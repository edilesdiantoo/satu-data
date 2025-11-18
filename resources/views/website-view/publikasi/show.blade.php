@extends('website-view.layout.layout')
@section('title', $publikasi->judul)
@section('main')
    <main id="main">
        <!-- ======= Breadcrumbs Section ======= -->
        <section class="breadcrumbs">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center">
                    <h2>Produk Statistik</h2>
                    <ol>
                        <li><a href="/">Beranda</a></li>
                        <li>Informasi</li>
                        <li>Produk Statistik</li>
                    </ol>
                </div>
            </div>
        </section><!-- End Breadcrumbs Section -->
        <section class="inner-page">
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <div class="section-title" data-aos="fade-up" style="padding-bottom: 5px">
                            <h2>Produk Statistik</h2>
                            <p>{{ $publikasi->judul }}</p>
                        </div>
                        <span class="badge bg-info" data-aos="fade-right">
                            Dipublish : {{ $publikasi->created_at->format('d M Y H:i') }}
                        </span>
                        <div class="mt-2" data-aos="fade-right">
                            @php
                                // Get the current URL
                                $url_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                            @endphp
                            <a class="btn btn-sm btn-primary"
                                href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($url_link) }}"
                                target="_blank" title="Share this post on Facebook">
                                <i class="bi bi-facebook"></i> Share
                            </a>
                            <a class="btn btn-sm btn-info text-white"
                                href="https://twitter.com/intent/tweet?text=&amp;url={{ urlencode($url_link) }}"
                                target="_blank" title="Share this post on Twitter">
                                <i class="bi bi-twitter"></i> Twitter
                            </a>
                            <a class="btn btn-sm btn-success"
                                href="https://api.whatsapp.com/send?text={{ urlencode($url_link) }}" target="_blank"
                                title="Share this post on WhatsApp">
                                <i class="bi bi-whatsapp"></i> Whatsapp
                            </a>

                            <a class="btn btn-sm btn-success float-end"
                                href="{{ asset('assets/publikasi/' . $publikasi->file) }}" target="_blank" title="Download">
                                <i class="bi bi-download" data-fa-transform="grow-2"></i>
                                Download
                            </a>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-4">
                                <img class="img-fluid mt-2 mb-2" data-aos="zoom-in-up"
                                    src="{{ asset('assets/cover-publikasi/' . $publikasi->cover) }}">
                            </div>
                            <div class="col-md-8">
                                @php
                                    echo $publikasi->deskripsi;
                                @endphp
                            </div>
                        </div>
                        <style>
                            blockquote {
                                background: #f2f9ff;
                                color: #617a91;
                                font-size: 17px;
                                font-style: italic;
                                border: 1px solid #2e87e7;
                                border-radius: 4px;
                                padding: 20px;
                                clear: both;
                            }

                            blockquote:before {
                                color: #2e87e7;
                                content: open-quote;
                                font-size: 4em;
                                line-height: 0.1em;
                                margin-right: 0.25em;
                                vertical-align: -0.4em;
                            }

                            blockquote,
                            q {
                                quotes: "\201C" "\201D" "\2018" "\2019";
                            }
                        </style>
                    </div>
                    <div class="col-md-4 gy-3">
                        <div class="section-title" data-aos="fade-left" style="padding-bottom: 5px">
                            <h2>Pencarian</h2>
                        </div>
                        <form method="get" action="{{ route('publikasi-informasi.index') }}" id="form"
                            data-aos="fade-left">
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class='bx bx-search'></i></span>
                                <div class="form-floating">
                                    <input type="text" name="judul" value="" class="form-control"
                                        id="floatingInputGroup1" placeholder="Username">
                                    <label for="floatingInputGroup1">Pencarian</label>
                                </div>
                            </div>
                        </form>
                        <hr class="mb-2" style="border: 2px solid;">
                        <div class="section-title mt-4" data-aos="fade-left" style="padding-bottom: 5px">
                            <h2>Produk Statistik Lainnya</h2>
                        </div>
                        @foreach ($list as $item)
                            <div class="card" data-aos="fade-left">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4 d-flex justify-content-center align-items-center">
                                            <div class="bg-image hover-overlay ripple shadow-2-strong rounded my-auto"
                                                data-mdb-ripple-color="light">
                                                <a href="{{ route('publikasi-informasi.show', ['id' => $item->id]) }}">
                                                    <img src="{{ asset('assets/cover-publikasi/' . $item->cover) }}"
                                                        class="img-fluid" style="height: 90px; width: 80px" />
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <a href="{{ route('publikasi-informasi.show', ['id' => $item->id]) }}"
                                                class="text-black">
                                                <span style="font-size: 13px;"><strong>
                                                        {{ \Illuminate\Support\Str::limit($item->judul, 60, $end = '...') }}
                                                    </strong></span></a><br>
                                            <p class="badge bg-info small-text">Dipublish :
                                                {{ $item->created_at->format('d M Y') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="section-title" data-aos="fade-left" style="padding-bottom: 5px">
                            <h2>Laporan Cuaca di Jambi</h2>
                        </div>
                        <div class="text-center">
                            <div id="id218ac80a3b6f5"
                                a='{"t":"a","v":"1.2","lang":"id","locs":[1704],"ssot":"c","sics":"ds","cbkg":"#FFFFFF","cfnt":"#000000","cprb":"#1976D2","cprf":"#FFFFFF","slbr":5,"slmw":400,"sfnt":"a"}'>
                                Sumber Data Cuaca: <a href="https://cuacalab.id/cuaca_jambi/">prakiraan cuaca</a></div>
                            <script async src="https://static1.cuacalab.id/widgetjs/?id=id218ac80a3b6f5"></script>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main><!-- End #main -->
@endsection
