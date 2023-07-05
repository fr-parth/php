<?php

include("cookieadminheader.php");
//@include 'conn.php'; 

//total sponsors
$t=mysql_query("select count(1) as Total from tbl_sponsorer");
$total=mysql_fetch_array($t);
$total_sponsors=$total['Total'];

//Revenue Generated
$a=mysql_query("select sum(amount) as Amount from tbl_sponsorer");
$amt=mysql_fetch_array($a);
$amount=$amt['Amount'];

//Registered Sponsors by salespersons
$sr=mysql_query("select count(1) as salesperson_reg from tbl_sponsorer where sales_person_id!=0");
$srp=mysql_fetch_array($sr);
$salesperson_reg=$srp['salesperson_reg'];

//Suggested Sponsors
$vl=mysql_query("select count(1) as v_status from tbl_sponsorer where v_status='Inactive'");
$vli=mysql_fetch_array($vl);
$Suggested=$vli['v_status'];

//Registered Sponsors
$rs=mysql_query("select count(1) as v_likes from tbl_sponsorer where v_likes is null");
$rsp=mysql_fetch_array($rs);
$registered=$rsp['v_likes'];


//Free registrations by salesperson
$fr=mysql_query("select count(1) as free from tbl_sponsorer where sales_person_id!=0 and amount='Free Registration'");
$fre=mysql_fetch_array($fr);
$freeregsalesp=$fre['free'];

//active products
$ap=mysql_query("select count(1) as activeproducts from tbl_sponsored c join tbl_sponsorer sp on sp.id=c.sponsor_id where validity!='invalid'");
$app=mysql_fetch_array($ap);
$activeproducts=$app['activeproducts'];

//active sponsors
$asp=mysql_query("select distinct sponsor_id from tbl_sponsored c join tbl_sponsorer sp on sp.id=c.sponsor_id where validity!='invalid' group by sponsor_id");
$active_sponsors=mysql_num_rows($asp);


/* select sponsor_id,sp_company, count(1) as activesp from tbl_sponsored c join tbl_sponsorer sp on sp.id=c.sponsor_id where validity!='invalid' group by sponsor_id order by activesp desc limit 10 */




?>
<!--Start changes Added style in div and also add align and <b> for title by Dhanashri Tak -->
<!--Start Camel Case By Dhanashri Tak--->
	<div class='panel panel-info col-md-4' style="margin-left: 436px;">
	<table class='table'>
		<tr><td colspan='2' align="center"><h3><b>Sponsor Statistics</b></h3><td></tr>
		<tr><td>Total Sponsors</td><td><b><?php echo $total_sponsors; ?></b></td></tr>
		<tr><td>Registered Sponsors</td><td><b><?php echo $registered; ?></b></td></tr>
		<tr><td>Registered By Sales Persons</td><td><b><?php echo $salesperson_reg; ?></b></td></tr>
		<tr><td>Revenue Generated</td><td><b><?php echo $amount; ?></b></td></tr>
		<tr><td>Free Registrations By Sales Persons</td><td><b><?php echo $freeregsalesp; ?></b></td></tr>
		<tr><td>Suggested Sponsors</td><td><b><?php echo $Suggested; ?></b></td></tr>
		<tr><td>Active Products</td><td><b><?php echo $activeproducts; ?></b></td></tr>
		<tr><td>Active Sponsors</td><td><b><?php echo $active_sponsors; ?></b></td></tr>
	</table>
	</div>
<!--End-->
<!--End-->



