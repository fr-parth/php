<?php
include_once("scadmin_header.php");
$results = $smartcookie->retrive_individual($table, $fields);
$result = mysql_fetch_array($results);
$school_id = $result['school_id'];
$limit = 10; 



$searchq=$_GET['id'];

$dept_query="SELECT  id,Dept_code,Dept_Name,ExtDeptId FROM tbl_department_master where id = '".$searchq."'";
// echo $dept_query; exit;
$dept_sql=mysql_query($dept_query) or die("could not Search!");
$dept_res=mysql_fetch_assoc($dept_sql);

if (!($_POST['submit']))
{
	if (isset($_GET["page"]))
	{
		$page  = mysql_real_escape_string($_GET["page"]); 
	}
	else 
	{
		$page=1; 
	}

	$start_from = ($page-1) * $webpagelimit;

	$sql1 =mysql_query("SELECT ls.RowID as totalEmp, s.std_PRN,s.std_complete_name,ls.LatestLoginTime,
	ls.FirstLoginTime,s.id as member_id FROM tbl_LoginStatus ls LEFT JOIN tbl_student s on ls.EntityID=s.id where(s.ExtDeptId='".$dept_res['ExtDeptId']."' OR s.std_dept='".$dept_res['Dept_Name']."') AND s.school_id='$school_id' AND (ls.Entity_type='105' OR ls.Entity_type='205') group by ls.EntityID order by ls.RowID ");
	
	$total_records = mysql_num_rows($sql1); 
	//print_r($total_records);exit;
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
	//Below code added for SMC-4925 by chaitali on 22-04-2021 
	if (isset($_GET["spage"])){ 
		$spage  = mysql_real_escape_string($_GET["spage"]);
	} 
	else{
		$spage=1; 
	};  
	$start_from = ($spage-1) * $webpagelimit;
	
	$from_date = $_POST['from_date'];
	$to_date = $_POST['to_date'];
			
	/*$search_query =mysql_query("SELECT ls.RowID as totalEmp, s.std_PRN,s.std_complete_name,ls.LatestLoginTime,
	ls.FirstLoginTime,s.id as member_id FROM tbl_LoginStatus ls LEFT JOIN tbl_student s on 
	ls.EntityID=s.id where (s.ExtDeptId='".$dept_res['ExtDeptId']."' OR 
	s.std_dept='".$dept_res['Dept_Name']."') AND s.school_id='$school_id' AND 
	(ls.Entity_type='105' OR ls.Entity_type='205') 
	AND (ls.LatestLoginTime >= '$from_date' AND ls.LatestLoginTime <= '$to_date ') 
	group by ls.EntityID order by ls.RowID 
	LIMIT $start_from, $limit");*/

	$sql1 =mysql_query("SELECT ls.RowID as totalEmp, s.std_PRN,s.std_complete_name,ls.LatestLoginTime,
	ls.FirstLoginTime,s.id as member_id FROM tbl_LoginStatus ls LEFT JOIN tbl_student s on 
	ls.EntityID=s.id where (s.ExtDeptId='".$dept_res['ExtDeptId']."' OR 
	s.std_dept='".$dept_res['Dept_Name']."') AND s.school_id='$school_id' AND 
	(ls.Entity_type='105' OR ls.Entity_type='205') 
	AND (ls.LatestLoginTime >= '$from_date' AND ls.LatestLoginTime <= '$to_date ') 
	group by ls.EntityID order by ls.RowID ") ;
	
	/*
	$search_query =mysql_query("SELECT std_PRN,std_complete_name,last_login_date FROM tbl_student 
	where (ExtDeptId='".$dept_res['ExtDeptId']."' OR std_dept='".$dept_res['Dept_Name']."') 
	AND school_id='$school_id' AND (entity_type_id='105' OR entity_type_id='205') 
	AND (last_login_date >= '$from_date' AND last_login_date <= '$to_date ') 
	group by entity_type_id order by std_PRN
	LIMIT $start_from, $limit");

	$sql1 =mysql_query("SELECT std_PRN,std_complete_name,last_login_date FROM tbl_student 
	where (ExtDeptId='".$dept_res['ExtDeptId']."' OR std_dept='".$dept_res['Dept_Name']."')
	AND school_id='$school_id' AND (entity_type_id='105' OR entity_type_id='205') 
	AND (last_login_date >= '$from_date' AND last_login_date <= '$to_date ') 
	group by entity_type_id") or die("could not Search!");
				*/
	$total_records = mysql_num_rows($sql1);  
	$total_pages = ceil($total_records / $webpagelimit);

	if($total_pages == $_GET['spage']){
		$webpagelimit = $total_records;
	}
	else{
		$webpagelimit = $start_from + $webpagelimit;
	}
	
}
//$result = mysql_query("SELECT  id,Dept_code,Dept_Name,ExtDeptId FROM tbl_department_master where(ExtDeptId =''OR ExtDeptId IS NULL) AND School_ID='$school_id' ");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title><?php echo $dynamic_degree;?></title>
    <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
	
	<script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#example').dataTable({
				"pagingType": "full_numbers"
			});
        });
		function confirmation(xxx) {
    var answer = confirm("Are you sure you want to delete")
    if (answer){
        
       window.location = "delete_school_degree.php?id="+xxx;
		
		
    }
    else{
       
     }
}
    </script>
    
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
                padding-right: 10px;
                white-space: nowrap;
            }
            /*
            Label the data
            */
            #no-more-tables td:before {
                content: attr(data-title);
            }
        }
    </style>

	<?php if (!($_POST['submit'])){ ?>

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

				window.location.assign('dept_login_report.php?id=<?php echo $searchq;?>&page='+page);

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

				window.location.assign('dept_login_report.php?id=<?php echo $searchq;?>&spage='+page);

    		});
		});
   </script>
