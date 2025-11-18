@extends('super-admin/layout/layout')
@section('title', $data->judul)
@section('main')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Api Datasets</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Api Datasets</a></div>
                    <div class="breadcrumb-item">Tabel Api Datasets</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Api Datasets</h2>
                <p class="section-lead">
                    Ini adalah halaman Api Datasets Jambi data dan Analitik Center.
                </p>

                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-primary alert-has-icon">
                            <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
                            <div class="alert-body">
                                <div class="alert-title">Download Api Datasets !</div>
                                <a href="{{ route('datasets-api.download', ['id' => $data->id]) }}"><strong><u>Klik
                                            Disini</u></strong></a> untuk Mendownload Format.
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>API Datasets</h4>
                            </div>
                            <div class="card-body">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active show" id="home-tab" data-toggle="tab" href="#home"
                                            role="tab" aria-controls="home" aria-selected="true">Tabel</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile"
                                            role="tab" aria-controls="profile" aria-selected="false">Metadata</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="desc-tab" data-toggle="tab" href="#desc" role="tab"
                                            aria-controls="desc" aria-selected="false">Deskripsi</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade active show" id="home" role="tabpanel"
                                        aria-labelledby="home-tab">
                                        <div class="table-responsive">
                                            <table class="table table-striped" id="table-3">
                                                <thead>
                                                    <tr>
                                                        <?php
                                                        $kode_kab_kota = false;
                                                        $kode_kec = false;
                                                        $kode_keldes = false;
                                                        ?>
                                                        @for ($i = 0; $i < count($datasets['table']['header']); $i++)
                                                            @if ($datasets['table']['header'][$i] == 'id')
                                                                <Th>id</Th>
                                                            @elseif($datasets['table']['header'][$i] == 'kode_kabupaten_kota')
                                                                <?php $kode_kab_kota = $i; ?>
                                                                <th>kode_kabupaten_kota</th>
                                                                <th>nama_kabupaten_kota</th>
                                                            @elseif($datasets['table']['header'][$i] == 'kode_kecamatan')
                                                                <?php $kode_kec = $i; ?>
                                                                <th>kode_kecamatan</th>
                                                                <th>nama_kecamatan</th>
                                                            @elseif($datasets['table']['header'][$i] == 'kode_kelurahan_desa')
                                                                <?php $kode_keldes = $i; ?>
                                                                <th>kode_kelurahan_desa </th>
                                                                <th>nama_kelurahan_desa</th>
                                                            @else
                                                                <th>{{ $datasets['table']['header'][$i] }}</th>
                                                            @endif
                                                        @endfor
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    @foreach ($values as $row)
                                                        <tr>
                                                            @foreach ($row as $index => $column)
                                                                @if ($kode_kab_kota == $index && $kode_kab_kota !== false)
                                                                    @php
                                                                        $wilayah = App\Http\Controllers\WebController\WilayahController::wilayah(
                                                                            $column,
                                                                        );
                                                                    @endphp
                                                                    <td>{{ $wilayah->kode ?? '-' }}</td>
                                                                    <td>{{ $wilayah->nama ?? '-' }}</td>
                                                                @elseif ($kode_kec == $index && $kode_kec !== false)
                                                                    @php
                                                                        $wilayah = App\Http\Controllers\WebController\WilayahController::wilayah(
                                                                            $column,
                                                                        );
                                                                    @endphp
                                                                    <td>{{ $wilayah->kode ?? '-' }}</td>
                                                                    <td>{{ $wilayah->nama ?? '-' }}</td>
                                                                @elseif ($kode_keldes == $index && $kode_keldes !== false)
                                                                    @php
                                                                        $wilayah = App\Http\Controllers\WebController\WilayahController::wilayah(
                                                                            $column,
                                                                        );
                                                                    @endphp
                                                                    <td>{{ $wilayah->kode ?? '-' }}</td>
                                                                    <td>{{ $wilayah->nama ?? '-' }}</td>
                                                                @else
                                                                    <td>{{ $column }}</td>
                                                                @endif
                                                            @endforeach
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                        <table class="table table-bordered table-striped">
                                            <thead class="bg-primary">
                                                <tr>
                                                    <th class="text-white">Key</th>
                                                    <th class="text-white">Value</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Organisasi Perangkat Daerah</td>
                                                    <td>{{ $data->opd->nama_opd }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Pengukuran Datasets</td>
                                                    <td>{{ $datasets['metadata']['pengukuran_datasets'] }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Tingkat Penyajian Datasets</td>
                                                    <td>{{ $datasets['metadata']['tingkat_penyajian_datasets'] }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Cakupan Datasets</td>
                                                    <td>{{ $datasets['metadata']['cakupan_datasets'] }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Bidang</td>
                                                    <td>{{ $datasets['metadata']['bidang'] }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Penganggung Jawab</td>
                                                    <td>{{ $datasets['metadata']['penganggung_jawab'] }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Kontak Produsen</td>
                                                    <td>{{ $datasets['metadata']['kontak_produsen'] }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Kode Indikator</td>
                                                    <td>{{ $datasets['metadata']['kode_indikator'] }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Bidang Urusan</td>
                                                    <td>{{ $datasets['metadata']['bidang_urusan'] }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Satuan Datasets</td>
                                                    <td>{{ $datasets['metadata']['satuan_datasets'] }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Frekuensi Datasets</td>
                                                    <td>{{ $datasets['metadata']['frekuensi_datasets'] }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Dimensi Datasets</td>
                                                    <td>{{ $datasets['metadata']['dimensi_datasets'] }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Metadata</td>
                                                    <td><a href="{{ $datasets['metadata']['metadata'] }}"
                                                            target="_blank">Download Metadata</a></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane fade" id="desc" role="tabpanel" aria-labelledby="desc-tab">
                                        <?php echo $datasets['data']['deskripsi']; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
