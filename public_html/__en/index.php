<?php
header("Content-Type:text/html; charset=utf-8");

include '../cpsys/sysinc/dbConn.php';

$ff_lang ='en';
$ff_img_dir='../doc_files/';

include '../m_inc/inc_gallery.php';
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>Makokoro</title>
    
  <link rel="icon" href="img/fav.ico" type="image/x-icon">
  <link rel="shortcut icon" href="img/fav.ico" type="image/x-icon" />
	<link rel="stylesheet" href="css/bootstrap.css">
	<link rel="stylesheet" href="css/style.css">
<meta name="keywords" content="Buddha statues,columbarium,columbarium design,columbarium planning,personal urn, personal cabinet,menorial tablets">
	<script type="text/javascript" src="js/jquery.js"></script>	
	<script type="text/javascript" src="js/device.js"></script>	
	<script type="text/javascript" src="js/bootstrap.min.js"></script>	
	<script type="text/javascript" src="js/core.js"></script>
	<script type="text/javascript" src="js/script.js"></script>	

	<!--[if lt IE 9]>
        <div style='text-align:center'><a href="http://windows.microsoft.com/en-US/internet-explorer/products/ie/home?ocid=ie6_countdown_bannercode"><img src="http://storage.ie6countdown.com/assets/100/images/banners/warning_bar_0000_us.jpg" border="0" height="42" width="820" alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today." /></a></div>  
    <![endif]-->
</head>
<body>
<div class="language">
    	<ul>
    		<li class="lan01"><a href="javascript:location.replace('../')">繁體中文</a></li>
    		<li class="lan02"><a href="#">English</a></li>
            <li class="lan03" style="margin-left:2px"><a href="http://www.makokoroks.com">簡體中文</a></li>
    	</ul>
</div>
<div id="webSiteLoader"></div>
<div id="glob-wrap">
	<header>
		<div class="container">
			
<div class="col-lg-12 tac">
				<!--logo and company name-->  
				<h1><a href="./" class="navbar-brand"><img src="img/logo.png" alt=""></a></h1>
				
				<!--menu-->  
					
					  <nav id="mainNav" data-follow="location" data-type="navigation">
					    <ul>
					      <li><a href="./">Gallery</a></li>
                 <li><a href="./news.php">News</a></li>
					      <li><a href="./about.html">About US</a>
					        <!--<nav class="subNav sf-mega" data-follow="location" data-type="navigation">
									<ul>
										<li><a href="./readmore.html">about</a></li>
										<li><a href="./readmore.html">history</a></li>
										<li><a href="./readmore.html">news</a></li>
										<li><a href="./readmore.html">awards</a>
											
										</li>
									</ul>
								</nav>-->
					        </li>
					      <li><a href="./designer.html">Designer</a></li>
					      <li><a href="./contacts.html">Contacts</a></li>
					      </ul>
					    </nav>
	  
		  </div>
		</div>
	</header>

	<article id="content" data-follow="location" data-type="switcher">
		<div data-id="" id="splash" class="mobile-only">
			<div class="container">
			 	<div class="row">
			 		<div class="col-lg-12">
			 			<ul class="splash-list">
	 						<li><a href="./model-1"><img src="img/bg_pic1.jpg" alt=""></a></li>
	 						<li><a href="./model-2"><img src="img/bg_pic2.jpg" alt=""></a></li>
	 						<li><a href="./model-3"><img src="img/bg_pic3.jpg" alt=""></a></li>
	 						<li><a href="./model-4"><img src="img/bg_pic4.jpg" alt=""></a></li>
	 						<li><a href="./model-5"><img src="img/bg_pic5.jpg" alt=""></a></li>
	 						<li><a href="./model-6"><img src="img/bg_pic6.jpg" alt=""></a></li>
	 						<li><a href="./model-7"><img src="img/bg_pic7.jpg" alt=""></a></li>
	 						<li><a href="./model-8"><img src="img/bg_pic8.jpg" alt=""></a></li>
	 						<li><a href="./model-9"><img src="img/bg_pic9.jpg" alt=""></a></li>
	 						<li><a href="./model-10"><img src="img/bg_pic10.jpg" alt=""></a></li>

	 					</ul>		
			 		</div>
		 		</div>
	 		</div>
		</div>
		<?php echo $str_dv?>
	</article>

	<div id="other_pages" data-follow="location" data-type="switcher" data-flags="ajax"></div>

	<div class="pagination-holder">
    <?php if($nrc>20) echo '<div id="prev-1" class="btn btn-control1"><a href="#"><img src="img/prev1.png"></a></div>'; ?>
		<div id="owl" class="owl">
			<?php echo $str_href?>
		</div>
	<?php if($nrc>20) echo '<div id="next-1" class="btn btn-control1"><a href="#"><img src="img/next1.png"></a></div>'; ?>
    </div>
	<div class="show_p">
	 <div class="tac">
	 		<p class=""><a href="#" class="btn btn-link show-panel">category</a></p>	  
	 </div>
	</div>
	<footer>
		<div class="container">
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12">
					<div class="copyright">&copy; <span id="year"></span> &bull; <a href="./privacy.html">makokoro.com</a><br><!-- {%FOOTER_LINK} --></div>
					<div class="clearfix"></div>	
				</div>
			</div>
		</div>
	</footer>
</div>
<script language=javascript>
	var xxbg='<?php echo $str_bg?>';
	if (xxbg !==''){
		  var xarr = xxbg.split(',');
		  var xnn=0;
		  for (i=0;i<xarr.length;i++){
		  	   xnn ++;
	         $('#model-'+xnn).css("background-image", "url(../doc_files/"+xarr[i]+")");  	  	
		  }
  }
	
</script>
</body>
</html>