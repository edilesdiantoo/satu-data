@extends('website-view.layout.layout')
@section('title', $response['var'][0]['label'])
@section('main')
    <style>
        .hero.hero-bg-image {
            background-position: center;
            background-size: cover;
        }

        .hero {
            border-radius: 3px;
            padding: 55px;
            display: flex;
            justify-content: center;
            flex-direction: column;
            position: relative;
        }

        .hero .hero-inner {
            position: relative;
            z-index: 1;
        }

        .hero p {
            margin-bottom: 0;
            font-size: 16px;
            letter-spacing: 0.3px;
        }

        .lead {
            line-height: 34px;
        }

        .lead {
            font-size: 1.25rem;
            font-weight: 300;
        }
    </style>
    <main id="main">
        <!-- ======= Breadcrumbs Section ======= -->
        <section class="breadcrumbs">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center">
                    <h2>Statistik Dasar</h2>
                    <ol>
                        <li><a href="/">Home</a></li>
                        <li><a href="{{ route('web-datadasar.index') }}"> Statistik Dasar</a></li>
                        <li>Badan Pusat Statistik</li>
                    </ol>
                </div>

            </div>
        </section><!-- End Breadcrumbs Section -->
        <section class="inner-page">
            <div class="container">
                <div class="section-title" data-aos="fade-up">
                    <h2>Statistik Dasar</h2>
                </div>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 text-center">
                                    <div class="mt-4">
                                        <img src="{{ asset('assets/img/logo_bps.png') }}" class="img-thumbnail"
                                            alt="logo" style="max-width: 300px;">
                                        <br>
                                        <a href="#" class="text-uppercase fw-bolder text-dark">Badan Pusat
                                            Statistik</a>
                                    </div>
                                    <h6 class="card-subtitle mb-2 mt-3 text-body-secondary">
                                        <span style="margin-right: 20px;"><i class='bx bx-calendar'></i>
                                            {{ $bps->created_at->format('d M Y') }}</span>
                                        <span style="margin-right: 20px;"> <i class="bx bx-building"></i>
                                            {{ $bps->sub_kategori }} </span>
                                    </h6>
                                    <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-success dropdown-toggle"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                Unduh Datasets
                                            </button>
                                            <ul class="dropdown-menu">
                                                
                                                <li>
                                                    <a class="dropdown-item" 
                                                    href="{{ route('web-datadasar.download', ['id' => $id, 'tahun' => $tahun_data]) }}">Excell</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <h4 class="mt-3"><?php echo $response['var'][0]['label']; ?></h4>
                                    <p><?php echo $response['var'][0]['note']; ?></p>
                                </div>

                                <div class="col-md-12">
                                    <div class="card-body">
                                        <nav class="mt-3">
                                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                                <button class="nav-link fw-bolder active" id="nav-home-tab"
                                                    data-bs-toggle="tab" data-bs-target="#nav-home" type="button"
                                                    role="tab" aria-controls="nav-home"
                                                    aria-selected="true">Tabel</button>
                                            </div>
                                        </nav>
                                        <style>
                                            .hero.hero-bg-image {
                                                background-position: center;
                                                background-size: cover;
                                            }

                                            .hero {
                                                border-radius: 3px;
                                                padding: 55px;
                                                display: flex;
                                                justify-content: center;
                                                flex-direction: column;
                                                position: relative;
                                            }

                                            .hero .hero-inner {
                                                position: relative;
                                                z-index: 1;
                                            }

                                            .hero p {
                                                margin-bottom: 0;
                                                font-size: 16px;
                                                letter-spacing: 0.3px;
                                            }

                                            .lead {
                                                line-height: 34px;
                                            }

                                            .lead {
                                                font-size: 1.25rem;
                                                font-weight: 300;
                                            }

                                            .status-align-right {
                                                padding-left: 50px;
                                            }

                                            html .njs-sticky-side.image_button_cover.placement-right {
                                                right: 0;
                                            }

                                            html .njs-sticky-side.image_button_cover {
                                                position: fixed;
                                                top: 50%;
                                                box-shadow: none;
                                                z-index: 99999;
                                                transition: transform .3s cubic-bezier(0, 0, 0, 1);
                                                -webkit-transition: -webkit-transform .3s cubic-bezier(0, 0, 0, 1);
                                            }

                                            html .njs-sticky-side.image_button_cover.placement-right.now-show a {
                                                transform: translate3d(4px, 0, 0) rotate(-90deg);
                                                -webkit-transform: translate3d(4px, 0, 0) rotate(-90deg);
                                            }

                                            html .njs-sticky-side.image_button_cover.placement-right a {
                                                border-radius: 3px 3px 0 0;
                                                transform: translate3d(200%, 0, 0) rotate(-90deg);
                                                -webkit-transform: translate3d(200%, 0, 0) rotate(-90deg);
                                                transform-origin: 100% 100%;
                                                -webkit-transform-origin: 100% 100%;
                                            }

                                            html .njs-sticky-side.image_button_cover a {
                                                padding: 6px 15px 12px;
                                                font-size: 18px;
                                                font-weight: 700;
                                                display: inline-block;
                                                position: relative;
                                                transition: transform .3s;
                                                -webkit-transition: -webkit-transform .3s;
                                                background-color: #FF7602;
                                                color: white;
                                                font-weight: 100;
                                                top: -106.5px;
                                                box-shadow: 10px 10px rgb(75, 78, 79);
                                                font-family: 'Arial';
                                            }

                                            html .njs-sticky-side.image_button_cover a:hover {
                                                background-color: white;
                                                color: black;
                                                border: 2px solid #acacac;
                                            }
                                        </style>

                                        <div class="tab-content" id="nav-tabContent">
                                            <div class="tab-pane fade show active" id="nav-home" role="tabpanel"
                                                aria-labelledby="nav-home-tab" tabindex="0">
                                                <div class="table-responsive mt-3">
                                                    <style>
                                                        thead {
                                                            background-color: #1a1d94;
                                                            color: white;
                                                        }
                                                    </style>
                                                    <div class="row container">
                                                        <div class="col-xl-2">
                                                            <form
                                                                action="{{ route('web-datadasar.show', ['id' => $id, 'slug' => $response['var'][0]['label']]) }}"
                                                                method="get">
                                                                <label for="">Data Series {{$tahun_data}}</label>
                                                                <input class="form-control mb-4" hidden name="tahun" value="{{$tahun_data}}"/>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <table class="table table-striped" id="table-1">
                                                        <?php
                                                        $idvariabel = $response['var'][0]['val'];
                                                        $jumlahbaris = count($response['vervar']);
                                                        $jumlahkarakteristik = count($response['turvar']);
                                                        $jumlahtahun = count($response['tahun']);
                                                        $jumlahturtahun = count($response['turtahun']);
                                                        
                                                        echo '<thead class="text-center">';
                                                        if ($jumlahturtahun == 1 && $jumlahkarakteristik == 1) {
                                                            echo "<tr><th rowspan = '3'>" . $response['labelvervar'] . '</th></tr>';
                                                            echo "<tr><th colspan='" . $jumlahtahun . "'>" . $response['var'][0]['label'] . '</th></tr>';
                                                            echo '<tr>';
                                                            for ($i = 0; $i < $jumlahtahun; $i++) {
                                                                echo '<th>' . $response['tahun'][$i]['label'] . '</th>';
                                                            }
                                                            echo '</tr>';
                                                        } elseif (($jumlahturtahun > 1) & ($jumlahkarakteristik == 1)) {
                                                            //Ada turunan tahun dan tidak ada karakteristik
                                                            echo "<tr><th rowspan='4'>" . $response['labelvervar'] . '</th></tr>';
                                                            echo "<tr><th colspan='" . $jumlahtahun * $jumlahturtahun . "'>" . $response['var'][0]['label'] . '</th></tr>';
                                                            echo '<tr>';
                                                            for ($i = 0; $i < $jumlahtahun; $i++) {
                                                                echo "<th colspan='" . $jumlahturtahun . "'>" . $response['tahun'][$i]['label'] . '</th>';
                                                            }
                                                            echo '</tr>';
                                                            echo '<tr>';
                                                            for ($i = 0; $i < $jumlahtahun; $i++) {
                                                                for ($j = 0; $j < $jumlahturtahun; $j++) {
                                                                    echo '<th>' . $response['turtahun'][$j]['label'] . '</th>';
                                                                }
                                                            }
                                                            echo '</tr>';
                                                        } elseif ($jumlahturtahun == 1 && $jumlahkarakteristik > 1) {
                                                            //Tidak turnan tahun dan ada karakteristik
                                                            echo "<tr><th rowspan='4'>" . $response['labelvervar'] . '</th></tr>';
                                                            echo "<tr><th colspan='" . $jumlahkarakteristik * $jumlahtahun . "'>" . $response['var'][0]['label'] . '</th></tr>';
                                                            echo '<tr>';
                                                            for ($i = 0; $i < $jumlahkarakteristik; $i++) {
                                                                echo "<th colspan='" . $jumlahtahun . "'>" . $response['turvar'][$i]['label'] . '</th>';
                                                            }
                                                            echo '</tr>';
                                                            echo '<tr>';
                                                            for ($i = 0; $i < $jumlahkarakteristik; $i++) {
                                                                for ($j = 0; $j < $jumlahtahun; $j++) {
                                                                    echo '<th>' . $response['tahun'][$j]['label'] . '</th>';
                                                                }
                                                            }
                                                            echo '</tr>';
                                                        } elseif ($jumlahturtahun > 1 && $jumlahkarakteristik > 1) {
                                                            //Ada turunan tahun dan ada karakteristik
                                                            echo "<tr><th rowspan='5'>" . $response['labelvervar'] . '</th></tr>';
                                                            echo "<tr><th colspan='" . $jumlahkarakteristik * $jumlahtahun * $jumlahturtahun . "'>" . $response['var'][0]['label'] . '</th></tr>';
                                                            echo '<tr>';
                                                            for ($i = 0; $i < $jumlahkarakteristik; $i++) {
                                                                echo "<th colspan ='" . $jumlahtahun * $jumlahturtahun . "'>" . $response['turvar'][$i]['label'] . '</th>';
                                                            }
                                                            echo '</tr>';
                                                            echo '<tr>';
                                                            for ($i = 0; $i < $jumlahkarakteristik; $i++) {
                                                                for ($j = 0; $j < $jumlahtahun; $j++) {
                                                                    echo "<th colspan='" . $jumlahturtahun . "''>" . $response['tahun'][$i]['label'] . '</th>';
                                                                }
                                                            }
                                                            echo '</tr>';
                                                            echo '<tr>';
                                                            for ($i = 0; $i < $jumlahkarakteristik; $i++) {
                                                                for ($j = 0; $j < $jumlahtahun; $j++) {
                                                                    for ($k = 0; $k < $jumlahturtahun; $k++) {
                                                                        echo '<th>' . $response['turtahun'][$k]['label'] . '</th>';
                                                                    }
                                                                }
                                                            }
                                                            echo '</tr>';
                                                        }
                                                        echo '</thead><tbody>';
                                                        for ($i = 0; $i < $jumlahbaris; $i++) {
                                                            echo '<tr>';
                                                            echo '<td>' . $response['vervar'][$i]['label'] . '</td>';
                                                            for ($j = 0; $j < $jumlahkarakteristik; $j++) {
                                                                for ($k = 0; $k < $jumlahtahun; $k++) {
                                                                    for ($l = 0; $l < $jumlahturtahun; $l++) {
                                                                        $id_data = $response['vervar'][$i]['val'] . $idvariabel . $response['turvar'][$j]['val'] . $response['tahun'][$k]['val'] . $response['turtahun'][$l]['val'];
                                                                        $data = isset($response['datacontent'][$id_data]) ? $response['datacontent'][$id_data] : '-';
                                                                        echo '<td>' . $data . '</td>';
                                                                    }
                                                                }
                                                            }
                                                            echo '</tr>';
                                                        }
                                                        echo '</tbody>';
                                                        ?>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script>
            function formatRibuan(number) {
                return new Intl.NumberFormat('id-ID').format(number);
            }

            // Example: Apply to each row in the table
            document.querySelectorAll('table tbody tr').forEach(row => {
                row.querySelectorAll('td').forEach(cell => {
                    const number = parseFloat(cell.innerText.replace(',', ''));
                    if (!isNaN(number)) {
                        cell.innerText = formatRibuan(number); // Format and replace the number
                    }
                });
            });
        </script>
        </section>

    </main><!-- End #main -->
@endsection
