<h3>cleanupsol(solution for clean-up-contracts-data)</h3>

The task was to "read the two files contracts.csv and awards.csv and output data-combined file final.csv and prints the following output 'Total Amount of closed contracts: 700000' in the screen."

so in my solution this is done by "process.php" 

	<?php
	include("function.php");
	include("config.php");
	
	$file1=process($_FILES['unorg1']);     //process() method is from
	$file2=process($_FILES['unorg2']);                               //function.php.
	
	$newfile=array();
	$empty=array("","","","","");
	$closedcon=0;
	
	foreach($file2 as $dt2 ){
	    $flag=FALSE;
	    foreach($file1 as $dt1){
	        if(strtolower($dt2[0])==strtolower($dt1[0]))
	        {
	            array_shift($dt1);
	            $dt2 = array_merge_recursive($dt2, $dt1);
	            $flag=TRUE;
	        }
	    }
	    if($flag!=TRUE){
	        $dt2 = array_merge_recursive($dt2, $empty);
	    }
	
	    if(strtolower($dt2[1])=="closed" )
	    {
	        $closedcon=$closedcon+$dt2[12];
	    }
	    $newfile[] = $dt2;
	}
	print_r("Total Amount of closed contracts: ".$closedcon );
	
	session_start();
	$_SESSION["finalout"]=$newfile;
	?>
	
	<script>
	    window.location.href="<?php echo BASE_URL?>download.php";         //BASE_URl is provided by 
	                                                                            //config.php for redirection to download.php
	</script>


in which file will be provided by the user from index .php
	
	<h4>please enter the file you want to process:</h4></br>
	<form method="post" enctype="multipart/form-data" action="process.php">
	    awards file = <input type='file' name="unorg1"/><br>
	    contracts file = <input type='file' name="unorg2"/><br>
	    </br>
	    <input type='submit' value="submit"/></br>
	</form>
	
and "process()" method is in the function.php

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
	
download functionality is supported by "download.php"
	
	<?php
	
	header('Content-Type: text/csv; charset=utf-8');
	header('Content-Disposition: attachment; filename=final.csv');
	header("Cache-Control: no-cache, no-store, must-revalidate");
	header("Pragma: no-cache");
	header("Expires: 0");
	
	$output = fopen('php://output', 'w');
	
	session_start();
	
	foreach($_SESSION["finalout"] as $data)
	    fputcsv($output, $data);
	
	?>
	
