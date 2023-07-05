<?php
//Created by Rutuja for SMC-4487 on 13/02/2020
//Modified by Rutuja to add 'address' column instead of 'add' in table 'tbl_cookie_adminstaff' for SMC-4568 on 23/03/2020
$report="";

include("groupadminheader.php"); 
 $grouadmindata=$_SESSION['data'];
        $grouadmindata=$grouadmindata[0];
     
      $group_mnumonic_code=$grouadmindata['group_mnemonic_name'];
      $group_member_id   = $_SESSION['id'];

$sc_id= $_SESSION['school_id'];
 $staffid = $_GET['staff'];


if($staffid=="")
{


    if(isset($_POST['submit']))
    {

          $email = $_POST['id_email'];


        $row=mysql_query("select * from tbl_cookie_adminstaff where email='$email' and group_member_id='$group_member_id'");
        if(mysql_num_rows($row)<=0)
        {
        $id_first_name = $_POST['id_first_name'];
        $id_last_name = $_POST['id_last_name'];

        $name=$id_first_name." ".$id_last_name;
        $education =$_POST['id_education'];
        $experience=$_POST['experience'];
        $designation=$_POST['Designation'];
        $date = $_POST['dob'];

        //$gender = $_POST['id_gender'];
        //retrive school_id and name school_admin
        //$arrs=$smartcookie->retrive_scadmin_profile();
        //$fields=array("id"=>$id);
        //$table="tbl_school_adminstaff";
        //$smartcookie=new smartcookie();
        //$results=$smartcookie->retrive_individual($table,$fields);
        //$arrs=mysql_fetch_array($results);
        //$school_id=$arrs['school_id'];
        //$school_name=$arrs['school_name'];
        //$class = $_POST['class1'];
        //$subject = $_POST['subject'];

        $email = $_POST['id_email'];
        $phone = $_POST['id_phone'];
        $gender=$_POST['gender'];
      $address = $_POST['address'];
        $country = $_POST['country'];
        $state = $_POST['state'];
        $city = $_POST['city'];
        $dates = date('Y/m/d');

        $password = $id_first_name."123";
        $permision=implode(' ',$_POST['permission']);

         list($month,$day,$year) = explode("-",$date);
        $year_diff  = date("Y") - $year;
        $month_diff = date("m") - $month;
        $day_diff   = date("d") - $day;
        if ($day_diff < 0 || $month_diff < 0) 
      $year_diff--;

        $age= $year_diff;

//date format changes by sachin 03-10-2018
  //  $currentdate = date('Y-m-d H:i:s');
    $currentdate = CURRENT_TIMESTAMP;
//date format changes by sachin 03-10-2018

        $sqls="INSERT INTO `tbl_cookie_adminstaff` (`id`, `stf_name`, `exprience`, `designation`, `address`, `country`, `city`, `statue`, `dob`, `age`, `gender`, `email`, `phone`, `pass`, `userPoint`, `qualification`,`dataTime`,group_member_id,group_mnemonic_name) VALUES (NULL, '$name', '$experience', '$designation', '$address', '$country', '$city', '$state', '$date', '$age', '$gender', '$email', '$phone', '$password', '123', '$education', '$currentdate','$group_member_id','$group_mnumonic_code');";

    $count = mysql_query($sqls) or die(mysql_error());


    $sql1 = mysql_query("select id,stf_name from tbl_cookie_adminstaff where email='$email' or phone='$phone' and group_member_id='$group_member_id'");
    $result=mysql_fetch_array($sql1);

    $cookie_admin_staf_id=$result['id'];
    $cookie_staf_name=$result['stf_name'];



     $sql="INSERT INTO `tbl_permission` (`permission_id`, `school_id`, `s_a_st_id`, `cookie_admin_staff_id`,`school_staff_name`, `cookie_staff_name`, `permission`, `current_date`) VALUES (NULL, NULL, NULL, '$cookie_admin_staf_id', NULL, '$cookie_staf_name', '$permision', '$currentdate')";
        $report=mysql_query($sql) or die(mysql_error());
        if($count>=1){

            // mail format changed by Pravin 2017-08-16
          $site = $_SERVER['HTTP_HOST'];
          //Modified below variable for adding Group Staff by Rutuja for SMC-4551 on 27/03/2020
          $msgid='groupstaff';

            $res = file_get_contents("https://$site/core/clickmail/sendmail.php?email=$email&msgid=$msgid&site=$site&pass=$password");


            echo "<script>alert('Successfully Added New Staff');window.location.href='GroupAdminStaff_list.php'</script>";
      
        }
        }
        else
        {

        $report="Email ID is already present";
        }

    }
?>

<!DOCTYPE html>
<head>



  <style>
  body {
   background-color:#F8F8F8;
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



  font: 600 15px "Open Sans",Arial,sans-serif;
}

label.control-label {
  font-weight: 600;
  color: #777;
}
</style>
 <script src='../js/bootstrap-datepicker.min.js' type='text/javascript'></script>
<script src="../js/city_state.js" type="text/javascript"></script>
<link href='../css/datepicker.min.css' rel='stylesheet' type='text/css'>

<script>
function toggle(source) {
  checkboxes = document.getElementsByName('permission[]');
  for(var i=0, n=checkboxes.length;i<n;i++) {
    checkboxes[i].checked = source.checked;
  }
}

function checkMaster(source) {
  checkboxes = document.getElementsByClassName('subMaster');
  for(var i=0, n=checkboxes.length;i<n;i++) {
    checkboxes[i].checked = source.checked;
  }
}

function checkSponsor(source) {
  checkboxes = document.getElementsByClassName('subSponsor');
  for(var i=0, n=checkboxes.length;i<n;i++) {
    checkboxes[i].checked = source.checked;
  }
}
 </script>
<script>
        $(document).ready(function () {

            $('.datepicker').datepicker({
        format: 'yyyy-mm-dd'

            });
        });
</script>
 <script>
$(function () {
        // add multiple select / deselect functionality
      /*  $("#master").click(function () {

            $('.subMaster').attr('checked', this.checked);
        });*/
        // if all checkbox are selected, then check the select all checkbox
        // and viceversa
        $(".subMaster").click(function () {

           if($(".subMaster:checked").length!=0) {
                  $("#master").attr("checked", "checked");
            }
      else
      {
       $("#master").removeAttr("checked");
      }

        });
    });

    $(function () {
        // add multiple select / deselect functionality
       /* $("#sponsor").click(function () {
            $('.subSponsor').attr('checked', this.checked);
        });*/
        // if all checkbox are selected, then check the select all checkbox
        // and viceversa
        $(".subSponsor").click(function () {

           if($(".subSponsor:checked").length!=0) {
                  $("#sponsor").attr("checked", "checked");
            }
      else
      {
       $("#sponsor").removeAttr("checked");
      }

        });
    });
</script>



<script>

function valid()
    {
    //Changes done by Pranali on 29-06-2018 for bug SMC-2839

    var first_name=document.getElementById("id_first_name").value;

        var last_name=document.getElementById("id_last_name").value;

        if(first_name.trim()==null || first_name.trim()=="" || last_name.trim()==null || last_name.trim()=="" )
            {

                document.getElementById('errorname').innerHTML='Please Enter Name';

                return false;
            }

        regx1=/^[A-z ]+$/;
               
                if(!regx1.test(first_name) || !regx1.test(last_name))
                {
                document.getElementById('errorname').innerHTML='Please Enter Valid Name';
                    return false;
                }
        else
          {
          document.getElementById('errorname').innerHTML='';
          }
  
        
      var experience=document.getElementById("experience").value;
      if(experience.trim()==null||experience.trim()=="")
            {
                document.getElementById('errorexperience').innerHTML='Please Enter Experience';
                return false;
            }
      else if(experience < 0)
      {
          document.getElementById('errorexperience').innerHTML='Please Enter Valid Experience';
          return false;
      }
      else
      {
        document.getElementById('errorexperience').innerHTML='';
      }
  
       var id_checkin=document.getElementById("id_checkin").value;
       var myDate = new Date(id_checkin);

        var today = new Date();
            if (id_checkin=="") {
        document.getElementById('errordob').innerHTML='Please Enter Date of Birth';
                return false;
            }
            else if (myDate.getFullYear() >= today.getFullYear()) {

              if (myDate.getFullYear() == today.getFullYear()) {
  
              if (myDate.getMonth() == today.getMonth()) {
            if (myDate.getDate() >= today.getDate()) {

              document.getElementById('errordob').innerHTML='Please Enter Valid Date of Birth';
                            return false;
                        }
                        else {
                              document.getElementById('errordob').innerHTML='';      
                        }

                 }

                 else if (myDate.getMonth() > today.getMonth()) {
                      document.getElementById('errordob').innerHTML='Please Enter Valid Date of Birth';
                      return false;

                 }
                 else {
                        document.getElementById('errordob').innerHTML='';        
                 }
           }
      else 
      {
         document.getElementById('errordob').innerHTML='Please Enter Valid Date Of Birth';
         return false;
             
      }
         }

         else {
            document.getElementById('errordob').innerHTML='';            
        }
      
       var gender1=document.getElementById("gender1").checked;
         var gender2=document.getElementById("gender2").checked;

        if(gender1==false && gender2==false)
            {
                document.getElementById('errorgender').innerHTML='Please Select Gender';
                return false;
            }
      else
      {
          document.getElementById('errorgender').innerHTML='';
      }
  
        var id_phone=document.getElementById("id_phone").value;
        if(id_phone==null||id_phone=="")
            {

                document.getElementById('errorphone').innerHTML='Please Enter Phone Number';

                return false;
            }

        regx2=/^[123456789]\d{9}$/;
               
                if(!regx2.test(id_phone))
                {
          document.getElementById('errorphone').innerHTML='Please Enter Valid Phone Number';
                    return false;
                }
        else
        {
          document.getElementById('errorphone').innerHTML='';
        }
  
    
    
        var email=document.getElementById("id_email").value;
    var patemail = /^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,4})$/;
      
       if(!patemail.test(email))
            {

                document.getElementById('erroremail').innerHTML='Please Enter Valid Email Id';
                return false;
            }
      else
        {
          document.getElementById('erroremail').innerHTML='';
        }

  
    var address=document.getElementById("address").value;
        var addrpat=/^[a-zA-Z0-9\s,'-]*$/;
    if(address.trim()=="" || address.trim()==null)
            {
                document.getElementById('erroraddress').innerHTML='Please Enter Address';
                return false;
            }
      else if(!addrpat.test(address))
      {
        document.getElementById('erroraddress').innerHTML='Please Enter Valid Address';
        return false;
      }
      else
      {
        document.getElementById('erroraddress').innerHTML='';

      }
       
    
    var country=document.getElementById("country").value;

        if(country=="-1")
            {
                document.getElementById('errorcountry').innerHTML='Please Select Country';
                return false;
            }
      else
      {
        document.getElementById('errorcountry').innerHTML='';
      }

        var state=document.getElementById("state").value;
        if(state=="")
            {

                document.getElementById('errorstate').innerHTML='Please Select State';
                return false;
            }
      else
      {
        document.getElementById('errorstate').innerHTML='';
      }

        var city=document.getElementById("id_city").value;
    var pattern = /^[A-z]+$/;
        if(city.trim()==null||city.trim()=="")
            {
                document.getElementById('errorcity').innerHTML='Please Enter City';
                return false;
            }
      else if(!pattern.test(city)) {
      document.getElementById('errorcity').innerHTML="Please Enter Valid City!";
      return false;
    }
    else
      {
        document.getElementById('errorcity').innerHTML='';
      }


  //changes end

    }
