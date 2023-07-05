<?php  
$json = file_get_contents('php://input');
$obj = json_decode($json);
$format = 'json';
include 'conn.php';

$entity=xss_clean(mysql_real_escape_string($obj->{'entity'}));
$user_id=xss_clean(mysql_real_escape_string($obj->{'user_id'}));
$sp_name=xss_clean(mysql_real_escape_string($obj->{'sp_name'}));
$v_category=xss_clean(mysql_real_escape_string($obj->{'v_category'}));
$sp_phone=xss_clean(mysql_real_escape_string($obj->{'sp_phone'}));
$sp_email=xss_clean(mysql_real_escape_string($obj->{'sp_email'}));
$sp_address=xss_clean(mysql_real_escape_string($obj->{'sp_address'}));
$sp_city=xss_clean(mysql_real_escape_string($obj->{'sp_city'}));
$sp_state=xss_clean(mysql_real_escape_string($obj->{'sp_state'}));
$sp_country=xss_clean(mysql_real_escape_string($obj->{'sp_country'}));
$splat=xss_clean(mysql_real_escape_string($obj->{'splat'}));         	//Sponsor Lat Lat
$splon=xss_clean(mysql_real_escape_string($obj->{'splon'}));				//Sponsor Lat Lon
$lat=xss_clean(mysql_real_escape_string($obj->{'lat'}));				//Teacher/Student current Lat 
$lon=xss_clean(mysql_real_escape_string($obj->{'lon'}));			//Teacher/Student current Lon
$Vendor_Image=xss_clean(mysql_real_escape_string($obj->{'Vendor_Image'}));
$Vendor_Base64=xss_clean(mysql_real_escape_string($obj->{'Vendor_Base64'}));
$platform_source=xss_clean(mysql_real_escape_string($obj->{'platform_source'}));
$app_version=xss_clean(mysql_real_escape_string($obj->{'app_version'}));


$callat=0;
$callon=0;
/* author vaibhavg
	* inserted new query by vaibhvG as per the discussed with Avi Sir & Android Developer Priyanka Gole for ticket number SAND-1517.
	*/
