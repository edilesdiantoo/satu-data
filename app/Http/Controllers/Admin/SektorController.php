<?php

namespace App\Http\Controllers\Admin;

use App\Models\Sektor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SektorController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkRole:admin');
    }
    public function index()
    {
        $sektor = Sektor::all();
        $main_sektor = DB::table('tbl_main_sektor')->get();
        $title = 'Hapus Sektor !';
        $text = "Kamu yakin ingin Menghapus Sektor ini?";
        confirmDelete($title, $text);
        return view('super-admin.sektor.index', compact('sektor','main_sektor'));
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_main_sektor' => 'required',
            'icon' => 'required',
            'nama_sektor' => 'required|unique:tbl_sektor|max:255',
        ]);
        Sektor::create([
            'id_main_sektor'=>$request->id_main_sektor,
            'icon' => $request->icon,
            'nama_sektor' => $request->nama_sektor,
        ]);
        (new AktivitasController)->store(Auth::user()->id, "Menambahkan Nama Sektor " . $request->nama_sektor, "S1", Auth::user()->role);
        return redirect()->route('sektor.index')->with('success', 'Berhasil Menambahkan Data Baru !');
    }
    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $sektor = Sektor::where('id', $id)->first();
        $main_sektor = DB::table('tbl_main_sektor')->get();
        return view('super-admin.sektor.edit', compact('sektor','main_sektor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'id_main_sektor' => 'required',
            'icon' => 'required',
            'nama_sektor' => 'required',
        ]);
        Sektor::where('id',$id)->update([
            'id_main_sektor'=>$request->id_main_sektor,
            'icon'=>$request->icon,
            'nama_sektor' => $request->nama_sektor,
        ]);
        (new AktivitasController)->store(Auth::user()->id, "Mengupdate Nama Sektor " . $request->nama_sektor, "S2", Auth::user()->role);
        return redirect()->route('sektor.index')->with('success', 'Berhasil Merubah Data Sektor !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $sektor = Sektor::find($id);
        (new AktivitasController)->store(Auth::user()->id, "Menghapus Nama Sektor " . $sektor->nama_sektor, "S3", Auth::user()->role);
        $sektor->delete();
        return redirect()->route('sektor.index')->with('success', 'Berhasil Menghapus Data !');
    }
}
