@extends('website-view.layout.layout')
@section('title', 'Datasets')
@section('main')

    <div class="njs-sticky-side body-append image_button_cover placement-right now-show">
        <a href="#" target="blank_" rel="noopener noreferrer" data-bs-toggle="modal"
            data-bs-target="#feedback_modal">Feedback <i class="bi bi-envelope-paper-fill"></i>
        </a>
    </div>
    <main id="main">
        <?php
        // replace non letter or digits by divider
        $text = preg_replace('~[^\pL\d]+~u', '-', $datasets->judul);
        
        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        
        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);
        
        // trim
        $text = trim($text, '-');
        
        // remove duplicate divider
        $text = preg_replace('~-+~', '-', $text);
        
        // lowercase
        $text = strtolower($text);
        ?>
        <!-- ======= Breadcrumbs Section ======= -->
        <section class="breadcrumbs">
            <div class="container">

                <div class="d-flex justify-content-between align-items-center">
                    <h2>Datasets</h2>
                    <ol>
                        <li><a href="/">Home</a></li>
                        <li><a href="{{ route('web-datasets.index') }}">Statistik Sektoral</a></li>
                        <li>{{ $datasets->nama_opd }}</li>
                    </ol>
                </div>

            </div>
        </section><!-- End Breadcrumbs Section -->
        <section class="inner-page">
            <div class="container">
                <div class="section-title" data-aos="fade-up">
                    <h2>Datasets</h2>
                </div>
                @if (\Session::has('success'))
                    <div class="col-md-12">
                        <div class="alert alert-success">
                            <ul>
                                <li>{!! \Session::get('success') !!}</li>
                            </ul>
                        </div>
                    </div>
                @elseif(\Session::has('danger'))
                    <div class="col-md-12">
                        <div class="alert alert-danger">
                            <ul>
                                <li>{!! \Session::get('danger') !!}</li>
                            </ul>
                        </div>
                    </div>
                @endif
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 text-center">
                                    <div class="mt-4">
                                        @if ($opd->gambar ?? null)
                                            <img src="{{ asset('assets/opd/' . $opd->gambar) }}" class="img-thumbnail"
                                                alt="logo" style="max-width: 300px;border:0;">
                                        @else
                                            <img src="{{ asset('assets/opd/default.jpg') }}" class="img-thumbnail"
                                                alt="logo" style="max-width: 300px;">
                                        @endif
                                        <br>
                                        <a href="{{ route('organisasi.informasi') }}?judul={{ $datasets->nama_opd }}"
                                            class="text-uppercase fw-bolder text-dark">{{ $datasets->nama_opd }}</a>
                                    </div>
                                    <h6 class="card-subtitle mb-2 mt-3 text-body-secondary">
                                        <span style="margin-right: 20px;"><i class='bx bx-calendar'></i>
                                            {{ $datasets->created_at->format('d M Y') }}</span>
                                        <span style="margin-right: 20px;"> <i class="bx bx-download"></i>
                                            {{ $datasets->jumlah_unduhan }} </span>
                                        <span style="margin-right: 20px;"> <i class="bx bx-show"></i>
                                            {{ $viewer }} </span>
                                    </h6>
                                    <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-success dropdown-toggle"
                                                data-bs-toggle="dropdown" aria-expanded="false" style="font-size: 12px">
                                                Unduh Datasets
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item"
                                                        href="{{ route('web-datasets.download', [$datasets->id, $text]) }}">Excel</a>
                                                </li>
                                                <li><a class="dropdown-item"
                                                        href="{{ route('web-datasets.downloadCsv', [$datasets->id, $text]) }}">CSV</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="btn-group" role="group" aria-label="Button group to open share modal">
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-secondary rounded" data-bs-toggle="modal"
                                                data-bs-target="#share_modal" style="font-size: 12px"><i
                                                    class="bi bi-share"></i> Bagikan</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <h4 class="mt-3">{{ $datasets->judul }}</h4>
                                    <p><?php echo $datasets->deskripsi; ?>
                                        <br>
                                        <i>
                                            (Sumber : {{ $datasets->nama_opd }}, {{ $datasets->tahun_datasets }} )
                                        </i>
                                    </p>
                                    @for ($i = 0; $i < count($tags); $i++)
                                        <span class="badge text-bg-secondary">#{{ $tags[$i] }}</span>
                                    @endfor
                                </div>

                                <div class="col-md-12">
                                    <div class="card-body">
                                        <nav class="mt-3">
                                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                                <button
                                                    class="nav-link fw-bolder @if (!app('request')->input('grafik') && !app('request')->input('peta')) active @endif "
                                                    id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home"
                                                    type="button" role="tab" aria-controls="nav-home"
                                                    aria-selected="true">
                                                    <i class="bi bi-table"></i> Tabel
                                                </button>
                                                <button class="nav-link fw-bolder" id="nav-profile-tab" data-bs-toggle="tab"
                                                    data-bs-target="#nav-profile" type="button" role="tab"
                                                    aria-controls="nav-profile" aria-selected="false">
                                                    <i class="bi bi-clipboard-check"></i> Metadata
                                                </button>
                                                <button
                                                    class="nav-link fw-bolder @if (app('request')->input('grafik')) active @endif "
                                                    id="nav-grafik-tab" data-bs-toggle="tab" data-bs-target="#nav-grafik"
                                                    type="button" role="tab" aria-controls="nav-grafik"
                                                    aria-selected="false">
                                                    <i class="bi bi-clipboard-data"></i> Grafik
                                                </button>
                                                <button
                                                    class="nav-link fw-bolder @if (app('request')->input('peta')) active @endif "
                                                    id="nav-peta-tab" data-bs-toggle="tab" data-bs-target="#nav-peta"
                                                    type="button" role="tab" aria-controls="nav-peta"
                                                    aria-selected="false">
                                                    <i class="bi bi-map"></i> Peta
                                                </button>
                                            </div>
                                        </nav>
                                        <style>
                                            .hero.hero-bg-image {
                                                background-position: center;
                                                background-size: cover;
                                            }

                                            .hero {
                                                border-radius: 3px;
                                                padding: 55px;
                                                display: flex;
                                                justify-content: center;
                                                flex-direction: column;
                                                position: relative;
                                            }

                                            .hero .hero-inner {
                                                position: relative;
                                                z-index: 1;
                                            }

                                            .hero p {
                                                margin-bottom: 0;
                                                font-size: 16px;
                                                letter-spacing: 0.3px;
                                            }

                                            .lead {
                                                line-height: 34px;
                                            }

                                            .lead {
                                                font-size: 1.25rem;
                                                font-weight: 300;
                                            }

                                            .status-align-right {
                                                padding-left: 50px;
                                            }

                                            html .njs-sticky-side.image_button_cover.placement-right {
                                                right: 0;
                                            }

                                            html .njs-sticky-side.image_button_cover {
                                                position: fixed;
                                                top: 50%;
                                                box-shadow: none;
                                                z-index: 99999;
                                                transition: transform .3s cubic-bezier(0, 0, 0, 1);
                                                -webkit-transition: -webkit-transform .3s cubic-bezier(0, 0, 0, 1);
                                            }

                                            html .njs-sticky-side.image_button_cover.placement-right.now-show a {
                                                transform: translate3d(4px, 0, 0) rotate(-90deg);
                                                -webkit-transform: translate3d(4px, 0, 0) rotate(-90deg);
                                            }

                                            html .njs-sticky-side.image_button_cover.placement-right a {
                                                border-radius: 3px 3px 0 0;
                                                transform: translate3d(200%, 0, 0) rotate(-90deg);
                                                -webkit-transform: translate3d(200%, 0, 0) rotate(-90deg);
                                                transform-origin: 100% 100%;
                                                -webkit-transform-origin: 100% 100%;
                                            }

                                            html .njs-sticky-side.image_button_cover a {
                                                padding: 6px 15px 12px;
                                                font-size: 18px;
                                                font-weight: 700;
                                                display: inline-block;
                                                position: relative;
                                                transition: transform .3s;
                                                -webkit-transition: -webkit-transform .3s;
                                                background-color: #FF7602;
                                                color: white;
                                                font-weight: 100;
                                                top: -106.5px;
                                                box-shadow: 10px 10px rgb(75, 78, 79);
                                                font-family: 'Arial';
                                            }

                                            html .njs-sticky-side.image_button_cover a:hover {
                                                background-color: white;
                                                color: black;
                                                border: 2px solid #acacac;
                                            }
                                        </style>
                                        <div class="tab-content" id="nav-tabContent">
                                            <div class="tab-pane fade @if (!app('request')->input('grafik') && !app('request')->input('peta')) show active @endif"
                                                id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab"
                                                tabindex="0">
                                                <div class="table-responsive mt-3">
                                                    <table class="table table-striped" id="table-5">
                                                        <thead class="text-white text-lowercase"
                                                            style="background-color: #1a42a9; font-size:14px">
                                                            <tr>
                                                                <?php
                                                                $kode_kab_kota = false;
                                                                $kode_kec = false;
                                                                $kode_keldes = false;
                                                                ?>
                                                                @foreach ($table as $column)
                                                                    @if ($column == 'kode_kabupaten_kota')
                                                                        <?php $kode_kab_kota = true; ?>
                                                                        <th>kode_kabupaten_kota</th>
                                                                        <th>nama_kabupaten_kota</th>
                                                                    @elseif ($column == 'kode_kecamatan')
                                                                        <?php $kode_kec = true; ?>
                                                                        <th>kode_kecamatan</th>
                                                                        <th>nama_kecamatan</th>
                                                                    @elseif ($column == 'kode_kelurahan_desa')
                                                                        <?php $kode_keldes = true; ?>
                                                                        <th>kode_kelurahan_desa</th>
                                                                        <th>nama_kelurahan_desa</th>
                                                                    @else
                                                                        <th>{{ $column }}</th>
                                                                    @endif
                                                                @endforeach
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="nav-profile" role="tabpanel"
                                                aria-labelledby="nav-profile-tab" tabindex="0">
                                                <h5 class="card-title mt-3 mb-3 ml-3 bolder">Meta Datasets</h5>
                                                <div class="table table-responsive">
                                                    <table class="table table-striped">
                                                        <tbody>
                                                            <tr>
                                                                <th scope="row">Datasets Diperbarui</th>
                                                                <td>:</td>
                                                                <td>{{ $datasets->updated_at->format('d F Y') }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Datasets Dibuat</th>
                                                                <td>:</td>
                                                                <td>{{ $datasets->created_at->format('d F Y') }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Walidata</th>
                                                                <td>:</td>
                                                                <td>Dinas Komunikasi dan Informatika Provinsi Jambi</td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Pengukuran Datasets</th>
                                                                <td>:</td>
                                                                <td>{{ $metadata->pengukuran_datasets ?? '-' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Tingkat Penyajian Datasets</th>
                                                                <td>:</td>
                                                                <td>{{ $metadata->tingkat_penyajian_datasets ?? '-' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Cakupan Datasets</th>
                                                                <td>:</td>
                                                                <td>{{ $metadata->cakupan_datasets ?? '-' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Bidang</th>
                                                                <td>:</td>
                                                                <td>{{ $metadata->bidang ?? '-' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Penanggung Jawab</th>
                                                                <td>:</td>
                                                                <td>{{ $metadata->penanggung_jawab ?? '-' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Kontak Produsen</th>
                                                                <td>:</td>
                                                                <td>{{ $metadata->kontak_produsen ?? '-' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Kode Indikator</th>
                                                                <td>:</td>
                                                                <td>{{ $metadata->kode_indikator ?? '-' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Bidang Urusan</th>
                                                                <td>:</td>
                                                                <td>{{ $metadata->bidang_urusan ?? '-' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Satuan Dataset</th>
                                                                <td>:</td>
                                                                <td>{{ $metadata->satuan_datasets ?? '-' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Frekuensi Datasets</th>
                                                                <td>:</td>
                                                                <td>{{ $metadata->frekuensi_datasets ?? '-' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Dimensi Dataset</th>
                                                                <td>:</td>
                                                                <td>{{ $metadata->dimensi_datasets ?? '-' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Produsen Data</th>
                                                                <td>:</td>
                                                                <td>{{ $datasets->nama_opd }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Judul Kegiatan</th>
                                                                <td>:</td>
                                                                <td>{{ $datasets->judul }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Dataset Diupload</th>
                                                                <td>:</td>
                                                                <td>{{ $datasets->created_at->format('d M Y') }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Diupload Oleh</th>
                                                                <td>:</td>
                                                                <td>{{ $user->name }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Tahun Datasets</th>
                                                                <td>:</td>
                                                                <td>{{ $datasets->tahun_datasets }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Metadata (Ms-Kegiatan, Ms-Variabel dan Ms-indikator)
                                                                </th>
                                                                <td>:</td>
                                                                <td> <a
                                                                        href="{{ route('download_metadata', $datasets->id) }}">Download
                                                                        Metadata</a></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade @if (app('request')->input('grafik')) show active @endif"
                                                id="nav-grafik" role="tabpanel" aria-labelledby="nav-grafik-tab"
                                                tabindex="0">
                                                <h5 class="card-title mt-3 mb-3 ml-3 bolder">Grafik Datasets</h5>
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        {!! $chart->container() !!}
                                                    </div>
                                                    <div class="col-md-4">
                                                        <h6 class="fw-bold">Sesuaikan Tampilan Grafik</h6>
                                                        <form
                                                            action="{{ route('web-datasets.show', [$datasets->id, $text]) }}">
                                                            <div class="mb-3">
                                                                <label for="gayaGrafik" class="form-label">Gaya
                                                                    Grafik</label>
                                                                <select class="form-select" name="grafik">
                                                                    <option value="bar"
                                                                        {{ app('request')->input('grafik') == 'bar' ? 'selected' : '' }}>
                                                                        Bar</option>
                                                                    <option value="line"
                                                                        {{ app('request')->input('grafik') == 'line' ? 'selected' : '' }}>
                                                                        Line</option>
                                                                </select>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="grupKolomX" class="form-label">Grup Kolom
                                                                    X</label>
                                                                <select class="form-select" name="index_x">
                                                                    @for ($i = 0; $i < count($table); $i++)
                                                                        <option value="{{ $i }}"
                                                                            {{ app('request')->input('index_x') == $i ? 'selected' : '' }}>
                                                                            {{ $table[$i] }}
                                                                        </option>
                                                                    @endfor
                                                                </select>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="grupKolomY" class="form-label">Grup Kolom
                                                                    Y</label>
                                                                <select class="form-select" name="index_y">
                                                                    @for ($i = 0; $i < count($table); $i++)
                                                                        <option value="{{ $i }}"
                                                                            {{ app('request')->input('index_y') == $i ? 'selected' : '' }}>
                                                                            {{ $table[$i] }}
                                                                        </option>
                                                                    @endfor
                                                                </select>
                                                            </div>
                                                            <div class="d-grid gap-2">
                                                                <button type="submit"
                                                                    class="btn btn-primary d-block">Pratinjau <i
                                                                        class="bi bi-eye"></i></button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade @if (app('request')->input('peta')) show active @endif"
                                                id="nav-peta" role="tabpanel" aria-labelledby="nav-peta-tab"
                                                tabindex="0">
                                                <div class="row">
                                                    <div class="col-md-8 mt-3">
                                                        <div id="map" style="height: 400px;"></div>
                                                    </div>
                                                    <div class="col-md-4 mt-3">
                                                        <h6 class="fw-bold">Sesuaikan Tampilan Peta</h6>
                                                        <form
                                                            action="{{ route('web-datasets.show', [$datasets->id, $text]) }}">
                                                            <div class="mb-3">
                                                                <label for="gayaPeta" class="form-label">Spasial
                                                                    Peta</label>
                                                                <select class="form-select" name="peta" id="gayaPeta"
                                                                    disabled>
                                                                    <option value="kode_kabupaten_kota"
                                                                        {{ app('request')->input('peta') == 'kode_kabupaten_kota' ? 'selected' : '' }}>
                                                                        kode_kabupaten_kota</option>
                                                                </select>
                                                            </div>
                                                            <input type="hidden" name="peta"
                                                                value="kode_kabupaten_kota">
                                                            <div class="mb-3">
                                                                <label for="grupValue" class="form-label">Value</label>
                                                                <select class="form-select" name="value_peta">
                                                                    @for ($i = 0; $i < count($table); $i++)
                                                                        <option value="{{ $table[$i] }}"
                                                                            {{ app('request')->input('value_peta') == $table[$i] ? 'selected' : '' }}>
                                                                            {{ $table[$i] }}
                                                                        </option>
                                                                    @endfor
                                                                </select>
                                                            </div>
                                                            <div class="d-grid gap-2">
                                                                <button type="submit"
                                                                    class="btn btn-primary d-block">Pratinjau <i
                                                                        class="bi bi-eye"></i></button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <style>
        .popup-card {
            background-color: white;
            border-radius: 8px;

            width: fit-content;
            height: fit-content;
        }

        .popup-card .line {
            margin-top: 8px;
            margin-bottom: 16px;
            width: 100%;
            height: 2px;
            border-radius: 999px;
            background-image: linear-gradient(to right, rgb(0, 80, 150), rgb(91, 176, 255));
        }

        .popup-card .text-wrapper {
            margin-bottom: 16px;
        }
    </style>
    <script>
        document.getElementById('nav-peta-tab').addEventListener('shown.bs.tab', function() {
            map.invalidateSize();
        });
    </script>
    <script>
        var map = L.map('map').setView([-1.603010, 103.583527], 7);

        L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        var json = @json($maps_data);
        var dataArray = json.original || [];

        function popUp(feature, layer) {
            let info = dataArray.find(item => item.nama_kabupaten === feature.properties.KAB_KOTA);

            if (feature.properties && feature.properties.KAB_KOTA) {
                let popupContent = `
            <div class="popup-card">
                <h5 class="text-center">${feature.properties.KAB_KOTA}</h5>
                <div class="line"></div>
                <div class="text-wrapper">
                    <p>
                    Data yang terdapat di Kota/Kabupaten ini sebagai berikut:
                    <br>
                    <b>
                        <b>
                            {!! json_encode(app('request')->input('value_peta')) !!} : ${info ? info.value : 'Data tidak tersedia'}
                        </b>
                    </b>
                    </p>
                </div>
            </div>`;
                layer.bindPopup(popupContent);
            }
        }

        var mapsJson = new L.GeoJSON.AJAX(["{{ asset('assets/geojson/Kab.Jambi.geojson') }}"], {
            onEachFeature: function(feature, layer) {
                popUp(feature, layer);
                layer.addTo(map);
            }
        });

        mapsJson.addTo(map);
    </script>
    <!-- End #main -->
    @if (isset($chart))
        <script src="{{ $chart->cdn() }}"></script>
        {{ $chart->script() }}
    @endif

    <!-- FeedBack Modal -->
    <div class="modal fade" id="feedback_modal" tabindex="-1" aria-labelledby="feedback_modalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="feedback_modalLabel">Feedback Form</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('web-datasets.ulasan', $datasets->id) }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label fw-bold">Seberapa besar Anda ingin
                                merekomendasikan Open Data Provinsi Jambi kepada orang lain?</label>
                            <select class="form-select" name="question1" aria-label="Default select example" required>
                                <option value="" selected>== Pilih Salah Satu ==</option>
                                <option value="Sangat Merekomendasikan">Sangat Merekomendasikan</option>
                                <option value="Cukup Merekomendasikan">Cukup Merekomendasikan</option>
                                <option value="Tidak Merekomendasikan">Tidak Merekomendasikan</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label fw-bold">Apakah datasets ini sangat
                                membantu?</label>
                            <select class="form-select" name="question2" aria-label="Default select example" required>
                                <option value="" selected>== Pilih Salah Satu ==</option>
                                <option value="Sangat Membantu">Sangat Membantu</option>
                                <option value="Cukup Membantu">Cukup Membantu</option>
                                <option value="Tidak Membantu">Tidak Membantu</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label fw-bold">Berikan saran dan masukan
                                Anda untuk
                                Open Data Provinsi Jambi agar kami dapat memberikan layanan lebih baik lagi</label>
                            <textarea name="saran" class="form-control" id="exampleFormControlInput1" cols="30" rows="5"></textarea>
                        </div>
                        <div class="mb-3">
                            {!! htmlFormSnippet() !!}
                        </div>
                        <div class="d-grid gap-2">
                            <button class="btn btn-success" type="submit">Kirim</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End FeedBack Modal -->

    <!-- Share Modal -->
    <div class="modal fade" id="share_modal" tabindex="-1" aria-labelledby="share_modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="share_modalLabel">Bagikan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- Modal Body -->
                <div class="modal-body">
                    <!-- Share Link Section -->
                    <div class="mb-3">
                        <label for="share-url" class="form-label"
                            style="text-align: left;"><strong>Tautan</strong></label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="share-url" style="font-size: 12px;"
                                value="" readonly>
                            <button class="btn" type="button" id="copy-url-btn"
                                style="font-size: 12px; background-color: rgba(26,29,148,255); color: white; border: none;">Salin</button>
                        </div>
                        <div class="form-text text-success mt-1 d-none" id="copy-success">Tautan berhasil disalin</div>
                    </div>

                    <!-- Citation Section -->
                    <div class="mb-3">
                        <div class="mb-2 d-flex align-items-center">
                            <label for="citation-format" class="form-label me-2"><strong>Kutipan</strong></label>
                            <select class="form-select" id="citation-format" style="width: 20%; font-size: 11px;">
                                <option value="apa" style="font-size: 12px;">APA</option>
                                <option value="mla" style="font-size: 12px;">MLA</option>
                                <option value="harvard" style="font-size: 12px;">Harvard</option>
                            </select>
                        </div>
                        <div class="mt-2 p-2 border rounded">
                            <p id="citation-text" class="mb-0" style="font-size: 14px">
                                <!-- Initial APA Citation will be populated by JavaScript -->
                            </p>
                        </div>
                        <button class="btn mt-2 w-100 ms-0" type="button" id="copy-cite-btn"
                            style="font-size: 12px; background-color: rgba(26,29,148,255); color: white; border: none;">Salin
                            Kutipan</button>
                        <div class="form-text text-success mt-1 d-none" id="copy-success-citation">Kutipan berhasil
                            disalin</div>
                    </div>

                    <!-- Social Media Share Section -->
                    <div class="d-flex justify-content-center">
                        <a href="#" id="facebook-share" target="_blank"
                            style="text-align: center; text-decoration: none; width: 50px;" class="me-2">
                            <img src="{{ asset('assets/img/socials/facebook.svg') }}" alt="Facebook"
                                style="width: 48px; height: 48px;">
                            <span style="font-size: 8px; color: black;">Facebook</span>
                        </a>
                        <a href="#" id="twitter-share" target="_blank"
                            style="text-align: center; text-decoration: none; width: 50px;" class="me-2">
                            <img src="{{ asset('assets/img/socials/twitter.svg') }}" alt="Facebook"
                                style="width: 48px; height: 48px;">
                            <span style="font-size: 8px; color: black;">Twitter</span>
                        </a>
                        <a href="#" id="whatsapp-share" target="_blank"
                            style="text-align: center; text-decoration: none; width: 50px;" class="me-2">
                            <img src="{{ asset('assets/img/socials/whatsapp.svg') }}" alt="Facebook"
                                style="width: 48px; height: 48px;">
                            <span style="font-size: 8px; color: black;">WhatsApp</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#table-5').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('web-datasets.fetch', ['id' => $datasets->id, 'bearer' => '3bd2f3f9059ff21e2ff85bb7b803728f']) }}",
                    type: 'GET',
                    dataSrc: function(json) {
                        // console.log('AJAX response data:', json);
                        return json
                            .data; // Pastikan json.data sesuai dengan data yang diambil dari server
                    }
                },
                columns: [
                    @foreach ($table as $column)
                        @if ($column == 'kode_kabupaten_kota')
                            {
                                data: 'kode_kabupaten_kota',
                                name: 'kode_kabupaten_kota',
                                searchable: true
                            }, {
                                data: 'nama_kabupaten_kota',
                                name: 'nama_kabupaten_kota',
                                searchable: true
                            },
                        @elseif ($column == 'kode_kecamatan') {
                                data: 'kode_kecamatan',
                                name: 'kode_kecamatan',
                                searchable: true
                            }, {
                                data: 'nama_kecamatan',
                                name: 'nama_kecamatan',
                                searchable: true
                            },
                        @elseif ($column == 'kode_kelurahan_desa') {
                                data: 'kode_kelurahan_desa',
                                name: 'kode_kelurahan_desa',
                                searchable: true
                            }, {
                                data: 'nama_kelurahan_desa',
                                name: 'nama_kelurahan_desa',
                                searchable: true
                            },
                        @else
                            {
                                data: '{{ $column }}',
                                name: '{{ $column }}',
                                searchable: true
                            },
                        @endif
                    @endforeach
                ],
                columnDefs: [{
                    targets: 0, // Cek apakah ID berada di kolom pertama
                    render: function(data, type, row, meta) {
                        return meta.row + 1 + meta.settings
                            ._iDisplayStart; // Menampilkan nomor urut yang berlanjut
                    }
                }],
                "paging": true, // Aktifkan pagination
                "pageLength": 10, // Tentukan jumlah baris per halaman
            });
        });

        // $('#table-5').DataTable({
        //         processing: true,
        //         serverSide: true,
        //         ajax: {
        //             url: "{{ route('web-datasets.fetch', ['id' => $datasets->id, 'bearer' => '3bd2f3f9059ff21e2ff85bb7b803728f']) }}",
        //             type: 'GET',
        //         },
        //         columns: [
        //             @foreach ($table as $column)
        //                 @if ($column == 'kode_kabupaten_kota')
        //                     {
        //                         data: 'kode_kabupaten_kota',
        //                         name: 'kode_kabupaten_kota'
        //                     }, {
        //                         data: 'nama_kabupaten_kota',
        //                         name: 'nama_kabupaten_kota'
        //                     },
        //                 @elseif ($column == 'kode_kecamatan') {
        //                         data: 'kode_kecamatan',
        //                         name: 'kode_kecamatan'
        //                     }, {
        //                         data: 'nama_kecamatan',
        //                         name: 'nama_kecamatan'
        //                     },
        //                 @elseif ($column == 'kode_kelurahan_desa') {
        //                         data: 'kode_kelurahan_desa',
        //                         name: 'kode_kelurahan_desa'
        //                     }, {
        //                         data: 'nama_kelurahan_desa',
        //                         name: 'nama_kelurahan_desa'
        //                     },
        //                 @else
        //                     {
        //                         data: '{{ $column }}',
        //                         name: '{{ $column }}'
        //                     },
        //                 @endif
        //             @endforeach
        //         ]
        //     });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Populate the share URL with the current page's URL
            const shareUrlInput = document.getElementById('share-url');
            shareUrlInput.value = window.location.href;

            // Copy URL to clipboard
            document.getElementById('copy-url-btn').addEventListener('click', function() {
                const copyText = document.getElementById('share-url');
                navigator.clipboard.writeText(copyText.value);
                document.getElementById('copy-success').classList.remove('d-none');
                setTimeout(() => {
                    document.getElementById('copy-success').classList.add('d-none');
                }, 2000);
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const citationText = document.getElementById('citation-text');
            const citationFormat = document.getElementById('citation-format');
            const currentDate = new Date().toLocaleDateString('id-ID', {
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            });
            const currentDate2 = new Date().toLocaleDateString('id-ID', {
                day: 'numeric',
                month: 'short',
                year: 'numeric'
            });
            // Pass the updated_at date from the dataset to JavaScript
            const updatedAt = "{{ $datasets->updated_at }}"; // Assuming you are using Laravel
            const updatedAtDate = new Date(updatedAt); // Convert the date string to a Date object

            // Format the updated_at date to "DD Month YYYY"
            const options = {
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            };
            const options2 = {
                year: 'numeric'
            };
            const formattedDate = updatedAtDate.toLocaleDateString('id-ID', options); // Format the date
            const formattedDate2 = updatedAtDate.toLocaleDateString('id-ID', options2); // Format the date

            const title = "{{ $datasets->judul }}";
            const url = window.location.href;

            // Function to update citation based on selected format
            function updateCitation(format) {
                let citation = '';

                switch (format) {
                    case 'apa':
                        citation =
                            `Jambi Data Analytic Center. (${formattedDate}). <i>${title}</i>. Diakses Pada ${currentDate}, dari ${url}`;
                        break;
                    case 'mla':
                        citation =
                            `Jambi Data Analytic Center. (${formattedDate}) .<i>${title}</i>. ${currentDate2}: ${url}.`;
                        break;
                    case 'harvard':
                        citation =
                            `Jambi Data Analytic Center. (${formattedDate2}). <i>${title}</i> [Online]. Tersedia di: ${url}.`;
                        break;
                    default:
                        citation =
                            `Jambi Data Analytic Center. (${formattedDate}). <i>${title}</i>. Retrieved from ${url}`;
                }

                citationText.innerHTML = citation;
            }

            // Initial citation update to APA format on page load
            updateCitation('apa');

            // Event listener to update citation when format is changed
            citationFormat.addEventListener('change', function() {
                updateCitation(this.value);
            });

            // Copy citation text to clipboard
            document.getElementById('copy-cite-btn').addEventListener('click', function() {
                navigator.clipboard.writeText(citationText.innerText);
                const copySuccessCitation = document.getElementById('copy-success-citation');
                copySuccessCitation.classList.remove('d-none');
                setTimeout(() => {
                    copySuccessCitation.classList.add('d-none');
                }, 2000);
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const currentUrl = window.location.href; // Get the current page URL

            // Set the share links
            document.getElementById('facebook-share').href =
                `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(currentUrl)}`;
            document.getElementById('twitter-share').href =
                `https://twitter.com/intent/tweet?url=${encodeURIComponent(currentUrl)}`;
            document.getElementById('whatsapp-share').href =
                `https://api.whatsapp.com/send?text=${encodeURIComponent(currentUrl)}`;
        });
    </script>
@endsection
