<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Datasets;
use Illuminate\Support\Facades\DB;

class UlasanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $feedback = DB::table('tbl_feedback')->get();
        $title = 'Hapus Feedback !';
        $text = 'Kamu yakin ingin Menghapus Feedback ini?';
        confirmDelete($title, $text);

        return view('super-admin.feedback.index', compact('feedback'));
    }

    public static function getNameDatasets($id)
    {
        $datasets = Datasets::where('id', $id)->first();

        return $datasets->judul ?? null;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $feedback = DB::table('tbl_feedback')->where('id', $id)->delete();
        (new AktivitasController)->store(Auth::user()->id, 'Menghapus Uladan '.$feedback->judul, 'F3', Auth::user()->role);

        return redirect()->route('feedback.index')->with('success', 'Berhasil Menghapus Data Feedback !');
    }
}
