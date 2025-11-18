@extends('super-admin/layout/layout')
@section('title', 'Dashboard')
@section('main')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Dashboard</h1>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="far fa-user"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Admin Operator</h4>
                            </div>
                            <div class="card-body">
                                {{ $operator }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-danger">
                            <i class="far fa-newspaper"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Akun OPD</h4>
                            </div>
                            <div class="card-body">
                                {{ $opd }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-warning">
                            <i class="far fa-file"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Dashboard</h4>
                            </div>
                            <div class="card-body">
                                {{ $dashboard }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-info">
                            <i class="far fa-file"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Storyboard</h4>
                            </div>
                            <div class="card-body">
                                {{ $storyboard }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-success">
                            <i class="fas fa-circle"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Data Sektoral</h4>
                            </div>
                            <div class="card-body">
                                {{ $data_sektoral }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-secondary">
                            <i class="far fa-user"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Data Dasar</h4>
                            </div>
                            <div class="card-body">
                                {{ $data_dasar }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-danger">
                            <i class="far fa-newspaper"></i>
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
                        <div class="card-icon bg-success">
                            <i class="far fa-file"></i>
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
            <div class="row">
                <div class="col-lg-8 col-md-12 col-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Statistics Datasets</h4>
                            <div class="card-header-action">
                                <form action="{{ route('dashboard') }}" method="get">
                                    <div class="btn-group">
                                        <div class="mr-2">
                                            <label for="startDate" class="form-label">Tanggal Mulai</label>
                                            <input type="date" class="form-control" id="startDate" name="startDate"
                                                required>
                                        </div>
                                        <div class="mr-2">
                                            <label for="endDate" class="form-label">Tanggal Akhir</label>
                                            <input type="date" class="form-control" id="endDate" name="endDate"
                                                required>
                                        </div>
                                        <div style="margin-top: 37px;">
                                            <button class="btn btn-primary" type="submit">Submit</button>
                                        </div>
                                    </div>
                                </form>
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
                            </div>
                            <hr>
                            <div class="statistic-details mt-sm-4">
                                <div class="statistic-details-item">
                                    <div class="detail-value">{{ $visitor_today }}</div>
                                    <div class="detail-name">Today's Visitor</div>
                                </div>
                                <div class="statistic-details-item">
                                    <div class="detail-value">{{ $visitor_week }}</div>
                                    <div class="detail-name">This Week's Visitor</div>
                                </div>
                                <div class="statistic-details-item">
                                    <div class="detail-value">{{ $visitor_month }}</div>
                                    <div class="detail-name">This Month's Visitor</div>
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
                                <a href="{{ route('aktivitas') }}" class="btn btn-primary btn-lg btn-round">
                                    View All
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
