@extends('super-admin/layout/layout')
@section('title', 'Datasets')
@section('main')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Datasets</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">List Agenda Rilis</a></div>
                    <div class="breadcrumb-item">Tabel List Agenda Datasets</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">List Agenda Rilis Datasets</h2>
                <p class="section-lead">
                    Ini adalah halaman List Agenda Rilis Datasets Jambi data dan Analitik Center.
                </p>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4>Daftar List Agenda Rilis Datasets</h4>
                                <a href="{{ route('datasets.create') }}" class="btn btn-primary">Tambah Datasets <i
                                        class="fa fa-plus"></i></a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-1">
                                        <thead>
                                            <tr>
                                                <th class="text-center">
                                                    No
                                                </th>
                                                <th>Judul</th>
                                                <th>Nama OPD</th>
                                                <th>Diupload Oleh</th>
                                                <th>Tahun Datasets</th>
                                                <th>Sifat Datasets</th>
                                                <th>DB Datasets</th>
                                                <th>Status</th>
                                                <th>Jumlah Unduhan</th>
                                                <th>Dataset Dibuat</th>
                                                <th>Dataset Diupdate</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($datasets as $item)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $item->judul }}</td>
                                                    <td>{{ $item->nama_opd }}</td>
                                                    @foreach ($users as $item_user)
                                                        @if ($item_user->id == $item->diupload_oleh)
                                                            <td>{{ $item_user->name }}</td>
                                                        @endif
                                                    @endforeach
                                                    <td>{{ $item->tahun_datasets }}</td>
                                                    <td>{{ $item->sifat_datasets }}</td>
                                                    <td>{{ $item->db_datasets }}</td>
                                                    <td>
                                                        @if ($item->status == 'PENDING')
                                                            <span class="badge badge-primary">Dalam Proses</span>
                                                        @elseif ($item->status == 'REPAIR')
                                                            <span class="badge badge-warning">Perlu Perbaikan</span>
                                                        @elseif ($item->status == 'REJECTED')
                                                            <span class="badge badge-danger">Ditolak</span>
                                                        @elseif ($item->status == 'APPROVED')
                                                            <span class="badge badge-success">Terverifikasi</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $item->jumlah_unduhan }}</td>
                                                    <td>{{ $item->created_at->format('d M Y H:i') }}</td>
                                                    <td>{{ $item->updated_at->format('d M Y H:i') }}</td>
                                                    <td>
                                                        <button type="button" class="btn btn-primary" data-toggle="modal"
                                                            data-target="#modalList{{ $item->id }}"
                                                            data-backdrop="true">
                                                            Show List
                                                        </button>
                                                    </td>
                                                    {{-- <td>
                                                        <div class="dropdown d-inline mr-2">
                                                            <button class="btn btn-primary dropdown-toggle" type="button"
                                                                id="dropdownMenuButton" data-toggle="dropdown"
                                                                aria-haspopup="true" aria-expanded="false">
                                                                Pilih Aksi
                                                            </button>
                                                            <div class="dropdown-menu" x-placement="bottom-start"
                                                                style="position: absolute; transform: translate3d(0px, 28px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                                <a class="dropdown-item"
                                                                    href="{{ route('datasets.show', $item->id) }}">Details</a>
                                                                <a class="dropdown-item"
                                                                    href="{{ route('datasets.edit', $item->id) }}">Edit</a>
                                                                <a class="dropdown-item"
                                                                    href="{{ route('agenda-rilis', $item->id) }}">Agenda
                                                                    Rilis</a>
                                                                <a class="dropdown-item"
                                                                    href="{{ route('datasets.destroy', $item->id) }}"
                                                                    data-confirm-delete="true">Delete</a>
                                                            </div>
                                                        </div>
                                                    </td> --}}
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
        @foreach ($datasets as $item)
            <div class="modal fade" id="modalList{{ $item->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Detail: {{ $item->judul }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="table-responsive">

                                <table class="table table-bordered table-sm calendar-matrix text-center" id="table-1">
                                    <thead class="table-white"
                                        style="background-color: #1a42a9; font-size:14px; text-transform: capitalize; color: #fff !important; vertical-align : middle;">
                                        <tr>
                                            <th>Jan</th>
                                            <th>Feb</th>
                                            <th>Mar</th>
                                            <th>Apr</th>
                                            <th>Mei</th>
                                            <th>Jun</th>
                                            <th>Jul</th>
                                            <th>Agu</th>
                                            <th>Sep</th>
                                            <th>Okt</th>
                                            <th>Nov</th>
                                            <th>Des</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            @php
                                                // List nama bulan sesuai dengan data di database Anda
                                                $listBulan = [
                                                    'Januari',
                                                    'Februari',
                                                    'Maret',
                                                    'April',
                                                    'Mei',
                                                    'Juni',
                                                    'Juli',
                                                    'Agustus',
                                                    'September',
                                                    'Oktober',
                                                    'November',
                                                    'Desember',
                                                ];
                                            @endphp

                                            @foreach ($listBulan as $namaBulan)
                                                <td>
                                                    @php
                                                        // Cari apakah ada agenda untuk bulan ini
                                                        $agendaBulanIni = $item->agendas
                                                            ->where('bulan', $namaBulan)
                                                            ->first();
                                                    @endphp

                                                    @if ($agendaBulanIni)
                                                        <div class="font-weight-bold text-primary">
                                                            {{ $agendaBulanIni->tanggal }}</div>
                                                        <hr class="my-1">

                                                        @if ($agendaBulanIni->status == 1)
                                                            <a href="{{ route('datasets.edit', [$item->id, 'read_only' => 1]) }}"
                                                                class="btn btn-sm btn-success p-0 px-1"
                                                                style="font-size: 10px;">View</a>
                                                        @else
                                                            <a href="{{ route('agenda-rilis', ['id' => $item->id, 'agenda_id' => $agendaBulanIni->id, 'read_only' => 1]) }}"
                                                                class="btn btn-sm btn-warning p-0 px-1"
                                                                style="font-size: 10px;">
                                                                rilis
                                                            </a>
                                                        @endif
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                            @endforeach
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                        <div class="modal-footer bg-whitesmoke br">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endsection
