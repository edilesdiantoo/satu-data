<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title> @yield('title') &mdash; Satu Data Jambi Data dan Analitik Center</title>

    <!-- Favicons -->
    <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- General CSS Files -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <link rel="stylesheet" href="{{ asset('assets-admin/modules/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-admin/modules/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('assets-admin/modules/datatables/datatables.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assets-admin/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assets-admin/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-admin/modules/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-admin/modules/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-admin/modules/weather-icon/css/weather-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-admin/modules/weather-icon/css/weather-icons-wind.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-admin/modules/summernote/summernote-bs4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-admin/modules/codemirror/lib/codemirror.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-admin/modules/codemirror/theme/duotone-dark.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-admin/modules/jquery-selectric/selectric.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css"
        rel="stylesheet" />

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('assets-admin/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-admin/css/components.css') }}">
    <!-- Start GA -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'UA-94034622-3');
    </script>
    <!-- /END GA -->
</head>
@php
    $data = App\Http\Controllers\OPD\OpdAktivitasController::data();
    $data_user = App\Http\Controllers\OPD\OpdAktivitasController::data_user();
    $graph = App\Http\Controllers\OPD\OpdGraphController::grafik();
    $i = 0;
    $j = 0;
    $nama_opd = '';
@endphp

<body class="layout-3" cz-shortcut-listen="true">
    <div id="app">
        <div class="main-wrapper container-fluid">
            <div class="navbar-bg"></div>
            <nav class="navbar navbar-expand-lg main-navbar">
                <a href="{{ route('opd_dashboard') }}" class="navbar-brand sidebar-gone-hide"><img
                        src="{{ asset('assets-admin/img/logo_satu_data.png') }}" alt="logo"
                        style="width: 150px;"></a>
                <a href="#" class="nav-link sidebar-gone-show" data-toggle="sidebar"><i
                        class="fas fa-bars"></i></a>
                <form class="form-inline ml-auto">
                    <ul class="navbar-nav">
                        <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i
                                    class="fas fa-search"></i></a></li>
                    </ul>
                    <div class="search-element">
                        <input class="form-control" type="search" name="q" placeholder="Google Search"
                            aria-label="Search" data-width="250">
                        <button class="btn" type="submit"><i class="fas fa-search"></i></button>
                        <div class="search-backdrop"></div>
                    </div>
                </form>
                <ul class="navbar-nav navbar-right">
                    <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown"
                            class="nav-link nav-link-lg message-toggle beep"><i class="far fa-envelope"></i></a>
                        <div class="dropdown-menu dropdown-list dropdown-menu-right">
                            <div class="dropdown-header">Messages</div>
                            <div class="dropdown-list-content dropdown-list-message">
                                @foreach ($data as $item)
                                    @if ($j <= 5)
                                        @if ($item->status == 'D1')
                                            @foreach ($data_user as $item_user)
                                                @if ($item->id_user == $item_user->id)
                                                    <a href="#" class="dropdown-item dropdown-item-unread">
                                                        <div class="dropdown-item-avatar">
                                                            <img alt="image"
                                                                src="{{ asset('assets/photo-profile/' . $item_user->photo) }}"
                                                                class="rounded-circle">
                                                        </div>
                                                        <div class="dropdown-item-desc">
                                                            <b>{{ $item_user->name }}</b>
                                                            <p>{{ $item->pesan }}</p>
                                                            <div class="time">
                                                                {{ $item->created_at->diffForHumans() }}</div>
                                                        </div>
                                                    </a>
                                                @endif
                                            @endforeach
                                            @php
                                                $j = $j + 1;
                                            @endphp
                                        @elseif($item->status == 'D7')
                                            @foreach ($data_user as $item_user)
                                                @if ($item->id_user == $item_user->id)
                                                    <a href="#" class="dropdown-item dropdown-item-unread">
                                                        <div class="dropdown-item-avatar">
                                                            <img alt="image"
                                                                src="{{ asset('assets/photo-profile/' . $item_user->photo) }}"
                                                                class="rounded-circle">
                                                        </div>
                                                        <div class="dropdown-item-desc">
                                                            <b>{{ $item_user->name }}</b>
                                                            <p>{{ $item->pesan }}</p>
                                                            <div class="time">
                                                                {{ $item->created_at->diffForHumans() }}</div>
                                                        </div>
                                                    </a>
                                                @endif
                                            @endforeach
                                            @php
                                                $j = $j + 1;
                                            @endphp
                                        @endif
                                    @endif
                                @endforeach
                            </div>
                            <div class="dropdown-footer text-center">
                                <a href="{{ route('opdaktivitas.index') }}">View All <i
                                        class="fas fa-chevron-right"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown"
                            class="nav-link notification-toggle nav-link-lg beep"><i class="far fa-bell"></i></a>
                        <div class="dropdown-menu dropdown-list dropdown-menu-right">
                            <div class="dropdown-header">Notifications</div>
                            <div class="dropdown-list-content dropdown-list-icons">
                                @foreach ($data as $item)
                                    @if ($i <= 5)
                                        @if ($item->status == 'D5')
                                            @foreach ($data_user as $item_user)
                                                @if ($item->id_user == $item_user->id)
                                                    <a href="#" class="dropdown-item">
                                                        <div class="dropdown-item-icon bg-success text-white">
                                                            <i class="fas fa-check"></i>
                                                        </div>
                                                        <div class="dropdown-item-desc">
                                                            {{ $item->role }} <b>{{ $item_user->name }}</b>
                                                            {{ $item->pesan }}
                                                            <div class="time">
                                                                {{ $item->created_at->diffForHumans() }}</div>
                                                        </div>
                                                    </a>
                                                @endif
                                            @endforeach
                                            @php
                                                $i = $i + 1;
                                            @endphp
                                        @elseif($item->status == 'D6')
                                            @foreach ($data_user as $item_user)
                                                @if ($item->id_user == $item_user->id)
                                                    <a href="#" class="dropdown-item">
                                                        <div class="dropdown-item-icon bg-danger text-white">
                                                            <i class="fas fa-exclamation-triangle"></i>
                                                        </div>
                                                        <div class="dropdown-item-desc">
                                                            {{ $item->role }} <b>{{ $item_user->name }}</b>
                                                            {{ $item->pesan }}
                                                            <div class="time">
                                                                {{ $item->created_at->diffForHumans() }}</div>
                                                        </div>
                                                    </a>
                                                @endif
                                            @endforeach
                                            @php
                                                $i = $i + 1;
                                            @endphp
                                        @endif
                                    @endif
                                @endforeach
                            </div>
                            <div class="dropdown-footer text-center">
                                <a href="{{ route('opdaktivitas.index') }}">View All <i
                                        class="fas fa-chevron-right"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="dropdown"><a href="#" data-toggle="dropdown"
                            class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                            <img alt="image" src="{{ asset('assets/photo-profile/' . Auth::user()->photo) }}"
                                class="rounded-circle mr-1">
                            <div class="d-sm-none d-lg-inline-block">Hi, {{ Auth::user()->name }}</div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <div class="dropdown-title">Akun Dibuat Sejak
                                <br>{{ Auth::user()->created_at->format('d-M-Y') }}
                            </div>
                            <a href="{{ route('opdprofile.index') }}" class="dropdown-item has-icon">
                                <i class="far fa-user"></i> Profile
                            </a>
                            <a href="{{ route('opdaktivitas.index') }}" class="dropdown-item has-icon">
                                <i class="fas fa-bolt"></i> Activities
                            </a>
                            <div class="dropdown-divider"></div>
                            <form action="{{ route('logout.opd') }}" method="post">
                                @csrf
                                <button type="submit" class="dropdown-item has-icon text-danger"> Logout
                                </button>
                            </form>
                        </div>
                    </li>
                </ul>
            </nav>
            <?php
            $c_permohonan_masuk = App\Http\Controllers\OPD\OpdDashboardController::getPermohonanMasuk(Auth::user()->id_opd);
            $c_datasets_berbagi = App\Http\Controllers\OPD\OpdDashboardController::getDatasetsBerbagiNotification(Auth::user()->id_opd);
            ?>
            <nav class="navbar navbar-secondary navbar-expand-lg">
                <div class="container-fluid">
                    <ul class="navbar-nav">
                        <li class="nav-item @if (Route::is('opd_dashboard')) active @endif">
                            <a href="{{ route('opd_dashboard') }}" class="nav-link"><i
                                    class="fas fa-fire"></i><span>Dashboard Satu
                                    Data</span></a>
                        </li>
                        <li class="nav-item @if (Route::is('opddatasets.*') || Route::is('opdpermohonan-data.*') || Route::is('opddatasetsshare.*')) active @endif dropdown">
                            <a href="#" data-toggle="dropdown"
                                class="nav-link has-dropdown @if ($c_permohonan_masuk != 0) beep @endif"><i
                                    class="fas fa-database"></i><span>Datasets</span></a>
                            <ul class="dropdown-menu" style="display: none;">
                                <li class="nav-item"><a href="{{ route('opddatasets.index') }}"
                                        class="nav-link">Datasets Saya</a></li>
                                <li class="nav-item"><a href="{{ route('opdbps.index') }}" class="nav-link">Data
                                        Dasar</a></li>
                                <li class="nav-item dropdown">
                                    <a href="#"
                                        class="nav-link has-dropdown @if ($c_permohonan_masuk != 0) beep @endif">Permohonan
                                        Data</a>
                                    <ul class="dropdown-menu" style="display: none;">
                                        <li class="nav-item"><a href="{{ route('opdpermohonan-data.masuk') }}"
                                                class="nav-link">Permohonan Masuk
                                                @if ($c_permohonan_masuk != 0)
                                                    <span class="badge badge-danger">{{ $c_permohonan_masuk }}</span>
                                                @endif
                                            </a>
                                        </li>
                                        <li class="nav-item"><a href="{{ route('opdpermohonan-data.index') }}"
                                                class="nav-link">Permohonan Keluar</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('opddatasetsshare.index') }}"
                                        class="nav-link @if ($c_datasets_berbagi != 0) beep @endif">
                                        Datasets Berbagi
                                    </a>
                                </li>
                                <style>
                                    .nav-link.beep {
                                        position: relative;
                                    }

                                    .nav-link.beep::after {
                                        content: '';
                                        position: absolute;
                                        top: 40%;
                                        /* Adjust spacing as needed */
                                        width: 8px;
                                        /* Size of the indicator */
                                        height: 8px;
                                        right: 8%;
                                    }
                                </style>
                            </ul>
                        </li>
                        <li
                            class="nav-item @if (Route::is('opd-artikel.index')) active @elseif(Route::is('opd-infografis.index')) active @elseif(Route::is('opd-publikasi.index')) active @endif dropdown">
                            <a href="#" data-toggle="dropdown" class="nav-link has-dropdown"><i
                                    class="fas fa-newspaper"></i><span>Publikasi dan Informasi</span></a>
                            <ul class="dropdown-menu" style="display: none;">
                                <li class="nav-item"><a href="{{ route('opd-artikel.index') }}"
                                        class="nav-link">Artikel</a></li>
                                <li class="nav-item"><a href="{{ route('opd-infografis.index') }}"
                                        class="nav-link">Infografis</a></li>
                                <li class="nav-item"><a href="{{ route('opd-publikasi.index') }}"
                                        class="nav-link">Produk Statistik</a></li>
                            </ul>
                        </li>
                        <li class="nav-item @if (Route::is('opdgraph.index')) active @endif">
                            <a href="{{ route('opdgraph.index') }}" class="nav-link"><i
                                    class="fas fa-chart-area"></i><span>Grafik Kinerja</span></a>
                        </li>
                    </ul>
                </div>
            </nav>

            @yield('main')
            <!-- Main Content -->

            <footer class="main-footer">
                <div class="footer-left">
                    Copyright &copy; 2024 <div class="bullet"></div> Made By <a
                        href="https://instagram.com/muhammad_rihaz">Muhamad
                        Rihaz</a>
                </div>
                <div class="footer-right">
                </div>
            </footer>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/gh/AmagiTech/JSLoader/amagiloader.js"></script>
    <script>
        AmagiLoader.show();
        setTimeout(() => {
            AmagiLoader.hide();
        }, 1000);
    </script>

    <!-- General JS Scripts -->
    <script src="{{ asset('assets-admin/modules/jquery.min.js') }}"></script>
    <script src="{{ asset('assets-admin/modules/popper.js') }}"></script>
    <script src="{{ asset('assets-admin/modules/tooltip.js') }}"></script>
    <script src="{{ asset('assets-admin/modules/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets-admin/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('assets-admin/modules/moment.min.js') }}"></script>
    <script src="{{ asset('assets-admin/js/stisla.js') }}"></script>

    <!-- JS Libraies -->
    <script src="{{ asset('assets-admin/modules/simple-weather/jquery.simpleWeather.min.js') }}"></script>
    <script src="{{ asset('assets-admin/modules/chart.min.js') }}"></script>
    <script src="{{ asset('assets-admin/modules/jqvmap/dist/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('assets-admin/modules/jqvmap/dist/maps/jquery.vmap.world.js') }}"></script>
    <script src="{{ asset('assets-admin/modules/summernote/summernote-bs4.js') }}"></script>
    <script src="{{ asset('assets-admin/modules/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>
    <script src="{{ asset('assets-admin/modules/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets-admin/modules/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets-admin/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}">
    </script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('assets-admin/js/page/modules-datatables.js') }}"></script>
    <script src="{{ asset('assets-admin/js/page/forms-advanced-forms.js') }}"></script>
    {{-- <script src="{{ asset('assets-admin/js/page/index-0.js') }}"></script> --}}

    <script>
        var statistics_chart = document.getElementById("myChart").getContext('2d');
        var myChart = new Chart(statistics_chart, {
            type: 'line',
            data: {
                labels: ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Juma'at", "Sabtu"],
                datasets: [{
                    label: 'Datasets',
                    data: [{{ $graph }}],
                    borderWidth: 5,
                    borderColor: '#6777ef',
                    backgroundColor: 'transparent',
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#6777ef',
                    pointRadius: 4
                }]
            },
            options: {
                legend: {
                    display: false
                },
                scales: {
                    yAxes: [{
                        gridLines: {
                            display: false,
                            drawBorder: false,
                        },
                        ticks: {
                            stepSize: 10,
                        }
                    }],
                    xAxes: [{
                        gridLines: {
                            color: '#fbfbfb',
                            lineWidth: 2
                        }
                    }]
                },
            }
        });
    </script>
    <script src="{{ asset('assets-admin/modules/codemirror/lib/codemirror.js') }}"></script>
    <script src="{{ asset('assets-admin/modules/codemirror/mode/javascript/javascript.js') }}"></script>
    <script src="{{ asset('assets-admin/modules/jquery-selectric/jquery.selectric.min.js') }}"></script>


    <!-- Template JS File -->
    <script src="{{ asset('assets-admin/js/scripts.js') }}"></script>
    <script src="{{ asset('assets-admin/js/custom.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.js"></script>

    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
        var Tawk_API = Tawk_API || {},
            Tawk_LoadStart = new Date();
        (function() {
            var s1 = document.createElement("script"),
                s0 = document.getElementsByTagName("script")[0];
            s1.async = true;
            s1.src = 'https://embed.tawk.to/665c45fa981b6c56477762a4/1hvc72n80';
            s1.charset = 'UTF-8';
            s1.setAttribute('crossorigin', '*');
            s0.parentNode.insertBefore(s1, s0);
        })();
    </script>
    <!--End of Tawk.to Script-->

    <div id="ascrail2000" class="nicescroll-rails nicescroll-rails-vr"
        style="width: 8px; z-index: 892; cursor: default; position: fixed; top: 70px; left: 2552px; height: 70px; touch-action: none; display: block; opacity: 0;">
        <div class="nicescroll-cursors"
            style="position: relative; top: 0px; float: right; width: 6px; height: 66px; background-color: rgb(66, 66, 66); border: 1px solid rgb(255, 255, 255); background-clip: padding-box; border-radius: 5px; touch-action: none;">
        </div>
    </div>
    <div id="ascrail2000-hr" class="nicescroll-rails nicescroll-rails-hr"
        style="height: 8px; z-index: 892; top: 132px; left: 0px; position: fixed; cursor: default; display: none; width: 2552px; opacity: 0;">
        <div class="nicescroll-cursors"
            style="position: absolute; top: 0px; height: 6px; width: 2560px; background-color: rgb(66, 66, 66); border: 1px solid rgb(255, 255, 255); background-clip: padding-box; border-radius: 5px; left: 0px;">
        </div>
    </div>
</body>

</html>
@include('sweetalert::alert')
