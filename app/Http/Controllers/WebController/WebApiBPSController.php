<?php

namespace App\Http\Controllers\WebController;

use App\Http\Controllers\Controller;
use App\Models\BPS;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WebApiBPSController extends Controller
{
    public function index(Request $request)
    {
        // --- FUNGSI UNTUK MENGAMBIL DATA DENGAN PURE CURL ---
        $fetchData = function ($url) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            // >>> PENGATURAN CURL UNTUK BYPASS/MELEWATI VERIFIKASI SSL <<<
            // INI SANGAT TIDAK DISARANKAN UNTUK LINGKUNGAN PRODUKSI KARENA BERBAHAYA
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); // Atau false untuk cURL versi lama
            // ------------------------------------------------------------------

            $response = curl_exec($ch);
            $error = curl_error($ch);
            curl_close($ch);

            if ($error) {
                // Tangani error jika terjadi (misal: log atau throw exception)
                throw new \Exception('cURL Error: '.$error);
            }

            return $response;
        };
        // ------------------------------------------------------------------

        try {
            // 1. Ambil Kategori
            $kategoriResponse = $fetchData('https://webapi.bps.go.id/v1/api/list/domain/1500/model/subcatcsa/key/5e8e48bcb594103813c4182cce2017ae/');
            $kategori = json_decode($kategoriResponse, true);

            $allData = [];
            $subcatIdsToFetch = [514, 515, 516];

            // 2. Ambil Semua Data Berdasarkan subcat ID dan Halaman
            foreach ($subcatIdsToFetch as $subcatId) {
                for ($i = 1; $i <= 4; $i++) {
                    $url = "https://webapi.bps.go.id/v1/api/list/domain/1500/model/subjectcsa/subcat/{$subcatId}/key/5e8e48bcb594103813c4182cce2017ae/page/{$i}/";
                    $response = $fetchData($url);
                    $data = json_decode($response, true);

                    if (isset($data['data'][1])) {
                        $allData = array_merge($allData, $data['data'][1]);
                    }
                }
            }

            // 3. Mengelompokkan data
            $demografi = [];
            $ekonomi = [];
            $lhdanmultidomain = [];

            foreach ($allData as $item) {
                if ($item['subcat_id'] == 514) {
                    $demografi[] = $item;
                } elseif ($item['subcat_id'] == 515) {
                    $ekonomi[] = $item;
                } elseif ($item['subcat_id'] == 516) {
                    $lhdanmultidomain[] = $item;
                }
            }

        } catch (\Exception $e) {
            // Jika ada error cURL, Anda bisa log dan mengembalikannya ke tampilan dengan data kosong atau pesan error
            $kategori = [];
            $demografi = $ekonomi = $lhdanmultidomain = [];
            // return view('website-view.bps.index', ['error' => $e->getMessage()]);
        }

        // 4. Proses Query Database (BAGIAN INI TETAP SAMA)
        $builder = BPS::query();

        if ($request->input('judul')) {
            $queryString = $request->input('judul');
            $builder->where('judul', 'LIKE', "%$queryString%");
        }
        if ($request->input('kategori')) {
            $queryString = $request->input('kategori');
            $builder->where('kategori', $queryString);
        }
        if ($request->input('sub_kategori')) {
            $queryString = $request->input('sub_kategori');
            $builder->where('sub_kategori', $queryString);
        }

        if ($request->input('record')) {
            $bps = $builder->orderBy('created_at', 'DESC')->paginate($request->input('record'))->withQueryString();
        } else {
            $bps = $builder->orderBy('created_at', 'DESC')->paginate(15)->withQueryString();
        }

        // 5. Kembalikan View
        return view('website-view.bps.index', ['kategori' => $kategori], compact('bps', 'demografi', 'ekonomi', 'lhdanmultidomain'));
    }

    public function show($id, Request $request)
    {
        // --- FUNGSI UNTUK MENGAMBIL DATA DENGAN PURE CURL ---
        $fetchData = function ($url) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            // >>> PENGATURAN CURL UNTUK BYPASS/MELEWATI VERIFIKASI SSL <<<
            // INI SANGAT TIDAK DISARANKAN UNTUK LINGKUNGAN PRODUKSI
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            // ------------------------------------------------------------------

            $response = curl_exec($ch);
            $error = curl_error($ch);
            curl_close($ch);

            if ($error) {
                // Jika ada error cURL, lempar exception atau tangani sesuai kebutuhan
                throw new \Exception('cURL Error: '.$error);
            }

            // Mengembalikan string respons mentah cURL
            return $response;
        };
        // -------------------------------------------------------------

        $bps = BPS::where('id', $id)->first();
        $tahun_data = null; // Inisialisasi variabel
        $responseString = null; // Akan menyimpan respons string dari cURL

        // Pastikan $bps ditemukan
        if (! $bps) {
            abort(404, 'Data BPS tidak ditemukan.');
        }

        try {
            if ($request->input('tahun')) {
                // --- Logika Jika Parameter Tahun Disediakan ---
                $tahun_data = $request->input('tahun');
                $inputYear = (int) $request->input('tahun');

                // Konversi tahun 2010-2027 menjadi 110-127
                $convertedYear = ($inputYear >= 2010 && $inputYear <= 2027)
                    ? (100 + ($inputYear - 2000))
                    : $inputYear;

                $array = explode('/', $bps->link_api);

                // Periksa apakah array memiliki panjang yang cukup sebelum memodifikasi
                if (count($array) < 14) {
                    // Tambahkan elemen baru jika array terlalu pendek
                    $array = array_pad($array, 14, null);
                }

                // Memodifikasi array untuk menyertakan tahun yang dikonversi
                $array[14] = 'th';
                $array[15] = (string) $convertedYear;
                $array[16] = 'key';
                $array[17] = '5e8e48bcb594103813c4182cce2017ae';

                // Build URL dari array yang sudah dimodifikasi
                $modifiedUrl = implode('/', $array);

                // Panggil cURL
                $responseString = $fetchData($modifiedUrl);

            } else {
                // --- Logika Jika Parameter Tahun TIDAK Disediakan ---
                $array = explode('/', $bps->link_api);

                // Panggil cURL
                $responseString = $fetchData($bps->link_api);

                // Decode string respons mentah
                $responseData = json_decode($responseString, true);

                // Ambil tahun dari respons
                if (isset($responseData['tahun']) && is_array($responseData['tahun'])) {
                    $tahun_data_array = $responseData['tahun'];
                    $tahun_data = $tahun_data_array[0]['label']; // Misalnya: "2024"
                    // $count_tahun = count($responseData['tahun'])-1; // Variabel ini tidak digunakan di bawah
                }
            }
        } catch (\Exception $e) {
            // Log error untuk debugging
            \Log::error('BPS API cURL Error: '.$e->getMessage().' for link: '.($modifiedUrl ?? $bps->link_api));

            // Atur respons menjadi array kosong atau array error
            $responseString = json_encode(['data' => []]);
        }

        // Kembalikan respons string mentah ke view, atau bisa di-decode di sini
        $responseData = json_decode($responseString, true);

        return view('website-view.bps.show', [
            'response' => $responseData,
            'id' => $id,
            'tahun_data' => $tahun_data,
            'bps' => $bps,
        ]);
    }

    public function download_excel($id, $tahun, Request $request)
    {
        $bps = BPS::where('id', $id)->first();
        $url = $bps->link_api;

        // Cek apakah URL mengandung 'th'
        if (strpos($url, 'th') !== false) {
            // Jika sudah ada 'th', ambil data langsung dari link API
            $response = Http::get($url);
        } else {
            // Jika tidak ada 'th', tambahkan tahun berdasarkan parameter 'tahun'
            $inputYear = (int) $tahun;

            // Konversi tahun 2010-2027 menjadi 110-127
            $convertedYear = ($inputYear >= 2010 && $inputYear <= 2027)
                ? (100 + ($inputYear - 2000))
                : $inputYear;

            $array = explode('/', $url);

            // Tambahkan th dan convertedYear ke posisi yang tepat
            $array[14] = 'th';
            $array[15] = (string) $convertedYear;
            $array[16] = 'key';
            $array[17] = '5e8e48bcb594103813c4182cce2017ae'; // key tetap sama

            // Bangun kembali URL dengan tahun yang sudah ditambahkan
            $modifiedUrl = implode('/', $array);
            $response = Http::get($modifiedUrl);
        }

        // Tampilkan view dengan response yang diperoleh
        return view('website-view.bps.to-excel', ['response' => $response]);
    }
}
