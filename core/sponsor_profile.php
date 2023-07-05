<?php 
include("sponsor_header.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style>
.pad-top{
	padding-top:5px;	
}
</style>

</head>

<body>

<script>
$(document).ready(function(){
	$("#phone_edit").hide();
	$("#email_edit").hide();
	$("#email_otp").hide();
	$("#phone_otp").hide();
	$("#p").click(function(){
        $("#phone_edit").toggle();
		
});

    $("#e").click(function(){
        $("#email_edit").toggle();		
		
    });
	
	$("#up_phone").click(function(){
        $("#phone_otp").toggle();		
		
    });
	
		$("#up_email").click(function(){
        $("#email_otp").toggle();		
		
    });
	
	$("#otp_phone").click(function(){        	
		$("#phone_otp").hide();
		$("#phone_edit").hide();
    });

	$("#otp_email").click(function(){        	
		$("#email_otp").hide();
		$("#email_edit").hide();
    });
	
});


</script>
<script>
$(document).ready(function(){
	$("#up_phone").click(function(){
		var phone= document.getElementById('phone').value;
		var cc= document.getElementById('cc').value;
		var spid=<?php echo $id; ?>;
		$.ajax({
		type: "POST",
		url: "send_otp.php",
		data:'ph='+phone+'&cc='+cc+'&sp='+spid,		
		beforeSend: function(){
			$("#phone").css("background","#FFF url(images/LoaderIcon.gif) no-repeat 165px");
		},
		success: function(data){
			$("#otp-message").html(data);
		}
		});
	});
});

</script>
<script>
$(document).ready(function(){
	$("#up_email").click(function(){
		var email= document.getElementById('email').value;
		var cc= document.getElementById('cc').value;
		var spid=<?php echo $id; ?>;
		$.ajax({
		type: "POST",
		url: "send_otp.php",
		data:'eml='+email+'&cc='+cc+'&sp='+spid,		
		beforeSend: function(){
			$("#email").css("background","#FFF url(images/LoaderIcon.gif) no-repeat 165px");
		},
		success: function(data){
			$("#otp-email").html(data);
		}
		});
	});
});

</script>
<script>
$(document).ready(function(){
	$("#otp_phone").click(function(){
		var sent_phone_otp= document.getElementById('sent_phone_otp').value;		
		var spid=<?php echo $id; ?>;
		$.ajax({
		type: "POST",
		url: "send_otp.php",
		data:'phoneotp='+sent_phone_otp+'&sp='+spid,		
		beforeSend: function(){
			$("#sent_phone_otp").css("background","#FFF url(images/LoaderIcon.gif) no-repeat 165px");
		},
		success: function(data){
			$("#otp-message").html(data);
		}
		});
	});
});

</script>
<script>
$(document).ready(function(){
	$("#otp_email").click(function(){
		var sent_email_otp= document.getElementById('sent_email_otp').value;		
		var spid=<?php echo $id; ?>;
		$.ajax({
		type: "POST",
		url: "send_otp.php",
		data:'emailotp='+sent_email_otp+'&sp='+spid,		
		beforeSend: function(){
			$("#sent_email_otp").css("background","#FFF url(images/LoaderIcon.gif) no-repeat 165px");
		},
		success: function(data){
			$("#otp-email-status").html(data);
		}
		});
	});
});

</script>
<div class="pad-top"></div>
<div class="container">
	<div class="panel panel-default">
		<div class="panel-heading">
		<h2 class="panel-title"><strong>Profile</strong></h2>
		</div>
		<div class="panel-body">
			<div class="col-md-12">
			
			<div class="col-md-5">
			
			<?php if(file_exists($sp_img_path)){ ?>
				<img src="<?php echo $sp_img_path;?>" style="height:120px; width:210.5px;" class="img-responsive pull-left" alt="Responsive image" >
                
                <?php }else{ ?> <img src="image/avatar_2x.png"  style="border:1px solid #CCCCCC;height:90px;" class="img-responsive" alt="Responsive image"/> <?php } ?>
				<div class="col-xs-6">
    <a href="edit_sponsorlogo.php" style="text-decoration:none;"><b>EditLogo</b></a>	
	</div>
			</div>
			<div class="col-md-7" style="padding-left:20px;">			
			<h3 class="text-capitalize">
				<?php echo $fname;?>
			</h3>			 	
			<?php echo $sp_company;?><br/>
			</div>
			
			</div>
		
		
			<table class="table table-hover">
			
			<tr>
				<td style="font-weight:bold;" >
					Phone
				</td>
				<td>
					<?php echo $phone; ?>
					&nbsp;<button class="btn btn-default btn-xs" name="p" id="p">Change</button>
					<div id="otp-message"></div><?php if($pv!='1'){ echo 'Not Verified'; } ?>
				</td>
			</tr>
			<tr id="phone_edit">
				<td style="font-weight:bold;">
					
				</td>
				<td>	
						
						<select required="" name="cc" id="cc" >
							<option value="91" selected="">+91</option>
							<option value="1">+1</option>							  
						</select>				
					<input type="text" name="phone" id="phone" class="form-control" 
					value="<?php if(isset($_POST['phone'])){echo $_POST['phone'];}else { echo $phone;}?>" onkeypress="return isNumberKey(event)">
					<div class="row text-danger" align="center" id='err_phone' ></div>					
					&nbsp;<button class="btn btn-warning btn-xs" name="up_phone" id="up_phone" onclick="" >Send OTP</button>
				</td>
			</tr>
			<tr id="phone_otp">
				<td style="font-weight:bold;">
					
				</td>
				<td><div id="otp-message"></div>
					<input type="text" name="sent_phone_otp" id="sent_phone_otp" class="form-control" value="" >
					&nbsp;<button class="btn btn-success btn-xs" name="otp_phone" id="otp_phone">Update</button>
				</td>
			</tr>
			<tr>
				<td style="font-weight:bold;">
					Email
				</td>
				<td>
					<?php echo $email; ?>
					&nbsp;<button class="btn btn-default btn-xs" name="e" id="e">Change</button>
					<div id="otp-email-status"></div><?php if($ev!='1'){ echo 'Not Verified'; } ?>
				</td>
			</tr>
			<tr id="email_edit">
				<td style="font-weight:bold;">
					
				</td>
				<td>
					<input type="email" name="email" id="email" class="form-control" 
					value="<?php if(isset($_POST['email'])){echo $_POST['email'];}else { echo $email;}?>" >
					<div class="row text-danger" align="center" id='err_email' ></div>
					&nbsp;<button class="btn btn-warning btn-xs" name="up_email" id="up_email">Send OTP</button>
				</td>
			</tr>
			<tr id="email_otp">
				<td style="font-weight:bold;">
					
				</td>
				<td><div id="otp-email-status"></div>
					<input type="text" name="sent_email_otp" id="sent_email_otp" class="form-control" value="" >
					&nbsp;<button class="btn btn-success btn-xs" name="otp_email" id="otp_email">Update</button>
				</td>
			</tr>
	<tr>
				<td style="font-weight:bold;">
					Website
				</td>
				<td>
					<a href="http://<?php echo $sp_website;?>" target="_blank"><?php echo $sp_website;?></a>
				</td>
			</tr>
			<tr>
				<td style="font-weight:bold;">
					Date of Birth
				</td>
				<td>
					<?php echo $sp_dob; ?>
				</td>
			</tr>
			<tr>
				<td style="font-weight:bold;">
					Gender
				</td>
				<td class="text-capitalize">
					<?php echo $sp_gender; ?>
				</td>
			</tr>
			<tr>
				<td style="font-weight:bold;">
					Occupation
				</td>
				<td class="text-capitalize">
					<?php echo $sp_occupation; ?>
				</td>
			</tr>
			<tr>
				<td style="font-weight:bold;">
					Default Product Category
				</td>
				<td class="text-capitalize">
					<?php echo $v_category; ?>
				</td>
			</tr>
			<tr>
				<td style="font-weight:bold;">
					Address
				</td>
				<td class="text-capitalize">
					<?php echo $address; ?>
				</td>
			</tr>
			<tr>
				<td style="font-weight:bold;">
					City
				</td>
				<td class="text-capitalize">
					<?php echo $city; ?>
				</td>
			</tr>
			<tr>
				<td style="font-weight:bold;">
					State
				</td>
				<td class="text-capitalize">
					<?php echo $state; ?>
				</td>
			</tr>
			<tr>
				<td style="font-weight:bold;">
					Country
				</td>
				<td class="text-capitalize">
					<?php echo $country; ?>
				</td>
			</tr>
			<tr>
				<td style="font-weight:bold;">
					ZIP / PIN
				</td>
				<td class="text-capitalize">
					<?php echo $pin; ?>
				</td>
			</tr>
			<tr>
				<td style="font-weight:bold;">
					Registration Date
				</td>
				<td class="text-capitalize" >
					<?php echo $reg_date; ?>
				</td>
			</tr>
			<tr>
				<td style="font-weight:bold;">
					Password
				</td>
				<td class="text-capitalize">
<a href="change_sponsor_password.php?id=<?php echo $id;?>"><button class="btn btn-default btn-xs" name="cp" id="cp">Change Password</button></a>
				</td>
			</tr>
			
			</table>
<a href="edit_sponsor_profile.php?id=<?php echo $id;?>" >
<input type="submit" value="Edit" name="submit" class="btn btn-success" ></a>
<a href="coupon_accept.php" ><input type="button" value="Back" name="cancel" class="btn btn-warning"></a>
		</div>
	</div>
</div>


</body>
</html>
