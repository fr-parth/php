<?php
$report="";	

include("hr_header.php");

	if(isset($_POST['submit']))
	{
	
	   $email = $_POST['id_email'];
		 
		$row=mysql_query("select * from tbl_teacher where t_email like '$email' ");
		if(mysql_num_rows($row)<=0)
		{
		$id_first_name = $_POST['id_first_name'];
		$id_last_name = $_POST['id_last_name'];
		$name=$id_first_name." ".$id_last_name;
		
	    $education =$_POST['id_education'];
		$experience=$_POST['experience'];
		$designation=$_POST['Designation'];
		
		$date = $_POST['dob'];
		
		//$gender = $_POST['id_gender'];
		//retrive school_id and name school_admin
		//$arrs=$smartcookie->retrive_scadmin_profile();
		$fields=array("id"=>$id);
		   $table="tbl_school_admin";
		   
		   $smartcookie=new smartcookie();
		   
            $results=$smartcookie->retrive_individual($table,$fields);
            $arrs=mysql_fetch_array($results);
			$school_id=$arrs['school_id'];
			$school_name=$arrs['school_name'];
		//$class = $_POST['class1'];
		//$subject = $_POST['subject'];
		$email = $_POST['id_email'];
		$phone = $_POST['id_phone'];
		$gender=$_POST['gender'];
    	$address = $_POST['address'];
		$country = mysql_escape_string($_POST['country']);
		$state = mysql_escape_string($_POST['state']);
		$city = $_POST['city'];
		$dates = date('m/d/Y');
		
        $password = $id_first_name."123";
		//$permision=implode(',',$_POST['permission']);
	
		 list($month,$day,$year) = explode("/",$date);
		$year_diff  = date("Y") - $year;
		$month_diff = date("m") - $month;
		$day_diff   = date("d") - $day;
		if ($day_diff < 0 || $month_diff < 0) $year_diff--;
		$age= $year_diff;
	
	$currentdate = date('Y-m-d H:i:s');
	
//------------------------------insert in tbl_school_adminstaff table----------
	  
	  $sqls= "INSERT INTO tbl_school_adminstaff ( stf_name, school_id, exprience, designation, addd, country, city, statue, dob, age, gender, email, phone, pass,  qualification, currentDate) VALUES ( '$name', '$school_id', '$experience', '$designation', '$address', '$country', '$city', '$state', '$date', '$age', '$gender', '$email', '$phone', '$password', '$education', '$currentdate')";
	  	
	$count = mysql_query($sqls) or die(mysql_error()); 
	
//-------------------------------End------------------------------------------------	


//------------------------------Fetch Data form tbl_school_adminstaff table----------
	
	/*$sql1 = mysql_query("select id,stf_name from tbl_school_adminstaff where email='$email' or phone='$phone'");
	$result=mysql_fetch_array($sql1);
	$staf_id=$result['id'];
	$staf_name=$result['stf_name'];*/
	
//------------------------------End--------------------------------------------------




//------------------------------Insert in permision in tbl_permission table----------
     /*$sql="INSERT INTO `tbl_permission` (`permission_id`, `school_id`, `s_a_st_id`, `cookie_admin_staff_id`,`school_staff_name`, `cookie_staff_name`, `permission`, `current_date`) VALUES (NULL, '$school_id', '$staf_id', NULL, '$staf_name', NULL, '$permision', '$currentdate')";
	 $rs=mysql_query($sql) or die(mysql_error());*/
//------------------------------End--------------------------------------------------

		if($count>=1)
		{	
	$to=$email;
	$from="smartcookiesprogramme@gmail.com";
	$subject="Succesful Registration";
	$message="Hello ".$id_first_name." ".$id_last_name."\r\n\r\n".
		 "Thanks for registration with Smart Cookie as teacher\r\n".
		  "your Username is: "  .$email.  "\n\n".
		  "your password is: ".$password."\n\n".
		  "your School ID is: ".$school_id."\n\n".
		  "Regards,\r\n".
   	      "Smart Cookie Admin";
		  
     mail($to, $subject, $message);
		
		$report="successfully updated"; 
		header("Location:Admin_Staff_setup.php?report=".$report);
		}
		}
		else
		{
		
		$report="Email ID is already present";
		}
	   
	}
