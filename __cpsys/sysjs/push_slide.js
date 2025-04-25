function gopush(nvv,nd){
	    var ovv =document.getElementById(nvv);
      ovv.href='show_vid.php?v='+nd;
      
			 if(document.all) {  
          //document.getElementById(nvv).click();
          ovv.click();
       }  
       else  
       {  
           var evt = document.createEvent("MouseEvents");  
           evt.initEvent("click", true, true);  
           document.getElementById(nvv).dispatchEvent(evt);  
       }
}		 