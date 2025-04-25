<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);

if (isset($_POST['hxx_apcode'])){
   $m_apcode =$_POST['hxx_apcode'];
}   
else{	
	 echo 'err 1';
	 exit();
}

if (isset($_POST['hxx_editmode'])){
  $feditmode = $_POST['hxx_editmode'];
} 
else{
	header("location:".$m_apnm."_list.php?m=".$m_apcode);
	exit();
} 

include '../sysinc/m_serverchk.php';   //$m_apnm

$m_apnm   ='user';
$fftable  ='infouser';
$ffpk     ='userid';
$strgourl =$m_apnm.'_list.php?m='.$m_apcode;

include '../sysinc/m_save_href.php';
?>
   