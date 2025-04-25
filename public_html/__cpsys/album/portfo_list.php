<?php 
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);

$m_apcode ='';
if (isset($_POST['hxx_apcode'])){
   $m_apcode =$_POST['hxx_apcode'];
}   
else if(isset($_GET['m'])){
	 $m_apcode =$_GET['m'];	
}

if ($m_apcode==''){
   echo 'error list access !';
	 exit();
}

$strcat='';

$fcaseid ='';
$fcasenm ='';
if (isset($_POST['hxx_caseid'])){
   $fcaseid =$_POST['hxx_caseid'];
   $fcasenm =$_POST['hxx_casenm'];   
}   
else{
	 echo 'error parameter !';
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

include '../sysinc/m_serverchk.php';   //$m_apnm 

$ff_table ='album_gallery';
$ff_pk    ='caseid';

$sqlx     ='select caseid from '.$ff_table.' where '.$ff_pk.'='.$fcaseid;
$rs       =$s_mysqli->query($sqlx);
$num_rows =mysqli_num_rows($rs);  //筆數

//--------------------
$pagesize =30;    //每頁n筆
$totpage  =ceil($num_rows/$pagesize);    //總頁數
$nowpage  =1;

if (isset($_POST['hxx_nowpage'])) {   //第幾頁
	$nowpage =$_POST['hxx_nowpage'];
}	

if ($nowpage==''){$nowpage=1;}

$beginrec = ($nowpage-1)*$pagesize;
$nowcnt   =$beginrec;
//------------------------------------------
$sqlx = 'select wkid,photo,sno,display,title,price,push,sphoto,push_new,stitle,push_cov '.
        'from '.$ff_table.
        ' where '.$ff_pk.'='.$fcaseid.
        ' order by sno '.
        'limit '.$beginrec.','.$pagesize;

//echo $sqlx;
//exit();

$rsm      = $s_mysqli->query($sqlx);
$rsm_rows = mysqli_num_rows($rsm);  //筆數

include '../sysinc/m_func.php'; 

$m_apnm ='portfo';
$ff_cov ='f';
if ($m_kind=='1'){	 
	  $ff_cov ='t';
    $f_picsz='770x408px以內';
    $nn_rz  ='b,300,160|o,770,408';
    $f_pic_anm='pg';    
}
else{    	  
}    

$str_para =$m_apnm.','.$ff_table.','.$ff_pk.','.$fcaseid.','.$f_pic_anm.',album';    //批次上傳程式的參數 apname,table,pk,cid,nm,dir
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $s_aptitle?>::管理中心:::</title>
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
	margin-left: 0px;
	margin-top: 0px;
	margin-bottom: 0px;
	margin-right: 0px;
}

#plugno {
	position: absolute;	
	left:30%;
	top:150px;
	height:10px;
	z-index:1;
	display:none;
}

.divtable{
  border-collapse: collapse;
  background-color: #f7f7f7;
  border:1px #6699CC solid;    
  width:300px;
  font-family: 新細明體,arial, sans-serif; 
  font-size:15px;   
}
-->
</style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $m_title1.$m_title2 ?></title>
<link rel="stylesheet" type="text/css" href="../sysinc/css.css" />
<script src="../sysinc/validform.js" type="text/javascript"></script>
<script type="text/javascript" src="../jqs/jquery.min.js"></script>

