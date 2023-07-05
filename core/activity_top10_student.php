<?php 
error_reporting(0);

include_once("scadmin_header.php");
$report="";
$results=$smartcookie->retrive_individual($table,$fields);
$result=mysql_fetch_array($results);
$group_member_id=$result['group_member_id'];
  $sch=$_POST['sch'];
$sc_id= $_SESSION['school_id'];


 $sql3=mysql_query("Select distinct(sc_list),sc_id from tbl_studentpointslist where school_id='$sc_id' group by sc_list order by sc_list" );
 
?> 
  <option  value="" disabled selected>Activities Name</option>
	 <option  value="allActivity">All</option>
	
<?php if($sch!='all'){?>
<?php while($row=mysql_fetch_array($sql3)){ ?>
	<option value="<?php echo $row['sc_id'];?>"><?php echo $row['sc_list'];?></option>
    <?php }?>

<?php }?>
  