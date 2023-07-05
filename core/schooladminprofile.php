<?php
include("scadmin_header.php");
error_reporting(0);
$report = "";
/*Updated by Rutuja Jori for adding dynamic queries & variables to display & update details for HR Admin, HR Admin Staff, School Admin & School Admin for SMC-4951 on 14-11-2020 */
if($_SESSION['entity']==1 or $_SESSION['entity']==24){
    $table= "tbl_school_admin";
}
else{
    $table= "tbl_school_adminstaff";   
}
$query = mysql_query("select * from $table where id = " . $_SESSION['id']);
$value = mysql_fetch_array($query);

if($_SESSION['entity']==1  or $_SESSION['entity']==24){
    $school_admin_name=$value['name'];
    $aicte_id=$value['aicte_permanent_id'];
    $school_aicte_application_id=$value['aicte_application_id'];
    $scadmin_gender=$value['scadmin_gender'];
    $school_admin_education=$value['education'];
    $scadmin_dob=$value['scadmin_dob'];
    $admin_school_pattern=$value['school_pattern'];
    $admin_address=$value['address'];
    $admin_mobile=$value['mobile'];
    $admin_city=$value['scadmin_city'];
    $admin_country=$value['scadmin_country'];
    $admin_state=$value['scadmin_state'];
    $admin_password=$value['password'];
    $coordinator_id=$value['coordinator_id'];

}
else{
    $school_admin_name=$value['stf_name'];
    $scadmin_gender=$value['gender'];
    $school_admin_education=$value['qualification'];
    $scadmin_dob=$value['dob'];
    $admin_address=$value['addd'];
    $admin_mobile=$value['phone'];
    $admin_city=$value['city'];
    $admin_country=$value['country'];
    $admin_state=$value['statue'];
    $admin_password=$value['pass'];
  
}
$school_id = $value['school_id'];
$id = $_SESSION['id'];
if (isset($_POST['saveimg']))
    {
        $path = "scadmin_image/";
        $allowedTypes = array("jpg","jpeg","png","gif");
        //echo$_FILES['profileimg']['tmp_name'];
        $extension = end(explode(".", $_FILES["profileimg"]["name"]));
        $size = $_FILES['profileimg']['size'];
        
        $error = !in_array($extension, $allowedTypes);
        $flag = 1;
        if($_FILES['profileimg']['name'] == "")
        {
            echo "<script>alert('Please select an image to upload.');</script>";
            $flag = 0;
        }
        else if($error)
        {
            echo "<script>alert('Image format is invalid, please upload correct format.');</script>";
            $flag = 0;
        }
        else if($size > 1048576)
        {
            echo "<script>alert('Image size should be of less than 1 MB');</script>";
            $flag = 0;
        }

        $actual_image_name = time().$id.".".$extension;
        $tmp = $_FILES['profileimg']['tmp_name'];
        if($flag !=0)
        {
            move_uploaded_file($tmp, $path.$actual_image_name);
            $imgpath = $path.$actual_image_name;
            mysql_query("UPDATE $table SET img_path='$imgpath' WHERE id='$id'");
            echo "<script>alert('Profile image updated succesfully.');window.location = 'schooladminprofile.php';</script>";
        }
        
    }   
