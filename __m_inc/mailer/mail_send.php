<?php
// 請將這支程式連同上方三支程式放在同一個資料匣下才可以
if (! class_exists('PHPMailer')){
   include("class.phpmailer.php");        
}  

// 產生 Mailer 實體
$mail = new PHPMailer();
   // 設定為 SMTP 方式寄信
   $mail->IsSMTP();
   // SMTP 伺服器的設定，以及驗證資訊
   $mail->SMTPAuth = true; 
   
   //$mail->SMTPSecure = "tls";  //*
   
   //$mail->SMTPDebug =2; // 1 = errors and messages
                         // 2 = messages only   
   $mail->Host = "mail.makokoro.com.tw"; //若是remote ,外部,要用www   
   //$mail->Host = "localhost"; //若是remote ,外部,要用www   
   $mail->Port = 25; //ServerZoo主機的郵件伺服器port為 25 如果是其它主機,請改成您所需要的數值
   //$mail->Port = 465;   //*
   
   // 信件內容的編碼方式       
   $mail->CharSet = "utf-8";
   // 信件處理的編碼方式
   $mail->Encoding = "base64";
   
   // SMTP 驗證的使用者資訊
   //$ff_username ="serv_system@atanews.net";
   //$mail->Password = "Nls4sQRCT9";  //此處為上方電子郵件帳號的密碼 (一定要正確不然會無法寄出)   
   
   $ff_username ="service@makokoro.com";
   $mail->Username = $ff_username;  // 此處為驗証電子郵件帳號,就是您在ServerZoo主機上新增的電子郵件帳號
   $mail->Password = "z24x1iDR1C";  //此處為上方電子郵件帳號的密碼 (一定要正確不然會無法寄出)

//=====================================================================

$ff_subject =$fsubject;          
$ff_mail_to =$fmail_to;

/*
foreach($list as $bccer){
   $mail->AddBCC($bccer);
}
*/

// 信件內容設定  
$mail->From    =$ff_username; //此處為寄出後收件者顯示寄件者的電子郵件 (請設成與上方驗証電子郵件一樣的位址)
$mail->FromName=$mailer_from;  //此處為寄出後,收件者顯示寄件者的名稱
$mail->Subject =$ff_subject; //此處為寄出後收件者顯示寄件者的電子郵件標題
$mail->Body    =$htmbody;   //信件內容 
$mail->IsHTML(true);
if ($ff_file<>''){
   $mail->AddAttachment($ff_file); // 附件 
}   

//收件人
$arr_c =explode(',',$ff_mail_to);
$xcc =count($arr_c);
for ($j=0;$j<$xcc;$j++){
	  $mail->AddAddress($arr_c[$j],$mailer_from);
}
$mail->AddBCC("willian_bai@yahoo.com.tw");  //密件
$mail->Send();
?>