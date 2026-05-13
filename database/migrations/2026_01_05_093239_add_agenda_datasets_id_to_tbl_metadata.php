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
        Schema::table('tbl_metadata', function (Blueprint $table) {
            $table->unsignedBigInteger('agenda_datasets_id')->nullable()->after('id_datasets');
        });
    }

    public function down(): void
    {
        Schema::table('tbl_metadata', function (Blueprint $table) {
            $table->dropColumn('agenda_datasets_id');
        });
    }
};
