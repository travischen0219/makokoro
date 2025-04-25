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


include '../sysinc/m_serverchk.php';   //$m_apnm

// htmlspecialchars 
// htmlentities 遇中文會變亂碼

if (isset($_POST['hxx_editmode'])){
  $feditmode = $_POST['hxx_editmode'];
} 
else{
	echo '<script>location.replace(group_list.php?m='.$m_apcode.');</script>';
	exit();
} 

//echo $_POST['tfx_content'];
//exit();

//$xename  =htmlspecialchars($_post['tfx_groupename']); 
//$xcname  =htmlspecialchars($_post['tfx_groupcname']);
//$xremark =htmlspecialchars($_post['tfx_groupremark'];

$ary_chkap =$_POST['chkap'];

if ($feditmode=='ADD'){	
   $sqla ='insert into apgrouplookup(editor,editdate,apgrouptype,';
   $sqlb ='values(\''.$fsys_user.'\',NOW(),2,';
   $ffield='';
   $strfield='';
   $strvalue='';
    if (count($_POST)>0){ 
    	 foreach($_POST as $_tag => $_value){     	  	
    	 	  $fhtag = substr($_tag,0,4);
    	 	  $ffield= substr($_tag,4);    
    	 	  //echo $_tag.':'.$_value.'<br/>';  
    	 	  if (substr($fhtag,1,3)=='fx_'){
    	 	  	  $strfield =$strfield.$ffield.",";	     	 	  	  
    	 	      switch ($fhtag){
    	 	      	case 'tfx_':    	 	           
    	 	      	   $strvalue =$strvalue."'".htmlspecialchars($_value,ENT_QUOTES)."',";
    	 	      	   break;
    	 	      	case 'nfx_':    	 	      	   
    	 	      	   if ($_value==''){
    	 	      	   	  $strvalue =$strvalue."NULL,";
    	 	      	   }
    	 	      	   else{
    	 	      	   	  $strvalue =$strvalue.htmlspecialchars($_value,ENT_QUOTES).",";
    	 	      	   }
    	 	      	   break;   
    	 	      	case 'dfx_':    	 	      	   
    	 	      	   if ($_value==''){
    	 	      	   	  $strvalue =$strvalue."NULL,";
    	 	      	   }
    	 	      	   else{
    	 	      	   	  $strvalue =$strvalue."'".htmlspecialchars($_value,ENT_QUOTES)."',";
    	 	      	   }
    	 	      	   break;
    	 	      	case 'pfx_':
    	 	      	   $xxpwd    =md5(htmlspecialchars($_value,ENT_QUOTES));
    	 	      	   $strvalue =$strvalue."'".$xxpwd."',";
    	 	      	   break;   
    	 	      	default :
    	 	      	   $strvalue =$strvalue."'".htmlspecialchars($_value,ENT_QUOTES)."',";
    	 	      	   break;     
     	 	      }
     	 	   }   
       } 
       
       $sqla = $sqla.substr($strfield,0,strlen($strfield)-1).")";
       $sqlb = $sqlb.substr($strvalue,0,strlen($strvalue)-1).")";        
       $strsql = $sqla.' '.$sqlb;
       /*       
       $result =mysql_query("show table status like 'apgrouplookup' ");  //先取auto id  
       $ncid   =mysql_result($result, 0, 'Auto_increment');
       */
       
       $s_mysqli->query($strsql) or die('sql錯誤!: '.$strsql.'<br/>' . mysqli_error()).'<br/>'; 
       $ncid   =$s_mysqli->insert_id;
       //--- 
       upd_apgroup($ary_chkap,'a',$ncid);      
       
       //echo $strsql;
       //exit();
    }
    else{
    	  echo '<script>location.replace(group_list.php?m='.$m_apcode.');</script>';
	 	    exit();
    }
}    
else{ 	 		 
	
	 if (isset($_POST['pxx_id'])){
	    $fid  = $_POST['pxx_id'];
	 }   
	 else{
	 	  echo '<script>location.replace(group_list.php?m='.$m_apcode.');</script>';
	 	  exit();
	 }	
	 $sqla  ='update apgrouplookup set ';
   $sqlb  =' where apgroupid='.$fid;
   $ffield='';
   $strfield='';
   $strvalue='';               
	 
	 if (count($_POST)>0){ 
    	 foreach($_POST as $_tag => $_value){     	  	
    	 	  $fhtag = substr($_tag,0,4);
    	 	  $ffield= substr($_tag,4);    
    	 	  //echo $_tag.':'.$_value.'<br/>';  
    	 	  if (substr($fhtag,1,3)=='fx_'){    	 	  	  
    	 	  	  
    	 	      switch ($fhtag){
    	 	      	case 'tfx_':
    	 	      	   $strfield =$strfield.$ffield."='".htmlspecialchars($_value,ENT_QUOTES)."',";
    	 	      	   break;
    	 	      	case 'nfx_':    	 	      	   
    	 	      	   if ($_value==''){    	 	      	   	  
    	 	      	   	  $strfield =$strfield.$ffield."=NULL,";
    	 	      	   }
    	 	      	   else{    	 	      	   	  
    	 	      	   	  $strfield =$strfield.$ffield."=".htmlspecialchars($_value,ENT_QUOTES).",";
    	 	      	   }
    	 	      	   break;   
    	 	      	case 'dfx_':    	 	      	   
    	 	      	   if ($_value==''){
    	 	      	   	  $strfield =$strfield.$ffield."=NULL,";
    	 	      	   }
    	 	      	   else{
    	 	      	   	  $strfield =$strfield.$ffield."='".htmlspecialchars($_value,ENT_QUOTES)."',";
    	 	      	   }
    	 	      	   break;
    	 	      	case 'pfx_':
    	 	      	   $xxpwd    =md5(htmlspecialchars($_value,ENT_QUOTES)); 
    	 	      	   $strfield =$strfield.$ffield."='".$xxpwd."',";
    	 	      	   break;   
    	 	      	default :    	 	      	   
    	 	      	   $strfield =$strfield.$ffield."='".htmlspecialchars($_value,ENT_QUOTES)."',";
    	 	      	   break;     
     	 	      }
     	 	   }   
       } 
       
       $strsql = $sqla.substr($strfield,0,strlen($strfield)-1).$sqlb;
       $result =$s_mysqli->query($strsql)or die('sql錯誤!: '.$strsql.'<br/>' . mysql_error()).'<br/>'; 
       upd_apgroup($ary_chkap,'e',$fid);
       //exit();
    }
    else{
    	  echo '<script>location.replace(group_list.php?m='.$m_apcode.');</script>';
	 	    exit();
    }	 	  	 
}  


function upd_apgroup($nnap,$ne,$nnd){		
	include '../sysinc/dbConn.php';
	
	$ary_cc  =count($nnap);
	if ($ne=='e'){	
	    $sqlxx="delete from apgroup where apgroupid=".$nnd." and apcode<>'S00M01' and apcode<>'S00M02' ";
	    $result =$s_mysqli->query($sqlxx)or die('sql錯誤!: '.$sqlxx.'<br/>'.mysql_error()).'<br/>';
	}  
	//--
	$sqlx ="insert into apgroup(apgroupid,apcode,rights,datadate) values ";   
  $xvalx ='';
  for ($k=0;$k<$ary_cc;$k++){      
      $xvalx .='('.$nnd.',\''.$nnap[$k].'\',255,NOW()),';           
  }  
  $sqlx = $sqlx.substr($xvalx,0,strlen($xvalx)-1);
  $result =$s_mysqli->query($sqlx)or die('sql錯誤!: '.$sqlx.'<br/>'.mysql_error()).'<br/>';
  
}

//exit();  
echo '<script>location.replace("'.$m_apnm.'_list.php?m='.$m_apcode.'")</script>';
?>
   