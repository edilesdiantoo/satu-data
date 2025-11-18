@extends('website-view.layout.layout')
@section('title', 'Statistik Sektoral')
@section('main')
    <main id="main">
        <!-- ======= Breadcrumbs Section ======= -->
        <section class="breadcrumbs">
            <div class="container">

                <div class="d-flex justify-content-between align-items-center">
                    <h2>Statistik Sektoral</h2>
                    <ol>
                        <li><a href="/">Home</a></li>
                        <li>Statistik Sektoral</li>
                    </ol>
                </div>
            </div>
        </section><!-- End Breadcrumbs Section -->
        <section class="inner-page">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 my-auto">
                        <div class="section-title" data-aos="fade-up">
                            <h2>Statistik Sektoral</h2>
                            <p>{{ $datasets->total() }} Data Ditemukan </p>
                        </div>
                    </div>
                    <div class="col-md-8 my-auto">
                        <form action="{{ route('web-datasets.index') }}" method="get">
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
                        <form action="{{ route('web-datasets.index') }}" method="get">
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
                            <?php $viewer = 0; ?>
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
                            @foreach ($seen as $item_seen)
                                @if ($item->id == $item_seen->id_datasets)
                                    @php
                                        $viewer = $viewer + 1;
                                    @endphp
                                @endif
                            @endforeach
                            <div class="card" style="margin-bottom:15px;" data-aos="fade-up">
                                <div class="g-2 py-3 row">
                                    <div class="position-relative px-4 col-lg-1 col-md-2 col-sm-3 col-4 my-auto mx-auto"
                                        style="width: 7.33rem;">
                                        <img src="{{ asset('assets/dataicon.png') }}" alt=""
                                            class="img-fluid ms-3">
                                        {{-- <svg width="88" height="88" viewBox="0 0 88 88" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <g clip-path="url(#clip0_4151_20419)">
                                                <rect width="88" height="88" rx="12" fill="#00988B"
                                                    fill-opacity="0.2"></rect>
                                                <ellipse cx="23.5" cy="64" rx="35.5" ry="35"
                                                    fill="#00988B" fill-opacity="0.12"></ellipse>
                                                <circle cx="44.5" cy="105.5" r="29" stroke="#00988B"
                                                    stroke-opacity="0.2"></circle>
                                                <path opacity="0.4"
                                                    d="M43.9993 31.7167V61.105C43.6877 61.105 43.3577 61.05 43.101 60.9034L43.0277 60.8667C39.5077 58.9417 33.366 56.925 29.3877 56.3934L28.856 56.32C27.096 56.1 25.666 54.45 25.666 52.69V30.5434C25.666 28.3617 27.4443 26.7117 29.626 26.895C33.476 27.2067 39.306 29.15 42.5693 31.185L43.0277 31.46C43.3027 31.625 43.651 31.7167 43.9993 31.7167Z"
                                                    fill="#00988B"></path>
                                                <path
                                                    d="M62.3333 30.5616V52.6899C62.3333 54.4499 60.9033 56.0999 59.1433 56.3199L58.5383 56.3932C54.5417 56.9249 48.3817 58.9599 44.8617 60.9032C44.6233 61.0499 44.33 61.1049 44 61.1049V31.7166C44.3483 31.7166 44.6967 31.6249 44.9717 31.4599L45.2833 31.2582C48.5467 29.2049 54.395 27.2432 58.245 26.9132H58.355C60.5367 26.7299 62.3333 28.3616 62.3333 30.5616Z"
                                                    fill="#00988B"></path>
                                                <path
                                                    d="M36.209 38.9399H32.084C31.3323 38.9399 30.709 38.3166 30.709 37.5649C30.709 36.8133 31.3323 36.1899 32.084 36.1899H36.209C36.9607 36.1899 37.584 36.8133 37.584 37.5649C37.584 38.3166 36.9607 38.9399 36.209 38.9399Z"
                                                    fill="#00988B"></path>
                                                <path
                                                    d="M37.584 44.4399H32.084C31.3323 44.4399 30.709 43.8166 30.709 43.0649C30.709 42.3133 31.3323 41.6899 32.084 41.6899H37.584C38.3357 41.6899 38.959 42.3133 38.959 43.0649C38.959 43.8166 38.3357 44.4399 37.584 44.4399Z"
                                                    fill="#00988B"></path>
                                            </g>
                                            <defs>
                                                <clipPath id="clip0_4151_20419">
                                                    <rect width="88" height="88" rx="12" fill="white">
                                                    </rect>
                                                </clipPath>
                                            </defs>
                                        </svg> --}}
                                    </div>
                                    <div class="col-lg col-md col-sm-9 col-8 px-4">
                                        <div class="flex-grow-1 row">
                                            <div class="col">
                                                <div class="d-flex flex-column gap-2">
                                                    <div class="fs-16 font-weight-500 text-capitalize">
                                                        <a class="fw-bold text-capitalize"
                                                            href="{{ route('web-datasets.show', [$item->id, $text]) }}"
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
                                                                {{ $item->nama_opd }}</div>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex flex-column flex-sm-row gap-2">
                                                        <div class="d-flex align-items-center gap-1"><svg width="20"
                                                                height="21" viewBox="0 0 20 21" fill="none"
                                                                xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M13.9583 3.46669V2.16669C13.9583 1.82502 13.675 1.54169 13.3333 1.54169C12.9917 1.54169 12.7083 1.82502 12.7083 2.16669V3.41669H7.29165V2.16669C7.29165 1.82502 7.00832 1.54169 6.66665 1.54169C6.32499 1.54169 6.04165 1.82502 6.04165 2.16669V3.46669C3.79165 3.67502 2.69999 5.01669 2.53332 7.00835C2.51665 7.25002 2.71665 7.45002 2.94999 7.45002H17.05C17.2917 7.45002 17.4917 7.24169 17.4667 7.00835C17.3 5.01669 16.2083 3.67502 13.9583 3.46669Z"
                                                                    fill="#F98404"></path>
                                                                <path opacity="0.4"
                                                                    d="M16.6667 8.70001C17.125 8.70001 17.5 9.07501 17.5 9.53335V14.6667C17.5 17.1667 16.25 18.8333 13.3333 18.8333H6.66667C3.75 18.8333 2.5 17.1667 2.5 14.6667V9.53335C2.5 9.07501 2.875 8.70001 3.33333 8.70001H16.6667Z"
                                                                    fill="#F98404"></path>
                                                                <path
                                                                    d="M7.08333 13C6.86667 13 6.65 12.9083 6.49167 12.7583C6.34167 12.6 6.25 12.3833 6.25 12.1666C6.25 11.95 6.34167 11.7333 6.49167 11.575C6.725 11.3416 7.09167 11.2666 7.4 11.4C7.50833 11.4416 7.6 11.5 7.675 11.575C7.825 11.7333 7.91667 11.95 7.91667 12.1666C7.91667 12.3833 7.825 12.6 7.675 12.7583C7.51667 12.9083 7.3 13 7.08333 13Z"
                                                                    fill="#F98404"></path>
                                                                <path
                                                                    d="M9.99999 13C9.78332 13 9.56666 12.9083 9.40832 12.7583C9.25832 12.6 9.16666 12.3833 9.16666 12.1666C9.16666 11.95 9.25832 11.7333 9.40832 11.575C9.48332 11.5 9.57499 11.4416 9.68332 11.4C9.99166 11.2666 10.3583 11.3416 10.5917 11.575C10.7417 11.7333 10.8333 11.95 10.8333 12.1666C10.8333 12.3833 10.7417 12.6 10.5917 12.7583C10.55 12.7916 10.5083 12.825 10.4667 12.8583C10.4167 12.8916 10.3667 12.9167 10.3167 12.9333C10.2667 12.9583 10.2167 12.975 10.1667 12.9833C10.1083 12.9917 10.0583 13 9.99999 13Z"
                                                                    fill="#F98404"></path>
                                                                <path
                                                                    d="M12.9167 13C12.7 13 12.4833 12.9083 12.325 12.7583C12.175 12.6 12.0833 12.3833 12.0833 12.1667C12.0833 11.95 12.175 11.7333 12.325 11.575C12.4083 11.5 12.4917 11.4416 12.6 11.4C12.75 11.3333 12.9167 11.3166 13.0833 11.35C13.1333 11.3583 13.1833 11.375 13.2333 11.4C13.2833 11.4166 13.3333 11.4417 13.3833 11.475C13.425 11.5083 13.4667 11.5417 13.5083 11.575C13.6583 11.7333 13.75 11.95 13.75 12.1667C13.75 12.3833 13.6583 12.6 13.5083 12.7583C13.4667 12.7916 13.425 12.825 13.3833 12.8583C13.3333 12.8916 13.2833 12.9167 13.2333 12.9333C13.1833 12.9583 13.1333 12.975 13.0833 12.9833C13.025 12.9917 12.9667 13 12.9167 13Z"
                                                                    fill="#F98404"></path>
                                                                <path
                                                                    d="M7.08333 15.9167C6.975 15.9167 6.86667 15.8917 6.76667 15.85C6.65833 15.8084 6.575 15.75 6.49167 15.675C6.34167 15.5167 6.25 15.3 6.25 15.0833C6.25 14.8667 6.34167 14.65 6.49167 14.4917C6.575 14.4167 6.65833 14.3583 6.76667 14.3167C6.91667 14.25 7.08333 14.2333 7.25 14.2667C7.3 14.275 7.35 14.2917 7.4 14.3167C7.45 14.3333 7.5 14.3584 7.55 14.3917C7.59167 14.425 7.63333 14.4584 7.675 14.4917C7.825 14.65 7.91667 14.8667 7.91667 15.0833C7.91667 15.3 7.825 15.5167 7.675 15.675C7.63333 15.7083 7.59167 15.75 7.55 15.775C7.5 15.8083 7.45 15.8334 7.4 15.85C7.35 15.875 7.3 15.8917 7.25 15.9C7.19167 15.9084 7.14167 15.9167 7.08333 15.9167Z"
                                                                    fill="#F98404"></path>
                                                                <path
                                                                    d="M9.99999 15.9167C9.78332 15.9167 9.56666 15.825 9.40832 15.675C9.25832 15.5167 9.16666 15.3 9.16666 15.0833C9.16666 14.8667 9.25832 14.65 9.40832 14.4917C9.71666 14.1834 10.2833 14.1834 10.5917 14.4917C10.7417 14.65 10.8333 14.8667 10.8333 15.0833C10.8333 15.3 10.7417 15.5167 10.5917 15.675C10.4333 15.825 10.2167 15.9167 9.99999 15.9167Z"
                                                                    fill="#F98404"></path>
                                                                <path
                                                                    d="M12.9167 15.9167C12.7 15.9167 12.4833 15.825 12.325 15.675C12.175 15.5167 12.0833 15.3 12.0833 15.0833C12.0833 14.8667 12.175 14.65 12.325 14.4917C12.6333 14.1834 13.2 14.1834 13.5083 14.4917C13.6583 14.65 13.75 14.8667 13.75 15.0833C13.75 15.3 13.6583 15.5167 13.5083 15.675C13.35 15.825 13.1333 15.9167 12.9167 15.9167Z"
                                                                    fill="#F98404"></path>
                                                            </svg>
                                                            <div class="fs-14 font-weight-400 text-capitalize">
                                                                {{ $item->tahun_datasets }}</div>
                                                        </div>
                                                        <div class="sc-fjvvzt hjjJXH">
                                                            <div
                                                                class="fs-14 font-weight-400 text-capitalize text-primary py-1 px-2">
                                                                <i class="bx bx-download"></i>
                                                                {{ $item->jumlah_unduhan }}
                                                            </div>
                                                        </div>
                                                        <div class="d-flex align-items-center gap-1">
                                                            <div class="fs-14 font-weight-400 text-capitalize">
                                                                <span class="badge opacity-70"
                                                                    style="background-color: #3f67d8">
                                                                    {{ App\Http\Controllers\WebController\WebDatasetsController::getSektor($item->sektor) }}
                                                            </div>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div
                                                    class="d-flex flex-column align-items-start align-align-items-lg-end gap-2">
                                                    <div class="d-flex align-items-center gap-1"><svg width="20"
                                                            height="20" viewBox="0 0 20 21" fill="none"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path opacity="0.4"
                                                                d="M17.7083 8.125C15.7833 5.1 12.9667 3.35834 9.99999 3.35834C8.51666 3.35834 7.07499 3.79167 5.75832 4.6C4.44166 5.41667 3.25832 6.60834 2.29166 8.125C1.45832 9.43334 1.45832 11.5583 2.29166 12.8667C4.21666 15.9 7.03332 17.6333 9.99999 17.6333C11.4833 17.6333 12.925 17.2 14.2417 16.3917C15.5583 15.575 16.7417 14.3833 17.7083 12.8667C18.5417 11.5667 18.5417 9.43334 17.7083 8.125ZM9.99999 13.8667C8.13332 13.8667 6.63332 12.3583 6.63332 10.5C6.63332 8.64167 8.13332 7.13334 9.99999 7.13334C11.8667 7.13334 13.3667 8.64167 13.3667 10.5C13.3667 12.3583 11.8667 13.8667 9.99999 13.8667Z"
                                                                fill="#8D9197"></path>
                                                            <path
                                                                d="M10 8.11664C8.69167 8.11664 7.625 9.1833 7.625 10.5C7.625 11.8083 8.69167 12.875 10 12.875C11.3083 12.875 12.3833 11.8083 12.3833 10.5C12.3833 9.19164 11.3083 8.11664 10 8.11664Z"
                                                                fill="#8D9197"></path>
                                                        </svg>
                                                        <div class="fs-14 font-weight-400 text-capitalize">
                                                            {{ $viewer }}
                                                            Lihat</div>
                                                    </div>
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

    </main><!-- End #main -->
@endsection
