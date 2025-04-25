<?php 
function get_sex($nvv){   //
	  $strvv ='';
	  switch($nvv) {
	 	 case '0':
	 	     $strvv ='女士';
	 	     break;
	 	 case '1':
	 	     $strvv ='先生';
	 	     break;  	 	 
	 }		  
	 return($strvv);	 
}


function get_shipnm($nvv){   //
	  $strvv ='';
	  switch($nvv) {
	 	 case 'R':
	 	     $strvv ='常溫';
	 	     break;
	 	 case 'L':
	 	     $strvv ='低溫';
	 	     break;  
	 	 case 'F':
	 	     $strvv ='冷凍';
	 	     break;
	 	 case 'S':
	 	     $strvv ='超商取貨';
	 	     break;    
	 	 case 'O':
	 	     $strvv ='海外郵寄';
	 	     break;        
	 	 default:
	 	     $strvv ='常溫';
	 	     break;
	 }	  
	 return($strvv);
}


function get_island($nvv){   //國內.1.本島 2.外島
	 $xouter='澎湖,金門,連江';
	 $nnp =strpos($xouter,$nvv);
	 if ($nnp===false){
	 	   return '1';
	 }	
	 else{
	 	  return '2';
	 }
	 
}

function get_land($nvv){
	 $strvv ='';
	 if ($nvv=='1'){
	 	  $strvv ='本島';
	 }
	 else if ($nvv=='2'){
	 	  $strvv ='外島';
	 }	
	 return($strvv);
}


function get_ship_island($nvv){   //國內.1.本島 2.外島
	 $strvv ='';
	 if ($nvv=='1'){
	 	  $strvv ='本島';
	 }
	 else if ($nvv=='2'){
	 	  $strvv ='外島';
	 }
}


function getordersts($nvv){   //訂單狀況
	 $strvv ='';
	 switch($nvv) {
	 	 case '0':
	 	     $strvv ='處理中';
	 	     break;
	 	 case '2':
	 	     $strvv ='備貨中';
	 	     break;    
	 	 case '3':
	 	     $strvv ='已出貨';
	 	     break;  
	 	 case '4':
	 	     $strvv ='退貨';
	 	     break;      
	 	 case '8':
	 	     $strvv ='暫存單';
	 	     break;              
	 	 case '9':
	 	     $strvv ='廢單';
	 	     break;          
	 	 default;
	 	     $strvv ='處理中';
	 	     break;	 	           
	 }
	 return($strvv);
}


function sts_option(){
	$xxvv='';
	$xxvv .='<option value="0">處理中</option>	
	         <option value="3">已出貨</option>
	         <option value="4">退貨</option>
	         <option value="9" style="color:red">廢單</option>';
  return $xxvv;
}


function sts_option2(){
	$xxvv ='';
	$xxvv .='<option value="0">處理中</option>
	         <option value="2">備貨中</option>
	         <option value="3">已出貨</option>
	         <option value="4">退貨</option>
	         <option value="9">廢單</option>';
  return $xxvv;
}



function getpayway($nvv){    //付款方式
	$strvv ='';
	 switch($nvv) {
	 	 case '1':
	 	     $strvv ='店面現金';
	 	     break;
	 	 case '2':
	 	     $strvv ='ATM';
	 	     break;
	 	 case '3':
	 	     $strvv ='匯款';
	 	     break;
	 	 case '4':
	 	     $strvv ='貨到付款';
	 	     break;    
	 	case '5':
	 	     $strvv ='傳真刷卡';
	 	     break;         
	 	case '6':
	 	     $strvv ='iBon';
	 	     break;   
	 	case '7':
	 	     $strvv ='信用卡';
	 	     break;                 
	 	case '8':
	 	     $strvv ='超商取貨付款';   //只限常溫
	 	     break;
	 	case '9':
	 	     $strvv ='Paypal';
	 	     break;     
	 }
	 return($strvv);
}



function get_pickway($nvv){ 
	$strvv ='';
	 switch($nvv) {
	 	 case '1':
	 	     $strvv ='宅配';
	 	     break;
	 	 case '2':
	 	     $strvv ='自取';
	 	     break;	 	               
	 }
	 return($strvv);	
}	



function get_stpay($nvv){    //店面結帳狀況
	$strvv ='';
	 switch($nvv) {
	 	 case 'full':
	 	     $strvv ='已付清';
	 	     break;
	 	 case 'part':
	 	     $strvv ='訂金';
	 	     break;	 	               
	 }
	 return($strvv);
}


