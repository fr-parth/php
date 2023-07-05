/*var script = document.createElement('script');
script.src = '//code.jquery.com/jquery-1.11.0.min.js';
document.getElementsByTagName('head')[0].appendChild(script); 

*/

var alpha_num = new RegExp("^[a-zA-Z0-9 \s]*$");  //pattern to check alphanumeric values with space
var alpha = new RegExp("^[a-zA-Z]*$");  //pattern to check alpha values
var alpha_space = new RegExp("^[a-zA-Z \s]*$");  //pattern to check alpha values with space
//replaced + with * in numeric and addr for SMC-4077 by Pranali on 20-9-19
var numeric = new RegExp("^[0-9]*$");  //pattern to check numeric values 
var addr = new RegExp("^[A-Za-z0-9 \s\.\,\-\/\(\)]*$");  //pattern to validate address field
var validate_email = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/; //check for valid email id
var decimal = /^[0-9]+\.?[0-9]*$/; //check for valid decimal numbers


$(document).ready(function() {
									//************These validations are checked on assign point page
	$('#select_subject').hide();
	$('#select_activity').hide();
	$('#select_sub_activity').hide();
	$('#type_method').html("Enter Value");
	$("#activity_or_subject").change(function(){
        var value = $(this).val();
	  	$('#actsub').hide(); 
			//alert($('#actsub').val());
	    if(value == 1)
	    {
			$('#select_subject').show();
			$('#select_activity').hide();
			$('#select_sub_activity').hide();
	    }
	    else if(value == 2)
	    {
			$('#select_subject').hide();
			$('#select_activity').show();
			$('#select_sub_activity').show();
	    }
		
		$("#point_method").change(function(){
			var point_method = $(this).val();
			if(point_method == 1)
			{
				var point_meth = "Enter Points";
			}
			else if(point_method == 2)
			{
				var point_meth = "Enter Marks";
			}
			else if(point_method == 3)
			{
				var point_meth = "Enter Grade";
			}
			else if(point_method == 4)
			{
				var point_meth = "Enter Percentile";
			}
				if(point_method != '')
				{
					$('#type_method').html(point_meth);
				}
		});
	   
	});

});

//********Starts Validation on assign point page in teacher module*********//////
	function assign_point()
	{
		//method_name value get into point_method & checked in conditions 
		//by Pranali for SMC-4210 on 6-12-19
		var avail_green = $('#avail_green').val();
		var avail_water = $('#avail_water').val();
		var activity_or_subject = $('#activity_or_subject').val();
		var subject = $('#subject').val();
		var activity = $('#activity').val();
		var sub_activity = $('#sub_activity').val();
		var point_type = $('#point_type').val();
		//var point_method = $('#point_method').val();
		var points_value = $('#points_value').val();
		var point_reason = $('#point_reason').val();
		var point = $.isNumeric(points_value);
		var elt = document.getElementById('point_method');
    	var point_method = elt.options[elt.selectedIndex].text;
    	var grade_arr = ['A','B','C','D'];
		//sctype added by Sayali for smc-4798 on 31/8/2020
		var sctype = "<?php echo $school_type ?>";
		//var alpha_num = "/^[-\w\s]/";

		if(activity_or_subject == "" || activity_or_subject == "0")
		{
			alert("Please select subject/activity type!!");
			$('#activity_or_subject').focus();
			return false;
		}
		else if(activity_or_subject == "1" && (subject == "0" || subject == ""))
		{
			if(sctype=="school")
			{
			alert("Please select School!!");
			} else {
				alert("Please select project!!");
			}
			$('#subject').focus();
			return false;
		}
		else if(activity_or_subject == "2" && (activity == "0" || activity == ""))
		{
			alert("Please select activity!!");
			$("#activity").focus();
			return false;
		}
		else if(activity_or_subject == "2" && (sub_activity == "0" || sub_activity == ""))
		{
			alert("Please select sub activity type!!");
			$("#sub_activity").focus();
			return false;
		}
		else if(point_type == "0" || point_type == "")
		{
			alert("Please select points type!!");
			$("#point_type").focus();
			return false;
		}
		else if(point_method == "0" || point_method == "")
		{
			alert("Please select points method!!");
			$("#point_method").focus();
			return false;
		}
		else if(points_value == "0" || points_value == "")
		{
			alert("Please enter value greater than 0!!");
			$("#points_value").focus();
			return false;
		}
		else if((point_method == "Judgement" || point_method == "Marks" || point_method == "Percentile") && point ==false)
		{
			alert("Please enter numeric value!!");
			$("#points_value").focus();
			$("#points_value").val("");
			return false;
		}
		else if(point_method == "Grade" && grade_arr.indexOf(points_value) < "0" )
		{
			alert("Please enter grade value A,B,C or D only!!");
			$("#points_value").focus();
			$("#points_value").val("");
			return false;
		}
		else if(point_type == "Greenpoint" && point_method == "Judgement" && points_value > parseInt(avail_green) )
		{
			alert("You have insufficient green points!!");
			$("#point_type").focus();
			$("#points_value").val("");
			return false;
		}
		else if(point_type == "Waterpoint" && point_method == "Judgement" && points_value > parseInt(avail_water) )
		{
			alert("You have insufficient water points!!");
			$("#point_type").focus();
			$("#points_value").val("");
			return false;
		}
		else if(alpha_num.test(point_reason) == false)
		{
			alert("Please enter comment having alphabets and numbers only!!");
			$("#point_reason").focus();
			$("#point_reason").val("");
			return false;
		}
		
	}
