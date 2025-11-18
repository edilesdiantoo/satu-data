<?php

namespace App\Http\Controllers\WebController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Datasets;
use Carbon\Carbon;



class WebAgendaController extends Controller
{
    // WebAgendaController.php
    public function index(Request $request)
    {
        // Validasi bulan dan tahun dari query string
        $validated = $request->validate([
            'month' => 'nullable|integer|min:0|max:11',        // Pastikan bulan antara 0 dan 11
            'year'  => 'nullable|integer|min:1900|max:9999',   // Pastikan tahun valid
        ]);

        $month = $validated['month'] ?? 10;  // Default November jika tidak ada bulan yang diberikan
        $year = $validated['year'] ?? 2025;  // Default tahun 2025

        // Pastikan bulan berada dalam rentang yang benar (0-11)
        $month = max(0, min(11, $month));

        // Mengambil data berdasarkan bulan dan tahun yang dipilih
        $data = Datasets::selectRaw('DATE(created_at) as date, count(id) as count')
                        ->whereYear('created_at', $year)
                        ->whereMonth('created_at', $month + 1)  // Menambahkan 1 karena MySQL bulan dimulai dari 1
                        ->groupBy('date')
                        ->get();

        // Mengambil data untuk menampilkan di tabel
        $getMonth = Datasets::whereYear('created_at', $year)
                            // ->whereMonth('created_at', $month + 1) // Menambahkan 1 karena bulan di MySQL mulai dari 1
                            ->get();

        // Format data untuk kalender (events)
        $events = [];
        foreach ($data as $datum) {
            $events[] = [
                'title' => $datum->count . ' Kegiatan',
                'start' => Carbon::parse($datum->date)->format('Y-m-d'), // Format tanggal yang sesuai
            ];
        }

        // Jika permintaan AJAX, hanya mengirimkan data tabel
        if ($request->ajax()) {
            $data = [];
            foreach ($getMonth as $event) {
                $data[] = [
                    'judul'      => $event->judul,
                    'nama_opd'   => $event->nama_opd,
                    'id'         => $event->id,
                    'created_at' => $event->created_at->format('d-m-Y'),
                    'status'     => $event->status
                ];
            }
            return response()->json(['data' => $data]);
        }

        $datasetCount = Datasets::count();

        
        return view('website-view.agenda.index', compact('events', 'getMonth', 'month', 'year','datasetCount'));
    }


    public function getEventDetails(Request $request)
    {
        // Ambil data berdasarkan tanggal yang diklik
        $date = $request->date;

        // Gunakan Carbon untuk memastikan format tanggal sesuai dengan YYYY-MM-DD
        $date = Carbon::parse($date)->format('Y-m-d');

        // Ambil data berdasarkan tanggal (tanpa memperhitungkan waktu)
        $events = Datasets::whereDate('created_at', $date)->get();

        // Mengembalikan data dalam format JSON
        return response()->json($events);
    }

    public function getEventsByYear(Request $request)
    {
        $validated = $request->validate([
            'year' => 'required|integer|min:1900|max:9999',
        ]);
        $year = $validated['year'];

        // Ambil data berdasarkan tahun
        $data = Datasets::selectRaw('YEAR(created_at) as year, count(id) as count')
            ->whereYear('created_at', $year)  // Mengambil data berdasarkan tahun
            ->groupBy('year')
            ->get();

        $events = [];
        foreach ($data as $d) {
            $events[] = [
                'title' => $d->count . ' Kegiatan',
                'start' => \Carbon\Carbon::parse($d->year)->format('Y'),
            ];
        }

        return response()->json($events);
    }


    // PERBULAN 
    public function getEventsByMonth(Request $request)
    {
        $validated = $request->validate([
            'month' => 'required|integer|min:1|max:12',
            'year'  => 'required|integer|min:1900|max:9999',
        ]);
        $month = $validated['month']; // sudah 1..12
        $year  = $validated['year'];

        $data = Datasets::selectRaw('DATE(created_at) as date, count(id) as count')
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)   // gunakan langsung $month
            ->groupBy('date')
            ->get();

        $events = [];
        foreach ($data as $d) {
            $events[] = [
                'title' => $d->count . ' Kegiatan',
                'start' => \Carbon\Carbon::parse($d->date)->format('Y-m-d'),
            ];
        }

        return response()->json($events);

    }

}
