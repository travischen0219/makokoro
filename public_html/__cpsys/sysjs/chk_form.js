var oform = document.reg;		

function gochk_mem(){   //會員
	  var errMsg = "";	  
	  var xmail,xtel,xcell 
	  if (oform.tfx_cuname.value.match(/[^\n^\s]/)==null){
        errMsg +="[會員名稱]\n " ;
    }      
    
    if (!(oform.rfx_sex[0].checked || oform.rfx_sex[1].checked)){
    	  errMsg +="[性別]\n " ;
    }       
    
    if (!(oform.tfx_email.value.match(/[^\n^\s]/)==null)){
    	  if (!(isEmail(oform.tfx_email)) ){
    	  	 errMsg +="[E-mail格式錯誤]\n " ;
    	  }
    	  else{
    	  	  xmail =oform.tfx_email.value;
    	  }
    }    
    var xxctry ='';
    if (oform.sxx_city.value==''){
        errMsg +="[縣市]\n " ;
    }   
    else{            	 
    	  oform.tfx_city.value=oform.sxx_city.value;
    }         
    if (oform.subtype.value==''){
     	 errMsg +="[區域]\n " ;
    }
    
    if (oform.tfx_address.value.match(/[^\n^\s]/)==null){
     	 errMsg +="[住址]\n " ;
    }   
    else{
    	 oform.tfx_address.value =oform.tfx_address.value;
    }               
    
    if (oform.tfx_tel.value=='' && oform.tfx_cell.value==''){
    	  errMsg +="[至少輸入一支聯絡電話]\n"
    }      
    else{     	    	         	  
        
        if (!(isTel(oform.tfx_tel)) ){
           errMsg +="[室內電話]格式錯誤\n";
        } 
        else{
        	 xtel =oform.tfx_tel.value;
        }  
        
        if (!(isCell(oform.tfx_cell))){
           errMsg +="[行動電話]格式錯誤\n";
        }         
        else{
        	 xcell  =oform.tfx_cell.value;
        }
    }          
    
    if (errMsg !="") { 
       alert ('請檢查欄位:\n'+errMsg);         
    } 
    else{   
    	  //check if duplicat... email, tel,cell
    	 document.getElementById("btnsure").disabled=true;
    	 var xxid =oform.pxx_id.value;
    	 var nnv = chk_memdup(xmail,xtel,xcell,xxid,'dup');  
    	    	 
    	 //document.reg.tfx_note.value=nnv;
    	 if (nnv !=='f'){ 
    	 	   alert(nnv+' 已經登錄過囉!');
    	 	   document.getElementById("btnsure").disabled=false;
    	 }
    	 else{
    	 	
    	 	   if (oform.hxx_editmode.value=='ADD'){
    	 	   	  if (oform.tfx_acc.value !==''){    	 	   	  	 
    	 	   	      var nlen =oform.tfx_acc.value.length;    	 	   	      
                  if (!(nlen>=4 &nlen<=15)){
                  	  errMsg ="[帳號長度4~15] \n" ;
                  }
                  else{
                  	   xxchk =acc_dup('acc');              	   
                  	   if (xxchk=='t'){
                  	   	   errMsg ="[帳號重覆註冊囉] \n" ;
                  	   	   oform.tfx_acc.value ='';
                  	   }
                  }
              }
              else{
              	  oform.tfx_acc.value =oform.tfx_email.value;
              	  //alert(oform.tfx_acc.value);
              }
    	 	   }
    	 	   else{
    	 	   	  oform.hfx_acc.value =oform.tfx_email.value;
    	 	   }
    	 	   
    	 	   if (errMsg !==''){
    	 	   	   alert(errMsg);
    	 	   	   document.getElementById("btnsure").disabled =false;
      	 	 }
      	 	 else{    	 	    	 	        	 	       
               oform.submit();
           }     
    	 }
    }		 
}


function acc_dup(nk){   //check duplicate or not
	var nval='';	
	nval =oform.tfx_acc.value;
			    
	if (nval==''){
		  return false;
  }
  else{  	    
  	     var httpObject =createXMLHttpRequest();     // XMLHttpRequest Object  	        	      
         var strUrl  ="" ;
         var strA    ="";
         var xselTxt ="";                    
         strUrl      = "../../js_f/chk_dupacc.php";
         opara = "v=" + nval+'&k='+nk;
         //alert(opara);
         
         httpObject.open("post",strUrl,false);    //true:非同步  flase:同步
         
         httpObject.setRequestHeader("Content-Length",strA.length); 
         httpObject.setRequestHeader("CONTENT-TYPE","application/x-www-form-urlencoded");     
         httpObject.setRequestHeader("charset", "utf-8");                   
         
         httpObject.send(opara);         
         var xxchk = httpObject.responseText;         
         return (xxchk);         
  }	
}





function chk_memdup(nv1,nv2,nv3,nv4,nact){
	var httpObject = createXMLHttpRequest();     // XMLHttpRequest Object  	        	      
  var strUrl  ="" ;
  var strA    ="";
  var xselTxt ="";                    
  strUrl      = "../sysjs/chk_dup.php";
  opara = "k=mem&act="+nact+"&mail=" + nv1 + "&tel=" + nv2 + "&cell=" + nv3+ "&nd=" + nv4;
   
 //alert(opara);
  
  httpObject.open("post",strUrl,false);    //true:非同步  flase:同步
  
  httpObject.setRequestHeader("Content-Length",strA.length); 
  httpObject.setRequestHeader("CONTENT-TYPE","application/x-www-form-urlencoded");     
  httpObject.setRequestHeader("charset", "utf-8");  
  httpObject.send(opara);  
  var xxchk = httpObject.responseText;
  //alert('t2='+xxchk);
  return xxchk;
}	