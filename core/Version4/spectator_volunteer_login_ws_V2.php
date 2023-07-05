<?php 
/* 
Author : Pranali Dalvi
Date : 04-01-2019
This web service is created for Spectator One Time Login and Display Sports List 
*/
$json = file_get_contents('php://input');
$obj = json_decode($json);

include '../conn.php';

		$mobile=xss_clean(mysql_real_escape_string(@$obj->{'mobile'}));
		$password = xss_clean(mysql_real_escape_string($obj->{'password'}));
		$school_id=xss_clean(mysql_real_escape_string(@$obj->{'school_id'}));
		$format = 'json';
		
		//As per approval of Amit Welangi Sir, added extra parameter school_id , validated the same and added 409 responseStatus by Pranali for SMC-3734 on 24-01-2019
		
		if($mobile!='' && $password!='' && $school_id!='')
		{
			$validateSchool=mysql_query("SELECT school_id FROM tbl_school_admin where school_id='$school_id'");
			$validateSchool1=mysql_fetch_assoc($validateSchool);
			$SchoolID=$validateSchool1['school_id'];
			
			if($school_id==$SchoolID)
			{
			$sql=mysql_query("SELECT * FROM tbl_vol_spect_master 
							  WHERE mobile='$mobile' AND otp='$password' AND school_id='$school_id'");
			
			//$school_id='KI2019';		
			$sports=mysql_query("SELECT subject FROM tbl_school_subject WHERE school_id='$school_id'");
			
			while($result=mysql_fetch_array($sports)){
								
				$posts[] = array(
				'Sports Name'=>$result['subject']);
				
				
			}
				$pquery = mysql_query("select SUM(no_of_points) AS points FROM game_master WHERE mobile_no='$mobile' AND school_id='$school_id'");
				$pqrow = mysql_fetch_assoc($pquery); 
                $sum = $pqrow['points'];
				if($sum > 0){
					$sum = $sum;
				}else{
					$sum = 0;
				}
			while($result1=mysql_fetch_array($sql)){
								
				$posts[] = array(
				'FullName'=>$result1['name'],
				'Points'=>$sum,
				'Category'=>$result1['category']);
				$memberID=$result1['id'];
			}
		//if only one spectator exist for given mobile no	
			if(mysql_num_rows($sql) == 1) 
			{
				
				$entityType='119'; // Entity type for Spectator is 119
				$LatestLoginTime = CURRENT_TIMESTAMP;
				$FirstDevicetype='Android Phone';
				$CountryCode='91';
				$LatestPlatformOS='Unknown device';
				$LatestDeviceDetails='Android';
				$method='Android';
				
				$arr = mysql_query("select * from `tbl_LoginStatus` where EntityID='$memberID' and Entity_type='$entityType' and school_id='$school_id' ORDER BY `RowID` DESC ");
							
					if(mysql_num_rows($arr) == 0) {
					$LoginStatus = mysql_query("INSERT INTO `tbl_LoginStatus`(`EntityID`,`Entity_type`,`FirstLoginTime`,`FirstMethod`,`FirstDevicetype`, `FirstDeviceDetails`, `FirstPlatformOS`, `LatestLoginTime`, `LatestMethod`,  `LatestDeviceDetails`, `LatestPlatformOS`, `CountryCode`,`school_id`)
					VALUES ('$memberID','$entityType','$LatestLoginTime','$method','$FirstDevicetype','$LatestDeviceDetails','$LatestPlatformOS','$LatestLoginTime','$method','$LatestDeviceDetails','$LatestPlatformOS','$CountryCode','$school_id')");			
				
					}
	 
						$postvalue['responseStatus'] = 200;
						$postvalue['responseMessage'] = "OK";
						$postvalue['posts'] = $posts;
						$postvalue['MemberID'] = $memberID;
						$postvalue['school_id'] = $school_id;

			}else {
				
				$postvalue['responseStatus'] = 204;
				$postvalue['responseMessage'] = "Mobile number not registered";
				$postvalue['posts'] = null;
			}
		}
		else{
		$postvalue['responseStatus']=409;
		$postvalue['responseMessage']="Please enter valid School Id!";
	}
	/* output in necessary format */
    if ($format == 'json') {
        header('Content-type: application/json');
        echo json_encode($postvalue);
    } else {
        header('Content-type: text/xml');
        echo '';
        foreach ($posts as $index => $post) {
            if (is_array($post)) {
                foreach ($post as $key => $value) {
                    echo '<', $key, '>';
                    if (is_array($value)) {
                        foreach ($value as $tag => $val) {
                            echo '<', $tag, '>', htmlentities($val), '</', $tag, '>';
                        }
                    }
                    echo '</', $key, '>';
                }
            }
        }
        echo '';
      }
	}
		else {

		$postvalue['responseStatus'] = 1000;
		$postvalue['responseMessage'] = "Invalid Input";
		$postvalue['posts'] = null;

		header('Content-type: application/json');
		echo json_encode($postvalue);

		}
@mysql_close($con);

?>