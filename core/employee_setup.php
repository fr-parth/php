<?php
        if(isset($_GET['student_id']))
		{ 
		$report="";
	    include_once("school_staff_header.php");
		if(isset($_POST['update']))
	    {
	    $stuID=$_GET['student_id'];
	            
				
				
		$roll_no=$_POST['roll_no'];
		$id_first_name = $_POST['id_first_name'];
		$id_first_name1 = $_POST['id_first_name1'];
		$id_last_name1 = $_POST['id_last_name1'];
		$father_name=$id_first_name1." ".$id_last_name1;
		$id_email = $_POST['id_email'];
	    $id_phone = $_POST['id_phone'];
		$id_checkin = $_POST['id_checkin'];
		$id_gender = $_POST['gender'];
		$id_address = $_POST['id_address'];
		
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
			
			
	   $class = $_POST['class'];
	   	$city = $_POST['city'];
	   	$div = $_POST['div'];
        $id_date = date('m/d/Y');
    	$id_first_name=trim($id_first_name);
        $password = $id_first_name."123";
 
		
		
		 list($month,$day,$year) = explode("/",$id_checkin);
    $year_diff  = date("Y") - $year;
    $month_diff = date("m") - $month;
    $day_diff   = date("d") - $day;
    if ($day_diff < 0 || $month_diff < 0) $year_diff--;
  $age= $year_diff;
  
	$prepAddr = str_replace(' ','+',$id_address);
							$geocode=file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false');
							$output= json_decode($geocode);
							$lat = $output->results[0]->geometry->location->lat;
							$long = $output->results[0]->geometry->location->lng;
							
					
							
	 $update= "update tbl_student set Roll_no='$roll_no',std_name='$id_first_name',std_Father_name='$father_name',std_class='$class',std_div='$div', std_address='$id_address', std_city='$city',std_dob='$id_checkin', std_gender='$id_gender', std_country='$country', std_email='$id_email',std_age='$age',latitude='$lat',longitude='$long',std_phone='$id_phone',std_state='$state' where id=".$stuID."";
	  
	$result_update = mysql_query($update) or die(mysql_error()); 
					if($result_update>=1){
		
    $to=$id_email;
	$from="smartcookiesprogramme@gmail.com";
	$subject="Succesful Registration";
	
	$message="Hello ".$id_first_name." ".$id_last_name."\r\n\r\n".
		 "Thanks for your registration with Smart Cookie as student\r\n".
		  "your Username is: "  .$id_email.  "\n\n".
		  "your Password is: ".$password."\n\n".
		  "your School ID is: ".$school_id."\n\n".
		  "Regards,\r\n".
   	      "Smart Cookie Admin";
		  
      mail($to, $subject, $message);
		 $studentname="student";
		$report="successfully Registered"; 
		header("Location:studentlist.php?name=".$studentname);
		}
	//	}
		else
		{
		$report="Email ID is already present";
		
		}
	  }
	//}
?>

<!DOCTYPE html>
<head>
  
  <link href='css/datepicker.min.css' rel='stylesheet' type='text/css'>
  <script src='js/bootstrap-datepicker.min.js' type='text/javascript'></script>
  <script src='js/bootstrap-switch.min.js' type='text/javascript'></script>
  <script src='js/bootstrap-multiselect.js' type='text/javascript'></script>
    <script>
function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}

</script>
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
  <style>
  body {
   background-color:#F8F8F8;
   }
  .indent-small {
	  margin-left: 5px;
}.form-group.internal {
  margin-bottom: 0;}
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
<script src="js/city_state.js" type="text/javascript"></script>
<script>
$(document).ready(function() {  
  $('.multiselect').multiselect();
  $('.datepicker').datepicker();  
});

<?php /*?> var reg = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;  
      function PhoneValidation(phoneNumber)
      {  
        var OK = reg.exec(phoneNumber.value);  
        if (!OK)  
         document.getElementById('errorphone').innerHTML='Please Enter Valid Phone Number';
		 return false;
       
      }<?php */?>
