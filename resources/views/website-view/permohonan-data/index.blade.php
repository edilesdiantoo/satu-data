@extends('website-view.layout.layout')
@section('title', 'Permohonan Data')
@section('main')
    <main id="main">
        <!-- ======= Breadcrumbs Section ======= -->
        <section class="breadcrumbs">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center">
                    <h2>Permohonan Data</h2>
                    <ol>
                        <li><a href="/">Home</a></li>
                        <li>Halaman Permohonan Data</li>
                    </ol>
                </div>
            </div>
        </section><!-- End Breadcrumbs Section -->
        <section class="inner-page">
            <div class="container">
                <div class="row" style="padding-bottom: 20px;">
                    <div class="col-md-10">
                        <div class="section-title" style="padding-bottom: 0px;" data-aos="fade-up">
                            <h2>Permohonan Data</h2>
                            <p>Cari Permohonan Data</p>
                        </div>
                    </div>
                    <div class="col-md-2 g-2">
                        <a href="{{ route('web-permohonan.create') }}" class="btn btn-primary mr-2"
                            data-aos="fade-up">Ajukan Permohonan <i class="bi bi-plus"></i></a>
                    </div>
                </div>
                <div class="row gy-3">
                    <div class="col-md-12" data-aos="fade-up">
                        @if (\Session::has('success'))
                            <div class="alert alert-danger">
                                <ul>
                                    <li>{!! \Session::get('success') !!}</li>
                                </ul>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-5">
                        <form method="post" action="{{ route('check_idtracking') }}" id="form" data-aos="fade-up">
                            @method('POST')
                            @csrf
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class='bx bx-search'></i></span>
                                <div class="form-floating">
                                    <input type="text" name="id_tracking" value="{{ old('id_tracking') }}"
                                        class="form-control" id="floatingInputGroup1" placeholder="Tracking Code">
                                    <label for="floatingInputGroup1">Masukan Kode Tracking</label>
                                </div>
                            </div>
                            {!! htmlFormSnippet() !!}
                        </form>
                    </div>
                    <div class="col-md-12" data-aos="fade-up">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if (\Session::has('error'))
                            <div class="alert alert-danger">
                                <ul>
                                    <li>{!! \Session::get('error') !!}</li>
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </main><!-- End #main -->
@endsection
