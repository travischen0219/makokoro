	var oform   =document.reg;
	var oform1  =document.reg1;
	var chkcount=0;	

	
	function chkthis(othis){
		
		 if (othis.checked==true){
		 	  chkcount=chkcount+1;
		 }
		 else{
		 	  chkcount=chkcount-1;
		 }
  }	
		
	
	function chk_all(ofrm,nnthis){	 	    
	 	    //var nchkSts = document.getElementById("chkAll").value	 	    	 	    
	 	    var nchkvalue = nnthis.value;
	 	    	 	    
	 	    var nnchk;
	 	    var nnchkCnt =0;
	 	    
	 	    if (nnthis.checked){
	 	    	 nnchk = true;
	 	    	 nnchkCnt = 1;	 	    	 
	 	    }
	 	    else{
	 	    	 nnchk = false;
	 	    	 nnchkCnt = -1;	 	    	 
	 	    }	 
	 	    
	 	   chkcount=0;
	 	   var objForm =document.forms[ofrm];
       var objLen  =objForm.length;
       for (var iCount = 0; iCount < objLen; iCount++)
       {
          if (objForm.elements[iCount].type == "checkbox")
          {
          	 if (objForm.elements[iCount].id !=='chkall'){
                objForm.elements[iCount].checked =nnchk;
                chkcount = chkcount+nnchkCnt; 
             } 
              //alert (chkcount);    
          }
           
       }	 	    
        
       if (chkcount<0){
        	 chkcount=0;
       }                  	 	    
   } 	
	
	
	function chk_del(nap){            
      if (chkcount==0){
         alert ("請先勾選想要刪除的項目!!");
      }   
      else{         
         var xdel =confirm("是否確定刪除這 "+chkcount+ " 筆資料?") 
         if (xdel)
         {         	  
            do_del(nap);
         }
      }             
  } 		
	
	   
   
  function do_del(nap){       
     oform.action =nap+'.php';
     oform.submit();          
  } 
  
    
  
  function godel(nfrm,nni,nap){ 
  	chk_all(nfrm,false);
  	document.getElementById("chkall").checked=false;
  	var nthischk = 'chkDel'+nni;
  	document.getElementById(nthischk).checked =true;
  	chkcount =1;  	
  	chk_del(nap);
  }    
  
  
  
  function goedit(nap,neid){
  	 oform.pxx_id.value =neid;  	 
     oform.action =nap+'.php';
     oform.submit();
  }
  
  
 function gopage(xpage){      
     oform1.hxx_nowpage.value=xpage;
     oform1.submit();
 }   
 
 function gopage2(xpage){
     oform.hxx_nowpage.value=xpage;
     oform.submit();
 }   
 
 
 function gosts(nap,xrun){
 	 if (chkcount==0){
      alert ("請先勾選想變更的項目!!");
   }   
   else{      
      //alert(nap);
      oform.hxx_sts.value=xrun;
      oform.action =nap+'.php';
      oform.submit();
   }  	 	
 } 
 
 function gosort(nid,ndir){
  	var nrec =document.getElementById("hxx_rec").value;
  	var nfld =document.getElementById("hxx_td").value;
  	var nnp;  	
  	for(i=1;i<=nfld;i++){
  		 eval('var nnh'+i);
    }	
  	var nee=0;
  	var nng ='';
  	if (ndir=='u'){
  		  if (nid==1){
  		  	  //變為最後1筆,其餘自動往前減1
  		  	  //保留第1筆的值
  		  	  for(i=1;i<=nfld;i++){
  		          eval('var nnh'+i);
  		          eval('nnh'+i+'=document.getElementById("Td'+i+'_1").innerHTML;');
            }	
                        
            nnKid =document.getElementById("tfx_sno1").value;   //id
  		  	  
  		  	  for(i=1;i<nrec;i++){
  		  	     nee =i+1;
  		  	     for(j=1;j<=nfld;j++){
  		  	     	  eval('document.getElementById("Td'+j+'_'+i+'").innerHTML=document.getElementById("Td'+j+'_'+nee+'").innerHTML;');  		  	     	  
  		  	     }               
               document.getElementById("tfx_sno"+i).value =document.getElementById("tfx_sno"+nee).value;
  		  	  }  		  	  
  		  	  
  		  	  for(j=1;j<=nfld;j++){
  		  	  	 eval('document.getElementById("Td'+j+'_'+nrec+'").innerHTML=nnh'+j+';');
  		  	  } 	  		  	  
            document.getElementById("tfx_sno"+nrec).value = nnKid;
            nng ='y';
  		  }
  		  else{  		  	
  		  	 nnp =eval(nid)-1;
  		  }
  		  
    }
    else{  //down
    	  if (nid ==nrec){    	  	 
    	  	  nnp=1;
    	  	  //保留最後1筆的值            
            for(j=1;j<=nfld;j++){
            	  eval('nnh'+j+'=document.getElementById("Td'+j+'_'+nrec+'").innerHTML;');
            }
            
            nnKid = document.getElementById("tfx_sno"+nrec).value;
  		  	  
  		  	  for(i=nrec;i>1;i--){
  		  	      nee=i-1;
               for(j=1;j<=nfld;j++){
               	  eval('document.getElementById("Td'+j+'_'+i+'").innerHTML=document.getElementById("Td'+j+'_'+nee+'").innerHTML;');
               }	               
               document.getElementById("tfx_sno"+i).value= document.getElementById("tfx_sno"+nee).value;
  		  	  }  
  		  	  
  		  	  for(j=1;j<=nfld;j++){
  		  	  	 eval('document.getElementById("Td'+j+'_1").innerHTML=nnh'+j+';');
  		  	  }
            document.getElementById("tfx_sno1").value = nnKid;
    	  	  nng='y';
    	  }
    	  else{
    	  	 nnp =eval(nid)+1;    	  	 
    	  }
    }  	    
    
    
    if (nng !=='y'){  
    	 //alert(nnp);     	         
       for(j=1;j<=nfld;j++){
       	  eval('nnh'+j+'=document.getElementById("Td'+j+'_'+nnp+'").innerHTML;');
       }	                    
       nnKid = document.getElementById("tfx_sno"+nnp).value;         	
    	 
    	 for(j=1;j<=nfld;j++){
    	 	  eval('document.getElementById("Td'+j+'_'+nnp+'").innerHTML =document.getElementById("Td'+j+'_'+nid+'").innerHTML;');
    	 }       
       
       document.getElementById("tfx_sno"+nnp).value =document.getElementById("tfx_sno"+nid).value; 
       for(j=1;j<=nfld;j++){
       	  eval('document.getElementById("Td'+j+'_'+nid+'").innerHTML=nnh'+j+';');
       }
       document.getElementById("tfx_sno"+nid).value = nnKid;    
    }    
  }
  
  
  function saveSort(nnap){ 
  	 //alert(nnap);  	 
     oform.action =nnap+'_sort.php';
     oform.submit();
  }   
  
 
