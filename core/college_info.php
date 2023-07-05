<?php

/*
Author : Pranali Dalvi
Date : 17-4-20
This file was created for displaying college info based on selected college on Express Registration Web
*/
ob_end_clean();
include 'conn.php';

$group_id = $_POST['group_id'];
$school_name = $_POST['school_name'];
$school_id = $_POST['school_id'];

$sql = mysql_query("SELECT address,mobile,scadmin_country,scadmin_city,scadmin_state,school_type
    FROM tbl_school_admin 
    WHERE school_id = '$school_id' AND school_name = '$school_name' AND school_name!=''");

$res = mysql_fetch_array($sql);

$address = $res['address'];
$scadmin_country = $res['scadmin_country'];
$scadmin_city = $res['scadmin_city'];
$scadmin_state = $res['scadmin_state'];

$output= "
		
		<td>School ID :<br>School Name :<br>Address :</td>
		<td>$school_id <br> $school_name <br> $address, $scadmin_state, $scadmin_city</td>
          ";
echo $output;
?>