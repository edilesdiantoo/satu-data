<?php

namespace App\Http\Controllers\WebController;

use App\Models\Gallery;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class WebGalleryController extends Controller
{
    public function show ($id , $slug){
        $gallery = Gallery::where('id',$id)->where('slug',$slug)->first();
        $list = Gallery::inRandomOrder()->limit(5)->get();
        return view('website-view.gallery.show',compact('gallery','list'));
    }
}
