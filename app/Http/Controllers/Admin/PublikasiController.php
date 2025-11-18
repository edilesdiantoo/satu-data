<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Sektor;
use App\Models\Publikasi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Admin\AktivitasController;

class PublikasiController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkRole:admin');
    }

    public function index()
    {
        $publikasi = Publikasi::latest()->get();
        $sektor = Sektor::all();
        $users = User::all();
        $title = 'Hapus Publikasi !';
        $text = "Kamu yakin ingin Menghapus Publikasi ini?";
        confirmDelete($title, $text);
        return view('super-admin.publikasi.index', compact('publikasi','users','sektor'));
    }

    public function create()
    {
        $sektor = Sektor::all();
        return view('super-admin.publikasi.tambah',compact('sektor'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|max:255',
            'id_sektor' => 'required|max:255',
            'cover' => 'required|mimes:jpeg,JPG,jpg,png|max:5048',
            'file' => 'required|mimes:pdf|max:10048',
            'deskripsi' => 'required',
        ]);
        $filename = null;
        $filename_cover = null;
            if ($request->file != null) {
                $filename = time() . '.' . $request->file->extension();
                $request->file->move(public_path('assets/publikasi'), $filename);
            }
            if ($request->cover != null) {
                $filename_cover = time() . '.' . $request->cover->extension();
                $request->cover->move(public_path('assets/cover-publikasi'), $filename_cover);
            }
            Publikasi::create([
                'id_user' => Auth::user()->id,
                'cover' => $filename_cover,
                'judul' => $request->judul,
                'id_sektor' => $request->id_sektor,
                'file' => $filename,
                'deskripsi' => $request->deskripsi,
                'status' => 'proses',
            ]);

        (new AktivitasController)->store(Auth::user()->id, "Menambahkan Publikasi dengan Nama " . $request->judul, "P1", Auth::user()->role);
        return redirect()->route('publikasi.index')->with('success', 'Berhasil Menambahkan Publikasi Baru !');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
       
    }
    
    public function edit(string $id)
    {
        $publikasi = Publikasi::where('id', $id)->first();
        $sektor = Sektor::all();
        return view('super-admin.publikasi.edit', compact('publikasi','sektor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'judul' => 'required|max:255',
            'id_sektor' => 'required|max:255',
            'cover' => 'mimes:jpeg,jpg,png|max:5048',
            'file' => 'mimes:pdf|max:10048',
            'deskripsi' => 'required',
            'status' => 'required',
        ]);
        $publikasi = Publikasi::find($id);
        $file = $publikasi->file;
        $cover = $publikasi->cover;

        if ($request->file != null) {
            $file_path = public_path('assets/publikasi/' . $file);
            if (File::exists($file_path)) {
                File::delete($file_path);
            }
            $file = time() . '.' . $request->file->extension();
            $request->file->move(public_path('assets/publikasi'), $file);
        }

        if ($request->cover != null) {
            $file_path = public_path('assets/cover-publikasi/' . $cover);
            if (File::exists($file_path)) {
                File::delete($file_path);
            }
            $cover = time() . '.' . $request->cover->extension();
            $request->cover->move(public_path('assets/cover-publikasi'), $cover);
        }

        Publikasi::where('id', $id)->update([
                'cover' => $cover,
                'judul' => $request->judul,
                'id_sektor' => $request->id_sektor,
                'file' => $file,
                'deskripsi' => $request->deskripsi,
                'status' => $request->status,
        ]);
        (new AktivitasController)->store(Auth::user()->id, "Mengubah Publikasi" . $request->judul, "P2", Auth::user()->role);
        return redirect()->route('publikasi.index')->with('success', 'Berhasil Merubah Publikasi !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $publikasi = Publikasi::find($id);
        $file_path = public_path('assets/publikasi/' . $publikasi->file);
        $file_path2 = public_path('assets/cover-publikasi/' . $publikasi->cover);
        if (File::exists($file_path)) {
            File::delete($file_path);
        }
        if (File::exists($file_path2)) {
            File::delete($file_path2);
        }
        (new AktivitasController)->store(Auth::user()->id, "Menghapus Publikasi dengan Nama " . $publikasi->judul, "P3", Auth::user()->role);
        $publikasi->delete();
        return redirect()->route('publikasi.index')->with('success', 'Data Berhasil dihapus !');
    }
}
