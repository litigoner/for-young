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
    window.location.href="<?php echo BASE_URL?>download.php";         //BASE_URl is provided by 
                                                                            //config.php for redirection to download.php
</script>

