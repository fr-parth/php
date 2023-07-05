<?php  
//Updated by Sayali Balkawade for Display Logo and Entity,header ,footer and back button  name on 30/12/2020 for SMC-5058
include 'index_header.php'; ?>
<?php include_once('securityfunctions.php');
error_reporting(0);
//$vphone=$_SESSSION['verifiedEmail'];
//$vemail=$_SESSSION['verifiedPhone'];

?>
<!DOCTYPE html>
<html>
<head>

<title>Registration</title>
<!--<link href="./css/style.css" rel="stylesheet" type="text/css" />-->
<style>
.bgwhite {
            background-color: #dcdfe3;
        }
body {
    font-family: Arial;
    color: #333;
    font-size: 0.95em;


 background-color: #edebe6
 
 
}
input[type=text], input[type=password] {
  width: 100%;
  padding: 15px;
  margin: 1px 0 5px 0;
  border: #0887cc solid;
  border-width: thin;
  display: inline-block;
 
  background: none;
}


.form-head {
    color: #191919;
    font-weight: normal;
    font-weight: 400;
    margin: 10;
    text-align: center;    
    font-size: 1.8em;
  width : 100%;
  
  
}

.error-message {
    padding: 7px 10px;
    background: #fff1f2;
    border: #ffd5da 1px solid;
    color: #d6001c;
    border-radius: 4px;
    margin: 10px 0px 10px 0px;
}

.success-message {
    padding: 7px 10px;
    background: #cae0c4;
    border: #c3d0b5 1px solid;
    color: #027506;
    border-radius: 4px;
    margin: 30px 0px 10px 0px;
}

.demo-table {
    background: #ffffff;
    border-spacing: 100px;
    margin: 200px auto;
    word-break: break-word;
    table-layout: 100px;
    line-height: 1.8em;
    color: #333;
    border-radius: 10px;
    padding: 20px 40px;
    width: 700px;
     border: 2px solid;
    border-color: #e5e6e9 #dfe0e4 #d0d1d5;
    
}


.demo-table .label {
    color: #888888;
}

.demo-table .field-column {
    padding: 2px 0px;
}

.demo-input-box {
    padding: 13px;
    border: #CCC 1px solid;
    border-radius: 4px;
    width: 100%;
}

.btnRegister {
    padding: 13px;
    background-color: #5d9cec;
    color: #f5f7fa;
    cursor: pointer;
    border-radius: 4px;
    width: 50%;
    border: #5791da 1px solid;
    font-size: 1.1em;
}

.response-text {
    max-width: 380px;
    font-size: 1.5em;
    text-align: center;
    background: #fff3de;
    padding: 42px;
    border-radius: 3px;
    border: #f5e9d4 1px solid;
    font-family: arial;
    line-height: 34px;
    margin: 15px auto;
}

