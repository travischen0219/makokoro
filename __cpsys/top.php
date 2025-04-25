<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
session_start();
if (isset($_SESSION['sys_pass'])){     //empty() 也可以
   if ($_SESSION['sys_pass']){
	   $fpwd = true; 
   }  
   else{
   	  echo '<script>parent.location.replace("./");</script>';
   }    
} 

$ffuser =$_SESSION['sys_user'];
$fftit  =$_SESSION['sys_title'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="sysinc/m_framechk.php"></script> 
<title><?php echo $fftit?></title>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style>
<link href="sysinc/css.css" rel="stylesheet" type="text/css" />
<base target="contents">
</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="10" bgcolor="#FF6600"></td>
  </tr>
  <tr>
    <td><div id="heade">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><?php echo $fftit?></td>
          <td align="right"><div id="heade-td"><img src="images/home.png" width="14" height="11" align="top" /><a href="../" target=_blank>前台網站</a><img src="images/dotline.gif" width="23" height="11" /><img src="images/icon1.gif" width="20" height="12" align="top" /><a href="logout.php" target="_self">登出系統</a></div></td>
        </tr>
      </table>
    </div></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="174" background="images/bg3.gif" height="28"><div id="loginuser"><img src="images/user.png" width="22" height="28" align="absmiddle" />使用者：<?php echo $ffuser ?></div></td>
    <td background="images/bg4.gif"><div id="divpath" name="divpath"> 登入頁</div></td>
  </tr>
</table>
</body>
</html>
