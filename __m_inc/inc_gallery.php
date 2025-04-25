<?php
//--背景圖
$sqlx ='SELECT `photo` FROM `vi_ci` WHERE `display`=\'Y\' ORDER by sno';
$rsv  =$s_mysqli->query($sqlx);
$str_li_bg ='';
$str_bg='';
$nrc=0;
while($rsv_c =mysqli_fetch_assoc($rsv)){
  $nrc+=1;	
	$str_li_bg .='<li><a href="./model-'.$nrc.'"><img src="./doc_files/'.$rsv_c['photo'].'" alt=""></a></li>';		
	$str_bg .=$rsv_c['photo'].',';
}	
if ($str_bg<>''){
	  $str_bg =substr($str_bg,0,strlen($str_bg)-1);
}
//echo $str_bg;


//--album
if ($ff_lang=='tw'){
	 $ff_fld ='wknm,wk_tit,wkinfo';
	 $ff_fld2 ='title';
	 $ff_msg_more ='';
}	    
elseif ($ff_lang=='en'){
	 $ff_fld  ='wknm_en as wknm,wk_tit_en as wk_tit,wkinfo_en as wkinfo';
	 $ff_fld2 ='title_en as title';
	 $ff_msg_more ='';
}	

$sqlx ='select caseid,'.$ff_fld.',photo from album_case where display=\'Y\' order by sno';
//echo $sqlx; 
$rsa   =$s_mysqli->query($sqlx);
$str_li ='';
$str_href='';
$str_dv ='';
$nrc =0;
while($rsa_c =mysqli_fetch_assoc($rsa)){ 	   
     $nrc +=1;            
     $str_li   .='<li><a href="./model-'.$nrc.'"><img src="'.$ff_img_dir.$rsa_c['photo'].'" alt=""></a></li>';     
     $str_href .='<a href="./model-'.$nrc.'">'.$nrc.'</a>';     
     
     $sqlx ='SELECT caseid,wkid,'.$ff_fld2.',photo FROM album_gallery WHERE display=\'Y\'  AND caseid ='.$rsa_c['caseid'].' ORDER BY sno ';
     $rsb   =$s_mysqli->query($sqlx);   
     //echo $sqlx;
     //exit();
     $xximg_dv='';
     while($rsb_c =mysqli_fetch_assoc($rsb)){ 
     	  $xximg_dv .='<div><img src="'.$ff_img_dir.$rsb_c['photo'].'" alt=""></div>';
     }
     
     $str_dv .='<div data-id="model-'.$nrc.'" id="model-'.$nrc.'" class="model-bg">
			<a href="./model-'.$nrc.'" class="model-logo"><strong class="mar_t_300"> 
				<em>'.$nrc.'</em><br>
				<span class="name">'.$rsa_c['wknm'].'</span>	
			</strong>
			
			</a>
			<div class="container">
			 	<div class="row">
			 		<div class="col-lg-4 col-lg-offset-0 col-md-4 col-md-offset-0 col-sm-4 col-sm-offset-0">
						<p class="model-logo animateItem1">
							<strong>
								<em>'.$nrc.'</em><br>
								<span class="name">'.$rsa_c['wknm'].'</span>
							</strong>
						</p>
						<div class="bg_1 animateBlock animateBlock-2">
							<div class="padding-1">
							<a href="./" class="close-btn"><span></span></a>
							<!--h2 class="animateItem1">'.$rsa_c['wk_tit'].'</h2-->
							<p class="animateItem2">'.htmlspecialchars_decode($rsa_c['wkinfo']).'</p>							
							</div>
							<div class="bg-2 animateBlock animateBlock-2">
								<p class="no-margin animateItem5"><a href="#" class="btn btn-link btn-photo"><span></span>'.$ff_msg_more.'</a></p>
							</div>
						</div>
			 		</div>
					<div class="col-lg-8 col-lg-offset-0 col-md-8 col-md-offset-0 col-sm-8 tab_-200">
						<div class="relative">
							<div class="owl mar_t_420">'.$xximg_dv.'</div>
							<div id="prev-2" class="btn btn-control2"><a href="#"><img src="img/prev2.png"></a></div>
							<div id="next-2" class="btn btn-control3"><a href="#"><img src="img/next2.png"></a></div>
						</div>
					</div>
				</div>
			</div>
		</div>';
}	
?>