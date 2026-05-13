<?php

use App\Http\Controllers\Admin\AgendaController;
use App\Http\Controllers\Admin\AktivitasController;
use App\Http\Controllers\Admin\AkunOpdController;
use App\Http\Controllers\Admin\ArtikelController;
use App\Http\Controllers\Admin\BahanPanganController;
use App\Http\Controllers\Admin\BeritaController;
use App\Http\Controllers\Admin\BpsController;
use App\Http\Controllers\Admin\BukuDigitalController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DatasetsApiController;
use App\Http\Controllers\Admin\DatasetsController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\GraphController;
use App\Http\Controllers\Admin\InfografisController;
use App\Http\Controllers\Admin\OpdController;
use App\Http\Controllers\Admin\OperatorController;
use App\Http\Controllers\Admin\PermohonanDataController;
use App\Http\Controllers\Admin\PublikasiController;
use App\Http\Controllers\Admin\SektorController;
use App\Http\Controllers\Admin\UlasanController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VisualisasiController;
use App\Http\Controllers\Auth\AuthentikasiController;
use App\Http\Controllers\OPD\OpdAktivitasController;
use App\Http\Controllers\OPD\OpdArtikelController;
use App\Http\Controllers\OPD\OpdBpsController;
use App\Http\Controllers\OPD\OpdDashboardController;
use App\Http\Controllers\OPD\OpdDatasetsController;
use App\Http\Controllers\OPD\OpdDatasetsShareController;
use App\Http\Controllers\OPD\OpdGraphController;
use App\Http\Controllers\OPD\OpdInfografisController;
use App\Http\Controllers\OPD\OpdPermohonanDataController;
use App\Http\Controllers\OPD\OpdPublikasiController;
use App\Http\Controllers\OPD\OpdUserController;
use App\Http\Controllers\WebController\HomeController;
use App\Http\Controllers\WebController\VisitorController;
use App\Http\Controllers\WebController\WebAgendaController;
use App\Http\Controllers\WebController\WebApiBPSController;
use App\Http\Controllers\WebController\WebApiDatasetsController;
use App\Http\Controllers\WebController\WebApiMetaDatasetsController;
use App\Http\Controllers\WebController\WebArtikelController;
use App\Http\Controllers\WebController\WebBeritaController;
use App\Http\Controllers\WebController\WebDatasetsController;
use App\Http\Controllers\WebController\WebGalleryController;
use App\Http\Controllers\WebController\WebInfografisController;
use App\Http\Controllers\WebController\WebPermohonar\WebPublikasiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::resource('web-datasets', WebDatasetsController::class)->except([
    'show',
]);

Route::get('/web-datasets/{id}/{bearer}/fetch', [WebDatasetsController::class, 'fetchTableData'])->name('web-datasets.fetch');

// Route::get('/download-metadata/{id}', [WebDatasetsController::class, 'getDownloadMetadata'])->name('download_metadata');
Route::get('/visualisasi/show/{id}/{slug}', [HomeController::class, 'show_visualisasi'])->name('web-visualisasi.show');
Route::get('/publikasi/informasi/stunting', [HomeController::class, 'stunting_index'])->name('web-berita.stunting');
Route::get('/publikasi/informasi/organisasi', [HomeController::class, 'organisasi'])->name('organisasi.informasi');
// Route::get('/web-datasets/download/{id}/{slug}', [WebDatasetsController::class, 'download'])->name('web-datasets.download');
// Route::get('/web-datasets/downloadCsv/{id}/{slug}', [WebDatasetsController::class, 'downloadCsv'])->name('web-datasets.downloadCsv');
// Route::get('/web-datasets/role/download/{id}/{slug}', [WebDatasetsController::class, 'role_download'])->name('role-datasets.download');
// Route::get('/web-datasets/share/download/{id}/{slug}', [WebDatasetsController::class, 'share_download'])->name('share-datasets.download');
Route::get('/web-datasets/{id}/{slug}', [WebDatasetsController::class, 'show'])->name('web-datasets.show');
Route::post('/web-datasets/ulasan/{id}', [WebDatasetsController::class, 'ulasan'])->name('web-datasets.ulasan');
Route::get('/data-dasar/badan-pusat-statistik', [WebApiBPSController::class, 'index'])->name('web-datadasar.index');
Route::get('/data-dasar/download/{id}/{tahun}', [WebApiBPSController::class, 'download_excel'])->name('web-datadasar.download');
Route::get('/data-dasar/{id}/{slug}', [WebApiBPSController::class, 'show'])->name('web-datadasar.show');

// Baris 70: Metadata
Route::get('/download-metadata/{id}', [WebDatasetsController::class, 'getDownloadMetadata'])->name('download_metadata')->middleware('throttle:5,1');

