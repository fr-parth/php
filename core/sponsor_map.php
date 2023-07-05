<?php 
  include_once('stud_header.php');
$id=$_SESSION['id'];
 $fields=array("id"=>$id);
		   $table="tbl_student";
	       $smartcookie=new smartcookie();
		   $result=$smartcookie->retrive_individual($table,$fields);
		   $results=mysql_fetch_array($result);
$city=$results['std_city'];
$country=$results['std_country'];

 $latitude=$results['latitude'];
 $longitude=$results['longitude'];
?>

<!DOCTYPE html>
 
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Google Maps Example</title>
        <style type="text/css">
           
            #sidebar { float: right; width: 0px; }
            #main { border:1 px solid #CCCCCC; }
            .infoWindow { width: 220px; }
        </style>
       
        <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
      
		
		<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places"></script>
    <script>
	




		function displayLocation(location) {
       for(var i=0;i<location.length;i++)
		{
    var content =   '<div class="infoWindow"><strong>'  + location[i].name + '</strong>'
                    + '<br/>'     + location[i].address
                    + '<br/>'     + location[i].description + '</div>';
	if(location[i].id==undefined)
	{
	  if (parseInt(location[i].lat) == 0) {
        geocoder.geocode( { 'address': location[i].address }, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                 
                var marker = new google.maps.Marker({
                    map: map, 
                    position: results[0].geometry.location,
                    title: location[i].name,
					animation: google.maps.Animation.DROP,
					 icon: 'http://maps.google.com/mapfiles/ms/icons/purple-dot.png'
                });
           
                google.maps.event.addListener(marker, 'click', function() {
                    infowindow.setContent(content);
                    infowindow.open(map,marker);
                });
            }
        });
    } else {
	
        var position = new google.maps.LatLng(parseFloat(location[i].lat), parseFloat(location[i].lon));
        var marker = new google.maps.Marker({
            map: map, 
            position: position,
            title: location[i].name,
			animation: google.maps.Animation.DROP,
			 icon: 'http://maps.google.com/mapfiles/ms/icons/purple-dot.png'
        });
       
        google.maps.event.addListener(marker, 'click', function() {
            infowindow.setContent(content);
            infowindow.open(map,marker);
        });
    }
	}
	else
	{
	  if (parseInt(location[i].lat) == 0) {
        geocoder.geocode( { 'address': location[i].address }, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                 
                var marker = new google.maps.Marker({
                    map: map, 
                    position: results[0].geometry.location,
                    title: location[i].name,
					animation: google.maps.Animation.DROP
                });
           
                google.maps.event.addListener(marker, 'click', function() {
                    infowindow.setContent(content);
                    infowindow.open(map,marker);
                });
            }
        });
    } else {
	
        var position = new google.maps.LatLng(parseFloat(location[i].lat), parseFloat(location[i].lon));
        var marker = new google.maps.Marker({
            map: map, 
            position: position,
            title: location[i].name,
			animation: google.maps.Animation.DROP
        });
       
        google.maps.event.addListener(marker, 'click', function() {
            infowindow.setContent(content);
            infowindow.open(map,marker);
        });
    }
	
	}
    
  
	}
}
		
		function makeRequest(url, callback) {
		        
				var request;
				var distance=document.getElementById("distance").value;
				var latitude=document.getElementById("latitude").value;
                var longitude=document.getElementById("longitude").value;
				  var url=url+"?dist="+distance+"&latitude="+latitude+"&longitude="+longitude;
				
				if (window.XMLHttpRequest) {
					request = new XMLHttpRequest(); // IE7+, Firefox, Chrome, Opera, Safari
				} else {
					request = new ActiveXObject("Microsoft.XMLHTTP"); // IE6, IE5
				}
				request.onreadystatechange = function() {
					if (request.readyState == 4 && request.status == 200) {
						callback(request);
					}
				}
				request.open("GET", url, true);
				
				request.send();
			}
        //<![CDATA[
         
       var map;
	   function getLocation() {
	 
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } 
}

