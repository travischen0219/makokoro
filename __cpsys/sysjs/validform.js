//驗證電話
function isTel(thisObj)
{
  var elem =thisObj.value
  if (elem=="") return true;    
  
  var pattern=/^0[0-9]{1,3}[0-9]{6,8}$/;
  
  if(pattern.test(elem))
  { 
    return true;
  }
  else
  {              
    return false;
  }
}



//驗證手機
function isCell(thisObj)
{
  var elem=thisObj.value;
  if (elem=="") return true;	
  
  //var pattern=/^09[0-9]{4}-[0-9]{3}[0-9]{3}$/;
  var pattern=/^09[0-9]{2}[0-9]{6}$/;
  
  if(pattern.test(elem))
  {    
    return true;
  }
  else
  {
    //alert("手機格式輸入錯誤!!");
    //thisObj.value="";
    //thisObj.focus();
    return false;
  }
}


//驗證E-mail
function isEmail(elem)
{
  var xvalue=elem.value
	if (xvalue=="") return true;	
	
  var reEmail        =/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/
  if(reEmail.test(xvalue))
  {
     return true;
  }
  else
  {     
    //alert("E-mail輸入錯誤");    
    //var xeid = elem.id   
    //document.getElementById(xeid).focus();
    return false;
  }     
}

function isint(e) { //按鍵 0~9 or .
  var key = window.event ? e.keyCode : e.which;     
  if ( !( (key>=48&&key<=57) || key==46) )
  {      	   
    return false;
  }     
}

function isint_d(e) {  //不含小數 	      
     var key = window.event ? e.keyCode : e.which;        
     if ( !( (key>=48&&key<=57)) ){
        return false;
     }
 }
 

//統編
function isTaxno(othis) { 
	 idvalue =othis.value;
   var tmp = new String("12121241"); 
   var sum = 0; 
   re = /^\d{8}$/; 
   if (!re.test(idvalue)) { 
       //alert("格式不對！"); 
       return false; 
    } 
   for (i=0; i< 8; i++) { 
     s1 = parseInt(idvalue.substr(i,1)); 
     s2 = parseInt(tmp.substr(i,1)); 
     sum += cal(s1*s2); 
   } 
   if (!valid(sum)) { 
      if (idvalue.substr(6,1)=="7") return(valid(sum+1)); 
   }   
   return(valid(sum)); 
} 

function valid(n) { 
   return (n%10 == 0)?true:false; 
} 


function cal(n) { 
   var sum=0; 
   while (n!=0) { 
      sum += (n % 10); 
      n = (n - n%10) / 10;  // 取整數 
     } 
   return sum; 
} 


 