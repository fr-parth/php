<?php
$report="";
$report1="";
include('conn.php');
	if(isset($_POST['submit']))
	{
	$user_type=$_POST['entity'];
	$email = $_POST['id_email'];
		$phone=$_POST['id_phone'];
		$counts=0;
		//for sponsor
		if($user_type==4)
		{
		  $row1=mysql_query("select * from tbl_sponsorer where sp_email='$email'");
		  if(mysql_num_rows($row1)>0)
		  {
		  $counts=1;
		  
		  }
		}
		else if($user_type==3)
		{
		  $row1=mysql_query("select * from tbl_student where std_email='$email'");
		  if(mysql_num_rows($row1)>0)
		  {
		  $counts=1;
		  
		  }
		
		}
		else if($user_type==1)
		{
		  $row1=mysql_query("select * from tbl_school_admin where email='$email'");
		  if(mysql_num_rows($row1)>0)
		  {
		  $counts=1;
		  
		  }
		
		}else if($user_type==2)
		{
		
		  $row1=mysql_query("select * from tbl_teacher where t_email='$email'");
		  if(mysql_num_rows($row1)>0)
		  {
		  $counts=1;
		  
		  }
		
		}else if($user_type==5)
		{
		  $row1=mysql_query("select * from tbl_parent where email_id='$email'");
		  if(mysql_num_rows($row1)>0)
		  {
		  $counts=1;
		  
		  }
		
		}
		else if($user_type==6)
		{
			
			 $row1=mysql_query("select * from tbl_salesperson where p_email='$email'");
		  if(mysql_num_rows($row1)>0)
		  {
		  $counts=1;
		  
		  }
			
		}
		if($counts>0)
		{
		
			$report="email_id is already present";
		
		}
		
		
		$count1=0;
		//for sponsor
		if($user_type==4)
		{
		  $row1=mysql_query("select * from tbl_sponsorer where sp_phone='$phone'");
		  if(mysql_num_rows($row1)>0)
		  {
		  $count1=1;
		  
		  }
		}
		else if($user_type==3)
		{
		  $row1=mysql_query("select * from tbl_student where std_phone='$phone'");
		  if(mysql_num_rows($row1)>0)
		  {
		  $count1=1;
		  
		  }
		
		}
		else if($user_type==1)
		{
		  $row1=mysql_query("select * from tbl_school_admin where mobile='$phone'");
		  if(mysql_num_rows($row1)>0)
		  {
		  $count1=1;
		  
		  }
		
		}else if($user_type==2)
		{
		 
		  $row1=mysql_query("select * from tbl_teacher where t_phone='$phone'");
		  if(mysql_num_rows($row1)>0)
		  {
		  $count1=1;
		  
		  }
		
		}else if($user_type==5)
		{
		  $row1=mysql_query("select * from tbl_parent where Phone='$phone'");
		  if(mysql_num_rows($row1)>0)
		  {
		  $count1=1;
		  
		  }
		
		}
		else if($user_type==6)
		{
		  $row1=mysql_query("select * from tbl_salesperson where p_phone='$phone'");
		  if(mysql_num_rows($row1)>0)
		  {
		  $count1=1;
		  
		  }
		
		}
		if($count1>0)
		{
		
			$report="Phone number already exist";
		
		}
		
		
		
		elseif(($counts==0)&&($count1==0)){
				
					if($user_type==4)
					{
							$company_name = $_POST['company_name'];
							
							
						 
							
							$phone = $_POST['id_phone'];
							//$gender=$_POST['gender1'];
							$address = $_POST['address'];
							 $password = $_POST['password'];
							$country =mysql_real_escape_string( $_POST['country']);
							$state = mysql_real_escape_string($_POST['state']);
							 $city = mysql_real_escape_string($_POST['city']);
							$dates = date('m/d/Y');
							
						
							
					}
					else if($user_type==6)
					{
						    $id_first_name = $_POST['id_first_name'];
							$id_last_name = $_POST['id_last_name'];
							$name=$id_first_name." ".$id_last_name;
							$password = $_POST['password'];
							$phone = $_POST['id_phone'];
						
					}
					else
					{
					
							$id_first_name = $_POST['id_first_name'];
							$id_last_name = $_POST['id_last_name'];
							$name=$id_first_name." ".$id_last_name;
						    $dob = $_POST['dob'];
						  
							 $password = $_POST['password'];
							$phone = $_POST['id_phone'];
							$gender=$_POST['gender'];
							$address = $_POST['address'];
							$country = mysql_real_escape_string($_POST['country']);
							$state = mysql_real_escape_string($_POST['state']);
							 $city = mysql_real_escape_string($_POST['city']);
							$dates = date('m/d/Y');
							
						
							 list($month,$day,$year) = explode("/",$dob);
								$year_diff  = date("Y") - $year;
								$month_diff = date("m") - $month;
								$day_diff   = date("d") - $day;
									if ($day_diff < 0 || $month_diff < 0) $year_diff--;
										$age= $year_diff;
										
										
					}
					
				if($user_type==3)
				{ 
				 if($age>0)
				 {
				
				
				
						  //calculate latitude and longitude from city country and state of student 
							$address1=$city+","+$state+","+$country;
							 $prepAddr = str_replace(' ','+',$address1);
							 $geocode=file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false');
							 $output= json_decode($geocode);
							$lat = $output->results[0]->geometry->location->lat;
							$long = $output->results[0]->geometry->location->lng;
							
							
							
						
							
							
							 //insert into student database
							 $sql="INSERT INTO tbl_student(std_name, std_address, std_city, std_dob,std_age, std_gender, std_country, std_email, std_date,std_phone,std_state,latitude,longitude,std_password) VALUES ('$name', '$address', '$city', '$date','$age', '$gender', '$country', '$email', '$dates','$phone','$state','$lat','$long','$password')";
							$count = mysql_query($sql) or die(mysql_error()); 
							//retrive current inserted record id
							$arr=mysql_query("select id from tbl_student ORDER BY id DESC limit 1"); 
							$result=mysql_fetch_array($arr);
					if($count>=1){$report="successfully updated"; header("Location:create_account_2.php?user_type=".$user_type."& id=".$result['id']);}
					}
					
					else
					{
					$report1="Birthdate is invalid";
					}
					
					
				}
				else if($user_type==2)
				{
				
				
				if($age>0)
				 {
				
				
					  $sqls= "INSERT INTO `tbl_teacher`(t_name,t_address, t_city, t_dob, t_gender,t_age, t_country, t_email,  t_date,state,t_phone,t_password) VALUES ('$name','$address','$city','$date','$gender','$age' ,'$country', '$email',  '$dates','$state','$phone','$password')";
				$count = mysql_query($sqls) or die(mysql_error()); 
					  //retrive current inserted record id
					$arr=mysql_query("select id from tbl_teacher ORDER BY id DESC limit 1"); 
						$result=mysql_fetch_array($arr);
						if($count>=1){$report="successfully updated"; header("Location:create_account_2.php?user_type=".$user_type."& id=".$result['id']);}
						
						
						}
						
						
						else
						
						{
						$report1="Birthdate is invalid";
						
						}
				
				
				}
				else if($user_type==1)
				{
				
			
				 if($age>0)
				 {
				
				 
				
					 $sqls= "INSERT INTO `tbl_school_admin`(name,address, scadmin_city,scadmin_dob, scadmin_gender,scadmin_age, scadmin_country, email,  reg_date,scadmin_state,mobile,password) VALUES ('$name','$address','$city','$dob','$gender','$age' ,'$country', '$email',  '$dates','$state','$phone','$password')";
					 $count = mysql_query($sqls) or die(mysql_error()); 
					// $sqls= "INSERT INTO `tbl_school`(school_name,school_address,school_email,date,password) VALUES ('$name','$address', '$email',  '$dates','$password')";
					 //$count = mysql_query($sqls) or die(mysql_error()); 
					 
					 //retrive current inserted record id
						  $arr=mysql_query("select id from tbl_school_admin ORDER BY id DESC limit 1"); 
						$result=mysql_fetch_array($arr);
							if($count>=1){$report="successfully updated"; header("Location:create_account_2.php?user_type=".$user_type."& id=".$result['id']);}
							
				}
				
				else
				{
				$report1="Birthdate is invalid";
				}			
							
				}
				else if($user_type==4)
				{
				
					$prepAddr = str_replace(' ','+',$address);
					
					 $geocode=file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false');
				 $output= json_decode($geocode);	 
					$lat = $output->results[0]->geometry->location->lat;
					$long = $output->results[0]->geometry->location->lng;
					
					
					
					
					 $sqls= "INSERT INTO `tbl_sponsorer`(sp_name,sp_address, sp_city, sp_country, sp_email,  sp_date,lat,lon,sp_password) VALUES ('$company_name','$address','$city','$country', '$email',  '$dates','$lat','$long','$password')";
					$count = mysql_query($sqls) or die(mysql_error()); 
					
					//retrive current inserted record id
							$arr=mysql_query("select id from tbl_sponsorer ORDER BY id DESC limit 1"); 
						$result=mysql_fetch_array($arr);
							if($count>=1){$report="successfully updated"; header("Location:create_account_2.php?user_type=".$user_type."& id=".$result['id']);}
				}
				else if($user_type==5)
				{
				
				 if($age>0)
				 {
				
				 
						 $sqls= "INSERT INTO `tbl_parent`(Name,Address, DateOfBirth, Gender,Age, country,email_id,  reg_date,state,city,phone,Password) VALUES ('$name','$address','$date','$gender','$age' ,'$country', '$email',  '$dates','$state','$city','$phone','$password')";
					$count = mysql_query($sqls) or die(mysql_error()); 
							//retrive current inserted record id
								$arr=mysql_query("select id from tbl_parent ORDER BY id DESC limit 1"); 
							$result=mysql_fetch_array($arr);
					
					
							if($count>=1){
								$from="smartcookiesprogramme@gmail.com";
								$to=$email;
								$subject="Successful Registration";
								$message="We are pleased to inform that you are part of SmartCookie Student/Teacher Rewards Program\r\n".
									   "your User ID is: "  .$email.  "\n\n".
									  "& your password is: ".$password."\n".
									  "Please visit www.smartcookie.in for more details"."\r\n".
									  "Regards,\r\n".
									  "Smart Cookie Admin";
									     mail($to, $subject, $message);

								
								$report="successfully updated"; header("Location:create_account_2.php?user_type=".$user_type."& id=".$result['id']);	}
				}
				else
				{
				$report1="Birthdate is invalid";
				}	
				
				
				}
				else if($user_type==6)
				{
					$sqls= "INSERT INTO `tbl_salesperson`(p_name,p_email, p_phone, p_password) VALUES ('$name', '$email',  '$phone','$password')";
					$count = mysql_query($sqls) or die(mysql_error()); 
							//retrive current inserted record id
						
								$arr=mysql_query("select person_id from tbl_salesperson where  p_email like '$email'"); 
							$result=mysql_fetch_array($arr);
					
					
							if($count>=1){$report="successfully updated";
						 header("Location:create_account_2.php?user_type=".$user_type."& id=".$result['person_id']);	}
					
					
				}
				else
				{
					  echo "Please select User Type";
				
				
				}
      }
			
		
		
	
	   
	}
