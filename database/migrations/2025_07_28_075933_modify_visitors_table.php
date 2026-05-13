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
        // Hapus tabel 'visitors' yang lama
        Schema::dropIfExists('visitors');

        // Buat tabel 'visits' yang baru dengan struktur yang benar
        Schema::create('visits', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->string('url_visited')->nullable();
            $table->string('referrer')->nullable();
            $table->date('visit_date'); // Kolom untuk tanggal kunjungan
            $table->timestamps(); // created_at dan updated_at

            // Opsional: Indeks unik untuk mencegah duplikasi kunjungan dari IP yang sama di hari yang sama untuk URL yang sama
            $table->unique(['ip_address', 'visit_date', 'url_visited'], 'unique_visit_per_day_url_ip');
            // Berikan nama indeks eksplisit karena mungkin terlalu panjang
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Saat rollback, hapus tabel 'visits'
        Schema::dropIfExists('visits');

        // Jika Anda ingin mengembalikan tabel 'visitors' yang lama saat rollback,
        // Anda harus membuat ulang strukturnya di sini.
        // Namun, karena data sudah hilang di up(), ini tidak akan mengembalikan data.
        // Umumnya, jika Anda menghapus tabel di up(), down() hanya akan menghapus tabel baru.
        Schema::create('visitors', function (Blueprint $table) {
            $table->id();
            $table->integer('today_visitors')->default(0);
            $table->integer('month_visitors')->default(0);
            $table->integer('year_visitors')->default(0);
            $table->integer('total_visitors')->default(0);
            $table->timestamps();
        });
    }
};
