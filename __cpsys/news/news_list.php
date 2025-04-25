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

include '../sysinc/m_serverchk.php';   //$m_apnm 

$sqlx     ='select bno from news ';
$rs       = $s_mysqli->query($sqlx);
$num_rows = mysqli_num_rows($rs);  //筆數

//--------------------
$pagesize = 20;    //每頁10筆
$totpage  =ceil($num_rows/$pagesize);    //總頁數
$nowpage=1;
$nowcnt   =0;
if (isset($_POST['hxx_nowpage'])) {   //第幾頁
	$nowpage =$_POST['hxx_nowpage'];
	$nowcnt  =$_POST['hxx_nowcnt'];
}	

if ($nowpage==''){$nowpage=1;}

if ($nowcnt==''){$nowcnt =0;}
//echo $nowpage.'<br/>';

$beginrec = ($nowpage-1)*$pagesize;
$nowcnt   =$beginrec;
//------------------------------------------

$sqlx = 'select bno,title,publish_bdate,publish_sts,publish_edate,display,photo,sticky '.
        'from news '.
        'order by sticky IS NULL,sno '.
        'limit '.$beginrec.','.$pagesize;

//echo $sqlx;
//exit();

$rsm      = $s_mysqli->query($sqlx);
$rsm_rows = mysqli_num_rows($rsm);  //筆數

include '../sysinc/m_func.php'; 

$ff_top ='f' ;  //是否有置頂
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $m_title1.'-'.$m_title2 ?></title>
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
	margin-left: 0px;
	margin-top: 0px;
	margin-bottom: 0px;
	margin-right: 0px;
}
-->
</style>

