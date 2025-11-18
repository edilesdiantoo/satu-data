@extends('website-view.layout.layout')
@section('title', 'Publikasi')
@section('main')
    <main id="main">
        <!-- ======= Breadcrumbs Section ======= -->
        <section class="breadcrumbs">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center">
                    <h2>Produk Statistik</h2>
                    <ol>
                        <li><a href="/">Home</a></li>
                        <li>Informasi</li>
                        <li>Produk Statistik</li>
                    </ol>
                </div>
            </div>
        </section><!-- End Breadcrumbs Section -->
        <section class="inner-page pt-3">
            <div class="container">
                <div class="section-title" data-aos="fade-up">
                    <h2>Produk Statistik</h2>
                    <p>{{ $publikasi->count() }} Produk Ditemukan </p>
                </div>
                <div class="row gy-3">
                    <div class="col-md-3" data-aos="fade-right">
                        <form role="form" id="form_tambah_kriteria" action="{{ route('publikasi-informasi.index') }}"
                            class="margin-bottom-0">
                            <div class="row d-flex align-items-end">
                                <div class="form-group col-md-12">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1"><i class='bx bx-search'></i></span>
                                        <input type="text" class="form-control" name="judul" value=""
                                            placeholder="Cari Buku Digital..." aria-label="Username"
                                            aria-describedby="basic-addon1">
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">Urutkan</span>
                                        <select name="urut" id="urut" class="form-select"
                                            onchange="this.form.submit()">
                                            <option {{ app('request')->input('urut') == 'Terbaru' ? 'selected' : '' }}
                                                value="Terbaru">--Terbaru--</option>
                                            <option {{ app('request')->input('urut') == 'Abjad' ? 'selected' : '' }}
                                                value="Abjad">--Abjad--</option>
                                        </select>

                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">Tampilkan</span>
                                        <select name="record" id="record" class="form-select"
                                            onchange="this.form.submit()">
                                            <option
                                                value="20"{{ app('request')->input('record') == 20 ? 'selected' : '' }}>
                                                20</option>
                                            <option
                                                value="30"{{ app('request')->input('record') == 30 ? 'selected' : '' }}>
                                                30</option>
                                            <option
                                                value="40"{{ app('request')->input('record') == 40 ? 'selected' : '' }}>
                                                40</option>
                                            <option
                                                value="50"{{ app('request')->input('record') == 50 ? 'selected' : '' }}>
                                                50</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header header-sosialdankependudukan text-white fw-bold">
                                            Filter Produk Statistik
                                            <i class="bi bi-funnel-fill float-end"></i>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-check">
                                                <input class="form-check-input" style="border-radius: 10%;" name="sektor"
                                                    value="" onChange="this.form.submit()" type="radio"
                                                    {{ app('request')->input('sektor') == null ? 'checked' : '' }}>
                                                <label class="form-check-label" for="flexCheckDefault">All</label>
                                            </div>
                                            @foreach ($sektor as $item)
                                                <div class="form-check">
                                                    <input class="form-check-input" style="border-radius: 10%;"
                                                        name="sektor" value="{{ $item->id }}"
                                                        onChange="this.form.submit()" type="radio"
                                                        {{ app('request')->input('sektor') == $item->id ? 'checked' : '' }}>
                                                    <label class="form-check-label"
                                                        for="flexCheckDefault">{{ $item->nama_sektor }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-9">
                        <div class="row">
                            @foreach ($publikasi as $item)
                                <div class="col-lg-3 col-md-6 d-flex align-items-stretch">
                                    <div class="member aos-init aos-animate" data-aos="fade-up" data-aos-delay="200">
                                        <div class="member-img" style="height: 200px;">
                                            <div class="cropper">
                                                <a target="_blank"
                                                    href="{{ route('publikasi-informasi.show', $item->id) }}"
                                                    data-gall="portfolioGallery" class="venobox vbox-item">
                                                    <img src="{{ asset('assets/cover-publikasi/' . $item->cover) }}"
                                                        class="img-fluid" alt="" width="320px;">
                                                </a>
                                            </div>
                                        </div>

                                        <span class="badge bg-info mt-2" style="font-size: 10px;">
                                            {{ App\Http\Controllers\WebController\HomeController::getSektor($item->id_sektor) }}
                                        </span>
                                        <div class="member-info pt-1">
                                            <h6 style="font-size:13px;">
                                                <a class="text-dark"
                                                    href="{{ route('publikasi-informasi.show', $item->id) }}">
                                                    {{ $item->judul }}
                                                </a>
                                            </h6>
                                            <p class="card-text"><small class="text-muted">Di publish
                                                    {{ $item->created_at->format('d F Y') }}</small>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-3">
                            {{ $publikasi->links('vendor.pagination.bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
