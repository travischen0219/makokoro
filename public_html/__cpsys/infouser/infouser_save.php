<?php
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
	header("location:infouser_list.php?m=<?php echo $m_apcode ?>");
	exit();
} 

$fftable ='infouser';
$ffpk    ='userid';
$strgourl =$m_apnm."_list.php?m=".$m_apcode;

include '../sysinc/m_save_href.php';
?>
   