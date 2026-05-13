@extends('website-view.layout.layout')
@section('title', 'Berita Provinsi Jambi')
@section('main')
    <main id="main">
        <!-- ======= Breadcrumbs Section ======= -->
        <section class="breadcrumbs">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center">
                    <h2>Rencana Terbit Dataset</h2>
                    <ol>
                        <li><a href="/">Home</a></li>
                        <li>Informasi</li>
                        <li>Rencana Terbit Dataset</li>
                    </ol>
                </div>
            </div>
        </section><!-- End Breadcrumbs Section -->
        <link href="{{ asset('assets/css/stylex.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/costum.css') }}" rel="stylesheet">
        <style>
            .featured-news {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
            }

            .featured-news-item {
                font-size: 8px;
                color: var(--text-color-lighter);
                display: flex;
                padding: 8px;

            }

            .featured-news-item:before {
                content: "";
                display: block;
                height: 0;
                width: 0;
                padding-bottom: calc(9 / 16 * 100%);
            }

            .featured-news-item:first-child {
                grid-column: span 2;
                font-size: 12px;
            }

            .featured-news-item:first-child:before {
                padding-bottom: calc(8 / 16 * 100%);
            }

            .featured-news-item a {
                display: grid;
                overflow: hidden;
                width: 100%;
            }

            .featured-news-item-img {
                object-fit: cover;
                height: 100%;
                width: 100%;
                border-radius: 6px;
            }

            .caption,
            .featured-news-item-img {
                grid-column: 1;
                grid-row: 1;
            }

            .caption {
                display: flex;
                height: 100%;
                align-items: flex-end;
                /* background: hsla(246, 40%, 30%, 0.5);
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        ; */
                padding: 10px;

                border-radius: 12px;
            }

            .caption h2 {
                font-weight: normal;
                margin: 0;
                display: -webkit-box;
                -webkit-line-clamp: 3;
                -webkit-box-orient: vertical;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            section {
                padding: 0 15px;
            }

            section.featured-news {
                padding: 0;
            }

            @media only screen and (min-width: 640px) {
                .featured-news {
                    grid-template-columns: repeat(9, 1fr);
                }

                .featured-news-item {
                    grid-column: span 3;
                    font-size: 10px;
                }

                .featured-news-item:first-child {
                    grid-column: span 6;
                    grid-row: span 2;
                }

                .featured-news-item:nth-child(4) {
                    grid-column: span 4;
                }

                .featured-news-item:last-child {
                    grid-column: span 5;
                    font-size: 12px;
                }
            }

            @media only screen and (min-width: 768px) {
                .content {
                    display: grid;
                    grid-gap: 2em;
                    grid-template-columns: repeat(3, 1fr);
                }

                .featured-news {
                    grid-column: span 3;
                }

                .featured-news {
                    grid-template-columns: repeat(4, 1fr);
                }

                .featured-news-item:first-child:before {
                    padding-bottom: calc(8 / 12 * 100%);
                }

                .featured-news-item {
                    grid-column: span 1;
                    font-size: 10px;
                }

                .featured-news-item:first-child {
                    grid-column: span 2;
                    grid-row: span 2;
                }

                .featured-news-item:nth-child(4) {
                    grid-column: span 1;
                }

                .featured-news-item:last-child {
                    grid-column: span 1;
                    font-size: 12px;
                }

                .caption {
                    padding: 15px;
                }
            }

            @media screen and (min-width: 1280px) {
                section {
                    padding: 0;
                }

                section:first-child {
                    padding-top: 15px;
                }

                .caption h2 {
                    font-size: 15px;
                }

                .content {
                    grid-column: 2;
                    display: grid;
                }
            }

            /* Efek Hover pada Kartu */
            .featured-news-item {
                transition: transform 0.3s ease, box-shadow 0.3s ease;
            }

            .featured-news-item:hover {
                transform: translateY(-5px);
                box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.15);
            }

            /* Gambar Hover Efek */
            .featured-news-image img {
                transition: transform 0.3s ease;
            }

            .featured-news-image:hover img {
                transform: scale(1.05);
            }

            /* Efek pada Caption */
            .featured-news-image .caption {
                transition: background 0.3s ease;
            }

            .featured-news-image:hover .caption {
                background: rgba(39, 101, 186, 0.9);
            }

            #prevMonth,
            #nextMonth {
                width: 40px;
                height: 40px;
                border-radius: 50%;
                display: flex;
                justify-content: center;
                align-items: center;
            }

            #monthYearLabel {
                font-size: 1.2rem;
                font-weight: bold;
            }

            .table-header {
                background-color: #1a42a9;
                color: #fff !important;
                /* Memastikan warna teks putih */
                font-size: 14px;
                text-transform: capitalize;
            }
        </style>
        <section class="inner-page pt-3">
            <div class="container">
                <div class="section-title" data-aos="fade-up" style="padding-bottom: 0px">
                    <h2>Data Dasar</h2>
                    <p>{{ $datasetCount }} Rencana Terbit Ditemukan </p>
                </div>
                <div class="row" data-aos="fade-up">
                    <div class="col-md-12">
                        {{-- <hr class="mb-2" style="border: 2px solid;"> --}}
                    </div>
                    <div class="col-md-12">
                        <div class="row pt-5">
                            <div class="card border-0 shadow-lg">
                                <div class="card-body">
                                    <nav class="mt-3">
                                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                            <button
                                                class="nav-link fw-bolder @if (!app('request')->input('grafik') && !app('request')->input('peta')) active @endif"
                                                id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home"
                                                type="button" role="tab" aria-controls="nav-home" aria-selected="true">
                                                <i class="bi bi-table"></i> Bulan
                                            </button>
                                            <button class="nav-link fw-bolder" id="nav-list-tab" data-bs-toggle="tab"
                                                data-bs-target="#nav-list" type="button" role="tab"
                                                aria-controls="nav-list" aria-selected="false">
                                                <i class="bi bi-clipboard-data"></i> Tahunan
                                            </button>
                                            <button class="nav-link fw-bolder" id="nav-profile-tab" data-bs-toggle="tab"
                                                data-bs-target="#nav-profile" type="button" role="tab"
                                                aria-controls="nav-profile" aria-selected="false">
                                                <i class="bi bi-clipboard-check"></i> List
                                            </button>
                                        </div>
                                    </nav>

                                    <div class="tab-content mt-3">
                                        <!-- Tab Bulan -->
                                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel"
                                            aria-labelledby="nav-home-tab" tabindex="0">
                                            <div id="calendar" class="py-4"></div>
                                        </div>

                                        <!-- Tab Tahun (Tampilkan Tabel di sini) -->
                                        <div class="tab-pane fade" id="nav-profile" role="tabpanel"
                                            aria-labelledby="nav-profile-tab" tabindex="0">
                                            {{-- <div class="d-flex justify-content-between align-items-center">
                                                <button id="prevMonth" class="btn btn-outline-secondary">&lt;</button>
                                                <h3 id="monthYearLabel">
                                                    {{ Carbon\Carbon::createFromFormat('m', $month)->format('F') }}
                                                    {{ $year }}</h3>
                                                <button id="nextMonth" class="btn btn-outline-secondary">&gt;</button>
                                            </div> --}}

                                            <div class="d-flex justify-content-between align-items-center">
                                                <button id="prevYear" class="btn btn-outline-secondary">&lt;</button>
                                                <h3 id="yearLabel">{{ $year }}</h3> <!-- Tampilkan hanya tahun -->
                                                <button id="nextYear" class="btn btn-outline-secondary">&gt;</button>
                                            </div>
                                            <div class="table-responsive mt-3">
                                                <table class="table table-striped" id="table-1">
                                                    <thead class="text-white table-header">
                                                        <tr>
                                                            <th
                                                                style="background-color: #1a42a9; font-size:14px; text-transform: capitalize; color: #fff !important; vertical-align : middle;">
                                                                No</th>
                                                            <th
                                                                style="background-color: #1a42a9; font-size:14px; text-transform: capitalize; color: #fff !important; vertical-align : middle;">
                                                                Judul</th>
                                                            <th
                                                                style="background-color: #1a42a9; font-size:14px; text-transform: capitalize; color: #fff !important; vertical-align : middle;">
                                                                Nama OPD</th>
                                                            <th
                                                                style="background-color: #1a42a9; font-size:14px; text-transform: capitalize; color: #fff !important; vertical-align : middle;">
                                                                Tangal Rilis</th>
                                                            <th
                                                                style="background-color: #1a42a9; font-size:14px; text-transform: capitalize; color: #fff !important; vertical-align : middle;">
                                                                Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse($getMonth as $event)
                                                            <tr onclick="window.location.href='{{ url('web-datasets/' . $event->id . '/' . Str::slug($event->judul)) }}';"
                                                                style="cursor: pointer;">
                                                                <td style="width: 1%; text-align: center;">
                                                                    {{ $loop->iteration }}</td>
                                                                <td>{{ $event->judul }}</td>
                                                                <td>{{ $event->nama_opd }}</td>
                                                                <td>{{ $event->created_at->format('d-m-Y') }}</td>
                                                                <td>{{ $event->status }}</td>
                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="4" class="text-center">No data available in
                                                                    table</td>
                                                            </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <!-- Tab List -->
                                        <div class="tab-pane fade" id="nav-list" role="tabpanel"
                                            aria-labelledby="nav-list-tab" tabindex="0">
                                            <h1>Data Tahunan </h1>
                                            <p>Rencana Rilis Metadataset.</p>
                                            {{-- <div class="d-flex justify-content-between align-items-center">
                                                <button id="prevYear" class="btn btn-outline-secondary">&lt;</button>
                                                <h3 id="yearLabel">{{ $year }}</h3> <!-- Tampilkan hanya tahun -->
                                                <button id="nextYear" class="btn btn-outline-secondary">&gt;</button>
                                            </div> --}}
                                            <div class="table-responsive mt-3">
                                                <table class="table table-striped" id="table-2">
                                                    <thead class="text-white table-header">
                                                        <tr>
                                                            <th
                                                                style="background-color: #1a42a9; font-size:14px; text-transform: capitalize; color: #fff !important; vertical-align : middle;">
                                                                No</th>
                                                            <th
                                                                style="background-color: #1a42a9; font-size:14px; text-transform: capitalize; color: #fff !important; vertical-align : middle;">
                                                                Judul</th>
                                                            <th
                                                                style="background-color: #1a42a9; font-size:14px; text-transform: capitalize; color: #fff !important; vertical-align : middle;">
                                                                Jan</th>
                                                            <th
                                                                style="background-color: #1a42a9; font-size:14px; text-transform: capitalize; color: #fff !important; vertical-align : middle;">
                                                                Feb</th>
                                                            <th
                                                                style="background-color: #1a42a9; font-size:14px; text-transform: capitalize; color: #fff !important; vertical-align : middle;">
                                                                Mar</th>
                                                            <th
                                                                style="background-color: #1a42a9; font-size:14px; text-transform: capitalize; color: #fff !important; vertical-align : middle;">
                                                                Apr</th>
                                                            <th
                                                                style="background-color: #1a42a9; font-size:14px; text-transform: capitalize; color: #fff !important; vertical-align : middle;">
                                                                Mei</th>
                                                            <th
                                                                style="background-color: #1a42a9; font-size:14px; text-transform: capitalize; color: #fff !important; vertical-align : middle;">
                                                                Jun</th>
                                                            <th
                                                                style="background-color: #1a42a9; font-size:14px; text-transform: capitalize; color: #fff !important; vertical-align : middle;">
                                                                Jul</th>
                                                            <th
                                                                style="background-color: #1a42a9; font-size:14px; text-transform: capitalize; color: #fff !important; vertical-align : middle;">
                                                                Agu</th>
                                                            <th
                                                                style="background-color: #1a42a9; font-size:14px; text-transform: capitalize; color: #fff !important; vertical-align : middle;">
                                                                Sep</th>
                                                            <th
                                                                style="background-color: #1a42a9; font-size:14px; text-transform: capitalize; color: #fff !important; vertical-align : middle;">
                                                                Okt</th>
                                                            <th
                                                                style="background-color: #1a42a9; font-size:14px; text-transform: capitalize; color: #fff !important; vertical-align : middle;">
                                                                Nov</th>
                                                            <th
                                                                style="background-color: #1a42a9; font-size:14px; text-transform: capitalize; color: #fff !important; vertical-align : middle;">
                                                                Des</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($jadwal_rilis as $no => $ds)
                                                            <tr>
                                                                <td class="text-center">{{ $no + 1 }}</td>
                                                                <td style="min-width: 200px;">{{ $ds->judul }}</td>

                                                                @for ($m = 1; $m <= 12; $m++)
                                                                    @php
                                                                        // 1. Ubah angka $m menjadi nama bulan bahasa Indonesia sesuai database
                                                                        $namaBulan = [
                                                                            1 => 'Januari',
                                                                            2 => 'Februari',
                                                                            3 => 'Maret',
                                                                            4 => 'April',
                                                                            5 => 'Mei',
                                                                            6 => 'Juni',
                                                                            7 => 'Juli',
                                                                            8 => 'Agustus',
                                                                            9 => 'September',
                                                                            10 => 'Oktober',
                                                                            11 => 'November',
                                                                            12 => 'Desember',
                                                                        ][$m];

                                                                        // 2. Cari data agenda berdasarkan datasets_id DAN nama bulan
                                                                        $dataBulan = null;
                                                                        if (isset($detail_agenda[$ds->id])) {
                                                                            // Sekarang kita mencari kecocokan dengan Nama Bulan (string)
                                                                            $dataBulan = $detail_agenda[
                                                                                $ds->id
                                                                            ]->firstWhere('bulan', $namaBulan);
                                                                        }
                                                                    @endphp
                                                                    <td class="text-center"
                                                                        style="vertical-align: middle;">
                                                                        @if ($dataBulan)
                                                                            @if ($dataBulan->status == 1)
                                                                                {{-- STATUS 1: Link Aktif sesuai format yang Anda minta --}}
                                                                                <a href="{{ url('web-agenda/' . $dataBulan->id . '/' . Str::slug($ds->judul)) }}"
                                                                                    style="font-size: 14px; font-weight: 700; color: #1a42a9; text-decoration: underline;">
                                                                                    {{ $dataBulan->tanggal }}
                                                                                </a>
                                                                            @else
                                                                                {{-- STATUS 0: Teks Biasa (Hitam) --}}
                                                                                <span
                                                                                    style="font-size: 14px; font-weight: 500; color: #000;">
                                                                                    {{ $dataBulan->tanggal }}
                                                                                </span>
                                                                            @endif
                                                                        @else
                                                                            {{-- KOSONG --}}
                                                                            <span style="opacity: 0.2;">-</span>
                                                                        @endif
                                                                    </td>
                                                                @endfor
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
                    </div>
                </div>
        </section>
    </main>
    <!-- End #main -->
    <!-- modal kalender -->
    <div id="calendarModal" class="modal fade" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header px-5">
                    <div class="fs-3" id="modalDate"></div>
                </div>
                <div id="modalBody" class="modal-body px-5">
                    <div class="d-flex">
                        <div class="fs-7 pe-1 text-secondary">Terdapat</div>
                        <div class="fw-semibold fs-7" id="modaltitle"></div>
                    </div>
                    <div class="row pb-4 align-items-center">
                        <div class="col-lg-12 py-4" style="height: 400px; overflow-y: auto">
                            <ul class="events" id="eventList">
                                <!-- List of events will be dynamically added here -->
                            </ul>
                        </div>
                        <div class="col-lg-6"></div>
                    </div>
                    <div class="text-left pb-3">
                        <button type="button" class="btn btn-primary px-4 py-1" data-bs-dismiss="modal">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.19/index.global.min.js'></script>


