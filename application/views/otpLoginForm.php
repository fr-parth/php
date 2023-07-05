<?php 
/*Created by Rutuja Jori for SMC-4936 for Login with OTP functionality on 04-11-2020*/
//Updated by Rutuja for design changes for SMC-4941 on 06-11-2020
 $webHost = $_SESSION['webHost'];
 $isSmartCookie=$_SESSION['isSmartCookie'];

error_reporting(0);
$uri = explode('/', $_SERVER['REQUEST_URI']);

$entity_otp=$uri[3];
/*Below session added for checking wether logging in is via Forgot Password or Login with OTP by Rutuja for SMC-5036 on 19-12-2020
session_start();
$forgot_password=$uri[4];
$_SESSION['forgot_password']=$forgot_password;*/

if($entity_otp==105){
  $entity_name= "Student";
}
else if($entity_otp==205){
  $entity_name= "Employee";
}
else if($entity_otp==103){
  $entity_name= "Teacher";
}
else if($entity_otp==203){
  $entity_name= "Manager";
}
else if($entity_otp=='sponsor'){
  $entity_name= "Sponsor";
}

?>


<!DOCTYPE html>
<html>
<head>
 
 <meta charset="utf-8">
    <title>Login</title>
     <link href="<?php echo base_url();?>Assets/vendors/bootstrap/css/bootstrap.css" rel="stylesheet">
  <script src="<?php echo base_url();?>Assets/js/jquery-1.11.1.min.js"></script>
  <script src="<?php echo base_url();?>Assets/vendors/bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
<script>
    $(document).ready(function () {
        if (navigator.geolocation) {

            navigator.geolocation.getCurrentPosition(showPosition);

        } else {

            x.innerHTML = "Geolocation is not supported by this browser.";

        }
    });

    function showPosition(position) {

        document.getElementById("lat").value = position.coords.latitude;

        document.getElementById("lon").value = position.coords.longitude;

    }

</script>

<style>
    body {
        background-color: #cdcdcd;
    }

    .padtop100 {
        padding-top: 100px;
    }

    .padtop10 {
        padding-top: 10px;
    }

    .bg-red {
        background-color: #F0483E;
    }

    .red {
        color: #f00;
    }

    .color-white {
        color: white;
    }

    .panel {
        border-radius: 10px;
        box-shadow: 10px 10px 5px #888888;
    }

    .title-text {
        padding-top: 10px;
        padding-bottom: 10px;
    }

    .form-content {
        padding-top: 10px;
    }

    .no-top-padding {
        padding-top: 0px;
    }
</style>
</head>
<body>

    <form name="frmRegistration" method="post" action="">
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
                        <span class='panel-title color-white'><?php echo $entity_name; ?> Login</span>
                    </div><br>
           <div class='row form-content'>
      
                 <div align="center"> <span style="color:red;font-size: 15px;margin-left: -100px">Get OTP By : </span>&nbsp <input type="radio" name="myCheck" id="myCheck" value="emailid" onclick="myFunction()" required /> Email-ID
                    &nbsp <input type="radio" name="myCheck" id="myCheck1" value="phoneno" onclick="myFunction1()" required/> Phone Number 
                </div>
        <div class='col-md-8 indent-small' id="errorredio" style="color:#FF0000"></div>
      
        <div class='col-md-12' id="myDIV" style="display:none"><br>
        <label style="margin-left: 5px"><b>Email-ID</b></label>
        <input type="text" class="form-control" autocomplete="off" name="email" id="email" placeholder="Enter Email-ID" style="width: 380px;">
        <div class='col-md-10 indent-small' id="erroremail" style="color:#FF0000"></div>
                  </div>
          
      <!--    <div class='col-md-12' id="myDIV1" style="display:none">
          <div class='col-md-3'>
                                    <select name='CountryCode' id='CountryCode' class='form-control'>
                                      <option value='+91'>+91</option>
                    <option value='+1'>+1</option>
                                    </select>
                                </div>
          <div class='col-md-8'>
        <label><b>Phone Number</b></label>
        <input type="text" class="demo-input-box" autocomplete="off" name="phone" id="phone" placeholder="Enter Phone Number">
        
                  </div>
          </div> -->
            
          <div id="myDIV1" style="display:none;margin-left: 20px">
        <br><label style="margin-left: 5px"><b>Phone Number</b></label>
        <select name="CountryCode" id="CountryCode" class="form-control" style="width: 30%;" >
  
  <option data-countryCode="IN" value="+91" Selected>India(+91)</option>
  <option data-countryCode="US" value="+1">USA(+1)</option>

