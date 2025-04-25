<?php 
function get_fileico($nk){	
	$ff_ary =explode('.',$nk);	
	$ff_ext =strtolower($ff_ary[count($ff_ary)-1]);			
	
	$strimg ='';
	switch ($ff_ext){   
   case 'jpg':        
   case 'jpeg':     
   case 'bmp':     
   case 'gif':        
   case 'png':   
     $strimg ='img';
     break;
   case 'xls':      
   case 'xlsx':
      $strimg ='95icon_xls.jpg';
      break;  
   case 'doc':
   case 'docx':
      $strimg ='95icon_doc.jpg';
      break;
   case 'ppt':
   case 'pptx':
      $strimg ='95icon_ppt.jpg';
      break;          
   case 'pdf':         
     $strimg ='95icon_pdf.jpg';
     break;    
   case 'rar':    
     $strimg ='95icon_rar.jpg';
     break;
   case 'zip':    
     $strimg ='95icon_zip.jpg';
     break;
   case '7z':         
     $strimg ='95icon_7z.jpg';
     break;     
   case 'mp3':
   case 'mp4':
   case 'mmv':
   case 'mma':
   case 'avi':
   case 'wav':
     $strimg ='95icon_music.jpg';
     break;      
   case 'ai':  
     $strimg ='95icon_ai.jpg';
     break;         
	}	
	return $strimg;		
}




function get_capa($nnk){     	
	 $ncapa='';
   if ($nnk<>''){  	  
   	  $ncapa =round(($nnk/1024),2);  //KB
   	  if ($ncapa<1){
   	  	  $ncapa =$nnk.'bytes';
   	  }
   	  elseif ($ncapa>1024){
   	      $ncapa =round(($ncapa/1024),2).' MB';  //MB       	  	  	
   	  }
   	  else{
   	  	  $ncapa .=' KB';  //KB       	  	  	
   	  }
   }   
   return $ncapa;
}




?>