// Baris 74: Download Excel (Website)
Route::get('/web-datasets/download/{id}/{slug}', [WebDatasetsController::class, 'download'])->name('web-datasets.download')->middleware('throttle:5,1');

// Baris 75: Download CSV (Website)
Route::get('/web-datasets/downloadCsv/{id}/{slug}', [WebDatasetsController::class, 'downloadCsv'])->name('web-datasets.downloadCsv')->middleware('throttle:5,1');

// Baris 76: Role Download
Route::get('/web-datasets/role/download/{id}/{slug}', [WebDatasetsController::class, 'role_download'])->name('role-datasets.download')->middleware('throttle:5,1');

// Baris 77: Share Download
Route::get('/web-datasets/share/download/{id}/{slug}', [WebDatasetsController::class, 'share_download'])->name('share-datasets.download')->middleware('throttle:5,1');

Route::get('/web-datasets-api', [WebApiDatasetsController::class, 'index'])->name('web-datasets-api.index');
Route::get('/web-datasets-api/{id}/{slug}', [WebApiDatasetsController::class, 'show'])->name('web-datasets-api.show');
Route::get('/web-datasets-api/{id}', [WebApiDatasetsController::class, 'download'])->name('web-datasets-api.download');

Route::get('/web-metadatasets-api', [WebApiMetaDatasetsController::class, 'index'])->name('web-metadatasets-api.index');

Route::get('/publikasi/berita', [WebBeritaController::class, 'index'])->name('web-berita.index');
Route::get('/publikasi/berita/{id}/{slug}', [WebBeritaController::class, 'show'])->name('web-berita.show');
Route::get('/publikasi/artikel', [WebArtikelController::class, 'index'])->name('web-artikel.index');
Route::get('/publikasi/artikel/{id}/{slug}', [WebArtikelController::class, 'show'])->name('web-artikel.show');
Route::get('/publikasi/informasi', [WebPublikasiController::class, 'index'])->name('publikasi-informasi.index');
Route::get('/publikasi/informasi/{id}', [WebPublikasiController::class, 'show'])->name('publikasi-informasi.show');
Route::get('/publikasi/gallery', [WebGalleryController::class, 'index'])->name('web-gallery.index');
Route::get('/publikasi/gallery/{id}/{slug}', [WebGalleryController::class, 'show'])->name('web-gallery.show');
Route::get('/web-infografis', [WebInfografisController::class, 'index'])->name('web-infografis.index');
Route::get('/web-storyboard', [HomeController::class, 'storyboard'])->name('web-storyboard.index');
Route::get('/web-buku', [HomeController::class, 'buku'])->name('web-buku-digital.index');
Route::get('/web-permohonan-data', [WebPermohonanData::class, 'index'])->name('web-permohonan.index');
Route::get('/web-permohonan-data/show', [WebPermohonanData::class, 'show'])->name('web-permohonan.show');
Route::get('/web-permohonan-data/create', [WebPermohonanData::class, 'create'])->name('web-permohonan.create');
Route::post('/web-permohonan-data/store', [WebPermohonanData::class, 'store'])->name('web-permohonan.store');
Route::post('/web-permohonan-data/check_idtracking', [WebPermohonanData::class, 'check_idtracking'])->name('check_idtracking');
// webagenda
Route::get('/publikasi/agenda', [WebAgendaController::class, 'index'])->name('web-agenda.index');
Route::get('/get-event-details', [WebAgendaController::class, 'getEventDetails'])->name('getEventDetails');
Route::get('/get-events-by-month', [WebAgendaController::class, 'getEventsByMonth'])->name('getEventsByMonth');

Route::get('web-agenda/{id}/{slug}', [WebAgendaController::class, 'show'])->name('web-agenda.show');
Route::get('web-agenda/fetch-data/{id}/{bearer}', [WebAgendaController::class, 'fetchTableData'])->name('web-agenda.fetch');

