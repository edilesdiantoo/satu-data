@extends('opd/layout/layout')
@section('title', 'Dashboard')
@section('main')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Dashboard Satu Data Provinsi Jambi</h1>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-database"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Datasets</h4>
                            </div>
                            <div class="card-body">
                                {{ $datasets }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-warning">
                            <i class="fas fa-database"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Artikel</h4>
                            </div>
                            <div class="card-body">
                                {{ $artikel }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-success">
                            <i class="fas fa-database"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Infografis</h4>
                            </div>
                            <div class="card-body">
                                {{ $infografis }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-danger">
                            <i class="fas fa-database"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Produk Statistik</h4>
                            </div>
                            <div class="card-body">
                                {{ $produk_statistik }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <h2 class="section-title">Kategori Data</h2>
            <section class="service-categories text-center">
                <div class="row">
                    @foreach ($sektor as $item)
                        <div class="col-md-2">
                            <a href="{{ route('opd_kategoridata', $item->id) }}">
                                <div class="card service-card card-inverse">
                                    <div class="card-block m-3">
                                        <span class="{{ $item->icon }}"></span>
                                        <h5 class="card-title">{{ $item->nama_sektor }}</h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
                <!--End Row-->
            </section>
            <h2 class="section-title">Highlight Trending</h2>
            <div class="row">
                @foreach ($berita as $item)
                    <div class="col-md-4 col-lg-4">
                        <div class="article article-style-c">
                            <div class="article-header">
                                <div class="article-image"
                                    data-background="{{ asset('assets/berita-thumbnail/' . $item->gambar) }}"
                                    style="background-image: url(&quot;{{ asset('assets/berita-thumbnail/' . $item->gambar) }}&quot;);">
                                </div>
                                <div class="article-badge">
                                    <div class="article-badge-item bg-danger">
                                        <i class="fas fa-fire"></i>
                                        Trending
                                    </div>
                                </div>
                            </div>
                            <div class="article-details">
                                <div class="article-category">
                                    <a href="#">Berita</a>
                                    <div class="bullet"></div>
                                    <a href="#">{{ $item->created_at->diffForHumans() }}</a>
                                </div>
                                <div class="article-title">
                                    <h2>
                                        <a target="_blank"
                                            href="{{ route('web-berita.show', ['id' => $item->id, 'slug' => $item->slug]) }}">{{ Str::words($item->judul, 15, ' ...') }}</a>
                                    </h2>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="row">
                <div class="col-lg-8 col-md-12 col-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Statistics Datasets</h4>
                            <div class="card-header-action">
                                <div class="btn-group">
                                    <a href="#" class="btn btn-primary">Week</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <canvas id="myChart" height="182"></canvas>
                            <div class="statistic-details mt-sm-4">
                                <div class="statistic-details-item">
                                    <div class="detail-value">{{ $today }}</div>
                                    <div class="detail-name">Today's Datasets</div>
                                </div>
                                <div class="statistic-details-item">
                                    <div class="detail-value">{{ $week }}</div>
                                    <div class="detail-name">This Week's Datasets</div>
                                </div>
                                <div class="statistic-details-item">
                                    <div class="detail-value">{{ $month }}</div>
                                    <div class="detail-name">This Month's Datasets</div>
                                </div>
                                <div class="statistic-details-item">
                                    <div class="detail-value">{{ $jumlah_datasets }}</div>
                                    <div class="detail-name">Total Datasets</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 col-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Recent Activities</h4>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled list-unstyled-border">
                                @foreach ($aktivitas as $item)
                                    @foreach ($user as $item_user)
                                        @if ($item->id_user == $item_user->id)
                                            <li class="media">
                                                <img class="mr-3 rounded-circle" width="50"
                                                    src="{{ asset('assets/photo-profile/' . $item_user->photo) }}"
                                                    alt="avatar">
                                                <div class="media-body">
                                                    <div class="float-right">{{ $item->created_at->diffForHumans() }}
                                                    </div>
                                                    <div class="media-title">{{ $item_user->name }}</div>
                                                    <span class="text-small text-muted">{{ $item->pesan }}</span>
                                                </div>
                                            </li>
                                        @endif
                                    @endforeach
                                @endforeach
                            </ul>
                            <div class="text-center pt-1 pb-1">
                                <a href="{{ route('opdaktivitas.index') }}" class="btn btn-primary btn-lg btn-round">
                                    View All
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </div>
    <style>
        /*DEMO ONLY*/

        .service-categories {
            padding-top: 1em;
            padding-bottom: 1em;
            background-size: cover;
        }


        /*DEMO ONLY*/

        .service-categories .card {
            transition: all 0.3s;
        }

        .service-categories .card-title {
            padding-top: 0.5em;
        }

        .service-categories a:hover {
            text-decoration: none;
        }

        .service-card {
            border: 0 gray;
        }

        .service-card:hover {
            box-shadow: 2px 4px 8px 0px rgba(46, 61, 73, 0.2)
        }

        .fa {
            color: #6777ef;
        }
    </style>
@endsection
