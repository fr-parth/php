<?php
include('../conn.php');
$result = $_POST['reason'];

$check_query =  mysql_query("select * from tbl_student_recognition where student_recognition = '$result'");

$count = mysql_num_rows($check_query);
if($count > 0 )
{
  console.log('hi');
  echo "already present";
}
else {

console.log('hi123');
$sql = mysql_query("insert into tbl_student_recognition (student_recognition) values ('$result')");



if($sql)
{
echo true;
}
else {
  echo false;
}

}
?>
