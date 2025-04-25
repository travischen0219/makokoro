<?php
session_start();

$nnk ='';
$xxact ='';
if (isset($_POST['k'])){
	 $nnk =$_POST['k'];
}	

if($nnk==''){
	 return 'err';
	 exit();
}

include '../sysinc/m_func.php';

if ($nnk=='mem'){  //後台 會員　	 	  
	  $xxerr ='';
    $xxmail ='';
    $xxtel ='';
    $xxcell='';  
    $xxid ='';
    $sqlx ='select mid from `member` where ';
	 
	 if (isset($_POST['act'])){
	    $xxact =$_POST['act'];
   }	   
   if (isset($_POST['mail'])){
	    $xxmail=$_POST['mail'];
   }	
   if (isset($_POST['tel'])){
	    $xxtel=$_POST['tel'];
   }	
   if (isset($_POST['cell'])){
	    $xxcell=$_POST['cell'];
   }	      
   if (isset($_POST['nd'])){
	    $xxid =$_POST['nd'];
   }      
   
   $xxand ='';
   if ($xxid<>''){
   	   $xxand =' and mid<>'.$xxid;
   }	
    
   //$xxmail ='pighead@odo.com.tw';
   if ($xxmail<>''){
   	   $xwhere ="email='".$xxmail."'".$xxand;
   	   $sqla =$sqlx.$xwhere;
   	   $xrr =run_sql($sqla,$xxact);   	   
   	   if ($xrr==1){
   	   	   $xxerr .='[E-mail],';   	   	   
   	   }  
   }    
   if ($xxtel<>''){
   	   $xwhere ="tel='".$xxtel."'".$xxand;
   	   $sqla =$sqlx.$xwhere;
   	   $xrr =run_sql($sqla,$xxact);   	  
   	   
   	   if ($xrr==1){
   	   	   $xxerr .='[室內電話],';   	   	   
   	   }  
   } 
   if ($xxcell<>''){
   	   $xwhere ="cell='".$xxcell."'".$xxand;   	  
   	   $sqla =$sqlx.$xwhere;   	   
   	   $xrr =run_sql($sqla,$xxact);   	   
   	   if ($xrr==1){
   	   	   $xxerr .='[手機],';   	   	   
   	   }  
   }      
   if ($xxerr<>''){
   	   $$xxerr =substr($xxerr,0,strlen($xxerr)-1);
   }
   else{
   	   $$xxerr ='f';
   }   
   echo $$xxerr;
}
else{	   
	   $xxtable='';
	   $xxfld  ='';
	   $xxval  ='';
	   if (isset($_POST['act'])){
	      $xxact =$_POST['tt'];
     }
	   if (isset($_POST['tt'])){
	      $xxtable =$_POST['tt'];
     }	 
     if (isset($_POST['ff'])){
	      $xxfld =$_POST['ff'];
     }
     if (isset($_POST['vv'])){
	      $xxval =$_POST['vv'];
     }	
     
     if ($xxtable=='pcollect' || $xxtable=='product'){
     	    if ($xxtable=='pcollect'){
     	    	  $xsql ='select p2.catnm from 
     	    	          pcollect p1 
     	    	          left join pcollect_cat p2 on p1.cid=p2.cid 
     	    	          where p1.'.$xxfld.'=\''.$xxval.'\'';
     	    }
     	    else{
     	    	  $xsql ='select p2.ctnm from 
     	    	          product p1 
     	    	          left join product_cat p2 on p1.cid=p2.cid 
     	    	          where p1.'.$xxfld.'=\''.$xxval.'\'';
     	    }	   	  	
     	    
     	    $xrr =run_sql2($xsql,$xxact);
     	    
	   }
	   else{
	   	   $xsql ='select \'t\' from '.$xxtable.' where '.$xxfld.'=\''.$xxval.'\'';
	   	   $xrr =run_sql($xsql,$xxact);
	   }
	   
	   echo $xrr;
}


function run_sql($xsql,$xact){        //$xact:dup=是否重複(已存在)
	  include '../sysinc/dbConn.php';
	  $xval ='';
	  $rsx       =$s_mysqli->query($xsql);
    $rsx_rows =mysqli_num_rows($rsx);     //筆數    
    if ($rsx_rows<=0){    	 
    	 $xval=0;
    }
    else{        
    	 $xval=1;    	 
    }
    return $xval;
}


function run_sql2($xsql,$xact){        //$xact:dup=是否重複(已存在)
	  include '../sysinc/dbConn.php';
	  $xval ='';
	  $rsx      =$s_mysqli->query($xsql);
    $rsx_rows =mysqli_num_rows($rsx);     //筆數    
    if ($rsx_rows<=0){    	 
    	 $xval=0;
    }
    else{      	      
    	 while ($rsx_c =mysqli_fetch_row($rsx)){    
              $xval .='['.$rsx_c[0].'],';
       }       
       if ($xval<>''){
       	  $xval =substr($xval,0,strlen($xval)-1);
       }       
    }
    return $xval;
}
?>