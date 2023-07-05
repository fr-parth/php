<?php 
	 include("conn.php");
	 if(!isset($_SESSION['id']))
	 {
	 	header('Location:index.php');
	 }
	 $point_date = date('m/d/Y');
 $query_points = mysql_query("select r.sc_total_point, r.sc_stud_id, r.sc_reward, s.std_name from tbl_student_reward r, tbl_student s where s.id = r.sc_stud_id and  sc_stud_id = ".$_SESSION['id']);
 $row_points = mysql_fetch_array($query_points);
 $amount = $row_points['sc_reward'];
 $std_name = $row_points['std_name'];
 $stud_id = $_SESSION['id'];
 mysql_query("update tbl_student_reward set sc_reward = '0' and sc_stud_id = ".$_SESSION['id']);
 mysql_query("insert into tbl_student_reward_backup(`sc_reward`,`sc_stud_id`,`sc_date`) values('$amount','$stud_id','$point_date')");
 header("Location:student_dashboard.php");
?>