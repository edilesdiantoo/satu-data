<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AgendaDataset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class AgendaController extends Controller
{
    public function store(Request $request, $agenda_id)
    {
        // 1. Cari data agenda
        $agenda = AgendaDataset::find($agenda_id);
        if (! $agenda) {
            return redirect()->back()->with('toast_error', 'Data Agenda tidak ditemukan!');
        }

        // 2. Persiapan Nama Tabel Dinamis
        $judul = Str::slug($request->judul_rilis);
        $hash = Str::random(5);
        $db_name = strtolower(str_replace('-', '_', $judul).'_'.$hash);

        // --- PROSES UPLOAD FILE METADATA ---
        $filename = null;
        if ($request->hasFile('metadata')) {
            $filename = time().'.'.$request->metadata->extension();
            $request->metadata->move(public_path('assets/metadata'), $filename);
        }

        // --- PROSES CREATE TABEL ---
        if ($request->has('nama_kolom') && count($request->nama_kolom) > 0) {

            // Bersihkan nama kolom: lowercase, trim, ganti spasi jadi underscore
            $columns = array_map(function ($col) {
                return strtolower(str_replace(' ', '_', trim($col)));
            }, $request->nama_kolom);

            // Buat Tabel Baru Jika Belum Ada
            if (! Schema::hasTable($db_name)) {
                Schema::create($db_name, function (\Illuminate\Database\Schema\Blueprint $table) use ($columns) {
                    // Primary Key otomatis dari Laravel
                    $table->increments('id');

                    foreach ($columns as $col) {
                        // FIX: Jangan buat kolom 'id' lagi jika di Excel ada kolom 'id'
                        if (! empty($col) && $col !== 'id') {
                            $table->text($col)->nullable();
                        }
                    }
                    $table->timestamps();
                });
            }

            // --- PROSES INSERT DATA (RIBUAN BARIS) ---
            if ($request->has('isi_kolom')) {
                $insert_data = [];
                $now = now();

                foreach ($request->isi_kolom as $row_values) {
                    $row_entry = [];
                    $has_value = false;

                    foreach ($columns as $index => $col_name) {
                        // FIX: Jika nama kolom adalah 'id', abaikan isinya (karena auto-increment)
                        // Atau jika Anda ingin simpan ID excel ke kolom lain, ganti logika di sini
                        if ($col_name === 'id') {
                            continue;
                        }

                        $val = $row_values[$index] ?? null;
                        $row_entry[$col_name] = $val;

                        if (! empty($val)) {
                            $has_value = true;
                        }
                    }

                    if ($has_value) {
                        $row_entry['created_at'] = $now;
                        $row_entry['updated_at'] = $now;
                        $insert_data[] = $row_entry;
                    }
                }

                // Gunakan CHUNK INSERT (Per 500 baris) agar tidak membebani server/database
                if (! empty($insert_data)) {
                    $chunks = array_chunk($insert_data, 500);
                    foreach ($chunks as $chunk) {
                        DB::table($db_name)->insert($chunk);
                    }
                }
            }
        } else {
            return redirect()->back()->with('toast_error', 'Konfigurasi kolom tidak ditemukan!');
        }

        // --- UPDATE DATA AGENDA ---
        $agenda->update([
            'judul_rilis' => $request->judul_rilis,
            'deskripsi' => $request->deskripsi,
            'metadata' => $filename,
            'db_datasets' => $db_name,
            'status' => '1',
            'updated_at' => now(),
        ]);

        // --- INSERT KE TBL_METADATA ---
        DB::table('tbl_metadata')->insert([
            'id_datasets' => $agenda->datasets_id,
            'agenda_datasets_id' => $agenda_id,
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
            'created_at' => now(),
        ]);

        return redirect()->route('datasets.agendaList')->with('success', 'Berhasil Merilis Data!');
    }
}
