<body>
<?php 
include('conn.php');
include('school_function.php');
$school_id=$_GET['school_id'];
$school=new school();
$result=$school->retriveclass($school_id);
while($value=mysql_fetch_array($result))
{
echo $value['class'].",";
}
?>
