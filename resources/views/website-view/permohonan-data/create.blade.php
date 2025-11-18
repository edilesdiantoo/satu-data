@extends('website-view.layout.layout')
@section('title', 'Ajukan Permohonan Data')
@section('main')
    <main id="main">
        <!-- ======= Breadcrumbs Section ======= -->
        <section class="breadcrumbs">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center">
                    <h2>Ajukan Permohonan Data</h2>
                    <ol>
                        <li><a href="/">Home</a></li>
                        <li>Halaman Ajukan Permohonan Data</li>
                    </ol>
                </div>
            </div>
        </section><!-- End Breadcrumbs Section -->
        <section class="inner-page">
            <div class="container">
                <div class="row" style="padding-bottom: 20px;">
                    <div class="col-md-10">
                        <div class="section-title" style="padding-bottom: 0px;" data-aos="fade-up">
                            <h2>Ajukan Permohonan Data</h2>
                            <p>Form Permohonan Data</p>
                        </div>
                    </div>
                </div>

                <form action="{{ route('web-permohonan.store') }}" method="POST" enctype="multipart/form-data"
                    data-aos="fade-up">
                    @method('POST')
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                @if ($errors->any())
                                    <div class="col-md-12">
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                @endif
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="nama_depan" class="form-label" style="font-family:sans-serif">Nama Depan
                                            <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" placeholder="Masukan Nama Depan"
                                            id="nama_depan" name="nama_depan" value="{{ old('nama_depan') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="nama_belakang" class="form-label" style="font-family:sans-serif">Nama
                                            Belakang <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" placeholder="Masukan Nama Belakang"
                                            id="nama_belakang" name="nama_belakang" value="{{ old('nama_belakang') }}"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="email" class="form-label" style="font-family:sans-serif">Email <span
                                                class="text-danger">*</span></label>
                                        <input type="email" class="form-control" placeholder="Contoh: emailkamu@gmail.com"
                                            id="email" name="email" value="{{ old('email') }}" required>
                                        <div id="email" class="form-text text-danger">Email yang di inputkan harus aktif
                                            agar bisa menerima Kode Tracking.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="telephone" class="form-label" style="font-family:sans-serif">No Telp
                                            <span class="text-danger">*</span></label>
                                        <input type="tel" class="form-control" name="no_tlp"
                                            placeholder="08xx xxxx xxxx" maxlength="12" title="Nomor Telephone"
                                            value="{{ old('no_tlp') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="judul_datasets" class="form-label" style="font-family:sans-serif">Judul
                                            Datasets <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" placeholder="Masukan Judul Datasets"
                                            id="judul_datasets" name="judul_datasets" value="{{ old('judul_datasets') }}"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="template" class="form-label" style="font-family:sans-serif">Format
                                            Template Contoh(.pdf)</label>
                                        <input type="file" class="form-control"
                                            placeholder="Masukan Format Template Contoh" id="template" name="template"
                                            accept="application/pdf">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="question" class="form-label" style="font-family:sans-serif">Apakah Anda
                                            Mengetahui OPD Penghasil Sumber
                                            Datasets ? <span class="text-danger">*</span></label>
                                        <select class="form-select" aria-label="Default select example" name="question"
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
                                            <label for="judul_datasets" class="form-label"
                                                style="font-family:sans-serif">Organisasi Perangkat
                                                Daerah <span class="text-danger">*</span></label>
                                            <select class="form-select" aria-label="Default select example"
                                                name="opd">
                                                <option value="" selected>=== Pilih Salah Satu ===</option>
                                                @foreach ($opd as $item)
                                                    <option value="{{ $item->id }}">{{ $item->nama_opd }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="deskripsi" class="form-label"
                                            style="font-family:sans-serif">Deskripsi Data<span
                                                class="text-danger">*</span></label>
                                        <textarea class="form-control" name="deskripsi" id="deskripsi" cols="30" rows="5" required>{{ old('deskripsi') }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="tujuan" class="form-label" style="font-family:sans-serif">Tujuan
                                            Permohonan Data <span class="text-danger">*</span></label>
                                        <textarea class="form-control" name="tujuan" id="tujuan" cols="10" rows="5" required>{{ old('tujuan') }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary mt-3" style="font-family: sans-serif">
                                        <i class="bx bx-paper-plane"></i> Kirim Permohonan</button>
                                </div>
                                <div class="col-md-6">
                                    {!! htmlFormSnippet() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </main><!-- End #main -->
@endsection
