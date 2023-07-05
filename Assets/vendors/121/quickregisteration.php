<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>

<?php

if(isset($_POST['submit']))
{
	
	$source = $_SERVER['HTTP_REFERER'];
	$firstname=$_POST['firstname'];
	$middlename=$_POST['middlename'];
	$lastname=$_POST['lastname'];
	$phonenumber=$_POST['phonenumber'];
	$emailid=$_POST['emailid'];
	$countrycode=$_POST['countrycode'];
	$usertype=$_POST['usertype'];
	$orgname=$_POST['orgname'];
	$project[]=$_POST['project'];


	for($i=0;$i<count($project);$i++)
	{
		for($j=0;$j<count($project[$i]);$j++)
		{
			if($project[$i][$j]=='smartcookie')
				{
					$result=  file_get_contents("http://tsmartcookies.bpsi.us/core/Version2/quickregistration_for_all_domain_API.php?Key=1&firstname=$firstname&middlename=$middlename&lastname=$lastname&phonenumber=$phonenumber&emailid=$emailid&countrycode=$countrycod&usertype=$usertype&org_name=$orgname&source=$source");
					
					$obj = json_decode($result,TRUE);
					
					$responseStatus=$obj->{'responseStatus'};
					
					if($responseStatus=="200")
					{
						
						$coll=	$obj["posts"];	
						 $value= $coll[0];
					    $id =  $value["id"];
						
						$password = $value["password"];
						//print here id and password
						echo "Your ID for Smartcookie is $id";
						echo "</br>";
						echo "Your Password for Smartcookie is $password";
						echo "</br>";
						echo "</br>";
						echo "</br>";
						
					}
				
				}
			if($project[$i][$j]=='ethicalhr')
				{
				$result=  file_get_contents("http://ethicalhr.org/webservices/quickregistration_for_all_domain_API.php?Key=2&firstname=$firstname&middlename=$middlename&lastname=$lastname&phonenumber=$phonenumber&emailid=$emailid&countrycode=$countrycod&usertype=$usertype&org_name=$orgname&source=$source");
				
				$obj = json_decode($result);
					
					$coll=	$result["posts"];	
					$value= $coll[0];
					$id =  $value["id"];
					$password = $value["password"];
					$ethical_reg_id = $value["ethical_reg_id"];
					$responseStatus=$obj->{'responseStatus'};
					if($responseStatus=="200")
					{
						echo "Your ID for Ethical HR is $id";
						echo "</br>";
						echo "Your Password for Ethical HR is $password";
						echo "</br>";
						echo "Your Ethical Registeration Id for Ethical HR is $ethical_reg_id";
						
						echo "</br>";
						echo "</br>";
						echo "</br>";
						
						
					}
				}
				if($project[$i][$j]=='startupworld')
				{
				$result=  file_get_contents("http://bpsi.us/startupworldus/quickregistration_for_all_domain_API.php?Key=5&firstname=$firstname&middlename=$middlename&lastname=$lastname&phonenumber=$phonenumber&emailid=$emailid&countrycode=$countrycod&usertype=$usertype&org_name=$orgname&source=$source");
				
				$obj = json_decode($result);
					$coll=	$result["posts"];
					$value= $coll[0];	
					$id =  $value["id"];
					$password = $value["password"];
					$responseStatus=$obj->{'responseStatus'};
					if($responseStatus=="200")
					{
						echo "Your ID for Ethical HR is $id";
						echo "</br>";
						echo "Your Password for Ethical HR is $password";
						echo "</br>";
						echo "</br>";
						echo "</br>";
						
					}
				}
					
		}
		
	}
	
	
}




?>
<div >
<div >
<form method="post">
<lable for name>First Name:</lable>
<input type="text" name="firstname" id="firstname" required></br>

<lable for name>Middle Name:</lable>
<input type="text" name="middlename" id="middlename" required></br>

<lable for name>Last Name:</lable>
<input type="text" name="lastname" id="lastname" required></br>

<lable for name>Phone Number:</lable>
<input type="text" name="phonenumber" id="phonenumber" required></br>

<lable for name>Email Id:</lable>
<input type="text" name="emailid" id="emailid" required></br>

<lable for name>Country Code:</lable>
<select name="countrycode" id="countrycode" required>
<option value="">Select Code</option>
<option value="91">91</option>
<option value="1">1</option>

</select></br>


<lable for name>User Type:</lable>
<select name="usertype" id="usertype" required>
<option value="">Select Code</option>
<option value="Student">Student</option>
<option value="Employee">Employee</option>
</select></br>

<lable for name>Organisation Name:</lable>
<input type="text" name="orgname" id="orgname" required></br>

<lable for name>Check for sign up:</lable></br>
<input type="checkbox" name="project[]" value="smartcookie" required>Smartcookie</br>
<input type="checkbox" name="project[]"  value="jobsitare">Job Sitare</br>
<input type="checkbox" name="project[]" value="ethicalhr">Ethical Hr</br>
<input type="checkbox" name="project[]"  value="startupworld">Startup World</br>
<input type="checkbox" name="project[]"  value="startterbarter">Startter Barter</br>
<!--<input type="checkbox" name="project[]" value="jobsitare"></br>
<input type="checkbox" name="project[]" value="jobsitare"></br>
<input type="checkbox" name="project[]" value="jobsitare"></br>
<input type="checkbox" name="project[]"value="jobsitare" ></br>-->

<input type="submit" name="submit" value="Sign Up" required>



<form>



</div>
</div>


</body>
</html>