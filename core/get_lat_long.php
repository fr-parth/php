<?php
ini_set("max_execution_time", "-1");
ini_set("memory_limit", "-1");
ignore_user_abort(true);
set_time_limit(0);
include 'conn.php';
// function to get  the address
function get_lat_long($address)
{
    $address = str_replace(" ", "+", $address);
    $json = file_get_contents("http://maps.google.com/maps/api/geocode/json?address=$address");
    $json = json_decode($json);
    $lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
    $long = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
    $results=array(
        "lat" => "$lat",
        "lang" => "$long"
    );
    return $results;
}
$result = mysql_query("select inst_id,address,state,district from Institution_directory where calculated_lat IS NULL AND state='maharashtra' limit 1000");
echo mysql_num_rows($result);
while ($address = mysql_fetch_array($result)) {
    $id = $address['inst_id'];
    $state = $address['state'];
    $district = $address['district'];
    $add = $address['address'];
    $location=$state . " " . $district . " " . $add;
    if(!empty($location)){
        $latlong = get_lat_long($location);
        if(!empty($latlong)){
            echo '<pre>';
            $calculated_lat=$latlong['lat'];
            $calculated_lng=$latlong['lang'];
            if($calculated_lat!='' && $calculated_lng!='' ){
            echo "update Institution_directory set calculated_lat='$calculated_lat',calculated_lon='$calculated_lng' where inst_id='$id'";
            mysql_query("update Institution_directory set calculated_lat='$calculated_lat',calculated_lon='$calculated_lng' where inst_id='$id'");
            } //echo mysql_error();
        }else{
            echo "LatLong Not Fetched";
            echo '<br>';
        }
    }else{
        echo'<br>';
        echo "Address Not Founds";
        echo '<br>';
    }
}
mysql_close($con);
?>
