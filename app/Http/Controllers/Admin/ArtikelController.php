<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Artikel;
use App\Models\Sektor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ArtikelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $artikel = Artikel::all();
        $sektor = Sektor::all();
        $title = 'Hapus Artikel !';
        $text = 'Kamu yakin ingin Menghapus Artikel ini?';
        confirmDelete($title, $text);

        return view('super-admin.artikel.index', compact('artikel', 'sektor'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sektor = Sektor::all();

        return view('super-admin.artikel.create', compact('sektor'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'judul' => 'required|max:255',
            'status' => 'required|max:255',
            'isi' => 'required',
            'id_sektor' => 'required',
        ]);
        $statement = DB::select("show table status like 'tbl_artikel'");
        $latest_id = $statement[0]->Auto_increment;
        if ($request->gambar != null) {
            $imageName = time().'.'.$request->gambar->extension();
            $request->gambar->move(public_path('assets/artikel-thumbnail'), $imageName);
            Artikel::create([
                'id_user' => Auth::user()->id,
                'id_sektor' => $request->id_sektor,
                'judul' => $request->judul,
                'gambar' => $imageName,
                'status' => $request->status,
                'slug' => Str::slug($request->judul.$latest_id),
                'isi' => $request->isi,
            ]);
        }
        (new AktivitasController)->store(Auth::user()->id, 'Menambahkan Artikel '.$request->judul, 'A1', Auth::user()->role);

        return redirect()->route('artikel.index')->with('success', 'Berhasil Menambahkan Artikel Baru !');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $artikel = Artikel::where('id', $id)->first();
        $sektor = Sektor::all();

        return view('super-admin.artikel.edit', compact('artikel', 'sektor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $artikel = Artikel::find($id);
        $request->validate([
            'gambar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'judul' => 'required|max:255',
            'status' => 'required|max:255',
            'isi' => 'required',
            'id_sektor' => 'required',
        ]);

        if ($request->gambar != null) {
            if ($artikel->gambar != 'img01.jpg') {
                $image_path = public_path('assets/artikel-thumbnail/'.$artikel->gambar);
                if (File::exists($image_path)) {
                    File::delete($image_path);
                }
            }
            $imageName = time().'.'.$request->gambar->extension();
            $request->gambar->move(public_path('assets/artikel-thumbnail'), $imageName);
            Artikel::where('id', $id)->update([
                'id_sektor' => $request->id_sektor,
                'judul' => $request->judul,
                'gambar' => $imageName,
                'status' => $request->status,
                'slug' => Str::slug($request->judul.$id),
                'isi' => $request->isi,
            ]);
        } else {
            Artikel::where('id', $id)->update([
                'id_sektor' => $request->id_sektor,
                'judul' => $request->judul,
                'status' => $request->status,
                'slug' => Str::slug($request->judul.$id),
                'isi' => $request->isi,
            ]);
        }
        (new AktivitasController)->store(Auth::user()->id, 'Mengupdate Artikel '.$request->judul, 'A2', Auth::user()->role);

        return redirect()->route('artikel.index')->with('success', 'Berhasil Mengubah Data Artikel !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $artikel = Artikel::find($id);
        if ($artikel->gambar != 'img01.jpg') {
            $image_path = public_path('assets/artikel-thumbnail/'.$artikel->gambar);
            if (File::exists($image_path)) {
                File::delete($image_path);
            }
        }
        (new AktivitasController)->store(Auth::user()->id, 'Menghapus Artikel '.$artikel->judul, 'A3', Auth::user()->role);
        $artikel->delete();

        return redirect()->route('artikel.index')->with('success', 'Berhasil Menghapus Data artikel !');
    }
}
