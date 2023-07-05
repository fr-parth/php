<?php
//include 'core/index_header.php';
include 'core/twilio.php';
$report="";
$errorreport="";
$result_mail="";
$emailErr="";
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
//commented by shivkumar after discussion with Amit Welangi on 20190102
/*function messageUser($cc, $phone, $link, $user_type , $device_type)
{
    switch ($cc) {
        case 91:
            $Text = "Thank+you+for+choosing+smartcookie.+Following+is+link+for+$device_type+app+for+$user_type+Now:+$link";
            $url = "http://www.smswave.in/panel/sendsms.php?user=blueplanet&password=123123&sender=PHUSER&PhoneNumber=$phone&Text=$Text";
            file_get_contents($url);
            break;
        case 1:
            $ApiVersion = "2010-04-01";
            // set our AccountSid and AuthToken
            $AccountSid = "ACf8730e89208f1dfc6f741bd6546dc055";
            $AuthToken = "45e624a756b26f8fbccb52a6a0a44ac9";
            // instantiate a new Twilio Rest Client
            $client = new TwilioRestClient($AccountSid, $AuthToken);
            $number = "+1" . $phone;
            $message = "Thank you for choosing smartcookie. Following is link for .$device_type. app for .$user_type. Now: . $link .";
            $response = $client->request("/$ApiVersion/Accounts/$AccountSid/SMS/Messages",
                "POST", array(
                    "To" => $number,
                    "From" => "732-798-7878",
                    "Body" => $message
                ));
            break;
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Contact=$_POST['Contact'];
    $link=$_POST['link'];
    $cc=$_POST['Country_Code'];
    $user_type=$_POST['user_type'];
    $device_type=$_POST['device_type'];
    $email=$_POST['email'];
    
    //sending mail logic
    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $email = test_input($_POST["email"]);
        // check if e-mail address is well-formed
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }
    }
    if($Contact!='' && $link!='' && $cc!='' && $user_type!='' && $device_type!='' || $email!=''){

        // FOR EMAIL SENDING
        $site = $_SERVER['HTTP_HOST'];
        $msgid='forsendinglink';
        $res = file_get_contents("http://$site/core/clickmail/sendmail.php?email=$email&msgid=$msgid&site=$site&device_type=$device_type&link=$link&user_type=$user_type");
        if(stripos($res,"Mail sent successfully"))
        {
            $result_mail = 'Mail sent successfully';
        }
        else{
            $result_mail = 'Mail not sent';
        }
         //FOR MESSAGE SENDING
        if(messageUser($cc, $Contact, $link, $user_type ,$device_type)){
            $report="SMS sent successfully";
        }else{
            $report="SMS sent successfully";
        }


    }else{
    $errorreport="Please fill up all data";
    }
}*/
?>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
    <style>
        .bgwhite {
            background-color: #fff;
        }
        .padtop10 {
            padding-top: 10px;
        }
        .red {
            color: #f00;
        }
        tr {
            padding-top: 10px;
        }
        .green {
            color: #0f0;
        }
        .panel-info
        {
            width:1000px;
        }
    </style>
