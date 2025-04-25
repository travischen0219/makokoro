<?php header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);

if (isset($_GET['m'])){
   $m_apcode =$_GET['m'];
}   
else{
	  header("location:./");
	  exit();
}

include '../sysinc/m_serverchk.php';   //$m_apnm 

$sqlx    ='select bid 
           from `vi_ci` 
           where 1=1';

//echo $sqlx;
//exit();

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

$sqlx = 'select `bid`,`title`,`photo`,`display`,stitle '.
        'from `vi_ci` '.                
        'order by sno '.
        'limit '.$beginrec.','.$pagesize;

//echo $sqlx;
//exit();
$rsm      = $s_mysqli->query($sqlx);
$rsm_rows = mysqli_num_rows($rsm);  //筆數
include '../sysinc/m_func.php'; ?>
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

.divtable{
  border-collapse: collapse;
  background-color:#4F6B4E;
  color:#FFFFFF; 
  width:300px;
  font-family: "微軟正黑體" ,arial, sans-serif;    
}
-->
</style>
<link rel="stylesheet" type="text/css" href="../sysinc/css.css" />
</head>
<center>  
   <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">   	     
      <tr>
        <td align="left"><div id="main-id"><?php echo $m_title1.'-'.$m_title2?></div></td>
      </tr>        
      <tr>
        <td height="40"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td align="left"><table border="0" cellspacing="1" cellpadding="0">
                <tr>
                  <td nowrap><img src="../images/n01.png" width="63" height="25" border="0" onclick="javascript:location.replace('<?php echo $m_apnm ?>_add.php?m=<?php echo $m_apcode ?>');" style="cursor:pointer;" /></td>
                  <td nowrap><img src="../images/n03.png" width="63" height="25" border="0" onclick="javascript:chk_del('<?php echo $m_apnm ?>_del');" style="cursor:pointer;" /></td>
                  <td nowrap><img src="../images/n04.png" width="63" height="25" border="0" onclick="javascript:gosts('<?php echo $m_apnm ?>_display','Y');" style="cursor:pointer;"></td>
                  <td nowrap><img src="../images/n05.png" width="63" height="25" border="0" onclick="javascript:gosts('<?php echo $m_apnm ?>_display','N');" style="cursor:pointer;"></td>
                  <td nowrap align="right"><img src="../images/ndwn.png"  border="0" onClick="javascript:saveSort('<?php echo $m_apnm ?>');" style="cursor:pointer;"></td>
                 <td width="90%">&nbsp;</td>  
                </tr>            
              </table>
             </td>              
            </tr>
          </table>
        </td>
      </tr>
  </table>
  <table width="98%" border="0" cellpadding="3" cellspacing="1" class="w12">  
  	<form name="reg" action="" method="post">  	
    <tr class="w12白">
      <td align="center" width="5%" background="../images/bg3.gif"><input type='checkbox' id='chkall' value='Y' onclick="javascript:chk_all('reg',this);" <?php if ($rsm_rows<=1){echo 'disabled';}?> ></td>
      <td align="center" background="../images/bg3.gif" width="5%">No.</td>
      <td align="center" background="../images/bg3.gif" width="65%">圖 片</td>      
     	<td align="center" background="../images/bg3.gif" width="5%" class="w12白">修改</td>
     	<td align="center" background="../images/bg3.gif" width="5%" class="w12白">刪除</td>
      <td align="center" background="../images/bg3.gif" width="5%">狀態
     	 <input type="hidden" name="hxx_apcode" value="<?php echo $m_apcode ?>">
       <input type="hidden" name="pxx_id">
       <input type="hidden" name="hxx_sts">        
      </td> 
    </tr>
    <?php  // `bid`,`title`,`photo`,`display`,stitle
      $bgcolor='';      
      $xcnt =$nowcnt;
      $xrec =0;
      for($i=0;$i<$rsm_rows;$i++){
         $rsrow =mysqli_fetch_row($rsm);
         $xcnt +=1;
         $xrec +=1;
         if ( $i%2==0 ){
         	 $bgcolor='#FFFFFF';
         }
         else{
         	 $bgcolor='#EDEEEF';
         }               
         
         $nncnt =$i+1; 
         //
         $xxtit ='';
         if ($rsrow[1]<>''){
         	  $xxtit =$rsrow[1];
         }
         if ($rsrow[4]<>''){
         	   if ($xxtit<>''){
         	   	  $xxtit .='<br/>&nbsp;&nbsp;'.$rsrow[4];
         	   }
         	   else{
         	   	   $xxtit =$rsrow[4];
         	  }         	  
         }         
        //--------                  
         $xxpic =$rsrow[2];
         if ($xxpic<>''){         	            	   
             $arypic =explode(".",$xxpic);
             $xxpic  =$ffiledir.$arypic[0].'_b.'.$arypic[1];             
         }  
         else{
         	   $xprv_pic ='../images/noimg.jpg';  
         }         
         if ($rsrow[3]=='Y'){
         	  $strdispimg ='on.gif';
         }
         else{         	  
         	  $strdispimg ='off.gif';
         }         
        //                              
         
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
             "<td align='left' id='Td2_".$nncnt."'><table border=0 cellspacing=0 cellpadding=0>".
             "<tr>".
             "<td width=60 align='center'><a href='javascript:goedit(\"".$m_apnm."_add\",".$rsrow[0].");'><img src='".$xxpic."' height=160 border=0></a></td>".
             "<td>&nbsp;<a href='javascript:goedit(\"".$m_apnm."_add\",".$rsrow[0].");'>".$xxtit."</a></td>".
             "</tr>".
             "</table></td>".                        
             "<td align='center' id='Td3_".$nncnt."'><img src='../images/bt-revise.gif' border=0 style='cursor:pointer;' onclick='javascript:goedit(\"".$m_apnm."_add\",".$rsrow[0].");'></td>".
             "<td align='center' id='Td4_".$nncnt."'><img src='../images/bt-delete.gif' border=0 style='cursor:pointer;' onclick='javascript:godel(\"reg\",\"".$nncnt."\",\"".$m_apnm."_del\");'></td>".
             "<td align='center' id='Td5_".$nncnt."'><img src='../images/".$strdispimg."'/> </td>".
             "</tr>";
     } ?>  
    </form>     
  </table>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  	<form name="reg1" action="" method="post">
    <tr>
      <input type="hidden" name="hxx_nowpage">
      <input type="hidden" name="hxx_nowcnt" value="<?php echo $xcnt ?>">      
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
