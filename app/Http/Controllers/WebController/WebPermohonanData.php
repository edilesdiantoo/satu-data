<?php

namespace App\Http\Controllers\WebController;

use App\Http\Controllers\Controller;
use App\Mail\PermohonananDatasetsEmail;
use App\Models\Opd;
use App\Models\PermohonanData;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class WebPermohonanData extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('website-view.permohonan-data.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $opd = Opd::all();

        return view('website-view.permohonan-data.create', compact('opd'));
    }

    public function check_idtracking(Request $request)
    {
        $request->validate([
            'id_tracking' => 'required',
            'g-recaptcha-response' => 'required|recaptcha',
        ]);
        $data = PermohonanData::where('id_tracking', '=', $request->id_tracking)->first();
        if ($data === null) {
            return redirect()->back()->with('error', 'ID Tracking Tidak Terdaftar');
        } else {
            return $this->show($data->id_tracking);
        }
    }

    public function store(Request $request, WhatsAppService $whatsAppService)
    {
        $nomor = ['+6282279239372'];
        $request->validate([
            'nama_depan' => 'required|max:255',
            'nama_belakang' => 'required|max:255',
            'email' => 'required',
            'no_tlp' => 'required',
            'judul_datasets' => 'required|max:255',
            'deskripsi' => 'required',
            'tujuan' => 'required',
            'template' => 'required|mimes:pdf|max:5000',
            'g-recaptcha-response' => 'required|recaptcha',
        ]);
        $statement = DB::select("show table status like 'tbl_permohonan_data'");
        $latest_id = $statement[0]->Auto_increment;
        if ($request->template != null) {
            $PdfName = time().'.'.$request->template->extension();
            $request->template->move(public_path('assets/permohonan-data'), $PdfName);
            $id_tracking = 'PD-'.$latest_id.'-'.date('dmY').Str::random(6);
            $data = PermohonanData::create([
                'id_tracking' => $id_tracking,
                'nama' => $request->nama_depan.' '.$request->nama_belakang,
                'email' => $request->email,
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
        $message = 'Kamu Menerima Permohonan Data ID Tracking :'.$id_tracking.' Segera Proses Permohonan Ini !';
        for ($i = 0; $i < count($nomor); $i++) {
            $whatsAppService->sendWhatsAppMessage($nomor[$i], $message);
        }

        return $this->show($data->id_tracking);
    }

    public function sendMailMasuk($id_tracking, $judul, $nama, $email)
    {
        $mail = Mail::to($email)->send(new PermohonananDatasetsEmail($id_tracking, $judul, $nama));

        return 'Email telah dikirim';
    }

    public static function getOpd($id)
    {
        $data = Opd::where('id', $id)->first();
        if ($data) {
            return $data->nama_opd;
        } else {
            return 'null';
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id_tracking)
    {
        $data = PermohonanData::where('id_tracking', '=', $id_tracking)->first();

        return view('website-view.permohonan-data.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