<?php }?>
</head>
<body>
<!-- Headline -->
        <div class="container">
			<div style="padding-top:30px" align="center" >

        		<h2 style="padding-left:20px;padding-top:10px;padding-bottom:10px;background-color:#428BCA; margin-top:2px;color:#666;color:white"><?= $dept_res['Dept_Name'];?> Department Login Report</h2>
			</div>
			<div  style=" height:30px; padding:10px;"></div>


			<!-- Below code added for SMC-4925 by chaitali on 22-04-2021 -->

<!-- search form -->
<div class="row col-md-12 text-center">
<form method="post" class="form-inline" >
	 <label for="from">From Date :</label>&nbsp;
	<input type="datetime-local" id="from_date" name="from_date" placeholder="dd-mm-yyyy"
	value="<?php if(isset($_POST['from_date'])){echo $_POST['from_date'];} ?>">

	&nbsp;&nbsp;

	<label for="to">To Date :</label>&nbsp;

	<input type="datetime-local" id="to_date" name="to_date" placeholder="dd-mm-yyyy" 
	value="<?php if(isset($_POST['to_date'])){echo $_POST['to_date'];} ?>"
	>
		 &nbsp;&nbsp;
	 <input type="submit" value="Submit" name="submit" id="search" class="btn btn-primary"/>
	
	 &nbsp;&nbsp;
	 <input type="reset" value="Cancel" name="cancel"  class="btn btn-danger" onClick="window.location.assign('dept_login_report.php?id=<?php echo $searchq;?>');"/>
	

</form> 
</div>
<div class="row col-md-12">
<a href="departmentwise_login_employee.php" class="btn btn-warning"> Back </a>
</div><br><br>
<!-- If Search is Set -->
<div style="bgcolor:#CCCCCC">
    <div class="container" style="padding:30px;">
        <div style="border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">
            <div style="background-color:#F8F8F8 ;">
                <div class="row">
                    <div class="col-md-12 " style="color:#700000 ;padding:5px;">&nbsp;&nbsp;&nbsp;&nbsp;
                        <center><h2><?= $dept_res['Dept_Name'];?> Department Login Report</h2></center>
                    </div>
                    
                </div>
                <div class="row" style="padding:15px;">
                    <div class="col-md-12" id="no-more-tables">
