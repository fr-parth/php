<?php  
//require_once('loader.php');
require_once('function.php');
require_once('config.php');
error_reporting(0);
//$json=$_GET ['json'];
$json = file_get_contents('php://input');
$obj = json_decode($json);
$format = 'json'; 

include 'conn.php';
							/* $con = mysql_connect('SmartCookies.db.7121184.hostedresource.com','SmartCookies','Bpsi@1234') 
								   or die('Cannot connect to the DB');
							mysql_select_db('SmartCookies',$con); */

   $id=$obj->{'id'};         // Sender ID
   $stud_id=$obj->{'stud_id'};  // Receiver ID
   $points=$obj->{'points'};
   $reason=$obj->{'reason'};
   $select_opt=$obj->{'Points_type'};
   $posts = array();
   
    $query2 = mysql_query("select std_name,std_lastname from tbl_student where std_PRN ='$id'");
	$result=mysql_fetch_array($query2);
	$fname=$result['std_name'];        // NAME OF SENDER
	$lname=$result['std_lastname']; 
	$msg="receive from|Congratulation! You got $points points from $fname $lname for $reason.";
	$query1 = mysql_query("select gcm_id from student_gcmid where std_PRN ='$stud_id'");
	$result1=mysql_fetch_array($query1);
	$gcmRegID=array();
	$pushMessage = $msg; 
	if(mysql_num_rows($result1)>=1)
			{
				 
				 while($row = mysql_fetch_assoc($result1))
				 {  
					$gcmRegID[] = $row['gcm_id'];
					
				 }
			}	 
  
