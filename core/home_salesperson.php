<?php
$report="";
$report1="";
include('salesperson_header.php');

$saleperson_id=$_SESSION['salespersonid'];
	if(isset($_POST['submit']))
	{
	
		$email = $_POST['id_email'];
		$phone=$_POST['id_phone'];
		$amount=$_POST['amount'];
							
		$amount1=$amount/100;
		   $date1="";
		   if($amount1!=0)
		   {
		
			$add_days = 365*$amount1;
			$date=date('m/d/Y');
			$date1 = date('m/d/Y',strtotime($date) + (24*3600*$add_days));
		
		   }
		   
		   if($amount1==0 || $amount=="")
		  {
		  $add_days = 15;
				$date=date('m/d/Y');
			$date1 = date('m/d/Y',strtotime($date) + (24*3600*$add_days));
			$amount="Free Registration";
		 
		  }
		$counts=0;
		//for sponsor
		
		  $row1=mysql_query("select * from tbl_sponsorer where sp_email='$email'");
		  if(mysql_num_rows($row1)>0)
		  {
		  $counts=1;
		  
		  }
		
		if($counts>0)
		{
		
			$report="email_id is already present";
		
		}
		
		
		$count1=0;
		//for sponsor
		
		  $row1=mysql_query("select * from tbl_sponsorer where sp_phone='$phone'");
		  if(mysql_num_rows($row1)>0)
		  {
		  $count1=1;
		  
		  }
		
		if($count1>0)
		{
		
			$report="Phone number already exist";
		
		}
		
		
		
		
				if($count1<=0 && $counts<=0)
				{
					
							 $company_name = $_POST['company_name'];
							
							
						 
							
							 $phone = $_POST['id_phone'];
							
							$address = $_POST['address'];
							 $password = $_POST['password'];
							 $country =mysql_real_escape_string( $_POST['country']);
							$state = mysql_real_escape_string($_POST['state']);
							$city = mysql_real_escape_string($_POST['city']);
							$dates = date('m/d/Y');
						   $country_code=$_POST['countrycode'];
							
							
				
				
				
					$prepAddr = str_replace(' ','+',$address);
					
					 $geocode=file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false');
				 $output= json_decode($geocode);	 
					$lat = $output->results[0]->geometry->location->lat;
					$long = $output->results[0]->geometry->location->lng;
					
				
					
					
					 $sqls= "INSERT INTO `tbl_sponsorer`(sp_company,sp_address, sp_city, sp_country, sp_email,  sp_date,lat,lon,sp_password,sp_phone,sp_state,sales_person_id,expiry_date,amount) VALUES ('$company_name','$address','$city','$country', '$email',  '$dates','$lat','$long','$password','$phone','$state','$saleperson_id','$date1','$amount')";
				
					$count = mysql_query($sqls) or die(mysql_error()); 
					
					
					
					
					//retrive current inserted record id
							$arr=mysql_query("select id,sp_company from tbl_sponsorer where sp_email like '$email' "); 
						$result=mysql_fetch_array($arr);
						$id=$result['id'];
						$sponsor_name=$result['sp_company'];
						
//update profile image of sales person


if($country_code=='91'){

/*Below query added by Rutuja for fetching dynamic values for user,password & sender for SMC-4989 on 02-12-2020*/
		$sql_dynamic= mysql_query("select * from tbl_otp where id=1");
		$dynamic_fetch= mysql_fetch_array($sql_dynamic);
		$dynamic_user = $dynamic_fetch['mobileno'];
		$dynamic_pass = $dynamic_fetch['email'];
		$dynamic_sender = $dynamic_fetch['otp'];	

							
 $Text="CONGRATULATIONS%21,+You+are+now+a+registered+User+of+Smart+Cookie+-+A+Student/Teacher+Rewards+Program.+Your+Username+is+".$email."+and+Password+is+".$password."."; 
$url="http://www.smswave.in/panel/sendsms.php?user=$dynamic_user&password=$dynamic_pass&sender=$dynamic_sender&PhoneNumber=$phone&Text=$Text";


				file_get_contents($url);
					
					
			}
			elseif($country_code=='1')		
			{
				include_once 'twilio.php';
				$ApiVersion = "2010-04-01";
				
				

	// set our AccountSid and AuthToken
	$AccountSid = "ACf8730e89208f1dfc6f741bd6546dc055";
	$AuthToken = "45e624a756b26f8fbccb52a6a0a44ac9";
    
	// instantiate a new Twilio Rest Client
	$client = new TwilioRestClient($AccountSid, $AuthToken);
	$number="+1".$phone;
	$message="CONGRATULATIONS!,Your are now registered user of Smartcookie 
	Your Username is ".$email." and Password is ".$password."."; 
				
				$response = $client->request("/$ApiVersion/Accounts/$AccountSid/SMS/Messages", 
			"POST", array(
			"To" => $number,
			"From" => "732-798-7878",
			"Body" => $message
		));

			} 
			
			
			
			
			$success = $error = false;

	// Object syntax looks better and is easier to use than arrays to me
	$post = new stdClass;
	
	// Usually there would be much more validation and filtering, but this
	// will work for now.
	
		
	// Check for blank fields
	
		
	
		// Get this directory, to include other files from
		$dir = dirname(__FILE__);
		
		// Get the contents of the pdf into a variable for later
		ob_start();
		require_once($dir.'/web_pdfforsales.php');
		$pdf_html = ob_get_contents();
		ob_end_clean();
		
		// Load the dompdf files
		require_once($dir.'/webservice/dompdf/dompdf_config.inc.php');
		
		$dompdf = new DOMPDF(); // Create new instance of dompdf
		$dompdf->load_html($pdf_html); // Load the html
		$dompdf->render(); // Parse the html, convert to PDF
		$pdf_content = $dompdf->output(); // Put contents of pdf into variable for later
		
		// Get the contents of the HTML email into a variable for later
		ob_start();
	
		
		
		$html_message="CONGRATULATIONS!,You are now a registered User of Smart Cookie,\r\n\r\n".
						    "A Student/Teacher Rewards Program\r\n".
						  "Your Username is: ".$email."\n\n".
						  "Your Password is: ".$password."\n\n".
						  "Regards,\r\n".
						  "Smart Cookie Admin \n"."www.smartcookie.in\r\n";
	
		// Load the SwiftMailer files
		require_once($dir.'/webservice/swift/swift_required.php');

		$mailer = new Swift_Mailer(new Swift_MailTransport()); // Create new instance of SwiftMailer

		$message1 = Swift_Message::newInstance()
				       ->setSubject('Smartcookie Registraion') // Message subject
					   ->setTo(array($email => $sponsor_name )) // Array of people to send to
					   ->setFrom(array('smartcookiesprogramme@gmail.com' => 'Smartcookie Registration')) // From:
					   ->setBody($html_message, 'text/html') // Attach that HTML message from earlier
					   ->attach(Swift_Attachment::newInstance($pdf_content, 'receipt.pdf', 'application/pdf')); // Attach the generated PDF from earlier
					   
					   
					   
					   	$html_message1="Hi, Please find attachment of Confirmation receipt of the sponsor";  
					   	$message = Swift_Message::newInstance()
				       ->setSubject('Smartcookie Registraion') // Message subject
					   ->setTo(array("cookieaccnt@gmail.com" => "Admin" )) // Array of people to send to
					   ->setFrom(array('smartcookiesprogramme@gmail.com' => 'Sponsor Registration')) // From:
					   ->setBody($html_message1, 'text/html') // Attach that HTML message from earlier
					   ->attach(Swift_Attachment::newInstance($pdf_content, 'receipt.pdf', 'application/pdf')); // Attach the generated PDF from earlier
		
				// Send the email, and show user message
		if ($mailer->send($message))
			$success = true;
		else
			$error = true;
		
		
			if ($mailer->send($message1))
			$success = true;
		else
			$error = true;


		// Send the email, and show user message
		

									$images= $_FILES['profileimage']['name'];
								
									$ex_img = explode(".",$images);
									  $img_name = $ex_img[0]."_".$id."_".date('mdY').".".$ex_img[1];
									  $full_name_path = "image_sponsor/".$img_name;
										move_uploaded_file($_FILES['profileimage']['tmp_name'],$full_name_path);
										
						   $sql="update  tbl_sponsorer set sp_img_path='$full_name_path' where id='$id'";
											   
												$count = mysql_query($sql) or die(mysql_error()); 
										

					
							if($count>=1){$report="Successfully Registered";}
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
 

    <link rel="stylesheet" href="css/bootstrap.css">
          
        
         
         <script>
       function valid()  
       {
	   //validaion for compnay name
	  
			
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
			
		
			
			
			if(isNaN(id_phone)|| id_phone.indexOf(" ")!=-1)
			  {			  
			       
				   document.getElementById('errorphone').innerHTML='Please Enter valid Phone no';
						   
						   return false; 
						   
				}
				
				
				
			
		
		
 
			
				
			
			
   //validation of country
  
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
       

         
         
 



</head>

<body>
<div id="head"></div>
<div id="login">

<!--<h1><strong>Welcome.</strong> Please register.</h1>-->
<form action="" method="post" enctype="multipart/form-data">
<div class='container' style="margin-top:10px;">
    <div class='panel panel-primary dialog-panel' style="background-color:radial-gradient(ellipse at center center , #E5E5E5 0%, #FFF 100%) repeat scroll 0% 0% transparent;">
   
         
         <div class="row">  <div class="col-md-5"></div><div  class="col-md-2"> <h3 >Registration </h3></div>
         
         <div class="col-md-5">
        
         
         </div>
         
        
        
        
           
  </div>
      <div class='panel-body'>
       
     
         <div class="row form-group">
          
            <label class='control-label col-md-3 col-md-offset-2' >Name <span class="style1">*</span></label>
           
           <div  id="catList"></div> 
           
                      <div class='col-md-3' >
                        <div class='form-group internal '>
                           <input class='form-control' id='company_name' name="company_name"  placeholder='Company Name' type='text' value="<?php if(isset($_POST['company_name'])){echo $_POST['company_name'];}?>">
                         
                        </div>
                    
                     </div>
                      
                  <div class='col-md-3 indent-small' id="errorname" style="color:#FF0000">
                    
                  </div>

             
             
         </div>
    
       
        
         
          
      <div class='row form-group'>
            	<label class='control-label col-md-3 col-md-offset-2' >Email ID<span class="style1"> *</span></label>
           
<div class='col-md-3 form-group internal'>
                  <input class='form-control' id='id_email' name="id_email"  placeholder='E-mail' type='text' value="<?php if(isset($_POST['id_email'])){echo $_POST['id_email'];}?>">
                </div>
              
                <div class='col-md-3 indent-small' id="erroremail" style="color:#FF0000"></div>
           </div>
                
             
<div class='row form-group'>
                   <label class='control-label col-md-3 col-md-offset-2' >Phone No.<span class="style1"> *</span></label>
                   <div class="col-md-2">
 						<select name="countrycode"  value=""  class="form-control">
                        <option value="91">91</option>
                        <option value="1">1</option>
                        </select>
                    </div>
                        <div class='col-md-3 form-group internal'>
                         <input class='form-control' id='id_phone' name="id_phone"  placeholder='Phone: (xxx) - xxx xxxx' type='text'  value="<?php if(isset($_POST['id_phone'])){echo $_POST['id_phone'];}?>" >
                          
                        </div>
              
                <div class='col-md-3 indent-small' id="errorphone" style="color:#FF0000"></div>
             
          </div>
          <div class="row form-group" id="addressdiv">
          	 <label class='control-label col-md-3 col-md-offset-2' >Address</label>
            <div class='col-md-3 '>
              <textarea class='form-control' id='id_address' name="address"  placeholder='Address' rows='3'> <?php if(isset($_POST['address'])){echo $_POST['address'];}?></textarea>
            </div>
            <div class='col-md-3 indent-small' id="erroraddress" style="color:#FF0000"></div>
          </div>
          
          
        <div class='row form-group' id="countrydiv">
            <label class='control-label col-md-3 col-md-offset-2' >Country <span class="style1">*</span></label>
    <div class='col-md-3'>
                  <select id="country" name="country" class='form-control' style="width:100%;" ></select>
                </div>
            
             
            <div class='col-md-3 indent-small' id="errorcountry" style="color:#FF0000"></div>
         </div>
         
         
      <div class='row form-group' id="statediv">
            <label class='control-label col-md-3 col-md-offset-2'>State<span class="style1">*</span></label>
            <div class='col-md-3'>
                  <select name="state" id="state" class='form-control' style="width:100%;" ></select>
        </div>
            
              <div class='col-md-3 indent-small' id="errorstate" style="color:#FF0000"></div>
        </div>
          <script language="javascript">
            populateCountries("country", "state");
            populateCountries("country2");
        </script>
        <div class='row form-group' id="citydiv">
            <label class='control-label col-md-3 col-md-offset-2' >City</label>
            <div class='col-md-3'>
              <input type="text" class='form-control' id='id_city' name="city" value=" <?php if(isset($_POST['city'])){echo $_POST['city'];}?>">
            </div>
             <div class='col-md-3 indent-small' id="errorcity" style="color:#FF0000"> </div>
          </div>
<div class='row form-group'>
                      <label class='control-label col-md-3 col-md-offset-2' >Password<span class="style1"> *</span></label>
<div class='col-md-3 form-group internal'>
                          <input class='form-control' id='password' name='password' placeholder='Password' type='password'  >
                        </div>
              
                
             
          </div>
<div class='row form-group'>
                      <label class='control-label col-md-3 col-md-offset-2' >Confirm Password <span class="style1">*</span></label>
<div class='col-md-3 form-group internal'>
                    <input class='form-control' id='cnfpassword' name="cnfpassword" placeholder='Confirm Password' type='password'  >
                        </div>
              
              <div class='col-md-3 indent-small' id="errorpassword" style="color:#FF0000"></div>
             
          </div>
          <div class='row form-group'>
                      <label class='control-label col-md-3 col-md-offset-2' >Amount<span class="style1">*</span></label>
<div class='col-md-3 form-group internal'>
                          <input class='form-control' id='amount' name="amount" placeholder='amount' type='text'  >
                        </div>
              
              <div class='col-md-3 indent-small' id="errorpassword" style="color:#FF0000"></div>
             
          </div>
           <div class='row form-group'>
                      <label class='control-label col-md-3 col-md-offset-2' >Profile Image<span class="style1">*</span></label>
<div class='col-md-3 form-group internal'>
                          <input  id='profileimage' name="profileimage"  type='file'  >
                        </div>
              
              <div class='col-md-3 indent-small' id="errorpassword" style="color:#FF0000"></div>
             
          </div>
          <div class='form-group row'>
           <div class='col-md-2 col-md-offset-4' >
                 <input class='btn-lg btn-primary' type='submit' value="Submit" name="submit" onClick="return valid()"/>
                </div>
                 <div class='col-md-1'>
                    
                     <a href="home_salesperson.php">   <button class='btn-lg btn-danger'  type='button' >Cancel</button></a>
                    
                  </div>
                
           
       
          </div>
          
          <div class="row" align="center" style="color:#F00;">
          <?php echo $report;?>
          </div>
       
         
        </form>
      </div>
     


</body>
</html>