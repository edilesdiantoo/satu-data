@extends('super-admin/layout/layout')
@section('title', 'Feedback')
@section('main')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Feedback</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Data Feedback</a></div>
                    <div class="breadcrumb-item">Tabel Feedback</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Feedback</h2>
                <p class="section-lead">
                    Ini adalah halaman Feedback dalam Sistem Jambi data dan Analitik Center.
                </p>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4>Daftar Data Feedback</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-1">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Nama Datasets</th>
                                                <th>Question 1</th>
                                                <th>Question 2</th>
                                                <th>Saran</th>
                                                <th>Created</th>
                                                <th>Updated</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($feedback as $item)
                                                <tr>

                                                    <td>
                                                        {{ App\Http\Controllers\Admin\UlasanController::getNameDatasets($item->id_datasets) }}
                                                    </td>
                                                    <td>{{ $item->question1 }}</td>
                                                    <td>{{ $item->question2 }}</td>
                                                    <td>{{ $item->saran }}</td>
                                                    <td>{{ $item->created_at }}</td>
                                                    <td>{{ $item->updated_at }}</td>
                                                    <td>
                                                        <div class="dropdown d-inline mr-2">
                                                            <button class="btn btn-primary dropdown-toggle" type="button"
                                                                id="dropdownMenuButton" data-toggle="dropdown"
                                                                aria-haspopup="true" aria-expanded="false">
                                                                Pilih Aksi
                                                            </button>
                                                            <div class="dropdown-menu" x-placement="bottom-start"
                                                                style="position: absolute; transform: translate3d(0px, 28px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                                <a class="dropdown-item"
                                                                    href="{{ route('feedback.destroy', $item->id) }}"
                                                                    data-confirm-delete="true">Delete</a>
                                                            </div>
                                                        </div>
                                                    </td>
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
@endsection
