<?php  

$json = file_get_contents('php://input');
$obj = json_decode($json);

	$school_id = $obj->{'school_id'};
	$entity_name = $obj->{'entity_key'};
	$point = $obj->{'points'};
	$assigner_id = $obj->{'assignee_user_id'};
	$number_of_posts = isset($_GET['num']) ? intval($_GET['num']) : 10; //10 is the default
	$format = 'json'; 
	include 'conn.php';



	switch($entity_name)
	{
		case 'DISTRIBUTE_GREEN_POINT_TO_TEACHER': 
						 
							Assign_Points($school_id,$entity_name,$point,$assigner_id);
							Break;
							
		case 'DISTRIBUTE_BLUE_POINT_TO_STUDENT':
							
							Assign_Points($school_id,$entity_name,$point,$assigner_id);
							 Break;
	
		
						
		
		default:
							$postvalue['responseStatus']=204;
							$postvalue['responseMessage']="Invalid Entity name";
							$postvalue['posts']=null;
							header('Content-type: application/json');
							echo json_encode($postvalue);
							break;
		
	}
	
  



   
 
    function Assign_Points($school_id,$entity_name,$point,$assigner_id)
	{
		
	
		if(!empty($school_id) && !empty($entity_name) && !empty($point) && !empty($assigner_id))
		{
				
		             if($entity_name=='DISTRIBUTE_GREEN_POINT_TO_TEACHER')  
					 {	 
						$sql=mysql_query("select school_balance_point from tbl_school_admin where school_id='$school_id'");

						$arr=mysql_fetch_array($sql);

						$school_balance_point=$arr['school_balance_point'];
						

						if($point>$school_balance_point)

						{

							$postvalue['responseStatus']=204;
							$postvalue['responseMessage']="Sorry School Admin has insufficient balance points";
							$postvalue['posts']=null;
							header('Content-type: application/json');
							echo json_encode($postvalue);

									

						}

	 

						else

							{

								$arrs=mysql_query("select tc_balance_point from tbl_teacher where t_id='$assigner_id' and school_id='$school_id'");

								$arr=mysql_fetch_array($arrs);

								$tc_balance_point=$arr['tc_balance_point']+$point;

								mysql_query("update tbl_teacher set tc_balance_point='$tc_balance_point' where t_id='$assigner_id' and school_id='$school_id'");


								$result=mysql_query("select school_balance_point,school_assigned_point from tbl_school_admin where school_id='$school_id'");

								$sql=mysql_fetch_array($result);

								$school_balance_point=$sql['school_balance_point']-$point;

								$school_assigned_point=$sql['school_assigned_point']+$point;

								mysql_query("update tbl_school_admin set school_balance_point='$school_balance_point',school_assigned_point='$school_assigned_point' where school_id='$school_id'");

										$postvalue['responseStatus']=200;
										$postvalue['responseMessage']="Ok";
										$postvalue['posts']=$point." "."points has been assigned to teacher successfully.";
										header('Content-type: application/json');
										echo json_encode($postvalue);
							
							
							}	
					 
					 }
					 else if($entity_name=='DISTRIBUTE_BLUE_POINT_TO_STUDENT')  
					 {	 
								 $sql=mysql_query("select balance_blue_points from tbl_school_admin where school_id='$school_id'");
								 $arr=mysql_fetch_array($sql);
								 $school_balance_point=$arr['balance_blue_points'];
					
								if($point>$school_balance_point)
								{
									$postvalue['responseStatus']=204;
									$postvalue['responseMessage']="Sorry School Admin has insufficient balance points";
									$postvalue['posts']=null;
									header('Content-type: application/json');
									echo json_encode($postvalue);

								}
							 else
								{
								
							
										$updatepoint=mysql_query("update tbl_student set balance_bluestud_points=balance_bluestud_points+'$point' where std_PRN='$assigner_id' and school_id='$school_id'");
										$result=mysql_query("select balance_blue_points,assign_blue_points from tbl_school_admin where school_id='$school_id'");
										$sql=mysql_fetch_array($result);
												 
										$balance_blue_point=$sql['balance_blue_points'];
										$balance_blue_point=$sql['balance_blue_points']-$point;
										$assign_blue_points=$sql['assign_blue_points']+$point;
									
										mysql_query("update tbl_school_admin set balance_blue_points='$balance_blue_point',assign_blue_points='$assign_blue_points' where school_id='$school_id'");
										
										$postvalue['responseStatus']=200;
										$postvalue['responseMessage']="Ok";
										$postvalue['posts']=$point." "."points has been assigned to students successfully.";
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