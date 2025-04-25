<?php 
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>::<?php echo $s_title?>::</title>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-color: #E7EFF1;
}
.w13 {
	font-family:"Apple LiGothic Medium","微軟正黑體","Microsoft JhengHei",Arial,Helvetica,sans-serif;
	color: #FFFFFF;
	font-size: 0.875em;
}
#table {
	padding-top: 70px;
	padding-right: 20px;
	padding-bottom: 20px;
	padding-left: 40px;
}
-->
</style>
<?php   
    if ($sys_pass=='err'){
  	   echo '<script>alert("帳號密碼有誤!,請重新輸入..");</script>';
    }
 ?>
</head>
<body>
<table width="100%" height="95%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center"><table width="422" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="280" align="center" background="images/login.jpg"><p>&nbsp;</p>
          <form name="reg1" method="post" action="./?ng=login">
            <p>&nbsp;</p>
            <div id="table">
              <table width="300" border="0" cellspacing="4" cellpadding="0">
                <tr>
                  <td width="50" align="right" class="w13" nowrap>帳號／</td>
                  <td><label>
                  	<input type="text" name="tfx_acc" id="tfx_acc">
                  	</label></td>
                  <td rowspan="2"><img src="images/login.png" border="0" style="cursor:pointer;" onclick="javascript:chkget();"></td>
                </tr>
                <tr>
                  <td align="right" class="w13" nowrap>密碼／</td>
                  <td><label><input type="password" name="tfx_pwd" id="tfx_pwd"></label></td>
                </tr>
              </table>
            </div><br>
           </form>
        </td>
      </tr>
    </table>
    <p>&nbsp;</p></td>
  </tr>
</table>
</body>
</html>
<script language=javascript>	
	function chkget(){
		 var doc=document.reg1;
		 if (doc.tfx_acc.value=='' || doc.tfx_pwd.value=='' ){
		 	   alert("請輸入帳號及密碼");
		 }	
		 else{
		 	  doc.submit();
		 }	 
  }
</script>