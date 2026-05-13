<?php

namespace App\Http\Controllers\Admin;

// Matikan Comment dibawah ini Jika Di Push Ke dalam Server :)
// define('STDIN', fopen('php://stdin','r'));

use App\Http\Controllers\Controller;
use App\Models\AgendaDataset;
use App\Models\Datasets;
use App\Models\Opd;
use App\Models\Sektor;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class DatasetsController extends Controller
{
    private $kolom_setelah;

    private $nama_kolom_delete;

    public function __construct()
    {
        $this->middleware('checkRole:admin');
    }

    public function index(Request $request)
    {
        $datasets = Datasets::query();
        if ($request->has('nama_opd') && ! empty($request->nama_opd)) {
            $datasets = Datasets::where('nama_opd', 'like', '%'.$request->nama_opd.'%')->latest()->get();
        } else {
            $datasets = Datasets::latest()->get();
        }
        $users = User::all();
        $title = 'Hapus Datasets !';
        $text = 'Kamu yakin ingin Menghapus Datasets ini?';
        confirmDelete($title, $text);

        return view('super-admin.datasets.index', compact('datasets', 'users'));
    }

    public function create()
    {
        $opd = Opd::all();
        $sektor = Sektor::all();
        $main_sektor = DB::table('tbl_main_sektor')->get();

        return view('super-admin.datasets.tambah', compact('opd', 'sektor', 'main_sektor'));
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
            'metadata' => 'mimes:pdf|max:5048',
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
        $judul = Str::slug($request->judul);
        $explode_judul = (explode('-', $judul));
        $hash = Str::random(5);
        $db_name = $explode_judul[0].'_'.$explode_judul[1].'_'.$explode_judul[2].'_'.$hash;
        $db_name = strtolower($db_name);
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

        $tahun_rilis = $request->tahun_datasets;

        $bulan_map = [
            'tgl_jan' => 'Januari',
            'tgl_feb' => 'Februari',
            'tgl_mar' => 'Maret',
            'tgl_apr' => 'April',
            'tgl_mei' => 'Mei',
            'tgl_jun' => 'Juni',
            'tgl_jul' => 'Juli',
            'tgl_agu' => 'Agustus',
            'tgl_sep' => 'September',
            'tgl_okt' => 'Oktober',
            'tgl_nov' => 'November',
            'tgl_des' => 'Desember',
        ];

        // Inisialisasi array untuk menampung data yang akan disimpan
        $data_to_insert = []; // DIGANTI menjadi data_to_insert agar konsisten

        foreach ($bulan_map as $field_input => $nama_bulan) {
            // 1. Ambil nilai tanggal dari input field
            // Menggunakan properti dinamis ($request->$field_input) sudah OK
            $hari = $request->$field_input;

            // 2. Periksa apakah user mengisikan tanggal untuk bulan ini
            if (! empty($hari)) {
                // 3. Jika ada, tambahkan ke array data_to_insert
                $data_to_insert[] = [
                    'datasets_id' => $datasets->id,        // ID dari datasets yang baru dibuat
                    'tanggal' => (int) $hari,          // Hari/Tanggal
                    'bulan' => $nama_bulan,         // Nama Bulan

                    'tahun' => $tahun_rilis,        // Ambil nilai dari $request->tahun_datasets
                    'status' => '1',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // *** PERBAIKAN PENTING DI SINI ***
        // Menggunakan AgendaDataset::insert() dan array $data_to_insert yang benar
        if (! empty($data_to_insert)) {
            AgendaDataset::insert($data_to_insert);
        }

        (new AktivitasController)->store(Auth::user()->id, 'Menambahkan Datasets dengan Nama '.$request->judul, 'D1', Auth::user()->role);

        return redirect()->route('datasets.index')->with('success', 'Berhasil Menambahkan Data Baru !');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $datasets = Datasets::find($id);
        $table = Schema::getColumnListing($datasets->db_datasets);
        $nama_table = $datasets->db_datasets;

        return view('super-admin.datasets.show', compact('table', 'datasets', 'nama_table'));
    }

    public function tambah_kolom(Request $request, $id)
    {
        $request->validate([
            'nama_kolom' => 'required|max:100',
            'kolom_setelah' => 'required|max:255',
        ]);
        $datasets = Datasets::find($id);
        if (Schema::hasColumn($datasets->db_datasets, $request->nama_kolom)) {
            return redirect()->route('datasets.show', $id)->with('toast_error', 'Nama Kolom Sudah ada !');
        } else {
            $newColumnType = 'string';
            $newColumnName = strtolower($request->nama_kolom);
            $newColumnName = str_replace(' ', '_', $newColumnName);
            $this->kolom_setelah = $request->kolom_setelah;
            Schema::table($datasets->db_datasets, function (Blueprint $table) use ($newColumnType, $newColumnName) {
                $table->$newColumnType($newColumnName)->after($this->kolom_setelah);
            });
            (new AktivitasController)->store(Auth::user()->id, 'Berhasil Menambah Kolom'.$request->nama_kolom, 'D9', Auth::user()->role);

            return redirect()->route('datasets.show', $id)->with('success', 'Nama Kolom Berhasil ditambahkan !');
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
        if ($request->rename == 'id') {
            return redirect()->route('datasets.show', $id)->with('toast_error', 'Nama Kolom Ini Tidak Boleh diubah !');
        } else {
            if (Schema::hasColumn($datasets->db_datasets, $request->nama_kolom)) {
                return redirect()->route('datasets.show', $id)->with('toast_error', 'Nama Kolom Sudah ada !');
            }
            if (Schema::hasColumn($datasets->db_datasets, $request->rename)) {
                DB::statement("ALTER TABLE `$datasets->db_datasets` CHANGE `$request->rename` `$request->nama_kolom` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL");
                (new AktivitasController)->store(Auth::user()->id, 'Berhasil Mengubah Kolom'.$request->nama_kolom, 'D10', Auth::user()->role);

                return redirect()->route('datasets.show', $id)->with('success', 'Nama Kolom Berhasil diubah !');
            } else {
                return redirect()->route('datasets.show', $id)->with('toast_error', 'Nama Kolom Ini Tidak ada !');
            }
        }
    }

    public function delete_kolom(Request $request, $id)
    {
        $request->validate([
            'nama_kolom' => 'required|max:100',
        ]);
        if ($request->nama_kolom == 'id') {
            return redirect()->route('datasets.show', $id)->with('toast_error', 'Nama Kolom Ini Tidak Boleh dihapus !');
        }
        $datasets = Datasets::find($id);
        $this->nama_kolom_delete = $request->nama_kolom;
        if (Schema::hasColumn($datasets->db_datasets, $request->nama_kolom)) {
            Schema::table($datasets->db_datasets, function (Blueprint $table) {
                $table->dropColumn($this->nama_kolom_delete);
            });
            (new AktivitasController)->store(Auth::user()->id, 'Berhasil menghapus Kolom'.$request->nama_kolom, 'D8', Auth::user()->role);

            return redirect()->route('datasets.show', $id)->with('success', 'Nama Kolom Berhasil Dihapus !');
        } else {
            return redirect()->route('datasets.show', $id)->with('toast_error', 'Nama Kolom Tidak ada !');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id, Request $request)
    {
        $datasets = Datasets::where('id', $id)->first();
        $metadata = DB::table('tbl_metadata')->where('id_datasets', $datasets->id)->first();
        $opd = Opd::all();
        $users = User::where('id', $datasets->diupload_oleh)->first();
        $sektor = Sektor::all();
        $main_sektor = DB::table('tbl_main_sektor')->get();
        $isReadOnly = $request->has('read_only');

        // dd($isReadOnly);
        return view('super-admin.datasets.edit', compact('datasets', 'opd', 'users', 'metadata', 'sektor', 'main_sektor', 'isReadOnly'));

    }

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
            'status' => 'required',
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
        if ($request->status == 'REPAIR') {
            $request->validate([
                'alasan' => 'required',
            ]);
        } else {
            $request->alasan = null;
        }
        $datasets = Datasets::find($id);
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
            'status' => $request->status,
            'alasan' => $request->alasan,
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
            DB::table('tbl_datasets_private')->where('id_datasets', $datasets->id)->update([
                'id_datasets' => $datasets->id,
                'id_instansi' => $instansi,
            ]);
        } else {
            DB::table('tbl_datasets_private')->where('id_datasets', $datasets->id)->delete();
        }
        $status = '';
        $pesan = '';
        if ($request->judul != null) {
            $status = 'D2'.'';
            $pesan = 'Berhasil Mengubah Details Datasets ';
        }
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

        return redirect()->route('datasets.index')->with('success', 'Berhasil Merubah Data !');
    }

    // ============= ini agenda ================///
    public function agendaList(Request $request)
    {
        $agendaDatasetIds = DB::table('tbl_agenda_datasets')->pluck('datasets_id');

        $datasets = Datasets::whereIn('id', $agendaDatasetIds);

        if ($request->has('nama_opd') && ! empty($request->nama_opd)) {
            $datasets->where('nama_opd', 'like', '%'.$request->nama_opd.'%');
        }

        $datasets = $datasets->latest()->get();

        $datasetsAgenda = Datasets::with('agendas')->latest()->get();

        $users = User::all();
        $title = 'Hapus Datasets !';
        $text = 'Kamu yakin ingin Menghapus Datasets ini?';
        confirmDelete($title, $text);

        return view('super-admin.datasets.agenda-list', compact('datasets', 'users', 'datasetsAgenda'));
    }

    public function agendaRilis(string $id, Request $request)
    {
        $datasets = Datasets::where('id', $id)->first();
        $metadata = DB::table('tbl_metadata')->where('id_datasets', $datasets->id)->first();
        $opd = Opd::all();
        $users = User::where('id', $datasets->diupload_oleh)->first();
        $sektor = Sektor::all();
        $main_sektor = DB::table('tbl_main_sektor')->get();
        $isReadOnly = $request->has('read_only');
        $agenda_id = $request->query('agenda_id');

        return view('super-admin.datasets.agenda-rilis', compact('datasets', 'opd', 'users', 'metadata', 'sektor', 'main_sektor', 'isReadOnly', 'agenda_id'));
    }

    // ==================== end agenda ====================//

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $datasets = Datasets::find($id);
        $file_path = public_path('assets/metadata/'.$datasets->metadata);
        if (File::exists($file_path)) {
            File::delete($file_path);
        }
        if (Schema::hasTable($datasets->db_datasets)) {
            Schema::drop($datasets->db_datasets);
        }
        DB::table('tbl_datasets_seen')->where('id_datasets', $id)->delete();
        DB::table('tbl_metadata')->where('id_datasets', $id)->delete();
        DB::table('tbl_datasets_private')->where('id_datasets', $id)->delete();
        (new AktivitasController)->store(Auth::user()->id, 'Menghapus Datasets dengan Nama '.$datasets->judul, 'D3', Auth::user()->role);
        $datasets->delete();

        return redirect()->route('datasets.index')->with('success', 'Data Berhasil dihapus !');
    }

    public static function checked_instansi($id, $id_opd)
    {
        $datasets_private = DB::table('tbl_datasets_private')->where('id_datasets', $id)->first();
        $temp = json_decode($datasets_private->id_instansi);
        for ($i = 0; $i < count($temp); $i++) {
            if ($temp[$i] == $id_opd) {
                return 'checked';
            }
        }

    }

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

        return redirect()->route('datasets.show', $id)->with('success', 'Berhasil Menambahkan Data Baru !');
    }

    public function store1(Request $request)
    {
        if (count($request->nama_kolom) !== count(array_unique($request->nama_kolom))) {
            return redirect()->back()->with('toast_error', 'Nama Kolom Tidak Boleh Sama !');
        }

        $request->validate([
            'judul' => 'required|max:255',
            'nama_opd' => 'required|max:255',
            'tahun_datasets' => 'required',
            'metadata' => 'mimes:pdf|max:5048',
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
        $judul = Str::slug($request->judul);
        $explode_judul = (explode('-', $judul));
        $hash = Str::random(5);
        $db_name = $explode_judul[0].'_'.$explode_judul[1].'_'.$explode_judul[2].'_'.$hash;
        $db_name = strtolower($db_name);
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

        $tahun_rilis = $request->tahun_datasets;

        $bulan_map = [
            'tgl_jan' => 'Januari',
            'tgl_feb' => 'Februari',
            'tgl_mar' => 'Maret',
            'tgl_apr' => 'April',
            'tgl_mei' => 'Mei',
            'tgl_jun' => 'Juni',
            'tgl_jul' => 'Juli',
            'tgl_agu' => 'Agustus',
            'tgl_sep' => 'September',
            'tgl_okt' => 'Oktober',
            'tgl_nov' => 'November',
            'tgl_des' => 'Desember',
        ];

        // Inisialisasi array untuk menampung data yang akan disimpan
        $data_to_insert = []; // DIGANTI menjadi data_to_insert agar konsisten

        foreach ($bulan_map as $field_input => $nama_bulan) {
            // 1. Ambil nilai tanggal dari input field
            // Menggunakan properti dinamis ($request->$field_input) sudah OK
            $hari = $request->$field_input;

            // 2. Periksa apakah user mengisikan tanggal untuk bulan ini
            if (! empty($hari)) {
                // 3. Jika ada, tambahkan ke array data_to_insert
                $data_to_insert[] = [
                    'datasets_id' => $datasets->id,        // ID dari datasets yang baru dibuat
                    'tanggal' => (int) $hari,          // Hari/Tanggal
                    'bulan' => $nama_bulan,         // Nama Bulan

                    'tahun' => $tahun_rilis,        // Ambil nilai dari $request->tahun_datasets
                    'status' => '0',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // *** PERBAIKAN PENTING DI SINI ***
        // Menggunakan AgendaDataset::insert() dan array $data_to_insert yang benar
        if (! empty($data_to_insert)) {
            AgendaDataset::insert($data_to_insert);
        }

        (new AktivitasController)->store(Auth::user()->id, 'Menambahkan Datasets dengan Nama '.$request->judul, 'D1', Auth::user()->role);

        return redirect()->route('datasets.index')->with('success', 'Berhasil Menambahkan Data Baru !');
    }
}
