<?php
 include("cookieadminheader.php");
$server_name = $_SERVER['SERVER_NAME'];
			
// $inst_id = $_GET['inst_id'];
  //$_POST['country'];
 if(isset($_POST['submit']))
 {
	$c_name= $_POST['c_name'];
	$c_type= $_POST['c_type'];
	 $u_name=$_POST['u_name'];
	 $u_type=$_POST['u_type'];
	 $website=$_POST['website'];
	 $address=$_POST['address'];
	 $state=$_POST['state'];
	 $city=$_POST['city'];
	 $source=$_POST['source'];
	 $info=$_POST['info'];
	  $contact=$_POST['contact'];
	   $college_email=$_POST['college_email'];
	   $college_code=trim($_POST['college_code']);
	  $stream=trim($_POST['stream']);
	  $intake=trim($_POST['intake']);
	  $principal_name=trim($_POST['principal_name']);
	  $tpo_name=trim($_POST['tpo_name']);
	 $tpo_contact=trim($_POST['tpo_contact']);
	 $tpo_email=trim($_POST['tpo_email']);
	 $number_of_teachers=trim($_POST['number_of_teachers']);
	 $number_of_subjects=trim($_POST['number_of_subjects']);
	  $number_of_students=trim($_POST['number_of_students']);
	 $date_Updated=trim($_POST['date_Updated']);
	    //$source=$_POST['source'];
	 
  // $sql1="UPDATE `Institution_directory` SET college_name='".$_POST['c_name']."' , college_type='".$_POST['c_type']."', university_name='".$_POST['u_name']."', university_type='".$_POST['u_type']."' , website='".$_POST['website']."' ,address='".$_POST['address']."',state='".$_POST['state']."',district='".$_POST['city']."',source='".$_POST['source']."' WHERE inst_id ='$inst_id'" ;
//echo "insert into Institution_directory(management,college_name,college_type,university_name,university_type,website,address,state,district,source,contact,college_email,college_code,stream,intake,principal_name,tpo_name,tpo_contact,tpo_email,number_of_teachers,number_of_subjects,number_of_students,date_Updated)
  //value('$info','$c_name','$c_type',' $u_name',' $u_type',' $website','$address','$state','$city',' $source','$contact','$college_email','$college_code','$stream','$intake','$principal','$tpo_name','$tpo_contact','$tpo_email',' $number_of_teachers','$number_of_subjects','$number_of_students','$date_Updated')";
  
  $sql=mysql_query("insert into Institution_directory(management,college_name,college_type,university_name,university_type,website,address,state,district,source,contact,college_email,college_code,stream,intake,principal_name,tpo_name,tpo_contact,tpo_email,number_of_teachers,number_of_subjects,number_of_students,date_Updated)
  value('$info','$c_name','$c_type',' $u_name',' $u_type',' $website','$address','$state','$city',' $source','$contact','$college_email','$college_code','$stream','$intake','$principal_name','$tpo_name','$tpo_contact','$tpo_email',' $number_of_teachers','$number_of_subjects','$number_of_students','$date_Updated')");
  if($sql)
  {
	  
	  
	 // echo"<script>alert('record inserted')</script>";
	 // header('Location:colleges.php');
	 
	 echo "<script>
window.location.href='http://$server_name/core/colleges.php';
alert('record inserted');
</script>";
  }
 else
  { 
	  echo "<script>
window.location.href='http://$server_name/core/colleges.php';
alert('record  not inserted');
</script>";
  }

 }

/* $sql = "SELECT * FROM  `Institution_directory` WHERE inst_id = '$inst_id'";
 $res = mysql_query($sql);
 $val = mysql_fetch_array($res);
*/

?>


<html>
<head>
<script>
function goBack() {
    window.history.back();
}


 function EmailValidation()
 {
	var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;  
  var website= document.getElementById('website').value;
if(mailformat!==website)
 			{
			  
          alert('please insert proper format');
		return false; 
			}	
	
	
 }
 function sourcelValidation()
 {
	 var source1=/^[A-Za-z]+$/;  
	 var source= document.getElementById('source').value;
if(source1!=source)	
{
			  
          alert('please insert sring format');
		return false; 
			}	
 }
</script>
<meta charset="utf-8">
<title>Smart Cookies</title>
<link href='css/datepicker.min.css' rel='stylesheet' type='text/css'>


<!-- <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>-->
<script src="js/city_state.js" type="text/javascript"></script>

 <!--<script src='js/bootstrap-datepicker.min.js' type='text/javascript'></script>-->


          <!-- Load jQuery and bootstrap datepicker scripts -->
       <!-- <script src="js/jquery-1.11.1.min.js"></script>
        <script src="js/bootstrap-datepicker.min.js"></script>-->
        <script type="text/javascript">
            // When the document is ready
            $(document).ready(function () {

                $('#example1').datepicker({

                });

            });
        </script>
        <style>
		textarea {
   resize: none;
}
		</style>



</head>
<body>
<div id="head"></div>
<div id="login">

<form action="" method="post">
<div class='container' style="padding-top:20px;">

    <div class='panel panel-primary dialog-panel' style="background-color:radial-gradient(ellipse at center center , #E5E5E5 0%, #FFF 100%) repeat scroll 0% 0% transparent;">
   <div style="color:red;font-size:15px;font-weight:bold;margin-top:10px;background-color:radial-gradient(ellipse at center center , #E5E5E5 0%, #FFF 100%) repeat scroll 0% 0% transparent;" align="center"> <?php echo $report;?></div>
      <div class='panel-heading' style="background-color:radial-gradient(ellipse at center center , #E5E5E5 0%, #FFF 100%) repeat scroll 0% 0% transparent;">

            <h3 align="center">Add College</h3>
          <!--  <p align="center"><a href="Add_school_dataexcel.php">Add Excel sheet</a></p>    -->



          </div>
      <div class='panel-body' >
        <form class='form-horizontal' role='form' method="post">
       <div class="row form-group">

                <label class='control-label col-md-3 col-md-offset-1' >College Name</label>
                <div class='col-md-3'>
                        <div class='form-group internal '>
                              <input class='form-control' id='c_name' name="c_name" placeholder='College Name' type='text'value="" required>
                        </div>
               </div>
                <div class='col-md-3 indent-small' >
                            <div class='form-group internal '>
                               <input class='form-control' id='id_last_name' name="c_type" placeholder='College Type' type='text' value=""  required>
                            </div>
                  </div>
         </div>

         <div class="row form-group">
           <label class='control-label col-md-3 col-md-offset-1' >University Name</label>

           <div  id="catList"></div>


                      <div class='col-md-3' >
                        <div class='form-group internal '>
                 <input class='form-control' id='id_first_name' name="u_name" placeholder='University Name' type='text'value="" required>

                        </div>

                     </div>
                      <div class='col-md-3 indent-small' >
                            <div class='form-group internal '>
                               <input class='form-control' id='id_last_name' name="u_type" placeholder='University Type' type='text' value="" required>
                            </div>
                  </div>
                  <div class='col-md-3'></div>
                  <div class='col-md-3 ' id="errorname" style="color:#FF0000" align="center">

                  </div>



         </div>

         <!--<div class="row form-group" id="datediv">

            <label class='control-label col-md-3 col-md-offset-1' >Date Of Birth</label>

              <div class='col-md-3'>
                <div class='form-group internal'>

 <input  type="text" class='form-control' placeholder="Date of Birth" name="dob" id="example1" value="<?php if(isset($_POST['dob'])){echo $_POST['dob'];}?>">
                </div>

             </div>
         </div>

          <div class='row form-group' id='genderdiv'>
            <label class='control-label col-md-3 col-md-offset-1'>Gender</label>
             <?php if(isset($_POST['gender1'])){
           if($_POST['gender1']=="Male"){?>
           <div class='col-md-1'>

                     Male <input type="radio" name="gender1" id="gender1" value="Male" checked >
                     </div>
                     <div class='col-md-2'>
                     Female <input type="radio" name="gender1" id="gender2" value="Female">
                      </div>
              <?php }else{?>
           <div class='col-md-1'>

                     Male <input type="radio" name="gender1" id="gender1" value="Male"  >
                     </div>
                     <div class='col-md-2'>
                     Female <input type="radio" name="gender1" id="gender2" value="Female" checked>
                      </div>
              <?php
			  }
			  }
              else
              {
			?>
                  <div class='col-md-1'>

                  Male <input type="radio" name="gender1" id="gender1" value="Male" >
                     </div>
                     <div class='col-md-2'>
                     Female <input type="radio" name="gender1" id="gender2" value="Female">
                      </div>


           <?php   }?>
                <div class='col-md-2 indent-small' id="errorgender" style="color:#FF0000"> </div>
          </div>

           <div class='row form-group'>
            	<label class='control-label col-md-3 col-md-offset-1' >Email ID</label>

                <div class='col-md-3 form-group internal'>
                  <input class='form-control' id='id_email' name="id_email" placeholder='E-mail' type='text' onBlur="return validemail()">
                </div>

                <div class='col-md-3 indent-small' id="erroremail" style="color:#FF0000"></div>
           </div>-->


              <div class='row form-group'>
                      <label class='control-label col-md-3 col-md-offset-1' >Website</label>
                        <div class='col-md-3 form-group internal'>
                         <input class='form-control' id='website' name="website" placeholder='Website' type='text'value="" required>
                        </div>

                <div class='col-md-3 indent-small' id="errorweb" style="color:#FF0000"></div>
                <div class='col-md-3 indent-small' >
                            <div class='form-group internal '>
                               <input class='form-control' id='source' name="source" placeholder='source' type='text' value=""  required>
                            </div>
							 <div class='col-md-3 indent-small' id="source" style="color:#FF0000"></div>
                  </div>
          </div>
		  <div class="row form-group">
          	 <label class='control-label col-md-3 col-md-offset-1' >contact</label>
            <div class='col-md-3 '>
              <input type="text" class='form-control' id='contact' name="contact" placeholder='contact'  required> </textarea>
            </div>
            <div class='col-md-2 indent-small' id='contact' style="color:#FF0000"></div>
          </div>
		  <div class="row form-group">
          	 <label class='control-label col-md-3 col-md-offset-1' >college email</label>
            <div class='col-md-3 '>
              <input type="text" class='form-control' id='college_email' name="college_email" placeholder='college_email'  required> </textarea>
            </div>
            <div class='col-md-2 indent-small' id='college_email' style="color:#FF0000"></div>
          </div>
		  <div class="row form-group">
          	 <label class='control-label col-md-3 col-md-offset-1' >college_code</label>
            <div class='col-md-3 '>
              <input type="text" class='form-control' id='college_code' name="college_code" placeholder='college_code'  required> </textarea>
            </div>
            <div class='col-md-2 indent-small' id='college_code' style="color:#FF0000"></div>
          </div>
		  <div class="row form-group">
          	 <label class='control-label col-md-3 col-md-offset-1' >stream</label>
            <div class='col-md-3 '>
              <input type="text" class='form-control' id='stream' name="stream" placeholder='stream'  required> </textarea>
            </div>
            <div class='col-md-2 indent-small' id='stream' style="color:#FF0000"></div>
          </div>
		  <div class="row form-group">
          	 <label class='control-label col-md-3 col-md-offset-1' >intake</label>
            <div class='col-md-3 '>
              <input type="text" class='form-control' id='intake' name="intake" placeholder='intake'  required> </textarea>
            </div>
            <div class='col-md-2 indent-small' id='intake' style="color:#FF0000"></div>
          </div>
		  <div class="row form-group">
          	 <label class='control-label col-md-3 col-md-offset-1' >principal_name</label>
            <div class='col-md-3 '>
              <input type="text" class='form-control' id='principal_name' name="principal_name" placeholder='principal_name'  required> </textarea>
            </div>
            <div class='col-md-2 indent-small' id='principal_name' style="color:#FF0000"></div>
          </div>
		  <div class="row form-group">
          	 <label class='control-label col-md-3 col-md-offset-1' >tpo_name</label>
            <div class='col-md-3 '>
              <input type="text" class='form-control' id='tpo_name' name="tpo_name" placeholder='tpo_name'  required> </textarea>
            </div>
            <div class='col-md-2 indent-small' id='tpo_name' style="color:#FF0000"></div>
          </div>
		  <div class="row form-group">
          	 <label class='control-label col-md-3 col-md-offset-1' >tpo_contact</label>
            <div class='col-md-3 '>
              <input type="text" class='form-control' id='tpo_contact' name="tpo_contact" placeholder='tpo_contact'  required> </textarea>
            </div>
            <div class='col-md-2 indent-small' id='tpo_contact' style="color:#FF0000"></div>
          </div>
		  <div class="row form-group">
          	 <label class='control-label col-md-3 col-md-offset-1' >tpo_email</label>
            <div class='col-md-3 '>
              <input type="text" class='form-control' id='tpo_email' name="tpo_email" placeholder='tpo_email'  required> </textarea>
            </div>
            <div class='col-md-2 indent-small' id='tpo_email' style="color:#FF0000"></div>
          </div>
		  <div class="row form-group">
          	 <label class='control-label col-md-3 col-md-offset-1' >number_of_teachers</label>
            <div class='col-md-3 '>
              <input type="text" class='form-control' id='number_of_teachers' name="number_of_teachers" placeholder='number_of_teachers'  required> </textarea>
            </div>
            <div class='col-md-2 indent-small' id='number_of_teachers' style="color:#FF0000"></div>
          </div>
		  <div class="row form-group">
          	 <label class='control-label col-md-3 col-md-offset-1' >number_of_subjects</label>
            <div class='col-md-3 '>
              <input type="text" class='form-control' id='number_of_subjects' name="number_of_subjects" placeholder='number_of_subjects'  required> </textarea>
            </div>
            <div class='col-md-2 indent-small' id='number_of_subjects' style="color:#FF0000"></div>
          </div>
		  <div class="row form-group">
          	 <label class='control-label col-md-3 col-md-offset-1' >number_of_students</label>
            <div class='col-md-3 '>
              <input type="text" class='form-control' id='number_of_students' name="number_of_students" placeholder='number_of_students'  required> </textarea>
            </div>
            <div class='col-md-2 indent-small' id='number_of_students' style="color:#FF0000"></div>
          </div>
		  <div class="row form-group">
          	 <label class='control-label col-md-3 col-md-offset-1' >date_Updated</label>
            <div class='col-md-3 '>
              <input type="text" class='form-control' id='date_Updated' name="date_Updated" placeholder='date_Updated'  required> </textarea>
            </div>
            <div class='col-md-2 indent-small' id='college_email' style="color:#FF0000"></div>
          </div>
		  
          <div class="row form-group">
          	 <label class='control-label col-md-3 col-md-offset-1' >Address</label>
            <div class='col-md-3 '>
              <textarea class='form-control' id='id_address' name="address" placeholder='Address' rows='3' required> </textarea>
            </div>
            <div class='col-md-2 indent-small' id='erroraddress' style="color:#FF0000"></div>
          </div>
		  <div class="row form-group">
          	 <label class='control-label col-md-3 col-md-offset-1' >Other Info</label>
            <div class='col-md-3 '>
              <textarea class='form-control' id='info' name="info" placeholder='Other Info' rows='3' required > </textarea>
            </div>
            <div class='col-md-2 indent-small' id='info' style="color:#FF0000"></div>
          </div>


         <div class='row form-group'>
            <label class='control-label col-md-3 col-md-offset-1' >Country</label>

            <div class='col-md-3'>
                  <select id="country" name="country" class='form-control' style="width:100%;" value=" <?php if(isset($_POST['country'])){echo $_POST['country'];}else{ if(isset($val['country'])){echo $val['country'];} }?>" required></select>
                </div>

               <script language="javascript">
            populateCountries("country", "state");
            populateCountries("country2");
        </script>
            <div class='col-md-3 indent-small' id="errorcountry" style="color:#FF0000" ></div>
         </div>


        <div class='row form-group'>
            <label class='control-label col-md-3 col-md-offset-1'>State</label>
            <div class='col-md-3'>
                  <select name="state" id="state" class='form-control' style="width:100%;" value=" <?php if(isset($_POST['state'])){echo $_POST['state'];}else{ echo $val['state']; }?>" required></select>
            
<!--<input type="text" class='form-control'  id='state' name="state" value=" " required>-->

			</div>

              <div class='col-md-3 indent-small' id="errorstate" style="color:#FF0000"></div>
        </div>

        <div class='row form-group'>
            <label class='control-label col-md-3 col-md-offset-1' for='id_accomodation'>City</label>
            <div class='col-md-3'>
              <input type="text" class='form-control'  id='id_city' name="city" value="" required>
            </div>
             <div class='col-md-3 indent-small' id="errorcity" style="color:#FF0000"></div>
          </div>
          <?php /*?><div class='row form-group'>
                      <label class='control-label col-md-3 col-md-offset-1' >Password</label>
                        <div class='col-md-3 form-group internal'>
                          <input class='form-control' id='password' name='password' placeholder='Password' type='password'  v>
                        </div>
                        
                        



          </div>
           <div class='row form-group'>
                      <label class='control-label col-md-3 col-md-offset-1' >Confirm Password</label>
                        <div class='col-md-3 form-group internal'>
                          <input class='form-control' id='cnfpassword' name="cnfpassword" placeholder='Confirm Password' type='password'  >
                        </div>

              <div class='col-md-3 indent-small' id="errorpassword" style="color:#FF0000"></div>

          </div><?php */?>
          <div class='form-group row'>
           <div class='col-md-2 col-md-offset-3' >
                 <input class='btn-lg btn-primary' type='submit' value="Add" name="submit" onClick="return valid()" />
                </div>
                 <div class='col-md-1'>

                    <button type="button" class='btn-lg btn-danger' onclick="goBack()">Cancel</button>

					
					
                  </div>



          </div>

        </form>
      </div>



</body>
</html>