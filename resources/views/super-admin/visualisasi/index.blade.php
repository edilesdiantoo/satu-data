@extends('super-admin/layout/layout')
@section('title', 'Data Visualisasi')
@section('main')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Visualisasi</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Visualisasi</a></div>
                    <div class="breadcrumb-item"><a href="#">Data Visualisasi</a></div>
                    <div class="breadcrumb-item">Tabel Visualisasi</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Data Visualisasi</h2>
                <p class="section-lead">
                    Ini adalah halaman data Visualisasi Jambi data dan Analitik Center.
                </p>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4>Daftar Visualisasi</h4>
                                <a href="{{ route('visualisasi.create') }}" class="btn btn-primary">Tambah Visualisasi <i
                                        class="fa fa-plus"></i></a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-1">
                                        <thead>
                                            <tr>
                                                <th class="text-center">
                                                    No
                                                </th>
                                                <th>Gambar</th>
                                                <th>Judul</th>
                                                <th>Deskripsi</th>
                                                <th>Sektor</th>
                                                <th>Kategori</th>
                                                <th>Created At</th>
                                                <th>Action</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($visualisasi as $item)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>
                                                        <img alt="image"
                                                            src="{{ asset('assets/visualisasi-thumbnail/' . $item->gambar) }}"
                                                            width="100" height="auto" data-toggle="tooltip"
                                                            title="{{ $item->judul }}">
                                                    </td>
                                                    <td>{{ $item->judul }}</td>
                                                    <td>{{ $item->deskripsi }}</td>
                                                    <td>
                                                        @foreach ($sektor as $item_sektor)
                                                            @if ($item->sektor == $item_sektor->id)
                                                                {{ $item_sektor->nama_sektor }}
                                                            @endif
                                                        @endforeach
                                                    </td>
                                                    <td class="text-capitalize">{{ $item->kategori }}</td>
                                                    <td>{{ $item->created_at->format('d M Y') }}</td>
                                                    <td><a href="{{ route('visualisasi.edit', $item->id) }}"
                                                            class="btn btn-info">Edit</a></td>
                                                    <td>
                                                        <a href="{{ route('visualisasi.destroy', $item->id) }}"
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
