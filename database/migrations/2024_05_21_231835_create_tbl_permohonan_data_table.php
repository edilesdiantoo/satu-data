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
        Schema::create('tbl_permohonan_data', function (Blueprint $table) {
            $table->id();
            $table->char('id_datasets')->nullable();
            $table->string('nama');
            $table->string('email');
            $table->string('no_tlp');
            $table->string('judul_datasets');
            $table->string('opd')->nullable();
            $table->longText('deskripsi');
            $table->string('tujuan');
            $table->string('upload_template');
            $table->string('status');
            $table->string('tracking');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_permohonan_data');
    }
};
