@extends('opd/layout/layout')
@section('title', 'Kategori Data')
@section('main')

    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Kategori Data</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Kategori Data</a></div>
                    <div class="breadcrumb-item">Tabel Kategori Data</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Kategori Data</h2>
                <p class="section-lead">
                    Ini adalah halaman Kategori Data Jambi data dan Analitik Center.
                </p>
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
                <div class="row">
                    <div class="col-md-12">
                        <section class="service-categories text-center">
                            <div class="row">
                                @foreach ($sektor as $item)
                                    <div class="col-md-2">
                                        <a href="{{ route('opd_kategoridata', $item->id) }}">
                                            <div class="card service-card card-inverse"
                                                @if ($idNode == $item->id) style="background-color: #6777ef;" @endif>
                                                <div class="card-block m-3">
                                                    <span
                                                        class="{{ $item->icon }}"@if ($idNode == $item->id) style="color: white;" @endif></span>
                                                    <h5 class="card-title"
                                                        @if ($idNode == $item->id) style="color:white;" @endif>
                                                        {{ $item->nama_sektor }}</h5>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                            <!--End Row-->
                        </section>
                    </div>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4>Daftar Kategori Data</h4>
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
                                                <th>Tahun Datasets</th>
                                                <th>Jumlah Unduhan</th>
                                                <th>Dataset Dibuat</th>
                                                <th>Dataset Diupdate</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($datasets as $item)
                                                <?php
                                                // replace non letter or digits by divider
                                                $text = preg_replace('~[^\pL\d]+~u', '-', $item->judul);
                                                
                                                // transliterate
                                                $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
                                                
                                                // remove unwanted characters
                                                $text = preg_replace('~[^-\w]+~', '', $text);
                                                
                                                // trim
                                                $text = trim($text, '-');
                                                
                                                // remove duplicate divider
                                                $text = preg_replace('~-+~', '-', $text);
                                                
                                                // lowercase
                                                $text = strtolower($text);
                                                
                                                ?>
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $item->judul }}</td>
                                                    <td>{{ $item->nama_opd }}</td>
                                                    <td>{{ $item->tahun_datasets }}</td>
                                                    <td>{{ $item->jumlah_unduhan }}</td>
                                                    <td>{{ $item->created_at->format('d M Y H:i') }}</td>
                                                    <td>{{ $item->updated_at->format('d M Y H:i') }}</td>
                                                    <td>
                                                        <a href="{{ route('web-datasets.show', ['id' => $item->id, 'slug' => $text]) }}"
                                                            target="_blank" class="btn btn-primary">Pratinjau <i
                                                                class="fa fa-eye text-white"></i></a>
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
