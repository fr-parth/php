<!DOCTYPE html>
<?php
//Below variables added for Protsahan-Bharati by Rutuja Jori on 19/07/2019
 $webHost = $_SESSION['webHost'];
 $isSmartCookie=$_SESSION['isSmartCookie'];
?>
<html>
<head> 
    <meta charset="utf-8">
    <title>Login</title>
    <link href="<?php echo base_url();?>Assets/vendors/bootstrap/css/bootstrap.css" rel="stylesheet">
    <script src="<?php echo base_url();?>Assets/js/jquery-1.11.1.min.js"></script>
    <script src="<?php echo base_url();?>Assets/vendors/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/85bec2338d.js" crossorigin="anonymous"></script>   
</head>
<body>
<style>
body{
    background-color:#cdcdcd;
}
.padtop100{
    padding-top:100px;
}
.padtop10{
    padding-top:10px;   
}
.bg-red{
    background-color:#F0483E;
}
.red{
    color:#f00;
}
.color-white{
    color:white;
}
.panel{
    border-radius:10px; 
    box-shadow: 10px 10px 5px #888888;
}
.title-text{
    padding-top:10px;
    padding-bottom:10px;    
}
.form-content{
    padding-top:10px;
}
.no-top-padding{
    padding-top:0px;
}

