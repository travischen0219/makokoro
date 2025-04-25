<?php
/**
 The MIT License

 Copyright (c) 2007 <Tsung-Hao>

 Permission is hereby granted, free of charge, to any person obtaining a copy
 of this software and associated documentation files (the "Software"), to deal
 in the Software without restriction, including without limitation the rights
 to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 copies of the Software, and to permit persons to whom the Software is
 furnished to do so, subject to the following conditions:

 The above copyright notice and this permission notice shall be included in
 all copies or substantial portions of the Software.

 THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 THE SOFTWARE.
 *
 * 抓取要縮圖的比例, 下述只處理 jpeg
 * $from_filename : 來源路徑, 檔名, ex: /tmp/xxx.jpg
 * $save_filename : 縮圖完要存的路徑, 檔名, ex: /tmp/ooo.jpg
 * $in_width : 縮圖預定寬度
 * $in_height: 縮圖預定高度
 * $quality  : 縮圖品質(1~100)
 *
 * Usage:
 *   ImageResize('ram/xxx.jpg', 'ram/ooo.jpg');
 */
function ImageResize($from_filename, $save_filename, $in_width, $in_height, $quality=100)
{
    $allow_format = array('jpeg', 'png', 'gif');
    $sub_name = $t = '';

    // Get new dimensions
    $img_info = getimagesize($from_filename);
    $width    = $img_info['0'];
    $height   = $img_info['1'];
    $imgtype  = $img_info['2'];
    $imgtag   = $img_info['3'];
    $bits     = $img_info['bits'];
    $channels = $img_info['channels'];
    $mime     = $img_info['mime'];

    list($t, $sub_name) = explode('/', $mime);
    if ($sub_name == 'jpg') {
        $sub_name = 'jpeg';
    }

    if (!in_array($sub_name, $allow_format)) {
        return false;
    }

    // 取得縮在此範圍內的比例
    $percent = getResizePercent($width, $height, $in_width, $in_height);
    $new_width  = $width * $percent;
    $new_height = $height * $percent;

    // Resample
    $image_new = imagecreatetruecolor($new_width, $new_height);

    // $function_name: set function name
    //   => imagecreatefromjpeg, imagecreatefrompng, imagecreatefromgif
    /*
    // $sub_name = jpeg, png, gif
    $function_name = 'imagecreatefrom'.$sub_name;
    $image = $function_name($filename); //$image = imagecreatefromjpeg($filename);
    */
    switch ($imgtype) {
      case 1: $image = imagecreatefromgif($from_filename); break;
      case 2: $image = imagecreatefromjpeg($from_filename);  break;
      case 3: $image = imagecreatefrompng($from_filename); break;    
    }      
    imagecopyresampled($image_new, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);  
    
    //$image = imagecreatefromjpeg($from_filename);
    //imagecopyresampled($image_new, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
    
    switch ($imgtype) {
      case 1: return imagegif($image_new, $save_filename); break;
      case 2: return imagejpeg($image_new, $save_filename, $quality);break;
      case 3: return imagepng($image_new, $save_filename); break;     
    }      

    //return imagejpeg($image_new, $save_filename, $quality);
}

/**
 * 抓取要縮圖的比例
 * $source_w : 來源圖片寬度
 * $source_h : 來源圖片高度
 * $inside_w : 縮圖預定寬度
 * $inside_h : 縮圖預定高度
 *
 * Test:
 *   $v = (getResizePercent(1024, 768, 400, 300));
 *   echo 1024 * $v . "\n";
 *   echo  768 * $v . "\n";
 */
function getResizePercent($source_w, $source_h, $inside_w, $inside_h)
{
    if ($source_w < $inside_w && $source_h < $inside_h) {
        return 1; // Percent = 1, 如果都比預計縮圖的小就不用縮
    }

    $w_percent = $inside_w / $source_w;
    $h_percent = $inside_h / $source_h;

    return ($w_percent > $h_percent) ? $h_percent : $w_percent;
}


