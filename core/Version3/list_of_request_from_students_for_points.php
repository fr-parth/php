<?php
include('../conn.php');
header('Content-type: application/json');	
$json = file_get_contents('php://input');
$obj = json_decode($json);
//comment
$t_id = xss_clean(mysql_real_escape_string($obj->{'t_id'}));
$school_id = xss_clean(mysql_real_escape_string($obj->{'school_id'}));
$entity = xss_clean(mysql_real_escape_string($obj->{'entity'}));


//r.id added in select clause by Pranali for SMC-3483
//if($entity=='Manager')
//{	
//Queries updated by Rutuja Jori on 05/12/2019 for adding student_comment for both Employee/Manager.
//tbl_school_subject join taken on id instead of subject_code by Pranali for SMC-4269 on 21-12-19
$sqlManager="select t.t_designation as designation,t.t_name as std_name, t.t_middlename as std_Father_name, t.t_lastname as std_lastname, t.t_complete_name as std_complete_name, t.t_pc as std_img_path, r.stud_id1 as stud_id, r.flag, r.requestdate,r.teacher_comment as student_comment, r.points,r.reason as reason_id, r.activity_type, (CASE WHEN r.activity_type = 'activity' THEN sp.sc_list WHEN r.activity_type = 'subject'
THEN ss.subject ELSE '' END) as reason,r.id from tbl_request r LEFT JOIN tbl_studentpointslist sp ON sp.sc_id = r.reason 
LEFT JOIN tbl_school_subject ss ON ss.id = r.reason JOIN tbl_teacher t ON t.t_id = r.stud_id1 and t.school_id='$school_id' 
where r.stud_id2='$t_id'  and r.flag='N' and r.school_id='$school_id' AND r.entitity_id1='103' AND r.reason IS NOT NULL order by r.id desc ";	

//$res=mysql_query("select t.t_name as std_name, t.t_middlename as std_Father_name, t.t_lastname as std_lastname, t.t_complete_name as std_complete_name, t.t_pc as std_img_path, r.stud_id1 as stud_id, r.flag, r.requestdate,r.teacher_comment as student_comment, r.points,r.reason as reason_id, r.activity_type, (CASE WHEN r.activity_type = 'activity' THEN sp.sc_list WHEN r.activity_type = 'subject'
//THEN ss.subject ELSE '' END) as reason,r.id from tbl_request r LEFT JOIN tbl_studentpointslist sp ON sp.sc_id = r.reason 
//LEFT JOIN tbl_school_subject ss ON ss.Subject_Code = r.reason JOIN tbl_teacher t ON t.t_id = r.stud_id1 and t.school_id='$school_id' 
//where r.stud_id2='$t_id'  and r.flag='N' and r.school_id='$school_id' AND r.reason IS NOT NULL order by r.id desc ");	

//}
//else
//{


$sqlEmployee="select st.emp_designation as designation,st.std_name, st.std_Father_name, st.std_lastname, st.std_complete_name, st.std_img_path, r.stud_id1 as stud_id,r.student_comment as student_comment, r.flag, r.requestdate, r.points,r.reason as reason_id, r.activity_type,r.activity_image, (CASE WHEN r.activity_type = 'activity' THEN sp.sc_list WHEN r.activity_type = 'subject'

THEN ss.subject ELSE '' END) as reason,r.id from tbl_request r LEFT JOIN tbl_studentpointslist sp ON sp.sc_id = r.reason 
LEFT JOIN tbl_school_subject ss ON ss.id = r.reason JOIN tbl_student st ON st.std_PRN = r.stud_id1 and st.school_id='$school_id' 
where r.stud_id2='$t_id'  and r.flag='N' and r.school_id='$school_id' AND r.entitity_id1='105' AND r.reason IS NOT NULL order by r.id desc ";

//}
//Updated by Rutuja Jori for adding entity 'All' & added for loop for merging Employee & Manager arrays for fetching both records if entity is 'All' on 12/12/2019 for SMC-4229
$nloop = 1;

if ( $entity == 'All') { $nloop = 2;}

for ($ni=1; $ni <= $nloop ; $ni++) { 

	if ($ni==1) {
		if ($entity == 'Manager') {
			$sql = $sqlManager;
		} else {
			$entity = "Employee";
			$sql = $sqlEmployee;
		}		
	} else {
		$entity = "Manager";
		$sql = $sqlManager;
	}

	$res=mysql_query($sql);
	$count=mysql_num_rows($res);


	if(mysql_num_rows($res)>=1)
	{	
		while($post = mysql_fetch_assoc($res))
		{
			

			$value['std_name'] = $post['std_name'];
			$value['std_Father_name'] = $post['std_Father_name'];
			$value['std_Father_name'] = $post['std_Father_name'];
			$value['std_complete_name'] = $post['std_complete_name'];
			$value['std_img_path'] = $post['std_img_path'];
			
			if($value['std_img_path']=="")
			{	
				$value['std_img_path']=$GLOBALS['URLNAME']."/Assets/images/avatar/avatar_2x.png";
			}
			else if($entity=='Manager')
			{
				$value['std_img_path']=$GLOBALS['URLNAME']."/teacher_images/".$value['std_img_path']; 
			}
			else{
				$value['std_img_path']=$GLOBALS['URLNAME']."/core/".$value['std_img_path']; 
			}
			$value['requestdate'] = $post['requestdate'];
			$value['student_comment'] = $post['student_comment'];
			$value['points'] = $post['points'];
			$value['activity_type'] = $post['activity_type'];
			$value['reason'] = $post['reason'];
			$value['student_PRN'] = $post['stud_id'];
			$value['reason_id'] = $post['reason_id'];
			$value['id'] = $post['id'];
			$value['designation'] = $post['designation'];
			$value['entity'] = $entity;

			$posts[] = $value;
		}
		$postvalue['responseStatus']=200;
		$postvalue['responseMessage']="Find Records";
		$postvalue['posts'] = $posts;	
	}
	else
	{
		if ($postvalue['responseStatus'] == "200") {

		} else {
			$postvalue['responseStatus']=204;
			$postvalue['responseMessage']="No records found";
			$postvalue['posts']=null;
		}
	}
}
echo json_encode($postvalue);
@mysql_close($con);
?>