//********Ends Validation on assign point page in teacher module*********//////

//********Starts Validation on generate smart cookie coupon page in teacher module*********//////
function generate_coupon()
{
	var points_type = $("#points_type").val();
	var points_value = $("#points_value").val();
	var avail_blue = $("#avail_blue").val();
	var avail_water = $("#avail_water").val();
	var avail_brown = $("#avail_brown").val();

	if(points_type == "" || points_type == "0")
	{
		alert("Please select point type to generate coupon!!");
		$("#points_type").focus();
		return false;
	}
	else if(points_value == "" || points_value == "0")
	{
		alert("Please select points to generate coupon!!");
		$("#points_value").focus();
		return false;
	}
	else if(points_value == "" || points_value == "0")
	{
		alert("Please select points to generate coupon!!");
		$("#points_value").focus();
		return false;
	}
	else if(points_type == "Bluepoints" && points_value > parseInt(avail_blue))
	{
		alert(points_value);
		alert("You have insufficient blue points to generate coupon!!");
		$("#points_type").focus();
		return false;
	}
	else if(points_type == "Waterpoints" && points_value > parseInt(avail_water))
	{
		alert("You have insufficient water points to generate coupon!!");
		$("#points_type").focus();
		return false;
	}
	else if(points_type == "Brownpoints" && points_value > parseInt(avail_brown))
	{
		alert("You have insufficient brown points to generate coupon!!");
		$("#points_type").focus();
		return false;
	}
}

function share_pointsto_teacher()
{
	var point_type = $("#point_type").val();
	var points = $("#points").val();
	var point_reason = $("#point_reason").val();
	
	if(point_type == "" || point_type == "0")
	{
		alert("Please select point type to share points!!");
		$("#point_type").focus();
		return false;
	}
	else if(points == "" || points == "0")
	{
		alert("Please enter points to share!!");
		$("#points").focus();
		return false;
	}
	else if($.isNumeric(points) == false)
	{
		alert("Please enter numeric value for points!!");
		$("#points").focus();
		$("#points").val("");
		return false;
	}
	else if(!$.trim(point_reason))
	{
		alert("Please enter text for reason!!");
		$("#point_reason").focus();
		return false;
	}
	else if(alpha_num.test(point_reason) == false)
	{
		alert("Please enter only alphabets and numeric value for reason!!");
		$("#point_reason").focus();
		$("#point_reason").val("");
		return false;
	}
}
//mudra_requestto_manager() & thanq_mudra() added by Pranali for validation of mudra request 
//and thanq mudra respectively for SMC-4269 on 17-12-19
function mudra_requestto_manager()
{
	var activity = $("#activity").val();
	var sub_activity = $("#sub_activity").val();
	var points = $("#points").val();
	var point_reason = $("#point_reason").val();
	
	if(activity == '')
	{
		alert("Please select activity!!");
		$("#activity").focus();
		return false;
	}
	else if(sub_activity == '')
	{
		alert("Please select sub activity!!");
		$("#sub_activity").focus();
		return false;
	}
	else if(points == "" || points == "0")
	{
		alert("Please enter points to share!!");
		$("#points").focus();
		return false;
	}
	else if($.isNumeric(points) == false)
	{
		alert("Please enter numeric value for points!!");
		$("#points").focus();
		$("#points").val("");
		return false;
	}
	else if(!$.trim(point_reason))
	{
		alert("Please enter text for reason!!");
		$("#point_reason").focus();
		return false;
	}
	else if(alpha_num.test(point_reason) == false)
	{
		alert("Please enter only alphabets and numeric value for reason!!");
		$("#point_reason").focus();
		$("#point_reason").val("");
		return false;
	}
}

