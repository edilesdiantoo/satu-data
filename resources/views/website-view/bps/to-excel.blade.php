<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Export BPS Excell</title>
</head>
<?php
header('Content-type: application/vnd-ms-excel');
header('Content-Disposition: attachment; filename=donwload_excell_bps.xls');
?>

<body>
    <div class="table-responsive">
        <style>
            thead {
                background-color: #1a1d94;
                color: white;
            }
        </style>
        <table class="table table-striped" id="table-1">
            <?php
            $idvariabel = $response['var'][0]['val'];
            $jumlahbaris = count($response['vervar']);
            $jumlahkarakteristik = count($response['turvar']);
            $jumlahtahun = count($response['tahun']);
            $jumlahturtahun = count($response['turtahun']);
            
            echo '<thead>';
            if ($jumlahturtahun == 1 && $jumlahkarakteristik == 1) {
                echo "<tr><th rowspan = '3'>" . $response['labelvervar'] . '</th></tr>';
                echo "<tr><th colspan='" . $jumlahtahun . "'>" . $response['var'][0]['label'] . '</th></tr>';
                echo '<tr>';
                for ($i = 0; $i < $jumlahtahun; $i++) {
                    echo '<th>' . $response['tahun'][$i]['label'] . '</th>';
                }
                echo '</tr>';
            } elseif (($jumlahturtahun > 1) & ($jumlahkarakteristik == 1)) {
                //Ada turunan tahun dan tidak ada karakteristik
                echo "<tr><th rowspan='4'>" . $response['labelvervar'] . '</th></tr>';
                echo "<tr><th colspan='" . $jumlahtahun * $jumlahturtahun . "'>" . $response['var'][0]['label'] . '</th></tr>';
                echo '<tr>';
                for ($i = 0; $i < $jumlahtahun; $i++) {
                    echo "<th colspan='" . $jumlahturtahun . "'>" . $response['tahun'][$i]['label'] . '</th>';
                }
                echo '</tr>';
                echo '<tr>';
                for ($i = 0; $i < $jumlahtahun; $i++) {
                    for ($j = 0; $j < $jumlahturtahun; $j++) {
                        echo '<th>' . $response['turtahun'][$j]['label'] . '</th>';
                    }
                }
                echo '</tr>';
            } elseif ($jumlahturtahun == 1 && $jumlahkarakteristik > 1) {
                //Tidak turnan tahun dan ada karakteristik
                echo "<tr><th rowspan='4'>" . $response['labelvervar'] . '</th></tr>';
                echo "<tr><th colspan='" . $jumlahkarakteristik * $jumlahtahun . "'>" . $response['var'][0]['label'] . '</th></tr>';
                echo '<tr>';
                for ($i = 0; $i < $jumlahkarakteristik; $i++) {
                    echo "<th colspan='" . $jumlahtahun . "'>" . $response['turvar'][$i]['label'] . '</th>';
                }
                echo '</tr>';
                echo '<tr>';
                for ($i = 0; $i < $jumlahkarakteristik; $i++) {
                    for ($j = 0; $j < $jumlahtahun; $j++) {
                        echo '<th>' . $response['tahun'][$j]['label'] . '</th>';
                    }
                }
                echo '</tr>';
            } elseif ($jumlahturtahun > 1 && $jumlahkarakteristik > 1) {
                //Ada turunan tahun dan ada karakteristik
                echo "<tr><th rowspan='5'>" . $response['labelvervar'] . '</th></tr>';
                echo "<tr><th colspan='" . $jumlahkarakteristik * $jumlahtahun * $jumlahturtahun . "'>" . $response['var'][0]['label'] . '</th></tr>';
                echo '<tr>';
                for ($i = 0; $i < $jumlahkarakteristik; $i++) {
                    echo "<th colspan ='" . $jumlahtahun * $jumlahturtahun . "'>" . $response['turvar'][$i]['label'] . '</th>';
                }
                echo '</tr>';
                echo '<tr>';
                for ($i = 0; $i < $jumlahkarakteristik; $i++) {
                    for ($j = 0; $j < $jumlahtahun; $j++) {
                        echo "<th colspan='" . $jumlahturtahun . "''>" . $response['tahun'][$i]['label'] . '</th>';
                    }
                }
                echo '</tr>';
                echo '<tr>';
                for ($i = 0; $i < $jumlahkarakteristik; $i++) {
                    for ($j = 0; $j < $jumlahtahun; $j++) {
                        for ($k = 0; $k < $jumlahturtahun; $k++) {
                            echo '<th>' . $response['turtahun'][$k]['label'] . '</th>';
                        }
                    }
                }
                echo '</tr>';
            }
            echo '</thead><tbody>';
            for ($i = 0; $i < $jumlahbaris; $i++) {
                echo '<tr>';
                echo '<td>' . $response['vervar'][$i]['label'] . '</td>';
                for ($j = 0; $j < $jumlahkarakteristik; $j++) {
                    for ($k = 0; $k < $jumlahtahun; $k++) {
                        for ($l = 0; $l < $jumlahturtahun; $l++) {
                            $id_data = $response['vervar'][$i]['val'] . $idvariabel . $response['turvar'][$j]['val'] . $response['tahun'][$k]['val'] . $response['turtahun'][$l]['val'];
                            $data = isset($response['datacontent'][$id_data]) ? $response['datacontent'][$id_data] : '-';
                            echo '<td>' . $data . '</td>';
                        }
                    }
                }
                echo '</tr>';
            }
            echo '</tbody>';
            ?>
        </table>
    </div>
</body>

</html>
