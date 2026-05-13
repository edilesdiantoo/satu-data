<?php

namespace App\Http\Controllers\OPD;

// Matikan Comment dibawah ini Jika Di Push Ke dalam Server :)
define('STDIN', fopen('php://stdin', 'r'));

use App\Http\Controllers\Admin\AktivitasController;
use App\Http\Controllers\Controller;
use App\Models\Datasets;
use App\Models\Opd;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class OpdDatasetsShareController extends Controller
{
    private $kolom_setelah;

    private $nama_kolom_delete;

    public function __construct()
    {
        $this->middleware('checkRole:opd');
    }

    public function index()
    {
        $datasets = Datasets::where('diupload_oleh', '!=', Auth::user()->id)->where('sifat_datasets', 'DIBAGIKAN')->latest()->get();
        $users = User::where('id', Auth::user()->id)->get();
        $title = 'Hapus Datasets !';
        $text = 'Kamu yakin ingin Menghapus Datasets ini?';
        confirmDelete($title, $text);

        return view('opd.datasets-sharing.index', compact('datasets', 'users'));
    }

    public static function check_private($id_datasets)
    {
        // Fetch the private dataset entry by its ID
        $private = DB::table('tbl_datasets_private')->where('id_datasets', $id_datasets)->first();

        if ($private) {
            // Decode the id_instansi column into an array
            $data = json_decode($private->id_instansi);

            // Check if the logged-in user's id_opd exists in the id_instansi array
            if (in_array(Auth::user()->id_opd, $data)) {
                return true; // The dataset is accessible
            }
        }

        return false; // The dataset is not accessible
    }

    public static function getName($id)
    {
        $user = User::where('id', $id)->first();

        return $user->name;
    }

    public function create()
    {
        $opd = Opd::all();

        return view('opd.datasets-sharing.tambah', compact('opd'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (count($request->nama_kolom) !== count(array_unique($request->nama_kolom))) {
            return redirect()->back()->with('toast_error', 'Nama Kolom Tidak Boleh Sama !');
        }
        $request->validate([
            'judul' => 'required|max:255',
            'nama_opd' => 'required|max:255',
            'tahun_datasets' => 'required',
            'metadata' => 'required|mimes:pdf|max:5048',
            'deskripsi' => 'required',
            'tags' => 'required',
            'sifat_datasets' => 'required|max:255',
            'nama_kolom' => 'required|max:255',
            'sektor' => 'required|max:255',
            'pengukuran_datasets' => 'required|max:255',
            'tingkat_penyajian_datasets' => 'required|max:255',
            'cakupan_datasets' => 'required|max:255',
            'bidang' => 'required|max:255',
            'penanggung_jawab' => 'required|max:255',
            'kontak_produsen' => 'required|max:255',
            'kode_indikator' => 'required|max:255',
            'bidang_urusan' => 'required|max:255',
            'satuan_datasets' => 'required|max:255',
            'frekuensi_datasets' => 'required|max:255',
            'dimensi_datasets' => 'required|max:255',
        ]);
        if ($request->sifat_datasets == 'KECUALI') {
            $request->validate([
                'id_instansi' => 'required',

            ]);
        }
        $tags = explode(',', $request->tags);
        $db_name = Str::random(20);
        $tables = DB::select('SHOW TABLES');
        foreach ($tables as $p) {
            if ($p->Tables_in_jdac === $db_name) {
                $data = true;
            } else {
                $data = false;
            }
        }
        if ($data == true) {
            return redirect()->back()->with('toast_error', 'Nama Database Sudah dipakai harap ganti nama DB Datasets !');
        }
        $request->nama_kolom = str_replace(' ', '_', $request->nama_kolom);
        $request->nama_kolom = array_map('strtolower', $request->nama_kolom);
        $newtableschema = [
            'tablename' => $db_name,
            'colnames' => $request->nama_kolom,
        ];
        Schema::create($newtableschema['tablename'], function ($table) use ($newtableschema) {
            $table->increments('id')->unique(); // primary key
            foreach ($newtableschema['colnames'] as $col) {
                $table->text($col);
            }
        });
        Artisan::call('migrate');

        $filename = null;

        if (Schema::hasTable($db_name)) {
            if ($request->metadata != null) {
                $filename = time().'.'.$request->metadata->extension();
                $request->metadata->move(public_path('assets/metadata'), $filename);
            }
            $datasets = Datasets::create([
                'judul' => $request->judul,
                'nama_opd' => $request->nama_opd,
                'diupload_oleh' => Auth::user()->id,
                'tahun_datasets' => $request->tahun_datasets,
                'metadata' => $filename,
                'sektor' => $request->sektor,
                'deskripsi' => $request->deskripsi,
                'tags' => $request->tags,
                'sifat_datasets' => $request->sifat_datasets,
                'db_datasets' => $db_name,
                'status' => 'PENDING',
                'jumlah_unduhan' => 0,
            ]);
        } else {
            return redirect()->back()->with('toast_error', 'Terdapat Kesalahan ! Harap Periksa Nama DB Anda atau Ganti !');
        }
        DB::table('tbl_metadata')->insert([
            'id_datasets' => $datasets->id,
            'pengukuran_datasets' => $request->pengukuran_datasets,
            'tingkat_penyajian_datasets' => $request->tingkat_penyajian_datasets,
            'cakupan_datasets' => $request->cakupan_datasets,
            'bidang' => $request->bidang,
            'penanggung_jawab' => $request->penanggung_jawab,
            'kontak_produsen' => $request->kontak_produsen,
            'kode_indikator' => $request->kode_indikator,
            'bidang_urusan' => $request->bidang_urusan,
            'satuan_datasets' => $request->satuan_datasets,
            'frekuensi_datasets' => $request->frekuensi_datasets,
            'dimensi_datasets' => $request->dimensi_datasets,
        ]);
        if ($request->sifat_datasets == 'KECUALI') {
            $instansi = json_encode($request->id_instansi);
            DB::table('tbl_datasets_private')->insert([
                'id_datasets' => $datasets->id,
                'id_instansi' => $instansi,
            ]);
        }
        (new AktivitasController)->store(Auth::user()->id, 'Menambahkan Datasets dengan Nama '.$request->judul, 'D1', Auth::user()->role);

        return redirect()->route('opddatasetsshare.index')->with('success', 'Berhasil Menambahkan Data Baru !');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $datasets = Datasets::find($id);
        // if ($this->check_private($datasets->id)){
        //     return redirect()->route('opddatasetsshare.index')->with('toast_error', 'Terdapat Kesalahan !');
        // }
        if ($datasets->sifat_datasets != 'DIBAGIKAN') {
            return redirect()->route('opddatasetsshare.index')->with('toast_error', 'Terdapat Kesalahan !');
        }
        $table = Schema::getColumnListing($datasets->db_datasets);
        $temp = DB::table($datasets->db_datasets)->get();
        $data = json_decode(json_encode($temp), true);
        $nama_table = $datasets->db_datasets;

        return view('opd.datasets-sharing.show', compact('table', 'data', 'datasets', 'nama_table'));
    }

    public function tambah_kolom(Request $request, $id)
    {
        $request->validate([
            'nama_kolom' => 'required|max:100',
            'kolom_setelah' => 'required|max:255',
        ]);
        $datasets = Datasets::find($id);
        if ($this->check_private($datasets->id)) {
            return redirect()->back()->with('toast_error', 'Terdapat Kesalahan !');
        }
        if (Schema::hasColumn($datasets->db_datasets, $request->nama_kolom)) {
            return redirect()->route('opddatasetsshare.show', $id)->with('toast_error', 'Nama Kolom Sudah ada !');
        } else {
            $newColumnType = 'string';
            $newColumnName = strtolower($request->nama_kolom);
            $newColumnName = str_replace(' ', '_', $newColumnName);
            $this->kolom_setelah = $request->kolom_setelah;
            Schema::table($datasets->db_datasets, function (Blueprint $table) use ($newColumnType, $newColumnName) {
                $table->$newColumnType($newColumnName)->after($this->kolom_setelah);
            });

            return redirect()->route('opddatasetsshare.show', $id)->with('success', 'Nama Kolom Berhasil ditambahkan !');
        }
    }

    public function edit_nama_kolom(Request $request, $id)
    {
        $request->validate([
            'rename' => 'required|max:100',
            'nama_kolom' => 'required|max:100',
        ]);
        $request->nama_kolom = str_replace(' ', '_', $request->nama_kolom);
        $request->nama_kolom = strtolower($request->nama_kolom);
        $datasets = Datasets::find($id);
        if ($this->check_private($datasets->id)) {
            return redirect()->back()->with('toast_error', 'Terdapat Kesalahan !');
        }
        if ($request->rename == 'id') {
            return redirect()->route('opddatasetsshare.show', $id)->with('toast_error', 'Nama Kolom Ini Tidak Boleh diubah !');
        } else {
            if (Schema::hasColumn($datasets->db_datasets, $request->nama_kolom)) {
                return redirect()->route('opddatasetsshare.show', $id)->with('toast_error', 'Nama Kolom Sudah ada !');
            }
            if (Schema::hasColumn($datasets->db_datasets, $request->rename)) {
                DB::statement("ALTER TABLE `$datasets->db_datasets` CHANGE `$request->rename` `$request->nama_kolom` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL");

                return redirect()->route('opddatasetsshare.show', $id)->with('success', 'Nama Kolom Berhasil diubah !');
            } else {
                return redirect()->route('opddatasetsshare.show', $id)->with('toast_error', 'Nama Kolom Ini Tidak ada !');
            }
        }
    }

    public function delete_kolom(Request $request, $id)
    {
        $request->validate([
            'nama_kolom' => 'required|max:100',
        ]);
        if ($request->nama_kolom == 'id') {
            return redirect()->route('opddatasetsshare.show', $id)->with('toast_error', 'Nama Kolom Ini Tidak Boleh dihapus !');
        }
        $datasets = Datasets::find($id);
        if ($this->check_private($datasets->id)) {
            return redirect()->back()->with('toast_error', 'Terdapat Kesalahan !');
        }
        $this->nama_kolom_delete = $request->nama_kolom;
        if (Schema::hasColumn($datasets->db_datasets, $request->nama_kolom)) {
            Schema::table($datasets->db_datasets, function (Blueprint $table) {
                $table->dropColumn($this->nama_kolom_delete);
            });

            return redirect()->route('opddatasetsshare.show', $id)->with('success', 'Nama Kolom Berhasil Dihapus !');
        } else {
            return redirect()->route('opddatasetsshare.show', $id)->with('toast_error', 'Nama Kolom Tidak ada !');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $datasets = Datasets::where('id', $id)->first();
        if ($this->check_private($datasets->id)) {
            return redirect()->back()->with('toast_error', 'Terdapat Kesalahan !');
        }
        $metadata = DB::table('tbl_metadata')->where('id_datasets', $datasets->id)->first();
        $opd = Opd::all();
        $users = User::where('id', $datasets->diupload_oleh)->first();

        return view('opd.datasets-sharing.edit', compact('datasets', 'opd', 'users', 'metadata'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'judul' => 'required',
            'nama_opd' => 'required',
            'tahun_datasets' => 'required',
            'metadata' => 'mimes:pdf|max:5048',
            'deskripsi' => 'required',
            'tags' => 'required',
            'sifat_datasets' => 'required',
            'sektor' => 'required|max:255',
            'pengukuran_datasets' => 'required|max:255',
            'tingkat_penyajian_datasets' => 'required|max:255',
            'cakupan_datasets' => 'required|max:255',
            'bidang' => 'required|max:255',
            'penanggung_jawab' => 'required|max:255',
            'kontak_produsen' => 'required|max:255',
            'kode_indikator' => 'required|max:255',
            'bidang_urusan' => 'required|max:255',
            'satuan_datasets' => 'required|max:255',
            'frekuensi_datasets' => 'required|max:255',
            'dimensi_datasets' => 'required|max:255',
        ]);
        if ($request->sifat_datasets == 'KECUALI') {
            $request->validate([
                'id_instansi' => 'required',

            ]);
        }
        $datasets = Datasets::find($id);
        if ($this->check_private($datasets->id)) {
            return redirect()->back()->with('toast_error', 'Terdapat Kesalahan !');
        }
        $filename = $datasets->metadata;
        if ($request->metadata != null) {
            $file_path = public_path('assets/metadata/'.$filename);
            if (File::exists($file_path)) {
                File::delete($file_path);
            }
            $filename = time().'.'.$request->metadata->extension();
            $request->metadata->move(public_path('assets/metadata'), $filename);
        }
        Datasets::where('id', $id)->update([
            'judul' => $request->judul,
            'nama_opd' => $request->nama_opd,
            'sektor' => $request->sektor,
            'tahun_datasets' => $request->tahun_datasets,
            'metadata' => $filename,
            'deskripsi' => $request->deskripsi,
            'tags' => $request->tags,
            'sifat_datasets' => $request->sifat_datasets,
        ]);
        DB::table('tbl_metadata')->where('id_datasets', $id)->updateOrInsert([
            'id_datasets' => $datasets->id], [
                'pengukuran_datasets' => $request->pengukuran_datasets,
                'tingkat_penyajian_datasets' => $request->tingkat_penyajian_datasets,
                'cakupan_datasets' => $request->cakupan_datasets,
                'bidang' => $request->bidang,
                'penanggung_jawab' => $request->penanggung_jawab,
                'kontak_produsen' => $request->kontak_produsen,
                'kode_indikator' => $request->kode_indikator,
                'bidang_urusan' => $request->bidang_urusan,
                'satuan_datasets' => $request->satuan_datasets,
                'frekuensi_datasets' => $request->frekuensi_datasets,
                'dimensi_datasets' => $request->dimensi_datasets,
            ]);
        if ($request->sifat_datasets == 'KECUALI') {
            $instansi = json_encode($request->id_instansi);
            $data_privat = DB::table('tbl_datasets_private')->where('id_datasets', $datasets->id)->update([
                'id_datasets' => $datasets->id,
                'id_instansi' => $instansi,
            ]);
            if (! $data_privat) {
                $data_privat = DB::table('tbl_datasets_private')->insert([
                    'id_datasets' => $datasets->id,
                    'id_instansi' => $instansi,
                ]);
            }
        } else {
            DB::table('tbl_datasets_private')->where('id_datasets', $datasets->id)->delete();
        }
        $status = '';
        $pesan = '';
        if ($request->status == 'PENDING') {
            $status = 'D4';
            $pesan = 'Mengubah Status Datasets Menjadi PENDING Nama ';
        } elseif ($request->status == 'APPROVED') {
            $status = 'D5';
            $pesan = 'Mengubah Status Datasets Menjadi APPROVED Nama ';
        } elseif ($request->status == 'REJECTED') {
            $status = 'D6';
            $pesan = 'Mengubah Status Datasets Menjadi REJECTED Nama ';
        } else {
            $status = 'D7';
            $pesan = 'Mengubah Status Datasets Menjadi PERLU PERBAIKAN Nama ';
        }
        (new AktivitasController)->store(Auth::user()->id, $pesan.$request->judul, $status, Auth::user()->role);

        return redirect()->route('opddatasetsshare.index')->with('success', 'Berhasil Merubah Data !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function csv_upload(Request $request, string $id)
    {
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt',
            'terminated' => 'required',
        ]);
        $name = time().'-'.$request->csv_file->getClientOriginalName();
        $request->csv_file->move(public_path('assets/csv_file'), $name);

        $file = public_path('assets/csv_file/'.$name);
        $file_path = addslashes($file);

        $datasets = Datasets::find($id);
        DB::table($datasets->db_datasets)->truncate();
        $loadDataToTempTableSql = "LOAD DATA LOCAL INFILE '".$file_path."' INTO TABLE ".$datasets->db_datasets." FIELDS TERMINATED BY '".$request->terminated."' OPTIONALLY ENCLOSED BY '\"' LINES TERMINATED BY '\r' IGNORE 1 LINES";
        $pdo = DB::connection()->getPdo();
        $pdo->exec($loadDataToTempTableSql);
        $data = DB::table($datasets->db_datasets)->get();
        $deleted = DB::table($datasets->db_datasets)->where('id', count($data))->delete();
        (new AktivitasController)->store(Auth::user()->id, 'Mengupload Data Di datasets '.$datasets->judul, 'D7', Auth::user()->role);

        return redirect()->route('opddatasetsshare.show', $id)->with('success', 'Berhasil Menambahkan Data Baru !');
    }
}
