@extends('super-admin/layout/layout')
@section('title', 'Api Badan Pusat Statistik')
@section('main')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Api Badan Pusat Statistik</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Data Api</a></div>
                    <div class="breadcrumb-item">Tabel Data Api</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Api Badan Pusat Statistik</h2>
                <p class="section-lead">
                    Ini adalah halaman Api Badan Pusat Statistik dalam sistem Jambi data dan Analitik Center.
                </p>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4>Daftar Data Api BPS</h4>
                                <a href="{{ route('bps.create') }}" class="btn btn-primary">Tambah Data<i
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
                                                <th>Kategori</th>
                                                <th>Sub Kategori</th>
                                                <th>Judul</th>
                                                <th>Slug</th>
                                                <th>Action</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($bps as $item)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $item->kategori }}</td>
                                                    <td>{{ $item->sub_kategori }}</td>
                                                    <td>{{ $item->judul }}</td>
                                                    <td>{{ $item->slug }}</td>
                                                    <td><a href="{{ route('bps.edit', $item->id) }}"
                                                            class="btn btn-info">Edit</a></td>
                                                    <td>
                                                        <a href="{{ route('bps.destroy', $item->id) }}"
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
