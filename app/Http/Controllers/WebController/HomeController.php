<?php

namespace App\Http\Controllers\WebController;

use App\Http\Controllers\Controller;
use App\Models\Artikel;
use App\Models\Berita;
use App\Models\BPS;
use App\Models\BukuDigital;
use App\Models\Datasets;
use App\Models\Gallery;
use App\Models\Infografis;
use App\Models\Opd;
use App\Models\Publikasi;
use App\Models\Sektor;
use App\Models\Visualisasi;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $count_datasets = Datasets::where('sifat_datasets', 'PUBLIK')->where('status', 'APPROVED')->count();
        $count_infografis = Infografis::where('status', 'terverifikasi')->count();
        $count_opd = Opd::count();
        $count_bps = BPS::count();
        $count_storyboard = Visualisasi::where('kategori', 'storyboard')->count();
        $count_publikasi = Publikasi::where('status', 'terverifikasi')->count();
        $datasets = Datasets::where('sifat_datasets', 'PUBLIK')->where('status', 'APPROVED')->latest()->take(5)->get();
        $specifiedId = 6;
        $visualisasi = Visualisasi::select('*')
            ->orderByRaw('id = ? DESC, created_at DESC', [$specifiedId])
            ->where('kategori', 'dashboard')
            ->get();

        $infografis = Infografis::where('status', 'terverifikasi')->latest()->take(6)->get();
        $storyboard = Visualisasi::where('kategori', 'storyboard')->latest()->take(6)->get();
        $sektor = Sektor::all();
        $publikasi = Publikasi::where('status', 'terverifikasi')->latest()->take(6)->get();
        $buku = BukuDigital::latest()->take(4)->get();
        $artikel = Artikel::latest()->take(6)->get();
        $berita = Berita::latest()->take(4)->get();
        $gallery = Gallery::latest()->take(8)->get();
        $ips = WebDatasetsController::getClientIps();
        $seen = DB::table('tbl_datasets_seen')->whereDate('created_at', Carbon::today())->where('ips', $ips)->where('id_datasets', 0)->first();
        if ($seen == null) {
            DB::table('tbl_datasets_seen')->insert([
                'id_datasets' => 0,
                'ips' => $ips,
            ]);
        }

        // $visitor_today = DB::table('tbl_datasets_seen')->whereDate('created_at', Carbon::today())->where('id_datasets',0)->count();
        $totalOpd = OPD::count();

        return view('website-view/index', compact('count_datasets', 'count_infografis', 'count_opd', 'count_bps', 'count_storyboard', 'count_publikasi', 'datasets', 'buku', 'artikel', 'berita', 'infografis', 'storyboard', 'visualisasi', 'sektor', 'publikasi', 'gallery'));
    }

    public static function getSektor($id)
    {
        $sektor = Sektor::where('id', $id)->first();

        return $sektor->nama_sektor;
    }

    public function storyboard(Request $request)
    {
        $sektor = Sektor::all();
        $builder = Visualisasi::query();
        if ($request->input('judul')) {
            $queryString = $request->input('judul');
            $builder->where('judul', 'LIKE', "%$queryString%");
        }
        if ($request->input('urut') == 'Terbaru') {
            $builder->latest();
        } elseif ($request->input('urut') == 'Abjad') {
            $builder->orderBy('judul');
        }
        if ($request->input('sektor')) {
            $queryString = $request->input('sektor');
            $builder->where('sektor', $queryString);
        }
        if ($request->input('record')) {
            $visualisasi = $builder->where('kategori', 'storyboard')->latest()->paginate($request->input('record'))->withQueryString();
        } else {
            $visualisasi = $builder->where('kategori', 'storyboard')->latest()->paginate(12)->withQueryString();
        }

        return view('website-view.storyboard.index', compact('visualisasi', 'sektor'));
    }

    public function show_visualisasi($id)
    {
        $visualisasi = Visualisasi::where('id', $id)->first();

        return view('website-view/visualisasi/show', compact('visualisasi'));
    }

    public function stunting_index()
    {
        return view('website-view/informasi/stunting');
    }

    public function buku(Request $request)
    {
        $sektor = Sektor::all();
        $builder = BukuDigital::query();
        if ($request->input('judul')) {
            $queryString = $request->input('judul');
            $builder->where('judul', 'LIKE', "%$queryString%");
        }
        if ($request->input('urut') == 'Terbaru') {
            $builder->latest();
        } elseif ($request->input('urut') == 'Abjad') {
            $builder->orderBy('judul');
        }
        if ($request->input('sektor')) {
            $queryString = $request->input('sektor');
            $builder->where('id_sektor', $queryString);
        }
        if ($request->input('record')) {
            $buku = $builder->paginate($request->input('record'))->withQueryString();
        } else {
            $buku = $builder->paginate(4)->withQueryString();
        }

        return view('website-view.buku-digital.index', compact('buku', 'sektor'));
    }

    public function organisasi(Request $request)
    {
        $builder = Opd::query();
        if ($request->input('judul')) {
            $queryString = $request->input('judul');
            $builder->where('nama_opd', 'LIKE', "%$queryString%");
        }
        if ($request->input('urut') == 'abjad') {
            $builder->orderBy('nama_opd');
        }
        if ($request->input('opd')) {
            $builder->where('id', $request->input('opd'));
        }
        $opd = $builder->get();
        $s_opd = opd::all();

        return view('website-view/organisasi/index', compact('opd', 's_opd'));
    }

    public static function count_organisasi(string $data)
    {
        return $count = Datasets::where('nama_opd', $data)->count();
    }
}
