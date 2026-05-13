<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tbl_agenda_datasets', function (Blueprint $table) {

            // 1. Primary Key: Menggunakan default 'id' sebagai auto-increment PK.
            $table->id();

            // 2. Kolom datasets_id (Diubah menjadi kolom data biasa, bukan FK, tipe CHAR(36))
            $table->char('datasets_id', 36)
                ->comment('ID datasets utama (sebelumnya Foreign Key, sekarang char(36))');

            // Kolom untuk menyimpan nama bulan (misalnya: 'Januari')
            $table->string('bulan', 20)
                ->comment('Nama bulan dari input field');

            // Kolom untuk menyimpan hari/tanggal (1-31)
            $table->unsignedTinyInteger('tanggal')
                ->comment('Hari/Tanggal (1-31) dari form input');

            // Kolom untuk menyimpan tahun
            $table->year('tahun')->nullable()->comment('Tahun data agenda');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_agenda_datasets');
    }
};
