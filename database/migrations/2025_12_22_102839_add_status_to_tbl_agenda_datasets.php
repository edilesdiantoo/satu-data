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
            $table->string('db_datasets', 255)->nullable()->comment('Nama database terkait dataset');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_agenda_datasets', function (Blueprint $table) {
            //
        });
    }
};
