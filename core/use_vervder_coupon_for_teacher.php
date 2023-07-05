

<?php
include('cookieadminheader.php');
?>
<?php
if (isset($_POST['search'])) 
    {
	//datepicker,coupon_id,uname
	  $datepicker = $_POST['datepicker'];
	  $coupon_id = $_POST['coupon_id'];
	$uname = $_POST['uname'];
	$spname = $_POST['spname'];
	//$sqltech="select svc.entity_id,svc.used_flag,svc.coupon_id,svc.school_id,svc.sponsor_id,svc.for_points,svc.valid_until,t.id,t.t_complete_name from smartcoo_dev.tbl_selected_vendor_coupons svc join smartcoo_dev.tbl_teacher t on t.id=svc.user_id where svc.used_flag='used'";
$sqltech="select svc.code,svc.entity_id,svc.used_flag,svc.coupon_id,sp.sp_company,svc.school_id,svc.sponsor_id,svc.for_points,svc.valid_until,t.id,t.t_complete_name from tbl_selected_vendor_coupons svc join tbl_teacher t join tbl_sponsorer sp on t.id=svc.user_id and svc.sponsor_id=sp.id ";

	//$sqltech="select * from tbl_coupons";	
if($coupon_id!='')
     {
		 
	$sqltech.=" where svc.used_flag='used' and  svc.code LIKE '%$coupon_id%'";
	//where svc.used_flag='used
		 
	 }
	 
	elseif($datepicker!='')
     {
		 
	$sqltech.="  where svc.used_flag='used' and svc.valid_until='$datepicker'";	

	 }
	 elseif($spname!='')
     {
		 
	$sqltech.=" where svc.used_flag='used'  and sp.sp_company LIKE'%$spname%'";	

	 }
	 elseif($datepicker!='' && $coupon_id!='')
     {
		 
	$sqltech.=" where svc.used_flag='used'  and svc.code LIKE '%$coupon_id%'and svc.valid_until='$datepicker'";	

	 }
	 elseif($uname!='' && $spname!='')
     {
		 
	$sqltech.=" where svc.used_flag='used'  and t.t_complete_name LIKE '%$uname%'and sp.sp_company LIKE'%$spname%'";	

	 }
	 elseif($uname!='' && $spname!='')
     {
		 
	$sqltech.=" where svc.used_flag='used'  and t.t_complete_name LIKE '%$uname%'and sp.sp_company LIKE'%$spname%'";	

	 }
	 elseif($coupon_id!='' && $uname!='')
     {
		 
	$sqltech.=" where svc.used_flag='used' and svc.code LIKE '%$coupon_id%' and t.t_complete_name LIKE '%$uname%'";	

	 }
	 elseif($datepicker!='' && $uname!=''&& $coupon_id!='')
     {
		 
	$sqltech.=" where svc.used_flag='used' and svc.code LIKE '%$coupon_id%' and t.t_complete_name LIKE '%$uname%' and svc.valid_until='$datepicker'";	

	 }
	 elseif($spname!='' && $uname!=''&& $coupon_id!='')
     {
		 
	$sqltech.=" where svc.used_flag='used' and svc.code LIKE '%$coupon_id%' and t.t_complete_name LIKE '%$uname%' and sp.sp_company LIKE'%$spname%'";	

	 }
	 elseif($datepicker!='' && $uname!=''&& $spname!='')
     {
		 
	$sqltech.=" where svc.used_flag='used' and svc.valid_until='$datepicker' and t.t_complete_name LIKE '%$uname%' and sp.sp_company LIKE'%$spname%'";	

	 }
	 
	 elseif($uname!='')
	 {	 
	$sqltech.=" where svc.used_flag='used' and t.t_complete_name LIKE '%$uname%'";
	
		  
		 
	 }
	 elseif($datepicker!='' && $coupon_id!='' && $uname!='' && $spname!='' )
	 {	 
	$sqltech.=" where svc.used_flag='used' and svc.valid_until='$datepicker' and t.t_complete_name LIKE '%$uname%' and sp.sp_company LIKE'%$spname%' and svc.code LIKE '%$coupon_id%'";	
}
	 
   // $row=mysql_query($sqltech);
    }
	
   else
	{
		
	//sqltech="select * from tbl_coupons where status='p' or status='no'";
		$sqltech="select svc.code,svc.entity_id,svc.used_flag,svc.coupon_id,sp.sp_company,svc.school_id,svc.sponsor_id,svc.for_points,svc.valid_until,t.id,t.t_complete_name from tbl_selected_vendor_coupons svc join tbl_teacher t join tbl_sponsorer sp on t.id=svc.user_id and svc.sponsor_id=sp.id where svc.used_flag='used' order by id DESC";


	}
	//echo $sqltech;
$row =mysql_query($sqltech);
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
<h1><center>Used  Vendor Coupon Log  For Teacher </center></h1>
		  <div class="row">
		   <form method="post">
			<div class="col-sm-2" style="background-color:lavender;">From <input type="text" id="datepicker" name="datepicker"  value="<?php if (isset($_POST['datepicker'])) {echo $_POST['datepicker'];} ?>" class="form-control">
		</div>
		<!-- Camel casing for placeholders Coupon ID, User Name & Sponsor Name done by Pranali -->
			<div class="col-sm-2" style="background-color:lavender;">Coupon ID<input type="text" id="coupon_id" name="coupon_id" value="<?php if (isset($_POST['coupon_id'])) {echo $_POST['coupon_id'];} ?>" placeholder="Coupon ID" class="form-control" >
		</div>
		 <div class="col-sm-2" style="background-color:lavender;">User Name<input type="text" id="uname" name="uname" value="<?php if (isset($_POST['uname'])) {echo $_POST['uname'];} ?>"placeholder="User Name" class="form-control">
		</div>
				 <div class="col-sm-3" style="background-color:lavender;">Sponsor Name<input type="text" id="spname" name="spname" value="<?php if (isset($_POST['spname'])) {echo $_POST['spname'];} ?>"placeholder="Sponsor Name" class="form-control">
		</div>
		 <div class="col-sm-2" style=" ">
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
		<th>Status</th>
		<th>Sponsor Name</th>
		<th>Point</th>
		<th>Validity Date</th>
		
		

		</tr>
		</thead>
	<tbody>
     <?php
	 $i = 1;
       while ($result = mysql_fetch_array($row)){
		
		//$compname=$result['t_complete_name'];	
		//$name=$result['t_name'];
		//$middlename=$result['t_middlename'];
		//$lastname=$result['t_lastname'];
		
		//if($compname=='')
		//{
		//$finalname=$name."".$middlename."".$lastname;
		//}
		//else
		//{
			//$finalname=$result['t_complete_name'];
		//}
     ?>
			<tr>
			<td data-title="id"><?php echo $i; ?></td>
			<td data-title="Couponid"><?php echo $result['code']; ?></td>

			<td>
			<?php echo "Teacher";?>
			</td>
				
			<td><?php echo $result['t_complete_name']; ?></td>
			<td><?php echo $result['used_flag']; ?></td>
			<td><?php echo $result['sp_company']; ?></td>
			<td><?php echo $result['for_points']; ?></td>
			
			
             <td><?php echo $result['valid_until']; ?></td>



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