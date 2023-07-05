<?php 
//Created by Rutuja for fetching school list for selected group for SMC-4447 on 23/01/2020
include('conn.php');
  $groupname=$_POST['groupname'];
$sc_id= $_SESSION['school_id'];

if( $groupname!='NA')
{
$sqldept = "SELECT * FROM tbl_school_admin where group_member_id='".$groupname."'";

}
else
{

}
  
  //echo $sqldept;
  
  $querydept = mysql_query($sqldept);
 // $rowcnt = mysql_num_rows($querydept);
 // echo $rowcnt;
?> 
 <option value="">Select School</option>
 <option value="All">All</option>
 
<?PHP 
 while( $rows = mysql_fetch_assoc($querydept))
  {  
?>		<option value="<?php echo $rows["school_id"]; ?>"><?php echo $rows["school_name"]." - " .$rows["school_id"] ?></option>  
<?php	
  // echo "<option value='".$rows[t_id]."'> ".$rows[t_complete_name]."</option>";
  }
   
?>