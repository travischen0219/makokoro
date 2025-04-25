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

//---
//---
$m_pky   ='cid';
$m_table ='servmail';
$m_fld   ='cid,mailbox,editor,editdate,serv_tel,serv_mail,facebook,blog,serv_tel,addr,serv_fax,photo1,line,serv_cell,addr_ch,addr_en,serv_tel_en,serv_fax_en';
$m_ordr  ='';

$sqlx    ='select '.$m_fld.' from '.$m_table ;
$rsm      =$s_mysqli->query($sqlx);
$rsm_rows =mysqli_num_rows($rsm);  //筆數

$nowid='';
if ($rsm_rows>0){
	 $editmode ='EDIT';
	 
	 $rsm_c =mysqli_fetch_assoc($rsm);
   extract($rsm_c, EXTR_PREFIX_ALL,'f'); 	      
	 
   $streditor ='['.$f_editor.']&nbsp;&nbsp;'.$f_editdate;   
   $nowid =$f_cid;
}
else{
	 $editmode ='ADD';	 
	 $arr_fld =explode(',',$m_fld);
   for($i=0;$i<count($arr_fld);$i++){      //動態宣告與塞值   	  
  	  $xxfld ='f_'.$arr_fld[$i];  	  
  	  ${$xxfld} ='';
   }	 	 
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $s_aptitle?>:::管理中心:::</title>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;	
	background-color: #CCCCCC;
}
-->
</style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $m_title1.$m_title12 ?></title>
<link rel="stylesheet" type="text/css" href="../sysinc/css.css" charset="utf-8" />
<script src="../sysjs/validform.js"></script>
</head>
<body>	
<center>
<table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td align="left"><div id="main-id"><?php echo $m_title1.'--'.$m_title2?></div></td>
      </tr>      
</table><br/>
<table width="75%" cellSpacing="0" cellPadding="0" border="0" bGColor="#C1C1C1">    
	 <form name="reg" action="<?php echo $m_apnm ?>_save.php" method="post" enctype="multipart/form-data">
	<Tr> 
  	<Td align=center class="w12">
  		<input type="hidden" name="hxx_editmode" value="<?php echo $editmode?>">
  		<input type="hidden" name="pxx_id" value="<?php echo $nowid ?>">
  		<input type="hidden" name="hxx_apcode" value="<?php echo $m_apcode ?>">
      <Table CellSpacing="1" CellPadding="2" border="0" width="100%" class="w12">      	              
      	   <Tr bgcolor="#D2D6D7"> 
              <Td align="center" width="15%">客服信箱</Td>
              <Td width="80%" align=left>&nbsp;<input type="text"  name="tfx_serv_mail" size="50" maxlength=50 value="<?php echo $f_serv_mail ?>"><br/>
              	&nbsp;&nbsp;<font color="#0066CC">●公開在網頁上的信箱
              	</font>              	
              	</Td>
            </Tr> 
            <Tr bgcolor="#D2D6D7"> 
              <Td align="center" width="15%">系統收件信箱</Td>
              <Td width="80%" align=left>&nbsp;<input type="text"  name="tfx_mailbox" size="60" maxlength=200 value="<?php echo $f_mailbox ?>"><br/>
              	&nbsp;&nbsp;<font color="#0066CC">●接收客服諮詢通知的信箱</br>
              	&nbsp;&nbsp;●多組信箱請用半形逗號隔開
              	</font>              	
             	</Td>
            </Tr>
            <tr>
             <td colspan="2" align="center" valign="top" bgcolor="#B0B6B9">              	
              	&nbsp;&nbsp;<input type="button" class="cbutton" id="btnsure" value="確定存檔" onclick="javascript:datachk();" ></td>
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
	parent.frames[0].document.getElementById("divpath").innerHTML="<?php echo $m_title1.' &raquo; '.$m_title2?>";
	
	var oform = document.reg;		
	function datachk(){				
	  var errMsg = "";	  
	  
	  if (oform.tfx_mailbox.value==''){
        errMsg +="[客服信箱]\n " ;
    }     
        
    if (errMsg !="") { 
       alert ('請檢查欄位:\n'+errMsg);         
    } 
    else{   
    	 document.getElementById("btnsure").disabled=true;
       oform.submit();             
    }		 
  }
  
  function gowindow(){
  	var nnap ='wcat_list.php';  	
  	var nnwin = window.open(nnap+'?m=<?php echo $m_apcode?>','getcat','width=600,height=780,top=0,left=380,toolbar=no,menubar=no,scrollbars=yes,resizable=yes,location=no,status=no');  	
  } 
</script>  	