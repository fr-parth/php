<?php  

$json = file_get_contents('php://input');
$obj = json_decode($json);

	//$input = $obj->{'input_id'};
	//$school_id = $obj->{'school_id'};
	$entity_name = $obj->{'entity_key'};
	include 'conn.php';



	switch($entity_name)
	{
		case 'Teachers': 
						 
							getdetails($obj->{'school_id'},$obj->{'input_id'},$entity_name);
							Break;
							
		case 'Non_Teachers':
							
							getdetails($obj->{'school_id'},$obj->{'input_id'},$entity_name);
							 Break;
	
		case 'Students': 
						 getdetails($obj->{'school_id'},$obj->{'input_id'},$entity_name);
						 Break;
						 
		case 'Parents': 
						 getdetails($obj->{'school_id'},$obj->{'input_id'},$entity_name);
						  Break;
						
		case 'Departments': 
							getdetails($obj->{'school_id'},$obj->{'input_id'},$entity_name);
							 Break;
							 
		case 'Branches':  
							getdetails($obj->{'school_id'},$obj->{'input_id'},$entity_name);
							Break;
						  
		case 'Semesters':
							getdetails($obj->{'school_id'},$obj->{'input_id'},$entity_name);
							Break;
						  
		case 'Classes': 
						getdetails($obj->{'school_id'},$obj->{'input_id'},$entity_name);
						 Break;
						 
		case 'Teacher_subjects': 
								getdetails($obj->{'school_id'},$obj->{'input_id'},$entity_name);
								  Break;
								  
		case 'Sponsors':  
							getdetails($obj->{'school_id'},$obj->{'input_id'},$entity_name);
							Break;
						  
		case 'Subjects':  
						  getdetails($obj->{'school_id'},$obj->{'input_id'},$entity_name);
						  Break;
						  
		case 'Student_Semester_Records': 
										 getdetails($obj->{'school_id'},$obj->{'input_id'},$entity_name);
										  Break;
										  
		case 'Student_Subjects': 
									getdetails($obj->{'school_id'},$obj->{'input_id'},$entity_name);
									Break;
									
		default:
							$postvalue['responseStatus']=204;
							$postvalue['responseMessage']="Invalid Entity name";
							$postvalue['posts']=null;
							header('Content-type: application/json');
							echo json_encode($postvalue);
							break;
		
	}
	
  



   
 
    function getdetails($school_id,$input,$entity_name)
	{
		
	
		if(!empty($school_id))
		{
			if($input==0)
			{	
		             if($entity_name=='Teachers')  
					 {	 
						$query="select * from tbl_teacher where (`t_emp_type_pid`=133 or `t_emp_type_pid`=134 ) and school_id='$school_id' limit 10 offset $input";
				  		$result = mysql_query($query) or die('Errant query:  '.$query);
					 }	
					  else if($entity_name=='Non_Teachers')  
					 {	 
						$query="select * from tbl_teacher where `t_emp_type_pid`!=133 and `t_emp_type_pid`!=134 and school_id='$school_id' limit 10 offset $input";
				  		$result = mysql_query($query) or die('Errant query:  '.$query);
					 }
					 else if($entity_name=='Students')  
					 {	 
						$query="select * from tbl_student where school_id='$school_id' limit 10 offset $input";
				  		$result = mysql_query($query) or die('Errant query:  '.$query);
					 }
					 else if($entity_name=='Parents')  
					 {	 
						$query="SELECT * FROM tbl_parent WHERE school_id='$school_id' limit 10 offset $input";
				  		$result = mysql_query($query) or die('Errant query:  '.$query);
					 }
					 else if($entity_name=='Departments')  
					 {	 
						$query="select * from tbl_department_master where school_id='$school_id' limit 10 offset $input";
				  		$result = mysql_query($query) or die('Errant query:  '.$query);
					 }
					 else if($entity_name=='Branches')  
					 {	 
						$query="select * from tbl_branch_master where school_id='$school_id' limit 10 offset $input";
				  		$result = mysql_query($query) or die('Errant query:  '.$query);
					 }
					 else if($entity_name=='Semesters')  
					 {	 
						$query="select * from tbl_semester_master where school_id='$school_id' limit 10 offset $input";
				  		$result = mysql_query($query) or die('Errant query:  '.$query);
					 }
					 else if($entity_name=='Classes')  
					 {	 
						$query="SELECT * FROM Class WHERE school_id='$school_id' limit 10 offset $input";
				  		$result = mysql_query($query) or die('Errant query:  '.$query);
					 }
					 else if($entity_name=='Teacher_subjects')  
					 {	 
						$query="select * from tbl_teacher_subject_master where school_id='$school_id' limit 10 offset $input";
				  		$result = mysql_query($query) or die('Errant query:  '.$query);
					 }
					 else if($entity_name=='Sponsors')  
					 {	 
						$query="select * from tbl_sponsorer limit 10 offset $input";
				  		$result = mysql_query($query) or die('Errant query:  '.$query);
					 }
					 else if($entity_name=='Subjects')  
					 {	 
						$query="select * from tbl_school_subject where school_id='$school_id' limit 10 offset $input";
				  		$result = mysql_query($query) or die('Errant query:  '.$query);
					 }
					 else if($entity_name=='Student_Semester_Records')  
					 {	 
						$query="SELECT * FROM StudentSemesterRecord WHERE school_id='$school_id' limit 10 offset $input";
				  		$result = mysql_query($query) or die('Errant query:  '.$query);
					 }
					  else   
					 {	
						if($entity_name=='Student_Subjects')
						{
							$query="select * from  tbl_student_subject_master where school_id='$school_id' limit 10 offset $input";
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
						}
			}				
			else
				{
					$input1=$input+10;
					 if($entity_name=='Teachers')  
					 {	 
						$query="select * from tbl_teacher where (`t_emp_type_pid`=133 or `t_emp_type_pid`=134 ) and school_id='$school_id' and id>$input and id<$input1";
				  		$result = mysql_query($query) or die('Errant query:  '.$query);
					 }	
					  else if($entity_name=='Non_Teachers')  
					 {	 
						$query="select * from tbl_teacher where `t_emp_type_pid`!=133 and `t_emp_type_pid`!=134 and school_id='$school_id' and id>$input and id<$input1";
				  		$result = mysql_query($query) or die('Errant query:  '.$query);
					 }
					 else if($entity_name=='Students')  
					 {	 
						$query="select * from tbl_student where school_id='$school_id' and id>$input and id<$input1";
				  		$result = mysql_query($query) or die('Errant query:  '.$query);
					 }
					 else if($entity_name=='Parents')  
					 {	 
						$query="SELECT * FROM tbl_parent WHERE school_id='$school_id' and Id>$input and Id<$input1";
				  		$result = mysql_query($query) or die('Errant query:  '.$query);
					 }
					 else if($entity_name=='Departments')  
					 {	 
						$query="select * from tbl_department_master where school_id='$school_id' and id>$input and id<$input1";
				  		$result = mysql_query($query) or die('Errant query:  '.$query);
					 }
					 else if($entity_name=='Branches')  
					 {	 
						$query="select * from tbl_branch_master where school_id='$school_id' and id>$input and id<$input1";
				  		$result = mysql_query($query) or die('Errant query:  '.$query);
					 }
					 else if($entity_name=='Semesters')  
					 {	 
						$query="select * from tbl_semester_master where school_id='$school_id' and Semester_Id>$input and Semester_Id<$input1";
				  		$result = mysql_query($query) or die('Errant query:  '.$query);
					 }
					 else if($entity_name=='Classes')  
					 {	 
						$query="SELECT * FROM Class WHERE school_id='$school_id' and id>$input and id<$input1";
				  		$result = mysql_query($query) or die('Errant query:  '.$query);
					 }
					 else if($entity_name=='Teacher_subjects')  
					 {	 
						$query="select * from tbl_teacher_subject_master where school_id='$school_id' and tch_sub_id>$input and tch_sub_id<$input1";
				  		$result = mysql_query($query) or die('Errant query:  '.$query);
					 }
					 else if($entity_name=='Sponsors')  
					 {	 
						$query="select * from tbl_sponsorer where id>$input and id<$input1";
				  		$result = mysql_query($query) or die('Errant query:  '.$query);
					 }
					 else if($entity_name=='Subjects')  
					 {	 
						$query="select * from tbl_school_subject where school_id='$school_id' and id>$input and id<$input1";
				  		$result = mysql_query($query) or die('Errant query:  '.$query);
					 }
					 else if($entity_name=='Student_Semester_Records')  
					 {	 
						$query="SELECT * FROM StudentSemesterRecord WHERE school_id='$school_id' and id>$input and id<$input1";
				  		$result = mysql_query($query) or die('Errant query:  '.$query);
					 }
					  else   
					 {	
						if($entity_name=='Student_Subjects')
						{
							$query="select * from  tbl_student_subject_master where school_id='$school_id' and id>$input and id<$input1";
							$result = mysql_query($query) or die('Errant query:  '.$query);
					    }
					 }
						//$query="SELECT  * from tbl_student where `school_id`='$school_id' ";
						$result = mysql_query($query) or die('Errant query:  '.$query);
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
							$postvalue['posts']=$posts;
							header('Content-type: application/json');
							echo json_encode($postvalue);
						}
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