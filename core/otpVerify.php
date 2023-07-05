<?php 
//Updated by Sayali Balkawade for Display Logo and Entity,header ,footer and back button  name on 30/12/2020 for SMC-5058
 include 'index_header.php'; ?>
<?php include_once('securityfunctions.php');
error_reporting(0);

//echo $entity;exit;
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
input[type="text"]
{
    font-size:24px;
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
        <div class="form-head">Verification</div>
            <br>
           
          
				
				 <div align="center">
				<input type="hidden" class="demo-input-box" name="email" id="email" value="<?php $email; ?>"/ >
				
				<input type="hidden" class="demo-input-box" name="phone" id="phone" value="<?php $phone; ?>"/>
              
				<label><b>OTP</b></label>
				<input type="text" class="demo-input-box" name="otp" id="otp" placeholder="Enter OTP">
				
                <div>
                    <input type="submit"
                        name="submit" value="Verify OTP"
                        class="btn btn-primary" />
						  <?php $server_name = $GLOBALS['URLNAME']; ?>
                        <a href="<?php echo $server_name;?>" style="text-decoration:none;"> <input type="button"  class="btn btn-danger" name="Back" value="Back"/></a>
						
                </div>
                </div>
            </div>

    </form>
	</div>
</body>
</html>

<?php
$phone=$_GET['phn'];
$email=$_GET['email'];
$entity=$_GET['ent'];
if (isset($_POST['submit'])) {
	
	
	$email=$email;
	$phone=$phone;
	$ent=$entity;
	$otp=$_POST['otp'];
$url_cat=$GLOBALS['URLNAME']."/core/api2/api2.php?x=varify_otp";
$myvars_cat=array(
			'operation'=>"varify_otp",
			'phone_number'=>$phone,
			'email_id'=>$email,	
			'otp'=>$otp,	
			'api_key'=>'cda11aoip2Ry07CGWmjEqYvPguMZTkBel1V8c3XKIxwA6zQt5s'
			
			);
}
//print_r($myvars_cat);exit;
$res_cat = get_curl_result($url_cat,$myvars_cat);
	$responce = $res_cat["responseStatus"];
                  if($responce==200)
				  {
					  echo ("<script LANGUAGE='JavaScript'>
					window.alert('OTP Verified Successfully..!!!');
					window.location.href='info.php?entity=$ent&phn=$phone&email=$email';
				</script>");
				  }
				   if($responce==204)
				   {
					 echo ("<script LANGUAGE='JavaScript'>
					window.alert('Your Contact And OTP are not matched');
				</script>");  
				   }
?>
<div class="row4 ">
 <div class=" col-md-12 text-center footer2txt">
  </div></div>
