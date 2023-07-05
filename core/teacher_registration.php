<?php
	include("admin_header.php");
	if(isset($_POST['submit']))
	{
	$id_title = $_POST['id_title'];
	$id_first_name = $_POST['id_first_name'];
	$id_last_name = $_POST['id_last_name'];
	$name = $id_title." ".$id_first_name." ".$id_last_name;
	$id_school_name = $_POST['id_school_name'];
	$id_email = $_POST['id_email'];
	$id_phone = $_POST['id_phone'];
	$id_password = $_POST['id_password'];
	$id_checkin = $_POST['id_checkin'];
	$id_gender = $_POST['id_gender'];
	$id_education = $_POST['id_education'];
	$id_address = $_POST['id_address'];
	$id_country = $_POST['id_country'];
	$id_state = $_POST['id_state'];
	$id_city = $_POST['id_city'];
	$id_date = date('m/d/Y');
	mysql_query("INSERT INTO `tbl_teacher`(`t_name`, `t_current_school_name`, `t_qualification`, `t_address`, `t_city`, `t_dob`, `t_gender`, `t_country`, `t_email`, `t_password`, `t_date`) VALUES ('$name', '$id_school_name', '$id_education', '$id_address', '$id_city', '$id_checkin', '$id_gender', '$id_country', '$id_email', '$id_password', '$id_date')");
	//echo "INSERT INTO `tbl_teacher`(`t_name`, `t_current_school_name`, `t_qualification`, `t_address`, `t_city`, `t_dob`, `t_gender`, `t_country`, `t_email`, `t_password`, `t_date`) VALUES ('$name', '$id_school_name', '$id_education', '$id_address', '$id_city', '$id_checkin', '$id_gender', '$id_country', '$id_email', '$id_password', '$id_date')";die;
	}
?>

