<?php
include_once("scadmin_header.php");
$results = $smartcookie->retrive_individual($table, $fields);
$result = mysql_fetch_array($results);
$school_id = $result['school_id'];
$limit = $webpagelimit; 

// page Created by Kalyani (Nagpur Intern)
if (!($_GET['Search']))  
{
	if (isset($_GET["page"])){ $page  = mysql_real_escape_string($_GET["page"]); } else { $page=1; }; 
	//if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };  
	
	$start_from = ($page-1) * $limit;

$query = mysql_query("SELECT id, branch_id,Branch_code,branch_Name,Course_Name FROM tbl_branch_master where (branch_Name ='' or branch_Name is null) AND school_id = '$school_id' LIMIT $start_from, $limit") or die("could not Search!");

$sql1 = "SELECT id FROM  tbl_branch_master where (branch_Name ='' or branch_Name is null) AND school_id = '$school_id' ";

$rs_result = mysql_query($sql1);  
		$row1 = mysql_num_rows($rs_result);  
		$total_records = $row1;  
		$total_pages = ceil($total_records / $limit);


		if($total_pages == $_GET['page']){
			$limit = $total_records;
		}else{
			$limit = $start_from + $limit;
		}

}else{
	
	if (isset($_GET["spage"])){ $spage  = mysql_real_escape_string($_GET["spage"]); } else { $spage=1; };   
			$start_from = ($spage-1) * $limit; 

			$searchq=$_GET['Search'];
			$colname=$_GET['colname'];
       
        if ($colname != ''and $colname != 'Select')
				{
            		$query1=mysql_query(" SELECT id, branch_id,Branch_code,branch_Name,Course_Name FROM tbl_branch_master where (branch_Name ='' or branch_Name is null) AND school_id = '$school_id'
									AND `$colname` LIKE '%$searchq%' LIMIT $start_from, $limit") or die("could not Search!");

				$sql1 =mysql_query("SELECT id FROM  tbl_branch_master where (branch_Name ='' or branch_Name is null) AND school_id = '$school_id'AND `$colname` LIKE '%$searchq%' ") or die("could not Search!");
				$total_records = mysql_num_rows($sql1);   
				$total_pages = ceil($total_records / $limit);
		}else{	
				$query1=mysql_query("SELECT id ,branch_id,Branch_code,branch_Name,Course_Name FROM tbl_branch_master where (branch_Name ='' or branch_Name is null) AND school_id = '$school_id' 
									AND (Course_Name LIKE '$searchq%' or branch_id LIKE '$searchq%' or Branch_code LIKE '%$searchq%' 
								or branch_Name LIKE '%$searchq%') LIMIT $start_from, $limit") or die("could not Search!");
			
				$sql1 =mysql_query("SELECT id FROM tbl_branch_master  where (branch_Name ='' or branch_Name is null) AND school_id = '$school_id' 
									AND (Course_Name LIKE '$searchq%' or branch_id LIKE '$searchq%' or Branch_code LIKE '%$searchq%' 
								or branch_Name LIKE '%$searchq%')") or die("could not Search!");   
				
				$total_records = mysql_num_rows($sql1);    
				$total_pages = ceil($total_records / $limit);
			}

		if($total_pages == $_GET['spage'])
		{
			$limit = $total_records;
		}else{
			$limit = $start_from + $limit;
		}			 
	}

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

/*tr:nth-child(even) {
    background-color: #dddddd;
}*/

</style>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.9/js/dataTables.bootstrap.min.js"></script>
  <script src="js/jquery.twbsPagination.js" type="text/javascript"></script>
 
  <script>
    $(document).ready(function(){
    $('#example').dataTable ({
		"paging":false,
		"info":false,
		"searching": false,
     	"scrollCollapse": true,
		//"scrollY": "500px",
		//"scrollX": "100%",
    });
  });
   </script>
   <!-- for search ~ start -->

	<?php if (!($_GET['Search'])){ ?>
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
				window.location.assign('branch_without_branch.php?page='+page);
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
				window.location.assign('branch_without_branch.php?colname=<?php echo $colname;?>&Search=<?php echo $searchq; ?>&spage='+page);
    		});
		});
   </script>
<?php }?>

</head>
<body>

