<?php
/*error_reporting(0); */
$report="";	
include("hr_header.php");
/*$id=$_SESSION['id'];*/
$fields=array("id"=>$id);
/*$table="tbl_school_admin";*/
$smartcookie=new smartcookie();
$results=$smartcookie->retrive_individual($table,$fields);
$arrs=mysql_fetch_array($results);
$school_id=$arrs['school_id'];
$std_PRN=$_GET['std_prn'];
$std_completename="";
if($std_PRN!='')
{
	if(isset($_POST['update']))
	{
	  if($std_PRN!='')
	  {
		$std_prn=$_POST['std_prn'];
		//$l_name=$_POST['id_last_name'];
		$c_name=$_POST['complete_name'];
		$c_name1=explode(" ",$c_name);
		$fname=$c_name1[0];
		$mname=$c_name1[1];
		$lname=$c_name1[2];
		$full_name=$fname." ".$mname." ".$lname;
		$com_father_name=$_POST['c_father_name'];
		$std_class=$_POST['class'];		
		$std_div=$_POST['div'];
		$std_gen=$_POST['gender'];
		$std_email_id=$_POST['std_email'];
		$std_internal_emailid=$_POST['internal_email'];
		$std_mob=$_POST['std_phone'];
		$std_dob=$_POST['std_dob'];
		$std_t_address=$_POST['temp_address'];
		$std_p_address=$_POST['permanant_address'];
		$std_country=$_POST['country'];
		$std_state=$_POST['state1'];
		$std_cty=$_POST['city'];
		
		$sql_update11="UPDATE `tbl_student` SET std_PRN='$std_prn',std_name='$fname',std_Father_name='$mname',std_lastname='$lname',std_complete_name='$full_name',std_Father_name='$com_father_name',
		std_class='$std_class',std_div='$std_div',std_gender='$std_gen',std_email='$std_email_id',Email_Internal='$std_internal_emailid',std_phone='$std_mob',std_dob='$std_dob',
		Temp_address='$std_t_address',permanent_address='$std_p_address',std_country='$std_country',std_state='$std_state',std_city='$std_cty'
		WHERE std_PRN='$std_PRN' AND school_id='$school_id'";
		$retval11 = mysql_query($sql_update11) or die('Could not update data: ' . mysql_error());
	  }else{
			echo "<script type=text/javascript>alert('Sry... No PRN Number.Unable to update this record '); window.location='studentlist.php'</script>";
			}
		if($retval11>0)
		{
			echo "<script type=text/javascript>alert('Record Updated Successfully '); /*window.location='studentlist.php'*/</script>";
		}
		else{
			  echo "<script type=text/javascript>alert('Ooops..you didn't make any kind of change'); /*window.location='studentlist.php'*/</script>";
		     }
	}
	 
		 
		 
		 


		$query=mysql_query("select * from tbl_student where std_PRN='$std_PRN' and school_id='$school_id'");
		if(mysql_num_rows($query)>0) {
    			while($value1= mysql_fetch_assoc($query))
				{

					$fname=$value1['std_name'];
					$lname=$value1['std_lastname'];
					$mname=$value1['std_Father_name'];
					$std_completename=$fname." ".$mname." ".$lname;
					/* $std_cname=$value1['std_complete_name'];
					$c_name=explode(" ",$std_cname);
					$fname=$c_name[0];
					$mname=$c_name[1];
					$lname=$c_name[2];
					$l2name=$c_name[3];
					$std_completename=$fname." ".$mname." ".$lname." ".$l2name; */
					$std_father_name=$value1['std_complete_father_name'];
					$std_dob=$value1['std_dob'];
					$std_branch=$value1['std_branch'];
					$std_class=$value1['std_class'];
					$std_div=$value1['std_div'];
					$std_year=$value1['std_year'];
					$std_sem=$value1['std_semester'];
					$std_add=$value1['std_address'];
					$std_city=$value1['std_city'];
					$std_country=$value1['std_country'];
					$std_state=$value1['std_state'];
					$std_gender=$value1['std_gender'];
					$std_email=$value1['std_email'];
					$std_phone=$value1['std_phone'];
					$std_internal_email=$value1['Email_Internal'];
					$std_temp_address=$value1['Temp_address'];
					$std_permanant_add=$value1['permanent_address'];
					$std_permanant_village=$value1['Permanent_village'];
					$std_permanant_taluka=$value1['Permanent_taluka'];
					$std_permanant_district=$value1['Permanent_district'];
					$std_permanant_pincode=$value1['Permanent_pincode'];
					
					
		
				 }
			
		}
}else{
	echo "<script type=text/javascript>alert('Sry... No PRN Number.Unable to update this record '); window.location='studentlist.php'</script>";
}		
?>

