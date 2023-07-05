<?php
/*
 * @auther  Rohit Pawar
 * @Date 28/09/2017
 * @Description-given Sponsor Latitude Longitude
 * @Contact- 9595512151<rohitp@roseland.com>
 *
 * */

include 'conn.php';

$SponsorResults = mysql_query("SELECT * FROM tbl_sponsorer where lat!='' AND lon!='' and v_responce_status='Interested'");
$row = mysql_num_rows($SponsorResults);

$locations = array();
/* For Sponsors Data */
while ($row = mysql_fetch_array($SponsorResults)) {
   
    $locations[] = array(
        "lat" => htmlentities($row['lat']),
        "lng" => htmlentities($row['lon']),
        "sp_name" => htmlentities($row['sp_name']),
        "sp_company" => htmlentities($row['sp_company']),
        "sp_address" => htmlentities($row['sp_address']),
        "sp_city" => htmlentities($row['sp_city']),
        "sp_country" => htmlentities($row['sp_country']),
        "sp_date" => htmlentities($row['sp_date']),
    );
}
if(!empty($locations)){
    $postvalue['responseStatus'] = 200;
    $postvalue['responseMessage'] = "OK";
    $postvalue['posts'] = $locations;
    header('Content-Type: application/json');
    echo json_encode($postvalue);
}else{
    $postvalue['responseStatus'] = 1000;
    $postvalue['responseMessage'] = "Invalid Input $row";
    $postvalue['posts'] = null;
    header('Content-Type: application/json');
    echo json_encode($postvalue);
}
?>