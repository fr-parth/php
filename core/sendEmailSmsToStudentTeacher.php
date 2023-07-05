<?php
$site = $GLOBALS['URLNAME'];
include("scadmin_header.php");
$school_id = $_SESSION['school_id'];
$res = mysql_query("select id,type,subject,email_body,sms_body,email_marathi,sms_marathi from tbl_email_sms_templates");
 
?>
<html>
<body>
	<div class="container" style="max-width:auto;padding:40px 20px;background:#ebeff2">
		<center><h2>Send Email/SMS To Students </h2></center><br>
		
		<form class="form-horizontal" role="form" method="POST" action="">
				
				<div class="form-group">
				 <label for="subject" class ="control-label col-sm-3">Language</label>
				 <div class="col-sm-8">
					<label class="radio-inline">
					  <input type="radio" name="language" value="english" id="langEng" checked>English
					</label>
					<label class="radio-inline">
					  <input type="radio" name="language" value="marathi" id="langMar">Marathi
					</label>
					</div>
				</div>

				<div class="form-group">
				  <label for="subject" class ="control-label col-sm-3">Email/SMS:</label>
				<div class="col-sm-8">
				 <select class="form-control" name="email_sms" id="email_sms" required>
					<option value="">Select Email/SMS</option>
					<option value="email">Email</option>
					<option value="sms">SMS</option>

				  </select>
				</div>
				</div>

			   <div class="form-group">
					<label for="type" class ="control-label col-sm-3">Message Id:</label>
					<div class="col-sm-8" id="typeedit">
					  <select class="form-control" name="msgid" id="msgid" required>
							<option value="">Select Id</option>
							<?php while($row= mysql_fetch_array($res)){ ?>
							<option value="<?php echo $row['id']; ?>"><?php echo $row['type']; ?></option>
							<?php } ?>
						  </select>
					</div>
				</div>

				<div class="form-group">
					<label for="type" class ="control-label col-sm-3">Target Entity:</label>
					<div class="col-sm-8" id="entity">
						<select class="form-control" name="entity" id="entity">
							<option value="">Select Entity</option>
							<!-- <option value="groupAdmin">Group Admin</option>
							<option value="school">School Admin</option> -->
							<option value="students">Students</option>
							<option value="teachers">Teachers</option>
							<option value="parents">Parents</option>
							<!-- <option value="sponsors">Sponsors</option> -->
						</select>
					</div>
				</div>

				<!-- <div class="form-group">
					<label for="type" class ="control-label col-sm-3">Select School:</label>
					<div class="col-sm-8" id="batchId">
					  <select class="form-control" name="batchId" id="batchId">
							<option value="">Select Batch ID</option>
							<option value="all">All</option>
							<?php
							//$school = mysql_query("select school_id,school_name from tbl_school_admin where school_name IS NOT NULL OR school_name !='' order by school_name");
							while($schools= mysql_fetch_array($school)){ ?>
							<option value="<?php echo $schools['school_id']; ?>"><?php echo $schools['school_name']; ?></option>
							<?php } ?>
						  </select>
					</div>
				</div> -->

				<div class="form-group">
					<label for="type" class ="control-label col-sm-3">Select Department:</label>
					<div class="col-sm-8" id="Department">
					  <select class="form-control" name="department" id="department">
							<option value="">Select Department</option>
							<option value="all">All</option>
							<?php
							$department = mysql_query("select Dept_Name from tbl_department_master where school_id='$school_id' AND Is_Enabled=1 order by Dept_Name");
							while($deptres= mysql_fetch_array($department)){ ?>
							<option value="<?php echo $deptres['Dept_Name']; ?>"><?php echo $deptres['Dept_Name']; ?></option>
							<?php } ?>
						  </select>
					</div>
				</div>
			
		   <div class="col-sm-offset-2 col-sm-8" id="editbutton">
			 <button type="submit" name="submit" class="btn btn-default" style="background-color: #428BCA; color: white;"><b>Send</b></button>
			 <button id="preview" class="btn btn-default" style="background-color: #428BCA;margin-left: 15%; color: white;"><b>Preview</b></button>
		   </div>
		</form>
	</div>
