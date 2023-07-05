<?php  
//$json=$_GET ['json'];
error_reporting(0);
require_once('function.php');
require_once('config.php');
$json = file_get_contents('php://input');
$obj = json_decode($json);

 $format = 'json'; //xml is the default


include 'conn.php';
// Start SMC-3450 Modify By Pravin 2018-09-20 07:30 PM 
//$date=date("d/m/Y");
$date=CURRENT_TIMESTAMP;
//input from user
    $stud_id1=$obj->{'stud_id1'};
	$stud_id2=$obj->{'stud_id2'};
	$reason=$obj->{'reason'};
	$points=$obj->{'points'};
	$school_id=$obj->{'school_id'};
	$query12 = mysql_query("select id,std_name,std_lastname from tbl_student where std_PRN ='$stud_id1' and school_id='$school_id'");
	$result1=mysql_fetch_array($query12);  // NAME OF SENDER
	$fname1=$result1['std_name']; 
	$lname1=$result1['std_lastname'];	
	$m_id_sender=$result1['id'];
	$query2 = mysql_query("select id,std_name,std_lastname from tbl_student where std_PRN ='$stud_id2' and school_id='$school_id'");
	$result=mysql_fetch_array($query2);   // NAME OF RECEIVER
	$fname=$result['std_name']; 
     $m_id_receiver=$result['id']; 	
	$lname=$result['std_lastname'];
    $query1 = mysql_query("select gcm_id from student_gcmid where std_PRN ='$stud_id'");
	$result12=mysql_fetch_array($query1);
	$gcmRegID=array();
	
	if(mysql_num_rows($result12)>=1)
	{
				 
				 while($row = mysql_fetch_assoc($result12))
				 {  
					$gcmRegID[] = $row['gcm_id'];
					
				 }
	}	 
	$msg="RequstForPoints,$stud_id1,$reason,$points,$date|Hello $fname $lname ,$fname1 $lname1 is requesting $points points for $reason.";
	//$query1 = mysql_query("select Gcm_id from tbl_student where std_PRN ='$stud_id2'");
	//$result=mysql_fetch_array($query1);
	//$gcm_id=$result['Gcm_id'];    
	//$gcmRegID    = $gcm_id;
	$pushMessage = $msg; 

	/* create one master array of the records */
				$posts = array();
	
	//id of student stud_id
	// Start SMC-3450 Modify By Pravin 2018-09-12 01:030 PM 
	//$request_date = date('m/d/Y');
	$request_date = CURRENT_TIMESTAMP;
	
	
    if((($stud_id1!="" && $stud_id2!="") || !empty($gcmRegID))  && $reason!="" && $points!="" && $school_id!="" )
	{
			//retrive info from tbl_student_point and tbl_studentpointslist,tbl_teacher
			
				
				 
				 $sql=mysql_query("select * from tbl_request where stud_id1='$stud_id1' and stud_id2='$stud_id2' and reason like '$reason' and flag='N' and requestdate='$request_date' and points='$points' and entitity_id='105' and school_id='$school_id'");
				 
				 
			 $count=mysql_num_rows($sql);
			 if($count==0)
			 {			
				$arr = mysql_query("insert into tbl_request(stud_id1,stud_id2,reason,points,requestdate,flag,entitity_id,school_id) values('$stud_id1','$stud_id2','$reason','$points','$request_date','N','105','$school_id')");
				$report="Request Sent Successfully";
				
					if (isset($gcmRegID) && isset($pushMessage)) 
					{
						$registatoin_ids = $gcmRegID;
						$message = array("msg" => $pushMessage);
						foreach ($registatoin_ids as $registatoin_ids)
						{
								$result = send_push_notification($registatoin_ids, $message);
						}
					}
					
					
			 
			 $server_name = $GLOBALS['URLNAME'];
			 
							
									$data = array('Action_Description'=>' Points Request To Student',
												'Actor_Mem_ID'=>$m_id_sender,
												'Actor_Name'=>$fname1,
												'Actor_Entity_Type'=>105,
												'Second_Receiver_Mem_Id'=>$m_id_receiver,
												'Second_Party_Receiver_Name'=>$fname,
												'Second_Party_Entity_Type'=>105,
												'Third_Party_Name'=>'',
												'Third_Party_Entity_Type'=>'',
												'Coupon_ID'=>'',
												'Points'=>$points,
												'Product'=>'',
												'Value'=>'',
												'Currency'=>''
							);
							
							$ch = curl_init("$server_name/core/Version2/master_action_log_ws.php"); 	
							//End SMC-3450
							
							$data_string = json_encode($data);    
							curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
							curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);  
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);      
							curl_setopt($ch, CURLOPT_HTTPHEADER, array('ContentType: application/json','ContentLength: ' . strlen($data_string)));
							$result = json_decode(curl_exec($ch),true);
			 
			 //end	
						
					 $posts[]=array('report'=>$report);
					
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
			
	  
  /* disconnect from the db */
  @mysql_close($link);	
	
		
  ?>
