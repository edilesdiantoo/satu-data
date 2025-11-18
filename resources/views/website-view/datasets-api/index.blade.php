@extends('website-view.layout.layout')
@section('title', 'Statistik API Sektoral')
@section('main')
    <main id="main">
        <!-- ======= Breadcrumbs Section ======= -->
        <section class="breadcrumbs">
            <div class="container">

                <div class="d-flex justify-content-between align-items-center">
                    <h2>Statistik API Sektoral</h2>
                    <ol>
                        <li><a href="/">Home</a></li>
                        <li>Statistik API Sektoral</li>
                    </ol>
                </div>
            </div>
        </section><!-- End Breadcrumbs Section -->
        <section class="inner-page">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 my-auto">
                        <div class="section-title" data-aos="fade-up">
                            <h2>Statistik API Sektoral</h2>
                            <p>{{ $datasets->total() }} Data Ditemukan </p>
                        </div>
                    </div>
                    <div class="col-md-8 my-auto">
                        <form action="{{ route('web-datasets-api.index') }}" method="get">
                            <div class="input-group mb-3" data-aos="fade-up">
                                <span class="input-group-text"><i class='bx bx-search'></i></span>
                                <div class="form-floating">
                                    <input type="text" name="judul" value="" class="form-control"
                                        id="floatingInputGroup1" placeholder="Username">
                                    <label for="floatingInputGroup1">Cari Statistik Sektoral</label>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row gy-3">
                    <div class="col-md-3" data-aos="fade-right">
                        <form action="{{ route('web-datasets-api.index') }}" method="get">
                            <div class="row">
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
                                            <option value="terpopuler"
                                                {{ app('request')->input('urut') == 'terpopuler' ? 'selected' : '' }}>
                                                Terpopuler</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">Tampilkan Sebanyak</span>
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
                            </div>
                            <div class="card">
                                <div class="card-header header-sosialdankependudukan text-white fw-bold">
                                    Filter Datasets
                                    <i class="bi bi-funnel-fill float-end"></i>
                                </div>
                                <div class="card-body">
                                    <div class="form-check">
                                        <input class="form-check-input" style="border-radius: 10%" id="flexCheckDefault-1"
                                            name="sektor" value="" onChange="this.form.submit()" type="radio"
                                            {{ app('request')->input('sektor') == null ? 'checked' : '' }}>
                                        <label class="form-check-label" style="font-size: 12px;"
                                            for="flexCheckDefault-1">All</label>
                                    </div>
                                    @foreach ($sektor as $item)
                                        <div class="form-check">
                                            <input class="form-check-input" style="border-radius: 10%"
                                                id="flexCheckDefault-{{ $item->id }}" name="sektor"
                                                value="{{ $item->id }}" onChange="this.form.submit()" type="radio"
                                                {{ app('request')->input('sektor') == $item->id ? 'checked' : '' }}>
                                            <label class="form-check-label" style="font-size: 12px;"
                                                for="flexCheckDefault-{{ $item->id }}">{{ $item->nama_sektor }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="col-md-9">
                        @foreach ($datasets as $item)
                            <?php
                            // replace non letter or digits by divider
                            $text = preg_replace('~[^\pL\d]+~u', '-', $item->judul);
                            
                            // transliterate
                            $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
                            
                            // remove unwanted characters
                            $text = preg_replace('~[^-\w]+~', '', $text);
                            
                            // trim
                            $text = trim($text, '-');
                            
                            // remove duplicate divider
                            $text = preg_replace('~-+~', '-', $text);
                            
                            // lowercase
                            $text = strtolower($text);
                            
                            ?>
                            <div class="card" style="margin-bottom:15px;" data-aos="fade-up">
                                <div class="g-2 py-3 row">
                                    <div class="position-relative px-4 col-lg-1 col-md-2 col-sm-3 col-4 my-auto mx-auto"
                                        style="width: 7.33rem;">
                                        <img src="{{ asset('assets/dataicon.png') }}" alt=""
                                            class="img-fluid ms-3">
                                    </div>
                                    <div class="col-lg col-md col-sm-9 col-8 px-4">
                                        <div class="flex-grow-1 row">
                                            <div class="col">
                                                <div class="d-flex flex-column gap-2">
                                                    <div class="fs-16 font-weight-500 text-capitalize">
                                                        <a class="fw-bold text-capitalize"
                                                            href="{{ route('web-datasets-api.show', [$item->id, $text]) }}"
                                                            style="color: #3f67d8">{{ $item->judul }}</a>
                                                    </div>
                                                    <div class="d-flex flex-column flex-sm-row gap-2">
                                                        <div class="d-flex align-items-center gap-1"><svg width="20"
                                                                height="21" viewBox="0 0 20 21" fill="none"
                                                                xmlns="http://www.w3.org/2000/svg">
                                                                <path opacity="0.4"
                                                                    d="M1.74997 18.8334V5.52504C1.74997 3.85004 2.58335 3.00836 4.24168 3.00836H9.43333C11.0917 3.00836 11.9166 3.85004 11.9166 5.52504V18.8334"
                                                                    fill="#F98404"></path>
                                                                <path
                                                                    d="M8.95832 8H4.83331C4.49165 8 4.20831 7.71667 4.20831 7.375C4.20831 7.03333 4.49165 6.75 4.83331 6.75H8.95832C9.29999 6.75 9.58332 7.03333 9.58332 7.375C9.58332 7.71667 9.29999 8 8.95832 8Z"
                                                                    fill="#F98404"></path>
                                                                <path
                                                                    d="M8.95832 11.125H4.83331C4.49165 11.125 4.20831 10.8417 4.20831 10.5C4.20831 10.1583 4.49165 9.875 4.83331 9.875H8.95832C9.29999 9.875 9.58332 10.1583 9.58332 10.5C9.58332 10.8417 9.29999 11.125 8.95832 11.125Z"
                                                                    fill="#F98404"></path>
                                                                <path
                                                                    d="M6.875 19.4583C6.53333 19.4583 6.25 19.175 6.25 18.8333V15.7083C6.25 15.3666 6.53333 15.0833 6.875 15.0833C7.21667 15.0833 7.5 15.3666 7.5 15.7083V18.8333C7.5 19.175 7.21667 19.4583 6.875 19.4583Z"
                                                                    fill="#F98404"></path>
                                                                <path
                                                                    d="M19.1667 18.2084H17.275V15.7084C18.0667 15.45 18.6417 14.7084 18.6417 13.8334V12.1667C18.6417 11.075 17.75 10.1833 16.6583 10.1833C15.5667 10.1833 14.675 11.075 14.675 12.1667V13.8334C14.675 14.7 15.2417 15.4333 16.0167 15.7V18.2084H0.833344C0.491677 18.2084 0.208344 18.4917 0.208344 18.8334C0.208344 19.175 0.491677 19.4584 0.833344 19.4584H16.6083C16.625 19.4584 16.6333 19.4667 16.65 19.4667C16.6667 19.4667 16.675 19.4584 16.6917 19.4584H19.1667C19.5083 19.4584 19.7917 19.175 19.7917 18.8334C19.7917 18.4917 19.5083 18.2084 19.1667 18.2084Z"
                                                                    fill="#F98404"></path>
                                                            </svg>
                                                            <div class="fs-14 font-weight-400 text-capitalize">
                                                                {{ $item->opd->nama_opd }}</div>
                                                        </div>
                                                        <div class="d-flex align-items-center gap-1">
                                                            <div class="fs-14 font-weight-400 text-capitalize">
                                                                <span class="badge opacity-70"
                                                                    style="background-color: #3f67d8">
                                                                    {{ App\Http\Controllers\WebController\WebDatasetsController::getSektor($item->id_sektor) }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div
                                                    class="d-flex flex-column align-items-start align-align-items-lg-end gap-2">
                                                    <div class="fs-14 font-weight-500 text-capitalize">
                                                        {{ $item->updated_at->format('d M Y') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="mt-3">
                            {{ $datasets->links('vendor.pagination.bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
