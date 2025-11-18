<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Export Excell</title>
</head>

<?php
header('Content-type: application/vnd-ms-excel');
header('Content-Disposition: attachment; filename=donwload.xls');
?>

<body>
    <div class="table-responsive">
        <table class="table table-striped" id="table-1">
            <thead>
                <tr>
                    <?php
                    $kode_kab_kota = false;
                    $kode_kec = false;
                    $kode_keldes = false;
                    ?>
                    @for ($i = 0; $i < count($table); $i++)
                        @if ($table[$i] == 'id')
                            <Th>NO</Th>
                        @elseif($table[$i] == 'KODE KABUPATEN/KOTA')
                            <?php $kode_kab_kota = $i; ?>
                            <th>KODE KABUPATEN/KOTA </th>
                            <th>NAMA KABUPATEN/KOTA</th>
                        @elseif($table[$i] == 'KODE KECAMATAN')
                            <?php $kode_kec = $i; ?>
                            <th>KODE KECAMATAN </th>
                            <th>NAMA KECAMATAN</th>
                        @elseif($table[$i] == 'KODE KELURAHAN/DESA')
                            <?php $kode_keldes = $i; ?>
                            <th>KODE KELURAHAN </th>
                            <th>NAMA DESA</th>
                        @else
                            <th>{{ $table[$i] }}</th>
                        @endif
                    @endfor
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                    <tr>
                        @for ($i = 0; $i < count($table); $i++)
                            @if ($kode_kab_kota == $i && $kode_kab_kota != false)
                                @php
                                    $wilayah = App\Http\Controllers\WebController\WilayahController::wilayah($item[$table[$i]]);
                                @endphp
                                <td>{{ $wilayah->kode ?? '-' }}</td>
                                <td>{{ $wilayah->nama ?? '-' }}</td>
                            @elseif($kode_kec == $i && $kode_kec != false)
                                @php
                                    $wilayah = App\Http\Controllers\WebController\WilayahController::wilayah($item[$table[$i]]);
                                @endphp
                                <td>{{ $wilayah->kode ?? '-' }}</td>
                                <td>{{ $wilayah->nama ?? '-' }}</td>
                            @elseif($kode_keldes == $i && $kode_keldes != false)
                                @php
                                    $wilayah = App\Http\Controllers\WebController\WilayahController::wilayah($item[$table[$i]]);
                                @endphp
                                <td>{{ $wilayah->kode ?? '-' }}</td>
                                <td>{{ $wilayah->nama ?? '-' }}</td>
                            @else
                                <td>{{ $item[$table[$i]] }}</td>
                            @endif
                        @endfor
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>
