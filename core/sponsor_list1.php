<?php

include("corporate_cookieadminheader.php");
//header problem solved
ob_start();
 $index_url=$GLOBALS['URLNAME'];
 $from_date = $_GET['from_date'];
    $to_date = $_GET['to_date'];

 
//$group_member_id = $_SESSION['group_admin_id'];
//include('conn.php');

 //$sql = "SELECT std_name,std_Father_name,std_lastname,std_complete_name,school_id,std_school_name,std_email,std_phone,std_address from tbl_student where group_member_id = '$group_member_id' order by school_id";
//$row = mysql_query($sql);


/*START-Change in pagignation problem line by sachin*/
//$webpagelimit = 10;
//$s="SELECT std_name,std_Father_name,std_lastname,std_complete_name,school_id,std_school_name,std_email,std_phone,std_address from tbl_student where group_member_id = '$group_member_id' order by school_id";

			 
			
if ($_GET['find']){
	
	 

if (isset($_GET["fpage"])){ $fpage  = mysql_real_escape_string($_GET["fpage"]); } else { $fpage=1; };  
$start_from = ($fpage-1) * $webpagelimit;

if ($from_date != '' and $to_date != '')
{
	
	
$q1=mysql_query("select s.id,s.sp_name,s.sp_address,s.sp_img_path,s.sp_date,s.expiry_date,s.sponaor_img_path,
s.sp_company,s.v_category,s.sp_email,s.sp_phone,s.sales_person_id,c.category,
sp.person_id,sp.p_name
 from tbl_sponsorer s
 LEFT JOIN tbl_salesperson sp ON s.sales_person_id=sp.person_id
 LEFT JOIN categories c ON s.v_category=c.id where s.sp_date between '$from_date' and '$to_date'  
 order by s.id	LIMIT $start_from, $webpagelimit");

$q2 ="select count(s.id),s.sp_name,s.sp_address,s.sp_img_path,s.sp_date,s.expiry_date,s.sponaor_img_path,
s.sp_company,s.v_category,s.sp_email,s.sp_phone,s.sales_person_id,c.category,
sp.person_id,sp.p_name
 from tbl_sponsorer s
 LEFT JOIN tbl_salesperson sp ON s.sales_person_id=sp.person_id
 LEFT JOIN categories c ON s.v_category=c.id  where s.sp_date between '$from_date' and '$to_date'
 order by s.id  ";	
 $count=mysql_num_rows($q1);
					$rs_result = mysql_query($q2);  
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
	
$sql=mysql_query("select s.id,s.sp_name,s.sp_address,s.sp_img_path,s.sp_date,s.sponaor_img_path,
s.sp_company,s.v_category,s.sp_email,s.sp_phone,s.sales_person_id,c.category,
sp.person_id,sp.p_name
 from tbl_sponsorer s
 LEFT JOIN tbl_salesperson sp ON s.sales_person_id=sp.person_id
 LEFT JOIN categories c ON s.v_category=c.id 
 order by s.id  
        
LIMIT $start_from, $webpagelimit");	

$sql1 ="select count(s.id),s.sp_name,s.sp_address,s.sp_img_path,s.sp_date,s.sponaor_img_path,
s.sp_company,s.v_category,s.sp_email,s.sp_phone,s.sales_person_id,c.category,
sp.person_id,sp.p_name
 from tbl_sponsorer s
 LEFT JOIN tbl_salesperson sp ON s.sales_person_id=sp.person_id
 LEFT JOIN categories c ON s.v_category=c.id 
 order by s.id  ";  
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
		$query1=mysql_query("select s.id,s.sp_name,s.sp_address,s.sp_img_path,s.sp_date,s.sponaor_img_path,
s.sp_company,s.v_category,s.sp_email,s.sp_phone,s.sales_person_id,c.category,
sp.person_id,sp.p_name
 from tbl_sponsorer s
 LEFT JOIN tbl_salesperson sp ON s.sales_person_id=sp.person_id
 LEFT JOIN categories c ON s.v_category=c.id 
  
  where 
            s.sp_name LIKE '%$searchq%' or 
			s.sp_address LIKE '%$searchq%'  or 
			s.sp_company LIKE '%$searchq%'or 
			s.sp_email LIKE '%$searchq%'or 
			c.category LIKE '%$searchq%' or
	        s.sp_phone LIKE '%$searchq%'or 
		    s.id LIKE '%$searchq%' or
			s.sp_date LIKE '%$searchq%' or
			sp.p_name LIKE '%$searchq%'
						
			order by s.id 
			LIMIT $start_from, $webpagelimit") 
			or die("could not Search!");
			
			$sql1 ="select count(s.id),s.sp_name,s.sp_address,s.sp_img_path,s.sp_date,s.sponaor_img_path,
s.sp_company,s.v_category,s.sp_email,s.sp_phone,s.sales_person_id,c.category,
sp.person_id,sp.p_name
 from tbl_sponsorer s
 LEFT JOIN tbl_salesperson sp ON s.sales_person_id=sp.person_id
 LEFT JOIN categories c ON s.v_category=c.id 

  where 
            s.sp_name LIKE '%$searchq%' or 
			s.sp_address LIKE '%$searchq%'  or 
			s.sp_company LIKE '%$searchq%'or 
			s.sp_email LIKE '%$searchq%'or
			c.category LIKE '%$searchq%' or
	        s.sp_phone LIKE '%$searchq%'or 
		    s.id LIKE '%$searchq%' or
			s.sp_date LIKE '%$searchq%' or
			sp.p_name LIKE '%$searchq%'
						
			order by s.id"; 

			$rs_result = mysql_query($sql1);  
					$row1 = mysql_fetch_row($rs_result);  
				    $total_records = $row1[0];  
					$total_pages = ceil($total_records / $webpagelimit);

	}else{
			//$q1="SELECT std_name,std_Father_name,std_lastname,std_complete_name,school_id,std_school_name,std_email,std_phone,std_address from tbl_student where group_member_id = '$group_member_id' AND (std_name LIKE '$searchq%' or std_Father_name LIKE '$searchq%' or std_lastname LIKE '$searchq%' or std_complete_name LIKE '%$searchq%' or school_id LIKE '$searchq%' or std_school_name LIKE '%$searchq%' or std_email LIKE '$searchq%' or std_phone LIKE '$searchq%'or std_address LIKE '$searchq%') order by school_id";

			$query1=mysql_query("select s.id ,s.sp_name,s.sp_address,s.sp_img_path,s.sp_date,s.sponaor_img_path,
s.sp_company,s.v_category,s.sp_email,s.sp_phone,s.sales_person_id,c.category,
sp.person_id,sp.p_name
 from tbl_sponsorer s
 LEFT JOIN tbl_salesperson sp ON s.sales_person_id=sp.person_id
 LEFT JOIN categories c ON s.v_category=c.id  
  where 
     $colname LIKE '%$searchq%' order by s.id LIMIT $start_from, $webpagelimit") 
		or die("could not Search!");
					//echo $query1;
		
		$sql1 ="select count(s.id) ,s.sp_name,s.sp_address,s.sp_img_path,s.sp_date,s.sponaor_img_path,
s.sp_company,s.v_category,s.sp_email,s.sp_phone,s.sales_person_id,c.category,
sp.person_id,sp.p_name
 from tbl_sponsorer s
 LEFT JOIN tbl_salesperson sp ON s.sales_person_id=sp.person_id
 LEFT JOIN categories c ON s.v_category=c.id 
 
  where 
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
	"searching": false,
     "scrollCollapse": true,
	 "scrollX":true
            });
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
	<script>


    function confirmation(id) {

			var numberOfChecked = $('input:checkbox:checked').length;
			var checkbox = $('#select-all').is(':checked');

			if(checkbox == true)
			{
				var numberOfChecked = parseInt(numberOfChecked - 1);
			}
			if(numberOfChecked == '1' && checkbox == true)
			{
				alert("Please first select a record to delete!");
				return false;
			}
			else if(numberOfChecked == '0'){
				alert("Please first select a record to delete!");
				return false;
			}
			
			else if(confirm("Are you sure you want to delete " + numberOfChecked +" sponsors?"))
			{
				return true;
			}
			else
			return false;
        //var answer = confirm("Are you sure you want to delete" + numberOfChecked +"sponsors?");
		
/*
        if (answer) {
			
           //alert('DELETE FROM tbl_sponsorer where id='+xxx);
            
            window.location.assign("delete_sponsor.php?id=" + id);
            // window.location.assign = ;
			


        }

        else {
				window.location("sponsor_list.php");

        }*/

    }


</script>

	
	<script>
    $(document).ready(function(){
            $("tr").not(':first').hover(
        function () {
          $(this).css("background","");
          //$(this).css("color","white");
        },
        function () {
          $(this).css("background","");
        }
      );

	  $('#select-all').click(function(event) {   
		if(this.checked) {
        // Iterate each checkbox
        $(':checkbox').each(function() {
            this.checked = true;                        
        });
    }
	else 
		$(':checkbox').each(function() {
            this.checked = false;                        
        });
});
    });
    </script>
	 <script>
    function gotodetails(id)
    {
        alert(id);
    }
    </script>
	
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
			window.location.assign('sponsor_list.php?from_date=<?php echo $from_date ;?>&to_date=<?php echo $to_date; ?>&find=<?php echo find; ?>&fpage='+page);
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
			window.location.assign('sponsor_list.php?page='+page);
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
			window.location.assign('sponsor_list.php?Search=<?php echo $searchq; ?>&spage='+page);
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
				dateFormat: 'yy-mm-dd'

            });
        });
        $(function () {
            $("#to_date").datepicker({
				dateFormat: 'yy-mm-dd'

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

            <h2 style="padding-left:20px; margin-top:2px;color:#666"> List of Sponsor</h2>

        </div>
		<div class='row'>
		<form style="margin-top:25px;">
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
          
			<div class="col-md-1" style="width:17%;">
				<input type="text" class="form-control" name="Search" value="<?php echo $searchq; ?>" placeholder="Search.." required> 
			</div>
			<div class="col-md-1" >
			<button type="submit" value="Search" class="btn btn-primary">Search</button>
			</div>
			<div class="col-md-1" >
			<input type="button" class="btn btn-info" value="Reset" onclick="window.open('sponsor_list.php','_self')" />
			</div>
				</form>	      
		
					<!-- <div style="margin-left: 800px;">
						<input type="text" name="Search" value="" placeholder="Search..">
						<input type="submit" value="Search">
						<input type="button" value="Reset" onclick="window.open('beneficiary_list.php','_self')" />
					</div> -->
					
<form action="" method="POST">
					
				<div style="margin-left: 1100px !important; margin-top: 15px;">
<input type="submit" name="delete" value="Delete" class="btn btn-danger" 
onclick="return confirmation(this.id)" ></div>
 
			

<div style="margin-left: 350px !important; margin-top:-20px;"><font color='blue'>
<b>Select All </b></font><input type="checkbox" name="select-all" id="select-all" /></div>
					

			<?php if(isset($_POST['delete']))
            {
				// echo "hii..";exit;
                $id = $_REQUEST['delete_spons'];

                $ids = implode(',',$id);
                    //print_r($id); exit;
                //foreach($id as $ids){
                    //$del_query = "DELETE from tbl_sponsorer where id='$ids'"; 
                    $del_query = "DELETE from tbl_sponsorer where id in ($ids)";
                     $del_res = mysql_query($del_query);
                    if($del_res)
                    {
                        echo "<script>alert('Sponsors deleted succesfully.');window.location.href='/core/sponsor_list.php';
						</script>";
                    }

                //}


			}  ?>	
					
					
		
			
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
		if (isset($_GET['find']))
		{
			
			$count=mysql_num_rows($q1);
			if($count == 0){
				
				echo "<script>$('#show').css('display','none');</script><div style='margin-top:20px;'><font color='Red'><b>There Was No Search Result</b></script></font></div>";	
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
                    
                   <th>Member ID</th>
				   <th>Name</th>
				   <th>Address</th>
                    <th> Date</th>
                    <th>Sponsor Image </th>
					<th> Company Name</th>
					<th> Shop image</th> 
					<th>Email ID</th>
					<th>Phone Number</th>
					<th> Category</th>
					<th> Enrolled/Suggested By</th>
					<th> Edit</th>
					<th> Delete</th>
					
                </tr>
                </thead>

                <?php  $i = 1;
					$i = ($start_from +1);
                while($result = mysql_fetch_array($q1)) {
                    ?>
                    <tr>
                        <td data-title="Sr.No."><?php echo $i; ?></td>
                        
                       
                       
                        <td data-title="Member ID"><?php echo $result['id'];?></td>
					    <td data-title="Name"><?php echo $result['sp_name']; ?></td>
                        <td data-title="Address"><?php echo $result['sp_address']; ?></td>
                        <td data-title="Date"><?php echo $result['sp_date']; ?></td>
						 
						 <?php if($result['sp_img_path']!=''){ ?>
						<td data-title="Sponsor image"><img style='width:40%' src="<?php echo $index_url."/core/".$result['sp_img_path']; ?>"/></td>
					<?php  }else {?>
						<td data-title="Sponsor image">NA</td>
					<?php } ?>

					
						 
						 
						 <td data-title="Company Name"><?php echo $result['sp_company']; ?></td>
						 
						 <?php if($result['sponaor_img_path']!=''){ ?>
						<td data-title="Shop image"><img style='width:40%' src="<?php echo $index_url."/core/".$result['sponaor_img_path']; ?>"/></td>
					<?php  }else {?>
						<td data-title="Shop image">NA</td>
					<?php } ?>
						 
						 <td data-title="Email ID"><?php echo $result['sp_email']; ?></td>
						 <td data-title="Phone Number"><?php echo $result['sp_phone'];?></td>
						 <td data-title="category"><?php echo $result['category'];?></td>
						 <td data-title="Enrolled/Suggested"><?php echo $result['p_name']; ?></td>
						 
						 <td>
                      <a href="edit_sponsor_details1.php?id=<?php echo $result['id']; ?>">
                        <center><img src="/Images/edit.png" style=" width:25px;height:25px;"></center>
                          </a></td>				
						
						 <td>
						 <input type="checkbox" name="delete_spons[]" id="delete_spons" value="<?php echo $result['id']; ?>"> 
                        <!-- <center><img src="Images/cancel.png" style=" width:25px;height:25px;"alt="Cancel"
						id="<?php echo $result['id']; ?>" onclick="return confirmation(this.id)"></center> -->
                          </td>
						 
						 
				
						 
                    </tr>
					
                    <?php $i++;
                } ?>
            </table>
			
			<div align=left>
				<?php 
		 				
		 				echo "<div style='margin-top:5px;'><font color='#0073BD'>
						<style='margin-center:600px;'>Now showing ".($start_from +1)." to ".($webpagelimit)." records out of ".$total_records. " records.</style></font></div>";
		    
		 				
		 			?>
			</div>
			
			
			
			
        </div>
			
		
		
			<?php
			}
 
		}
		
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
                    
                   <th>Member ID</th>
				   <th>Name</th>
				   <th>Address</th>
                    <th> Date</th>
                    <th>Sponsor Image </th>
					<th> Company Name</th>
					<th> Shop image</th>
					<th>Email ID</th>
					<th>Phone Number</th>
					<th> Category</th>
					<th> Enrolled/Suggested By</th>
					<th> Edit</th>
					<th> Delete</th>
					
                </tr>
                </thead>

                <?php  $i = 1;
					$i = ($start_from +1);
                while($result = mysql_fetch_array($query1)) {
                    ?>
                    <tr>
                        <td data-title="Sr.No."><?php echo $i; ?></td>
                        
                       
                       
                        <td data-title="Member ID"><?php echo $result['id'];?></td>
					    <td data-title="Name"><?php echo $result['sp_name']; ?></td>
                        <td data-title="Address"><?php echo $result['sp_address']; ?></td>
                        <td data-title="Date"><?php echo $result['sp_date']; ?></td>
						 
						 <?php if($result['sp_img_path']!=''){ ?>
						<td data-title="Sponsor image"><img style='width:40%' src="<?php echo $index_url."/core/".$result['sp_img_path']; ?>"/></td>
					<?php  }else {?>
						<td data-title="Sponsor image">NA</td>
					<?php } ?>

					
						 
						 
						 <td data-title="Company Name"><?php echo $result['sp_company']; ?></td>
						 
						 <?php if($result['sponaor_img_path']!=''){ ?>
						<td data-title="Shop image"><img style='width:40%' src="<?php echo $index_url."/core/".$result['sponaor_img_path']; ?>"/></td>
					<?php  }else {?>
						<td data-title="Shop image">NA</td>
					<?php } ?>
						 
						 
						 
						 
						 <td data-title="Email ID"><?php echo $result['sp_email']; ?></td>
						 <td data-title="Phone Number"><?php echo $result['sp_phone'];?></td>
						 <td data-title="category"><?php echo $result['category'];?></td>
						 <td data-title="Enrolled/Suggested"><?php echo $result['p_name']; ?></td>
						 
						 
						 
						 
						 

						 <td>
                      <a href="edit_sponsor_details1.php?id=<?php echo $result['id']; ?>">
                        <center><img src="/Images/edit.png" style=" width:25px;height:25px;"></center>
                          </a></td>				
						
						 <td>
						 <input type="checkbox" name="delete_spons[]" id="delete_spons" value="<?php echo $result['id']; ?>"> 
                        <!-- <center><img src="Images/cancel.png" style=" width:25px;height:25px;"alt="Cancel"
						id="<?php echo $result['id']; ?>" onclick="return confirmation(this.id)"></center> -->
                          </td>
						 
						 
				
						 
                    </tr>
					
					
					
					
					
						  
						  
                    <?php $i++;
                } ?>
            </table>
			
			<div align=left>
				<?php if (!($_GET['Search']))
		 			{
		 				if ($webpagelimit >$total_records){ $webpagelimit=$total_records;}
		 				echo "<div style='margin-top:5px;'><font color='#0073BD'>< style='margin-center:600px;'>Now showing ".($start_from +1)." to ".($webpagelimit)." records out of ".$total_records. " records.</font></div>";
		    }else
		 			{
		 				if ($webpagelimit >$total_records){ $webpagelimit=$total_records;}
		 				echo "<div style='margin-top:5px;'><font color='#0073BD'><style='margin-center:600px;'>Now showing ".($start_from +1)." to ".($webpagelimit)." records out of ".($total_records). " records.</font></div>";
		 			}
		 			?>
			</div>
			
			
			
			
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
					 <th>Member ID</th>
				   <th>Name</th>
				   <th>Address</th>
                    <th> Date</th>
                    <th>Sponsor Image </th>
					<th> Company Name</th>
					<th> Shop image</th>
					<th>Email ID</th>
					<th>Phone Number</th>
					<th> Category</th>
					<th> Enrolled/Suggested By</th>
					<th> Edit</th>
					<th> Delete</th>
                </tr>
				
                </thead>
				
				

                <?php $i = 1;
				 $i = ($start_from +1);
                while($result = mysql_fetch_array($sql)) {
                    ?>
                    <tr>
					<td data-title="Sr.No."><?php echo $i; ?></td>
                        
                       
                       
                        <td data-title="Member ID"><?php echo $result['id'];?></td>
					    <td data-title="Name"><?php echo $result['sp_name']; ?></td>
                        <td data-title="Address"><?php echo $result['sp_address']; ?></td>
                        <td data-title="Date"><?php echo $result['sp_date']; ?></td>
						 
						 <?php if($result['sp_img_path']!=''){ ?>
						<td data-title="Sponsor image"><img style='width:40%' src="<?php echo $index_url."/core/".$result['sp_img_path']; ?>"/></td>
					<?php  }else {?>
						<td data-title="Sponsor image">NA</td>
					<?php } ?>

						 <td data-title="Company Name"><?php echo $result['sp_company']; ?></td>
						 
						 <?php if($result['sponaor_img_path']!=''){ ?>
						<td data-title="Shop image"><img style='width:40%' src="<?php echo $index_url."/core/".$result['sponaor_img_path']; ?>"/></td>
					<?php  }else {?>
						<td data-title="Shop image">NA</td>
					<?php } ?>
						 
						 <td data-title="Email ID"><?php echo $result['sp_email']; ?></td>
						  <td data-title="Phone Number"><?php echo $result['sp_phone'];?></td>
						 <td data-title="Category"><?php echo $result['category']; ?></td>
						 
						 <td data-title="Enrolled/Suggested">
						 <?php 
						 echo $result['p_name'];
											?></td>

					<td>
					
                      <a href="edit_sponsor_details1.php?id=<?php echo $result['id']; ?>">
                        <center><img src="..//Images/edit.png" style=" width:25px;height:25px;"></center>
                          </a></td>				
						
						 <td>
						 <input type="checkbox" name="delete_spons[]" id="delete_spons" value="<?php echo $result['id']; ?>"> 
                        <!-- <center><img src="Images/cancel.png" style=" width:25px;height:25px;"alt="Cancel"
						id="<?php echo $result['id']; ?>" onclick="return confirmation(this.id)"></center> -->
                          </td>
					
					</tr>
					
                    <?php $i++;
                } ?>
            </table>
			
        </div>
		<div align="left">
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

	<div style="padding-top:50px;">

            
        </div>
		
		
		<div class="printablediv" id="printablediv" style="display:none;">
            <div class="container" style="border-width:2px;border-style: solid;">
                <div class="row" style="padding-top:20px;" align="center">
                    <h2> Sponsor Registered List </h2>
                </div>
                <div class="row" style="padding-left:20px;" align="center">
                    
                </div>
                <div class="row" style="padding-top:10px;padding-left:20px;" align="center">
                    <h4><?php
                        
                        echo $_GET['from_date']; ?> &nbsp;&nbsp; To &nbsp;&nbsp;<?php 
                        echo $_GET['to_date']; ?></h4>
                </div>
                <div class="row" align="center" style="padding-top:20px;">
                    <table bordercolor="rgb(6,79,168)" border="2" style="border-style:solid;padding:5px;"
                           cellspacing="5">
                       <thead>
				<!-- <tr><?php echo $q2; ?></tr> -->
                <tr style="background-color:#0073BD; color:#FFFFFF; height:30px;">
                    <th>Sr.No.</th>
                    <th>Member ID</th>
				   <th>Name</th>
				   <th>Address</th>
                   <th> Date</th>
					<th> Company Name</th>
					
					<th>Email ID</th>
					<th>Phone Number</th>
					<th> Category</th>
					
					
					<th>Amount</th>
                </tr>
                </thead>
                       <?php  
					   
					   if ($from_date != '' and $to_date != '')
{
	
	
$q1=mysql_query("select s.id,s.sp_name,s.sp_address,s.sp_img_path,s.sp_date,s.expiry_date,s.sponaor_img_path,
s.sp_company,s.v_category,s.sp_email,s.sp_phone,s.sales_person_id,c.category,
sp.person_id,sp.p_name
 from tbl_sponsorer s
 LEFT JOIN tbl_salesperson sp ON s.sales_person_id=sp.person_id
 LEFT JOIN categories c ON s.v_category=c.id where s.sp_date between '$from_date' and '$to_date'  
 order by s.id");

$q2 ="select count(s.id),s.sp_name,s.sp_address,s.sp_img_path,s.sp_date,s.expiry_date,s.sponaor_img_path,
s.sp_company,s.v_category,s.sp_email,s.sp_phone,s.sales_person_id,c.category,
sp.person_id,sp.p_name
 from tbl_sponsorer s
 LEFT JOIN tbl_salesperson sp ON s.sales_person_id=sp.person_id
 LEFT JOIN categories c ON s.v_category=c.id  where s.sp_date between '$from_date' and '$to_date'
 order by s.id  ";	
 $count=mysql_num_rows($q1);
					   
					   
					   
}				   
					   $i = 1;
					$i = ($start_from +1);
                while($result = mysql_fetch_array($q1)) {
                    ?>
                            <tr>
                        <td data-title="Sr.No."><?php echo $i; ?></td>
                        <td data-title="Member ID"><?php echo $result['id'];?></td>
					    <td data-title="Name"><?php echo $result['sp_name']; ?></td>
                        <td data-title="Address"><?php echo $result['sp_address']; ?></td>
                        <td data-title="Date"><?php echo $result['sp_date']; ?></td>
						 
						 
						 <td data-title="Company Name"><?php echo $result['sp_company']; ?></td>
						 
						 
						 <td data-title="Email ID"><?php echo $result['sp_email']; ?></td>
						 <td data-title="Phone Number"><?php echo $result['sp_phone'];?></td>
						 <td data-title="category"><?php echo $result['category'];?></td>
						 
                                <td data-title="Amount"><?php if ($result['amount'] == "" or $result['amount'] == 0) {
                                        $amount = "Free Registered";
                                    } else {
                                        $amount = $result['amount'];
                                    }
                                    echo $amount; ?></td>
                            </tr>
                            <?php $i++;
                        } ?>
                    </table>
                </div>
                <div class="row" style="padding-top:20px;"><h6>Subtotal:
                        <?php echo $count; ?></h6>
                </div>
            </div>
			</div>
        
			<div class="container">
			<nav aria-label="Page navigation">
			  <ul class="pagination" id="pagination"></ul>
		    </nav>
		</div>
    </div>
			
</div>
</form>
</div>

</body>
</html>