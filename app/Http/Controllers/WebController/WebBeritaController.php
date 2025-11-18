<?php

namespace App\Http\Controllers\WebController;

use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class WebBeritaController extends Controller
{
    public function index (Request $request){
        $builder = Berita::query();
        if ($request->input('judul')) {
            $queryString = $request->input('judul');
            $builder->where('judul', 'LIKE', "%$queryString%");
        }
        $berita = $builder->orderBy('created_at','desc')->paginate(8)->withQueryString();
        //$random_berita = Berita::whereMonth('created_at', Carbon::now()->month)->inRandomOrder()->take(5)->get();
        $random_berita = Berita::latest()->take(5)->get();
        return view('website-view.berita.index', compact('berita','random_berita'));
    }

    public function show ($id , $slug){
        $berita = Berita::where('id',$id)->where('slug',$slug)->first();
        $list = Berita::orderBy('created_at', 'desc')->limit(5)->get();
        return view('website-view.berita.show',compact('berita','list'));
    }
}
