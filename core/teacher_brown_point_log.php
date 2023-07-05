<?php
/*Author: Pranali Dalvi (PHP Developer)
Date : 29-05-20
This file was created for displaying Teacher's brown point log in School Admin 
*/
include_once("scadmin_header.php");
 //error_reporting(E_ALL);
$id=$_SESSION['id'];
$school_id=$_SESSION['school_id'];
//$webpagelimit = 10;

if (!isset($_GET['submit'])) {
	
	if (isset($_GET["page"])){ $page  = mysql_real_escape_string($_GET["page"]); } else { $page=1; };  
	$start_from = ($page-1) * $webpagelimit;

	$result = mysql_query("SELECT sp.activity_type,s.id,sp.sc_teacher_id,sp.sc_entities_id,sp.sc_point,sp.reason,sp.point_date,sp.source,sp.category,sp.sub_category, (CASE WHEN s.t_complete_name!='' THEN s.t_complete_name
	ELSE CONCAT_WS(' ', s.t_name , s.t_middlename, s.t_lastname)    
    END) as teacher_name
	from tbl_teacher s
	join tbl_teacher_point sp
	ON s.t_id = sp.sc_teacher_id  AND  s.school_id = sp.school_id 
	where (sp.point_type='Brown' or sp.point_type='BrownPoints' or sp.point_type='Brown Points') and sp.school_id='$school_id' ORDER BY sp.id DESC LIMIT $start_from,$webpagelimit");
				
	$result1 = mysql_query("SELECT count(s.id) as cnt  
	from tbl_teacher s
	join tbl_teacher_point sp
	ON s.t_id = sp.sc_teacher_id  AND  s.school_id = sp.school_id 
	where (sp.point_type='Brown' or sp.point_type='BrownPoints' or sp.point_type='Brown Points') and sp.school_id='$school_id' ORDER BY sp.id DESC"); 

	$count_record = mysql_fetch_assoc($result1);
	$count = $count_record['cnt'];
	

	$total_records = $count;
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

	$searchq=trim(mysql_real_escape_string($_GET['Search']));
	$colname=trim(mysql_real_escape_string($_GET['colname'])); 
	$from_date2=trim(mysql_real_escape_string($_GET['from_date']));
	$to_date2=trim(mysql_real_escape_string($_GET['to_date']));
	$category=trim(mysql_real_escape_string($_GET['category'])); 
	$sub_category=trim(mysql_real_escape_string($_GET['sub_category']));
	$source=trim(mysql_real_escape_string($_GET['source']));  
	$reason=trim(mysql_real_escape_string($_GET['reason']));  
	$teacher_member_id=trim(mysql_real_escape_string($_GET['teacher_member_id'])); 
	$t_id=trim(mysql_real_escape_string($_GET['t_id']));  

	$from_date1=strtotime($from_date2);
	$to_date1=strtotime($to_date2);

  	$from_date = @date("Y-m-d", $from_date1 );
  	$from_date .= ' 00:00:00';

  	$to_date = @date("Y-m-d", $to_date1 );
	$to_date .=  ' 23:59:59';
	$arr = "SELECT sp.activity_type,s.id,sp.sc_teacher_id,sp.sc_entities_id,sp.sc_point,sp.reason,sp.point_date,sp.source,sp.category,sp.sub_category, (CASE WHEN s.t_complete_name!='' THEN s.t_complete_name
	ELSE CONCAT_WS(' ', s.t_name , s.t_middlename, s.t_lastname)    
    END) as teacher_name
	from tbl_teacher s
	join tbl_teacher_point sp
	ON s.t_id = sp.sc_teacher_id  AND  s.school_id = sp.school_id 
	where (sp.point_type='Brown' or sp.point_type='BrownPoints' or sp.point_type='Brown Points') and sp.school_id='$school_id' ";
	$cond='';
	if($colname!="Select"){
		$cond .= " AND sp.activity_type LIKE '%$colname%' ";
	}
	if($searchq!=''){
		$cond .= " AND s.t_complete_name LIKE '%$searchq%' ";
	}
	if($from_date!='1970-01-01 00:00:00' && $to_date!='1970-01-01 23:59:59'){
		$cond .= " AND sp.point_date BETWEEN '".$from_date."' AND '".$to_date."' ";
	}	
	if($source!=''){
		$cond .= " AND sp.source  LIKE '%$source%' ";
	}
	if($category!=''){
		$cond .= " AND sp.category LIKE '%$category%' ";
	}
	if($sub_category!=''){
		$cond .= " AND sp.sub_category LIKE '%$sub_category%' ";
	}	
	if($reason!=""){
		$cond .= " AND sp.reason LIKE '%$reason%' ";
	}
	if($teacher_member_id!=''){
		$cond .= " AND s.id  LIKE '%$teacher_member_id%' ";
	}	
	if($t_id!=""){
		$cond .= " AND sp.sc_teacher_id LIKE '%$t_id%' ";
	}

	$arr .= $cond." ORDER BY sp.id DESC LIMIT $start_from,$webpagelimit";	
	$result = mysql_query($arr); // limit

	$result1 = mysql_query("SELECT count(s.id) as cnt  
	from tbl_teacher s
	join tbl_teacher_point sp
	ON s.t_id = sp.sc_teacher_id  AND  s.school_id = sp.school_id 
	where (sp.point_type='Brown' or sp.point_type='BrownPoints' or sp.point_type='Brown Points') and sp.school_id='$school_id' $cond ORDER BY sp.id DESC"); 

	$count_record = mysql_fetch_assoc($result1);
	$count = $count_record['cnt'];

	$total_records = $count;
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
	<link rel="stylesheet" type="text/css" href="css/datepicker.min.css">
	<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css" rel="stylesheet" />
	<script>
		$(document).ready(function() {
			$('#example').dataTable( {
				"paging":   false,
				"info":false,
				"searching": false
			} );
		} );
	</script>
	<?php if (!isset($_GET['submit'])){?>
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
					window.location.assign('teacher_brown_point_log.php?page='+page);
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
					window.location.assign('teacher_brown_point_log.php?colname=<?php echo $colname;?>&Search=<?php echo $searchq; ?>&spage='+page+'&submit=<?php echo $_GET['submit']?>&from_date=<?php echo $from_date2; ?>&to_date=<?php echo $to_date2;?>&source=<?php echo $source; ?>&category=<?php echo $category; ?>&sub_category=<?php echo $sub_category; ?>&reason=<?php echo $reason; ?>&teacher_member_id=<?php echo $teacher_member_id; ?>&t_id=<?php echo $t_id; ?>');
				});
			});
		</script>
	<?php }?>
	
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

