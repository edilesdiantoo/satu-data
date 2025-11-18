@extends('super-admin/layout/layout')
@section('title', 'Form Edit Berita')
@section('main')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit Berita</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Berita</a></div>
                    <div class="breadcrumb-item"><a href="#">Edit Data</a></div>
                    <div class="breadcrumb-item">Form Edit Data</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Form Edit Berita</h2>
                <p class="section-lead">Ini adalah halaman untuk Mengubah Berita kedalam sistem.</p>

                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Input Berita</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('berita.update', $berita->id) }}" runat="server"
                                    enctype="multipart/form-data" method="post">
                                    @csrf
                                    @method('patch')
                                    <div class="text-center">
                                        <img id="blah" class="border" style="width:150px;height:auto;"
                                            src="{{ asset('assets/berita-thumbnail/' . $berita->gambar) }}"
                                            alt="your image" />
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
                                            value="{{ old('judul', $berita->judul) }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Isi Berita</label>
                                        <textarea class="summernote form-control @error('isi')is-invalid @enderror" name="isi">{{ old('isi', $berita->isi) }}</textarea>
                                    </div>
                                    <button class="btn btn-primary mt-3" type="submit">Simpan Perubahan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
