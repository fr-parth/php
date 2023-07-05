<?php
 include("scadmin_header.php");
 //Query changed & Pagination done by Pranali for bug SMC-3355
$id=$_SESSION['id'];
$school_id=$_SESSION['school_id'];
//$webpagelimit = 10;


if (!($_GET['Search'])){

	if (isset($_GET["page"])){ $page  = mysql_real_escape_string($_GET["page"]); } else { $page=1; };  
	$start_from = ($page-1) * $webpagelimit;
		
	$sql=mysql_query("SELECT ts.school_id,ts.std_complete_name,ts.std_name,ts.std_Father_name,ts.std_lastname,ts.balance_bluestud_points,
    tsp.sc_total_point,tsp.purple_points,
	ts.std_PRN,ts.std_school_name 
	FROM tbl_student ts  join tbl_student_reward tsp 
    on ts.std_PRN=tsp.sc_stud_id and ts.school_id=tsp.school_id 
    where ts.school_id='$school_id'  order by std_complete_name LIMIT $start_from, $webpagelimit") or die("Could not Search!");	

	$sql1 =mysql_query("SELECT ts.school_id,ts.std_complete_name,ts.std_name,ts.std_Father_name,ts.std_lastname,ts.balance_bluestud_points,
    tsp.sc_total_point,tsp.purple_points,
	ts.std_PRN,ts.std_school_name 
	FROM tbl_student ts  join tbl_student_reward tsp 
    on ts.std_PRN=tsp.sc_stud_id and ts.school_id=tsp.school_id 
    where ts.school_id='$school_id'  order by std_complete_name");
	  
						
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
	
		
			$sql=mysql_query("SELECT ts.school_id,ts.std_complete_name,ts.std_name,ts.std_Father_name,ts.std_lastname,ts.balance_bluestud_points,
			tsp.sc_total_point,tsp.purple_points,
			ts.std_PRN,ts.std_school_name 
			FROM tbl_student ts JOIN tbl_student_reward tsp 
			on ts.std_PRN=tsp.sc_stud_id AND ts.school_id=tsp.school_id 
			WHERE ts.school_id='$school_id' AND ts.std_complete_name LIKE '%$searchq%'
            order by std_complete_name LIMIT $start_from, $webpagelimit") or die("Could not Search!");
					
			$sql1 =mysql_query("SELECT ts.school_id,ts.std_complete_name,ts.std_name,ts.std_Father_name,ts.std_lastname,ts.balance_bluestud_points,
			tsp.sc_total_point,tsp.purple_points,
			ts.std_PRN,ts.std_school_name 
			FROM tbl_student ts JOIN tbl_student_reward tsp 
			on ts.std_PRN=tsp.sc_stud_id AND ts.school_id=tsp.school_id 
			WHERE ts.school_id='$school_id' AND ts.std_complete_name LIKE '%$searchq%'
            order by std_complete_name"); 
				
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
	"searching": false
     //"scrollCollapse": true
	
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
			window.location.assign('recalculate.php?page='+page);
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
			window.location.assign('recalculate.php?colname=<?php echo $colname;?>&Search=<?php echo $searchq; ?>&spage='+page);
        });
    });
</script>
<?php }?>
  <style>
 input[type="submit"]
        {

           background-color: #FFFFFF;
           width:250px;
           height:45px;
           border-radius: 5px;
           font-size: 17px;
           box-shadow:0px 0px 2px 3px #FFCC33;
           background: linear-gradient(#FFF,#CCC);
        }
@media only screen AND (max-width: 800px) {
    
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

<body>
    <div class="row">
<div class="container" style="padding-top:20px;width:100%;">

<div style=" background-color:#f9f9f9; border:1px solid #CCCCCC;" align="center" >
  	<h1 style="padding-left:20px; margin-top:4px;color:#800080;">List Of All Points</h1>
        </div>

         <div style="height:20px;"></div>


<a href="recalculate.php"><input type="submit" name="btnSubmit" id="submitId" value="Recalculate Points" style="font-size:16px;font-family: Georgia, serif"/> </a> 

<div class="row" style="padding:10px;" >

		<form style="margin-top:5px;">
			 <div class="col-md-4" style="width:17%;">
			 </div>
			            
			<div class="col-md-2" style="width:17%;margin-left:194px">
				<input type="text" class="form-control" name="Search" value="<?php echo $searchq; ?>" placeholder="Search.." required> 
			</div>
			<div class="col-md-1" >
			<button type="submit" value="Search" class="btn btn-primary">Search</button>
			</div>
			<div class="col-md-1" >
			<input type="button" class="btn btn-info" value="Reset" onclick="window.open('recalculate.php','_self')" />
			</div>
					<!-- <div style="margin-left: 800px;">
						<input type="text" name="Search" value="<?php echo $searchq; ?>" placeholder="Search..">
						<input type="submit" value="Search">
						<input type="button" value="Reset" onclick="window.open('beneficiary_list.php','_self')" />
					</div> -->
		</form>
		 </div>  
	<!--	<div id="show">
			?php if (!($_GET['Search']))
				{
					if ($webpagelimit >$total_records){ $webpagelimit=$total_records;}
					echo "<div style='margin-top:5px;'><font color='blue'><b style='margin-left:600px;'>Now showing ".($start_from +1)." to ".($webpagelimit)." records out of ".$total_records. " records.</b></font></div>";
				}else
				{
					if ($webpagelimit >$total_records){ $webpagelimit=$total_records;}
					echo "<div style='margin-top:5px;'><font color='blue'><b style='margin-left:600px;'>Now showing ".($start_from +1)." to ".($webpagelimit)." records out of ".($total_records). " records.</b></font></div>";
				}
				?>
		</div> -->
		   
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


				<table id="example" class="col-md-12 table-bordered table-striped " >



        			<thead>
        			<tr style="background-color:#708090;color:#FFFFFF;">
                	<th>Sr. No.</th>
                    <th><?php echo $dynamic_student  ?> Name</th>
                    <th><?php echo $organization  ?> Name</th>
                    <th>Recalculate Points</th>
					
                </tr>
                </thead>
				<tbody>


             <?php 
				
				$i = ($start_from +1);
                
					 while($result=mysql_fetch_array($sql))
                     {
                          $std_PRN=$result['std_PRN'];

					?>
					<tr  onClick="document.location='recalculate_log.php?s_id=<?php echo $result['std_PRN'];?>&sc_id=<?php echo $result['school_id'];?>'">
					<td   data-title="Sr.No."><?php echo $i;?></td>
					<td  data-title="<?php echo $dynamic_student  ?> Name"><?php if($result['std_complete_name']==""){echo 
					strtoupper($result['std_name'])." ".strtoupper($result['std_lastname']);}else{ echo strtoupper($result['std_complete_name']);}?></td>
					<td data-title="<?php echo $organization  ?> Name"><?php if($result['std_school_name']==""){echo $school_id;}else{ echo $result['std_school_name'];}?></td>


					<td data-title="Green Points">
					    <div class="row" style="padding-bottom:5px;padding-left:8px;">
											<div class="col-md-1 " style="background-color:#92C81A;" >
                        &nbsp;
                        </div>

                        <div  class="col-md-3">
                           <?php if($result['sc_total_point']==""){echo "0";}else{echo $result['sc_total_point'];}?>
                        </div>

                        <div style="background-color:#0F15D2;" class="col-md-1">
                        &nbsp;
                        </div>
                        
                        <div  class="col-md-3">

                          <?php if($result['balance_bluestud_points']==""){echo "0";}else{echo $result['balance_bluestud_points'];}?>

                        </div>
						 <div style="background-color:#990099;" class="col-md-1">
                           &nbsp;
                        </div>

                        <div  class="col-md-3">

                          <?php if($result['purple_points']==""){echo "0";}else{echo $result['purple_points'];}?>

                        </div>
					    </div>
                        </td>

<!--<td data-title="Used Blue Points"><?php //echo $result['used_blue_points'];?></td>-->
                        </tr>
                        <?php
                        $i++;
                        }
                        ?>
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

              <div id="no-more-tables" style="padding-top:20px;">


				<table id="example" class="col-md-12 table-bordered table-striped " >



        			<thead>
        			<tr style="background-color:#708090;color:#FFFFFF;">
                	<th>Sr. No.</th>
                    <th><?php echo $dynamic_student  ?> Name</th>
                    <th><?php echo $organization  ?> Name</th>
                    <th>Recalculate Points</th>




                </tr>
                </thead>
				<tbody>


             <?php 
				
				$i = ($start_from +1);
                
					 while($result=mysql_fetch_array($sql))
                     {
                          $std_PRN=$result['std_PRN'];


					?>
					<tr  onClick="document.location='recalculate_log.php?s_id=<?php echo $result['std_PRN'];?>&sc_id=<?php echo $result['school_id'];?>'">
					<td  data-title="Sr.No."><?php echo $i;?></td>
					<td  data-title="<?php echo $dynamic_student  ?> Name"><?php if($result['std_complete_name']==""){echo 
					strtoupper($result['std_name'])." ".strtoupper($result['std_lastname']);}else{ echo strtoupper($result['std_complete_name']);}?></td>
					<td data-title="<?php echo $organization  ?> Name"><?php if($result['std_school_name']==""){echo $school_id;}else{ echo $result['std_school_name'];}?></td>


					<td data-title="Green Points">
					    <div class="row" style="padding-bottom:5px;padding-left:8px;">
						<div  class="col-md-1">
                        </div>
						<div class="col-md-1" style="background-color:#92C81A;" >
                        &nbsp;
                        </div>

                        <div  class="col-md-2">
                           <?php if($result['sc_total_point']==""){echo "0";}else{echo $result['sc_total_point'];}?>
                        </div>

                        <div style="background-color:#0F15D2;" class="col-md-1">
                        &nbsp;
                        </div>
                        
                        <div  class="col-md-2">

                          <?php if($result['balance_bluestud_points']==""){echo "0";}else{echo $result['balance_bluestud_points'];}?>

                        </div>
						 <div style="background-color:#990099;" class="col-md-1">
                           &nbsp;
                        </div>

                        <div  class="col-md-2">

                          <?php if($result['purple_points']==""){echo "0";}else{echo $result['purple_points'];}?>

                        </div>
					    </div>
                        </td>

<!--<td data-title="Used Blue Points"><?php //echo $result['used_blue_points'];?></td>-->
                        </tr>
                        <?php
                        $i++;
                        }
                        ?>
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
//changes end			?>
</div>
</div>
</div>
</body>
</html>
