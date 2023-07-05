<html>
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>

<?php
include('conn.php');

$pufct=mysql_query("select sum(for_points)as pufbct from tbl_selected_vendor_coupons where used_flag='unused'") or die(mysql_error());
$a=mysql_fetch_array($pufct);	

$nost=mysql_query("select count(sp_date)as nostoday from tbl_sponsorer where sp_date=curdate()")or die(mysql_error());
$b=mysql_fetch_array($nost);


$nostsale=mysql_query("select count(v_status)as nostsalep from tbl_sponsorer where v_status='Active' AND sp_date=curdate() and sales_person_id!='0' ") or die(mysql_error());
$result1=mysql_fetch_array($nostsale);


$nostthem=mysql_query("select count(sp_date)as nosrbt from tbl_sponsorer where sp_date=curdate() AND sales_person_id='0' and v_status in('Active',NULL)")or die(mysql_error());
$result2=mysql_fetch_array($nostthem);

$nost1=mysql_query("select count(id)as norstt from tbl_sponsorer where v_status in('Active',NULL)") or die(mysql_error());
$c=mysql_fetch_array($nost1);



?>


<center>

<div class="container" style="padding-top:100px;">  
  
<div class="row">
	<div class="col-md-6">
		<div class="panel panel-primary">
			<div class="panel-heading"><h4>Points used for buying coupons today's <span class="badge pull-right"><?php echo "hello". $a['pufbct'];?></span></h4></div>
				
			</div>
	</div>
</div>


<div class="row">
	<div class="col-md-6">
		<div class="panel panel-primary">
			<div class="panel-heading"><h4>Number of sponsors registered today's <span class="badge pull-right"><?php echo $b['nostoday'];?></span></h4></div>
				
			</div>
	</div>
</div>


<div class="row">	
<div class='col-md-3'>
	<div class="panel panel-default">
			<div class="panel-footer">
				<h5>Number of sponsors registered todays by salesperson<?php echo $result1['nostsalep'];?></h5>
			</div>
	</div>
</div>
</div>
<div class="row">
<?php
while($sale=mysql_fetch_array($nosale))
{
echo "
<div class='col-md-2'>
	<div class='panel panel-default'>
		<div class='panel-body  text-center'>
			<h1>".$sale['nostsalep']."</h1>
		</div>			
	</div>
</div>";
}
?>
</div>

	<div class='col-md-3'>
	<div class="panel panel-default">
		<div class="panel-footer">
				<h5>Number of sponsors registered by themselves<?php echo $result2['nosrbt'];?></h5>
			</div>
	</div>
</div>

<div class="row">
<?php
while($them=mysql_fetch_array($nosthm))
{
echo "
<div class='col-md-2'>
	<div class='panel panel-default'>
		<div class='panel-body  text-center'>
			<h1>".$them['nosrbt']."</h1>
		</div>			
	</div>
</div>";
}
?>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="panel panel-primary">
			<div class="panel-heading"><h4>Number of sponsors registered till today's <span class="badge pull-right"><?php echo $c['norstt'];?></span></h4></div>
				</div>
	</div>
</div>

</div>
</center>
</body>
</html>