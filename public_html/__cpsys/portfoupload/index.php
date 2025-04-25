<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);

$m_apcode ='';
if (isset($_POST['hxx_apcode'])){
   $m_apcode =$_POST['hxx_apcode'];
}   
else{
	 echo 'error access !!';
	 exit();
}

$m_kind ='';  //記錄那個單元
if (isset($_POST['hxx_mkind'])){
	 $m_kind =$_POST['hxx_mkind']; 
}	  
else{
	  echo 'error model!';
	  exit();
}


/*fapdata 批次上傳程式的參數 apname,table,pk,cid,nm,dir
  apname:程式名稱 (返回)
  table :資料表名稱
  pk    :主鍵欄位名 或 須存入判斷值的欄位
  cid   :主鍵值 或 重要判斷值
  nm    :上傳檔案,前兩個字
  dir   :返回資料夾  
*/  
  	

$fapdata ='';
if (isset($_POST['hxx_apdata'])){
   $fapdata =$_POST['hxx_apdata'];  
} 
$arr_dd=explode(',',$fapdata);

$fftodir =$arr_dd[5];
$ffdoap  =$arr_dd[0].'_list.php';
$ffpara  ='?m='.$m_apcode.'&k='.$m_kind;

$ff_frm_action ='../'.$fftodir.'/'.$ffdoap.$ffpara;
$ff_back_dir ='../'.$fftodir;  

include '../sysinc/m_serverchk.php';

$fcaseid ='';
$fcasenm ='';
$strcat ='';
if (isset($_POST['hxx_wkid'])){	
	$fcaseid =$_POST['hxx_wkid'];
  $fcasenm =$_POST['hxx_casenm'];
}

if (isset($_POST['hxx_catid'])){	
	 $strcat  =$_POST['hxx_catid'];
}	

