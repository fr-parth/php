<?php  
//$json=$_GET ['json'];
$json = file_get_contents('php://input');
$obj = json_decode($json);

 $format = 'json'; 

include 'conn.php';

//input from user
 $media_id=$obj->{'media_id'};
	$std_PRN=$obj->{'std_PRN'};
	$points=$obj->{'points'};
	// Start SMC-3450 Modify By Pravin 2018-09-21 03:40 PM 
	$school_id=$obj->{'school_id'};
	
		$posts = array();
   if($media_id!='' && $std_PRN!='' && $points!='' && $school_id!='')//SMC-3450
	{ 
			
				//SMC-3450
				//$date=Date('d/m/Y');
				 $date=CURRENT_TIMESTAMP;
		
	$sql=mysql_query("select media_name,id,points from tbl_social_points where id='$media_id'");
$result=mysql_fetch_array($sql);

$media_name=$result['media_name'];

$sql1=mysql_query("select * from tbl_student_reward where sc_stud_id='$std_PRN' and school_id='$school_id'");//SMC-3450
		$count=mysql_num_rows($sql1);
			$result1=mysql_fetch_array($sql1);
		if($count!=0)
		{
		 $sc_final_point=$result1['sc_total_point']+$points;
		$sql1=mysql_query("update tbl_student_reward set sc_total_point='$sc_final_point' where sc_stud_id='$std_PRN' and school_id='$school_id'");//SMC-3450
		}
		else
		{
	
		$query1=mysql_query("insert into tbl_student_reward(sc_stud_id,sc_total_point,sc_date,school_id) values('$std_PRN','$points','$date','$school_id')");//SMC-3450
		}

	$test=mysql_query("insert into tbl_student_point(sc_entites_id,sc_point,sc_teacher_id,sc_stud_id,reason,point_date,school_id) values('110','$points','$std_PRN','$std_PRN','$media_name','$date','$school_id')");//SMC-3450
	
	 $sql3=mysql_query("select online_flag from tbl_student_reward where sc_stud_id='$std_PRN' and school_id='$school_id'");//SMC-3450
$result3=mysql_fetch_array($sql3);
$flag3=$result3['online_flag'];

$med_name=substr($media_name, 0,2);
$flag=$flag3."".$med_name;

mysql_query("update tbl_student_reward set online_flag='$flag' where sc_stud_id='$std_PRN' and school_id='$school_id'");//SMC-3450
$sqa=mysql_query("select std_complete_name,id from tbl_student where std_PRN='$std_PRN' and school_id='$school_id'");
									$rows2=mysql_fetch_assoc($sqa);
									$s_id1=$rows2['id'];
									$stud_name=$rows2['std_complete_name'];
			 
			 $server_name = $GLOBALS['URLNAME'];//SMC-3450
			 ////End SMC-3450
							
									$data = array('Action_Description'=>'Points for social media' ,
												'Actor_Mem_ID'=>$s_id1,
												'Actor_Name'=>$stud_name,
												'Actor_Entity_Type'=>105,
												'Second_Receiver_Mem_Id'=>'',
												'Second_Party_Receiver_Name'=>'',
												'Second_Party_Entity_Type'=>'',
												'Third_Party_Name'=>'',
												'Third_Party_Entity_Type'=>'',
												'Coupon_ID'=>'',
												'Points'=>$points,
												'Product'=>'',
												'Value'=>'',
												'Currency'=>''
							);
							
							$ch = curl_init("$server_name/core/Version2/master_action_log_ws.php"); 	
							
							
							$data_string = json_encode($data);    
							curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
							curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);  
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);      
							curl_setopt($ch, CURLOPT_HTTPHEADER, array('ContentType: application/json','ContentLength: ' . strlen($data_string)));
							$result = json_decode(curl_exec($ch),true);
			 
			 //end	
		 $report="You have got $points Points";
		  $posts[]=array('report'=>$report);
		
      				
    		$postvalue['responseStatus']=200;
				$postvalue['responseMessage']="OK";
				$postvalue['posts']=$posts;
  			
  					/* output in necessary format */
					if($format == 'json') {
							header('Content-type: application/json');
    						 echo json_encode($postvalue);
						}
 				 else {
   				 		header('Content-type: text/xml');
    					echo '';
   					 	foreach($posts as $index => $post) {
     						 if(is_array($post)) {
       							 foreach($post as $key => $value) {
        							  echo '<',$key,'>';
          								if(is_array($value)) {
            								foreach($value as $tag => $val) {
              								echo '<',$tag,'>',htmlentities($val),'</',$tag,'>';
            											}
         									}
         							  echo '</',$key,'>';
        						}
      						}
    				}
   			 echo '';
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
