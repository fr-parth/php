<?php 
//include('scadmin_header.php');
include('conn.php');
 echo $school_name=$_POST['school_name'];

  $sqldept = "Select password from tbl_school_admin  where  id='".$school_name."'";
  //echo $sqldept;
  
  $querydept = mysql_query($sqldept);
 // $rowcnt = mysql_num_rows($querydept);
 // echo $rowcnt;
?> 
Password
<?PHP 
  $rows = mysql_fetch_assoc($querydept)
   
?>		<option value="<?php echo $rows["password"]; ?>"><?php echo $rows["password"]; ?></option>


