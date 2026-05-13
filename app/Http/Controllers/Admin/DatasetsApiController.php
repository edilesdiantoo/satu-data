<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\APIDatasets;
use App\Models\Opd;
use App\Models\Sektor;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use JsonSchema\Constraints\Constraint;
use JsonSchema\Validator;

class DatasetsApiController extends Controller
{
    public function index()
    {
        $api_datasets = APIDatasets::with('sektor')->get();
        $title = 'Hapus Datasets !';
        $text = 'Kamu yakin ingin Menghapus Datasets ini?';
        confirmDelete($title, $text);

        return view('super-admin.datasets-api.index', compact('api_datasets'));
    }

    public function create()
    {
        $opd = Opd::select('id', 'nama_opd')->get();
        $main_sektor = DB::table('tbl_main_sektor')->get();
        $sektor = Sektor::select('id', 'id_main_sektor', 'nama_sektor')->get();

        return view('super-admin.datasets-api.create', compact('opd', 'sektor', 'main_sektor'));
    }

    public function show($id)
    {
        $data = APIDatasets::with('sektor')->where('id', $id)->first();
        $datasets = collect($this->getApi($data->link_api, $data->bearer));
        $headers = $datasets['table']['header'];
        $values = $datasets['table']['value'];

        return view('super-admin.datasets-api.show', compact('data', 'datasets', 'headers', 'values'));
    }

    public function download($id)
    {
        $data = APIDatasets::where('id', $id)->first();
        $datasets = collect($this->getApi($data->link_api, $data->bearer));
        $headers = $datasets['table']['header'];
        $values = $datasets['table']['value'];

        return view('super-admin.datasets-api.format_download', compact('data', 'datasets', 'headers', 'values'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|max:255',
            'id_sektor' => 'required|max:255',
            'id_opd' => 'required|max:255',
            'bearer' => 'required|max:255',
            'link_api' => 'required|max:255',
        ]);

        if (! $this->checkValidApi($request->link_api, $request->bearer)) {
            return redirect()->back()->with('toast_error', 'Gagal Menambahkan Datasets API Tidak Valid !');
        }
        if (! $this->validateJson($this->getApi($request->link_api, $request->bearer))) {
            return redirect()->back()->with('toast_error', 'Gagal Menambahkan Datasets API Output Tidak Valid !');
        }
        APIDatasets::create([
            'judul' => $request->judul,
            'id_sektor' => $request->id_sektor,
            'id_opd' => $request->id_opd,
            'bearer' => $request->bearer,
            'link_api' => $request->link_api,
        ]);
        (new AktivitasController)->store(Auth::user()->id, 'Menambahkan Datasets API '.$request->judul, 'DA1', Auth::user()->role);

        return redirect()->route('datasets-api.index')->with('success', 'Berhasil Menambahkan Datasets API Baru !');
    }

    public function edit($id)
    {
        $api_datasets = APIDatasets::where('id', $id)->first();
        $opd = Opd::select('id', 'nama_opd')->get();
        $main_sektor = DB::table('tbl_main_sektor')->get();
        $sektor = Sektor::select('id', 'id_main_sektor', 'nama_sektor')->get();

        return view('super-admin.datasets-api.edit', compact('api_datasets', 'opd', 'sektor', 'main_sektor'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|max:255',
            'id_sektor' => 'required|max:255',
            'id_opd' => 'required|max:255',
            'sifat_datasets' => 'required|max:255',
            'bearer' => 'required|max:255',
            'link_api' => 'required|max:255',
        ]);

        if (! $this->checkValidApi($request->link_api, $request->bearer)) {
            return redirect()->back()->with('toast_error', 'Gagal Menambahkan Datasets API Tidak Valid !');
        }
        if (! $this->checkValidApi($request->link_api, $request->bearer)) {
            return redirect()->back()->with('toast_error', 'Gagal Menambahkan Datasets API Tidak Valid !');
        }
        APIDatasets::where('id', $id)->update([
            'judul' => $request->judul,
            'id_sektor' => $request->id_sektor,
            'id_opd' => $request->id_opd,
            'sifat_datasets' => $request->sifat_datasets,
            'bearer' => $request->bearer,
            'link_api' => $request->link_api,
        ]);
        (new AktivitasController)->store(Auth::user()->id, 'Mengubah Datasets API '.$request->judul, 'DA2', Auth::user()->role);

        return redirect()->route('datasets-api.index')->with('success', 'Berhasil Mengubah Datasets API Baru !');
    }

    public function destroy(string $id)
    {
        $api_datasets = APIDatasets::find($id);
        (new AktivitasController)->store(Auth::user()->id, 'Menghapus API Datasets dengan Nama '.$api_datasets->judul, 'DA3', Auth::user()->role);
        $api_datasets->delete();

        return redirect()->route('datasets-api.index')->with('success', 'Data Berhasil dihapus !');
    }

    private function checkValidApi($url, $bearer)
    {
        $client = new Client([
            'verify' => false,
        ]);
        $options = [
            'headers' => [
                'Authorization' => 'Bearer '.$bearer,
                'Accept' => 'application/json',
            ],
        ];
        try {
            $response = $client->get($url, $options);
            $statusCode = $response->getStatusCode();
            $responseBody = json_decode($response->getBody()->getContents(), true);
            if ($statusCode === 200) {
                return true;
            } elseif ($statusCode === 401) {
                return false;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            return false;
        }
    }

    public function validateJson($inputJson)
    {
        $schemaPath = public_path('assets-admin/schema.json');
        $schema = json_decode(file_get_contents($schemaPath));
        $validator = new Validator;
        $validator->validate($inputJson, $schema, Constraint::CHECK_MODE_TYPE_CAST);
        if ($validator->isValid()) {
            return true;
        } else {
            $errors = $validator->getErrors();

            return false;
            // return response()->json([
            //     'status' => 'Gagal',
            //     'response_code' => 400,
            //     'message' => 'JSON is invalid',
            //     'errors' => $errors
            // ]);
        }
    }

    private function getApi($url, $bearer)
    {
        $client = new Client([
            'verify' => false,
        ]);
        $options = [
            'headers' => [
                'Authorization' => 'Bearer '.$bearer,
                'Accept' => 'application/json',
            ],
        ];
        try {
            $response = $client->get($url, $options);
            $statusCode = $response->getStatusCode();
            $responseBody = json_decode($response->getBody()->getContents(), true);
            if ($statusCode === 200) {
                return $responseBody;
            } elseif ($statusCode === 401) {
                return false;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            return false;
        }
    }
}
