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

include '../sysinc/m_serverchk.php';

$m_apnm ='';
if (isset($_POST['hxx_apname'])){	
	$m_apnm =$_POST['hxx_apname'];
}
else{
	 echo 'error access !!';
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
  
  
$fcaseid ='';
$fcasenm ='';
$strcat ='';
if (isset($_POST['hxx_wkid'])){
   $fcaseid =$_POST['hxx_wkid'];
   $fcasenm =$_POST['hxx_casenm'];
   //$strcat =$_POST['hxx_ctid'];
}   
else{
	 echo 'error parameter !!';
	 exit();
}  

$f_fld   ='wkid,caseid,title,photo,sno,display,push,push_new,editor,editdate,note,stitle,title_en';
$arr_fld = explode(',',$f_fld);
$f_table ='album_gallery';

if (isset($_POST['pxx_id'])) {   
	$nowid    =$_POST['pxx_id'];
	$editmode ='EDIT';
	
	$sqlx = "select ".$f_fld." from ".$f_table." where wkid=".$nowid;		
	
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
  
  $fnote =htmlspecialchars_decode($fnote);
  
}	
else{
  $editmode='ADD';  
  for($i=0;$i<count($arr_fld);$i++){      //動態宣告與塞初始值   	  
  	  $xxfld   ='f'.$arr_fld[$i];
  	  ${$xxfld} ='';
  } 
}

if ($m_kind=='1'){	 
    $str_picsz='770 x408 px';     
}
else{        
    $str_picsz='770 x408 px';         
}    
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $m_title1.'-'.$m_title12 ?></title>
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
<script src="../sysjs/validform.js" type="text/javascript"></script>
</head>
<body>	
<center>
<table width="93%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td align="left"><div id="main-id">        	
        	<table width="98%" border="0" cellspacing="0" cellpadding="0">
              <tr class="main-id">
              	<td align="left"><?php echo $m_title1.'--'.$m_title2.'--<b>['.$fcasenm.']</b>相片集維護'?></td>
              	<td align="right" class="w12"><a href="javascript:golist();">&lt;&lt; 回上頁</a></td>
              </tr>
            </table> 	
        	</div>        	
        	</td>
      </tr>      
</table>
<table width="93%" cellSpacing="0" cellPadding="0" border="0" bGColor="#C1C1C1">    
	 <form name="reg" action="<?php echo $m_apnm ?>_save.php" method="post" enctype="multipart/form-data">
	<Tr>
  	<Td align=center class="w12">
  		<input type="hidden" name="hxx_editmode" value="<?php echo $editmode?>">
  		<input type="hidden" name="pxx_id" value="<?php echo $nowid ?>">
  		<input type="hidden" name="hxx_apcode" value="<?php echo $m_apcode ?>">
  		<input type="hidden" name="hxx_apname" value="<?php echo $m_apnm ?>">
      <input type="hidden" name="hxx_caseid" value="<?php echo $fcaseid ?>">
      <input type="hidden" name="hxx_casenm" value="<?php echo $fcasenm ?>">  	
      <input type="hidden" name="hxx_ctid" value="<?php echo $strcat ?>">  
      <input type="hidden" name="hxx_mkind" value="<?php echo $m_kind ?>">     	
  		
      <Table CellSpacing="1" CellPadding="2" border="0" width="100%" class="w12">      	                         
            <!--Tr bgcolor="#D2D6D7"> 
              <Td align="center" width="15%">標題</Td>
              <Td width="85%" align=left>
              	<?php
              	  if ($m_kind=='1'){ ?>
              	      &nbsp;繁中:<input type="text" name="tfx_title" size="30" maxlength=50 value="<?php echo $ftitle ?>"><br/>
              	      &nbsp;英文:<input type="text" name="tfx_title_en" size="30" maxlength=50 value="<?php echo $ftitle_en ?>">
           <?php  }    
                  else { ?>
                   &nbsp;<input type="text" name="tfx_title" size="40" maxlength=50 value="<?php echo $ftitle ?>">
          <?php   }  ?>
            	</Td>
            </Tr-->                          
                                                                                   
            <tr bgcolor="#D2D6D7">
              <td align="center">狀態</td>
              <td align=left>
                <input type="radio" name="rfx_display" id="rfx_display" value="Y" <?php if($fdisplay=='Y'){echo 'checked';}?> >
                公開
                <input type="radio" name="rfx_display" id="rfx_display" value="N" <?php if($fdisplay=='N'){echo 'checked';}?>>
                隱藏                 
               </td>
            </tr>                                                
            <tr bgcolor="#D2D6D7">
              <td align="center" valign="middle">相片上傳</td>
              <td align=left><table width="95%" border="0" cellpadding="0" cellspacing="0" class="w12">
                  <tr>
                    <td class="w12" width="60%"><input type="file" class="cfile" name="up_photo" size="20"><br/>
                    	<font color="#0066CC"><?php if($editmode =='EDIT'){ echo '‧目前檔名:'.$fphoto.'<br/>'; }?>
                    		‧相片尺寸: <?php echo $str_picsz?><br/>
                    		</font>
                    	</td>
                    <td align="left" width="40%">
                    	<?php
                    	 if ($fphoto<>''){
                    	 	   /*
        	                 $arypic =explode(".",$fphoto);
                           $fphoto =$arypic[0].'_b.'.$arypic[1];                    	 	
                           */
                    	     echo '<img src="../../doc_files/'.$fphoto.'" width=200>';
                    	 }
                    	 else{
                    	 	   echo '&nbsp;';
                    	}
                    	 ?></td>                    	     
                  </tr>
              </table>
              <input type="hidden" name="hxx_oldphoto" value="<?php echo $fphoto?>">
              </td>
            </tr>
            <tr>
             <td colspan="2" align="center" valign="top" bgcolor="#B0B6B9">
              	<input type="button"  class="cbutton" value="回上頁" onclick="javascript:golist();">
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
	parent.frames[0].document.getElementById("divpath").innerHTML=="<?php echo $m_title1.' &gt; 產品集維護'?>"  ;
	
	var oform = document.reg;		
	function datachk(){					  
    document.getElementById("btnsure").disabled=true;
    oform.submit();
  }					
  
  function golist(){
  	  document.reg.action ="<?php echo $m_apnm?>_list.php";
  	  document.reg.submit();
  }
</script>  	