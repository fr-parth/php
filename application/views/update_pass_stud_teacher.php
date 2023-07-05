<?php//Created by Rutuja for SMC-5169 on 20-02-2021 ?>
<!DOCTYPE html>
<html lang="en">
<head>
<style>
body{
background-color:white;
}
</style>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>
<?php if($isSmartCookie) { ?>
:: Smart Cookie -  Student/Teacher Rewards Program ::
<?php }else{ ?>
:: Protsahan-Bharati -  Student/Teacher Rewards Program ::
<?php } ?>
</title>
<link href="<?php echo base_url();?>Assets/vendors/bootstrap/css/bootstrap.css" rel="stylesheet">
    <script src="<?php echo base_url();?>Assets/vendors/bootstrap/js/bootstrap.min.js"></script>
<link href="<?php echo base_url();?>css/sc_style2.css"rel="stylesheet">
<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>

</head>
<body>
<div class="row1 header  bg-wht">
	<div class='container bg-wht' >
		<div class="row " style="padding-top:20px;" >
			<div class="col-md-7 visible-lg visible-md">
			
	<?php  $isSmartCookie=$_SESSION['isSmartCookie'];

		 if($isSmartCookie) {  ?>                      
                            <div class="visible-sm visible-lg visible-md">
                                <div align='center'><img src="<?php echo base_url();?>Assets/images/logo/250_86.png" /></div>
                            </div>
<?php  }else{   ?> 
                            
                            <div class="visible-sm visible-lg visible-md">
                               <div align='center'><img src="<?php echo base_url();?>Assets/images/logo/pblogoname.jpg" /></div>
                            </div>
<?php } ?>
	
		<!--End-->			
            </div>
			 <div class="col-md-7 visible-sm">
                <img src="<?php echo base_url();?>Images/250_86.png" />
            </div>
            <div class="col-md-7 visible-xs">
                <img src="<?php echo base_url();?>Images/220_76.png" />
            </div>
           
			<div class='col-md-2'>
				<a class="btn btn-primary" href="express_registration_sp.php" >Registration</a> 
			</div>
			<div class="col-md-3" >
				<div class="btn-group">
			
				  <a href = "<?php echo base_url();?>"><button type="button" class="btn btn-primary">
					Login</span>
				  </button></a>
				
				</div>					
			</div>     
		</div>	
	</div>
</div>

<?php 
error_reporting(0);

?>
<!DOCTYPE html>
<html>
<head>

<title>Verify OTP</title>
<!--<link href="./css/style.css" rel="stylesheet" type="text/css" />-->
<style>
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
    color: white;
    font-weight: normal;
    font-weight: 400;
    margin: 0 190px 0 190px ;
    text-align: center;    
    font-size: 1.5em;
    width : 50%;
	
	background-color:#f00;
	font-family: "Times New Roman", Times, serif;
    
    
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
    background: white;
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
    background-color: #660033;
    color: #f5f7fa;
    cursor: pointer;
    border-radius: 4px;
    width: 30%;
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

    <form name="frmRegistration" method="post" action="">
        <div class="demo-table">
		<?php
		
		$isSmartCookie=$_SESSION['isSmartCookie'];

		 if($isSmartCookie) {  ?>                      
                            <div class="visible-sm visible-lg visible-md">
                                <div align='center'><img src="<?php echo base_url();?>Assets/images/logo/250_86.png" /></div>
                            </div>
<?php  }else{   ?> 
                            
                            <div class="visible-sm visible-lg visible-md">
                               <div align='center'><img src="<?php echo base_url();?>Assets/images/logo/pblogoname.jpg" /></div>
                            </div>
<?php } ?>
            <div class="form-head" align='center'><?php echo ucwords($_SESSION['usertype']); ?>  Update Password</div>
        
            <br>
           
          
				
				 <div align="center">
				<input type="hidden" class="demo-input-box" name="email" id="email" value="<?php $email; ?>"/ >
				
				<input type="hidden" class="demo-input-box" name="phone" id="phone" value="<?php $phone; ?>"/>
              
				<label><b>New Password : </b></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="password" class="demo-input-box" name="updated_password" id="updated_password" placeholder="Please enter new password" style="width: 300px" required><br><br>
                <label><b>Confirm Password : </b></label>
                <input type="password" class="demo-input-box" name="confirm_updated_password" id="confirm_updated_password" placeholder="Please re-enter new password" style="width: 300px" required>
				<br><br>
                <div>
                       <?php 
                  echo form_submit('update_password', 'Update','class="myButton btn btn-primary" id="update_password" onclick=" return update_password_stud_teacher();"');
                ?>
					<!--<a href="<?php //echo base_url();?>" style="text-decoration:none;"> <input type="button"  class="btn btn-danger" name="Back" value="Back"/></a>-->	
                </div>
                </div>
            </div>

    </form>
</body>
</html>
<div class="row4 ">
 <div class=" col-md-12 text-center footer2txt">
  </div></div>

