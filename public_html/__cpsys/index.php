<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);

session_start();
$fpwd =	false; 
if (isset($_SESSION['sys_pass'])){     //empty() 也可以
   if ($_SESSION['sys_pass']){
	   $fpwd = true; 
   }      
} 

$s_title ='真心蓮坊 網站管理';
if ($fpwd){	 	 	 
   header("location:sysindex.php");
   exit();  
}
else{
    //---------------------------------------
    $sys_pass = '';
    if (isset($_GET['ng'])){
    	 if ($_GET['ng']=='login'){
    	 	  include 'sysinc/dbConn.php';
    	 	  $facc =htmlspecialchars ($_POST['tfx_acc']);
    	 	  $fpwd =md5(htmlspecialchars ($_POST['tfx_pwd']));    	 	      	 	  
    	 	  
    	 	  $sqlx     ="select loginid,username,userid,groupid from infouser where (loginid='".$facc."' and loginpwd='".$fpwd."')" ;
          $rs       =$s_mysqli->query($sqlx)or die('sql錯誤!: '.$sqlx.'<br/>' . mysql_error()).'<br/>'; 
          $num_rows =mysqli_num_rows($rs);  //筆數
          
          if ($num_rows <=0){
          	 $sys_pass = 'err';
          	 include 'loginck.php';
          }
          else{
          	 $sys_pass ='t';
          	 include 'sysinc/m_func.php';          	  
             date_default_timezone_set("Asia/Taipei");          	 
          	 $rsrow  =mysqli_fetch_assoc($rs);
          	 $_SESSION['sys_pass']   =true;
          	 $_SESSION['sys_acc']    =$rsrow['loginid'];
          	 $_SESSION['sys_user']   =$rsrow['username'];
          	 $_SESSION['sys_userid'] =$rsrow['userid'];
          	 $_SESSION['sys_groupid']=$rsrow['groupid'];
          	 
          	 $_SESSION['sys_title']  =$s_title;          	 
          	 $_SESSION['sys_uip']    =getip();
          	 $_SESSION['sys_utime']  =date('Y-m-d H:i');          	           	 
          	 
          	 header("location:sysindex.php");          	 
    	       exit();
          }      
    	 }
    }
    else{
       include 'loginck.php';    
    }   
}
?>