<!DOCTYPE html>
<html>
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

/* $(document).ready(function() { 

$('#country').change(function() { 

	var  country=document.getElementById("country").value;
    
		if(country=='-1')
			{
			    
				document.getElementById('errorcountry').innerHTML='Please enter country';
				
				return false;
			} 
	   
	  
	  

}); 
}); */
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
.internal_email
{
	padding-left:200px;
}
</style>
<script src="js/city_state.js" type="text/javascript"></script>
<script>
$(document).ready(function() {  
  $('.multiselect').multiselect();
  $('.datepicker').datepicker();  
});


</script>

</head>
<body>

<div class='panel panel-primary dialog-panel'>
    <div style="color:red;font-size:15px;font-weight:bold;margin-top:5px;" class="col-md-offset-6"> <?php if(isset($_GET['report'])){ echo $_GET['report']; };echo $report;?></div>
    <div class='panel-heading'>
        <h3 align="center">Edit Employee Information</h3>
       
      </div>
                                               
        <form class='form-horizontal' role='form' method="POST" action="" onSubmit="return valid()">
        
        		<div class='form-group'>
           			 <label class='control-label col-md-2 col-md-offset-2' style="text-align:left;">Employee ID</label>
            	
              		
                	 <div class='col-md-2' style="text-align:left;">
                 	 <input class='form-control' id='std_prn' name="std_prn" type='text' value="<?php echo $std_PRN;?>"></div>
                	
                     <div class='col-md-3 ' id="errorrollno" style="color:#FF0000"> </div>
                 </div>
               <div class="row">
                 	<label class='control-label col-md-2 col-md-offset-2'  style="text-align:left;">Employee Name</label>
                 	 <div class='col-md-3' style="text-align:left;">
                	 <input class='form-control' id='complete_name' name="complete_name" type='text' size="50" value="<?php echo $std_completename;?>">
                  
              	     </div>
                 </div>
                                                                    
    			 <div class='form-group'>
            	  </div>
                	<div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2'  style="text-align:left;">Father Name</label>
            <div class='col-md-3' style="text-align:left;">

                  <input class='form-control' id='c_father_name' name="c_father_name" type='text' size="50" value="<?php echo $mname;?>">
              </div>
              
            
          </div>

 <div class='col-md-8 col-md-offset-3' id="errorfatname" style="color:#FF0000"></div>
				     
       <div class="form-group">
            <label class='control-label col-md-2 col-md-offset-2'  style="text-align:left;" >Department Name</label>
            
                         
               
                <div class='col-md-2' style="text-align:left;">
                  <input class='form-control' id="id_class" name="class" type='text' value="<?php echo $std_class;?>">
                </div>
          
            <label class='control-label col-md-1'  style="text-align:left;">Designation</label>
            
              
                <div class='col-md-2' style="text-align:left;">
                  <input class='form-control' id='id_div' name="div" type='text' value="<?php echo $std_div;?>">
                </div>
               </div>
                <div class='col-md-10 col-md-offset-3' id="errordiv" style="color:#FF0000"></div>
           <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2'  for='id_email'  style="text-align:left;">Contact</label>
           <div class='col-md-3' style="text-align:left;">
                  <input class='form-control' id='id_email' name="std_email" type='text' value="<?php echo $std_email;?>">
                </div>
                <div class='col-md-3'>
                  <input class='form-control' id='id_phone' name="std_phone" type='text' value="<?php echo $std_phone;?>">
                </div>
				</div>
				<div class='form-group'>
				<label class='control-label col-md-2 col-md-offset-2'  for='id_email'  style="text-align:left;">Internal Email Id</label>
				<div class='col-md-3' style="text-align:center;">
                  <input class='form-control' id='internal_email' name="internal_email" type='text' value="<?php echo $std_internal_email;?>">
                </div>
				</div>
                
				
          
         <div class='col-md-10 col-md-offset-4' id="errorphone" style="color:#FF0000"></div>

			<div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2'  style="text-align:left;">Date Of Birth</label>
            <div class='col-md-2' style="text-align:left;">
             <input class='form-control datepicker' id='id_checkin' name="std_dob" value="<?php echo $std_dob;?>">
             </div>
         </div>
