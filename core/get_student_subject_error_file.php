<?php
header("Content-type: application/vnd.ms-excel; charset=utf-8");
header("Content-disposition: attachment; filename=studentSub_error_file".date("Ymd").".xls");
include("conn.php");
	
$id=$_SESSION['id'];
$query="select * from `tbl_school_admin` where id='$id'";       // getting the the school id of login user by checking the session
$row1=mysql_query($query);
$value1=mysql_fetch_array($row1);
 $school_id=$value1['school_id'];

$sql="select stud_sub_id from `tbl_student_subject` where status='N'";

    

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
echo "<table border=1><tr><td colspan=12><b><center><font size=30px;>-------------: Student Subject Name Error List :---------------</font></b></td></tr></center><tr><td colspan=12><center>*Please Try to resolve the errors as soon as possible.</center></td></tr><tr><td>Sr.No.</td><td>Student PRN</td><td>Student Name</td><td>Subject Code</td><td>Subject Title</td></tr>";
$p=1;
	
while($row = mysql_fetch_assoc($result)) {
	
	
	$studentID=$row["stud_sub_id"];
	    $dataArray=explode(",",$studentID);
	$studentPRN=$dataArray[0];
	$School_ID=$dataArray[1];
    $subject_Code=$dataArray[2];
	$subject_Title=$dataArray[3];	

	
	
	
   

	echo "<tr> <td>$p</td><td>$studentPRN</td><td>$School_ID</td><td>$subject_Code</td><td>$subject_Title</td> </tr>";
	//$p++;
}
//fwrite($passfile,"</table>");
echo "</table>";



					

?>
