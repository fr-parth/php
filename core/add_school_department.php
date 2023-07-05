<?php


if (isset($_GET['name'])) {
    include('school_staff_header.php');
    $table = "tbl_school_adminstaff";
} else {
    include('scadmin_header.php');
    $table = "tbl_school_admin";
}

$successreport = "";
$errorreport = "";
$report1 = "";
/* include('scadmin_header.php');
$id=$_SESSION['id'];*/
if($_SESSION['usertype']=='HR Admin Staff' OR $_SESSION['usertype']=='School Admin Staff')
    {
        $sc_id=$_SESSION['school_id']; 
        $query2 = mysql_query("select id from tbl_school_admin where school_id ='$sc_id'");

    $value2 = mysql_fetch_array($query2);

    $id = $value2['id'];
        
        
    }
$fields = array("id" => $id);
/*  $table="tbl_school_admin"; */

$smartcookie = new smartcookie();

$results = $smartcookie->retrive_individual($table, $fields);
$result = mysql_fetch_array($results);
$sc_id = $result['school_id'];

////Below code updated by Rutuja Jori for merging Add page & Edit page into one on 28/11/2019 for SMC-4196.

if(isset($_GET['d_id'])=='' && $_GET['d_code']=='')
{
if (isset($_POST['submit'])) {
    $dept_code = $_POST['dept_code'];
    $dept_name = $_POST['dept_name'];
    $year = $_POST['year'];
    $department_id = $_POST['department_id'];
    $FaxNo = $_POST['FaxNo'];
    $email_id = $_POST['email_id'];
    $isenable = $_POST['isenable'];
    $phone_no = $_POST['phone_no'];
    $landline = $_POST['landline'];

    if ($_POST['dept_code'] != '') {
        
        $query= "select * from registration WHERE ExtDeptId=='$department_id'";
                    $query_run = mysqli_query($conn,$query);
                    
                    if(mysqli_num_rows($query_run)>0)
                    {
                        // there is already a user with the same username
                        echo '<script type="text/javascript"> alert("User already exists.. try another username") </script>';
                    }
        $sql = mysql_query("select  Dept_code,ExtDeptId from tbl_department_master where school_id='$sc_id' and (Dept_code='$dept_code'
        or ExtDeptId='$department_id')");
        $result = mysql_num_rows($sql);
        
        $res=mysql_fetch_array($sql);
        if ($result == 0) {
            $query = mysql_query("insert into tbl_department_master (PhoneNo,Dept_code,Dept_Name,Establiment_Year,ExtDeptId,`Fax_No`,Email_Id,School_ID,Is_Enabled,landline) values('$phone_no','$dept_code','$dept_name','$year','$department_id','$FaxNo','$email_id','$sc_id','$isenable','$landline')");
           // $successreport = "$dept_name is successfully Inserted";
           echo ("<script LANGUAGE='JavaScript'>
                    window.alert('$dept_name is successfully Inserted');
                    window.location.href='list_school_department.php';
                    </script>");

        } else {
            if ($res['Dept_code']==$dept_code)
        {
            
            $errorreport = "$dept_code Department Code is already exists";
        }
        if ($res['ExtDeptId']==$department_id)
        {
            $errorreport = "$department_id Department ID is already exists";
        }
        
    }} else {
        $errorreport = "Department Code is must";
    }
    if($errorreport!=''){
        echo ("<script LANGUAGE='JavaScript'>
                    alert('".$errorreport."');
                    </script>");
    }
}
?>
<html>
<head>
   <script  src="http://code.jquery.com/jquery-3.2.1.min.js"  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
            <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.js"></script>
            <script type="text/javascript">
function valid() {  
var dept_name = document.getElementById("dept_name").value;
        var pattern = /^[a-zA-Z0-9-_ ]+$/;
        
        //Changes done by Pranali on 21-06-2018 for bug SMC-2895

        if(dept_name.trim()=="" || dept_name.trim()==null){
        alert("Enter Department Name!");
        return false;
        }
        else if (pattern.test(dept_name)) {
           
        }
        else
        {
            alert("Enter valid Department Name!");
            return false;
        }

var dept_code = document.getElementById("dept_code").value;
        var pattern = /^[a-zA-Z0-9-_ ]+$/;

        if(dept_code.trim()=="" || dept_code.trim()==null){
        alert("Enter Department Code!");
        return false;
        }
       else if (pattern.test(dept_code)) {
           
        }
        else{
        alert("Enter valid Department Code!");
        return false;
        }

        var estyear=document.getElementById("year");
           

        
var phone_no = document.getElementById("phone_no").value;
        var pattern = /^[6789]\d{9}$/;
        if(phone_no.trim()=="" || phone_no.trim()==null){
       
        }
       else if (pattern.test(phone_no)) {
           
        }
        else{
        alert("Enter valid Phone Number!");
        return false;
        }

        
var landline = document.getElementById("landline").value;
        var pattern = /^[0-9-]+$/;
        if(landline.trim()=="" || landline.trim()==null){
       
        }
       else if (pattern.test(landline)) {
           
        }
        else{
        alert("Enter valid Landline Number!");
        return false;
        }

        
var department_id = document.getElementById("department_id").value;
        var pattern = /^[a-zA-Z0-9-_ ]+$/;
        
        if(department_id.trim()=="" || department_id.trim()==null){
        alert("Enter Department ID!");
        return false;
        }
        
        if (pattern.test(department_id)) {
           
        }
        else{
        alert("Enter valid Department ID!");
        return false;
        }
                    
        
var email_id = document.getElementById("email_id").value;
        var pattern = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
       
     if(email_id.trim()=="" || email_id.trim()==null){
       
        }
       else if (pattern.test(email_id)) {
           
        }
        else{
        alert("Enter valid Email ID!");
        return false;
        }



}   

 
</script>
</head>

<body bgcolor="#CCCCCC">
<div style="bgcolor:#CCCCCC">
    <div>
    </div>
    <div class="container" style="padding:25px;">
        <div style="padding:2px 2px 2px 2px;border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4; background-color:#F8F8F8 ;">
            <h2 style="padding-top:30px;">
                <center>Add Department</center>
            </h2>

            <form method="post">
                <div class="row" style="padding-top:30px;">
                    <div class="col-md-4"></div>
                    <div class="col-md-3" style="color:#808080; font-size:18px;">Department Name <span style="color:red;font-size: 25px;">*</span></div>

                    <div class="col-md-3">
                       <!-- Changes done by Pranali on 26-06-2018 for bug SMC-2895-->

                        <input type="text" style="padding-right: 25;margin-left: -95;" class="form-control" name="dept_name" id="dept_name" placeholder="Enter Department Name"
                               value="<?php if (isset ($_POST['dept_name'])) {
                                   echo $_POST['dept_name'];
                               } ?>">
                              <!-- Changes end-->

                    </div>
                
                    </div>
                <div class="row">
                    <div class="col-md-3 " id="errordept" style="color:#F00; text-align: center;"></div>
                </div>

                <div class="row" style="padding-top:30px;">
                    <div class="col-md-4"></div>

                    <div class="col-md-2" style="color:#808080; font-size:18px;">Department Code <span style="color:red;font-size: 25px;">*</span></div>

                    <div class="col-md-3">
                        <input type="text" class="form-control" name="dept_code" id="dept_code" placeholder="Enter Department Code"
                               value="<?php if (isset ($_POST['dept_code'])) {
                                   echo $_POST['dept_code'];
                               } ?>">
                    </div>
                    
                    <div class="col-md-3 col-md-offset-6" style="color:#FF0000; text-align: center;"><?php echo $report1; ?></div>
                </div>
            <!--    
                 <div class="row" style="padding-top:30px;">
                <div class="col-md-4"></div>
                <div class="col-md-2" style="color:#808080; font-size:18px;"> course level<span
                            style="color:red;font-size: 25px;">*</span></div>
                <div class="col-md-3">
                    <select name="course_level" class="form-control" required>
                        <option value="" disabled selected> Select Course Level</option>
                        <?php
                      //  $sql = "SELECT * FROM `tbl_degree_master` WHERE `school_id`='$sc_id'";
                      //  $query = mysql_query($sql);
                      //  while ($rows = mysql_fetch_assoc($query)) { ?>
                            <option value="<?php //echo $rows['CourseLevel']; ?>" <?php// if($rows['CourseLevel']==$course_level){ echo "selected";}else{}?>><?php //echo $rows['CourseLevel'];?></option>
                        <?php //} ?>
                    </select>
                </div>
            </div>
            --> 
                <div class="row">
                    <div class="col-md-2 col-md-offset-6" id="errordeptcode" style="color:#F00;text-align: center;"></div>
                </div>

                <div class="row" style="padding-top:30px;">
                    <div class="col-md-4"></div>
                    <div class="col-md-2" style="color:#808080; font-size:18px;">Establishment Year</div>
                    <?php $date = date('Y'); ?>
                    <div class="col-md-3">
                        <select name="year" class="form-control" id="year">
                            <option value="">Select Year</option>
                            <?php
                            for ($i = $date; $i > 1900; $i--) {
                                ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-2 col-md-offset-6" id="erroryear" style="color:#F00;"></div>
                </div>

                <div class="row" style="padding-top:30px;"><div class="col-md-4"></div>
                    <div class="col-md-2" style="color:#808080; font-size:18px;">Phone no</div>
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="phone_no" id="phone_no" placeholder="Enter Phone No."
                               value="<?php if (isset ($_POST['phone_no'])) {
                                   echo $_POST['phone_no'];
                               } ?>">
                    </div>
                </div>
                <!--Landline field added by Rutuja as discussed with Tapan for SMC-4909 on 24-10-2020-->
                <div class="row" style="padding-top:30px;"><div class="col-md-4"></div>
                    <div class="col-md-2" style="color:#808080; font-size:18px;">Landline No </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="landline" id="landline" placeholder="Enter Landline No."
                               value="<?php if (isset ($_POST['landline'])) {
                                   echo $_POST['landline'];
                               } ?>">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-2 col-md-offset-6" id="errorphone" style="color:#F00;"></div>
                </div>


                <div class="row" style="padding-top:30px;">
                    <div class="col-md-4"></div>

                    <div class="col-md-2" style="color:#808080; font-size:18px;">Department ID<span style="color:red;font-size: 25px;">*</span></div>
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="department_id" id="department_id" placeholder="Enter Department ID"
                               value="<?php if (isset ($_POST['department_id'])) {
                                   echo $_POST['department_id'];
                               } ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-md-offset-6" id="errordepartment_id" style="color:#F00;"></div>
                </div>

                <div class="row" style="padding-top:30px;"><div class="col-md-4"></div>
                <div class="col-md-2" style="color:#808080; font-size:18px;">Fax no</div>

                    <div class="col-md-3">
                        <input type="text" class="form-control" name="FaxNo" id="FaxNo"
                               value="<?php if (isset ($_POST['FaxNo'])) {
                                   echo $_POST['FaxNo'];
                               } ?>">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-2 col-md-offset-6" id="errorFaxNo" style="color:#F00;"></div>
                </div>


                <div class="row" style="padding-top:30px;">
                    <div class="col-md-4"></div>
                    <div class="col-md-2" style="color:#808080; font-size:18px;">Email ID </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="email_id" id="email_id" placeholder="Enter Email ID"
                               value="<?php if (isset ($_POST['email_id'])) {
                                   echo $_POST['email_id'];
                               } ?>">
                    </div>
                  </div>
