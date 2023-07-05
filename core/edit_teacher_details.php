<?php
//error_reporting(0);
include_once("function.php");
$report = "";
if (isset($_GET['name'])) {
    include_once("school_staff_header.php");
    $table = "tbl_school_adminstaff";
    $id = $_SESSION['staff_id'];
} else {
    include_once("scadmin_header.php");
    $table = "tbl_school_admin";
}
$fields = array("id" => $id);
$smartcookie = new smartcookie();
$results = $smartcookie->retrive_individual($table, $fields);
$arrs = mysql_fetch_array($results);
//$school_id = $arrs['school_id'];
$school_id =$_SESSION['school_id'];
$t_id = $_GET['t_id'];
if ($t_id != '') {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if ($t_id != '') {
           
			$fname = $_POST['fname'];
			 $mname = $_POST['mname'];
			  $lname = $_POST['lname'];
			  
			   $complete_name = $_POST['fname'] . " " . $_POST['mname'] . " " .$_POST['lname'];
            $edu = $_POST['id_education'];
			 $t_emp_type_pid = $_POST['t_emp_type_pid'];
            $experience = $_POST['experience'];
			$experience_month = $_POST['experience_month'];
			$exp_mon=$experience . "." . $experience_month;
            $department = $_POST['dept'];
			$designation = $_POST['designation'];
			$class = $_POST['class'];
         $id_checkin = $_POST['id_checkin'];
            $gen = $_POST['gender'];
            $e_id = $_POST['id_email'];
            $internal_emailid = $_POST['internal_email'];
            $mob = $_POST['id_phone'];
			 $CountryCode = $_POST['country_code'];
            $land = $_POST['landline'];
            $address = $_POST['address'];
			$t_address = $_POST['t_address'];
            $country = $_POST['country'];
            $t_state = $_POST['t_state'];
            $cty = $_POST['city'];
            //$CountryCode = $_POST['CountryCode'];
		$id_date = CURRENT_TIMESTAMP; 
                        


    list($month,$day,$year) = explode("/",$id_checkin);
	
	
	$year_diff  = date("Y") - $year; 
    $month_diff = date("m") - $month; 
    $day_diff   = date("d") - $day; 
		if ($day_diff < 0 || $month_diff < 0) $year_diff--;
	
	$age= $year_diff;
	
	$dateformat=$year. "-" .$month. "-" .$day;
			
            $sql_update11 = "UPDATE `tbl_teacher` SET t_complete_name=' $complete_name',t_name='$fname',t_middlename='$mname',t_lastname='$lname',CountryCode='$CountryCode',t_emp_type_pid='$t_emp_type_pid',t_designation='$designation',t_qualification='$edu',t_dob='$dateformat',t_email='$e_id',
			t_exprience='$exp_mon',t_dept='$department',t_class='$class',t_age='$age',t_gender='$gen',t_internal_email='$internal_emailid',t_phone='$mob',t_landline='$land',
			t_address='$address',t_temp_address='$t_address',t_country='$country',state='$t_state',t_city='$cty',CountryCode='$CountryCode'
			WHERE t_id='$t_id' AND school_id='$school_id'";
            $retval11 = mysql_query($sql_update11) or die('Could not update data: ' . mysql_error());
            $report = 'Successfully updated';
        } else {
            echo "<script type=text/javascript>alert('Sry... No Teacher ID.Unable to update this record '); window.location='teacherlist.php'</script>";
        }
    }
    $query = mysql_query("select * from tbl_teacher where school_id='$school_id' AND t_id='$t_id'");
    // $data = mysql_fetch_assoc($query);
    if (mysql_num_rows($query) >= 1) {
        $value1 = mysql_fetch_assoc($query);
		 $fname1 = $value1['t_name'];
		 $mname1 = $value1['t_middlename'];
		  $l2name1 = $value1['t_lastname'];
		//t_complete_name added by Rutuja Jori on 01/11/2019 to solve the issue of first name, middle name & last name not getting displayed on edit page
		
		 $complete_t_name=$value1['t_complete_name'];
		
		$complete_name=explode(" ",$complete_t_name);
		 $count=count($complete_name);
		
		if ($fname1==''){
			if($count=='3' || $count=='2' || $count=='1')
			{
			$fname1=ucwords($complete_name['0']);
			}
		}
		if ($l2name1==''){
			if($count=='3')
			{
			$l2name1=ucwords($complete_name['2']);
			}
			if($count=='2')
			{
			$l2name1=ucwords($complete_name['1']);
			}
		}
		
      if($mname1==''){
			if($count=='3')
			{
			$mname1=ucwords($complete_name['1']);
			}
		if($count=='2')
			{
			$mname1="";
			}
	  }
        $dept = $value1['t_dept'];
		 $class1 = $value1['t_class'];
		$designation1 = $value1['t_designation'];
        $exp = $value1['t_exprience'];
		$exp1=explode(".", $exp);
		$year=$exp1['0'];
		$month=$exp1['1'];
        $gender = $value1['t_gender'];
        $qul = $value1['t_qualification'];
        $add = $value1['t_address'];
		$tadd = $value1['t_temp_address'];
        $date_birth = $value1['t_dob'];
	$d1=explode("-", $date_birth);
		$dob=$d1['1']. "/" .$d1['2']. "/" .$d1['0'];
        $email = $value1['t_email'];
        $phone = $value1['t_phone'];
		 $country_code = $value1['CountryCode'];
        $landline = $value1['t_landline'];
        $c_name = $value1['t_complete_name'];
        $internal_email = $value1['t_internal_email'];
        $city = $value1['t_city'];
         $t_country = $value1['t_country'];
		 $state = $value1['state'];
        $t_qualification = $value1['t_qualification'];
		$t_emp_type = $value1['t_emp_type_pid'];
		
		
        $country_code = $value1['CountryCode'];
		$t_id = $value1['t_id'];
    }
} else {
    echo "<script type=text/javascript>alert('Sry... No Teacher ID.Unable to update this record '); //window.location='teacherlist.php'</script>";
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
	//Below code for duplicte Email-ID added by Rutuja Jori on 01/11/2019
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
     
 });//Validations added by Rutuja Jori on 01/11/2019
        function valid() {
            var first_name = document.getElementById("fname").value;
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
           
			
			var last_name = document.getElementById("lname").value;
           /* if (last_name == null || last_name == "") {
                document.getElementById('errorname').innerHTML = 'Please Enter Name';
                return false;
            }*/
            regx1 = /^[A-z ]+$/;
            //validation for name
            /*if (!regx1.test(last_name)) {
                document.getElementById('errorname').innerHTML = 'Please Enter valid Name';
                return false;
            }
            else {
                document.getElementById('errorname').innerHTML = '';
            }*/
			
			
            var id_education = document.getElementById("id_education").value;
            /*if (id_education == '') {
                document.getElementById('errorexperience').innerHTML = 'Please Enter education';
                return false;
            }
            else {
                document.getElementById('errorexperience').innerHTML = '';
            }*/
            var experience = document.getElementById("experience").value;
           /* if (experience == null || experience == "") {

                document.getElementById('errorexperience').innerHTML = 'Please Enter Experience';

                return false;
            }*/
             if (experience < 0 || experience % 1 != 0) {
               alert("Please Enter valid Experience");

                return false;

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

            var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

            var email = document.getElementById("id_email").value;
			if(email=='')
			{
				alert("Please Enter Email ID");
			}
			

          else if (!email.match(mailformat)) {
               alert("Please Enter valid email ID");

                return false;
            }
            else {
                document.getElementById('erroremail').innerHTML = '';
            }
            var internal_email = document.getElementById("internal_email").value;

			
			
			if(internal_email=='')
			{
			}
           else if (!internal_email.match(mailformat)) {
                document.getElementById('errorinternalemail').innerHTML = 'Please Enter valid internal email ID';

                return false;
            }
            else {
                document.getElementById('errorinternalemail').innerHTML = '';
            }

            var phone1 = document.getElementById("phone").value;
			var phone=phone1.trim();
				if(phone=='')
			{
			}
          else if(phone!=''){
				var pattern = /^[6789]\d{9}$/;
				
				if (!pattern.test(phone)) {
				   alert("Please enter 10 digits number!");
					return false;
				}
				
		}
             var country = document.getElementById("country");

                    if (country.value == "-1" || country.value == '') {

                        alert("Please select country");
                        return false;
                    }
                    

                    var state = document.getElementById("t_state");
                    if (state.value == "" || state.value == "-1" ) {

                         alert("Please select state");
                        return false;
                    }
                    
					
					var id_city = document.getElementById("id_city").value;
				 
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
<div class='container'>
    <div class='panel panel-primary dialog-panel' style="background-color:#FFFFFF;background-image=""">
    <div style="color:red;font-size:15px;font-weight:bold;margin-top:10px;"> <?php if (isset($_GET['report'])) {
            echo $_GET['report'];
        }; ?></div>
    <div class='panel-heading'>
        <a href="teacherlist.php"> <input type="button" class="btn btn-primary" name="submit" value="Back" style="width:150;font-weight:bold;font-size:14px;"/></a>
        <h3 align="center">Update <?php echo $dynamic_teacher;?> Information</h3>
    </div>

    <div class='panel-body'>
        <form class='form-horizontal' role='form' method="POST">
		
		<div class='form-group'>
                <label class='control-label col-md-2 col-md-offset-2' for='id_accomodation' style="text-align:left;">Employee ID<b style="color:red";> *</b></span></label>
                <div class='col-md-3'>
                    <input class='form-control ' id='id' name='id' type='text' value="<?php echo $t_id; ?>" readonly="readonly">
                </div>
                
            </div>
			
		
			
			
			
			<div class='form-group'>
                <label class='control-label col-md-2 col-md-offset-2' for='id_accomodation' style="text-align:left;"><?php echo $dynamic_teacher;?> Name<b style="color:red";> *</b></span></label>
                <div class='col-md-3'>
                    <input class='form-control ' id='fname' name='fname' type='text' value=<?php echo $fname1; ?>>
                </div>
                <div class='col-md-2 indent-small' id="errorname" style="color:#FF0000"></div>
            </div>
			
            
		<div class='form-group'>
                <label class='control-label col-md-2 col-md-offset-2' for='id_accomodation' style="text-align:left;">Middle Name</label>
                <div class='col-md-3'>
                    <input class='form-control ' id='mname' name='mname' type='text' value=<?php echo $mname1; ?>>
                </div>
                <div class='col-md-2 indent-small' id="errorname" style="color:#FF0000"></div>
            </div>
		
		
        <div class='form-group'>
                <label class='control-label col-md-2 col-md-offset-2' for='id_accomodation' style="text-align:left;">Last Name</span></label>
                <div class='col-md-3'>
                    <input class='form-control ' id='lname' name='lname' type='text' value=<?php echo $l2name1; ?>>
                </div>
                <div class='col-md-2 indent-small' id="errorname" style="color:#FF0000"></div>
            </div>
		
		
		
		

            <div class='form-group'>
                <label class='control-label col-md-2 col-md-offset-2' for='id_service' style="text-align:left;">Education</span></label>
                <div class='col-md-3'>
                    <select class='multiselect  form-control' id='id_education' name="id_education">
                        <?php
                        echo $t_qualification;
						if ($t_qualification== '-1') {
                            ?>
                            <option value='<?php echo $t_qualification ?>'
                                    selected><?php echo ""; ?></option>
                            <?php
                        }
                       else if ($t_qualification != '') {
                            ?>
                            <option value='<?php echo $t_qualification ?>'
                                    selected><?php echo $t_qualification; ?></option>
                            <?php
                        } else { ?>
                            <option value=''>Select</option>
                        <?php } ?>
                        <?php if ($t_qualification != 'BE') { ?>
                            <option value='BE'>BE</option>
                        <?php }
                        if ($t_qualification != 'ME') {
                            ?>
                            <option value='ME'>ME</option>
                        <?php }
                        if ($t_qualification != 'BA') {

                            ?>
                            <option value='BA'>BA</option>
                        <?php }
                        if ($t_qualification != 'BCom') {

                            ?>
                            <option value='BCom'>BCom</option>
                        <?php }
                        if ($t_qualification != 'BSc') {

                            ?>
                            <option value='BSc'>BSc</option>
                        <?php }
                        if ($t_qualification != 'MA') {

                            ?>
                            <option value='MA'>MA</option>
                        <?php }
                        if ($t_qualification != 'MCom') {

                            ?>
                            <option value='MCom'>MCom</option>
                        <?php }
                        if ($t_qualification != 'MSc') {

                            ?>
                            <option value='MSc'>MSc</option>
                        <?php }
                        if ($t_qualification != 'B.ED') {

                            ?>
                            <option value='B.ED'>B.ED</option>
                        <?php }
                        if ($t_qualification != 'D.ED') {

                            ?>
                            <option value='D.ED'>D.ED</option>
                        <?php }
                        if ($t_qualification != 'Diploma') {

                            ?>
                            <option value='Diploma'>Diploma</option>
                        <?php }
						
						if ($t_qualification != 'Ph.D') {

                            ?>
                            <option value='Ph.D'>Ph.D</option>
                        <?php }
                        if ($t_qualification != 'ME') {

                            ?>
                            <option value='Other'>Other</option>
                        <?php } ?>
                    </select>
                </div>
				 </div>
				 
				 
				 
				 
				  <div class='form-group'>
                <label class='control-label col-md-2 col-md-offset-2' for='id_accomodation' style="text-align:left;">Employee Type<b style="color:red";> *</b></span></label>
                <div class='col-md-3'>
                    <select name='t_emp_type_pid' id='t_emp_type_pid' class='form-control'>
                         <?php
                       // echo $t_emp_type;
                         //echo $t_emp_type;
                        if ($t_emp_type != '') {

							if($t_emp_type=='133' || $t_emp_type=='134')
							{
								$t_emp=$dynamic_teacher;
							}
							
							
						 if($t_emp_type=='135')
							{
								$t_emp=$dynamic_hod;
							}
							
							
							 if($t_emp_type=='137')
							{
								$t_emp=$dynamic_principal;
							
							}
							
							 if($t_emp_type=='140')
							{
								$t_emp=$nonTeacherStaff;
							
							}
							
							
                            ?>
                            <option value='<?php echo $t_emp_type ?>'
                                    selected><?php echo $t_emp
									; ?></option>
                            <?php
                        } else { ?>
                            <option value=''>Select</option>
                        <?php } ?>
                        <?php if ($t_emp != $dynamic_teacher ) { ?>
                            <option value='133'><?php echo $dynamic_teacher; ?></option>
                        <?php }
					
						
                         if ($t_emp != $dynamic_hod)  {
                            ?>
                            <option value='135'><?php echo $dynamic_hod; ?></option>
                        <?php }
						
                         if ($t_emp != $dynamic_principal)  {
                            ?>
                            <option value='137'><?php echo $dynamic_principal; ?></option>
                        <?php }?>
						
						
                         <?php 
						 //For Corporate
						 if ($school_type == 'organization'  && $user=='HR Admin'){
														
						 if ($t_emp != 'Member Secretary')  {
                            ?>
                            <option value='139'>Member Secretary</option>
                        <?php }
						
						 if ($t_emp != 'Vice Chairman')  {
                            ?>
                            <option value='141'>Vice Chairman</option>
                        <?php }
						
						if ($t_emp != 'Chairman')  {
                            ?>
                            <option value='143'>Chairman</option>
                        <?php }?>
						
						  <?php }?>
						 
					<?php 	 if ($t_emp != $nonTeacherStaff)  {
                            ?>
                            <option value='140'><?php echo $nonTeacherStaff; ?></option>
                        <?php }?>
                    </select>
                </div>
                <div class='col-md-3 indent-small' id="errordept" style="color:#FF0000"></div>
            </div>
			
			
			 <div class='form-group'>
                <label class='control-label col-md-2 col-md-offset-2' for='id_accomodation' style="text-align:left;">Department<b style="color:red";> *</b></label>
                <div class='col-md-3'>
                    <select name='dept' id='dept' class='form-control'>
                        <?php $arr = mysql_query("select Dept_Name from tbl_department_master where school_id='$school_id' ORDER BY Dept_Name"); ?>
                        <option><?php echo $dept; ?></option>
                        <?php while ($row = mysql_fetch_array($arr)) { ?>
                        <option><?php echo $row['Dept_Name'] ?></option><?php } ?>
                    </select>
                </div>
                <div class='col-md-3 indent-small' id="errordept" style="color:#FF0000"></div>
            </div>
			
			
			<div class='form-group'>
                <label class='control-label col-md-2 col-md-offset-2' for='id_accomodation' style="text-align:left;"><?php echo $dynamic_class;?></label>
                <div class='col-md-3'>
                    <select name='class' id='class' class='form-control'>
					 <?php
                        echo $class1;
                        if ($class1 != '') {
                            ?>
                            <option value='<?php echo $class1 ?>'
                                    selected><?php echo $class1; ?></option>
                            <?php
                        } else { ?>
                            <option value=''>Select</option>
                        <?php } ?>
                        <?php $arr = mysql_query("select distinct(class) from Class where school_id='$school_id'"); 
						 while ($row = mysql_fetch_array($arr)) { 
						 $t_class=$row['class'];
						?>
                        <?php if ($class1 != $t_class) { ?>
                            <option value="<?php echo $t_class;?>"><?php echo $t_class;?></option>
						 <?php }
                            
                         }?>
                
                    </select>
                </div>
               
            </div>
			<div class='form-group'>
                <label class='control-label col-md-2 col-md-offset-2' for='id_accomodation' style="text-align:left;">Designation<b style="color:red";> </b></span></label>
                <div class='col-md-3'>
                    <select name='designation' id='designation' class='form-control'>
						<?php
                        echo $designation1;
                        if ($designation1 != '') {
                            ?>
                            <option value='<?php echo $designation1 ?>'
                                    selected><?php echo $designation1; ?></option>
                            <?php
                        } else { ?>
                            <option value=''>Select</option>
                        <?php } ?>
                        <?php $arr = mysql_query("select * from tbl_teacher_designation where school_id='$school_id'"); 
						 while ($row = mysql_fetch_array($arr)) { 
						 $t_desig=$row['designation'];
						?>
                        <?php if ($designation1 != $t_desig) { ?>
                            <option value="<?php echo $t_desig;?>"><?php echo $t_desig;?></option>
						 <?php }
                            
                         }?>


					  
						
						
						
						
                    </select>
                </div>
                <div class='col-md-3 indent-small' id="errordept" style="color:#FF0000"></div>
            </div>
				 
				 
				  <div class='form-group'>
                <label class='control-label col-md-2 col-md-offset-2' for='id_accomodation' style="text-align:left;">Experience</span></label>
                <div class='col-md-3'>
                    <input class='form-control ' id='experience' name='experience' type='text' value=<?php echo $year; ?>>
                </div>
				  <div class='col-md-3'>
				<select class='multiselect  form-control' id='experience_month' name="experience_month">
                        <?php
                        echo $month;
                        if ($month != '') {
                            ?>
                            <option value='<?php echo $month ?>'
                                    selected><?php echo $month; ?></option>
                            <?php
                        } else { ?>
                            <option value='0'>Select</option>
                        <?php } ?>
                        <?php if ($month != '0') { ?>
                            <option value='0'>0</option>
                        <?php }
                        if ($month != '1') {
                            ?>
                            <option value='1'>1</option>
                        <?php }
                        if ($month != '2') {

                            ?>
                            <option value='2'>2</option>
                        <?php }
                        if ($month != '3') {

                            ?>
                            <option value='3'>3</option>
                        <?php }
                        if ($month != '4') {

                            ?>
                            <option value='4'>4</option>
                        <?php }
                        if ($month != '4') {

                            ?>
                            <option value='5'>5</option>
                        <?php }
						if ($month != '5') {

                            ?>
                            <option value='6'>6</option>
                        <?php }
						if ($month != '6') {

                            ?>
                            <option value='7'>7</option>
                        <?php }
						if ($month != '8') {

                            ?>
                            <option value='8'>8</option>
                        <?php }
						if ($month != '9') {

                            ?>
                            <option value='9'>9</option>
                        <?php }
						if ($month != '10') {

                            ?>
                            <option value='10'>10</option>
                        <?php }
						if ($month != '11') {

                            ?>
                            <option value='11'>11</option>
                        <?php }

                            ?>
                          
                    </select>
				  </div>
				
                <div class='col-md-2 indent-small' id="errorexperience" style="color:#FF0000"></div>
            </div>

           

 <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2'  style="text-align:left;">Date Of Birth<span class="error"></label>
            <div class='col-md-3' style="text-align:left;">

			<!-- Changes done by Pranali on 28-06-2018 for bug SMC-3200 -->

           <!--  <input type="text"  id='id_checkin' name="id_checkin" value=<?php //echo $dob; ?> class='form-control datepicker' /> -->
			<input type="text"  id='id_checkin' name="id_checkin" value=<?php echo $dob; ?> autocomplete="off" class='form-control'>
			<!-- Changes end-->

             </div>
			 <div class='col-md-3 error1' id="errordob" style="color:#FF0000"></div>
         </div>
		 

            <div class='form-group'>
                <label class='control-label col-md-2 col-md-offset-2' for='id_pets' style="text-align:left;">Gender<b style="color:red";> *</b></span></label>
                <div class='col-md-2' style="font-weight: 600;

color: #777;">
                    <input type="radio" name="gender" id="gender1" <?php if ($gender == "Male") echo 'checked'; ?> value="Male">Male
                </div>
                <div class='col-md-3' style="font-weight: 600;

color: #777;">
                    <input type="radio" name="gender" id="gender2" <?php if ($gender == "Female") echo 'checked'; ?> value="Female">Female
                </div>
                <div class='col-md-2 indent-small' id="errorgender" style="color:#FF0000">
                </div>
            </div>
            <div class='form-group'>
                <label class='control-label col-md-2 col-md-offset-2' for='id_email' style="text-align:left;">Contact<b style="color:red";> *</b></span></label>
                <div class='col-md-3'>Email<input class='form-control' id='id_email' name="id_email" type='text' value=<?php echo $email; ?>></div>
                <div class='col-md-3 indent-small' id="erroremail" style="color:#FF0000">
                </div>
            </div>
            <div class='form-group'>
                <label class='control-label col-md-2 col-md-offset-2' for='id_email' style="text-align:left;"></label>
                <div class='col-md-3'>Internal Email<input class='form-control' id='internal_email' name="internal_email" type='text' value=<?php echo $internal_email; ?>>
                </div>
                <div class='col-md-3 indent-small' id="errorinternalemail" style="color:#FF0000">
                </div>
            </div>
			
  <div class='form-group'>
                <label class='control-label col-md-2 col-md-offset-2' for='id_accomodation' style="text-align:left;">Country Code<b style="color:red";> *</b></span></label>
                <div class='col-md-3'>
                    <select name='country_code' id='country_code' class='form-control'>
                        <?php $arr = mysql_query("select * from tbl_country where calling_code!=''"); ?>
                        <option><?php echo $country_code; ?></option>
                        <?php while ($row = mysql_fetch_array($arr)) { ?>
                        <option><?php echo $row['calling_code'] ?></option><?php } ?>
                    </select>
                </div>
                <div class='col-md-3 indent-small' id="errorcountry_code" style="color:#FF0000"></div>
            </div>
			
            <div class='form-group'>
                <label class='control-label col-md-2 col-md-offset-2' for='id_email' style="text-align:left;"></label>
                <div class='col-md-3'>Phone<input class='form-control' id='phone' name="id_phone" type='text' value="<?php echo $phone; ?> "></div>
                <div class='col-md-3 indent-small' id="errorphone" style="color:#FF0000">
                </div>
            </div>
			
			<div class='form-group'>
                <label class='control-label col-md-2 col-md-offset-2' for='id_email' style="text-align:left;"></label>
                <div class='col-md-3'>Alternate Contact No<input class='form-control' id='alt_phone' name="alt_phone" type='text' value="<?php echo $alternate_phone; ?> "></div>
                <div class='col-md-3 indent-small' id="errorphone" style="color:#FF0000">
                </div>
            </div>

          

            <div class='form-group'>
                <label class='control-label col-md-2 col-md-offset-2' for='id_comments' style="text-align:left;">Address</span></label>
                <div class='col-md-3'>
                    <textarea class='form-control' id='id_address' name="address" rows='3'><?php echo $add; ?></textarea>
                </div>
                <div class='col-md-2 indent-small' id="erroraddress" style="color:#FF0000"></div>
            </div>
			
			<div class='form-group'>
                <label class='control-label col-md-2 col-md-offset-2' for='id_comments' style="text-align:left;">Temporary Address</span></label>
                <div class='col-md-3'>
                    <textarea class='form-control' id='t_address' name="t_address" rows='3'><?php echo $tadd; ?></textarea>
                </div>
                <div class='col-md-2 indent-small' id="errortaddress" style="color:#FF0000"></div>
            </div>

            <div class='form-group'>
                <label class='control-label col-md-2 col-md-offset-2' style="text-align:left;">Country<b style="color:red";> *</b></span></label>
                <div class='col-md-3'>
                    <select id="country" name="country" class='form-control'></select>
                </div>
                <div class='col-md-3 indent-small' id="errorcountry" style="color:#FF0000"></div>
            </div>
            <div class='form-group'>
                <label class='control-label col-md-2 col-md-offset-2' style="text-align:left;">State<b style="color:red";> *</b></span></label>
                <div class='col-md-3'>
                    <select name="t_state" id="t_state" class='form-control'>
					
					</select>
                </div>
                <div class='col-md-3 indent-small' id="errorstate" style="color:#FF0000"></div>
            </div>
		
            <script language="javascript">
                populateCountries("country", "t_state");
                populateCountries("country2");
            </script>
            <div class='form-group'>
                <label class='control-label col-md-2 col-md-offset-2' for='id_accomodation' style="text-align:left;">City<b style="color:red";> *</b></span></label>
                <div class='col-md-3'>
                    <input type="text" class='form-control' id='id_city' name="city" value=<?php echo $city; ?>>
                </div>
                <div class='col-md-3 indent-small' id="errorcity" style="color:#FF0000"></div>
            </div>

            <div class='form-group row'>
                <div class='col-md-2 col-md-offset-4'>
                    <input class='btn-lg btn-primary' type='submit' value="Update" name="submit" onClick="return valid()" style="padding:5px;"/>
                </div>

                <div class='col-md-1'>
                    <a href="teacherlist.php"><input type="button" class='btn-lg btn-danger' value="Cancel" name="cancel" style="padding:5px;"/></a>
                </div>
        </form>
    </div>
    <div class='row' align="center" style="color:#096;"><?php echo $report; ?></div>
</div>
</div>

<script type="text/javascript" language="javascript">
    $(document).ready(function () {
        var t_country = "<?php echo $value1['t_country'];?>";
        var state = "<?php echo $value1['state'];?>";
        $('#country').val(t_country).trigger('change');
        $('#t_state').val(state).trigger('change');
    });
</script>

</body>



				  