<?php

include '../conn.php';
error_reporting(0);
$json = file_get_contents('php://input');
header('Content-type: application/json');
$obj = json_decode($json);

$GroupID = xss_clean(mysql_real_escape_string($obj->{'GroupID'}));
$SchoolID = xss_clean(mysql_real_escape_string($obj->{'SchoolID'}));
$Academic_Year = xss_clean(mysql_real_escape_string($obj->{'Academic_Year'}));
$Semester_Type = xss_clean(mysql_real_escape_string($obj->{'Semester_Type'}));

	if($GroupID != "" && $SchoolID !="" && $Academic_Year!='' && $Semester_Type!='')
	{		
		$upload_status = mysql_query("SELECT sa.school_name,sd.*,dw.weightage 
						FROM tbl_school_datacount sd
					  	JOIN tbl_datafile_weightage dw 
					  	ON sd.tbl_name=dw.tbl_name
					  	JOIN tbl_school_admin sa
						ON sd.school_id=sa.school_id
					 	WHERE sd.school_id='".$SchoolID."' AND sd.academic_year='".$Academic_Year."' AND sd.semister_type='".$Semester_Type."'");

		$count = mysql_num_rows($upload_status);
		$posts = array();
		while($post = mysql_fetch_assoc($upload_status))
		{
			$posts[] = $post;
		}
	            $postvalue['responseStatus']=200;
				$postvalue['responseMessage']="OK";
				$postvalue['count']=$count;
				$postvalue['posts']=$posts;
   				echo  json_encode($postvalue);

	}
	else
	{
		$postvalue['responseStatus']=1000;
		$postvalue['responseMessage']="Invalid Input";
		$postvalue['posts']=null;
		echo  json_encode($postvalue);
	}
?>