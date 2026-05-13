<?php

namespace App\Http\Controllers\WebController;

use App\Http\Controllers\Controller;
use App\Models\Publikasi;
use App\Models\Sektor;
use Illuminate\Http\Request;

class WebPublikasiController extends Controller
{
    public function index(Request $request)
    {
        $sektor = Sektor::all();
        $builder = Publikasi::query();
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
            $publikasi = $builder->paginate($request->input('record'))->withQueryString();
        } else {
            $publikasi = $builder->paginate(12)->withQueryString();
        }

        return view('website-view.publikasi.index', compact('publikasi', 'sektor'));
    }

    public function show($id)
    {
        $publikasi = Publikasi::where('id', $id)->first();
        $list = Publikasi::inRandomOrder()->limit(5)->get();

        return view('website-view.publikasi.show', compact('publikasi', 'list'));
    }
}
