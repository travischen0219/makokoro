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
  
$ff_table ='news';
$ff_pk    ='bno';
$fphoto_b='';

$ff_fld ='title,publish_bdate,publish_sts,publish_edate,newsnote,display,photo,sphoto,ytid,filmurl,editdate,editor,title_en,newsnote_en';
$arr_fld =explode(',',$ff_fld);  
$nnfld_cnt =count($arr_fld);

if (isset($_POST['pxx_id'])) {  	
  $nowid    =$_POST['pxx_id'];
	$editmode ='EDIT';
	$sqlx ="select ".$ff_fld." from ".$ff_table." where ".$ff_pk."=".$nowid;	
	//echo $sqlx;
  $rsm  =$s_mysqli->query($sqlx);  
  $rsm_rows =mysqli_num_rows($rsm);  //筆數
  
  if ($rsm_rows<=0){
  	  echo ("access error");
  	  exit();
  }   
  $rsrow =mysqli_fetch_row($rsm);   
  for($i=0;$i<$nnfld_cnt;$i++){      //動態宣告與塞值   	  
  	  $xxfld   ='f'.$arr_fld[$i];  	  
  	  ${$xxfld}=$rsrow[$i];
  }    
  
  $fnewsnote    =htmlspecialchars_decode($fnewsnote); 
  $fnewsnote_en =htmlspecialchars_decode($fnewsnote_en); 
  
  $xxedate =date("Y-m-d H:i",strtotime($feditdate));  
  //$fcrdate =($fcrdate<>'')?date("Y-m-d H:i",strtotime($fcrdate)):'';  
  //$streditor =$xxedate.'&nbsp;&nbsp;'.$fuip.'&nbsp;&nbsp;['.$feditor.']';
  $streditor =$xxedate.'&nbsp;&nbsp;['.$feditor.']';
  
  if ($fphoto<>''){
      $xary_pic =explode('.',$fphoto);
      $fphoto_b =$xary_pic[0].'_b.'.$xary_pic[1];
  }        
   
}	
else{
  $editmode='ADD'; 
  for($i=0;$i<$nnfld_cnt;$i++){      //動態宣告與塞值   	  
  	  $xxfld   ='f'.$arr_fld[$i];  	  
  	  ${$xxfld}='';
  }     
  if ($fpublish_sts==''){
  	  $fpublish_sts ='o';
  }
  if ($fpublish_bdate==''){
  	  $fpublish_bdate =date('Y-m-d');
  }  
  
}