//------切成正方形
function imgcut_square($src_to,$src_from, $to_width, $to_height){
	
	$src = imagecreatefromjpeg($src_from);	
	
  // 取得圖片的寬
  $src_w = imagesx($src );
  // 取得圖片的長
  $src_h = imagesy($src );
  // 取得圖片的副檔名 ( 如 jpg, gif... )
  $src_type = strtolower(getFiletype($src_from));
  
  // 依長與寬兩者最短的邊來算出要抓的正方形邊長
  if( $src_w > $src_h){
    $new_w = $src_h;
    $new_h = $src_h;
  }else{
    $new_w = $src_w;
    $new_h = $src_w;
  }    
  
  // 以長方形的中心來取得正方形的左上方原點           
  $srt_w = ( $src_w - $new_w ) / 2;
  $srt_h = ( $src_h - $new_h ) / 2;
  
  // 定義一個圖形 ( 針對正方形圖形 )                        
	$newpc = imagecreatetruecolor($new_w,$new_h);   
	
	// 抓取正方形的截圖                                                    
	imagecopy($newpc, $src, 0, 0, $srt_w, $srt_h, $new_w, $new_h );
	
	// 建立縮圖                               
	$finpic = imagecreatetruecolor($to_width, $to_height);
	
	// 開始縮圖
  imagecopyresampled($finpic, $newpc, 0, 0, 0, 0,$to_width,$to_height, $new_w, $new_h);
  
  //save to path
  imagejpeg($finpic, $src_to);
}

function getFiletype ($nnm) {
  $num=strrpos($nnm,"."); 
  return ".".substr($nnm,$num+1);
}




function resize_image($filename,$ntofile,$frame_width,$frame_height){
    $pos   =strrpos($filename, ".");
    $first =substr($filename, 0, $pos);            
    $ext   =strtolower(substr($filename, $pos+1));

    //$resized_filename = $first."_".$frame_width."_".$frame_height.".".$ext;
    $resized_filename =$ntofile;
        
    //if (!file_exists($resized_filename)){
          if ($frame_width == 0){
            $frame_width = 1000000;
          }
          if ($frame_height == 0){
            $frame_height = 1000000;
          }

          $imginfo = getimagesize($filename);  //[0]:width ,[1]:height, [2]:type(1=GIF，2 = JPG，3= PNG)
          switch ($imginfo[2]) {
           case 1: $image = imagecreatefromgif($filename); break;
           case 2: $image = imagecreatefromjpeg($filename);  break;
           case 3: $image = imagecreatefrompng($filename); break;
           default:  trigger_error('Unsupported filetype!', E_USER_WARNING);  break;
          }

           //if ($imginfo[0] > $frame_width || $imginfo[1] > $frame_height){
            
            if ($frame_width == $frame_height){   //正方形
            	  // exit();            	  
            	  $ratio = $frame_height / $imginfo[1];
                $new_width = round($imginfo[0]*$ratio);            	
            	  // 取得圖片的寬
                $src_w = $imginfo[0];
                // 取得圖片的高
                $src_h = $imginfo[1];
                // 依長與寬兩者最短的邊來算出要抓的正方形邊長
                if( $src_w > $src_h){
                  $new_w = $src_h;
                  $new_h = $src_h;
                }else{
                  $new_w = $src_w;
                  $new_h = $src_w;
                }            	
            	  // 以長方形的中心來取得正方形的左上方原點
                $srt_w = ( $src_w - $new_w ) / 2;
                $srt_h = ( $src_h - $new_h ) / 2;
                
                // 定義一個圖形 ( 針對正方形圖形 )                        
	              $tnimage = imagecreatetruecolor($new_w,$new_h);
	              if ($imginfo[2] == 1 || $imginfo[2] == 3){  //(1=GIF，2 = JPG，3= PNG)
                   imagealphablending($tnimage, false);
                   imagesavealpha($tnimage,true);
                   $transparent = imagecolorallocatealpha($tnimage, 255, 255, 255, 127);
                   imagefilledrectangle($tnimage, 0, 0, $frame_width, $frame_height, $transparent);
                   //imagefilledrectangle($tnimage, 0, 0, $new_width, $frame_height, $transparent);
                } 	
                
	              // 抓取正方形的截圖                                                    
	              imagecopy($tnimage,$image, 0, 0, $srt_w, $srt_h, $new_w, $new_h );	 	              	                            	              
	                           
	              // 建立縮圖                               
	              $finpic = imagecreatetruecolor($frame_width,$frame_height);	              
	              if ($imginfo[2] == 1 || $imginfo[2] == 3){  //(1=GIF，2 = JPG，3= PNG)
                   imagealphablending($finpic , false);
                   imagesavealpha($finpic ,true);
                   $transparent = imagecolorallocatealpha($finpic , 255, 255, 255, 127);
                   imagefilledrectangle($finpic , 0, 0, $frame_width, $frame_height, $transparent);
                   //imagefilledrectangle($tnimage, 0, 0, $new_width, $frame_height, $transparent);
                } 		              	              	              
	              
	              // 開始縮圖
                imagecopyresampled($finpic, $tnimage, 0, 0, 0, 0,$frame_width,$frame_height, $new_w, $new_h);
                switch ($imginfo[2]) {
                  case 1: imagegif($finpic,$resized_filename); break;
                  case 2: imagejpeg($finpic,$resized_filename,90);  break;
                  case 3: imagepng($finpic,$resized_filename); break;
                  default:  trigger_error('Failed resize image!', E_USER_WARNING);  break;
               }
                	                      	
            }             
            else if ($imginfo[0]*$frame_height > $imginfo[1]*$frame_width){
                $ratio = $frame_width / $imginfo[0];
                $new_height = round($imginfo[1] * $ratio);

                $tnimage =imagecreatetruecolor($frame_width, $new_height);
                if ($imginfo[2] == 1 || $imginfo[2] == 3){
                  imagealphablending($tnimage, false);
                  imagesavealpha($tnimage,true);
                  $transparent = imagecolorallocatealpha($tnimage, 255, 255, 255, 127);
                  imagefilledrectangle($tnimage, 0, 0, $frame_width, $new_height, $transparent);
                }
                imagecopyresampled($tnimage, $image, 0,0,0,0, $frame_width, $new_height, $imginfo[0], $imginfo[1]);
                switch ($imginfo[2]) {
                  case 1: imagegif($tnimage,$resized_filename); break;
                  case 2: imagejpeg($tnimage,$resized_filename,90);  break;
                  case 3: imagepng($tnimage,$resized_filename); break;
                  default:  trigger_error('Failed resize image!', E_USER_WARNING);  break;
               }
                
            }         
            else {
                $ratio = $frame_height / $imginfo[1];
                $new_width = round($imginfo[0] * $ratio);

                $tnimage = imagecreatetruecolor($new_width, $frame_height);
                if ($imginfo[2] == 1 || $imginfo[2] == 3){
                  imagealphablending($tnimage, false);
                  imagesavealpha($tnimage,true);
                  $transparent = imagecolorallocatealpha($tnimage, 255, 255, 255, 127);
                  imagefilledrectangle($tnimage, 0, 0, $new_width, $frame_height, $transparent);
                }
                imagecopyresampled($tnimage, $image, 0,0,0,0, $new_width, $frame_height, $imginfo[0], $imginfo[1]); 
                
                switch ($imginfo[2]) {
                  case 1: imagegif($tnimage,$resized_filename); break;
                  case 2: imagejpeg($tnimage,$resized_filename,90);  break;
                  case 3: imagepng($tnimage,$resized_filename); break;
                  default:  trigger_error('Failed resize image!', E_USER_WARNING);  break;
               }
            }

            
        //} else {
        //    copy($filename, $resized_filename);
        //}
    //}
    return $resized_filename;
}





