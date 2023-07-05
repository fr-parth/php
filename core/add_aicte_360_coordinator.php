<?php
//Created by Kaushlya on 15/02/2022 for SMC-5603
if (isset($_GET["name"])) {
    include "school_staff_header.php";
    $table = "tbl_school_adminstaff";
} else {
    include "scadmin_header.php";
    $table = "tbl_school_admin";
}
$sc_id = $_SESSION["school_id"];
$AcademicYear = $_SESSION["AcademicYear"];

$query = mysql_query(
    "select coordinator_id,CountryCode from tbl_school_admin where school_id='$sc_id'"
);

if (mysql_num_rows($query) >= 1) {
    $value1 = mysql_fetch_assoc($query);
    $coordinator_id = $value1["coordinator_id"];
    $countrycode = $value1["CountryCode"];
}
if (isset($_POST["submit"])) {
    $currentdate = date('Y-m-d H:i:s');
    $permision='Leaderboard,Master,Points,Points Status,Sponsor Map,purchesC,schooladminprofile.php,Logs,Report,Search,school_admin_analytics.php,sd_upload_panel.php,scadmin_point_summary.php,data_quality.php,Single File Upload,TeacherListFeed360.php,School Average Points Distributions,Statistics,Dashboard,student_blog,AICTE_info,Download Data,Update record,TeacherLeader,StudLeader,Activities,AddCount,year,Activity,SubActivity,Branch,BrSubjects,Class,CSub,Course,create,Degree,Departments,Division,Designation,Generate_Student_Subject_Master,Parents,Rewards Rule Engine,School Master,access,School Admin Staff Access,School Rule Engine,Semester,sms,Student1,Student Recognition,StuSem,SSub,Subject1,Teacher1,TSub,ThanQ,Add AICTE 360 Coordinator,My Groups,Department Admin,Distribution,Reward,TGP1,Teacher Green Point,Gpc1,Bpc2,Wpc2,TGP1,TGP1,purchase_point_log.php,TGP1,TGP1,TGP1,S2gp,Sponsor1,Teacher Blue Point,Teacher Green Point,status,actLog,Recalculate,Gaming_Point_Log,student_brown_point_log,teacher_brown_point_log,teacher_login_Detatils,student_login_Details,Send Email Log,Send SMS Log,BM,DT,SR1,SSR,TR1,TSR,DLS,BM,SS,ss,Student Reward,Teacher Reward,Something New,Student Subjects,Teacher Subjects,Student,Teachers,Single File Upload Pannel,Download Error Report,BM,TSR,ISD,student_data,teacher_data,branch_data,class_data,degree_data,department_data,semester_data,nonteach_data,subject_data,student_subject_data,teacher_subject_data';
    $r = $_POST["reporting_id"];
    $b = explode(",", $r);
    $reporting_id = $b[0];
    $reporting_name = $b[1];
    $t_id = $_POST["t_id"];
    $sql = mysql_query("select coordinator_id from tbl_school_admin where school_id='$sc_id' and coordinator_id!='' and coordinator_id is not null ");
    $count = mysql_num_rows($sql);
    $val1 = mysql_fetch_assoc($sql);
    $t_id_previous = $val1["coordinator_id"];

    $sql = mysql_query("SELECT id,t_id,school_id,t_exprience,t_designation,t_address,t_country,t_city,state,t_dob,t_age,t_gender,t_email,t_phone,t_qualification,t_password,t_current_school_name,CountryCode,group_member_id,(CASE WHEN t_complete_name='' THEN CONCAT_WS(' ', t_name, t_middlename,t_lastname) ELSE t_complete_name END) as teacher_name 
        FROM tbl_teacher WHERE school_id='$sc_id' AND t_id='$reporting_id'");
    $t = mysql_fetch_assoc($sql);
    $name = $t['teacher_name'];
    $email = $t['t_email'];
    $countrycode= $t['CountryCode'];
    $phone = $t['t_phone'];
    $designation = $t['t_designation'];
    $gender = $t['t_gender'];

    if ($count >= 1) {
        if ($reporting_id != $t_id_previous && $t_id != "") { 
                
               
                    $id_first_name = $_POST["id_first_name"];
                    $id_middle_name = $_POST["id_middle_name"];
                    $id_last_name = $_POST["id_last_name"];
                    $name = $id_first_name . " " . $id_middle_name. " " . $id_last_name;
                    $email = $_POST["id_email"];
                    $countrycode = $_POST["calling_code"];
                    $phone = $_POST["phone"];
                    $gender = $_POST["gender"];
                    $employee1= $_POST['id_employee'];
                    $employee2 = explode (",", $employee1); 
                    $employee = $employee2[0];
                    $designation   = $employee2[1];
                        ?>
            <script LANGUAGE='JavaScript'>
                var r=  window.confirm(' AICTE 360 Coordinator already exists...Do you want to change the AICTE 360 Coordinator??');
            <?php $var = "<script>document.write(r)</script>"; ?>             
        </script>

        <?php 
       
            if ($var == true) {
                if ($t_id != "") {
                    $query = mysql_query("update tbl_school_admin set coordinator_id='$t_id' where school_id = '$sc_id'");
                    $sqls = "INSERT INTO `tbl_teacher`(t_complete_name, t_name, t_middlename, t_lastname, school_id,t_id,t_academic_year, t_email,CountryCode,t_phone,t_password,t_emp_type_pid,t_gender,t_designation) 
                    VALUES ('$name', '$id_first_name', '$id_middle_name', '$id_last_name', '$sc_id','$t_id','$AcademicYear', '$email', '$countrycode','$phone','$t_id','$employee','$gender','$designation')";
                    $count = mysql_query($sqls);

                    $add_staff = mysql_query("INSERT INTO tbl_school_adminstaff(stf_name,school_id,email,CountryCode,phone,pass,delete_flag,designation,gender) 
			        VALUES ('$name','$sc_id','$email','$countrycode','$phone','$t_id','0','$designation','$gender')");
                    $schoolStaff=mysql_query("SELECT id from tbl_school_adminstaff order by id desc LIMIT 1");
                    $schoolStaff_res=mysql_fetch_array($schoolStaff);
                    $stff_id=$schoolStaff_res['id'];
                    $sql="INSERT INTO `tbl_permission` (`school_id`, `s_a_st_id`, `cookie_admin_staff_id`,`school_staff_name`, `cookie_staff_name`, `permission`, `current_date`) 
                    VALUES ('$sc_id','$stff_id',NULL,'$name',NULL, '$permision', '$currentdate')";
                    $rs=mysql_query($sql);
                }
                    else {
                        $update1 = "update tbl_school_admin set coordinator_id='$reporting_id' where school_id = '$sc_id'";
                        $q1 = mysql_query($update1);

                        $sql = mysql_query("SELECT id,t_id,school_id,t_exprience,t_designation,t_address,t_country,t_city,state,t_dob,t_age,t_gender,t_email,t_phone,t_qualification,t_password,t_current_school_name,CountryCode,group_member_id,(CASE WHEN t_complete_name='' THEN CONCAT_WS(' ', t_name, t_middlename,t_lastname) ELSE t_complete_name END) as teacher_name 
		                    FROM tbl_teacher WHERE school_id='$sc_id' AND t_id='$reporting_id'");
	                    $t = mysql_fetch_assoc($sql);
                        $name = $t['teacher_name'];
                        $email = $t['t_email'];
                        $countrycode= $t['CountryCode'];
                        $phone = $t['t_phone'];
                        $designation = $t['t_designation'];
                        $gender = $t['t_gender'];

                        $add_staff = mysql_query("INSERT INTO tbl_school_adminstaff(stf_name,school_id,email,CountryCode,phone,pass,delete_flag,designation,gender) 
                        VALUES ('$name','$sc_id','$email','$countrycode','$phone','$reporting_id','0','$designation','$gender')");
                        $schoolStaff=mysql_query("SELECT id from tbl_school_adminstaff order by id desc LIMIT 1");
                        $schoolStaff_res=mysql_fetch_array($schoolStaff);
                        $stff_id=$schoolStaff_res['id'];
                        $sql="INSERT INTO `tbl_permission` (`school_id`, `s_a_st_id`, `cookie_admin_staff_id`,`school_staff_name`, `cookie_staff_name`, `permission`, `current_date`) 
                        VALUES ('$sc_id','$stff_id',NULL,'$name',NULL, '$permision', '$currentdate')";
                        $rs=mysql_query($sql);
                     }
                     echo "<script LANGUAGE='JavaScript'>
                     window.alert('Updated Successfully...');
                     window.location.href='add_aicte_360_coordinator.php';
                     </script>";
                } 
               
             else {
                echo "<script LANGUAGE='JavaScript'>
                    window.alert('No change...');
                    window.location.href='add_aicte_360_coordinator.php';
                    </script>";
             }
            
        } 
        elseif($reporting_id != $t_id_previous && $reporting_id != ""){ ?>
            <script LANGUAGE='JavaScript'>
            var r=  window.confirm(' AICTE 360 Coordinator already exists...Do you want to change the AICTE 360 Coordinator??');
        <?php $var = "<script>document.write(r)</script>"; ?>  
    </script>

    <?php 
        if ($var == true) {
                $query = mysql_query("update tbl_school_admin set coordinator_id='$reporting_id' where school_id = '$sc_id'");
                
                $sql = mysql_query("SELECT id,t_id,school_id,t_exprience,t_designation,t_address,t_country,t_city,state,t_dob,t_age,t_gender,t_email,t_phone,t_qualification,t_password,t_current_school_name,CountryCode,group_member_id,(CASE WHEN t_complete_name='' THEN CONCAT_WS(' ', t_name, t_middlename,t_lastname) ELSE t_complete_name END) as teacher_name 
                FROM tbl_teacher WHERE school_id='$sc_id' AND t_id='$reporting_id'");
                $t = mysql_fetch_assoc($sql);
                $name = $t['teacher_name'];
                $email = $t['t_email'];
                $countrycode= $t['CountryCode'];
                $phone = $t['t_phone'];
                $designation = $t['t_designation'];
                $gender = $t['t_gender'];

                $add_staff = mysql_query("INSERT INTO tbl_school_adminstaff(stf_name,school_id,email,CountryCode,phone,pass,delete_flag,designation,gender) 
			    VALUES ('$name','$sc_id','$email','$countrycode','$phone','$reporting_id','0','$designation','$gender')");
                $schoolStaff=mysql_query("SELECT id from tbl_school_adminstaff order by id desc LIMIT 1");
                $schoolStaff_res=mysql_fetch_array($schoolStaff);
                $stff_id=$schoolStaff_res['id'];
                $sql="INSERT INTO `tbl_permission` (`school_id`, `s_a_st_id`, `cookie_admin_staff_id`,`school_staff_name`, `cookie_staff_name`, `permission`, `current_date`) 
                VALUES ('$sc_id','$stff_id',NULL,'$name',NULL, '$permision', '$currentdate')";
                $rs=mysql_query($sql);
                echo "<script LANGUAGE='JavaScript'>
                window.alert('Updated Successfully...');
                window.location.href='add_aicte_360_coordinator.php';
                </script>";  
        }
    }
    
        else {echo "<script LANGUAGE='JavaScript'>
            window.alert('The same record already exists...');
            window.location.href='add_aicte_360_coordinator.php';
            </script>";}
    } else {
        if ($t_id != "") {
            $id_first_name = $_POST["id_first_name"];
            $id_middle_name = $_POST["id_middle_name"];
            $id_last_name = $_POST["id_last_name"];
            $name = $id_first_name . " " . $id_middle_name. " " . $id_last_name;
            $email = $_POST["id_email"];
            $countrycode = $_POST["calling_code"];
            $phone = $_POST["phone"];
            $gender = $_POST["gender"];
            $employee1= $_POST['id_employee'];
            $employee2 = explode (",", $employee1); 
            $employee = $employee2[0];
            $designation   = $employee2[1];
           
            $query = mysql_query("update tbl_school_admin set coordinator_id='$t_id' where school_id = '$sc_id'");
            $sqls = "INSERT INTO `tbl_teacher`(t_complete_name, t_name, t_middlename, t_lastname, school_id,t_id,t_academic_year, t_email,CountryCode,t_phone,t_password,t_emp_type_pid,t_gender,t_designation) 
            VALUES ('$name', '$id_first_name', '$id_middle_name', '$id_last_name', '$sc_id','$t_id','$AcademicYear', '$email', '$countrycode','$phone','$t_id','$employee','$gender','$designation')";
            $count = mysql_query($sqls);

            $add_staff = mysql_query("INSERT INTO tbl_school_adminstaff(stf_name,school_id,email,CountryCode,phone,pass,delete_flag,designation,gender) 
			VALUES ('$name','$sc_id','$email','$countrycode','$phone','$t_id','0','$designation','$gender')");
            $schoolStaff=mysql_query("SELECT id from tbl_school_adminstaff order by id desc LIMIT 1");
            $schoolStaff_res=mysql_fetch_array($schoolStaff);
            $stff_id=$schoolStaff_res['id'];
            $sql="INSERT INTO `tbl_permission` (`school_id`, `s_a_st_id`, `cookie_admin_staff_id`,`school_staff_name`, `cookie_staff_name`, `permission`, `current_date`) 
            VALUES ('$sc_id','$stff_id',NULL,'$name',NULL, '$permision', '$currentdate')";
            $rs=mysql_query($sql);
        } else {
            $query = mysql_query(
                "update tbl_school_admin set coordinator_id='$reporting_id' where school_id = '$sc_id'"
            );
            $sql = mysql_query("SELECT id,t_id,school_id,t_exprience,t_designation,t_address,t_country,t_city,state,t_dob,t_age,t_gender,t_email,t_phone,t_qualification,t_password,t_current_school_name,CountryCode,group_member_id,(CASE WHEN t_complete_name='' THEN CONCAT_WS(' ', t_name, t_middlename,t_lastname) ELSE t_complete_name END) as teacher_name 
                FROM tbl_teacher WHERE school_id='$sc_id' AND t_id='$reporting_id'");
                $t = mysql_fetch_assoc($sql);
                $name = $t['teacher_name'];
                $email = $t['t_email'];
                $countrycode= $t['CountryCode'];
                $phone = $t['t_phone'];
                $designation = $t['t_designation'];
                $gender = $t['t_gender'];

            $add_staff = mysql_query("INSERT INTO tbl_school_adminstaff(stf_name,school_id,email,CountryCode,phone,pass,delete_flag,designation,gender) 
			VALUES ('$name','$sc_id','$email','$countrycode','$phone','$reporting_id','0','$designation','$gender')");
            $schoolStaff=mysql_query("SELECT id from tbl_school_adminstaff order by id desc LIMIT 1");
            $schoolStaff_res=mysql_fetch_array($schoolStaff);
            $stff_id=$schoolStaff_res['id'];
            $sql="INSERT INTO `tbl_permission` (`school_id`, `s_a_st_id`, `cookie_admin_staff_id`,`school_staff_name`, `cookie_staff_name`, `permission`, `current_date`) 
            VALUES ('$sc_id','$stff_id',NULL,'$name',NULL, '$permision', '$currentdate')";
            $rs=mysql_query($sql); 
        }
        echo "<script LANGUAGE='JavaScript'>
                    window.alert('AICTE 360 Coordinator is successfully Inserted');
                    window.location.href='scadmin_dashboard.php';
                    </script>";
    }
}
?>
<!DOCTYPE html>
<head>
<link rel="stylesheet" type="text/css" href="./css/jquery.dataTables.css">
    <script src="./js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
 
 
 
function valid() {  
    var reporting_id = document.getElementById("reporting_id").value;
    if (reporting_id === "-1") {
        alert('Please Select Coordinator');
        return false;
    }
   //alert(reporting_id);
  if (reporting_id === "Other") 
{
    var calling_code = document.getElementById("calling_code").value;
    if (calling_code == "-1") {
        alert('Please Select country code');
        return false;
    } 
    
    var id_email = document.getElementById("id_email").value;
    var pattern = /^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,4})$/;
    
    if (id_email=="") {
            alert("Please enter Email ID");
            return false;  
    }
    
    if (!pattern.test(id_email)) {
            alert("It is not valid Email id!");
            return false;  
    }
    
    var phone = document.getElementById("id_phone").value;
    var pattern = /^[6789]\d{9}$/;
    
    if (!pattern.test(phone)) {
        alert("Please enter 10 digits number!");
        return false;
    }
    
    var first_name = document.getElementById("id_first_name").value;
    regx1=/^[A-Za-z\s]+$/;
    if(!regx1.test(first_name)  )
    {
    alert('Please Enter valid First Name');
        return false;
    }
    var last_name = document.getElementById("id_last_name").value;
    if(!regx1.test(last_name)  )
    {
    alert('Please Enter valid Last Name');
        return false;
    }
    var employee = document.getElementById("id_employee");
    if (employee.value == "-1") {

        alert("Please select <?php echo $dynamic_teacher;?> Type");
        return false;
    } 
}
else{
   // alert('You have selected '+reporting_id);
}
return true;
}

</script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/js/select2.min.js"></script>
 <script>
   $(document).ready(function(){
     $('.SMCselect2').select2({
    
     });
    });
 </script>
</head>

<body bgcolor="#CCCCCC">
<div style="bgcolor:#CCCCCC">
    <div>
    </div>
    <div class="container" style="padding:25px;">
        <div style="padding:2px 2px 2px 2px;border:1px solid #CCACCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4; background-color:#F8F8F8 ;">
            <h2 style="padding-top:30px;">
                <center>Add AICTE 360 Coordinator</center>
            </h2>
           
            <form class='form-horizontal' role='form' method="post">
                <div class="row" style="padding-top:30px;">
              
                    <div class='form-group'>

                        <label class='control-label col-md-2 col-md-offset-2' style="text-align:left;" >AICTE 360 Coordinator<span ><b style="color: red;"> *</b></span></label>
                        <div class='col-md-6'>
                            <div class='form-group'>
                            
                                <div class='col-md-6'>
                                <select class='form-control SMCselect2' id="reporting_id" name="reporting_id" onchange="changeStatus(this.value);" >
                    
                    <option value="-1"> Select AICTE 360 Coordinator</option>
                    <?php $arr = mysql_query(
                        "select t_id, t_complete_name from tbl_teacher where school_id='$sc_id'"
                    ); ?>
                          
                          <?php while ($row = mysql_fetch_array($arr)) { ?>
                          <option value="<?php echo $row["t_id"] ."," . $row["t_complete_name"]; ?>" <?php if (
                              $row["t_id"] == $coordinator_id) { ?> selected="selected" <?php } ?> > 
                          <?php echo $row["t_complete_name"] ."(" .$row["t_id"] .")"; ?></option><?php } ?>
                          <option value="Other"> New Teacher </option>
                    </select>
                                </div>
                            
                            </div>
                        </div>  
                    </div>
                 <div class='form-group'id="lbl1" style="display:none;">
                        <label class='control-label col-md-2 col-md-offset-2' for='id_accomodation' style="text-align:left; ">Teacher ID <span ><b style="color: red;"> *</b></span></label>
                        <div class='col-md-3'>
                            <input type="text" class='form-control t_id' id='t_id' name="t_id" onchange="checktid();" placeholder="Enter Teacher ID" maxlength="30" required>
                        </div>
                        <div class='col-md-3 indent-small' id="errort_id" style="color:#FF0000"></div>
                    </div>
                    
                    
                    <div class='form-group'  id="lbl2" style="display:none;">

                        <label class='control-label col-md-2 col-md-offset-2' style="text-align:left;" >First Name<span ><b style="color: red;"> *</b></span></label>
                        <div class='col-md-6'>
                            <div class='form-group'>
                                <div class='col-md-6'>
                                <input class='form-control col-md-8' id='id_first_name' name='id_first_name' value="<?php echo $id_first_name ?>" placeholder='First Name' type='text' required>
                                </div>
                            </div>
                        </div>  
                    </div>  
                    
                    
                
                    <div class='form-group' id="lbl3" style="display:none;">
                        <label class='control-label col-md-2 col-md-offset-2' style="text-align:left;" >Middle Name</label>
                        <div class='col-md-6'>
                            <div class='form-group'>
                            
                                <div class='col-md-6'>
                                    <input class='form-control col-md-8' id='id_middle_name' name='id_middle_name' value="<?php echo $id_middle_name ?>" placeholder='Middle Name' type='text'>
                                </div>
                               
                            </div>
                        </div>  
                    </div>  
                            
                            
                        <div class='form-group' id="lbl4" style="display:none;">
                        <label class='control-label col-md-2 col-md-offset-2' style="text-align:left;" >Last Name<span><b style="color: red;">*</b></span></label>
                        <div class='col-md-6'>
                            <div class='form-group'>
                            
                                <div class='col-md-6'>
                                    <input class='form-control col-md-8' id='id_last_name' name='id_last_name' value="<?php echo $id_last_name ?>" required placeholder='Last Name' type='text'>
                                </div>
                               
                            </div>
                        </div>  
                    </div>                      
                    <div class='form-group' id="lbl5" style="display:none;">
                        <label class='control-label col-md-2 col-md-offset-2' for='email' style="text-align:left;">Email<span ><b style="color: red;"> *</b></span></label>
                        <div class='col-md-6'>
                            <div class='form-group'>
                            
                                <div class='col-md-6'>
                                    <input class='form-control email_id' id='id_email' name="id_email"  onchange="checkemail();" value="<?php echo $email ?>" required placeholder='E-mail' type='email' maxlength="60">
                                </div>
                                <div class='col-md-3 indent-small' id="erroremail" style="color:#FF0000">
                                </div>
                            </div>
                        </div>  
                    </div>  
                    
                <div class='form-group' id="lbl6" style="display:none;">
                    <label class='control-label col-md-2 col-md-offset-2'  style="text-align:left;" >Country Code<span ><b style="color: red;"> *</b></span></label>
                <div class='col-md-3' style="text-align:left;">
                   <select class='form-control SMCselect2' id='calling_code' name="calling_code" placeholder='Enter Country Code'>
                        <option value="-1"> Select Country Code</option>
                        <?php
                        $sql = mysql_query(
                            "select * from tbl_country where calling_code!=''"
                        );

                        while ($arr = mysql_fetch_array($sql)) { ?>
                            <option value="<?php echo $arr["calling_code"]; ?>" <?php
                             if ( $arr["calling_code"]== $countrycode) { ?> selected="selected" <?php } ?> ><?php echo $arr["calling_code"]; ?></option>
                            <?php }
                        ?>
                    </select>
                </div>
                <div class='col-md-3 indent-small' id="erroremail" style="color:#FF0000"></div>   
                 </div>  
                    
                    <div class='form-group '  id="lbl7" style="display:none;">
                        <label class='control-label col-md-2 col-md-offset-2' for='Mobile no.' style="text-align:left;"  >Mobile No.<span ><b style="color: red;"> *</b></span></label>
                            <div class='col-md-6'>
                                <div class='form-group'>
                                <div class='col-md-6'>
                                    <input class='form-control id_phone' id='id_phone' name="phone" onchange="checkphone();" value="<?php echo $phone ?>"  placeholder='Mobile No'  required length="10" type='text'>
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class='form-group'  id="lbl9" style="display:none;">
                            <label class='control-label col-md-2 col-md-offset-2' style="text-align:left;" ><?php echo $dynamic_teacher;?> Type<span class="error"><b style="color: red;"> *</b></span></label>
                            <div class='col-md-3' style="padding-left:20px;">
                                <select class='multiselect  form-control' id='id_employee' name="id_employee" >
                                    <option value='-1'>Select</option>
                                    <option value='137,Principal'>Principal</option>
                                    <option value='135,HOD'>HOD</option>
                                    <option value='134,Teacher'>Teacher</option>

                                </select>
                            </div>
                        </div>
                    <div class='form-group'  id="lbl8" style="display:none;">
                        <label class='control-label col-md-2 col-md-offset-2' for='id_pets' style="text-align:left;"  >Gender<span ><b style="color: red;"> *</b></span></label>
                        <div class='col-md-2' style="font-weight: 600;color: #777;">
                            <input type="radio"name="gender" id="gender1" value="Male" checked>Male
                        </div>
                        <div class='col-md-3' style="font-weight: 600;color: #777;" >
                            <input type="radio" name="gender" id="gender2" value="Female">Female
                        </div>
                        <div class='col-md-2 indent-small' id="errorgender" style="color:#FF0000">
                        </div>
                    </div>

                    <div class='form-group row'>
                        <div class='col-md-2 col-md-offset-4'>
                            <input class='btn-lg btn-primary' type='submit' value="  Add  " name="submit" id="submit"  onClick="return valid()"  style="padding:5px;"/>
                        </div>
                        <div class='col-md-1 '>
                            <a href="scadmin_dashboard.php" style="text-decoration:none;">
                                <input class='btn-lg btn-danger' type='button' value=" Back " name="back" style="padding:5px;"/>
                            </a>
                        </div>
                    </div>  
                    
                </div>
            </form>
        </div>
    </div>
</body>


<script>
    function checkemail(){
    var email=$('.email_id').val();
    console.log(email);

    $.ajax({
    type: "POST",
    url:"add_aicte_duplicate_check.php",
    data:{
        'check_email':1,
        'email':email,
    },
    success: function(response){
      if ($.trim(response)){   
        alert(response);
        $('.email_id').val("");
    }
    }
    });
}

function checkphone(){
    var phone=$('.id_phone').val();
    console.log(phone);

    $.ajax({
    type: "POST",
    url:"add_aicte_duplicate_check.php",
    data:{
        'check_phone':1,
        'phone':phone,
    },
    success: function(response){
        if ($.trim(response)){   
        alert(response);
        $('.id_phone').val("");
    } 
    }
    }); 
}
  
function checktid(){
    var t_id=$('.t_id').val();
    console.log(t_id);

    $.ajax({
    type: "POST",
    url:"add_aicte_duplicate_check.php",
    data:{
        'check_tid':1,
        't_id':t_id,
    },
    success: function(response){
        if ($.trim(response)){   
        alert(response);
        $('.t_id').val("");
    }  
    }
    }); 
}
</script>

</html>
                 
<script>
//script to hide field
function changeStatus()
{
    var status = document.getElementById("reporting_id");
    if(status.value=="Other")
    {
        document.getElementById("lbl1").style.display="block";
        document.getElementById("lbl2").style.display="block";
        document.getElementById("lbl3").style.display="block";
        document.getElementById("lbl4").style.display="block";
        document.getElementById("lbl5").style.display="block";
        document.getElementById("lbl6").style.display="block";
        document.getElementById("lbl7").style.display="block";
        document.getElementById("lbl8").style.display="block";
        document.getElementById("lbl9").style.display="block";
    }
    else
    {
        document.getElementById("lbl1").style.display="none";
        document.getElementById("lbl2").style.display="none";
        document.getElementById("lbl3").style.display="none";
        document.getElementById("lbl4").style.display="none";
        document.getElementById("lbl5").style.display="none";
        document.getElementById("lbl6").style.display="none";
        document.getElementById("lbl7").style.display="none";
        document.getElementById("lbl8").style.display="none";
        document.getElementById("lbl9").style.display="none";
        document.getElementById("id_email").required = false;
        document.getElementById("id_phone").required = false;
        document.getElementById("id_last_name").required = false;
        document.getElementById("id_first_name").required = false;
        document.getElementById("t_id").required = false;
        
    }
}
</script>