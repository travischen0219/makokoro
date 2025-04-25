<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Content-Type:text/html; charset=utf-8");

if (isset($_POST['hxx_apcode'])){
   $m_apcode =$_POST['hxx_apcode'];
}   
else{
	 echo 'error access !!';
	 exit();
}

include '../sysinc/m_serverchk.php';   //$m_apnm

// htmlspecialchars 
// htmlentities 遇中文會變亂碼

if (isset($_POST['hxx_editmode'])){
  $feditmode = $_POST['hxx_editmode'];
} 
else{
	header("location:".$m_apnm."_list.php?m=".$m_apcode);
	exit();
} 

//echo $_POST['tfx_content'];
//exit();

$fftable ='servmail';
$ffpk    ='cid';

$strgourl =$m_apnm."_list.php?m=".$m_apcode;

include '../sysinc/m_save_href.php';
?> 