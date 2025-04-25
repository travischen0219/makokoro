<?php 
  $faddr =''; 
  if (isset($_GET['p'])){
     $faddr =$_GET['p'];
  }
  
  //$faddr ='台中市西區中港路一段133號';
  //$faddr ='台北市內湖區行愛路141巷38號';
  
  $gurl ='http://maps.google.com/maps/geo?q='.urlencode($faddr).'&output=csv';
  //echo $gurl.'<br/>';
  
  $fpos_v =getcurl($gurl,'r');  //取座標
    
  $fpos_l ='';
  $fpos_l =$fpos_v;   
  $fpos_l =substr($fpos_l,6);
  $ary_pos =explode(',',$fpos_l);
  $pos_x =$ary_pos[0];
  $pos_y =$ary_pos[1];
  
  $m_gkey ='ABQIAAAAoeEa-HiZh80MPVdJigH59BSeWAE3ZnHXM-oqcM6PEWkfNAxYXRTFsarsN3M2Vufjfdc47RdtOd4Ebg';
  
  //echo $fpos_l;
  //exit();
  
function getcurl($xurl){
	$ch = curl_init();
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_URL,$xurl);
  //curl_setopt($ch, CURLOPT_USERAGENT, "Google Bot");
  $ffp = curl_exec($ch);
  curl_close($ch);
  return $ffp;
}  
  
  
?>
<html> 
  <head> 
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/> 
    <title>查詢地圖上的經緯度</title> 
    <script src="http://maps.google.com/maps?hl=zh-tw&file=api&amp;v=2&amp;key=<?php echo $m_gkey?>"
      type="text/javascript"></script> 
    <script type="text/javascript"> 
    //<![CDATA[
    var pos_x ='<?php echo $pos_x?>';
    var pos_y ='<?php echo $pos_y?>';
    var sw=0;
    var pos_str;
 
    function load() {
      //var ParStr = getUrl();
      var ParStr ='';      
      if (ParStr.length > 0){
          ParStr =ParStr.substr(4);
	        var parm =ParStr.split(',');
	        pos_x =parseFloat(parm[0]);
	        pos_y =parseFloat(parm[1]);
	        pos_str =ParStr;
	        var strlen=13;
	        var address = "zzzzzzzzzzzzzxx";
      }else{
          //var address = document.getElementById('addr').value; 
          //var strlen  = document.getElementById('addr').value.length; 
	         pos_str  =address;
	         //document.getElementById('aid').value = document.getElementById('cid').value ; 
      }
 
      if (GBrowserIsCompatible()) {
  	     var geo =new GClientGeocoder(new GGeocodeCache()); 
	       var map =new GMap2(document.getElementById("map"));
         var LatLng =new GLatLng(pos_x, pos_y);
  	     map.addControl(new GLargeMapControl());
	       map.addControl(new GMapTypeControl());
       // map.addControl(new ExtStreetviewControl());
 
         if (strlen>0){
	            geo.getLatLng( address, function(point) { 
	        if (point){
           	  map.setCenter(point, 16);
  		        showMap(map, point,0);
		      }else{
         	    map.setCenter(LatLng, 16);
		          showMap(map, LatLng,1);
		      }
	    });
	 }else {
		    //pos_str ="移動這指標到所要位置, 或請輸入地址,<BR>再按 [更換地點] 以顯示新地點.";
        map.setCenter(LatLng, 16);
		    showMap(map, LatLng,1);
	 } 
   }
  }
    
   function showMap(map,loc,sw){ //draggable
 	 var pos =new GMarker(loc,{draggable:false});
	   //document.getElementById('pos_k').value =pos.getPoint().lat().toFixed(6)+','+pos.getPoint().lng().toFixed(6);
	   //document.getElementById('_url').value ='http://'+ 'card.url.com.tw'+'/realads/map_latlng.php?pos='+
	 	//pos.getPoint().lat().toFixed(6)+','+ pos.getPoint().lng().toFixed(6);
 
	 GEvent.addListener(pos, "dragstart", function() {
   //       			map.closeInfoWindow();
	 });
	 GEvent.addListener(pos, "dragend", function() {
	  	//document.getElementById('pos_k').value = pos.getPoint().lat().toFixed(6)+','+	pos.getPoint().lng().toFixed(6);
	  	//document.getElementById('_url').value = 'http://'+ 'card.url.com.tw'+	'/realads/map_latlng.php?pos='+	pos.getPoint().lat().toFixed(6)+','+ pos.getPoint().lng().toFixed(6);
	//xx	pos.openInfoWindowHtml( pos_str );
	 });
 
         map.addOverlay(pos);   //提示框
	// pos.openInfoWindowHtml(pos_str);
      }
 
      function getUrl(){
	      var str = window.location.href;
	      if ( str.indexOf("?") > -1 ){
	         var strQ = str.substr(str.indexOf("?")+1);
	         return strQ;
	      } else {
	         return "";
	      }
      }
 
     function URLDecode(str){
       var ret="";
       for(var i=0;i<str.length;i++){
          var chr = str.charAt(i);
    	  if (chr == "+"){
      	      ret+=" ";
   	  }else if(chr=="%"){
     	      var asc = str.substring(i+1,i+3);
     	      if(parseInt("0x"+asc)>0x7f){
      		  ret+=String.fromCharCode((parseInt("0x"+asc)));
      		  i+=2;
     	      }
    	 }else{
      		ret+= chr;
    	 }
       }
       return ret;
     }
 
    //]]>
    </script> 
  </head> 
  <body onload="load()" onunload="GUnload()"> 
    <div id="map" style="width:100%;height:100%;overflow:hidden;"></div> 
   </body>
</html> 