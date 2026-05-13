<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sektor;
use App\Models\Visualisasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class VisualisasiController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkRole:admin');
    }

    public function index()
    {
        $visualisasi = Visualisasi::where('kategori', 'dashboard')->get();
        $sektor = Sektor::all();
        $title = 'Hapus Visualisasi !';
        $text = 'Kamu yakin ingin Menghapus Visualisasi ini?';
        confirmDelete($title, $text);

        return view('super-admin.visualisasi.index', compact('visualisasi', 'sektor'));
    }

    public function storyboard()
    {
        $visualisasi = Visualisasi::where('kategori', 'storyboard')->get();
        $sektor = Sektor::all();
        $title = 'Hapus Visualisasi !';
        $text = 'Kamu yakin ingin Menghapus Visualisasi ini?';
        confirmDelete($title, $text);

        return view('super-admin.visualisasi.index', compact('visualisasi', 'sektor'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sektor = Sektor::all();

        return view('super-admin.visualisasi.tambah', compact('sektor'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|max:255',
            'deskripsi' => 'required|max:255',
            'url' => 'required',
            'kategori' => 'required',
            'gambar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'sektor' => 'required|max:255',
        ]);

        if ($request->gambar != null) {
            $imageName = time().'.'.$request->gambar->extension();
            $request->gambar->move(public_path('assets/visualisasi-thumbnail'), $imageName);
            Visualisasi::create([
                'judul' => $request->judul,
                'deskripsi' => $request->deskripsi,
                'url' => $request->url,
                'kategori' => $request->kategori,
                'gambar' => $imageName,
                'sektor' => $request->sektor,
            ]);
        } else {
            Visualisasi::create([
                'judul' => $request->judul,
                'deskripsi' => $request->deskripsi,
                'url' => $request->url,
                'kategori' => $request->kategori,
                'gambar' => 'img01.jpg',
                'sektor' => $request->sektor,
            ]);
        }
        (new AktivitasController)->store(Auth::user()->id, 'Menambahkan Visualisasi '.$request->judul, 'V1', Auth::user()->role);

        return redirect()->route('visualisasi.index')->with('success', 'Berhasil Menambahkan Visualisasi Baru !');
    }

    public function edit(string $id)
    {
        $visualisasi = Visualisasi::where('id', $id)->first();
        $sektor = Sektor::all();

        return view('super-admin.visualisasi.edit', compact('visualisasi', 'sektor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $visualisasi = Visualisasi::find($id);
        $request->validate([
            'judul' => 'required|max:255',
            'deskripsi' => 'required|max:255',
            'url' => 'required',
            'kategori' => 'required',
            'gambar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'sektor' => 'required|max:255',
        ]);

        if ($request->gambar != null) {
            if ($visualisasi->gambar != 'img01.jpg') {
                $image_path = public_path('assets/visualisasi-thumbnail/'.$visualisasi->gambar);
                if (File::exists($image_path)) {
                    File::delete($image_path);
                }
            }
            $imageName = time().'.'.$request->gambar->extension();
            $request->gambar->move(public_path('assets/visualisasi-thumbnail'), $imageName);
            Visualisasi::where('id', $id)->update([
                'judul' => $request->judul,
                'deskripsi' => $request->deskripsi,
                'url' => $request->url,
                'kategori' => $request->kategori,
                'gambar' => $imageName,
                'sektor' => $request->sektor,
            ]);
        } else {
            Visualisasi::where('id', $id)->update([
                'judul' => $request->judul,
                'deskripsi' => $request->deskripsi,
                'url' => $request->url,
                'kategori' => $request->kategori,
                'sektor' => $request->sektor,
            ]);
        }
        (new AktivitasController)->store(Auth::user()->id, 'Mengupdate Visualisasi '.$request->judul, 'V2', Auth::user()->role);

        return redirect()->route('visualisasi.index')->with('success', 'Berhasil Mengubah Data Visualisasi !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $visualisasi = Visualisasi::find($id);
        if ($visualisasi->gambar != 'img01.jpg') {
            $image_path = public_path('assets/visualisasi-thumbnail/'.$visualisasi->gambar);
            if (File::exists($image_path)) {
                File::delete($image_path);
            }
        }
        (new AktivitasController)->store(Auth::user()->id, 'Menghapus Visualisasi '.$visualisasi->judul, 'V3', Auth::user()->role);
        $visualisasi->delete();

        return redirect()->route('visualisasi.index')->with('success', 'Berhasil Menghapus Data Visualisasi !');
    }
}
