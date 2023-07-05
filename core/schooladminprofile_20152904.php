<?php
include("scadmin_header.php");
$report = "";
$query = mysql_query("select * from tbl_school_admin where id = " . $_SESSION['id']);
$value = mysql_fetch_array($query);
$school_id = $value['school_id'];
$id = $_SESSION['id'];
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $education = $_POST['education'];
    $id_checkin = $_POST['id_checkin'];
    $school_name = $_POST['school_name'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $mobile = $_POST['mobile'];
    //$ContryCode = $_POST['mobile'];
    $Country=$_POST['Country'];

    list($month, $day, $year) = explode("/", $id_checkin);
    $year_diff = date("Y") - $year;
    $month_diff = date("m") - $month;
    $day_diff = date("d") - $day;
    if ($day_diff < 0 || $month_diff < 0) $year_diff--;
    $age = $year_diff;
    $prepAddr = str_replace(' ', '+', $address);
    $geocode = file_get_contents('http://maps.google.com/maps/api/geocode/json?address=' . $prepAddr . '&sensor=false');
    $output = json_decode($geocode);
    $lat = $output->results[0]->geometry->location->lat;
    $long = $output->results[0]->geometry->location->lng;
    $query = mysql_query("update tbl_school set school_address='$address',school_latitude='$lat', school_longitude='$long' where id='$school_id'");
    $sql = mysql_query("update tbl_school_admin set  school_name='$school_name',name='$name',scadmin_gender='$gender',education='$education',scadmin_dob='$id_checkin',address='$address',email='$email',mobile='$mobile',scadmin_age='$age',CountryCode='$Country' where id = " . $_SESSION['id']);
    if (mysql_affected_rows() > 0) {
        $successreport = "Profile is successfully updated";
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
    <script type="text/javascript" src="http://ajax.googleapis.com/
ajax/libs/jquery/1.5/jquery.min.js"></script>
    <script src="//code.jquery.com/ui/1.11.3/jquery-ui.js"></script>
    <script type="text/javascript">
        $(function () {
            $("#id_checkin").datepicker({
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
                $('#logo').attr('src', 'image/avatar_2x.png');
                $('#logo input').val("image/avatar_2x.png");
                location.reload();
            });
        });

        function valid() {
            var name = document.getElementById("name").value;
            if (name == "" || name == null) {
                document.getElementById("errorname").innerHTML = "Please enter name";
                return false;
            }
            regx1 = /^[A-z ]+$/;
            //validation for name
            if (!regx1.test(name) || !regx1.test(name)) {
                document.getElementById('errorname').innerHTML = 'Please Enter valid Name';
                return false;
            }
            var gender1 = document.getElementById("gender1").checked;
            var gender2 = document.getElementById("gender2").checked;
            if (gender1 == false && gender2 == false) {
                document.getElementById('errorgender').innerHTML = 'Please Select gender';
                return false;
            }
            var education = document.getElementById("education").value;

            if (education == "Select") {
                document.getElementById("erroreducation").innerHTML = "Please enter Education";
                return false;
            }
            var id_checkin = document.getElementById("id_checkin").value;
            if (id_checkin == "" || id_checkin == null) {
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

            var address = document.getElementById("address").value;
            if (address == "" || address == null) {
                document.getElementById("erroraddress").innerHTML = "Please enter Address";
                return false;
            }
            var email = document.getElementById("email").value;
            if (email == null || email == "") {

                document.getElementById('erroremail').innerHTML = 'Please Enter email ID';

                return false;
            }

            var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
            if (!email.match(mailformat)) {
                document.getElementById('erroremail').innerHTML = 'Please Enter valid email ID';
                return false;
            }
            var mobile = document.getElementById("mobile").value;

            if (mobile == "" || mobile == null) {

                document.getElementById("errormobile").innerHTML = "Please enter mobile no.";
                return false;
            }
            var phoneno = /^\d{10}$/;
            if (!mobile.match(phoneno)) {
                document.getElementById("errormobile").innerHTML = "Please enter valid mobile no.";
                return false;
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
    <?php $sql = mysql_query("select * from tbl_school_admin where id='$id'");
    $result = mysql_fetch_array($sql);
    ?>
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-2">
            <div id="preview">
                <?php
                if ($result['img_path'] == "") {
                    ?>
                    <img src="image/avatar_2x.png" class='preview'/><?php } else {
                    ?>
                    <img src="<?php echo $result['img_path']; ?>" class='preview' id="logo"
                         style="height:100px;width:100px;"/>
                <?php } ?>
            </div>
            <div class="col-md-1" style="padding-top:10px;">
                <form id="imageform" method="post" enctype="multipart/form-data" action='ajaximage.php'>
                    <input type="file" name="photoimg" id="photoimg"/>
                    <br>
                    <input type="button" name="resetimage" id="resetimage" style="color: red" value="Remove"/>
                </form>
            </div>
        </div>
        <div class="col-md-4">
            <div class="h" align="center"><h3>Edit Profile</h3></div>
        </div>
        <div class="col-md-4"><img src="image/edit-icon.png" style="height:50px;"></div>
    </div>

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
                    <div class="col-md-5" style="font-size:18px; padding-left:15px;">Name</div>
                    <div class="col-md-6"><input type="text" name="name" id="name" class="form-control" value="<?php echo $result['name']; ?>" required></div>
                </div>
                <div class="col-md-5"></div>
                <div class="col-md-5" id='errorname' style="color:#FF0000;"></div>

                <div class="row" style="padding-top:25px;">
                    <div class="col-md-5" style="font-size:18px;">School ID</div>
                    <div class="col-md-6"><input type="text" required name="school_id" id="school_id" class="form-control"
                                                 value="<?php echo $result['school_id']; ?>" disabled ></div>
                </div>

                <div class="row" style="padding-top:20px;">
                    <div class="col-md-5" style="font-size:18px;">Gender</div>
                    <div class="col-md-2">
                        <?php
                        if ($result['scadmin_gender'] == ""){
                        ?>
                        <input type="radio" name="gender" id="gender1" value="Male" required> Male
                    </div>
                    <div class="col-md-2"><input type="radio" name="gender" id="gender2" value="Female">
                        Female
                    </div>
                    <?php }else {
                    if ($result['scadmin_gender'] == "Male"){
                    ?>
                    <input type="radio" name="gender" id="gender1" value="Male" checked> Male
                </div>
                <?php }else{
                ?>
                <input type="radio" name="gender" id="gender1" value="Male"> Male
            </div>
            <div class="col-md-2">
                <?php }if ($result['scadmin_gender'] == "Female"){ ?>
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
            <div class="col-md-5" style="font-size:18px;">Education</div>
            <div class="col-md-6">
                <?php if ($result['education'] != "") { ?>
                    <select class="form-control" name="education" id="education">
                        <?php if ($result['education'] == "B.Ed") { ?>
                            <option value="B.Ed" selected>B.Ed</option>
                        <?php } else { ?>
                            <option value="B.Ed">B.Ed</option>
                        <?php }
                        if ($result['education'] == "M.Ed") { ?>
                            <option value="M.Ed" selected>M.Ed</option>
                        <?php } else { ?>
                            <option value="M.Ed">M.Ed</option>
                        <?php }
                        if ($result['education'] == "Ph.D") { ?>

                            <option value="Ph.D" selected>Ph.D</option>
                        <?php } else { ?>
                            <option value="Ph.D">Ph.D</option>
                        <?php }
                        if ($result['education'] == "B.Sc") { ?>
                            <option value="B.Sc" selected>B.Sc</option>

                        <?php } else { ?>
                            <option value="B.Sc">B.Sc</option>
                        <?php } ?>

                        <?php if ($result['education'] == "BTech") { ?>
                            <option value="BTech" selected>BTech</option>
                        <?php } else { ?>
                            <option value="BTech">BTech</option>
                        <?php } ?>

                        <?php if ($result['education'] == "MTech") { ?>
                            <option value="MTech" selected>MTech</option>
                        <?php } else { ?>
                            <option value="MTech">MTech</option>
                        <?php } ?>

                        <?php if ($result['education'] == "B.A") { ?>
                            <option value="B.A" selected>B.A</option>
                        <?php } else { ?>
                            <option value="B.A">B.A</option>
                        <?php } ?>

                        <?php if ($result['education'] == "M.A") { ?>
                            <option value="M.A" selected>M.A</option>
                        <?php } else { ?>
                            <option value="M.A">M.A</option>
                        <?php } ?>

                        <?php if ($result['education'] == "B.B.A") { ?>
                            <option value="B.B.A" selected>B.B.A</option>
                        <?php } else { ?>
                            <option value="B.B.A">B.B.A</option>
                        <?php } ?>

                        <?php if ($result['education'] == "M.S") { ?>
                            <option value="M.S" selected>M.S</option>
                        <?php } else { ?>
                            <option value="M.S">M.S</option>
                        <?php } ?>

                        <?php if ($result['education'] == "M.B.A") { ?>
                            <option value="M.B.A" selected>M.B.A</option>
                        <?php } else { ?>
                            <option value="M.B.A">M.B.A</option>
                        <?php } ?>

                        <?php if ($result['education'] == "B.COM") { ?>
                            <option value="B.COM" selected>B.COM</option>
                        <?php } else { ?>
                            <option value="B.COM">B.COM</option>
                        <?php } ?>

                        <?php if ($result['education'] == "ME") { ?>
                            <option value="ME" selected>ME</option>
                        <?php } else { ?>
                            <option value="ME">ME</option>
                        <?php } ?>

                        <?php if ($result['education'] == "BE") { ?>
                            <option value="BE" selected>BE</option>
                        <?php } else { ?>
                            <option value="BE">BE</option>
                        <?php } ?>
                        <?php if ($result['education'] == "Other") { ?>
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
            <div class="col-md-6"><input class='form-control datepicker' id='id_checkin' name="id_checkin" value="<?php echo $result['scadmin_dob'] ?>"></div>
        </div>

        <div class="col-md-5"></div>
        <div class="col-md-5" id='errordate' style="color:#FF0000;"></div>

        <div class="row" style="padding-top:25px;">
            <div class="col-md-5" style="font-size:18px;">School Name</div>
            <div class="col-md-6"><input type="text" required name="school_name" id="school_name" class="form-control" value="<?php echo $result['school_name']; ?>"></div>
        </div>

        <div class="row" style="padding-top:25px;">
            <div class="col-md-5" style="font-size:18px;">School Address</div>
            <div class="col-md-6"><textarea required class='form-control' id='address' name="address" rows='3'><?php echo $result['address']; ?> </textarea></div>
        </div>

        <div class="col-md-5"></div>
        <div class="col-md-5" id='erroraddress' style="color:#FF0000;"></div>

        <div class="row" style="padding-top:25px;">
            <div class="col-md-5" style="font-size:18px;">Email</div>
            <div class="col-md-6"><input type="text" required name="email" id="email" class="form-control" value="<?php echo $result['email']; ?>"></div>
        </div>

        <div class="col-md-5"></div>
        <div class="col-md-5" id='erroremail' style="color:#FF0000;"></div>

        <!--<div class="row" style="padding-top:27px;">
            <div class="col-md-5" style="font-size:18px;padding-left:16px;" required>Country Code.</div>
            <div class="col-md-6">
                <input type="text" id='mobile' name="mobile" value="<?php echo $result['mobile'] ?>" class="form-control"></div>
        </div>-->
        <div class="row" style="padding-top:27px;">
            <div class="col-md-5" style="font-size:18px;padding-left:16px;" required>Country Code.</div>
            <div class="col-md-6">
            <select name="Country"class="col-md-5" style="font-size:18px;padding-left:16px;" >

                <option value="">Select...</option>
                <option value="91"<?php if($result['CountryCode']=='91'){echo "selected";}else{}?>>91</option>
                <option value="1"<?php if($result['CountryCode']=='1'){echo "selected";}else{}?>>1</option>




            </select>
            </div>

        </div>
        <div class="row" style="padding-top:27px;">
            <div class="col-md-5" style="font-size:18px;padding-left:16px;" required>Mobile No.</div>
            <div class="col-md-6"><input type="text" id='mobile' name="mobile" value="<?php echo $result['mobile'] ?>" class="form-control"></div>
        </div>

        <div class="col-md-5"></div>
        <div class="col-md-5" id='errormobile' style="color:#FF0000;"></div>

        <div class="row" style="padding-top:25px;">
            <div class="col-md-5" style="font-size:18px;"><a
                        href="change_password.php?email=<?php echo $result['email'] ?>">Change Password</a></div>
        </div>
        <div class="row" style="padding-top:40px;">
            <div class="col-md-3"></div>
            <div class="col-md-3"><input type="submit" name="submit" class="btn btn-primary" value="Update" onClick="return valid();"></div>
            <div class="col-md-3"><a href="scadmin_dashboard.php" style="text-decoration:none"> <input type="button" class="btn btn-danger" value="Cancel"></a>
            </div>
        </div>
    </form>
</div>
</div>
</div>
</div>
</div>
</body>
</html>
