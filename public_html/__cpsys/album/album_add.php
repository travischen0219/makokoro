<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Content-Type:text/html; charset=utf-8");

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

$m_kind ='';
if (isset($_GET['k'])){
   $m_kind =$_GET['k'];
} 
elseif (isset($_POST['hxx_mkind'])){
	 $m_kind =$_POST['hxx_mkind']; 
}	  
else{
	  echo 'error model!';
	  exit();
}


$nncat ='';

if (isset($_GET['cat'])){
	  $nncat =$_GET['cat'];
}	

include '../sysinc/m_serverchk.php';   //$m_apnm

$f_pky   ='caseid';
$f_table ='album_case';
$f_fld   ='wknm,wknm_en,display,wkinfo,wkinfo_en,wk_tit,wk_tit_en';
$f_ordr  ='';
$arr_fld =explode(',',$f_fld);
$nowid='';

//-- 
if (isset($_POST['pxx_id'])) {   
	$nowid    =$_POST['pxx_id'];
	$editmode ='EDIT';
	
	$sqlx ='SELECT '.$f_fld.' FROM '.$f_table.' WHERE caseid='.$nowid;	
  
  $rsm  =$s_mysqli->query($sqlx);
  $rsm_rows =mysqli_num_rows($rsm);  //筆數
  
  if ($rsm_rows<=0){
  	 header("location:".$m_apnm."_list.php");
  	 exit();
  }   
  
  $rsm_c =mysqli_fetch_row($rsm);   
  for($i=0;$i<count($arr_fld);$i++){      //動態宣告與塞值   	  
  	  $xxfld   ='f'.$arr_fld[$i];  	  
  	  ${$xxfld}=$rsm_c[$i];
   }	
  $fwkinfo =htmlspecialchars_decode($fwkinfo);  
  $fwkinfo_en =htmlspecialchars_decode($fwkinfo_en);
   
}	
else{
  $editmode='ADD';
   for($i=0;$i<count($arr_fld);$i++){      //動態宣告與塞值   	  
  	  $xxfld   ='f'.$arr_fld[$i];  	  
  	  ${$xxfld}='';
   }
}

if ($fdisplay ==''){
	 $fdisplay ='N';
}

$ff_txt_w=400;
$ff_txt_h=480;
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

textarea{
	 font-size:13px;
}
-->
</style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $m_title1.$m_title12 ?></title>
<link rel="stylesheet" type="text/css" href="../sysinc/css.css" charset="utf-8" />
<script src="../sysinc/validform.js" type="text/javascript"></script>
</head>
<body>	
<center>
<table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td><div id="main-id">
        	  <table width="98%" border="0" cellspacing="0" cellpadding="0">
              <tr class="main-id">
              	<td align="left"><?php echo $m_title1.'--'.$m_title2?></td>
              	<td align="right" class="w12"><a href="javascript:location.replace('<?php echo $m_apnm?>_list.php?m=<?php echo $m_apcode?>&k=<?php echo $m_kind?>');">&lt;&lt; 回上頁</a></td>
              </tr>
            </table> 	
            </div>
       	</td>
      </tr>      
