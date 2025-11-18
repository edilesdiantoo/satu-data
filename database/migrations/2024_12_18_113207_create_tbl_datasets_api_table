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
        Schema::create('tbl_datasets_api', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('judul');
            $table->integer('id_opd');
            $table->enum('sifat_datasets', ['PUBLIK', 'PRIVATE'])->default('PRIVATE');
            $table->integer('id_sektor');
            $table->string('bearer');
            $table->string('link_api');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_datasets_api');
    }
};
