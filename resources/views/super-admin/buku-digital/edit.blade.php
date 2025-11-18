@extends('super-admin/layout/layout')
@section('title', 'Form Edit Buku Digital')
@section('main')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit Buku Digital</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Buku Digital</a></div>
                    <div class="breadcrumb-item"><a href="#">Edit Data</a></div>
                    <div class="breadcrumb-item">Form Edit Data</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Form Edit Buku Digital</h2>
                <p class="section-lead">Ini adalah halaman untuk Mengubah Buku Digital kedalam sistem.</p>

                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Input Buku Digital</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('buku-digital.update', $buku->id) }}" runat="server"
                                    enctype="multipart/form-data" method="post">
                                    @csrf
                                    @method('patch')
                                    <div class="text-center">
                                        <img id="blah" class="border" style="width:150px;height:auto;"
                                            src="{{ asset('assets/buku/' . $buku->cover) }}"
                                            alt="your image" />
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
                                            value="{{ old('judul', $buku->judul) }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Sektor</label>
                                        <select name="id_sektor"
                                            class="form-control @error('sektor')is-invalid @enderror select2 ">
                                            <option selected disabled>=== Pilih Salah Satu ===</option>
                                            @foreach ($sektor as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ old('id_sektor',$buku->id_sektor) == $item->id ? 'selected' : '' }}>
                                                    {{ $item->nama_sektor }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Url</label>
                                        <input type="text" name="url"
                                            class="form-control @error('url')is-invalid @enderror"
                                            value="{{ old('url', $buku->url) }}">
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
