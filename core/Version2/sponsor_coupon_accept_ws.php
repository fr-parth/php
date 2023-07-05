<?php
$json = file_get_contents('php://input');
$obj = json_decode($json);

include 'conn.php';

$sponsor_cp_id=xss_clean(mysql_real_escape_string($obj->{'sponsor_cp_id'}));
$sp_id=xss_clean(mysql_real_escape_string($obj->{'sp_id'}));

if(!empty($sponsor_cp_id) && !empty($sp_id)){

$accepted=mysql_query("UPDATE tbl_selected_vendor_coupons SET `used_flag`='used' WHERE `id`='$sponsor_cp_id' and sponsor_id='$sp_id'");
	if($accepted){
				$msg='Accepted';
				$postvalue['responseStatus']=200;
				$postvalue['responseMessage']="OK";
				$postvalue['posts']=$msg;
	
	}else{
				$postvalue['responseStatus']=204;
				$postvalue['responseMessage']="No Response";
				$postvalue['posts']=null;
	}
}else{
				$postvalue['responseStatus']=1000;
				$postvalue['responseMessage']="Invalid Input";
				$postvalue['posts']=null;

	
}

			  
			  header('Content-type: application/json');
   			  echo  json_encode($postvalue); 
		
?>