<?php
$fields = array();
if($_POST['t']=='tbl_student'){					// For Student
	$fields = array('country_code'=>'Country Code','std_password'=>'Password','RegistrationSource'=>'Registration Source','group_member_id'=>'Group ID','entity_type_id'=>'Entity Type ID');  
	
} else if($_POST['t']=='tbl_teacher'){			// For Teacher
	$fields = array('CountryCode'=>'Country Code','t_password'=>'Password','group_member_id'=>'Group ID','entity_type_id'=>'Entity Type ID','school_type'=>'School Type','t_academic_year'=>'Academic Year'); 

} else if($_POST['t']=='tbl_school_admin'){		// For School Admin
	$fields = array('CountryCode'=>'Country Code','password'=>'Password','group_member_id'=>'Group ID','school_type'=>'School Type');  
}  else if($_POST['t']=='tbl_360_activities_data'){		// For Feedback Activity
	$fields = array('activity_name'=>'Activity Name','semester_name'=>'Semester Name','group_member_id'=>'Group ID','Academic_Year'=>'Academic Year');  
} else if($_POST['t']=='tbl_360feedback_template'){		// For Feedback Activity
	$fields = array('feed360_subject_name'=>'Subject Name','feed360_semester_ID'=>'Semester Name','feed360_subject_code'=>'Subject Code','feed360_academic_year_ID'=>'Academic Year');  
} else if($_POST['t']=='tbl_student_feedback'){		// For Feedback Activity
	$fields = array('stu_feed_que'=>'Student Question','stu_feed_semester_ID'=>'Semester Name','stu_feed_dept_ID'=>'Department','stu_feed_academic_year'=>'Academic Year');  
} 
// else if($_POST['t']=='tbl_cookieadmin'){ 		// For Group Admin
// 	$fields = array('admin_password'=>'Password');  
// }
?>
<option value="" disabled selected>Select Field</option>
								   		<?php foreach($fields as $code => $name){ ?>
										    <option value="<?= $code;?>"><?= $name;?></option>
										<?php } ?>