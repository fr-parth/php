<?php
/*Author: Pranali Dalvi (PHP Developer)
Date : 11-05-20
This file was created for displaying gaming point log in School Admin 
*/
include("scadmin_header.php");
 //error_reporting(E_ALL);
$id=$_SESSION['id'];
$school_id=$_SESSION['school_id'];
//$webpagelimit = 10;

function game_log($url,$data){
	$ch = curl_init($url);
	$data_string = json_encode($data);      
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);  
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);      
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data_string)));
	$result = json_decode(curl_exec($ch),true);
	return $result;
}

if (!($_GET['Search'])){

	if (isset($_GET["page"])){ $page  = mysql_real_escape_string($_GET["page"]); } else { $page=1; };  
	$start_from = ($page-1) * $webpagelimit;

	$data = array("SchoolID"=>$school_id, "Offset"=>$start_from, "Limit"=>$webpagelimit);
	$url = $GLOBALS['URLNAME'].'/core/Version5/Gaming_Point_Log.php';
	
	$result = game_log($url,$data); //for pagewise records
	
	$total_records = $result['total_count'];
	$total_pages = ceil($total_records / $webpagelimit);

	if($total_pages == $_GET['page']){
		$webpagelimit = $total_records;
	}
	else{
		$webpagelimit = $start_from + $webpagelimit;
	}
}
else
{
	if (isset($_GET["spage"])){ 
		$spage  = mysql_real_escape_string($_GET["spage"]);
	} 
	else{
		$spage=1; 
	};  
	$start_from = ($spage-1) * $webpagelimit;

	$searchq=mysql_real_escape_string($_GET['Search']);
	$colname=mysql_real_escape_string($_GET['colname']); 

	$data = array("SchoolID"=>$school_id, "Offset"=>$start_from, "Limit"=>$webpagelimit, "Search_Key"=>$colname, "Search"=>$searchq);
	
	$url = $GLOBALS['URLNAME'].'/core/Version5/Gaming_Point_Log.php';
	
	$result = game_log($url,$data); //for pagewise records
	// print_r($result);die;
	$total_records = $result['total_count']; 
	$total_pages = ceil($total_records / $webpagelimit);

	if($total_pages == $_GET['spage']){
		$webpagelimit = $total_records;
	}
	else{
		$webpagelimit = $start_from + $webpagelimit;
	}

}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta charset="utf-8">
	<title>Smart Cookies</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
	<script>
		$(document).ready(function() {
			$('#example').dataTable( {
				"paging":   false,
				"info":false,
				"searching": false
			} );
		} );
	</script>
	<?php if (!($_GET['Search'])){?>
		<script type="text/javascript">
			$(function () {
				var total_pages = <?php echo $total_pages; ?> ;
				var start_page = <?php echo $page; ?> ;
				window.pagObj = $('#pagination').twbsPagination({
					totalPages: total_pages,
					visiblePages: 10,
					startPage: start_page,
					onPageClick: function (event, page) {
						console.info(page + ' (from options)'); 
					}
				}).on('page', function (event, page) {
					console.info(page + '(from event listening)');
					window.location.assign('gaming_point_log.php?page='+page);
				});
			});
		</script>
	<?php }else{
		?>
		<script type="text/javascript">
			$(function () {
				var total_pages = <?php echo $total_pages; ?> ;
				var start_page = <?php echo $spage; ?> ;
				window.pagObj = $('#pagination').twbsPagination({
					totalPages: total_pages,
					visiblePages: 10,
					startPage: start_page,
					onPageClick: function (event, page) {
						console.info(page + ' (from options)'); 
					}
				}).on('page', function (event, page) {
					console.info(page + '(from event listening)');
					window.location.assign('gaming_point_log.php?colname=<?php echo $colname;?>&Search=<?php echo $searchq; ?>&spage='+page);
				});
			});
		</script>
	<?php }?>
	<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/jquery.twbsPagination.js" type="text/javascript"></script>
	<script src="js/jquery.dataTables.min.js"></script>
	<style>
		/*input[type="submit"]
		{

			background-color: #FFFFFF;
			width:250px;
			height:45px;
			border-radius: 5px;
			font-size: 17px;
			box-shadow:0px 0px 2px 3px #FFCC33;
			background: linear-gradient(#FFF,#CCC);
			}*/
			@media only screen AND (max-width: 800px) {

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

				#no-more-tables tr { border: 1px solid #ccc; }

				#no-more-tables td { 
					/* Behave  like a "row" */
					border: none;
					border-bottom: 1px solid #eee; 
					position: relative;
					padding-left: 50%; 
					white-space: normal;
					text-align:left;
					font:Arial, Helvetica, sans-serif;
				}

				#no-more-tables td:before { 
					/* Now like a table header */
					position: absolute;
					/* Top/left values mimic padding */
					top: 6px;
					left: 6px;
					width: 45%; 
					padding-right: 10px; 
					white-space: nowrap;
					text-align:left;

				}

	/*
	Label the data
	*/
	#no-more-tables td:before { content: attr(data-title); }
}
</style>

