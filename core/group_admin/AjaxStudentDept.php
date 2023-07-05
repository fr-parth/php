<?php 
include('../conn.php');
$sc_id = $_POST['school'];

$sql1 = mysql_query("SELECT DISTINCT(std_dept) as std_dept,school_id from tbl_student where school_id='$sc_id' AND std_dept!='' group by std_dept"); ?>
 		<option value="0">Select Department</option>
<?php while ($row = mysql_fetch_array($sql1)){ 
	if(isset($_POST['dept_id'])){?>
       <option <?php if($_POST['dept_id']==$row['std_dept']){ echo "selected"; }?> value="<?php echo $row['std_dept']; ?>"><?php echo $row['std_dept']; ?></option>
<?php } else{ ?>
       <option value="<?php echo $row['std_dept']; ?>"><?php echo $row['std_dept']; ?></option>

<?php } } ?>