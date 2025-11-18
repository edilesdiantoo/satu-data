<?php

namespace App\Charts\Opd;

use App\Models\Datasets;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class OpdMingguanDatasetsChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\LineChart
    {
        $stat = Datasets::where('diupload_oleh',Auth::user()->id)->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get();
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
        return $this->chart->lineChart()
            ->addData('Datasets', [
                $mon,$tue,$wed,$thu,$fri,$sat,$sun  
            ])
            ->setXAxis(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu','Minggu'])
            ->setGrid();
    }
}
