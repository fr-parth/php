<?php
include("cookieadminheader.php");

$group_member_id = $_SESSION['group_admin_id'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title> Summary Of Salesperson</title>
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
	
    
   /* if ($category != '') {
        $sql .= "and sp.v_category='$category' order by sp.id desc";
    }
    if ($category == '') {
        $sql .= "order by sp.id desc";
    }
	
	*/
	
	
//echo $sql;


 
	
	
	
	
	$tot=mysql_query("select s.sp_date,sp.p_name,s.sp_company,
s.amount,
s.payment_method from tbl_sponsorer s left join tbl_salesperson
sp on sp.person_id=s.sales_person_id
 order by s.id desc");
 $to=mysql_num_rows($tot);
 
 
	$cash=mysql_query("select s.payment_method from tbl_sponsorer s left join tbl_salesperson
sp on sp.person_id=s.sales_person_id where s.payment_method='cash'
 order by s.id desc");
$c=mysql_num_rows($cash);

 $cheque=mysql_query("select s.payment_method from tbl_sponsorer s left join tbl_salesperson
sp on sp.person_id=s.sales_person_id where s.payment_method='cheque'
 order by s.id desc");
 $ce=mysql_num_rows($cheque);
 
 
 $free=mysql_query("select s.payment_method from tbl_sponsorer s left join tbl_salesperson
sp on sp.person_id=s.sales_person_id where s.payment_method='free register'
 order by s.id desc");
 $f=mysql_num_rows($free);
 
 
 $cashamount=mysql_query("select sum(s.amount) as cashamount1 from tbl_sponsorer s left join tbl_salesperson
sp on sp.person_id=s.sales_person_id where s.payment_method='cash'
 order by s.id desc");
  $r = mysql_fetch_assoc($cashamount); 
$sum = $r['cashamount1'];

 
 $chequeamount=mysql_query("select sum(s.amount) as chequeamount1 from tbl_sponsorer s left join tbl_salesperson
sp on sp.person_id=s.sales_person_id where s.payment_method='cheque'
 order by s.id desc");
 $r1 = mysql_fetch_assoc($chequeamount); 
$sum1 = $r1['chequeamount1'];
 




$t=mysql_query("select sum(s.amount) as tot from tbl_sponsorer s left join tbl_salesperson
sp on sp.person_id=s.sales_person_id
 order by s.id desc");
 
 $r2 = mysql_fetch_assoc($t); 
$sum2 = $r2['tot'];


$from_date = $_GET['from_date'];
    $to_date = $_GET['to_date'];

if ($_GET['find']) {
		if (isset($_GET["fpage"])){ $fpage  = mysql_real_escape_string($_GET["fpage"]); } else { $fpage=1; };  
$start_from = ($fpage-1) * $webpagelimit;

    
    

    if ($from_date != '' && $to_date != '') {
		
   // $sql="SELECT sp.id,sp.sp_company,sp.sp_address,sp.sp_email,sp.sp_phone,sp.sp_website,sp.sp_date,sp.amount,sp.sales_person_id,c.category from tbl_sponsorer sp  join categories c on sp.v_category=c.id  where sp.sales_person_id='$person_id'  and sp.sp_date between '$from_date' and '$to_date' ";
		//echo "SELECT sp.sp_name,sp.sp_img_path,sp.id,sp.source,sp.sp_company,sp.sp_address,sp.sp_email,sp.sp_phone,sp.sp_website,sp.sp_date,sp.amount,sp.sales_person_id,sp.v_category,sp.v_responce_status,sp.comment,sp.calback_date_time,sp.v_status,sp.lat,sp.lon,sp.sales_p_lat,sp.sales_p_lon,sp.entity_id,sp.user_member_id,sp.platform_source,sp.app_version,sp.payment_method,sp.sp_country,sp.calculated_lat,sp.calculated_lon from tbl_sponsorer sp where sp.sales_person_id='$person_id'  and sp.sp_date between '$from_date' and '$to_date' and sp.sp_date!=''";
		
		
		$sq = mysql_query("select s.sp_date,sp.p_name,s.sp_company,
s.amount,
s.payment_method from tbl_sponsorer s left join tbl_salesperson
sp on sp.person_id=s.sales_person_id
  where s.sp_date between '$from_date' and '$to_date' and s.sp_date!='' 
		order by s.id desc
LIMIT $start_from, $webpagelimit");


$sq1 ="select count(s.sp_date),sp.p_name,s.sp_company,
s.amount,
s.payment_method from tbl_sponsorer s left join tbl_salesperson
sp on sp.person_id=s.sales_person_id
  where s.sp_date between '$from_date' and '$to_date' and s.sp_date!='' 
		order by s.id desc";

$count=mysql_num_rows($sq);		
 
					$rs_result = mysql_query($sq1);  
					$row1 = mysql_fetch_row($rs_result);  
					$total_records = $row1[0];  
					$total_pages = ceil($total_records / $webpagelimit);

    }
    
    
    if (($from_date == $to_date)  && $from_date != '') {
        
		//$sql="SELECT sp.id,sp.sp_company,sp.sp_address,sp.sp_email,sp.sp_phone,sp.sp_website,sp.sp_date,sp.amount,sp.sales_person_id,c.category from tbl_sponsorer sp  join categories c on sp.v_category=c.id  where sp.sales_person_id='$person_id'  and sp.sp_date = '$from_date'";
		//echo "SELECT sp.sp_name,sp.sp_img_path,sp.id,sp.source,sp.sp_company,sp.sp_address,sp.sp_email,sp.sp_phone,sp.sp_website,sp.sp_date,sp.amount,sp.sales_person_id,sp.v_category,sp.v_responce_status,sp.comment,sp.calback_date_time,sp.v_status,sp.lat,sp.lon,sp.sales_p_lat,sp.sales_p_lon,sp.entity_id,sp.user_member_id,sp.platform_source,sp.app_version,sp.payment_method,sp.sp_country,sp.calculated_lat,sp.calculated_lon from tbl_sponsorer sp where sp.sales_person_id='$person_id'  and sp.sp_date = '$from_date' and sp.sp_date!=''";
		$sq = mysql_query("select s.sp_date,sp.p_name,s.sp_company,
s.amount,
s.payment_method from tbl_sponsorer s left join tbl_salesperson
sp on sp.person_id=s.sales_person_id
  where s.sp_date = '$from_date' and s.sp_date!='' order by s.id desc
LIMIT $start_from, $webpagelimit");


$sq1 ="select count(s.sp_date),sp.p_name,s.sp_company,
s.amount,
s.payment_method from tbl_sponsorer s left join tbl_salesperson
sp on sp.person_id=s.sales_person_id
  where s.sp_date = '$from_date' and s.sp_date!='' order by s.id desc"; 
 
	$count=mysql_num_rows($sq);	
	                $rs_result = mysql_query($sq1);  
					$row1 = mysql_fetch_row($rs_result);  
					$total_records = $row1[0];  
					$total_pages = ceil($total_records / $webpagelimit);




    }
	
	if($total_pages == $_GET['fpage']){
					$webpagelimit = $total_records;
					}else{
					$webpagelimit = $start_from + $webpagelimit;
					}
					 
	}   





else if (!($_GET['Search'])){

if (isset($_GET["page"])){ $page  = mysql_real_escape_string($_GET["page"]); } else { $page=1; };  
$start_from = ($page-1) * $webpagelimit;



$sql=mysql_query("select s.sp_date,sp.p_name,s.sp_company,
s.amount,
s.payment_method from tbl_sponsorer s left join tbl_salesperson
sp on sp.person_id=s.sales_person_id
 order by s.id desc
LIMIT $start_from, $webpagelimit");	

$sql1 ="select count(s.sp_date),sp.p_name,s.sp_company,
s.amount,
s.payment_method from tbl_sponsorer s left join tbl_salesperson
sp on sp.person_id=s.sales_person_id
 order by s.id desc"; 
 
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

$searchq=trim(mysql_real_escape_string($_GET['Search']));
//$colname=mysql_real_escape_string($_GET['colname']);
	if ($searchq != '')
	{ 
		$query1=mysql_query("select s.sp_date,sp.p_name,s.sp_company,
s.amount,
s.payment_method from tbl_sponsorer s left join tbl_salesperson
sp on sp.person_id=s.sales_person_id where
 
  s.sp_date LIKE '%$searchq%' or sp.p_name LIKE '%$searchq%'
  or s.sp_company LIKE '%$searchq%' or 
  s.amount LIKE '%$searchq%' or s.payment_method LIKE '%$searchq%' 
			order by s.id desc
  LIMIT $start_from, $webpagelimit") or die("could not Search!");
			
			$sql1 ="select count(s.sp_date),sp.p_name,s.sp_company,
s.amount,
s.payment_method from tbl_sponsorer s left join tbl_salesperson
sp on sp.person_id=s.sales_person_id where
 
  s.sp_date LIKE '%$searchq%' or sp.p_name LIKE '%$searchq%'
  or s.sp_company LIKE '%$searchq%' or 
  s.amount LIKE '%$searchq%' or s.payment_method LIKE '%$searchq%' 
			order by s.id desc "; 

			$rs_result = mysql_query($sql1);  
					$row1 = mysql_fetch_row($rs_result);  
					$total_records = $row1[0];  
					$total_pages = ceil($total_records / $webpagelimit);

	}else{
	
	//$q1="SELECT std_name,std_Father_name,std_lastname,std_complete_name,school_id,std_school_name,std_email,std_phone,std_address from tbl_student where group_member_id = '$group_member_id' AND (std_name LIKE '$searchq%' or std_Father_name LIKE '$searchq%' or std_lastname LIKE '$searchq%' or std_complete_name LIKE '%$searchq%' or school_id LIKE '$searchq%' or std_school_name LIKE '%$searchq%' or std_email LIKE '$searchq%' or std_phone LIKE '$searchq%'or std_address LIKE '$searchq%') order by school_id";
$query1=mysql_query("select s.sp_date,sp.p_name,s.sp_company,
s.amount,
s.payment_method from tbl_sponsorer s left join tbl_salesperson
sp on sp.person_id=s.sales_person_id where  $colname LIKE '%$searchq%' order by s.id desc
 
LIMIT $start_from, $webpagelimit")
 
		or die("could not Search!");
					//echo $query1;
		$sql1 ="select count(s.sp_date),sp.p_name,s.sp_company,
s.amount,
s.payment_method from tbl_sponsorer s left join tbl_salesperson
sp on sp.person_id=s.sales_person_id where 
   $colname LIKE '%$searchq%' order by s.id desc"; 
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
<?php if ($_GET['find']){?>
	<script type="text/javascript">
    $(function () {
		var total_pages = <?php echo $total_pages; ?> ;
		var start_page = <?php echo $fpage; ?> ;
        window.pagObj = $('#pagination').twbsPagination({
            totalPages: total_pages,
            visiblePages: 10,
			startPage: start_page,
            onPageClick: function (event, page) {
                console.info(page + ' (from options)'); 
            }
        }).on('page', function (event, page) {
            console.info(page + '(from event listening)');
			window.location.assign('saleperson_summary.php?from_date=<?php echo $from_date; ?>&to_date=<?php echo $to_date; ?>&find=<?php echo Find; ?>&fpage='+page);
        });
    });
</script>
<?php }


 else if (!($_GET['Search'])){?>
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
			window.location.assign('saleperson_summary.php?page='+page);
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
			window.location.assign('saleperson_summary.php?Search=<?php echo $searchq; ?>&spage='+page);
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
	
	<script>
        $(function () {
            $("#from_date").datepicker({
               // changeMonth: true,
                //changeYear: true
				dateFormat: 'yy-mm-dd',
            });
        });
        $(function () {
            $("#to_date").datepicker({
                //changeMonth: true,
                //changeYear: true,
				dateFormat: 'yy-mm-dd',
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            $('#example').dataTable()
            ({});
        });
    </script>
    <script language="javascript" type="text/javascript">
        function printDiv(divID) {
            //Get the HTML of div
            var divElements = document.getElementById(divID).innerHTML;
            //Get the HTML of whole page
            var oldPage = document.body.innerHTML;
            //Reset the page's HTML with div's HTML only
            document.body.innerHTML =
                "<html><head><title></title></head><body><center>" +
                divElements + "</center></body>";
            //Print Page
            window.print();
            //Restore orignal HTML
            document.body.innerHTML = oldPage;
        }
    </script>
</head>

<body bgcolor="#CCCCCC">
<div align="center">
    <div class="container" style="width:100%;">
        <div style="padding-top:30px;">

            <h2 style="padding-left:20px; margin-top:2px;color:#666"> Sales Person Summary</h2>

        </div>
		
		<div class='row'>
		<form style="margin-top:5px;">
		<div class="col-md-1" style="font-weight:bold; margin-right:-36px;"> From</div>
            <div class="col-md-1" style="width:13%;">
                <input type="text" id="from_date" name="from_date" placeholder="YYYY/MM/DD" class="form-control" value="<?php if (isset($_GET['from_date'])) {echo $_GET['from_date'];} ?>"></div>
            <div class="col-md-1" style="font-weight:bold; margin-right:-54px;margin-left:-28px;"> To</div>
            <div class="col-md-1" style="width:13%;">
                <input type="text" id="to_date" name="to_date" placeholder="YYYY/MM/DD" class="form-control" value="<?php if (isset($_GET['to_date'])) {echo $_GET['to_date'];} ?>">
            </div>
            <div class="col-md-1"><input type="submit" name="find" value="Find" class="btn btn-primary"></div>
            <?php if (isset($_GET['find']) && $count != 0) {?>
                <div class="col-md-1"><input type="submit" name="report" value="Report" class="btn btn-primary" onClick="javascript:printDiv('printablediv')"></div>
            <?php } ?>
			</form>
		
		
			<form style="margin-top:5px;">
			 <div class="col-md-80" style="width:55%;">
			 </div>
          
			<div class="col-md-2" style="width:17%;">
				<input type="text" class="form-control" name="Search" value="<?php echo $searchq; ?>" placeholder="Search.." required> 
			</div>
			<div class="col-md-1" >
			<button type="submit" value="Search" class="btn btn-primary">Search</button>
			</div>
			<div class="col-md-1" >
			<input type="button" class="btn btn-info" value="Reset" onclick="window.open('saleperson_summary.php','_self')" />
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
		 				echo "<div style='margin-top:5px;'><font color='blue'><b style='margin-left:600px;'>Now showing ".($start_from +1)." to ".($webpagelimit)." records out of ".$total_records. " records.</b></font></div>";
		    }else
		 			{
		 				if ($webpagelimit >$total_records){ $webpagelimit=$total_records;}
		 				echo "<div style='margin-top:5px;'><font color='blue'><b style='margin-left:600px;'>Now showing ".($start_from +1)." to ".($webpagelimit)." records out of ".($total_records). " records.</b></font></div>";
		 			}
		 			?>
		 </div> -->
		<?php
		 if ($_GET['find'])
		{
			
			//$count=mysql_num_rows($sq);
			if($count == 0){
				
				echo "<script>$('#show').css('display','none');</script><div style='margin-top:20px;'><font color='Red'><b>There Was No Search Result</b></font></div>";	
			}
			else
			{
			?>
			<div id="no-more-tables" style="padding-top:20px;">

            <table id="example" class="col-md-12 table-bordered " align="center">
                <thead>
				<!-- <tr><?php echo $sq1; ?></tr> -->
                <tr style="background-color:#0073BD; color:#FFFFFF; height:30px;">
                    
				  <th>Sr.No.</th>
					<th>Reg.Date</th>
                    <th>  Sales Person Name </th>
					 <th> Sponsor Name</th>
                   <th>Amount</th>
                    <th> Cash Payment</th> 
					<th>Cheque Payment</th>
                    <th>Free Register</th>
                </tr>
                </thead>

               <?php 
				
				$i = 1;
				$cash = 0;
						$cheque = 0;
						$free = 0;
                        $chequeamount1 = 0;
                        $cashamount1 = 0;
				
					$i = ($start_from +1);
                while($result = mysql_fetch_array($sq)) {
					
                    ?>
                    <tr>
                        <td data-title="Sr.No."><?php echo $i; ?></td>
                        
                       
                       
                        <td data-title="Reg.Date"><?php echo $result['sp_date']; ?></td>
						<td data-title="Sales Person Name"><?php echo $result['p_name']; ?></td>
                        <td data-title="Sponsor Name"><?php echo $result['sp_company']; ?></td>
                        <td data-title="amount"><?php if ($result['amount'] == "" or $result['amount'] == 0) {
                            $amount = "0";
                        } else {
                            $amount = $result['amount'];
							
							$total = $total + $result['amount'];
							 if($result['payment_method'] == "Cash"){
                                            $cashamount1 = $cashamount1 + $result['amount'];
                                        }elseif ($result['payment_method'] == "Cheque"){
                                            $chequeamount1 = $chequeamount1 + $result['amount'];
                                        }
										
                        }
                        echo $amount; ?></td>
<td data-title="Cash Payment"><?php if($result['payment_method'] == "Cash") { echo "Cash";$cash++;}else{ echo"";} ?></td>
<td data-title="Cheque Payment"><?php if($result['payment_method'] == "Cheque") { echo "Cheque";$cheque++;}else{ echo"";}  ?></td>
<td data-title="Free Register"><?php if($result['payment_method'] == "Free Register") { echo "Free Register";$free++;}else{ echo"";} ?></td>

					</tr>	
                    <?php $i++;
                } ?>
            </table>
        </div>
		<div align=left>
		 		<?php
				
		 				
		 				echo "<div style='margin-top:5px;'><font color='#0073BD'><style='margin-left:600px;'>Now showing ".($start_from +1)." to ".($webpagelimit)." records out of ".$total_records. " records.</font></style></div>";
		    
		 			?>
		 </div>
			<div class="container">
			<nav aria-label="Page navigation">
			  <ul class="pagination" id="pagination"></ul>
		    </nav>
		</div>
		
		<div class="row">
                     <br><br>
                    <TABLE BORDER="1"    WIDTH="10%"  >
                        <caption style="background-color:lightgray"><b>SUMMARY REPORT SALESPERSON<b></caption>
                        <TR>
                            <TH>TOTAL SPONSOR</TH>
                            <TH>BY CASH</TH>
                            <TH>CASH AMOUNT</TH>
                            <TH>BY CHEQUE</TH>
                            <TH>CHEQUE AMOUNT</TH>
                            <TH>FREE REGISTER</TH>
                            <TH>TOTAL AMOUNT</TH>
                        </TR>
						
						<?php
						
						$c0=mysql_query("select s.payment_method

 from tbl_sponsorer s left join tbl_salesperson
sp on sp.person_id=s.sales_person_id
  where s.sp_date between '$from_date' and '$to_date' 
  and s.sp_date!='' and s.payment_method='cash'
		order by s.id desc");
		$c1=mysql_num_rows($c0);
		
		
		$c2=mysql_query("select s.payment_method

 from tbl_sponsorer s left join tbl_salesperson
sp on sp.person_id=s.sales_person_id
  where s.sp_date between '$from_date' and '$to_date'
  and s.sp_date!='' and s.payment_method='cheque'
		order by s.id desc");
						
    $c3=mysql_num_rows($c2);
    
	
	
	$c4=mysql_query("select s.payment_method

 from tbl_sponsorer s left join tbl_salesperson
sp on sp.person_id=s.sales_person_id
  where s.sp_date between '$from_date' and '$to_date'
  and s.sp_date!='' and s.payment_method='free register'
		order by s.id desc");
						
    $c5=mysql_num_rows($c4);
	
$c6=mysql_query("select sum(s.amount) as cashamount from tbl_sponsorer s left join tbl_salesperson
sp on sp.person_id=s.sales_person_id  where s.sp_date between '$from_date' and '$to_date' 
and  s.payment_method='cash'
 order by s.id desc");
  $c7 = mysql_fetch_assoc($c6); 
$sum1 = $c7['cashamount'];					
							
	$c8=mysql_query("select sum(s.amount) as cheque from tbl_sponsorer s left join tbl_salesperson
sp on sp.person_id=s.sales_person_id  where s.sp_date between '$from_date' and '$to_date' 
and  s.payment_method='cheque'
 order by s.id desc");
  $c9 = mysql_fetch_assoc($c8); 
$sum2 = $c9['cheque'];		


$c10=mysql_query("select sum(s.amount) as amount from tbl_sponsorer s left join tbl_salesperson
sp on sp.person_id=s.sales_person_id  where s.sp_date between '$from_date' and '$to_date' 

 order by s.id desc");
  $c11 = mysql_fetch_assoc($c10); 
$sum3 = $c11['amount'];		
    
 
		?>

                        <TR ALIGN="CENTER">
                            <TD><?php echo $total_records; ?></TD>
                            <TD><?php echo $c1; ?></TD>
                            <TD><?php echo $sum1; ?></TD>
                            <TD><?php echo $c3; ?></TD>
                            <TD><?php echo $sum2; ?></TD>
                            <TD><?php echo $c5; ?></TD>
                            <TD><?php echo $sum3; ?></TD>
                        </TR>
                    </TABLE>
					<br>
				</div>
			<?php
			}

		}
		//end
		
	else if (isset($_GET['Search']))
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
					<th>Reg.Date</th>
                    <th>  Sales Person Name </th>
					 <th> Sponsor Name</th>
                   <th>Amount</th>
                    <th> Cash Payment</th> 
					<th>Cheque Payment</th>
                    <th>Free Register</th>
                </tr>
                </thead>

                <?php $i = 1;
				
					$i = ($start_from +1);
                while($result = mysql_fetch_array($query1)) {
					
                    ?>
                    <tr>
                        <td data-title="Sr.No."><?php echo $i; ?></td>
                        
                       
                       
                        <td data-title="Reg.Date"><?php echo $result['sp_date']; ?></td>
						<td data-title="Sales Person Name"><?php echo $result['p_name']; ?></td>
                        <td data-title="Sponsor Name"><?php echo $result['sp_company']; ?></td>
                        <td data-title="Amount"><?php if ($result['amount'] == "" or $result['amount'] == 0) {
                                      //  $amount = "Free Registered";
                                        $amount = "0";
                        } else {
                            $amount = $result['amount'];
							
							
										
                        }		
                        
			
                        echo $amount; ?></td>
						<td data-title="Cash Payment"><?php if($result['payment_method'] == "Cash") { echo "Cash";}else{ echo"";} ?></td>
                    <td data-title="Cheque Payment"><?php if($result['payment_method'] == "Cheque") { echo "Cheque";}else{ echo"";}  ?></td>
                    <td data-title="Free Register"><?php if($result['payment_method'] == "Free Register" || $result['amount'] == 0) { echo "Free Register";}else{ echo"";} ?></td>
						

					</tr>	
                    <?php $i++;
                } ?>
            </table>
        </div>
		<div align=left>
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
		
		<div class="row">
                     <br><br>
                    <TABLE BORDER="1"    WIDTH="10%"  >
                        <caption style="background-color:lightgray"><b>SUMMARY REPORT SALESPERSON<b></caption>
                        <TR>
                            <TH>TOTAL SPONSOR</TH>
                            <TH>BY CASH</TH>
                            <TH>CASH AMOUNT</TH>
                            <TH>BY CHEQUE</TH>
                            <TH>CHEQUE AMOUNT</TH>
                            <TH>FREE REGISTOR</TH>
                            <TH>TOTAL AMOUNT</TH>
                        </TR>
                        <TR ALIGN="CENTER">
                            <TD><?php echo $to; ?></TD>
                            <TD><?php echo $c; ?></TD>
                            <TD><?php echo $sum; ?></TD>
                            <TD><?php echo $ce; ?></TD>
                            <TD><?php echo $sum1; ?></TD>
                            <TD><?php echo $f; ?></TD>
                            <TD><?php echo $sum2; ?></TD>
                        </TR>
                    </TABLE>
					<br>
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
                    <th>Sr.No.</th>
					<th>Reg.Date</th>
                    <th>  Sales Person Name </th>
					 <th> Sponsor Name</th>
                   <th>Amount</th>
                    <th> Cash Payment</th>
					<th>Cheque Payment</th>
                    <th>Free Register</th>
					
				   
                </tr>
                </thead>

                <?php $i = 1;
				
					$i = ($start_from +1);
                while($result = mysql_fetch_array($sql)) {
					
                    ?>
                    <tr>
                        <td data-title="Sr.No."><?php echo $i; ?></td>
                        
                       
                       
                        <td data-title="Reg.Date"><?php echo $result['sp_date']; ?></td>
						<td data-title="Sales Person Name"><?php echo $result['p_name']; ?></td>
                        <td data-title="Sponsor Name"><?php echo $result['sp_company']; ?></td>
                        <td data-title="Amount"><?php if ($result['amount'] == "" or $result['amount'] == 0) {
                                      //  $amount = "Free Registered";
                                        $amount = "0";
                        } else {
                            $amount = $result['amount'];
							
							
										
                        }
										
                        
			
                        echo $amount; ?></td>
						<td data-title="Cash Payment"><?php if($result['payment_method'] == "Cash") { echo "Cash";}else{ echo"";} ?></td>
                    <td data-title="Cheque Payment"><?php if($result['payment_method'] == "Cheque") { echo "Cheque";}else{ echo"";}  ?></td>
                    <td data-title="Free Register"><?php if($result['payment_method'] == "Free Register" || $result['amount'] == 0) { echo "Free Register";}else{ echo"";} ?></td>
						

					</tr>	
                    <?php $i++;
                } ?>
            </table>
        </div>
<div align=left>
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
		<div class="row">
                     <br><br>
                    <TABLE BORDER="1"    WIDTH="10%"  >
                        <caption style="background-color:lightgray"><b>SUMMARY REPORT SALESPERSON<b></caption>
                        <TR>
                            <TH>TOTAL SPONSOR</TH>
                            <TH>BY CASH</TH>
                            <TH>CASH AMOUNT</TH>
                            <TH>BY CHEQUE</TH>
                            <TH>CHEQUE AMOUNT</TH>
                            <TH>FREE REGISTOR</TH>
                            <TH>TOTAL AMOUNT</TH>
                        </TR>
                        <TR ALIGN="CENTER">
                            <TD><?php echo $total_records; ?></TD>
                            <TD><?php echo $c; ?></TD>
                            <TD><?php echo $sum; ?></TD>
                            <TD><?php echo $ce; ?></TD>
                            <TD><?php echo $sum1; ?></TD>
                            <TD><?php echo $f; ?></TD>
                            <TD><?php echo $sum2; ?></TD>
                        </TR>
                    </TABLE>
					<br>
				</div>

<?php } ?>




	<div style="padding-top:50px;">

            
        </div>
		
		<div class="printablediv" id="printablediv" style="display:none;">
            <div class="container" style="border-width:2px;border-style: solid;">
                <div class="row" style="padding-top:20px;" align="center">
                    <h2> Sponsor Registered List </h2>
                </div>
				
				<div class="row" style="padding-top:10px;padding-left:20px;" align="center">
                    <h4><?php
                        
                        echo $_GET['from_date']; ?> &nbsp;&nbsp; To &nbsp;&nbsp;<?php 
                        echo $_GET['to_date']; ?></h4>
                </div>

		
			<div id="no-more-tables" style="padding-top:20px;">

            <table id="example" class="col-md-12 table-bordered " align="center">
                <thead>
				<!-- <tr><?php echo $sq1; ?></tr> -->
                <tr style="background-color:#0073BD; color:#FFFFFF; height:30px;">
                    
				  <th>Sr.No.</th>
					<th>Reg.Date</th>
                    <th>  Sales Person Name </th>
					 <th> Sponsor Name</th>
                   <th>Amount</th>
                    <th> Cash Payment</th> 
					<th>Cheque Payment</th>
                    <th>Free Register</th>
                </tr>
                </thead>

               <?php 
			   
			   
			   if ($from_date != '' && $to_date != '') {
		
   // $sql="SELECT sp.id,sp.sp_company,sp.sp_address,sp.sp_email,sp.sp_phone,sp.sp_website,sp.sp_date,sp.amount,sp.sales_person_id,c.category from tbl_sponsorer sp  join categories c on sp.v_category=c.id  where sp.sales_person_id='$person_id'  and sp.sp_date between '$from_date' and '$to_date' ";
		//echo "SELECT sp.sp_name,sp.sp_img_path,sp.id,sp.source,sp.sp_company,sp.sp_address,sp.sp_email,sp.sp_phone,sp.sp_website,sp.sp_date,sp.amount,sp.sales_person_id,sp.v_category,sp.v_responce_status,sp.comment,sp.calback_date_time,sp.v_status,sp.lat,sp.lon,sp.sales_p_lat,sp.sales_p_lon,sp.entity_id,sp.user_member_id,sp.platform_source,sp.app_version,sp.payment_method,sp.sp_country,sp.calculated_lat,sp.calculated_lon from tbl_sponsorer sp where sp.sales_person_id='$person_id'  and sp.sp_date between '$from_date' and '$to_date' and sp.sp_date!=''";
		
		
		$sq = mysql_query("select s.sp_date,sp.p_name,s.sp_company,
s.amount,
s.payment_method from tbl_sponsorer s left join tbl_salesperson
sp on sp.person_id=s.sales_person_id
  where s.sp_date between '$from_date' and '$to_date' and s.sp_date!='' 
		order by s.id desc");


$sq1 ="select count(s.sp_date),sp.p_name,s.sp_company,
s.amount,
s.payment_method from tbl_sponsorer s left join tbl_salesperson
sp on sp.person_id=s.sales_person_id
  where s.sp_date between '$from_date' and '$to_date' and s.sp_date!='' 
		order by s.id desc";

$count=mysql_num_rows($sq);		
 
					

    }
    
    
    if (($from_date == $to_date)  && $from_date != '') {
        
		//$sql="SELECT sp.id,sp.sp_company,sp.sp_address,sp.sp_email,sp.sp_phone,sp.sp_website,sp.sp_date,sp.amount,sp.sales_person_id,c.category from tbl_sponsorer sp  join categories c on sp.v_category=c.id  where sp.sales_person_id='$person_id'  and sp.sp_date = '$from_date'";
		//echo "SELECT sp.sp_name,sp.sp_img_path,sp.id,sp.source,sp.sp_company,sp.sp_address,sp.sp_email,sp.sp_phone,sp.sp_website,sp.sp_date,sp.amount,sp.sales_person_id,sp.v_category,sp.v_responce_status,sp.comment,sp.calback_date_time,sp.v_status,sp.lat,sp.lon,sp.sales_p_lat,sp.sales_p_lon,sp.entity_id,sp.user_member_id,sp.platform_source,sp.app_version,sp.payment_method,sp.sp_country,sp.calculated_lat,sp.calculated_lon from tbl_sponsorer sp where sp.sales_person_id='$person_id'  and sp.sp_date = '$from_date' and sp.sp_date!=''";
		$sq = mysql_query("select s.sp_date,sp.p_name,s.sp_company,
s.amount,
s.payment_method from tbl_sponsorer s left join tbl_salesperson
sp on sp.person_id=s.sales_person_id
  where s.sp_date = '$from_date' and s.sp_date!='' order by s.id desc");


$sq1 ="select count(s.sp_date),sp.p_name,s.sp_company,
s.amount,
s.payment_method from tbl_sponsorer s left join tbl_salesperson
sp on sp.person_id=s.sales_person_id
  where s.sp_date = '$from_date' and s.sp_date!='' order by s.id desc"; 
 
	$count=mysql_num_rows($sq);	
	                



    }
	

				
				$i = 1;
				$cash = 0;
						$cheque = 0;
						$free = 0;
                        $chequeamount1 = 0;
                        $cashamount1 = 0;
				
					$i = ($start_from +1);
                while($result = mysql_fetch_array($sq)) {
					
                    ?>
                    <tr>
                        <td data-title="Sr.No."><?php echo $i; ?></td>
                        
                       
                       
                        <td data-title="Reg.Date"><?php echo $result['sp_date']; ?></td>
						<td data-title="Sales Person Name"><?php echo $result['p_name']; ?></td>
                        <td data-title="Sponsor Name"><?php echo $result['sp_company']; ?></td>
                        <td data-title="amount"><?php if ($result['amount'] == "" or $result['amount'] == 0) {
                            $amount = "0";
                        } else {
                            $amount = $result['amount'];
							
							$total = $total + $result['amount'];
							 if($result['payment_method'] == "Cash"){
                                            $cashamount1 = $cashamount1 + $result['amount'];
                                        }elseif ($result['payment_method'] == "Cheque"){
                                            $chequeamount1 = $chequeamount1 + $result['amount'];
                                        }
										
                        }
                        echo $amount; ?></td>
<td data-title="Cash Payment"><?php if($result['payment_method'] == "Cash") { echo "Cash";$cash++;}else{ echo"";} ?></td>
<td data-title="Cheque Payment"><?php if($result['payment_method'] == "Cheque") { echo "Cheque";$cheque++;}else{ echo"";}  ?></td>
<td data-title="Free Register"><?php if($result['payment_method'] == "Free Register") { echo "Free Register";$free++;}else{ echo"";} ?></td>

					</tr>	
                    <?php $i++;
                } ?>
            </table>
        </div>
		<div align=left>
		 		<?php
				
		 				
		 				echo "<div style='margin-top:5px;'><font color='#0073BD'><style='margin-left:600px;'>Now showing ".($start_from +1)." to ".($webpagelimit)." records out of ".$total_records. " records.</font></style></div>";
		    
		 			?>
		 </div>
			<div class="container">
			<nav aria-label="Page navigation">
			  <ul class="pagination" id="pagination"></ul>
		    </nav>
		</div>
		
		<div class="row">
                     <br><br>
                    <TABLE BORDER="1"    WIDTH="10%"  >
                        <caption style="background-color:lightgray"><b>SUMMARY REPORT SALESPERSON<b></caption>
                        <TR>
                            <TH>TOTAL SPONSOR</TH>
                            <TH>BY CASH</TH>
                            <TH>CASH AMOUNT</TH>
                            <TH>BY CHEQUE</TH>
                            <TH>CHEQUE AMOUNT</TH>
                            <TH>FREE REGISTER</TH>
                            <TH>TOTAL AMOUNT</TH>
                        </TR>
						
						
						
                        <TR ALIGN="CENTER">
                            <TD><?php echo $total_records; ?></TD>
                            <TD><?php echo $c1; ?></TD>
                            <TD><?php echo $sum1; ?></TD>
                            <TD><?php echo $c3; ?></TD>
                            <TD><?php echo $sum2; ?></TD>
                            <TD><?php echo $c5; ?></TD>
                            <TD><?php echo $sum3; ?></TD>
                        </TR>
                    </TABLE>
					<br>
				</div>
			
		
		
    </div>
	

</div>

</div>
</div>
</body>
</html>