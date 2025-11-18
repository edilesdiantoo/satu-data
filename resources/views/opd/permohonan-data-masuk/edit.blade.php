@extends('opd/layout/layout')
@section('title', 'Form Edit Permohonan Data Masuk')
@section('main')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit Permohonan Data Masuk</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Permohonan Data Masuk</a></div>
                    <div class="breadcrumb-item"><a href="#">Edit Data</a></div>
                    <div class="breadcrumb-item">Form Edit Data</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Form Edit Permohonan Data Masuk</h2>
                <p class="section-lead">Ini adalah halaman untuk Mengubah Permohonan Data Masuk kedalam sistem.</p>

                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Input Permohonan Data Masuk</h4>
                            </div>
                            <div class="card-body">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <form action="{{ route('opdprosespermohonan-data.terbit', $data->id) }}" runat="server"
                                    enctype="multipart/form-data" method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="nama_lengkap" class="form-label">*Nama Lengkap</label>
                                                <input type="text" class="form-control" placeholder="Masukan Nama Depan"
                                                    id="nama_lengkap" name="nama_lengkap"
                                                    value="{{ old('nama_lengkap', $data->nama) }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="email" class="form-label">*Email</label>
                                                <input type="email" class="form-control" placeholder="Masukan Email"
                                                    id="email" name="email" value="{{ old('email', $data->email) }}"
                                                    readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="telephone" class="form-label">*No Telp</label>
                                                <input type="tel" class="form-control" name="no_tlp"
                                                    placeholder="08xx xxxx xxxx" maxlength="12" title="Nomor Telephone"
                                                    value="{{ old('no_tlp', $data->no_tlp) }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="judul_datasets" class="form-label">*Judul Datasets</label>
                                                <input type="text" class="form-control"
                                                    placeholder="Masukan Judul Datasets" id="judul_datasets"
                                                    name="judul_datasets"
                                                    value="{{ old('judul_datasets', $data->judul_datasets) }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="opd" class="form-label">*Organisasi Perangkat
                                                    Daerah</label>
                                                <select class="form-control" aria-label="Default select example"
                                                    name="opd" readonly>
                                                    <option value="" selected>=== Pilih Salah Satu ===</option>
                                                    @foreach ($opd as $item)
                                                        <option value="{{ $item->id }}"
                                                            @if ($item->id == $data->opd) selected @endif>
                                                            {{ $item->nama_opd }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="id_datasets" class="form-label">Datasets</label>
                                                <select class="form-control select2" aria-label="Default select example"
                                                    name="id_datasets">
                                                    <option value="" selected>=== Pilih Salah Satu ===</option>
                                                    @foreach ($datasets as $item)
                                                        @if ($item->diupload_oleh == Auth::user()->id)
                                                            <option value="{{ $item->id }}"
                                                                @if ($item->id == $data->id_datasets) selected @endif>
                                                                {{ $item->judul }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="deskripsi" class="form-label">*Deskripsi</label>
                                                <textarea class="form-control" name="deskripsi" id="deskripsi" cols="30" rows="5" readonly>{{ old('deskripsi', $data->deskripsi) }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="tujuan" class="form-label">*Tujuan</label>
                                                <textarea class="form-control" name="tujuan" id="tujuan" cols="10" rows="5" readonly>{{ old('tujuan', $data->tujuan) }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="template" class="form-label">Template</label>
                                                <a href="{{ asset('assets/permohonan-data/' . $data->upload_template) }}"
                                                    target="_blank">Lihat
                                                    file.</a>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary mt-3" type="submit">Simpan Perubahan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
