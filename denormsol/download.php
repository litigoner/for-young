<?php
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=amp-organised-location.csv');
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

$output = fopen('php://output', 'w');

session_start();

foreach($_SESSION["finalout"] as $data)
    fputcsv($output, $data);

?>
