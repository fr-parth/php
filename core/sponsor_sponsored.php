<?php 
include("cookieadminheader.php");
//@include 'conn.php'; 

?>
<!DOCTYPE html>
<html>
<head>
<title>Sponsors</title>
 <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
</head><body>
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.dataTables.min.js"></script>
<script src="js/jquery.twbsPagination.js" type="text/javascript"></script> 

<?php
//START - change for pagination by Ajinkya(Nagpur intern).
$limit =  $webpagelimit; //from securityfunctions.php

if (!($_GET['Search'])){  
	if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };  
	$start_from = ($page-1) * $limit;
	//start - change in query	
	$sql="SELECT sp_company, sp_address, sp_city, sp_state, sp_country, sp_phone, sp_email, sp_website, lat, lon 
			FROM tbl_sponsorer 
			ORDER BY sp_name 
			ASC limit $start_from, $limit";

	//end		
	$result = mysql_query($sql);
	$sql1 ="SELECT COUNT(id) FROM tbl_sponsorer";
	
						$rs_result = mysql_query($sql1);  
						$row1 = mysql_fetch_row($rs_result);  
						$total_records = $row1[0]; 
						$total_pages = ceil($total_records / $limit);
						
						if($total_pages == $_GET['page']){
						$limit = $total_records;
						}else{
						$limit = $start_from + $limit;
						
						}
}else{
	if (isset($_GET["spage"])){ $spage  = $_GET["spage"]; } else { $spage=1; };  
			$start_from = ($spage-1) * $limit;
			$searchq=$_GET['Search'];
			$colname=$_GET['colname'];
		
	if ($colname != ''and $colname != 'Select'){

		$qstr = "SELECT sp_company, sp_address, sp_city, sp_state, sp_country, sp_phone, sp_email, sp_website FROM tbl_sponsorer
		WHERE $colname like '%$searchq%' LIMIT $start_from, $limit";
		
		$query1=mysql_query($qstr) or die("could not Search!");
				
		$sql1 =mysql_query("SELECT sp_company, sp_address, sp_city, sp_state, sp_country, sp_phone, sp_email, sp_website 
		FROM tbl_sponsorer
		WHERE  $colname like '%$searchq%'	order by sp_name") or die("could not Search!");

					$total_records = mysql_num_rows($sql1);   
					$total_pages = ceil($total_records / $limit);
	}
	else{
			$qstr2 = "SELECT sp_company, sp_address, sp_city, sp_state, sp_country, sp_phone, sp_email, sp_website 
			FROM tbl_sponsorer
			WHERE sp_company LIKE '%$searchq%' 
			OR sp_address LIKE '%$searchq' 
			OR sp_city LIKE '%$searchq%' 
			OR sp_state LIKE  '%$searchq%'
			OR sp_country LIKE  '%$searchq%'
			OR sp_phone LIKE '%$searchq%'
			OR sp_email LIKE  '%$searchq%'
			OR sp_website LIKE '%$searchq%'
			LIMIT $start_from, $limit";
			$query1=mysql_query($qstr2) or die("query2 failed");
			
			
			$sql1 = mysql_query("SELECT sp_company, sp_address, sp_city, sp_state, sp_country, sp_phone, sp_email, sp_website 
			FROM tbl_sponsorer
			WHERE sp_company LIKE '%$searchq%' 
			OR sp_address LIKE '%$searchq%' 
			OR sp_city 	LIKE '%$searchq%' 
			OR sp_state LIKE '%$searchq%'
			OR sp_country LIKE '%$searchq%' 
			OR sp_phone LIKE '%$searchq%' 
			OR sp_email LIKE '%$searchq%' 
			OR sp_website LIKE '%$searchq%' ") or die("query 3 Search!");   

					$total_records = mysql_num_rows($sql1);    
					$total_pages = ceil($total_records / $limit);
		}
			if($total_pages == $_GET['spage']){
					$limit = $total_records;
					}else{
					$limit = $start_from + $limit;
					}			 
	}
?>
<script>
$(document).ready(function(){
    $('#example').DataTable( {
	"paging":   false,
	"info":false,
	"searching": false,
     "scrollCollapse": false,
	//"scrollY": "500px",
	//"scrollX": "100%"
    } );
});
</script>
<?php if (!($_GET['Search'])){;?>
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
			window.location.assign('sponsor_sponsored.php?page='+page);
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
			window.location.assign('sponsor_sponsored.php?colname=<?php echo $colname;?>&Search=<?php echo $searchq; ?>&spage='+page);
        });
    });
</script>
<?php }?>
<?php

