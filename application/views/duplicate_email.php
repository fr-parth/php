<!DOCTYPE html>
<?php
//Below variables added for Protsahan-Bharati by Rutuja Jori on 19/07/2019
 $webHost = $_SESSION['webHost'];
 $isSmartCookie=$_SESSION['isSmartCookie'];
?>
<html>
<head>
	<meta charset="utf-8">
	<title>Login</title>
	<link href="<?php echo base_url();?>Assets/vendors/bootstrap/css/bootstrap.css" rel="stylesheet">
	<script src="<?php echo base_url();?>Assets/js/jquery-1.11.1.min.js"></script>
	<script src="<?php echo base_url();?>Assets/vendors/bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
<style>
body{
	background-color:#cdcdcd;
}
.padtop100{
	padding-top:100px;
}
.padtop10{
	padding-top:10px;	
}
.bg-red{
	background-color:#F0483E;
}
.red{
	color:#f00;
}
.color-white{
	color:white;
}
.panel{
	border-radius:10px;	
	box-shadow: 10px 10px 5px #888888;
}
.title-text{
	padding-top:10px;
	padding-bottom:10px;	
}
.form-content{
	padding-top:10px;
}
.no-top-padding{
	padding-top:0px;
}
th, td {
  padding: 3px;
}
</style>
<script>
$(document).ready(function(){
	//EmailInput
	//NumberInput
	//OrganisationInput
	//PhoneInput
	//SocialLogin
	//PasswordInput
	//SubmitInput
	//ForgotPassord

	
		var user='<?php echo @$entity; ?>';

	$("#OptEmailID").hide();
	$("#OptEmployeeID").hide();
	$("#OptPhoneNumber").hide();
	
	switch(user){
		case 'student':
	$("#OptEmailID").show();
	$("#OptEmployeeID").show();
	$("#OptPhoneNumber").show();		
			break;
	case 'teacher':
	$("#OptEmailID").show();
	$("#OptEmployeeID").show();
	$("#OptPhoneNumber").show();		
	break;
	case 'manager':
	$("#OptEmailID").show();
	$("#OptEmployeeID").show();
	$("#OptPhoneNumber").show();		
	break;
			case 'employee':
	$("#OptEmailID").show();
	$("#OptEmployeeID").show();
	$("#OptPhoneNumber").show();		
			break;		
		case 'sponsor':
	$("#OptEmailID").show();
	$("#OptEmployeeID").hide();
	$('select option[value=EmployeeID]').attr('disabled', 'disabled').hide();
	$("#OptPhoneNumber").show();			
			break;	
		case 'salesperson':
	$("#OptEmailID").show();
	$("#OptEmployeeID").hide();
	$("#OptPhoneNumber").show();			
			break;	
		
		default:
	$("#OptEmailID").hide();
	$("#OptEmployeeID").hide();
	$("#OptPhoneNumber").hide();
			break;
	}
	
 	$("#EmailInput").hide();
	$("#NumberInput").hide();
	$("#OrganisationInput").hide();
	$("#PhoneInput").hide();
	$("#SocialLogin").hide();
	
	$("#PasswordInput").hide();
	$("#SubmitInput").hide();
	$("#ForgotPassord").hide(); 
	

	
	function loginHideShow(LoginOption){
				switch(LoginOption){
			case 'SocialLogin':	
					$("#EmailInput").hide();
					$("#NumberInput").hide();
					$("#OrganisationInput").hide();
					$("#PhoneInput").hide();
					$("#SocialLogin").show();					
					$("#PasswordInput").hide();
					$("#SubmitInput").hide();
					$("#ForgotPassord").hide();		
					$("#MemberID").hide();
					$("#PasswordInput").removeClass("padtop10");
				break;
			case 'EmailID':	
					$("#EmailInput").show();
					$("#NumberInput").hide();
					
						var user='<?php echo @$entity; ?>';
						switch(user){
							case 'student':
						$("#OrganisationInput").show();
								break;
						case 'teacher':
							$("#OrganisationInput").show();
							break;
						case 'manager':
							$("#OrganisationInput").show();
							break;	
						case 'employee':
							$("#OrganisationInput").show();
							break;
						default:
						$("#OrganisationInput").hide();
								break;
						}	
					
					$("#PhoneInput").hide();
					$("#SocialLogin").hide();					
					$("#PasswordInput").show();
					$("#SubmitInput").show();
					$("#ForgotPassord").show();	
					$("#MemberID").hide();
					$("#PasswordInput").removeClass("padtop10");
				break;	
			case 'EmployeeID':	
					$("#EmailInput").hide();
					$("#NumberInput").show();
					$("#OrganisationInput").show();
					$("#PhoneInput").hide();
					$("#SocialLogin").hide();					
					$("#PasswordInput").show();
					$("#SubmitInput").show();
					$("#ForgotPassord").show();	
					$("#MemberID").hide();
					$("#PasswordInput").removeClass("padtop10");
				break;			
			case 'PhoneNumber':	
					$("#EmailInput").hide();
					$("#NumberInput").hide();
	/*Start changes */			
					//$("#OrganisationInput").hide();
						
					var user='<?php echo @$entity; ?>';
					switch(user){
					case 'student':
					$("#OrganisationInput").show();
					break;
					case 'teacher':
					$("#OrganisationInput").show();
					break;
					case 'manager':
					$("#OrganisationInput").show();
					break;
					case 'employee':
					$("#OrganisationInput").show();
					break;
					default:
					$("#OrganisationInput").hide();
					break;
					}
		/*End*/			
					$("#PhoneInput").show();
					$("#SocialLogin").hide();					
					$("#PasswordInput").show();
					$("#SubmitInput").show();
					$("#ForgotPassord").show();
					$("#MemberID").hide();
					$("#PasswordInput").addClass("padtop10");
						
				break;	
			case 'memberId':	
					$("#EmailInput").hide();
					$("#NumberInput").hide();
					$("#OrganisationInput").hide();
					$("#PhoneInput").hide();
					$("#SocialLogin").hide();					
					$("#PasswordInput").show();
					$("#SubmitInput").show();
					$("#ForgotPassord").show();
					$("#MemberID").show();
					
					$("#PasswordInput").addClass("padtop10");
						
				break;					
		}
	}
	
	var LoginOption=$("#LoginOption").val();
	loginHideShow(LoginOption);	
	
	$("#LoginOption").change(function(){
		var LoginOption=$("#LoginOption").val();
		loginHideShow(LoginOption);
	});	
	
		getLocation();
});
</script>
<script>
function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else {
        x.innerHTML = "Geolocation is not supported by this browser.";
    }
}
function showPosition(position) {
    $("#lat").val(position.coords.latitude);
    $("#lon").val(position.coords.longitude);
}