#Password{
    position:  relative;
}
.fas{
    position: absolute;
    right: 20px;
    bottom: 186px;
    cursor: pointer;
    opacity: 0.5;
} 
.fas:hover{
    opacity: 1;
}
.fas:active{
    transform: scale(0.9);
}
</style>
<script>
$(document).ready(function(){
    //EmailInput
    //NumberInput
    //OrganisationInput
    //PhoneInput
    //SocialLogin
    //PasswordInput
    //SubmitInput
    //ForgotPassord

    
        var user='<?php echo @$entity; ?>';

    $("#OptEmailID").hide();
    $("#OptEmployeeID").hide();
    $("#OptPhoneNumber").hide();
    
    switch(user){
        case 'student':
    $("#OptEmailID").show();
    $("#OptEmployeeID").show();
    $("#OptPhoneNumber").show();        
            break;
    case 'teacher':
    $("#OptEmailID").show();
    $("#OptEmployeeID").show();
    $("#OptPhoneNumber").show();        
    break;
    case 'manager':
    $("#OptEmailID").show();
    $("#OptEmployeeID").show();
    $("#OptPhoneNumber").show();        
    break;
            case 'employee':
    $("#OptEmailID").show();
    $("#OptEmployeeID").show();
    $("#OptPhoneNumber").show();        
            break;      
        case 'sponsor':
    $("#OptEmailID").show();
    $("#OptEmployeeID").hide();
    $('select option[value=EmployeeID]').attr('disabled', 'disabled').hide();
    $("#OptPhoneNumber").show();            
            break;  
        case 'salesperson':
    $("#OptEmailID").show();
    $("#OptEmployeeID").hide();
    $("#OptPhoneNumber").show();            
            break;  
        
        default:
    $("#OptEmailID").hide();
    $("#OptEmployeeID").hide();
    $("#OptPhoneNumber").hide();
            break;
    }
    
    $("#EmailInput").hide();
    $("#NumberInput").hide();
    $("#OrganisationInput").hide();
    $("#PhoneInput").hide();
    $("#SocialLogin").hide();
    
    $("#PasswordInput").hide();
    $("#SubmitInput").hide();
    $("#ForgotPassord").hide(); 
    

    
    function loginHideShow(LoginOption){
                switch(LoginOption){
            case 'SocialLogin': 
                    $("#EmailInput").hide();
                    $("#NumberInput").hide();
                    $("#OrganisationInput").hide();
                    $("#PhoneInput").hide();
                    $("#SocialLogin").show();                   
                    $("#PasswordInput").hide();
                    $("#SubmitInput").hide();
                    $("#ForgotPassord").hide();     
                    $("#MemberID").hide();
                    $("#PasswordInput").removeClass("padtop10");
                break;
            case 'EmailID': 
                    $("#EmailInput").show();
                    $("#NumberInput").hide();
                    
                        var user='<?php echo @$entity; ?>';
                        switch(user){
                            case 'student':
                        $("#OrganisationInput").show();
                                break;
                        case 'teacher':
                            $("#OrganisationInput").show();
                            break;
                        case 'manager':
                            $("#OrganisationInput").show();
                            break;  
                        case 'employee':
                            $("#OrganisationInput").show();
                            break;
                        default:
                        $("#OrganisationInput").hide();
                                break;
                        }   
                    
                    $("#PhoneInput").hide();
                    $("#SocialLogin").hide();                   
                    $("#PasswordInput").show();
                    $("#SubmitInput").show();
                    $("#ForgotPassord").show(); 
                    $("#MemberID").hide();
                    $("#PasswordInput").removeClass("padtop10");
                break;  
            case 'EmployeeID':  
                    $("#EmailInput").hide();
                    $("#NumberInput").show();
                    $("#OrganisationInput").show();
                    $("#PhoneInput").hide();
                    $("#SocialLogin").hide();                   
                    $("#PasswordInput").show();
                    $("#SubmitInput").show();
                    $("#ForgotPassord").show(); 
                    $("#MemberID").hide();
                    $("#PasswordInput").removeClass("padtop10");
                break;          
            case 'PhoneNumber': 
                    $("#EmailInput").hide();
                    $("#NumberInput").hide();
    /*Start changes */          
                    //$("#OrganisationInput").hide();
                        
                    var user='<?php echo @$entity; ?>';
                    switch(user){
                    case 'student':
                    $("#OrganisationInput").show();
                    break;
                    case 'teacher':
                    $("#OrganisationInput").show();
                    break;
                    case 'manager':
                    $("#OrganisationInput").show();
                    break;
                    case 'employee':
                    $("#OrganisationInput").show();
                    break;
                    default:
                    $("#OrganisationInput").hide();
                    break;
                    }
        /*End*/         
                    $("#PhoneInput").show();
                    $("#SocialLogin").hide();                   
                    $("#PasswordInput").show();
                    $("#SubmitInput").show();
                    $("#ForgotPassord").show();
                    $("#MemberID").hide();
                    $("#PasswordInput").addClass("padtop10");
                        
                break;  
            case 'memberId':    
                    $("#EmailInput").hide();
                    $("#NumberInput").hide();
                    $("#OrganisationInput").hide();
                    $("#PhoneInput").hide();
                    $("#SocialLogin").hide();                   
                    $("#PasswordInput").show();
                    $("#SubmitInput").show();
                    $("#ForgotPassord").show();
                    $("#MemberID").show();
                    
                    $("#PasswordInput").addClass("padtop10");
                        
                break;                  
        }
    }
    
    var LoginOption=$("#LoginOption").val();
    loginHideShow(LoginOption); 
    
    $("#LoginOption").change(function(){
        var LoginOption=$("#LoginOption").val();
        loginHideShow(LoginOption);
    }); 
    
        getLocation();
});
</script>
<script>
function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else {
        x.innerHTML = "Geolocation is not supported by this browser.";
    }
}
function showPosition(position) {
    $("#lat").val(position.coords.latitude);
    $("#lon").val(position.coords.longitude);
}

