@extends('super-admin/layout/layout')
@section('title', 'Berita')
@section('main')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Berita</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Data Berita</a></div>
                    <div class="breadcrumb-item">Tabel Berita</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Berita</h2>
                <p class="section-lead">
                    Ini adalah halaman Berita dalam sistem Jambi data dan Analitik Center.
                </p>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4>Daftar Data Berita</h4>
                                <a href="{{ route('berita.create') }}" class="btn btn-primary">Tambah Data <i
                                        class="fa fa-plus"></i></a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-1">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Gambar</th>
                                                <th>Judul</th>
                                                <th>Di Buat</th>
                                                <th>Di Update</th>
                                                <th>Action</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($berita as $item)
                                                <tr>
                                                    <td class="text-center">
                                                        <img alt="image"
                                                            src="{{ asset('assets/berita-thumbnail/' . $item->gambar) }}"
                                                            width="100" height="auto" data-toggle="tooltip"
                                                            title="{{ $item->judul }}">
                                                    </td>
                                                    <td>{{ $item->judul }}</td>
                                                    <td>{{ $item->created_at->format('d M Y h:i') }}</td>
                                                    <td>{{ $item->updated_at->format('d M Y h:i') }}</td>
                                                    <td><a href="{{ route('berita.edit', $item->id) }}"
                                                            class="btn btn-info">Edit</a></td>
                                                    <td>
                                                        <a href="{{ route('berita.destroy', $item->id) }}"
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
