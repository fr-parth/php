<?php
include('cookieadminheader.php');

$lat=$_GET['lat'];
//$lat="18.5074";
$long=$_GET['long'];
//$long="73.8077";
?>
<!DOCTYPE html>
<html>
<body>

<h1>Map</h1>

<div id="map" style="width:100%;height:500px"></div>

<script>
     var lat=<?php echo $lat;?>;
     var long=<?php echo $long;?>;

//     alert(lat);
//     alert(long);
     function myMap() {
         var myCenter = new google.maps.LatLng(lat,long);
         var mapCanvas = document.getElementById("map");
         var mapOptions = {center: myCenter, zoom: 18};
         var map = new google.maps.Map(mapCanvas, mapOptions);
         var marker = new google.maps.Marker({position:myCenter});
         marker.setMap(map);

         // Zoom to 9 when clicking on marker
         google.maps.event.addListener(marker,'click',function() {
             map.setZoom(50);
             map.setCenter(marker.getPosition());
         });
     }
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBnem-OEoDqydxHe0TjLdQNgei5yQcnDS8&callback=myMap"></script>
<!--
To use this code on your website, get a free API key from Google.
Read more at: https://www.w3schools.com/graphics/google_maps_basic.asp
-->

</body>
</html>
