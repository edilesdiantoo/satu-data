@extends('super-admin/layout/layout')
@section('title', 'Form Tambah Publikasi')
@section('main')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Tambah Publikasi</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Publikasi</a></div>
                    <div class="breadcrumb-item"><a href="#">Tambah Publikasi</a></div>
                    <div class="breadcrumb-item">Form Tambah Publikasi</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Form Tambah Publikasi</h2>
                <p class="section-lead">Ini adalah halaman untuk menambahkan Publikasi kedalam sistem.</p>

                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Input Data</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('publikasi.store') }}" runat="server" enctype="multipart/form-data"
                                    method="post">
                                    @csrf
                                    <div class="text-center">
                                        <img id="blah" class="border" style="width:150px;height:auto;"
                                            src="{{ asset('assets/visualisasi-thumbnail/img01.jpg') }}" alt="your image" />
                                    </div>
                                    <div class="form-group">
                                        <label>Cover</label>
                                        <input type="file" accept="image/*" id="imgInp" name="cover"
                                            class="form-control @error('cover')is-invalid @enderror">
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
                                        <select name="id_sektor"
                                            class="form-control @error('sektor')is-invalid @enderror select2 ">
                                            <option selected disabled>=== Pilih Salah Satu ===</option>
                                            @foreach ($sektor as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ old('id_sektor') == $item->id ? 'selected' : '' }}>
                                                    {{ $item->nama_sektor }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="file" class="form-label">File</label>
                                        <input type="file" name="file" class="form-control" id="file"
                                            aria-describedby="filehelp" accept="application/pdf">
                                        <div id="filehelp" class="form-text">Upload Pdf.</div>
                                    </div>
                                    <div class="form-group">
                                        <label>Deskripsi</label>
                                        <textarea class="summernote form-control @error('deskripsi')is-invalid @enderror" name="deskripsi" style="height: 127px;">{{ old('deskripsi') }}</textarea>
                                    </div>
                                    <button class="btn btn-primary mt-3" type="submit">Tambah Publikasi</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
