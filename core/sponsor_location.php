<!DOCTYPE html>
<html>
  <head>
<?php
include("cookieadminheader.php");
//Comment include conn file to display map by Dhanashri 
//@include 'conn.php';

$a=$_GET['a'];
$b=$_GET['b'];
$sp=$_GET['sp'];

?>
<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Marker Labels</title>
    <style>
      html, body, #map-canvas {
        height: 100%;
        margin: 0;
        padding: 0px;
      }
	  #map-canvas{
		padding: 10px  10px 10px 10px;
		  
	  }

    </style>
	<!--Added Key for Bug No-3269-->
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true&key=AIzaSyCsoxrWRL4sdXdF6LaucFAHpwHSLLbuSvY"></script>
	<!--End-->
    <script>
	
// In the following example, markers appear when the user clicks on the map.
// Each marker is labeled with a single alphabetical character.
var labels = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
var labelIndex = 0;

function initialize() {
  var bangalore = { lat: <?php echo $a;?>, lng: <?php echo $b;?>};
  var map = new google.maps.Map(document.getElementById('map-canvas'), {
    zoom: 12,
    center: bangalore
  });

  // This event listener calls addMarker() when the map is clicked.
  google.maps.event.addListener(map, 'click', function(event) {
    addMarker(event.latLng, map);
  });

  // Add a marker at the center of the map.
  addMarker(bangalore, map);
}

// Adds a marker to the map.
function addMarker(location, map) {
  // Add the marker at the clicked location, and add the next-available label
  // from the array of alphabetical characters.
  var marker = new google.maps.Marker({
    position: location,
    label: labels[labelIndex++ % labels.length],
    map: map
  });
}

google.maps.event.addDomListener(window, 'load', initialize);

    </script>
  </head>
  <body>
   <a class="btn btn-primary" href="sponsor_sponsored.php" role="button" style="padding:10px 10px 10px 10px;" ><span style="color:#fff;"><-- Go Back</span></a>&nbsp;&nbsp;<b><?php echo $sp; ?></b>
    <div id="map-canvas"></div>
  </body>
</html>
 
