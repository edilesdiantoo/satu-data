<?php

namespace App\Http\Controllers\WebController;

use App\Models\Sektor;
use App\Models\Infografis;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WebInfografisController extends Controller
{
    public function index(Request $request)
    {
        $sektor = Sektor::all();
        $builder = Infografis::query();
        $infografisId = $request->query('id');

        // Apply filters based on user input
        if ($request->input('judul')) {
            $queryString = $request->input('judul');
            $builder->where('judul', 'LIKE', "%$queryString%");
        }
        if ($request->input('urut')) {
            $queryString = $request->input('urut');
            if ($queryString == "terbaru") {
                $builder->orderBy('updated_at', 'DESC');
            } elseif ($queryString == "abjad") {
                $builder->orderBy('judul');
            }
        }
        if ($request->input('sektor')) {
            $queryString = $request->input('sektor');
            $builder->where('id_sektor', $queryString);
        }

        // Get the paginated results
        if ($request->input('record')) {
            $infografis = $builder->where('status', 'terverifikasi')->orderBy('updated_at', 'DESC')->paginate($request->input('record'))->withQueryString();
        } else {
            $infografis = $builder->where('status', 'terverifikasi')->orderBy('updated_at', 'DESC')->paginate(12)->withQueryString();
        }

        // Retrieve the selected infographic if id is present
        $selectedInfographic = null;
        if ($infografisId) {
            $selectedInfographic = Infografis::find($infografisId);
        }

        return view('website-view.infografis.index', compact('infografis', 'sektor', 'infografisId', 'selectedInfographic'));
    }
    

}
