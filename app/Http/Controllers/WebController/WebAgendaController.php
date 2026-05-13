<?php

namespace App\Http\Controllers\WebController;

use App\Charts\WebView\WebDatasetsChartAgenda;
use App\Charts\WebView\WebDatasetsLineChartAgenda;
use App\Http\Controllers\Controller;
use App\Models\Datasets;
use App\Models\Opd;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class WebAgendaController extends Controller
{
    // WebAgendaController.php
    public function index(Request $request)
    {
        // Validasi bulan dan tahun dari query string
        $validated = $request->validate([
            'month' => 'nullable|integer|min:0|max:11',        // Pastikan bulan antara 0 dan 11
            'year' => 'nullable|integer|min:1900|max:9999',   // Pastikan tahun valid
        ]);

        // Jika Anda menerima input dari FullCalendar (melalui AJAX atau URL Query):
        $year = $request->input('year');
        $month = $request->input('month'); // Ini adalah indeks 0-11 dari FullCalendar

        // Tentukan nilai default:
        if (empty($year) || empty($month)) {
            $now = Carbon::now();
            $year = $now->year;
            // Carbon::month mengembalikan 1-12 (Desember = 12).
            // FullCalendar/Kode Anda menggunakan 0-11, jadi kita harus menguranginya 1.
            $month = $now->month - 1; // Sekarang, $month = 11 (indeks Desember)
        }

        // Mengambil data berdasarkan bulan dan tahun yang dipilih
        $data = Datasets::selectRaw('DATE(created_at) as date, count(id) as count')
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month + 1)  // Menambahkan 1 karena MySQL bulan dimulai dari 1
            ->groupBy('date')
            ->get();

        // Mengambil data untuk menampilkan di tabel
        $getMonth = Datasets::whereYear('created_at', $year)
                            // ->whereMonth('created_at', $month + 1) // Menambahkan 1 karena bulan di MySQL mulai dari 1
            ->get();

        // Format data untuk kalender (events)
        $events = [];
        foreach ($data as $datum) {
            $events[] = [
                'title' => $datum->count.' Kegiatan',
                'start' => Carbon::parse($datum->date)->format('Y-m-d'), // Format tanggal yang sesuai
            ];
        }

        // Jika permintaan AJAX
        if ($request->ajax()) {
            $year = $request->input('year');
            $month = $request->input('month');

            $query = Datasets::whereYear('created_at', $year);
            if ($request->has('month') && $request->input('month') !== null) {
                $query->whereMonth('created_at', $month + 1);
            }

            $getMonth = $query->get();

            $data = [];
            foreach ($getMonth as $event) {
                // --- LOGIKA TAMBAHAN DISINI ---
                // Cari apakah dataset ini terdaftar di agenda
                $agenda = DB::table('tbl_agenda_datasets')
                    ->where('datasets_id', $event->id)
                    ->first();

                $data[] = [
                    'judul' => $event->judul,
                    'nama_opd' => $event->nama_opd,
                    'id' => $event->id,
                    'created_at' => $event->created_at->format('d-m-Y'),
                    'status' => $event->status,
                    // Tambahkan info agenda
                    'is_agenda' => $agenda ? true : false,
                    'agenda_id' => $agenda ? $agenda->id : null,
                    'agenda_status' => $agenda ? $agenda->status : null, // 0 atau 1
                ];
            }

            return response()->json(['data' => $data]);
        }

        $datasetCount = Datasets::count();

        // Ambil semua ID dataset yang ada di agenda
        $agendaIds = DB::table('tbl_agenda_datasets')->pluck('datasets_id');

        // Ambil data Judul dari tbl_datasets
        $jadwal_rilis = DB::table('tbl_datasets')
            ->whereIn('id', $agendaIds)
            ->get();

        // Ambil data rilis dan dikelompokkan berdasarkan datasets_id
        // Ini penting agar di Blade kita bisa memanggil $detail_agenda[$dataset_id]
        $detail_agenda = DB::table('tbl_agenda_datasets')
            ->get()
            ->groupBy('datasets_id');

        // dd($detail_agenda);

        return view('website-view.agenda.index', compact('events', 'getMonth', 'month', 'year', 'datasetCount', 'jadwal_rilis', 'detail_agenda'));
    }

    public function getEventDetails(Request $request)
    {
        $date = $request->date;
        $carbonDate = \Carbon\Carbon::parse($date);
        $year = $carbonDate->year;
        $month = $carbonDate->month;
        $day = $carbonDate->day;

        $monthNames = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
        ];
        $targetMonthName = $monthNames[$month];

        $events = DB::table('tbl_datasets as d')
            // PERBAIKAN: Join dengan kondisi tanggal yang ketat agar tidak looping
            ->leftJoin('tbl_agenda_datasets as ad', function ($join) use ($date, $year, $targetMonthName, $day) {
                $join->on('d.id', '=', 'ad.datasets_id')
                    ->where('ad.status', 1)
                    ->where(function ($q) use ($date, $year, $targetMonthName, $day) {
                        $q->where('ad.tanggal', 'LIKE', "%$date%")
                            ->orWhere(function ($sq) use ($year, $targetMonthName, $day) {
                                $sq->where('ad.tahun', $year)
                                    ->where('ad.bulan', $targetMonthName)
                                    ->where('ad.tanggal', $day);
                            });
                    });
            })
            // Hanya ambil data yang memang ada rilisnya di tanggal tersebut
            ->where(function ($query) use ($date) {
                $query->whereDate('d.created_at', $date)
                    ->orWhereNotNull('ad.id');
            })
            ->select(
                'd.id',
                'd.nama_opd',
                'd.status as display_status', // Ambil status asli (PENDING/PUBLIK)
                'd.created_at',
                // Gunakan COALESCE untuk memprioritaskan judul agenda
                DB::raw('COALESCE(ad.judul_rilis, d.judul) as display_judul'),
                'ad.id as agenda_id',
                DB::raw('IF(ad.id IS NOT NULL, 1, 0) as is_agenda')
            )
            // GroupBy ID agar tidak ada data ganda yang tampil di modal
            ->groupBy('d.id', 'd.nama_opd', 'd.status', 'd.created_at', 'ad.judul_rilis', 'd.judul', 'ad.id')
            ->orderBy('is_agenda', 'desc')
            ->get();

        return response()->json($events);
    }

    public function getEventsByYear(Request $request)
    {
        $validated = $request->validate([
            'year' => 'required|integer|min:1900|max:9999',
        ]);
        $year = $validated['year'];

        // Ambil data berdasarkan tahun
        $data = Datasets::selectRaw('YEAR(created_at) as year, count(id) as count')
            ->whereYear('created_at', $year)  // Mengambil data berdasarkan tahun
            ->groupBy('year')
            ->get();

        $events = [];
        foreach ($data as $d) {
            $events[] = [
                'title' => $d->count.' Kegiatan',
                'start' => \Carbon\Carbon::parse($d->year)->format('Y'),
            ];
        }

        return response()->json($events);
    }

    // PERBULAN
    public function getEventsByMonth(Request $request)
    {
        $year = $request->year;
        $month = (int) $request->month;

        $monthNames = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
        ];
        $targetMonthName = $monthNames[$month];
        $formattedMonth = str_pad($month, 2, '0', STR_PAD_LEFT);

        // Ambil data Agenda dengan status 1
        $agendaEvents = DB::table('tbl_agenda_datasets as ad')
            ->join('tbl_datasets as d', 'ad.datasets_id', '=', 'd.id')
            ->where('ad.status', 1)
            ->where(function ($q) use ($year, $formattedMonth, $targetMonthName) {
                $q->where('ad.tanggal', 'LIKE', "$year-$formattedMonth%")
                    ->orWhere(function ($sq) use ($year, $targetMonthName) {
                        $sq->where('ad.bulan', $targetMonthName)
                            ->where('ad.tahun', $year);
                    });
            })
            ->select(
                'd.id',
                // PERBAIKAN: Gunakan kolom 'tanggal' (angka 3) jika ad.tanggal standar tidak ada
                DB::raw("DATE(
                CASE 
                    WHEN ad.tanggal LIKE '$year-$formattedMonth-%' THEN ad.tanggal 
                    WHEN ad.tanggal REGEXP '^[0-9]+$' THEN CONCAT('$year-', '$formattedMonth-', LPAD(ad.tanggal, 2, '0'))
                    ELSE CONCAT('$year-', '$formattedMonth', '-01') 
                END
            ) as start")
            )
            ->get();

        $excludeIds = $agendaEvents->pluck('id')->toArray();

        // Ambil data Dataset Umum
        $datasetEvents = DB::table('tbl_datasets as d')
            ->whereYear('d.created_at', $year)
            ->whereMonth('d.created_at', $month)
            ->whereNotIn('d.id', $excludeIds)
            ->select(
                'd.id',
                DB::raw('DATE(d.created_at) as start')
            )
            ->get();

        $allEvents = $agendaEvents->concat($datasetEvents);

        $finalData = $allEvents->groupBy('start')->map(function ($group, $date) {
            return [
                'start' => $date,
                'total' => $group->count(),
                'title' => $group->count().' Rilis Data',
            ];
        })->values();

        return response()->json($finalData);
    }

    public function show(WebDatasetsLineChartAgenda $chart_line, WebDatasetsChartAgenda $chart_bar, Request $request, string $id, string $slug)
    {
        // 1. Ambil data rilis dari agenda
        $agenda = DB::table('tbl_agenda_datasets')->where('id', $id)->first();
        if (! $agenda) {
            return redirect('/')->with('error', 'Agenda tidak ditemukan.');
        }

        // 2. Metadata berdasarkan agenda_datasets_id
        $metadata = DB::table('tbl_metadata')->where('agenda_datasets_id', $id)->first();
        $datasets = Datasets::where('id', $agenda->datasets_id)->firstOrFail();

        // 3. Struktur kolom dari db_datasets milik agenda
        $nama_tabel_dinamis = $agenda->db_datasets;
        $table = Schema::hasTable($nama_tabel_dinamis) ? Schema::getColumnListing($nama_tabel_dinamis) : [];
        $jumlah_kolom = count($table);

        // 4. Proteksi Indeks Grafik (Mencegah Undefined array key 4)
        $index_x = $request->input('index_x') ?? (($jumlah_kolom > 0) ? $jumlah_kolom - 1 : 0);
        $index_y = $request->input('index_y') ?? 0;
        if ($index_x >= $jumlah_kolom) {
            $index_x = 0;
        }

        // 5. Data Pendukung & Maps (MEMPERBAIKI image_8ab235.jpg)
        $opd = Opd::where('nama_opd', $datasets->nama_opd)->first();
        $user = User::where('id', $datasets->diupload_oleh)->first('name');
        $viewer = DB::table('tbl_datasets_seen')->where('id_datasets', $datasets->id)->count();
        $tags = explode(',', $datasets->tags);

        // Pastikan variabel ini ada untuk dikirim ke view
        $maps_data = $this->data_maps($nama_tabel_dinamis, $request->input('value_peta') ?? 'id');

        // 6. Visualisasi
        $chart = ($request->input('grafik') == 'line')
                 ? $chart_line->build($agenda->id, $index_x, $index_y)
                 : $chart_bar->build($agenda->id, $index_x, $index_y);

        return view('website-view.agenda.show', compact('chart', 'opd', 'maps_data', 'table', 'datasets', 'user', 'viewer', 'metadata', 'tags', 'agenda', 'index_x', 'index_y'));
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

    public function fetchTableData(string $id, $bearer)
    {
        if ($bearer !== env('BEARER_TOKEN')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $agenda = DB::table('tbl_agenda_datasets')->where('id', $id)->first();
        if (! $agenda || ! Schema::hasTable($agenda->db_datasets)) {
            return response()->json(['data' => []]);
        }

        $db_name = $agenda->db_datasets;
        $query = DB::table($db_name);

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('nama_kabupaten_kota', function ($row) {
                $mapping = [
                    '1501' => 'KERINCI', '1502' => 'MERANGIN', '1503' => 'SAROLANGUN',
                    '1504' => 'BATANGHARI', '1505' => 'MUARO JAMBI', '1506' => 'TANJUNG JABUNG BARAT',
                    '1507' => 'TANJUNG JABUNG TIMUR', '1508' => 'BUNGO', '1509' => 'TEBO',
                    '1571' => 'KOTA JAMBI', '1572' => 'KOTA SUNGAI PENUH',
                ];

                return $mapping[$row->kode_kabupaten_kota] ?? ($row->kode_kabupaten_kota ?? '-');
            })
            /** * FIX: Custom Filter untuk mencegah error "Column not found" saat search
             */
            ->filter(function ($instance) use ($db_name) {
                $request = request();
                if ($request->has('search') && ! empty($request->get('search')['value'])) {
                    $keyword = strtolower($request->get('search')['value']);

                    // Ambil daftar kolom asli yang ADA di database
                    $dbColumns = Schema::getColumnListing($db_name);

                    $instance->where(function ($q) use ($keyword, $dbColumns) {
                        foreach ($dbColumns as $column) {
                            // Lewati kolom-kolom yang tidak relevan untuk teks (seperti id/timestamps)
                            if (in_array($column, ['id', 'created_at', 'updated_at'])) {
                                continue;
                            }

                            // Gunakan orWhereRaw agar lebih fleksibel dengan database engine
                            $q->orWhere($column, 'LIKE', "%$keyword%");
                        }
                    });
                }
            })
            ->make(true);
    }

    public function data_maps($database, $value)
    {
        if (! Schema::hasTable($database)) {
            return [];
        }
        $mapping = [
            '1501' => 'KERINCI', '1502' => 'MERANGIN', '1503' => 'SAROLANGUN',
            '1504' => 'BATANGHARI', '1505' => 'MUARO JAMBI', '1506' => 'TANJUNG JABUNG BARAT',
            '1507' => 'TANJUNG JABUNG TIMUR', '1508' => 'BUNGO', '1509' => 'TEBO',
            '1571' => 'KOTA JAMBI', '1572' => 'KOTA SUNGAI PENUH',
        ];

        $output = [];
        $data = DB::table($database)
            ->select('kode_kabupaten_kota', DB::raw("SUM(CAST($value AS DECIMAL(10,2))) as total"))
            ->groupBy('kode_kabupaten_kota')->get();

        foreach ($data as $item) {
            $output[] = [
                'nama_kabupaten' => $mapping[$item->kode_kabupaten_kota] ?? $item->kode_kabupaten_kota,
                'value' => $item->total,
            ];
        }

        return $output;
    }

    public function downloadExcel(string $id)
    {
        // Cari agenda berdasarkan ID
        $agenda = DB::table('tbl_agenda_datasets')->where('id', $id)->first();

        if (! $agenda || ! Schema::hasTable($agenda->db_datasets)) {
            return back()->with('error', 'Data dataset tidak ditemukan.');
        }

        // Ambil info pendukung dari tabel datasets asli jika diperlukan (opsional)
        $datasets = DB::table('tbl_datasets')->where('id', $agenda->datasets_id)->first();
        $user = DB::table('users')->where('id', $datasets->diupload_oleh)->first(['name']);

        // Ambil struktur kolom dan data dari tabel dinamis
        $table = Schema::getColumnListing($agenda->db_datasets);
        $temp = DB::table($agenda->db_datasets)->get();
        $data = json_decode(json_encode($temp), true);

        // Update hitungan unduhan (gunakan ID datasets asli)
        $this->update_unduhan_agenda($agenda->id);

        return view('website-view.datasets.to-excel', compact('table', 'data', 'datasets', 'user', 'agenda'));
    }

    public function downloadCsv(string $id)
    {
        // Cari agenda berdasarkan ID
        $agenda = DB::table('tbl_agenda_datasets')->where('id', $id)->first();

        if (! $agenda || ! Schema::hasTable($agenda->db_datasets)) {
            return back()->with('error', 'Dataset tidak ditemukan.');
        }

        $columns = Schema::getColumnListing($agenda->db_datasets);
        $data = DB::table($agenda->db_datasets)->get();

        // Gunakan output buffer untuk menangani memori jika data ribuan
        $callback = function () use ($data, $columns) {
            $file = fopen('php://output', 'w');

            // Header CSV
            fputcsv($file, $columns);

            // Baris Data
            foreach ($data as $row) {
                $rowData = [];
                foreach ($columns as $column) {
                    $rowData[] = $row->{$column};
                }
                fputcsv($file, $rowData);
            }
            fclose($file);
        };

        // Update unduhan
        $this->update_unduhan_agenda($agenda->id);

        $fileName = Str::slug($agenda->judul_rilis, '_').'.csv';

        return response()->stream($callback, 200, [
            'Content-type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=$fileName",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ]);
    }

    private function update_unduhan_agenda($agenda_id)
    {
        // Mengupdate kolom jumlah_unduhan di tabel tbl_agenda_datasets
        return DB::table('tbl_agenda_datasets')
            ->where('id', $agenda_id)
            ->increment('jumlah_unduhan');
    }
}
