<?php
error_reporting(0);
include('scadmin_header.php');

ob_start();
 $index_url=$GLOBALS['URLNAME'];
$results = $smartcookie->retrive_individual($table, $fields);
$result = mysql_fetch_array($results);
$school_id = $result['school_id'];
$from=$_GET['from'];
$to=$_GET['to'];

ob_start();
	

if (!($_GET['Search'])) {

	if (isset($_GET["page"])) {
		$page  = mysql_real_escape_string($_GET["page"]);
	} else {
		$page = 1;
	};
	$start_from = ($page - 1) * $webpagelimit;
	//$dynamic_school_admin added by Sayali Balkawade for SMC-4254 on 11/12/2019
	$sql = mysql_query("SELECT distinct(st.school_id),st.std_complete_name,p.user_id,p.school_id ,p.date,s.rewardType FROM purcheseSoftreward 
	as p 
	inner join softreward as s on p.reward_id=s.softrewardId 
	 inner join tbl_student st on (st.std_PRN=p.user_id and p.school_id=st.school_id)
	where (p.date BETWEEN '$from' AND '$to') and (userType='Student') and  (st.school_id='$school_id')
	LIMIT $start_from, $webpagelimit");	
	
    $sql1 = mysql_query("SELECT count(distinct(st.std_complete_name)),st.school_id,p.date,p.user_id,p.school_id ,s.rewardType FROM purcheseSoftreward 
	as p 
	inner join softreward as s on p.reward_id=s.softrewardId 
	 inner join tbl_student st on (st.std_PRN=p.user_id and p.school_id=st.school_id)
	where (p.date BETWEEN '$from' AND '$to') and (userType='Student') and  (st.school_id='$school_id') ");

$rs_result = mysql_query($sql1);  
$row1 = mysql_fetch_row($rs_result);  
$total_records = $row1[0];  
$total_pages = ceil($total_records / $webpagelimit);
	if ($total_pages == $_GET['page']) {
		$webpagelimit = $total_records;
	} else {
		$webpagelimit = $start_from + $webpagelimit;
	}
} else {
	if (isset($_GET["spage"])) {
		$spage  = mysql_real_escape_string($_GET["spage"]);
	} else {
		$spage = 1;
	};
	$start_from = ($spage - 1) * $webpagelimit;

	$searchq = mysql_real_escape_string($_GET['Search']);
	//$colname=mysql_real_escape_string($_GET['colname']);

	if($searchq !='')

	//if ($colname != ''and $colname != 'Select')
	{
		$query1=mysql_query("SELECT distinct(st.std_complete_name),st.school_id,p.date,p.user_id,p.school_id ,s.rewardType FROM purcheseSoftreward 
as p 
inner join softreward as s on p.reward_id=s.softrewardId 
 inner join tbl_student st on(st.std_PRN=p.user_id and p.school_id=st.school_id)
where (p.date BETWEEN '$from' AND '$to') and  (userType='Student') and  (st.school_id='$school_id')
 and
 
            (st.std_complete_name LIKE '%$searchq%' or 
			p.school_id like '%$searchq%'  or 
			s.rewardType LIKE '%$searchq%'or 
			p.user_id LIKE '%$searchq%' or 
			p.date LIKE '%$searchq%')					
			  
			LIMIT $start_from, $webpagelimit") 
			or die("could not Search!");
			
			$sql1 ="SELECT count(distinct(st.std_complete_name)),st.school_id,p.date,p.user_id,p.school_id ,s.rewardType FROM purcheseSoftreward 
as p 
inner join softreward as s on p.reward_id=s.softrewardId 
 inner join tbl_student st on (st.std_PRN=p.user_id and p.school_id=st.school_id)
where (p.date BETWEEN '$from' AND '$to') and (userType='Student') and  (st.school_id='$school_id')
 and 
           (st.std_complete_name LIKE '%$searchq%' or 
			p.school_id like '%$searchq%'  or 
			s.rewardType LIKE '%$searchq%'or 
			p.user_id LIKE '%$searchq%' or 
			p.date LIKE '%$searchq%')					
			 "; 

			$rs_result = mysql_query($sql1);  
					$row1 = mysql_fetch_row($rs_result);  
				    $total_records = $row1[0];  
					$total_pages = ceil($total_records / $webpagelimit);

	}else{
			

			$query1=mysql_query("SELECT distinct(st.std_complete_name),st.school_id,p.date,p.user_id,p.school_id ,s.rewardType FROM purcheseSoftreward 
as p 
inner join softreward as s on p.reward_id=s.softrewardId 
 inner join tbl_student st on(st.std_PRN=p.user_id and p.school_id=st.school_id)
where (p.date BETWEEN '$from' AND '$to') and (userType='Student') and  (st.school_id='$school_id')
 and 
     ('$colname' LIKE '%$searchq%')  LIMIT $start_from, $webpagelimit") 
		or die("could not Search!");
					//echo $query1;
		
		$sql1 ="SELECT count(distinct(st.std_complete_name)),st.school_id,p.date,p.user_id,p.school_id ,s.rewardType FROM purcheseSoftreward 
as p 
inner join softreward as s on p.reward_id=s.softrewardId 
 inner join tbl_student st on (st.std_PRN=p.user_id and p.school_id=st.school_id)
where (p.date BETWEEN '$from' AND '$to') and (userType='Student') and  (st.school_id='$school_id')
 and 
     ('$colname' LIKE '%$searchq%') "; 
					$rs_result = mysql_query($sql1);  
					$row1 = mysql_fetch_row($rs_result);  
					$total_records = $row1[0];  
					$total_pages = ceil($total_records / $webpagelimit);
		}

	//below query use for search count

	if ($total_pages == $_GET['spage']) {
		$webpagelimit = $total_records;
	} else {
		$webpagelimit = $start_from + $webpagelimit;
	}
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta charset="utf-8">
	<title>Sponsor Information</title>
	<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
	<script src="code.jquery.com/jquery-1.10.2.js"></script>
	<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/jquery.dataTables.min.js"></script>

	<script src="code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
	<script src="js/jquery.twbsPagination.js" type="text/javascript"></script>
	<script>
		$(document).ready(function() {
			$('#example').dataTable({
				"paging": false,
				"info": false,
				"searching": true,
				"scrollCollapse": true,
				"scrollX": true
			});
		});
	</script>
	<?php if (!($_GET['Search'])) { ?>
		<script type="text/javascript">
			$(function() {
				var total_pages = <?php echo $total_pages; ?>;
				var start_page = <?php echo $page; ?>;
				window.pagObj = $('#pagination').twbsPagination({
					totalPages: total_pages,
					visiblePages: 10,
					startPage: start_page,
					onPageClick: function(event, page) {
						console.info(page + ' (from options)');
					}
				}).on('page', function(event, page) {
					console.info(page + '(from event listening)');
					window.location.assign('soft_reward_student_stat.php?from=<?php echo $from; ?>&to=<?php echo $to; ?>&page='+page);
				});
			});
		</script>
	<?php } else {
	?>
		<script type="text/javascript">
			$(function() {
				var total_pages = <?php echo $total_pages; ?>;
				var start_page = <?php echo $spage; ?>;
				window.pagObj = $('#pagination').twbsPagination({
					totalPages: total_pages,
					visiblePages: 10,
					startPage: start_page,
					onPageClick: function(event, page) {
						console.info(page + ' (from options)');
					}
				}).on('page', function(event, page) {
					console.info(page + '(from event listening)');
					window.location.assign('soft_reward_student_stat.php?Search=<?php echo $searchq; ?>&spage='+page);
				});
			});
		</script>
	<?php } ?>
	<style>
		@media only screen and (max-width: 800px) {

			/* Force table to not be like tables anymore */
			#no-more-tables table,
			#no-more-tables thead,
			#no-more-tables tbody,
			#no-more-tables th,
			#no-more-tables td,
			#no-more-tables tr {
				display: block;
			}

			/* Hide table headers (but not display: none;, for accessibility) */
			#no-more-tables thead tr {
				position: absolute;
				top: -9999px;
				left: -9999px;
			}

			#no-more-tables tr {
				border: 1px solid #ccc;
			}

			#no-more-tables td {
				/* Behave  like a "row" */
				border: none;
				border-bottom: 1px solid #eee;
				position: relative;
				padding-left: 50%;
				white-space: normal;
				text-align: left;
				font: Arial, Helvetica, sans-serif;
			}

			#no-more-tables td:before {
				/* Now like a table header */
				position: absolute;
				/* Top/left values mimic padding */
				top: 6px;
				left: 6px;

				padding-right: 10px;
				white-space: nowrap;


			}

			/*
	Label the data
	*/
			#no-more-tables td:before {
				content: attr(data-title);
			}
		}
	</style>
