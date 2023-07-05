<?php
//Below code updated by Rutuja Jori for merging Admin Staff setup page & Edit Admin Staff page into one on 29/11/2019 for SMC-4196.
$report=""; 

include("scadmin_header.php");

$school_id = $_SESSION['school_id'];

$school_type = strtolower($_GET['school_type']);
//modified $entity  for displaying menu access for SMC-5011
$entity = ($school_type=='school') ? 'School Admin' : 'HR Admin';
$staff_id = $_GET['staff_d'];

$currentdate = date('Y-m-d H:i:s');

$sql1 = mysql_query("select id,stf_name from tbl_school_adminstaff where id='$staff_id'");
$result = mysql_fetch_assoc($sql1);
$stf_name = $result['stf_name'];
if(isset($_GET['staff_d'])==''){

    if(isset($_POST['submit']))
    {
    
       $email = $_POST['id_email'];
         

        $row=mysql_query("select * from tbl_school_adminstaff where school_id='$school_id' AND email='$email'");

        if(mysql_num_rows($row)<=0)
      {
        $id_first_name = $_POST['id_first_name'];
        $id_last_name = $_POST['id_last_name'];
        $name=$id_first_name." ".$id_last_name;
        
        $education =$_POST['id_education'];
    //Experience and month added by Rutuja on 06/01/2019 for SMC-4389 and added validations for all fields and also added proper alignment
     $exp = $_POST['experience'];
     $experience_month = $_POST['experience_month'];
                          
      $experience= $exp . "." . $experience_month;
        $designation=$_POST['Designation'];
        
        $date = $_POST['dob'];
        
        //$gender = $_POST['id_gender'];
        //retrive school_id and name school_admin
        //$arrs=$smartcookie->retrive_scadmin_profile();
        $fields=array("id"=>$id);
           $table="tbl_school_admin";
           
           $smartcookie=new smartcookie();
           
            $results=$smartcookie->retrive_individual($table,$fields);
            $arrs=mysql_fetch_array($results);
            $school_id=$_SESSION['school_id'];
            $sch_sql = mysql_query("SELECT school_name FROM tbl_school_admin WHERE school_id='".$school_id."'");
            $sch_res = mysql_fetch_array($sch_sql);
            $school_name=$sch_res['school_name'];
        //$class = $_POST['class1'];
        //$subject = $_POST['subject'];
        $email = $_POST['id_email'];
        $phone = $_POST['id_phone'];
        $gender=$_POST['gender'];
        $address = $_POST['address'];
        $country = mysql_escape_string($_POST['country']);
        $state = mysql_escape_string($_POST['state']);
        $city = $_POST['city'];
        $dates = date('m/d/Y');
        
        $password = $id_first_name."123";
        //$permision=implode(',',$_POST['permission']);
    
         list($month,$day,$year) = explode("/",$date);
        $year_diff  = date("Y") - $year;
        $month_diff = date("m") - $month;
        $day_diff   = date("d") - $day;
        if ($day_diff < 0 || $month_diff < 0) $year_diff--;
        $age= $year_diff;
    
    $currentdate = date('Y-m-d H:i:s');
    
//------------------------------insert in tbl_school_adminstaff table----------
      
      $sqls= "INSERT INTO tbl_school_adminstaff ( stf_name, school_id, exprience, designation, addd, country, city, statue, dob, age, gender, email, phone, pass,  qualification, currentDate) VALUES ( '$name', '$school_id', '$experience', '$designation', '$address', '$country', '$city', '$state', '$date', '$age', '$gender', '$email', '$phone', '$password', '$education', '$currentdate')";
        
    $count = mysql_query($sqls) or die(mysql_error()); 
    
//-------------------------------End------------------------------------------------    


//------------------------------Fetch Data form tbl_school_adminstaff table----------
    
    $sql1 = mysql_query("select id,stf_name from tbl_school_adminstaff where email='$email' or phone='$phone'");
    $result=mysql_fetch_array($sql1);
    $staf_id=$result['id'];
    $staf_name=$result['stf_name'];
    
//------------------------------End--------------------------------------------------




//------------------------------Insert in permision in tbl_permission table----------
     /*$sql="INSERT INTO `tbl_permission` (`permission_id`, `school_id`, `s_a_st_id`, `cookie_admin_staff_id`,`school_staff_name`, `cookie_staff_name`, `permission`, `current_date`) VALUES (NULL, '$school_id', '$staf_id', NULL, '$staf_name', NULL, '$permision', '$currentdate')";
     $rs=mysql_query($sql) or die(mysql_error());*/
//------------------------------End--------------------------------------------------

        if($count>=1)
        {   
    $to=$email;
    $from="smartcookiesprogramme@gmail.com";
    $subject="Succesful Registration";
    $message="Hello ".$id_first_name." ".$id_last_name."\r\n\r\n".
         "Thanks for registration with Smart Cookie as teacher\r\n".
          "your Username is: "  .$email.  "\n\n".
          "your password is: ".$password."\n\n".
          "your School ID is: ".$school_id."\n\n".
          "Regards,\r\n".
          "Smart Cookie Admin";
          
     mail($to, $subject, $message); 
        echo ("<script LANGUAGE='JavaScript'>
                    window.alert('Successfully added');
                    window.location.href='schoolAdminStaff_list.php';
                    </script>");
        //$report="Successfully added"; 
        //header("Location:Admin_Staff_setup.php?report=".$report);
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
<script src='js/bootstrap-datepicker.min.js' type='text/javascript'></script>
<script src="js/city_state.js" type="text/javascript"></script>
<link href='css/datepicker.min.css' rel='stylesheet' type='text/css'>
<script>
$(document).ready(function() {
    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd'
    });
});


 var reg = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;  
      function PhoneValidation(phoneNumber)
      {  
        var OK = reg.exec(phoneNumber.value);  
        if (!OK)  
         document.getElementById('errorphone').innerHTML='Please Enter Valid Phone Number';
         return false;
       
      }
function valid()
    {
    
    /*          
        
        var dob=document.getElementById("id_checkin").value;

        var MyDate = new Date();
            var MyDateString;
            MyDate.setDate(MyDate.getDate());
            MyDateString = MyDate.getFullYear()+'-'+('0' + (MyDate.getMonth()+1)).slice(-2)+'-'+('0' + MyDate.getDate()).slice(-2);
                if(dob==MyDateString)
                {
                    document.getElementById('errorname').innerHTML='Please Enter valid date of birth';
                    return false;
                }
                
        */
        var first_name=document.getElementById("id_first_name").value;
        
        var last_name=document.getElementById("id_last_name").value;
        
        if(first_name.trim()==null||first_name.trim()==""  )
            {
               
               alert('Please Enter first Name');
                
                return false;
            }
            else
            {
                document.getElementById('errorname').innerHTML='';
            }

        if( last_name.trim()==null|| last_name.trim()=="" )
        {

            alert('Please Enter last Name');

            return false;
        }
        
        
        regx1=/^[A-z ]+$/;
                //validation for name
                if(!regx1.test(first_name) || !regx1.test(last_name))
                {
               alert('Please Enter valid Name');
                    return false;
                }
                else
            {
                document.getElementById('errorname').innerHTML='';
            }

                var education=document.getElementById("id_service").value; 
        if(education.trim()==null||education.trim()=="")
            {
               
                alert('Please enter education');
                
                return false;
            }
            
       var experience = document.getElementById("experience").value;
                var experience_month = document.getElementById("experience_month").value;
        
        
                 if(experience.trim()=="" && experience_month=='')
            {
                document.getElementById('errorname').innerHTML='';
                alert('Please enter experience');
                
                return false;
            }
      else if(experience < 0 || experience % 1 != 0){//if no is negative or decimal 

                        alert("Please enter valid Experience");
                        return false;

                    }
      
      
       if(experience_month=='')
            {
                document.getElementById('errorname').innerHTML='';
                alert('Please select month');
                
                return false;
            }
                
                
             
            
            regx1=/^[A-z ]+$/;
            var Designation=document.getElementById("Designation").value;
                //validation for name
                if(Designation.trim()=="" || Designation.trim()==null)
                {
                    alert('Please enter designation');
                
                return false;
                }
                if(!regx1.test(Designation))
                {
               alert('Please Enter valid Designation');
                    return false;
                }
                else
                {
                    document.getElementById('errordesignation').innerHTML='';
                }
                     var id_checkin=document.getElementById("id_checkin").value;
                         var myDate = new Date(id_checkin);
                var today = new Date();
                if(id_checkin=="")
            {
    
               
                alert('Please Enter Date of Birth');
                
                return false;
            }
            if(myDate.getFullYear()>=today.getFullYear())
                {
                        if(myDate.getMonth()>=today.getMonth())
                        {
                            if(myDate.getDate()>=today.getDate())
                            {
                                
                           alert("please enter valid birth date");
                        return false;
                            }   
                            
                        }   
                }
                  else
                      {
                           document.getElementById("errordob").innerHTML ="";
                          
                         }
            var gender1=document.getElementById("gender1").checked;
        
            var gender2=document.getElementById("gender2").checked;
            
        if(gender1==false && gender2==false)
            {
                alert('Please Select gender');
                return false;
            }
            else{
                document.getElementById('errorgender').innerHTML='';
                
            }
/*
        var subject=document.getElementById("subject").value;
        if(subject==null||subject=="")
            {
               
                document.getElementById('errorsubject').innerHTML='Please Enter Subject';
                
                return false;
            }
            else
            { 
                document.getElementById('errorsubject').innerHTML='';
            }
    */
        var id_email=document.getElementById("id_email").value;
        
        if(id_email==null||id_email=="")
            {
               
              alert('Please Enter email');
                
                return false;
            }
            
              
                var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;  
              if(!id_email.match(mailformat))  
                {  
               alert('Please Enter valid email ID');

                return false;  
                }
                {  
                document.getElementById('erroremail').innerHTML='';
                } 
//
var id_phone=document.getElementById("id_phone").value;
        
        if(id_phone==null||id_phone=="")
            {
               
               alert('Please Enter Phone Number');
                
                return false;
            }
            
              
                var mailformat = /^[6789]\d{9}$/;  
              if(!id_phone.match(mailformat))  
                {  
                alert('Please Enter valid Phone Number');

                return false;  
                }
                {  
                document.getElementById('errorphone').innerHTML='';
                }                   

        var address=document.getElementById("address").value;
        if(address.trim()==null||address.trim()=="")
            {
               
               alert('Please Enter address');
                
                return false;
            }
            else
            { 
                document.getElementById('erroraddress').innerHTML='';
            }
                
        var country=document.getElementById("country").value;
        
        if(country=="-1")
            {
               
               alert('Please Enter country');
                
                return false;
            }
            else
            {
                document.getElementById('errorcountry').innerHTML='';
            }
            
        var state=document.getElementById("state").value;
        if(state==null||state=="")
            {  
                alert('Please Enter state');   
                return false;
            }
            else
            {
                document.getElementById('errorstate').innerHTML='';
            }
        var city=document.getElementById("id_city").value;
        
        if(city==null||city=="")
            {
               
               alert('Please Enter city');
                
                return false;
            }
            else
            {
                document.getElementById('errorcity').innerHTML='';
            }
            
                                
              
        
    }
</script>
</head>
<body >
  <div class='container' >
    <div class='panel panel-primary dialog-panel' style="background-color:#FFFFFF;background-image=""">
   <div style="color:green;font-size:15px;font-weight:bold;margin-top:10px;"> <?php if(isset($_GET['report'])){ echo $_GET['report']; };?></div>
      <div class='panel-heading'>
         
            <h3 align="center"><?php echo $dynamic_school;?> Admin Staff Setup</h3>
        
        <!--Removed Add excel sheet option for SMC-4443 by Sayali Balkawade on 18/01/2020 -->
           <!-- <h5 align="center"><a href="Add_teacherSheet.php" >Add Excel Sheet</a></h5>
          </div>-->
      <div class='panel-body'>
        <form class='form-horizontal' role='form' method="post">
        
        
        <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='id_title' style="text-align:left;">Staff Name<b style="color:red";>*</b></label>
            <div class='col-md-5'>
            
              <div class='col-md-7 '>
                <div class='form-group internal'>
                  <input class='form-control' id='id_first_name' name="id_first_name" placeholder='First Name' type='text'>
                </div>
              </div>
               </div>
                </div>
              
              <div class='form-group'>
              
              <label class='control-label col-md-2 col-md-offset-2' for='id_title' style="text-align:left;">Last Name<b style="color:red";>*</b></label>
            <div class='col-md-5'>
              <div class='col-md-7'>
                <div class='form-group internal'>
                  <input class='form-control' id='id_last_name' name="id_last_name" placeholder='Last Name' type='text'>
                </div>
              </div>
              <div class='col-md-4 indent-small' id="errorname" style="color:#FF0000">
                
              </div>
            </div>
              </div>
       
        

                 
           <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='id_service' style="text-align:left;">Education<b style="color:red";>*</b></label>
            <div class='col-md-3'>
              <select class='multiselect  form-control' id='id_service' name="id_education" >
               <option value=''>Select</option>
                <option value='BA'>BA</option>
                <option value='BCom'>BCom</option>
                <option value='BSc'>BSc</option>
                <option value='MA'>MA</option>
                <option value='MCom'>MCom</option>
                <option value='MSc'>MSc</option>
                <option value='B.ED'>B.ED</option>
                <option value='D.ED'>D.ED</option>
                <option value='Other'>Other</option>
              </select>
            </div>
             
                        </div>
            
           
                 <div class='form-group'>
                        <label class='control-label col-md-2 col-md-offset-2' style="padding-right: 92px;" >Experience<b style="color:red";>*</b></label>
                        <div class='col-md-6'>
                            <div class='form-group'>
                            
                                <div class='col-md-6'>
                                    <input class='form-control col-md-8' id='experience' name='experience' placeholder='Experience in years' type='text'>
                                    </div>
                                     <div class='col-md-6'>
                                     <select class='multiselect  form-control' id='experience_month' name="experience_month" required>
                                    <option value=''>Select Month</option>
                                    <option value='0'>0</option>
                                    <option value='1'>1</option>
                                    <option value='2'>2</option>
                                    <option value='3'>3</option>
                                    <option value='4'>4</option>
                                    <option value='5'>5</option>
                                    <option value='6'>6</option>
                                    <option value='7'>7</option>
                                    <option value='8'>8</option>
                                    <option value='9'>9</option>
                                    <option value='10'>10</option>
                                      <option value='11'>11</option>
                                </select>
                                </div>
                                <div class='col-md-3 indent-small'  style="color:#FF0000">
                                </div>
                            </div>
                        </div>  
                    </div> 
                      
          
           <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='id_title' style="text-align:left;">Designation<b style="color:red";>*</b></label>
            
             
                <div class='form-group '>
    <input class='form-control col-md-8' style="width:21.7%;margin-left:15px;" id='Designation' name="Designation" placeholder='Designation' type='text'>
                </div>
             </div>
             <div class="row" ><div class="col-md-3 col-md-offset-2" id="errordesignation" style="color:#F00;"></div></div>
          
         
            <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='id_checkin' style="text-align:left;">Date Of Birth<b style="color:red";>*</b></label>
            <div class='col-md-8'>
              <div class='col-md-5'>
                <div class='form-group internal input-group'>
              
               <input class='form-control datepicker' id="id_checkin" name="dob" class="form-control" style="width:140%; margin-left:1px;">
                
                </div>
                
                <div class='col-md-15' id="errordob" style="color:#FF0000"></div>
              </div>
               
            </div>
          </div>
          
          
          <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='id_pets' style="text-align:left;">Gender<b style="color:red";>*</b></label>
           <div class='col-md-2' style="font-weight: 600;
color: #777;margin-left:8px;">
           <input type="radio" name="gender" id="gender1" value="Male"> 
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
          
       
         <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='id_email' style="text-align:left;" >Contact<b style="color:red";>*</b></label>
            <div class='col-md-6'>
              <div class='form-group'>
                <div class='col-md-6'>
                  <input class='form-control' id='id_email' name="id_email" placeholder='E-mail' type='email'>
                </div>
                <div class='col-md-3 indent-small' id="erroremail" style="color:#FF0000">
                
              </div>
              </div>
              <div class='form-group '>
                <div class='col-md-6'>
                  <input class='form-control' id='id_phone' name="id_phone" placeholder='Mobile No' type='text'> <!--onChange="PhoneValidation(this);" -->
                  
                </div>
                <div class='col-md-3 indent-small' id="errorphone" style="color:#FF0000">
                
              </div>
              </div>
            </div>
          </div>
         
        
        
         
           
          <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='id_comments' style="text-align:left;">Address<b style="color:red";>*</b></label>
            <div class='col-md-3'>
              <textarea class='form-control' id='address' name="address" placeholder='Address' rows='3'></textarea>
            </div>
            <div class='col-md-2 indent-small' id="erroraddress" style="color:#FF0000"></div>
          </div>
         <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' style="text-align:left;" >Country<b style="color:red";>*</b></label>
            <div class='col-md-3'>
                  <select id="country" name="country" class='form-control'></select>
                </div>
            
             
            <div class='col-md-3 indent-small' id="errorcountry" style="color:#FF0000"></div>
           </div>
        <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' style="text-align:left;">State<b style="color:red";>*</b></label>
            <div class='col-md-3'>
                  <select name="state" id="state" class='form-control'></select>
                </div>
            
              <div class='col-md-3 indent-small' id="errorstate" style="color:#FF0000"></div>

          </div>
          <script language="javascript">
            populateCountries("country", "state");
            populateCountries("country2");
        </script>
         <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='id_accomodation' style="text-align:left;" >City<b style="color:red";>*</b></label>
            <div class='col-md-3'>
              <input type="text" class='form-control' id='id_city' name="city" placeholder="City">
            </div>
            
             <div class='col-md-3 indent-small' id="errorcity" style="color:#FF0000"></div>
          </div>
       <div class='form-group'>
       <div class='col-md-1'></div>
        <div class='col-md-12'>
        
            
  
  
  </div>
          
           </div>
     
         <div class='form-group row'>
           <div class='col-md-2 col-md-offset-4' >
                 <input class='btn-lg btn-primary' type='submit' value="Submit" name="submit" onClick="return valid()" style="padding:5px;"/>
                </div>
                <div class='col-md-1'>
                    
      <a href="schoolAdminStaff_list.php"><input type="button" class='btn-lg btn-danger' value="Cancel" style="padding:5px;"/></a>
                    
                  </div>
          
          
        </form>
      </div>
      
      <div class='row' align="center"  style="color:#063"><?php echo $report;?></div>
      
    </div>
  </div>
</body>
<?php }else{

function changeDateFormat1($date)
{
    $str= explode("/",$date);
    $date = $str[2]."/".$str[0]."/".$str[1];
    return $date;
}
$report="";
$server_name = $_SERVER['SERVER_NAME'];

    function changeDateFormat($date)
                            {
                                $str= explode("-",$date);
                                $date = $str[1]."/".$str[2]."/".$str[0];
                                return $date;
                            }


//include("scadmin_header.php");
   $staff_id=$_GET['staff_d'];


   if(isset($_GET['staff_d']))
  {
                              $id=$_GET['staff_d'];
                              
                              $sql=mysql_query("select * from tbl_school_adminstaff where id='".$id."' AND school_id='".$school_id."'");
                              while($row=mysql_fetch_array($sql))
                               {
                                 $s_st_id=$row['id'];
                                 $school_id= $row['school_id'];
                                 $names=$row['stf_name'];
                                 $a=explode(" ",$names);
                                 $a[0];$a[1];
                                 $edu=$row['qualification'];
                                 $des=$row['designation'];
                                 $exp = $row['exprience'];
                                 $exp1=explode(".", $exp);
                                 $year=$exp1['0'];
                                 $month=$exp1['1'];
                                 $GetDate=$row['dob'];
                                 $GetDate = changeDateFormat($GetDate);
                                 
                                 $Getgender=$row['gender'];
                                 $mailid=$row['email'];
                                 $phone=$row['phone'];
                                 $add=$row['addd'];
                                 $getcounty=$row['country'];
                                 $getstatu=$row['statue'];
                                 $city=$row['city'];

                                }
                              }


$errorreport="";

    if(isset($_POST['Update']))
    { 

        // $id_first_name = $_POST['id_first_name'];
        // $id_last_name = $_POST['id_last_name'];
        // $name=$id_first_name." ".$id_last_name;
        // $education =$_POST['id_education'];
        // $experience = $_POST['experience'];
        // $experience_month = $_POST['experience_month'];
        // $exp_mon=$experience . "." . $experience_month;
        // $designation=$_POST['Designation'];
        // $date = $_POST['dob'];
        // $date = changeDateFormat1($date);
        // $email = $_POST['id_email'];
        // $phone = $_POST['id_phone'];
        // $gender=$_POST['gender'];
        // $address = $_POST['address'];
        // $city = $_POST['city'];
      
        // if($name!="" && $address!="" && $email!="" && $city!="")
        // {
        //     if($_POST['country']==-1)
        //     {
        //     $country=$_POST['country1'];
        //     }
        //     else
        //     {
        //     $country=$_POST['country'];
        //     }
        //     if(isset($_POST['state']) && $_POST['state']!='')
        //     {
        //     $state=$_POST['state'];
        //     }
        //     else
        //     {
        //     $state=$_POST['state1'];
        //     }
       
        // $dates = date('m/d/Y');
        // $password = $id_first_name."123";
            
        // list($month,$day,$year) = explode("/",$date);
        // $year_diff  = date("Y") - $year;
        // $month_diff = date("m") - $month;
        // $day_diff   = date("d") - $day;
        // if ($day_diff < 0 || $month_diff < 0) $year_diff--;
        // $age= $year_diff;
        // $currentdate = date('Y-m-d H:i:s');
        $permision=@implode(',',$_POST['permission']);
    
//------------------------------insert in tbl_school_adminstaff table----------


//       $sqls="update tbl_school_adminstaff set stf_name='$name',exprience='$exp_mon',designation='$designation',addd='$address',country='$country',city='$city', statue='$state',dob='$date',age='$age',gender='$gender',email='$email',phone='$phone',pass='$password',qualification='$education'where id=".$staff_id."";
//       if($sqls)
//        {
           
//          echo "<script>
// window.location.href='http://$server_name/core/schoolAdminStaff_list.php';
// alert('Updated succesfully...');
// </script>";
//        }
//     $count = mysql_query($sqls) or die(mysql_error());

//-------------------------------End------------------------------------------------

//------------------------------Insert in permision in tbl_permission table----------

     $r=mysql_query("select * from tbl_permission where s_a_st_id='".$s_st_id."' AND school_id='".$school_id."'");

       if(mysql_num_rows($r)==0)
       {
          $sql="INSERT INTO `tbl_permission` (`school_id`, `s_a_st_id`, `cookie_admin_staff_id`,`school_staff_name`, `cookie_staff_name`, `permission`, `current_date`) VALUES ('$school_id','$staff_id',NULL,'$staf_name',NULL, '$permision', '$currentdate')";
          /* $sql="insert into tbl_permission(permission) values ('$permision') where s_a_st_id=".$staff_id."";           */
           $rs=mysql_query($sql) or die(mysql_error());
           echo "<script>
          alert('Access added successfully');
          window.location.href = 'schoolAdminStaff_list.php';
          </script>";
       }
       else
       {
          $sql="update tbl_permission set permission='".$permision."' where s_a_st_id='".$staff_id."' AND school_id='".$school_id."'";
           $rs=mysql_query($sql) or die(mysql_error());
           echo "<script>
          alert('Access edited successfully');
          window.location.href = 'schoolAdminStaff_list.php';
          </script>";
       }

//------------------------------End--------------------------------------------------

/*if($count>=1)
        {   
    $to=$email;
    $from="smartcookiesprogramme@gmail.com";
    $subject="Succesful Updated Your Profile";
    $message="Hello ".$id_first_name." ".$id_last_name."\r\n\r\n".
         "Thanks for registration with Smart Cookie as teacher\r\n".
          "your Username is: "  .$email.  "\n\n".
          "your password is: ".$password."\n\n".
          "your School ID is: ".$school_id."\n\n".
          "Regards,\r\n".
          "Smart Cookie Admin";
          
       mail($to, $subject, $message);
        
        $report="successfully updated"; 
        header("Location:schoolAdminStaff_list.php?report=".$report);
        }*/
        //alert( 'Upated Succesfully');
        
        
//    }
// else
// {
    
//     $errorreport="Please enter all details";
    
// }

//alert( 'Upated Succesfully');
        }
        
?>

<!DOCTYPE html>
<head>
 
  <script language="JavaScript">
function toggle(source) {
  checkboxes = document.getElementsByName('permission[]');
  for(var i=0, n=checkboxes.length;i<n;i++) {
    checkboxes[i].checked = source.checked;
  }
}
</script>
<!-- <SCRIPT language="javascript">
    $(function () {
        // add multiple select / deselect functionality
        $("#master").click(function () {
            $('.name').attr('checked', this.checked);
        });
        // if all checkbox are selected, then check the select all checkbox
        // and viceversa
        $(".name").click(function () {
 
           if($(".name:checked").length!=0) {
                  $("#master").attr("checked", "checked");
            }
            else
            {
             $("#master").removeAttr("checked");
            }

        });
    });
</SCRIPT> -->

<!-----------------------------POINT----------------------------------------->
<!-- <SCRIPT language="javascript">
    $(function () {
        // add multiple select / deselect functionality
        $("#point").click(function () {
            $('.subpoint').attr('checked', this.checked);
        });
        // if all checkbox are selected, then check the select all checkbox
        // and viceversa
        $(".subpoint").click(function () {
 
           if($(".subpoint:checked").length!=0) {
                  $("#point").attr("checked", "checked");
            }
            else
            {
             $("#point").removeAttr("checked");
            }

        });
    });
</SCRIPT> -->
<!--------------------------------LOG-------------------------------------------->

<!-- <SCRIPT language="javascript">
    $(function () {
        // add multiple select / deselect functionality
        $("#log").click(function () {
            $('.sublog').attr('checked', this.checked);
        });
        // if all checkbox are selected, then check the select all checkbox
        // and viceversa
        $(".sublog").click(function () {
 
           if($(".sublog:checked").length!=0) {
                  $("#log").attr("checked", "checked");
            }
            else
            {
             $("#log").removeAttr("checked");
            }

        });
    });
</SCRIPT> -->

<!-------------------------------------purches coupone------------>

<!-- <SCRIPT language="javascript">
    $(function () {
        // add multiple select / deselect functionality
        $("#purchesC").click(function () {
            $('.subpurches').attr('checked', this.checked);
        });
        // if all checkbox are selected, then check the select all checkbox
        // and viceversa
        $(".subpurches").click(function () {

           if($(".subpurches:checked").length!=0) {
                  $("#purchesC").attr("checked", "checked");
            }
            else
            {
             $("#purchesC").removeAttr("checked");
            }

        });
    });
</SCRIPT> -->

<!-- <SCRIPT language="javascript">
    $(function () {
        // add multiple select / deselect functionality
        $("#report").click(function () {
            $('.subreport').attr('checked', this.checked);
        });
        // if all checkbox are selected, then check the select all checkbox
        // and viceversa
        $(".subreport").click(function () {

           if($(".subreport:checked").length!=0) {
                  $("#report").attr("checked", "checked");
            }
            else
            {
             $("#report").removeAttr("checked");
            }

        });
    });
</SCRIPT> -->


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




#perm td ul li{
    
    padding:2px;
    border:1px solid #ccc;
    
    border-radius:0px;
    box-shadow: 0px 0px 0px 1px rgba(150,150,100,0.2);
}

</style>
 <script src='js/bootstrap-datepicker.min.js' type='text/javascript'></script>
<script src="js/city_state.js" type="text/javascript"></script>
<link href='css/datepicker.min.css' rel='stylesheet' type='text/css'>
<!--<link href='css/bootstrapMaterial.css' rel='stylesheet' type='text/css'> -->
<script>
$(document).ready(function() {  
   
  $('.datepicker').datepicker();  
});



function valid()
    {
    
        var first_name=document.getElementById("id_first_name").value;
        
        var last_name=document.getElementById("id_last_name").value;
        
        if(first_name.trim()==null||first_name.trim()=="" || last_name.trim()==null|| last_name.trim()=="" )
            {
               
                alert('Please Enter Name');
                
                return false;
            }
        
        regx1=/^[A-z ]+$/;
                //validation for name
                if(!regx1.test(first_name) || !regx1.test(last_name))
                {
                alert('Please Enter valid Name');
                    return false;
                }
                else
                {
                    document.getElementById('errorname').innerHTML='';
                }
    //          
                regx1=/^[A-z ]+$/;
                var Designation=document.getElementById("Designation").value;
            if(Designation.trim()==null||Designation.trim()=="")
            { 
                alert('Please Enter Designation');
                return false;
            }
            if(!regx1.test(Designation) || !regx1.test(Designation))
                {
               alert('Please Enter valid Designation');
                    return false;
                }
           
                
                   var experience = document.getElementById("experience").value;
                var experience_month = document.getElementById("experience_month").value;
        
        
                 if(experience.trim()=="" && experience_month=='')
            {
                document.getElementById('errorname').innerHTML='';
                alert('Please enter experience');
                
                return false;
            }
      else if(experience < 0 || experience % 1 != 0){//if no is negative or decimal 

                        alert("Please enter valid Experience");
                        return false;

                    }
      
      
       if(experience_month=='')
            {
                document.getElementById('errorname').innerHTML='';
                alert('Please select month');
                
                return false;
            }
            
            var id_checkin=document.getElementById("id_checkin").value;
       var myDate = new Date(id_checkin);

        var today = new Date();
            if (id_checkin=="") {
                alert('Please Enter Date of Birth');
                return false;
            }
            else if (myDate.getFullYear() >= today.getFullYear()) {

                if (myDate.getFullYear() == today.getFullYear()) {
    
                    if (myDate.getMonth() == today.getMonth()) {
                        if (myDate.getDate() >= today.getDate()) {

                            alert('Please Enter Valid Date of Birth');
                            return false;
                        }
                        else {
                              document.getElementById('errordob').innerHTML='';      
                        }

                 }

                 else if (myDate.getMonth() > today.getMonth()) {
                      alert('Please Enter Valid Date of Birth');
                      return false;

                 }
                 else {
                        document.getElementById('errordob').innerHTML='';        
                 }
           }
            else 
            {
               alert('Please Enter Valid Date Of Birth');
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
               alert('Please Select gender');
                return false;
            }
            else
            {
                document.getElementById('errorgender').innerHTML='';
            }
            
        var id_email=document.getElementById("id_email").value;
        
        if(id_email==null||id_email=="")
            {
               
               alert('Please Enter email');
                
                return false;
            }
            
              
                var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;  
              if(!id_email.match(mailformat))  
                {  
                alert('Please Enter valid email ID');

                return false;  
                }
                {  
                document.getElementById('erroremail').innerHTML='';
                }   
        
              
      var id_phone=document.getElementById("id_phone").value;
      
        regx2=/^[6789]\d{9}$/;
                //validation for name
                if(!regx2.test(id_phone))
                {
               alert('Please Enter valid mobile number');
                    return false;
                }
                else
                {
                    document.getElementById('errorphone').innerHTML='';
                }
                


        var address=document.getElementById("id_address").value;
        if(address.trim()==null||address.trim()=="")
            {
               
                alert('Please Enter address');
                
                return false;
            }
            else
            {
                document.getElementById('erroraddress').innerHTML='';
            }
            if(document.getElementById("text_country1").style.display=="block")
            {
                var country=document.getElementById("country").value;
                if(country=="-1")
                    {   
                        alert('Please Enter country');
                        return false;
                    }
                    else
                    {
                        document.getElementById('errorcountry').innerHTML='';
                    }
            }
            if(document.getElementById("text_state").style.display=="block")
            {
                var state=document.getElementById("state").value;
                if(state==null||state=="")
                    {
                       
                       alert('Please Enter state');
                        
                        return false;
                    }   
                    else
                    {
                        document.getElementById('errorstate').innerHTML='';
                    }
            }
        var city=document.getElementById("id_city").value;
        
        if(city.trim()==null||city.trim()=="")
            {
               
               alert('Please enter city');
                
                return false;
            }
            
            if(!regx1.test(city) )
                {
                alert('Please enter valid city');
                    return false;
                }
            else
            {
                document.getElementById('errorcity').innerHTML='';
            }
            
                                
              
        
    }
</script>
<script>
function showOrhide()
{

if(document.getElementById("firstBtn"))
{

document.getElementById('text_country1').style.display="block";
document.getElementById('text_country').style.display="none";
document.getElementById('text_state1').style.display="block";
document.getElementById('text_state').style.display="none";
return false;
}


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

<script type="text/javascript"> 

$(document).ready(function() { 

$('#country').change(function() { 

    var  country=document.getElementById("country").value;
    
        if(country=='-1')
            {
                
                alert('Please enter country');
                
                return false;
            }
       
      
      

}); 
}); 
</script> 


<script type="text/javascript"> 

$(document).ready(function() { 

$('#state').change(function() { 

    var  state=document.getElementById("state").value;

 if(state==null|| state=="")
            {
                
                alert('Please enter State');
                
                return false;
            }
 
    else
      
      {
       document.getElementById('errorstate').innerHTML='';
                
                
      }
      

}); 
});

 
</script> 
<style>
.error {color: #FF0000;}
#edit_access{
     overflow-x: scroll;
    }
</style>

</head>
<body >
  
    <div class='panel panel-primary dialog-panel' style="background-color:#FFFFFF;background-image=""">
   <div style="color:red;font-size:15px;font-weight:bold;margin-top:10px;"> <?php if(isset($_GET['report'])){ echo $_GET['report']; };?></div>
     <div class='row' align="center"  style="color:#090"><?php echo $report;?></div>
      <div class='row' align="center"  style="color:#F00"><?php echo $errorreport;?></div>
      <div class='panel-heading'>
         
            <h3 align="center">Edit Staff Information</h3>
        
        
          <!--  <h5 align="center"><a href="Add_teacherSheet.php" >Add Excel Sheet</a></h5> -->
          </div>
          
                      
      <div class='panel-body'>
        <form class='form-horizontal' role='form' method="post">


         <!-- <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='id_title' style="text-align:left;">Staff Name<b style="color:red";>*</b></label>
            <div class='col-md-5'>
            
              <div class='col-md-7 '>
                <div class='form-group internal'>
                  <input class='form-control' id='id_first_name' value="<?=$a[0];?>" name="id_first_name"  placeholder='First Name' type='text'>
                </div>
              </div>
              </div>
              </div>
              
              <div class='form-group'>
               <label class='control-label col-md-2 col-md-offset-2' for='id_title' style="text-align:left;">Last Name<b style="color:red";>*</b></label>
            <div class='col-md-5'>
              <div class='col-md-7'>
                <div class='form-group internal'>
                  <input class='form-control' id='id_last_name' value="<?=$a[1];?>" name="id_last_name" placeholder='Last Name' type='text'>
                </div>
              </div>
              <div class='col-md-4 indent-small' id="errorname" style="color:#FF0000">
                
              </div>
            </div>
          </div>
                           <?php if($edu!=="0")
                           {
                           ?>     
        <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='id_service' style="text-align:left;">Education<b style="color:red";>*</b></label>
            <div class='col-md-3'>
              <select class='multiselect  form-control' id='id_service' name="id_education" >
                 <option value="<?=$edu;?>" selected=""><?=$edu;?></option>
                 
                <option value="BA">BA</option>
                <option value="BCom">BCom</option>
                <option value="BSc">BSc</option>
                <option value="MA">MA</option>
                <option value="MCom">MCom</option>
                <option value="MSc">MSc</option>
                <option value="B.ED">B.ED</option>
                <option value="D.ED">D.ED</option>
             </select>  
                           
                </div>
                <div class='col-md-15' id="erroreducation" style="color:#FF0000;"></div>
              </div>
               
           
          
                       <?php 
                           }
                           else
                           {
                               ?>
                           <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='id_checkin' style="width:440%;text-align:left;">Education<span class="error"> *</span></label>
            <div class='col-md-12'>
              <div class='col-md-7'>
                <div class='form-group internal input-group'>
              <select class="multiselect  form-control" id="id_service" name="id_education">
              <option value="" selected="">Select</option>
                 
                <option value="BA">BA</option>
                <option value="BCom">BCom</option>
                <option value="BSc">BSc</option>
                <option value="MA">MA</option>
                <option value="MCom">MCom</option>
                <option value="MSc">MSc</option>
                <option value="B.ED">B.ED</option>
                <option value="D.ED">D.ED</option>
             </select>  
                           
                </div>
                <div class='col-md-15' id="erroreducation" style="color:#FF0000;"></div>
              </div>  
            </div>
          </div>    
                               
          <?php
            }
            ?>
        
        <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='id_title' style="text-align:left;">Designation<b style="color:red";>*</b></label>
            
             
                <div class='form-group '>
    <input class='form-control col-md-8' style="width:21.7%;margin-left:15px;" value="<?=$des?>" id='Designation' name="Designation"  placeholder='Designation' type='text'>
                </div>
             </div>
             
              
                <div class='col-md-15' id="errordesignation" style="color:#FF0000;
                
                "></div>
              
          
          
            
                  <div class='form-group'>
                <label class='control-label col-md-2 col-md-offset-2' for='id_accomodation' style="text-align:left;">Experience</span><b style="color:red";>*</b></label>
                <div class='col-md-3'>
                    <input class='form-control ' id='experience' name='experience' type='text' value=<?php echo $year; ?>>
                </div>
                  <div class='col-md-3'>
                <select class='multiselect  form-control' id='experience_month' name="experience_month">
                        <?php
                        echo $month;
                        if ($month != '') {
                            ?>
                            <option value='<?php echo $month ?>'
                                    selected><?php echo $month; ?></option>
                            <?php
                        } else { ?>
                            <option value='0'>Select</option>
                        <?php } ?>
                        <?php if ($month != '0') { ?>
                            <option value='0'>0</option>
                        <?php }
                        if ($month != '1') {
                            ?>
                            <option value='1'>1</option>
                        <?php }
                        if ($month != '2') {

                            ?>
                            <option value='2'>2</option>
                        <?php }
                        if ($month != '3') {

                            ?>
                            <option value='3'>3</option>
                        <?php }
                        if ($month != '4') {

                            ?>
                            <option value='4'>4</option>
                        <?php }
                        if ($month != '4') {

                            ?>
                            <option value='5'>5</option>
                        <?php }
                        if ($month != '5') {

                            ?>
                            <option value='6'>6</option>
                        <?php }
                        if ($month != '6') {

                            ?>
                            <option value='7'>7</option>
                        <?php }
                        if ($month != '8') {

                            ?>
                            <option value='8'>8</option>
                        <?php }
                        if ($month != '9') {

                            ?>
                            <option value='9'>9</option>
                        <?php }
                        if ($month != '10') {

                            ?>
                            <option value='10'>10</option>
                        <?php }
                        if ($month != '11') {

                            ?>
                            <option value='11'>11</option>
                        <?php }

                            ?>
                          
                    </select>
                  </div>
                
                <div class='col-md-2 indent-small' id="errorexperience" style="color:#FF0000"></div>
            </div>
               
    
        
         
           <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='id_checkin' style="text-align:left;">Date Of Birth<b style="color:red";>*</b></label>
            <div class='col-md-8'>
              <div class='col-md-5'>
                <div class='form-group internal input-group'>
              
               <input class='form-control datepicker' value="<?=$GetDate;?>" id="id_checkin" name="dob" class="form-control" style="width:140%; margin-left:1px;">
              
               
                
                </div>
                
                <div class='col-md-15' id="errordob" style="color:#FF0000;
                
                "></div>
              </div>
               
            </div>
          </div>
          
          
          <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='id_pets' style="text-align:left;">Gender<span class="error"> *</span></label>
           <div class='col-md-2' style="font-weight: 600;
color: #777;">
           <input type="radio" name="gender" id="gender1"<?php if($Getgender=="Male"){echo "checked=\"checked\" ";} ?>value="Male"> 
                  Male
             </div>
             <div class='col-md-3' style="font-weight: 600;
color: #777;">
             <input type="radio" name="gender" id="gender2"  <?php if($Getgender=="Female"){echo "checked=\"checked\" ";} ?> value="Female">
            Female
              </div>
              
                <div class='col-md-2 indent-small' id="errorgender" style="color:#FF0000">
          </div>
          </div>
          
       
         <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='id_email' style="text-align:left;" >Contact<span class="error"> *</span></label>
            <div class='col-md-6'>
              <div class='form-group'>
                <div class='col-md-6'>
                  <input class='form-control' id='id_email' name="id_email" value="<?=$mailid;?>" placeholder='E-mail' type='text'>
                </div>
                <div class='col-md-3 indent-small' id="erroremail" style="color:#FF0000">
                
              </div>
              </div>
              <div class='form-group '>
                <div class='col-md-6'>
                  <input class='form-control' id='id_phone' name="id_phone" value="<?=$phone?>" placeholder='Mobile No' type='text' >
                </div>
                <div class='col-md-3 indent-small' id="errorphone" style="color:#FF0000">
                
              </div>
              </div>
            </div>
          </div>
          
          <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='id_comments' style="text-align:left;">Address<span class="error"> *</span></label>
            <div class='col-md-3'>
              <textarea class='form-control' id='id_address' name="address" placeholder='Address' rows='3'><?=$add?></textarea>
            </div>
            <div class='col-md-2 indent-small' id="erroraddress" style="color:#FF0000"></div>
          </div>
         
         
        
        <div class="form-group" style="padding-top:7px;" id="text_country" style="display:block" align="left">
         
           
          <label class="col-md-2 col-md-offset-2">Country<span class="error"> *</span></label> 
<div class="col-md-5"><input type="text" class='form-control' id="country1" name="country1" style="width:57%;" value="<?=$getcounty?>" readonly >
</div>
<div class="control-label col-md-2 " id="firstBtn"><a href="" onClick="return showOrhide()">Edit</a></div>
   
</div>

        <div class='row ' style="padding-top:7px; display:none" id="text_country1" align="left">
           
            <label class="col-md-2 col-md-offset-2 ">Country<span class="error"> *</span></label> 
    <div class='col-md-2'>
                  <select id="country" name="country" class='form-control' ></select>
                </div>
            
             
            <div class='col-md-3 indent-small' id="errorcountry" style="color:#FF0000"></div>
         </div>
         
         


<div class='row ' style="padding-top:7px; display:none" id="text_state1" align="left">
            <label class=" col-md-2 col-md-offset-2">State <span class="error"> *</span></label>
    <div class='col-md-2'>
                  <select id="state" name="state" class='form-control' style="width:60%;" ></select>
                </div>
            
             
            <div class='col-md-3 indent-small' id="errorstate" style="color:#FF0000"><?php// echo $report4; ?></div>
         </div>
       


<div class="row" style="padding-top:7px;" id="text_state" style="display:block" align="left">
<label class=" col-md-2 col-md-offset-2 "> State<span class="error"> *</span></label>
<div class="col-md-5"> <input type="text" id="state1" name="state1"  class='form-control' style="width:57%;" value="<?=$getstatu?>" readonly>


</div> 
</div>
 <script language="javascript">
            populateCountries("country", "state");
            populateCountries("country2");
        </script>
</div>

         <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='id_accomodation' style="text-align:left;" >City<span class="error"> *</span></label>
            <div class='col-md-3'>
              <input type="text" class='form-control' value="<?=$city?>" id='id_city' name="city" placeholder="City">
            </div>
            
             <div class='col-md-3 indent-small' id="errorcity" style="color:#FF0000"></div>
          </div>
       <div class='form-group'>
       <div class='col-md-1'></div>
        <div class='col-md-12'>
        
  </div>
          
           </div> -->
           
<!--Commented above code and added below code for table driven menu access by Pranali for SMC-4485 on 5-3-20  --> 
                <div class='form-group' id='edit_access'>
                                 
            
             <div class='form-group'>
       
        
            <fieldset style="border:thick;margin-left:11px;">
    <legend>Edit Access for <?php echo $stf_name; ?></legend>
    <div class='col-md-12'>
             <div class="form-group internal" align="center" style="padding:10px;"> <td style="background-color:#B2B2B2;  border-radius:5px;"><input type="checkbox" onClick="toggle(this)">Select All</td></div>
<?php    
  $permission_query="select * from tbl_permission where s_a_st_id='".$staff_id."' AND school_id='".$school_id."'";           
  $getpermision=mysql_query($permission_query);
  $fetchpermision=mysql_fetch_array($getpermision);
  $perm=$fetchpermision['permission'];  
?>
   <table id="perm" class="table-striped table-bordered table" style="width:100%;border:1px solid #ddd;">
      <tr>
        <?php 
    $sql_menu_access = "SELECT * FROM tbl_menu WHERE entity_name='$entity' AND org_type_id='$school_type' AND menu_active='Y' AND parent_menu_id='0'";

        $menu_access=mysql_query($sql_menu_access); 
        while ($menu = mysql_fetch_assoc($menu_access)) {
            $key=$menu['menu_key'];
                $Mst=strpos($perm,$key);
                    if($Mst !== false)
                    { $checked='checked';

                  }else{
                    $checked='';
                  }
                ?>
          <td style="background-color:#B2B2B2;">
            <input type="checkbox" name="permission[]" value="<?php echo $menu['menu_key']; ?>" <?php echo $checked; ?> /><?php echo $menu['menu_name']; ?>
          </td>
        <?php
        }
        ?>
      </tr>

      <tr>
        <?php
        $menu_access=mysql_query($sql_menu_access);

        $getpermision=mysql_query($permission_query);
        $fetchpermision=mysql_fetch_array($getpermision);
        $child_perm=$fetchpermision['permission'];

        while ($menu = mysql_fetch_assoc($menu_access)) { ?>
          <td>
          <table>
          <?php
          $child_menu = mysql_query("SELECT * FROM tbl_menu WHERE entity_name='$entity' AND org_type_id='$school_type' AND menu_active='Y' AND parent_menu_id='".$menu['id']."'");
            
          if(mysql_num_rows($child_menu)==0){ ?>
            </table>
            </td>
            <?php
          } else {
            //display child menu if it exists
            while($child_menu1 = mysql_fetch_assoc($child_menu)){ 
              ?>
              <tr>
                <?php
                $child_key=$child_menu1['menu_key'];
                $child_Mst=strpos($child_perm,$child_key);
                    if($child_Mst !== false)
                    {  $child_checked='checked';

                  }else{
                    $child_checked='';
                  }
                  
                  ?>
                <td>
                  <ul style="list-style-type:none; margin-left: -35px;">
                    <li>
                      <input type="checkbox" name="permission[]" value="<?php echo $child_menu1['menu_key']; ?>" <?php echo $child_checked; ?> /><?php echo $child_menu1['menu_name']; ?>
                    </li>
                  </ul>
                </td>
              </tr>
              <?php 
            }
            ?>
            </table>
            </td>
          <?php 
          } 
        }
        ?>
      </tr>
    </table>
                       
                       
  </fieldset>
  
  
  </div>
          
           </div>
           
           <div class='form-group row'>
           <div class='col-md-2 col-md-offset-4' >
   <input class='btn-lg btn-primary' type='submit' value="Update" name="Update" onClick="return valid()" style="padding:5px;"/>
                </div>
                
              <script>   
                    /*  function abc()
                      { 
                      window.history.go(1);
                      }*/
              </script>
                 <div class='col-md-1'>
                    
     <a href="schoolAdminStaff_list.php"><input type="button" class='btn-lg btn-danger' value="Cancel" style="padding:5px;" /></a>
                    
                  </div>
</div>
                  </div>
          
        </form>
      </div>
    
    </div>
 
</body> 

    <?php } ?>