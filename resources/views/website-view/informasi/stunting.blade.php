@extends('website-view.layout.layout')
@section('title', 'Informasi Data Stunting')
@section('main')
    <main id="main">
        <!-- ======= Breadcrumbs Section ======= -->
        <section class="breadcrumbs">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center">
                    <h2>Publikasi & Informasi</h2>
                    <ol>
                        <li><a href="/">Home</a></li>
                        <li>Informasi</li>
                        <li>Stunting</li>
                    </ol>
                </div>

            </div>
        </section><!-- End Breadcrumbs Section -->
        <section class="inner-page">
            <div class="container">
                <div class="section-title" data-aos="fade-up">
                    <h2>Informasi</h2>
                    <p>Data Stunting Provinsi Jambi</p>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card" data-aos="fade-down">
                            <div class="card-body">
                                <div class="container">
                                    <div class="row">
                                        <style>
                                            .callout {
                                                padding: 20px;
                                                margin: 20px 0;
                                                border: 1px solid #eee;
                                                border-left-width: 5px;
                                                border-radius: 3px;
                                            }

                                            .callout h4 {
                                                margin-top: 0;
                                                margin-bottom: 5px;
                                            }

                                            .callout p:last-child {
                                                margin-bottom: 0;
                                            }

                                            .callout code {
                                                border-radius: 3px;
                                            }

                                            .callout+.bs-callout {
                                                margin-top: -5px;
                                            }

                                            .callout-default {
                                                border-left-color: #777;
                                            }

                                            .callout-default h4 {
                                                color: #777;
                                            }

                                            .callout-primary {
                                                border-left-color: #428bca;
                                            }

                                            .callout-primary h4 {
                                                color: #428bca;
                                            }

                                            .callout-success {
                                                border-left-color: #5cb85c;
                                            }

                                            .callout-success h4 {
                                                color: #5cb85c;
                                            }

                                            .callout-danger {
                                                border-left-color: #d9534f;
                                            }

                                            .callout-danger h4 {
                                                color: #d9534f;
                                            }

                                            .callout-warning {
                                                border-left-color: #f0ad4e;
                                            }

                                            .callout-warning h4 {
                                                color: #f0ad4e;
                                            }

                                            .callout-info {
                                                border-left-color: #5bc0de;
                                            }

                                            .callout-info h4 {
                                                color: #5bc0de;
                                            }

                                            .callout-bdc {
                                                border-left-color: #29527a;
                                            }

                                            .callout-bdc h4 {
                                                color: #29527a;
                                            }
                                        </style>
                                        <div class="col-md-12">
                                            <div class="callout callout-primary">
                                                <h4>Stunting dan Penyebabnya</h4>
                                                <p style="text-align: justify;">Masalah gizi pada balita merupakan masalah
                                                    Kesehatan Masyarakat yang masih tergolong tinggi di Indonesia, baik yang
                                                    bersifat akut maupun kronis. <strong><em>Stunting</em></strong> atau
                                                    anak pendek berdasarkan umur merupakan <u>salah satu</u> indikator
                                                    kondisi gagal tumbuh pada anak berusia dibawah lima tahun (balita)
                                                    akibat kekurangan asupan gizi kronis dan infeksi berulang terutama pada
                                                    <strong>periode 1.000 Hari Pertama Kehidupan (HPK), yaitu dari janin
                                                        hingga anak berusia 23 bulan</strong>.
                                                    Karenanya periode 1.000 HPK ini disebut pula sebagai <strong>periode
                                                        Emas</strong> untuk melakukan pencegahan atau koreksi masalah
                                                    stunting dengan berbagai intervensi gizi spesifik dan sensitif.
                                                    <strong>Intervensi gizi spesifik</strong> terdiri dari berbagai program
                                                    yang bertujuan untuk <strong>menanggulangi penyebab langsung</strong>
                                                    masalah stunting, sementara <strong>intervensi gizi sensitif</strong>
                                                    merupakan kelompok program yang bertujuan untuk <strong>menanggulangi
                                                        berbagai penyebab tak langsung</strong> dari stunting.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <nav>
                                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                            <button class="nav-link active fw-bold" id="nav-home-tab" data-bs-toggle="tab"
                                                data-bs-target="#nav-home" type="button" role="tab"
                                                aria-controls="nav-home" aria-selected="true">Masalah Gizi Pada
                                                Balita</button>
                                            <a class="nav-link fw-bold scrollto" href="#penyebab">Penyebab Langsung
                                                Stunting</a>
                                            <a class="nav-link fw-bold scrollto" href="#cakupan">Cakupan Intervensi</a>
                                        </div>
                                    </nav>
                                    <div class="tab-content" id="nav-tabContent">
                                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel"
                                            aria-labelledby="nav-home-tab" tabindex="0">
                                            <div class="section-title text-center mt-3" data-aos="fade-up">
                                                <p>Masalah Gizi Pada Balita</p>
                                                <h3>Tingkat Kabupaten/Kota</h3>
                                            </div>
                                            <div class='tableauPlaceholder' id='viz1700294294417'
                                                style='position: relative'><noscript><a
                                                        href='https:&#47;&#47;dashboard.stunting.go.id&#47;'><img
                                                            alt='Dashboard 1 '
                                                            src='https:&#47;&#47;public.tableau.com&#47;static&#47;images&#47;CJ&#47;CJ2ZBY78W&#47;1_rss.png'
                                                            style='border: none' /></a></noscript><object class='tableauViz'
                                                    style='display:none;'>
                                                    <param name='host_url' value='https%3A%2F%2Fpublic.tableau.com%2F' />
                                                    <param name='embed_code_version' value='3' />
                                                    <param name='path' value='shared&#47;CJ2ZBY78W' />
                                                    <param name='toolbar' value='yes' />
                                                    <param name='static_image'
                                                        value='https:&#47;&#47;public.tableau.com&#47;static&#47;images&#47;CJ&#47;CJ2ZBY78W&#47;1.png' />
                                                    <param name='animate_transition' value='yes' />
                                                    <param name='display_static_image' value='yes' />
                                                    <param name='display_spinner' value='yes' />
                                                    <param name='display_overlay' value='yes' />
                                                    <param name='display_count' value='yes' />
                                                    <param name='tabs' value='no' />
                                                    <param name='language' value='en-US' />
                                                </object></div>
                                            <script type='text/javascript'>
                                                var divElement = document.getElementById('viz1700294294417');
                                                var vizElement = divElement.getElementsByTagName('object')[0];
                                                if (divElement.offsetWidth > 800) {
                                                    vizElement.style.width = '100%';
                                                    vizElement.style.height = '800px';
                                                } else if (divElement.offsetWidth > 500) {
                                                    vizElement.style.width = '100%';
                                                    vizElement.style.height = '800px';
                                                } else {
                                                    vizElement.style.width = '100%';
                                                    vizElement.style.height = '727px';
                                                }
                                                var scriptElement = document.createElement('script');
                                                scriptElement.src = 'https://public.tableau.com/javascripts/api/viz_v1.js';
                                                vizElement.parentNode.insertBefore(scriptElement, vizElement);
                                            </script>
                                            <div class='tableauPlaceholder' id='viz1700294446213'
                                                style='position: relative'><noscript><a
                                                        href='https:&#47;&#47;dashboard.stunting.go.id&#47;'><img
                                                            alt='Dashboard 1 '
                                                            src='https:&#47;&#47;public.tableau.com&#47;static&#47;images&#47;FN&#47;FNHPT6T9C&#47;1_rss.png'
                                                            style='border: none' /></a></noscript><object class='tableauViz'
                                                    style='display:none;'>
                                                    <param name='host_url' value='https%3A%2F%2Fpublic.tableau.com%2F' />
                                                    <param name='embed_code_version' value='3' />
                                                    <param name='path' value='shared&#47;FNHPT6T9C' />
                                                    <param name='toolbar' value='yes' />
                                                    <param name='static_image'
                                                        value='https:&#47;&#47;public.tableau.com&#47;static&#47;images&#47;FN&#47;FNHPT6T9C&#47;1.png' />
                                                    <param name='animate_transition' value='yes' />
                                                    <param name='display_static_image' value='yes' />
                                                    <param name='display_spinner' value='yes' />
                                                    <param name='display_overlay' value='yes' />
                                                    <param name='display_count' value='yes' />
                                                    <param name='tabs' value='no' />
                                                    <param name='language' value='en-US' />
                                                </object></div>
                                            <script type='text/javascript'>
                                                var divElement = document.getElementById('viz1700294446213');
                                                var vizElement = divElement.getElementsByTagName('object')[0];
                                                if (divElement.offsetWidth > 800) {
                                                    vizElement.style.width = '100%';
                                                    vizElement.style.height = '800px';
                                                } else if (divElement.offsetWidth > 500) {
                                                    vizElement.style.width = '100%';
                                                    vizElement.style.height = '800px';
                                                } else {
                                                    vizElement.style.width = '100%';
                                                    vizElement.style.height = '727px';
                                                }
                                                var scriptElement = document.createElement('script');
                                                scriptElement.src = 'https://public.tableau.com/javascripts/api/viz_v1.js';
                                                vizElement.parentNode.insertBefore(scriptElement, vizElement);
                                            </script>
                                            <div class='tableauPlaceholder' id='viz1700294524248'
                                                style='position: relative'><noscript><a
                                                        href='https:&#47;&#47;dashboard.stunting.go.id&#47;'><img
                                                            alt='Dashboard 1 '
                                                            src='https:&#47;&#47;public.tableau.com&#47;static&#47;images&#47;63&#47;63F7N9STS&#47;1_rss.png'
                                                            style='border: none' /></a></noscript><object
                                                    class='tableauViz' style='display:none;'>
                                                    <param name='host_url' value='https%3A%2F%2Fpublic.tableau.com%2F' />
                                                    <param name='embed_code_version' value='3' />
                                                    <param name='path' value='shared&#47;63F7N9STS' />
                                                    <param name='toolbar' value='yes' />
                                                    <param name='static_image'
                                                        value='https:&#47;&#47;public.tableau.com&#47;static&#47;images&#47;63&#47;63F7N9STS&#47;1.png' />
                                                    <param name='animate_transition' value='yes' />
                                                    <param name='display_static_image' value='yes' />
                                                    <param name='display_spinner' value='yes' />
                                                    <param name='display_overlay' value='yes' />
                                                    <param name='display_count' value='yes' />
                                                    <param name='language' value='en-US' />
                                                </object></div>
                                            <script type='text/javascript'>
                                                var divElement = document.getElementById('viz1700294524248');
                                                var vizElement = divElement.getElementsByTagName('object')[0];
                                                if (divElement.offsetWidth > 800) {
                                                    vizElement.style.width = '100%';
                                                    vizElement.style.height = '800px';
                                                } else if (divElement.offsetWidth > 500) {
                                                    vizElement.style.width = '100%';
                                                    vizElement.style.height = '800px';
                                                } else {
                                                    vizElement.style.width = '100%';
                                                    vizElement.style.height = '727px';
                                                }
                                                var scriptElement = document.createElement('script');
                                                scriptElement.src = 'https://public.tableau.com/javascripts/api/viz_v1.js';
                                                vizElement.parentNode.insertBefore(scriptElement, vizElement);
                                            </script>
                                            <div class='tableauPlaceholder' id='viz1700295018178'
                                                style='position: relative'><noscript><a
                                                        href='https:&#47;&#47;dashboard.stunting.go.id&#47;'><img
                                                            alt='Dashboard 2 '
                                                            src='https:&#47;&#47;public.tableau.com&#47;static&#47;images&#47;YN&#47;YN3JC6PTM&#47;1_rss.png'
                                                            style='border: none' /></a></noscript><object
                                                    class='tableauViz' style='display:none;'>
                                                    <param name='host_url' value='https%3A%2F%2Fpublic.tableau.com%2F' />
                                                    <param name='embed_code_version' value='3' />
                                                    <param name='path' value='shared&#47;YN3JC6PTM' />
                                                    <param name='toolbar' value='yes' />
                                                    <param name='static_image'
                                                        value='https:&#47;&#47;public.tableau.com&#47;static&#47;images&#47;YN&#47;YN3JC6PTM&#47;1.png' />
                                                    <param name='animate_transition' value='yes' />
                                                    <param name='display_static_image' value='yes' />
                                                    <param name='display_spinner' value='yes' />
                                                    <param name='display_overlay' value='yes' />
                                                    <param name='display_count' value='yes' />
                                                    <param name='tabs' value='no' />
                                                    <param name='language' value='en-US' />
                                                </object></div>
                                            <script type='text/javascript'>
                                                var divElement = document.getElementById('viz1700295018178');
                                                var vizElement = divElement.getElementsByTagName('object')[0];
                                                if (divElement.offsetWidth > 800) {
                                                    vizElement.style.width = '100%';
                                                    vizElement.style.height = '800px';
                                                } else if (divElement.offsetWidth > 500) {
                                                    vizElement.style.width = '100%';
                                                    vizElement.style.height = '800px';
                                                } else {
                                                    vizElement.style.width = '100%';
                                                    vizElement.style.height = '727px';
                                                }
                                                var scriptElement = document.createElement('script');
                                                scriptElement.src = 'https://public.tableau.com/javascripts/api/viz_v1.js';
                                                vizElement.parentNode.insertBefore(scriptElement, vizElement);
                                            </script>
                                            <div class='tableauPlaceholder' id='viz1700295273812'
                                                style='position: relative'><noscript><a
                                                        href='https:&#47;&#47;dashboard.stunting.go.id&#47;'><img
                                                            alt='Dashboard 2 (2) '
                                                            src='https:&#47;&#47;public.tableau.com&#47;static&#47;images&#47;MG&#47;MGKDGRPTT&#47;1_rss.png'
                                                            style='border: none' /></a></noscript><object
                                                    class='tableauViz' style='display:none;'>
                                                    <param name='host_url' value='https%3A%2F%2Fpublic.tableau.com%2F' />
                                                    <param name='embed_code_version' value='3' />
                                                    <param name='path' value='shared&#47;MGKDGRPTT' />
                                                    <param name='toolbar' value='yes' />
                                                    <param name='static_image'
                                                        value='https:&#47;&#47;public.tableau.com&#47;static&#47;images&#47;MG&#47;MGKDGRPTT&#47;1.png' />
                                                    <param name='animate_transition' value='yes' />
                                                    <param name='display_static_image' value='yes' />
                                                    <param name='display_spinner' value='yes' />
                                                    <param name='display_overlay' value='yes' />
                                                    <param name='display_count' value='yes' />
                                                    <param name='language' value='en-US' />
                                                </object></div>
                                            <script type='text/javascript'>
                                                var divElement = document.getElementById('viz1700295273812');
                                                var vizElement = divElement.getElementsByTagName('object')[0];
                                                if (divElement.offsetWidth > 800) {
                                                    vizElement.style.width = '100%';
                                                    vizElement.style.height = '795px';
                                                } else if (divElement.offsetWidth > 500) {
                                                    vizElement.style.width = '100%';
                                                    vizElement.style.height = '795px';
                                                } else {
                                                    vizElement.style.width = '100%';
                                                    vizElement.style.height = '727px';
                                                }
                                                var scriptElement = document.createElement('script');
                                                scriptElement.src = 'https://public.tableau.com/javascripts/api/viz_v1.js';
                                                vizElement.parentNode.insertBefore(scriptElement, vizElement);
                                            </script>
                                            <div class='tableauPlaceholder' id='viz1700295358733'
                                                style='position: relative'><noscript><a
                                                        href='https:&#47;&#47;dashboard.stunting.go.id&#47;'><img
                                                            alt='Dashboard 3 '
                                                            src='https:&#47;&#47;public.tableau.com&#47;static&#47;images&#47;D7&#47;D7BK4X2F5&#47;1_rss.png'
                                                            style='border: none' /></a></noscript><object
                                                    class='tableauViz' style='display:none;'>
                                                    <param name='host_url' value='https%3A%2F%2Fpublic.tableau.com%2F' />
                                                    <param name='embed_code_version' value='3' />
                                                    <param name='path' value='shared&#47;D7BK4X2F5' />
                                                    <param name='toolbar' value='yes' />
                                                    <param name='static_image'
                                                        value='https:&#47;&#47;public.tableau.com&#47;static&#47;images&#47;D7&#47;D7BK4X2F5&#47;1.png' />
                                                    <param name='animate_transition' value='yes' />
                                                    <param name='display_static_image' value='yes' />
                                                    <param name='display_spinner' value='yes' />
                                                    <param name='display_overlay' value='yes' />
                                                    <param name='display_count' value='yes' />
                                                    <param name='tabs' value='no' />
                                                    <param name='language' value='en-US' />
                                                </object></div>
                                            <script type='text/javascript'>
                                                var divElement = document.getElementById('viz1700295358733');
                                                var vizElement = divElement.getElementsByTagName('object')[0];
                                                if (divElement.offsetWidth > 800) {
                                                    vizElement.style.width = '100%';
                                                    vizElement.style.height = '795px';
                                                } else if (divElement.offsetWidth > 500) {
                                                    vizElement.style.width = '100%';
                                                    vizElement.style.height = '795px';
                                                } else {
                                                    vizElement.style.width = '100%';
                                                    vizElement.style.height = '727px';
                                                }
                                                var scriptElement = document.createElement('script');
                                                scriptElement.src = 'https://public.tableau.com/javascripts/api/viz_v1.js';
                                                vizElement.parentNode.insertBefore(scriptElement, vizElement);
                                            </script>
                                            <div class="section-title text-center mt-5" id="penyebab"
                                                data-aos="fade-up">
                                                <p>Penyebab Langsung Stunting</p>
                                                <h3>Tingkat Kabupaten/Kota</h3>
                                            </div>
                                            <div class='tableauPlaceholder' id='viz1700298083941'
                                                style='position: relative'><noscript><a
                                                        href='https:&#47;&#47;dashboard.stunting.go.id&#47;'><img
                                                            alt='DB KAB DIRECT '
                                                            src='https:&#47;&#47;public.tableau.com&#47;static&#47;images&#47;YQ&#47;YQ7CHD2XW&#47;1_rss.png'
                                                            style='border: none' /></a></noscript><object
                                                    class='tableauViz' style='display:none;'>
                                                    <param name='host_url' value='https%3A%2F%2Fpublic.tableau.com%2F' />
                                                    <param name='embed_code_version' value='3' />
                                                    <param name='path' value='shared&#47;YQ7CHD2XW' />
                                                    <param name='toolbar' value='yes' />
                                                    <param name='static_image'
                                                        value='https:&#47;&#47;public.tableau.com&#47;static&#47;images&#47;YQ&#47;YQ7CHD2XW&#47;1.png' />
                                                    <param name='animate_transition' value='yes' />
                                                    <param name='display_static_image' value='yes' />
                                                    <param name='display_spinner' value='yes' />
                                                    <param name='display_overlay' value='yes' />
                                                    <param name='display_count' value='yes' />
                                                    <param name='tabs' value='no' />
                                                    <param name='language' value='en-US' />
                                                    <param name='filter' value='publish=yes' />
                                                </object></div>
                                            <script type='text/javascript'>
                                                var divElement = document.getElementById('viz1700298083941');
                                                var vizElement = divElement.getElementsByTagName('object')[0];
                                                vizElement.style.width = '100%';
                                                vizElement.style.height = (divElement.offsetWidth * 0.75) + 'px';
                                                var scriptElement = document.createElement('script');
                                                scriptElement.src = 'https://public.tableau.com/javascripts/api/viz_v1.js';
                                                vizElement.parentNode.insertBefore(scriptElement, vizElement);
                                            </script>
                                            <div class='tableauPlaceholder mt-3' id='viz1700298164951'
                                                style='position: relative'><noscript><a
                                                        href='https:&#47;&#47;dashboard.stunting.go.id&#47;'><img
                                                            alt='DB KAB DIRECT BAR '
                                                            src='https:&#47;&#47;public.tableau.com&#47;static&#47;images&#47;NQ&#47;NQWFGCNSX&#47;1_rss.png'
                                                            style='border: none' /></a></noscript><object
                                                    class='tableauViz' style='display:none;'>
                                                    <param name='host_url' value='https%3A%2F%2Fpublic.tableau.com%2F' />
                                                    <param name='embed_code_version' value='3' />
                                                    <param name='path' value='shared&#47;NQWFGCNSX' />
                                                    <param name='toolbar' value='yes' />
                                                    <param name='static_image'
                                                        value='https:&#47;&#47;public.tableau.com&#47;static&#47;images&#47;NQ&#47;NQWFGCNSX&#47;1.png' />
                                                    <param name='animate_transition' value='yes' />
                                                    <param name='display_static_image' value='yes' />
                                                    <param name='display_spinner' value='yes' />
                                                    <param name='display_overlay' value='yes' />
                                                    <param name='display_count' value='yes' />
                                                    <param name='tabs' value='no' />
                                                    <param name='language' value='en-US' />
                                                    <param name='filter' value='publish=yes' />
                                                </object></div>
                                            <script type='text/javascript'>
                                                var divElement = document.getElementById('viz1700298164951');
                                                var vizElement = divElement.getElementsByTagName('object')[0];
                                                vizElement.style.width = '100%';
                                                vizElement.style.height = (divElement.offsetWidth * 0.75) + 'px';
                                                var scriptElement = document.createElement('script');
                                                scriptElement.src = 'https://public.tableau.com/javascripts/api/viz_v1.js';
                                                vizElement.parentNode.insertBefore(scriptElement, vizElement);
                                            </script>
                                            <div class="section-title text-center mt-5" id="cakupan"
                                                data-aos="fade-up">
                                                <p>Cakupan Intervensi</p>
                                                <h3>Tingkat Kabupaten/Kota</h3>
                                            </div>
                                            <div class='tableauPlaceholder mt-3' id='viz1700298351582'
                                                style='position: relative'><noscript><a
                                                        href='https:&#47;&#47;dashboard.stunting.go.id&#47;'><img
                                                            alt='DB KAB '
                                                            src='https:&#47;&#47;public.tableau.com&#47;static&#47;images&#47;M9&#47;M9CF82QXY&#47;1_rss.png'
                                                            style='border: none' /></a></noscript><object
                                                    class='tableauViz' style='display:none;'>
                                                    <param name='host_url' value='https%3A%2F%2Fpublic.tableau.com%2F' />
                                                    <param name='embed_code_version' value='3' />
                                                    <param name='path' value='shared&#47;M9CF82QXY' />
                                                    <param name='toolbar' value='yes' />
                                                    <param name='static_image'
                                                        value='https:&#47;&#47;public.tableau.com&#47;static&#47;images&#47;M9&#47;M9CF82QXY&#47;1.png' />
                                                    <param name='animate_transition' value='yes' />
                                                    <param name='display_static_image' value='yes' />
                                                    <param name='display_spinner' value='yes' />
                                                    <param name='display_overlay' value='yes' />
                                                    <param name='display_count' value='yes' />
                                                    <param name='tabs' value='no' />
                                                    <param name='language' value='en-US' />
                                                    <param name='filter' value='publish=yes' />
                                                </object></div>
                                            <script type='text/javascript'>
                                                var divElement = document.getElementById('viz1700298351582');
                                                var vizElement = divElement.getElementsByTagName('object')[0];
                                                vizElement.style.width = '100%';
                                                vizElement.style.height = (divElement.offsetWidth * 0.75) + 'px';
                                                var scriptElement = document.createElement('script');
                                                scriptElement.src = 'https://public.tableau.com/javascripts/api/viz_v1.js';
                                                vizElement.parentNode.insertBefore(scriptElement, vizElement);
                                            </script>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main><!-- End #main -->
@endsection
