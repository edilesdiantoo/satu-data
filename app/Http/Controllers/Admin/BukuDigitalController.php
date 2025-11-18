<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Sektor;
use App\Models\BukuDigital;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class BukuDigitalController extends Controller
{
    public function index()
    {
        $buku = BukuDigital::all();
        $sektor = Sektor::all();
        $user = User::get(['id','name']);
        $title = 'Hapus Buku Digital !';
        $text = "Kamu yakin ingin Menghapus Buku digital ini?";
        confirmDelete($title, $text);
        return view('super-admin.buku-digital.index', compact('buku','user','sektor'));
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sektor = Sektor::all();
        return view('super-admin.buku-digital.create',compact('sektor'));
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'cover' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'judul' => 'required|max:255',
            'id_sektor' => 'required|max:255',
            'url' => 'required|max:550',
        ]);
        if ($request->cover != null) {
            $imageName = time() . '.' . $request->cover->extension();
            $request->cover->move(public_path('assets/buku'), $imageName);
            BukuDigital::create([
                'id_users'=>  Auth::user()->id,
                'judul' => $request->judul,
                'id_sektor' => $request->id_sektor,
                'url' => $request->url,
                'cover' => $imageName,
                
            ]);
        } 
        (new AktivitasController)->store(Auth::user()->id, "Menambahkan Buku Digital " . $request->judul, "BD1", Auth::user()->role);
        return redirect()->route('buku-digital.index')->with('success', 'Berhasil Menambahkan Buku Digital Baru !');
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
        $buku = BukuDigital::where('id',$id)->first();
        $sektor = Sektor::all();
        return view('super-admin.buku-digital.edit',compact('buku','sektor'));
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $buku = BukuDigital::find($id);
        $request->validate([
            'cover' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'judul' => 'required|max:255',
            'id_sektor' => 'required|max:255',
            'url' => 'required|max:550',
        ]);

        if ($request->cover != null) {
            if ($buku->cover != "img01.jpg") {
                $image_path = public_path('assets/buku/' . $buku->cover);
                if (File::exists($image_path)) {
                    File::delete($image_path);
                }
            }
            $imageName = time() . '.' . $request->cover->extension();
            $request->cover->move(public_path('assets/buku'), $imageName);
            BukuDigital::where('id', $id)->update([
                'judul' => $request->judul,
                'id_sektor' => $request->id_sektor,
                'url' => $request->url,
                'cover' => $imageName,
            ]);
        } else {
            BukuDigital::where('id', $id)->update([
                'judul' => $request->judul,
                'id_sektor' => $request->id_sektor,
                'url' => $request->url,
            ]);
        }
        (new AktivitasController)->store(Auth::user()->id, "Mengupdate Buku Digital " . $request->judul, "BD2", Auth::user()->role);
        return redirect()->route('buku-digital.index')->with('success', 'Berhasil Mengubah Data Buku Digital !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $buku = BukuDigital::find($id);
        if ($buku->cover != "img01.jpg") {
            $image_path = public_path('assets/buku/' . $buku->cover);
            if (File::exists($image_path)) {
                File::delete($image_path);
            }
        }
        (new AktivitasController)->store(Auth::user()->id, "Menghapus Buku Digital " . $buku->judul, "BD3", Auth::user()->role);
        $buku->delete();
        return redirect()->route('buku-digital.index')->with('success', 'Berhasil Menghapus Data Digital !');
    }
}
