<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class BeritaController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkRole:admin');
    }

    public function index()
    {
        $berita = Berita::all();
        $title = 'Hapus Berita !';
        $text = 'Kamu yakin ingin Menghapus Berita ini?';
        confirmDelete($title, $text);

        return view('super-admin.berita.index', compact('berita'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('super-admin.berita.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'judul' => 'required|max:255',
            'isi' => 'required',
        ]);
        $statement = DB::select("show table status like 'tbl_berita'");
        $latest_id = $statement[0]->Auto_increment;
        if ($request->gambar != null) {
            $imageName = time().'.'.$request->gambar->extension();
            $request->gambar->move(public_path('assets/berita-thumbnail'), $imageName);
            Berita::create([
                'judul' => $request->judul,
                'gambar' => $imageName,
                'slug' => Str::slug($request->judul.$latest_id),
                'isi' => $request->isi,
            ]);
        }
        (new AktivitasController)->store(Auth::user()->id, 'Menambahkan Berita '.$request->judul, 'B1', Auth::user()->role);

        return redirect()->route('berita.index')->with('success', 'Berhasil Menambahkan Berita Baru !');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $berita = Berita::where('id', $id)->first();

        return view('super-admin.berita.edit', compact('berita'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $berita = Berita::find($id);
        $request->validate([
            'gambar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'judul' => 'required|max:255',
            'isi' => 'required',
        ]);

        if ($request->gambar != null) {
            if ($berita->gambar != 'img01.jpg') {
                $image_path = public_path('assets/berita-thumbnail/'.$berita->gambar);
                if (File::exists($image_path)) {
                    File::delete($image_path);
                }
            }
            $imageName = time().'.'.$request->gambar->extension();
            $request->gambar->move(public_path('assets/berita-thumbnail'), $imageName);
            Berita::where('id', $id)->update([
                'judul' => $request->judul,
                'gambar' => $imageName,
                'slug' => Str::slug($request->judul.$id),
                'isi' => $request->isi,
            ]);
        } else {
            Berita::where('id', $id)->update([
                'judul' => $request->judul,
                'slug' => Str::slug($request->judul.$id),
                'isi' => $request->isi,
            ]);
        }
        (new AktivitasController)->store(Auth::user()->id, 'Mengupdate berita '.$request->judul, 'B2', Auth::user()->role);

        return redirect()->route('berita.index')->with('success', 'Berhasil Mengubah Data Berita !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $berita = Berita::find($id);
        if ($berita->gambar != 'img01.jpg') {
            $image_path = public_path('assets/berita-thumbnail/'.$berita->gambar);
            if (File::exists($image_path)) {
                File::delete($image_path);
            }
        }
        (new AktivitasController)->store(Auth::user()->id, 'Menghapus berita '.$berita->judul, 'B3', Auth::user()->role);
        $berita->delete();

        return redirect()->route('berita.index')->with('success', 'Berhasil Menghapus Data berita !');
    }
}