function go_push(nap,vv){
 	 if (chkcount==0){
      alert ("請先勾選項目!!");
   }      	
   else{
   	   if (chkcount>1 && vv=='cov'){
   	   	   alert ("只能選擇一張做為代表圖!!");
   	   }	
   	   else{   	   	          
           oform.action =nap+'.php?v='+vv;
           oform.submit();          
      }    
   }  	 	
}  


  
function review_val(nthis){
	  oform.hxx_push.value=nthis.value;  	  
}


function go_plugno(){
	if (chkcount==0){
      alert ("請先勾選項目!!");
   }   
   else{      
      //alert(nap);
      document.getElementById("plugno").style.display="inline";
   } 		
}



function do_plugno(nap){	
	 var neno =document.getElementById("nfx_seno").value;
	 
   if (neno==''){
    	 alert("請輸入No.代號");
   }
   else{   
   	  var xxpos =document.getElementsByName("cxx_pos");
   	  if (xxpos[0].checked){
   	  	  oform.hxx_pos.value =xxpos[0].value;
   	  }
   	  else{
   	  	  oform.hxx_pos.value =xxpos[1].value;
   	  }   	     	  
   	
   	  oform.hxx_totchk.value=chkcount;   	  
   	  oform.hxx_plugno.value =neno;    	  
   	  if (nap =='work_plugno'){
   	     oform.hxx_ctid.value =document.getElementById("sxx_cat").value;
   	  }   
      oform.action =nap+'.php';
      oform.submit();
   }
}



function go_itemvfy(){  
 	 if (chkcount==0){
      alert ("請先勾選項目!!");
   }   
 	 else{  	 	   	 	 	  	 	
      var xdel =confirm("是否確定選擇這些產品?");
      if (xdel){  
      	 oform.hxx_rec.value=window.opener.document.reg.hxx_rcnt.value;
         oform.action ='witem_do.php';
         oform.submit();
      }        
   }     
}  


function goquery(){
	var errmsg ='';
	 
	var xbdt =document.getElementById("dxx_bdate").value;
	var xedt =document.getElementById("dxx_edate").value;
	var xcargo =document.getElementById("sxx_cargo").value;	
	if (!(xbdt=='' || xedt=='') && xcargo==''){
		  errmsg +='出貨日還是訂單日\n';		 
  }
  
  var xkld =document.getElementById("sxx_keyfld").value;
  var xqry =document.getElementById("txx_query").value
  if ( xqry!=='' && xkld==''){
  	  errmsg +='查詢欄位\n';		 
  }	
	
	
	if (errmsg !==''){   
		  alert('請設定:\n'+errmsg);
  }
  else{
	    oform1.hxx_sts.value    =document.getElementById("sxx_sts").value;
	    oform1.hxx_cargo.value  =document.getElementById("sxx_cargo").value;
	    oform1.hxx_bdate.value  =document.getElementById("dxx_bdate").value;
	    oform1.hxx_edate.value  =document.getElementById("dxx_edate").value;
	    oform1.hxx_keyfld.value =document.getElementById("sxx_keyfld").value;
	    oform1.hxx_keywd.value  =document.getElementById("txx_query").value;
      oform1.submit();
  }
}

function cust_query(){
	var errmsg ='';	 
	
    var xkld =document.getElementById("sxx_keyfld").value;
    var xqry =document.getElementById("txx_query").value
    if ( xqry!=='' && xkld==''){
  	    errmsg +='查詢欄位\n';		 
    }		
	
	if (errmsg !==''){   
		  alert('請設定:\n'+errmsg);
  }
  else{	    
	    oform1.hxx_keyfld.value =document.getElementById("sxx_keyfld").value;
	    oform1.hxx_keywd.value  =document.getElementById("txx_query").value;
        oform1.submit();
  }
}



function goarea(nap,nid,nm){    //進入下一層
	  oform.pxx_id.value=nid;
	  oform.hxx_nm.value=nm;
	  var nnap =nap+'_list.php';	  
	  oform.action =nnap;
	  oform.submit();
}