</head>
    <script>
        $(document).ready(function () {
            $(".mobile-num").on("blur", function(){
                var mobNum = $(this).val();
                var filter = /^\d*(?:\.\d{1,2})?$/;
                if (filter.test(mobNum)) {
                    if(mobNum.length==10){
                        //alert("valid");
                        $("#mobile-valid").removeClass("hidden");
                       $("#folio-invalid").addClass("hidden");
                    } else {
                       // alert('Please put 10  digit mobile number');
                        $("#folio-invalid").removeClass("hidden");
                        $("#mobile-valid").addClass("hidden");
                        return false;
                    }
                }
                else {
                  //  alert('Not a valid number');
                    $("#folio-invalid").removeClass("hidden");
                    $("#mobile-valid").addClass("hidden");
                    event.preventDefault();
                    return false;
                }
            });
        $("#user_type").change(function(){
            var user_type = $('#user_type').val();
            $('#user').html(user_type);
            $('#user').css('textTransform', 'capitalize');
            
        })
            $("#submit").click(function(){
               var user_type = $('#user_type').val();
               var device_type = $('#device_type').val();
               //ert(user_type);
               if(user_type!='' && device_type!=''){
                    if(device_type=='ios'){
                        switch (user_type) {
                            case 'student':
                                var url="https://goo.gl/HNqrPR";
                                $('#appurlanchor').attr('href',url).html(url);
                                $('#link').val(url);
                                break;
                            case 'teacher':
                                var url="https://goo.gl/cdi711";
                                $('#appurlanchor').attr('href',url).html(url);
                                $('#link').val(url);
                                break;
                            case 'sponsor':
                                var url="https://goo.gl/K1fdxE";
                                $('#appurlanchor').attr('href',url).html(url);
                                $('#link').val(url);
                                break;
//As per discussed with Rakesh Sir, Social Workers option disabled for SMC-3579 by Pranali on 12-11-19                
                            // case 'Social_Workers':
                            //     var url="Under construction";
                            //     $('#appurlanchor').attr('href',url).html(url);
                            //     $('#link').val(url);
                            //     break;
                        }
                    }else
                        if(device_type=='android') {
                            switch (user_type) {
                                case 'student':
                                    var url="https://goo.gl/G6jpu2";
                                    $('#appurlanchor').attr('href',url).html(url);
                                    $('#link').val(url);
                                    break;
                                case 'teacher':
                                    var url="https://goo.gl/89Fr11";
                                    $('#appurlanchor').attr('href',url).html(url);
                                    $('#link').val(url);
                                    break;
                                case 'sponsor':
                                    var url="https://goo.gl/zbAhi4";
                                    $('#appurlanchor').attr('href',url).html(url);
                                    $('#link').val(url);
                                    break;
                                // case 'Social_Workers':
                                //     var url="Under construction";
                                //     $('#appurlanchor').attr('href',url).html(url);
                                //     $('#link').val(url);
                                //     break;
                            }
                        }
               }else{
               alert('Please select user type first');}
            });
        });
    </script>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>:: Smart Cookie -  Student/Teacher Rewards Program ::</title>
    <link href="css/bootstrap.css"rel="stylesheet">
<!--    <script src="js/jquery-1.11.1.min.js"></script>-->
    <script src="js/bootstrap.min.js"></script>
    <link href="css/sc_style2.css"rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
</head>
<body>


<div id="background">
    <p id="bg-text">Background</p>
</div>
<!-- Heading should display on a page by chaitali(php intern) for SMC-3577 on 7/11/19 -->
<div class="row1 header  bg-wht">
    <div class='container'>

        <div class="row" style="padding-top:20px;" >

            <div class="col-md-5 visible-lg visible-md">
                <a href="index.php"> <img src="images/300_103.png" /> </a>
            </div>
            <div class="col-md-5 visible-sm">
                <img src="Images/250_86.png" />
            </div>
            <div class="col-md-5 visible-xs">
                <img src="Images/220_76.png" />
            </div>
            <div class="col-md-4 visible-sm visible-lg visible-md visible-xs" style="margin-top:40px; font-weight:bold; float-left:0; font-size:15px;">
            Download IOS / Android Application

            </div>
        </div>
    </div>
