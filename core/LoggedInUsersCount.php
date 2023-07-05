<?php
include('cookieadminheader.php');
$otot1=mysql_query("SELECT count(RowID)as overalluser FROM `tbl_LoginStatus`");
$otot=mysql_fetch_array($otot1);

$otype1=mysql_query("SELECT e.sc_entities,count(RowID)as oluser FROM `tbl_LoginStatus` l LEFT JOIN tbl_entites e ON l.Entity_type=e.sc_id GROUP BY l.Entity_type");



$ttot1=mysql_query("SELECT count(RowID)as todaysuser FROM `tbl_LoginStatus` WHERE DATE(LatestLoginTime)=CURDATE()");
$ttot=mysql_fetch_array($ttot1);



$ttype1=mysql_query("SELECT e.sc_entities,count(RowID)as tluser FROM `tbl_LoginStatus` l LEFT JOIN tbl_entites e ON l.Entity_type=e.sc_id WHERE DATE(LatestLoginTime)=CURDATE() GROUP BY l.Entity_type");

?>

<style>
.panel-primary{
	background-color:#694489;
	
}
</style>

<div class="container" style="padding-top:10px;">  
  
  <div class="row">
		<div class="col-md-12">
			<div class="panel panel-primary ">
				<div class="panel-heading clr">Logged In Users Today<span class='badge'><?php echo $ttot['todaysuser'];?></span></div>
			
			</div>
		</div>
</div>


<div class="row">
<?php
while($ttype=mysql_fetch_array($ttype1)){

echo "
<div class='col-md-2'>
	<div class='panel panel-default'>
		<div class='panel-body  text-center'>
			<h1>".$ttype['tluser']."</h1>
		</div>
			<div class='panel-footer clr'>
				".$ttype['sc_entities']."
			</div>
	</div>
</div>";
}
?>
</div>

<div class="row">
		<div class="col-md-12">
			<div class="panel panel-primary">
				<div class="panel-heading clr">Logged In Users Till Today<span class='badge'><?php echo $otot['overalluser'];?></span></div>
			</div>
		</div>
</div>

	
<div class="row">
<?php

while($otype=mysql_fetch_array($otype1))
{
echo "
<div class='col-md-2'>
	<div class='panel panel-default'>
		<div class='panel-body  text-center'>
			<h1>".$otype['oluser']."</h1>
		</div>
			<div class='panel-footer clr'>
				".$otype['sc_entities']."
			</div>
	</div>
</div>";
}
?>

</div>
</div>	
</body>
</html>