</script>

</head>
<body >
  <div class='container' >
    <div class='panel panel-primary dialog-panel' style="background-color:#FFFFFF;border:1px solid #694489">
   <div style="color:red;font-size:15px;font-weight:bold;margin-top:10px;"><?php if(isset($_GET['report'])){ echo $_GET['report']; };?></div>
      <div class='panel-heading'>

            <h3 align="center" style="padding-left:20px; margin-top:2px;color:white;background-color:#694489;padding-top:10px;padding-bottom:10px">Group Admin Staff</h3>

            <div class='row' align="center"  style="color:#FF0000"><?php echo $report;?></div>
      
    </div>
      <div class='panel-body'>
        <form class='form-horizontal' role='form' method="post">


        <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='id_title' style="text-align:left;">Staff Name<span style='color:red;font-weight:bold;font-size: 17px;'>&#9913</span></label>
            <div class='col-md-8'>

              <div class='col-md-3 '>
                <div class='form-group internal'>
                  <input class='form-control' id='id_first_name' name="id_first_name" placeholder='First Name' type='text' value='<?php if(isset($_POST['id_first_name'])) { echo $_POST['id_first_name'];}?>'>
                </div>
              </div>
              <div class='col-md-3 col-sm-offset-1'>
                <div class='form-group internal'>
                  <input class='form-control' id='id_last_name' name="id_last_name" value='<?php if(isset($_POST['id_last_name'])) { echo $_POST['id_last_name'];}?>' placeholder='Last Name' type='text'>
                </div>
              </div>
              <div class='col-md-4 indent-small' id="errorname" style="color:#FF0000">

              </div>
            </div>
          </div>

         <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='id_service' style="text-align:left;">Education</label>
            <div class='col-md-2'>
              <select class='multiselect  form-control' id='id_service' value='<?php if(isset($_POST['id_service'])) { echo $_POST['id_service'];}?>' name="id_education" >
                <option value='BA'>BA</option>
                <option value='BCom'>BCom</option>
                <option value='BSc'>BSc</option>
        <option value='B.ED'>B.ED</option>
        <option value='D.ED'>D.ED</option>
                <option value='MA'>MA</option>
                <option value='MCom'>MCom</option>
                <option value='MSc'>MSc</option>
               
              </select>
            </div>

            <label class='control-label col-md-2 '>Experience<span style='color:red;font-weight:bold;font-size: 17px;'>&#9913</span></label>

              <div class='col-md-2'>

                  <input class='form-control col-md-8' id='experience' value='<?php if(isset($_POST['experience'])) { echo $_POST['experience'];}?>' name='experience' placeholder='Experience' type='text'>

              </div>
        <!-- Changes done by Pranali on 29-06-2018 for bug SMC-2839  -->

             <div class='col-md-25 indent-small' id="errorexperience" style="color:#FF0000;"></div>
       <!-- changes end  -->
      
      </div>

          <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='id_title' style="text-align:left;">Designation</label>


                <div class='col-md-8'>
           <input class='form-control col-md-8' style="width:20%;" id='Designation' value="" value='<?php if(isset($_POST['Designation'])) { echo $_POST['Designation'];}?>' name="Designation" placeholder='Designation' type='text'>
                </div>
                </div>



            <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='id_checkin' style="text-align:left;">Date Of Birth<span style='color:red;font-weight:bold;font-size: 17px;'>&#9913</span></label>
            <div class='col-md-8'>
              <div class='col-md-5'>
                <div class='form-group internal input-group'>

               <input class='form-control datepicker' type="text" class='form-control' id="id_checkin" value="" placeholder="YYYY/MM/DD" value='<?php if(isset($_POST['dob'])) { echo $_POST['dob'];}?>' name="dob" class="form-control">

                </div>

                <div class='col-md-15' id="errordob" style="color:#FF0000"></div>
              </div>

            </div>
          </div>


          <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='id_pets' style="text-align:left;">Gender<span style='color:red;font-weight:bold;font-size: 17px;'>&#9913</span></label>
           <div class='col-md-2' style="font-weight: 600;