.terms {
    margin-bottom: 5px;
}
 select {
        width: 150px;
        margin: 10px;
    height: 30px;
    }
    select:focus {
        min-width: 150px;
        width: auto;

</style>

</head>
<body>
<div class='row bgwhite padtop10'>
    <form name="frmRegistration" method="post" action="">
        <div class="demo-table">
        <div class="form-head">Find Member ID</div>
            </br>
          <div align="center"> <span style="color:red;font-size: 15px;">Verify Using</span>
            <div class="field-column">
      
                 <div align="center">  <input type="radio" name="myCheck" id="myCheck" value="emailid" onclick="myFunction()"/> Email-ID
                    <input type="radio" name="myCheck" id="myCheck1" value="phoneno" onclick="myFunction1()"/>Phone Number 
                </div>
        <div class='col-md-3 indent-small' id="errorredio" style="color:#FF0000"></div>
      
        <div class='col-md-12' id="myDIV" style="display:none">
        <label><b>Email-ID</b></label>
        <input type="text" class="demo-input-box" autocomplete="off" name="email" id="email" placeholder="Enter Emai-ID">
        <div class='col-md-3 indent-small' id="erroremail" style="color:#FF0000"></div>
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
            
          <div id="myDIV1" style="display:none"></br>
        <label><b>Select Country Code  </b></label>
        
        <select name="CountryCode" id="CountryCode" style="margin-right:20px">
  
  <option data-countryCode="IN" value="+91" Selected>India(+91)</option>
  <option data-countryCode="US" value="+1">USA(+1)</option>

</select> </br></br>
<label><b>Phone Number: </b></label>
        <input type="number" style="width: 47%;" class="demo-input-box" name="phone" id="phone" placeholder="Enter Phone Number">
        <div class='col-md-3 indent-small' id="errorphone" style="color:#FF0000"></div>
                  </div>
          
          
          
          
          
            </br>

                  <div>
          
          <label>Select Entity Type</label>
                <select id="ent_type" name="ent_type">
                
                <option value="">Select</option> 
                  <option value="105">Student</option>
                  <option value="103">Teacher</option>
                  <option value="205">Employee</option>
                  <option value="203">Manager</option></select>
                </div> 
        <div class='col-md-3 indent-small' id="errorentity" style="color:#FF0000"></div>        
                </div>             
        
            
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
        document.getElementById('errorphone').innerHTML='Please select Valid Phone Number';
    
        return false;
        }
}


    
    var ent_type=document.getElementById("ent_type").value;

    if(ent_type==null || ent_type=="")

    {

    document.getElementById('errorentity').innerHTML='Please select Entity Type';

        

        return false;

    }

  
    
}
</script>


                <div>
          <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> </br>
                    <input type="submit"
                        name="submit" value="SEND OTP"
                        class="btn btn-success" onClick="return valid()" />

						<?php $server_name = $GLOBALS['URLNAME']; ?>
						<a href="<?php echo $server_name;?>" style="text-decoration:none;"> <input type="button"  class="btn btn-danger" name="Back" value="Back"/></a>
						
                </div>
            </div>

    </form>
  </div>
</body>
</html>

<?php


if (isset($_POST['submit'])) {
  
  
  $email=$_POST['email'];
  $country_code=$_POST['CountryCode'];
  $phone=$_POST['phone'];
  //$phone=$CountryCode.$phone1;
  $entity=$_POST['ent_type'];

  if(empty($email) || empty($phone))
  {
         
$url_cat=$GLOBALS['URLNAME']."/core/api2/api2.php?x=send_otp"; 
$myvars_cat=array(
      'operation'=>"send_otp",
      'phone_number'=>$phone,
      'email_id'=>$email,
      'country_code'=>$country_code,      
      'msg'=>"SMC_LOGIN_OTP",   
      'api_key'=>'cda11aoip2Ry07CGWmjEqYvPguMZTkBel1V8c3XKIxwA6zQt5s'
      
      );
//msg input added by Rutuja for new SMS settings for SMC-5256 on 17-04-2021
      
      $phn=$myvars_cat['phone_number'];
      $email=$myvars_cat['email_id'];
      $res_cat = get_curl_result($url_cat,$myvars_cat);
      
      
      //print_r($myvars_cat);exit;
        
      $responce = $res_cat["responseStatus"];
                  if($responce==200)
                  {
            if($email=='')
            {
              $a=Phone;
            }
            else 
            {
              $a=Email;
            }
      echo ("<script LANGUAGE='JavaScript'>
          window.alert('OTP is Sent to your entered $a ...!!');
          window.location.href='otpVerify.php?phn=$phn&email=$email&ent=$entity';
        </script>");
          }
  //print_r($res_cat);exit;
  } else 
  {
     echo ("<script LANGUAGE='JavaScript'>
          window.alert('Please fill only one field..!!');
          
        </script>");
  }
}

?>
<div class="row4 ">
 <div class=" col-md-12 text-center footer2txt">
  </div></div>
