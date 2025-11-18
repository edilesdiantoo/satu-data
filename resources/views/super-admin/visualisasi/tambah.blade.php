@extends('super-admin/layout/layout')
@section('title', 'Form Tambah Visualisasi')
@section('main')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Tambah Visualisasi</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Visualisasi</a></div>
                    <div class="breadcrumb-item"><a href="#">Tambah Visualisasi</a></div>
                    <div class="breadcrumb-item">Form Tambah Visualisasi</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Form Tambah Visualisasi</h2>
                <p class="section-lead">Ini adalah halaman untuk menambahkan Visualisasi kedalam sistem.</p>

                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Input Data</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('visualisasi.store') }}" runat="server" enctype="multipart/form-data"
                                    method="post">
                                    @csrf
                                    <div class="text-center">
                                        <img id="blah" class="border" style="width:150px;height:auto;"
                                            src="{{ asset('assets/visualisasi-thumbnail/img01.jpg') }}" alt="your image" />
                                    </div>
                                    <div class="form-group">
                                        <label>Gambar</label>
                                        <input type="file" accept="image/*" id="imgInp" name="gambar"
                                            class="form-control @error('gambar')is-invalid @enderror">
                                    </div>
                                    <script>
                                        imgInp.onchange = evt => {
                                            const [file] = imgInp.files
                                            if (file) {
                                                blah.src = URL.createObjectURL(file)
                                            }
                                        }
                                    </script>
                                    <div class="form-group">
                                        <label>Judul</label>
                                        <input type="text" name="judul"
                                            class="form-control @error('judul')is-invalid @enderror"
                                            value="{{ old('judul') }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Sektor</label>
                                        <select name="sektor"
                                            class="form-control @error('sektor')is-invalid @enderror select2 ">
                                            <option selected disabled>=== Pilih Salah Satu ===</option>
                                            @foreach ($sektor as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ old('sektor') == $item->id ? 'selected' : '' }}>
                                                    {{ $item->nama_sektor }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Kategori</label>
                                        <select name="kategori"
                                            class="form-control @error('kategori')is-invalid @enderror select2 ">
                                            <option selected disabled>=== Pilih Salah Satu ===</option>
                                            <option value="dashboard"
                                                {{ old('kategori') == 'dashboard' ? 'selected' : '' }}>
                                                Dashboard</option>
                                            <option value="storyboard"
                                                {{ old('kategori') == 'storyboard' ? 'selected' : '' }}>
                                                Storyboard</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Deskripsi</label>
                                        <textarea class="form-control @error('deskripsi')is-invalid @enderror" name="deskripsi" style="height: 127px;">{{ old('deskripsi') }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Url (Embed Code)</label>
                                        <textarea name="url" class="codeeditor">{{ old('url') }}</textarea>
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
