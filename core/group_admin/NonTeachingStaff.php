<?php
include("groupadminheader.php");
//include("../conn.php");
$group_member_id = $_SESSION['group_admin_id'];
//echo "http://".$server_name.'/css/jquery.dataTables.css';


$sql=mysql_query("SELECT t_id,t_name,t_complete_name,t_middlename,t_lastname,t.school_id,t_current_school_name,t_email,t_phone,t_address from tbl_teacher t inner join tbl_group_school gs on t.school_id=gs.school_id where gs.group_member_id = '$group_member_id' AND t_emp_type_pid NOT IN (133,134,135,137) order by t.school_id LIMIT $start_from, $webpagelimit");


if (!($_GET['Search'])){

if (isset($_GET["page"])){ $page  = $_GET["page"]; } else { $page=1; };  
$start_from = ($page-1) * $webpagelimit;
	
$sql=mysql_query("SELECT  t_id,t_name,t_complete_name,t_middlename,t_lastname,t.school_id,t_current_school_name,t_email,t_phone,t_address from tbl_teacher t inner join tbl_group_school gs on t.school_id=gs.school_id where gs.group_member_id = '$group_member_id' AND t_emp_type_pid NOT IN (133,134,135,137) order by t.school_id LIMIT $start_from, $webpagelimit");	

$sql1 ="select COUNT(t.id) from tbl_teacher t inner join tbl_group_school gs on t.school_id=gs.school_id where gs.group_member_id = '$group_member_id' AND t_emp_type_pid NOT IN (133,134,135,137) order by t.school_id";  
					$rs_result = mysql_query($sql1);  
					$row1 = mysql_fetch_row($rs_result);  
					$total_records = $row1[0];  
					$total_pages = ceil($total_records / $webpagelimit);
					if($total_pages == $_GET['page']){
					$webpagelimit = $total_records;
					}else{
					$webpagelimit = $start_from + $webpagelimit;
					}
}else
{
	if (isset($_GET["spage"])){ $spage  = $_GET["spage"]; } else { $spage=1; };  
$start_from = ($spage-1) * $webpagelimit;

$searchq=$_GET['Search'];
$colname=$_GET['colname'];
	if ($colname !=''and $colname != 'Select')
	{
		if($colname== "school_id"){
			$colname = "t.".$colname;
			$query1=mysql_query("SELECT t_id,
		t_name,t_complete_name,t_middlename,t_lastname,t.school_id,t_current_school_name,t_email,t_phone,t_address from tbl_teacher t inner join tbl_group_school gs on t.school_id=gs.school_id where gs.group_member_id = '$group_member_id' AND t_emp_type_pid NOT IN (133,134,135,137) AND $colname LIKE '%$searchq%' order by t.school_id LIMIT $start_from, $webpagelimit") or die("could not Search!");
		}else{
		$query1=mysql_query("SELECT t_id,
		t_name,t_complete_name,t_middlename,t_lastname,t.school_id,t_current_school_name,t_email,t_phone,t_address from tbl_teacher t inner join tbl_group_school gs on t.school_id=gs.school_id where gs.group_member_id = '$group_member_id' AND t_emp_type_pid NOT IN (133,134,135,137) AND $colname LIKE '%$searchq%' order by t.school_id LIMIT $start_from, $webpagelimit") or die("could not Search!");
		}			
		$sql1 ="select COUNT(t.id) from tbl_teacher t inner join tbl_group_school gs on t.school_id=gs.school_id where gs.group_member_id = '$group_member_id' AND t_emp_type_pid NOT IN (133,134,135,137) AND $colname LIKE '%$searchq%' order by t.school_id ";


					$rs_result = mysql_query($sql1);  
					$row1 = mysql_fetch_row($rs_result);  
					$total_records = $row1[0];  
					$total_pages = ceil($total_records / $webpagelimit);

	}else{
			

			$query1=mysql_query("SELECT t_id, t_name,t_complete_name,t_middlename,t_lastname,t.school_id,t_current_school_name,t_email,t_phone,t_address from tbl_teacher t inner join tbl_group_school gs on t.school_id=gs.school_id where gs.group_member_id = '$group_member_id' AND t_emp_type_pid NOT IN (133,134,135,137) AND (t_name LIKE '$searchq%' or t_complete_name LIKE '%$searchq%' or t_middlename LIKE '$searchq%' or t_lastname LIKE '$searchq%' or t.school_id LIKE '$searchq%' or t_current_school_name LIKE '%$searchq%' or t_email LIKE '$searchq%' or t_phone LIKE '$searchq%'or t_address LIKE '%$searchq%')order by t.school_id LIMIT $start_from, $webpagelimit") or die("could not Search!");
			
			$sql1 ="select COUNT(t.id) from tbl_teacher t inner join tbl_group_school gs on t.school_id=gs.school_id where gs.group_member_id = '$group_member_id' AND t_emp_type_pid NOT IN (133,134,135,137) AND (t_name LIKE '$searchq%' or t_complete_name LIKE '%$searchq%' or t_middlename LIKE '$searchq%' or t_lastname LIKE '$searchq%' or t.school_id LIKE '$searchq%' or t_current_school_name LIKE '%$searchq%' or t_email LIKE '$searchq%' or t_phone LIKE '$searchq%'or t_address LIKE '%$searchq%')order by t.school_id "; 

			$rs_result = mysql_query($sql1);  
					$row1 = mysql_fetch_row($rs_result);  
					$total_records = $row1[0];  
					$total_pages = ceil($total_records / $webpagelimit);
		}
			
		//below query use for search count
		 
					if($total_pages == $_GET['spage']){
					$webpagelimit = $total_records;
					}else{
					$webpagelimit = $start_from + $webpagelimit;
					}
					 
}
?>

<!DOCTYPE>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Volunteer Information</title>
     <link rel="stylesheet" type="text/css" href="../css/jquery.dataTables.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="../js/jquery-1.11.1.min.js"></script>
    <script src="../js/jquery.dataTables.min.js"></script>

    <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
	<script src="../js/jquery.twbsPagination.js" type="text/javascript"></script>
<script>
    $(document).ready(function() {
    $('#example').dataTable( {
	"paging":   false,
	"info":false,
	"searching": false,
     "scrollCollapse": true
	
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
			window.location.assign('NonTeachingStaff.php?page='+page);
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
			window.location.assign('NonTeachingStaff.php?colname=<?php echo $colname;?>&Search=<?php echo $searchq; ?>&spage='+page);
        });
    });
</script>
<?php }?>
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
                width: 45%;
                padding-right: 10px;
                white-space: nowrap;
                text-align: left;
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
<div class="container" style="width:100%;">
    <div class="row" style="padding-top:10px;height:30px;" align="center">
        <h2 style="margin-top:8px;color:#666"> List of Non Teaching Staff<?php// echo $dynamic_teacher;?></h2></br>
    </div>
		
		<div class='row'>
		<form style="margin-top:25px;">
			 <div class="col-md-4" style="width:17%;">
			 </div>
			<div class="col-md-2" style="font-weight:bold; margin-right:-36px;">Search By
			</div>
            <div class="col-md-2" style="width:17%;">
                <select name="colname" class="form-control">
                    <option selected="selected">Select</option>
                    <option value="t_complete_name"
					<?php if (($_GET['colname']) == "t_complete_name") {
                            echo $_GET['colname']; ?> selected="selected" <?php } ?>><?php echo $dynamic_teacher;?> Name</option>
                     <option value="school_id"
					<?php if (($_GET['colname']) == "school_id") {
                            echo $_GET['colname']; ?> selected="selected" <?php } ?>><?php echo $dynamic_school;?> ID</option>
					<option value="t_current_school_name"
					<?php if (($_GET['colname']) == "t_current_school_name") {
                            echo $_GET['colname']; ?> selected="selected" <?php } ?>><?php echo $dynamic_school;?> Name</option>
					<option value="t_email"
					<?php if (($_GET['colname']) == "t_email") {
                            echo $_GET['colname']; ?> selected="selected" <?php } ?>>Email ID</option>
					<option value="t_phone"
					<?php if (($_GET['colname']) == "t_phone") {
                            echo $_GET['colname']; ?> selected="selected" <?php } ?>>Phone No</option>
					<option value="t_address"
					<?php if (($_GET['colname']) == "t_address") {
                            echo $_GET['colname']; ?> selected="selected" <?php } ?>>Address</option>
                </select>
			</div>
			<div class="col-md-2" style="width:17%;">
				<input type="text" class="form-control" name="Search" value="<?php echo $searchq; ?>" placeholder="Search.." required> 
			</div>
			<div class="col-md-1" >
			<button type="submit" value="Search" class="btn btn-primary">Search</button>
			</div>
			<div class="col-md-1" >
			<input type="button" class="btn btn-info" value="Reset" onclick="window.open('NonTeachingStaff.php','_self')" />
			</div>
					<!-- <div style="margin-left: 800px;">
						<input type="text" name="Search" value="<?php echo $searchq; ?>" placeholder="Search..">
						<input type="submit" value="Search">
						<input type="button" value="Reset" onclick="window.open('beneficiary_list.php','_self')" />
					</div> -->
		</form>
		 </div>
		 <!-- <div id="show" >
		 		<?php if (!($_GET['Search']))
		 			{
		 				if ($webpagelimit >$total_records){ $webpagelimit=$total_records;}
		 				echo "<div style='margin-top:5px;'><font color='blue'><b style='margin-left:600px;'>Now showing ".($start_from +1)." to ".($webpagelimit)." records out of ".$total_records. " records.</b></font></div>";
		    }else
		 			{
		 				if ($webpagelimit >$total_records){ $webpagelimit=$total_records;}
		 				echo "<div style='margin-top:5px;'><font color='blue'><b style='margin-left:600px;'>Now showing ".($start_from +1)." to ".($webpagelimit)." records out of ".($total_records). " records.</b></font></div>";
		 			}
		 			?>
		 </div> -->
		<?php
		if (isset($_GET['Search']))
		{
			

			$count=mysql_num_rows($query1);
			if($count == 0){
				echo "<script>$('#show').css('display','none');</script><center><div style='margin-top:20px;'><font color='Red'><b>There Was No Search Result</b></font></div></center>";	
			}
			else
			{
			?>
				<div id="no-more-tables" style="padding-top:40px;">
				<table id="example" class="col-md-12 table-bordered " align="center">
					<thead>
					<tr style="background-color:#0073BD; color:#FFFFFF; height:30px;">
						<th>Sr. No.</th>
						<th> <?php echo $dynamic_teacher;?> ID </th>
						<th> <?php echo $dynamic_teacher;?> Name </th>
						<th> <?php echo $dynamic_school;?> ID </th>
						<th> <?php echo $dynamic_school;?> Name </th>
						<th> Email ID </th>
						<th style="width:15%"> Phone No </th>
						<th> Adderss </th>
					</tr>
					</thead>
					<?php $i = 1;
					$i = ($start_from +1);
					while ($result = mysql_fetch_array($query1)) {
						?>
						<tr>
							<td data-title="Sr.No."><?php echo $i; ?></td>
							<td data-title="Staff ID"><?php echo $result['t_id']; ?></td>
							<td data-title="Teacher Name "><?php if ($result['t_complete_name'] == "") {echo ucwords(strtolower($result['t_name'] . " " . $result['t_middlename'] . " " . $result['t_lastname']));
								} else {
									echo ucwords(strtolower($result['t_complete_name']));
								}
								?></td>
							<td data-title="School ID"><?php echo $result['school_id']; ?></td>
							<td data-title="School Name"><?php echo $result['t_current_school_name']; ?></td>
							<td data-title="Email ID"><?php echo $result['t_email']; ?></td>
							<td data-title="Phone No."><?php echo $result['t_phone']; ?></td>
							<td data-title="Address"><?php echo $result['t_address']; ?></td>
						</tr>
						<?php $i++;
					} ?>
				</table>
				</div>
				<center>
					<!--Below pagination added by Rutuja for SMC-4464 on 30/01/2020-->
					 <div align='left'>
                <?php if (!($_GET['Search']))
                    {
                        if ($webpagelimit >$total_records){ $webpagelimit=$total_records;}
                        echo "<div style='margin-top:5px;'><font color='#0073BD'><style='margin-left:600px;'>Now showing ".($start_from +1)." to ".($webpagelimit)." records out of ".$total_records. " records.</font></style></div>";
            }else
                    {
                        if ($webpagelimit >$total_records){ $webpagelimit=$total_records;}
                        echo "<div style='margin-top:5px;'><font color='#0073BD'><style='margin-left:600px;'>Now showing ".($start_from +1)." to ".($webpagelimit)." records out of ".($total_records). " records.</font></style></div>";
                    }
                    ?>
         </div> 
			<div class="container">
			<nav aria-label="Page navigation">
			  <ul class="pagination" id="pagination"></ul>
		    </nav>
		</div>
	</center>
			<?php
			}
		}
		else
		{			
		?>
			<div id="no-more-tables" style="padding-top:40px;">
			<table id="example" class="col-md-12 table-bordered " align="center">
				<thead>
				<tr style="background-color:#0073BD; color:#FFFFFF; height:30px;">
					<th>Sr. No.</th>
					<th> <?php echo $dynamic_teacher;?> ID </th>
					<th> <?php echo $dynamic_teacher;?> Name </th>
					<th> <?php echo $dynamic_school;?> ID </th>
					<th> <?php echo $dynamic_school;?> Name </th>
					<th> Email ID </th>
					<th style="width:15%"> Phone No </th>
					<th> Adderss </th>
				</tr>
				</thead>
				<?php $i = 1;
				$i = ($start_from +1);
				while ($result = mysql_fetch_array($sql)) {
					?>
					<tr>
						<td data-title="Sr.No."><?php echo $i; ?></td>
						<td data-title="Staff ID"><?php echo $result['t_id']; ?></td>
						<td data-title="Teacher Name "><?php if ($result['t_complete_name'] == "") {echo ucwords(strtolower($result['t_name'] . " " . $result['t_middlename'] . " " . $result['t_lastname']));
							} else {
								echo ucwords(strtolower($result['t_complete_name']));
							}
							?></td>
						<td data-title="School ID"><?php echo $result['school_id']; ?></td>
						<td data-title="School Name"><?php echo $result['t_current_school_name']; ?></td>
						<td data-title="Email ID"><?php echo $result['t_email']; ?></td>
						<td data-title="Phone No."><?php echo $result['t_phone']; ?></td>
						<td data-title="Address"><?php echo $result['t_address']; ?></td>
					</tr>
					<?php $i++;
				} ?>
			</table>
			</div>
			<center>
				<!--Below pagination added by Rutuja for SMC-4464 on 30/01/2020-->
				<div align='left'>
                <?php if (!($_GET['Search']))
                    {
                        if ($webpagelimit >$total_records){ $webpagelimit=$total_records;}
                        echo "<div style='margin-top:5px;'><font color='#0073BD'><style='margin-left:600px;'>Now showing ".($start_from +1)." to ".($webpagelimit)." records out of ".$total_records. " records.</font></style></div>";
            }else
                    {
                        if ($webpagelimit >$total_records){ $webpagelimit=$total_records;}
                        echo "<div style='margin-top:5px;'><font color='#0073BD'><style='margin-left:600px;'>Now showing ".($start_from +1)." to ".($webpagelimit)." records out of ".($total_records). " records.</font></style></div>";
                    }
                    ?>
         </div>
			<div class="container">
			<nav aria-label="Page navigation">
			  <ul class="pagination" id="pagination"></ul>
		    </nav>
		</div>
		</center>
	<?php } ?>
</div>
</body>
</html>