
<!--Below code is updated by Rutuja Jori & Sayali Balkawade on 21/05/2019 for bug SMC-3874-->


<?php  ob_start(); ?>
<html>
<head>
    <meta charset="utf-8">
    <title>Smart Cookies</title>
<!--    <link href='css/datepicker.min.css' rel='stylesheet' type='text/css'>-->
     <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="js/city_state.js" type="text/javascript"></script>
<!--    <script src='js/bootstrap-datepicker.min.js' type='text/javascript'></script>-->
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>-->
<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->
    <!-- Load jQuery and bootstrap datepicker scripts -->
     <script src="js/jquery-1.11.1.min.js"></script>
     <script src="js/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript">
        // When the document is ready
        $(document).ready(function () {
            //$('#example1').datepicker({});
        });

        $(document).ready(function () {

            $('#catdiv').hide();
        });
         $(document).ready(function () {

            $('#payment_method').hide();
        });
        $(document).ready(function () {

            $('#amount').hide();
        });
    </script>
    <style>
        textarea {
            resize: none;
        }
    </style>

    <script type="text/javascript">
        /*$(document).ready(function() {
         $('.multiselect').multiselect();
         });*/

        var reg = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;
        function PhoneValidation(phoneNumber) {
            var OK = reg.exec(phoneNumber.value);
            var count=(phoneNumber.value.match(/0/g)|| []).length;
            if (!OK) {
                document.getElementById('errorphone').innerHTML = 'Please Enter Valid Phone Number';
                return false;
            }
            if(count=='10'){
                document.getElementById('errorphone').innerHTML = 'Please Enter Valid Phone Number';
                return false;
            }
            else {
                document.getElementById('errorphone').innerHTML = '';
                return true;
            }

        }
        function valid() {
         if (document.getElementById("entity").value == 1) {
        var id_first_name = document.getElementById("id_first_name").value;
        var pattern = /^[a-zA-Z ]*$/;
       if(id_first_name.trim()=="" || id_first_name.trim()==null)
        {
            alert("Please Enter first name!");
            return false;
        }
        
        else if (pattern.test(id_first_name)) {
            //alert("Your your Academic Year is : " + reason);
           // return true;
        }
        else{
        alert("It is not valid first name");
        return false;
        }
        var id_last_name = document.getElementById("id_last_name").value;
        var pattern = /^[a-zA-Z ]*$/;
       if(id_last_name.trim()=="" || id_last_name.trim()==null)
        {
            alert("Please Enter last name!");
            return false;
        }
        
        else if (pattern.test(id_last_name)) {
            //alert("Your your Academic Year is : " + reason);
           // return true;
        }
        else{
        alert("It is not valid last name!");
        return false;
        }
        var school_id = document.getElementById("school_id").value;
        var pattern =/^(?=.*[1-9a-zA-Z])[a-zA-Z0-9-_ ]+$/;
        //var pattern =/^0*[1-9][0-9]*$
        ///^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,16}$/
       if(school_id.trim()=="" || school_id.trim()==null)
        {
            alert("Please Enter school ID!");
            return false;
        }
        
        else if (pattern.test(school_id)) {
            //alert("Your your Academic Year is : " + reason);
           // return true;
        }
        else{
        alert("It is not valid school ID!");
        return false;
        }
        var sc_school_name = document.getElementById("sc_school_name").value;
        var pattern =  /^[a-zA-Z0-9-_ ]+$/;
       if(sc_school_name.trim()=="" || sc_school_name.trim()==null)
        {
            alert("Please Enter school name!");
            return false;
        }
        
        else if (pattern.test(sc_school_name)) {
            //alert("Your your Academic Year is : " + reason);
           // return true;
        }
        else{
        alert("It is not valid school name!");
        return false;
        }
        
        var group_id=document.getElementById("group_id").value;
      if(group_id=="")
        {
        alert("please select group type!");
            return false;
        }
        var school_type=document.getElementById("school_type").value;
      if(school_type=="")
        {
        alert("please select school type!");
            return false;
        }
        var gender1 = document.getElementById("gender1").checked;
        var gender2 = document.getElementById("gender2").checked;
            if (gender1 == false && gender2 == false) {
               // document.getElementById('errorgender').innerHTML = 'Please Select gender';
                alert("Please Select gender!");
                return false;
            }
        /*  else
            {
                document.getElementById('errorgender').innerHTML = '';
            }
        */
         }      
        var id_email = document.getElementById("id_email").value;
        var pattern = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
       if(id_email.trim()=="" || id_email.trim()==null)
        {
            alert("Please Enter email ID!");
            return false;
        }
        
        else if (pattern.test(id_email)) {
            //alert("Your your Academic Year is : " + reason);
           // return true;
        }
        else{
        alert("It is not valid email ID!");
        return false;
        }
            
    /*  var id_email = document.getElementById("id_email").value;
        var pattern = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
        if (pattern.test(id_email)) {
           // alert("Your mobile number : " + mobile);
           // return true;FILTER_VALIDATE_EMAIL
        }
        else{
        alert("Enter valid mobile number!");
        return false;
        }
    */  
        var id_phone = document.getElementById("id_phone").value;
        var pattern =/^[6789]\d{9}$/;
       if(id_phone.trim()=="" || id_phone.trim()==null)
        {
            alert("Please Enter phone number!");
            return false;
        }
        
        else if (pattern.test(id_phone)) {
            //alert("Your your Academic Year is : " + reason);
           // return true;address
        }
        else{
        alert("It is not valid phone number!");
        return false;
        }
        var address = document.getElementById("id_address").value;
        var pattern =/^[a-zA-Z0-9-_ ]+$/;
       if(address.trim()=="" || address.trim()==null)
        {
            alert("Please Enter address!");
            return false;
        }
        
        else if (pattern.test(address)) {
            //alert("Your your Academic Year is : " + reason);
           // return true;address  country state
        }
        else{
        alert("It is not valid address!");
        return false;
        }
        var country=document.getElementById("country").value;
      if(country==null || country=="" || country=="Select Country")
        {
        alert("please select country!");
            return false;
        }
        var state=document.getElementById("state").value;
      if(state==null || state=="" || state=="Select State")
        {
        alert("please select state!");
            return false;
        }
        var city = document.getElementById("id_city").value;
        var pattern =/^[a-zA-Z0-9-_ ]+$/;
       if(city.trim()=="" || city.trim()==null)
        {
            alert("It is not valid city!");
            return false;
        }
        
        else if (pattern.test(city)) {
            //alert("Your your Academic Year is : " + reason);
           // return true;address  country state
        }
        else{
        alert("It is not valid city!");
        return false;
        }

        
            if (document.getElementById("entity").value == 4) {
                console.log("for create Sponsor ");
                var reg1 = /^[A-z]+$/;//validation for name
                var company_name = document.getElementById("company_name").value;
                if (company_name == null || company_name == "") {
                    document.getElementById('errorname').innerHTML = 'Please Enter Company Name';
                    return false;
                }
                else if (reg1.test(company_name)) {
                    document.getElementById('errorname').innerHTML = '';
                    return true;
                }
                else {
                    document.getElementById('errorname').innerHTML = 'Please Enter valid Company Name';
                    return false;
                }

                var cat = document.getElementById("category").value;
                if (cat == null || cat == "") {
                    document.getElementById('errorcat').innerHTML = '';
                    return false;
                }
                else {
                    document.getElementById('errorcat').innerHTML = 'Please Select Category';
                }
                regx1 = /^[A-z ]+$/;
                var email = document.getElementById("id_email").value;
                if (email == "") {
                    document.getElementById('erroremail').innerHTML = '';
                    return false;
                }
                else {
                    document.getElementById('erroremail').innerHTML = 'Please Enter email';
                }
                $regx2 = /^\d{10}$/
                var phone = document.getElementById("phone").value;
                if (phone == null || phone == "") {
                    document.getElementById('errorphone').innerHTML = 'Please enter phone';
                    return false;
                }
                else if (!regx2.test(phone)) {
                    document.getElementById('errorphone').innerHTML = '';
                    return false;
                }
                else {
                    document.getElementById('errorphone').innerHTML = 'Please enter valid phone';
                }
                var address = document.getElementById("id_address").value;
                alert(address);
            }
            else {
                console.log("for create school ");
                var first_name = document.getElementById("id_first_name").value;
                var last_name = document.getElementById("id_last_name").value;
                var state = document.getElementById("state").value;
                //var last_name=document.getElementById("id_last_name").value;
                regx1 = /^[A-z ]+$/;
                var email = document.getElementById("id_email").value;
                var country = document.getElementById("country").value;
                var city = document.getElementById("id_city").value;
                var password = document.getElementById("password").value;
                var cnfpassword = document.getElementById("cnfpassword").value;

                if (first_name == null || first_name == "" || last_name == null || last_name == "") {
                    document.getElementById('errorname').innerHTML = 'Please Enter Name';
                    return false;
                }
                //validation for name
                else if (!regx1.test(first_name) || !regx1.test(last_name)) {
                    document.getElementById('errorname').innerHTML = 'Please Enter valid Name';
                    return false;
                }
                else {
                    document.getElementById('errorname').innerHTML = '';
                }
                if (email == null || email == "") {
                    document.getElementById('erroremail').innerHTML = 'Please Enter email';
                    return false;
                }
                else {
                    document.getElementById('erroremail').innerHTML = '';
                }
                $regx2 = /^[0-9 ]+$/
                var phone = document.getElementById("phone").value;
                if (phone == null || phone == "") {
                    document.getElementById('errorphone').innerHTML = 'Please enter phone';
                    return false;
                }
                else if (!regx2.test(phone)) {
                    document.getElementById('errorphone').innerHTML = 'Please enter valid phone';
                    return false;
                }
                else {
                    document.getElementById('errorphone').innerHTML = '';
                }
                var address = document.getElementById("id_address").value;
                if (address == null || address == " ") {
                    document.getElementById('erroraddress').innerHTML = 'Please Enter address';
                    return false;
                }
                else {
                    document.getElementById('erroraddress').innerHTML = '';
                }
                if (country == '-1') {
                    document.getElementById('errorcountry').innerHTML = 'Please Enter country';
                    return false;
                }
                else {
                    document.getElementById('errorcountry').innerHTML = '';
                }
                if (state == null || state == "") {
                    document.getElementById('errorstate').innerHTML = 'Please Enter state';
                    return false;
                }
                else {
                    document.getElementById('errorstate').innerHTML = '';
                }
                if (city == null || city == "") {
                    document.getElementById('errorcity').innerHTML = 'Please Enter city';
                    return false;
                }
                else {
                    document.getElementById('errorcity').innerHTML = '';
                }
                if (password != cnfpassword) {
                    document.getElementById('errorpassword').innerHTML = 'Password does not match the confirm password';
                    return false;
                }
                else {
                    document.getElementById('errorpassword').innerHTML = '';
                }
            }

        }

        function validemail() {
            var email = document.getElementById("id_email").value;
            if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)) {
                return (true);
            }
            alert("Enter Valid Email Address!")
            return (false);
        }

        $(document).ready(function () {
            $('#entity').change(function () {
                if (document.getElementById("entity").value == 4) {
                    $('#genderdiv').hide();
                    $('#datediv').hide();
                    $('#id_last_name').hide();
                    $('#id_first_name').hide();
                    $('#catdiv').show();
                     $('#payment_method').show();
                     $('#amount').show();
                     $('#school_type1').hide();
                     $('#school_id1').hide();
                     $('#sc_school_name1').hide();
                      $('#group_id1').hide();
                    
                }
                else {
                    $('#genderdiv').show();
                    $('#datediv').show();
                    $('#id_last_name').show();
                    $('#id_first_name').show();
                    $('#catdiv').hide();
                    $('#payment_method').hide();
                    $('#amount').hide();
                    $('#school_type1').show();
                    $('#group_id1').show();
                    $('#school_id1').show();
                    $('#sc_school_name1').show();
                }
            });
        });


    </script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#entity').change(function () {
                var num = $('#entity').val();
                var html = ''; //string variable for html code for fields
                if (num == 4) {
                    html += ' <div class="col-md-3" >  <div class="form-group internal "> <input class="form-control" type="text" name="company_name" placeholder="Company Name" id="company_name" value="<?php if (isset($_POST['company_name'])) {
                        echo $_POST['company_name'];
                    }?>" /></div></div>';
                }
