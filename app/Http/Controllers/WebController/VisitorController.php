<?php
namespace App\Http\Controllers\WebController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Visit;
use Carbon\Carbon;
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
        // \Log::info('Logging page view started'); // Log untuk mengecek eksekusi fungsi

        $ip = $request->ip();
        $userAgent = $request->header('User-Agent');
        $currentDate = Carbon::today()->toDateString();
        $urlVisited = $request->fullUrl();
        $referrer = $request->header('Referer');

        // Debugging: log data yang diterima
        // \Log::info('Request Data: ', [
        //     'ip' => $ip,
        //     'urlVisited' => $urlVisited,
        //     'referrer' => $referrer
        // ]);

        $sessionKey = 'visited_today_' . $currentDate . '_' . $ip . '_' . md5($urlVisited);

        if (!Session::has($sessionKey)) {
            Session::put($sessionKey, true);

            // Debugging: cek apakah data sudah ada di database
            $existingVisit = Visit::where('ip_address', $ip)
                                ->whereDate('visit_date', $currentDate)
                                ->first();
            
            // \Log::info('Existing visit: ', ['existingVisit' => $existingVisit]);

            if (!$existingVisit) {
                Visit::create([
                    'ip_address' => $ip,
                    'user_agent' => $userAgent,
                    'url_visited' => $urlVisited,
                    'referrer' => $referrer,
                    'visit_date' => $currentDate,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
                // \Log::info('Data saved for IP: ' . $ip); // Log jika data disimpan
            }
        }
        return response()->json(['status' => 'success', 'message' => 'Page view logged.']);
    }

    /**
     * Mengambil jumlah pengunjung unik untuk hari ini, bulan ini, tahun ini, dan total.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getVisitorCounts()
    {
        $today = Carbon::today();
        $startOfMonth = Carbon::now()->startOfMonth();
        $startOfYear = Carbon::now()->startOfYear();

        // Pengunjung Hari Ini (unik IP untuk hari ini)
        $todayVisitors = Visit::whereDate('visit_date', $today)
                            ->distinct('ip_address') // Hanya IP unik
                            ->count();

        // Pengunjung Bulan Ini (unik IP untuk bulan ini)
        $monthVisitors = Visit::where('visit_date', '>=', $startOfMonth)
                            ->distinct('ip_address') // Hanya IP unik
                            ->count();

        // Pengunjung Tahun Ini (unik IP untuk tahun ini)
        $yearVisitors = Visit::where('visit_date', '>=', $startOfYear)
                            ->distinct('ip_address') // Hanya IP unik
                            ->count();

        // Total Pengunjung (unik IP sepanjang waktu)
        $totalVisitors = Visit::distinct('ip_address') // Hanya IP unik
                            ->count();

        return response()->json([
            'today' => $todayVisitors,
            'month' => $monthVisitors,
            'year' => $yearVisitors,
            'total' => $totalVisitors,
        ]);
    }
}
