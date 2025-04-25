<?php
$result =false;
$xact_sts ='';

if (count($_POST)>0){ 	 
    foreach($_POST as $_tag => $_value){ 
    	   //echo $_tag.":".$_value.'<br/>';
    	  if(substr($_tag,0,7)=='tfx_sno'){
    	  	 $xsort =substr($_tag,7);
           $xid   =$_value;
           $sqlx  ="update `".$fftable."` set `".$ffld ."`=".$xsort." where `".$ffpk."`=".$xid;
           $result= $s_mysqli->query($sqlx)or die('錯誤!: '.$sqlx.'<br/>' . mysql_error()).'<br/>';    	  	 
    	  }    	    
    }     
} 

if ($result){
	 $xact_sts ='排序已存檔!';
}
else{
	  $xact_sts ='存檔發生錯誤!!';
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
?>