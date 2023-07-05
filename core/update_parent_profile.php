<?php
	
	include("Parent_header.php");
           if(!isset($_SESSION['id']))
	{
	header("location:index.php");
	}
	$id=$_SESSION['id'];
           $fields=array("id"=>$id);
		   $table="tbl_parent";
		   
		   $smartcookie=new smartcookie();
		   
//$result=$smartcookie->retrive_individual($table,$fields);
//$parent=mysql_fetch_array($result);
$row=mysql_query("select * from tbl_parent where Id='$id'");
$parent=mysql_fetch_array($row);

if(isset($_POST['remove']))
{
	$sql = mysql_query("update tbl_parent set p_img_path = '' WHERE Id='$id'");
	if($sql)
	{
		echo "<script>alert('profile picture removed successfully')</script>";	
	}
	
}

if(isset($_POST['upload']))
	{
              //echo "<script type=text/javascript>alert('entered1111');</script>";	
			  $file_name = $_FILES['image']['name'];
			  $file_size =$_FILES['image']['size'];
			  $file_tmp =$_FILES['image']['tmp_name'];
			  $file_type=$_FILES['image']['type'];
			  $file_ext=strtolower(end(explode('.',$_FILES['image']['name'])));
			  $expensions= array("jpg","gif","jpeg","png","JPG","JPEG","tiff");
			  
			  if(in_array($file_ext,$expensions)=== false){
				  echo "<script type=text/javascript>alert('extension not allowed, please choose a JPEG or PNG file.');</script>";
			  } 
			  if($file_size > 2097152)
			  {
				echo "<script type=text/javascript>alert('File size must be excately 2 MB');</script>";
			  }
			  $path="parent_image/".date('mdY')."_".$file_name;
			  if($file_name!='')
			  {  
				  move_uploaded_file($file_tmp,"parent_image/".date('mdY')."_".$file_name);
				  mysql_query("update `tbl_parent` set p_img_path = '$path' WHERE Id='$id'");
				  $msg="Image Uploaded Successfully";
			  }//else{echo "<script type=text/javascript>alert('Plz select Image');</script>";}	
        
	} 
	
		if(isset($_POST['submit']))
		{
			//echo "<script type=text/javascript>alert('entered');</script>";
			$id=$_SESSION['id'];
		  $first_name=$_POST['id_first_name1'];
		   $last_name=$_POST['id_first_name2'];
		   $name=$first_name." ".$last_name;
		  $dob=$_POST['dob'];
		 $age=$_POST['age'];
		  $gender=$_POST['gender'];
		 $qualification=$_POST['qualification'];
			$occupation=$_POST['occupation'];
			$country=$_POST['country'];
			$city=$_POST['city'];
			$phone=$_POST['phone'];
			$state=$_POST['state'];
			$password=$_POST['password'];
			$email_id=$_POST['email_id'];
			$address=$_POST['address'];
		
					$row="update tbl_parent set Name='$name',email_id='$email_id',Password='$password',DateOfBirth='$dob',Age='$age',Qualification='$qualification',Occupation='$occupation',Address='$address',country='$country',state='$state',city='$city',Phone='$phone',Gender='$gender' where Id='$id'";
					$retval = mysql_query($row) or die('Could not update data: ' . mysql_error());
					if($retval>0)
					header('Location:update_parent_profile.php');
		}
		
	
			
?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap 101 Template</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

  <link href='css/datepicker.min.css' rel='stylesheet' type='text/css'>
 
  <script src='js/bootstrap-datepicker.min.js' type='text/javascript'></script>
 
    <script src="js/city_state.js" type="text/javascript"></script>
    
  </head>
  <script>
  
  var _validFileExtensions = [".jpg", ".png", ".jpeg", ".gif",".PNG",".bmp"];    
function Validatedocfile(oInput) {
    if (oInput.type == "file") {
        var sFileName = oInput.value;
         if (sFileName.length > 0) {
            var blnValid = false;
            for (var j = 0; j < _validFileExtensions.length; j++) {
                var sCurExtension = _validFileExtensions[j];
                if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
                    blnValid = true;
                    break;
                }
            }
             
            if (!blnValid) {
                alert("Sorry, " + sFileName + " is invalid, allowed extensions are: " + _validFileExtensions.join(", "));
                oInput.value = "";
                return false;
            }
        }
    }
    return true;
}
$(document).ready(function() {  

  $('.datepicker').datepicker();  

     //   activaTab('tab_a');
  
		
   		
		
				
			
 
  
    });
	 
