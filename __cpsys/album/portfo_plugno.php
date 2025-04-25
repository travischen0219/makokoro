<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);

$m_apcode ='';
if (isset($_POST['hxx_apcode'])){
	 $m_apcode =$_POST['hxx_apcode'];
	 $strplug  =$_POST['hxx_plugno'];
}
else{
	echo 'error access !';
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
$strplug =''; 
$strcat  ='';

if (isset($_POST['hxx_wkid'])){
   $fcaseid =$_POST['hxx_wkid'];
   $fcasenm =$_POST['hxx_casenm'];
   $strplug =$_POST['hxx_plugno'];  //插入目標的排序號
   $strcat  =$_POST['hxx_ctid'];   //目前分類
}   
else{
	 echo 'error parameter !!';
	 exit();
} 

if ($strplug==''){
	  echo 'error access !!';
	  exit();
}


if (count($_POST)>0){ 	
    $ntotchk	=$_POST['hxx_totchk']; //選了幾筆
    $strpos   =$_POST['hxx_pos'];    //bf or af  指定位置   
    $nto_sno  =$strplug;   //指定位置代號
    
    $nbegin ='';
    if ($strpos=='bf'){    //before
       $nbegin =$nto_sno;
       $sqlx ="update wk_gallery set sno=sno+".$ntotchk." where sno>=".$nto_sno." and caseid=".$fcaseid;
    }
    else if($strpos=='af'){   //after
    	 $nbegin =$nto_sno+1;
    	 $sqlx ="update wk_gallery set sno=sno+".$ntotchk." where sno>".$nto_sno." and caseid=".$fcaseid;
    }	 
    
    $result =mysql_query($sqlx,$s_link) or die('sql錯誤!: '.$sqlx.'<br/>' . mysql_error()).'<br/>';        
    
    foreach($_POST as $_tag => $_value){ 
    	   //echo $_tag.":".$_value.'<br/>';
    	  if(substr($_tag,0,6)=='chkDel'){
    	  	if ($_value !==''){    	  	
    	  		 $sqlx ="update wk_gallery set sno=".$nbegin." where wkid=".$_value;
    	  		 $nbegin +=1;
    	  		 $result =mysql_query($sqlx,$s_link) or die('sql錯誤!: '.$sqlx.'<br/>' . mysql_error()).'<br/>';
          } 
    	  }    	    
    }    
    
    //---排好位置後, 將該類別的序號重新整理
    
    $sqlx ='select wkid from wk_gallery where caseid='.$fcaseid.' order by sno ';
    //echo $sqlx;
    //exit();
    $rsn      = mysql_query($sqlx,$s_link);
    $rsn_rows = mysql_num_rows($rsn);  //筆數
    $xxsno =0;
    for($i=0;$i<$rsn_rows;$i++){
        $rsn_c =mysql_fetch_row($rsn);
        $nwkd =$rsn_c[0];
        $xxsno +=1;
        $sqlx ='update wk_gallery set sno='.$xxsno.' where wkid='.$nwkd;
        $result =mysql_query($sqlx,$s_link) or die('sql錯誤!: '.$sqlx.'<br/>' . mysql_error()).'<br/>';
    }     
        
} 

//exit();
//$strgourl =$m_apnm."_list.php?m=".$m_apcode."&cat=".$strcat;
//echo("<script>location.href ='".$strgourl."';</script>"); 
?>
<html>
	<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>
	<body>
		<form name="reg" action="<?php echo $m_apnm ?>_list.php" method="post">
		  <input type="hidden" name="hxx_apcode" value="<?php echo $m_apcode ?>">  		
      <input type="hidden" name="hxx_caseid" value="<?php echo $fcaseid ?>">
      <input type="hidden" name="hxx_casenm" value="<?php echo $fcasenm ?>"> 
      <input type="hidden" name="hxx_ctid" value="<?php echo $strcat?>">
	  </form>	
  </body>
</html>
<script language=javascript>
	<?php
	   if ($result){
	  	  echo "document.reg.submit();";
    }?>
</script>	  
   