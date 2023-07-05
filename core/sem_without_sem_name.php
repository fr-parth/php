<?php
include_once("scadmin_header.php");
$results = $smartcookie->retrive_individual($table, $fields);
$result = mysql_fetch_array($results);
$school_id = $result['school_id'];
$result = mysql_query("SELECT * FROM tbl_semester_master where(Semester_Name  ='' or Semester_Name is null ) and School_ID='$school_id'");
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

<!--tr:nth-child(even) {
    background-color: #dddddd;
}-->

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
  
 <!--<script>
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
</script>-->

</head>
<body>

<div class="container">
	<div class="panel panel-default">
		<div class="panel-heading" align='center'><h3> Semester  Without Semester Name</h3></div>
		<div class="panel-body">
			<div id="no-more-tables" style="padding-top:20px;">
			<table id="example" class="display" width="100%" cellspacing="0">
				<thead style="background-color:#FFFFFF;">
									
					<tr><!-- Camel casing done for Member ID and School ID by Pranali-->
					<th>Sr.No.</th>
					<th>Semester Name</th>
					<th>Branch_name</th>
					<th>CourseLevel</th>
					</tr>
				</thead>
				<tbody>
					 <?php
						$i = 1;
						while ($row= mysql_fetch_array($result)){
						//$id=$row['id'];
						//echo "select t_complete_name where id='$id'";
						//$q=mysql_query("select Email_Id from tbl_department_master where id='$id'");
						//$result1=mysql_fetch_array($q);
						
					 ?>
						<tr>
							<td data-title="id"><?php echo $i; ?></td>
							<td data-title=""><?php echo $row['Semester_Name']; ?></td>
							<td><?php echo $row['Branch_name']; ?></td>
							<td><?php echo $row['CourseLevel']; ?></td>
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