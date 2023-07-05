<?php
include('conn.php');
header('Content-type: application/json');	
$json = file_get_contents('php://input');
$obj = json_decode($json);
//comment
$t_id = xss_clean(mysql_real_escape_string($obj->{'t_id'}));
$school_id = xss_clean(mysql_real_escape_string($obj->{'school_id'}));

$res=mysql_query("select st.std_name, st.std_Father_name, st.std_lastname, st.std_complete_name, st.std_img_path, r.stud_id1 as stud_id, r.flag, r.requestdate, r.points,r.reason as reason_id, r.activity_type, (CASE WHEN r.activity_type = 'activity' THEN sp.sc_list WHEN r.activity_type = 'subject'
THEN ss.subject ELSE '' END) as reason from tbl_request r LEFT JOIN tbl_studentpointslist sp ON sp.sc_id = r.reason 
LEFT JOIN tbl_school_subject ss ON ss.Subject_Code = r.reason JOIN tbl_student st ON st.std_PRN = r.stud_id1 and st.school_id='$school_id' 
where r.stud_id2='$t_id'  and r.flag='N' and r.school_id='$school_id' AND r.reason IS NOT NULL order by r.id desc ");
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
			$value['requestdate'] = $post['requestdate'];
			$value['points'] = $post['points'];
			$value['activity_type'] = $post['activity_type'];
			$value['reason'] = $post['reason'];
			$value['student_PRN'] = $post['stud_id'];
			$value['reason_id'] = $post['reason_id'];
			$posts[] = $value;
		}
		$postvalue['responseStatus']=200;
		$postvalue['responseMessage']="Find Records";
		$postvalue['posts']=$posts;	
	 }
	 else
	 {
		$postvalue['responseStatus']=204;
		$postvalue['responseMessage']="No records found";
		$postvalue['posts']=null;
	 }

		echo json_encode($postvalue);
@mysql_close($con);
?>