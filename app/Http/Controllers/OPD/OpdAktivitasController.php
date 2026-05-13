<?php

namespace App\Http\Controllers\OPD;

use App\Http\Controllers\Controller;
use App\Models\Aktivitas;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class OpdAktivitasController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkRole:opd');
    }

    public function index()
    {
        $aktivitas = Aktivitas::where('id_user', Auth::user()->id)->orderBy('created_at', 'desc')->paginate(10);
        $users = User::where('id', Auth::user()->id)->get();

        return view('opd.aktivitas.index', compact('aktivitas', 'users'));
    }

    public function store($id_user, $pesan, $status, $role)
    {
        $data = Aktivitas::create([
            'id_user' => $id_user,
            'pesan' => $pesan,
            'status' => $status,
            'role' => $role,
        ]);
        if ($data) {
            return true;
        } else {
            return false;
        }
    }

    public static function data()
    {
        $aktivitas = Aktivitas::orderBy('created_at', 'DESC')->get();

        return $aktivitas;
    }

    public static function data_user()
    {
        $user = User::get(['id', 'name', 'photo']);

        return $user;
    }
}