//validation of first name
function validfirstname()
	{
	
	 var first_name=document.getElementById("id_first_name").value;
			 regx1=/^[A-z ]+$/;
				//validation for first name it should be char
					if(!regx1.test(first_name))
					{
						document.getElementById('errorfirst').innerHTML='Please enter valid first name';
						return false;
					}
	}
	//validation of last name
function validlastname()
	{
	
	 var last_name=document.getElementById("id_last_name").value;
			 regx1=/^[A-z ]+$/;
				//validation for last name it should be char
					if(!regx1.test(last_name))
					{
						document.getElementById('errorfirst').innerHTML='Please enter valid last name';
						return false;
					}
	}
	
	function validfirstform()
	{
	         regx2=/^[a-zA-Z]+$/;
    	var first_name=document.getElementById("id_first_name").value;
		if(first_name==""||first_name==null)
			{
				
				document.getElementById('errorfirst').innerHTML='Please enter first name';
						return false;
			
			}
            else if(!regx2.test(first_name))
					{
						document.getElementById('errorfirst').innerHTML='Please enter valid First Name';
						return false;
					}
                    else{}
			
		 var last_name=document.getElementById("id_last_name").value;
		 if(last_name==""|| last_name==null)
			{
				
				document.getElementById('errorfirst').innerHTML='Please enter last name';
						return false;
			
			}
            else if(!regx2.test(last_name))
					{
						document.getElementById('errorfirst').innerHTML='Please enter valid Last Name';
						return false;
					}
                    else{}
			var qualification=document.getElementById("qualification").value;
			if(qualification==""|| qualification==null)
			{
			document.getElementById('errorfirst').innerHTML='Please enter qualification ';
						return false;
			}
            else if(!regx2.test(qualification))
					{
						document.getElementById('errorfirst').innerHTML='Please enter valid qualification';
						return false;
					}
                    else{}
			var occupation=document.getElementById("occupation").value;
			if(occupation==""||occupation==null)
			{
			document.getElementById('errorfirst').innerHTML='Please enter occupation ';
						return false;
			}
            else if(!regx2.test(occupation))
					{
						document.getElementById('errorfirst').innerHTML='Please enter valid Occupation';
						return false;
					}
                    else{}
			 var age=document.getElementById("age").value;
			 regx1=/^[0-9]+$/;
				//validation for last name it should be number
					if(!regx1.test(age))
					{
						document.getElementById('errorfirst').innerHTML='Please enter valid birth date';
						return false;
					}
					
					
			 $('.nav-tabs > .active').next('li').find('a').trigger('click');
	}
	
	function validsecond()
	{
	       var address=document.getElementById("address").value;
		   var regex2 = /^[A-Za-z0-9'\.\-\s\,]/; 
        	
				
			
					
			
		
			var country=document.getElementById("country").value;
			if(country==""||country==null)
			{
			document.getElementById('errorsecond').innerHTML='Please enter country ';
						return false;
			}
			  regx=/^[a-zA-Z ]+$/;
				//validation for  it should be alphabet
					if(!regx.test(country))
					{
						document.getElementById('errorsecond').innerHTML='Please enter valid country';
						return false;
					}
					var state=document.getElementById("state").value;
					
					if(state==""||state==null)
					{
					document.getElementById('errorsecond').innerHTML='Please enter state ';
								return false;
					}
					
				//validation for  it should be alphabet
					if(!regx.test(state))
					{
						document.getElementById('errorsecond').innerHTML='Please enter valid state';
						return false;
					}
		        var id_accomodation=document.getElementById("id_accomodation").value;
					if(id_accomodation==""||id_accomodation==null)
					{
					document.getElementById('errorsecond').innerHTML='Please enter city ';
								return false;
					}
					
				//validation for  it should be alphabet
					if(!regx.test(id_accomodation))
					{
						document.getElementById('errorsecond').innerHTML='Please enter valid city';
						return false;
					}
					
					
		
			var phone=document.getElementById("phone").value;
			var reg = new RegExp('^[0-9]+$');
			if((phone.length)!=10)
				 {
				
				 document.getElementById('errorsecond').innerHTML='Please enter valid phone number';
				 return false;
				 }
			 if(phone==null||phone=="")
				{
				  
					document.getElementById('errorsecond').innerHTML='Please enter phone number';
					return false;
					
				}	
				if(!reg.test(phone))
				{
				    document.getElementById('errorsecond').innerHTML='Please enter phone number';
					return false;
				}
				
				 $('.nav-tabs > .active').next('li').find('a').trigger('click');
	}
	
function valid()
	{
	    
		var first_name=document.getElementById("id_first_name").value;
			 regx1=/^[A-z ]+$/;
				//validation for first name it should be char
					if(!regx1.test(first_name))
					{
						document.getElementById('error').innerHTML='Please enter valid first name';
						return false;
					}
			
			 var last_name=document.getElementById("id_last_name").value;
			  if(last_name==""||last_name==null)
				{
				
				document.getElementById('error').innerHTML='Please enter last name';
						return false;
			
				}
				var age=document.getElementById("age").value;
			      regx1=/^[0-9]+$/;
				//validation for  it should be number
					if(!regx1.test(age))
					{
						document.getElementById('error').innerHTML='Please enter valid birth date';
						return false;
					}
				var qualification=document.getElementById("qualification").value;
				if(qualification==""||qualification==null)
					{
				document.getElementById('error').innerHTML='Please enter qualification ';
							return false;
					}
			var occupation=document.getElementById("occupation").value;
				if(occupation==""||occupation==null)
						{
				document.getElementById('error').innerHTML='Please enter occupation ';
							return false;
						}
			var address=document.getElementById("address").value;
					//if(address!="")
						
					//{
							var regex2 = /^[a-zA-Z0-9\s,'-]+$/;  
							
							
					//}else{
						//document.getElementById('error').innerHTML='Please enter valid Address';
					//}
		
			var country=document.getElementById("country").value;
					if(country==""||country==null)
					{
					document.getElementById('error').innerHTML='Please enter country ';
								return false;
					}
					
			var email=document.getElementById("email").value;
			
			 //validation of email
				var atpos = email.indexOf("@");
				var dotpos = email.lastIndexOf(".");
				
				if (atpos< 1 || dotpos<atpos+2 || dotpos+2>=x.length) {
				
					document.getElementById('error').innerHTML='Please enter valid email-id';
					return false;
				}
				
					
			
		
	
		
		
				
	
			
		
	}
	function alphanumeric(uadd)  
	{   
			
	}  

	function validpassword()
		{
			regx=/^[a-zA-Z0-9!@#$%^&*]{6,16}$/;
				var password=document.getElementById("password").value;
				if(!regx.test(password)||password.length<6 )
				{
				document.getElementById('error').innerHTML='password contain specialchar alphbet digit and min length 6';
							return false;
				}
		
	    }
	function getAge() 
		{
		   var dateString=document.getElementById("dob").value;
			var today = new Date();
			var birthDate = new Date(dateString);
			var age = today.getFullYear() - birthDate.getFullYear();
			var m = today.getMonth() - birthDate.getMonth();
			if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) 
			{
				age--;
			}
			document.getElementById("age").value=age;
		}
    function validate()
		{
	
		var password=document.getElementById("password").value;
				var cnfpassword=document.getElementById("cnfpassword").value;
 
		 		   if (password != cnfpassword)
		 		 		{
							document.getElementById("error").innerHTML = "password and confirm password should match";
							return false;
						}
						else
						{
						      document.getElementById("error").innerHTML = "";
						}
	
		
		}

</script>
  <body>
  
<div><h1>Update Profile</h1></div>

<div class="container" style="margin-top:20px;" >
<ul class="nav nav-tabs">
  <li role="presentation" class="active"><a href="#tab_a" data-toggle="tab">Personal details</a></li>
  <li role="presentation"><a href="#tab_b" data-toggle="tab">Contact</a></li>
  <li role="presentation"><a href="#tab_c" data-toggle="tab">Setting</a></li>

</ul>
<div class="tab-content newboxes" id="newboxes1" style="margin-top:10px;">
        <div class="tab-pane active" id="tab_a" >
          
            <form role="form" method="POST" enctype="multipart/form-data">
               <?php $str = $parent['Name'];
				$name = explode(" ", $str);?>
   				<div class="form-group col-md-8">
      				<label for="name" class="col-md-4">First Name <span style="color:red;">*</span></label>
                    <div class='form-group internal col-md-6'>
                  		<input class='form-control' id='id_first_name' name="id_first_name1" placeholder='First Name' value='<?php echo $name[0]; ?>' type='text' onBlur="validfirstname()">
                	</div>
   				</div> 
                <div class="form-group col-md-8 col-md-offset-3 " id="errorname" style="color:#FF0000"></div>
                <div class="form-group col-md-8 ">
      				<label for="name" class="col-md-4">Last Name</label>
                    <div class='form-group internal col-md-6'>
                  		<input class='form-control' id='id_last_name' name="id_first_name2" placeholder='Last Name' value='<?php echo $name[1]; ?>' onBlur="validlastname()" type='text'>
                	</div>
   				</div> 
                <div class="form-group col-md-8 col-md-offset-3 " id="errorlastname" style="color:#FF0000"></div>
                <div class="form-group col-md-8">
      				<label for="name" class="col-md-4">Date of Birth<span style="color:red;">*</span></label>
                    <div class='form-group internal col-md-6'>
                  		<input type="date" class='form-control' name='dob' id='dob' value='<?php echo $parent['DateOfBirth']; ?>' onChange="getAge()">
                 
                	</div>
   				</div> 
                <div class="form-group col-md-8">
      				<label for="name" class="col-md-4">Age</label>
                    <div class='form-group internal col-md-6'>
                  		<input class='form-control' id='age' name="age" placeholder='Age' readonly value='<?php echo $parent['Age']; ?>' type='text'>
                	</div>
   				</div>
                <div class="form-group col-md-8">
      				<label for="name" class="col-md-4">Gender<span style="color:red;">*</span></label>
                  <?php  if( $parent['Gender']=='Male'){?>
                    <div class='form-group internal col-md-2'>
                      Male&nbsp;&nbsp;
                  		<input type="radio" id='gender' name="gender" value="Male" checked >
                	</div>
                    <div class='form-group internal col-md-3'>
                    Female&nbsp;&nbsp;
                  		<input type="radio" id='gender' name="gender" value="Female">
                	</div>
                    <?php }else{?>
                     <div class='form-group internal col-md-2'>
                      Male&nbsp;&nbsp;
                  		<input type="radio" id='gender' name="gender" value="Male" >
                	</div>
                    <div class='form-group internal col-md-3'>
                    Female&nbsp;&nbsp;
                  		<input type="radio" id='gender' name="gender" value="Female" checked>
                	</div>
                    <?php }?>
   				</div> 
                <div class="form-group col-md-8">
      				<label for="name" class="col-md-4">Qualification<span style="color:red;">*</span></label>
                    <div class='form-group internal col-md-6'>
                  		<input class='form-control' id='qualification' name="qualification" placeholder='Qualification' value='<?php echo $parent['Qualification'];?>'	type='text'>
                	</div>
   				</div> 
                <div class="form-group col-md-8">
      				<label for="name" class="col-md-4">Occupation<span style="color:red;">*</span></label>
                    <div class='form-group internal col-md-6'>
                  		<input class='form-control' id='occupation' name="occupation" placeholder='Occupation' value='<?php echo $parent['Occupation']; ?>' type='text'>
                	</div>
   				</div> 
				
				
                <div class="form-group col-md-8">
				 <label for="name" class="col-md-4">Upload Image</label>
				 <input type="file" name="image" />
				<input type="submit" name = "upload" value="Upload" class="btn btn-primary"/>
                <input type="submit" name="remove" value="Remove" class="btn btn-primary"/>
				
				<span><?php echo $msg;?></span>
				</div> 	
				
				
           <div class="form-group col-md-8 col-md-offset-3 " id="errorfirst" style="color:#FF0000"></div>
            <div class='form-group col-md-8 col-md-offset-2'>
             <button class='btn-lg btn-primary col-md-offset-4' id="btnReview" type='button' onClick="return validfirstform()">Next</button>
          
        </div>   
             </div>    
           
       
        <div class="tab-pane newboxes" id="tab_b">
         
            <div class='form-group col-md-8'>
                <label class='control-label col-md-2 col-md-offset-2' for='id_comments'>Address</label>
                <div class='form-group internal col-md-6'>
                  <textarea class='form-control' id='address' name="address" placeholder='Address' 
                   rows='3'><?php echo $parent['Address']; ?></textarea>
                </div>
          </div>
          <div class='form-group col-md-8'>
            <label class='control-label col-md-2 col-md-offset-2' for='id_equipment'>Country<span style="color:red;">*</span></label>
          
              
                <div class='form-group internal col-md-4 '>
               <input type="text" class='form-control' id='country' placeholder='Country' name="country" value='<?php echo $parent['country']; ?>'>
                </div>
             
             
            </div>
         
           <div class='form-group col-md-8'>
                <label class='control-label col-md-2 col-md-offset-2' for='id_equipment'>State<span style="color:red;">*</span></label>
            
             
                <div class='form-group internal col-md-4 '>
                  <input type="text" class='form-control' id='state' placeholder='State' name="state" value='<?php echo $parent['state']; ?>'>
                </div>
             
          	</div>
              <script language="javascript">
            populateCountries("country", "state");
            populateCountries("country2");
        	</script>
            <div class='form-group col-md-8'>
                <label class='control-label col-md-2 col-md-offset-2' for='id_equipment'>City<span style="color:red;">*</span></label>
            
             
                <div class='form-group internal col-md-4 '>
                   <input type="text" class='form-control' id='id_accomodation' placeholder='City' name="city" value='<?php echo $parent['city']; ?>'>
                </div>
             
          	</div>
            <div class='form-group col-md-8'>
                <label class='control-label col-md-2 col-md-offset-2' for='id_equipment'>Phone<span style="color:red;">*</span></label>
            
             
                <div class='form-group internal col-md-4 '>
                   <input type="text" class='form-control' id='phone' placeholder='Phone' name='phone' value='<?php echo $parent['Phone']; ?>'>
                </div>
             
          	</div>
            
            
             <div class="form-group col-md-8 col-md-offset-3 " id="errorsecond" style="color:#FF0000"></div>
            <div class='form-group col-md-8 col-md-offset-2'>
             <button class='btn-lg btn-primary col-md-offset-4' id="btnReview1" type='button' onClick="return validsecond()">Next</button>
          
        </div>  
            
        </div>
        <div class="tab-pane newboxes" id="tab_c">
             <div class='form-group col-md-8 col-md-offset-2'>
                <label class='control-label col-md-4 ' for='id_comments'>Email ID<span style="color:red;">*</span></label>
                <div class='form-group internal col-md-6'>
                <input type="text" class='form-control' id='email' name="email_id" placeholder='Email Id' value='<?php echo $parent['email_id']; ?>'>
                </div>
          </div>
          <div class='form-group col-md-8 col-md-offset-2'>
            <label class='control-label col-md-4 ' for='id_equipment'>Password</label>
          
              
                <div class='form-group internal col-md-6 '>
                  <input type="password" class='form-control' id='password' name="password" placeholder='password' value='<?php echo $parent['Password']; ?>' onBlur="return validpassword()">
                </div>
             
             
            </div>
            <div class='form-group col-md-8 col-md-offset-2'>
            <label class='control-label col-md-4 ' for='id_equipment'>Confirm Password</label>
          
              
                <div class='form-group internal col-md-6 '>
                  <input type="password" class='form-control' id='cnfpassword' name="password1" placeholder='password' onBlur="return validate()" value='<?php echo $parent['Password']; ?>'>
                </div>
             
             
            </div>
             <div class="form-group col-md-8 col-md-offset-3 " id="error" style="color:#FF0000"></div>
            <div class='form-group col-md-8 col-md-offset-5'>
            <input type="submit" name="submit" value="Submit" style="width:100px; height:35px; background-color:#0080C0; color:#FFFFFF;" onClick="return valid()"/>
            </div>
             
        </div>
    </form>
            
        </div>
</div><!-- tab content -->
</div><!-- end of container -->


  </body>
</html>