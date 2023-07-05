<?php
header("Content-type: application/vnd.ms-excel; charset=utf-8");
header("Content-disposition: attachment; filename=Student_Error_File".date("Ymd").".xls");
//header('Content-disposition: filename='.$filename.'.csv');
include("conn.php");
	
$id=$_SESSION['id'];
$query="select * from `tbl_school_admin` where id='$id'";       // getting the the school id of login user by checking the session
$row1=mysql_query($query);
$value1=mysql_fetch_array($row1);
 $school_id=$value1['school_id'];

$sql="select s_PRN,s_firstname,s_middlename,s_lastname,s_school_name,s_school_id,s_dept,s_phone,s_email,batch_id,input_file_name,
uploaded_date_time,uploaded_by,error_records from `tbl_raw_student` where s_school_id='$school_id' and (error_records like 'Err-Phone/Email' OR error_records like 'Err-SPRN' OR error_records like 'Err-Branch' OR error_records like 'Err-Name') "; 

    

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
echo "<table border=1><tr><td colspan=12><b><center><font size=30px;>-------------: Students Name Error List :---------------</font></b></td></tr></center><tr><td colspan=12><center>*Please Try to resolve the errors as soon as possible.</center></td></tr><tr><td>Sr.No.</td><td>Student PRN</td><td>First name</td><td>Middle name</td><td>Last name</td><td>School name</td><td>School ID</td><td>Branch</td><td>Phone No.</td><td>Email ID</td><td>Batch ID</td><td>Error Records</td></tr>";
//echo "Student PRN"." "."First Name"." "."Middle Name"." "."Last Name"." "."School Name"." "."School ID"." "."Department"." "."Phone"." "."Email ID"." "."Batch ID"." "."Error Status";

$p=1;
	
while($row = mysql_fetch_assoc($result)) {
	
	
	$s_id=$row["s_PRN"];
	$s_first=$row["s_firstname"];
	$s_middle=$row["s_middlename"];
	$s_last=$row["s_lastname"];
	$s_school=$row["s_school_name"];
	$s_sid=$row["s_school_id"];
	$s_dept=$row["s_dept"];
	$s_branch=$row["s_branch"];
	$s_phone=$row["s_phone"];
	$s_bid=$row["batch_id"];
	$s_inputfn=$row["input_file_name"];
	$s_uploadeddt=$row["uploaded_date_time"];
	$s_uploadedby=$row["uploaded_by"];
	$s_err=$row["error_records"];
	$s_email=$row["s_email"];
	
	echo "<script type=text/javascript>alert('error'); window.location=''</script>";
	
   

	echo "<tr><td>$p</td><td>$s_id</td><td>$s_first</td><td>$s_middle</td><td>$s_last</td><td>$s_school</td><td>$s_sid</td><td>$s_branch</td><td>$s_phone</td><td>$s_email</td><td>$s_bid</td><td>$s_err</td></tr>";
	//echo $s_id." ".$s_first." ".$s_middle." ".$s_last." ".$s_school." ".$s_sid." ".$s_dept." ".$s_phone." ".$s_email." ".$s_bid." ".$s_err.;
	$p++;
}
//fwrite($passfile,"</table>");
echo "</table>";

mysql_free_result($result);

					

?>
