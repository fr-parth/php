<?php


function ip_details($ip) 
{
    $json = file_get_contents("http://ipinfo.io/{$ip}");
    $details = json_decode($json);
    return $details;
}

$details = ip_details($_SERVER['REMOTE_ADDR']);                          //ip_details(gethostbyaddr($_SERVER['REMOTE_ADDR']));

echo $details->city; echo "<br>"  ;  // => Mountain View
echo $details->country; echo "<br>"  ; 
echo $details->region; echo "<br>"  ;// => US
echo $details->org;     echo "<br>"  ; // => AS15169 Google Inc.
echo $details->hostname; echo "<br>" ;// => google-public-dns-a.google.com

echo $details->loc;  echo "<br>" ;
echo $details->ip; echo "<br>" ;
echo $details->postal; echo "<br>" ;
echo "<br>" ;


$loc=$details->loc;
$lat1=explode(",",$loc); // for Employee name
$latitude=$lat1[0];
$longitude=$lat1[1];


getPlaceName($latitude, $longitude);

function getPlaceName($latitude, $longitude)
{
   //This below statement is used to send the data to google maps api and get the place

   $geocode=file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?latlng='.$latitude.','.$longitude.'&sensor=false');

   
   $output= json_decode($geocode);
  
   //Here "formatted_address" is used to display the address in a user friendly format.
   echo $output->results[0]->formatted_address;
}






/*  $lok1 = $_REQUEST['lok1'];
 $lok2 = $_REQUEST['lok2'];

   $url = 'http://maps.google.com/maps/geo?q='.$lok2.','.$lok1.'&output=json';
    $data = file_get_contents($url);
    $jsondata = json_decode($data,true);

    if(is_array($jsondata )&& $jsondata ['Status']['code']==200)
    {
          $addr =  $jsondata ['Placemark'][0]['AddressDetails']['Country']['CountryName'];
          $addr2 = $jsondata ['Placemark'][0]['AddressDetails']['Country']['Locality']['LocalityName'];
          $addr3 = $jsondata ['Placemark'][0]['AddressDetails']['Country']['Locality']['DependentLocality']['DependentLocalityName'];
    }
    echo "Country: " . $addr . " | Region: " . $addr2 . " | City: " . $addr3;
	echo "<br>" ;
	echo "----------------------------";
	echo "<br>" ;
	
	$geocode=file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?latlng=$latitude,$longitude&sensor=false');

        $output= json_decode($geocode);

    for($j=0;$j<count($output->results[0]->address_components);$j++){
                echo '<b>'.$output->results[0]->address_components[$j]->types[0].': </b>  '.$output->results[0]->address_components[$j]->long_name.'<br/>';
            }
 */






			
/* $ip  = !empty($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
$url = "http://freegeoip.net/json/$ip";
$ch  = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
$data = curl_exec($ch);
curl_close($ch);

if ($data) {
    $location = json_decode($data);

    $lat = $location->latitude;
    $lon = $location->longitude;

    $sun_info = date_sun_info(time(), $lat, $lon);
    print_r($sun_info);
} */
/* function getPlaceName($latitude, $longitude)
{
   //This below statement is used to send the data to google maps api and get the place
 
   $geocode=file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?latlng='
                                         .$latitude.','.$longitude.'&sensor=false');

   
   $output= json_decode($geocode);

   //Here "formatted_address" is used to display the address in a user friendly format.
   print_r($output->results[0]->formatted_address);
} */

/* $address = "India";
$url = "http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false&region=India";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
$response = curl_exec($ch);
curl_close($ch);
$response_a = json_decode($response);
echo $lat = $response_a->results[0]->geometry->location->lat;
echo "<br />";
echo $long = $response_a->results[0]->geometry->location->lng; */
/* $url = "http://api.geonames.org/findNearbyPlaceNameJSON?lat=position.coords.latitude&lng=position.coords.longitude&username=demo";
$response = file_get_contents($url);
$response = json_decode($response, true);
 
print_r($response); */
 
/*$lat = $response['results'][0]['geometry']['location']['lat'];
$long = $response['results'][0]['geometry']['location']['lng'];
 
echo "latitude: " . $lat . " longitude: " . $long; */


?>

<!DOCTYPE html>
<html>
<body>

<p>Click the button to get your latitude and Longitude.</p>

<button onclick="getLocation()">Try It</button>

<p id="demo"></p>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
<div id="map_canvas" style="height:500px;width:600px;"></div>
<script>

var geocoder;
var map;
var infowindow = new google.maps.InfoWindow();

/* function to initialize the map */
function initialize() {
    geocoder = new google.maps.Geocoder();
    var latlng = new google.maps.LatLng(-34.397, 150.644);
    var mapOptions = {
        zoom: 10,
        center: latlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    }
    map = new google.maps.Map(document.getElementById('map_canvas'), mapOptions);
}

/* Geocoding based on address */
function codeAddress(address, title, imageURL) {
    geocoder.geocode({ 'address': address }, function (results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            map.setCenter(results[0].geometry.location);
            var marker = new google.maps.Marker({map: map,position: results[0].geometry.location,icon: imageURL,title: title});
			
            /* Set onclick popup */
			var infowindow = new google.maps.InfoWindow({content: title});
			google.maps.event.addListener(marker, 'click', function() {infowindow.open(marker.get('map'), marker);});
        } else {
            alert('Geocode was not successful for the following reason: ' + status);
        }
    });
}

/* Geocoding based on latitude and longitude */
function codeLatLng(latlng, title, imageURL) {
    var latlngStr = latlng.split(',', 2);
    var lat = parseFloat(latlngStr[0]);
    var lng = parseFloat(latlngStr[1]);
    var latlng = new google.maps.LatLng(lat, lng);
    geocoder.geocode({ 'latLng': latlng }, function (results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            if (results[1]) {
                map.setZoom(11);
                marker = new google.maps.Marker({position: latlng,map: map,icon: imageURL,title: title,content: title});
				
                /* Set onclick popup */
            	var infowindow = new google.maps.InfoWindow({content: title});
				google.maps.event.addListener(marker, 'click', function() {infowindow.open(marker.get('map'), marker);});
				
            } else {
                alert('No results found');
            }
        } else {
            alert('Geocoder failed due to: ' + status);
        }
    });
}



var x = document.getElementById("demo");

function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.watchPosition(showPosition);
    } else { 
        x.innerHTML = "Geolocation is not supported by this browser.";}
    }
    
function showPosition(position) {
    x.innerHTML="Latitude: " + position.coords.latitude + 
    "<br>Longitude: " + position.coords.longitude;	
	var level_var = document.getElementById(leve);
    var training_name_var = document.getElementById(name);
}

</script>




</body>
</html>
