<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);

/**
 * Swiff.Uploader Example Backend
 *
 * This file represents a simple logging, validation and output.
 *  *
 * WARNING: If you really copy these lines in your backend without
 * any modification, there is something seriously wrong! Drop me a line
 * and I can give you a good rate for fancy and customised installation.
 *
 * No showcase represents 100% an actual real world file handling,
 * you need to move and process the file in your own code!
 * Just like you would do it with other uploaded files, nothing
 * special.
 *
 * @license		MIT License
 *
 * @author		Harald Kirschner <mail [at] digitarald [dot] de>
 * @copyright	Authors
 *
 */


/**
 * Only needed if you have a logged in user, see option appendCookieData,
 * which adds session id and other available cookies to the sent data.
 *
 * session_id($_POST['SID']); // whatever your session name is, adapt that!
 * session_start();
 */

// Request log

/**
 * You don't need to log, this is just for the showcase. Better remove
 * those lines for production since the log contains detailed file
 * information.
 */
 

$result = array();

$result['time'] = date('r');
$result['addr'] = substr_replace(gethostbyaddr($_SERVER['REMOTE_ADDR']), '******', 0, 6);
$result['agent'] = $_SERVER['HTTP_USER_AGENT'];

if (count($_GET)) {
	$result['get'] = $_GET;
}
if (count($_POST)) {
	$result['post'] = $_POST;
}
if (count($_FILES)) {
	$result['files'] = $_FILES;
}

//echo $_GET['m'];

// we kill an old file to keep the size small

/*--
if (file_exists('script.log') && filesize('script.log') > 102400) {
	unlink('script.log');
}

$log = @fopen('script.log', 'a');
if ($log) {
	fputs($log, print_r($result, true) . "\n---\n");
	fclose($log);
}
*/


// Validation

$error = false;

if (!isset($_FILES['Filedata']) || !is_uploaded_file($_FILES['Filedata']['tmp_name'])) {
	$error = 'Invalid Upload';
}

$strfilenm ='';



/**
 * You would add more validation, checking image type or user rights.
 *

if (!$error && $_FILES['Filedata']['size'] > 2 * 1024 * 1024)
{
	$error = 'Please upload only files smaller than 2Mb!';
}

if (!$error && !($size = @getimagesize($_FILES['Filedata']['tmp_name']) ) )
{
	$error = 'Please upload only images, no other files are supported.';
}

if (!$error && !in_array($size[2], array(1, 2, 3, 7, 8) ) )
{
	$error = 'Please upload only images of type JPEG, GIF or PNG.';
}

if (!$error && ($size[0] < 25) || ($size[1] < 25))
{
	$error = 'Please upload an image bigger than 25px.';
}
*/


// Processing

/**
 * Its a demo, you would move or process the file like:
 */
 
  
  
/*
 * or
 *
 * $return['link'] = YourImageLibrary::createThumbnail($_FILES['Filedata']['tmp_name']);
 *
 */

if ($error) {

	$return = array(
		'status' => '0',
		'error' => $error
	);

} else {	
	$ffcid   =$_GET['cid'];
	$ffdkind =$_GET['d'];
	
	include '../../sysinc/dbConn.php';
	
	$fntable='';
	$fnnm ='';
	if ($ffdkind=='3'){	
	   $fntable ='wk_gallery';
	   $fnnm ='3d';	   
	}
	else{
		 $fntable ='wk_gallery'; 
		 $fnnm ='wk';
		 //$result  =mysql_query("show table status like 'wk_gallery'");
  }   
  
  $result =mysql_query("show table status like '".$fntable."'");
  
  $ncid   =mysql_result($result, 0, 'Auto_increment');
	
  $extarry  =explode(".", $_FILES['Filedata']['name']);               	 	  
  $file_ext =$extarry[count($extarry)-1];      
  $fphoto   =$fnnm.$ncid.date("ymd").'.'.$file_ext;  //wk12110301.jpg	
 
	$return = array(
		'status' => '1',
		'name' => $fphoto
	);

	// Our processing, we get a hash value from the file
	$return['hash'] = md5_file($_FILES['Filedata']['tmp_name']);

	// ... and if available, we get image data
	$info = @getimagesize($_FILES['Filedata']['tmp_name']);

	if ($info) {
		$return['width']  =$info[0];
		$return['height'] =$info[1];
		$return['mime']   =$info['mime'];
	}				
	
	
	
	$ftofold ='../../../doc_files/';
	
	$fphoto =strtolower($fphoto);
	
	move_uploaded_file($_FILES['Filedata']['tmp_name'],$ftofold.$fphoto);		
	
	//$ffcid
	$sqlx ='select sno from wk_gallery where caseid='.$ffcid.' order by sno desc limit 0,1 ';
	$rst   =mysql_query($sqlx,$s_link);
   //$rsm_rows =mysql_num_rows($rsm);  //µ§¼Æ
  $nnsno ='';
  if ($rst){
     $rst_c =mysql_fetch_row($rst);      
     $nnsno =$rst_c[0]+1;
  }   
  else{
   	  $nnsno =1;
  }
	
	$sqlx ="insert into ".$fntable."(caseid,photo,display,sno) ".
	       "values(".$ffcid.",'".$fphoto."','N',".$nnsno.")"; 
  mysql_query($sqlx,$s_link) or die('sql¿ù»~!: '.$sqlx.'<br/>' . mysql_error()).'<br/>';
}


// Output

/**
 * Again, a demo case. We can switch here, for different showcases
 * between different formats. You can also return plain data, like an URL
 * or whatever you want.
 *
 * The Content-type headers are uncommented, since Flash doesn't care for them
 * anyway. This way also the IFrame-based uploader sees the content.
 */

if (isset($_REQUEST['response']) && $_REQUEST['response'] == 'xml') {
	// header('Content-type: text/xml');

	// Really dirty, use DOM and CDATA section!
	echo '<response>';
	foreach ($return as $key => $value) {
		echo "<$key><![CDATA[$value]]></$key>";
	}
	echo '</response>';
} else {
	// header('Content-type: application/json');

	echo json_encode($return);	
}
?>