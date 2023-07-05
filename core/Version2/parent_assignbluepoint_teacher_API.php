<?php  

$json = file_get_contents('php://input');
$obj = json_decode($json);

 $teacher_id = $obj->{'t_id'};
  $school_id = $obj->{'school_id'};
   $user_id = $obj->{'parent_id'};
   $point = $obj->{'blue_points'};
   $activity_id = $obj->{'activity_id'};
   //$reason = $obj->{'reason'};
  
  


  $number_of_posts = isset($_GET['num']) ? intval($_GET['num']) : 10; //10 is the default
  $format = 'json'; 
  
  if(!empty($teacher_id) && !empty($school_id) && !empty($user_id) && !empty($point) && !empty($activity_id))
 {
	include 'conn.php';
		
			       $arrs=mysql_query("select * from tbl_parent where Id='$user_id' ");
      				$arr=mysql_fetch_array($arrs);
					if($arr['balance_points']>=$point)
					{
						$balance_blue_points=$arr['balance_points']-$point;
						$assign_blue_points=$arr['assigned_blue_points']+$point;

						
						$assign_date=date('d/m/Y');
						
							
							$prn=mysql_query("select balance_blue_points from tbl_teacher where t_id='$teacher_id' and school_id='$school_id'");
							$arr1=mysql_fetch_array($prn);
							$t_balance_blue_points=$arr1['balance_blue_points']+$point;
							mysql_query("update tbl_teacher set balance_blue_points='$t_balance_blue_points' where t_id='$teacher_id' and school_id='$school_id'");
						
							$reason=mysql_query("select `t_list` from `tbl_thanqyoupointslist` where `id`='$activity_id'");
							$arr11=mysql_fetch_array($reason);
							$point_given_reason=$arr11['t_list'];
						
							mysql_query("insert into tbl_teacher_point(sc_teacher_id,sc_entities_id,assigner_id,sc_point,sc_thanqupointlist_id,point_date,reason,school_id) values('$teacher_id','106','$user_id','$point','$activity_id','$assign_date','$point_given_reason','$school_id')");
							mysql_query("update tbl_parent set balance_points='$balance_blue_points',assigned_blue_points='$assign_blue_points' where Id='$user_id'");
							$postvalue['responseStatus']=200;
							$postvalue['responseMessage']="You assigned $point Blue points successfully.";
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
	else
			{
			
			    $postvalue['responseStatus']=1000;
				$postvalue['responseMessage']="Invalid Input";
				$postvalue['posts']=null;
			  
			   header('Content-type: application/json');
   			   echo  json_encode($postvalue); 
			  
			
			}
  
  
  @mysql_close($con);

?>