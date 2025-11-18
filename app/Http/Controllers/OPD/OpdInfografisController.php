<?php

namespace App\Http\Controllers\OPD;

use App\Models\User;
use App\Models\Sektor;
use App\Models\Infografis;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Admin\AktivitasController;

class OpdInfografisController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $infografis = Infografis::where('id_user',Auth::user()->id)->get();
        $user = User::get(['id','name']);
        $title = 'Hapus Infografis !';
        $text = "Kamu yakin ingin Menghapus Infografis ini?";
        confirmDelete($title, $text);
        return view('opd.infografis.index', compact('infografis','user'));
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sektor = Sektor::all();
        return view('opd.infografis.create',compact('sektor'));
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'judul' => 'required|max:255',
            'id_sektor' => 'required',
        ]);
        if ($request->gambar != null) {
            $imageName = time() . '.' . $request->gambar->extension();
            $request->gambar->move(public_path('assets/infografis'), $imageName);
            Infografis::create([
                'id_user'=>  Auth::user()->id,
                'judul' => $request->judul,
                'gambar' => $imageName,
                'status' => 'proses',
                'id_sektor' => $request->id_sektor,
            ]);
        } 
        (new AktivitasController)->store(Auth::user()->id, "Menambahkan Infografis " . $request->judul, "I1", Auth::user()->role);
        return redirect()->route('opd-infografis.index')->with('success', 'Berhasil Menambahkan Infografis Baru !');
    }
    
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }
    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $infografis = Infografis::where('id', $id)->where('id_user',Auth::user()->id)->first();
        $sektor = Sektor::all();
        return view('opd.infografis.edit',compact('infografis','sektor'));
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $infografis = Infografis::find($id);
        $request->validate([
            'gambar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'judul' => 'required|max:255',
            'id_sektor' => 'required',
        ]);

        if ($request->gambar != null) {
            if ($infografis->gambar != "img01.jpg") {
                $image_path = public_path('assets/infografis/' . $infografis->gambar);
                if (File::exists($image_path)) {
                    File::delete($image_path);
                }
            }
            $imageName = time() . '.' . $request->gambar->extension();
            $request->gambar->move(public_path('assets/infografis'), $imageName);
            infografis::where('id', $id)->update([
                'judul' => $request->judul,
                'gambar' => $imageName,
                'id_sektor' => $request->id_sektor,
            ]);
        } else {
            infografis::where('id', $id)->update([
                'judul' => $request->judul,
                'id_sektor' => $request->id_sektor,
            ]);
        }
        (new AktivitasController)->store(Auth::user()->id, "Mengupdate infografis " . $request->judul, "I2", Auth::user()->role);
        return redirect()->route('opd-infografis.index')->with('success', 'Berhasil Mengubah Data infografis !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $infografis = Infografis::find($id);
        if ($infografis->gambar != "img01.jpg") {
            $image_path = public_path('assets/infografis/' . $infografis->gambar);
            if (File::exists($image_path)) {
                File::delete($image_path);
            }
        }
        (new AktivitasController)->store(Auth::user()->id, "Menghapus infografis " . $infografis->judul, "I3", Auth::user()->role);
        $infografis->delete();
        return redirect()->route('opd-infografis.index')->with('success', 'Berhasil Menghapus Data infografis !');
    }
}
