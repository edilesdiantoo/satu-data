<?php

namespace App\Http\Controllers\OPD;

use App\Http\Controllers\Admin\AktivitasController;
use App\Http\Controllers\Controller;
use App\Mail\PermohonananDatasetsEmail;
use App\Models\Datasets;
use App\Models\Opd;
use App\Models\PermohonanData;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class OpdPermohonanDataController extends Controller
{
    public function index()
    {
        $data = PermohonanData::Where('id_user', Auth::user()->id)->orderBy('updated_at', 'DESC')->get();
        $user = User::all();
        $title = 'Hapus Permohonan Data !';
        $text = 'Kamu yakin ingin Menghapus Permohonan ini?';
        confirmDelete($title, $text);

        return view('opd.permohonan-data-keluar.index', compact('data', 'user'));
    }

    public function masuk()
    {
        $data = PermohonanData::Where('opd', Auth::user()->id_opd)->orderBy('updated_at', 'DESC')->get();
        $user = User::all();

        return view('opd.permohonan-data-masuk.index', compact('data', 'user'));
    }

    public function proses(string $id)
    {
        $data = PermohonanData::where('id', $id)->update([
            'status' => 'diproses',
        ]);
        (new AktivitasController)->store(Auth::user()->id, 'Memproses Permohonan data dengan Judul ', $id, 'P4', Auth::user()->role);

        return redirect()->route('opdpermohonan-data.masuk')->with('success', 'Berhasil Mengubah Permohonan Data !');

    }

    public function edit_masuk(string $id)
    {
        $data = PermohonanData::where('id', $id)->first();
        $datasets = Datasets::all();
        $opd = Opd::all();

        return view('opd.permohonan-data-masuk.edit', compact('data', 'opd', 'datasets'));
    }

    public function update_masuk(Request $request, string $id)
    {
        $request->validate([
            'id_datasets' => 'required',
        ]);
        $data = PermohonanData::where('id', $id)->update([
            'id_datasets' => $request->id_datasets,
            'status' => 'terbit',
        ]);
        $permohonan = PermohonanData::where('id', $id)->first();
        (new AktivitasController)->store(Auth::user()->id, 'Menerbitkan Permohonan data dengan Judul '.$permohonan->judul_datasets, 'P5', Auth::user()->role);

        return redirect()->route('opdpermohonan-data.masuk')->with('success', 'Berhasil Menerbitkan Permohonan Data !');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $opd = Opd::all();

        return view('opd.permohonan-data-keluar.create', compact('opd'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'no_tlp' => 'required',
            'judul_datasets' => 'required|max:255',
            'deskripsi' => 'required',
            'tujuan' => 'required',
            'template' => 'required|mimes:pdf|max:5000',
        ]);
        $statement = DB::select("show table status like 'tbl_permohonan_data'");
        $latest_id = $statement[0]->Auto_increment;
        if ($request->template != null) {
            $PdfName = time().'.'.$request->template->extension();
            $request->template->move(public_path('assets/permohonan-data'), $PdfName);
            $data = PermohonanData::create([
                'id_tracking' => 'PD-'.$latest_id.'-'.date('dmY').Str::random(6),
                'id_user' => Auth::user()->id,
                'nama' => Auth::user()->name,
                'email' => Auth::user()->email,
                'no_tlp' => $request->no_tlp,
                'judul_datasets' => $request->judul_datasets,
                'opd' => $request->opd,
                'deskripsi' => $request->deskripsi,
                'tujuan' => $request->tujuan,
                'upload_template' => $PdfName,
                'status' => 'terkirim',
            ]);
        }
        $this->sendMailMasuk($data->id_tracking, $data->judul_datasets, $data->nama, $data->email);
        (new AktivitasController)->store(Auth::user()->id, 'Menambahkan Permohonan data dengan Nama '.$request->judul_datasets, 'P1', Auth::user()->role);

        return redirect()->route('opdpermohonan-data.index')->with('success', 'Berhasil Menambahkan Permohonan Data Baru !');
    }

    public function sendMailMasuk($id_tracking, $judul, $nama, $email)
    {
        $mail = Mail::to($email)->send(new PermohonananDatasetsEmail($id_tracking, $judul, $nama));

        return 'Email telah dikirim';
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
        $data = PermohonanData::where('id', $id)->first();
        $datasets = Datasets::all();
        $opd = Opd::all();

        return view('opd.permohonan-data-masuk.edit', compact('data', 'opd', 'datasets'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_lengkap' => 'required|max:255',
            'email' => 'required',
            'no_tlp' => 'required',
            'judul_datasets' => 'required|max:255',
            'opd' => 'required',
            'deskripsi' => 'required',
            'tujuan' => 'required',
            'template' => 'mimes:pdf|max:5000',
        ]);
        if ($request->template != null) {
            $PdfName = time().'.'.$request->template->extension();
            $request->template->move(public_path('assets/permohonan-data'), $PdfName);
            $data = PermohonanData::where('id', $id)->update([
                'nama' => Auth::user()->id,
                'email' => Auth::user()->email,
                'no_tlp' => $request->no_tlp,
                'judul_datasets' => $request->judul_datasets,
                'opd' => $request->opd,
                'deskripsi' => $request->deskripsi,
                'tujuan' => $request->tujuan,
                'upload_template' => $PdfName,
            ]);
        } else {
            $data = PermohonanData::where('id', $id)->update([
                'nama' => Auth::user()->id,
                'email' => Auth::user()->email,
                'no_tlp' => $request->no_tlp,
                'judul_datasets' => $request->judul_datasets,
                'opd' => $request->opd,
                'deskripsi' => $request->deskripsi,
                'tujuan' => $request->tujuan,
            ]);
        }
        (new AktivitasController)->store(Auth::user()->id, 'Mengubah Permohonan data dengan Judul '.$request->judul_datasets, 'P2', Auth::user()->role);

        return redirect()->route('opdpermohonan-data.index')->with('success', 'Berhasil Mengubah Permohonan Data !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = PermohonanData::find($id);
        $file_path = public_path('assets/permohonan-data/'.$data->upload_template);
        if (File::exists($file_path)) {
            File::delete($file_path);
        }
        (new AktivitasController)->store(Auth::user()->id, 'Menghapus Permohonan Data dengan Judul '.$data->judul_datasets, 'P3', Auth::user()->role);
        $data->delete();

        return redirect()->route('opdpermohonan-data.index')->with('success', 'Permohonan Data Berhasil dihapus !');
    }
}
