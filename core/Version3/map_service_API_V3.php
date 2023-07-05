<?php
include 'conn.php';
$json = file_get_contents('php://input');
$obj = json_decode($json);
error_reporting(0);

 $lat = xss_clean(mysql_real_escape_string($obj->{'lat'}));
 $long = xss_clean(mysql_real_escape_string($obj->{'long'}));
 $entity_type = xss_clean(mysql_real_escape_string($obj->{'entity_type'})); //school/sponsor
 $range = xss_clean(mysql_real_escape_string($obj->{'range'}));//range in int
  $range_km = sprintf("%.2f", $range);
	if($range == '')
	{
		$range_km = 2.00;
	}
 $range_type = xss_clean(mysql_real_escape_string($obj->{'range_type'}));//1-miles and 0-km
 $loc_type = xss_clean(mysql_real_escape_string($obj->{'loc_type'})); // custome/current
 $place_name = xss_clean(mysql_real_escape_string($obj->{'place_name'}));
 $input = xss_clean(mysql_real_escape_string($obj->{'input_id'}));
//Start SMC-3480 Pagination
 $offset = xss_clean(mysql_real_escape_string($obj->{'offset'}));//for pagination
 $map_limit = xss_clean(mysql_real_escape_string($obj->{'map'}));//for map limit
 //map_check_limit function call from core/securityfunctions.php
  $limit=map_check_limit($map_limit);
 //offset function call from core/securityfunctions.php
  $offset=offset($offset);//default offset = "0"

 $site=$GLOBALS['URLNAME']; /*check URL HTTP OR HTTPS and check environment eg Dev, Test, 
                            Production */

//////////// *****Validation for Empty****** ////////

	if(empty($loc_type) || empty($entity_type))
	{
		$postvalue['responseStatus']=1000;
		$postvalue['responseMessage']="Invalid Input";
		$postvalue['posts']=null;
		encode_values($postvalue);
	}

//////////// *****Get latitude & longitude for custom address****** ////////

	if($loc_type=='CUSTOM')
	{
		$address = str_replace(" ", "+", $place_name);
		$json = file_get_contents("https://maps.google.com/maps/api/geocode/json?address=$address&sensor=false&key=AIzaSyCsoxrWRL4sdXdF6LaucFAHpwHSLLbuSvY");
	  
		$json= json_decode($json);
		$lat  = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
		$long = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
	}

