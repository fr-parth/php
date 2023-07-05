<?php

//error_reporting(0);
include_once("function.php");
$report="";	
if(isset($_GET['name']))
{
	include_once("school_staff_header.php");
	$table="tbl_school_adminstaff";
	$id=$_SESSION['staff_id'];
	//echo $id;
}
else
{
	include_once("hr_header.php");
	$table="tbl_school_admin";
	//$id=$_SESSION['id'];
	//echo $id;
}


// $id=$_SESSION['id'];
//echo $id;

$fields=array("id"=>$id);

//$table="tbl_school_admin";

$smartcookie=new smartcookie();

$results=$smartcookie->retrive_individual($table,$fields);

$arrs=mysql_fetch_array($results);

$school_id=$arrs['school_id'];
//echo  $school_id;

$t_id=$_GET['t_id'];

if($t_id!='')

{

	if($_SERVER["REQUEST_METHOD"]=="POST")

	{

	   if($t_id!='')

	   {	   

			$complete_name=$_POST['c_name'];

			//$l_name=$_POST['id_last_name'];

			$edu=$_POST['id_education'];

			$experience=$_POST['experience'];  

			$department=$_POST['dept'];		

			$dob1=$_POST['dob'];

			$gen=$_POST['gender'];

			$e_id=$_POST['id_email'];

			$internal_emailid=$_POST['internal_email'];

			$mob=$_POST['id_phone'];

			$land=$_POST['landline'];

			$address=$_POST['address'];

			$country=$_POST['country'];

			$state=$_POST['state'];

			$cty=$_POST['city'];

			
$sql_update11="UPDATE `tbl_teacher` SET t_complete_name='$complete_name',t_qualification='$edu',t_dob='$dob1',

			t_exprience='$experience',t_dept='$department',t_gender='$gen',t_internal_email='$internal_emailid',t_phone='$mob',t_landline='$land',

			t_address='$address',t_country='$country',state='$state',t_city='$cty'

			WHERE t_id='$t_id' AND school_id='$school_id'"; 

			$retval11 = mysql_query($sql_update11) or die('Could not update data: ' . mysql_error());

			$report='Successfully updated';

	   }else{

				echo "<script type=text/javascript>alert('Sry... No Teacher ID.Unable to update this record '); window.location='teacherlist.php'</script>";

			}	

		/*if($retval11>0)

		{

			echo "<script type=text/javascript>alert('Record Updated Successfully '); //window.location='teacherlist.php?name=t&t_id=".$t_id."</script>";

	

		}

		else{

			  echo "<script type=text/javascript>alert('Ooops..you didn't make any kind of change'); //window.location='teacherlist.php'</script>";

		     }*/

	}	

	 

		 

		 

		 

		 

		 

		$query=mysql_query("select * from tbl_teacher where t_id='$t_id'");

		if(mysql_num_rows($query)>=1) {

    			while($value1= mysql_fetch_assoc($query))

				{

					$cname=$value1['t_complete_name'];

					$c_name=explode(" ",$cname);

					$fname=$c_name[0];

					$mname=$c_name[1];

					$lname=$c_name[2];

					$l2name=$c_name[3];

					$completename=$fname." ".$mname." ".$lname." ".$l2name;

					//$fname=$value1['t_name'];

					//$mname=$value1['t_middlename'];

					//$lname=$value1['t_lastname'];

					$dept=$value1['t_dept'];

					$exp=$value1['t_exprience'];
					
					$gender=$value1['t_gender'];

					$qul=$value1['t_qualification'];

					$add=$value1['t_address'];

					$dob=$value1['t_dob'];

					$email=$value1['t_email'];

					$phone=$value1['t_phone'];

					$landline=$value1['t_landline'];

					$c_name=$value1['t_complete_name'];

					$internal_email=$value1['t_internal_email'];

					$city=$value1['t_city'];
					$t_qualification=$value1['t_qualification'];
					

					

		

				}

		

			}

}else{

		echo "<script type=text/javascript>alert('Sry... No Teacher ID.Unable to update this record '); //window.location='teacherlist.php'</script>";

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





 

function valid()

	{

var first_name=document.getElementById("c_name").value;
		
		
		
		
		
		if(first_name==null||first_name=="" )
			{
			   
				document.getElementById('errorname').innerHTML='Please Enter Name';
				
				return false;
			}
		
		regx1=/^[A-z ]+$/;
				//validation for name
				if(!regx1.test(first_name) )
				{
				document.getElementById('errorname').innerHTML='Please Enter valid Name';
					return false;
				}
				else
				{
					document.getElementById('errorname').innerHTML='';
				}
				var id_education=document.getElementById("id_education").value;
				if(id_education=='')
				{
					document.getElementById('errorexperience').innerHTML='Please Enter education';
					return false;
				}
				else
				{
				document.getElementById('errorexperience').innerHTML='';
						
				}
				
				var experience=document.getElementById("experience").value; 
				
		if(experience==null||experience=="")
			{
			   
				document.getElementById('errorexperience').innerHTML='Please Enter Experience';
				
				return false;
			}
			else if(experience <0 || experience%1!=0)
			{
				document.getElementById('errorexperience').innerHTML='Please Enter valid Experience';
				
				return false;
				
				}
			else
			{
				document.getElementById('errorexperience').innerHTML='';
			}
			
			var id_checkin=document.getElementById("id_checkin").value;
					 var myDate = new Date(id_checkin);
			
				var today = new Date();
				
				if(id_checkin=="")
			{
	
			   
				document.getElementById('errordob').innerHTML='Please Enter Date of Birth';
				
				return false;
			}
			
			
			else	if(myDate.getFullYear()>=today.getFullYear())
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
						else
						{
							document.getElementById('errorgender').innerHTML='';
						}
						
						 var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;  
						 
						 var email=document.getElementById("id_email").value;
						
			  if(!email.match(mailformat))  
				{  
				document.getElementById('erroremail').innerHTML='Please Enter valid email ID';

				return false;  
				} 
				else
				{
					document.getElementById('erroremail').innerHTML='';
				}
				 var internal_email=document.getElementById("internal_email").value;
				
			  if(!internal_email.match(mailformat))  
				{  
				document.getElementById('errorinternalemail').innerHTML='Please Enter valid internal email ID';

				return false;  
				} 
				else
				{
					document.getElementById('errorinternalemail').innerHTML='';
				}
				
	 var phone=document.getElementById("phone").value;
	
			if( isNaN(phone))
			{
				document.getElementById('errorphone').innerHTML='Please Enter Valid Phone Number';
				return false;	
			}
			else
			{
				document.getElementById('errorphone').innerHTML='';
			}
			var landline=document.getElementById("landline").value;
						if( isNaN(landline))
			{
				document.getElementById('errorlandline').innerHTML='Please Enter Valid landline Number';
				return false;	
			}
			else
			{
				document.getElementById('errorlandline').innerHTML='';
			}
			
			var address=document.getElementById("id_address").value;
		if(address==null||address=="")
			{
			   
				document.getElementById('erroraddress').innerHTML='Please Enter address';
				
				return false;
			}
			else
			{
				document.getElementById('erroraddress').innerHTML='';
			}
		var country=document.getElementById("country").value;
		
		if(country=="-1")
			{
			   
				document.getElementById('errorcountry').innerHTML='Please Enter country';
				
				return false;
			}
			else
			{
				
				document.getElementById('errorcountry').innerHTML='';
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
				document.getElementById('errorcity').innerHTML='Please Enter valid  city';
				
				return false;
				}
				else
				{
					document.getElementById('errorcity').innerHTML='';
				
					}
	
	}

		

	

</script>

</head>

<body >

  <div class='container' >

    <div class='panel panel-primary dialog-panel' style="background-color:#FFFFFF;background-image=""">

   <div style="color:red;font-size:15px;font-weight:bold;margin-top:10px;"> <?php if(isset($_GET['report'])){ echo $_GET['report']; };?></div>

      <div class='panel-heading'>

         
 <a href="managerlist.php"> <input type="button" class="btn btn-primary" name="submit" value="Back" style="width:150;font-weight:bold;font-size:14px;"/></a>
 
            <h3 align="center">Update Manager Information</h3>

        

       

            

          </div>

      <div class='panel-body'>

        <form class='form-horizontal' role='form' method="POST">

        

        

        <div class='form-group'>

            <label class='control-label col-md-2 col-md-offset-2' for='id_title'  style="text-align:left;">Manager Name</label>

            <div class='col-md-8'>

            

              <div class='col-md-4'>

                <div class='form-group internal'>

                  <input class='form-control' id='c_name' name="c_name" type='text' size="50" value="<?php echo $completename;?>">

                </div>

              </div>

            

              <div class='col-md-4 indent-small' id="errorname" style="color:#FF0000">

                

              </div>

            </div>

          </div>

        



                 

           <div class='form-group'>

            <label class='control-label col-md-2 col-md-offset-2' for='id_service' style="text-align:left;">Education</label>

            <div class='col-md-2'>

              <select class='multiselect  form-control' id='id_education' name="id_education" >
              <?php
			  echo $t_qualification;
			  
			   if($t_qualification!='')
			  {
				  ?>
              <option value='<?php echo $t_qualification ?>' selected><?php echo $t_qualification;?></option>
              <?php 
			  }else
			  { ?>
				<option value=''>Select</option>
                <?php }?>
                <?php if($t_qualification!='BE') {?>
                 <option value='BE'>BE</option>
                 <?php }
				if($t_qualification!='ME'){ 
				 
				?>

				 <option value='ME'>MBA</option>
                   <?php }
				if($t_qualification!='BA'){ 
				 
				?>
			
                <option value='BCom'>BCom</option>
  <?php }
				if($t_qualification!='BSc'){ 
				 
				?>
               
                <option value='MCom'>MCom</option>
  <?php }
				if($t_qualification!='MSc'){ 
				 
				?>
                <option value='MSc'>BCom</option>
  <?php }
				if($t_qualification!='B.ED'){ 
				 
				?>
                <option value='B.ED'>B-Tech</option>
  <?php }
				if($t_qualification!='D.ED'){ 
				 
				?>
                <option value='D.ED'>M-Tech</option>
  <?php }
				if($t_qualification!='Diploma'){ 
				 
				?>
				 <option value='Diploma'>Phd</option>
  <?php }
				if($t_qualification!='ME'){ 
				 
				?>
                <option value='Other'>Other</option>
                <?php }?>
              </select>

            </div>

             

            

            

            <label class='control-label col-md-2 '  >Experience<br>(in months)</label>

            

              <div class='col-md-1'>

               

                  <input class='form-control ' id='experience' name='experience' type='text' value=<?php echo $exp;?>>

              

              </div>
              

             <div class='col-md-2 indent-small' id="errorexperience" style="color:#FF0000"></div>

           
</div>
       

         

		      <!--    <div class='form-group'>

		    <label class='control-label col-md-2 ' style="margin-left:110px;">Department</label>

            

              <div class='col-md-4' style="margin-left:6px;">

               

                  <input class='form-control col-md-8' id='dept' name='dept' type='text' value="<?php echo $dept;?>">

              

              </div>

             <div class='col-md-2 indent-small' id="errorexperience" style="color:#FF0000"></div>

           

       

           </div> -->
		   
		   
		    <div class='form-group'>

            <label class='control-label col-md-2 col-md-offset-2' for='id_accomodation' style="text-align:left;" >Department</label>

            <div class='col-md-3'>

            
              <select name='dept' id='dept' class='form-control'>
           <?php     $arr=mysql_query("select Dept_Name from tbl_department_master where school_id='$school_id' ORDER BY Dept_Name"); ?>
		<option><?php echo $dept;?></option>
		<?php    while($row=mysql_fetch_array($arr)){?> <option><?php echo $row['Dept_Name']?></option><?php }?>
              
              </select>

            </div>

             <div class='col-md-3 indent-small' id="errordept" style="color:#FF0000"></div>

          </div>


         

            <div class='form-group'>

            <label class='control-label col-md-2 col-md-offset-2' for='id_checkin' style="text-align:left;">Date Of Birth</label>

            <div class='col-md-8'>

              <div class='col-md-5'>

                <div class='form-group internal input-group'>

              

               <input class='form-control datepicker' id="id_checkin" name="dob" class="form-control" value="<?php echo $dob; ?>">

                

                </div>

                

                <div class='col-md-15' id="errordob" style="color:#FF0000"></div>

              </div>

               

            </div>

          </div>

          

          

          <div class='form-group'>

            <label class='control-label col-md-2 col-md-offset-2' for='id_pets' style="text-align:left;">Gender</label>

           <div class='col-md-2' style="font-weight: 600;

color: #777;">

           <input type="radio" name="gender" id="gender1" <?php if($gender=="Male") echo 'checked'; ?> value="Male"> 

                  Male

             </div>

             <div class='col-md-3' style="font-weight: 600;

color: #777;">

             <input type="radio" name="gender" id="gender2" <?php if($gender=="Female") echo 'checked'; ?> value="Female">

            Female

              </div>

              

                <div class='col-md-2 indent-small' id="errorgender" style="color:#FF0000">

          </div>

          </div>

          

       

         <div class='form-group'>

            <label class='control-label col-md-2 col-md-offset-2' for='id_email' style="text-align:left;" >Contact</label>

            
             

                <div class='col-md-3'>

				

                  Email<input class='form-control' id='id_email' name="id_email" type='text' value=<?php echo $email;?>></div>
<div class='col-md-3 indent-small' id="erroremail" style="color:#FF0000">

                

              </div>
           
             </div>
             
				  <div class='form-group'>

            <label class='control-label col-md-2 col-md-offset-2' for='id_email' style="text-align:left;" ></label>

           

             

                <div class='col-md-3'>


				  Internal Email<input class='form-control' id='internal_email' name="internal_email" type='text' value=<?php echo $internal_email;?>>

                </div>

				

                <div class='col-md-3 indent-small' id="errorinternalemail" style="color:#FF0000">

                

             
              </div>
</div>
             

               <div class='form-group'>

            <label class='control-label col-md-2 col-md-offset-2' for='id_email' style="text-align:left;" ></label>

            <div class='col-md-3'>

             

               

                  Phone<input class='form-control' id='phone' name="id_phone" type='text' value="<?php echo $phone;?> "></div><div class='col-md-3 indent-small' id="errorphone" style="color:#FF0000">

                

              </div>
              </div>
              <div class='form-group'>
                <label class='control-label col-md-2 col-md-offset-2' for='id_email' style="text-align:left;" ></label>
<div class='col-md-3'>
				  Landline<input class='form-control' id='landline' name="landline" type='text' value=<?php echo $landline;?>>
                  </div>

               

                <div class='col-md-3 indent-small' id="errorlandline" style="color:#FF0000">

                

              </div>

              </div>

            

     
         

        

        

         

           

          <div class='form-group'>

            <label class='control-label col-md-2 col-md-offset-2' for='id_comments' style="text-align:left;">Address</label>

            <div class='col-md-4'>

              <textarea class='form-control' id='id_address' name="address" rows='3' ><?php echo $add;?></textarea>

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

              <input type="text" class='form-control' id='id_city' name="city" value=<?php echo $city;?>>

            </div>

             <div class='col-md-3 indent-small' id="errorcity" style="color:#FF0000"></div>

          </div>

      

          

          

           

          

         <div class='form-group row'>

           <div class='col-md-2 col-md-offset-4' >

   <input class='btn-lg btn-primary' type='submit' value="Update" name="submit" onClick="return valid()" style="padding:5px;"/>

                </div>

                 <div class='col-md-1'>

                    

       <a href="managerlist.php"><input type="button" class='btn-lg btn-danger' value="Cancel" name="cancel"  style="padding:5px;" /></a>

                    

                  </div>

          

          

          

          

          

          

        </form>

      </div>

      <div class='row' align="center"  style="color:#096;"><?php echo $report;?></div>

    </div>

  </div>

</body>





				  