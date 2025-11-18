@extends('website-view.layout.layout')
@section('title', 'Permohonan Data')
@section('main')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var myModal = new bootstrap.Modal(document.getElementById('autoShowModal'));
            myModal.show(); // Menampilkan modal saat halaman selesai dimuat
        });
    </script>
    <style>
        .page-header {
            margin: 0 0 1rem;
            padding-bottom: 1rem;
            padding-top: .5rem;
            border-bottom: 1px dotted #e2e2e2;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-pack: justify;
            justify-content: space-between;
            -ms-flex-align: center;
            align-items: center;
        }

        .page-title {
            padding: 0;
            margin: 0;
            font-size: 1.75rem;
            font-weight: 300;
        }

        .brc-default-l1 {
            border-color: #dce9f0 !important;
        }

        .ml-n1,
        .mx-n1 {
            margin-left: -.25rem !important;
        }

        .mr-n1,
        .mx-n1 {
            margin-right: -.25rem !important;
        }

        .mb-4,
        .my-4 {
            margin-bottom: 1.5rem !important;
        }

        hr {
            margin-top: 1rem;
            margin-bottom: 1rem;
            border: 0;
            border-top: 1px solid rgba(0, 0, 0, .1);
        }

        .text-grey-m2 {
            color: #888a8d !important;
        }

        .text-success-m2 {
            color: #86bd68 !important;
        }

        .font-bolder,
        .text-600 {
            font-weight: 600 !important;
        }

        .text-110 {
            font-size: 110% !important;
        }

        .text-blue {
            color: #478fcc !important;
        }

        .pb-25,
        .py-25 {
            padding-bottom: .75rem !important;
        }

        .pt-25,
        .py-25 {
            padding-top: .75rem !important;
        }

        .bgc-default-tp1 {
            background-color: rgba(121, 169, 197, .92) !important;
        }

        .bgc-default-l4,
        .bgc-h-default-l4:hover {
            background-color: #f3f8fa !important;
        }

        .page-header .page-tools {
            -ms-flex-item-align: end;
            align-self: flex-end;
        }

        .btn-light {
            color: #757984;
            background-color: #f5f6f9;
            border-color: #dddfe4;
        }

        .w-2 {
            width: 1rem;
        }

        .text-120 {
            font-size: 120% !important;
        }

        .text-primary-m1 {
            color: #4087d4 !important;
        }

        .text-danger-m1 {
            color: #dd4949 !important;
        }

        .text-blue-m2 {
            color: #68a3d5 !important;
        }

        .text-150 {
            font-size: 150% !important;
        }

        .text-60 {
            font-size: 60% !important;
        }

        .text-grey-m1 {
            color: #7b7d81 !important;
        }

        .align-bottom {
            vertical-align: bottom !important;
        }

        .track {
            position: relative;
            background-color: #ddd;
            height: 7px;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            margin-bottom: 90px;
            margin-top: 50px
        }

        .track .step {
            -webkit-box-flex: 1;
            -ms-flex-positive: 1;
            flex-grow: 1;
            width: 25%;
            margin-top: -18px;
            text-align: center;
            position: relative
        }

        .track .step.active:before {
            background: #FF5722
        }

        .track .step::before {
            height: 7px;
            position: absolute;
            content: "";
            width: 100%;
            left: 0;
            top: 18px
        }

        .track .step.active .icon {
            background: #ee5435;
            color: #fff
        }

        .track .icon {
            display: inline-block;
            width: 40px;
            height: 40px;
            line-height: 40px;
            position: relative;
            border-radius: 100%;
            background: #ddd
        }

        .track .step.active .text {
            font-weight: 400;
            color: #000
        }

        .track .text {
            display: block;
            margin-top: 7px
        }
    </style>
    <main id="main">
        <!-- ======= Breadcrumbs Section ======= -->
        <section class="breadcrumbs">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center">
                    <h2>Permohonan Data</h2>
                    <ol>
                        <li><a href="/">Home</a></li>
                        <li>Halaman Permohonan Data</li>
                    </ol>
                </div>
            </div>
        </section><!-- End Breadcrumbs Section -->
        <section class="inner-page">
            <div class="container">
                <div class="row" style="padding-bottom: 20px;">
                    <div class="col-md-10">
                        <div class="section-title" style="padding-bottom: 0px;" data-aos="fade-up">
                            <h2>Permohonan Data</h2>
                            <p>Permohonan Data Ditemukan </p>
                        </div>
                    </div>
                </div>

                <div class="page-content container" data-aos="fade-up">
                    <div class="page-header text-blue-d2">
                        <h1 class="page-title text-secondary-d1">
                            ID TRACKING
                            <small class="page-info">
                                <i class="bi bi-chevron-double-right text-80"></i>
                                {{ $data->id_tracking }}
                            </small>
                        </h1>

                        <div class="page-tools">
                            <div class="action-buttons">
                                <a class="btn bg-white btn-light mx-1px text-95" href="#" onclick="window.print();"
                                    data-title="PDF">
                                    <i class="mr-1 bi bi-printer text-danger-m1 text-120 w-2"></i>
                                    Export
                                </a>
                                @if ($data->id_datasets)
                                    <a class="btn bg-white btn-light mx-1px text-95"
                                        href="{{ route('web-datasets.download', ['id' => $data->id_datasets, 'slug' => 'Download']) }}">
                                        <i class="mr-1 bi bi-download text-info-m1 text-120 w-2"></i>
                                        Download
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="container px-0">
                        <div class="row mt-4">
                            <div class="col-lg-12">
                                <div class="card shadow-sm border-0">
                                    <div class="card-body">
                                        <div class="row">
                                            <!-- Informasi Data -->
                                            <div class="col-sm-6">
                                                <h5 class="text-primary fw-bold mb-3">{{ $data->judul }}</h5>
                                                <p class="mb-1">
                                                    <span class="text-muted">Nama: </span>
                                                    <span class="fw-semibold text-dark">{{ $data->nama }}</span>
                                                </p>
                                                <p class="mb-1">
                                                    <span class="text-muted">Email: </span>
                                                    <span class="fw-semibold text-dark">{{ $data->email }}</span>
                                                </p>
                                                <p class="mb-0">
                                                    <span class="text-muted">Nomor Telepon: </span>
                                                    <span class="fw-semibold text-dark">{{ $data->no_tlp }}</span>
                                                </p>
                                            </div>
                                            <!-- Informasi Permohonan -->
                                            <div class="col-sm-6 text-sm-end">
                                                <h6 class="text-secondary fw-bold mb-3">Permohonan Data</h6>
                                                <p class="mb-2">
                                                    <i class="bi bi-bank text-primary me-2"></i>
                                                    <span class="text-muted">Penghasil Sumber Data: </span>
                                                    <span class="fw-semibold text-dark">
                                                        {{ App\Http\Controllers\WebController\WebPermohonanData::getOpd($data->opd) ?? 'null' }}
                                                    </span>
                                                </p>
                                                <p class="mb-2">
                                                    <i class="bi bi-calendar-event text-primary me-2"></i>
                                                    <span class="text-muted">Tanggal Mengajukan: </span>
                                                    <span class="fw-semibold text-dark">
                                                        {{ $data->created_at->isoFormat('dddd, D MMMM Y') }}
                                                    </span>
                                                </p>
                                                <p class="mb-0">
                                                    <i class="bi bi-info-circle text-primary me-2"></i>
                                                    <span class="text-muted">Status: </span>
                                                    @if ($data->status == 'terkirim')
                                                        <span class="badge bg-info">Sedang Diverifikasi</span>
                                                    @elseif($data->status == 'verifikasi')
                                                        <span class="badge bg-warning">Sedang Diproses</span>
                                                    @elseif($data->status == 'diproses')
                                                        <span class="badge bg-warning">Datasets sedang diproses oleh OPD
                                                            bersangkutan</span>
                                                    @elseif($data->status == 'terbit')
                                                        <span class="badge bg-success">Berhasil Terbit</span>
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                        <div class="mt-4">
                                            <div class="track">
                                                <div class="step @if (
                                                    $data->status == 'terkirim' ||
                                                        $data->status == 'verifikasi' ||
                                                        $data->status == 'diproses' ||
                                                        $data->status == 'terbit') active @endif "> <span
                                                        class="icon"> <i class="bi bi-send-check-fill"></i>
                                                    </span>
                                                    <span class="text">Permohonan Data Terkirim</span>
                                                </div>
                                                <div class="step @if ($data->status == 'verifikasi' || $data->status == 'diproses' || $data->status == 'terbit') active @endif">
                                                    <span class="icon">
                                                        <i class="bi bi-card-checklist"></i>
                                                    </span>
                                                    <span class="text">Verifikasi Permohonan Data</span>
                                                </div>
                                                <div class="step @if ($data->status == 'diproses' || $data->status == 'terbit') active @endif"> <span
                                                        class="icon">
                                                        <i class="bi bi-person-fill-check"></i>
                                                    </span>
                                                    <span class="text">Sedang di Proses Permohonan Data</span>
                                                </div>
                                                <div class="step @if ($data->status == 'terbit') active @endif"> <span
                                                        class="icon">
                                                        <i class="bi bi-database-check"></i>
                                                    </span> <span class="text">Datasets Telah Terbit</span> </div>
                                            </div>
                                            <table class="table">
                                                <thead style="background-color: #84B0CA" class="text-white">
                                                    <tr>
                                                        <th scope="col">Tujuan</th>
                                                        <th scope="col">Deskripsi</th>
                                                        <th scope="col">Template</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th scope="row">{{ $data->tujuan }}</th>
                                                        <td>{{ $data->deskripsi }}</td>
                                                        <td><a href="{{ asset('assets/permohonan-data/' . $data->upload_template) }}"
                                                                target="_blank">Download</a>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <div class="row border-b-2 brc-default-l2"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main><!-- End #main -->
    <!-- Modal -->
    <div class="modal fade" id="autoShowModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Notifikasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Kode Tracking telah Terkirim di email anda. Silahkan Cek Email anda.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

@endsection
