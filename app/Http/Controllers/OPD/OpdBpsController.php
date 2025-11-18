<?php

namespace App\Http\Controllers\OPD;

use App\Models\BPS;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Admin\AktivitasController;

class OpdBpsController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkRole:opd');
    }

    public function index()
    {
        // Get the logged-in user's ID
        $userId = auth()->id();
        
        // Retrieve BPS data where uploaded_oleh matches the logged-in user's ID
        $bps = BPS::where('diupload_oleh', $userId)
                ->orderBy('created_at', 'desc')
                ->get();
        
        $title = 'Hapus Data !';
        $text = "Kamu yakin ingin Menghapus Data ini?";
        confirmDelete($title, $text);
        
        return view('opd.bps.index', compact('bps'));
    }   

    /**
     * Show the form for creating a new resource.
     */
    
    public function create()
    {
        $kategori = json_decode(Http::get('https://webapi.bps.go.id/v1/api/list/domain/1500/model/subcatcsa/key/97fb2e54e7ed024d54ca2825e6448e0d/')->body(), true);
        $demografi = json_decode(Http::get('https://webapi.bps.go.id/v1/api/list/domain/1500/model/subjectcsa/subcat/514/key/97fb2e54e7ed024d54ca2825e6448e0d/')->body(), true)['data'][1];
        $ekonomi = json_decode(Http::get('https://webapi.bps.go.id/v1/api/list/domain/1500/model/subjectcsa/subcat/515/key/97fb2e54e7ed024d54ca2825e6448e0d/')->body(), true)['data'][1];
        $lhdanmultidomain = json_decode(Http::get('https://webapi.bps.go.id/v1/api/list/domain/1500/model/subjectcsa/subcat/516/key/97fb2e54e7ed024d54ca2825e6448e0d/')->body(), true)['data'][1];
        return view ('opd.bps.tambah',['kategori'=>$kategori],compact('demografi','ekonomi','lhdanmultidomain'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kategori' => 'required|max:255',
            'sub_kategori' => 'required|max:255',
            'judul' => 'required|max:255',
            'link_api' => 'required|max:255',
        ]);
        
        BPS::create([
            'kategori' => $request->kategori,
            'sub_kategori' => $request->sub_kategori,
            'diupload_oleh' => Auth::user()->id,
            'judul' => $request->judul,
            'slug' => Str::slug($request->judul),
            'link_api' => $request->link_api,
        ]);
        (new AktivitasController)->store(Auth::user()->id, "Menambahkan Data API dengan Judul " . $request->judul, "BPS1", Auth::user()->role);
        return redirect()->route('opdbps.index')->with('success', 'Berhasil Menambahkan Data API Baru !');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $bps = BPS::where('id',$id)->first();
        $kategori = json_decode(Http::get('https://webapi.bps.go.id/v1/api/list/domain/1500/model/subcatcsa/key/97fb2e54e7ed024d54ca2825e6448e0d/')->body(), true);
        $demografi = json_decode(Http::get('https://webapi.bps.go.id/v1/api/list/domain/1500/model/subjectcsa/subcat/514/key/97fb2e54e7ed024d54ca2825e6448e0d/')->body(), true)['data'][1];
        $ekonomi = json_decode(Http::get('https://webapi.bps.go.id/v1/api/list/domain/1500/model/subjectcsa/subcat/515/key/97fb2e54e7ed024d54ca2825e6448e0d/')->body(), true)['data'][1];
        $lhdanmultidomain = json_decode(Http::get('https://webapi.bps.go.id/v1/api/list/domain/1500/model/subjectcsa/subcat/516/key/97fb2e54e7ed024d54ca2825e6448e0d/')->body(), true)['data'][1];
        return view ('opd.bps.edit',compact('bps','kategori','demografi','ekonomi','lhdanmultidomain'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'kategori' => 'required|max:255',
            'sub_kategori' => 'required|max:255',
            'judul' => 'required|max:255',
            'link_api' => 'required|max:255',
        ]);
        BPS::where('id',$id)->update([
            'kategori' => $request->kategori,
            'sub_kategori' => $request->sub_kategori,
            'judul' => $request->judul,
            'slug' => Str::slug($request->judul),
            'link_api' => $request->link_api,
        ]);
        (new AktivitasController)->store(Auth::user()->id, "Mengupdate Data API dengan Judul " . $request->judul, "BPS2", Auth::user()->role);
        return redirect()->route('opdbps.index')->with('success', 'Berhasil Mengupdate Data API !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $bps = BPS::find($id);
        $bps->delete();
        (new AktivitasController)->store(Auth::user()->id, "Menghapus Data dengan Judul " . $bps->judul, "BPS3", Auth::user()->role);
        return redirect()->route('opdbps.index')->with('success', 'Berhasil Menghapus Data !');
    }
}
