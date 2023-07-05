<?php
function changeDateFormat1($date)
{
	$str= explode("/",$date);
	$date = $str[2]."/".$str[0]."/".$str[1];
	return $date;
}
$report="";

	function changeDateFormat($date)
							{
								$str= explode("-",$date);
								$date = $str[1]."/".$str[2]."/".$str[0];
								return $date;
							}


include("hr_header.php");
   $staff_id=$_GET['staff_d'];


   if(isset($_GET['staff_d']))
		                      {
						      $id=$_GET['staff_d'];
							  $sql=mysql_query("select * from tbl_school_adminstaff where id=".$id."");
							  while($row=mysql_fetch_array($sql))
							   {
								 $s_st_id=$row['id'];
                                 $school_id= $row['school_id'];
								 $names=$row['stf_name'];
								 $a=explode(" ",$names);
								 $a[0];$a[1];
								 $edu=$row['qualification'];
								 $des=$row['designation'];
								 $exp=$row['exprience'];
								 $GetDate=$row['dob'];
								 $GetDate = changeDateFormat($GetDate);
                                 
								 $Getgender=$row['gender'];
								 $mailid=$row['email'];
								 $phone=$row['phone'];
								 $add=$row['addd'];
								 $getcounty=$row['country'];
								 $getstatu=$row['statue'];
								 $city=$row['city'];

								}
		                      }


$errorreport="";

	if(isset($_POST['Update']))
	{ 

		$id_first_name = $_POST['id_first_name'];
		$id_last_name = $_POST['id_last_name'];
		$name=$id_first_name." ".$id_last_name;
	    $education =$_POST['id_education'];
		$experience=$_POST['Experience'];
		$designation=$_POST['Designation'];
		$date = $_POST['dob'];
		$date = changeDateFormat1($date);
		$email = $_POST['id_email'];
	    $phone = $_POST['id_phone'];
		$gender=$_POST['gender'];
    	$address = $_POST['address'];
		$city = $_POST['city'];
if($name!="" && $address!="" && $email!="" && $city!="")
{
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

		
		$dates = date('m/d/Y');
		$password = $id_first_name."123";
			
		list($month,$day,$year) = explode("/",$date);
		$year_diff  = date("Y") - $year;
		$month_diff = date("m") - $month;
		$day_diff   = date("d") - $day;
		if ($day_diff < 0 || $month_diff < 0) $year_diff--;
	    $age= $year_diff;
	    $currentdate = date('Y-m-d H:i:s');
	    $permision=@implode(',',$_POST['permission']);
	
//------------------------------insert in tbl_school_adminstaff table----------


      $sqls="update tbl_school_adminstaff set stf_name='$name',exprience='$experience',designation='$designation',addd='$address',country='$country',city='$city', statue='$state',dob='$date',age='$age',gender='$gender',email='$email',phone='$phone',pass='$password',qualification='$education'where id=".$staff_id."";

	$count = mysql_query($sqls) or die(mysql_error());

//-------------------------------End------------------------------------------------

//------------------------------Insert in permision in tbl_permission table----------

     $r=mysql_query("select * from tbl_permission where s_a_st_id=".$s_st_id."");

       if(mysql_num_rows($r)==0)
       {
            $sql="INSERT INTO `tbl_permission` (`school_id`, `s_a_st_id`, `cookie_admin_staff_id`,`school_staff_name`, `cookie_staff_name`, `permission`, `current_date`) VALUES ('$school_id','$staff_id',NULL,'$staf_name',NULL, '$permision', '$currentdate')";
          /* $sql="insert into tbl_permission(permission) values ('$permision') where s_a_st_id=".$staff_id."";           */
	       $rs=mysql_query($sql) or die(mysql_error());
       }
       else
       {
           $sql="update tbl_permission set permission='$permision' where s_a_st_id=".$staff_id."";
	       $rs=mysql_query($sql) or die(mysql_error());
       }

//------------------------------End--------------------------------------------------

/*if($count>=1)
		{	
	$to=$email;
	$from="smartcookiesprogramme@gmail.com";
	$subject="Succesful Updated Your Profile";
	$message="Hello ".$id_first_name." ".$id_last_name."\r\n\r\n".
		 "Thanks for registration with Smart Cookie as teacher\r\n".
		  "your Username is: "  .$email.  "\n\n".
		  "your password is: ".$password."\n\n".
		  "your School ID is: ".$school_id."\n\n".
		  "Regards,\r\n".
   	      "Smart Cookie Admin";
		  
       mail($to, $subject, $message);
		
		$report="successfully updated"; 
		header("Location:schoolAdminStaff_list.php?report=".$report);
		}*/
}
else
{
	
	$errorreport="Please enter all details";
	
}
		}
		
	   	  ?>

<!DOCTYPE html>
<head>
 
  <script language="JavaScript">
