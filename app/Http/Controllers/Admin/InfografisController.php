<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Infografis;
use App\Models\Sektor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class InfografisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $infografis = Infografis::all();
        $sektor = Sektor::all();
        $user = User::get(['id', 'name']);
        $title = 'Hapus Infografis !';
        $text = 'Kamu yakin ingin Menghapus Infografis ini?';
        confirmDelete($title, $text);

        return view('super-admin.infografis.index', compact('infografis', 'user', 'sektor'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sektor = Sektor::all();

        return view('super-admin.infografis.create', compact('sektor'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'judul' => 'required|max:255',
            'id_sektor' => 'required|max:255',
        ]);
        if ($request->gambar != null) {
            $imageName = time().'.'.$request->gambar->extension();
            $request->gambar->move(public_path('assets/infografis'), $imageName);
            Infografis::create([
                'id_user' => Auth::user()->id,
                'judul' => $request->judul,
                'id_sektor' => $request->id_sektor,
                'gambar' => $imageName,
                'status' => 'proses',
            ]);
        }
        (new AktivitasController)->store(Auth::user()->id, 'Menambahkan Infografis '.$request->judul, 'I1', Auth::user()->role);

        return redirect()->route('infografis.index')->with('success', 'Berhasil Menambahkan Infografis Baru !');
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
        $infografis = Infografis::where('id', $id)->first();
        $sektor = Sektor::all();

        return view('super-admin.infografis.edit', compact('infografis', 'sektor'));
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
            'id_sektor' => 'required|max:255',
        ]);

        if ($request->gambar != null) {
            if ($infografis->gambar != 'img01.jpg') {
                $image_path = public_path('assets/infografis/'.$infografis->gambar);
                if (File::exists($image_path)) {
                    File::delete($image_path);
                }
            }
            $imageName = time().'.'.$request->gambar->extension();
            $request->gambar->move(public_path('assets/infografis'), $imageName);
            infografis::where('id', $id)->update([
                'judul' => $request->judul,
                'id_sektor' => $request->id_sektor,
                'gambar' => $imageName,
                'status' => $request->status,
            ]);
        } else {
            infografis::where('id', $id)->update([
                'judul' => $request->judul,
                'id_sektor' => $request->id_sektor,
                'status' => $request->status,
            ]);
        }
        (new AktivitasController)->store(Auth::user()->id, 'Mengupdate infografis '.$request->judul, 'I2', Auth::user()->role);

        return redirect()->route('infografis.index')->with('success', 'Berhasil Mengubah Data infografis !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $infografis = Infografis::find($id);
        if ($infografis->gambar != 'img01.jpg') {
            $image_path = public_path('assets/infografis/'.$infografis->gambar);
            if (File::exists($image_path)) {
                File::delete($image_path);
            }
        }
        (new AktivitasController)->store(Auth::user()->id, 'Menghapus infografis '.$infografis->judul, 'I3', Auth::user()->role);
        $infografis->delete();

        return redirect()->route('infografis.index')->with('success', 'Berhasil Menghapus Data infografis !');
    }
}
