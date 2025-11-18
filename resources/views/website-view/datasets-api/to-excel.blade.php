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
                    @for ($i = 0; $i < count($datasets['table']['header']); $i++)
                        @if ($datasets['table']['header'][$i] == 'id')
                            <Th>id</Th>
                        @elseif($datasets['table']['header'][$i] == 'kode_kabupaten_kota')
                            <?php $kode_kab_kota = $i; ?>
                            <th>kode_kabupaten_kota</th>
                            <th>nama_kabupaten_kota</th>
                        @elseif($datasets['table']['header'][$i] == 'kode_kecamatan')
                            <?php $kode_kec = $i; ?>
                            <th>kode_kecamatan</th>
                            <th>nama_kecamatan</th>
                        @elseif($datasets['table']['header'][$i] == 'kode_kelurahan_desa')
                            <?php $kode_keldes = $i; ?>
                            <th>kode_kelurahan_desa </th>
                            <th>nama_kelurahan_desa</th>
                        @else
                            <th>{{ $datasets['table']['header'][$i] }}</th>
                        @endif
                    @endfor
                </tr>
            </thead>
            <tbody>
                @foreach ($values as $row)
                    <tr>
                        @foreach ($row as $index => $column)
                            @if ($kode_kab_kota == $index && $kode_kab_kota !== false)
                                @php
                                    $wilayah = App\Http\Controllers\WebController\WilayahController::wilayah($column);
                                @endphp
                                <td>{{ $wilayah->kode ?? '-' }}</td>
                                <td>{{ $wilayah->nama ?? '-' }}</td>
                            @elseif ($kode_kec == $index && $kode_kec !== false)
                                @php
                                    $wilayah = App\Http\Controllers\WebController\WilayahController::wilayah($column);
                                @endphp
                                <td>{{ $wilayah->kode ?? '-' }}</td>
                                <td>{{ $wilayah->nama ?? '-' }}</td>
                            @elseif ($kode_keldes == $index && $kode_keldes !== false)
                                @php
                                    $wilayah = App\Http\Controllers\WebController\WilayahController::wilayah($column);
                                @endphp
                                <td>{{ $wilayah->kode ?? '-' }}</td>
                                <td>{{ $wilayah->nama ?? '-' }}</td>
                            @else
                                <td>{{ $column }}</td>
                            @endif
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>
