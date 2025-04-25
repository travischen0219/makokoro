<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);

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
include '../sysinc/m_func.php';   //$m_apnm

$f_fld ='title,title_ch,title_en,stitle,stitle_ch,stitle_en,lnk_buy,lnk_more,photo,display,editor,editdate,boxalign';	        
$arr_fld =explode(',',$f_fld);

if (isset($_POST['pxx_id'])) {   
	$nowid    =$_POST['pxx_id'];
	$editmode ='EDIT';		
  	
	$sqlx = "select ".$f_fld." from vi_ci where bid=".$nowid;
	
  $rsm      =$s_mysqli->query($sqlx);
  $rsm_rows =mysqli_num_rows($rsm);  //筆數
  
  if ($rsm_rows<=0){
  	  echo ("access error");
  	  exit();
  }
   
  $rsrow =mysqli_fetch_row($rsm); 
  
  for($i=0;$i<count($arr_fld);$i++){      //動態宣告與塞值   	  
  	  $xxfld   ='f'.$arr_fld[$i];  	  
  	  ${$xxfld}=$rsrow[$i];
  }
  
 //$fsnote =htmlspecialchars_decode($fsnote);  
  $streditor ='['.$feditor.']&nbsp;&nbsp;'.$feditdate;
}	
else{
  $editmode  ='ADD';
  $streditor =''; 
  
  for($i=0;$i<count($arr_fld);$i++){      //動態宣告與塞初始值   	  
  	  $xxfld   ='f'.$arr_fld[$i];
  	  ${$xxfld} ='';
  }  
  $fboxalign='L';
}
if ($fdisplay==''){
	  $fdisplay ='Y';
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
<link rel="stylesheet" type="text/css" href="../sysinc/css.css" charset="utf-8" />
<script src="../sysjs/validform.js"></script>
</head>
<body>	
<center>
<table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td align="left"><div id="main-id">
        	<table width="98%" border="0" cellspacing="0" cellpadding="0">
            <tr class="main-id">
              <td><?php echo $m_title1.'--'.$m_title2?></td>
             	<td align="right" class="w12"><a href="#" onclick="javascript:location.replace('<?php echo $m_apnm ?>_list.php?m=<?php echo $m_apcode ?>');">&lt;&lt; 回上頁</a></td>
            </tr>
          </table>
         	</div>
        </td>              	
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
            <!--Tr bgcolor="#D2D6D7"> 
              <Td align="center" width="15%">大標題</Td>
              <Td width="90%" align=left>
              	&nbsp;繁中：<input type="text" name="tfx_title"    size="50" maxlength=50 value="<?php echo $ftitle ?>"><br/>
              	&nbsp;簡體：<input type="text" name="tfx_title_ch" size="50" maxlength=50 value="<?php echo $ftitle_ch ?>"><br/>
              	&nbsp;英文：<input type="text" name="tfx_title_en" size="50" maxlength=100 value="<?php echo $ftitle_en ?>">
              	</Td>
            </Tr>
            <Tr bgcolor="#D2D6D7"> 
              <Td align="center" width="15%">副標題</Td>
              <Td width="90%" align=left>
              	&nbsp;繁中：<input type="text" name="tfx_stitle"    size="50" maxlength=50 value="<?php echo $fstitle ?>"><br/>
              	&nbsp;簡體：<input type="text" name="tfx_stitle_ch" size="50" maxlength=50 value="<?php echo $fstitle_ch ?>"><br/>
              	&nbsp;英文：<input type="text" name="tfx_stitle_en" size="50" maxlength=100 value="<?php echo $fstitle_en ?>">
              	</Td>
            </Tr>            
            <Tr bgcolor="#D2D6D7"> 
              <Td align="center" width="15%">連結網址</Td>
              <Td width="90%" align=left>
              	&nbsp;Find out more：<input type="text" name="tfx_lnk_more" size="60" maxlength=250 value="<?php echo $flnk_more ?>"><br/>
              	&nbsp;Buy Now：<input type="text" name="tfx_lnk_buy" size="60" maxlength=250 value="<?php echo $flnk_buy ?>"><br/>
              	&nbsp;網址格式:<font color="blue">http://www.xxx.com</font>
              	</Td>
            </Tr>
            
            <Tr bgcolor="#D2D6D7"> 
              <Td align="center" width="15%">標題區位置</Td>
              <Td width="90%" align=left>
              	<input type="radio" name="rfx_boxalign" value="L" <?php if ($fboxalign=='L'){echo 'checked';} ?> >置左
              	<input type="radio" name="rfx_boxalign" value="R" <?php if ($fboxalign=='R'){echo 'checked';} ?>>置右
             	</Td>
            </Tr-->
                        
            <tr bgcolor="#D2D6D7">
              <td align="center" valign="middle">圖片上傳</td>
              <td align="left"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="w12">
                  <tr>
                    <td class="w12" width="70%" nowrap><input type="file" class="cfile" name="up_photo" size="20"><br/>
                    	<div style="color:blue;font-size:14px"><?php if($editmode =='EDIT'){ echo '‧目前檔名:'.$fphoto.'<br/>'; }?>
                    		‧圖片尺寸: 1026 x 1582 <br/> 
                    		‧品質:90%<br/>
                    		‧圖片類型:jpg
                    		</div>
                   	</td>
                    <td align="left" width="30%">
                    	<?php
                    	 if ($fphoto<>''){     
                    	 	   $arypic =explode(".",$fphoto);
                           $fphoto =$arypic[0].'_b.'.$arypic[1];
                    	     echo '<img src="'.$ffiledir.$fphoto.'" width=200>';
                    	 }
                    	 else{
                    	 	  echo '&nbsp;';
                     	 } ?>
                   	</td>
                  </tr>
              </table>
              <input type="hidden" name="hxx_oldphoto" value="<?php echo $fphoto?>">
              </td>
            </tr>
            <tr bgcolor="#D2D6D7">
              <td align="center">資料狀態</td>
              <td align="left">
                <input type="radio" name="rfx_display" id="rfx_display" value="Y" <?php if($fdisplay=='Y'){echo 'checked';}?> >
                公開
                <input type="radio" name="rfx_display" id="rfx_display" value="N" <?php if($fdisplay=='N'){echo 'checked';}?>>
                隱藏                 
               </td>
            </tr>  
            
            <tr>
             <td colspan="2" align="center" valign="top" bgcolor="#B0B6B9">
              	<input type="button"  class="cbutton" value="返  回" onclick="javascript:location.replace('<?php echo $m_apnm?>_list.php?m=<?php echo $m_apcode?>');">
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
	
	var nedit='<?php echo $editmode?>';
	
	var oform = document.reg;		
	function datachk(){				
	  var errMsg = "";
	  
    if(nedit =='ADD'){        
      if (oform.up_photo.value==''){
      	  errMsg +="[圖片上傳]\n" ;
      }
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