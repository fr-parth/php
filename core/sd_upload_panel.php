<?php
if(isset($_POST['download'])  || (isset($_GET['download']))){
    if(!empty($_POST['check'])){
    $file = $_POST['table1']."_".$_POST['schl']."_".date('Y-m-d');
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="'.$file.'".csv"');
    $arr=$_POST['csvdata'];
    $arr1=$_POST['csvdata1'];
    $array1=$_POST['check'];
    $array2=$_POST['idvalues'];//idvalues
    foreach($array2 as $row=>$val){
        if(in_array($val,$array1))
        {
        $keyvalues[]=$row;
        }
    }
    foreach($arr1 as $ky=>$st){
        foreach($st as $row=>$val){
            if(in_array($row, $keyvalues)){
                 $lines[$row][$ky] = $val;
            }
        }
      } 
      $fp = fopen('php://output', 'wb');
    fputcsv($fp,$arr,',');
    foreach ($lines as $line)
    {
      fputcsv($fp,$line,',');
    } 
    fclose($fp); 
    exit;
}
else{
    echo "<script>
    window.alert('No Data selected to Export...');
    window.location.href='sd_upload_panel.php';
    </script>";    
}
}
include 'sd_upload_function.php';
include "scadmin_header.php";

$report = "";

$sca = get_school_id($_SESSION['id']);

// $usertype = $_SESSION['usertype'];
// echo $usertype;exit;
// // echo $sca; exit;
// if( $usertype =='Group Admin'){
//  include "group_admin/groupadminheader.php";
//  $school_type = 'school';
//  $user='School Admin';
// }
// else{
//  include "scadmin_header.php";
// }

$sc_country_code = $sca['CountryCode'];
if ($sc_country_code == "") {
    $sc_country_code = "91";
}
$uploaded_by = $sca['name'];

$school_id = $_SESSION['school_id'];

$group_id = $_SESSION['group_member_id'];

$redirect_to = '';





