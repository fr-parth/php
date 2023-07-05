<?php  
$json = file_get_contents('php://input');
$obj = json_decode($json);
$format = 'json';
include 'conn.php';

$entity=$obj->{'entity'};
$user_id=$obj->{'user_id'};
$sp_name=$obj->{'sp_name'};
$v_category=$obj->{'v_category'};
$sp_phone=$obj->{'sp_phone'};
$sp_email=$obj->{'sp_email'};
$sp_address=$obj->{'sp_address'};
$sp_city=$obj->{'sp_city'};
$sp_state=$obj->{'sp_state'};
$sp_country=$obj->{'sp_country'};
$lat=$obj->{'lat'};
$lon=$obj->{'lon'};
$Vendor_Image=$obj->{'Vendor_Image'};
$Vendor_Base64=$obj->{'Vendor_Base64'};




if($sp_name!='' and $sp_address!=''){
	
if($Vendor_Image!='' and $Vendor_Base64!=''){
  $ex_img = explode(".",$Vendor_Image);
  $img_name = $ex_img[0]."_".date('mdY');
  
  $full_name_path = "image_sponsor/".$img_name.".".$ex_img[1];
  $imageName = "../".$full_name_path;
  
  $source = imagecreatefromstring(base64_decode($Vendor_Base64));	
  $imageSave = imagejpeg($source,$imageName,100);
}else{
	$full_name_path='';
}	

if($lat=='' or $lon==''){
	$geocode_selected=file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.urlencode($sp_address.", ".$sp_city.", ".$sp_state.", ".$sp_country).'&sensor=false');
	$output_selected= json_decode($geocode_selected);
	$lat = $output_selected->results[0]->geometry->location->lat;
	$lon = $output_selected->results[0]->geometry->location->lng;		
}

$insert = mysql_query("INSERT INTO `tbl_sponsorer`(`id`, `sp_name`, `v_category`, `sp_phone`, `sp_email`, `sp_address`, `v_status`, `v_likes`,`sp_city`,`sp_state`,`sp_country`,`lat`,`lon`,`sp_img_path`) VALUES (NULL, '$sp_name', '$v_category', '$sp_phone', '$sp_email', '$sp_address', 'Inactive', '1', '$sp_city','$sp_state','$sp_country','$lat','$lon','$full_name_path') ")or die(mysql_error());

$iid=mysql_insert_id();

$ins_like=mysql_query("insert into tbl_like_status (id,from_entity,from_user_id,to_entity,to_user_id,active_status) values(null,'$entity','$user_id','4','$iid','0')")or die(mysql_error());$report="Suggested Sponsor succesfully";
		$posts[]=array('report'=>$report);
			$postvalue['responseStatus']=200;
			$postvalue['responseMessage']="OK";
			$postvalue['posts']=$posts;	

}else{
		
			$postvalue['responseStatus']=1000;
			$postvalue['responseMessage']="Invalid Input";
			$postvalue['posts']=null;

}			
			
						
 header('Content-type: application/json');
 echo json_encode($postvalue);						
						
  @mysql_close($con);
	
		
  ?>