<?php
	if (isset($_POST['submit']))
		{
			$count=mysql_num_rows($sql1);
			if($count == 0){
				echo "<script>$('#show').css('display','none');</script><div style='margin-top:66px;'><font color='Red' style='margin-left: 29px;'><b style='margin-left:490px;'><b>There Was No Search Result</b></font></div>";
			}else{
?>

			<table id="example" class="display" width="100%" cellspacing="0" style="margin-top:20px;" >
					<thead style="background-color:#FFFFFF;">
					<tr>
					<th style="width:10px;">Sr.No.</th>
                    <th>Student PRN</th>					
                    <th>Student Name</th>					
                    <th>Latest Login time</th>					
                    </tr>
					</thead>
					<tbody>
					 	<?php
							$i = ($start_from +1);
							while ($row1= mysql_fetch_array($sql1)){

						//$id=$row['id'];
						//echo "select t_complete_name where id='$id'";
						//$q=mysql_query("select PhoneNo from tbl_department_master where id='$id'");
						//$result1=mysql_fetch_array($q);
						
					 ?>
						<tr>
							<td data-title="id"><center><?php echo $i; ?></center></td>

                            <td data-title="id"><?php echo $row1['std_PRN']; ?></td>
							<td data-title="Dept_code"><?php echo $row1['std_complete_name']; ?></td>
							<td data-title="Dept_Name"><?php echo $row1['LatestLoginTime']; ?></td>

							<!--<td> <center>
                     			<a style="cursor: pointer;" href="edit_school_department.php?d_id=<?php echo $row['id'];?>&d_code=<?php echo $row['Dept_code']; ?>&pg=dq"><span class="glyphicon glyphicon-pencil"></span></a>
								</center>
							</td>-->
							
						</tr>
					<?php $i++;} ?>     
				</tbody>
			</table>

			



	<?php } 
		}
		else
		{
		?>


			<table id="example" class="display" width="100%" cellspacing="0" style="margin-top:20px;">

					<thead style="background-color:#FFFFFF;">
					<tr>
					<th style="width:10px;">Sr.No.</th>
                    <th>Student PRN</th>					
                    <th>Student Name</th>					
                    <th>Latest Login time</th>					
                    </tr>
					</thead>
					<tbody>
					 	<?php
							$i = ($start_from +1);
							while ($row= mysql_fetch_array($sql1)){
							//$id=$row['id'];
							//echo "select t_complete_name where id='$id'";
							//$q=mysql_query("select Email_Id from tbl_department_master where id='$id'");
							//$result1=mysql_fetch_array($q);
						
					 	?>
					 	<!-- <a href="student_login_report.php?id=<?= $row['member_id'];?>"> -->

						<!-- <tr onclick='location.replace("student_login_report.php?id=<?= $row['member_id'];?>&did=<?= $_GET['id'];?>")'> -->
						<tr>
							<td data-title="id"><center><?php echo $i; ?></center></td>
                            <td data-title="id"><?php echo $row['std_PRN']; ?></td>
							<td data-title="Dept_code"><?php echo $row['std_complete_name']; ?></td>
							<td data-title="Dept_Name"><?php echo $row['LatestLoginTime']; ?></td>
						</tr>
						<!-- </a> -->
						<?php $i++;} ?>     
					</tbody>
				</table>



		<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
		<!--<div class="container" align="center">
		<nav aria-label="Page navigation">
			<ul class="pagination" id="pagination"></ul>
		</nav>

		<?php  if (!($_POST['submit']))
		{   
			if ($limit >$total_records){ $limit=$total_records;}
			echo "<font color='#428bca'><b>Now showing ".($start_from +1)." to ".($limit)." records out of ".($total_records). " records.</b></font>";
		}else
		{
			if ($limit >$total_records){ $limit=$total_records;}
			echo "<font color='#428bca'><b>Now showing ".($start_from +1)." to ".($limit)." records out of ".($total_records). " records.</b></font>";
		} 
		?>

		</div>-->

<br><br>
	</div>

</body>
</html> 

