

<?php
include('cookieadminheader.php');
?>
<?php

	//$row=mysql_query("Select t.t_complete_name,l.EntityID,l.school_id,l.LatestLoginTime from tbl_LoginStatus l INNER JOIN tbl_teacher t on t.id=l.EntityID where Entity_type='103' ");
//$result=mysql_fetch_array($sql);

//$row=mysql_query("SELECT tvc.coupon_id, tvc.user_id, ts.sp_name FROM tbl_selected_vendor_coupons as tvc join tbl_sponsorer as ts on tvc.sponsor_id = ts.id where tvc.entity_id='2'");
$row=mysql_query("SELECT tvc.coupon_id, tvc.code, tvc.user_id FROM tbl_selected_vendor_coupons as tvc where tvc.entity_id='2'");


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
  <!-- Title Vendor Coupon Used By Teacher modified by Pranali -->
    <div class="panel-heading" align='center'><h3> Vendor Coupons Used By Teachers</h3></div>
	<div class="panel-body">
		 <div id="no-more-tables" style="padding-top:20px;">
	<table id="example" class="display" width="100%" cellspacing="0">
	<thead style="background-color:#FFFFFF;">
                        
		<tr>
		<!--Camel casing for Member ID & School ID done by Pranali  -->
		<th>Sr.No.</th>
		<th>Teacher Name</th>
		<th>Member ID</th>
		<th>School ID</th>
		<th>Coupon ID</th>
		<th>Coupon Code</th>
		
		
		
		

		</tr>
		</thead>
	<tbody>
     <?php
	 $i = 1;
	 
       while ($result= mysql_fetch_array($row)){
		$id=$result['user_id'];
		//echo "select t_complete_name where id='$id'";
		$q=mysql_query("select t_complete_name,school_id from tbl_teacher where id='$id'");
		$result1=mysql_fetch_array($q);
	   	
     ?>
			<tr>
			<td data-title="id"><?php echo $i; ?></td>
			<td data-title="Couponid"><?php echo $result1['t_complete_name']; ?></td>

				
			<td><?php echo $result['user_id']; ?></td>
			<td><?php echo $result1['school_id']; ?></td>
			<td><?php echo $result['coupon_id']; ?></td>
			<td><?php echo $result['code']; ?></td>
			
			
			
			
			
			



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