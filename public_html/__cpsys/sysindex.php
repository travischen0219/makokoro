<?php
session_start();
if (isset($_SESSION['sys_pass'])){     //empty() 也可以
   if ($_SESSION['sys_pass']){
	   $fpwd = true; 
   }  
   else{
   	  //echo '<script>parent.location.replace("./");</script>';
   }    
} 
?>
<html>
<head>
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
<title>::<?php echo $_SESSION['sys_title']?> 網站管理系統::</title>  
<script type="text/javascript" src="sysinc/m_framechk.php"></script> 
</head>
<frameset rows="96,*" border=0>
	<frame name="top" id="top" scrolling="no" noresize target="contents" frameborder="no" src="top.php">
	<frameset cols="174,*" border=0>
		<frame id="leftmenu" name="leftmenu" target="main" frameborder="no" src="tleft.php" scrolling="no" noresize marginwidth="1">
		<frame id="main" name="main">
	</frameset>
	<noframes>
	<body>
	<p>此網頁使用框架，但是您的瀏覽器不支援框架。</p>
	</body>	</noframes>
</frameset>
</html>
