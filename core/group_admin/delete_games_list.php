<?php
include("groupadminheader.php");

$group_member_id = $_SESSION['group_admin_id'];
$sql1 = "SELECT group_type FROM tbl_cookieadmin WHERE id='$group_member_id'";
 $query = mysql_query($sql1);
$rows = mysql_fetch_assoc($query);
$group_type= $rows['group_type']; 
$id=$_GET['id'];
if($group_type=="Sports")
{
$sql="Delete FROM  tbl_games where id='$id' ";
//echo $sql;
}
else 
{
	$sql="Delete FROM  tbl_school_subject where id='$id' ";
}
	$row=mysql_query($sql);
	$result=mysql_fetch_array($row);
	if (mysql_affected_rows() > 0) {
		?>
		<script>
		alert("Successfully Deleted");
		
		  window.location.href ="games_list.php";
		 </script>
		 <?php
    }
	else
	{
		?>
		<script>
		alert("record not Deleted");
		
		  window.location.href ="games_list.php";
		 </script>
		  <?php
	}

?>