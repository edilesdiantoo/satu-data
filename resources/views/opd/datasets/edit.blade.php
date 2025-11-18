@extends('opd/layout/layout')
@section('title', 'Form Edit Datasets')
@section('main')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit Datasets</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Datasets</a></div>
                    <div class="breadcrumb-item"><a href="#">Edit Datasets</a></div>
                    <div class="breadcrumb-item">Form Edit Datasets</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Form Edit Datasets</h2>
                <p class="section-lead">Ini adalah halaman untuk Mengubah Datasets kedalam sistem.</p>
                <div class="row">
                    @if ($datasets->status == 'REPAIR')
                        <div class="col-md-12">
                            <div class="alert alert-warning alert-has-icon">
                                <div class="alert-icon"><i class="fa fa-info-circle"></i></div>
                                <div class="alert-body">
                                    <div class="alert-title">Alasan Datasets Butuh Perbaikan</div>
                                    {{ $datasets->alasan }}
                                </div>
                            </div>
                        </div>
                    @elseif($datasets->status == 'REJECTED')
                        <div class="col-md-12">
                            <div class="alert alert-danger alert-has-icon">
                                <div class="alert-icon"><i class="fa fa-info-circle"></i></div>
                                <div class="alert-body">
                                    <div class="alert-title">Alasan Datasets Ditolak</div>
                                    {{ $datasets->alasan }}
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="col-12 col-md-12 col-lg-12">
                        <form action="{{ route('opddatasets.update', $datasets->id) }}" enctype="multipart/form-data"
                            runat="server" method="post">
                            @csrf
                            @method('patch')
                            <div class="card">
                                <div class="card-header">
                                    <h4>Edit Data</h4>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Judul</label>
                                        <input type="text" name="judul"
                                            class="form-control @error('judul')is-invalid @enderror"
                                            value="{{ $datasets->judul }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Nama OPD</label>
                                        <select name="nama_opd"
                                            class="form-control @error('nama_opd')is-invalid @enderror select2 ">
                                            <option disabled>=== Pilih Salah Satu ===</option>
                                            @foreach ($opd as $item)
                                                <option value="{{ $item->nama_opd }}"
                                                    {{ $datasets->nama_opd == $item->nama_opd ? 'selected' : '' }}>
                                                    {{ $item->nama_opd }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Diupload Oleh</label>
                                        <input type="text" name="diupload_oleh"
                                            class="form-control @error('diupload_oleh')is-invalid @enderror"
                                            value="{{ $users->name }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Tahun Datasets</label>
                                        <select name="tahun_datasets"
                                            class="form-control @error('tahun_datasets')is-invalid @enderror select2 ">
                                            <option disabled>=== Pilih Salah Satu ===</option>
                                            @for ($i = 1980; $i <= date('Y'); $i++)
                                                <option value="{{ $i }}"
                                                    {{ $datasets->tahun_datasets == $i ? 'selected' : '' }}>
                                                    {{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Kategori Datasets</label>
                                        <select name="sektor"
                                            class="form-control @error('sektor')is-invalid @enderror select2 ">
                                            <option selected disabled>=== Pilih Salah Satu ===</option>
                                            @foreach ($main_sektor as $item_main)
                                                <optgroup label="{{ $item_main->main_sektor }}">
                                                    @foreach ($sektor as $item)
                                                        @if ($item_main->id == $item->id_main_sektor)
                                                            <option value="{{ $item->id }}"
                                                                {{ old('sektor', $datasets->sektor) == $item->id ? 'selected' : '' }}>
                                                                {{ $item->nama_sektor }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </optgroup>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Deskripsi</label>
                                        <textarea class="summernote form-control @error('deskripsi')is-invalid @enderror" name="deskripsi"
                                            style="height: 127px;">{{ $datasets->deskripsi }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Tag</label>
                                        <input class="form-control" type="text" data-role="tagsinput" name="tags"
                                            value="{{ $datasets->tags }}">
                                        @if ($errors->has('tags'))
                                            <span class="text-danger">{{ $errors->first('tags') }}
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label>Sifat Datasets</label>
                                        <select name="sifat_datasets" onchange="yesnoCheck(this);"
                                            class="form-control @error('sifat_datasets')is-invalid @enderror select2 ">
                                            <option selected disabled>=== Pilih Salah Satu ===</option>
                                            <option value="PUBLIK"
                                                {{ $datasets->sifat_datasets == 'PUBLIK' ? 'selected' : '' }}>Publik
                                            </option>
                                            <option value="RAHASIA"
                                                {{ $datasets->sifat_datasets == 'RAHASIA' ? 'selected' : '' }}>
                                                Private</option>
                                            <option value="DIBAGIKAN"
                                                {{ $datasets->sifat_datasets == 'DIBAGIKAN' ? 'selected' : '' }}>
                                                Dibagikan</option>
                                        </select>
                                    </div>
                                    <script>
                                        function yesnoCheck(that) {
                                            if (that.value == "DIBAGIKAN") {
                                                alert("Input Instansi yang ingin diberikan !");
                                                document.getElementById("instansi").style.display = "block";
                                            } else {
                                                document.getElementById("instansi").style.display = "none";
                                            }
                                        }
                                    </script>
                                    <script type="text/javascript">
                                        function selects() {
                                            var ele = document.getElementsByName('id_instansi[]');
                                            for (var i = 0; i < ele.length; i++) {
                                                if (ele[i].type == 'checkbox')
                                                    ele[i].checked = true;
                                            }
                                        }

                                        function deSelect() {
                                            var ele = document.getElementsByName('id_instansi[]');
                                            for (var i = 0; i < ele.length; i++) {
                                                if (ele[i].type == 'checkbox')
                                                    ele[i].checked = false;
                                            }
                                        }
                                    </script>
                                    <div id="instansi"
                                        style="display: @if ($datasets->sifat_datasets == 'DIBAGIKAN') block @else none @endif;">
                                        <div class="form-group">
                                            <label>Pilih Instansi</label>
                                            <div class="row mb-3 container">
                                                @foreach ($opd as $item)
                                                    <div class="col-md-4">
                                                        @if ($item->id != Auth::user()->id)
                                                            <input type="checkbox" class="form-check-input"
                                                                name="id_instansi[]" value="{{ $item->id }}"
                                                                @if ($datasets->sifat_datasets == 'DIBAGIKAN') {{ App\Http\Controllers\Admin\DatasetsController::checked_instansi($datasets->id, $item->id) }} @endif>{{ $item->nama_opd }}<br>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                            <input type="button" onclick='selects()' value="Select All" />
                                            <input type="button" onclick='deSelect()' value="Deselect All" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>DB Datasets</label>
                                        <input type="text" class="form-control @error('db_datasets')is-invalid @enderror"
                                            value="{{ $datasets->db_datasets }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <h4>Input Metadata</h4>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Pengukuran Datasets</label>
                                        <input type="text" name="pengukuran_datasets"
                                            class="form-control @error('pengukuran_datasets')is-invalid @enderror"
                                            value="{{ old('pengukuran_datasets', $metadata->pengukuran_datasets ?? '-') }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Tingkat Penyajian Datasets</label>
                                        <input type="text" name="tingkat_penyajian_datasets"
                                            class="form-control @error('tingkat_penyajian_datasets')is-invalid @enderror"
                                            value="{{ old('tingkat_penyajian_datasets', $metadata->tingkat_penyajian_datasets ?? '-') }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Cakupan Datasets</label>
                                        <input type="text" name="cakupan_datasets"
                                            class="form-control @error('cakupan_datasets')is-invalid @enderror"
                                            value="{{ old('cakupan_datasets', $metadata->cakupan_datasets ?? '-') }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Bidang</label>
                                        <input type="text" name="bidang"
                                            class="form-control @error('bidang')is-invalid @enderror"
                                            value="{{ old('bidang', $metadata->bidang ?? '-') }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Penanggung Jawab</label>
                                        <input type="text" name="penanggung_jawab"
                                            class="form-control @error('penanggung_jawab')is-invalid @enderror"
                                            value="{{ old('penanggung_jawab', $metadata->penanggung_jawab ?? '-') }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Kontak Produsen</label>
                                        <input type="text" name="kontak_produsen"
                                            class="form-control @error('kontak_produsen')is-invalid @enderror"
                                            value="{{ old('kontak_produsen', $metadata->kontak_produsen ?? '-') }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Kode Indikator</label>
                                        <input type="text" name="kode_indikator"
                                            class="form-control @error('kode_indikator')is-invalid @enderror"
                                            value="{{ old('kode_indikator', $metadata->kode_indikator ?? '-') }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Bidang Urusan</label>
                                        <input type="text" name="bidang_urusan"
                                            class="form-control @error('bidang_urusan')is-invalid @enderror"
                                            value="{{ old('bidang_urusan', $metadata->bidang_urusan ?? '-') }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Satuan Datasets</label>
                                        <input type="text" name="satuan_datasets"
                                            class="form-control @error('satuan_datasets')is-invalid @enderror"
                                            value="{{ old('satuan_datasets', $metadata->satuan_datasets ?? '-') }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Frekuensi Datasets</label>
                                        <input type="text" name="frekuensi_datasets"
                                            class="form-control @error('frekuensi_datasets')is-invalid @enderror"
                                            value="{{ old('frekuensi_datasets', $metadata->frekuensi_datasets ?? '-') }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Dimensi Datasets</label>
                                        <input type="text" name="dimensi_datasets"
                                            class="form-control @error('dimensi_datasets')is-invalid @enderror"
                                            value="{{ old('dimensi_datasets', $metadata->dimensi_datasets ?? '-') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="metadata" class="form-label">Metadata</label>
                                        <input type="file" name="metadata" class="form-control" id="metadata"
                                            aria-describedby="metadatahelp" accept="application/pdf">
                                        <div id="metadatahelp" class="form-text">Upload Pdf: Ms-Kegiatan, Ms-Variabel
                                            dan
                                            Ms
                                            Indikator (dalam 1 file .Pdf). <a
                                                href="{{ asset('assets/metadata/' . $datasets->metadata ?? '-') }}">File
                                                Sebelumnya</a> </div>
                                    </div>
                                    <button class="btn btn-primary mt-3" type="submit">Simpan Perubahan Data</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
