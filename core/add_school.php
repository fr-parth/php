<?php
 include("cookieadminheader.php");
 
  

if(isset($_POST['submit']))
 {

 $school_id=$_POST['id'];
 $school_name=$_POST['school_name'];
 $school_address=$_POST['school_address'];
 $school_email=$_POST['school_email'];
 $school_head_nm=$_POST['school_head_nm'];
 $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%&*_";
 $password = substr( str_shuffle( $chars ), 0, 8 );

 $date=Date('d/m/Y');
             
$sql="INSERT INTO tbl_school(id,school_name,school_address,school_email,school_head_nm,password,date)VALUES('$school_id','$school_name','$school_address','$school_email','$school_head_nm','$password','$date')";
	$row=mysql_query($sql);
	
	/*if($row)
	{
	$to=$school_email;
	$from="smartcookie@gmail.com";
	$subject="Succesful Registration";
	$message="Hello ".$school_name."\r\n\r\n".
		 "Thanks for your registration with Smart Cookie\r\n";
		  "your Username is:"  .$school_email.  "\n\n";
		  "your password is:".$password."\n\n";
		  
		  "Regards,\r\n";
   	      "Smart Cookie Admin";
		  
     mail($to, $subject, $message);
	}*/
}
?>

<!DOCTYPE html >
<html >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Add School</title>
<link href="css/style.css" rel="stylesheet">
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/bootstrap-multiselect.css" rel="stylesheet">
<link href="css/bootstrap-responsive.min.css" rel="stylesheet">
</head>

<script>
function school_confirmationemail()
{
alert("hii");
$a1 = explode("@", $sc_email);
    $username = $a1[0];
  
    print "username = ".$username;
$to=$sc_email;
$from="smartcookie@gmail.com";
$subject="Succesful Registration";
$message="Hello ".$sc_name."\r\n\r\n".
		 "Thanks for your registration with Smart Cookie\r\n"
		  "your Username is:"  .$username.  "\n\n".
		  
		  "Regards,\r\n".
   	      "Smart Cookie Admin";
     mail($to, $subject, $message);
	 
    		
}	

</script>

<body style="background-color:#EBEBEB;">
<div align="center">
	<div style="width:1002px;">
    	 <div style="height:20px;"></div>
    	<div style="height:50px; background-color:#FFFFFF; border:1px solid #CCCCCC;" align="left">
        	<h1 style="padding-left:20px; margin-top:2px;">Add School</h1>
        </div>
        <div style="height:20px;"></div>
        <div style="height:400px; background-color:#FFFFFF; border:1px solid #CCCCCC;" align="left">

<div class="container" style="width:500px;">
	<form id="add_school" method='POST' >
		<fieldset>
			<br />
			<div class="control-group">
				<label class="control-label">School Id:</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<label>
				<input type="text" name="school_id" id="school_id" />
				</label>
			</div>
            <br/>
			<div class="control-group">
				<label class="control-label">School Name:</label>&nbsp;
				<label>
					<input type="text" id="school_name" name="school_name">
				</label>
			</div>
            <br />
			<div class="control-group">
				<label class="control-label">Address:</label>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
				<label>
					 <input type="text" id="school_address" name="school_address">
				</label>
			</div>
              <br />
			<div class="control-group">
				<label class="control-label">Email:</label>&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;
				<label>
					<input type="text" id="school_email" name="school_email">
				</label>
			</div>
              <br />
            <div class="control-group">
				<label class="control-label">School Head:</label>&nbsp;
                 
				<label>
					<input type="text" id="school_head_nm" name="school_head_nm">
				</label>
			</div>
            <br/>
           
			<div class="control-group">
				<label class="control-label"></label>&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<label>
					<input type="submit" Value="Submit" id="submit" name="submit" style="width:100px; height:40px; background-color:#0063C6; color:#FFFFFF; border:1px solid #CCCCCC;">
				</label>
			</div>
		</fieldset>
	</form>
</div>
</div>
    </div>
</div>
</body>

</html>
