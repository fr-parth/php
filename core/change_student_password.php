<?php
error_reporting(0);
//include('conn.php');
include_once("cookieadminheader.php");
$report="";
$subject_id=$_GET['id'];


/*$id=$_SESSION['id'];
$query="select * from `tbl_school_admin` where id='$id'";       // getting the the school id of login user by checking the session
$row1=mysql_query($query);
$value1=mysql_fetch_array($row1);
 $school_id=$value1['school_id'];*/
$results=$smartcookie->retrive_individual($table,$fields);
$result=mysql_fetch_array($results);


 
 if(isset($_POST['submit']))
	 {   
		$id=$_POST['dropcoll']; 
//$school_name = $_POST['school_name']; 
		$newpassword = mysql_real_escape_string($_POST['newpwd']);
		$confirmpassword= mysql_real_escape_string($_POST['confirmpwd']);
		
      				if($newpassword==$confirmpassword)
						{	
					
							$insert=mysql_query("update tbl_student set std_password ='$newpassword' where school_id='$id'"); 
							if($insert)	
							{
				$successreport="Password Updated Successfully ";
							}
							else
							{
				$successreport1="Password  Not Updated";
							}
							
							
						}
						else
						{
							
		$successreport1="New Password & Confirm Password Not Match Please Try Again";
						}
	 }  
	
?>


<script>
	 $(document).ready(function() {
    	$('.searchselect').select2();
	});
function pvalid() {
//	alert("hiii");
	
	/*		//validation for Previous Password
			var prepass = document.getElementById("prepass").value;
            if (prepass.trim() == "" || prepass.trim() == null) {
                document.getElementById("prepass").innerHTML = "Enter Your Previous Password";
                return false;
            }else{
                document.getElementById("prepass").innerHTML = ""; 
            }
		*/	
			
			//validation for Country code
			var newpwd = document.getElementById("newpwd").value;
            if (newpwd.trim() == "" || newpwd.trim() == null) {
				
                document.getElementById("newpwd").innerHTML = "Enter Your New Password";
                return false;
            }else{
				
                document.getElementById("newpwd").innerHTML = ""; 
            }
			//validation for Country code
			var confirmpwd = document.getElementById("confirmpwd").value;
            if (confirmpwd.trim() == "" || confirmpwd.trim() == null) {
                document.getElementById("confirmpwd").innerHTML = "Enter Your Confirm Password";
                return false;
            }else{
                document.getElementById("confirmpwd").innerHTML = ""; 
            }
		}
    </script>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title></title>
    <link rel="stylesheet" type="css" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="../js/jquery-1.11.1.min.js"></script>
    <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
	<script type="text/javascript" src="../js/jquery.form.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css" rel="stylesheet" />
</head>
<body>
<form action="" method="POST" onsubmit="return pvalid();">
	<div class="row">
    <!-- <div class="col-md-1 "></div> -->
	  	<div class=" col-md-offset-1 col-md-10 col-md-offset-1">
			<div class="panel panel-danger " style="margin-top:22px;">
				<div class="panel-heading text-center">
				    <h3 class="panel-title"><font color="#580000"><b>Update Password For School Students</b></font></h3>
				</div>
				<div class="panel-body" style="margin-top:10px;">
				 	<div class="center-block">
						<div class="row">

						 	<div class="col-md-6" >
							 	<select name="dropcoll" class="form-control searchselect" id="dropcoll" required>
								   <?php $sql1=mysql_query("Select id,school_name,school_id,password from tbl_school_admin  where `school_name`!='' group by school_name order by `id` desc");?>
									    <option value="<?php echo $school_id; ?>" disabled selected>School/College Name</option>
										
										<?php while($row=mysql_fetch_array($sql1)){ ?>
										
										<option value="<?php echo $row['school_id']; ?>" <?php if($row['school_id']==$id){ echo "selected";}else{}?>><?php echo $row['school_name'];?></option>	
								    <?php }?>
							  	</select>
							</div>

							<div class="col-md-3">
								<input type="password" name="newpwd"  id="newpwd" placeholder="New Password" class="form-control" >
							</div>

							<div class="col-md-3">
								<input type="password" name="confirmpwd"  id="confirmpwd" placeholder="Confirm Password" class="form-control">
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row" align="center">
						  <div class="col-md-4" ></div>
						  <div  class="col-md-4" >
							 <input type="submit" name="submit" value="Submit" class="btn btn-success" />
						  </div>
						   <div class="col-md-3" ></div>
						   
			</div>
			<div class="row" style="padding:30px;padding-left:330px;">
	                                    <div class="col-md-10" style="color:#F00;"  id="error">
	                                        <b><?php echo $successreport1; ?></b>
	                                    </div>
	        </div>
			<div class="row" style="padding:30px;padding-left:350px;">
	            <div class="col-md-7" style="color:#008000;" align="center" id="error">
	                <b><?php echo $successreport; ?></b>
	            </div>
	        </div>	
		</div>			
	</div>		
</form>
</body>
</html>


