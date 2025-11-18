<?php

namespace App\Http\Controllers\OPD;

use Carbon\Carbon;
use App\Models\Datasets;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Charts\Opd\OpdDatasetsBulananChart;
use App\Charts\Opd\OpdMingguanDatasetsChart;

class OpdGraphController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkRole:opd');
    }

    public function index(OpdDatasetsBulananChart $chart , OpdMingguanDatasetsChart $chart_mingguan)
    {
        $datasets = Datasets::groupBy('nama_opd')->select('nama_opd', DB::raw('count(*) as total'))->get();
        return view('opd.graph.index',['chart' => $chart->build() , 'chart_mingguan' => $chart_mingguan->build()], compact('datasets'));
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
            if ($item->created_at->format('D') == "Sun") {
                $sun = $sun + 1;
            } elseif ($item->created_at->format('D') == "Mon") {
                $mon = $mon + 1;
            } elseif ($item->created_at->format('D') == "Tue") {
                $tue = $tue + 1;
            } elseif ($item->created_at->format('D') == "Wed") {
                $wed = $wed + 1;
            } elseif ($item->created_at->format('D') == "Thu") {
                $thu = $thu + 1;
            } elseif ($item->created_at->format('D') == "Fri") {
                $fri = $fri + 1;
            } elseif ($item->created_at->format('D') == "Sat") {
                $sat = $sat + 1;
            }
        }
        $graph = "$sun," . "$mon," . "$tue," . "$wed," . "$thu," . "$fri," . "$sat";
        return $graph;
    }
}
