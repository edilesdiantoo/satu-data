@extends('opd/layout/layout')
@section('title', 'Form Edit Produk Statistik')
@section('main')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit Produk Statistik</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Produk Statistik</a></div>
                    <div class="breadcrumb-item"><a href="#">Edit Produk Statistik</a></div>
                    <div class="breadcrumb-item">Form Edit Produk Statistik</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Form Edit Produk Statistik</h2>
                <p class="section-lead">Ini adalah halaman untuk menambahkan Produk Statistik kedalam sistem.</p>

                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Input Data</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('opd-publikasi.update', $publikasi->id) }}" runat="server"
                                    enctype="multipart/form-data" method="post">
                                    @csrf
                                    @method('patch')
                                    <div class="text-center">
                                        <img id="blah" class="border" style="width:150px;height:auto;"
                                            src="{{ asset('assets/cover-publikasi/' . $publikasi->cover) }}"
                                            alt="" />
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
                                            value="{{ old('judul', $publikasi->judul) }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="file" class="form-label">File</label>
                                        <input type="file" name="file" class="form-control" id="file"
                                            aria-describedby="filehelp" accept="application/pdf">
                                        <div id="filehelp" class="form-text"><a
                                                href="{{ asset('assets/publikasi/' . $publikasi->file) }}">Lihat file</a>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Sektor</label>
                                        <select class="form-control select2" name="id_sektor"
                                            aria-label="Default select example">
                                            <option selected>=== Pilih Salah Satu ===</option>
                                            @foreach ($sektor as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ $publikasi->id_sektor == old('id_sektor', $item->id) ? 'selected' : '' }}>
                                                    {{ $item->nama_sektor }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Deskripsi</label>
                                        <textarea class="form-control @error('deskripsi')is-invalid @enderror" name="deskripsi" style="height: 127px;">{{ old('deskripsi', $publikasi->deskripsi) }}</textarea>
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
