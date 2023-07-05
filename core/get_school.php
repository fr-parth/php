
<?php 
error_reporting(0);
include('conn.php');
include('school_function.php');
$school_id=$_GET['school_id'];
$type=$_GET['type'];
if($type=='class')
{
$school=new school();
$result=$school->retriveclass($school_id);
while($value=mysql_fetch_array($result))
{

echo $value['class'].",";
}
}
else
if($type=='subject')
{
$school=new school();
$result=$school->retrivesubject($school_id);
while($value=mysql_fetch_array($result))
{

echo ucwords($value['subject']).",";
}

}
else if($type=='activity')
{
$values="";
$school=new school();
$result1=$school->retriveactivity($school_id);

while($value1=mysql_fetch_array($result1))
{

echo ucwords($value1['sc_list']).",";
}


}
?>