color: #777;">
           <input type="radio" name="gender" id="gender1" value='<?php if(isset($_POST['gender'])) { echo $_POST['gender'];}?>' value="Male">
                  Male
             </div>
             <div class='col-md-3' style="font-weight: 600;
color: #777;">
             <input type="radio" name="gender" id="gender2" value="Female">
            Female
              </div>

                <div class='col-md-2 indent-small' id="errorgender" style="color:#FF0000">
          </div>
          </div>


      <div class='form-group '>
                <label class='control-label col-md-2 col-md-offset-2' for='id_phone' style="text-align:left;" >Contact<span style='color:red;font-weight:bold;font-size: 17px;'>&#9913</span></label>
                <div class='col-md-6'>
                    <div class='form-group'>
                        <div class='col-md-6'>
                    <input class='form-control' id='id_phone' name="id_phone" value='<?php if(isset($_POST['id_phone'])) { echo $_POST['id_phone'];}?>' placeholder='Mobile No' type='number' min="0" ">
                </div>
                <div class='indent-small' id="errorphone" style="color:#FF0000">
                </div>
            </div>
                </div>
            </div>
      
         <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='id_email' style="text-align:left;" >Email<span style='color:red;font-weight:bold;font-size: 17px;'>&#9913</span></label>
            <div class='col-md-6'>
              <div class='form-group'>
                <div class='col-md-6'>
                  <input class='form-control' id='id_email' name="id_email" value='<?php if(isset($_POST['id_email'])) { echo $_POST['id_email'];}?>' placeholder='E-mail' type='text'>
                </div>
                <div class='indent-small' id="erroremail" style="color:#FF0000">

              </div>
              </div>
            </div>
          </div>

      <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='id_comments' style="text-align:left;">Address<span style='color:red;font-weight:bold;font-size: 17px;'>&#9913</span></label>
            <div class='col-md-4'>
              <textarea class='form-control' id="address" name="address" value='<?php if(isset($_POST['address'])) { echo $_POST['address'];}?>' placeholder='Address' rows='3'></textarea>
            </div>
            <div class='indent-small' id="erroraddress" style="color:#FF0000"></div>
          </div>



         <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' style="text-align:left;" >Country<span style='color:red;font-weight:bold;font-size: 17px;'>&#9913</span></label>
            <div class='col-md-3'>
                  <select id="country" name="country" value='<?php if(isset($_POST['country'])) { echo $_POST['country'];}?>' class='form-control'></select>
                </div>


            <div class='indent-small' id="errorcountry" style="color:#FF0000"></div>
           </div>
        <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' style="text-align:left;">State<span style='color:red;font-weight:bold;font-size: 17px;'>&#9913</span></label>
            <div class='col-md-3'>
                  <select name="state" id="state" value='<?php if(isset($_POST['state'])) { echo $_POST['state'];}?>' class='form-control'></select>
                </div>

              <div class='indent-small' id="errorstate" style="color:#FF0000"></div>

          </div>
          <script language="javascript">
            populateCountries("country", "state");
            populateCountries("country2");
        </script>






         <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='id_accomodation' style="text-align:left;" >City<span style='color:red;font-weight:bold;font-size: 17px;'>&#9913</span></label>
            <div class='col-md-3'>
              <input type="text" class='form-control' value='<?php if(isset($_POST['city'])) { echo $_POST['city'];}?>' id='id_city' name="city" placeholder="City">
            </div>
             <div class='indent-small' id="errorcity" style="color:#FF0000"></div>
          </div>
    <!--   <div class='form-group'>

            <fieldset style="border:thick;    margin :20px;">
    <legend>Permissions:</legend>
                       <!--<input type="checkbox" name="permission[]" value="Leader Board"> Leader Board&nbsp;
                       <input type="checkbox" name="permission[]" value="Master"> Master&nbsp;
                       <input type="checkbox" name="permission[]" value="school"> school &nbsp;

                       <input type="checkbox" name="permission[]" value="Log"> Log<br></p>
                       <input type="checkbox" name="permission[]" value="Sponsor Map"> Sponsor Map
                       <input type="checkbox" name="permission[]" value="Purchese Coupons"> Purchese Coupons
                       <input type="checkbox" name="permission[]" value="Profile"> Profile
                       <input type="checkbox" name="permission[]" value="Start Board" > Start Board<br>

   <div class="form-group internal" align="center" style="padding:10px;"> <td style="background-color:#B2B2B2;  border-radius:5px;"><input type="checkbox" onClick="toggle(this)">Select All</td></div>
  <table id="perm" class="table table-bordered" style="border-radius:8px; border:1px solid #777;box-shadow: 1px 1px 1px 2px  rgba(150,150,150, 0.4);">
                           <tr style="background-color:#9F5F9F;color:white;box-shadow: 1px 1px 1px 2px  rgba(150,150,150, 0.6);">
                               <td>

                                   <input id="master" onclick="checkMaster(this) " type="checkbox" name="permission[]" value="Master"> Master


                               </td>
                               <td>

                                   <input type="checkbox" name="permission[]" value="Map"> Map   &nbsp;


                               </td>
                               <td>

                                   <input type="checkbox" name="permission[]" value="Gift Card"> Gift Card


                               </td>
                               <td>

                                   <input type="checkbox" name="permission[]" value="Colleges"> Colleges


                               </td>
                               <td>

                                   <input  id="sponsor" onclick="checkSponsor(this)" type="checkbox" name="permission[]" value="Sponsor"> Sponsor

                               </td>
                               <td>

                                   <input type="checkbox" name="permission[]" value="Social Footprint"> Social Footprint


                               </td>
                               <td>

                                   <input type="checkbox" name="permission[]" value="Log"> Log


                               </td>
                               <td>

                                   <input type="checkbox" name="permission[]" value="Leader Board"> Leader Board



                               </td>
                               <td>

                                   <input type="checkbox" name="permission[]" value="Error"> Error Log Report


                               </td>

                               <td>

                                   <input type="checkbox" name="permission[]" value="Account"> Account


                               </td>

                           </tr>
                           <tr>
                                <td>
                                     <ul style="list-style-type:none;margin-left: -41px;">
                                       <li>

                                           <input class="subMaster" type="checkbox" name="permission[]" value="School"> School/Sponsor

                                       </li>
                                       <li>

                                           <input class="subMaster" type="checkbox" name="permission[]" value="Sales Person"> Sales Person

                                       </li>
                                       <li>

                                           <input class="subMaster" type="checkbox" name="permission[]" value="Blue Points"> Blue Points

                                      </li>
                                       <li>

                                           <input class="subMaster" type="checkbox" name="permission[]" value="Activity"> Activity

                                       </li>
                                       <li>

                                           <input class="subMaster" type="checkbox" name="permission[]" value="AdminStaff"> Add Staff

                                       </li>
                                       <li>

                                           <input class="subMaster" type="checkbox" name="permission[]" value="Type"> Activity Type

                                       </li>
                                       <li>

                                           <input class="subMaster" type="checkbox" name="permission[]" value="Soft Rewards"> Soft Rewards

                                       </li>
                                       <li>

                                           <input class="subMaster" type="checkbox" name="permission[]" value="ThanQ List"> ThanQ List

                                       </li>
                                       <li>

                                           <input class="subMaster" type="checkbox" name="permission[]" value="Categories & Currencies"> Categories & Currencies

                                       </li>
                                       <li>

                                           <input class="subMaster" type="checkbox" name="permission[]" value="Rule Engine"> Rule Engine

                                       </li>
                                     </ul>
                                </td>
                                <td></td>
                                <td></td>
                                <td>All India College List</td>
                                <td>
                                    <ul style="list-style-type:none;margin-left: -41px;">
                                        <li>

                                           <input class="subSponsor" type="checkbox" name="permission[]" value="Registered"> Registered Sponsers

                                        </li>
                    <li>


                                           <input class="subSponsor" type="checkbox" name="permission[]" value="SponsorProfileSummery">Sponsor Profile Summary


                                        </li>
                                        <li>

                                           <input class="subSponsor" type="checkbox" name="permission[]" value="Suggested"> Suggested

                                        </li>
                                        <li>

                                           <input class="subSponsor" type="checkbox" name="permission[]" value="Location"> Location & Coupons

                                        </li>
                                        <li>

                                           <input class="subSponsor" type="checkbox" name="permission[]" value="Statistics"> Statistics

                                        </li>
                                    </ul>
                                </td>
                                <td></td>
                                <td>Soft Rewards</td>
                                <td></td>
                                <td></td>
                           </tr>
                      </table>
                  </fieldset>

           </div>-->



                            <div class='form-group row'>
           <div class='col-md-2 col-md-offset-4' >
                 <input class='btn-lg btn-primary' type='submit' value="Submit" name="submit" onClick="return valid()" style="padding:5px;"/>
                </div> <div class='col-md-1'>




              <div class='col-md-1'>

                     <a href="GroupAdminStaff_list.php"><button class='btn-lg btn-danger'  type='submit' style="padding:5px;">Cancel</button></a>

                  </div>


        </form>
      </div>

    </div>
  </div>
