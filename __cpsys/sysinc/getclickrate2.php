<?php
function getclickrate($ncid,$nnu,$nnk,$nssid,$nlang){
//ncid,nnu,nnk,nssid
//c,u,k,e,lang  //ncid:p_key ,nnu:unit, nnk:kind, nssid:sessionid, lang:language
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Expires: Mon, 1 Mon 1990 00:00:00 GMT");
header("Last-Modified: ".gmdate('D, d M Y H:i:s') . " GMT");

$xxcaseid ='';    //id 
$xxunit   ='';    //eg...wk,dg,nw,bg => wk:wk_case, db:designer ,nw:news, bg:blog
$xxkind   ='';    //click,push,msg
$xxssid   ='';    //session id
$xxlang   ='';    //c,ch,en,jp (language)

$ferr='';
if ($ncid<>''){
	$xxcaseid =$ncid;
}
else{
	$ferr='err';
}

if ($nnu<>''){
	$xxunit =$nnu;   
}
else{
	$ferr='err';
}

if ($nnk<>''){
	$xxkind =$nnk;
}
else{
	$ferr='err';
}

if ($nssid<>''){
	$xxssid =$nssid;
}
else{
	$ferr='err';
}

if ($nlang<>''){
	$xxlang =$nlang;    //'c,ch,en,jp
}
else{
	$ferr='err';
}


if ($ferr=='err'){
	 $strvalue ='error';
}
else{
	   //$strvalue =$xxssid; 	
	   include './cpsys/sysinc/dbConn.php';
	   
	  //清除超時的sessionid -->新增sessionid --> 計算(累加)次數  	        
	  
    //TIMESTAMPDIFF(MINUTE,'2009/12/3 13:30',NOW())  
    //點閱數(click)30分鐘內 , 推薦數(push)1天以內
    
    $ff_clickdate ='';    //判斷語言 
    $fftable ='';
    if ($xxlang=='c'){
    	  $ff_clickdate ='clickdate';
    }
    else if($xxlang=='ch'){
    	  $ff_clickdate ='clickdate_ch';
    }	
    else if($xxlang=='en'){
    	  $ff_clickdate ='clickdate_en';
    }	
    else if($xxlang=='jp'){
    	  $ff_clickdate ='clickdate_jp';
    }	        
    
    //--先清除時間超過規定時間的所有session id. (推薦5小時內不可再推,點閱半小時內不可再計點閱)
    $sqlx ="delete from clickrate where ".
           "(TIMESTAMPDIFF(MINUTE,".$ff_clickdate.",NOW())>30 and dokind='click') ".
           "or (TIMESTAMPDIFF(HOUR,".$ff_clickdate.",NOW())>3 and dokind='push')";
    //echo $sqlx.'<br/>';       
    $result =mysql_query($sqlx,$s_link) or die('sql錯誤!: '.$sqlx.'<br/>'.mysql_error());
    //echo 'delete:'.$result.'<br/>';
    if ($result){   
    	 $sqlx     ="select 't' from clickrate where sid='".$xxssid."' and cunit='".$xxunit."' and wid=".$xxcaseid ." and dokind='".$xxkind."'";
    	 //echo $sqlx.'<br/>'; 
    	 $rsc      =mysql_query($sqlx,$s_link) or die('sql錯誤!: '.$sqlx.'<br/>' . mysql_error());
       $rsc_rows =mysql_num_rows($rsc);  //筆數  
       $fsumadd  ='';   //是否可以累加
       //echo 'rsc_rows:'.$rsc_rows.'<br/>';
       if ($rsc_rows<=0){    //是否已有該session id ,如果沒有就新增記錄 
       	   $fsumadd ='t';
       	   $sqlx ="INSERT INTO clickrate(sid,".$ff_clickdate.",cunit,wid,dokind) ".
    	            "VALUES('".$xxssid."',NOW(),'".$xxunit."',".$xxcaseid.",'".$xxkind."') ";
            //echo $sqlx.'<br/>'; 
    	     $result =mysql_query($sqlx,$s_link) or die('sql錯誤!: '.$sqlx.'<br/>' . mysql_error());
       }    	    	 
    	 //echo 'add?:'.$fsumadd.'<br/>';
    	 if ($fsumadd=='t'){  //累加次數,如果不在規定分鐘內者 才能累加   
    	 	  $fftable=''; 	
    	 	  $ffkey =''; 	  
    	    if ($xxunit=='wk'){
    	    	 $fftable='wkcase_push';
    	    	 $ffkey ='caseid';
    	    	 
    	    }
    	    else if($xxunit=='dg'){
    	    	 $fftable='designer_push'; 
    	    	 $ffkey ='did';
    	       
    	    }
    	    else if($xxunit=='nw'){    	 
    	    	 $fftable='news_push';    
    	    	 $ffkey ='bno';    	       
    	    } 
    	    
    	    $sqlx  ="select 't' from ".$fftable." where ".$ffkey."=".$xxcaseid;    	        	         	    
          
    	    $rsadd =mysql_query($sqlx,$s_link) or die('sql錯誤!: '.$sqlx.'<br/>' . mysql_error()); 
    	    $rsadd_rows =mysql_num_rows($rsadd);  //筆數
    	    
    	    $ffield ='';
    	    if ($xxlang=='c'){
    	       $ff_clickdate ='clickdate';
    	       $ffield = $xxkind.'num';
          }
          else{
          	 $ffield = $xxkind.'num'.'_'.$xxlang;
          }  
    	    
    	    if ($rsadd_rows<=0){   //無資料時.新增
    	    	  $sqlx ="insert into ".$fftable."(".$ffkey.",".$ffield.") ".
    	    	         "values(".$xxcaseid.",1)";    	        
    	    	  $result =mysql_query($sqlx,$s_link) or die('sql錯誤!: '.$sqlx.'<br/>' . mysql_error());
    	    	  if ($result){
    	           $strvalue ='1人';   
    	        }
    	        else{
    	        	 $strvalue ='error';   
    	        }   
    	    }
    	    else{   //累加    	    	  
    	    	  $sqlx ="update ".$fftable." set ".$ffield."=".$ffield."+1 where ".$ffkey."=".$xxcaseid;
    	    	  $result =mysql_query($sqlx,$s_link) or die('sql錯誤!: '.$sqlx.'<br/>' . mysql_error());
    	    	  if ($result){
    	    	  	 $sqlx ="select ".$ffield." from ".$fftable." where ".$ffkey."=".$xxcaseid;
    	    	  	 $rss      =mysql_query($sqlx,$s_link);                 
                 $rssrow   =mysql_fetch_row($rss);
    	           $strvalue =$rssrow[0].'人';   
    	        }
    	        else{
    	        	 $strvalue ='error';   
    	        }
    	    }
    	 	  
    	 }
    	 else{
    	 	  $strvalue ='already';
    	 }
    	  
    }
    else{
    	  $strvalue ='error';
    }
}
//echo $strvalue;
}
?>