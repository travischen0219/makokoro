<?php 
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);

if (isset($_GET['m'])){
   $m_apcode =$_GET['m'];
}   
else{
	  header("location:./");
	  exit();
}

/* m_kind  程式單元      
*/

$m_kind ='';   //那個單元 wk1...wk5

if (isset($_GET['k'])){
   $m_kind =$_GET['k'];
}   
else{
	  header("location:./");
	  exit();
}

include '../sysinc/m_serverchk.php';   //$m_apnm 


$sqlx     ='select caseid from album_case where mkind=\''.$m_kind.'\'';
$rs       = $s_mysqli->query($sqlx);
$num_rows = mysqli_num_rows($rs);  //筆數

//--------------------
$pagesize =30;    //每頁n筆
$totpage  =ceil($num_rows/$pagesize);    //總頁數
$nowpage  =1;
$nowcnt   =0;
if (isset($_POST['hxx_nowpage'])) {   //第幾頁
	$nowpage =$_POST['hxx_nowpage'];
	$nowcnt  =$_POST['hxx_nowcnt'];
}	

if ($nowpage==''){$nowpage=1;}
if ($nowcnt==''){$nowcnt =0;}
//echo $nowpage.'<br/>';
$beginrec =($nowpage-1)*$pagesize;
$nowcnt   =$beginrec;
//------------------------------------------
$sqlx = 'select caseid,wknm,wknm_en,stitle,photo,sno,display '.
        'from album_case  '.
        'where mkind=\''.$m_kind.'\' '.
        'order by sno '.
        'limit '.$beginrec.','.$pagesize;

//echo $sqlx;
//exit();
$rsm      = $s_mysqli->query($sqlx);
$rsm_rows = mysqli_num_rows($rsm);  //筆數

include '../sysinc/m_func.php'; 

