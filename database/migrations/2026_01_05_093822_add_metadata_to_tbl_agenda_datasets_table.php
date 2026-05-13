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
            // Menambahkan kolom metadata dengan tipe varchar (string di Laravel)
            // Saya letakkan setelah kolom 'deskripsi' yang kita buat tadi
            $table->string('metadata')->nullable()->after('deskripsi');
        });
    }

    public function down(): void
    {
        Schema::table('tbl_agenda_datasets', function (Blueprint $table) {
            $table->dropColumn('metadata');
        });
    }
};
