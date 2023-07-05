
<?php
include('cookieadminheader.php');
?>
<?php

$coupon_id=$_GET['coupon_id'];

//echo"select ac.sponsored_id,ac.stud_id,ac.coupon_id,ac.points,ac.product_name,ac.issue_date,ac.user_type,ac.school_id,sp.sp_company from tbl_accept_coupon  ac join tbl_sponsorer  sp on ac.sponsored_id=sp.id  where ac.coupon_id='$coupon_id'";

$sql="select ac.sponsored_id,ac.stud_id,ac.coupon_id,ac.points,ac.product_name,ac.issue_date,ac.user_type,ac.school_id,sp.sp_company from tbl_accept_coupon  ac join tbl_sponsorer  sp on ac.sponsored_id=sp.id  where ac.coupon_id='$coupon_id'";
$row=mysql_query($sql);
//echo"$sql";
?>
<!DOCTYPE html>
<html lang="en">
<head>
<style>
 .table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
	margin-top: 66px;
	
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
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>-->
  <!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->
</head>
<body>

<div class="container">
 <!--changes done by Pranali intern start -->  
<center><h2>Accepted Coupons Log</h2></center>
    <table class="table table-striped table-bordered">
    <thead>
      <tr>
        <th>Sponsor Name</th>
        <th>Product Name</th>
        <th>Issue Date</th>
		<th>User Type</th>
		<th>School ID</th>
		<th>Points</th>
		<th>Coupon ID</th>
      </tr>
    </thead>
    <tbody>
     
	  
	  <?php   
	  while ($result = mysql_fetch_array($row))
	  { 
			  $sp_company= $result['sp_company'];
			  $product_name=$result['product_name']; 
			  $issue_date=$result['issue_date'];
			  $user_type=$result['user_type']; 
			  $school_id=$result['school_id'];
			  $points=$result['points']; 
			  $coupon_id=$result['coupon_id']; 
	  
	  
	  ?>
    <tr>
		<td><?php echo  $sp_company; ?></td>
        <td><?php echo $product_name;  ?></td>
        <td><?php echo $issue_date;  ?></td>
         <td><?php echo $user_type; ?></td> 		
		 <td><?php echo $school_id; ?></td> 
		  <td><?php echo $points; ?></td> 
		   <td><?php echo $coupon_id; ?></td> 
		   
  </tr>
   
	  <?php 
	  } 
	  ?> 
	  <!-- changes done end -->
	  
	  
	 
        
    </tbody>
  </table>
</div>

</body>
</html>
