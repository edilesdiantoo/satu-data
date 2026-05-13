<?php

namespace App\Http\Controllers\WebController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WebApiMetaDatasetsController extends Controller
{
    public function index(Request $request)
    {
        $bps = '';

        return view('website-view.metadata.index', compact('bps'));
    }
}
