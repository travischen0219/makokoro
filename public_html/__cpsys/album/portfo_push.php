<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
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

$m_apnm ='';
if (isset($_POST['hxx_apname'])){
	$m_apnm =$_POST['hxx_apname'];
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


//----
$f_vv='';  //new or push
if (isset($_GET['v'])){
	  $f_vv =$_GET['v'];
}	
if ($f_vv ==''){
	  echo 'error para !';
	  exit();
}
//--
$fcaseid ='';
$fcasenm ='';
if (isset($_POST['hxx_wkid'])){
   $fcaseid =$_POST['hxx_wkid'];
   $fcasenm =$_POST['hxx_casenm'];   
}   
else{
	 echo 'error parameter !!';
	 exit();
} 
//-----
if (count($_POST)>0){ 
	  $xxin='';
    foreach($_POST as $_tag => $_value){ 
    	   //echo $_tag.":".$_value.'<br/>';
    	  if(substr($_tag,0,6)=='chkDel'){    	  	
    	  	 if ($_value !==''){
    	  	 	   $xxin = $xxin.$_value.',';
    	  	 }    	  	 
    	  }    	    
    } 
    //echo $xxin;
    //exit();            
    if ($xxin<>''){  //把原來是有勾的改為空白,把原是空白的改為勾  
    	 $xfld ='';
    	 if ($f_vv=='new'){   //新品
    	 	  $xfld ='push_new';
    	 }
    	 else if($f_vv=='push'){ //推薦
    	 	  $xfld ='push';    	 	
    	 }    	     	
    	 else if($f_vv=='cov'){  //代表圖-封面
    	 	  $xfld ='push_cov';    	 	
    	 }	
    	 //----	  
    	 $ff_table_1 ="album_case";
    	 $ff_pk_1    ="caseid";
    	 
    	 $ff_table_2 ="album_gallery";
    	 $ff_pk_2    ="wkid";    	 
    	 
    	 $xxin   =substr($xxin,0,strlen($xxin)-1);   //勾選的
    	 $xxid_y ='';
    	 $xxid_n ='';    	 
    	 $xx_cov ='';    	     	     	 
    	 
    	 if ($f_vv=='cov'){  //$fcaseid  //先清空明細檔-原代表圖,
    	 	  $sqlx ="update ".$ff_table_2." set ".$xfld."='' where ".$ff_pk_1."=".$fcaseid;
    	 	  $result =$s_mysqli->query($sqlx);
    	 	    	 	  
    	 	  $sqlx ="update ".$ff_table_2." set ".$xfld."='Y' where ".$ff_pk_2."=".$xxin;
    	 	  $result =$s_mysqli->query($sqlx);      	 	  
    	 	  
    	 	  $sqlx ='select photo from '.$ff_table_2.' where '.$ff_pk_2.'='.$xxin;
    	    $rsw =$s_mysqli->query($sqlx);
    	    
    	    $rsw_c=mysqli_fetch_assoc($rsw);  //代表圖名稱存入主檔
    	    $xx_cov =$rsw_c['photo'];
    	    $sqlx ="update ".$ff_table_1." set photo='".$xx_cov."' where ".$ff_pk_1."=".$fcaseid;
    	 	  $result =$s_mysqli->query($sqlx)or die('sql錯誤!: '.$sqlx.'<br/>' . mysql_error()).'<br/>';    	 	    	 	
    	 }
    	 else{
    	 
    	       $sqlx ='select wkid,'.$xfld.',photo from photo_gallery where wkid in('.$xxin.')';
    	       $rsw =$s_mysqli->query($sqlx);
    	       
    	       while ($rsw_c=mysqli_fetch_assoc($rsw)){    	 	
    	       	    if ($rsw_c[$xfld]=='Y'){
    	       	    	   $xxid_n .=$rsw_c['wkid'].',';
    	       	    }
    	       	    else{
    	       	    	  $xxid_y .=$rsw_c['wkid'].',';
    	       	    	  if ($xx_cov==''){    	 	    	     
    	       	    	     $xx_cov =$rsw_c['photo'];
    	       	    	  }   
    	       	    }
    	       }
    	       
    	       if ($xxid_y<>''){
    	       	   $xxid_y  =substr($xxid_y,0,strlen($xxid_y)-1);   //要設為Y的
    	       	   $sqlx ="update photo_gallery set ".$xfld."='Y' where wkid in(".$xxid_y.")";
    	       	   $result =$s_mysqli->query($sqlx)or die('sql錯誤!: '.$sqlx.'<br/>' . mysql_error()).'<br/>';
    	       }    	 
    	       if ($xxid_n<>''){
    	       	   $xxid_n  =substr($xxid_n,0,strlen($xxid_n)-1);   //要清空的
    	       	   $sqlx ="update photo_gallery set ".$xfld."='' where wkid in(".$xxid_n.")";
    	       	   $result =$s_mysqli->query($sqlx)or die('sql錯誤!: '.$sqlx.'<br/>' . mysql_error()).'<br/>';
    	       }
    	}     	     	 
    	 
    	    	    	  
    } 
} 

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