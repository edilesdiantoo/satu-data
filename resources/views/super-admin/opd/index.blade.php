@extends('super-admin/layout/layout')
@section('title', 'Data OPD')
@section('main')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Organisasi Perangkat Daerah</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Organisasi Perangkat Daerah</a></div>
                    <div class="breadcrumb-item"><a href="#">Data Organisasi Perangkat Daerah</a></div>
                    <div class="breadcrumb-item">Tabel Organisasi Perangkat Daerah</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Data Organisasi Perangkat Daerah</h2>
                <p class="section-lead">
                    Ini adalah halaman data Akun Organisasi Perangkat Daerah Jambi data dan Analitik Center.
                </p>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Input Data</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('opd.store') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label>Nama Organisasi Perangkat Daerah</label>
                                        <input type="text" name="nama_opd"
                                            class="form-control @error('nama_opd')is-invalid @enderror"
                                            value="{{ old('nama_opd') }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Logo OPD</label>
                                        <input type="file" name="gambar"
                                            class="form-control @error('gambar')is-invalid @enderror">
                                    </div>
                                    <button class="btn btn-primary mt-3" type="submit">Tambah Data</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4>Daftar Organisasi Perangkat Daerah</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-1">
                                        <thead>
                                            <tr>
                                                <th class="text-center">
                                                    No
                                                </th>
                                                <th>Nama OPD</th>
                                                <th>Logo</th>
                                                <th>Action</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($opd as $item)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $item->nama_opd }}</td>
                                                    <td><img style="width: 52px; height:auto"
                                                            src="{{ asset('assets/opd/' . $item->gambar) }}"></td>
                                                    <td><a href="{{ route('opd.edit', $item->id) }}"
                                                            class="btn btn-info">Edit</a></td>
                                                    <td>
                                                        <a href="{{ route('opd.destroy', $item->id) }}"
                                                            class="btn btn-danger" data-confirm-delete="true">Delete</a>
                                                    </td>
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