</table><br/>
<table width="96%" cellSpacing="0" cellPadding="0" border="0" bGColor="#C1C1C1">    
	 <form name="reg" action="<?php echo $m_apnm ?>_save.php" method="post" enctype="multipart/form-data">
	<Tr>
  	<Td align=center class="w12">
  		<input type="hidden" name="hxx_editmode" value="<?php echo $editmode?>">
  		<input type="hidden" name="pxx_id" value="<?php echo $nowid ?>">
  		<input type="hidden" name="hxx_apcode" value="<?php echo $m_apcode ?>">
  		
  		<input type="hidden" name="hfx_mkind" value="<?php echo $m_kind ?>">
  		
      <Table cellSpacing="1" CellPadding="2" border="0" width="100%" class="w12">
            <Tr bgcolor="#D2D6D7"> 
              <Td align="center" nowap width=20%>分類名稱</Td>
              <Td nowrap align=left width=80%>
              	&nbsp;繁中:<input type="text" name="tfx_wknm" size="30" maxlength=50 value="<?php echo $fwknm ?>"><br/>
              	&nbsp;英文:<input type="text" name="tfx_wknm_en" size="30" maxlength=50 value="<?php echo $fwknm_en ?>">
             	</Td>
            </Tr>  
            
            
            <Tr bgcolor="#D2D6D7"> 
              <Td align="center" nowap>簡介標題</Td>
              <Td nowrap align=left>
              	&nbsp;繁中:<input type="text" name="tfx_wk_tit" size="30" maxlength=50 value="<?php echo $fwk_tit ?>"><br/>
              	&nbsp;英文:<input type="text" name="tfx_wk_tit_en" size="30" maxlength=50 value="<?php echo $fwk_tit_en ?>">
             	</Td>
            </Tr>  
            
            <tr bgcolor="#D2D6D7">
              <td align="center" valign="top" nowrap><br/>簡介 (繁體)</td>
              <td align=left>               
 <?php
	include_once "../CKEdit/ckeditor/ckeditor.php";
	$CKEditor =new CKEditor();
	$CKEditor->basePath = '../CKEdit/ckeditor/';	
	$CKEditor->config['height'] =250;
	$CKEditor->config['width']  =$ff_txt_w;		
	
	$config['toolbar'] = array(
	        array( 'Source', '-', 'Bold', 'Italic', 'Underline'),
	        array( 'Link', 'Unlink' ),
	        array( 'FontSize','TextColor'),
	        array( 'JustifyLeft','JustifyCenter','JustifyRight'),	        
	        array( 'PasteText'),
	       );	
	
	$CKEditor->editor("tfx_wkinfo",$fwkinfo, $config);	  
	?>          
              </td>
            </tr>     
      
      <tr bgcolor="#D2D6D7">
              <td align="center" valign="top" nowrap><br/>簡介 (英文)</td>
              <td align=left>               
 <?php
	include_once "../CKEdit/ckeditor/ckeditor.php";
	$CKEditor =new CKEditor();
	$CKEditor->basePath = '../CKEdit/ckeditor/';	
	$CKEditor->config['height'] =250;
	$CKEditor->config['width']  =$ff_txt_w;		
	
	$config['toolbar'] = array(
	        array( 'Source', '-', 'Bold', 'Italic', 'Underline'),
	        array( 'Link', 'Unlink' ),
	        array( 'FontSize','TextColor'),
	        array( 'JustifyLeft','JustifyCenter','JustifyRight'),	        
	        array( 'PasteText'),
	       );	
	
	$CKEditor->editor("tfx_wkinfo_en",$fwkinfo_en,$config);	  
	?>          
              </td>
            </tr>  
            
            
            
            
            
            
                    
            <tr>
             <td colspan="2" align="center" valign="top" bgcolor="#B0B6B9">
              	<input type="button"  class="cbutton" value="回上頁" onclick="javascript:location.replace('<?php echo $m_apnm?>_list.php?m=<?php echo $m_apcode?>&k=<?php echo $m_kind ?>');">
              	&nbsp;&nbsp;<input type="button" class="cbutton" id="btnsure" value="確定送出" onclick="javascript:datachk();" ></td>
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
	parent.frames[0].document.getElementById("divpath").innerHTML="<?php echo $m_title1.' &gt; '.$m_title2?>" ;
	
	var oform = document.reg;		
	function datachk(){				
	  var errMsg = "";	  	  	  
    
    if (oform.tfx_wknm.value==''){
        errMsg ="[分類名稱] " ;    
    }                  
    
    if (errMsg !="") { 
       alert ('請輸入:'+errMsg);         
    } 
    else{
    	  document.getElementById("btnsure").disabled=true;
         oform.submit();             
    } 		 
  }       
</script>