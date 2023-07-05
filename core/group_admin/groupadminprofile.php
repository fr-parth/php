<?php
include("groupadminheader.php");
/*Below entity and if conditions added by Rutuja for differentiating between Group Admin & Group Admin Staff
for SMC-4568 on 23/03/2020*/
$entity=$_SESSION['entity'];
    if($entity==12)
    {
        $group_member_id=$_SESSION['group_admin_id'];
    }
    if($entity==13)
    {
        $id=$_SESSION['id'];
    }

if (isset($_POST['submit'])) 
	{
    $name = mysql_real_escape_string($_POST['name']);
    $group_name = mysql_real_escape_string($_POST['group_name']);
    $address = mysql_real_escape_string($_POST['address']);
    $email = mysql_real_escape_string($_POST['email']);
    $password = mysql_real_escape_string($_POST['password']);
    $mobile = mysql_real_escape_string($_POST['mobile']);
    $Country=mysql_real_escape_string($_POST['Country']);
	

	//echo "update tbl_cookieadmin set  admin_name='$name',group_name='$group_name',admin_email='$email',mobile_no='$mobile',address='$address' where id ='$group_member_id'";
	//Added if conditins and tbl_cookie_adminstaff for updating Group Admin Staff Profile - by Rutuja for SMC-4568 on 23/03/2020
	if($entity==12)
    {
    $sql = mysql_query("update tbl_cookieadmin set  admin_name='$name',group_name='$group_name',admin_email='$email',mobile_no='$mobile',address='$address' where id ='$group_member_id'");
    }
	if($entity==13)
    {
		$sql = mysql_query("update tbl_cookie_adminstaff set  stf_name='$name',
		email='$email',
		phone='$mobile',address='$address' where id ='$id'");
	}
	
	if (mysql_affected_rows() > 0) {
        $successreport = "Profile Is Successfully Updated";
    }
}

  if(isset($_POST['passsubmit']))
	 {                      
		$prevpassword = mysql_real_escape_string($_POST['prepwd']);
		$newpassword = mysql_real_escape_string($_POST['newpwd']);
		$confirmpassword= mysql_real_escape_string($_POST['confirmpwd']);
		//Added if conditins and tbl_cookie_adminstaff for fetching password of Group Admin Staff - by Rutuja for SMC-4568 on 23/03/2020
	
		if($entity==12)
		{
		$select=mysql_query("select admin_password as admin_password from tbl_cookieadmin where id='$group_member_id'"); 
		}
		if($entity==13)
		{
		$select=mysql_query("select pass as admin_password from tbl_cookie_adminstaff where id='$id'"); 
		}
		$fetch=mysql_fetch_array($select);
		$data_pwd=$fetch['admin_password'];
		//$sql=mysql_query("select password from `tbl_school_admin` where email='$email'");
		//$result=mysql_query($sql);		
		//$email=$fetch['email'];
      if($prevpassword!="") 
	  {
		  if($newpassword!="" && $confirmpassword!="")
		  {
				  if($data_pwd==$prevpassword) 
					{
						if($newpassword==$confirmpassword)
						{	
					//Added if conditins and tbl_cookie_adminstaff for updating password of Group Admin Staff - by Rutuja for SMC-4568 on 23/03/2020
							if($entity==12)
							{
							$insert=mysql_query("update tbl_cookieadmin set admin_password ='$confirmpassword' where id='$group_member_id'"); 
							}
							if($entity==13)
							{
							$insert=mysql_query("update tbl_cookie_adminstaff set pass ='$confirmpassword' where id='$id'"); 
							}
							//echo "<script type=text/javascript>alert('You have successfully changed your Password '); window.location='schooladminprofile_20152904.php'</script>";
							$successreport="Password Is Successfully Changed";
						}
						else
						{
							
							$login1="New Password & Confirm Password Not Match Please Try Again";
						}
						
					}
				  else
					{
						$login1="Previous Password Did Not Match Please Try Again";
					}
		  }
		   else
		  {
				$login1="You Forgot To Enter Your New Password And Confirm Password";
		  }
     }
      else
		  {
				$login1="You Forgot To Enter Your Previous Password";
		  }

	 }  
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Beneficiary Information</title>
    <link rel="stylesheet" type="text/css" href="../css/jquery.dataTables.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="../js/jquery-1.11.1.min.js"></script>
    <script src="../js/jquery.dataTables.min.js"></script>

    <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
	<script type="text/javascript" src="../js/jquery.form.js"></script>
	 <script type="text/javascript"> 
        function valid() {
			 //validation for name
			 regx1 = /^[A-z ]+$/;
            var name = document.getElementById("name").value;
            if (name.trim() == "" || name.trim() == null) {
                document.getElementById("errorname").innerHTML = "Please Enter Name";
               return false;
            }else 
            if (!regx1.test(name) || !regx1.test(name)) {
				   
                document.getElementById('errorname').innerHTML = 'Please Enter valid Name';
                return false;
            }else{
                document.getElementById("errorname").innerHTML = ""; 
            }
			//validation for group name
			regx2 = /^[A-Za-z.,() ]+$/;
			var group_name = document.getElementById("group_name").value;
            if (group_name.trim() == "" || group_name.trim() == null) {
                document.getElementById("errorgroup_name").innerHTML = "Please enter group name";
                return false;
            }else
            if (!regx2.test(group_name) || !regx2.test(group_name)) {
                document.getElementById('errorgroup_name').innerHTML = 'Please Enter valid group name';
                return false;
            }else{
                document.getElementById("errorgroup_name").innerHTML = ""; 
            }
			//validation for email
			var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
			var email = document.getElementById("email").value;
            if (email == null || email == "") {
                document.getElementById('erroremail').innerHTML = 'Please Enter email ID';
                return false;
            }else
            if (!email.match(mailformat)) {
                document.getElementById('erroremail').innerHTML = 'Please Enter valid email ID';
                return false;
            }else{
                document.getElementById("erroremail").innerHTML = ""; 
            }
			
			//validation for mobile
			var phoneno = /^[6789]\d{9}$/;
			var mobile = document.getElementById("mobile").value;
            if (mobile == "" || mobile == null) {

                document.getElementById("errormobile").innerHTML = "Please enter mobile no.";
                return false;
            }else 
            if (!mobile.match(phoneno)) {
                document.getElementById("errormobile").innerHTML = "Please enter valid mobile no.";
                return false;
            }
			else{
				document.getElementById("errormobile").innerHTML = "";
			}

			//validation for address

			regx3 = /^[A-Za-z1-9.,() ]+$/;
            var address = document.getElementById("address").value;
            if (address.trim() == "" || address.trim() == null) {
                document.getElementById("erroraddress").innerHTML = "Please enter Address";
                return false;
            }
			if (!regx3.test(address) || !regx3.test(address)) {
                document.getElementById('erroraddress').innerHTML = 'Please Enter valid Address';
                return false;
            }
			else
			{
			document.getElementById('erroraddress').innerHTML = '';	
			}
			
          //validation for Country code
			var Country = document.getElementById("Country").value;
			if (Country == "" || Country == null) {

                document.getElementById("errorcountrycode").innerHTML = "Please select country code";
				document.getElementById("Country").focus();
                return false;
            } 

        }
 function pvalid() {
			
			//validation for Previous Password
			var prepass = document.getElementById("prepass").value;
            if (prepass.trim() == "" || prepass.trim() == null) {
                document.getElementById("prepass1").innerHTML = "Enter Your Previous Password";
                return false;
            }else{
                document.getElementById("prepass1").innerHTML = ""; 
            }
			//validation for Country code
			var newpwd = document.getElementById("newpwd").value;
            if (newpwd.trim() == "" || newpwd.trim() == null) {
                document.getElementById("newpwd1").innerHTML = "Enter Your New Password";
                return false;
            }else{
                document.getElementById("newpwd1").innerHTML = ""; 
            }
			//validation for Country code
			var confirmpwd = document.getElementById("confirmpwd").value;
            if (confirmpwd.trim() == "" || confirmpwd.trim() == null) {
                document.getElementById("confirmpwd1").innerHTML = "Enter Your Confirm Password";
                return false;
            }else{
                document.getElementById("confirmpwd1").innerHTML = ""; 
            }
		}
    </script>

    <script>
    $(document).ready(function() {
    $('#example').dataTable( {
	"paging":   false,
	"info":false,
	"searching": false,
     "scrollCollapse": true,
	"scrollY": "500px"
    } );
} );
    </script>

    <style>
        @media only screen and (max-width: 800px) {
            /* Force table to not be like tables anymore */
            #no-more-tables table,
            #no-more-tables thead,
            #no-more-tables tbody,
            #no-more-tables th,
            #no-more-tables td,
            #no-more-tables tr {
                display: block;
            }

            /* Hide table headers (but not display: none;, for accessibility) */
            #no-more-tables thead tr {
                position: absolute;
                top: -9999px;
                left: -9999px;
            }

            #no-more-tables tr {
                border: 1px solid #ccc;
            }

            #no-more-tables td {
                /* Behave  like a "row" */
                border: none;
                border-bottom: 1px solid #eee;
                position: relative;
                padding-left: 50%;
                white-space: normal;
                text-align: left;
                font: Arial, Helvetica, sans-serif;
            }

            #no-more-tables td:before {
                /* Now like a table header */
                position: absolute;
                /* Top/left values mimic padding */
                top: 6px;
                left: 6px;
                width: 45%;
                padding-right: 10px;
                white-space: nowrap;
                text-align: left;

            }
            /*
            Label the data
            */
            #no-more-tables td:before {
                content: attr(data-title);
            }
        }
    </style>