function resetReport()
{
    document.getElementById('Report').innerHTML="";
}
</script>
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-FBDC0Z3FQJ"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-FBDC0Z3FQJ');
</script>
    <div class='container-fluid bgcolor'>
        <div class='row'>
            <div class='col-md-4 col-md-offset-4 padtop100'>
                <div class='panel panel-primary'>                       
                    <div class='panel-body'>                                        
                        <div class='row text-center'>                           
                            <?php if($isSmartCookie) {  ?>                      
                            <div class="visible-sm visible-lg visible-md">
                                <img src="<?php echo base_url();?>Assets/images/logo/250_86.png" />
                            </div>
<?php  }else{   ?>
                            
                            <div class="visible-sm visible-lg visible-md">
                                <img src="<?php echo base_url();?>Assets/images/logo/pblogoname.jpg" />
                            </div>
<?php } ?>
                            <div class="visible-xs">
                                <img src="<?php echo base_url();?>Assets/images/logo/220_76.png" />
                            </div>
                        </div>
                        <div class='row bg-red text-center title-text'>
                            <span class='panel-title color-white'><?php echo ucfirst(@$entity); ?> Login</span>
                        </div>
                        <div class='row form-content' id='ct'>                      
                        <?php echo form_open('Clogin/login_validation');?>
                            <div class='col-md-12'>
                            <div class='form-group'>
                                <label for='LoginOption' >Login With</label>
                                        <select name='LoginOption' id='LoginOption' class='form-control' onfocus="resetReport()">
                                            <option id='OptEmailID' value='EmailID' <?php if(@$LoginOption=='EmailID'){ echo 'selected';} ?>>Email ID</option>
                                            <option id='OptEmployeeID' value='EmployeeID' <?php if(@$LoginOption=='EmployeeID'){ echo 'selected';} ?>>PRN / EmployeeID</option>
                                            <option id='OptPhoneNumber' value='PhoneNumber' <?php if(@$LoginOption=='PhoneNumber'){ echo 'selected';} ?>>Phone Number</option>
                                            <option id='OptPhoneNumber' value='memberId' <?php if(@$LoginOption=='memberId'){ echo 'selected';} ?>>Member ID</option>
                                            <!--<option value='SocialLogin' <?php if(@$LoginOption=='SocialLogin'){ echo 'selected';} ?>>Social Login</option>-->
                                        </select>
                                
                            </div>
                            <div class='form-group' id='EmailInput'>                                
                                        <input type='text' name='EmailID'  id='EmailID' class='form-control' value='<?php if(isset($_COOKIE["studEmailLoginE"]) && ucfirst(@$entity)=='Student') { echo $_COOKIE["studEmailLoginE"]; } if(isset($_COOKIE["spEmailLoginE"]) && ucfirst(@$entity)=='Sponsor'){ echo $_COOKIE["spEmailLoginE"]; } if(isset($_COOKIE["empEmailLoginE"]) && ucfirst(@$entity)=='Employee'){ echo $_COOKIE["empEmailLoginE"]; } if(isset($_COOKIE["saleEmailLoginE"]) && ucfirst(@$entity)=='Sales Person'){ echo $_COOKIE["saleEmailLoginE"]; } else{echo @$EmailID;} ?>' placeholder='Email ID' onfocus="resetReport()"/>                               
                            </div>
                            <span id='erremail' class='red' style="font-size:16px"></span>
                            
                            <div class='form-group' id='NumberInput'> 
                                        <input type='text' name='EmployeeID' id='EmployeeID' class='form-control' value='<?php if(isset($_COOKIE["studPRNLoginE"]) && ucfirst(@$entity)=='Student') { echo $_COOKIE["studPRNLoginE"]; } if(isset($_COOKIE["spPRNLoginE"]) && ucfirst(@$entity)=='Sponsor'){ echo $_COOKIE["spPRNLoginE"]; } if(isset($_COOKIE["empPRNLoginE"]) && ucfirst(@$entity)=='Employee'){ echo $_COOKIE["empPRNLoginE"]; } if(isset($_COOKIE["salePRNLoginE"]) && ucfirst(@$entity)=='Sales Person'){ echo $_COOKIE["salePRNLoginE"]; }else{echo @$EmployeeID;} ?>' placeholder='PRN / EmployeeID' onfocus="resetReport()"/>    
                            </div>
                            <span id='erremp' class='red' style="font-size:16px"></span>
                            <div class='form-group' id='NumberInput'>
                                        <input type='text' name='MemberID' id='MemberID' class='form-control' value='<?php if(isset($_COOKIE["studMemberLoginE"]) && ucfirst(@$entity)=='Student') { echo $_COOKIE["studMemberLoginE"]; } if(isset($_COOKIE["spMemberLoginE"]) && ucfirst(@$entity)=='Sponsor'){ echo $_COOKIE["spMemberLoginE"]; } if(isset($_COOKIE["empMemberLoginE"]) && ucfirst(@$entity)=='Employee'){ echo $_COOKIE["empMemberLoginE"]; } if(isset($_COOKIE["saleMemberLoginE"]) && ucfirst(@$entity)=='Sales Person'){ echo $_COOKIE["saleMemberLoginE"]; }else{echo @$MemberID;} ?>' placeholder='Member ID' onfocus="resetReport()"/> 
                            </div>
                            <span id='errid' class='red' style="font-size:16px"></span>
                            </div>
                            <div class='form-group' id='PhoneInput'>                                
                                <div class='col-md-3'>                                  
                                        <select name='CountryCode' id='CountryCode' class='form-control'style=" width:103%" onfocus="resetReport()">
                                                <option value='<?php if(isset($_COOKIE["studCCLoginE"]) && ucfirst(@$entity)=='Student') { echo $_COOKIE["studCCLoginE"]; } if(isset($_COOKIE["spCCLoginE"]) && ucfirst(@$entity)=='Sponsor'){ echo $_COOKIE["spCCLoginE"]; } if(isset($_COOKIE["empCCLoginE"]) && ucfirst(@$entity)=='Employee'){ echo $_COOKIE["empCCLoginE"]; } if(isset($_COOKIE["saleCCLoginE"]) && ucfirst(@$entity)=='Sales Person'){ echo $_COOKIE["saleCCLoginE"]; }else{echo '91';} ?>' <?php if(@$CountryCode==91){ echo 'selected';} ?>>+91</option>
                                                <option value='<?php if(isset($_COOKIE["studCCLoginE"]) && ucfirst(@$entity)=='Student') { echo $_COOKIE["studCCLoginE"]; } if(isset($_COOKIE["spCCLoginE"]) && ucfirst(@$entity)=='Sponsor'){ echo $_COOKIE["spCCLoginE"]; } if(isset($_COOKIE["empCCLoginE"]) && ucfirst(@$entity)=='Employee'){ echo $_COOKIE["empCCLoginE"]; } if(isset($_COOKIE["saleCCLoginE"]) && ucfirst(@$entity)=='Sales Person'){ echo $_COOKIE["saleCCLoginE"]; }else{echo '1';} ?>' <?php if(@$CountryCode=='1'){ echo 'selected';} ?>>+1</option>
                                        </select>                                   
                                </div>
                                <div class='col-md-9' style="width:75%" id="phn" >
                                        <input type='text' name='PhoneNumber' id='PhoneNumber' class='form-control' value='<?php if(isset($_COOKIE["studPhoneLoginE"]) && ucfirst(@$entity)=='Student') { echo $_COOKIE["studPhoneLoginE"]; } if(isset($_COOKIE["spPhoneLoginE"]) && ucfirst(@$entity)=='Sponsor'){ echo $_COOKIE["spPhoneLoginE"]; } if(isset($_COOKIE["empPhoneLoginE"]) && ucfirst(@$entity)=='Employee'){ echo $_COOKIE["empPhoneLoginE"]; } if(isset($_COOKIE["salePhoneLoginE"]) && ucfirst(@$entity)=='Sales Person'){ echo $_COOKIE["salePhoneLoginE"]; }else{echo $PhoneNumber;} ?>' placeholder='Phone Number' onfocus="resetReport()"/>
                                        <br>                                        
                                        <span id='errphone' class='red' style="font-size:16px"></span>  
                                </div>  
                                                        
                            </div>
                            <br>
                            
                            <div  class='col-md-12'>
                            <div class='form-group' id='SocialLogin'>
                                        Facebook<br/>
                                        Twitter<br/>
                                        LinkedIn<br/>
                                        Google<br/>                                     
                            </div>
                                
                            <div class='form-group' id='OrganisationInput'>
                                        <input type='text' name='OrganizationID' id='OrganizationID' class='form-control' value='<?php if(isset($_COOKIE["studOrgLoginE"]) && ucfirst(@$entity)=='Student') { echo $_COOKIE["studOrgLoginE"]; } if(isset($_COOKIE["spOrgLoginE"]) && ucfirst(@$entity)=='Sponsor'){ echo $_COOKIE["spOrgLoginE"]; } if(isset($_COOKIE["empOrgLoginE"]) && ucfirst(@$entity)=='Employee'){ echo $_COOKIE["empOrgLoginE"]; } if(isset($_COOKIE["saleOrgLoginE"]) && ucfirst(@$entity)=='Sales Person'){ echo $_COOKIE["saleOrgLoginE"]; }else{echo @$OrganizationID;} ?>' placeholder='Institute ID / Organization ID' onfocus="resetReport()"/>  
                            </div>
                            <span id='errschoolid' class='red' style="font-size:16px"></span>
                            <div class='form-group' id='PasswordInput'>

                                        <input type='password' name='Password' id='Password' class='form-control' value='<?php if(isset($_COOKIE["studPassLoginE"]) && ucfirst(@$entity)=='Student') { echo $_COOKIE["studPassLoginE"]; } if(isset($_COOKIE["spPassLoginE"]) && ucfirst(@$entity)=='Sponsor'){ echo $_COOKIE["spPassLoginE"]; } if(isset($_COOKIE["empPassLoginE"]) && ucfirst(@$entity)=='Employee'){ echo $_COOKIE["empPassLoginE"]; } if(isset($_COOKIE["salePassLoginE"]) && ucfirst(@$entity)=='Sales Person'){ echo $_COOKIE["salePassLoginE"]; }else{ echo @$Password; } ?>' placeholder='Password' onfocus="resetReport()"/><span><i class="fas fa-eye-slash" onclick="myFunction()"></i></span>    
                            </div>
                            <span id='errpass' class='red' style="font-size:16px"></span>
                            <div class='form-group' id='Report'>
                                    <?php echo @$report; ?> 
                            </div>
                            <div class='form-group' id='SubmitInput'>
                                <input type='hidden' name='entity' id='entity' value='<?php echo @$entity;?>'/> 
                                <div><label>

                                        <input type="checkbox" name="remember_me" id="remember_me" <?php if(isset($_COOKIE["studRememberLoginE"]) && ucfirst(@$entity)=='Student') { echo 'checked' ; } if(isset($_COOKIE["spRememberLoginE"]) && ucfirst(@$entity)=='Sponsor'){ echo 'checked' ; } if(isset($_COOKIE["empRememberLoginE"]) && ucfirst(@$entity)=='Employee'){ echo 'checked' ; } if(isset($_COOKIE["saleRememberLoginE"]) && ucfirst(@$entity)=='Sales Person'){ echo 'checked' ; } ?>>
                                        Remember me
                                    </label></div>
                <input type='submit' name='submit' id='submit' class='btn btn-primary' value='Login' onclick="return valid();"/>        
