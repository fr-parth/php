
<?php
 include_once('conn.php');
 include_once('Parent_header.php');
 $parent_id = $_SESSION['id'];



?>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <link rel="stylesheet" href="//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">
    <script src="//cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
    <script>
    $(document).ready(function(){
      $('#myTable').DataTable();
    });
    </script>

  </head>
  <body>
    <div class="container row">
    	<div class='col-md-8 col-md-offset-3' align='center'>
    	 <div class="panel-body">
    	  <h3 style='background-color:#9900CC;color:white;text-decoration:underline;padding:10px'><b>Received Proud Points Log</b></h3>

    	 </div>
    	  <div class="panel panel-default">
    		<div class="panel-body">
    			<table id='myTable'>
    			<thead>
    				<tr>
    					<th>Proud Points</th>
    					<th>From Teacher</th>
    					<th>To Child</th>
    					<th>Reason</th>
    					<th>Comment</th>
    					<th>Date</th>
    				</tr>
    			</thead>



    			<tbody>
    				<?php
            $proud_query = mysql_query("SELECT * FROM Tbl_proud_points_log where Parent_member_id='$parent_id'");
            while($row = mysql_fetch_assoc($proud_query)){
            $Teacher_member_id = $row['Teacher_member_id'];
            $teacher_query = mysql_query("SELECT * FROM tbl_teacher where id='$Teacher_member_id'");
            $teacher_query_result = mysql_fetch_assoc($teacher_query);
            $teacher_name = $teacher_query_result['t_complete_name'];

            $Student_member_id = $row['Student_member_id'];
            $student_query = mysql_query("SELECT * FROM tbl_student where id='$Student_member_id'");
            $student_query_result = mysql_fetch_assoc($student_query);
            $student_name = $teacher_query_result['std_complete_name'];
    				?>
    					<tr>
    						<td><?php echo $row['Proud_Points'];?></td>
    						<td><?php echo $teacher_name;?></td>
    						<td><?php echo $student_name;?></td>
    						<td><?php echo $row['Reason'];?></td>
                <td><?php echo $row['Comment'];?></td>
    						<td><?php echo $row['Point_datestamp'];?></td>
    						<!--<td><a href="add_update_delete_referal_activity.php?curd=delete&id=<?php echo $row['id'];?>"><i class='glyphicon glyphicon-trash'></i></a></td>-->
    					</tr>
    				<?php
    					}
    				?>
    			</tbody>
    		</div>
    	</div>
      </div>
    </div>

  </body>
</html>
