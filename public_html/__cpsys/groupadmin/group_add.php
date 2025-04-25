<?php
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

include '../sysinc/m_serverchk.php';   //$m_apnm
  
$fgroupename  ='';
$fgroupcname  ='';
$fgroupremark ='';
$fapgrouptype ='';    
$feditor      ='';    
$editdate     =''; 

$fright ='';

if (isset($_POST['pxx_id'])) {   
	$nowid   =$_POST['pxx_id'];
	$editmode='EDIT';
	
	$sqlx     ='select `groupename`,`groupcname`,`groupremark`,`apgrouptype`,`editor`,`editdate` 
	            from apgrouplookup where apgroupid='.$nowid; 	 
  $rsm      =$s_mysqli->query($sqlx);
  $rsm_rows =mysqli_num_rows($rsm);  //筆數
  
  if ($rsm_rows<=0){
  	  header("location:infouser.php");
  	  exit();
  }
   
  $rsrow =mysqli_fetch_row($rsm); 
  
  $fgroupename  =$rsrow[0];
  $fgroupcname  =$rsrow[1];
  $fgroupremark =$rsrow[2];
  $fapgrouptype =$rsrow[3];    
  $feditor      =$rsrow[4];    
  $editdate     =$rsrow[5];  
  
  if ( ($nowid ==1 || $nowid==2) & $fsys_userid<>1 ){   //最高權限,次高權限,店面權限群組．．不能修改
  	  $fright ='disabled';
  }  
  
  //--明細
   //$sqlx ='select apgroupid,apcode from apgroup where apgroupid='.$nowid.' and rights>0 ';   
   
  // $rsa        =mysql_query($sqlx,$s_link);
  // $rsa_rows =mysql_num_rows($rsa);  //筆數 
  
    //---各單元
    $sqlx ='select apcat.apcatid,apcat.apcatcname, ap.apcode, ap.apcname ,apg.apcode as ckcode 
            from apcat 
            left join ap on apcat.apcatid = ap.apcatid 
            left join (select apcode from apgroup where apgroupid='.$nowid.' and rights>0 ) as apg on ap.apcode=apg.apcode 
            order by apcat.apcatid,ap.apcode ';
}	
else{
     $editmode='ADD';
      //---各單元
    $sqlx ='select apcat.apcatid,apcat.apcatcname, ap.apcode, ap.apcname ,\'@@\' as ckcode 
            from apcat 
            left join ap on apcat.apcatid = ap.apcatid 
            order by apcat.apcatid,ap.apcode ';
}

$rsu      =$s_mysqli->query($sqlx);
$rsu_rows =mysqli_num_rows($rsu);  //筆數   
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>:::</title>
<link rel="stylesheet" type="text/css" href="../sysinc/css.css" charset="utf-8" />
</head>
<body>	
<center>
	<table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td align="left"><div id="main-id">
        	<table width="98%" border="0" cellspacing="0" cellpadding="0">
            <tr class="main-id">
              <td><?php echo $m_title1.'--'.$m_title2?></td>
             	<td align="right" class="w12"><a href="javascript:history.back()">&lt;&lt; 回上頁</a></td>
            </tr>
          </table>
         	</div>
        </td>              	
      </tr>      
