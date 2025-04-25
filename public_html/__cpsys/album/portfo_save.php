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

$m_apnm ='';
if (isset($_POST['hxx_apname'])){
	$m_apnm =$_POST['hxx_apname'];
}
else{
	 echo 'error access !!';
	 exit();
}
  
$fcaseid ='';
$fcasenm ='';
$fnowid  ='';
$strcat  ='';
if (isset($_POST['hxx_caseid'])){
   $fcaseid =$_POST['hxx_caseid'];
   $fcasenm =$_POST['hxx_casenm'];
   $fnowid  =$_POST['pxx_id'];
   //$strcat  =$_POST['hxx_ctid'];
}   
else{
	 echo 'error parameter !!';
	 exit();
} 

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

include '../sysinc/m_func.php'; 


$fphoto =$_FILES['up_photo']['name'];   //表示前端有選擇相片
$fophoto =$_POST['hxx_oldphoto'];   //原檔

//echo $fdfile;
//exit();

if ($m_kind=='1'){	 
    $nn_picsz='b,300,160|o,770,408';   
    $ff_pnm  ='pg';
}
else{        
    $nn_picsz='p,292,219|o,800,800';         
    $ff_pnm  ='pg';
}
if ($fphoto<>''){	  //表示前台有上傳檔案	 
	 $fphoto =f_upfile('up_photo',$fophoto,$ff_pnm,$fnowid,$ffiledir,$nn_picsz,'t');	 
}	


$f_sno   ='Y'; //須要填入排序值時,才需要這變數
$fftable ='album_gallery';
$ffpk    ='wkid';
$strgourl ='';

$fbak_form ='<html>'.
'<head>'.
'<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />'.
'</head>'.	
'<body>'.
'		<form name="reg" action="'.$m_apnm.'_list.php" method="post">'.
'		  <input type="hidden" name="hxx_apcode" value="'.$m_apcode.'">'.  		
'      <input type="hidden" name="hxx_caseid" value="'.$fcaseid.'">'.
'      <input type="hidden" name="hxx_casenm" value="'.$fcasenm.'">'.
'      <input type="hidden" name="hxx_ctid" value="'.$strcat.'">'.
'       <input type="hidden" name="hxx_mkind" value="'.$m_kind.'">'.  
'	  </form>'.	
'  </body>'.
'</html>';
//echo $fbak_form;
include '../sysinc/m_save_href.php';
?>
