<?php 
/* 
Author : Pranali Dalvi
Date : 07-01-2019
This web service is created for Displaying Players List according to received Sport Name  
*/
$json = file_get_contents('php://input');
$obj = json_decode($json);

include '../conn.php';
$format = 'json';
	$sportName=xss_clean(mysql_real_escape_string(@$obj->{'sportName'}));
	$school_id=xss_clean(mysql_real_escape_string(@$obj->{'school_id'}));
	//School ID added by Pranali
	if($sportName!='')
	{
		//$school_id='KI2019';
		$player = mysql_query("SELECT distinct s.std_complete_name 
		FROM tbl_student_subject_master ssm 
		JOIN tbl_student s 
		ON ssm.student_id=s.std_PRN AND ssm.school_id=s.school_id 
		where ssm.school_id='$school_id' 
		AND ssm.subjectName='$sportName' AND s.std_complete_name!=''"); 
	
		if(mysql_num_rows($player) > 0) 
		{
			while($result1=mysql_fetch_array($player)){
								
				$posts[] = array(
				'PlayerName'=>$result1['std_complete_name']);
				
			}
	
		$postvalue['responseStatus'] = 200;
        $postvalue['responseMessage'] = "OK";
        $postvalue['posts1'] = $posts;
		}
		else{
			$postvalue['responseStatus'] = 204;
			$postvalue['responseMessage'] = "No Records Found";
			$postvalue['posts1'] = null;
		}
		 
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
    $postvalue['posts1'] = null;

    header('Content-type: application/json');
    echo json_encode($postvalue);


}
@mysql_close($con);

?>
