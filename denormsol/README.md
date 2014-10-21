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

and "process()" method is in the function.php

download functionality is supported by "download.php"

