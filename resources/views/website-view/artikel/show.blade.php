@extends('website-view.layout.layout')
@section('title', $artikel->judul)
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
        <section class="inner-page">
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <div class="section-title" data-aos="fade-up" style="padding-bottom: 5px">
                            <h2>Artikel</h2>
                            <p>{{ $artikel->judul }}</p>
                        </div>
                        <span class="badge bg-info" data-aos="fade-right">
                            Dipublish : {{ $artikel->created_at->format('d M Y H:i') }}
                        </span>
                        <div class="mt-2" data-aos="fade-right">
                            @php
                                $url_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                            @endphp
                            <a class="btn btn-sm btn-primary"
                                href='https://www.facebook.com/sharer/sharer.php?u=https://127.0.0.1:8000/visualisasi/show/dashboard'
                                target="_blank" title="Share this post on Facebook">
                                <i class="bi bi-facebook"></i> Share
                            </a>
                            <a class="btn btn-sm btn-info text-white"
                                href="https://twitter.com/intent/tweet?text=&amp;url=https://127.0.0.1:8000/visualisasi/show/dashboard"
                                target="_blank" title="Share this post on Twitter">
                                <i class="bi bi-twitter"></i> Tweet
                            </a>
                            <a class="btn btn-sm btn-success"
                                href="https://twitter.com/intent/tweet?text=&amp;url=https://127.0.0.1:8000/visualisasi/show/dashboard"
                                target="_blank" title="Share this post on Twitter">
                                <i class="bi bi-whatsapp"></i> Whatsapp
                            </a>
                            <a class="btn btn-sm btn-outline-primary"
                                href="https://www.linkedin.com/shareArticle?mini=true&url=https://127.0.0.1:8000/visualisasi/show/dashboard&amp;title="
                                target="_blank" title="Share this post on LinkedIn">
                                <i class="bi bi-linkedin" data-fa-transform="grow-2"></i>
                            </a>
                            <a class="btn btn-sm btn-outline-danger"
                                href="https://plus.google.com/share?url=https://127.0.0.1:8000/visualisasi/show/dashboard"
                                target="_blank" title="Share this post on Google Plus">
                                <i class="bi bi-google" data-fa-transform="grow-2"></i>
                            </a>
                        </div>
                        <img class="img-fluid rounded mt-2 mb-2" data-aos="zoom-in-up"
                            src="{{ asset('assets/artikel-thumbnail/' . $artikel->gambar) }}">
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
                        @php
                            echo $artikel->isi;
                        @endphp
                    </div>
                    <div class="col-md-4 gy-3">
                        <div class="section-title" data-aos="fade-left" style="padding-bottom: 5px">
                            <h2>Pencarian</h2>
                        </div>
                        <form method="get" action="{{ route('web-artikel.index') }}" id="form" data-aos="fade-left">
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
                            <h2>Artikel Populer</h2>
                        </div>
                        @foreach ($list as $item)
                            <div class="card" data-aos="fade-left">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4 text-center">
                                            <div class="bg-image hover-overlay ripple shadow-2-strong rounded my-auto"
                                                data-mdb-ripple-color="light">
                                                <a
                                                    href="{{ route('web-artikel.show', ['id' => $item->id, 'slug' => $item->slug]) }}">
                                                    <img src="{{ asset('assets/artikel-thumbnail/' . $item->gambar) }}"
                                                        class="img-fluid" style="width:100%; height: 90px;" />
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <a href="{{ route('web-artikel.show', ['id' => $item->id, 'slug' => $item->slug]) }}"
                                                class="text-black">
                                                <span style="font-size: 13px;"><strong>
                                                        {{ \Illuminate\Support\Str::limit($item->judul, 40, $end = '...') }}
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
