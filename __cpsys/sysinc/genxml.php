<?php
function genxml($nid){
	  include 'dbConn.php';
	   
	  $sqlx ='select wkid,wknote,photo,caseid '.
           'from wk_gallery '.
           'where caseid ='.$nid.' and display=\'Y\' '.
           'order by caseid,sno ';
    //echo $sqlx;
    //exit();
    $rsx      = mysql_query($sqlx,$s_link);
    $rsx_rows = mysql_num_rows($rsx);  //筆數
    $strxml   ='';    
    // 
    $ftmpxml  ='xmltmp.xml';  //樣版
    $handle   =fopen($ftmpxml, "r");  //xml樣本檔
    $ftext    ='';
    while (!feof($handle)) {
      $ftext .= fread($handle,8192);
    }
    fclose($handle);
    
    //-----
    for($i=0;$i<$rsx_rows;$i++){
       $rsxrow =mysql_fetch_row($rsx);
       $xphoto =$rsxrow[2];
       $ffnmary  =explode('.',$xphoto);
       $xthumb =$ffnmary[0].'_pr.'.$ffnmary[1];
       
       //$strxml =$strxml."<item><thumb>".$rsxrow[2]."</thumb><img>".$rsxrow[2]."</img><caption>".$rsxrow[1]."</caption></item>";
       $strxml =$strxml.'<item source="'.$xphoto.'" thumb="'.$xthumb.'" description="'.$rsxrow[1].'" />';
    }   
    
    $fnewtxt =str_replace("#item",$strxml,$ftext);
    
    $ftofile ='art_'.$nid.'.xml';
    $fp  =fopen($ftofile, "w");    //若不存在則自動建立      
   
    if($fp){
      fwrite($fp,$fnewtxt);
    }  
    fclose($fp);
    
   // $fsource   = $ftofile;
   // $fdestfile = '../../galleryxml/'.$fsource;
    
   // if (!copy($fsource,$fdestfile)) {
  //     echo "failed to copy $file...\n";
  //     exit();
  //  }	    
}
?>