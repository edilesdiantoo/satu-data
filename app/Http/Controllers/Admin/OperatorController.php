<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Opd;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\File;


class OperatorController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkRole:admin');
    }
    public function index()
    {
        $users = User::where('role', 'admin')->get();
        $opd = Opd::all();
        $title = 'Hapus Operator !';
        $text = "Kamu yakin ingin Menghapus Operator ini?";
        confirmDelete($title, $text);
        return view('super-admin.operator.index', compact('users', 'opd'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $opd = Opd::all();
        return view('super-admin.operator.tambah', compact('opd'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_opd' => 'required',
            'name' => 'required|max:255',
            'email' => 'required|unique:users|max:255',
            'password' => 'required|confirmed|max:255',
            'photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if ($request->photo != null) {
            $imageName = time() . '.' . $request->photo->extension();
            $request->photo->move(public_path('assets/photo-profile'), $imageName);
            user::create([
                'id_opd' => $request->id_opd,
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => "admin",
                'photo' => $imageName,
            ]);
        } else {
            user::create([
                'id_opd' => $request->id_opd,
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => "admin",
                'photo' => "avatar-1.png",
            ]);
        }
        (new AktivitasController)->store(Auth::user()->id, "Menambahkan Operator dengan Nama " . $request->name, "O1", Auth::user()->role);
        return redirect()->route('operator.index')->with('success', 'Berhasil Menambahkan Data Baru !');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $users = User::where('id', $id)->first();
        $opd = Opd::all();
        return view('super-admin.operator.edit', compact('users', 'opd'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $users = User::find($id);
        $request->validate([
            'id_opd' => 'required',
            'name' => 'required|max:255',
            'email' => 'required|max:255|unique:users,email,' . $id,
            'password' => 'confirmed|max:255',
            'photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if ($request->photo != null) {
            if ($users->photo != "avatar-1.png") {
                $image_path = public_path('assets/photo-profile/' . $users->photo);
                if (File::exists($image_path)) {
                    File::delete($image_path);
                }
            }
            $imageName = time() . '.' . $request->photo->extension();
            $request->photo->move(public_path('assets/photo-profile'), $imageName);
            if ($request->password != null) {
                user::where('id', $id)->update([
                    'id_opd' => $request->id_opd,
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'photo' => $imageName,
                ]);
            } else {
                user::where('id', $id)->update([
                    'id_opd' => $request->id_opd,
                    'name' => $request->name,
                    'email' => $request->email,
                    'photo' => $imageName,
                ]);
            }
        } else {
            if ($request->password != null) {
                user::where('id', $id)->update([
                    'id_opd' => $request->id_opd,
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);
            } else {
                user::where('id', $id)->update([
                    'id_opd' => $request->id_opd,
                    'name' => $request->name,
                    'email' => $request->email,
                ]);
            }
        }
        (new AktivitasController)->store(Auth::user()->id, "Mengupdate Operator dengan Nama " . $request->name, "O2", Auth::user()->role);
        return redirect()->route('operator.index')->with('success', 'Berhasil Mengubah Data Operator !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $users = user::find($id);
        if ($users->photo != "avatar-1.png") {
            $image_path = public_path('assets/photo-profile/' . $users->photo);
            if (File::exists($image_path)) {
                File::delete($image_path);
            }
        }
        $users->delete();
        (new AktivitasController)->store(Auth::user()->id, "Menghapus Operator dengan Nama " . $users->nama_opd, "O3", Auth::user()->role);
        return redirect()->route('operator.index')->with('success', 'Berhasil Menghapus Data Operator !');
    }
}