if(isset($_GET['del'])){
	$sp=$_GET['del'];
	mysql_query(" DELETE FROM `tbl_sponsorer` WHERE `id`= $sp ");
	//mysql_query(" DELETE FROM `tbl_sponsored` WHERE `sponsor_id`= $sp ");
	header("Location:sponsor_sponsored.php");
}
if(isset($_GET['sps'])){
	$sps=$_GET['sps'];	//$tsmart = mysql_connect("Tsmartcookies.db.7121184.hostedresource.com","Tsmartcookies","B@v!2018297");
	$smart = mysql_connect("SmartCookies.db.7121184.hostedresource.com","SmartCookies","b@V!2017297",true);
	if($_SERVER['HTTP_HOST']=='tsmartcookies.bpsi.us'){		
		$q=mysql_query("select * from `tbl_sponsorer` WHERE `id`='$sps'",$con)or die(mysql_error());	
		while($a=mysql_fetch_array($q)){		
			$p=mysql_query("insert into tbl_sponsorer (sp_name,sp_address,sp_city,sp_dob,sp_gender,sp_country,sp_state,sp_email,sp_phone,sp_password,sp_date,sp_occupation,sp_company,sp_website,sp_img_path,school_id,register_throught,lat,lon,pin,sales_person_id,expiry_date,amount,v_status,v_likes,v_category,temp_phone,otp_phone,temp_email,otp_email,sp_landline) values('".$a['sp_name']."', '".$a['sp_address']."','".$a['sp_city']."','".$a['sp_dob']."','".$a['sp_gender']."','".$a['sp_country']."','".$a['sp_state']."','".$a['sp_email']."','".$a['sp_phone']."','".$a['sp_password']."','".$a['sp_date']."','".$a['sp_occupation']."','".$a['sp_company']."','".$a['sp_website']."','".$a['sp_img_path']."','".$a['school_id']."','".$a['register_throught']."','".$a['lat']."','".$a['lon']."','".$a['pin']."','".$a['sales_person_id']."','".$a['expiry_date']."','".$a['amount']."','".$a['v_status']."','".$a['v_likes']."','".$a['v_category']."','".$a['temp_phone']."','".$a['otp_phone']."','".$a['temp_email']."','".$a['otp_email']."','".$a['sp_landline']."')",$smart)or die(mysql_error());
		} 

		
	}else{				mysql_select_db('SmartCookies', $smart);
		$q=mysql_query("select * from `tbl_sponsorer` WHERE `id`='$sps'",$smart)or die(mysql_error());	
		while($a=mysql_fetch_array($q)){		
			$p=mysql_query("insert into tbl_sponsorer (sp_name,sp_address,sp_city,sp_dob,sp_gender,sp_country,sp_state,sp_email,sp_phone,sp_password,sp_date,sp_occupation,sp_company,sp_website,sp_img_path,school_id,register_throught,lat,lon,pin,sales_person_id,expiry_date,amount,v_status,v_likes,v_category,temp_phone,otp_phone,temp_email,otp_email,sp_landline) values('".$a['sp_name']."', '".$a['sp_address']."','".$a['sp_city']."','".$a['sp_dob']."','".$a['sp_gender']."','".$a['sp_country']."','".$a['sp_state']."','".$a['sp_email']."','".$a['sp_phone']."','".$a['sp_password']."','".$a['sp_date']."','".$a['sp_occupation']."','".$a['sp_company']."','".$a['sp_website']."','".$a['sp_img_path']."','".$a['school_id']."','".$a['register_throught']."','".$a['lat']."','".$a['lon']."','".$a['pin']."','".$a['sales_person_id']."','".$a['expiry_date']."','".$a['amount']."','".$a['v_status']."','".$a['v_likes']."','".$a['v_category']."','".$a['temp_phone']."','".$a['otp_phone']."','".$a['temp_email']."','".$a['otp_email']."','".$a['sp_landline']."')",$con)or die(mysql_error());
		} 		
	}	
		if($p){
			echo "<script>alert('Succefully Copied')</script>";
		}else{
			echo "<script>alert('Error Occured')</script>";
		}
	
	

	//mysql_query(" DELETE FROM `tbl_sponsored` WHERE `sponsor_id`= $sp ");
	header("Location:sponsor_sponsored.php");
	
}
//START-change for pagination problem bug No. 3328 by Ajinkya (Nagpur Intern)

