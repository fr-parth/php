

<?php
$report="";

$smartcookie=new smartcookie();
$id=$_SESSION['id'];
           $fields=array("id"=>$id);
		   $table="tbl_school_admin";
		   
		   $smartcookie=new smartcookie();
		   
$results=$smartcookie->retrive_individual($table,$fields);
$result=mysql_fetch_array($results);
$school_id=$result['school_id'];
?>




<?php

$subject_id=$_GET['subject_id'];
$activity_id=$_GET['activity_id'];
$sql="SELECT * FROM tbl_master WHERE  school_id='".$school_id."' and subject_id='$subject_id' and activity_id='$activity_id'";
$result = mysql_query($sql);
$val=mysql_fetch_array($result);
echo $method_id=$val['method_id'];
echo     "**";
   $sql="SELECT * FROM tbl_master WHERE method_id = '".$method_id."' and activity_id='$activity_id' and school_id='".$school_id."' and subject_id='$subject_id'";
$result = mysql_query($sql);
if(mysql_num_rows($result)>0)
{
echo "<table style='padding:5px; width: 100%;
    border-collapse: collapse;'>
<tr style='background-color:#CCCCCC;text-align: left;'>
<th style=' border: 1px solid black;padding: 5px;'>From Range</th>
<th style=' border: 1px solid black;padding: 5px;'>To range</th>
<th style=' border: 1px solid black;padding: 5px;'>Points</th>

</tr>";
$i=0;
$count=0;
while($row = mysql_fetch_array($result))
 {
		$from_range="from".$i;
		$to_range="to".$i;
		$point="point".$i;
    echo "<tr >";
    echo "<td style=' border: 1px solid black;padding: 5px;'><input type='text' value='" . $row['from_range'] . "' class='form-control' name='".$from_range."' id=''></td>";
    echo "<td style=' border: 1px solid black;padding: 5px;'><input type='text' value='". $row['to_range'] ."' class='form-control' name='".$to_range."' id=''></td>";
    echo "<td style=' border: 1px solid black;padding: 5px;'><input type='text' value='" . $row['points'] ."' class='form-control' name='".$point."' id=''></td>";
   
    echo "</tr>";
	$i++;
}
while($i<4)
{
	$from_range="from".$i;
		$to_range="to".$i;
		$point="point".$i;
    echo "<tr>";
    echo "<td style=' border: 1px solid black;padding: 5px;'><input type='text' value='" . $row['from_range'] . "' class='form-control' name='".$from_range."' id=''></td>";
    echo "<td style=' border: 1px solid black;padding: 5px;'><input type='text' value='". $row['to_range'] ."' class='form-control' name='".$to_range."' id=''></td>";
    echo "<td style=' border: 1px solid black;padding: 5px;'><input type='text' value='" . $row['points'] ."' class='form-control' name='".$point."' id=''></td>";
   
    echo "</tr>";
	$i++;
}
}
?>


