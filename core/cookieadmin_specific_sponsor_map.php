
<?php 
  include_once('cookieadminheader.php');
$id=$_SESSION['id'];

 //$city=$results['t_city'];
//$country=$results['t_country'];

 
 
?><!DOCTYPE html>
<html>
<head>
	<title>Google Map Template with Geocoded Address</title>
	<!--<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>	 Google Maps API -->
   <script src="https://maps.googleapis.com/maps/api/js?key= AIzaSyC6a82THnTa5HNDK98J2KOihmQc03YkWQ0&libraries=places&callback=initAutocomplete"async defer></script>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places"></script>
	<script>
	var map;	// Google map object
	
	
	
	
	
	 function initAutocomplete() {
        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: -33.8688, lng: 151.2195},
          zoom: 13,
          mapTypeId: 'roadmap'
        });

        // Create the search box and link it to the UI element.
        var input = document.getElementById('pac-input');
        var searchBox = new google.maps.places.SearchBox(input);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        // Bias the SearchBox results towards current map's viewport.
        map.addListener('bounds_changed', function() {
          searchBox.setBounds(map.getBounds());
        });

        var markers = [];
        // Listen for the event fired when the user selects a prediction and retrieve
        // more details for that place.
        searchBox.addListener('places_changed', function() {
          var places = searchBox.getPlaces();

          if (places.length == 0) {
            return;
          }

          // Clear out the old markers.
          markers.forEach(function(marker) {
            marker.setMap(null);
          });
          markers = [];

          // For each place, get the icon, name and location.
          var bounds = new google.maps.LatLngBounds();
          places.forEach(function(place) {
            if (!place.geometry) {
              console.log("Returned place contains no geometry");
              return;
            }
            var icon = {
              url: place.icon,
              size: new google.maps.Size(71, 71),
              origin: new google.maps.Point(0, 0),
              anchor: new google.maps.Point(17, 34),
              scaledSize: new google.maps.Size(25, 25)
            };

            // Create a marker for each place.
            markers.push(new google.maps.Marker({
              map: map,
              icon: icon,
              title: place.name,
              position: place.geometry.location
            }));

            if (place.geometry.viewport) {
              // Only geocodes have viewport.
              bounds.union(place.geometry.viewport);
            } else {
              bounds.extend(place.geometry.location);
            }
          });
          map.fitBounds(bounds);
        });
      }
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
            
	// Initialize and display a google map
	function Init()
	{
		// Create a Google coordinate object for where to initially center the map
		var latlng = new google.maps.LatLng( 38.8951, -77.0367 );	// Washington, DC
		
		// Map options for how to display the Google map
		var mapOptions = { zoom: 5, center: latlng  };
		
		// Show the Google map in the div with the attribute id 'map-canvas'.
		map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
	}
	
	// Update the Google map for the user's inputted address
	function UpdateMap( )
	{
		var geocoder = new google.maps.Geocoder();    // instantiate a geocoder object
		
		// Get the user's inputted address
		var address = document.getElementById( "address" ).value;
		var state = document.getElementById( "state" ).value;
		var country = document.getElementById( "country" ).value;
		
		 var address = address.concat(',').concat(state).concat(',').concat(country);
		
			var distance = document.getElementById( "distance" ).value;
		
	
		// Make asynchronous call to Google geocoding API
		geocoder.geocode( { 'address': address }, function(results, status) {
			var addr_type = results[0].types[0];	
			
			// type of address inputted that was geocoded
			if ( status == google.maps.GeocoderStatus.OK ) 
			{
				
				ShowLocation( results[0].geometry.location, address, addr_type,distance );
			
	   	var latitude = results[0].geometry.location.lat();
      var longitude = results[0].geometry.location.lng(); 
	  
 makeRequest('get_locations.php',latitude,longitude,distance, function(data) {
   
        var data = JSON.parse(data.responseText);
		
         
        for (var i = 0; i < data.length; i++) {
            displayLocation(data[i]);

			
        }
    });
	  
	  
	
				
			}
			else     
				alert("Geocode was not successful for the following reason: " + status);        
		});
	}
	
	
	
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
									 icon: 'http://maps.google.com/mapfiles/ms/icons/orange-dot.png'
								});
							   
								google.maps.event.addListener(marker, 'click', function() {
									infowindow.setContent(content);
									infowindow.open(map,marker);
								});
							}
							
							}
    
  
	}
}

