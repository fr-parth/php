<?php
include 'conn.php';
error_reporting(0);
$sc_id = $_POST['id'];
$sql1=mysql_query("Select ad.activityID,ad.tID,ad.activity_name,ad.Academic_Year,ad.semester_name,t.t_id,t.t_complete_name from tbl_360_activities_data ad  JOIN tbl_teacher t on t.t_id=ad.tID where ad.schoolID='$sc_id' AND t.school_id='$sc_id' AND ad.tID!=''"); ?>
	<option value="" selected>ALL Teachers</option>
										
	<?php while($row=mysql_fetch_array($sql1)){ ?>
		<option value="<?php echo $row['tID']; ?>"><?php echo $row['t_complete_name']; echo "\t"; echo $row['t_id']; ?></option>
	<?php } ?>