<?php
header("Content-type: application/vnd.ms-excel; charset=utf-8");
header("Content-disposition: attachment; filename=teacher_error_file".date("Ymd").".xls");
include("conn.php");
	
$id=$_SESSION['id'];
$query="select * from `tbl_school_admin` where id='$id'";       // getting the the school id of login user by checking the session
$row1=mysql_query($query);
$value1=mysql_fetch_array($row1);
 $school_id=$value1['school_id'];

$sql="select t_id,t_name,t_middlename,t_lastname,t_school_name,t_school_id,t_dept,t_password,t_phone,batch_id,input_file_name,
uploaded_date_time,uploaded_by,error_records,t_email from `tbl_raw_teacher` where t_school_id='$school_id' and (error_records like 'Err-Phone/Email' OR error_records like 'Err-Tid' OR error_records like 'Err-Dept' OR error_records like 'Err-Name') "; 

    

$result = mysql_query($sql);

if (!$result) {
    echo "Could not successfully run query ($sql) from DB: " . mysql_error();
    exit;
}

if (mysql_num_rows($result) == 0) {
    echo "No rows found, nothing to print so am exiting";
    exit;
}

// While a row of data exists, put that row in $row as an associative array
// Note: If you're expecting just one row, no need to use a loop
// Note: If you put extract($row); inside the following loop, you'll
//       then create $userid, $fullname, and $userstatus
echo "<table border=1><tr><td colspan=12><b><center><font size=30px;>-------------: Teachers Name Error List :---------------</font></b></td></tr></center><tr><td colspan=12><center>*Please Try to resolve the errors as soon as possible.</center></td></tr><tr><td>Sr.No.</td><td>Teachers ID</td><td>First name</td><td>Middle name</td><td>Last name</td><td>School name</td><td>School ID</td><td>Department</td><td>Phone No.</td><td>Batch ID</td><td>Error Records</td></tr>";
$p=1;
	
while($row = mysql_fetch_assoc($result)) {
	
	
	$t_id=$row["t_id"];
	$t_first=$row["t_name"];
	$t_middle=$row["t_middlename"];
	$t_last=$row["t_lastname"];
	$t_school=$row["t_school_name"];
	$t_sid=$row["t_school_id"];
	$t_dept=$row["t_dept"];
	$t_phone=$row["t_phone"];
	$t_bid=$row["batch_id"];
	$t_inputfn=$row["input_file_name"];
	$t_uploadeddt=$row["uploaded_date_time"];
	$t_uploadedby=$row["uploaded_by"];
	$t_err=$row["error_records"];
	$t_email=$row["t_email"];
	
	echo "<script type=text/javascript>alert('error'); window.location=''</script>";
	
   

	echo "<tr><td>$p</td><td>$t_id</td><td>$t_first</td><td>$t_middle</td><td>$t_last</td><td>$t_school</td><td>$t_sid</td><td>$t_dept</td><td>$t_phone</td><td>$t_email</td><td>$t_bid</td><td>$t_err</td></tr>";
	$p++;
}
//fwrite($passfile,"</table>");
echo "</table>";

mysql_free_result($result);

					

?>