Route::get('/web-agenda/download/{id}/{slug}', [WebAgendaController::class, 'downloadExcel'])->name('web-agenda.download');
Route::get('/web-agenda/downloadCsv/{id}/{slug}', [WebAgendaController::class, 'downloadCsv'])->name('web-agenda.downloadCsv');
Route::get('/get-monthly-events', [AgendaController::class, 'getMonthlyEvents'])->name('getMonthlyEvents');
// end
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthentikasiController::class, 'login'])->name('login');
    Route::post('/authentikasi', [AuthentikasiController::class, 'authenticate'])->name('authentikasi');
});
Route::middleware('checkRole:admin')->group(function () {
    Route::get('/datasets-api', [DatasetsApiController::class, 'index'])->name('datasets-api.index');
    Route::get('/datasets-api/download/{id}', [DatasetsApiController::class, 'download'])->name('datasets-api.download');
    Route::get('/datasets-api/create', [DatasetsApiController::class, 'create'])->name('datasets-api.create');
    Route::post('/datasets-api/store', [DatasetsApiController::class, 'store'])->name('datasets-api.store');
    Route::get('/datasets-api/edit/{id}', [DatasetsApiController::class, 'edit'])->name('datasets-api.edit');
    Route::get('/datasets-api/show/{id}', [DatasetsApiController::class, 'show'])->name('datasets-api.show');
    Route::patch('/datasets-api/update/{id}', [DatasetsApiController::class, 'update'])->name('datasets-api.update');
    Route::delete('/datasets-api/delete/{id}', [DatasetsApiController::class, 'destroy'])->name('datasets-api.destroy');

    Route::resource('operator', OperatorController::class);
    Route::resource('opd', OpdController::class);
    Route::resource('sektor', SektorController::class);
    Route::resource('visualisasi', VisualisasiController::class);
    Route::get('/storyboard', [VisualisasiController::class, 'storyboard'])->name('visualisasi.storyboard');

    Route::post('/agenda/store/{agenda_id}', [AgendaController::class, 'store'])->name('agenda.store');

    Route::get('/datasets/agenda-list', [DatasetsController::class, 'agendaList'])->name('datasets.agendaList');
    Route::get('/datasets/agenda-rilis/{id}', [DatasetsController::class, 'agendaRilis'])->name('agenda-rilis');

    Route::resource('datasets', DatasetsController::class);
    Route::delete('/pangan/mass-delete', [BahanPanganController::class, 'massDelete'])->name('pangan.massDelete');
    Route::resource('pangan', BahanPanganController::class);
    Route::post('/datasets/tambah-kolom/{id}', [DatasetsController::class, 'tambah_kolom'])->name('tambah_kolom');
    Route::post('/datasets/edit-nama-kolom/{id}', [DatasetsController::class, 'edit_nama_kolom'])->name('edit_nama_kolom');
    Route::post('/datasets/delete-kolom/{id}', [DatasetsController::class, 'delete_kolom'])->name('delete_kolom');

    Route::resource('bps', BpsController::class);
    Route::resource('berita', BeritaController::class);
    Route::resource('publikasi', PublikasiController::class);
    Route::resource('gallery', GalleryController::class);
    Route::post('/datasets/csv-file-upload/{id}', [DatasetsController::class, 'csv_upload'])->name('csv_upload');
    Route::post('/logout', [AuthentikasiController::class, 'logout'])->name('logout');
    Route::resource('akunopd', AkunOpdController::class);
    Route::get('/aktivitas', [AktivitasController::class, 'index'])->name('aktivitas');
    Route::patch('/profile/change-password', [UserController::class, 'update_password'])->name('change_password');
    Route::resource('profile', UserController::class);
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/grafik', [GraphController::class, 'index'])->name('graph');
    Route::resource('infografis', InfografisController::class);
    Route::resource('buku-digital', BukuDigitalController::class);
    Route::resource('artikel', ArtikelController::class);
    Route::resource('permohonan-data', PermohonanDataController::class);
    Route::get('/feedback', [UlasanController::class, 'index'])->name('feedback.index');
    Route::delete('/feedback-destroy/{id}', [UlasanController::class, 'destroy'])->name('feedback.destroy');
});

