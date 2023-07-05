<?php
include 'conn.php';
error_reporting(0);
$sc_id = $_POST['id'];
$sql1=mysql_query("Select std_PRN,std_complete_name from tbl_student  where school_id='$sc_id' AND `std_PRN`!='' AND std_complete_name!=''");?>
	<option value="" selected>ALL Student</option>
										
	<?php while($row=mysql_fetch_array($sql1)){ ?>
		<option value="<?php echo $row['std_PRN']; ?>"><?php echo $row['std_complete_name'];?></option>
	<?php } ?>