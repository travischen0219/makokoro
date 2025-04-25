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

$m_kind ='';
if (isset($_POST['hfx_mkind'])){
	 $m_kind =$_POST['hfx_mkind']; 
}	  



include '../sysinc/m_func.php'; 
$fphoto    ='';
$fophoto   ='';
if (isset($_FILES['up_photo']['name'])){
	 $fphoto  =$_FILES['up_photo']['name'];   //表示前端有選擇相片
   $fophoto =$_POST['hxx_oldphoto'];
}	
if ($fphoto<>''){	  //$kk,$op1,$nym,$nnd,$nndr,$nsz,$rsz / 欄位名,舊圖,代名,id,路徑 , 指定各種尺寸,是否壓縮
	 $fphoto =f_upfile('up_photo',$fophoto,'cs','',$ffiledir,'','f');
}	

$f_sno   ='Y'; //須要填入排序值時,才需要這變數
$fftable ='album_case';
$ffpk    ='caseid';
$strgourl=$m_apnm."_list.php?m=".$m_apcode.'&k='.$m_kind;

include '../sysinc/m_save_href.php'; 
?>