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
   //$strcat=$_POST['hxx_ctid'];
}   
else{
	 echo 'error parameter !!';
	 exit();
} 

$m_kind ='';
if (isset($_POST['hxx_mkind'])){
	 $m_kind =$_POST['hxx_mkind']; 
}	  
else{
	  echo 'error mode..';
	  exit();
}


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
   
    if ($xxin<>''){
    	 $xxin   =substr($xxin,0,strlen($xxin)-1);    	 
    	 $sqlx     ="select photo,sphoto from album_gallery where wkid in(".$xxin.")"; 	
        $rsd      =$s_mysqli->query($sqlx);
        $rsd_rows =mysqli_num_rows($rsd);  //筆數
   
         //echo $rsd_rows;
         //exit();
   
         for($i=0;$i<$rsd_rows;$i++){
            $rsrow    =mysqli_fetch_row($rsd);
            $xxphoto    =$rsrow[0];
            $xxsphoto  =$rsrow[1];
            
            if ($xxphoto<>''){
            	  if (file_exists ($ffiledir.$xxphoto)){
            	  	  if(! unlink($ffiledir.$xxphoto)){
            	  	  	 echo '刪除'.$ffiledir.$xxphoto.'時,發生錯誤';
            	  	  	 exit();
            	  	  }
            	  }      	  
            	  $arypic  =explode(".",$xxphoto);
                $xxphoto_s =$arypic[0].'_s.'.$arypic[1];                          
                
                if (file_exists ($ffiledir.$xxphoto_s)){
                    if(! unlink($ffiledir.$xxphoto_s)){
            	  	   	 echo '刪除'.$ffiledir.$xxphoto_s.'時,發生錯誤';
            	  	   	 exit();
            	  	  }
            	  }             	  
            	  
                $xxphoto_b =$arypic[0].'_b.'.$arypic[1];                                          
                if (file_exists ($ffiledir.$xxphoto_b)){
                    if(! unlink($ffiledir.$xxphoto_b)){
            	  	   	 echo '刪除'.$ffiledir.$xxphoto_b.'時,發生錯誤';
            	  	   	 exit();
            	  	  }
            	  } 
            	  
            	  $xxphoto_pr =$arypic[0].'_p'.$arypic[1];
                if (file_exists ($ffiledir.$xxphoto_pr)){
                    if(! unlink($ffiledir.$xxphoto_pr)){
            	  	   	 echo '刪除'.$ffiledir.$xxphoto_pr.'時,發生錯誤';
            	  	   	 exit();
            	  	  }
            	  }
            }
            
            if ($xxsphoto<>''){
            	  if (file_exists ($ffiledir.$xxsphoto)){
            	  	  if(! unlink($ffiledir.$xxsphoto)){
            	  	  	 echo '刪除'.$ffiledir.$xxsphoto.'時,發生錯誤';
            	  	  	 exit();
            	  	  }
            	  } 
            }
         }	
         
    	 $strsql ="delete from album_gallery where wkid in(".$xxin.")";  
    	 $result =$s_mysqli->query($strsql)or die('sql錯誤!: '.$strsql.'<br/>' . mysqli_error()).'<br/>'; 
    	 //genxml($fcaseid);    	  
    }    
} 

/*
$strgourl =$m_apnm."_list.php?m=".$m_apcode;
echo("<script>location.href ='".$strgourl."';</script>"); 
//header("location:infouser_list.php?m=".$m_apcode);
//exit();  
*/
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
   