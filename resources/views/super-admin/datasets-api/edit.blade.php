@extends('super-admin/layout/layout')
@section('title', 'Form Edit API Datasets')
@section('main')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit API Datasets</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">API Datasets</a></div>
                    <div class="breadcrumb-item"><a href="#">Edit API Datasets</a></div>
                    <div class="breadcrumb-item">Form Edit API Datasets</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Form Edit API Datasets</h2>
                <p class="section-lead">Ini adalah halaman untuk Mengubah API Datasets kedalam sistem.</p>

                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <form action="{{ route('datasets-api.update', $api_datasets->id) }}" enctype="multipart/form-data"
                            runat="server" method="post">
                            @csrf
                            @method('patch')
                            <div class="card">
                                <div class="card-header">
                                    <h4>Input Datasets API</h4>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Judul</label>
                                        <input type="text" name="judul"
                                            class="form-control @error('judul')is-invalid @enderror"
                                            value="{{ old('judul', $api_datasets->judul) }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Nama OPD</label>
                                        <select name="id_opd"
                                            class="form-control @error('id_opd')is-invalid @enderror select2 ">
                                            <option selected disabled>=== Pilih Salah Satu ===</option>
                                            @foreach ($opd as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ old('id_opd', $api_datasets->id_opd) == $item->id ? 'selected' : '' }}>
                                                    {{ $item->nama_opd }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Sifat Datasets</label>
                                        <select name="sifat_datasets"
                                            class="form-control @error('sifat_datasets')is-invalid @enderror select2 ">
                                            <option selected disabled>=== Pilih Salah Satu ===</option>
                                            <option value="PUBLIK"
                                                {{ old('sifat_datasets', $api_datasets->sifat_datasets) == 'PUBLIK' ? 'selected' : '' }}>
                                                PUBLIK</option>
                                            <option value="PRIVATE"
                                                {{ old('sifat_datasets', $api_datasets->sifat_datasets) == 'PRIVATE' ? 'selected' : '' }}>
                                                PRIVATE</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Kategori Datasets</label>
                                        <select name="id_sektor"
                                            class="form-control @error('id_sektor')is-invalid @enderror select2 ">
                                            <option selected disabled>=== Pilih Salah Satu ===</option>
                                            @foreach ($main_sektor as $item_main)
                                                <optgroup label="{{ $item_main->main_sektor }}">
                                                    @foreach ($sektor as $item)
                                                        @if ($item_main->id == $item->id_main_sektor)
                                                            <option value="{{ $item->id }}"
                                                                {{ old('id_sektor', $api_datasets->id_sektor) == $item->id ? 'selected' : '' }}>
                                                                {{ $item->nama_sektor }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </optgroup>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Bearer</label>
                                        <input type="text" name="bearer"
                                            class="form-control @error('bearer')is-invalid @enderror"
                                            value="{{ old('bearer', $api_datasets->bearer) }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Link API</label>
                                        <input type="text" name="link_api"
                                            class="form-control @error('link_api')is-invalid @enderror"
                                            value="{{ old('link_api', $api_datasets->link_api) }}">
                                    </div>
                                    <button class="btn btn-primary mt-3" type="submit">Simpan Perubahan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