function toggle(source) {
  checkboxes = document.getElementsByName('permission[]');
  for(var i=0, n=checkboxes.length;i<n;i++) {
    checkboxes[i].checked = source.checked;
  }
}
</script>
<SCRIPT language="javascript">
    $(function () {
        // add multiple select / deselect functionality
        $("#master").click(function () {
            $('.name').attr('checked', this.checked);
        });
        // if all checkbox are selected, then check the select all checkbox
        // and viceversa
        $(".name").click(function () {
 
           if($(".name:checked").length!=0) {
                  $("#master").attr("checked", "checked");
            }
			else
			{
			 $("#master").removeAttr("checked");
			}

        });
    });
</SCRIPT>

<!-----------------------------POINT----------------------------------------->
<SCRIPT language="javascript">
    $(function () {
        // add multiple select / deselect functionality
        $("#point").click(function () {
            $('.subpoint').attr('checked', this.checked);
        });
        // if all checkbox are selected, then check the select all checkbox
        // and viceversa
        $(".subpoint").click(function () {
 
           if($(".subpoint:checked").length!=0) {
                  $("#point").attr("checked", "checked");
            }
			else
			{
			 $("#point").removeAttr("checked");
			}

        });
    });
</SCRIPT>
<!--------------------------------LOG-------------------------------------------->

<SCRIPT language="javascript">
    $(function () {
        // add multiple select / deselect functionality
        $("#log").click(function () {
            $('.sublog').attr('checked', this.checked);
        });
        // if all checkbox are selected, then check the select all checkbox
        // and viceversa
        $(".sublog").click(function () {
 
           if($(".sublog:checked").length!=0) {
                  $("#log").attr("checked", "checked");
            }
			else
			{
			 $("#log").removeAttr("checked");
			}

        });
    });
</SCRIPT>

<!-------------------------------------purches coupone------------>

<SCRIPT language="javascript">
    $(function () {
        // add multiple select / deselect functionality
        $("#purchesC").click(function () {
            $('.subpurches').attr('checked', this.checked);
        });
        // if all checkbox are selected, then check the select all checkbox
        // and viceversa
        $(".subpurches").click(function () {

           if($(".subpurches:checked").length!=0) {
                  $("#purchesC").attr("checked", "checked");
            }
			else
			{
			 $("#purchesC").removeAttr("checked");
			}

        });
    });
</SCRIPT>

<SCRIPT language="javascript">
    $(function () {
        // add multiple select / deselect functionality
        $("#report").click(function () {
            $('.subreport').attr('checked', this.checked);
        });
        // if all checkbox are selected, then check the select all checkbox
        // and viceversa
        $(".subreport").click(function () {

           if($(".subreport:checked").length!=0) {
                  $("#report").attr("checked", "checked");
            }
			else
			{
			 $("#report").removeAttr("checked");
			}

        });
    });
</SCRIPT>


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




#perm td ul li{
	
	padding:2px;
	border:1px solid #ccc;
	
	border-radius:0px;
	box-shadow: 0px 0px 0px 1px rgba(150,150,100,0.2);
}
</style>
 <script src='js/bootstrap-datepicker.min.js' type='text/javascript'></script>
