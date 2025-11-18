@extends('super-admin/layout/layout')
@section('title', 'Form Edit Infografis')
@section('main')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit Infografis</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Infografis</a></div>
                    <div class="breadcrumb-item"><a href="#">Edit Data</a></div>
                    <div class="breadcrumb-item">Form Edit Data</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Form Edit Infografis</h2>
                <p class="section-lead">Ini adalah halaman untuk Mengubah Infografis kedalam sistem.</p>

                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Input Infografis</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('infografis.update', $infografis->id) }}" runat="server"
                                    enctype="multipart/form-data" method="post">
                                    @csrf
                                    @method('patch')
                                    <div class="text-center">
                                        <img id="blah" class="border" style="width:150px;height:auto;"
                                            src="{{ asset('assets/infografis/' . $infografis->gambar) }}"
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
                                            value="{{ old('judul', $infografis->judul) }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Sektor</label>
                                        <select name="id_sektor"
                                            class="form-control @error('sektor')is-invalid @enderror select2 ">
                                            <option selected disabled>=== Pilih Salah Satu ===</option>
                                            @foreach ($sektor as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ old('id_sektor',$infografis->id_sektor) == $item->id ? 'selected' : '' }}>
                                                    {{ $item->nama_sektor }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Status Infografis</label>
                                        <select class="form-control select2" aria-label="Default select example"
                                            name="status">
                                            <option selected disabled>=== Pilih Salah Satu ===</option>
                                            <option value="proses" @if (old('status', $infografis->status) == 'proses') selected @endif>
                                                Diproses
                                            </option>
                                            <option value="terverifikasi" @if (old('status', $infografis->status) == 'terverifikasi') selected @endif>
                                                Terverifikasi</option>
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
