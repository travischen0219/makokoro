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
  
$floginid ='';
$fusername='';
$floginpwd='';
$fgroupid ='';

$fright ='';

if (isset($_POST['pxx_id'])) {   
	$nowid   = $_POST['pxx_id'];
	$editmode= 'EDIT';
	$fright ='disabled';
	
	$sqlx     ='select userid,loginid,loginpwd,username,groupid  from infouser where userid='.$nowid;    
    $rsm      =mysql_query($sqlx,$s_link);
    $rsm_rows =mysql_num_rows($rsm);  //筆數
  
  if ($rsm_rows<=0){
  	  header("location:infouser.php");
  	  exit();
  }
   
  $rsrow = mysql_fetch_row($rsm); 
  
  $floginid  =$rsrow[1];
  $floginpwd =$rsrow[2];
  $fusername =$rsrow[3];
  $fgroupid  =$rsrow[4];
  
}	
else{
  $editmode='ADD';
}

//
$sqlx="select apgroupid,groupename,groupcname from apgrouplookup order by apgroupid";
$rsg      =mysql_query($sqlx,$s_link);
$rsg_rows =mysql_num_rows($rsg);  //筆數
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>:::::</title>
<link rel="stylesheet" type="text/css" href="../sysinc/css.css" charset="utf-8" />
<script src="../sysinc/getHttp.js" type="text/javascript" ></script>
<script src="../sysinc/chk_ajx.js" type="text/javascript"></script> 
</head>
<body>	
<center>
<table width="93%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td align="left">&nbsp;</td>
      </tr>      
</table>
<table width="50%" cellSpacing="0" cellPadding="0" border="0" bGColor="#C1C1C1">    
	 <form name="reg" action="infouser_save.php" method="post" class="long">
	<Tr> <!--userid,loginid,loginpwd,username-->
  	<Td align=center class="w12">
  		<input type="hidden" name="hxx_editmode" value="<?php echo $editmode?>">
  		<input type="hidden" name="pxx_id" value="<?php echo $nowid ?>">
  		<input type="hidden" name="hxx_apcode" value="<?php echo $m_apcode ?>">
      <Table CellSpacing="1" CellPadding="2" border="0" width="100%" class="w12">
            <Tr bgcolor="#D2D6D7"> 
              <Td align="center" width="20%">登入帳號</Td>
              <Td width="80%" align=left>&nbsp;
                <input type="text" class="txtinput" name="tfx_loginid" size="20" maxlength=20 value="<?php echo $floginid ?>" <?php echo $fright?>>
              </Td>
            </Tr>            
            <Tr bgcolor="#D2D6D7"> 
              <Td align="center" >登入密碼</Td>
              <Td align=left>&nbsp;
                <input type="password" class="txtinput" name="pfx_loginpwd" size="20" maxlength=50 value="<?php echo $floginpwd ?>">
              </Td>
            </Tr>
            <Tr bgcolor="#D2D6D7"> 
              <Td align="center">使用者名稱</Td>
              <Td align=left>&nbsp;
                <input type="text" class="txtinput" name="tfx_username" size="20" maxlength=20 value="<?php echo $fusername ?>">
              </Td>
            </Tr> 
            <Tr bgcolor="#D2D6D7"> 
              <Td align="center">權限群組</Td>
              <Td align=left>&nbsp;<select name="sfx_groupid" size=1>
              	   <option value=""></option>
              	<?php  //apgroupid,groupename,groupcname              	
              	   for($i=0;$i<$rsg_rows;$i++){
                       $rsg_c =mysql_fetch_row($rsg);
                       echo '<option value="'.$rsg_c[0].'">'.$rsg_c[1].'-'.$rsg_c[2].'</option>';
                   }?>
                 </select><script>document.reg.sfx_groupid.value="<?php echo $fgroupid?>"</script>
              </Td>
            </Tr> 
            <tr>
             <td colspan="2" align="center" valign="top" bgcolor="#B0B6B9">
              	<input type="button"  class="cbutton" value="回上頁" onclick="javascript:location.replace('infouser_list.php?m=<?php echo $m_apcode?>');">&nbsp;
                <input type="button" class="cbutton" id="btnsure" value="確定送出" onclick="javascript:datachk();" ></td>
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
	
	var nemod ='<?php echo $editmode ?>';	
		
	var oform = document.reg;		
	function datachk(){				
	  var errMsg = "";
    if (oform.tfx_loginid.value==''){
        errMsg ="[登入帳號] \n" ;
    }          
    else{
    	   if (nemod=='ADD'){
    	   	  var nval =chk_acc(oform.tfx_loginid.value);
    	   	  if (nval=='t'){
    	   	  	   errMsg +="[帳號重覆]\n " ;         
    	   	  }
    	  }
    }
    if (oform.pfx_loginpwd.value==''){
        errMsg +="[登入密碼] \n" ;         
    }  
    if (oform.tfx_username.value==''){
        errMsg +="[使用者名稱] \n" ;         
    }   
    
    if (oform.sfx_groupid.value==''){
    	   errMsg +="[權限群組] \n" ;         
    }
    
    if (errMsg !="") { 
       alert ('請檢查欄位:\n'+errMsg);         
    } 
    else{   
    	 document.getElementById("btnsure").disabled=true;
       oform.submit();             
    } 
		 
  }					
</script>  	