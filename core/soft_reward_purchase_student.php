

<?php
include('cookieadminheader.php');
?>
<?php

	//$row=mysql_query("Select t.t_complete_name,l.EntityID,l.school_id,l.LatestLoginTime from tbl_LoginStatus l INNER JOIN tbl_teacher t on t.id=l.EntityID where Entity_type='103' ");
//$result=mysql_fetch_array($sql);

$row=mysql_query("SELECT p.user_id,p.school_id ,s.rewardType FROM purcheseSoftreward as p inner join softreward as s on p.reward_id=s.softrewardId where userType='Student'");



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
  <!-- Title Soft Reward Purchased By Student modified by Pranali -->
    <div class="panel-heading" align='center'><h3> Soft Rewards Purchased By Students</h3></div>
	<div class="panel-body">
		 <div id="no-more-tables" style="padding-top:20px;">
	<table id="example" class="display" width="100%" cellspacing="0">
	<thead style="background-color:#FFFFFF;">
                        
		<tr>
		<!--Camel casing for Member ID & School ID done by Pranali  -->
		<th>Sr.No.</th>
		<th>Student Name</th>
		<th>Member ID</th>
		<th>Reward Type</th>
		<th>School ID</th>
		
		
		

		</tr>
		</thead>
	<tbody>
     <?php
	 $i = 1;
	 
       while ($result= mysql_fetch_array($row)){
		$id=$result['user_id'];
		//echo "select t_complete_name where id='$id'";
		$q=mysql_query("select std_complete_name from tbl_student where std_PRN='$id'");
		$result1=mysql_fetch_array($q);
	   	
     ?>
			<tr>
			<td data-title="id"><?php echo $i; ?></td>
			<td data-title="Couponid"><?php echo $result1['std_complete_name']; ?></td>

				
			<td><?php echo $result['user_id']; ?></td>
			<td><?php echo $result['rewardType']; ?></td>
			<td><?php echo $result['school_id']; ?></td>
			
			



</tr>


</tr>
		<?php $i++;
                 }
					
                    ?>
					</thead>
 <tbody>
</table>

</div>
</div>
</div>
</div>
</body>


</html>