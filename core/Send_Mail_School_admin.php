<?php
/**
 * Created by PhpStorm.
 * User: Bpsi-Rohit
 * Date: 9/23/2017
 * Time: 4:29 PM
 */
error_reporting(0);
	include("cookieadminheader.php");
	$res = mysql_query("select id,type,email_body from tbl_email_sms_templates");

		$id = $_SESSION['id'];
		$query = "select * from `tbl_school_admin` where id='$id'";       // uploaded by
		$row1 = mysql_query($query);
		$value1 = mysql_fetch_array($row1);
		$uploaded_by = $value1['name'];
		$smartcookie = new smartcookie();
		/*$id=$_SESSION['id']; */
		$fields = array("id" => $id);
		/*$table="tbl_school_admin";*/
		$smartcookie = new smartcookie();
		$results = $smartcookie->retrive_individual($table, $fields);
		$result = mysql_fetch_array($results);
		$sc_id = $result['school_id'];
		
		
$limit = 50;  
if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };  
$start_from = ($page-1) * $limit;
$sql ="select name, school_id,school_name, email, mobile, email_status, send_sms_status, sms_time_log, email_time_log, scadmin_country from tbl_school_admin order by id LIMIT $start_from, $limit ";
/*End*/
$arr = mysql_query($sql);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.cs">
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
                padding-right: 10px;
                white-space: nowrap;
            }
            /*
            Label the data
            */
            #no-more-tables td:before {
                content: attr(data-title);
            }
        }
    </style>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Smart Cookie:Send SMS/EMAIL</title>
    <style>
        .dropdown1 {
            padding-left: 460px;
            margin-top: 15px;
        }
        .dropdown2 {
            padding-left: 500px;
            margin-top: 15px;
        }
    </style>
</head>
	<script>
		/*$(document).ready(function () {
			$('#example').dataTable({
			"bPaginate": true,
				 "bFilter": true,
				 "bInfo": true
			});
		})*/
		$(document).ready(function() {
    $('#example').dataTable( {
	"paging":   false,
	"searching": false
    } );
} );
		function confirmEmail(Status,school_id,email,name) {
			//alert(email);return false;
			if (Status == 'Send_Email') {
				var answer = confirm("Are you sure,do you want to resend Email");
				if (answer) {
					window.location = "SendEmail_Scadmin.php?email="+email+"&school_id="+school_id+"&name="+name;
				}
				else {
				}
			} else {
				window.location = "SendEmail_Scadmin.php?email="+email+"&school_id="+school_id+"&name="+name;
			}
		}

		function confirmSMS(phone,school_id,Status,country) {
			var template_id=document.getElementById("type").value;
			//alert(template_id);
			if(Status=='Send_SMS'){
				var answer = confirm("Are you sure,do you want to resend SMS");
				if (answer) {
					window.location = "Send_SMS_School_admin.php?phone="+phone+"&school_id="+school_id+"&Status="+Status+"&country="+country+"&template_id="+template_id;
				}
				else {
				}
			}else{
				window.location = "Send_SMS_School_admin.php?phone="+phone+"&school_id="+school_id+"&Status="+Status+"&country="+country+"&template_id="+template_id;
			}
		}


	</script>
	<body bgcolor="#CCCCCC">
	<div style="bgcolor:#CCCCCC">
		<div class="container" style="padding:30px;width:1500px">
			<div style="border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">
				<div style="background-color:#F8F8F8 ;">
					<div class="row">
						<div class="col-md-3 " style="color:#700000 ;padding:5px;">&nbsp;&nbsp;&nbsp;&nbsp;
							<!--<a href="teacher_setup.php">   <input type="submit" class="btn btn-primary" name="submit" value="Add Teacher" style="width:150;font-weight:bold;font-size:14px;"/></a>-->
						</div>
						<div class="col-md-6 " align="center">
							<h2>&nbsp&nbsp&nbsp&nbspSend Email to School Admin</h2>
						</div>
					</div>
					<div class="col-md-6 " align="center">
					    <div class="form-group">
							  <label for="type" class ="control-label col-sm-3">Message Id</label>
							<div class="col-sm-8" id="typeedit">
							  <select class="form-control"  name="type" id="type">

								<?php while($row= mysql_fetch_array($res)){ 
									if($row['type']=='welcomeschooladmin')
									{ ?>
										
									<option value="<?php echo $row['id']; ?>" selected="selected"><?php echo $row['type'];?></option>
								<?php } ?>

								     <option value="<?php echo $row['id']; ?>"><?php echo $row['type']; ?></option>
								<?php } ?> 
							  </select>
							 
							</div>
					   </div>
			     </div>
			
				<?php  
