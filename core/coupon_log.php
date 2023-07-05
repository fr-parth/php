

<?php
include('cookieadminheader.php');
?>
<?php
//$sql=mysql_query("select s.coupon_id,s.amount,s.issue_date,s.validity_date,s.user_id,s.status,s.used_points,s.original_point,t.t_id,t.t_complete_name,sp.sp_company sp.coupon_id from tbl_teacher_coupon  s INNER JOIN tbl_teacher  t INNER JOIN tbl_sponsorer  sp INNER JOIN  tbl_accept_coupon spa on s.user_id=t.t_id and s.coupon_id=spa.coupon_id where status='no'");

//$sqltech=("SELECT tc.coupon_id,tc.user_id,tc.amount,tc.original_point,tc.issue_date,t.t_complete_name,t.t_name,t.t_middlename,tc.issue_date,tc.validity_date,t.t_lastname FROM tbl_teacher_coupon tc join  tbl_teacher t on t.id=tc.user_id where status='p'  order by tc.id DESC ");
//$row=mysql_query($sqltech);

if (isset($_POST['search'])) 
    {
	//datepicker,coupon_id,uname
	  $datepicker = $_POST['datepicker'];
	  $coupon_id = $_POST['coupon_id'];
	$uname = $_POST['uname'];
	
$sqltech="SELECT tc.status,tc.coupon_id,tc.user_id,tc.amount,tc.original_point,t.t_complete_name,t.t_name,t.t_middlename,tc.issue_date,t.t_lastname FROM tbl_teacher_coupon tc join  tbl_teacher t on t.id=tc.user_id";
	
if($coupon_id!='')
     {
		 
	$sqltech.=" where (status='p'or status='no') and  tc.coupon_id LIKE '%$coupon_id%'";
	
		 
	 }
	 
	elseif($datepicker!='')
     {
		 
	$sqltech.=" where (status='p' or status='no') and tc.issue_date='$datepicker'";	

	 }
	 elseif($datepicker!='' && $coupon_id!='')
     {
		 
	$sqltech.=" where (status='p' or status='no') and tc.issue_date='$datepicker' and tc.coupon_id LIKE '%$coupon_id%'";	

	 }
	 elseif($datepicker!='' && $uname!='')
     {
		 
	$sqltech.=" where (status='p' or status='no') and tc.issue_date='$datepicker' and t.t_complete_name LIKE '%$uname%' or CONCAT(t.t_name,t.t_middlename) LIKE '%$uname%'";	

	 }
	 elseif($datepicker!='' && $uname!=''&& $coupon_id!='')
     {
		 
	$sqltech.=" where (status='p' or status='no') and tc.issue_date='$datepicker' and t.t_complete_name LIKE '%$uname%' or CONCAT(t.t_name,t.t_middlename) LIKE '%$uname%' and tc.coupon_id LIKE '%$coupon_id%'";	

	 }
	 
	 elseif($uname!='')
	 {	 
	$sqltech.=" where (status='p' or status='no') and t.t_complete_name LIKE '%$uname%' or CONCAT(t.t_name,t.t_middlename) LIKE '%$uname%'";
	
		  
		 
	 }
	 elseif($uname!='' && $coupon_id!='' )
	 {	 
	$sqltech.=" where (status='p' or status='no')  and tc.coupon_id LIKE '%$coupon_id%' and t.t_complete_name LIKE '%$uname%' or CONCAT(t.t_name,t.t_middlename) LIKE '%$uname%'";	 
	 }
	 
   // $row=mysql_query($sqltech);
    }
	
   else
	{
		
	$sqltech=("SELECT tc.status,tc.coupon_id,tc.user_id,tc.amount,tc.issue_date,t.t_complete_name,t.t_name,t.t_middlename,tc.issue_date,tc.original_point,tc.validity_date,t.t_lastname FROM tbl_teacher_coupon tc join tbl_teacher t on t.id=tc.user_id where tc.status='p' or tc.status='no' order by tc.id DESC");	

	}
	//echo $sqltech;
$row = mysql_query($sqltech);
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

		 dateFormat: 'yy-mm-dd'
            
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
<h1><center>Used Coupon  Log For Teacher</center></h1>
		  <div class="row">
		   <form method="post">
			<div class="col-sm-3" style="background-color:lavender;">From <input type="text" id="datepicker" name="datepicker"  value="<?php if (isset($_POST['datepicker'])) {echo $_POST['datepicker'];} ?>" class="form-control">
		</div>
		<!-- Camel casing for placeholders Coupon ID, User Name done by Pranali -->
			<div class="col-sm-3" style="background-color:lavender;">Coupon ID<input type="text" id="coupon_id" name="coupon_id" value="<?php if (isset($_POST['coupon_id'])) {echo $_POST['coupon_id'];} ?>" placeholder="Coupon ID" class="form-control" >
		</div>
		 <div class="col-sm-3" style="background-color:lavender;">User Name<input type="text" id="uname" name="uname" value="<?php if (isset($_POST['uname'])) {echo $_POST['uname'];} ?>"placeholder="User Name" class="form-control">
		</div>
		 <div class="col-sm-3" style="">
		 <input type="submit" name="search" value="Search" class="btn btn-primary">
			</div>
			</form
		  </div>
		</div>
		 <div id="no-more-tables" style="padding-top:20px;">
	<table id="example" class="display" width="100%" cellspacing="0">
	<thead style="background-color:#FFFFFF;">
                        
		<tr>
		<th>Sr.No.</th>
		<th>Coupon</th>
		<th>Generated By</th>
		<th>Name</th>
		<th>Generated Date</th>
		<th>Original Point</th>
		<th>Status</th>
		<!-- Spelling of Remaining  Point corrected by Pranali-->
		<th> Remaining  Point</th>
		<th> Details</th>

		</tr>
		</thead>
	<tbody>
     <?php
	 $i = 1;
       while ($result = mysql_fetch_array($row)){
		
		$compname=$result['t_complete_name'];	
		$name=$result['t_name'];
		$middlename=$result['t_middlename'];
		$lastname=$result['t_lastname'];
		
		if($compname=='')
		{
		$finalname=$name."".$middlename."".$lastname;
		}
		else
		{
			$finalname=$result['t_complete_name'];
		}
     ?>
			<tr>
			<td data-title="id"><?php echo $i; ?></td>
			<td data-title="Couponid"><?php echo $result['coupon_id']; ?></td>

			<td>
			<?php echo "Teacher";?>
			</td>
				
			<td><?php echo $finalname; ?></td>
			<td><?php echo $result['issue_date']; ?></td>
			<td><?php echo $result['original_point']; ?></td>
			<td><?php

			$status=$result['status'];
			if($status==no) 
			{
				
				echo"Used";
				
			}
			 else 
			 {
				 echo"PartiallyUsed";
				 
			 }
 
 
 ?></td>
<td><?php echo $result['amount']; ?></td>
<td> <a href="Purchsed_Coupon_Details.php?coupon_id=<?php echo $result['coupon_id'];?>">Show Details</td>


</tr>


</tr>
		<?php $i++;
                 }
					
                    ?>
					</thead>
 <tbody>
</table>

</div>
</body>


</html>