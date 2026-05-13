<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>OPEN DATA PROVINSI JAMBI - @yield('title')</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

    <!-- Favicons -->
    <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Leaflet Maps -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet-ajax/2.1.0/leaflet.ajax.min.js"></script>

    <!-- Google Fonts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets-admin/modules/datatables/datatables.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assets-admin/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
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
    {!! ReCaptcha::htmlScriptTagJsApi() !!}
</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="fixed-top d-flex align-items-center">
        <div class="container d-flex align-items-center justify-content-between">

            <div class="logo">
                <h1><a href="/"><img src="{{ asset('assets/img/jdac-logo-text.png') }}" alt=""
                            srcset=""></a></h1>
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
                            <li><a href="{{ route('web-agenda.index') }}">Rencana Terbit</a></li>
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
                            <li><a href="{{ route('web-metadatasets-api.index') }}">Metadata Sektoral</a></li>
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
                    <li><a class="nav-link fw-bold text-white @if (Route::is('web-permohonan.index')) active @endif"
                            href="{{ route('web-permohonan.index') }}">Permohonan Data</a></li>
                    {{-- <li class="dropdown"><a href="#"><span>Drop Down</span> <i class="bi bi-chevron-down"></i></a>
                        <ul>
                            <li><a href="#">Drop Down 1</a></li>
                            <li class="dropdown"><a href="#"><span>Deep Drop Down</span> <i
                                        class="bi bi-chevron-right"></i></a>
                                <ul>
                                    <li><a href="#">Deep Drop Down 1</a></li>
                                    <li><a href="#">Deep Drop Down 2</a></li>
                                    <li><a href="#">Deep Drop Down 3</a></li>
                                    <li><a href="#">Deep Drop Down 4</a></li>
                                    <li><a href="#">Deep Drop Down 5</a></li>
                                </ul>
                            </li>
                            <li><a href="#">Drop Down 2</a></li>
                            <li><a href="#">Drop Down 3</a></li>
                            <li><a href="#">Drop Down 4</a></li>
                        </ul>
                    </li> --}}
                </ul>
                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav><!-- .navbar -->

        </div>
    </header><!-- End Header -->

    @yield('main')

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

        <div class="container">
            <div class="copyright">
                &copy; Copyright <strong><span>JDAC</span></strong>. All Rights Reserved
            </div>
            <div class="credits">
                Designed by TIM IT JDAC</a>
            </div>
        </div>
    </footer><!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>
    <div id="preloader"></div>



    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.isotope/3.0.6/isotope.pkgd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
    <script src="{{ asset('assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
    <script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>

    <script src="{{ asset('assets-admin/modules/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets-admin/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}">
    </script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('assets-admin/js/page/modules-datatables.js') }}"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <!-- Vendor JS Files -->

    <script>
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content'); // Ambil CSRF token
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
                    console.log('Page view logged:', data);
                })
                .catch(error => {
                    console.error('Error logging page view:', error);
                });
        }

        logPageView(); // Call logPageView setelah halaman dimuat
    </script>

    <script>
        // external js: isotope.pkgd.js

        // init Isotope elements
        var $box = $(".isotope-box").isotope({
            itemSelector: ".isotope-item"
        });
        // filter functions
        // bind filter button click
        $(".isotope-toolbar").on("click", "button", function() {
            var filterValue = $(this).attr("data-type");
            $(".isotope-toolbar-btn").removeClass("active");
            $(this).addClass("active");
            if (filterValue !== "*") {
                filterValue = '[data-type="' + filterValue + '"]';
            }
            // console.log(filterValue);
            $box.isotope({
                filter: filterValue
            });
        });

        // change is-checked class on buttons
    </script>

</body>

</html>