Route::middleware('checkRole:opd')->group(function () {
    Route::get('/akun-opd/dashboard', [OpdDashboardController::class, 'index'])->name('opd_dashboard');
    Route::get('/akun-opd/kategori-data/{id}', [OpdDashboardController::class, 'kategori_data'])->name('opd_kategoridata');
    Route::get('/akun-opd/opd-datasets', [OpdDatasetsController::class, 'index'])->name('opddatasets.index');
    Route::get('/akun-opd/opd-datasets/create', [OpdDatasetsController::class, 'create'])->name('opddatasets.create');
    Route::post('/akun-opd/opd-datasets', [OpdDatasetsController::class, 'store'])->name('opddatasets.store');
    Route::get('/akun-opd/opd-datasets/{id}', [OpdDatasetsController::class, 'show'])->name('opddatasets.show');
    Route::get('/akun-opd/opd-datasets/edit/{id}', [OpdDatasetsController::class, 'edit'])->name('opddatasets.edit');
    Route::patch('/akun-opd/opd-datasets/{id}', [OpdDatasetsController::class, 'update'])->name('opddatasets.update');
    Route::delete('/akun-opd/opd-datasets/{id}', [OpdDatasetsController::class, 'destroy'])->name('opddatasets.destroy');

    Route::post('/akun-opd/datasets/tambah-kolom/{id}', [OpdDatasetsController::class, 'tambah_kolom'])->name('tambah_kolom.opd');
    Route::post('/akun-opd/datasets/edit-nama-kolom/{id}', [OpdDatasetsController::class, 'edit_nama_kolom'])->name('edit_nama_kolom.opd');
    Route::post('/akun-opd/datasets/delete-kolom/{id}', [OpdDatasetsController::class, 'delete_kolom'])->name('delete_kolom.opd');
    Route::post('/akun-opd/datasets/csv-file-upload/{id}', [OpdDatasetsController::class, 'csv_upload'])->name('csv_upload.opd');
    Route::post('/akun-opd/logout', [AuthentikasiController::class, 'logout'])->name('logout.opd');
    Route::patch('/akun-opd/profile/change-password', [OpdUserController::class, 'update_password'])->name('change_password.opd');
    Route::get('/akun-opd/aktivitas', [OpdAktivitasController::class, 'index'])->name('opdaktivitas.index');

    Route::resource('opdbps', OpdBpsController::class);

    Route::get('/akun-opd/profile', [OpdUserController::class, 'index'])->name('opdprofile.index');
    Route::patch('/akun-opd/profile', [OpdUserController::class, 'update'])->name('opdprofile.update');

    Route::get('/akun-opd/grafik', [OpdGraphController::class, 'index'])->name('opdgraph.index');
    Route::resource('akun-opd/permohonan-keluar/opdpermohonan-data', OpdPermohonanDataController::class);
    Route::get('/akun-opd/permohonan-masuk/opdpermohonan-data', [OpdPermohonanDataController::class, 'masuk'])->name('opdpermohonan-data.masuk');
    Route::post('/akun-opd/permohonan-acc/{id}', [OpdPermohonanDataController::class, 'proses'])->name('opdprosespermohonan-data.masuk');
    // Route::get('/akun-opd/permohonan-masuk/edit-opdpermohonan-data/{id}', [OpdPermohonanDataController::class, 'edit_masuk'])->name('opdpermohonan-data.edit');
    // Route::get('/akun-opd/permohonan-keluar/edit-opdpermohonan-data/{id}', [OpdPermohonanDataController::class, 'edit'])->name('opdpermohonan-data.edit');
    Route::post('/akun-opd/terbit-permohonan/{id}', [OpdPermohonanDataController::class, 'update_masuk'])->name('opdprosespermohonan-data.terbit');

    Route::get('/akun-opd/opd-datasets-share', [OpdDatasetsShareController::class, 'index'])->name('opddatasetsshare.index');
    Route::get('/akun-opd/opd-datasets-share/create', [OpdDatasetsShareController::class, 'create'])->name('opddatasetsshare.create');
    Route::post('/akun-opd/opd-datasets-share', [OpdDatasetsShareController::class, 'store'])->name('opddatasetsshare.store');
    Route::get('/akun-opd/opd-datasets-share/{id}', [OpdDatasetsShareController::class, 'show'])->name('opddatasetsshare.show');
    Route::get('/akun-opd/opd-datasets-share/edit/{id}', [OpdDatasetsShareController::class, 'edit'])->name('opddatasetsshare.edit');
    Route::patch('/akun-opd/opd-datasets-share/{id}', [OpdDatasetsShareController::class, 'update'])->name('opddatasetsshare.update');

    Route::post('/akun-opd/datasets-share/tambah-kolom/{id}', [OpdDatasetsShareController::class, 'tambah_kolom'])->name('tambah_kolom.opdshare');
    Route::post('/akun-opd/datasets-share/edit-nama-kolom/{id}', [OpdDatasetsShareController::class, 'edit_nama_kolom'])->name('edit_nama_kolom.opdshare');
    Route::post('/akun-opd/datasets-share/delete-kolom/{id}', [OpdDatasetsShareController::class, 'delete_kolom'])->name('delete_kolom.opdshare');
    Route::post('/akun-opd/datasets-share/csv-file-upload/{id}', [OpdDatasetsShareController::class, 'csv_upload'])->name('csv_upload.opdshare');
    Route::resource('akun-opd/opd-artikel', OpdArtikelController::class);
    Route::resource('akun-opd/opd-infografis', OpdInfografisController::class);
    Route::resource('akun-opd/opd-publikasi', OpdPublikasiController::class);
});

// Menambahkan rute untuk mencatat pengunjung
Route::post('/log-page-view', [VisitorController::class, 'logPageView']);

// Menambahkan rute untuk mengambil statistik pengunjung
Route::get('/visitor-data', [VisitorController::class, 'getVisitorCounts']);

// Route::get('/data-dasar/badan-pusat-statistik', [WebApiBPSController::class, 'index'])->name('web-datadasar.index');
