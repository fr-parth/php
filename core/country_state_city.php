<?php
include'conn.php';
require_once("dbcontroller.php");
$db_handle = new DBController();

if(xss_clean(mysql_real_escape_string(!empty($_POST["country_keyword"])))) {	
	$countrykeyword = xss_clean(mysql_real_escape_string($_POST["country_keyword"]));
$query_c="SELECT country FROM `tbl_country` where country like '" . $countrykeyword . "%' and is_enabled='1' ORDER BY country ASC LIMIT 0,6";

$result = $db_handle->runQuery($query_c);
if(!empty($result)) {
		echo "<ul id='state-list'>";
		foreach($result as $countries) {	?>
<li onClick="selectCountry('<?php echo xecho($countries["country"]); ?>');"><?php echo xecho($countries["country"]); ?></li>
<?php }
		echo "</ul>";
}else{
	echo "<ul id='state-list'><li>Enter Valid Country</li></ul>";
} 
}

if(xss_clean(mysql_real_escape_string(!empty($_POST["state_keyword"])))) {
	$c=xss_clean(mysql_real_escape_string($_POST['c']));	
	
	$sid=mysql_query("select country_id from tbl_country where country='$c'");
	$stid=mysql_fetch_array($sid);
	$country_id=$stid['country_id'];
	$statekeyword=xss_clean(mysql_real_escape_string($_POST["state_keyword"]));
	$query ="SELECT state FROM tbl_state WHERE state like '" . $statekeyword . "%' and country_id='$country_id' ORDER BY state ASC LIMIT 0,6";
	$result = $db_handle->runQuery($query);
	if(!empty($result)) {
		echo "<ul id='state-list'>";
		foreach($result as $states) {	?>
<li onClick="selectState('<?php echo xecho($states["state"]); ?>');"><?php echo xecho($states["state"]); ?></li>
<?php }
		echo "</ul>";
}else{
	echo "<ul id='state-list'><li>Enter Valid State</li></ul>";
} 
} 
 

if(xss_clean(mysql_real_escape_string(!empty($_POST["city_keyword"])))) {
	$s=xss_clean(mysql_real_escape_string($_POST['s']));
	$c=xss_clean(mysql_real_escape_string($_POST['c']));	
	
	$sid=mysql_query("select country_id from tbl_country where country='$c'");
	$stid=mysql_fetch_array($sid);
	$country_id=$stid['country_id'];	

$sid=mysql_query("select state_id from tbl_state where state='$s' and country_id='$country_id'");
$stid=mysql_fetch_array($sid);
$state_id=$stid['state_id'];

$citykeyword = xss_clean(mysql_real_escape_string($_POST["city_keyword"]));
$query ="SELECT distinct sub_district FROM tbl_city WHERE sub_district like '" . $citykeyword . "%' and state_id='$state_id' and country_id='$country_id' ORDER BY sub_district ASC LIMIT 0,6";
$result = $db_handle->runQuery($query);

if(!empty($result)) {
	echo "<ul id='city-list'>";
	foreach($result as $city) {
?>
<li onClick="selectCity('<?php echo xecho($city["sub_district"]); ?>');"><?php echo xecho($city["sub_district"]); ?></li>
<?php } 
echo "</ul>";
}else{
	echo "<ul id='state-list'><li>Enter Valid City</li></ul>";
}
} ?>
