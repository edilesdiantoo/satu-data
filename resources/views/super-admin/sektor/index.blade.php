@extends('super-admin/layout/layout')
@section('title', 'Data Sektor')
@section('main')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Sektor</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Sektor</a></div>
                    <div class="breadcrumb-item"><a href="#">Data Sektor</a></div>
                    <div class="breadcrumb-item">Tabel Sektor</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Data Sektor</h2>
                <p class="section-lead">
                    Ini adalah halaman data Akun Sektor Jambi data dan Analitik Center.
                </p>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Input Data</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('sektor.store') }}" method="post">
                                    @csrf

                                    <div class="form-group">
                                        <label>Kategori Utama</label>
                                        <select class="form-control select2 @error('main_sektor')is-invalid @enderror"
                                            name="id_main_sektor">
                                            <option selected disabled>Pilih Salah Satu</option>
                                            @foreach ($main_sektor as $item)
                                                <option value="{{ $item->id }}"
                                                    @if (old('id_main_sektor') == $item->id) selected @endif>
                                                    {{ $item->main_sektor }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Nama Kategori</label>
                                        <input type="text" name="nama_sektor"
                                            class="form-control @error('nama_sektor')is-invalid @enderror"
                                            value="{{ old('nama_sektor') }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Icon Kategori</label>
                                        <input type="text" name="icon"
                                            class="form-control @error('icon')is-invalid @enderror"
                                            value="{{ old('icon') }}">
                                    </div>
                                    <button class="btn btn-primary mt-3" type="submit">Tambah Data</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4>Daftar Sektor</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-1">
                                        <thead>
                                            <tr>
                                                <th class="text-center">
                                                    No
                                                </th>
                                                <th>Main Kategori</th>
                                                <th>Nama Kategori</th>
                                                <th>Icon Kategori</th>
                                                <th>Action</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($sektor as $item)
                                                <tr>
                                                    <td class="text-center">{{ $loop->iteration }}</td>
                                                    <td>
                                                        @foreach ($main_sektor as $item_main_sektor)
                                                            @if ($item_main_sektor->id == $item->id_main_sektor)
                                                                {{ $item_main_sektor->main_sektor }}
                                                            @endif
                                                        @endforeach
                                                    </td>
                                                    <td>{{ $item->nama_sektor }}</td>
                                                    <td>{{ $item->icon }}</td>
                                                    <td>
                                                        <a href="{{ route('sektor.edit', $item->id) }}"
                                                            class="btn btn-info">Edit</a>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('sektor.destroy', $item->id) }}"
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
