<?php
include("cookieadminheader.php");
$report="";
$report1="";
	if(isset($_POST['submit'])){		
		$email = $_POST['id_email'];
		$phone=$_POST['id_phone'];
		$counts=0;
		//for sponsor
		$row1=mysql_query("select * from tbl_salesperson where p_email='$email'");
		if(mysql_num_rows($row1)>0){
			$counts=1;  
			$report="Email ID Is Already Present";
		}
		$count1=0;
		//for sponsor
		$row1=mysql_query("select * from tbl_salesperson where p_phone='$phone'");
		if(mysql_num_rows($row1)>0){
			$count1=1; 
			$report="Phone Number Already Exist";
		}elseif(($counts==0)&&($count1==0)){				
			$id_first_name = $_POST['id_first_name'];
			$id_last_name = $_POST['id_last_name'];
			$name=$id_first_name." ".$id_last_name;
			$password = $_POST['password'];
			$phone = $_POST['id_phone'];					
			if(isset($_FILES['profileimage']['name'])){
				$images= $_FILES['profileimage']['name'];
				$without_extension = pathinfo($images, PATHINFO_FILENAME);
				$ex_img = pathinfo($images, PATHINFO_EXTENSION);

				//date format changes by sachin 03-10-2018
				// $img_name = $without_extension."_".$id."_".date('mdY').".".$ex_img;
					$img_name = $without_extension."_".$id."_".date('Ymd').".".$ex_img;
				//End date format changes by sachin 03-10-2018


				
				$full_name_path = "salesapp_image/".$img_name;
				move_uploaded_file($_FILES['profileimage']['tmp_name'],$full_name_path);
				$sqls= "INSERT INTO `tbl_salesperson`(p_name,p_email, p_phone, p_password,p_image) VALUES ('$name', '$email',  '$phone','$password','$full_name_path')";
				$count = mysql_query($sqls) or die(mysql_error()); 										
			}
			else{													
				$sqls= "INSERT INTO `tbl_salesperson`(p_name,p_email, p_phone, p_password) VALUES ('$name', '$email',  '$phone','$password')";
				$count = mysql_query($sqls) or die(mysql_error()); 
			}				
			if($count>=1){
				echo ("<script type='text/javascript'>alert('Successfully Registered'); window.location.href='salesperson_list_cookie.php';</script>");
		    }
				
		}
	}
