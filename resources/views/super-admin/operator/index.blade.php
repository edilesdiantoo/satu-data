@extends('super-admin/layout/layout')
@section('title', 'Data Operator')
@section('main')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Operator</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Operator</a></div>
                    <div class="breadcrumb-item"><a href="#">Data Operator</a></div>
                    <div class="breadcrumb-item">Tabel Operator</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Data Operator</h2>
                <p class="section-lead">
                    Ini adalah halaman data Akun Operator Jambi data dan Analitik Center.
                </p>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4>Daftar Operator</h4>
                                <a href="{{ route('operator.create') }}" class="btn btn-primary">Tambah Operator <i
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
                                                <th>Photo</th>
                                                <th>Nama</th>
                                                <th>Email</th>
                                                <th>OPD</th>
                                                <th>Role</th>
                                                <th>Created At</th>
                                                <th>Action</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($users as $item)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>
                                                        <img alt="image"
                                                            src="{{ asset('assets/photo-profile/' . $item->photo) }}"
                                                            class="rounded-circle" width="35" data-toggle="tooltip"
                                                            title="{{ $item->name }}">
                                                    </td>
                                                    <td>{{ $item->name }}</td>
                                                    <td>{{ $item->email }}</td>
                                                    <td>
                                                        @foreach ($opd as $item_opd)
                                                            @if ($item->id_opd == $item_opd->id)
                                                                {{ $item_opd->nama_opd }}
                                                            @endif
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        <div class="badge badge-info">{{ $item->role }}</div>
                                                    </td>
                                                    <td>{{ $item->created_at }}</td>
                                                    <td><a href="{{ route('operator.edit', $item->id) }}"
                                                            class="btn btn-info">Edit</a></td>
                                                    <td>
                                                        <a href="{{ route('operator.destroy', $item->id) }}"
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
