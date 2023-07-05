<?php 
  include 'sponsor_header.php';
$id=$_SESSION['id'];

           $fields=array("id"=>$id);
		   $table="tbl_sponsorer";
		   
		   $smartcookie=new smartcookie();
		   
$result=$smartcookie->retrive_individual($table,$fields);
$results=mysql_fetch_array($result);

$sp_name=$results['sp_name'];

 $latitude=$results['lat'];
  $longitude=$results['lon'];
 $country=$results['sp_country'];
 $city=$results['sp_city'];
$state=$results['sp_state'];
$address1=$results['sp_address'];
 $address=$results['sp_address'].",".$results['sp_city'].",".$results['sp_state'].",".$results['sp_country'];


?>
<style type="text/css">
.infoWindow { width: 220px; }
</style>
   <!--     <link rel="stylesheet" type="text/css" href="css/student_dashboard_test.css">-->
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places"></script>
 <script>
	
function displayLocation(location) {
         for(var i=0;i<location.length;i++)
		{
		
   			
								if(location[i].id==undefined)
									{
										var contentString = '<div id="content">'+
      '<div id="siteNotice">'+
      '</div>'+
      '<strong>'+location[i].name+'</strong>'+
      '<div id="bodyContent">'+
      '<p>'+ location[i].address +'</p>'+
      '</div>'+
      '</div>';
										  if (parseInt(location[i].lat) == 0) {
											geocoder.geocode( { 'address': location[i].address }, function(results, status) {
												if (status == google.maps.GeocoderStatus.OK) {
													 
													 
													 var infowindow = new google.maps.InfoWindow({
      content: contentString
  });
													var marker = new google.maps.Marker({
														map: map, 
														position: results[0].geometry.location,
														title: location[i].name,
														animation: google.maps.Animation.DROP,
														 icon: 'http://maps.google.com/mapfiles/ms/icons/purple-dot.png'
													});
											   
													google.maps.event.addListener(marker, 'click', function() {
													
														
														infowindow.open(map,marker);
													});
												}
											});
										} else {
										
										
										
										
										var contentString = '<div id="content">'+
      '<div id="siteNotice">'+
      '</div>'+
      '<strong>'+location[i].name+'</strong>'+
      '<div id="bodyContent">'+
      '<p>'+ location[i].address +'</p>'+
      '</div>'+
      '</div>';
					
										
											var position = new google.maps.LatLng(parseFloat(location[i].lat), parseFloat(location[i].lon));
											
											var infowindow = new google.maps.InfoWindow({
      content: contentString
  });
											var marker1 = new google.maps.Marker({
												map: map, 
												position: position,
												title: location[i].name,
												animation: google.maps.Animation.DROP,
												 icon: 'http://maps.google.com/mapfiles/ms/icons/purple-dot.png'
											});
										   
											google.maps.event.addListener(marker1, 'click', function() {
											
											
												infowindow.open(map,marker1);
											});
										}
										}
										else
										{
										
										var contentString = '<div id="content">'+
      '<div id="siteNotice">'+
      '</div>'+
      '<strong>'+location[i].name+'</strong>'+
      '<div id="bodyContent">'+
      '<p>'+ location[i].address +'</p>'+
      '</div>'+
      '</div>';
											 
										  if (parseInt(location[i].lat) == 0) {
											geocoder.geocode( { 'address': location[i].address }, function(results, status) {
												if (status == google.maps.GeocoderStatus.OK) {
												
												var infowindow = new google.maps.InfoWindow({
      content: contentString
  });
													 
													var marker = new google.maps.Marker({
														map: map, 
														position: results[0].geometry.location,
														title: location[i].name,
														animation: google.maps.Animation.DROP
													});
											   
													google.maps.event.addListener(marker, 'click', function() {
														
														infowindow.open(map,marker);
													});
												}
											});
										} else {
										
												var contentString = '<div id="content">'+
      '<div id="siteNotice">'+
      '</div>'+
      '<strong>'+location[i].name+'</strong>'+
      '<div id="bodyContent">'+
      '<p>'+ location[i].address +'</p>'+
      '</div>'+
      '</div>';
	  
	  	var infowindow = new google.maps.InfoWindow({
      content: contentString
  });
	  
											var position = new google.maps.LatLng(parseFloat(location[i].lat), parseFloat(location[i].lon));
											
											var infowindow = new google.maps.InfoWindow({
      content: contentString
  });
											var marker = new google.maps.Marker({
												map: map, 
												position: position,
												title: location[i].name,
												animation: google.maps.Animation.DROP
											});
										   
											google.maps.event.addListener(marker, 'click', function() {
												
												infowindow.open(map,marker);
											});
										}
							
							}

  
	}
}
		
		function makeRequest(url, callback) {
		        
				var request;
				var distance=document.getElementById("distance").value;
				var latitude=<?php echo $latitude; ?>;
				 var longitude=<?php echo  $longitude ;?>;
				 var sp_id=<?php echo $id;?>
               
				  var url=url+"?dist="+distance+"&latitude="+latitude+"&longitude="+longitude+"&sp_id="+sp_id;
				
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
	 

 	
	


 
function init() {

// City Center
var center = new google.maps.LatLng(<?php echo $latitude; ?>,<?php echo  $longitude ;?>);

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
   var zoom_in=4;
 }

 var mapOptions = {
      zoom: zoom_in,
      center: center,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    }
      
    map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
/*//	var position = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
 var image = {
    url: 'http://maps.google.com/mapfiles/ms/icons/purple-dot.png',
    // This marker is 20 pixels wide by 32 pixels tall.
    size: new google.maps.Size(500, 150),
    // The origin for this image is 0,0.
    origin: new google.maps.Point(0,0),
    // The anchor for this image is the base of the flagpole at 0,32.
    anchor: new google.maps.Point(0, 52)
  };*/

						var contentString = '<div id="content">'+
      '<div id="siteNotice">'+
      '</div>'+
      '<strong>'+'<?php echo $sp_name;?>'+'</strong>'+
      '<div id="bodyContent">'+
      '<p>'+'<?php echo $address1; ?>' +'</p>'+
      '</div>'+
      '</div>';
	  var infowindow = new google.maps.InfoWindow({
      content: contentString
  });
					
        var marker1 = new google.maps.Marker({
            map: map, 
            position: center,
            title: "<?php echo $sp_name; ?>",
			 icon: 'http://maps.google.com/mapfiles/ms/icons/green-dot.png'



			
			
        });
       
        google.maps.event.addListener(marker1, 'click', function() {
	
														
														infowindow.open(map,marker1);
													});
													
    
    makeRequest('get_locations.php', function(data) {

        var data = JSON.parse(data.responseText);
		
    
        for (var i = 0; i < data.length; i++) {
		
            displayLocation(data[i]);

			
        }
    });
    
}


        //]]>
        </script>    </head>
    <body onLoad="init();">
   
       <!-- body-->