if ($fdisplay==''){
	 $fdisplay ='Y';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $m_title1.'-'.$m_title2 ?></title>
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
<link rel="stylesheet" href="../sysinc/_calendar/ui.datepicker.css" type="text/css" media="screen" title="core css file" charset="utf-8" />
<script src="../sysinc/_calendar/jquery.js"></script>		
<script src="../sysinc/_calendar/ui.datepicker.js" type="text/javascript" charset="utf-8"></script>
</head>
<body>	
<center>
<table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td><div id="main-id">
        	<table width="98%" border="0" cellspacing="0" cellpadding="0">
            <tr class="main-id">
              <td align="left"><?php echo $m_title1.'--'.$m_title2?></td>
             	<td align="right" class="w12"><a href="javascript:location.replace('<?php echo $m_apnm?>_list.php?m=<?php echo $m_apcode?>');">&lt;&lt; 回上頁</a></td>
            </tr>
          </table>
         	</div>
        </td>              	
      </tr>      
</table><br/>
<table width="99%" cellSpacing="0" cellPadding="0" border="0" bGColor="#C1C1C1">    
	 <form name="reg" action="<?php echo $m_apnm ?>_save.php" method="post" enctype="multipart/form-data">
	<Tr> <!--did,title,title_en,title_en,title_jp,publish_bdate,publish_edate,publish_sts,metatitle,metatitle_en,metatitle_en,metatitle_jp,photo,dinfo,dinfo_en,dinfo_en,dinfo_jp-->
  	<Td align=center class="w12">
  		<input type="hidden" name="hxx_editmode" value="<?php echo $editmode?>">
  		<input type="hidden" name="pxx_id" value="<?php echo $nowid ?>">
  		<input type="hidden" name="hxx_apcode" value="<?php echo $m_apcode ?>">
      <Table CellSpacing="1" CellPadding="2" border="0" width="100%" class="w12">
            <Tr bgcolor="#D2D6D7"> 
              <Td align="center" width="15%">文章標題</Td>
              <Td width="90%" align=left>
              	&nbsp;繁中<input type="text"  name="tfx_title" size="60" maxlength=100 value="<?php echo $ftitle ?>"><br/>
              	&nbsp;英文<input type="text"  name="tfx_title_en" size="60" maxlength=100 value="<?php echo $ftitle_en ?>"><br/>
             	</Td>
            </Tr> 
            <tr bgcolor="#D2D6D7">
              <td align="center">起始刊登</td>
              <td align="left">&nbsp;<input class="calendar" type="text" name="dxx_bdate" id="dxx_bdate" size=10 readonly value="<?php echo $fpublish_bdate ?>">
              	<input type="hidden" name="dfx_publish_bdate" value="<?php echo $fpublish_bdate ?>">
             	</td>
            </tr>
            <tr bgcolor="#D2D6D7">
              <td align="center">刊登設定</td>
              <td align="left">
                <input type="radio" name="rfx_publish_sts" id="rfx_publish_sts" value="o" <?php if($fpublish_sts=='o'){echo 'checked';}?> >
                永久刊登 
                <input type="radio" name="rfx_publish_sts" id="rfx_publish_sts" value="x" <?php if($fpublish_sts=='x'){echo 'checked';}?>>
                停止刊登 
                <input type="radio" name="rfx_publish_sts" id="rfx_publish_sts" value="d" <?php if($fpublish_sts=='d'){echo 'checked';}?>>
                刊登至 <input class="calendar" type="text" id="dxx_edate" readonly  size=10 value="<?php echo $fpublish_edate ?>">
                <input type="hidden" name="dfx_publish_edate" value="<?php echo $fpublish_edate ?>">
              </td>
            </tr>   
            <tr bgcolor="#D2D6D7">
              <td align="center">訊息狀態</td>
              <td align="left">
                <input type="radio" name="rfx_display" id="rfx_display" value="Y" <?php if($fdisplay=='Y'){echo 'checked';}?> >
                公開
                <input type="radio" name="rfx_display" id="rfx_display" value="N" <?php if($fdisplay=='N'){echo 'checked';}?>>
                隱藏                 
               </td>
            </tr>                                               
            <tr bgcolor="#D2D6D7">
              <td align="center" valign="top"><br/>文章內容<br/>(繁中)</td>
              <td align="left" valign="top" >              
              	<font color="blue">換行:Shift+Enter　段落:Enter </font><br/>
<?php
$ff_txt_h ='290';
$ff_txt_w ='800';
$xxtd_nm ='tfx_newsnote';

include_once "../CKEdit/ckeditor/ckeditor.php";
$CKEditor =new CKEditor();
$CKEditor->basePath ='../CKEdit/ckeditor/';	
$CKEditor->config['height'] =$ff_txt_h; 
$CKEditor->config['width']  =$ff_txt_w; 	

$config['toolbar'] = array(
                           array('Source', '-', 'Bold','Italic','Underline','Strike','HorizontalRule'),
                           array('Image','Table','Link', 'Unlink','list','Unlist'),
                           array('FontSize','TextColor','BGColor'),
                           array('JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'),
                           array('PasteText'),
                           );	
$CKEditor->editor($xxtd_nm,$fnewsnote,$config);	                                  
?>              
              </td>
            </tr> 
            <tr bgcolor="#D2D6D7">
              <td align="center" valign="top"><br/>文章內容<br/>(英文)</td>
              <td align="left" valign="top" >              
              	<font color="blue">換行:Shift+Enter　段落:Enter </font><br/>
<?php
$xxtd_nm ='tfx_newsnote_en';

include_once "../CKEdit/ckeditor/ckeditor.php";
$CKEditor =new CKEditor();
$CKEditor->basePath ='../CKEdit/ckeditor/';	
$CKEditor->config['height'] =$ff_txt_h; 
$CKEditor->config['width']  =$ff_txt_w; 	

$config['toolbar'] = array(
                           array('Source', '-', 'Bold','Italic','Underline','Strike','HorizontalRule'),
                           array('Image','Table','Link', 'Unlink','list','Unlist'),
                           array('FontSize','TextColor','BGColor'),
                           array('JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'),
                           array('PasteText'),
                           );	
$CKEditor->editor($xxtd_nm,$fnewsnote_en,$config);	                                  
?>              
              </td>
            </tr> 
            <!--tr bgcolor="#D2D6D7">
              <td align="center" valign="middle">代表圖</td>
              <td align="left"><table width="95%" border="0" cellpadding="0" cellspacing="0" class="w12">
                  <tr>
                    <td class="w12" width="60%" ><input type="file" class="cfile" name="up_photo" size="20"><br/>
                    	<font style='color:#0066CC;font-size:15px;'><?php if($editmode =='EDIT'){ echo '‧目前檔名:'.$fphoto.'<br/>'; }?>
                    		‧尺寸: 960 x 639px <br/>
                    		‧品質: 90%<br/>
                    		‧檔案型態:jpg
                    		</font>
                   	</td>
                    <td align="left" width="40%">
                    	<?php
                    	 if ($fphoto<>''){                      	 	                    	 	  
                    	    echo '<img src="'.$ffiledir.$fphoto_b.'" width=220>';
                    	 }
                    	 else{
                    	 	  echo '&nbsp;';
                     	 } ?>
                   	</td>
                  </tr>
              </table>
              <input type="hidden" name="hxx_oldphoto" value="<?php echo $fphoto?>">
              </td>
            </tr-->   
            
            <!--tr bgcolor="#D2D6D7">
              <td align="center" valign="middle">Youtube影片</td>
              <td align="left"><table width="95%" border="0" cellpadding="0" cellspacing="0" class="w12">                  
                  <tr>
                    <td class="w12" width="60%" valign=top style='color:#0066CC;font-size:15px;'>                    	
                    	&nbsp;網址:<input type="text" name="tfx_filmurl" size="60" value="<?php echo $ffilmurl ?>"><br/>
                    	<font color="#0066CC">
                    		&nbsp;&nbsp;‧輸入Youtube影片網址即可<br/>
                    		&nbsp;&nbsp;‧網址完整格式:<font color=red>http://</font>xxx.xxx.xxx/?v=xxxx...
                    	</font>                    		
                   	</td>
                    <td align="left" width="40%" id="i_film">
                    	<?php 
                    	  if ($fytid<>""){                    	  	 
                    	     echo '<object width="245" height="160">
                    	     <param name="movie" value="http://www.youtube.com/v/'.$fytid.'&hl=zh_TW&fs=1"></param>
                    	     <param name="allowFullScreen" value="true"></param>
                    	     <param name="allowscriptaccess" value="always"></param>
                    	     <embed src="http://www.youtube.com/v/'.$fytid.'&hl=zh&fs=1" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="245" height="160"></embed>
                    	     </object>';
                        }?>                     		
                   	</td>                    	     
                  </tr>
              </table>              
              </td>
            </tr-->                               
                                      
            <tr>
             <td colspan="2" align="center" valign="top" bgcolor="#B0B6B9">
              	<input type="button"  class="cbutton" id="btnprev" value="回上頁" onclick="javascript:location.replace('<?php echo $m_apnm?>_list.php?m=<?php echo $m_apcode?>');">
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
	jQuery(function($){
				$("#dateinput").datepicker();      	
      	$('#dxx_bdate').datepicker({dateFormat: 'yy-mm-dd', showOn: 'both', 
      		buttonImageOnly: true, buttonImage: '../sysinc/_calendar/calendar.gif'});      		
        $('#dxx_edate').datepicker({dateFormat: 'yy-mm-dd', showOn: 'both', 
      		buttonImageOnly: true, buttonImage: '../sysinc/_calendar/calendar.gif'});      		          		
			});							
	
	
	var oform = document.reg;		
	function datachk(){				
	  var errMsg = "";
           
    if (document.getElementById("dxx_bdate").value==''){
        errMsg +="[起始刊登日] " ;         
    }   
    
    if (!(oform.rfx_publish_sts[0].checked || oform.rfx_publish_sts[1].checked || oform.rfx_publish_sts[2].checked)){
    	 errMsg +="[刊登狀態] " ;
    }
    else if( oform.rfx_publish_sts[2].checked && document.getElementById("dxx_edate").value==''){
    	 errMsg +="[刊登至] " ;
    }        
    
    if (errMsg !="") { 
       alert ('請輸入:'+errMsg);         
    } 
    else{   
    	
    	  oform.dfx_publish_bdate.value =document.getElementById("dxx_bdate").value;
    	 
    	 if (oform.rfx_publish_sts[2].checked ){
    	    oform.dfx_publish_edate.value =document.getElementById("dxx_edate").value;
    	 }
    	 else{
    	 	  oform.dfx_publish_edate.value ='';
    	 }  
    	 
    	 document.getElementById("btnprev").disabled=true;
    	 document.getElementById("btnsure").disabled=true;
       oform.submit();             
    } 
		 
  }					
</script>  	