<script type="text/javascript">
function valid(){
  
  var from = document.getElementById("from_date").value;
  var myDate = new Date(from);
  var today = new Date();
                   
 
  if(myDate.getFullYear() > today.getFullYear()) {

        alert('Please select valid from date');
        return false;

  }
  else if(myDate.getFullYear() == today.getFullYear()) {

      if (myDate.getMonth() == today.getMonth()) {
                                
          if (myDate.getDate() > today.getDate()) {

              alert('Please select valid from date');
              return false;
          }                    
          
      }

  else if (myDate.getMonth() > today.getMonth()) {
      alert('Please select valid from date');
      return false;

  }                
          
  }          
          
  var to = document.getElementById("to_date").value;
  var myDate1 = new Date(to);
  var today1 = new Date();
                    
    
 
  if(myDate1.getFullYear() > today1.getFullYear()) {

         alert('Please select valid to date');
          return false;
      
    }
    else if(myDate1.getFullYear() == today1.getFullYear()) {

      if (myDate1.getMonth() == today1.getMonth()) {
                                
          if (myDate1.getDate() > today1.getDate()) {
          
            alert('Please select valid to date');
            return false;
        }
                                
        
    }

    else if(myDate1.getMonth() > today1.getMonth()) {
      alert('Please select valid to date');
      return false;

    }
                            
  }

    if(myDate.getFullYear() > myDate1.getFullYear())
    {
      alert('Start Date should be less than End Date');
      return false;
    }

    else if(myDate.getFullYear() == myDate1.getFullYear())
    {
        if(myDate.getMonth() == myDate1.getMonth()){

          if(myDate.getDate() > myDate1.getDate()) {

          alert('Start Date should be less than End Date');
          return false;
          }
          
        }
        else if (myDate.getMonth() > myDate1.getMonth()) {
          alert('Start Date should be less than End Date');
          return false;

        }
                            
    }
}
</script>
<body>
	<div>
		<div class="" style="padding:30px;" >
			<div style="border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">
				<div style="background-color:#F8F8F8 ;">
					<div class="row">
						<div class="col-md-0 "  style="color:#700000 ;padding:5px;" >&nbsp;&nbsp;&nbsp;&nbsp;
							<!-- <a href="Add_degree.php"> <input type="submit" class="btn btn-primary" name="submit" value="Add Degree" style="font-weight:bold;font-size:14px;"/></a>      -->
						</div>
						<div class="col-md-12 " align="center"  >
							<div style="font-size:34px;">Teacher Brown Point Log </div>

							
							<div class="row" style=
							"padding: 30px;">
								<form style="margin-top:2px;" action="">
								<div class="row">
    								<div class="form-group col-md-2">
									<label class='control-label' for='from_date' style="text-align:left;">From Date :</label>&nbsp;&nbsp;
										<input type="text" name="from_date" id="from_date" class="datepicker form-control" autocomplete="off" value="<?php echo $from_date2;?>" placeholder="From Date">&emsp;
								</div>

        						<div class="form-group col-md-2">
        								<label class='control-label' for='to_date' style="text-align:left;">To Date :</label>&emsp;<input name="to_date" id='to_date' value="<?php echo $to_date2;?>" class='datepicker form-control' autocomplete="off" placeholder="To Date">&emsp;
								</div>
								<div class="form-group col-md-4">
									<label class='control-label' for='colname' style="text-align:left;">Activity Type :</label>&emsp;
										<select name="colname" id="colname" class="searchselect form-control">
											<option selected="selected">Select</option>
											<?php
											$sql = mysql_query("SELECT * FROM referral_activity_reasons");
											while($row = mysql_fetch_array($sql)){  ?>
												 <option value="<?php echo $row['reason']?>"
											<?php if (($_GET['colname']) == $row['reason']) {
												echo $_GET['colname']; ?> selected="selected" <?php } ?>> <?php echo ucwords($row['reason'])?></option>
										<?php	}
										?>
											                     			
										</select>
								</div>
								 <div class="clear-fix"></div> 
								<div class="form-group col-md-4">
																													
									<label class='control-label' for='source' style="text-align:left;"> Source :</label>&emsp;
									<input type="text" class="form-control" name="source" id="source" value="<?php echo $source; ?>" placeholder="Search Source ..."  autocomplete="off">

								</div>
							</div>
							<div class="clear-fix" style="clear: both"></div>
							<div class="row">
								<div class="form-group col-md-3" style="">	
									&emsp;
									<label class='control-label' for='category' > Category :</label>&emsp;
									<input type="text" class="form-control" name="category" id="category" value="<?php echo $category; ?>" placeholder="Search Category ..."  autocomplete="off">
									
								</div>
								<div class="form-group col-md-3" style="">
									&emsp;
									<label class='control-label' for='sub_category' > Program Name :</label>&emsp;
									<input type="text" class="form-control" id="sub_category" name="sub_category" value="<?php echo $sub_category; ?>" placeholder="Search Program Name ..."  autocomplete="off">
								</div>
								<div class="form-group col-md-3">
										&emsp;
									<label class='control-label' for='reason'> Reason :</label>&emsp;
									<input type="text" class="form-control" name="reason" id="reason" value="<?php echo $reason; ?>" placeholder="Search Reason ..."  autocomplete="off">
								</div>
								<div class="form-group col-md-3">
									&emsp;
									<label class='control-label' for='teacher_member_id' > Teacher Member ID :</label>&emsp;
												<input type="text" class="form-control" name="teacher_member_id" id="teacher_member_id" value="<?php echo $teacher_member_id; ?>" placeholder="Search Teacher Member ID.."  autocomplete="off">
										
								</div>
							</div>
							<div class="clear-fix" style="clear: both"></div>
							<div class="row">
								<div class="form-group col-md-3">
										<label class='control-label' for='t_id' style="text-align:left;"> Teacher Employee ID :</label>&emsp;
												<input type="text" class="form-control" name="t_id" id="t_id" value="<?php echo $t_id; ?>" placeholder="Search Teacher Employee ID.."  autocomplete="off">
												&emsp;
								</div>
								<div class="form-group col-md-3">

											<label class='control-label' for='Search' style="text-align:left;"> Teacher Name :</label>&emsp;
												<input type="text" class="form-control" name="Search" id="Search" value="<?php echo $searchq; ?>" placeholder="Search Teacher Name.."  autocomplete="off">	 
											&emsp;
								</div>
							<div class="form-group col-md-3">
												<button type="submit" value="Search" name="submit" class="btn btn-primary" value="submit" onclick="return valid();" style="margin-top:27px;">Search</button>
								&nbsp;&nbsp;
								</div>
								<div class="form-group col-md-3">
												<input type="button" class="btn btn-info" value="Reset" onclick="window.open('teacher_brown_point_log.php','_self')" style="margin-top:27px;"/>
											
								</div>
								</div>
											
										</form>
									</div>  
									
								</div>
							</div>

							<?php
							if (isset($_GET['submit']))
							{					
								if($count == 0)
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
														<th>Member ID</th>
														<th> Teacher Name / Employee ID</th>
														<th>Activity Type</th>
														<th>Source</th>
														<th> Category</th>
														<th> Program Name </th>	
														<th>Reason</th>
														<th> Points</th>
														<th> Date Time</th>

													</tr>
												</thead>
												<tbody>
													<?php 
													$i = ($start_from +1);

											while ($res = mysql_fetch_array($result))
											{                        

											?>
											<tr>
											<td data-title="Sr.No."><?php echo $i;?></td>
											<td data-title="id"><?php echo $res['id'] ?></td>
											<td data-title="prn"><?php echo $res['teacher_name']."<br>".$res['sc_teacher_id'] ?> </td>	
											<td data-title="activity_type"><?php echo $res['activity_type'] ?></td>
											<td data-title="source"><?php echo $res['source'] ?></td>
											<td data-title="category"><?php echo $res['category'] ?></td>
											<td data-title="sub_category"><?php echo $res['sub_category'] ?></td>
											<td data-title="reason"><?php echo $res['reason'] ?></td>
											<td data-title="points"><?php echo $res['sc_point'] ?></td>
											<td data-title="date"><?php echo $res['point_date'] ?></td>
											
										</tr>
										<?php
											$i++;
										}
									
													?>
												</tbody>
											</table>
										</div>
									</div>
									<div id="show" >
										<?php if (!isset($_GET['submit']))
										{
											if ($webpagelimit >$total_records){ $webpagelimit=$total_records;}
											if($count==0){
											echo "<div style='margin-top:5px;'><font color='blue'><b style='margin-left:18px;'>No record found </b></font></div>";
										}else{
											echo "<div style='margin-top:5px;'><font color='blue'><b style='margin-left:18px;'>Now showing ".($start_from +1)." to ".($webpagelimit)." records out of ".$total_records. " records.</b></font></div>";
										}
										}else
										{
											if ($webpagelimit >$total_records){ $webpagelimit=$total_records;}
											if($count==0){
											echo "<div style='margin-top:5px;'><font color='blue'><b style='margin-left:18px;'>No record found </b></font></div>";
										}else{
											echo "<div style='margin-top:5px;'><font color='blue'><b style='margin-left:18px;'>Now showing ".($start_from +1)." to ".($webpagelimit)." records out of ".$total_records. " records.</b></font></div>";
										}
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
														<th>Member ID</th>
														<th> Teacher Name / Employee ID</th>
														<th>Activity Type</th>
														<th>Source</th>
														<th> Category</th>
														<th> Program Name </th>
														<th>Reason</th>	
														<th> Points</th>
														<th> Date Time</th>

													</tr>
												</thead>
												<tbody>
													<?php 
													$i = ($start_from +1);

											while ($res = mysql_fetch_array($result))
											{                        

											?>
											<tr>
											<td data-title="Sr.No."><?php echo $i;?></td>
											<td data-title="id"><?php echo $res['id'] ?></td>
											<td data-title="prn"><?php echo $res['teacher_name']."<br>".$res['sc_teacher_id'] ?> </td>					
											<td data-title="activity_type"><?php echo $res['activity_type'] ?></td>	
											<td data-title="source"><?php echo $res['source'] ?></td>
											<td data-title="category"><?php echo $res['category'] ?></td>
											<td data-title="sub_category"><?php echo $res['sub_category'] ?></td>
											<td data-title="reason"><?php echo $res['reason'] ?></td>
											<td data-title="points"><?php echo $res['sc_point'] ?></td>
											<td data-title="date"><?php echo $res['point_date'] ?></td>
											
										</tr>
														<?php
														$i++;
											}
												
												?>
											</tbody>
										</table>
									</div>
								</div>
								<div id="show"  align='left'>
									<?php if (!isset($_GET['submit']))
									{
										if ($webpagelimit >$total_records){ $webpagelimit=$total_records;}

										if($count==0){
											echo "<div style='margin-top:5px;'><font color='blue'><b style='margin-left:18px;'>No record found </b></font></div>";
										}else{
											echo "<div style='margin-top:5px;'><font color='blue'><b style='margin-left:18px;'>Now showing ".($start_from +1)." to ".($webpagelimit)." records out of ".$total_records. " records.</b></font></div>";
										}
									}else
									{
										if ($webpagelimit >$total_records){ $webpagelimit=$total_records;}
										if($count==0){
											echo "<div style='margin-top:5px;'><font color='blue'><b style='margin-left:18px;'>No record found </b></font></div>";
										}else{
											echo "<div style='margin-top:5px;'><font color='blue'><b style='margin-left:18px;'>Now showing ".($start_from +1)." to ".($webpagelimit)." records out of ".$total_records. " records.</b></font></div>";
										}
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
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.twbsPagination.js" type="text/javascript"></script>
<script src="js/jquery.dataTables.min.js"></script>
<script src='js/bootstrap-datepicker.min.js' type='text/javascript'></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>

<script type="text/javascript">
            $(function () {

                $("#from_date").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    dateFormat: 'yy-mm-dd',
                    endDate: new Date()
                });

                $("#to_date").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    dateFormat: 'yy-mm-dd',
                    endDate: new Date()
                });

            });

</script>
<script type="text/javascript">

$(document).ready(function() {
    $('.searchselect').select2();
});
         
</script>
</html>
