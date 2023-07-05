<?php 
	 include("conn.php");
	 if(!isset($_SESSION['id']))
	 {
	 	header('Location:index.php');
	 }
 $query_points = mysql_query("select sc_total_point, sc_stud_id, sc_reward from tbl_student_reward where sc_stud_id = ".$_SESSION['id']);
 $row_points = mysql_fetch_array($query_points);
 $msg = "";
if(isset($_POST['submit']))
{
	$points = $row_points['sc_total_point'];
	$reward = $_POST['doller'];
	if($reward <50)
	{
		$msg = "Please enter points greater than 50";
	}
	elseif($reward > $points)
	{
		$msg = "Please enter points less than $points";
	}
	elseif($reward > 50 && $reward < $points)
	{
		$new_reward = $reward + $row_points['sc_reward'];
		$new_point = $points - $reward;
		mysql_query("update tbl_student_reward set sc_reward = '$new_reward', sc_total_point = $new_point where  sc_stud_id = ".$_SESSION['id']);
		header("Location:student_dashboard.php");
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<div align="center">
<div style="height:30px; color:#FF0000;"><?php echo $msg;?></div>
<form method="post" action="">
<p>Total Points : <?php echo $row_points['sc_total_point'];?></p>

<p>Redeem Into Reward in $ <input type="text" name="doller" value="<?php echo $row_points['sc_total_point'];?>" /></p>

<p><input type="submit" name="submit" value="Confirm" />&nbsp;&nbsp;&nbsp;&nbsp;<a href="http://localhost/smartcookies/student_dashboard.php" style="text-decoration:none;"><input type="button" value="cancel" /></a></p>
</form>
</div>
</body>
</html>
