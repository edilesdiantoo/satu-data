@extends('opd/layout/layout')
@section('title', 'Form Tambah Data API')
@section('main')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Tambah Data API</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Data API</a></div>
                    <div class="breadcrumb-item"><a href="#">Tambah Data</a></div>
                    <div class="breadcrumb-item">Form Tambah Data</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Form Tambah Data API</h2>
                <p class="section-lead">Ini adalah halaman untuk menambahkan Data API kedalam sistem.</p>

                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Input Data API</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('opdbps.store') }}" runat="server" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <label>Kategori</label>
                                        <select name="kategori" id="kategori"
                                            class="form-control @error('kategori')is-invalid @enderror select2 ">
                                            <option selected disabled>=== Pilih Salah Satu ===</option>
                                            @php
                                                $jumlahkategori = count($kategori['data'][1]);
                                            @endphp
                                            @for ($i = 0; $i < $jumlahkategori; $i++)
                                                <option value="{{ $kategori['data'][1][$i]['title'] }}">
                                                    {{ $kategori['data'][1][$i]['title'] }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Sub Kategori</label>
                                        <select name="sub_kategori" id="sub-kategori"
                                            class="form-control @error('sub-kategori')is-invalid @enderror select2">
                                            <option selected disabled>=== Pilih Salah Satu ===</option>
                                            @foreach ($demografi as $item)
                                                <option value="{{ $item['title'] }}">{{ $item['title'] }}</option>
                                            @endforeach
                                            @foreach ($ekonomi as $item)
                                                <option value="{{ $item['title'] }}">{{ $item['title'] }}</option>
                                            @endforeach
                                            @foreach ($lhdanmultidomain as $item)
                                                <option value="{{ $item['title'] }}">{{ $item['title'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Judul</label>
                                        <input type="text" name="judul"
                                            class="form-control @error('judul')is-invalid @enderror"
                                            value="{{ old('judul') }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Link Api</label>
                                        <input type="text" name="link_api"
                                            class="form-control @error('link_api')is-invalid @enderror"
                                            value="{{ old('link_api') }}">
                                    </div>
                                    <button class="btn btn-primary mt-3" type="submit">Tambah Data</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
