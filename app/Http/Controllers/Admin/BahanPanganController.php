<?php

namespace App\Http\Controllers\Admin;

use App\Models\BahanPangan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\UpdateBahanPanganRequest;

class BahanPanganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pangan = DB::table('harga_eceran')
        ->join('kabupaten', 'harga_eceran.id_kabupaten_kota', '=', 'kabupaten.id')
        ->join('komoditas', 'harga_eceran.id_komoditas', '=', 'komoditas.id')
        ->select('harga_eceran.*', 'kabupaten.nama_kabupaten_kota', 'komoditas.nama_komoditas')
        ->orderBy('id','DESC')->get();

        // Fetch kabupaten data
        $kabupatens = DB::table('kabupaten')->select('id', 'nama_kabupaten_kota')->get();
        $komoditas = DB::table('komoditas')->select('id', 'nama_komoditas')->get();

        return view('super-admin.bahan-pangan.index', compact('pangan', 'kabupatens', 'komoditas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the CSV file input
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt|max:2048',
        ]);

        try {
            // Get the uploaded file and store it in a temporary path
            $tempFile = $request->file('csv_file')->getRealPath();
            $escapedFilePath = addslashes($tempFile);
            $tableName = 'harga_eceran'; 

            // Load data into the table using `LOAD DATA INFILE`
            $loadDataQuery = "LOAD DATA LOCAL INFILE '" . $escapedFilePath . "' 
                            INTO TABLE " . $tableName . " 
                            FIELDS TERMINATED BY ';' 
                            OPTIONALLY ENCLOSED BY '\"' 
                            LINES TERMINATED BY '\n' 
                            IGNORE 1 LINES
                            (id_kabupaten_kota, id_komoditas, harga, tanggal_survey, @dummy) 
                            SET created_at = NOW()";

            // Execute the query
            DB::connection()->getPdo()->exec($loadDataQuery);

            // // Fetch all the data that was just uploaded (you can now use created_at)
            // $uploadedData = DB::table('harga_eceran')->where('created_at', '>=', now()->subMinute())->get();

            // // Iterate through the uploaded data to send to the external API
            // foreach ($uploadedData as $row) {
            //     // Map your data to the API's required format
            //     $apiData = [
            //         'kode_komoditas' => $row->id_komoditas,
            //         'kode_pasar' => $row->id_kabupaten_kota,
            //         'kode_pedagang' => '1',
            //         'harga_jual' => $row->harga,
            //         'harga_beli' => '0',
            //         'ketersediaan' => '1',
            //         'deskripsi' => 'N/A',
            //         'kode_pengguna' => '1',
            //         'tgl_survey' => $row->tanggal_survey,
            //     ];

            //     // Send the data to the external API
            //     $response = Http::withOptions(['verify' => false])->post('https://simbako.jambiprov.go.id/api/inputSurveyPasar', $apiData);

            //     // Check if the API call was successful
            //     if (!$response->successful()) {
            //         \Log::error('Failed to send data to API. Status: ' . $response->status() . '. Body: ' . $response->body());
            //     }
            // }

            // Redirect with success message
            return redirect()->back()->with('success', 'Data successfully uploaded!');
        } catch (\Exception $e) {
            // Log the error and redirect with an error message
            \Log::error('Error uploading CSV: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to upload data. Please check the CSV file and try again.');
        }
    }

    public function massDelete(Request $request)
    {
        $ids = $request->ids; // Get the array of IDs from the request

        if ($ids) {
            // Delete the selected records
            DB::table('harga_eceran')->whereIn('id', $ids)->delete();

            return redirect()->back()->with('success', 'Selected records have been deleted!');
        }

        return redirect()->back()->with('error', 'No records selected!');
    }

    /**
     * Display the specified resource.
     */
    public function show(BahanPangan $bahanPangan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $item = DB::table('harga_eceran')
            ->join('kabupaten', 'harga_eceran.id_kabupaten_kota', '=', 'kabupaten.id')
            ->join('komoditas', 'harga_eceran.id_komoditas', '=', 'komoditas.id')
            ->select('harga_eceran.*', 'kabupaten.nama_kabupaten_kota', 'komoditas.nama_komoditas')
            ->where('harga_eceran.id', $id)
            ->first();

        return response()->json($item);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBahanPanganRequest $request, $id)
    {
        $bahanPangan = BahanPangan::findOrFail($id); // Use Eloquent to find the record

        $bahanPangan->update([
            'id_kabupaten_kota' => $request->input('id_kabupaten_kota'),
            'id_komoditas' => $request->input('id_komoditas'),
            'harga' => $request->input('harga'),
            'tanggal_survey' => $request->input('tanggal_survey'),
        ]);

        // Redirect back to the index with the current page number
        return redirect()->route('pangan.index')
                        ->with('success', 'Data updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BahanPangan $bahanPangan)
    {
        //
    }
}
