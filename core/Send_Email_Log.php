<?php
error_reporting(0);
include("scadmin_header.php");
$id=$_SESSION['id'];
$fields=array("id"=>$id);
$table="tbl_school_admin";
$results = $smartcookie->retrive_individual($table, $fields);
$result = mysql_fetch_array($results);
$school_id = $result['school_id'];
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" href="css/bootstrap.min.css">
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
<script src='js/bootstrap.min.js' type='text/javascript'></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.cs">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script src="../js/jquery.twbsPagination.js" type="text/javascript"></script>

</head>

<body>
<table class="table">
  <thead>
    <tr>
      <th scope="col">S.no</th>
      <th scope="col">Email / Phone</th>
      <th scope="col">Method</th>
      <th scope="col">Reason</th>
      <th scope="col">Send Time Stamp</th>
    </tr>
  </thead>
  <tbody>
    <?php
    //  $webpagelimit = 10;
    // if (isset($_GET["page"])){ $page  = mysql_real_escape_string($_GET["page"]); } else { $page=1; };  
    // $start_from = ($page-1) * $webpagelimit;
   

      $sql1 ="SELECT * FROM tbl_otp_log WHERE delivery_method ='Email' and school_id ='$school_id' ";
        $result = mysql_query($sql1);
        $s = 1;
        // $sql2 ="SELECT * FROM tbl_otp_log WHERE delivery_method ='Email' and school_id ='$school_id'";
        // $rs_result = mysql_query($sql2);  
		// 			$row1 = mysql_fetch_row($rs_result);  
		// 			$total_records = $row1[0];  
		// 			$total_pages = ceil($total_records / $webpagelimit);
		// 			if($total_pages == $_GET['page']){
		// 			$webpagelimit = $total_records;
		// 			}else{
		// 			$webpagelimit = $start_from + $webpagelimit;
		// 			}

        while ($row = mysql_fetch_array($result)) {
        ?>
            <tr>
                <td><?php echo $s++; ?></td>
                <td><?php echo $row['phone_email']; ?></td>
                <td><?php echo $row['delivery_method']; ?></td>
                <td><?php echo $row['reason']; ?></td>
                <td><?php echo $row['created_date']; ?></td>
              
            </tr>
        <?php } ?>
 
  </tbody>

</table>
 <!-- <div class="container">
			<nav aria-label="Page navigation">
			  <ul class="pagination" id="pagination"></ul>
		    </nav>
		</div> -->
</body>
<!-- <script type="text/javascript">
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
			window.location.assign('Send_Email_Log.php?colname=<?php echo $colname;?>&Search=<?php echo $searchq; ?>&spage='+page);
        });
    });
</script> -->
</html>
