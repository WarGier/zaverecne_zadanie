<?php
include_once 'config.php';

if(isset($_POST['exportCSV'])){
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=data.csv');

    $output = fopen("php://output", "w");
    fputcsv($output, array('id', 'datum_cas', 'prikazy', 'info', 'chyba'));
    $query = "SELECT * FROM skuskaPDF ORDER BY id asc";
    $result = mysqli_query($link, $query);

    while ($row = mysqli_fetch_assoc($result)) {
        fputcsv($output, $row);
    }

    fclose($output);
}
