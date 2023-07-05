<?php
/*Author: Pranali Dalvi (PHP Developer)
Date : 11-10-19
This API was created for displaying used water point log for Teacher according to selected type
*/

$json = file_get_contents('php://input');
$obj = json_decode($json);
$format = 'json'; //xml is the default
include '../conn.php';

$TeacherMemberID = xss_clean(mysql_real_escape_string($obj->{'TeacherMemberID'}));
$TeacherID = xss_clean(mysql_real_escape_string($obj->{'TeacherID'}));
$SchoolID = xss_clean(mysql_real_escape_string($obj->{'SchoolID'}));
$key = xss_clean(mysql_real_escape_string($obj->{'key'}));

	if($TeacherMemberID!='' && $key!='' && $TeacherID!='' && $SchoolID!='')  
	{
		switch ($key) 
		{
			case "Coupon":
						//Below query for displaying water point log which were used to generate Smartcookie Coupon
						$sql = mysql_query("SELECT * FROM tbl_teacher_coupon  
			  			WHERE used_points LIKE '%Waterpoints%' AND (user_id='".$TeacherMemberID."' OR Teacher_Member_Id='".$TeacherMemberID."') order by id desc");

			  				if(mysql_num_rows($sql)>=1){

								while($row=mysql_fetch_assoc($sql)) {

								$post[] = array('coupon_id' => $row['coupon_id'], 
								'amount' => $row['amount'],
								'issue_date' => $row['issue_date'],
								'validity_date' => $row['validity_date']);

								}
								$postvalue['responseStatus']=200;
								$postvalue['responseMessage']="OK";
								$postvalue['count']=mysql_num_rows($sql);
								$postvalue['Coupon']=$post;
								
							}
							else{
								$postvalue['responseStatus']=204;
								$postvalue['responseMessage']="No Response";
								$postvalue['posts']=null;
							}
				break;

			case "SharedPoints":
							//Below query for displaying water point log which were shared from one Teacher to other Teacher
							$sql = mysql_query("SELECT tp.sc_teacher_id,tp.sc_point,tp.point_date,tp.reason,t.t_complete_name,t.t_name,t.t_middlename,t.t_lastname
								FROM tbl_teacher_point tp
								LEFT JOIN tbl_teacher t 
								ON t.t_id=tp.sc_teacher_id AND t.school_id=tp.school_id
								WHERE tp.sc_entities_id='103' AND tp.point_type LIKE '%Waterpoint%' 
								AND tp.school_id='".$SchoolID."' AND tp.assigner_id='".$TeacherID."' order by tp.id desc");
		
								if(mysql_num_rows($sql)>=1){

									while($row1=mysql_fetch_assoc($sql)) {

										if($row1['t_complete_name']=='' || $row1['t_complete_name']==null){

											$teacherName = $row1['t_name']." ".$row1['t_middlename']." ".$row1['t_lastname'];
										}else{
											$teacherName = $row1['t_complete_name'];
										}

									$post[] = array('sc_teacher_id' => $row1['sc_teacher_id'], 
									'sc_point' => $row1['sc_point'],
									'point_date' => $row1['point_date'],
									'reason' => $row1['reason'],
									't_complete_name' =>$row1['t_complete_name']
									);

									}
									$postvalue['responseStatus']=200;
									$postvalue['responseMessage']="OK";
									$postvalue['count']=mysql_num_rows($sql);
									$postvalue['SharedPoints']=$post;
								}
							    else{
									$postvalue['responseStatus']=204;
									$postvalue['responseMessage']="No Response";
									$postvalue['posts']=null;
								}
				break;

			case "AssignedPoints":
							//Below query for displaying water point log which were assigned to Student
			
							$sql = mysql_query("SELECT `sp`.`sc_point`, `sp`.`point_date`, `sp`.`type_points`, s.std_complete_name as std_complete_name, s.std_name as std_name, s.std_lastname as std_lastname, s.std_Father_name as std_Father_name, (CASE WHEN sp.activity_type = 'activity' THEN tat.activity_type WHEN sp.activity_type = 'subject' THEN ss.subject ELSE '' END) as act_or_sub, `sp`.`activity_type`, `tsp`.`sc_list` 
								FROM `tbl_student_point` `sp` 
								JOIN `tbl_student` `s` ON `s`.`std_PRN`=`sp`.`sc_stud_id` AND s.school_id=sp.school_id
								AND `s`.`school_id`=`sp`.`school_id` 
								LEFT JOIN `tbl_school_subject` `ss` ON `ss`.`id`=`sp`.`subject_id` 
								AND `ss`.`school_id`=`sp`.`school_id` 
								LEFT JOIN `tbl_activity_type` `tat` ON `tat`.`id`=`sp`.`activity_id` 
								AND `tat`.`school_id`=`sp`.`school_id` 
								LEFT JOIN `tbl_studentpointslist` `tsp` 
								ON `tsp`.`sc_id`=`sp`.`sc_studentpointlist_id` 
								AND `tsp`.`school_id`=`sp`.`school_id` 
								WHERE `sp`.`sc_teacher_id` = '".$TeacherID."' AND `sp`.`school_id` = '".$SchoolID."'
								AND `sp`.`type_points` = 'Waterpoint'
								AND `sp`.`sc_entites_id` = '103'
								ORDER BY `sp`.`id` DESC");
		

								if(mysql_num_rows($sql)>=1){

									while($row1=mysql_fetch_assoc($sql)) {

										if($row1['std_complete_name']=='' || $row1['std_complete_name']==null){

											$studentName = $row1['std_name']." ".$row1['std_Father_name']." ".row1['std_lastname'];
										}else{
											$studentName = $row1['std_complete_name'];
										}
									$post[] = array('Stud_Member_Id' => $row1['Stud_Member_Id'], 
									'sc_stud_id' => $row1['sc_stud_id'],
									'sc_studentpointlist_id' => $row1['sc_studentpointlist_id'],
									'subject_id' => $row1['subject_id'],
									'sc_point' => $row1['sc_point'],
									'point_date' => $row1['point_date'],
									'std_complete_name' => $studentName,
									'act_or_sub' => $row1['act_or_sub']
									);

									}
									$postvalue['responseStatus']=200;
									$postvalue['responseMessage']="OK";	
									$postvalue['count']=mysql_num_rows($sql);
									$postvalue['AssignedPoints']=$post;
								}
							    else{
									$postvalue['responseStatus']=204;
									$postvalue['responseMessage']="No Response";
									$postvalue['posts']=null;
								}
				break;
		

			default:				
								$postvalue['responseStatus']=1000;
								$postvalue['responseMessage']="Invalid Input";
								$postvalue['posts']=null;
								
				break;
		}
	 
	}
	else
		{
				$postvalue['responseStatus']=1000;
				$postvalue['responseMessage']="Invalid Input";
				$postvalue['posts']=null;
		}

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
?>