$getSponsor = mysql_query("select count(id) as countsp from `tbl_sponsorer` where user_member_id=$user_id AND sp_company='$sp_name' AND `sp_name`='$sp_name' AND `v_category`='$v_category' AND `sp_phone`='$sp_phone' AND `sp_email`='$sp_email' AND `sp_address`='$sp_address' AND `sp_city`='$sp_city' AND `sp_state`='$sp_state' AND `sp_country`='$sp_country' ")or die(mysql_error());
$getSponsorCount=mysql_fetch_assoc($getSponsor);
if($getSponsorCount['countsp']==0)
{

// Start SMC-3450 Modify By Pravin 2018-09-21 01:40 PM
	/*if($sp_country=='India')
			{
				date_default_timezone_set("Asia/Calcutta");
				$dates = date("Y-m-d h:i:s A");
			}
	elseif($sp_country=='USA')
			{
				date_default_timezone_set("America/Boa_Vista");
				$dates = date("Y-m-d h:i:s A");
			}
			
	//Pravin Chopade Date changes 2017/07/26
	// if country is not comming
	else
	{
				date_default_timezone_set("Asia/Calcutta");
				$dates = date("Y-m-d h:i:s A");		
	}*/
	if($sp_country=='USA'){
		
		date_default_timezone_set("America/Boa_Vista");
		$dates = date("Y-m-d h:i:s");
	}
	else{
		$dates = CURRENT_TIMESTAMP;
	}
	//End SMC-3450

	if($sp_name!='' and $sp_address!='')
	{	
		if($Vendor_Image!='' and $Vendor_Base64!='')
		{
			$ex_img = explode(".",$Vendor_Image);
			$img_name = $ex_img[0]."_".date('Ymd');
		  
			$full_name_path = "image_sponsor/".$img_name.".".$ex_img[1];
			$imageName = "../".$full_name_path;
		  
			$source = imagecreatefromstring(base64_decode($Vendor_Base64));	
			$imageSave = imagejpeg($source,$imageName,100);
		}
		else
		{
			$full_name_path='';
		}	

		if($sp_address !='' && $sp_city !='' && $sp_state!='' && $sp_country!='')
		{
			
			$geocode_selected=file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.urlencode($sp_address.", ".$sp_city.", ".$sp_state.", ".$sp_country).'&sensor=false');
			$output_selected= json_decode($geocode_selected);
			 
			$callat = $output_selected->results[0]->geometry->location->lat;
			$callon = $output_selected->results[0]->geometry->location->lng;		
		}
		else
		{
			$postvalue['responseStatus']=204;
			$postvalue['responseMessage']="Invalid Address";
			$postvalue['posts']=null;
		}

		/* 	Author VaibhavG
			Below INSERT Query misplaced the position of latitude & longitude column. So, changed the place of latitude & longitude into insert query for ticket number SAND-1275 30Aug18 3:50PM
		*/
		$insert = mysql_query("INSERT INTO `tbl_sponsorer`(	sp_company,`id`, `sp_name`, `v_category`, `sp_phone`, `sp_email`, `sp_address`, `v_status`, `v_likes`,`sp_city`,`sp_state`,`sp_country`,`lat`,`lon`,`sales_p_lon`,`sales_p_lat`,`sp_img_path`,calculated_lat,calculated_lon,sp_date,platform_source,app_version,entity_id,user_member_id) VALUES ('$sp_name',NULL, '$sp_name', '$v_category', '$sp_phone', '$sp_email', '$sp_address', 'Inactive', '1', '$sp_city','$sp_state','$sp_country','$lat','$lon','$splon','$splat','$full_name_path','$callat','$callon','$dates','$platform_source','$app_version','$entity','$user_id') ")or die(mysql_error());

		if($entity==103)
		{
			$sq=mysql_query("select t_complete_name from tbl_teacher where id='$user_id'");
			$rows=mysql_fetch_assoc($sq);
			$uname=$rows['t_complete_name'];
		}
		elseif($entity==105)
		{
			$sq=mysql_query("select std_complete_name from tbl_student where id='$user_id'");
			$rows=mysql_fetch_array($sq);
			$uname=$rows['std_complete_name'];
			
		}
		else
		{
			$sq=mysql_query("select t_complete_name from tbl_teacher where id='$user_id'");
			$rows=mysql_fetch_array($sq);
			$uname=$rows['t_complete_name'];
			//echo"$uname";
		}

		//calling new web service
		$server_name = $GLOBALS['URLNAME'];
								
		$data = array('Action_Description'=>'suggest sponsor',
				'Actor_Mem_ID'=>$user_id,
				'Actor_Name'=>$uname,
				'Actor_Entity_Type'=>$entity,
				'Second_Receiver_Mem_Id'=>'',
				'Second_Party_Receiver_Name'=>'cookie Admin',
				'Second_Party_Entity_Type'=>113,
				'Third_Party_Name'=>'',
				'Third_Party_Entity_Type'=>'',
				'Coupon_ID'=>'',
				'Points'=>'',
				'Product'=>'$v_category',
				'Value'=>'',
				'Currency'=>''
		);
			
		$ch = curl_init("$server_name/core/Version2/master_action_log_ws.php"); 	
		
		
		$data_string = json_encode($data);    
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);      
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('ContentType: application/json','ContentLength: ' . strlen($data_string)));
		$result = json_decode(curl_exec($ch),true);
		
		//$result_mail = 'mail not sent';
		//
		$iid=mysql_insert_id();

		$ins_like=mysql_query("insert into tbl_like_status (id,from_entity,from_user_id,to_entity,to_user_id,active_status) values(null,'$entity','$user_id','4','$iid','0')")or die(mysql_error());
		$report="Suggested Sponsor succesfully";

				$posts[]=array('report'=>$report);
				$postvalue['responseStatus']=200;
				$postvalue['responseMessage']="OK";
				$postvalue['posts']=$posts;	

	}
	else
	{	
				$postvalue['responseStatus']=1000;
				$postvalue['responseMessage']="Invalid Input";
				$postvalue['posts']=null;
	}			
}			
else
{	
			$postvalue['responseStatus']=204;
			$postvalue['responseMessage']="Already Suggested Sponsor.";
			$postvalue['posts']=null;
}						
	header('Content-type: application/json');
	echo json_encode($postvalue);						
						
	@mysql_close($con);
		
?>