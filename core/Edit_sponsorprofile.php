<?php 
include("sponsor_header.php");
$report="";
$report4="";
	
$id=$_GET['id'];	


if(isset($_POST['submit']))
{
	

$name=$_POST['name'];
$uname=$_POST['uname'];
$pass=$_POST['pass'];
$phone=$_POST['phone'];
$address=$_POST['address'];


if($_POST['country']==-1)
{
$country=$_POST['country1'];


}

else
{
$country=$_POST['country'];

}

if(isset($_POST['state']) && $_POST['state']!='')
{

$state=$_POST['state'];

}

else
{

$state=$_POST['state1'];

}


$city=$_POST['city'];
$date=$_POST['date'];
$pin=$_POST['pin_code'];



$address1=$address.",".$city.",".$state.",".$country;

$prepAddr = str_replace(' ','+',$address1);
					
					 $geocode=file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false');
				 $output= json_decode($geocode);	 
					$lat = $output->results[0]->geometry->location->lat;
					$long = $output->results[0]->geometry->location->lng;

					$sql=mysql_query("update tbl_sponsorer set sp_name='$name',sp_email='$uname', sp_password='$pass', sp_phone='$phone',sp_address='$address', sp_country='$country',sp_state='$state',sp_city='$city',sp_date='$date' ,lat='$lat', lon='$long',pin='$pin'  where id='$id'");
					
					if(mysql_affected_rows()>0)
{
$report="Profile is successfully updated";
header( "refresh:30;url=sponsor_profile.php");
	
}



}
	
?>





<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href='css/datepicker.min.css' rel='stylesheet' type='text/css'>
<script src='js/bootstrap-datepicker.min.js' type='text/javascript'></script>
  <script src='js/bootstrap-switch.min.js' type='text/javascript'></script>
  <script src='js/bootstrap-multiselect.js' type='text/javascript'></script>
   <link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">
   <script type="text/javascript" src="http://ajax.googleapis.com/
ajax/libs/jquery/1.5/jquery.min.js"></script>
  <script src="//code.jquery.com/ui/1.11.3/jquery-ui.js"></script>
  
   
<script type="text/javascript" src="js/jquery.form.js"></script>
<script src="js/city_state.js" type="text/javascript"></script>




<script>
function showOrhide()
{

if(document.getElementById("firstBtn"))
{

document.getElementById('text_country1').style.display="block";
document.getElementById('text_country').style.display="none";
document.getElementById('text_state1').style.display="block";
document.getElementById('text_state').style.display="none";
return false;
}


}

</script>



<script type="text/javascript">// < ![CDATA[
function valid()
{
		var name=document.getElementById("name").value;
 		if(name==""||name==null)
 		{
   				document.getElementById("errorname").innerHTML = "Please enter name";
   				return false;
 		}
		else
		{
		document.getElementById("errorname").innerHTML = "";
		}
		

		
		
 
 var uname=document.getElementById("uname").value;
 		if(uname==""||uname==null)
 		{
   				document.getElementById("erroruname").innerHTML = "Please enter Email ID";
   				return false;
 		}
 
 

	  
var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;  
			  if(!uname.match(mailformat))  
				{  
				document.getElementById('erroruname').innerHTML='Please Enter valid email ID';

				return false;  
				} 
	  
	  
	  else
	  
	  {
	   document.getElementById('erroruname').innerHTML='';
				
				
	  } 
       var id_checkin=document.getElementById("date").value;
       if(id_checkin=="")
        {
		

                 document.getElementById("errordate").innerHTML = "Please enter Date";
                 return false;
        }
 
 
       
 
 
 		

					
 var password=document.getElementById("pass").value;

 if(password==""||password==null){

   document.getElementById("errorpassword").innerHTML = "Please enter password";
   return false;
 }
 
 
 var cpassword=document.getElementById("con_pass").value;
 if(cpassword==""||cpassword==null)
 {

   document.getElementById("errorcpassword").innerHTML = "Please enter confirm password";
   return false;
 }
 
 
 
 if(password!=cpassword)
 {
 document.getElementById("errorcpassword").innerHTML = "Password and confirm password should match";
   return false;
 }
 
 else
 {
 document.getElementById("errorcpassword").innerHTML = "";
 }
 
 
 var mobile=document.getElementById("phone").value;
 if(mobile==""||mobile==null || mobile==0)
 {

   document.getElementById("errorphone").innerHTML = "Please enter Phone no.";
   return false;
 }
 
  var phoneno = /^\d{10}$/;  
  if(!mobile.match(phoneno))  
        {  
		 document.getElementById("errorphone").innerHTML = "Please enter valid Phone no.";
      return false;  
        }

else
{
document.getElementById("errorphone").innerHTML = "";
}

 
 
  var address=document.getElementById("address").value;

	   var uname = document.getElementById('uname');
    var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

    if (!filter.test(uname.value)) {
		document.getElementById("erroremail").innerHTML = "Please enter valid Email id.";
    uname.focus;
    return false;
 }
        if(address==""||address==null)
		{
document.getElementById("erroraddress").innerHTML = "Please Enter Adddress";
   return false;
   		
 		}
		else
		{
		document.getElementById("erroraddress").innerHTML = "";
		}
		
		
	
		 

//validation for city

var city=document.getElementById("city").value;
		
		if(city.length==0)
			{
			   
				document.getElementById('errorcity').innerHTML='Please Enter city';
				
				return false;
		
			
		}
		
		else
			{
			   
				document.getElementById('errorcity').innerHTML='';
				
							
		}
 
 
  
	  
	  
	  
	  			var pin=document.getElementById("pin_code").value;
					
 		if(pin==""|| pin==null || pin==0)
 		{
	
   				document.getElementById("errorpin").innerHTML ='Please enter ZIP code';
   				return false;
 		}
		else
	  
	  {
	   document.getElementById('errorpin').innerHTML='';
				
				
	  }
		
		  	
			if(isNaN(pin)|| pin.indexOf(" ")!=-1)
			  {			  
			       
				   document.getElementById('errorpin').innerHTML='Please Enter valid Zip Code';
						   
						   return false; 
						   
				}
				
				
					
				if (pin.length > 10 )
			{
              document.getElementById('errorpin').innerHTML='Please Enter valid Zip Code';
						   
						   return false; 
           }
		   else
		   {
		   document.getElementById('errorpin').innerHTML='';
		   }

	  
	  
	  
	  

 
		
    

}


