<?php
include 'conn.php';
header('Content-type: application/json');

$json = file_get_contents('php://input');
$obj = json_decode($json);

$group_id = xss_clean(mysql_real_escape_string($obj->{'group_id'}));
$school_id = xss_clean(mysql_real_escape_string($obj->{'school_id'}));

//***********Entities Descriptions*********/////
$school_desc = "School";
$teacher_desc = "Teacher";
$student_desc = "Student";
$sponsor_desc = "Sponsor";
$parent_desc = "Parent";
$school_admin_staff_desc = "School_admin_staff";
$subject_desc = "Subject";
$student_subject_desc = "Student_subject";
$department_desc = "Department";
$teacher_subject_desc = "Teacher_subject";
$academic_year_desc = "Academic_year";
$non_teacher_desc = "Non_teacher";
$branch_desc = "Branch";
$semester_desc = "Semester";
$class_desc = "Class";
$student_semester_desc = "Student_semester";
$class_subject_desc = "class_subject";
$branch_subject_divison_year_desc = "Branch_subject_divison_year";

//***********End Entities Descriptions*********/////

	if(trim($group_id) != '')
	{
		if(!empty($school_id))
		{
			$where = "school_id='".$school_id."";
			$school_count = 0;
		}
		else
		{
			$where = "inner join tbl_group_school gs on sc.school_id=gs.school_id  where gs.group_member_id='".$group_id."'";
			$count_query = mysql_query("SELECT count(sc.id) as schoolCount FROM tbl_school_admin sc $where");
			$res = mysql_fetch_array($count_query);
			$school_count = ($group_id>0) ? $res['schoolCount']:'0';
		}

		$summary_tbl_sql = mysql_query("SELECT count(id) as count FROM tbl_dashboard_summary where group_id='$group_id' AND school_id='$school_id'");
		$summary_tbl_res = mysql_fetch_array($summary_tbl_sql);
		$summary_tbl_cnt = $summary_tbl_res['count'];
			$school_admin_sql = mysql_query("SELECT count(sc.id) as count FROM tbl_school_adminstaff sc $where");
			$school_admin_staff = mysql_fetch_array($school_admin_sql);
			$school_admin_cnt = $school_admin_staff['count'];

			$academics_sql = mysql_query("SELECT count(distinct sc.Academic_Year)  as count FROM tbl_academic_Year sc $where");
			$academics_res = mysql_fetch_array($academics_sql);
			$academics_cnt = $academics_res['count'];

			$one="select count(t_id) as count from tbl_teacher sc $where and t_emp_type_pid IN (133,134,135,137)"; 
			$row_t1=mysql_query($one);
			$count1=mysql_fetch_array($row_t1);
			$no_of_Teachers=$count1['count'];
			
			$two="select count(t_id) as count from tbl_teacher sc $where and t_emp_type_pid NOT IN (133,134,135,137)";
			$row_t2=mysql_query($two);
			$count2=mysql_fetch_array($row_t2);
			$no_of_non_Teachers=$count2['count'];
			
			$three="select count(sc.id) as count from tbl_student sc $where";
			$row_t3=mysql_query($three);
			$count3=mysql_fetch_array($row_t3);
			$no_of_students=$count3['count'];
			
			$five="SELECT count(sc.id) as count FROM tbl_parent sc $where";
			$row_t5=mysql_query($five);
			$count5=mysql_fetch_array($row_t5);
			$no_of_parents=$count5['count'];
			
			$six="select count(sc.id) as count from tbl_department_master sc $where";
			$row_t6=mysql_query($six);
			$count6=mysql_fetch_array($row_t6);
			$no_of_departments=$count6['count'];
			
			$seven="select count(sc.id) as count from tbl_branch_master sc $where";
			$row_t7=mysql_query($seven);
			$count7=mysql_fetch_array($row_t7);
			$no_of_branches=$count7['count'];
			
			$eight="select count(sc.Semester_Id) as count from tbl_semester_master $where";
			$row_t8=mysql_query($eight);
			$count8=mysql_fetch_array($row_t8);
			$no_of_semesters=$count8['count'];
			
			$nine="SELECT count(sc.id) as count FROM Class sc $where";
			$row_t9=mysql_query($nine);
			$count9=mysql_fetch_array($row_t9);
			$no_of_classes=$count9['count'];
			
			$ten="select count(tch_sub_id) as count from tbl_teacher_subject_master sc $where";
			$row_t10=mysql_query($ten);
			$count10=mysql_fetch_array($row_t10);
			$no_of_teacher_subject=$count10['count'];
			
			$eleven="select count(id) as count from tbl_sponsorer";
			$row_t11=mysql_query($eleven);
			$count11=mysql_fetch_array($row_t11);
			$no_of_sponsors=$count11['count'];
			
			$tweleve="select count(sc.id) as count from tbl_school_subject sc $where";
			$row_t12=mysql_query($tweleve);
			$count12=mysql_fetch_array($row_t12);
			$no_of_subjects=$count12['count'];
			
			$thirteen="SELECT count(sc.id) as count FROM StudentSemesterRecord sc $where";
			$row_t13=mysql_query($thirteen);
			$count13=mysql_fetch_array($row_t13);
			$no_of_studentsemesterrecord=$count13['count'];

			$fourteen="select count(sc.id) as count from tbl_student_subject_master sc inner join tbl_school_admin sa on sa.school_id = sc.school_id join tbl_student st on sc.student_id = st.std_PRN and sc.school_id = st.school_id $where";
			$row_t14=mysql_query($fourteen);
			$count14=mysql_fetch_array($row_t14);
			$no_of_studentpersubjects=$count14['count'];

			$class_subject = mysql_query("SELECT count(sc.id) as count FROM tbl_class_subject_master sc $where");
			$class_subject_res = mysql_fetch_array($class_subject);
			$class_subject_cnt = $class_subject_res['count'];

			$bsdy_sql = mysql_query("SELECT count(sc.id) as count FROM Branch_Subject_Division_Year sc $where");
			$bsdy_res = mysql_fetch_array($bsdy_sql);
			$branch_sub_div_yr =  $bsdy_res['count'];
		if($summary_tbl_cnt > 0)
		{
			$myquery = mysql_query("UPDATE tbl_dashboard_summary SET cnt_department='$no_of_departments',cnt_class='$no_of_classes',cnt_semester='$no_of_semesters',cnt_academic_year='$academics_cnt',cnt_student='$no_of_students',cnt_teacher='$no_of_Teachers',cnt_subject='$no_of_subjects',cnt_branch_subject_divison_year='$branch_sub_div_yr',cnt_teacher_subject='$no_of_teacher_subject',cnt_student_subject='$no_of_studentpersubjects',cnt_student_semester='$no_of_studentsemesterrecord',cnt_parent='$no_of_parents',cnt_non_teacher='$no_of_non_Teachers',cnt_branch='$no_of_branches',cnt_class_subject='$class_subject_cnt',cnt_school_admin_staff='$school_admin_cnt',cnt_school='$school_count' where group_id='$group_id' AND school_id='$school_id'");

			$msg = mysql_error();
		}
		else
		{
			$myquery = mysql_query("INSERT INTO tbl_dashboard_summary (group_id,school_id,cnt_department,cnt_class,cnt_semester,cnt_academic_year,cnt_student,cnt_teacher,cnt_subject,cnt_branch_subject_divison_year,cnt_teacher_subject,cnt_student_subject,cnt_student_semester,cnt_parent,cnt_non_teacher,cnt_branch,cnt_class_subject,cnt_school_admin_staff,cnt_school,desc_school,desc_teacher,desc_student,desc_parent,desc_school_admin_staff,desc_subject,desc_student_subject,desc_department,desc_teacher_subject,desc_academic_year,desc_non_teacher,desc_branch,desc_semester,desc_class,desc_student_semester,desc_class_subject,desc_branch_subject_divison_year) VALUES ('$group_id','$school_id','$no_of_departments','$no_of_classes','$no_of_semesters','$academics_cnt','$no_of_students','$no_of_Teachers','$no_of_subjects','$branch_sub_div_yr','$no_of_teacher_subject','$no_of_studentpersubjects','$no_of_studentsemesterrecord','$no_of_parents','$no_of_non_Teachers','$no_of_branches','$class_subject_cnt','$school_admin_cnt','$school_count','$school_desc','$teacher_desc','$student_desc','$parent_desc','$school_admin_staff_desc','$subject_desc','$student_subject_desc','$department_desc','$teacher_subject_desc','$academic_year_desc','$non_teacher_desc','$branch_desc','$semester_desc','$class_desc','$student_semester_desc','$class_subject_desc','$branch_subject_divison_year_desc');");
			$msg = mysql_error();
		}
		
		if($myquery)
		{
			$postvalue['responseStatus']=200;
			$postvalue['responseMessage']="OK";
			//$postvalue['posts']=$posts;	
			echo json_encode($postvalue);
		}
		else
		{
			$postvalue['responseStatus']=204;
			$postvalue['responseMessage']="Could not updated ".$msg;
			$postvalue['posts']=null;	
			echo json_encode($postvalue);
		}
	}
	else
	{
		$postvalue['responseStatus']=1000;
		$postvalue['responseMessage']="Invalid Input";
		$postvalue['posts']=null;
		echo json_encode($postvalue); 
	}