<style>
.list-group-item{
	padding:5px;
}
.row{
	padding-top:5px; 
}
</style>
	   <div class="container-fluid">
  	<div class="col-md-12">
	<div class="row">
		<div class="col-sm-3">
			<div class="panel panel-default">
				<div class="panel-heading" >
					<h3 class="panel-title"><b>Local Sponsors</b></h3>
				</div>
			<div class="" >
          
              <ul class="list-group" >
							<?php $rows=mysql_query("select * from tbl_sponsorer  where sp_city like '$city' and sp_country like '$country' and sp_state like'$state' and id!='$id'");
							   while($result=mysql_fetch_array($rows))
							   {?><!--<a style="text-decoration:none;" href="sponsor_information.php?id=<?php echo $result['id']; ?>">-->
						   <li class="list-group-item" >
						   <?php
							   echo $result['sp_name'];
							   echo "-";
							   echo $result['sp_city'];
							   echo ",";
							   echo $result['sp_country'];
							?>
							</li><!--</a>--><?php
							   }
					     ?>          
             </ul>  
</div>
			</div>
        </div>
		<div class="col-md-9">
				<div class="panel panel-default">
				<div class="panel-heading" >
					<h3 class="panel-title"><b>School & Sponsor Map</b></h3>
				</div>
				<div class="panel-body" >
					<input type="hidden" id="latitude" ><input type="hidden" id="longitude">
					<div class="row"><div class="col-md-6"><b>Distance in km</b><select name="distance" id="distance" value="" type="text" onChange="return init()" style="width:100px;"><option value="2">2</option><option value="5">5</option><option value="10">10</option><option value="20">50</option><option value="100">100</option><option value="200">200</option><option value="300">300</option></select></div></div>
					<div class="row">
						<section id="main">
						<div id="map_canvas" style="width: 100%; height: 500px;"></div>
						</section>
					</div>
				</div>
				</div>
		</div>
	</div>      
 </div>
 </div>  

    </body>
</html>