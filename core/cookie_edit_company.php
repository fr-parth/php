<?php
 include("corporate_cookieadminheader.php");


 $s_id = $_GET['s_id'];

 if(isset($_POST['submit']))
 {


$sql1= "UPDATE `tbl_school_admin` SET  school_id='".$_POST['id']."', school_name='".$_POST['s_name']."' ,name='".$_POST['s_head']."' ,email='".$_POST['email']."',mobile='".$_POST['phone']."',address='".$_POST['address']."'  WHERE id='".$s_id."'";

mysql_query($sql1);

if(mysql_affected_rows()>0)
{
   echo "<script>alert('Data Updated Successfully')</script>";
   header("Location: cookie_list_school.php");
}
else
{
    echo "<script>alert('Error While Updating Data')</script>";
}
 }

 $sql = "SELECT * FROM  `tbl_school_admin` WHERE id = '$s_id'";
 $res = mysql_query($sql);
 $val = mysql_fetch_array($res);


?>


<html>
<head>
<meta charset="utf-8">
<title>Smart Cookies</title>
<link href='css/datepicker.min.css' rel='stylesheet' type='text/css'>


<!-- <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>-->
<script src="js/city_state.js" type="text/javascript"></script>

 <script src='js/bootstrap-datepicker.min.js' type='text/javascript'></script>


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

            <h3 align="center">Edit Project Details</h3>
          <!--  <p align="center"><a href="Add_school_dataexcel.php">Add Excel sheet</a></p>    -->



          </div>
      <div class='panel-body' >
        <form class='form-horizontal' role='form' method="post">

        <div class="row form-group">

                <label class='control-label col-md-3 col-md-offset-1' >Project ID</label>
                <div class='col-md-3'>
                        <div class='form-group internal '>
                              <input class='form-control' id='c_name' name="id" placeholder='School ID' type='text'value="<?php echo $val['school_id'];?>" required>
                        </div>
               </div>

         </div>

       <div class="row form-group">

                <label class='control-label col-md-3 col-md-offset-1' >Project Name</label>
                <div class='col-md-3'>
                        <div class='form-group internal '>
                              <input class='form-control' id='c_name' name="s_name" placeholder='School Name' type='text'value="<?php echo $val['school_name'];?>" required>
                        </div>
               </div>

         </div>

         <div class="row form-group">
           <label class='control-label col-md-3 col-md-offset-1' >Project Head</label>

                      <div class='col-md-3' >
                        <div class='form-group internal '>
                 <input class='form-control' id='id_first_name' name="s_head" placeholder='School Head' type='text'value="<?php echo $val['name'];?>" required>

                        </div>

                     </div>


         </div>


              <div class='row form-group'>
                      <label class='control-label col-md-3 col-md-offset-1' >Email</label>
                        <div class='col-md-3 form-group internal'>
                         <input class='form-control' id='phone' name="email" placeholder='Email' type='text' onChange="PhoneValidation(this);" value="<?php echo $val['email'];?>" required>
                        </div>

                <div class='col-md-3 indent-small' id="errorphone" style="color:#FF0000"></div>

          </div>


            <div class="row form-group">
          	 <label class='control-label col-md-3 col-md-offset-1' >Phone No</label>
            <div class='col-md-3 '>
                <input class='form-control' id='phone' name="phone" placeholder='Phone' type='text' onChange="PhoneValidation(this);" value="<?php echo trim($val['mobile']);?>" required>

            </div>
            <div class='col-md-2 indent-small' id='erroraddress' style="color:#FF0000"></div>
          </div>

          <div class="row form-group">
          	 <label class='control-label col-md-3 col-md-offset-1' >Address</label>
            <div class='col-md-3 '>
              <textarea class='form-control' id='id_address' name="address" placeholder='Address' rows='3' required><?php echo trim($val['address']);?> </textarea>
            </div>
            <div class='col-md-2 indent-small' id='erroraddress' style="color:#FF0000"></div>
          </div>




        <!-- <div class='row form-group'>
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
             </div>

              <div class='col-md-3 indent-small' id="errorstate" style="color:#FF0000"></div>
        </div>

        <div class='row form-group'>
            <label class='control-label col-md-3 col-md-offset-1' for='id_accomodation'>City</label>
            <div class='col-md-3'>
              <input type="text" class='form-control'  id='id_city' name="city" value=" <?php echo $val['district']; ?>" required>
            </div>
             <div class='col-md-3 indent-small' id="errorcity" style="color:#FF0000"></div>
          </div>-->
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
                 <input class='btn-lg btn-primary' type='submit' value="Update" name="submit"  />
                </div>
                 <div class='col-md-1'>

                    <a href="cookie_list_school.php" ><input type="button" value="Cancel" class='btn-lg btn-danger'  ></input></a>

                  </div>



          </div>

        </form>
      </div>



</body>
</html>