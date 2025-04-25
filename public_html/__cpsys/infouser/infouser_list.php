<?php 
if (isset($_GET['m'])){
   $m_apcode =$_GET['m'];
}   
else{
	  header("location:./");
	  exit();
}

include '../sysinc/m_serverchk.php';   //$m_apnm 

$sqlx     ='select userid from infouser ';
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
//$sqlx = 'select userid,loginid,username from infouser where userid<>1 limit '.$beginrec.','.$pagesize;

$sqlx ="select infouser.userid,infouser.loginid,infouser.username,apgrouplookup.groupcname ".
       "from infouser ".
       "left join apgrouplookup on infouser.groupid = apgrouplookup.apgroupid ".
       "where loginid <>'s_pighead' ".
       "order by infouser.groupid,infouser.userid ";

//echo $sqlx;
//exit();
$rsm      = $s_mysqli->query($sqlx);
$rsm_rows = mysqli_num_rows($rsm);  //筆數
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>::::</title>
<link rel="stylesheet" type="text/css" href="../sysinc/css.css" />
</head>
<center>     
   <table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">  
   	<tr>
        <td align="left"><div id="main-id"><?php echo $m_title1.'--'.$m_title2?></div></td>
      </tr>         
      <tr>
        <td height="40" align="left">
        	<table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td><table border="0" cellspacing="1" cellpadding="0">
                <tr>
                  <td width="63"><img src="../images/n01.png" width="63" height="25" border="0" onclick="javascript:location.replace('<?php echo $m_apnm ?>_add.php?m=<?php echo $m_apcode ?>');" style="cursor:pointer;" /></td>
                  <td width="63"><img src="../images/n03.png" width="63" height="25" border="0" onclick="javascript:chk_del('<?php echo $m_apnm ?>_del');" style="cursor:pointer;" /></td>
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
      <td align="center" background="../images/bg3.gif" width="6%">No.</td>
      <td align="center" background="../images/bg3.gif" width="25%">登入帳號</td>
      <td align="center" background="../images/bg3.gif" width="24%">名稱</td>
      <td align="center" background="../images/bg3.gif" width="20%">群組</td>
     	<td width="10%" align="center" background="../images/bg3.gif" class="w12白">修改</td>
      <td width="10%" align="center" background="../images/bg3.gif" class="w12白">刪除
     	<input type="hidden" name="hxx_apcode" value="<?php echo $m_apcode ?>">
       <input type="hidden" name="pxx_id">
     </td>
    </tr>
    <?php  // userid,loginid,username,groupcname 
      $bgcolor='';
      $nncnt =$nowcnt;     
      $xrec =0;
      for($i=0;$i<$rsm_rows;$i++){
         //$rsrow =mysql_fetch_row($rsm);
         $rsrow = $rsm->fetch_row();      
         if ( $i%2==0 ){
         	  $bgcolor='#FFFFFF';
         }
         else{
         	  $bgcolor='#EDEEEF';
         }
         
        $nncnt =$i+1;
        //$nowno =strrev(substr(strrev('00'.$nncnt),0,2));  //右邊2個字元 
         
        echo "<tr bgcolor='".$bgcolor."'>".
             "<td align='center'><input type='checkbox' id='chkDel".$i."' name='chkDel".$i."' value='".$rsrow[0]."' onClick='javascript:chkthis(this);'></td>".
             "<td align='center'>".$nncnt.".</td>".
             "<td align='left'>&nbsp;<a href='javascript:goedit(\"".$m_apnm."_add\",".$rsrow[0].");'>".$rsrow[1]."</a></td>".
             "<td align='left'>&nbsp;<a href='javascript:goedit(\"".$m_apnm."_add\",".$rsrow[0].");'>".$rsrow[2]."</a></td>".
             "<td align='left'>&nbsp;<a href='javascript:goedit(\"".$m_apnm."_add\",".$rsrow[0].");'>".$rsrow[3]."</a></td>".
             "<td align='center'><img src='../images/bt-revise.gif' border=0 style='cursor:pointer;' onclick='javascript:goedit(\"".$m_apnm."_add\",".$rsrow[0].");'></td>".
             "<td align='center'><img src='../images/bt-delete.gif' border=0 style='cursor:pointer;' onclick='javascript:godel(\"reg\",\"".$i."\",\"".$m_apnm."_del\");'></td>".
             "</tr>";
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