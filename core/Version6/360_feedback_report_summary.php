<?php
include '../conn.php';
$json = file_get_contents('php://input');
$obj = json_decode($json);

	$sc_id = $obj->{'school_id'};
	// $limit = $obj->{'limit'};
	$t_id = $obj->{'teacher_id'};
	$student_subject_code = $obj->{'stud_subjcet_code'};
	$student_semester = $obj->{'stu_feed_semester_ID'};
	$years = $obj->{'academic_year'};

	
							 
		 
	getdetails($sc_id,$t_id,$student_subject_code,$student_semester,$years);

 
    function getdetails($sc_id,$t_id,$student_subject_code,$student_semester,$years)
	{
		
	//echo $limit;exit;
		if(!empty($sc_id))
		{

						$query = "SELECT stu_feed_que_id,stu_feed_que, avg(stu_feed_points) as avgpoints
						FROM tbl_student_feedback 
						where stu_feed_school_id = '$sc_id' and stu_feed_teacher_id='$t_id'
						and  stu_feed_semester_ID = '$student_semester' and stud_subjcet_code = '$student_subject_code' and stu_feed_academic_year = '$years'
						group by stu_feed_que_ID";
						$result = mysql_query($query);
						// $res = mysql_fetch_array($sql);
					
		            
					 
						/* create one master array of the records */
						$posts = array();
						if(mysql_num_rows($result)>=1) 
						{
							while($post = mysql_fetch_assoc($result))
							{
							$posts[] = $post;
							
							}
							$postvalue['responseStatus']=200;
							$postvalue['responseMessage']="OK";
							$postvalue['posts']=$posts;
							header('Content-type: application/json');
							echo json_encode($postvalue);
						}else
						{
							
							$postvalue['responseStatus']=204;
							$postvalue['responseMessage']="Not Found";
							$postvalue['posts']=null;
							header('Content-type: application/json');
							echo json_encode($postvalue);
						}
							


		}else
			{

			   $postvalue['responseStatus']=1000;
				$postvalue['responseMessage']="Invalid Input";
				$postvalue['posts']=null;

			  header('Content-type: application/json');
   			  echo  json_encode($postvalue); 
			  
			
			}

	
   					
  
  
  	}
		
	 
  @mysql_close($con);

?>