</head>
<body>
<form name="reg" action="" method="post">
<center>     
   <table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr valign=top>
        <td align="left"><div id="main-id">
        	   <table width="98%" border="0" cellspacing="0" cellpadding="0">
              <tr class="main-id" valign=top>
              	<td align="left"><?php echo $m_title1.' &#187;'.$m_title2.' &#187;<b> ['.$fcasenm.'] </b> 專案相片集'?></td>
              	<td align="right" class="w12"><a href="javascript:location.replace('album_list.php?m=<?php echo $m_apcode?>&cat=<?php echo $strcat?>&k=<?php echo $m_kind?>');">&lt;&lt; 回上頁</a></td>
              </tr>
            </table> 	
        	  </div>
        </td>
      </tr>      
      <tr>
        <td height="40"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td><table border="0" cellspacing="1" cellpadding="0">
                <tr>
                  <td nowrap align="left"><img src="../images/n01.png" width="63" height="25" border="0" onclick="javascript:goupload();" style="cursor:pointer;" /></td>
                  <td nowrap align="left"><img src="../images/n03.png" width="63" height="25" border="0" onclick="javascript:chk_del('<?php echo $m_apnm ?>_del');" style="cursor:pointer;" /></td>                  
                  <td nowrap align="left"><img src="../images/n04.png" width="63" height="25" border="0" onclick="javascript:gosts('<?php echo $m_apnm ?>_display','Y');" style="cursor:pointer;"></td>
                  <td nowrap align="left"><img src="../images/n05.png" width="63" height="25" border="0" onclick="javascript:gosts('<?php echo $m_apnm ?>_display','N');" style="cursor:pointer;"></td>
                  <?php
                   if ($rsm_rows > 1){                      	  
                      echo '<td nowrap><img src="../images/ndwn.png" border="0" onClick="javascript:saveSort(\''.$m_apnm.'\');" style="cursor:pointer;"></td>';
                   } 
                   /*
                  if ($rsm_rows > 0){
                      echo '<td nowrap align="left">
                             <!--input type="button" class="cbutton" name="btnplugno" value="設為新品" onclick="javascript:go_push(\''.$m_apnm.'_push\',\'new\');"-->
                             <input type="button" class="cbutton" name="btnplugno" value="設為封面" onclick="javascript:go_push(\''.$m_apnm.'_push\',\'cov\');">
                            </td>';
                   }*/
                   ?>                  
                  <td width="90%">&nbsp;</td>
                </tr>
              </table>
             </td>              
            </tr>
          </table>
        </td>
      </tr>
  </table>
  <table width="99%" border="0" cellpadding="3" cellspacing="1" class="w12">  	
    <tr class="w12白">
      <td align="center" width="7%" background="../images/bg3.gif"><input type='checkbox' id='chkall' value='Y' onclick="javascript:chk_all('reg',this);" <?php if ($rsm_rows<=1){echo 'disabled';}?> ></td>
      <td align="center" background="../images/bg3.gif" width="7%">No.</td>
      <td align="center" background="../images/bg3.gif" width="68%">圖片</td>            
     	<td width="6%" align="center" background="../images/bg3.gif" class="w12白">修改</td>
     	<td width="6%" align="center" background="../images/bg3.gif" class="w12白">刪除</td>
     <td align="center" background="../images/bg3.gif" width="6%">狀態
     	 <input type="hidden" name="hxx_apcode" value="<?php echo $m_apcode ?>">
     	 <input type="hidden" name="hxx_apname" value="<?php echo $m_apnm ?>">
       <input type="hidden" name="hxx_wkid" value="<?php echo $fcaseid ?>">
       <input type="hidden" name="hxx_casenm" value="<?php echo $fcasenm ?>">       
       
       <input type="hidden" name="hxx_apdata" value="<?php echo $str_para?>">
       
       <input type="hidden" name="pxx_id">
       <input type="hidden" name="hxx_sts">
       <input type="hidden" name="hxx_caseid" value="<?php echo $fcaseid ?>">       
       <input type="hidden" name="hxx_plugno">
       <input type="hidden" name="hxx_totchk">
       <input type="hidden" name="hxx_pos"> 
       <input type="hidden" name="hxx_psize" value="<?php echo $f_picsz?>">
       <input type="hidden" name="hxx_rz" value="<?php echo $nn_rz?>"> 
       <input type="hidden" name="hxx_push" value="Y"> 
       <input type="hidden" name="hxx_mkind" value="<?php echo $m_kind ?>">
     	</td>
    </tr>
    <?php  // wkid,photo,sno,display,title,price,push,sphoto,push_new,stitle,push_cov
      $bgcolor='';
      $ftoday =date('Y-m-d');
      $nncnt =$nowcnt;  
      $xrec =0;
      for($i=0;$i<$rsm_rows;$i++){
         $rsrow =mysqli_fetch_row($rsm);
         $xrec +=1;
         
         if ( $i%2==0 ){
         	 $bgcolor='#FFFFFF';
         }
         else{
         	 $bgcolor='#EDEEEF';
         }
         
        $nncnt +=1;
        $nowno =strrev(substr(strrev('00'.$nncnt),0,2));  //右邊2個字元
        
        if ($rsrow[3]=='Y'){         	  
         	  $strdispimg ='on.gif';
         }
         else{         	  
         	  $strdispimg ='off.gif';
         }        

        if ($rsrow[7]<>''){     //sphoto
        	   $nnphoto =$rsrow[7];
        }
        else{
             $nnphoto =$rsrow[1];
             if ($nnphoto<>'' && $m_kind=='1' ){             	  
        	      $arypic =explode(".",$nnphoto);
                $nnphoto =$arypic[0].'_b.'.$arypic[1];                
            }
        }    
        
        $npush  =$rsrow[10];
        $ntitle =$rsrow[4];
        
        if ($rsrow[9]<>''){  //stitle
           if ($ntitle<>''){
           	  $ntitle .='/'.$rsrow[9];           	
           }	  
           else{
           	  $ntitle =$rsrow[9];
           }
        }       
        
        if ($npush=='Y'){
        	// $ntitle .='&nbsp;<img src=../images/push1.png border=0 style="margin-bottom:-10px" title="封面圖">';
        }
        $npush_new  =$rsrow[8];
        if ($npush_new=='Y'){
        	// $ntitle .='&nbsp;<img src=../images/push_new.png border=0 style="margin-bottom:-10px" title="新品">&nbsp;';
        }            
        
                         
        echo "<tr bgcolor='".$bgcolor."'>".
             "<td align='center' id='Td1_".$nncnt."'><input type='checkbox' id='chkDel".$i."' name='chkDel".$i."' value='".$rsrow[0]."' onClick='javascript:chkthis(this);'></td>".
             "<td align='center'>".
             "<table width='100%' border=0 cellpadding=0 cellspacing=0 class='w12'>".
             "<tr>".
             "<td rowspan=2 align='center'><div id='divno'>".$nncnt."</div></td>".
             "<td align='center'><img src='../images/arrow-upper.png' width=10 height=10 style='cursor:pointer;' onclick='javascript:gosort(\"".$nncnt."\",\"u\");'></td>".
             "</tr>".
             "<tr>".
             "<td align='center'><img src='../images/arrow-downer.png' width=10 height=10 style='cursor:pointer;' onclick='javascript:gosort(\"".$nncnt."\",\"d\");'>".
             "<input type='hidden' id='tfx_sno".$nncnt."' name='tfx_sno".$nncnt."' value='".$rsrow[0]."'>".
             "<input type='hidden' id='hxx_sno".$nncnt."' name='hxx_sno".$nncnt."' value='".$rsrow[2]."'>".
             "</td>".
             "</tr>".
             "</table>".
             "</td>".   
             "<td align='left' id='Td2_".$nncnt."'><table border=0 cellspacing=0 cellpadding=0>".
             "<tr>".
             "<td align='center'><img src='../../doc_files/".$nnphoto."' width=110></td>".
             "<td class='w12'>&nbsp;<a href='javascript:goedit(\"".$m_apnm."_add\",".$rsrow[0].");'>&nbsp;".$ntitle."</a></td>".
             "</tr>".
             "</table></td>".             
             "<td align='center' id='Td3_".$nncnt."'><img src='../images/bt-revise.gif' border=0 style='cursor:pointer;' onclick='javascript:goedit(\"".$m_apnm."_add\",".$rsrow[0].");'></td>".
             "<td align='center' id='Td4_".$nncnt."'><img src='../images/bt-delete.gif' border=0 style='cursor:pointer;' onclick='javascript:godel(\"reg\",\"".$i."\",\"".$m_apnm."_del\");'></td>".
             "<td align='center' id='Td5_".$nncnt."'><img src='../images/".$strdispimg."'/> </td>".
             "</tr>";
     }
    ?>    
  </table>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">  	
    <tr>
      <input type="hidden" name="hxx_nowpage">
      <input type="hidden" name="hxx_nowcnt" value="<?php echo $nncnt ?>">
       <input type="hidden" id="hxx_td" value="5">
       <input type="hidden" id="hxx_rec" value="<?php echo $xrec?>"> 
      </td>
    </tr>
    <tr>
      <td align="center" class="w12">      	
      	<?php 
          if($totpage>1){
          	 echo "共 ".$num_rows." 筆，";          	             
             for($i=1;$i<=$totpage;$i++){ 
                echo '<a href="javascript:gopage2('.$i.')">'.$i;
                if ($i<>$totpage){
                	 echo ' | ';
                }
                echo '</a>';
             }                          
          }
        ?>
      	</td>
    </tr>    
  </table>   