?>
<html>
<head>
<meta charset="utf-8">
<title>Smart Cookies</title>
<link href='css/datepicker.min.css' rel='stylesheet' type='text/css'>
 <script src='js/jquery.min.js' type='text/javascript'></script>
  <script src='js/bootstrap.min.js' type='text/javascript'></script>
  <link rel="stylesheet" href="css/bootstrap.min.css">
<!-- <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>-->
<script src="js/city_state.js" type="text/javascript"></script>
<style>
textarea {
   resize: none;
}
</style>
 

<script src='js/bootstrap-datepicker.min.js' type='text/javascript'></script>
   <!-- Bootstrap CSS and bootstrap datepicker CSS used for styling the demo pages-->
       <!-- <link rel="stylesheet" href="css/datepicker.css">-->
        <link rel="stylesheet" href="css/bootstrap.css">
          <script type="text/javascript">
            // When the document is ready
            $(document).ready(function () {
                
                $('#dob').datepicker({
                  
                });  
            
            });
        </script>
        
        
         
         <script>
       function valid()  
       {
	   //validaion for compnay name
	   var entity=document.getElementById("entity").value;
	    if(document.getElementById("entity").value==4)
			{
			
				var company_name=document.getElementById("company_name").value;
				if(company_name==null|| company_name=="")
				{
					document.getElementById('errorname').innerHTML='Please enter company name';
					return false;
				}
				else
				{
		 			document.getElementById('errorname').innerHTML='';
					
				}
			
			}
	   // validation for name
	   
	
	   
	   var first_name=document.getElementById("id_first_name").value;
	  
	   var last_name=document.getElementById("id_last_name").value;
	   
	   
	   		if(first_name==null||first_name=="" || last_name==null|| last_name=="" )
			{
			   
				document.getElementById('errorname').innerHTML='Please enter Name';
				
				return false;
			}
			
			
			regx1=/^[A-z ]+$/;
				//validation for name
				if(!regx1.test(first_name) || !regx1.test(last_name))
				{
				document.getElementById('errorname').innerHTML='Please enter valid Name';
					return false;
				}
			
			
			else
			{
			
			document.getElementById('errorname').innerHTML='';
				
						
			}
			
			
			
			
				//date of birth
		if(entity!=6)
		{
		var dob=document.getElementById("dob").value;
		
		
		

			
					 var myDate = new Date(dob);
				var today = new Date();
				if(dob=="")
			{
	
			   
				document.getElementById('errorbirth').innerHTML='Please Enter Date of Birth';
				
				return false;
			}
			else if(myDate.getFullYear()>=today.getFullYear())
				{
					
					if(myDate.getFullYear()==today.getFullYear())
				   {
					
						if(myDate.getMonth()==today.getMonth())
						{
							if(myDate.getDate()>=today.getDate())
							{
								
							document.getElementById("errorbirth").innerHTML ="please enter valid birth date";
						return false;
							}	
							else
							{
								document.getElementById("errorbirth").innerHTML ="";
							}
							
							
						}	
						else if(myDate.getMonth()>today.getMonth())
						{
							document.getElementById("errordob").innerHTML ="please enter valid birth date";
						return false;
							
						}
						else
				           {
							   document.getElementById("errorbirth").innerHTML ="";
							 }
				   }
				   else 
				   {
					   document.getElementById("errorbirth").innerHTML ="please enter valid birth date";
						return false;
					   
					 }
					 
				   
				}
					  else
					  {
						   document.getElementById("errorbirth").innerHTML ="";
						  
						 }
			
			//validation for gender
			 var gender1=document.getElementById("gender1").checked;
 	   var gender2=document.getElementById("gender2").checked;
			
	   if(gender1==false && gender2==false)
	  {
	            document.getElementById('errorgender').innerHTML='Please Select gender';
				return false;
	  }		
			
		else
		{	
		document.getElementById('errorgender').innerHTML='';
			}
	
		}
			
			
			// validation for email
	  
	   var email=document.getElementById("id_email").value;
		if(email==null||email=="")
			{
			   
				document.getElementById('erroremail').innerHTML='Please enter email ID';
				
				return false;
			}	
	  
	  
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
			
	// validation of phone
	
	var id_phone=document.getElementById("id_phone").value;
			
			if(id_phone=="")
			{
			   
				document.getElementById('errorphone').innerHTML='Please Enter Phone no';
				
				return false;
			}
			
			
			
			if(isNaN(id_phone)|| id_phone.indexOf(" ")!=-1)
			  {			  
			       
				   document.getElementById('errorphone').innerHTML='Please Enter valid Phone no';
						   
						   return false; 
						   
				}
				
				
				
				if (id_phone.length > 10 )
			{
              document.getElementById('errorphone').innerHTML='Please Enter valid Phone no';
						   
						   return false; 
           }
		   
		   
		   if (id_phone.length < 10 )
			{
              document.getElementById('errorphone').innerHTML='Please Enter valid Phone no';
						   
						   return false; 
           }
		   
		   else
	  
	  {
	   document.getElementById('errorphone').innerHTML='';
				
				
	  }
		
		
 
			
		   		
			
			
   //validation of country
   if(entity!=6)
   {
	  	var  country=document.getElementById("country").value;
     
	
		if(country=='-1')
			{
			    
				document.getElementById('errorcountry').innerHTML='Please enter country';
				
				return false;
			}
	   
	  
	   else
	  
	  {
	   document.getElementById('errorcountry').innerHTML='';
				
				
	  }
	  
	  
	  
 
 //validation of state
 
 var  state=document.getElementById("state").value;
 
 if(state==null||state=="")
			{
			   
				document.getElementById('errorstate').innerHTML='Please enter state';
				
				return false;
			}	
 
 
	else
	  
	  {
	   document.getElementById('errorstate').innerHTML='';
				
				
	  }
			

//validation for city

var city=document.getElementById("id_city").value;
		
		if(city.length==0)
			{
			   
				document.getElementById('errorcity').innerHTML='Please Enter city';
				
				return false;
		
			
		}
	
	   
   }
	 
	     var password=document.getElementById("password").value;
	  var cnfpassword=document.getElementById("cnfpassword").value;	
	  	
		if(password==null||password=="")
			{
			   
				document.getElementById('errorpassword').innerHTML='Please Enter Password';
				
				return false;
		
			
		}
	  
	  
	  if(cnfpassword==null||cnfpassword=="")
			{
			   
				document.getElementById('errorpassword').innerHTML='Please Enter Confirm Password';
				
				return false;
		
			
		}
	  
		if(password!=cnfpassword)
			{
			   
				document.getElementById('errorpassword').innerHTML='Password does not match with confirm password';
				
				return false;
			}
			
			else
			
			{
			document.getElementById('errorpassword').innerHTML='';
			}
	   
	   
	   
	   
	   
	   
	   
	   
	   
	   
	   }
	   
	   
	   
       </script>
       

         
         
 