function thanq_mudra()
{
	var thanq = $("#thanq").val();
	var points = $("#points").val();

	if(thanq == '')
	{
		alert("Please select thanq reason!!");
		$("#thanq").focus();
		return false;
	}
	else if(points == "" || points == "0")
	{
		alert("Please enter thanq points!!");
		$("#points").focus();
		return false;
	}
	else if($.isNumeric(points) == false)
	{
		alert("Please enter numeric value for points!!");
		$("#points").focus();
		$("#points").val("");
		return false;
	}
}

function requestToJoinSmartcookie()
{
	var entity_type = $('#entity_type').val();
	var firstName = $('#firstName').val();
	var midName = $('#midName').val();
	var lastName = $('#lastName').val();
	var emailId = $('#emailId').val();
	var countryCode = $('#countryCode').val();
	var mobileNumber = $('#mobileNumber').val();
	
	
	if(entity_type == "" || entity_type == "0")
	{
		alert("Please select user type!!");
		$("#entity_type").focus();
		return false;
	}
	else if(!$.trim(firstName))
	{
		alert("Please enter user's first name!!");
		$("#firstName").focus();
		$("#firstName").val("");
		return false;
	}
	else if(alpha.test(firstName) == false || firstName.length < "2")
	{
		alert("Please enter valid first name having alphabets only!!");
		$("#firstName").focus();
		$("#firstName").val("");
		return false;
	}
	else if(!$.trim(midName))
	{
		alert("Please enter user's middle name!!");
		$("#midName").focus();
		$("#midName").val("");
		return false;
	}
	else if(alpha.test(midName) == false)
	{
		alert("Please enter valid middle name having alphabets only!!");
		$("#midName").focus();
		$("#midName").val("");
		return false;
	}
	else if(!$.trim(lastName))
	{
		alert("Please enter user's last name!!");
		$("#lastName").focus();
		$("#lastName").val("");
		return false;
	}
	else if(alpha.test(lastName) == false || lastName.length < "2")
	{
		alert("Please enter valid last name having alphabets only!!");
		$("#lastName").focus();
		$("#lastName").val("");
		return false;
	}
	else if(!$.trim(emailId))
	{
		alert("Please enter user's email id!!");
		$("#emailId").focus();
		$("#emailId").val("");
		return false;
	}
	else if(validate_email.test(emailId) == false )
	{
		alert("Please enter valid email id!!");
		$("#emailId").focus();
		$("#emailId").val("");
		return false;
	}
	else if(!$.trim(countryCode))
	{
		alert("Please enter user's country code!!");
		$("#countryCode").focus();
		$("#countryCode").val("");
		return false;
	}
	else if(numeric.test(countryCode) == false)
	{
		alert("Please enter valid country code!!");
		$("#countryCode").focus();
		$("#countryCode").val("");
		return false;
	}
	else if(!$.trim(mobileNumber))
	{
		alert("Please enter user's mobile number!!");
		$("#mobileNumber").focus();
		$("#mobileNumber").val("");
		return false;
	}
	else if(numeric.test(mobileNumber) == false || mobileNumber.length != "10")
	{
		alert("Please enter valid 10 digit mobile number!!");
		$("#mobileNumber").focus();
		$("#mobileNumber").val("");
		return false;
	}
}