<!-- Headline -->
	<div class="container">
			<div style="padding-top:30px" align="center" >
        		<h2 style="padding-left:20px;padding-top:10px;padding-bottom:10px;background-color:#428BCA; margin-top:2px;color:#666;color:white"><?php echo $dynamic_branch;?> Data without <?php echo $dynamic_branch;?> Name  </h2>
			</div>
			<div  style=" height:30px; padding:10px;"></div>

		<!-- search form -->

		<form>
			<!-- <label for="from">From</label>
			<input type="text" id="from_date" name="from_date" placeholder="MM/DD/YYYY">
			<label for="to">to</label>

			<input type="text" id="to_date" name="to_date" placeholder="MM/DD/YYYY">
				 &nbsp;&nbsp;
 			<input type="submit" value="Search" name="search" id="search" /> -->
			 
			
			<div class="col-md-2"></div>
			<div class="col-md-2" style="font-weight:bold;" align="right">Search By</div>
            <div class="col-md-2" style="width:17%;">
                <select name="colname" class="form-control">
                    <option selected="selected">Select</option>
					
					<option value="branch_id"
					<?php if (($_GET['colname']) == "branch_id") {
                            echo $_GET['colname']; ?> selected="selected" <?php } ?>><?php echo $dynamic_branch;?> Id</option>

					<option value="Branch_code"
					<?php if (($_GET['colname']) == "Branch_code") {
                            echo $_GET['colname']; ?> selected="selected" <?php } ?>><?php echo $dynamic_branch;?> Code</option>  

                    <option value="Course_Name"
					<?php if (($_GET['colname']) == "Course_Name") {
                            echo $_GET['colname']; ?> selected="selected" <?php } ?>><?php echo $dynamic_course_level; ?> Name</option> 

                   

                    
                </select>
			</div>

        <div class="col-md-2" style="width:17%;">
				<input type="text" class="form-control" name="Search" value="<?php echo $searchq; ?>" placeholder="Search.." required> 
			</div>
			<div class="col-md-1">
			<button type="submit" value="Search" class="btn btn-primary">Search</button>
			</div>
			<div class="col-md-1">
			<input type="button" class="btn btn-danger" value="Reset" onclick="window.open('branch_without_branch.php','_self')" />
			</div>	
        </form>
		<!-- search form END -->	
		<div id="show" style="margin-top: 70px;">
			<?php if (!($_GET['Search']))
			{   
				if ($limit >$total_records){ $limit=$total_records;}
				echo "<font color='blue' style='margin-left: 29px;'><b style='margin-left:400px;'>Now showing ".($start_from +1)." to ".($limit)." records out of ".($total_records). " records.</b></font>";
		    }else
			{
				if ($limit >$total_records){ $limit=$total_records;}
				echo "<font color='blue' style='margin-left: 29px;'><b style='margin-left:400px;'>Now showing ".($start_from +1)." to ".($limit)." records out of ".($total_records). " records.</b></font>";
			} 
			?>
		</div>

		<!-- If Search is Set -->

		<?php
			if (isset($_GET['Search']))
				{
					$count=mysql_num_rows($query1);
					if($count == 0){
						echo "<script>$('#show').css('display','none');</script><div style='margin-top:66px;'><font color='Red' style='margin-left: 29px;'><b style='margin-left:490px;'><b>There Was No Search Result</b></font></div>";
					}else{
		?>
		<div id="no-more-tables" style="padding-top:20px;">
			<table id="example" class="display" width="100%" cellspacing="0">
					<thead style="background-color:#FFFFFF;">
                        <tr>
					<th style="width:10px;">Sr.No.</th>
					<th><?php echo $dynamic_branch;?>  Id</th>
					<th><?php echo $dynamic_branch;?>  Code</th>
					<th><?php echo $dynamic_course_level;?>  Name</th>
					<th><?php echo $dynamic_branch;?>  Name</th>
					<th style="width:10%;" ><center>Edit</center></th>
					
					</tr>
				</thead>
				<tbody>
                     <?php
							$i = ($start_from +1);
							while ($row= mysql_fetch_array($query1)){

					 ?>
						<tr>
							<td data-title="id"><?php echo $i; ?></td>
							<td><?php echo $row['branch_id']; ?></td>
							<td><?php echo $row['Branch_code']; ?></td>
							<td><?php echo $row['Course_Name']; ?></td>
							<td><?php echo $row['branch_Name']; ?></td>
							
							<td> <center>
                     			<a style="cursor: pointer;" href="edit_school_branch.php?id=<?php echo $row['id']?>"><span class="glyphicon glyphicon-pencil"></span></a>
								</center>
							</td>
							
						</tr>
					<?php $i++;} ?>     
				</tbody>
			</table>
          </div>
          <div class="container" align="center">
			<nav aria-label="Page navigation">
			  <ul class="pagination" id="pagination"></ul>
		    </nav>
		</div>

	<?php } 
		}
		else
		{
		?>


			<table id="example" class="display" width="100%" cellspacing="0">
					<thead style="background-color:#FFFFFF;">
									
						<tr>
							<th style="width:10px;" >Sr.No.</th>
							<th><?php echo $dynamic_branch;?>  Id</th>
					        <th><?php echo $dynamic_branch;?>  Code</th>
							<th><?php echo $dynamic_course_level;?>  Name</th>
					        <th><?php echo $dynamic_branch;?>  Name</th>
							<th style="width:10%;" ><center>Edit</center></th> 
						</tr>
					</thead>
					<tbody>
					 	<?php
							$i = ($start_from +1);
							while ($row= mysql_fetch_array($query)){
						
					 	?>
						<tr>
							<td data-title="id">
								<center>
										<?php echo $i; ?>
								</center>
										</td>
										<td><?php echo $row['branch_id']; ?></td>
							<td><?php echo $row['Branch_code']; ?></td>
							<td><?php echo $row['Course_Name']; ?></td>
							<td><?php echo $row['branch_Name']; ?></td>
							<td> <center>
                     			<a style="cursor: pointer;" href="edit_school_branch.php?id=<?php echo $row['id']?>"><span class="glyphicon glyphicon-pencil"></span></a>
								</center>
							</td>
							
						</tr>
						<?php $i++;} ?>     
					</tbody>
				</table>
			</div>


		<div class="container" align="center">
			<nav aria-label="Page navigation">
			  <ul class="pagination" id="pagination"></ul>
		    </nav>
		</div>

		<?php } ?>
		</div>
	</div>
</div>
</body>
</html>