<?php
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

$fftable  ='infouser';
$ffpk     ='userid';
$strgourl =$m_apnm."_list.php?m=".$m_apcode;

include '../sysinc/m_del_href.php'; 
?>
   