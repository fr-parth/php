<?php
include("cookieadminheader.php");
$res = mysql_query("select id,type,email_body from tbl_email_sms_templates");
?>
<html>
<head>
	<!-- <script src="https://cdn.ckeditor.com/4.11.1/standard/ckeditor.js"></script> -->
	<script src="../Assets/vendors/ckeditor/ckeditor.js"></script>
</head>
<body>
	<div class="container" style="max-width:auto;padding:40px 20px;background:#ebeff2">
		<center><h2>Add/Edit Email Template</h2></center><br>
		<div class="col-sm-offset-2 col-sm-8">
			 <button name="submit" id="toadd" class="btn btn-default" style="background-color: #694489;margin-left: -21%; margin-top: -10%;color: white;"><b>Add New</b></button>
			 
		   </div>
		<form class="form-horizontal" role="form" method="POST" action="">
			<div class="form-group">
			  <label for="type" class ="control-label col-sm-3">Message Id</label>
			<div class="col-sm-8" id="typeedit">
			  <select class="form-control"  name="type" id="type">
				<option value="select">Select Type</option>
				<?php while($row= mysql_fetch_array($res)){ ?>
				<option value="<?php echo $row['id']; ?>"><?php echo $row['type']; ?></option>
				<?php } ?> 
			  </select>
			  
			  <script>
			  //script added by Sayali Balkawade for SMC-4586 on 30/03/2020
			  window.onload = function() {
    var selItem = sessionStorage.getItem("SelItem");
    var selItem1 = sessionStorage.getItem("SelItem");
	
    $('#type').val(selItem);
    }
    $('#type').change(function() { 
        var selVal = $(this).val();
        sessionStorage.setItem("SelItem", selVal);
    });
			  </script>
			</div>
		
			<div class="col-sm-8" id="typeadd" style="display:none">
			  <input type="text" class="form-control" name="type1" id="type1" autocomplete="off" />
			</div>
			</div>
			
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

			<!-- <div class="form-group">
			  <label for="subject" class ="control-label col-sm-3">Field:</label>
			<div class="col-sm-8">
			  <select class="form-control"  name="fields" id="fields">
				<option value="">Select Field</option>
				<option value="{email}">Email</option>
				<option value="{pass}">Password</option>
				<option value="{school}">College Name</option>
				<option value="{logo}">College Logo</option>
				<option value="{coordinator_name}">Coordinator Name</option>
				<option value="{Name}">Name</option>
				<option value="{group_name}">Group Name</option>
				<option value="{stud_complete_name}">Student Complete Name</option>
				<option value="{t_complete_name}">Teacher Complete Name</option>
				<option value="{status}">Status</option>
				<option value="{member_id}">Member ID</option>
				<option value="{school_id}">School Id</option>
				<option value="{PRN}">Student PRN</option>
				<option value="{std_phone}">Student Phone</option>
				<option value="{t_id}">teacher ID</option>
				<option value="{t_phone}">Teacher Phone</option>
				<option value="{phone}">Phone</option>
				<option value="{stud_first_name}">Student First Name</option>
				<option value="{teach_first_name}">Teacher First Name</option>
				<option value="{site}">Site Name</option>
				<option value="{user_type}">User Type</option>
				<option value="{link}">link</option>
				<option value="{pass_admin}">pass_admin</option>
				<option value="{pass_staff}">pass_staff</option>
			  </select>
			</div>
			</div> -->

			<div class="form-group">
			  <label for="subject" class ="control-label col-sm-3">Subject:</label>
			<div class="col-sm-8">
			 <!--Value added by Sayali Balkawade for SMC-4586 on 30/03/2020-->
			  <input type="text" class="form-control" value='<?php if(isset($_POST['subject'])){echo $_POST['subject'];}?>' name="subject" id="subject" />
			</div>
			</div>

			<div class="form-group">
			  <label for="email" class ="control-label col-sm-3">Email Body:</label>
			<div class="col-sm-8">
						 <!--if condition added by Sayali Balkawade for SMC-4586 on 30/03/2020-->
			<textarea class="form-control"  name="email_body" id="email_body" ><?php if(isset($_POST['email_body'])) { 
         echo htmlentities ($_POST['email_body']); }?> </textarea>
			</div>
			</div>
		
			<div class="form-group">
			  <label for="SMS" class ="control-label col-sm-3">SMS Body:</label>
			<div class="col-sm-8">
			  <textarea class="form-control" name="sms_body" id="sms_body" > </textarea>
			</div>
			</div>
		  
		   <div class="col-sm-offset-2 col-sm-8" id="editbutton">
			 <button type="submit" name="submit" class="btn btn-default">Submit</button>
		   </div>
		   <div class="col-sm-offset-2 col-sm-8" id="addbutton" style="display:none">
			 <button type="submit" name="save" class="btn btn-default">Submit</button>
			 <button value="Refresh Page" onClick="history.go(0)" style="background-color: #f44336;margin-left: 15%; margin-top: -10%;color: white;">Cancel</button>
		   </div>
		</form>
	</div>
