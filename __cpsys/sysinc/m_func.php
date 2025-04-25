<?php
function begin() 
{
  @mysqli_query("BEGIN");
}

function commit()
{
  @mysqli_query("COMMIT");
}

function rollback()
{
  @mysqli_query("ROLLBACK");
}


function get_fld_typ($vv){
	$nntag='';
	 switch ($vv){
	 	 case 'v':
	 	 case 't':
	 	    $nntag='tfx';
	 	    break;
	 	 case 'n':   
	 	   $nntag='nfx';
	 	    break;	 
	 	 case 'e':   
	 	   //$nntag='txx';  //editor
	 	   $nntag='tfx';
	 	    break;	 
	 	 case 's':   
	 	   $nntag='sfx';  //editor
	 	    break;	 
	 	 case 'l':   
	 	   $nntag='tfx';  //link 
	 	    break;	          	   
	 }
	 return $nntag;
}



function datediff($interval, $datefrom, $dateto, $using_timestamps = false) {
    /*
    $interval can be:
    yyyy - Number of full years
    q - Number of full quarters
    m - Number of full months
    y - Difference between day numbers
        (eg 1st Jan 2004 is "1", the first day. 2nd Feb 2003 is "33". The datediff is "-32".)
    d - Number of full days
    w - Number of full weekdays
    ww - Number of full weeks
    h - Number of full hours
    n - Number of full minutes
    s - Number of full seconds (default)
    */
    
    if (!$using_timestamps) {
        $datefrom = strtotime($datefrom, 0);
        $dateto = strtotime($dateto, 0);
    }
    $difference = $dateto - $datefrom; // Difference in seconds
     
    switch($interval) {
     
    case 'yyyy': // Number of full years
 
        $years_difference = floor($difference / 31536000);
        if (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom), date("j", $datefrom), date("Y", $datefrom)+$years_difference) > $dateto) {
            $years_difference--;
        }
        if (mktime(date("H", $dateto), date("i", $dateto), date("s", $dateto), date("n", $dateto), date("j", $dateto), date("Y", $dateto)-($years_difference+1)) > $datefrom) {
            $years_difference++;
        }
        $datediff = $years_difference;
        break;
 
    case "q": // Number of full quarters
 
        $quarters_difference = floor($difference / 8035200);
        while (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom)+($quarters_difference*3), date("j", $dateto), date("Y", $datefrom)) < $dateto) {
            $months_difference++;
        }
        $quarters_difference--;
        $datediff = $quarters_difference;
        break;
 
    case "m": // Number of full months
 
        $months_difference = floor($difference / 2678400);
        while (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom)+($months_difference), date("j", $dateto), date("Y", $datefrom)) < $dateto) {
            $months_difference++;
        }
        $months_difference--;
        $datediff = $months_difference;
        break;
 
    case 'y': // Difference between day numbers
 
        $datediff = date("z", $dateto) - date("z", $datefrom);
        break;
 
    case "d": // Number of full days
 
        $datediff = floor($difference / 86400);
        break;
 
    case "w": // Number of full weekdays
 
        $days_difference = floor($difference / 86400);
        $weeks_difference = floor($days_difference / 7); // Complete weeks
        $first_day = date("w", $datefrom);
        $days_remainder = floor($days_difference % 7);
        $odd_days = $first_day + $days_remainder; // Do we have a Saturday or Sunday in the remainder?
        if ($odd_days > 7) { // Sunday
            $days_remainder--;
        }
        if ($odd_days > 6) { // Saturday
            $days_remainder--;
        }
        $datediff = ($weeks_difference * 5) + $days_remainder;
        break;
 
    case "ww": // Number of full weeks
 
        $datediff = floor($difference / 604800);
        break;
 
    case "h": // Number of full hours
 
        $datediff = floor($difference / 3600);
        break;
 
    case "n": // Number of full minutes
 
        $datediff = floor($difference / 60);
        break;
 
    default: // Number of full seconds (default)
 
        $datediff = $difference;
        break;
    }    
 
    return $datediff; 
}



