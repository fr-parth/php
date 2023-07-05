<?php
include("cookieadminheader.php");
$limit = $webpagelimit; //from securityfunctions.php
if (!($_GET['Search']))  
{  
	if (isset($_GET["page"])){ $page  = mysql_real_escape_string($_GET["page"]); } else { $page=1; }; 
	//if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };  
	
	$start_from = ($page-1) * $limit;

	$row=mysql_query("SELECT id,school_id,school_name,name,school_name,email,group_type,school_type,reg_date,lat,lon FROM tbl_school_admin WHERE school_id!='' ORDER BY school_id LIMIT $start_from, $limit") or die("Query Failed!");
	$sql1="SELECT school_id FROM `tbl_school_admin` where school_id!='' ";
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
			$query1=mysql_query("SELECT id,school_id,school_name,name,school_name,email,group_type,school_type,reg_date,lat,lon FROM tbl_school_admin 
									WHERE school_id!='' AND `$colname` LIKE '%$searchq%' 
									ORDER BY school_id  LIMIT $start_from, $limit") or die("could not Search!");

				$sql1 =mysql_query("SELECT id,school_id,school_name,name,school_name,email,group_type,school_type,reg_date,lat,lon FROM tbl_school_admin 
									WHERE school_id!='' AND `$colname` LIKE '%$searchq%' 
									ORDER BY school_id ") or die("could not Search!");
				$total_records = mysql_num_rows($sql1);   
				$total_pages = ceil($total_records / $limit);
		}else{	
				$query1=mysql_query("SELECT id,school_id,school_name,name,school_name,email,group_type,school_type,reg_date,lat,lon FROM tbl_school_admin
				WHERE school_id!='' AND ( id LIKE '%$searchq%' or
				school_id LIKE '%$searchq%' or
				school_name LIKE '%$searchq%' or
				name LIKE '%$searchq%' or
				school_name LIKE '%$searchq%' or
				email LIKE '%$searchq%' or
				group_type LIKE '%$searchq%' or
				school_type LIKE '%$searchq%' or
				reg_date LIKE '%$searchq%' or 
				lat LIKE '%$searchq%' or
				lon LIKE '%$searchq%' ) ORDER BY school_id LIMIT $start_from, $limit" ) or die("Query 3 failed!");
			
				$sql1 =mysql_query("SELECT id,school_id,school_name,name,school_name,email,group_type,school_type,reg_date FROM tbl_school_admin
									WHERE school_id!='' AND ( id LIKE '%$searchq%' or
									school_id LIKE '%$searchq%' or
									school_name LIKE '%$searchq%' or
									name LIKE '%$searchq%' or
									school_name LIKE '%$searchq%' or
									email LIKE '%$searchq%' or
									group_type LIKE '%$searchq%' or
									school_type LIKE '%$searchq%' or
									reg_date LIKE '%$searchq%' or
									lat LIKE '%$searchq%' or
									lon LIKE '%$searchq%' )");  
					$total_records = mysql_num_rows($sql1);    
					$total_pages = ceil($total_records / $limit);
			}

		if($total_pages == $_GET['spage']){
			$limit = $total_records;
		}else{
			$limit = $start_from + $limit;
		}			 
	}
//if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };  
//$start_from = ($page-1) * $limit;
//$sql="SELECT id,school_id,school_name,name,school_name,email,group_type,school_type,reg_date FROM `tbl_school_admin` where `school_id`!='' LIMIT $start_from, $limit order by id desc ";
//$row = mysql_query($sql);
?>
<html>

 <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
 <link rel="stylesheet" href="css/bootstrap.min.css">


<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.dataTables.min.js"></script>
<script src="js/jquery.twbsPagination.js" type="text/javascript"></script>

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



      <script>
       	$(document).ready(function() {

	    $('#example').DataTable({
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
				window.location.assign('cookie_list_school.php?page='+page);
    		});
  		});
  		</script>
		<?php }else{ ?>
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
				window.location.assign('cookie_list_school.php?colname=<?php echo $colname;?>&Search=<?php echo $searchq; ?>&spage='+page);
    		});
		});
   		</script>
	<?php }?>



    <script>

    function confirmation(xxx)
  		{

    	var s = "Are you sure you want to delete?";
    	var answer = confirm(s);
    	if (answer){

        	window.location = "cookie_delete_school.php?sc_id="+xxx;

    	}else{
    		}
  		}
