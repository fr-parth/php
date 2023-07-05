<html>
<head>
    <meta charset="utf-8">
    <title>Smart Cookies</title>
<!--    <link href='css/datepicker.min.css' rel='stylesheet' type='text/css'>-->
     <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="js/city_state.js" type="text/javascript"></script>
<!--    <script src='js/bootstrap-datepicker.min.js' type='text/javascript'></script>-->
	 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
     <script src="js/jquery-1.11.1.min.js"></script>
     <script src="js/bootstrap-datepicker.min.js"></script>
</head>
<?php
$report = "";
include("cookieadminheader.php");
$url =$GLOBALS['URLNAME']."/core/Version5/city_state_list.php";
//$url = "https://dev.smartcookie.in/core/Version5/city_state_list.php";
$data = array("keyState"=>'1234',"country"=>'', "state"=>'' );
	
	$ch = curl_init($url);             
	$data_string = json_encode($data);    
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);  
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);      
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data_string)));
	$country_ar = json_decode(curl_exec($ch),true); 

	if (isset($_POST['submit'])) {
		$group_name = trim($_POST['name']);
		$group_short_name = trim($_POST['group_short_name']);
		$email_id = trim($_POST['email']);
		$mobile_no = trim($_POST['phone']);
        $country = trim($_POST['country']);
        $state = trim($_POST['state']);
        $city = trim($_POST['city']);
		$address = $_POST['address'];
		$group_type = $_POST['group_type'];
		$password = $_POST['password'];
		$Confirm = $_POST['confirm'];
		$admin_name = $_POST['admin_name'];
		$dates = date('Y/m/d h:m:s');
		$counts = 0;
		$emails="select admin_email,mobile_no from tbl_cookieadmin where admin_email='$email_id'";
		$emailid=mysql_query($emails);
		$a=mysql_num_rows($emailid);

		$phone_no=mysql_query("select admin_email,mobile_no from tbl_cookieadmin where mobile_no='$mobile_no'");
		$b=mysql_num_rows($phone_no);
			if ($a>0 || $b>0)
			{	
				if($a>0 && $b>0){
					echo ("<script LANGUAGE='JavaScript'>
								alert('Both  ".$email_id." and ".$mobile_no." Is Already Present');
							</script>");
				}
                 else{
				if($a>0){
				echo ("<script LANGUAGE='JavaScript'>
								alert('Email Id ".$email_id." Is Already Present');
							</script>");
				}
				else{
					echo ("<script LANGUAGE='JavaScript'>
								alert('Phone no  ".$mobile_no." Is Already Present');
							</script>");
				}
			}
		}
			else
			{	
			
				$sql=mysql_query("INSERT INTO tbl_cookieadmin (admin_name,group_name,group_mnemonic_name,admin_email,mobile_no,country,state,city,address,group_type,admin_password) VALUES ('$admin_name','$group_name','$group_short_name','$email_id','$mobile_no','$country','$state','$city','$address','$group_type','$password')");
	
		 
		//print_r($result); exit;
		
		if($sql){
			$grp_admin=mysql_query("select id from tbl_cookieadmin order by id desc LIMIT 1");
			$grp_admin_res=mysql_fetch_array($grp_admin);
			$school_id="GRP".$grp_admin_res['id'];
			$group_member_id=$grp_admin_res['id'];
			$sql1="INSERT INTO `tbl_school_admin`(name,school_name,address,email,reg_date,mobile,password,group_type,school_id,group_member_id,school_type,scadmin_country,scadmin_state,scadmin_city) VALUES ('$admin_name','$group_name','$address','$email_id','$dates','$mobile_no','$password','$group_type','$school_id','$group_member_id','School','$country','$state','$city')";
			$res=mysql_query($sql1);
			$insert="INSERT INTO `tbl_group_school`(group_member_id,group_mnemonic_name, school_id,createdby, isenabled) VALUES ('$group_member_id','$group_name','$school_id','$admin_name','1')";
            $res1 = mysql_query($insert);
			//Mail format changed by Pranali
			$site=$GLOBALS['URLNAME'];
			$msgid="welcomeGroupAdmin";
			$res = file_get_contents("$site/core/clickmail/sendmail.php?email=$email_id&msgid=$msgid&site=$site&pass=$password&group_name=$group_name&group_short_name=$group_short_name");
			
			//For SMS
			$Text1="Hello, \r\n\r" .
				"You are registred as Group Admin in Smart Cookie \r\n" .
				"your Group Name is: " . $group_name . "\n" .
				"your Group Short Name ID is: " . $group_short_name . "\n".
				"your password is: " . $password . "\n" .
				"Regards,\r\n" .
				"Smart Cookie Admin"; 								
			$Text = urlencode($Text1);
			/*Below query added by Rutuja for fetching dynamic values for user,password & sender for SMC-4989 on 02-12-2020*/
		$sql_dynamic= mysql_query("select * from tbl_otp where id=1");
		$dynamic_fetch= mysql_fetch_array($sql_dynamic);
		$dynamic_user = $dynamic_fetch['mobileno'];
		$dynamic_pass = $dynamic_fetch['email'];
		$dynamic_sender = $dynamic_fetch['otp'];
		
			$url="http://www.smswave.in/panel/sendsms.php?user=$dynamic_user&password=$dynamic_pass&sender=$dynamic_sender&PhoneNumber=$mobile_no&Text=$Text";
			$response = file_get_contents($url);
			echo "<script>alert('Group Admin Successfully Registered');</script>";
		}
		else{
			 echo "<script>alert('Something went Wrong....Please Try Again...');
			 window.location.href='registergroupadmin.php';
			 </script>";
			 return false;
		 }
	} 
}
	$query=mysql_query("select * from tbl_group_type");
?>
</script>
<script>
 $(document).ready(function() 
 {  
     $("#country").on('change',function(){   
         var cid = document.getElementById("country").value;
         $.ajax({
             type:"POST",
             data:{c_id:cid}, 
             url:'../college_id/country_state_city_js.php',
             success:function(data)
             {
               
                 $('#state').html(data);
             }
         });
     }); 
 });
</script> 
<script>
 $(document).ready(function() 
 {  
     $("#state").on('change',function(){   
     	var cid = document.getElementById("country").value;  
         var s_id = document.getElementById("state").value;
//alert(s_id);
         $.ajax({
             type:"POST",
             data:{s_id:s_id,cid:cid}, 
             url:'../college_id/country_state_city_js.php',
             success:function(data)
             {
                 $('#city').html(data);
             } 
         }); 
     }); 
 });
</script>			
<style>
.error {color: #FF0000;}
</style>
<body>
	<div class="container">
		<center><h2>Group Admin Registration Form</h2></center>
		<form class="form-horizontal" action="" method="POST" style="margin-left : 318px;">
		<div class="form-group">
			<label class="control-label col-sm-2" for="name">Group Type:<span class="error"> *</span></label>
			<div class="col-sm-6">	  
				<select id="group_type" name="group_type" class="form-control" style="width:300px;">
					<option value="select">Select Group Type</option>
					<?php while ($row=mysql_fetch_array($query)) { 	
					$id=$row["id"];   
					$group_type=$row["group_type"];   
					?>
					<OPTION VALUE="<?php echo $group_type;?>"><?php echo $group_type;?></option>
					<?php } ?>
				</select>
			</div>
		</div>
		<div class="form-group">
		  <label class="control-label col-sm-2" for="name">Admin Name:<span class="error"> *</span></label>
			<div class="col-sm-6">
				<input type="text" class="form-control" id="admin_name" placeholder="Enter admin name" name="admin_name" style="width:300px;">
			</div>
		</div>
		<div class="form-group">
		  <label class="control-label col-sm-2" for="name">Group Name:<span class="error"> *</span></label>
			<div class="col-sm-6">
				<input type="text" class="form-control" id="name" placeholder="Enter group name" name="name" style="width:300px;">
			</div>
		</div>
		<div class="form-group">
		  <label class="control-label col-sm-2" for="group_short_name">Group Short Name :<span class="error"> *</span></label>
		  <div class="col-sm-6">
			<input type="text" class="form-control" id="group_short_name" placeholder="Enter group short name" name="group_short_name" style="width:300px;">
		  </div>
		</div>
		<div class="form-group">
		  <label class="control-label col-sm-2" for="email">Email id:<span class="error"> *</span></label>
		  <div class="col-sm-6">
			<input type="email" class="form-control" id="email" placeholder="Enter email id" name="email" style="width:300px;">
		  </div>
		</div>
		<div class="form-group">
		  <label class="control-label col-sm-2" for="phone">Mobile No:<span class="error"> *</span></label>
		  <div class="col-sm-6">
			<input type="text" class="form-control" id="phone" min="0" maxlength="10"placeholder="Enter mobile no" onkeypress="return isNumberKey(event)" name="phone" style="width:300px;">
		  </div>
		</div>
		<div class="form-group">
            <label class='control-label col-sm-2'  for="country">Country<span class="error"> *</span></label>
           <div class='col-sm-6'>
                 <select id="country" name="country" class='form-control' style="width:300px;">
                  <option value='select'>Select Country</option>
                  <?php foreach($country_ar['posts'] as $res){ ?>
                                <option value="<?= $res["country"];?>"><?= $res["country"];?></option>
                                <?php } ?>
                                </select>
                </div>
		</div>
		 <div class="form-group">
				
            <label class='control-label col-sm-2' for="state">State<span class="error"> *</span></label>
                <div class='col-sm-6'>
            <select name='state' id='state' class='form-control'style="width:300px;">
            	<option value='select'>First select Country</option></select>
            </select>
                </div>
      </div> 
	  <div class='form-group'>
            <label class='control-label col-sm-2'  for="city">City<span class="error"> *</span></label>
            <div class='col-sm-6'>
              <select name='city' id='city' class='form-control' style="width:300px;">
            	<option value='select'>First select State</option></select>
            </select>
            </div>
          </div>
		<div class="form-group">
		  <label class="control-label col-sm-2" for="email">Address:<span class="error"> *</span></label>
		  <div class="col-sm-6">
			<textarea class="form-control" id="address" placeholder="Enter address" name="address" style="width:300px;"></textarea>
		  </div>
		</div>
		<div class="form-group">
		  <label class="control-label col-sm-2" for="email">Password:<span class="error"> *</span></label>
		  <div class="col-sm-6">
			<input type="password" class="form-control" onPaste="return false" onCopy="return false" id="password" placeholder="Enter password" name="password" style="width:300px;">
		  </div>
		</div>
		<div class="form-group">
		  <label class="control-label col-sm-2" for="email"> Confirm Password:<span class="error"> *</span></label>
		  <div class="col-sm-6">
			<input type="password" class="form-control" onPaste="return false" id="confirm" placeholder="Enter confirm password" name="confirm" style="width:300px;">
		  </div>
		</div>
		<div class="form-group">        
		  <div class="col-sm-offset-2 col-sm-10">
		  <button type="reset" id="reset" name="reset" class="btn btn-danger" style="margin-right:10px">Reset</button>
			<button type="submit" id ="submit" name = "submit" onclick ="return validation();" class="btn btn-primary" style="margin-right:10px">Submit</button>
			<a href="group_admin_list.php"><button type="button" id="back" name="back" class="btn btn-danger" align="right">Back</button></a>
		  </div>
		</div>
	  </form>
	</div>
</body>
</html> 

<script>
	function validation(){
		var alpha = /^[a-zA-Z-,]+(\s{0,1}[a-zA-Z-, ])*$/;
		var alpha1 = /^[a-zA-Z0-9 ]+$/;
		var valid_mobile= /^[6789]\d{9}$/;
		var valid_email= /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
		var pass=/^\S+(?: \S+)*$/; 
		var group_type = document.getElementById("group_type").value;
		var name = document.getElementById("name").value;
		var admin_name = document.getElementById("admin_name").value;
		var group_short_name = document.getElementById("group_short_name").value;
		var phone = document.getElementById("phone").value;
		var email = document.getElementById("email").value; 
		var country = document.getElementById("country").value;
		var state = document.getElementById("state").value;
		var city = document.getElementById("city").value;
		var address = document.getElementById("address").value;
		var password = document.getElementById("password").value;
		var confirm = document.getElementById("confirm").value;
		/*if(name == "" || name == null && group_short_name == "" || group_short_name == null && phone == "" || phone == null && address == "" || address == null){
			alert('Please Enter All Fields...! ');
				return false;}	*/	
		if(group_type=="select"){
			alert('Please Select Group Type First...!');
			return false;
		}
		if (admin_name.trim() == "" || admin_name.trim() == null){
			alert('Please Enter Admin Name...!');
			return false;
		}
		if(!alpha.test(admin_name)){
			alert('Please enter only in alphabets in Admin name');
			return false;
		}
		if (name.trim() == "" || name.trim() == null){
			alert('Please Enter Group Name...!');
			return false;
		}
		if(!alpha1.test(name)){
			alert('Please enter only in alphabets in group name');
			return false;
		}
		
		if (group_short_name == "" || group_short_name == null){
			alert('Please Enter Group Short Name...!');
			return false;
		}
		if(!alpha1.test(group_short_name)){
			alert('Please enter only in alphabets in Group Short Name');
			return false;
		}
		if (email == "" || email == null){
			alert('Please Enter Email Id...!');
			return false;
		}
		if(!valid_email.test(email)){
			alert('Please enter valid Email Id');
			return false;
		}
		if (phone == "" || phone == null){
			alert('Please Enter Mobile Number...!');
			return false;
		}
		if(!valid_mobile.test(phone)){
			alert('Please enter only 10 digit Mobile No and start 6 to 9');
			return false;
		}
        if(country=="select"){
			alert('Please Select country...!');
			return false;
		}
        if(state=="select"){
			alert('Please Select state...!');
			return false;
		}
		if(city=="select"){
			alert('Please Select city...!');
			return false;
		}
		if (address.trim() == "" || address.trim() == null){
			alert('Please Enter Address...!');
			return false;
		}	
		if(password.trim() == ""){
			alert("Please Enter Valid Password");
			return false;
		}
		if(!pass.test(password )){
			alert("Incorrect Password");
			return false;
		}
		if(password != confirm){
			alert('Password and confirm password must be same');
			return false
		}
	}
	function isNumberKey(evt) { 
		var charCode = (evt.which) ? evt.which : event.keyCode;
		 if ((charCode < 48 || charCode > 57))
			 return false; 
		 return true; 
	}
</script>