<div class='col-md-10 col-md-offset-3 ' id="errordob" style="color:#FF0000"></div>
    <div class='form-group'>
              <label class='control-label col-md-2 col-md-offset-2'  style="text-align:left;">Gender</label>
     <div class='col-md-2'  style="font-weight: 600;color: #777;">
             <input type="radio" name="gender" <?php if($std_gender=="Male"){ echo "checked";} ?> id="gender1" value="Male"> Male
             </div>
             <div class='col-md-2'  style="font-weight: 600; color: #777;">
             <input type="radio" name="gender" <?php if($std_gender=="Female"){ echo "checked";} ?> id="gender2" value="Female"> Female
              </div>
            <div class='col-md-4 indent-small' id="errorgender" style="color:#FF0000"> </div>
             </div>
             
       <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' style="text-align:left;">Temporary Address</label>
            <div class='col-md-3' style="text-align:left;">
              <textarea class='form-control' id='id_address' name="temp_address" rows='3' value=""><?php echo $std_temp_address;?></textarea>
         
		   </div>
		    </div>
			
			 <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' style="text-align:left;">Permanant Address</label>
            <div class='col-md-3' style="text-align:left;">
              <textarea class='form-control' id='id_address' name="permanant_address" rows='3' value=""><?php echo $std_permanant_add;?></textarea>
            </div>
           </div>
            
            

         <div class="row" align="center" id='erroraddress' style="color:#FF0000;"></div>
<div class="row" style="padding-top:7px;" id="text_country" style="display:block">
<div class="col-md-5"><h4  align="center">Country:</h4></div> 
<div class="col-md-3"><input type="text" class='form-control' id="country1" name="country" style="width:100%;" value="<?php echo $std_country;?>" readonly >
</div>
<div class="col-md-1" id="firstBtn"><a href="" onClick="return showOrhide()">Edit</a></div>
</div>
<div class='row ' style="padding-top:7px; display:none" id="text_country1">
            
           <div class='col-md-3 indent-small' id="errorcountry" style="color:#FF0000"></div>
         </div>
    <div class='row ' style="padding-top:7px; display:none" id="text_state1">
            
            <div class='col-md-3 indent-small' id="errorstate" style="color:#FF0000"><?php // echo $report4; ?></div>
         </div>
<div class="row" style="padding-top:7px;" id="text_state" style="display:block">
<div class="col-md-5"><h4  align="center"> State:</h4></div> 
<div class="col-md-3"> <input type="text" id="state1" name="state1"  class='form-control' style="width:100%;" value="<?php echo $std_state;?>">
</div> 
</div>     
<script language="javascript">
            populateCountries("country", "state");
            populateCountries("country2");
        </script>
<div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2'  style="text-align:center;">City</label>
            <div class='col-md-3' style="text-align:left;">
              <input type="text" class='form-control' id='id_accomodation' name='city' value="<?php echo $std_city;?>">
            </div>
            <div class='col-md-4 indent-small' id="errorcity" style="color:#FF0000"></div>
          </div>
          
          
        <div class='form-group'>
           <div class='col-md-3 col-md-offset-3' >
                <center> <input class='btn-lg btn-primary' type='submit' value="Update" name="update"/> <!-- onClick="return valid()"/>-->
           </div>

                 <div class='col-md-2'>
                    <a href="studentlist.php"><input type="button" class='btn-lg btn-danger' value="Cancel"/>  </a>
                 </div>
          </div>
            </form>
      </div>

</body>
</html>