</script>
<body>
<div class="container" style="padding-top:20px;width:100%;">
		<!--<div style="width:100%; height:50px; background-color:#f9f9f9; border:1px solid #CCCCCC;" align="center" >
        	<h1 style="padding-left:20px; margin-top:4px; border-color:#694489;">Edit School Info</h1>
        </div>-->

		<div class="radius " style="height:50px; width:105%; background-color:#694489;" align="center">
        	<h2 style="padding-left:30px;padding-top:15px; margin-top:20px;color:white">Edit School Info</h2>
        </div>
        <div style="height:20px;"></div>
    <div id="no-more-tables" style="padding-top:20px;">

		<form>
			<div class="col-md-2"></div>
			<div class="col-md-2" style="font-weight:bold;" align="right">Search By
			</div>
            <div class="col-md-2" style="width:17%;">
                <select name="colname" class="form-control">

                    <option selected="selected">Select</option>

                    <option value="school_id"
					<?php if (($_GET['colname']) == "school_id") {
                            echo $_GET['colname']; ?> selected="selected" <?php } ?>>School ID</option>

					<option value="school_name"
					<?php if (($_GET['colname']) == "school_name") {
                            echo $_GET['colname']; ?> selected="selected" <?php } ?>>School Name</option>

					<option value="name"
					<?php if (($_GET['colname']) == "name") {
                            echo $_GET['colname']; ?> selected="selected" <?php } ?>>School Head</option>  

					<option value="email"
					<?php if (($_GET['colname']) == "email") {
                            echo $_GET['colname']; ?> selected="selected" <?php } ?>>Email</option>  

					<option value="group_type"
					<?php if (($_GET['colname']) == "group_type") {
                            echo $_GET['colname']; ?> selected="selected" <?php } ?>>Group Type</option> 

					<option value="school_type"
					<?php if (($_GET['colname']) == "school_type") {
                            echo $_GET['colname']; ?> selected="selected" <?php } ?>>School Type</option>

					<option value="reg_date"
					<?php if (($_GET['colname']) == "reg_date") {
                            echo $_GET['colname']; ?> selected="selected" <?php } ?>>Reg.Date</option>  

					<option value="lat"
					<?php if (($_GET['colname']) == "lat") {
                            echo $_GET['colname']; ?> selected="selected" <?php } ?>>Latitude</option>  

					<option value="lon"
					<?php if (($_GET['colname']) == "lon") {
                            echo $_GET['colname']; ?> selected="selected" <?php } ?>>Longitude</option>   

                </select>
			</div>
			<div class="col-md-2" style="width:17%;">
				<input type="text" class="form-control" name="Search" value="<?php echo $searchq; ?>" placeholder="Search.." required> 
			</div>
			<div class="col-md-1">
			<button type="submit" value="Search" class="btn btn-primary">Search</button>
			</div>
			<div class="col-md-1">
			<input type="button" class="btn btn-danger" value="Reset" onclick="window.open('cookie_list_school.php','_self')" />
			</div>	
        </form>

		<div id="show" style="margin-top: 70px;">
			<?php /* if (!($_GET['Search']))
			{   
				if ($limit >$total_records){ $limit=$total_records;}
				echo "<font color='blue' style='margin-left: 29px;'><b style='margin-left:400px;'>Now showing ".($start_from +1)." to ".($limit)." records out of ".($total_records). " records.</b></font>";
		    }else
			{
				if ($limit >$total_records){ $limit=$total_records;}
				echo "<font color='blue' style='margin-left: 29px;'><b style='margin-left:400px;'>Now showing ".($start_from +1)." to ".($limit)." records out of ".($total_records). " records.</b></font>";
			} */
			?>
		</div> 






			  <?php /* 
				$sql = "SELECT COUNT(id) FROM `tbl_school_admin` where `school_id`!='' ";   
				$rs_result = mysql_query($sql);  
				$row1 = mysql_fetch_row($rs_result);  
				$total_records = $row1[0];  
				$total_pages = ceil($total_records / $limit);  
				if($total_pages == $_GET['page']){
					$limit = $total_records;
				}else{
					$limit = $start_from + $limit;
					}
				$pagLink = "<div class='pagination'>"; 
				for ($i=1; $i<=$total_pages; $i++) { 
					$mypage = !empty($_GET['page'])?$_GET['page']:1;
					if($i == $mypage){
							$class = 'active';
							$selected = "selected";
							$pagLink .= "<option value='cookie_list_school.php?page=".$i."'".$selected." >  ".$i.''." </option> ";
					}else{
						$class = '';
        				$pagLink .= "<option value='cookie_list_school.php?page=".$i."'>  ".$i.''." </option> "; 
						}		   
				};
				echo "<div class='pagination'>";
				echo "<p style='margin-left: 105px;
    				margin-bottom: 21px;'><font color='blue'><b>Go to page number</font></p>";
				echo "<form><select onchange='location = this.value;' style='margin-left: 240px;
    				margin-top: -41px;'>";
				echo $pagLink . "</div>";
				echo "</select></form></div>"; 
				echo "<div id='record' style='margin-top: -62px;
    				margin-left: 523px;color:blue'>Now showing ".($start_from +1)." to ".($limit)." records out of ".$total_records. " records.</div></b>";
				 */?>

				<!-- <form>
					<div style="margin-left: 1000px;margin-top: 10px;">
						<input type="text" name="Search" placeholder="Search..">
						<input type="submit" value="Search">
					</div>
				</form> -->
					<?php
						if (isset($_GET['Search']))
						{
							$count=mysql_num_rows($query1);
							if($count == 0){
								echo "<script>$('#show').css('display','none');</script><div style='margin-top:66px;'><font color='Red' style='margin-left: 29px;'><b style='margin-left:490px;'><b>There Was No Search Result</b></font></div>";
							}else{
							
								/* $searchq=$_GET['Search'];
								$query1=mysql_query(" SELECT id,school_id,school_name,name,school_name,email,group_type,school_type,reg_date FROM `tbl_school_admin` where 
								`school_id`!='' AND
								id LIKE '%$searchq%' or
								school_id LIKE '%$searchq%' or
								school_name LIKE '%$searchq%' or
								name LIKE '%$searchq%' or
								school_name LIKE '%$searchq%' or
								email LIKE '%$searchq%' or
								group_type LIKE '%$searchq%' or
								school_type LIKE '%$searchq%' or
								reg_date LIKE '%$searchq%'
								order by id desc") or die("could not Search!");
								$count=mysql_num_rows($query1);
								if($count == 0){
									echo "There Was No Search Result"; */
								?>	
									<table id="example" class="table-bordered table-striped ">
										<thead>
										<tr bgcolor="#694489" style="color:white"><!--style="background-color: #ddd"-->
											<th>Sr. No.</th>
											<th>School ID</th>
											<th>School Name</th>
											<th>School Head</th>
											<th>Email</th>
											<th>Group Type</th>
											<th>School Type</th>
											<th>Latitude</th>
											<th>Longitude</th>
											<th>Reg Date</th>
											<th>Edit</th>
											<th>Delete</th>
										</tr>
										</thead>
										<?php $i=($start_from +1);
												while($result=mysql_fetch_array($query1)){
												$id=$result['id'];
												$school_id=$result['school_id'];?>
												<tr>
												<td><?php echo $i;   ?></td>
												<td><?php echo $school_id;?></td>
												<td><?php echo ucwords($result['school_name']);?></td>
												<td><?php echo ucwords($result['name']);?></td>
												<td><?php echo $result['email'];?></td>
												<td><?php echo $result['group_type'];?></td>
												<td><?php echo $result['school_type'];?></td>
												<td><?php echo $result['lat'];?></td>
												<td><?php echo $result['lon'];?></td>
												<td><?php echo $result['reg_date'];?></td>
												<td><a href="cookie_edit_school.php?s_id=<?php echo $result['id']; ?>"><span class="glyphicon glyphicon-pencil"></span></a></td>
												<td><a style="cursor: pointer" onclick="confirmation(<?php echo $id; ?>)"><span class="glyphicon glyphicon-trash"></span></a></td>
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
								<table id="example" class="table-bordered table-striped ">
									<thead>
        							<tr bgcolor="#694489" style="color:white"><!--style="background-color: #ddd"-->
                						<th>Sr. No.</th>
                   						<th>School ID</th>
                    					<th>School Name</th>
                    					<th>School Head</th>
                    					<th>Email</th>
										<th>Group Type</th>
										<th>School Type</th>
										<th>Latitude</th>
										<th>Longitude</th>
                    					<th>Reg Date</th>
                     					<th>Edit</th>
                     					<th>Delete</th>
									</tr>
               						</thead>
									<?php $i=($start_from +1);
			 			
 											while($result=mysql_fetch_array($row)){
 											$id=$result['id'];
 											$school_id=$result['school_id'];?>
											<tr>
												<td><?php echo $i;   ?></td>
												<td><?php echo $school_id;?></td>
												<td><?php echo ucwords($result['school_name']);?></td>
												<td><?php echo ucwords($result['name']);?></td>
												<td><?php echo $result['email'];?></td>
												<td><?php echo $result['group_type'];?></td>
												<td><?php echo $result['school_type'];?></td>
												<td><?php echo $result['lat'];?></td>
												<td><?php echo $result['lon'];?></td>
												<td><?php echo $result['reg_date'];?></td>
												<td><a href="cookie_edit_school.php?s_id=<?php echo $result['id']; ?>"><span class="glyphicon glyphicon-pencil"></span></a></td>
												<td><a style="cursor: pointer" onclick="confirmation(<?php echo $id; ?>)"><span class="glyphicon glyphicon-trash"></span></a></td>
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
				?>
            </div>
		</div>
	</div>
</body>
</html>
