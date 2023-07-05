<?php
include '../conn.php';
//add space
$json = file_get_contents('php://input');
$obj = json_decode($json);

	$sc_id = $obj->{'school_id'};
	// $limit = $obj->{'limit'};
	$t_id = $obj->{'teacher_id'};
	// $entity_name = $obj->{'entity_key'};
	$years = $obj->{'academic_year'};
	$feedback_score = 0;
		
	//echo $limit;exit;
		if(!empty($sc_id))
		{
				
		              //teachingprocess
						$query="SELECT feed360_semester_ID, feed360_subject_code,feed360_classes_scheduled, feed360_actual_classes
                        FROM tbl_360feedback_template
                        WHERE feed360_school_id='$sc_id' and feed360_teacher_id='$t_id' and feed360_academic_year_ID='$years' ";
						
				  		$teaching_process = mysql_query($query) or die('Errant query:  '.$query);
						  $tc_row_count = mysql_num_rows($teaching_process);
                        //   print_r($query);
						
						$temp = 0;

						while($rows = mysql_fetch_array($teaching_process) )
						{
							$tc_array[] = array_map(clean_string,$rows);
							$tc = round((($rows['feed360_actual_classes'] /$rows['feed360_classes_scheduled'])*25),2);
         
                                $temp = $temp+$tc;
                                $tc_sum = round(($temp/$tc_row_count),2);
								if($tc_sum > 25	)
								{
									$t = mysql_query("SELECT total_points from tbl_360activity_level where actL360_activity_level = 'Teaching Process' ");
									$tc = mysql_fetch_array($t);
									$tc_sum = $tc['total_points'];
								}
						}
						// echo $tc_sum;exit;					
						
					//departmental_activity
						$dept_total=0;
						$dept_cnt=0;
                       
                            $query="SELECT semester_name, activity_name,credit_point,criteria
                              		FROM tbl_360_activities_data
                             		WHERE schoolID='$sc_id' and Receiver_tID='$t_id' and activity_level_id='1' and Academic_Year='$years'";
                        
						
				  		$departmental_activity = mysql_query($query) or die('Errant query:  '.$query);
						$dp_row_count = mysql_num_rows($departmental_activity);

						while($rows = mysql_fetch_array($departmental_activity) )
						{
							
							$dept_array[] = array_map(clean_string,$rows);
							$dept_total+= $rows['credit_point'];
                            if($dept_total > 20	)
								{
									$dp = mysql_query("SELECT total_points from tbl_360activity_level where actL360_activity_level = 'Departmental Activities' ");
									$dpt = mysql_fetch_array($t);
									$dept_total = $dpt['total_points'];
								}
						}
						// echo $dept_total;exit;
						// print_r($dept_array);exit;
						// echo $dept_feed;exit;
                        
					 
					 //studentfeedback
                            $query ="SELECT count(stu_feed_ID) as count ,stu_feed_semester_ID, stud_subjcet_code,sum(stu_feed_points) as stu_feed_points
                            FROM tbl_student_feedback
                            WHERE stu_feed_school_id='$sc_id' and stu_feed_teacher_id='$t_id' and stu_feed_academic_year='$years' group by stud_subjcet_code";
                        
							$stud_feed =  mysql_query($query) or die('Errant query:  '.$query);
							$stud_row_count = mysql_num_rows($stud_feed);
							$temp1 = 0;
						while($rows = mysql_fetch_array($stud_feed) )
						{
							$stud_array[] =array_map(clean_string,$rows);
							$avg_stud_feed=round((($rows['stu_feed_points'])*(25/(5*$rows['count']))),2);
							$temp1=$temp1+$avg_stud_feed;
                            $st_feed = round(($temp1/$stud_row_count),2);
							if($st_feed > 25)
							{
								$s = mysql_query("SELECT total_points from tbl_360activity_level where actL360_activity_level = 'Students Feedback' ");
								$st = mysql_fetch_array($s);
								$st_feed = $st['total_points'];
							}
						}
						// echo $st_feed;exit;

						// print_r($stud_array);exit;

					 	//institute_activity
                        
                            $query="SELECT semester_name, activity_name,credit_point,criteria
                            FROM tbl_360_activities_data
                            WHERE schoolID='$sc_id' and Receiver_tID='$t_id' and activity_level_id='2' and Academic_Year='$years'" ;
						
				  		$inst_feed = mysql_query($query) or die('Errant query:  '.$query);
						$inst_row_count = mysql_num_rows($inst_feed);

						$institute_total = 0;
                        $institute_cnt = 0;
						while($rows = mysql_fetch_array($inst_feed) )
						{
							$inst_array[] =array_map(clean_string,$rows);
							$institute_cnt++;
         					$institute_total+=$rows['credit_point'];
                            $inst_feed_sum = round(($institute_total),2); 	

							if($inst_feed_sum > 10)
							{
								$inst_max_sql = mysql_query("select total_points from tbl_360activity_level where actL360_activity_level = 'Institute Activities' ");
                                $inst_res = mysql_fetch_array($inst_max_sql);
                                $inst_feed_sum = $inst_res['total_points'];
							}
						}
						
						// echo $inst_feed_sum;exit;
						// print_r($inst_array);exit;
					 
						//ACR
                        
                            $query="SELECT a.Academic_Year, a.activity_name,a.credit_point,a.criteria
                            FROM tbl_360_activities_data a join tbl_academic_Year y on a.schoolID=y.school_id and a.Academic_Year=y.Academic_Year
                            WHERE a.schoolID='$sc_id' and a.Receiver_tID='$t_id' and a.activity_level_id='4' and a.Academic_Year='$years'";
                        
				  		$acr_feed = mysql_query($query) or die('Errant query:  '.$query);
						$acr_rows_count = mysql_num_rows($acr_feed);
						
						$ACR_total = 0;
						while($rows = mysql_fetch_array($acr_feed) )
						{
							$acr_array[] = array_map(clean_string,$rows);
							$ACR_total+= $rows['credit_point'];
                            $acr_feed_sum = round(($ACR_total/$acr_rows_count),2); 
							if($acr_feed_sum > 10	)
							{
								$a = mysql_query("SELECT total_points from tbl_360activity_level where actL360_activity_level = 'ACR' ");
								$ac = mysql_fetch_array($t);
								$acr_feed_sum = $ac['total_points'];
							}
						}
						// echo $acr_feed_sum;exit;
						// echo $acr_feed_sum;exit;
                        //  print_r($acr_array);exit;
					  
						//society contribution
                            $query="SELECT semester_name, activity_name,credit_point,criteria
                            FROM tbl_360_activities_data
                            WHERE schoolID='$sc_id' and Receiver_tID='$t_id' and activity_level_id='3' and Academic_Year='$years'";

				  		$soc_feed = mysql_query($query) or die('Errant query:  '.$query);
						$soc_row_count = mysql_num_rows($soc_feed);

						$contribution_total = 0;
						$contribution_cnt = 0;
						while($rows = mysql_fetch_array($soc_feed) )
						{
							$soc_array[] = array_map(clean_string,$rows);
							$contribution_cnt++;
							$contribution_total+= $rows['credit_point'];
							
							if($contribution_total > 10)
							{
								$soc_sql = mysql_query("select total_points from tbl_360activity_level where actL360_activity_level = 'Contribution to Society' ");
								$soc_res = mysql_fetch_array($soc_sql);
								$contribution_total = $soc_res['total_points'];
							}
						}
						// echo $contribution_total;exit;
					 	// print_r($soc_array);exit;

						$total = $tc_sum + $acr_feed_sum + $dept_total + $st_feed + $inst_feed_sum + $contribution_total;
						// $grand_total = array("total_sum"=>$total);
						// echo $grand_total;exit;
						$sum = array(
							"teaching_process"=>$tc_sum , 
							"Dept_activity"=>$dept_total , 
							"ACR"=>$acr_feed_sum , 
							"stud_feed_sum"=>$st_feed,
							"soc_contri"=>$contribution_total,
							"inst_feed_sum"=>$inst_feed_sum,
							"grand_total"=>$total
						);
						// print_r($sum);exit;
						/* create one master array of the records */
						$posts = array();
						
							$postvalue['responseStatus']=200;
							$postvalue['responseMessage']="OK";
							$postvalue['teaching']= $tc_array ;
							$postvalue['acr']= $acr_array ;
							$postvalue['department']= $dept_array ;
							$postvalue['student']= $stud_array ;
							$postvalue['institute']= $inst_array ;
							$postvalue['society']= $soc_array ;
							$postvalue['sum_details']= $sum ;
							// $postvalue['grand_total']= $grand_total ;
							// $postvalue['posts']=$posts;
							header('Content-type: application/json');
							echo json_encode($postvalue);
						// }else
						// {
							
						// 	$postvalue['responseStatus']=204;
						// 	$postvalue['responseMessage']="Not Found";
						// 	$postvalue['posts']=null;
						// 	header('Content-type: application/json');
						// 	echo json_encode($postvalue);
						// }
							


		}else
			{

			   	$postvalue['responseStatus']=1000;
				$postvalue['responseMessage']="Invalid Input";
				$postvalue['posts']=null;

			  header('Content-type: application/json');
 			  echo  json_encode($postvalue);

			}

  @mysql_close($con);

?>