//高精度的縮圖類別
/***************************************/
/*功 能：利用PHP的GD函式生成高質量縮圖*/
/*運行環境:PHP5.01/GD2*/
/*類別說明：
可以選擇是/否裁圖，是/否放大圖像。
如果裁圖則生成的圖的尺寸與您輸入的一樣。
原則：盡可能保持原圖完整

如果不裁圖，則按照原圖比例生成新圖
原則：根據比例以輸入的長或者寬為基準

如果不放大圖像，則當原圖尺寸不大於新圖尺寸時，維持原圖尺寸
*/

/*參數說明：
$imgout:輸出圖片的位址
$imgsrc:來源圖片位址
$width: 新圖的寬度
$height:新圖的高度
$cut:是否裁圖，1為是，0為否
$enlarge:是否放大圖像，1為是，0為否*/

/*使用方式: resizeimage($imgout, $imgsrc, $width, $height,$cut,$enlarge)*/  
/***************************************/
class resizeimage
{
//圖片類型
var $type;
//實際寬度
var $width;
//實際高度
var $height;
//改變後的寬度
var $resize_width;
//改變後的高度
var $resize_height;
//是否裁圖
var $cut;
//是否放大圖像
var $enlarge;
//來源圖檔
var $srcimg;
//目標圖檔位址
var $dstimg;
//臨時建立的圖檔
var $im;
//回傳狀態
var $status;

function resizeimage($imgout,$imgsrc,$width,$height,$cut,$enlarge)
{
//目標圖檔位址
$this->dstimg = $imgout;
//來源圖檔
$this->srcimg = $imgsrc;
//改變後的寬度
$this->resize_width = $width;
//改變後的高度
$this->resize_height = $height;
//是否裁圖
$this->cut = $cut;
//是否放大圖像
$this->enlarge = $enlarge;
//初始化圖檔
$this->initi_img();
//來源圖檔實際寬度
$this->width = imagesx($this->im);
//來源圖檔實際高度
$this->height = imagesy($this->im);
//生成新圖檔
$this->newimg();
//結束圖形
ImageDestroy ($this->im);
}
function newimg()
{
if(($this->cut)=="1")
//裁圖
{
if($this->enlarge=='0')//不放大圖像，只縮圖
{
//調整輸出的圖片大小，如不超過指定的大小則維持原大小
if($this->resize_width < $this->width)
$resize_width = $this->resize_width;
else
$resize_width = $this->width;

if($this->resize_height < $this->height)
$resize_height = $this->resize_height;
else
$resize_height = $this->height;
}
else//放大圖像
{
$resize_width = $this->resize_width;
$resize_height = $this->resize_height;
}

//改變後的圖檔的比例
$resize_ratio = ($this->resize_width)/($this->resize_height);
//實際圖檔的比例
$ratio = ($this->width)/($this->height);

if($ratio>=$resize_ratio)
//高度優先
{
$newimg = imagecreatetruecolor($resize_width,$resize_height);
//生成白色背景
$white = imagecolorallocate($newimg, 255, 255, 255);
imagefilledrectangle($newimg,0,0,$resize_width,$resize_height,$white);
imagecopyresampled($newimg, $this->im, 0, 0, 0, 0, $resize_width,$resize_height, (($this->height)*$resize_ratio), $this->height);
$this->status = ImageJpeg ($newimg,$this->dstimg);
}
if($ratio<$resize_ratio)
//寬度優先
{
$newimg = imagecreatetruecolor($resize_width,$resize_height);
//生成白色背景
$white = imagecolorallocate($newimg, 255, 255, 255);
imagefilledrectangle($newimg,0,0,$resize_width,$resize_height,$white);
imagecopyresampled($newimg, $this->im, 0, 0, 0, 0, $resize_width, $resize_height, $this->width, (($this->width)/$resize_ratio));
$this->status = ImageJpeg ($newimg,$this->dstimg);
}
}
else
//不裁圖
{
if($this->enlarge=='0')//不放大圖像，只縮圖
{
//調整輸出的圖片大小，如不超過指定的大小則維持原大小
if($this->resize_width < $this->width)
$resize_width = $this->resize_width;
else
$resize_width = $this->width;

if($this->resize_height < $this->height)
$resize_height = $this->resize_height;
else
$resize_height = $this->height;
}
else//放大圖像
{
$resize_width = $this->resize_width;
$resize_height = $this->resize_height;
}

//改變後的圖檔的比例
$resize_ratio = ($this->resize_width)/($this->resize_height);
//實際圖檔的比例
$ratio = ($this->width)/($this->height);

if($this->width>=$this->height) //圖片較寬
{
$newimg = imagecreatetruecolor($resize_width,($resize_height)/$ratio);
//生成白色背景
$white = imagecolorallocate($newimg, 255, 255, 255);
imagefilledrectangle($newimg,0,0,$resize_width,($resize_width)/$ratio,$white);
imagecopyresampled($newimg, $this->im, 0, 0, 0, 0, $resize_width, ($resize_width)/$ratio, $this->width, $this->height);
$this->status = ImageJpeg ($newimg,$this->dstimg);
}
if($this->width<$this->height) //圖片較高
{
$newimg = imagecreatetruecolor(($resize_height)*$ratio,$resize_height);
//生成白色背景
$white = imagecolorallocate($newimg, 255, 255, 255);
imagefilledrectangle($newimg,0,0,($resize_height)*$ratio,$resize_height,$white);
imagecopyresampled($newimg, $this->im, 0, 0, 0, 0, ($resize_height)*$ratio, $resize_height, $this->width, $this->height);
$this->status = ImageJpeg ($newimg,$this->dstimg);
}
}
}
//初始化圖檔
function initi_img()
{
//取得圖片的類型
$getimgdata=@getimagesize($this->srcimg);
$this->type = $getimgdata['mime'];

//根據類型選擇讀取方式
if($this->type=='image/gif')
{
$this->im = imagecreatefromgif($this->srcimg);
}
else if($this->type=='image/png')
{
$this->im = imagecreatefrompng($this->srcimg);
}
else if($this->type=='image/x-ms-bmp')
{
$this->im = imagecreatefromwbmp($this->srcimg);
}
else
{
$this->im = imagecreatefromjpeg($this->srcimg);
}
}
}
?>