var infowindow = new google.maps.InfoWindow();
	
	function makeRequest(url,latitude,longitude,distance,callback) 
	
	{
		
		var request;
				
				
				
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
	
	// Show the location (address) on the map.
	function ShowLocation( latlng, address, addr_type, distance )
	{
		// Center the map at the specified location
		map.setCenter( latlng );
		
		// Set the zoom level according to the address level of detail the user specified
	if(distance<10)
 {
 var zoom=15;
 }
 else if(distance<200)
 {
   var zoom=11;
 }
 else
 {
   var zoom=7;
 }
		
		map.setZoom( zoom );
		
		// Place a Google Marker at the same location as the map center 
		// When you hover over the marker, it will display the title
		var marker = new google.maps.Marker( { 
			position: latlng,     
			map: map,      
			title: address
		});
		
		// Create an InfoWindow for the marker
		var contentString = "" + address + "";	// HTML text to display in the InfoWindow
		var infowindow = new google.maps.InfoWindow( { content: contentString } );
		
		// Set event to display the InfoWindow anchored to the marker when the marker is clicked.
		google.maps.event.addListener( marker, 'click', function() { infowindow.open( map, marker ); });
	}
	
	// Call the method 'Init()' to display the google map when the web page is displayed ( load event )
	google.maps.event.addDomListener( window, 'load', Init );
	
	</script>
	<style>
	/* style settings for Google map */
	#map-canvas
	{
		width : 500px; 	/* map width */
		height: 500px;	/* map height */
	}
	</style>
	<link href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel='stylesheet'/>
<script src='//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js' type='text/javascript'></script>	
	
 <script>
$(document).ready(function(){
	
    $('#myTable').DataTable();
	
});
</script>  
	
	
</head>
<body> 
<div class="container">
	
	<div class="row">
	
	<div class="col-sm-3">
	<div class="panel panel-default">
		<div class="panel-heading">
		<div class="panel-title">All Sponsors</div>
		</div>
		<div class="panel-body"> 
		<div class="table-responsive" id="no-more-tables">
			<table class='table table-bordered table-striped table-condensed cf' id='myTable'>
			<thead>
			<tr><td></td></tr>
			</thead>
			<tbody>
				<?php $rows=mysql_query("select * from tbl_sponsorer ");
						while($result=mysql_fetch_array($rows)){
							if($result['sp_company']!=""){ ?>
				<tr><td title="<?=$result['sp_address'];?>"><?=$result['sp_company'];?></td></tr>
						<?php } } ?>	
			</tbody>
			</table>
		</div>
		</div>
	</div>
</div>

<div class="col-md-8" id="rewards-main-content" style=" margin-top: 2cm;"  >
<div>
		<label for="address"> Address:</label>
		<input type="text" id="address"/> &nbsp;&nbsp;
		<label for="address"> State:</label>	<input type="text" id="state"/> &nbsp;&nbsp;
		<label for="address"> Country:</label>	<input type="text" id="country"/> &nbsp;&nbsp;
	<label for="address"> Distance:</label>	
	
	<select name="distance" id="distance">
	<option value="2">2</option>
	<option value="5">5</option>
	<option value="10">10</option>
	<option value="20">50</option>
	<option value="100">100</option>
	<option value="200">200</option>
	<option value="300">300</option></select>
	
		<button onClick="UpdateMap()">Locate</button>
	</div><br/>

<div id='map-canvas' style="width: 100%; height: 450px;" ></div>
	

</div>

</div>
</div>


	<!-- Dislay Google map here -->
	
</body>
</html>