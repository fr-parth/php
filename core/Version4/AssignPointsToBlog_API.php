<?php
/*Author: Pranali Dalvi and Yogesh Sonawne
Date: 21-3-19
This API was created for assigning points to blog from Student to Teacher / Teacher to Teacher / Teacher to Student / Student to Student.

*/
include('function.php');
$json=file_get_contents('php://input');
$obj=json_decode($json);
include '../conn.php';

$SenderID = xss_clean(mysql_real_escape_string($obj->{'SenderID'}));
$ReceiverID = xss_clean(mysql_real_escape_string($obj->{'ReceiverID'}));
$Sender_EntityType = xss_clean(mysql_real_escape_string($obj->{'Sender_EntityType'}));
$Receiver_EntityType = xss_clean(mysql_real_escape_string($obj->{'Receiver_EntityType'}));
$Points = xss_clean(mysql_real_escape_string($obj->{'Points'}));
$Reason = xss_clean(mysql_real_escape_string($obj->{'Reason'}));
$Sender_SchoolID = xss_clean(mysql_real_escape_string($obj->{'Sender_SchoolID'}));
$PointType = xss_clean(mysql_real_escape_string($obj->{'PointType'}));
$Receiver_SchoolID = xss_clean(mysql_real_escape_string($obj->{'Receiver_SchoolID'}));
$BlogID = xss_clean(mysql_real_escape_string($obj->{'BlogID'}));

	if(empty($SenderID) && empty($ReceiverID) && empty($Sender_SchoolID) && empty($Receiver_SchoolID) && empty($Sender_EntityType)  && empty($Receiver_EntityType) && empty($Points) && empty($PointType))
	{
		$postvalue['responseStatus']=1000;
		$postvalue['responseMessage']="Invalid Input";
		$postvalue['posts']=null;
	}
	else  if(($SenderID==$ReceiverID) && ($Sender_SchoolID==$Receiver_SchoolID) && ($Sender_EntityType==$Receiver_EntityType))
	{
		$postvalue['responseStatus']=409;
		$postvalue['responseMessage']="You cannot assign points to your own blog";
		$postvalue['posts']=null;
	}
	else
	{
		if($Sender_EntityType=='105')//if sender is Student
		{
			switch($PointType)
			{
				case 'Yellow': 
							$TableName='tbl_student_reward';
							$ColumnName='yellow_points,sc_stud_id';
							$Where='sc_stud_id ="'.$SenderID.'" AND school_id="'.$Sender_SchoolID.'"';
							break;
				case 'Green': 
							$TableName='tbl_student_reward';
							$ColumnName='sc_total_point,sc_stud_id';
							$Where='sc_stud_id ="'.$SenderID.'" AND school_id="'.$Sender_SchoolID.'"';
							break;
				case 'Purple': 
							$TableName='tbl_student_reward';
							$ColumnName='purple_points,sc_stud_id';
							$Where='sc_stud_id ="'.$SenderID.'" AND school_id="'.$Sender_SchoolID.'"';
							break;
				case 'Brown': 
							$TableName='tbl_student_reward';
							$ColumnName='brown_point,sc_stud_id';
							$Where='sc_stud_id ="'.$SenderID.'" AND school_id="'.$Sender_SchoolID.'"';
							break;
				case 'Water': 
							$TableName='tbl_student';
							$ColumnName='balance_water_points,std_PRN';
							$Where='std_PRN ='$SenderID' AND school_id='$Sender_SchoolID'';
							break;
				case 'Blue': 
							$TableName='tbl_student';
							$ColumnName='balance_bluestud_points,std_PRN';
							$Where='std_PRN ='$SenderID' AND school_id='$Sender_SchoolID'';
							break;
				
			}
		}
		else if($Sender_EntityType=='103')//if sender is Teacher
		{
			$TableName='tbl_teacher';
			switch($PointType)
			{
				case 'Green': 
							$ColumnName='tc_balance_point';
							$Where='';
							break;
							
				case 'Brown': 
							$ColumnName='brown_point';
							break;
							
				case 'Water': 
							$ColumnName='water_point';
							break;
							
				case 'Blue': 
							$ColumnName='balance_blue_points';
							break;
			}
		}
		
		 if($Sender_EntityType=='103' && $Receiver_EntityType=='103')
		{
			//Teacher to Teacher
		}
		else if($Sender_EntityType=='105' && $Receiver_EntityType=='105')
		{
			//Student to Student
			
			$SenderPoints = mysql_query("select $ColumnName from $TableName where $Where");
			$result=mysql_fetch_array($SenderPoints);
			$sc_total_point=$result['sc_total_point'];
			$purple_points=$result['purple_points'];


				if($Points<=$sc_total_point)
				{ 
					$ReceiverPoints=mysql_query("select $ColumnName from $TableName where sc_stud_id ='".$ReceiverID."' AND school_id='".$school_id."'");
					$result1=mysql_fetch_array($ReceiverPoints);
					$sc_final_point=$result1['yellow_points']+$Points;
					
					$sql1=mysql_query("update tbl_student_reward set yellow_points='$sc_final_point',Receiver_SchoolID='$Receiver_SchoolID' where sc_stud_id='$ReceiverID' AND school_id='$Receiver_SchoolID'");
					
					$sc_share_point=$sc_total_point-$Points;
					$query=mysql_query("update tbl_student_reward set sc_total_point='$sc_share_point',Receiver_SchoolID='$Receiver_SchoolID' where sc_stud_id='$SenderID' AND school_id='$Sender_SchoolID'");
					$date=CURRENT_TIMESTAMP;
					$test=mysql_query("insert into tbl_student_point(sc_entites_id,sc_point,sc_teacher_id,sc_stud_id,reason,point_date,type_points,school_id,comment,Receiver_SchoolID) values('105','$Points','$SenderID','$ReceiverID','$Reason','$date','$PointType','$Sender_SchoolID','$BlogID','$Receiver_SchoolID')");
					$report="Green points are successfully shared";
					
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
		else if($Sender_EntityType=='103' && $Receiver_EntityType=='105')
		{
			//Teacher to Student
		}
		else if($Sender_EntityType=='105' && $Receiver_EntityType=='103')
		{
			//Student to Teacher
		}
		
	}

?>