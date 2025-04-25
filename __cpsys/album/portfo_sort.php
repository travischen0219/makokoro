<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Content-Type:text/html; charset=utf-8");

$m_apcode ='';
if (isset($_POST['hxx_apcode'])){
	$m_apcode =$_POST['hxx_apcode'];
}
elseif(isset($_GET['m'])){
	$m_apcode =$_GET['m'];  
}
else{
	 echo 'error way !!';
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

include '../sysinc/m_serverchk.php';
//include '../sysinc/genxml.php';

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
$strcat ='';
if (isset($_POST['hxx_wkid'])){
   $fcaseid =$_POST['hxx_wkid'];
   $fcasenm =$_POST['hxx_casenm'];
  // $strcat=$_POST['hxx_ctid'];
}   
else{
	 echo 'error parameter !!';
	 exit();
} 


if (count($_POST)>0){ 	 
    foreach($_POST as $_tag => $_value){ 
    	   //echo $_tag.":".$_value.'<br/>';
    	  if(substr($_tag,0,7)=='tfx_sno'){
    	  	 $xsort =substr($_tag,7);
           $xid   =$_value;
           $sqlx  ="update album_gallery set sno=".$xsort." where wkid=".$xid;
           //echo $sqlx.'<br/>';
           $result= $s_mysqli->query($sqlx) or die('錯誤!: '.$sqlx.'<br/>' . mysql_error()).'<br/>';
           //genxml($fcaseid);
    	  }    	    
    }     
} 
/*
$strgourl =$m_apnm."_list.php?m=".$m_apcode;
echo("<script>location.href ='".$strgourl."';</script>"); 
*/
//exit();
?>
<html>
	<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>
	<body>
		<form name="reg" action="<?php echo $m_apnm ?>_list.php" method="post">
		  <input type="hidden" name="hxx_apcode" value="<?php echo $m_apcode ?>">  		
      <input type="hidden" name="hxx_caseid" value="<?php echo $fcaseid ?>">
      <input type="hidden" name="hxx_casenm" value="<?php echo $fcasenm ?>"> 
      <input type="hidden" name="hxx_ctid" value="<?php echo $strcat?>">
      <input type="hidden" name="hxx_mkind" value="<?php echo $m_kind ?>">
	  </form>	
  </body>
</html>
<script language=javascript>
	<?php
	   if ($result){
	  	  echo "document.reg.submit();";
    }?>
</script>	  
   