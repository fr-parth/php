<?php
include 'conn.php';
error_reporting(0);
$sc_id = $_POST['id'];
$sql1=mysql_query("Select t_id,t_complete_name,t_academic_year from tbl_teacher  where school_id='$sc_id' AND `t_id`!='' AND t_complete_name!=''"); ?>
	<option value="" selected>ALL Teachers</option>
										
	<?php while($row=mysql_fetch_array($sql1)){ ?>
		<option value="<?php echo $row['t_id']; ?>"><?php echo $row['t_complete_name']; ?></option>

	<?php } ?>