@extends('super-admin/layout/layout')
@section('title', 'Form Edit Artikel')
@section('main')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit Artikel</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Artikel</a></div>
                    <div class="breadcrumb-item"><a href="#">Edit Data</a></div>
                    <div class="breadcrumb-item">Form Edit Data</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Form Edit Artikel</h2>
                <p class="section-lead">Ini adalah halaman untuk Mengubah Artikel kedalam sistem.</p>

                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Input Artikel</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('artikel.update', $artikel->id) }}" runat="server"
                                    enctype="multipart/form-data" method="post">
                                    @csrf
                                    @method('patch')
                                    <div class="text-center">
                                        <img id="blah" class="border" style="width:150px;height:auto;"
                                            src="{{ asset('assets/artikel-thumbnail/' . $artikel->gambar) }}"
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
                                            value="{{ old('judul', $artikel->judul) }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Sektor</label>
                                        <select class="form-control select2" name="id_sektor"
                                            aria-label="Default select example">
                                            <option selected>=== Pilih Salah Satu ===</option>
                                            @foreach ($sektor as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ $artikel->id_sektor == old('id_sektor', $item->id) ? 'selected' : '' }}>
                                                    {{ $item->nama_sektor }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Isi artikel</label>
                                        <textarea class="summernote form-control @error('isi')is-invalid @enderror" name="isi">{{ old('isi', $artikel->isi) }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select class="form-control select2" name="status"
                                            aria-label="Default select example">
                                            <option selected>=== Pilih Salah Satu ===</option>
                                            <option value="publish"
                                                {{ 'publish' == old('status', $artikel->status) ? 'selected' : '' }}>
                                                Publish
                                            </option>
                                            <option value="draft"
                                                {{ 'draft' == old('status', $artikel->status) ? 'selected' : '' }}>
                                                Draft
                                            </option>
                                        </select>
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
