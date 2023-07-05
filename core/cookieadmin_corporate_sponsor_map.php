<?php
include_once('corporate_cookieadminheader.php');
if (!isset($_SESSION['id'])) {
    header('location:login.php');
}
//include 'conn.php';

	if (isset($_POST['submit']))
	{
		$Address = $_POST['Address'];
		if(empty($Address))
		{
			echo "<script>alert('Please enter any place name or address to check sponsors');window.location.href='cookieadmin_school_sponsor_map.php';</script>";
			exit;
		}
		$distance = $_POST['distance'];
		if($distance == '')
		{
			$distance = 2.00;
		}
		$address = str_replace(" ", "+", $Address);
		$json = file_get_contents("https://maps.google.com/maps/api/geocode/json?address=$address&sensor=false&key=AIzaSyCsoxrWRL4sdXdF6LaucFAHpwHSLLbuSvY");
	  
		$json= json_decode($json);
		$lat  = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
		$long = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};


		$distance_in_km = ", ROUND( 111.111 * DEGREES(ACOS(COS(RADIANS(s.lat)) *										COS(RADIANS($lat)) * COS(RADIANS(s.lon - $long)) +										SIN(RADIANS(s.lat)) * SIN(RADIANS($lat)))),2) AS distance_in_km";
	//$having_order	= "HAVING distance_in_km <= $distance ORDER BY distance_in_km DESC";
	$having_order	= "";
		if($distance ==1)
		{
			$zoom_value		= 17;
		}
		elseif($distance ==2)
		{
			$zoom_value		= 16;
		}
		elseif($distance == 5)
		{
			$zoom_value		= 15;
		}
		elseif($distance == 10)
		{
			$zoom_value		= 14;
		}
		elseif($distance == 20)
		{
			$zoom_value		= 13;
		}elseif($distance == 50)
		{
			$zoom_value		= 11;
		}elseif($distance == 100)
		{
			$zoom_value		= 10;
		}
	}
	else 
	{ 
		$lat			= "";
		$long			= "";
		$distance_in_km = "";
		$having_order	= "";
		$zoom_value		= 15;
	}

$SponsorResults = mysql_query("select s.id, s.sp_name, s.sp_address, s.sp_city, s.sp_company, s.sp_country, s.sp_email, s.sp_phone, s.lat, s.lon, s.v_category, s.sp_img_path, s.v_status, (select max(spd.discount) from tbl_sponsored spd where spd.sponsor_id=s.id group by spd.sponsor_id) as discount $distance_in_km FROM tbl_sponsorer s  where s.lat != ''and s.lon != '' $having_order ");
$data_array = array();
/* For Sponsors Data */
while ($row = mysql_fetch_assoc($SponsorResults)) {
    /* Each row is added as a new array */
    $data_array[] = $row;
    $res[] = $row;
/*Added $discount to display default value in discount*/
	$discount = (!empty($row['discount'])) ? $row['discount'] : "0";
    $locations[] = array(
        "title" => $row['sp_company'],
        "lat" => $row['lat'],
        "lng" => $row['lon'],
        "description" =>  "Shop Name : <b>" . $row['sp_company'] . "</b><br>Address : <b>" . $row['sp_address'] . "," . $row['sp_city'] . "," . $row['sp_country']."</b><br>Discount Percentage : <b>" .$discount   
    );
}
/*End*/
//print_r($locations); exit;
$markers = json_encode($locations);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Sponsor & College Tracking System</title>
</head>
<body>
<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCsoxrWRL4sdXdF6LaucFAHpwHSLLbuSvY&callback=initMap">
    </script>
<script >
</script>
<script type="text/javascript">
    var markers = <?php echo $markers;?>;
	var map, infoWindow;
    window.onload = function initMap() {
		infoWindow = new google.maps.InfoWindow();
		
        // When map display first time
        var mapOptions = {
            center: new google.maps.LatLng(markers[0].lat, markers[0].lng),
            zoom: <?php echo $zoom_value;?>,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
      
        var map = new google.maps.Map(document.getElementById("dvMap"));
		map.setZoom(<?php echo $zoom_value;?>);
		//map.setZoom(map.getZoom() + <?php echo $zoom_value;?>);// This will trigger a zoom_changed on the map
if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
			
			var lat = "<?php echo $lat ?>";
			var lon = "<?php echo $long ?>";
            
			if(!lat && !lon)
			{
				var lat = position.coords.latitude;
				var lon = position.coords.longitude;
			}
            map.setCenter(new google.maps.LatLng(lat, lon));
            
          });
        }
		else { 
        alert("Geolocation is not supported by this browser. Please enter your location details to find sponsors.");
		
		}

