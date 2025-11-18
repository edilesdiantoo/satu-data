<?php

namespace App\Charts\Opd;

use App\Models\Datasets;
use Illuminate\Support\Facades\Auth;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class OpdDatasetsBulananChart
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
            Datasets::where('diupload_oleh',Auth::user()->id)->whereYear('created_at', date("Y"))->whereMonth('created_at', '=', "01")->count(), 
            Datasets::where('diupload_oleh',Auth::user()->id)->whereYear('created_at', date("Y"))->whereMonth('created_at', '=', "02")->count(), 
            Datasets::where('diupload_oleh',Auth::user()->id)->whereYear('created_at', date("Y"))->whereMonth('created_at', '=', "03")->count(), 
            Datasets::where('diupload_oleh',Auth::user()->id)->whereYear('created_at', date("Y"))->whereMonth('created_at', '=', "04")->count(), 
            Datasets::where('diupload_oleh',Auth::user()->id)->whereYear('created_at', date("Y"))->whereMonth('created_at', '=', "05")->count(), 
            Datasets::where('diupload_oleh',Auth::user()->id)->whereYear('created_at', date("Y"))->whereMonth('created_at', '=', "06")->count(), 
            Datasets::where('diupload_oleh',Auth::user()->id)->whereYear('created_at', date("Y"))->whereMonth('created_at', '=', "07")->count(), 
            Datasets::where('diupload_oleh',Auth::user()->id)->whereYear('created_at', date("Y"))->whereMonth('created_at', '=', "08")->count(), 
            Datasets::where('diupload_oleh',Auth::user()->id)->whereYear('created_at', date("Y"))->whereMonth('created_at', '=', "09")->count(), 
            Datasets::where('diupload_oleh',Auth::user()->id)->whereYear('created_at', date("Y"))->whereMonth('created_at', '=', "10")->count(), 
            Datasets::where('diupload_oleh',Auth::user()->id)->whereYear('created_at', date("Y"))->whereMonth('created_at', '=', "11")->count(), 
            Datasets::where('diupload_oleh',Auth::user()->id)->whereYear('created_at', date("Y"))->whereMonth('created_at', '=', "12")->count(), 
            ])
        ->setXAxis(['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni','July','Agustus','September','Oktober','November','Desember'])
        ->setGrid();
    }
}