$sql = "SELECT COUNT(id) FROM tbl_school_admin";  
$rs_result = mysql_query($sql);  
$row1 = mysql_fetch_row($rs_result);  
$total_records = $row1[0];  
$total_pages = ceil($total_records / $limit);  
if($total_pages == $_GET['page']){
$limit = $total_records;
}else{
$limit = $start_from + $limit;
}
$pagLink = "<div class='pagination'>"; 
for ($i=1; $i<=$total_pages; $i++) { 
	$mypage = !empty($_GET['page'])?$_GET['page']:1;
	if($i == $mypage){
		$class = 'active';
		$selected = "selected";
		$pagLink .= "<option value='Send_Mail_School_admin.php?page=".$i."'".$selected." >  ".$i.''." </option> ";
	}else
		$class = '';
           // $pagLink .= " <option value='index.php?page=".$i."'".$selected." ><a class='$class' href='index.php?page=".$i."'>".$i.''." </a></option> "; 
		   //$pagLink .="
		   $pagLink .= "<option value='Send_Mail_School_admin.php?page=".$i."'>  ".$i.''." </option> "; 	   
};
echo "<div class='pagination'>";
echo "<p style='margin-right: 955px;
    margin-bottom: 21px;'><font color='blue'><b>Go to page number</font></p>";
echo "<form style='margin-left: 155px;' ><select onchange='location = this.value;' style='margin-right: 600px;
    margin-top: -41px;'>";
echo $pagLink . "</div>";
echo "</select></form></div>"; 
echo "<div id='record' style='margin-top: -62px;
    margin-left: 700px;color:blue'>Now showing ".($start_from +1)." to ".($limit)." records out of ".$total_records. " records.</div></b>";
?>
	<form>
<div style="margin-left: 700px;margin-top: 10px;">
	<input type="text" name="Search" placeholder="Search..">
	<input type="submit" value="Search">