function getYTid($ytURL) {
 
		$ytvIDlen = 11;	// This is the length of YouTube's video IDs
 
		// The ID string starts after "v=", which is usually right after 
		// "youtube.com/watch?" in the URL
		$idStarts = strpos($ytURL, "?v=");
 
		// In case the "v=" is NOT right after the "?" (not likely, but I like to keep my 
		// bases covered), it will be after an "&":
		
		if($idStarts === FALSE){
			$idStarts = strpos($ytURL, "&v=");
		    // If still FALSE, URL doesn't have a vid ID
		    if($idStarts === FALSE){
			    //die("YouTube video ID not found. Please double-check your URL.");
			    return false; 
			 }
       } 			    
 
		// Offset the start location to match the beginning of the ID string
		$idStarts +=3; 
		// Get the ID string and return it
		$ytvID = substr($ytURL, $idStarts, $ytvIDlen); 
		return $ytvID; 
}



function getcurl($xurl){
	$ch = curl_init();
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_URL,$xurl);
  curl_setopt($ch, CURLOPT_USERAGENT, "Google Bot");
  $ffp = curl_exec($ch);
  curl_close($ch);
  return $ffp;
}


//--get vimeo id
function get_vimeo_id($url){
	if ($url==''){
		  return '';
  }
  else{
	    $jsn_vimeo_url ='http://vimeo.com/api/oembed.json?url='; 		
	    $xjson =getcurl($jsn_vimeo_url.$url);
	    if (get_magic_quotes_gpc()) {
 	       $xjson =stripslashes($xjson);
      }  
      $arr_cart =json_decode($xjson,true);   //tru ->stdClass to array
      return $arr_cart['video_id'];	
  }
}


function SpHtml2Text($str)
{
 $str = preg_replace("/<sty(.*)\/style>|<scr(.*)\/script>|<!--(.*)-->/isU","",$str);
 $alltext = "";
 $start = 1;
 for($i=0;$i<strlen($str);$i++)
 {
  if($start==0 && $str[$i]==">")
  {
   $start = 1;
  }
  else if($start==1)
  {
   if($str[$i]=="<")
   {
    $start = 0;
    $alltext .= " ";
   }
   else if(ord($str[$i])>31)
   {
    $alltext .= $str[$i];
   }
  }
 }
 $alltext = str_replace("　"," ",$alltext);
 $alltext = preg_replace("/&([^;&]*)(;|&)/","",$alltext);
 $alltext = preg_replace("/[ ]+/s"," ",$alltext);
 return $alltext;
}


function CuttingStr($str, $strlen) {   //utf-8 取字串
     //把'&nbsp;'先轉成空白
      $str = str_replace('&nbsp;', ' ', $str);
 
      $output_str_len = 0; //累計要輸出的擷取字串長度
      $output_str = ''; //要輸出的擷取字串
 
      //逐一讀出原始字串每一個字元
  for($i=0; $i<strlen($str); $i++)  {
            //擷取字數已達到要擷取的字串長度，跳出回圈
            if($output_str_len >= $strlen){
                  break;
            }
  
            //取得目前字元的ASCII碼
            $str_bit = ord(substr($str, $i, 1));
  
            if($str_bit  <  128)  {
                  //ASCII碼小於 128 為英文或數字字符
                  $output_str_len += 1; //累計要輸出的擷取字串長度，英文字母算一個字數
                  $output_str .= substr($str, $i, 1); //要輸出的擷取字串
   
            }elseif($str_bit  >  191  &&  $str_bit  <  224)  {
                  //第一字節為落於192~223的utf8的中文字(表示該中文為由2個字節所組成utf8中文字)
                  $output_str_len += 2; //累計要輸出的擷取字串長度，中文字需算二個字數
                  $output_str .= substr($str, $i, 2); //要輸出的擷取字串
                  $i++;
   
            }elseif($str_bit  >  223  &&  $str_bit  <  240)  {
                  //第一字節為落於223~239的utf8的中文字(表示該中文為由3個字節所組成的utf8中文字)
                  $output_str_len += 2; //累計要輸出的擷取字串長度，中文字需算二個字數
                  $output_str .= substr($str, $i, 3); //要輸出的擷取字串
                  $i+=2;
   
            }elseif($str_bit  >  239  &&  $str_bit  <  248)  {
                  //第一字節為落於240~247的utf8的中文字(表示該中文為由4個字節所組成的utf8中文字)
                  $output_str_len += 2; //累計要輸出的擷取字串長度，中文字需算二個字數
                  $output_str .= substr($str, $i, 4); //要輸出的擷取字串
                  $i+=3;
            }
    }
 
      //要輸出的擷取字串為空白時，輸出原始字串
      return ($output_str == '') ? $str : $output_str; 
} 


