<?php

namespace App\Http\Controllers\WebController;

use App\Http\Controllers\Controller;
use App\Models\Artikel;
use App\Models\Sektor;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class WebArtikelController extends Controller
{
    public function index(Request $request)
    {
        $sektor = Sektor::all();
        $builder = Artikel::query();
        if ($request->input('judul')) {
            $queryString = $request->input('judul');
            $builder->where('judul', 'LIKE', "%$queryString%");
        }
        if ($request->input('urut')) {
            $queryString = $request->input('urut');
            if ($queryString == 'terbaru') {
                $builder->orderBy('updated_at', 'DESC');
            } elseif ($queryString == 'abjad') {
                $builder->orderBy('judul');
            }
        }
        if ($request->input('sektor')) {
            $queryString = $request->input('sektor');
            $builder->where('id_sektor', $queryString);
        }
        if ($request->input('record')) {
            $artikel = $builder->where('status', 'publish')->orderBy('updated_at', 'DESC')->paginate($request->input('record'))->withQueryString();
        } else {
            $artikel = $builder->where('status', 'publish')->orderBy('updated_at', 'DESC')->paginate(20)->withQueryString();
        }
        $random_artikel = Artikel::where('status', 'publish')->whereMonth('created_at', Carbon::now()->month)->inRandomOrder()->take(5)->get();

        return view('website-view.artikel.index', compact('artikel', 'random_artikel', 'sektor'));
    }

    public function show($id, $slug)
    {
        $artikel = Artikel::where('id', $id)->where('slug', $slug)->first();
        $list = Artikel::inRandomOrder()->limit(5)->get();

        return view('website-view.artikel.show', compact('artikel', 'list'));
    }
}
