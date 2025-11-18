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
        Schema::create('tbl_artikel', function (Blueprint $table) {
            $table->id();
            $table->integer('id_user');
            $table->integer('id_sektor');
            $table->string('judul');
            $table->string('gambar');
            $table->string('slug');
            $table->longText('isi');
            $table->enum('status', ['publish', 'draft'])->default('draft');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_artikel');
    }
};
