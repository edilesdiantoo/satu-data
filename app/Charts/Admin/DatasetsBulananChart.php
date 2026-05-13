<?php

namespace App\Charts\Admin;

use App\Models\Datasets;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class DatasetsBulananChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\BarChart
    {
        return $this->chart->barChart()
            ->addData('Datasets', [
                Datasets::whereYear('created_at', date('Y'))->whereMonth('created_at', '=', '01')->count(),
                Datasets::whereYear('created_at', date('Y'))->whereMonth('created_at', '=', '02')->count(),
                Datasets::whereYear('created_at', date('Y'))->whereMonth('created_at', '=', '03')->count(),
                Datasets::whereYear('created_at', date('Y'))->whereMonth('created_at', '=', '04')->count(),
                Datasets::whereYear('created_at', date('Y'))->whereMonth('created_at', '=', '05')->count(),
                Datasets::whereYear('created_at', date('Y'))->whereMonth('created_at', '=', '06')->count(),
                Datasets::whereYear('created_at', date('Y'))->whereMonth('created_at', '=', '07')->count(),
                Datasets::whereYear('created_at', date('Y'))->whereMonth('created_at', '=', '08')->count(),
                Datasets::whereYear('created_at', date('Y'))->whereMonth('created_at', '=', '09')->count(),
                Datasets::whereYear('created_at', date('Y'))->whereMonth('created_at', '=', '10')->count(),
                Datasets::whereYear('created_at', date('Y'))->whereMonth('created_at', '=', '11')->count(),
                Datasets::whereYear('created_at', date('Y'))->whereMonth('created_at', '=', '12')->count(),
            ])
            ->setXAxis(['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'July', 'Agustus', 'September', 'Oktober', 'November', 'Desember'])
            ->setGrid();
    }
}
