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
        Schema::create('yearly_visitor_summaries', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('year')->unique(); // Tahun (e.g., 2023, 2024), harus unik
            $table->unsignedBigInteger('visitor_count')->default(0); // Total pengunjung untuk tahun tersebut
            $table->timestamps(); // created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('yearly_visitor_summaries');
    }
};