//--隨機密碼
function getrndchar($len=6,$format='all') { 
 switch($format) { 
 case 'all':
    $chars='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-@#~'; break;
 case 'char':
    $chars='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz-@#~'; break;
 case 'num':
    $chars='0123456789'; 
    break;
 case 'lnum':
    $chars='abcdefghijklmnopqrstuvwxyz0123456789';
    break;
 default :
    $chars='abcdefghijklmnopqrstuvwxyz0123456789-@#~'; 
    break;
 }
 
 mt_srand((double)microtime()*1000000*getmypid()); 
 
 $password="";
 while(strlen($password)<$len){
   $password.=substr($chars,(mt_rand()%strlen($chars)),1);
 }   
    
 return $password;
}



function getip(){
   if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
       $ip = getenv("HTTP_CLIENT_IP");
   else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
       $ip = getenv("HTTP_X_FORWARDED_FOR");
   else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
       $ip = getenv("REMOTE_ADDR");
   else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
       $ip = $_SERVER['REMOTE_ADDR'];
   else
       $ip = "unknown";
   return($ip);
}


function get_custip(){
   if (!empty($_SERVER['HTTP_CLIENT_IP'])){    //check ip from share internet
      $ip=$_SERVER['HTTP_CLIENT_IP'];
   }
   elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){   //to check ip is pass from proxy
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
   }else{
      $ip=$_SERVER['REMOTE_ADDR'];
   }
   
  return $ip; 
}

//-------------------上傳圖/裁圖/刪圖
include 'imgresize.php';

