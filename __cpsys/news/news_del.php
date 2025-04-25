<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);

$m_apcode ='';
if (isset($_POST['hxx_apcode'])){
	$m_apcode =$_POST['hxx_apcode'];
}
else{
	echo 'error access !!';
  exit();
}

include '../sysinc/m_serverchk.php';   //$m_apnm

$pic_table  ='news';
$pic_pky    ='bno';

$fftable  ='news';
$ffpk     ='bno';
$strgourl =$m_apnm."_list.php?m=".$m_apcode;
include '../sysinc/m_del_href.php'; 
?>
   