//insert this html code into the div with id catList
                $('#catList').html(html);
            });
        });
        
        
    </script>

<style>
.error {color: #FF0000;}
</style>
</head>


<?php
            
include("corporate_cookieadminheader.php");
if (isset($_POST['submit'])) {
    
    //print_r($_REQUEST); exit;
    $user_type = $_POST['entity'];
    $email = $_POST['id_email'];
    $phone = $_POST['id_phone'];
    $school_id = addslashes($_POST['school_id']);
    $school_name = addslashes($_POST['sc_school_name']);
    $group_id = $_POST['group_id'];
    $counts = 0;
    $counts1 = 0;
    
    //for sponsor
    if ($user_type == 4) {
        $row1 = mysql_query("select * from tbl_sponsorer where sp_email='$email'");
        if (mysql_num_rows($row1) > 0) {
            $counts = 1;
        }
    } else if ($user_type == 1) {
        $row1 = mysql_query("select * from tbl_school_admin where email='$email'");
        
        $row2 = mysql_query("select id from tbl_school_admin where mobile='$phone'");
        if (mysql_num_rows($row1) > 0) {
           // echo "</br>counts" . 
           $counts = 1;
        }
        if (mysql_num_rows($row2) > 0) {
           // echo "</br>counts" . 
           $counts1 = 1;
        }
        
    }
          //exit;
        

if($counts > 0 || $counts1 > 0){
    if ($counts > 0) {
        $report = "Email ID is already present";        
    } 
    if($counts1 > 0){
        $report1 = "Mobile number is already present";
    }
} else {
        $counts = 0;
        $counts1 =0;
        if ($user_type == 4) {
            $company_name = $_POST['company_name'];
            $phone = $_POST['id_
            phone'];
            $gender = $_POST['gender1'];
            $category = $_POST['category'];
            $address = trim($_POST['address']);
            $country_code= $_POST['country-code'];
            $payment_method= $_POST['method'];
            $amount= $_POST['amount'];

            //echo "</br>password-->".$password = $_POST['password'];
            $country = mysql_real_escape_string($_POST['country']);
            $state = mysql_real_escape_string($_POST['state']);
            $city = mysql_real_escape_string($_POST['city']);
                if($country_code==91)
                {
                date_default_timezone_set("Asia/Calcutta");
                //date format changes by sachin 03-10-2018
                // $dates = date("Y-m-d h:i:s ");
                    $dates = CURRENT_TIMESTAMP;
                //date format changes by sachin 03-10-2018
                }
                elseif($country_code==1)
                {
                date_default_timezone_set("America/Boa_Vista");
                $dates = date("Y-m-d h:i:s ");
                }
                else
                {
                date_default_timezone_set("Asia/Calcutta");
                //date format changes by sachin 03-10-2018
                // $dates = date("Y-m-d h:i:s ");
                    $dates = CURRENT_TIMESTAMP;
                //date format changes by sachin 03-10-2018
                }
                
              $calculated_json = file_get_contents("http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false&region=$region");
            // var_dump($calculated_json);
             $calculated_json = json_decode($calculated_json);
 //var_dump($calculated_json);die;
         $calculated_lat = $calculated_json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
         $calculated_lon = $calculated_json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
            $cal_lat=$calculated_lat;   
            $cal_lon=$calculated_lon;
            
            

        } else {

            $id_first_name = $_POST['id_first_name'];
            $id_last_name = $_POST['id_last_name'];
            $school_type = $_POST['school_type'];
            $name = $id_first_name . " " . $id_last_name;
            // $date = $_POST['dob'];
            // $password = $_POST['password'];
            $phone = $_POST['id_phone'];
            $gender = $_POST['gender1'];
            $address = $_POST['address'];
            $country_code= $_POST['country-code'];

            $country = mysql_real_escape_string($_POST['country']);
            $state = mysql_real_escape_string($_POST['state']);
            $city = mysql_real_escape_string($_POST['city']);
            $dates = date('Y/m/d h:m:s');


            // list($month, $day, $year) = explode("/", $date);
            // $year_diff = date("Y") - $year;
            // $month_diff = date("m") - $month;
            // $day_diff = date("d") - $day;
            // if ($day_diff < 0 || $month_diff < 0) $year_diff--;
            // $age = $year_diff;
        }

        if ($user_type == 1) {
            $password = $id_last_name. "123";

            //changes done by Pranali on 25-06-2018 for bug SMC-2718
            
            $myquery = "select school_id from tbl_school_admin where school_id='$school_id'" ;
            $row2 = mysql_query($myquery); 
            if (mysql_num_rows($row2) > 0){
                echo "<script>alert('School id already exist, please try with different id!!'); window.location.href='/core/addorganisation.php'; </script>";
                EXIT;
                }
                
            
            $sqls = "INSERT INTO `tbl_school_admin`(name,address, scadmin_city, scadmin_gender,scadmin_country, email,  reg_date,scadmin_state,mobile,password,school_type,group_status,school_id,school_name,CountryCode) VALUES ('$name','$address','$city','$gender','$country', '$email','$dates','$state','$phone','$password','organization','organization','$school_id','$school_name','$country_code')";

            
            // echo $sqls;
            $count = mysql_query($sqls) or die(mysql_error());

            //retrive current inserted record id
            $arr = mysql_query("select id from tbl_school_admin ORDER BY id DESC limit 1");
            $result = mysql_fetch_array($arr);

    //Staff insertion and access permission to staff functionality done by Pranali Dalvi for SMC-4645 on 4-4-20
            $pass = $id_first_name . "123";
            $delete_flag='0';
            $group_member_id='0';
            $sql_staff = "INSERT INTO `tbl_school_adminstaff`(stf_name,addd, city, gender, country, email, currentDate,statue,phone,pass,school_id,school_name,CountryCode,group_member_id,delete_flag) VALUES ('$name','$address','$city','$gender','$country', '$email','$dates','$state','$phone','$pass','$school_id','$school_name','$country_code','$group_member_id','$delete_flag')"; 
            $sql_result = mysql_query($sql_staff) or die(mysql_error());

            $arr1 = mysql_query("select id,stf_name from tbl_school_adminstaff ORDER BY id DESC limit 1");
            $row = mysql_fetch_array($arr1);
            $staff_id = $row['id'];
            $stf_name = $row['stf_name'];

            if ($count >= 1 && mysql_num_rows($arr1) >= 1) {
                
                //$site=$_SERVER['REQUEST_SCHEME'].'://'.$_SERVER["HTTP_HOST"];
                $site = $GLOBALS['URLNAME'];
                //$msgid="welcomeschooladmin";
                $user = 'HR Admin';

                //$msgid1="welcomeadminstaff";
                $user1='HR Admin Staff';
                $entity_id='202';
    //spaces replaced with '%20' by Pranali for resolving email sending issue
                $user_new=str_replace(' ', '%20', $user);
                $school_name_new=str_replace(' ', '%20', $school_name);
                $smsid ='welcomehradminandstaff';
                //sendmail_new.php used for Email sending by Pranali for SMC-4673 on 25-6-20
                $msgid_sql = mysql_query("SELECT id FROM tbl_email_sms_templates WHERE type='$smsid'");
                $msgid1 = mysql_fetch_array($msgid_sql);
                $msgid =  $msgid1['id'];
                //email to admin and staff
               $senderid=1;
                $res = file_get_contents("$site/core/clickmail/sendmail_new.php?email=$email&msgid=$msgid&site=$site&pass_admin=$password&user_type=$user_new&school_name=$school_name_new&school_id=$school_id&pass_staff=$pass&senderid=$senderid");
                //email to admin staff
                //$res = file_get_contents("http://$site/core/clickmail/sendmail.php?email=$email&msgid=$msgid1&site=$site&pass=$password&user_type=$user1&school_name=$school_name&school_id=$school_id");

//message to User added , autocomplete="off" and country code & mobile number field merge into one row by Pranali for SMC-4673 on 20-5-20
    //sendsms.php file called for SMS sending by Pranali for SMC-4673 on 8-6-20          

    $res_sms = file_get_contents("$site/core/clickmail/sendsms.php?email=$email&smsid=$smsid&site=$site&pass_admin=$password&country_code=$country_code&pass_staff=$pass&school_id=$school_id&mobile=$phone");
    // $Text = "Dear+Sir+/+Ma'am,+".$school_name_new."+is+pleased+to+inform+that+you+are+part+of+SmartCookie+Student/Teacher+Rewards+Program+as+".$user_new."+and+".$user_new."+Staff+Credentials+for+".$user_new."+:+Your+Username+is:+".$email."+Your+Password+is:+".$password."+Credentials+for+".$user_new."+Staff+:+Your+Username+is:+".$email."+Your+School+ID+is:+".$school_id."+Your+Password+is:+".$pass."+".$site;

    //     if($country_code=='91')
    //     {
    //         $sms_sql = mysql_query("SELECT * FROM tbl_otp WHERE id='1'");
    //         $sms = mysql_fetch_assoc($sms_sql);
    //         $sms_user = $sms['mobileno'];
    //         $sms_password = $sms['email'];
    //         $sms_sender = 'SCRMSG';

    //             $url = "http://www.smswave.in/panel/sendsms.php?user=$sms_user&password=$sms_password&sender=$sms_sender&PhoneNumber=$phone&Text=$Text";
    //              $msg = file_get_contents($url);
    //     } 
    //     else if($country_code=='1')
    //     {
    //             $ApiVersion = "2010-04-01";

    //             // set our AccountSid and AuthToken

    //             $AccountSid = "ACf8730e89208f1dfc6f741bd6546dc055";
    //             $AuthToken = "45e624a756b26f8fbccb52a6a0a44ac9";

    //             // instantiate a new Twilio Rest Client

    //             $client = new TwilioRestClient($AccountSid, $AuthToken);
    //             $number = "+1" . $phone;
    //             $response = $client->request("/$ApiVersion/Accounts/$AccountSid/SMS/Messages", "POST", 
    //                 array(                                                      "To" => $number,
    //                     "From" => "732-798-7878",
    //                     "Body" => $Text
    //                     ));
    //     }
               //access permission to staff
                $sql_access = mysql_query("SELECT menu_key FROM tbl_menu WHERE entity_type='$entity_id'");
                if(mysql_num_rows($sql_access) > 0) 
                {
                    $key = array();
                        while($access = mysql_fetch_assoc($sql_access))
                        {
                           $key[] = $access['menu_key'];
                        }
                        
                    $permission = implode(',' ,$key);

                    $insert_access = mysql_query("INSERT INTO tbl_permission (`school_id`, `s_a_st_id`, `school_staff_name`, `permission`, `current_date`) VALUES ('$school_id','$staff_id','$stf_name','$permission','$dates')");

                }

                echo "<script>alert('Successfully Added New HR Admin and Staff');window.location.href='addorganisation.php'</script>";
                    
            }                                
            
        } else if ($user_type == 4) {

            $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%&*_";
            $password = $sp_name . "123";

           

            $prepAddr = str_replace(' ', '+', $address);

            $geocode = file_get_contents('http://maps.google.com/maps/api/geocode/json?address=' . $prepAddr . '&sensor=false');
            $output = json_decode($geocode);
            $lat = $output->results[0]->geometry->location->lat;
            $long = $output->results[0]->geometry->location->lng;


            $sqls = "INSERT INTO `tbl_sponsorer`(sp_name,sp_address,sp_city,sp_country,sp_state,sp_email,lat,lon,sp_password,v_category,sp_date,entity_id,v_responce_status,calculated_lat,calculated_lon,sp_phone,payment_method,amount,platform_source,CountryCode) VALUES ('$company_name','$address','$city','$country','$state','$email','$calculated_lat','$calculated_lon','$password','$category','$dates','113','Interested','$cal_lat','$cal_lon','$phone','$payment_method','$amount','cookieadmin web','$country_code')";

            $count = mysql_query($sqls) or die(mysql_error());

            //retrive current inserted record id
            $arr = mysql_query("select id from tbl_sponsorer ORDER BY id DESC limit 1");
            $result = mysql_fetch_array($arr);

            if ($count >= 1)
            {
                $site=$_SERVER["HTTP_HOST"];
                $msgid="welcomesponsor";
            
                $res = file_get_contents("http://$site/core/clickmail/sendmail.php?email=$email&msgid=$msgid&site=$site&pass=$password");
      
                header("Location:addschool2.php?user_type=" . $user_type . "& id=" . $result['id']);

                //Changes end
            }
        } else {
            echo "Please select User Type";
        }
    }
}

?>

<body>
<div id="head"></div>
<div id="login">

    <form action="" method="post">
        <div class='container' style="padding-top:20px;">
            <div class='panel panel-primary dialog-panel'
                 style="background-color:radial-gradient(ellipse at center center , #E5E5E5 0%, #FFF 100%) repeat scroll 0% 0% transparent;">
                <div style="color:red;font-size:15px;font-weight:bold;margin-top:10px;background-color:radial-gradient(ellipse at center center , #E5E5E5 0%, #FFF 100%) repeat scroll 0% 0% transparent;"
                     align="center"> <?php echo $report."<br>".$report1; ?></div>
                <div class='panel-heading' style="background-color:radial-gradient(ellipse at center center , #E5E5E5 0%, #FFF 100%) repeat scroll 0% 0% transparent;">
                <!-- Title School/Sponsor Registration & Add Excel Sheet modified by Pranali -->
                    <h3 align="center">HR/Sponsor Registration</h3>
                    <p align="center"><a href="Add_school_dataexcel.php"><font color="white">Add Excel Sheet</font></a></p>


                </div>
                <div class='panel-body'>
                    <form class='form-horizontal' role='form' method="post">
                        <div class="row form-group">
                            <label class='control-label col-md-3 col-md-offset-1'>User Type<span class="error"><b> * </b></span></label>
                            <div class='col-md-3'>
                                <div class='form-group internal '>
                                    <select required name="entity" id='entity' class='form-control'>
                                        <?php if (isset($_POST['entity'])) {
                                            if ($_POST['entity'] == "1") {
                                                ?>
                                                <option value="1" selected="selected">HR</option>
                                                <option value="4">Sponsor</option>
                                            <?php }
                                            if ($_POST['entity'] == "4") {
                                                ?>
                                                <option value="1">HR</option>
                                                <option value="4" selected="selected">Sponsor</option>
                                                <?php
                                            }
                                        } else { ?>
                                            <option value="1" selected="selected">HR</option>
                                            <option value="4">Sponsor</option><?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>


                        <div class="row form-group">
                            <label class='control-label col-md-3 col-md-offset-1'> Name<span class="error"><b> * </b></span></label>
                            <div id="catList"></div>

                            <div class='col-md-3'>
                                <div class='form-group internal '>
                                    <input class='form-control' id='id_first_name' name="id_first_name"
                                           placeholder='Admin First Name' type='text'
                                           value="<?php if (isset($_POST['id_first_name'])) {
                                               echo $_POST['id_first_name'];
                                           } ?>" maxlength="25" autocomplete="off">
                                </div>
                            </div>

                            <div class='col-md-3 indent-small'>
                                <div class='form-group internal '>
                                    <input class='form-control' id='id_last_name' name="id_last_name"
                                           placeholder='Admin Last Name' type='text'
                                           value="<?php if (isset($_POST['id_last_name'])) {
                                               echo $_POST['id_last_name'];
                                           } ?>" maxlength="25" autocomplete="off">
                                </div>
                            </div>

                            <div class='col-md-3'></div>
                            <div class='col-md-3 ' id="errorname" style="color:#FF0000" align="center"></div>
                        </div>
                        <div class="row form-group" id="catdiv">
                            <label class='control-label col-md-3 col-md-offset-1'>Category</label>
                            <div class='col-md-3'>
                                <div class='form-group internal'>
                                    <select  name="category" id='category' class='form-control'>
                                        <option value="" disabled selected="selected">Select Category</option>
                                        <?php
                                        $sql = mysql_query("SELECT * FROM  `categories` ");
                                        while ($cat = mysql_fetch_assoc($sql)) {
                                            ?>
                                            <option value="<?php echo $cat['id'] ?>" <?php
                                                if($_POST['category']==$cat['id'])
                                                    echo "selected";
                                                else
                                                     echo "";
                                                    ?>><?php echo $cat['category']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <!--<div  id="errorcat" style="color:#FF0000" align="center">      -->
                            </div>
                            <div id="errorcat" style="color:#FF0000" align="center"></div>
                        </div>
    
                        <div class="row form-group" id="school_id1">
                            <label class='control-label col-md-3 col-md-offset-1'>Organization ID<span class="error"><b> * </b></span></label>
                            <div class='col-md-3'>
                                <div class='form-group internal'>
                                    <input type="text"  name="school_id" id='school_id' class='form-control' placeholder='Enter Organization ID' maxlength="20" value="<?php if (isset($_POST['school_id'])) {
                                               echo $_POST['school_id'];
                                           } ?>" autocomplete="off">
                                       
                                </div>
                                <!--<div  id="errorcat" style="color:#FF0000" align="center">      -->
                            </div>
                            <!-- <div id="errorcat" style="color:#FF0000" align="center"></div>-->
                        </div>
                        
                        <div class="row form-group" id="sc_school_name1">
                            <label class='control-label col-md-3 col-md-offset-1'>Organization Name<span  class="error"><b> * </b></span></label>
                            <div class='col-md-3'>
                                <div class='form-group internal'>
                                    <input class='form-control ' id='sc_school_name' name="sc_school_name" placeholder='Enter Organization Name' maxlength="80" value="<?php if (isset($_POST['sc_school_name'])) {
                                               echo $_POST['sc_school_name'];
                                           } ?>" autocomplete="off">
                                       
                                </div>
                                <!--<div  id="errorcat" style="color:#FF0000" align="center">      -->
                            </div>
                            <!-- <div id="errorcat" style="color:#FF0000" align="center"></div>-->
                        </div>
                    
                        <span class="error"> <?php echo "$Err";?></span><br>
                        
                            
                        <div class="row form-group" id="school_type1">
                            <label class='control-label col-md-3 col-md-offset-1'>Organization Type<span class="error"><b> * </b></span></label>
                            <div class='col-md-3'>
                                <div class='form-group internal'>
                                    <select  name="school_type" id='school_type' class='form-control'  >
                                        <!--                                        <option value="" disabled selected="selected">Select Type</option>-->
                                        <option value="">Select</option>
                                        
                                        <option value="organization" <?php if($_POST['school_type']=="organization") echo "selected";?>>Organization</option>
                                       
                                        
                                    </select>
                                </div>
                                <!--<div  id="errorcat" style="color:#FF0000" align="center">      -->
                            </div>
                            <!-- <div id="errorcat" style="color:#FF0000" align="center"></div>-->
                        </div>  
                            
                        <div class="row form-group" id="payment_method">
                            <label class='control-label col-md-3 col-md-offset-1'>Payment Method</label>
                            <div class='col-md-3'>
                                <div class='form-group internal'>
                                    <select  name="method" id='method' class='form-control'>
                                      <option value="" disabled selected="selected">Select Method</option>
                                        <option value="free" 
                                        <?php 
                                            if($_POST['method']=="free")
                                                echo "selected";
                                            else echo "";   
                                        ?>>Free</option>
                                           <option value="Cash" 
                                           <?php 
                                            if($_POST['method']=="Cash")
                                                echo "selected";
                                            else echo "";
                                        ?>>Cash</option>
                                              <option value="Cheque" 
                                              <?php 
                                            if($_POST['method']=="Cheque")
                                                echo "selected";
                                            else echo "";   
                                        ?>>Cheque</option>
                                        
                                    </select>
                                        
                                   
                                        
                                        
                                   
                                </div>
                                
                                
                                
                                <!--<div  id="errorcat" style="color:#FF0000" align="center">      -->
                            </div>
                           <!-- <div id="errorcat" style="color:#FF0000" align="center"></div>-->
                        </div>

                       <!-- <div class="row form-group" id="datediv">



                            <label class='control-label col-md-3 col-md-offset-1'>Date Of Birth</label>

                            <div class='col-md-3'>
                                <div class='form-group internal'>

                                    <input type="text" class='form-control' placeholder="Date of Birth" name="dob"
                                           id="example1" value="<?php if (isset($_POST['dob'])) {
                                        echo $_POST['dob'];
                                    } ?>">
                                </div>
                            </div>
                        </div>-->
                        <div class='row form-group' id="amount">
                            <label class='control-label col-md-3 col-md-offset-1'> Enter Amount</label>
                            <div class='col-md-3 form-group internal'>
                               <input type="text" name="amount" value="<?php if (isset($_POST['amount'])) {
                                               echo $_POST['amount'];
                                           } ?>" autocomplete="off">
   
                            
                            </div>

                            <!--<div class='col-md-3 indent-small' id="errorphone" style="color:#FF0000"></div>-->

                        </div>
                        

                        <div class='row form-group' id='genderdiv'>
                            <label class='control-label col-md-3 col-md-offset-1'>Gender<span class="error"><b> * </b></span></label>
                            <?php if (isset($_POST['gender1'])) {
                                if ($_POST['gender1'] == "Male") {
                                    ?>
                                    <div class='col-md-1'>
                                        Male <input type="radio" name="gender1" id="gender1" value="Male" checked>
                                    </div>
                                    <div class='col-md-2'>
                                        Female <input type="radio" name="gender1" id="gender2" value="Female">
                                    </div>
                                <?php } else {
                                    ?>
                                    <div class='col-md-1'>

                                        Male <input type="radio" name="gender1" id="gender1" value="Male">
                                    </div>
                                    <div class='col-md-2'>
                                        Female <input type="radio" name="gender1" id="gender2" value="Female" checked>
                                    </div>
                                    <?php
                                }
                            } else {
                                ?>
                                <div class='col-md-1'>

                                    Male <input type="radio" name="gender1" id="gender1" value="Male">
                                </div>
                                <div class='col-md-2'>
                                    Female <input type="radio" name="gender1" id="gender2" value="Female">
                                </div>
                            <?php } ?>
                            <div class='col-md-2 indent-small' id="errorgender" style="color:#FF0000"></div>
                        </div>
                        <div class='row form-group'>
                            <label class='control-label col-md-3 col-md-offset-1'>Email ID<span class="error"><b> * </b></span></label>
                            <div class='col-md-3 form-group internal'>
                                <input class='form-control' id='id_email' name="id_email" placeholder='Email ID'
                                       type='text' value="<?php 
                                    if($report!=''){
                                        echo '';
                                    }
                                    else if (isset($_POST['id_email'])) {
                                        echo $_POST['id_email'];
                                    } ?>" maxlength="55" autocomplete="off"><!-- required onBlur="return validemail()"-->
                            </div>
                            <div class='col-md-3 indent-small' id="erroremail" style="color:#FF0000"></div>
                        </div>
                        
                        
                        <div class='row form-group'>
                            <label class='control-label col-md-3 col-md-offset-1'>Country Code</label>
                            <div class='col-md-3 form-group internal'>
                                <select id="country-code" name="country-code" style="width:92%;" class="form-control">
                                 <div class="col-md-3">
             
             
             <option value="select">Select Country Code</option>
             <?php
             
             $query=mysql_query("select calling_code,country from tbl_country where calling_code !='' ");
             while($result=mysql_fetch_array($query))
             {?>
             
             
               <option value=<?php echo $result['calling_code'];?>><?php echo $result['calling_code']."  -  ".$result['country'];?></option>
             
             <?php }?>
             
             </select>
             </div>
                            <!--    
                                <option value="91">91</option>
                                <option value="1" >1</option>
   -->
                                

                            <!--<div class='col-md-3 indent-small' id="errorphone" style="color:#FF0000"></div>-->

                        </div>
                        
                    </div>  
                        


                        <div class='row form-group'>
                            <label class='control-label col-md-3 col-md-offset-1'>Mobile No.<span class="error"><b> * </b></span></label>
                            <div class='col-md-3 form-group internal'>
                                <input class='form-control' id='id_phone' name="id_phone" placeholder='Enter Mobile No.'
                                       type='text' onChange="PhoneValidation(this);"
                                       value="<?php if (isset($_POST['id_phone'])) {
                                           echo $_POST['id_phone'];
                                       } ?>" maxlength="15" required autocomplete="off">
                            </div>

                      <!--      <div class='col-md-3 indent-small' id="errorphone" style="color:#FF0000"></div>    -->

                        </div>
                        <div class="row form-group">
                            <label class='control-label col-md-3 col-md-offset-1'>Address</label>
                            <div class='col-md-3 '>
                                <textarea class='form-control' id='id_address' name="address" placeholder='Address' rows='3' maxlength="100" required value="<?php if ($_POST['address']!='') {
                                           echo $_POST['address'];
                                       } ?>" required autocomplete="off"> </textarea>
                            </div>
                            <div class='col-md-2 indent-small' id='erroraddress' style="color:#FF0000"></div>
                        </div>


                        <div class='row form-group'>
                            <label class='control-label col-md-3 col-md-offset-1'>Country<span class="error"><b>  </b></span></label>
                            <div class='col-md-3'>
                                <select id="country" name="country" class='form-control' style="width:100%;"
                                        value=" <?php if (isset($_POST['country'])) {
                                            echo $_POST['country'];
                                        } ?>"></select>
                            </div>


                            <div class='col-md-3 indent-small' id="errorcountry" style="color:#FF0000"></div>
                        </div>

                        <div class='row form-group'>
                            <label class='control-label col-md-3 col-md-offset-1'>State<span class="error"><b>  </b></span></label>
                            <div class='col-md-3'>
                                <select name="state" id="state" class='form-control' style="width:100%;"
                                        value=" <?php if (isset($_POST['state'])) {
                                            echo $_POST['state'];
                                        } ?>"></select>
                            </div>
                            <div class='col-md-3 indent-small' id="errorstate" style="color:#FF0000">
                            </div>
                        </div>

                        <script language="javascript">
                            populateCountries("country", "state");
                            populateCountries("country2");
                        </script>

                        <div class='row form-group'>
                            <label class='control-label col-md-3 col-md-offset-1' for='id_accomodation'>City<span class="error"><b>  </b></span></label>
                            <div class='col-md-3'>
                                <input type="text" class='form-control' id='id_city' name="city"  maxlength="50" required
                                       value=" <?php if (isset($_POST['city'])) {
                                           echo $_POST['city'];
                                       } ?>" autocomplete="off">
                            </div>
                            <div class='col-md-3 indent-small' id="errorcity" style="color:#FF0000">

                            </div>
                        </div>

                        <div class='row form-group'>
                            <div class='col-md-2 col-md-offset-4'>
                                <input class='btn-lg btn-primary' type='submit'  value="Submit" name="submit"
                                       onClick="return valid()"/>
                            </div>
                            <div class='col-md-3'>
                                <a href="addorganisation.php">
                                    <button class='btn-lg btn-danger' type='Reset'>Reset</button>
                                </a>
                            </div>
                        </div>

                    </form>
                </div>
</body>
</html>