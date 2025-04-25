<?php
$result =false;
$xact_sts ='';

$xold_pwd ='';
if (isset($_POST['hxx_pwd'])){
   $xold_pwd = $_POST['hxx_pwd'];
}

$feditmode =strtolower($feditmode);

if ($feditmode=='add'){
	 $xact_sts ='已新增';	 
   $sqla ='insert into '.$fftable.'(editor,editdate,';
   $sqlb ='values(\''.$fsys_user.'\',NOW(),';   
   
   if (isset($f_crdate)){     //是否有建立日期的欄位
   	   if ($f_crdate=='Y'){
          $sqla .='crdate,';
          $sqlb .='NOW(),';   
   	   }
   }  
   
   
   if (isset($mmytid)){   //是否有Youtube 欄位
   	  if ($mmytid<>''){
   	      $sqla .='ytid,';
   	      $sqlb .='\''.$mmytid.'\',';   
   	  } 
   	  if (isset($fypic)){    //是否有Youtube 封面圖欄位
   	  	  if ($fypic<>''){
   	  	  	   $sqla .='ypic,';
   	           $sqlb .='\''.$fypic.'\',';    
   	  	  }
   	  }  	  
   } 
   if (isset($mmvmoid)){   //是否有Vimeo 欄位
   	  if ($mmvmoid<>''){
   	      $sqla .='vimeo_id,';
   	      $sqlb .='\''.$mmvmoid.'\',';   
   	  }    	  
   }       
     
   
   if (isset($f_sno)){   //是否有排序欄位
   	   if ($f_sno =='Y'){
   	   	  $xsno_where='';
   	   	  $xsno_o ='';
   	   	  if (isset($f_sno_where)){   //有條件的排序
   	   	  	  if ($f_sno_where<>''){
   	   	  	  	  $xsno_where =$f_sno_where;   	   	  
   	   	  	  }
   	   	  }   	   	  
   	   	  if (isset($f_sno_o)){    //排序的方式 a:正常 d:新的在第一筆
   	   	  	  $f_sno_o =$f_sno_o;
   	   	  }	
   	   	  else{
   	   	  	   $f_sno_o ='';
   	   	  }   	   	  
   	   	  
   	   	  if ($f_sno_o =='d'){
   	   	     $sqlx  ='update '.$fftable.' set sno=sno+1 '.$xsno_where;
   	   	     $result =$s_mysqli->query($sqlx);
	           $ffsno =1;  
   	   	  }
   	   	  else{
   	   	  	
   	   	  	  $sqlx  ='select sno from '.$fftable.' '.$xsno_where.' order by sno desc limit 0,1';   	   	  	  
	            $rst   =$s_mysqli->query($sqlx);   
              $ffsno ='';
              if ($rst){
                  $rst_c =mysqli_fetch_row($rst);      
                  $ffsno =$rst_c[0]+1;
              }   
              else{
   	              $ffsno =1;
              }                	  	              
   	   	  }
	                   	   	
   	   	  //--
   	   	   $sqla .='sno,';
   	       $sqlb .=$ffsno.',';
   	   }
   }   
   //----   
   $ffield  ='';
   $strfield='';
   $strvalue='';
   $strfield2='';
   $strvalue2='';
    if (count($_POST)>0){ 
    	 foreach($_POST as $_tag => $_value){     	  	
    	 	  $fhtag = substr($_tag,0,4);
    	 	  $ffield= substr($_tag,4);
    	 	  if (substr($fhtag,1,3)=='fx_'){
    	 	  	  $strfield =$strfield.$ffield.",";	     	 	  	  
    	 	      switch ($fhtag){
    	 	      	case 'tfx_':    	 	           
    	 	      	   $strvalue =$strvalue."'".htmlspecialchars($_value,ENT_QUOTES)."',";
    	 	      	   break;
    	 	      	case 'nfx_':    	 	      	   
    	 	      	   if ($_value==''){
    	 	      	   	  $strvalue =$strvalue."NULL,";
    	 	      	   }
    	 	      	   else{
    	 	      	   	  $strvalue =$strvalue.htmlspecialchars($_value,ENT_QUOTES).",";
    	 	      	   }
    	 	      	   break;   
    	 	      	case 'dfx_':    	 	      	   
    	 	      	   if ($_value==''){
    	 	      	   	  $strvalue =$strvalue."NULL,";
    	 	      	   }
    	 	      	   else{
    	 	      	   	  $strvalue =$strvalue."'".htmlspecialchars($_value,ENT_QUOTES)."',";
    	 	      	   }
    	 	      	   break;
    	 	      	case 'cfx_':
    	 	      	   if (is_array($_value)){  //如果是checkbox 陣列
    	 	      	   	   $strck ='';
    	 	      	   	   foreach($_POST as $_tag => $_value){ 	
                       	 if (is_array($_value)){
                       	 	  $strck =implode(",",$_value);                       	 	  
                       	 }
                       }
                       $strvalue =$strvalue."'".htmlspecialchars($strck,ENT_QUOTES)."',";                       
    	 	      	   }	   
    	 	      	   else{
    	 	      	   	   $strvalue =$strvalue."'".htmlspecialchars($_value,ENT_QUOTES)."',";
    	 	      	   }  
    	 	      	   break;
    	 	      	case 'pfx_':  //
    	 	      	    if ($_value<>''){
 	 	      	            $xxpwd    =md5(htmlspecialchars($_value,ENT_QUOTES));
    	 	      	        $strvalue =$strvalue."'".$xxpwd."',"; 
    	 	      	    }    
 	 	      	        break;  
 	 	      	          
 	 	      	    case 'ufx_':  //encrypt  	 	           
 	 	      	         $strvalue =$strvalue."'".auth_crypt(htmlspecialchars($_value,ENT_QUOTES),'en')."',";
 	 	      	        break;       
    	 	      	default :
    	 	      	   $strvalue =$strvalue."'".htmlspecialchars($_value,ENT_QUOTES)."',";
    	 	      	   break;
     	 	      }
     	 	   }
       }              
       
       if (isset($fphoto)){
          if ($fphoto <>''){
       	     $sqla =$sqla.'photo'.',';	
       	     $sqlb =$sqlb."'".htmlspecialchars($fphoto,ENT_QUOTES)."',";
          } 
       }
       if(isset($ff_imgcnt)){       	
       	    for($i=1;$i<=$ff_imgcnt;$i++){
       	    	  $xxpic ='fphoto'.$i;
       	    	  $xxfld ='photo'.$i;
       	    	  if (isset(${$xxpic})){
       	    	     if (${$xxpic}<>''){
       	    	         $sqla =$sqla.$xxfld.',';	
       	               $sqlb =$sqlb."'".htmlspecialchars(${$xxpic},ENT_QUOTES)."',"; 
       	           }
       	        }   
       	    }	
       }
       if (isset($fsphoto)){   //小圖檔名
           if ($fsphoto<>''){
       	      $sqla =$sqla.'sphoto'.',';	
       	      $sqlb =$sqlb."'".htmlspecialchars($fsphoto,ENT_QUOTES)."',";
            } 
       }            
           
       if (isset($fufile)){
          if ($fufile <>''){
       	     $sqla =$sqla.'ufile'.',';	
       	     $sqlb =$sqlb."'".htmlspecialchars($fufile,ENT_QUOTES)."',";
          } 
       }  
       
       for($i=1;$i<=8;$i++){
       	   $xxuf    ='fufile'.$i;
       	   $xxuf_tt ='fufile'.$i.'_tit';
       	   if (isset(${$xxuf})){
       	   	  if (${$xxuf}<>''){
       	         $sqla =$sqla.'ufile'.$i.',';	
       	         $sqlb =$sqlb."'".htmlspecialchars(${$xxuf},ENT_QUOTES)."',";
       	         
       	         if (isset(${$xxuf_tt})){
       	     	       $sqla =$sqla.'ufile1_tit,';	
       	     	       $sqlb .="'".htmlspecialchars(${$xxuf_tt},ENT_QUOTES)."',";
       	         }       	         
              } 
       	   }
       	   $xxuf    ='fufile'.$i.'_ch';
       	   $xxuf_tt ='fufile'.$i.'_tit_ch';
       	   if (isset(${$xxuf})){
       	   	  if (${$xxuf}<>''){
       	         $sqla =$sqla.'ufile'.$i.'_ch,';	
       	         $sqlb =$sqlb."'".htmlspecialchars(${$xxuf},ENT_QUOTES)."',";
       	         
       	         if (isset(${$xxuf_tt})){
       	     	       $sqla =$sqla.'ufile1_tit_ch,';	
       	     	       $sqlb .="'".htmlspecialchars(${$xxuf_tt},ENT_QUOTES)."',";
       	         }       	         
              } 
       	   }      	          	   	
       }                    
       
       
       //--是否有其它欄位   //array( array('servhour','T',$str_servhr) )  欄位名,型態,值
       if (isset($arr_fld)){  
       	  $xcc =count($arr_fld);
       	  for($h=0;$h<$xcc;$h++){             
             $xxfld =$arr_fld[$h][0];
             $xxtyp =$arr_fld[$h][1];
             $xxval =$arr_fld[$h][2];
             
             $sqla .=$xxfld.',';             
             if ($xxtyp=='T'){
             	  $sqlb .="'".$xxval."',";
             }
             else if($xxtyp=='N'){
             	  $sqlb .=$xxval.",";
             }             
          }
       }   
       
       
       if($strfield<>''){       	  
       	  $sqla =$sqla.substr($strfield,0,strlen($strfield)-1).")";
       }
       else{
       	  $sqla =substr($sqla,0,strlen($sqla)-1).")";
       }
       if($strvalue<>''){       	  
       	  $sqlb =$sqlb.substr($strvalue,0,strlen($strvalue)-1).")"; 
       }	
       else{
       	  $sqlb =substr($sqlb,0,strlen($sqlb)-1).")";
       }                                   
       $strsql =$sqla.' '.$sqlb;   //LAST_INSERT_ID() mysql 取新增後的自動編號       
       
       $result=$s_mysqli->query($strsql) or die('sql錯誤!: '.$strsql.'<br/>' . mysqli_error()).'<br/>';
       //echo $strsql;       
       //exit();
    }
    else{
    	  $xact_sts ='add:post para err';	 	    
    }
}    
else{
	
	 $xact_sts ='已修改';	 
	 $fid  = $_POST['pxx_id'];
	 
	 $sqla  ='update '.$fftable.' set editor=\''.$fsys_user.'\',editdate=NOW(),';
   $sqlb  =' where '.$ffpk.'='.$fid;   
   
   if (isset($mmytid)){   //是否有Youtube 欄位   	  
   	  $sqla .="ytid='".$mmytid."',";
   	  
   	  if (isset($fypic)){    //是否有Youtube 封面圖欄位
   	  	  if ($fypic<>''){
   	  	  	  $sqla .="ypic='".$fypic."',";   	  	  	   
   	  	  }
   	  }
   }      
   
   $ffield='';
   $strfield  ='';
   $strvalue  ='';               
   $strfield2 ='';
   $strvalue2 ='';
	 
	 if (count($_POST)>0){ 
    	 foreach($_POST as $_tag => $_value){     	  	
    	 	  $fhtag  =substr($_tag,0,4);
    	 	  $ffield =substr($_tag,4);    
    	 	  //echo $_tag.':'.$_value.'<br/>';  
    	 	  if (substr($fhtag,1,3)=='fx_'){
    	 	      switch ($fhtag){
    	 	      	case 'tfx_':
    	 	      	   $strfield =$strfield.$ffield."='".htmlspecialchars($_value,ENT_QUOTES)."',";
    	 	      	   break;
    	 	      	case 'nfx_':    	 	      	   
    	 	      	   if ($_value==''){    	 	      	   	  
    	 	      	   	  $strfield =$strfield.$ffield."=NULL,";
    	 	      	   }
    	 	      	   else{    	 	      	   	  
    	 	      	   	  $strfield =$strfield.$ffield."=".htmlspecialchars($_value,ENT_QUOTES).",";
    	 	      	   }
    	 	      	   break;   
    	 	      	case 'dfx_':    	 	      	   
    	 	      	   if ($_value==''){
    	 	      	   	  $strfield =$strfield.$ffield."=NULL,";
    	 	      	   }
    	 	      	   else{
    	 	      	   	  $strfield =$strfield.$ffield."='".htmlspecialchars($_value,ENT_QUOTES)."',";
    	 	      	   }
    	 	      	   break;
    	 	      	   
    	 	      	case 'cfx_':
    	 	      	   if (is_array($_value)){  //如果是checkbox 陣列
    	 	      	   	   $strck ='';
    	 	      	   	   foreach($_POST as $_tag => $_value){ 	
                       	 if (is_array($_value)){
                       	 	  $strck =implode(",",$_value);                       	 	  
                       	 }
                       }                       
                       $strfield =$strfield.$ffield."='".htmlspecialchars($strck,ENT_QUOTES)."',";                      
    	 	      	   }	   
    	 	      	   else{
    	 	      	   	    $strfield =$strfield.$ffield."='".htmlspecialchars($_value,ENT_QUOTES)."',";
    	 	      	   }  
    	 	      	   break;  
    	 	      	   
    	 	      	case 'pfx_': //password
    	 	      	   if (isset($_POST['hxx_pwd'])){
    	 	      	   	  $xold_pwd =$_POST['hxx_pwd'];
    	 	      	   	  if ($_value<>'' & $xold_pwd<>$_value){
 	 	      	              $xxpwd    =md5(htmlspecialchars($_value,ENT_QUOTES)); 
 	 	      	              $strfield =$strfield.$ffield."='".$xxpwd."',";
 	 	      	           }
                   } 	 
    	 	      	   break; 
    	 	      	   
    	 	       case 'ufx_':    	 	      	  
    	 	      	    $strfield =$strfield.$ffield."='".auth_crypt(htmlspecialchars($_value,ENT_QUOTES),'en')."',";    	 	      	   
    	 	      	    break;   	      
    	 	      	    
    	 	      	default :    	 	      	   
    	 	      	     $strfield =$strfield.$ffield."='".htmlspecialchars($_value,ENT_QUOTES)."',";
    	 	      	   break;     
     	 	      }
     	 	   }     	 	       	 	      
       }   
              
       //echo $fphoto.'<br/>'.$fphoto_en;
       //exit(); 
       if (isset($fphoto)){      
          if ($fphoto <>''){
       	    $strfield =$strfield."photo='".htmlspecialchars($fphoto,ENT_QUOTES)."',";       	  
          } 
       }
       if(isset($ff_imgcnt)){       	
       	    for($i=1;$i<=$ff_imgcnt;$i++){
       	    	  $xxpic ='fphoto'.$i;
       	    	  $xxfld ='photo'.$i;  
       	    	  if (isset(${$xxpic})){       	    	     
       	    	     $strfield =$strfield."photo".$i."='".htmlspecialchars(${$xxpic},ENT_QUOTES)."',";
       	    	  }   
       	       // echo ${$xxpic};
       	    }	
       } 	       
       
       if (isset($fsphoto)){
           if ($fsphoto<>''){
       	        $strfield =$strfield."sphoto='".htmlspecialchars($fsphoto,ENT_QUOTES)."',";
            } 
       } 
       
       for($i=1;$i<=8;$i++){
       	   $xxuf    ='fufile'.$i;
       	   $xxuf_tt ='fufile'.$i.'_tit';
       	   if (isset(${$xxuf})){       	   	  
       	       $strfield =$strfield."ufile".$i."='".htmlspecialchars(${$xxuf},ENT_QUOTES)."',";       	       
       	      if (isset(${$xxuf_tt})){   
       	         $strfield .="ufile".$i."_tit='".htmlspecialchars(${$xxuf_tt},ENT_QUOTES)."',";
       	      }               
       	   }
       	   $xxuf    ='fufile'.$i.'_ch';
       	   $xxuf_tt ='fufile'.$i.'_tit_ch';
       	   if (isset(${$xxuf})){       	   	  
       	       $strfield =$strfield."ufile".$i."_ch='".htmlspecialchars(${$xxuf},ENT_QUOTES)."',";       	       
       	      if (isset(${$xxuf_tt})){   
       	         $strfield .="ufile".$i."_tit_ch='".htmlspecialchars(${$xxuf_tt},ENT_QUOTES)."',";
       	      }               
       	   }
       }
       
       if (isset($mmytid)){   //是否有Youtube 欄位   
       	   $strfield .='ytid=\''.$mmytid.'\',';   	       
   	       
   	       if (isset($fypic)){    //是否有Youtube 封面圖欄位   	       	  
   	         	 $strfield .='ypic=\''.$fypic.'\',';
   	       }  	  
       }   
       
       if (isset($mmvmoid)){   //是否有Vimeo 欄位       	  
       	   $strfield .='vimeo_id=\''.$mmvmoid.'\',';
       }                
       
       //--是否有其它欄位   //array( array('servhour','T',$str_servhr) )
       if (isset($arr_fld)){  
       	  $xcc =count($arr_fld);
       	  for($h=0;$h<$xcc;$h++){             
             $xxfld =$arr_fld[$h][0];
             $xxtyp =$arr_fld[$h][1];
             $xxval =$arr_fld[$h][2];             
             if ($xxtyp=='T'){             	  
             	  $strfield .=$xxfld."='".$xxval."',"; 
             }
             else if($xxtyp=='N'){
             	  $strfield .=$xxfld."=".$xxval.","; 
             }             
          }
       }	           
       //------------------------                       
       
       $strsql =$sqla.$strfield;
       $strsql =substr($strsql,0,strlen($strsql)-1).$sqlb;
       
       //echo $strsql;
       //exit();
       
       $result =$s_mysqli->query($strsql) or die('sql錯誤!: '.$strsql.'<br/>' . mysqli_error()).'<br/>';       
    }
    else{
    	  $xact_sts ='edit:post para err';		 	    
    }	 	  	 
}



if ($result===false){
	  $xact_sts ='存檔發生錯誤!!';	  
}
echo "<script>alert('".$xact_sts."');</script>";

if (isset($fbak_form)){
	 if ($fbak_form<>''){
       echo $fbak_form;
       echo '<script>document.reg.submit();</script>';
   }
}
else{
	  //echo $strgourl;
	  echo("<script>location.replace('".$strgourl."');</script>"); 
}
?>