<script src="js/city_state.js" type="text/javascript"></script>
<link href='css/datepicker.min.css' rel='stylesheet' type='text/css'>
<!--<link href='css/bootstrapMaterial.css' rel='stylesheet' type='text/css'> -->
<script>
$(document).ready(function() {  
   
  $('.datepicker').datepicker();  
});



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
				
					var experience=document.getElementById("Experience").value; 
					
		if(experience==null||experience=="")
			{
			   document.getElementById('errorexperience').innerHTML='Please Enter Experience';
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
	
			   
				document.getElementById('errordob').innerHTML='Please enter date of birth';
				
				return false;
			}
			
			
			else	if(myDate.getFullYear()>=today.getFullYear())
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
						   document.getElementById("errordob").innerHTML ="";
						  
						 }
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
			
			
		
		 
		
		var email=document.getElementById("id_email").value;
		
			
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
	  
	  var id_phone=document.getElementById("phone").value;
	  
		regx2=/^[0-9 ]+$/;
				//validation for name
				if(!regx2.test(id_phone))
				{
				document.getElementById('errorphone').innerHTML='Please Enter valid mobile number';
					return false;
				}
				else
				{
					document.getElementById('errorphone').innerHTML='';
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
			if(document.getElementById("text_country1").style.display=="block")
			{
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
			}
			if(document.getElementById("text_state").style.display=="block")
			{
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
			}
		var city=document.getElementById("id_city").value;
		
		if(city==null||city=="")
			{
			   
				document.getElementById('errorcity').innerHTML='Please enter city';
				
				return false;
			}
			
			if(!regx1.test(city) )
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


</head>
<body >
  <div class='container'>
    <div class='panel panel-primary dialog-panel' style="background-color:#FFFFFF;background-image=""">
   <div style="color:red;font-size:15px;font-weight:bold;margin-top:10px;"> <?php if(isset($_GET['report'])){ echo $_GET['report']; };?></div>
     <div class='row' align="center"  style="color:#090"><?php echo $report;?></div>
      <div class='row' align="center"  style="color:#F00"><?php echo $errorreport;?></div>
      <div class='panel-heading'>
         
            <h3 align="center">Edit Staff Information</h3>
        
        
          <!--  <h5 align="center"><a href="Add_teacherSheet.php" >Add Excel Sheet</a></h5> -->
          </div>
          
                      <?php 


					  ?>
      <div class='panel-body'>
        <form class='form-horizontal' role='form' method="post">


        <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='id_title' style="text-align:left;">Staff Name</label>
            
             <div class='col-md-8'>

              <div class='col-md-3 '>
                <div class='form-group internal'>
                  <input class='form-control' id='id_first_name' value="<?=$a[0];?>" name="id_first_name"  placeholder='First Name' type='text'>
                </div>
              </div>
              <div class='col-md-3 col-sm-offset-1'>
                <div class='form-group internal'>
                  <input class='form-control' id='id_last_name' value="<?=$a[1];?>" name="id_last_name" placeholder='Last Name' type='text'>
                </div>
              </div>
              <div class='col-md-4 indent-small' id="errorname" style="color:#FF0000">
                
              </div>
            </div>
          </div>
                           <?php if($edu!=="0")
						   {
						   ?>     
        <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='id_checkin' style="text-align:left;">Education</label>
            <div class='col-md-8'>
              <div class='col-md-5'>
                <div class='form-group internal input-group'>
              <select class="multiselect  form-control" id="id_service" name="id_education">
                 <option value="<?=$edu;?>" selected=""><?=$edu;?></option>
                 
                <option value="BA">Be</option>
                <option value="BCom">BCom</option>
                <option value="BSc">Phd</option>
                <option value="MA">MBA</option>
                <option value="MCom">MCom</option>
                <option value="MSc">M-Tech</option>
                <option value="B.ED">B-Tech</option>
                <option value="D.ED">Other</option>
             </select>  
                           
                </div>
                <div class='col-md-15' id="erroreducation" style="color:#FF0000;"></div>
              </div>
               
            </div>
          </div>
                       <?php 
						   }
						   else
						   {
							   ?>
                           <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='id_checkin' style="text-align:left;">Education</label>
            <div class='col-md-8'>
              <div class='col-md-5'>
                <div class='form-group internal input-group'>
              <select class="multiselect  form-control" id="id_service" name="id_education">
              <option value="" selected="">Select</option>
                 
                <option value="BA">BA</option>
                <option value="BCom">BCom</option>
                <option value="BSc">BSc</option>
                <option value="MA">MA</option>
                <option value="MCom">MCom</option>
                <option value="MSc">MSc</option>
                <option value="B.ED">B.ED</option>
                <option value="D.ED">D.ED</option>
             </select>  
                           
                </div>
                <div class='col-md-15' id="erroreducation" style="color:#FF0000;"></div>
              </div>  
            </div>
          </div>    
                               
          <?php
			}
			?>
        
        <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='id_checkin' style="text-align:left;">Designation</label>
            <div class='col-md-8'>
              <div class='col-md-5'>
                <div class='form-group internal input-group'>
             
              <input class="form-control col-md-8"  value="<?=$des?>" id="Designation" name="Designation" placeholder="Designation" type="text">         
             
                </div>
                
                <div class='col-md-15' id="errordesignation" style="color:#FF0000;
                
                "></div>
              </div>
               
            </div>
          </div>
          
          
          <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='id_checkin' style="text-align:left;">Experience</label>
            <div class='col-md-8'>
              <div class='col-md-5'>
                <div class='form-group internal input-group'>
             
        <input class="form-control col-md-8"  value="<?=$exp?>" id="Experience" name="Experience" placeholder="Experience" type="text">         
             
                </div>
                
                <div class='col-md-15' id="errorexperience" style="color:#FF0000;
                
                "></div>
              </div>
               
            </div>
          </div>
        
        
         
            <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='id_checkin' style="text-align:left;">Date Of Birth</label>
            <div class='col-md-8'>
              <div class='col-md-5'>
                <div class='form-group internal input-group'>
              
               <input class='form-control datepicker' value="<?=$GetDate;?>" id="id_checkin" name="dob" class="form-control">
                
                </div>
                
                <div class='col-md-15' id="errordob" style="color:#FF0000;
                
                "></div>
              </div>
               
            </div>
          </div>
          
          
          <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='id_pets' style="text-align:left;">Gender</label>
           <div class='col-md-2' style="font-weight: 600;
color: #777;">
           <input type="radio" name="gender" id="gender1"<?php if($Getgender=="Male"){echo "checked=\"checked\" ";} ?>value="Male"> 
                  Male
             </div>
             <div class='col-md-3' style="font-weight: 600;
color: #777;">
             <input type="radio" name="gender" id="gender2"  <?php if($Getgender=="Female"){echo "checked=\"checked\" ";} ?> value="Female">
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
                  <input class='form-control' id='id_email' name="id_email" value="<?=$mailid;?>" placeholder='E-mail' type='text'>
                </div>
                <div class='col-md-3 indent-small' id="erroremail" style="color:#FF0000">
                
              </div>
              </div>
              <div class='form-group '>
                <div class='col-md-6'>
                  <input class='form-control' id='phone' name="id_phone" value="<?=$phone?>" placeholder='Mobile No' type='text' >
                </div>
                <div class='col-md-3 indent-small' id="errorphone" style="color:#FF0000">
                
              </div>
              </div>
            </div>
          </div>
          
          <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='id_comments' style="text-align:left;">Address</label>
            <div class='col-md-4'>
              <textarea class='form-control' id='id_address' name="address" placeholder='Address' rows='3'><?=$add?></textarea>
            </div>
            <div class='col-md-2 indent-small' id="erroraddress" style="color:#FF0000"></div>
          </div>
         
         
        
        <div class="form-group" style="padding-top:7px;" id="text_country" style="display:block" align="left">
         
           
          <label class="col-md-2 col-md-offset-2">Country</label> 
<div class="col-md-5"><input type="text" class='form-control' id="country1" name="country1" style="width:60%;" value="<?=$getcounty?>" readonly >
</div>
<div class="control-label col-md-2 " id="firstBtn"><a href="" onClick="return showOrhide()">Edit</a></div>
   
</div>

        <div class='row ' style="padding-top:7px; display:none" id="text_country1" align="left">
           
            <label class="col-md-2 col-md-offset-2 ">Country</label> 
    <div class='col-md-2'>
                  <select id="country" name="country" class='form-control' ></select>
                </div>
            
             
            <div class='col-md-3 indent-small' id="errorcountry" style="color:#FF0000"></div>
         </div>
         
         


<div class='row ' style="padding-top:7px; display:none" id="text_state1" align="left">
            <label class=" col-md-2 col-md-offset-2">State </label>
    <div class='col-md-2'>
                  <select id="state" name="state" class='form-control' style="width:60%;" ></select>
                </div>
            
             
            <div class='col-md-3 indent-small' id="errorstate" style="color:#FF0000"><?php// echo $report4; ?></div>
         </div>
       


<div class="row" style="padding-top:7px;" id="text_state" style="display:block" align="left">
<label class=" col-md-2 col-md-offset-2 "> State</label>
<div class="col-md-5"> <input type="text" id="state1" name="state1"  class='form-control' style="width:100%;" value="<?=$getstatu?>" readonly>


</div> 
</div>
 <script language="javascript">
            populateCountries("country", "state");
            populateCountries("country2");
        </script>
</div>

         <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='id_accomodation' style="text-align:left;" >City</label>
            <div class='col-md-3'>
              <input type="text" class='form-control' value="<?=$city?>" id='id_city' name="city" placeholder="City">
            </div>
            
             <div class='col-md-3 indent-small' id="errorcity" style="color:#FF0000"></div>
          </div>
       <div class='form-group'>
       <div class='col-md-1'></div>
        <div class='col-md-12'>
        
  </div>
          
           </div>
           
         
                <div class='form-group'>
                                 
            
             <div class='form-group'>
       
        
            <fieldset style="border:thick;">
    <legend>Edit Access</legend>
    <div class='col-md-12'>
             <div class="form-group internal" align="center" style="padding:10px;"> <td style="background-color:#B2B2B2;  border-radius:5px;"><input type="checkbox" onClick="toggle(this)">Select All</td></div>
               <?php  
			         
									  
							  $getpermision=mysql_query("select * from tbl_permission where s_a_st_id=".$id."");
							        $fetchpermision=mysql_fetch_array($getpermision);
									      $perm=$fetchpermision['permission'];
										  
										 
			   ?>
    <table id="perm" class="table-striped table-bordered table" style="width:100%;border:1px solid #ddd;">
          <tr >

          <?php $Lb="LDBRD";
					      $Mst=strpos($perm,$Lb);
						  if($Mst !== false)
						  {?>
  <td style=" background-color:#B2B2B2; "><input type="checkbox" checked name="permission[]" value="LDBRD">Leader Board</td>
    <?php }else{?>

  <td style=" background-color:#B2B2B2; "><input type="checkbox" name="permission[]" value="LDBRD">Leader Board</td>
      <?php } ?>
                 <?php $Masters="Master";
					      $Mstr=strpos($perm,$Masters);
						  if($Mstr !== false)
						  {?>
<td style=" background-color:#B2B2B2;"><input type="checkbox"  name="permission[]" checked id="master" value="Master"> Master&nbsp;</td>
<?php }else{?>
<td style=" background-color:#B2B2B2;"><input type="checkbox"  name="permission[]" id="master" value="Master"> Master&nbsp;</td>
          <?php } ?>
          
          <?php $Points="Points";
					      $P=strpos($perm,$Points);
						  if($P !== false)
						  {?>
<td style=" background-color:#B2B2B2;"><input type="checkbox" name="permission[]" checked id="point" value="Points"> Points&nbsp;</td>
<?php }else{?>
<td style=" background-color:#B2B2B2;"><input type="checkbox" name="permission[]" id="point" value="Points"> Points&nbsp;</td>
          <?php } ?>

          <?php $Logs="Logs";
					      $L=strpos($perm,$Logs);
						  if($L !== false)
						  {?>
<td style=" background-color:#B2B2B2;"><input type="checkbox" checked name="permission[]" id="log" value="Logs"> Logs&nbsp;</td>
<?php }else{?>
<td style=" background-color:#B2B2B2;"><input type="checkbox" name="permission[]" id="log" value="Logs"> Logs&nbsp;</td>
          <?php } ?>
          
          <?php $Sponsor="Sponsor Map";
					      $s=strpos($perm,$Sponsor);
						  if($s !== false)
						  {?>
<td style=" background-color:#B2B2B2;"><input type="checkbox" checked name="permission[]" value="Sponsor Map"> Sponsor Map&nbsp;</td><?php }else{?>
<td style=" background-color:#B2B2B2;"><input type="checkbox" name="permission[]" value="Sponsor Map"> Sponsor Map&nbsp;</td>          <?php } ?>

                   <?php $Purches="purchesC";
					      $Pches=strpos($perm,$Purches);
						  if($Pches !== false)
						  {?>
<td style=" background-color:#B2B2B2;"><input type="checkbox" name="permission[]" checked id="purchesC" value="purchesC"> Purchase Coupon&nbsp;</td><?php }else{?>
<td style=" background-color:#B2B2B2;"><input type="checkbox" name="permission[]" id="purchesC" value="purchesC"> Purchase Coupon&nbsp;</td>          <?php } ?>

 <?php $Purches="Report";
					      $Pches=strpos($perm,$Purches);
						  if($Pches !== false)
						  {?>
<td style=" background-color:#B2B2B2;"><input type="checkbox" name="permission[]" checked id="report" value="Report"> Report&nbsp;</td><?php }else{?>
<td style=" background-color:#B2B2B2;"><input type="checkbox" name="permission[]" id="report" value="Report"> Report&nbsp;</td>          <?php } ?>

      </tr>
          <tr>
              <td><ul style="list-style-type:none; border-left:dotted; margin-left: -41px;"></ul>
           </td>
           
               <td>
                 <ul  style="list-style-type:none; margin-left: -35px;">
                 <?php $Teacher="Teacher1";
					      $Tch=strpos($perm,$Teacher);
						  if($Tch !== false)
						  {?>
<li><input type="checkbox" class="name" name="permission[]" checked id="td" value="Teacher1">Teacher&nbsp;</li>
<?php }else{?>
<li><input type="checkbox" class="name" name="permission[]" id="td" value="Teacher1">  Manager&nbsp;</li>
<?php } ?>

<?php $Student="Student1";
					      $St=strpos($perm,$Student);
						  if($St !== false)
						  {?>
<li><input type="checkbox" class="name" name="permission[]" checked id="td" value="Student1">Student&nbsp;</li>
<?php }else{?>
<li><input type="checkbox" class="name" name="permission[]" id="td" value="Student1"> Employee&nbsp;</li>
<?php } ?>

<?php $Parents="Parents";
					      $St=strpos($perm,$Parents);
						  if($St !== false)
						  {?>
<li><input type="checkbox" class="name" name="permission[]" checked id="td" value="Parents"> Parents&nbsp;</li>
<?php }else{?>
<li><input type="checkbox" class="name" name="permission[]" id="td" value="Parents"> Parents&nbsp;</li>
<?php } ?>

<?php $Semester="Semester";
					      $St=strpos($perm,$Semester);
						  if($St !== false)
						  {?>
<li><input type="checkbox" class="name" name="permission[]" checked id="td" value="Semester"> Semester&nbsp;</li>
<?php }?>


<?php $StuSem="StuSem";
					      $St=strpos($perm,$StuSem);
						  if($St !== false)
						  {?>
<li><input type="checkbox" class="name" name="permission[]" checked id="td" value="StuSem"> Student Semester&nbsp;</li>
<?php }?>


<?php $TSub="TSub";
					      $St=strpos($perm,$TSub);
						  if($St !== false)
						  {?>
<li><input type="checkbox" class="name" name="permission[]" checked id="td" value="TSub"> Teacher Project&nbsp;</li>
<?php }else{?>
<li><input type="checkbox" class="name" name="permission[]" id="td" value="TSub">  Manager Subject&nbsp;</li>
<?php } ?>

<?php $SSub="SSub";
					      $St=strpos($perm,$SSub);
						  if($St !== false)
						  {?>
<li><input type="checkbox" class="name" name="permission[]" checked id="td" value="SSub">  Student Project&nbsp;</li>
<?php }else{?>
<li><input type="checkbox" class="name" name="permission[]" id="td" value="SSub"> Employee Subject&nbsp;</li>
<?php } ?>


<?php $CSub="CSub";
					      $St=strpos($perm,$CSub);
						  if($St !== false)
						  {?>
<li><input type="checkbox" class="name" name="permission[]" checked id="td" value="CSub"> Class Subject&nbsp;</li>
<?php }else{?>
<li><input type="checkbox" class="name" name="permission[]" id="td" value="CSub">Department Project&nbsp;</li>
<?php } ?>
  
  <?php $ScholM="School Master";
					      $SM=strpos($perm,$ScholM);
						  if($SM !== false)
						  {?>
<li><input type="checkbox" class="name" name="permission[]" checked id="td" value="School Master"> company Master&nbsp;</li>
<?php }else{?>
<li><input type="checkbox" class="name" name="permission[]" id="td" value="School Master"> company Master&nbsp;</li><?php } ?>

   <?php $Activity="Activity";
					      $Activi=strpos($perm,$Activity);
						  if($Activi !== false)
						  {?>
 <li><input type="checkbox" class="name" name="permission[]" checked id="td" value="Activity"> Activity&nbsp;</li>
<?php }else{?>
 <li><input type="checkbox" class="name" name="permission[]" id="td" value="Activity"> Activity&nbsp;</li>
 <?php } ?>
 
  <?php $Subject="Subject1";
					      $Sub=strpos($perm,$Subject);
						  if($Sub !== false)
						  {?>
 <li><input type="checkbox" class="name" name="permission[]" checked id="td" value="Subject1"> Subject&nbsp;</li>
<?php }else{?>
 <li><input type="checkbox" class="name" name="permission[]" id="td" value="Subject1"> Project&nbsp;</li>
 <?php } ?>

 
                         <?php $Branch="Branch";
					      $Degs=strpos($perm,$Branch);
						  if($Degs !== false)
						  {?>
 <li><input type="checkbox" class="name" name="permission[]" checked id="td" value="Branch"> Branch&nbsp;</li>
<?php }?>
 
 
                          <?php $Departments="Departments";
					      $Dep=strpos($perm,$Departments);
						  if($Dep !== false)
						  {?>
<li><input type="checkbox" class="name" checked name="permission[]" id="td" value="Departments"> Departments&nbsp;</li>
<?php }else{?>
 <li><input type="checkbox" class="name" name="permission[]" id="td" value="Departments"> Departments&nbsp;</li>
 <?php } ?>
 
                          <?php $BrSubjects="BrSubjects";
					      $Dep=strpos($perm,$BrSubjects);
						  if($Dep !== false)
						  {?>
<li><input type="checkbox" class="name" checked name="permission[]" id="td" value="BrSubjects"> Branch Subjects&nbsp;</li>
<?php }?>
  
 
 
  
                      <?php $Class="Class";
					      $Cla=strpos($perm,$Class);
						  if($Cla !== false)
						  {?>
 <li><input type="checkbox" class="name" checked name="permission[]" id="td" value="Class"> Class&nbsp;</li>
<?php }?>
  
  
                    <?php $Division="Division";
					      $Div=strpos($perm,$Division);
						  if($Div !== false)
						  {?>
 <li><input type="checkbox" class="name" checked name="permission[]" id="td" value="Division"> Division&nbsp;</li>
<?php }else{?>
  <li><input type="checkbox" class="name" name="permission[]" id="td" value="Division"> Division&nbsp;</li>
 <?php } ?>


               <?php $Division="access";
					      $Div=strpos($perm,$Division);
						  if($Div !== false)
						  {?>
 <li><input type="checkbox" class="name" checked name="permission[]" id="td" value="access"> School Admin Staff&nbsp;</li>
<?php }else{?>
  <li><input type="checkbox" class="name" name="permission[]" id="td" value="access"> HR Staff&nbsp;</li>
 <?php } ?>


                    <?php $ThanQ="ThanQ";
					      $Than=strpos($perm,$ThanQ);
						  if($Than !== false)
						  {?>
 <li><input type="checkbox" class="name" checked name="permission[]" id="td" value="ThanQ"> ThanQ&nbsp;</li>
<?php }else{?>
 <li><input type="checkbox" class="name" name="permission[]" id="td" value="ThanQ"> ThanQ&nbsp;</li>
 <?php } ?>


                    <?php $ThanQ="sms";
					      $Than=strpos($perm,$ThanQ);
						  if($Than !== false)
						  {?>
 <li><input type="checkbox" class="name" checked name="permission[]" id="td" value="sms"> Send SMS/Email&nbsp;</li>
<?php }else{?>
 <li><input type="checkbox" class="name" name="permission[]" id="td" value="sms"> Send SMS/Email&nbsp;</li>
 <?php } ?>



                  <!--  <?php $Who="Who Assign Blue Point?";
					      $W=strpos($perm,$Who);
						  if($W !== false)
						  {?>
 <li><input type="checkbox" class="name"  checked name="permission[]" id="td" value="Who Assign Blue Point?"> Who Assign Blue Point?&nbsp;</li>
<?php }else{?>
 <li><input type="checkbox" class="name" name="permission[]" id="td" value="Who Assign Blue Point?"> Who Assign Blue Point?&nbsp;</li>
 <?php } ?> -->
 
   <?php $up="Upload Panel";
					      $W=strpos($perm,$up);
						  if($W !== false)
						  {?>
<li><input type="checkbox" class="name" name="permission[]" checked id="td" value="Upload Panel"> Upload Panel&nbsp;</li>
<?php }else{?>
<li><input type="checkbox" class="name" name="permission[]" id="td" value="Upload Panel"> Upload Panel&nbsp;</li>
 <?php } ?>

 <?php $cre="create";
					      $Than=strpos($perm,$cre);
						  if($Than !== false)
						  {?>
 <li><input type="checkbox" class="name" checked name="permission[]" id="td" value="create"> Create Excel Files&nbsp;</li>
<?php }else{?>
 <li><input type="checkbox" class="name" name="permission[]" id="td" value="create"> Create Excel Files&nbsp;</li>
 <?php } ?>
                            </ul>
    
    </td>
                   
              <td style="vertical-align:top; ">
                  <ul style="list-style-type:none; vertical-align:top; margin-left:-35px;">

                    <?php $BPTs="Distribution";
					      $BP=strpos($perm,$BPTs);
						  if($BP !== false)
						  {?>
                       <li>
                             <input type="checkbox" class="subpoint" checked name="permission[]" value="Distribution"> Distribution Points&nbsp;
                          </li>
                           <?php }else{ ?>
                            <li>
                             <input type="checkbox" class="subpoint" name="permission[]" value="Distribution"> Distribution Points&nbsp;
                          </li>
                          <?php }  ?>


                           <?php $BPTs="Reward";
					      $BP=strpos($perm,$BPTs);
						  if($BP !== false)
						  {?>
                          <li>
                             <input type="checkbox" class="subpoint" checked name="permission[]" value="Reward"> Reward Points&nbsp;
                          </li>

                           <?php }else{ ?>
                          <li>
                             <input type="checkbox" class="subpoint"  name="permission[]" value="Reward"> Reward Points&nbsp;
                          </li>
                           <?php }  ?>
                  
                <!--  <?php $GeenPoints="gP2t";
					      $GW=strpos($perm,$GeenPoints);
						  if($GW !== false)
						  {?>
<li><input type="checkbox" class="subpoint" checked name="permission[]" value="gP2t">Green Points to Teachers for distribution&nbsp;</li>
<?php }else{?>
<li><input type="checkbox" class="subpoint" name="permission[]" value="gP2t">Green Points to Teachers for distribution&nbsp;</li>
 <?php } ?>

                   <?php $BPTT="Blue Points To Teacher";
					      $BPT=strpos($perm,$BPTT);
						  if($BPT !== false)
						  {?>
<li><input type="checkbox" checked class="subpoint" name="permission[]" value="Blue Points To Teacher">Blue Point rewards to teachers&nbsp;</li>
<?php }else{?>
<li><input type="checkbox" class="subpoint" name="permission[]" value="Blue Points To Teacher">Blue Point rewards to teachers&nbsp;</li>
 <?php } ?>

                       <?php $BPTs="Blue Points To Student";
					      $BP=strpos($perm,$BPTs);
						  if($BP !== false)
						  {?>
 <li><input type="checkbox" class="subpoint" checked name="permission[]" value="Blue Points To Student">Blue Points to Students for distribution&nbsp;</li><?php }else{?>
 <li><input type="checkbox" class="subpoint" name="permission[]" value="Blue Points To Student">Blue Points to Students for distribution&nbsp;</li>
 <?php } ?>-->


                   </ul>
                </td>

                   <td style="vertical-align:top; ">
                      <ul style="list-style-type:none; margin-left: -35px;">


                    <?php $TGP="TGP1";
					      $BGP=strpos($perm,$TGP);
						  if($BGP !== false)
						  {?>
 <li><input type="checkbox" class="sublog" checked name="permission[]" value="TGP1">Green Points given to Manager for Distribution&nbsp;</li><?php }else{?>
  <li><input type="checkbox" class="sublog" name="permission[]" value="TGP1">Green Points given to Manager for Distribution&nbsp;</li>
 <?php } ?>

 <?php $SGP="S2gp";
					      $SG1=strpos($perm,$SGP);
						  if($SG1 !== false)
						  {?>
 <li><input type="checkbox" class="sublog" checked name="permission[]" value="S2gp"> Green Points given to Employee as rewards&nbsp;</li><?php }else{?>
  <li><input type="checkbox" class="sublog" name="permission[]" value="S2gp">Green Points given to Employee as rewards&nbsp;</li>
 <?php } ?>

 <?php $Sponsor="Sponsor1";
					      $Sponsor1=strpos($perm,$Sponsor);
						  if($Sponsor1 !== false)
						  {?>
 <li><input type="checkbox" class="sublog" checked name="permission[]" value="Sponsor1"> Sponsors log of points and products&nbsp;</li><?php }else{?>
  <li><input type="checkbox" class="sublog" name="permission[]" value="Sponsor1"> Sponsors log of points and products&nbsp;</li>
 <?php } ?>


 <?php $TeacherBluePoint="Teacher Blue Point";
					      $TeacherBPoint=strpos($perm,$TeacherBluePoint);
						  if($TeacherBPoint !== false)
						  {?>
 <li><input type="checkbox" class="sublog" checked name="permission[]" value="Teacher Blue Point"> Blue Points given to Manager as Rewards&nbsp;</li><?php }else{?>
  <li><input type="checkbox" class="sublog" name="permission[]" value="Teacher Blue Point"> Blue Points given to Manager as Rewards&nbsp;</li>
 <?php } ?>


 <?php $TeacherBluePoint="Teacher Green Point";
					      $TeacherBPoint=strpos($perm,$TeacherBluePoint);
						  if($TeacherBPoint !== false)
						  {?>
 <li><input type="checkbox" class="sublog" checked name="permission[]" value="Teacher Green Point"> Blue Points Given to Employee for Distribution&nbsp;</li><?php }else{?>
  <li><input type="checkbox" class="sublog" name="permission[]" value="Teacher Green Point"> Blue Points Given to Employee for Distribution&nbsp;</li>
 <?php } ?>
           </ul>
                    </td>

                    <td>  
                       <ul style="list-style-type:none;   margin-left: -41px;"> </ul>
                    </td>
                    
              <td style="vertical-align:top;">
              
                     <ul style="list-style-type:none; margin-left: -35px;">
                     
                     
                     <?php $GeenPointscoupones="Gpc1";
					      $GeenPscoupones=strpos($perm,$GeenPointscoupones);
						  if($GeenPscoupones !== false)
						  {?>
 <li><input type="checkbox" class="subpurches" checked name="permission[]" value="Gpc1"> Green Points coupons&nbsp;</li>
 <?php }else{?>
 <li><input type="checkbox" class="subpurches" name="permission[]" value="Gpc1"> Green Points coupons&nbsp;</li>
 <?php } ?>

 <?php $BluePointscoupones="Bpc2";
					      $Bluecoupones=strpos($perm,$BluePointscoupones);
						  if($Bluecoupones !== false)
						  {?>
 <li><input type="checkbox" class="subpurches" checked name="permission[]" value="Bpc2"> Blue Points coupons&nbsp;</li>
 <?php }else{?>
 <li><input type="checkbox" class="subpurches" name="permission[]" value="Bpc2"> Blue Points coupons&nbsp;</li>
 <?php } ?>
 
         </ul>
                   </td>

                  <td style="vertical-align:top; ">
                      <ul style="list-style-type:none; margin-left: -35px;">
                           <?php $BM="BM";
					      $T=strpos($perm,$BM);
						  if($T !== false)
						  {?>
                          <li><input type="checkbox" class="subreport" checked name="permission[]" value="BM"> Batch Master&nbsp;</li>
                          <?php }else{?>
                          <li><input type="checkbox" class="subreport"  name="permission[]" value="BM"> Batch Master&nbsp;</li>
                          <?php } ?>

                          <?php $BM="TSR";
					      $T=strpos($perm,$BM);
						  if($T !== false)
						  {?>
                          <li><input type="checkbox" class="subreport" checked name="permission[]" value="TSR"> Teacher Subject&nbsp;</li>
                           <?php }else{?>
                          <li><input type="checkbox" class="subreport"  name="permission[]" value="TSR"> Manager Projects&nbsp;</li>
                           <?php } ?>

                          <?php $BM="SSR";
					      $T=strpos($perm,$BM);
						  if($T !== false)
						  {?>
                          <li><input type="checkbox" class="subreport" checked name="permission[]" value="SSR"> Student Subject&nbsp;</li>
                           <?php }else{?>
                          <li><input type="checkbox" class="subreport"  name="permission[]" value="SSR">Employee Project&nbsp;</li>
                           <?php } ?>

                          <?php $BM="TR1";
					      $T=strpos($perm,$BM);
						  if($T !== false)
						  {?>
                          <li><input type="checkbox" class="subreport" checked name="permission[]" value="TR1"> Teacher&nbsp;</li>
                           <?php }else{?>
                          <li><input type="checkbox" class="subreport"  name="permission[]" value="TR1"> Manager&nbsp;</li>
                           <?php } ?>

                          <?php $BM="SR1";
					      $T=strpos($perm,$BM);
						  if($T !== false)
						  {?>
                          <li><input type="checkbox" class="subreport" checked name="permission[]" value="SR1"> Student&nbsp;</li>
                           <?php }else{?>
                          <li><input type="checkbox" class="subreport"  name="permission[]" value="SR1"> Employee&nbsp;</li>
                          <?php } ?>
                      </ul>
                   </td>
             </tr>
         </table>   
                       
                       
  </fieldset>
  
  
  </div>
          
           </div>
           
           <div class='form-group row'>
           <div class='col-md-2 col-md-offset-4' >
   <input class='btn-lg btn-primary' type='submit' value="Update" name="Update" onClick="return valid()" style="padding:5px;"/>
                </div>
                
              <script>   
                    /*  function abc()
					  { 
					  window.history.go(1);
					  }*/
              </script>
                 <div class='col-md-1'>
                    
     <a href="schoolAdminStaff_list.php"><input type="button" class='btn-lg btn-danger' value="cancel" style="padding:5px;" /></a>
                    
                  </div>
</div>

      
          
        
                  </div>
          
          
        </form>
      </div>
    
    </div>
  </div>
</body>