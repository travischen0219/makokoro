<?php
$dbserver='localhost';

/*虛擬主機 */
/*
$dbname ='odocomtw_makokoro';
$dbuser ='odocomtw_sa';  
$dbpwd  ='sa@66.88';
*/

$dbname ='makokoro_odo';
$dbuser ='makokoro_sa';  
$dbpwd  ='sa@66.88';


$s_link = false;
$s_mysqli = mysqli_connect($dbserver,$dbuser,$dbpwd,$dbname) or die('DB SERVER error!: ' . mysql_error());
mysqli_set_charset($s_mysqli, "utf8");
$s_mysqli->query("SET NAMES 'utf8'");
putenv("TZ=Asia/Taipei");  //timeZone for php4x
?>