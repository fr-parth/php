<?php
header("Content-type: application/vnd.ms-excel; charset=utf-8");
header("Content-disposition: attachment; filename=xls_file_".date("Ymd").".xls");
include 'conn.php';


//echo "select * from tbl_teacher where id='$id'";
$id=$_SESSION['id'];
$query="select * from `tbl_school_admin` where id='$id'";       // getting the the school id of login user by checking the session
$row1=mysql_query($query);
$value1=mysql_fetch_array($row1);
 $school_id=$value1['school_id'];
$sql="select t_current_school_name,t_firstname,t_middlename,t_lastname,t_password,t_phone,t_email from tbl_teacher where school_id='$school_id'"; 

//$passfile=fopen("passfile.docx","a") or die("Unable to open file!");
					
					//$total= mysql_num_rows($sql1);
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
echo "<table border=1><tr><td colspan=5><b><center><font size=16px;>Teachers Password List</font></center></b></td></tr><tr><td colspan=5>*You can use either phone number or email id as a login id.</td></tr><tr><td>Sr.No.</td><td>School Name</td><td>First Name</td><td>Middle Name</td><td>Last Name</td><td>Phone No.</td><td>Email</td><td>Password</td></tr>";
$p=1;
	//fwrite($passfile,"<table border=1><tr><td>Sr.No.</td><td>Teachers Name</td><td>Username/PhoneNo.</td><td>Password</td></tr>");
while($row = mysql_fetch_assoc($result)) {
    $t_school_name=$row["t_current_school_name"];
	$f_name=$row["t_firstname"];
	$m_name=$row["t_middlename"];
	$l_name=$row["t_lastname"];
	$t_phone= $row["t_phone"];
    $t_password=$row["t_password"];
	$t_email=$row["t_email"];
	//fwrite($passfile,"<tr><td>$p</td><td>$t_name</td><td>$t_phone</td><td>$t_password</td></tr>");
	echo "<tr><td>$p</td><td>$t_school_name</td><td>$f_name</td><td>$m_name</td><td>$l_name</td><td>$t_phone</td><td>$t_email</td><td>$t_password</td></tr>";
	$p++;
}
//fwrite($passfile,"</table>");
echo "</table>";

mysql_free_result($result);

					
//while($total){
//	mysql_fetch_assoc();
//fwrite($passfile, $sql1);
//$txt = "Jane Doe\n";
//fwrite($myfile, $txt);
//fclose($passfile);
?>
