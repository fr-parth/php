<?php 
include("cookieadminheader.php");
$report="";
	$id=$_GET['sponserEditId'];	
		
   $getsponser=mysql_query("select * from tbl_sponsorer where id=".$id."");
          $result=mysql_fetch_array($getsponser);
		  $name=$result['sp_name'];
if(isset($_POST['submit']))
{

$name=$_POST['name'];
$email=$_POST['email'];
$phone=$_POST['mob'];
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

$city=$_POST['City'];
$company=$_POST['company'];
$Website=$_POST['Website'];



$prepAddr = str_replace(' ','+',$address);
					
					 $geocode=file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false');
				     $output= json_decode($geocode);	 
				    $lat = $output->results[0]->geometry->location->lat;
					$long = $output->results[0]->geometry->location->lng;
 

 

 
					$sql=mysql_query("update tbl_sponsorer set sp_name='$name',sp_email='$email',sp_phone='$phone',sp_address='$address',sp_country='$country',sp_state='$state',sp_city='$city',sp_company='$company',sp_website='$Website',lat='$lat',lon='$long' where id='$id'");
					
					if(mysql_affected_rows()>0)
{
//$report="Profile is successfully updated";
echo "<script type=text/javascript>alert('Profile is successfully updated'); window.location='sponsor_list.php'</script>";
}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href='css/datepicker.min.css' rel='stylesheet' type='text/css'>
<script src="js/city_state.js" type="text/javascript"></script>
<script src='js/bootstrap-datepicker.min.js' type='text/javascript'></script>
<script src='js/bootstrap-switch.min.js' type='text/javascript'></script>
<script src='js/bootstrap-multiselect.js' type='text/javascript'></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">
<script type="text/javascript" src="http://ajax.googleapis.com/
ajax/libs/jquery/1.5/jquery.min.js"></script>
  <script src="//code.jquery.com/ui/1.11.3/jquery-ui.js"></script>
  <script type="text/javascript">
  $(function() {

 $( "#date" ).datepicker({
      changeMonth: true,
      changeYear: true
    });
   
  });
  </script>
   <script>
  $(function() {
   
  });
  </script>
<script type="text/javascript" src="js/jquery.form.js"></script>

<script type="text/javascript">// < ![CDATA[
$(document).ready(function() 
{ 

$('#photoimg').live('change', function()	
{ 

$("#preview").html('');
$("#preview").html('<img src="image/loader.gif" alt="Uploading...."/>');
$("#imageform").ajaxForm(
{

target: '#preview'
}).submit();
});


  
});

function valid()
{
		var name=document.getElementById("name").value;
 		if(name==""||name==null)
 		{
   				document.getElementById("errorname").innerHTML = "Please enter name";
   				return false;
 		}
 
 var uname=document.getElementById("uname").value;
 		if(uname==""||uname==null)
 		{
   				document.getElementById("erroruname").innerHTML = "Please enter name";
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
 
 
  var address=document.getElementById("address").value;

	
        if(address==""||address==null)
		{
			document.getElementById("erroraddress").innerHTML = "Please Enter Adddress";
			return false;
   		
 		}
		
		    var city=document.getElementById("city").value;
			 var letters = /^[A-Za-z]+$/;
			if(city==""||city==null)
			{
				
			  
		     	document.getElementById('errorcity').innerHTML='Please enter city ';
						return false;
			
			}
			  else if(!letters.test(city))
			{
			   document.getElementById('errorcity').innerHTML='Please enter valid city ';
						return false;
			}
		
		
 
  var mobile=document.getElementById("phone").value;
 if(mobile==""||mobile==null)
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
    

}
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

<body style="background-color:#F8F8F8;">
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



<div class="row" ><div class="col-md-3"></div>
            	<div   id="preview"  class="col-md-3">
                <?php if($result['sp_img_path']!=""){?>
                <img src="<?php echo$result['sp_img_path'];?>"   style="border:1px solid #CCCCCC;height:90px;" class="img-responsive" alt="Responsive image"/>
        <?php }else {?> <img src="image/avatar_2x.png"  style="border:1px solid #CCCCCC;height:90px;" class="img-responsive" alt="Responsive image"/> <?php }?>
              </div>
                
              <div class="col-md-3"> <form id="imageform" method="post" enctype="multipart/form-data" action='ajax1.php'>
 <input type="file" name="photoimg" id="photoimg" value="<?=$result['sp_img_path']; ?>" />
</form>
             </div></div>

<form method="post">
<div class="row" style="padding-top:20px;">
<div class="col-md-5"><h4  align="left"> Name:</h4></div> 
<div class="col-md-5"><input type="text" name="name" id="name"  class="form-control" value="<?=$result['sp_name'];?>" /></div> 
</div>

<div class="row" align="center" id='errorname' style="color:#FF0000;"></div>


<div class="row" style="padding-top:5px;">
<div class="col-md-5"><h4  align="left"> Email ID:</h4></div> 
<div class="col-md-5"><input type="text" name="email" id="email" class="form-control" value="<?=$result['sp_email']?>"/></div> 
</div>
<div class="row" align="center" id='erroruname' style="color:#FF0000;"></div>

<div class="row" style="padding-top:5px;">
<div class="col-md-5"><h4  align="left"> Mobile No:</h4></div> 
<div class="col-md-5"> <input type="text" name="mob" id="mob" class="form-control" value="<?=$result['sp_phone']?>"/></div> 
</div>

<div class="row" align="center" id='errorpassword' style="color:#FF0000;"></div>

<div class="row" style="padding-top:5px;">
<div class="col-md-5"><h4  align="left"> Address:</h4></div> 
<div class="col-md-5"><textarea class="form-control" id="address" name="address" rows='3'><?=$result['sp_address']?> </textarea></div> 
<div class="row" align="center" id='errorcpassword' style="color:#FF0000;"></div>

<div class="row" style="padding-top:7px;" id="text_country" style="display:block">




<div class="col-md-5"><h4  align="left">Country:</h4></div> 
<div class="col-md-5"><input type="text" class='form-control' id="country1" name="country1" style="width:100%;" value="<?=$result['sp_country']?>" readonly="readonly" >
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
            
             
            <div class='col-md-3 indent-small' id="errorstate" style="color:#FF0000"><?php// echo $report4; ?></div>
         </div>
       


<div class="row" style="padding-top:7px;" id="text_state" style="display:block">
<div class="col-md-5"><h4  align="left"> State:</h4></div> 
<div class="col-md-5"> <input type="text" id="state1" name="state1"  class='form-control' style="width:100%;" value="<?=$result['sp_state']?>" readonly="readonly">


</div> 



</div>


  
         <script language="javascript">
            populateCountries("country", "state");
            populateCountries("country2");
        </script>


</div>
<div class="row" align="center" id='errorphone' style="color:#FF0000;"></div>

<div class="row" style="padding-top:5px;">
<div class="col-md-5"><h4  align="left"> City:</h4></div> 
<div class="col-md-5"><input type="text" name="City" id="City" class="form-control" value="<?=$result['sp_city']?>" /></div> 

</div>
<div class="row" align="center" id='errorphone' style="color:#FF0000;"></div>



<div class="row" style="padding-top:7px;">
<div class="col-md-5"><h4  align="left"> company:</h4></div> 
<div class="col-md-5"><input type="text" name="company" id="company"  class="form-control" value="<?=$result['sp_company']?>" /></div> 

</div>

<div class="row" align="center" id='errorcity' style="color:#FF0000;"></div>

<div class="row" style="padding-top:7px;">
<div class="col-md-5"><h4  align="left"> Website:</h4></div> 
<div class="col-md-5"><input type="text" name="Website" id="Website"  class="form-control" value="<?=$result['sp_website']?>" /></div> 

</div>

<div class="row" align="center" id='errorcity' style="color:#FF0000;"></div>


<div class="row" align="center" style="color:#FF0000;"> <?php echo $report;?></div>


<div class="row" style="padding-top:20px;">
<div class="col-md-3"></div>
<div class="col-md-3"> <input type="submit" value="Update" name="submit" class="btn btn-primary" onClick="return valid();" style="width:80%;" ></div>
<div class="col-md-3"><a href="sponsor_list.php" style="text-decoration:none;"> <input type="button" value="Cancel" name="cancel" class="btn btn-danger"></a></div>


</div>

     <div class="row" style="padding-top:20px;"></div>  
     </form>
        
  </div>      
</div>






</div>
</div>
</body>
</html>
