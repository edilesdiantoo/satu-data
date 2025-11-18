@extends('website-view.layout.layout')
@section('title', 'Buku Digital')
@section('main')
    <main id="main">
        <!-- ======= Breadcrumbs Section ======= -->
        <section class="breadcrumbs">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center">
                    <h2>Buku Digital</h2>
                    <ol>
                        <li><a href="/">Home</a></li>
                        <li>Informasi</li>
                        <li>Buku Digital</li>
                    </ol>
                </div>
            </div>
        </section><!-- End Breadcrumbs Section -->
        <section class="inner-page pt-3">
            <div class="container">
                <div class="section-title" data-aos="fade-up">
                    <h2>Buku Digital</h2>
                    <p>{{ $buku->count() }} Buku Digital Ditemukan </p>
                </div>
                <div class="row gy-3">
                    <div class="col-md-3" data-aos="fade-right">
                        <form role="form" id="form_tambah_kriteria" action="{{ route('web-buku-digital.index') }}"
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
                                            Filter Buku
                                            <i class="bi bi-funnel-fill float-end"></i>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-check">
                                                <input class="form-check-input" name="sektor" value=""
                                                    onChange="this.form.submit()" type="radio"
                                                    {{ app('request')->input('sektor') == null ? 'checked' : '' }}>
                                                <label class="form-check-label" for="flexCheckDefault">All</label>
                                            </div>
                                            @foreach ($sektor as $item)
                                                <div class="form-check">
                                                    <input class="form-check-input" name="sektor"
                                                        value="{{ $item->id }}" onChange="this.form.submit()"
                                                        type="radio"
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
                            @foreach ($buku as $item)
                                <div class="col-md-4 align-items-center">
                                    <div class="book-card mx-auto">
                                        <div class="book-card__cover">
                                            <div class="book-card__book">
                                                <div class="book-card__book-front">
                                                    <a href="{{ $item->url }}" target="_blank">
                                                        <img class="book-card__img"
                                                            src="{{ asset('assets/buku/' . $item->cover) }}" />
                                                    </a>
                                                </div>
                                                <div class="book-card__book-back"></div>
                                                <div class="book-card__book-side"></div>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="book-card__title">
                                                <h6 class="fw-bold">
                                                    {{ $item->judul }}
                                                </h6>
                                            </div>
                                            <div class="book-card__author">
                                                <span class="badge bg-info">
                                                    {{ App\Http\Controllers\WebController\HomeController::getSektor($item->id_sektor) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="mt-3">
                        {{ $buku->links('vendor.pagination.bootstrap-5') }}
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
