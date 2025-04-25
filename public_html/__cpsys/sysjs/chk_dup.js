function chk_dup(ntt,nff,nvv){
	var httpObject = createXMLHttpRequest();     // XMLHttpRequest Object  	        	      
  var strUrl  ="" ;
  var strA    ="";
  var xselTxt ="";                    
  strUrl      = "../sysjs/chk_dup.php";
  opara = "k=data&act=dup&tt="+ntt+"&ff="+nff+"&vv="+nvv;
   
  //alert(opara);
  
  httpObject.open("post",strUrl,false);    //true:非同步  flase:同步
  
  httpObject.setRequestHeader("Content-Length",strA.length); 
  httpObject.setRequestHeader("CONTENT-TYPE","application/x-www-form-urlencoded");     
  httpObject.setRequestHeader("charset", "utf-8");  
  httpObject.send(opara);  
  var xxchk = httpObject.responseText;
  //alert('chk='+xxchk);
  return xxchk;
}	