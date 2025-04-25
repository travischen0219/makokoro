<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);

if (isset($_POST['hxx_apcode'])){
	$m_apcode =$_POST['hxx_apcode'];
}
else{
	echo 'error access !!';
  exit();
}

$fwkfile ='';
if ( isset($_POST['hxx_nfile']) ){
   $fwkfile =$_POST['hxx_nfile'];
}   
else{	  
	 echo 'error access !!';
	 exit();
}

if ($fwkfile==""){
	 echo 'error data parsing!!';
	 exit();
}


$fdkind =$_POST['hxx_dkind'];

include '../sysinc/m_serverchk.php';   //$m_apnm

$fcaseid = $_POST['hxx_caseid'];
$fwkfile  =substr($fwkfile,0,strlen($fwkfile)-1);

$ntable ='';
if ($fdkind=='3'){
	  $ntable ='3dwk_gallery';
}
else{	
    $ntable ='wk_gallery';
}    

$arryfile =explode(",",$fwkfile);
echo $fwkfile.'<br/>';
foreach($arryfile as $eeitem){
	$sqlx ="insert into ".$ntable."(caseid,photo,display) ".
	      "values(".$fcaseid.",'".$eeitem."','N')";
	echo $sqlx.'<br/>';      
	//$fgo =mysql_query($sqlx,$s_link) or die('sql錯誤!: '.$sqlx.'<br/>' . mysql_error()).'<br/>';
}	
//echo "<script>window.opener.document.reg.submit();window.close();</script>";    
?>