<?php
if (count($_POST)>0){
	 $fname  =htmlspecialchars($_POST['name'],ENT_QUOTES);	               
   $femail =htmlspecialchars($_POST['email'],ENT_QUOTES);   
   $fmsg   =htmlspecialchars($_POST['message'],ENT_QUOTES);   
   
   //include './cpsys/sysinc/m_func.php';
	
	 if ($fname=='' ||  $femail=='' ||  $fmsg==''){	 	  
	 	  exit();
	 }			 
	 
	 include '../cpsys/sysinc/dbConn.php';
	
	 $sqlx     ='select mailbox from `servmail` ';
   $rsm      =$s_mysqli->query($sqlx);
   $rsm_rows =mysqli_num_rows($rsm);  //筆數
   $fmail_to ='';
   if ($rsm_rows>0){
	    $rsm_c =mysqli_fetch_row($rsm);
	    $fmail_to=$rsm_c[0];
   }
   //---
    $htmbody ="<table width='90%' border=1 bordercolorlight='#CCCCCC' style='border-collapse: collapse' bordercolor='#CCCCCC'>".         
          "<tr>".
		       "<td width='25%' height=26 align='center'><font color='#333333'>姓  名</font></td>".
		       "<td width='75%' height=26 align='left'>".$fname."</td>".
	         "</tr>".	         
	         "<tr>".
		       "<td align='center'><font color='#333333'>E-mail</font></td>".
		       "<td align='left'>&nbsp;".$femail."</td>".
	         "</tr>".
	         "<tr>".
		       "<td align='center'><font color='#333333'>".$ff_fld_tit."留言內容</font></td>".
		       "<td align='left'><pre>".$fmsg."</pre></td>".
	         "</tr>".		         	      
	         "</table>";	         
	         
         //echo $htmbody;
         //exit();         
         //echo $fmail_to;
         //exit();  
         
          $mailer_sjt  ="訪客留言  | 真心蓮坊";
          $mailer_from ="真心蓮坊";   //寄出後,收件者顯示寄件者的名稱      
          $mailer_to   =$fmail_to;
          $mailer_body =$htmbody;   
          if ($ff_up_file<>''){
              $mailer_att =$ff_up_file_dir.$ff_up_file;       
          }
          else{
          	  $mailer_att ='';
          }    
          
          do_mail_send($mailer_sjt,$mailer_from,$mailer_to,$mailer_body,$mailer_att);
          
          //echo '<script>alert("謝謝您,我們將盡快處理");parent.$.fancybox.close();;</script>';
}	 	


function do_mail_send($nsj,$nfrom,$nto,$nbody,$nfile){
	$fsubject    =$nsj;
	$fmail_to    =$nto;	
	$mailer_from =$nfrom;
	$htmbody     =$nbody;			
	$ff_file     =$nfile;
	include("./mailer/mail_send.php");	
}	 	 
?>