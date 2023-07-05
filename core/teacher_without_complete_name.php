<?php
include_once("scadmin_header.php");
$results = $smartcookie->retrive_individual($table, $fields);
$result = mysql_fetch_array($results);
$Academic_Year= $_SESSION["Ac_Year"];
$school_id = $result['school_id'];
if(isset($_POST['submit'])){
    $Academic_Year = $_POST['ac_year']; 
}
$limit = $webpagelimit; 
// page Created by Ajinkya (Nagpur Intern)
if (!($_GET['Search']))  
{
	if (isset($_GET["page"])){ $page  = mysql_real_escape_string($_GET["page"]); } else { $page=1; }; 
	//if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };  
	
	$start_from = ($page-1) * $limit;

	$query=mysql_query("SELECT t_id, t_complete_name, t_email, t_phone, t_city FROM tbl_teacher 
						where (t_complete_name is null or t_complete_name = '') and (t_emp_type_pid =133 OR t_emp_type_pid=134  or t_emp_type_pid=135 or t_emp_type_pid=137)  and school_id='$school_id' and t_academic_year='$Academic_Year' 
						LIMIT $start_from, $limit") or die("die could not Search!");;
 
	$sql1=" SELECT id FROM tbl_teacher 
			where (t_complete_name is null or t_complete_name = ' ') and (t_emp_type_pid =133 OR t_emp_type_pid=134  or t_emp_type_pid=135 or t_emp_type_pid=137) and school_id='$school_id' and t_academic_year='$Academic_Year' ";

			

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
			$query1=mysql_query(" SELECT t_id, t_complete_name, t_email, t_phone, t_city  FROM tbl_teacher 
									WHERE (t_complete_name is null or t_complete_name = '')
                                    AND (t_emp_type_pid =133 OR t_emp_type_pid=134  or t_emp_type_pid=135 or t_emp_type_pid=137) 
									AND  school_id='$school_id' and t_academic_year='$Academic_Year' 
									AND `$colname` LIKE '%$searchq%' LIMIT $start_from, $limit") or die("could not Search!");

				$sql1 =mysql_query("SELECT id FROM tbl_teacher 
									WHERE  (t_complete_name ='' or t_complete_name is null ) 
                                    AND (t_emp_type_pid = 133 OR t_emp_type_pid = 134  or t_emp_type_pid=135 or t_emp_type_pid=137)
									AND school_id='$school_id' and t_academic_year='$Academic_Year' 
									AND `$colname` LIKE '%$searchq%' ") or die("could not Search!");
				$total_records = mysql_num_rows($sql1);   
				$total_pages = ceil($total_records / $limit);
		}else{	
				$query1=mysql_query("SELECT t_id, t_complete_name, t_email, t_phone, t_city FROM tbl_teacher 
									WHERE (t_complete_name ='' or t_complete_name is null) 
                                    AND (t_emp_type_pid = 133 OR t_emp_type_pid = 134  or t_emp_type_pid=135 or t_emp_type_pid=137)
									AND  school_id='$school_id' and t_academic_year='$Academic_Year' 
									AND (t_complete_name LIKE '%$searchq%' or t_email LIKE '%$searchq%') LIMIT $start_from, $limit") or die("could not Search!");
			
				$sql1 =mysql_query("SELECT id FROM tbl_teacher 
									WHERE (t_complete_name ='' or t_complete_name is null) 
									AND (t_emp_type_pid = 133 OR t_emp_type_pid = 134  or t_emp_type_pid=135 or t_emp_type_pid=137)
									AND  school_id='$school_id' and t_academic_year='$Academic_Year' 
									AND (t_complete_name LIKE '%$searchq%' or t_email LIKE '%$searchq%')") or die("could not Search!");   
				
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

/* tr:nth-child(even) {
    background-color: #dddddd;
} */

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
				window.location.assign('teacher_without_complete_name.php?page='+page);
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
				window.location.assign('teacher_without_complete_name.php?colname=<?php echo $colname;?>&Search=<?php echo $searchq; ?>&spage='+page);
    		});
		});
   </script>
<?php }?>

</head>
<body>

<!-- Headline -->
	<div class="container">
			<div style="padding-top:30px" align="center" >
        		<h2 style="padding-left:20px;padding-top:10px;padding-bottom:10px;background-color:#428BCA; margin-top:2px;color:#666;color:white"><?php echo $dynamic_teacher;?> Data without Complete Name (<?php echo $total_records; ?>)</h2>
			</div>
			<div  style=" height:30px; padding:10px;"></div>


<!-- academic year dropdown -->	 
<form method="post" id="empActivity"> 	
<?php $date = date('Y'); ?>

<div style="padding-top:30px;" align="left">
<a href="data_quality_teacher.php" style="text-decoration:none;"><input type="button" class="btn btn-danger" name="Back" value="Back" style="width:80px;font-weight:bold;font-size:14px;"/></a>
</div>
<div class="row" style="padding-top:30px;"></div>
<?php
$acyear=mysql_query("SELECT * FROM tbl_academic_Year where school_id='$school_id' and Enable='1' ");
$result=mysql_fetch_array($acyear);
?>
<div class="input-group" style="display:flex; flex-direction: row; justify-content: center; align-items: center" >
Academic Year<select name="ac_year" id="ac_year" style="width:200px;margin-left:50px;" class="form-control" >&nbsp;&nbsp;&nbsp;
<option value="<?php echo $result['Academic_Year'];?>" selected="selected" ><?php echo $result['Academic_Year'];?></option>

<?php 
$acyear2=mysql_query("SELECT * FROM tbl_academic_Year where school_id='$school_id'");
while($result1 = mysql_fetch_array($acyear2)){ ?>
<option value="<?php echo $result1['Academic_Year']; ?>"  <?php if($result1['Academic_Year']==$Academic_Year){?> selected="selected" <?php }?>><?php echo $result1['Academic_Year']; ?></option>
<?php  }?>

</select>
<span class="input-group-btn">
<button type="submit" name="submit" style="margin-left: 100px;" value="Submit" class="btn btn-success">Submit</button>
</span>
</div>
</form>
<!--End of dropdown ----------------------- --- -->

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
					
					<option value="t_email"
					<?php if (($_GET['colname']) == "t_email") {
                            echo $_GET['colname']; ?> selected="selected" <?php } ?>>Email Id</option>

					<option value="t_complete_name"
					<?php if (($_GET['colname']) == "t_complete_name") {
                            echo $_GET['colname']; ?> selected="selected" <?php } ?>>Teacher's Name</option>  
                </select>
			</div>
			<div class="col-md-2" style="width:17%;">
				<input type="text" class="form-control" name="Search" value="<?php echo $searchq; ?>" placeholder="Search.." required> 
			</div>
			<div class="col-md-1">
			<button type="submit" value="Search" class="btn btn-primary">Search</button>
			</div>
			<div class="col-md-1">
			<input type="button" class="btn btn-danger" value="Reset" onclick="window.open('teacher_without_complete_name.php','_self')" />
			</div>	
        </form>
		<br><br><br><br>
		<!-- search form END -->	
		
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
									
						<tr><!-- Camel casing done for Member ID and School ID by Pranali-->
							<th width = "10px">Sr.No.</th>
							
							<th>Complete Name</th>
							<th>Email id</th>
							<th>Phone</th>
                            
                            <th>City</th>
							<th style="width:10%;" ><center>Edit</center></th>
						</tr>
					</thead>
					<tbody>
					 	<?php
							$i = ($start_from +1);
							while ($row= mysql_fetch_array($query1)){
							//$id=$row['id'];
							//echo "select t_complete_name where id='$id'";
							//$q=mysql_query("select Email_Id from tbl_department_master where id='$id'");
							//$result1=mysql_fetch_array($q);
						
					 	?>
						<tr>
							<td data-title="Sr.No." ><?php echo $i; ?></td>
							
							<td data-title="t_complete_name" ><?php echo $row['t_complete_name']; ?></td>
                            <td data-title="t_email" ><?php echo $row['t_email']; ?></td>
							<td data-title="t_phone" ><?php echo $row['t_phone']; ?></td>
                            	
                            <td data-title="t_city" ><?php echo $row['t_city']; ?></td>
							<td> <center>
                     			<a style="cursor: pointer;" href="edit_teacher_data_quality.php?t_id=<?php echo $row['t_id']; ?>&flag=name"><span class="glyphicon glyphicon-pencil"></span></a>
								</center>
							</td>
						</tr>
						<?php $i++;} ?>     
					</tbody>
				</table>
				
			</div>
			<!--pagination line of now showing records added by Sayali Balkawade on 30-12-2019 for SMC-3628 -->
			<div align=left>
		 		<?php if (!($_GET['Search']))
		 			{
		 				if ($limit >$total_records){ $limit=$total_records;}
		 				echo "<div style='margin-top:5px;margin-left:30px;'><font color='#0073BD'><style='margin-left:600px;'>Now showing ".($start_from +1)." to ".($limit)." records out of ".$total_records. " records.</font></style></div>";
		    }else
		 			{
		 				if ($limit >$total_records){ $limit=$total_records;}
		 				echo "<div style='margin-top:5px;margin-left:30px;'><font color='#0073BD'><style='margin-left:600px;'>Now showing ".($start_from +1)." to ".($limit)." records out of ".($total_records). " records.</font></style></div>";
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


			<table id="example" class="display" width="100%" cellspacing="0">
					<thead style="background-color:#FFFFFF;">
									
						<tr><!-- Camel casing done for Member ID and School ID by Pranali-->
						<th width = "10px">Sr.No.</th>
						
						<th>Complete Name</th>
							<th>Email id</th>
							<th>Phone</th>
                            
                            <th>City</th>
							<th style="width:10%;" ><center>Edit</center></th>
						</tr>
					</thead>
					<tbody>
					 	<?php
							$i = ($start_from +1);
							while ($row= mysql_fetch_array($query)){
							//$id=$row['id'];
							//echo "select t_complete_name where id='$id'";
							//$q=mysql_query("select Email_Id from tbl_department_master where id='$id'");
							//$result1=mysql_fetch_array($q);
						
					 	?>
						<tr>
						<td data-title="Sr.No." ><?php echo $i; ?></td>
						
                        <td data-title="t_complete_name" ><?php echo $row['t_complete_name']; ?></td>
                            <td data-title="t_email" ><?php echo $row['t_email']; ?></td>
							<td data-title="t_phone" ><?php echo $row['t_phone']; ?></td>
                            		
                            <td data-title="t_city" ><?php echo $row['t_city']; ?></td>
							<td> <center>
                     			<a style="cursor: pointer;" href="edit_teacher_data_quality.php?t_id=<?php echo $row['t_id']; ?>&flag=contact"><span class="glyphicon glyphicon-pencil"></span></a>
								</center>
							</td>
						</tr>
						<?php $i++;} ?>     
					</tbody>
					
				</table>
			</div>
			
<!--pagination line of now showing records added by Sayali Balkawade on 30-12-2019 for SMC-3628 -->
			<div align=left>
		 		<?php if (!($_GET['Search']))
		 			{
		 				if ($limit >$total_records){ $limit=$total_records;}
		 				echo "<div style='margin-top:5px;margin-left:30px;'><font color='#0073BD'><style='margin-left:600px;'>Now showing ".($start_from +1)." to ".($limit)." records out of ".$total_records. " records.</font></style></div>";
		    }else
		 			{
		 				if ($limit >$total_records){ $limit=$total_records;}
		 				echo "<div style='margin-top:5px;margin-left:30px;'><font color='#0073BD'><style='margin-left:600px;'>Now showing ".($start_from +1)." to ".($limit)." records out of ".($total_records). " records.</font></style></div>";
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
	

</body>
</html>