@extends('opd/layout/layout')
@section('title', 'Form Tambah Datasets')
@section('main')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Tambah Datasets</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Datasets</a></div>
                    <div class="breadcrumb-item"><a href="#">Tambah Datasets</a></div>
                    <div class="breadcrumb-item">Form Tambah Datasets</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Form Tambah Datasets</h2>
                <p class="section-lead">Ini adalah halaman untuk menambahkan Datasets kedalam sistem.</p>
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <form action="{{ route('opddatasets.store') }}" runat="server" enctype="multipart/form-data"
                            method="post">
                            @csrf
                            <div class="card">
                                <div class="card-header">
                                    <h4>Input Data</h4>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Judul</label>
                                        <input type="text" name="judul"
                                            class="form-control @error('judul')is-invalid @enderror"
                                            value="{{ old('judul') }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Nama OPD</label>
                                        <select name="nama_opd"
                                            class="form-control @error('nama_opd')is-invalid @enderror select2" readonly>
                                            @foreach ($opd as $item)
                                                @if ($item->id == Auth::user()->id_opd)
                                                    <option value="{{ $item->nama_opd }}"
                                                        {{ old('nama_opd') == $item->nama_opd ? 'selected' : '' }} selected>
                                                        {{ $item->nama_opd }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Diupload Oleh</label>
                                        <input type="text" name="diupload_oleh"
                                            class="form-control @error('diupload_oleh')is-invalid @enderror"
                                            value="{{ Auth::user()->name }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Tahun Datasets</label>
                                        <select name="tahun_datasets"
                                            class="form-control @error('tahun_datasets')is-invalid @enderror select2 ">
                                            <option selected disabled>=== Pilih Salah Satu ===</option>
                                            @for ($i = 1980; $i <= date('Y'); $i++)
                                                <option value="{{ $i }}"
                                                    {{ old('tahun_datasets') == $i ? 'selected' : '' }}>
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
                                                                {{ old('sektor') == $item->id ? 'selected' : '' }}>
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
                                            style="height: 127px;">{{ old('deskripsi') }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Tag</label>
                                        <input class="form-control" type="text" data-role="tagsinput" name="tags">
                                        @if ($errors->has('tags'))
                                            <span class="text-danger">{{ $errors->first('tags') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label>Sifat Datasets</label>
                                        <select name="sifat_datasets" onchange="yesnoCheck(this);"
                                            class="form-control @error('sifat_datasets')is-invalid @enderror select2 ">
                                            <option selected disabled>=== Pilih Salah Satu ===</option>
                                            <option value="PUBLIK">Publik
                                            </option>
                                            <option value="RAHASIA">
                                                Private</option>
                                            <option value="DIBAGIKAN">
                                                Dibagikan</option>
                                        </select>
                                    </div>
                                    <script>
                                        function yesnoCheck(that) {
                                            if (that.value == "DIBAGIKAN") {
                                                alert("Input Instansi yang ingin diberikan !");
                                                document.getElementById("alasan").style.display = "block";
                                            } else {
                                                document.getElementById("alasan").style.display = "none";
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
                                    <div id="alasan" style="display: none;">
                                        <div class="form-group">
                                            <label>Pilih Instansi</label>
                                            <div class="row mb-3 container">
                                                @foreach ($opd as $item)
                                                    <div class="col-md-4">
                                                        @if ($item->id != Auth::user()->id)
                                                            <input type="checkbox" class="form-check-input"
                                                                name="id_instansi[]"
                                                                value="{{ $item->id }}">{{ $item->nama_opd }}<br>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                            <input type="button" onclick='selects()' value="Select All" />
                                            <input type="button" onclick='deSelect()' value="Deselect All" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleDataList" class="form-label">Nama Kolom</label>
                                        <div class="input-group control-group after-add-more">
                                            <input type="text" name="nama_kolom[]"
                                                class="form-control @error('nama_kolom')is-invalid @enderror"
                                                style="text-transform: lowercase">
                                            <div class="input-group-btn">
                                                <button class="btn btn-success add-more" type="button"><i
                                                        class="bi bi-plus"></i> Add</button>
                                            </div>
                                        </div>
                                        <!-- Copy Fields -->
                                        <div class="copy hide">
                                            <div class="control-group input-group" style="margin-top:10px">
                                                <input type="text" name="nama_kolom[]" class="form-control"
                                                    style="text-transform: lowercase">
                                                <div class="input-group-btn">
                                                    <button class="btn btn-danger remove" type="button"><i
                                                            class="glyphicon glyphicon-remove"></i> Remove</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div for="duration" class="form-text">Tentukan Banyaknya Kolom Didatabase dan.
                                            <span class="text-danger">Nama Kolom Tidak Boleh sama !</span>
                                        </div>
                                    </div>

                                    <script type="text/javascript">
                                        $(document).ready(function() {

                                            $(".add-more").click(function() {
                                                var html = $(".copy").html();
                                                $(".after-add-more").after(html);
                                            });

                                            $("body").on("click", ".remove", function() {
                                                $(this).parents(".control-group").remove();
                                            });

                                        });
                                    </script>
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
                                            value="{{ old('pengukuran_datasets') }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Tingkat Penyajian Datasets</label>
                                        <input type="text" name="tingkat_penyajian_datasets"
                                            class="form-control @error('tingkat_penyajian_datasets')is-invalid @enderror"
                                            value="{{ old('tingkat_penyajian_datasets') }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Cakupan Datasets</label>
                                        <input type="text" name="cakupan_datasets"
                                            class="form-control @error('cakupan_datasets')is-invalid @enderror"
                                            value="{{ old('cakupan_datasets') }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Bidang</label>
                                        <input type="text" name="bidang"
                                            class="form-control @error('bidang')is-invalid @enderror"
                                            value="{{ old('bidang') }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Penanggung Jawab</label>
                                        <input type="text" name="penanggung_jawab"
                                            class="form-control @error('penanggung_jawab')is-invalid @enderror"
                                            value="{{ old('penanggung_jawab') }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Kontak Produsen</label>
                                        <input type="text" name="kontak_produsen"
                                            class="form-control @error('kontak_produsen')is-invalid @enderror"
                                            value="{{ old('kontak_produsen') }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Kode Indikator</label>
                                        <input type="text" name="kode_indikator"
                                            class="form-control @error('kode_indikator')is-invalid @enderror"
                                            value="{{ old('kode_indikator') }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Bidang Urusan</label>
                                        <input type="text" name="bidang_urusan"
                                            class="form-control @error('bidang_urusan')is-invalid @enderror"
                                            value="{{ old('bidang_urusan') }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Satuan Datasets</label>
                                        <input type="text" name="satuan_datasets"
                                            class="form-control @error('satuan_datasets')is-invalid @enderror"
                                            value="{{ old('satuan_datasets') }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Frekuensi Datasets</label>
                                        <input type="text" name="frekuensi_datasets"
                                            class="form-control @error('frekuensi_datasets')is-invalid @enderror"
                                            value="{{ old('frekuensi_datasets') }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Dimensi Datasets</label>
                                        <input type="text" name="dimensi_datasets"
                                            class="form-control @error('dimensi_datasets')is-invalid @enderror"
                                            value="{{ old('dimensi_datasets') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="metadata" class="form-label">Metadata</label>
                                        <input type="file" name="metadata" class="form-control" id="metadata"
                                            aria-describedby="metadatahelp" accept="application/pdf">
                                        <div id="metadatahelp" class="form-text">Upload Pdf: Ms-Kegiatan, Ms-Variabel
                                            dan
                                            Ms
                                            Indikator (dalam 1 file .Pdf).</div>
                                    </div>
                                    <button class="btn btn-primary mt-3" type="submit">Tambah Data</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