<script type="text/javascript">

$(document).ready(function(){
		$('#entity').change(function(){
		
		  
		 if(document.getElementById("entity").value==4)
			{
  			  $('#genderdiv').hide();
			  $('#datediv').hide();
			  $('#id_last_name').hide();
			    
			   $('#id_first_name').hide();
 			 }
		else if(document.getElementById("entity").value==6)
			  {
				   $('#genderdiv').hide();
			  $('#datediv').hide();
			  $('#citydiv').hide();
			  $('#countrydiv').hide();
			  $('#statediv').hide();
			   $('#addressdiv').hide();
			   $('#id_last_name').show();
			   $('#id_first_name').show();
				  }
		 else{
			 $('#genderdiv').show();
			  $('#datediv').show();
			  $('#id_last_name').show();
			  	  $('#id_first_name').show();
				   $('#citydiv').show();
			  $('#countrydiv').show();
			  $('#statediv').show();
			   $('#addressdiv').show();
			 
			 }
		});
	});

</script>

<script type="text/javascript"> 

	
	
$(document).ready(function() { 

$('#entity').change(function() { 

var num = $('#entity').val(); 

var html = ''; //string variable for html code for fields 

if(num==4) { 
 
html +=  ' <div class="col-md-3" >  <div class="form-group internal "> <input class="form-control" type="text" id="company_name"  name="company_name" placeholder="Company Name" value="<?php if(isset($_POST['company_name'])){echo $_POST['company_name'];}?>" /></div></div>'; 
} 

//insert this html code into the div with id catList 
$('#catList').html(html); 
}); 
}); 
</script> 