</body>
<?php }else{

  $report = "";

$staffid = $_GET['staff'];
if (isset($_POST['update'])) {

    /* $email = $_POST['id_email'];  */
    $id_first_name = $_POST['id_first_name'];
    $id_last_name = $_POST['id_last_name'];
    $name = $id_first_name . " " . $id_last_name;
    $education = $_POST['id_education'];
    $experience = $_POST['experience'];
    $designation = $_POST['Designation'];
    $date = $_POST['dob'];

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


    $email = $_POST['id_email'];
    $phone = $_POST['id_phone'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];

    $city = $_POST['city'];
  //date format changes by sachin 03-10-2018
  // $dates = date('m/d/Y');
    $dates = date('Y/m/d');
  //date format changes by sachin 03-10-2018
    

    $password = $id_first_name . "123";
    $permision = implode(',', $_POST['permission']);

    list($month, $day, $year) = explode("/", $date);
    $year_diff = date("Y") - $year;
    $month_diff = date("m") - $month;
    $day_diff = date("d") - $day;
    if ($day_diff < 0 || $month_diff < 0) $year_diff--;
    $age = $year_diff;
    /*echo"<br>" .$age; */

    $currentdate = CURRENT_TIMESTAMP;


    $updatestaff = "UPDATE tbl_cookie_adminstaff SET `stf_name`='$name',`exprience` ='$experience',`designation`='$designation',`address`='$address',`country`='$country',`city`='$city',`statue`='$state',`dob`='$date',`age`='$age',`gender`='$gender',`email`='$email',`phone`='$phone',`qualification`='$education' WHERE  `id`='$staffid' and group_member_id='$group_member_id'";

    $count = mysql_query($updatestaff) or die(mysql_error());


    $sql1 = mysql_query("select id,stf_name from tbl_cookie_adminstaff where email='$email' or phone='$phone' and group_member_id='$group_member_id'");
    $result = mysql_fetch_array($sql1);

    $cookie_admin_staf_id = $result['id'];
    $cookie_staf_name = $result['stf_name'];

    $row = mysql_query("select * from `tbl_permission` where cookie_admin_staff_id = '$cookie_admin_staf_id'");
    if (mysql_num_rows($row) <= 0) {

        $sql = "INSERT INTO `tbl_permission` (`permission_id`, `school_id`, `s_a_st_id`, `cookie_admin_staff_id`,`school_staff_name`, `cookie_staff_name`, `permission`, `current_date`) VALUES (NULL, NULL, NULL, '$cookie_admin_staf_id', NULL, '$cookie_staf_name', '$permision', '$currentdate')";
    } else {
        $sql = "Update `tbl_permission` SET permission='$permision' WHERE cookie_admin_staff_id = '$cookie_admin_staf_id'";
        /* $report="Email ID is already present";        */
    }


    $report = mysql_query($sql) or die(mysql_error());
    if ($count >= 1) {

        /*$to=$email;
        $from="smartcookiesprogramme@gmail.com";
        $subject="Succesful Registration";
        $message="Hello ".$id_first_name." ".$id_last_name."\r\n\r\n".
             "Thanks for registration with Smart Cookie as teacher\r\n".
              "your Username is: "  .$email.  "\n\n".
              "your password is: ".$password."\n\n".
              "your School ID is: ".$school_id."\n\n".
              "Regards,\r\n".
                 "Smart Cookie Admin";

           mail($to, $subject, $message);*/

        $report = "successfully updated";
        /*header("Location:cookieAdminStaff_list.php?report=".$report);*/
    }


}


/*echo "stf". $staffid;      */
$getstaff = mysql_query("select * from tbl_cookie_adminstaff where id=" . $staffid . "");
$getrow = mysql_fetch_array($getstaff);

$staffname = explode(' ', $getrow['stf_name']);
$staffname[0];
$staffname[1];
?>

<!DOCTYPE html>
<head>


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

        #perm td ul li {

            padding: 2px;
            /*  border:1px solid #ccc;    */

            /*  border-radius:0px;      */
            /*box-shadow: 0px 0px 0px 1px rgba(150,150,100,0.2);   */
        }
    </style>
    <script src='../js/bootstrap-datepicker.min.js' type='text/javascript'></script>
    <script src="../js/city_state.js" type="text/javascript"></script>
    <link href='../css/datepicker.min.css' rel='stylesheet' type='text/css'>

    <script>
        $(document).ready(function () {

            $('.datepicker').datepicker({
        format: 'yyyy-mm-dd'

            });
        });
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

        $(document).ready(function () {

            $('#state').change(function () {

                var state = document.getElementById("state").value;

                if (state == null || state == "") {

                    document.getElementById('errorstate').innerHTML = 'Please enter State';

                    return false;
                }

                else {
                    document.getElementById('errorstate').innerHTML = '';


                }


            });
        });
    </script>

    <script>
        function toggle(source) {
            checkboxes = document.getElementsByName('permission[]');
            for (var i = 0, n = checkboxes.length; i < n; i++) {
                checkboxes[i].checked = source.checked;
            }
        }

        function checkMaster(source) {
            checkboxes = document.getElementsByClassName('subMaster');
            for (var i = 0, n = checkboxes.length; i < n; i++) {
                checkboxes[i].checked = source.checked;
            }
        }

        function checkSponsor(source) {
            checkboxes = document.getElementsByClassName('subSponsor');
            for (var i = 0, n = checkboxes.length; i < n; i++) {
                checkboxes[i].checked = source.checked;
            }
        }
    </script>
    <script>
        $(function () {
            // add multiple select / deselect functionality
            /*  $("#master").click(function () {

             $('.subMaster').attr('checked', this.checked);
             });*/
            // if all checkbox are selected, then check the select all checkbox
            // and viceversa
            $(".subMaster").click(function () {

                if ($(".subMaster:checked").length != 0) {
                    $("#master").attr("checked", "checked");
                }
                else {
                    $("#master").removeAttr("checked");
                }

            });
        });

        $(function () {
            // add multiple select / deselect functionality
            /* $("#sponsor").click(function () {
             $('.subSponsor').attr('checked', this.checked);
             });*/
            // if all checkbox are selected, then check the select all checkbox
            // and viceversa
            $(".subSponsor").click(function () {

                if ($(".subSponsor:checked").length != 0) {
                    $("#sponsor").attr("checked", "checked");
                }
                else {
                    $("#sponsor").removeAttr("checked");
                }

            });
        });
    </script>

   <script>

