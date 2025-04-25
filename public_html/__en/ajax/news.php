<?php
$ff_lang ='en';
$ff_db_dir ='../../cpsys/sysinc/dbConn.php';
include '../../m_inc/inc_news.php';
?>
<!doctype html>

<html lang="en">

<head>

	<meta charset="UTF-8">

	<title>News | Makokoro</title>

</head>

<body>
	<div>
		<div class="container">
			<div class="row" >
				<div class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1 col-sm-12 col-xs-12 tac bg" >
				<div class="padding-4 animateBlock">
						<h3 class="animateItem1">NEWS</h3>
						<div class="row">						
                <ul class="animateItem5 News" style="margin:0px;"><?php echo $str_li?></ul>
					</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>