<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Datasets;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Charts\Admin\DatasetsBulananChart;
use App\Charts\Admin\MingguanDatasetsChart;

class GraphController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkRole:admin');
    }

    public function index(Request $request, DatasetsBulananChart $chart_bulanan , MingguanDatasetsChart $chart_mingguan)
    {
        $chart=null;
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
        $datasets = Datasets::groupBy('nama_opd')->select('nama_opd', DB::raw('count(*) as total'))->get();
        return view('super-admin.graph.index',compact('chart','datasets'),['chart_bulanan' => $chart_bulanan->build() , 'chart_mingguan' => $chart_mingguan->build()]);
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
