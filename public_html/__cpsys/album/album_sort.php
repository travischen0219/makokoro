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

$m_kind ='';
if (isset($_GET['k'])){
   $m_kind =$_GET['k'];
} 
elseif (isset($_POST['hxx_mkind'])){
	 $m_kind =$_POST['hxx_mkind']; 
}	  
else{
	  echo 'error model!';
	  exit();
}

include '../sysinc/m_serverchk.php';   //$m_apnm


$fftable ='album_case';
$ffpk    ='caseid';
$ffld    ='sno';
$strgourl =$m_apnm."_list.php?m=".$m_apcode.'&k='.$m_kind;
include '../sysinc/m_sort_href.php' 
?>
   