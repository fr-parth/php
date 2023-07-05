<?php
/*
Author: Sayali Balkawade
Date : 19-1-2021
This file was created for display country state city for SMC-5111
*/
ob_end_clean();
include('../core/conn.php');



if($_POST['c_id'] !='')
{
$c_id=$_POST['c_id'];
$ss=$_POST['ss'];
$url =$GLOBALS['URLNAME']."/core/Version5/city_state_list.php";
//$url = "https://dev.smartcookie.in/core/Version5/city_state_list.php";
	$data = array("keyState"=>'',"country"=>$c_id, "state"=>'' );
		
		$ch = curl_init($url);             
		$data_string = json_encode($data);    
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);      
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data_string)));
		$country_ar = json_decode(curl_exec($ch),true); 
		
$output = "<option value=".$ss.">".$ss."</option>";

	foreach($country_ar['posts'] as $res){ 
	
		$output .="<option value='".$res['state_name']."'>".$res['state_name']."</option>";
	}
	
echo $output;
}

if($_POST['s_id'] !='')
{
$s_id=$_POST['s_id'];
echo $stu_state=$_POST['stu_state'];
$sts=$_POST['sts'];
$url = $GLOBALS['URLNAME']."/core/Version5/city_state_list.php";
//$url = "https://dev.smartcookie.in/core/Version5/city_state_list.php";
	$data = array("keyState"=>'',"country"=>'', "state"=>$s_id );
		
		$ch = curl_init($url);             
		$data_string = json_encode($data);    
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);      
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data_string)));
		$country_ar = json_decode(curl_exec($ch),true); 
		
   $output = "<option value=".$sts.">".$sts."</option>";

	foreach($country_ar['posts'] as $res){ 
		if($res['city_sub_district'] ==$stu_state){
		$output .="<option value='".$res['city_sub_district']."' selected >".$res['city_sub_district']."</option>";
	}else{
		$output .="<option value='".$res['city_sub_district']."'  >".$res['city_sub_district']."</option>";
	}
	}
echo $output;
}

?>