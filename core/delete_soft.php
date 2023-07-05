<?php

	include 'conn.php';
	$userid=$_GET['userid'];
	$id=$_GET['softid'];
	if(isset($userid))
	{
		mysql_query("delete from `softreward` where `user`='$userid'");
		$message = "User has been deleted successfully..";
		echo "<script type=text/javascript>alert('$message'); window.location='softrewardslist.php'</script>";
		
	}
	elseif(isset($id))
	{
		mysql_query("delete from `softreward` where `softrewardId`='$id'");
		$message = "SoftReward has been deleted successfully..";
		echo "<script type=text/javascript>alert('$message'); window.location='softrewardslist.php'</script>";
		//header('Location:softrewardslist.php');
		//echo "<script type=text/javascript>alert('');window.location=''</script>";
	}
?>