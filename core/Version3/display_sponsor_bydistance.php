<?php 
 
//$json=$_GET ['json'];
$json = file_get_contents('php://input');
$obj = json_decode($json);

$format = 'json';  
include 'conn.php';
 
//input from user
   $std_latitude  = mysql_real_escape_string((float)$obj->{'std_latitude'});
   $std_longitude = mysql_real_escape_string((float)$obj->{'std_longitude'});
   $dist          = mysql_real_escape_string((int)$obj->{'distance'});
 
    
	function imageurl($value,$type='',$img=''){
			//$logoUrl=@get_headers(base_url('/Assets/images/sp/profile/'.$value));
			if($img=='sp_profile'){
				$path='sp/profile/';
			}elseif($img=='product'){
				$path='sp/productimage/';
			}elseif($img=='spqr'){
				$path='sp/coupon_qr/';
			}else{
				$path='';
			}
			$base_url=$GLOBALS['URLNAME'];		
			$logoUrl=@get_headers($base_url.'/Assets/images/'.$path.$value);
			
				if($type=='sclogo'){
					$logoexist=$base_url.'/Assets/images/sp/profile/newlogo.png';
				}elseif($type=='avatar'){
					$logoexist=$base_url.'/Assets/images/avatar/avatar_2x.png';
				}else{
					$logoexist=$base_url.'/Assets/images/sp/profile/imgnotavl.png';
				}
			return $logoexist;
		}
function calculateDistance($latitude1, $longitude1, $latitude2, $longitude2) {
    $theta = $longitude1 - $longitude2;
    $miles = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta)));
    $miles = acos($miles);
    $miles = rad2deg($miles);
    $miles = $miles * 60 * 1.1515;
    return $miles; 
}

function distanceCalculation($point1_lat, $point1_long, $point2_lat, $point2_long, $unit = 'km', $decimals = 2) {
	// Calculate the distance in degrees
	$degrees = rad2deg(acos((sin(deg2rad($point1_lat))*sin(deg2rad($point2_lat))) + (cos(deg2rad($point1_lat))*cos(deg2rad($point2_lat))*cos(deg2rad($point1_long-$point2_long)))));
 
	// Convert the distance in degrees to the chosen unit (kilometres, miles or nautical miles)
	switch($unit) {
		case 'km':
			$distance = $degrees * 111.13384; // 1 degree = 111.13384 km, based on the average diameter of the Earth (12,735 km)
			break;
		case 'mi':
			$distance = $degrees * 69.05482; // 1 degree = 69.05482 miles, based on the average diameter of the Earth (7,913.1 miles)
			break;
		case 'nmi':
			$distance =  $degrees * 59.97662; // 1 degree = 59.97662 nautic miles, based on the average diameter of the Earth (6,876.3 nautical miles)
			
	}
	return round($distance, $decimals);
}
	//include '../distance.php';
	
    	if( $std_latitude != "" &&  $std_longitude != "" && $dist!="")
	{
			//retrive info from tbl_school_subject
				$sql="select id,sp_company,sp_address,sp_city,sp_country,sp_email,sp_phone,lat,lon,v_category,sp_img_path,v_status from tbl_sponsorer where v_status='Active' or v_status is null";
				 $arr = mysql_query($sql)or die(mysql_error());  
             
  				/* create one master array of the records */
  			$posts = array();
  			if(mysql_num_rows($arr)>=1) {
    		while($test = mysql_fetch_assoc($arr)) {
					 
						 $lat2=@$test['lat'];
						 $lon2=@$test['lon'];
				 $sp_company=$test['sp_company'];
				 $sp_address=$test['sp_address'];
				
		
					$sp_city=$test['sp_city'];
					$sp_country=$test['sp_country'];
					$sp_email=$test['sp_email'];
					$sp_phone=$test['sp_phone'];
					$v_category=$test['v_category'];
				
					$sp_id=$test['id'];				
				
		
		if($lat2!='' and $lon2!='' and $lat2!=0 and $lon2!=0 and !empty($sp_company) and !empty($sp_address)){
			//$miles=calculateDistance($std_latitude, $std_longitude, $lat2, $lon2);
 $km = distanceCalculation($std_latitude, $std_longitude, $lat2, $lon2);
           
// Calculate distance in kilometres (default)			
			//$kilometers = $miles * 1.609344;
			//$distance=round($kilometers,1);
			//echo $km.'-'.$dist."<br/>";
			if($km <= (int)$dist ){
						
						$posts[]= array(
							'post'=>array('id'=>$sp_id,
							'sp_company'=>$sp_company,
							'sp_address'=>$sp_address,
							'sp_city'=>$sp_city,
							'sp_country'=>$sp_country,
							'sp_email'=>$sp_email,
							'sp_phone'=>$sp_phone,
							'lat'=>$lat2,
							'lon'=>$lon2,
							'distance'=>$km,
							'category'=>$v_category,
							'sp_img_path'=>imageurl($test['sp_img_path'],'sclogo','sp_profile')
						));
			}		
		}		
				
					
				$postvalue['responseStatus']=200;
				$postvalue['responseMessage']="OK";
				$postvalue['posts']=$posts;
      				
    			}
  			}
  			else
  				{
  				$postvalue['responseStatus']=204;
				$postvalue['responseMessage']="No Response";
				$postvalue['posts']=null;
  				}
  					/* output in necessary format */
  					
  					if($format == 'json') {
    					header('Content-type: application/json');
    					 echo json_encode($postvalue);
  					}
 				 else {
   				 		header('Content-type: text/xml');
    					echo '';
   					 	foreach($posts as $index => $post) {
     						 if(is_array($post)) {
       							 foreach($post as $key => $value) {
        							  echo '<',$key,'>';
          								if(is_array($value)) {
            								foreach($value as $tag => $val) {
              								echo '<',$tag,'>',htmlentities($val),'</',$tag,'>';
            											}
         									}
         							  echo '</',$key,'>';
        						}
      						}
    				}
   			 echo '';
 				 }
		} 
	else
			{
			 $postvalue['responseStatus']=1000;
				$postvalue['responseMessage']="Invalid Input";
				$postvalue['posts']=null;
			  
			  header('Content-type: application/json');
   			  echo  json_encode($postvalue); 
			}	
			
			
			
 
  /* disconnect from the db */
  @mysql_close($link);	
	
		
  ?>