</body>
</html> 
<?php 
if(isset($_POST['submit']))
{
	$id = addslashes($_POST['type']);
	$subject = addslashes($_POST['subject']);
	$email_body = addslashes($_POST['email_body']);
	$sms_body = addslashes($_POST['sms_body']);
	$language = addslashes($_POST['language']);

	if(empty($id))
	{
		echo "<script>alert('Please select type!!')</script>";
	}
	else if(empty($subject))
	{
		echo "<script>alert('Please enter subject!!')</script>";
	}
	else if(empty($email_body))
	{
		echo "<script>alert('Please enter email body!!')</script>";
	}
	else if(empty($sms_body))
	{
		echo "<script>alert('Please enter sms body!!')</script>";
	}
	else
	{
		mysql_set_charset('utf8');
		if($language == 'marathi')
		{
			$myquery = mysql_query("update tbl_email_sms_templates set subject=\"$subject\",email_marathi=\"$email_body\",sms_marathi=\"$sms_body\",modified_on=NOW() where id='$id'");
		}
		else
		{
			$myquery = mysql_query("update tbl_email_sms_templates set subject=\"$subject\",email_body=\"$email_body\",sms_body=\"$sms_body\",modified_on=NOW() where id='$id'");
		}

		if($myquery)
		{
			echo "<script>alert('Details updated successfully!!')</script>";
		}
		else 
		{
			echo "<script>alert('Details could not be updated, please try again!!')</script>";
		}
	}
	
}
else if(isset($_POST['save']))
{
	$type = addslashes($_POST['type1']);
	$subject = addslashes($_POST['subject']);
	$email_body = addslashes($_POST['email_body']);
	$sms_body = addslashes($_POST['sms_body']);
	$language = addslashes($_POST['language']);

	if(empty($type))
	{
		echo "<script>alert('Please enter type!!')</script>";
	}
	else if(empty($subject))
	{
		echo "<script>alert('Please enter subject!!')</script>";
	}
	else if(empty($email_body))
	{
		echo "<script>alert('Please enter email body!!')</script>";
	}
	else if(empty($sms_body))
	{
		echo "<script>alert('Please enter sms body!!')</script>";
	}
	else
	{
		//get related data from table
		$res = mysql_query("select id from tbl_email_sms_templates where type ='$type'");
		$count = mysql_num_rows($res);
		if($count < 1)
		{
			if($language == 'marathi')
			{
				$columns = "type,subject,email_marathi,sms_marathi,created_on";
			}
			else
			{
				$columns = "type,subject,email_body,sms_body,created_on";
			}
			mysql_set_charset('utf8');
			$myquery = mysql_query("INSERT INTO tbl_email_sms_templates ($columns) VALUES (\"$type\",\"$subject\",\"$email_body\",\"$sms_body\",NOW())");
			if($myquery)
			{
				echo "<script>alert('Details added successfully!!')</script><meta http-equiv='refresh' content='0';>";
			}
			else 
			{
				echo "<script>alert('Details could not be added, please try again!!')</script>";
			}
		}
		else 
		{
			echo "<script>alert('The email type is already added, please try with different type!!')</script>";
		} 
	}
	
}
	
?>

<script>
$(document).ready(function() {	
CKEDITOR.replace('email_body');
var base_url = "<?php echo $GLOBALS['URLNAME'];?>";
	$('#toadd').click(function() {
		$('#typeadd').show();
		$('#typeedit').hide();
		$('#editbutton').hide();
		$('#addbutton').show();
		$('#subject').val("");
		CKEDITOR.instances['email_body'].setData("")
		$('#sms_body').val("");
	});
	$('#type').change(function() {
			var value = $(this).val();

			$.ajax({
					type: "POST",
					url: base_url + '/core/EmailSmsTemplate_ajax.php',
					data: { id : value,},
					dataType: "json",
					cache:false,
					success: function(data) {
							if($('#langMar').is(':checked')) 
							{
								$('#subject').val(data["subject"]);
								$('#sms_body').val(data["sms_marathi"]);
								CKEDITOR.instances['email_body'].setData(data["email_marathi"]);
							}
							else
							{
								$('#subject').val(data["subject"]);
								$('#sms_body').val(data["sms_body"]);
								CKEDITOR.instances['email_body'].setData(data["email_body"]);
							}
						}		
				});
		})

			$('#langMar').click(function() {
				var value = $('#type').val();

			$.ajax({
					type: "POST",
					url: base_url + '/core/EmailSmsTemplate_ajax.php',
					data: { id : value,},
					dataType: "json",
					cache:false,
					success: function(data) {
								$('#subject').val(data["subject"]);
								$('#sms_body').val(data["sms_marathi"]);
								CKEDITOR.instances['email_body'].setData(data["email_marathi"]);
					}
				});
			})

			$('#langEng').click(function() {
			var value = $('#type').val();

			$.ajax({
					type: "POST",
					url: base_url + '/core/EmailSmsTemplate_ajax.php',
					data: { id : value,},
					dataType: "json",
					cache:false,
					success: function(data) {
								$('#subject').val(data["subject"]);
								$('#sms_body').val(data["sms_body"]);
								CKEDITOR.instances['email_body'].setData(data["email_body"]);
					}
				});
			})
		
})
</script>