<?php
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
    	
    	 include '../sysinc/m_func.php';  
    	
    	 $xxin   =substr($xxin,0,strlen($xxin)-1);   
    	 //--刪圖片
    	 if (isset($pic_table)){
    	 	  if ($pic_table<>''){
    	 	  	  del_upfile($xxin,$pic_table.',photo,'.$pic_pky,$ffiledir);
    	 	  }
    	 }
    	 if (isset($pic_table2)){   //例如:明細檔
    	 	  if ($pic_table2<>''){
    	 	  	  del_upfile($xxin,$pic_table2.',photo,'.$pic_pky,$ffiledir);
    	 	  }
    	 }  
    	 
    	 //--刪檔案
    	 if (isset($file_table)){
    	 	  if ($file_table<>''){
    	 	  	  del_upfile($xxin,$file_table.','.$file_fld.','.$file_pky,$ffiledir);
    	 	  }
    	 }
    	 if (isset($file_table2)){   //例如:明細檔
    	 	  if ($file_table2<>''){
    	 	  	  del_upfile($xxin,$file_table2.','.$file_fld2.','.$file_pky2,$ffiledir);
    	 	  }
    	 }     	 
    	   	 
    	 //--刪資料    
    	 $strsql ="delete from ".$fftable." where ".$ffpk." in(".$xxin.")";  
    	 $result =$s_mysqli->query($strsql) or die('sql錯誤!: '.$strsql.'<br/>' . mysql_error()).'<br/>';    	 
    	 
    	 if (isset($fftable2)){
    	   if ($fftable2<>''){
    	 	    $strsql ="delete from ".$fftable2." where ".$ffpk2." in(".$xxin.")";  
    	      $result =$s_mysqli->query($strsql)or die('sql錯誤!: '.$strsql.'<br/>' . mysql_error()).'<br/>';     	    	     	     
    	   }
    	 }  
    	 if (isset($fftable3)){
    	 	  if ($fftable3<>''){
    	 	  	 $strsql ="delete from ".$fftable3." where ".$ffpk3." in(".$xxin.")";  
    	       $result =$s_mysqli->query($strsql)or die('sql錯誤!: '.$strsql.'<br/>' . mysql_error()).'<br/>';     	    	     	     
    	       //echo $strsql;
    	 	  }	
    	 }
    }    
    
    
    
    //echo $fftable3;
    //exit();
    
    if ($result){
    	 $xact_sts ='資料已刪除!!';	  
    }
    else{
    	  $xact_sts ='刪除時,發生錯誤!!';	  
    }
    echo "<script>alert('".$xact_sts."');</script>";
    
    if (isset($fbak_form)){
    	 if ($fbak_form<>''){
           echo $fbak_form;
           echo '<script>document.reg.submit();</script>';
       }
    }
    else{
    	  echo("<script>location.replace('".$strgourl."');</script>"); 
    }            
} 
?>