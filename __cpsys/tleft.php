<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);  

session_start();

include 'sysinc/dbConn.php';

if ($_SESSION['sys_acc']=='s_pighead'){
   $sqlx ="SELECT ap.apcatid,apcat.apcatcname, ap.apcode, ap.apcname, ap.appath, ap.aporder,ap.apename,ap.para ".
          " FROM ap".
          " LEFT JOIN apcat ON ap.apcatid = apcat.apcatid".
          " where ap.display='Y' and apcat.display='Y' ".
          " ORDER BY apcat.aporder, ap.aporder ";
}
else{ 

   $sqlx ="SELECT a1.apcatid,a2.apcatcname,a1.apcode,a1.apcname,a1.appath,a1.aporder,a1.apename,a1.para ".
          " FROM ap AS a1 ".
          " LEFT JOIN apcat AS a2 ON a1.apcatid = a2.apcatid".
          " WHERE a1.display='Y' AND a2.display='Y' ".
          "   AND a1.apcode in(select apcode from apgroup ".
                            "inner join infouser on infouser.groupid = apgroup.apgroupid ".
                            "where infouser.userid =".$_SESSION['sys_userid'].") ".       
          " ORDER BY a2.aporder,a1.aporder "; 
}

//echo $sqlx;
 
$rsm      =$s_mysqli->query($sqlx);
$rsm_rows =mysqli_num_rows($rsm);       //筆數
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script type="text/javascript" src="sysinc/m_framechk.php"></script> 
<title>leftmenu</title>
<style type="text/css">
<!--
body {
	background-color:#848C91;	
	font-family:"Apple LiGothic Medium","微軟正黑體","Microsoft JhengHei",Arial,Helvetica,sans-serif;
  font-size:13px;  
}

#example1{
margin:5;
padding:0;
width:150px;
list-style-type:circle;
line-height:160%;
font-size:13px;
}

#example1 .closed,#example1 .opened{
padding-right:0px;
background-position:98% 50%;
background-repeat:no-repeat;
}
#example1 .header{
background-color:#7B7B7B;
}
* html ul ul li{
margin-bottom:1px;
}

* html ul ul li a,* html ul li a{
height:100%;
}

#example1 .closed{
background-image:url(sysinc/ha-down.gif);
}

#example1 .opened{
background-image:url(sysinc/ha-up.gif);
}

#example1 a{
display:block;
font-size:1.15em;
text-decoration:none;
}
#example1 a.hover{
border-top:1px solid #5F5F5F;
border-bottom:1px solid #7B7B7B;
background-color:#7B7B7B;
color:#FFFFFF;
}
#example1 ul{
overflow: hidden;
margin:0;
padding:0;
list-style-type:circle;
}

#example1 li{
margin:1;
padding:0;
background-color:#848484;
color:#FFFFFF;
list-style-type:circle;
}

#example1 li a{
padding:5px 10px 2px 4px;
border-top:1px solid #9A9A9A;
border-left:1px solid #9A9A9A;
border-right:1px solid #696969;
border-bottom:1px solid #757575;
background-color:#848484;
color:#FFFFFF;
}

#example1 li.active a,#example1 li li.active a{
border-top:1px solid #5F5F5F;
border-bottom:1px solid #7B7B7B;
border-left:1px solid #757575;
border-right:1px solid #9A9A9A;
background-color:#404040;
color:#FFFFFF;
list-style-type:circle;
}

#example1 li.active li a,#example1 li li a{
padding:5px 4px 2px 17px;
border-top:1px solid #696969;
border-left:1px solid #696969;
border-right:1px solid #8A8A8A;
border-bottom:1px solid #7B7B7B;
background-color:#757575;
color:#fff;
list-style-type:circle;
}
*/
-->
</style>
<link href="css.css" rel="stylesheet" type="text/css">

<script type="text/javascript" src="sysinc/jquery.min.js"></script> 
<script type="text/javascript" src="sysinc/jquery.hoveraccordion.min.js"></script> 

<script type="text/javascript"> 
$(document).ready(function(){	
	$('#example1').hoverAccordion();
});
</script> 
</head>
<body>
<br/><br/>
 <ul id="example1"> 
 	<?php  // ap.apcatid, apcat.apcatcname, ap.apcode, ap.apcname, ap.appath, ap.aporder ,ap.apename,ap.para
 	$fcatid='@';
  $f_apcode ='';
  $f_modnm  ='';
  $f_title1 ='';
  $f_title2 ='';
  $str_li ='';    
  
  for($i=0;$i<$rsm_rows;$i++){
   	 $rsrow =$rsm->fetch_row(); 
   	 if ($rsrow[2]=='S08M02'){   	 
   	 	  $f_apcode =$rsrow[2];
        $f_modnm  =$rsrow[1];
        $f_title1 =$rsrow[3];
        $f_title2 ='';
        $f_apdir  =$rsrow[4];
        $f_apnm   =$rsrow[6];   
        $f_para   =$rsrow[7];   
   	 }
   	 
   	 if ( $fcatid<>$rsrow[0]){
   	 	   if ($fcatid!=='@'){
   	 	   	  $str_li .='</ul></li>';
   	 	   }
   	 	   $fcatid =$rsrow[0];
   	 	  $str_li .='<li><a href="#">'.$rsrow[1].'</a><ul>'; 
   	 }
   	 
   	 $nnapcname=$rsrow[3];
   	 $nnpath   =$rsrow[4];
   	 $nnap     =$rsrow[6];
   	 $nnapcode =$rsrow[2];
   	 $nnpara   =$rsrow[7];
   	 
   	 $strhref  =$nnpath.'/'.$nnap.'_list.php?m='.$nnapcode;   	 
   	 
   	 if ($nnpara<>''){
   	 	  $strhref  .='&'.$nnpara;
     }
   	 
   	 $str_li .= '<li><a href="'.$strhref.'" target="main">‧'.$nnapcname.'</a>';   	    	 
  } 
  $str_li .='</ul></li>';
  echo $str_li;  
  
  $nnff =$f_apdir.'/'.$f_apnm.'_list.php?m='.$f_apcode.'&'.$f_para;  
?>
</ul>
</body>
</html>
<script language=javascript>
	var nnff ='<?php echo $nnff?>';     	 	
 	
	window.parent.frames[2].location.href=nnff;	
	
	var nnapcode ='';
  function goprg(nnid,nnpath,nnap,nncat,nnprg,nsexe){	 	
  	//alert(nnid);
  	 nnapcode =nnid;
  	 document.getElementById("catnm").innerHTML  =nncat;
  	 document.getElementById("mtitle").innerHTML ='';
  	 document.getElementById("submain").innerHTML ='';
  	 document.getElementById("mtitle").innerHTML =nnprg;	
  	 
  	 var nnff ='';  	 
     nnff =nnpath+'/'+nnap+'_list.php?m='+nnid
     document.getElementById("imod").src =nnff;
  }
</script>