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
include("table_name_array.php");

 
 if(isset($_POST['submit']))
	 {   
		$id=$_POST['dropcoll']; 
		$reward = mysql_real_escape_string($_POST['rp']);
		
      				if($reward!='' && $id!='')
						{	
							$sql="INSERT INTO tbl_stud_first_login set school_id='$id', default_points ='$reward'";
							// echo $sql; exit;
							$insert=mysql_query($sql); 
							if($insert)	
							{
				$successreport="Points Inserted Successfully ";
							}
							else
							{
				$successreport1="Points Not Inserted";
							}
							
							
						}
						else
						{
							
		$successreport1="Please Try Again";
						}
	 }  
	
?>


<script>
	 $(document).ready(function() {
    	$('.searchselect').select2();
	});
function pvalid() {
//	alert("hiii");
			
			//validation for Country code
			var confirmpwd = document.getElementById("rp").value;
            if (confirmpwd.trim() == "" || confirmpwd.trim() == null) {
                document.getElementById("cpass").innerHTML = "Please Enter Reward Points";
                return false;
            }else{
                document.getElementById("cpass").innerHTML = ""; 
            }
		}
    </script>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title></title>
    <link rel="stylesheet" type="css" href="css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css"> -->
    <!-- <script src="//code.jquery.com/jquery-1.10.2.js"></script> -->
    <script src="js/jquery-1.11.1.min.js"></script>
    <!-- <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script> -->
	<!-- <script type="text/javascript" src="js/jquery.form.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css" rel="stylesheet" />
<style type="text/css">
	.row{
		padding-bottom: 10px;
	}
</style>
</head>
<body>
<form action="" method="POST" onsubmit="return pvalid();">
	<div class="row">
    <!-- <div class="col-md-1 "></div> -->
	  	<div class=" col-md-offset-1 col-md-10 col-md-offset-1">
			<div class="panel panel-danger " style="margin-top:22px;">
				<div class="panel-heading text-center">
				    <h3 class="panel-title"><font color="#580000"><b>Bulk Update for Reward Points </b></font></h3>
				</div>
				<div class="panel-body" style="margin-top:10px;">
				 	<div class="center-block">
						<div class="row">
						 	<label for="type" class ="control-label col-md-3"> Select School Name:</label>
						 	<div class="col-md-6" >
							 	<select name="dropcoll" class="form-control searchselect" id="dropcoll" required>
								   <?php $sql1=mysql_query("Select id,school_name,school_id,password from tbl_school_admin  where `school_name`!='' group by school_name order by `id` desc");?>
									    <option value="<?php echo $school_id; ?>" disabled selected>School/College Name</option>
										
										<?php while($row=mysql_fetch_array($sql1)){ ?>
										
										<option value="<?php echo $row['school_id']; ?>" <?php if($row['school_id']==$id){ echo "selected";}else{}?>><?php echo $row['school_name'];?></option>	
								    <?php }?>
							  	</select>
							</div>
						</div>
						<div class="row">
							<label for="type" class ="control-label col-md-3">Default Reward points:</label>
							<div class="col-md-3">
								<input type="text" name="rp"  id="rp" placeholder="Default points for student" class="form-control">
							</div>
							<div class="col-md-6 text-danger" id="cpass"></div>
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