function f_upfile($kk,$op1,$nym,$nnd,$nndr,$nsz,$rsz){ //欄位名,舊圖,代名,auto_id, 路徑,指定各種尺寸,是否壓縮	  
	  $destfolder =$nndr;
	  //exit();	  
	  if($_FILES[$kk]['error']== 0){     //上傳至暫存目錄無誤
     
      if(is_uploaded_file($_FILES[$kk]['tmp_name'])){   //再次確認檔案是否真正被上傳與存在於伺服器上 
 
      	 if (is_dir($destfolder) && is_writeable($destfolder)){   
      	 	   if ($op1<>''){   //刪除舊圖
               if (file_exists ($destfolder.$op1)){
               	  if(! unlink($destfolder.$op1)){
                    	 echo '刪除'.$destfolder.$op1.'時,發生錯誤';
                     	 exit();
                   }
                   
                  $arypic  =explode(".",$op1);
                  
                  $strkk  ='b,s,r,p,m,t';
                  $arr_kk =explode(',',$strkk);
                  $xkk_cc =count($arr_kk);
                  for($jj=0;$jj<$xkk_cc;$jj++){
                  	  $xxphoto =$arypic[0].'_'.$arr_kk[$jj].'.'.$arypic[1];
                  	  if (file_exists ($destfolder.$xxphoto)){
                         if(! unlink($destfolder.$xxphoto)){
          	  	     	       echo '刪除'.$destfolder.$xxphoto.'時,發生錯誤';
          	  	     	       exit();
          	  	         }
          	     	    }
                  }          	     	
               }
            }            
            
            //--判斷類型  // 從多檔上傳Script.php 傳來的type 可能有誤
            $fftype =$_FILES[$kk]['type'];
            if (($fftype == "image/gif") ||($fftype=="image/jpeg") || ($fftype== "image/pjpeg") ){
            	  $fftype ='pic';
            }
            else{
            	  $fftype ='doc';
            }
            //---
            
            $extarry  =explode(".", $_FILES[$kk]['name']);               	 	  
            $file_ext =strtolower($extarry[count($extarry)-1]);
            if ($nnd==''){
            	  $xxmss    =microtime();  //毫秒
                $ary_mss  =explode(' ',$xxmss);
                $xxmsec   =floor($ary_mss[0]*1000);                
                $file_nm  =$nym.date("ymdHis").$xxmsec;                
            }
            else{
                $file_nm  =$nym.$nnd.date("ymdHis");
            }    
            $fphoto   =$file_nm.'.'.$file_ext;	          
         	  
         	  move_uploaded_file($_FILES[$kk]['tmp_name'],$destfolder.$fphoto);        	           	  
         	  
         	  //--需要縮圖時)
         	  if ($rsz=='t'){
         	  	    $ffromimg =$destfolder.$fphoto;         	  	                      
                  $ary_sz   =explode('|',$nsz);
                  for($p=0;$p<count($ary_sz);$p++){
                      $ary_ff =explode(',',$ary_sz[$p]); //b,200,120
                      $xttnm =$ary_ff[0];
                      $xxw   =$ary_ff[1];
                      $xxh   =$ary_ff[2];                      
                      if ( $xttnm=='p' || $xttnm=='r' || $xttnm=='s' ){  //裁切縮圖,保留原圖
                          $fftoimg =$destfolder.$file_nm.'_'.$xttnm.'.'.$file_ext;  
                          $resizeimage =new resizeimage($fftoimg,$ffromimg,$xxw,$xxh,'1','0');  //'1','0' 要裁,不放大
                      }                     
                      else{  //b:大圖->產生新等比縮圖;  xxx_b.jpg 
                      	  if ($xttnm=='b'){
                      	  	  $fftoimg =$destfolder.$file_nm.'_'.$xttnm.'.'.$file_ext;                        	  	  
                      	  	   //resize_image($ffromimg,$fftoimg,$xxw,$xxh) ; 
                      	  	  $resizeimage =ImageResize($ffromimg,$fftoimg,$xxw,$xxh); 
                      	  	  //$resizeimage =new resizeimage($fftoimg,$ffromimg,$xxw,$xxh,'0','0');                      	  	  
                      	  }
                      	  else if($xttnm=='o'){
                      	  	  $fftoimg =$destfolder.$file_nm.'.'.$file_ext;
                      	  	  //resize_image($ffromimg,$fftoimg,$xxw,$xxh) ; 
                      	  	  $resizeimage =ImageResize($ffromimg,$fftoimg,$xxw,$xxh);                    	  	  
                      	  	  //$resizeimage =new resizeimage($fftoimg,$ffromimg,$xxw,$xxh,'0','0'); //不裁,不放大                   	  	  
                      	  }	
                      }
                  }
            }
         	  
     	      return $fphoto;
      	 }
      	 else{
      	 	  echo "找不到指定目錄或沒有寫入權限!";
      	 	  exit();
      	 }	
      }
   } 
   else{ 
   	  echo '..upload..temp err';
   	  exit();  	 
   }
}