?>

<!DOCTYPE html>
<head>
 
 
 
<style>
  body {
   background-color:#F8F8F8;
   }
  .indent-small {
  margin-left: 5px;
}
.form-group.internal {
  margin-bottom: 0;
}

.dialog-panel {
  margin: 10px;
}


.panel-body {  
  


  font: 600 15px "Open Sans",Arial,sans-serif;
}

label.control-label {
  font-weight: 600;
  color: #777;  
}
</style>
<script src='js/bootstrap-datepicker.min.js' type='text/javascript'></script>
<script src="js/city_state.js" type="text/javascript"></script>
<link href='css/datepicker.min.css' rel='stylesheet' type='text/css'>
<script>
$(document).ready(function() {  
   
  $('.datepicker').datepicker();  
});


 var reg = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;  
      function PhoneValidation(phoneNumber)
      {  
        var OK = reg.exec(phoneNumber.value);  
        if (!OK)  
         document.getElementById('errorphone').innerHTML='Please Enter Valid Phone Number';
		 return false;
       
      }
function valid()
	{
	
				
	 
		
		var first_name=document.getElementById("id_first_name").value;
		
		var last_name=document.getElementById("id_last_name").value;
		
		if(first_name==null||first_name=="" || last_name==null|| last_name=="" )
			{
			   
				document.getElementById('errorname').innerHTML='Please Enter Name';
				
				return false;
			}
		
		regx1=/^[A-z ]+$/;
				//validation for name
				if(!regx1.test(first_name) || !regx1.test(last_name))
				{
				document.getElementById('errorname').innerHTML='Please Enter valid Name';
					return false;
				}
				var education=document.getElementById("id_service").value; 
		if(education==null||education=="")
			{
			   
				document.getElementById('errorexperience').innerHTML='Please enter education';
				
				return false;
			}
				var experience=document.getElementById("experience").value; 
		if(experience==null||experience=="")
			{
			   
				document.getElementById('errorexperience').innerHTML='Please enter experience';
				
				return false;
			}
			else if(experience <0 || experience%1!=0)
			{
				document.getElementById('errorexperience').innerHTML='Please enter valid experience';
				
				return false;
				
				}
			else
			{
				document.getElementById('errorexperience').innerHTML='';
			}
			
			
			
			regx1=/^[A-z ]+$/;
			var Designation=document.getElementById("Designation").value;
				//validation for name
				if(!regx1.test(Designation))
				{
				document.getElementById('errordesignation').innerHTML='Please Enter valid Designation';
					return false;
				}
					 var id_checkin=document.getElementById("id_checkin").value;
					 	 var myDate = new Date(id_checkin);
				var today = new Date();
				if(id_checkin=="")
			{
	
			   
				document.getElementById('errordob').innerHTML='Please Enter Date of Birth';
				
				return false;
			}
			if(myDate.getFullYear()>=today.getFullYear())
				{
						if(myDate.getMonth()>=today.getMonth())
						{
							if(myDate.getDate()>=today.getDate())
							{
								
							document.getElementById("errordob").innerHTML ="please enter valid birth date";
						return false;
							}	
							
						}	
				}
				  else
					  {
						   document.getElementById("errordob").innerHTML ="";
						  
						 }
			var gender1=document.getElementById("gender1").checked;
		
			var gender2=document.getElementById("gender2").checked;
			
		if(gender1==false && gender2==false)
			{
				document.getElementById('errorgender').innerHTML='Please Select gender';
				return false;
			}
			
			
		
		 
		
		var subject=document.getElementById("subject").value;
		if(subject==null||subject=="")
			{
			   
				document.getElementById('errorsubject').innerHTML='Please Enter Subject';
				
				return false;
			}
	
				var email=document.getElementById("id_email").value;
		if(email==null||email=="")
			{
			   
				document.getElementById('erroremail').innerHTML='Please Enter email';
				
				return false;
			}
			
			  //validation of email
				/*var atpos = email.indexOf("@");
				var dotpos = email.lastIndexOf(".");
				
				if (atpos< 1 || dotpos<atpos+2 || dotpos+2>=email.length) {
					document.getElementById('erroremail').innerHTML='Please enter valid Email Id';
					return false;
				}*/
				 var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;  
			  if(!email.match(mailformat))  
				{  
				document.getElementById('erroremail').innerHTML='Please Enter valid email ID';

				return false;  
				} 
				else
				{
					document.getElementById('erroremail').innerHTML='';
				}
			


		var address=document.getElementById("id_address").value;
		if(address==null||address=="")
			{
			   
				document.getElementById('erroraddress').innerHTML='Please Enter address';
				
				return false;
			}
		var country=document.getElementById("country").value;
		
		if(country=="-1")
			{
			   
				document.getElementById('errorcountry').innerHTML='Please Enter country';
				
				return false;
			}
			
		var state=document.getElementById("state").value;
		if(state==null||state=="")
			{
			   
				document.getElementById('errorstate').innerHTML='Please Enter state';
				
				return false;
			}	
		var city=document.getElementById("id_city").value;
		
		if(city==null||city=="")
			{
			   
				document.getElementById('errorcity').innerHTML='Please Enter city';
				
				return false;
			}
			
								
			  
		
	}