function valid()
    {
    //Changes done by Pranali on 29-06-2018 for bug SMC-2839

    var first_name=document.getElementById("id_first_name").value;

        var last_name=document.getElementById("id_last_name").value;

        if(first_name.trim()==null || first_name.trim()=="" || last_name.trim()==null || last_name.trim()=="" )
            {

                document.getElementById('errorname').innerHTML='Please Enter Name';

                return false;
            }

        regx1=/^[A-z ]+$/;
               
                if(!regx1.test(first_name) || !regx1.test(last_name))
                {
                document.getElementById('errorname').innerHTML='Please Enter Valid Name';
                    return false;
                }
        else
          {
          document.getElementById('errorname').innerHTML='';
          }
  
        
      var experience=document.getElementById("experience").value;
      if(experience.trim()==null||experience.trim()=="")
            {
                document.getElementById('errorexperience').innerHTML='Please Enter Experience';
                return false;
            }
      else if(experience < 0)
      {
          document.getElementById('errorexperience').innerHTML='Please Enter Valid Experience';
          return false;
      }
      else
      {
        document.getElementById('errorexperience').innerHTML='';
      }
  
       var id_checkin=document.getElementById("id_checkin").value;
       var myDate = new Date(id_checkin);

        var today = new Date();
            if (id_checkin=="") {
        document.getElementById('errordob').innerHTML='Please Enter Date of Birth';
                return false;
            }
            else if (myDate.getFullYear() >= today.getFullYear()) {

              if (myDate.getFullYear() == today.getFullYear()) {
  
              if (myDate.getMonth() == today.getMonth()) {
            if (myDate.getDate() >= today.getDate()) {

              document.getElementById('errordob').innerHTML='Please Enter Valid Date of Birth';
                            return false;
                        }
                        else {
                              document.getElementById('errordob').innerHTML='';      
                        }

                 }

                 else if (myDate.getMonth() > today.getMonth()) {
                      document.getElementById('errordob').innerHTML='Please Enter Valid Date of Birth';
                      return false;

                 }
                 else {
                        document.getElementById('errordob').innerHTML='';        
                 }
           }
      else 
      {
         document.getElementById('errordob').innerHTML='Please Enter Valid Date Of Birth';
         return false;
             
      }
         }

         else {
            document.getElementById('errordob').innerHTML='';            
        }
      
       var gender1=document.getElementById("gender1").checked;
         var gender2=document.getElementById("gender2").checked;

        if(gender1==false && gender2==false)
            {
                document.getElementById('errorgender').innerHTML='Please Select Gender';
                return false;
            }
      else
      {
          document.getElementById('errorgender').innerHTML='';
      }
  
        var id_phone=document.getElementById("id_phone").value;
        if(id_phone==null||id_phone=="")
            {

                document.getElementById('errorphone').innerHTML='Please Enter Phone Number';

                return false;
            }

        regx2=/^[123456789]\d{9}$/;
               
                if(!regx2.test(id_phone))
                {
          document.getElementById('errorphone').innerHTML='Please Enter Valid Phone Number';
                    return false;
                }
        else
        {
          document.getElementById('errorphone').innerHTML='';
        }
  
    
    
        var email=document.getElementById("id_email").value;
    var patemail = /^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,4})$/;
      
       if(!patemail.test(email))
            {

                document.getElementById('erroremail').innerHTML='Please Enter Valid Email Id';
                return false;
            }
      else
        {
          document.getElementById('erroremail').innerHTML='';
        }

  
    var address=document.getElementById("address").value;
        var addrpat=/^[a-zA-Z0-9\s,'-]*$/;
    if(address.trim()=="" || address.trim()==null)
            {
                document.getElementById('erroraddress').innerHTML='Please Enter Address';
                return false;
            }
      else if(!addrpat.test(address))
      {
        document.getElementById('erroraddress').innerHTML='Please Enter Valid Address';
        return false;
      }
      else
      {
        document.getElementById('erroraddress').innerHTML='';

      }
       
    
    var country=document.getElementById("country1").value;

        if(country=="-1")
            {
                document.getElementById('errorcountry').innerHTML='Please Select Country';
                return false;
            }
      else
      {
        document.getElementById('errorcountry').innerHTML='';
      }

        var state=document.getElementById("state").value;
        if(state=="")
            {

                document.getElementById('errorstate').innerHTML='Please Select State';
                return false;
            }
      else
      {
        document.getElementById('errorstate').innerHTML='';
      }

        var city=document.getElementById("id_city").value;
    var pattern = /^[A-z]+$/;
        if(city.trim()==null||city.trim()=="")
            {
                document.getElementById('errorcity').innerHTML='Please Enter City';
                return false;
            }
      else if(!pattern.test(city)) {
      document.getElementById('errorcity').innerHTML="Please Enter Valid City!";
      return false;
    }
    else
      {
        document.getElementById('errorcity').innerHTML='';
      }


  //changes end

    }
</script>
<script>
function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}

    </script>

