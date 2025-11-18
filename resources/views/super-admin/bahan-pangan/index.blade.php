@extends('super-admin/layout/layout')
@section('title', 'Bahan Pangan')
@section('main')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Bahan Pangan</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Bahan Pangan</a></div>
                    <div class="breadcrumb-item">Tabel Bahan Pangan</div>
                </div>
            </div>

            <div class="section-body">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <h2 class="section-title">Bahan Pangan</h2>
                <p class="section-lead">
                    Ini adalah halaman Bahan Pangan Jambi data dan Analitik Center.
                </p>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4>Daftar Bahan Pangan</h4>
                                <a href="#" class="btn btn-primary" data-toggle="modal"
                                    data-target="#addBahanPanganModal">
                                    <i class="fa fa-plus"></i> Tambah Bahan Pangan
                                </a>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('pangan.massDelete') }}" method="POST" id="deleteForm">
                                    @csrf
                                    @method('DELETE')

                                    <div class="table-responsive">
                                        <table class="table table-striped" id="table-1">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">
                                                        <input type="checkbox" id="select-all"> <!-- Select all checkbox -->
                                                    </th>
                                                    <th>No</th>
                                                    <th>Kabupaten/Kota</th>
                                                    <th>Komoditas</th>
                                                    <th>Harga</th>
                                                    <th>Tanggal Survey</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($pangan as $item)
                                                    <tr>
                                                        <td>
                                                            <input type="checkbox" name="ids[]"
                                                                value="{{ $item->id }}"> <!-- Checkbox for each row -->
                                                        </td>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $item->nama_kabupaten_kota }}</td>
                                                        <td>{{ $item->nama_komoditas }}</td>
                                                        <td>{{ $item->harga }}</td>
                                                        <td>{{ $item->tanggal_survey }}</td>
                                                        <td>
                                                            <!-- Edit Button -->
                                                            <a href="#" class="btn btn-info editButton"
                                                                data-id="{{ $item->id }}" data-toggle="modal"
                                                                data-target="#editBahanPanganModal">
                                                                <i class="fa fa-edit"></i> Edit
                                                            </a>

                                                            {{-- <!-- Individual Delete Button (Optional) -->
                                                            <a href="#" class="btn btn-danger"
                                                                data-confirm-delete="true">Delete</a> --}}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    <button type="submit" class="btn btn-danger">Delete Selected</button>
                                    <!-- Button to delete selected rows -->
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
        document.getElementById('select-all').addEventListener('click', function(event) {
            const checkboxes = document.querySelectorAll('input[name="ids[]"]');
            checkboxes.forEach(checkbox => {
                checkbox.checked = event.target.checked;
            });
        });

        // Trigger the edit modal with data preloaded
        // Trigger the edit modal with data preloaded
        $(document).on('click', '.editButton', function() {
            const itemId = $(this).data('id'); // Get the ID from the data-id attribute

            $.ajax({
                url: `/pangan/${itemId}/edit`, // Route to get item details
                method: 'GET',
                success: function(data) {
                    // Populate modal fields with the data from the server
                    $('#editKabupatenKota').val(data.id_kabupaten_kota).trigger(
                        'change'); // Set ID and trigger change for select2
                    $('#editKomoditas').val(data.id_komoditas).trigger('change');
                    $('#editHarga').val(data.harga);
                    $('#editTanggalSurvey').val(data.tanggal_survey);

                    // Update the form action dynamically
                    $('#editForm').attr('action', `/pangan/${itemId}`);

                    // Show the modal with pre-filled data
                    $('#editBahanPanganModal').modal('show');
                },
                error: function() {
                    alert("Failed to fetch data for editing.");
                }
            });
        });
    </script>

    <!-- Add Bahan Pangan Modal Structure -->
    <div class="modal fade" id="addBahanPanganModal" tabindex="-1" role="dialog" aria-labelledby="addBahanPanganLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addBahanPanganLabel">Tambah Bahan Pangan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('pangan.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <!-- File upload input for CSV -->
                        <div class="mb-3">
                            <label for="csvFile" class="form-label">Upload CSV</label>
                            <input type="file" class="form-control" id="csvFile" name="csv_file" accept=".csv"
                                required>
                        </div>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Bahan Pangan Modal Structure -->
    <div class="modal fade" id="editBahanPanganModal" tabindex="-1" role="dialog" aria-labelledby="editBahanPanganLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editBahanPanganLabel">Edit Bahan Pangan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editForm" action="{{ route('pangan.update', ':id') }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <!-- Kabupaten/Kota Dropdown -->
                        <div class="form-group mb-3">
                            <div class="col-md-12" style="padding-left: 0px">
                                <label for="editKabupatenKota" class="form-label">Kabupaten/Kota</label>
                            </div>
                            <select name="id_kabupaten_kota" id="editKabupatenKota"
                                class="form-control @error('id_kabupaten_kota') is-invalid @enderror select2"
                                style="width: 100%" required>
                                <option selected disabled>=== Pilih Salah Satu ===</option>
                                @foreach ($kabupatens as $kabupaten)
                                    <option value="{{ $kabupaten->id }}"
                                        {{ old('id_kabupaten_kota') == $kabupaten->id ? 'selected' : '' }}>
                                        {{ $kabupaten->nama_kabupaten_kota }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_kabupaten_kota')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Komoditas Dropdown -->
                        <div class="form-group mb-3">
                            <div class="col-md-12" style="padding-left: 0px">
                                <label for="editKomoditas" class="form-label">Komoditas</label>
                            </div>
                            <select name="id_komoditas" id="editKomoditas"
                                class="form-control @error('id_komoditas') is-invalid @enderror select2"
                                style="width: 100%" required>
                                <option selected disabled>=== Pilih Salah Satu ===</option>
                                @foreach ($komoditas as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('id_komoditas') == $item->id ? 'selected' : '' }}>
                                        {{ $item->nama_komoditas }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_komoditas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Harga Input -->
                        <div class="mb-3">
                            <label for="editHarga" class="form-label">Harga</label>
                            <input type="number" class="form-control" id="editHarga" name="harga" required>
                        </div>

                        <!-- Tanggal Survey Input -->
                        <div class="mb-3">
                            <label for="editTanggalSurvey" class="form-label">Tanggal Survey</label>
                            <input type="date" class="form-control" id="editTanggalSurvey" name="tanggal_survey"
                                required>
                        </div>

                        <!-- Save Button -->
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>

            </div>
        </div>
    </div>

@endsection