if (isset($_POST['submit'])) {
    //print_r($_REQUEST); exit;
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $education = $_POST['education'];
    $id_checkin = $_POST['id_checkin'];
    $school_name = $_POST['school_name'];
    $school_pattern=$_POST['school_pattern'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $mobile = $_POST['mobile'];
    //$ContryCode = $_POST['mobile'];
    $Country=$_POST['Country_code'];
    $aicte_permanent_id=$_POST['aicte_permanent_id'];
    $aicte_application_id=$_POST['aicte_application_id'];
    $coordinator_id=$_POST['school_coordinator'];
    //Country,state,city drop downs & validations for the same added by Rutuja Jori on 14/11/2019 for bug SMC-4190
   // exit;
     $Country_id=$_POST['id_country'];
      $state=$_POST['state'];
       $city=$_POST['city'];

    list($month, $day, $year) = explode("/", $id_checkin);
    $year_diff = date("Y") - $year;
    $month_diff = date("m") - $month;
    $day_diff = date("d") - $day;
    if ($day_diff < 0 || $month_diff < 0) $year_diff--;
    $age = $year_diff;

      if ($_SESSION['entity']==1 or $_SESSION['entity']==24){ 
    $prepAddr = str_replace(' ', '+', $address);
    $geocode = file_get_contents('http://maps.google.com/maps/api/geocode/json?address=' . $prepAddr . '&sensor=false');
    $output = json_decode($geocode);
    $lat = $output->results[0]->geometry->location->lat;
    $long = $output->results[0]->geometry->location->lng;
    $query = mysql_query("update tbl_school set school_address='$address',school_latitude='$lat', school_longitude='$long' where id='$school_id'");
    $sql = mysql_query("update tbl_school_admin set scadmin_city='$city', scadmin_country='$Country_id',scadmin_state='$state',school_name='$school_name',school_pattern='$school_pattern',name='$name',scadmin_gender='$gender',education='$education',scadmin_dob='$id_checkin',address='$address',email='$email',mobile='$mobile',scadmin_age='$age',CountryCode='$Country',aicte_application_id='$aicte_application_id',aicte_permanent_id='$aicte_permanent_id',coordinator_id='$coordinator_id' where id = " . $_SESSION['id']);
   
    }
    else{

        $sql = mysql_query("update tbl_school_adminstaff set city='$city', country='$Country_id',statue='$state',school_name='$school_name',stf_name='$name',gender='$gender',qualification='$education',dob='$id_checkin',addd='$address',email='$email',phone='$mobile',age='$age',CountryCode='$Country' where id = '$id'");

    }
    if (mysql_affected_rows() > 0) {
        //$successreport = "Profile is successfully updated";
        echo "<script>alert('Profile is successfully updated');window.location = 'schooladminprofile.php';</script>";
    }
}
?>

<html>
<head>
    <link href='css/datepicker.min.css' rel='stylesheet' type='text/css'>
    
    <script src='js/bootstrap-datepicker.min.js' type='text/javascript'></script>
    <script src='js/bootstrap-switch.min.js' type='text/javascript'></script>
    <script src='js/bootstrap-multiselect.js' type='text/javascript'></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">
<!-- Added 'https' for solving 'blocked:mixed content' error on 15/11/2019 //Rutuja Jori-->
<script type="text/javascript" src="https://ajax.googleapis.com/
ajax/libs/jquery/1.5/jquery.min.js"></script><!--end-->
    <script src="//code.jquery.com/ui/1.11.3/jquery-ui.js"></script>
    <script src="js/city_state.js" type="text/javascript"></script>

    <script type="text/javascript">
    
        $(function () {
            $("#id_checkin").datepicker({
                dateFormat: 'yy-mm-dd',
                maxDate: 0,
                changeMonth: true,
                changeYear: true
            });
        });
    </script>
    <script>
        $(function () {
        });
    </script>
    <script type="text/javascript" src="js/jquery.form.js"></script>
    <script type="text/javascript">// < ![CDATA[
        $(document).ready(function () {
            $('#photoimg').live('change', function () {
                $("#preview").html('');
                $("#preview").html('<img src="http://test.easyman.in/images/loader_blue.gif" alt="Uploading...."/>');
                $("#imageform").ajaxForm(
                    {
                        target: '#preview'
                    }).submit();
                location.reload();
            });

            $("#resetimage").click(function () {
                $("#imageform").ajaxForm(
                    {
                        target: '#preview'
                    }).submit();
                $('#logo').attr('src', 'images/avatar_2x.png');
                $('#logo input').val("images/avatar_2x.png");
                location.reload();
            });
            
        /*  
            
        var str = $("#aicte_permanent_id").val();
        if(str !="")
        {
        
        document.getElementById("aicte_permanent_id").disabled = true;
        }
        else{
        
        document.getElementById("aicte_permanent_id").disabled = false;
        
        }
        */  
            
            
            
        });

        function valid() {
            var name = document.getElementById("name").value;
            if (name.trim() == "" || name.trim() == null) {
                document.getElementById("errorname").innerHTML = "Please enter name";
                return false;
            }
            regx1 = /^[A-z ]+$/;
            //validation for name
            if (!regx1.test(name) || !regx1.test(name)) {
                document.getElementById('errorname').innerHTML = 'Please Enter valid Name';
                return false;
            }
       /*     var gender1 = document.getElementById("gender1").checked;
            var gender2 = document.getElementById("gender2").checked;
            if (gender1 == false && gender2 == false) {
                document.getElementById('errorgender').innerHTML = 'Please Select gender';
                return false;
            }
        */  
            var education = document.getElementById("education").value;

            if (education == "Select") {
                document.getElementById("erroreducation").innerHTML = "Please enter Education";
                return false;
            }
            var id_checkin = document.getElementById("id_checkin").value;
            if (id_checkin.trim() == "" || id_checkin.trim() == null) {
                document.getElementById("errordate").innerHTML = "Please enter Date";
                return false;
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
//
            var school_name = document.getElementById("school_name").value;
            if (school_name.trim() == "" || school_name.trim() == null) {
                document.getElementById("errorschool_name").innerHTML = "Please enter school name";
                return false;
            }
            regx1 = /^[A-Za-z.,() ]+$/;
            //validation for name
            if (!regx1.test(school_name) || !regx1.test(school_name)) {
                document.getElementById('errorschool_name').innerHTML = 'Please Enter valid school name';
                return false;
            }
            else
            {
            document.getElementById('errorschool_name').innerHTML = ''; 
            }
            regx1 = /^[A-Za-z1-9.,() ]+$/;
        /*    var address = document.getElementById("address").value;
            if (address.trim() == "" || address.trim() == null) {
                document.getElementById("erroraddress").innerHTML = "Please enter Address";
                return false;
            }
            if (!regx1.test(address) || !regx1.test(address)) {
                document.getElementById('erroraddress').innerHTML = 'Please Enter valid Address';
                return false;
            }
            else
            {
            document.getElementById('erroraddress').innerHTML = ''; 
            }
            */
            var email = document.getElementById("email").value;
            if (email == null || email == "") {

                document.getElementById('erroremail').innerHTML = 'Please Enter email ID';

                return false;
            }
            
            else{
                document.getElementById("erroremail").innerHTML = "";
            }

            var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
            if (!email.match(mailformat)) {
                document.getElementById('erroremail').innerHTML = 'Please Enter valid email ID';
                return false;
            }Country
            var Country = document.getElementById("Country_code").value;
            if (Country == "" || Country == null || Country=="Select") {

                document.getElementById("errorcountry").innerHTML = "Please select country code";
                document.getElementById("Country").focus();
                return false;
            }
            else{
                document.getElementById("errorcountry").innerHTML = "";
            }
            
            var id_country=document.getElementById("country").value;
            
                    if(id_country=='-1')
                    {
                         document.getElementById("errorstate").innerHTML = "Please select country";
                        return false;
                    }
                    
                    else{
                document.getElementById("errorstate").innerHTML = "";
            }
                    
                    var state=document.getElementById("state").value;
            
                    if(state=='' || state=='Select State')
                    {
                         document.getElementById("errorst").innerHTML = "Please select state";
                        return false;
                    }
                    else{
                document.getElementById("errorst").innerHTML = "";
            }
            
            var city=document.getElementById("id_accomodation").value;
            
                    if(city=='')
                    {
                         document.getElementById("errorcity").innerHTML = "Please enter city";
                        return false;
                    }
                    else{
                document.getElementById("errorcity").innerHTML = "";
            }
            
            var mobile = document.getElementById("mobile").value;

            if (mobile == "" || mobile == null) {

                document.getElementById("errormobile").innerHTML = "Please enter mobile no.";
                return false;
            }
            var phoneno = /^[6789]\d{9}$/;
            if (!mobile.match(phoneno)) {
                document.getElementById("errormobile").innerHTML = "Please enter valid mobile no.";
                return false;
            }
            else{
                document.getElementById("errormobile").innerHTML = "";
            }
        }
    </script>
    <style>
        .h {
            border: 2px solid #a1a1a1;
            background: #dddddd;
            width: 300px;
            border-radius: 25px;
        }

        .box2 {
            margin: 20px auto;
            width: 600px;
            min-height: 150px;
            padding: 10px;
            position: relative;
            background: -webkit-gradient(linear, 0% 20%, 0% 92%, from(#f3f3f3), to(#fff), color-stop(.1, #f3f3f3));
            border-top: 1px solid #ccc;
            border-left: 1px solid #ccc;
            border-right: 1px solid #ccc;
            -webkit-border-bottom-right-radius: 60px 60px;
            -webkit-box-shadow: -1px 2px 2px rgba(0, 0, 0, 0.2);

        }

        .box2:before {
            content: '';
            width: 25px;
            height: 20px;
            position: absolute;
            bottom: 0;
            right: 0;
            -webkit-border-bottom-right-radius: 30px;
            -webkit-box-shadow: -2px -2px 5px rgba(0, 0, 0, 0.3);
            -webkit-transform: rotate(-20deg) skew(-40deg, -3deg) translate(-13px, -13px);
        }
        .box2:after {
            content: '';
            z-index: -1;
            position: absolute;
            bottom: 0;
            right: 0;
            background: rgba(0, 0, 0, 0.2);
            display: inline-block;
            -webkit-box-shadow: 20px 20px 8px rgba(0, 0, 0, 0.2);
            -webkit-transform: rotate(0deg) translate(-45px, -20px) skew(20deg);
        }
        .box2 img {
            width: 100%;

        }
        .preview {
            border-radius: 50% 50% 50% 50%;
            height: 100px;
            box-shadow: 0 3px 2px rgba(0, 0, 0, 0.3);
            -webkit-border-radius: 99em;
            -moz-border-radius: 99em;
            border-radius: 99em;
            border: 5px solid #eee;
            width: 100px;
        }
        textarea {
            resize: none;
        }
    </style>
</head>
<body>
<div class="container" style="padding-top:20px;">
    
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-2">
            <div id="preview">
                <?php
                if ($value['img_path'] == "") {
                    ?>
                    <img src="images/avatar_2x.png" class='preview'/><?php } else {
                    ?>
                    <img src="<?php echo $value['img_path']; ?>" class='preview' id="logo"
                         style="height:100px;width:100px;"/>
                <?php } ?>
            </div>
            <div class="col-md-1" style="padding-top:10px;">
               <form id="form1" runat="server" method="POST" enctype="multipart/form-data">
        <input type='file' name="profileimg" id="profileimg" onchange="readURL(this);" />
        <input type='submit' name="saveimg" value="Save"/>
        <!-- <img class='preview' id="logo" src="#" alt="your image" style="height:100px;width:100px;"/> -->
    </form>
            </div>
        </div>
        <div class="col-md-4">
            <div class="h" align="center"><h3>Edit Profile</h3></div>
        </div>
     <!--   <div class="col-md-4"><img src="image/edit-icon.png" style="height:50px;"></div>  -->
    </div>
<script type="text/javascript">
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#logo').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
    <form method="post">
        <div class="row">
            <div class="col-md-5" align="center"></div>
            <div style="color:#FF0000;"><?php echo $report; ?></div>
            <div style="color:#090;"><?php echo $successreport; ?></div>
        </div>
        <div class="row">
            <div class="box2" id="box2">
                <p style="text-align: center;">All Fields are mandatory <span style="color:red;font-size: 25px;">*</span></p>
                <div class="row">
                    <div class="col-md-5" style="font-size:18px; padding-left:15px;">Name<span style="color:red;font-size: 25px;">*</span></div>
                    <div class="col-md-6"><input type="text" name="name" id="name" class="form-control" value="<?php echo $school_admin_name; ?>" required></div>
                </div>
                <div class="col-md-5"></div>
                <div class="col-md-5" id='errorname' style="color:#FF0000;"></div>
                    
                     <?php if ($_SESSION['entity']==1 or $_SESSION['entity']==24){ ?>
                     <div class="row" style="padding-top:25px;">
                    <div class="col-md-5" style="font-size:18px;">Group ID</div>
                    <div class="col-md-6"><input type="text" required name="group_id" id="group_id" class="form-control"
                                                 value="<?php echo $res['group_mnemonic_name']; ?>" disabled ></div>
                </div>
                <?php } ?>
                
                <div class="row" style="padding-top:25px;">
                    <div class="col-md-5" style="font-size:18px;"><?php echo $organization;?> ID</div>
                    <div class="col-md-6"><input type="text" required name="school_id" id="school_id" class="form-control"
                                                 value="<?php echo $school_id; ?>" disabled ></div>
                </div>
                <!--AICTE Permanent ID disabled by Rutuja for SMC-5101 on 13-01-2021-->
                 <?php if ($_SESSION['entity']==1 or $_SESSION['entity']==24){ ?>
                <div class="row" style="padding-top:25px;">
                    <div class="col-md-5" style="font-size:18px;">AICTE Permanent ID</div>
                    <div class="col-md-6"><input type="text"  name="aicte_permanent_id" id="aicte_permanent_id" class="form-control"
                                                 value="<?php echo $aicte_id;?>" >
                                             
                                                 </div>
                </div>
                <div class="row" style="padding-top:25px;">
                    <div class="col-md-5" style="font-size:18px;">AICTE Application ID</div>
                    <div class="col-md-6"><input type="text"  name="aicte_application_id" id="aicte_application_id" class="form-control"
                                                 value="<?php echo $school_aicte_application_id;?>">
                                                 
                                                 
                                                 </div>
                </div>
                <?php } ?>
                <div class="row" style="padding-top:20px;">
                    <div class="col-md-5" style="font-size:18px;">Gender</div>
                    <div class="col-md-2">
                        <?php
                        if ($scadmin_gender == ""){
                        ?>
                        <input type="radio" name="gender" id="gender1" value="Male"> Male
                    </div>
                    <div class="col-md-2"><input type="radio" name="gender" id="gender2" value="Female">
                        Female
                    </div>
                    <?php }else {
                    if ($scadmin_gender == "Male"){
                    ?>
                    <input type="radio" name="gender" id="gender1" value="Male" checked> Male
                </div>
                <?php }else{
                ?>
                <input type="radio" name="gender" id="gender1" value="Male"> Male
            </div>
            <div class="col-md-2">
                <?php }if ($scadmin_gender == "Female"){ ?>
                <input type="radio" name="gender" id="gender2" value="Female" checked>Female
            </div>
            <?php } else { ?>
                <input type="radio" name="gender" id="gender2" value="Female">
                Female
            <?php }
            } ?>

        </div>
        <div class="col-md-5"></div>
        <div class="col-md-5" id='errorgender' style="color:#FF0000;"></div>

        <div class="row" style="padding-top:20px;">
            <div class="col-md-5" style="font-size:18px;">Education<span style="color:red;font-size: 25px;">*</span></div>
            <div class="col-md-6">
                <?php if ($school_admin_education != "") { ?>
                    <select class="form-control" name="education" id="education">
                        <?php if ($school_admin_education == "B.Ed") { ?>
                            <option value="B.Ed" selected>B.Ed</option>
                        <?php } else { ?>
                            <option value="B.Ed">B.Ed</option>
                        <?php }
                        if ($school_admin_education == "M.Ed") { ?>
                            <option value="M.Ed" selected>M.Ed</option>
                        <?php } else { ?>
                            <option value="M.Ed">M.Ed</option>
                        <?php }
                        if ($school_admin_education== "Ph.D") { ?>

                            <option value="Ph.D" selected>Ph.D</option>
                        <?php } else { ?>
                            <option value="Ph.D">Ph.D</option>
                        <?php }
                        if ($school_admin_education == "B.Sc") { ?>
                            <option value="B.Sc" selected>B.Sc</option>

                        <?php } else { ?>
                            <option value="B.Sc">B.Sc</option>
                        <?php } ?>

                        <?php if ($school_admin_education == "BTech") { ?>
                            <option value="BTech" selected>BTech</option>
                        <?php } else { ?>
                            <option value="BTech">BTech</option>
                        <?php } ?>

                        <?php if ($school_admin_education == "MTech") { ?>
                            <option value="MTech" selected>MTech</option>
                        <?php } else { ?>
                            <option value="MTech">MTech</option>
                        <?php } ?>

                        <?php if ($school_admin_education == "B.A") { ?>
                            <option value="B.A" selected>B.A</option>
                        <?php } else { ?>
                            <option value="B.A">B.A</option>
                        <?php } ?>

                        <?php if ($school_admin_education == "M.A") { ?>
                            <option value="M.A" selected>M.A</option>
                        <?php } else { ?>
                            <option value="M.A">M.A</option>
                        <?php } ?>

                        <?php if ($school_admin_education == "B.B.A") { ?>
                            <option value="B.B.A" selected>B.B.A</option>
                        <?php } else { ?>
                            <option value="B.B.A">B.B.A</option>
                        <?php } ?>

                        <?php if ($school_admin_education == "M.S") { ?>
                            <option value="M.S" selected>M.S</option>
                        <?php } else { ?>
                            <option value="M.S">M.S</option>
                        <?php } ?>

                        <?php if ($school_admin_education == "M.B.A") { ?>
                            <option value="M.B.A" selected>M.B.A</option>
                        <?php } else { ?>
                            <option value="M.B.A">M.B.A</option>
                        <?php } ?>

                        <?php if ($school_admin_education == "B.COM") { ?>
                            <option value="B.COM" selected>B.COM</option>
                        <?php } else { ?>
                            <option value="B.COM">B.COM</option>
                        <?php } ?>

                        <?php if ($school_admin_education == "ME") { ?>
                            <option value="ME" selected>ME</option>
                        <?php } else { ?>
                            <option value="ME">ME</option>
                        <?php } ?>

                        <?php if ($school_admin_education == "BE") { ?>
                            <option value="BE" selected>BE</option>
                        <?php } else { ?>
                            <option value="BE">BE</option>
                        <?php } ?>
                        <?php if ($school_admin_education == "Other") { ?>
                            <option value="Other" selected>Other</option>
                        <?php } else { ?>
                            <option value="Other">Other</option>
                        <?php } ?>
                        <!-- ---------  select start----------- -->
                    </select>
                <?php } else { ?>
                    <select class="form-control" name="education" id="education">
                        <option value="Select">Select</option>
                        <option value="B.Ed">B.Ed</option>
                        <option value="M.Ed">M.Ed</option>
                        <option value="Ph.D">Ph.D</option>
                        <option value="B.Sc">B.Sc</option>
                        <option value="BTech">BTech</option>
                        <option value="B.Sc">MTech</option>
                        <option value="B.Sc">B.A</option>
                        <option value="B.Sc">M.A</option>
                        <option value="B.Sc">B.B.A</option>
                        <option value="B.Sc">M.S</option>
                        <option value="B.Sc">M.B.A</option>
                        <option value="B.Sc">B.COM</option>
                        <option value="B.Sc">ME</option>
                        <option value="B.Sc">BE</option>
                        <option value="Other">Other</option>
                    </select>
                <?php } ?>
            </div>
        </div>
        <div class="col-md-5"></div>
        <div class="col-md-5" id='erroreducation' style="color:#FF0000;"></div>

        <div class="row" style="padding-top:25px;">
            <div class="col-md-5" style="font-size:18px;">Date of Birth</div>
            <div class="col-md-6"><input class='form-control datepicker' id='id_checkin' name="id_checkin" value="<?php echo $scadmin_dob ?>" readonly = "readonly"></div>
        </div>

        <div class="col-md-5"></div>
        <div class="col-md-5" id='errordate' style="color:#FF0000;"></div>

        <div class="row" style="padding-top:25px;">
            <div class="col-md-5" style="font-size:18px;"><?php echo $organization;?> Name<span style="color:red;font-size: 25px;">*</span></div>
            <div class="col-md-6"><input type="text" required name="school_name" id="school_name" class="form-control" value="<?php echo $value['school_name']; ?>"></div>
        </div>

        <div class="row" style="padding-top:25px;">
            <div class="col-md-5" style="font-size:18px;">College Coordinator<span style="color:red;font-size: 25px;">*</span></div>
            <?php $a=mysql_query("SELECT * from tbl_teacher where school_id='$school_id' order by t_id ASC");
            //$b=mysql_fetch_array($a);
           
            ?>
            <div class="col-md-6">
                <div class="form-group">
              <select class="form-control searchselect" name="school_coordinator" id="">
              
                    <option value="">Select Coordinator Name(Id)</option>
                    <?php while($b=mysql_fetch_array($a)){?>
                    <option value="<?php echo $b['t_id']; ?>" <?php if($coordinator_id == $b['t_id']){?> selected="selected" <?php }?>><?php echo $b['t_complete_name'].'('.$b['t_id'].')'; ?></option>
                      <?php } ?>
             </select>
               </div>
                </div>
        </div>

        <?php if ($_SESSION['entity']==1 or $_SESSION['entity']==24){ ?>
            <!-- yogesh -->
            <div class="row" style="padding-top:20px;">
            <div class="col-md-5" style="font-size:18px;">School Pattern<span style="color:red;font-size: 25px;"></span></div>
            <div class="col-md-6">
                <?php if ($value['school_pattern'] != "") { ?>
                    <select class="form-control" name="school_pattern" id="school_pattern">
                        <?php if ($value['school_pattern'] == "Annual") { ?>
                            <option value="Annual" selected>Annual</option>
                        <?php } else { ?>
                            <option value="Annual">Annual</option>
                        <?php }
                        if ($value['school_pattern'] == "Semester") { ?>
                            <option value="Semester" selected>Semester</option>
                        <?php } else { ?>
                            <option value="Semester">Semester</option>
                        <?php } ?>
                        
                        <!-- ---------  select start----------- -->
                    </select>
                <?php } else { ?>
                    <select class="form-control" name="school_pattern" id="school_pattern">
                        <option value="Select">Select</option>
                        <option value="Annual">Annual</option>
                        <option value="Semester">Semester</option>
                        
                    </select>
                <?php } ?>
            </div>
        </div>
    
<!--End -->
<?php } ?>
        <div class="col-md-5"></div>
                <div class="col-md-5" id='errorschool_name' style="color:#FF0000;"></div>

        <div class="row" style="padding-top:25px;">
            <div class="col-md-5" style="font-size:18px;"><?php echo $organization;?> Address</div>
            <div class="col-md-6"><textarea required class='form-control' id='address' name="address" rows='3'><?php echo $admin_address; ?> </textarea></div>
        </div>

        <div class="col-md-5"></div>
        <div class="col-md-5" id='erroraddress' style="color:#FF0000;"></div>

        <div class="row" style="padding-top:25px;">
            <div class="col-md-5" style="font-size:18px;">Email<span style="color:red;font-size: 25px;">*</span></div>
            <div class="col-md-6"><input type="text" required name="email" id="email" class="form-control" value="<?php echo $value['email']; ?>"></div>
        </div>

        <div class="col-md-5"></div>
        <div class="col-md-5" id='erroremail' style="color:#FF0000;"></div>

        <!--<div class="row" style="padding-top:27px;">
            <div class="col-md-5" style="font-size:18px;padding-left:16px;" required>Country Code.</div>
            <div class="col-md-6">
                <input type="text" id='mobile' name="mobile" value="<?php echo $result['mobile'] ?>" class="form-control"></div>
        </div>-->
        <div class="row" style="padding-top:27px;">

            <div class="col-md-5" style="font-size:18px;padding-left:16px;" required>Country Code.<span style="color:red;font-size: 25px;">*</span></div>
            <div class="col-md-6">
                <select name="Country_code" id = "Country_code" class="col-md-5" style="font-size:18px;padding-left:16px;" >


                    
                    <option value="91"<?php if($value['CountryCode']=='91'){echo "selected";}else{}?>>91</option>
                    <option value="1"<?php if($value['CountryCode']=='1'){echo "selected";}else{}?>>1</option>




                </select>
            </div>
<div class='col-md-3 error1' id="errorcountry" style="color:#FF0000"></div>
        </div>
        <div class="row" style="padding-top:27px;">

            <div class="col-md-5" style="font-size:18px;padding-left:16px;" required>Country<span style="color:red;font-size: 25px;">*</span></div>
            <div class="col-md-6">
                 <select id="country" name="id_country" class='form-control'>
                  <option value='-1'>select</option></select>
                </div>
                
                <div class='col-md-3 error1' id="errorstate" style="color:#FF0000"></div>
        </div>
        
         

        <div class="row" style="padding-top:27px;">

            <div class="col-md-5" style="font-size:18px;padding-left:16px;" required>State<span style="color:red;font-size: 25px;">*</span></div>
            <div class="col-md-6">
            
            <select name='state' id='state' class='form-control'> <option value=''>Select</option>
            </select>
                </div>
                
                <div class='col-md-3 error1' id="errorst" style="color:#FF0000"></div>
      </div> 
        
           <script language="javascript">
            populateCountries("country", "state");
            populateCountries("country2");
            
        </script>
         <script>
    $(document).ready(function () {
          var country = "<?php echo $admin_country ?>" ;
          var  state =  "<?php echo $admin_state ?>" ;
          $("#country").val(country).change();
          $("#state").val(state).change();
    });
</script>  
        <div class="row" style="padding-top:27px;">

            <div class="col-md-5" style="font-size:18px;padding-left:16px;" required>City<span style="color:red;font-size: 25px;">*</span></div>
            <div class='col-md-3' style="text-align:left;">
              <input type="text" class='form-control' id='id_accomodation' name='city' value="<?php echo $admin_city ?>">
            </div>
            <div class='col-md-4 indent-small error1' id="errorcity" style="color:#FF0000"></div>
          </div>
        
         <div class="col-md-5"></div>
        <div class="col-md-5" id='errorcountrycode' style="color:#FF0000;"></div>
        <div class="row" style="padding-top:27px;">
            <div class="col-md-5" style="font-size:18px;padding-left:16px;" required>Mobile No.<span style="color:red;font-size: 25px;">*</span></div>
            <div class="col-md-6"><input type="text" id='mobile' name="mobile" value="<?php echo $admin_mobile ?>" class="form-control"></div>
        </div>

        <div class="col-md-5"></div>
        <div class="col-md-5" id='errormobile' style="color:#FF0000;"></div>

        <div class="row" style="padding-top:25px;">
            <div class="col-md-5" style="font-size:18px;"><a
                        href="change_password.php?email=<?php echo $value['email'] ?>">Change Password</a></div>
        </div>
        <div class="row" style="padding-top:40px;">
            <div class="col-md-4"><input type="submit" name="submit" class="btn btn-primary" value="Update" onClick="return valid();"></div>

            <div class="col-md-4"><a href="scadmin_dashboard.php" style="text-decoration:none"> <input type="button" class="btn btn-danger" value="Cancel" style="margin-left:-50px;"></a>
            </div>
<?php if (($school_type == 'school' or $school_type == 'organization') && $user=='School Admin'){?>
             <div class="col-md-4" style="margin-left:-100px;"><a href="school_additional_detail.php?id=<?php echo base64_encode($school_id);?>" style="text-decoration:none" target='_blank'> <input type="button" class="btn btn-danger" value="Additional Details"></a> 
             
        </div>
<?php }?>
    </form>

</div>
</div>
</div>
</div>
</body>
</html>
 
