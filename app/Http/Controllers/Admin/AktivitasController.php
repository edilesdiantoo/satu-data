<?php

namespace App\Http\Controllers\Admin;

use App\Models\Aktivitas;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class AktivitasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('checkRole:admin');
    }
    public function index(Request $request)
    {
        $chart = null;
        $aktivitas = Aktivitas::query();
        if ($request->input('startDate') && $request->input('endDate')) {
            $validatedData = $request->validate([
                'startDate' => 'required|date',
                'endDate' => 'required|date|after_or_equal:startDate',
            ]);
        
            $aktivitas->whereBetween('created_at', [$request->startDate, $request->endDate]);
        }
        $aktivitas = $aktivitas->orderBy('created_at', 'desc')->paginate(10)->withQueryString();
        $users = User::all();
        return view('super-admin.aktivitas.index', compact('aktivitas', 'users','chart'));
    }

    public function store($id_user, $pesan, $status, $role)
    {
        $data = Aktivitas::create([
            'id_user' => $id_user,
            'pesan' => $pesan,
            'status' => $status,
            'role' => $role
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
        $user =  User::get(['id', 'name', 'photo']);
        return $user;
    }
}
