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
        Schema::table('tbl_agenda_datasets', function (Blueprint $table) {
            // Menambahkan kolom judul_rilis (string) dan deskripsi (text)
            // Saya letakkan setelah kolom 'bulan' (sesuaikan jika perlu)
            $table->string('judul_rilis')->nullable()->after('bulan');
            $table->text('deskripsi')->nullable()->after('judul_rilis');
        });
    }

    public function down(): void
    {
        Schema::table('tbl_agenda_datasets', function (Blueprint $table) {
            $table->dropColumn(['judul_rilis', 'deskripsi']);
        });
    }
};
