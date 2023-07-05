<?php

$json = file_get_contents('php://input');
$obj = json_decode($json);

	//$input = $obj->{'input_id'};
	/*$limit = 20;*/
	$school_id = $obj->{'school_id'};
	$entity_name = $obj->{'entity_key'};
    $user_type = $obj->{'user_name'};  \
    $condition = "";


	include 'conn.php';



	switch($entity_name)
	{
		case 'Teachers':
                            if(preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/",trim($user_type)))
                        	{
                        	    $condition = "t_internal_email='".$user_type."'";
                        	}

                        	if(preg_match("/^[789]\d{9}$/",trim($user_type)))
                        	{
                        		$condition = "t_phone='".$user_type."'";
                        	}
                        	else
                        	{
                        		$condition = "t_id='".$user_type."'";
                            }
							getdetails($school_id,$entity_name,$user_type);
							Break;

		case 'Non_Teachers':

							getdetails($school_id,$entity_name,$user_type);
							 Break;

		case 'Students':
                            if(preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/",trim($user_type)))
                        	{
                        	    $condition = "std_email='".$user_type."'";
                        	}

                        	if(preg_match("/^[789]\d{9}$/",trim($user_type)))
                        	{
                        		$condition = "std_phone='".$user_type."'";
                        	}
                        	else
                        	{
                        		$condition = "std_PRN='".$user_type."'";
                            }
						    getdetails($school_id,$entity_name,$user_type);
						    Break;

		case 'Parents':
                            if(preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/",trim($user_type)))
                        	{
                        	    $condition = "email_id='".$user_type."'";
                        	}

                        	if(preg_match("/^[789]\d{9}$/",trim($user_type)))
                        	{
                        		$condition = "phone='".$user_type."'";
                        	}
                            else
                        	{
                        		$condition = "Id='".$user_type."'";
                            }
						 getdetails($school_id,$entity_name,$user_type);
						  Break;

		case 'Departments':
							getdetails($school_id,$entity_name,$user_type);
							 Break;

		case 'Branches':
							getdetails($school_id,$entity_name,$user_type);
							Break;

		case 'Semesters':
							getdetails($school_id,$entity_name,$user_type);
							Break;

		case 'Classes':
						getdetails($school_id,$entity_name,$user_type);
						 Break;

		case 'Teacher_subjects':
								getdetails($school_id,$entity_name,$user_type);
								  Break;

		case 'Sponsors':
							getdetails($school_id,$entity_name,$user_type);
							Break;

		case 'Subjects':
						  getdetails($school_id,$entity_name,$user_type);
						  Break;

		case 'Student_Semester_Records':
										 getdetails($school_id,$entity_name,$user_type);
										  Break;

		case 'Student_Subjects':
									getdetails($school_id,$entity_name,$user_type);
									Break;

		default:
							$postvalue['responseStatus']=204;
							$postvalue['responseMessage']="Invalid Entity name";
							$postvalue['posts']=null;
							header('Content-type: application/json');
							echo json_encode($postvalue);
							break;

	}







    function getdetails($school_id,$entity_name,$user_type)
	{


		if(!empty($school_id))
		{

		             if($entity_name=='Teachers')
					 {
						$query="select * from tbl_teacher where (`t_emp_type_pid`=133 or `t_emp_type_pid`=134 ) and $condition and school_id='$school_id' ";
				  		$result = mysql_query($query) or die('Errant query:  '.$query);
					 }
					  else if($entity_name=='Non_Teachers')
					 {
						$query="select * from tbl_teacher where `t_emp_type_pid`!=133 and `t_emp_type_pid`!=134 and school_id='$school_id' and $condition";
				  		$result = mysql_query($query) or die('Errant query:  '.$query);
					 }
					 else if($entity_name=='Students')
					 {
						$query="SELECT * FROM `tbl_student` where $condition and school_id='$school_id'";
				  		$result = mysql_query($query) or die('Errant query:  '.$query);
					 }
					 else if($entity_name=='Parents')
					 {
						$query="SELECT * FROM tbl_parent WHERE school_id='$school_id' and $condition";
				  		$result = mysql_query($query) or die('Errant query:  '.$query);
					 }
					 else if($entity_name=='Departments')
					 {
						$query="select * from tbl_department_master where school_id='$school_id' limit $limit offset $input";
				  		$result = mysql_query($query) or die('Errant query:  '.$query);
					 }
					 else if($entity_name=='Branches')
					 {
						$query="select * from tbl_branch_master where school_id='$school_id' limit $limit offset $input";
				  		$result = mysql_query($query) or die('Errant query:  '.$query);
					 }
					 else if($entity_name=='Semesters')
					 {
						$query="select * from tbl_semester_master where school_id='$school_id' limit $limit offset $input";
				  		$result = mysql_query($query) or die('Errant query:  '.$query);
					 }
					 else if($entity_name=='Classes')
					 {
						$query="SELECT * FROM Class WHERE school_id='$school_id' limit $limit offset $input";
				  		$result = mysql_query($query) or die('Errant query:  '.$query);
					 }
					 else if($entity_name=='Teacher_subjects')
					 {
						$query="select * from tbl_teacher_subject_master where school_id='$school_id' limit $limit offset $input";
				  		$result = mysql_query($query) or die('Errant query:  '.$query);
					 }
					 else if($entity_name=='Sponsors')
					 {
						$query="select * from tbl_sponsorer limit $limit offset $input";
				  		$result = mysql_query($query) or die('Errant query:  '.$query);
					 }
					 else if($entity_name=='Subjects')
					 {
						$query="select * from tbl_school_subject where school_id='$school_id' limit $limit offset $input";
				  		$result = mysql_query($query) or die('Errant query:  '.$query);
					 }
					 else if($entity_name=='Student_Semester_Records')
					 {
						$query="SELECT * FROM StudentSemesterRecord WHERE school_id='$school_id' limit $limit offset $input";
				  		$result = mysql_query($query) or die('Errant query:  '.$query);
					 }
					  else
					 {
						if($entity_name=='Student_Subjects')
						{
							$query="select * from  tbl_student_subject_master where school_id='$school_id' limit $limit offset $input";
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

			/* else
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
						}*/

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