<?php //$server_name = $GLOBALS['URLNAME'];exit; ?>

						<a href="<?php echo base_url();?>" style="text-decoration:none;"> <input type="button"  class="btn btn-danger" name="Back" value="Back"/></a>				
				<input type='hidden' name='lat' id='lat' value='<?php echo @$lat;?>'/>					<input type='hidden' name='lon' id='lon' value='<?php echo @$lon;?>'/>
				
							</div>

                       


<!--Below Login with OTP button added by Rutuja for SMC-4941 on 09-11-2020-->                                                   <?php if($entity!='sponsor' ||  $entity!='salesperson'){ ?>
                            <div class='form-group'>
                                <?php if (@$entity=='employee'){$entity_otp=205;}else if(@$entity=='student'){$entity_otp=105;}else if(@$entity=='teacher'){$entity_otp=103;}else if(@$entity=='manager'){$entity_otp=203;}else if(@$entity=='sponsor'){$entity_otp='sponsor';} ?>
                                <a href="<?php echo base_url();?>LoginOTP/OTPLoginForm/<?php echo @$entity_otp; ?>" style="text-decoration:none;"> <input type="button"  class="btn btn-primary" name="Login with OTP" value="Login with OTP"/></a>

                            </div>
                        <?php } ?>

<!-- user variable passed in /core/forgetpassword.php link by Pranali for bug SMC-3613 -->
<!--Below Login with OTP functionality for Forgot Password added by Rutuja for SMC-5036 on 19-12-2020-->    

