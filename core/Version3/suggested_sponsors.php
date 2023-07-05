<?php
$json = file_get_contents('php://input');
$obj = json_decode($json);
$format = 'json';
include 'conn.php';

$entity=xss_clean(mysql_real_escape_string($obj->{'entity'}));
$user_id=xss_clean(mysql_real_escape_string($obj->{'user_id'}));

$v_category=xss_clean(mysql_real_escape_string($obj->{'v_category'}));  
$lk_sp_lat=xss_clean(mysql_real_escape_string($obj->{'lk_sp_lat'}));
$lk_sp_long=xss_clean(mysql_real_escape_string($obj->{'lk_sp_long'}));

$lk_sp_country=xss_clean(addslashes($obj->{'lk_sp_country'}));
$lk_sp_state=xss_clean(addslashes($obj->{'lk_sp_state'}));
$lk_sp_city=xss_clean(addslashes($obj->{'lk_sp_city'}));


if($entity!='' and $user_id!=''){


	if($lk_sp_long==0 and $lk_sp_lat==0){		
		$address_selected=$lk_sp_city.", ".$lk_sp_state.", ".$lk_sp_country;	
		$prepAddr_selected = urlencode($address_selected);
		
		/* Author :- VaibhavG
		*	I've fire queries for checking country, state & city for entered invalid input as per the discussed with Android Developer Sayali Raghojiwar for Ticket Number SAND-1302.
		*/
		$countCountryQ =mysql_query("SELECT count(country_id) as count FROM tbl_country WHERE country='$lk_sp_country'");
		$countCountry=mysql_fetch_assoc($countCountryQ);
		$countStateQ =mysql_query("SELECT count(state_id) as count FROM tbl_state WHERE state='$lk_sp_state'");
		$countState=mysql_fetch_assoc($countStateQ);
		$countCityQ =mysql_query("SELECT count(city_id) as count FROM tbl_city WHERE district='$lk_sp_city' OR sub_district='$lk_sp_city' OR area='$lk_sp_city'");
		$countCity=mysql_fetch_assoc($countCityQ);
		if($countCountry['count']>=1 AND $countState['count']>=1 AND $countCity['count']>=1	AND $lk_sp_country!='' AND $lk_sp_state!='' AND $lk_sp_city!='')
		{
		//End Ticket Number SAND-1302.
			$geocode_selected=file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$prepAddr_selected.'&sensor=false&key=AIzaSyCsoxrWRL4sdXdF6LaucFAHpwHSLLbuSvY');
			$output_selected= json_decode($geocode_selected);
			$lat = $output_selected->results[0]->geometry->location->lat;
			$lon = $output_selected->results[0]->geometry->location->lng;	
		//Start Ticket Number SAND-1302.	
		}
		else	
		{
			$postvalue['responseStatus']=204;
			$postvalue['responseMessage']="No Response";
			$postvalue['posts']=null;
		//End Ticket Number SAND-1302.
		}
	}else{
		$lat=$lk_sp_lat;
		$lon=$lk_sp_long;
	}

	//////////// *****distance calculation query****** ////////	

	$distance_in_km = "ROUND( 111.111 * DEGREES(ACOS(COS(RADIANS(lat)) *										COS(RADIANS($lat)) * COS(RADIANS(lon - $lon)) +										SIN(RADIANS(lat)) * SIN(RADIANS($lat)))),2) AS distance_in_km";
	$having_order	= "HAVING distance_in_km <= 50 ORDER BY distance_in_km ASC ";

	//////////// *****End distance calculation query****** ////////
		/* Author :- VaibhavG
		*	Below I've changed v_status=Inactive & inserted user_member_id='$user_id' in where condition from Active to getting suggested sponsors as per the discussed with Android Developer Pooja Paramshetti for Ticket Number SAND-1275 31Aug18 4:00PM.
		*/
	if($v_category!='' or $v_category!=0){
		
		$WHERE =  "v_status='Inactive' AND v_category='$v_category' AND user_member_id='$user_id'";
	}else{
	 
		$WHERE =  "v_status='Inactive' AND user_member_id='$user_id'";
	}	
	
	$su =mysql_query("SELECT id,sp_name,v_category,sp_phone,sp_email,sp_address,sp_state,sp_city,sp_country,v_status,v_likes,lat,lon,(CASE WHEN (select count(*) from tbl_like_status where from_entity='$entity' and from_user_id='$user_id' and to_entity='4' and to_user_id=s.id) > 0 THEN 'liked' ELSE 'like' END) as like_status,$distance_in_km FROM tbl_sponsorer s WHERE $WHERE $having_order");	
	$posts = array();
	$iii=0;
	while($r=mysql_fetch_array($su)){
	
		$sp_id=$r['id'];	
		$sp_address=$r['sp_address'];
		$sp_name=$r['sp_name'];
		$v_category=$r['v_category'];
		$sp_email=isset($r['sp_email']) ? $r['sp_email'] : '';
		$v_likes=isset($r['v_likes']) ? $r['v_likes']: '';
		$v_status=isset($r['v_status']) ? $r['v_status'] : '';
		$kilometers=$r['distance_in_km'];
		$like_status=$r['like_status'];


				$posts[] =array("v_id"=>$sp_id,
					"v_name"=>$sp_name,
					"v_category"=>$v_category,
					"v_email"=>$sp_email,
					"v_address"=>$sp_address,
					"v_likes"=>$v_likes,
					"v_status"=>$v_status,
					"kilometers"=>$kilometers,
					"like_status"=>$like_status
					); 
					$iii++;
					
	}
	if($iii==0){
		$postvalue['responseStatus']=204;
		$postvalue['responseMessage']="No Response";
		$postvalue['posts']=null;
	}else{
		$postvalue['responseStatus']=200;
		$postvalue['responseMessage']="OK";
		$postvalue['posts']=$posts;	
	}

}else{
			$postvalue['responseStatus']=1000;
			$postvalue['responseMessage']="Invalid Input";
			$postvalue['posts']=null;
}		
 header('Content-type: application/json');
 echo json_encode($postvalue);						
						
  @mysql_close($con);
?>