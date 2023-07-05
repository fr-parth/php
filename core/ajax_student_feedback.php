<?php
include 'conn.php';
error_reporting(0);
$sc_id = $_POST['id'];
$sql1=mysql_query("Select DISTINCT sf.stu_feed_teacher_id,sf.stu_feed_student_ID,sf.stu_feed_academic_year,sf.stu_feed_semester_ID,sf.stu_feed_dept_ID,sf.stu_feed_que,t.t_id,t.t_complete_name from tbl_student_feedback sf JOIN tbl_teacher t on t.t_id=sf.stu_feed_teacher_id where sf.stu_feed_school_id='$sc_id' AND t.school_id='$sc_id' AND sf.stu_feed_student_ID!='' AND sf.stu_feed_teacher_id!=''"); ?>
	<option value="" selected>ALL Teachers</option>
										
	<?php while($row=mysql_fetch_array($sql1)){ ?>
		<option value="<?php echo $row['stu_feed_teacher_id']; ?>"><?php echo $row['t_complete_name']; echo "\t"; echo $row['stu_feed_teacher_id']; ?></option>
	<?php } ?>