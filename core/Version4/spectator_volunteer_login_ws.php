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
		
		$format = 'json';
		
		if($mobile!='' and $password!='')
		{
			$sql=mysql_query("SELECT * FROM tbl_vol_spect_master 
							  WHERE mobile='$mobile' AND otp='$password'");
			
			$school_id='KI2019';		
			$sports=mysql_query("SELECT subject FROM tbl_school_subject WHERE school_id='$school_id'");
			
			while($result=mysql_fetch_array($sports)){
								
				$posts[] = array(
				'Sports Name'=>$result['subject']);
				
				
			}
			while($result1=mysql_fetch_array($sql)){
								
				$posts[] = array(
				'FullName'=>$result1['name'],
				'Points'=>$result1['reward_points']
				);
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
				
				$arr = mysql_query("select * from `tbl_LoginStatus` where EntityID='$memberID' and Entity_type='$entityType' ORDER BY `RowID` DESC ");
							
					if(mysql_num_rows($arr) == 0) {
					$LoginStatus = mysql_query("INSERT INTO `tbl_LoginStatus`(`EntityID`,`Entity_type`,`FirstLoginTime`,`FirstMethod`,`FirstDevicetype`, `FirstDeviceDetails`, `FirstPlatformOS`, `LatestLoginTime`, `LatestMethod`,  `LatestDeviceDetails`, `LatestPlatformOS`, `CountryCode`,`school_id`)
					VALUES ('$memberID','$entityType','$LatestLoginTime','$method','$FirstDevicetype','$LatestDeviceDetails','$LatestPlatformOS','$LatestLoginTime','$method','$LatestDeviceDetails','$LatestPlatformOS','$CountryCode','$school_id')");			
				
					}
	 
						$postvalue['responseStatus'] = 200;
						$postvalue['responseMessage'] = "OK";
						$postvalue['posts'] = $posts;
					
					

			}else {
				
				$postvalue['responseStatus'] = 204;
				$postvalue['responseMessage'] = "Mobile number not registered";
				$postvalue['posts'] = null;
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