@extends('super-admin/layout/layout')
@section('title', 'Edit OPD')
@section('main')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Organisasi Perangkat Daerah</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Organisasi Perangkat Daerah</a></div>
                    <div class="breadcrumb-item"><a href="#">Edit Organisasi Perangkat Daerah</a></div>
                    <div class="breadcrumb-item">Form Edit Organisasi Perangkat Daerah</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Edit Organisasi Perangkat Daerah</h2>
                <p class="section-lead">
                    Ini adalah halaman Edit Organisasi Perangkat Daerah di Sistem Jambi data dan Analitik Center.
                </p>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Input Data</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('opd.update', $opd->id) }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('Patch')
                                    <div class="form-group">
                                        <label>Nama Organisasi Perangkat Daerah</label>
                                        <input type="text" name="nama_opd"
                                            class="form-control @error('nama_opd')is-invalid @enderror"
                                            value="{{ $opd->nama_opd }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Logo OPD</label>
                                        <input type="file" name="gambar"
                                            class="form-control @error('gambar')is-invalid @enderror">
                                    </div>
                                    <button class="btn btn-primary mt-3" type="submit">Simpan Perubahan Data</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