$strsz ='';
if (isset($_POST['hxx_psize'])){	
   $strsz =$_POST['hxx_psize'];
}
$str_rz ='';
if (isset($_POST['hxx_rz'])){	
   $str_rz =$_POST['hxx_rz'];
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Portofolio Uploader..by Queue</title>
	<!--script type="text/javascript" src="source/mootools1-2-2.js"></script-->
	<script type="text/javascript" src="source/mootools-core-1.4.5-full-compat.js"></script>	
	<script type="text/javascript" src="source/Swiff.Uploader.js"></script>
	<script type="text/javascript" src="source/Fx.ProgressBar.js"></script>
	<script type="text/javascript" src="source/coreLang.js"></script>
	<script type="text/javascript" src="source/FancyUpload2.js"></script>
	
	<script type="text/javascript">		
   window.addEvent('domready', function() { // wait for the content

	// our uploader instance 
	
	var up = new FancyUpload2($('demo-status'), $('demo-list'), { // options object
		// we console.log infos, remove that in production!!
		verbose: true,
		
		// url is read from the form, so you just have to change one place
		url: $('form-demo').action,
		
		// path to the SWF file
		path: 'source/Swiff.Uploader.swf',
		
		// remove that line to select all files, or edit it, add more items
		typeFilter: {
			'Images (*.jpg, *.jpeg, *.gif, *.png)': '*.jpg; *.jpeg; *.gif; *.png'
		},
		
		// this is our browse button, *target* is overlayed with the Flash movie
		target: 'demo-browse',
		
		// graceful degradation, onLoad is only called if all went well with Flash
		onLoad: function() {
			$('demo-status').removeClass('hide'); // we show the actual UI
			$('demo-fallback').destroy(); // ... and hide the plain form
			
			// We relay the interactions with the overlayed flash to the link
			this.target.addEvents({
				click: function() {
					return false;
				},
				mouseenter: function() {
					this.addClass('hover');
				},
				mouseleave: function() {
					this.removeClass('hover');
					this.blur();
				},
				mousedown: function() {
					this.focus();
				}
			});

			// Interactions for the 2 other buttons
			
			$('demo-clear').addEvent('click', function() {
				up.remove(); // remove all files
				return false;
			});

			$('demo-upload').addEvent('click', function() {
				up.start(); // start upload
				return false;
			});
		},
		
		// Edit the following lines, it is your custom event handling
		
		/**
		 * Is called when files were not added, "files" is an array of invalid File classes.
		 * 
		 * This example creates a list of error elements directly in the file list, which
		 * hide on click.
		 */ 
		onSelectFail: function(files) {
			files.each(function(file) {
				new Element('li', {
					'class': 'validation-error',
					html: file.validationErrorMessage || file.validationError,
					title: MooTools.lang.get('FancyUpload', 'removeTitle'),
					events: {
						click: function() {
							this.destroy();
						}
					}
				}).inject(this.list, 'top');
			}, this);
		},
		
		/**
		 * This one was directly in FancyUpload2 before, the event makes it
		 * easier for you, to add your own response handling (you probably want
		 * to send something else than JSON or different items).
		 */
		onFileSuccess: function(file, response) {
			var json = new Hash(JSON.decode(response, true) || {});
			
			if (json.get('status') == '1') {
				 file.element.addClass('file-success');
				 file.info.set('html', '上傳OK: (' + json.get('width') + ' x ' + json.get('height') + 'px, <em>' + json.get('mime') + '</em>)');
				 getnfile(json.get('name')); 
			} else {
				 //file.element.addClass('file-failed');
				 //file.info.set('html', '<font color="red">有錯誤!!: ' + (json.get('error') ? (json.get('error') + ' #' + json.get('code')) : response));
			}
		},
		
		/**
		 * onFail is called when the Flash movie got bashed by some browser plugin
		 * like Adblock or Flashblock.
		 */
		onFail: function(error) {
			switch (error) {
				case 'hidden': // works after enabling the movie and clicking refresh
					alert('To enable the embedded uploader, unblock it in your browser and refresh (see Adblock).');
					break;
				case 'blocked': // This no *full* fail, it works after the user clicks the button
					alert('To enable the embedded uploader, enable the blocked Flash movie (see Flashblock).');
					break;
				case 'empty': // Oh oh, wrong path
					alert('A required file was not found, please be patient and we fix this.');
					break;
				case 'flash': // no flash 9+ :(
					alert('To enable the embedded uploader, install the latest Adobe Flash plugin.')
			}
		}
		
	});
	
});
		//]]>
	</script>

	<!-- See style.css -->
	<style type="text/css">
		/**
 * FancyUpload Showcase
 *
 * @license		MIT License
 * @author		Harald Kirschner <mail [at] digitarald [dot] de>
 * @copyright	Authors
 */

/* CSS vs. Adblock tabs */

body{
   background-color: #CCCCCC;
	 margin-left: 0px;
	 margin-top: 0px;
	 margin-bottom: 0px;
	 margin-right: 0px;
   font-family: Verdana,Arial, Helvetica, sans-serif;	
   font-size: 13px;
}
.swiff-uploader-box a {
	display: none !important;
}

a:link {
	color:#0063C6;	
	font-size: 13px;
}
a:visited {
	color:#0063C6;
	font-size: 13px;
}

/* .hover simulates the flash interactions */
a:hover, a.hover {
	color: red;
}


#demo-status {
	padding: 10px 15px;
	width: 550px;
	border: 1px solid #eee;
}

#demo-status .progress {
	background: url(assets/progress-bar/progress.gif) no-repeat;
	background-position: +50% 0;
	margin-right: 0.5em;
	vertical-align: middle;
}

#demo-status .progress-text {
	font-size: 0.9em;
	font-weight: bold;
}

#demo-list {
	list-style: none;
	width: 400px;
	margin: 0;
	
}

#demo-list li.validation-error {
	padding-left: 44px;
	display: block;
	clear: left;
	line-height: 40px;
	color: #8a1f11;
	cursor: pointer;
	border-bottom: 1px solid #fbc2c4;
	background: #fbe3e4 url(assets/failed.png) no-repeat 4px 4px;
}

#demo-list li.file {  
	border-bottom: 1px solid #eee;
	background: url(assets/file.png) no-repeat 4px 4px;
	overflow: auto;
}
#demo-list li.file.file-uploading {
	background-image: url(assets/uploading.png);
	background-color: #D9DDE9;
}
#demo-list li.file.file-success {
	background-image: url(assets/success.png);
}
#demo-list li.file.file-failed {
	background-image: url(assets/failed.png);
}

