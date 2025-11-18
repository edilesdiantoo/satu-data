<?php

namespace App\Http\Controllers\OPD;

use App\Models\User;
use App\Models\Berita;
use App\Models\Sektor;
use App\Models\Artikel;
use App\Models\Datasets;
use App\Models\Aktivitas;
use App\Models\Publikasi;
use App\Models\Infografis;
use App\Models\Visualisasi;
use Illuminate\Http\Request;
use App\Models\PermohonanData;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OpdDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkRole:opd');
    }   
    public function index()
    {
        $datasets = Datasets::where('diupload_oleh',Auth::user()->id)->where('status','APPROVED')->count();
        $infografis = Infografis::where('id_user',Auth::user()->id)->where('status','terverifikasi')->count();
        $artikel = Artikel::where('id_user',Auth::user()->id)->where('status','terverifikasi')->count();
        $produk_statistik = Publikasi::where('id_user',Auth::user()->id)->where('status','terverifikasi')->count();
        $sektor = Sektor::all();
        $jumlah_datasets = Datasets::where('diupload_oleh',Auth::user()->id)->count();
        $today = Datasets::where('diupload_oleh',Auth::user()->id)->whereDate('created_at', Carbon::today())->count();
        $week = Datasets::where('diupload_oleh',Auth::user()->id)->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();;
        $month = Datasets::where('diupload_oleh',Auth::user()->id)->whereMonth('created_at', date('m'))->count();
        $aktivitas = Aktivitas::where('id_user',Auth::user()->id)->orderBy('created_at', 'DESC')->paginate(6);
        $berita = Berita::latest()->take(3)->get();
        $user =  User::get(['id', 'name', 'photo']);
        return view('opd.index', compact('sektor','datasets','jumlah_datasets','infografis','artikel','produk_statistik', 'today', 'week', 'month', 'aktivitas', 'user','berita'));
    }

    public function kategori_data($id){
        $datasets = Datasets::where('sektor',$id)->where('sifat_datasets','PUBLIK')->where('status','APPROVED')->get();
        $sektor = Sektor::all();
        $idNode = $id;
        return view('opd.kategori-data.index',compact('sektor','datasets','idNode'));
    }

    static function getPermohonanMasuk($id_opd){
        $permohonan = PermohonanData::where('opd',$id_opd)->where('status','!=','terbit')->count();
        return $permohonan;
    }

    public static function getDatasetsBerbagiNotification($id_opd)
    {
        // Fetch datasets with shared status
        $datasets = DB::table('tbl_datasets_private')
            ->get();

        $count = 0;

        // Loop through datasets to check if `id_opd` is in `id_instansi`
        foreach ($datasets as $dataset) {
            $id_instansi = json_decode($dataset->id_instansi, true);
            if (in_array($id_opd, $id_instansi)) {
                $count++;
            }
        }

        return $count; // Return the count of datasets matching the condition
    }

    public static function grafik()
    {
        $stat = Datasets::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get();
        $sun = 0;
        $mon = 0;
        $tue = 0;
        $wed = 0;
        $thu = 0;
        $fri = 0;
        $sat = 0;
        foreach ($stat as $item) {
            if ($item->created_at->format('D') == "Sun") {
                $sun = $sun + 1;
            } elseif ($item->created_at->format('D') == "Mon") {
                $mon = $mon + 1;
            } elseif ($item->created_at->format('D') == "Tue") {
                $tue = $tue + 1;
            } elseif ($item->created_at->format('D') == "Wed") {
                $wed = $wed + 1;
            } elseif ($item->created_at->format('D') == "Thu") {
                $thu = $thu + 1;
            } elseif ($item->created_at->format('D') == "Fri") {
                $fri = $fri + 1;
            } elseif ($item->created_at->format('D') == "Sat") {
                $sat = $sat + 1;
            }
        }
        $graph = "$sun,"."$mon,"."$tue,"."$wed,"."$thu,"."$fri,"."$sat";
        return $graph;
    }
}
