@extends('super-admin/layout/layout')
@section('title', 'API Datasets')
@section('main')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>API Datasets</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">API Datasets</a></div>
                    <div class="breadcrumb-item">Tabel API Datasets</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">API Datasets</h2>
                <p class="section-lead">
                    Ini adalah halaman Datasets Jambi data dan Analitik Center.
                </p>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4>Daftar API Datasets</h4>
                                <a href="{{ route('datasets-api.create') }}" class="btn btn-primary">Tambah API Datasets <i
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
                                                <th>Judul</th>
                                                <th>Nama OPD</th>
                                                <th>Sifat Datasets</th>
                                                <th>Kategori</th>
                                                <th>Dataset Dibuat</th>
                                                <th>Dataset Diupdate</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($api_datasets as $item)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $item->judul }}</td>
                                                    <td>{{ $item->opd->nama_opd }}</td>
                                                    <td>
                                                        @if ($item->sifat_datasets == 'PUBLIK')
                                                            <span
                                                                class="badge badge-primary">{{ $item->sifat_datasets }}</span>
                                                        @else
                                                            <span
                                                                class="badge badge-warning">{{ $item->sifat_datasets }}</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $item->sektor->nama_sektor }}</td>
                                                    <td>{{ $item->created_at }}</td>
                                                    <td>{{ $item->updated_at }}</td>
                                                    <td>
                                                        <div class="dropdown d-inline mr-2">
                                                            <button class="btn btn-primary dropdown-toggle" type="button"
                                                                id="dropdownMenuButton" data-toggle="dropdown"
                                                                aria-haspopup="true" aria-expanded="false">
                                                                Pilih Aksi
                                                            </button>
                                                            <div class="dropdown-menu" x-placement="bottom-start"
                                                                style="position: absolute; transform: translate3d(0px, 28px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                                <a class="dropdown-item"
                                                                    href="{{ route('datasets-api.show', $item->id) }}">Details</a>
                                                                <a class="dropdown-item"
                                                                    href="{{ route('datasets-api.edit', $item->id) }}">Edit</a>
                                                                <a class="dropdown-item"
                                                                    href="{{ route('datasets-api.destroy', $item->id) }}"
                                                                    data-confirm-delete="true">Delete</a>
                                                            </div>
                                                        </div>
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