</head>

<body>
	<div style="bgcolor:#CCCCCC">
		<div class="" style="padding:30px;" >
			<div style="border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">
				<div style="background-color:#F8F8F8 ;">
					<div class="row">
						<div class="col-md-0 "  style="color:#700000 ;padding:5px;" >&nbsp;&nbsp;&nbsp;&nbsp;
							<!-- <a href="Add_degree.php"> <input type="submit" class="btn btn-primary" name="submit" value="Add Degree" style="font-weight:bold;font-size:14px;"/></a>      -->
						</div>
						<div class="col-md-10 " align="center"  >
							<div style="font-size:34px;">Gaming Point Log </div>

							<div style="height:20px;"></div>

							<div class='row'>
								<form style="margin-top:5px;">
									<div class="col-md-4" style="width:17%;">
									</div>
									<div class="col-md-2" style="font-weight:bold; margin-right:-36px;">Search By
									</div>      

									<div class="col-md-2" style="width:17%;">
										<select name="colname" class="form-control">
											<option selected="selected">Select</option>
											<option value="game_name"
											<?php if (($_GET['colname']) == "game_name") {
												echo $_GET['colname']; ?> selected="selected" <?php } ?>>Game Name</option>
												<option value="user_name_game"
												<?php if (($_GET['colname']) == "user_name_game") {
													echo $_GET['colname']; ?> selected="selected" <?php } ?>>Player Name</option>                     			
												</select>
											</div>

											<div class="col-md-2" style="width:17%;">
												<input type="text" class="form-control" name="Search" value="<?php echo $searchq; ?>" placeholder="Search.." required autocomplete="off"> 
											</div>
											<div class="col-md-1" >
												<button type="submit" value="Search" class="btn btn-primary">Search</button>
											</div>
											<div class="col-md-1" >
												<input type="button" class="btn btn-info" value="Reset" onclick="window.open('gaming_point_log.php','_self')" />
											</div>
											
										</form>
									</div>  
									
								</div>
							</div>

							<?php
							if (isset($_GET['Search']))
							{					
								if($result['total_count'] == 0)
								{
									echo "<script>$('#show').css('display','none');</script><div style='margin-top:20px;' align='center'><font color='Red'><b>There Was No Search Result</b></font></div>";	
								}
								else
								{
									?>
									<div class="row" style="padding:10px;">
										<div id="no-more-tables" class="col-md-12  ">


											<table id="example" class="display" width="100%" cellspacing="0">

												<thead>
													<tr>
														<th>Sr. No.</th>
														<th> Game ID</th>
														<th> Game Name</th>
														<th> Player Name</th>
														<th>Member ID</th>
														<th> Kills</th>
														<th> Levels </th>
														<th> Points</th>
														<th> Image </th>
														<th> Date Time</th>
														
													</tr>
												</thead>
												<tbody>
													<?php 
													$i = ($start_from +1);

													foreach ($result as $res1)  
													{
														foreach ($res1 as $res)
														{                        

															?>
<tr>
	<td data-title="Sr.No."><?php echo $i;?></td>
	<td data-title="game_id"><?php echo $res['game_id'] ?></td>
	<td data-title="game_name"><?php echo ucwords($res['game_name']) ?></td>
	<td data-title="player_name"><?php echo ucwords($res['user_name_game']) ?> </td>	
	<td data-title="member_id"><?php echo $res['sc_member_id'] ?></td>
	<td data-title="end_time"><?php echo $res['kills'] ?></td>
	<td data-title="levels"><?php echo $res['levels'] ?></td>
	<td data-title="no_of_points"><?php echo $res['no_of_points'] ?> </td>
	<td data-title="Image">
		<?php $img = $GLOBALS['URLNAME']."/core/".$res['image_name']; ?>
		<img src="<?php echo $img ?>" width="70" height="80">
	</td>
	<td data-title="start_time"><?php echo $res['update_date'] ?></td>
	
</tr>
															<?php
															$i++;
														}
													}
													?>
												</tbody>
											</table>
										</div>
									</div>
									<div id="show" >
										<?php if (!($_GET['Search']))
										{
											if ($webpagelimit >$total_records){ $webpagelimit=$total_records;}
											echo "<div style='margin-top:5px;'><font color='blue'><b style='margin-left:18px;'>Now showing ".($start_from +1)." to ".($webpagelimit)." records out of ".$total_records. " records.</b></font></div>";
										}else
										{
											if ($webpagelimit >$total_records){ $webpagelimit=$total_records;}
											echo "<div style='margin-top:5px;'><font color='blue'><b style='margin-left:18px;'>Now showing ".($start_from +1)." to ".($webpagelimit)." records out of ".($total_records). " records.</b></font></div>";
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
							}


							else
							{
								?>

								<div class="row" style="padding:10px;" >
									<div class="col-md-12  " id="no-more-tables" >
										<table id="example" class="display" width="100%" cellspacing="0">

											<thead>
												<tr>
													<th>Sr. No.</th>
													<th> Game ID</th>
													<th> Game Name</th>
													<th> Player Name</th>
													<th>Member ID</th>
													<th> Kills</th>
													<th> Levels </th>
													<th> Points</th>
													<th> Image </th>
													<th> Date Time</th>
													

												</tr>
											</thead>
											<tbody>
												<?php 

												$i = ($start_from +1);

												foreach ($result as $res1)  
												{
													foreach ($res1 as $res)
													{ 
														?>
														<tr>
															<td data-title="Sr.No."><?php echo $i;?></td>
															<td data-title="game_id"><?php echo $res['game_id'] ?></td>
															<td data-title="game_name"><?php echo ucwords($res['game_name']) ?></td>
															<td data-title="player_name"><?php echo ucwords($res['user_name_game']) ?> </td>	
															<td data-title="member_id"><?php echo $res['sc_member_id'] ?></td>
															<td data-title="end_time"><?php echo $res['kills'] ?></td>
															<td data-title="levels"><?php echo $res['levels'] ?></td>
															<td data-title="no_of_points"><?php echo $res['no_of_points'] ?> </td>
															<td data-title="Image">
																<?php $img = $GLOBALS['URLNAME']."/core/".$res['image_name']; ?>
																<img src="<?php echo $img ?>" width="70" height="80">
															</td>
															<td data-title="start_time"><?php echo $res['update_date'] ?></td>
															

														</tr>
														<?php
														$i++;
													}
												}
												?>
											</tbody>
										</table>
									</div>
								</div>
								<div id="show"  align='left'>
									<?php if (!($_GET['Search']))
									{
										if ($webpagelimit >$total_records){ $webpagelimit=$total_records;}

										echo "<div style='margin-top:5px;'><font color='blue'><b style='margin-left:18px;'>Now showing ".($start_from +1)." to ".($webpagelimit)." records out of ".$total_records. " records.</b></font></div>";
									}else
									{
										if ($webpagelimit >$total_records){ $webpagelimit=$total_records;}
										echo "<div style='margin-top:5px;'><font color='blue'><b style='margin-left:18px;'>Now showing ".($start_from +1)." to ".($webpagelimit)." records out of ".($total_records). " records.</b></font></div>";
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
							?>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
