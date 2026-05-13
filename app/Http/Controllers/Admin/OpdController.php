<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Opd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class OpdController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkRole:admin');
    }

    public function index()
    {
        $opd = Opd::all();
        $title = 'Hapus Nama OPD !';
        $text = 'Kamu yakin ingin Menghapus Nama OPD ini?';
        confirmDelete($title, $text);

        return view('super-admin.opd.index', compact('opd'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_opd' => 'required|unique:tbl_opd|max:255',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($request->gambar != null) {
            $imageName = time().'.'.$request->gambar->extension();
            $request->gambar->move(public_path('assets/opd'), $imageName);
            Opd::create([
                'nama_opd' => $request->nama_opd,
                'gambar' => $imageName,
            ]);
        }
        (new AktivitasController)->store(Auth::user()->id, 'Menambahkan OPD dengan Nama '.$request->nama_opd, 'OPD1', Auth::user()->role);

        return redirect()->route('opd.index')->with('success', 'Berhasil Menambahkan Data Baru !');
    }

    public function edit(string $id)
    {
        $opd = Opd::where('id', $id)->first();

        return view('super-admin.opd.edit', compact('opd'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $opd = Opd::find($id);
        $request->validate([
            'nama_opd' => 'required|max:255|unique:tbl_opd,nama_opd,'.$opd->id,
            'gambar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->gambar != null) {
            if ($opd->gambar != 'default.jpg') {
                $image_path = public_path('assets/opd/'.$opd->gambar);
                if (File::exists($image_path)) {
                    File::delete($image_path);
                }
            }
            $imageName = time().'.'.$request->gambar->extension();
            $request->gambar->move(public_path('assets/opd'), $imageName);
            Opd::where('id', $id)->update([
                'nama_opd' => $request->nama_opd,
                'gambar' => $imageName,
            ]);
        } else {
            Opd::where('id', $id)->update([
                'nama_opd' => $request->nama_opd,
            ]);
        }
        (new AktivitasController)->store(Auth::user()->id, 'Mengupdate OPD dengan Nama '.$request->nama_opd, 'OPD2', Auth::user()->role);

        return redirect()->route('opd.index')->with('success', 'Berhasil Merubah Data OPD !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $opd = Opd::find($id);
        if ($opd->gambar != 'default.jpg') {
            $image_path = public_path('assets/opd/'.$opd->gambar);
            if (File::exists($image_path)) {
                File::delete($image_path);
            }
        }
        $opd->delete();
        (new AktivitasController)->store(Auth::user()->id, 'Menghapus OPD dengan Nama '.$opd->nama_opd, 'OPD3', Auth::user()->role);

        return redirect()->route('opd.index')->with('success', 'Berhasil Menghapus Data !');
    }
}