</select> 
<div style="margin-top:-34px;margin-left: 145px ">
        <input type="number" style="width: 89%;" class="form-control " name="phone" id="phone" placeholder="Enter Phone Number" >
        <div class='col-md-10 indent-small' id="errorphone" style="color:#FF0000"></div>
      </div>
                  </div>
          
                  <div>
          
          <input type="hidden" name="ent_type" id="ent_type" value="<?php echo $entity_otp; ?>" >
                </div> 
        <div class='col-md-3 indent-small' id="errorentity" style="color:#FF0000"></div>        
                </div>   
                <br>
                 <?php if($entity_otp!='sponsor'){ ?>  
                <div id="school">
           <label style="margin-left: 5px"><b> <?php if($entity_otp==105 || $entity_otp==103){ echo "School"; }else{ echo "Organization"; } ?>-ID</b></label><br><br><br>
           <div style="width: 380px;margin-left: 1px;margin-top: -30px;"> 
        
        
        <input type="text"  autocomplete="off" name="school_name" id="school_name" class="form-control" placeholder="Enter <?php if($entity_otp==105 || $entity_otp==103){ echo "School";}else{echo "Organization";} ?>-ID" required>
        <div>
                <div class='col-md-10 indent-small' id="errorschool" style="color:#FF0000"></div>                
                </div>     
                </div>
                </div>      
                
                 <?php } ?>             
                </div>             
        <br><br>
 
       
        <script>
function myFunction() {
  var x = document.getElementById("myDIV");
  var y = document.getElementById("myDIV1");
    x.style.display = "block";
    y.style.display = "none";
}
</script>
<script>
function myFunction1() {
  var x = document.getElementById("myDIV1");
    var y = document.getElementById("myDIV");
    x.style.display = "block";
    y.style.display = "none";
}
</script>
<script>
function valid() { 
var myCheck = document.getElementById("myCheck").checked;
var myCheck1 = document.getElementById("myCheck1").checked;
if(myCheck==false && myCheck1==false)
{
document.getElementById('errorredio').innerHTML='Please select radio button value';
 return false;  
}
else if(myCheck==true)
{
  document.getElementById('errorredio').innerHTML='';
  var email = document.getElementById("email").value;
        var pattern = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
       
     if(email.trim()=="" || email.trim()==null){
     document.getElementById('erroremail').innerHTML='Please enter the Email ID';
     
    return false;
        }
       else if (pattern.test(email)) {
           document.getElementById('erroremail').innerHTML='';
        }
        else{
      
        document.getElementById('erroremail').innerHTML='Please enter valid email id';
        return false;
        }

}
else
{
  document.getElementById('errorredio').innerHTML='';
var phone = document.getElementById("phone").value;
        var pattern = /^[0123456789]\d{9}$/;
        if(phone.trim()=="" || phone.trim()==null){
    document.getElementById('errorphone').innerHTML='Please enter Phone Number';
    return false;
        }
       else if (pattern.test(phone)) {
           document.getElementById('errorphone').innerHTML='';
        }
        else{
        document.getElementById('errorphone').innerHTML='Please enter Valid Phone Number';
    
        return false;
        }
}


    
    var ent_type=document.getElementById("ent_type").value;

    if(ent_type==null || ent_type=="")

    {

    document.getElementById('errorentity').innerHTML='Please select Entity Type';

        

        return false;

    }

        var school_name=document.getElementById("school_name").value;

      if(school_name==null || school_name=="")

        {

        document.getElementById('errorschool').innerHTML='Please enter School/Organization';

                

                return false;

        }

  
    
}
</script>


                <div style="margin-left: 10px;">

<?php 
                  echo form_submit('submit', 'Submit','class="btn btn-primary" id="submit" onclick=" return OTPLoginForm();"');
                ?>

                    
            <a href="<?php echo base_url();?>Clogin/login/<?php echo lcfirst($entity_name); ?>" style="text-decoration:none;"> <input type="button"  class="btn btn-danger" name="Back" value="Back"/></a>
              </div>
            <br>
              <meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>

/* style inputs and link buttons */
input,
.btn {

  opacity: 0.90;
  
  text-decoration: none; /* remove underline from anchors */
}


/* add appropriate colors to fb and google buttons */
.fb {
  background-color: #3B5998;
  color: white;
}

.google {
  background-color: #dd4b39;
  color: white;
}

}
</style>
            
              
            </div>
          </div>
        </div>
      </div>


    </form>
</body>
</html>

