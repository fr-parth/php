<?php

$json = file_get_contents('php://input');
$obj = json_decode($json);

	$school_id = $obj->{'school_id'};
	$entity_name = $obj->{'entity_key'};
	$point = $obj->{'points'};
	$assigner_id = $obj->{'assignee_user_id'};
    $activity_id = $obj->{'activity_id'};

    error_reporting(0);
	include 'conn.php';

     //$query=mysql_query("SELECT id FROM `tbl_school_admin` where school_id='$school_id'");
     //$result=mysql_fetch_array($query);
     //$running_id=$result['id'];
	switch($entity_name)
	{
		case 'REWARD_BLUE_POINT_TO_TEACHER':

							Assign_Points($school_id,$entity_name,$point,$assigner_id,$activity_id,$running_id);
							Break;

		case 'REWARD_GREEN_POINT_TO_STUDENT':
							
							Assign_Points($school_id,$entity_name,$point,$assigner_id,$activity_id,$running_id);
							 Break;
	
		

		
		default:
							$postvalue['responseStatus']=204;
							$postvalue['responseMessage']="Invalid Entity name";
							$postvalue['posts']=null;
							header('Content-type: application/json');
							echo json_encode($postvalue);
							break;

	}
	
 
    function Assign_Points($school_id,$entity_name,$point,$assigner_id,$activity_id,$running_id)
	{
		
	
		if(!empty($school_id) && !empty($entity_name) && !empty($point) && !empty($assigner_id))
		{
				
		             if($entity_name=='REWARD_BLUE_POINT_TO_TEACHER')
					 {
					    	$arrs=mysql_query("select * from tbl_school_admin where school_id='$school_id'");
            				$arr=mysql_fetch_array($arrs);
      					    if($arr['balance_blue_points']>=$point)
      					    {
                  				$sc_balance_blue_points=$arr['balance_blue_points']-$point;
                                $sc_assign_blue_points=$arr['assign_blue_points']+$point;
            					$scadmin_name=$arr['name'];
            		  			mysql_query("update tbl_school_admin set balance_blue_points='$sc_balance_blue_points',assign_blue_points='$sc_assign_blue_points' where school_id='$school_id'");

								
								// Start SMC-3489 Modify By sachin 2018-09-29 17:16:38 PM 
								  //$assign_date=date('d/m/Y');
								   $assign_date= CURRENT_TIMESTAMP; 
								  // define in core/securityfunctions.php
								  //Start SMC-3489
            					

            					$arrs1=mysql_query("select balance_blue_points from tbl_teacher where t_id='$assigner_id' and school_id='$school_id'");
                  				$arr1=mysql_fetch_array($arrs1);
                  				$t_balance_blue_points=$arr1['balance_blue_points']+$point;


      		  		        	mysql_query("update tbl_teacher set balance_blue_points='$t_balance_blue_points' where t_id='$assigner_id' and school_id='$school_id'");
                                $row=mysql_query("select t_list from tbl_thanqyoupointslist where id='$activity_id'");
      							$value=mysql_fetch_array($row);
      							$reasonofreward=$value['t_list'];
      				        	mysql_query("insert into tbl_teacher_point(sc_teacher_id,sc_entities_id,assigner_id,sc_point,sc_thanqupointlist_id,point_date,reason,school_id) values('$assigner_id','102','$school_id','$point','$activity_id','$assign_date','$reasonofreward','$school_id')");
                               	        $postvalue['responseStatus']=200;
										$postvalue['responseMessage']="ok";
										$postvalue['posts']=$point." "."blue points has been assigned to Teacher successfully.";
										header('Content-type: application/json');
										echo json_encode($postvalue);


                            }
                            else{

                                         	$postvalue['responseStatus']=204;
        									$postvalue['responseMessage']="Sorry School Admin has insufficient balance points";
        									$postvalue['posts']=null;
        									header('Content-type: application/json');
        									echo json_encode($postvalue);

                                 }
                     }


					 else if($entity_name=='REWARD_GREEN_POINT_TO_STUDENT')
					 {
          					        $sql=mysql_query("select school_balance_point,school_assigned_point from tbl_school_admin where school_id='$school_id'");
          						    $arr=mysql_fetch_array($sql);
          						    $school_balance_point=$arr['school_balance_point'];
          						    $assigned_points_details=$arr['school_assigned_point'];




						    	if($point>=$school_balance_point)

						    	{
                                         	$postvalue['responseStatus']=204;
        									$postvalue['responseMessage']="Sorry School Admin has insufficient balance points";
        									$postvalue['posts']=null;
        									header('Content-type: application/json');
        									echo json_encode($postvalue);

						    	}else

								{
										// Start SMC-3489 Modify By sachin 2018-09-29 17:16:38 PM 
									  //$date = date('d/m/Y');
									   $date= CURRENT_TIMESTAMP; 
									  // define in core/securityfunctions.php
									  //Start SMC-3489

                                                
												$sql=mysql_query("select sc_total_point from `tbl_student_reward` where sc_stud_id='$assigner_id' and school_id='$school_id'") or die(mysql_error());
												$result1=mysql_fetch_array($sql);
												$balance_greenstud_points=$result1['sc_total_point'];
												$final_greenstud_points=$balance_greenstud_points+$point;
												$get_stud_info=mysql_query("select `id` from tbl_student_reward where `sc_stud_id`='$assigner_id' and school_id='$school_id'") or die(mysql_error());
												if(mysql_num_rows($get_stud_info)==0)
											   {
												 $insert_stud_rewards="INSERT INTO `tbl_student_reward` (`sc_total_point`,`sc_assigned_by`,`sc_stud_id`,`sc_date`,`school_id`)
													VALUES ('$point','$school_id','$assigner_id','$date','$school_id')";
												 $result_insert11 = mysql_query($insert_stud_rewards) or die(mysql_error());
												}
                                                else{

													    mysql_query("update tbl_student_reward set sc_total_point='$final_greenstud_points' where sc_stud_id='$assigner_id' and school_id='$school_id'") or die(mysql_error());
													}


										$final_green_points=$school_balance_point-$point;
                                        $school_assigned_point=$assigned_points_details+$point;
										mysql_query("update tbl_school_admin set school_balance_point='$final_green_points',school_assigned_point='$school_assigned_point' where school_id='$school_id'") or die(mysql_error());



                                            $reason=mysql_query("select `sc_list` from `tbl_studentpointslist` where `sc_id`='$activity_id'");
                    						$arr11=mysql_fetch_array($reason);
                    						$point_given_reason=$arr11['sc_list'];

                    						mysql_query("insert into tbl_student_point(sc_stud_id,sc_studentpointlist_id,sc_entites_id,sc_point,point_date,reason,activity_type,school_id) values('$assigner_id',
											'$activity_id','102','$point','$date','$point_given_reason','activity','$school_id')");


                                         $postvalue['responseStatus']=200;
										$postvalue['responseMessage']="ok";
										$postvalue['posts']=$point." "."Green points has been assigned to student as a Reward.";
										header('Content-type: application/json');
										echo json_encode($postvalue);

								}

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