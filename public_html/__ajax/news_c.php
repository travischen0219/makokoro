<?php
$ff_lang ='tw';
$ff_db_dir ='../cpsys/sysinc/dbConn.php';
include '../m_inc/inc_news_c.php';
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?php echo $f_title?></title>
<style>
.newsphoto{	
	float:left;
	width:170px;
	height:250px;
	margin-right:10px;
	}
.newsphoto img{margin-bottom:7px}
</style>
</head>
<body>
	<div>
		<div class="container">
			<div class="row">
				<div class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1 col-sm-12 col-xs-12 tac bg">		
				 <div class="padding-4 animateBlock">
						<h3 class="animateItem1"><?php echo $f_title?></h3>
						<div class="row">
              <?php echo $f_newsnote?>
              <div class="back"><a href="./news.php">back</a></div>
				    </div>
				  </div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>