<?php
include 'stud_header.php';
$id=$_SESSION['id'];

if(isset($_GET['set']))
{	$q=mysql_query("SELECT std_city, std_country, latitude, longitude, std_state FROM `tbl_student` WHERE `id`=\"$id\" ");
	$s=mysql_fetch_array($q);
	
	$country_selected=$s['std_country'];
	$state_selected=$s['std_state'];
	$city_selected=$s['std_city'];
	
	$latitude=$s['latitude'];
	$longitude=$s['longitude'];
	
	if($country_selected!=""){
	$address_selected=$city_selected.", ".$state_selected.", ".$country_selected;	
	$prepAddr_selected = urlencode($address_selected);
	$geocode_selected=file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$prepAddr_selected.'&sensor=false');
	$output_selected= json_decode($geocode_selected);
	$lat_selected = $output_selected->results[0]->geometry->location->lat;
	$long_selected = $output_selected->results[0]->geometry->location->lng;	
		
	setcookie("lat2", $lat_selected, time()+3600);
	setcookie("lon2", $long_selected, time()+3600);
	header("Location:student_coupon.php");	
	}elseif($latitude!=""){
	setcookie("lat2", $latitude, time()+3600);
	setcookie("lon2", $longitude, time()+3600);	
	header("Location:student_coupon.php");	
	}
}
?>
 <script>
 
function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else {
        alert("Geolocation is not supported by this browser.");
    }
}
function showPosition(position) {
    
	var string_url = "student_coupon.php?getlat="+position.coords.latitude+"&getlong="+position.coords.longitude;
	window.location = string_url;
}
</script>
<style>
.btn2{
	margin-left:10px;
}
</style>
<div class="container" style="padding-top:80px;" >

<a class="btn btn-primary progress-bar-striped" href="current_location.php?set=a">View Coupons By Address</a>
<button onClick="getLocation()" class="btn btn-primary progress-bar-striped btn2" >View Coupons By Current Location</button>
</div>