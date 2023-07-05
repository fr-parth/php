<?php  
include 'conn.php';
$json = file_get_contents('php://input');
$obj = json_decode($json);
//echo $json;
$total_point=0;
 $format = 'json';

//Save
if($obj->{'User_Std_id'} != ''&& $obj->{'t_id'}!='' && $obj->{'method_id'}!=''&& $obj->{'point_type'}!=''&&$obj->{'reward_value'}!=''&&$obj->{'school_id'}!='')
{
		//input from user
		
		$method_id=$obj->{'method_id'};
		$school_id=$obj->{'school_id'};
		$activity_id=$obj->{'activity_id'};
		$subject_id=$obj->{'subject_id'};
		$value=$obj->{'reward_value'};
		$teacher_id=$obj->{'t_id'};//teacher id ic coulmn from tbl_teacher t_id
		$std_id=$obj->{'User_Std_id'};//student PRN no		
		//$date1=$obj->{'User_date'};
		$dates=date('d/m/Y');
		$select_opt=$obj->{'point_type'};
		$comment=$obj->{'Comment'};
		if($obj->{'activity_id'}=='')
		{
		$activity_id=0;
		
		}
		if($obj->{'subject_id'}=='')
		{
		$subject_id=0;
		
		}
		$posts=array();
		


		if($select_opt=='Greenpoint')
		{
			
		
		
		if($method_id==2 ||$method_id==3||$method_id==4)
		{
		
		//retrive points for grade /marks or percentile
		 $sql="SELECT  m.id,from_range,to_range
		FROM tbl_master m
		JOIN tbl_method t on t.id=m.method_id
		WHERE t.id ='$method_id' AND activity_id='$activity_id' AND subject_id='$subject_id' AND school_id='$school_id'";
		
		$id=0;
		$result=mysql_query($sql);
			/* if else start*/
				if(mysql_num_rows($result)>0)
				{
					while( $row = mysql_fetch_array($result))
					{
					
						 $from_range=$row['from_range'];
						 $to_range=$row['to_range'];
						if($method_id=='3')
						{
						
							if(strcmp($from_range,$value)<=0 && strcmp($to_range,$value)>=0)
							{
							 $id=$row['id'];
							}
						
						}
						else
						{
							if($value>=$from_range && $value<=$to_range)
							{
							 $id=$row['id'];
							
							
							}
						}
					
					}
				}
				
				
				else
				{
								 $sql="SELECT  m.id,from_range,to_range
							FROM tbl_master m
							JOIN tbl_method t on t.id=m.method_id
							WHERE t.id ='$method_id' AND activity_id='0' AND subject_id='0' AND school_id='0'";
							
							$id=0;
							$result=mysql_query($sql);
							while( $row = mysql_fetch_array($result))
								{
								
										 $from_range=$row['from_range'];
										 $to_range=$row['to_range'];
										if($method_id=='3')
										{
										
											if(strcmp($from_range,$value)<=0 && strcmp($to_range,$value)>=0)
											{
											 $id=$row['id'];
											}
										
										}
										else
										{
											if($value>=$from_range && $value<=$to_range)
											{
											 $id=$row['id'];
											
											
											}
										}
								
								}


				}
				
				/* if else end*/
			
				if($id==0)
				{
				$postvalue['responseStatus']=204;
				$postvalue['responseMessage']="No Response";
				$postvalue['posts']=null;
				
				}
				
				//marks percentile and grade
				else
				{

					$results=mysql_query("SELECT  m.id,points
					FROM tbl_master m
					JOIN tbl_method t
					WHERE m.id='$id'");
					$values=mysql_fetch_array($results);
					 $points =$values['points'];
					
					 $arr1=mysql_query("select tc_balance_point,t_name,t_middlename,t_lastname from tbl_teacher where t_id='$teacher_id'");
						 $val=mysql_fetch_array($arr1);
						 $teacher_name=$val['t_name'].' '.$val['t_middlename'].' '.$val['t_lastname'];
						 $balance_point=$val['tc_balance_point'];
						
						 //checking for balance of teacher
						 if($balance_point>=$points)
						 {
					
								  $balance_point= $balance_point-$points;
								$reasonofreward="";
						 mysql_query("update tbl_teacher set tc_balance_point='$balance_point' where t_id='$teacher_id' and school_id='$school_id'");
								 if($subject_id=="0")
								 {
								 
			
							mysql_query("INSERT INTO `tbl_student_point` (sc_stud_id, sc_entites_id, sc_teacher_id, sc_studentpointlist_id, sc_point, point_date, sc_status,activity_type,marks,method,school_id,comment) VALUES('".$obj->{'User_Std_id'}."', '103', '".$obj->{'t_id'}."', '$activity_id', '$points', '$dates', 'N','activity','$value','$method_id','$school_id','$comment')");
								  //retrive activity name for particular activity id(monika)
								$row_activity=mysql_query(" SELECT sc_list FROM `tbl_studentpointslist` WHERE `sc_id` = '$activity_id'");
								$value_activity=mysql_fetch_array($row_activity);
								$reasonofreward=$value_activity['sc_list'];
								 }
								 else
								 {
								
								 
								 
							  mysql_query("INSERT INTO `tbl_student_point` (sc_stud_id, sc_entites_id, sc_teacher_id, sc_studentpointlist_id, sc_point, point_date, sc_status,activity_type,marks,method,school_id,comment) VALUES('".$obj->{'User_Std_id'}."', '103', '".$obj->{'t_id'}."','$subject_id', '$points', '$dates', 'N','subject','$value','$method_id','$school_id','$comment')");
								   //retrive subject name for particular subject id(monika)
								  
								  $row_activity=mysql_query("SELECT distinct(subjectName) FROM `tbl_student_subject_master` WHERE subjcet_code ='$subject_id'");
								$value_activity=mysql_fetch_array($row_activity);
								$reasonofreward=$value_activity['subjectName'];
								 
								 }
                    			 
								 $arr=   mysql_query("select sc_total_point from tbl_student_reward where sc_stud_id='".$obj->{'User_Std_id'}."' and school_id='$school_id'");
								  if(mysql_num_rows($arr)>0)
								 {
								 $row=   mysql_fetch_array($arr);
								  $original_point=$row['sc_total_point'];
							
								$total_point=$original_point+$points;
								
					mysql_query("Update tbl_student_reward set sc_total_point='$total_point' where sc_stud_id='".$obj->{'User_Std_id'}."' and school_id='$school_id'");
					$report=" $value Green Points  successfully assigned";
					  $posts[]=array('report'=>$report);
					
					 	$postvalue['responseStatus']=200;
				$postvalue['responseMessage']="OK";
		$postvalue['posts']=$posts;
								   }
						   
								   else
								   {
									 
								  $original_point=0;
							
								$total_point=$original_point+$points;
								
								
							
					  mysql_query("insert into  tbl_student_reward(sc_total_point,sc_stud_id,sc_date,school_id) values ('$total_point','$std_id','$dates','$school_id') ");
					$report="$value Green Points successfully assigned";
					  $posts[]=array('report'=>$report);
					 	$postvalue['responseStatus']=200;
				$postvalue['responseMessage']="OK";
		$postvalue['posts']=$posts;
								   
								   }
						// Message to be sent 
						//$std_id is student PRN
										
										$row_student=mysql_query("select * from tbl_student where std_PRN='$std_id'");
												$value_student=mysql_fetch_array($row_student);
												$stdudentid=$value_student['id'];
											$row=mysql_query("select * from student_gcmid where student_id='$stdudentid'");
								while($value=mysql_fetch_array($row))
								{
											
						$reason = mysql_query("select sc_list from tbl_studentpointslist where sc_id='$activity_id'");
						$sqlresult = mysql_fetch_array($reason);
						$reasonofreward = $sqlresult['sc_list'];
								            	 $Gcm_id=$value['gcm_id'];
									$message = "Reward Point | Hello ".ucfirst(strtolower($value_student['std_name']))." ".ucfirst(strtolower($value_student['std_lastname'])).", Your teacher $teacher_name rewarded you $points points for $reasonofreward";
												include('pushnotification.php');
												
							send_push_notification($Gcm_id, $message);
								}
								
												
						
						}
					else
					{
						$postvalue['responseStatus']=204;
				$postvalue['responseMessage']="No Response";
				$postvalue['posts']=null;	
						
					}
		
	
	
	
				}
}

//end method_id!=1 if loop

else
{


$points=$value;
 $arr1=mysql_query("select tc_balance_point,t_name,t_middlename,t_lastname from tbl_teacher where t_id='$teacher_id' and school_id='$school_id'");
	 $val=mysql_fetch_array($arr1);
	 $teacher_name=ucfirst(strtolower($val['t_name'])).' '.ucfirst(strtolower($val['t_middlename'])).' '.ucfirst(strtolower($val['t_lastname']));
	$balance_point=$val['tc_balance_point'];
	
	 //checking for balance of teacher
	 if($balance_point>=$value)
	 {

					  $balance_point= $balance_point-$value;
					 
					
					 mysql_query("update tbl_teacher set tc_balance_point='$balance_point' where t_id='$teacher_id' and school_id='$school_id'");
					 $reasonofreward="";
					 if($subject_id=="0")
					 {
					
					
					
				 mysql_query("INSERT INTO `tbl_student_point` (sc_stud_id, sc_entites_id, sc_teacher_id, sc_studentpointlist_id, sc_point, point_date, sc_status,activity_type,marks,method,school_id,comment) VALUES('".$obj->{'User_Std_id'}."', '103', '".$obj->{'t_id'}."', '$activity_id', '$value', '$dates', 'N','activity','','$method_id','$school_id','$comment')");
				 //retrive activity name for particular activity id(monika)
				
				$row_activity=mysql_query("SELECT sc_list FROM `tbl_studentpointslist` WHERE sc_id = '$activity_id' and school_id='$school_id'");
				$value_activity=mysql_fetch_array($row_activity);
			 $reasonofreward=$value_activity['sc_list'];
				 }
				 else
				 {
				 
				 
				  mysql_query("INSERT INTO `tbl_student_point` (sc_stud_id, sc_entites_id, sc_teacher_id, sc_studentpointlist_id, sc_point, point_date, sc_status,activity_type,marks,method,school_id,comment) VALUES('".$obj->{'User_Std_id'}."', '103', '".$obj->{'t_id'}."','$subject_id', '$value', '$dates', 'N','subject','','$method_id','$school_id','$comment')");
				  //retrive subject name for particular subject id(monika)
				 
				  $row_activity=mysql_query("SELECT distinct(subjectName) FROM `tbl_student_subject_master` WHERE subjcet_code ='$subject_id'");
				$value_activity=mysql_fetch_array($row_activity);
			 $reasonofreward=$value_activity['subjectName'];
				 
				 }
					  
					 $arr=   mysql_query("select sc_total_point from tbl_student_reward where sc_stud_id='".$obj->{'User_Std_id'}."' and school_id='$school_id'");
					 if(mysql_num_rows($arr)>0)
					 {
					 $row=   mysql_fetch_array($arr);
					  $original_point=$row['sc_total_point'];
				
			$total_point=$original_point+$value;
					
				
				 mysql_query("Update tbl_student_reward set sc_total_point='$total_point' where sc_stud_id='".$obj->{'User_Std_id'}."' and school_id='$school_id'");
				$report="$value Green Points successfully assigned";
					  $posts[]=array('report'=>$report);
					 	$postvalue['responseStatus']=200;
				$postvalue['responseMessage']="OK";
		$postvalue['posts']=$posts;
					   }
					   
					   else
					   {
						 
					  $original_point=0;
				
				$total_point=$original_point+$points;
					
					
				
					mysql_query("insert into  tbl_student_reward(sc_total_point,sc_stud_id,sc_date,school_id) values ('$total_point','$std_id','$dates','$school_id') ");
					  $report="$value Green Points successfully assigned";
					  $posts[]=array('report'=>$report);
					  
					 	$postvalue['responseStatus']=200;
				$postvalue['responseMessage']="OK";
		$postvalue['posts']=$posts;
					   
					   }
					  
					   // Message to be sent where std_PRN is match to particular student
											
												$row_student=mysql_query("select * from tbl_student where std_PRN='$std_id' and school_id='$school_id'");
												$value_student=mysql_fetch_array($row_student);
												$stdudentid=$value_student['id'];
											$row=mysql_query("select * from student_gcmid where student_id='$stdudentid'");
								
							
								while($value=mysql_fetch_array($row))
								{
									$reason = mysql_query("select sc_list from tbl_studentpointslist where sc_id='$activity_id'");
						$sqlresult = mysql_fetch_array($reason);
						$reasonofreward = $sqlresult['sc_list'];
											
								            	 $Gcm_id=$value['gcm_id'];
										$message = "Reward Points| Hello ".trim(ucfirst(strtolower($value_student['std_name'])))." ".trim(ucfirst(strtolower($value_student['std_lastname']))).", your teacher $teacher_name rewarded you $points points for $reasonofreward";
												include('pushnotification.php');
												
							send_push_notification($Gcm_id, $message);
											}
								
											
		
	}
	else
	{
		$postvalue['responseStatus']=204;
				$postvalue['responseMessage']="Insufficient Green Points";
				$postvalue['posts']=null;	
		
		
	}
		
		

 				


}


		}
// end of green point 

// start water point
						if($select_opt=='Waterpoint')
		{
			
		
		
		if($method_id==2 ||$method_id==3||$method_id==4)
		{
		
		//retrive points for grade /marks or percentile
		 $sql="SELECT  m.id,from_range,to_range
		FROM tbl_master m
		JOIN tbl_method t on t.id=m.method_id
		WHERE t.id ='$method_id' AND activity_id='$activity_id' AND subject_id='$subject_id' AND school_id='$school_id'";
		
		$id=0;
		$result=mysql_query($sql);
			/* if else start*/
				if(mysql_num_rows($result)>0)
				{
					while( $row = mysql_fetch_array($result))
					{
					
						 $from_range=$row['from_range'];
						 $to_range=$row['to_range'];
						if($method_id=='3')
						{
						
							if(strcmp($from_range,$value)<=0 && strcmp($to_range,$value)>=0)
							{
							 $id=$row['id'];
							}
						
						}
						else
						{
							if($value>=$from_range && $value<=$to_range)
							{
							 $id=$row['id'];
							
							
							}
						}
					
					}
				}
				
				
				else
				{
								 $sql="SELECT  m.id,from_range,to_range
							FROM tbl_master m
							JOIN tbl_method t on t.id=m.method_id
							WHERE t.id ='$method_id' AND activity_id='0' AND subject_id='0' AND school_id='0'";
							
							$id=0;
							$result=mysql_query($sql);
							while( $row = mysql_fetch_array($result))
								{
								
										 $from_range=$row['from_range'];
										 $to_range=$row['to_range'];
										if($method_id=='3')
										{
										
											if(strcmp($from_range,$value)<=0 && strcmp($to_range,$value)>=0)
											{
											 $id=$row['id'];
											}
										
										}
										else
										{
											if($value>=$from_range && $value<=$to_range)
											{
											 $id=$row['id'];
											
											
											}
										}
								
								}


				}
				
				/* if else end*/
			
				if($id==0)
				{
				$postvalue['responseStatus']=204;
				$postvalue['responseMessage']="No Response";
				$postvalue['posts']=null;
				
				}
				
				//marks percentile and grade
				else
				{

					$results=mysql_query("SELECT  m.id,points
					FROM tbl_master m
					JOIN tbl_method t
					WHERE m.id='$id'");
					$values=mysql_fetch_array($results);
					 $points =$values['points'];
					
					 $arr1=mysql_query("select water_point,tc_balance_point,t_name,t_middlename,t_lastname from tbl_teacher where t_id='$teacher_id'");
						 $val=mysql_fetch_array($arr1);
						 $teacher_name=$val['t_name'].' '.$val['t_middlename'].' '.$val['t_lastname'];
						 $water_point=$val['water_point'];
						
						 //checking for balance of teacher
						 if($water_point>=$points)
						 {
					
								  $water_point= $water_point-$points;
								$reasonofreward="";
						 mysql_query("update tbl_teacher set water_point='$water_point' where t_id='$teacher_id' and school_id='$school_id'");
								 if($subject_id=="0")
								 {
								 
			
							mysql_query("INSERT INTO `tbl_student_point` (sc_stud_id, sc_entites_id, sc_teacher_id, sc_studentpointlist_id, sc_point, point_date, sc_status,activity_type,marks,method,school_id,comment) VALUES('".$obj->{'User_Std_id'}."', '103', '".$obj->{'t_id'}."', '$activity_id', '$points', '$dates', 'N','activity','$value','$method_id','$school_id','$comment')");
								  //retrive activity name for particular activity id(monika)
								$row_activity=mysql_query(" SELECT sc_list FROM `tbl_studentpointslist` WHERE `sc_id` = '$activity_id'");
								$value_activity=mysql_fetch_array($row_activity);
								$reasonofreward=$value_activity['sc_list'];
								 }
								 else
								 {
								
								 
								 
							  mysql_query("INSERT INTO `tbl_student_point` (sc_stud_id, sc_entites_id, sc_teacher_id, sc_studentpointlist_id, sc_point, point_date, sc_status,activity_type,marks,method,school_id,comment) VALUES('".$obj->{'User_Std_id'}."', '103', '".$obj->{'t_id'}."','$subject_id', '$points', '$dates', 'N','subject','$value','$method_id','$school_id','$comment')");
								   //retrive subject name for particular subject id(monika)
								  
								  $row_activity=mysql_query("SELECT distinct(subjectName) FROM `tbl_student_subject_master` WHERE subjcet_code ='$subject_id'");
								$value_activity=mysql_fetch_array($row_activity);
								$reasonofreward=$value_activity['subjectName'];
								 
								 }
                    			 
								 $arr=   mysql_query("select sc_total_point from tbl_student_reward where sc_stud_id='".$obj->{'User_Std_id'}."' and school_id='$school_id'");
								  if(mysql_num_rows($arr)>0)
								 {
								 $row=   mysql_fetch_array($arr);
								  $original_point=$row['sc_total_point'];
							
								$total_point=$original_point+$points;
								
					mysql_query("Update tbl_student_reward set sc_total_point='$total_point' where sc_stud_id='".$obj->{'User_Std_id'}."' and school_id='$school_id'");
					$report="$value Water Points successfully assigned";
					  $posts[]=array('report'=>$report);
					
					 	$postvalue['responseStatus']=200;
				$postvalue['responseMessage']="OK";
		$postvalue['posts']=$posts;
								   }
						   
								   else
								   {
									 
								  $original_point=0;
							
								$total_point=$original_point+$points;
								
								
							
					  mysql_query("insert into  tbl_student_reward(sc_total_point,sc_stud_id,sc_date,school_id) values ('$total_point','$std_id','$dates','$school_id') ");
					$report="$value Water Points successfully assigned";
					  $posts[]=array('report'=>$report);
					 	$postvalue['responseStatus']=200;
				$postvalue['responseMessage']="OK";
		$postvalue['posts']=$posts;
								   
								   }
						// Message to be sent 
						//$std_id is student PRN
										
										$row_student=mysql_query("select * from tbl_student where std_PRN='$std_id'");
												$value_student=mysql_fetch_array($row_student);
												$stdudentid=$value_student['id'];
											$row=mysql_query("select * from student_gcmid where student_id='$stdudentid'");
								while($value=mysql_fetch_array($row))
								{
											
						$reason = mysql_query("select sc_list from tbl_studentpointslist where sc_id='$activity_id'");
						$sqlresult = mysql_fetch_array($reason);
						$reasonofreward = $sqlresult['sc_list'];
								            	 $Gcm_id=$value['gcm_id'];
									$message = "Reward Point | Hello ".ucfirst(strtolower($value_student['std_name']))." ".ucfirst(strtolower($value_student['std_lastname'])).", Your teacher $teacher_name rewarded you $points points for $reasonofreward";
												include('pushnotification.php');
												
							send_push_notification($Gcm_id, $message);
								}
								
												
						
						}
					else
					{
						$postvalue['responseStatus']=204;
				$postvalue['responseMessage']="No Response";
				$postvalue['posts']=null;	
						
					}
		
	
	
	
				}
}

//end method_id!=1 if loop

else
{


$points=$value;
 $arr1=mysql_query("select water_point,tc_balance_point,t_name,t_middlename,t_lastname from tbl_teacher where t_id='$teacher_id' and school_id='$school_id'");
	 $val=mysql_fetch_array($arr1);
	 $teacher_name=ucfirst(strtolower($val['t_name'])).' '.ucfirst(strtolower($val['t_middlename'])).' '.ucfirst(strtolower($val['t_lastname']));
	$water_point=$val['water_point'];
	
	 //checking for balance of teacher
	 if($water_point>=$value)
	 {

					  $water_point= $water_point-$value;
					 
					
					 mysql_query("update tbl_teacher set tc_balance_point='$balance_point' where t_id='$teacher_id' and school_id='$school_id'");
					 $reasonofreward="";
					 if($subject_id=="0")
					 {
					
					
					
				 mysql_query("INSERT INTO `tbl_student_point` (sc_stud_id, sc_entites_id, sc_teacher_id, sc_studentpointlist_id, sc_point, point_date, sc_status,activity_type,marks,method,school_id,comment) VALUES('".$obj->{'User_Std_id'}."', '103', '".$obj->{'t_id'}."', '$activity_id', '$value', '$dates', 'N','activity','','$method_id','$school_id','$comment')");
				 //retrive activity name for particular activity id(monika)
				
				$row_activity=mysql_query("SELECT sc_list FROM `tbl_studentpointslist` WHERE sc_id = '$activity_id' and school_id='$school_id'");
				$value_activity=mysql_fetch_array($row_activity);
			 $reasonofreward=$value_activity['sc_list'];
				 }
				 else
				 {
				 
				 
				  mysql_query("INSERT INTO `tbl_student_point` (sc_stud_id, sc_entites_id, sc_teacher_id, sc_studentpointlist_id, sc_point, point_date, sc_status,activity_type,marks,method,school_id,comment) VALUES('".$obj->{'User_Std_id'}."', '103', '".$obj->{'t_id'}."','$subject_id', '$value', '$dates', 'N','subject','','$method_id','$school_id','$comment')");
				  //retrive subject name for particular subject id(monika)
				 
				  $row_activity=mysql_query("SELECT distinct(subjectName) FROM `tbl_student_subject_master` WHERE subjcet_code ='$subject_id'");
				$value_activity=mysql_fetch_array($row_activity);
			 $reasonofreward=$value_activity['subjectName'];
				 
				 }
					  
					 $arr=   mysql_query("select sc_total_point from tbl_student_reward where sc_stud_id='".$obj->{'User_Std_id'}."' and school_id='$school_id'");
					 if(mysql_num_rows($arr)>0)
					 {
					 $row=   mysql_fetch_array($arr);
					  $original_point=$row['sc_total_point'];
				
			$total_point=$original_point+$value;
					
				
				 mysql_query("Update tbl_student_reward set sc_total_point='$total_point' where sc_stud_id='".$obj->{'User_Std_id'}."' and school_id='$school_id'");
				$report="$value Water Points successfully assigned";
					  $posts[]=array('report'=>$report);
					 	$postvalue['responseStatus']=200;
				$postvalue['responseMessage']="OK";
		$postvalue['posts']=$posts;
					   }
					   
					   else
					   {
						 
					  $original_point=0;
				
				$total_point=$original_point+$points;
					
					
				
					mysql_query("insert into  tbl_student_reward(sc_total_point,sc_stud_id,sc_date,school_id) values ('$total_point','$std_id','$dates','$school_id') ");
					  $report="$value Water Points successfully assigned";
					  $posts[]=array('report'=>$report);
					  
					 	$postvalue['responseStatus']=200;
				$postvalue['responseMessage']="OK";
		$postvalue['posts']=$posts;
					   
					   }
					  
					   // Message to be sent where std_PRN is match to particular student
											
												$row_student=mysql_query("select * from tbl_student where std_PRN='$std_id' and school_id='$school_id'");
												$value_student=mysql_fetch_array($row_student);
												$stdudentid=$value_student['id'];
											$row=mysql_query("select * from student_gcmid where student_id='$stdudentid'");
								
							
								while($value=mysql_fetch_array($row))
								{
									$reason = mysql_query("select sc_list from tbl_studentpointslist where sc_id='$activity_id'");
						$sqlresult = mysql_fetch_array($reason);
						$reasonofreward = $sqlresult['sc_list'];
											
								            	 $Gcm_id=$value['gcm_id'];
										$message = "Reward Points| Hello ".trim(ucfirst(strtolower($value_student['std_name'])))." ".trim(ucfirst(strtolower($value_student['std_lastname']))).", your teacher $teacher_name rewarded you $points points for $reasonofreward";
												include('pushnotification.php');
												
							send_push_notification($Gcm_id, $message);
											}
								
											
		
	}
	else
	{
		$postvalue['responseStatus']=204;
				$postvalue['responseMessage']="Insufficient Water Points";
				$postvalue['posts']=null;	
		
		
	}
		
		

 				


}


		}


//end of water point
		
		

if($format == 'json') {
    					header('Content-type: application/json');
   					 echo json_encode($postvalue);
  					}
 

 
	
}
else
{
	 $postvalue['responseStatus']=1000;
				$postvalue['responseMessage']="Invalid Input";
				$postvalue['posts']=null;
			  
			  header('Content-type: application/json');
   			  echo  json_encode($postvalue); 
}	
		
  ?>