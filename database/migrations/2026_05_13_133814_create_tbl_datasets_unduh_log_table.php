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
        Schema::create('tbl_datasets_unduh_log', function (Blueprint $table) {
            $table->id();
            $table->string('id_datasets', 50); // Pakai string karena ID Anda UUID (ada huruf/strip)
            $table->string('ips', 45);
            $table->timestamp('created_at')->useCurrent();

            $table->index(['id_datasets', 'ips']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_datasets_unduh_log');
    }
};
