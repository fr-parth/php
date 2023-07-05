<?php
$json = file_get_contents('php://input');
$obj = json_decode($json);


$lk_user_id=$obj->{'user_id'};
$lk_entity_id=$obj->{'entity'};
$lk_sp_cat=$obj->{'lk_sp_cat'};
$lk_sp_lat=$obj->{'lk_sp_lat'};
$lk_sp_long=$obj->{'lk_sp_long'};
$lk_sp_country=$obj->{'lk_sp_country'};
$lk_sp_state=$obj->{'lk_sp_state'};
$lk_sp_city=$obj->{'lk_sp_city'};

include 'conn.php';
if($lk_entity_id=="" or $lk_user_id==""){
	
	$postvalue['responseStatus']=1000;
	$postvalue['responseMessage']="Invalid Input";
	$postvalue['posts']=null;
	
	header('Content-type: application/json');
	echo  json_encode($postvalue);
	die;
}
if($lk_sp_lat=="" and $lk_sp_country==""){
	$postvalue['responseStatus']=1000;
	$postvalue['responseMessage']="Location Required";
	$postvalue['posts']=null;
	
	header('Content-type: application/json');
	echo  json_encode($postvalue); 
	die;
}
if(($lk_sp_lat!="" and $lk_sp_country!="") or $lk_sp_lat!=""){
	$lat2=$lk_sp_lat;
	$lon2=$lk_sp_long;	
}
if($lk_sp_country!="" and $lk_sp_lat==""){
	$addr=$lk_sp_city.", ".$lk_sp_state.", ".$lk_sp_country;
	$add= urlencode($addr);
	$geocode_selected=file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$add.'&sensor=false');
	$output_selected= json_decode($geocode_selected);			
	$lat2 = $output_selected->results[0]->geometry->location->lat;
	$lon2 = $output_selected->results[0]->geometry->location->lng;	
}

	
if($lk_sp_cat==""){
	$su =mysql_query("SELECT id,v_name,v_category,v_phone,v_email,v_address,v_status,v_likes FROM  tbl_vendor_suggested WHERE `v_status`='Inactive' ORDER BY id DESC");
	$count = mysql_num_rows($su);
}else{
	$su =mysql_query("SELECT id,v_name,v_category,v_phone,v_email,v_address,v_status,v_likes FROM  tbl_vendor_suggested WHERE `v_status`='Inactive' and `v_category`=\"$lk_sp_cat\" ORDER BY id DESC");
	$count = mysql_num_rows($su);	
}
	while($r=mysql_fetch_array($su)){
	//id 	v_name 	v_category 	v_phone 	v_email 	v_address 	v_status 	v_likes

	$v_address=$r['v_address'];	
		
	$geocode_selected=file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.urlencode($v_address).'&sensor=false');
	$output_selected= json_decode($geocode_selected);
	$lat1 = $output_selected->results[0]->geometry->location->lat;
	$lon1 = $output_selected->results[0]->geometry->location->lng;
	
	//$miles=calculateDistance($lat1, $lon1, $lat2, $lon2);
	$theta = $lon1 - $lon2;
	$miles = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
	$miles = acos($miles);
	$miles = rad2deg($miles);
	$miles = $miles * 60 * 1.1515;
	$kilometers = $miles * 1.609344;		
	if($kilometers <= 100){
		$v_likes=$r['v_likes'];	
		$v_status=$r['v_status'];
		$v_id=$r['id'];
		$v_name=$r['v_name'];
		$v_category=$r['v_category'];
		$v_email=$r['v_email'];
		
	$l=mysql_query("select id from tbl_like_status where from_entity='$lk_entity_id' and from_user_id='$lk_user_id' and to_entity='4' and to_user_id='$v_id' and active_status='0'"); 
	$liked = mysql_affected_rows();
			if($liked > 0 ){
					$like_status='liked';
			}else{
					$like_status='like';
			}
	$posts[] =array("v_id"=>$v_id,
					"v_name"=>$v_name,
					"v_category"=>$v_category,
					"v_email"=>$v_email,
					"v_address"=>$v_address,
					"v_likes"=>$v_likes,
					"v_status"=>$v_status,
					"kilometers"=>$kilometers,
					"like_status"=>$like_status
					); 
		}
	}
$postvalue['responseStatus']=200;
$postvalue['responseMessage']="OK";
$postvalue['posts']=$posts;
	
			  header('Content-type: application/json');
   			  echo  json_encode($postvalue); 

@mysql_close($con);

?>