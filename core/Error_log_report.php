<?php
include('cookieadminheader.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title> Error Log Report</title>
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
 if (!($_GET['Search']) &&  !($_GET['Search_schoolid'])  &&  !($_GET['Search_app'])  &&  !($_GET['Search_user']) && !($_GET['from_date']) && !($_GET['to_date'])) {

if (isset($_GET["page"])){ $page  = mysql_real_escape_string($_GET["page"]); } else { $page=1; };  
$start_from = ($page-1) * $webpagelimit;
	
	$findq1="select * from tbl_error_log ORDER BY id DESC";
$sql=mysql_query("select * from tbl_error_log ORDER BY id DESC
LIMIT $start_from, $webpagelimit");	

$sql1 ="select count(*) from tbl_error_log ORDER BY id DESC"; 
 
					$rs_result = mysql_query($sql1);  
					$row1 = mysql_fetch_row($rs_result);  
					$total_records = $row1[0];  
					$total_pages = ceil($total_records / $webpagelimit);
					if($total_pages == $_GET['page']){
					$webpagelimit = $total_records;
					}else{
					$webpagelimit = $start_from + $webpagelimit;
					}
}else if (($_GET['Search']))
{
	if (isset($_GET["spage"])){ $spage  = mysql_real_escape_string($_GET["spage"]); } else { $spage=1; };  
$start_from = ($spage-1) * $webpagelimit;

$searchq=mysql_real_escape_string($_GET['Search']);
//$colname=mysql_real_escape_string($_GET['colname']);
	if ($searchq != '')
	{
		$findq2="Select * from tbl_error_log 
		where id LIKE '%$searchq%' or error_type LIKE '%$searchq%' or error_description LIKE '%$searchq%' or datetime LIKE '%$searchq%' or user_type LIKE 
		'%$searchq%' or name LIKE '%$searchq%' or email LIKE '%$searchq%' or subroutine_name LIKE '%$searchq%' or assignment_date LIKE '%$searchq%' or resolution_date LIKE '%$searchq%' or assigned_to LIKE '%$searchq%' or resolved_by LIKE '%$searchq%' or line LIKE '%$searchq%' or member_id LIKE '%$searchq%' or school_id LIKE '%$searchq%' or app_name LIKE '%$searchq%' or status LIKE '%$searchq%' or last_programmer_name LIKE '%$searchq%' or webservice_name LIKE '%$searchq%' or webmethod_name LIKE '%$searchq%' or programmer_error_message LIKE '%$searchq%' ORDER BY id DESC ";
		$query1=mysql_query("Select * from tbl_error_log 
		
		where
		id LIKE '%$searchq%' or error_type LIKE '%$searchq%' or error_description LIKE '%$searchq%' or datetime LIKE '%$searchq%' or user_type LIKE 
		'%$searchq%' or name LIKE '%$searchq%' or email LIKE '%$searchq%' or subroutine_name LIKE '%$searchq%' or assignment_date LIKE '%$searchq%' or resolution_date LIKE '%$searchq%' or assigned_to LIKE '%$searchq%' or resolved_by LIKE '%$searchq%' or line LIKE '%$searchq%' or member_id LIKE '%$searchq%' or school_id LIKE '%$searchq%' or app_name LIKE '%$searchq%' or status LIKE '%$searchq%' or last_programmer_name LIKE '%$searchq%' or webservice_name LIKE '%$searchq%' or webmethod_name LIKE '%$searchq%' or programmer_error_message LIKE '%$searchq%' ORDER BY id DESC LIMIT $start_from, $webpagelimit") or die("could not Search!");
			
			$sql1 ="Select count(*) from tbl_error_log 
		
		where
		id LIKE '%$searchq%' or error_type LIKE '%$searchq%' or error_description LIKE '%$searchq%' or datetime LIKE '%$searchq%' or user_type LIKE 
		'%$searchq%' or name LIKE '%$searchq%' or email LIKE '%$searchq%' or subroutine_name LIKE '%$searchq%' or assignment_date LIKE '%$searchq%' or resolution_date LIKE '%$searchq%' or assigned_to LIKE '%$searchq%' or resolved_by LIKE '%$searchq%' or line LIKE '%$searchq%' or member_id LIKE '%$searchq%' or school_id LIKE '%$searchq%' or app_name LIKE '%$searchq%' or status LIKE '%$searchq%' or last_programmer_name LIKE '%$searchq%' or webservice_name LIKE '%$searchq%' or webmethod_name LIKE '%$searchq%' or programmer_error_message LIKE '%$searchq%' ORDER BY id DESC "; 

			$rs_result = mysql_query($sql1);  
					$row1 = mysql_fetch_row($rs_result);  
					$total_records = $row1[0];  
					$total_pages = ceil($total_records / $webpagelimit);

	}else{
	
	//$q1="SELECT std_name,std_Father_name,std_lastname,std_complete_name,school_id,std_school_name,std_email,std_phone,std_address from tbl_student where group_member_id = '$group_member_id' AND (std_name LIKE '$searchq%' or std_Father_name LIKE '$searchq%' or std_lastname LIKE '$searchq%' or std_complete_name LIKE '%$searchq%' or school_id LIKE '$searchq%' or std_school_name LIKE '%$searchq%' or std_email LIKE '$searchq%' or std_phone LIKE '$searchq%'or std_address LIKE '$searchq%') order by school_id";
	$findq2="Select * from tbl_error_log 
		where $colname LIKE '%$searchq%' ORDER BY id DESC";
$query1=mysql_query("Select * from tbl_error_log 
		where $colname LIKE '%$searchq%' ORDER BY id DESC LIMIT $start_from, $webpagelimit")
 
		or die("could not Search!");
					//echo $query1;
		$sql1 ="Select count(*) from tbl_error_log 
		where $colname LIKE '%$searchq%' ORDER BY id DESC"; 
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

/*Below code and filters for School ID, Application & User Type added by Rutuja Jori for SMC-4912 on 20-10-2020*/
/*Updated code for merging the From date, To date search with School ID, Application & User type filters for SMC-4928 on 29-10-2020 by Rutuja*/

else
{
	if (isset($_GET["spage"])){ $spage  = mysql_real_escape_string($_GET["spage"]); } else { $spage=1; };  
$start_from = ($spage-1) * $webpagelimit;
$where_search = "";
/*Updated by Rutuja for adding LIKE conditions on Usertype and also added conditions for today's date for SMC-4946 on 11-11-2020*/
if(($_GET['Search_schoolid']) && ($_GET['Search_app']) &&  ($_GET['Search_user']) &&  ($_GET['from_date']) &&  ($_GET['to_date']) ){
$searchschool=mysql_real_escape_string($_GET['Search_schoolid']);
$searchapp=mysql_real_escape_string($_GET['Search_app']);
$searchuser=mysql_real_escape_string($_GET['Search_user']);	
$from_date=mysql_real_escape_string($_GET['from_date']);	
$to_date=mysql_real_escape_string($_GET['to_date']);	
$where_search.= " school_id = '$searchschool' and  app_name = '$searchapp' and user_type LIKE '%$searchuser%'";
if (($from_date == $to_date)  && $from_date != '') {
$where_search.= " and DATE(datetime) = '$from_date' and datetime!='' ";	
}	
else{	
$where_search.= " and datetime between '$from_date' and '$to_date' and datetime!='' ";
}

}
else if(($_GET['Search_schoolid']) && ($_GET['Search_app']) && ($_GET['from_date']) &&  ($_GET['to_date'])){
$searchschool=mysql_real_escape_string($_GET['Search_schoolid']);	
$searchapp=mysql_real_escape_string($_GET['Search_app']);	
$from_date=mysql_real_escape_string($_GET['from_date']);	
$to_date=mysql_real_escape_string($_GET['to_date']);
$where_search.= " school_id = '$searchschool' and app_name = '$searchapp'";
if (($from_date == $to_date)  && $from_date != '') {
$where_search.= " and DATE(datetime) = '$from_date' and datetime!='' ";	
}	
else{	
$where_search.= " and datetime between '$from_date' and '$to_date' and datetime!='' ";
}

}
else if(($_GET['Search_schoolid']) && ($_GET['Search_user']) && ($_GET['from_date']) &&  ($_GET['to_date'])){
$searchschool=mysql_real_escape_string($_GET['Search_schoolid']);	
$searchuser=mysql_real_escape_string($_GET['Search_user']);	
$from_date=mysql_real_escape_string($_GET['from_date']);	
$to_date=mysql_real_escape_string($_GET['to_date']);
$where_search.= " school_id = '$searchschool' and user_type LIKE '%$searchuser%'";

if (($from_date == $to_date)  && $from_date != '') {
$where_search.= " and DATE(datetime) = '$from_date' and datetime!='' ";	
}	
else{	
$where_search.= " and datetime between '$from_date' and '$to_date' and datetime!='' ";
}

}
else if(($_GET['Search_app']) && ($_GET['Search_user']) && ($_GET['from_date']) &&  ($_GET['to_date'])){
$searchapp=mysql_real_escape_string($_GET['Search_app']);	
$searchuser=mysql_real_escape_string($_GET['Search_user']);	
$from_date=mysql_real_escape_string($_GET['from_date']);	
$to_date=mysql_real_escape_string($_GET['to_date']);
$where_search.= " app_name = '$searchapp' and user_type LIKE '%$searchuser%'";
if (($from_date == $to_date)  && $from_date != '') {
$where_search.= " and DATE(datetime) = '$from_date' and datetime!='' ";	
}	
else{	
$where_search.= " and datetime between '$from_date' and '$to_date' and datetime!='' ";
}

}
else if(($_GET['Search_schoolid']) && ($_GET['from_date']) &&  ($_GET['to_date'])){
$searchschool=mysql_real_escape_string($_GET['Search_schoolid']);	
$from_date=mysql_real_escape_string($_GET['from_date']);	
$to_date=mysql_real_escape_string($_GET['to_date']);	
$where_search.= " school_id = '$searchschool' ";
if (($from_date == $to_date)  && $from_date != '') {
$where_search.= " and DATE(datetime) = '$from_date' and datetime!='' ";	
}	
else{	
$where_search.= " and datetime between '$from_date' and '$to_date' and datetime!='' ";
}

}
else if(($_GET['Search_app']) && ($_GET['from_date']) &&  ($_GET['to_date'])){
$searchapp=mysql_real_escape_string($_GET['Search_app']);	
$from_date=mysql_real_escape_string($_GET['from_date']);	
$to_date=mysql_real_escape_string($_GET['to_date']);	
$where_search.= " app_name = '$searchapp' ";
if (($from_date == $to_date)  && $from_date != '') {
$where_search.= " and DATE(datetime) = '$from_date' and datetime!='' ";	
}	
else{	
$where_search.= " and datetime between '$from_date' and '$to_date' and datetime!='' ";
}

}
else if(($_GET['Search_user']) && ($_GET['from_date']) &&  ($_GET['to_date'])){
$searchuser=mysql_real_escape_string($_GET['Search_user']);	
$from_date=mysql_real_escape_string($_GET['from_date']);	
$to_date=mysql_real_escape_string($_GET['to_date']);	
$where_search.= " user_type LIKE '%$searchuser%'";
if (($from_date == $to_date)  && $from_date != '') {
$where_search.= " and DATE(datetime) = '$from_date' and datetime!='' ";	
}	
else{	
$where_search.= " and datetime between '$from_date' and '$to_date' and datetime!='' ";
}

}
else if(($_GET['Search_schoolid']) && ($_GET['Search_app']) && ($_GET['Search_user'])){
$searchschool=mysql_real_escape_string($_GET['Search_schoolid']);	
$searchapp=mysql_real_escape_string($_GET['Search_app']);	
$searchuser=mysql_real_escape_string($_GET['Search_user']);
$where_search.= " school_id = '$searchschool' and app_name = '$searchapp' and user_type LIKE '%$searchuser%' ";
}
else if(($_GET['Search_schoolid']) && ($_GET['Search_app'])){
$searchschool=mysql_real_escape_string($_GET['Search_schoolid']);	
$searchapp=mysql_real_escape_string($_GET['Search_app']);	
$where_search.= " school_id = '$searchschool' and app_name = '$searchapp' ";
}
else if(($_GET['Search_schoolid']) && ($_GET['Search_user'])){
$searchschool=mysql_real_escape_string($_GET['Search_schoolid']);	
$searchuser=mysql_real_escape_string($_GET['Search_user']);	
$where_search.= " school_id = '$searchschool' and user_type LIKE '%$searchuser%' ";
}
else if(($_GET['Search_app']) && ($_GET['Search_user'])){
$searchuser=mysql_real_escape_string($_GET['Search_user']);	
$searchapp=mysql_real_escape_string($_GET['Search_app']);	
$where_search.= " user_type LIKE '%$searchuser%' and app_name = '$searchapp' ";
}
else if($_GET['Search_schoolid']){
$searchschool=mysql_real_escape_string($_GET['Search_schoolid']);	
$where_search.= " school_id = '$searchschool' ";
}
else if($_GET['Search_app']){
$searchapp=mysql_real_escape_string($_GET['Search_app']);	
$where_search.= " app_name = '$searchapp' ";
}
else if($_GET['Search_user']){
$searchuser=mysql_real_escape_string($_GET['Search_user']);	
$where_search.= " user_type LIKE '%$searchuser%' ";
}
else if(($_GET['from_date']) &&  ($_GET['to_date'])) {
 $from_date=mysql_real_escape_string($_GET['from_date']);	
 $to_date=mysql_real_escape_string($_GET['to_date']);	
if (($from_date == $to_date)  && $from_date != '') {
$where_search.= " DATE(datetime) = '$from_date' and datetime!='' ";	
}	
else{	
$where_search.= " datetime between '$from_date' and '$to_date' and datetime!='' ";
}
}

	if ($searchschool != '' || $searchapp != '' || $searchuser != '' || ($from_date!='' && $to_date!='') )
	{
		$findq2="Select * from tbl_error_log where $where_search ORDER BY id DESC "; //echo $findq2;

		$query1=mysql_query("Select * from tbl_error_log 
		where $where_search	ORDER BY id DESC LIMIT $start_from, $webpagelimit") or die("could not Search!");
			
			$sql1 ="Select count(*) from tbl_error_log 
					where $where_search ORDER BY id DESC "; 

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

<?php 

 if (!($_GET['Search']) &&  !($_GET['Search_schoolid'])  &&  !($_GET['Search_app'])  &&  !($_GET['Search_user']) &&  !($_GET['from_date']) &&  !($_GET['to_date']) )
{?>
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
			window.location.assign('Error_log_report.php?page='+page);
        });
    });
</script>
<?php }else{
	if(($_GET['Search'])){
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
			window.location.assign('Error_log_report.php?Search=<?php echo $searchq; ?>&spage='+page);
        });
    });
</script>
<?php } else if(($_GET['Search_schoolid']) && ($_GET['Search_app']) &&  ($_GET['Search_user']) &&  ($_GET['from_date']) &&  ($_GET['to_date'])) { ?>

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
			window.location.assign('Error_log_report.php?Search_schoolid=<?php echo $searchschool; ?>&Search_app=<?php echo $searchapp; ?>&Search_user=<?php echo $searchuser; ?>&from_date=<?php echo $from_date; ?>&to_date=<?php echo $to_date; ?>&spage='+page);
        });
    });
