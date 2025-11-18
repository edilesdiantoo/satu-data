@extends('opd/layout/layout')
@section('title', 'Grafik Datasets')
@section('main')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Grafik Datasets</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Grafik Datasets</a></div>
                    <div class="breadcrumb-item"><a href="#">Data Grafik Datasets</a></div>
                    <div class="breadcrumb-item">Tabel Grafik Datasets</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Data Grafik Datasets Tahun {{date('Y')}}</h2>
                <p class="section-lead">
                    Ini adalah halaman data Grafik Datasets Jambi data dan Analitik Center.
                </p>

                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Grafik Datasets Perminggu</h4>
                            </div>
                            <div class="card-body">
                                {!! $chart_mingguan->container() !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Grafik Datasets Bulanan</h4>
                            </div>
                            <div class="card-body">
                                {!! $chart->container() !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4>Daftar Datasets Terbanyak</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-1">
                                        <thead>
                                            <tr>
                                                <th class="text-center">
                                                    No
                                                </th>
                                                <th>Nama OPD</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $datasets = $datasets->sortByDesc('total');
                                            @endphp
                                            @foreach ($datasets as $item)
                                                <tr>
                                                    <td class="text-center">{{ $loop->iteration }}</td>
                                                    <td>{{ $item->nama_opd }}</td>
                                                    <td>{{ $item->total }}</td>
                                                    
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script src="{{ $chart->cdn() }}"></script>
    <script src="{{ $chart_mingguan->cdn() }}"></script>

    {{ $chart->script() }}
    {{ $chart_mingguan->script() }}
@endsection
