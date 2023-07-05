<?php
//Reporting Manager added by Rutuja Jori for assigning Reporting Manager to Manager on 17/12/2019 for SMC-4270
if (isset($_GET['edit_id'])) {
    $t_id = $_GET['edit_id'];
    $report = "";
    include_once("school_staff_header.php");
    if (isset($_POST['Update'])) {
        $t_id = $_GET['edit_id'];
        //$email = $_POST['id_email'];
        function test_input($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        if (empty($_POST["id_email"])) {
            $emailErr = "Email is required";
        } else {
            $email = test_input($_POST["email"]);
            // check if e-mail address is well-formed
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "Invalid email format";
            }
        }
        if (empty($_POST["id_email"])) {
            $emailErr = "Email is required";
        } else {
            $email = test_input($_POST["email"]);
            // check if e-mail address is well-formed
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "Invalid email format";
            }
        }
        //$row=mysql_query("select * from tbl_teacher where t_email like '$email' ");
        //if(mysql_num_rows($row)<=0)
        //{
        $id_first_name = $_POST['id_first_name'];
        $id_last_name = $_POST['id_last_name'];
        $name = $id_first_name . " " . $id_last_name;

        $test = $_POST['other1'];

                if($test == "" ){
                    $education = $_POST['id_education'];
        
                }
                else{
                    $education = $test;
                }

        $experience = $_POST['experience'];
        $date = $_POST['dob'];


        $class = $_POST['class1'];
        $subject = $_POST['subject'];
        $email = $_POST['id_email'];

        $department = $_POST['department'];

        $phone = $_POST['id_phone'];
        $gender = $_POST['gender'];
        $address = $_POST['address'];
        if ($_POST['country'] == -1) {
            $country = $_POST['country1'];
        } else {
            $country = $_POST['country'];
        }
        if (isset($_POST['state']) && $_POST['state'] != '') {
            $state = $_POST['state'];
        } else {
            $state = $_POST['state1'];
        }
        $city = $_POST['city'];
        
        
        // Start SMC-3495 Modify By yogesh 2018-10-08 07:04 PM 
        //$dates = date('m/d/Y');
        $dates = CURRENT_TIMESTAMP; // define in core/securityfunctions.php
        //end SMC-3495
        $password = $id_first_name . "123";
        list($year,$month,$day) = explode("-", $date);
        $year_diff = date("Y") - $year;
        $month_diff = date("m") - $month;
        $day_diff = date("d") - $day;
        if ($day_diff < 0 || $month_diff < 0) $year_diff--;
        $age = $year_diff;
        $sqls = "update tbl_teacher set t_name='$name',t_exprience='$experience',t_designation='$designation',t_qualification='$education',t_address='$address',t_dept = '$department',t_city='$city',t_dob='$date',t_age='$age',t_gender='$gender',t_country='$country',t_email='$email',t_phone='$phone',state='$state' where id=" . $t_id . "";

        $count = mysql_query($sqls) or die(mysql_error());
        if ($count >= 1) {
            $to = $email;
            $from = "smartcookiesprogramme@gmail.com";
            $subject = "Succesful Registration";
            $message = "Hello " . $id_first_name . " " . $id_last_name . "\r\n\r\n" .
                "Thanks for registration with Smart Cookie as ".$dynamic_teacher."\r\n" .
                "your Username is: " . $email . "\n\n" .
                "your password is: " . $password . "\n\n" .
                "your School ID is: " . $school_id . "\n\n" .
                "Regards,\r\n" .
                "Smart Cookie Admin";

            mail($to, $subject, $message);

            $report = "Successfully updated";
            header("Location:teacherlist_sc.php");
        }
    } else {
        $report = "Email ID is already present";
    }

    //}
    ?>
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

            $('#country').change(function () {

                var country = document.getElementById("country").value;

                if (country == '-1') {
                    document.getElementById('errorcountry').innerHTML = 'Please enter country';
                    return false;
                } else {
                    document.getElementById('errorcountry').innerHTML = '';
                }
            });
        });
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
        <script src='js/bootstrap-datepicker.min.js' type='text/javascript'></script>
        <script src="js/city_state.js" type="text/javascript"></script>
        <link href='css/datepicker.min.css' rel='stylesheet' type='text/css'>

        <script type="text/javascript">
            $(function () {

                $("#id_checkin").datepicker({
                    changeMonth: true,
                    changeYear: true
                });

            });
        </script>

        <script>


            var reg = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;
            function PhoneValidation(phoneNumber) {
                var OK = reg.exec(phoneNumber.value);
                if (!OK)
                    document.getElementById('errorphone').innerHTML = 'Please Enter Valid Phone Number';
                return false;

            }
            function valid() {
                alert('By');
                var first_name = document.getElementById("id_first_name").value;

                var last_name = document.getElementById("id_last_name").value;


                if (first_name == null || first_name == "" || last_name == null || last_name == "") {

                    document.getElementById('errorname').innerHTML = 'Please Enter Name';

                    return false;
                } else {
                    document.getElementById('errorname').innerHTML = '';
                }

                regx1 = /^[A-z ]+$/;
                //validation for name
                if (!regx1.test(first_name) || !regx1.test(last_name)) {
                    document.getElementById('errorname').innerHTML = 'Please Enter valid Name';
                    return false;
                } else {
                    document.getElementById('errorname').innerHTML = '';
                }


                var experience = document.getElementById("experience").value;
                if (experience == null || experience == "") {

                    document.getElementById('errorexperience').innerHTML = 'Please Enter Experience';

                    return false;
                }
                else if (experience < 0) {
                    document.getElementById('errorexperience').innerHTML = 'Please Enter valid Experience';

                    return false;

                }
                else {
                    document.getElementById('errorexperience').innerHTML = '';
                }


                var myDate = new Date(id_checkin);

                var today = new Date();

                if (id_checkin == "") {


                    document.getElementById('errordate').innerHTML = 'Please enter date of birth';

                    return false;
                }


                else if (myDate.getFullYear() >= today.getFullYear()) {

                    if (myDate.getFullYear() == today.getFullYear()) {

                        if (myDate.getMonth() == today.getMonth()) {
                            if (myDate.getDate() >= today.getDate()) {

                                document.getElementById("errordate").innerHTML = "please enter valid birth date";
                                return false;
                            }
                            else {
                                document.getElementById("errordate").innerHTML = "";
                            }


                        }
                        else if (myDate.getMonth() > today.getMonth()) {
                            document.getElementById("errordate").innerHTML = "please enter valid birth date";
                            return false;

                        }
                        else {
                            document.getElementById("errordate").innerHTML = "";
                        }
                    }
                    else {
                        document.getElementById("errordate").innerHTML = "";

                    }
                }


                var gender1 = document.getElementById("gender1").checked;

                var gender2 = document.getElementById("gender2").checked;

                if (gender1 == false && gender2 == false) {
                    document.getElementById('errorgender').innerHTML = 'Please Select gender';
                    return false;
                } else {
                    document.getElementById('errorgender').innerHTML = '';
                }


                /*var subject=document.getElementById("subject").value;
                 if(subject==null||subject=="")
                 {

                 document.getElementById('errorsubject').innerHTML='Please Enter Subject';

                 return false;
                 }else{
                 document.getElementById('errorsubject').innerHTML='';
                 }*/
                var email = document.getElementById("id_email").value;
                alert('8656');
                if (email == null || email == "") {

                    document.getElementById('erroremail').innerHTML = 'Please Enter email';

                    return false;
                }

                //validation of email
                var atpos = email.indexOf("@");
                var dotpos = email.lastIndexOf(".");
                if (atpos < 1 || dotpos < atpos + 2 || dotpos + 2 >= x.length) {
                    document.getElementById('erroremail').innerHTML = 'Please enter valid Email Id';
                    return false;
                } else {
                    //document.getElementById('erroremail').innerHTML='';
                }


                alert('etger');
                var reg_mail = /^[a-zA-Z]*[0-9]*[#!_]*[@]*[.]*[a-zA-Z]*$/;
                alert('ertgrg');
                var regx_result = reg_mail.test(email);
                alert(regx_result);
                if (!regx_result) {
                    document.getElementById('erroremail').innerHTML = 'Please enter valid Email Id';
                    return false;
                }


                var phone = document.getElementById("phone").value;

                if (phone.length > 10 || phone.length < 10 || isNaN(phone)) {
                    document.getElementById('errorphone').innerHTML = 'Please Enter Valid Phone Number';
                    return false;
                }


                var department = document.getElementById("id_department").value;
                if (department == null || department == "") {

                    document.getElementById('errordepartment').innerHTML = 'Please Enter department';

                    return false;
                }

                else {
                    document.getElementById('errordepartment').innerHTML = '';
                }

                // regexp = /^[A-Za-z0-9'\.\-\s\,]*$/;
                // var address = document.getElementById("id_address").value;
                // if (address == null || address == "") {

                //     document.getElementById('erroraddress').innerHTML = 'Please Enter address';

                //     return false;
                // } 
                else if(!regexp.test(address)){
                    document.getElementById('erroraddress').innerHTML = 'Please Enter address';
                    return false;
                }
                else {
                    document.getElementById('erroraddress').innerHTML = '';
                }


                var country = document.getElementById("country").value;

                if (country == "-1") {

                    document.getElementById('errorcountry').innerHTML = 'Please Enter country';

                    return false;
                } else {
                    document.getElementById('errorcountry').innerHTML = '';
                }

                var state = document.getElementById("state").value;
                if (state == null || state == "") {

                    document.getElementById('errorstate').innerHTML = 'Please Enter state';

                    return false;
                } else {
                    document.getElementById('errorstate').innerHTML = '';
                }
                var city = document.getElementById("id_city").value;

                if (city == null || city == "") {

                    document.getElementById('errorcity').innerHTML = 'Please Enter city';

                    return false;
                } else {
                    document.getElementById('errorcity').innerHTML = '';
                }

            }
        </script>
<style>
.error {color: #FF0000;}
</style>
    </head>
    <?php


    $get_teacher = mysql_query("SELECT * FROM `tbl_teacher` WHERE id=" . $t_id . "");
    $get_row_t = mysql_fetch_array($get_teacher);
print_r($get_row_t);
    $name = explode(" ", $get_row_t['t_name']);


    $name['0'];
    $name['1'];


    ?>
    <body>
    <div class='container'>
        <div class='panel panel-primary dialog-panel' style="background-color:#FFFFFF;background-image="
        "">
        <div style="color:#060;font-size:15px;font-weight:bold;margin-top:10px;"> <?php if (isset($_GET['report'])) {
                echo $_GET['report'];
            }; ?></div>
        <div class='panel-heading'>

            <!-- <h3 align="center">Edit Teacher Setup</h3>


            <h5 align="center"><a href="Add_teacherSheet.php?id=<?//=$school_id
            ?>" >Add Excel Sheet</a></h5>-->
         <!--   <h5 align="center"><b style="color:red;">All Field Are mandatory</b></h5>   -->

        </div>
        <div class='panel-body'>
            <form class='form-horizontal' role='form' method="post">


                <div class='form-group'>

                    <label class='control-label col-md-2 col-md-offset-2' for='id_title' style="text-align:left;">Teacher
                        Name<span class="error">* </span></label>
                    <div class='col-md-8'>

                        <div class='col-md-3 '>
                            <div class='form-group internal'>
                                <input class='form-control' id='id_first_name' value="<?= $name['0']; ?>"
                                       name="id_first_name" placeholder='First Name' type='text'>
                            </div>
                        </div>
                        <div class='col-md-3 col-sm-offset-1'>
                            <div class='form-group internal'>
                                <input class='form-control' id='id_last_name' value="<?= $name['1']; ?>"
                                       name="id_last_name" placeholder='Last Name' type='text'>
                            </div>
                        </div>
                        <div class='col-md-4 indent-small' id="errorname" style="color:#FF0000">

                        </div>
                    </div>
                </div>

                <?php
                if (isset($get_row_t['t_qualification']) != "0")
                {
                ?>
                <div class='form-group'>
                    <label class='control-label col-md-2 col-md-offset-2' for='id_service' style="text-align:left;">Education</label>
                    <div class='col-md-2'>
                        <select class='multiselect  form-control' id='id_service' name="id_education">
                            <option value='<?= $get_row_t['t_qualification'] ?>'><?= $get_row_t['t_qualification'] ?></option>
                            <option value='BA'>BA</option>
                            <option value='BCom'>BCom</option>
                            <option value='BSc'>BSc</option>
                            <option value='MA'>MA</option>
                            <option value='MCom'>MCom</option>
                            <option value='MSc'>MSc</option>
                            <option value='B.ED'>B.ED</option>
                            <option value='D.ED'>D.ED</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                                <input type="text" class="form-control col-md-3" value='<?= $get_row_t['t_qualification'] ?>'><?= $get_row_t['t_qualification'] ?> id="other1" name="other1" placeholder="Enter your Education"  style="text-align:left;padding-left:27px;,padding-right: 92px;" >
                            </div>
                    <?php
                    }
                    else
                    {
                    ?>

                    <div class='form-group'>
                        <label class='control-label col-md-2 col-md-offset-2' for='id_service' style="text-align:left;">Education</label>
                        <div class='col-md-2'>
                            <select class='multiselect  form-control' id='id_service' name="id_education">
                                <option value='BA'>BA</option>
                                <option value='BCom'>BCom</option>
                                <option value='BSc'>BSc</option>
                                <option value='MA'>MA</option>
                                <option value='MCom'>MCom</option>
                                <option value='MSc'>MSc</option>
                                <option value='B.ED'>B.ED</option>
                                <option value='D.ED'>D.ED</option>
                            </select>
                        </div>

                        <?php
                        }
                        ?>
                        
                        
                        
                        
                        <label class='control-label col-md-2 '>Designation</label>

                        <div class='col-md-2'>

                            <input class='form-control col-md-8' id='designation'
                                   value="<?= $get_row_t['t_designation'] ?>" name='designation' placeholder='Designation'
                                   type='text'>

                        </div>
                        <div class='col-md-2 indent-small' id="errordesignation" style="color:#FF0000"></div>
                        
                        

                        <label class='control-label col-md-2 '>Experience(in Months)</label>

                        <div class='col-md-2'>

                            <input class='form-control col-md-8' id='experience'
                                   value="<?= $get_row_t['t_exprience'] ?>" name='experience' placeholder='Experience'
                                   type='text'>

                        </div>
                        <div class='col-md-2 indent-small' id="errorexperience" style="color:#FF0000"></div>


                    </div>


                    <div class='form-group'>
                        <label class='control-label col-md-2 col-md-offset-2' for='id_checkin' style="text-align:left;">Date
                            Of Birth</label>
                        <div class='col-md-8'>
                            <div class='col-md-5'>
                                <div class='form-group internal input-group'>
                                    <input class='form-control datepicker' id='id_checkin' name="id_checkin"
                                           value="<?php echo $result['scadmin_dob'] ?>">
                                </div>

                                <div class='col-md-15' id="errordob" style="color:#FF0000"></div>
                            </div>

                        </div>
                    </div>


                    <div class='form-group'>
                        <label class='control-label col-md-2 col-md-offset-2' for='id_pets' style="text-align:left;">Gender</label>
                        <div class='col-md-2' style="font-weight: 600;
color: #777;">
                            <input type="radio"
                                   name="gender" <?php echo ($get_row_t['t_gender'] == "Male") ? "checked" : "" ?>
                                   id="gender1" value="Male">
                            Male
                        </div>
                        <div class='col-md-3' style="font-weight: 600;
color: #777;">
                            <input type="radio"
                                   name="gender" <?php echo ($get_row_t['t_gender'] == "Female") ? "checked" : "" ?>
                                   id="gender2" value="Female">
                            Female
                        </div>

                        <div class='col-md-2 indent-small' id="errorgender" style="color:#FF0000">
                        </div>
                    </div>


                    <div class='form-group'>

                        <label class='control-label col-md-2 col-md-offset-2' for='id_email' style="text-align:left;">Contact</label>

                        <div class='col-md-6'>
                            <div class='form-group'>
                                <div class='col-md-6'>
                                    <input class='form-control' id='id_email' value="<?= $get_row_t['t_email'] ?>"
                                           name="id_email" placeholder='E-mail ID' type='email'/>
                                </div>
                                <div class='col-md-3 indent-small' id="erroremail" style="color:#FF0000"></div>
                            </div>


                            <div class='form-group'>
                                <div class='col-md-6'>
                                    <input class='form-control' id='phone' name="id_phone" placeholder='Mobile No'
                                           maxlength="10" type='text' onChange="PhoneValidation(this);">
                                </div>
                                <div class='col-md-3 indent-small' id="errorphone" style="color:#FF0000"></div>
                            </div>
                        </div>

                    </div>


                    <div class='form-group'>
                        <label class='control-label col-md-2 col-md-offset-2' for='id_department'
                               style="text-align:left;">Department</label>
                        <div class='col-md-3'>
                            <input type='text' class='form-control' id='id_department'
                                   value="<?= $get_row_t['t_department'] ?>" name="department"
                                   placeholder='Department'/>
                        </div>
                        <div class='col-md-3 indent-small' id="errordepartment" style="color:#FF0000"></div>
                    </div>


                    <div class='form-group'>
                        <label class='control-label col-md-2 col-md-offset-2' for='id_comments'
                               style="text-align:left;">Address</label>
                        <div class='col-md-4'>
                            <textarea class='form-control' id='id_address' name="address" placeholder='Address'
                                      rows='3'><?= $get_row_t['t_address'] ?></textarea>
                        </div>
                        <div class='col-md-2 indent-small' id="erroraddress" style="color:#FF0000"></div>
                    </div>

                    <div class="row" align="center" id='erroraddress' style="color:#FF0000;"></div>


                    <div class="row" style="padding-top:7px;" id="text_country" style="display:block">

                        <div class="col-md-5"><h4 align="left">Country:</h4></div>
                        <div class="col-md-5"><input type="text" class='form-control' id="country1" name="country1"
                                                     style="width:100%;" value="<?= $get_row_t['t_country'] ?>"
                                                     readonly>
                        </div>
                        <div class="col-md-1" id="firstBtn"><a href="" onclick="return showOrhide()">Edit</a></div>

                    </div>

                    <div class='row ' style="padding-top:7px; display:none" id="text_country1">
                        <div class="col-md-5"><h4 align="left">Country </h4></div>
                        <div class='col-md-5'>
                            <select id="country" name="country" class='form-control'></select>
                        </div>


                        <div class='col-md-3 indent-small' id="errorcountry" style="color:#FF0000"></div>
                    </div>


                    <div class='row ' style="padding-top:7px; display:none" id="text_state1">
                        <div class="col-md-5"><h4 align="left">State </h4></div>
                        <div class='col-md-5'>
                            <select id="state" name="state" class='form-control'></select>
                        </div>


                        <div class='col-md-3 indent-small' id="errorstate"
                             style="color:#FF0000"><?php // echo $report4;
                            ?></div>
                    </div>


                    <div class="row" style="padding-top:7px;" id="text_state" style="display:block">
                        <div class="col-md-5"><h4 align="left"> State:</h4></div>
                        <div class="col-md-5"><input type="text" id="state1" name="state1" class='form-control'
                                                     style="width:100%;" value="<?= $get_row_t['state'] ?>" readonly>


                        </div>


                    </div>
                    <script language="javascript">
                        populateCountries("country", "state");
                        populateCountries("country2");
                    </script>

                    <div class='form-group'>
                        <label class='control-label col-md-2 col-md-offset-2' for='id_accomodation'
                               style="text-align:left;">City</label>
                        <div class='col-md-3'>
                            <input type="text" class='form-control' value="<?= $get_row_t['t_city'] ?>" id='id_city'
                                   name="city" placeholder="City">
                        </div>
                        <div class='col-md-3 indent-small' id="errorcity" style="color:#FF0000"></div>
                    </div>

                    <div class='form-group row'>
                        <div class='col-md-2 col-md-offset-4'>
                            <input class='btn-lg btn-primary' type='submit' value="Update" name="Update"
                                   onClick="return valid()" style="padding:5px;"/>
                        </div>

                        <div class='col-md-1'>

                            <a href="teacherlist_sc.php"><input type="button" class='btn-lg btn-danger' value="Cancel"
                                                                name="cancel" style="padding:5px;"/></a>

                        </div>


            </form>
        </div>
        <div class='row' align="center" style="color:#F00;"><?php echo $report; ?></div>
    </div>
    </div>
    </body>
    <?php
} else
    if (isset($_GET['id'])) {
        $report = "";
        include_once("school_staff_header.php");

        if (isset($_POST['submit'])) {
            $id = $_GET['id'];
            $email = $_POST['id_email'];
            $r = mysql_query("select * from tbl_school_adminstaff where id=" . $id . "");
            $rr = mysql_fetch_array($r);
            $school_id = $rr['school_id'];


            $row = mysql_query("select * from tbl_teacher where t_email = '$email' and school_id='$school_id'");
            if (mysql_num_rows($row) <= 0) {
                $id_first_name = $_POST['id_first_name'];
                $id_last_name = $_POST['id_last_name'];
                $name = $id_first_name . " " . $id_last_name;
                //$education = $_POST['id_education'];
                $test = $_POST['other1'];

                if($test == "" ){
                    $education = $_POST['id_education'];
        
                }
                else{
                    $education = $test;
                }
                

                $experience = $_POST['experience'];
                $date = $_POST['dob'];

                //$gender = $_POST['id_gender'];
                //retrive school_id and name school_admin
                //$arrs=$smartcookie->retrive_scadmin_profile();


                $results = mysql_query("select * from tbl_school_adminstaff where id=" . $id . "");
                $arrs = mysql_fetch_array($results);
                $staff_id = $arrs['id'];
                $school_id = $arrs['school_id'];
                $getSCname = mysql_query("select * from tbl_school where id=" . $school_id . "");
                $r = mysql_fetch_array($getSCname);
                $school_name = $r['school_name'];

                $class = $_POST['class1'];
                $subject = $_POST['subject'];
                $email = $_POST['id_email'];
                $department = $_POST['department'];
                $phone = $_POST['id_phone'];
                $gender = $_POST['gender'];
                $address = $_POST['address'];
                $country = $_POST['country'];
                $state = $_POST['state'];
                $city = $_POST['city'];
               // $dates = date('Y/m/d');
                //$assign_date=date('m/d/Y');
                // Start SMC-3495 Modify By yogesh 2018-10-11 07:04 PM 
                //$dates = date('Y/m/d');
                $dates = CURRENT_TIMESTAMP; // define in core/securityfunctions.php
                //end SMC-3495
                   $password = $id_first_name . "123";


                  list($year,$month,$day) = explode("-", $date);
                
                $year_diff = date("Y") - $year;
                $month_diff = date("m") - $month;
                $day_diff = date("d") - $day;
                if ($day_diff < 0 || $month_diff < 0) $year_diff--;
                $age = $year_diff;


                $sqls = "INSERT INTO `tbl_teacher`(t_name, t_current_school_name,school_id,t_school_staff_id,t_exprience ,t_designation,t_subject,t_class,t_qualification, t_dept,t_address, t_city, t_dob, t_gender,t_age, t_country, t_email,t_date,state,t_phone,t_password) 
                                        VALUES ('$name', '$school_name','$school_id','$staff_id','$experience','$subject','$class','$education','$department','$address','$city','$date','$gender','$age' ,'$country', '$email',  '$dates','$state','$phone','$password')";

                $count = mysql_query($sqls) or die(mysql_error());
                if ($count >= 1) {

                    $to = $email;
                    $from = "smartcookiesprogramme@gmail.com";
                    $subject = "Succesful Registration";
                    $message = "Hello " . $id_first_name . " " . $id_last_name . "\r\n\r\n" .
                        "Thanks for registration with Smart Cookie as teacher\r\n" .
                        "your Username is: " . $email . "\n\n" .
                        "your password is: " . $password . "\n\n" .
                        "your School ID is: " . $school_id . "\n\n" .
                        "Regards,\r\n" .
                        "Smart Cookie Admin";

                    mail($to, $subject, $message);

                    $report = "successfully updated";
                    header("Location:teacher_setup.php?name=t&report=" . $report . "&id=" . $id);
                }
            } else {

                $report = "Email ID is already present";
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
            <script src='js/bootstrap-datepicker.min.js' type='text/javascript'></script>
            <script src="js/city_state.js" type="text/javascript"></script>
            <link href='css/datepicker.min.css' rel='stylesheet' type='text/css'>
            <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
            <script src="js/jquery-1.11.1.min.js"></script>
            <link rel="stylesheet" href="css/bootstrap.min.css">
            <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
            <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
            <script>


                var reg = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;
                function PhoneValidation(phoneNumber) {
                    var OK = reg.exec(phoneNumber.value);
                    if (!OK)
                        document.getElementById('errorphone').innerHTML = 'Please Enter Valid Phone Number';
                    return false;



                    var phone = document.getElementById("phone").value;


                    if (phone>10) {

                        document.getElementById('errorphone').innerHTML = 'Please Enter valid no';

                        return false;
                    }

                    if (phone<10) {

                        document.getElementById('errorphone').innerHTML = 'Please Enter valid no';

                        return false;
                    }


                }
                function valid() {
                    //alert('hello');
                    var first_name = document.getElementById("id_first_name").value;

                    var last_name = document.getElementById("id_last_name").value;

                    if (first_name == null || first_name == "") {

                        document.getElementById('errorname').innerHTML = 'Please Enter Name';

                        return false;
                    } else {
                        document.getElementById('errorname').innerHTML = '';
                    }

                    regx1 = /^[A-z ]+$/;
                    //validation for name
                    if (!regx1.test(first_name)) {
                        document.getElementById('errorname').innerHTML = 'Please Enter valid Name';
                        return false;
                    } else {
                        document.getElementById('errorname').innerHTML = '';
                    }


                    var myDate = new Date(id_checkin);

                    var today = new Date();

                    if (id_checkin == "") {


                        document.getElementById('errordate').innerHTML = 'Please enter date of birth';

                        return false;
                    }


                    else if (myDate.getFullYear() >= today.getFullYear()) {

                        if (myDate.getFullYear() == today.getFullYear()) {

                            if (myDate.getMonth() == today.getMonth()) {
                                if (myDate.getDate() >= today.getDate()) {

                                    document.getElementById("errordate").innerHTML = "please enter valid birth date";
                                    return false;
                                }
                                else {
                                    document.getElementById("errordate").innerHTML = "";
                                }


                            }
                            else if (myDate.getMonth() > today.getMonth()) {
                                document.getElementById("errordate").innerHTML = "please enter valid birth date";
                                return false;

                            }
                            else {
                                document.getElementById("errordate").innerHTML = "";
                            }
                        }
                        else {
                            document.getElementById("errordate").innerHTML = "";

                        }
                    }


                    var experience = document.getElementById("experience").value;
                    if (experience == null || experience == "") {

                        document.getElementById('errorexperience').innerHTML = 'Please Enter Experience';

                        return false;
                    } else {
                        document.getElementById('errorexperience').innerHTML = '';
                    }
                    var gender1 = document.getElementById("gender1").checked;

                    var gender2 = document.getElementById("gender2").checked;

                    if (gender1 == false && gender2 == false) {
                        document.getElementById('errorgender').innerHTML = 'Please Select gender';
                        return false;
                    } else {
                        document.getElementById('errorgender').innerHTML = '';
                    }


                    var subject = document.getElementById("subject").value;
                    if (subject == null || subject == "") {

                        document.getElementById('errorsubject').innerHTML = 'Please Enter Subject';

                        return false;
                    } else {
                        document.getElementById('errorsubject').innerHTML = '';
                    }
                    var email = document.getElementById("id_email").value;
                    if (email == null || email == "") {

                        document.getElementById('erroremail').innerHTML = 'Please Enter email';

                        return false;
                    }

                    //validation of email
                    var atpos = email.indexOf("@");
                    var dotpos = email.lastIndexOf(".");
                    if (atpos < 1 || dotpos < atpos + 2 || dotpos + 2 >= email.length) {
                        document.getElementById('erroremail').innerHTML = 'Please enter valid Email Id';
                        return false;
                    } else {
                        document.getElementById('erroremail').innerHTML = '';
                    }


                    var phone = document.getElementById("phone").value;

                    if (phone.length > 10 )) {
                        document.getElementById('errorphone').innerHTML = 'Please Enter Valid Phone Number';
                        return false;
                    }



                    var department = document.getElementById("id_department").value;
                    if (department == null || department == "") {

                        document.getElementById('errordepartment').innerHTML = 'Please Enter department';

                        return false;
                    }

                    else {
                        document.getElementById('errordepartment').innerHTML = '';
                    }


              /*      var address = document.getElementById("id_address").value;
                    if (address == null || address == "") {

                        document.getElementById('erroraddress').innerHTML = 'Please Enter address';

                        return false;
                    } else {
                        document.getElementById('erroraddress').innerHTML = '';
                    }
*/

                    var country = document.getElementById("country").value;

                    if (country == "-1") {

                        document.getElementById('errorcountry').innerHTML = 'Please Enter country';

                        return false;
                    } else {
                        document.getElementById('errorcountry').innerHTML = '';
                    }

                    var state = document.getElementById("state").value;
                    if (state == null || state == "") {

                        document.getElementById('errorstate').innerHTML = 'Please Enter state';

                        return false;
                    } else {
                        document.getElementById('errorstate').innerHTML = '';
                    }
                    var city = document.getElementById("id_city").value;

                    if (city == null || city == "") {

                        document.getElementById('errorcity').innerHTML = 'Please Enter city';

                        return false;
                    } else {
                        document.getElementById('errorcity').innerHTML = '';
                    }

                }
            </script>
<style>
.error {color: #FF0000;}
</style>
        </head>
        <body>
        <div class='container'>
            <div class='panel panel-primary dialog-panel' style="background-color:#FFFFFF;background-image="
            "">
            <div style="color:red;font-size:15px;font-weight:bold;margin-top:10px;"> <?php if (isset($_GET['report'])) {
                    echo $_GET['report'];
                }; ?></div>
            <div class='panel-heading'>

                <h3 align="center"><?php echo $dynamic_teacher;?> Setup</h3>


               <!-- <h5 align="center"><a href="Add_teacherSheet_20152006PT.php?id=<?= $school_id ?>">Add Excel Sheet</a>
                </h5>-->
                <h5 align="center"><b style="color:red;">All Field Are mandatory</b></h5>

            </div>
            <div class='panel-body'>
                <form class='form-horizontal' role='form' method="post">


                    <div class='form-group'>
                        <label class='control-label col-md-2 col-md-offset-2' for='id_title' style="text-align:left;">Teacher
                            Name </label><span class="error">*</span>
                        <div class='col-md-8'>

                            <div class='col-md-3 '>
                                <div class='form-group internal'>
                                    <input class='form-control' id='id_first_name' name="id_first_name"
                                           placeholder='First Name' type='text'>
                                </div>
                            </div>
                            <div class='col-md-3 col-sm-offset-1'>
                                <div class='form-group internal'>
                                    <input class='form-control' id='id_last_name' name="id_last_name"
                                           placeholder='Last Name' type='text'>
                                </div>
                            </div>
                            <div class='col-md-4 indent-small' id="errorname" style="color:#FF0000">

                            </div>
                        </div>
                    </div>
                

                    <div class='form-group'>
                        <div class='row'>
                            <label class='control-label col-md-2 col-md-offset-2' for='id_service'
                                   style="text-align:left;">Education</label>
                            <div class='col-md-2'>
                                <select class='multiselect  form-control' id='id_service' name="id_education">
                                    <option value='BA'>BA</option>
                                    <option value='BCom'>BCom</option>
                                    <option value='BSc'>BSc</option>
                                    <option value='MA'>MA</option>
                                    <option value='MCom'>MCom</option>
                                    <option value='MSc'>MSc</option>
                                    <option value='B.ED'>B.ED</option>
                                    <option value='D.ED'>D.ED</option>
                                </select>
                            </div>


                            <label class='control-label col-md-2 '>Experience</label>

                            <div class='col-md-2'>

                                <input class='form-control col-md-8' id='experience' name='experience'
                                       placeholder='Experience' type='text'>

                            </div>
                            <div class='col-md-2 indent-small' id="errorexperience" style="color:#FF0000"></div>

                        </div>
                    </div>


                    <div class='form-group'>
                        <label class='control-label col-md-2 col-md-offset-2' for='id_checkin' style="text-align:left;">Date
                            Of Birth</label>
                        <div class='col-md-8'>
                            <div class='col-md-5'>
                                <div class='form-group internal input-group'>
                                    <input class='form-control datepicker' id='id_checkin'  name="id_checkin"
                                           value="<?php echo $result['scadmin_dob'] ?>">
                                    <!--<input class='form-control datepicker' id="id_checkin" name="dob" class="form-control">-->

                                </div>

                                <div class='col-md-15' id="errordob" style="color:#FF0000"></div>
                            </div>

                        </div>
                    </div>


                    <div class='form-group'>
                        <label class='control-label col-md-2 col-md-offset-2' for='id_pets' style="text-align:left;">Gender</label>
                        <div class='col-md-2' style="font-weight: 600;
color: #777;">
                            <input type="radio" name="gender" id="gender1" value="Male">
                            Male
                        </div>
                        <div class='col-md-3' style="font-weight: 600;
color: #777;">
                            <input type="radio" name="gender" id="gender2" value="Female">
                            Female
                        </div>

                        <div class='col-md-2 indent-small' id="errorgender" style="color:#FF0000">
                        </div>
                    </div>


                    <div class='form-group'>
                        <label class='control-label col-md-2 col-md-offset-2' for='id_email' style="text-align:left;">Contact</label>
                        <div class='col-md-6'>
                            <div class='form-group'>
                                <div class='col-md-6'>
                                    <input class='form-control' id='id_email' name="id_email" placeholder='E-mail'
                                           type='email'>
                                </div>
                                <div class='col-md-3 indent-small' id="erroremail" style="color:#FF0000">

                                </div>
                            </div>
                            <div class='form-group '>
                                <div class='col-md-6'>
                                    <input class='form-control' id='phone' name="id_phone" placeholder='Mobile No'
                                           maxlength="10" type='text' onChange="PhoneValidation(this);">
                                </div>
                                <div class='col-md-3 indent-small' id="errorphone" style="color:#FF0000">

                                </div>
                            </div>
                        </div>
                    </div>


                    <div class='form-group'>
                        <label class='control-label col-md-2 col-md-offset-2' for='id_department'
                               style="text-align:left;">Department</label>
                        <div class='col-md-3'>
                            <input type='text' class='form-control' id='id_department'
                                   value="<?= $get_row_t['t_department'] ?>" name="department"
                                   placeholder='Department'/>
                        </div>
                        <div class='col-md-3 indent-small' id="errordepartment" style="color:#FF0000"></div>
                    </div>


                    <div class='form-group'>
                        <label class='control-label col-md-2 col-md-offset-2' for='id_comments'
                               style="text-align:left;">Address</label>
                        <div class='col-md-4'>
                            <textarea class='form-control' id='id_address' name="address" placeholder='Address'
                                      rows='3'></textarea>
                        </div>
                        <div class='col-md-2 indent-small' id="erroraddress" style="color:#FF0000"></div>
                    </div>
                    <div class='form-group'>
                        <label class='control-label col-md-2 col-md-offset-2' style="text-align:left;">Country</label>
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
                        <label class='control-label col-md-2 col-md-offset-2' for='id_accomodation'
                               style="text-align:left;">City</label>
                        <div class='col-md-3'>
                            <input type="text" class='form-control' id='id_city' name="city" placeholder="City">
                        </div>
                        <div class='col-md-3 indent-small' id="errorcity" style="color:#FF0000"></div>
                    </div>

                    <div class='form-group row'>
                        <div class='col-md-2 col-md-offset-4'>
                            <input class='btn-lg btn-primary' type='submit' value="Submit" name="submit"
                                   onClick="return valid()" style="padding:5px;"/>
                        </div>
                        <div class='col-md-1'>

                            <a href="teacherlist_sc.php"><input type="button" class='btn-lg btn-danger' value="Cancel"
                                                                name="cancel" style="padding:5px;"/></a>

                        </div>


                </form>
            </div>
            <div class='row' align="center" style="color:#FF0000"><?php echo $report; ?></div>
        </div>
        </div>
        </body>

        <!-- Admin Header -->

        <?php
    } else {
        ?>
        <?php
        $errorreport = "";
        //Changes done by Pranali on 18-06-2018 for bug SMC-2415
        
        session_start();
        include_once("function.php");
        
        $school_id=$_SESSION['school_id'];
        
        
        
        if (isset($_GET['name'])) {
            include_once("school_staff_header.php");
        } else {
            include_once("scadmin_header.php");
        }
//Updated code by Rutuja Jori for merging Add & Edit pages into one on 29/11/2019 for SMC-4196
if(isset($_GET['t_id'])==''){
        if (isset($_POST['submit'])) {

            $email = $_POST['id_email'];
             $inemail = $_POST['in_email'];
            $t_id = $_POST['t_id'];
            $r = mysql_query("select * from tbl_school_adminstaff where id=" . $id . "");
            $rr = mysql_fetch_array($r);
            
            if ($email != '') {
                $row = mysql_query("select * from tbl_teacher where t_email = '$email' and school_id ='$school_id'");
                if (mysql_num_rows($row) <= 0) {
                    
                    //change in below query done by Pranali
                    $row_id = mysql_query("select * from tbl_teacher where t_id='$t_id'  and school_id ='$school_id'");
                    if (mysql_num_rows($row_id) <= 0) {
                         $id_first_name = $_POST['id_first_name'];
                         $password = $t_id;
                         $id_middle_name = $_POST['id_middle_name'];
                         $id_last_name = $_POST['id_last_name'];
                         $name = $id_first_name . " " . $id_middle_name. " " .$id_last_name;
                        //  $education = $_POST['id_education'];
                         $test = $_POST['other1'];
                        
                        if($test == "" ){
                             $education = $_POST['id_education'];
                
                         }
                         else{
                             $education = $test;
                         }


                         $exp = $_POST['experience'];
                         $experience_month = $_POST['experience_month'];
                          
                         $experience= $exp . "." . $experience_month;
                         $designation = $_POST['designation'];
                         $id_checkin = $_POST['id_checkin'];
                         $employee= $_POST['id_employee'];
                        
                         $fields = array("id" => $id);
                         $table = "tbl_school_admin";

                        $smartcookie = new smartcookie();

                        $results = $smartcookie->retrive_individual($table, $fields);
                        $arrs = mysql_fetch_array($results);
                        $school_name = $arrs['school_name'];
                        //school_type & entity_type_id added by Rutuja Jori on 31/12/2019 for differentiating between Teacher & Manager & for SMC-4304
                        if ($user=='HR Admin'){
                            $school_type = 'organization';
                            $entity_type_id='203';
                        }
                        else{
                             $school_type = 'school';
                             $entity_type_id='103';
                        }
                             
                        $cls = $_POST['class'];
                        // Null condition added by Rutuja on 30/12/2019 if $class is empty for SMC-4300
                        $class = !empty($cls) ? "'$cls'" : "NULL";
                        
                        $subject = $_POST['subject'];
                         $acad_year = $_POST['Intruduce_YeqarID'];
                        $academicyear = explode (",", $acad_year); 

                        $a = $academicyear[0];
                        $ac_year = $academicyear[1];
                        $academic_year = $academicyear[2];
                        $academicyear = explode (",", $acad_year); 
                        $academic_year = $academicyear[2];
                        $email = $_POST['id_email'];
                        $inemail = $_POST['in_email'];
                        $r_id = $_POST['reporting_id'];
                        $report = explode (",", $r_id); 
                        $reporting_id = $report[0];
                        $depart = $_POST['dept'];
                         $dep = explode (",", $depart); 
                         $department = $dep[0];
                         $dept_id = $dep[1];
                         
                        $phone = $_POST['phone'];
                        $gender = $_POST['gender'];
                        $address = mysql_real_escape_string($_POST['id_address']);
                         $t_address = mysql_real_escape_string ($_POST['t_address']);
                        $country = $_POST['country'];
                         $calling_code = $_POST['calling_code'];
                        $state = $_POST['state'];
                        $city = $_POST['id_city'];
                        $group_teacher_id = $_POST['group_teacher_id'];
                        $edu_org_teacher_id = $_POST['edu_org_teacher_id'];
                        $state_group_teacher_id = $_POST['state_group_teacher_id'];
                        $state_group_id = $_POST['state_group_id'];
                        $edu_org_id = $_POST['edu_org_id'];
                        
                            $id_date = CURRENT_TIMESTAMP; 

                            $password = $t_id;

        
 
    list($month,$day,$year) = explode("/",$id_checkin);
    
    
    $year_diff  = date("Y") - $year; 
    $month_diff = date("m") - $month; 
    $day_diff   = date("d") - $day; 
        if ($day_diff < 0 || $month_diff < 0) $year_diff--;
    
    $age= $year_diff;

    
    $dateformat=$year. "-" .$month. "-" .$day;
       //If department is All then inserted dept_id & department as NULL and fetched department dynamically for SMC-4034 on 29/01/2020 for SMC-4034
                                                          
   if($department=="All" && $dept_id==0)
                        {//NOW() added by Rutuja to insert t_date on 03/03/2020 for SMC-4575
                  $sqls = "INSERT INTO `tbl_teacher`(t_academic_year,school_type,entity_type_id,reporting_manager_id,t_id,CountryCode,t_name,t_middlename,t_lastname,t_complete_name, t_current_school_name,school_id,t_exprience ,t_designation,t_subject,t_qualification,t_dept,t_DeptID,t_class, t_address,t_temp_address, t_city, t_dob, t_gender,t_age, t_country, t_email,t_internal_email,  t_date,state,t_phone,t_password,t_emp_type_pid,group_member_id,created_by,created_on,group_teacher_id,edu_org_teacher_id,state_group_teacher_id,state_group_id,edu_org_id) VALUES ('$academic_year','$school_type','$entity_type_id','$reporting_id','$t_id','$calling_code','$id_first_name','$id_middle_name', '$id_last_name','$name','$school_name','$school_id','$experience','$designation','$subject','$education',NULL,NULL,$class,'$address','$t_address','$city','$dateformat','$gender','$age' ,'$country', '$email', '$inemail', NOW(),'$state','$phone','$password','$employee','','','','$group_teacher_id','$edu_org_teacher_id','$state_group_teacher_id','$state_group_id','$edu_org_id')";
                            
                     }
                     else{

                 $sqls = "INSERT INTO `tbl_teacher`(t_academic_year,school_type,entity_type_id,reporting_manager_id,t_id,CountryCode,t_name,t_middlename,t_lastname,t_complete_name, t_current_school_name,school_id,t_exprience ,t_designation,t_subject,t_qualification,t_dept,t_DeptID,t_class, t_address,t_temp_address, t_city, t_dob, t_gender,t_age, t_country, t_email,t_internal_email,  t_date,state,t_phone,t_password,t_emp_type_pid,group_member_id,created_by,created_on,group_teacher_id,edu_org_teacher_id,state_group_teacher_id,state_group_id,edu_org_id) 
                                            VALUES ('$academic_year','$school_type','$entity_type_id','$reporting_id','$t_id','$calling_code','$id_first_name','$id_middle_name', '$id_last_name','$name','$school_name','$school_id','$experience','$designation','$subject','$education','$department','$dept_id',$class,'$address','$t_address','$city','$dateformat','$gender','$age' ,'$country', '$email', '$inemail',NOW(),'$state','$phone','$password','$employee','','','','$group_teacher_id','$edu_org_teacher_id','$state_group_teacher_id','$state_group_id','$edu_org_id')";

                     }       
                        $count = mysql_query($sqls) or die(mysql_error());
                        if ($count) {
                            //$successreport = "Teacher Add Successfully";
                            $to = $email;
                            $from = "smartcookiesprogramme@gmail.com";
                            $subject = "Succesful Registration";
                            $message = "Hello " . $id_first_name . " " . $id_last_name . "\r\n\r\n" .
                                "Thanks for registration with Smart Cookie as $dynamic_teacher\r\n" .
                                "your Username is: " . $email . "\n\n" .
                                "your password is: " . $password . "\n\n" .
                                "your School ID is: " . $school_id . "\n\n" .
                                "Regards,\r\n" .
                                "Smart Cookie Admin";

                            mail($to, $subject, $message);

                            //$successreport = "Successfully updated";
                            //header("Location:teacher_setup.php?successreport=" . $successreport);
                            echo ("<script LANGUAGE='JavaScript'>


                                alert('$dynamic_teacher Added Successfully');


                                

                                window.location.href='teacherlist.php';
                            </script>");
                        }
                    } else {

                        $errorreport = "$dynamic_teacher code is already present";

                    }
                } else {

                    $errorreport = "Email ID is already present";
                }
            } else {
                $errorreport = "Please enter data";

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
                form .error {
                    color: #ff0000;
                }
                .other{
                    padding-right:
                }
            </style>
            <script src='js/bootstrap-datepicker.min.js' type='text/javascript'></script>
            <script src="js/city_state.js" type="text/javascript"></script>
            <link href='css/datepicker.min.css' rel='stylesheet' type='text/css'>
            <script>
                
 
                jQuery.validator.addMethod("lettersonly", function(value, element) {
                    return this.optional(element) || /^[a-z]+$/i.test(value);
                }, "Letters only please");
                // validations
                $(function() {
                    $("form[name='registration']").validate({
                        rules: {
                            id_first_name: {
                                required: true,
                                lettersonly: true
                            },
                            
                            id_middle_name: {
                                required: true,
                                lettersonly: true
                            },
                            id_last_name: {
                                required: true,
                                lettersonly: true
                            },
                            
                
                            id_education: {
                                required: true
                            },
                            experience: {
                                required: true,
                                number: true
                            },
                            designation: {
                                required: true,
                                number: true
                            },
                            dob: {
                                required: true
                            },
                            id_email: {
                                required: true,
                                email:true
                            },
                            t_id: {
                                required: true
                            },
                            id_phone: {
                                required: true,
                                phoneUS: true
                            },
                            calling_code: {
                                required: true
                            },
                            department: {
                                required: true
                            },
                            country: {
                                required: true
                            },
                            state: {
                                required: true
                            },
                            city: {
                                required: true
                            },
                        },
                        messages: {
                            id_first_name: {
                                required: "First  name is required",
                                lettersonly: "Only Letters is required"
                            },
                            id_middle_name: {
                                required: "Middle  name is required",
                            },
                            
                            id_last_name: {
                                required: "Last  name is required",
                            },
                            id_education: {
                                required: "Please select Education"
                            },
                            experience: {
                                required: "experience is required",
                                number: "Only Letters is required"
                            },
                            
                            designation: {
                                required: "designation is required",
                                number: "Only Letters is required"
                            },
                            dob: {
                                required: "Please Select DOB"
                            },
                            id_email: {
                                required: "Email is required",
                                email: "please Enter valid email id",
                            },
                            t_id: {
                                required: "<?php echo $dynamic_teacher;?> id is required"
                            },
                            id_phone: {
                                required: "Contact is required",
                                phoneUS: "please Enter valied contact details",
                            },
                             calling_code: {
                                required: "Country Code is required"
                            },
                            department: {
                                required: "department is required"
                            },
                            country: {
                                required: "country is required"
                            },
                            state: {
                                required: "state is required"
                            },
                            city: {
                                required: "city is required"
                            }
                        },
                        // in the "action" attribute of the form when valid
                        submitHandler: function(form) {
                            form.submit();
                        }
                    });
                });
            </script>
       
            <script src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>
            <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
            <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
    <script src="js/jquery-1.11.1.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css">
        <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
        <script type="text/javascript">
            $(function () {

                $("#id_checkin").datepicker({
                     changeYear: true,
                    changeMonth: true 
                });

            });
        </script>
            <script type="text/javascript">

                var reg = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;
                function PhoneValidation(phoneNumber) {
                    var OK = reg.exec(phoneNumber.value);
                    if (!OK)
                        document.getElementById('errorphone').innerHTML = 'Please Enter Valid Phone Number';
                    return false;
                    var phone = document.getElementById("phone").value;
                    if (phone>10 ) {

                        document.getElementById('errorphone').innerHTML = 'Please valid no';

                        return false;
                    }
                    if (phone<10 ) {

                        document.getElementById('errorphone').innerHTML = 'Please valid no';

                        return false;
                    }

                }
                
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
                


            function Myfunction(value, fn) {
                
                
                
                if (value != '') {
                    if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
                        xmlhttp = new XMLHttpRequest();
                    }
                    else {// code for IE6, IE5
                        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    xmlhttp.onreadystatechange = function () {
                        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                            
                            if (fn == 'fun_emp_type') {
                                document.getElementById("reporting_id").innerHTML = xmlhttp.responseText;
                            }
                        }
                    }
                    xmlhttp.open("GET", "get_reporting_manager_list.php?fn=" + fn + "&value=" + value, true);
                    xmlhttp.send();
                }
            }

    function valid() 
    {
        //Changes done by Pranali on 19-06-2018 for bug SMC-3169,SMC-3205
        //Below code updated by Rutuja for SMC-4846 on 22-09-2020
        
                var t_id = document.getElementById("t_id").value;
                var pattern = /^[A-z0-9-]+$/;
                if(t_id.trim() == "" || t_id.trim() == null)
                {
                    alert("Please enter Employee ID");
                    return false;
                }
                else if (!pattern.test(t_id)) {
                   alert("It is not valid Employee ID!");
                    return false;
                }
                else{
                
                }
                
                var id_first_name = document.getElementById("id_first_name").value;

                var id_last_name = document.getElementById("id_last_name").value;
                var id_middle_name = document.getElementById("id_middle_name").value;
                         
                var pattern = /^[a-zA-Z ]+$/;
                if(id_first_name.trim()=="" || id_first_name.trim()==null)
                {
                     alert("Please enter first name!");
                    return false;
                }
                if (pattern.test(id_first_name))
                {

                }
                else
                {
                alert("It is not valid First name!");
                return false;
                }
        
        
                    
                
        
        
            /*  var pattern = /^[a-zA-Z ]+$/;
                if(id_last_name.trim()=="" || id_last_name.trim()==null)
                        {
                             alert("Please enter last name!");
                            return false;
                        }
                    if (pattern.test(id_last_name)) {
                   
                }
                else{
                alert("It is not valid Last name!");
                return false;
                }
                
                var education = document.getElementById("id_education");
                    if (education.value == "-1") {

                        alert("Please select Education");
                        return false;
                    }
                    */
                var employee = document.getElementById("id_employee");
                    if (employee.value == "-1") {

                        alert("Please select Employee Type");
                        return false;
                    }   
                    
                    var department = document.getElementById("dept");
                    if (department.value == "-1") {

                        alert("Please select Department");
                        return false;
                    }
                    
                     var Intruduce_YeqarID = document.getElementById("Intruduce_YeqarID");
                    if (Intruduce_YeqarID.value == "") {

                        alert("Please select <?php echo $dynamic_year; ?>");
                        return false;
                    }   
                    
                  
        /*          var designation = document.getElementById("designation").value;
                    if(designation.trim()=="" || designation.trim()==null)
                {
                     alert("Please enter designation!");
                    return false;
                }
           */        
                var experience = document.getElementById("experience").value;
                var experience_month = document.getElementById("experience_month").value;
                
                
                
                 if(experience < 0 || experience % 1 != 0){//if no is negative or decimal 

                        alert("Please enter valid Experience");
                        return false;

                    }
                    
                    

             
                     
                var pattern = /^[a-zA-Z ]+$/;
                

                   
                    
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


                    
                
            
                    
        
                var id_email = document.getElementById("id_email").value;
                var pattern = /^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,4})$/;
                
                if (id_email=="") {
                     alert("Please enter Email ID");
                     return false;  
                }
                
                if (!pattern.test(id_email)) {
                     alert("It is not valid Email id!");
                     return false;  
                }
                
                
                var calling_code= document.getElementById("calling_code").value;
                if (calling_code=="") {
                     alert("Please select country code");
                     return false;  
                }
                
        
                var phone = document.getElementById("phone").value;
                var pattern = /^[6789]\d{9}$/;
                
                if (!pattern.test(phone)) {
                   alert("Please enter 10 digits number!");
                    return false;
                }
                
                var gender1=document.getElementById("gender1").checked;
            
                var gender2=document.getElementById("gender2").checked;
                
                if(gender1==false && gender2==false)
                {
                    alert("Please select gender");
                    return false;
                }else{
                    
                }
                
        
                   
                // regexp = /^[A-Za-z0-9'\.\-\s\,]*$/;
                // var address = document.getElementById("id_address").value;
                // if (address == null || address == "") {

                //     document.getElementById('erroraddress').innerHTML = 'Please Enter address';

                //     return false;
                // }
                // else if(!regexp.test(address)){
                    
                //     document.getElementById('erroraddress').innerHTML = 'Please Enter address';

                //     return false;
                // }

                    
              

                    var country = document.getElementById("country");

                    if (country.value == "-1") {

                        alert("Please select country");
                        return false;
                    }
                    

                    var state = document.getElementById("state");
                    if (state.value == "") {

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
                    
                
                
                    function process(date) {
                        var parts = date.split("/");
                        return new Date(parts[2], parts[1] - 1, parts[0]);
                    }
    }   
</script>
<script>
 $(document).ready(function() 
 {  
     $("#id_employee").on('change',function(){   
         var id_employee = document.getElementById("id_employee").value;

         $.ajax({
             type:"POST",
             data:{id_employee:id_employee}, 
             url:'fetch_dept.php',
             success:function(data)
             {
                 //alert(data);
                 
                 $('#dept').html(data);
             }
             
             
         });
         
     });
     
 });
</script>   
<style>
.error {color: #FF0000;}
</style>
        </head>
        <body>
        <div class='container'>
            <div class='panel panel-primary dialog-panel' style="background-color:#FFFFFF;background-image=""">
            <div style="color:#063;font-size:15px;font-weight:bold;margin-top:20px;"
                 align="center"> <?php if (isset($_GET['successreport'])) {
                    echo $_GET['successreport'];
                }; ?></div>
            <div style="color:red;font-size:15px;font-weight:bold;margin-top:20px;"
                 align="center"> <?php if (isset($_GET['successreport'])) {
                    echo $_GET['errorreport'];
                }; ?></div>
            <div class='panel-heading'>
                <h3 align="center"><?php echo $dynamic_teacher;?> Registration</h3>
               <!-- <h5 align="center"><a href="Add_teacherSheet_updated_20160103PT.php">Add Excel Sheet</a></h5>-->
              <!--  <h5 align="center"><b style="color:red;">All Field Are mandatory</b></h5>  -->

                <!-- <h5 align="center"><a href="addteacher_excelsheet.php" >Add Excel Sheet</a></h5>-->
            </div>
            <div class='panel-body'>
                <form class='form-horizontal' role='form' name="registration" method="post">
                    
                    <div class='form-group'>
                        <label class='control-label col-md-2 col-md-offset-2' for='id_accomodation' style="text-align:left;">Employee ID <span class="error"><b> *</b></span></label>
                        <div class='col-md-3'>
                            <input type="text" class='form-control' id='t_id' name="t_id" placeholder="Enter Employee ID" maxlength="30">
                        </div>
                        <div class='col-md-3 indent-small' id="errort_id" style="color:#FF0000"></div>
                    </div>
                    
                    
                    <div class='form-group'>

                        <label class='control-label col-md-2 col-md-offset-2' style="padding-right: 81px;" >First Name<span class="error"><b> *</b></span></label>
                        <div class='col-md-6'>
                            <div class='form-group'>
                            
                                <div class='col-md-6'>
                                    <input class='form-control col-md-8' id='id_first_name' name='id_first_name' placeholder='First Name' type='text'>
                                </div>
                               
                            </div>
                        </div>  
                    </div>  
                    
                    
                
                    <div class='form-group'>
                        <label class='control-label col-md-2 col-md-offset-2' style="padding-right: 78px;" >Middle Name</label>
                        <div class='col-md-6'>
                            <div class='form-group'>
                            
                                <div class='col-md-6'>
                                    <input class='form-control col-md-8' id='id_middle_name' name='id_middle_name' placeholder='Middle Name' type='text'>
                                </div>
                               
                            </div>
                        </div>  
                    </div>  
                            
                            
                        <div class='form-group'>
                        <label class='control-label col-md-2 col-md-offset-2' style="padding-right: 94px;" >Last Name<span 
                        class="error"><b> </b></span></label>
                        <div class='col-md-6'>
                            <div class='form-group'>
                            
                                <div class='col-md-6'>
                                    <input class='form-control col-md-8' id='id_last_name' name='id_last_name' placeholder='Last Name' type='text'>
                                </div>
                               
                            </div>
                        </div>  
                    </div>  
                            

                        
                            

                    <div class='form-group'>
                        <div class='row'>
                            <label class='control-label col-md-2 col-md-offset-2' for='id_service' style="text-align:left;padding-left:27px;,padding-right: 92px;">Education</label>
                            <div class='col-md-3' style="padding-left:20px;">
                                <select class='multiselect  form-control' id='id_education' name="id_education" onchange="changeStatus(this.value);">
                                    <option value=''>Select</option>
                                    <option value='BA'>BA</option>
                                    <option value='BCom'>BCom</option>
                                    <option value='BSc'>BSc</option>
                                    <option value='MA'>MA</option>
                                    <option value='MCom'>MCom</option>
                                    <option value='MSc'>MSc</option>
                                    <option value='B.ED'>B.ED</option>
                                    <option value='D.ED'>D.ED</option>
                                    <option value='B.Tech'>B.Tech</option>
                                    <option value='M.Tech'>M.Tech</option>
                                    <option value='Ph.D'>Ph.D</option>
                                    <option value='Architecture'>Architecture</option>
                                    <option value='Other'>Other</option>
                                </select>
                            
                            </div>
                            <div class="col-md-3" >
                                    <input type="text" class="form-control col-md-3" style="display:none;" id="other1"  name="other1" placeholder="Enter your Education"  style="text-align:left;padding-left:27px;,padding-right: 92px;" >
                            </div>
                           
                           
                        </div>
                        <div class='col-md-2 ' id="erroredu" style="color:#FF0000">
                        <div class='col-md-6'>
                         </div>

                        </div>

                    </div>            


                 <div class='form-group'>
                        <div class='row'>
                            <label class='control-label col-md-2 col-md-offset-2' for='id_service' style="text-align:left;padding-left:27px;" >Employee Type<span class="error"><b> *</b></span></label>
                            <div class='col-md-3' style="padding-left:20px;">
                                <select class='multiselect  form-control' id='id_employee' name="id_employee" onChange="Myfunction(this.value,'fun_emp_type')">
                                    <option value='-1'>Select</option>
                                    <option value='134'><?php echo $dynamic_teacher; ?></option>
                                    <option value='135'><?php echo $dynamic_hod; ?></option>
                                    <?php if($school_type == 'school' || $school_type == ''){ ?>
                                    <option value='137'><?php echo $dynamic_principal;?> </option>
                                    <?php } ?>
                                    <?php if ($school_type == 'organization'  && $user=='HR Admin'){?>
                                    
                                    
                                    
                                    <option value='139'>Member Secretary</option>
                                    <option value='141'>Vice Chairman</option>
                                    <option value='143'>Chairman</option>
                                    <?php } ?>

                                </select>
                            </div>
                        </div>
                        <div class='col-md-2 ' id="erroredu" style="color:#FF0000"></div>
                        
                    </div>
                    
                    <div class='form-group'>
                        <label class='control-label col-md-2 col-md-offset-2' for='id_department' style="text-align:left;">Department<span class="error"><b> *</b></span></label>
                        <div class='col-md-3'>
                            <select name='dept' id='dept' class='form-control' required="required">
                           
                    </select>
                        </div>
                        <div class='col-md-3 indent-small' id="errordepartment" style="color:#FF0000"></div>
                    </div>
                    
                    
                    
                    <div class='form-group'>
                        <label class='control-label col-md-2 col-md-offset-2' for='id_department' style="text-align:left;"><?php echo $dynamic_class;?></label>
                        <div class='col-md-3'>
                            <select name='class' id='class' class='form-control' >
                            <option value="0">Select</option>
                        <?php 
                        $arr = mysql_query("select distinct(class) from Class where school_id='$school_id'"); 
                        
                         while ($row = mysql_fetch_array($arr)) { ?>
                        <option><?php echo $row['class'] ?></option><?php } ?>
                    </select>
                        </div>
                        <div class='col-md-3 indent-small' id="errordepartment" style="color:#FF0000"></div>
                    </div>
                    
                     <div class='form-group'>
                        <label class='control-label col-md-2 col-md-offset-2'  style="text-align:left;" >Designation</label>
           
              
                <div class='col-md-3' style="text-align:left;">
                   <select class='form-control' id='designation' name="designation" placeholder='Enter Designation'>
                  <option value=""> Select Designation</option>
                 <?php
                 
                
                 $sql =mysql_query("select * from tbl_teacher_designation where school_id='$school_id'");

                 

                 while($arr = mysql_fetch_array($sql))
                 {
                     ?>
                     <option value="<?php echo $arr['designation'];?>"><?php echo $arr['designation'];?></option>
                     <?php
                 }
                 
                 
                 ?>
                  </select>
                </div>
                <div class='col-md-3 error1' id="errordiv" style="color:#FF0000"></div>
                    </div> 


                    <?php if ($_SESSION['usertype'] == 'HR Admin') {?>


<div class="form-group">

            <label class='control-label col-md-2 col-md-offset-2'  style="text-align:left;" >Reporting Manager<span class="error"></span></label>
           
              
                <div class='col-md-3' style="text-align:left;">
                   <select class='form-control' id="reporting_id" name="reporting_id" placeholder='Enter Reporting Manager'>
                  <option value="-1"> Select Reporting Manager</option>
                <?php 

             $sql_teacher=mysql_query("select t_id,t_complete_name from tbl_teacher where school_id='$sc_id' and t_complete_name!='' and (t_emp_type_pid='133' or t_emp_type_pid='134' or t_emp_type_pid='135' or t_emp_type_pid='137' ) order by t_complete_name");

             while($result_teacher=mysql_fetch_array($sql_teacher))

             {?>

                 <option value="<?php echo $result_teacher['t_id']?>"><?php echo ucwords(strtolower($result_teacher['t_complete_name']))?></option>

                 <?php }

             ?>
                  </select>
                </div>
                <div class='col-md-3 error1' id="errordiv" style="color:#FF0000"></div>
               </div>
                    
                 <?php }

             ?>
              
<!--Academic/Financial Year added by Rutuja on 02/01/2020-->
<div class="form-group">

            <label class='control-label col-md-2 col-md-offset-2'  style="text-align:left;" ><?php echo $dynamic_year; ?><span class="error"><b> *</b></span></label>
           
              
                <div class='col-md-3' style="text-align:left;">
                 <select name="Intruduce_YeqarID" class="form-control " id="Intruduce_YeqarID">
                                <option value="">Select <?php echo $dynamic_year; ?></option>
                        <?php 
                        $sql = "select * from tbl_academic_Year where school_id='$school_id' and Academic_Year != ''";
                        $result = mysql_query($sql);
                        while($row=mysql_fetch_array($result))
                        {
                            $ExtYearID = $row['ExtYearID'];
                            $Year = $row['Year'];
                            $Academic_Year = $row['Academic_Year'];
                            echo "<option value='$ExtYearID,$Year,$Academic_Year'>$Academic_Year</option>";
                        }
                        ?>
                                </select>
                </div>
                <div class='col-md-3 error1' id="errorAY" style="color:#FF0000"></div>
               </div>     
                
                 <div class='form-group'>
                        <label class='control-label col-md-2 col-md-offset-2' style="padding-right: 92px;" >Experience</label>
                        <div class='col-md-6'>
                            <div class='form-group'>
                            
                                <div class='col-md-6'>
                                    <input class='form-control col-md-8' id='experience' name='experience' placeholder='Experience in years' type='text'>
                                    </div>
                                    <div class='col-md-6'>
                                    <select class='multiselect  form-control' id='experience_month' name="experience_month" required>
                                    <option value='0'>Select Month</option>
                                    <option value='0'>0</option>
                                    <option value='1'>1</option>
                                    <option value='2'>2</option>
                                    <option value='3'>3</option>
                                    <option value='4'>4</option>
                                    <option value='5'>5</option>
                                    <option value='6'>6</option>
                                    <option value='7'>7</option>
                                    <option value='8'>8</option>
                                    <option value='9'>9</option>
                                    <option value='10'>10</option>
                                      <option value='11'>11</option>
                                </select>
                                </div>
                                <div class='col-md-3 indent-small'  style="color:#FF0000">
                                </div>
                            </div>
                        </div>  
                    </div>  
                    
                    
                    <div class='form-group'>
                        <label class='control-label col-md-2 col-md-offset-2' for='email' style="text-align:left;">Email<span class="error"><b> *</b></span></label>
                        <div class='col-md-6'>
                            <div class='form-group'>
                            
                                <div class='col-md-6'>
                                    <input class='form-control' id='id_email' name="id_email" placeholder='E-mail' type='email' maxlength="60">
                                </div>
                                <div class='col-md-3 indent-small' id="erroremail" style="color:#FF0000">
                                </div>
                            </div>
                        </div>  
                    </div>  
                    
                    <div class='form-group'>
                        <label class='control-label col-md-2 col-md-offset-2' for='email' style="text-align:left;">Internal Email<span class="error"><b> </b></span></label>
                        <div class='col-md-6'>
                            <div class='form-group'>
                            
                                <div class='col-md-6'>
                                    <input class='form-control' id='in_email' name="in_email" placeholder='Internal E-mail' type='email' maxlength="60">
                                </div>
                                <div class='col-md-3 indent-small' id="errorinemail" style="color:#FF0000">
                                </div>
                            </div>
                        </div>  
                    </div>  
                    
                    
                    
                     <div class='form-group'>
                        <label class='control-label col-md-2 col-md-offset-2'  style="text-align:left;" >Country Code<span class="error"><b> *</b></span></label>
           
              
                <div class='col-md-3' style="text-align:left;">
                   <select class='form-control' id='calling_code' name="calling_code" placeholder='Enter Country Code'>
                  <option value=""> Select Country Code</option>
                 <?php
                 
                
                 $sql =mysql_query("select * from tbl_country where calling_code!=''");

                 

                 while($arr = mysql_fetch_array($sql))
                 {
                     ?>
                     <option value="<?php echo $arr['calling_code'];?>"><?php echo $arr['calling_code'];?></option>
                     <?php
                 }
                 
                 
                 ?>
                  </select>
                </div>
                <div class='col-md-3 error1' id="errordiv" style="color:#FF0000"></div>
                    </div>  
                    
                    <div class='form-group '>
                        <label class='control-label col-md-2 col-md-offset-2' for='Mobile no.' style="text-align:left;">Mobile No.<span class="error"><b> *</b></span></label>
                            <div class='col-md-6'>
                                <div class='form-group'>
                                <div class='col-md-6'>
                                    <input class='form-control' id='phone' name="phone" placeholder='Mobile No'   length="10" type='text' onChange="PhoneValidation(this);">
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    
                    
                    <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2'  style="text-align:left;">Date Of Birth</label>
            <div class='col-md-3' style="text-align:left;">

            <!-- Changes done by Pranali on 28-06-2018 for bug SMC-3200 -->


             <input type="text"  id='id_checkin' name="id_checkin" autocomplete="off" class="form-control">



            <!-- Changes end-->

             </div>
             <div class='col-md-3 error1' id="errordob" style="color:#FF0000"></div>
         </div>


                    <div class='form-group'>
                        <label class='control-label col-md-2 col-md-offset-2' for='id_pets' style="text-align:left;" >Gender<span class="error"><b> *</b></span></label>
                        <div class='col-md-2' style="font-weight: 600;color: #777;">
                            <input type="radio" name="gender" id="gender1" value="Male">Male
                        </div>
                        <div class='col-md-3' style="font-weight: 600;color: #777;">
                            <input type="radio" name="gender" id="gender2" value="Female">Female
                        </div>
                        <div class='col-md-2 indent-small' id="errorgender" style="color:#FF0000">
                        </div>
                    </div>

                    

                    
                    
                    

         <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' style="text-align:left;">Address</label>
            <div class='col-md-3' style="text-align:left;">
              <textarea class='form-control' id='id_address' name="id_address" placeholder='Address' rows='3' style="resize:none;" maxlength="200"></textarea>
            </div>
            <div class='col-md-4 indent-small' id="erroraddress" style="color:#FF0000"></div>
        </div>
        
        <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' style="text-align:left;">Temporary Address<span class="error"><b> </b></span></label>
            <div class='col-md-3' style="text-align:left;">
              <textarea class='form-control' id='t_address' name="t_address" placeholder='Temporary Address' rows='3' style="resize:none;" maxlength="200"></textarea>
            </div>
            <div class='col-md-4 indent-small' id="errortaddress" style="color:#FF0000"></div>
        </div>

                    
                    <div class='form-group'>
                        <label class='control-label col-md-2 col-md-offset-2' style="text-align:left;">Country<span class="error"><b>*</b></span></label>
                        <div class='col-md-3'>
                            <select id="country" name="country" class='form-control'>
                            <option value='-1'>select</option></select>
                        </div>
                        <div class='col-md-3 indent-small' id="errorcountry" style="color:#FF0000">
                        </div>
                    </div>
<!--
                 <div class='form-group'>
                <label class='control-label col-md-2 col-md-offset-2' for='id_accomodation' style="text-align:left;">Department</label>
                <div class='col-md-3'>
                    <select name='id_department' id='id_department' class='form-control'>
                        <?php// $arr = mysql_query("select Dept_Name from tbl_department_master where school_id='$school_id' ORDER BY Dept_Name"); ?>
                        <option><?php// echo $id_department; ?></option>
                        <?php// while ($row = mysql_fetch_array($arr)) { ?>
                        <option><?php //echo $row['Dept_Name'] ?></option><?php// } ?>
                    </select>
                </div>
                <div class='col-md-3 indent-small' id="errordept" style="color:#FF0000"></div>
                </div>  
                        
    -->                 
                        
                    <div class='form-group'>
                        <label class='control-label col-md-2 col-md-offset-2' style="text-align:left;">State<span class="error"><b> *</b></span></label>
                        <div class='col-md-3'>
                            <select name="state" id="state" class='form-control'></select>
                        </div>
                        <div class='col-md-3 indent-small' id="errorstate" style="color:#FF0000"></div>

                    </div>
                    <script language="javascript">
                        populateCountries("country", "state");
                        //populateCountries("country2");
                    </script>
                   <script>
                        //script for education
                        function changeStatus()
                        {
                            var status = document.getElementById("id_education");
                            if(status.value=="Other")
                            {
                                document.getElementById("other1").style.display="block";
                            }
                            else
                            {
                                document.getElementById("other1").style.display="none";

                            }
                        }
                    </script>


                    <div class='form-group'>
                        <label class='control-label col-md-2 col-md-offset-2' for='id_accomodation' style="text-align:left;">City<span class="error"><b> *</b></span></label>
                        <div class='col-md-3'>
                            <input type="text" class='form-control' id='id_city' name="id_city" placeholder="City"  maxlength="30">
                        </div>
                        <div class='col-md-3 indent-small' id="errorcity" style="color:#FF0000"></div>
                    </div>

<!--Added 5 new fields for teacher id and inserted into tbl_teacher by Pranali for SMC-5133 on 2-2-21-->
<?php if($school_type == 'school') { ?>
                    <div class='form-group'>
                        <label class='control-label col-md-2 col-md-offset-2' for='group_teacher_id'
                               style="text-align:left;">Group Teacher ID</label>
                        <div class='col-md-3'>
                            <input type="text" class='form-control' value="<?= $get_row_t['group_teacher_id'] ?>" id='group_teacher_id'
                                   name="group_teacher_id" placeholder="Group Teacher ID">
                        </div>
                        
                    </div>

                    <div class='form-group'>
                        <label class='control-label col-md-2 col-md-offset-2' for='state_group_teacher_id'
                               style="text-align:left;">State Group Teacher ID</label>
                        <div class='col-md-3'>
                            <input type="text" class='form-control' value="<?= $get_row_t['state_group_teacher_id'] ?>" id='state_group_teacher_id'
                                   name="state_group_teacher_id" placeholder="State Group Teacher ID">
                        </div>
                        
                    </div>

                    <div class='form-group'>
                        <label class='control-label col-md-2 col-md-offset-2' for='edu_org_teacher_id'
                               style="text-align:left;">Education Teacher ID</label>
                        <div class='col-md-3'>
                            <input type="text" class='form-control' value="<?= $get_row_t['edu_org_teacher_id'] ?>" id='edu_org_teacher_id'
                                   name="edu_org_teacher_id" placeholder="Education Teacher ID">
                        </div>
                        
                    </div>

                    <div class='form-group'>
                        <label class='control-label col-md-2 col-md-offset-2' for='state_group_id'
                               style="text-align:left;">State Group ID</label>
                        <div class='col-md-3'>
                            <input type="text" class='form-control' value="<?= $get_row_t['state_group_id'] ?>" id='state_group_id'
                                   name="state_group_id" placeholder="State Group ID">
                        </div>
                        
                    </div>

                    <div class='form-group'>
                        <label class='control-label col-md-2 col-md-offset-2' for='edu_org_id'
                               style="text-align:left;">Education Organization ID</label>
                        <div class='col-md-3'>
                            <input type="text" class='form-control' value="<?= $get_row_t['edu_org_id'] ?>" id='edu_org_id'
                                   name="edu_org_id" placeholder="Education Organization ID">
                        </div>
                        
                    </div>
<?php } ?>
                    <div class='form-group row'>
                        <div class='col-md-2 col-md-offset-4'>
                            <input class='btn-lg btn-primary' type='submit' value="Submit" name="submit" onClick="return valid()" style="padding:5px;"/>
                        </div>
                        <div class='col-md-1 '>
                            <a href="teacherlist.php" style="text-decoration:none;">
                                <input class='btn-lg btn-danger' type='button' value="Back" name="back" style="padding:5px;"/>
                            </a>
                        </div>
                </form>
            </div>
       <!--     <div class='row' align="center" style="color:#FF0000"><?php// echo $successreport $errorreport; ?></div>  -->
            <div class="row" align="center" style="padding-top:40px; color:#FF0000; font-weight:bold;"  id="errorreport">
<div style="color:#008000;"><?php echo $successreport;?> </div><div style="color:#FF0000;"><?php echo $errorreport;?></div></div>
            
            
        </div>
        </div>
        
        </body>
        <?php
    }else{

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
            //logic for education
              //echo $edu = $_POST['id_education'];
                //if(isset())
                 $education = $_POST['id_education'];
                 $test = $_POST['other1'];
                
                 if($education != "Other" ){
                    $education = $_POST['id_education'];
                
                }
                else{
                    $education = $test;
                }
              
               

             $t_emp_type_pid = $_POST['t_emp_type_pid'];
            $experience = $_POST['experience'];
            $experience_month = $_POST['experience_month'];
            $exp_mon=$experience . "." . $experience_month;
            $depart = $_POST['dept'];
            $dep = explode (",", $depart); 
             $department = $dep[0];
            $dept_id = $dep[1];
            $designation = $_POST['designation'];
            $r_id = $_POST['reporting_id'];
            $report = explode (",", $r_id); 
            $reporting_id = $report[0];
            $cls = $_POST['class'];
            // Null condition added by Rutuja on 30/12/2019 if $class is empty for SMC-4300
            $class = !empty($cls) ? "'$cls'" : "NULL";
            $Intruduce_YeqarID = $_POST['Intruduce_YeqarID'];
          //  $academicyear = explode (",", $Intruduce_YeqarID); 
           // $a = $academicyear[0];
            //$ac_year = $academicyear[1];
            $academic_year = $_POST['Intruduce_YeqarID'];
         $id_checkin = $_POST['id_checkin'];
            $gen = $_POST['gender'];
            $e_id = $_POST['id_email'];
            $internal_emailid = $_POST['internal_email'];
            $mob = $_POST['id_phone'];
             $CountryCode = $_POST['country_code'];
            $land = $_POST['landline'];
            $address =  mysql_real_escape_string($_POST['address']);
            $t_address =  mysql_real_escape_string($_POST['t_address']);
            $country = $_POST['country'];
            $t_state = $_POST['t_state'];
            $cty = $_POST['city'];
            //$CountryCode = $_POST['CountryCode'];
            $group_teacher_id = $_POST['group_teacher_id'];
            $edu_org_teacher_id = $_POST['edu_org_teacher_id'];
            $state_group_teacher_id = $_POST['state_group_teacher_id'];
            $state_group_id = $_POST['state_group_id'];
            $edu_org_id = $_POST['edu_org_id'];
        $id_date = CURRENT_TIMESTAMP; 
                        


    list($month,$day,$year) = explode("/",$id_checkin);
    
    
    $year_diff  = date("Y") - $year; 
    $month_diff = date("m") - $month; 
    $day_diff   = date("d") - $day; 
        if ($day_diff < 0 || $month_diff < 0) $year_diff--;
    
    $age= $year_diff;
    
    $dateformat=$year. "-" .$month. "-" .$day;
            
        //If department is All then inserted dept_id & department as NULL and fetched department dynamically for SMC-4034 on 29/01/2020 for SMC-4034
    //Added 5 new fields after CountryCode in update queries by Pranali for SMC-5133 on 2-2-21 
           if($department=='All')
            {
                 $sql_update11 = "UPDATE `tbl_teacher` SET t_academic_year='$academic_year',reporting_manager_id='$reporting_id', t_complete_name=' $complete_name',t_name='$fname',t_middlename='$mname',t_lastname='$lname',CountryCode='$CountryCode',t_emp_type_pid='$t_emp_type_pid',t_designation='$designation',t_qualification='$education',t_dob='$dateformat',t_email='$e_id',
            t_exprience='$exp_mon',t_dept=NULL,t_DeptID=NULL,t_class=$class,t_age='$age',t_gender='$gen',t_internal_email='$internal_emailid',t_phone='$mob',t_landline='$land',t_address='$address',t_temp_address='$t_address',t_country='$country',state='$t_state',t_city='$cty',CountryCode='$CountryCode', group_teacher_id='$group_teacher_id', edu_org_teacher_id='$edu_org_teacher_id', state_group_teacher_id='$state_group_teacher_id', state_group_id='$state_group_id', edu_org_id='$edu_org_id'
            WHERE t_id='$t_id' AND school_id='$school_id'";
            }
            else
            {


            $sql_update11 = "UPDATE `tbl_teacher` SET t_academic_year='$academic_year',reporting_manager_id='$reporting_id', t_complete_name=' $complete_name',t_name='$fname',t_middlename='$mname',t_lastname='$lname',CountryCode='$CountryCode',t_emp_type_pid='$t_emp_type_pid',t_designation='$designation',t_qualification='$education',t_dob='$dateformat',t_email='$e_id',
            t_exprience='$exp_mon',t_dept='$department',t_DeptID='$dept_id',t_class=$class,t_age='$age',t_gender='$gen',t_internal_email='$internal_emailid',t_phone='$mob',t_landline='$land',t_address='$address',t_temp_address='$t_address',t_country='$country',state='$t_state',t_city='$cty',CountryCode='$CountryCode', group_teacher_id='$group_teacher_id', edu_org_teacher_id='$edu_org_teacher_id', state_group_teacher_id='$state_group_teacher_id', state_group_id='$state_group_id', edu_org_id='$edu_org_id'
            WHERE t_id='$t_id' AND school_id='$school_id'";
        }
            $retval11 = mysql_query($sql_update11) or die('Could not update data: ' . mysql_error());
            $report = 'Successfully updated';
            //SMC-5133 by Pranali : Added alert message for successful updation of teacher 
            echo "<script type=text/javascript>alert('Teacher details updated successfully'); 
            window.location='teacherlist.php'</script>";
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
        $t_DeptID = $value1['t_DeptID'];
         $class1 = $value1['t_class'];
        $designation1 = $value1['t_designation'];
        $Academic_Year = $value1['t_academic_year'];
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
        $reporting_manager_id = $value1['reporting_manager_id'];
        
        
        $country_code = $value1['CountryCode'];
        $t_id = $value1['t_id'];
    }
} else {
    echo "<script type=text/javascript>alert('Sry... No Teacher ID.Unable to update this record '); //window.location='teacherlist.php'</script>";
}

$arr1 = mysql_query("select t_id,t_complete_name,t_emp_type_pid from tbl_teacher where school_id='$school_id' and t_id='$reporting_manager_id'"); 
  while ($row1 = mysql_fetch_assoc($arr1)) {
    $reporting_manager_t_id=$row1['t_id'];
    $reporting_manager_t_name=$row1['t_complete_name'];


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
     
 });

function Myfunction(value, fn) {
                
                
                
                if (value != '') {
                    if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
                        xmlhttp = new XMLHttpRequest();
                    }
                    else {// code for IE6, IE5
                        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    xmlhttp.onreadystatechange = function () {
                        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                            
                            if (fn == 'fun_emp_type_edit') {
                                document.getElementById("reporting_id").innerHTML = xmlhttp.responseText;
                            }
                        }
                    }
                    xmlhttp.open("GET", "get_reporting_manager_list.php?fn=" + fn + "&value=" + value, true);
                    xmlhttp.send();
                }
            }


 //Validations added by Rutuja Jori on 01/11/2019
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
 /*
            var address = document.getElementById("id_address").value;
           if (address == null || address == "") {

                document.getElementById('erroraddress').innerHTML = 'Please Enter address';

                return false;
            }
            else {
                document.getElementById('erroraddress').innerHTML = '';
            }*/
          
        }
    </script>
    <script>
 $(document).ready(function() 
 {  
     $("#t_emp_type_pid").on('change',function(){   
         var id_employee = document.getElementById("t_emp_type_pid").value;

         $.ajax({
             type:"POST",
             data:{id_employee:id_employee}, 
             url:'fetch_dept.php',
             success:function(data)
             {
                 //alert(data);
                 
                 $('#dept').html(data);
             }
             
             
         });
         
     });
     
 });
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


                <label class='control-label col-md-2 col-md-offset-2' for='id_accomodation' style="text-align:left;">First Name<b style="color:red";> *</b></span></label>


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
                    <select class='multiselect  form-control' id='id_education' name="id_education" onchange="changeStatus(this.value);">
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
                        if ($t_qualification != 'Architecture') {

                            ?>
                            <option value='Architecture'>Architecture</option>
                        <?php }
                        // if ($t_qualification != 'ME') {

                            ?>
                            <option value='Other'>Other</option>
                        <?php //} ?>
                    </select>
                </div>
                <div class='col-md-3' >
                    <input class='form-control' style="display:none;" id='other1' name='other1' type='text'  value=<?php echo $t_qualification; ?>>
                </div>
                 </div>
                 
                 <script>
                        //script for education
                        function changeStatus()
                        {
                            var status = document.getElementById("id_education");
                            if(status.value=="Other")
                            {
                                document.getElementById("other1").style.display="block";
                            }
                            else
                            {
                                document.getElementById("other1").style.display="none";

                            }
                        }
                    </script>

                 
                 
                 
                 
                  <div class='form-group'>
                <label class='control-label col-md-2 col-md-offset-2' for='id_accomodation' style="text-align:left;">Employee Type<b style="color:red";> *</b></span></label>
                <div class='col-md-3'>
                    <select name='t_emp_type_pid' id='t_emp_type_pid' class='form-control' onChange="Myfunction(this.value,'fun_emp_type_edit')">
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
                              if($t_emp_type=='139')
                            {
                                $t_emp="Member Secretary";
                            
                            }
                            if($t_emp_type=='141')
                            {
                                $t_emp="Vice Chairman";
                            
                            }
                            if($t_emp_type=='143')
                            {
                                $t_emp="Chairman";
                            
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
                        
                         if (($school_type == 'school' || $school_type == '') && $t_emp != $dynamic_principal)  {
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
                         
                    <?php    if ($t_emp != $nonTeacherStaff)  {
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
                    <select name='dept' id='dept' class='form-control' required="required">
                    <!--SMC-4575 Updated for showing Department list by default on 03/03/2020 by Rutuja & for solving the issue of Department getting blank after we update Department-->
                                       
                        <?php
                        echo $dept;
                        if ($dept != '') {
                            ?>
                            <option value='<?php echo $dept ?>,<?php echo $t_DeptID; ?>'
                                    selected><?php echo $dept; ?></option>
                            <?php
                        }

                        else if ($dept ==NULL) {
                            ?>
                            <option value='All,0'
                                    selected><?php echo "All"; ?></option>
                            <?php
                        }

                         else { ?>
                            <option value=''>Select Department</option>
                        <?php } ?>

                     
                        <?php $arr = mysql_query("select * from tbl_department_master where school_id='$school_id' and Is_Enabled='1'"); 
                         while ($row = mysql_fetch_array($arr)) { 
                         $Dept_Name=$row['Dept_Name'];
                         $ExtDeptId=$row['ExtDeptId'];
                         
                        ?>
                        <?php if ($dept != $Dept_Name) { ?>
                            <option value="<?php echo $Dept_Name;?>,<?php echo $ExtDeptId; ?>"><?php echo $Dept_Name;?></option>
                         <?php }
                            
                         }?>



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
                 


<div class="form-group">

            <label class='control-label col-md-2 col-md-offset-2'  style="text-align:left;" >Reporting Manager<span class="error"></span></label>
           
              
                <div class='col-md-3' style="text-align:left;">
                   <select class='form-control' id='reporting_id' name="reporting_id" placeholder='Enter Reporting Manager'>
                  <option value="-1"> Select Reporting Manager</option>
                 <?php
                 
                 
                  echo $reporting_manager_id;
                        if ($reporting_manager_id != '') {
                            ?>
                            <option value='<?php echo $reporting_manager_id ?>'
                                    selected><?php echo $reporting_manager_t_name; ?></option>
                            <?php
                        } else { ?>
                            <option value='-1'>Select Reporting Manager</option>
                        <?php } ?>
              
                  </select>
                </div>
                <div class='col-md-3 error1' id="errordiv" style="color:#FF0000"></div>
               </div>

                <div class='form-group'>
                <label class='control-label col-md-2 col-md-offset-2' for='id_accomodation' style="text-align:left;"><?php echo $dynamic_year; ?><b style="color:red";>* </b></span></label>
                <div class='col-md-3'>
                   
<!--Updated for solving the issue of Year getting blanked after updating for SMC-4575 on 03/03/2020 by Rutuja -->
                    <select name='Intruduce_YeqarID' id='Intruduce_YeqarID' class='form-control'>
                        <?php
                        echo $Academic_Year;
                        if ($Academic_Year != '') {
                            ?>
                            <option value='<?php echo $Academic_Year ?>'
                                    selected><?php echo $Academic_Year; ?></option>
                            <?php
                        } else { ?>
                            <option value=''>Select <?php echo $dynamic_year; ?></option>
                        <?php } ?>
                        <?php $arr = mysql_query("select * from tbl_academic_Year where school_id='$school_id' and Academic_Year != ''"); 
                         while ($row = mysql_fetch_array($arr)) { 
                          //$ExtYearID = $row['ExtYearID'];
                        //$Year = $row['Year'];
                        $A_Year = $row['Academic_Year'];
                        ?>
                        <?php if ($Academic_Year != $A_Year) { ?>
                            <option value="<?php echo $A_Year;?>"><?php echo $A_Year;?></option>
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
            <input type="text"  id='id_checkin' name="id_checkin" value="<?php echo $dob; ?>" autocomplete="off" class='form-control'>
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

            <!--Added 5 new fields for teacher id and inserted into tbl_teacher by Pranali for SMC-5133 on 2-2-21-->
            <?php if($school_type == 'school') { ?>
                    <div class='form-group'>
                        <label class='control-label col-md-2 col-md-offset-2' for='group_teacher_id'
                               style="text-align:left;">Group Teacher ID</label>
                        <div class='col-md-3'>
                            <input type="text" class='form-control' value="<?= $value1['group_teacher_id'] ?>" id='group_teacher_id'
                                   name="group_teacher_id" placeholder="Group Teacher ID">
                        </div>
                        
                    </div>

                    <div class='form-group'>
                        <label class='control-label col-md-2 col-md-offset-2' for='state_group_teacher_id'
                               style="text-align:left;">State Group Teacher ID</label>
                        <div class='col-md-3'>
                            <input type="text" class='form-control' value="<?= $value1['state_group_teacher_id'] ?>" id='state_group_teacher_id'
                                   name="state_group_teacher_id" placeholder="State Group Teacher ID">
                        </div>
                        
                    </div>

                    <div class='form-group'>
                        <label class='control-label col-md-2 col-md-offset-2' for='edu_org_teacher_id'
                               style="text-align:left;">Education Teacher ID</label>
                        <div class='col-md-3'>
                            <input type="text" class='form-control' value="<?= $value1['edu_org_teacher_id'] ?>" id='edu_org_teacher_id'
                                   name="edu_org_teacher_id" placeholder="Education Teacher ID">
                        </div>
                        
                    </div>

                    <div class='form-group'>
                        <label class='control-label col-md-2 col-md-offset-2' for='state_group_id'
                               style="text-align:left;">State Group ID</label>
                        <div class='col-md-3'>
                            <input type="text" class='form-control' value="<?= $value1['state_group_id'] ?>" id='state_group_id'
                                   name="state_group_id" placeholder="State Group ID">
                        </div>
                        
                    </div>

                    <div class='form-group'>
                        <label class='control-label col-md-2 col-md-offset-2' for='edu_org_id'
                               style="text-align:left;">Education Organization ID</label>
                        <div class='col-md-3'>
                            <input type="text" class='form-control' value="<?= $value1['edu_org_id'] ?>" id='edu_org_id'
                                   name="edu_org_id" placeholder="Education Organization ID">
                        </div>
                        
                    </div>
        <?php } ?>

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



        
   



<?php } }
?>