<?php if($entity!='sponsor' || $entity!='salesperson'){ ?>  
                            <div class='form-group' id='ForgotPassord'>
                                    <!--<a id="link-forgot-passwd" href="<?php echo base_url();?>/core/forgetpassword.php?user=<?php echo @$entity; ?>">Forgot password?</a>&nbsp-->
                                <?php if (@$entity=='employee'){$entity_otp=205;}else if(@$entity=='student'){$entity_otp=105;}else if(@$entity=='teacher'){$entity_otp=103;}else if(@$entity=='manager'){$entity_otp=203;}else if(@$entity=='sponsor'){$entity_otp='sponsor';} ?>
                                <a href="<?php echo base_url();?>LoginOTP/OTPLoginForm/<?php echo @$entity_otp; ?>" style="text-decoration:none;">Forgot password?</a>
    

                            </div>
                            <?php } ?>
                            </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Script added by Sayali Balkawade for SMC-4866 on 07/10/2020 -->
     <script type="text/javascript">
     
      
function valid() {  
 
 var email_id = document.getElementById("EmailID").value;
 var LoginOption = document.getElementById("LoginOption").value;
        var pattern = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
       if(LoginOption =="EmailID")
       { 
        if(email_id.trim()=="" || email_id.trim()==null){

       document.getElementById("erremail").innerHTML="Please Enter Email ID!";
        return false;
        }

       else if (!pattern.test(email_id)) {
           document.getElementById("erremail").innerHTML="Please Enter Valid Email ID!";
        return false;
        }
        else{
       document.getElementById("erremail").innerHTML='';
       
       }
       }
    if(LoginOption =="PhoneNumber")
       {    
var phone_no = document.getElementById("PhoneNumber").value;
        var pattern = /^[6789]\d{9}$/;
        if(phone_no.trim()=="" || phone_no.trim()==null){

        document.getElementById("errphone").innerHTML="Please Enter Phone Number";

        return false;
        }
       else if (!pattern.test(phone_no)) {
            document.getElementById("errphone").innerHTML="Please Enter valid Phone Number";
        return false;
        }
        else{

         document.getElementById("errphone").innerHTML='';

        }
       }
        if(LoginOption =="memberId")
       {  
var department_id = document.getElementById("MemberID").value;
        var pattern = /^[0-9]+$/;
        
        if(department_id.trim()=="" || department_id.trim()==null){

        document.getElementById("errid").innerHTML="Please Enter Member ID";

        return false;
        }
        
        if (!pattern.test(department_id)) {
           document.getElementById("errid").innerHTML="Please Enter valid Member ID";
        return false;
        }
        else{

         document.getElementById("errid").innerHTML='';

        }
                    
       }

if(LoginOption =="EmployeeID")
       {
var EmployeeID = document.getElementById("EmployeeID").value;
        var pattern = /^[a-zA-Z0-9-_ ]+$/;
if(email_id =='' )
            {
        if(EmployeeID.trim()=="" || EmployeeID.trim()==null){

        document.getElementById("erremp").innerHTML="Please Enter PRN/Employee ID";

        return false;
        }
       else if (!pattern.test(EmployeeID)) {
             document.getElementById("erremp").innerHTML="Please Enter valid PRN/Employee ID";
        return false;
        }
        else{

         document.getElementById("erremp").innerHTML='';

        }
            }
       }
       //Changed below code by chaitali for SMC-5161 on 15-03-2021
       var user='<?php echo @$entity; ?>';
    //alert(user);
       if(user != "sponsor" && user != "salesperson")
       {
         if(LoginOption !="memberId")
       {  
       var OrganizationID = document.getElementById("OrganizationID").value;
        var pattern = /^[a-zA-Z0-9-_ ]+$/;
        if(OrganizationID.trim()=="" || OrganizationID.trim()==null){

         document.getElementById("errschoolid").innerHTML="Please Enter Institute ID/Organization ID";

        return false;
        }else{
        document.getElementById("errschoolid").innerHTML='';    
       }
       }
    }
var Password = document.getElementById("Password").value;
        var pattern = /^[a-zA-Z0-9-_ ]+$/;
        
        if(Password.trim()=="" || Password.trim()==null){

        document.getElementById("errpass").innerHTML="Please Enter Password";

        return false;
        }else {
            document.getElementById("errpass").innerHTML='';
        }
      
}   

$('#LoginOption').change(function(event) {
       document.getElementById("errpass").innerHTML='';
       document.getElementById("errschoolid").innerHTML='';
        document.getElementById("erremail").innerHTML='';
        document.getElementById("errphone").innerHTML='';
        document.getElementById("errid").innerHTML='';
         document.getElementById("erremp").innerHTML='';
}); 

function myFunction() {
            var x = document.getElementById("Password");
            if (x.type === "password") {
                x.type = "text";
            }
            else {
                x.type = "password";  
            } 
        }     
 
</script>
</body>
</html>