</script>
</head>
<body >
  <div class='container' >
    <div class='panel panel-primary dialog-panel' style="background-color:#FFFFFF;background-image=""">
   <div style="color:red;font-size:15px;font-weight:bold;margin-top:10px;"> <?php if(isset($_GET['report'])){ echo $_GET['report']; };?></div>
      <div class='panel-heading'>
         
            <h3 align="center">HR Staff Setup</h3>
        
        
            <h5 align="center"><a href="Add_teacherSheet.php" >Add Excel Sheet</a></h5>
          </div>
      <div class='panel-body'>
        <form class='form-horizontal' role='form' method="post">
        
        
        <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='id_title' style="text-align:left;">Staff Name</label>
            <div class='col-md-8'>
            
              <div class='col-md-3 '>
                <div class='form-group internal'>
                  <input class='form-control' id='id_first_name' name="id_first_name" placeholder='First Name' type='text'>
                </div>
              </div>
              <div class='col-md-3 col-sm-offset-1'>
                <div class='form-group internal'>
                  <input class='form-control' id='id_last_name' name="id_last_name" placeholder='Last Name' type='text'>
                </div>
              </div>
              <div class='col-md-4 indent-small' id="errorname" style="color:#FF0000">
                
              </div>
            </div>
          </div>
        

                 
           <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='id_service' style="text-align:left;">Education</label>
            <div class='col-md-2'>
              <select class='multiselect  form-control' id='id_service' name="id_education" >
               <option value=''>Select</option>
                <option value='BA'>BE</option>
                <option value='BCom'>BCom</option>
                <option value='MCom'>MCom</option>
                <option value='MSc'>MBA</option>
                <option value='B.ED'>B-Tech</option>
                <option value='D.ED'>M-Tech</option>
				 <option value='D.ED'>Phd</option>
                <option value='Other'>Other</option>
              </select>
            </div>
             
            
            
            <label class='control-label col-md-3 '>Experience(in Months)</label>
            
              <div class='col-md-1'>
               
                  <input class='form-control ' id='experience' name='experience' placeholder='Experience' type='text'>
              
              </div>
             <div class='col-md-2 indent-small' id="errorexperience" style="color:#FF0000"></div>
           
       
          </div>
          
          
           <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='id_title' style="text-align:left;">Designation</label>
            
             
                <div class='form-group '>
    <input class='form-control col-md-8' style="width:15%;margin-left:15px;" id='Designation' name="Designation" placeholder='Designation' type='text'>
                </div>
             </div>
             <div class="row" ><div class="col-md-3 col-md-offset-2" id="errordesignation" style="color:#F00;"></div></div>
          
         
            <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='id_checkin' style="text-align:left;">Date Of Birth</label>
            <div class='col-md-8'>
              <div class='col-md-5'>
                <div class='form-group internal input-group'>
              
               <input class='form-control datepicker' id="id_checkin" name="dob" class="form-control" style="margin-left:6px;">
                
                </div>
                
                <div class='col-md-15' id="errordob" style="color:#FF0000"></div>
              </div>
               
            </div>
          </div>
          
          
          <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='id_pets' style="text-align:left;">Gender</label>
           <div class='col-md-2' style="font-weight: 600;