<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            locale: 'id',
            initialView: 'dayGridMonth',
            timeZone: 'local',
            navLinks: true,
            selectable: true,
            selectMirror: true,
            editable: true,
            dayMaxEvents: true,

            // Sumber event awal dari Controller index
            eventSources: [{
                events: @json($events),
                textColor: '#fff',
                color: '#0054e6',
                eventDataTransform: function(eventData) {
                    // Tetap menggunakan logika hitung rilis Anda
                    const count = eventData.title.split(' ')[0];
                    return {
                        ...eventData,
                        title: count + ' Rilis Data'
                    };
                },
            }],

            eventClick: function(arg) {
                var dateObj = arg.event.start;
                var year = dateObj.getFullYear();
                var month = ('0' + (dateObj.getMonth() + 1)).slice(-2);
                var day = ('0' + dateObj.getDate()).slice(-2);

                var dateClicked = year + '-' + month + '-' + day;
                var dateClickedJudul = day + '/' + month + '/' + year;

                $.ajax({
                    url: '{{ route('getEventDetails') }}',
                    type: 'GET',
                    data: {
                        date: dateClicked
                    },
                    success: function(response) {
                        $('#modalDate').text('Tanggal Rilis: ' + dateClickedJudul);
                        $('#modaltitle').text(response.length + ' Rilis Data');
                        $('#eventList').empty();

                        response.forEach(function(event, index) {
                            let displayJudul = event.display_judul;
                            let displayStatus = event.display_status;

                            let cleanSlug = displayJudul.toLowerCase()
                                .replace(/[^a-z0-9]/g, '-')
                                .replace(/-+/g, '-')
                                .replace(/^-|-$/g, '');
                            let urlFriendlyText = encodeURIComponent(cleanSlug);

                            let finalUrl = "#";
                            let isLink = false;

                            // KONDISI DIPERBAIKI: 
                            // Izinkan link jika statusnya 'PUBLIK' ATAU 'APPROVED'
                            if (displayStatus === 'PUBLIK' || displayStatus ===
                                'APPROVED') {
                                isLink = true;
                                if (parseInt(event.is_agenda) === 1) {
                                    finalUrl = "{{ url('web-agenda') }}/" +
                                        event.agenda_id + "/" + urlFriendlyText;
                                } else {
                                    finalUrl = "{{ url('web-datasets') }}/" +
                                        event.id + "/" + urlFriendlyText;
                                }
                            }

                            // Template judul: Jika isLink true pakai <a>, jika tidak pakai <span>
                            let judulTemplate = isLink ?
                                `<a class="fw-bold text-capitalize" href="${finalUrl}">${displayJudul}</a>` :
                                `<span class="fw-bold text-capitalize text-secondary">${displayJudul}</span>`;

                            $('#eventList').append(`
                                <li>
                                    <div class="time fs-7 text-secondary fw-bold">${index + 1}.</div> 
                                    <div class="isi">
                                        <div class="border border-primary rounded bg-primary bg-opacity-10 p-2">
                                            <div class="fs-7 text-primary fw-semibold pb-1">
                                                <small class="text-uppercase" style="font-size: 0.65rem;">
                                                    ${parseInt(event.is_agenda) === 1 ? 'Agenda Rilis' : 'Update Dataset'}
                                                </small>
                                            </div>
                                            <div class="fs-7 text-primary fw-semibold pb-2">
                                                ${judulTemplate} 
                                            </div>
                                            <span class="badge text-bg-primary fw-light text-primary">${displayStatus}</span>
                                            <div class="d-flex align-items-center justify-content-between pt-2">
                                                <div class="fs-7 text-primary">${event.nama_opd}</div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            `);
                        });
                        $('#calendarModal').modal('show');
                    }
                });
            },
            views: {
                dayGridMonth: {
                    dayHeaderFormat: {
                        weekday: 'long'
                    }
                }
            }
        });

        calendar.render();

        // Listener DatesSet untuk Next/Prev
        calendar.on('datesSet', function(info) {
            var currentMonth = info.view.currentStart.getMonth() + 1;
            var currentYear = info.view.currentStart.getFullYear();

            $.ajax({
                url: '{{ route('getEventsByMonth') }}', // Pastikan method ini pakai logic COUNT(DISTINCT)
                type: 'GET',
                data: {
                    month: currentMonth,
                    year: currentYear
                },
                success: function(data) {
                    // Hapus sumber lama agar tidak tumpang tindih
                    calendar.getEventSources().forEach(source => source.remove());

                    // Tambahkan data baru dengan format yang Anda inginkan
                    calendar.addEventSource({
                        events: data.map(event => ({
                            ...event,
                            title: event.total +
                                ' Rilis Data' // Mengambil jumlah asli dari server
                        })),
                        textColor: '#fff',
                        color: '#0054e6',
                    });
                }
            });
        });
    });

    $(document).ready(function() {
        var currentYear = {{ $year }}; // Mengambil tahun yang diterima dari controller

        // Fungsi untuk memperbarui tampilan tahun
        function updateYearDisplay() {
            $('#yearLabel').text(currentYear); // Menampilkan tahun
        }

        function fetchAgenda(year) {
            $.ajax({
                url: '/publikasi/agenda',
                method: 'GET',
                data: {
                    year: year
                },
                success: function(response) {
                    // console.log(response);

                    // jika DataTable sudah inisialisasi, destroy dulu
                    if ($.fn.dataTable.isDataTable('#table-1')) {
                        $('#table-1').DataTable().clear().destroy();
                    }

                    // bangun HTML tbody dari response (misal response.data)
                    let tableData = '';
                    let i = 1;
                    (response.data || []).forEach(function(ev) {
                        // Membuat URL yang dinamis dengan format yang sudah diubah
                        let text = ev.judul
                            .replace(/[^a-zA-Z0-9]+/g,
                                '-') // Mengganti karakter non-alfanumerik dengan -
                            .replace(/-+/g, '-') // Menghapus pengulangan -
                            .toLowerCase(); // Menjadikan huruf kecil

                        // Encode string untuk URL
                        let urlFriendlyText = encodeURIComponent(text);

                        // Bangun URL dinamis menggunakan JavaScript
                        let url = "{{ url('web-datasets') }}/" + ev.id + "/" +
                            urlFriendlyText;

                        // Menambahkan baris tabel yang dapat diklik
                        tableData += '<tr onclick="window.location.href=\'' + url +
                            '\';" style="cursor: pointer;">';
                        tableData += '<td style="width: 1%; text-align: center;">' + i++ +
                            '</td>';
                        tableData += '<td>' + (ev.judul || '') + '</td>';
                        tableData += '<td>' + (ev.nama_opd || '') + '</td>';
                        tableData += '<td>' + (ev.created_at || '') + '</td>';
                        tableData += '<td>' + (ev.status || '') + '</td>';
                        tableData += '</tr>';
                    });



                    // masukkan HTML ke tbody
                    $('#table-1 tbody').html(tableData);
                    $('#yearLabel').html(year);

                    // inisialisasi DataTable baru setelah HTML dimasukkan
                    $('#table-1').DataTable({
                        paging: true,
                        searching: true,
                        ordering: true,
                        info: true
                    });
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }


        // Fungsi untuk mundur satu tahun
        $('#prevYear').click(function() {
            currentYear--; // Kurangi tahun satu
            fetchAgenda(currentYear);
        });

        // Fungsi untuk maju satu tahun
        $('#nextYear').click(function() {
            currentYear++; // Tambah tahun satu
            fetchAgenda(currentYear);
        });

        // Memperbarui tampilan awal
        updateYearDisplay();
    });
</script>
