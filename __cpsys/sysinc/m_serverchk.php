<?php
if(! isset($_SESSION)) {
   session_start();
}  
$fpwd =false; 

//$nnurl =$_SERVER['HTTP_REFERER'];
//$nnp =strpos($nnurl,'_add.php'); //是否正要存檔

if (isset($_SESSION['sys_pass'])){     //empty() 也可以
   if ($_SESSION['sys_pass']){   	
   	  //----------- 
	    $fpwd = true; 
	    $fsys_user    =$_SESSION['sys_user'];
	    $fsys_userid  =$_SESSION['sys_userid'];
	    $fsys_groupid =$_SESSION['sys_groupid'];
	    $fsys_uip     =$_SESSION['sys_uip'];	   
   }         
}

include 'dbConn.php';

if ($fpwd){   
   $xadmin ='f';
   if ($_SESSION['sys_acc']=='s_pighead'){
   	  $xadmin ='t';
   }	
      
   //echo $xadmin.'<br/>';
   
   $sqlxx ="SELECT rights FROM apgroup ".
          "INNER JOIN infouser ON infouser.groupid = apgroup.apgroupid ".
          "WHERE infouser.userid =".$_SESSION['sys_userid']." and apgroup.apcode='".$m_apcode."'";
   
   $rs       =$s_mysqli->query($sqlxx);
   $num_rows =mysqli_num_rows($rs);  //筆數   

   if ($num_rows<=0 && $xadmin=='f'){
   	   echo "此單元無使用權限!!";
   	   exit();
   }
   else{
   	
   	   $sqlxx = "SELECT A1.apcname,A1.apcatid,A1.apename,A2.apcatename,A1.appath,A2.apcatcname ".
   	           "From ap AS A1,apcat A2 ".
   	           "Where A1.apcode ='". $m_apcode ."' And A1.apcatid=A2.apcatid ";
			             
   	   $rs       =$s_mysqli->query($sqlxx);
       $num_rows =mysqli_num_rows($rs);  //筆數  
       
       //echo '<br/>'.$sqlx.'<br/>';
       
       if ($num_rows>0){
          $rsrow =mysqli_fetch_assoc($rs);          
          $m_title1 =$rsrow['apcatcname'];   //apcatCname 模組中文名稱
	        $m_title2 =$rsrow['apcname'];   //apCname    Ap中文
	        $m_apnm   =$rsrow['apename'];   //apEname    Ap英文
          $m_apdir  =$rsrow['appath'];	  //ApPath     Ap路徑
          $s_aptitle ="真心蓮坊 網站管理";
          $ff_path   ='doc_files';
          $ffiledir  ='../../doc_files/';
       }   	   
   }   
}
else{
	
	 //echo '<script>parent.location.replace("../");</script>'; 
   exit();
}
?>
