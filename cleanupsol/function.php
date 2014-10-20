
<?php
function process($file){

    $target_dir = "processingfile/";
    $target_dir = $target_dir . basename( $file["name"]);

    move_uploaded_file($file["tmp_name"], $target_dir);
    $file_handle = fopen($target_dir, "r");

    $csv_data = array();

    while (!feof($file_handle) ) {
        $row = fgetcsv($file_handle, 1024);
        $csv_data[] = $row;
    }
    fclose($file_handle);
    return($csv_data);
}
?>
