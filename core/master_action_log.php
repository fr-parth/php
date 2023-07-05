<?php
include("cookieadminheader.php");

$group_member_id = $_SESSION['group_admin_id'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title> Master Action Log Layout</title>
    <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>

    <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
    <script src="js/jquery.twbsPagination.js" type="text/javascript"></script>
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
    <?php

if (!($_GET['Search'])){

if (isset($_GET["page"])){ $page  = mysql_real_escape_string($_GET["page"]); } else { $page=1; };  
$start_from = ($page-1) * $webpagelimit;
    
$sql=mysql_query("select * from tbl_master_action_log order by action_tracking_number DESC
LIMIT $start_from, $webpagelimit"); 

$sql1 ="select count(*) from tbl_master_action_log order by action_tracking_number DESC"; 
 
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
    if ($searchq != '')
    { 
        $query1=mysql_query("select * from tbl_master_action_log 
where
  action_tracking_number LIKE '%$searchq%' or action_date_time LIKE '%$searchq%'
  or action_description LIKE '%$searchq%' or 
  actor_mem_id LIKE '%$searchq%' or actor_name LIKE '%$searchq%' 
  or actor_entity_type LIKE '%$searchq%' or receiver_mem_id LIKE '%$searchq%'
 or third_party_name LIKE '%$searchq%' or third_party_entity_type LIKE '%$searchq%'
 or points LIKE '%$searchq%' or coupon_id LIKE '%$searchq%' or product LIKE '%$searchq%'
 or value LIKE '%$searchq%'  or currency LIKE '%$searchq%'
            order by
        action_tracking_number DESC
  LIMIT $start_from, $webpagelimit") or die("could not Search!");
            
            $sql1 ="select count(*) from tbl_master_action_log 
where
  action_tracking_number LIKE '%$searchq%' or action_date_time LIKE '$searchq%'
  or action_description LIKE '%$searchq%' or 
  actor_mem_id LIKE '$searchq%' or actor_name LIKE '%$searchq%' 
  or actor_entity_type LIKE '%$searchq%' or receiver_mem_id LIKE '%$searchq%'
 or receiver_name LIKE '%$searchq%' or receiver_entity_type LIKE '%$searchq%'
 or third_party_name LIKE '%$searchq%' or third_party_entity_type LIKE '%$searchq%'
 or points LIKE '%$searchq%' or coupon_id LIKE '%$searchq%' or product LIKE '%$searchq%'
 or value LIKE '%$searchq%'  or currency LIKE '%$searchq%'
            order by
        action_tracking_number DESC "; 

            $rs_result = mysql_query($sql1);  
                    $row1 = mysql_fetch_row($rs_result);  
                    $total_records = $row1[0];  
                    $total_pages = ceil($total_records / $webpagelimit);

    }else{
    
    //$q1="SELECT std_name,std_Father_name,std_lastname,std_complete_name,school_id,std_school_name,std_email,std_phone,std_address from tbl_student where group_member_id = '$group_member_id' AND (std_name LIKE '$searchq%' or std_Father_name LIKE '$searchq%' or std_lastname LIKE '$searchq%' or std_complete_name LIKE '%$searchq%' or school_id LIKE '$searchq%' or std_school_name LIKE '%$searchq%' or std_email LIKE '$searchq%' or std_phone LIKE '$searchq%'or std_address LIKE '$searchq%') order by school_id";
$query1=mysql_query("select * from tbl_master_action_log 
where
 
   $colname LIKE '%$searchq%' order by action_tracking_number DESC
LIMIT $start_from, $webpagelimit")
 
        or die("could not Search!");
                    //echo $query1;
        $sql1 ="select count(*) from tbl_master_action_log 
where
   $colname LIKE '%$searchq%' order by action_tracking_number DESC"; 
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
            window.location.assign('master_action_log.php?page='+page);
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
            window.location.assign('master_action_log.php?Search=<?php echo $searchq; ?>&spage='+page);
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

            <h2 style="padding-left:20px; margin-top:2px;color:#666"> Master Action Log Layout</h2>

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
            <input type="button" class="btn btn-info" value="Reset" onclick="window.open('master_action_log.php','_self')" />
            </div>
                    
        
                    <!-- <div style="margin-left: 800px;">
                        <input type="text" name="Search" value="" placeholder="Search..">
                        <input type="submit" value="Search">
                        <input type="button" value="Reset" onclick="window.open('beneficiary_list.php','_self')" />
                    </div> -->
                    
                    
                    
                    
        </form>
         </div> 
         <!-- <div id="show" >
                <?php if (!($_GET['Search']))
                    {
                        if ($webpagelimit >$total_records){ $webpagelimit=$total_records;}
                        echo "<div style='margin-top:5px;'><font color='blue'><b style='margin-left:600px;' align='left'>Now showing ".($start_from +1)." to ".($webpagelimit)." records out of ".$total_records. " records.</b></font></div>";
            }else
                    {
                        if ($webpagelimit >$total_records){ $webpagelimit=$total_records;}
                        echo "<div style='margin-top:5px;'><font color='blue'><b style='margin-left:600px;'>Now showing ".($start_from +1)." to ".($webpagelimit)." records out of ".($total_records). " records.</b></font></div>";
                    }
                    ?>
         </div> -->
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
                    <th>  Action Track No</th>
                   <th>Action Date</th>
                    <th> Action Description</th>
                    <th> Actor Member ID</th>
                   <th>Actor Name</th>
                   <th> Actor Entity Type</th>
                   <th> Second/Receiver Member ID</th>
                   <th> Second Party Receiver Name</th>
                   <th> Second Party Entity Type</th>
                   <th> Third Party Name</th>
                   <th> Third Party Entity Type</th>
                   <th> Points</th>
                   <th>Coupon ID</th>
                   <th>Product</th>
                   <th>Value</th>
                   <th>Currency</th>
                   
                </tr>
                </thead>

                <?php $i = 1;
                    $i = ($start_from +1);
                while($result = mysql_fetch_array($query1)) {
                    
                    ?>
                    <tr>
                        <td data-title="Sr.No."><?php echo $i; ?></td>
                        
                       
                       
                        <td data-title="Action Track No"><?php echo $result['action_tracking_number']; ?></td>
                        <td data-title="Action Date"><?php echo $result['action_date_time']; ?></td>
                        <td data-title="Action Description"><?php echo $result['action_description']; ?></td>
                        <td data-title="Actor Member ID"><?php echo $result['actor_mem_id']; ?></td>
                        <td data-title="Actor Name"><?php echo $result['actor_name']; ?></td>
                        <td data-title="Actor Entity Type"><?php echo $result['actor_entity_type']; ?></td>
                        <td data-title="Second/Receiver Member ID"><?php echo $result['receiver_mem_id']; ?></td>
                        <td data-title="Second Party Receiver Name"><?php echo $result['receiver_name']; ?></td>
                        <td data-title="Second Party Entity Type"><?php echo $result['receiver_entity_type']; ?></td>
                        <td data-title="Third Party Name"><?php echo $result['third_party_name']; ?></td>
                        <td data-title="Third Party Entity Type"><?php echo $result['third_party_entity_type']; ?></td>
                        <td data-title="Points"><?php echo $result['points']; ?></td>
                        <td data-title="Coupon ID"><?php echo $result['coupon_id']; ?></td>
                        <td data-title="Product"><?php echo $result['product']; ?></td>
                        <td data-title="Value"><?php echo $result['value']; ?></td>
                        <td data-title="Currency"><?php echo $result['currency']; ?></td>
                        
                        
                        
                    </tr>
                    <?php $i++;
                } ?>
            </table>
        </div>
        <div align='left'>
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
                    <th>  Action Track No</th>
                   <th>Action Date</th>
                    <th> Action Description</th>
                    <th> Actor Member ID</th>
                   <th>Actor Name</th>
                   <th> Actor Entity Type</th>
                   <th> Second/Receiver Member ID</th>
                   <th> Second Party Receiver Name</th>
                   <th> Second Party Entity Type</th>
                   <th> Third Party Name</th>
                   <th> Third Party Entity Type</th>
                   <th> Points</th>
                   <th>Coupon ID</th>
                   <th>Product</th>
                   <th>Value</th>
                   <th>Currency</th>
                   
                </tr>
                
                </thead>

                <?php $i = 1;
                 $i = ($start_from +1);
                while($result = mysql_fetch_array($sql)) {
                
                    ?>
                    <tr>
                        <td data-title="Sr.No."><?php echo $i; ?></td>
                        
                       
                       
                        <td data-title="Action Track No"><?php echo $result['action_tracking_number']; ?></td>
                        <td data-title="Action Date"><?php echo $result['action_date_time']; ?></td>
                        <td data-title="Action Description"><?php echo $result['action_description']; ?></td>
                        <td data-title="Actor Member ID"><?php echo $result['actor_mem_id']; ?></td>
                        <td data-title="Actor Name"><?php echo $result['actor_name']; ?></td>
                        <td data-title="Actor Entity Type"><?php echo $result['actor_entity_type']; ?></td>
                        <td data-title="Second/Receiver Member ID"><?php echo $result['receiver_mem_id']; ?></td>
                        <td data-title="Second Party Receiver Name"><?php echo $result['receiver_name']; ?></td>
                        <td data-title="Second Party Entity Type"><?php echo $result['receiver_entity_type']; ?></td>
                        <td data-title="Third Party Name"><?php echo $result['third_party_name']; ?></td>
                        <td data-title="Third Party Entity Type"><?php echo $result['third_party_entity_type']; ?></td>
                        <td data-title="Points"><?php echo $result['points']; ?></td>
                        <td data-title="Coupon ID"><?php echo $result['coupon_id']; ?></td>
                        <td data-title="Product"><?php echo $result['product']; ?></td>
                        <td data-title="Value"><?php echo $result['value']; ?></td>
                        <td data-title="Currency"><?php echo $result['currency']; ?></td>
                    </tr>
                    <?php $i++;
                } ?>
            </table>
        </div>
<div align='left'>
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