<!--Added checked for yes option for setting it by default value of Is Enabled field by Pranali for SMC-5154-->
                <div class="col-md-4"></div>
                <div class="row" style="padding-top:10px;">
                    <div class="col-md-4"></div>
                    <div class="col-md-2" style="color:#808080; font-size:18px;">Is Enabled</div>
                    <div class="col-md-3">Yes&nbsp;&nbsp; <input type="radio" name="isenable" id="isenable1" class="isenable" value="1" checked> &nbsp;&nbsp;No&nbsp;
                        &nbsp;&nbsp;<input type="radio" name="isenable" id="isenable2" class="isenable" value="0">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-2 col-md-offset-5" id="error_is_enable" style="color:#F00;"></div>
                </div>


                <div class="row" style="padding-top:60px;">
                    <div class="col-md-5"></div>
                    <div class="col-md-1"><input type="submit" name="submit" value="Save" class="btn btn-success" onClick="return valid()"></div>
                    <div><a href="list_school_department.php" style="text-decoration:none;">
                            <input type="button" class="btn btn-primary" name="Back" value="Back" style="width:80px;font-weight:bold;font-size:14px;"/>
                        </a>
                    </div>
                    <!--<div class="col-md-2"><input type="reset" name="cancel" value="Cancel"  class="btn btn-danger"></div>-->
                </div>

                <div class="row" style="padding-top:30px;">
                    <!-- <center style="color:#FF0000;"><?php // echo $errorreport ?></center> -->
                    <center style="color:#093;"><?php echo $successreport ?></center>
                </div>

            </form>
        </div>
    </div>
