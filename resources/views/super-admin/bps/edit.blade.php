@extends('super-admin/layout/layout')
@section('title', 'Form Edit Data API')
@section('main')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit Data API</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Data API</a></div>
                    <div class="breadcrumb-item"><a href="#">Edit Data</a></div>
                    <div class="breadcrumb-item">Form Edit Data</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Form Edit Data API</h2>
                <p class="section-lead">Ini adalah halaman untuk Mengubah Data API kedalam sistem.</p>

                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Input Data API</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('bps.update', $bps->id) }}" runat="server" method="post">
                                    @csrf
                                    @method('patch')
                                    <div class="form-group">
                                        <label>Kategori</label>
                                        <select name="kategori" id="kategori" class="form-control select2">
                                            <option disabled>=== Pilih Salah Satu ===</option>
                                            @foreach ($kategori as $kat)
                                                <option value="{{ $kat['title'] }}"
                                                    {{ old('kategori', $selectedKategori) == $kat['title'] ? 'selected' : '' }}>
                                                    {{ $kat['title'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Sub Kategori</label>
                                        <select name="sub_kategori" id="sub-kategori"
                                            class="form-control @error('sub_kategori') is-invalid @enderror select2">
                                            <option disabled>=== Pilih Salah Satu ===</option>
                                            @foreach ($subkategori as $sub)
                                                @if (is_array($sub) && isset($sub['sub_id'], $sub['title']))
                                                    <option value="{{ $sub['title'] }}"
                                                        {{ old('sub_kategori', $selectedSubKategori) == $sub['title'] ? 'selected' : '' }}>
                                                        {{ $sub['title'] }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Judul</label>
                                        <input type="text" name="judul"
                                            class="form-control @error('judul')is-invalid @enderror"
                                            value="{{ old('judul', $bps->judul) }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Link Api</label>
                                        <input type="text" name="link_api"
                                            class="form-control @error('link_api')is-invalid @enderror"
                                            value="{{ old('link_api', $bps->link_api) }}">
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
