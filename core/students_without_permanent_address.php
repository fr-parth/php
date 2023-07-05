<?php
include_once("scadmin_header.php");
$results = $smartcookie->retrive_individual($table, $fields);
$result = mysql_fetch_array($results);
$school_id = $result['school_id'];
$limit = $webpagelimit; 
$Academic_Year= $_SESSION["Ac_Year"];
if(isset($_POST['submit'])){
    $Academic_Year = $_POST['ac_year']; 
    
}
// page Created by Ajinkya (Nagpur Intern)
if (!($_GET['Search']))  
{
	if (isset($_GET["page"])){ $page  = mysql_real_escape_string($_GET["page"]); } else { $page=1; }; 
	//if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };  
	
	$start_from = ($page-1) * $limit;

	$query=mysql_query("SELECT std_PRN, std_complete_name, std_semester, std_class, std_div, parent_id, permanent_address, std_email, std_phone FROM tbl_student 
						where (permanent_address is null or permanent_address = ' ') and school_id='$school_id' and Academic_Year='$Academic_Year'
						LIMIT $start_from, $limit") or die("die could not Search!");;
 
	$sql1="SELECT id FROM tbl_student 
			where (permanent_Address is null or permanent_address = ' ') and school_id='$school_id' and Academic_Year='$Academic_Year' ";
			
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
			$query1=mysql_query(" SELECT std_PRN, std_complete_name, std_semester, std_class, std_div, parent_id, permanent_address, std_email, std_phone FROM tbl_student 
									WHERE (permanent_address ='' or permanent_address is null ) 
									AND  School_ID='$school_id' and Academic_Year='$Academic_Year'
									AND `$colname` LIKE '%$searchq%' LIMIT $start_from, $limit") or die("could not Search!");

				$sql1 =mysql_query("SELECT id FROM tbl_student 
									WHERE  (permanent_address ='' or permanent_address is null ) 
									AND School_ID='$school_id' and Academic_Year='$Academic_Year'
									AND `$colname` LIKE '%$searchq%' ") or die("could not Search!");
				$total_records = mysql_num_rows($sql1);   
				$total_pages = ceil($total_records / $limit);
		}else{	
				$query1=mysql_query("SELECT std_PRN, std_complete_name, std_semester, std_class, std_div, parent_id, permanent_address, std_email, std_phone FROM tbl_student 
									WHERE (permanent_address ='' or permanent_address is null ) 
									AND  School_ID='$school_id' and Academic_Year='$Academic_Year'
									AND (std_complete_name LIKE '%$searchq%' or std_email LIKE '%$searchq%' or parent_id LIKE '%$searchq%' ) LIMIT $start_from, $limit") or die("could not Search!");
			
				$sql1 =mysql_query("SELECT id FROM tbl_student 
									WHERE (permanent_address ='' or permanent_address is null ) 
									AND  School_ID='$school_id' and Academic_Year='$Academic_Year'
									AND (std_complete_name LIKE '%$searchq%' or std_email LIKE '%$searchq%' or parent_id LIKE '%$searchq%' )") or die("could not Search!");   
				
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
				window.location.assign('students_without_permanent_address.php?page='+page);
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
				window.location.assign('students_without_permanent_address.php?colname=<?php echo $colname;?>&Search=<?php echo $searchq; ?>&spage='+page);
    		});
		});
   </script>
<?php }?>

</head>
<body>

<!-- Headline -->
	<div class="container">
			<div style="padding-top:30px" align="center" >
        		<h2 style="padding-left:20px;padding-top:10px;padding-bottom:10px;background-color:#428BCA; margin-top:2px;color:#666;color:white"><?php echo $dynamic_student ;?> Data without Permanent Address (<?php echo $total_records; ?>)</h2>
			</div
			<div  style=" height:30px; padding:10px;"></div>


<!-- academic year dropdown -->	 
<form method="post" id="Academic_Year" name="Academic_Year"> 	
<?php $date = date('Y'); ?>

<div style="padding-top:30px;" align="left">
<a href="data_quality_student.php" style="text-decoration:none;"><input type="button" class="btn btn-danger" name="Back" value="Back" style="width:80px;font-weight:bold;font-size:14px;"/></a>
</div>
<div class="row" style="padding-top:30px;"></div>
<?php
$acyear=mysql_query("SELECT * FROM tbl_academic_Year where school_id='$school_id' and Enable='1'");
$result=mysql_fetch_array($acyear);
?>
<div class="input-group" style="display:flex; flex-direction: row; justify-content: center; align-items: center" >
Academic Year<select name="ac_year" id="ac_year" style="width:200px;margin-left:50px;" class="form-control" >&nbsp;&nbsp;&nbsp;
<option value="<?php echo $result['Academic_Year'];?>" selected="selected" ><?php echo $result['Academic_Year'];?></option>

<?php 
$acyear2=mysql_query("SELECT * FROM tbl_academic_Year where school_id='$school_id' ");
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
					
					<option value="std_email"
					<?php if (($_GET['colname']) == "std_email") {
                            echo $_GET['colname']; ?> selected="selected" <?php } ?>>Email Id</option>

					<option value="std_complete_name"
					<?php if (($_GET['colname']) == "std_complete_name") {
                            echo $_GET['colname']; ?> selected="selected" <?php } ?>><?php echo $dynamic_student ;?>Name</option>  
                </select>
			</div>
			<div class="col-md-2" style="width:17%;">
				<input type="text" class="form-control" name="Search" value="<?php echo $searchq; ?>" placeholder="Search.." required> 
			</div>
			<div class="col-md-1">
			<button type="submit" value="Search" class="btn btn-primary">Search</button>
			</div>
			<div class="col-md-1">
			<input type="button" class="btn btn-danger" value="Reset" onclick="window.open('students_without_permanent_address.php','_self')" />
			</div>	
        </form>
		<!-- search form END -->	
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
							<th>Sr.No.</th>
							<th><?php echo $dynamic_student ;?> <?php echo $dynamic_student_prn ;?></th>
							<th><?php echo $dynamic_student ;?> Name</th>
							<th><?php echo $dynamic_semester ;?></th>
							<th><?php echo $dynamic_class ;?></th>
							<th><?php echo $designation ;?></th>
							<?php if ($school_type == 'school' && $user=='School Admin'){?>
							<th>Parent Id</th>
							<?php }?>
							<th>Email Id</th>
							<th>Phone No.</th>
							<th>Permanent Address</th>
							<th>Edit</th>
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
							<td data-title="std_PRN"><?php echo $row['std_PRN']; ?> </td> 
							<td data-title="std_complete_name" ><?php echo $row['std_complete_name']; ?></td>
							<td data-title="std_semester" ><?php echo $row['std_semester']; ?></td>
							<td data-title="std_class" ><?php echo $row['std_class']; ?></td>
							<td data-title="std_div" ><?php echo $row['std_div']; ?></td>
							<?php if ($school_type == 'school' && $user=='School Admin'){?>
							<td data-title="parent_id" ><?php echo $row['parent_id']; ?></td>
							<?php }?>
							<td data-title="std_email"><?php echo $row['std_email']; ?></td>
							<td data-title="std_phone"><?php echo $row['std_phone']; ?></td>
							<td data-title="permanent_address"><?php echo $row['permanent_address']; ?></td>
							<td>
                     			<a style="cursor: pointer;" href="edit_student_data_quality.php?std_prn=<?php echo $row['std_PRN']; ?>&flag=perm_address#id_address"><span class="glyphicon glyphicon-pencil"></span></a>
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
		

	<?php 
	
	} 
		}
		else
		{
			
		?>


			<table id="example" class="display" width="100%" cellspacing="0">
					<thead style="background-color:#FFFFFF;">
									
						<tr><!-- Camel casing done for Member ID and School ID by Pranali-->
						<th>Sr.No.</th>
						<th><?php echo $dynamic_student ;?> <?php echo $dynamic_student_prn ;?></th>
							<th><?php echo $dynamic_student ;?> Name</th>
							<th><?php echo $dynamic_semester ;?></th>
							<th><?php echo $dynamic_class ;?></th>
							<th><?php echo $designation ;?></th>
							<?php if ($school_type == 'school' && $user=='School Admin'){?>
							<th>Parent Id</th>
							<?php }?>
							<th>Email Id</th>
							<th>Phone No.</th>
							<th>Permanent Address</th>
							<th>Edit</th>

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
						<td data-title="std_PRN"><?php echo $row['std_PRN']; ?> </td>
							<td data-title="std_complete_name" ><?php echo $row['std_complete_name']; ?></td>
							<td data-title="std_semester" ><?php echo $row['std_semester']; ?></td>
							<td data-title="std_class" ><?php echo $row['std_class']; ?></td>
							<td data-title="std_div" ><?php echo $row['std_div']; ?></td>
							<?php if ($school_type == 'school' && $user=='School Admin'){?>
							
							<td data-title="parent_id" ><?php echo $row['parent_id']; ?></td>
							<?php }?>
							<td data-title="std_email"><?php echo $row['std_email']; ?></td>
							<td data-title="std_phone"><?php echo $row['std_phone']; ?></td>
							<td data-title="permanent_address"><?php echo $row['permanent_address']; ?></td>
							<td>
                     			<a style="cursor: pointer;" href="edit_student_data_quality.php?std_prn=<?php echo $row['std_PRN']; ?>&flag=perm_address#id_address"><span class="glyphicon glyphicon-pencil"></span></a>
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

		<?php 
		
		
	}
	 ?> 
	</div>
	

</body>
</html>