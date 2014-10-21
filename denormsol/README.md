denormsol(solution for denormalise-location-data)

The task was to "read the following file amp-unorganised-location.csv and output new file amp-organised-location.csv in exact form"

so in my solution this is done by "process.php"
  
  <?php
  include("function.php");
  include("config.php");
  
  $file=process($_FILES['unorg']);                    //process() method is provided by function.php
  
  array_shift($file);
  $rslt_head=array("AMP ID","Project Title","Status","District","City");
  
  $rslt=array();
  $rslt[]=$rslt_head;
  $finaldata=array();
  
  foreach($file as $dta)
  {
      $dta[3]=ltrim($dta[3],' - ');
      $arr=explode(' - ',$dta[3]);
      $len=count($arr);
      foreach($arr as $findta)
      {
          $findta=rtrim($findta,")\n\r");
          $arr2=explode(' (',$findta);
          for($i=0;$i<4;$i++){
              if($i==3)
              {
                  if($arr2[0]==null)
                  {
                      $finaldata[$i]=' ';
                      $finaldata[++$i]=' ';
                  }
                  else{
                      $finaldata[$i]=$arr2[0];
                      $finaldata[++$i]=$arr2[1];
                  }
              }
              else
              {
                  $finaldata[$i]=$dta[$i];
              }
          }
          $rslt[]=$finaldata;
      }
  }
  var_dump($rslt);
  
  session_start();
  $_SESSION["finalout"]=$rslt;
  ?>
  
  <script>
      window.open('<?php echo BASE_URL?>download.php','_blank');          //BASE_URl is provided by config.php
  </script>


in which file will be provided by the user from index .php

  <?php include("config.php")?>
  <h4>please enter the file you want to process:</h4></br>
  <form method="post" enctype="multipart/form-data" action="process.php">
     upload unorganized file = <input type='file' name="unorg"/><br>
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
  header('Content-Disposition: attachment; filename=amp-organised-location.csv');
  header("Cache-Control: no-cache, no-store, must-revalidate");
  header("Pragma: no-cache");
  header("Expires: 0");
  
  $output = fopen('php://output', 'w');
  
  session_start();
  
  foreach($_SESSION["finalout"] as $data)
      fputcsv($output, $data);
  
  ?>