$ff_tr_cnt =5;
$ff_cov ='f';
if ($m_kind=='1'){	 
	 $arr_fld=array('代表圖 / 分類名稱','專案相片集');		 
	 //$ff_cov ='t';
}
else{
	 $ff_cov='t'; 
	 $arr_fld=array('單元名稱','輪播圖集');		 
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<script src="../sysinc/validform.js" type="text/javascript"></script>
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

#sxx_cat{
	 font-size:15px;
	 line-height:23px;
	 border:1px solid #c00;
   color:green;
}
-->
</style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $m_title1.$m_title12 ?></title>
<link rel="stylesheet" type="text/css" href="../sysinc/css.css" />
</head>
<center>     
   <table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td align="left"><div id="main-id"><?php echo $m_title1.'--'.$m_title2?></div></td>
      </tr>      
      <!tr>
        <td height="40" align="left">
        	
        	<table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td><table border="0" cellspacing="1" cellpadding="0">
                <tr>                	                	
                  <td nowrap><img src="../images/n01.png" border="0" onclick="javascript:location.replace('<?php echo $m_apnm ?>_add.php?m=<?php echo $m_apcode ?>&k=<?php echo $m_kind?>');" style="cursor:pointer;" /></td>
                  <td nowrap><img src="../images/n03.png" border="0" onclick="javascript:chk_del('<?php echo $m_apnm ?>_del');" style="cursor:pointer;" /></td>                  
                  <td nowrap><img src="../images/n04.png" border="0" onclick="javascript:gosts('<?php echo $m_apnm ?>_display','Y');" style="cursor:pointer;"></td>
                  <td nowrap><img src="../images/n05.png" border="0" onclick="javascript:gosts('<?php echo $m_apnm ?>_display','N');" style="cursor:pointer;"></td>                  
                  <?php
                      if ($rsm_rows>1){                      	  
                        echo '<td nowrap align="right"><img src="../images/ndwn.png"  border="0" onClick="javascript:saveSort(\''.$m_apnm.'\');" style="cursor:pointer;"></td>';
                      }                        
                   ?>                                    
                	<td width="80%">&nbsp;</td>
                </tr>
              </table>
             </td>              
            </tr>
          </table>         
        </td>
      </tr>
  </table>
  <table width="99%" border="0" cellpadding="3" cellspacing="1" class="w12">
  	<form name="reg" action="" method="post">  		
    <tr class="w12白">
      <td width="5%"  align="center" background="../images/bg3.gif"><input type='checkbox' id='chkall' value='Y' onclick="javascript:chk_all('reg',this);" <?php if ($rsm_rows<=1){echo 'disabled';}?> ></td>
      <td width="5%"  align="center" background="../images/bg3.gif" >No.</td>
      <td width="62%" align="center" background="../images/bg3.gif"><?php echo $arr_fld[0]?></td>
      <td width="10%"  align="center" background="../images/bg3.gif" class="w12白"><font color=yellow><?php echo $arr_fld[1]?></font></td>       
     	<td width="6%"  align="center" background="../images/bg3.gif" class="w12白">修改
     		<input type="hidden" name="hxx_apcode" value="<?php echo $m_apcode ?>">
       <input type="hidden" name="pxx_id">
       <input type="hidden" name="hxx_caseid">
       <input type="hidden" name="hxx_casenm">
       <input type="hidden" name="hxx_sts">
       <input type="hidden" name="hxx_plugno">       
       <input type="hidden" name="hxx_totchk">
       <input type="hidden" name="hxx_pos">       
       <input type="hidden" name="hxx_mkind" value="<?php echo $m_kind ?>">
     	</td>     	       
      <td width="6%" align="center" background="../images/bg3.gif" >狀態</td>      
    </tr>
    <?php  // caseid,wknm,wknm_en,stitle,photo,sno,display
      $bgcolor='';
     // $ftoday =date('Y-m-d'); 
      $nncnt =$nowcnt;     
      $xrec =0;
      $str_tr ='';
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
        if ($rsrow[6]=='Y'){         	  
        	 $strdispimg ='on.gif';
        }
        else{         	  
         	 $strdispimg ='off.gif';
        } 
        /*
        $xxnote =$rsrow[4];
        if ($xxnote<>''){
        	  $xxnote =$xdigest=CuttingStr(SpHtml2Text(htmlspecialchars_decode($xxnote)),70).'...';        	  
        } */   
        
        $str_tit =$rsrow[1];
        if ($rsrow[2]<>''){
        	 $str_tit .=' / '.$rsrow[2];
        }
        
         $nnphoto =$rsrow[4];
         if ($nnphoto<>''){             
        	  $arypic =explode(".",$nnphoto);
            $nnphoto =$ffiledir.$arypic[0].'_b.'.$arypic[1];             
         }   
         else{
         	  $nnphoto ='../images/noimg2.jpg';
         }         
                 
       $str_tr .="<tr bgcolor='".$bgcolor."'>".
             "<td align='center' id='Td1_".$nncnt."'><input type='checkbox' id='chkDel".$nncnt."' name='chkDel".$nncnt."' value='".$rsrow[0]."' onClick='javascript:chkthis(this);'></td>".
             "<td align='center'>".
             "<table width='100%' border=0 cellpadding=0 cellspacing=0 class='w12'>".
             "<tr>".
             "<td rowspan=2 align='right'><div id='divno'>".$nncnt."</div></td>".
             "<td align='center'><img src='../images/arrow-upper.png' width=10 height=10 style='cursor:pointer;' onclick='javascript:gosort(\"".$nncnt."\",\"u\");'></td>".
             "</tr>".
             "<tr>".
             "<td align='center'><img src='../images/arrow-downer.png' width=10 height=10 style='cursor:pointer;' onclick='javascript:gosort(\"".$nncnt."\",\"d\");'>".
             "<input type='hidden' id='tfx_sno".$nncnt."' name='tfx_sno".$nncnt."' value='".$rsrow[0]."'>".             
             "</td>".
             "</tr>".
             "</table>".
             "</td>";
             if ($ff_cov=='t'){
                $str_tr .="<td align='left' id='Td2_".$nncnt."'><table border=0 cellspacing=0 cellpadding=0>".
                          "<tr>".
                           "<td align='center'><a href='javascript:goedit(\"".$m_apnm."_add\",".$rsrow[0].");'><img src='".$nnphoto."' width=100 border=0></a></td>".
                           "<td class='w12'>&nbsp;<a href='javascript:goedit(\"".$m_apnm."_add\",".$rsrow[0].");'>&nbsp;".$str_tit."</a></td>".
                         "</tr>".
                         "</table></td>";
             }
             else{
             	  $str_tr .="<td align='left' id='Td2_".$nncnt."'><a href='javascript:goedit(\"".$m_apnm."_add\",".$rsrow[0].");'>".$str_tit."</a></td>";
             }            
             $str_tr .="<td align='center' id='Td3_".$nncnt."'><a href='javascript:goportfo(\"".$rsrow[0]."\",\"".$rsrow[1]."\");'><img src='../images/bt-file.gif' width=23 height=23 border=0></a></td>".
             "<td align='center' id='Td4_".$nncnt."'><img src='../images/bt-revise.gif' border=0 style='cursor:pointer;' onclick='javascript:goedit(\"".$m_apnm."_add\",".$rsrow[0].");'></td>".
             "<td align='center' id='Td5_".$nncnt."'><img src='../images/".$strdispimg."'/> </td>";
             
        $str_tr .="</tr>";
     }
     echo $str_tr;
    ?>        
   </form> 
       
  </table>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  	<form name="reg1" action="" method="post">
    <tr>
      <input type="hidden" name="hxx_nowpage">
      <input type="hidden" name="hxx_nowcnt" value="<?php echo $nncnt ?>">      
      <input type="hidden" id="hxx_td" value="<?php echo $ff_tr_cnt ?>">
       <input type="hidden" id="hxx_rec" value="<?php echo $xrec?>">     
      </td>
    </tr>
    <tr>
      <td align="center" class="w12">      	
      	<?php 
          if($totpage>1){
          	 echo "共 ".$num_rows." 筆，";          	             
             for($i=1;$i<=$totpage;$i++){ 
                echo '<a href="javascript:gopage('.$i.')">'.$i;
                if ($i<>$totpage){
                	 echo ' | ';
                }
                echo '</a>';
             }                          
          }
        ?>
      	</td>
    </tr>
    </form>
  </table>
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
</center> 
</body>
</html>
<script src="../sysjs/common_list_ctrl.js" type="text/javascript"></script>
<script language=javascript>
	parent.frames[0].document.getElementById("divpath").innerHTML="<?php echo $m_title1.' &gt; '.$m_title2?>" ;	  
  
 
 function goportfo(nnid,ncnm){ 	 
  	   oform.hxx_caseid.value =nnid;
  	   oform.hxx_casenm.value =ncnm;
       oform.action ="portfo_list.php";
       oform.submit();
 }
</script> 	