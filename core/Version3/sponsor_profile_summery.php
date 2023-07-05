<?php
include("cookieadminheader.php");

$index_url='http://'.$_SERVER['HTTP_HOST'];
if (isset($_POST['search'])) {

    $from_date = $_POST['from_date'];
    $to_date = $_POST['to_date'];
    $person_id = $_POST['person_id'];
    $category = $_POST['category'];
    $_SESSION['category'] = $category;
    $_SESSION['person_id'] = $person_id;


    if ($from_date != '' && $to_date != '' && $person_id != '' && $from_date !=$to_date) {
   // $sql="SELECT sp.id,sp.sp_company,sp.sp_address,sp.sp_email,sp.sp_phone,sp.sp_website,sp.sp_date,sp.amount,sp.sales_person_id,c.category from tbl_sponsorer sp  join categories c on sp.v_category=c.id  where sp.sales_person_id='$person_id'  and sp.sp_date between '$from_date' and '$to_date' ";
		
		$sql = "SELECT sp.sp_name,sp.sp_img_path,sp.id,sp.source,sp.sp_company,sp.sp_address,sp.sp_email,sp.sp_phone,sp.sp_website,sp.sp_date,sp.amount,sp.sales_person_id,sp.v_category,sp.v_responce_status,sp.comment,sp.calback_date_time,sp.v_status,sp.lat,sp.lon,sp.sales_p_lat,sp.sales_p_lon,sp.entity_id,sp.user_member_id,sp.platform_source,sp.app_version,sp.payment_method,sp.sp_country,sp.calculated_lat,sp.calculated_lon,spd.Sponser_type,spd.Sponser_product,spd.Sponser_product,spd.points_per_product,spd.sponsor_id,spd.discount from tbl_sponsorer sp join tbl_sponsored spd on sp.id=spd.sponsor_id where sp.sales_person_id='$person_id'  and sp.sp_date between '$from_date' and '$to_date'";
    }
	if ($from_date != '' && $to_date != '' && $person_id != '' && $from_date ==$to_date) {
   // $sql="SELECT sp.id,sp.sp_company,sp.sp_address,sp.sp_email,sp.sp_phone,sp.sp_website,sp.sp_date,sp.amount,sp.sales_person_id,c.category from tbl_sponsorer sp  join categories c on sp.v_category=c.id  where sp.sales_person_id='$person_id'  and sp.sp_date between '$from_date' and '$to_date' ";
		
		$sql = "SELECT sp.sp_name,sp.sp_img_path,sp.id,sp.source,sp.sp_company,sp.sp_address,sp.sp_email,sp.sp_phone,sp.sp_website,sp.sp_date,sp.amount,sp.sales_person_id,sp.v_category,sp.v_responce_status,sp.comment,sp.calback_date_time,sp.v_status,sp.lat,sp.lon,sp.sales_p_lat,sp.sales_p_lon,sp.entity_id,sp.user_member_id,sp.platform_source,sp.app_version,sp.payment_method,sp.sp_country,sp.calculated_lat,sp.calculated_lon,spd.Sponser_type,spd.Sponser_product,spd.Sponser_product,spd.points_per_product,spd.sponsor_id,spd.discount from tbl_sponsorer sp join tbl_sponsored spd on sp.id=spd.sponsor_id where sp.sales_person_id='$person_id'  and sp.sp_date like '%$from_date%'";
    }
	
    if ($from_date != '' && $to_date != '' && $person_id == '' && $from_date !=$to_date) {
			//$sql="SELECT sp.id,sp.sp_company,sp.sp_address,sp.sp_email,sp.sp_phone,sp.sp_website,sp.sp_date,sp.amount,sp.sales_person_id,c.category from tbl_sponsorer sp join categories c on sp.v_category=c.id where sp.sp_date between '$from_date' and '$to_date' ";
	
		$sql = "SELECT sp.sp_name,sp.sp_img_path,sp.id,sp.source,sp.sp_company,sp.sp_address,sp.sp_email,sp.sp_phone,sp.sp_website,sp.sp_date,sp.amount,sp.sales_person_id,sp.v_category,sp.v_responce_status,sp.comment,sp.calback_date_time,sp.v_status,sp.lat,sp.lon,sp.sales_p_lat,sp.sales_p_lon,sp.entity_id,sp.user_member_id,sp.platform_source,sp.app_version,sp.payment_method,sp.sp_country,sp.calculated_lat,sp.calculated_lon,spd.Sponser_type,spd.Sponser_product,spd.Sponser_product,spd.points_per_product,spd.sponsor_id,spd.discount from tbl_sponsorer sp join tbl_sponsored spd on sp.id=spd.sponsor_id where sp.sp_date between '$from_date' and '$to_date'";
    }
	if ($from_date != '' && $to_date != '' && $person_id == '' && $from_date ==$to_date) {
			//$sql="SELECT sp.id,sp.sp_company,sp.sp_address,sp.sp_email,sp.sp_phone,sp.sp_website,sp.sp_date,sp.amount,sp.sales_person_id,c.category from tbl_sponsorer sp join categories c on sp.v_category=c.id where sp.sp_date between '$from_date' and '$to_date' ";
	
		$sql = "SELECT sp.sp_name,sp.sp_img_path,sp.id,sp.source,sp.sp_company,sp.sp_address,sp.sp_email,sp.sp_phone,sp.sp_website,sp.sp_date,sp.amount,sp.sales_person_id,sp.v_category,sp.v_responce_status,sp.comment,sp.calback_date_time,sp.v_status,sp.lat,sp.lon,sp.sales_p_lat,sp.sales_p_lon,sp.entity_id,sp.user_member_id,sp.platform_source,sp.app_version,sp.payment_method,sp.sp_country,sp.calculated_lat,sp.calculated_lon,spd.Sponser_type,spd.Sponser_product,spd.Sponser_product,spd.points_per_product,spd.sponsor_id,spd.discount from tbl_sponsorer sp join tbl_sponsored spd on sp.id=spd.sponsor_id where sp.sp_date like '%$from_date%'";
    }
	
    if (($from_date == '' || $to_date == '') && $person_id != '') {
        //$sql="SELECT sp.id,sp.sp_company,sp.sp_address,sp.sp_email,sp.sp_phone,sp.sp_website,sp.sp_date,sp.amount,sp.sales_person_id,c.category from tbl_sponsorer sp  join categories c on sp.v_category=c.id  where sp.sales_person_id='$person_id' ";
		
		$sql = "SELECT sp.sp_name,sp.sp_img_path,sp.id,sp.source,sp.sp_company,sp.sp_address,sp.sp_email,sp.sp_phone,sp.sp_website,sp.sp_date,sp.amount,sp.sales_person_id,sp.v_category,sp.v_responce_status,sp.comment,sp.calback_date_time,sp.v_status,sp.lat,sp.lon,sp.sales_p_lat,sp.sales_p_lon,sp.entity_id,sp.user_member_id,sp.platform_source,sp.app_version,sp.payment_method,sp.sp_country,sp.calculated_lat,sp.calculated_lon,spd.Sponser_type,spd.Sponser_product,spd.Sponser_product,spd.points_per_product,spd.sponsor_id,spd.discount from tbl_sponsorer sp join tbl_sponsored spd on sp.id=spd.sponsor_id  where sp.sales_person_id='$person_id'";
    }
    if (($from_date == $to_date) && $person_id != '' && $from_date != '') {
        
		//$sql="SELECT sp.id,sp.sp_company,sp.sp_address,sp.sp_email,sp.sp_phone,sp.sp_website,sp.sp_date,sp.amount,sp.sales_person_id,c.category from tbl_sponsorer sp  join categories c on sp.v_category=c.id  where sp.sales_person_id='$person_id'  and sp.sp_date = '$from_date'";
		
		$sql = "SELECT sp.sp_name,sp.sp_img_path,sp.id,sp.source,sp.sp_company,sp.sp_address,sp.sp_email,sp.sp_phone,sp.sp_website,sp.sp_date,sp.amount,sp.sales_person_id,sp.v_category,sp.v_responce_status,sp.comment,sp.calback_date_time,sp.v_status,sp.lat,sp.lon,sp.sales_p_lat,sp.sales_p_lon,sp.entity_id,sp.user_member_id,sp.platform_source,sp.app_version,sp.payment_method,sp.sp_country,sp.calculated_lat,sp.calculated_lon,spd.Sponser_type,spd.Sponser_product,spd.Sponser_product,spd.points_per_product,spd.sponsor_id,spd.discount from tbl_sponsorer sp join tbl_sponsored spd on sp.id=spd.sponsor_id where sp.sales_person_id='$person_id'  and sp.sp_date like '%$from_date%'";
    }
  /*  if (($from_date == $to_date) && $person_id == '' && $from_date != '') {
		//$sql="SELECT sp.id,sp.sp_company,sp.sp_address,sp.sp_email,sp.sp_phone,sp.sp_website,sp.sp_date,sp.amount,sp.sales_person_id,c.category from tbl_sponsorer sp  join categories c on sp.v_category=c.id  where sp.sp_date = '$from_date'";

	   $sql = "SELECT sp.sp_name,sp.sp_img_path,sp.id,sp.source,sp.sp_company,sp.sp_address,sp.sp_email,sp.sp_phone,sp.sp_website,sp.sp_date,sp.amount,sp.sales_person_id,sp.v_category,sp.v_responce_status,sp.comment,sp.calback_date_time,sp.v_status,sp.lat,sp.lon,sp.sales_p_lat,sp.sales_p_lon,sp.entity_id,sp.user_member_id,sp.platform_source,sp.app_version,sp.payment_method,sp.sp_country,sp.calculated_lat,sp.calculated_lon from tbl_sponsorer sp  where sp.sp_date like '%$from_date%'";
    }*/
	
	if ($from_date == '' && $to_date == '' && $person_id != '' && $category != '') {
		//$sql="SELECT sp.id,sp.sp_company,sp.sp_address,sp.sp_email,sp.sp_phone,sp.sp_website,sp.sp_date,sp.amount,sp.sales_person_id,c.category from tbl_sponsorer sp  join categories c on sp.v_category=c.id  where sp.sp_date = '$from_date'";

	   $sql = "SELECT sp.sp_name,sp.sp_img_path,sp.id,sp.source,sp.sp_company,sp.sp_address,sp.sp_email,sp.sp_phone,sp.sp_website,sp.sp_date,sp.amount,sp.sales_person_id,sp.v_category,sp.v_responce_status,sp.comment,sp.calback_date_time,sp.v_status,sp.lat,sp.lon,sp.sales_p_lat,sp.sales_p_lon,sp.entity_id,sp.user_member_id,sp.platform_source,sp.app_version,sp.payment_method,sp.sp_country,sp.calculated_lat,sp.calculated_lon,spd.Sponser_type,spd.Sponser_product,spd.Sponser_product,spd.points_per_product,spd.sponsor_id,spd.discount from tbl_sponsorer sp join tbl_sponsored spd on sp.id=spd.sponsor_id where sp.sales_person_id='$person_id' and sp.v_category='$category'";
    }
	if ($from_date != '' && $to_date != '' && $person_id == '' && $category != '' && $category != 'Select'  && $from_date==$to_date) {
		//$sql="SELECT sp.id,sp.sp_company,sp.sp_address,sp.sp_email,sp.sp_phone,sp.sp_website,sp.sp_date,sp.amount,sp.sales_person_id,c.category from tbl_sponsorer sp  join categories c on sp.v_category=c.id  where sp.sp_date = '$from_date'";

	   $sql = "SELECT sp.sp_name,sp.sp_img_path,sp.id,sp.source,sp.sp_company,sp.sp_address,sp.sp_email,sp.sp_phone,sp.sp_website,sp.sp_date,sp.amount,sp.sales_person_id,sp.v_category,sp.v_responce_status,sp.comment,sp.calback_date_time,sp.v_status,sp.lat,sp.lon,sp.sales_p_lat,sp.sales_p_lon,sp.entity_id,sp.user_member_id,sp.platform_source,sp.app_version,sp.payment_method,sp.sp_country,sp.calculated_lat,sp.calculated_lon from tbl_sponsorer sp  where  sp.v_category='$category' and sp.sp_date like '%$from_date%'";
    }
    if ($from_date == "" && $to_date == "" && $person_id == "") {
        
		//$sql="SELECT sp.id,sp.sp_company,sp.sp_address,sp.sp_email,sp.sp_phone,sp.sp_website,sp.sp_date,sp.amount,sp.sales_person_id,c.category from tbl_sponsorer sp  join categories c on sp.v_category=c.id ";
		
		
		$sql = "SELECT sp.sp_name,sp.sp_img_path,sp.id,sp.source,sp.sp_company,sp.sp_address,sp.sp_email,sp.sp_phone,sp.sp_website,sp.sp_date,sp.amount,sp.sales_person_id,sp.v_category,sp.v_responce_status,sp.comment,sp.calback_date_time,sp.v_status,sp.lat,sp.lon,sp.sales_p_lat,sp.sales_p_lon,sp.entity_id,sp.user_member_id,sp.platform_source,sp.app_version,sp.payment_method,sp.sp_country,sp.calculated_lat,sp.calculated_lon,spd.Sponser_type,spd.Sponser_product,spd.Sponser_product,spd.points_per_product,spd.sponsor_id,spd.discount from tbl_sponsorer sp join tbl_sponsored spd on sp.id=spd.sponsor_id";
    }
	

    if ($category != '' && $from_date == '' && $to_date == '' && $person_id == '') {
        $sql .= " where sp.v_category='$category' order by sp.id desc";
    }
    if ($category == '') {
        $sql .= "order by sp.id desc";
    }
//echo $sql;

    $row = mysql_query($sql);
//    $result = mysql_fetch_array($row);
//    var_dump($result);
//    die;
    $count1 = mysql_num_rows($row);
} else {
	
    //$sql="SELECT sp.id,sp.sp_company,sp.sp_address,sp.sp_email,sp.sp_phone,sp.sp_website,sp.sp_date,sp.amount,sp.sales_person_id,c.category from tbl_sponsorer sp left join categories c on sp.v_category=c.id order by sp.id desc";
	
	
	$sql = "SELECT sp.sp_name,sp.sp_img_path,sp.id,sp.source,sp.sp_company,sp.sp_address,sp.sp_email,sp.sp_phone,sp.sp_website,sp.sp_date,sp.amount,sp.sales_person_id,sp.v_category,sp.v_responce_status,sp.comment,sp.calback_date_time,sp.v_status,sp.lat,sp.lon,sp.sales_p_lat,sp.sales_p_lon,sp.entity_id,sp.user_member_id,sp.platform_source,sp.app_version,sp.payment_method,sp.sp_country,sp.calculated_lat,sp.calculated_lon,spd.Sponser_type,spd.Sponser_product,spd.Sponser_product,spd.points_per_product,spd.sponsor_id,spd.discount,ls.LogoutTime from tbl_sponsorer sp join tbl_sponsored spd on sp.id=spd.sponsor_id join tbl_LoginStatus ls on ls.EntityID =sp.id order by sp.id desc";
 
   $row = mysql_query($sql);
  
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Sponsor List</title>
    <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
	<script>
	function gotodetails(id)
	{
		alert(id);
	}
	</script>
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
		.sortable{
				cursor: pointer;
		}
    </style>
    <script>
        $(function () {
            $("#from_date").datepicker({
				dateFormat: 'yy-mm-dd',
               
            });
        });
        $(function () {
            $("#to_date").datepicker({
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
    <div class="row" style="padding-top:60px;">
        <form method="post">
            <div class="col-md-2" style="font-weight:bold; margin-right:-52px;margin-left:-3%"> Person Name</div>
            <div class="col-md-2" style="width:17%;">
                <select name="person_id" class="form-control">
                    <?php $query = mysql_query("select person_id,p_name from tbl_salesperson"); ?>
                    <option value="">Select</option>
                    <?php $j = 1;
                    while ($test = mysql_fetch_array($query)) {
                        ?>
                        <option value="<?php echo $test['person_id'] ?>" <?php if (($_SESSION['person_id']) == $test['person_id']) {
                            echo $_POST['person_id']; ?> selected="selected" <?php } ?>><?php echo $test['p_name']; ?></option>
                        <?php $j++;
                    }
                    ?>
                </select></div>
            <div class="col-md-1" style="font-weight:bold; margin-right:-36px;"> Category</div>
            <div class="col-md-2" style="width:17%;">
                <select name="category" class="form-control">
                    <?php $query1 = mysql_query("select id,category from categories"); ?>
                    <option selected="selected">Select</option>
					
                    <?php $k = 1;
                    while ($test1 = mysql_fetch_array($query1)) {
                        ?>
                        <option value="<?php echo $test1['id'] ?>" <?php if (($_SESSION['category']) == $test1['id']) {
                            echo $_POST['category']; ?> selected="selected" <?php } ?> ><?php echo $test1['category']; ?></option>
                        <?php $k++;
                    }
                    ?>
                </select></div>
            <div class="col-md-1" style="font-weight:bold; margin-right:-36px;"> from</div>
            <div class="col-md-1" style="width:13%;">
                <input type="text" id="from_date" name="from_date" placeholder="MM/DD/YYYY" class="form-control" value="<?php if (isset($_POST['from_date'])) {echo $_POST['from_date'];} ?>"></div>
            <div class="col-md-1" style="font-weight:bold; margin-right:-54px;margin-left:-28px;"> To</div>
            <div class="col-md-1" style="width:13%;">
                <input type="text" id="to_date" name="to_date" placeholder="MM/DD/YYYY" class="form-control" value="<?php if (isset($_POST['to_date'])) {echo $_POST['to_date'];} ?>">
            </div>
            <div class="col-md-1"><input type="submit" name="search" value="Search" class="btn btn-primary"></div>
           <br>
           <br>
            <?php if (isset($_POST['search']) && $count1 != 0) {?>
                <div class="col-md-1"><input type="submit" name="report" value="Report" class="btn btn-primary" onClick="javascript:printDiv('printablediv')"></div>
            <?php } ?>
        </form>
    </div>

    <div style="width:100%;">
        <div style="padding-top:50px;">
            <h2 style="padding-left:20px; margin-top:2px;color:#666">Sponsor Profile Summery</h2>
        </div>
        <div id="no-more-tables" style="padding-top:20px;">
            <table id="example" class="col-md-12 table-bordered ">
                <thead>
                <tr style="background-color:#CCCCCC; color:#000000; height:30px;">
                    <th>Sr.No.</th>
                    <th>SponsorMemberId/Phone/LastLogin</th>                    
					<!--<th> Country</th>-->
					<th> Shop Image</th>
					<th>Company Name</th>  
					<th> Lat-Long</th>									                  
                    <th>Sponsor Category</th>                                     					
                    <th>Member  Discount</th>                                     					
                    <th>Discount Type</th>
                    
                    <th>Standard Discount And Points</th>
					<th> Product Name</th>
					<th> Product Discount And Points</th>	
					 <th> Reg.Date</th>
					<th> Registered By</th>
                </tr>
                </thead>
                <?php $i = 1;
				$server_name = $_SERVER['SERVER_NAME'];	
                while ($result = mysql_fetch_array($row)){
                ?>
				
                <tr class='sortable' onclick="window.location.href = 'http://<?php echo $server_name; ?>/core/sponsor_deatils.php?id=<?php echo $result['id'] ?>';">
                    <td data-title="Sr.No."><?php echo $i; ?></td>
                    <td data-title="SponsorMemberId/PhoneNo/LastLogin"><?php echo $result['id']."</br>".$result['sp_phone']."</br>".$result['LogoutTime'];?></td>
                   
					<!--<td data-title="countrycode"><?php// echo $result['sp_country'];?></td>-->
					
					<?php if($result['sp_img_path']!=''){ ?>
						<td data-title="sponsor image"><img style='width:40%' src="<?php echo $index_url."/core/".$result['sp_img_path']; ?>"/></td>
					<?php  }else {?>
						<td data-title="sponsor image">NA</td>
					<?php } ?>
					 <td data-title="Company Name"><?php echo $result['sp_company']; ?></td>
					<td data-title="latlong"><?php echo $result['lat']."</br>".$result['lon']; ?></td>
					
					
					
					
                    
                    <td data-title="category"><?php 
					$cat = $result['v_category'];
					if($cat!='')
					{
						if($cat=='Fashion and Lifestyle')
						{
							echo "Fashion and Lifestyle";
						}
						elseif($cat=='food')
						{
							echo "Food";
						}
						else
						{
							$qry = mysql_query("select category from categories where id='$cat'");
							$r = mysql_fetch_array($qry);
							echo $r[0]; 
						}
					}
					else{
						echo "NA";
					}
					
					?></td>
                   
                    
					<td data-title="Member Discount "><?php echo "0"; ?></td>
					<td data-title="Discount Type"><?php echo $result['Sponser_type']; ?></td>
					
					<td data-title="Standard Discount And Points ">
					<?php
					if($result['Sponser_type']=='Discount' ||$result['Sponser_type']=='discount')
					{
					echo $result['Sponser_product'];"%" echo "<br>"; echo $result['points_per_product'];
					}
					
					
					?></td>
					<td data-title="Product Name"><?php
						if($result['Sponser_type']=='Product' || $result['Sponser_type']=='product')
						{
							echo $result['Sponser_product'];
						}
						?></td>
					<td data-title="Product Discount And Points"><?php
						if($result['Sponser_type']=='Product' || $result['Sponser_type']=='product')
						{
							echo $result['discount']; echo "<br>";echo $result['points_per_product'];
						}
						?></td>
						
					 <td data-title="Reg.Date"><?php echo $result['sp_date']; ?></td>
				   <td data-title="Registered By"><?php
                        $sp_id = $result['sales_person_id'];
						$entity_id = $result['entity_id'];
                        if ($sp_id == 0 && $entity_id!='' && $entity_id!=0 && $entity_id!=113 && $entity_id!=108) {
							echo "suggested by</br>";
                            if($entity_id =='103'){ 
								echo "Teacher </br>";
								$teacher_query = mysql_query("select t_complete_name from tbl_teacher");
								$teacher_result = mysql_fetch_assoc($teacher_query);
								echo $teacher_result['t_complete_name'];
								}
							if($entity_id =='105'){ 
								echo "Student </br>";
								$student_query = mysql_query("select std_complete_name from tbl_student");
								$student_result = mysql_fetch_assoc($student_query);
								echo $student_result['std_complete_name'];
								}
							
							
                        }
						elseif($entity_id =='113'){ 
								echo "Enrolled By Cookieadmin </br>";
								
								}	
						elseif($entity_id =='108'){ 
								echo "New Shop added by ".$result['sp_name']."</br>";
							
                        } 	
						
						elseif($sp_id != 0 && $sp_id != '') {
							echo "Enrolled By </br>";
                            $sql2 = mysql_query("select p_name from tbl_salesperson where person_id='$sp_id'");
                            $sql3 = mysql_fetch_array($sql2);
                            echo $sql3['p_name'];
                        }
											?></td>
						
					

					
					
                    <?php $i++;
                    }
                    ?>
            </table>
        </div>
        <div class="printablediv" id="printablediv" style="display:none;">
            <div class="container" style="border-width:2px;border-style: solid;">
                <div class="row" style="padding-top:20px;" align="center">
                    <h2> Sponsor Registered List </h2>
                </div>
                <div class="row" style="padding-left:20px;" align="center">
                    <h3><?php
                        if (isset($_POST['person_id'])) {
                            $p_id = $_POST['person_id'];
                            $query1 = mysql_query("select p_name from tbl_salesperson where person_id='$p_id'");
                            $test1 = mysql_fetch_array($query1);
                            echo $test1['p_name'];
                        }
                        ?> </h3>
                </div>
                <div class="row" style="padding-top:10px;padding-left:20px;" align="center">
                    <h4><?php
                        $from_date = $_POST['from_date'];
                        echo $_POST['from_date']; ?> &nbsp;&nbsp; To &nbsp;&nbsp;<?php $to_date = $_POST['to_date'];
                        echo $_POST['to_date']; ?></h4>
                </div>
                <div class="row" align="center" style="padding-top:20px;">
                    <table bordercolor="rgb(6,79,168)" border="2" style="border-style:solid;padding:5px;"
                           cellspacing="5">
                        <thead>
                        <tr>
                            <th width="7%"><font face="tahoma" color="rgb(6,79,168)">Sr.No.</font></th>
                            <th width="10%"><font face="tahoma" color="rgb(6,79,168)">Registered Date</font></th>
                            <th width="20%"><font face="tahoma" color="rgb(6,79,168)">Sponsor Name</font></th>
                            <th width="30%"><font face="tahoma" color="rgb(6,79,168)">Sponsor Address</font></th>
                            <th width="15%"><font face="tahoma" color="rgb(6,79,168)">Category</font></th>
                            <th width="15%"><font face="tahoma" color="rgb(6,79,168)">Email ID</font></th>
                            <th width="10%"><font face="tahoma" color="rgb(6,79,168)">Phone No</font></th>
                            <th width="10%"><font face="tahoma" color="rgb(6,79,168)">Amount</font></th>

                        </thead>
                        </tr>
                        <?php
                        if ($from_date != '' && $to_date != '' && $p_id != '') {
                            $sql = "SELECT sp.id,sp.v_status,sp.source,sp.sp_company,sp.sp_address,sp.sp_email,sp.sp_phone,sp.sp_website,sp.sp_date,sp.amount,sp.sales_person_id,c.category from tbl_sponsorer sp  join categories c on sp.v_category=c.id  where sp.sales_person_id='$p_id'  and sp.sp_date between '$from_date' and '$to_date' ";
                        }

                        if ($from_date != '' && $to_date != '' && $p_id == '') {
                            $sql = "SELECT sp.id,sp.v_status,sp.source,sp.sp_company,sp.sp_address,sp.sp_email,sp.sp_phone,sp.sp_website,sp.sp_date,sp.amount,sp.sales_person_id,c.category from tbl_sponsorer sp join categories c on sp.v_category=c.id where sp.sp_date between '$from_date' and '$to_date' ";
                        }

                        if (($from_date == '' || $to_date == '') && $p_id != '') {
                            $sql = "SELECT sp.id,sp.v_status,sp.source,sp.sp_company,sp.sp_address,sp.sp_email,sp.sp_phone,sp.sp_website,sp.sp_date,sp.amount,sp.sales_person_id,c.category from tbl_sponsorer sp  join categories c on sp.v_category=c.id  where sp.sales_person_id='$p_id' ";
                        }
                        if (($from_date == $to_date) && $p_id != '' && $from_date != '') {
                            $sql = "SELECT sp.id,sp.v_status,sp.source,sp.sp_company,sp.sp_address,sp.sp_email,sp.sp_phone,sp.sp_website,sp.sp_date,sp.amount,sp.sales_person_id,c.category from tbl_sponsorer sp  join categories c on sp.v_category=c.id  where sp.sales_person_id='$p_id'  and sp.sp_date = '$from_date'";
                        }
                        if (($from_date == $to_date) && $p_id == '' && $from_date != '') {
                            $sql = "SELECT sp.id,sp.v_status,sp.source,sp.sp_company,sp.sp_address,sp.sp_email,sp.sp_phone,sp.sp_website,sp.sp_date,sp.amount,sp.sales_person_id,c.category from tbl_sponsorer sp  join categories c on sp.v_category=c.id  where sp.sp_date = '$from_date'";
                        }

                        if ($from_date == "" && $to_date == "" && $p_id == "") {
                            $sql = "SELECT sp.id,sp.v_status,sp.source,sp.sp_company,sp.sp_address,sp.sp_email,sp.sp_phone,sp.sp_website,sp.sp_date,sp.amount,sp.sales_person_id,c.category from tbl_sponsorer sp  join categories c on sp.v_category=c.id ";
                        }
                        if ($category != '') {
                            $sql .= "and sp.v_category='$category' order by sp.id desc";
                        }

                        if ($category == '') {
                            $sql .= "order by sp.id desc";
                        }
                        //$row=mysql_query($sql);
                        //$count1=mysql_num_rows($row);
                        //$query = "SELECT id,sp_company,sp_address,sp_email,sp_phone,sp_website,sp_date,amount,sales_person_id from tbl_sponsorer  where sales_person_id='$p_id'  and sp_date between '$from_date' and '$to_date' order by id";
						
                        $res = mysql_query($sql);
                        $count = mysql_num_rows($res);
                        $i = 1;
                        while ($test1 = mysql_fetch_array($res)) {
                            ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $test1['sp_date']; ?></td>
                                <td><?php echo $test1['sp_company']; ?></td>
                                <td><?php echo $test1['sp_address']; ?></td>
                                <td><?php echo $test1['category']; ?></td>
                                <td><?php echo $test1['sp_email']; ?></td>
                                <td><?php echo $test1['sp_phone']; ?></td>
                                <td data-title="amount"><?php if ($test1['amount'] == "" or $test1['amount'] == 0) {
                                        $amount = "Free Registered";
                                    } else {
                                        $amount = $test1['amount'];
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
        </div><!-- end of right content-->
    </div>   <!--end of center content -->
</div>
</div>
</div>
</div>
</body>
</html>