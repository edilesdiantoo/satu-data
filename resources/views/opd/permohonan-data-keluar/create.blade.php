@extends('opd/layout/layout')
@section('title', 'Form Tambah Permohonan Data')
@section('main')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Tambah Permohonan Data</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Permohonan Data</a></div>
                    <div class="breadcrumb-item"><a href="#">Tambah Data</a></div>
                    <div class="breadcrumb-item">Form Tambah Data</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Form Tambah Permohonan Data</h2>
                <p class="section-lead">Ini adalah halaman untuk menambahkan Permohonan Data kedalam sistem.</p>

                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Input Permohonan Data</h4>
                            </div>

                            <div class="card-body">
                                <form action="{{ route('opdpermohonan-data.store') }}" enctype="multipart/form-data"
                                    runat="server" method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="nama_lengkap" class="form-label">*Nama Lengkap</label>
                                                <input type="text" class="form-control" placeholder="Masukan Nama Depan"
                                                    id="nama_lengkap" name="nama_lengkap" value="{{ Auth::user()->name }}"
                                                    readonly>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="email" class="form-label">*Email</label>
                                                <input type="email" class="form-control" placeholder="Masukan Email"
                                                    id="email" name="email" value="{{ Auth::user()->email }}"
                                                    readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="telephone" class="form-label">*No Telp</label>
                                                <input type="tel" class="form-control" name="no_tlp"
                                                    placeholder="08xx xxxx xxxx" maxlength="12" title="Nomor Telephone"
                                                    value="{{ old('no_tlp') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="judul_datasets" class="form-label">*Judul Datasets</label>
                                                <input type="text" class="form-control"
                                                    placeholder="Masukan Judul Datasets" id="judul_datasets"
                                                    name="judul_datasets" value="{{ old('judul_datasets') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="question" class="form-label">*Apakah Anda
                                                    Mengetahui OPD Penghasil Sumber
                                                    Datasets ?</label>
                                                <select class="form-control @error('question')is-invalid @enderror select2 "
                                                    aria-label="Default select example" name="question"
                                                    onchange="yesnoCheck(this);" required>
                                                    <option value="" selected>=== Pilih Salah Satu ===</option>
                                                    <option value="tahu">Mengetahui</option>
                                                    <option value="tidak">Tidak Mengetahui</option>
                                                </select>
                                            </div>
                                        </div>
                                        <script>
                                            function yesnoCheck(that) {
                                                if (that.value == "tahu") {
                                                    alert("Input Instansi yang ingin diberikan !");
                                                    document.getElementById("instansi").style.display = "block";
                                                } else {
                                                    document.getElementById("instansi").style.display = "none";
                                                }
                                            }
                                        </script>
                                        <div class="col-md-6">
                                            <div id="instansi" style="display: none;">
                                                <div class="mb-3">
                                                    <label for="judul_datasets" class="form-label">*Organisasi Perangkat
                                                        Daerah</label>
                                                    <select class="form-control" aria-label="Default select example"
                                                        name="opd">
                                                        <option value="" selected>=== Pilih Salah Satu ===</option>
                                                        @foreach ($opd as $item)
                                                            <option value="{{ $item->id }}">{{ $item->nama_opd }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="deskripsi" class="form-label">*Deskripsi</label>
                                                <textarea class="form-control" name="deskripsi" id="deskripsi" cols="30" rows="5" required>{{ old('deskripsi') }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="tujuan" class="form-label">*Tujuan</label>
                                                <textarea class="form-control" name="tujuan" id="tujuan" cols="10" rows="5" required>{{ old('tujuan') }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="template" class="form-label">Template</label>
                                                <input type="file" class="form-control" placeholder="Masukan Template"
                                                    id="template" name="template">
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary mt-3" type="submit">Ajukan Permohonan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
