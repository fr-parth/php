<?php  

$json = file_get_contents('php://input');
$obj = json_decode($json);

 $format = 'json'; //xml is the default
include 'conn.php';

 $request_id=$obj->{'request_id'};
 $flag=$obj->{'flag'};
 
 $posts=array();
 
	if($request_id != "" && $flag !="" )
		{
				
			 $sql= mysql_query("SELECT * from tbl_request where id='$request_id' and flag='N'");
			 			 
 			 $arr = mysql_fetch_array($sql);
			 $count=mysql_num_rows($sql);
			 
			 if($count==1)
			 {
			 $points=$arr['points'];
			 $reason=$arr['reason'];
			 $stud_id1=$arr['stud_id1'];
			 $stud_id2=$arr['stud_id2'];
			 
			 //// Start SMC-3450 Modify By Pravin 2018-09-21 05:02 PM 
			 $school_id=$arr['school_id'];			 
			 //$accept_date=Date('d/m/Y');
			 $accept_date=CURRENT_TIMESTAMP;
			 
					
			$query=mysql_query("select sc_total_point from tbl_student_reward where sc_stud_id='$stud_id2' and school_id='$school_id'");//SMC-3450
			$result_query=mysql_fetch_array($query);
			if($result_query['sc_total_point']=='')
			{
				$sc_total_point=0;
				
			}
			else
			{
				$sc_total_point=$result_query['sc_total_point'];
			}
			
			
						if($sc_total_point>=$points)
						{
							
							 if($flag=="1")
							{	
						
						 $final_points=$sc_total_point-$points;
						  $test=mysql_query("update tbl_student_reward set sc_total_point='$final_points' where sc_stud_id='$stud_id2' and school_id='$school_id'");//SMC-3450
						  $query1=mysql_query("select * from tbl_student_reward where sc_stud_id='$stud_id1' and school_id='$school_id' ");//SMC-3450
							 $arr1=mysql_fetch_array($query1);
							 
								if($arr1['yellow_points']=='')
								{
									$yellow_points=0;
									
								}
								else
								{
									$yellow_points=$arr1['yellow_points'];
								}
							 
							  
		  					$sc_final_point=$yellow_points+$points;
							
							
		$sql1=mysql_query("update tbl_student_reward set yellow_points='$sc_final_point' where sc_stud_id='$stud_id1' and school_id='$school_id'");//SMC-3450
		
			$sql2=mysql_query("update tbl_request set flag='Y' where stud_id1='$stud_id1' and stud_id2='$stud_id2' and entitity_id='105' and id='$request_id' and school_id='$school_id'");//SMC-3450
			
		$sql3=mysql_query("insert into tbl_student_point(sc_entites_id,sc_point,sc_teacher_id,sc_stud_id,reason,point_date,school_id) values('105','$points','$stud_id2','$stud_id1','$reason','$accept_date','$school_id')");//SMC-3450
			//End SMC-3450			  
						 	$report="Request successfully accepted";
					  $posts[]=array('report'=>$report);
						  
						  	$postvalue['responseStatus']=200;
				$postvalue['responseMessage']="OK";
		$postvalue['posts']=$posts;
		
		
						}
						
						if($flag=="2")
						{
							
							$sql2=mysql_query("update tbl_request set flag='P' where id='$request_id'");
							
								$report="Request declined";
							  $posts[]=array('report'=>$report);
						  
						  	$postvalue['responseStatus']=200;
							$postvalue['responseMessage']="OK";
							$postvalue['posts']=$posts;
									
							
						}
					}
						
								
						
						else
							{
									$postvalue['responseStatus']=204;
							$postvalue['responseMessage']="No Response";
							$postvalue['posts']=null;	
							}
  					/* output in necessary format */
			 }
					
			
			 
			 else
			 {
				 	$postvalue['responseStatus']=204;
							$postvalue['responseMessage']="No Response";
							$postvalue['posts']=null;	
			 }
			 if($format == 'json')
					
					 {
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