</script>

<?php } else if(($_GET['Search_schoolid']) && ($_GET['Search_app']) && ($_GET['from_date']) &&  ($_GET['to_date'])){ ?>

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
			window.location.assign('Error_log_report.php?Search_schoolid=<?php echo $searchschool; ?>&Search_app=<?php echo $searchapp; ?>&from_date=<?php echo $from_date; ?>&to_date=<?php echo $to_date; ?>&spage='+page);
        });
    });
</script>

<?php } else if(($_GET['Search_schoolid']) && ($_GET['Search_user']) && ($_GET['from_date']) &&  ($_GET['to_date'])){ ?>

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
			window.location.assign('Error_log_report.php?Search_schoolid=<?php echo $searchschool; ?>&Search_user=<?php echo $searchuser; ?>&from_date=<?php echo $from_date; ?>&to_date=<?php echo $to_date; ?>&spage='+page);
        });
    });
</script>

<?php } else if(($_GET['Search_app']) && ($_GET['Search_user']) && ($_GET['from_date']) &&  ($_GET['to_date'])){ ?>

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
			window.location.assign('Error_log_report.php?Search_app=<?php echo $searchapp; ?>&Search_user=<?php echo $searchuser; ?>&from_date=<?php echo $from_date; ?>&to_date=<?php echo $to_date; ?>&spage='+page);
        });
    });
