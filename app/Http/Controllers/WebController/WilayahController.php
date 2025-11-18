<?php

namespace App\Http\Controllers\WebController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class WilayahController extends Controller
{
    public static function wilayah($kode){
        $wilayah = DB::table('tbl_wilayah')->where('kode',$kode)->first();
        return $wilayah;
    }
}