function suggest_sponsor()
{
	var sponsorName = $('#sponsorName').val();
	var companyName = $('#companyName').val();
	var categories = $('#categories').val();
	var emailId = $('#emailId').val();
	var phoneNumber = $('#phoneNumber').val();
	var country_id = $('#country_id').val();
	var states = $('#states').val();
	var cities = $('#cities').val();
	var address = $('#address').val();

	if(!$.trim(sponsorName))
	{
		alert("Please enter sponsor name!!");
		$("#sponsorName").focus();
		$("#sponsorName").val("");
		return false;
	}
	else if(alpha_space.test(sponsorName) == false)
	{
		alert("Please enter sponsor name having alphabets with space only!!");
		$("#sponsorName").focus();
		$("#sponsorName").val("");
		return false;
	}
	else if(!$.trim(companyName))
	{
		alert("Please enter shop name!!");
		$("#companyName").focus();
		$("#companyName").val("");
		return false;
	}
	else if(alpha_num.test(companyName) == false)
	{
		alert("Please enter shop name having alphabets & numbers with space only!!");
		$("#companyName").focus();
		$("#companyName").val("");
		return false;
	}
	else if(!$.trim(categories))
	{
		alert("Please select sponsor category!!");
		$("#categories").focus();
		$("#categories").val("");
		return false;
	}
	else if(numeric.test(categories) == false)
	{
		alert("Please select valid category!!");
		$("#categories").focus();
		$("#categories").val("");
		return false;
	}
	else if(!$.trim(emailId))
	{
		alert("Please enter email id!!");
		$("#emailId").focus();
		$("#emailId").val("");
		return false;
	}
	else if(validate_email.test(emailId) == false)
	{
		alert("Please enter valid email id!!");
		$("#emailId").focus();
		$("#emailId").val("");
		return false;
	}
	else if(!$.trim(phoneNumber))
	{
		alert("Please enter phone number!!");
		$("#phoneNumber").focus();
		$("#phoneNumber").val("");
		return false;
	}
	else if(numeric.test(phoneNumber) == false || phoneNumber.length < 10 || phoneNumber.length > 11)
	{
		alert("Please enter valid phone number!!");
		$("#phoneNumber").focus();
		$("#phoneNumber").val("");
		return false;
	}
	else if(!$.trim(country_id))
	{
		alert("Please select country!!");
		$("#country_id").focus();
		$("#country_id").val("");
		return false;
	}
	else if(alpha_space.test(country_id) == false )
	{
		alert("Please select valid country, invalid country found!!");
		$("#country_id").focus();
		$("#country_id").val("");
		return false;
	}
	else if(!$.trim(states))
	{
		alert("Please select state!!");
		$("#states").focus();
		$("#states").val("");
		return false;
	}
	else if(alpha_space.test(states) == false )
	{
		alert("Please select valid state, invalid state found!!");
		$("#states").focus();
		$("#states").val("");
		return false;
	}
	else if(!$.trim(cities))
	{
		alert("Please select city!!");
		$("#cities").focus();
		$("#cities").val("");
		return false;
	}
	else if(alpha_space.test(cities) == false )
	{
		alert("Please select valid city, invalid city found!!");
		$("#cities").focus();
		$("#cities").val("");
		return false;
	}
	else if(!$.trim(address))
	{
		alert("Please enter address!!");
		$("#address").focus();
		$("#address").val("");
		return false;
	}
	else if(addr.test(address) == false || address.length < 4)
	{
		alert("Please enter address properly!!");
		$("#address").focus();
		$("#address").val("");
		return false;
	}
	
}
function teacher_basic_info()
{
	var fullName = $('#fullName').val();
	//var firstName = $('#firstName').val();
	//var midName = $('#midName').val();
	//var lastName = $('#lastName').val();
	// var date = $('#date').val();
	// var qualification = $('#qualification').val();
	// var genderM = $('#genderM').prop('checked');
	// var genderF = $('#genderF').prop('checked');

	if(!$.trim(fullName))
	{
		alert("Please enter full name!!");
		$("#fullName").focus();
		$("#fullName").val("");
		return false;
	}
	else if(alpha_space.test(fullName) == false)
	{
		alert("Please enter full name having alphabets & space only!!");
		$("#fullName").focus();
		$("#fullName").val("");
		return false;
	}
	/*if(!$.trim(firstName))
	{
		alert("Please enter first name!!");
		$("#firstName").focus();
		$("#firstName").val("");
		return false;
	}
	else if(alpha.test(firstName) == false)
	{
		alert("Please enter first name having alphabets without space!!");
		$("#firstName").focus();
		$("#firstName").val("");
		return false;
	}
	else if(alpha.test(midName) == false)
	{
		alert("Please enter middle name having alphabets without space!!");
		$("#midName").focus();
		$("#midName").val("");
		return false;
	}
	else if(!$.trim(lastName))
	{
		alert("Please enter last name!!");
		$("#lastName").focus();
		$("#lastName").val("");
		return false;
	}
	else if(alpha.test(lastName) == false)
	{
		alert("Please enter last name having alphabets without space!!");
		$("#lastName").focus();
		$("#lastName").val("");
		return false;alpha_num
	}*/

	//Validation for Qualification, date removed by Pranali for SMC-4077 on 20-9-19
	/*else if(!$.trim(date))
	{
		alert("Please enter date of birth!!");
		$("#date").focus();
		$("#date").val("");
		return false;
	}
	else if(!$.trim(qualification))
	{
		alert("Please enter qualification!!");
		$("#qualification").focus();
		$("#qualification").val("");
		return false;
	}*/
	//else if condition added by Pranali for SMC-3995 on 25-9-19 
	// else if(qualification!=''){
	// 	if(alpha_num.test(qualification) == false)
	// 	{
	// 		alert("Please enter qualification having alphabets , number or space only!!");
	// 		$("#qualification").focus();
	// 		$("#qualification").val("");
	// 		return false;
	// 	}
	// }
	/*
	else if(genderM == false && genderF == false)
	{
		alert("Please select gender!!");
		$("#genderM").focus();
		return false;
	}*/
}
function teacher_contact_info()
{
	var countryCode = $('#countryCode').val();
	var countryName = $('#countryName').val();
	var mobileNumber = $('#mobileNumber').val();
	//var landLine = $('#landLine').val();
	var emailId = $('#emailId').val();
	// var address = $('#address').val();
	// var pinCode = $('#pinCode').val();

	//country code validation commented by Pranali for SMC-3997 on 21-10-19
	// if(!$.trim(countryCode))
	// {
	// 	alert("Please enter country code!!");
	// 	$("#countryCode").focus();
	// 	$("#countryCode").val("");
	// 	return false;
	// }
	// else if(numeric.test(countryCode) == false)
	// {
	// 	alert("Please enter country code having numbers only!!");
	// 	$("#countryCode").focus();
	// 	$("#countryCode").val("");
	// 	return false;
	// }
	// if(countryName=="")
	// {
	// 	alert("Please select country name!!");
	// if(!$.trim(countryCode))
	// {
	// 	alert("Please enter country code!!");
	// 	$("#countryCode").focus();
	// 	$("#countryCode").val("");
	// 	return false;
	// }
	// else if(numeric.test(countryCode) == false)
	// {
	// 	alert("Please enter country code having numbers only!!");
	// 	$("#countryCode").focus();
	// 	$("#countryCode").val("");
	// 	return false;
	// }

	//Country Name validation removed by Pranali for SMC-4077 on 20-9-19
	if(countryName=="")
	{
		alert("Please select country name!!");
		$("#countryName").focus();
		//$("#countryName").val("");
		return false;
	}
	// else if(alpha_space.test(countryName) == false)
	// {
	// 	alert("Please enter country name having alphabets with space only!!");
	// 	$("#countryName").focus();
	// 	$("#countryName").val("");
	// 	return false;
	// }
	else if(!$.trim(mobileNumber))
	{
		alert("Please enter mobile number!!");
		$("#mobileNumber").focus();
		$("#mobileNumber").val("");
		return false;
	}
	else if(numeric.test(mobileNumber) == false || mobileNumber.length != "10")
	{
		alert("Please enter valid 10 digit mobile number!!");
		$("#mobileNumber").focus();
		$("#mobileNumber").val("");
		return false;
	}
	//Code updated by Rutuja Jori & Sayali Balkawade(PHP Interns) for making 'landLine' optional as specified in bug SMC-3466 on 04/04/2019
/*	else if (landLine!='')
	{
	 if(numeric.test(landLine) == false || landLine.length < "10" || landLine.length > "12")
	{
		alert("Please enter valid landline number!!");
		$("#landLine").focus();
		$("#landLine").val("");
		return false;
	}
	}
	*/
	else if(!$.trim(emailId))
	{
		alert("Please enter email id!!");
		$("#emailId").focus();
		$("#emailId").val("");
		return false;
	}
	else if(validate_email.test(emailId) == false )
	{
		alert("Please enter valid email id!!");
		$("#emailId").focus();
		$("#emailId").val("");
		return false;
	}
	//Address, pinCode validation removed by Pranali for SMC-4077 on 20-9-19
	/*else if(!$.trim(address))
	{
		alert("Please enter address!!");
		$("#address").focus();
		$("#address").val("");
		return false;
	}*/
	//else if(addr.test(address) == false || address.length < 4)
	// else if(addr.test(address) == false)
	// {
	// 	alert("Please enter address properly!!");
	// 	$("#address").focus();
	// 	$("#address").val("");
	// 	return false;
	// }
	/*
	else if(!$.trim(pinCode))
	{
		alert("Please enter pin code!!");
		$("#pinCode").focus();
		$("#pinCode").val("");
		return false;
	}*/
	// else if(!empty(pinCode)){
	// 	if(numeric.test(pinCode) == false || pinCode.length < 5 || pinCode.lenght >6)
	// 	{
	// 		alert("Please enter valid pin code!!");
	// 		$("#pinCode").focus();
	// 		$("#pinCode").val("");
	// 		return false;
	// 	}
	// }
}
function teacher_work_info()
{
	//var experience = $('#experience').val();
	var internalEmail = $('#internalEmail').val();
	

	//Mandatory validation for experience removed by Pranali for SMC-4077 on 20-9-19 
	/*if(!$.trim(experience))
	{
		alert("Please enter experience years!!");
		$("#experience").focus();
		$("#experience").val("");
		return false;
	}*/
	if(!empty(experience)){
		if(decimal.test(experience) == false || experience <= 0 || experience >99)
		{
			alert("Please enter valid number for experience years greater than zero!!");
			$("#experience").focus();
			$("#experience").val("");
			return false;
		}
	}
	
	else if(!$.trim(internalEmail))
	{
		alert("Please enter internal email id!!");
		$("#internalEmail").focus();
		$("#internalEmail").val("");
		return false;
	}
	else if(validate_email.test(internalEmail) == false )
	{
		alert("Please enter valid internal email id!!");
		$("#internalEmail").focus();
		$("#internalEmail").val("");
		return false;
	}
	
}
function teacher_pass_info()
{
	var oldPassword = $('#oldPassword').val();
	var newPassword = $('#newPassword').val();
	var confPassword = $('#confPassword').val();
	
	if(!$.trim(oldPassword))
	{
		alert("Please enter old password!!");
		$("#oldPassword").focus();
		$("#oldPassword").val("");
		return false;
	}
	else if(!$.trim(newPassword))
	{
		alert("Please enter new password!!");
		$("#newPassword").focus();
		$("#newPassword").val("");
		return false;
	}
	else if (newPassword.indexOf(' ') >= 0)
	{
		alert("Please enter new password without space!!");
		$("#newPassword").focus();
		$("#newPassword").val("");
		return false;
	}
	else if(!$.trim(confPassword))
	{
		alert("Please confirm new password!!");
		$("#confPassword").focus();
		$("#confPassword").val("");
		return false;
	}
	else if (confPassword.indexOf(' ') >= 0)
	{
		alert("Please enter confirm password without space!!");
		$("#confPassword").focus();
		$("#confPassword").val("");
		return false;
	}
	else if(newPassword != confPassword)
	{
		alert("New password does not match!!");
		$("#confPassword").focus();
		$("#confPassword").val("");
		return false;
	}
	
}