</script>

<?php } else if(($_GET['Search_schoolid']) && ($_GET['from_date']) &&  ($_GET['to_date'])){ ?>

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
			window.location.assign('Error_log_report.php?Search_schoolid=<?php echo $searchschool; ?>&from_date=<?php echo $from_date; ?>&to_date=<?php echo $to_date; ?>&spage='+page);
        });
    });
</script>

<?php } else if(($_GET['Search_app']) && ($_GET['from_date']) &&  ($_GET['to_date'])){ ?>

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
			window.location.assign('Error_log_report.php?Search_app=<?php echo $searchapp; ?>&from_date=<?php echo $from_date; ?>&to_date=<?php echo $to_date; ?>&spage='+page);
        });
    });
</script>

<?php } else if(($_GET['Search_user']) && ($_GET['from_date']) &&  ($_GET['to_date'])){ ?>

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
			window.location.assign('Error_log_report.php?Search_user=<?php echo $searchuser; ?>&from_date=<?php echo $from_date; ?>&to_date=<?php echo $to_date; ?>&spage='+page);
        });
    });
</script>

<?php } else if(($_GET['Search_user']) && ($_GET['from_date']) &&  ($_GET['to_date'])){ ?>

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
			window.location.assign('Error_log_report.php?Search_user=<?php echo $searchuser; ?>&from_date=<?php echo $from_date; ?>&to_date=<?php echo $to_date; ?>&spage='+page);
        });
    });
