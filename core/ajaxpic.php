<?php
include_once ('conn.php');


$query = mysql_query("select * from tbl_student where id = ".$_SESSION['id']);
$value = mysql_fetch_array($query);
$school_id=$value['school_id'];
$id=$_SESSION['id'];


$path = "student_image/";
 
$valid_formats = array("jpg", "png", "gif", "bmp","jpeg");
if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST")
{
$name = $_FILES['photoimg']['name'];
$size = $_FILES['photoimg']['size'];
if(strlen($name))
{
list($txt, $ext) = explode(".", $name);
if(in_array($ext,$valid_formats))
{
if($size<(1024*1024)) // Image size max 1 MB
{
$actual_image_name = time().$id.".".$ext;
$tmp = $_FILES['photoimg']['tmp_name'];
if(move_uploaded_file($tmp, $path.$actual_image_name))
{

mysql_query("UPDATE tbl_student SET std_img_path='$path$actual_image_name' WHERE id='$id'");
echo "<img src='student_image/".$actual_image_name."'  class='preview'>";
}
else
echo "failed";
}
else
echo "Image file size max 1 MB"; 
}
else
echo "Invalid file format.."; 
}
else
echo "Please select image..!";
exit;
}
?>