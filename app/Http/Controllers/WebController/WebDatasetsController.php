<?php

namespace App\Http\Controllers\WebController;

use App\Charts\WebView\WebDatasetsChart;
use App\Charts\WebView\WebDatasetsLineChart;
use App\Http\Controllers\Controller;
use App\Models\Datasets;
use App\Models\Opd;
use App\Models\Sektor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class WebDatasetsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $opd = Opd::all();
        $sektor = Sektor::all();
        $builder = Datasets::query();
        if ($request->input('judul')) {
            $queryString = $request->input('judul');
            $builder->where('judul', 'LIKE', "%$queryString%");
        }
        if ($request->input('urut')) {
            $queryString = $request->input('urut');
            if ($queryString == 'terbaru') {
                $builder->orderBy('updated_at', 'DESC');
            } elseif ($queryString == 'abjad') {
                $builder->orderBy('judul');
            } elseif ($queryString == 'terpopuler') {
                $builder->orderBy('jumlah_unduhan', 'DESC');
            }
        }
        if ($request->input('opd')) {
            $queryString = $request->input('opd');
            $builder->where('nama_opd', $queryString);
        }
        if ($request->input('sektor')) {
            $queryString = $request->input('sektor');
            $builder->where('sektor', $queryString);
        }
        if ($request->input('record')) {
            $datasets = $builder->where('sifat_datasets', 'PUBLIK')->where('status', 'APPROVED')->orderBy('updated_at', 'DESC')->paginate($request->input('record'))->withQueryString();
        } else {
            $datasets = $builder->where('sifat_datasets', 'PUBLIK')->where('status', 'APPROVED')->orderBy('updated_at', 'DESC')->paginate(20)->withQueryString();
        }
        $seen = DB::table('tbl_datasets_seen')->get();

        // dd($builder);
        return view('website-view.datasets.index', compact('datasets', 'opd', 'seen', 'sektor'));
    }

    public function ulasan(Request $request, $id_datasets)
    {
        $request->validate([
            'question1' => 'required|max:255',
            'question2' => 'required|max:255',
            'saran' => 'required|max:255',
            'g-recaptcha-response' => 'required|recaptcha',
        ]);
        if (! in_array($request->question1, ['Sangat Merekomendasikan', 'Cukup Merekomendasikan', 'Tidak Merekomendasikan'])) {
            return redirect()->back()->with('danger', 'Ulasan anda terdapat kesalahan!');
        }

        if (! in_array($request->question2, ['Sangat Membantu', 'Cukup Membantu', 'Tidak Membantu'])) {
            return redirect()->back()->with('danger', 'Ulasan anda terdapat kesalahan!');
        }

        DB::table('tbl_feedback')->insert([
            'id_datasets' => $id_datasets,
            'question1' => $request->question1,
            'question2' => $request->question2,
            'saran' => $request->saran,
        ]);

        return redirect()->back()->with('success', 'Terimakasih atas Ulasan anda sangat berarti bagi kami :)');
    }

    public function show(WebDatasetsLineChart $chart_line, WebDatasetsChart $chart_bar, Request $request, string $id)
    {
        // $datasets = Datasets::where('id', $id)->where('sifat_datasets','PUBLIK')->where('status','APPROVED')->first();
        $datasets = Datasets::where('id', $id)
            ->where('sifat_datasets', 'PUBLIK')
            ->where('status', 'APPROVED')
            ->orderByDesc('tahun_datasets')
            ->first();
        if (! $datasets) {
            return redirect('/')->with('error', 'Dataset not found.');
        }
        $opd = Opd::where('nama_opd', $datasets->nama_opd)->first();
        $metadata = DB::table('tbl_metadata')->where('id_datasets', $id)->first();
        $user = User::where('id', $datasets->diupload_oleh)->first('name');
        $table = Schema::getColumnListing($datasets->db_datasets);
        $ips = $this->getClientIps();
        $viewer = DB::table('tbl_datasets_seen')->where('id_datasets', $id)->count();
        $tags = explode(',', $datasets->tags);
        $seen = DB::table('tbl_datasets_seen')->where('id_datasets', $id)->where('ips', $ips)->first();
        $value_peta = $request->input('value_peta') ?? 'id';
        if (! in_array($value_peta, $table)) {
            return redirect('/')->with('error', 'Invalid parameter.');
        }
        $maps_data = $this->data_maps($datasets->db_datasets, $request->input('value_peta') ?? 'id');
        if ($seen == null) {
            DB::table('tbl_datasets_seen')->insert([
                'id_datasets' => $id,
                'ips' => $ips,
            ]);
        }
        if ($request->input('index_x') && $request->input('index_y')) {
            $index_x = $request->input('index_x');
            $index_y = $request->input('index_y');
        } else {
            $index_x = count($table) - 1;
            $index_y = 0;
        }

        if ($request->input('grafik') == 'line') {
            return view('website-view.datasets.show', ['chart' => $chart_line->build($id, $index_x, $index_y)], compact('opd', 'maps_data', 'table', 'datasets', 'user', 'viewer', 'metadata', 'tags'));
        } else {
            $grafik = 'bar';

            return view('website-view.datasets.show', ['chart' => $chart_bar->build($id, $index_x, $index_y)], compact('opd', 'maps_data', 'table', 'datasets', 'user', 'viewer', 'metadata', 'tags'));
        }
    }

    public function data_maps($database, $value)
    {
        $table = Schema::getColumnListing($database);
        $output = [];

        if (in_array('kode_kabupaten_kota', $table)) {
            $sample = DB::table($database)
                ->whereNotNull($value)
                ->value($value);

            if ($sample !== null) {
                $aggregateFunction = is_numeric($sample) ? 'SUM' : 'COUNT';
                $data = DB::table($database)
                    ->select(
                        'kode_kabupaten_kota as kode_kabupaten',
                        DB::raw("$aggregateFunction($value) as value")
                    )
                    ->groupBy('kode_kabupaten_kota')
                    ->get();
                foreach ($data as $item) {
                    $output[] = [
                        'kode_kabupaten' => $item->kode_kabupaten,
                        'nama_kabupaten' => WilayahController::wilayah($item->kode_kabupaten ?? '-')->nama,
                        'value' => $item->value,
                    ];
                }
            }
        }

        return response()->json($output);
    }

    public function fetchTableData(string $id, $bearer)
    {
        $bearerToken = 'Bearer '.$bearer;
        $validToken = 'Bearer '.env('BEARER_TOKEN');
        if (! $bearerToken || $bearerToken != $validToken) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        if (Auth::user()) {
            $datasets = Datasets::where('id', $id)
                ->firstOrFail();
        } else {
            $datasets = Datasets::where('id', $id)
                ->where('status', 'APPROVED')
                ->where('sifat_datasets', 'PUBLIK')
                ->firstOrFail();
        }
        if (! $datasets || ! Schema::hasTable($datasets->db_datasets)) {
            return response()->json(['error' => 'Dataset atau tabel tidak ditemukan.'], 404);
        }

        $tableName = $datasets->db_datasets;

        // Inisialisasi query builder
        $query = DB::table($tableName);

        // Langkah 1: Periksa apakah kolom 'tahun' ada di tabel
        $kolomTahunAda = Schema::hasColumn($tableName, 'tahun');

        $gunakanOrderTahun = false;

        if ($kolomTahunAda) {
            // Langkah 2: Jika kolom 'tahun' ada, periksa apakah ada data non-NULL di dalamnya
            $adaDataDiKolomTahun = DB::table($tableName)
                ->whereNotNull('tahun')
                ->exists();

            if ($adaDataDiKolomTahun) {
                $gunakanOrderTahun = true;
            }
        }

        // Langkah 3: Terapkan pengurutan berdasarkan kondisi
        if ($gunakanOrderTahun) {
            // Jika kolom 'tahun' ada DAN memiliki data, urutkan berdasarkan 'tahun'
            $query->orderBy('tahun', 'desc');
            Log::info("Mengurutkan berdasarkan 'tahun' (DESC) karena kolom ada dan memiliki data.");
        } else {
            // Jika kolom 'tahun' tidak ada ATAU tidak memiliki data, urutkan berdasarkan 'id'
            $query->orderBy('id', 'desc');
            Log::info("Mengurutkan berdasarkan 'id' (DESC) karena kolom 'tahun' tidak ada atau tidak memiliki data.");
        }

        // Lanjutkan dengan mengambil data
        $debugData = $query->get();

        Log::info('Data fetched:', $debugData->toArray());

        return DataTables::of($query)
            ->addColumn('nama_kabupaten_kota', function ($row) {
                $wilayah = WilayahController::wilayah($row->kode_kabupaten_kota ?? '-');

                return $wilayah->nama ?? '-';
            })
            ->addColumn('nama_kecamatan', function ($row) {
                $wilayah = WilayahController::wilayah($row->kode_kecamatan ?? '-');

                return $wilayah->nama ?? '-';
            })
            ->addColumn('nama_kelurahan_desa', function ($row) {
                $wilayah = WilayahController::wilayah($row->kode_kelurahan_desa ?? '-');

                return $wilayah->nama ?? '-';
            })
            ->make(true);
    }

    // public function fetchTableData(string $id, $bearer)
    // {
    //     $bearerToken = 'Bearer '. $bearer;
    //     $validToken = 'Bearer ' . env('BEARER_TOKEN');
    //     if (!$bearerToken || $bearerToken != $validToken) {
    //         return response()->json(['error' => 'Unauthorized'], 401);
    //     }
    //     if(Auth::user()){
    //         $datasets = Datasets::where('id', $id)
    //         ->firstOrFail();
    //     }else{
    //         $datasets = Datasets::where('id', $id)
    //         ->where('status', 'APPROVED')
    //         ->where('sifat_datasets', 'PUBLIK')
    //         ->firstOrFail();
    //     }
    //     if (!$datasets || !Schema::hasTable($datasets->db_datasets)) {
    //         return response()->json(['error' => 'Dataset atau tabel tidak ditemukan.'], 404);
    //     }

    //     $query = DB::table($datasets->db_datasets);
    //     $debugData = $query->take(10)->get();
    //     Log::info('Data fetched:', $debugData->toArray());

    //     // $query = DB::table($datasets->db_datasets);
    //     // $query->orderBy('tahun', 'desc');
    //     // $debugData = $query->get(); // Will fetch all data, sorted by 'tahun'
    //     // Log::info('Data fetched:', $debugData->toArray());

    //     return DataTables::of($query)
    //         ->addColumn('nama_kabupaten_kota', function ($row) {
    //             $wilayah = WilayahController::wilayah($row->kode_kabupaten_kota ?? "-");
    //             return $wilayah->nama ?? '-';
    //         })
    //         ->addColumn('nama_kecamatan', function ($row) {
    //             $wilayah = WilayahController::wilayah($row->kode_kecamatan ?? '-');
    //             return $wilayah->nama ?? '-';
    //         })
    //         ->addColumn('nama_kelurahan_desa', function ($row) {
    //             $wilayah = WilayahController::wilayah($row->kode_kelurahan_desa ?? '-');
    //             return $wilayah->nama ?? '-';
    //         })
    //         ->make(true);
    // }

    public function download(string $id)
    {
        $datasets = Datasets::where('id', $id)->where('sifat_datasets', 'PUBLIK')->where('status', 'APPROVED')->first();
        $user = User::where('id', $datasets->diupload_oleh)->first('name');
        $table = Schema::getColumnListing($datasets->db_datasets); // users table
        $temp = DB::table($datasets->db_datasets)->get();
        $data = json_decode(json_encode($temp), true);
        $this->update_unduhan($id);

        return view('website-view.datasets.to-excel', compact('table', 'data', 'datasets', 'user'));
    }

    public function downloadCsv(string $id)
    {
        $datasets = Datasets::where('id', $id)
            ->where('sifat_datasets', 'PUBLIK')
            ->where('status', 'APPROVED')
            ->first();

        if (! $datasets) {
            return back()->with('error', 'Dataset not found.');
        }

        $columns = Schema::getColumnListing($datasets->db_datasets);
        $data = DB::table($datasets->db_datasets)->get();
        $csvData = '';

        // Generate CSV headers
        $csvData .= implode(',', $columns)."\n";

        // Generate CSV data rows
        foreach ($data as $row) {
            $rowData = [];
            foreach ($columns as $column) {
                // Ensure proper CSV formatting (escaping quotes, etc.)
                $rowData[] = '"'.str_replace('"', '""', $row->$column).'"';
            }
            $csvData .= implode(',', $rowData)."\n";
        }

        // Update download count
        $this->update_unduhan($id);

        // Set the file name
        $fileName = Str::slug($datasets->nama_datasets, '_').'.csv';

        // Return CSV data as a downloadable file
        return response($csvData)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="'.$fileName.'.csv"');
    }

    public function role_download(string $id)
    {
        $datasets = Datasets::where('id', $id)->where('sifat_datasets', 'PUBLIK')->first();
        $user = User::where('id', $datasets->diupload_oleh)->first('name');
        $table = Schema::getColumnListing($datasets->db_datasets); // users table
        $temp = DB::table($datasets->db_datasets)->get();
        $data = json_decode(json_encode($temp), true);
        $this->update_unduhan($id);

        return view('super-admin.datasets.format_download', compact('table', 'data', 'datasets', 'user'));
    }

    public function share_download(string $id)
    {
        $datasets = Datasets::where('id', $id)->where('sifat_datasets', 'KECUALI')->first();
        $user = User::where('id', $datasets->diupload_oleh)->first('name');
        $table = Schema::getColumnListing($datasets->db_datasets); // users table
        $temp = DB::table($datasets->db_datasets)->get();
        $data = json_decode(json_encode($temp), true);
        $this->update_unduhan($id);

        return view('super-admin.datasets.format_download', compact('table', 'data', 'datasets', 'user'));
    }

    public function getDownloadMetadata($id)
    {
        $datasets = Datasets::find($id);
        $myFile = public_path('assets/metadata/'.$datasets->metadata);

        return response()->download($myFile);
    }

    public function update_unduhan($id)
    {
        $ips = $this->getClientIps();

        // 1. Cek apakah IP ini sudah pernah download dataset ini dalam 1 jam terakhir
        $isBotOrSpam = DB::table('tbl_datasets_unduh_log')
            ->where('id_datasets', $id)
            ->where('ips', $ips)
            ->where('created_at', '>', now()->subHours(1))
            ->exists();

        if (! $isBotOrSpam) {
            // 2. Jika belum ada (atau sudah lewat 1 jam), baru tambah angka unduhan
            DB::table('tbl_datasets')->where('id', $id)->increment('jumlah_unduhan');

            // 3. Catat log barunya
            DB::table('tbl_datasets_unduh_log')->insert([
                'id_datasets' => $id,
                'ips' => $ips,
                'created_at' => now(),
            ]);
        }
    }

    public static function getSektor($id)
    {
        $sektor = Sektor::where('id', $id)->first();

        return $sektor->nama_sektor ?? 'null';
    }

    public static function getClientIps()
    {
        foreach (['HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR'] as $key) {
            if (array_key_exists($key, $_SERVER) === true) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    $ip = trim($ip);
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                        return $ip;
                    }
                }
            }
        }

        return request()->ip();
    }
}