</head>


<body bgcolor="#CCCCCC">

	<div align="center">
		<div class="container" style="width:100%;">
			<div style="padding-top:30px;">
				<!-- added comment by Chaitali for SMC-5180 on 25/02/2021 -->
				<!-- $dynamic_school_admin added by Sayali Balkawade for SMC-4254 on 11/12/2019 -->
				<h2 style="padding-left:20px; margin-top:2px;color:#666">Soft Reward Purchased By <?php echo$dynamic_student;?></h2>

			</div>
			<div class='row'>
				<form style="margin-top:5px;">
					<div class="col-md-4" style="width:17%;">
					</div>

					<!--<div class="col-md-2" style="width:17%;margin-left:200px; ">
				<input type="text" class="form-control" name="Search" value="<?php echo $searchq; ?>" placeholder="Search.." > 
			</div>
			<div class="col-md-1" >
			<button type="submit" value="Search" class="btn btn-primary">Search</button>
			</div>
			<div class="col-md-1" >
			<input type="button" class="btn btn-info" value="Reset" onclick="window.open('green_point_distributed_by_cookieadmin.php','_self')" />
			</div>
					 <div style="margin-left: 800px;">
						<input type="text" name="Search" value="<?php echo $searchq; ?>" placeholder="Search..">
						<input type="submit" value="Search">
						<input type="button" value="Reset" onclick="window.open('soft_reward_student_stat.php','_self')" />
					</div> -->
				</form>
			</div>




			<div class="row">

				<div class="col-md-2" style="padding-right: 0px; padding-left: 0px;">
				</div>

				<?php
				if (isset($_GET['Search'])) {

					$count = mysql_num_rows($sql);
					if ($count == 0) {

						echo "<script>$('#show').css('display','none');</script><div style='margin-top:20px;' align='center'><font color='Red'><b>There Was No Search Result</b></font></div>";
					} else {
				?>

						<div id="no-more-tables" style="padding-top:20px;">

							<table id="example" class="col-md-12 table-bordered " align="center">
								<thead>
									<!-- <tr><?php echo $sql1; ?></tr> -->
									<tr style="background-color:#0073BD; color:#FFFFFF; height:30px;">

									<th>Sr.No.</th>
		<th><?php echo$dynamic_student;?> Name</th>
		<th>Member ID</th>
		<th>Reward Type</th>

		<th><?php echo $organization;?> ID</th>
					<th>Purchase Date</th>

									</tr>
								</thead>
								<tbody>
									<?php

									$i = 1;
									$i = ($start_from + 1); ?>
									<?php
									 while($result = mysql_fetch_array($query1)) {
									?>

<td data-title="Sr.No."><?php echo $i; ?></td>
                        
                        <td data-title="<?php echo$dynamic_student;?> Name"><?php echo $result['std_complete_name'];?></td>
					    <td data-title="Member ID"><?php echo $result['user_id']; ?></td>
                        <td data-title="Reward Type"><?php echo $result['rewardType']; ?></td>
                        <td data-title="<?php echo $organization;?> ID"><?php echo $result['school_id']; ?></td>
						
						 <td data-title="Purchase Date"><?php echo $result['date']; ?></td>
										</tr>
										<?php $i++; ?>
									<?php } ?>

								</tbody>
							</table>
						</div>
						<div align=left>
							<?php if (!($_GET['Search'])) {
								if ($webpagelimit > $total_records) {
									$webpagelimit = $total_records;
								}
								echo "<div style='margin-top:5px;margin-left:30px;'><font color='#0073BD'><style='margin-left:600px;'>Now showing " . ($start_from + 1) . " to " . ($webpagelimit) . " records out of " . $total_records . " records.</font></style></div>";
							} else {
								if ($webpagelimit > $total_records) {
									$webpagelimit = $total_records;
								}
								echo "<div style='margin-top:5px;margin-left:30px;'><font color='#0073BD'><style='margin-left:600px;'>Now showing " . ($start_from + 1) . " to " . ($webpagelimit) . " records out of " . ($total_records) . " records.</font></style></div>";
							}
							?>
						</div>
						<div class="container" align="center">
							<nav aria-label="Page navigation">
								<ul class="pagination" id="pagination"></ul>
							</nav>
						</div>
					<?php
					}
				} else {
					?>

					<div id="no-more-tables" class="col-md-12 table-responsive" style="padding-top:20px;">
						<table id="example" class="table table-bordered">
						<thead>

<tr style="background-color:#0073BD; color:#FFFFFF;height:30px; width:1147px">
	<!-- <tr><?php echo $sq1; ?></tr> -->
    <th>Sr. No.</th>                        
	<th><?php echo$dynamic_student;?> Name</th>
		<th>Member ID</th>
		<th>Reward Type</th>
		<th><?php echo $organization;?> ID</th>
					<th>Purchase Date</th>

</tr>
</thead>
							<tbody>
								<?php

								$i = 1;
								$i = ($start_from + 1); ?>
								<?php
							 while($result = mysql_fetch_array($sql)){
								?> 
                                
                        <td data-title="Sr.No."><?php echo $i; ?></td>
                        
                        <td data-title="<?php echo$dynamic_student;?> Name"><?php echo $result['std_complete_name'];?></td>
					    <td data-title="Member ID"><?php echo $result['user_id']; ?></td>
                        <td data-title="Reward Type"><?php echo $result['rewardType']; ?></td>
                        <td data-title="<?php echo $organization;?> ID"><?php echo $result['school_id']; ?></td>
					 <td data-title="Purchase Date"><?php echo $result['date']; ?></td>
            

									</tr>
									<?php $i++; ?>
								<?php } ?>
							</tbody>
						</table>
					</div>


					<div align=left>
						<?php if (!($_GET['Search'])) {
							if ($webpagelimit > $total_records) {
								$webpagelimit = $total_records;
							}
							echo "<div style='margin-top:5px;margin-left:30px;'><font color='#0073BD'><style='margin-left:600px;'>Now showing " . ($start_from + 1) . " to " . ($webpagelimit) . " records out of " . $total_records . " records.</font></style></div>";
						} else {
							if ($webpagelimit > $total_records) {
								$webpagelimit = $total_records;
							}
							echo "<div style='margin-top:5px;margin-left:30px;'><font color='#0073BD'><style='margin-left:600px;'>Now showing " . ($start_from + 1) . " to " . ($webpagelimit) . " records out of " . ($total_records) . " records.</font></style></div>";
						}
						?>
					</div>
					<div class="container" align="center">
						<nav aria-label="Page navigation">
							<ul class="pagination" id="pagination"></ul>
						</nav>
					</div>
				<?php } ?>


			</div>
			<!--changes end -->

			<div class="row" style="padding:5px;">
				<div class="col-md-4">
				</div>
				<div class="col-md-3 " align="center">


				</div>
			</div>
			<div class="row">
				<div class="col-md-4">
				</div>
				<div class="col-md-3" style="color:#FF0000;" align="center">

					<?php echo $report; ?>
				</div>

			</div>
		</div>
	</div>
</body>

</html>