function resetReport()
{
	document.getElementById('Report').innerHTML="";
}
</script>
	<div class='container-fluid bgcolor'>
		<div class='row'>
			
			<div class='col-md-5 col-md-offset-4 padtop100'>
				<div class='panel panel-primary'>						
					<div class='panel-body'>										
						<div class='row text-center'>							
							<?php if($isSmartCookie) {  ?>						
							<div class="visible-sm visible-lg visible-md">
								<img src="<?php echo base_url();?>Assets/images/logo/250_86.png" />
							</div>
<?php  }else{   ?>
							
							<div class="visible-sm visible-lg visible-md">
								<img src="<?php echo base_url();?>Assets/images/logo/pblogoname.jpg" />
							</div>
<?php } ?>
							<div class="visible-xs">
								<img src="<?php echo base_url();?>Assets/images/logo/220_76.png" />
							</div>
						</div>
						<?php if($entity=="teacher" || $entity=="manager"){?>
						<div class='row bg-red text-center title-text'>
							<span class='panel-title color-white'><?php echo ucfirst(@$entity); ?> Duplicate Records</span>
						</div>
						<div class='row form-content' id='ct'>		
						<form method="post" >
						<div class="col-md-12">
							<table border="1px solid black;" width="80%" >
								<tbody>
									<tr style="text-align:center;">
										<th>Sr. No</th>
										<th>ID</th>
										<th>Organization Id</th>
										<th>Name</th>
										<th>Phone</th>
										<th>Email</th>
										<th>Action</th>
									</tr>
									<?php //print_r($entity);exit; 
									$i=1; foreach($all_value as $res){ //print_r($entity);exit; ?>
									<form method="post" >
									<tr style="text-align:center;">
										<td><?php echo $i;?></td>
										<td><?php echo $res['t_id'];?></td>
										<td><?php echo $res['school_id'];?></td>
										<td><?php echo $res['t_complete_name'];?></td>
										<td><?php echo $res['t_phone'];?></td>
										<td><?php echo $res['t_email'];?></td>
										<td><a href="<?php echo base_url();?>Clogin/login_duplicate/<?php echo $entity;?>/<?php echo $res['id'];?>" style="text-decoration:none;"> <input type="button"  class="btn btn-primary" name="btn_submit" value="Login"/></a></td>
										<!--<td><input type="submit" id="btn_submit" name="btn_submit" class="btn btn-success" value="Login" onclick="login_duplicate(<?php echo $entity; ?>)"></td>-->
									</tr>
									</form>
									<?php $i++;  } ?>
								</tbody>
							</table>
						</div>
						
						</form>
						</div>
						<?php } 
							if($entity=="student" || $entity=="employee"){?>
						<div class='row bg-red text-center title-text'>
						<span class='panel-title color-white'><?php echo ucfirst(@$entity); ?> Duplicate Records</span>
						</div>
						<div class='row form-content' id='ct'>		
						<form method="post" >
						<div class="col-md-12">
							<table border="1px solid black;" width="80%" >
								<tbody>
									<tr style="text-align:center;">
										<th>Sr. No</th>
										<th>School Id</th>
										<th>Name</th>
										<th>Phone</th>
										<th>Email</th>
										<th>Course Level</th>
										<th>Action</th>
									</tr>
									<?php  
									$i=1; foreach($all_value as $res){ //print_r($entity);exit; ?>
									<form method="post" >
									<tr style="text-align:center;">
										<td><?php echo $i;?></td>
										<td><?php echo $res['school_id'];?></td>
										<td><?php echo $res['std_complete_name'];?></td>
										<td><?php echo $res['std_phone'];?></td>
										<td><?php echo $res['std_email'];?></td>
										<td><?php echo $res['Course_level'];?></td>
										<td><a href="<?php echo base_url();?>Clogin/login_duplicate/<?php echo $entity;?>/<?php echo $res['id'];?>" style="text-decoration:none;"> <input type="button"  class="btn btn-primary" name="btn_submit" value="Login"/></a></td>
									</tr>
									</form>
									<?php $i++;  } ?>
								</tbody>
							</table>
						</div>
						
						</form>
						</div>
							
						<?php }
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--Script added by Sayali Balkawade for SMC-4866 on 07/10/2020 -->
	 <script type="text/javascript">
	 
	  