?>
	<html>
		<head>
			<meta charset="utf-8">
			<title>Smart Cookies</title>
			<style>
			textarea {
			   resize: none;
			}
			.style1 {color: #FF0000}
			</style>
	 
			<!-- Bootstrap CSS and bootstrap datepicker CSS used for styling the demo pages-->	
			<script src='js/bootstrap-datepicker.min.js' type='text/javascript'></script>
			<script type="text/javascript">
				$(document).ready(function () {
					$('#dob').datepicker({});  
				});
			</script>        
			<!--Start Validation for first name,last name,image and also added country code field By Dhanashri Tak-->
				<script>
					function valid()  {
						var first_name=document.getElementById("id_first_name").value; 
						var last_name=document.getElementById("id_last_name").value;
						if(first_name.trim()=="" || first_name.trim()==null || last_name.trim()=="" || last_name.trim()==null){
							document.getElementById("errorname").innerHTML="Please Enter valid Name";	
								return false;
						}			
						regx1=/^[A-z ]+$/;
							//validation for name
						if(!regx1.test(first_name) || !regx1.test(last_name)){
							document.getElementById('errorname').innerHTML='Please Enter valid Name';
							return false;
						}
						var regname=/^\S+(?: \S+)*$/;
						if((!regname.test(first_name )) || (!regname.test(last_name ))){
							document.getElementById('errorname').innerHTML='Incorrect Name';
							return false;
						}
						else{
							document.getElementById('errorname').innerHTML='';
						}
						// validation for email	  
						var email=document.getElementById("id_email").value;
						if(email==null||email==""){
							document.getElementById('erroremail').innerHTML='Please Enter Email ID';
							return false;
						}	
						var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;  
						if(!email.match(mailformat)){  
							document.getElementById('erroremail').innerHTML='Please Enter valid Email ID';
							return false;  
						} 
						else{
							document.getElementById('erroremail').innerHTML='';			
						}
						
						// validation of phone	
						var phone = /^(\+91[\-\s]?)?[0]?(91)?[789]\d{9}$/;
						var id_phone=document.getElementById("id_phone").value;
						if(id_phone==""){   
							document.getElementById('errorphone').innerHTML='Please Enter Phone No';
							return false;
						}			
						if(phone.test(id_phone)== false){
							document.getElementById('errorphone').innerHTML='Invalid Phone Number';
							return false;
						}			
						if(isNaN(id_phone)|| id_phone.indexOf(" ")!=-1){			  
							document.getElementById('errorphone').innerHTML='Please Enter valid Phone No';
						   return false; 				   
						}
						if (id_phone.length > 10){
							document.getElementById('errorphone').innerHTML='Please Enter valid Phone No';
							return false; 
						}
						if (id_phone.length < 10 ){
						  document.getElementById('errorphone').innerHTML='Please Enter valid Phone No';				   
							return false; 
						}		   
						else{
							document.getElementById('errorphone').innerHTML='';
						}
					
						//validation of country
						var password=document.getElementById("password").value;
						var cnfpassword=document.getElementById("cnfpassword").value;	
						if(password.trim()==""){
							document.getElementById("errorpassword").innerHTML="Please Enter valid Password";	
							return false;
						}
						if(password==null||password==""){
							document.getElementById('errorpassword').innerHTML='Please Enter Password';
							return false;
						}
						var pass=/^\S+(?: \S+)*$/;
						if(!pass.test(password )){
							document.getElementById('errorpassword').innerHTML='Please Enter Password';
							return false;
						}
						if(cnfpassword==null||cnfpassword==""){
							document.getElementById('errorpassword').innerHTML='Please Enter Confirm Password';			
							return false;			
						}		  
						if(password!=cnfpassword){  
							document.getElementById('errorpassword').innerHTML='Password Does Not Match With Confirm Password';	
							return false;
						}else{
							document.getElementById('errorpassword').innerHTML='';
						}
						var pimage=document.getElementById("profileimage").value;	
						 if(pimage==null||pimage==""){
							document.getElementById('errorpimg').innerHTML='Please Choose File';
							return false;
						}	   
					}	   
				</script>      
			<!--Stop Validation for first name,last name,image and also added country code field By Dhanashri Tak-->	
				<script>
					function isNumberKey(evt){
						var charCode = (evt.which) ? evt.which : event.keyCode
						if (charCode > 31 && (charCode < 48 || charCode > 57))
							return false;
						return true;
					}
				</script>
				<script>
					function fileValidation(){
						var fileInput = document.getElementById('profileimage');
						var filePath = fileInput.value;
						var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
						if(!allowedExtensions.exec(filePath)){
							alert('Please upload file having extensions .jpeg/.jpg/.png/.gif only.');
							fileInput.value = '';
							return false;
						}
					}
				</script>
		</head>
		<body>
			<div id="head"></div>
			<div id="login">
			<form action="" method="post" enctype="multipart/form-data">			
				<div class='container'>
					<div class='panel panel-primary dialog-panel' style="background-color:radial-gradient(ellipse at center center , #E5E5E5 0%, #FFF 100%) repeat scroll 0% 0% transparent;">
						<div style="color:red;font-size:15px;font-weight:bold;margin-top:10px;background-color:radial-gradient(ellipse at center center , #E5E5E5 0%, #FFF 100%) repeat scroll 0% 0% transparent;" align="center"> <?php echo $report;?></div>
							<div class='panel-heading' style="background-color:radial-gradient(ellipse at center center , #E5E5E5 0%, #FFF 100%) repeat scroll 0% 0% transparent;">   
								<div class="row">  
									<div class="col-md-4"></div><div  class="col-md-5"> <h3 >Salesperson Registration </h3></div>
								</div>
							</div>
							<div class='panel-body'>
								<!--form class='form-horizontal' role='form' method="post"-->
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
										<div class='col-md-2 indent-small' id="errorname" style="color:#FF0000"></div>
									</div>
    
									<div class='row form-group'>
										<label class='control-label col-md-3 col-md-offset-1' >Email ID<span class="style1"> *</span></label>
										<div class='col-md-3 form-group internal'>
											<input class='form-control' id='id_email' name="id_email"  placeholder='E-mail' type='text' value="<?php if(isset($_POST['id_email'])){echo $_POST['id_email'];}?>">
										</div>
					  
										<div class='col-md-3 indent-small' id="erroremail" style="color:#FF0000"></div>
									</div>
                
									<!--Added Country code-->
										<div class='row form-group'>
											<label class='control-label col-md-3 col-md-offset-1' >Country Code<span class="style1"> *</span></label>
											<div class='col-md-3 form-group internal'>
											 <select name='CountryCode' id='CountryCode' class='form-control'>
												<option value="91">91</option>
												<option value="1" >1</option> 
											</select>
											</div>
											<div class='col-md-2 indent-small' id="errorcode" style="color:#FF0000"></div>
										</div>
									<!--End-->   
									<div class='row form-group'>
										<label class='control-label col-md-3 col-md-offset-1' >Phone No.<span class="style1"> *</span></label>
										<div class='col-md-3 form-group internal'>
										 <input class='form-control' id='id_phone' name="id_phone"  placeholder='Phone Number' type='text'  value="<?php if(isset($_POST['id_phone'])){echo $_POST['id_phone'];}?>" onKeyPress="return isNumberKey(event)">
										</div>
										<div class='col-md-3 indent-small' id="errorphone" style="color:#FF0000"></div> 
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
									<div class="row form-group">
										<label class='control-label col-md-3 col-md-offset-1' for='id_checkin'>Profile Image <span class="style1">*</span></label>
										<div class='col-md-3 form-group internal'>
											<input type="file" id="profileimage" name="profileimage" onChange="return fileValidation()" >           
										</div>
										<div class='col-md-3 indent-small' id="errorpimg" style="color:#FF0000"></div>
									</div>
									<div class='row form-group'>
										<div class='col-md-2 col-md-offset-4' >
											<input class='btn-lg btn-primary' type='submit' value="Submit" name="submit" onClick="return valid()"/>
										</div>
										<div class='col-md-3'>
											 <a href="salesperson_list_cookie.php"><input class='btn-lg btn-danger' type='button' value="Back" name="submit"/></a>
										</div>
									</div>	
								</form>
							</div>
					</div>
				</div>	
			</form>	
			</div>			
		</body>
	</html>