function valid()
	{
		 
	
		var roll_no=document.getElementById("roll_no").value;
		
		
		
		if(roll_no==null)
			{
			   
				document.getElementById('errorrollno').innerHTML='Please Enter Roll No';
				
				return false;
			}
		
		regx1=/^[A-z ]+$/;
				//validation for name
				if(!regx1.test(first_name) || !regx1.test(last_name))
				{
				document.getElementById('errorrollno').innerHTML='Please Enter valid Name';
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
	
		
		
		var email=document.getElementById("id_email").value;
		if(email==null||email=="")
			{
			   
				document.getElementById('erroremail').innerHTML='Please Enter email';
				
				return false;
			}
			
			  //validation of email
				var atpos = email.indexOf("@");
				var dotpos = email.lastIndexOf(".");
				if (atpos< 1 || dotpos<atpos+2 || dotpos+2>=email.length) {
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
			else
			{
				document.getElementById('errorstate').innerHTML='';
				
			}	
		var city=document.getElementById("id_city").value;
		
		if(city==null||city=="" )
			{
			   
				document.getElementById('errorcity').innerHTML='Please Enter city';
				
				return false;
			}
			else if(!regx1.test(city))
			{
				document.getElementById('errorcity').innerHTML='Please Enter city';
				
				return false;
				
			}
			else
			{
				document.getElementById('errorcity').innerHTML='';
				
				
				
			}
			
		}
</script>

</head>
<body>

<div class='panel panel-primary dialog-panel'>
    <div style="color:red;font-size:15px;font-weight:bold;margin-top:5px;" class="col-md-offset-6"> <?php if(isset($_GET['report'])){ echo $_GET['report']; };echo $report;?></div>
    <div class='panel-heading'>
        <h3 align="center">Edit Student Registration</h3>
       <!-- <h5 align="center"><a href="Add_studentSheet.php?id=<?//=$studentID?>">Add Excel Sheet</a></h5>-->
        <h5 align="center"><a href="Add_studentSheet_20150626PT.php?id=<?=$studentID?>">Add Excel Sheet</a></h5>
      </div>
                                               <?php
                                                    $studentID=$_GET['student_id'];
													$get_std_id=mysql_query("select * from tbl_student where id=".$studentID."");
													$row=mysql_fetch_array($get_std_id);
													    $row['id'];
											   ?>
      <div class='panel-body'>
        <form class='form-horizontal' role='form' method="post" action="" onSubmit="return valid()">
        
        		<div class='form-group'>
           			 <label class='control-label col-md-2 col-md-offset-2' style="text-align:left;">Roll No</label>
            	
              		
                	 <div class='col-md-2' style="text-align:left;">
                 	 <input class='form-control' id='roll_no' name="roll_no" placeholder='Enter Roll No' type='text' onKeyPress="return isNumberKey(event)"></div>
                	
                     <div class='col-md-3 ' id="errorrollno" style="color:#FF0000"> </div>
                 </div>
               <div class="row">
                 	<label class='control-label col-md-2 col-md-offset-2'  style="text-align:left;">Student Name</label>
                 	 <div class='col-md-2' style="text-align:left;">
                	 <input class='form-control' id='id_first_name' value="<?=$row['std_name'];?>" name="id_first_name" placeholder='First Name' type='text'>
                  
              	     </div>
                 </div>
                                                                      <?php
                                                                            $fathrName=explode(" ",$row['std_Father_name']);
																			
																	  ?>
    			 <div class='form-group'>
            	  </div>
                	<div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2'  style="text-align:left;">Father Name</label>
            <div class='col-md-3 ' style="text-align:left;">
                
                  <input class='form-control' id='id_first_name_f'name="id_first_name1" value="<?=$fathrName['0'];?>" placeholder='First Name' type='text'>
              </div>
              
              <div class='col-md-3 '>
                 <input class='form-control' id='id_last_name_f' name="id_last_name1" value="<?=$fathrName['1'];?>" placeholder='Last Name' type='text'>
              </div>   
          </div>

 <div class='col-md-8 col-md-offset-4' id="errorfatname" style="color:#FF0000"></div>
				     
       <div class="form-group">
            <label class='control-label col-md-2 col-md-offset-2'  style="text-align:left;" >Class</label>
            
                         
               
                <div class='col-md-2' style="text-align:left;">
                  <input class='form-control' id="id_class" value="<?=$row['std_class'];?>" name="class" placeholder='Enter Class' type='text'>
                </div>
          
            <label class='control-label col-md-1'  style="text-align:left;">Division</label>
            
              
                <div class='col-md-2' style="text-align:left;">
                  <input class='form-control' id='id_div' name="div" value="<?=$row['std_div'];?>"  placeholder='Enter Division' type='text'>
                </div>
               </div>
                <div class='col-md-10 col-md-offset-3' id="errordiv" style="color:#FF0000"></div>
           <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2'  for='id_email'  style="text-align:left;">Contact</label>
           <div class='col-md-3' style="text-align:left;">
                  <input class='form-control' id='id_email' name="id_email" value="<?=$row['std_email'];?>" placeholder='E-mail' type='text'>
                </div>
                <div class='col-md-3'>
                  <input class='form-control' id='id_phone' name="id_phone" value="<?=$row['std_phone'];?>" placeholder='Mobile No' type='text' onChange="PhoneValidation(this);">
                </div>
          </div>
         <div class='col-md-10 col-md-offset-4' id="errorphone" style="color:#FF0000"></div>

			<div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2'  style="text-align:left;">Date Of Birth</label>
            <div class='col-md-3' style="text-align:left;">
             <input class='form-control datepicker' id='id_checkin'  value="<?=$row['std_dob'];?>" name="id_checkin" placeholder='mm/dd/yyyy'>
             </div>
         </div>
<div class='col-md-10 col-md-offset-3 ' id="errordob" style="color:#FF0000"></div>
    <div class='form-group'>
              <label class='control-label col-md-2 col-md-offset-2'  style="text-align:left;">Gender</label>
     <div class='col-md-2'  style="font-weight: 600;color: #777;">
             <input type="radio" name="gender" <?php echo ($row['std_gender']=="Male")?"checked":"" ?> id="gender1" value="Male"> Male
             </div>
             <div class='col-md-2'  style="font-weight: 600; color: #777;">
             <input type="radio" name="gender" <?php echo ($row['std_gender']=="Female")?"checked":"" ?> id="gender2" value="Female"> Female
              </div>
            <div class='col-md-4 indent-small' id="errorgender" style="color:#FF0000"> </div>
             </div>
             
       <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' style="text-align:left;">Address</label>
            <div class='col-md-3' style="text-align:left;">
              <textarea class='form-control' id='id_address' name="id_address" placeholder='Address' rows='3'><?=$row['std_address'];?></textarea>
            </div>
            
            
            
            
         <div class="row" align="center" id='erroraddress' style="color:#FF0000;"></div>
<div class="row" style="padding-top:7px;" id="text_country" style="display:block">
<div class="col-md-5"><h4  align="left">Country:</h4></div> 
<div class="col-md-5"><input type="text" class='form-control' id="country1" name="country1" style="width:100%;" value="<?=$row['std_country'];?>" readonly >
</div>
<div class="col-md-1" id="firstBtn"><a href="" onClick="return showOrhide()">Edit</a></div>
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
<div class="col-md-5"> <input type="text" id="state1" name="state1"  class='form-control' style="width:100%;" value="<?=$row['std_state']?>" readonly>
</div> 
</div>     <script language="javascript">
            populateCountries("country", "state");
            populateCountries("country2");
        </script>
<div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2'  style="text-align:left;">City</label>
            <div class='col-md-3' style="text-align:left;">
              <input type="text" class='form-control' id='id_accomodation' value="<?=$row['std_city'];?>" name='city' placeholder="city">
            </div>
            <div class='col-md-4 indent-small' id="errorcity" style="color:#FF0000"></div>
          </div>
          
          <script>
function goBack() {
    window.history.back(-2);
}
</script>
        <div class='form-group'>
           <div class='col-md-3 col-md-offset-3' >
                 <input class='btn-lg btn-primary' type='submit' value="Update" name="update" onClick="return valid()" />
           </div>
                 <div class='col-md-2'>
                    <button class='btn-lg btn-danger' onClick="goBack()" type='submit'>Cancel</button>
                 </div>
          </div>
  </form>
      </div>
</div>
</body>
</html>
<?php
	}
		else if(isset($_GET['id']))
	  {
		  $report="";
	  include_once("school_staff_header.php");
	  

	if(isset($_POST['submit']))
	{
		
	   $roll_no=$_POST['roll_no'];
		$id_first_name = $_POST['id_first_name'];
		//echo "</br>id_last_name-->".$id_last_name = $_POST['id_last_name'];
		
	//	echo "</br>name-->".$name = $id_first_name." ".$id_last_name;
		
		$id_first_name1 = $_POST['id_first_name1'];
		$id_last_name1 = $_POST['id_last_name1'];
		$father_name=$id_first_name1." ".$id_last_name1;
		//retrive school_id and name school_admin
		
		   
        $results=mysql_query("select * from tbl_school_adminstaff where id=".$_GET['id']."");
        $arrs=mysql_fetch_array($results);

		$school_id=$arrs['school_id'];
		
		$r=mysql_query("select * from tbl_school where id=".$school_id."");
        $ar=mysql_fetch_array($r);
		
		$school_name=$ar['school_name'];
		$sc_staff_id=$arrs['id'];
		$id_email = $_POST['id_email'];
		
		$arr=mysql_query("select * from tbl_student where std_email like '$id_email'");
		if(mysql_num_rows($arr)<=0)
		{
		$id_phone = $_POST['id_phone'];
		/*$id_password = $_POST['id_password'];*/
		$id_checkin = $_POST['id_checkin'];
		$id_gender = $_POST['gender'];
		/*$id_education = $_POST['id_education'];*/
		$id_address = $_POST['id_address'];
	    $id_country = $_POST['id_country'];
	    $id_state = $_POST['state'];
	    $class = $_POST['class'];
	   	$city = $_POST['city'];
	   	$div = $_POST['div'];
        $id_date = date('m/d/Y');
    	$id_first_name=trim($id_first_name);
        $password = $id_first_name."123";
 
		
		
		 list($month,$day,$year) = explode("/",$id_checkin);
    $year_diff  = date("Y") - $year;
    $month_diff = date("m") - $month;
    $day_diff   = date("d") - $day;
    if ($day_diff < 0 || $month_diff < 0) $year_diff--;
  $age= $year_diff;
  
	$prepAddr = str_replace(' ','+',$id_address);
							$geocode=file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false');
							$output= json_decode($geocode);
							$lat = $output->results[0]->geometry->location->lat;
							$long = $output->results[0]->geometry->location->lng;
						
							
	 $sqls= "INSERT INTO tbl_student(Roll_no,std_name,std_Father_name,std_school_name,school_id,sc_staff_id,std_class,std_div, std_address, std_city, std_dob, std_gender, std_country,std_email,std_date,std_age,std_password,latitude,longitude,std_phone,std_state) VALUES ('$roll_no','$id_first_name','$father_name', '$school_name','$school_id','$sc_staff_id','$class','$div','$id_address','$city','$id_checkin','$id_gender','$id_country','$id_email', '$id_date','$age','$password','$lat','$long','$id_phone','$id_state')";
	 
	$result_insert = mysql_query($sqls) or die(mysql_error()); 
					if($result_insert>=1){
		
  $to=$id_email;
	$from="smartcookiesprogramme@gmail.com";
	$subject="Succesful Registration";
	
	$message="Hello ".$id_first_name." ".$id_last_name."\r\n\r\n".
		 "Thanks for your registration with Smart Cookie as student\r\n".
		  "your Username is: "  .$id_email.  "\n\n".
		  "your Password is: ".$password."\n\n".
		  "your School ID is: ".$school_id."\n\n".
		  "Regards,\r\n".
   	      "Smart Cookie Admin";
		  
      mail($to, $subject, $message);
		
		$report="successfully Registered"; 
		
		
		//header("Location:student_setup.php?report=".$report);
		}
		}
		else
		{
		$report="Email ID is already present";
		
		}
	  }
	//}
?>

<!DOCTYPE html>
<head>
  
  <link href='css/datepicker.min.css' rel='stylesheet' type='text/css'>
  <script src='js/bootstrap-datepicker.min.js' type='text/javascript'></script>
  <script src='js/bootstrap-switch.min.js' type='text/javascript'></script>
  <script src='js/bootstrap-multiselect.js' type='text/javascript'></script>
  <style>
  body {
   background-color:#F8F8F8;
   }
  .indent-small {
	  margin-left: 5px;
}.form-group.internal {
  margin-bottom: 0;}
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
<script src="js/city_state.js" type="text/javascript"></script>
    <script>
function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}

</script>
<script>
$(document).ready(function() {  
  $('.multiselect').multiselect();
  $('.datepicker').datepicker();  
});

<?php /*?> var reg = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;  
      function PhoneValidation(phoneNumber)
      {  
        var OK = reg.exec(phoneNumber.value);  
        if (!OK)  
         document.getElementById('errorphone').innerHTML='Please Enter Valid Phone Number';
		 return false;
       
      }<?php */?>
function valid()
	{
		
	
		var roll_no=document.getElementById("roll_no").value;
		
		
		
		if(roll_no==null)
			{
			   
				document.getElementById('errorrollno').innerHTML='Please Enter Roll No';
				
				return false;
			}
		
		regx1=/^[A-z ]+$/;
				//validation for name
				if(!regx1.test(first_name) || !regx1.test(last_name))
				{
				document.getElementById('errorrollno').innerHTML='Please Enter valid Name';
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
<body>

<div class='panel panel-primary dialog-panel'>
    <div style="color:red;font-size:15px;font-weight:bold;margin-top:5px;" class="col-md-offset-6"> <?php if(isset($_GET['report'])){ echo $_GET['report']; };echo $report;?></div>
    <div class='panel-heading'>
        <h3 align="center">Student Registration</h3>
        <h5 align="center"><a href="Add_studentSheet.php" >Add Excel Sheet</a></h5>
      </div>
      
      <div class='panel-body'>
        <form class='form-horizontal' role='form' method="post" action="" onSubmit="return valid()">
        
        		<div class='form-group'>
           			 <label class='control-label col-md-2 col-md-offset-2' style="text-align:left;">Roll No</label>
            	
              		
                	 <div class='col-md-2' style="text-align:left;">
                 	 <input class='form-control' id='roll_no' name="roll_no" placeholder='Enter Roll No' type='text' onKeyPress="return isNumberKey(event)"></div>
                	
                     <div class='col-md-3 ' id="errorrollno" style="color:#FF0000"> </div>
                 </div>
               <div class="row">
                 	<label class='control-label col-md-2 col-md-offset-2'  style="text-align:left;">Student Name</label>
                 	 <div class='col-md-2' style="text-align:left;">
                	 <input class='form-control' id='id_first_name' name="id_first_name" placeholder='First Name' type='text'>
                  
              	     </div>
                 </div>
               
    			 <div class='form-group'>
            	  </div>
                	<div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2'  style="text-align:left;">Father Name</label>
            <div class='col-md-3 ' style="text-align:left;">
                
                  <input class='form-control' id='id_first_name_f'name="id_first_name1" placeholder='First Name' type='text'>
              </div>
              
              <div class='col-md-3 '>
                 <input class='form-control' id='id_last_name_f' name="id_last_name1" placeholder='Last Name' type='text'>
              </div>   
          </div>

 <div class='col-md-8 col-md-offset-4' id="errorfatname" style="color:#FF0000"></div>
				     
       <div class="form-group">
            <label class='control-label col-md-2 col-md-offset-2'  style="text-align:left;" >Class</label>
            
                         
               
                <div class='col-md-2' style="text-align:left;">
                  <input class='form-control' id="id_class" name="class" placeholder='Enter Class' type='text'>
                </div>
          
            <label class='control-label col-md-1'  style="text-align:left;">Division</label>
            
              
                <div class='col-md-2' style="text-align:left;">
                  <input class='form-control' id='id_div' name="div" placeholder='Enter Division' type='text'>
                </div>
               </div>
                <div class='col-md-10 col-md-offset-3' id="errordiv" style="color:#FF0000"></div>
           <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='id_email'  style="text-align:left;">Contact</label>
           <div class='col-md-3' style="text-align:left;">
                  <input class='form-control' id='id_email' name="id_email" placeholder='E-mail' type='text'>
                </div>
                <div class='col-md-3'>
                  <input class='form-control' id='id_phone' name="id_phone" placeholder='Mobile No' type='text' onChange="PhoneValidation(this);">
                </div>
          </div>
         <div class='col-md-10 col-md-offset-4' id="errorphone" style="color:#FF0000"></div>

			<div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2'  style="text-align:left;">Date Of Birth</label>
            <div class='col-md-3' style="text-align:left;">
             <input class='form-control datepicker' id='id_checkin' name="id_checkin" placeholder='mm/dd/yyyy'>
             </div>
         </div>
<div class='col-md-10 col-md-offset-3 ' id="errordob" style="color:#FF0000"></div>
    <div class='form-group'>
              <label class='control-label col-md-2 col-md-offset-2'  style="text-align:left;">Gender</label>
     <div class='col-md-2'  style="font-weight: 600;color: #777;">
             <input type="radio" name="gender" id="gender1" value="Male"> Male
             </div>
             <div class='col-md-2'  style="font-weight: 600; color: #777;">
             <input type="radio" name="gender" id="gender2" value="Female"> Female
              </div>
            <div class='col-md-4 indent-small' id="errorgender" style="color:#FF0000"> </div>
             </div>
       <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' style="text-align:left;">Address</label>
            <div class='col-md-3' style="text-align:left;">
              <textarea class='form-control' id='id_address' name="id_address" placeholder='Address' rows='3'></textarea>
            </div>
            <div class='col-md-4 indent-small' id="erroraddress" style="color:#FF0000"></div>
       </div>
          <div class="form-group">
            <label class='control-label col-md-2 col-md-offset-2'  style="text-align:left;">Country</label>
           <div class='col-md-3' style="text-align:left;">
                 <select id="country" name="id_country" class='form-control'>
                  <option value='select'>select</option></select>
                </div>
            <label class='control-label col-md-1 '  style="text-align:left;">State</label>
                <div class='col-md-3' style="text-align:left;">
            <select name='state' id='state' class='form-control'> <option value='select'>select</option>
            </select>
                </div>
       </div> 
          <div class='col-md-10 indent-small col-md-offset-4' id="errorstate" style="color:#FF0000">  </div>
<script language="javascript">
            populateCountries("country", "state");
            populateCountries("country2");
        </script>

<div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2'  style="text-align:left;">City</label>
            <div class='col-md-3' style="text-align:left;">
              <input type="text" class='form-control' id='id_accomodation' name='city' placeholder="city">
            </div>
            <div class='col-md-4 indent-small' id="errorcity" style="color:#FF0000"></div>
          </div>
        <div class='form-group'>
           <div class='col-md-3 col-md-offset-3' >
                 <input class='btn-lg btn-primary' type='submit' value="Submit" name="submit" onClick="return valid()" />
           </div>
                 <div class='col-md-2'>
                    <button class='btn-lg btn-danger'  type='submit'>Cancel</button>
                 </div>
          </div>
  </form>
      </div>
</div>
</body>
</html>

 <?php
	  }
	  
	 else
	 {
	?>
    <?php
      $report="";
	if(isset($_GET['name']))
	{
		include_once('school_staff_header.php');
		$table="tbl_school_adminstaff";
		//$id = $_SESSION['staff_id'];

	}
	else
	{
		include_once('hr_header.php');
		/*$table="tbl_school_admin";  */
	}
	//include("scadmin_header.php");
	if(isset($_POST['submit']))
	{
		$roll_no=$_POST['roll_no'];
		$id_first_name = $_POST['id_first_name'];
		$id_last_name = $_POST['id_last_name'];

		$id_first_name1 = $_POST['id_first_name1'];
		$id_last_name1 = $_POST['id_last_name1'];
        $name = $id_first_name." ".$id_last_name1;
        $complete_name = $id_first_name." ".$id_first_name1." ".$id_last_name1;
		$father_name=$id_first_name1." ".$id_last_name1;
		//retrive school_id and name school_admin
		 //$id=$_SESSION['id'];
           $fields=array("id"=>$id);
		   //$table="tbl_school_admin";
		   
		   $smartcookie=new smartcookie();
		   
$results=$smartcookie->retrive_individual($table,$fields);
$arrs=mysql_fetch_array($results);

			$school_id=$arrs['school_id'];
			$school_name=$arrs['school_name'];
		$id_email = $_POST['id_email'];
		$arr=mysql_query("select * from tbl_student where std_email='$id_email' and  school_id='$school_id'");
		if(mysql_num_rows($arr)<=0)
		{
		$id_phone = $_POST['id_phone'];
		/*$id_password = $_POST['id_password'];*/
		$id_checkin = $_POST['id_checkin'];
		$id_gender = $_POST['gender'];
		/*$id_education = $_POST['id_education'];*/
		$id_address = $_POST['id_address'];
		$id_country = $_POST['id_country'];
		$id_state = $_POST['state'];
		$class = $_POST['class'];
		$city = $_POST['city'];
		$div = $_POST['div'];
		$id_date = date('m/d/Y');
		$id_first_name=trim($id_first_name);
 $password = $id_first_name."123";
 
		
		
		 list($month,$day,$year) = explode("/",$id_checkin);
    $year_diff  = date("Y") - $year;
    $month_diff = date("m") - $month;
    $day_diff   = date("d") - $day;
    if ($day_diff < 0 || $month_diff < 0) $year_diff--;
  $age= $year_diff;
	$prepAddr = str_replace(' ','+',$id_address);
					 $geocode=file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false');
							 $output= json_decode($geocode);
							$lat = $output->results[0]->geometry->location->lat;
							$long = $output->results[0]->geometry->location->lng;
	 $sqls= "INSERT INTO tbl_student(std_PRN,std_complete_name,std_name,std_lastname,std_Father_name,std_complete_father_name, std_school_name,school_id ,std_class,std_div, permanent_address, std_city, std_dob, std_gender, std_country, std_email,std_phone, std_date,std_age,std_password,latitude,longitude) VALUES ('$roll_no','$complete_name','$id_first_name','$id_last_name1','$father_name','$father_name', '$school_name','$school_id', '$class','$div','$id_address', '$city', '$id_checkin', '$id_gender', '$id_country', '$id_email','$id_phone', '$id_date','$age','$password','$lat','$long')";
	$result_insert = mysql_query($sqls) or die(mysql_error()); 
					if($result_insert>=1){
		
     $to=$id_email;
	$from="smartcookiesprogramme@gmail.com";
	$subject="Succesful Registration";
	$message="Hello ".$id_first_name." ".$id_last_name."\r\n\r\n".
		 "Thanks for your registration with Smart Cookie as student\r\n".
		  "your Username is: "  .$id_email.  "\n\n".
		  "your Password is: ".$password."\n\n".
		  "your School ID is: ".$school_id."\n\n".
		  "Regards,\r\n".
   	      "Smart Cookie Admin";
		  
    echo  mail($to, $subject, $message);
		
		$successreport="Successfully Registered"; 
		//header("Location:student_setup.php?successreport=".$successreport);
		}
		}
		else
		{
		 $errorreport="Email ID is already present";
		// header("Location:student_setup.php?errorreport=".$errorreport);
		
		}
	}
?>

<!DOCTYPE html>
<head>
  
 <link href='css/datepicker.min.css' rel='stylesheet' type='text/css'>
  <script src='js/bootstrap-datepicker.min.js' type='text/javascript'></script>
  <script src='js/bootstrap-switch.min.js' type='text/javascript'></script>
  <script src='js/bootstrap-multiselect.js' type='text/javascript'></script>
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
<script src="js/city_state.js" type="text/javascript"></script>
    <script>
function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}

</script>
<script>
$(document).ready(function() {  
  $('.multiselect').multiselect();
  $('.datepicker').datepicker();  
});

<?php /*?> var reg = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;  
      function PhoneValidation(phoneNumber)
      {  
        var OK = reg.exec(phoneNumber.value);  
        if (!OK)  
         document.getElementById('errorphone').innerHTML='Please Enter Valid Phone Number';
		 return false;
       
      }<?php */?>
function valid()
	{
		
	  	var roll_no=document.getElementById("roll_no").value;
		
		
		var first_name=document.getElementById("id_first_name").value;
		
		
		
		var first_name1=document.getElementById("id_first_name_f").value;
		var last_name1=document.getElementById("id_last_name_f").value;
	 
	    
		 var email=document.getElementById("id_email").value;
		
			var address=document.getElementById("id_address").value;
				
			var country=document.getElementById("country").value;
			
		
			var phone_no=document.getElementById("id_phone").value;
			var state=document.getElementById("state").value;
				var city=document.getElementById("id_accomodation").value;
		
			 if(roll_no==null||roll_no=="")
			{
				
				document.getElementById('errorrollno').innerHTML='Please enter Roll No';
				return false;
			}
			else
			{
			document.getElementById('errorrollno').innerHTML='';
			}
		
			if(first_name==null||first_name==""  )
			{
			   
				document.getElementById('errorname').innerHTML='Please enter name';
				
				return false;
			}
			
			regx1=/^[A-z ]+$/;
				//validation for name
				if(!regx1.test(first_name)  )
				{
				document.getElementById('errorname').innerHTML='Please Enter valid Name';
					return false;
				}
				else
				{
				 document.getElementById('errorname').innerHTML='';
				
				}
				if(first_name1==null||first_name1=="" || last_name1==null || last_name1=="" )
			{
			   
				document.getElementById('errorfatname').innerHTML='Please enter father name';
				
				return false;
			}
			
			
				//validation for name
				if(!regx1.test(first_name1) || !regx1.test(last_name1)  )
				{
				document.getElementById('errorfatname').innerHTML='Please Enter valid  father name';
					return false;
				}
				else
				{
				 document.getElementById('errorfatname').innerHTML='';
				
				}
				var id_class=document.getElementById("id_class").value;
					if(id_class=='')
					{
						document.getElementById('errordiv').innerHTML='Please enter class';
					return false;
					}
					else
					{
						document.getElementById('errordiv').innerHTML='';
					}
					var id_class=document.getElementById("id_class").value;
					if(id_class=='')
					{
						document.getElementById('errordiv').innerHTML='Please enter class';
					return false;
					}
					else
					{
						document.getElementById('errordiv').innerHTML='';
					}
					var id_div=document.getElementById("id_div").value;
					if(id_div=='')
					{
						document.getElementById('errordiv').innerHTML='Please enter division';
					return false;
					}
					else
					{
						document.getElementById('errordiv').innerHTML='';
					}
				//validation of email
				var atpos = email.indexOf("@");
				var dotpos = email.lastIndexOf(".");
				
				if (atpos< 1 || dotpos<atpos+2 || dotpos+2>=email.length) {
					document.getElementById('errorphone').innerHTML='Please enter valid Email ID';
					return false;
				}
					regx=/^[0-9]{1,10}$/;
		
		 var mobiles=document.getElementById("id_phone").value;
				 if(mobiles==""||mobiles==null)
				 {
				
				   document.getElementById("errorphone").innerHTML = "Please enter mobile no.";
				   return false;
				 }

				else if (isNaN(mobiles) || mobiles.length>10 || mobiles.length<10 )
				  {
					  document.getElementById("errorphone").innerHTML = "Please enter valid mobile no.";
				   return false;
					  
					}
					else
					{
						
						document.getElementById("errorphone").innerHTML = ""
					}
					
					var id_checkin=document.getElementById("id_checkin").value;
					 var myDate = new Date(id_checkin);
				var today = new Date();
				if(id_checkin=="")
			{
	
			   
				document.getElementById('errordob').innerHTML='Please Enter Date of Birth';
				
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
								
							document.getElementById("errordob").innerHTML ="please enter valid birth date";
						return false;
							}	
							else
							{
								document.getElementById("errordob").innerHTML ="";
							}
							
							
						}	
						else if(myDate.getMonth()>today.getMonth())
						{
							document.getElementById("errordob").innerHTML ="please enter valid birth date";
						return false;
							
						}
						else
				           {
							   document.getElementById("errordob").innerHTML ="";
							 }
				   }
				   else 
				   {
					   document.getElementById("errordob").innerHTML ="please enter valid birth date";
						return false;
					   
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
			}else{
				document.getElementById('errorgender').innerHTML='';
			}
	var id_address=document.getElementById("id_address").value;
			if(id_address=='')
			{
				document.getElementById('erroraddress').innerHTML='Please enter address ';
				return false;
			}else{
				document.getElementById('erroraddress').innerHTML='';
			}
			if(country==-1)
			{
				document.getElementById('errorstate').innerHTML='Please enter Country';
				return false;
			}
			else
			{
				document.getElementById('errorstate').innerHTML='';
				}
			if(state==-1)
			{
				document.getElementById('errorstate').innerHTML='Please enter state';
				return false;
			}
			else
			{
				document.getElementById('errorstate').innerHTML='';
				}
				regx2=/^[A-z]+$/;
				
			if(city==null||city=="")
			{
			    
				document.getElementById('errorcity').innerHTML='Please enter city';
				return false;
			}
			else if(!regx2.test(city))
			{
				document.getElementById('errorcity').innerHTML='Please enter valid city';
				return false;
				
				}
			else
			{
				
				document.getElementById('errorcity').innerHTML='';
			}

	}
	
