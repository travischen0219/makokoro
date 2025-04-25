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

$nowid =$fsys_userid;

if ($nowid==''){
	  echo '<script>location.replace("../")</script>';
	  exit();
}
	
$sqlx     ='select userid,loginid,loginpwd,username,groupid from infouser where userid='.$nowid;    
$rsm      =$s_mysqli->query($sqlx,$s_link);
$rsm_rows =mysqli_num_rows($rsm);  //筆數
  
if ($rsm_rows<=0){
	  echo '<script>location.replace("../")</script>';
    exit();
}   
$rsrow = mysqli_fetch_row($rsm); 
  
$floginid  =$rsrow[1];
$floginpwd =$rsrow[2];
$fusername =$rsrow[3];
$fgroupid  =$rsrow[4];  
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $m_title1.'-'.$m_title2 ?></title>
<link rel="stylesheet" type="text/css" href="../sysinc/css.css" charset="utf-8" />
</head>
<body>	
<center>
<table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td align="left">
        	<div id="main-id">
        	<table width="98%" border="0" cellspacing="0" cellpadding="0">
            <tr class="main-id">
              <td align="left"><?php echo $m_title1.'--'.$m_title2?></td>
             	<td align="right" class="w12">&nbsp;</td>
            </tr>
          </table>
         	</div>
        </td>              	
      </tr>      
</table><br/>
<table width="50%" cellSpacing="0" cellPadding="0" border="0" bGColor="#C1C1C1">    
	 <form name="reg" action="<?php echo $m_apnm?>_save.php" method="post" class="long">
	<Tr> <!--userid,loginid,loginpwd,username-->
  	<Td align=center class="w12">  		
  		<input type="hidden" name="pxx_id" value="<?php echo $nowid ?>">
  		<input type="hidden" name="hxx_apcode" value="<?php echo $m_apcode ?>">
  		<input type="hidden" name="hxx_editmode" value="edit">
      <Table CellSpacing="1" cellPadding="2" border="0" width="100%" class="w12">
            <Tr bgcolor="#D2D6D7"> 
              <Td align="center" width="20%">登入帳號</Td>
              <Td width="80%" align=left>&nbsp;<?php echo $floginid ?></Td>
            </Tr>            
            <Tr bgcolor="#D2D6D7"> 
              <Td align="center">變更密碼</Td>
              <Td align=left>&nbsp;
                <input type="password" class="txtinput" name="pfx_loginpwd" size="15" maxlength=100 value="">
                <input type="hidden" name="hxx_pwd" size="20" maxlength=50 value="<?php echo $floginpwd ?>">
              </Td>
            </Tr>
            <Tr bgcolor="#D2D6D7"> 
              <Td align="center">使用者名稱</Td>
              <Td align=left>&nbsp;
                <input type="text" class="txtinput" name="tfx_username" size="20" maxlength=30 value="<?php echo $fusername ?>">
              </Td>
            </Tr>             
            <tr>
             <td colspan="2" align="center" valign="top" bgcolor="#B0B6B9">
              	<!--input type="button"  class="cbutton" value="回上頁" onclick="javascript:location.replace('<?php echo $m_apnm ?>_list.php?m=<?php echo $m_apcode?>');"-->&nbsp;
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
		
	var oform = document.reg;		
	function datachk(){				
	  var errMsg = "";    
    
    if (oform.tfx_username.value.match(/[^\n^\s]/)==null){
        errMsg +="[使用者名稱] \n" ;         
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