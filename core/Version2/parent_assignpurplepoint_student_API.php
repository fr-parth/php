<?php
//require_once('parent_loader.php');
require_once('parent_config.php');
require_once('parent_function.php');
include 'conn.php';
error_reporting(0);
$json = file_get_contents('php://input');
$obj = json_decode($json);

	$stud_id = $obj->{'stud_id'};
	$school_id = $obj->{'school_id'};
    $user_id = $obj->{'parent_id'};
    $point = $obj->{'purple_points'};
    $activity_id = $obj->{'activity_id'};
    $subject_id = $obj->{'subject_id'};
	$type = $obj->{'activity_type'};
   $point_given_reason = $obj->{'reason'};
  
  


  $number_of_posts = isset($_GET['num']) ? intval($_GET['num']) : 10; //10 is the default
  $format = 'json'; 
  
  if(!empty($user_id) && !empty($stud_id) && !empty($school_id) && !empty($point) && !empty($type) && !empty($point_given_reason))
 {
		
		if($type=='activity')
		{	
			assignpoint($stud_id,$school_id,$user_id,$point,$activity_id,$type,$point_given_reason);
		
		}
		else
		{
			
			assignpoint($stud_id,$school_id,$user_id,$point,$subject_id,$type,$point_given_reason);
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
			
			function assignpoint($stud_id,$school_id,$user_id,$point,$studpointlist_id,$type,$point_given_reason)
			{
		
		
			       $arrs=mysql_query("select * from tbl_parent where Id='$user_id' ");
      				$arr=mysql_fetch_array($arrs);
					$parent_name=$arr['Name'];
					if($arr['balance_points']>=$point)
					{
						$balance_blue_points=$arr['balance_points']-$point;
						$assign_blue_points=$arr['distributed_purple']+$point;

						
						$assign_date=date('d/m/Y');
						
						$arrs1=mysql_query("select sc_stud_id from tbl_student_reward where sc_stud_id='$stud_id' and school_id='$school_id'");
						//$arr=mysql_fetch_array($arrs);
						if(mysql_num_rows($arrs1)>=1) 
						{
							$prn=mysql_query("select purple_points from tbl_student_reward where sc_stud_id='$stud_id' and school_id='$school_id'");
							$arr1=mysql_fetch_array($prn);
							$t_balance_purple_points=$arr1['purple_points']+$point;
							mysql_query("update tbl_student_reward set purple_points='$t_balance_purple_points' where sc_stud_id='$stud_id' and school_id=
                                            '$school_id'");
							//$I=mysql_query("INSERT INTO tbl_student_reward(sc_stud_id,sc_assigned_by,sc_date,purple_points,school_id) VALUES('$stud_id',
                            //'$user_id','$assign_date','$point','$school_id')");

								$stud_prn=mysql_query("select `gcm_id` from student_gcmid where std_PRN='$stud_id'");
								while($results=mysql_fetch_array($stud_prn))
								{
									$gcmRegID    = $results["gcm_id"]; // GCM Registration ID got from device
									$pushMessage = "I Got $point Points for $point_given_reason from $parent_name";
								
									if (isset($gcmRegID) && isset($pushMessage)) 
									{
									
									
										$registatoin_ids = array($gcmRegID);
										$message = array("point_assign" => $pushMessage);
								
										send_push_notification($registatoin_ids, $message);
								
										//echo $result;
									}
								}
						
						
						
						}else
							{
							
								$I=mysql_query("INSERT INTO tbl_student_reward(sc_stud_id,sc_assigned_by,sc_date,purple_points,school_id) VALUES('$stud_id','$user_id','$assign_date','$point','$school_id')");
								
								$stud_prn=mysql_query("select `gcm_id` from student_gcmid where std_PRN='$stud_id'");
								while($results=mysql_fetch_array($stud_prn))
								{
									$gcmRegID    = $results["gcm_id"]; // GCM Registration ID got from device
									$pushMessage = "I Got $point Points for $point_given_reason from $parent_name";
								
									if (isset($gcmRegID) && isset($pushMessage)) 
									{
									
									
										$registatoin_ids = array($gcmRegID);
										$message = array("point_assign" => $pushMessage);
								
										send_push_notification($registatoin_ids, $message);
								
										//echo $result;
									}
								}
							
							}
							/* $reason=mysql_query("select `sc_list` from `tbl_studentpointslist` where `sc_id`='$activity_id'");
							$arr11=mysql_fetch_array($reason);
							$point_given_reason=$arr11['sc_list']; */
						
							if($type=='activity')
							{	
								mysql_query("insert into tbl_student_point(sc_stud_id,sc_studentpointlist_id,sc_entites_id,sc_point,point_date,reason,sc_teacher_id,school_id,activity_type) values('$stud_id','$studpointlist_id','106','$point','$assign_date','$point_given_reason','$user_id','$school_id','activity')");
							}else
							{
								mysql_query("insert into tbl_student_point(sc_stud_id,sc_studentpointlist_id,sc_entites_id,sc_point,point_date,reason,sc_teacher_id,school_id,activity_type) values('$stud_id','$studpointlist_id','106','$point','$assign_date','$point_given_reason','$user_id','$school_id','subject')");
							}	
						
							mysql_query("update tbl_parent set balance_points='$balance_blue_points',distributed_purple='$assign_blue_points' where Id='$user_id'");
							$postvalue['responseStatus']=200;
							$postvalue['responseMessage']="You assigned $point Purple points successfully.";
							header('Content-type: application/json');
							echo  json_encode($postvalue);  
					 }
				 else
				 {
	 				 $postvalue['responseStatus']=204;
					 $postvalue['responseMessage']="You have insufficient balance to assign.";
					 header('Content-type: application/json');
   			         echo  json_encode($postvalue); 
				}
		
		
		}
  
  
  @mysql_close($con);

?>