if (isset($_POST['submit'])) {


    if (!empty($_FILES["file"]["name"]) and !empty($_POST['table'])) {






        $table = $_POST['table'];

        $uploaded_by1 = $_POST['uploaded_by'];

        if ($uploaded_by1 != '') {

            $uploaded_by = $uploaded_by1;
        }

        $academic_year = trim($_POST['academic_year']);
        $sem_type = trim($_POST['semester_type']);
        $weightage = trim($_POST['weightage']);



        $upinfo = upload_info($table);

        $display_table_name = $upinfo['display_table_name'];

        $raw_table = $upinfo['raw_table'];
        if ($school_type == 'school' && $user == 'School Admin') {

            $fields = $upinfo['fields'];

            $redirect_to = $upinfo['redirect_to'];

            $filename = $upinfo['filename'];

            $display_fields = $upinfo['display_fields'];
        } else {
            $fields = $upinfo['hr_fields'];

            $redirect_to = $upinfo['redirect_to'];

            $filename = $upinfo['hrfilename'];

            $display_fields = $upinfo['hr_display_fields'];
        }




        $date = date('Y-m-d h:i:s', strtotime('+330 minute'));

        $up_date = date('Y-m-d h:i:s');


        $batch_id = get_last_batchid($school_id);



        $storagename = $_FILES["file"]["name"];

        $file_typ = explode(".", $storagename);

        $file_type = $file_typ[1];







        $storagename = "Importdata/" . $_FILES["file"]["name"];

        if (file_exists($storagename)) {

            unlink($storagename);
        }

        move_uploaded_file($_FILES["file"]["tmp_name"],  $storagename);





        //headers comparison

        $handle = fopen($storagename, "r");

        $first_row = fgetcsv($handle);

        $firstRowTrimmed = array_map('trim', $first_row);

        //Below code is added by Sayali Balkawade for upload downloaded error file on 09/01/2021
        $array_check = array("upload_date", "uploaded_by", "batch_id", "status");

        foreach ($array_check as $stack) {
            if (in_array($stack, $firstRowTrimmed)) {
                $check = "True";
            } else {
                $check = "False";
            }
        }


        $displayFields = explode(",", $display_fields);

        $displayFieldsTrimmed = array_map('trim', $displayFields);



        $equals = strcmp(implode(",", $firstRowTrimmed), implode(",", $displayFieldsTrimmed));
        if ($equals != 0 && $check == 'True') {
            $equal = '0';
        } else {
            $equal = '';
        }


        if ($equal == 0) {

            //insert new batch id   
            //  Add if condition for SMC-4203 By Kunal 
           
            if ($school_type == 'school' && $user == 'School Admin') {
                $qry = "insert into tbl_Batch_Master (batch_id, input_file_name, uploaded_date_time, uploaded_by, entity, school_id, display_table_name, db_table_name,academic_year,semester_type,num_error_count,group_member_id)values ('$batch_id', '$storagename', '$date', '$uploaded_by', '$user', '$school_id', '$display_table_name', '$table', '$academic_year', '$sem_type','0','0')";
               // echo $qry; //exit;
                $sql3 = mysql_query($qry);


                $query = "SELECT * from tbl_school_datastatus where school_id='$school_id' AND academic_year='$academic_year'";
                $sql_check = mysql_query($query);
                $res_cnt = mysql_num_rows($res_cnt);
                if ($res_cnt < 1) {
                    $sql4 = mysql_query("insert into tbl_school_datastatus (school_id, group_id, table_name, weightage, academic_year,upload_date)values('$school_id', '$group_id', '$table', '$weightage', '$academic_year', '$up_date')");
                }
            } else
                {
                $sql3 = mysql_query("insert into tbl_Batch_Master (batch_id, input_file_name, uploaded_date_time, uploaded_by, entity, school_id, display_table_name, db_table_name,num_error_count,group_member_id) values('$batch_id', '$storagename', '$date', '$uploaded_by', '$user', '$school_id', '$display_table_name', '$table','0','0')");
                
            }

            if ($file_type == 'csv') {

                $j = mysql_query("LOCK TABLES $raw_table WRITE;") or die(mysql_error());

                if ($raw_table == "tbl_raw_teacher") {
                    $k = mysql_query("LOAD DATA LOCAL INFILE '$storagename' REPLACE INTO TABLE $raw_table

                                FIELDS TERMINATED BY \",\"

                                ENCLOSED BY '\"'

                                ESCAPED BY '&'

                                LINES TERMINATED BY \"\r\n\"                               

                                IGNORE 1 LINES

                                ( $fields ) 

                            SET status='', upload_date='$date', uploaded_by='$uploaded_by', batch_id='$batch_id', CountryCode='$sc_country_code', validity=''") or die(mysql_error());
                } else if ($raw_table == "tbl_raw_student") {
                    $k = mysql_query("LOAD DATA LOCAL INFILE '$storagename' REPLACE INTO TABLE $raw_table

                                FIELDS TERMINATED BY \",\"

                                ENCLOSED BY '\"'
                                
                                ESCAPED BY '&'

                                LINES TERMINATED BY \"\r\n\"                               

                                IGNORE 1 LINES

                                ( $fields ) 

                            SET status='', upload_date='$date', uploaded_by='$uploaded_by', batch_id='$batch_id', s_country_code='$sc_country_code', validity=''") or die(mysql_error());
                } else {
                    $k = mysql_query("LOAD DATA LOCAL INFILE '$storagename' REPLACE INTO TABLE $raw_table

                                FIELDS TERMINATED BY \",\"

                                ENCLOSED BY '\"'

                                ESCAPED BY '&'

                                LINES TERMINATED BY \"\r\n\"                               

                                IGNORE 1 LINES

                                ( $fields ) 

                            SET status='', upload_date='$date', uploaded_by='$uploaded_by', batch_id='$batch_id', validity=''") or die(mysql_error());
                }
                $l = mysql_query("UNLOCK TABLES;") or die(mysql_error());



                if ($k) {



                    $totrec1 = mysql_query("select count(1) as totrec from " . $raw_table . " where batch_id='$batch_id'");

                    $totrecords = mysql_fetch_array($totrec1);

                    $totrec = $totrecords['totrec'];

                    $upbm = mysql_query("update tbl_Batch_Master set num_records_uploaded='$totrec' where batch_id='$batch_id'") or die(mysql_error());




                    $succesfully =  "<script>

                        alert('Uploaded To Temporary Table, Please go to Batch Upload Status');

                        //window.location='$urlredirect';

                        </script>";
                    echo $succesfully;
                }
            } else {

                $report = "<span style='color:red;'>" . 'Please upload File In MS-DOS .CSV Format' . "</span>";
            }
        } else {

            $report = "<span style='color:red;'>" . 'Please Check Uploaded File, Headers Do Not Match. ' . "</span>";
        }
    } else {

        $report = "<span style='color:red;'>" . 'Please Select A File Or Table Name' . "</span>";
    }
}



if (isset($_POST['dformat'])) {

    $table = $_POST['table'];

    if ($table != '') {

        $upinfo = upload_info($table);

        $display_table_name = $upinfo['display_table_name'];

        $raw_table = $upinfo['raw_table'];

        if ($school_type == 'school' && $user == 'School Admin') {

            $filename = $upinfo['filename'];

            $display_fields = $upinfo['display_fields'];

            $redirect_to = $upinfo['redirect_to'];



            $filename1 = $school_id . "_" . $filename . ".csv";

            $file = fopen($filename1, "w");

            fputcsv($file, explode(',', $display_fields));

            fclose($file);

            echo "<script>window.open('$filename1');</script>";
        } else {


            $filename = $upinfo['hrfilename'];

            $display_fields = $upinfo['hr_display_fields'];

            $redirect_to = $upinfo['redirect_to'];

            $filename1 = $school_id . "_" . $filename . ".csv";

            $file = fopen($filename1, "w");

            fputcsv($file, explode(',', $display_fields));

            fclose($file);

            echo "<script>window.open('$filename1');</script>";
        }
    }
}

if (isset($_POST['copy']) || isset($_GET['copy']) ) {
    $checkbox = $_POST['check'];
    // echo("<div style=\"display:none;\">". print_r($checkbox) ."</div>");
    $table = $_POST['table1'];
    $batch_id = get_last_batchid($school_id);
    $school_id1 = $_SESSION['school_id'];
    if(count($checkbox)<=0)
    {
        echo "<script LANGUAGE='JavaScript'>
        window.alert('No Data selected to copy...');
        window.location.href='sd_upload_panel.php';
        </script>";
    }
    else{
    for ($i = 0; $i < count($checkbox); $i++) {
        $del_id = $checkbox[$i];
        //echo $del_id;
        if ($table == 'tbl_semester_master') {
            $s1 = "SELECT * FROM $table WHERE Semester_Id='" . $del_id . "'";
            $r1 = mysql_query($s1);
            $r2 = mysql_fetch_array($r1);
        } else {
            $s1 = "SELECT * FROM $table WHERE id='" . $del_id . "'";
            $r1 = mysql_query($s1);
            $r2 = mysql_fetch_array($r1);
        }
        // print_r($r2);
        if ($table == 'tbl_CourseLevel') {
            $extid1 = $r2['ExtCourseLevelID'];
            $records = $r2['CourseLevel'];
            $copied_frm = $r2['school_id'];
            $a = mysql_query("SELECT ExtCourseLevelID from tbl_CourseLevel where ExtCourseLevelID='$extid1' and school_id='$school_id1'");
            $b = mysql_num_rows($a);
            // print_r($b);
            if ($b > 0) {
                if ($records != '') {
                    $records1 = $records;
                }
                $sql = "UPDATE tbl_CourseLevel set CourseLevel='$records1' where school_id='$school_id1' and ExtCourseLevelID='$extid1'";
            } else {
                //$copied_frm='grp91';
                $sql = "INSERT into $table(ExtCourseLevelID,CourseLevel,copied_from,school_id,group_member_id)values('$extid1','$records','$copied_frm','$school_id','$group_id')";
                //echo $sql;
            }
        }

        if ($table == 'tbl_department_master') {
            $extid1 = $r2['ExtDeptId'];
            $dept_code = $r2['Dept_code'];
            $Is_Enabled = $r2['Is_Enabled'];
            $Establiment_Year = $r2['Establiment_Year'];
            $PhoneNo = $r2['PhoneNo'];
            $records = $r2['Dept_Name'];
            $copied_frm = $r2['school_id'];
            $a = mysql_query("SELECT ExtDeptId from tbl_department_master where ExtDeptId='$extid1' and school_id='$school_id1'");
            $b = mysql_num_rows($a);
            // print_r($b);
            if ($b > 0) {
                if ($records != '') {
                    $records1 = $records;
                }
                if ($dept_code != '') {
                    $dept_code1 = $dept_code;
                }
                if ($Is_Enabled != '') {
                    $Is_Enabled1 = $Is_Enabled;
                }
                if ($Establiment_Year != '') {
                    $Establiment_Year1 = $Establiment_Year;
                }
                if ($PhoneNo != '') {
                    $PhoneNo1 = $PhoneNo;
                }

               $sql = "UPDATE tbl_department_master set Dept_Name='$records1',Dept_code='$dept_code1',Is_Enabled='$Is_Enabled1',Establiment_Year='$Establiment_Year1',PhoneNo='$PhoneNo1'  where school_id='$school_id' and ExtDeptId='$extid1'";
            } else {
                $sql = "INSERT into $table(ExtDeptId,Dept_code,Is_Enabled,PhoneNo,Establiment_Year,Dept_Name,copied_from,School_ID,group_member_id)values('$extid1','$dept_code','$Is_Enabled','$PhoneNo','$Establiment_Year','$records','$copied_frm','$school_id','$group_id')";
            }
        }

        if ($table == 'tbl_degree_master') {
            $extid1 = $r2['ExtDegreeID'];
            $Degree_code = $r2['Degree_code'];
            $course_level = $r2['course_level'];
            $records = $r2['Degee_name'];
            $copied_frm = $r2['school_id'];

            $a = mysql_query("SELECT ExtDegreeID from tbl_degree_master where ExtDegreeID='$extid1' and school_id='$school_id1'");
            $b = mysql_num_rows($a);
            //print_r($b);
            if ($b > 0) {
                if ($records != '') {
                    $records1 = $records;
                }
                if ($Degree_code != '') {
                    $Degree_code1 = $Degree_code;
                }
                if ($course_level != '') {
                    $course_level1 = $course_level;
                }
                $sql = "UPDATE tbl_degree_master set Degee_name='$records1',Degree_code='$Degree_code1',course_level='$course_level1' where school_id='$school_id' and ExtDegreeID='$extid1'";
            } else {

                $sql = "INSERT into $table(ExtDegreeID,Degree_code,course_level,Degee_name,copied_from,school_id,group_member_id)values('$extid1','$Degree_code','$course_level','$records','$copied_frm','$school_id','$group_id')";
            }
        }

        if ($table == 'tbl_branch_master') {
            $extid1 = $r2['ExtBranchId'];
            $records = $r2['branch_Name'];
            $Branch_code = $r2['Branch_code'];
            $DepartmentName = $r2['DepartmentName'];
            $Course_Name = $r2['Course_Name'];
            $branch_id = $r2['branch_id'];
            $copied_frm = $r2['school_id'];

            $a = mysql_query("SELECT ExtBranchId from tbl_branch_master where ExtBranchId='$extid1' and school_id='$school_id1'");
            $b=mysql_num_rows($a);
            //print_r($b);
            if ($b > 0) {
                if ($records != '') {
                    $records1 = $records;
                }
                if ($Branch_code != '') {
                    $Branch_code1 = $Branch_code;
                }
                if ($DepartmentName != '') {
                    $DepartmentName1 = $DepartmentName;
                }
                if ($Course_Name != '') {
                    $Course_Name1 = $Course_Name;
                }
                if ($branch_id != '') {
                    $branch_id1 = $branch_id;
                }

                $sql = "UPDATE tbl_branch_master set branch_Name='$records1',Branch_code='$Branch_code1',DepartmentName='$DepartmentName1',Course_Name='$Course_Name1',branch_id='$branch_id' where school_id='$school_id' and ExtBranchId='$extid1'";
            } else {

                $sql = "INSERT into $table(ExtBranchId,Branch_code,DepartmentName,Course_Name,branch_id,branch_Name,copied_from,school_id,group_member_id)values('$extid1','$Branch_code','$DepartmentName','$Course_Name','$branch_id','$records','$copied_frm','$school_id','$group_id')";
            }
        }

        if ($table == 'Class') {
            $extid1 = $r2['ExtClassID'];
            $course_level = $r2['course_level'];
            $records = $r2['class'];
            $copied_frm = $r2['school_id'];

            $a = mysql_query("SELECT ExtClassID from Class where ExtClassID='$extid1' and school_id='$school_id1'");
            $b = mysql_num_rows($a);
            //print_r($b);
            if ($b > 0) {
                if ($records != '') {
                    $records1 = $records;
                }
                if ($course_level != '') {
                    $course_level1 = $course_level;
                }

                $sql = "UPDATE Class set class='$records1',course_level='$course_level1' where school_id='$school_id' and ExtClassID='$extid1'";
            } else {

                $sql = "INSERT into $table(ExtClassID,course_level,class,copied_from,school_id,group_member_id)values('$extid1','$course_level','$records','$copied_frm','$school_id','$group_id')";
            }
        }

        if ($table == 'Division') {
            $extid1 = $r2['ExtDivisionID'];
            $records = $r2['DivisionName'];
            $copied_frm = $r2['school_id'];
            $a = mysql_query("SELECT ExtDivisionID from Division where ExtDivisionID='$extid1' and school_id='$school_id1'");
            $b = mysql_num_rows($a);
            //print_r($b);
            if ($b > 0) {
                if ($records != '') {
                    $records1 = $records;
                }

                $sql = "UPDATE Division set DivisionName='$records1' where school_id='$school_id' and ExtDivisionID='$extid1'";
            } else {

                $sql = "INSERT into $table(ExtDivisionID,DivisionName,copied_from,school_id,group_member_id)values('$extid1','$records','$copied_frm','$school_id','$group_id')";
            }
        }

        if ($table == 'tbl_school_subject') {
            $extid1 = $r2['ExtSchoolSubjectId'];
            $Subject_Code = $r2['Subject_Code'];
            $records = $r2['subject'];
            $copied_frm = $r2['school_id'];

            $a = mysql_query("SELECT ExtSchoolSubjectId from tbl_school_subject where ExtSchoolSubjectId='$extid1' and school_id='$school_id1'");
            $b = mysql_num_rows($a);
            //print_r($b);
            if ($b > 0) {
                if ($records != '') {
                    $records1 = $records;
                }
                if ($Subject_Code != '') {
                    $Subject_Code1 = $Subject_Code;
                }

                $sql = "UPDATE tbl_school_subject set subject='$records1',Subject_Code='$Subject_Code1' where school_id='$school_id' and ExtSchoolSubjectId='$extid1'";
            } else {

                $sql = "INSERT into $table(ExtSchoolSubjectId,Subject_Code,subject,copied_from,school_id,group_member_id)values('$extid1','$Subject_Code','$records','$copied_frm','$school_id','$group_id')";
            }
        }

        if ($table == 'tbl_academic_Year') {
            $extid1 = $r2['ExtYearID'];
            $Year = $r2['Year'];
            $records = $r2['Academic_Year'];
            $copied_frm = $r2['school_id'];

            $a = mysql_query("SELECT ExtYearID from tbl_academic_Year where ExtYearID='$extid1' and school_id='$school_id1'");
            $b = mysql_num_rows($a);
            //print_r($b);
            if ($b > 0) {
                if ($records != '') {
                    $records1 = $records;
                }
                if ($Year != '') {
                    $Year1 = $Year;
                }

                $sql = "UPDATE tbl_academic_Year set Academic_Year='$records1',Year='$Year1' where school_id='$school_id' and ExtYearID='$extid1'";
            } else {

                $sql = "INSERT into $table(ExtYearID,Year,Academic_Year,copied_from,school_id,group_member_id)values('$extid1','$Year','$records','$copied_frm','$school_id','$group_id')";
            }
        }
        if ($table == 'tbl_class_subject_master') {
            $extid1 = $r2['subject_code'];
            $records = $r2['subject_name'];
            $copied_frm = $r2['school_id'];
            $class_id=$r2['class_id']; 
            $class=$r2['class'];
            $subject_id=$r2['subject_id'];
            $course_level=$r2['course_level'];
            $department=$r2['department']; 

            $a = mysql_query("SELECT subject_code from tbl_class_subject_master where subject_code='$extid1' and school_id='$school_id1'");
            $b = mysql_num_rows($a);
            //print_r($b);
            if ($b > 0) {
                if ($records != '') {
                    $records1 = $records;
                }
                $sql = "UPDATE tbl_class_subject_master set subject_name='$records1', class_id='$class_id',class='$class',subject_id='$subject_id',course_level='$course_level',department='$department' where school_id='$school_id' and subject_code='$extid1'";
            } else {
                $sql = "INSERT into $table(subject_code,subject_name,class_id,class,subject_id,course_level,department,copied_from,school_id,group_member_id)values('$extid1','$records','$class_id', '$class','$subject_id','$course_level','$department','$copied_frm','$school_id','$group_id')";
            }
        }

        if ($table == 'tbl_semester_master') {

            $extid1 = $r2['ExtSemesterId'];
            $ExtBranchId = $r2['ExtBranchId'];
            $Branch_name = $r2['Branch_name'];
            $Semester_credit = $r2['Semester_credit'];
            $Is_regular_semester = $r2['Is_regular_semester'];
            $Is_enable = $r2['Is_enable'];
            $Department_Name = $r2['Department_Name'];
            $CourseLevel = $r2['CourseLevel'];
            $records = $r2['Semester_Name'];
            $copied_frm = $r2['school_id'];

            $a = mysql_query("SELECT ExtSemesterId from tbl_semester_master where ExtSemesterId='$extid1' and school_id='$school_id1'");
            $b = mysql_num_rows($a);
            //print_r($b);
            if ($b > 0) {
                if ($records != '') {
                    $records1 = $records;
                }
                if ($ExtBranchId != '') {
                    $ExtBranchId1 = $ExtBranchId;
                }
                if ($Branch_name != '') {
                    $Branch_name1 = $Branch_name;
                }
                if ($Semester_credit != '') {
                    $Semester_credit1 = $Semester_credit;
                }
                if ($Is_regular_semester != '') {
                    $Is_regular_semester1 = $Is_regular_semester;
                }
                if ($Is_enable != '') {
                    $Is_enable1 = $Is_enable;
                }
                if ($Department_Name != '') {
                    $Department_Name1 = $Department_Name;
                }
                if ($CourseLevel != '') {
                    $CourseLevel1 = $CourseLevel;
                }

                $sql = "UPDATE tbl_semester_master set Semester_Name='$records1',ExtBranchId='$ExtBranchId1',Branch_name='$Branch_name1',Semester_credit='$Semester_credit1',Is_regular_semester='$Is_regular_semester1',Is_enable='$Is_enable',Department_Name='$Department_Name1',CourseLevel='$CourseLevel1' where school_id='$school_id' and ExtSemesterId='$extid1'";
            } else {

                $sql = "INSERT into $table(ExtSemesterId,ExtBranchId,Branch_name,Semester_credit,Is_regular_semester,Is_enable,Department_Name,CourseLevel,Semester_Name,copied_from,school_id,group_member_id)values('$extid1','$ExtBranchId','$Branch_name','$Semester_credit','$Is_regular_semester','$Is_enable','$Department_Name','$CourseLevel','$records','$copied_frm','$school_id','$group_id')";
            }
        }

        mysql_query($sql);
    }
    echo "<script LANGUAGE='JavaScript'>
                window.alert('Data copied/Updated sucessfully...');
                window.location.href='sd_upload_panel.php';
                </script>";
    }     
}

?>
<div class='container'>
    <style type="text/css">
        #academic_year option:nth-child(2) {
            font-weight: bold;
        }
    </style>

    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Smart Cookies</title>
        <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
        <script src="code.jquery.com/jquery-1.10.2.js"></script>
        <script src="js/jquery-1.11.1.min.js"></script>
        <script src="js/jquery.dataTables.min.js"></script>

        <script src="code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
        <script src="js/jquery.twbsPagination.js" type="text/javascript"></script>
        <script>
            $(document).ready(function() {
                $('#example').dataTable({
                    "paging": false,
                    "info": false,
                    "searching": false,
                    "scrollCollapse": true

                });
            });
        </script>
         
        <?php if (!($_GET['Search'])) { ?>
            <script type="text/javascript">
                $(function() {
                    var total_pages = <?php echo $total_pages; ?>;
                    var start_page = <?php echo $page; ?>;
                    window.pagObj = $('#pagination').twbsPagination({
                        totalPages: total_pages,
                        visiblePages: 10,
                        startPage: start_page,
                        onPageClick: function(event, page) {
                            console.info(page + ' (from options)');
                        }
                    }).on('page', function(event, page) {
                        console.info(page + '(from event listening)');
                        window.location.assign('sd_upload_report.php?page=' + page);
                    });
                });
            </script>
        <?php } else {
        ?>
            <script type="text/javascript">
                $(function() {
                    var total_pages = <?php echo $total_pages; ?>;
                    var start_page = <?php echo $spage; ?>;
                    window.pagObj = $('#pagination').twbsPagination({
                        totalPages: total_pages,
                        visiblePages: 10,
                        startPage: start_page,
                        onPageClick: function(event, page) {
                            console.info(page + ' (from options)');
                        }
                    }).on('page', function(event, page) {
                        console.info(page + '(from event listening)');
                        window.location.assign('sd_upload_report.php?colname=<?php echo $colname; ?>&Search=<?php echo $searchq; ?>&spage=' + page);
                    });
                });
            </script>
        <?php } ?>
        <style>
            @media only screen and (max-width: 800px) {

                /* Force table to not be like tables anymore */
                #no-more-tables table,
                #no-more-tables thead,
                #no-more-tables tbody,
                #no-more-tables th,
                #no-more-tables td,
                #no-more-tables tr {
                    display: block;
                }

                /* Hide table headers (but not display: none;, for accessibility) */
                #no-more-tables thead tr {
                    position: absolute;
                    top: -9999px;
                    left: -9999px;
                }

                #no-more-tables tr {
                    border: 1px solid #ccc;
                }

                #no-more-tables td {
                    /* Behave  like a "row" */
                    border: none;
                    border-bottom: 1px solid #eee;
                    position: relative;
                    padding-left: 50%;
                    white-space: normal;
                    text-align: left;
                    font: Arial, Helvetica, sans-serif;
                }

                #no-more-tables td:before {
                    /* Now like a table header */
                    position: absolute;
                    /* Top/left values mimic padding */
                    top: 6px;
                    left: 6px;

                    padding-right: 10px;
                    white-space: nowrap;


                }

                /*
    Label the data
    */
                #no-more-tables td:before {
                    content: attr(data-title);
                }
            }
        </style>
    </head>




    <style>
        .preview {

            border-radius: 50% 50% 50% 50%;

            box-shadow: 0 3px 2px rgba(0, 0, 0, 0.3);

            -webkit-border-radius: 99em;

            -moz-border-radius: 99em;

            border-radius: 99em;

            border: 5px solid #eee;

            width: 100px;

        }
    </style>
    <style>
        body {
            font-family: Arial;
        }

        /* Style the tab */
        .tab {
            overflow: hidden;
            border: 1px solid #ccc;
            background-color: #f1f1f1;

        }

        /* Style the buttons inside the tab */
        .tab button {
            background-color: inherit;
            float: left;
            border: none;
            outline: none;
            cursor: pointer;
            padding: 14px 16px;
            transition: 0.3s;
            font-size: 17px;
        }

        /* Change background color of buttons on hover */
        .tab button:hover {
            background-color: #ddd;
            display: block;
        }

        /* Create an active/current tablink class */
        .tab button.active {
            background-color: #ccc;
            display: block;
        }

        /* Style the tab content */
        .tabcontent {
            display: none;
            padding: 6px 12px;
            border: 1px solid #ccc;
            border-top: none;
            height: 55%;
        }

        .active {
            display: block;
        }

        .active1 {
            width: 100%;
            margin-left: 300px;
            margin-top: -100px;
        }
    </style>
    </head>

    <body>

        <div class="tab">
            <button class="tablinks" onclick="openCity(event, 'format')">Data Formats</button>
            <button class="tablinks" onclick="openCity(event, 'upload')">Data Upload</button>
            <button class="tablinks" onclick="openCity(event, 'copy')">Data Copy</button>
            <button class="tablinks" onclick="openCity(event, 'Batch')">Batch Report</button>

        </div>

        <div id="format" class="tabcontent">
            <br />
            <div class='col-md-4'>

                <!--format-->
                <form method='post' enctype='multipart/form-data'>


                    <div class='row'>
                        <?php if ($school_type == 'school' && $user == 'School Admin') { ?>
                            <select name='table' id='table'>
                                <option value=''>Select Table</option>

                                <option value='tbl_CourseLevel'>01. Course Level</option>

                                <option value='tbl_degree_master'>02. Degree</option>

                                <option value='tbl_department_master'>03. Departments</option>

                                <option value='tbl_branch_master'>04. Branch</option>

                                <option value='Class'>05. Class</option>

                                <option value='Division'>06. Division</option>

                                <option value='tbl_school_subject'>07. Subject</option>
<!--
                                <option value='tbl_academic_Year'>08. Academic Year</option>
-->
                                <option value='tbl_semester_master'>08. Semester</option>

                                <option value='tbl_teacher'>09. Teacher</option>
                                
                                <option value='tbl_teacher_subject_master'>10. Teacher Subject</option>

                                <option value='Branch_Subject_Division_Year'>11. Branch Subject Division Year</option>

                                <option value='tbl_class_subject_master'>12. Class Subject</option>

                                <option value='tbl_student'>13. Student</option>

                                <option value='StudentSemesterRecord'>14. Student Semester</option>

                                <option value='tbl_student_subject_master'>15. Student Subject</option>

                                <option value='tbl_parent'>16.Parent</option>


                            </select>
                        <?php } else { ?>
                            <select name='table' id='table'>

                                <option value=''></option>

                                <option value='tbl_department_master'>01. Departments</option>

                                <option value='tbl_CourseLevel'>02. Employee Level</option>

                                <option value='tbl_degree_master'>03. Corporate</option>

                                <option value='tbl_branch_master'>04. Section</option>

                                <option value='Class'>05. Team</option>

                                <option value='Division'>06. Location</option>

                                <option value='tbl_semester_master'>07. Default Duration</option>

                                <option value='tbl_academic_Year'>08. Financial Year</option>

                                <option value='tbl_student'>9. Employee</option>

                                <option value='tbl_teacher'>10. Manager</option>

                                <option value='tbl_school_subject'>11. Project</option>

                            </select>
                        <?php } ?>
                        <button type='submit' name='dformat' class='btn btn-success btn-xs'>Download Format</button>
                        <button type='submit' name='Previewformat' class='btn btn-success btn-xs'>Preview</button>

                    </div>
                </form>
            </div>
        </div>

        <div id="upload" class="tabcontent">

            <div class='row'>

                <div class='col-md-4'>

                    <?php $group_name4 = $_POST['group_name1'];
                    $table4 = $_POST['table'];
                    //echo $table4;

                    ?>

                    <form method='post' enctype='multipart/form-data'>



                        <br /> <input type='text' name='uploaded_by' id='uploaded_by' value='<?php if (isset($_POST['uploaded_by'])) {
                                                                                                    echo $_POST['uploaded_by'];
                                                                                                } ?>' placeholder='Uploaded By' /><br /> <br />

                        <?php if ($school_type == 'school' && $user == 'School Admin') { ?>

                            Please Follow these steps:<br />

                            <select name='table' id='table'>

                                <option value='' >Select Table Name</option>

                                <option value='tbl_CourseLevel' >01. Course Level</option>

                                <option value='tbl_degree_master' disabled>02. Degree</option>

                                <option value='tbl_department_master' disabled>03. Departments</option>

                                <option value='tbl_branch_master' disabled>04. Branch</option>

                                <option value='Class' disabled>05. Class</option>

                                <option value='Division' disabled>06. Division</option>

                                <option value='tbl_school_subject' disabled>07. Subject</option>
<!---
                                <option value='tbl_academic_Year' disabled>08. Academic Year</option>
-->
                                <option value='tbl_semester_master' disabled>08. Semester</option>

                                <option value='tbl_teacher' disabled>09. Teacher</option>

                                <option value='tbl_teacher_subject_master' disabled>10. Teacher Subject</option>

                                <option value='Branch_Subject_Division_Year' disabled>11. Branch Subject Division Year</option>

                                <option value='tbl_class_subject_master' disabled>12. Class Subject</option>

                                <option value='tbl_student' disabled>13. Student</option>

                                <option value='StudentSemesterRecord' disabled>14. Student Semester</option>

                                <option value='tbl_student_subject_master' disabled>15. Student Subject</option>

                                <option value='tbl_parent' disabled>16. Parent</option>



                            </select><br /><br />
                            <!-- start SMC-4203 by Kunal -->
                            <!-- start SMC-4203 by Kunal -->
                            <span id="ac_year" style="display:none;">
                                <select name='academic_year' id='academic_year'>
                                    <option value=''>Select Academic Year</option>
                                    <?php $query_ay = "SELECT DISTINCT ExtYearID, Academic_Year, Year, Enable FROM tbl_academic_Year where school_id='$school_id' order by Enable DESC";
                                    $sql_ay = mysql_query($query_ay);
                                    while ($res_ay = mysql_fetch_array($sql_ay)) { ?>
                                        <option value="<?= $res_ay['Academic_Year']; ?>"><?php echo $res_ay['Academic_Year']; ?></option>
                                    <?php } ?>
                                </select>
                                <br /> <br />
                                <select name='semester_type' id='semester_type'>
                                    <option value=''>Select Semester Type</option>
                                    <option value="regular">Regular Semester</option>
                                    <option value="odd">Odd Semester</option>
                                    <option value="even">Even Semester</option>
                                </select>
                                <br /> <br />
                            </span>
                            <!-- end SMC-4203 by Kunal -->

                            <input type="hidden" name="weightage" id="weightage">
                            <script type="text/javascript">
                                $(document).ready(function() {
                                    $('#table').change(function() {
                                        var tbl_nm = $(this).val();
                                        $.ajax({
                                            datatype: "json",
                                            method: "post",
                                            url: "ajax_table_weightage.php",
                                            data: {
                                                tbls: tbl_nm
                                            }
                                        }).done(function(res) {
                                            console.log(res);
                                            $("#weightage").val(res);
                                        });
                                    });
                                });
                            </script>
                            <!-- start SMC-4203 by Kunal -->


                        <?php } else { ?>
                            Please Follow these steps:<br />
                            <select name='table' id='table'>

                                <option value='' disabled></option>

                                <option value='tbl_department_master'>01. Departments</option>

                                <option value='tbl_CourseLevel'>02. Employee Level</option>

                                <option value='tbl_degree_master'>03. Corporate</option>

                                <option value='tbl_branch_master'>04. Section</option>

                                <option value='Class'>05. Team</option>

                                <option value='Division'>06. Location</option>

                                <option value='tbl_semester_master'>07. Default Duration</option>

                                <option value='tbl_academic_Year'>08. Financial Year</option>

                                <option value='tbl_student'>09. Employee</option>

                                <option value='tbl_teacher'>10. Manager</option>

                                <option value='tbl_school_subject'>11. Project</option>

                            </select>
                        <?php } ?>

                        <input type='file' name='file' accept='.csv,.xls,.xlsx' />

                        <br /><?php echo $report; ?><br />

                        <button type='submit' name='submit' class='btn btn-success'>Upload</button>&nbsp;&nbsp;&nbsp;

                        <button type='reset' name='reset' class='btn btn-alert'>Cancel</button>

                    </form>



                    <a href='<?php echo $redirect_to; ?>'>Process Previous Batch Uploaded</a>


                </div>

            </div>
        </div>

        <div id="copy" class="tabcontent">
            <!-- <h1>Data copy is under Construction</h1> -->
            <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/css/select2.min.css" rel="stylesheet" />
            <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/js/select2.min.js"></script>
            <script>
                $(document).ready(function(){
                    $('.SMCselect2').select2({
                    
                    });
                    });
            </script>
            <script type="text/javascript">
                    // var source=document.getElementById("source").checked;
                    
                    function fun(x) { 
                        var type;
                        if(x==0) 
                        type = "DTE";
                        else if(x==1) 
                        type = "SBTE";
                        else if(x==2) 
                        type = "University";
                        else;
                        
                        if (x==3)
                        {
                            document.getElementById("selgroupname1").style.display="none";
                            document.getElementById("groupname1").style.display="block";
                            document.getElementById("groupname").value="";
                        }
                        else{
                            $.ajax({
                            type: "POST",
                            url: 'Ajaxschool.php',
                            data: { type : type},
                            success: function(data) {
                                $("#selgroupname").html(data);
                               // alert(data);
                                }       
                             });
                            document.getElementById("selgroupname1").style.display="block";
                            document.getElementById("groupname1").style.display="none";
                        }
                    }
                    function getOption()
                    {
                        selectElement = document.querySelector('#selgroupname');
                        output = selectElement.value;
                        document.getElementById("groupname").value= output;
                    }
                </script>

            <div class="col-md-4">
                <form method='post' enctype='multipart/form-data'>
                    <label  style="text-align:left;">Source<span class="error"> *</span></label>
                    <input type="radio" name="source" id="DTE" value="DTE" checked onclick="fun(0)"> DTE 
                    <input type="radio" name="source" id="sbte" value="SBTE" onclick="fun(1)"> SBTE
                    <input type="radio" name="source" id="uni" value="University" onclick="fun(2)"> University
                    <input type="radio" name="source" id="othersc" value="OtherSchool"  onclick="fun(3)"> Other <br/>
                    </br/>

                   <div id="selgroupname1" style="width:200px;" >
                   <?php 
                        $sql5 = mysql_query( " SELECT scadmin_state FROM tbl_school_admin where school_id='".$school_id."'");
                        $result5 = mysql_fetch_array($sql5);
                        $state = $result5['scadmin_state'];
                        $sql6 = mysql_query( " SELECT school_id,school_name FROM tbl_school_admin where school_id like 'GRP%'  and group_type='DTE' and scadmin_state='".$state."' limit 1");
                        $result6 = mysql_fetch_array($sql6);
                        $school_name1 = $result6['school_name'];
                        $sc_id1 = $result6['school_id'];
                        $sql2 = mysql_query( " SELECT school_name,school_id FROM tbl_school_admin where group_type='DTE'order by school_name");
                            ?>
                        <select class='form-control  SMCselect2' name="selgroupname" id="selgroupname" onChange="getOption()">
                            <option value="0">Select Group Name</option>
                            <?php while ($result2 = mysql_fetch_array($sql2)) { ?>
                                    <option value="<?php echo $result2['school_id']; ?>" <?php if ($result2['school_id']==$sc_id1) echo "Selected"; ?> >
                                    <?php echo $result2['school_name']." (".$result2['school_id'].")"; ?>
                            </option>
                            <?php } ?> 
                        </select> <br /><br />
                    </div>
                    <div id="groupname1" style="display:none;" >
                        <!-- <label  style="text-align:left;">Enter School ID<span ><b style="color: red;"> *</b></span></label> -->
                        <input type="text" id='groupname' name="group_name1" placeholder='Enter School ID' value="<?php echo $sc_id1; ?>" ><br /><br />
                    </div>

                    <select name='table' id='table'>
                        <option value=''>Select Table Name</option>
                        <option value='tbl_CourseLevel' <?php if ($table4 == 'tbl_CourseLevel') { ?> selected="selected" <?php } ?>>01. Course Level</option>
                        <option value='tbl_degree_master' <?php if ($table4 == 'tbl_degree_master') { ?> selected="selected" <?php } ?>>02. Degree</option>
                        <option value='tbl_department_master' <?php if ($table4 == 'tbl_department_master') { ?> selected="selected" <?php } ?>>03. Departments</option>
                        <option value='tbl_branch_master' <?php if ($table4 == 'tbl_branch_master') { ?> selected="selected" <?php } ?>>04. Branch</option>
                        <option value='Class' <?php if ($table4 == 'Class') { ?> selected="selected" <?php } ?>>05. Class</option>
                        <option value='Division' <?php if ($table4 == 'Division') { ?> selected="selected" <?php } ?>>06. Division</option>
                        <option value='tbl_school_subject' <?php if ($table4 == 'tbl_school_subject') { ?> selected="selected" <?php } ?>>07. Subject</option>
                        <!-- <option value='tbl_academic_Year' <?php// if ($table4 == 'tbl_academic_Year') { ?> selected="selected" <?php // } ?>>08. Academic Year</option> -->
                        <option value='tbl_semester_master' <?php if ($table4 == 'tbl_semester_master') { ?> selected="selected" <?php } ?>>08. Semester</option>
                        <option value='tbl_class_subject_master' <?php if ($table4 == 'tbl_class_subject_master') { ?> selected="selected" <?php } ?>>09. Class Subject</option>
                    </select><br /><br />

            <button type='submit' name='Previewformat1' class='btn btn-success btn-xs'>  Display Data  </button>
            </form>
