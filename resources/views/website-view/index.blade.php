<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>OPEN DATA PROVINSI JAMBI - HOME</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

    <!-- Favicons -->
    <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.css">
    <!-- Template Main CSS File -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/mycustom.css') }}" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    {{-- <script>
        $(document).ready(function() {
            $("#popupModal").modal('show');
        });
    </script> --}}
</head>

<body>
    <style>
        /* Hover efek pada card */
        .card.hover-zoom {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card.hover-zoom:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        /* Hover efek pada gambar */
        .card img {
            transition: transform 0.3s ease;
        }

        .card:hover img {
            transform: scale(1.05);
        }

        /* Warna judul berubah saat hover */
        .card a h5 {
            transition: color 0.3s ease;
        }

        .card a:hover h5 {
            color: #007bff;
            /* Warna biru untuk interaktif */
        }

        /* visitor */
        .visitor-widget {
            position: fixed;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            /* Background Gradient Baru */
            background: linear-gradient(to right, #010483, #001f3f);
            /* Biru gelap ke biru navy */
            padding: 6px;
            border-radius: 0 15px 15px 0;
            /* Box Shadow yang Lebih Lembut dan Menyebar */
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.25), 0 0 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            width: auto;
            display: flex;
            align-items: center;
            transition: all 0.4s ease-in-out;
            cursor: pointer;
            border: 1px solid rgba(255, 255, 255, 0.2);
            overflow: hidden;

            /* --- PERUBAHAN UTAMA UNTUK TRANSPARANSI --- */
            opacity: 0.3;
            /* Transparan saat tidak aktif (misal 30%) */
            /* Untuk background, kita bisa gunakan rgba agar juga transparan */
            background: linear-gradient(to right, rgba(1, 4, 131, 0.7), rgba(0, 31, 63, 0.7));
            /* Gradien dengan transparansi */
            /* Opsional: Ubah warna border juga */
            border: 1px solid rgba(255, 255, 255, 0.1);
            /* --- AKHIR PERUBAHAN UTAMA --- */
        }

        /* --- PERUBAHAN UNTUK SAAT HOVER/ACTIVE --- */
        .visitor-widget:hover,
        .visitor-widget.active {
            /* Tambahkan .active untuk mobile click */
            opacity: 1;
            /* Sepenuhnya terlihat saat aktif atau dihover */
            background: linear-gradient(to right, #010483, #001f3f);
            /* Kembali ke warna solid saat aktif */
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.35), 0 0 15px rgba(0, 0, 0, 0.15);
            /* Shadow lebih intens saat aktif */
            border: 1px solid rgba(255, 255, 255, 0.2);
            /* Border lebih kontras saat aktif */
        }

        /* --- AKHIR PERUBAHAN UNTUK SAAT HOVER/ACTIVE --- */


        /* Menampilkan detail pengunjung ketika hover ke ikon */
        .visitor-widget:hover .visitor-detail,
        .visitor-widget.active .visitor-detail {
            /* Pastikan ini juga berlaku untuk .active */
            width: 220px;
            opacity: 1;
            padding-left: 18px;
            padding-right: 18px;
            padding-top: 8px;
            padding-bottom: 8px;
            border-left: 1px solid rgba(255, 255, 255, 0.3);
        }

        /* Styling untuk ikon dan detail */
        .visitor-widget-header {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding-right: 12px;
        }

        .visitor-icon {
            font-size: 2.2rem;
            color: #ffd700;
            margin-bottom: 6px;
            transition: transform 0.3s ease-in-out;
        }

        /* Efek ikon saat widget aktif/hover */
        .visitor-widget:hover .visitor-icon,
        .visitor-widget.active .visitor-icon {
            /* Tambahkan .active di sini */
            transform: scale(1.1) rotate(5deg);
        }


        /* Detail pengunjung */
        .visitor-detail {
            width: 0;
            overflow: hidden;
            white-space: nowrap;
            transition: width 0.4s ease-in-out, opacity 0.4s ease-in-out, padding 0.4s ease-in-out, border-left 0.4s ease-in-out;
            opacity: 0;
            padding-left: 0;
            border-left: none;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
            border-top-right-radius: 15px;
            border-bottom-right-radius: 15px;
            /* Ubah background-color menjadi rgba untuk transparansi saat detail terbuka */
            background-color: rgba(0, 0, 0, 0.4);
            /* Transparansi sedang untuk detail terbuka */
        }

        .visitor-detail h5 {
            font-size: 1rem;
            margin-bottom: 10px;
            color: #f0f0f0;
            text-align: left;
            font-weight: 600;
        }

        .visitor-detail ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .visitor-detail li {
            font-size: 0.9rem;
            color: #e0e0e0;
            margin-bottom: 6px;
            text-align: left;
        }

        .visitor-detail li span {
            font-weight: 700;
            color: #aaffaa;
            text-shadow: 0 0 5px rgba(170, 255, 170, 0.5);
        }

        /* Responsif untuk layar kecil (Mobile) */
        @media (max-width: 768px) {
            .visitor-widget {
                flex-direction: row;
                border-radius: 0 15px 15px 0;
                padding: 12px;
                top: 50%;
                transform: translateY(-50%);
                left: 0;
                width: auto;

                /* --- PERUBAHAN UTAMA UNTUK TRANSPARANSI MOBILE --- */
                opacity: 0.3;
                /* Transparan saat tidak aktif di mobile juga */
                background: linear-gradient(to right, rgba(1, 4, 131, 0.7), rgba(0, 31, 63, 0.7));
                border: 1px solid rgba(255, 255, 255, 0.1);
                /* --- AKHIR PERUBAHAN UTAMA --- */
            }

            /* Perilaku hover/active untuk mobile */
            .visitor-widget:hover,
            .visitor-widget.active {
                opacity: 1;
                /* Sepenuhnya terlihat saat aktif di mobile */
                background: linear-gradient(to right, #010483, #001f3f);
                /* Warna solid saat aktif */
                box-shadow: 0 12px 35px rgba(0, 0, 0, 0.35), 0 0 15px rgba(0, 0, 0, 0.15);
                border: 1px solid rgba(255, 255, 255, 0.2);
            }

            .visitor-widget-header {
                padding-right: 12px;
                flex-direction: column;
            }

            .visitor-icon {
                margin-bottom: 6px;
                margin-right: 0;
            }

            .visitor-detail {
                position: static;
                width: 0;
                opacity: 0;
                overflow: hidden;
                white-space: nowrap;
                transition: width 0.4s ease-in-out, opacity 0.4s ease-in-out, padding 0.4s ease-in-out, border-left 0.4s ease-in-out;
                padding-left: 0;
                border-left: none;
                box-shadow: none;
                background-color: transparent;
                /* Tetap transparan untuk bagian yang tidak terlihat */
            }

            /* Detail yang muncul saat hover/active di mobile */
            .visitor-widget:hover .visitor-detail,
            .visitor-widget.active .visitor-detail {
                width: 220px;
                opacity: 1;
                padding-left: 18px;
                padding-right: 18px;
                padding-top: 8px;
                padding-bottom: 8px;
                border-left: 1px solid rgba(255, 255, 255, 0.3);
                background-color: rgba(0, 0, 0, 0.4);
                /* Background untuk detail saat terbuka di mobile */
            }
        }
    </style>
    <!-- ======= Header ======= -->
    <header id="header" class="fixed-top d-flex align-items-center header-transparent">
        <div class="container d-flex align-items-center justify-content-between">

            <div class="logo">
                <h1><a href="{{ route('home') }}"><img src="{{ asset('assets/img/jdac-logo-text.png') }}"
                            alt="" srcset=""></a></h1>
                <!-- Uncomment below if you prefer to use an image logo -->
                <!-- <a href="index.html"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->
            </div>

            <nav id="navbar" class="navbar">
                <ul>
                    <li><a class="nav-link scrollto @if (Route::is('home')) active @endif"
                            href="{{ route('home') }}">Beranda</a></li>
                    <li class="dropdown"><a class="@if (Route::is('web-berita.*')) active @endif"
                            href="#"><span>Informasi</span> <i class="bi bi-chevron-down"></i></a>
                        <ul>
                            <li><a href="{{ route('web-agenda.index') }}">Agenda</a></li>
                            <li><a href="{{ route('web-berita.index') }}">Berita</a></li>
                            <li><a href="{{ route('web-artikel.index') }}">Artikel</a></li>
                            <li><a href="/#infografis">Infografis</a></li>
                            <li><a href="/#buku">Buku Digital</a></li>
                            <li><a href="/#produk">Produk Statistik</a></li>
                            <!--<li><a href="{{ route('web-gallery.index') }}">Gallery</a></li>-->
                        </ul>
                    </li>
                    <li><a class="nav-link @if (Route::is('web-datadasar.*')) active @endif"
                            href="{{ route('web-datadasar.index') }}">Statistik Dasar</a></li>
                    <li class="dropdown"><a class="@if (Route::is('web-datasets.*') || Route::is('web-datasets-api.*')) active @endif"
                            href="#"><span>Datasets</span> <i class="bi bi-chevron-down"></i></a>
                        <ul>
                            <li><a href="{{ route('web-datasets.index') }}">Statistik Sektoral</a></li>
                            <li><a href="{{ route('web-datasets-api.index') }}"> API Statistik Sektoral</a></li>
                        </ul>
                    </li>
                    <li><a class="nav-link @if (Route::is('organisasi.informasi')) active @endif"
                            href="{{ route('organisasi.informasi') }}">Organisasi</a></li>
                    <li class="dropdown"><a class="@if (Route::is('web-berita.*')) active @endif"
                            href="#"><span>Visualisasi</span> <i class="bi bi-chevron-down"></i></a>
                        <ul>
                            <li><a href="{{ route('web-storyboard.index') }}">Storyboard</a></li>
                            <li><a href="/#visualisasi">Dashboard</a></li>
                        </ul>
                    </li>
                    {{-- <li><a class="nav-link scrollto @if (Route::is('home')) active @endif"
                            href="/#visualisasi">Visualisasi</a></li> --}}
                    <li><a class="nav-link fw-bold text-white @if (Route::is('web-permohonan.index.*')) active @endif"
                            href="{{ route('web-permohonan.index') }}">Permohonan Data</a></li>
                </ul>
                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav><!-- .navbar -->

        </div>
    </header><!-- End Header -->

    <!-- ======= Visitor ======= -->
    {{-- visitor --}}
    <div id="visitor-widget" class="visitor-widget">
        <div class="visitor-widget-header">
            <i class="bi bi-people visitor-icon"></i>
        </div>
        <div id="visitor-detail" class="visitor-detail">
            <h5>Detail Pengunjung</h5>
            <ul>
                <li>Pengunjung Hari Ini: <span id="today-visitors"></span></li>
                <li>Pengunjung Bulan Ini: <span id="month-visitors"></span></li>
                <li>Pengunjung Tahun Ini: <span id="year-visitors"></span></li>
                <li>Total Pengunjung: <span id="total-visitors"></span></li>
            </ul>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute(
            'content'); // Ambil CSRF token
            const todayVisitorsSpan = document.getElementById('today-visitors');
            const monthVisitorsSpan = document.getElementById('month-visitors');
            const yearVisitorsSpan = document.getElementById('year-visitors');
            const totalVisitorsSpan = document.getElementById('total-visitors');
            const visitorWidget = document.getElementById('visitor-widget');

            // Fungsi untuk mengirimkan request log pengunjung ke server
            function logPageView() {
                fetch('/log-page-view', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': token, // Tambahkan token CSRF ke header
                        },
                        body: JSON.stringify({
                            url_visited: window.location.href,
                            referrer: document.referrer,
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        // console.log('Page view logged:', data);
                    })
                    .catch(error => {
                        // console.error('Error logging page view:', error);
                    });
            }

            logPageView(); // Call logPageView setelah halaman dimuat

            // Fungsi untuk mengambil data pengunjung
            function fetchVisitorData() {
                fetch('/visitor-data')
                    .then(response => response.json())
                    .then(data => {
                        todayVisitorsSpan.textContent = data.today;
                        monthVisitorsSpan.textContent = data.month;
                        yearVisitorsSpan.textContent = data.year;
                        totalVisitorsSpan.textContent = data.total;
                    })
                    .catch(error => {
                        console.error('Error fetching visitor data:', error);
                    });
            }

            // Ambil data pengunjung setelah halaman dimuat
            fetchVisitorData();

            // Event listener untuk tap/klik pada widget untuk membuka/menutup
            visitorWidget.addEventListener('click', function(event) {
                event.stopPropagation();
                visitorWidget.classList.toggle('active');
            });

            // Event listener untuk tap/klik di mana saja di dokumen (body)
            document.body.addEventListener('click', function(event) {
                if (visitorWidget.classList.contains('active') && !visitorWidget.contains(event.target)) {
                    visitorWidget.classList.remove('active');
                }
            });
        });
    </script>
    <!-- ======= Hero Section ======= -->
    <section id="hero">
        {{-- <video autoplay loop muted playsinline id="heroVideo">
            <source src="{{ asset('assets/background_video.mp4') }}" type="video/mp4">
            Your browser does not support the video tag.
        </video> --}}
        <div id="particles-js" class="bg-transparent" style="z-index: 10;">
        </div>
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-lg-7 pt-5 pt-lg-0 order-2 order-lg-1 d-flex align-items-center">
                    <div data-aos="zoom-out">
                        <h1>Selamat Datang di Open Data <span>Provinsi Jambi</span></h1>
                        <h2>Pusat Data Provinsi Jambi berisikan Statistik Sektoral dan Statistik Dasar.
                            Cari data tentang Jambi kini bisa di mana saja, kapan saja dengan mudah
                        </h2>
                        <div class="text-center text-lg-start">
                            <form action="{{ route('web-datasets.index') }}" method="get">
                                <div class="p-1 bg-light rounded rounded-pill shadow-sm mb-4">
                                    <div class="input-group">
                                        <input type="search" name="judul" placeholder="Data apa yang kamu cari ?"
                                            aria-describedby="button-addon1" class="form-control border-0 bg-light"
                                            style="border-radius: 25px;">
                                        <div class="input-group-append">
                                            <button id="button-addon1" type="submit" class="btn-get-started"><i
                                                    class="bi bi-search"></i> Cari
                                                Sekarang</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 order-1 order-lg-2 hero-img" data-aos="zoom-out" data-aos-delay="300">
                    <img src="{{ asset('assets/img/hero-img.png') }}" class="img-fluid animated" alt="">
                </div>
                <style>
                    .dashboard-highlight .card {
                        border-radius: 50px;
                        box-shadow: 4px 4px 4px 0 rgba(0, 0, 0, .25);
                        margin-top: 70px;
                    }
                </style>
            </div>
        </div>

        <svg class="hero-waves" style="z-index: 0;" xmlns="http://www.w3.org/2000/svg"
            xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 24 150 28 " preserveAspectRatio="none">
            <defs>
                <path id="wave-path" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z">
            </defs>
            <g class="wave1">
                <use xlink:href="#wave-path" x="50" y="3" fill="rgba(255,255,255, .1)">
            </g>
            <g class="wave2">
                <use xlink:href="#wave-path" x="50" y="0" fill="rgba(255,255,255, .2)">
            </g>
            <g class="wave3">
                <use xlink:href="#wave-path" x="50" y="9" fill="#fff">
            </g>
        </svg>
    </section>
    <!-- End Hero -->

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card" style="margin-top: -80px; border-radius:55px;">
                    <div class="card-body">
                        <div class="row text-center g-4">
                            <div class="col-md-2">
                                <a href="{{ route('web-datadasar.index') }}" style="color: #020383">
                                    <i class="bi-file-earmark-bar-graph h4"></i>
                                    <h5 class="fw-bold d-inline">{{ $count_bps }}</h5>
                                    <h5>Statistik Dasar</h5>
                                </a>
                            </div>
                            <div class="col-md-2">
                                <a href="{{ route('web-datasets.index') }}" style="color: #020383">
                                    <i class="bi bi-database h4"></i>
                                    <h5 class="fw-bold d-inline">{{ $count_datasets }}</h5>
                                    <h5>Statistik Sektoral</h5>
                                </a>
                            </div>
                            <div class="col-md-2">
                                <a href="{{ route('web-storyboard.index') }}" style="color: #020383">
                                    <i class="bi bi-file-earmark-text h4"></i>
                                    <h5 class="fw-bold d-inline">{{ $count_storyboard }}</h5>
                                    <h5>Storyboard</h5>
                                </a>
                            </div>
                            <div class="col-md-2">
                                <a href="{{ route('web-infografis.index') }}" style="color: #020383">
                                    <i class="bi bi-grid-1x2 h4"></i>
                                    <h5 class="fw-bold d-inline">{{ $count_infografis }}</h5>
                                    <h5>Infografis</h5>
                                </a>
                            </div>
                            <div class="col-md-2">
                                <a href="{{ route('publikasi-informasi.index') }}" style="color: #020383">
                                    <i class="bi bi-book h4"></i>
                                    <h5 class="fw-bold d-inline">{{ $count_publikasi }}</h5>
                                    <h5>Produk Statistik</h5>
                                </a>
                            </div>
                            <div class="col-md-2">
                                <a href="{{ route('organisasi.informasi') }}" style="color: #020383">
                                    <i class="bi bi-buildings h4"></i>
                                    <h5 class="fw-bold d-inline">{{ $count_opd }}</h5>
                                    <h5>Organisasi</h5>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <main id="main">
        <!-- ======= Statistik Data ======= -->
        <section id="statistik" class="about mt-5 mb-2 pt-3">
            <div class="container">
                <div class="section-title mb-3" data-aos="fade-up" style="padding-top: 18px; padding-bottom:18px">
                    <h2>Berita dan Artikel</h2>
                    <p>Berita dan Artikel Terbaru</p>
                </div>
                <div class="row">
                    <!-- Berita Carousel Section -->
                    <div class="col-md-7 mb-3">
                        <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-indicators">
                                @foreach ($berita as $item)
                                    <button type="button" data-bs-target="#carouselExampleSlidesOnly"
                                        data-bs-slide-to="{{ $loop->index }}"
                                        class="@if ($loop->index == 0) active @endif" aria-current="true"
                                        aria-label="Slide {{ $loop->iteration }}"></button>
                                @endforeach
                            </div>
                            <div class="carousel-inner rounded">
                                @foreach ($berita as $item)
                                    <div class="carousel-item @if ($loop->index == 0) active @endif">
                                        <a
                                            href="{{ route('web-berita.show', ['id' => $item->id, 'slug' => $item->slug]) }}">
                                            <img src="{{ asset('assets/berita-thumbnail/' . $item->gambar) }}"
                                                class="d-block w-100"
                                                style="height:500px; width:600px; object-fit:cover;"
                                                alt="{{ $item->gambar }}">
                                        </a>
                                        <div class="carousel-caption d-none d-md-block text-bg-dark"
                                            style="right: 0%; left:0%; bottom:0%;">
                                            <h6 class="pb-3">
                                                <span class="badge bg-danger float-start">
                                                    {{ $item->created_at->diffForHumans() }}
                                                </span>
                                                <br><br>
                                                <a class="text-white"
                                                    href="{{ route('web-berita.show', ['id' => $item->id, 'slug' => $item->slug]) }}">
                                                    {{ \Illuminate\Support\Str::limit($item->judul, 100, '...') }}
                                                </a>
                                            </h6>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <a class="carousel-control-prev" type="button"
                                data-bs-target="#carouselExampleSlidesOnly" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </a>
                            <a class="carousel-control-next" type="button"
                                data-bs-target="#carouselExampleSlidesOnly" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </a>
                        </div>
                    </div>

                    <!-- Artikel Section -->
                    <div class="col-md-5">
                        <div class="row g-2">
                            @foreach ($artikel as $item)
                                <div class="col-md-6" style="height:166px;">
                                    <div class="mb-3">
                                        <div class="card border-0 shadow-sm h-100 hover-zoom">
                                            <div class="row g-0">
                                                <!-- Thumbnail Gambar -->
                                                <div class="col-4">
                                                    <img src="{{ asset('assets/artikel-thumbnail/' . $item->gambar) }}"
                                                        class="rounded-start" alt="{{ $item->gambar }}"
                                                        style="object-fit: cover; width:100%; height:150px;">
                                                </div>
                                                <!-- Konten Artikel -->
                                                <div class="col-8 d-flex flex-column justify-content-between">
                                                    <div class="card-body py-3 px-2">
                                                        <!-- Judul Artikel -->
                                                        <a href="{{ route('web-artikel.show', ['id' => $item->id, 'slug' => $item->slug]) }}"
                                                            class="text-decoration-none">
                                                            <h5 class="card-title text-dark text-truncate mb-2"
                                                                style="font-size: 12px; font-weight: 600;">
                                                                {{ \Illuminate\Support\Str::limit($item->judul, 50, '...') }}
                                                            </h5>
                                                        </a>
                                                        <!-- Badge Kategori -->
                                                        <div class="mb-2">
                                                            <span class="badge bg-info text-light me-1"
                                                                style="font-size: 10px;">Artikel</span>
                                                            <span class="badge bg-warning text-dark text-capitalize"
                                                                style="font-size: 10px;">
                                                                {{ App\Http\Controllers\WebController\HomeController::getSektor($item->id_sektor) }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <!-- Tanggal Publikasi -->
                                                    <div class="px-2 pb-2">
                                                        <p class="text-muted mb-0" style="font-size: 12px;">
                                                            <i class="bi bi-calendar"></i>
                                                            {{ $item->created_at->format('d F Y') }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <style>
            @media (max-width: 425px) {
                .carousel-inner img {
                    height: 570px !important;
                    width: 600px !important;
                }

                .badge {
                    font-size: 8px;
                }

                .card-title {
                    font-size: 12px;
                }

                .mb-3 img {
                    height: 120px;
                }
            }
        </style>
        <!-- End Statistik Data -->

        <!-- Informasi Data -->
        <section id="highlight" class="counts mt-5 mb-2 pt-3">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 icon-boxes d-flex flex-column align-items-stretch justify-content-center py-5 px-lg-5"
                        data-aos="fade-left">
                        <div class="section-testmonials">
                            <div class="column-testmonials">
                                <div class="section-details">
                                    <h4 class="name-section">Highlight</h4>
                                    <h2 class="title-section">Informasi Datasets Terbaru</h2>
                                </div>
                            </div>
                            <div class="navigation-testmonials">
                                <div class="swiper-button-testmonials-prev"><svg xmlns="http://www.w3.org/2000/svg"
                                        width="64" height="65" viewBox="0 0 64 65" fill="none">
                                        <circle cx="32" cy="32" r="31"
                                            transform="matrix(-1 0 0 1 64 0.947266)" stroke="#FFCB00"
                                            stroke-width="2" />
                                        <path
                                            d="M34.5967 20.9197C35.1642 20.3521 36.0843 20.3521 36.6519 20.9197C37.2194 21.4872 37.2194 22.4073 36.6519 22.9749L34.5967 20.9197ZM36.6519 22.9749L24.3207 35.306L22.2655 33.2509L34.5967 20.9197L36.6519 22.9749Z"
                                            fill="#FFCB00" />
                                        <path
                                            d="M34.9724 45.9749C35.5399 46.5424 36.4601 46.5424 37.0276 45.9749C37.5951 45.4073 37.5951 44.4872 37.0276 43.9197L34.9724 45.9749ZM37.0276 43.9197L24.6964 31.5885L22.6412 33.6437L34.9724 45.9749L37.0276 43.9197Z"
                                            fill="#FFCB00" />
                                    </svg>
                                </div>
                                <div class="swiper-button-testmonials-next"><svg xmlns="http://www.w3.org/2000/svg"
                                        width="64" height="65" viewBox="0 0 64 65" fill="none">
                                        <circle cx="32" cy="32.9473" r="32" fill="#FFCB00" />
                                        <path
                                            d="M29.4033 20.9197C28.8358 20.3521 27.9157 20.3521 27.3481 20.9197C26.7806 21.4872 26.7806 22.4073 27.3481 22.9749L29.4033 20.9197ZM27.3481 22.9749L39.6793 35.306L41.7345 33.2509L29.4033 20.9197L27.3481 22.9749Z"
                                            fill="white" />
                                        <path
                                            d="M29.0276 45.9749C28.4601 46.5424 27.5399 46.5424 26.9724 45.9749C26.4049 45.4073 26.4049 44.4872 26.9724 43.9197L29.0276 45.9749ZM26.9724 43.9197L39.3036 31.5885L41.3588 33.6437L29.0276 45.9749L26.9724 43.9197Z"
                                            fill="white" />
                                    </svg>
                                </div>
                            </div>
                            <div class="swiper-testmonials">
                                <div class="swiper-wrapper">
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
                                        <div class="swiper-slide">
                                            <div class="card-slide">
                                                <div class="row">
                                                    <div class="col-md-3 my-auto">
                                                        <img src="{{ asset('assets/dataset-logo.jpg') }}"
                                                            class="img-fluid rounded mx-auto" width="70"
                                                            alt="{{ $text }}">
                                                    </div>
                                                    <div class="col-md-9">
                                                        <div class="head-slide">
                                                            <div class="header-slide">
                                                                <a
                                                                    href="{{ route('web-datasets.show', ['id' => $item->id, 'slug' => $text]) }}">
                                                                    <div class="title-slide">
                                                                        <h6> {{ \Illuminate\Support\Str::limit($item->judul, 40, $end = '...') }}
                                                                        </h6>
                                                                        <span
                                                                            class="badge bg-warning text-dark mt-2">Statistik
                                                                            Sektoral</span>
                                                                        <span
                                                                            class="badge bg-info text-white mt-2">{{ App\Http\Controllers\WebController\WebDatasetsController::getSektor($item->sektor) }}</span>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="swiper-pagination"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Statistik Data -->

        <!-- ======= Kategori Data ======= -->
        <section id="kategori" class="features" style="padding: 25px">
            <div class="container">
                <div class="section-title" data-aos="fade-up" style="padding-bottom: 10px">
                    <h2>Kategori Data</h2>
                    <p>Pencarian Berdasarkan Topik Terpopuler</p>
                </div>
                <section class="text-center" style="padding: 20px 0px;">
                    <div class="row g-4" data-aos="fade-left">
                        @foreach ($sektor as $item)
                            <div class="col-lg-2 col-md-4">
                                <div class="icon-box child bounce" class="display:grid;" data-aos="zoom-in"
                                    data-aos-delay="50">
                                    <a href="{{ route('web-datasets.index') }}?sektor={{ $item->id }}">
                                        <span class="{{ $item->icon }}" style="color: #010483;"></span>
                                        <h5 class="mt-2 text-dark fw-bold" style="font-size:13px;">
                                            {{ $item->nama_sektor }}</h5>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            </div>
        </section>
        <!-- ======= End Kategori Data ======= -->

        <!-- ======= Visualisasi Section ======= -->
        <section id="visualisasi" class="features" style="padding: 20px">
            <div class="container">

                <div class="section-title" data-aos="fade-up">
                    <h2>Visualisasi</h2>
                    <p>Visualisasi Data</p>
                </div>
                <div class="row g-2" data-aos="fade-up">
                    @foreach ($visualisasi as $item_visualisasi)
                        <div class="col-md-2 d-flex align-items-stretch">
                            <div class="card-visualisasi m-3">
                                <a href="{{ route('web-visualisasi.show', [$item_visualisasi->id, 'dashboard']) }}">
                                    <div class="text-center">
                                        <img style="width: 70px;height:70px;"
                                            src="{{ asset('assets/visualisasi-thumbnail/' . $item_visualisasi->gambar) }}">
                                    </div>
                                    <div class="card-visualisasi__subtitle text-dark mt-2" style="font-size: 9px;"><i
                                            class="bi bi-buildings"></i>
                                        @foreach ($sektor as $item_sektor)
                                            @if ($item_sektor->id == $item_visualisasi->sektor)
                                                {{ $item_sektor->nama_sektor }}
                                            @endif
                                        @endforeach
                                    </div>
                                    <div class="card-visualisasi__wrapper mt-1">
                                        <div class="card-visualisasi__title text-dark" style="font-size: 13px;">
                                            {{ $item_visualisasi->judul }}</div>

                                    </div>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        <!-- End Visualisasi Section -->

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

        <!-- ======= Data Storyboard ======= -->
        <section id="storyboard" class="counts" style="padding: 25px">
            <div class="container">
                <div class="section-title" data-aos="fade-up" style="padding-bottom: 10px">
                    <h2 class="title">Storyboard</h2>
                    <p class="subtitle">Temukan Storyboard</p>
                </div>
                <section class="text-center" style="padding: 20px 0px;">
                    <div class="row g-4 justify-content-center" data-aos="fade-left">
                        @foreach ($storyboard as $item)
                            <div class="col-lg-2 col-md-6 d-flex justify-content-center">
                                <div class="member aos-init aos-animate" data-aos="fade-up" data-aos-delay="200">
                                    <div class="member-img">
                                        <div class="cropper img-hover-zoom">
                                            <a href="{{ route('web-visualisasi.show', [$item->id, 'storyboard']) }}"
                                                class="venobox vbox-item">
                                                <img src="{{ asset('assets/visualisasi-thumbnail/' . $item->gambar) }}"
                                                    class="img-fluid" alt="{{ $item->gambar }}"
                                                    style="width:100%; height: 450px;">
                                            </a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="member-info pt-1 float-start">
                                                <h6 class="fw-bold" style="font-size: 12px;">
                                                    {{ \Illuminate\Support\Str::limit($item->judul, 19, $end = '...') }}
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
                    <div class="col-md-12 mt-3 text-center">
                        <a class="button-custom-1" href="{{ route('web-storyboard.index') }}">Tampilkan
                            lebih banyak</a>
                    </div>
                </section>
            </div>
        </section>

        <style>
            @media (max-width: 450px) {

                .section-title .title,
                .section-title .subtitle {
                    text-align: center;
                    /* Center the text */
                }

                #storyboard .section-title h2::after {
                    content: "";
                    width: 60px;
                    height: 1px;
                    display: inline-block;
                    background: #1acc8d;
                    margin: 4px 10px;
                }

                #storyboard .section-title h2::before {
                    content: "";
                    width: 60px;
                    height: 1px;
                    display: inline-block;
                    background: #1acc8d;
                    margin: 4px 10px;
                }
            }
        </style>

        <!-- ======= Data Infografis ======= -->
        <section id="infografis" class="counts" style="padding: 25px">
            <div class="container">
                <div class="section-title" data-aos="fade-up" style="padding-bottom: 10px">
                    <h2 class="title">Infografis</h2>
                    <p class="subtitle">Temukan Infografis</p>
                </div>
                <section class="text-center" style="padding: 20px 0px;">
                    <div class="row g-4 justify-content-center" data-aos="fade-left">
                        @foreach ($infografis as $item)
                            <div class="col-lg-2 col-md-6 d-flex justify-content-center">
                                <div class="member aos-init aos-animate" data-aos="fade-up" data-aos-delay="200">
                                    <div class="member-img">
                                        <div class="cropper img-hover-zoom">
                                            <a data-bs-toggle="modal"
                                                data-bs-target="#infografis-{{ $item->id }}"
                                                href="{{ asset('assets/infografis/' . $item->gambar) }}"
                                                data-title="{{ $item->judul }}"
                                                data-updated-at="{{ $item->updated_at->format('Y-m-d H:i:s') }}"
                                                data-url="http://127.0.0.1:8000/web-infografis?id={{ $item->id }}"
                                                data-gall="portfolioGallery" class="venobox vbox-item">
                                                <img src="{{ asset('assets/infografis/' . $item->gambar) }}"
                                                    class="img-fluid" alt="{{ $item->gambar }}">
                                            </a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="member-info pt-1 float-start">
                                                <h6 class="fw-bold" style="font-size: 12px;">
                                                    {{ \Illuminate\Support\Str::limit($item->judul, 19, $end = '...') }}
                                                </h6>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <span class="badge bg-info mt-1 mb-3" style="font-size: 10px;">
                                                {{ App\Http\Controllers\WebController\HomeController::getSektor($item->id_sektor) }}
                                            </span>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="col-md-12 mt-3 text-center">
                        <a class="button-custom-1" href="{{ route('web-infografis.index') }}">Tampilkan
                            lebih banyak</a>
                    </div>
                </section>
            </div>
        </section>

        <style>
            .infografis-img {
                width: 100%;
                height: 250px;
            }

            @media (max-width: 450px) {
                .infografis-img {
                    width: 250px;
                    height: 450px;
                }

                #infografis .section-title h2::after {
                    content: "";
                    width: 60px;
                    height: 1px;
                    display: inline-block;
                    background: #1acc8d;
                    margin: 4px 10px;
                }

                #infografis .section-title h2::before {
                    content: "";
                    width: 60px;
                    height: 1px;
                    display: inline-block;
                    background: #1acc8d;
                    margin: 4px 10px;
                }
            }
        </style>

        @foreach ($infografis as $item)
            <!-- Modal -->
            <div class="modal fade" id="infografis-{{ $item->id }}" tabindex="-1"
                aria-labelledby="exampleModalLabel" aria-hidden="true"data-title="{{ $item->judul }}"
                data-updated-at="{{ $item->updated_at }}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">{{ $item->judul }}</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center">
                            <img src="{{ asset('assets/infografis/' . $item->gambar) }}" class="img-fluid"
                                alt="" style="max-height: 665px">
                        </div>
                        <div class="btn-group" role="group" aria-label="Button group to open share modal">
                            <button type="button" class="btn btn-secondary rounded w-100 mx-4 mb-2"
                                onclick="openShareModal('{{ $item->id }}', 'http://127.0.0.1:8000/web-infografis?id={{ $item->id }}')"
                                style="font-size: 12px;">
                                <i class="bi bi-share"></i> Bagikan
                            </button>
                        </div>
                        <a download="images.jpg" href="{{ asset('assets/infografis/' . $item->gambar) }}"
                            class="btn btn-primary mx-4 mb-3"
                            style="font-size: 14px; background-color: rgba(26,29,148,255); color: white; border: none;">Unduh</a>
                    </div>
                </div>
            </div>

            <!-- Share Modal -->
            <div class="modal fade" id="share_modal" tabindex="0" aria-labelledby="share_modalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h5 class="modal-title" id="share_modalLabel">Bagikan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <!-- Modal Body -->
                        <div class="modal-body">
                            <!-- Share Link Section -->
                            <div class="mb-3">
                                <label for="share-url" class="form-label"
                                    style="text-align: left;"><strong>Tautan</strong></label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="share-url"
                                        style="font-size: 12px;" value="" readonly>
                                    <button class="btn" type="button" id="copy-url-btn"
                                        style="font-size: 12px; background-color: rgba(26,29,148,255); color: white; border: none;">Salin</button>
                                </div>
                                <div class="form-text text-success mt-1 d-none" id="copy-success">Tautan berhasil
                                    disalin</div>
                            </div>

                            <!-- Citation Section -->
                            <div class="mb-3">
                                <div class="mb-2 d-flex align-items-center">
                                    <label for="citation-format"
                                        class="form-label me-2"><strong>Kutipan</strong></label>
                                    <select class="form-select" id="citation-format"
                                        style="width: 20%; font-size: 11px;">
                                        <option value="apa" style="font-size: 12px;">APA</option>
                                        <option value="mla" style="font-size: 12px;">MLA</option>
                                        <option value="harvard" style="font-size: 12px;">Harvard</option>
                                    </select>
                                </div>
                                <div class="mt-2 p-2 border rounded">
                                    <p id="citation-text" class="mb-0" style="font-size: 14px">
                                        <!-- Initial APA Citation will be populated by JavaScript -->
                                    </p>
                                </div>
                                <button class="btn mt-2 w-100 ms-0" type="button" id="copy-cite-btn"
                                    style="font-size: 12px; background-color: rgba(26,29,148,255); color: white; border: none;">Salin
                                    Kutipan</button>
                                <div class="form-text text-success mt-1 d-none" id="copy-success-citation">Kutipan
                                    berhasil
                                    disalin</div>
                            </div>

                            <!-- Social Media Share Section -->
                            <div class="d-flex justify-content-center">
                                <a href="#" id="facebook-share" target="_blank"
                                    style="text-align: center; text-decoration: none; width: 50px;" class="me-2">
                                    <img src="{{ asset('assets/img/socials/facebook.svg') }}" alt="Facebook"
                                        style="width: 48px; height: 48px;">
                                    <span style="font-size: 8px; color: black;">Facebook</span>
                                </a>
                                <a href="#" id="twitter-share" target="_blank"
                                    style="text-align: center; text-decoration: none; width: 50px;" class="me-2">
                                    <img src="{{ asset('assets/img/socials/twitter.svg') }}" alt="Facebook"
                                        style="width: 48px; height: 48px;">
                                    <span style="font-size: 8px; color: black;">Twitter</span>
                                </a>
                                <a href="#" id="whatsapp-share" target="_blank"
                                    style="text-align: center; text-decoration: none; width: 50px;" class="me-2">
                                    <img src="{{ asset('assets/img/socials/whatsapp.svg') }}" alt="Facebook"
                                        style="width: 48px; height: 48px;">
                                    <span style="font-size: 8px; color: black;">WhatsApp</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <style>
                #share_modal {
                    z-index: 2000;
                    /* Set a higher z-index for the share modal */
                }
            </style>

            <script>
                function openShareModal(itemId, itemUrl) {
                    // Set the share URL in the input field
                    const shareUrlInput = document.getElementById('share-url');
                    shareUrlInput.value = itemUrl;

                    // Update social media share links
                    document.getElementById('facebook-share').href =
                        `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(itemUrl)}`;
                    document.getElementById('twitter-share').href =
                        `https://twitter.com/intent/tweet?url=${encodeURIComponent(itemUrl)}`;
                    document.getElementById('whatsapp-share').href =
                        `https://api.whatsapp.com/send?text=${encodeURIComponent(itemUrl)}`;

                    // Open the share modal
                    const shareModal = new bootstrap.Modal(document.getElementById('share_modal'));
                    shareModal.show();
                }

                //Tautan Section Script
                document.addEventListener('DOMContentLoaded', function() {
                    // Copy URL to clipboard
                    document.getElementById('copy-url-btn').addEventListener('click', function() {
                        const copyText = document.getElementById('share-url');
                        navigator.clipboard.writeText(copyText.value);
                        document.getElementById('copy-success').classList.remove('d-none');
                        setTimeout(() => {
                            document.getElementById('copy-success').classList.add('d-none');
                        }, 2000);
                    });
                });

                //Citation Section Script
                document.addEventListener('DOMContentLoaded', function() {
                    const citationText = document.getElementById('citation-text');
                    const citationFormat = document.getElementById('citation-format');
                    const currentDate = new Date().toLocaleDateString('id-ID', {
                        day: 'numeric',
                        month: 'long',
                        year: 'numeric'
                    });
                    const currentDate2 = new Date().toLocaleDateString('id-ID', {
                        day: 'numeric',
                        month: 'short',
                        year: 'numeric'
                    });

                    // Function to update citation based on selected format
                    function updateCitation(format, title, updatedAt, url) {
                        const updatedAtDate = new Date(updatedAt);
                        const formattedDate = updatedAtDate.toLocaleDateString('id-ID', {
                            day: 'numeric',
                            month: 'long',
                            year: 'numeric'
                        });
                        const formattedDate2 = updatedAtDate.toLocaleDateString('id-ID', {
                            year: 'numeric'
                        });

                        let citation = '';
                        switch (format) {
                            case 'apa':
                                citation =
                                    `Jambi Data Analytic Center. (${formattedDate}). <i>${title}</i>. Diakses Pada ${currentDate}, dari ${url}`;
                                break;
                            case 'mla':
                                citation =
                                    `Jambi Data Analytic Center. (${formattedDate}). <i>${title}</i>. ${currentDate2}: ${url}.`;
                                break;
                            case 'harvard':
                                citation =
                                    `Jambi Data Analytic Center. (${formattedDate2}). <i>${title}</i> [Online]. Tersedia di: ${url}.`;
                                break;
                            default:
                                citation =
                                    `Jambi Data Analytic Center. (${formattedDate}). <i>${title}</i>. Retrieved from ${url}`;
                        }

                        citationText.innerHTML = citation;
                    }

                    // Update the citation when the share modal is opened
                    const shareModals = document.querySelectorAll('.modal');

                    shareModals.forEach(modal => {
                        modal.addEventListener('show.bs.modal', (event) => {
                            const triggerElement = document.querySelector(
                                `[data-bs-target="#${modal.id}"]`); // Get the <a> that opened the modal
                            const title = triggerElement.getAttribute('data-title');
                            const updatedAt = triggerElement.getAttribute('data-updated-at');
                            const url = triggerElement.getAttribute(
                                'data-url'); // Get the specific URL from data-url

                            // Initial citation update to APA format when the modal opens
                            updateCitation('apa', title, updatedAt, url);
                        });
                    });

                    // Event listener to update citation when format is changed
                    citationFormat.addEventListener('change', function() {
                        const activeModal = document.querySelector('.modal.show');
                        if (activeModal) {
                            const triggerElement = document.querySelector(`[data-bs-target="#${activeModal.id}"]`);
                            const title = triggerElement.getAttribute('data-title');
                            const updatedAt = triggerElement.getAttribute('data-updated-at');
                            const url = triggerElement.getAttribute('data-url');
                            updateCitation(this.value, title, updatedAt, url);
                        }
                    });

                    // Copy citation text to clipboard
                    document.getElementById('copy-cite-btn').addEventListener('click', function() {
                        navigator.clipboard.writeText(citationText.innerText);
                        const copySuccessCitation = document.getElementById('copy-success-citation');
                        copySuccessCitation.classList.remove('d-none');
                        setTimeout(() => {
                            copySuccessCitation.classList.add('d-none');
                        }, 2000);
                    });
                });
            </script>
        @endforeach

        <!-- ======= Produk Statistik Section ======= -->
        <section id="produk" class="counts" style="padding: 20px">
            <div class="container">
                <div class="section-title" data-aos="fade-up">
                    <h2>Produk Statistik</h2>
                    <p>Temukan Produk Statistik</p>
                </div>
                <div class="row" data-aos="fade-left">
                    @foreach ($publikasi as $item)
                        <div class="col-lg-2 col-md-6 d-flex align-items-stretch">
                            <div class="member aos-init aos-animate" style="width: 100%;" data-aos="fade-up"
                                data-aos-delay="200">
                                <div class="member-img" style="height: 200px;">
                                    <div class="cropper">
                                        <a target="_blank" href="{{ route('publikasi-informasi.show', $item->id) }}"
                                            data-gall="portfolioGallery" class="venobox vbox-item">
                                            <img src="{{ asset('assets/cover-publikasi/' . $item->cover) }}"
                                                class="img-fluid" alt="">
                                        </a>
                                    </div>
                                </div>

                                <span class="badge bg-info mt-2" style="font-size: 10px;">
                                    {{ App\Http\Controllers\WebController\HomeController::getSektor($item->id_sektor) }}
                                </span>
                                <div class="member-info pt-1">
                                    <h6 style="font-size: 13px;">
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
                    <div class="col-md-12 mt-3 text-center">
                        <a class="button-custom-1" href="{{ route('publikasi-informasi.index') }}">Tampilkan
                            lebih banyak</a>
                    </div>
                </div>
        </section>
        <!-- End Publikasi Section -->

        <!-- Buku Digtal -->
        <section id="buku" class="features" style="padding: 25px">
            <div class="container">
                <div class="section-title" data-aos="fade-up" style="padding-bottom: 10px">
                    <h2>Buku Digital Statistik</h2>
                    <p>Temukan Buku Digital</p>
                </div>
                <section class="text-center" style="padding: 30px 0px;">
                    <div class="row g-3" data-aos="fade-left">
                        @foreach ($buku as $item)
                            <div class="col-md-3 align-items-center">
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
                                            <h6 class="fw-bold" style="font-size:13px;">
                                                {{ $item->judul }}
                                            </h6>
                                        </div>
                                        <div class="book-card__author">
                                            <span class="badge bg-info" style="font-size:10px;">
                                                {{ App\Http\Controllers\WebController\HomeController::getSektor($item->id_sektor) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
                <div class="col-md-12 mt-3 text-center">
                    <a class="button-custom-1" href="{{ route('web-buku-digital.index') }}">Tampilkan
                        lebih banyak</a>
                </div>
            </div>
        </section>
        <!-- ======= End Buku Digital Section ======= -->

        {{-- <!-- ======= Gallery Section ======= -->
        <section id="gallery" class="gallery" style="padding-top: 30px">
            <div class="container">

                <div class="section-title" data-aos="fade-up">
                    <h2>Gallery</h2>
                    <p>Check our Gallery</p>
                </div>

                <div class="row g-0" data-aos="fade-left">
                    @foreach ($gallery as $item)
                        <div class="col-md-3 text-center">
                            <figure class="figure">
                                <div class="gallery-item " data-aos="zoom-in" data-aos-delay="150">
                                    <a
                                        href="{{ route('web-gallery.show', ['id' => $item->id, 'slug' => $item->slug]) }}">
                                        <img src="{{ asset('assets/gallery-thumbnail/' . $item->gambar) }}"
                                            alt="" class="img-fluid" style="height: 250px;widht: 250px">
                                    </a>
                                </div>
                                <figcaption>
                                    <a
                                        href="{{ route('web-gallery.show', ['id' => $item->id, 'slug' => $item->slug]) }}"><svg
                                            style="isolation:isolate" viewBox="0 0 50 50" width="20px"
                                            height="20px">
                                            <g>
                                                <path
                                                    d=" M 49.334 46.12 L 33.838 30.624 C 36.369 27.403 37.88 23.345 37.88 18.94 C 37.88 8.497 29.384 0 18.94 0 C 8.497 0 0 8.497 0 18.94 C 0 29.384 8.497 37.88 18.94 37.88 C 23.345 37.88 27.403 36.369 30.624 33.838 L 46.12 49.334 C 46.564 49.778 47.146 50 47.727 50 C 48.309 50 48.891 49.778 49.334 49.334 C 50.222 48.447 50.222 47.008 49.334 46.12 Z  M 4.545 18.94 C 4.545 11.003 11.003 4.545 18.94 4.545 C 26.878 4.545 33.335 11.003 33.335 18.94 C 33.335 26.877 26.878 33.335 18.94 33.335 C 11.003 33.335 4.545 26.877 4.545 18.94 Z "
                                                    fill="white"></path>
                                                <path
                                                    d=" M 23.486 16.668 L 21.213 16.668 L 21.213 14.395 C 21.213 13.14 20.195 12.122 18.94 12.122 C 17.685 12.122 16.667 13.14 16.667 14.395 L 16.667 16.668 L 14.395 16.668 C 13.14 16.668 12.122 17.685 12.122 18.94 C 12.122 20.195 13.14 21.213 14.395 21.213 L 16.667 21.213 L 16.667 23.486 C 16.667 24.741 17.685 25.758 18.94 25.758 C 20.195 25.758 21.213 24.741 21.213 23.486 L 21.213 21.213 L 23.486 21.213 C 24.741 21.213 25.758 20.195 25.758 18.94 C 25.758 17.685 24.741 16.668 23.486 16.668 Z "
                                                    fill="white"></path>
                                            </g>
                                        </svg>
                                    </a>
                                    <h4 style="font-size: 10px;">
                                        {{ $item->judul }}
                                    </h4>
                                </figcaption>
                            </figure>
                        </div>
                    @endforeach
                </div>
        </section>
        <!-- End Gallery Section --> --}}

        <!-- ======= F.A.Q Section ======= -->
        {{-- <section id="faq" class="faq section-bg">
            <div class="container">

                <div class="section-title" data-aos="fade-up">
                    <h2>F.A.Q</h2>
                    <p>Frequently Asked Questions</p>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <img class="img-fluid" data-aos="fade-right" src="{{ asset('assets/img/faq.jpg') }}"
                            alt="faq.jpg">
                    </div>
                    <div class="col-md-8">
                        <div class="faq-list">
                            <ul>
                                <li data-aos="fade-up">
                                    <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse"
                                        class="collapsed" data-bs-target="#faq-list-1">Apa saja fungsi Jambi Data
                                        Analytic Center ? <i class="bx bx-chevron-down icon-show"></i><i
                                            class="bx bx-chevron-up icon-close"></i></a>
                                    <div id="faq-list-1" class="collapse" data-bs-parent=".faq-list">
                                        <p>
                                            Berikut beberapa fungsi dan kegiatan yang biasanya dijalankan oleh Jambi
                                            Data
                                            Analytic Center :
                                            <br>
                                            <br>
                                            • Pemantauan Real-time: JDAC dilengkapi dengan layar pemantauan untuk
                                            mengawasi
                                            berbagai aktivitas kota, mulai dari lalu lintas, kondisi cuaca, hingga
                                            insiden-insiden yang mungkin terjadi.
                                            <br>
                                            <br>
                                            • Penerimaan Aduan Masyarakat: Masyarakat bisa melaporkan berbagai
                                            masalah
                                            melalui
                                            platform digital yang terhubung ke JDAC. Hal ini memudahkan pemerintah
                                            kota
                                            untuk
                                            merespons dan menangani aduan dengan lebih cepat.
                                            <br>
                                            <br>
                                            • Analisis Data: Dengan data yang dikumpulkan dari berbagai sumber, JDAC
                                            dapat
                                            menganalisis pola-pola tertentu dalam kota, seperti titik-titik
                                            kemacetan
                                            yang
                                            sering terjadi, atau area yang sering mengalami banjir.
                                            <br>
                                            <br>
                                            • Pengambilan Keputusan: Dengan informasi real-time dan analisis data,
                                            pihak
                                            pemerintah kota dapat membuat keputusan yang lebih tepat dan responsif
                                            terhadap
                                            kebutuhan masyarakat.
                                            <br>
                                            <br>
                                            • Komunikasi dan Informasi: JDAC juga berfungsi sebagai pusat informasi
                                            bagi
                                            masyarakat, memberikan update tentang berbagai hal yang berkaitan dengan
                                            kota.
                                            <br>
                                            <br>
                                            • Kolaborasi dengan Instansi Lain: JDAC seringkali bekerja sama dengan
                                            berbagai
                                            instansi lain, baik di tingkat kota maupun provinsi, untuk koordinasi
                                            tata
                                            kelola
                                            kota.
                                            <br>
                                            <br>
                                        </p>
                                    </div>
                                </li>

                                <li data-aos="fade-up" data-aos-delay="100">
                                    <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse"
                                        data-bs-target="#faq-list-2" class="collapsed">Bagaimana saya mengakses
                                        data
                                        yang ada
                                        di jambi data analytic center ?<i class="bx bx-chevron-down icon-show"></i><i
                                            class="bx bx-chevron-up icon-close"></i></a>
                                    <div id="faq-list-2" class="collapse" data-bs-parent=".faq-list">
                                        <p>
                                            Untuk mengakses data dari jambi data analythic center (JDAC) atau
                                            informasi
                                            yang
                                            berkaitan dengan pelayanan public di Kota Jambi, anda bisa mengikuti
                                            beberapa
                                            Langkah berikut :
                                            <br>
                                            <br>
                                            • Situs web resmi : kunjungi situs web resmi Jambi Data Analythic Center
                                            (JDAC)
                                            https://jdac.jambiprov.go.id/ situs ini menyediakan informasi public,
                                            statistic, dan
                                            data lain yang berkaitan dengan kota.
                                            <br>
                                            <br>
                                            • Sosial media : Jambi Data Analythic Center (JDAC) memiliki akun resmi
                                            di
                                            platform
                                            sosial media seperti Instagram. Akun ini biasanya aktif dan sering
                                            membagikan
                                            informasi terkini tentang kota.
                                            <br>
                                            <br>
                                        </p>
                                    </div>
                                </li>

                                <li data-aos="fade-up" data-aos-delay="200">
                                    <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse"
                                        data-bs-target="#faq-list-3" class="collapsed">Bagaimana saya melihat data
                                        yang telah
                                        divisualisasi? <i class="bx bx-chevron-down icon-show"></i><i
                                            class="bx bx-chevron-up icon-close"></i></a>
                                    <div id="faq-list-3" class="collapse" data-bs-parent=".faq-list">
                                        <p>
                                            Cukup dengan ke menu visualisasi dan memilih data yang ingin
                                            ditampilkan.
                                        </p>
                                    </div>
                                </li>
                                <li data-aos="fade-up" data-aos-delay="200">
                                    <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse"
                                        data-bs-target="#faq-list-4" class="collapsed">Bagaimana saya ingin
                                        mengajukan
                                        data untuk penelitian saya? <i class="bx bx-chevron-down icon-show"></i><i
                                            class="bx bx-chevron-up icon-close"></i></a>
                                    <div id="faq-list-4" class="collapse" data-bs-parent=".faq-list">
                                        <p>
                                            Cukup dengan ke menu visualisasi dan memilih data yang ingin
                                            ditampilkan.
                                        </p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section> --}}
        <!-- End F.A.Q Section -->
    </main>
    <!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="footer">
        <div class="footer-top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-title" data-aos="fade-up">
                            <h2 id="contact">Contact</h2>
                            <p class="text-white">Contact Us</p>
                        </div>
                        <div class="footer-info">
                            <div class="row">
                                <div class="col-md-8">
                                    <p> Jl. Jend. Ahmad Yani No.1, Telanaipura,<br>
                                        Kec. Telanaipura, Kota Jambi, Jambi 36128<br><br>
                                        <strong>Phone:</strong> (0741)<br>
                                        <strong>Email:</strong> jambidataanalitik@gmail.com<br>
                                    </p>
                                    <div class="social-links mt-3">
                                        <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
                                        <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
                                    </div>
                                    <div class="d-inline g-2">
                                        <img src="{{ asset('assets/kerjasama/DISKOMINFO.png') }}"
                                            style="max-width: 100px;">
                                        <img src="{{ asset('assets/kerjasama/portal-indonesia.png') }}"
                                            style="max-width: 100px;">
                                        <img src="{{ asset('assets/kerjasama/satu-data-indonesia.png') }}"
                                            style="max-width: 100px;">
                                        <img src="{{ asset('assets/kerjasama/logo-bps-provinsi-jambi.png') }}"
                                            style="max-width: 100px;">
                                    </div>
                                    <br>
                                    &copy; Copyright <strong><span>JDAC</span></strong>. All Rights Reserved
                                    <div class="credits">
                                        Designed by TIM IT JDAC</a>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div
                                        style="text-decoration:none; overflow:hidden;max-width:100%;width:NaNpx;height:250px;">
                                        <div id="google-maps-canvas" style="height:100%; width:100%;max-width:100%;">
                                            <iframe style="height:100%;width:100%;border:0;" frameborder="0"
                                                src="https://www.google.com/maps/embed/v1/place?q=Kantor+Gubernur+Jambi,+Jalan+Jendral+Ahmad+Yani,+Telanaipura,+Jambi+City,+Jambi,+Indonesia&key=AIzaSyBFw0Qbyq9zTFTd-tUY6dZWTgaQzuU17R8"></iframe>
                                        </div>
                                        <style>
                                            #google-maps-canvas .text-marker {}

                                            .map-generator {
                                                max-width: 100%;
                                                max-height: 100%;
                                                background: none;
                                            }
                                        </style>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer><!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>
    <div id="preloader">
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
    <script src="{{ asset('assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
    <script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="{{ asset('assets/particels-js/particles.js') }}"></script>
    <script src="{{ asset('assets/particels-js/js/app.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.js"></script>
    <!-- Vendor JS Files -->
    <div class="modal fade" id="popupModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img class="img-fluid" src="{{ asset('assets/img/popup.jpg') }}">
                </div>
            </div>
        </div>
    </div>
    <script>
        const swiperTestmonials = new Swiper('.swiper-testmonials', {
            loop: true,
            slidesPerView: 1.2,
            grabCursor: true,
            // Navigation arrows
            navigation: {
                nextEl: '.swiper-button-testmonials-next',
                prevEl: '.swiper-button-testmonials-prev',
            },
            autoplay: {
                delay: 3000,
            },
            pagination: {
                el: '.swiper-pagination',
                type: 'bullets',
            },
            breakpoints: {
                // when window width is >= 640px
                500: {
                    slidesPerView: 1.4,
                },
                780: {
                    slidesPerView: 1.8,
                },
                1300: {
                    slidesPerView: 2.6,
                },
                1630: {
                    slidesPerView: 3.2,
                }
            }

        });
    </script>

</body>

</html>
