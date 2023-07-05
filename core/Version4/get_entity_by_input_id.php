<?php
include '../conn.php';

$json = file_get_contents('php://input');
$obj = json_decode($json);

	//$input = $obj->{'input_id'};
	$limit = $obj->{'limit'};
	//$school_id = $obj->{'school_id'};
	$entity_name = $obj->{'entity_key'};
	
	switch($entity_name)
	{
		case 'Teachers': 
						 
							getdetails($obj->{'school_id'},$obj->{'input_id'},$entity_name,$limit);
							Break;
							
		case 'Non_Teachers':
							
							getdetails($obj->{'school_id'},$obj->{'input_id'},$entity_name,$limit);
							 Break;
	
		case 'Students': 
						 getdetails($obj->{'school_id'},$obj->{'input_id'},$entity_name,$limit);
						 Break;
						 
		case 'Parents': 
						 getdetails($obj->{'school_id'},$obj->{'input_id'},$entity_name,$limit);
						  Break;
						
		case 'Departments': 
							getdetails($obj->{'school_id'},$obj->{'input_id'},$entity_name,$limit);
							 Break;
							 
		case 'Branches':  
							getdetails($obj->{'school_id'},$obj->{'input_id'},$entity_name,$limit);
							Break;
						  
		case 'Semesters':
							getdetails($obj->{'school_id'},$obj->{'input_id'},$entity_name,$limit);
							Break;
						  
		case 'Classes': 
						getdetails($obj->{'school_id'},$obj->{'input_id'},$entity_name,$limit);
						 Break;
						 
		case 'Teacher_subjects': 
								getdetails($obj->{'school_id'},$obj->{'input_id'},$entity_name,$limit);
								  Break;
								  
		case 'Sponsors':  
							getdetails($obj->{'school_id'},$obj->{'input_id'},$entity_name,$limit);
							Break;
						  
		case 'Subjects':  
						  getdetails($obj->{'school_id'},$obj->{'input_id'},$entity_name,$limit);
						  Break;
						  
		case 'Student_Semester_Records': 
										 getdetails($obj->{'school_id'},$obj->{'input_id'},$entity_name,$limit);
										  Break;
										  
		case 'Student_Subjects': 
									getdetails($obj->{'school_id'},$obj->{'input_id'},$entity_name,$limit);
									Break;
		case 'CourseLevel': 
									getdetails($obj->{'school_id'},$obj->{'input_id'},$entity_name,$limit);
									Break;
		case 'Degree': 
									getdetails($obj->{'school_id'},$obj->{'input_id'},$entity_name,$limit);
									Break;
		case 'Division': 
									getdetails($obj->{'school_id'},$obj->{'input_id'},$entity_name,$limit);
									Break;
		case 'Academic_Year': 
									getdetails($obj->{'school_id'},$obj->{'input_id'},$entity_name,$limit);
									Break;										
		case 'Class_Subject': 
									getdetails($obj->{'school_id'},$obj->{'input_id'},$entity_name,$limit);
									Break;
		
		case 'Branch_Subject_Division_Year': 
									getdetails($obj->{'school_id'},$obj->{'input_id'},$entity_name,$limit);
									Break;										
									
		default:
							$postvalue['responseStatus']=204;
							$postvalue['responseMessage']="Invalid Entity name";
							$postvalue['posts']=null;
							header('Content-type: application/json');
							echo json_encode($postvalue);
							break;
		
	}
	
  



   
 
    function getdetails($school_id,$input,$entity_name,$limit)
	{
		
	//echo $limit;exit;
		if(!empty($school_id))
		{
				//$limit='All';
		             if($entity_name=='Teachers')  
					 {	 
					 	if($limit=='All')
					 	{
					 		$query="select * from tbl_teacher where (`t_emp_type_pid`=133 or `t_emp_type_pid`=134 or `t_emp_type_pid`=135 or `t_emp_type_pid`=137 ) and school_id='$school_id' ";
					 	}
					 	else
					 	{
						$query="select * from tbl_teacher where (`t_emp_type_pid`=133 or `t_emp_type_pid`=134 or `t_emp_type_pid`=135 or `t_emp_type_pid`=137) and school_id='$school_id' limit $limit offset $input";
						}
				  		$result = mysql_query($query) or die('Errant query:  '.$query);
					 }	
					  else if($entity_name=='Non_Teachers')  
					 {	
					    if($limit=='All')
					 	{
					 		$query="select * from tbl_teacher where `t_emp_type_pid`!=133 and `t_emp_type_pid`!=134 and school_id='$school_id'";
					 	}
					 	else
					 	{ 
						$query="select * from tbl_teacher where `t_emp_type_pid`!=133 and `t_emp_type_pid`!=134 and school_id='$school_id' limit $limit offset $input";
						}
				  		$result = mysql_query($query) or die('Errant query:  '.$query);
				  	    
					 }
					 else if($entity_name=='Students')  
					 {
					 	if($limit=='All')
					 	{
					 		$query="SELECT s.*,sr.sc_total_point FROM `tbl_student` s LEFT join tbl_student_reward sr on s.`std_PRN`=sr.sc_stud_id and s.`school_id`=sr.school_id WHERE s.school_id='$school_id'";
					 	}
					 	else
					 	{ 
						$query="SELECT s.*,sr.sc_total_point FROM `tbl_student` s LEFT join tbl_student_reward sr on s.`std_PRN`=sr.sc_stud_id and s.`school_id`=sr.school_id WHERE s.school_id='$school_id' limit $limit offset $input";
						}
				  		$result = mysql_query($query) or die('Errant query:  '.$query);
				     	
					 }
					 else if($entity_name=='Parents')  
					 {	 
					 	if($limit=='All')
					 	{
					 		$query="SELECT * FROM tbl_parent WHERE school_id='$school_id'";
					 	}
					 	else
					 	{ 
						$query="SELECT * FROM tbl_parent WHERE school_id='$school_id' limit $limit offset $input";
						}
				  		$result = mysql_query($query) or die('Errant query:  '.$query);
				  	    
					 }
					 else if($entity_name=='Departments')  
					 {	 
					 	if($limit=='All')
					 	{
					 		$query="select * from tbl_department_master where school_id='$school_id'";
					 	}
					 	else
					 	{ 
						$query="select * from tbl_department_master where school_id='$school_id' limit $limit offset $input";
						 }
				  		$result = mysql_query($query) or die('Errant query:  '.$query);
				  	    
					 }
					 else if($entity_name=='Branches')  
					 {	 
					 	if($limit=='All')
					 	{
					 		$query="select * from tbl_branch_master where school_id='$school_id'";
					 	}
					 	else
					 	{ 
						$query="select * from tbl_branch_master where school_id='$school_id' limit $limit offset $input";
						}
				  		$result = mysql_query($query) or die('Errant query:  '.$query);
				  	    
					 }
					 else if($entity_name=='Semesters')  
					 {	 
					 	if($limit=='All')
					 	{
					 		$query="select * from tbl_semester_master where school_id='$school_id'";
					 	}
					 	else
					 	{ 
						$query="select * from tbl_semester_master where school_id='$school_id' limit $limit offset $input";
						}
				  		$result = mysql_query($query) or die('Errant query:  '.$query);
				  	    
					 }
					 else if($entity_name=='Classes')  
					 {	 
					 	if($limit=='All')
					 	{
					 		$query="SELECT * FROM Class WHERE school_id='$school_id'";
					 	}
					 	else
					 	{ 
						$query="SELECT * FROM Class WHERE school_id='$school_id' limit $limit offset $input";
					    }
				  		$result = mysql_query($query) or die('Errant query:  '.$query);
				  	    
					 }
					 else if($entity_name=='Teacher_subjects')  
					 {	 
					 	if($limit=='All')
					 	{
					 		$query="select * from tbl_teacher_subject_master where school_id='$school_id'";
					 	}
					 	else
					 	{ 
						$query="select * from tbl_teacher_subject_master where school_id='$school_id' limit $limit offset $input";
						 }
				  		$result = mysql_query($query) or die('Errant query:  '.$query);
				  	   
					 }
					 else if($entity_name=='Sponsors')  
					 {	 
					 	if($limit=='All')
					 	{
					 		$query="select * from tbl_sponsorer";
					 	}
					 	else
					 	{ 
						$query="select * from tbl_sponsorer limit $limit offset $input";
					    }
				  		$result = mysql_query($query) or die('Errant query:  '.$query);
				  	    
					 }
					 else if($entity_name=='Subjects')  
					 {	 
					 	if($limit=='All')
					 	{
					 		$query="select * from tbl_school_subject where school_id='$school_id'";
					 	}
					 	else
					 	{ 
						$query="select * from tbl_school_subject where school_id='$school_id' limit $limit offset $input";
					    }
				  		$result = mysql_query($query) or die('Errant query:  '.$query);
					 }
					 else if($entity_name=='Student_Semester_Records')  
					 {	
					    if($limit=='All')
					 	{
					 		$query="SELECT * FROM StudentSemesterRecord WHERE school_id='$school_id'";
					 	}
					 	else
					 	{  
						$query="SELECT * FROM StudentSemesterRecord WHERE school_id='$school_id' limit $limit offset $input";
					    }
				  		$result = mysql_query($query) or die('Errant query:  '.$query);
					 }
					 else if($entity_name=='CourseLevel')  
					 {	
					    if($limit=='All')
					 	{
					 		$query="SELECT * FROM tbl_CourseLevel WHERE school_id='$school_id'";
					 	}
					 	else
					 	{  
						    $query="SELECT * FROM tbl_CourseLevel WHERE school_id='$school_id' limit $limit offset $input";
					    }
				  		$result = mysql_query($query) or die('Errant query:  '.$query);
					 }
					 else if($entity_name=='Degree')  
					 {	
					    if($limit=='All')
					 	{
					 		$query="SELECT * FROM tbl_degree_master WHERE school_id='$school_id'";
					 	}
					 	else
					 	{  
						$query="SELECT * FROM tbl_degree_master WHERE school_id='$school_id' limit $limit offset $input";
					    }
				  		$result = mysql_query($query) or die('Errant query:  '.$query);
					 }
					 else if($entity_name=='Division')  
					 {	 
					 	if($limit=='All')
					 	{
					 		$query="SELECT * FROM Division WHERE school_id='$school_id' ";
					 	}
					 	else
					 	{  
						$query="SELECT * FROM Division WHERE school_id='$school_id' limit $limit offset $input";
					    }
				  		$result = mysql_query($query) or die('Errant query:  '.$query);
					 }
					 else if($entity_name=='Academic_Year')  
					 {	
					    if($limit=='All')
					 	{
					 		$query="SELECT * FROM tbl_academic_Year WHERE school_id='$school_id'";
					 	}
					 	else
					 	{   
						$query="SELECT * FROM tbl_academic_Year WHERE school_id='$school_id' limit $limit offset $input";
					    }
				  		$result = mysql_query($query) or die('Errant query:  '.$query);
					 }
					 else if($entity_name=='Branch_Subject_Division_Year')  
					 {	 
					 	if($limit=='All')
					 	{
					 		$query="SELECT * FROM Branch_Subject_Division_Year WHERE school_id='$school_id'";
					 	}
					 	else
					 	{  
						$query="SELECT * FROM Branch_Subject_Division_Year WHERE school_id='$school_id' limit $limit offset $input";
					    }
				  		$result = mysql_query($query) or die('Errant query:  '.$query);
					 }
					 else if($entity_name=='Class_Subject')  
					 {	
					 if($limit=='All')
					 	{
					 		$query="SELECT * FROM tbl_class_subject_master WHERE school_id='$school_id'";
					 	}
					 	else
					 	{   
						$query="SELECT * FROM tbl_class_subject_master WHERE school_id='$school_id' limit $limit offset $input";
					    }
				  		$result = mysql_query($query) or die('Errant query:  '.$query);
					 }
					  else   
					 {	
						if($entity_name=='Student_Subjects')
						{
							if($limit=='All')
					 	{
					 		$query="select * from  tbl_student_subject_master where school_id='$school_id'";
					 	}
					 	else
					 	{ 
							$query="select * from  tbl_student_subject_master where school_id='$school_id' limit $limit offset $input";
						}
							$result = mysql_query($query) or die('Errant query:  '.$query);
					     }
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