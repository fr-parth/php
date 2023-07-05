<?php 
error_reporting(0);

include_once("scadmin_header.php");
$report="";
$results=$smartcookie->retrive_individual($table,$fields);
$result=mysql_fetch_array($results);
$group_member_id=$result['group_member_id'];
  $sch=$_POST['sch'];
$sc_id= $_SESSION['school_id'];


  $sql2=mysql_query("Select distinct(subject),id from tbl_school_subject where school_id='$sc_id'" );
 
?> 
   <option  value="" disabled selected><?php echo $dynamic_subject;?> Name</option>
    <option  value="allSubject">All</option>
	
<?php if($sch!='all'){?>
<?php while($row=mysql_fetch_array($sql2)){ ?>
	<option value="<?php echo $row['id'];?>"><?php echo $row['subject'];?></option>
    <?php }?>

<?php }?>
  

	
	
   
	