<?php
include 'conn.php';
$json = file_get_contents('php://input');
$obj = json_decode($json);
$total_point=0;
 $format = 'json';
if($obj->{'User_Std_id'} != ''&& $obj->{'t_id'}!='' && $obj->{'method_id'}!=''&& $obj->{'point_type'}!=''&&$obj->{'reward_value'}!=''&&$obj->{'school_id'}!='')
{
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
switch ($select_opt) {
    case Greenpoint:
			switch ($method_id) {
					case 1|| 2||3 ||4:

					 $sl=mysql_query("select parent_id from tbl_student where school_id='$school_id' and std_PRN='$std_id'");
					$g=mysql_fetch_array($sl);
					$Parent_member_id=$g['parent_id'];
					
					$s=mysql_query("select  parent_proud_points from school_rule_engine where school_id='$school_id'");
					$ss=mysql_fetch_array($s);
					$parent_proud_points=$ss['parent_proud_points'];
					//$Proud_Points=$parent_proud_points/$value*100;
					$Proud_Points=$value/100*$parent_proud_points;
					 //= 22% of x = (22 / 100) * x = 0.22 x 
					
					
							$sql=mysql_query("select id from tbl_method where id='$method_id'");
							$values=mysql_fetch_array($sql);
							$mid =$values['id'];
							
							$arr1=mysql_query("select tc_balance_point,t_name,t_middlename,t_lastname from tbl_teacher where t_id='$teacher_id' and school_id='$school_id'");
							
							$val=mysql_fetch_array($arr1);
							$teacher_name=$val['t_name'].' '.$val['t_middlename'].' '.$val['t_lastname'];
							$balance_point=$val['tc_balance_point'];
							if($balance_point>=$value)
								{
									$balance_point= $balance_point-$value;
									mysql_query("update tbl_teacher set tc_balance_point='$balance_point'
									where t_id='$teacher_id' and school_id='$school_id'");
									$Proud_Points=$value/100*$parent_proud_points;
									
									if($subject_id=="0")
									{
										$query_get_points = mysql_query("select points from  tbl_master where from_range>'$points' and to_range<'$points' and activity_id='$activity_id'");
										$reasults=mysql_fetch_array($query_get_points);
										$calculated_point=$reasults['points'];
										mysql_query("INSERT INTO `tbl_student_point` (sc_stud_id,sc_entites_id,sc_teacher_id,sc_studentpointlist_id,sc_point, point_date,sc_status,activity_type,method,school_id,comment)VALUES('".$obj->{'User_Std_id'}."', '103', '".$obj->{'t_id'}."','$activity_id', '$value', '$dates', 'N','activity','$method_id','$school_id','$comment')");
										
										$arr=   mysql_query("select sc_total_point from tbl_student_reward where sc_stud_id='".$obj->{'User_Std_id'}."'
										and school_id='$school_id'");
										
										
										if(mysql_num_rows($arr)>0)
											{
												$row=mysql_fetch_array($arr);
												$original_point=$row['sc_total_point'];
												$total_point=$original_point+$value;
												
												$update=mysql_query("Update tbl_student_reward set sc_total_point='$total_point'where sc_stud_id='".$obj->{'User_Std_id'}."' and school_id='$school_id'");
												$report="Green Points  successfully assigned";
												
												 $sql1=mysql_query("insert into tbl_proud_points_log(Parent_member_id,Proud_Points,Teacher_member_id,Student_member_id,Reason,Comment)values('$Parent_member_id','$Proud_Points','$teacher_id','$std_id','$activity_id','$comment')");
							      $lk=mysql_query("select total_earn_green_point from tbl_parent where Id='$Parent_member_id'");
							                     $row5=mysql_fetch_array($lk);
												$total_earn_green_point =$row5['total_earn_green_point'];
												$parent_point1=$total_earn_green_point+$Proud_Points;
							
												$update=mysql_query("update  tbl_parent set total_earn_green_point='$parent_point1' where ID='$Parent_member_id'");
												
												$posts[]=array('report'=>$report);
												 $postvalue['responseStatus']=200;
				                                 $postvalue['responseMessage']="OK  $total_earn_green_point update  tbl_parent set total_earn_green_point='$parent_point1' where ID='$Parent_member_id'";
				                                  $postvalue['posts']=$posts;
												  
												  header('Content-type: application/json');
   			                                       echo  json_encode($postvalue); 
											}
                             else
							 {
$insert=mysql_query("insert into tbl_student_reward (sc_assigned_by,sc_total_point,sc_stud_id,sc_date,school_id) 
								  values('$teacher_id','$value','$std_id','$dates','$school_id')");
								  $sql1=mysql_query("insert into tbl_proud_points_log
												(Parent_member_id,Proud_Points,Teacher_member_id,Student_member_id,Reason,Comment)
												values('$Parent_member_id''$Proud_Points','$teacher_id','$std_id','$activity_id','$comment')");
												 $lk=mysql_query("select total_earn_green_point from tbl_parent where Id='$Parent_member_id'");
							                     $row5=mysql_fetch_array($lk);
												$total_earn_green_point =$row5['total_earn_green_point'];
												$parent_point1=$total_earn_green_point+$Proud_Points;
							
												$update=mysql_query("update  tbl_parent set total_earn_green_point='$parent_point1' where ID='$Parent_member_id'");
												
								 $report="Green Points  successfully assigned";
												$posts[]=array('report'=>$report);
												 $postvalue['responseStatus']=200;
				                                 $postvalue['responseMessage']="OK $Proud_Points $parent_id";
												 
				                                  $postvalue['posts']=$posts;
												  
												  header('Content-type: application/json');
   			                                       echo  json_encode($postvalue); 
								 
							 }								 
									}
									else
									{
										$query_get_points = mysql_query("select points from  tbl_master where from_range>'$points' and to_range<'$points' and subject_id='$subject_id' ");
										$reasults=mysql_fetch_array($query_get_points);
										$calculated_point=$reasults['points'];
										
										mysql_query("INSERT INTO `tbl_student_point` (sc_stud_id, sc_entites_id, sc_teacher_id, 
										sc_studentpointlist_id, sc_point, point_date, sc_status,activity_type,method,school_id,comment)
										VALUES('".$obj->{'User_Std_id'}."', '103', '".$obj->{'t_id'}."','$subject_id', '$value', '$dates',
										'N','subject','$method_id','$school_id','$comment')");
										$arr=   mysql_query("select sc_total_point from tbl_student_reward where sc_stud_id='".$obj->{'User_Std_id'}."'
										and school_id='$school_id'");
										if(mysql_num_rows($arr)>0)
										{
											$row=   mysql_fetch_array($arr);
											$original_point=$row['sc_total_point'];
											$total_point=$original_point+$points;
											$update=mysql_query("Update tbl_student_reward set sc_total_point='$total_point'
											where sc_stud_id='".$obj->{'User_Std_id'}."' and school_id='$school_id'");
										
										 $sql1=mysql_query("insert into Tbl_proud_points_log(Parent_member_id,Proud_Points,Teacher_member_id,Student_member_id,Reason,Comment)values('$Parent_member_id','$Proud_Points','$teacher_id','$std_id','$activity_id','$comment')");
							 $lk=mysql_query("select total_earn_green_point from tbl_parent where Id='$Parent_member_id'");
							                     $row5=mysql_fetch_array($lk);
												$total_earn_green_point =$row5['total_earn_green_point'];
												$parent_point1=$total_earn_green_point+$Proud_Points;
							
												$update=mysql_query("update  tbl_parent set total_earn_green_point='$parent_point1' where ID='$Parent_member_id'");
												
										$report="Green Points  successfully assigned";
											$posts[]=array('report'=>$report);
											$postvalue['responseStatus']=200;
											$postvalue['responseMessage']="OK";
											$postvalue['posts']=$posts;
											 header('Content-type: application/json');
   			                                       echo  json_encode($postvalue); 
												   
										} 
										 else
							 {
$insert=mysql_query("insert into tbl_student_reward (sc_assigned_by,sc_total_point,sc_stud_id,sc_date,school_id) 
								  values('$teacher_id','$value','$std_id','$dates','$school_id')");
								   $sql1=mysql_query("insert into tbl_proud_points_log
												(Parent_member_id,Proud_Points,Teacher_member_id,Student_member_id,Reason,Comment,)
												values('$Parent_member_id','$Proud_Points','$teacher_id','$std_id','$activity_id','$comment')");
							 $lk=mysql_query("select total_earn_green_point from tbl_parent where Id='$Parent_member_id'");
							                     $row5=mysql_fetch_array($lk);
												$total_earn_green_point =$row5['total_earn_green_point'];
												$parent_point1=$total_earn_green_point+$Proud_Points;
							
												$update=mysql_query("update  tbl_parent set total_earn_green_point='$parent_point1' where ID='$Parent_member_id'");
												
								 $report="Green Points  successfully assigned";
												$posts[]=array('report'=>$report);
												 $postvalue['responseStatus']=200;
				                                 $postvalue['responseMessage']="OK";
												 
				                                  $postvalue['posts']=$posts;
												  
												  header('Content-type: application/json');
   			                                       echo  json_encode($postvalue); 
								 
							 }
									}
									$sq=mysql_query("select t_complete_name,id from tbl_teacher where t_id='$teacher_id'");
									$rows1=mysql_fetch_assoc($sq);
									$t_id1=$rows1['id'];
									$t_name=$rows1['t_complete_name'];
									$s=mysql_query("select id,std_complete_name from tbl_student where std_PRN='$std_id' and school_id='$school_id'");
							$rows=mysql_fetch_array($s);
							$uname=$rows['std_complete_name'];
							$student_id=$rows['id'];
									
									//calling another webservice
									
									
									$server_name = $_SERVER['SERVER_NAME'];
							
									$data = array('Action_Description'=>'Assign Point To Student',
												'Actor_Mem_ID'=>$t_id1,
												'Actor_Name'=>$t_name,
												'Actor_Entity_Type'=>103,
												'Second_Receiver_Mem_Id'=>$student_id,
												'Second_Party_Receiver_Name'=>$uname,
												'Second_Party_Entity_Type'=>105,
												'Third_Party_Name'=>'',
												'Third_Party_Entity_Type'=>'',
												'Coupon_ID'=>'',
												'Points'=>$value,
												'Product'=>'',
												'Value'=>'',
												'Currency'=>''
							);
							
							$ch = curl_init("http://$server_name/core/Version2/master_action_log_ws.php"); 	
							
							
							$data_string = json_encode($data);    
							curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
							curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);  
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);      
							curl_setopt($ch, CURLOPT_HTTPHEADER, array('ContentType: application/json','ContentLength: ' . strlen($data_string)));
							$result = json_decode(curl_exec($ch),true);
							
									//
							}
						 //balance condition finis
							else
							{
								$postvalue['responseStatus']=204;
								$postvalue['responseMessage']="No Response";
								$postvalue['posts']=null;
								 header('Content-type: application/json');
   			                                       echo  json_encode($postvalue); 
							}
							break;
							
							//breck swich for method case
			}
        break;
   case Waterpoint:
	switch ($method_id) {
					case 1|| 2||3 ||4:
					
					
					$sl=mysql_query("select parent_id from tbl_student where school_id='$school_id' and std_PRN='$std_id'");
					$g=mysql_fetch_array($sl);
					$Parent_member_id=$g['parent_id'];
					
					$s=mysql_query("select  parent_proud_points from school_rule_engine where school_id='$school_id'");
					$ss=mysql_fetch_array($s);
					$parent_proud_points=$ss['parent_proud_points'];
					//$Proud_Points=$parent_proud_points/$value*100;
					$Proud_Points=$value/100*$parent_proud_points;
					 //= 22% of x = (22 / 100) * x = 0.22 x 
							$sql=mysql_query("select id from tbl_method where id='$method_id'");
							$values=mysql_fetch_array($sql);
							$mid =$values['id'];
							$arr1=mysql_query("select water_point,t_name,t_middlename,t_lastname from tbl_teacher where t_id='$teacher_id' and school_id='$school_id'");
							
							$val=mysql_fetch_array($arr1);
							$teacher_name=$val['t_name'].' '.$val['t_middlename'].' '.$val['t_lastname'];
							$balance_point=$val['water_point'];
							if($balance_point>=$value)
								{
									$balance_point= $balance_point-$value;
									mysql_query("update tbl_teacher set water_point='$balance_point'where t_id='$teacher_id' and school_id='$school_id'");
									
									if($subject_id=="0")
									{
										$query_get_points = mysql_query("select points from  tbl_master where from_range>'$points' and to_range<'$points' and activity_id='$activity_id'");
										$reasults=mysql_fetch_array($query_get_points);
										$calculated_point=$reasults['points'];
										mysql_query("INSERT INTO `tbl_student_point` (sc_stud_id, sc_entites_id, sc_teacher_id, sc_studentpointlist_id,sc_point, point_date, sc_status,activity_type,method,school_id,comment)VALUES('".$obj->{'User_Std_id'}."', '103', '".$obj->{'t_id'}."','$activity_id', '$value', '$dates', 'N','activity','$method_id','$school_id','$comment')");
										
										$arr=   mysql_query("select sc_total_point from tbl_student_reward where sc_stud_id='".$obj->{'User_Std_id'}."'
										and school_id='$school_id'");
										
										
										if(mysql_num_rows($arr)>0)
											{
												$row=mysql_fetch_array($arr);
												$original_point=$row['sc_total_point'];
												$total_point=$original_point+$value;
												
												$update=mysql_query("Update tbl_student_reward set sc_total_point='$total_point'where sc_stud_id='".$obj->{'User_Std_id'}."' and school_id='$school_id'");
												 $sql1=mysql_query("insert into tbl_proud_points_log(Parent_member_id,Proud_Points,Teacher_member_id,Student_member_id,Reason,Comment)values('$Parent_member_id','$Proud_Points','$teacher_id','$std_id','$activity_id','$comment')");
							
												 $lk=mysql_query("select total_earn_green_point from tbl_parent where Id='$Parent_member_id'");
							                     $row5=mysql_fetch_array($lk);
												$total_earn_green_point =$row5['total_earn_green_point'];
												$parent_point1=$total_earn_green_point+$Proud_Points;
							
												$update=mysql_query("update  tbl_parent set total_earn_green_point='$parent_point1' where ID='$Parent_member_id'");
												
												$report="Green Points  successfully assigned";
												$posts[]=array('report'=>$report);
												 $postvalue['responseStatus']=200;
				                                 $postvalue['responseMessage']="OK";
				                                  $postvalue['posts']=$posts;
												  
												  header('Content-type: application/json');
   			                                       echo  json_encode($postvalue); 
											} 	
											 else
							 {
$insert=mysql_query("insert into tbl_student_reward (sc_assigned_by,sc_total_point,sc_stud_id,sc_date,school_id) 
								  values('$teacher_id','$value','$std_id','$dates','$school_id')");
$sql1=mysql_query("insert into tbl_proud_points_log(Parent_member_id,Proud_Points,Teacher_member_id,Student_member_id,Reason,Comment)values('$Parent_member_id','$Proud_Points','$teacher_id','$std_id','$activity_id','$comment')");
							
							
							 $lk=mysql_query("select total_earn_green_point from tbl_parent where Id='$Parent_member_id'");
							                     $row5=mysql_fetch_array($lk);
												$total_earn_green_point =$row5['total_earn_green_point'];
												$parent_point1=$total_earn_green_point+$Proud_Points;
							
												$update=mysql_query("update  tbl_parent set total_earn_green_point='$parent_point1' where ID='$Parent_member_id'");
												
								 $report="Green Points  successfully assigned";
												$posts[]=array('report'=>$report);
												 $postvalue['responseStatus']=200;
				                                 $postvalue['responseMessage']="OK";
												 
				                                  $postvalue['posts']=$posts;
												  
												  header('Content-type: application/json');
   			                                       echo  json_encode($postvalue); 
								 
							 }
									}
									else
									{
										$query_get_points = mysql_query("select points from  tbl_master where from_range>'$points' and to_range<'$points' and subject_id='$subject_id' ");
										$reasults=mysql_fetch_array($query_get_points);
										$calculated_point=$reasults['points'];
										
										mysql_query("INSERT INTO `tbl_student_point` (sc_stud_id, sc_entites_id, sc_teacher_id, 
										sc_studentpointlist_id, sc_point, point_date, sc_status,activity_type,method,school_id,comment)
										VALUES('".$obj->{'User_Std_id'}."', '103', '".$obj->{'t_id'}."','$subject_id', '$value', '$dates',
										'N','subject','$method_id','$school_id','$comment')");
										$arr=   mysql_query("select sc_total_point from tbl_student_reward where sc_stud_id='".$obj->{'User_Std_id'}."'
										and school_id='$school_id'");
										if(mysql_num_rows($arr)>0)
										{
											$row=   mysql_fetch_array($arr);
											$original_point=$row['sc_total_point'];
											$total_point=$original_point+$points;
											$update=mysql_query("Update tbl_student_reward set sc_total_point='$total_point'
											where sc_stud_id='".$obj->{'User_Std_id'}."' and school_id='$school_id'");
											
											
											//$a=mysql_query("select parent_proud_points from school_rule_engine where school_id='$school_id'");
											//$aa=mysql_num_rows($a);
											
											//$status=$aa['parent_proud_points'];
											
											 $sql1=mysql_query("insert into tbl_proud_points_log(Parent_member_id,Proud_Points,Teacher_member_id,Student_member_id,Reason,Comment)values('$Parent_member_id','$Proud_Points','$teacher_id','$std_id','$activity_id','$comment')");
 $lk=mysql_query("select total_earn_green_point from tbl_parent where Id='$Parent_member_id'");
							                     $row5=mysql_fetch_array($lk);
												$total_earn_green_point =$row5['total_earn_green_point'];
												$parent_point1=$total_earn_green_point+$Proud_Points;
							
												$update=mysql_query("update  tbl_parent set total_earn_green_point='$parent_point1' where ID='$Parent_member_id'");
												
											$report="Water Points  successfully assigned";
											$posts[]=array('report'=>$report);
											$postvalue['responseStatus']=200;
											$postvalue['responseMessage']="OK";
											$postvalue['posts']=$posts;
											 header('Content-type: application/json');
   			                                 echo  json_encode($postvalue); 
										} 
										 else
							 {
$insert=mysql_query("insert into tbl_student_reward (sc_assigned_by,sc_total_point,sc_stud_id,sc_date,school_id) 
								  values('$teacher_id','$value','$std_id','$dates','$school_id')");
								   $sql1=mysql_query("insert into tbl_proud_points_log
												(Parent_member_id,Proud_Points,Teacher_member_id,Student_member_id,Reason,Comment,)
												values('$Parent_member_id','$Proud_Points','$teacher_id','$std_id','$activity_id','$comment')");
							
							 $lk=mysql_query("select total_earn_green_point from tbl_parent where Id='$Parent_member_id'");
							                     $row5=mysql_fetch_array($lk);
												$total_earn_green_point =$row5['total_earn_green_point'];
												$parent_point1=$total_earn_green_point+$Proud_Points;
							
												$update=mysql_query("update  tbl_parent set total_earn_green_point='$parent_point1' where ID='$Parent_member_id'");
												
							
								 $report="Green Points  successfully assigned";
												$posts[]=array('report'=>$report);
												 $postvalue['responseStatus']=200;
				                                 $postvalue['responseMessage']="OK";
												 
				                                  $postvalue['posts']=$posts;
												  
												  header('Content-type: application/json');
   			                                       echo  json_encode($postvalue); 
								 
							 }
									}
							}
						 //balance condition finis
							else
							{
								$postvalue['responseStatus']=204;
								$postvalue['responseMessage']="No Response";
								$postvalue['posts']=null;
								 header('Content-type: application/json');
   			                     echo  json_encode($postvalue); 
							}
							break;

							
							//breck swich for method case
					
							
							//breck swich for method case
			}
			
        break;
    default:
	if($method_id==1 ||$method_id==2 ||$method_id==3||$method_id==4)
        //if($select_opt=='Greenpoint')
		{
		$sql=mysql_query("select id from tbl_method where id=$method_id");
		$values=mysql_fetch_array($sql);
					 $mid =$values['id'];
					 $arr1=mysql_query("select tc_balance_point,t_name,t_middlename,t_lastname from tbl_teacher where t_id='$teacher_id' and school_id='$school_id'");
					$val=mysql_fetch_array($arr1);
					$teacher_name=$val['t_name'].' '.$val['t_middlename'].' '.$val['t_lastname'];
					$balance_point=$val['tc_balance_point'];
					if($balance_point>=$points)
						 {
						 $balance_point= $balance_point-$points;
						 mysql_query("update tbl_teacher set tc_balance_point='$balance_point' where t_id='$teacher_id' and school_id='$school_id'");
						if($subject_id=="0")
								 {
						mysql_query("INSERT INTO `tbl_student_point` (sc_stud_id, sc_entites_id, sc_teacher_id, sc_studentpointlist_id
						sc_point, point_date, sc_status,activity_type,method,school_id,comment)
						VALUES('".$obj->{'User_Std_id'}."', '103', '".$obj->{'t_id'}."',
						'$activity_id', '$points', '$dates', 'N','activity','$method_id','$school_id','$comment')");
						$arr=   mysql_query("select sc_total_point from tbl_student_reward where sc_stud_id='".$obj->{'User_Std_id'}."'
					and school_id='$school_id'");
								  if(mysql_num_rows($arr)>0)
								  {
								  $row=   mysql_fetch_array($arr);
								  $original_point=$row['sc_total_point'];
								$total_point=$original_point+$points;
					 $update=mysql_query("Update tbl_student_reward set sc_total_point='$total_point'
					 where sc_stud_id='".$obj->{'User_Std_id'}."' and school_id='$school_id'");
					 $report="Green Points  successfully assigned";
					  $posts[]=array('report'=>$report);
					 $postvalue['responseStatus']=200;
				     $postvalue['responseMessage']="OK";
					 $postvalue['posts']=$posts;
					  header('Content-type: application/json');
   			          echo  json_encode($postvalue); 
								 } 
							}
                        else
						{
						 mysql_query("INSERT INTO `tbl_student_point` (sc_stud_id, sc_entites_id, sc_teacher_id, 
						 sc_studentpointlist_id, sc_point, point_date, sc_status,activity_type,method,school_id,comment)
						 VALUES('".$obj->{'User_Std_id'}."', '103', '".$obj->{'t_id'}."','$subject_id', '$points', '$dates',
						 'N','subject','$method_id','$school_id','$comment')");
					$arr=   mysql_query("select sc_total_point from tbl_student_reward where sc_stud_id='".$obj->{'User_Std_id'}."'
					and school_id='$school_id'");
								  if(mysql_num_rows($arr)>0)
								  {
								  $row=   mysql_fetch_array($arr);
								  $original_point=$row['sc_total_point'];
								$total_point=$original_point+$points;
					 $update=mysql_query("Update tbl_student_reward set sc_total_point='$total_point'
					 where sc_stud_id='".$obj->{'User_Std_id'}."' and school_id='$school_id'");
					 $report="Green Points  successfully assigned";
					  $posts[]=array('report'=>$report);
					 $postvalue['responseStatus']=200;
				     $postvalue['responseMessage']="OK";
					 $postvalue['posts']=$posts;
					  header('Content-type: application/json');
   			           echo  json_encode($postvalue); 
								 } 
						}
						 }
						 //balance condition finis
						 else
						 {
						 $postvalue['responseStatus']=204;
						$postvalue['responseMessage']="No Response";
						$postvalue['posts']=null;
						 header('Content-type: application/json');
   			             echo  json_encode($postvalue); 
						 }
	
	}  


    
	
	//
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