#demo-list li.file .file-name {
	font-size: 1em;
	margin-left: 40px;
	display: block;
	clear: left;
	line-height: 40px;
	height: 40px;
	font-weight: bold;
}
#demo-list li.file .file-size {
	font-size: 0.9em;
	line-height: 18px;
	float: right;
	margin-top: 2px;
	margin-right: 6px;
}
#demo-list li.file .file-info {
	display: block;
	margin-left: 44px;
	font-size: 0.9em;
	line-height: 20px;
	clear
}
#demo-list li.file .file-remove {
	clear: right;
	float: right;
	line-height: 18px;
	margin-right: 6px;
}	

#main-id {
  font-family: 新細明體,Verdana,Arial, Helvetica, sans-serif;	
	font-size: 15px;
	color: #213D46;
	border-bottom: 4px solid #B0B6B9;
	line-height: 28px;
	background: url(../images/icon4.gif) no-repeat;
	padding-left: 10px;
	padding-right: 10px;
	margin-top: 10px;
}
</style>
</head>
<body>
	<center>
	<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
      	<td align="left">
      	<div id="main-id">                
         <table width="98%" border="0" cellspacing="0" cellpadding="0">
              <tr class="main-id">
              	<td align="left"><?php echo '<b> ['.$fcasenm.'] </b> -- 圖片集上傳'?></td>
              	<td align="right" class="w12"><a href="javascript:go_back('<?php echo $ff_frm_action?>')">&lt;&lt; 回上頁</a></td>
              </tr>
         </table>        
        </div>
       </td> 
      </tr>              
  </table>
	<table border=0 width=60%>
		<tr>
			<td align=left>	
	<div class="container">		
		<!-- See index.html -->
		<div>
			<form action="server/script.php?ap=<?php echo $fapdata?>&z=<?php echo $str_rz?>" method="post" enctype="multipart/form-data" id="form-demo">
	       <fieldset id="demo-fallback">
	       	<legend></legend>		
	       	<label for="demo-photoupload">			
	       		<input type="file" name="Filedata" style="display:none"/>	       		
	       	</label>
	       </fieldset>         
	       <div id="demo-status" class="hide">
	       	<p>
	       		<a href="#" id="demo-browse">瀏覽選擇圖檔</a> |
	       		<a href="#" id="demo-clear">清除列表</a> |
	       		<a href="#" id="demo-upload">開始上傳</a>	       		
	       	</p>
	       	<div>
	       		<strong class="overall-title"></strong><br />
	       		<img src="assets/progress-bar/bar.gif" class="progress overall-progress" />
	       	</div>
	       	<div>
	       		<strong class="current-title"></strong><br />
	       		<img src="assets/progress-bar/bar.gif" class="progress current-progress" />
	       		<?php 
	       		  if ($strsz<>''){
	       		  	  echo '<font color="red">尺寸:'.$strsz.'</font>'; 
	       		  }
	       		?>
	       	</div>
	       	<div class="current-text"></div>
	       </div>
	       <ul id="demo-list"></ul>
    </form>
    <form name="preg" action="<?php echo $ff_frm_action?>" method="post">
    	    <input type="hidden" name="hxx_apcode" value="<?php echo $m_apcode ?>">
    	    <input type="hidden" name="hxx_nfile" value="xml">
    	    <input type="hidden" name="hxx_caseid" value="<?php echo $fcaseid ?>">
    	    <input type="hidden" name="hxx_casenm" value="<?php echo $fcasenm ?>">
    	    <input type="hidden" name="hxx_dkind" value="<?php echo $fdkind ?>">
    	    <input type="hidden" name="hxx_catid" value="<?php echo $strcat?>">
    	    
    	    <input type="hidden" name="hxx_mkind" value="<?php echo $m_kind ?>">    	        	        	        	    
    </form>	
	</div>
	</div>	
</td>
</tr>
</table>
</center>
</body>
</html>
<script language=javascript> 
	//document.getElementById("main-id").innerHTML = '<b>['+nowcasenm+']</b> 作品圖檔上傳'	
	
	var nnstrfile ='';
	function getnfile(nnf){
		  nnstrfile =nnstrfile+nnf+',';		  
  }
  
  function godone(){     	
  	document.preg.hxx_caseid.value =nowcaseid;
  	document.preg.hxx_casenm.value =nowcasenm;
  	alert('nnstrfile='+nnstrfile);
  	document.preg.hxx_nfile.value  =nnstrfile;  	
  	alert('nnstrfile='+nnstrfile);
  	//document.preg.submit();
  }
  
  function go_back(ndir){
  	document.preg.action=ndir;
  	document.preg.submit();
  }    
</script>