<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style>
</head>

<body>
<div id="head"></div>
<div id="login">
<div class="page-header" style="background-color:black;color:white;text-align:center; padding:4px;">
  <h1>Welcome to::Smart Cookie  <small><font color="wheat">Please Register here....</small></h1></font>
</div>
<!--<h1><strong>Welcome.</strong> Please register.</h1>-->
<form action="" method="post">
<div class='container'>
    <div class='panel panel-primary dialog-panel' style="background-color:radial-gradient(ellipse at center center , #E5E5E5 0%, #FFF 100%) repeat scroll 0% 0% transparent;">
   <div style="color:red;font-size:15px;font-weight:bold;margin-top:10px;background-color:radial-gradient(ellipse at center center , #E5E5E5 0%, #FFF 100%) repeat scroll 0% 0% transparent;" align="center"> <?php echo $report;?></div>
      <div class='panel-heading' style="background-color:radial-gradient(ellipse at center center , #E5E5E5 0%, #FFF 100%) repeat scroll 0% 0% transparent;">
         
         <div class="row">  <div class="col-md-5"></div><div  class="col-md-2"> <h3 >Registration </h3></div>
         
         <div class="col-md-5">
        
         
         </div>
         
         </div>
        
        
           
  </div>
      <div class='panel-body'>
        <form class='form-horizontal' role='form' method="post">
       <div class="row form-group" >
        
                <label class='control-label col-md-3 col-md-offset-1' >User Type <span class="style1">*</span></label>
                <div class='col-md-3'>
                        <div class='form-group internal '>
                                <select required name="entity" id='entity' class='form-control' >
                                <?php if(isset($_POST['entity'])){
								      if($_POST['entity']=="1")
									  {?>
									  <option value="1">School admin</option>
									 <?php }
									  if($_POST['entity']=="2")
									  {?>
									  <option value="2">Teacher</option>
									 <?php  }
									  if($_POST['entity']=="3")
									  {?>
									  	  <option value="3" >Student</option>
									  <?php }
									  if($_POST['entity']=="4")
									  {?>
									  	<option value="4">Sponsorer</option>
									  <?php }
									  if($_POST['entity']=="5")
									  {?>
									  	<option value="5" selected="selected">Parent</option>
									<?php }
								
								
								
								} ?>
                                <option value="3" >Student</option><option value="1">School admin</option><option value="2">Teacher</option><option value="4">Sponsor</option><option value="5" selected="selected">Parent</option>
                              </select>
                        </div>
               </div>
         </div>
         
         <div class="row form-group">
          
            <label class='control-label col-md-3 col-md-offset-1' >Name <span class="style1">*</span></label>
           
           <div  id="catList"></div> 
           
                      <div class='col-md-3' >
                        <div class='form-group internal '>
                           <input class='form-control' id='id_first_name' name="id_first_name" required placeholder='First Name' type='text' value="<?php if(isset($_POST['id_first_name'])){echo $_POST['id_first_name'];}?>">
                         
                        </div>
                    
                     </div>
                      <div class='col-md-3 indent-small' >
                            <div class='form-group internal '>
                            
                              <input class='form-control' id='id_last_name' name="id_last_name" required placeholder='Last Name' type='text' value="<?php if(isset($_POST['id_last_name'])){echo $_POST['id_last_name'];}?>">
                              
                              
                             
                            </div>
                  </div>
                  <div class='col-md-2 indent-small' id="errorname" style="color:#FF0000">
                    
                  </div>

             
             
         </div>
    
        <div class="row form-group" id="datediv">
          
            <label class='control-label col-md-3 col-md-offset-1' >Date of Birth <span class="style1">*</span></label>
           
      <div class='col-md-3'>
                <div class='form-group internal'>
                
              <input  type="text" class='form-control' placeholder="Date of Birth" name="dob" id="dob" value="<?php if(isset($_POST['dob'])){echo $_POST['dob'];}?>">
                </div>
            
             </div>
             
              <div class='col-md-3 indent-small' id="errorbirth" style="color:#FF0000"></div>
              <div class='col-md-3 indent-small'  style="color:#FF0000"><?php echo $report1;?></div>
         </div>
        
          <div class='row form-group' id='genderdiv'>
            <label class='control-label col-md-3 col-md-offset-1'>Gender<span class="style1"> *</span></label>
             <?php if(isset($_POST['gender'])){
           if($_POST['gender']=="Male"){?>
   <div class='col-md-1'>
          
                     Male <input type="radio" name="gender" id="gender1" value="Male" checked >
                     </div>
                     <div class='col-md-2'>
                     Female <input type="radio" name="gender" id="gender2" value="Female">
                      </div>
              <?php }else{?>
           <div class='col-md-1'>
          
                     Male <input type="radio" name="gender" id="gender1" value="Male"  >
                     </div>
                     <div class='col-md-2'>
                     Female <input type="radio" name="gender" id="gender2" value="Female" checked>
                      </div>
              <?php }
			  }
              else
              {?>
                  <div class='col-md-1'>
              
                   <input type="radio" name="gender" id="gender1" value="Male" > Male
                     </div>
                     <div class='col-md-2'>
                     <input type="radio" name="gender" id="gender2" value="Female"> Female 
                      </div>
              
              
           <?php   }?>
                <div class='col-md-3 indent-small' id="errorgender" style="color:#FF0000"> </div>
          </div>
          
      <div class='row form-group'>
            	<label class='control-label col-md-3 col-md-offset-1' >Email ID<span class="style1"> *</span></label>
           
