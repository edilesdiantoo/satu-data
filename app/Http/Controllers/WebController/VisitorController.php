<?php

namespace App\Http\Controllers\WebController;

use App\Http\Controllers\Controller;
use App\Models\Visit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class VisitorController extends Controller
{
    /**
     * Fungsi untuk menghitung pengunjung dan menyimpan data ke database.
     *
     * @return \Illuminate\Http\Response
     */
    public function logPageView(Request $request)
    {
        // 1. AMBIL IP ASLI (Membongkar Proxy)
        // Cek header X-Forwarded-For (umumnya digunakan Proxy/WAF Pemprov)
        $ip = $request->header('X-Forwarded-For')
              ? trim(explode(',', $request->header('X-Forwarded-For'))[0])
              : $request->ip();

        // Jika menggunakan Cloudflare, aktifkan baris di bawah ini:
        // $ip = $request->header('CF-Connecting-IP') ?? $ip;

        $userAgent = $request->header('User-Agent');
        $currentDate = Carbon::today()->toDateString();
        $urlVisited = $request->fullUrl();
        $referrer = $request->header('Referer');

        // 2. FILTER BOT: Jangan simpan jika yang akses adalah Crawler/Bot
        if (preg_match('/bot|crawl|slurp|spider|mediapartners/i', $userAgent)) {
            return response()->json(['status' => 'ignored', 'message' => 'Bot activity ignored.']);
        }

        // 3. GUNAKAN SESSION ID: Membedakan orang di IP yang sama
        $sessionID = session()->getId();
        // Tambahkan URL ke MD5 agar pindah halaman tetap tercatat (jika ingin per halaman)
        $sessionKey = 'v_today_'.$currentDate.'_'.md5($ip.$sessionID.$urlVisited);

        if (! Session::has($sessionKey)) {

            // 4. LOGIKA DATABASE: Gunakan IP asli yang baru didapat
            $existingVisit = Visit::where('ip_address', $ip)
                ->where('user_agent', $userAgent)
                ->where('url_visited', $urlVisited)
                ->whereDate('visit_date', $currentDate)
                ->first();

            if (! $existingVisit) {
                Visit::create([
                    'ip_address' => $ip,
                    'user_agent' => $userAgent,
                    'url_visited' => $urlVisited,
                    'referrer' => $referrer,
                    'visit_date' => $currentDate,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);

                Session::put($sessionKey, true);
            }
        }

        return response()->json(['status' => 'success', 'message' => 'Page view logged.']);
    }

    /**
     * Mengambil jumlah pengunjung unik untuk hari ini, bulan ini, tahun ini, dan total.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getVisitorCounts(Request $request)
    {
        $today = \Carbon\Carbon::today();
        $startOfMonth = \Carbon\Carbon::now()->startOfMonth();
        $startOfYear = \Carbon\Carbon::now()->startOfYear();

        // Query untuk mengambil IP unik
        $todayVisitors = Visit::whereDate('visit_date', $today)
            ->distinct()
            ->count('ip_address');

        $monthVisitors = Visit::where('visit_date', '>=', $startOfMonth)
            ->distinct()
            ->count('ip_address');

        $yearVisitors = Visit::where('visit_date', '>=', $startOfYear)
            ->distinct()
            ->count('ip_address');

        $totalVisitors = Visit::distinct()
            ->count('ip_address');

        return response()->json([
            'today' => $todayVisitors,
            'month' => $monthVisitors,
            'year' => $yearVisitors,
            'total' => $totalVisitors,
            'your_ip' => $request->ip(), // Sekarang $request sudah didefinisikan
        ]);
    }
}