?>
<script>
function confirmation(xxx) {

    var answer = confirm("Are you sure you want to delete?")
    if (answer)
    {
        
        window.location = "sponsor_sponsored.php?del="+xxx;
    }
    else
    {   
    }
}
</script>
<div class="" style="background-color:#fff;">
<div class="panel panel-default" style="min-height:100%;min-width:103%; overflow:hidden;">
  <!-- Default panel contents -->
  <div class="panel-heading"><h2 style="text-decoration: underline;" align="center">Sponsors List With Location And Coupons</h2></div>
  <form style="margin-top:9px;">
			<div class="col-md-2"></div>
			<div class="col-md-2" style="font-weight:bold;" align="right">Search By
			</div>
            <div class="col-md-2" style="width:17%;">
                <select name="colname" class="form-control">
				<!--school_id,school_name,name,reg_date,balance_blue_points,assign_blue_points-->
					<option selected="selected">Select</option>
					
                    <option value="sp_company"
					<?php if (($_GET['colname']) == "sp_company") {
							echo $_GET['colname']; ?> selected="selected" <?php } ?>>Company</option>
							
                     <option value="sp_address"
					<?php if (($_GET['colname']) == "sp_address") {
							echo $_GET['colname']; ?> selected="selected" <?php } ?>>Address</option>
							
					<option value="sp_city"
					<?php if (($_GET['colname']) == "sp_city") {
							echo $_GET['colname']; ?> selected="selected" <?php } ?>>City</option>  
							
					<option value="sp_state"
					<?php if (($_GET['colname']) == "sp_state") {
							echo $_GET['colname']; ?> selected="selected" <?php } ?>>State</option> 
							 
					<option value="sp_country"
					<?php if (($_GET['colname']) == "sp_country") {
							echo $_GET['colname']; ?> selected="selected" <?php } ?>>Country</option>
							  
					<option value="sp_phone"
					<?php if (($_GET['colname']) == "sp_phone") {
							echo $_GET['colname']; ?> selected="selected" <?php } ?>>Phone No.</option> 

					<option value="sp_email"
					<?php if (($_GET['colname']) == "sp_email") {
							echo $_GET['colname']; ?> selected="selected" <?php } ?>>Email ID</option>

					<option value="sp_website"
					<?php if (($_GET['colname']) == "sp_website") {
							echo $_GET['colname']; ?> selected="selected" <?php } ?>>Website</option>
							
                </select>
			</div>
			<div class="col-md-2" style="width:17%;">
				<input type="text" class="form-control" name="Search" value="<?php echo $searchq; ?>" placeholder="Search.." required> 
			</div>
			<div class="col-md-1">
			<button type="submit" value="Search" class="btn btn-primary">Search</button>
			</div>
			<div class="col-md-1">
			<input type="button" class="btn btn-danger" value="Reset" onclick="window.open('sponsor_sponsored.php','_self')" />
			</div>
		</form>
		<div id="show" style="margin-top: 70px;">
			<?php /*if (!($_GET['Search']))
			{   
				if ($limit >$total_records){ $limit=$total_records;}
				echo "<font color='blue' style='margin-left: 50px;'><b style='margin-left:400px;'>Now showing ".($start_from +1)." to ".($limit)." records out of ".$total_records. " records.</b></font>";
		    }else
			{
				if ($limit >$total_records){ $limit=$total_records;}
				echo "<font color='blue' style='margin-left: 50px;'><b style='margin-left:400px;'>Now showing ".($start_from +1)." to ".($limit)." records out of ".($total_records). " records.</b></font>";
			}*/
			?>
		</div>
			<?php
		if (isset($_GET['Search']))
		{
			$count=mysql_num_rows($query1);
			if($count == 0){
					echo "<script>$('#show').css('display','none');</script><div style='margin-top:66px;'><font color='Red' style='margin-left: 29px;'><b style='margin-left:490px;'><b>There Was No Search Result</b></font></div>";
			}
			else
			{//else block when search is set 
			?>
				<!-- <div id="no-more-tables" style="padding-top:20px;">
						 <table id="example" class="col-md-12 table-bordered " align="center">
                            <thead>
                            <tr style="background-color:#9F5F9F;color:white;box-shadow: 1px 1px 1px 2px  rgba(150,150,150, 0.6);height:30px;"> -->
							<table class="table-bordered table-striped" id='example'>
							<thead>
							<th>Sr.No.</th>
							<th>Company</th>
							<th>Address</th>
							<th>City</th>
							<th>State</th>
							<th>Country</th>
							<th>Phone No.</th>
							<th>Email ID</th>
							<th>Website</th>
							<th>Copy</th>
							<th>Location</th>
							<th>Coupons</th>
							<th>Delete</th>
							</thead>
							<?php $i=($start_from +1);
						while($result=mysql_fetch_array($query1)){?>
							<tr >
							<td><?php echo $start; ?></td>
							<td><?php echo $sp=$result['sp_company']; ?></td>
							<td><?php echo $result['sp_address']; ?></td>
							<td><?php echo $result['sp_city']; ?></td>
							<td><?php echo $result['sp_state']; ?></td>
							<td><?php echo $result['sp_country']; ?></td>
							<td><?php echo $result['sp_phone']; ?></td>
							<td ><?php echo $result['sp_email']; ?></td>
							<td><?php echo $result['sp_website']; ?></td>
							<td><a href="sponsor_sponsored.php?sps=<?php echo  $sp_id; ?>"><?php if($_SERVER['HTTP_HOST']=='tsmartcookies.bpsi.us'){ echo "Copy2Smart"; } else{ echo "Copy2TSmart";}?> </td>
							<td><a href="sponsor_location.php?a=<?php echo $a; ?>&b=<?php echo $b; ?>&sp=<?php echo $sp; ?>"><span class=' glyphicon glyphicon-map-marker'></span></a></td>
							<?php if($num_rows >=1 ){ ?>
							<td style=" float:left; "><a href="sponsored_coupons.php?cpns=<?php echo $sp_id; ?>"><span class='glyphicon glyphicon-tags'></span><span style="link-style:none; color:#000; font-size:20px; float:right;"><?php echo $num_rows;?></span></a></td>
							<?php } else{ ?>
							<td style=" float:left; "><span class='glyphicon glyphicon-tags'></span><span style="link-style:none; color:#000; font-size:20px; float:right;"><?php echo $num_rows;?></span></td>
							<?php } ?>
							<td >
							<a href="#" ><button class='glyphicon glyphicon-trash' alt="Location" style="width:35px;height:42px;" onClick="confirmation(<?php echo  $sp_id; ?>)"></button></a>
							</td>
						</tr>
				<?php  $i++;} ?>
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
		<table class="table" id='example'>
			<thead>
			<tr>
				<th>Sr.No.</th>
				<th>Company</th>
				<th>Address</th>
				<th>City</th>
				<th>State</th>
				<th>Country</th>
				<th>Phone No.</th>
				<th>Email ID</th>
				<th>Website</th>
				<th>Copy</th>
				<th>Location</th>
				<th>Coupons</th>
				<th>Delete</th>
			</tr>
			</thead>
			<tbody>
			<?php
				$start=$start_from+1;

				while($result1=mysql_fetch_array($result)){
					$sp_id=$result1['id'];
					$get_cpn = mysql_query("SELECT id FROM tbl_sponsored WHERE `sponsor_id` = $sp_id ");
					$num_rows = mysql_num_rows($get_cpn);
					$a=$result1['lat'];
					$b=$result1['lon'];
				?>

				<tr >
					<td><?php echo $start; ?></td>
					<td><?php echo $sp=$result1['sp_company']; ?></td>
					<td><?php echo $result1['sp_address']; ?></td>
					<td><?php echo $result1['sp_city']; ?></td>
					<td><?php echo $result1['sp_state']; ?></td>
					<td><?php echo $result1['sp_country']; ?></td>
					<td><?php echo $result1['sp_phone']; ?></td>
					<td ><?php echo $result1['sp_email']; ?></td>
					<td><?php echo $result1['sp_website']; ?></td>
					<td><a href="sponsor_sponsored.php?sps=<?php echo  $sp_id; ?>"><?php if($_SERVER['HTTP_HOST']=='tsmartcookies.bpsi.us'){ echo "Copy2Smart"; } else{ echo "Copy2TSmart";}?> </td>
					<td><a href="sponsor_location.php?a=<?php echo $a; ?>&b=<?php echo $b; ?>&sp=<?php echo $sp; ?>"><span class=' glyphicon glyphicon-map-marker'></span></a></td>
					<?php if($num_rows >=1 ){ ?>
					<td style=" float:left; "><a href="sponsored_coupons.php?cpns=<?php echo $sp_id; ?>"><span class='glyphicon glyphicon-tags'></span><span style="link-style:none; color:#000; font-size:20px; float:right;"><?php echo $num_rows;?></span></a></td>
					<?php } else{ ?>
					<td style=" float:left; "><span class='glyphicon glyphicon-tags'></span><span style="link-style:none; color:#000; font-size:20px; float:right;"><?php echo $num_rows;?></span></td>
					<?php } ?>
					<td >
					<a href="#" ><button class='glyphicon glyphicon-trash' alt="Location" style="width:35px;height:42px;" onClick="confirmation(<?php echo  $sp_id; ?>)"></button></a>
					</td>
				</tr>
			<?php
			$start++;
			};
			?></tbody>
		</table>
	</div>
			<div class="container" align="center">
						<nav aria-label="Page navigation">
						<ul class="pagination" id="pagination"></ul>
						</nav>
					</div>
<?php }?>
</div>
</div>
</div>
</body>
</html>