<!DOCTYPE html>
<head>
  <link href='css/bootstrap.min.css' rel='stylesheet' type='text/css'>
  <link href='css/datepicker.min.css' rel='stylesheet' type='text/css'>
  <link href='css/bootstrap-switch.css' rel='stylesheet' type='text/css'>
  <link href='css/bootstrap-multiselect.css' rel='stylesheet' type='text/css'>
  <script src='js/jquery.min.js' type='text/javascript'></script>
  <script src='js/bootstrap.min.js' type='text/javascript'></script>
  <script src='js/bootstrap-datepicker.min.js' type='text/javascript'></script>
  <script src='js/bootstrap-switch.min.js' type='text/javascript'></script>
  <script src='js/bootstrap-multiselect.js' type='text/javascript'></script>
  <style>
  body {
   background-color:#E8F3FF;
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

.datepicker-dropdown {
  z-index: 200 !important;
}

.panel-body {  
  
  background: #e5e5e5; /* Old browsers */
  background: -moz-radial-gradient(center, ellipse cover,  #e5e5e5 0%, #ffffff 100%); /* FF3.6+ */
  background: -webkit-gradient(radial, center center, 0px, center center, 100%, color-stop(0%,#e5e5e5), color-stop(100%,#ffffff)); /* Chrome,Safari4+ */
  background: -webkit-radial-gradient(center, ellipse cover,  #e5e5e5 0%,#ffffff 100%); /* Chrome10+,Safari5.1+ */
  background: -o-radial-gradient(center, ellipse cover,  #e5e5e5 0%,#ffffff 100%); /* Opera 12+ */
  background: -ms-radial-gradient(center, ellipse cover,  #e5e5e5 0%,#ffffff 100%); /* IE10+ */
  background: radial-gradient(ellipse at center,  #e5e5e5 0%,#ffffff 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#e5e5e5', endColorstr='#ffffff',GradientType=1 ); /* IE6-9 fallback on horizontal gradient */

  font: 600 15px "Open Sans",Arial,sans-serif;
}

label.control-label {
  font-weight: 600;
  color: #777;  
}
</style>
<script src="js/city_state.js" type="text/javascript"></script>
<script>
$(document).ready(function() {  
  $('.multiselect').multiselect();
  $('.datepicker').datepicker();  
});

</script>
</head>
<body>
  <div class='container'>
    <div class='panel panel-primary dialog-panel'>
      <div class='panel-heading'>
        <h3>Teacher Registration</h3>
      </div>
      <div class='panel-body'>
        <form class='form-horizontal' role='form' method="post">
          <!--<div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='id_accomodation'>Accomodation</label>
            <div class='col-md-2'>
              <select class='form-control' id='id_accomodation'>
                <option>RV</option>
                <option>Tent</option>
                <option>Cabin/Lodging</option>
              </select>
            </div>
          </div>-->
          
          <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='id_title'>Name</label>
            <div class='col-md-8'>
              <div class='col-md-2'>
                <div class='form-group internal'>
                  <select class='form-control' id='id_title' name="id_title">
                    <option>Mr</option>
                    <option>Ms</option>
                    <option>Mrs</option>
                    <option>Miss</option>
                    <option>Dr</option>
                  </select>
                </div>
              </div>
              <div class='col-md-3 indent-small'>
                <div class='form-group internal'>
                  <input class='form-control' id='id_first_name' name="id_first_name" placeholder='First Name' type='text'>
                </div>
              </div>
              <div class='col-md-3 indent-small'>
                <div class='form-group internal'>
                  <input class='form-control' id='id_last_name' name="id_last_name" placeholder='Last Name' type='text'>
                </div>
              </div>
            </div>
          </div>
          <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='id_email'>School Name</label>
            <div class='col-md-6'>
              <div class='form-group'>
                <div class='col-md-11'>
                  <input class='form-control' id='id_school_name' name="id_school_name" placeholder='School Name' type='text'>
                </div>
              </div>
             
            </div>
          </div>
            
         <!-- <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='id_adults'>Guests</label>
            <div class='col-md-8'>
              <div class='col-md-2'>
                <div class='form-group internal'>
                  <input class='form-control col-md-8' id='id_adults' placeholder='18+ years' type='number'>
                </div>
              </div>
              <div class='col-md-3 indent-small'>
                <div class='form-group internal'>
                  <input class='form-control' id='id_children' placeholder='2-17 years' type='number'>
                </div>
              </div>
              <div class='col-md-3 indent-small'>
                <div class='form-group internal'>
                  <input class='form-control' id='id_children_free' placeholder='&lt; 2 years' type='number'>
                </div>
              </div>
            </div>
          </div>-->
          <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='id_email'>Contact</label>
            <div class='col-md-6'>
              <div class='form-group'>
                <div class='col-md-11'>
                  <input class='form-control' id='id_email' name="id_email" placeholder='E-mail' type='text'>
                </div>
              </div>
              <div class='form-group internal'>
                <div class='col-md-6'>
                  <input class='form-control' id='id_phone' name="id_phone" placeholder='Phone: (xxx) - xxx xxxx' type='text'>
                </div>
              </div>
            </div>
          </div>
          
           <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='id_email'>Password</label>
            <div class='col-md-6'>
              <div class='form-group'>
                <div class='col-md-6'>
                  <input class='form-control' id='id_password' name="id_password" placeholder='' type='password'>
                </div>
              </div>
             
            </div>
          </div>
          <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='id_checkin'>DOB</label>
            <div class='col-md-8'>
              <div class='col-md-3'>
                <div class='form-group internal input-group'>
                  <input class='form-control datepicker' id='id_checkin' name="id_checkin">
                  <span class='input-group-addon'>
                    <i class='glyphicon glyphicon-calendar'></i>
                  </span>
                </div>
              </div>
             <!-- <label class='control-label col-md-2' for='id_checkout'>Checkout</label>
              <div class='col-md-3'>
                <div class='form-group internal input-group'>
                  <input class='form-control datepicker' id='id_checkout'>
                  <span class='input-group-addon'>
                    <i class='glyphicon glyphicon-calendar'></i>
                  </span>
                </div>
              </div>-->
            </div>
          </div>
          
         
          <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='id_pets'>Gender</label>
            <div class='col-md-1'>
              <div class='make-switch' data-off-label='Male' data-on-label='Female' id='id_pets_switch'>
                <input id='id_pets' name="id_gender" type='checkbox' value='1'>
              </div>
            </div>
          </div>
           <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='id_service'>Education</label>
            <div class='col-md-1'>
              <select class='multiselect' id='id_service' name="id_education" multiple='multiple'>
                <option value='hydro'>BA</option>
                <option value='water'>BCom</option>
                <option value='sewer'>BSc</option>
                <option value='hydro'>MA</option>
                <option value='water'>MCom</option>
                <option value='sewer'>MSc</option>
                <option value='water'>B.ED</option>
                <option value='sewer'>D.ED</option>
              </select>
            </div>
          </div>
          <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='id_comments'>Address</label>
            <div class='col-md-6'>
              <textarea class='form-control' id='id_comments' name="id_address" placeholder='Address' rows='3'></textarea>
            </div>
          </div>
          <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='id_equipment'>Country</label>
            <div class='col-md-8'>
              <div class='col-md-3'>
                <div class='form-group internal'>
                  <select id="country" name="id_country" class='form-control'></select>
                </div>
              </div>
             
            </div>
          </div>
           <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='id_equipment'>State</label>
            <div class='col-md-8'>
              <div class='col-md-3'>
                <div class='form-group internal'>
                  <select name="id_state" id="state" class='form-control'></select>
                </div>
              </div>
              <!--<div class='col-md-9'>
                <div class='form-group internal'>
                  <label class='control-label col-md-3' for='id_slide'>Slide-outs</label>
                  <div class='make-switch' data-off-label='NO' data-on-label='YES' id='id_slide_switch'>
                    <input id='id_slide' type='checkbox' value='chk_hydro'>
                  </div>
                </div>
              </div>-->
            </div>
          </div>
          <script language="javascript">
            populateCountries("country", "state");
            populateCountries("country2");
        </script>
         <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='id_accomodation'>City</label>
            <div class='col-md-3'>
              <input type="text" class='form-control' id='id_accomodation' name="id_city">
            </div>
          </div>
          <div class='form-group'>
            <div class='col-md-offset-4 col-md-3'>
              <input class='btn-lg btn-primary' type='submit' value="Submit" name="submit" />
            </div>
            <div class='col-md-3'>
              <button class='btn-lg btn-danger' style='float:right' type='submit'>Cancel</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>