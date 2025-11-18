@extends('super-admin/layout/layout')
@section('title', 'Form Edit Permohonan Data')
@section('main')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit Permohonan Data</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Permohonan Data</a></div>
                    <div class="breadcrumb-item"><a href="#">Edit Data</a></div>
                    <div class="breadcrumb-item">Form Edit Data</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Form Edit Permohonan Data</h2>
                <p class="section-lead">Ini adalah halaman untuk Mengubah Permohonan Data kedalam sistem.</p>

                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Input Permohonan Data</h4>
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
                                <form action="{{ route('permohonan-data.update', $data->id) }}" runat="server"
                                    enctype="multipart/form-data" method="post">
                                    @csrf
                                    @method('patch')
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="nama_lengkap" class="form-label">*Nama Lengkap</label>
                                                <input type="text" class="form-control" placeholder="Masukan Nama Depan"
                                                    id="nama_lengkap" name="nama_lengkap"
                                                    value="{{ old('nama_lengkap', $data->nama) }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="email" class="form-label">*Email</label>
                                                <input type="email" class="form-control" placeholder="Masukan Email"
                                                    id="email" name="email" value="{{ old('email', $data->email) }}"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="telephone" class="form-label">*No Telp</label>
                                                <input type="tel" class="form-control" name="no_tlp"
                                                    placeholder="08xx xxxx xxxx" maxlength="12" title="Nomor Telephone"
                                                    value="{{ old('no_tlp', $data->no_tlp) }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="judul_datasets" class="form-label">*Judul Datasets</label>
                                                <input type="text" class="form-control"
                                                    placeholder="Masukan Judul Datasets" id="judul_datasets"
                                                    name="judul_datasets"
                                                    value="{{ old('judul_datasets', $data->judul_datasets) }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="opd" class="form-label">*Organisasi Perangkat
                                                    Daerah</label>
                                                <select class="form-control" aria-label="Default select example"
                                                    name="opd" required>
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
                                                <label for="status" class="form-label">Status</label>
                                                <select class="form-control" aria-label="Default select example"
                                                    name="status" required>
                                                    <option value="" selected>=== Pilih Salah Satu ===</option>
                                                    <option value="terkirim"
                                                        @if ($data->status == 'terkirim') selected @endif>
                                                        Terkirim</option>
                                                    <option value="verifikasi"
                                                        @if ($data->status == 'verifikasi') selected @endif>Verifikasi
                                                    </option>
                                                    <option value="diproses"
                                                        @if ($data->status == 'diproses') selected @endif>Diproses</option>
                                                    <option value="terbit"
                                                        @if ($data->status == 'terbit') selected @endif>Terbit</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="id_datasets" class="form-label">Datasets</label>
                                                <select class="form-control" aria-label="Default select example"
                                                    name="id_datasets">
                                                    <option value="" selected>=== Pilih Salah Satu ===</option>
                                                    @foreach ($datasets as $item)
                                                        <option value="{{ $item->id }}">{{ $item->judul }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="deskripsi" class="form-label">*Deskripsi</label>
                                                <textarea class="form-control" name="deskripsi" id="deskripsi" cols="30" rows="5" required>{{ old('deskripsi', $data->deskripsi) }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="tujuan" class="form-label">*Tujuan</label>
                                                <textarea class="form-control" name="tujuan" id="tujuan" cols="10" rows="5" required>{{ old('tujuan', $data->tujuan) }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="template" class="form-label">Template</label>
                                                <input type="file" class="form-control" placeholder="Masukan Template"
                                                    id="template" name="template">
                                                <div id="emailHelp" class="form-text"><a
                                                        href="{{ asset('assets/permohonan-data/' . $data->upload_template) }}"
                                                        target="_blank">Lihat
                                                        file lama.</a></div>
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