function getpaysts($nvv){    //付款狀況 0.未付 1.已付部份 2.已付清
	$strvv ='';
	 switch($nvv) {
	 	 case '0':
	 	     $strvv ='未付';
	 	     break;
	 	 case '1':
	 	     $strvv ='已付部份';
	 	     break;
	 	 case '2':
	 	     $strvv ='已付清';
	 	     break;
	 }
	 return($strvv);
}


function paysts_option(){
	$xxvv .='<option value="0">未付</option>
	         <option value="1">已付部份</option>
	         <option value="2">已付清</option>';	         
  return $xxvv;
}




function amt_option($nn){
	$xxvv ='';
	for($k=1;$k<=$nn;$k++){
	    $xxvv .='<option value="'.$k.'">'.$k.'</option>';	   
  }
  return $xxvv;
}


function get_inv_send($nv){
	$strvv ='';
	 switch ($nv){
	 	  case '1':
	 	    $strvv ='隨貨寄出';
	 	    break;
	 	  case '2':
	 	    $strvv ='另寄(同訂購資訊)';
	 	    break;  
	 	  case '3':
	 	    $strvv ='其他地址';
	 	    break;  
	 	  case '4':
	 	    $strvv ='捐贈創世基金會';
	 	    break;  	 	    
	 }
	return($strvv); 
}


function get_inv_typ($nv){
	  $strvv ='';
	  switch ($nv){
	 	  case '1':
	 	    $strvv ='電子三聯';
	 	    break;
	 	  case '2':
	 	    $strvv ='手寫二聯';
	 	    break;  
	 	  case '3':
	 	    $strvv ='手寫三聯';
	 	    break;  	 	   	 	    
	 }
	return($strvv); 
}


function get_pack_opt($nv){  //sys系統內定,opt.自選,none.環保
	 $strvv ='';
	  switch ($nv){
	 	  case 'sys':
	 	    $strvv ='系統內定';
	 	    break;
	 	  case 'opt':
	 	    $strvv ='自選';
	 	    break;  
	 	  case 'none':
	 	    $strvv ='響應環保,不附提袋';
	 	    break;  	 	   	 	    
	 }
	return($strvv); 
}


function get_tmpship($nr,$nl,$nf){   //運費字串(常低溫130元 冷凍130元)
 $strvv ='';
 $xvv =0;
 
 if (!($nr=='' & $nl=='0')){
 	  $strvv ='常低溫'.((int)$nr+(int)$nl).'元';
 	  $xvv =1;
 }
 else{
 	   if (!($nr=='' || $nr=='0')){
 	       $xvv +=1;
 	       $strvv ='常溫'.$nr.'元';
     } 
     if (!($nl=='' || $nl=='0')){
  	     $xvv +=1;
  	     $strvv ='低溫'.$nl.'元';
     }
 }  
 if (!($nf=='' || $nf=='0')){
 	  $strvv ='冷凍'.$nf.'元'; 
 } 
 
 if ($xvv <=1){
 	  $strvv ='';
 }
 return($strvv); 
}



function get_dosts($nv){   //提貨狀況
	$strvv ='';
	  switch ($nv){
	 	  case '0':
	 	    $strvv ='未提貨';
	 	    break;
	 	  case '1':
	 	    $strvv ='已提貨';
	 	    break; 
	 	     
	 	  default:
	 	     $strvv ='未提貨';
	 	     break;  	 	    	 	   	   	 	    
	 }
	return($strvv); 
}


function get_okind($nv){   //訂單來源 S:店面,T:電話,F傳真,W網站
	$strvv ='';
	  switch ($nv){
	 	  case 'S':
	 	    $strvv ='店面';
	 	    break;
	 	  case 'T':
	 	    $strvv ='電話';
	 	    break; 
	 	  case 'F':
	 	    $strvv ='傳真';
	 	    break; 
	 	  case 'W':
	 	    $strvv ='網站';
	 	    break;
	 }
 	return($strvv); 	
}


function get_shpsec_opt(){
	$arr_tr =explode(',','A,B,C,D');  //運費模式	
  return($arr_tr); 	
}

function get_shpsec($nv){
	$strvv ='';
	  switch ($nv){
	 	  case 'A':
	 	    $strvv ='中廚';
	 	    break;
	 	  case 'B':
	 	    $strvv ='巧克力';
	 	    break;  	 	   	   	 	    
	 	  case 'C':
	 	    $strvv ='冰淇淋';
	 	    break; 
	 	  case 'D':
	 	    $strvv ='預留';
	 	    break;     
	 }
	return($strvv); 		
}

function get_atm_bno(){   //日出企業代號 for ATM
	  return ('98466');
}
?>