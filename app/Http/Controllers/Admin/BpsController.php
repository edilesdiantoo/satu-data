<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BPS;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class BpsController extends Controller
{
    public function index()
    {
        $bps = BPS::orderBy('created_at', 'DESC')->get();
        $title = 'Hapus Data !';
        $text = 'Kamu yakin ingin Menghapus Data ini?';
        confirmDelete($title, $text);

        return view('super-admin.bps.index', compact('bps'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function __construct()
    {
        $this->middleware('checkRole:admin');
    }

    public function create()
    {
        // $kategori = Http::get('https://webapi.bps.go.id/v1/api/list/domain/1500/model/subcatcsa/key/97fb2e54e7ed024d54ca2825e6448e0d/');
        // $sosialdankependudukan = $this->sosialdankependudukan;
        // $ekonomiperdagangan = $this->ekonomiperdagangan;
        // $pertaniandanpertambangan = $this->pertaniandanpertambangan;
        // return view ('super-admin.bps.create',['kategori'=>$kategori],compact('sosialdankependudukan','ekonomiperdagangan','pertaniandanpertambangan'));
        $apiKey = '97fb2e54e7ed024d54ca2825e6448e0d';
        $domain = 1500;

        // Fetch kategori (subcatcsa)
        $kategoriResponse = Http::get("https://webapi.bps.go.id/v1/api/list/domain/$domain/model/subcatcsa/key/$apiKey/");
        $kategoriData = $kategoriResponse->json()['data'] ?? [];

        // Extract the actual kategori data (second element in array)
        $kategori = $kategoriData[1] ?? [];

        $subkategori = []; // Store all subcategories in one array
        $page = 1;

        do {
            // Fetch all subcategories (subjectcsa)
            $subkategoriResponse = Http::get("https://webapi.bps.go.id/v1/api/list/domain/$domain/model/subjectcsa/key/$apiKey/page/$page/");
            $subkategoriData = $subkategoriResponse->json();

            // Ensure the response contains data before accessing it
            if (isset($subkategoriData['data'][1])) {
                $subkategori = array_merge($subkategori, $subkategoriData['data'][1]);
            }

            // Check if there are more pages
            $totalPages = $subkategoriData['data'][0]['pages'] ?? 1;
            $page++;

        } while ($page <= $totalPages); // Keep fetching until all pages are retrieved

        return view('super-admin.bps.create', compact('kategori', 'subkategori'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kategori' => 'required|max:255',
            'sub_kategori' => 'required|max:255',
            'judul' => 'required|max:255',
            'link_api' => 'required|max:255',
        ]);

        BPS::create([
            'kategori' => $request->kategori,
            'sub_kategori' => $request->sub_kategori,
            'judul' => $request->judul,
            'slug' => Str::slug($request->judul),
            'link_api' => $request->link_api,
        ]);
        (new AktivitasController)->store(Auth::user()->id, 'Menambahkan Data API dengan Judul '.$request->judul, 'BPS1', Auth::user()->role);

        return redirect()->route('bps.index')->with('success', 'Berhasil Menambahkan Data API Baru !');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $bps = BPS::where('id', $id)->first();
        $apiKey = '97fb2e54e7ed024d54ca2825e6448e0d';
        $domain = 1500;

        // Fetch kategori (subcatcsa)
        $kategoriResponse = Http::get("https://webapi.bps.go.id/v1/api/list/domain/$domain/model/subcatcsa/key/$apiKey/");
        $kategoriData = $kategoriResponse->json()['data'] ?? [];

        // Extract the actual kategori data (second element in array)
        $kategori = $kategoriData[1] ?? [];

        $subkategori = []; // Store all subcategories in one array
        $page = 1;

        do {
            // Fetch all subcategories (subjectcsa)
            $subkategoriResponse = Http::get("https://webapi.bps.go.id/v1/api/list/domain/$domain/model/subjectcsa/key/$apiKey/page/$page/");
            $subkategoriData = $subkategoriResponse->json();

            // Ensure the response contains data before accessing it
            if (isset($subkategoriData['data'][1])) {
                $subkategori = array_merge($subkategori, $subkategoriData['data'][1]);
            }

            // Check if there are more pages
            $totalPages = $subkategoriData['data'][0]['pages'] ?? 1;
            $page++;

        } while ($page <= $totalPages); // Keep fetching until all pages are retrieved
        $selectedKategori = $bps->kategori ?? null;
        $selectedSubKategori = $bps->sub_kategori ?? null;

        return view('super-admin.bps.edit', compact('bps', 'kategori', 'subkategori', 'selectedKategori', 'selectedSubKategori'));

        // $sosialdankependudukan = $this->sosialdankependudukan;
        // $ekonomiperdagangan = $this->ekonomiperdagangan;
        // $pertaniandanpertambangan = $this->pertaniandanpertambangan;
        // $kategori = Http::get('https://webapi.bps.go.id/v1/api/list/domain/1500/model/subcatcsa/key/97fb2e54e7ed024d54ca2825e6448e0d/');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'kategori' => 'required|max:255',
            'sub_kategori' => 'required|max:255',
            'judul' => 'required|max:255',
            'link_api' => 'required|max:255',
        ]);
        BPS::where('id', $id)->update([
            'kategori' => $request->kategori,
            'sub_kategori' => $request->sub_kategori,
            'judul' => $request->judul,
            'slug' => Str::slug($request->judul),
            'link_api' => $request->link_api,
        ]);
        (new AktivitasController)->store(Auth::user()->id, 'Mengupdate Data API dengan Judul '.$request->judul, 'BPS2', Auth::user()->role);

        return redirect()->route('bps.index')->with('success', 'Berhasil Mengupdate Data API !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $bps = BPS::find($id);
        $bps->delete();
        (new AktivitasController)->store(Auth::user()->id, 'Menghapus Data dengan Judul '.$bps->judul, 'BPS3', Auth::user()->role);

        return redirect()->route('bps.index')->with('success', 'Berhasil Menghapus Data !');
    }
}
