@extends('website-view.layout.layout')
@section('title', $visualisasi->judul)
@section('main')
    <main id="main">
        <!-- ======= Breadcrumbs Section ======= -->
        <section class="breadcrumbs">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center">
                    <h2>Visualisasi</h2>
                    <ol>
                        <li><a href="/">Home</a></li>
                        <li>Visualisasi</li>
                        <li>{{ $visualisasi->kategori === 'dashboard' ? 'Dashboard' : 'Storyboard' }}</li>
                    </ol>
                </div>

            </div>
        </section><!-- End Breadcrumbs Section -->
        <section class="inner-page">
            <div class="container">
                <div class="section-title" data-aos="fade-up">
                    <h2>{{ $visualisasi->kategori === 'dashboard' ? 'Dashboard' : 'Storyboard' }}</h2>
                    <p>{{ $visualisasi->judul }} </p>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card" data-aos="fade-down">
                            <div class="card-body">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <span class="badge bg-info">
                                                Terakhir Diperbarui : {{ $visualisasi->updated_at->format('d M Y h:i') }}
                                            </span>
                                            <div class="mt-2">
                                                @php
                                                    $url_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                                                @endphp
                                                <a class="btn btn-sm btn-primary"
                                                    href='https://www.facebook.com/sharer/sharer.php?u=https://127.0.0.1:8000/visualisasi/show/{{ $visualisasi->id }}/dashboard'
                                                    target="_blank" title="Share this post on Facebook">
                                                    <i class="bi bi-facebook"></i> Share
                                                </a>
                                                <a class="btn btn-sm btn-info text-white"
                                                    href="https://twitter.com/intent/tweet?text={{ $visualisasi->judul }}&amp;url=https://127.0.0.1:8000/visualisasi/show/{{ $visualisasi->id }}/dashboard"
                                                    target="_blank" title="Share this post on Twitter">
                                                    <i class="bi bi-twitter"></i> Tweet
                                                </a>
                                                <a class="btn btn-sm btn-outline-primary"
                                                    href="https://www.linkedin.com/shareArticle?mini=true&url=https://127.0.0.1:8000/visualisasi/show/{{ $visualisasi->id }}/dashboard&amp;title={{ $visualisasi->judul }}"
                                                    target="_blank" title="Share this post on LinkedIn">
                                                    <i class="bi bi-linkedin" data-fa-transform="grow-2"></i>
                                                </a>
                                                <a class="btn btn-sm btn-outline-danger"
                                                    href="https://plus.google.com/share?url=https://127.0.0.1:8000/visualisasi/show/{{ $visualisasi->id }}/dashboard"
                                                    target="_blank" title="Share this post on Google Plus">
                                                    <i class="bi bi-google" data-fa-transform="grow-2"></i>
                                                </a>
                                            </div>
                                        </div>
                                        {{-- <div class="col-md-8">
                                            <div class="btn-group float-end" role="group"
                                                aria-label="Button group with nested dropdown">
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-success dropdown-toggle"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        Unduh
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item" href="#">Excell</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div> --}}
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
                                                <h4>Deskripsi Singkat</h4>
                                                {{ $visualisasi->deskripsi }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="embed-responsive embed-responsive-16by9 mt-3">
                                        <div class="embed-responsive-item">
                                            @php
                                                echo $visualisasi->url;
                                            @endphp
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
