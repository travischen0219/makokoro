<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);

$fwkfile ='';
if (isset($_POST['hxx_nfile'])){
   $fwkfile = =$_POST['hxx_nfile'];
}   
else{
	 echo 'error access !!';
	 exit();
}

echo $fwkfile;

?>