map.setMapTypeId(google.maps.MapTypeId.ROADMAP);
        function moveToLocation(lat, lng) {
            var center = new google.maps.LatLng(lat, lng);
            //map.panTo(center);
        }
        
        var lat_lng = new Array();
        var latlngbounds = new google.maps.LatLngBounds();
        var marker_length = markers.length;
        var end_marker_length = markers.length - 1;
        for (i = 0; i < markers.length; i++) {
            var data = markers[i];
            var myLatlng = new google.maps.LatLng(data.lat, data.lng);
            lat_lng.push(myLatlng);
            var x = data.title;
            if (x.match("^@SCH@")) {
                var iconBase = 'http://chart.apis.google.com/chart?chst=d_map_spin&chld=1|0|6FA804|18|_|SC';
            } else {
                var iconBase = 'http://chart.apis.google.com/chart?chst=d_map_spin&chld=1|0|CC7ED8|18|_|SP';
            }
            var maptitle = x.replace("@SCH@", "");
            var marker = new google.maps.Marker({
                position: myLatlng,
                map: map,
                icon: iconBase,
                title: maptitle,
            });
            latlngbounds.extend(marker.position);
            (function (marker, data) {
                google.maps.event.addListener(marker, "click", function (e) {
                    infoWindow.setContent(data.description);
                    infoWindow.open(map, marker);
                });
            })(marker, data);
        }
        //map.setCenter(latlngbounds.getCenter());
        //map.fitBounds(latlngbounds);
    }
</script>
<div class="container">
    <div class="page-header">
        <b><h2 style="text-align: center;"><font face="verdana" color="#3d004d">Sponsor & College Tracking System</font></h2></b>
    </div>
    <div class="panel panel-default" style="background-color:#694489;">
        <form method="POST">
            <div class="panel-body" style="background-color:#694489;">
                <div class="col-xs-2  input-group input-group-sm" id="locationField">
                    <input id="autocomplete" type="text" onFocus="geolocate()" name="Address" value="<?php if ($_POST['Address']) {echo $_POST['Address'];}?>" class="form-control" placeholder="Enter the address" style="width: 500px;">
                </div>
                <input id="getlat" type="hidden" name="getlat" value="<?php echo $latlong['lat']; ?>"
                       class="form-control" placeholder="lat">
                <input id="getlng" type="hidden" name="getlng" value="<?php echo $latlong['lng']; ?>"
                       class="form-control" placeholder="lan">
                <div class="col-xs-2  input-group input-group-sm" id="locationField"">
                    <div class="dropdown dropdown-dark">
                        <select name="distance" id="distance" class="dropdown-select" style="height: 30px; color: #0a819c;">
                            <option value="" selected>Distance</option>
                            <option value="1" <?php if($distance== "1") echo "selected"; ?>>1 KM</option>
                            <option value="2" <?php if($distance== "2") echo "selected"; ?>>2 KM</option>
                            <!-- <option value="3"  <?php if($distance== "3") echo "selected"; ?>>3 KM</option> -->
							<option value="5" <?php if($distance== "5") echo "selected"; ?>>5 KM</option>
                            <option value="10" <?php if($distance== "10") echo "selected"; ?>>10 KM</option>
                            <option value="20"  <?php if($distance== "20") echo "selected"; ?>>20 KM</option>
							<option value="50" <?php if($distance== "50") echo "selected"; ?>>50 KM</option>
                            <option value="100"  <?php if($distance== "100") echo "selected"; ?>>100 KM</option>
                        </select>
                    </div>
                </div>
                <div class="input-group-btn">
                    <button class="btn btn-primary" type="submit" name="submit"><i class="glyphicon glyphicon-search"></i></button>
                </div>
        </form>
    </div>
</div>
</div>
<div class="container">
    <div id="dvMap" style="width: 938px; height: 400px; margin-top: 20px;">
    </div>
    <script>
        function initAutocomplete() {
            autocomplete = new google.maps.places.Autocomplete(
                (document.getElementById('autocomplete')),
                {types: ['geocode']});
            autocomplete.addListener('place_changed', fillInAddress);
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCsoxrWRL4sdXdF6LaucFAHpwHSLLbuSvY&libraries=places&callback=initAutocomplete" async defer></script>
</body>
</html>


