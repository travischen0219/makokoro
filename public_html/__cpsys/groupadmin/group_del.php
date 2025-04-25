<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);

$m_apcode ='';
if (isset($_POST['hxx_apcode'])){
	$m_apcode =$_POST['hxx_apcode'];
}
else{
	echo 'error access !!';
  exit();
}

include '../sysinc/m_serverchk.php';   //$m_apnm

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
    	  $xxin=substr($xxin,0,strlen($xxin)-1);
    	  $sqla ="delete from apgrouplookup where apgroupid in(".$xxin.") and apgroupid<>1 and apgroupid<>2";
    	  $sqlb ="delete from apgroup where apgroupid in(".$xxin.")  and apgroupid<>1 and apgroupid<>2"; 
    }       
       
    //mysql_query("SET NAMES utf-8;"); 
   // mysql_query($strsql,$s_link);
   $fgo =mysql_query($sqla,$s_link)or die('sql錯誤!: '.$sqla.'<br/>' . mysql_error()).'<br/>';      
   $fgo =mysql_query($sqlb,$s_link)or die('sql錯誤!: '.$sqlb.'<br/>' . mysql_error()).'<br/>';  
       //exit();
       //echo $strsql;       
} 

echo '<script>location.replace("'.$m_apnm.'_list.php?m='.$m_apcode.'")</script>';
//exit();  
?>
   