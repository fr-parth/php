<?php
include("cookieadminheader.php");
$sc_id=$_SESSION['school_id'];
/*START-Change for pagignation problem Bug no-3066 by Dhanashri*/
//$webpagelimit = 10;
if (!($_GET['Search'])){   
	if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };  
	$start_from = ($page-1) * $webpagelimit;
	/* START-Change in query to display "school Name" by Dhanashri*/
	$sql="SELECT school_id,school_name,name,reg_date,balance_blue_points,assign_blue_points FROM tbl_school_admin 
	WHERE school_id !='' order by school_id LIMIT $start_from, $webpagelimit";
	/*End*/
	$row = mysql_query($sql);
	$sql1 ="SELECT COUNT(id) FROM tbl_school_admin WHERE school_id !='' order by school_id";  
						$rs_result = mysql_query($sql1);  
						$row1 = mysql_fetch_row($rs_result);  
						$total_records = $row1[0];  
						$total_pages = ceil($total_records / $webpagelimit);
						if($total_pages == $_GET['page']){
						$webpagelimit = $total_records;
						}else{
						$webpagelimit = $start_from + $webpagelimit;
						}
}else{
	if (isset($_GET["spage"])){ $spage  = $_GET["spage"]; } else { $spage=1; };  
			$start_from = ($spage-1) * $webpagelimit;

			$searchq=$_GET['Search'];
			$colname=$_GET['colname'];
		
	if ($colname != ''and $colname != 'Select'){
		$query1=mysql_query("SELECT school_id,school_name,name,reg_date,balance_blue_points,assign_blue_points
		FROM tbl_school_admin 
		WHERE school_id != '' AND `$colname` LIKE '%$searchq%' order by school_id  LIMIT $start_from, $webpagelimit") or die("could not Search!");
					
		$sql1 =mysql_query("SELECT school_id,school_name,name,reg_date,balance_blue_points,assign_blue_points
		FROM tbl_school_admin 
		WHERE school_id != '' AND `$colname` LIKE '%$searchq%' order by school_id ") or die("could not Search!");
					$total_records = mysql_num_rows($sql1);   
					$total_pages = ceil($total_records / $webpagelimit);
	}
	else{
			$query1=mysql_query("SELECT  school_id,school_name,name,reg_date,balance_blue_points,assign_blue_points
			FROM tbl_school_admin 
			WHERE school_id = '$sc_id' AND (school_id LIKE '$searchq%' or school_name LIKE '$searchq%' or name LIKE '$searchq%' or reg_date LIKE '%$searchq%' or balance_blue_points LIKE '$searchq%' or assign_blue_points LIKE '$searchq%')order by school_id LIMIT $start_from, $webpagelimit") or die("could not Search!");
			
			$sql1 =mysql_query("SELECT  school_id,school_name,name,reg_date,balance_blue_points,assign_blue_points
			FROM tbl_school_admin 
			WHERE school_id = '$sc_id' AND (school_id LIKE '$searchq%' or school_name LIKE '$searchq%' or name LIKE '$searchq%' or reg_date LIKE '%$searchq%' or balance_blue_points LIKE '$searchq%' or assign_blue_points LIKE '$searchq%')order by school_id") or die("could not Search!");   
					$total_records = mysql_num_rows($sql1);    
					$total_pages = ceil($total_records / $webpagelimit);
		}
			if($total_pages == $_GET['spage']){
					$webpagelimit = $total_records;
					}else{
					$webpagelimit = $start_from + $webpagelimit;
					}			 
	}
?>
<html>
	<!--link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/jquery.dataTables.min.js"></script-->
	<link rel="stylesheet" type="text/css" href="../css/jquery.dataTables.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!--link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css"-->
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <!--script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script-->
	<script src="js/jquery.twbsPagination.js" type="text/javascript"></script>
	
	 <script>
    $(document).ready(function() {
    $('#example').dataTable( {
	"paging":   false,
	"info":false,
	"searching": false,
     "scrollCollapse": true
	//"scrollY": "500px",
	//"scrollX": "100%"
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
			window.location.assign('bluepoints.php?page='+page);
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
			window.location.assign('bluepoints.php?colname=<?php echo $colname;?>&Search=<?php echo $searchq; ?>&spage='+page);
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
    <!--script>
		/*$(document).ready(function() {
		$('#example').DataTable();
		} );*/
		 $(document).ready(function() {
    $('#example').dataTable( {
	"paging":   false,
	"searching": false
    } );
} );
    </script-->
<body>
	<div class="container" style="padding-top:20px;">
		<div style="height:50px;  background-color:#694489;" align="center" >
        	<h2 style="padding-left:20px;padding-top:10px;padding-bottom:10px; margin-top:20px;color:white">Assign Blue Points</h2>
        </div>
		
	<form style="margin-top:9px;">
			<div class="col-md-2"></div>
			<div class="col-md-2" style="font-weight:bold;" align="right">Search By
			</div>
            <div class="col-md-2" style="width:17%;">
                <select name="colname" class="form-control">
				<!--school_id,school_name,name,reg_date,balance_blue_points,assign_blue_points-->
                    <option selected="selected">Select</option>
                    <option value="school_id"
					<?php if (($_GET['colname']) == "school_id") {
                            echo $_GET['colname']; ?> selected="selected" <?php } ?>>School ID</option>
                     <option value="school_name"
					<?php if (($_GET['colname']) == "school_name") {
                            echo $_GET['colname']; ?> selected="selected" <?php } ?>> School Name</option>
					<option value="name"
					<?php if (($_GET['colname']) == "name") {
                            echo $_GET['colname']; ?> selected="selected" <?php } ?>> School Head</option>  
							<option value="reg_date"
					<?php if (($_GET['colname']) == "reg_date") {
                            echo $_GET['colname']; ?> selected="selected" <?php } ?>> Reg Date</option>  
							<option value="balance_blue_points"
					<?php if (($_GET['colname']) == "balance_blue_points") {
                            echo $_GET['colname']; ?> selected="selected" <?php } ?>> Balance Blue Points</option>  
							<option value="assign_blue_points"
					<?php if (($_GET['colname']) == "assign_blue_points") {
                            echo $_GET['colname']; ?> selected="selected" <?php } ?>> Assign Blue Points</option> 
							
                </select>
			</div>
			<div class="col-md-2" style="width:17%;">
				<input type="text" class="form-control" name="Search" value="<?php echo $searchq; ?>" placeholder="Search.." required> 
			</div>
			<div class="col-md-1">
			<button type="submit" value="Search" class="btn btn-primary">Search</button>
			</div>
			<div class="col-md-1">
			<input type="button" class="btn btn-danger" value="Reset" onclick="window.open('bluepoints.php','_self')" />
			</div>
	</form>
	<br>
		 <!-- <div id="show" style="margin-top: 70px;">
		 			<?php if (!($_GET['Search']))
		 			{   
		 				if ($webpagelimit >$total_records){ $webpagelimit=$total_records;}
		 				echo "<font color='blue' style='margin-left: 29px;'><b style='margin-left:400px;'>Now showing ".($start_from +1)." to ".($webpagelimit)." records out of ".$total_records. " records.</b></font>";
		    }else
		 			{
		 				if ($webpagelimit >$total_records){ $webpagelimit=$total_records;}
		 				echo "<font color='blue' style='margin-left: 29px;'><b style='margin-left:400px;'>Now showing ".($start_from +1)." to ".($webpagelimit)." records out of ".($total_records). " records.</b></font>";
		 			}
		 			?>
		 		</div> 
		--><br>
			<?php
		if (isset($_GET['Search']))
		{
			$count=mysql_num_rows($query1);
			if($count == 0){
					echo "<script>$('#show').css('display','none');</script><div style='margin-top:66px;'><font color='Red' style='margin-left: 29px;'><b style='margin-left:490px;'><b>There Was No Search Result</b></font></div>";
			}
			else
			{
			?>
        <!--div style="height:20px;"></div>
		<div id="no-more-tables" style="padding-top:20px;">
			<table id="example" class="col-md-12 table-bordered table-striped ">
	    		<thead>
        			<tr style="background-color:#9F5F9F;color:white;box-shadow: 1px 1px 1px 2px  rgba(150,150,150, 0.6);height:30px;"-->
					
					<div id="no-more-tables" style="padding-top:20px;">
						 <table id="example" class="col-md-12 table-bordered " align="center">
                            <thead>
                            <tr style="background-color:#9F5F9F;color:white;box-shadow: 1px 1px 1px 2px  rgba(150,150,150, 0.6);height:30px;">
							
                	<th>Sr. No.</th>
                    <th>School ID</th>
                    <th>School Name</th>
                    <th>School Head</th>
                    <th>Reg Date</th>
                    <th>Balance Blue Points</th>
                    <th>Used Blue Points</th>
					<th>Assign</th>
					</tr>
                </thead>
				<?php $i=($start_from +1);
						while($result=mysql_fetch_array($query1)){
							$school_id=$result['school_id'];?>
							<tr>
							<td><?php echo $i;   ?></td>
							<td><?php echo $school_id;?></td>
							<td><?php echo ucwords($result['school_name']);?></td>
							<td><?php echo ucwords($result['name']);?></td>
							<td><?php echo $result['reg_date'];?></td>
							<td><?php echo $result['balance_blue_points'];?></td>
							<td><?php echo $result['assign_blue_points'];?></td>
							<td > <a href="assign_bluepoints.php?school_id=<?php echo $school_id;?>"> <input type="button" value="Assign" name="assign" class="btn btn-primary"/></a></td>
							</tr>
							<?php  $i++;} ?>
        	</table>
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
					<!--<div style="height:20px;"></div>-->
					<div id="no-more-tables" style="padding-top:20px;">
						 <table id="example" class="col-md-12 table-bordered table-striped">
                            <thead>
                            <tr style="background-color:#9F5F9F;color:white;box-shadow: 1px 1px 1px 2px  rgba(150,150,150, 0.6);height:30px;">
                	<th>Sr. No.</th>
                    <th>School ID</th>
                    <th>School Name</th>
                    <th>School Head</th>
                    <th>Reg Date</th>
                    <th>Balance Blue Points</th>
                    <th>Used Blue Points</th>
					<th>Assign</th>
					</tr>
                </thead>
				<?php $i=($start_from +1);
						while($result=mysql_fetch_array($row)){
							$school_id=$result['school_id'];?>
							<tr>
							<td><?php echo $i;   ?></td>
							<td><?php echo $school_id;?></td>
							<td><?php echo ucwords($result['school_name']);?></td>
							<td><?php echo ucwords($result['name']);?></td>
							<td><?php echo $result['reg_date'];?></td>
							<td><?php echo $result['balance_blue_points'];?></td>
							<td><?php echo $result['assign_blue_points'];?></td>
							<td > <a href="assign_bluepoints.php?school_id=<?php echo $school_id;?>"> <input type="button" value="Assign" name="assign" class="btn btn-primary"/></a>
							</td>
							</tr>
							<?php  $i++;} ?>
        	</table>
        </div>
		<div class="container" align="center">
			<nav aria-label="Page navigation">
			  <ul class="pagination" id="pagination"></ul>
		    </nav>
		</div>
<?php } ?>
    </div>
	<!--END-->
</body>
</html>
