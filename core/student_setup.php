<?php
//Code updated by Rutuja Jori for adding Reporting Manager for Employee for HR Admin on 16/12/2019 for SMC-4270
if (isset($_GET['std_prn']) == '') {
	//add student setup
	session_start();
	include_once("function.php");
	//include_once('conn.php');

	if (isset($_GET['student_id'])) {
		$report = "";
		include_once("school_staff_header.php");
		if (isset($_POST['update'])) {
			$stuID = $_GET['student_id'];



			$roll_no = $_POST['roll_no'];
			$id_first_name = $_POST['id_first_name'];
			$id_first_name1 = $_POST['id_first_name1'];
			$id_last_name1 = $_POST['id_last_name1'];
			// $father_name=$id_first_name1." ".$id_last_name1;
			$father_name = $id_first_name1;
			$id_email = $_POST['id_email'];
			$id_phone = $_POST['id_phone'];
			$id_checkin = $_POST['id_checkin'];
			$id_gender = $_POST['gender'];
			$id_address = $_POST['id_address'];

			if ($_POST['country'] == -1) {
				$country = $_POST['country1'];
			} else {
				$country = $_POST['country'];
			}
			if (isset($_POST['state']) && $_POST['state'] != '') {
				$state = $_POST['state'];
			} else {
				$state = $_POST['state1'];
			}


			$cls = $_POST['class'];
			// Null condition added by Rutuja on 30/12/2019 if $class is empty for SMC-4300
			$class = !empty($cls) ? "'$cls'" : "NULL";
			$city = $_POST['city'];
			$div = $_POST['div'];

			// Start SMC-3495 Modify By yogesh 2018-10-10 07:04 PM 
			//$id_date = date('m/d/Y');
			$id_date = CURRENT_TIMESTAMP; // define in core/securityfunctions.php
			//end SMC-3495
			$id_first_name = trim($id_first_name);
			$password = $id_first_name . "123";



			list($year, $month, $day) = explode("-", $id_checkin);
			$year_diff  = date("Y") - $year;
			$month_diff = date("m") - $month;
			$day_diff   = date("d") - $day;
			if ($day_diff < 0 || $month_diff < 0) $year_diff--;
			$age = $year_diff;

			$prepAddr = str_replace(' ', '+', $id_address);
			$geocode = file_get_contents('http://maps.google.com/maps/api/geocode/json?address=' . $prepAddr . '&sensor=false');
			$output = json_decode($geocode);
			$lat = $output->results[0]->geometry->location->lat;
			$long = $output->results[0]->geometry->location->lng;



			$update = "update tbl_student set Roll_no='$roll_no',std_name='$id_first_name',std_Father_name='$father_name',std_class='$class',std_div='$div', std_address='$id_address', std_city='$city',std_dob='$id_checkin', std_gender='$id_gender', std_country='$country', std_email='$id_email',std_age='$age',latitude='$lat',longitude='$long',std_phone='$id_phone',std_state='$state' where id=" . $stuID . "";

			$result_update = mysql_query($update) or die(mysql_error());
			if ($result_update >= 1) {

				$to = $id_email;
				$from = "smartcookiesprogramme@gmail.com";
				$subject = "Succesful Registration";

				$message = "Hello " . $id_first_name . " " . $id_last_name . "\r\n\r\n" .
					"Thanks for your registration with Smart Cookie as student\r\n" .
					"your Username is: "  . $id_email .  "\n\n" .
					"your Password is: " . $password . "\n\n" .
					"your School ID is: " . $school_id . "\n\n" .
					"Regards,\r\n" .
					"Smart Cookie Admin";

				mail($to, $subject, $message);
				$studentname = "student";
				$report = "successfully Registered";
				header("Location:studentlist.php?name=" . $studentname);
			}
			//	}
			else {
				$report = "Email ID is already present";
			}
		}
		//}
?>

		<!DOCTYPE html>

		<head>
			<style>
				.error {
					color: #FF0000;
				}
			</style>
			<link href='css/datepicker.min.css' rel='stylesheet' type='text/css'>
			<script src='js/bootstrap-datepicker.min.js' type='text/javascript'></script>
			<script src='js/bootstrap-switch.min.js' type='text/javascript'></script>
			<script src='js/bootstrap-multiselect.js' type='text/javascript'></script>
			<script>
				function isNumberKey(evt) {
					var charCode = (evt.which) ? evt.which : event.keyCode
					if (charCode > 31 && (charCode < 48 || charCode > 57))
						return false;
					return true;
				}
			</script>
			<script>
				function showOrhide() {

					if (document.getElementById("firstBtn")) {

						document.getElementById('text_country1').style.display = "block";
						document.getElementById('text_country').style.display = "none";
						document.getElementById('text_state1').style.display = "block";
						document.getElementById('text_state').style.display = "none";
						return false;
					}


				}
			</script>
			<script type="text/javascript">
				$(document).ready(function() {

					$('#country').change(function() {

						var country = document.getElementById("country").value;

						if (country == '-1') {

							document.getElementById('errorcountry').innerHTML = 'Please enter country';

							return false;
						}




					});
				});
			</script>


			<script type="text/javascript">
				$(document).ready(function() {

					$('#state').change(function() {

						var state = document.getElementById("state").value;

						if (state == null || state == "") {

							document.getElementById('errorstate').innerHTML = 'Please enter State';

							return false;
						} else

						{
							document.getElementById('errorstate').innerHTML = '';


						}


					});
				});
			</script>
			<style>
				body {
					background-color: #F8F8F8;
				}

				.indent-small {
					margin-left: 5px;
				}

				.form-group.internal {
					margin-bottom: 0;
				}

				.dialog-panel {
					margin: 10px;
				}

				.panel-body {
					font: 600 15px "Open Sans", Arial, sans-serif;
				}

				label.control-label {
					font-weight: 600;
					color: #777;
				}
			</style>
			<script src="js/city_state.js" type="text/javascript"></script>
			<script>
				/*$(document).ready(function() {  
  $('.multiselect').multiselect();
  $('.datepicker').datepicker();  
   $( "id_checkin" ).datepicker({  maxDate: 0 });
});
*/


				function valid() {


					var roll_no = document.getElementById("roll_no").value;



					if (roll_no == null) {

						document.getElementById('errorrollno').innerHTML = 'Please Enter Roll No';

						return false;
					}

					regx1 = /^[A-z ]+$/;
					//validation for name
					if (!regx1.test(first_name) || !regx1.test(last_name)) {
						document.getElementById('errorrollno').innerHTML = 'Please Enter valid Name';
						return false;
					}

					var id_checkin = document.getElementById("id_checkin").value;
					if (id_checkin == "") {


						document.getElementById('errordob').innerHTML = 'Please Enter Date of Birth';

						return false;
					}
					var experience = document.getElementById("experience").value;
					if (experience == null || experience == "") {

						document.getElementById('errorexperience').innerHTML = 'Please Enter Experience';

						return false;
					}
					var gender1 = document.getElementById("gender1").checked;

					var gender2 = document.getElementById("gender2").checked;

					if (gender1 == false && gender2 == false) {
						document.getElementById('errorgender').innerHTML = 'Please Select gender';
						return false;
					}



					var email = document.getElementById("id_email").value;
					if (email == null || email == "") {

						document.getElementById('erroremail').innerHTML = 'Please Enter email';

						return false;
					}

					//validation of email
					var atpos = email.indexOf("@");
					var dotpos = email.lastIndexOf(".");
					if (atpos < 1 || dotpos < atpos + 2 || dotpos + 2 >= email.length) {
						document.getElementById('erroremail').innerHTML = 'Please enter valid Email Id';
						return false;
					}
					var address = document.getElementById("id_address").value;
					if (address == null || address == "") {

						document.getElementById('erroraddress').innerHTML = 'Please Enter address';

						return false;
					}

					var country = document.getElementById("country").value;

					if (country == "-1") {

						document.getElementById('errorcountry').innerHTML = 'Please Enter country';

						return false;
					}

					var state = document.getElementById("state").value;
					if (state == null || state == "") {

						document.getElementById('errorstate').innerHTML = 'Please Enter state';

						return false;
					} else {
						document.getElementById('errorstate').innerHTML = '';

					}
					var city = document.getElementById("id_city").value;

					if (city == null || city == "") {

						document.getElementById('errorcity').innerHTML = 'Please Enter city';

						return false;
					} else if (!regx1.test(city)) {
						document.getElementById('errorcity').innerHTML = 'Please Enter city';

						return false;

					} else {
						document.getElementById('errorcity').innerHTML = '';



					}

				}
			</script>

		</head>

		<body>

			<div class='panel panel-primary dialog-panel'>
				<div style="color:red;font-size:15px;font-weight:bold;margin-top:5px;" class="col-md-offset-6"> <?php if (isset($_GET['report'])) {
																													echo $_GET['report'];
																												};
																												echo $report; ?></div>
				<div class='panel-heading'>
					<h3 align="center">Edit <?php echo $dynamic_student; ?> Registration</h3>
					<!-- <h5 align="center"><a href="Add_studentSheet.php?id=<? //=$studentID
																				?>">Add Excel Sheet</a></h5>-->

					<!--Removed Add excel sheet option for SMC-4443 by Sayali Balkawade on 18/01/2020 -->
					<!-- <h5 align="center"><a href="Add_studentSheet_20150626PT.php?id=<?= $studentID ?>">Add Excel Sheet</a></h5>-->

					<!--In Title renamed All by Asterisk by Pranali for SMC-5001-->
					<h5 align="center"><b style="color:red;">Asterisk Fields Are Mandatory</b></h5>
				</div>
				<?php
				$studentID = $_GET['student_id'];
				$get_std_id = mysql_query("select * from tbl_student where id=" . $studentID . "");
				$row = mysql_fetch_array($get_std_id);
				$row['id'];
				?>
				<div class='panel-body'>
					<form class='form-horizontal' role='form' method="post" action="" onSubmit="return valid()">

						<div class='form-group'>
							<label class='control-label col-md-2 col-md-offset-2' style="text-align:left;">Roll No</label>


							<div class='col-md-2' style="text-align:left;">
								<input class='form-control' id='roll_no' name="roll_no" placeholder='Enter Roll No' type='text' onKeyPress="return isNumberKey(event)">
							</div>
							<div class='col-md-3 ' id="errorrollno" style="color:#FF0000"> </div>

						</div>

						<div class="row">
							<label class='control-label col-md-2 col-md-offset-2' style="text-align:left;"><?php echo $dynamic_student; ?> Name</label>
							<div class='col-md-2' style="text-align:left;">
								<input class='form-control' id='id_first_name' value="<?= $row['std_name']; ?>" name="id_first_name" placeholder='First Name' type='text'>
								<span class="error">*</span><br>
							</div>

						</div>
						<?php
						$fathrName = explode(" ", $row['std_Father_name']);

						?>
						<div class='form-group'>
						</div>
						<div class='form-group'>
							<label class='control-label col-md-2 col-md-offset-2' style="text-align:left;">Father Name</label>
							<div class='col-md-3 ' style="text-align:left;">

								<input class='form-control' id='id_first_name_f' name="id_first_name1" value="<?= $fathrName['0']; ?>" placeholder='First Name' type='text'>
							</div>

							<div class='col-md-3 '>
								<input class='form-control' id='id_last_name_f' name="id_last_name1" value="<?= $fathrName['1']; ?>" placeholder='Last Name' type='text'>
							</div>
						</div>

						<div class='col-md-8 col-md-offset-4' id="errorfatname" style="color:#FF0000"></div>

						<div class="form-group">
							<label class='control-label col-md-2 col-md-offset-2' style="text-align:left;">Class</label>



							<div class='col-md-2' style="text-align:left;">
								<input class='form-control' id="id_class" value="<?= $row['std_class']; ?>" name="class" placeholder='Enter Class' type='text'>
							</div>

							<label class='control-label col-md-1' style="text-align:left;">Division</label>


							<div class='col-md-2' style="text-align:left;">
								<select class='form-control' id='id_div' name="div" placeholder='Enter Division'>

									<?php
									$sql = mysql_query('select * from Division where school_id=$school_id');
									while ($arr = mysql_fetch_array($sql)) {
									?>
										<option value="<?php echo $arr['DivisionName']; ?>"><?php echo $arr['DivisionName']; ?></option>
									<?php
									}


									?>
								</select>
							</div>
						</div>
						<div class='col-md-10 col-md-offset-3' id="errordiv" style="color:#FF0000"></div>
						<div class='form-group'>
							<label class='control-label col-md-2 col-md-offset-2' for='id_email' style="text-align:left;">Contact</label>
							<div class='col-md-3' style="text-align:left;">
								<input class='form-control' id='id_email' name="id_email" value="<?= $row['std_email']; ?>" placeholder='E-mail' type='text'>
							</div>
							<div class='col-md-3'>
								<input class='form-control' id='id_phone' name="id_phone" value="<?= $row['std_phone']; ?>" placeholder='Mobile No' type='text' onChange="PhoneValidation(this);">
							</div>
						</div>
						<div class='col-md-10 col-md-offset-4' id="errorphone" style="color:#FF0000"></div>

						<div class='form-group'>
							<label class='control-label col-md-2 col-md-offset-2' style="text-align:left;">Date Of Birth</label>
							<div class='col-md-3' style="text-align:left;">
								<input class='form-control datepicker' id='id_checkin' value="<?= $row['std_dob']; ?>" name="id_checkin" placeholder='mm/dd/yyyy'>
							</div>
						</div>
						<div class='col-md-10 col-md-offset-3 ' id="errordob" style="color:#FF0000"></div>
						<div class='form-group'>
							<label class='control-label col-md-2 col-md-offset-2' style="text-align:left;">Gender</label>
							<div class='col-md-2' style="font-weight: 600;color: #777;">
								<input type="radio" name="gender" <?php echo ($row['std_gender'] == "Male") ? "checked" : "" ?> id="gender1" value="Male"> Male
							</div>
							<div class='col-md-2' style="font-weight: 600; color: #777;">
								<input type="radio" name="gender" <?php echo ($row['std_gender'] == "Female") ? "checked" : "" ?> id="gender2" value="Female"> Female
							</div>
							<div class='col-md-4 indent-small' id="errorgender" style="color:#FF0000"> </div>
						</div>

						<div class='form-group'>
							<label class='control-label col-md-2 col-md-offset-2' style="text-align:left;">Address</label>
							<div class='col-md-3' style="text-align:left;">
								<textarea class='form-control' id='id_address' name="id_address" placeholder='Address' rows='3'><?= $row['std_address']; ?></textarea>
							</div>




							<div class="row" align="center" id='erroraddress' style="color:#FF0000;"></div>
							<div class="row" style="padding-top:7px;" id="text_country" style="display:block">
								<div class="col-md-5">
									<h4 align="left">Country:</h4>
								</div>
								<div class="col-md-5"><input type="text" class='form-control' id="country1" name="country1" style="width:100%;" value="<?= $row['std_country']; ?>" readonly>
								</div>
								<div class="col-md-1" id="firstBtn"><a href="" onClick="return showOrhide()">Edit</a></div>
							</div>
							<div class='row ' style="padding-top:7px; display:none" id="text_country1">
								<div class="col-md-5">
									<h4 align="left">Country </h4>
								</div>
								<div class='col-md-5'>
									<select id="country" name="country" class='form-control'></select>
								</div>
								<div class='col-md-3 indent-small' id="errorcountry" style="color:#FF0000"></div>
							</div>
							<div class='row ' style="padding-top:7px; display:none" id="text_state1">
								<div class="col-md-5">
									<h4 align="left">State </h4>
								</div>
								<div class='col-md-5'>
									<select id="state" name="state" class='form-control'></select>
								</div>
								<div class='col-md-3 indent-small' id="errorstate" style="color:#FF0000"><?php // echo $report4; 
																											?></div>
							</div>
							<div class="row" style="padding-top:7px;" id="text_state" style="display:block">
								<div class="col-md-5">
									<h4 align="left"> State:</h4>
								</div>
								<div class="col-md-5"> <input type="text" id="state1" name="state1" class='form-control' style="width:100%;" value="<?= $row['std_state'] ?>" readonly>
								</div>
							</div>
							<script language="javascript">
								populateCountries("country", "state");
								populateCountries("country2");
							</script>
							<div class='form-group'>
								<label class='control-label col-md-2 col-md-offset-2' style="text-align:left;">City</label>
								<div class='col-md-3' style="text-align:left;">
									<input type="text" class='form-control' id='id_accomodation' value="<?= $row['std_city']; ?>" name='city' placeholder="city">
								</div>
								<div class='col-md-4 indent-small' id="errorcity" style="color:#FF0000"></div>
							</div>

							<script>
								function goBack() {
									window.history.back(-2);
								}
							</script>
							<div class='form-group'>
								<div class='col-md-3 col-md-offset-3'>
									<input class='btn-lg btn-primary' type='submit' value="Update" name="update" onClick="return valid()" />
								</div>
								<div class='col-md-2'>
									<button class='btn-lg btn-danger' type='reset'>Reset</button>
								</div>
							</div>
					</form>
				</div>
			</div>
		</body>

		</html>
	<?php
	} else if (isset($_GET['id'])) {
		$report = "";
		include_once("school_staff_header.php");


		if (isset($_POST['submit'])) {

			$roll_no = $_POST['roll_no'];
			$id_first_name = $_POST['id_first_name'];
			//echo "</br>id_last_name-->".$id_last_name = $_POST['id_last_name'];

			//	echo "</br>name-->".$name = $id_first_name." ".$id_last_name;

			$id_first_name1 = $_POST['id_first_name1'];
			$id_last_name1 = $_POST['id_last_name1'];
			$father_name = $id_first_name1 . " " . $id_last_name1;
			//retrive school_id and name school_admin


			$results = mysql_query("select * from tbl_school_adminstaff where id=" . $_GET['id'] . "");
			$arrs = mysql_fetch_array($results);

			$school_id = $arrs['school_id'];

			$r = mysql_query("select * from tbl_school where id=" . $school_id . "");
			$ar = mysql_fetch_array($r);

			$school_name = $ar['school_name'];
			$sc_staff_id = $arrs['id'];
			 $id_email = $_POST['id_email'];

			$arr = mysql_query("select * from tbl_student where std_email = '$id_email'");
			if (mysql_num_rows($arr) <= 0) {
				$id_phone = $_POST['id_phone'];
				/*$id_password = $_POST['id_password'];*/
				$id_checkin = $_POST['id_checkin'];
				$id_gender = $_POST['gender'];
				/*$id_education = $_POST['id_education'];*/
				$id_address = $_POST['id_address'];
				$id_country = $_POST['id_country'];
				$id_state = $_POST['state'];
				$class = $_POST['class'];
				$id_email= $_POST[''];
				$city = $_POST['city'];
				$div = $_POST['div'];

				// Start SMC-3495 Modify By yogesh 2018-10-10 07:04 PM 
				//$id_date = date('m/d/Y');
				$id_date = CURRENT_TIMESTAMP; // define in core/securityfunctions.php
				//end SMC-3495

				$id_first_name = trim($id_first_name);
				//$password = $id_first_name."123";
				$password = $roll_no;


				list($year, $month, $day) = explode("-", $id_checkin);

				$year_diff  = date("Y") - $year;
				$month_diff = date("m") - $month;
				$day_diff   = date("d") - $day;
				if ($day_diff < 0 || $month_diff < 0) $year_diff--;
				$age = $year_diff;

				$prepAddr = str_replace(' ', '+', $id_address);
				$geocode = file_get_contents('http://maps.google.com/maps/api/geocode/json?address=' . $prepAddr . '&sensor=false');
				$output = json_decode($geocode);
				$lat = $output->results[0]->geometry->location->lat;
				$long = $output->results[0]->geometry->location->lng;


				$sqls = "INSERT INTO tbl_student(Roll_no,std_name,std_Father_name,std_school_name,school_id,sc_staff_id,std_class,std_div, std_address, std_city, std_dob, std_gender, std_country,std_email,std_date,std_age,std_password,latitude,longitude,std_phone,std_state) VALUES ('$roll_no','$id_first_name','$father_name', '$school_name','$school_id','$sc_staff_id','$class','$div','$id_address','$city','$id_checkin','$id_gender','$id_country','$id_email', '$id_date','$age','$password','$lat','$long','$id_phone','$id_state')";

				$result_insert = mysql_query($sqls) or die(mysql_error());
				if ($result_insert >= 1) {

					$to = $id_email;
					$from = "smartcookiesprogramme@gmail.com";
					$subject = "Succesful Registration";

					$message = "Hello " . $id_first_name . " " . $id_last_name . "\r\n\r\n" .
						"Thanks for your registration with Smart Cookie as student\r\n" .
						"your Username is: "  . $id_email .  "\n\n" .
						"your Password is: " . $password . "\n\n" .
						"your School ID is: " . $school_id . "\n\n" .
						"Regards,\r\n" .
						"Smart Cookie Admin";

					mail($to, $subject, $message);

					$report = "successfully Registered";


					//header("Location:student_setup.php?report=".$report);
				}
			} else {
				$report = "Email ID is already present";
			}
		}
		//}
	?>

		<!DOCTYPE html>

		<head>

			<link href='css/datepicker.min.css' rel='stylesheet' type='text/css'>
			<script src='js/bootstrap-datepicker.min.js' type='text/javascript'></script>
			<script src='js/bootstrap-switch.min.js' type='text/javascript'></script>
			<script src='js/bootstrap-multiselect.js' type='text/javascript'></script>
			<style>
				body {
					background-color: #F8F8F8;
				}

				.indent-small {
					margin-left: 5px;
				}

				.form-group.internal {
					margin-bottom: 0;
				}

				.dialog-panel {
					margin: 10px;
				}

				.panel-body {
					font: 600 15px "Open Sans", Arial, sans-serif;
				}

				label.control-label {
					font-weight: 600;
					color: #777;
				}
			</style>
			<script src="js/city_state.js" type="text/javascript"></script>
			<script>
				function isNumberKey(evt) {
					var charCode = (evt.which) ? evt.which : event.keyCode
					if (charCode > 31 && (charCode < 48 || charCode > 57))
						return false;
					return true;
				}
			</script>
			<script>
				$(document).ready(function() {
					$('.multiselect').multiselect();
					$('.datepicker').datepicker();
				});

				<?php /*?> var reg = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;  
      function PhoneValidation(phoneNumber)
      {  
        var OK = reg.exec(phoneNumber.value);  
        if (!OK)  
         document.getElementById('errorphone').innerHTML='Please Enter Valid Phone Number';
		 return false;
       
      }<?php */ ?>

				function valid() {


					var roll_no = document.getElementById("roll_no").value;



					if (roll_no == null) {

						document.getElementById('errorrollno').innerHTML = 'Please Enter Roll No';

						return false;
					}

					regx1 = /^[A-z ]+$/;
					//validation for name
					if (!regx1.test(first_name) || !regx1.test(last_name)) {
						document.getElementById('errorrollno').innerHTML = 'Please Enter valid Name';
						return false;
					}

					var id_checkin = document.getElementById("id_checkin").value;
					if (id_checkin == "") {


						document.getElementById('errordob').innerHTML = 'Please Enter Date of Birth';

						return false;
					}
					var experience = document.getElementById("experience").value;
					if (experience == null || experience == "") {

						document.getElementById('errorexperience').innerHTML = 'Please Enter Experience';

						return false;
					}
					var gender1 = document.getElementById("gender1").checked;

					var gender2 = document.getElementById("gender2").checked;

					if (gender1 == false && gender2 == false) {
						document.getElementById('errorgender').innerHTML = 'Please Select gender';
						return false;
					}


					var subject = document.getElementById("subject").value;
					if (subject == null || subject == "") {

						document.getElementById('errorsubject').innerHTML = 'Please Enter Subject';

						return false;
					}
					var email = document.getElementById("id_email").value;
					if (email == null || email == "") {

						document.getElementById('erroremail').innerHTML = 'Please Enter email';

						return false;
					}

					//validation of email
					var atpos = email.indexOf("@");
					var dotpos = email.lastIndexOf(".");
					if (atpos < 1 || dotpos < atpos + 2 || dotpos + 2 >= x.length) {
						document.getElementById('erroremail').innerHTML = 'Please enter valid Email Id';
						return false;
					}
					var address = document.getElementById("id_address").value;
					if (address == null || address == "") {

						document.getElementById('erroraddress').innerHTML = 'Please Enter address';

						return false;
					}
					var country = document.getElementById("country").value;

					if (country == "-1") {

						document.getElementById('errorcountry').innerHTML = 'Please Enter country';

						return false;
					}

					var state = document.getElementById("state").value;
					if (state == null || state == "") {

						document.getElementById('errorstate').innerHTML = 'Please Enter state';

						return false;
					}
					var city = document.getElementById("id_city").value;

					if (city == null || city == "") {

						document.getElementById('errorcity').innerHTML = 'Please Enter city';

						return false;
					}

				}
			</script>

		</head>

		<body>

			<div class='panel panel-primary dialog-panel'>
				<div style="color:red;font-size:15px;font-weight:bold;margin-top:5px;" class="col-md-offset-6"> <?php if (isset($_GET['report'])) {
																													echo $_GET['report'];
																												};
																												echo $report; ?></div>
				<div class='panel-heading'>
					<h3 align="center"><?php echo $dynamic_student; ?> Registration</h3>
					<!--Removed Add excel sheet option for SMC-4443 by Sayali Balkawade on 18/01/2020 -->
					<!-- <h5 align="center"><a href="Add_studentSheet.php" >Add Excel Sheet</a></h5>-->
					<h5 align="center"><b style="color:red;">Asterisk Fields Are Mandatory</b></h5>
				</div>

				<div class='panel-body'>
					<form class='form-horizontal' role='form' method="post" action="" onSubmit="return valid()">

						<div class='form-group'>
							<label class='control-label col-md-2 col-md-offset-2' style="text-align:left;">Roll No</label>


							<div class='col-md-2' style="text-align:left;">
								<input class='form-control' id='roll_no' name="roll_no" placeholder='Enter Roll No' type='text' onKeyPress="return isNumberKey(event)">
							</div>

							<div class='col-md-3 ' id="errorrollno" style="color:#FF0000"> </div>
						</div>

						<div class="row">
							<label class='control-label col-md-2 col-md-offset-2' style="text-align:left;"><?php echo $dynamic_student; ?> Name</label>
							<div class='col-md-2' style="text-align:left;">
								<input class='form-control' id='id_first_name' name="id_first_name" placeholder='First Name' type='text'>

							</div>
							<span style="color:#FF0000">*</span>
						</div>
						<span style="color:#FF0000">*</span>

						<div class='form-group'>
						</div>
						<div class='form-group'>
							<label class='control-label col-md-2 col-md-offset-2' style="text-align:left;">Father Name</label>
							<div class='col-md-3 ' style="text-align:left;">

								<input class='form-control' id='id_first_name_f' name="id_first_name1" placeholder='First Name' type='text'>

							</div>

							<div class='col-md-3 '>
								<input class='form-control' id='id_last_name_f' name="id_last_name1" placeholder='Last Name' type='text'>
							</div>
						</div>

						<div class='col-md-8 col-md-offset-4' id="errorfatname" style="color:#FF0000"></div>

						<div class="form-group">
							<label class='control-label col-md-2 col-md-offset-2' style="text-align:left;">Class</label>



							<div class='col-md-2' style="text-align:left;">
								<input class='form-control' id="id_class" name="class" placeholder='Enter Class' type='text'>
							</div>

							<label class='control-label col-md-1' style="text-align:left;">Division</label>


							<div class='col-md-2' style="text-align:left;">
								<select class='form-control' id='id_div' name="div" placeholder='Enter Division'>

									<?php
									$sql = mysql_query('select * from Division where school_id=$school_id');
									while ($arr = mysql_fetch_array($sql)) {
									?>
										<option value="<?php echo $arr['DivisionName']; ?>"><?php echo $arr['DivisionName']; ?></option>
									<?php
									}


									?>
								</select>
							</div>
						</div>
						<div class='col-md-10 col-md-offset-3' id="errordiv" style="color:#FF0000"></div>


						<div class='form-group'>
							<label class='control-label col-md-2 col-md-offset-2' for='id_email' style="text-align:left;">Contact</label>
							<div class='col-md-3' style="text-align:left;">
								<input class='form-control' id='id_email' name="id_email" placeholder='E-mail' type='text'>
							</div>
							<div class='col-md-3'>
								<input class='form-control' id='id_phone' name="id_phone" placeholder='Mobile No' type='text' onChange="PhoneValidation(this);">
							</div>
						</div>
						<div class='col-md-10 col-md-offset-4' id="errorphone" style="color:#FF0000"></div>

						<div class='form-group'>
							<label class='control-label col-md-2 col-md-offset-2' style="text-align:left;">Date Of Birth</label>
							<div class='col-md-3' style="text-align:left;">
								<input class='form-control datepicker' id='id_checkin' name="id_checkin" placeholder='mm/dd/yyyy'>
							</div>
						</div>
						<div class='col-md-10 col-md-offset-3 ' id="errordob" style="color:#FF0000"></div>
						<div class='form-group'>
							<label class='control-label col-md-2 col-md-offset-2' style="text-align:left;">Gender</label>
							<div class='col-md-2' style="font-weight: 600;color: #777;">
								<input type="radio" name="gender" id="gender1" value="Male"> Male
							</div>
							<div class='col-md-2' style="font-weight: 600; color: #777;">
								<input type="radio" name="gender" id="gender2" value="Female"> Female
							</div>
							<div class='col-md-4 indent-small' id="errorgender" style="color:#FF0000"> </div>
						</div>
						<div class='form-group'>
							<label class='control-label col-md-2 col-md-offset-2' style="text-align:left;">Address</label>
							<div class='col-md-3' style="text-align:left;">
								<textarea class='form-control' id='id_address' name="id_address" placeholder='Address' rows='3'></textarea>
							</div>
							<div class='col-md-4 indent-small' id="erroraddress" style="color:#FF0000"></div>
						</div>
						<div class="form-group">
							<label class='control-label col-md-2 col-md-offset-2' style="text-align:left;">Country</label>
							<div class='col-md-3' style="text-align:left;">
								<select id="country" name="id_country" class='form-control'>
									<option value='select'>select</option>
								</select>

							</div>

							<label class='control-label col-md-1 ' style="text-align:left;">State</label>
							<div class='col-md-3' style="text-align:left;">
								<select name='state' id='state' class='form-control'>
									<option value='select'>select</option>
								</select>
							</div>
						</div>
						<div class='col-md-10 indent-small col-md-offset-4' id="errorstate" style="color:#FF0000"> </div>
						<script language="javascript">
							populateCountries("country", "state");
							populateCountries("country2");
						</script>

						<div class='form-group'>
							<label class='control-label col-md-2 col-md-offset-2' style="text-align:left;">City</label>
							<div class='col-md-3' style="text-align:left;">
								<input type="text" class='form-control' id='id_accomodation' name='city' placeholder="city">
							</div>
							<div class='col-md-4 indent-small' id="errorcity" style="color:#FF0000"></div>
						</div>
						<div class='form-group'>
							<div class='col-md-3 col-md-offset-3'>
								<input class='btn-lg btn-primary' type='submit' value="Submit" name="submit" onClick="return valid()" />
							</div>
							<div class='col-md-2'>
								<button class='btn-lg btn-danger' type='reset'>Reset</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</body>

		</html>

	<?php
	} else {
		//Changes done by Pranali on 26-06-2018 for bug SMC-3200

		$sc_id = $_SESSION['school_id'];

		//changes end
	?>
		<?php
		$report = "";
		if (isset($_GET['name'])) {
			include_once('school_staff_header.php');
			$table = "tbl_school_adminstaff";
			//$id = $_SESSION['staff_id'];

		} else {
			include_once('scadmin_header.php');
			/*$table="tbl_school_admin";  */
		}
		//include("scadmin_header.php");
		//Below web service called by Rutuja for fetching Country, State and city dynamically depending on the values selected for SMC-5193 on 10-03-2021
		$url = $GLOBALS['URLNAME'] . "/core/Version5/city_state_list.php";
		//$url = "https://dev.smartcookie.in/core/Version5/city_state_list.php";
		$data = array("keyState" => '1234', "country" => '', "state" => '');

		$ch = curl_init($url);
		$data_string = json_encode($data);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen($data_string)));
		$country_ar = json_decode(curl_exec($ch), true);

		if (isset($_POST['submit'])) {
			$roll_no = $_POST['roll_no'];
			$std_branch = $_POST['std_branch'];
			$id_first_name = $_POST['id_first_name'];
			$id_last_name = $_POST['id_last_name'];

			$id_first_name1 = $_POST['id_first_name1'];
			$id_last_name1 = $_POST['id_last_name1'];
			$name = $id_first_name . " " . $id_last_name1;
			$complete_name = $id_first_name . " " . $id_first_name1 . " " . $id_last_name1;
			// $father_name=$id_first_name1." ".$id_last_name1;
			$father_name = $id_first_name1;
			//retrive school_id and name school_admin

			if ($_SESSION['usertype'] == 'HR Admin Staff' or $_SESSION['usertype'] == 'School Admin Staff') {
				$sc_id = $_SESSION['school_id'];
				$query2 = mysql_query("select id from tbl_school_admin where school_id ='$sc_id'");

				$value2 = mysql_fetch_array($query2);

				$id = $value2['id'];
			} else {
				$id = $_SESSION['id'];
			}
			$fields = array("id" => $id);
			$table = "tbl_school_admin";

			$smartcookie = new smartcookie();

			$results = $smartcookie->retrive_individual($table, $fields);
			$arrs = mysql_fetch_array($results);

			//school_id taken from session and school_name taken from tbl_school_admin table by Pranali for SMC-5001
			$school_id = $_SESSION['school_id'];

			$school_sql = mysql_query("SELECT school_name FROM tbl_school_admin WHERE school_id='$school_id'");
			$sc_res = mysql_fetch_array($school_sql);

			$school_name = $sc_res['school_name'];
			$id_email = $_POST['id_email'];
			$in_email = $_POST['in_email'];
			$arr = mysql_query("select * from tbl_student where std_email='$id_email' and  school_id='$school_id'");
			
			if (mysql_num_rows($arr) <= 0) {




				$id_phone = $_POST['id_phone'];
				/*$id_password = $_POST['id_password'];*/
				$id_checkin = $_POST['id_checkin'];
				$id_gender = $_POST['gender'];
				/*$id_education = $_POST['id_education'];*/
				$id_address = $_POST['id_address'];
				$t_address = $_POST['t_address'];
				//$id_country = $_POST['id_country'];
				$c = $_POST['country1'];
				$coun = explode(",", $c);
				$id_country = $coun[0];
				$calling_code = $coun[1];
				$id_state = $_POST['state'];
				if ($user == 'HR Admin') {
					$school_type = 'organization';
					$entity_type_id = '205';
				} else {
					$school_type = 'school';
					$entity_type_id = '105';
				}
				$cls = $_POST['class'];
				// Null condition added by Rutuja on 30/12/2019 if $class is empty for SMC-4300
				$class = !empty($cls) ? "'$cls'" : "NULL";
				$city = $_POST['city'];
				$div = $_POST['div1'];
				$emp_desig = $_POST['emp_designation'];
				$reporting_id = $_POST['reporting_id'];

				$std_branch = $_POST['std_branch'];
				$Specialization = $_POST['Specialization'];
				$CourseLevel = $_POST['CourseLevel'];
				$BranchName1 = $_POST['BranchName'];
				$BranchName2 = explode(",", $BranchName1);
				$BranchName = $BranchName2[1];
				$Branchid = $BranchName2[0];

				$Intruduce_YeqarID1 = $_POST['Intruduce_YeqarID'];
				$Intruduce_YeqarID2 = explode(",", $Intruduce_YeqarID1);
				$Intruduce_YeqarID = $Intruduce_YeqarID2[2];
				$std_year = $Intruduce_YeqarID2[0];
				$Year = $Intruduce_YeqarID2[1];

				$PermanentVillage = $_POST['PermanentVillage'];
				$PermanentTaluka = $_POST['PermanentTaluka'];
				$PermanentDistrict = $_POST['PermanentDistrict'];
				$PermanentPincode = $_POST['PermanentPincode'];

				$DeptName1 = $_POST['DeptName'];
				$DeptName2 = explode(",", $DeptName1);
				$DeptName = $DeptName2[1];
				$Deptid = $DeptName2[0];

				$SemesterName1 = $_POST['SemesterName'];
				$SemesterName2 = explode(",", $SemesterName1);
				$SemesterName = $SemesterName2[1];
				$Semesterid = $SemesterName2[0];

				//$id_date = date('Y/m/d');
				// Start SMC-3495 Modify By yogesh 2018-10-10 07:04 PM 
				//$id_date = date('m/d/Y');
				$id_date = CURRENT_TIMESTAMP; // define in core/securityfunctions.php
				//end SMC-3495

				$id_first_name = trim($id_first_name);
				//Password=PRN added by Rutuja for SMC-5168 on 19-01-2021
				$password = $roll_no;
				//$password = $id_first_name."123";


				list($month, $day, $year) = explode("/", $id_checkin);


				$year_diff  = date("Y") - $year;
				$month_diff = date("m") - $month;
				$day_diff   = date("d") - $day;
				if ($day_diff < 0 || $month_diff < 0) $year_diff--;

				$age = $year_diff;


				$dateformat = $year . "-" . $month . "-" . $day;

				$prepAddr = str_replace(' ', '+', $id_address);
				$geocode = file_get_contents('http://maps.google.com/maps/api/geocode/json?address=' . $prepAddr . '&sensor=false');
				$output = json_decode($geocode);
				$lat = $output->results[0]->geometry->location->lat;
				$long = $output->results[0]->geometry->location->lng;
				if ($reporting_id == '-1') {
					$reporting_id = '';
				} else {
					$reporting_id = $reporting_id;
				}
				 $sqls = "INSERT INTO tbl_student(entity_type_id,reporting_manager_id,std_PRN,std_complete_name,std_name,std_lastname,std_Father_name,std_complete_father_name, std_school_name,school_id ,std_branch,std_class,std_div,emp_designation, permanent_address,Temp_address, std_city, std_dob, std_gender, std_country, std_email,Email_Internal,std_phone, std_date,std_age,std_password,latitude,longitude,std_state,Specialization,Course_level,Academic_Year,Admission_year_id,std_dept,Permanent_village,Permanent_taluka,Permanent_district,Permanent_pincode,std_year,ExtBranchId,ExtDeptId,std_semester,ExtSemesterId,country_code) VALUES ('$entity_type_id','$reporting_id','$roll_no','$complete_name','$id_first_name','$id_last_name1','$father_name','$father_name', '$school_name','$school_id','$BranchName',$class,'$div','$emp_desig','$id_address','$t_address', '$city', '$dateformat', '$id_gender', '$id_country', '$id_email','$in_email','$id_phone', '$id_date','$age','$password','$lat','$long','$id_state','$Specialization','$CourseLevel','$Intruduce_YeqarID','$std_year','$DeptName','$PermanentVillage','$PermanentTaluka','$PermanentDistrict','$PermanentPincode','$Year','$Branchid','$Deptid','$SemesterName','$Semesterid','$calling_code')";



				$result_insert = mysql_query($sqls) or die(mysql_error());
				if ($result_insert >= 1) {

					$to = $id_email;
					$from = "smartcookiesprogramme@gmail.com";
					$subject = "Succesful Registration";
					$message = "Hello " . $id_first_name . " " . $id_last_name . "\r\n\r\n" .
						"Thanks for your registration with Smart Cookie as student\r\n" .
						"your Username is: "  . $id_email .  "\n\n" .
						"your Password is: " . $password . "\n\n" .
						"your School ID is: " . $school_id . "\n\n" .
						"Regards,\r\n" .
						"Smart Cookie Admin";

					echo  mail($to, $subject, $message);
					//window.location='studentlist.php' added by Pranali for bug SMC-3308
					echo "<script type='text/javascript'>alert('Successfully Registered');
		
			window.location.href='studentlist.php';
		</script>";
				}
			} else {
				echo '<script type="text/javascript">alert("Email ID is already present ")</script>';
			}
		}
		?>

		<!DOCTYPE html>
		<!-- Changes done by Pranali on 28-06-2018 for bug SMC-3201 -->

		<head>
			<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
			<script type="text/javascript">
				$(document).ready(function() {
					$('#btn').click(function() {
						$(".error1").hide();

					});
					$('#submit').click(function() {
						$(".error1").show();

					});
				});
			</script>
		</head>
		<!-- changes end-->
		<link href='css/datepicker.min.css' rel='stylesheet' type='text/css'>
		<script src='js/bootstrap-datepicker.min.js' type='text/javascript'></script>
		<script src='js/bootstrap-switch.min.js' type='text/javascript'></script>
		<script src='js/bootstrap-multiselect.js' type='text/javascript'></script>
		<script type="text/javascript">
			$(function() {

				$("#id_checkin").datepicker({
					changeMonth: true,
					changeYear: true
				});

			});
		</script>
		<style>
			body {
				background-color: #F8F8F8;
			}

			.indent-small {
				margin-left: 5px;
			}

			.form-group.internal {
				margin-bottom: 0;
			}

			.dialog-panel {
				margin: 10px;
			}


			.panel-body {



				font: 600 15px "Open Sans", Arial, sans-serif;
			}

			label.control-label {
				font-weight: 600;
				color: #777;
			}
		</style>
		<script src="js/city_state.js" type="text/javascript"></script>
		<script>
			function isNumberKey(evt) {
				var charCode = (evt.which) ? evt.which : event.keyCode
				if (charCode > 31 && (charCode < 48 || charCode > 57))
					return false;
				return true;
			}
		</script>

		<script type="text/javascript">
			/*$(document).ready(function() {  
  $('.multiselect').multiselect();
  $('.datepicker').datepicker();  


});*/
		</script>
		<script src='js/bootstrap-datepicker.min.js' type='text/javascript'></script>
		<link href='css/datepicker.min.css' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
		<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

		<script src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>
		<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
		<script>
			$(document).ready(function() {
				$("#id_email").on('change', function() {
					var dup_email = document.getElementById("id_email").value;

					$.ajax({
						type: "POST",
						data: {
							dup_email: dup_email
						},
						url: 'email_validation_student.php',
						success: function(data) {
							if (data == 0) {
								$(data).hide();
							} else {

								 alert("Email ID already present...Please try another one");
								$('#id_email').val("");
							}
							// $('#managerList').html(data);
						}


					});

				});

			});
		</script>
		<script>
			$(document).ready(function() {
				$("#country1").on('change', function() {
					var cid = document.getElementById("country1").value;
					//alert (cid);
					var c = cid.split(",");
					var c_id = c[0];
					$.ajax({
						type: "POST",
						data: {
							c_id: c_id
						},
						url: '../college_id/country_state_city_js.php',
						success: function(data) {

							$('#state').html(data);
						}


					});

				});

			});
		</script>
		<script>
			$(document).ready(function() {
				$("#state").on('change', function() {
					var cid = document.getElementById("country1").value;
					var s_id = document.getElementById("state").value;
					//alert(s_id);
					$.ajax({
						type: "POST",
						data: {
							s_id: s_id,
							cid: cid
						},
						url: '../college_id/country_state_city_js.php',
						success: function(data) {

							$('#city').html(data);
						}


					});

				});

			});
		</script>
		<script>
			function Relationfunction(value, fn) {

				if (value != '') {

					if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
						xmlhttp = new XMLHttpRequest();
					} else { // code for IE6, IE5
						xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
					}
					xmlhttp.onreadystatechange = function() {
						if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
							if (fn == 'fun_course') {
								document.getElementById("DeptName").innerHTML = xmlhttp.responseText;
							}
							if (fn == 'fun_dept') {
								document.getElementById("BranchName").innerHTML = xmlhttp.responseText;
							}
							if (fn == 'fun_branch') {
								document.getElementById("SemesterName").innerHTML = xmlhttp.responseText;
							}


						}
					}
					xmlhttp.open("GET", "get_student_detail.php?fn=" + fn + "&value=" + value, true);
					xmlhttp.send();
				}




			}

			function valid() {
				//Changes done by Pranali on 28-06-2018 for bug SMC-3200
				var roll_no = document.getElementById("roll_no").value;


				var first_name = document.getElementById("id_first_name").value;




				var last_name1 = document.getElementById("id_last_name_f").value;


				var email = document.getElementById("id_email").value;
				var inemail = document.getElementById("in_email").value;

				var address = document.getElementById("id_address").value;

				var country = document.getElementById("country1").value;


				var phone_no = document.getElementById("id_phone").value;
				var state = document.getElementById("state").value;
				var city = document.getElementById("city").value;

				//Below pattern and conditions for roll_no added by Rutuja for SMC-5210 on 23-03-2021
				var pattern = /^[A-z0-9-_]+$/;
				if (roll_no.trim() == "" || roll_no.trim() == null) {
					alert("Please enter <?php echo $dynamic_emp; ?>");
					return false;
				} else if (!pattern.test(roll_no)) {
					alert("It is not valid <?php echo $dynamic_emp; ?>!");
					return false;
				} else {

				}
				/* if(roll_no==null||roll_no=="")
				{
					
					alert('Please enter <?php echo $dynamic_emp; ?>');
					return false;
				}
				else
				{
				document.getElementById('errorrollno').innerHTML='';
				}*/
				//Validations added by Rutuja Jori on 04/11/2019
				if (first_name.trim() == null || first_name.trim() == "") {

					alert('Please enter first name');

					return false;
				}

				regx1 = /^[A-Za-z\s]+$/;

				if (!regx1.test(first_name)) {
					alert('Please Enter valid Name');
					return false;
				} else {
					document.getElementById('errorname').innerHTML = '';

				}

				var phone = document.getElementById("id_phone").value;
				var pattern = /^[6789]\d{9}$/;

				if (!pattern.test(phone)) {
					alert("Please enter 10 digits number!");
					return false;
				}

				var std_cource = document.getElementById("CourseLevel").value;
				if (std_cource == '' || std_cource == 'Select <?php echo $dynamic_level; ?>') {
					alert('Please select <?php echo $dynamic_level; ?>');
					return false;
				} else {
					document.getElementById('errorcource').innerHTML = '';
				}


				var std_dept = document.getElementById("DeptName").value;
				if (std_dept == '' || std_dept == 'Select Department' || std_dept == 'select') {
					alert('Please select Department');
					return false;
				} else {
					document.getElementById('errordept').innerHTML = '';
				}

				var year_id = document.getElementById("Intruduce_YeqarID").value;
				if (year_id == '' || year_id == 'Select <?php echo $dynamic_year; ?>' || year_id == 'select') {
					alert('Please select <?php echo $dynamic_year; ?>');
					return false;
				} else {
					document.getElementById('errordept').innerHTML = '';
				}

				var id_email = document.getElementById("id_email").value;
				var pattern = /^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,4})$/;

				if (id_email == "") {
					alert("Please enter Email ID");
					return false;
				}

				if (!pattern.test(id_email)) {
					alert("It is not valid Email id!");
					return false;
				}

				var gender1 = document.getElementById("gender1").checked;

				var gender2 = document.getElementById("gender2").checked;

				if (gender1 == false && gender2 == false) {
					alert("Please select gender");
					return false;
				} else {

				}



				var id_country = document.getElementById("country1").value;

				if (id_country == '0') {
					alert('Please select country');
					return false;
				}

				var state = document.getElementById("state").value;

				if (state == '' || state == '0') {
					alert('Please select state');
					return false;
				}
				var city = document.getElementById("city").value;

				if (city == '' || city == '0') {
					alert('Please select city');
					return false;
				}

				/*var city=document.getElementById("id_accomodation").value;
					regx2=/^[A-z]+$/;
						if(city.trim()==null||city.trim()=="")
					{
			    
						alert('Please enter city');
						return false;
					}
					else if(!regx2.test(city))
				{
				alert('Please enter valid city');
				return false;
				
				}*/

				if (first_name1.trim() == null || first_name1.trim() == "") {

					document.getElementById('errorfatname').innerHTML = 'Please enter <?php echo $dynamic_student; ?> middle name';

					return false;
				}


				if (!regx1.test(first_name1)) {
					document.getElementById('errorfatname').innerHTML = 'Please Enter valid <?php echo $dynamic_student; ?> middle name';
					return false;
				} else {
					document.getElementById('errorfatname').innerHTML = '';

				}


				if (last_name1.trim() == null || last_name1.trim() == "") {
					document.getElementById('errorlastname').innerHTML = 'Please enter <?php echo $dynamic_student; ?> last name';

					return false;
				} else {
					document.getElementById('errorlastname').innerHTML = '';

				}


				if (!regx1.test(first_name1) || !regx1.test(last_name1)) {
					document.getElementById('errorlastname').innerHTML = 'Please Enter valid <?php echo $dynamic_student; ?> last name';
					return false;
				} else {
					document.getElementById('errorlastname').innerHTML = '';

				}

				<?php if ($_SESSION['usertype'] == 'School Admin') { ?>
					var id_class = document.getElementById("id_class1").value;
					regx = /^[a-zA-Z0-9&_\.-]+$/;
					if (id_class.trim() == "" || id_class.trim() == null) {
						document.getElementById('errorclass').innerHTML = 'Please enter class';
						return false;
					} else if (!regx1.test(id_class)) {
						document.getElementById('errorclass').innerHTML = 'Please Enter valid  class name';
						return false;
					} else {
						document.getElementById('errorclass').innerHTML = '';
					}




				<?php } ?>



				var std_branch = document.getElementById("BranchName").value;
				if (std_branch == '') {
					document.getElementById('errorbranch').innerHTML = 'Please select <?php echo $dynamic_branch; ?>';
					return false;
				} else {
					document.getElementById('errorbranch').innerHTML = '';
				}


				var id_div = document.getElementById("id_div").value;
				if (id_div == '') {
					document.getElementById('errordiv').innerHTML = 'Please select <?php echo $designation; ?>';
					return false;
				} else {
					document.getElementById('errordiv').innerHTML = '';
				}

				var id_checkin = document.getElementById("id_checkin").value;
				var myDate = new Date(id_checkin);



				var today = new Date();
				if (id_checkin == "") {


					document.getElementById('errordob').innerHTML = 'Please Enter Date of Birth';

					return false;
				} else if (myDate.getFullYear() >= today.getFullYear()) {

					if (myDate.getFullYear() == today.getFullYear()) {

						if (myDate.getMonth() == today.getMonth()) {
							if (myDate.getDate() >= today.getDate()) {

								document.getElementById("errordob").innerHTML = "please enter valid birth date";
								return false;
							} else {
								document.getElementById("errordob").innerHTML = "";
							}


						} else if (myDate.getMonth() > today.getMonth()) {
							document.getElementById("errordob").innerHTML = "please enter valid birth date";
							return false;

						} else {
							document.getElementById("errordob").innerHTML = "";
						}
					} else {
						document.getElementById("errordob").innerHTML = "please enter valid birth date";
						return false;

					}


				} else {
					document.getElementById("errordob").innerHTML = "";

				}

				var id_address = document.getElementById("id_address").value;
				var addrpat = /^[a-zA-Z0-9\s,'-]*$/;
				if (id_address.trim() == '' || id_address.trim() == null) {
					document.getElementById('erroraddress').innerHTML = 'Please enter address ';
					return false;
				} else if (!addrpat.test(id_address)) {
					document.getElementById('erroraddress').innerHTML = 'Please enter valid address ';
					return false;
				} else {
					document.getElementById('erroraddress').innerHTML = '';
				}


				var id_vill = document.getElementById("PermanentVillage").value;
				if (id_vill == '') {
					document.getElementById('errorvillage').innerHTML = 'Please Enter Permanent Village';
					return false;
				} else {
					document.getElementById('errorvillage').innerHTML = '';
				}

				var id_taluka = document.getElementById("PermanentTaluka").value;
				if (id_taluka == '') {
					document.getElementById('errortaluka').innerHTML = 'Please Enter Permanent Taluka';
					return false;
				} else {
					document.getElementById('errortaluka').innerHTML = '';
				}

				var id_distric = document.getElementById("PermanentDistrict").value;
				if (id_distric == '') {
					document.getElementById('errorDIST').innerHTML = 'Please Enter Permanent District';
					return false;
				} else {
					document.getElementById('errorDIST').innerHTML = '';
				}

				var id_pincode = document.getElementById("PermanentPincode").value;
				if (id_pincode == '') {
					document.getElementById('errorpincode').innerHTML = 'Please Enter Pincode';
					return false;
				} else {
					document.getElementById('errorpincode').innerHTML = '';
				}

				var id_academic = document.getElementById("Intruduce_YeqarID").value;
				if (id_academic == '') {
					document.getElementById('errorAY').innerHTML = 'Please select Academic Year';
					return false;
				} else {
					document.getElementById('errorAY').innerHTML = '';
				}

				var id_Year = document.getElementById("Year").value;
				if (id_Year == '') {
					document.getElementById('errorYI').innerHTML = 'Please select Year';
					return false;
				} else {
					document.getElementById('errorYI').innerHTML = '';
				}
				//changes end
			}
		</script>
		<style>
			.error {
				color: #FF0000;
			}
		</style>
		</head>
		<body>
			<div class='panel panel-primary dialog-panel'>
				<div style="font-size:15px;font-weight:bold;margin-top:5px;" class="col-md-offset-6">
					<div style="color:#F00"><?php if (isset($_GET['errorreport'])) {
												echo $_GET['errorreport'];
											};
											echo $errorreport; ?></div>
					<div style="color:#090"><?php if (isset($_GET['successreport'])) {
												echo $_GET['successreport'];
											};
											echo $successreport; ?></div>
				</div>
				<div class='panel-heading'>
					<a href="studentlist.php?name=s"><input type="submit" class="btn btn-warning" name="submit" value="Back" style="width:150;font-weight:bold;font-size:14px;" /></a>
					<h3 align="center"><?php echo $dynamic_student; ?> Registrations</h3>

					
					
					<?php if (isset($_GET['name'])) { ?>

						<!--Removed Add excel sheet option for SMC-4443 by Sayali Balkawade on 18/01/2020 -->
						<!--<h5 align="center"><a href="Add_studentSheet_updated_20160101PT.php?id=s" >Add Excel Sheet</a></h5>-->
						<h5 align="center"><b style="color:red;">Asterisk Fields Are Mandatory</b></h5>
					<?php } else { ?>
						<!--Removed Add excel sheet option for SMC-4443 by Sayali Balkawade on 18/01/2020 -->
						<!--<h5 align="center"><a href="Add_studentSheet_updated_20160101PT.php" >Add Excel Sheet</a></h5>-->
						<h5 align="center"><b style="color:red;">Asterisk Fields Are Mandatory</b></h5>
					<?php } ?>
				</div>
				<div class='panel-body'>
					<form class='form-horizontal' role='form' method="post" action="" id="form" onSubmit="return valid()">

						<div class='form-group'>
							<label class='control-label col-md-2 col-md-offset-2' style="text-align:left;"><?php echo $dynamic_emp; ?> <span class="error"><b> *</b></span></label>

							<div class='col-md-3' style="text-align:left;">
								<input class='form-control' id='roll_no' name="roll_no" placeholder='Enter <?php echo $dynamic_emp; ?>' type='text'>
							</div>

							<!-- 	Changes done (added error1 in class) by Pranali on 30-06-2018 for bug SMC-3201 -->
							<div class='col-md-3 error1' id="errorrollno" style="color:#FF0000"></div>

						</div>



						<div class="row">
							<label class='control-label col-md-2 col-md-offset-2' style="text-align:left;"><?php echo $dynamic_student; ?> Name <span class="error">*</span></label>
							<div class='col-md-3' style="text-align:left;">

								<input class='form-control' id='id_first_name' name="id_first_name" placeholder='First Name' type='text'>

							</div>

							<div class='col-md-2 error1' id="errorname" style="color:#FF0000"></div>
						</div>

						<div class='form-group'>
						</div>

						<div class='form-group'>
							<label class='control-label col-md-2 col-md-offset-2' style="text-align:left;">Middle Name <span class="error"></span></label>
							<div class='col-md-3 ' style="text-align:left;">

								<input class='form-control' id='id_first_name_f' name="id_first_name1" placeholder='Middle Name' type='text'>
							</div>

						</div>
						<div class='form-group'>
							<label class='control-label col-md-2 col-md-offset-2' style="text-align:left;">Last Name<span class="error"></span></label>
							<div class='col-md-3 '>
								<input class='form-control' id='id_last_name_f' name="id_last_name1" placeholder='Last Name' type='text'>
							</div>
							<div class='col-md-2 error1' id="errorlastname" style="color:#FF0000"></div>
						</div>

						<div class='form-group'>
							<label class='control-label col-md-2 col-md-offset-2' style="text-align:left;">Mobile Number<span class="error"><b> *</b></span></label>
							<div class='col-md-3'>
								<input class='form-control' id='id_phone' name="id_phone" placeholder='Mobile No' type='text' onChange="PhoneValidation(this);">
							</div>
							<div class='col-md-2 error1' id="errorphone" style="color:#FF0000"></div>
						</div>

						<div class='form-group'>
							<label class='control-label col-md-2 col-md-offset-2' for='id_department' style="text-align:left;"><?php echo $dynamic_class; ?></label>
							<div class='col-md-3'>
								<select name='class' id='class' class='form-control'>
									<option value="">Select</option>
									<?php
									$arr = mysql_query("select distinct(class) from Class where school_id='$sc_id'");

									while ($row = mysql_fetch_array($arr)) { ?>
										<option><?php echo $row['class'] ?></option><?php } ?>
								</select>
							</div>
							<div class='col-md-3 indent-small' id="errordepartment" style="color:#FF0000"></div>
						</div>

						<?php if ($_SESSION['usertype'] == 'School Admin') { ?>
							<div class="form-group">
								<label class='control-label col-md-2 col-md-offset-2' style="text-align:left;">Specialization<span class="error"></span></label>
								<div class='col-md-2' style="text-align:left;">
									<input class='form-control' id="Specialization" name="Specialization" placeholder='Enter Specialization' type='text'>

								</div>

							</div>
						<?php } ?>
						<div class="form-group">
							<label class='control-label col-md-2 col-md-offset-2' style="text-align:left;"><?php echo $dynamic_level; ?>
								<span class="error"><b> *</b></span></label>
							<div class='col-md-3' style="text-align:left;">
								<select name="CourseLevel" class="form-control " id="CourseLevel">
									<!--onclick removed from Course level, chnaged queries for department and branch master by Pranali for SMC-5025-->
									<option value="">Select <?php echo $dynamic_level; ?></option>
									<?php
									$sql = "select DISTINCT CourseLevel  from tbl_CourseLevel where school_id='$sc_id' and ExtCourseLevelID !=''";
									$result = mysql_query($sql);
									while ($row = mysql_fetch_array($result)) {
										//$ExtCourseLevelID = $row['ExtCourseLevelID'];
										$CourseLevel = $row['CourseLevel'];
										echo "<option value='$CourseLevel'>$CourseLevel</option>";
									}
									?>
								</select>

							</div>
							<div class='col-md-2 error1' id="errorcource" style="color:#FF0000"></div>
						</div>



						<div class='form-group'>

							<label class='control-label col-md-2 col-md-offset-2' style="text-align:left;">Department<span class="error"><b> *</b></span></label>


							<div class='col-md-3' style="text-align:left;">
								<!--Modified below department query for displaying unique & not null records by Pranali for SMC-5025 -->
								<select name="DeptName" class="form-control " id="DeptName" onChange="Relationfunction(this.value,'fun_branch')">
									<option value="">Select Department</option>
									<?php
									$sql = "select ExtDeptId,trim(Dept_Name) as Dept_Name from tbl_department_master where School_ID='$sc_id' and Dept_Name!='' group by Dept_Name order by trim(Dept_Name)  asc";
									$result = mysql_query($sql);
									while ($row = mysql_fetch_array($result)) {
										$ExtDeptId = $row['ExtDeptId'];
										$Dept_Name = $row['Dept_Name'];
										echo "<option value='$ExtDeptId,$Dept_Name'>$Dept_Name</option>";
									}
									?>
								</select>
							</div>


							<div class='col-md-3 error1' id="errordept" style="color:#FF0000"></div>


						</div>


						<div class='form-group'>

							<label class='control-label col-md-2 col-md-offset-2' style="text-align:left;"><?php echo $dynamic_branch; ?> Name <span class="error"></span></label>


							<div class='col-md-3' style="text-align:left;">
								<select name="BranchName" class="form-control " id="BranchName" onChange="Relationfunction(this.value,'fun_branch')">
									<option value="">Select <?php echo $dynamic_branch; ?> Name</option>
									<?php
									$sql = "select ExtBranchId,trim(branch_Name) as branch_Name from tbl_branch_master where school_id='$sc_id' and branch_Name!='' group by branch_Name order by branch_Name asc";
									$result = mysql_query($sql);
									while ($row = mysql_fetch_array($result)) {
										$ExtBranchId = $row['ExtBranchId'];
										$branch_Name = $row['branch_Name'];
										echo "<option value='$ExtBranchId,$branch_Name'>$branch_Name</option>";
									}
									?>
								</select>
							</div>


							<div class='col-md-3 error1' id="errorbranch" style="color:#FF0000"></div>


						</div>

						<?php if ($_SESSION['usertype'] == 'School Admin') { ?>
							<div class='form-group'>

								<label class='control-label col-md-2 col-md-offset-2' style="text-align:left;">Semester Name <span class="error"></span></label>


								<div class='col-md-3' style="text-align:left;">
									<select name="SemesterName" class="form-control " id="SemesterName">
										<option value="">Select Semester Name</option>
										<?php
										$sql = "select * from tbl_semester_master where school_id='$sc_id'";
										$result = mysql_query($sql);
										while ($row = mysql_fetch_array($result)) {
											$ExtSemesterId = $row['ExtSemesterId'];
											$Semester_Name = $row['Semester_Name'];
											echo "<option value='$ExtSemesterId,$Semester_Name'>$Semester_Name</option>";
										}
										?>
									</select>
								</div>


								<div class='col-md-3 error1' id="errorsem" style="color:#FF0000"></div>


							</div>
						<?php } ?>


						<div class="form-group">

							<label class='control-label col-md-2 col-md-offset-2' style="text-align:left;"><?php echo $designation; ?><span class="error"></span></label>


							<div class='col-md-3' style="text-align:left;">
								<select class='form-control' id='id_div' name="div1" placeholder='Enter  <?php echo $designation; ?>'>
									<option value=""> Select <?php echo $designation; ?></option>
									<?php


									$sql = mysql_query("select * from Division where school_id='$sc_id' and DivisionName != ''");



									while ($arr = mysql_fetch_array($sql)) {
									?>
										<option value="<?php echo $arr['DivisionName']; ?>"><?php echo $arr['DivisionName']; ?></option>
									<?php
									}


									?>
								</select>
							</div>
							<div class='col-md-3 error1' id="errordiv" style="color:#FF0000"></div>
						</div>


						<?php if ($_SESSION['usertype'] == 'HR Admin') { ?>
							<div class="form-group">

								<label class='control-label col-md-2 col-md-offset-2' style="text-align:left;">Designation<span class="error"></span></label>


								<div class='col-md-3' style="text-align:left;">
									<select class='form-control' id="emp_designation" name="emp_designation" placeholder='Enter Designation'>
										<option value=""> Select Designation</option>
										<?php


										$sql = mysql_query("select * from tbl_teacher_designation where school_id='$sc_id'");



										while ($arr = mysql_fetch_array($sql)) {
										?>
											<option value="<?php echo $arr['designation']; ?>"><?php echo $arr['designation']; ?></option>
										<?php
										}


										?>
									</select>
								</div>
								<div class='col-md-3 error1' id="errordiv" style="color:#FF0000"></div>
							</div>


							<div class="form-group">

								<label class='control-label col-md-2 col-md-offset-2' style="text-align:left;">Reporting Manager<span class="error"></span></label>


								<div class='col-md-3' style="text-align:left;">
									<select class='form-control' id="reporting_id" name="reporting_id" placeholder='Enter Reporting Manager'>
										<option value="-1"> Select Reporting Manager</option>
										<?php

										$sql_teacher = mysql_query("select t_id,t_complete_name from tbl_teacher where school_id='$sc_id' and t_complete_name!='' order by t_complete_name");

										while ($result_teacher = mysql_fetch_array($sql_teacher)) { ?>

											<option value="<?php echo $result_teacher['t_id'] ?>"><?php echo ucwords(strtolower($result_teacher['t_complete_name'])) ?></option>

										<?php }

										?>
									</select>
								</div>
								<div class='col-md-3 error1' id="errordiv" style="color:#FF0000"></div>
							</div>




						<?php } ?>


						<div class="form-group">

							<label class='control-label col-md-2 col-md-offset-2' style="text-align:left;"><?php echo $dynamic_year; ?><span class="error"><b> *</b></span></label>


							<div class='col-md-3' style="text-align:left;">
								<select name="Intruduce_YeqarID" class="form-control " id="Intruduce_YeqarID">
									<option value="">Select <?php echo $dynamic_year; ?></option>
									<?php
									$sql = "select * from tbl_academic_Year where school_id='$sc_id' and Academic_Year != ''";
									$result = mysql_query($sql);
									while ($row = mysql_fetch_array($result)) {
										$ExtYearID = $row['ExtYearID'];
										$Year = $row['Year'];
										$Academic_Year = $row['Academic_Year'];
										echo "<option value='$ExtYearID,$Year,$Academic_Year'>$Academic_Year</option>";
									}
									?>
								</select>
							</div>
							<div class='col-md-3 error1' id="errorAY" style="color:#FF0000"></div>
						</div>



						<div class='form-group'>
							<label class='control-label col-md-2 col-md-offset-2' for='id_email' style="text-align:left;">E-Mail<span class="error"> *</span></label>
							<div class='col-md-3' style="text-align:left;">
								<input class='form-control' id='id_email' name="id_email" placeholder='E-mail' type='text'>
							</div>
							<div class='col-md-2 error1' id="erroremail" style="color:#FF0000"></div>
						</div>

						<div class='form-group'>
							<label class='control-label col-md-2 col-md-offset-2' for='in_email' style="text-align:left;">Internal E-Mail<span class="error"> </span></label>
							<div class='col-md-3' style="text-align:left;">
								<input class='form-control' id='in_email' name="in_email" placeholder='Internal E-mail' type='text'>
							</div>
							<div class='col-md-2 error1' id="errorinemail" style="color:#FF0000"></div>
						</div>




						<div class='form-group'>
							<label class='control-label col-md-2 col-md-offset-2' style="text-align:left;">Date Of Birth<span class="error"></span></label>
							<div class='col-md-3' style="text-align:left;">

								<!-- Changes done by Pranali on 28-06-2018 for bug SMC-3200 -->

								<input type="text" id='id_checkin' name="id_checkin" class="form-control" />

								<!-- Changes end-->

							</div>
							<div class='col-md-3 error1' id="errordob" style="color:#FF0000"></div>
						</div>

						<div class='form-group'>
							<label class='control-label col-md-2 col-md-offset-2' style="text-align:left;">Gender<span class="error"> *</span></label>
							<div class='col-md-2' style="font-weight: 600;color: #777;">
								<input type="radio" name="gender" id="gender1" value="Male"> Male
							</div>
							<div class='col-md-2' style="font-weight: 600; color: #777;">
								<input type="radio" name="gender" id="gender2" value="Female"> Female
							</div>
							<div class='col-md-3 error1' id="errorgender" style="color:#FF0000"></div>

						</div>
						<div class='form-group'>
							<label class='control-label col-md-2 col-md-offset-2' style="text-align:left;">Address<span class="error"></span></label>
							<div class='col-md-3' style="text-align:left;">
								<textarea class='form-control' id='id_address' name="id_address" placeholder='Address' rows='3' style="resize:none;"></textarea>
							</div>
							<div class='col-md-4 indent-small error1' id="erroraddress" style="color:#FF0000"></div>
						</div>

						<div class='form-group'>
							<label class='control-label col-md-2 col-md-offset-2' style="text-align:left;">Temporary Address<span class="error"><b> </b></span></label>
							<div class='col-md-3' style="text-align:left;">
								<textarea class='form-control' id='t_address' name="t_address" placeholder='Temporary Address' rows='3' style="resize:none;"></textarea>
							</div>
							<div class='col-md-4 indent-small error1' id="errortaddress" style="color:#FF0000"></div>
						</div>

						<div class="form-group">
							<label class='control-label col-md-2 col-md-offset-2' style="text-align:left;">Country<span class="error"> *</span></label>
							<div class='col-md-3' style="text-align:left;">
								<select id="country1" name="country1" class='form-control'>
									<option value='0'>Select Country</option>
									<?php foreach ($country_ar['posts'] as $res) { ?>
										<option value="<?= $res["country"]; ?>,<?= $res["calling_id"]; ?>"><?= $res["country"]; ?></option>
									<?php } ?>
								</select>
							</div>
							<div class='col-md-3 error1' id="errorstate" style="color:#FF0000"></div>
						</div>



						<div class="form-group">

							<label class='control-label col-md-2 col-md-offset-2 ' style="text-align:left;">State<span class="error"> *</span></label>
							<div class='col-md-3' style="text-align:left;">
								<select name='state' id='state' class='form-control'>
									<option value='0'>First select Country</option>
								</select>
								</select>
							</div>
							<div class='col-md-3 error1' id="errorst" style="color:#FF0000"></div>
						</div>

						<script language="javascript">
							//populateCountries("country", "state");
							//populateCountries("country2");
						</script>

						<div class='form-group'>
							<label class='control-label col-md-2 col-md-offset-2' style="text-align:left;">Permanent Village<span class="error"></span></label>
							<div class='col-md-3' style="text-align:left;">
								<input type="text" class='form-control' id='PermanentVillage' name='PermanentVillage' placeholder="Permanent Village">
							</div>
							<div class='col-md-4 indent-small error1' id="errorvillage" style="color:#FF0000"></div>
						</div>

						<div class='form-group'>
							<label class='control-label col-md-2 col-md-offset-2' style="text-align:left;">Permanent Taluka<span class="error"></span></label>
							<div class='col-md-3' style="text-align:left;">
								<input type="text" class='form-control' id='PermanentTaluka' name='PermanentTaluka' placeholder="Permanent Taluka">
							</div>
							<div class='col-md-4 indent-small error1' id="errortaluka" style="color:#FF0000"></div>
						</div>

						<div class='form-group'>
							<label class='control-label col-md-2 col-md-offset-2' style="text-align:left;">Permanent District<span class="error"></span></label>
							<div class='col-md-3' style="text-align:left;">
								<input type="text" class='form-control' id='PermanentDistrict' name='PermanentDistrict' placeholder="Permanent District">
							</div>
							<div class='col-md-4 indent-small error1' id="errorDIST" style="color:#FF0000"></div>
						</div>

						<div class='form-group'>
							<label class='control-label col-md-2 col-md-offset-2' style="text-align:left;">City<span class="error"> *</span></label>
							<div class='col-md-3' style="text-align:left;">
								<select name='city' id='city' class='form-control'>
									<option value='0'>First select State</option>
								</select>
								</select>
							</div>
							<div class='col-md-4 indent-small error1' id="errorcity" style="color:#FF0000"></div>
						</div>

						<div class='form-group'>
							<label class='control-label col-md-2 col-md-offset-2' style="text-align:left;">Permanent Pincode
								<span class="error"></span></label>
							<div class='col-md-3' style="text-align:left;">
								<input type="text" class='form-control' id='PermanentPincode' name='PermanentPincode' placeholder="Permanent Pincode">
							</div>
							<div class='col-md-4 indent-small error1' id="errorpincode" style="color:#FF0000"></div>
						</div>

						<div class='form-group'>
							<div class='col-md-3 col-md-offset-3'>
								<input class='btn-lg btn-primary' type='submit' value="Submit" id="submit" name="submit" onClick="return valid()" />
							</div>
							<div class='col-md-2'>
								<button class='btn-lg btn-danger' id="btn" type='reset'>Reset</button>

								<!-- changes end  -->
							</div>
						</div>
					</form>
				</div>
			</div>
		</body>

		</html>

	<?php
	}
} else {
	//edit student details

	/*error_reporting(0); */
	$report = "";
	include("scadmin_header.php");
	$sc_id = $_SESSION['school_id'];
	if ($_SESSION['usertype'] == 'HR Admin Staff' or $_SESSION['usertype'] == 'School Admin Staff') {
		$sc_id = $_SESSION['school_id'];
		$query2 = mysql_query("select id from tbl_school_admin where school_id ='$sc_id'");

		$value2 = mysql_fetch_array($query2);

		$id = $value2['id'];
	}

	/*$id=$_SESSION['id'];*/
	$fields = array("id" => $id);
	$table = "tbl_school_admin";
	$smartcookie = new smartcookie();
	$results = $smartcookie->retrive_individual($table, $fields);
	$arrs = mysql_fetch_array($results);
	//Removed school id from session by Pranali for SMC-5001 
	$school_id = $_SESSION['school_id'];
	$std_PRN = $_GET['std_prn'];
	$std_complete_name = "";
	if ($std_PRN != '') {
		if (isset($_POST['update'])) {
			if ($std_PRN != '') {
				$std_prn = $_POST['std_prn'];
				//$l_name=$_POST['id_last_name'];

				$fname = $_POST['id_first_name'];
				$mname = $_POST['id_first_name_f'];
				$lname = $_POST['id_last_name_f'];

				$full_name = $fname . " " . $mname . " " . $lname;
				$std_class = $_POST['class'];
				$std_div = $_POST['id_div'];
				$reporting_id = $_POST['reporting_id'];
				$std_gen = $_POST['gender'];
				$std_email_id = $_POST['id_email'];
				$std_internal_emailid = $_POST['in_email'];
				$std_mob = $_POST['id_phone'];
				$std_dob = $_POST['id_checkin'];
				$std_t_address = $_POST['t_address'];
				$std_p_address = $_POST['id_address'];
				//$std_country= $_POST['country'];
				$c = $_POST['country1'];
				$coun = explode(",", $c);
				$std_country = $coun[0];
				$calling_code = $coun[1];
				$std_state = $_POST['state'];
				$std_cty = $_POST['city'];
				$emp_desig = $_POST['emp_designation'];

				$Specialization = $_POST['Specialization'];
				$CourseLevel = $_POST['CourseLevel'];

				$BranchName1 = $_POST['BranchName'];
				$BranchName2 = explode(",", $BranchName1);
				$BranchName = $BranchName2[1];
				$Branchid = $BranchName2[0];


				$Intruduce_YeqarID1 = $_POST['Intruduce_YeqarID'];


				$PermanentVillage = $_POST['PermanentVillage'];
				$PermanentTaluka = $_POST['PermanentTaluka'];
				$PermanentDistrict = $_POST['PermanentDistrict'];
				$PermanentPincode = $_POST['PermanentPincode'];

				//Department name & Department ID inserted by Rutuja on 04/01/2019 for displaying Department name on edit page for SMC-4382
				$DeptName1 = $_POST['DeptName'];
				$DeptName2 = explode(",", $DeptName1);
				$DeptName = $DeptName2[1];
				$Deptid = $DeptName2[0];

				$SemesterName1 = $_POST['SemesterName'];
				$SemesterName2 = explode(",", $SemesterName1);
				$SemesterName = $SemesterName2[1];
				$Semesterid = $SemesterName2[0];

				list($month, $day, $year) = explode("/", $std_dob);


				$year_diff  = date("Y") - $year;
				$month_diff = date("m") - $month;
				$day_diff   = date("d") - $day;
				if ($day_diff < 0 || $month_diff < 0) $year_diff--;

				$age = $year_diff;

				$dateformat = $year . "-" . $month . "-" . $day;
				$row_email = mysql_query("select * from tbl_student where std_email = '" . $std_email_id . "' and school_id ='" . $school_id . "' and std_PRN!='$std_PRN'");

				$count_email = mysql_num_rows($row_email);
				if ($count_email == 0) {
					$sql_update11 = "UPDATE `tbl_student` SET reporting_manager_id='$reporting_id',std_PRN='$std_prn',std_name='$fname',std_Father_name='$mname',std_lastname='$lname',std_complete_name='$full_name',
		std_class='$std_class',std_div='$std_div',emp_designation='$emp_desig',std_gender='$std_gen',std_email='$std_email_id',Email_Internal='$std_internal_emailid',std_phone='$std_mob',std_dob='$dateformat',
		Temp_address='$std_t_address',permanent_address='$std_p_address',std_country='$std_country',std_state='$std_state',std_city='$std_cty',Specialization='$Specialization',Course_level='$CourseLevel',std_branch='$BranchName',Academic_Year='$Intruduce_YeqarID1',Permanent_village='$PermanentVillage',Permanent_taluka='$PermanentTaluka',Permanent_district='$PermanentDistrict',Permanent_pincode='$PermanentPincode',Admission_year_id='$std_year',std_dept='$DeptName',ExtDeptId='$Deptid',ExtBranchId='$Branchid',std_year='$Year',std_semester='$SemesterName',ExtSemesterId='$Semesterid',country_code='$calling_code'
		WHERE std_PRN='$std_PRN' AND school_id='$school_id'";



					$retval11 = mysql_query($sql_update11) or die('Could not update data: ' . mysql_error());
				} else {
					echo ("<script LANGUAGE='JavaScript'>alert('Email ID already present...Please try another one');
 			window.location.href='student_setup.php?std_prn='" . $std_PRN . "'';
                            </script>");
				}
			} else {

				//window.location='studentlist.php' added by Pranali for bug SMC-3308
				echo "<script type=text/javascript>alert('Sry... No PRN Number.Unable to update this record '); window.location='studentlist.php'</script>";
			}
			if ($retval11 > 0) {
				echo "<script type=text/javascript>alert('Record Updated Successfully '); window.location='studentlist.php'</script>";
			} else {
				echo "<script type=text/javascript>alert('Ooops..you didn't make any kind of change'); window.location='studentlist.php'</script>";
			}
			//changes end
		}


		$query = mysql_query("select * from tbl_student where std_PRN='$std_PRN' and school_id='$school_id'");
		if (mysql_num_rows($query) > 0) {
			while ($value1 = mysql_fetch_assoc($query)) {
				$std_complete_name = $value1['std_complete_name'];
				$fname1 = $value1['std_name'];
				$l2name1 = $value1['std_lastname'];
				$mname1 = $value1['std_Father_name'];
				if ($std_complete_name == '') {

					$std_complete_name = $fname . " " . $mname . " " . $lname;
				}

				$complete_std_name = $value1['std_complete_name'];

				$complete_name = explode(" ", $complete_std_name);
				$count = count($complete_name);

				if ($fname1 == '') {
					if ($count <= '5') {
						$fname1 = ucwords($complete_name['0']);
					}
				}

				if ($mname1 == '') {

					if ($count == '2') {
						$mname1 = "";
					}
					if ($count == '3' || $count == '4' || $count == '5') {
						$mname1 = ucwords($complete_name['1']);
					}
				}

				if ($l2name1 == '') {
					if ($count == '3') {
						$l2name1 = ucwords($complete_name['2']);
					}
					if ($count == '2') {
						$l2name1 = ucwords($complete_name['1']);
					}
					if ($count == '4') {
						$l2name1 = ucwords($complete_name['2']) . "" . ucwords($complete_name['3']);
					}
					if ($count == '5') {
						$l2name1 = ucwords($complete_name['2']) . "" . ucwords($complete_name['3']) . "" . ucwords($complete_name['4']);
					}
				}


				/* $std_cname=$value1['std_complete_name'];
            $c_name=explode(" ",$std_cname);
            $fname=$c_name[0];
            $mname=$c_name[1];
            $lname=$c_name[2];
            $l2name=$c_name[3];
            $std_complete_name=$fname." ".$mname." ".$lname." ".$l2name; */
				$std_father_name = $value1['std_complete_father_name'];
				$std_dob = $value1['std_dob'];
				$std_branch = $value1['std_branch'];
				$std_class = $value1['std_class'];
				$std_div = $value1['std_div'];
				$emp_designation = $value1['emp_designation'];
				$reporting_manager_id = $value1['reporting_manager_id'];
				$std_year = $value1['std_year'];
				$std_sem = $value1['std_semester'];
				$std_add = $value1['std_address'];
				$std_city = $value1['std_city'];
				$std_country = $value1['std_country'];
				$std_state = $value1['std_state'];
				$std_gender = $value1['std_gender'];
				$std_email = $value1['std_email'];
				$std_phone = $value1['std_phone'];
				$std_internal_email = $value1['Email_Internal'];
				$std_temp_address = $value1['Temp_address'];
				$std_permanant_add = $value1['permanent_address'];
				$std_permanant_village = $value1['Permanent_village'];
				$std_permanant_taluka = $value1['Permanent_taluka'];
				$std_permanant_district = $value1['Permanent_district'];
				$std_permanant_pincode = $value1['Permanent_pincode'];
				$Specialization = $value1['Specialization'];
				$Course_level = $value1['Course_level'];
				$Academic_Year = $value1['Academic_Year'];
				$Admission_year_id = $value1['Admission_year_id'];
				$std_dept = $value1['std_dept'];
				$std_semester = $value1['std_semester'];
				$ExtSemesterId = $value1['ExtSemesterId'];
				$year = $value1['std_year'];
				$ExtDeptId = $value1['ExtDeptId'];
				$ExtBranchId = $value1['ExtBranchId'];
			}
		}
	} else {
		echo "<script type=text/javascript>alert('Sry... No PRN Number.Unable to update this record '); window.location='studentlist.php'</script>";
	}


	$arr1 = mysql_query("select t_id,t_complete_name,t_emp_type_pid from tbl_teacher where school_id='$sc_id' and t_id='$reporting_manager_id'");
	while ($row1 = mysql_fetch_assoc($arr1)) {
		$reporting_manager_t_id = $row1['t_id'];
		$reporting_manager_t_name = $row1['t_complete_name'];
	}
	?>

	<!DOCTYPE html>
	<html>

	<head>

		<link href='css/datepicker.min.css' rel='stylesheet' type='text/css'>
		<script src='js/bootstrap-datepicker.min.js' type='text/javascript'></script>
		<script src='js/bootstrap-switch.min.js' type='text/javascript'></script>
		<script src='js/bootstrap-multiselect.js' type='text/javascript'></script>







		<script type="text/javascript">
			$(function() {

				$("#id_checkin").datepicker({
					changeYear: true,
					changeMonth: true
				});

			});
		</script>


		<script>
			function isNumberKey(evt) {
				var charCode = (evt.which) ? evt.which : event.keyCode
				if (charCode > 31 && (charCode < 48 || charCode > 57))
					return false;
				return true;
			}

			function goBack() {
				window.history.back();
			}
		</script>
		<script>
			function showOrhide() {

				if (document.getElementById("firstBtn")) {

					document.getElementById('text_country1').style.display = "block";
					document.getElementById('text_country').style.display = "none";
					document.getElementById('text_state1').style.display = "block";
					document.getElementById('text_state').style.display = "none";
					return false;
				}
			}
		</script>

		<style>
			body {
				background-color: #F8F8F8;
			}

			.indent-small {
				margin-left: 5px;
			}

			.form-group.internal {
				margin-bottom: 0;
			}

			.dialog-panel {
				margin: 10px;
			}

			.panel-body {
				font: 600 15px "Open Sans", Arial, sans-serif;
			}

			label.control-label {
				font-weight: 600;
				color: #777;
			}

			.internal_email {
				padding-left: 200px;
			}
		</style>
		<script src="js/city_state.js" type="text/javascript"></script>
		<script src='js/bootstrap-datepicker.min.js' type='text/javascript'></script>

		<link href='css/datepicker.min.css' rel='stylesheet' type='text/css'>
		<script src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>
		<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
		<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>

		<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
		<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">

		<!--Below script updated by Rutuja for SMC-5191 on 06-03-2021-->
		<script>
			$(document).ready(function() {
				$("#id_email").on('change', function() {
					var dup_email = document.getElementById("id_email").value;
					var std_prn = <?php echo $_GET['std_prn']; ?>;
					$.ajax({
						type: "POST",
						data: {
							dup_email: dup_email,
							std_prn: std_prn
						},
						url: 'email_validation_student.php',
						success: function(data) {
							if (data == 0) {
								$(data).hide();
							} else {

								alert("Email ID already present...Please try another one");
								$('#id_email').val("");
							}
							// $('#managerList').html(data);
						}


					});

				});

			});
		</script>
		<script>
			$(document).ready(function() {
				$("#country1").on('change', function() {
					var cid = document.getElementById("country1").value;
					//alert (cid);
					var c = cid.split(",");
					var c_id = c[0];
					$.ajax({
						type: "POST",
						data: {
							c_id: c_id
						},
						url: '../college_id/country_state_city_js.php',
						success: function(data) {

							$('#state').html(data);
						}


					});

				});

			});
		</script>
		<script>
			$(document).ready(function() {
				$("#state").on('change', function() {
					var s_id = document.getElementById("state").value;

					$.ajax({
						type: "POST",
						data: {
							s_id: s_id
						},
						url: '../college_id/country_state_city_js.php',
						success: function(data) {

							$('#city').html(data);
						}


					});

				});

			});
		</script>
		<script>
			$(document).ready(function() {
				$('.multiselect').multiselect();
				$('.datepicker').datepicker();

			});
			$(function() {
				$("#std_dob").datepicker({
					changeMonth: true,
					changeYear: true,
					dateFormat: 'yy-mm-dd',
				});
			});


			//		
		</script>
		<script>
			function Relationfunction(value, fn) {

				if (value != '') {

					if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
						xmlhttp = new XMLHttpRequest();
					} else { // code for IE6, IE5
						xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
					}
					xmlhttp.onreadystatechange = function() {
						if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
							if (fn == 'fun_course') {
								document.getElementById("DeptName").innerHTML = xmlhttp.responseText;
							}
							if (fn == 'fun_dept') {
								document.getElementById("BranchName").innerHTML = xmlhttp.responseText;
							}

							if (fn == 'fun_branch') {
								document.getElementById("SemesterName").innerHTML = xmlhttp.responseText;

							}

						}
					}
					xmlhttp.open("GET", "get_student_detail.php?fn=" + fn + "&value=" + value, true);
					xmlhttp.send();
				}




			}
		</script>
		<script>
			function valid() { //Validations added by Rutuja Jori on 04/11/2019
				var first_name = document.getElementById("id_first_name").value;

				if (first_name.trim() == null || first_name.trim() == "") {

					alert('Please enter first name');

					return false;
				}

				regx1 = /^[A-Za-z\s]+$/;

				if (!regx1.test(first_name)) {
					alert('Please Enter valid Name');
					return false;
				}




				var phone = document.getElementById("id_phone").value;
				var pattern = /^[6789]\d{9}$/;

				if (!pattern.test(phone)) {
					alert("Please enter 10 digits number!");
					return false;
				}


				var std_cource = document.getElementById("CourseLevel").value;
				if (std_cource == '' || std_cource == 'Select <?php echo $dynamic_level; ?>') {
					alert('Please select <?php echo $dynamic_level; ?>');
					return false;
				}



				var std_dept = document.getElementById("DeptName").value;
				if (std_dept == "" || std_dept == 'Select Department' || std_dept == 'select') {
					alert('Please select Department');
					return false;
				}





				var year_id = document.getElementById("Intruduce_YeqarID").value;
				if (year_id == '' || year_id == 'Select <?php echo $dynamic_year; ?>' || year_id == 'select') {
					alert('Please select <?php echo $dynamic_year; ?>');
					return false;
				}


				var id_email = document.getElementById("id_email").value;
				var pattern = /^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,4})$/;

				if (id_email == "") {
					alert("Please enter Email ID");
					return false;
				}

				if (!pattern.test(id_email)) {
					alert("It is not valid Email id!");
					return false;
				}

				var id_country = document.getElementById("country1").value;

				if (id_country == '0') {
					alert('Please select country');
					return false;
				}

				var state = document.getElementById("state").value;

				if (state == '' || state == '0') {
					alert('Please select state');
					return false;
				}
				var city = document.getElementById("city").value;

				if (city == '' || city == '0') {
					alert('Please select city');
					return false;
				}

				/*var city=document.getElementById("id_accomodation").value;
					regx2=/^[A-z]+$/;
						if(city.trim()==null||city.trim()=="")
					{
			    
						alert('Please enter city');
						return false;
					}
					else if(!regx2.test(city))
				{
				alert('Please enter valid city');
				return false;
				
				}*/






				var gender1 = document.getElementById("gender1").checked;

				var gender2 = document.getElementById("gender2").checked;

				if (gender1 == false && gender2 == false) {
					alert("Please select gender");
					return false;
				} else {

				}


				var id_checkin = document.getElementById("id_checkin").value;
				var myDate = new Date(id_checkin);



				var today = new Date();
				if (id_checkin == "") {



				} else if (myDate.getFullYear() >= today.getFullYear()) {

					if (myDate.getFullYear() == today.getFullYear()) {

						if (myDate.getMonth() == today.getMonth()) {
							if (myDate.getDate() >= today.getDate()) {

								document.getElementById("errordob").innerHTML = "please enter valid birth date";
								return false;
							} else {
								document.getElementById("errordob").innerHTML = "";
							}


						} else if (myDate.getMonth() > today.getMonth()) {
							document.getElementById("errordob").innerHTML = "please enter valid birth date";
							return false;

						} else {
							document.getElementById("errordob").innerHTML = "";
						}
					} else {
						document.getElementById("errordob").innerHTML = "please enter valid birth date";
						return false;

					}


				} else {
					document.getElementById("errordob").innerHTML = "";

				}



				//end
				var complete_name = document.getElementById("complete_name").value;
				regx1 = /^[A-z ]+$/;
				if (complete_name == "") {

					document.getElementById('errorname').innerHTML = 'Please enter full name';

					return false;
				} else if (!regx1.test(complete_name)) {
					document.getElementById('errorname').innerHTML = 'Please Enter valid Name';
					return false;
				} else {
					document.getElementById('errorname').innerHTML = '';

				}
				var c_father_name = document.getElementById("c_father_name").value;
				regx1 = /^[A-z ]+$/;
				if (c_father_name == "") {

					document.getElementById('errorfatname').innerHTML = 'Please enter full name';

					return false;
				} else if (!regx1.test(c_father_name)) {
					document.getElementById('errorfatname').innerHTML = 'Please Enter valid Name';
					return false;
				} else {
					document.getElementById('errorfatname').innerHTML = '';

				}



				var c_lastname = document.getElementById("c_lastname").value;
				regx1 = /^[A-z ]+$/;
				if (c_lastname == "") {

					document.getElementById('errorlastname').innerHTML = 'Please enter last name';

					return false;
				} else if (!regx1.test(c_lastname)) {
					document.getElementById('errorlastname').innerHTML = 'Please Enter valid Name';
					return false;
				} else {
					document.getElementById('errorlastname').innerHTML = '';

				}
				<?php if ($_SESSION['usertype'] == 'School Admin') { ?>
					var id_class = document.getElementById("id_class").value;
					regx = /^[a-zA-Z0-9&_\.-]+$/;
					if (id_class.trim() == "" || id_class.trim() == null) {
						document.getElementById('errorclass').innerHTML = 'Please enter class';
						return false;
					} else if (!regx1.test(id_class)) {
						document.getElementById('errorclass').innerHTML = 'Please Enter valid  class name';
						return false;
					} else {
						document.getElementById('errorclass').innerHTML = '';
					}

					var std_cource = document.getElementById("CourseLevel").value;
					if (std_cource == '') {
						document.getElementById('errorcource').innerHTML = 'Please select Course Level';
						return false;
					} else {
						document.getElementById('errorcource').innerHTML = '';
					}


				<?php } ?>
				var id_div = document.getElementById("id_div").value;
				if (id_div == '') {
					document.getElementById('errordiv').innerHTML = 'Please enter division';
					return false;
				} else {
					document.getElementById('errordiv').innerHTML = '';
				}

				regx1 = /^[6789]\d{9}$/;
				//validation for name


				/*	var gender1=document.getElementById("gender1").checked;
		
			var gender2=document.getElementById("gender2").checked;
			
		if(gender1==false && gender2==false)
			{
				document.getElementById('errorgender').innerHTML='Please Select gender';
				return false;
			}else{
				document.getElementById('errorgender').innerHTML='';
			}
			
			var permanant_address=document.getElementById("id_address").value;
		regx2=/^[A-z ]+$/;
		if(permanant_address=="")
			{
			   
				document.getElementById('erroraddress').innerHTML='Please enter address';
				
				return false;
			}
	
			else
				{
				 document.getElementById('erroraddress').innerHTML='';
				}
			*/



				//var city=document.getElementById("id_accomodation").value;
				/*var city=document.getElementById("city").value;
					regx2=/^[A-z ]+$/;
				if(city==null||city=="")
				{
				    
					document.getElementById('errorcity').innerHTML='Please enter city';
					return false;
				}
				else if(!regx2.test(city))
				{
					document.getElementById('errorcity').innerHTML='Please enter valid city';
					return false;
					
					}
				else
				{
					
					document.getElementById('errorcity').innerHTML='';
				}*/

				var std_dept = document.getElementById("DeptName").value;
				if (std_dept == '') {
					document.getElementById('errordept').innerHTML = 'Please select Department';
					return false;
				} else {
					document.getElementById('errordept').innerHTML = '';
				}

				var std_branch = document.getElementById("BranchName").value;
				if (std_branch == '') {
					document.getElementById('errorbranch').innerHTML = 'Please select <?php echo $dynamic_branch; ?>';
					return false;
				} else {
					document.getElementById('errorbranch').innerHTML = '';
				}
				var id_vill = document.getElementById("PermanentVillage").value;
				if (id_vill == '') {
					document.getElementById('errorvillage').innerHTML = 'Please Enter Permanent Village';
					return false;
				} else {
					document.getElementById('errorvillage').innerHTML = '';
				}

				var id_taluka = document.getElementById("PermanentTaluka").value;
				if (id_taluka == '') {
					document.getElementById('errortaluka').innerHTML = 'Please Enter Permanent Taluka';
					return false;
				} else {
					document.getElementById('errortaluka').innerHTML = '';
				}

				var id_distric = document.getElementById("PermanentDistrict").value;
				if (id_distric == '') {
					document.getElementById('errorDIST').innerHTML = 'Please Enter Permanent District';
					return false;
				} else {
					document.getElementById('errorDIST').innerHTML = '';
				}

				var id_pincode = document.getElementById("PermanentPincode").value;
				if (id_pincode == '') {
					document.getElementById('errorpincode').innerHTML = 'Please Enter Pincode';
					return false;
				} else {
					document.getElementById('errorpincode').innerHTML = '';
				}



				var id_Year = document.getElementById("Year").value;
				if (id_Year == '') {
					document.getElementById('errorYI').innerHTML = 'Please select Year';
					return false;
				} else {
					document.getElementById('errorYI').innerHTML = '';
				}

			}
		</script>

	</head>


	<body>

		<div class='panel panel-primary dialog-panel'>
			<div style="font-size:15px;font-weight:bold;margin-top:5px;" class="col-md-offset-6">
				<div style="color:#F00"><?php if (isset($_GET['errorreport'])) {
											echo $_GET['errorreport'];
										};
										echo $errorreport; ?></div>
				<div style="color:#090"><?php if (isset($_GET['successreport'])) {
											echo $_GET['successreport'];
										};
										echo $successreport; ?></div>
			</div>
			<div class='panel-heading'>
				<h3 align="center">Edit <?php echo $dynamic_student; ?> Information</h3>
				<!--Added below line by Panali for SMC-5001-->
				<h5 align="center"><b style="color:red;">Asterisk Fields Are Mandatory</b></h5>

			</div>

			<div class='panel-body'>
				<form class='form-horizontal' role='form' method="POST" action="">

					<div class='form-group'>
						<label class='control-label col-md-2 col-md-offset-2' style="text-align:left;"><?php echo $dynamic_emp; ?> <span class="error"><b style="color:red" ;> *</b></span></label>


						<div class='col-md-3' style="text-align:left;">
							<input class='form-control' id='std_prn' name="std_prn" type='text' value="<?php echo $std_PRN; ?>" readonly="readonly">
						</div>


						<!-- 	Changes done (added error1 in class) by Pranali on 30-06-2018 for bug SMC-3201 -->
						<div class='col-md-3 error1' id="errorrollno" style="color:#FF0000"></div>

					</div>


					<div class="row">
						<label class='control-label col-md-2 col-md-offset-2' style="text-align:left;"><?php echo $dynamic_student; ?> Name <span class="error"><b style="color:red" ;> *</b></span></label>
						<div class='col-md-3' style="text-align:left;">

							<input class='form-control' id='id_first_name' name="id_first_name" placeholder='First Name' type='text' value="<?php echo $fname1; ?>">

						</div>

						<div class='col-md-2 error1' id="errorname" style="color:#FF0000"></div>
					</div>

					<div class='form-group'>
					</div>

					<div class='form-group'>
						<label class='control-label col-md-2 col-md-offset-2' style="text-align:left;">Middle Name <span class="error"></span></label>
						<div class='col-md-3 ' style="text-align:left;">

							<input class='form-control' id="id_first_name_f" name="id_first_name_f" placeholder='Middle Name' type='text' value="<?php echo $mname1; ?>">
						</div>

					</div>
					<div class='form-group'>
						<label class='control-label col-md-2 col-md-offset-2' style="text-align:left;">Last Name<span class="error"></span></label>
						<div class='col-md-3 '>
							<input class='form-control' id="id_last_name_f" name="id_last_name_f" placeholder='Last Name' type='text' value="<?php echo $l2name1; ?>">
						</div>
						<div class='col-md-2 error1' id="errorlastname" style="color:#FF0000"></div>
					</div>

					<div class='form-group'>
						<label class='control-label col-md-2 col-md-offset-2' style="text-align:left;">Mobile Number<span class="error"><b style="color:red" ;> *</b></span></label>
						<div class='col-md-3'>
							<input class='form-control' id='id_phone' name="id_phone" placeholder='Mobile No' type='text' value="<?php echo $std_phone; ?>" onChange="PhoneValidation(this);">
						</div>
						<div class='col-md-2 error1' id="errorphone" style="color:#FF0000"></div>
					</div>

					<div class='form-group'>
						<label class='control-label col-md-2 col-md-offset-2' for='id_accomodation' style="text-align:left;"><?php echo $dynamic_class; ?></label>
						<div class='col-md-3'>
							<select name='class' id='class' class='form-control'>
								<?php
								echo $std_class;
								if ($std_class == '0') {
									$std_class = "";
								}
								if ($std_class != '') {
								?>
									<option value='<?php echo $std_class ?>' selected><?php echo $std_class; ?></option>
								<?php
								} else { ?>
									<option value=''>Select</option>
								<?php } ?>
								<?php $arr = mysql_query("select distinct(class) from Class where school_id='$sc_id'");
								while ($row = mysql_fetch_array($arr)) {
									$s_class = $row['class'];
								?>
									<?php if ($std_class != $s_class) { ?>
										<option value="<?php echo $s_class; ?>"><?php echo $s_class; ?></option>
								<?php }
								} ?>

							</select>
						</div>

					</div>

					<?php if ($_SESSION['usertype'] == 'School Admin') { ?>
						<div class="form-group">
							<label class='control-label col-md-2 col-md-offset-2' style="text-align:left;">Specialization<span class="error"></span></label>
							<div class='col-md-2' style="text-align:left;">
								<input class='form-control' id="Specialization" name="Specialization" placeholder='Enter Specialization' type='text' value="<?php echo $Specialization; ?>">

							</div>

						</div>
					<?php } ?>



					<div class='form-group'>
						<label class='control-label col-md-2 col-md-offset-2' for='id_accomodation' style="text-align:left;"><?php echo $dynamic_level; ?><b style="color:red" ;> *</b></label>
						<div class='col-md-3'>
							<select name='CourseLevel' id='CourseLevel' class='form-control' onChange="Relationfunction(this.value,'fun_course')">
								<option value="<?php echo $Course_level; ?>"><?php echo $Course_level; ?></option>
								<?php
								$sql = "select DISTINCT CourseLevel  from tbl_CourseLevel where school_id='$sc_id' and ExtCourseLevelID !=''";
								$result = mysql_query($sql);
								while ($row = mysql_fetch_array($result)) {
									//$ExtCourseLevelID = $row['ExtCourseLevelID'];
									$CourseLevel = $row['CourseLevel'];
									//Below condition added by Rutuja for SMC-4808 on 27-02-2021
									if ($Course_level != $CourseLevel) {
										echo "<option value='$CourseLevel'>$CourseLevel</option>";
									}
								}
								?>

							</select>
						</div>

					</div>




					<div class='form-group'>
						<label class='control-label col-md-2 col-md-offset-2' for='id_accomodation' style="text-align:left;">Department<b style="color:red" ;> *</b></label>
						<div class='col-md-3'>
							<select name='DeptName' id='DeptName' class='form-control' onChange="Relationfunction(this.value,'fun_dept')">
								<option value="<?php echo $std_dept; ?>"><?php echo $std_dept; ?></option>
								<?php
								$sql = "select * from tbl_department_master where School_ID='$sc_id'";
								$result = mysql_query($sql);
								while ($row = mysql_fetch_array($result)) {
									$ExtDeptId = $row['ExtDeptId'];
									$Dept_Name = $row['Dept_Name'];
									//Below option value changed by Rutuja for SMC-5212 on 24-03-2021
									echo "<option value='$ExtDeptId,$Dept_Name'>$Dept_Name</option>";
								}
								?>

							</select>
						</div>

					</div>



					<div class='form-group'>
						<label class='control-label col-md-2 col-md-offset-2' for='id_accomodation' style="text-align:left;"><?php echo $dynamic_branch; ?> Name </label>
						<div class='col-md-3'>
							<select name='BranchName' id='BranchName' class='form-control' onChange="Relationfunction(this.value,'fun_branch')">
								<option value="<?php echo $ExtBranchId . ',' . $std_branch; ?>"><?php echo $std_branch; ?></option>
								<?php
								$sql = "select * from tbl_branch_master where school_id='$sc_id'";
								$result = mysql_query($sql);
								while ($row = mysql_fetch_array($result)) {
									$ExtBranchId = $row['ExtBranchId'];
									$branch_Name = $row['branch_Name'];
									echo "<option value='$ExtBranchId,$branch_Name'>$branch_Name</option>";
								}
								?>

							</select>
						</div>

					</div>


					<?php if ($_SESSION['usertype'] == 'School Admin') { ?>
						<div class='form-group'>

							<label class='control-label col-md-2 col-md-offset-2' style="text-align:left;">Semester Name <span class="error"></span></label>


							<div class='col-md-3' style="text-align:left;">
								<select name='SemesterName' id='SemesterName' class='form-control'>
									<option value="<?php echo $ExtSemesterId . ',' . $std_semester; ?>"><?php echo $std_semester; ?></option>
									<?php
									$sql = "select * from tbl_semester_master where school_id='$sc_id'";
									$result = mysql_query($sql);
									while ($row = mysql_fetch_array($result)) {
										$ExtSemesterId = $row['ExtSemesterId'];
										$Semester_Name = $row['Semester_Name'];
										echo "<option value='$ExtSemesterId,$Semester_Name'>$Semester_Name</option>";
									}
									?>

								</select>

							</div>


							<div class='col-md-3 error1' id="errorsem" style="color:#FF0000"></div>


						</div>
					<?php } ?>






					<div class="form-group">

						<label class='control-label col-md-2 col-md-offset-2' style="text-align:left;"><?php echo $designation; ?><span class="error"></span></label>


						<div class='col-md-3' style="text-align:left;">
							<select name='id_div' id='id_div' class='form-control'>
								<?php
								echo $std_div;
								if ($std_div != '') {
								?>
									<option value='<?php echo $std_div ?>' selected><?php echo $std_div; ?></option>
								<?php
								} else { ?>
									<option value=''>Select <?php echo $designation; ?></option>
								<?php } ?>
								<?php $arr = mysql_query("select * from Division where school_id='$sc_id' and DivisionName != ''");
								while ($row = mysql_fetch_array($arr)) {
									$t_class = $row['DivisionName'];
								?>
									<?php if ($std_div != $t_class) { ?>
										<option value="<?php echo $t_class; ?>"><?php echo $t_class; ?></option>
								<?php }
								} ?>

							</select>
						</div>
						<div class='col-md-3 error1' id="errordiv" style="color:#FF0000"></div>
					</div>

					<?php if ($_SESSION['usertype'] == 'HR Admin') { ?>
						<div class="form-group">

							<label class='control-label col-md-2 col-md-offset-2' style="text-align:left;">Designation<span class="error"></span></label>


							<div class='col-md-3' style="text-align:left;">
								<select class='form-control' id='emp_designation' name="emp_designation" placeholder='Enter Designation'>

									<?php


									echo $emp_designation;
									if ($emp_designation != '') {
									?>
										<option value='<?php echo $emp_designation ?>' selected><?php echo $emp_designation; ?></option>
									<?php
									} else { ?>
										<option value=''>Select Designation</option>
									<?php } ?>
									<?php $arr = mysql_query("select * from tbl_teacher_designation where school_id='$sc_id'");
									while ($row = mysql_fetch_array($arr)) {
										$t_class = $row['designation'];
									?>
										<?php if ($emp_designation != $t_class) { ?>
											<option value="<?php echo $t_class; ?>"><?php echo $t_class; ?></option>
									<?php }
									} ?>

								</select>
							</div>
							<div class='col-md-3 error1' id="errordiv" style="color:#FF0000"></div>
						</div>


						<div class="form-group">

							<label class='control-label col-md-2 col-md-offset-2' style="text-align:left;">Reporting Manager<span class="error"></span></label>


							<div class='col-md-3' style="text-align:left;">
								<select class='form-control' id='reporting_id' name="reporting_id" placeholder='Enter Reporting Manager'>
									<option value="-1"> Select Reporting Manager</option>
									<?php


									echo $reporting_manager_id;
									if ($reporting_manager_id != '') {
									?>
										<option value='<?php echo $reporting_manager_id ?>' selected><?php echo $reporting_manager_t_name; ?></option>
									<?php
									} else { ?>
										<option value='-1'>Select Reporting Manager</option>
									<?php } ?>
									<?php $arr = mysql_query("select t_id,t_complete_name,t_emp_type_pid from tbl_teacher where school_id='$sc_id'  order by t_complete_name");
									while ($row = mysql_fetch_array($arr)) {
										$t_name = $row['t_complete_name'];
										$t_id = $row['t_id'];
									?>
										<?php if ($reporting_manager_id != $t_id) { ?>
											<option value="<?php echo $t_id; ?>"><?php echo $t_name; ?></option>
									<?php }
									} ?>

								</select>
							</div>
							<div class='col-md-3 error1' id="errordiv" style="color:#FF0000"></div>
						</div>

					<?php } ?>


					<div class="form-group">

						<label class='control-label col-md-2 col-md-offset-2' style="text-align:left;"><?php echo $dynamic_year; ?><span class="error"><b style="color:red" ;> *</b></span></label>


						<div class='col-md-3' style="text-align:left;">
							<select name='Intruduce_YeqarID' id='Intruduce_YeqarID' class='form-control'>
								<?php
								echo $Academic_Year;
								if ($Academic_Year != '') {
								?>
									<option value='<?php echo $Academic_Year ?>' selected><?php echo $Academic_Year; ?></option>
								<?php
								} else { ?>
									<option value=''>Select <?php echo $dynamic_year; ?></option>
								<?php } ?>
								<?php $arr = mysql_query("select * from tbl_academic_Year where school_id='$sc_id' and Academic_Year != ''");
								while ($row = mysql_fetch_array($arr)) {
									$ExtYearID = $row['ExtYearID'];
									$Year = $row['Year'];
									$AcademicYear = $row['Academic_Year'];
								?>
									<?php if ($Academic_Year != $AcademicYear) { ?>
										<option value='<?php echo $AcademicYear; ?>'><?php echo $AcademicYear; ?></option>
								<?php }
								} ?>

							</select>
						</div>
						<div class='col-md-3 error1' id="errorAY" style="color:#FF0000"></div>
					</div>



					<div class='form-group'>
						<label class='control-label col-md-2 col-md-offset-2' for='id_email' style="text-align:left;">E-Mail<span class="error"><b style="color:red" ;> *</b></span></label>
						<div class='col-md-3' style="text-align:left;">
							<input class='form-control' id='id_email' name="id_email" placeholder='E-mail' type='text' value="<?php echo $std_email; ?>">
						</div>
						<div class='col-md-2 error1' id="erroremail" style="color:#FF0000"></div>
					</div>

					<div class='form-group'>
						<label class='control-label col-md-2 col-md-offset-2' for='in_email' style="text-align:left;">Internal E-Mail<span class="error"> </span></label>
						<div class='col-md-3' style="text-align:left;">
							<input class='form-control' id='in_email' name="in_email" placeholder='Internal E-mail' type='text' value="<?php echo $std_internal_email; ?>">
						</div>
						<div class='col-md-2 error1' id="errorinemail" style="color:#FF0000"></div>
					</div>




					<div class='form-group'>
						<label class='control-label col-md-2 col-md-offset-2' style="text-align:left;">Date Of Birth<span class="error"></span></label>
						<div class='col-md-3' style="text-align:left;">

							<!-- Changes done by Pranali on 28-06-2018 for bug SMC-3200 -->

							<input type="text" id='id_checkin' name="id_checkin" value="<?php echo $std_dob; ?>" class="form-control" />

							<!-- Changes end-->

						</div>
						<div class='col-md-3 error1' id="errordob" style="color:#FF0000"></div>
					</div>

					<div class='form-group'>
						<label class='control-label col-md-2 col-md-offset-2' style="text-align:left;">Gender<span class="error"> <b style="color:red" ;> *</b></span></label>
						<div class='col-md-2' style="font-weight: 600;color: #777;">
							<input type="radio" name="gender" <?php if ($std_gender == "Male") {
																	echo "checked";
																} ?> id="gender1" value="Male"> Male
						</div>
						<div class='col-md-2' style="font-weight: 600; color: #777;">
							<input type="radio" name="gender" <?php if ($std_gender == "Female") {
																	echo "checked";
																} ?> id="gender2" value="Female"> Female
						</div>
						<div class='col-md-3 error1' id="errorgender" style="color:#FF0000"></div>

					</div>
					<div class='form-group'>
						<label class='control-label col-md-2 col-md-offset-2' style="text-align:left;">Address<span class="error"></span></label>
						<div class='col-md-3' style="text-align:left;">
							<textarea class='form-control' id='id_address' name="id_address" placeholder='Address' rows='3' style="resize:none;" value=""><?php echo $std_permanant_add; ?></textarea>
						</div>
						<div class='col-md-4 indent-small error1' id="erroraddress" style="color:#FF0000"></div>
					</div>

					<div class='form-group'>
						<label class='control-label col-md-2 col-md-offset-2' style="text-align:left;">Temporary Address<span class="error"><b> </b></span></label>
						<div class='col-md-3' style="text-align:left;">
							<textarea class='form-control' id='t_address' name="t_address" placeholder='Temporary Address' rows='3' style="resize:none;" value=""><?php echo $std_temp_address; ?></textarea>
						</div>
						<div class='col-md-4 indent-small error1' id="errortaddress" style="color:#FF0000"></div>
					</div>

					<div class='form-group'>
						<label class='control-label col-md-2 col-md-offset-2' style="text-align:left;">Country<b style="color:red" ;> *</b></label>
						<div class='col-md-3'>
							<select id="country1" name="country1" class='form-control'>
								<option value="<?php echo $std_country; ?>"><?php echo $std_country; ?></option>
								<?php
								$query = mysql_query("SELECT c.country as country ,c.country_id as country_id,c.calling_code as calling_id 
                        FROM tbl_country c where c.is_enabled='1' and country!='$std_country' group by c.country ORDER BY c.country");
								while ($row = mysql_fetch_array($query)) { ?>
									<option value="<?php echo $row['country'] ?>,<?php echo $row['calling_id'] ?>"><?php echo $row['country'] ?></option><?php } ?>
							</select>
						</div>
						<div class='col-md-3 indent-small' id="errorcountry" style="color:#FF0000"></div>
					</div>



					<div class='form-group'>
						<label class='control-label col-md-2 col-md-offset-2' style="text-align:left;">State<b style="color:red" ;> *</b></label>
						<div class='col-md-3'>
							<select name="state" id="state" class='form-control'>
								<option value="<?php echo $std_state; ?>"><?php echo $std_state; ?></option>
								<?php
								$query = mysql_query("SELECT st.state as state_name, st.state_id as state_id
                            FROM tbl_state st left join tbl_country c on c.country_id=st.country_id where c.country ='$std_country' and st.state!='$std_state'
                            group by st.state ORDER BY st.state ");
								while ($row = mysql_fetch_array($query)) { ?>
									<option value="<?php echo $row['state_name'] ?>"><?php echo $row['state_name'] ?></option><?php } ?>
							</select>
						</div>
						<div class='col-md-3 indent-small' id="errorstate" style="color:#FF0000"></div>
					</div>

					<script language="javascript">
						//populateCountries("country", "state");
						// populateCountries("country2");
					</script>

					<div class='form-group'>
						<label class='control-label col-md-2 col-md-offset-2' style="text-align:left;">Permanent Village<span class="error"> </span></label>
						<div class='col-md-3' style="text-align:left;">
							<input type="text" class='form-control' id='PermanentVillage' name='PermanentVillage' value="<?php echo $std_permanant_village; ?>">
						</div>
						<div class='col-md-4 indent-small error1' id="errorvillage" style="color:#FF0000"></div>
					</div>

					<div class='form-group'>
						<label class='control-label col-md-2 col-md-offset-2' style="text-align:left;">Permanent Taluka<span class="error"> </span></label>
						<div class='col-md-3' style="text-align:left;">
							<input type="text" class='form-control' id='PermanentTaluka' name='PermanentTaluka' value="<?php echo $std_permanant_taluka; ?>">
						</div>
						<div class='col-md-4 indent-small error1' id="errortaluka" style="color:#FF0000"></div>
					</div>

					<div class='form-group'>
						<label class='control-label col-md-2 col-md-offset-2' style="text-align:left;">Permanent District<span class="error"> </span></label>
						<div class='col-md-3' style="text-align:left;">
							<input type="text" class='form-control' id='PermanentDistrict' name='PermanentDistrict' value="<?php echo $std_permanant_district; ?>">
						</div>
						<div class='col-md-4 indent-small error1' id="errorDIST" style="color:#FF0000"></div>
					</div>

					<div class='form-group'>
						<label class='control-label col-md-2 col-md-offset-2' style="text-align:left;">City<span class="error"> <b style="color:red" ;> *</b></span></label>
						<div class='col-md-3' style="text-align:left;">
							<select name="city" id="city" class='form-control'>
								<option value="<?php echo $std_city; ?>"><?php echo $std_city; ?></option>
								<?php
								$query = mysql_query("SELECT cc.state_id as city_state_id,cc.sub_district as city_sub_district FROM tbl_city cc left join tbl_state s on s.state_id=cc.state_id where s.state='$std_state' group by cc.sub_district ORDER BY cc.sub_district ");
								while ($row = mysql_fetch_array($query)) {
									if ($std_city != $row['city_sub_district']) {
								?>
										<option value="<?php echo $row['city_sub_district'] ?>"><?php echo $row['city_sub_district'] ?></option><?php }
																																		} ?>
							</select>
						</div>
						<div class='col-md-4 indent-small error1' id="errorcity" style="color:#FF0000"></div>
					</div>

					<div class='form-group'>
						<label class='control-label col-md-2 col-md-offset-2' style="text-align:left;">Permanent Pincode
							<span class="error"> </span></label>
						<div class='col-md-3' style="text-align:left;">
							<input type="text" class='form-control' id='PermanentPincode' name='PermanentPincode' value="<?php echo $std_permanant_pincode ?>">
						</div>
						<div class='col-md-4 indent-small error1' id="errorpincode" style="color:#FF0000"></div>
					</div>

					<div class='form-group'>
						<div class='col-md-3 col-md-offset-3'>
							<center><input class='btn-lg btn-primary' type='submit' value="Update" name="update" onClick="return valid()" />
								<!-- onClick="return valid()"/>-->
						</div>

						<div class='col-md-2'>
							<a href="studentlist.php"><input type="button" class='btn-lg btn-danger' value="Cancel" /> </a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</body>

	</html>
	<!--<script>
	$(document).ready(function () {
		  var country = "<?php echo $std_country ?>" ;
		  var  state = "<?php echo $std_state ?>" ;
		  $("#country").val(country).change();
		  $("#state").val(state).change();
	});
</script>  -->

<?php
}
?>