<option value="0">    All</option>
<?php
include('conn.php');
$group_member_id = $_SESSION['group_admin_id'];
if($_POST['group_id']!=''){ $group_member_id = $_POST['group_id']; }
// echo "Select DISTINCT(sa.school_id) as school_id,sa.school_name,sa.scadmin_country from tbl_school_admin sa join tbl_group_school gs on gs.school_id=sa.school_id  where gs.group_member_id='$group_member_id' group by sa.school_id ";
$sqln2="Select DISTINCT(sa.school_id) as school_id,sa.school_name,sa.scadmin_country from tbl_school_admin sa join tbl_group_school gs on gs.school_id=sa.school_id  where gs.group_member_id='$group_member_id' group by sa.school_id ";
$sqln2 = mysql_query($sqln2);
// echo "hiiii";
while($row = mysql_fetch_array($sqln2)){
     ?>
   <option <?php if(isset($_POST['school_id'])){ if($_POST['school_id']==$row['school_id']){ echo "selected"; } }?> value="<?php echo $row['school_id']; ?>"><?php echo $row['school_name']." (".$row['school_id'].")"; ?></option>
<?php
 }

?>