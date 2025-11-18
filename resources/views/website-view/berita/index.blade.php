@extends('website-view.layout.layout')
@section('title', 'Berita Provinsi Jambi')
@section('main')
    <main id="main">
        <!-- ======= Breadcrumbs Section ======= -->
        <section class="breadcrumbs">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center">
                    <h2>Berita</h2>
                    <ol>
                        <li><a href="/">Home</a></li>
                        <li>Informasi</li>
                        <li>Berita</li>
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
                padding: 8px;

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
                border-radius: 6px;
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
                /* background: hsla(246, 40%, 30%, 0.5);
                                                        ; */
                padding: 10px;

                border-radius: 12px;
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

            /* Efek Hover pada Kartu */
            .featured-news-item {
                transition: transform 0.3s ease, box-shadow 0.3s ease;
            }

            .featured-news-item:hover {
                transform: translateY(-5px);
                box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.15);
            }

            /* Gambar Hover Efek */
            .featured-news-image img {
                transition: transform 0.3s ease;
            }

            .featured-news-image:hover img {
                transform: scale(1.05);
            }

            /* Efek pada Caption */
            .featured-news-image .caption {
                transition: background 0.3s ease;
            }

            .featured-news-image:hover .caption {
                background: rgba(39, 101, 186, 0.9);
            }
        </style>
        <section class="inner-page pt-3">
            <div class="container">
                <div class="section-title" data-aos="fade-up" style="padding-bottom: 0px">
                    <h2>Data Dasar</h2>
                    <p>{{ $berita->total() }} Berita Ditemukan </p>
                </div>
                <div class="row" data-aos="fade-up">
                    <div class="col-md-12">
                        <form method="get" action="{{ route('web-berita.index') }}" id="form" data-aos="fade-up">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1"><i class='bx bx-search'></i></span>
                                <input type="text" class="form-control" name="judul" value=""
                                    placeholder="Cari Berita..." aria-label="Cari Berita..."
                                    aria-describedby="basic-addon1">
                            </div>
                        </form>
                        <hr class="mb-2" style="border: 2px solid;">
                    </div>
                    <div class="col-md-12">
                        <div class="section-title mt-3 mb-3" data-aos="fade-up" style="padding-bottom: 0px">
                            <h2>Highlight Berita Terkini</h2>
                        </div>
                        <div class="content">
                            <section class="featured-news">
                                @foreach ($random_berita as $item)
                                    <div class="featured-news-item">
                                        <a
                                            href="{{ route('web-berita.show', ['id' => $item->id, 'slug' => $item->slug]) }}">
                                            <img class="featured-news-item-img"
                                                style="border: 1px rgba(0, 106, 255, 0.623) solid; padding:6px;"
                                                src="{{ asset('assets/berita-thumbnail/' . $item->gambar) }}">
                                            <div class="caption">
                                                <h2 class="text-white"
                                                    style="padding:10px; background-color:rgba(39, 101, 186, 0.568); font-size:14px; font-family:Cambria, Cochin, Georgia, Times, 'Times New Roman', serif">
                                                    {{ substr($item->judul, 0, 50) }}....</h2>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </section>
                        </div>
                        <div class="col-md-12 mt-5">
                            <div class="section-title mt-3 mb-3" data-aos="fade-up" style="padding-bottom: 0px">
                                <h2>Daftar Berita Provinsi Jambi</h2>
                            </div>
                            <div class="row">
                                @foreach ($berita as $item)
                                    <div class="col-md-3 gy-3">
                                        <div class="card" style="border-radius:6px;">
                                            <div class="snip1208">
                                                <img src="{{ asset('assets/berita-thumbnail/' . $item->gambar) }}" />
                                                <div class="date"><span class="day"
                                                        style="font-size: 15px;">{{ $item->created_at->format('d') }}</span><span
                                                        class="month"
                                                        style="font-size: 10px;">{{ $item->created_at->format('M') . ' ' . $item->created_at->format('Y') }}</span>
                                                </div>
                                                <i class="bi bi-newspaper"></i>
                                                <figcaption>
                                                    <span style="font-size: 11px;"
                                                        class="badge bg-danger mb-2">{{ $item->created_at->diffForHumans() }}</span>
                                                    <h4 style="font-size: 10px;">
                                                        {{ Str::words($item->judul, 6, ' ...') }}
                                                        <br>
                                                        <span class="text-primary">Baca Selengkapnya >>></span>
                                                    </h4>
                                                </figcaption>
                                                <a
                                                    href="{{ route('web-berita.show', ['id' => $item->id, 'slug' => $item->slug]) }}"></a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        {{ $berita->links('vendor.pagination.bootstrap-5') }}
                    </div>
                </div>
        </section>
    </main><!-- End #main -->
@endsection