function valid() {  
 
 var email_id = document.getElementById("EmailID").value;
 var LoginOption = document.getElementById("LoginOption").value;
        var pattern = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
       if(LoginOption =="EmailID")
	   { 
		if(email_id.trim()=="" || email_id.trim()==null){

	   document.getElementById("erremail").innerHTML="Please Enter Email ID!";
        return false;
        }

       else if (!pattern.test(email_id)) {
           document.getElementById("erremail").innerHTML="Please Enter Valid Email ID!";
        return false;
        }
        else{
       document.getElementById("erremail").innerHTML='';
       
	   }
	   }
    if(LoginOption =="PhoneNumber")
	   {    
var phone_no = document.getElementById("PhoneNumber").value;
        var pattern = /^[6789]\d{9}$/;
        if(phone_no.trim()=="" || phone_no.trim()==null){

        document.getElementById("errphone").innerHTML="Please Enter Phone Number";

        return false;
        }
       else if (!pattern.test(phone_no)) {
            document.getElementById("errphone").innerHTML="Please Enter valid Phone Number";
        return false;
        }
        else{

         document.getElementById("errphone").innerHTML='';
 
        }
	   }
	    if(LoginOption =="memberId")
	   {  
var department_id = document.getElementById("MemberID").value;
        var pattern = /^[0-9]+$/;
        
        if(department_id.trim()=="" || department_id.trim()==null){

        document.getElementById("errid").innerHTML="Please Enter Member ID";

        return false;
        }
        
        if (!pattern.test(department_id)) {
           document.getElementById("errid").innerHTML="Please Enter valid Member ID";
        return false;
        }
        else{
         document.getElementById("errid").innerHTML='';

        }
                    
	   }

if(LoginOption =="EmployeeID")
	   {
var EmployeeID = document.getElementById("EmployeeID").value;
        var pattern = /^[a-zA-Z0-9-_ ]+$/;
if(email_id =='' )
			{
        if(EmployeeID.trim()=="" || EmployeeID.trim()==null){

        document.getElementById("erremp").innerHTML="Please Enter PRN/Employee ID";

        return false;
        }
       else if (!pattern.test(EmployeeID)) {
             document.getElementById("erremp").innerHTML="Please Enter valid PRN/Employee ID";
        return false;
        }
        else{

         document.getElementById("erremp").innerHTML='';

        }
			}
	   }
	     if(LoginOption !="memberId")
	   {  
       var OrganizationID = document.getElementById("OrganizationID").value;
        var pattern = /^[a-zA-Z0-9-_ ]+$/;
        if(OrganizationID.trim()=="" || OrganizationID.trim()==null){

		 document.getElementById("errschoolid").innerHTML="Please Enter Institute ID/Organization ID";

        return false;
        }else{
		document.getElementById("errschoolid").innerHTML='';	
	   }
	   }
var Password = document.getElementById("Password").value;
        var pattern = /^[a-zA-Z0-9-_ ]+$/;
        
        if(Password.trim()=="" || Password.trim()==null){

		document.getElementById("errpass").innerHTML="Please Enter Password";

        return false;
        }else {
			document.getElementById("errpass").innerHTML='';
		}
      
}   

$('#LoginOption').change(function(event) {
	   document.getElementById("errpass").innerHTML='';
	   document.getElementById("errschoolid").innerHTML='';
	    document.getElementById("erremail").innerHTML='';
        document.getElementById("errphone").innerHTML='';
        document.getElementById("errid").innerHTML='';
         document.getElementById("erremp").innerHTML='';
}); 
	
 
</script>

</body>
</html>