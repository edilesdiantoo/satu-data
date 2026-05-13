<?php

namespace App\Charts\WebView;

use App\Models\Datasets;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class WebDatasetsChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build($id, $index_x, $index_y): \ArielMejiaDev\LarapexCharts\BarChart
    {
        $datasets = Datasets::where('id', $id)
            ->where('sifat_datasets', 'PUBLIK')
            ->where('status', 'APPROVED')
            ->first();

        $table = Schema::getColumnListing($datasets->db_datasets); // Get table columns
        $kolom_x = $table[$index_x]; // Column for X axis
        $kolom_y = $table[$index_y]; // Column for Y axis

        // Mapping kode_kabupaten_kota ke nama kabupaten/kota
        $kode_kab_mapping = [
            '1501' => 'KERINCI',
            '1502' => 'MERANGIN',
            '1503' => 'SAROLANGUN',
            '1504' => 'BATANGHARI',
            '1505' => 'MUARO JAMBI',
            '1506' => 'TANJUNG JABUNG BARAT',
            '1507' => 'TANJUNG JABUNG TIMUR',
            '1508' => 'BUNGO',
            '1509' => 'TEBO',
            '1571' => 'KOTA JAMBI',
            '1572' => 'KOTA SUNGAI PENUH',
        ];

        // Determine the default grouping column (e.g., 'kode_kabupaten_kota')
        $temp_kolom = 'kode_kabupaten_kota';
        if (! Schema::hasColumn($datasets->db_datasets, $temp_kolom)) {
            $temp_kolom = $table[0]; // Fallback to first column if 'kode_kabupaten_kota' does not exist
        }

        // Fetch data from the selected columns
        $x_axis_labels = DB::table($datasets->db_datasets)
            ->select($kolom_x)
            ->distinct()
            ->pluck($kolom_x)
            ->toArray(); // Distinct X axis labels

        $y_data = [];
        foreach ($x_axis_labels as $label) {
            $y_data[] = DB::table($datasets->db_datasets)
                ->where($kolom_x, $label)
                ->sum($kolom_y); // Summing Y axis values
        }
        // Replace kode_kabupaten_kota with corresponding names
        $x_axis_labels_mapped = array_map(function ($kode_kab) use ($kode_kab_mapping) {
            return $kode_kab_mapping[$kode_kab] ?? $kode_kab; // If not found in mapping, keep the code
        }, $x_axis_labels);

        return $this->chart->barChart()
            ->setTitle('Grafik Datasets '.$datasets->judul)
            ->setSubtitle('Grafik berdasarkan '.$kolom_x.' dan '.$kolom_y)
            ->setDataset([
                [
                    'name' => $kolom_y,
                    'data' => $y_data,
                ],
            ])
            ->setXAxis($x_axis_labels)
            ->setGrid();
    }
}
