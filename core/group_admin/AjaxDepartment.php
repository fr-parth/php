<?php 
include('../conn.php');
$sc_id = $_POST['school'];

$sql1 = mysql_query("Select DISTINCT(batch_id) as batch_id,t_dept,school_id,send_unsend_status,t_country from tbl_teacher where school_id='$sc_id' and t_dept!='' group by t_dept"); ?>
 		<option value="0">Select Department</option>
<?php while ($row = mysql_fetch_array($sql1)){ 
	if(isset($_POST['dept'])){?>
       <option <?php if($_POST['dept']==$row['t_dept']){ echo "selected"; }?> value="<?php echo $row['t_dept']; ?>"><?php echo $row['t_dept']; ?></option>
<?php } else{ ?>
       <option value="<?php echo $row['t_dept']; ?>"><?php echo $row['t_dept']; ?></option>

<?php } } ?>