</center>
<div id="plugno" style="display:none;">
      <table cellpadding="3" border="0" bordercolor="" class="divtable">      	
      	<tr>
      		<td colspan=2 align=center background="../images/header.gif" style="color:#fff">資料排序設定</td>      		
      	</tr>      	
      	<tr>      	
      		<td nowrap>
      	     將勾選的資料,排在No.<input type="text" id="nfx_seno" name="nfx_seno" size=5 maxlength=4 onkeypress="javascript:return IsInt(event);">
      	     <input type=radio name="cxx_pos" value="bf" checked>之前
      	     <input type=radio name="cxx_pos" value="af">之後
      		</td>
      	</tr>      	 
      	<tr>
      		<td colspan="2" align="right">&nbsp;<input type="button" value="存檔" onclick="javascript:do_plugno('<?php echo $m_apnm?>_plugno')">
      			&nbsp;<input type="button" value="關閉" onclick="javascript:document.getElementById('plugno').style.display='none';"></td>
      	</tr>      
      </table>
 </div> 
 
    <div id="dataDiv1" name="dataDiv1" style="display:none;">
       <table cellpadding="3" border="1" bordercolor="#d6d6d6" class="divtable">
       	<tr>
       		<td align="center" nowrap>新品設定</td>
       		<td nowrap align="left">
       			&nbsp;<input type=radio id="rxx_regsts" name="rxx_regsts" value="Y" checked onclick="review_val(this)">設為新品
       			         <input type=radio id="rxx_regsts" name="rxx_regsts" value="N" onclick="review_val(this)">取消新品
       			</td>
       	</tr>      	
       	<tr>
       		<td colspan="2" align="center">&nbsp;<input type="button" value="確定送出" onclick="javascript:go_push('sv');">
       			&nbsp;<input type="button" value="關閉" onclick="$.unblockUI();"></td>
       	</tr>      
       </table>
    </div>  
</form>    
</body>
</html>
<script src="../sysjs/common_list_ctrl.js" type="text/javascript"></script>
<script language=javascript>
	parent.frames[0].document.getElementById("divpath").innerHTML="<?php echo $m_title1.' &gt; 作品集維護'?>" ;	 
 
 function goupload(){ 	
 	  alert("請先準備<?php echo $f_picsz?> 的相片");
 	  oform.action ="../portfoupload/index.php";
 	  oform.submit();
 }  

</script> 	