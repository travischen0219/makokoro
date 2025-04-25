  var oform = document.reg;	
  			
	function datachk(){				
	  var errMsg = "";
	  var npikway =oform.hxx_pickup_way.value;  //取貨方式1.宅 2.自	  
	 
	  
	  if (npikway=='1'){  //宅配
	  	    if (oform.tfx_rman.value==''){
             errMsg +="[收件人姓名]\n" ;
          }  
    
          if (oform.tfx_rtel.value=='' && oform.tfx_rcell.value==''){
          	  errMsg +="[至少輸入一支聯絡電話]\n"
          }  
          else{
              
              if (!(isTel(oform.tfx_rtel)) ){
                 errMsg +="[室內電話]格式錯誤\n";
              } 
              
              if (!(isCell(oform.tfx_rcell))){
                 errMsg +="[行動電話]格式錯誤\n";
              }         
          } 
          
          if (oform.sxx_city.value.match(/[^\n^\s]/)==null){
              errMsg +="[縣市] \n" ;
          }                 
          if (oform.subtype.value.match(/[^\n^\s]/)==null){
            	 errMsg +="[區域] \n" ; 
          }    
          if (oform.tfx_rhome.value.match(/[^\n^\s]/)==null){
          	  errMsg +="[收件地址]\n" ; 
          } 	  	
     }	  
	     
    
    if (oform.sfx_sts.value==''){
    	  errMsg +="[處理進度]\n" ; 
    }
    else{
    	
    	  if (oform.sfx_sts.value !=='3' && document.getElementById("dxx_date").value !==''){
    	  	  errMsg +='訂單未出貨時,不需輸入出貨日期\n';
    	  	  oform.dxx_date.value='';
    	  }	
    	  else if (oform.sfx_sts.value =='3' && document.getElementById("dxx_date").value ==''){
    	  	  errMsg +='訂單為已出貨時,請輸入出貨日期\n';
    	  }	    	    	   
    }            
     
    if (errMsg !="") { 
       alert ('請檢查以下欄位:\n'+errMsg);         
    } 
    else{   
    	
    	 //document.getElementById("btnadd").disabled =true;
    	 document.getElementById("btnsure").disabled=true;
    	 document.getElementById("btnback").disabled=true;
    	 oform.dfx_cargodate.value =document.getElementById("dxx_date").value;
    	 //oform.dfx_deliver_d.value =document.getElementById("dxx_d").value;
    	 
    	 if (npikway=='1'){
    	     var oselect1 =oform.sxx_city;
           var oselect2 =oform.subtype;           	      
	         oform.hfx_rcity.value=oselect1.options[oselect1.selectedIndex].value;	     
	         oform.hfx_rdist.value=oselect2.options[oselect2.selectedIndex].text;
	         oform.hfx_rzip.value =oselect2.options[oselect2.selectedIndex].value;
	     }    
       oform.submit();
    }		 
  }
	
  
  function gowindow(){  	
  	var nnap ='witem_list.php';  	
  	var nnapcode =oform.hxx_apcode.value;
  	var nnowid   =oform.pxx_id.value;
  	var nnwin = window.open(nnap+'?m='+nnapcode+'&p='+nnowid,'getitem','width=700,height=780,top=0,left=380,toolbar=no,menubar=no,scrollbars=yes,resizable=yes,location=no,status=yes');  	
  } 
  
  function go_cust(){  	
  	var nnap ='wcust_list.php';  	
  	var nnwin = window.open(nnap+'?m=<?php echo $m_apcode?>&p=<?php echo $nowid ?>','getcust','width=700,height=780,top=0,left=380,toolbar=no,menubar=no,scrollbars=yes,resizable=yes,location=no,status=yes');  	
  }
  
  
  function chg_amt(othis,nnc){  	 
  	 var nvv;  	 
  	 nvv =othis.value;  	 
  	 if (nvv==''){
  	 	  nvv=0;
  	 }  	 
  	 
  	 var nnprice =document.getElementById("nxx_price"+nnc).value;  	 
  	 //alert(nnc);
  	 var nstot =nvv*nnprice;  //產品小計
  	   	 
  	 //document.getElementById("nxx_price"+nnc).value=nstot;
  	 document.getElementById("stot"+nnc).innerHTML =nstot;
  	 document.getElementById("nmx_stot"+nnc).value =nstot;
  	 ntagid =othis.id;
  	 if (nstot==0){  	 	  
  	 	  document.getElementById(ntagid).value=nstot;
     }
     //--
     //alltot(nncnt);
     alltot('');
  }         
  
  function chg_cargo(nvv){  	
  	  //var nn_cargo ='';
     // var ary_cargo =nn_cargo.split('|');  
  	 // var nff =nvv-1;
  	 // var ncargo=ary_cargo[nff];
  	 // oform.nfx_cargo.value =ncargo;
  	 // document.getElementById("cargo").innerHTML =ncargo;
  	 // alltot(nncnt);
  }  
  
  function dst_chg(othis){
  	  oform.hfx_rzip.value =othis.value;
  	  //alltot('');
  	  return false;
  }
  
  function alltot(nvv){ 
  	 //alert(nvv);
  	 var nnpikway =oform.hxx_pickup_way.value //取貨方式
  	
  	 var nnc ='';
  	 if (nvv !==''){
  	 	  nnc =nvv;
  	 } 	
  	 else{
  	 	  nnc =oform.hxx_rcnt.value;
  	 }  	 
  	 var ntot=0;
  	 var nnamt;
  	 var ndamt;
  	 var ntot_amt=0;
     for(i=1;i<=nnc;i++){
     	  ntot +=parseInt(document.getElementById("nmx_stot"+i).value,10);  //總金額     	  
     }          
     
     //--商品金額
     oform.nfx_pmny.value=ntot;
     document.getElementById("pmny").innerHTML =ntot;     
     //--運費
     if (nnpikway=='1'){
         var nnland =oform.sfx_land.value;   //島內外
         var nndst  =oform.hfx_rzip.value;    //宅配特定優惠區域 zip
         nncargo =getcargo(nnland,ntot,nndst);     
     }    
     else{
     	   nncargo=0;
     }
     oform.nfx_cargo.value =nncargo;
     document.getElementById("cargo").innerHTML =nncargo;     
     //--代收款
     nnpdvr =0
     //oform.nfx_pay_deliver.value=0;
     //--總額
     nalltot =ntot + parseInt(nncargo,10) + parseInt(nnpdvr,10);
     //alert(nalltot);     
     document.getElementById("totmny").innerHTML =nalltot;
     oform.nfx_totmny.value =nalltot;
  }  
  
  function getcargo(nl,ny,nz){
  	 var httpObject =createXMLHttpRequest();
     var strUrl  ="";
     var strA    ="";
     var xselTxt ="";                    
     strUrl      ="../../js/get_cargo.php";
     opara ="nl="+nl+"&ny="+ny+"&ds="+nz;
     //alert(opara);
     httpObject.open("post",strUrl,false);    //true:非同步  flase:同步
     
     httpObject.setRequestHeader("Content-Length",strA.length); 
     httpObject.setRequestHeader("CONTENT-TYPE","application/x-www-form-urlencoded");     
     httpObject.setRequestHeader("charset", "utf-8");                   
     
     httpObject.send(opara);     
     var xxchk =httpObject.responseText;  	  	
     //alert(xxchk);
     return xxchk;
  }    