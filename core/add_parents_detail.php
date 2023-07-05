<?php
include_once("scadmin_header.php");

if($_SESSION['usertype']=='HR Admin Staff' OR $_SESSION['usertype']=='School Admin Staff')
    {
        $sc_id1=$_SESSION['school_id']; 
        $query2 = mysql_query("select id from tbl_school_admin where school_id ='$sc_id1'");

    $value2 = mysql_fetch_array($query2);

    $id = $value2['id'];
        
        
    }
    else
    {
        $id = $_SESSION['id'];
    }
    $query = mysql_query("select * from tbl_school_admin where id ='$id'");

    $value = mysql_fetch_array($query);

    $school_id = $value['school_id'];

//$id=$_SESSION['id'];

     $fields=array("id"=>$id);

           $table="tbl_school_admin";

           $smartcookie=new smartcookie();

           

$results=$smartcookie->retrive_individual($table,$fields);

$school_admin=mysql_fetch_array($results);

    

            $sc_id=$school_admin['school_id'];

            $uploadedBy=$school_admin['name'];
            
            
    if(base64_decode($_REQUEST['id'])=='')  
    {
//add parent details        
if(isset($_POST['submit']))



{

    $std_PRN=$_POST['student_id'];

    

$student_name=$_POST['student_name'];



$parent_name=$_POST['parent_name'];

$phone=$_POST['phone'];

$Occupation=$_POST['Occupation'];

$FamilyIncome=$_POST['FamilyIncome'];

$id_email = $_POST['id_email'];
$id_checkin = $_POST['id_checkin'];
$gender = $_POST['gender'];
$mothername = $_POST['mothername'];
$Qualification = $_POST['Qualification'];
$id_address = $_POST['id_address'];
$country = $_POST['country'];
$state = $_POST['state'];
$id_city = $_POST['id_city'];
$pass = $parent_name.'123';
//$fileToUpload = $_POST['fileToUpload'];


        $path = "parent_img/";
        $allowedTypes = array("jpg","jpeg","png","gif");
        //echo$_FILES['profileimg']['tmp_name'];
        $extension = end(explode(".", $_FILES["photo"]["name"]));
        $size = $_FILES['photo']['size'];
        
        $error = !in_array($extension, $allowedTypes);

        if($_FILES['photo']['name'] == "")
        {
            //echo "<script>alert('Please select an image to upload.');</script>";
            $flag = 0;
        }
        else if($error)
        {
            echo "<script>alert('Image format is invalid, please upload correct format.');</script>";
            $flag = 0;
        }
        else if($size > 1048576)
        {
            echo "<script>alert('Image size should be of less than 1 MB');</script>";
            $flag = 0;
        }

        $actual_image_name = time().$id.".".$extension;
        $tmp = $_FILES['photo']['tmp_name'];
        if($flag !=0)
        {
            move_uploaded_file($tmp, $path.$actual_image_name);
            $imgpath = $path.$actual_image_name;
}
        
    

$sql1=mysql_query("select Phone,email_id,std_PRN from tbl_parent where std_PRN='$std_PRN' and (Phone='$phone' or email_id='$id_email')");
// echo "select Phone,email_id,std_PRN from tbl_parent where std_PRN='$std_PRN' and (Phone='$phone' or email_id='$id_email')";exit;
$cnt=mysql_num_rows($sql1);

if($cnt<1)
{



//uploaded date set to current date time by Pranali for SMC-3765 on 14-5-19
$upload_date=date('Y-m-d h:i:s');


$query=mysql_query("insert into tbl_parent (Name,std_PRN,Phone,Occupation,FamilyIncome,school_id,uploaded_date_time,uploaded_by,email_id,DateOfBirth,Gender,Mother_name,Qualification,Password,Address,country,state,city,p_img_path) values('$parent_name','$std_PRN','$phone','$Occupation','$FamilyIncome','$sc_id','$upload_date','$uploadedBy','$id_email','$id_checkin','$gender','$mothername','$Qualification','$pass','$id_address','$country','$state','$id_city','$imgpath')");


                       

//$report1="Subject is successfully Inserted";
echo ("<script LANGUAGE='JavaScript'>
                    alert('Parent is successfully Inserted');
                    window.location.href='parents_list.php';
                    </script>");


}else {
    
    echo ("<script LANGUAGE='JavaScript'>
                    alert('Record not inserted..!');
                    window.location.href='parents_list.php';
                    </script>");
}
}

$querysql = "select * from tbl_student where school_id='$sc_id'";
$queryresult = mysql_query($querysql);

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
            </style>
            <script src='js/bootstrap-datepicker.min.js' type='text/javascript'></script>
            <script src="js/city_state.js" type="text/javascript"></script>
            <link href='css/datepicker.min.css' rel='stylesheet' type='text/css'>
            <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
            <script src="js/jquery-1.11.1.min.js"></script>
            <link rel="stylesheet" href="css/bootstrap.min.css">
            <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
            <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">

            <link href='css/datepicker.min.css' rel='stylesheet' type='text/css'>
            <script type="text/javascript">
    
        $(function () {
            $("#id_checkin").datepicker({
                dateFormat: 'yy-mm-dd',
                maxDate: 0,
                changeMonth: true,
                changeYear: true
            });
        });
    </script>
           

            <script>


                var reg = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;
                function PhoneValidation(phoneNumber) {
                    var OK = reg.exec(phoneNumber.value);
                    if (!OK)
                        document.getElementById('errorphone').innerHTML = 'Please Enter Valid Phone Number';
                    return false;



                    var phone = document.getElementById("phone").value;


                    if (phone>10) {

                        document.getElementById('errorphone').innerHTML = 'Please Enter valid no';

                        return false;
                    }

                    if (phone<10) {

                        document.getElementById('errorphone').innerHTML = 'Please Enter valid no';

                        return false;
                    }


                }
                function valid() {
                    
                    var first_name = document.getElementById("student_name").value;
            if (first_name == null || first_name == "") {
               alert("Please select student Name");
                return false;
            }
            
            var first_name = document.getElementById("parent_name").value;
            if (first_name == null || first_name == "") {
               alert("Please Enter Parent Name");
                return false;
            }
            regx1 = /^[A-z ]+$/;
            //validation for name
            if (!regx1.test(first_name)) {
                alert("Please Enter Valid Parent Name");
                return false;
            }
           
           
            var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

            var email = document.getElementById("id_email").value;
            if(email=='')
            {
                alert("Please Enter Email ID");
            }
            

          else if (!email.match(mailformat)) {
               alert("Please Enter valid email ID");

                return false;
            }
            else {
                document.getElementById('erremail').innerHTML = '';
            }
            

            var phone1 = document.getElementById("phone").value;
            var phone=phone1.trim();
                if(phone=='')
            {
                alert("Please Enter Phone Number");
            }
          else if(phone!=''){
                var pattern = /^[6789]\d{9}$/;
                
                if (!pattern.test(phone)) {
                   alert("Please enter 10 digits number!");
                    return false;
                }
                
        }
            

              var myDate = new Date(id_checkin);

                    var today = new Date();

                    if (id_checkin == "") {


                        document.getElementById('errordate').innerHTML = 'Please enter date of birth';

                        return false;
                    }


                    else if (myDate.getFullYear() >= today.getFullYear()) {

                        if (myDate.getFullYear() == today.getFullYear()) {

                            if (myDate.getMonth() == today.getMonth()) {
                                if (myDate.getDate() >= today.getDate()) {

                                    document.getElementById("errordate").innerHTML = "please enter valid birth date";
                                    return false;
                                }
                                else {
                                    document.getElementById("errordate").innerHTML = "";
                                }


                            }
                            else if (myDate.getMonth() > today.getMonth()) {
                                document.getElementById("errordate").innerHTML = "please enter valid birth date";
                                return false;

                            }
                            else {
                                document.getElementById("errordate").innerHTML = "";
                            }
                        }
                        else {
                            document.getElementById("errordate").innerHTML = "";

                        }
                    }



            var gender1 = document.getElementById("gender1").checked;

            var gender2 = document.getElementById("gender2").checked;

            if (gender1 == false && gender2 == false) {
                document.getElementById('errorgender').innerHTML = 'Please Select gender';
                return false;
            }
            else {
                document.getElementById('errorgender').innerHTML = '';
            }

            
             var country = document.getElementById("country");

                    if (country.value == "-1" || country.value == '') {

                        alert("Please select country");
                        return false;
                    }
                    

                    var state = document.getElementById("state");
                    if (state.value == "" || state.value == "-1" ) {

                         alert("Please select state");
                        return false;
                    }
                    
                    
                    var id_city = document.getElementById("city").value;
                 
                    var pattern = /^[a-zA-Z ]+$/;
                    if(id_city.trim()=="" || id_city.trim()==null)
                    {
                        alert("Please enter city!");
                        return false;
                    }
                    else if (!pattern.test(id_city)) {
                        alert("Please enter valid city!");
                        return false;
                    }

            var address = document.getElementById("id_address").value;
           /* if (address == null || address == "") {

                document.getElementById('erroraddress').innerHTML = 'Please Enter address';

                return false;
            }
            else {
                document.getElementById('erroraddress').innerHTML = '';
            }*/
          
        }
        </script>
<style>
.error {color: #FF0000;}
</style>
        </head>
<body>
        <div class='container'>
            <div class='panel panel-primary dialog-panel' style="background-color:#FFFFFF;background-image="
            "">
            <div style="color:red;font-size:15px;font-weight:bold;margin-top:10px;"> <?php if (isset($_GET['report'])) {
                    echo $_GET['report'];
                }; ?></div>
            <div class='panel-heading'>

                <h3 align="center">Add Parent Details</h3>

            <!--Removed Add excel sheet option for SMC-4443 by Sayali Balkawade on 18/01/2020 -->
               <!-- <h5 align="center"><a href="Add_ParentSheet.php?id=<?= $school_id ?>">Add Excel Sheet</a>-->
                <!-- <h5 align="center"><b style="color:red;">All Field Are mandatory</b></h5> -->

            </div>
            <div class='panel-body'>

                <form enctype="multipart/form-data" class='form-horizontal' role='form' method="post">




                    <div class='form-group'>
                        <label class='control-label col-md-2 col-md-offset-2' for='id_title' style="text-align:left;">Student Name<span class="error"><b> *</b></span> </label>
                        <div class='col-md-6'>
                            <div class='form-group'>
                            
                                <div class='col-md-6'>
                                     <select class='multiselect  form-control' id='student_name' name="student_name" onChange="StudentNameChnage(this)">

                                    <option value=''>Select <?php echo $dynamic_student; ?> Name</option>
                                    <?php
                                    $querysql = "select DISTINCT std_name,std_PRN from tbl_student where school_id='$sc_id' AND std_name != ''";
                                    $queryresult = mysql_query($querysql);
                                    while($row = mysql_fetch_array($queryresult)){
                                    $studentname = $row['std_name'];
                                    $studentid = $row['std_PRN'];
                                    echo "<option value='$studentid'>$studentname</option>";
                                    }
                                    ?>
                                    </select>
                                </div>

                            </div>
                            <div class='col-md-4 indent-small' id="errorname" style="color:#FF0000">
                            </div>
                        </div>  
                    </div>         
                    
                
<script>
function StudentNameChnage(strVal) {
var strStudentId = document.getElementById("student_name").value;
document.getElementById("student_id").value = strStudentId;
};
</script>
                   



             
                   
                    <div class='form-group'>
                        <label class='control-label col-md-2 col-md-offset-2' for='id_checkin2' style="text-align:left;"><?php echo $dynamic_student_prn; ?></label>
                        <div class='col-md-6'>
                            <div class='form-group'>
                            
                                <div class='col-md-6'>
                                    <input class='form-control' id='student_id' name="student_id" placeholder='Student PRN No.' type='text' readonly>
                                </div>

                            </div>
                        </div>  
                    </div>  
                   
                   
                   
                   
                           
                                <div class='form-group'>
                        <label class='control-label col-md-2 col-md-offset-2' for='id_checkin2' style="text-align:left;">Parent Name<span class="error"><b> *</b></span></label>
                        <div class='col-md-6'>
                            <div class='form-group'>
                            
                                <div class='col-md-6'>
                                    <input class='form-control' id='parent_name' name="parent_name" placeholder='Parent Name' type='text' maxlength="100">
                                </div>


                            </div>
                        </div>  
                    </div>         
                                       
                                       
                         <div class='form-group '>
                        <label class='control-label col-md-2 col-md-offset-2' for='Mobile no.' style="text-align:left;">Phone<span class="error"><b> *</b></span></label>
                            <div class='col-md-6'>
                                <div class='form-group'>
                                <div class='col-md-6'>
                                    <input class='form-control' id='phone'  name="phone" placeholder='Mobile No'   length="10" type='text' onChange="PhoneValidation(this);">
                                </div>
                                <div class='col-md-3 indent-small' id="errorphone" style="color:#FF0000">
                                </div>
                            </div>
                        </div>
                    </div> 

                        
                        <div class='form-group'>
                        <label class='control-label col-md-2 col-md-offset-2' for='email' style="text-align:left;">Email<span class="error"><b> *</b></span></label>
                        <div class='col-md-6'>
                            <div class='form-group'>
                            
                                <div class='col-md-6'>
                                    <input class='form-control' id='id_email' name="id_email" placeholder='E-mail' type='email' maxlength="60">
                                </div>
                                <div class='col-md-3 indent-small' id="erroremail" style="color:#FF0000">
                                </div>
                            </div>
                        </div>  
                    </div>  


            
                     <div class='form-group '>
                        <label class='control-label col-md-2 col-md-offset-2' for='id_check no.' style="text-align:left;">Date Of Birth<span class="error"><b> *</b></span></label>
                            <div class='col-md-6'>
                                <div class='form-group'>
                                <div class='col-md-6'>

                                    <input class='form-control datepicker' id="id_checkin" name="id_checkin" class="form-control" required>
                                </div>
                                <div class='col-md-15' id="errordob" style="color:#FF0000"></div>
                            </div>
                        </div>
                    </div> 
                    

                     <div class='form-group'>
                        <label class='control-label col-md-2 col-md-offset-2' for='id_pets' style="text-align:left;" >Gender<span class="error"><b> *</b></span></label>
                        <div class='col-md-2' style="font-weight: 600;color: #777;">
                            <input type="radio" name="gender" id="gender1" value="Male" required>Male
                        </div>
                        <div class='col-md-3' style="font-weight: 600;color: #777;">
                            <input type="radio" name="gender" id="gender2" value="Female" required>Female
                        </div>
                        <div class='col-md-2 indent-small' id="errorgender" style="color:#FF0000">
                        </div>
                    </div>
                    
                    <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' style="text-align:left;">Address<span class="error"><b> </b></span></label>
            <div class='col-md-3' style="text-align:left;">
              <textarea class='form-control' id='id_address' name="id_address" placeholder='Address' rows='3' style="resize:none;" maxlength="200"></textarea>
            </div>
            <div class='col-md-4 indent-small' id="erroraddress" style="color:#FF0000"></div>
        </div>
        
        <div class='form-group'>
                        <label class='control-label col-md-2 col-md-offset-2' style="text-align:left;">Country<span class="error"><b> </b></span></label>
                        <div class='col-md-3'>
                            <select id="country" name="country" class='form-control'>
                            <option value='-1'>select</option></select>
                        </div>
                        <div class='col-md-3 indent-small' id="errorcountry" style="color:#FF0000">
                        </div>
                    </div>
                    
                    <div class='form-group'>
                        <label class='control-label col-md-2 col-md-offset-2' style="text-align:left;">State<span class="error"><b> </b></span></label>
                        <div class='col-md-3'>
                            <select name="state" id="state" class='form-control'></select>
                        </div>
                        <div class='col-md-3 indent-small' id="errorstate" style="color:#FF0000"></div>

                    </div>
                    <script language="javascript">
                        populateCountries("country", "state");
                        //populateCountries("country2");
                    </script>
                     <div class='form-group'>
                        <label class='control-label col-md-2 col-md-offset-2' for='id_accomodation' style="text-align:left;">City<span class="error"><b> </b></span></label>
                        <div class='col-md-3'>
                            <input type="text" class='form-control' id='id_city' name="id_city" placeholder="City"  maxlength="30">
                        </div>
                        <div class='col-md-3 indent-small' id="errorcity" style="color:#FF0000"></div>
                    </div>
    
                    <div class='form-group'>
                        <label class='control-label col-md-2 col-md-offset-2' for='id_checkin' style="text-align:left;">Qualification</label>
                        <div class='col-md-6'>
                            <div class='form-group'>
                            
                                <div class='col-md-6'>
                                    <input class='form-control' id='Qualification' name="Qualification" placeholder='Qualification' type='text' >
                                </div>

                            </div>
                        </div>  
                    </div>  
                        
                    <div class='form-group'>
                        <label class='control-label col-md-2 col-md-offset-2' for='id_checkin' style="text-align:left;">Occupation</label>
                        <div class='col-md-6'>
                            <div class='form-group'>
                            
                                <div class='col-md-6'>
                                    <input class='form-control' id='Occupation' name="Occupation" placeholder='Occupation' type='text' >
                                </div>

                            </div>
                        </div>  
                    </div>      
                        
                        <div class='form-group'>
                        <label class='control-label col-md-2 col-md-offset-2' for='id_checkin' style="text-align:left;">Family Income</label>
                        <div class='col-md-6'>
                            <div class='form-group'>
                            
                                <div class='col-md-6'>
                                    <input class='form-control' id='FamilyIncome' name="FamilyIncome" placeholder='Family Income' type='text' >
                                </div>

                            </div>
                        </div>  
                    </div>

<div class='form-group'>
                        <label class='control-label col-md-2 col-md-offset-2' for='id_checkin' style="text-align:left;">Mother Name</label>
                        <div class='col-md-6'>
                            <div class='form-group'>
                            
                                <div class='col-md-6'>
                                    <input class='form-control' id='mothername' name="mothername" placeholder='Mother Name' type='text' >
                                </div>

                            </div>
                        </div>  
                    </div>  
                                
                        <div class='form-group'>
                        <label class='control-label col-md-2 col-md-offset-2' for='id_checkin' style="text-align:left;">Parent Profile Image</label>
                        <div class='col-md-6'>
                            <div class='form-group'>
                            
                                <div class='col-md-6'>
                                     <input type="file" class='form-control datepicker' name="photo" id="profileimg">
                                </div>

                            </div>
                        </div>  
                    </div>                          

                    <div class='form-group row'>
                        <div class='col-md-2 col-md-offset-4'>
                            <input class='btn-lg btn-primary' type='submit' value="Submit" name="submit"
                                   onClick="return valid()" style="padding:5px;"/>
                        </div>
                        <div class='col-md-1'>

                            <a href="parents_list.php"><input type="button" class='btn-lg btn-danger' value="Back"
                                                                name="Back" style="padding:5px;"/></a>

                        </div>


                </form>
            </div>
            <div class='row' align="center" style="color:#FF0000"><?php echo $report; ?></div>
        </div>
        </div>
        </body>
        
    <?php } else {

//edit parent details
    $id=base64_decode($_REQUEST['id']);

    $sql=mysql_query("SELECT p.Name,p.Phone,p.Address,p.city,p.state,p.country,p.Qualification,p.Occupation,p.Mother_name,p.DateOfBirth,p.FamilyIncome,p.email_id,s.std_name,p.std_PRN,s.std_Father_name,s.std_lastname,s.std_complete_name 
    FROM tbl_parent p 
    JOIN tbl_student s ON p.std_PRN=s.std_PRN and p.school_id=s.school_id
    WHERE p.Id='$id'");
        
        
    $result=mysql_fetch_array($sql);

            
                    
        if($result['std_complete_name']=="")
        {
            $std_name=$result['std_name']." ".$result['std_Father_name']." ".$result['std_lastname'];
        }
        
        else
        {
            $std_name=$result['std_complete_name'];
        }
                            
                            
                            

        if(isset($_POST['submit']))
        {
              $id=base64_decode($_REQUEST['id']);
              $Name=$_POST['Name'];
              $Phone=$_POST['Phone'];
              $email=$_POST['email'];
              
              
              $Occupation=$_POST['Occupation'];
              $FamilyIncome=$_POST['FamilyIncome'];
              $site=$_SERVER['SERVER_NAME'];
              $id_checkin=$_POST['id_checkin'];
              $id_address=$_POST['id_address'];
              $country=$_POST['country'];
              $state=$_POST['state'];
              $city=$_POST['city'];
              $qualification=$_POST['qualification'];
              $mname=$_POST['mname'];
                            
                            
                            
                            

         $ql="UPDATE `tbl_parent` SET `Name`='$Name',`Phone`='$Phone',`Occupation`='$Occupation',`FamilyIncome`='$FamilyIncome',email_id='$email', Address='$id_address', DateOfBirth='$id_checkin', Mother_name='$mname',country='$country',
         state='$state',city='$city',Qualification='$qualification'
         
         
         WHERE `Id`='$id'";
             $qr=mysql_query($ql);
             
             if($qr)
             {
                    echo "<script>alert('Updated Successfully')</script>";
                    header( "refresh:0; url=parents_list.php" );
             }
        }
        
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
    </style>
          
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>
            <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
            <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
    <script src="js/jquery-1.11.1.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css">
        <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
    <script src='js/bootstrap-datepicker.min.js' type='text/javascript'></script>
            <script src="js/city_state.js" type="text/javascript"></script>
            <link href='css/datepicker.min.css' rel='stylesheet' type='text/css'>  
        <script type="text/javascript">
    
     
            $(function () {

                $("#id_checkin").datepicker({
                     changeYear: true,
                    changeMonth: true 
                });

            });
        </script>
    <script>
        function valid() {
            var first_name = document.getElementById("Name").value;
            if (first_name == null || first_name == "") {
               alert("Please Enter Name");
                return false;
            }
            regx1 = /^[A-z ]+$/;
            //validation for name
            if (!regx1.test(first_name)) {
                alert("Please Enter Valid Name");
                return false;
            }
           
            var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

            var email = document.getElementById("email").value;
            if(email=='')
            {
                alert("Please Enter Email ID");
            }
            

          else if (!email.match(mailformat)) {
               alert("Please Enter valid email ID");

                return false;
            }
            else {
                document.getElementById('erremail').innerHTML = '';
            }
            

            var phone1 = document.getElementById("Phone").value;
            var phone=phone1.trim();
                if(phone=='')
            {
                alert("Please Enter Phone Number");
            }
          else if(phone!=''){
                var pattern = /^[6789]\d{9}$/;
                
                if (!pattern.test(phone)) {
                   alert("Please enter 10 digits number!");
                    return false;
                }
                
        }
            

             var id_checkin=document.getElementById("id_checkin").value;
                     var myDate = new Date(id_checkin);

                  

                var today = new Date();
                if(id_checkin=="")
            {
    
               
                
            }
            else if(myDate.getFullYear()>=today.getFullYear())
                {
                    
                    if(myDate.getFullYear()==today.getFullYear())
                   {
                    
                        if(myDate.getMonth()==today.getMonth())
                        {
                            if(myDate.getDate()>=today.getDate())
                            {
                                
                            document.getElementById("errordob").innerHTML ="please enter valid birth date";
                        return false;
                            }   
                            else
                            {
                                document.getElementById("errordob").innerHTML ="";
                            }
                            
                            
                        }   
                        else if(myDate.getMonth()>today.getMonth())
                        {
                            document.getElementById("errordob").innerHTML ="please enter valid birth date";
                        return false;
                            
                        }
                        else
                           {
                               document.getElementById("errordob").innerHTML ="";
                             }
                   }
                   else 
                   {
                       document.getElementById("errordob").innerHTML ="please enter valid birth date";
                        return false;
                       
                     }
                     
                   
                }
                      else
                      {
                           document.getElementById("errordob").innerHTML ="";
                          
                         }




            var gender1 = document.getElementById("gender1").checked;

            var gender2 = document.getElementById("gender2").checked;

            if (gender1 == false && gender2 == false) {
                document.getElementById('errorgender').innerHTML = 'Please Select gender';
                return false;
            }
            else {
                document.getElementById('errorgender').innerHTML = '';
            }

            
             var country = document.getElementById("country");

                    if (country.value == "-1" || country.value == '') {

                        alert("Please select country");
                        return false;
                    }
                    

                    var state = document.getElementById("state");
                    if (state.value == "" || state.value == "-1" ) {

                         alert("Please select state");
                        return false;
                    }
                    
                    
                    var id_city = document.getElementById("city").value;
                 
                    var pattern = /^[a-zA-Z ]+$/;
                    if(id_city.trim()=="" || id_city.trim()==null)
                    {
                        alert("Please enter city!");
                        return false;
                    }
                    else if (!pattern.test(id_city)) {
                        alert("Please enter valid city!");
                        return false;
                    }
            var address = document.getElementById("id_address").value;
           /* if (address == null || address == "") {

                document.getElementById('erroraddress').innerHTML = 'Please Enter address';

                return false;
            }
            else {
                document.getElementById('erroraddress').innerHTML = '';
            }*/
          
        }
    </script>
</head>
<body>
<div class="container" style="padding:10px;" align="center">
        <div class="row">
            <div class="col-md-3">
            </div>
            <div class="col-md-12">
                <div class="container" style="padding:25px;">
                    <div style="padding:2px 2px 2px 2px;border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;background-color:#F8F8F8 ;">
                        <form method="post">
                            <div class="row"
                                 style="color: #666;height:100px;font-family: 'Open Sans',sans-serif;font-size: 12px;">
                                <h2>Edit Parent Record</h2>
                            </div>
                            <div class="row ">
                                <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">
                                    <b> Parent Name:<span style="color:red;font-size: 25px;">*</span></b>
                                </div>
                                <div class="col-md-5 form-group">
                                    <input type="text" name="Name" id="Name" class="form-control" style="width:100%; padding:5px;" placeholder="Parent_Name" value="<?php echo $result['Name'] ?>"/>
                                    <div class="col-md-13" style="color:#FC2338; font-size:15px;" id="errName"></div>
                                </div>

                                <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">
                                    <b> <?php echo $dynamic_student_prn; ?>:<span style="color:red;font-size: 25px;">*</span></b>
                                </div>
                                <div class="col-md-5 form-group">
                                    <input type="text" name="std_PRN" id="std_PRN" class="form-control" style="width:100%; padding:5px;" placeholder="Student_PRN" value="<?php echo $result['std_PRN'];?>" readonly="readonly"/>
                                </div>

                                <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">
                                    <b> <?php echo $dynamic_student; ?> Name:<span style="color:red;font-size: 25px;">*</span></b>
                                </div>
                                <div class="col-md-5 form-group">

                                    <input type="text" name="Student_Name" id="Student_Name" class="form-control" style="width:100%; padding:5px;" placeholder="Student_Name" value="<?php echo $std_name;?>" readonly="readonly"/>
                                </div>

                                <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">
                                    <b> Phone:<span style="color:red;font-size: 25px;">*</span></b>
                                </div>
                                <div class="col-md-5 form-group">
                                    <input type="text" name="Phone" id="Phone" class="form-control" style="width:100%; padding:5px;" placeholder="Phone" value="<?php echo $result['Phone'];?>"/>
                                    <div class="col-md-13" style="color:#FC2338; font-size:15px;" id="errPhone"></div>
                                </div>
                                  <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">
                                    <b> Email:<span style="color:red;font-size: 25px;">*</span></b>
                                </div>
                                <div class="col-md-5 form-group">
                                    <input type="text" name="email" id="email" class="form-control" style="width:100%; padding:5px;" placeholder="email" value="<?php echo $result['email_id'];?> required"/>
                                    <div class="col-md-13" style="color:#FC2338; font-size:15px;" id="erremail"></div>
                                </div>
                                 <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">
                                    <b> Date Of Birth :<span style="color:red;font-size: 25px;"></span></b>
                                </div>
                        <div class="col-md-5 form-group">
                                    <input class='form-control datepicker' id="id_checkin" name="id_checkin" class="form-control" value="<?php echo $result['DateOfBirth'];?>" required/>
                                
                                <div class='col-md-15' id="errordob" style="color:#FF0000"></div>
                            </div>
                            
                             <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">
                                    <b> Address:<span style="color:red;font-size: 25px;"></span></b>
                                </div>
                                <div class="col-md-5 form-group">
                                     <input type="text" class='form-control' id='id_address' name="id_address" placeholder='Address' rows='3' style="resize:none;" maxlength="200"value="<?php echo $result['Address'];?>"/>
                                    <div class="col-md-13" style="color:#FC2338; font-size:15px;" id="errAddress"></div>
                                </div>
                                 <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">
                                    <b> Country:<span style="color:red;font-size: 25px;"></span></b>
                                </div>
                        <div class="col-md-5 form-group">
                             <select id="country" name="country" class='form-control'></select>
                        </div>
                       <div class="col-md-13" style="color:#FC2338; font-size:15px;" id="errOccupation"></div>
                       
                        <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">
                                    <b> State:<span style="color:red;font-size: 25px;"></span></b>
                                </div>
                        <div class="col-md-5 form-group">
                            <select name="state" id="state" class='form-control'>
                    
                    </select>
                        </div>
                       <div class="col-md-13" style="color:#FC2338; font-size:15px;" id="errOccupation"></div>
                        <script language="javascript">
                        populateCountries("country", "state");
                        populateCountries("country2");
                    </script>
                       
                        <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">
                                    <b> City:<span style="color:red;font-size: 25px;"></span></b>
                                </div>
                                <div class="col-md-5 form-group">
                                    <input type="text" name="city" id="city" class="form-control" style="width:100%; padding:5px;" placeholder="city" value="<?php echo $result['city'];?>"/>
                                    <div class="col-md-13" style="color:#FC2338; font-size:15px;" id="errPhone"></div>
                                </div>
                         <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">
                                    <b> Qualification:<span style="color:red;font-size: 25px;"></span></b>
                                </div>
                                <div class="col-md-5 form-group">
                                    <input type="text" name="qualification" id="qualification" class="form-control" style="width:100%; padding:5px;" placeholder="qualification" value="<?php echo $result['Qualification'];?>"/>
                                    <div class="col-md-13" style="color:#FC2338; font-size:15px;" id="errPhone"></div>
                                </div>
                       
                       
                
                                <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">
                                    <b>Occupation:<span style="color:red;font-size: 25px;"></span></b>
                                </div>
                                <div class="col-md-5 form-group">
                                    <input type="text" name="Occupation" id="Occupation" class="form-control" style="width:100%; padding:5px;" placeholder="Occupation" value="<?php echo $result['Occupation'];?>"/>
                                    <div class="col-md-13" style="color:#FC2338; font-size:15px;" id="errOccupation"></div>
                                </div>


                                <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">
                                    <b> Family Income:<span style="color:red;font-size: 25px;"></span></b>
                                </div>
                                <div class="col-md-5 form-group">
                                    <input type="text" name="FamilyIncome" id="FamilyIncome" class="form-control" style="width:100%; padding:5px;" placeholder="FamilyIncome" value="<?php echo $result['FamilyIncome'];?>"/>
                                    <div class="col-md-13" style="color:#FC2338; font-size:15px;" id="errFamilyIncome"></div>
                                </div>
                                
                                <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">
                                    <b>Mother Name:<span style="color:red;font-size: 25px;"></span></b>
                                </div>
                                <div class="col-md-5 form-group">
                                    <input type="text" name="mname" id="mname" class="form-control" style="width:100%; padding:5px;" placeholder="Mother Name" value="<?php echo $result['Mother_name'];?>"/>
                                    <div class="col-md-13" style="color:#FC2338; font-size:15px;" id="errOccupation"></div>
                                </div>
                                <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">
                                    <b>Parent Profile Image:<span style="color:red;font-size: 25px;"></span></b>
                                </div>
                       
                           <div class="col-md-5 form-group">
                                
                                
                                    <input type="file" class='form-control datepicker' name="photo" id="profileimg">
                                    
                                    </div>
                                     
                                       </div>

                            <div class="row ">
                                <div class="col-md-8 form-group col-md-offset-3" id="error"
                                     style="color:red;"><?php echo $report; ?></div>
                            </div>
                            <div class="row" align="right">

                                <div class='col-md-2 col-md-offset-4'>
                            <input class='btn-lg btn-primary' type='submit' value="Submit" name="submit" onClick="return valid()" style="padding:5px;"/>
                        </div>

                            
                                <div class="col-md-3" >

                                    <a href="parents_list.php" style="text-decoration:none;"> <input type="button" class="btn btn-danger" name="Back" value="Back" style="width:80px;font-weight:bold;font-size:14px;"/></a>

                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
      <script src='js/bootstrap-datepicker.min.js' type='text/javascript'></script>
       <link href='css/datepicker.min.css' rel='stylesheet' type='text/css'>
       <script src="js/city_state.js" type="text/javascript"></script>
    <link href='css/datepicker.min.css' rel='stylesheet' type='text/css'>
            

    </html>
<script type="text/javascript" language="javascript">
    $(document).ready(function () {
        var t_country = "<?php echo $value1['country'];?>";
        var state = "<?php echo $value1['state'];?>";
        $('#country').val(t_country).trigger('change');
        $('#state').val(state).trigger('change');
    });
</script>

</body>



                  

        <?php }?>