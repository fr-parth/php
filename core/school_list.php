<?php
include("cookieadminheader.php");
$limit = $webpagelimit;
//if(isset($_POST['search'])&& $spage=='' )
if (!($_GET['Search']))  
{
	if (isset($_GET["page"])){ $page  = mysql_real_escape_string($_GET["page"]); } else { $page=1; }; 
	//if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };  
	
	$start_from = ($page-1) * $limit;

	$row=mysql_query("SELECT sa.school_id,sa.school_name,sa.reg_date,sa.name,sa.school_balance_point,sa.school_assigned_point,sa.balance_blue_points ,
							(SELECT COUNT('id') as no_students FROM tbl_student  where school_id=sa.school_id) as no_students,
							(SELECT COUNT('id') as no_teacher  FROM tbl_teacher  where  t_emp_type_pid in (134,133) and school_id=sa.school_id) as no_teacher
						FROM tbl_school_admin sa
						WHERE sa.school_id!=''  
						ORDER BY sa.school_id 
						LIMIT $start_from, $limit") or die("could not Search!");;
 
	$sql1="SELECT school_id,school_name,reg_date,name,school_balance_point,school_assigned_point,balance_blue_points 
			FROM tbl_school_admin 
			WHERE school_id!=''  
			ORDER BY school_id ";
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
			$query1=mysql_query("SELECT sa.school_id,sa.school_name,sa.reg_date,sa.name,sa.school_balance_point,sa.school_assigned_point,sa.balance_blue_points ,
									(SELECT COUNT('id') as no_students FROM tbl_student  where school_id=sa.school_id) as no_students,
									(SELECT COUNT('id') as no_teacher  FROM tbl_teacher  where  t_emp_type_pid in (134,133) and school_id=sa.school_id) as no_teacher
									FROM tbl_school_admin sa 
									WHERE sa.school_id!='' AND `$colname` LIKE '%$searchq%' 
									order by sa.school_id  LIMIT $start_from, $limit") or die("could not Search!");

				$sql1 =mysql_query("SELECT school_id,school_name,name,reg_date,balance_blue_points,assign_blue_points
									FROM tbl_school_admin 
									WHERE school_id != '' AND `$colname` LIKE '%$searchq%' 
									order by school_id ") or die("could not Search!");
				$total_records = mysql_num_rows($sql1);   
				$total_pages = ceil($total_records / $limit);
		}else{	
				$que = "SELECT sa.school_id,sa.school_name,sa.reg_date,sa.name,sa.school_balance_point,sa.school_assigned_point,sa.balance_blue_points ,
							(SELECT COUNT('id') as no_students FROM tbl_student  where school_id=sa.school_id) as no_students,
							(SELECT COUNT('id') as no_teacher  FROM tbl_teacher  where  t_emp_type_pid in (134,133) and school_id=sa.school_id) as no_teacher
						FROM tbl_school_admin sa
						WHERE sa.school_id!='' AND 
							(sa.school_id LIKE '%$searchq%' or 
							sa.school_name LIKE '%$searchq%' or 
							sa.name LIKE '%$searchq%' or 
							sa.reg_date LIKE '%$searchq%' or 
							sa.balance_blue_points LIKE '%$searchq%' or 
							sa.assign_blue_points LIKE '%$searchq%')	
						ORDER BY sa.school_id LIMIT $start_from, $limit";
				$query1=mysql_query($que) or die("could not Search!");
			
				$sql1 =mysql_query("SELECT COUNT('school_id')
									FROM tbl_school_admin
									WHERE school_id!='' AND 
										(school_id LIKE '%$searchq%' or 
										school_name LIKE '%$searchq%' or 
										name LIKE '%$searchq%' or 
										reg_date LIKE '%$searchq%' or 
										balance_blue_points LIKE '%$searchq%' or 
										assign_blue_points LIKE '%$searchq%')
									ORDER BY school_id ") or die("could not Search!");   
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
	//}
			/* if (isset($_POST['Search'])){
				$from_date = mysql_real_escape_string($_POST['from_date']);
				$to_date = mysql_real_escape_string($_POST['to_date']);
			}else{
				$from_date = mysql_real_escape_string($_GET['from_date']);
				$to_date = mysql_real_escape_string($_GET['to_date']);
			}

			if($from_date !='' && $to_date !='')
			{
				$sql=mysql_query("SELECT school_id,school_name,name,reg_date,school_balance_point ,school_assigned_point,balance_blue_points FROM tbl_school_admin where school_id!=''  and reg_date between '$from_date' and '$to_date' order by school_id desc LIMIT $start_from, $limit");
			}else{
					if($from_date !='' && $to_date =''){
						$today = date("Y-m-d"); 
						$sql=mysql_query("SELECT school_id,school_name,name,reg_date,school_balance_point ,school_assigned_point,balance_blue_points FROM tbl_school_admin where school_id!=''  and reg_date between '$from_date' and '$to_date' order by school_id desc LIMIT $start_from, $limit");
					}else{
						echo "Enter From Date";
					}
				}				
}
	$from_date = $_POST['from_date'];
	$to_date = $_POST['to_date'];


	 $sql="SELECT school_id,school_name,name,reg_date,school_balance_point ,school_assigned_point,balance_blue_points FROM tbl_school_admin where school_id!=''  and reg_date between '$from_date' and '$to_date' order by school_id desc";
	//die;

	$row=mysql_query($sql);

}
else
{


	$sql="SELECT school_id,school_name,reg_date,name,school_balance_point,school_assigned_point,balance_blue_points FROM tbl_school_admin where school_id!=''  order by school_id ";
	$row=mysql_query($sql);
} */

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />



<title>School Information</title>


<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
<link rel="stylesheet" href="css/bootstrap.min.css">
<!--link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css"-->
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="js/jquery-1.11.1.min.js"></script> 
<script src="js/jquery.dataTables.min.js"></script>
<!--script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script-->
<script src="js/jquery.twbsPagination.js" type="text/javascript"></script>

  <script>
  //$(function() {
    //$( "#from_date" ).datepicker({
     // changeMonth: true,
     // changeYear: true
    //});
  //});

  //$(function() {
   // $( "#to_date" ).datepicker({
     // changeMonth: true,
     // changeYear: true,

    //});
  //});
  </script>

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

	<?php if (!($_GET['Search'])){ 
		?>
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
				window.location.assign('school_list.php?page='+page);
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
				window.location.assign('school_list.php?colname=<?php echo $colname;?>&Search=<?php echo $searchq; ?>&spage='+page);
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
 </head>

<body bgcolor="#CCCCCC">
	<!-- <div align="center"> -->

		<div class="container">
			<div style="padding-top:30px" align="center" >
        	<h2 style="padding-left:20px;padding-top:10px;padding-bottom:10px;background-color:#694489; margin-top:2px;color:#666;color:white">School Information</h2>
			</div>
		<div  style=" height:30px; padding:10px;"></div>

		<form>
			<!-- <label for="from">From</label>
			<input type="text" id="from_date" name="from_date" placeholder="MM/DD/YYYY">
			<label for="to">to</label>

			<input type="text" id="to_date" name="to_date" placeholder="MM/DD/YYYY">
				 &nbsp;&nbsp;
 			<input type="submit" value="Search" name="search" id="search" /> -->
			 
			
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

					<option value="reg_date"
					<?php if (($_GET['colname']) == "reg_date") {
                            echo $_GET['colname']; ?> selected="selected" <?php } ?>>Reg.Date</option>  

					<option value="balance_blue_points"
					<?php if (($_GET['colname']) == "balance_blue_points") {
                            echo $_GET['colname']; ?> selected="selected" <?php } ?>>Balance Blue Points</option>  

					<option value="assign_blue_points"
					<?php if (($_GET['colname']) == "assign_blue_points") {
                            echo $_GET['colname']; ?> selected="selected" <?php } ?>>Balance Blue Points</option> 

                </select>
			</div>
			<div class="col-md-2" style="width:17%;">
				<input type="text" class="form-control" name="Search" value="<?php echo $searchq; ?>" placeholder="Search.." required> 
			</div>
			<div class="col-md-1">
			<button type="submit" value="Search" class="btn btn-primary">Search</button>
			</div>
			<div class="col-md-1">
			<input type="button" class="btn btn-danger" value="Reset" onclick="window.open('school_list.php','_self')" />
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
		<?php
			if (isset($_GET['Search']))
				{
					$count=mysql_num_rows($query1);
					if($count == 0){
						echo "<script>$('#show').css('display','none');</script><div style='margin-top:66px;'><font color='Red' style='margin-left: 29px;'><b style='margin-left:490px;'><b>There Was No Search Result</b></font></div>";
					}else{
		?>





<!--  <div  style=" height:30px; padding:10px;"></div>
 <form method="post" action="">
 <label for="from">From</label>
 <input type="text" id="from_date" name="from_date" placeholder="YYYY/MM/DD">
 <label for="to">to</label>
 <input type="text" id="to_date" name="to_date" placeholder="YYYY/MM/DD">
 &nbsp;&nbsp;
 <input type="submit" value="Search" name="search" id="search" />
 </form> -->



<div id="no-more-tables">
  						<table id="example" class="col-md-12 table-bordered" align="center" >

        		<thead>
    	    	<tr  style="background-color:#694489; color:#FFFFFF; height:30px;" align="center">
        	        <th>Sr._No.</th>
                    <th>School ID</th>
                    <th>School Name</th>
                    <th>School Head</th>
                    <th>No. of Students</th>
        	        <th>No. of Teachers</th>
                    <th>Date</th>
                    <th>Balance Blue Points</th>
                    <th>Balance Green Points</th>
                  <!--  <th>Assign</th>-->
                </tr>
        		</thead>

            			<?php $i=($start_from +1);
						while($result=mysql_fetch_array($query1))
						{
 							$school_id=$result['school_id'];?>
							<tr>
								<td data-title="Sr.No."><?php echo $i;   ?></td>
								<td data-title="School_ID"><?php echo $school_id; ?></td>
								<td data-title="School_Name"><?php echo ucwords($result['school_name']);?></td>
								<td data-title="School_Head"><?php echo ucwords($result['name']);?></td>


								<td data-title="No.of_Students">
									<?php if($result['no_students'] > 0 && $result['no_students'] !='') { ?>
											<a href="studentinfo.php?school_id=<?php echo $school_id ; ?>"style="text-decoration:none">
								 	<?php  echo $result['no_students']; ?> </a> 
									<?php  }else{ echo "0"; } ?>
								</td>

								<td data-title="No.of_Teachers">
									<?php if($result['no_teacher'] > 0 && $result['no_teacher'] != '') { ?>
										<a href="teacherinfo.php?school_id=<?php  echo $school_id; ?>"style="text-decoration:none">
									<?php  echo $result['no_teacher'];   ?> </a>
									<?php }else{ echo "0";} ?>
								</td>
									
								<td  data-title="Reg.Date"><?php echo $result['reg_date']; ?></td>
								<td  data-title="School_assigned_Points"><?php echo $result['balance_blue_points'];?></td>
								<td  data-title="Balance_Points"><?php echo $result['school_balance_point'];?></td>
								<!--<td > <a href="school_assignpoint.php?school_id=<?php //echo $school_id;?>" style="text-decoration:none;"> <input type="button" value="Assign" name="assign"/></a></td> -->
							</tr>
				<?php  $i++;} //while ?>

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
		<div id="no-more-tables">
			<table id="example" class="table-bordered table-striped table-condensed cf" align="center">
    				<thead>
	    	    			<tr  style="background-color:#694489; color:#FFFFFF; height:30px;" align="center">
        	        			<th>Sr. No.</th>
            	        		<th>School ID</th>
                	    		<th>School Name</th>
	                    		<th>School Head</th>
    	                		<th>No. of Students</th>
        	            		<th>No. of Teachers</th>
            	        		<th>Date</th>
                	    		<th>Balance Blue Points</th>
                    			<th>Balance Green Points</th>
                  				<!--  <th>Assign</th>-->
                			</tr>
        			</thead>

            		<?php $i=($start_from +1);
						while($result=mysql_fetch_array($row))
						{
							$school_id=$result['school_id'];

							 ?>
							<tr>
								<td data-title="Sr.No."><?php echo $i; ?></td>
								<td data-title="School_ID"><?php echo $school_id; ?></td>
								<td  data-title="School_Name"><?php echo ucwords($result['school_name']);?></td>
								<td  data-title="School_Head"><?php echo ucwords($result['name']);?></td>
								<!-- <td data-title="No.of_Students">0</td> -->

								<td data-title="No.of_Students">
									<?php if($result['no_students'] > 0 && $result['no_students'] !='') { ?>
											<a href="studentinfo.php?school_id=<?php echo $school_id ; ?>"style="text-decoration:none">
								 	<?php  echo $result['no_students']; ?> </a> 
									 <?php  }else{ echo"0"; } ?>
								</td>

								<td data-title="No.of_Teachers">
									<?php if($result['no_teacher'] > 0 && $result['no_teacher'] != '') { ?>
										<a href="teacherinfo.php?school_id=<?php  echo $school_id; ?>"style="text-decoration:none">
									<?php  echo $result['no_teacher'];   ?> </a>
									<?php }else{ echo "0";} ?>
								</td>

								<!-- <td data-title="No.of_Teachers">0</td> -->
								<td  data-title="Reg.Date"><?php echo $result['reg_date'];?></td>
								<td  data-title="School_assigned_Points"><?php echo $result['balance_blue_points'];?></td>
								<td  data-title="Balance_Points"><?php echo $result['school_balance_point'];?></td>
									<!--<td > <a href="school_assignpoint.php?school_id=<?//php echo $school_id;?>" style="text-decoration:none;"> <input type="button" value="Assign" name="assign"/></a></td> -->
</tr>
				<?php  $i++;} //while ?>
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
</div>
</body>
</html>