<link rel="stylesheet" type="text/css" href="../sysinc/css.css" />
</head>
<body>
<center>     
   <table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">  
   	  <tr>
        <td align="left"><div id="main-id"><?php echo $m_title1.'--'.$m_title2?></div></td>
      </tr>     
      <tr>      
        <td height="40"><table border="0" cellspacing="1" cellpadding="0">
                <tr>  
                  <td nowrap><img src="../images/n01.png" width="63" height="25" border="0" onclick="javascript:location.replace('<?php echo $m_apnm ?>_add.php?m=<?php echo $m_apcode ?>');" style="cursor:pointer;" /></td>
                  <td nowrap><img src="../images/n03.png" width="63" height="25" border="0" onclick="javascript:chk_del('<?php echo $m_apnm ?>_del');" style="cursor:pointer;" /></td>
                  <td nowrap><img src="../images/n04.png" width="63" height="25" border="0" onclick="javascript:gosts('<?php echo $m_apnm ?>_display','Y');" style="cursor:pointer;"></td>
                  <td nowrap><img src="../images/n05.png" width="63" height="25" border="0" onclick="javascript:gosts('<?php echo $m_apnm ?>_display','N');" style="cursor:pointer;"></td>
                  <td nowrap align="right"><img src="../images/ndwn.png"  border="0" onClick="javascript:saveSort('<?php echo $m_apnm ?>');" style="cursor:pointer;"></td>
                  <?php
                   if($ff_top=='t'){ ?>
                   	  <td nowrap>&nbsp;<input type="button" class="mbutton" name="btn_cov" value="設定置頂" onclick="javascript:go_push('<?php echo $m_apnm.'_sticky'?>','sticky');"></td>
                <?php } ?>                  
                  <td width="80%">&nbsp;</td>
                </tr>
              </tr>
              </table>
        </td>
      </tr>
  </table>
  <table width="99%" border="0" cellpadding="3" cellspacing="1" class="w12">
  	<form name="reg" action="" method="post">
    <tr class="w12白">
      <td align="center" width="5%" background="../images/bg3.gif"><input type='checkbox' id='chkall' value='Y' onclick="javascript:chk_all('reg',this);" <?php if ($rsm_rows<=1){echo 'disabled';}?> ></td>
      <td align="center" background="../images/bg3.gif" width="7%">No.</td>
      <td align="center" background="../images/bg3.gif" width="50%">標題</td>      
      <td align="center" background="../images/bg3.gif" width="10%">刊登起日</td>
      <td align="center" background="../images/bg3.gif" width="10%">刊登設定</td>      
     	<td width="6%" align="center" background="../images/bg3.gif" class="w12白">修改</td>
     	<td width="6%" align="center" background="../images/bg3.gif" class="w12白">刪除      
     	<input type="hidden" name="hxx_apcode" value="<?php echo $m_apcode ?>">
      <input type="hidden" name="pxx_id">
      <input type="hidden" name="hxx_sts">
     </td>
     <td align="center" background="../images/bg3.gif" width="6%">狀態</td>
    </tr>
    <?php  // bno,title,publish_bdate,publish_sts,publish_edate,display,photo
      $bgcolor='';
      //$ftoday =date('Y-m-d');
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
        
        $xsts  =$rsrow[3];
        $xedate='';
        $strsts='';
        if ($xsts=='o'){      //永久刊登
        	 $strsts ="<font color='blue'>永久刊登</font>";
        }
        else if($xsts=='x'){  //停止刊登
        	 $strsts ="<font color='blue'>停止刊登</font>";
        }
        else if($xsts=='d'){  //刊登迄日
        	 $xedate =$rsrow[4];       	
        	 $nndiff = datediff('d', $ftoday,$xedate,false);
        	 if ($nndiff < 0){
        	 	  $strsts ='<font color="red">(已結束)</font>';
        	 }
        	 else if($nndiff <=3) {
        	 	  $strsts ='<font color="blue">(即將到期)</font>';
        	 }        	 
        	 $strsts =$rsrow[4].'<br/>'.$strsts;
        }
        
        if ($rsrow[5]=='Y'){         	  
         	  $strdispimg ='on.gif';
         }
         else{         	  
         	  $strdispimg ='off.gif';
         }         
         
         $xxphoto ='';
         if ($rsrow[6]<>''){
         	   $xary_pic =explode('.',$rsrow[6]);
             $xxphoto  =$ffiledir.$xary_pic[0].'_s.'.$xary_pic[1];
         }   
         $str_td ='';
        if ($rsrow[7]>=1){
        	 $str_td ="<a href='javascript:goedit(\"".$m_apnm."_add\",".$rsrow[0].");'><img src='../images/sticky_top3.jpg' border=0 width=20 title='置頂'/>".$rsrow[1]."</a>";        	 
        }	
        else{
        	  $str_td="&nbsp;<a href='javascript:goedit(\"".$m_apnm."_add\",".$rsrow[0].");'>".$rsrow[1]."</a>";        	 
        }         
                            
         
        echo "<tr bgcolor='".$bgcolor."'>".
             "<td align='center' id='Td1_".$nncnt."'><input type='checkbox' id='chkDel".$nncnt."' name='chkDel".$nncnt."' value='".$rsrow[0]."' onClick='javascript:chkthis(this);'></td>".
             "<td align='center'>".
             "<table width='100%' border=0 cellpadding=0 cellspacing=0 class='w12'>".
             "<tr>".
             "<td rowspan=2 align='center'><div id='divno'>".$nncnt."</div></td>".
             "<td align='center'><img src='../images/arrow-upper.png' width=10 height=10 style='cursor:pointer;' onclick='javascript:gosort(\"".$nncnt."\",\"u\");'></td>".
             "</tr>".
             "<tr>".
             "<td align='center'><img src='../images/arrow-downer.png' width=10 height=10 style='cursor:pointer;' onclick='javascript:gosort(\"".$nncnt."\",\"d\");'>".
             "<input type='hidden' id='tfx_sno".$nncnt."' name='tfx_sno".$nncnt."' value='".$rsrow[0]."'>".             
             "</td>".
             "</tr>".
             "</table>".
             "</td>".                
             "<td align='left'  id='Td2_".$nncnt."'><a href='javascript:goedit(\"".$m_apnm."_add\",".$rsrow[0].");'>&nbsp;".$str_td."</a></td>".             
             "<td align='center'  id='Td3_".$nncnt."'>".$rsrow[2]."</td>".             
             "<td align='center'  id='Td4_".$nncnt."'>".$strsts."</td>".
             "<td align='center'  id='Td5_".$nncnt."'><img src='../images/bt-revise.gif' border=0 style='cursor:pointer;' onclick='javascript:goedit(\"".$m_apnm."_add\",".$rsrow[0].");'></td>".
             "<td align='center'  id='Td6_".$nncnt."'><img src='../images/bt-delete.gif' border=0 style='cursor:pointer;' onclick='javascript:godel(\"reg\",\"".$nncnt."\",\"".$m_apnm."_del\");'></td>".
             "<td align='center'  id='Td7_".$nncnt."'><img src='../images/".$strdispimg."'/> </td>".
             "</tr>";
     }
    ?> 
   </form>   
  </table>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  	<form name="reg1" action="" method="post">
    <tr>
    	<td>
      <input type="hidden" name="hxx_nowpage">
       <input type="hidden" name="hxx_nowcnt" value="<?php echo $nncnt ?>">
       <input type="hidden" id="hxx_td" value="7">
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
</center>
</body>
</html>
<script src="../sysjs/common_list_ctrl.js" type="text/javascript"></script>
<script language=javascript>
	parent.frames[0].document.getElementById("divpath").innerHTML="<?php echo $m_title1.' &gt; '.$m_title2?>";
</script> 	