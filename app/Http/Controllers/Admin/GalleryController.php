<?php

namespace App\Http\Controllers\Admin;

use App\Models\Gallery;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Admin\AktivitasController;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('checkRole:admin');
    }
    public function index()
    {
        $gallery = Gallery::all();
        $title = 'Hapus Gallery !';
        $text = "Kamu yakin ingin Menghapus Gallery ini?";
        confirmDelete($title, $text);
        return view('super-admin.gallery.index', compact('gallery'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('super-admin.gallery.create');
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
        $statement = DB::select("show table status like 'tbl_gallery'");
        $latest_id = $statement[0]->Auto_increment;
        if ($request->gambar != null) {
            $imageName = time() . '.' . $request->gambar->extension();
            $request->gambar->move(public_path('assets/gallery-thumbnail'), $imageName);
            Gallery::create([
                'judul' => $request->judul,
                'gambar' => $imageName,
                'slug' => Str::slug($request->judul.$latest_id),
                'isi' => $request->isi,
            ]);
        } 
        (new AktivitasController)->store(Auth::user()->id, "Menambahkan Gallery " . $request->judul, "B1", Auth::user()->role);
        return redirect()->route('gallery.index')->with('success', 'Berhasil Menambahkan Gallery Baru !');
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
        $gallery = Gallery::where('id',$id)->first();
        return view('super-admin.gallery.edit',compact('gallery'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $gallery= Gallery::find($id);
        $request->validate([
            'gambar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'judul' => 'required|max:255',
            'isi' => 'required',
        ]);

        if ($request->gambar != null) {
            if ($gallery->gambar != "img01.jpg") {
                $image_path = public_path('assets/gallery-thumbnail/' . $gallery->gambar);
                if (File::exists($image_path)) {
                    File::delete($image_path);
                }
            }
            $imageName = time() . '.' . $request->gambar->extension();
            $request->gambar->move(public_path('assets/gallery-thumbnail'), $imageName);
            Gallery::where('id', $id)->update([
                'judul' => $request->judul,
                'gambar' => $imageName,
                'slug' => Str::slug($request->judul.$id),
                'isi' => $request->isi,
            ]);
        } else {
            Gallery::where('id', $id)->update([
                'judul' => $request->judul,
                'slug' => Str::slug($request->judul.$id),
                'isi' => $request->isi,
            ]);
        }
        (new AktivitasController)->store(Auth::user()->id, "Mengupdate gallery " . $request->judul, "B2", Auth::user()->role);
        return redirect()->route('gallery.index')->with('success', 'Berhasil Mengubah Data Gallery !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $gallery = Gallery::find($id);
        if ($gallery->gambar != "img01.jpg") {
            $image_path = public_path('assets/gallery-thumbnail/' . $gallery->gambar);
            if (File::exists($image_path)) {
                File::delete($image_path);
            }
        }
        (new AktivitasController)->store(Auth::user()->id, "Menghapus gallery " . $gallery->judul, "B3", Auth::user()->role);
        $gallery->delete();
        return redirect()->route('gallery.index')->with('success', 'Berhasil Menghapus Data gallery !');
    }
}
