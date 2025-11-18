@extends('website-view.layout.layout')
@section('title', 'Artikel Provinsi Jambi')
@section('main')
    <main id="main">
        <!-- ======= Breadcrumbs Section ======= -->
        <section class="breadcrumbs">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center">
                    <h2>Artikel</h2>
                    <ol>
                        <li><a href="/">Home</a></li>
                        <li>Informasi</li>
                        <li>Artikel</li>
                    </ol>
                </div>
            </div>
        </section><!-- End Breadcrumbs Section -->
        <style>
            .featured-news {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
            }

            .featured-news-item {
                font-size: 8px;
                color: var(--text-color-lighter);
                display: flex;
            }

            .featured-news-item:before {
                content: "";
                display: block;
                height: 0;
                width: 0;
                padding-bottom: calc(9 / 16 * 100%);
            }

            .featured-news-item:first-child {
                grid-column: span 2;
                font-size: 12px;
            }

            .featured-news-item:first-child:before {
                padding-bottom: calc(8 / 16 * 100%);
            }

            .featured-news-item a {
                display: grid;
                overflow: hidden;
                width: 100%;
            }

            .featured-news-item-img {
                object-fit: cover;
                height: 100%;
                width: 100%;
            }

            .caption,
            .featured-news-item-img {
                grid-column: 1;
                grid-row: 1;
            }

            .caption {
                display: flex;
                height: 100%;
                align-items: flex-end;
                background: hsla(246, 40%, 30%, 0.5);
                ;
                padding: 10px;
            }

            .caption h2 {
                font-weight: normal;
                margin: 0;
                display: -webkit-box;
                -webkit-line-clamp: 3;
                -webkit-box-orient: vertical;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            section {
                padding: 0 15px;
            }

            section.featured-news {
                padding: 0;
            }

            @media only screen and (min-width: 640px) {
                .featured-news {
                    grid-template-columns: repeat(9, 1fr);
                }

                .featured-news-item {
                    grid-column: span 3;
                    font-size: 10px;
                }

                .featured-news-item:first-child {
                    grid-column: span 6;
                    grid-row: span 2;
                }

                .featured-news-item:nth-child(4) {
                    grid-column: span 4;
                }

                .featured-news-item:last-child {
                    grid-column: span 5;
                    font-size: 12px;
                }
            }

            @media only screen and (min-width: 768px) {
                .content {
                    display: grid;
                    grid-gap: 2em;
                    grid-template-columns: repeat(3, 1fr);
                }

                .featured-news {
                    grid-column: span 3;
                }

                .featured-news {
                    grid-template-columns: repeat(4, 1fr);
                }

                .featured-news-item:first-child:before {
                    padding-bottom: calc(8 / 12 * 100%);
                }

                .featured-news-item {
                    grid-column: span 1;
                    font-size: 10px;
                }

                .featured-news-item:first-child {
                    grid-column: span 2;
                    grid-row: span 2;
                }

                .featured-news-item:nth-child(4) {
                    grid-column: span 1;
                }

                .featured-news-item:last-child {
                    grid-column: span 1;
                    font-size: 12px;
                }

                .caption {
                    padding: 15px;
                }
            }

            @media screen and (min-width: 1280px) {
                section {
                    padding: 0;
                }

                section:first-child {
                    padding-top: 15px;
                }

                .caption h2 {
                    font-size: 15px;
                }

                .content {
                    grid-column: 2;
                    display: grid;
                }
            }
        </style>
        <section class="inner-page pt-3">
            <div class="container">
                <div class="section-title" data-aos="fade-up" style="padding-bottom: 0px">
                    <h2>Data Dasar</h2>
                    <p>{{ $artikel->total() }} artikel Ditemukan </p>
                </div>
                <div class="row" data-aos="fade-up">
                    <div class="col-md-3" data-aos="fade-right">
                        <form role="form" id="form_tambah_kriteria" action="{{ route('web-artikel.index') }}"
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
                                            Filter Artikel
                                            <i class="bi bi-funnel-fill float-end"></i>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-check">
                                                <input class="form-check-input" style="border-radius: 10%" name="sektor"
                                                    value="" onChange="this.form.submit()" type="radio"
                                                    {{ app('request')->input('sektor') == null ? 'checked' : '' }}>
                                                <label class="form-check-label" style="font-size: 13px;"
                                                    for="flexCheckDefault">All</label>
                                            </div>
                                            @foreach ($sektor as $item)
                                                <div class="form-check">
                                                    <input class="form-check-input" style="border-radius: 10%"
                                                        name="sektor" value="{{ $item->id }}"
                                                        onChange="this.form.submit()" type="radio"
                                                        {{ app('request')->input('sektor') == $item->id ? 'checked' : '' }}>
                                                    <label class="form-check-label" style="font-size: 13px;"
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
                            @foreach ($artikel as $item)
                                <div class="col-md-4 d-flex align-items-stretch gy-3">
                                    <div class="card" style="width: 100%;">
                                        <div class="snip1208">
                                            <img src="{{ asset('assets/artikel-thumbnail/' . $item->gambar) }}"
                                                style="height: 320px;" />
                                            <div class="date"><span
                                                    class="day">{{ $item->created_at->format('d') }}</span><span
                                                    class="month"
                                                    style="font-size: 10px;">{{ $item->created_at->format('M') . ' ' . $item->created_at->format('Y') }}</span>
                                            </div>
                                            <i class="bi bi-newspaper"></i>
                                            <figcaption>
                                                <span class="badge bg-danger mb-2"
                                                    style="font-size: 10px;">{{ $item->created_at->diffForHumans() }}</span>
                                                <span class="badge bg-warning" style="font-size: 10px;">
                                                    {{ App\Http\Controllers\WebController\HomeController::getSektor($item->id_sektor) }}
                                                </span>
                                                <h4 style="font-size: 13px;">
                                                    {{ Str::words($item->judul, 6, ' ...') }}
                                                </h4>
                                                <div class="d-grid gap-2">
                                                    <button style="font-size: 10px">Baca Selengkapnya</button>
                                                </div>
                                            </figcaption><a
                                                href="{{ route('web-artikel.show', ['id' => $item->id, 'slug' => $item->slug]) }}"></a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="mt-3">
                        {{ $artikel->links('vendor.pagination.bootstrap-5') }}
                    </div>
                </div>
        </section>
    </main><!-- End #main -->
@endsection