</div>

    <div style="width:800px; margin:0 auto; background-color: white;">
        <div class='col-md-10 col-md-offset-2' >
            <div class='panel panel-info' style="width: 550px;height: 700px;">
                <div class='panel-heading'>
                    <div class='panel-title'>
                        Smartcookie - Students/Teachers/Employees/Managers<!-- /Social Workers --> rewards program
                    </div>
                </div>
                <div class='panel-body' style="text-align: center;">
                    <form method="post" id="myform" action="">
                        <table class='table'>

                                <tr>
                                    <td style="color:#78F44E";><?php echo $report;?> </td>
                                    <td id="errorreport" style="color:#ff0000;";><?php echo $errorreport;?></td>
                                    <td style="color:#78F44E;";><?php echo $result_mail;?> </td>
                                </tr>
                                <tr>
                                    <td style="padding: 27px">I am<span class='red'>*</span></td>
                                    <td style="padding: 27px">
                                        <select id="user_type" name="user_type" style="width:200px">
                                            <option value="" selected="selected">Select</option>
                                            <option value="student">Student</option>
                                            <option value="teacher">Teacher</option>
                                            <option value="sponsor">Sponsor</option>
                                            <!-- <option value="Social_Workers">Social Workers</option> -->
                                        </select>
                                        <?php echo form_error('user_type', '<div class="alert alert-danger alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>'); ?>
                                        </td>
                                </tr>
                                 <tr>
                                    <td style="padding: 27px"><span id="user"></span> Name<span class='red'>*</span></td>
                                    <td style="padding: 27px"><input type='text' class=" " id='user_name' name='user_name' style='width:200px'/>
                                    <?php echo form_error('user_name', '<div class="alert alert-danger alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>'); ?>
                                    </td>
                                    
                                </tr>
                                <tr>
                                    <!--Below code is updated by Rutuja Jori & Sayali Balkawade(PHP Interns) for Bug SMC-3578 on 26/04/2019-->
                                    <td style="padding: 27px">Mobile<span class='red'>*</span></td>
                                    <td style="padding: 27px">
                                        <select id="device_type" name="device_type" style="width:200px">
                                            <option value="" selected="selected">Select</option>
                                            <option value="ios">ios</option>
                                            <option value="android">Android</option>
                                        </select>
                                        <?php echo form_error('device_type', '<div class="alert alert-danger alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>'); ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td style="padding: 27px">Country<span class='red'>*</span></td>
                                    <td style="padding: 27px">
                                        <select id="Country_Code" name="Country_Code" style="width:200px">
                                            <option value="" selected="selected">Select</option>
                                            <option value="91">India</option>
                                            <option value="1">Us</option>
                                        </select>
                                        <?php echo form_error('Country_Code', '<div class="alert alert-danger alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>'); ?>
                                        </td>
                                </tr>

                                <tr>
                                    <td style="padding: 27px">Contact No<span class='red'>*</span></td>
                                    <td style="padding: 27px"><input type='Contact' class="mobile-num " id='Contact' name='Contact' style='width:200px'/>
                                    <?php echo form_error('Contact', '<div class="alert alert-danger alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>'); ?>
                                    </td>
                                    <span id="folio-invalid" class="hidden mob-helpers">
                                        <i class="fa fa-times mobile-invalid"></i><font color="red">Please Enter valid contact No</font></span>
                                </tr>

                                <tr>
                                    <td style="padding: 27px">Email Address</td>
                                    <td style="padding: 27px"><input type='email' id='email' name='email' style='width:200px'  />
                                    <?php echo form_error('email', '<div class="alert alert-danger alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>'); ?>
                                    </td>
                                    <br>
                                    <td style="color:#ff0000;";><?php //echo $emailErr;?></td>
                                </tr>

                                    <input type='hidden' id='link' name='link' style='width:200px'/>
                                <tr style="display:none">
                                    <td style="padding: 27px">Link</td>
                                    <td style="padding: 27px" id="applink">
                                        <a name="link"id="appurlanchor"></a>
                                    </td>
                                </tr>

                                <tr>
                                    <td style="padding: 27px"></td>
                                    <td class="center">
                                        <!-- Display Successful message by chaitali(php intern) for SMC-3580 on 11/11/19 -->
                                        <input class="btn btn-primary" type='submit' id='submit' name='submit'  value="Send SMS/Email" style='width:200px' onClick="alert('SMS/Email sent successfully')" />
                                    </td>
                                </tr>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php include 'core/index_footer.php'; ?>
