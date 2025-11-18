@extends('website-view.layout.layout')
@section('title', 'Organisasi')
@section('main')
    <main id="main">
        <!-- ======= Breadcrumbs Section ======= -->
        <section class="breadcrumbs">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center">
                    <h2>Organisasi</h2>
                    <ol>
                        <li><a href="/">Home</a></li>
                        <li>Informasi</li>
                        <li>Organisasi</li>
                    </ol>
                </div>

            </div>
        </section><!-- End Breadcrumbs Section -->
        <section class="inner-page">
            <div class="container">
                <div class="section-title" data-aos="fade-up">
                    <h2>Organisasi</h2>
                    <p>Data Organisasi Pemerintahan Provinsi Jambi</p>
                </div>
                <form action="{{ route('organisasi.informasi') }}" method="GET">
                    <div class="row gy-2" data-aos="fade-up">
                        <div class="col-md-12">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1"><i class='bx bx-search'></i></span>
                                <input type="text" class="form-control" name="judul" value=""
                                    placeholder="Cari Data..." aria-label="Username" aria-describedby="basic-addon1">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h5><b>{{ count($opd) }}</b> Organisasi Ditemukan</h5>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <span class="input-group-text">Urutkan Berdasarkan</span>
                                <select name="urut" id="urut" class="form-select" onchange="this.form.submit()">
                                    <option value="abjad" {{ app('request')->input('urut') == 'abjad' ? 'selected' : '' }}>
                                        Abjad
                                    </option>
                                    <option value="Terbanyak"
                                        {{ app('request')->input('urut') == 'Terbanyak' ? 'selected' : '' }}>
                                        Terbanyak</option>
                                </select>
                            </div>
                        </div>
                        <hr>
                    </div>
                </form>
                <div class="row gy-3">
                    <div class="col-md-3">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header header-sosialdankependudukan text-white fw-bold">
                                        Filter Organisasi
                                        <i class="bi bi-funnel-fill float-end"></i>
                                    </div>
                                    <div class="card-body">
                                        <form role="form" id="form_tambah_kriteria"
                                            action="{{ route('organisasi.informasi') }}" class="margin-bottom-0">
                                            <div class="form-check">
                                                <input class="form-check-input" style="border-radius: 10%;" name="opd"
                                                    value="" onChange="this.form.submit()" type="radio"
                                                    {{ app('request')->input('opd') == null ? 'checked' : '' }}>
                                                <label class="form-check-label" style="font-size: 13px;"
                                                    for="flexCheckDefault">Tampilkan
                                                    Semua</label>
                                            </div>
                                            @foreach ($s_opd as $item)
                                                <div class="form-check">
                                                    <input class="form-check-input" style="border-radius: 10%;"
                                                        id="flexCheckDefault-{{ $item->nama_opd }}" name="opd"
                                                        value="{{ $item->id }}" onChange="this.form.submit()"
                                                        type="radio"
                                                        {{ app('request')->input('opd') == $item->id ? 'checked' : '' }}>
                                                    <label class="form-check-label" style="font-size: 13px;"
                                                        for="flexCheckDefault-{{ $item->nama_opd }}">{{ $item->nama_opd }}</label>
                                                </div>
                                            @endforeach
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="row g-3">
                            @foreach ($opd as $item)
                                <div class="col-md-3">
                                    <a href="{{ route('web-datasets.index') }}?opd={{ $item->nama_opd }}">
                                        <div class="d-flex align-items-stretch" data-aos="fade-down">
                                            <div class="card-body text-center">
                                                <img src="{{ asset('assets/opd/' . $item->gambar) }}"
                                                    style="width: 175px; height:160px;" alt="Logo Jambi">
                                                <h6 class="card-title text-black mt-3"
                                                    style="font-family: Cambria; height: 50px;font-size:13px">
                                                    {{ $item->nama_opd }}
                                                </h6>
                                                {{-- <p class="card-text text-black" style="font-size:10px;"><i
                                                        class="bx bx-file"></i> @php
                                                            $count = App\Http\Controllers\WebController\HomeController::count_organisasi(
                                                                $item->nama_opd,
                                                            );
                                                            echo $count;
                                                        @endphp
                                                </p> --}}
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main><!-- End #main -->
@endsection