<div class='col-md-3 form-group internal'>
                  <input class='form-control' id='id_email' name="id_email"  placeholder='E-mail' type='text' value="<?php if(isset($_POST['id_email'])){echo $_POST['id_email'];}?>">
                </div>
              
                <div class='col-md-3 indent-small' id="erroremail" style="color:#FF0000"></div>
           </div>
                
             
<div class='row form-group'>
                   <label class='control-label col-md-3 col-md-offset-1' >Phone No.<span class="style1"> *</span></label>
                        <div class='col-md-3 form-group internal'>
                         <input class='form-control' id='id_phone' name="id_phone"  placeholder='Phone: (xxx) - xxx xxxx' type='text'  value="<?php if(isset($_POST['id_phone'])){echo $_POST['id_phone'];}?>" >
                          
                        </div>
              
                <div class='col-md-3 indent-small' id="errorphone" style="color:#FF0000"></div>
             
          </div>
          <div class="row form-group" id="addressdiv">
          	 <label class='control-label col-md-3 col-md-offset-1' >Address</label>
            <div class='col-md-3 '>
              <textarea class='form-control' id='id_address' name="address"  placeholder='Address' rows='3'> <?php if(isset($_POST['address'])){echo $_POST['address'];}?></textarea>
            </div>
            <div class='col-md-3 indent-small' id="erroraddress" style="color:#FF0000"></div>
          </div>
          
          
        <div class='row form-group' id="countrydiv">
            <label class='control-label col-md-3 col-md-offset-1' >Country <span class="style1">*</span></label>
    <div class='col-md-3'>
                  <select id="country" name="country" class='form-control' style="width:100%;" value=" <?php if(isset($_POST['country'])){echo $_POST['country'];}?>"></select>
                </div>
            
             
            <div class='col-md-3 indent-small' id="errorcountry" style="color:#FF0000"></div>
         </div>
         
         
      <div class='row form-group' id="statediv">
            <label class='control-label col-md-3 col-md-offset-1'>State<span class="style1">*</span></label>
            <div class='col-md-3'>
                  <select name="state" id="state" class='form-control' style="width:100%;" value=" <?php if(isset($_POST['state'])){echo $_POST['state'];}?>"></select>
        </div>
            
              <div class='col-md-3 indent-small' id="errorstate" style="color:#FF0000"></div>
        </div>
          <script language="javascript">
            populateCountries("country", "state");
            populateCountries("country2");
        </script>
        <div class='row form-group' id="citydiv">
            <label class='control-label col-md-3 col-md-offset-1' >City</label>
            <div class='col-md-3'>
              <input type="text" class='form-control' id='id_city' name="city" value=" <?php if(isset($_POST['city'])){echo $_POST['city'];}?>">
            </div>
             <div class='col-md-3 indent-small' id="errorcity" style="color:#FF0000"> </div>
          </div>
<div class='row form-group'>
                      <label class='control-label col-md-3 col-md-offset-1' >Password<span class="style1"> *</span></label>
<div class='col-md-3 form-group internal'>
                          <input class='form-control' id='password' name='password' placeholder='Password' type='password'  >
                        </div>
              
                
             
          </div>
<div class='row form-group'>
                      <label class='control-label col-md-3 col-md-offset-1' >Confirm Password <span class="style1">*</span></label>
<div class='col-md-3 form-group internal'>
                          <input class='form-control' id='cnfpassword' name="cnfpassword" placeholder='Confirm Password' type='password'  >
                        </div>
              
              <div class='col-md-3 indent-small' id="errorpassword" style="color:#FF0000"></div>
             
          </div>
          <div class='form-group row'>
           <div class='col-md-2 col-md-offset-3' >
                 <input class='btn-lg btn-primary' type='submit' value="Next" name="submit" onClick="return valid()"/>
                </div>
                 <div class='col-md-1'>
                    
                     <a href="login.php">   <button class='btn-lg btn-danger'  type='submit' >Cancel</button></a>
                    
                  </div>
                
           
       
          </div>
          
       
         
        </form>
      </div>
     


</body>
</html>