</script>

<?php } else if(($_GET['Search_schoolid']) && ($_GET['Search_app']) &&  ($_GET['Search_user'])) { ?>

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
			window.location.assign('Error_log_report.php?Search_schoolid=<?php echo $searchschool; ?>&Search_app=<?php echo $searchapp; ?>&Search_user=<?php echo $searchuser; ?>&spage='+page);
        });
    });
</script>

<?php }else if(($_GET['Search_schoolid']) && ($_GET['Search_app'])) { ?>

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
			window.location.assign('Error_log_report.php?Search_schoolid=<?php echo $searchschool; ?>&Search_app=<?php echo $searchapp; ?>&spage='+page);
        });
    });
</script>

<?php }else if(($_GET['Search_schoolid']) && ($_GET['Search_user'])) { ?>

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
			window.location.assign('Error_log_report.php?Search_schoolid=<?php echo $searchschool; ?>&Search_user=<?php echo $searchuser; ?>&spage='+page);
        });
    });
</script>	

<?php }else if(($_GET['Search_app']) && ($_GET['Search_user'])) { ?>

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
			window.location.assign('Error_log_report.php?Search_app=<?php echo $searchapp; ?>&Search_user=<?php echo $searchuser; ?>&spage='+page);
        });
    });
</script>	

<?php }else if($_GET['Search_schoolid']) { ?>

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
			window.location.assign('Error_log_report.php?Search_schoolid=<?php echo $searchschool; ?>&spage='+page);
        });
    });
