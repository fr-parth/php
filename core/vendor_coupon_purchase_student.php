<?php

include("scadmin_header.php");
//header problem solved
ob_start();
 $index_url=$GLOBALS['URLNAME'];
$results = $smartcookie->retrive_individual($table, $fields);
$result = mysql_fetch_array($results);
$school_id = $result['school_id'];
$from=$_GET['from'];
$to=$_GET['to'];
 if (!($_GET['Search'])){

if (isset($_GET["page"])){ $page  = mysql_real_escape_string($_GET["page"]); } else { $page=1; };  
$start_from = ($page-1) * $webpagelimit;
	
$sql=mysql_query(" SELECT s.std_complete_name,s.school_id , tvc.timestamp , tvc.coupon_id, tvc.code, tvc.user_id FROM tbl_selected_vendor_coupons tvc 
 join tbl_student s on  s.id=tvc.user_id and s.school_id=tvc.school_id where  (tvc.timestamp BETWEEN '$from' AND '$to') and  
 tvc.entity_id='3' AND 
 (tvc.used_flag ='used' AND tvc.school_id = '$school_id')
        
LIMIT $start_from, $webpagelimit");	

$sql1 =" SELECT count(s.std_complete_name),s.school_id , tvc.timestamp , tvc.coupon_id, tvc.code, tvc.user_id FROM tbl_selected_vendor_coupons tvc 
 join tbl_student s on  s.id=tvc.user_id and s.school_id=tvc.school_id where (tvc.timestamp BETWEEN '$from' AND '$to') and   
 tvc.entity_id='3' AND 
 (tvc.used_flag ='used' AND tvc.school_id = '$school_id')";  
					$rs_result = mysql_query($sql1);  
					$row1 = mysql_fetch_row($rs_result);  
					$total_records = $row1[0];  
					$total_pages = ceil($total_records / $webpagelimit);
					if($total_pages == $_GET['page']){
					$webpagelimit = $total_records;
					}else{
					$webpagelimit = $start_from + $webpagelimit;
					}
}else
{
	if (isset($_GET["spage"])){ $spage  = mysql_real_escape_string($_GET["spage"]); } else { $spage=1; };  
$start_from = ($spage-1) * $webpagelimit;

$searchq=mysql_real_escape_string($_GET['Search']);
//$colname=mysql_real_escape_string($_GET['colname']);

if($searchq !='')

	//if ($colname != ''and $colname != 'Select')
	{
		$query1=mysql_query("SELECT s.std_complete_name,s.school_id ,tvc.timestamp ,  tvc.coupon_id, tvc.code, tvc.user_id FROM tbl_selected_vendor_coupons tvc 
 join tbl_student s on  s.id=tvc.user_id and s.school_id=tvc.school_id where (tvc.timestamp BETWEEN '$from' AND '$to') and   
 tvc.entity_id='3' AND 
 (tvc.used_flag ='used' AND tvc.school_id = '$school_id')
 and
 
            (s.std_complete_name LIKE '%$searchq%' or 
			s.school_id like '%$searchq%'  or 
			tvc.coupon_id LIKE '%$searchq%'or 
			tvc.code LIKE '%$searchq%'	or
			tvc.user_id LIKE '%$searchq%'  )
			
			LIMIT $start_from, $webpagelimit") 
			or die("could not Search!");
			
			$sql1 ="SELECT count(s.std_complete_name),s.school_id , tvc.timestamp , tvc.coupon_id, tvc.code, tvc.user_id FROM tbl_selected_vendor_coupons tvc 
 join tbl_student s on  s.id=tvc.user_id and s.school_id=tvc.school_id where (tvc.timestamp BETWEEN '$from' AND '$to') and   
 tvc.entity_id='3' AND 
 (tvc.used_flag ='used' AND tvc.school_id = '$school_id')
 and 
            (s.std_complete_name LIKE '%$searchq%' or 
			s.school_id like '%$searchq%'  or 
			tvc.coupon_id LIKE '%$searchq%'or 
			tvc.code LIKE '%$searchq%'	or
			tvc.user_id LIKE '%$searchq%') 				
			 "; 

			$rs_result = mysql_query($sql1);  
					$row1 = mysql_fetch_row($rs_result);  
				    $total_records = $row1[0];  
					$total_pages = ceil($total_records / $webpagelimit);

	}else{
			

			$query1=mysql_query("SELECT s.std_complete_name,s.school_id , tvc.timestamp , tvc.coupon_id, tvc.code, tvc.user_id FROM tbl_selected_vendor_coupons tvc 
 join tbl_student s on  s.id=tvc.user_id and s.school_id=tvc.school_id where (tvc.timestamp BETWEEN '$from' AND '$to') and   
 tvc.entity_id='3' AND 
 (tvc.used_flag ='used' AND tvc.school_id = '$school_id')
 and 
     ($colname LIKE '%$searchq%' ) LIMIT $start_from, $webpagelimit") 
		or die("could not Search!");
					//echo $query1;
		
		$sql1 ="SELECT count(s.std_complete_name),s.school_id , tvc.timestamp , tvc.coupon_id, tvc.code, tvc.user_id FROM tbl_selected_vendor_coupons tvc 
 join tbl_student s on  s.id=tvc.user_id and s.school_id=tvc.school_id where  (tvc.timestamp BETWEEN '$from' AND '$to') and  
 tvc.entity_id='3' AND 
 (tvc.used_flag ='used' AND tvc.school_id = '$school_id')
 and 
     ($colname LIKE '%$searchq%') "; 
					$rs_result = mysql_query($sql1);  
					$row1 = mysql_fetch_row($rs_result);  
					$total_records = $row1[0];  
					$total_pages = ceil($total_records / $webpagelimit);
		}
			
		//below query use for search count
		 
					

					if($total_pages == $_GET['spage']){
					$webpagelimit = $total_records;
					}else{
					$webpagelimit = $start_from + $webpagelimit;
					}
					 
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Sponsor Information</title>
    <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>

    <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
	<script src="js/jquery.twbsPagination.js" type="text/javascript"></script>
    <script>
	
        $(document).ready(function () {
            $('#example').dataTable( {
			"paging":   false,
	"info":false,
	"searching": true,
     "scrollCollapse": true,
	 "scrollX":true
            });
        });
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
			window.location.assign('vendor_coupon_purchase_student.php?from=<?php echo $from; ?>&to=<?php echo $to; ?>&page='+page);
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
			window.location.assign('vendor_coupon_purchase_student.php?Search=<?php echo $searchq; ?>&from=<?php echo $from; ?>&to=<?php echo $to; ?>&spage='+page);
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
               /* width: 45%; */
                padding-right: 10px;
                white-space: nowrap;
               /* text-align: left; */

            }
            /*
            Label the data
            */
            #no-more-tables td:before {
                content: attr(data-title);
            }
        }
    </style>
	
</head>


<body bgcolor="#CCCCCC">


<div align="center">
    <div class="container" style="width:100%;">
        <div style="padding-top:30px;">

            <h2 style="padding-left:20px; margin-top:2px;color:#666">Vendor Coupons Used By <?php echo $dynamic_student;?></h2>

        </div>
		<div class='row'>
		<form style="margin-top:5px;">
			 <div class="col-md-4" style="width:35%;">
			 </div>
			 
			 
		<!--<div class="col-md-2" style="width:17%;">
				<input type="text" class="form-control" name="Search" value="<?php echo $searchq; ?>" placeholder="Search.." required> 
			</div>
			<div class="col-md-1" >
			<button type="submit" value="Search" class="btn btn-primary">Search</button>
			</div>
			<div class="col-md-1" >
			<input type="button" class="btn btn-info" value="Reset" onclick="window.open('vendor_coupon_purchase_student.php','_self')" />
			</div>-->
			
			
		</form>
		 </div>
		 <div class="row">

<div class="col-md-2" style="padding-right: 0px; padding-left: 0px;">
</div>
		<?php
		if (isset($_GET['Search']))
		{
			
			$count=mysql_num_rows($query1);
			if($count == 0){
				
				echo "<script>$('#show').css('display','none');</script><div style='margin-top:20px;'><font color='Red'><b>There Was No Search Result</b></font></div>";	
			}
			else
			{
			?>
			<div id="no-more-tables" style="padding-top:20px;">

            <table id="example" class="col-md-12 table-bordered " align="center">
                <thead>
				<!-- <tr><?php echo $sql1; ?></tr> -->
                <tr style="background-color:#0073BD; color:#FFFFFF; height:30px;">
        <th>Sr.No.</th>
		<th><?php echo $dynamic_student; ?> Name</th>
		<th>Member ID</th>
		<th><?php echo $organization;?> ID</th>
		<th>Coupon ID</th>
		<th>Coupon Code</th>
				<th>Purchase Date</th>	
                </tr>
                </thead>
				<?php $i = 1;
				 $i = ($start_from +1);
                while($result = mysql_fetch_array($query1)) {
                    ?>
                    <tr>
						<td data-title="Sr.No."><?php echo $i; ?></td>
						<td data-title="<?php echo $dynamic_student;?> Name"><?php echo $result['std_complete_name'];?></td>
					    <td data-title="Member ID"><?php echo $result['user_id']; ?></td>
                        <td data-title="<?php echo $organization;?> ID"><?php echo $result['school_id']; ?></td>
                        <td data-title="Coupon ID"><?php echo $result['coupon_id']; ?></td>
						<td data-title="Coupon Code"><?php echo $result['code']; ?></td>
						<td data-title="Purchase Date"><?php echo $result['timestamp']; ?></td>
					</tr>
				<?php $i++;?>
               <?php } ?>
			   </tbody>
            </table>
				
        </div>
		<div align=left>
			<?php if (!($_GET['Search']))
		 			{echo $webpagelimit;
		 				if ($webpagelimit >$total_records){ $webpagelimit=$total_records;}
		 				echo "<div style='margin-top:5px;'><font color='#0073BD'><b style='margin-center:600px;'>Now showing ".($start_from +1)." to ".($webpagelimit)." records out of ".$total_records. " records.</b></font></div>";
		    }else
		 			{
		 				if ($webpagelimit >$total_records){ $webpagelimit=$total_records;}
		 				echo "<div style='margin-top:5px;'><font color='#0073BD'><b style='margin-center:600px;'>Now showing ".($start_from +1)." to ".($webpagelimit)." records out of ".($total_records). " records.</b></font></div>";
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
       <div id="no-more-tables" class="col-md-12 table-responsive" style="padding-top:20px;">

	   <table id="example" class="table table-bordered">
                <thead>
				<!-- <tr><?php echo $sql1; ?></tr> -->
                <tr style="background-color:#0073BD; color:#FFFFFF; ">
        <th>Sr.No.</th>
		<th><?php echo $dynamic_student;?> Name</th>
		<th>Member ID</th>
		<th><?php echo $organization;?> ID</th>
		<th>Coupon ID</th>
		<th>Coupon Code</th>
				<th>Purchase Date</th>	
                </tr>
                </thead>
				<tbody>
					<?php 
					$i = 1;
				 $i = ($start_from +1);?>
				 <?php
                while($result = mysql_fetch_array($sql)) {
                    ?>
                   
				
                        <td data-title="Sr.No."><?php echo $i; ?></td>
                        <td data-title="<?php echo $dynamic_student;?> Name"><?php echo $result['std_complete_name'];?></td>
					    <td data-title="Member ID"><?php echo $result['user_id']; ?></td>
                        <td data-title="<?php echo $organization;?> ID"><?php echo $result['school_id']; ?></td>
                        <td data-title="Coupon ID"><?php echo $result['coupon_id']; ?></td>
						<td data-title="Coupon Code"><?php echo $result['code']; ?></td>
						<td data-title="Purchase Date"><?php echo $result['timestamp']; ?></td>
					</tr>
					 <?php $i++;1?>
              <?php  } ?>
			  </tbody>
            </table>
				
			
        </div>

		<div align=left>
			<?php if (!($_GET['Search']))
		 			{
		 				if ($webpagelimit >$total_records){ $webpagelimit=$total_records;}
		 				echo "<div style='margin-top:5px;'><font color='#0073BD'><b style='margin-center:600px;'>Now showing ".($start_from +1)." to ".($webpagelimit)." records out of ".$total_records. " records.</b></font></div>";
		    }else
		 			{
		 				if ($webpagelimit >$total_records){ $webpagelimit=$total_records;}
		 				echo "<div style='margin-top:5px;'><font color='#0073BD'><b style='margin-center:600px;'>Now showing ".($start_from +1)." to ".($webpagelimit)." records out of ".($total_records). " records.</b></font></div>";
		 			}
		 			?>
		</div>
			
		<div class="container">
			<nav aria-label="Page navigation">
			  <ul class="pagination" id="pagination"></ul>
		    </nav>
		</div>

<?php } ?>


            
        </div>
    </div>
</div>

</div>
</div>
</body>
</html>