<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
<title>Info Table</title>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

</head>
<body>



<?php

$id = $_GET['id'];

$conn = mysql_connect("localhost","root","");
$db = mysql_select_db("smartcookie");
$query="select * from college_list where id='$id'";

$sql = mysql_query($query);

$row = mysql_fetch_array($sql);

?>

<h2 style="text-align:center;color:#6600CC;">Update Data</h2>
<form method="post" >
<div>
<table align="center" style="margin-top: 1cm;">
<tr>
<th>College Code:</th>
<td><input type="text" name="college_code" value="<?php echo $row['college_code']?>" ></td>
</tr>
<tr>
<th>Stream:</th>
<td><input type="text" name="stream" value="<?php echo $row['stream']?>" ></td>
</tr>
<tr>
<th>College Name:</th>
<td><textarea cols="25" rows="5" name="college_name" ><?php echo $row['college_name'] ?></textarea></td>
</tr>
<tr>
<th>College Location:</th>
<td><input type="text" name="college_location"  value="<?php echo $row['college_location'] ?>"  ></td>
</tr>
<tr>
<th>College Intake:</th>
<td><input type="text" name="intake" value="<?php echo $row['intake'] ?>"  ></td>
</tr>
<tr>
<th>Principal Name:</th>
<td><input type="text" name="pricipal_name"  value="<?php echo $row['pricipal_name'] ?>" ></td>
</tr>
<tr>
<th>Cotact Number:</th>
<td><input type="text" name="contact_number"  value="<?php echo $row['contact_number']?>" ></td>
</tr>
<tr>
<th>Alternate Contact:</th>
<td><input type="text" name="alternate_contact"  value="<?php echo $row['alternate_contact'] ?>" ></td>
</tr>
<tr>
<th>College Email:</th>
<td><input type="text" name="college_email" value="<?php echo $row['college_email'] ?>"  ></td>
</tr>
<tr>
<th>TPO Name:</th>
<td><input type="text" name="tpo_name"  value="<?php echo $row['tpo_name'] ?>" ></td>
</tr>
<tr>
<th>TPO Contact:</th>
<td><input type="text" name="tpo_contact"  value="<?php echo $row['tpo_contact'] ?>"  ></td>
</tr>
<tr>
<th>TPO Email:</th>
<td><input type="text" name="tpo_email"  value="<?php echo $row['tpo_email'] ?>"></td>
</tr>
<tr>
<th>Number Of Teachers:</th>
<td><input type="text" name="number_of_teachers"  value="<?php echo $row['number_of_teachers'] ?>"  ></td>
</tr>
<tr>
<th>Number Of Students:</th>
<td><input type="text" name="number_of_students" value="<?php echo $row['number_of_students'] ?>" ></td>
</tr>
<tr>
<th>Number Of Subjects:</th>
<td><input type="text" name="number_of_subjects" value="<?php echo $row['number_of_subjects'] ?>" ></td>
</tr>
<tr>
<th>Data Updated Date:</th>
<td><input type="text" name="date_Updated"  value="<?php echo $row['date_Updated'] ?>" ></td>
</tr>
<tr>
<tr>
<th>Source:</th>
<td><input type="text" name="source"  value="<?php echo $row['source'] ?>" ></td>
</tr>
<tr>
<td><input type="submit" value="update" name="submit" class="btn btn-primary"></td>
</tr>

</table>
<div>
</form>


<?php

if(isset($_POST['submit']))
{
$college_code = $_POST['college_code'];
$stream=$_POST['stream'];
$college_name= mysql_real_escape_string($_POST['college_name']);
$college_location=$_POST['college_location'];
$intake=$_POST['intake'];
$pricipal_name=$_POST['pricipal_name'];
$contact_number=$_POST['contact_number'];
$alternate_contact=$_POST['alternate_contact'];
$college_email=$_POST['college_email'];
$tpo_name=$_POST['tpo_name'];
$tpo_contact=$_POST['tpo_contact'];
$tpo_email=$_POST['tpo_email'];
$number_of_teachers=$_POST['number_of_teachers'];
$number_of_students=$_POST['number_of_students'];
$number_of_subjects=$_POST['number_of_subjects'];
$date_Updated=$_POST['date_Updated'];
$source=$_POST['source'];

//echo "update college_list set college_code='$college_code',stream='$stream',college_name='$college_name',college_location='$college_location',intake='$intake',principal_name='$pricipal_name',contact_number='$contact_number',alternate_contact='$alternate_contact',college_email='$college_email',tpo_name='$tpo_name',tpo_contact='$tpo_contact',tpo_email='$tpo_email',number_of_teachers='$number_of_teachers',number_of_students='$number_of_students',date_Updated='$date_Updated' where id='$id'";

$query="update college_list set college_code='$college_code',stream='$stream',college_name='$college_name',college_location='$college_location',intake='$intake',pricipal_name='$pricipal_name',contact_number='$contact_number',alternate_contact='$alternate_contact',college_email='$college_email',tpo_name='$tpo_name',tpo_contact='$tpo_contact',tpo_email='$tpo_email',number_of_teachers='$number_of_teachers',number_of_students='$number_of_students',number_of_subjects='$number_of_subjects',date_Updated='$date_Updated',source='$source' where id='$id'";

$sql = mysql_query($query);
if($sql==true)
{
?>
<script>

window.alert('successfully updated the data');
window.location.assign('trialdatatable.php');
</script>

<?php
}
}


?>
</body>
</html>
