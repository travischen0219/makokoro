<?php 
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Content-Type:text/html; charset=utf-8");

if (isset($_GET['m'])){
   $m_apcode =$_GET['m'];
}   
else{
	  header("location:./");
	  exit();
}

include '../sysinc/m_serverchk.php';   //$m_apnm 

$sqlx = 'select apgroupid from apgrouplookup  ';
$rs       =$s_mysqli->query($sqlx);
$num_rows =mysqli_num_rows($rs);  //筆數

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

$sqlx ='select apgrouplookup.apgroupid,apgrouplookup.groupename,apgrouplookup.groupcname,apgrouplookup.groupremark,apg.apcname,apg.apcatid,apg.apcatcname  
       from apgrouplookup 
        left join (select a1.apgroupid,a1.apcode,a2.apcname,a3.apcatid,a3.apcatcname from apgroup as a1,ap as a2,apcat as a3  
                   where a1.apcode=a2.apcode and a2.apcatid=a3.apcatid) as apg on apgrouplookup.apgroupid=apg.apgroupid 
       order by apgrouplookup.apgroupid,apg.apcode';
$rsm      =$s_mysqli->query($sqlx);
$rsm_rows =mysqli_num_rows($rsm);  //筆數

//echo $sqlx;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>:::</title>
<link rel="stylesheet" type="text/css" href="../sysinc/css.css" />
</head>
<center>     
   <table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
   	  <tr>
        <td align="left"><div id="main-id"><?php echo $m_title1.'--'.$m_title2?></div></td>
      </tr>       
      <tr>
        <td height="40" align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td><table border="0" cellspacing="1" cellpadding="0">
                <tr>
                  <td nowrap><img src="../images/n01.png" width="63" height="25" border="0" onclick="javascript:location.replace('<?php echo $m_apnm ?>_add.php?m=<?php echo $m_apcode ?>');" style="cursor:pointer;" /></td>
                  <td nowrap><img src="../images/n03.png" width="63" height="25" border="0" onclick="javascript:chk_del('<?php echo $m_apnm ?>_del');" style="cursor:pointer;" /></td>
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
  	<form name="reg" action="" method="post">
    <tr class="w12白">
      <td align="center" width="5%" background="../images/bg3.gif"><input type='checkbox' id='chkall' value='Y' onclick="javascript:chk_all('reg',this);" <?php if ($rsm_rows<=1){echo 'disabled';}?> ></td>
      <td align="center" background="../images/bg3.gif" width="5%">No.</td>
      <td align="center" background="../images/bg3.gif" width="20%">英文名稱</td>
      <td align="center" background="../images/bg3.gif" width="20%">中文名稱</td>
      <td align="center" background="../images/bg3.gif" width="20%">權限</td>
      <td align="center" background="../images/bg3.gif" width="20%">備註</td>
     	<td width="5%" align="center" background="../images/bg3.gif" class="w12白">修改</td>
      <td width="5%" align="center" background="../images/bg3.gif" class="w12白">刪除
     	<input type="hidden" name="hxx_apcode" value="<?php echo $m_apcode ?>">
       <input type="hidden" name="pxx_id">
     </td>
    </tr>
   <?php  //apgroupid ,groupename ,groupcname, groupremark,  apcname,  apcatid,  apcatcname  
       $xgid="@@@" ;
       $ix=1;
       $totrec=0;
       $ckx=0;
       $bgcolor='';
       $nncnt =$nowcnt;     
       $xrec =0;
       
      for($i=0;$i<$rsm_rows;$i++){
      	 if ($i==0){
             $rsm_c =mysqli_fetch_row($rsm);
         }    
          if ($xgid<>$rsm_c[0]){          	   
              $xgid   =$rsm_c[0];
              $xename =$rsm_c[1];
              $xcname =$rsm_c[2];
              $xremark=$rsm_c[3];
              
              if ($i%2==0 ){
         	       $bgcolor='#FFFFFF';
              }
              else{
         	       $bgcolor='#EDEEEF';
              }
              
              $nncnt =$i+1;
              //$nowno =strrev(substr(strrev('00'.$nncnt),0,2));  //右邊2個字元
              $xxoption ='';
              //---
             echo "<tr bgcolor='".$bgcolor."'>\n".
             "<td align='center'><input type='checkbox' id='chkDel".$i."' name='chkDel".$i."' value='".$xgid."' onClick='javascript:chkthis(this);'></td>\n".
             "<td align='center'>".$nncnt.".</td>\n".
             "<td align='left'>&nbsp;<a href='javascript:goedit(\"".$m_apnm."_add\",".$xgid.");'>".$xename."</a></td>\n".
             "<td align='left'>&nbsp;<a href='javascript:goedit(\"".$m_apnm."_add\",".$xgid.");'>".$xcname."</a></td>\n".
             "<td align='left'>&nbsp;<select name='ofx_ap' size=1>";              
             $xcatid="@@@";   
                   
             while ($rsm_c[0]==$xgid){
             	    //echo $rsm_c[0].','.$xgid.'<br/>';
             	    //var_dump($rsm_c[0]==$xgid).'<br/>';
             	    
             	    if ($xcatid<>$rsm_c[5]){ 
                      $xcatid =$rsm_c[5];
                      $xxoption .= "<option value='' style='color:blue'>==".$rsm_c[6]."==</option>\n";
                  }  
                  $xxoption .= "<option value=''>&nbsp;".$rsm_c[4]."</option>\n";
             	    //echo 'opt->'.$xxoption;
             	    $rsm_c =mysqli_fetch_row($rsm);
             	    if (!$rsm_c){
             	    	 // exit();
             	    	  break;
             	    }             	  
             }
             echo $xxoption."</select></td>\n".
              "<td align='left'>&nbsp;".$xremark."</td>\n".
             "<td align='center'><img src='../images/bt-revise.gif' border=0 style='cursor:pointer;' onclick='javascript:goedit(\"".$m_apnm."_add\",".$xgid.");'></td>\n".
             "<td align='center'><img src='../images/bt-delete.gif' border=0 style='cursor:pointer;' onclick='javascript:godel(\"reg\",\"".$i."\",\"".$m_apnm."_del\");'></td>\n".
             "</tr>";
          }	
          
          if (!$rsm_c){
           	  break;
          }
     }
    ?> 
   </form>   
  </table>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  	<form name="reg1" action="" method="post">
    <tr>
      <input type="hidden" name="hxx_nowpage"></td>
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
</center>
</body>
</html>
<script src="../sysjs/common_list_ctrl.js" type="text/javascript"></script>
<script language=javascript>
	//parent.frames[0].document.getElementById("divpath").innerHTML="<?php echo $m_title1.' &gt; '.$m_title2?>" ;	  	
</script> 	