@extends('super-admin/layout/layout')
@section('title', 'Buku Digital')
@section('main')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Buku Digital</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Data Buku Digital</a></div>
                    <div class="breadcrumb-item">Tabel Buku Digital</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Buku Digital</h2>
                <p class="section-lead">
                    Ini adalah halaman Buku Digital dalam Sistem Jambi data dan Analitik Center.
                </p>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4>Daftar Data Buku Digital</h4>
                                <a href="{{ route('buku-digital.create') }}" class="btn btn-primary">Tambah Buku <i
                                        class="fa fa-plus"></i></a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-1">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Cover</th>
                                                <th>Judul</th>
                                                <th>Sektor</th>
                                                <th>Url</th>
                                                <th>Di Buat Oleh</th>
                                                <th>Created</th>
                                                <th>Updated</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($buku as $item)
                                                <tr>
                                                    <td class="text-center">
                                                        <img alt="image" src="{{ asset('assets/buku/' . $item->cover) }}"
                                                            width="100" height="auto" data-toggle="tooltip"
                                                            title="{{ $item->judul }}">
                                                    </td>
                                                    <td>{{ $item->judul }}</td>
                                                    @foreach ($sektor as $item_sektor)
                                                        @if ($item->id_sektor == $item_sektor->id)
                                                            <td>{{ $item_sektor->nama_sektor }}</td>
                                                        @endif
                                                    @endforeach
                                                    <td>
                                                        <a href="{{ $item->url }}">{{ $item->url }}</a>
                                                    </td>
                                                    @foreach ($user as $item_user)
                                                        @if ($item_user->id == $item->id_users)
                                                            <td>{{ $item_user->name }}</td>
                                                        @endif
                                                    @endforeach
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
                                                                    href="{{ route('buku-digital.edit', $item->id) }}">Edit</a>
                                                                <a class="dropdown-item"
                                                                    href="{{ route('buku-digital.destroy', $item->id) }}"
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
