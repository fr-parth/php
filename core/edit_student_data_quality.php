<?php
/*error_reporting(0); */
$report = "";
include("scadmin_header.php");
/*$id=$_SESSION['id'];*/
$fields = array("id" => $id); 
$table="tbl_school_admin";
$smartcookie = new smartcookie();
$results = $smartcookie->retrive_individual($table, $fields);
$arrs = mysql_fetch_array($results);
$school_id = $arrs['school_id'];
$std_PRN = $_GET['std_prn'];
$FLAG = $_GET['flag'];
$std_complete_name = "";
if ($std_PRN != '') {
    if (isset($_POST['update'])) {
        if ($std_PRN != '') {
            $std_prn = $_POST['std_prn'];
            //$l_name=$_POST['id_last_name'];
            $c_name = $_POST['complete_name'];
            $c_name1 = explode(" ", $c_name);
            $fname = $c_name1[0];
            $mname = $c_name1[1];
            $lname = $c_name1[2];
            $full_name = $fname . " " . $mname . " " . $lname;
            $com_father_name = $_POST['c_father_name'];
            $std_class = $_POST['class'];
            $std_div = $_POST['div'];
            $std_gen = $_POST['gender'];
            $std_email_id = $_POST['std_email'];
            $std_internal_emailid = $_POST['internal_email'];
            $std_mob = $_POST['std_phone'];
            $std_dob = $_POST['std_dob'];
            $std_t_address = $_POST['temp_address'];
            $std_p_address = $_POST['permanant_address'];
            $std_country = $_POST['country'];
            $std_state = $_POST['state'];
            $std_cty = $_POST['city'];
            $std_branch = $_POST['std_branch'];
            $std_permanant_district = $_POST['Permanent_district'];
            $std_permanant_pincode = $_POST['Permanent_pincode'];
            $Academic_year = $_POST['Academic_year'];
            $std_dept = $_POST['std_dept'];

            $sql_update11 = "UPDATE `tbl_student` SET std_PRN='$std_prn',std_name='$fname',std_Father_name='$mname',std_lastname='$lname',std_complete_name='$full_name',std_Father_name='$com_father_name',
		std_class='$std_class',std_div='$std_div',std_gender='$std_gen',std_email='$std_email_id',Email_Internal='$std_internal_emailid',std_phone='$std_mob',std_dob='$std_dob',
		Temp_address='$std_t_address',permanent_address='$std_p_address',std_country='$std_country',std_state='$std_state',std_city='$std_cty',std_branch='$std_branch',Permanent_district='$std_permanant_district',
        Permanent_pincode='$std_permanant_pincode', Academic_year='$Academic_year', std_dept='$std_dept'
		WHERE std_PRN='$std_PRN' AND school_id='$school_id'";
            $retval11 = mysql_query($sql_update11) or die('Could not update data: ' . mysql_error());
        } else {
			
			//window.location='studentlist.php' added by Pranali for bug SMC-3308
            echo "<script type=text/javascript>alert('Sry... No PRN Number.Unable to update this record '); history.go(-1) </script>";
        }
        if ($retval11 > 0) {
            echo "<script type=text/javascript>alert('Record Updated Successfully '); history.go(-2) </script>";
        } else {
            echo "<script type=text/javascript>alert('Ooops..you didn't make any kind of change'); history.go(-1)</script>";
        }
		//changes end
    }


    $query = mysql_query("select * from tbl_student where std_PRN='$std_PRN' and school_id='$school_id'");
    if (mysql_num_rows($query) > 0) {
        while ($value1 = mysql_fetch_assoc($query)) {
			$std_complete_name=$value1['std_complete_name'];
            $fname = $value1['std_name'];
            $lname = $value1['std_lastname'];
            $mname = $value1['std_Father_name'];
			if($std_complete_name == '')
			{
				
             $std_complete_name = $fname . " " . $mname . " " . $lname;
			}
            /* $std_cname=$value1['std_complete_name'];
            $c_name=explode(" ",$std_cname);
            $fname=$c_name[0];
            $mname=$c_name[1];
            $lname=$c_name[2];
            $l2name=$c_name[3];
            $std_complete_name=$fname." ".$mname." ".$lname." ".$l2name; */
            $std_father_name = $value1['std_complete_father_name'];
            $std_dob = $value1['std_dob'];
            $std_branch = $value1['std_branch'];
            $std_class = $value1['std_class'];
            $std_div = $value1['std_div'];
            $std_year = $value1['std_year'];
            $std_sem = $value1['std_semester'];
            $std_add = $value1['std_address'];
            $std_city = $value1['std_city'];
            $std_country = $value1['std_country'];
            $std_state = $value1['std_state'];
            $std_gender = $value1['std_gender'];
            $std_email = $value1['std_email'];
            $std_phone = $value1['std_phone'];
            $std_dept = $value1['std_dept'];
            $Academic_year = $value1['Academic_year'];
            $std_internal_email = $value1['Email_Internal'];
            $std_temp_address = $value1['Temp_address'];
            $std_permanant_add = $value1['permanent_address'];
            $std_permanant_village = $value1['Permanent_village'];
            $std_permanant_taluka = $value1['Permanent_taluka'];
            $std_permanant_district = $value1['Permanent_district'];
            $std_permanant_pincode = $value1['Permanent_pincode']; 
        }
    }
} else {
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
        function isNumberKey(evt) {
            var charCode = (evt.which) ? evt.which : event.keyCode
            if (charCode > 31 && (charCode < 48 || charCode > 57))
                return false;
            return true;
        }
		
  function goBack() 
  {
    window.history.back();
   }
    </script>
    <script>
        function showOrhide() {

            if (document.getElementById("firstBtn")) {

                document.getElementById('text_country1').style.display = "block";
                document.getElementById('text_country').style.display = "none";
                document.getElementById('text_state1').style.display = "block";
                document.getElementById('text_state').style.display = "none";
                return false;
            }
        }
    </script>
    <script type="text/javascript">

        $(document).ready(function () {

            $('#state').change(function () {

                var state = document.getElementById("state").value;

                if (state == null || state == "") {

                    document.getElementById('errorstate').innerHTML = 'Please enter State';

                    return false;
                }

                else {
                    document.getElementById('errorstate').innerHTML = '';
                }
            });
        });
    </script>
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

        .internal_email {
            padding-left: 200px;
        }

        .glowing-border {
            border: 2px solid #0080ff;
            border-radius: 7px;
            box-shadow: 0 0 10px #0080ff;
            }
    </style>
    <script src="js/city_state.js" type="text/javascript"></script>
	<script src='js/bootstrap-datepicker.min.js' type='text/javascript'></script>
           
            <link href='css/datepicker.min.css' rel='stylesheet' type='text/css'>
			<script src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>
            <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
			 <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
			
			<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
			<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
    <script>
        $(document).ready(function () {
            $('.multiselect').multiselect();
            $('.datepicker').datepicker();
			
        });
 $(function () {
                $("#std_dob").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    dateFormat: 'yy-mm-dd',
                });
            });

		
		
		
		
		function valid()
	{
		
		var complete_name=document.getElementById("complete_name").value;
		regx1=/^[A-z ]+$/;
		if(complete_name=="")
			{
			   
				document.getElementById('errorname').innerHTML='Please enter full name';
				
				return false;
			}
		else if(!regx1.test(complete_name))
				{
				document.getElementById('errorname').innerHTML='Please Enter valid Name';
					return false;
				}
				else
				{
				 document.getElementById('errorname').innerHTML='';
				
				}
				var c_father_name=document.getElementById("c_father_name").value;
		regx1=/^[A-z ]+$/;
		//if(c_father_name=="")
			//{
			   
				//document.getElementById('errorfatname').innerHTML='Please enter full name';
				
				//return false;
			//}
		else if(!regx1.test(c_father_name))
				{
				document.getElementById('errorfatname').innerHTML='Please Enter valid Name';
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
					var std_phone = document.getElementById("id_phone").value;
					if (std_phone == null || std_phone == "") {
                document.getElementById('errorphone').innerHTML = 'Please Enter phone Number';
                return false;
            }
            regx1 = /^[6789]\d{9}$/;
            //validation for name
            if (!regx1.test(std_phone)) {
                document.getElementById('errorphone').innerHTML = 'Please Enter valid phone number';
                return false;
            }
            else {
                document.getElementById('errorphone').innerHTML = '';
            }
			var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

            var std_email = document.getElementById("id_email").value;
				if (std_email == null || std_email == "") {
                document.getElementById('erroremail').innerHTML = 'Please Enter email ID';
                return false;
			
            }
            if (!std_email.match(mailformat)) {
                document.getElementById('erroremail').innerHTML = 'Please Enter valid email ID';

                return false;
            }
            else {
                document.getElementById('erroremail').innerHTML = '';
            }
		/*	var gender1=document.getElementById("gender1").checked;
		
			var gender2=document.getElementById("gender2").checked;
			
		if(gender1==false && gender2==false)
			{
				document.getElementById('errorgender').innerHTML='Please Select gender';
				return false;
			}else{
				document.getElementById('errorgender').innerHTML='';
			}
			
			var permanant_address=document.getElementById("id_address").value;
		regx2=/^[A-z ]+$/;
		if(permanant_address=="")
			{
			   
				document.getElementById('erroraddress').innerHTML='Please enter address';
				
				return false;
			}
	
			else
				{
				 document.getElementById('erroraddress').innerHTML='';
				}
			*/	
				
				var state=document.getElementById("state").value;
				
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
			
			//var city=document.getElementById("id_accomodation").value;
			var city=document.getElementById("city").value;
				regx2=/^[A-z ]+$/;
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
    <div style="color:red;font-size:15px;font-weight:bold;margin-top:5px;"
         class="col-md-offset-6"> <?php if (isset($_GET['report'])) {
            echo $_GET['report'];
        };
        echo $report; ?>
    </div>
    <div class='panel-heading'>
        <h3 align="center">Edit <?php echo $dynamic_student;?> Information</h3>

    </div>

   <form class='form-horizontal' role='form' method="POST" action="" > 
   <!--onSubmit="return valid()"-->
   <!-- roll no. -->
        <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' style="text-align:left;">Roll No</label>

            <div class='col-md-2' style="text-align:left;">
                <input class='form-control' id='std_prn' name="std_prn" type='text' value="<?php echo $std_PRN; ?>" readonly="readonly">
            </div>

            <div class='col-md-3 ' id="errorrollno" style="color:#FF0000"></div>
        </div>
    <!-- Name -->
        <div class="row">
            <label class='control-label col-md-2 col-md-offset-2' style="text-align:left;"><?php echo $dynamic_student;?> Name<b style="color:red";> *</b></label>
            <div class='col-md-3' style="text-align:left;">
                <input class='form-control' id='complete_name' name="complete_name" type='text' size="50"
                       value="<?php echo $std_complete_name; ?>">
            </div>
			<div class='col-md-8 col-md-offset-4' id="errorname" style="color:#FF0000"></div>
        </div>
        
    <!-- Father Name -->
    <?php if($FLAG == 'CompleteName' ) { ?>
        <div class='form-group'>
        </div>
        <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' style="text-align:left;">Father Name</label>
            <div class='col-md-3' style="text-align:left;">
                    <input class='form-control' id='c_father_name' name="c_father_name" type='text' size="50"
                        value="<?php echo $mname; ?>">
            </div>
         <div class='col-md-8 col-md-offset-4' id="errorfatname" style="color:#FF0000"></div>
        </div>
    <?php } ?>

    <!-- Class and Division -->
    <?php if($FLAG == 'Class_Division' ) { ?>

        <div class="form-group">
            <label class='control-label col-md-2 col-md-offset-2' style="text-align:left;">Class</label>
            <div class='col-md-2' style="text-align:left;">
                <input class='form-control' id="id_class" name="class" type='text' value="<?php echo $std_class; ?>">
            </div>
            <div class='col-md-8 col-md-offset-4' id="errorclass" style="color:#FF0000"></div>
        </div>

        <div class="form-group">
            <label class='control-label col-md-2 col-md-offset-2' style="text-align:left;">Division</label>
            <div class='col-md-2' style="text-align:left;">      
                <input class='form-control' id='id_div' name="div" type='text' value="<?php echo $std_div; ?>">
            </div>
            <div class='col-md-8 col-md-offset-4' id="errordiv" style="color:#FF0000"></div>
        </div>

    <?php } ?>


    <!-- phone -->
    <div class='form-group'> </div>
    <?php if($FLAG == 'phone' ) { ?>
		<div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='id_phone'
                   style="text-align:left;">Phone</label>
            <div class='col-md-3' style="text-align:left;">                 
                <input class='form-control' id='id_phone' name="std_phone" type='text' onKeyPress="return isNumberKey(event)" maxlength="10" placeholder="Phone"
                       value="<?php echo $std_phone; ?>">
            </div>
            <div class='col-md-8 col-md-offset-4' id="errorphone" style="color:#FF0000"></div>
        </div>
    <?php } ?>

    <div class='form-group'></div> 

	<!-- Email - ID -->	
    <?php if($FLAG == 'email' ) { ?>
        <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='id_email' style="text-align:left;">Email ID</label>
            <div class='col-md-3' style="text-align:left;">
                        <input class='form-control' id='id_email' name="std_email" type='text' placeholder="Email ID"
                            value="<?php echo $std_email; ?>"> 
            </div>
            <div class='col-md-8 col-md-offset-4' id="erroremail" style="color:#FF0000"></div>
        </div>
    <?php } ?>


    <!-- internal Email - ID -->
    <?php if($FLAG == 'email' ) { ?>	
        <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='internal_email' style="text-align:left;">Internal Email Id</label>
            <div class='col-md-3' style="text-align:center;">
                <input class='form-control' id='internal_email' name="internal_email" type='text'
                       value="<?php echo $std_internal_email; ?>">
            </div>
            <div class='col-md-8 col-md-offset-4' id="erroremail" style="color:#FF0000"></div>
        </div>
    <?php } ?>

    <!-- Branch Name  -->
    <?php if($FLAG == 'branch' ) { ?>	
        <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='std_branch' style="text-align:left;">Branch Name</label>
            <div class='col-md-3' style="text-align:center;">
                        <input class='form-control' id='std_branch' name="std_branch" type='text'
                       value="<?php echo $std_branch; ?>">
            </div>
            <div class='col-md-8 col-md-offset-4' id="erroremail" style="color:#FF0000"></div>
        </div>
    <?php } ?>

    <!-- Year ID -->
    <?php if($FLAG == 'Year' ) { ?>
        <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='id_email' style="text-align:left;">Year ID</label>
            <div class='col-md-3' style="text-align:center;">
                        <input class='form-control' id='std_year' name="std_year" type='text'
                       value="<?php echo $std_year; ?>"> 
            </div>
            <div class='col-md-8 col-md-offset-4' id="erroremail" style="color:#FF0000"></div>
        </div>
    <?php } ?>


    <!-- Academic Year -->
    <?php if($FLAG == 'acdemic_year' ) { ?>
        <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='Academic_year' style="text-align:left;">Academic Year</label>
            <div class='col-md-3' style="text-align:center;">       
                        <input class='form-control' id='Academic_year' name="Academic_year" type='text'
                       value="<?php echo  $Academic_year; ?>">
            </div>
            <div class="row" align="center" id='erroraddress' style="color:#FF0000;"></div>
        </div>
    <?php } ?>


    <!-- Department -->
    <?php if($FLAG == 'department' ) { ?>
        <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='std_dept' style="text-align:left;">Department</label>
            <div class='col-md-3' style="text-align:center;">
                    <input class='form-control' id='std_dept' name="std_dept" type='text'
                       value="<?php echo $std_dept; ?>">
            </div>
            <div class="row" align="center" id='erroraddress' style="color:#FF0000;"></div>
        </div>
    <?php } ?>   

    <!-- Date of Birth-->
    <?php if($FLAG == 'dob' ) { ?>
        <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' style="text-align:left;">Date Of Birth</label>
            <div class='col-md-2' style="text-align:left;">
                        <input class='form-control datepicker' id='dob' name="std_dob" 
                        value="<?php echo $std_dob; ?>">
            </div>
            <div class='col-md-10 col-md-offset-3 ' id="errordob" style="color:#FF0000"></div>
        </div>
    <?php } ?>

    <!-- gender -->
    <?php if($FLAG == 'gender' ) { ?>
        <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' style="text-align:left;">Gender</label>
                    <div class='col-md-2' style="font-weight: 600;color: #777;">
                        <input type="radio" name="gender" <?php if ($std_gender == "Male") {
                            echo "checked";
                        } ?> id="gender1" value="Male"> Male
                    </div>
                    <div class='col-md-2' style="font-weight: 600; color: #777;">
                        <input type="radio" name="gender" <?php if ($std_gender == "Female") {
                            echo "checked";
                        } ?> id="gender2" value="Female"> Female
                    </div>
            <div class='col-md-4 indent-small' id="errorgender" style="color:#FF0000"></div>
        </div>
    <?php } ?>
    
    <!-- temporary address -->
    <?php if($FLAG == 'temp_address' ) { ?>
        <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' style="text-align:left;">Temporary Address</label>
            <div class='col-md-3' style="text-align:left;">
                        <textarea class='form-control' id='id_address' name="temp_address" rows='3'
                                value=""><?php echo $std_temp_address; ?></textarea>
            </div>
            <div class="row" align="center" id='erroraddress' style="color:#FF0000;"></div>
        </div>
    <?php } ?>


    <!-- permanent address -->
    <?php if($FLAG == 'perm_address' ) { ?>
        <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' style="text-align:left;">Permanant Address</label>
            <div class='col-md-3' style="text-align:left;">
                <textarea class='form-control' id='id_address' name="permanant_address" rows='3'
                          value=""><?php echo $std_permanant_add; ?></textarea>
            </div>
            <div class="row" align="center" id='erroraddress' style="color:#FF0000;"></div>
        </div>
    <?php } ?>
      
      
    <!-- parmanent District -->
    <?php if($FLAG == 'perm_dist' ) { ?>
        <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='id_email' style="text-align:left;">Permanent District</label>
            <div class='col-md-3' style="text-align:center;">
                        <input class='form-control' id='Permanent_district' name="Permanent_district" type='text'
                       value="<?php echo $std_permanant_district; ?>">   
            </div>
        <div class="row" align="center" id='erroraddress' style="color:#FF0000;"></div>
        </div>
    <?php } ?>


    <!-- parmanent Pincode -->
    <?php if($FLAG == 'perm_pincode' ) { ?>
        <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='pincode' style="text-align:left;">Permanent Pincode</label>
            <div class='col-md-3' style="text-align:center;">    
                <input class='form-control' id='pincode' name="Permanent_pincode" type='text'
                       value="<?php echo $std_permanant_pincode; ?>">
            </div>
        <div class="row" align="center" id='erroraddress' style="color:#FF0000;"></div>
        </div>
    <?php } ?>
  

    <!-- country -->
    <?php if( $FLAG == 'place' ) { ?>
		<div class='form-group'>
                <label class='control-label col-md-2 col-md-offset-2' style="text-align:left;">Country</label>
                <div class='col-md-3'>
                            <select id="country" name="country" class='form-control'></select>
                </div>
            <div class='col-md-3 indent-small' id="errorcountry" style="color:#FF0000"></div>
        </div>   
    <?php } ?>    

    <!-- state -->
    <?php if( $FLAG == 'place' ) { ?>
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
    <?php } ?>
     


    <!-- city -->
    <?php if( $FLAG == 'place' or $FLAG == 'city' ) { ?>
        <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' style="text-align:left;">City</label>
            <div class='col-md-3' style="text-align:left;">
                <input type="text" class='form-control' id='id_accomodation' name='city'
                        value="<?php echo $std_city; ?>">
            </div>
            <div class='col-md-4 indent-small' id="errorcity" style="color:#FF0000"></div>
        </div>
    <?php } ?>
    

   <!--    
	   <div class="row" style="padding-top:7px;" id="text_country" style="display:block">
            <div class="col-md-5"><h4 align="center">Country:</h4></div>
            <div class="col-md-3"><input type="text" class='form-control' id="country1" name="country"
                                         style="width:100%;" value="<?php //echo $std_country; ?>" readonly>
            </div>
            <div class="col-md-1" id="firstBtn"><a href="" onClick="return showOrhide()">Hide</a></div>
        </div>
        <div class='row ' style="padding-top:7px; display:none" id="text_country1">

            <div class='col-md-3 indent-small' id="errorcountry" style="color:#FF0000"></div>
        </div>
        <div class='row ' style="padding-top:7px; display:none" id="text_state1">

            <div class='col-md-3 indent-small' id="errorstate" style="color:#FF0000"><?php // echo $report4; ?></div>
        </div>
        <div class="row" style="padding-top:7px;" id="text_state" style="display:block">
            <div class="col-md-5"><h4 align="center"> State:</h4></div>
            <div class="col-md-3"><input type="text" id="state1" name="state1" class='form-control' style="width:100%;"
                                         value="<?php// echo $std_state; ?>">
            </div>
        </div>
        <script language="javascript">
            populateCountries("country", "state");
            populateCountries("country2");
        </script>
	-->	
    

    
    <!-- submit and cancel -->
        <div class='form-group'>
            <div class='col-md-3 col-md-offset-3'>
                <center><input class='btn-lg btn-primary' type='submit' value="Update" name="update" onClick="return valid()"/>
                    <!-- onClick="return valid()"/>-->
            </div>

            <div class='col-md-2'>
                <a href="javascript:history.go(-1)"><input type="button" class='btn-lg btn-danger' value="Cancel"/> </a>
            </div>
        </div>

    </form>

            <div class='form-group row'>
                <div class='col-md-offset-4' >
                    <a href="edit_student_details.php?t_id=<?php echo $t_id; ?>"> <input type="button" class="btn-lg btn-primary" value="Edit Complete Details: <?php echo $std_complete_name; ?>" style="padding:5px;"/></a>
                </div>
        
            </div>



</div>

</body>
</html>

<script>
	$(document).ready(function () {
		  var country = "<?php echo $std_country ?>" ;
		  var  state = "<?php echo $std_state ?>" ;
		  $("#country").val(country).change();
		  $("#state").val(state).change();
	});
</script>


