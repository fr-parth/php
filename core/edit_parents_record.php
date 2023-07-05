<?php
ob_start();
	include("scadmin_header.php");

	$id=base64_decode($_REQUEST['id']);

	$sql=mysql_query("SELECT p.Name,p.Phone,p.Address,p.city,p.state,p.country,p.Qualification,p.Occupation,p.Mother_name,p.DateOfBirth,p.FamilyIncome,p.email_id,s.std_name,p.std_PRN,s.std_Father_name,s.std_lastname,s.std_complete_name 
	FROM tbl_parent p 
	JOIN tbl_student s ON p.std_PRN=s.std_PRN and p.school_id=s.school_id
	WHERE p.Id='$id'");
		
		
	$result=mysql_fetch_array($sql);

			
					
		if($result['std_complete_name']=="")
		{
			$std_name=$result['std_name']." ".$result['std_Father_name']." ".$result['std_lastname'];
		}
		
		else
		{
			$std_name=$result['std_complete_name'];
		}
							
							
							

		if(isset($_POST['submit']))
		{
			  $id=base64_decode($_REQUEST['id']);
			  $Name=$_POST['Name'];
			  $Phone=$_POST['Phone'];
			  $email=$_POST['email'];
			  
			  
			  $Occupation=$_POST['Occupation'];
			  $FamilyIncome=$_POST['FamilyIncome'];
			  $site=$_SERVER['SERVER_NAME'];
			  $id_checkin=$_POST['id_checkin'];
			  $id_address=$_POST['id_address'];
			  $country=$_POST['country'];
			  $state=$_POST['state'];
			  $city=$_POST['city'];
			  $qualification=$_POST['qualification'];
			  $mname=$_POST['mname'];
							
							
							
							

		 $ql="UPDATE `tbl_parent` SET `Name`='$Name',`Phone`='$Phone',`Occupation`='$Occupation',`FamilyIncome`='$FamilyIncome',email_id='$email', Address='$id_address', DateOfBirth='$id_checkin', Mother_name='$mname',country='$country',
		 state='$state',city='$city',Qualification='$qualification'
		 
		 
		 WHERE `Id`='$id'";
			 $qr=mysql_query($ql);
			 
			 if($qr)
			 {
					echo "<script>alert('Updated Successfully')</script>";
					header( "refresh:0; url=parents_list.php" );
			 }
		}
		
?>
<!DOCTYPE html>
<head>
    <style>
        body {
            background-color: #F8F8F8;
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
            font: 600 15px "Open Sans", Arial, sans-serif;
        }
        label.control-label {
            font-weight: 600;
            color: #777;
        }
    </style>
	      
	<script src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>
            <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
			<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
    <script src="js/jquery-1.11.1.min.js"></script>
	<link rel="stylesheet" href="css/bootstrap.min.css">
        <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
		<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
    <script src='js/bootstrap-datepicker.min.js' type='text/javascript'></script>
            <script src="js/city_state.js" type="text/javascript"></script>
            <link href='css/datepicker.min.css' rel='stylesheet' type='text/css'>  
    	<script type="text/javascript">
    
	 
            $(function () {

                $("#id_checkin").datepicker({
					 changeYear: true,
                    changeMonth: true 
                });

            });
        </script>
    <script>
	
$(document).ready(function() 
 {  
	 $("#id_email").on('change',function(){ 	 
		 var dup_email = document.getElementById("id_email").value;

		 $.ajax({
			 type:"POST",
			 data:{dup_email:dup_email}, 
			 url:'email_validation.php',
			 success:function(data)
			 {
				 if(data == 0)
				 {
					  $(data).hide();
				 }
				 else{
					 
			           alert("Email ID already present...Please try another one");
					  $('#id_email').val("");
				 }
				// $('#managerList').html(data);
			 }
			 
			 
		 });
		 
	 });
     
 });
        function valid() {
            var first_name = document.getElementById("Name").value;
            if (first_name == null || first_name == "") {
               alert("Please Enter Name");
                return false;
            }
            regx1 = /^[A-z ]+$/;
            //validation for name
            if (!regx1.test(first_name)) {
                alert("Please Enter Valid Name");
                return false;
            }
           
			var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

            var email = document.getElementById("email").value;
			if(email=='')
			{
				alert("Please Enter Email ID");
			}
			

          else if (!email.match(mailformat)) {
               alert("Please Enter valid email ID");

                return false;
            }
            else {
                document.getElementById('erremail').innerHTML = '';
            }
            

            var phone1 = document.getElementById("Phone").value;
			var phone=phone1.trim();
				if(phone=='')
			{
				alert("Please Enter Phone Number");
			}
          else if(phone!=''){
				var pattern = /^[6789]\d{9}$/;
				
				if (!pattern.test(phone)) {
				   alert("Please enter 10 digits number!");
					return false;
				}
				
		}
            

             var id_checkin=document.getElementById("id_checkin").value;
					 var myDate = new Date(id_checkin);

                  

				var today = new Date();
				if(id_checkin=="")
			{
	
			   
				
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




            var gender1 = document.getElementById("gender1").checked;

            var gender2 = document.getElementById("gender2").checked;

            if (gender1 == false && gender2 == false) {
                document.getElementById('errorgender').innerHTML = 'Please Select gender';
                return false;
            }
            else {
                document.getElementById('errorgender').innerHTML = '';
            }

            
             var country = document.getElementById("country");

                    if (country.value == "-1" || country.value == '') {

                        alert("Please select country");
                        return false;
                    }
                    

                    var state = document.getElementById("state");
                    if (state.value == "" || state.value == "-1" ) {

                         alert("Please select state");
                        return false;
                    }
                    
					
					var id_city = document.getElementById("city").value;
				 
				    var pattern = /^[a-zA-Z ]+$/;
					if(id_city.trim()=="" || id_city.trim()==null)
					{
						alert("Please enter city!");
						return false;
					}
					else if (!pattern.test(id_city)) {
						alert("Please enter valid city!");
						return false;
					}

            var address = document.getElementById("id_address").value;
           /* if (address == null || address == "") {

                document.getElementById('erroraddress').innerHTML = 'Please Enter address';

                return false;
            }
            else {
                document.getElementById('erroraddress').innerHTML = '';
            }*/
          
        }
    </script>
</head>
<body>
<div class="container" style="padding:10px;" align="center">
        <div class="row">
            <div class="col-md-3">
            </div>
            <div class="col-md-12">
                <div class="container" style="padding:25px;">
                    <div style="padding:2px 2px 2px 2px;border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;background-color:#F8F8F8 ;">
                        <form method="post">
                            <div class="row"
                                 style="color: #666;height:100px;font-family: 'Open Sans',sans-serif;font-size: 12px;">
                                <h2>Edit Parent Record</h2>
                            </div>
                            <div class="row ">
                                <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">
                                    <b> Parent Name:<span style="color:red;font-size: 25px;">*</span></b>
                                </div>
                                <div class="col-md-5 form-group">
                                    <input type="text" name="Name" id="Name" class="form-control" style="width:100%; padding:5px;" placeholder="Parent_Name" value="<?php echo $result['Name'] ?>"/>
									<div class="col-md-13" style="color:#FC2338; font-size:15px;" id="errName"></div>
                                </div>

                                <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">
                                    <b> <?php echo $dynamic_student_prn; ?>:<span style="color:red;font-size: 25px;">*</span></b>
                                </div>
                                <div class="col-md-5 form-group">
                                    <input type="text" name="std_PRN" id="std_PRN" class="form-control" style="width:100%; padding:5px;" placeholder="Student_PRN" value="<?php echo $result['std_PRN'];?>" readonly="readonly"/>
                                </div>

                                <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">
                                    <b> <?php echo $dynamic_student; ?> Name:<span style="color:red;font-size: 25px;">*</span></b>
                                </div>
                                <div class="col-md-5 form-group">

                                    <input type="text" name="Student_Name" id="Student_Name" class="form-control" style="width:100%; padding:5px;" placeholder="Student_Name" value="<?php echo $std_name;?>" readonly="readonly"/>
                                </div>

                                <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">
                                    <b> Phone:<span style="color:red;font-size: 25px;">*</span></b>
                                </div>
                                <div class="col-md-5 form-group">
                                    <input type="text" name="Phone" id="Phone" class="form-control" style="width:100%; padding:5px;" placeholder="Phone" value="<?php echo $result['Phone'];?>"/>
									<div class="col-md-13" style="color:#FC2338; font-size:15px;" id="errPhone"></div>
                                </div>
								  <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">
                                    <b> Email:<span style="color:red;font-size: 25px;">*</span></b>
                                </div>
                                <div class="col-md-5 form-group">
                                    <input type="text" name="email" id="email" class="form-control" style="width:100%; padding:5px;" placeholder="email" value="<?php echo $result['email_id'];?>"/>
									<div class="col-md-13" style="color:#FC2338; font-size:15px;" id="erremail"></div>
                                </div>
								 <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">
                                    <b> Date Of Birth :<span style="color:red;font-size: 25px;"></span></b>
                                </div>
                        <div class="col-md-5 form-group">
                                    <input class='form-control datepicker' id="id_checkin" name="id_checkin" class="form-control" value="<?php echo $result['DateOfBirth'];?>"/>
                                
                                <div class='col-md-15' id="errordob" style="color:#FF0000"></div>
                            </div>
							
							 <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">
                                    <b> Address:<span style="color:red;font-size: 25px;"></span></b>
                                </div>
                                <div class="col-md-5 form-group">
                                     <input type="text" class='form-control' id='id_address' name="id_address" placeholder='Address' rows='3' style="resize:none;" maxlength="200"value="<?php echo $result['Address'];?>"/>
									<div class="col-md-13" style="color:#FC2338; font-size:15px;" id="errAddress"></div>
                                </div>
								 <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">
                                    <b> Country:<span style="color:red;font-size: 25px;"></span></b>
                                </div>
                        <div class="col-md-5 form-group">
                             <select id="country" name="country" class='form-control'></select>
                        </div>
                       <div class="col-md-13" style="color:#FC2338; font-size:15px;" id="errOccupation"></div>
					   
					    <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">
                                    <b> State:<span style="color:red;font-size: 25px;"></span></b>
                                </div>
                        <div class="col-md-5 form-group">
                            <select name="state" id="state" class='form-control'>
					
					</select>
                        </div>
                       <div class="col-md-13" style="color:#FC2338; font-size:15px;" id="errOccupation"></div>
                        <script language="javascript">
                        populateCountries("country", "state");
                        populateCountries("country2");
                    </script>
					   
					    <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">
                                    <b> City:<span style="color:red;font-size: 25px;"></span></b>
                                </div>
                                <div class="col-md-5 form-group">
                                    <input type="text" name="city" id="city" class="form-control" style="width:100%; padding:5px;" placeholder="city" value="<?php echo $result['city'];?>"/>
									<div class="col-md-13" style="color:#FC2338; font-size:15px;" id="errPhone"></div>
                                </div>
					     <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">
                                    <b> Qualification:<span style="color:red;font-size: 25px;"></span></b>
                                </div>
                                <div class="col-md-5 form-group">
                                    <input type="text" name="qualification" id="qualification" class="form-control" style="width:100%; padding:5px;" placeholder="qualification" value="<?php echo $result['Qualification'];?>"/>
									<div class="col-md-13" style="color:#FC2338; font-size:15px;" id="errPhone"></div>
                                </div>
					   
					   
                
                                <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">
                                    <b>Occupation:<span style="color:red;font-size: 25px;"></span></b>
                                </div>
                                <div class="col-md-5 form-group">
                                    <input type="text" name="Occupation" id="Occupation" class="form-control" style="width:100%; padding:5px;" placeholder="Occupation" value="<?php echo $result['Occupation'];?>"/>
									<div class="col-md-13" style="color:#FC2338; font-size:15px;" id="errOccupation"></div>
                                </div>


                                <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">
                                    <b> Family Income:<span style="color:red;font-size: 25px;"></span></b>
                                </div>
                                <div class="col-md-5 form-group">
                                    <input type="text" name="FamilyIncome" id="FamilyIncome" class="form-control" style="width:100%; padding:5px;" placeholder="FamilyIncome" value="<?php echo $result['FamilyIncome'];?>"/>
									<div class="col-md-13" style="color:#FC2338; font-size:15px;" id="errFamilyIncome"></div>
                                </div>
								
								<div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">
                                    <b>Mother Name:<span style="color:red;font-size: 25px;"></span></b>
                                </div>
                                <div class="col-md-5 form-group">
                                    <input type="text" name="mname" id="mname" class="form-control" style="width:100%; padding:5px;" placeholder="Mother Name" value="<?php echo $result['Mother_name'];?>"/>
									<div class="col-md-13" style="color:#FC2338; font-size:15px;" id="errOccupation"></div>
                                </div>
								<div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">
                                    <b>Parent Profile Image:<span style="color:red;font-size: 25px;"></span></b>
                                </div>
                       
                           <div class="col-md-5 form-group">
                                
								
                                    <input type="file" class='form-control datepicker' name="photo" id="profileimg">
                                    
                                    </div>
                                     
                                       </div>

                            <div class="row ">
                                <div class="col-md-8 form-group col-md-offset-3" id="error"
                                     style="color:red;"><?php echo $report; ?></div>
                            </div>
                            <div class="row" align="right">

                                <div class='col-md-2 col-md-offset-4'>
                            <input class='btn-lg btn-primary' type='submit' value="Submit" name="submit" onClick="return valid()" style="padding:5px;"/>
                        </div>

                            
                                <div class="col-md-3" >

                                    <a href="parents_list.php" style="text-decoration:none;"> <input type="button" class="btn btn-danger" name="Back" value="Back" style="width:80px;font-weight:bold;font-size:14px;"/></a>

                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
	  <script src='js/bootstrap-datepicker.min.js' type='text/javascript'></script>
	   <link href='css/datepicker.min.css' rel='stylesheet' type='text/css'>
	   <script src="js/city_state.js" type="text/javascript"></script>
	<link href='css/datepicker.min.css' rel='stylesheet' type='text/css'>
			

    </html>
<script type="text/javascript" language="javascript">
    $(document).ready(function () {
        var t_country = "<?php echo $value1['country'];?>";
        var state = "<?php echo $value1['state'];?>";
        $('#country').val(t_country).trigger('change');
        $('#state').val(state).trigger('change');
    });
</script>

</body>



				  