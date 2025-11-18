@extends('opd/layout/layout')
@section('title', 'Aktivitas')
@section('main')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Aktivitas</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Aktivitas</a></div>
                    <div class="breadcrumb-item">History Aktivitas</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Aktivitas</h2>
                <p class="section-lead">
                    Ini adalah halaman Aktivitas Jambi data dan Analitik Center.
                </p>
                <div class="row">
                    <div class="col-12">
                        <div class="section-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="activities">
                                        @foreach ($aktivitas as $item)
                                            <div class="activity">
                                                @if (
                                                    $item->status == 'O1' ||
                                                        $item->status == 'P2' ||
                                                        $item->status == 'P4' ||
                                                        $item->status == 'OPD1' ||
                                                        $item->status == 'S1' ||
                                                        $item->status == 'AOPD1' ||
                                                        $item->status == 'D1' ||
                                                        $item->status == 'V1')
                                                    <div class="activity-icon bg-primary text-white shadow-primary">
                                                        <i class="fas fa-plus"></i>
                                                    </div>
                                                @elseif (
                                                    $item->status == 'O2' ||
                                                        $item->status == 'P2' ||
                                                        $item->status == 'P4' ||
                                                        $item->status == 'OPD2' ||
                                                        $item->status == 'S2' ||
                                                        $item->status == 'AOPD2' ||
                                                        $item->status == 'D2' ||
                                                        $item->status == 'V2')
                                                    <div class="activity-icon bg-secondary text-white shadow-secondary">
                                                        <i class="fas fa-comment-alt"></i>
                                                    </div>
                                                @elseif (
                                                    $item->status == 'O3' ||
                                                        $item->status == 'P2' ||
                                                        $item->status == 'P4' ||
                                                        $item->status == 'OPD3' ||
                                                        $item->status == 'S3' ||
                                                        $item->status == 'AOPD3' ||
                                                        $item->status == 'D3' ||
                                                        $item->status == 'V3')
                                                    <div class="activity-icon bg-danger text-white shadow-danger">
                                                        <i class="fas fa-trash"></i>
                                                    </div>
                                                @elseif ($item->status == 'D4')
                                                    <div class="activity-icon bg-info text-white shadow-info">
                                                        <i class="fas fa-random"></i>
                                                    </div>
                                                @elseif ($item->status == 'D5')
                                                    <div class="activity-icon bg-success text-white shadow-success">
                                                        <i class="fas fa-check-square"></i>
                                                    </div>
                                                @elseif ($item->status == 'D6')
                                                    <div class="activity-icon bg-danger text-white shadow-danger">
                                                        <i class="fas fa-exclamation-triangle"></i>
                                                    </div>
                                                @elseif ($item->status == 'D7')
                                                    <div class="activity-icon bg-primary text-white shadow-primary">
                                                        <i class="fas fa-plus"></i>
                                                    </div>
                                                @else
                                                    <div class="activity-icon bg-primary text-white shadow-primary">
                                                    </div>
                                                @endif

                                                <div class="activity-detail">
                                                    <div class="mb-2">
                                                        <span class="text-job text-primary">{{ $item->created_at }}</span>
                                                        <span class="bullet"></span>
                                                    </div>
                                                    @foreach ($users as $item_user)
                                                        @if ($item_user->id == $item->id_user)
                                                            <p><b>{{ $item_user->name }} </b>{{ $item->pesan }}.
                                                        @endif
                                                    @endforeach
                                                    </p>
                                                </div>
                                            </div>
                                        @endforeach
                                        {{ $aktivitas->links('vendor.pagination.bootstrap-5') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
