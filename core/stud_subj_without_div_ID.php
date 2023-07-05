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
//page created by kalyani (Nagpur Intern)
if (!($_GET['Search']))  
{
	if (isset($_GET["page"])){ $page  = mysql_real_escape_string($_GET["page"]); } else { $page=1; }; 
	
	$start_from = ($page-1) * $limit;

	$query=mysql_query("SELECT Stud_Member_Id,ExtSemesterId,subjectName,student_id,subjcet_code,Division_id
						FROM tbl_student_subject_master 
						WHERE (Division_id = '' OR Division_id is NULL)
							AND school_id = '$school_id' and AcademicYear='$Academic_Year'
						LIMIT $start_from, $limit") or die("could not Search!");;
 
	$sql1=" SELECT id,Stud_Member_Id,ExtSemesterId,subjectName,student_id,subjcet_code,Division_id
			FROM tbl_student_subject_master 
			WHERE (Division_id = '' OR Division_id is NULL)
			AND school_id = '$school_id' and AcademicYear='$Academic_Year' ";

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
			$query1=mysql_query("SELECT Stud_Member_Id,ExtSemesterId,subjectName,student_id,subjcet_code,Division_id
								FROM tbl_student_subject_master 
								WHERE (Division_id = '' OR Division_id is NULL)
									AND school_id = '$school_id' and AcademicYear='$Academic_Year'
									AND `$colname` LIKE '%$searchq%' LIMIT $start_from, $limit") or die("could not Search!");

				$sql1 =mysql_query("SELECT id,Stud_Member_Id,ExtSemesterId,subjectName,student_id,subjcet_code,Division_id
				                	FROM tbl_student_subject_master 
									WHERE (Division_id = '' OR Division_id is NULL)
										AND school_id = '$school_id' and AcademicYear='$Academic_Year'
										AND `$colname` LIKE '%$searchq%' ") or die("could not Search!");

				$total_records = mysql_num_rows($sql1);   
				$total_pages = ceil($total_records / $limit);
		}else{	
				$query1=mysql_query("SELECT Stud_Member_Id,ExtSemesterId,subjectName,student_id,subjcet_code,Division_id
									FROM tbl_student_subject_master 
									WHERE (Division_id = '' OR Division_id is NULL)
										AND school_id = '$school_id' and AcademicYear='$Academic_Year'
										AND (Stud_Member_Id LIKE '$searchq%' or ExtSemesterId LIKE '$searchq%' or Division_id LIKE '$searchq%' or subjcet_code LIKE '$searchq%' or subjectName LIKE '$searchq%'  or student_id LIKE '$searchq%' ) LIMIT $start_from, $limit") or die("could not Search!");
			
				$sql1 =mysql_query("SELECT id,Stud_Member_Id,ExtSemesterId,subjectName,student_id,subjcet_code,Division_id
									FROM tbl_student_subject_master 
									WHERE (Division_id = '' OR Division_id is NULL)
										AND school_id = '$school_id' and AcademicYear='$Academic_Year'
										AND (Stud_Member_Id LIKE '$searchq%' or Division_id LIKE '$searchq%' ExtSemesterId LIKE '$searchq%' or or subjcet_code LIKE '$searchq%' or subjectName LIKE '$searchq%'  or student_id LIKE '$searchq%' ) ") or die("could not Search!");   
				
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

//$result = mysql_query("SELECT Parent_Member_id,Father_name,std_PRN,Name,Father_name,Mother_name FROM  tbl_parent where (Father_name ='' or Father_name = null) AND school_id = '$school_id' and AcademicYear='$Academic_Year'");
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
  <script src="https://cdn.datatables.net/1.10.9/js/dataTables.bootstrap.min.js"></script>
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
				window.location.assign('stud_subj_without_div_ID.php?page='+page);
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
				window.location.assign('stud_subj_without_div_ID.php?colname=<?php echo $colname;?>&Search=<?php echo $searchq; ?>&spage='+page);
	});
	});
</script>
<?php }?>




</head>
<body>

	<div class="container">
		<div style="padding-top:30px" align="center" >
        		<h2 style="padding-left:20px;padding-top:10px;padding-bottom:10px;background-color:#428BCA; margin-top:2px;color:#666;color:white">Student Subject Data without Division ID (<?php echo $total_records; ?>)</h2>
		</div>
		<div  style=" height:30px; padding:10px;"></div>
<!-- academic year dropdown -->	 
<form method="post" id="empActivity"> 	
<?php $date = date('Y'); ?>

<div style="padding-top:30px;" align="left">
<a href="data_quality_student_subject.php" style="text-decoration:none;"><input type="button" class="btn btn-danger" name="Back" value="Back" style="width:80px;font-weight:bold;font-size:14px;"/></a>
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
			
			<div class="col-md-2"></div>
			<div class="col-md-2" style="font-weight:bold;" align="right">Search By</div>
            <div class="col-md-2" style="width:17%;">
                <select name="colname" class="form-control">
                    <option selected="selected">Select</option>
					
					<option value="Stud_Member_Id"
					<?php if (($_GET['colname']) == "Stud_Member_Id") {
                            echo $_GET['colname']; ?> selected="selected" <?php } ?>>Student Member ID</option>

					<option value="ExtSemesterId"
					<?php if (($_GET['colname']) == "ExtSemesterId") {
                            echo $_GET['colname']; ?> selected="selected" <?php } ?>>External Semester ID</option>
                
					<option value="subjectName"
					<?php if (($_GET['colname']) == "subjectName") {
                            echo $_GET['colname']; ?> selected="selected" <?php } ?>>Subject Name</option>
					
					<option value="student_id"
					<?php if (($_GET['colname']) == "student_id") {
                            echo $_GET['colname']; ?> selected="selected" <?php } ?>>Student ID</option>
				
				</select>
			</div>
			<div class="col-md-2" style="width:17%;">
				<input type="text" class="form-control" name="Search" value="<?php echo $searchq; ?>" placeholder="Search.." required> 
			</div>
			<div class="col-md-1">
			<button type="submit" value="Search" class="btn btn-primary">Search</button>
			</div>
			<div class="col-md-1">
			<input type="button" class="btn btn-danger" value="Reset" onclick="window.open('stud_subj_without_div.php','_self')" />
			</div>

        </form>
		<br>
		<br>
		<br>
		<br>
		<!-- search form END -->

		<!-- message display START -->
		
		<!-- message display END -->


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
							<th>Student Member ID</th>
							<th>External Semester ID</th>
							<th>Subject Name</th>
							<th>Student ID</th>
							
							<th>Division ID</th>
							<th style="width:10%;"><center>Edit</center></th>
							</tr>
						</thead>
						<tbody>
							<?php
								$i =  ($start_from +1);
								while ($row= mysql_fetch_array($query1)){
								$id=$row['id'];		
							?>
								<tr>
									<td><center>
											<?php echo $i; ?>
										</center>
									</td>
									<td><?php echo $row['Stud_Member_Id']; ?></td>
									<td><?php echo $row['ExtSemesterId']; ?></td>
									<td><?php echo $row['subjectName']; ?></td>
									<td><?php echo $row['student_id']; ?></td>
									
									<td><?php echo $row['Division_id']; ?></td>
									<td> <center>
                     						<a style="cursor: pointer;" href="edit_student_subject_data_quality.php?id=<?php echo $row['id']; ?>&FLAG=Division" ><span class="glyphicon glyphicon-pencil"></span></a>
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
			
			<?php } 
		}
		else
		{
		?>

				<div id="no-more-tables" style="padding-top:20px;">
					<table id="example" class="display" width="100%" cellspacing="0">
						<thead style="background-color:#FFFFFF;">
											
							<tr>
							<th style="width:10px;">Sr.No.</th>
							<th>Student Member ID</th>
							<th>External Semester ID</th>
							<th>Subject Name</th>
							<th>Student ID</th>
							
							<th>Division ID</th>
							<th style="width:10%;"><center>Edit</center></th>
							</tr>
						</thead>
						<tbody>
							<?php
								$i =  ($start_from +1);
								while ($row= mysql_fetch_array($query)){
								$id=$row['id'];
							?>
								<tr>
									<td>
										<center>
											<?php echo $i; ?>
										</center>
									</td>
									<td><?php echo $row['Stud_Member_Id']; ?></td>
									<td><?php echo $row['ExtSemesterId']; ?></td>
									<td><?php echo $row['subjectName']; ?></td>
									<td><?php echo $row['student_id']; ?></td>
									
									<td><?php echo $row['Division_id']; ?></td>
									<td> <center>
                     						<a style="cursor: pointer;" href="edit_student_subject_data_quality.php?id=<?php echo $row['id']; ?>&FLAG=Division" ><span class="glyphicon glyphicon-pencil"></span></a>
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

		<?php } ?>
		</div>
	</div>
</div>
</body>
</html>