@extends('opd/layout/layout')
@section('title', 'Permohonan Data Masuk')
@section('main')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Permohonan Data Masuk</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Data Permohonan Data Masuk</a></div>
                    <div class="breadcrumb-item">Tabel Permohonan Data Masuk</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Permohonan Data Masuk</h2>
                <p class="section-lead">
                    Ini adalah halaman Permohonan Data Masuk dalam Sistem Jambi data dan Analitik Center.
                </p>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4>Daftar Data Permohonan Data Masuk</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-1">
                                        <thead>
                                            <tr>
                                                <th>Judul</th>
                                                <th>ID Tracking</th>
                                                <th>Di Buat Oleh</th>
                                                <th>Status</th>
                                                <th>Created</th>
                                                <th>Updated</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data as $item)
                                                <tr>

                                                    <td>{{ $item->judul_datasets }}</td>
                                                    <td>{{ $item->id_tracking }}</td>
                                                    @if ($item->id_user == null)
                                                        <td>{{ $item->nama }}</td>
                                                    @else
                                                        @foreach ($user as $item_user)
                                                            @if ($item_user->id == $item->id_user)
                                                                <td>{{ $item_user->name }}</td>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                    <td>
                                                        @if ($item->status == 'terkirim')
                                                            <span class="badge badge-info">Permohonan Data diterima</span>
                                                        @elseif($item->status == 'verifikasi')
                                                            <span class="badge badge-primary">Terverifikasi</span>
                                                        @elseif($item->status == 'diproses')
                                                            <span class="badge badge-warning">Sedang Diproses</span>
                                                        @elseif($item->status == 'terbit')
                                                            <span class="badge badge-success">Telah Terbit</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $item->created_at->format('d M Y h:i') }}</td>
                                                    <td>{{ $item->updated_at->format('d M Y h:i') }}</td>
                                                    @if ($item->status == 'verifikasi')
                                                        <td>
                                                            <form
                                                                action="{{ route('opdprosespermohonan-data.masuk', $item->id) }}"
                                                                method="post">
                                                                @csrf
                                                                <input type="hidden" name="judul_datasets"
                                                                    value="{{ $item->judul }}">
                                                                <button type="submit" class="btn btn-success">Terima dan
                                                                    Proses
                                                                    Permohonan</button>
                                                            </form>
                                                        </td>
                                                    @else
                                                        <td>
                                                            <div class="dropdown d-inline mr-2">
                                                                <button class="btn btn-primary dropdown-toggle"
                                                                    type="button" id="dropdownMenuButton"
                                                                    data-toggle="dropdown" aria-haspopup="true"
                                                                    aria-expanded="false">
                                                                    Pilih Aksi
                                                                </button>
                                                                <div class="dropdown-menu" x-placement="bottom-start"
                                                                    style="position: absolute; transform: translate3d(0px, 28px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                                    <a class="dropdown-item"
                                                                        href="{{ route('opdpermohonan-data.edit', $item->id) }}">Edit</a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    @endif
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
