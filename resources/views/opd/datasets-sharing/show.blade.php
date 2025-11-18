@extends('opd/layout/layout')
@section('title', $datasets->judul)
@section('main')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Datasets</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('opddatasetsshare.index') }}">Shared Datasets</a>
                    </div>
                    <div class="breadcrumb-item">Tabel Datasets</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Datasets</h2>
                <p class="section-lead">
                    Ini adalah halaman Datasets Jambi data dan Analitik Center.
                </p>
                <div class="row">
                    @if ($datasets->status == 'REPAIR')
                        <div class="col-md-12">
                            <div class="alert alert-warning alert-has-icon">
                                <div class="alert-icon"><i class="fa fa-info-circle"></i></div>
                                <div class="alert-body">
                                    <div class="alert-title">Alasan Datasets Butuh Perbaikan</div>
                                    {{ $datasets->alasan }}
                                </div>
                            </div>
                        </div>
                    @elseif($datasets->status == 'REJECTED')
                        <div class="col-md-12">
                            <div class="alert alert-danger alert-has-icon">
                                <div class="alert-icon"><i class="fa fa-info-circle"></i></div>
                                <div class="alert-body">
                                    <div class="alert-title">Alasan Datasets Ditolak</div>
                                    {{ $datasets->alasan }}
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="col-12">
                        <div class="alert alert-primary alert-has-icon">
                            <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
                            <div class="alert-body">
                                <div class="alert-title">Unduh Datasets !</div>
                                Silahkan unduh datasets berikut dengan cara <a
                                    href="{{ route('share-datasets.download', ['id' => $datasets->id, 'slug' => $datasets->judul]) }}"><strong><u>Klik
                                            Disini</u></strong></a> untuk mulai mengunduh.
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4>Daftar Datasets</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-1">
                                        <thead class="bg-primary">
                                            <tr>
                                                <?php
                                                $kode_kab_kota = false;
                                                $kode_kec = false;
                                                $kode_keldes = false;
                                                ?>
                                                @for ($i = 0; $i < count($table); $i++)
                                                    @if ($table[$i] == 'id')
                                                        <Th class="text-white">id</Th>
                                                    @elseif($table[$i] == 'kode_kabupaten_kota')
                                                        <?php $kode_kab_kota = $i; ?>
                                                        <th>kode_kabupaten_kota</th>
                                                        <th>nama_kabupaten_kota</th>
                                                    @elseif($table[$i] == 'kode_kecamatan')
                                                        <?php $kode_kec = $i; ?>
                                                        <th>kode_kecamatan</th>
                                                        <th>nama_kecamatan</th>
                                                    @elseif($table[$i] == 'kode_kelurahan_desa')
                                                        <?php $kode_keldes = $i; ?>
                                                        <th>kode_kelurahan_desa </th>
                                                        <th>nama_kelurahan_desa</th>
                                                    @else
                                                        <th class="text-white">{{ $table[$i] }}</th>
                                                    @endif
                                                @endfor
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($data as $item)
                                                <tr>
                                                    @for ($i = 0; $i < count($table); $i++)
                                                        @if ($kode_kab_kota == $i && $kode_kab_kota != false)
                                                            @php
                                                                $wilayah = App\Http\Controllers\WebController\WilayahController::wilayah(
                                                                    $item[$table[$i]],
                                                                );
                                                            @endphp
                                                            <td>{{ $wilayah->kode ?? '-' }}</td>
                                                            <td>{{ $wilayah->nama ?? '-' }}</td>
                                                        @elseif($kode_kec == $i && $kode_kec != false)
                                                            @php
                                                                $wilayah = App\Http\Controllers\WebController\WilayahController::wilayah(
                                                                    $item[$table[$i]],
                                                                );
                                                            @endphp
                                                            <td>{{ $wilayah->kode ?? '-' }}</td>
                                                            <td>{{ $wilayah->nama ?? '-' }}</td>
                                                        @elseif($kode_keldes == $i && $kode_keldes != false)
                                                            @php
                                                                $wilayah = App\Http\Controllers\WebController\WilayahController::wilayah(
                                                                    $item[$table[$i]],
                                                                );
                                                            @endphp
                                                            <td>{{ $wilayah->kode ?? '-' }}</td>
                                                            <td>{{ $wilayah->nama ?? '-' }}</td>
                                                        @else
                                                            <td>{{ $item[$table[$i]] }}</td>
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
