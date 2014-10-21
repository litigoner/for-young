
<?php
include("function.php");
include("config.php");

$file1=process($_FILES['unorg1']);                         //process() method is 
$file2=process($_FILES['unorg2']);                           //from function.php.             

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
    window.open('<?php echo BASE_URL?>download.php','_blank');             //BASE_URL is provided by config.php
</script>
