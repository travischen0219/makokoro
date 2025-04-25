<?php 

if (count($_POST)>0){ 
	  $nowsts = $_POST["hxx_sts"];
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
    	 $xxin =substr($xxin,0,strlen($xxin)-1);
    	 $sqlx ="update ".$fftable." set display='".$nowsts."' where ".$ffpk." in(".$xxin.")";  
    	 $result =$s_mysqli->query($sqlx)or die('sql錯誤!: '.$sqlx.'<br/>' . mysqli_error()).'<br/>';
    	 
    	 if (isset($fftable2)){
    	 	  if ($fftable2<>''){
    	 	  	 $sqlx ="update ".$fftable2." set display='".$nowsts."' where ".$ffpk2." in(".$xxin.")";  
    	       $result =$s_mysqli->query($sqlx)or die('sql錯誤!: '.$sqlx.'<br/>' . mysqli_error()).'<br/>';
    	 	  }
    	 }    	 
    }
    
    if ($result){
    	 $xact_sts ='啟用狀態已變更!!';	  
    }
    else{
    	  $xact_sts ='發生錯誤!!';	  
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