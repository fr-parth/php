<?php
include_once("scadmin_header.php");
$results = $smartcookie->retrive_individual($table, $fields);
$result = mysql_fetch_array($results);
$school_id = $result['school_id'];
$limit = $webpagelimit; 
//page created by Anamika (Nagpur Intern)
if (!($_GET['Search']))  
{
	if (isset($_GET["page"])){ $page  = mysql_real_escape_string($_GET["page"]); } else { $page=1; }; 
	
	$start_from = ($page-1) * $limit;

	$query=mysql_query("SELECT id,ExtDegreeID,Degee_name,Degree_code,course_level FROM tbl_degree_master 
						WHERE ( Degee_name ='' OR Degee_name is NULL) 
							AND school_id = '$school_id'
						LIMIT $start_from, $limit") or die("could not Search!");;
 
	$sql1=" SELECT id FROM  tbl_degree_master
			WHERE ( Degee_name ='' OR Degee_name is NULL ) 
			AND school_id = '$school_id' ";

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
			$query1=mysql_query("SELECT id,ExtDegreeID,Degee_name,Degree_code,course_level FROM tbl_degree_master 
								WHERE ( Degee_name ='' OR Degee_name is NULL) 
									AND school_id = '$school_id'
									AND `$colname` LIKE '%$searchq%' 
								LIMIT $start_from, $limit") or die("could not Search!");

				$sql1 =mysql_query(" SELECT id FROM  tbl_degree_master
								WHERE ( Degee_name ='' OR Degee_name is NULL )  
										AND school_id = '$school_id'
										AND `$colname` LIKE '%$searchq%' ") or die("could not Search!");

				$total_records = mysql_num_rows($sql1);   
				$total_pages = ceil($total_records / $limit);
		}else{	
				$query1=mysql_query("SELECT id,ExtDegreeID,Degee_name,Degree_code,course_level FROM tbl_degree_master 
									WHERE ( Degee_name ='' OR Degee_name is NULL) 
										AND school_id = '$school_id'
										AND (ExtDegreeID LIKE '$searchq%' or Degee_name LIKE '$searchq%' or Degree_code LIKE '$searchq%' or course_level LIKE '$searchq%'  ) LIMIT $start_from, $limit") or die("could not Search!");
			
				$sql1 =mysql_query("SELECT id FROM  tbl_degree_master
									WHERE ( Degee_name ='' OR Degee_name is NULL )  
										AND school_id = '$school_id'
										AND (ExtDegreeID LIKE '$searchq%' or Degee_name LIKE '$searchq%' or Degree_code LIKE '$searchq%' or course_level LIKE '$searchq%' )") or die("could not Search!");   
				
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
//$result = mysql_query("SELECT * FROM tbl_degree_master where ( Degee_name ='' OR Degee_name is NULL) ");
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
				window.location.assign('data_quality_degree.php?page='+page);
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
				window.location.assign('data_quality_degree.php?colname=<?php echo $colname;?>&Search=<?php echo $searchq; ?>&spage='+page);
		});
	});
</script>
<?php }?>

</head>
<body>

<div class="container">
		<div style="padding-top:30px" align="center" >
        		<h2 style="padding-left:20px;padding-top:10px;padding-bottom:10px;background-color:#428BCA; margin-top:2px;color:#666;color:white"><?php echo $dynamic_degree;?> Data without <?php echo $dynamic_degree;?> Name</h2>
		</div>
		<div  style=" height:30px; padding:10px;"></div>

		<!-- search form -->

		<form>
			
			<div class="col-md-2"></div>
			<div class="col-md-2" style="font-weight:bold;" align="right">Search By</div>
            <div class="col-md-2" style="width:17%;">
                <select name="colname" class="form-control">
                    <option selected="selected">Select</option>
					
					<option value="ExtDegreeID"
					<?php if (($_GET['colname']) == "ExtDegreeID") {
                            echo $_GET['colname']; ?> selected="selected" <?php } ?>><?php echo $dynamic_degree;?> ID</option>

					<option value="Degree_code"
					<?php if (($_GET['colname']) == "Degree_code") {
                            echo $_GET['colname']; ?> selected="selected" <?php } ?>><?php echo $dynamic_degree;?> Code</option>
					
					<option value="course_level"
					<?php if (($_GET['colname']) == "course_level") {
                            echo $_GET['colname']; ?> selected="selected" <?php } ?>><?php echo $dynamic_course_level;?></option>  
				</select>
			</div>
			<div class="col-md-2" style="width:17%;">
				<input type="text" class="form-control" name="Search" value="<?php echo $searchq; ?>" placeholder="Search.." required> 
			</div>
			<div class="col-md-1">
			<button type="submit" value="Search" class="btn btn-primary">Search</button>
			</div>
			<div class="col-md-1">
			<input type="button" class="btn btn-danger" value="Reset" onclick="window.open('parent_without_fathername.php','_self')" />
			</div>

        </form>
		<!-- search form END -->

		<!-- message display START -->
		<div id="show" style="margin-top: 70px;">
			<?php  if (!($_GET['Search']))
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
		<!-- message display END -->				

		<?php
			if (isset($_GET['Search']))
				{
					$count=mysql_num_rows($query1);
					if($count == 0){
						echo "<script>$('#show').css('display','none');</script><div style='margin-top:66px;'><font color='Red' style='margin-left: 29px;'><b style='margin-left:490px;'><b>There Was No Search Result</b></font></div>";
					}else{ ?>	

										<div id="no-more-tables" style="padding-top:20px;">
											<table id="example" class="display" width="100%" cellspacing="0">
												<thead style="background-color:#FFFFFF;">
																	
													<tr>
													<th style="width:10px;">Sr.No.</th>
													<th><?php echo $dynamic_degree;?> ID</th>
													<th><?php echo $dynamic_degree;?> Code</th>
													<th><?php echo $dynamic_course_level;?></th>
													<th><?php echo $dynamic_degree;?> Name</th>
													<th style="width:10%;" ><center>Edit</center></th>
													
												
												</tr>
												</thead>
												<tbody>
													<?php
														$i = ($start_from +1);;
														while ($row= mysql_fetch_array($query1)){
														
													?>
														<tr>
															<td data-title="id"><center> <?php echo $i; ?> </center> </td>
															<td data-title="ExtDegreeID"><?php echo $row['ExtDegreeID']; ?></td>
															<td data-title="Degree_code"><?php echo $row['Degree_code']; ?></td>
															<td data-title="course_level"><?php echo $row['course_level']; ?></td>
															<td data-title="Degee_name"><?php echo $row['Degee_name']; ?></td>
															<td> <center>
																<a style="cursor: pointer;" href="edit_degree_data_quality.php?degree_id=<?php echo $row['id']; ?>"><span class="glyphicon glyphicon-pencil"></span></a>
																</center>
																</td>
															
								
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
					<div id="no-more-tables" style="padding-top:20px;">
						<table id="example" class="display" width="100%" cellspacing="0">
							<thead style="background-color:#FFFFFF;">
												
								<tr>
								<th style="width:10px;" >Sr.No.</th>
								<th><?php echo $dynamic_degree;?> ID</th>
								<th><?php echo $dynamic_degree;?> Code</th>
								<th><?php echo $dynamic_course_level;?></th>
								<th><?php echo $dynamic_degree;?> Name</th>
								<th style="width:10%;" ><center>Edit</center></th>
								
							
							</tr>
							</thead>
							<tbody>
								<?php
									$i = ($start_from +1);
									while ($row= mysql_fetch_array($query)){
								?>
									<tr>
										<td data-title="id"><center> <?php echo $i; ?> </center> </td>
										<td data-title="ExtDegreeID"><?php echo $row['ExtDegreeID']; ?></td>
										<td data-title="Degree_code"><?php echo $row['Degree_code']; ?></td>
										<td data-title="course_level"><?php echo $row['course_level']; ?></td>
										<td data-title="Degee_name"><?php echo $row['Degee_name']; ?></td>
										<td> <center>
                     							<a style="cursor: pointer;" href="edit_degree_data_quality.php?degree_id=<?php echo $row['id']; ?>"><span class="glyphicon glyphicon-pencil"></span></a>
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