</script>


  <script>
function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}

</script>

<script type="text/javascript"> 

$(document).ready(function() { 

$('#country').change(function() { 

	var  country=document.getElementById("country").value;
    
		if(country=='-1')
			{
			    
				document.getElementById('errorcountry').innerHTML='Please enter country';
				
				return false;
			}
	   
	  
	  

}); 
}); 
</script> 


<script type="text/javascript"> 

$(document).ready(function() { 

$('#state').change(function() { 

	var  state=document.getElementById("state").value;

 if(state==null|| state=="")
			{
			    
				document.getElementById('errorstate').innerHTML='Please enter State';
				
				return false;
			}
 
	else
	  
	  {
	   document.getElementById('errorstate').innerHTML='';
				
				
	  }
	  

}); 
}); 
</script> 



  
  <style>
  .preview
{
  
height:100px;

  width:100px;
}

textarea {
   resize: none;
}
  </style>
  
  
  
</head>

<body style="">

<div class="pad-top"></div>

<div class="container" style="padding:10px;" >
<div class="container">
       
        <div class="row" style=" border-bottom: thin solid #CCCCCC;" align="left">
        <h1 style="padding-left:20px; margin-top:2px;color: #666;
font-family: "Open Sans",sans-serif;
font-size: 12px;">Edit Profile</h1>
        </div>
        
</div>


<div class="container" style="padding-top:20px;">
<div class="row" >
<div class="col-md-3"></div>

<div class="col-md-7" style=" border: thin solid #CCCCCC;padding-top:20px; " align="center" >

<div class="row" align="center" ><h3>Update Profile</h3></div>

<form method="post">
<div class="row" style="padding-top:20px;">
<div class="col-md-5">
  <h4  align="left"> Company Name:</h4>
</div> 
<div class="col-md-5"><input type="text" name="name" id="name"  class="form-control" value="<?php if(isset($_POST['name'])){echo $_POST['name'];}else { echo $fname;}?>" /></div> 
</div>

<div class="row" align="center" id='errorname' style="color:#FF0000;"></div>


<div class="row" style="padding-top:5px;">
<div class="col-md-5"><h4  align="left"> Email:</h4></div> 
<div class="col-md-5"><input type="text" name="uname" id="uname" class="form-control" value="<?php if(isset($_POST['uname'])){echo $_POST['uname'];}else { echo $email;}?>"/></div> 
</div>
<div class="row" align="center" id='erroremail' style="color:#FF0000;"></div>
<div class="row" align="center" id='erroruname' style="color:#FF0000;"></div>

<div class="row" style="padding-top:5px;">
<div class="col-md-5"><h4  align="left"> Password:</h4></div> 
<div class="col-md-5"> <input type="password" name="pass" id="pass" class="form-control" value="<?php if(isset($_POST['pass'])){echo $_POST['pass'];}else { echo $password;}?>"/></div> 
</div>

<div class="row" align="center" id='errorpassword' style="color:#FF0000;"></div>

