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
// page Created by Anamika (Nagpur Intern)
if (!($_GET['Search']))  
{
	if (isset($_GET["page"])){ $page  = mysql_real_escape_string($_GET["page"]); } else { $page=1; }; 
	//if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };  
	
	$start_from = ($page-1) * $limit;

	$query=mysql_query(" SELECT  ts.ExtSchoolSubjectId, ts.subjectName, ts.teacher_id, t.t_complete_name , ts.subjcet_code 
							FROM tbl_teacher t 
						JOIN tbl_teacher_subject_master ts ON ts.school_id =t.school_id AND ts.teacher_id=t.t_id 
						WHERE (ts.subjectName ='' or ts.subjectName is null ) 
						AND ts.school_id = '$school_id' and ts.AcademicYear='$Academic_Year' 
						LIMIT $start_from, $limit") or die("could not Search!");;
 
	$sql1=" SELECT ts.tch_sub_id 
			FROM tbl_teacher t 
				JOIN tbl_teacher_subject_master ts 
				ON ts.school_id =t.school_id AND ts.teacher_id=t.t_id 
			WHERE (ts.subjectName ='' or ts.subjectName is null ) 
			AND ts.school_id = '$school_id' and ts.AcademicYear='$Academic_Year' ";

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
			$query1=mysql_query(" SELECT  ts.ExtSchoolSubjectId, ts.subjectName, ts.teacher_id, t.t_complete_name , ts.subjcet_code 
									FROM tbl_teacher t 
								JOIN tbl_teacher_subject_master ts ON ts.school_id =t.school_id AND ts.teacher_id=t.t_id 
								WHERE (ts.subjectName ='' or ts.subjectName is null ) 
								AND ts.school_id = '$school_id' and ts.AcademicYear='$Academic_Year' 
									AND ts.$colname LIKE '%$searchq%' LIMIT $start_from, $limit") or die("could not Search!");

				$sql1 =mysql_query("SELECT tch_sub_id
				FROM tbl_teacher t 
				JOIN tbl_teacher_subject_master ts 
				ON ts.school_id =t.school_id AND ts.teacher_id=t.t_id 
			WHERE (ts.subjectName ='' or ts.subjectName is null ) 
			AND ts.school_id = '$school_id' and ts.AcademicYear='$Academic_Year' 
									AND ts.$colname LIKE '%$searchq%' ") or die("could not Search!");
				$total_records = mysql_num_rows($sql1);   
				$total_pages = ceil($total_records / $limit);
		}else{	
				$query1=mysql_query("SELECT  ts.ExtSchoolSubjectId, ts.subjectName, ts.teacher_id, t.t_complete_name , ts.subjcet_code 
										FROM tbl_teacher t 
									JOIN tbl_teacher_subject_master ts ON ts.school_id =t.school_id AND ts.teacher_id=t.t_id 
									WHERE (ts.subjectName ='' or ts.subjectName is null ) 
									AND ts.school_id = '$school_id' and ts.AcademicYear='$Academic_Year' 
									AND (ts.subjectName LIKE '$searchq%' or ts.ExtSchoolSubjectId LIKE '$searchq%' or ts.subjcet_code LIKE '%$searchq%'or ts.teacher_id LIKE '$searchq%'or t.t_complete_name LIKE '$searchq%' ) LIMIT $start_from, $limit") or die("could not Search!");
			
				$sql1 =mysql_query("SELECT tch_sub_id FROM tbl_teacher t 
				JOIN tbl_teacher_subject_master ts 
				ON ts.school_id =t.school_id AND ts.teacher_id=t.t_id 
			WHERE (ts.subjectName ='' or ts.subjectName is null ) 
			AND ts.school_id = '$school_id' and ts.AcademicYear='$Academic_Year'  
									AND (ts.subjectName LIKE '$searchq%' or ts.ExtSchoolSubjectId LIKE '$searchq%' or ts.subjcet_code LIKE '%$searchq%' or ts.teacher_id LIKE '%$searchq%'or t.t_complete_name LIKE '$searchq%')") or die("could not Search!");   
				
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

//$result = mysql_query("SELECT * FROM tbl_teacher_subject_master where(subjectName='' or subjectName is null ) and School_ID='$school_id'");
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
				window.location.assign('teacher_subject_without_subjectname.php?page='+page);
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
				window.location.assign('teacher_subject_without_subjectname.php?colname=<?php echo $colname;?>&Search=<?php echo $searchq; ?>&spage='+page);
    		});
		});
   </script>
<?php }?>

</head>
<body>

<!-- Headline -->
	<div class="container">
			<div style="padding-top:30px" align="center" >
        		<h2 style="padding-left:20px;padding-top:10px;padding-bottom:10px;background-color:#428BCA; margin-top:2px;color:#666;color:white"><?php echo $dynamic_teacher;?> <?php echo $dynamic_subject;?> Data <?php echo $dynamic_subject;?> Name</h2>
			</div>
			<div  style=" height:30px; padding:10px;"></div>

		<!-- search form -->

		<form method="post">
			<!-- <label for="from">From</label>
			<input type="text" id="from_date" name="from_date" placeholder="MM/DD/YYYY">
			<label for="to">to</label>

			<input type="text" id="to_date" name="to_date" placeholder="MM/DD/YYYY">
				 &nbsp;&nbsp;
 			<input type="submit" value="Search" name="search" id="search" /> -->
			 
			<div style="padding-top:30px;" align="left">
<a href="data_quality_teacher_subject.php" style="text-decoration:none;"><input type="button" class="btn btn-danger" name="Back" value="Back" style="width:80px;font-weight:bold;font-size:14px;"/></a>
</div>
			<div class="col-md-2"></div>
			<div class="col-md-2" style="font-weight:bold;" align="right">Search By</div>
            <div class="col-md-2" style="width:17%;">
                <select name="colname" class="form-control">
                    <option selected="selected">Select</option>
					
					<option value="ExtSchoolSubjectId"
					<?php if (($_GET['colname']) == "ExtSchoolSubjectId") {
                            echo $_GET['colname']; ?> selected="selected" <?php } ?>>Subject Id</option>

					<option value="subjcet_code"
					<?php if (($_GET['colname']) == "subjcet_code") {
                            echo $_GET['colname']; ?> selected="selected" <?php } ?>>Subject Code</option> 

					<option value="teacher_id"
					<?php if (($_GET['colname']) == "teacher_id") {
                            echo $_GET['colname']; ?> selected="selected" <?php } ?>>Teacher ID</option>

					<option value="t_complete_name"
					<?php if (($_GET['colname']) == "t_complete_name") {
                            echo $_GET['colname']; ?> selected="selected" <?php } ?>>Teacher Name</option>
                </select>
			</div>
			<div class="col-md-2" style="width:17%;">
				<input type="text" class="form-control" name="Search" value="<?php echo $searchq; ?>" placeholder="Search.." required> 
			</div>
			<div class="col-md-1">
			<button type="submit" value="Search" class="btn btn-primary">Search</button>
			</div>
			<div class="col-md-1">
			<input type="button" class="btn btn-danger" value="Reset" onclick="window.open('teacher_subject_without_subjectname.php','_self')" />
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
									
						<tr><!-- Camel casing done for Member ID and School ID by Pranali-->
							<th style="width:10px;" >Sr.No.</th>
							<th>Subject ID</th>
							<th>Subject Code</th>
							<th>Teacher Name</th>
							<th>Teacher ID</th>
							<th>Subject Name</th>
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
						<td data-title="id"><center><?php echo $i; ?></center></td>
							<td data-title="ExtSchoolSubjectId" ><?php echo $row['ExtSchoolSubjectId']; ?></td>
							<td data-title="subjcet_code" ><?php echo $row['subjcet_code']; ?></td>
							<td data-title="t_complete_name" ><?php echo $row['t_complete_name']; ?></td>
							<td data-title="teacher_id" ><?php echo $row['teacher_id']; ?></td>
							<td data-title="subjectName" ><?php echo $row['subjectName']; ?></td>
							<td> <center>
                     				<a style="cursor: pointer;" href=# ><span class="glyphicon glyphicon-pencil"></span></a>
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
									
						<tr><!-- Camel casing done for Member ID and School ID by Pranali-->
							<th style="width:10px;">Sr.No.</th>
							<th>Subject Id</th>
							<th>Subject Code</th>
							<th>Teacher Name</th>
							<th>Teacher ID</th>
							<th>Subject Name</th>
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
						<td data-title="id"><center><?php echo $i; ?></center></td>
							<td data-title="ExtSchoolSubjectId" ><?php echo $row['ExtSchoolSubjectId']; ?></td>
							<td data-title="subjcet_code" ><?php echo $row['subjcet_code']; ?></td>
							<td data-title="t_complete_name" ><?php echo $row['t_complete_name']; ?></td>
							<td data-title="teacher_id" ><?php echo $row['teacher_id']; ?></td>
							<td data-title="subjectName" ><?php echo $row['subjectName']; ?></td>
							<td> <center>
                     				<a style="cursor: pointer;" href=# ><span class="glyphicon glyphicon-pencil"></span></a>
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

</body>
</html>