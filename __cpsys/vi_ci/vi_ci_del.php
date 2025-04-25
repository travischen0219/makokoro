<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Content-Type:text/html; charset=utf-8");

$m_apcode ='';
if (isset($_POST['hxx_apcode'])){
	$m_apcode =$_POST['hxx_apcode'];
}
else{
	echo 'error access !!';
  exit();
}

include '../sysinc/m_serverchk.php';   //$m_apnm

$pic_table ='vi_ci';
$pic_pky   ='bid';

$fftable  ='vi_ci';
$ffpk     ='bid';
$strgourl =$m_apnm."_list.php?m=".$m_apcode;
include '../sysinc/m_del_href.php';  
?>
   