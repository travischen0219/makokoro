<?php
//---
include $ff_db_dir;

$ffld='`bno`,publish_bdate,photo';
if ($ff_lang=='tw'){
	 $ffld .=',title';
}
elseif($ff_lang=='en'){
	 $ffld .=',title_en as title';
}

$sqlx ='select '.$ffld.
       ' from `news` '.   
       'where TO_DAYS(NOW())-TO_DAYS(publish_bdate) >=0 '.
              'and (publish_sts=\'o\' or (publish_sts=\'d\' and (TO_DAYS(NOW())-TO_DAYS(publish_edate)<=0) ) )  '.
              'and display=\'Y\' '.
       'order by sticky IS NULL,sno '.
       'limit 0,5 ';
       
$rsnw  =$s_mysqli->query($sqlx);  
$str_li ='';
while($rsnw_c =mysqli_fetch_assoc($rsnw)){ 
	  $xxdate =date("Y/m/d",strtotime($rsnw_c['publish_bdate'])); 	  
    $str_li .='<li><span class="date">'.$xxdate.'</span><a href="./news_c.php?n='.$rsnw_c['bno'].'">'.$rsnw_c['title'].'</a><span class="more"><a href="./news_c.php?n='.$rsnw_c['bno'].'">more</a></span></li>';
}
?>