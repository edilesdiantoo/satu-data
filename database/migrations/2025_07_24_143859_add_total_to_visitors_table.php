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
        Schema::table('visitors', function (Blueprint $table) {
            // Tambahkan field 'total_visitors' (gunakan nama yang konsisten dengan lainnya)
            // Pastikan tipe data cukup besar, unsignedBigInteger adalah pilihan yang baik
            // default(0) agar nilai awalnya nol jika tabel sudah ada isinya
            $table->unsignedBigInteger('total_visitors')->default(0)->after('year_visitors');
            // Anda bisa mengatur posisinya sesuai keinginan, 'after' adalah opsional
            // Contoh lain: $table->unsignedBigInteger('total_visitors')->default(0); // Akan menambah di akhir
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('visitors', function (Blueprint $table) {
            // Hapus field 'total_visitors' jika migrasi di-rollback
            $table->dropColumn('total_visitors');
        });
    }
};