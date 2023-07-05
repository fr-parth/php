<?php
include('conn.php');
$school_id = xss_clean(mysql_real_escape_string($_GET['sc_id']));;

$sql3=mysql_query("Select sc_id,sc_list from tbl_studentpointslist where school_id='$school_id' group by sc_list order by sc_list" );
echo '<option  value="" disabled selected>Activities Name</option>  ';
if($school_id=="all")
{
	echo '<option  value="allActivity" >All Activities</option>';
}
else
{
	echo '<option  value="" >All Activities</option>';
}
 while($row=mysql_fetch_array($sql3)){ ?>
    <option value="<?php echo xecho($row['sc_id']);?>"><?php echo xecho($row['sc_list']);?></option>
    <?php }?>