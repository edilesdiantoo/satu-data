@extends('super-admin/layout/layout')
@section('title', 'Form Tambah Operator')
@section('main')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Tambah Operator</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Operator</a></div>
                    <div class="breadcrumb-item"><a href="#">Tambah Operator</a></div>
                    <div class="breadcrumb-item">Form Tambah Operator</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Form Tambah Operator</h2>
                <p class="section-lead">Ini adalah halaman untuk menambahkan akun operator kedalam sistem.</p>

                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Input Data</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('operator.store') }}" runat="server" enctype="multipart/form-data"
                                    method="post">
                                    @csrf
                                    <div class="text-center">
                                        <img id="blah" class="border" style="width:150px;height:auto;"
                                            src="{{ asset('assets/photo-profile/avatar-1.png') }}" alt="your image" />
                                    </div>
                                    <div class="form-group">
                                        <label>Photo</label>
                                        <input type="file" accept="image/*" id="imgInp" name="photo"
                                            class="form-control @error('photo')is-invalid @enderror">
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
                                        <label>Nama</label>
                                        <input type="text" name="name"
                                            class="form-control @error('name')is-invalid @enderror"
                                            value="{{ old('name') }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" name="email"
                                            class="form-control @error('email')is-invalid @enderror"
                                            value="{{ old('email') }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Organisasi Pemerintah Daerah</label>
                                        <select name="id_opd"
                                            class="form-control @error('id_opd')is-invalid @enderror select2 ">
                                            <option selected disabled>=== Pilih Salah Satu ===</option>
                                            @foreach ($opd as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ old('id_opd') == $item->id ? 'selected' : '' }}>
                                                    {{ $item->nama_opd }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" name="password"
                                            class="form-control @error('password')is-invalid @enderror">
                                    </div>
                                    <div class="form-group">
                                        <label>Confirm Password</label>
                                        <input type="password" name="password_confirmation"
                                            class="form-control @error('password')is-invalid @enderror">
                                    </div>
                                    <div class="form-group">
                                        <label>Roles</label>
                                        <input type="text" class="form-control" value="Operator" readonly>
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