</body>
</html> 
<?php 
if(isset($_POST['submit']))
{
	mysql_set_charset('utf8');
	$language = addslashes($_POST['language']);
	$email_sms = addslashes($_POST['email_sms']);
	$msgid = addslashes($_POST['msgid']);
	$department = addslashes($_POST['department']);
	$getEmailSms = mysql_query("select id,type,email_body,sms_body,email_marathi,sms_marathi from tbl_email_sms_templates where id = '$msgid'");
	$EmailSmsres = mysql_fetch_array($getEmailSms);
	$sms = ($language == 'marathi') ? $EmailSmsres['sms_marathi'] : $EmailSmsres['sms_body'];
	$Text = urlencode($sms);
	$emailMsg = ($language == 'marathi') ? $EmailSmsres['email_marathi'] : $EmailSmsres['email_body']; 

	if($batchId && $batchId !='all')
	{
		$where = "batch_id=".$batch_id." and school_id=".$school_id;
	}
	else
	{
		$where = "school_id=".$school_id;
	}
	
	$getdetails = mysql_query("select std_PRN,std_name,std_complete_name,std_password,std_email,std_phone,std_password,std_school_name,email_status from `tbl_student` where school_id='$school_id'"); 
	
	/*Below query added by Rutuja for fetching dynamic values for user,password & sender for SMC-4989 on 02-12-2020*/
                        $sql_dynamic= mysql_query("select * from tbl_otp where id=1");
                        $dynamic_fetch= mysql_fetch_array($sql_dynamic);
                        $dynamic_user = $dynamic_fetch['mobileno'];
                        $dynamic_pass = $dynamic_fetch['email'];
                        $dynamic_sender = $dynamic_fetch['otp'];
                        
	if($email_sms == 'sms')
	{
		while($getdetails = mysql_fetch_array($getdetails))
		{
			$phone = $getdetails['std_phone'];
			$url="http://www.smswave.in/panel/sendsms.php?user=$dynamic_user&password=$dynamic_pass&sender=$dynamic_sender&PhoneNumber=$phone&Text=$Text";
			$response = file_get_contents($url); 
		}
		echo "<script>alert('SMS sent successfully!!')</script>";

	}
	else if($email_sms == 'email')
	{
		while($getdetails = mysql_fetch_array($getdetails))
		{
			$email = $getdetails['std_email'];
			$password = $getdetails['std_password'];
			$std_complete_name = $getdetails['std_complete_name'];
			$school_name = $getdetails['std_school_name'];
			$url = SEND_MAIL_PATH; //defined in securityfunctions.php
			$myvars = 'email=' . $email . '&msgid=' . $msgid. '&site=' . $site. '&pass=' . $password. '&studentname=' . $std_complete_name. '&school_id=' . $school_id. '&school_name=' . $school_name;

			$res = post_function($url,$myvars); //function defined in securityfunctions.php
		}
		echo "<script>alert('Email sent successfully!!')</script>";

	}

	
	
}

	
?>

<script>
$(document).ready(function() {
var base_url = "<?php echo $GLOBALS['URLNAME'];?>";

	$('#preview').click(function(e) {
		e.preventDefault();
			var base_url = "<?php echo $GLOBALS['URLNAME'];?>";
			var value = $('#msgid').val();
			var email_sms = $('#email_sms').val();
			//var value = '8';

			$.ajax({
					type: "POST",
					url: base_url + '/core/EmailSmsTemplate_ajax.php',
					data: { id : value,},
					dataType: "json",
					cache:false,
					success: function(data) {
						if(email_sms == 'sms')
						{
							if($('#langMar').is(':checked')) 
							{
								$("#getCode").html(data["sms_marathi"]);
							}
							else
							{
								$("#getCode").html(data["sms_body"]);
							}
						}
						else
						{
							if($('#langMar').is(':checked')) 
							{
								$("#getCode").html(data["email_marathi"]);
							}
							else
							{
								$("#getCode").html(data["email_body"]);
							}
						}

						$("#getCodeModal").modal('show');
						$("#myModalLabel").html("Subject : " + data["subject"]);
						
						}		
				});
		})		
})
</script>

<div class="modal fade" id="getCodeModal" tabindex="0" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
       <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		 <h2 class="modal-title" align='center'>Email/SMS Message Preview</h2>
         <h4 class="modal-title" id="myModalLabel"> </h4>
       </div>
       <div class="modal-body" id="getCode" style="overflow-x: scroll;">
          //ajax success content here.
       </div>
    </div>
   </div>
 </div>
<style>
.modal fade {
  text-align: center;
}

@media screen and (min-width: 768px) { 
  .modal fade:before {
    display: inline-block;
    vertical-align: middle;
    content: " ";
    height: 100%;
  }
}

.modal-dialog {
  display: inline-block;
  text-align: left;
  vertical-align: middle;
  margin-left: 15%;
  width: 70%;
}
</style>