</body>

</html>
<?php }else{

if($_SESSION['usertype']=='HR Admin Staff' OR $_SESSION['usertype']=='School Admin Staff')
    {
        $sc_id=$_SESSION['school_id']; 
        $query2 = mysql_query("SELECT DISTINCT id from tbl_school_admin where school_id ='$sc_id'");

    $value2 = mysql_fetch_array($query2);

    $id = $value2['id'];
        
        
    }

$report = "";
$fields = array("id" => $id);
$results = $smartcookie->retrive_individual($table, $fields);
$result1 = mysql_fetch_array($results);
$sc_id = $result1['school_id'];
$d_id = $_GET['d_id'];
$de_code = $_GET['d_code'];

$sql = mysql_query("select * from tbl_department_master where school_id='$sc_id' and id='$d_id'");
if (mysql_num_rows($sql) > 0) 
{
    $result = mysql_fetch_assoc($sql);
    $de_id=$result['ExtDeptId'];
}
    
//echo $d_id;die;
//$result = "";
if (isset($_POST['submit'])) {
    $d_name = $_POST['dept_name'];
    $d_code = $_POST['dept_code'];
    $year = $_POST['year'];
    $phone_no = $_POST['phone_no'];
    $landline = $_POST['landline'];
     $dept_id = $_POST['dept_id'];
    //$department_id = $_POST['department_id'];
    $FaxNo = $_POST['FaxNo'];
    $email = $_POST['email_id'];
    $isenable = $_POST['isenable'];
//echo phone_no;
if(($de_code == $d_code)&& ($dept_id==$de_id) )
{
    
    $sql4 = "UPDATE `tbl_department_master` SET Dept_Name='$d_name', Dept_code='$d_code',Establiment_Year='$year',PhoneNo='$phone_no',ExtDeptId='$dept_id',Fax_No='$FaxNo', Email_Id='$email',Is_Enabled='$isenable', landline='$landline' WHERE id='$d_id'";
    //echo "<script>alert('123') </script>";
}
else
{
$sql1 = mysql_query("SELECT * from tbl_department_master where school_id='$sc_id' and id!='$d_id' and (Dept_code='$d_code'or ExtDeptId='$dept_id')");

if (mysql_num_rows($sql1) > 0) {
    echo "<script>alert('Record already present') </script>";
}
else
{
    $sql4 = "UPDATE `tbl_department_master` SET Dept_Name='$d_name', Dept_code='$d_code',Establiment_Year='$year',PhoneNo='$phone_no',ExtDeptId='$dept_id',Fax_No='$FaxNo', Email_Id='$email', landline='$landline' WHERE id='$d_id'";
}
}
    //$sql = "UPDATE `tbl_department_master` SET Dept_Name='$d_name', Dept_code='$d_code',PhoneNo='$phone_no',Fax_No='$FaxNo', Email_Id='$email' WHERE id='$d_id'";
   // echo "UPDATE `tbl_department_master` SET Dept_Name='$d_name', Dept_code='$d_code',PhoneNo='$phone_no',ExtDeptId='$department_id',Fax_No='$FaxNo', Email_Id='$email' WHERE id='$d_id'";
    if($sql4!='')
    {
    $r = mysql_query($sql4);
    if (mysql_affected_rows() > 0) {
        
        echo ("<script LANGUAGE='JavaScript'>
                    alert('Record Updated Successfully..!!');
                    window.location.href='list_school_department.php';
                    </script>");
    } else {
        echo "<script>alert('There is no change while updating record') </script>";
    }
    }
    
}

?>

<body bgcolor="#CCCCCC">
<div style="bgcolor:#CCCCCC">
    <div>
    </div>
    <div class="container" style="padding:25px;">
        <div style="padding:2px 2px 2px 2px;border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4; background-color:#F8F8F8 ;">
            <h2 style="padding-top:30px;">
                <center>Edit Department</center>
            </h2>
            <form method="post">
                <div class="row" style="padding-top:50px;">
                    <div class="col-md-4"></div>
                    <div class="col-md-2" style="color:#808080; font-size:18px;">Department Name<b style="color:red;">*</b></div>
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="dept_name" id="dept_name" value="<?php echo $result['Dept_Name'] ?>">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 col-md-offset-5" id="errordept" style="color:#F00;"></div>
                </div>


                <div class="row" style="padding-top:30px;">
                    <div class="col-md-4"></div>
                    <div class="col-md-2" style="color:#808080; font-size:18px;">Department Code<b style="color:red;">*</b></div>
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="dept_code" id="dept_code" value="<?php echo $result['Dept_code'] ?>">
                    </div>
                    <div class="col-md-3" style="color:#FF0000;"><?php echo $report1; ?></div>
                </div>

                <div class="row">
                    <div class="col-md-2 col-md-offset-5" id="errordeptcode" style="color:#F00;"></div>
                </div>

                <?php // Establiment_Year added by Rutuja Jori on 08/08/2019 for making add & edit forms same
                ?>
                <div class="row" style="padding-top:30px;">
                    <div class="col-md-4"></div>
                    <div class="col-md-2" style="color:#808080; font-size:18px;">Establishment Year</div>
                    <?php $date = date('Y'); ?>
                    <div class="col-md-3">
                        <select name="year" class="form-control"  id="year" >
                            <option value="<?php 
                            echo $result['Establiment_Year'];
                               ?>"><?php 
                            echo $result['Establiment_Year'];
                               ?></option>
                            <?php
                            for ($i = $date; $i > 1900; $i--) {
                                ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php }
                            ?>
                        </select>
                    </div>
                </div>
                
                <div class="row" style="padding-top:30px;"><div class="col-md-4"></div>
                    <div class="col-md-2" style="color:#808080; font-size:18px;">Phone no</div>
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="phone_no" id="phone_no"
                               value="<?php if (isset ($result['Dept_code'])) {
                                   echo $result['PhoneNo'];
                               } ?>">
                    </div>
                </div>

                <!--Landline field added by Rutuja as discussed with Tapan for SMC-4909 on 24-10-2020-->
                <div class="row" style="padding-top:30px;"><div class="col-md-4"></div>
                    <div class="col-md-2" style="color:#808080; font-size:18px;">Landline No</div>
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="landline" id="landline" placeholder="Enter Landline No." value="<?php if (isset ($result['Dept_code'])) {
                                   echo $result['landline'];
                               } ?>">
                    </div>
                </div>
                
                
                <div class="row" style="padding-top:50px;">
                    <div class="col-md-4"></div>
                    <div class="col-md-2" style="color:#808080; font-size:18px;">Department ID<b style="color:red;">*</b></div>
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="dept_id" id="dept_id" value="<?php if (isset ($result['ExtDeptId'])) {
                                   echo $result['ExtDeptId'];
                               } ?>">
                    </div>
                </div>

                

                
                

                <div class="row">
                    <div class="col-md-2 col-md-offset-6" id="errorphone" style="color:#F00;"></div>
                </div>

              <!--  <div class="row" style="padding-top:30px;">
                    <div class="col-md-4"></div>

                    <div class="col-md-2" style="color:#808080; font-size:18px;">Department id</span></div>
                    <div class="col-md-3">
                        <input type="hidden" class="form-control" name="department_id" id="department_id"
                               value="<?php if (isset ($result['ExtDeptId'])) {
                                   echo $result['ExtDeptId'];
                               } ?>">
                    </div>
                </div> -->
                <div class="row">
                    <div class="col-md-3 col-md-offset-6" id="errordepartment_id" style="color:#F00;"></div>
                </div>

                <div class="row" style="padding-top:30px;"><div class="col-md-4"></div>
                    <div class="col-md-2" style="color:#808080; font-size:18px;">Fax no</div>

                    <div class="col-md-3">
                        <input type="text" class="form-control" name="FaxNo" id="FaxNo"
                               value="<?php if (isset ($result['Fax_No'])) {
                                   echo $result['Fax_No'];
                               } ?>">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-2 col-md-offset-6" id="errorFaxNo" style="color:#F00;"></div>
                </div>

                <div class="row" style="padding-top:30px;">
                    <div class="col-md-4"></div>
                    <div class="col-md-2" style="color:#808080; font-size:18px;">Email ID</div>

                    <div class="col-md-3">
                        <input type="text" class="form-control" name="email_id" id="email_id" value="<?php echo $result['Email_Id'] ?>">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-2 col-md-offset-5" id="erroremail" style="color:#F00;"></div>
                </div>

                <div class="col-md-4"></div>
                <div class="row" style="padding-top:10px;">
                    <div class="col-md-4"></div>
                    <div class="col-md-2" style="color:#808080; font-size:18px;">Is Enabled</div>
                    <div class="col-md-3">Yes&nbsp;&nbsp; <input type="radio" name="isenable" id="isenable1" class="isenable" value="1" <?php echo ($result['Is_Enabled']=='1')?'checked':'' ?>> &nbsp;&nbsp;No&nbsp;
                        &nbsp;&nbsp;<input type="radio" name="isenable" id="isenable2" class="isenable" value="0" <?php echo ($result['Is_Enabled']=='0
                        ')?'checked':'' ?> >
                    </div>
                </div>

                <div class="row" style="padding-top:60px;">
                    <div class="col-md-5"></div>
                    <div class="col-md-1"><input type="submit" name="submit" value="Update"  class="btn btn-success"  onClick="return valid()"></div>
                  
                <div class="col-md-1"><a href="list_school_department.php"><input type="button" value="Back" class="btn btn-danger"></a></div>

                    <!--<div class="col-md-2"><input type="reset" name="cancel" value="Cancel"  class="btn btn-danger"></div>-->
                </div>


                <div class="row" style="padding-top:30px;">
                    <center style="color:#006600;"><?php echo $errorreport ?></center>
                    <center style="color:#093;"><?php echo $successreport ?></center>
                </div>


            </form>

        </div>
    </div>
</body>
</html>
<script  src="http://code.jquery.com/jquery-3.2.1.min.js"  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
            <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.js"></script>
            <script type="text/javascript">
function valid() {
var dept_name = document.getElementById("dept_name").value;
        var pattern = /^[a-zA-Z0-9-_ ]+$/;
        if(dept_name.trim()=="" ||dept_name.trim()==null)
        {
            alert("Enter Department Name!");
            return false;
        }
        if (pattern.test(dept_name)) {
           // alert("Your your name is : " + name);
           // return true;
        }
        else{
        alert("It is not valid Department Name!");
        return false;
        }

var dept_code = document.getElementById("dept_code").value;
        var pattern = /^[a-zA-Z0-9-_ ]+$/;
        if(dept_code.trim()=="" || dept_code.trim()==null)
        {
            alert("Enter valid Department Code!");
        return false;
        }
        if (pattern.test(dept_code)) {
           // alert("Your your name is : " + name);
           // return true;
        }
        else{
        alert("It is not valid Department Code!");
        return false;
        }
        
var phone_no = document.getElementById("phone_no").value;
        var pattern = /^[6789]\d{9}$/;
        if(phone_no.trim()=="" || phone_no.trim()==null){
       
        }
       else if (pattern.test(phone_no)) {
           
        }
        else{
        alert("Enter valid Phone Number!");
        return false;
        }

var landline = document.getElementById("landline").value;
        var pattern = /^[0-9-]+$/;
        if(landline.trim()=="" || landline.trim()==null){
       
        }
       else if (pattern.test(landline)) {
           
        }
        else{
        alert("Enter valid Landline Number!");
        return false;
        }   
        
var email_id = document.getElementById("email_id").value;
        var pattern = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
        if(email_id.trim()=="" || email_id.trim()==null){
       
        }
       else if (pattern.test(email_id)) {
           
        }
        else{
        alert("Enter valid Email ID!");
        return false;
        }
        
}                               
    </script>   



<?php } ?>