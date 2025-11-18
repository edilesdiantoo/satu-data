@extends('opd/layout/layout')
@section('title', $datasets->judul)
@section('main')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Datasets</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Datasets</a></div>
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
                                <div class="alert-title">Download Format Datasets !</div>
                                Harap Mengisi Datasets ini sesuai dengan Format ! dengan cara <a
                                    href="{{ route('role-datasets.download', ['id' => $datasets->id, 'slug' => $datasets->judul]) }}"><strong><u>Klik
                                            Disini</u></strong></a> untuk Mendownload Format.
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4>Upload .Csv</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('csv_upload.opd', $datasets->id) }}" enctype="multipart/form-data"
                                    method="post">
                                    @csrf
                                    <div class="form-group">
                                        <label>.Csv File</label>
                                        <input type="file" name="csv_file"
                                            accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                                            class="form-control @error('csv_file')is-invalid @enderror">
                                    </div>
                                    <div class="form-group">
                                        <label>Terminated by</label>
                                        <select name="terminated"
                                            class="form-control @error('terminated')is-invalid @enderror select2 ">
                                            <option selected disabled>=== Pilih Salah Satu ===</option>
                                            <option value=";" {{ old('terminated') == ';' ? 'selected' : '' }}>;
                                            </option>
                                            <option value="," {{ old('terminated') == ',' ? 'selected' : '' }}>,
                                            </option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-primary" type="submit">Upload</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4>Daftar Datasets</h4>
                                <div class="float-end">
                                    <div class="dropdown d-inline">
                                        <button class="btn btn-primary dropdown-toggle" type="button"
                                            id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            Pengaturan Datasets
                                        </button>
                                        <div class="dropdown-menu" x-placement="bottom-start"
                                            style="position: absolute; transform: translate3d(0px, 28px, 0px); top: 0px; left: 0px; will-change: transform;">
                                            <a class="dropdown-item has-icon"
                                                href="{{ route('role-datasets.download', ['id' => $datasets->id, 'slug' => $datasets->judul]) }}"><i
                                                    class="fas fa-download"></i>
                                                Download</a>
                                            <a class="dropdown-item has-icon" href="#add_kolom"><i class="fas fa-plus"></i>
                                                Tambah Kolom</a>
                                            <a class="dropdown-item has-icon" href="#edit_kolom"><i
                                                    class="fas fa-pencil-alt"></i>
                                                Edit Kolom</a>
                                            <a class="dropdown-item has-icon" href="#delete_kolom"><i
                                                    class="fas fa-trash"></i>
                                                Hapus Kolom</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-5">
                                        <thead>
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
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="card" id="add_kolom">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4><i class="fas fa-plus mr-2"></i>Tambah Kolom</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('tambah_kolom.opd', $datasets->id) }}" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <label>Nama Kolom</label>
                                        <input type="text" name="nama_kolom"
                                            class="form-control @error('nama_kolom')is-invalid @enderror">
                                    </div>

                                    <div class="form-group">
                                        <label>Kolom Setelah</label>
                                        <select name="kolom_setelah"
                                            class="form-control @error('kolom_setelah')is-invalid @enderror select2 ">
                                            <option selected disabled>=== Pilih Salah Satu ===</option>
                                            @for ($i = 0; $i < count($table); $i++)
                                                <option value="{{ $table[$i] }}"
                                                    {{ old('kolom_setelah') == $table[$i] ? 'selected' : '' }}>
                                                    @if ($table[$i] == 'id')
                                                        id
                                                    @else
                                                        {{ $table[$i] }}
                                                    @endif
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-primary" type="submit">Simpan Perubahan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="card" id="edit_kolom">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4><i class="fas fa-pencil-alt mr-2"></i>Ganti Nama Kolom</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('edit_nama_kolom.opd', $datasets->id) }}" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <label>Nama Kolom yang ingin Diganti</label>
                                        <select name="rename"
                                            class="form-control @error('rename')is-invalid @enderror select2 ">
                                            <option selected disabled>=== Pilih Salah Satu ===</option>
                                            @for ($i = 0; $i < count($table); $i++)
                                                <option value="{{ $table[$i] }}"
                                                    {{ old('rename') == $table[$i] ? 'selected' : '' }}>
                                                    @if ($table[$i] == 'id')
                                                        id
                                                    @else
                                                        {{ $table[$i] }}
                                                    @endif
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Nama Kolom</label>
                                        <input type="text" name="nama_kolom"
                                            class="form-control @error('nama_kolom')is-invalid @enderror">
                                    </div>

                                    <div class="form-group">
                                        <button class="btn btn-primary" type="submit">Simpan Perubahan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="card" id="delete_kolom">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4><i class="fas fa-trash mr-2"></i>Hapus Kolom</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('delete_kolom.opd', $datasets->id) }}" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <label>Nama Kolom yang ingin Dihapus</label>
                                        <select name="nama_kolom"
                                            class="form-control @error('nama_kolom')is-invalid @enderror select2 ">
                                            <option selected disabled>=== Pilih Salah Satu ===</option>
                                            @for ($i = 0; $i < count($table); $i++)
                                                <option value="{{ $table[$i] }}"
                                                    {{ old('nama_kolom') == $table[$i] ? 'selected' : '' }}>
                                                    @if ($table[$i] == 'id')
                                                        id
                                                    @else
                                                        {{ $table[$i] }}
                                                    @endif
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-danger" type="submit">Hapus Kolom</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
        $(document).ready(function() {
            $('#table-5').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('web-datasets.fetch', ['id' => $datasets->id, 'bearer' => '3bd2f3f9059ff21e2ff85bb7b803728f']) }}",
                    type: 'GET',
                },
                columns: [
                    @foreach ($table as $column)
                        @if ($column == 'kode_kabupaten_kota')
                            {
                                data: 'kode_kabupaten_kota',
                                name: 'kode_kabupaten_kota'
                            }, {
                                data: 'nama_kabupaten_kota',
                                name: 'nama_kabupaten_kota'
                            },
                        @elseif ($column == 'kode_kecamatan') {
                                data: 'kode_kecamatan',
                                name: 'kode_kecamatan'
                            }, {
                                data: 'nama_kecamatan',
                                name: 'nama_kecamatan'
                            },
                        @elseif ($column == 'kode_kelurahan_desa') {
                                data: 'kode_kelurahan_desa',
                                name: 'kode_kelurahan_desa'
                            }, {
                                data: 'nama_kelurahan_desa',
                                name: 'nama_kelurahan_desa'
                            },
                        @else
                            {
                                data: '{{ $column }}',
                                name: '{{ $column }}'
                            },
                        @endif
                    @endforeach
                ]
            });
        });
    </script>
@endsection
