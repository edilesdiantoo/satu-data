@extends('website-view.layout.layout')
@section('title', 'Storyboard')
@section('main')
    <main id="main">
        <!-- ======= Breadcrumbs Section ======= -->
        <section class="breadcrumbs">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center">
                    <h2>Storyboard</h2>
                    <ol>
                        <li><a href="/">Home</a></li>
                        <li>Informasi</li>
                        <li>Storyboard</li>
                    </ol>
                </div>
            </div>
        </section><!-- End Breadcrumbs Section -->
        <style>
            /* [1] The container */
            .img-hover-zoom {
                height: 200px;
                /* [1.1] Set it as per your need */
                overflow: hidden;
                /* [1.2] Hide the overflowing of child elements */
            }

            /* [2] Transition property for smooth transformation of images */
            .img-hover-zoom img {
                transition: transform .5s ease;
            }

            /* [3] Finally, transforming the image when container gets hovered */
            .img-hover-zoom:hover img {
                transform: scale(1.5);
            }
        </style>
        <section class="inner-page pt-3">
            <div class="container">
                <div class="section-title" data-aos="fade-up" style="padding-bottom: 0px">
                    <h2>Storyboard</h2>
                    <p>{{ $visualisasi->count() }} Storyboard Ditemukan </p>
                </div>
                <div class="row mt-3 g-4" data-aos="fade-left">
                    <div class="col-md-3" data-aos="fade-right">
                        <form action="{{ route('web-storyboard.index') }}" method="get">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1"><i class='bx bx-search'></i></span>
                                        <input type="text" class="form-control" name="judul" value=""
                                            placeholder="Cari Data..." aria-label="Username"
                                            aria-describedby="basic-addon1">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">Urutkan Berdasarkan</span>
                                        <select name="urut" id="urut" class="form-select"
                                            onchange="this.form.submit()">
                                            <option value="terbaru"
                                                {{ app('request')->input('urut') == 'terbaru' ? 'selected' : '' }}>Terbaru
                                            </option>
                                            <option value="abjad"
                                                {{ app('request')->input('urut') == 'abjad' ? 'selected' : '' }}>Abjad
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">Tampilkan Sebanyak</span>
                                        <select name="record" id="record" class="form-select"
                                            onchange="this.form.submit()">
                                            <option
                                                value="10"{{ app('request')->input('record') == 10 ? 'selected' : '' }}>
                                                10</option>
                                            <option
                                                value="20"{{ app('request')->input('record') == 20 ? 'selected' : '' }}>
                                                20</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header header-sosialdankependudukan text-white fw-bold">
                                    Filter Storyboard
                                    <i class="bi bi-funnel-fill float-end"></i>
                                </div>
                                <div class="card-body">
                                    <div class="form-check">
                                        <input class="form-check-input" style="border-radius: 10%" name="sektor"
                                            value="" onChange="this.form.submit()" type="radio"
                                            {{ app('request')->input('sektor') == null ? 'checked' : '' }}>
                                        <label class="form-check-label" for="flexCheckDefault"
                                            style="font-size: 13px;">All</label>
                                    </div>
                                    @foreach ($sektor as $item)
                                        <div class="form-check">
                                            <input class="form-check-input" style="border-radius: 10%" name="sektor"
                                                value="{{ $item->id }}" onChange="this.form.submit()" type="radio"
                                                {{ app('request')->input('sektor') == $item->id ? 'checked' : '' }}>
                                            <label class="form-check-label" style="font-size: 13px;"
                                                for="flexCheckDefault">{{ $item->nama_sektor }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-9">
                        <div class="row">
                            @foreach ($visualisasi as $item)
                                <div class="col-lg-3 col-md-6 d-flex align-items-stretch">
                                    <div class="member aos-init aos-animate" data-aos="fade-up" data-aos-delay="200"
                                        style="width:100%">
                                        <div class="member-img">
                                            <div class="cropper img-hover-zoom">
                                                <a href="{{ route('web-visualisasi.show', [$item->id, 'storyboard']) }}"
                                                    data-gall="portfolioGallery" class="venobox vbox-item">
                                                    <img src="{{ asset('assets/visualisasi-thumbnail/' . $item->gambar) }}"
                                                        class="img-fluid" alt="{{ $item->gambar }}"
                                                        style="width:100%; height: 450px;">
                                                </a>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="member-info pt-1 float-start">
                                                    <h6 class="fw-bold text-uppercase" style="font-size: 12px;">
                                                        {{ \Illuminate\Support\Str::limit($item->judul, 22, $end = '...') }}
                                                    </h6>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <span class="badge bg-info mt-1 mb-3" style="font-size: 10px;">
                                                    {{ App\Http\Controllers\WebController\HomeController::getSektor($item->sektor) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="mt-3">
                        {{ $visualisasi->links('vendor.pagination.bootstrap-5') }}
                    </div>
                </div>
        </section>
    </main><!-- End #main -->
@endsection
