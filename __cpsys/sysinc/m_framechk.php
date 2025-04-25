<?php
session_start();
$fpwd =	false; 
if (isset($_SESSION['sys_pass'])){     //empty() 也可以
   if ($_SESSION['sys_pass']){
	   $fpwd = true; 
	   $fsys_user =$_SESSION['sys_user'];
   }         
} 
if ($fpwd){	 
}
else{ ?>	
       parent.location.href="./";
  <?php
}
?>
