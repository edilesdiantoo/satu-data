<?php

namespace App\Http\Controllers\WebController;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class WilayahController extends Controller
{
    public static function wilayah($kode)
    {
        $wilayah = DB::table('tbl_wilayah')->where('kode', $kode)->first();

        return $wilayah;
    }
}