</div>

</div>
<div id="Batch" class="tabcontent">
    <br /> <button type='submit' name='submit' class='btn btn-success'><a href='sd_process_report.php' style="color: white;">Batch Scanning Status</a></button>
    <button type='submit' name='submit' class='btn btn-success'><a href='sd_upload_report.php' style="color: white;">Batch Upload Status</a></button>
    <button type='submit' name='submit' class='btn btn-success'><a href='Batch_Master_PT.php' style="color: white;">Overall Batch Report</a></button>
</div>

<script>
    function openCity(evt, cityName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(cityName).style.display = "block";
        evt.currentTarget.className += " active";
    }
    function confirmation()
    {
        let confrm=confirm("You are going to copy master file. If the destination already has a same record Data will be updated. This can not be reversed. You will have to manually delete if any wrong sourse is selected. Do you want to continue. Please confirm....");
        if(confrm){
            let btn=document.querySelector('#cpy');
            if(btn){
                btn.setAttribute('name','copy');
            }
        }
        else{
           let btn=document.querySelector('#cpy');
           if(btn){
               btn.setAttribute('name','');
           } 
           window.alert("Data not Copied...");
        }
    }
    function confirmation1()
    {
        let conn=confirm("You are exporting data. You can update as per your requirement and upload it in your files. Do you want to continue. Please confirm....");
        if(conn){
            let btnSend = document.querySelector('#conf');
        if (btnSend) {
            btnSend.setAttribute('name','download');
        }
        }
        else{
            let btnSend = document.querySelector('#conf');
        if (btnSend) {
            btnSend.setAttribute('name','');
        }
             window.alert("Data not Exported...");
        }
        }
    