color: #777;margin-left:8px;">
           <input type="radio" name="gender" id="gender1" value="Male"> 
                  Male
             </div>
             <div class='col-md-3' style="font-weight: 600;
color: #777;">
             <input type="radio" name="gender" id="gender2" value="Female">
            Female
              </div>
              
                <div class='col-md-2 indent-small' id="errorgender" style="color:#FF0000">
          </div>
          </div>
          
       
         <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='id_email' style="text-align:left;" >Contact</label>
            <div class='col-md-6'>
              <div class='form-group'>
                <div class='col-md-6'>
                  <input class='form-control' id='id_email' name="id_email" placeholder='E-mail' type='text'>
                </div>
                <div class='col-md-3 indent-small' id="erroremail" style="color:#FF0000">
                
              </div>
              </div>
              <div class='form-group '>
                <div class='col-md-6'>
                  <input class='form-control' id='phone' name="id_phone" placeholder='Mobile No' type='text' onChange="PhoneValidation(this);">
                </div>
                <div class='col-md-3 indent-small' id="errorphone" style="color:#FF0000">
                
              </div>
              </div>
            </div>
          </div>
         
        
        
         
           
          <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='id_comments' style="text-align:left;">Address</label>
            <div class='col-md-4'>
              <textarea class='form-control' id='id_address' name="address" placeholder='Address' rows='3'></textarea>
            </div>
            <div class='col-md-2 indent-small' id="erroraddress" style="color:#FF0000"></div>
          </div>
         <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' style="text-align:left;" >Country</label>
            <div class='col-md-3'>
                  <select id="country" name="country" class='form-control'></select>
                </div>
            
             
            <div class='col-md-3 indent-small' id="errorcountry" style="color:#FF0000"></div>
           </div>
        <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' style="text-align:left;">State</label>
            <div class='col-md-3'>
                  <select name="state" id="state" class='form-control'></select>
                </div>
            
              <div class='col-md-3 indent-small' id="errorstate" style="color:#FF0000"></div>

          </div>
          <script language="javascript">
            populateCountries("country", "state");
            populateCountries("country2");
        </script>
         <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='id_accomodation' style="text-align:left;" >City</label>
            <div class='col-md-3'>
              <input type="text" class='form-control' id='id_city' name="city" placeholder="City">
            </div>
            
             <div class='col-md-3 indent-small' id="errorcity" style="color:#FF0000"></div>
          </div>
       <div class='form-group'>
       <div class='col-md-1'></div>
        <div class='col-md-12'>
        
            
  
  
  </div>
          
           </div>
     
         <div class='form-group row'>
           <div class='col-md-2 col-md-offset-4' >
                 <input class='btn-lg btn-primary' type='submit' value="Submit" name="submit" onClick="return valid()" style="padding:5px;"/>
                </div>
                <div class='col-md-1'>
                    
      <a href="schoolAdminStaff_list.php"><input type="button" class='btn-lg btn-danger' value="Cancel" style="padding:5px;"/></a>
                    
                  </div>
          
          
        </form>
      </div>
      <div class='row' align="center"  style="color:#FF0000"><?php echo $report;?></div>
    </div>
  </div>
</body>