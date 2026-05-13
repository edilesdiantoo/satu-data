<?php

namespace App\Http\Controllers\WebController;

use App\Http\Controllers\Controller;
use App\Models\APIDatasets;
use App\Models\Opd;
use App\Models\Sektor;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class WebApiDatasetsController extends Controller
{
    public function index(Request $request)
    {
        $sektor = Sektor::all();
        $builder = APIDatasets::query();
        if ($request->input('judul')) {
            $queryString = $request->input('judul');
            $builder->where('judul', 'LIKE', "%$queryString%");
        }
        if ($request->input('urut')) {
            $queryString = $request->input('urut');
            if ($queryString == 'terbaru') {
                $builder->orderBy('updated_at', 'DESC');
            } elseif ($queryString == 'abjad') {
                $builder->orderBy('judul');
            } elseif ($queryString == 'terpopuler') {
                $builder->orderBy('jumlah_unduhan', 'DESC');
            }
        }
        if ($request->input('opd')) {
            $queryString = $request->input('opd');
            $builder->where('id_opd', $queryString);
        }
        if ($request->input('sektor')) {
            $queryString = $request->input('sektor');
            $builder->where('id_sektor', $queryString);
        }
        if ($request->input('record')) {
            $datasets = $builder->where('sifat_datasets', 'PUBLIK')->orderBy('updated_at', 'DESC')->paginate($request->input('record'))->withQueryString();
        } else {
            $datasets = $builder->where('sifat_datasets', 'PUBLIK')->orderBy('updated_at', 'DESC')->paginate(20)->withQueryString();
        }

        return view('website-view.datasets-api.index', compact('datasets', 'sektor'));
    }

    public function show($id, $slug)
    {
        $data = APIDatasets::with('sektor')->where('id', $id)->first();
        $opd = Opd::where('id', $data->id_opd)->first();
        $datasets = collect($this->getApi($data->link_api, $data->bearer));
        $headers = $datasets['table']['header'];
        $values = $datasets['table']['value'];

        return view('website-view.datasets-api.show', compact('data', 'opd', 'datasets', 'headers', 'values'));
    }

    public function download($id)
    {
        $data = APIDatasets::where('id', $id)->first();
        $datasets = collect($this->getApi($data->link_api, $data->bearer));
        $headers = $datasets['table']['header'];
        $values = $datasets['table']['value'];

        return view('website-view.datasets-api.to-excel', compact('data', 'datasets', 'headers', 'values'));
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
        } catch (Exception $e) {
            return false;
        }
    }
}
