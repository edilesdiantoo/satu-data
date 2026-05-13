<?php

namespace App\Console\Commands;

use App\Models\Visitor;
use App\Models\YearlyVisitorSummary;
use Carbon\Carbon; // <<< Tambahkan ini
use Illuminate\Console\Command;

class ResetVisitors extends Command
{
    protected $signature = 'visitors:reset';

    protected $description = 'Resets daily, monthly, and yearly visitor counts, and saves yearly summary.';

    public function handle()
    {
        $visitor = Visitor::first();

        if ($visitor) {
            $now = Carbon::now();

            // --- Logika untuk Menyimpan Data Tahunan ---
            // Ini akan dieksekusi setiap hari, tapi hanya efek pada 1 Januari
            if ($now->month === 1 && $now->day === 1) { // Jika hari ini tanggal 1 Januari
                // Ambil tahun sebelumnya
                $previousYear = $now->subYear()->year; // Menggunakan subYear() dari Carbon

                // Pastikan ada nilai year_visitors dari tahun sebelumnya
                // Jika $visitor->year_visitors ini adalah total tahun *sekarang* yang belum direset,
                // maka kita harus mengambil nilai dari akhir hari kemarin untuk tahun sebelumnya.
                // Pendekatan yang lebih aman: Ketika script ini dijalankan pada 1 Jan,
                // nilai year_visitors yang ada di $visitor adalah total untuk tahun yang BARU SAJA BERAKHIR.

                // Simpan total pengunjung tahun sebelumnya ke tabel summary
                YearlyVisitorSummary::updateOrCreate(
                    ['year' => $previousYear], // Cari berdasarkan tahun sebelumnya
                    ['visitor_count' => $visitor->year_visitors] // Simpan nilai year_visitors dari tahun sebelumnya
                );

                $this->info("Saved {$visitor->year_visitors} visitors for year {$previousYear}.");

                // Reset year_visitors untuk tahun yang baru
                $visitor->year_visitors = 0;
            }
            // --- Akhir Logika Menyimpan Data Tahunan ---

            // Reset today_visitors setiap hari
            $visitor->today_visitors = 0;

            // Reset month_visitors setiap awal bulan
            if ($now->day === 1) { // Jika hari ini tanggal 1
                $visitor->month_visitors = 0;
            }

            $visitor->save();
            $this->info('Visitor counts reset successfully.');
        } else {
            $this->warn('No visitor record found to reset.');
        }

        return Command::SUCCESS;
    }
}
