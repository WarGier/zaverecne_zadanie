<?php
include_once 'config.php';

if(isset($_POST['exportCSV'])){
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=data.csv');

    $output = fopen("php://output", "w");
    fputcsv($output, array('id', 'login_name', 'login_time', 'login_method'));
    $query = "SELECT * FROM loginlog ORDER BY id asc";
    $result = mysqli_query($link, $query);

    while ($row = mysqli_fetch_assoc($result)) {
        fputcsv($output, $row);
    }

    mb_convert_encoding($output, 'Windows-1250', 'UTF-8');

    fclose($output);
}
