<?php

namespace App\Charts\WebView;

use App\Models\Datasets;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class WebDatasetsLineChartAgenda
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    /**
     * @param  string  $id  ID dari tbl_agenda_datasets
     */
    public function build($id, $index_x, $index_y): \ArielMejiaDev\LarapexCharts\LineChart
    {
        // 1. Ambil data agenda (Sumber utama db_datasets)
        $agenda = DB::table('tbl_agenda_datasets')->where('id', $id)->first();

        if (! $agenda) {
            return $this->chart->lineChart()->setTitle('Data Agenda Tidak Ditemukan');
        }

        // 2. Ambil data induk untuk metadata judul
        $datasets = Datasets::where('id', $agenda->datasets_id)->first();

        // 3. Gunakan db_datasets milik agenda
        $db_name = $agenda->db_datasets;

        if (! Schema::hasTable($db_name)) {
            return $this->chart->lineChart()->setTitle('Tabel Data Belum Tersedia');
        }

        $table = Schema::getColumnListing($db_name);
        $total_kolom = count($table);

        // 4. Proteksi Indeks (Penting agar tidak error Key 4)
        $final_x = ($index_x >= $total_kolom) ? 0 : $index_x;
        $final_y = ($index_y >= $total_kolom) ? ($total_kolom > 0 ? $total_kolom - 1 : 0) : $index_y;

        $kolom_x = $table[$final_x];
        $kolom_y = $table[$final_y];

        // Mapping wilayah
        $kode_kab_mapping = [
            '1501' => 'KERINCI', '1502' => 'MERANGIN', '1503' => 'SAROLANGUN',
            '1504' => 'BATANGHARI', '1505' => 'MUARO JAMBI', '1506' => 'TANJUNG JABUNG BARAT',
            '1507' => 'TANJUNG JABUNG TIMUR', '1508' => 'BUNGO', '1509' => 'TEBO',
            '1571' => 'KOTA JAMBI', '1572' => 'KOTA SUNGAI PENUH',
        ];

        // 5. Fetch data dari tabel dinamis agenda
        $x_axis_labels = DB::table($db_name)
            ->select($kolom_x)
            ->distinct()
            ->whereNotNull($kolom_x)
            ->pluck($kolom_x)
            ->toArray();

        $y_data = [];
        foreach ($x_axis_labels as $label) {
            $y_data[] = DB::table($db_name)
                ->where($kolom_x, $label)
                ->sum($kolom_y);
        }

        // Mapping label X-Axis
        $x_axis_labels_mapped = array_map(function ($kode_kab) use ($kode_kab_mapping) {
            return $kode_kab_mapping[$kode_kab] ?? $kode_kab;
        }, $x_axis_labels);

        return $this->chart->lineChart()
            ->setTitle('Grafik Garis: '.($agenda->judul_rilis ?? $datasets->judul))
            ->setSubtitle('Berdasarkan '.str_replace('_', ' ', $kolom_x).' dan '.str_replace('_', ' ', $kolom_y))
            ->setDataset([
                [
                    'name' => str_replace('_', ' ', $kolom_y),
                    'data' => $y_data,
                ],
            ])
            ->setXAxis($x_axis_labels_mapped)
            ->setGrid();
    }
}
