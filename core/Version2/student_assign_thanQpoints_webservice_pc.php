<?php

$json = file_get_contents('php://input');
$obj = json_decode($json);

 $format = 'json'; //xml is the default


include("conn.php");

 $ThanQreason_id=$obj->{'ThanQreason_id'};
 $points=$obj->{'points'};
 $std_PRN=$obj->{'std_PRN'};
 $t_id=$obj->{'t_id'};
 
 

	if($ThanQreason_id != "" && $points != "")
		{

		$issue_date=date('d/m/Y');
		
		  $arrs=mysql_query("select balance_bluestud_points,used_blue_points,std_complete_name,std_name,std_Father_name,std_lastname from tbl_student where std_PRN='$std_PRN' ");
			  $result=mysql_fetch_array($arrs);
			  $balance_bluestud_points=$result['balance_bluestud_points'];
			
			  $used_blue_points=$result['used_blue_points'];
			  if($balance_bluestud_points >=$points)
				  
			  {
			  

			  			
				 $query1=mysql_query("insert into tbl_teacher_point (sc_teacher_id,sc_entities_id,assigner_id,sc_thanqupointlist_id,sc_point,point_date) values('$t_id','105','$std_PRN','$ThanQreason_id','$points','$issue_date')");
				
						$sql=mysql_query("select balance_blue_points from tbl_teacher where t_id='$t_id'");
 $result1=mysql_fetch_array($sql);
 $final_blue_points=$result1['balance_blue_points']+$points;
 $query=mysql_query("update tbl_teacher set balance_blue_points='$final_blue_points'  where t_id='$t_id'");
 
 
 				 $final_bluestud_points=$balance_bluestud_points-$points;
$final_used_blue_points=$used_blue_points+$points;


 mysql_query("update tbl_student set balance_bluestud_points='$final_bluestud_points' , used_blue_points='$final_used_blue_points' where  std_PRN='$std_PRN'
 ");
 
		$student_name='';
							if($result['std_complete_name']!='')
								{
									$arr=explode(" ",$result['std_complete_name']);
									$i=0;
									while(count($arr)>$i)
									{
										$student_name=$student_name.' '.ucfirst(strtolower($arr[$i]));
										$i++;
									}
								
								}
								else
								{
									$student_name=ucfirst(strtolower($result['std_name'])).' '.ucfirst(strtolower($result['std_Father_name'])).' '.ucfirst(strtolower($result['std_lastname']));
								}
			
			$row=mysql_query("select * from tbl_thanqyoupointslist where id='$ThanQreason_id'");
			$value=mysql_fetch_array($row);
			$reasonofreward=$value['t_list'];
 			// Message to be sent
							
								
									$row=mysql_query("select gc.gcm_id,t_name,t_middlename,t_lastname,t_complete_name from teacher_gcmid  gc left outer join tbl_teacher t on  gc.teacher_PRN=t.t_id where gc.teacher_PRN='$t_id'");
								while($value=mysql_fetch_array($row))
								{
								
									$Gcm_id=$value['gcm_id'];
									$teacher_name="";
									if($value['t_complete_name']=="")
									{
										
									$teacher_name=ucfirst(strtolower($value['t_name']))." ".ucfirst(strtolower($value['t_middlename']))." ".ucfirst(strtolower($value['t_lastname']));
									}
									else
									{
										
										$arr=explode(" ",$value['t_complete_name']);
										$i=0;
										while(count($arr)>$i)
										{
										$teacher_name=$teacher_name.' '.ucfirst(strtolower($arr[$i]));
											$i++;
										}
		
									}
						 $message = "Reward Point| Hello ".$teacher_name.", your student ".trim($student_name)." rewarded you ".$points." points for".$reasonofreward;
								include('pushnotification.php');
					      send_push_notification($Gcm_id, $message);
								
								}

 
 $posts[] = "ThnaQ points given successfully";

 $ent_type = "105";
 $ent_type2 = "103";
/* $tch =mysql_fetch_array(mysql_query("SELECT `t_id` FROM `tbl_teacher` WHERE t_id='".$t_id."'"));        */
  $std =mysql_fetch_array(mysql_query("SELECT `id`,`school_id` FROM `tbl_student` WHERE std_PRN='".$std_PRN."'"));
  $tq =mysql_fetch_array(mysql_query("SELECT `t_list` FROM `tbl_thanqyoupointslist` WHERE id='".$ThanQreason_id."' and school_id='".$std['school_id']."'"));

  /*$sql = mysql_query("INSERT INTO `tbl_ActivityLog`(EntityID,Entity_type,EntitySubType,Timestamp,Activity,school_id) VALUES ('".$std['id']."','".$ent_type."','".$tq['t_list']."','".date("Y-m-d h:i:s")."','Given ".$points." ThanQ Points to ".strtoupper($tch['t_complete_name'])."(Teacher)','".$std['school_id']."')")or die(mysql_query());  */

$sql = mysql_query("INSERT INTO `tbl_ActivityLog`(EntityID,Entity_type,EntityID_2,Entity_Type_2,Timestamp,Activity,quantity,school_id) VALUES ('".$std['id']."','".$ent_type."','".$t_id."','".$ent_type2."','".date("d-m-Y h:i:s")."','Given ThanQ Points For ".$tq['t_list']."(Reason)','".$points." Points','".$std['school_id']."')")or die(mysql_query());

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
			
			
			
		
		
	
  					if($format == 'json')
					{
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


