</div>
</form>
<?php
		if (isset($_GET['Search']))
		{
			$searchq=$_GET['Search'];
			//$searchq=preg_replace("#[^0-9a-zA-Z]#i","",$searchq);
		
			$query1=mysql_query("SELECT name, school_id,school_name, email, mobile, email_status, send_sms_status, sms_time_log, email_time_log, scadmin_country 
			FROM tbl_school_admin
			WHERE name LIKE '%$searchq%' or 
			school_id LIKE '%$searchq%' or 
			school_name LIKE '%$searchq%' or 
			email LIKE '%$searchq%' or 
			mobile LIKE '%$searchq%'") or die("could not Search!");
			$count=mysql_num_rows($query1);
			if($count == 0){
				echo "<center>There Was No Search Result</center>";
			}
			else
			{
				?>
				<div class="row" style="padding:10px;">
						<div class="col-md-12  " id="no-more-tables">
							<?php $i = 0; ?>
							<table class="table-bordered  table-condensed cf" style="border: 1px solid #ccc;" id="example" width="100%;">
								<thead>
								<tr style="background-color:#428BCA">
									<th style="width:10%;"><b>Sr.No</b></th>
									<th style="width:20%;"><b>Admin Name</b></th>
									<th style="width:20%;">School Name.</th>
									<th style="width:20%;">Email ID</th>
									<th style="width:20%;">Mobile</th>
									<th style="width:10%;">EMAIL Status</th>
									<th style="width:10%;">SMS Status</th>
									<th style="width:10%;">TimeStamp(SMS/Email)</th>
									<th style="width:20%;">Send Email</th>
									</th>
								</tr>
								</thead>
								<tbody>
								<!--php
								$i = 1;
								$arr = mysql_query("select name, school_id,school_name, email, mobile, email_status, send_sms_status, sms_time_log, email_time_log, scadmin_country from tbl_school_admin order by id "); -->
								<?php $J = 1;
								while ($row = mysql_fetch_array($query1)) {
									$teacher_id = $row['id'];
									?>
									<tr style="color:#808080;" class="active">
										<td data-title="Sr.No" style="width:4%;"><b><?php echo $J; ?></b></td>
										<td data-title="Teacher ID" style="width:6%;"><b><?php echo ucwords($row['name']); ?></b></td>
										<td data-title="Name" style="width:12%;"><?php echo ucwords($row['school_name']);?></td>
										<td data-title="Phone" style="width:8%;"><?php echo $row['email']; ?> </td>
										<td data-title="Phone" style="width:6%;"><?php echo $row['mobile']; ?> </td>
										<td data-title="Phone" style="width:5%;"><?php
											if ($row['email_status'] == 'Send_Email') {
												echo 'Email sent';
											} elseif ($row['email_status'] == 'Unsend') {
												echo 'Unsent';
											}
											?> </td>
										<td data-title="Send/Unsen Status" style="width:5%;"><?php
											if ($row['send_sms_status'] == 'Send_SMS') {
											echo 'SMS sent';
											} elseif ($row['send_sms_status'] == 'Unsend') {
											echo 'Unsent';
											}
											?> </td>
										<td><?php echo "SMS :".$row['sms_time_log']."<br>Email :".$row['email_time_log'];?></td>
										<td data-title="Phone" style="width:10%;">
											<a onclick="confirmSMS( '<?php echo $row['mobile']; ?>','<?php echo $row['school_id']; ?>','<?php echo $row['send_sms_status'];?>','<?php echo $row['scadmin_country']; ?>');"><img src="Images/S.png"></a>
											<a onclick="confirmEmail('<?php echo $row['email_status'];?>','<?php echo $row['school_id']; ?>','<?php echo $row['email']; ?>','<?php echo $row['name']; ?>');" ><img src="Images/E.png"></a>
										</td>
									</tr>
									 <?php $J++;
										} ?>
								</tbody>
							</table>
						</div>
					</div>
					
					<div class="row" style="padding:5px;">
						<div class="col-md-4">
						</div>
						<div class="col-md-3 " align="center">
							</form>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
						</div>
						<div class="col-md-3" style="color:#FF0000;" align="center">
							<?php echo $report; ?>
						</div>
					</div>
				
			<?php
			}
		}
		else
		{			
	?>
	<div class="row" style="padding:10px;">
						<div class="col-md-12  " id="no-more-tables">
							<?php $i = 0; ?>
							<table class="table-bordered  table-condensed cf" style="border: 1px solid #ccc;" id="example" width="100%;">
								<thead>
								<tr style="background-color:#428BCA">
									<th style="width:10%;"><b>Sr.No</b></th>
									<th style="width:20%;"><b>Admin Name</b></th>
									<th style="width:20%;">School Name.</th>
									<th style="width:20%;">Email ID</th>
									<th style="width:20%;">Mobile</th>
									<th style="width:10%;">EMAIL Status</th>
									<th style="width:10%;">SMS Status</th>
									<th style="width:10%;">TimeStamp(SMS/Email)</th>
									<th style="width:20%;">Send Email</th>
									</th>
								</tr>
								</thead>
								<tbody>
								<!--php
								$i = 1;
								$arr = mysql_query("select name, school_id,school_name, email, mobile, email_status, send_sms_status, sms_time_log, email_time_log, scadmin_country from tbl_school_admin order by id "); -->
								<?php $J = ($start_from +1);
								while ($row = mysql_fetch_array($arr)) {
									$teacher_id = $row['id'];
									?>
									<tr style="color:#808080;" class="active">
										<td data-title="Sr.No" style="width:4%;"><b><?php echo $J; ?></b></td>
										<td data-title="Teacher ID" style="width:6%;"><b><?php echo ucwords($row['name']); ?></b></td>
										<td data-title="Name" style="width:12%;"><?php echo ucwords($row['school_name']);?></td>
										<td data-title="Phone" style="width:8%;"><?php echo $row['email']; ?> </td>
										<td data-title="Phone" style="width:6%;"><?php echo $row['mobile']; ?> </td>
										<td data-title="Phone" style="width:5%;"><?php
											if ($row['email_status'] == 'Send_Email') {
												echo 'Email sent';
											} elseif ($row['email_status'] == 'Unsend') {
												echo 'Unsent';
											}
											?> </td>
										<td data-title="Send/Unsen Status" style="width:5%;"><?php
											if ($row['send_sms_status'] == 'Send_SMS') {
											echo 'SMS sent';
											} elseif ($row['send_sms_status'] == 'Unsend') {
											echo 'Unsent';
											}
											?> </td>
										<td><?php echo "SMS :".$row['sms_time_log']."<br>Email :".$row['email_time_log'];?></td>
										<td data-title="Phone" style="width:10%;">
											<a onclick="confirmSMS( '<?php echo $row['mobile']; ?>','<?php echo $row['school_id']; ?>','<?php echo $row['send_sms_status'];?>','<?php echo $row['scadmin_country']; ?>');"><img src="Images/S.png"></a>
											<a onclick="confirmEmail('<?php echo $row['email_status'];?>','<?php echo $row['school_id']; ?>','<?php echo $row['email']; ?>','<?php echo $row['name']; ?>');" ><img src="Images/E.png"></a>
										</td>
									</tr>
									 <?php $J++;
										} ?>
								</tbody>
							</table>
						</div>
					</div>
					
					<div class="row" style="padding:5px;">
						<div class="col-md-4">
						</div>
						<div class="col-md-3 " align="center">
							</form>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
						</div>
						<div class="col-md-3" style="color:#FF0000;" align="center">
							<?php echo $report; ?>
						</div>
					</div>
					
		<?php
		}
		?>
			 </div>	
			</div>
			</div>
			</div>
	</body>
</html>
<script>
$(document).ready(function() {
$('#example_info').hide();
$('#example_paginate').hide();
//$("select[name='example_length']").hide();
});
</script>