<?php
//sponsored_coupons
include("groupadminheader.php");
//Comment include conn file to display coupon by Dhanashri
//@include 'conn.php';
//$user_id=$_SESSION['id'];
//coupon deletion

	
//echo $sp_id;
$sp_id=$_GET['cpns'];



	
	

if(isset($_GET['del'])){
	$del=$_GET['del'];
	mysql_query(" DELETE FROM `tbl_sponsored` WHERE `id`= $del ");
	header("Location:sponsored_coupons.php?cpns='$sp_id'");
}



if (!($_GET['Search'])){
	
if (isset($_GET["page"])){ $page  = mysql_real_escape_string($_GET["page"]); } else { $page=1; };  
$start_from = ($page-1) * $webpagelimit;
//echo "hi";
	

$sql=mysql_query("SELECT s.id,c.category,s.Sponser_product,s.product_image,
s.points_per_product,s.sponsered_date,s.valid_until,s.currency,s.product_price,
s.discount,s.buy,s.saving,s.offer_description,s.daily_limit,s.total_coupons,
s.coupon_code_ifunique,s.priority FROM tbl_sponsored s left join categories c on 
s.category=c.id WHERE s.sponsor_id = '$sp_id' order by s.id
LIMIT $start_from, $webpagelimit");	


$sql1 ="SELECT count(s.id),c.category,s.Sponser_product,s.product_image,
s.points_per_product,s.sponsered_date,s.valid_until,s.currency,s.product_price,
s.discount,s.buy,s.saving,s.offer_description,s.daily_limit,s.total_coupons,
s.coupon_code_ifunique,s.priority FROM tbl_sponsored s left join categories c on 
s.category=c.id WHERE s.sponsor_id = '$sp_id' order by s.id"; 
 
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
	
	echo $sp_id=$_GET['cpns'];
	if (isset($_GET["spage"])){ $spage  = mysql_real_escape_string($_GET["spage"]); } else { $spage=1; };  
$start_from = ($spage-1) * $webpagelimit;

$searchq=mysql_real_escape_string($_GET['Search']);
//$colname=mysql_real_escape_string($_GET['colname']);
	if ($searchq != '')
	{ 
		$query1=mysql_query("SELECT s.id,c.category,s.Sponser_product,
		s.product_image,s.points_per_product,s.sponsered_date,s.valid_until,s.currency,
		s.product_price,s.discount,s.buy,s.saving,s.offer_description,s.daily_limit,
		s.total_coupons,s.coupon_code_ifunique,s.priority FROM tbl_sponsored s 
		left join categories c on s.category=c.id WHERE s.sponsor_id = '158' and 
		s.id LIKE '%$searchq%' or s.Sponser_product LIKE '%$searchq%' or s.product_image LIKE
	'%$searchq%'or s.points_per_product LIKE '%$searchq%' or s.sponsered_date LIKE '%$searchq%'
or s.valid_until LIKE '%$searchq%' or s.currency LIKE '%$searchq%' or s.product_price LIKE '%$searchq%'
 or s.discount LIKE '%$searchq%' or s.buy LIKE '$searchq%'
  or s.saving LIKE '%$searchq%' or s.offer_description LIKE '%$searchq%'
 or s.daily_limit LIKE '%$searchq%' or s.total_coupons LIKE '%$searchq%'
 or s.coupon_code_ifunique LIKE '%$searchq%' or s.priority LIKE '%$searchq%' 
 or c.category LIKE '%$searchq%'
  order by s.id LIMIT $start_from, $webpagelimit") or die("could not Search!");
			
			$sql1 ="SELECT count(s.id),c.category,s.Sponser_product,
		s.product_image,s.points_per_product,s.sponsered_date,s.valid_until,s.currency,
		s.product_price,s.discount,s.buy,s.saving,s.offer_description,s.daily_limit,
		s.total_coupons,s.coupon_code_ifunique,s.priority FROM tbl_sponsored s 
		left join categories c on s.category=c.id WHERE s.sponsor_id = '158' and 
		s.id LIKE '%$searchq%' or s.Sponser_product LIKE '%$searchq%' or s.product_image LIKE
	'$searchq%'or s.points_per_product LIKE '%$searchq%' or s.sponsered_date LIKE '%$searchq%'
or s.valid_until LIKE '%$searchq%' or s.currency LIKE '%$searchq%' or s.product_price LIKE '%$searchq%'
 or s.discount LIKE '%$searchq%' or s.buy LIKE '$searchq%'
  or s.saving LIKE '%$searchq%' or s.offer_description LIKE '%$searchq%'
 or s.daily_limit LIKE '%$searchq%' or s.total_coupons LIKE '%$searchq%'
 or s.coupon_code_ifunique LIKE '%$searchq%' or s.priority LIKE '%$searchq%' 
 or c.category LIKE '%$searchq%' order by s.id"; 

			$rs_result = mysql_query($sql1);  
					$row1 = mysql_fetch_row($rs_result);  
					$total_records = $row1[0];  
					$total_pages = ceil($total_records / $webpagelimit);

	}else{
			//$q1="SELECT std_name,std_Father_name,std_lastname,std_complete_name,school_id,std_school_name,std_email,std_phone,std_address from tbl_student where group_member_id = '$group_member_id' AND (std_name LIKE '$searchq%' or std_Father_name LIKE '$searchq%' or std_lastname LIKE '$searchq%' or std_complete_name LIKE '%$searchq%' or school_id LIKE '$searchq%' or std_school_name LIKE '%$searchq%' or std_email LIKE '$searchq%' or std_phone LIKE '$searchq%'or std_address LIKE '$searchq%') order by school_id";
$query1=mysql_query("SELECT s.id,s.category,c.category,s.Sponser_product,s.product_image,
s.points_per_product,s.sponsered_date,s.valid_until,s.currency,s.product_price,
s.discount,s.buy,s.saving,s.offer_description,s.daily_limit,s.total_coupons,
s.coupon_code_ifunique,s.priority FROM tbl_sponsored s left join categories c on 
s.category=c.id WHERE s.sponsor_id = '158' and
 $colname LIKE '%$searchq%' order by s.id
LIMIT $start_from, $webpagelimit")
 
		or die("could not Search!");
					//echo $query1;
		$sql1 ="SELECT count(s.id),s.category,c.category,s.Sponser_product,s.product_image,
s.points_per_product,s.sponsered_date,s.valid_until,s.currency,s.product_price,
s.discount,s.buy,s.saving,s.offer_description,s.daily_limit,s.total_coupons,
s.coupon_code_ifunique,s.priority FROM tbl_sponsored s left join categories c on 
s.category=c.id WHERE s.sponsor_id = '$sp_id' and
 $colname LIKE '%$searchq%' order by s.id"; 
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
    <title>Coupons Sponsored By </title>
    <link rel="stylesheet" type="text/css" href="../css/jquery.dataTables.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="../js/jquery-1.11.1.min.js"></script>
    <script src="../js/jquery.dataTables.min.js"></script>

    <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
	<script src="../js/jquery.twbsPagination.js" type="text/javascript"></script>
    <script>
    $(document).ready(function() {
    $('#example').dataTable( {
	"paging":   false,
	"info":false,
	"searching": false,
     "scrollCollapse": true,
	 "scrollX": true
    } );
} );
    </script>

<script>
function confirmation(xxx) {

    var answer = confirm("Are you sure you want to delete?")
    if (answer){
        
        window.location = "sponsored_coupons.php?cpns=<?php echo $sp_id?>&del="+xxx;
    }
    else{
       
    }
}
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
			window.location.assign('sponsored_coupons.php?cpns=<?php echo $sp_id?>&page='+page);
        });
    });
</script>
<?php }else{
	$sp_id=$_GET['cpns'];
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
			window.location.assign('sponsored_coupons.php?cpns=158Search=<?php echo $searchq; ?>&spage='+page);
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

            <h2 style="padding-left:20px; margin-top:2px;color:#666">Coupons</h2>

        </div>
		
		<div class='row'>
		<form style="margin-top:5px;">
			 <div class="col-md-4" style="width:35%;">
			 </div>
          
			<div class="col-md-2" style="width:17%;">
				<input type="text" class="form-control" name="Search" value="<?php echo $searchq; ?>" placeholder="Search.." required> 
			</div>
			<div class="col-md-1" >
			<button type="submit" value="Search" class="btn btn-primary">Search</button>
			</div>
			<div class="col-md-1" >
			<input type="button" class="btn btn-info" value="Reset" onclick="window.open('sponsored_coupons.php?cpns=<?php echo $sp_id; ?>','_self')" />
			</div>
					
		
					<!-- <div style="margin-left: 800px;">
						<input type="text" name="Search" value="" placeholder="Search..">
						<input type="submit" value="Search">
						<input type="button" value="Reset" onclick="window.open('beneficiary_list.php','_self')" />
					</div> -->
					
					
					
					
		</form>
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
                    <th>  Coupon ID </th>
                   <th>Product Name</th>
                    <th> Image</th>
					<th> Points</th>
                   <th>Start Date</th>
				   <th> End Date</th>
				   <th> Category</th>
				   <th> Price</th>
				   <th>Discount</th>
                    <th> Buy </th>
                   
                    <th> Saving</th>
					<th> Description</th>
                   <th>Daily Limit</th>
				   <th> Total Coupons</th>
				   <th> Unique Code</th>
				   <th> Priority</th>
				   <th> Set Priority</th>
				   <th> Delete</th>
                </tr>
                </thead>

                <?php $i = 1;
					$i = ($start_from +1);
                while($result = mysql_fetch_array($query1)) {
					
                    ?>
                    <tr>
                        <td data-title="Sr.No."><?php echo $i; ?></td>
                        
                       
                       
                        <td data-title="Coupon ID"><?php echo $result['id']; ?></td>
                        <td data-title="Product Name"><?php echo $result['Sponser_product']; ?></td>
                        <td data-title="Image"><?php echo $result['product_image']; ?></td>
						<td data-title="Points"><?php echo $result['points_per_product']; ?></td>
						<td data-title="Start Date"><?php echo $result['sponsered_date']; ?></td>
						<td data-title="End Date"><?php echo $result['valid_until']; ?></td>
						<td data-title="Category"><?php echo $result['category']; ?></td>
						<td data-title="Price"><?php echo $result['currency'].' '.$result['product_price']; ?></td>
						<td data-title="Discount"><?php echo $result['discount']; ?></td>
                        <td data-title="Buy"><?php echo $result['buy']; ?></td>
                        
						<td data-title="Saving"><?php echo $result['saving']; ?></td>
						<td data-title="Description"><?php echo $result['offer_description']; ?></td>
						<td data-title="Daily Limit"><?php echo $result['daily_limit']; ?></td>
						<td data-title="Total Coupons"><?php echo $result['total_coupons']; ?></td>
						<td data-title="Unique Code"><?php echo $result['coupon_code_ifunique']; ?></td>
						<td data-title="Priority"><?php echo $result['priority']; ?></td>
						
                    <td><a href="single_field_edit.php?pri=<?php echo $result['id']; ?>" ><button type="button" class="btn btn-primary">Set Priority</button></a></td>
	<td><a href="#" ><button class='glyphicon glyphicon-trash' alt="Location" style="width:35px;height:42px;" onClick="confirmation(<?php echo  $result['id']; ?>)"></button></a>
</td>
	</tr>
                    <?php $i++;
                } ?>
            </table>
        </div>
		<!--div>
		<?php //$start=$start_from+1;
		 //echo "Showing $start to $webpagelimit out of $total_records";?>
		</div-->
		
		<div>
		 		<?php if (!($_GET['Search']))
		 			{
		 				if ($webpagelimit >$total_records){ $webpagelimit=$total_records;}
		 				echo "<div style='margin-top:5px;'><font color='#0073BD'><style='margin-left:600px;'>Now showing ".($start_from +1)." to ".($webpagelimit)." records out of ".$total_records. " records.</font></style></div>";
		    }else
		 			{
		 				if ($webpagelimit >$total_records){ $webpagelimit=$total_records;}
		 				echo "<div style='margin-top:5px;'><font color='#0073BD'><style='margin-left:600px;'>Now showing ".($start_from +1)." to ".($webpagelimit)." records out of ".($total_records). " records.</font></style></div>";
		 			}
		 			?>
		 </div>
			<div class="container">
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

            <table id="example" class="col-md-10 table-bordered " align="center">
                <thead>

                <tr style="background-color:#0073BD;; color:#FFFFFF; height:30px;">
                     <th>Sr.No.</th>
                    <th>  Coupon ID </th>
                   <th>Product Name</th>
                    <th> Image</th>
					<th> Points</th>
                   <th>Start Date</th>
				   <th> End Date</th>
				   <th> Category</th>
				   <th> Price</th>
				   <th>Discount</th>
                    <th> Buy </th>
                   
                    <th> Saving</th>
					<th> Description</th>
                   <th>Daily Limit</th>
				   <th> Total Coupons</th>
				   <th> Unique Code</th>
				   <th> Priority</th>
				   <th> Set Priority</th>
				   <th> Delete</th>
				   
                </tr>
				
                </thead>

                <?php $i = 1;
					$i = ($start_from +1);
                while($result = mysql_fetch_array($sql)) {
					
                    ?>
                    <tr>
                        <td data-title="Sr.No."><?php echo $i; ?></td>
                        
                       
                       
                        <td data-title="Coupon ID"><?php echo $result['id']; ?></td>
                        <td data-title="Product Name"><?php echo $result['Sponser_product']; ?></td>
                        <td data-title="Image"><?php echo $result['product_image']; ?></td>
						<td data-title="Points"><?php echo $result['points_per_product']; ?></td>
						<td data-title="Start Date"><?php echo $result['sponsered_date']; ?></td>
						<td data-title="End Date"><?php echo $result['valid_until']; ?></td>
						<td data-title="Category"><?php echo $result['category']; ?></td>
						<td data-title="Price"><?php echo $result['currency'].' '.$result['product_price']; ?></td>
						<td data-title="Discount"><?php echo $result['discount']; ?></td>
                        <td data-title="Buy"><?php echo $result['buy']; ?></td>
                       
						<td data-title="Saving"><?php echo $result['saving']; ?></td>
						<td data-title="Description"><?php echo $result['offer_description']; ?></td>
						<td data-title="Daily Limit"><?php echo $result['daily_limit']; ?></td>
						<td data-title="Total Coupons"><?php echo $result['total_coupons']; ?></td>
						<td data-title="Unique Code"><?php echo $result['coupon_code_ifunique']; ?></td>
						<td data-title="Priority"><?php echo $result['priority']; ?></td>
						
                    <td><a href="single_field_edit.php?pri=<?php echo $result['id']; ?>" ><button type="button" class="btn btn-primary">Set Priority</button></a></td>
	<td><a href="#" ><button class='glyphicon glyphicon-trash' alt="Location" style="width:35px;height:42px;" onClick="confirmation(<?php echo  $result['id']; ?>)"></button></a>
</td>
	</tr>
                    <?php $i++;
                } ?>
            </table>
        </div>
<!--div>
		<?php //$start=$start_from+1;
		 //echo "Showing $start to $webpagelimit out of $total_records";?>
		</div-->
		
		<div>
		 		<?php if (!($_GET['Search']))
		 			{
		 				if ($webpagelimit >$total_records){ $webpagelimit=$total_records;}
		 				echo "<div style='margin-top:5px;'><font color='#0073BD'><style='margin-left:600px;'>Now showing ".($start_from +1)." to ".($webpagelimit)." records out of ".$total_records. " records.</font></style></div>";
		    }else
		 			{
		 				if ($webpagelimit >$total_records){ $webpagelimit=$total_records;}
		 				echo "<div style='margin-top:5px;'><font color='#0073BD'><style='margin-left:600px;'>Now showing ".($start_from +1)." to ".($webpagelimit)." records out of ".($total_records). " records.</font></style></div>";
		 			}
		 			?>
		 </div>
		<div class="container">
			<nav aria-label="Page navigation">
			  <ul class="pagination" id="pagination"></ul>
		    </nav>
		</div>

<?php } ?>

	<div style="padding-top:50px;">

            
        </div>
    </div>
</div>

</div>
</div>
</body>
</html>