</script>
<style type="text/css">
    .select2 {
        width: 200px !important;
        text-overflow: ellipsis;
    }
    select {
        width: 200px !important;
        text-overflow: ellipsis;

</style>


<?php
if (isset($_POST['Previewformat1']) || isset($_GET['Previewformat1'])) {
    
    if(isset($_GET['table'])){
        $table=trim($_GET['table']);
    }
    else
        $table = $_POST['table'];
    
    if(isset($_GET['group_name1'])){
        $group_member_id=trim($_GET['group_name1']);
    }
    else 
        $group_member_id = $_POST['group_name1'];
    
    //echo $group_member_id. "<br/>".$table;
    $school_id1 = $school_id;
    $sql2 = mysql_query(" SELECT school_id FROM tbl_school_admin where school_id='$group_member_id'");
    $arr=mysql_fetch_array( $sql2);
    if($arr==NULL)
    {
    echo "<script LANGUAGE='JavaScript'>
                window.alert('Wrong School ID...');
                window.location.href='sd_upload_panel.php';
                </script>";
    }
    // $show = 1;
    if ($table != '') {
        if ($school_type == 'school' && $user == 'School Admin') { 
            if(isset($_GET['group_name11'])){
            $group_member_id = trim($_GET['group_name11']);
            }
            $schl_name = $_POST['schl_name'];
            // data copy pagination start
            $page_no_get = "SELECT * from $table where school_id='$group_member_id'";
            $abcd=mysql_query($page_no_get);
            $max_per_page=1000;
            $total_data=mysql_num_rows($abcd);
            $total_page_no=ceil($total_data/$max_per_page);
            $curent_page = intval(@$_GET["pagen"]);
            if($curent_page==0){
                $curent_page=1;
            }
            $start_limit=$max_per_page * ($curent_page-1);
            $max_limit= $max_per_page;

            $display_fields1 = "SELECT * from $table where school_id='$group_member_id' LIMIT $start_limit , $max_limit ";
            $arr = mysql_query($display_fields1);

            ?>
            <center><form method="post" action="" style="margin-top: 10px">
            <!-- <button type="submit" class="btn btn-success" id="cpy" onclick="return confirmation()">COPY</button>
                        &nbsp&nbsp&nbsp
                    <button  type="submit" class="btn btn-success" id="conf"  onclick="return confirmation1()">Export to CSV</button>     -->
            <table class='table table-bordered' style="width:60%;" id="tab123">

                    <tr>
                        <th <?php if ($table == 'tbl_CourseLevel') { ?>colspan="4" <?php } ?> <?php if ($table == 'tbl_department_master') { ?>colspan="4" <?php } ?> <?php if ($table == 'tbl_degree_master') { ?>colspan="5" <?php } ?> <?php if ($table == 'tbl_branch_master') { ?>colspan="7" <?php } ?> <?php if ($table == 'Class') { ?>colspan="4" <?php } ?> <?php if ($table == 'Division') { ?>colspan="4" <?php } ?> <?php if ($table == 'tbl_school_subject') { ?>colspan="7" <?php } ?> <?php if ($table == 'tbl_academic_Year') { ?>colspan="5" <?php } ?> <?php if ($table == 'tbl_semester_master') { ?>colspan="8" <?php } ?> <?php if ($table == 'tbl_class_subject_master') { ?>colspan="8" <?php } ?>>
                            <h3 align='center'>File selected for Copy :
                                <?php if ($table == 'tbl_CourseLevel') {
                                    echo 'CourseLevel';
                                }
                                if ($table == 'tbl_department_master') {
                                    echo 'Department Name';
                                }
                                if ($table == 'tbl_degree_master') {
                                    echo 'Degree Name';
                                }
                                if ($table == 'tbl_branch_master') {
                                    echo 'Branch Name';
                                }
                                if ($table == 'Class') {
                                    echo 'Class';
                                }
                                if ($table == 'Division') {
                                    echo 'Division';
                                }
                                if ($table == 'tbl_school_subject') {
                                    echo 'Subject';
                                }
                                if ($table == 'tbl_academic_Year') {
                                    echo 'Acadmic Year';
                                }
                                if ($table == 'tbl_semester_master') {
                                    echo 'Semester';
                                }
                                if ($table == 'tbl_class_subject_master') {
                                    echo 'Class Subject';
                                }
                                ?>

                            </h3>
                            <h3 align='center'>Copy From:
                                <?php
                                $display_fields2 = mysql_query("SELECT school_name from tbl_school_admin where school_id='$group_member_id'");
                                $arr11 = mysql_fetch_array($display_fields2);
                                $schl_name = $arr11['school_name'];
                                //echo $schl_name; 
                                echo $schl_name; ?>(<?php echo $group_member_id; ?>)
                                 <?php ?>&nbsp;&nbsp;To <?php echo $school_name; ?>(<?php echo $school_id; ?>)
                            </h3>
                        </th>
                    </tr>
                    <input type="hidden" name="table1" value="<?php echo $table; ?>">
                    <input type="hidden" name="schl" value="<?php echo $group_member_id; ?>">
                    <tr>
                        <th><input type="checkbox" id="checkAl"> Select All
                            <!-- <button type="submit" class="btn btn-success" name="copy">COPY</button> -->

                        </th>
                        <?php

                        if ($table == 'tbl_CourseLevel') {
                        ?><th>ExtCourseLevelID</th>
                            <th>CourseLevel</th>
                            <input type="hidden" name="csvdata[]" value="<?php echo "School ID"; ?>">
                            <input type="hidden" name="csvdata[]" value="<?php echo "ExtCourseLevelID"; ?>" />
                            <input type="hidden" name="csvdata[]" value="<?php echo "CourseLevel"; ?>"/> 
                        <?php
                        //$user_CSV[0] = array('School ID','ExtCourseLevelID','CourseLevel');
                        }

                        if ($table == 'tbl_department_master') {
                        ?> <th>DepartmentID</th>
                            <th>DepartmentCode</th>
                            <th>DepartmentName</th>
                            <input type="hidden" name="csvdata[]" value="<?php echo "School ID"; ?>"/>
                            <input type="hidden" name="csvdata[]" value="<?php echo "DepartmentID"; ?>" />
                            <input type="hidden" name="csvdata[]" value="<?php echo "DepartmentCode"; ?>"/> 
                            <input type="hidden" name="csvdata[]" value="<?php echo "DepartmentName"; ?>"/> 

                        <?php
                        //$user_CSV[0] = array('School ID','DepartmentID','DepartmentCode','DepartmentName');
                        }

                        if ($table == 'tbl_degree_master') {
                        ?> <th>DegreeID</th>
                            <th>DegreeCode</th>
                            <th>DegreeName</th>
                            <th>CourseLevel</th>
                            <input type="hidden" name="csvdata[]" value="<?php echo "School ID"; ?>"/>
                            <input type="hidden" name="csvdata[]" value="<?php echo "DegreeID"; ?>" />
                            <input type="hidden" name="csvdata[]" value="<?php echo "DegreeCode"; ?>"/> 
                            <input type="hidden" name="csvdata[]" value="<?php echo "DegreeName"; ?>"/> 
                            <input type="hidden" name="csvdata[]" value="<?php echo "CourseLevel"; ?>"/>
                        <?php
                        //$user_CSV[0] = array('School ID','DegreeID','DegreeCode','DegreeName','CourseLevel');
                        }
                        if ($table == 'tbl_branch_master') {
                        ?><th>BranchID</th>
                            <th>Branch</th>
                            <th>Specialization</th>
                            <th>Duration</th>
                            <th>DepartmentName</th>
                            <th>CourseLevel</th>
                            <input type="hidden" name="csvdata[]" value="<?php echo "School ID"; ?>"/>
                            <input type="hidden" name="csvdata[]" value="<?php echo "BranchID"; ?>" />
                            <input type="hidden" name="csvdata[]" value="<?php echo "Branch"; ?>"/> 
                            <input type="hidden" name="csvdata[]" value="<?php echo "Specialization"; ?>"/> 
                            <input type="hidden" name="csvdata[]" value="<?php echo "Duration"; ?>"/>
                            <input type="hidden" name="csvdata[]" value="<?php echo "DepartmentName"; ?>"/> 
                            <input type="hidden" name="csvdata[]" value="<?php echo "CourseLevel"; ?>"/>
                        <?php
                       // $user_CSV[0] = array('School ID','BranchID','Branch','Specialization','Duration','DepartmentName','CourseLevel');
                    }

                        if ($table == 'Class') {
                        ?>
                            <th>ClassID</th>
                            <th>Class</th>
                            <th>CourseLevel</th>
                            <input type="hidden" name="csvdata[]" value="<?php echo "School ID"; ?>"/>
                            <input type="hidden" name="csvdata[]" value="<?php echo "ClassID"; ?>" />
                            <input type="hidden" name="csvdata[]" value="<?php echo "Class"; ?>"/> 
                            <input type="hidden" name="csvdata[]" value="<?php echo "CourseLevel"; ?>"/> 
                        <?php
                        //$user_CSV[0] = array('School ID','ClassID','Class','CourseLevel');
                    }

                        if ($table == 'Division') {
                        ?><th>DivisionID</th>
                            <th>Division</th>
                            <input type="hidden" name="csvdata[]" value="<?php echo "School ID"; ?>"/>
                            <input type="hidden" name="csvdata[]" value="<?php echo "DivisionID"; ?>" />
                            <input type="hidden" name="csvdata[]" value="<?php echo "Division"; ?>"/> 
                        <?php
                        //$user_CSV[0] = array('School ID','DivisionID','Division');
                    }

                        if ($table == 'tbl_school_subject') {
                        ?><th>SubjectID</th>
                            <th>SubjectCode</th>
                            <th>Subject</th>
                            <th>SubjectType</th>
                            <th>SubjectShortName</th>
                            <th>SubjectCredit</th>
                            <input type="hidden" name="csvdata[]" value="<?php echo "School ID"; ?>"/>
                            <input type="hidden" name="csvdata[]" value="<?php echo "SubjectID"; ?>" />
                            <input type="hidden" name="csvdata[]" value="<?php echo "SubjectCode"; ?>"/> 
                            <input type="hidden" name="csvdata[]" value="<?php echo "Subject"; ?>"/> 
                            <input type="hidden" name="csvdata[]" value="<?php echo "SubjectType"; ?>"/>
                            <input type="hidden" name="csvdata[]" value="<?php echo "SubjectShortName"; ?>"/> 
                            <input type="hidden" name="csvdata[]" value="<?php echo "SubjectCredit"; ?>"/>
                        <?php
                        //$user_CSV[0] = array('School ID','SubjectID','SubjectCode','Subject','SubjectType','SubjectShortName','SubjectCredit');
                    }

                        if ($table == 'tbl_academic_Year') {
                        ?><th>YearID</th>
                            <th>AcademicYear</th>
                            <th>Year</th>
                            <th>IsEnabled</th>
                            <input type="hidden" name="csvdata[]" value="<?php echo "School ID"; ?>"/>
                            <input type="hidden" name="csvdata[]" value="<?php echo "YearID"; ?>" />
                            <input type="hidden" name="csvdata[]" value="<?php echo "AcademicYear"; ?>"/> 
                            <input type="hidden" name="csvdata[]" value="<?php echo "Year"; ?>"/> 
                            <input type="hidden" name="csvdata[]" value="<?php echo "IsEnabled"; ?>"/> 
                        <?php
                       // $user_CSV[0] = array('School ID','YearID','AcademicYear','Year','IsEnabled');
                    }
                        if ($table == 'tbl_semester_master') {
                        ?>
                            <th>SemesterID</th>
                            <th>SemesterName</th>
                            <th>IsRegularSemester</th>
                            <th>CourseLevel</th>
                            <th>DepartmentName</th>
                            <th>BranchName</th>
                            <th>Class</th>
                            <input type="hidden" name="csvdata[]" value="<?php echo "School ID"; ?>"/>
                            <input type="hidden" name="csvdata[]" value="<?php echo "SemesterID"; ?>" />
                            <input type="hidden" name="csvdata[]" value="<?php echo "SemesterName"; ?>"/> 
                            <input type="hidden" name="csvdata[]" value="<?php echo "IsRegularSemester"; ?>"/> 
                            <input type="hidden" name="csvdata[]" value="<?php echo "CourseLevel"; ?>"/>
                            <input type="hidden" name="csvdata[]" value="<?php echo "DepartmentName"; ?>"/> 
                            <input type="hidden" name="csvdata[]" value="<?php echo "BranchName"; ?>"/> 
                            <input type="hidden" name="csvdata[]" value="<?php echo "Class"; ?>"/>
                        <?php
                        //$user_CSV[0] = array('School ID','SemesterID','SemesterName','IsRegularSemester','CourseLevel','DepartmentName','BranchName','Class');
                    }
                        if ($table == 'tbl_class_subject_master') {
                        ?>
                            <th>ClassId</th>
                            <th>Class</th>
                            <th>SubjectId</th>
                            <th>SubjectCode</th>
                            <th>SubjectName</th>
                            <th>CourseLevel</th>
                            <th>Department</th>
                            <input type="hidden" name="csvdata[]" value="<?php echo "School ID"; ?>"/>
                            <input type="hidden" name="csvdata[]" value="<?php echo "ClassId"; ?>" />
                            <input type="hidden" name="csvdata[]" value="<?php echo "Class"; ?>"/> 
                            <input type="hidden" name="csvdata[]" value="<?php echo "SubjectId"; ?>"/> 
                            <input type="hidden" name="csvdata[]" value="<?php echo "SubjectCode"; ?>"/>
                            <input type="hidden" name="csvdata[]" value="<?php echo "SubjectName"; ?>"/> 
                            <input type="hidden" name="csvdata[]" value="<?php echo "CourseLevel"; ?>"/> 
                            <input type="hidden" name="csvdata[]" value="<?php echo "Department"; ?>"/>
                        <?php
                        //$user_CSV[0] = array('School ID','ClassId','Class','SubjectId','SubjectCode','SubjectName','CourseLevel','Department');
                    }

                        ?>
                    </tr>
                    <?php
                    $i=0;
                    while ($row = mysql_fetch_array($arr)) { 
                        $i++;
                        ?>
                        <tr>
                            <td>
                                <?php if ($table == 'tbl_semester_master') { ?>
                                    <input type="checkbox" id="checkItem" name="check[]" value="<?php echo $row['Semester_Id']; ?>">
                                <?php } else { ?>
                                    <input type="checkbox" id="checkItem" name="check[]" value="<?php echo $row['id']; ?>">
                                <?php } ?>

                            </td>
                            <!-- <?php $school_id = $row['school_id']; ?> -->
                            <?php if ($table == 'tbl_CourseLevel') { ?>
                                <!--  <td><?php echo $school_id; ?></td> -->
                                <td><?php echo $row['ExtCourseLevelID']; ?></td>
                                <td><?php echo $row['CourseLevel']; ?></td>
                                <input type="hidden" name="idvalues[]" value="<?php echo $row['id']; ?>"/>
                                <input type="hidden" name="csvdata1[school_id][]" value="<?php echo $group_member_id; ?>"/>
                            <input type="hidden" name="csvdata1[Ext_CourseLevel_ID][]" value="<?php echo $row['ExtCourseLevelID']; ?>" />
                            <input type="hidden" name="csvdata1[Course_Level][]" value="<?php echo $row['CourseLevel']; ?>"/> 
                            <?php 
                        //$user_CSV[$i] = array($school_id,$row['ExtCourseLevelID'],$row['CourseLevel']);
                        } ?>



                            <?php if ($table == 'tbl_department_master') { ?>
                                <td><?php echo $row['ExtDeptId']; ?></td>
                                <td><?php echo $row['Dept_code']; ?></td>
                                <td><?php echo $row['Dept_Name']; ?></td>
                                <input type="hidden" name="idvalues[]" value="<?php echo $row['id']; ?>"/>
                                <input type="hidden" name="csvdata1[school_id][]" value="<?php echo $group_member_id; ?>"/>
                            <input type="hidden" name="csvdata1[ExtDeptId][]" value="<?php echo $row['ExtDeptId']; ?>" />
                            <input type="hidden" name="csvdata1[Dept_code][]" value="<?php echo $row['Dept_code']; ?>"/> 
                            <input type="hidden" name="csvdata1[Dept_Name][]" value="<?php echo $row['Dept_Name']; ?>"/>
                            <?php 
                                 //$user_CSV[$i] = array($school_id,$row['ExtDeptId'],$row['Dept_code'],$row['Dept_Name']);
                            } ?>


                            <?php if ($table == 'tbl_degree_master') { ?>
                                <td><?php echo $row['ExtDegreeID']; ?></td>
                                <td><?php echo $row['Degree_code']; ?></td>
                                <td><?php echo $row['Degee_name']; ?></td>
                                <td><?php echo $row['course_level']; ?></td>
                                <input type="hidden" name="idvalues[]" value="<?php echo $row['id']; ?>"/>
                                <input type="hidden" name="csvdata1[school_id][]" value="<?php echo $group_member_id; ?>"/>
                            <input type="hidden" name="csvdata1[ExtDegreeID][]" value="<?php echo $row['ExtDegreeID']; ?>" />
                            <input type="hidden" name="csvdata1[Degree_code][]" value="<?php echo $row['Degree_code']; ?>"/> 
                            <input type="hidden" name="csvdata1[Degee_name][]" value="<?php echo $row['Degee_name']; ?>"/>
                            <input type="hidden" name="csvdata1[course_level][]" value="<?php echo $row['course_level']; ?>"/>
                            <?php 
                                // $user_CSV[$i] = array($school_id,$row['ExtDegreeID'],$row['Degree_code'],$row['Degee_name'],$row['course_level']);
                            } ?>

                            <?php if ($table == 'tbl_branch_master') { ?>
                                <td><?php echo $row['ExtBranchId']; ?></td>
                                <td><?php echo $row['branch_Name']; ?></td>
                                <td><?php echo $row['Specialization']; ?></td>
                                <td><?php echo $row['Duration']; ?></td>
                                <td><?php echo $row['DepartmentName']; ?></td>
                                <td><?php echo $row['Course_Name']; ?></td>
                                <input type="hidden" name="idvalues[]" value="<?php echo $row['id']; ?>"/>
                                <input type="hidden" name="csvdata1[school_id][]" value="<?php echo $group_member_id; ?>"/>
                            <input type="hidden" name="csvdata1[ExtBranchId][]" value="<?php echo $row['ExtBranchId']; ?>" />
                            <input type="hidden" name="csvdata1[branch_Name][]" value="<?php echo $row['branch_Name']; ?>"/> 
                            <input type="hidden" name="csvdata1[Specialization][]" value="<?php echo $row['Specialization']; ?>"/>
                            <input type="hidden" name="csvdata1[Duration][]" value="<?php echo $row['Duration']; ?>"/>
                            <input type="hidden" name="csvdata1[DepartmentName][]" value="<?php echo $row['DepartmentName']; ?>"/>
                            <input type="hidden" name="csvdata1[Course_Name][]" value="<?php echo $row['Course_Name']; ?>"/>

                            <?php 
                                // $user_CSV[$i] = array($school_id,$row['ExtBranchId'],$row['branch_Name'],$row['Specialization'],$row['Duration'],$row['DepartmentName'],$row['Course_Name']);
                            } ?>

                            <?php if ($table == 'Class') { ?>
                                <td><?php echo $row['ExtClassID']; ?></td>
                                <td><?php echo $row['class']; ?></td>
                                <td><?php echo $row['course_level']; ?></td>
                                <input type="hidden" name="idvalues[]" value="<?php echo $row['id']; ?>"/>
                                <input type="hidden" name="csvdata1[school_id][]" value="<?php echo $group_member_id; ?>"/>
                            <input type="hidden" name="csvdata1[ExtClassID][]" value="<?php echo $row['ExtClassID']; ?>" />
                            <input type="hidden" name="csvdata1[class][]" value="<?php echo $row['class']; ?>"/> 
                            <input type="hidden" name="csvdata1[course_level][]" value="<?php echo $row['course_level']; ?>"/>
                            <?php 
                                // $user_CSV[$i] = array($school_id,$row['ExtClassID'],$row['class'],$row['course_level']);
                            } ?>
                            <?php if ($table == 'Division') { ?>
                                <!--   <td><?php echo $school_id; ?></td> -->
                                <td><?php echo $row['ExtDivisionID']; ?></td>
                                <td><?php echo $row['DivisionName']; ?></td>
                                <input type="hidden" name="idvalues[]" value="<?php echo $row['id']; ?>"/>
                                <input type="hidden" name="csvdata1[school_id][]" value="<?php echo $group_member_id; ?>"/>
                            <input type="hidden" name="csvdata1[ExtDivisionID][]" value="<?php echo $row['ExtDivisionID']; ?>" />
                            <input type="hidden" name="csvdata1[DivisionName][]" value="<?php echo $row['DivisionName']; ?>"/> 
                            <?php 
                                 //$user_CSV[$i] = array($school_id,$row['ExtDivisionID'],$row['DivisionName']);
                            } ?>
                            <?php if ($table == 'tbl_school_subject') { ?>
                                <td><?php echo $row['ExtSchoolSubjectId']; ?></td>
                                <td><?php echo $row['Subject_Code']; ?></td>
                                <td><?php echo $row['subject']; ?></td>
                                <td><?php echo $row['Subject_type']; ?></td>
                                <td><?php echo $row['Subject_short_name']; ?></td>
                                <td><?php echo $row['subject_credit']; ?></td>
                                <input type="hidden" name="idvalues[]" value="<?php echo $row['id']; ?>"/>
                                <input type="hidden" name="csvdata1[school_id][]" value="<?php echo $group_member_id; ?>"/>
                            <input type="hidden" name="csvdata1[ExtSchoolSubjectId][]" value="<?php echo $row['ExtSchoolSubjectId']; ?>" />
                            <input type="hidden" name="csvdata1[Subject_Code][]" value="<?php echo $row['Subject_Code']; ?>"/> 
                            <input type="hidden" name="csvdata1[subject][]" value="<?php echo $row['subject']; ?>"/>
                            <input type="hidden" name="csvdata1[Subject_type][]" value="<?php echo $row['Subject_type']; ?>"/>
                            <input type="hidden" name="csvdata1[Subject_short_name][]" value="<?php echo $row['Subject_short_name']; ?>"/>
                            <input type="hidden" name="csvdata1[subject_credit][]" value="<?php echo $row['subject_credit']; ?>"/>
                            <?php 
                                 //$user_CSV[$i] = array($school_id,$row['ExtSchoolSubjectId'],$row['Subject_Code'],$row['subject'],$row['Subject_type'],$row['Subject_short_name'],$row['subject_credit']);
                            } ?>

                            <?php if ($table == 'tbl_academic_Year') { ?>
                                <td><?php echo $row['ExtYearID']; ?></td>
                                <td><?php echo $row['Academic_Year']; ?></td>
                                <td><?php echo $row['Year']; ?></td>
                                <td><?php echo $row['Enable']; ?></td>
                                <input type="hidden" name="idvalues[]" value="<?php echo $row['id']; ?>"/>
                                <input type="hidden" name="csvdata1[school_id][]" value="<?php echo $group_member_id; ?>"/>
                            <input type="hidden" name="csvdata1[ExtYearID][]" value="<?php echo $row['ExtYearID']; ?>" />
                            <input type="hidden" name="csvdata1[Academic_Year][]" value="<?php echo $row['Academic_Year']; ?>"/> 
                            <input type="hidden" name="csvdata1[Year][]" value="<?php echo $row['Year']; ?>"/>
                            <input type="hidden" name="csvdata1[Enable][]" value="<?php echo $row['Enable']; ?>"/>
                            <?php 
                                 //$user_CSV[$i] = array($school_id,$row['ExtYearID'],$row['Academic_Year'],$row['Year'],$row['Enable']);
                            } ?>

                            <?php if ($table == 'tbl_semester_master') { ?>
                                <!--   <td><?php echo $school_id; ?></td> -->
                                <td><?php echo $row['ExtSemesterId']; ?></td>
                                <td><?php echo $row['Semester_Name']; ?></td>
                                <td><?php echo $row['Is_regular_semester']; ?></td>
                                <td><?php echo $row['CourseLevel']; ?></td>
                                <td><?php echo $row['Department_Name']; ?></td>
                                <td><?php echo $row['Branch_name']; ?></td>
                                <td><?php echo $row['class']; ?></td>
                                <input type="hidden" name="idvalues[]" value="<?php echo $row['Semester_Id']; ?>"/>
                                <input type="hidden" name="csvdata1[school_id][]" value="<?php echo $group_member_id; ?>"/>
                            <input type="hidden" name="csvdata1[ExtSemesterId][]" value="<?php echo $row['ExtSemesterId']; ?>" />
                            <input type="hidden" name="csvdata1[Semester_Name][]" value="<?php echo $row['Semester_Name']; ?>"/> 
                            <input type="hidden" name="csvdata1[Is_regular_semester][]" value="<?php echo $row['Is_regular_semester']; ?>"/>
                            <input type="hidden" name="csvdata1[CourseLevel][]" value="<?php echo $row['CourseLevel']; ?>"/>
                            <input type="hidden" name="csvdata1[Department_Name][]" value="<?php echo $row['Department_Name']; ?>"/>
                            <input type="hidden" name="csvdata1[Branch_name][]" value="<?php echo $row['Branch_name']; ?>"/>
                            <input type="hidden" name="csvdata1[class][]" value="<?php echo $row['class']; ?>"/>
                            <?php  
                                 //$user_CSV[$i] = array($school_id,$row['ExtSemesterId'],$row['Semester_Name'],$row['Is_regular_semester'],$row['CourseLevel'],$row['Department_Name'],$row['Branch_name'],$row['class']);
                            } ?>
                            <?php if ($table == 'tbl_class_subject_master') { ?>
                                <td><?php echo $row['class_id']; ?></td>
                                <td><?php echo $row['class']; ?></td>
                                <td><?php echo $row['subject_id']; ?></td>
                                <td><?php echo $row['subject_code']; ?></td>
                                <td><?php echo $row['subject_name']; ?></td>
                                <td><?php echo $row['course_level']; ?></td>
                                <td><?php echo $row['department']; ?></td>
                                <input type="hidden" name="idvalues[]" value="<?php echo $row['id']; ?>"/>
                                <input type="hidden" name="csvdata1[school_id][]" value="<?php echo $group_member_id; ?>"/>
                            <input type="hidden" name="csvdata1[class_id][]" value="<?php echo $row['class_id']; ?>" />
                            <input type="hidden" name="csvdata1[class][]" value="<?php echo $row['class']; ?>"/> 
                            <input type="hidden" name="csvdata1[subject_id][]" value="<?php echo $row['subject_id']; ?>"/>
                            <input type="hidden" name="csvdata1[subject_code][]" value="<?php echo $row['subject_code']; ?>"/>
                            <input type="hidden" name="csvdata1[subject_name][]" value="<?php echo $row['subject_name']; ?>"/>
                            <input type="hidden" name="csvdata1[course_level][]" value="<?php echo $row['course_level']; ?>"/>
                            <input type="hidden" name="csvdata1[department][]" value="<?php echo $row['department']; ?>"/>
                            <?php  
                               //  $user_CSV[$i] = array($school_id,$row['class_id'],$row['class'],$row['subject_id'],$row['subject_code'],$row['subject_name'],$row['course_level'],$row['department']);
                            } ?>


                        </tr> <?php
                            } 
                           // print_r($user_CSV);  
                            // echo "</table>";
                                ?></table>
                                <?php

                            $tbl=$_POST['table'];
                            if(isset($_GET['table'])){
                                $tbl=$_GET['table'];
                            }
                            $groupp_name=$_POST['group_name1'];
                            if(isset($_GET['group_name11'])){
                                $groupp_name=$_GET['group_name11'];
                            }

                                ?>
                                <center>
                            <?php  if($curent_page > 1){ $prev = $curent_page - 1; ?> <a href="?pagen=<?php echo $prev; ?>&Previewformat1=<?php echo true; ?>&table=<?php echo $tbl; ?>&group_name11=<?php echo $groupp_name; ?> "> << PREV 1000 </a> <?php }if($curent_page < $total_page_no){ $nxt = $curent_page + 1; ?> &nbsp &nbsp <a href="?pagen=<?php echo $nxt; ?>&Previewformat1=<?php echo true; ?>&table=<?php echo $tbl; ?>&group_name11=<?php echo $groupp_name; ?> ">NEXT 1000 >> </a><br><br><?php }?>  
                            </center>
                    <center><button type="submit" class="btn btn-success" id="cpy" onclick="return confirmation()">COPY</button>
                        &nbsp&nbsp&nbsp
                    <button  type="submit" class="btn btn-success" id="conf"  onclick="return confirmation1()">Export to CSV</button>&nbsp&nbsp&nbsp
                        <button class="btn btn-danger" name="cancel1">CANCEL</button>
                    </center>
            </form></center><?php

                }
            }
        }



        if (isset($_POST['Previewformat'])) {

            $table = $_POST['table'];

            if ($table != '') {

                $upinfo = upload_info($table);

                $display_table_name = $upinfo['display_table_name'];

                $raw_table = $upinfo['raw_table'];
                if ($school_type == 'school' && $user == 'School Admin') {
                    $filename = $upinfo['filename'];
                    $display_fields_description = $upinfo['display_fields_description'];
                    $display_fields = $upinfo['display_fields'];

                    $redirect_to = $upinfo['redirect_to'];
                    $x = explode(",", $display_fields);
                    $y = count($x);
                    $z = explode(",", $display_fields_description);
                    echo "<h3 align='center'>$filename</h3>";
                    echo "<table class='table table-bordered'>";
                    echo "<tr>";
                    for ($i = 0; $i < $y; $i++) {
                        echo "<th class='text-center'>$x[$i]</th>";
                        //echo $x[$i];
                    }
                    echo "</tr>";

                    echo "<tr>";
                    for ($j = 0; $j < $y; $j++) {
                        echo "<td class='text-center'>$z[$j]</td>";
                        //echo $x[$i];
                    }
                    echo "</tr>";

                    echo "</table>";
                } else {
                    $filename = $upinfo['hrfilename'];
                    $display_fields = $upinfo['hr_display_fields'];
                    $display_fields_description = $upinfo['hr_display_fields_description'];
                    $redirect_to = $upinfo['redirect_to'];
                    $x = explode(",", $display_fields);
                    $y = count($x);
                    $z = explode(",", $display_fields_description);
                    echo "<h3 align='center'>$filename</h3>";
                    echo "<table class='table table-bordered'>";
                    echo "<tr>";
                    for ($i = 0; $i < $y; $i++) {
                        echo "<th class='text-center'>$x[$i]</th>";
                        //echo $x[$i];
                    }
                    echo "</tr>";

                    echo "<tr>";
                    for ($j = 0; $j < $y; $j++) {
                        echo "<td class='text-center'>$z[$j]</td>";
                        //echo $x[$i];
                    }
                    echo "</tr>";


                    echo "</table>";
                }
            }
        }
        if ($succesfully) {
            $rowtablequery = mysql_query("select * from $raw_table where batch_id='$batch_id'");
            $rowtablecount = mysql_num_rows($rowtablequery);
            echo "<div align='center'><font color='green'><b>Total No. of records: " . $rowtablecount . "</b></font></div>";
            $showquery = "select $fields from $raw_table where batch_id='$batch_id'";
            $tsdeve = mysql_query($showquery);

            $conto = mysql_num_rows($tsdeve);
            $a = explode(",", $display_fields);
            $b = count($a);
            echo "<h3 align='center'>$filename</h3>";
            echo "<table border='1px' align='center'>";
            echo "<tr>";
            for ($j = 0; $j < $b; $j++) {
                echo "<th>$a[$j]</th>";
            }
            echo "</tr>";

            while ($row = mysql_fetch_array($tsdeve)) {
                $p = count($row);
                $sd = $p / 2;
                echo "<tr>";
                for ($k = 0; $k < $sd; $k++) {
                    $a = $row[$k];

                    echo "<td>$a</td>";
                }
                echo "</tr>";
            }

            echo "</table>";
        }
                    ?>


<?php
if ($school_type == 'school' && $user == 'School Admin') {
    $z = array('tbl_CourseLevel', 'tbl_degree_master', 'tbl_department_master', 'tbl_branch_master', 'Class', 'Division', 'tbl_school_subject', 'tbl_academic_Year', 'tbl_semester_master', 'tbl_teacher', 'tbl_teacher_subject_master', 'Branch_Subject_Division_Year', 'tbl_class_subject_master', 'tbl_student', 'StudentSemesterRecord', 'tbl_student_subject_master', 'tbl_parent');
    //$s = array('CourseLevel','Degree','Departments','Branch','Class','Division','Subject','Academic Year','Semester','Teacher','Teacher Subject','Branch Subject Division Year','Class Subject','Student','Student Semester','Student Subject','Project');
    $tablesql = "select DISTINCT db_table_name from tbl_Batch_Master where school_id='$school_id' and num_correct_records > 0";
    $cnt = count($z);
    $display_table_name = array();
    for ($k = 0; $k < $cnt; $k++) {
        $tablesql = "select count(1) as datacount from $z[$k] where school_id='$school_id'";
        // echo $tablesql;
        $tblquery = mysql_query($tablesql);
        $tablerow = mysql_fetch_array($tblquery);
        if ($tablerow['datacount'] > 0) {
            $display_table_name[] = $z[$k];
        }
    }
    // print_r($display_table_name);exit;
    $y = count($display_table_name);

    if ($y > 0) {
        // while($tablerow = mysql_fetch_array($tblquery)){
        //   $display_table_name[] = $tablerow['db_table_name'];

        // }
        // $x = count($display_table_name);
        $index = array_intersect($z, $display_table_name);
        end($index);
        $key = key($index);
        $p = $key + 1;
        if ($y < 8) {
            echo "<script>";
            for ($i = 0; $i < $y; $i++) {
                echo "$('option[value=$display_table_name[$i]]').prop('disabled', false);";
            }
            echo "$('option[value=$z[$p]]').prop('disabled', false);";
            echo "</script>";
        } else {
            echo "<script>";
            for ($i = 0; $i < 17; $i++) {
                echo "$('option[value=$z[$i]]').prop('disabled', false);";
            }
            echo "</script>";
        }
    } else {
        echo "<script>";
        echo "$('option[value=tbl_CourseLevel]').prop('disabled', false);";
        echo "</script>";
    }
}
?>

</div>

</div>

</div>

<script type="text/javascript">
    $('#table').change(function() {
        var tbl_arr = ['tbl_teacher', 'tbl_teacher_subject_master', 'Branch_Subject_Division_Year', 'tbl_class_subject_master', 'tbl_student', 'StudentSemesterRecord', 'tbl_student_subject_master', 'tbl_parent'];
        var tbl_nm = $('#table').val();
        if ($.inArray(tbl_nm, tbl_arr) > -1) {
            $('#ac_year').css('display', 'block');
            $('#academic_year').prop('required', true);
        } else {
            $('#ac_year').css('display', 'none');
            $('#academic_year').prop('required', false);
        }
    });
</script>

<script>
    $("#checkAl").click(function() {
        $('input:checkbox').not(this).prop('checked', this.checked);
    });

    $(document).ready(function() {
        $("#cancel1").click(function() {
            $("#tab123").hide();
        });
    });
</script>