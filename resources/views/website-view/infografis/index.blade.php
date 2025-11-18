@extends('website-view.layout.layout')
@section('title', 'Infografis Provinsi Jambi')
@section('main')
    <main id="main">
        <!-- ======= Breadcrumbs Section ======= -->
        <section class="breadcrumbs">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center">
                    <h2>Infografis</h2>
                    <ol>
                        <li><a href="/">Home</a></li>
                        <li>Informasi</li>
                        <li>Infografis</li>
                    </ol>
                </div>
            </div>
        </section><!-- End Breadcrumbs Section -->

        <section class="inner-page pt-3">
            <div class="container">
                <div class="section-title" data-aos="fade-up" style="padding-bottom: 0px">
                    <h2>Data Dasar</h2>
                    <p>{{ $infografis->count() }} Infografis Ditemukan </p>
                </div>
                <div class="row mt-3 g-4" data-aos="fade-left">
                    <div class="col-md-3" data-aos="fade-right">
                        <form action="{{ route('web-infografis.index') }}" method="get">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1"><i class='bx bx-search'></i></span>
                                        <input type="text" class="form-control" name="judul" value=""
                                            placeholder="Cari Data..." aria-label="Username"
                                            aria-describedby="basic-addon1">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">Urutkan Berdasarkan</span>
                                        <select name="urut" id="urut" class="form-select"
                                            onchange="this.form.submit()">
                                            <option value="terbaru"
                                                {{ app('request')->input('urut') == 'terbaru' ? 'selected' : '' }}>Terbaru
                                            </option>
                                            <option value="abjad"
                                                {{ app('request')->input('urut') == 'abjad' ? 'selected' : '' }}>Abjad
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">Tampilkan Sebanyak</span>
                                        <select name="record" id="record" class="form-select"
                                            onchange="this.form.submit()">
                                            <option
                                                value="10"{{ app('request')->input('record') == 10 ? 'selected' : '' }}>
                                                10</option>
                                            <option
                                                value="20"{{ app('request')->input('record') == 20 ? 'selected' : '' }}>
                                                20</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header header-sosialdankependudukan text-white fw-bold">
                                    Filter Infografis
                                    <i class="bi bi-funnel-fill float-end"></i>
                                </div>
                                <div class="card-body">
                                    <div class="form-check">
                                        <input class="form-check-input" style="border-radius: 10%" name="sektor"
                                            value="" onChange="this.form.submit()" type="radio"
                                            {{ app('request')->input('sektor') == null ? 'checked' : '' }}>
                                        <label class="form-check-label" style="font-size: 13px;"
                                            for="flexCheckDefault">All</label>
                                    </div>
                                    @foreach ($sektor as $item)
                                        <div class="form-check">
                                            <input class="form-check-input" style="border-radius: 10%" name="sektor"
                                                value="{{ $item->id }}" onChange="this.form.submit()" type="radio"
                                                {{ app('request')->input('sektor') == $item->id ? 'checked' : '' }}>
                                            <label class="form-check-label" style="font-size: 13px;"
                                                for="flexCheckDefault">{{ $item->nama_sektor }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-9">
                        <div class="row">
                            @foreach ($infografis as $item)
                                <div class="col-lg-3 col-md-6 d-flex align-items-stretch">
                                    <div class="member aos-init aos-animate" data-aos="fade-up" data-aos-delay="200">
                                        <div class="member-img">
                                            <div class="cropper img-hover-zoom">
                                                <a data-bs-toggle="modal" data-bs-target="#infografis-{{ $item->id }}"
                                                    href="{{ asset('assets/infografis/' . $item->gambar) }}"
                                                    data-title="{{ $item->judul }}"
                                                    data-updated-at="{{ $item->updated_at->format('Y-m-d H:i:s') }}"
                                                    data-url="http://127.0.0.1:8000/web-infografis?id={{ $item->id }}"
                                                    data-gall="portfolioGallery" class="venobox vbox-item">
                                                    <img src="{{ asset('assets/infografis/' . $item->gambar) }}"
                                                        class="img-fluid" alt="{{ $item->gambar }}"
                                                        style="width:100%; height: 250px;">
                                                </a>
                                            </div>
                                        </div>
                                        <span class="badge bg-info mt-2" style="font-size:10px;">
                                            {{ App\Http\Controllers\WebController\HomeController::getSektor($item->id_sektor) }}
                                        </span>
                                        <div class="member-info pt-1">
                                            <h6 class="fw-bold" style="font-size: 13px;">{{ $item->judul }}</h6>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="mt-3">
                        {{ $infografis->links('vendor.pagination.bootstrap-5') }}
                    </div>
                </div>
        </section>
    </main><!-- End #main -->

    @if ($selectedInfographic)
        <script>
            $(document).ready(function() {
                $('#infografis-{{ $selectedInfographic->id }}').modal('show');
                $('#infografis-{{ $selectedInfographic->id }}').on('hidden.bs.modal', function() {
                    window.history.pushState('', document.title, window.location.pathname);
                });
            });
        </script>
    @endif

    @foreach ($infografis as $item)
        <!-- Modal -->
        <div class="modal fade" id="infografis-{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true"data-title="{{ $item->judul }}" data-updated-at="{{ $item->updated_at }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">{{ $item->judul }}</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <img src="{{ asset('assets/infografis/' . $item->gambar) }}" class="img-fluid" alt=""
                            style="max-height: 665px">
                    </div>
                    <div class="btn-group" role="group" aria-label="Button group to open share modal">
                        <button type="button" class="btn btn-secondary rounded w-100 mx-4 mb-2"
                            onclick="openShareModal('{{ $item->id }}', 'http://127.0.0.1:8000/web-infografis?id={{ $item->id }}')"
                            style="font-size: 12px;">
                            <i class="bi bi-share"></i> Bagikan
                        </button>
                    </div>
                    <a download="images.jpg" href="{{ asset('assets/infografis/' . $item->gambar) }}"
                        class="btn btn-primary mx-4 mb-3"
                        style="font-size: 14px; background-color: rgba(26,29,148,255); color: white; border: none;">Unduh</a>
                </div>
            </div>
        </div>

        <!-- Share Modal -->
        <div class="modal fade" id="share_modal" tabindex="0" aria-labelledby="share_modalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h5 class="modal-title" id="share_modalLabel">Bagikan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <!-- Modal Body -->
                    <div class="modal-body">
                        <!-- Share Link Section -->
                        <div class="mb-3">
                            <label for="share-url" class="form-label"
                                style="text-align: left;"><strong>Tautan</strong></label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="share-url" style="font-size: 12px;"
                                    value="" readonly>
                                <button class="btn" type="button" id="copy-url-btn"
                                    style="font-size: 12px; background-color: rgba(26,29,148,255); color: white; border: none;">Salin</button>
                            </div>
                            <div class="form-text text-success mt-1 d-none" id="copy-success">Tautan berhasil
                                disalin</div>
                        </div>

                        <!-- Citation Section -->
                        <div class="mb-3">
                            <div class="mb-2 d-flex align-items-center">
                                <label for="citation-format" class="form-label me-2"><strong>Kutipan</strong></label>
                                <select class="form-select" id="citation-format" style="width: 20%; font-size: 11px;">
                                    <option value="apa" style="font-size: 12px;">APA</option>
                                    <option value="mla" style="font-size: 12px;">MLA</option>
                                    <option value="harvard" style="font-size: 12px;">Harvard</option>
                                </select>
                            </div>
                            <div class="mt-2 p-2 border rounded">
                                <p id="citation-text" class="mb-0" style="font-size: 14px">
                                    <!-- Initial APA Citation will be populated by JavaScript -->
                                </p>
                            </div>
                            <button class="btn mt-2 w-100 ms-0" type="button" id="copy-cite-btn"
                                style="font-size: 12px; background-color: rgba(26,29,148,255); color: white; border: none;">Salin
                                Kutipan</button>
                            <div class="form-text text-success mt-1 d-none" id="copy-success-citation">Kutipan
                                berhasil
                                disalin</div>
                        </div>

                        <!-- Social Media Share Section -->
                        <div class="d-flex justify-content-center">
                            <a href="#" id="facebook-share" target="_blank"
                                style="text-align: center; text-decoration: none; width: 50px;" class="me-2">
                                <img src="{{ asset('assets/img/socials/facebook.svg') }}" alt="Facebook"
                                    style="width: 48px; height: 48px;">
                                <span style="font-size: 8px; color: black;">Facebook</span>
                            </a>
                            <a href="#" id="twitter-share" target="_blank"
                                style="text-align: center; text-decoration: none; width: 50px;" class="me-2">
                                <img src="{{ asset('assets/img/socials/twitter.svg') }}" alt="Facebook"
                                    style="width: 48px; height: 48px;">
                                <span style="font-size: 8px; color: black;">Twitter</span>
                            </a>
                            <a href="#" id="whatsapp-share" target="_blank"
                                style="text-align: center; text-decoration: none; width: 50px;" class="me-2">
                                <img src="{{ asset('assets/img/socials/whatsapp.svg') }}" alt="Facebook"
                                    style="width: 48px; height: 48px;">
                                <span style="font-size: 8px; color: black;">WhatsApp</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <style>
            #share_modal {
                z-index: 2000;
                /* Set a higher z-index for the share modal */
            }
        </style>

        <script>
            function openShareModal(itemId, itemUrl) {
                // Set the share URL in the input field
                const shareUrlInput = document.getElementById('share-url');
                shareUrlInput.value = itemUrl;

                // Update social media share links
                document.getElementById('facebook-share').href =
                    `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(itemUrl)}`;
                document.getElementById('twitter-share').href =
                    `https://twitter.com/intent/tweet?url=${encodeURIComponent(itemUrl)}`;
                document.getElementById('whatsapp-share').href =
                    `https://api.whatsapp.com/send?text=${encodeURIComponent(itemUrl)}`;

                // Open the share modal
                const shareModal = new bootstrap.Modal(document.getElementById('share_modal'));
                shareModal.show();
            }

            // Function to open infographic modal and handle data display
            function openInfographicModal(id) {
                // Logic to fetch infographic data based on ID and update modal content if needed
                console.log('Open infographic modal for ID:', id);
            }

            // Function to open infographic modal and handle data display
            function openInfographicModal(id) {
                // Logic to fetch infographic data based on ID and update modal content
                console.log('Open infographic modal for ID:', id);
                // Set modal title and content here if needed
            }

            // Tautan Section Script
            document.addEventListener('DOMContentLoaded', function() {
                // Copy URL to clipboard
                document.getElementById('copy-url-btn').addEventListener('click', function() {
                    const copyText = document.getElementById('share-url');
                    navigator.clipboard.writeText(copyText.value);
                    document.getElementById('copy-success').classList.remove('d-none');
                    setTimeout(() => {
                        document.getElementById('copy-success').classList.add('d-none');
                    }, 2000);
                });
            });

            // Citation Section Script
            document.addEventListener('DOMContentLoaded', function() {
                const citationText = document.getElementById('citation-text');
                const citationFormat = document.getElementById('citation-format');
                const currentDate = new Date().toLocaleDateString('id-ID', {
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric'
                });
                const currentDate2 = new Date().toLocaleDateString('id-ID', {
                    day: 'numeric',
                    month: 'short',
                    year: 'numeric'
                });

                // Function to update citation based on selected format
                function updateCitation(format, title, updatedAt, url) {
                    const updatedAtDate = new Date(updatedAt);
                    const formattedDate = updatedAtDate.toLocaleDateString('id-ID', {
                        day: 'numeric',
                        month: 'long',
                        year: 'numeric'
                    });
                    const formattedDate2 = updatedAtDate.toLocaleDateString('id-ID', {
                        year: 'numeric'
                    });

                    let citation = '';
                    switch (format) {
                        case 'apa':
                            citation =
                                `Jambi Data Analytic Center. (${formattedDate}). <i>${title}</i>. Diakses Pada ${currentDate}, dari ${url}`;
                            break;
                        case 'mla':
                            citation =
                                `Jambi Data Analytic Center. (${formattedDate}). <i>${title}</i>. ${currentDate2}: ${url}.`;
                            break;
                        case 'harvard':
                            citation =
                                `Jambi Data Analytic Center. (${formattedDate2}). <i>${title}</i> [Online]. Tersedia di: ${url}.`;
                            break;
                        default:
                            citation =
                                `Jambi Data Analytic Center. (${formattedDate}). <i>${title}</i>. Retrieved from ${url}`;
                    }

                    citationText.innerHTML = citation;
                }

                // Update the citation when the share modal is opened
                const shareModals = document.querySelectorAll('.modal');

                shareModals.forEach(modal => {
                    modal.addEventListener('show.bs.modal', (event) => {
                        const triggerElement = document.querySelector(
                            `[data-bs-target="#${modal.id}"]`); // Get the <a> that opened the modal
                        const title = triggerElement.getAttribute('data-title');
                        const updatedAt = triggerElement.getAttribute('data-updated-at');
                        const url = triggerElement.getAttribute(
                            'data-url'); // Get the specific URL from data-url

                        // Initial citation update to APA format when the modal opens
                        updateCitation('apa', title, updatedAt, url);
                    });
                });

                // Event listener to update citation when format is changed
                citationFormat.addEventListener('change', function() {
                    const activeModal = document.querySelector('.modal.show');
                    if (activeModal) {
                        const triggerElement = document.querySelector(`[data-bs-target="#${activeModal.id}"]`);
                        const title = triggerElement.getAttribute('data-title');
                        const updatedAt = triggerElement.getAttribute('data-updated-at');
                        const url = triggerElement.getAttribute('data-url');
                        updateCitation(this.value, title, updatedAt, url);
                    }
                });

                // Copy citation text to clipboard
                document.getElementById('copy-cite-btn').addEventListener('click', function() {
                    navigator.clipboard.writeText(citationText.innerText);
                    const copySuccessCitation = document.getElementById('copy-success-citation');
                    copySuccessCitation.classList.remove('d-none');
                    setTimeout(() => {
                        copySuccessCitation.classList.add('d-none');
                    }, 2000);
                });
            });
        </script>
    @endforeach
@endsection
