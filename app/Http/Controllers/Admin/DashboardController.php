<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aktivitas;
use App\Models\BPS;
use App\Models\Datasets;
use App\Models\Infografis;
use App\Models\Publikasi;
use App\Models\User;
use App\Models\Visualisasi;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkRole:admin');
    }

    public function index(Request $request)
    {
        $data_sektoral = Datasets::count();
        $dashboard = Visualisasi::where('kategori', 'dashboard')->count();
        $storyboard = Visualisasi::where('kategori', 'storyboard')->count();
        $produk_statistik = Publikasi::count();
        $infografis = Infografis::count();
        $data_dasar = BPS::count();
        $operator = User::where('role', 'admin')->count();
        $opd = User::where('role', 'opd')->count();

        $today = Datasets::whereDate('created_at', Carbon::today())->count();
        $week = Datasets::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
        $month = Datasets::whereMonth('created_at', date('m'))->count();

        $visitor_today = DB::table('tbl_datasets_seen')->whereDate('created_at', Carbon::today())->count();
        $visitor_week = DB::table('tbl_datasets_seen')->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
        $visitor_month = DB::table('tbl_datasets_seen')->whereMonth('created_at', date('m'))->count();

        $aktivitas = Aktivitas::orderBy('created_at', 'DESC')->paginate(6);
        $user = User::get(['id', 'name', 'photo']);
        $chart = null;
        if ($request->input('startDate') && $request->input('endDate')) {
            $validatedData = $request->validate([
                'startDate' => 'required|date',
                'endDate' => 'required|date|after_or_equal:startDate',
            ]);
            $chart = Datasets::whereBetween('created_at', [$request->startDate, $request->endDate])->get()->groupBy(function ($item) {
                return Carbon::parse($item->created_at)->format('Y-m-d');
            })
                ->map(function ($group) {
                    return $group->count();
                });
        }

        return view('super-admin.index', compact('data_sektoral', 'chart', 'dashboard', 'storyboard', 'operator', 'produk_statistik', 'infografis', 'data_dasar', 'opd', 'today', 'week', 'month', 'visitor_today', 'visitor_week', 'visitor_month', 'aktivitas', 'user'));
    }

    public static function grafik()
    {
        $stat = Datasets::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get();
        $sun = 0;
        $mon = 0;
        $tue = 0;
        $wed = 0;
        $thu = 0;
        $fri = 0;
        $sat = 0;
        foreach ($stat as $item) {
            if ($item->created_at->format('D') == 'Sun') {
                $sun = $sun + 1;
            } elseif ($item->created_at->format('D') == 'Mon') {
                $mon = $mon + 1;
            } elseif ($item->created_at->format('D') == 'Tue') {
                $tue = $tue + 1;
            } elseif ($item->created_at->format('D') == 'Wed') {
                $wed = $wed + 1;
            } elseif ($item->created_at->format('D') == 'Thu') {
                $thu = $thu + 1;
            } elseif ($item->created_at->format('D') == 'Fri') {
                $fri = $fri + 1;
            } elseif ($item->created_at->format('D') == 'Sat') {
                $sat = $sat + 1;
            }
        }
        $graph = "$sun,"."$mon,"."$tue,"."$wed,"."$thu,"."$fri,"."$sat";

        return $graph;
    }
}
