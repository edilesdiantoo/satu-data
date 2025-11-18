@extends('opd/layout/layout')
@section('title', 'Datasets')
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
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4>Daftar Datasets</h4>
                                <a href="{{ route('opddatasets.create') }}" class="btn btn-primary">Tambah Datasets <i
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
                                                <th>Diupload Oleh</th>
                                                <th>Tahun Datasets</th>
                                                <th>Sifat Datasets</th>
                                                <th>DB Datasets</th>
                                                <th>Status</th>
                                                <th>Jumlah Unduhan</th>
                                                <th>Dataset Dibuat</th>
                                                <th>Dataset Diupdate</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($datasets as $item)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $item->judul }}</td>
                                                    <td>{{ $item->nama_opd }}</td>
                                                    <td>{{ App\Http\Controllers\OPD\OpdDatasetsController::getDiuploadOleh($item->diupload_oleh) }}
                                                    </td>
                                                    <td>{{ $item->tahun_datasets }}</td>
                                                    <td>{{ $item->sifat_datasets }}</td>
                                                    <td>{{ $item->db_datasets }}</td>
                                                    <td>
                                                        @if ($item->status == 'PENDING')
                                                            <span class="badge badge-primary">Dalam Proses</span>
                                                        @elseif ($item->status == 'REPAIR')
                                                            <span class="badge badge-warning">Perlu Perbaikan</span>
                                                        @elseif ($item->status == 'REJECTED')
                                                            <span class="badge badge-danger">Ditolak</span>
                                                        @elseif ($item->status == 'APPROVED')
                                                            <span class="badge badge-success">Terverifikasi</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $item->jumlah_unduhan }}</td>
                                                    <td>{{ $item->created_at->format('d M Y H:i') }}</td>
                                                    <td>{{ $item->updated_at->format('d M Y H:i') }}</td>
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
                                                                    href="{{ route('opddatasets.show', $item->id) }}">Details</a>
                                                                <a class="dropdown-item"
                                                                    href="{{ route('opddatasets.edit', $item->id) }}">Edit</a>
                                                                <a class="dropdown-item"
                                                                    href="{{ route('opddatasets.destroy', $item->id) }}"
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