if(($stud_id!="" || !empty($gcmRegID)) && $points!="" && $id!="" && $reason!="" && $select_opt!="")
{
     if($select_opt=='Greenpoint') 
	 {
			$query = mysql_query("select sc_total_point,sc_stud_id, sc_reward from tbl_student_reward where sc_stud_id ='$id' ");

			$result=mysql_fetch_array($query);
			$sc_total_point=$result['sc_total_point'];


				if($points<=$sc_total_point)
					{
						$date=Date('d/m/Y');
						$sql=mysql_query("select * from tbl_student_reward where sc_stud_id='$stud_id'");
						$result=mysql_fetch_array($sql);
						$sc_final_point=$result['yellow_points']+$points;
		
							$sql1=mysql_query("update tbl_student_reward set yellow_points='$sc_final_point' where sc_stud_id='$stud_id'");
							
							$sc_share_point=$sc_total_point-$points;
							$query=mysql_query("update tbl_student_reward set sc_total_point='$sc_share_point' where sc_stud_id='$id'");
							$test=mysql_query("insert into tbl_student_point(sc_entites_id,sc_point,sc_teacher_id,sc_stud_id,reason,point_date) values('105','$points','$id','$stud_id','$reason','$date')");
							$report=" Green points are successfully shared ";
		
							if (isset($gcmRegID) && isset($pushMessage)) 
							{
								$registatoin_ids = $gcmRegID;
								$message = array("msg" => $pushMessage);
								foreach ($registatoin_ids as $registatoin_ids)
								{
									$result = send_push_notification($registatoin_ids, $message);
								}
								//$test="$points Points are shared succesfully";
							}
							$posts[]=array('report'=>$report);
							$postvalue['responseStatus']=200;
							$postvalue['responseMessage']="OK";
							$postvalue['posts']=$posts;
	       
		   
					}
					else{
						 $postvalue['responseStatus']=204;
								$postvalue['responseMessage']="Green points are insufficient";
								$postvalue['posts']=null;
						
					}
					
	}
	 
	 elseif($select_opt=='Purplepoint') 
	 {
				$query = mysql_query("select purple_points,sc_stud_id, sc_reward from tbl_student_reward where sc_stud_id ='$id' ");

				$result=mysql_fetch_array($query);
				$purple_points=$result['purple_points'];


					if($points<=$purple_points)
					{
						$date=Date('d/m/Y');
						$sql=mysql_query("select * from tbl_student_reward where sc_stud_id='$stud_id'");
						$result=mysql_fetch_array($sql);
						$sc_final_point=$result['yellow_points']+$points;
		
						$sql1=mysql_query("update tbl_student_reward set yellow_points='$sc_final_point' where sc_stud_id='$stud_id'");
						
						$sc_share_point=$purple_points-$points;
						$query=mysql_query("update tbl_student_reward set purple_points='$sc_share_point' where sc_stud_id='$id'");
						$test=mysql_query("insert into tbl_student_point(sc_entites_id,sc_point,sc_teacher_id,sc_stud_id,reason,point_date) values('105','$points','$id','$stud_id','$reason','$date')");
						$report="Purple points are successfully shared";
		
								if (isset($gcmRegID) && isset($pushMessage)) 
								{
									$registatoin_ids = $gcmRegID;
									$message = array("msg" => $pushMessage);
									foreach ($registatoin_ids as $registatoin_ids)
									{
										$result = send_push_notification($registatoin_ids, $message);
									}
									//$test="$points Points are shared succesfully";
								}
								$posts[]=array('report'=>$report);
								$postvalue['responseStatus']=200;
								$postvalue['responseMessage']="OK";
								$postvalue['posts']=$posts;
	       
		   
					}
					else{
								$postvalue['responseStatus']=204;
								$postvalue['responseMessage']="Purple points are insufficient";
								$postvalue['posts']=null;
						
					}
	 }
	 
	  elseif($select_opt=='yellowpoints') 
		{
				$query = mysql_query("select yellow_points,sc_stud_id, sc_reward from tbl_student_reward where sc_stud_id ='$id' ");

				$result=mysql_fetch_array($query);
				$yellow_points=$result['yellow_points'];


					if($points<=$yellow_points)
					{
						$date=Date('d/m/Y');
						$sql=mysql_query("select * from tbl_student_reward where sc_stud_id='$stud_id'");
						$result=mysql_fetch_array($sql);
						$sc_final_point=$result['yellow_points']+$points;
		
							$sql1=mysql_query("update tbl_student_reward set yellow_points='$sc_final_point' where sc_stud_id='$stud_id'");
							
							$sc_share_point=$yellow_points-$points;
							$query=mysql_query("update tbl_student_reward set yellow_points='$sc_share_point' where sc_stud_id='$id'");
							$test=mysql_query("insert into tbl_student_point(sc_entites_id,sc_point,sc_teacher_id,sc_stud_id,reason,point_date) values('105','$points','$id','$stud_id','$reason','$date')");
							$report="Yellow points are successfully shared";
		
							if (isset($gcmRegID) && isset($pushMessage)) 
							{
								$registatoin_ids = $gcmRegID;
								$message = array("msg" => $pushMessage);
								foreach ($registatoin_ids as $registatoin_ids)
								{
									$result = send_push_notification($registatoin_ids, $message);
								}
								//$test="$points Points are shared succesfully";
							}
							$posts[]=array('report'=>$report);
							$postvalue['responseStatus']=200;
							$postvalue['responseMessage']="OK";
							$postvalue['posts']=$posts;
	       
		   
					}
					else{
								$postvalue['responseStatus']=204;
								$postvalue['responseMessage']="Yellow points are insufficient";
								$postvalue['posts']=null;
						
					}
		}
	
	elseif($select_opt=='waterpoints') 
		{
				$query = mysql_query("select balance_water_points from tbl_student where std_PRN ='$id' ");

				$result=mysql_fetch_array($query);
				$water_points=$result['balance_water_points'];


					if($points<=$water_points)
					{
						$date=Date('d/m/Y');
						$sql=mysql_query("select balance_water_points from tbl_student where std_PRN='$stud_id'");
						$result=mysql_fetch_array($sql);
						$sc_final_point=$result['balance_water_points']+$points;
		
							$sql1=mysql_query("update tbl_student set balance_water_points='$sc_final_point' where std_PRN='$stud_id'");
							
							$sc_share_point=$water_points-$points;
							$query=mysql_query("update tbl_student set balance_water_points='$sc_share_point' where std_PRN='$id'");
							$test=mysql_query("insert into tbl_student_point(sc_entites_id,sc_point,sc_teacher_id,sc_stud_id,reason,point_date) values('105','$points','$id','$stud_id','$reason','$date')");
							$report="Water points are successfully shared";
		
							if (isset($gcmRegID) && isset($pushMessage)) 
							{
								$registatoin_ids = $gcmRegID;
								$message = array("msg" => $pushMessage);
								foreach ($registatoin_ids as $registatoin_ids)
								{
									$result = send_push_notification($registatoin_ids, $message);
								}
								//$test="$points Points are shared succesfully";
							}
							$posts[]=array('report'=>$report);
							$postvalue['responseStatus']=200;
							$postvalue['responseMessage']="OK";
							$postvalue['posts']=$posts;
	       
		   
					}
					else{
								$postvalue['responseStatus']=204;
								$postvalue['responseMessage']="Water points are insufficient";
								$postvalue['posts']=null;
						
					}
		}
	
}

					if($format == 'json')
						{
							header('Content-type: application/json');
    						 echo json_encode($postvalue);
						}

						else
						{
		   
							$postvalue['responseStatus']=1000;
							$postvalue['responseMessage']="Invalid Input";
							$postvalue['posts']=null;
				  
							header('Content-type: application/json');
							echo  json_encode($postvalue); 
		   
						}
//
  //$posts = array($json);
  
	
		
  ?>