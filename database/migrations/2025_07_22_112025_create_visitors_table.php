<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitorsTable extends Migration
{
    /**
     * Menjalankan migrasi.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visitors', function (Blueprint $table) {
            $table->id(); // ID pengunjung
            $table->integer('today_visitors')->default(0); // Pengunjung hari ini
            $table->integer('month_visitors')->default(0); // Pengunjung bulan ini
            $table->integer('year_visitors')->default(0); // Pengunjung tahun ini
            $table->timestamps(); // Tanggal dibuat dan diperbarui
        });
    }

    /**
     * Membatalkan migrasi.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('visitors');
    }
}