</script>
</head>
<body>

<div class='panel panel-primary dialog-panel'>
<div style="font-size:15px;font-weight:bold;margin-top:5px;" class="col-md-offset-6"><div style="color:#F00"><?php if(isset($_GET['errorreport'])){ echo $_GET['errorreport']; };echo $errorreport;?></div><div style="color:#090"><?php if(isset($_GET['successreport'])){ echo $_GET['successreport']; };echo $successreport;?></div></div>
    <div class='panel-heading'>
	 <a href="employeelist.php?name=s"><input type="submit" class="btn btn-primary" name="submit" value="Back" style="width:150;font-weight:bold;font-size:14px;"/></a>
        <h3 align="center">Employee Registration</h3>	

       <!-- <h5 align="center"><a href="Add_studentSheet.php" >Add Excel Sheet</a></h5>-->
		<?php if(isset($_GET['name'])){ ?>
        <h5 align="center"><a href="Add_studentSheet_updated_20160101PT.php?id=s" >Add Excel Sheet</a></h5>
		<?php }else{ ?>
		<h5 align="center"><a href="Add_studentSheet_updated_20160101PT.php" >Add Excel Sheet</a></h5>
		<?php } ?>
      </div>
      
      <div class='panel-body'>
        <form class='form-horizontal' role='form' method="post" action="" onSubmit="return valid()">
        
        		<div class='form-group'>
           			 <label class='control-label col-md-2 col-md-offset-2' style="text-align:left;">Employee ID</label>
            	
              		
                	 <div class='col-md-2' style="text-align:left;">
                 	 <input class='form-control' id='roll_no' name="roll_no" placeholder='Enter Employee ID' type='text' onKeyPress="return isNumberKey(event)" ></div>
                	
                     <div class='col-md-3' id="errorrollno" style="color:#FF0000"></div>
                 </div>
             
          		 
                 
                 <div class="row">
                 	<label class='control-label col-md-2 col-md-offset-2'  style="text-align:left;">Employee Name</label>
                 	 <div class='col-md-2' style="text-align:left;">
                	 
                  	 <input class='form-control' id='id_first_name' name="id_first_name" placeholder='First Name' type='text'>
                  
              	     </div>
                     <div class='col-md-3' id="errorname" style="color:#FF0000"></div>
                 </div>
               
    			 <div class='form-group'>
            	  </div>
                	<div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2'  style="text-align:left;">Father Name</label>
            <div class='col-md-3 ' style="text-align:left;">
                
                  <input class='form-control' id='id_first_name_f'name="id_first_name1" placeholder='First Name' type='text'>
              </div>
              
              <div class='col-md-3 '>
                 <input class='form-control' id='id_last_name_f' name="id_last_name1" placeholder='Last Name' type='text'>
              </div>   
          </div>

 <div class='col-md-8 col-md-offset-4' id="errorfatname" style="color:#FF0000"></div>
				     
       <div class="form-group">
            <label class='control-label col-md-2 col-md-offset-2'  style="text-align:left;" >Designation</label>
            
   <!--Below Drop Down List added by Rutuja Jori on 29/05/2019-->                      
               
                <div class='col-md-2' style="text-align:left;">
                  
               <select id="id_class" name="class">
				<option>Select</option>
				<option>Project Manager</option>
				<option>Technical Director</option>
				<option>Team Leader</option>
				<option>PHP Developer</option>
				<option>Android Developer</option>
				<option>IOS Developer</option>
				</select>
			   </div>
				
            <label class='control-label col-md-1'  style="text-align:left;">Project Domain</label>
            
              
                <div class='col-md-2' style="text-align:left;">
                  <input class='form-control' id='id_div' name="div" placeholder='Enter Project Domain' type='text'>
                </div>
               </div>
                <div class='col-md-10 col-md-offset-3' id="errordiv" style="color:#FF0000"></div>
           <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='id_email'  style="text-align:left;">Contact</label>
           <div class='col-md-3' style="text-align:left;">
                  <input class='form-control' id='id_email' name="id_email" placeholder='E-mail' type='text'>
                </div>
                <div class='col-md-3'>
                  <input class='form-control' id='id_phone' name="id_phone" placeholder='Mobile No' type='text' onChange="PhoneValidation(this);">
                </div>
          </div>
         <div class='col-md-10 col-md-offset-4' id="errorphone" style="color:#FF0000"></div>

			<div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2'  style="text-align:left;">Date Of Birth</label>
            <div class='col-md-3' style="text-align:left;">
             <input class='form-control datepicker' id='id_checkin' name="id_checkin" placeholder='mm/dd/yyyy'>
             </div>
         </div>