</head>
<body>
<div class='container'>
    <div class='panel panel-primary dialog-panel' style="background-color:#FFFFFF;border:1px solid #694489">
    <div style="color:red;font-size:15px;font-weight:bold;margin-top:10px;"><?php if (isset($_GET['report'])) {
            echo $_GET['report'];
        }; ?></div>
    <div class='panel-heading'>

        <h3 align="center" style="padding-left:20px; margin-top:2px;color:white;background-color:#694489;padding-top:10px;padding-bottom:10px">Edit Group Admin Staff</h3>


        <!-- <h5 align="center"><a href="Add_teacherSheet.php" >Add Excel Sheet</a></h5>-->
    </div>
    <div class="col-md-2" style="margin-top:-10px;">
        <a href="GroupAdminStaff_list.php" style="text-decoration:none;">
    <input type="button" class="btn btn-warning" name="Back" value="Back" style="width:50%;"  /></a>
                    </div>
    <div class='panel-body' style="margin-top: 20px;">

        <form class='form-horizontal' role='form' method="post">


            <div class='form-group'>
                <label class='control-label col-md-2 col-md-offset-2' for='id_title' style="text-align:left;">Staff
                    Name<span style='color:red;font-weight:bold;font-size: 17px;'>&#9913</span></label>
                <div class='col-md-8'>

                    <div class='col-md-3 '>
                        <div class='form-group internal'>
                            <input class='form-control' id='id_first_name' name="id_first_name"
                                   value="<?= $staffname[0]; ?>" placeholder='First Name' type='text'>
                        </div>
                    </div>
                    <div class='col-md-3 col-sm-offset-1'>
                        <div class='form-group internal'>
                            <input class='form-control' id='id_last_name' name="id_last_name"
                                   value="<?= $staffname[1]; ?>" placeholder='Last Name' type='text'>
                        </div>
                    </div>
                    <div class='col-md-4 indent-small' id="errorname" style="color:#FF0000">

                    </div>
                </div>
            </div>

            <?php


            if ($getrow['qualification'] != '0')
            {
            ?>
            <div class='form-group'>
                <label class='control-label col-md-2 col-md-offset-2' for='id_service' style="text-align:left;">Education<span style='color:red;font-weight:bold;font-size: 17px;'>&#9913</span></label>
                <div class='col-md-2'>
                    <select class='multiselect  form-control' id='id_service' name="id_education">
                        <option value='<?= $getrow['qualification'] ?>'><?= $getrow['qualification'] ?></option>
                        <option value='BE'>BE</option>
                        <option value='BCom'>BCom</option>
                        <option value='BSc'>MBA</option>
                        <option value='MA'>MTech</option>
                        <option value='MCom'>MCom</option>
                        <option value='MSc'>BTech</option>
                        <option value='B.ED'>Phd</option>
                        <option value='D.ED'>Other</option>
                    </select>
                </div>
                <?php

                }
                else
                {
                ?>

                <div class='form-group'>
                    <label class='control-label col-md-2 col-md-offset-2' for='id_service' style="text-align:left;">Education<span style='color:red;font-weight:bold;font-size: 17px;'>&#9913</span></label>
                    <div class='col-md-2'>
                        <select class='multiselect  form-control' id='id_service' name="id_education">
                            <option value='BA'>BA</option>
                            <option value='BCom'>BCom</option>
                            <option value='BSc'>BSc</option>
                            <option value='MA'>MA</option>
                            <option value='MCom'>MCom</option>
                            <option value='MSc'>MSc</option>
                            <option value='B.ED'>B.ED</option>
                            <option value='D.ED'>D.ED</option>
                        </select>
                    </div>
                    <?php

                    }

                    ?>


                    <label class='control-label col-md-2 '>Experience<span style='color:red;font-weight:bold;font-size: 17px;'>&#9913</span></label>

                    <div class='col-md-2'>

                        <input class='form-control col-md-8' id='experience' name='experience'
                               value="<?= $getrow['exprience'] ?>" placeholder='Experience' type='text' onKeyPress="return isNumberKey(event)">

                    </div>
                    <div class='col-md-2 indent-small' id="errorexperience" style="color:#FF0000"></div>


                </div>

               <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='id_title' style="text-align:left;">Designation</label>


                <div class='col-md-8'>
           <input class='form-control col-md-8' style="width:20%;" id='Designation'  value="<?= $getrow['designation'] ?>" name="Designation" placeholder='Designation' type='text'>
                </div>
                </div>

                    <div class='form-group'>
                        <label class='control-label col-md-2 col-md-offset-2' for='id_checkin' style="text-align:left;">Date
                            Of Birth<span style='color:red;font-weight:bold;font-size: 17px;'>&#9913</span></label>
                        <div class='col-md-8'>
                            <div class='col-md-5'>
                                <div class='form-group internal input-group'>

                                    <input class='form-control datepicker' id="id_checkin" placeholder="YYYY/MM/DD" value="<?= $getrow['dob'] ?>"
                                           name="dob" class="form-control">

                                </div>

                                <div class='col-md-15' id="errordob" style="color:#FF0000"></div>
                            </div>

                        </div>
                    </div>


                    <div class='form-group'>
                        <label class='control-label col-md-2 col-md-offset-2' for='id_pets' style="text-align:left;">Gender<span style='color:red;font-weight:bold;font-size: 17px;'>&#9913</span></label>
                        <div class='col-md-2' style="font-weight: 600;
color: #777;">

                            <input type="radio" name="gender" <?php if ($getrow['gender'] == "Male") echo "checked"; ?>
                                   id="gender1" value="Male">
                            Male
                        </div>
                        <div class='col-md-3' style="font-weight: 600;
