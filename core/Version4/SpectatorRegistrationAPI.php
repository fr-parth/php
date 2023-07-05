<?php  

$json = file_get_contents('php://input');
$obj = json_decode($json);
 $format = 'json';

include '../conn.php';

	$name=xss_clean(mysql_real_escape_string(@$obj->{'user_name'}));
  	$category=xss_clean(mysql_real_escape_string(@$obj->{'category'}));
	$mobile=xss_clean(mysql_real_escape_string(@$obj->{'mobile'}));
	$otp=xss_clean(mysql_real_escape_string(@$obj->{'password'}));

	
if(!empty($mobile) && !empty($name) && !empty($otp))
{
	$arr = mysql_query("select id from tbl_vol_spect_master where mobile='$mobile'");
	$count = mysql_num_rows($arr);
	
			if($count == 0)
			{
				
					$category='spectator';
				
				
				//$total_points=500;
				$reward_points=200;
			    $date = CURRENT_TIMESTAMP;
				$school_id='KI2019';
					$test = mysql_query("INSERT INTO `tbl_vol_spect_master` (name,category,mobile,otp,reward_points,registered_on,school_id) VALUES('$name','$category','$mobile','$otp','$reward_points','$date','$school_id')");

								
 				$postvalue['responseStatus']=200;
				$postvalue['responseMessage']="OK";
				
  

			}
			else
			{
				 $postvalue['responseStatus']=204;
				 $postvalue['responseMessage']="User already exists!";
				
			}

}
			else
			{
			
			    $postvalue['responseStatus']=1000;
				$postvalue['responseMessage']="Invalid Input";
				 
			   
			}
    header('Content-type: application/json');
	echo json_encode($postvalue);
	
@mysql_close($con); 
			
?>