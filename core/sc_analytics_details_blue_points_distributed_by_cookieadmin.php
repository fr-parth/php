<?php
error_reporting(0);
include('scadmin_header.php');

$report="";
//Queries modified and pagination done by Pranali for bug SMC-3349
$sc_id=$_SESSION['school_id'];
//$webpagelimit = 100;
if (!($_GET['Search'])){

	if (isset($_GET["page"])){ $page  = mysql_real_escape_string($_GET["page"]); } else { $page=1; };  
	$start_from = ($page-1) * $webpagelimit;
		
//	$sql=mysql_query("SELECT sc_teacher_id,school_id,sc_point FROM tbl_teacher_point where sc_entities_id='102' AND school_id='$sc_id' AND reason = 'assigned by school admin' order by id desc LIMIT $start_from, $webpagelimit") or die("Could not Search!");	
	$sql=mysql_query("SELECT s.std_complete_name,sp.sc_stud_id,sp.school_id,sp.sc_point FROM tbl_student_point sp join tbl_student s on sp.sc_stud_id=s.std_PRN AND sp.school_id=s.school_id where sc_entites_id='102' AND sp.school_id='$sc_id' AND s.school_id='$sc_id' AND type_points='blue_point' order by sp.id desc LIMIT $start_from, $webpagelimit") or die("Could not Search!");

	$sql1 =mysql_query("SELECT s.std_complete_name,sp.sc_stud_id,sp.school_id,sp.sc_point FROM tbl_student_point sp join tbl_student s on sp.sc_stud_id=s.std_PRN AND sp.school_id=s.school_id where sc_entites_id='102' AND sp.school_id='$sc_id' AND s.school_id='$sc_id' AND type_points='blue_point' order by sp.id desc");
	  
						
						$total_records = mysql_num_rows($sql1);
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
		if (isset($_GET["spage"])){ 
			$spage  = mysql_real_escape_string($_GET["spage"]);
		} 
		else{
			$spage=1; 
		};  
	$start_from = ($spage-1) * $webpagelimit;

	$searchq=mysql_real_escape_string($_GET['Search']);
	//$colname=mysql_real_escape_string($_GET['colname']);
		
			
			$sql = mysql_query("SELECT s.std_complete_name,sp.sc_stud_id,sp.school_id,sp.sc_point FROM tbl_student_point sp join tbl_student s on sp.sc_stud_id=s.std_PRN AND sp.school_id=s.school_id where sc_entites_id='102' AND sp.school_id='$sc_id' AND s.school_id='$sc_id' AND type_points='blue_point' AND (sp.sc_stud_id LIKE '%$searchq%' or sp.school_id LIKE '%$searchq%' or sp.sc_point LIKE '%$searchq%' or s.std_complete_name LIKE '%$searchq%') order by sp.id desc LIMIT $start_from, $webpagelimit") or die("Could not Search!");
							
			$sql1 = mysql_query("SELECT s.std_complete_name,sp.sc_stud_id,sp.school_id,sp.sc_point FROM tbl_student_point sp join tbl_student s on sp.sc_stud_id=s.std_PRN AND sp.school_id=s.school_id where sc_entites_id='102' AND sp.school_id='$sc_id' AND s.school_id='$sc_id' AND type_points='blue_point' AND (sp.sc_stud_id LIKE '%$searchq%' or sp.school_id LIKE '%$searchq%' or sp.sc_point LIKE '%$searchq%' or s.std_complete_name LIKE '%$searchq%') order by sp.id desc ");
		  
							$total_records = mysql_num_rows($sql1);  
							$total_pages = ceil($total_records / $webpagelimit);
		
				
			//below query use for search count
			 
						if($total_pages == $_GET['spage']){
							$webpagelimit = $total_records;
						}
						else{
							$webpagelimit = $start_from + $webpagelimit;
						}
					 
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta charset="utf-8">
<title>Smart Cookies</title>
<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
    <script src="code.jquery.com/jquery-1.10.2.js"></script>
    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>

    <script src="code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
	<script src="js/jquery.twbsPagination.js" type="text/javascript"></script>
    <script>
    $(document).ready(function() {
    $('#example').dataTable( {
	"paging":   false,
	"info":false,
	"searching": false,
     "scrollCollapse": true,
	"scrollX":true	
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
			window.location.assign('sc_analytics_details_blue_points_distributed_by_cookieadmin.php?page='+page);
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
			window.location.assign('sc_analytics_details_blue_points_distributed_by_cookieadmin.php?colname=<?php echo $colname;?>&Search=<?php echo $searchq; ?>&spage='+page);
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
		
		padding-right: 10px; 
		white-space: nowrap;
		
		
	}
 
	/*
	Label the data
	*/
	#no-more-tables td:before { content: attr(data-title); }
}
</style>
</head>


<body bgcolor="#CCCCCC">

<div align="center">
    <div class="container" style="width:100%;">
        <div style="padding-top:30px;">
<!--$dynamic_school_admin added by Sayali Balkawade for SMC-4254 on 11/12/2019-->
            <h2 style="padding-left:20px; margin-top:2px;color:#666">Blue Points Distributed To <?php echo $dynamic_student;?> By <?php echo $organization;?> Admin</h2>

        </div>
		<div class='row'>
		<form style="margin-top:5px;">
			 <div class="col-md-4" style="width:17%;">
			 </div>
                  
                  <div class="row" style="padding:10px;" >

		<form style="margin-top:5px;">
			 <div class="col-md-4" style="width:17%;">
			 </div>
			
           
			<div class="col-md-2" style="width:17%;margin-left:200px; ">
				<input type="text" class="form-control" name="Search" value="<?php echo $searchq; ?>" placeholder="Search.." > 
			</div>
			<div class="col-md-1" >
			<button type="submit" value="Search" class="btn btn-primary">Search</button>
			</div>
			<div class="col-md-1" >
			<input type="button" class="btn btn-info" value="Reset" onclick="window.open('sc_analytics_details_blue_points_distributed_by_cookieadmin.php','_self')" />
			</div>
			<div class="col-md-1" >
			  <div><a href="school_admin_analytics.php">
                            <input type="button" class="btn btn-danger" name="Back" value="Back" />
                        </a>
                    </div>
			</div>
					<!-- <div style="margin-left: 800px;">
						<input type="text" name="Search" value="<?php echo $searchq; ?>" placeholder="Search..">
						<input type="submit" value="Search">
						<input type="button" value="Reset" onclick="window.open('beneficiary_list.php','_self')" />
					</div> -->
		</form>
		 </div> 
      

		 
                  
               <div class="row">

               <div class="col-md-2">
               </div>
			   
			   <?php
		if (isset($_GET['Search']))
		{
			
			$count=mysql_num_rows($sql);
			if($count == 0)
			{
				
				echo "<script>$('#show').css('display','none');</script><div style='margin-top:20px;' align='center'><font color='Red'><b>There Was No Search Result</b></font></div>";	
			}
			else
			{
			?>
			   
               <div id="no-more-tables" style="padding-top:20px;">

            <table id="example" class="col-md-12 table-bordered " align="center">
                <thead>
				<!-- <tr><?php echo $sql1; ?></tr> -->
                <tr style="background-color:#0073BD; color:#FFFFFF; height:30px;">
						<th>Sr.No</th>						
						<th><?php echo $dynamic_student;?> Name</th>	
                        <th><?php echo $dynamic_student_prn;?> </th>					
						<th><?php echo $organization;?> ID</th>
						
						
						<th><center>Points</th>
						

					</tr>
					</thead>
				<tbody>
                <?php
									
					$i = 1;
					$i = ($start_from +1);?>
                  <?php 
				  while($row=mysql_fetch_array($sql)){
				  ?>
                
                    <td data-title="Sr.No" ><?php echo $i;?></td>
					<td data-title="<?php echo $dynamic_student;?> Name"><?php echo ucwords(strtolower($row['std_complete_name']));?> </td>
                    <td data-title=" <?php echo $dynamic_student_prn;?>"><?php echo $row['sc_stud_id'];?></td>	
					<td data-title="<?php echo $organization;?> ID" ><?php echo $row['school_id'];?> </td>	
					<td data-title="Point" ><?php echo $row['sc_point'];?></td>
					
                 </tr>
                <?php $i++;?>
                 <?php }?>
                  
                  </tbody>
                  </table>
				   </div>
				   <div align=left>
		 		<?php if (!($_GET['Search']))
		 			{
		 				if ($webpagelimit >$total_records){ $webpagelimit=$total_records;}
		 				echo "<div style='margin-top:5px;margin-left:30px;'><font color='#0073BD'><style='margin-left:600px;'>Now showing ".($start_from +1)." to ".($webpagelimit)." records out of ".$total_records. " records.</font></style></div>";
		    }else
		 			{
		 				if ($webpagelimit >$total_records){ $webpagelimit=$total_records;}
		 				echo "<div style='margin-top:5px;margin-left:30px;'><font color='#0073BD'><style='margin-left:600px;'>Now showing ".($start_from +1)." to ".($webpagelimit)." records out of ".($total_records). " records.</font></style></div>";
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
		<div id="no-more-tables" style="padding-top:20px;">

            <table id="example" class="col-md-12 table-bordered " align="center">
                <thead>
				<!-- <tr><?php echo $sql1; ?></tr> -->
                <tr style="background-color:#0073BD; color:#FFFFFF; height:30px;">
						<th>Sr.No</th>						
						<th><?php echo $dynamic_student;?> Name</th>	
                        <th><?php echo $dynamic_student_prn;?> </th>					
						<th><?php echo $organization;?> ID</th>
						
						
						<th><center>Points</th>
						

					</tr>
					</thead>
				<tbody>
                <?php
									
					$i = 1;
					$i = ($start_from +1);?>
                  <?php 
				  while($row=mysql_fetch_array($sql)){
				  ?>
                 <td data-title="Sr.No" ><?php echo $i;?></td>
					<td data-title="<?php echo $dynamic_student;?> Name"><?php echo ucwords(strtolower($row['std_complete_name']));?> </td>
                    <td data-title=" <?php echo $dynamic_student_prn;?>"><?php echo $row['sc_stud_id'];?></td>	
					<td data-title="<?php echo $organization;?> ID" ><?php echo $row['school_id'];?> </td>	
					<td data-title="Point" ><?php echo $row['sc_point'];?></td>
					
					
					

					
                 </tr>
                <?php $i++;?>
                 <?php }?>
                  
                  </tbody>
                  </table>
				   </div>
				   <div align=left>
		 		<?php if (!($_GET['Search']))
		 			{
		 				if ($webpagelimit >$total_records){ $webpagelimit=$total_records;}
		 				echo "<div style='margin-top:5px;margin-left:30px;'><font color='#0073BD'><style='margin-left:600px;'>Now showing ".($start_from +1)." to ".($webpagelimit)." records out of ".$total_records. " records.</font></style></div>";
		    }else
		 			{
		 				if ($webpagelimit >$total_records){ $webpagelimit=$total_records;}
		 				echo "<div style='margin-top:5px;margin-left:30px;'><font color='#0073BD'><style='margin-left:600px;'>Now showing ".($start_from +1)." to ".($webpagelimit)." records out of ".($total_records). " records.</font></style></div>";
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
                <!--changes end -->  
                  
                   <div class="row" style="padding:5px;">
                   <div class="col-md-4">
               </div>
                  <div class="col-md-3 "  align="center">
                   
                   
                   </div>
                    </div>
                     <div class="row" >
                     <div class="col-md-4">
                     </div>
                      <div class="col-md-3" style="color:#FF0000;" align="center">
                      
                      <?php echo $report;?>
               			</div>
                 
                    </div>
               </div>
               </div>
	</body>
</html>