</script>	

<?php }else if($_GET['Search_app']) { ?>

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
			window.location.assign('Error_log_report.php?Search_app=<?php echo $searchapp; ?>&spage='+page);
        });
    });
</script>	


<?php }else if($_GET['Search_user']) { ?>

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
			window.location.assign('Error_log_report.php?Search_user=<?php echo $searchuser; ?>&spage='+page);
        });
    });
</script>	

<?php }else if(($_GET['from_date']) &&  ($_GET['to_date'])){ ?>

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
			window.location.assign('Error_log_report.php?from_date=<?php echo $from_date; ?>&to_date=<?php echo $to_date; ?>&spage='+page);
        });
    });
</script>	

<?php } 
} ?>





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
			maxDate:0
            });
        });
        $(function () {
            $("#to_date").datepicker({
                //changeMonth: true,
                //changeYear: true,
				dateFormat: 'yy-mm-dd',
				maxDate:0
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            $('#example').dataTable()
            ({});
        });
    </script>
 



</head>
<body bgcolor="#CCCCCC">
<div align="center">
    <div class="container" style="width:100%;">
        <div style="padding-top:30px;">

           <u> <h2 style="padding-left:20px; margin-top:2px;color:#666"> Error Log Report</h2></u><br>

        </div>
		
		<div class='col-md-offset-4 col-md-11'>
		<div class='row' align='center' >
		<form style="margin-top:5px;">
		<div class="col-md-1" style="font-weight:bold; margin-right:-36px;"> From</div>
            <div class="col-md-1" style="width:14%;">
                <input type="text" id="from_date" name="from_date" placeholder="YYYY/MM/DD" class="form-control" value="<?php echo $from_date; ?>" autocomplete="off"></div>
            <div class="col-md-1" style="font-weight:bold; margin-right:-45px;margin-left: -10px"> To</div>
            <div class="col-md-1" style="width:14%;">
                <input type="text" id="to_date" name="to_date" placeholder="YYYY/MM/DD" class="form-control" value="<?php echo $to_date; ?>" autocomplete="off">
            </div>
            <!--<div class="col-md-1"><input type="submit" name="find" value="Find" class="btn btn-primary"></div>-->
           
			
		</div>
		<br>
		<div class='row' align="center">
			
			 <div class="col-md-80" style="width:55%;">
			 </div>
          
			<div class="col-md-2" style="width:20%;margin-left: -200px">
				<input type="text" class="form-control" name="Search" value="<?php echo $searchq; ?>" placeholder="Search by All"> 
			</div>

			<div class="col-md-2" style="width:20%;">
				<input type="text" class="form-control" name="Search_schoolid" value="<?php echo $searchschool; ?>" placeholder="Search by School ID"> 
			</div>

			<div class="col-md-2" style="width:20%;">
				<input type="text" class="form-control" name="Search_app" value="<?php echo $searchapp; ?>" placeholder="Search by Application"> 
			</div>

			<div class="col-md-2" style="width:20%;">
				<input type="text" class="form-control" name="Search_user" value="<?php echo $searchuser; ?>" placeholder="Search by User Type"> 
			</div>
			<br><br><br>
			<div class="col-md-2" style="margin-left: 70px" >
			<button type="submit" value="Search" class="btn btn-primary">Search</button>
			</div>
			<div class="col-md-1" >
			<input type="button" class="btn btn-danger" value="Reset" onclick="window.open('Error_log_report.php','_self')" />
			</div>
			
			</div>
			<div class='row col-md-offset-8'>
			<div class="col-md-1" style="margin-left:50px">
			 <a href="Export_report.php?fn=errorlog__<?php echo date('Y-m-d');?>" style="float:right; text-decoration:none;"><input type="button" value="Generate Excel Report" class="btn btn-info"/></a>
			</div><br><br>
			</div>
		
		</form>
		
		 </div> 
		
     
	
		 <!-- <div id="show" >
		 		<?php if (!($_GET['Search']) &&  !($_GET['Search_schoolid'])  &&  !($_GET['Search_app'])  &&  !($_GET['Search_user']))

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
		
	 if (isset($_GET['Search']) || isset($_GET['Search_schoolid']) || isset($_GET['Search_app']) || isset($_GET['Search_user']) || isset($_GET['from_date']) || isset($_GET['to_date']) )
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
					<th>Error ID</th>
                    <th>  Error Type </th>
					 <th> Error Description On Line</th>
                   <th>Date-Time</th>
                    <th> User Type/Member ID/School ID</th> 
					<th> Name/Email/Application</th> 
					<th> Subroutine Name/Status</th>
					<th> Assignment/Resolution Date</th> 
					<th> Assigned To/Resolved By</th>
					<th>Last Programmer Name</th>
                    <th>WebService/WebMethod</th>
                    <th>Programmer Error Message</th>
					
					
                </tr>
                </thead>

                <?php $i = 1;
					$i = ($start_from +1);
                while($result = mysql_fetch_array($query1)) {
					
                    ?>
					<tr onmouseover="this.style.cursor='pointer';this.style.textDecoration='underline';this.style.color='dodgerblue'" onmouseout="this.style.textDecoration='none';this.style.color='black';"  onclick="window.location='Error_log_report_vertical_PT.php?Err_id=<?php echo $result['id'];?>'"class="d0" style="padding-top:2px;color:#808080">
                    
                        <td data-title="Sr.No."><?php echo $i; ?></td>
                        
                       
                       
                        <td data-title="Error ID"><?php echo $result['id']; ?></td>
						<td data-title="Error Type"><?php echo $result['error_type']; ?></td>
                        <td data-title="Error Description On Line"><?php echo $result['error_description']."<br> ON Line (".$result['line'].")"; ?></td>
                        <td data-title="Date-Time"><?php echo $result['datetime']; ?></td>
						<td data-title="User Type/Member ID/School ID"><?php echo $result['user_type']."<br>(".$result['member_id'].")"."<br>(".$result['school_id'].")"; ?></td>
						<td data-title="Name/Email/Application"><?php echo $result['name']."<br>(".$result['email'].")"."<br>(".$result['app_name'].")"; ?></td>
						<td data-title="Subroutine Name/Status"><?php echo $result['subroutine_name']."(".$result['status'].")"; ?></td>
                        <td data-title="Assignment/Resolution Date"><?php echo $result['assignment_date']."<br>(".$result['resolution_date'].")"; ?></td>
                        <td data-title="Assigned To/Resolved By"><?php echo $result['assigned_to']."<br>(".$result['resolved_by'].")"; ?></td>
						
						<td data-title="Last Programmer Name"><?php echo $result['last_programmer_name']; ?></td>
                        <td data-title="WebService/WebMethod"><?php echo $result['webservice_name']."<br>(".$result['webmethod_name'].")"; ?></td>
                        <td data-title="Programmer Error Message"><?php echo $result['programmer_error_message']; ?></td>
						
						
						
						

					</tr>	
                    <?php $i++;
                } ?>
            </table>
        </div>
		<div align="left">
		 		<?php if (!($_GET['Search']) &&  !($_GET['Search_schoolid'])  &&  !($_GET['Search_app'])  &&  !($_GET['Search_user']) && !($_GET['from_date']) && !($_GET['to_date']))
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

            <table id="example" class="col-md-12 table-bordered " align="center">
                <thead>
				<!-- <tr><?php echo $sql1; ?></tr> -->
                <tr style="background-color:#0073BD; color:#FFFFFF; height:30px;">
                    <th>Sr.No.</th>
					<th>Error ID</th>
                    <th>  Error Type </th>
					 <th> Error Description On Line</th>
                   <th>Date-Time</th>
                    <th> User Type/Member ID/School ID</th> 
					<th> Name/Email/Application</th> 
					<th> Subroutine Name/Status</th>
					<th> Assignment/Resolution Date</th> 
					<th> Assigned To/Resolved By</th>
					<th>Last Programmer Name</th>
                    <th>WebService/WebMethod</th>
                    <th>Programmer Error Message</th>
					
				   
                </tr>
                </thead>

                <?php $i = 1;
					$i = ($start_from +1);
                while($result = mysql_fetch_array($sql)) {
					
                    ?>
					<tr onmouseover="this.style.cursor='pointer';this.style.textDecoration='underline';this.style.color='dodgerblue'" onmouseout="this.style.textDecoration='none';this.style.color='black';"  onclick="window.location='Error_log_report_vertical_PT.php?Err_id=<?php echo $result['id'];?>'"class="d0" style="padding-top:2px;color:#808080">
                    
                        <td data-title="Sr.No."><?php echo $i; ?></td>
                        
                       
                       
                        <td data-title="Error ID"><?php echo $result['id']; ?></td>
						<td data-title="Error Type"><?php echo $result['error_type']; ?></td>
                        <td data-title="Error Description On Line"><?php echo $result['error_description']."<br> ON Line (".$result['line'].")"; ?></td>
                        <td data-title="Date-Time"><?php echo $result['datetime']; ?></td>
						<td data-title="User Type/Member ID/School ID"><?php echo $result['user_type']."<br>(".$result['member_id'].")"."<br>(".$result['school_id'].")"; ?></td>
						<td data-title="Name/Email/Application"><?php echo $result['name']."<br>(".$result['email'].")"."<br>(".$result['app_name'].")"; ?></td>
						<td data-title="Subroutine Name/Status"><?php echo $result['subroutine_name']."(".$result['status'].")"; ?></td>
                        <td data-title="Assignment/Resolution Date"><?php echo $result['assignment_date']."<br>(".$result['resolution_date'].")"; ?></td>
                        <td data-title="Assigned To/Resolved By"><?php echo $result['assigned_to']."<br>(".$result['resolved_by'].")"; ?></td>
						
						<td data-title="Last Programmer Name"><?php echo $result['last_programmer_name']; ?></td>
                        <td data-title="WebService/WebMethod"><?php echo $result['webservice_name']."<br>(".$result['webmethod_name'].")"; ?></td>
                        <td data-title="Programmer Error Message"><?php echo $result['programmer_error_message']; ?></td>


					</tr>	
                    <?php $i++;
                } ?>
            </table>
        </div>
<div align="left">
		 		<?php if (!($_GET['Search']) &&  !($_GET['Search_schoolid'])  &&  !($_GET['Search_app'])  &&  !($_GET['Search_user']) && !($_GET['from_date']) && !($_GET['to_date']) )
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

<?php 
//Below code is added by Sayali Balkawade for SMC-4896 on 13/10/2020 

if($findq !='')
{
	$res=$findq;
}
else if($findq2 !='')
{
	$res=$findq2;
} else {
	
	$res=$findq1;
}

 
					 $rs_result = mysql_query($res);  
					
  unset($_SESSION['report_header']);
  unset($_SESSION['report_values']);

    $_SESSION['report_header']=array("Sr.No.","Error ID","Error Type","Error Description","User Type","Member ID","School ID","Name","Email","App Name","Date Time","Status","Subroutine Name","Assignment Date","Resolution Name","Assigned To","Resolved By","Last Programmer Name","Webservice Name","Web Method Name","Programmer Error Message");
  $j1=0;
          
    while($row7=mysql_fetch_assoc($rs_result))
    {
    
    $j=$j1++;
          
	$_SESSION['report_values'][$j][0]=$j1;
  $_SESSION['report_values'][$j][1]=$row7['id'];
  $_SESSION['report_values'][$j][2]=$row7['error_type'];
    $_SESSION['report_values'][$j][3]=$row7['error_description'];
    $_SESSION['report_values'][$j][4]=$row7['user_type'];
    $_SESSION['report_values'][$j][5]=$row7['member_id'];
    $_SESSION['report_values'][$j][6]=$row7['school_id'];
    $_SESSION['report_values'][$j][7]=$row7['name'];
    $_SESSION['report_values'][$j][8]=$row7['email'];
    $_SESSION['report_values'][$j][9]=$row7['app_name'];
    $_SESSION['report_values'][$j][10]=$row7['datetime'];
$_SESSION['report_values'][$j][11]=$row7['status'];
$_SESSION['report_values'][$j][12]=$row7['subroutine_name'];
$_SESSION['report_values'][$j][13]=$row7['assignment_date'];
$_SESSION['report_values'][$j][14]=$row7['resolution_date'];
$_SESSION['report_values'][$j][15]=$row7['assigned_to'];
$_SESSION['report_values'][$j][16]=$row7['resolved_by'];
$_SESSION['report_values'][$j][17]=$row7['last_programmer_name'];
$_SESSION['report_values'][$j][18]=$row7['webservice_name'];
$_SESSION['report_values'][$j][19]=$row7['webmethod_name'];
$_SESSION['report_values'][$j][20]=$row7['programmer_error_message'];
  
   }  
?>        
						
