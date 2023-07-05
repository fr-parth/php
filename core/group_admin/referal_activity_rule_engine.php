<?php include("cookieadminheader.php"); ?>
<!DOCTYPE html>
<html lang="en">
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
  <script>
  function delete_item(id)
  {
	  if(confirm("Do you want to delete the record") == true)
	  {
		  window.location.assign("/core/add_update_delete_referal_activity.php?curd=delete&id="+id);
	  }
  }
  </script>
</head>
<body>
 
<div class="container row">
	<div class='col-md-8 col-md-offset-3' align='center'>
	 <div class="panel-body">
	  <h2 style='background-color:#694489;color:white;text-decoration:underline;padding:10px'><b>Referral Activity Rule Engine</b></h2>
	  <a href='add_update_delete_referal_activity.php?curd=add'><button type="button" class="btn btn-primary">Add More</button></a>
	 </div>
	  <div class="panel panel-default">
		<div class="panel-body">
			<table id='myTable'>
			<thead>
				<tr>
					<th>From User</th>
					<th>To User</th>
					<th>Points</th>
					<th>Reason</th>
					<th>Edit</th>
					<th>Delete</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$query = mysql_query("select * from rule_engine_for_referral_activity");
					while($row=mysql_fetch_assoc($query)){
				?>
					<tr>
						<td><?php echo $row['from_user'];?></td>
						<td><?php echo $row['to_user'];?></td>
						<td><?php echo $row['points'];?></td>
		
						<!--changes done by Pranali intern-->
						<td><?php echo ucwords($row['referal_reason'],"_");?></td>
						<td><a href="add_update_delete_referal_activity.php?curd=update&id=<?php echo $row['id'];?>"><i class='glyphicon glyphicon-pencil'></i></a></td>
						<td><p onclick="delete_item(<?php echo $row['id'];?>)"><i class='glyphicon glyphicon-trash'></i></p></td>
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


