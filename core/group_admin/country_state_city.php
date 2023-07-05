<?php
/*
Author: Sayali Balkawade
Date :  2021/01/02
This file was created for country, state ,city dependent list.
*/
ob_end_clean();
include('../conn.php');

if($_POST['c_id'] !='')
{
$countryid=$_POST['c_id'];
$sql= "SELECT * FROM tbl_state where country_id='$countryid' order by state asc";
$query =mysql_query($sql);

$output = "<option value=''>Select State</option>";
if(mysql_num_rows($query)>0){
	//echo "in if";
	while($row= mysql_fetch_array($query)){
		$output .="<option value='".$row['state_id']."'>".$row['state']."</option>";
	}
}
echo $output;
}
if($_POST['s_id'] !='')
{
$s_id=$_POST['s_id'];
$sql= "SELECT * FROM tbl_city where state_id='$s_id' and  sub_district!='' group by sub_district order by sub_district asc";
$query =mysql_query($sql);

$output = "<option value=''>Select City  Name</option>";
if(mysql_num_rows($query)>0){
	//echo "in if";
	while($row= mysql_fetch_array($query)){
		$output .="<option value='".$row['sub_district']."'>".$row['sub_district']."</option>";
	}
}
echo $output;
}

?>