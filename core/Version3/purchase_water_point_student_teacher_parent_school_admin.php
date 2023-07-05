<?php
error_reporting(0);
$json = file_get_contents('php://input');
$obj = json_decode($json);

include '../conn.php';

  $card_no = $obj->{'card_no'};
  $user_id = $obj->{'user_id'};
  $school_id=$obj->{'school_id'};
  $entity_id=$obj->{'entity_id'};
  $color = $obj->{'point_color'};
  
 
  
if(($card_no == '' || $user_id == '' || $entity_id == '' || $school_id == '') && $entity_id != '106')
{
	$postvalue['responseStatus']=1000;
	$postvalue['responseMessage']="Please enter gift card number";
	$postvalue['posts']=null;
	header('Content-type: application/json');
	echo json_encode($postvalue);
	exit;
} 
else if(($card_no == '' || $user_id == '' || $entity_id == '') && $entity_id == '106')
{
	$postvalue['responseStatus']=1001;
	$postvalue['responseMessage']="Invalid inputs";
	$postvalue['posts']=null;
	header('Content-type: application/json');
	echo json_encode($postvalue);
	exit;
} 
else if($color=='' && $entity_id == '102')
{
	$postvalue['responseStatus']=1002;
	$postvalue['responseMessage']="Enter color name";
	$postvalue['posts']=null;
	header('Content-type: application/json');
	echo json_encode($postvalue);
	exit;
} 
else
{
	$server_name =  $GLOBALS['URLNAME'];//SMC-3507	
$query="SELECT * FROM `tbl_giftcards` where card_no='$card_no'";
		$result = mysql_query($query) or die('Errant query:  '.$query);
        $count = mysql_num_rows($result);
		$value2=mysql_fetch_array($result);
		$amount=$value2['amount'];
		$issue_date=$value2['issue_date'];
		$valid_to=$value2['valid_to'];
		$status=$value2['status'];

		 //$date1=date('m/d/Y');
		 //Modify by Pravin date format on 14/09/2018 8:17 PM
		 //$date1=date('d/m/Y');
		 //SMC-3507 Modify by Pravin date format on 2018-10-10 8:14 PM
		 $date1=CURRENT_TIMESTAMP;
		 //end modify

if($count=='0')
{
	$postvalue['responseStatus']=1003;
	$postvalue['responseMessage']="Invalid card no";
	$postvalue['posts']=null;
	header('Content-type: application/json');
	echo json_encode($postvalue);
	exit;
}
if($status=='Used')
{
	$postvalue['responseStatus']=1004;
	$postvalue['responseMessage']="This gift card already used";
	$postvalue['posts']=null;
	header('Content-type: application/json');
	echo json_encode($postvalue);
	exit;
}
else
{
		if (strtotime($date1) <= strtotime($valid_to))
		{
			switch($entity_id)
			{
				//School Admin
				case  '102':
						
						if($color=='BLUE')
						{
							
							$selectschool="select name,school_name, balance_blue_points from tbl_school_admin where id='$user_id'";
							$result = mysql_query($selectschool) or die('Errant query:  '.$selectschool);
      			  $arrs=mysql_fetch_array($result);
				  $count=mysql_num_rows($result);
							if($count == '0')
							{
								$postvalue['responseStatus']=1005;
								$postvalue['responseMessage']="Record Not found";
								$postvalue['posts']=null;
								header('Content-type: application/json');
								echo json_encode($postvalue);
								exit;
							}
							else{
								$balance_blue_points=$arrs['balance_blue_points'];
								$admin_name=$arrs['name'];
								$username=$arrs['school_name'];
								$balance_blue_points=$balance_blue_points+$amount;
								$query1="update tbl_school_admin set balance_blue_points='$balance_blue_points' where id='$user_id'";
								$result = mysql_query($query1) or die('Errant query:  '.$query1);
								$update="update  tbl_giftcards  set  amount='0' ,status='Used' where card_no='$card_no'";
							$result = mysql_query($update) or die('Errant query:  '.$update);
							
							$insert="insert into tbl_giftof_bluepoint(coupon_id,points,issue_date,entities_id,user_id)values('$card_no','$amount','$date1','$entity_id','$user_id')";
							$result = mysql_query($insert) or die('Errant query:  '.$insert);
							
							if($username=='')
							{
								$username = $admin_name;
								
							}
							else
							{
								$username;
							}
							
							}
						
						}
						else if($color=='GREEN')
						{
							$selectschool="select name,school_name, school_balance_point from tbl_school_admin where id='$user_id'";
							$result = mysql_query($selectschool) or die('Errant query:  '.$selectschool);
      			  $arrs=mysql_fetch_array($result);
				  $count=mysql_num_rows($result);
							if($count == '0')
							{
								$postvalue['responseStatus']=1006;
								$postvalue['responseMessage']="Record Not found";
								$postvalue['posts']=null;
								header('Content-type: application/json');
								echo json_encode($postvalue);
								exit;
							}
							else{
								$balance_green_points=$arrs['school_balance_point'];
								$admin_name=$arrs['name'];
								$username=$arrs['school_name'];
								$balance_green_points=$balance_green_points+$amount;
								$query1="update tbl_school_admin set school_balance_point='$balance_green_points' where id='$user_id'";
								$result = mysql_query($query1) or die('Errant query:  '.$query1);
								$update="update  tbl_giftcards  set  amount='0' ,status='Used' where card_no='$card_no'";
							$result = mysql_query($update) or die('Errant query:  '.$update);
							
							$insert="insert into tbl_giftof_rewardpoint(coupon_id,point,issue_date,entity,user_id)values('$card_no','$amount','$date1','$entity_id','$user_id')";
							$result = mysql_query($insert) or die('Errant query:  '.$insert);
							
							if($username=='')
							{
								$username = $admin_name;
								
							}
							else
							{
								$username;
							}
							
						}
					}
					else if($color=='WATER')
						{
							$selectschool="select name,school_name, balance_water_point,group_member_id from tbl_school_admin where id='$user_id'";
							$result = mysql_query($selectschool) or die('Errant query:  '.$selectschool);
      			  $arrs=mysql_fetch_array($result);
				  $count=mysql_num_rows($result);
							if($count == '0')
							{
								$postvalue['responseStatus']=1006;
								$postvalue['responseMessage']="Record Not found";
								$postvalue['posts']=null;
								header('Content-type: application/json');
								echo json_encode($postvalue);
								exit;
							}
							else{
								$balance_water_point=$arrs['balance_water_point'];
								$admin_name=$arrs['name'];
								$username=$arrs['school_name'];
								$group_member_id=$arrs['group_member_id'];
								$balance_water_point=$balance_water_point+$amount;
								$query1="update tbl_school_admin set balance_water_point='$balance_water_point' where id='$user_id'";
								$result = mysql_query($query1) or die('Errant query:  '.$query1);
								$update="update  tbl_giftcards  set  amount='0' ,status='Used' where card_no='$card_no'";
							$result = mysql_query($update) or die('Errant query:  '.$update);
							
							$insert="insert into tbl_waterpoint(coupon_id,points,issue_date,entities_id,School_Member_Id,school_id,group_member_id)values('$card_no','$amount','$date1','$entity_id','$user_id','$school_id','$group_member_id')";
							$result = mysql_query($insert) or die('Errant query:  '.$insert);
							
							if($username=='')
							{
								$username = $admin_name;
								
							}
							else
							{
								$username;
							}
							
						}
					}
					else{
								$postvalue['responseStatus']=1007;
								$postvalue['responseMessage']="color not match";
								$postvalue['posts']=null;
								header('Content-type: application/json');
								echo json_encode($postvalue);
								exit;
					}
							
				 break;
				 //Teacher
				case  '103':
						
				
				$selectteacher="select id,t_id,t_complete_name,t_name,t_middlename,t_lastname,water_point,group_member_id from tbl_teacher where id='$user_id'";
				$result = mysql_query($selectteacher) or die('Errant query:  '.$selectteacher);
				$result_query=mysql_fetch_array($result);
				$count=mysql_num_rows($result);
				if($count == '0')
							{
								$postvalue['responseStatus']=1008;
								$postvalue['responseMessage']="Record Not found";
								$postvalue['posts']=null;
								header('Content-type: application/json');
								echo json_encode($postvalue);
								exit;
							}
							else
							{
							$balance_water_points=$result_query['water_point'];
							$complete_name=$result_query['t_complete_name'];
							$name=$result_query['t_name'];
							$t_id=$result_query['t_id'];
							$mname=$result_query['t_middlename'];
							$lname=$result_query['t_lastname'];
							$group_member_id=$result_query['group_member_id'];
							
							$balance_water_points=$balance_water_points+$amount;
							
							$query1="update tbl_teacher set water_point='$balance_water_points' where id='$user_id'";
							$result = mysql_query($query1) or die('Errant query:  '.$query1);
							$update="update  tbl_giftcards  set  amount='0' ,status='Used' where card_no='$card_no'";
							$result = mysql_query($update) or die('Errant query:  '.$update);
							
							$test=("insert into tbl_waterpoint(coupon_id,points,issue_date,entities_id,stud_id,school_id,Teacher_Member_Id,group_member_id)values('$card_no','$amount','$date1','$entity_id','$t_id','$school_id','$user_id','$group_member_id')");
							$result = mysql_query($test) or die('Errant query:  '.$test);
							
							//calling master action webservice
							if($complete_name=='')
							{
								$username = $name." ".$mname." ".$lname;
							}
							else{
								$username=$complete_name;
							}
							}
				 break;
				 //Student
				case  '105':
				 
				 
							$selectstudinfo="select id,std_PRN,std_complete_name,std_name,std_lastname,std_Father_name,balance_water_points,group_member_id from tbl_student where id='$user_id'";
							$result = mysql_query($selectstudinfo) or die('Errant query:  '.$selectstudinfo);
							
							$result_query=mysql_fetch_array($result);
							$count=mysql_num_rows($result);
							
							if($count == '0')
							{
								$postvalue['responseStatus']=1009;
								$postvalue['responseMessage']="Record Not found";
								$postvalue['posts']=null;
								header('Content-type: application/json');
								echo json_encode($postvalue);
								exit;
							}
							else
							{
							 $balance_water_points=$result_query['balance_water_points'];
							$std_complete_name=$result_query['std_complete_name'];
							$std_name=$result_query['std_name'];
							$std_PRN=$result_query['std_PRN'];
							$std_mname=$result_query['std_Father_name'];
							$std_lname=$result_query['std_lastname'];
							$group_member_id=$result_query['group_member_id'];
							
							$balance_water_points=$balance_water_points+$amount;
							
							$query1="update tbl_student set balance_water_points='$balance_water_points' where id='$user_id'";
							$result = mysql_query($query1) or die('Errant query:  '.$query1);
							$update="update  tbl_giftcards  set  amount='0' ,status='Used' where card_no='$card_no'";
							$result = mysql_query($update) or die('Errant query:  '.$update);
							
							$test="insert into tbl_waterpoint(coupon_id,points,issue_date,entities_id,stud_id,school_id,Stud_Member_Id,group_member_id)values('$card_no','$amount','$date1','$entity_id','$std_PRN','$school_id','$user_id','$group_member_id')";
							$result = mysql_query($test) or die('Errant query:  '.$test);
							
							//calling master action webservice
							if($std_complete_name=='')
							{
								$username = $std_name." ".$std_mname." ".$std_lname;
							}
							else{
								$username=$std_complete_name;
							}
							}
				 break;
				 
				 //Parent
				case  '106':
						
						$selectparent="select Name,Mother_name,balance_points,group_member_id from tbl_parent where Id='$user_id'";
							$result = mysql_query($selectparent) or die('Errant query:  '.$selectparent);
							$result_query=mysql_fetch_array($result);
							$count=mysql_num_rows($result);
							
							if($count == '0')
							{
								$postvalue['responseStatus']=1010;
								$postvalue['responseMessage']="Record Not found";
								$postvalue['posts']=null;
								header('Content-type: application/json');
								echo json_encode($postvalue);
								exit;
							}
							else
							{
							 $balance_water_points=$result_query['balance_points'];
							$complete_name=$result_query['Name'];
							$name=$result_query['Mother_name'];
							$group_member_id=$result_query['group_member_id'];							
							
							$balance_water_points=$balance_water_points+$amount;
							
							$query1="update tbl_parent set balance_points='$balance_water_points' where Id='$user_id'";
							$result = mysql_query($query1) or die('Errant query:  '.$query1);
							$update="update  tbl_giftcards  set  amount='0' ,status='Used' where card_no='$card_no'";
							$result = mysql_query($update) or die('Errant query:  '.$update);
							
							$test=("insert into tbl_waterpoint(coupon_id,points,issue_date,entities_id,Parent_Member_Id,group_member_id)values('$card_no','$amount','$date1','$entity_id','$user_id','$group_member_id')");
							$result = mysql_query($test) or die('Errant query:  '.$test);
							
							//calling master action webservice
							if($complete_name=='')
							{
								$username = $name;
							}
							else{
								$username=$complete_name;
							}
							}
						
				
				
				
				 break;
				 
				 default:
						$postvalue['responseStatus']=1011;
						$postvalue['responseMessage']="You can not purchase water points";
						$postvalue['posts']=null;
						header('Content-type: application/json');
						echo json_encode($postvalue);
						exit;
				 
			}
			
			$data = array('Action_Description'=>'Purchased Water Points',
												'Actor_Mem_ID'=>$user_id,
												'Actor_Name'=>$username,
												'Actor_Entity_Type'=>$entity_id,
												'Second_Receiver_Mem_Id'=>$user_id,
												'Second_Party_Receiver_Name'=>$username,
												'Second_Party_Entity_Type'=>'',
												'Third_Party_Name'=>'',
												'Third_Party_Entity_Type'=>'',
												'Coupon_ID'=>$card_no,
												'Points'=>$amount,
												'Product'=>'',
												'Value'=>'',
												'Currency'=>''
							);
				
								$ch = curl_init("$server_name/core/Version2/master_action_log_ws.php");//SMC-3507 	
							
							
							$data_string = json_encode($data);    
							curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
							curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);  
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);      
							curl_setopt($ch, CURLOPT_HTTPHEADER, array('ContentType: application/json','ContentLength: ' . strlen($data_string)));
							$result = json_decode(curl_exec($ch),true);
			
			
	$data_array=array(
	
	'Points'=>$amount,
	'message'=>'Water points purchased successfully'
	);
	
	
	$posts[]=$data_array;
	$postvalue['responseStatus']=200;
	$postvalue['responseMessage']="OK";
	$postvalue['posts']=$posts;
	header('Content-type: application/json');
	echo json_encode($postvalue);
	
	
}
else
{
	
						$postvalue['responseStatus']=1012;
						$postvalue['responseMessage']="Coupon Expired";
						$postvalue['posts']=null;
						header('Content-type: application/json');
						echo json_encode($postvalue);
	
}
}
	
	
	
	  @mysql_close($con);
}	  
?>