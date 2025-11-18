@extends('opd/layout/layout')
@section('title', 'Artikel')
@section('main')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Artikel</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Data Artikel</a></div>
                    <div class="breadcrumb-item">Tabel Artikel</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Artikel</h2>
                <p class="section-lead">
                    Ini adalah halaman Artikel dalam Sistem Jambi data dan Analitik Center.
                </p>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4>Daftar Data Artikel</h4>
                                <a href="{{ route('opd-artikel.create') }}" class="btn btn-primary">Tambah Data <i
                                        class="fa fa-plus"></i></a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-1">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Gambar</th>
                                                <th>Judul</th>
                                                <th>Sektor</th>
                                                <th>Status</th>
                                                <th>Di Buat</th>
                                                <th>Di Update</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($artikel as $item)
                                                <tr>
                                                    <td class="text-center">
                                                        <img alt="image"
                                                            src="{{ asset('assets/artikel-thumbnail/' . $item->gambar) }}"
                                                            width="100" height="auto" data-toggle="tooltip"
                                                            title="{{ $item->judul }}">
                                                    </td>
                                                    <td>{{ $item->judul }}</td>
                                                    <td>
                                                        @foreach ($sektor as $item_sektor)
                                                            @if ($item->id_sektor == $item_sektor->id)
                                                                {{ $item_sektor->nama_sektor }}
                                                            @endif
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        @if ($item->status == 'publish')
                                                            <span class="badge bg-success"> Publish</span>
                                                        @else
                                                            <span class="badge bg-secondary"> Draft</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $item->created_at->format('d M Y h:i') }}</td>
                                                    <td>{{ $item->updated_at->format('d M Y h:i') }}</td>
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
                                                                    href="{{ route('opd-artikel.edit', $item->id) }}">Edit</a>
                                                                <a class="dropdown-item"
                                                                    href="{{ route('opd-artikel.destroy', $item->id) }}"
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