<div class="row" style="padding-top:5px;">
<div class="col-md-5"><h4  align="left">Confirm Password:</h4></div> 
<div class="col-md-5"> <input type="password" name="con_pass" id="con_pass" class="form-control" value="<?php if(isset($_POST['pass'])){echo $_POST['pass'];}else { echo $password;}?>"/></div> 
</div>
<div class="row" align="center" id='errorcpassword' style="color:#FF0000;"></div>

<div class="row" style="padding-top:5px;">
<div class="col-md-5"><h4  align="left"> Phone No:</h4></div> 
<div class="col-md-5"><input type="text" name="phone" id="phone" class="form-control" value="<?php if(isset($_POST['phone'])){echo $_POST['phone'];}else { echo $phone;}?>"  onkeypress="return isNumberKey(event)"/></div> 

</div>
<div class="row" align="center" id='errorphone' style="color:#FF0000;"></div>

<div class="row" style="padding-top:5px;">
<div class="col-md-5"><h4  align="left"> Address:</h4></div> 
<div class="col-md-5"><textarea class="form-control" id="address" name="address" rows='3'><?php if(isset($_POST['address'])){echo $_POST['address'];}else { echo $address;}?> </textarea></div> 

</div>

<div class="row" align="center" id='erroraddress' style="color:#FF0000;"></div>


<div class="row" style="padding-top:7px;" id="text_country" style="display:block">

<div class="col-md-5"><h4  align="left"> Country:</h4></div> 
<div class="col-md-5">   <input type="text" class='form-control' id="country1" name="country1" style="width:100%;" value=" <?php  echo $country;?>" readonly="readonly" >



</div>
<div class="col-md-1" id="firstBtn"><a href="" onclick="return showOrhide()">Edit</a></div>
   
</div>

        <div class='row ' style="padding-top:7px; display:none" id="text_country1">
            <div class="col-md-5"><h4  align="left">Country </h4></div> 
    <div class='col-md-5'>
                  <select id="country" name="country" class='form-control' ></select>
                </div>
            
             
            <div class='col-md-3 indent-small' id="errorcountry" style="color:#FF0000"></div>
         </div>
         
         


<div class='row ' style="padding-top:7px; display:none" id="text_state1">
            <div class="col-md-5"><h4  align="left">State </h4></div> 
    <div class='col-md-5'>
                  <select id="state" name="state" class='form-control' ></select>
                </div>
            
             
            <div class='col-md-3 indent-small' id="errorstate" style="color:#FF0000"><?php echo $report4; ?></div>
         </div>
       


<div class="row" style="padding-top:7px;" id="text_state" style="display:block">
<div class="col-md-5"><h4  align="left"> State:</h4></div> 
<div class="col-md-5"> <input type="text" id="state1" name="state1"  class='form-control' style="width:100%;" value=" <?php  echo $state;?>" readonly="readonly">


</div> 



</div>


  
         <script language="javascript">
            populateCountries("country", "state");
            populateCountries("country2");
        </script>

 

<div class="row" style="padding-top:7px;">
<div class="col-md-5"><h4  align="left"> City:</h4></div> 
<div class="col-md-5"><input type="text" name="city" id="city"  class="form-control"  value="<?php if(isset($_POST['city'])){echo $_POST['city'];}else { echo $city;}?>" /></div> 
   <div class='col-md-3 indent-small' id="errorcity" style="color:#FF0000"> </div>
</div>



<div class="row" style="padding-top:7px;">
<div class="col-md-5"><h4  align="left"> ZIP Code:</h4></div> 
<div class="col-md-5"><input type="text" name="pin_code" id="pin_code"  class="form-control"  value="<?php if(isset($_POST['pin'])){echo $_POST['pin'];}else { echo $pin;}?>"  onkeypress="return isNumberKey(event)" /></div> 
   <div class='col-md-4 indent-small' id="errorpin" style="color:#FF0000"> </div>
</div>


<div class="row" style="padding-top:5px;">
<div class="col-md-5"><h4  align="left"> Reg. Date:</h4></div> 
<div class="col-md-5"><input class='form-control' id='date' name="date" value="<?php  echo $reg_date;?>"readonly="readonly" /></div> 

</div>
<div class="row" align="center" id='errordate' style="color:#FF0000;"></div>

<div class="row" align="center" style="color:#FF0000;"> <?php if($report){echo $report;}?></div>


<div class="row" style="padding-top:20px;">
<div class="col-md-3"></div>
<div class="col-md-3"> <input type="submit" value="Update" name="submit" class="btn btn-primary" onClick="return valid();" style="width:80%;" ></div>
<div class="col-md-3"><a href="coupon_accept.php" style="text-decoration:none;"> <input type="button" value="Cancel" name="cancel" class="btn btn-danger"></a></div>


</div>

     <div class="row" style="padding-top:20px;"></div>  
     </form>
        
  </div>      
</div>






</div>
</div>

</body>
</html>
