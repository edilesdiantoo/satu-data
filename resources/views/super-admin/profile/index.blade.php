@extends('super-admin/layout/layout')
@section('title', Auth::user()->name)
@section('main')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>My Profile</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">{{ Auth::user()->name }}</a></div>
                    <div class="breadcrumb-item">Profile {{ Auth::user()->name }}</div>
                </div>
            </div>

            <div class="section-body">
                <div class="col-12 mb-4">
                    <div class="hero text-white hero-bg-image"
                        style="background-image: url('assets/img/unsplash/eberhard-grossgasteiger-1207565-unsplash.jpg');">
                        <div class="hero-inner">
                            <h2>Welcome, {{ Auth::user()->name }} !</h2>
                            <p class="lead">Selamat Bergabung dari bagian Jambi Data Analitik Center (JDAC) Provinsi
                                Jambi.</p>
                            <div class="mt-4">
                                <a href="#profile" class="btn btn-outline-white btn-lg btn-icon icon-left"><i
                                        class="far fa-user"></i> Setup Account</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-sm-4">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card profile-widget">
                            <div class="profile-widget-header">
                                <img alt="image" src="{{ asset('assets/photo-profile/' . $users->photo) }}"
                                    class="rounded-circle profile-widget-picture">
                                <div class="profile-widget-items">
                                    <div class="profile-widget-item">
                                        <div class="profile-widget-item-label">Datasets</div>
                                        <div class="profile-widget-item-value">{{ $datasets }}</div>
                                    </div>
                                    <div class="profile-widget-item">
                                        <div class="profile-widget-item-label">OPD</div>
                                        @foreach ($opd as $item)
                                            @if ($item->id == Auth::user()->id_opd)
                                                <div class="profile-widget-item-value">{{ $item->nama_opd }}</div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="profile-widget-description">
                                <div class="profile-widget-name">{{ Auth::user()->name }} <div
                                        class="text-muted d-inline font-weight-normal">
                                        <div class="slash"></div> {{ Auth::user()->role }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>My Profile</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('profile.update', Auth::user()->id) }}" runat="server"
                                    enctype="multipart/form-data" method="post" id="profile">
                                    @csrf
                                    @method('patch')
                                    <div class="text-center">
                                        <img id="blah" class="border" style="width:150px;height:auto;"
                                            src="{{ asset('assets/photo-profile/' . $users->photo) }}" alt="your image" />
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
                                            value="{{ $users->name }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" name="email"
                                            class="form-control @error('email')is-invalid @enderror"
                                            value="{{ $users->email }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Organisasi Pemerintah Daerah</label>
                                        <select name="id_opd"
                                            class="form-control @error('id_opd')is-invalid @enderror select2 ">
                                            <option disabled>=== Pilih Salah Satu ===</option>
                                            @foreach ($opd as $item_opd)
                                                <option value="{{ $item_opd->id }}"
                                                    {{ $users->id_opd == $item_opd->id ? 'selected' : '' }}>
                                                    {{ $item_opd->nama_opd }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Roles</label>
                                        <input type="text" class="form-control" value="{{ Auth::user()->role }}"
                                            readonly>
                                    </div>
                                    <button class="btn btn-primary mt-3" type="submit">Simpan Perubahan</button>
                                </form>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('change_password') }}" method="post">
                                    @csrf
                                    @method('patch')
                                    <div class="form-group">
                                        <label>Old Password</label>
                                        <input type="password" name="old_password"
                                            class="form-control @error('old_password')is-invalid @enderror">
                                    </div>
                                    <div class="form-group">
                                        <label>New Password</label>
                                        <input type="password" name="password"
                                            class="form-control @error('password')is-invalid @enderror">
                                    </div>
                                    <div class="form-group">
                                        <label>Confirm Password</label>
                                        <input type="password" name="password_confirmation"
                                            class="form-control @error('password')is-invalid @enderror">
                                    </div>
                                    <button class="btn btn-primary mt-3" type="submit">Ganti Password</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
