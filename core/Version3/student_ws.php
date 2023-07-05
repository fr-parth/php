<?php  
$json = file_get_contents('php://input');
$obj = json_decode($json);
$format = 'json';
include 'conn.php';
$arr="";
$msg="";
$school_id=$obj->{'school_id'};
$student_id=$obj->{'student_id'};

if($school_id!="" and $student_id!=""){

$stud=mysql_query("select * from tbl_student where std_PRN='$student_id' and `school_id`='$school_id'");
$i=mysql_fetch_array($stud);

$stud_id=$i['id'];
$std_city=$i['std_city'];
$std_state=$i['std_state'];
$std_country=$i['std_country'];


}else{
	$postvalue['responseStatus']=1000;
	$postvalue['responseMessage']="Invalid Input";
	$postvalue['posts']=null;

	header('Content-type: application/json');
	echo  json_encode($postvalue); 
	die;
}

//include($_SERVER['DOCUMENT_ROOT'].'/'.$db.'/smartcookiefunction.php');
//include 'smartcookiefunction.php';

function suggestSponsor($school_id,$student_id,$sp_name,$sp_cat,$sp_phone,$sp_email,$sp_add){
	if(!empty($sp_name)&&!empty($sp_cat)&&!empty($sp_phone)&&!empty($sp_add)){
	$likes=0;
	$msg="";
	$v_status='Inactive';
	$likes+=1;	
		
	$chkexi=mysql_query("select * from `tbl_vendor_suggested` where `v_name`=\"$sp_name\" and `v_category`=\"$sp_cat\" and `v_phone`=\"$sp_phone\" and `v_email`=\"$sp_email\" and `v_address`=\"$sp_add\"");
		if(mysql_affected_rows() > 0){
			
			$postvalue['responseStatus']=409;
			$postvalue['responseMessage']="Already suggested";
			$postvalue['posts']=null;		
			
		}else{
	
	$insert = mysql_query("INSERT INTO `tbl_vendor_suggested`(`id`, `v_name`, `v_category`, `v_phone`, `v_email`, `v_address`, `v_status`, `v_likes`) VALUES (NULL, \"$sp_name\", \"$sp_cat\", \"$sp_phone\", \"$sp_email\", \"$sp_add\", \"$v_status\", \"$likes\")");
	global $stud_id;
	$insert_likes=mysql_query("insert into tbl_like_status (id,from_entity,from_user_id,to_entity,to_user_id,active_status) values(null,'3','$stud_id','4','$likes','0')");
			$count1 = mysql_affected_rows();		
			if( $count1  >= 1 ){			
			
			$postvalue['responseStatus']=200;
			$postvalue['responseMessage']="OK";
			$postvalue['posts']=null;	
			
			}else{ 
			
			$postvalue['responseStatus']=204;
			$postvalue['responseMessage']="No Response";
			$postvalue['posts']=null;

			}
						
		}	}else{ 
		
			$postvalue['responseStatus']=1000;
			$postvalue['responseMessage']="Invalid Input";
			$postvalue['posts']=null;
		
		}
		return $postvalue;
}
function listSuggestedSponsor($school_id,$student_id,$lk_loc,$lk_sp_cat,$lk_sp_lat,$lk_sp_long,$lk_sp_country,$lk_sp_state,$lk_sp_city){
	
	
	//$lk_sp_cat,$lk_sp_lat,$lk_sp_long,$lk_sp_country,$lk_sp_state,$lk_sp_city
	$tc_check=0;
	if($lk_loc=='choosed'){		
		$address_selected=$lk_sp_city.", ".$lk_sp_state.", ".$lk_sp_country;	
		$prepAddr_selected = urlencode($address_selected);
		$geocode_selected=file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$prepAddr_selected.'&sensor=false');
		$output_selected= json_decode($geocode_selected);
		$lat2 = $output_selected->results[0]->geometry->location->lat;
		$lon2 = $output_selected->results[0]->geometry->location->lng;		
		
	}elseif($lk_loc=='addr'){
		global $std_city,$std_state,$std_country;
	$address_selected=$std_city.", ".$std_state.", ".$std_country;	
		$prepAddr_selected = urlencode($address_selected);
		$geocode_selected=file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$prepAddr_selected.'&sensor=false');
		$output_selected= json_decode($geocode_selected);
		$lat2 = $output_selected->results[0]->geometry->location->lat;
		$lon2 = $output_selected->results[0]->geometry->location->lng;
	}elseif($lk_loc=='curr'){
		$lat2=$lk_sp_lat;
		$lon2=$lk_sp_long;
	}
	
	if($lk_sp_cat==""){
	//id 	v_name 	v_category 	v_phone 	v_email 	v_address 	v_status 	v_likes
	$su =mysql_query("SELECT id,v_name,v_category,v_phone,v_email,v_address,v_status,v_likes FROM  tbl_vendor_suggested WHERE `v_status`='Inactive' ORDER BY id DESC");
	$count = mysql_num_rows($su);
	}else{
	$su =mysql_query("SELECT id,v_name,v_category,v_phone,v_email,v_address,v_status,v_likes FROM  tbl_vendor_suggested WHERE `v_status`='Inactive' and `v_category`=\"$lk_sp_cat\" ORDER BY id DESC");
	$count = mysql_num_rows($su);	
	}
	include 'distance.php';
	$posts = array();
	while($r=mysql_fetch_array($su)){
	//id 	v_name 	v_category 	v_phone 	v_email 	v_address 	v_status 	v_likes
	$v_id=$r['id'];
	$v_name=$r['v_name'];
	$v_category=$r['v_category'];
	$v_email=$r['v_email'];
	$v_address=$r['v_address'];	
	$v_likes=$r['v_likes'];	
	$v_status=$r['v_status'];		
		$prepAddr_selected = urlencode($v_address);
		$geocode_selected=file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$prepAddr_selected.'&sensor=false');
		$output_selected= json_decode($geocode_selected);
		$lat1 = $output_selected->results[0]->geometry->location->lat;
		$lon1 = $output_selected->results[0]->geometry->location->lng;
	
	$miles=calculateDistance($lat1, $lon1, $lat2, $lon2);
	$kilometers = "".($miles * 1.609344)."";
		global $stud_id;
		$l=mysql_query("select * from tbl_like_status where from_entity='3' and from_user_id='$stud_id' and to_entity='4' and to_user_id='$v_id' and active_status='0'"); 
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
	
		$postvalue['responseStatus']=200;
		$postvalue['responseMessage']="OK";
		$postvalue['posts']=$posts;	
}
function likeSuggestedSponsor($v_id){
	global $stud_id; 
	$l=mysql_query("select * from tbl_like_status where from_entity='3' and from_user_id='$stud_id' and to_entity='4' and to_user_id='$v_id' and active_status='0'");
	$rows=mysql_affected_rows();
	if($rows > 0){		
			$postvalue['responseStatus']=409;
			$postvalue['responseMessage']="Already liked";
			$postvalue['posts']=null;	
	}else{
		$p=mysql_query("update `tbl_vendor_suggested` set v_likes = v_likes + 1 where `id`='$v_id'");
		$q=mysql_query("insert into tbl_like_status (id,from_entity,from_user_id,to_entity,to_user_id,active_status) values(null,'3','$stud_id','4','$v_id','0')");	
		if($p and $q){		
			$postvalue['responseStatus']=200;
			$postvalue['responseMessage']="OK";
			$postvalue['posts']=null;	
		}else{
			$postvalue['responseStatus']=204;
			$postvalue['responseMessage']="No Response";
			$postvalue['posts']=null;
		}
	}
	return $postvalue;
}
if(function_exists($_GET['f'])){
	switch($_GET['f']) {
	case 'suggestSponsor':
		$postvalue=$_GET['f']($obj->{'school_id'},
						$obj->{'student_id'},
						$obj->{'sp_name'},
						$obj->{'sp_cat'},
						$obj->{'sp_phone'},
						$obj->{'sp_email'},
						$obj->{'sp_add'});
		break;
	case 'listSuggestedSponsor':
		$postvalue=$_GET['f']($obj->{'school_id'},$obj->{'student_id'},$obj->{'lk_loc'},$obj->{'lk_sp_cat'},$obj->{'lk_sp_lat'},$obj->{'lk_sp_long'},$obj->{'lk_sp_country'},$obj->{'lk_sp_state'},$obj->{'lk_sp_city'});

		break;
	case 'likeSuggestedSponsor':
		$postvalue=$_GET['f']($obj->{'v_id'});
		break;
	
	}  
}
						
 header('Content-type: application/json');
 echo json_encode($postvalue);						
						
  @mysql_close($con);
	
		
  ?>