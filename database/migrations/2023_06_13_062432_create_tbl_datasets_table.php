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
        Schema::create('tbl_datasets', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('nama_opd');
            $table->string('diupload_oleh');
            $table->string('tahun_datasets');
            $table->string('deskripsi');
            $table->string('tags');
            $table->string('sifat_datasets');
            $table->string('db_datasets');
            $table->string('status');
            $table->string('jumlah_unduhan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_datasets');
    }
};