</table><br/>
<table width="85%" cellSpacing="0" cellPadding="0" border="0" bGColor="#C1C1C1">    
	 <form name="reg" action="<?php echo $m_apnm?>_save.php" method="post" class="long">
	<Tr> <!--userid,loginid,loginpwd,username-->
  	<Td align=center class="w12">
  		<input type="hidden" name="hxx_editmode" value="<?php echo $editmode?>">
  		<input type="hidden" name="pxx_id" value="<?php echo $nowid ?>">
  		<input type="hidden" name="hxx_apcode" value="<?php echo $m_apcode ?>">
      <Table CellSpacing="1" CellPadding="2" border="0" width="100%" class="w12">
            <Tr bgcolor="#D2D6D7"> 
              <Td align="center" width="20%">群組英文名稱</Td>
              <Td width="80%" align=left>&nbsp;
              <input type="text" class="txtinput" name="tfx_groupename" size="20" maxlength=20 value="<?php echo $fgroupename ?>" <?php echo $fright?> >
              </Td>
            </Tr>   
             <Tr bgcolor="#D2D6D7"> 
              <Td align="center" width="20%">群組中文名稱</Td>
              <Td width="80%" align=left>&nbsp;
                <input type="text" class="txtinput" name="tfx_groupcname" size="20" maxlength=20 value="<?php echo $fgroupcname ?>"  <?php echo $fright?>>
              </Td>
            </Tr>   
            <Tr bgcolor="#D2D6D7"> 
              <Td align="center" width="20%">群組備註</Td>
              <Td width="80%" align=left>&nbsp;
                <input type="text" class="txtinput" name="tfx_groupremark" size="25" maxlength=30 value="<?php echo $fgroupremark ?>"  <?php echo $fright?>>
              </Td>
            </Tr>         
            <Tr bgcolor="#D2D6D7"> 
              <Td align="center" valign="top"><br/>權限設定</Td>
              <Td align=left>&nbsp;
             	<?php  //apcatid,apcatcname, apcode,apcname ,apcode2
              	 $xcatid="@@@";
                 $ix =0;
                 $ict=0;
                 $ibr=0;
                 for($i=0;$i<$rsu_rows;$i++){
                       $rsu_c =mysqli_fetch_row($rsu);
                       if ($xcatid<>$rsu_c[0]){
                          $ix +=1;
                          $xcatid=$rsu_c[0];
                          if ($ict>0){
                             echo '<br>';
                          }
                         echo '<font color="#003399">【'.$rsu_c[1].'】</font><br>';
                         $ibr=0;
                      }
                      
                      $xapcode1=$rsu_c[2];
                      $xapcode2=$rsu_c[4];
                      $xchk ='';
                      if ($xapcode1==$xapcode2){
                      	  $xchk ='checked';
                      }                      
                      if ( $xapcode1=='S00M01' || $xapcode1=='S00M02'){
                      	  $xright ='disabled';
                      	  $xright ='';
                      }
                      else{
                      	  $xright ='';
                      }
                      
                      echo '<input type="checkbox" name="chkap[]" value="'.$rsu_c[2].'" '.$xchk.' '.$fright.' '.$xright.'>'.$rsu_c[3].'&nbsp;';
                      
                     $ict +=1;
                     $ibr +=1;
                     if ( ($ibr % 7)==0){
                         echo '<br>';
                     }                        
                 }      
                 ?>         
              </Td>
            </Tr>            
            <tr>
             <td colspan="2" align="center" valign="top" bgcolor="#B0B6B9">
              	<input type="button"  class="cbutton" value="回上頁" onclick="javascript:location.replace('<?php echo $m_apnm?>_list.php?m=<?php echo $m_apcode?>');">&nbsp;
                <input type="button" class="cbutton" id="btnsure" value="確定送出" onclick="javascript:datachk();" <?php echo $fright?> ></td>
            </tr>                       
     </Table>
    </td>
     </Tr>
     </form>
  </table>
</center>
</body>
</html>
<script language=javascript charset="utf-8">				
	//parent.frames[0].document.getElementById("divpath").innerHTML="<?php echo $m_title1.' &gt; '.$m_title2?>" ;
	
	var oform = document.reg;		
	function datachk(){				
	   var errMsg = "";
       if (oform.tfx_groupename.value==''){
           errMsg +="[群組英文]\n" ;
       }          
       if (oform.tfx_groupcname.value==''){
           errMsg +="[群組中文]\n" ;
       }   
       
       var qryck =oform.elements["chkap[]"];     
       var nqry_ck=false;
       for (j=0;j<qryck.length;j++){
    	    if (qryck[j].checked){
    	  	   nqry_ck=true;
    	    } 
       }
    
       if (! nqry_ck){
    	    errMsg +="[權限設定]\n"
      }        
       
       if (errMsg !="") { 
           alert ('請輸入:\n'+errMsg);         
       } 
       else{   
       	    document.getElementById("btnsure").disabled=true;
           oform.submit();             
       } 
		 
  }					
</script>  	