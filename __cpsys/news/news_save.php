<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);

putenv("TZ=Asia/Taipei");

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

$fphoto    ='';
$fophoto   ='';

if (isset($_FILES['up_photo']['name'])){
	  $fphoto    =$_FILES['up_photo']['name'];   //表示前端有選擇相片
    $fophoto   =$_POST['hxx_oldphoto'];
}	
include '../sysinc/m_func.php'; 

if ($fphoto<>''){	  //$kk,$op1,$nym,$nnd,$nndr,$nsz,$rsz / 欄位名,舊圖,代名,id,路徑 , 指定各種尺寸,是否壓縮	 
	 $ffilenm ='up_photo';
	 $fphoto =f_upfile($ffilenm,'','nw','',$ffiledir,'s,400,200|o,1000,800','t');   //o:原圖 
} 

if (isset($_POST['tfx_filmurl'])){
   $xxurl  =$_POST['tfx_filmurl'];
   $mmytid =getYTid($xxurl);
}  

$f_sno   ='Y';    //須要填入排序值時,才需要這變數
$f_sno_o ='d';    //排序的方式 a:正常 d:新的在第一筆

$fftable ='news';
$ffpk    ='bno';
$strgourl =$m_apnm."_list.php?m=".$m_apcode;
include '../sysinc/m_save_href.php';
?> 