function addSubject()
{
	var mysubject = $('#mysubject').val();
	var courseLevel = $('#courseLevel').val();
	var department = $('#department').val();
	var branch = $('#branch').val();
	var semester = $('#semester').val();
	var year = $('#year').val();
	var division = $('#division').val();
	
	if(!$.trim(mysubject))
	{
		alert("Please select subject name!!");
		$("#mysubject").focus();
		$("#mysubject").val("");
		return false;
	}
	else if(!$.trim(courseLevel))
	{
		alert("Please select course level!!");
		$("#courseLevel").focus();
		$("#courseLevel").val("");
		return false;
	}
	else if(!$.trim(department))
	{
		alert("Please select department!!");
		$("#department").focus();
		$("#department").val("");
		return false;
	}
	else if(!$.trim(branch))
	{
		alert("Please select branch!!");
		$("#branch").focus();
		$("#branch").val("");
		return false;
	}
	else if(!$.trim(semester))
	{
		alert("Please select semester!!");
		$("#semester").focus();
		$("#semester").val("");
		return false;
	}
	else if(!$.trim(year))
	{
		alert("Please select year!!");
		$("#year").focus();
		$("#year").val("");
		return false;
	}
	else if(!$.trim(division))
	{
		alert("Please select division!!");
		$("#division").focus();
		$("#division").val("");
		return false;
	}
}

function searchStudent()
{
	var search_text = $('#search_text').val();
	
	if(!$.trim(search_text))
	{
		alert("Please Enter Student PRN, Name or Class!!");
		$("#search_text").focus();
		$("#search_text").val("");
		return false;
	}
	else if(/^[a-zA-Z0-9 \s\.]+$/.test(search_text)== false)
	{
		alert("Please Enter valid Student PRN, Name or Class!!");
		$("#search_text").focus();
		$("#search_text").val("");
		return false;
	}
}