<div class='col-md-10 col-md-offset-3 ' id="errordob" style="color:#FF0000"></div>
    <div class='form-group'>
              <label class='control-label col-md-2 col-md-offset-2'  style="text-align:left;">Gender</label>
     <div class='col-md-2'  style="font-weight: 600;color: #777;">
             <input type="radio" name="gender" id="gender1" value="Male"> Male
             </div>
             <div class='col-md-2'  style="font-weight: 600; color: #777;">
             <input type="radio" name="gender" id="gender2" value="Female"> Female
              </div>
            <div class='col-md-4 indent-small' id="errorgender" style="color:#FF0000"> </div>
             </div>
       <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' style="text-align:left;">Address</label>
            <div class='col-md-3' style="text-align:left;">
              <textarea class='form-control' id='id_address' name="id_address" placeholder='Address' rows='3' style="resize:none;"></textarea>
            </div>
            <div class='col-md-4 indent-small' id="erroraddress" style="color:#FF0000"></div>
       </div>
          <div class="form-group">
            <label class='control-label col-md-2 col-md-offset-2'  style="text-align:left;">Country</label>
           <div class='col-md-3' style="text-align:left;">
                 <select id="country" name="id_country" class='form-control'>
                  <option value='select'>select</option></select>
                </div>
            <label class='control-label col-md-1 '  style="text-align:left;">State</label>
                <div class='col-md-3' style="text-align:left;">
            <select name='state' id='state' class='form-control'> <option value='select'>Select</option>
            </select>
                </div>
       </div> 
          <div class='col-md-10 indent-small col-md-offset-4' id="errorstate" style="color:#FF0000">  </div>
<script language="javascript">
            populateCountries("country", "state");
            populateCountries("country2");
        </script>

<div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2'  style="text-align:left;">City</label>
            <div class='col-md-3' style="text-align:left;">
              <input type="text" class='form-control' id='id_accomodation' name='city' placeholder="City">
            </div>
            <div class='col-md-4 indent-small' id="errorcity" style="color:#FF0000"></div>
          </div>
        <div class='form-group'>
           <div class='col-md-3 col-md-offset-3' >
                 <input class='btn-lg btn-primary' type='submit' value="Submit" name="submit" onClick="return valid()" />
           </div>
                 <div class='col-md-2'>
                    <button class='btn-lg btn-danger'  type='reset'>Cancel</button>
                 </div>
				 
				 <!--Cancel button added by Rutuja Jori on 29/05/2019 to reset form-->
          </div>
  </form>
      </div>
</div>
</body>
</html>

        <?php	  
	 }
?>