function showPosition(position) {
 	
	
// City Center
var center = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
document.getElementById("latitude").value=position.coords.latitude;
document.getElementById("longitude").value=position.coords.longitude;
 var distance=document.getElementById("distance").value;
 if(distance<10)
 {
 var zoom_in=15;
 }
 else if(distance<200)
 {
   var zoom_in=11;
 }
 else
 {
   var zoom_in=7;
   
 }

 var mapOptions = {
      zoom: zoom_in,
      center: center,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    }
      
    map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
	 var position = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
	 var iconBase = 'https://maps.google.com/mapfiles/kml/shapes/';
        var marker = new google.maps.Marker({
            map: map, 
            position: position,
            title: "My Position",
			
			 icon: iconBase + 'man.png'
        });
       
        google.maps.event.addListener(marker, 'click', function() {
            infowindow.setContent(content);
            infowindow.open(map,marker);
        });
     
    makeRequest('get_locations.php', function(data) {

        var data = JSON.parse(data.responseText);
		
         
        for (var i = 0; i < data.length; i++) {
            displayLocation(data[i]);

			
        }
    });
}
 

var geocoder = new google.maps.Geocoder();

var infowindow = new google.maps.InfoWindow();
 
function init() {

getLocation();


 
    
}


        //]]>
        </script>
    </head>
    <body onLoad="init();" style="background-color:#FFFFFF;">
   
       <!-- body-->
<div class="container">
  <div class="row">
	
       <div class="col-sm-3" style="padding:20px;">
   
          <div class="panel panel-default" style="width:110%;">
          <div class="panel-heading" style="background: -moz-linear-gradient(center top , #FFF 20%, #E7E7E7 100%) repeat scroll 0px 0px transparent;padding:10px;">
            <h2 class="panel-title" style="font-weight:bold; color:#0066CC; font-family:Arial,Helvetica,sans-serif;"  >Sponsors</h2>
          </div>
          <div class="panel-body">
          <h3 style="color:#000000;font-family:Arial,Helvetica,sans-serif;"> Local Sponsors</h3>
           <ul class="my-account-nav"  style="padding-top:20px;width:116%;">
							<?php $rows=mysql_query("select * from tbl_sponsorer where sp_city='$city' and sp_country='$country' ");
							   while($result=mysql_fetch_array($rows))
							   {?><a style="text-decoration:none;" href="#"><li ><?php
							   echo $result['sp_name'];
							   echo "-";
							   echo $result['sp_city'];
							   echo ",";
							   echo $result['sp_country'];?></li></a><?php
							   }
					     ?>       
                       
                </ul>                      
                                      
                                      
                                      
                                 
          
          </div>
        </div>
        
	</div>
       
           <!-- reight side-->
           
           <div class="col-sm-9" style="padding:20px;">
         <div  style="height:50px; background-color:#0073BD; border:1px solid #0073BD;color:#FFFFFF" align="left">
        		<div style="float:left;"><h1 style="padding-left:20px; margin-top:10px;color:#FFFFFF">School & Sponsor Map</h1></div>
                
                 
                
          </div> 

           
                      <div class="container" style="width:100%;margin-top:30px;border:1 px solid #333333;">      
     
         <input type="hidden" id="latitude" ><input type="hidden" id="longitude">
       <div class="row"><div class="col-md-6"><b>Distance in km  </b><select name="distance" id="distance" value="" type="text" onChange="return init()" style="width:100px;"><option value="2">2</option><option value="5">5</option><option value="10">10</option><option value="20">50</option><option value="100">100</option><option value="200">200</option><option value="300">300</option></select></div></div>
        <div class="row" style="padding:5px;" style="border:1 px solid #000000;"><div class="col-md-18" >
        <section id="main">
            <div id="map_canvas" style="width: 100%; height: 450px;"></div>
            
             
        <div class="row" style="padding-top:10px;">
        <div class="col-md-7"></div>
        <div class="col-md-5 " style="color:#FF0000;font-weight:bold;">* Vendors Negotiation is in process </div>
        </div>
        </section>
        </div>
        <!--<input id="pac-input" class="controls" type="text"
        placeholder="Enter a location">
        <div id="lat"></div>
        <div id="long"></div>-->
         </div>
         </div>
         </div>
    </body>
</html>