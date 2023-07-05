<?php

include("cookieadminheader.php");
$server = $_SERVER['SERVER_NAME'];
$report="";
$report1="";
				/*Done changes for validation and also change message by Dhanashri_Tak  */

if(isset($_GET['delete_id'])){
    $delete_salesperson=$_GET['delete_id'];
//    echo $delete_salesperson;die;
    $sql1 = "delete from tbl_salesperson where `person_id`='$delete_salesperson'";
    $row = mysql_query($sql1);
    header('location:/core/salesperson_list_cookie.php');
}
if(isset($_GET['Edit_id'])){
    $salesupdateid=$_GET['Edit_id'];
    $sql1 = "SELECT * FROM `tbl_salesperson` WHERE person_id='$salesupdateid'";
    $row = mysql_query($sql1);
    $results = mysql_fetch_array($row);
}
if(isset($_POST['submit']))
{
        $email = $_POST['id_email'];
        $phone=$_POST['id_phone'];
        $id_first_name = $_POST['id_first_name'];
        $Country_code = $_POST['Country_code'];
        //$id_last_name = $_POST['id_last_name'];
       // $name=$id_first_name." ".$id_last_name;
        $name=$id_first_name;
        $password = $_POST['password'];
        $phone = $_POST['id_phone'];

 if(isset($_FILES['profileimage']['name']))
        {
            $images= $_FILES['profileimage']['name'];
            $ex_img = explode(".",$images);

			//date format changes by sachin 03-10-2018
			// $img_name = $ex_img[0]."_".$id."_".date('mdY').".".$ex_img[1];
				 $img_name = $ex_img[0]."_".$id."_".date('Ymd').".".$ex_img[1];
			//End date format changes by sachin 03-10-2018

           
            $full_name_path = "salesapp_image/".$img_name;
            move_uploaded_file($_FILES['profileimage']['tmp_name'],$full_name_path);
            $sqls= "UPDATE tbl_salesperson SET `p_name`='$name',`p_email`='$email', `p_password`='$password',`p_phone`='$phone',`p_image`='$full_name_path',`CountryCode`='$Country_code' WHERE `person_id`='$salesupdateid'";
            $count = mysql_query($sqls) or die(mysql_error());
            header("Location:salesperson_list_cookie.php");//retrive current inserted record id
        }
        else
        {
            $sqls= "UPDATE tbl_salesperson SET `p_name`='$name',`p_email`='$email', `p_password`='$password',`p_phone`='$phone',`CountryCode`='$Country_code' WHERE `person_id`='$salesupdateid'";
            $count = mysql_query($sqls) or die(mysql_error());
        }
        if($count>=1){

			 echo ("<script LANGUAGE='JavaScript'>
				window.alert('Successfully Updated');
				window.location.href='salesperson_list_cookie.php';
				</script>");
		
            //$report="Successfully Updated";
			  //header( "refresh:0; url=edit_salesperson.php" );

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
    </style>
    <script src='js/bootstrap-datepicker.min.js' type='text/javascript'></script>
    <script type="text/javascript">
        // When the document is ready
        $(document).ready(function () {
            $('#dob').datepicker({
            });
        });
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
    <script>

	function valid()
	{
		var first_name1 = /^[A-z ]+$/;
		var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
		//var phone=/^(?:(?:\+|0{0,2})91(\s*[\ -]\s*)?|[0]?)?[789]\d{9}|(\d[ -]?){10}\d$/;
          var phone=/^[6789]\d{9}$/;
		var first_name=document.getElementById("id_first_name").value;
		var email=document.getElementById("id_email").value;
	    var Country_code = document.getElementById("Country_code");
		var id_phone=document.getElementById("id_phone").value;
		var password=document.getElementById("password").value;
        var cnfpassword=document.getElementById("cnfpassword").value;

		
		///Name
				if(first_name.trim()=="" || first_name.trim()==null)
					{
						document.getElementById("errorname").innerHTML="Please Enter valid Name";	
							return false;
					}	
				if (first_name1.test(first_name)==false)
					{
						document.getElementById("errorname").innerHTML="Please Enter valid Name";	
							return false;
					}
					var regname=/^\S+(?: \S+)*$/;
				if(!regname.test(first_name ))
					{
						document.getElementById('errorname').innerHTML='Incorrect Name';
						return false;
					}
				
				else
					{
					document.getElementById("errorname").innerHTML="";	
					}	
					
    /////Email
				if(email=="" || email==null)
					{
						document.getElementById("erroremail").innerHTML="Please Enter email id";	
							return false;	
					}
					if(mailformat.test(email)==false)
					{
						document.getElementById("erroremail").innerHTML="Please Enter valid email id";	
							return false;
					}
					else
					{
						document.getElementById("erroremail").innerHTML="";	
						
					}

		///Country Code
		          if(Country_code.value == "-1")
				  {

				 // alert('Select your country code from the list');
				  
				  	document.getElementById("errorcode").innerHTML="Please Select your country code";	
							return false;
					}
					else
					{
						document.getElementById("errorcode").innerHTML="";	
						
					}
		//Phone
		if(id_phone=="")
            {
                document.getElementById('errorphone').innerHTML='Please Enter Phone no';
                return false;
            }
			if(phone.test(id_phone)==false)
			{
				document.getElementById('errorphone').innerHTML='Please Enter valid Phone no';
                return false;
			}
            if(isNaN(id_phone)|| id_phone.indexOf(" ")!=-1)
            {
                document.getElementById('errorphone').innerHTML='Please Enter valid Phone no';
                return false;
            }
           if (id_phone.length > 10 )
            {
                document.getElementById('errorphone').innerHTML='Please Enter valid Phone no';
                return false;
            }
            if (id_phone.length < 10 )
            {
                document.getElementById('errorphone').innerHTML='Please Enter valid Phone no';
                return false;
            }
            else
            {
                document.getElementById('errorphone').innerHTML='';
            }

	//Password
	       if(password.trim()=="")
			{
				document.getElementById("errorpassword").innerHTML="Please Enter valid Password";	
					return false;
			}
	          if(password==null||password=="")
            {
                document.getElementById('errorpassword').innerHTML='Please Enter Password';
                return false;
            }
			var pass=/^\S+(?: \S+)*$/;
			if(!pass.test(password ))
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

		 var pimage=document.getElementById("profileimage").value;	

	     if(pimage==null||pimage=="")
			{
			   
				document.getElementById('errorpimg').innerHTML='Please Choose File';
				
				return false;
		
			
		}

		
		
	}
	
       /* function valid()
        {
            //validaion for compnay name
            // validation for name
		    var Country_code = document.getElementById("Country_code");
            var first_name=document.getElementById("id_first_name").value;
            var last_name=document.getElementById("id_last_name").value;

            if(first_name==null||first_name=="" || last_name==null|| last_name=="" )

            {
                document.getElementById('errorname').innerHTML='Please enter Name';
                return false;
            }

            regx1=/^[A-z ]+$/;
            //validation for name
            if(!regx1.test(first_name) || !regx1.test(last_name))
            {
                document.getElementById('errorname').innerHTML='Please enter valid Name';
                return false;
            }
            else
            {
                document.getElementById('errorname').innerHTML='';
            }
            //date of birth
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

			 if(Country_code.value == "-1")
				  {
				  alert('Select your Country Code from the list');
				  
				  return false;
				  }

            // validation of phone
            var id_phone=document.getElementById("id_phone").value;
            if(id_phone=="")
            {
                document.getElementById('errorphone').innerHTML='Please Enter Phone no';
                return false;
            }
            if(isNaN(id_phone)|| id_phone.indexOf(" ")!=-1)
            {
                document.getElementById('errorphone').innerHTML='Please Enter valid Phone no';
                return false;
            }
            if (id_phone.length > 10 )
            {
                document.getElementById('errorphone').innerHTML='Please Enter valid Phone no';
                return false;
            }
            if (id_phone.length < 10 )
            {
                document.getElementById('errorphone').innerHTML='Please Enter valid Phone no';
                return false;
            }
            else
            {
                document.getElementById('errorphone').innerHTML='';
            }
            //validation of country
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
        }*/

    </script>

    <script>
        function isNumberKey(evt){
            var charCode = (evt.which) ? evt.which : event.keyCode
            if (charCode > 31 && (charCode < 48 || charCode > 57))
                return false;
            return true;
        }
    </script>

    <style type="text/css">
        <!--
        .style1 {color: #FF0000}
        -->
    </style>
</head>
<body>
<div id="head"></div>
<div id="login">
    <!--<h1><strong>Welcome.</strong> Please register.</h1>-->
    <form action="" method="post" enctype="multipart/form-data">
        <div class='container'>
            <div class='panel panel-primary dialog-panel' style="background-color:radial-gradient(ellipse at center center , #E5E5E5 0%, #FFF 100%) repeat scroll 0% 0% transparent;">
                <div style="color:green;font-size:15px;font-weight:bold;margin-top:10px;background-color:radial-gradient(ellipse at center center , #E5E5E5 0%, #FFF 100%) repeat scroll 0% 0% transparent;" align="center"> <?php echo $report;?></div>
                <div class='panel-heading' style="background-color:radial-gradient(ellipse at center center , #E5E5E5 0%, #FFF 100%) repeat scroll 0% 0% transparent;">
                    <div class="row">  <div class="col-md-4"></div><div  class="col-md-5"> <h3 >Edit Salesperson </h3></div>
                        <div class="col-md-5">
                        </div>
                    </div>
                </div>
                <div class='panel-body'>
                    <form class='form-horizontal' role='form' method="post">
                        <div class="row form-group">
                            <label class='control-label col-md-3 col-md-offset-1' >Name <span class="style1">*</span></label>
                            <div  id="catList"></div>
                            <div class='col-md-3' >
                                <div class='form-group internal '>
                                    <input class='form-control' id='id_first_name' name="id_first_name" placeholder=' Name' type='text' value="<?php echo $results['p_name'];?>">
                                </div>
                            </div>
                            <!--<div class='col-md-3 indent-small' >
                                <div class='form-group internal '>
                                    <input class='form-control' id='id_last_name' name="id_last_name" required placeholder='Last Name' type='text' value="<?php /*if(isset($_POST['id_last_name'])){echo $_POST['id_last_name'];}*/?>">
                                </div>
                            </div>-->
                            <div class='col-md-2 indent-small' id="errorname" style="color:#FF0000">
                            </div>
                        </div>
                        <div class='row form-group'>
                            <label class='control-label col-md-3 col-md-offset-1' >Email ID<span class="style1"> *</span></label>
                            <div class='col-md-3 form-group internal'>
                                <input class='form-control' id='id_email' name="id_email"  placeholder='E-mail' type='text' value="<?php echo $results['p_email'];?>">
                            </div>
                            <div class='col-md-3 indent-small' id="erroremail" style="color:#FF0000"></div>
                        </div>
						<!---->
						
                        <div class='row form-group'>
                            <label class='control-label col-md-3 col-md-offset-1' >Country Code<span class="style1"> *</span></label>
                            <div class='col-md-3 form-group internal'>
                              <!-- <input class='form-control' id='Country_code' name="Country_code"  placeholder="Country code" min="1"  type='number' value="<?php echo $results['CountryCode']?>" >-->
					  <select name='Country_code' id='Country_code' class='form-control'>
					  <option value="-1" selected>Select</option>
						  <option value='91' <?php if ($results['CountryCode'] == 91) {
								echo 'selected';
							} ?>>+91</option>
							<option value='1' <?php if ($results['CountryCode'] == 1) {
								echo 'selected';
							} ?>>+1</option>
						</select>
									</div><div class='col-md-2 indent-small' id="errorcode" style="color:#FF0000">
                            </div>
									</div>
								<div class='row form-group'>
                            <label class='control-label col-md-3 col-md-offset-1' >Phone No.<span class="style1"> *</span></label>
                            <div class='col-md-3 form-group internal'>
                                <input class='form-control' id='id_phone' name="id_phone"  placeholder='Enter Phone number' type='text' value="<?php echo $results['p_phone'];?>" onKeyPress="return isNumberKey(event)">
                            </div>
                            <div class='col-md-3 indent-small' id="errorphone" style="color:#FF0000"></div>
                        </div>    
						
						<!---->
						
                        <div class='row form-group'>
                            <label class='control-label col-md-3 col-md-offset-1' >Password<span class="style1"> *</span></label>
                            <div class='col-md-3 form-group internal'>
                                <input class='form-control' id='password' name='password' placeholder='Password' value="<?php echo $results['p_password'];?>" type='password'  >
                            </div>
                        </div>
                        <div class='row form-group'>
                            <label class='control-label col-md-3 col-md-offset-1' >Confirm Password <span class="style1">*</span></label>
                            <div class='col-md-3 form-group internal'>
                                <input class='form-control' id='cnfpassword' name="cnfpassword" placeholder='Confirm Password' value="<?php echo $results['p_password'];?>" type='password'  >
                            </div>
                            <div class='col-md-3 indent-small' id="errorpassword" style="color:#FF0000"></div>
                        </div>
                        <div class="row form-group">
                            <label class='control-label col-md-3 col-md-offset-1' for='id_checkin'>Profile image </label>
                            <div class='col-md-3 form-group internal'>
                                <input type="file" id="profileimage" name="profileimage"   onChange="return fileValidation()"><span><?php echo $results['p_image'];?></span>
							<!--<?php if(isset($results['p_image']))
							{
							?>
									<label><span><?php echo $results['p_image'];?></span></label>
							<?php 
							}
							else{ 
							?>
							<label id="profileimage1"><span><?php echo "please enter"?></span></label>
								
								<?php }?>-->
                            </div>
                        </div>

                        <div class="row" style="margin-left: 114px; padding-top: 10px;" >
                            <div class='row form-group'>
<!--                                <div class='col-md-4 col-md-offset-5' >-->
                             <div class='col-md-2 col-md-offset-3'>
                               
                                    <input class='btn-lg btn-primary' type='submit' value="Submit" name="submit" onClick="return valid();"/>
                                </div>&nbsp;&nbsp;
								   <div class='col-md-3'>
                                    <a href="salesperson_list_cookie.php"><input class='btn-lg btn-danger' type='button' value="Back" name="submit"/></a>
                                </div>
                            </div>
                        </div>
                        </div>
                    </form>
                </div>
</body>
</html>