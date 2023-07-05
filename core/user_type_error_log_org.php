<?php 
/*
Author:Sayali Balkawade
Date:02/11/2020
This file is created for display error log summary of user type with count for SMC-4929.
*/
include('corporate_cookieadminheader.php');
ob_start();
 $index_url=$GLOBALS['URLNAME'];
if($_SESSION['from'] =='')
{
	$_SESSION['from']=date('Y-m-d');
}
if( $_SESSION['to'] =='')
{
$_SESSION['to'] =date('Y-m-d 23:59:59');
}

if (isset($_GET["page"])){ $page  = mysql_real_escape_string($_GET["page"]); } else { $page=1; };  
$start_from = ($page-1) * $webpagelimit;
	
$sql=mysql_query("select id,user_type from tbl_error_log where user_type !='' and (datetime between '".$_SESSION['from']."' and '".$_SESSION['to']."') group by user_type LIMIT $start_from, $webpagelimit");	

$sql1 ="select id, user_type from tbl_error_log where user_type !='' and (datetime between '".$_SESSION['from']."' and '".$_SESSION['to']."') group by user_type ";  
					$rs_result = mysql_query($sql1);  
					$row1 = mysql_num_rows($rs_result);  
					
					$total_records = $row1;  
					$total_pages = ceil($total_records / $webpagelimit);
					if($total_pages == $_GET['page']){
					$webpagelimit = $total_records;
					}else{
					$webpagelimit = $start_from + $webpagelimit;
					}

			
		//below query use for search count
		 
					

					if($total_pages == $_GET['spage']){
					$webpagelimit = $total_records;
					}else{
					$webpagelimit = $start_from + $webpagelimit;
					}
					 

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>User error log</title>
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
	"searching": false,
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
			window.location.assign('user_type_error_log_org.php?page='+page);
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
			window.location.assign('user_type_error_log_org.php?Search=<?php echo $searchq; ?>&spage='+page);
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
                width: 45%;
                padding-right: 10px;
                white-space: nowrap;
                text-align: left;

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

            <h2 style="padding-left:20px; margin-top:2px;color:#666"> User Type List</h2>

        </div>
		<div class='col-md-2'><a href="errorlog_summary_org.php?fr=<?php echo $_SESSION['from'];?>&too=<?php echo $_SESSION['to'];?>"><button type="button" id="back" name="back" class="btn btn-success" align="right">Back</button></a></div>
		<div class='row'>
		<form style="margin-top:5px;">
			 <div class="col-md-4" style="width:35%;">
			 </div>
		
			
		</form>
		 </div>
			
		 <!-- <div id="show" >
		 		<?php if (!($_GET['Search']))
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
		<?php

					
		?>
        <div id="no-more-tables" style="padding-top:20px;">

            <table id="example" class="col-md-12 table-bordered " align="center">
                <thead>
				<!-- <tr><?php echo $sql1; ?></tr> -->
                <tr style="background-color:#0073BD; color:#FFFFFF; height:30px;">
                    <th>Sr. No.</th>
                    <th>User Type</th>
                    <th>Count</th>
                   
					
                </tr>
                </thead>
				
				

                <?php $i = 1;
				 $i = ($start_from +1);
                while($result = mysql_fetch_array($sql)) {
					
					$querys=mysql_query("select id,user_type from tbl_error_log where user_type ='".$result['user_type']."' and (datetime between '".$_SESSION['from']."' and '".$_SESSION['to']."')");
					
					$sqls=mysql_num_rows($querys);
                    ?>
					
					
                    <tr>
				
                        <td data-title="Sr.No."><?php echo $i; ?></td>
						<?php if($result['user_type']=='105' || $result['user_type']=='STUDENT' || $result['user_type']=='student' || $result['user_type']=='105(Student)'){
							$a='Student';
						}
						else if($result['user_type']=='103' ||$result['user_type']=='teacher' || $result['user_type']=='2')
						{
							$a='Teacher';
						}
						else if($result['user_type']=='205' || $result['user_type']=='205(Employee)')
						{
							$a='Employee';
						}
						else if($result['user_type']=='203' || $result['user_type']=='10' || $result['user_type']=='manager')
						{
							$a='Manager';
						}
						else if ($result['user_type']=='1' )
						{
							$a='School Admin';
						}
						else if ($result['user_type']=='11' )
						{
							$a='HR Admin';
						}
						else if ($result['user_type']=='13' )
						{
							$a='Group Admin';
						}
						else if ($result['user_type']=='5' )
						{
							$a='Parent';
						}
						else if ($result['user_type']=='6' )
						{
							$a='Cookie Admin';
						}
						else if ($result['user_type']=='7' )
						{
							$a='School Admin Staff';
						}
						else if ($result['user_type']=='71' )
						{
							$a='HR Admin Staff';
						}
						else if ($result['user_type']=='8' )
						{
							$a='Cookie Admin Staff';
						}else 
						{
							$a=$result['user_type'];
						}
						?>
                        <td data-title="User Type"><?php echo $a;?></td>
                        <td data-title="Count"><?php echo $sqls;?></td>
					   
					</tr>
					
                    <?php $i++;
                } ?>
            </table>
			<?php 
			$qr=mysql_query("select  user_type from tbl_error_log where user_type !='' and (datetime between '".$_SESSION['from']."' and '".$_SESSION['to']."') ");
									$result = mysql_num_rows($qr);
                                                 
												 
												 ?>
												 <br>
											<div style="font-weight: bold;margin-left:754px;font-weight: 900;font-size: 100%;">Grand Total :&nbsp;&nbsp;&nbsp; <?php echo $result;?></div> 
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


	<div style="padding-top:50px;">

            
        </div>
    </div>
</div>

</div>
</div>
</body>
</html>