function del_upfile($nin,$ntb,$ndr){  //nin:all id, ntb(table ,filed,pkey), ndr:path
	 include 'dbConn.php'; 
	 $ary_tb=explode(',',$ntb);
	 $xtbl =$ary_tb[0];  //table
	 $xfld =$ary_tb[1];  //field	 	  
	 $xpk  =$ary_tb[2];  //P_key
	 
	 $xdel_dr =$ndr;
	
   $sqlx     ="select `".$xfld."` from `".$xtbl."` where ".$xpk." in(".$nin.")";  
   $rsd      =$s_mysqli->query($sqlx)or die('sql錯誤!: '.$sqlx.'<br/>' . mysql_error()).'<br/>';
   $rsd_rows =mysqli_num_rows($rsd);  //筆數
   
   //echo 'file:_'.$sqlx;
   //exit();
   
   for($i=0;$i<$rsd_rows;$i++){
      $rsrow    =mysqli_fetch_row($rsd);
      $xxphoto  =$rsrow[0];          
      
      if ($xxphoto<>''){
      	  if (file_exists ($xdel_dr.$xxphoto)){
      	  	  if(! unlink($xdel_dr.$xxphoto)){
      	  	  	 echo '刪除'.$xdel_dr.$xxphoto.'時,發生錯誤';
      	  	  	 exit();
      	  	  }
      	  }      	  
      	  $arypic  =explode(".",$xxphoto); 
      	  
      	  $strkk  ='b,s,r,p,m,t';
          $arr_kk =explode(',',$strkk);
          $xkk_cc =count($arr_kk);
          for($jj=0;$jj<$xkk_cc;$jj++){
          	  $xxphoto =$arypic[0].'_'.$arr_kk[$jj].'.'.$arypic[1];
          	  if (file_exists ($xdel_dr.$xxphoto)){
                 if(! unlink($xdel_dr.$xxphoto)){
             	       echo '刪除'.$xdel_dr.$xxphoto.'時,發生錯誤';
             	       exit();
                 }
              }
          }
      	  
      }     
   }			
}

//--只要縮圖;;例如:多圖上傳完後的處理
function f_rzfile($npp,$nndr,$nsz){ //圖片名稱,路徑,指定各種尺寸
	  $destfolder =$nndr; 	  	  
	  $extarry    =explode(".",$npp);
	  $ffnm       =$extarry[0];
    $file_ext   =$extarry[count($extarry)-1];
    $nnpos      =strpos('jpg,jpeg,png,gif',strtolower($file_ext));
    if ($nnpos===false){
    	  $fftype ='doc';
    }
    else{
    	  $fftype ='pic';
    }
    
    if($fftype =='pic'){    	     	  
    	  $ffromimg =$destfolder.$npp;
    	  $ary_sz   =explode('|',$nsz);
        for($p=0;$p<count($ary_sz);$p++){
            $ary_ff =explode(',',$ary_sz[$p]);
            $xttnm =$ary_ff[0];
            $xxw   =$ary_ff[1];
            $xxh   =$ary_ff[2];
            
            switch ($xttnm){
            	 case 'b':      // 等比縮圖 xxxx_b.jpg
            	     //$fftoimg =$ffromimg;
            	     //resize_image($ffromimg,$fftoimg,$xxw,$xxh);
            	     $fftoimg =$destfolder.$ffnm.'_'.$xttnm.'.'.$file_ext;  
            	     ImageResize($ffromimg,$fftoimg,$xxw,$xxh);            	     
            	     
            	     break;            	 
            	 case 'o':      //等比縮圖 & 覆蓋
            	     $fftoimg =$ffromimg;
            	     //resize_image($ffromimg,$fftoimg,$xxw,$xxh);
            	     ImageResize($ffromimg,$fftoimg,$xxw,$xxh);            	     
            	     break;            	     
            	 case 'c':  //只有一張代表圖,不需要大圖時,直接切圖
            	     $fftoimg =$ffromimg;
            	     $resizeimage =new resizeimage($fftoimg,$ffromimg,$xxw,$xxh,'1','0');
            	     break;
            	 default:     //各種尺寸的切圖
            	    $fftoimg =$destfolder.$ffnm.'_'.$xttnm.'.'.$file_ext;  
                  $resizeimage =new resizeimage($fftoimg,$ffromimg,$xxw,$xxh,'1','0'); 
            }
        }    	  
    }    
}




function URIAuthcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
	  if ($string==''){
	  	  return '';
	  	  exit();
	  }
    if( $operation == 'DECODE') $string=str_replace(array("-","_"), array('+','/'),$string);
    $ckey_length = 4;
    $key = md5($key ? $key : $GLOBALS['discuz_auth_key']);
    $keya = md5(substr($key, 0, 16));
    $keyb = md5(substr($key, 16, 16));
    $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';
    $cryptkey = $keya.md5($keya.$keyc);
    $key_length = strlen($cryptkey);
    $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
    $string_length = strlen($string);
    $result = '';
    $box = range(0, 255);
    $rndkey = array();
    for($i = 0; $i <= 255; $i++) {
        $rndkey[$i] = ord($cryptkey[$i % $key_length]);
    }
    for($j = $i = 0; $i < 256; $i++) {
        $j = ($j + $box[$i] + $rndkey[$i]) % 256;
        $tmp = $box[$i];
        $box[$i] = $box[$j];
        $box[$j] = $tmp;
    }
    for($a = $j = $i = 0; $i < $string_length; $i++) {
        $a = ($a + 1) % 256;
        $j = ($j + $box[$a]) % 256;
        $tmp = $box[$a];
        $box[$a] = $box[$j];
        $box[$j] = $tmp;
        $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
    }
    if($operation == 'DECODE') {
        if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
            return substr($result, 26);
        } else {
            return '';
        }
    } else {
        return $keyc.str_replace(array("=","+","/"), array('','-','_'), base64_encode($result));
    }
}



function auth_crypt($nvv,$vty){
	$nval ='';
	if ($nvv<>''){
	    if ($vty=='en'){
	        $nval = 'Eks36d'.$nvv.'kz5XqeQ';
	        $nval = strrev($nval);
	        $nval = base64_encode($nval);
	    }
	    else{
	    	  $nval = base64_decode($nvv);
	        $nval = strrev($nval);
	        $nval = substr($nval, 6, -7);
      }    
  }
	return $nval;
}

function chgmask($xnum){  //漏字
	$nnid ='';
  if ($xnum<>''){
     $nnid  ='';
     $nnlen =mb_strlen($xnum,"utf-8"); 
     
 	   for ($i=0;$i< $nnlen;$i++){ 
 	      if ($i==0){ 
 	      	 $nnid .=mb_substr($xnum,0,1,"utf-8");
 	      } 	 
 	      else{
 	      	 if (($i%2)==0){ 
 	      	 	  $xxm = "*";
 	      	 }	  
 	      	 else{
 	      	 	  $xxm =mb_substr($xnum,$i,1,"utf-8");
 	      	 }
 	      	 $nnid .=$xxm;
 	      } 	      
 	   }
  }
   return($nnid);
}



/**
 * Return human readable sizes
 *
 * @author      Aidan Lister <aidan@php.net>
 * @version     1.3.0
 * @link        http://aidanlister.com/2004/04/human-readable-file-sizes/
 * @param       int     $size        size in bytes
 * @param       string  $max         maximum unit
 * @param       string  $system      'si' for SI, 'bi' for binary prefixes
 * @param       string  $retstring   return string format
 */
function size_readable($size, $max = null, $system = 'si', $retstring = '%01.1f %s')
{
    // Pick units
    $systems['si']['prefix'] = array('B', 'K', 'MB', 'GB', 'TB', 'PB');
    $systems['si']['size']   = 1000;
    $systems['bi']['prefix'] = array('B', 'KiB', 'MiB', 'GiB', 'TiB', 'PiB');
    $systems['bi']['size']   = 1024;
    $sys = isset($systems[$system]) ? $systems[$system] : $systems['si'];
  
    // Max unit to display
    $depth = count($sys['prefix']) - 1;
    if ($max && false !== $d = array_search($max, $sys['prefix'])) {
        $depth = $d;
    }
  
    // Loop
    $i = 0;
    while ($size >= $sys['size'] && $i < $depth) {
        $size /= $sys['size'];
        $i++;
    }
  
    return sprintf($retstring, $size, $sys['prefix'][$i]);
}
?>
