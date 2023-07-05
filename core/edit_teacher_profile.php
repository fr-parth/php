<?
include("scadmin_header.php");
if(isset($_GET['edit_id']))
	   { $t_id=$_GET['edit_id'];
		 $report="";					 
		
		
		if(isset($_POST['Update']))
		{
	      $t_id=$_GET['edit_id'];
	      $email = $_POST['id_email'];
		 
		//$row=mysql_query("select * from tbl_teacher where t_email like '$email' ");
	    //if(mysql_num_rows($row)<=0)
		//{
		$id_first_name = $_POST['id_first_name'];
		$id_last_name = $_POST['id_last_name'];
		$name=$id_first_name." ".$id_last_name;
	    $education =$_POST['id_education'];
		$experience=$_POST['experience'];
		$date = $_POST['dob'];
		
		
			
		$class = $_POST['class1'];
		$subject = $_POST['subject'];
		$email = $_POST['id_email'];
		$phone = $_POST['id_phone'];
		$gender=$_POST['gender'];
    	$address = $_POST['address'];
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

		$city = $_POST['city'];
		$dates = date('m/d/Y');
		
                            $password = $id_first_name."123";
		
		
		 list($month,$day,$year) = explode("/",$date);
           $year_diff  = date("Y") - $year;
            $month_diff = date("m") - $month;
            $day_diff   = date("d") - $day;
        if ($day_diff < 0 || $month_diff < 0) $year_diff--;
            $age= $year_diff;
	 $sqls= "update tbl_teacher set t_name='$name',t_exprience='$experience',t_qualification='$education',t_address='$address',t_city='$city',t_dob='$date',t_age='$age',t_gender='$gender',t_country='$country',t_email='$email',t_phone='$phone',state='$state' where id=".$t_id."";
		
	$count = mysql_query($sqls) or die(mysql_error()); 
		if($count>=1){
	$to=$email;
	$from="smartcookiesprogramme@gmail.com";
	$subject="Succesful Registration";
	$message="Hello ".$id_first_name." ".$id_last_name."\r\n\r\n".
		 "Thanks for registration with Smart Cookie as teacher\r\n".
		  "your Username is: ".$email."\n\n".
		  "your password is: ".$password."\n\n".
		  "your School ID is: ".$school_id."\n\n".
		  "Regards,\r\n".
   	      "Smart Cookie Admin";
		  
       mail($to, $subject, $message);
		
		$report="successfully updated"; 
		header("Location:teacherlist_sc.php");
		}
		}
		else
		{
		$report="Email ID is already present";
		}
	   
	//}
?>	
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

<!DOCTYPE html>
<head>
<style>
  body 
 {
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
				
					 var id_checkin=document.getElementById("id_checkin").value;
				if(id_checkin=="")
			{
	
			   
				document.getElementById('errordob').innerHTML='Please Enter Date of Birth';
				
				return false;
			}
		var experience=document.getElementById("experience").value; 
		if(experience==null||experience=="")
			{
			   
				document.getElementById('errorexperience').innerHTML='Please Enter Experience';
				
				return false;
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
				var atpos = email.indexOf("@");
				var dotpos = email.lastIndexOf(".");
				if (atpos< 1 || dotpos<atpos+2 || dotpos+2>=x.length) {
					document.getElementById('erroremail').innerHTML='Please enter valid Email Id';
					return false;
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
                                   <?php
								         
										 
								        $get_teacher=mysql_query("SELECT * FROM `tbl_teacher` WHERE id=".$t_id."");
									    $get_row_t=mysql_fetch_array($get_teacher);
										
										$name=explode(" ",$get_row_t['t_name']);
										   $name['0'];
										   $name['1'];
										     
                                   
								   ?>
<body>
  <div class='container' >
    <div class='panel panel-primary dialog-panel' style="background-color:#FFFFFF;background-image=""">
   <div style="color:red;font-size:15px;font-weight:bold;margin-top:10px;"> <?php if(isset($_GET['report'])){ echo $_GET['report']; };?></div>
      <div class='panel-heading'>
         
            <h3 align="center">Edit Teacher Setup</h3>
        
        
            <h5 align="center"><a href="Add_teacherSheet.php?id=<?=$school_id?>" >Add Excel Sheet</a></h5>
          </div>s
      <div class='panel-body'>
        <form class='form-horizontal' role='form' method="post">
        
        
        <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='id_title' style="text-align:left;">Teacher Name</label>
            <div class='col-md-8'>
            
              <div class='col-md-3 '>
                <div class='form-group internal'>
                  <input class='form-control' id='id_first_name' value="<?=$name['0'];?>" name="id_first_name" placeholder='First Name' type='text'>
                </div>
              </div>
              <div class='col-md-3 col-sm-offset-1'>
                <div class='form-group internal'>
                  <input class='form-control' id='id_last_name' value="<?=$name['1'];?>" name="id_last_name" placeholder='Last Name' type='text'>
                </div>
              </div>
              <div class='col-md-4 indent-small' id="errorname" style="color:#FF0000">
                
              </div>
            </div>
          </div>
        
                       <?php 
					         if(isset($get_row_t['t_qualification'])!="0")
	                       {
							   ?>
                                <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='id_service' style="text-align:left;">Education</label>
            <div class='col-md-2'>
              <select class='multiselect  form-control' id='id_service' name="id_education" >
              <option value='<?=$get_row_t['t_qualification']?>'><?=$get_row_t['t_qualification']?></option>
                <option value='BA'>BA</option>
                <option value='BCom'>BCom</option>
                <option value='BSc'>BSc</option>
                <option value='MA'>MA</option>
                <option value='MCom'>MCom</option>
                <option value='MSc'>MSc</option>
                <option value='B.ED'>B.ED</option>
                <option value='D.ED'>D.ED</option>
              </select>
            </div>
                               <?php
							   }
							   else
							   {
					           ?>
                 
           <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='id_service' style="text-align:left;">Education</label>
            <div class='col-md-2'>
              <select class='multiselect  form-control' id='id_service' name="id_education" >
                <option value='BA'>BA</option>
                <option value='BCom'>BCom</option>
                <option value='BSc'>BSc</option>
                <option value='MA'>MA</option>
                <option value='MCom'>MCom</option>
                <option value='MSc'>MSc</option>
                <option value='B.ED'>B.ED</option>
                <option value='D.ED'>D.ED</option>
              </select>
            </div>
             
                    <?php
	                   }
		            ?>
            
            <label class='control-label col-md-2 '>Experience</label>
            
              <div class='col-md-2'>
               
                  <input class='form-control col-md-8' id='experience' value="<?=$get_row_t['t_exprience']?>" name='experience' placeholder='Experience' type='text'>
              
              </div>
             <div class='col-md-2 indent-small' id="errorexperience" style="color:#FF0000"></div>
           
       
          </div>
          
         
            <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='id_checkin' style="text-align:left;">Date Of Birth</label>
            <div class='col-md-8'>
              <div class='col-md-5'>
                <div class='form-group internal input-group'>
              
               <input class='form-control datepicker' value="<?=$get_row_t['t_dob']?>" id="id_checkin" name="dob" class="form-control">
                
                </div>
                
                <div class='col-md-15' id="errordob" style="color:#FF0000"></div>
              </div>
               
            </div>
          </div>
          
          
          <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='id_pets' style="text-align:left;">Gender</label>
           <div class='col-md-2' style="font-weight: 600;
color: #777;">
           <input type="radio" name="gender" <?php echo ($get_row_t['t_gender']=="Male")?"checked":"" ?> id="gender1" value="Male"> 
                  Male
             </div>
             <div class='col-md-3' style="font-weight: 600;
color: #777;">
             <input type="radio" name="gender" <?php echo ($get_row_t['t_gender']=="Female")?"checked":"" ?> id="gender2" value="Female">
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
                  <input class='form-control' id='id_email' value="<?=$get_row_t['t_email']?>" name="id_email" placeholder='E-mail' type='text'>
                </div>
                <div class='col-md-3 indent-small' id="erroremail" style="color:#FF0000">
                
              </div>
              </div>
              <div class='form-group '>
                <div class='col-md-6'>
                  <input class='form-control' id='phone' name="id_phone" value="<?=$get_row_t['t_phone']?>" placeholder='Mobile No' type='text' onChange="PhoneValidation(this);">
                </div>
                <div class='col-md-3 indent-small' id="errorphone" style="color:#FF0000">
                
              </div>
              </div>
            </div>
          </div>
         <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='id_comments' style="text-align:left;">Address</label>
            <div class='col-md-4'>
              <textarea class='form-control' id='id_address'  name="address" placeholder='Address' rows='3'><?=$get_row_t['t_address']?></textarea>
            </div>
      <div class='col-md-2 indent-small' id="erroraddress" style="color:#FF0000"></div>
          </div>
        
       <div class="row" align="center" id='erroraddress' style="color:#FF0000;"></div>


<div class="row" style="padding-top:7px;" id="text_country" style="display:block">

<div class="col-md-5"><h4  align="left">Country:</h4></div> 
<div class="col-md-5"><input type="text" class='form-control' id="country1" name="country1" style="width:100%;" value="<?=$get_row_t['t_country']?>" readonly >
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
            
             
            <div class='col-md-3 indent-small' id="errorstate" style="color:#FF0000"><?php // echo $report4; ?></div>
         </div>
       


<div class="row" style="padding-top:7px;" id="text_state" style="display:block">
<div class="col-md-5"><h4  align="left"> State:</h4></div> 
<div class="col-md-5"> <input type="text" id="state1" name="state1"  class='form-control' style="width:100%;" value="<?=$get_row_t['state']?>" readonly>


</div> 



</div>
          <script language="javascript">
            populateCountries("country", "state");
            populateCountries("country2");
        </script>

         <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='id_accomodation' style="text-align:left;" >City</label>
            <div class='col-md-3'>
              <input type="text" class='form-control' value="<?=$get_row_t['t_city']?>" id='id_city' name="city" placeholder="City">
            </div>
             <div class='col-md-3 indent-small' id="errorcity" style="color:#FF0000"></div>
          </div>
      
          
          
           
          
         <div class='form-group row'>
           <div class='col-md-2 col-md-offset-4' >
   <input class='btn-lg btn-primary' type='submit' value="Update" name="Update" onClick="return valid()" style="padding:5px;"/>
                </div>
                
                 <div class='col-md-1'>
                    
       <a href="teacherlist_sc.php"><input type="button" class='btn-lg btn-danger' value="Cancel" name="cancel"  style="padding:5px;" /></a>
                    
                  </div>
          
          
          
          
          
          
        </form>
      </div>
      <div class='row' align="center"  style="color:#FF0000"><?php echo $report;?></div>
    </div>
  </div>
</body>