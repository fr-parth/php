<!-- add file for SMC-4137 By Kunal -->

<?php
include 'conn.php';
error_reporting(0);
$sc_id = $_POST['id'];
$cls = $_POST['cl'];
$query = "Select std_PRN,std_complete_name from tbl_student  where school_id='$sc_id' AND std_class='$cls' AND `std_PRN`!='' AND std_complete_name!=''";

$sql1=mysql_query($query);
if(mysql_num_rows($sql1)<1){?>
	<option value="">No Student in class</option>
<?php } else{?>
	<option value="all">ALL Students from above class</option>
										
	<?php while($row=mysql_fetch_array($sql1)){ ?>
		<option value="<?php echo $row['std_PRN']; ?>"><?php echo $row['std_complete_name'];?></option>
	<?php } } ?>