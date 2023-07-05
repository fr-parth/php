<?php
include('cookieadminheader.php');
$result =  mysql_query("SELECT * FROM tbl_coupons as student_smartcookie_used where status = 'no' or status = 'p' order by id Desc");
?>
<html>
<head>
<style>
table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

/* tr:nth-child(even) {
    background-color: #dddddd;
} */

</style>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#datepicker" ).datepicker({
				
         dateFormat: 'dd/mm/yy',     
            });

  } );
  </script
<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>

  
  <script src="https://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.9/js/dataTables.bootstrap.min.js"></script>
  
 <script>
 $(document).ready(function() 
 {

    $('#example').DataTable(
	{
	"pageLength": 5
	});
	
	$('#example1').DataTable(
	{
	"pageLength": 5
	});
} );
</script>

</head>
<body>

<div class="container">
	<div class="panel panel-default">
	<!-- Camel casing done for Title "SmartCookie Coupons Used By Students" by Pranali -->
		<div class="panel-heading" align='center'><h2>SmartCookie Coupons Used By Students</h2></div>
		<div class="panel-body">
			<div id="no-more-tables" style="padding-top:20px;">
			<table id="example" class="display" width="100%" cellspacing="0">
				<thead style="background-color:#FFFFFF;">
									
					<tr>
					<!--Camel casing for Coupon ID,School ID & Amount done by Pranali  -->
					<th>Sr.No.</th>
					<th>Student Name</th>
					<th>School ID</th>
					<th>Coupon ID</th>
					<th>Amount</th>
					
					</tr>
				</thead>
				<tbody>
					 <?php
						$i = 1;
						while ($row= mysql_fetch_array($result)){
					 ?>
						<tr>
							<td><?php echo $i; ?></td>
							<td><?php echo $row['stud_complete_name']; ?></td>
							<td><?php echo $row['school_id']; ?></td>
							<td><?php echo $row['cp_code']; ?></td>
							<td><?php echo $row['amount']; ?></td>
						</tr>
					<?php $i++;} ?>     
				</tbody>
			</table>

			</div>
		</div>
	</div>
</div>
</body>
</html>