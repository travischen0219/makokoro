<?php
include $ff_db_dir;

$ff_id ='';
if(isset($_GET['n'])){	  	  
	 $ff_id =(is_numeric($_GET['n']))?$_GET['n']:'';
}
if ($ff_id==''){
	 echo '<script>location.replace(\'./\')</script>';
	 exit();
}

$ffld='`bno`,publish_bdate,photo';
if ($ff_lang=='tw'){
	 $ffld .=',title,newsnote';
}
elseif($ff_lang=='en'){
	 $ffld .=',title_en as title,newsnote_en as newsnote';
}

$sqlx ='select '.$ffld.
       ' from `news` '.   
       'where TO_DAYS(NOW())-TO_DAYS(publish_bdate) >=0 '.
              'and (publish_sts=\'o\' or (publish_sts=\'d\' and (TO_DAYS(NOW())-TO_DAYS(publish_edate)<=0) ) )  '.
              'and display=\'Y\' and bno='.$ff_id;
$rsnw     =$s_mysqli->query($sqlx);
//$num_rows =mysql_num_rows($rs);  //筆數
if (! $rsnw){
	 echo "<script>location.replace('./?news')</script>";
}
$rsnw_c =mysqli_fetch_assoc($rsnw);
extract($rsnw_c, EXTR_PREFIX_ALL,'f');
$f_publish_bdate =date("Y/m/d",strtotime($f_publish_bdate));
$f_newsnote =htmlspecialchars_decode($f_newsnote);
?>