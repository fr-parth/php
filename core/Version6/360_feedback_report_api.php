<?php
include '../conn.php';

//add space

$json = file_get_contents('php://input');
$obj = json_decode($json);

	$sc_id = $obj->{'school_id'};
	$limit = $obj->{'limit'};
	$t_id = $obj->{'teacher_id'};
	$entity_name = $obj->{'entity_key'};
	$years = $obj->{'academic_year'};

	switch($entity_name)
	{
		case 'teaching_process': 
						 
							getdetails($sc_id,$t_id,$years,$entity_name,$limit);
							Break;
							
		case 'departmental_activity':
							
                            getdetails($sc_id,$t_id,$years,$entity_name,$limit);
							 Break;
	
		case 'student_feedback': 
						    getdetails($sc_id,$t_id,$years,$entity_name,$limit);
						    Break;
						 
		case 'institute_activity': 
						    getdetails($sc_id,$t_id,$years,$entity_name,$limit);
						    Break;
						
		case 'ACR': 
							getdetails($sc_id,$t_id,$years,$entity_name,$limit);
							Break;
							 
		case 'society_contribution':  
							getdetails($sc_id,$t_id,$years,$entity_name,$limit);
							Break;
						  
		
									
		default:
							$postvalue['responseStatus']=204;
							$postvalue['responseMessage']="Invalid Entity name";
							$postvalue['posts']=null;
							header('Content-type: application/json');
							echo json_encode($postvalue);
							break;
		
	}
	
  



   
 
    function getdetails($sc_id,$t_id,$years,$entity_name,$limit)
	{
		
	//echo $limit;exit;
		if(!empty($sc_id))
		{
				//$limit='All';
		             if($entity_name=='teaching_process')  
					 {	 
					 	if($limit=='All')
					 	{
					 		$query="SELECT feed360_semester_ID, feed360_subject_code,feed360_classes_scheduled, feed360_actual_classes
                             FROM tbl_360feedback_template
                             WHERE feed360_school_id='$sc_id' and feed360_teacher_id='$t_id' ";
					 	}
					 	else
					 	{
						$query="SELECT feed360_semester_ID, feed360_subject_code,feed360_classes_scheduled, feed360_actual_classes
                        FROM tbl_360feedback_template
                        WHERE feed360_school_id='$sc_id' and feed360_teacher_id='$t_id' and feed360_academic_year_ID='$years' ";
						}
				  		$result = mysql_query($query) or die('Errant query:  '.$query);
                        //   print_r($query);
                          
					 }	
					  else if($entity_name=='departmental_activity')  
					 {	 
                        if($limit=='All')
                        {
                            $query="SELECT semester_name, activity_name,credit_point,criteria
                            FROM tbl_360_activities_data
                            WHERE schoolID='$sc_id' and Receiver_tID='$t_id' and activity_level_id='1'";
                        }
                        else
                        {
                            $query="SELECT semester_name, activity_name,credit_point,criteria
                              FROM tbl_360_activities_data
                              WHERE schoolID='$sc_id' and Receiver_tID='$t_id' and activity_level_id='1' and Academic_Year='$years' group by semester_name, activity_name";
                        }
						
				  		$result = mysql_query($query) or die('Errant query:  '.$query);
                        
					 }
					 else if($entity_name=='student_feedback')  
					 {
                        if($limit=='All')
                        {
                            $query="SELECT count(stu_feed_ID) as count ,stu_feed_semester_ID, stu_feed_academic_year,stud_subjcet_code,sum(stu_feed_points) as stu_feed_points
                            FROM tbl_student_feedback
                            WHERE stu_feed_school_id='$sc_id' and stu_feed_teacher_id='$t_id' group by stud_subjcet_code";
    
                        }
                        else
                        {
                            // $Years_4dig=substr($years,0,4);
                            $query ="SELECT count(stu_feed_ID) as count ,stu_feed_semester_ID, stu_feed_academic_year,stud_subjcet_code,sum(stu_feed_points) as stu_feed_points
                            FROM tbl_student_feedback
                            WHERE stu_feed_school_id='$sc_id' and stu_feed_teacher_id='$t_id' and stu_feed_academic_year='$years' group by stu_feed_semester_ID, stud_subjcet_code ";
                        }
                        
							$result = mysql_query($query) or die('Errant query:  '.$query);
					 }
					 else if($entity_name=='institute_activity')  
					 {	 
                        if($limit=='All')
                        {
                            $query="SELECT semester_name, activity_name,credit_point,criteria
                            FROM tbl_360_activities_data
                            WHERE schoolID='$sc_id' and Receiver_tID='$t_id' and activity_level_id='2' group by semester_name, activity_name";
                        }
                        else
                        {
                            $query="SELECT semester_name, activity_name,credit_point,criteria
                            FROM tbl_360_activities_data
                            WHERE schoolID='$sc_id' and Receiver_tID='$t_id' and activity_level_id='2' and Academic_Year='$years' group by semester_name, activity_name" ;
                        }
						
				  		$result = mysql_query($query) or die('Errant query:  '.$query);
					 }
					 else if($entity_name=='ACR')  
					 {	 
                        if($limit=='All')
                        {
                            $query="SELECT a.Academic_Year, a.activity_name,a.credit_point,a.criteria
                            FROM tbl_360_activities_data a join tbl_academic_Year y on a.schoolID=y.school_id and a.Academic_Year=y.Academic_Year
                            WHERE a.schoolID='$sc_id' and a.Receiver_tID='$t_id' and a.activity_level_id='4' group by a.activity_name";
                        }
                        else
                        {
                            $query="SELECT a.Academic_Year, a.activity_name,a.credit_point,a.criteria
                            FROM tbl_360_activities_data a join tbl_academic_Year y on a.schoolID=y.school_id and a.Academic_Year=y.Academic_Year
                            WHERE a.schoolID='$sc_id' and a.Receiver_tID='$t_id' and a.activity_level_id='4' and a.Academic_Year='$years' group by a.activity_name, a.Academic_Year";
                        }
                        
				  		$result = mysql_query($query) or die('Errant query:  '.$query);
                         
					 }
					 else if($entity_name=='society_contribution')  
					 {	 
                        if($limit=='All')
                        {
                            $query="SELECT semester_name, activity_name,credit_point,criteria
                            FROM tbl_360_activities_data
                            WHERE schoolID='$sc_id' and Receiver_tID='$t_id' and activity_level_id='3' group by activity_name";
                        }
                        else
                        {
                            $query="SELECT semester_name, activity_name,credit_point,criteria
                            FROM tbl_360_activities_data
                            WHERE schoolID='$sc_id' and Receiver_tID='$t_id' and activity_level_id='3' and Academic_Year='$years' group by semester_name, activity_name";
                        }

				  		$result = mysql_query($query) or die('Errant query:  '.$query);
					 }
					 
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