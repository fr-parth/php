<?php 
include_once ('function.php');
include_once ('school_function.php');
?>
<?php
$report="";
//school_id taken from session by Pranali for SMC-4210 on 2-12-19
// $smartcookie=new smartcookie();
$id=$_SESSION['id'];
//            $fields=array("id"=>$id);
// 		   $table="tbl_school_admin";
		   
// 		   $smartcookie=new smartcookie();
		   
// $results=$smartcookie->retrive_individual($table,$fields);
// $result=mysql_fetch_array($results);
$school_id=$_SESSION['school_id'];
?>
<html>
<head>
<style>
table {
    width: 100%;
    border-collapse: collapse;
}

table, td, th {
    border: 1px solid black;
    padding: 5px;
}

th {text-align: left;}
</style>
<link rel="stylesheet" href="css/bootstrap.min.css">
 <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>

<script src='js/bootstrap.min.js' type='text/javascript'></script>
</head>
<body>

<?php
$method_id = xss_clean(mysql_real_escape_string(intval($_GET['method_name'])));
$subject_id=xss_clean(mysql_real_escape_string($_GET['subject_id']));
$activity_id=xss_clean(mysql_real_escape_string($_GET['activity_id']));

 $sql="SELECT * FROM tbl_master WHERE method_id = '".$method_id."' and activity_id='".$activity_id."' and school_id='".$school_id."' and subject_id='$subject_id'";
$result = mysql_query($sql);
if(mysql_num_rows($result)>0)
{
echo "<table style='padding:5px;'>
<tr style='background-color:#CCCCCC'>
<th>From Range</th>
<th>To range</th>
<th>Points</th>

</tr>";
$i=0;
$count=0;
while($row = mysql_fetch_array($result))
 {
		$from_range="from".$i;
		$to_range="to".$i;
		$point="point".$i;
    echo "<tr>";
    echo "<td><input type='text' value='" . $row['from_range'] . "' class='form-control' name='".$from_range."' id='".$from_range."'></td>";
    echo "<td><input type='text' value='". $row['to_range'] ."' class='form-control' name='".$to_range."' id='".$to_range."'></td>";
    echo "<td><input type='text' value='" . $row['points'] ."' class='form-control' name='".$point."' id='".$point."'></td>";
   
    echo "</tr>";
	$i++;
}
while($i<4)
{
	$from_range="from".$i;
		$to_range="to".$i;
		$point="point".$i;
    echo "<tr>";
    echo "<td><input type='text' value='" . $row['from_range'] . "' class='form-control' name='".$from_range."' id='".$from_range."'></td>";
    echo "<td><input type='text' value='". $row['to_range'] ."' class='form-control' name='".$to_range."' id='".$to_range."'></td>";
    echo "<td><input type='text' value='" . $row['points'] ."' class='form-control' name='".$point."' id='".$point."'></td>";
   
    echo "</tr>";
	$i++;
}

echo "</table>";
}
else
{
    //below queries added to get default rule engine for selected method by Pranali for SMC-4210 on 2-12-19
    $query=mysql_query("SELECT method_name FROM tbl_method WHERE id = '".$method_id."' and school_id='".$school_id."'");
    $res=mysql_fetch_assoc($query);

    $query1=mysql_query("SELECT id FROM tbl_method WHERE method_name = '".$res['method_name']."' and school_id='0' and group_member_id='0'");
    $res1=mysql_fetch_assoc($query1);

$sql="SELECT * FROM tbl_master WHERE method_id = '".$res1['id']."' and school_id='0' ";
$result = mysql_query($sql);

echo "<table style='padding:5px;'>
<tr style='background-color:#CCCCCC'>
<th>From Range</th>
<th>To range</th>
<th>Points</th>
</tr>";
$i=0;

while($row = mysql_fetch_array($result))
 {
		$from_range="from".$i;
		$to_range="to".$i;
		$point="point".$i;
    echo "<tr>";
    echo "<td><input type='text' value='" . $row['from_range'] . "' class='form-control' name='".$from_range."' id='".$from_range."'></td>";
    echo "<td><input type='text' value='". $row['to_range'] ."' class='form-control' name='".$to_range."' id='".$to_range."'></td>";
    echo "<td><input type='text' value='" . $row['points'] ."' class='form-control' name='".$point."' id='".$point."'></td>";
   
    echo "</tr>";
	$i++;
}

echo "</table>";

}

?>
</body>
</html>