color: #777;">
                            <input type="radio"
                                   name="gender" <?php if ($getrow['gender'] == "Female") echo "checked"; ?>
                                   id="gender2" value="Female">
                            Female
                        </div>

                        <div class='col-md-2 indent-small' id="errorgender" style="color:#FF0000">
                        </div>
                    </div>


                    <div class='form-group'>
                        <label class='control-label col-md-2 col-md-offset-2' for='id_email' style="text-align:left;">Contact<span style='color:red;font-weight:bold;font-size: 17px;'>&#9913</span></label>
                        <div class='col-md-6'>
                            <div class='form-group'>
                                <div class='col-md-6'>
                                    <input class='form-control' id='id_email' name="id_email"
                                           value="<?= $getrow['email'] ?>" placeholder='E-mail' type='text'>
                                </div>
                                <div class='col-md-3 indent-small' id="erroremail" style="color:#FF0000">

                                </div>
                            </div>
                            <div class='form-group '>
                                <div class='col-md-6'>
                                    <input class='form-control' id='id_phone' name="id_phone"
                                           value="<?= $getrow['phone'] ?>" placeholder='Mobile No' type='text'>
                                        
                                </div>
                                <div class='col-md-3 indent-small' id="errorphone" style="color:#FF0000">

                                </div>
                            </div>
                        </div>
                    </div>


                    <div class='form-group'>
                        <label class='control-label col-md-2 col-md-offset-2' for='id_comments'
                               style="text-align:left;">Address<span style='color:red;font-weight:bold;font-size: 17px;'>&#9913</span></label>
                        <div class='col-md-4'>
                            <textarea class='form-control' id='address' name="address" placeholder='Address'
                                      rows='3'><?php echo $getrow['address']; ?></textarea>
                        </div>
                        <div class='col-md-2 indent-small' id="erroraddress" style="color:#FF0000"></div>
                    </div>
                    <div class="row" align="center" id='erroraddress' style="color:#FF0000;"></div>


                    <div class="row" style="padding-top:15px;" id="text_country" style="display:block">

                        <label class='control-label col-md-2 col-md-offset-2' for='id_comments'
                               style="text-align:left;">Country<span style='color:red;font-weight:bold;font-size: 17px;'>&#9913</span></label>
                        <div class="col-md-3"><input type="text" class='form-control' id="country1" name="country1"
                                                     value="<?= $getrow['country'] ?>" readonly>
                        </div>
                        <div class="col-md-1" id="firstBtn"><a href="" onclick="return showOrhide()">Edit</a></div>

                    </div>

                    <div class='row' style="padding-top:7px; display:none" id="text_country1">
                        <label class='control-label col-md-2 col-md-offset-2' for='id_comments'
                               style="text-align:left;">Country<span style='color:red;font-weight:bold;font-size: 17px;'>&#9913</span></label>
                        <div class='col-md-3'>
                            <select id="country" name="country" class='form-control'></select>
                        </div>
                        <div class='col-md-3 indent-small' id="errorcountry" style="color:#FF0000"></div>
                    </div>


                    <div class='row' style="padding-top:7px; display:none" id="text_state1">
                        <label class='control-label col-md-2 col-md-offset-2' for='id_comments'
                               style="text-align:left;">State <span style='color:red;font-weight:bold;font-size: 17px;'>&#9913</span></label>
                        <div class='col-md-3'>
                            <select id="state" name="state" class='form-control'></select>
                        </div>
                        <div><?php //echo $report4; ?></div>
                    </div>

                    <div class="row" style="padding-top:7px;" id="text_state" style="display:block">
                        <label class='control-label col-md-2 col-md-offset-2' for='id_comments'
                               style="text-align:left;"> State<span style='color:red;font-weight:bold;font-size: 17px;'>&#9913</span></label>
                        <div class="col-md-3"><input type="text" id="state1" name="state1" class='form-control'
                                                     style="width:100%;" value="<?= $getrow['statue'] ?>" readonly>

                        </div>
                    </div>


                    <script language="javascript">
                        populateCountries("country", "state");
                        populateCountries("country2");


                    </script>


                    <div class='form-group' style="    margin-top: 14px;">
                        <label class='control-label col-md-2 col-md-offset-2' for='id_accomodation'
                               style="text-align:left;">City<span style='color:red;font-weight:bold;font-size: 17px;'>&#9913</span></label>
                        <div class='col-md-3'>
                            <input type="text" class='form-control' value="<?= $getrow['city'] ?>" id='id_city'
                                   name="city" placeholder="City">
                        </div>
                        <div class='col-md-3 indent-small' id="errorcity" style="color:#FF0000"></div>
                    </div>

                    <!--<div class='form-group' style="margin:18px;">
                        <fieldset style="border:thick;">
                            <legend>Permissions:</legend>
                            <?php

                            $cookie_ad_st_id = $getrow['id'];
                            $sql = mysql_query("SELECT * FROM `tbl_permission` WHERE cookie_admin_staff_id='$cookie_ad_st_id'");
                            $arr = mysql_fetch_assoc($sql);
                            $perm = $arr['permission'];
                            /*echo $perm;*/

                            ?>
                          <?php
                            $lb = strpos($perm, "Leader");
                            if ($lb !== false) { ?>
                       <input type="checkbox" name="permission[]" value="Leader" checked> Leader Board&nbsp;
                       <?php } else { ?>
                       <input type="checkbox" name="permission[]" value="Leader"> Leader Board&nbsp;
                       <?php } ?>

                       <?php
                            $mas = strpos($perm, "Master");
                            if ($mas !== false) { ?>
                       <input type="checkbox" name="permission[]" value="Master" checked> Master&nbsp; <br>
                       <?php } else { ?>
                       <input type="checkbox" name="permission[]" value="Master"> Master&nbsp; <br>
                       <?php } ?>

                       <?php
                            $sch = strpos($perm, "school");
                            if ($sch !== false) { ?>
                       <input type="checkbox" name="permission[]" value="school" checked> school &nbsp; <br>
                       <?php } else { ?>
                       <input type="checkbox" name="permission[]" value="school"> school &nbsp; <br>
                       <?php } ?>

                       <?php
                            $lg = strpos($perm, "Log");
                            if ($lg !== false) { ?>
                       <input type="checkbox" name="permission[]" value="Log" checked> Log   <br>
                       <?php } else { ?>
                       <input type="checkbox" name="permission[]" value="Log"> Log   <br>
                       <?php } ?>

                       <?php
                            $sp = strpos($perm, "Sponsor Map");
                            if ($sp !== false) { ?>
                       <input type="checkbox" name="permission[]" value="Sponsor Map" checked> Sponsor Map   <br>
                       <?php } else { ?>
                       <input type="checkbox" name="permission[]" value="Sponsor Map"> Sponsor Map   <br>
                       <?php } ?>

                       <?php
                            $pc = strpos($perm, "Purchese Coupons");
                            if ($pc !== false) { ?>
                       <input type="checkbox" name="permission[]" value="Purchese Coupons" checked> Purchese Coupons   <br>
                       <?php } else { ?>
                       <input type="checkbox" name="permission[]" value="Purchese Coupons"> Purchese Coupons   <br>
                       <?php } ?>

                       <?php
                            $pr = strpos($perm, "Profile");
                            if ($pr !== false) { ?>
                       <input type="checkbox" name="permission[]" value="Profile" checked> Profile             <br>
                       <?php } else { ?>
                       <input type="checkbox" name="permission[]" value="Profile"> Profile             <br>
                       <?php } ?>

                       <?php
                            $sb = strpos($perm, "Start Board");
                            if ($sb !== false) { ?>
                       <input type="checkbox" name="permission[]" value="Start Board" checked> Start Board     <br>
                       <?php } else { ?>
                       <input type="checkbox" name="permission[]" value="Start Board" > Start Board     <br>
                       <?php } ?>
                            <div class="form-group internal" align="center" style="padding:10px;">
                                <td style="background-color:#B2B2B2;  border-radius:5px;"><input type="checkbox"
                                                                                                 onClick="toggle(this)">Select
                                    All
                                </td>
                            </div>


                            <table id="perm" class="table table-bordered"
                                   style="border-radius:8px; border:1px solid #777;box-shadow: 1px 1px 1px 2px  rgba(150,150,150, 0.4);">
                                <tr style="background-color:#9F5F9F;color:white;box-shadow: 1px 1px 1px 2px  rgba(150,150,150, 0.6);">
                                    <td>
                                        <?php
                                        $lb = strpos($perm, "Master");
                                        if ($lb !== false) { ?>
                                            <input id="master" onclick="checkMaster(this) " type="checkbox"
                                                   name="permission[]" value="Master" checked> Master
                                        <?php } else { ?>
                                            <input id="master" onclick="checkMaster(this) " type="checkbox"
                                                   name="permission[]" value="Master"> Master
                                        <?php } ?>

                                    </td>
                                    <td>
                                        <?php
                                        $lb = strpos($perm, "Map");
                                        if ($lb !== false) { ?>
                                            <input type="checkbox" name="permission[]" value="Map" checked> Map &nbsp;
                                        <?php } else { ?>
                                            <input type="checkbox" name="permission[]" value="Map"> Map   &nbsp;
                                        <?php } ?>

                                    </td>
                                    <td>
                                        <?php
                                        $lb = strpos($perm, "Gift Card");
                                        if ($lb !== false) { ?>
                                            <input type="checkbox" name="permission[]" value="Gift Card"
                                                   checked> Gift Card
                                        <?php } else { ?>
                                            <input type="checkbox" name="permission[]" value="Gift Card"> Gift Card
                                        <?php } ?>

                                    </td>
                                    <td>
                                        <?php
                                        $lb = strpos($perm, "Colleges");
                                        if ($lb !== false) { ?>
                                            <input type="checkbox" name="permission[]" value="Colleges"
                                                   checked> colleges
                                        <?php } else { ?>
                                            <input type="checkbox" name="permission[]" value="Colleges">Organisation
                                        <?php } ?>

                                    </td>
                                    <td>
                                        <?php
                                        $lb = strpos($perm, "Sponsor");
                                        if ($lb !== false) { ?>
                                            <input id="sponsor" onclick="checkSponsor(this)" type="checkbox"
                                                   name="permission[]" value="Sponsor" checked> Sponsor
                                        <?php } else { ?>
                                            <input id="sponsor" onclick="checkSponsor(this)" type="checkbox"
                                                   name="permission[]" value="Sponsor"> Sponsor
                                        <?php } ?>

                                    </td>
                                    <td>
                                        <?php
                                        $lb = strpos($perm, "Social Footprint");
                                        if ($lb !== false) { ?>
                                            <input type="checkbox" name="permission[]" value="Social Footprint"
                                                   checked> Social Footprint
                                        <?php } else { ?>
                                            <input type="checkbox" name="permission[]"
                                                   value="Social Footprint"> Social Footprint
                                        <?php } ?>

                                    </td>
                                    <td>
                                        <?php
                                        $lb = strpos($perm, "Log");
                                        if ($lb !== false) { ?>
                                            <input type="checkbox" name="permission[]" value="Log" checked> Log
                                        <?php } else { ?>
                                            <input type="checkbox" name="permission[]" value="Log"> Log
                                        <?php } ?>

                                    </td>
                                    <td>
                                        <?php
                                        $lb = strpos($perm, "Leader Board");
                                        if ($lb !== false) { ?>
                                            <input type="checkbox" name="permission[]" value="Leader Board"
                                                   checked> Leader Board
                                        <?php } else { ?>
                                            <input type="checkbox" name="permission[]"
                                                   value="Leader Board"> Leader Board
                                        <?php } ?>


                                    </td>
                                    <td>
                                        <?php
                                        $lb = strpos($perm, "Error");
                                        if ($lb !== false) { ?>
                                            <input type="checkbox" name="permission[]" value="Error"
                                                   checked> Error Log Report
                                        <?php } else { ?>
                                            <input type="checkbox" name="permission[]" value="Error"> Error Log Report
                                        <?php } ?>

                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <ul style="list-style-type:none;margin-left: -41px;">
                                            <li>
                                                <?php
                                                $lb = strpos($perm, "School");
                                                if ($lb !== false) { ?>
                                                    <input class="subMaster" type="checkbox" name="permission[]"
                                                           value="School" checked> School/Sponsor
                                                <?php } else { ?>
                                                    <input class="subMaster" type="checkbox" name="permission[]"
                                                           value="School">Organisation /Sponsor
                                                <?php } ?>
                                            </li>
                                            <li>
                                                <?php
                                                $lb = strpos($perm, "Sales Person");
                                                if ($lb !== false) { ?>
                                                    <input class="subMaster" type="checkbox" name="permission[]"
                                                           value="Sales Person" checked> Sales Person
                                                <?php } else { ?>
                                                    <input class="subMaster" type="checkbox" name="permission[]"
                                                           value="Sales Person"> Sales Person
                                                <?php } ?>
                                            </li>
                                            <li>
                                                <?php
                                                $lb = strpos($perm, "Blue Points");
                                                if ($lb !== false) { ?>
                                                    <input class="subMaster" type="checkbox" name="permission[]"
                                                           value="Blue Points" checked> Blue Points
                                                <?php } else { ?>
                                                    <input class="subMaster" type="checkbox" name="permission[]"
                                                           value="Blue Points"> Blue Points
                                                <?php } ?>
                                            </li>
                                            <li>
                                                <?php
                                                $lb = strpos($perm, "Activity");
                                                if ($lb !== false) { ?>
                                                    <input class="subMaster" type="checkbox" name="permission[]"
                                                           value="Activity" checked> Activity
                                                <?php } else { ?>
                                                    <input class="subMaster" type="checkbox" name="permission[]"
                                                           value="Activity"> Activity
                                                <?php } ?>
                                            </li>
                                            <li>
                                                <?php
                                                $lb = strpos($perm, "Add Staff");
                                                if ($lb !== false) { ?>
                                                    <input class="subMaster" type="checkbox" name="permission[]"
                                                           value="Add Staff" checked> Add Staff
                                                <?php } else { ?>
                                                    <input class="subMaster" type="checkbox" name="permission[]"
                                                           value="Add Staff"> Add Staff
                                                <?php } ?>
                                            </li>
                                            <li>
                                                <?php
                                                $lb = strpos($perm, "Type");
                                                if ($lb !== false) { ?>
                                                    <input class="subMaster" type="checkbox" name="permission[]"
                                                           value="Type" checked> Activity Type
                                                <?php } else { ?>
                                                    <input class="subMaster" type="checkbox" name="permission[]"
                                                           value="Type"> Activity Type
                                                <?php } ?>
                                            </li>
                                            <li>
                                                <?php
                                                $lb = strpos($perm, "Soft Rewards");
                                                if ($lb !== false) { ?>
                                                    <input class="subMaster" type="checkbox" name="permission[]"
                                                           value="Soft Rewards" checked> Soft Rewards
                                                <?php } else { ?>
                                                    <input class="subMaster" type="checkbox" name="permission[]"
                                                           value="Soft Rewards"> Soft Rewards
                                                <?php } ?>
                                            </li>
                                            <li>
                                                <?php
                                                $lb = strpos($perm, "ThanQ List");
                                                if ($lb !== false) { ?>
                                                    <input class="subMaster" type="checkbox" name="permission[]"
                                                           value="ThanQ List" checked> ThanQ List
                                                <?php } else { ?>
                                                    <input class="subMaster" type="checkbox" name="permission[]"
                                                           value="ThanQ List"> ThanQ List
                                                <?php } ?>
                                            </li>
                                            <li>
                                                <?php
                                                $lb = strpos($perm, "Categories & Currencies");
                                                if ($lb !== false) { ?>
                                                    <input class="subMaster" type="checkbox" name="permission[]"
                                                           value="Categories & Currencies"
                                                           checked> Categories & Currencies
                                                <?php } else { ?>
                                                    <input class="subMaster" type="checkbox" name="permission[]"
                                                           value="Categories & Currencies"> Categories & Currencies
                                                <?php } ?>
                                            </li>
                                            <li>
                                                <?php
                                                $lb = strpos($perm, "Rule Engine");
                                                if ($lb !== false) { ?>
                                                    <input class="subMaster" type="checkbox" name="permission[]"
                                                           value="Rule Engine" checked> Rule Engine
                                                <?php } else { ?>
                                                    <input class="subMaster" type="checkbox" name="permission[]"
                                                           value="Rule Engine"> Rule Engine
                                                <?php } ?>
                                            </li>
                                        </ul>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td>All India College List</td>
                                    <td>
                                        <ul style="list-style-type:none;margin-left: -41px;">
                                            <li>
                                                <?php
                                                $lb = strpos($perm, "Registered");
                                                if ($lb !== false) { ?>
                                                    <input class="subSponsor" type="checkbox" name="permission[]"
                                                           value="Registered" checked> Registered Sponsers
                                                <?php } else { ?>
                                                    <input class="subSponsor" type="checkbox" name="permission[]"
                                                           value="Registered"> Registered Sponsers
                                                <?php } ?>
                                            </li>

                       <li>
                                                <?php
                                                $lb = strpos($perm, "SponsorProfileSummery");
                                                if ($lb !== false) { ?>
                                                    <input class="subSponsor" type="checkbox" name="permission[]"
                                                           value="SponsorProfileSummery" checked> Sponsor Profile Summery
                                                <?php } else { ?>
                                                    <input class="subSponsor" type="checkbox" name="permission[]"
                                                           value="SponsorProfileSummery"> Sponsor Profile Summery
                                                <?php } ?>
                                            </li>
                                            <li>
                                                <?php
                                                $lb = strpos($perm, "Suggested");
                                                if ($lb !== false) { ?>
                                                    <input class="subSponsor" type="checkbox" name="permission[]"
                                                           value="Suggested" checked> Suggested
                                                <?php } else { ?>
                                                    <input class="subSponsor" type="checkbox" name="permission[]"
                                                           value="Suggested"> Suggested
                                                <?php } ?>
                                            </li>
                                            <li>
                                                <?php
                                                $lb = strpos($perm, "Location");
                                                if ($lb !== false) { ?>
                                                    <input class="subSponsor" type="checkbox" name="permission[]"
                                                           value="Location" checked> Location & Coupons
                                                <?php } else { ?>
                                                    <input class="subSponsor" type="checkbox" name="permission[]"
                                                           value="Location"> Location & Coupons
                                                <?php } ?>
                                            </li>
                                            <li>
                                                <?php
                                                $lb = strpos($perm, "Statistics");
                                                if ($lb !== false) { ?>
                                                    <input class="subSponsor" type="checkbox" name="permission[]"
                                                           value="Statistics" checked> Statistics
                                                <?php } else { ?>
                                                    <input class="subSponsor" type="checkbox" name="permission[]"
                                                           value="Statistics"> Statistics
                                                <?php } ?>
                                            </li>
                                        </ul>
                                    </td>
                                    <td></td>
                                    <td>Soft Rewards</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </table>

                        </fieldset>

                    </div>-->

                    <div class='form-group row'>
                        <div class='col-md-2 col-md-offset-4'>
                            <input class='btn-lg btn-primary' type='submit' value="Update" name="update"
                                   onClick="return valid()" style="padding:5px;"/>
                        </div>


                        <div class='col-md-1'>

                            <a href="group_Admin_Staff_setup.php">
                                <button class='btn-lg btn-danger' type='submit' style="padding:5px;">Cancel</button>
                            </a>

                        </div>


        </form>
    </div>
    <div class='row' align="center" style="color:#008000"><?php echo $report; ?></div>
</div>
</div>
</body>
<?php } ?>