//////////// *****distance calculation query****** ////////	

	$distance_in_km = "ROUND( 111.111 * DEGREES(ACOS(COS(RADIANS(s.lat)) * COS(RADIANS($lat)) * COS(RADIANS(s.lon - $long)) + SIN(RADIANS(s.lat)) * SIN(RADIANS($lat)))),2) AS distance_in_km";
	$having_order	= "HAVING distance_in_km <= $range_km ORDER BY distance_in_km ASC";
	
	if($entity_type=='SPONSOR')
	{
		$query = "select s.id, s.sp_name, s.sp_address, s.sp_city, s.sp_company, s.sp_country, s.sp_email, s.sp_phone, s.lat, s.lon, s.v_category, s.sp_img_path, s.v_status, (select max(spd.discount) from tbl_sponsored spd where spd.sponsor_id=s.id group by spd.sponsor_id) as discount,$distance_in_km FROM tbl_sponsorer s WHERE s.v_status='Active' $having_order  LIMIT $limit OFFSET $offset";
		//$limit call from core/securityfunctions.php
		//End SMC-3480
      	$arr   = mysql_query($query); 
		$count = mysql_num_rows($arr);
		
		if($count==0 && $arr ) 
		{
			if($offset==0)
			{
				
				$postvalue['responseStatus']=204;
				$postvalue['responseMessage']="No Record found";
				$postvalue['posts']=null;
			}else
				{
				
				$postvalue['responseStatus']=224;
				$postvalue['responseMessage']="End of Records";
				$postvalue['posts']=null;
				}
			
			encode_values($postvalue);
		}									
		elseif($count > 0)
		{

			while($test = mysql_fetch_assoc($arr))
			{
				$sp_name	=	$test['sp_name'];
				$shop_name	=	$test['sp_company'];
				$sp_address	=	$test['sp_address'];
				$sp_city	=	$test['sp_city'];
				$sp_country	=	$test['sp_country'];
				$sp_email	=	$test['sp_email'];
				$sp_phone	=	$test['sp_phone'];
				$v_category	=	$test['v_category'];
				$sp_id		=	$test['id'];
				$lat2		=	$test['lat'];
				$lon2		=	$test['lon'];
				$distance	=	$test['distance_in_km'];

					if($test['sp_img_path']!='')
					{
						$image_path=$site."/core/".$test['sp_img_path'];
					}
					else
					{
						$image_path=$site."/Assets/images/avatar/avatar_2x.png";	
					}
						$posts[]= array(
						'id'=>$sp_id,
						'sp_name'=>$sp_name,
						'shop_name'=>$shop_name,
						'sp_address'=>isset($sp_address) ? $sp_address : '',
						'sp_city'=>isset($sp_city) ? $sp_city : '',
						'sp_country'=>isset($sp_country) ? $sp_country : '',
						'sp_email'=>isset($sp_email) ? $sp_email : '',
						'sp_phone'=>isset($sp_phone) ? $sp_phone : '',
						'lat'=>$lat2,
						'lon'=>$lon2,
						'distance'=>$distance,
						'max_discount'=>isset($discount) ? $discount : '0',
						'category'=>isset($v_category) ? $v_category : '',
						'sp_img_path'=>$image_path
						//'count'=>$count
						);
			 
			}
			$postvalue['responseStatus']=200;
			$postvalue['responseMessage']="Ok";
			$postvalue['posts']=$posts;
			encode_values($postvalue);
		}
		
		else
		{

			$postvalue['responseStatus']=204;
			$postvalue['responseMessage']="No Response";
			$postvalue['posts']=null;
			encode_values($postvalue);
		}
	}
	//SMC-3480 Modify by Pravin 2018-10-03
	else if($entity_type=='SCHOOL')
	{
		 $query ="select id, name, email, school_name, school_id,address, DTECode, stream, CountryCode, mobile,lat,lon,scadmin_city, scadmin_country,scadmin_state, group_type, group_name,img_path,$distance_in_km from tbl_school_admin s $having_order  LIMIT $limit OFFSET $offset";
		
		
		$arr   = mysql_query($query); 
		$count = mysql_num_rows($arr);
		
		if($count==0) 
		{
			if($offset==0)
			{
				$postvalue['responseStatus']=204;
				$postvalue['responseMessage']="No Record found";
				$postvalue['posts']=null;
				encode_values($postvalue);
			}else
				{
				
				$postvalue['responseStatus']=224;
				$postvalue['responseMessage']="End of Records";
				$postvalue['posts']=null;
				encode_values($postvalue);
				}
			
			
		}									
		elseif($count > 0)
		{

			while($test = mysql_fetch_assoc($arr))
			{
				$id				=	$test['id'];
				$name			=	$test['name'];
				$email			=	$test['email'];
				$school_name	=	$test['school_name'];
				$school_id		=	$test['school_id'];
				$DTECode		=	$test['DTECode'];
				$stream			=	$test['stream'];
				$CountryCode	=	$test['CountryCode'];
				$address		=	$test['address'];
				$scadmin_city	=	$test['scadmin_city'];
				$scadmin_state	=	$test['scadmin_state'];
				$scadmin_country=	$test['scadmin_country'];
				$group_type		=	$test['group_type'];
				$group_name		=	$test['group_name'];
				$mobile			=	$test['mobile'];
				$lat2			=	$test['lat'];
				$lon2			=	$test['lon'];
				$distance		=	$test['distance_in_km'];
				

					if($test['img_path']!='')
					{
						$image_path=$site."/core/".$test['img_path'];
					}
					else
					{
						$image_path=$site."/Assets/images/avatar/avatar_2x.png";	
					}
						$posts[]= array(
						'id'=>$id,
						'admin_name'=>$name,
						'school_name'=>$school_name,
						'school_id'=>$school_id,
						'address'=>isset($address) ? $address : '',
						'scadmin_city'=>isset($scadmin_city) ? $scadmin_city : '',
						'scadmin_country'=>isset($scadmin_country) ? $scadmin_country : '',
						'email'=>isset($email) ? $email : '',
						'mobile'=>isset($mobile) ? $mobile : '',
						'lat'=>$lat2,
						'lon'=>$lon2,
						'distance'=>$distance,
						'img_path'=>$image_path
						);
			 
			}
			$postvalue['responseStatus']=200;
			$postvalue['responseMessage']="Ok";
			$postvalue['posts']=$posts;
			encode_values($postvalue);
		}
		else
		{

			$postvalue['responseStatus']=204;
			$postvalue['responseMessage']="No Response";
			$postvalue['posts']=null;
			encode_values($postvalue);
		}
		
		
	}// End SMC-3480
	else
		{

			$postvalue['responseStatus']=204;
			$postvalue['responseMessage']="Entity Type Invalid";//SMC-3480
			$postvalue['posts']=null;
			encode_values($postvalue);
		}

function encode_values($postvalue)
{
	header('Content-Type: application/json');
	echo json_encode($postvalue);
}
@mysql_close($con);
?>