<?php  

$json = file_get_contents('php://input');
$obj = json_decode($json);
 $format = 'json';

include '../conn.php';

	$name=xss_clean(mysql_real_escape_string(@$obj->{'user_name'}));
  	$category=xss_clean(mysql_real_escape_string(@$obj->{'category'}));
	$mobile=xss_clean(mysql_real_escape_string(@$obj->{'mobile'}));
	$otp=xss_clean(mysql_real_escape_string(@$obj->{'password'}));
	$school_id=xss_clean(mysql_real_escape_string(@$obj->{'school_id'}));
	
	//As per approval of Amit Welangi Sir, added extra parameter school_id , validated the same and added 409 responseStatus by Pranali for SMC-3734 on 24-01-2019
if(!empty($mobile) && !empty($name) && !empty($otp) && !empty($school_id))
{
	$validateSchool=mysql_query("SELECT school_id FROM tbl_school_admin where school_id='$school_id'");
	$validateSchool1=mysql_fetch_assoc($validateSchool);
	$SchoolID=$validateSchool1['school_id'];
	if($school_id==$SchoolID)
	{
		
	$arr = mysql_query("select id from tbl_vol_spect_master where mobile='$mobile' and school_id='$school_id'");
	$count = mysql_num_rows($arr);
	
			if($count == 0)
			{
//case added for parent and coach as approval of Avi Sir by Pranali for SMC-3734
				if($category=='' || $category=='spectator' || $category=='Spectator'){
					$category='spectator';
				}
				else if($category=='volunteer' || $category=='Volunteer'){
					$category='volunteer';
				}
				else if($category=='coach' || $category=='Coach'){
					$category='coach';
				}
				else if($category=='parent' || $category=='Parent'){
					$category='parent';
				}
				else if($category=='player' || $category=='Player'){
					$category='player';
				}
				
				//$total_points=500;
				$reward_points=200;
			    $date = CURRENT_TIMESTAMP;
				//$school_id='KI2019';
				
							
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
	else{
		$postvalue['responseStatus']=409;
		$postvalue['responseMessage']="Please enter valid School Id!";
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