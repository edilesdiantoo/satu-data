@extends('super-admin/layout/layout')
@section('title', 'Publikasi')
@section('main')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Publikasi</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Publikasi</a></div>
                    <div class="breadcrumb-item">Tabel Publikasi</div>
                </div>
            </div>
            <div class="section-body">
                <h2 class="section-title">Publikasi</h2>
                <p class="section-lead">
                    Ini adalah halaman Publikasi Jambi data dan Analitik Center.
                </p>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4>Daftar Publikasi</h4>
                                <a href="{{ route('publikasi.create') }}" class="btn btn-primary">Tambah Publikasi <i
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
                                                <th>Cover</th>
                                                <th>Judul</th>
                                                <th>Sektor</th>
                                                <th>Status</th>
                                                <th>Deskripsi</th>
                                                <th>Diupload Oleh</th>
                                                <th>Created At</th>
                                                <th>Updated At</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($publikasi as $item)
                                                <tr>
                                                    <td class="text-center">{{ $loop->iteration }}</td>
                                                    <td><img src="{{ asset('assets/cover-publikasi/' . $item->cover) }}"
                                                            alt="{{ $item->cover }}" style="width: 150px;height:200px;">
                                                    </td>
                                                    <td>{{ $item->judul }}</td>
                                                    @foreach ($sektor as $item_sektor)
                                                        @if ($item->id_sektor == $item_sektor->id)
                                                            <td>{{ $item_sektor->nama_sektor }}</td>
                                                        @endif
                                                    @endforeach
                                                    <td>
                                                        @if ($item->status == 'proses')
                                                            <span class="badge badge-primary">Butuh Verifikasi</span>
                                                        @else
                                                            <span class="badge badge-success">Terverifikasi</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ substr($item->deskripsi, 0, 35) }}...</td>
                                                    @foreach ($users as $item_user)
                                                        @if ($item_user->id == $item->id_user)
                                                            <td>{{ $item_user->name }}</td>
                                                        @endif
                                                    @endforeach
                                                    <td>{{ $item->created_at->format('d M Y') }}</td>
                                                    <td>{{ $item->updated_at->format('d M Y') }}</td>
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
                                                                    href="{{ url('assets/publikasi/' . $item->file) }}">Lihat
                                                                    File</a>
                                                                <a class="dropdown-item"
                                                                    href="{{ route('publikasi.edit', $item->id) }}">Edit</a>
                                                                <a class="dropdown-item"
                                                                    href="{{ route('publikasi.destroy', $item->id) }}"
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
