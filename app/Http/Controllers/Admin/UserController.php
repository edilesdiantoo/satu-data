<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Datasets;
use App\Models\Opd;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkRole:admin');
    }

    public function index()
    {
        $opd = Opd::all();
        $users = User::where('id', Auth::user()->id)->first();
        $datasets = Datasets::where('diupload_oleh', Auth::user()->id)->count();

        return view('super-admin.profile.index', compact('opd', 'users', 'datasets'));
    }

    public function update(Request $request)
    {
        $users = User::find(Auth::user()->id);
        $request->validate([
            'id_opd' => 'required',
            'name' => 'required|max:255',
            'email' => 'required|max:255|unique:users,email,'.$users->id,
            'photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($request->photo != null) {
            if ($users->photo != 'avatar-1.png') {
                $image_path = public_path('assets/photo-profile/'.$users->photo);
                if (File::exists($image_path)) {
                    File::delete($image_path);
                }
            }
            $imageName = time().'.'.$request->photo->extension();
            $request->photo->move(public_path('assets/photo-profile'), $imageName);
            user::where('id', $users->id)->update([
                'id_opd' => $request->id_opd,
                'name' => $request->name,
                'email' => $request->email,
                'photo' => $imageName,
            ]);
        } else {
            user::where('id', $users->id)->update([
                'id_opd' => $request->id_opd,
                'name' => $request->name,
                'email' => $request->email,
            ]);
        }
        (new AktivitasController)->store(Auth::user()->id, 'Mengupdate Profile dengan '.$request->name, 'P2', Auth::user()->role);

        return redirect()->route('profile.index')->with('success', 'Berhasil Mengubah Data Profile !');
    }

    public function update_password(Request $request)
    {
        $users = User::find(Auth::user()->id);
        $request->validate([
            'old_password' => 'required|max:255',
            'password' => 'required|max:255|confirmed',
        ]);
        $old_password = $request->old_password;
        $password = $request->password;

        if (! Hash::check($old_password, Auth::user()->password)) {
            return redirect()->route('opdprofile.index')->with('toast_error', 'Password Lama Salah !');
        } else {
            $request->user()->fill(['password' => Hash::make($password)])->save();
            (new AktivitasController)->store(Auth::user()->id, 'Mengganti Passoword dengan '.$users->name, 'P4', Auth::user()->role);

            return redirect()->route('profile.index')->with('success', 'Berhasil Mengubah Password !');
        }
    }
}