</head>

<body bgcolor="#CCCCCC" >
<div class="container"><br><br><center>
		<?php if($successreport!=""){?>
		<div class="alert alert-success" role="alert"><h4><?php echo $successreport;?></h4>
		</div>
		<?php }else if($login1!=""){?>
			<div class="alert alert-danger" role="alert"><h4><?php echo $login1;?></h4>
		</div>
		<?php
		}else{
		}?>
		</center>

 <div class="panel-group" id="accordion" >
    <div class="panel panel-default">
      <div class="panel-heading">
			<h4 class="panel-title"><center>
			  <a data-toggle="collapse" data-parent="#accordion" href="#collapse1"><h3>Edit Profile</h3></a>
			  </center>
			</h4>
		  </div>
		  <div id="collapse1" class="panel-collapse collapse in">
			<div class="panel-body">
						<div class="row">
				<p style="text-align: center; font-size:15px;">All Fields Are Mandatory <span style="color:red;font-size: 25px;">*</span></p>
				 <?php 
	 //Added if conditins and tbl_cookie_adminstaff for details of Group Admin Staff - by Rutuja for SMC-4568 on 23/03/2020
				 if($entity==12)
				 {
					$sql = mysql_query("select * from tbl_cookieadmin where id='$group_member_id'");
				 }
				 if($entity==13)
				 {
					$sql = mysql_query("select stf_name as admin_name,group_member_id as id,
					email as admin_email,phone as mobile_no,address as address from tbl_cookie_adminstaff where id='$id'");
				 }
					$result = mysql_fetch_array($sql);

				?>
				 <form action="" method="POST" >
					<div class="row" style="text-align:left;">
						<div class="col-md-3"></div>
						<div class="col-md-2" style="font-size:18px; padding-left:15px;">Name<span style="color:red;font-size: 25px;">*</span>
						</div>
						<div class="col-md-3"><input type="text" name="name" id="name" class="form-control" value="<?php echo $result['admin_name']; ?>" required><span id="errorname" class="text-danger"></span>
						</div>
						<div class="col-md-4"></div>
					</div>
					<br>
					<div class="row" style="text-align:left;">
						<div class="col-md-3"></div>
						<div class="col-md-2" style="font-size:18px; padding-left:15px;">Group Admin ID<span style="color:red;font-size: 25px;">*</span>
						</div>
						<div class="col-md-3"><input type="text" name="group_id" id="group_id" class="form-control" value="<?php echo $result['id']; ?>" disabled>
						</div>
						<div class="col-md-4"></div>
					</div>
					<br>
					<?php if($entity==12)
					{?>
					<div class="row" style="text-align:left;">
						<div class="col-md-3"></div>
						<div class="col-md-2" style="font-size:18px; padding-left:15px;">Group Type<span style="color:red;font-size: 25px;">*</span>
						</div>
						<div class="col-md-3"><input type="text" name="group_type" id="group_type" class="form-control" value="<?php echo $result['group_type']; ?>" disabled>
						</div>
						<div class="col-md-4"></div>
					</div>

					<br>
					<div class="row" style="text-align:left;">
						<div class="col-md-3"></div>
						<div class="col-md-2" style="font-size:18px; padding-left:15px;">Group Name<span style="color:red;font-size: 25px;">*</span>
						</div>
						<div class="col-md-3"><input type="text" name="group_name" id="group_name" class="form-control" value="<?php echo $result['group_name']; ?>" required>
						<span id="errorgroup_name" class="text-danger"></span>
						</div>
						<div class="col-md-4"></div>
					</div>
					<br>
					<?php } ?>
					<div class="row" style="text-align:left;">
						<div class="col-md-3"></div>
						<div class="col-md-2" style="font-size:18px; padding-left:15px;">Email<span style="color:red;font-size: 25px;">*</span>
						</div>
						<div class="col-md-3"><input type="text" name="email" id="email" class="form-control" value="<?php echo $result['admin_email']; ?>" required>
						<span id="erroremail" class="text-danger"></span>
						</div>
						<div class="col-md-4"></div>
					</div>
					<br>
					<div class="row" style="text-align:left;">
						<div class="col-md-3"></div>
						<div class="col-md-2" style="font-size:18px; padding-left:15px;">Mobile No<span style="color:red;font-size: 25px;">*</span>
						</div>
						<div class="col-md-3"><input type="text" name="mobile" id="mobile" class="form-control" value="<?php echo $result['mobile_no']; ?>" required>
						<span id="errormobile" class="text-danger"></span>
						</div>
						<div class="col-md-4"></div>
					</div>
					<br>
					<div class="row" style="text-align:left;">
						<div class="col-md-3"></div>
						<div class="col-md-2" style="font-size:18px; padding-left:15px;">Address<span style="color:red;font-size: 25px;">*</span>
						</div>
						<div class="col-md-3"><textarea class='form-control' id='address' name="address" rows='3' required><?php echo $result['address']; ?> </textarea>
						<span id="erroraddress" class="text-danger"></span>
						</div>
						<div class="col-md-4"></div>
					</div>
					<br>
					<br>
					<div class="row" style="text-align:left;">
						<div class="col-md-5"></div>
						<div class="col-md-1"><input type="submit" name="submit" class="btn btn-primary" value="Update" onClick="return valid();">
						</div>
						<div class="col-md-1">
							<a href="home_groupadmin.php" > 
							<input type="button" class="btn btn-danger" value="Cancel" >
							</a>
						</div>
						<div class="col-md-5"></div>
					</div>
				 </form>
				</div>	
		</div>
      </div>
    </div>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title"><center>
          <a data-toggle="collapse" data-parent="#accordion" href="#collapse2"><h3>Change Password</h3></a>
		  </center>
        </h4>
      </div>
      <div id="collapse2" class="panel-collapse collapse">
        <div class="panel-body">
		<br><br><br>
			<form action="" method="POST">
				<div class="row" align="center">  
					  <!-- <div  class="col-md-2" style=" padding:10px;"><div align="center" style="font-size:18px; padding-left:12px;">Change Password</div> 
					  </div> -->
					  <div class="col-md-1" ></div>
					  <div class="col-md-3" style="font-size:18px; padding-left:15px;">Previous Password<span style="color:red;font-size: 25px;">*</span>
						</div>
					  <div class="col-md-5" > 
						<input type="password" name="prepwd" id="prepass"  placeholder="Previous Password" class="form-control" required><span id="prepass1" class="text-danger"></span>
						</div>
					  <div class="col-md-3" ></div>
				</div>
				<br>
				<div class="row" align="center">
					 <div class="col-md-1" ></div>
					  <div class="col-md-3" style="font-size:18px; padding-left:15px;">New Password<span style="color:red;font-size: 25px;">*</span>
						</div>
					  <div class="col-md-5" > 
						<input type="password" name="newpwd" id="newpwd" placeholder="New Password" class="form-control" required>
					  <span id="newpwd1" class="text-danger"></span>
					  </div>
					<div class="col-md-3" ></div>
				</div>
				<br>
				<div class="row" align="center">
					   <div class="col-md-1" ></div>
					  <div class="col-md-3" style="font-size:18px; padding-left:15px;">Confirm Password<span style="color:red;font-size: 25px;">*</span>
						</div>
					  <div class="col-md-5" >
						<input type="password" name="confirmpwd" id="confirmpwd" placeholder="Confirm Password" class="form-control" required ><span id="confirmpwd1" class="text-danger"></span>
					  </div>
					  <div class="col-md-3" ></div>
				</div>
				<br>
				<div class="row" align="center">
					  <div class="col-md-3" ></div>
					  <div  class="col-md-6" >
						 <input type="submit" name="passsubmit" value="Change Password" class="btn btn-primary" onClick="return pvalid();"/>
					  </div>
					   <div class="col-md-3" ></div>
				</div>
				<br><br><br><br><br>
			</form>
		</div>
      </div>
    </div>
    
  </div> 
</div>


</div>
</body>
</html>