<?php 
/*
Author Yogesh Sonawane
New web service for purchase brown point log to the student, teacher 
*/

$json = file_get_contents('php://input');
$obj = json_decode($json);
header('Content-type: application/json');
$format = 'json'; //xml is the default

include '../conn.php';

  $offset = xss_clean(mysql_real_escape_string($obj->{'offset'}));
  $user_id = xss_clean(mysql_real_escape_string($obj->{'user_id'}));
  $entity_id=xss_clean(mysql_real_escape_string($obj->{'entity_id'}));
  $school_id=xss_clean(mysql_real_escape_string($obj->{'school_id'}));
  //offset function call from core/securityfunctions.php
 $offset=offset($offset);//default offset = "0"
	if($user_id!="" &&  $entity_id!="" && $school_id!="")
	{			
		  //Teacher
			 if($entity_id=='103')
			 {

				$table='tbl_teacher_point';
				$point_type='point_type';
				$user='sc_teacher_id';
				$entity='sc_entities_id';

			 }
			 //student
			 else if($entity_id=='105')
			 {

				$table='tbl_student_point';
				$point_type='type_points';
				$user='sc_stud_id';
				$entity='sc_entites_id';

			  }
			  else
			  {
					$postvalue['responseStatus']=1002;
					$postvalue['responseMessage']="Entity id not match";
					$postvalue['posts']=null;
					header('Content-type: application/json');
					echo json_encode($postvalue);
					@mysql_close($con);
					exit;
			  }	
//or $point_type='BrownPoints' added for brown point log by Pranali for SMC-4449 on 23-1-20	
				$arr="Select sc_point,reason,point_date,activity_type from $table
				where ($point_type='Brown' or $point_type='BrownPoints' or $point_type='Brown Points') and $user ='$user_id' and $entity='$entity_id' and school_id='$school_id' ORDER BY id DESC LIMIT $limit OFFSET $offset";

				
				$result = mysql_query($arr,$con) or die('Errant query:  '.$arr);
		/* create one master array of the records */
		
		//$posts = array();
		$count=mysql_num_rows($result);
		
			if($count==0 && $result) 
					{
						
						if($offset==0)
						{
							$postvalue['responseStatus']=204;
							$postvalue['responseMessage']="No Record found";
							$postvalue['posts']=null;
						}else
							{
							
							$postvalue['responseStatus']=224;
							$postvalue['responseMessage']="End of Records";
							$postvalue['posts']=null;
							}
					}
					//End SMC-3450
  			else if($count > 0) 
			{
  //referral_reason output parameter added by Pranali for SMC-4727 
					while($post = mysql_fetch_assoc($result))
					{
						$sc_point=$post['sc_point'];
						$reason=$post['reason'];
						$point_date=$post['point_date'];
						$activity_type=$post['activity_type'];
						$posts[] =array('sc_point'=>$sc_point,'reason'=>$reason,'point_date'=>$point_date,'referral_reason'=>$activity_type);
					}
				
					$postvalue['responseStatus']=200;
					$postvalue['responseMessage']="OK";
					$postvalue['posts']=$posts;
				}
				else
				{
					$postvalue['responseStatus']=204;
					$postvalue['responseMessage']="No Response";
					$postvalue['posts']=null;	
				}
		
  					/* output in necessary format */
  					
				header('Content-type: application/json');
				echo json_encode($postvalue);
  					
			}
			else 
			{
				$postvalue['responseStatus']=1000;
				$postvalue['responseMessage']="Invalid Input";
				$postvalue['posts']=null;
				echo  json_encode($postvalue); 
			 }	

  /* disconnect from the db */
  @mysql_close($con);	
  ?>