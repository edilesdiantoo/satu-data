<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('tbl_agenda_datasets', function (Blueprint $table) {
            // Menambahkan kolom jumlah_unduhan setelah kolom db_datasets
            // Default 0 agar tidak null saat pertama kali dibuat
            $table->integer('jumlah_unduhan')->default(0)->after('db_datasets');
        });
    }

    public function down()
    {
        Schema::table('tbl_agenda_datasets', function (Blueprint $table) {
            $table->dropColumn('jumlah_unduhan');
        });
    }
};
