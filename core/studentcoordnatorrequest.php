<?php
 include_once('stud_header.php');
 $id=$_SESSION['id'];
		
		$query=mysql_query("select school_id,std_PRN from tbl_student where id='$id' ");
		$result=mysql_fetch_array($query);
		$school_id=$result['school_id'];
		$std_PRN=$result['std_PRN'];
		$date=date('d/m/Y');

?>
</head>
<body>

<?php
 $teacherid=$_GET['t_id'];
 
$sql=mysql_query("insert into tbl_request (stud_id1,stud_id2,requestdate,flag,entitity_id) values('$id','$teacherid','$date','N','112')") ;

header("location:requestcoordinator_teacher.php");
?>
</body>
</html>