<?php
include 'conn.php';
error_reporting(0);
$sc_id = $_POST['id'];
$sql1=mysql_query("Select ft.feed360_teacher_id,ft.feed360_academic_year_ID,ft.feed360_semester_ID,ft.feed360_subject_name,ft.feed360_subject_code,t.t_id,t.t_complete_name from tbl_360feedback_template ft JOIN tbl_teacher t on t.t_id=ft.feed360_teacher_id where ft.feed360_school_id='$sc_id' AND t.school_id='$sc_id' AND ft.feed360_teacher_id!=''");
?>
	<option value="" selected>ALL Teachers</option>
										
	<?php while($row=mysql_fetch_array($sql1)){ ?>
		<option value="<?php echo $row['feed360_teacher_id'];  ?>"><?php echo $row['t_complete_name']; echo "\t"; echo $row['feed360_teacher_id'];?></option>
	<?php } ?>
	