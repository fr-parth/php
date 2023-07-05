<?php 
include('conn.php');
$source = $_POST['type'];
$sql2 = mysql_query(" SELECT school_name,school_id FROM tbl_school_admin where group_type='".$source."'");
 ?>
<option value="0">Select Group Name</option>
<?php while ($result2 = mysql_fetch_array($sql2)) { ?>
<option value="<?php echo $result2['school_id']; ?>" >
<?php echo $result2['school_name']." (".$result2['school_id'].")"; ?>
</option>
<?php } ?>