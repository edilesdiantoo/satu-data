@extends('super-admin/layout/layout')
@section('title', 'Edit Sektor')
@section('main')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Sektor</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Sektor</a></div>
                    <div class="breadcrumb-item"><a href="#">Edit Sektor</a></div>
                    <div class="breadcrumb-item">Form Edit Sektor</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Edit Sektor</h2>
                <p class="section-lead">
                    Ini adalah halaman Edit Sektor di Sistem Jambi data dan Analitik Center.
                </p>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Input Data</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('sektor.update', $sektor->id) }}" method="post">
                                    @csrf
                                    @method('Patch')
                                    <div class="form-group">
                                        <label>Kategori Utama</label>
                                        <select class="form-control select2 @error('main_sektor')is-invalid @enderror"
                                            name="id_main_sektor">
                                            <option selected disabled>Pilih Salah Satu</option>
                                            @foreach ($main_sektor as $item)
                                                <option value="{{ $item->id }}"
                                                    @if (old('id_main_sektor', $sektor->id_main_sektor) == $item->id) selected @endif>
                                                    {{ $item->main_sektor }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Nama Kategori</label>
                                        <input type="text" name="nama_sektor"
                                            class="form-control @error('nama_sektor')is-invalid @enderror"
                                            value="{{ $sektor->nama_sektor }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Icon Kategori</label>
                                        <input type="text" name="icon"
                                            class="form-control @error('icon')is-invalid @enderror"
                                            value="{{ $sektor->icon }}">
                                    </div>
                                    <button class="btn btn-primary mt-3" type="submit">Simpan Perubahan Data</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
