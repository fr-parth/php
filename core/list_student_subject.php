<?php

include_once('scadmin_header.php');
$x = $_SESSION['AcademicYear'];
$report = "";
$results = $smartcookie->retrive_individual($table, $fields);
$test = 0;
$AcademicYear = $_SESSION['AcademicYear'];

$result = mysql_fetch_array($results);
$school_id = $result['school_id'];
?>
<?php

define('MAX_REC_PER_PAGE', 10);

if (isset($_POST['submit1']) || count($_SESSION['list_submit_subject']) > 0) {
    if(count($_POST)>0) {
        $_SESSION['list_submit_subject'] = $_POST;
    } else {
        $_POST = $_SESSION['list_submit_subject'];
    }

    $student_id         = trim($_POST['student_id']);
    $std_complete_name  = trim($_POST['std_complete_name']);
    $t_complete_name    = trim($_POST['t_complete_name']);
    $CourseLevel        = trim($_POST['CourseLevel']);
    $std_class          = trim($_POST['std_class']);
    $subject_code       = trim($_POST['subjcet_code']);
    $Semester_id        = trim($_POST['Semester_id']);
    $Division_id        = trim($_POST['Division_id']);
    $Department_id      = trim($_POST['Department_id']);
    $AcademicYear       = trim($_POST['AcademicYear']);

    $query = "select DISTINCT sm.student_id,sm.id as subject_master_id,sm.teacher_ID,sm.subjcet_code,sm.subjectName,sm.Semester_id,sm.CourseLevel,sm.id,sm.Division_id,sm.Department_id,sm.Branches_id, sm.AcademicYear,s.std_complete_name,s.std_name, s.std_Father_name,s.std_lastname, s.std_class FROM tbl_student_subject_master sm
    LEFT JOIN tbl_student s on s.school_id=sm.school_id AND sm.student_id=s.std_PRN where sm.school_id='$school_id' and s.school_id='$school_id'";

    $query1 = "";
    if ($_POST['student_id'] == ''  &&  $_POST['std_complete_name'] == '' && $_POST['t_complete_name'] == '' && $_POST['CourseLevel'] == '' && $_POST['std_class'] == '' && $_POST['subjcet_code'] == '' && $_POST['Semester_id'] == '' && $_POST['Division_id'] == '' && $_POST['Department_id'] == '' && $_POST['AcademicYear'] == '') {
        echo "<script>window.alert('please enter a field')</script>";
        echo "<script>window.location.assign('list_student_subject.php')</script>";
    } else {
        if ($student_id != '') {
            $query1 .= " and sm.student_id like '%$student_id%'";
        }
        if ($std_complete_name != '') {
            $query1 .= " and s.std_complete_name like '%$std_complete_name%'";
        }
        if ($CourseLevel != '') {
            $query1 .= " and sm.CourseLevel like '%$CourseLevel%'";
        }
        if ($std_class != '') {
            $query1 .= " and s.std_class like '%$std_class%'";
        }
        if ($subject_code != '') {
            $query1 .= " and sm.subjcet_code like '%$subject_code%'";
        }
        if ($Semester_id != '') {
            $query1 .= " and sm.Semester_id like '$Semester_id'";
        }
        if ($Division_id != '') {
            $query1 .= " and sm.Division_id like '%$Division_id%'";
        }
        if ($Department_id != '') {
            $query1 .= " and sm.Department_id like '%$Department_id%'";
        }
        if ($AcademicYear != '' && $AcademicYear != 'All') {
            $query1 .= " and sm.AcademicYear = '$AcademicYear'";
        }
        $arr = $query . $query1;
    }
} else if ($x != '') {
    if ($x == 'All') {
        $arr = "SELECT sm.id as subject_master_id,sm.student_id,sm.teacher_ID,sm.subjcet_code,sm.subjectName,sm.Semester_id,sm.CourseLevel,sm.id,sm.Division_id,sm.Department_id,sm.Branches_id,s.std_complete_name,s.std_name, s.std_Father_name,s.std_lastname, s.std_class, sm.AcademicYear as AcademicYear
    FROM tbl_student_subject_master sm
    LEFT JOIN tbl_student s on s.school_id=sm.school_id AND sm.student_id=s.std_PRN where sm.school_id='$school_id' and s.school_id='$school_id'";
    } else {
        $arr = "SELECT sm.id as subject_master_id,sm.student_id,sm.teacher_ID,sm.subjcet_code,sm.subjectName,sm.Semester_id,sm.CourseLevel,sm.id,sm.Division_id,sm.Department_id,sm.Branches_id,s.std_complete_name,s.std_name, s.std_Father_name,s.std_lastname, s.std_class, sm.AcademicYear as AcademicYear
    FROM tbl_student_subject_master sm
    LEFT JOIN tbl_student s on s.school_id=sm.school_id AND sm.student_id=s.std_PRN where sm.school_id='$school_id' and s.school_id='$school_id' And sm.AcademicYear='$x'";
    }
} else {
    $arr = "SELECT sm.id as subject_master_id,sm.student_id,sm.teacher_ID,sm.subjcet_code,sm.subjectName,sm.Semester_id,sm.CourseLevel,sm.id,sm.Division_id,sm.Department_id,sm.Branches_id,s.std_complete_name,s.std_name, s.std_Father_name,s.std_lastname, s.std_class, sm.AcademicYear as AcademicYear
     FROM tbl_student_subject_master sm
     LEFT JOIN tbl_student s on s.school_id=sm.school_id AND sm.student_id=s.std_PRN where sm.school_id='$school_id' and s.school_id='$school_id'";
}

$sql1 = mysql_query($arr);
$total = mysql_num_rows($sql1);
if (!isset($_GET['page'])) {
    $page = 0;
}
$total_page = ceil($total / MAX_REC_PER_PAGE);
$page = intval($_GET['page']);
if ($page == 0 || $page == '') {
    $page = 1;
}
$start = MAX_REC_PER_PAGE * ($page - 1);
$end = MAX_REC_PER_PAGE;
if ($total_page == $_GET['page']) {
    $end = $total;
} else {
    $end = $start + $end;
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
<script src="jquery.js"></script>
<script src="js/jquery-1.11.1.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="jquery.dataTables.js"></script>
<script src="js/jquery.dataTables.min.js"></script>
<script src="js/jquery.twbsPagination.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">



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

    #abc {
        display: inline;
    }
</style>

<script type="text/javascript">
    $(function() {
        var total_page = <?php echo $total_page; ?>;
        var start_page = <?php echo $page; ?>;
        window.pagObj = $('#pagination').twbsPagination({
            totalPages: total_page,
            visiblePages: 10,
            startPage: start_page,
            onPageClick: function(event, page) {

                console.info(page + ' (from options)');
            }
        }).on('page', function(event, page) {
            console.info(page + '(from event listening)');
            console.log(page);
            // window.location.assign('list_student_subject.php?page='+page+'&school_id=<?php echo $school_id; ?>' );

            window.location.assign('list_student_subject.php?&page=' + page + '&school_id=<?php echo $school_id . "&AcademicYear=" . $AcademicYear . "&std_complete_name=" . $std_complete_name . "&t_complete_name=" . $t_complete_name . "&CourseLevel=" . $CourseLevel . "&std_class=" . $std_class . "&subject_code=" . $subject_code . "&Semester_id=" . $Semester_id . "&Division_id=" . $Division_id . "&Department_id=" . $Department_id; ?>');


        });
    });

    function confirmation(xxx) {
        // alert(xxx);
        var answer = confirm("Are you sure you want to delete?")
        if (answer) {
            //alert('Record Deleted Successfully'); //Done comment by Dhanashri_Tak on 15/6/18
            window.location = "delete_teacher_subject_master.php?id=" + xxx;
        }

    }
</script>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Untitled Document</title>
</head>
<script>
    $(document).ready(function() {
        $('#example').dataTable({});
        "paging": false,
        "searching": true,
        "info": false,
        "scrollCollapse": true
    });
</script>

<body bgcolor="#CCCCCC">
    <div style="bgcolor:#CCCCCC">

        <div class="container" style="padding:30px;">


            <div style="border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">


                <div style="background-color:#F8F8F8;">
                    <div class="row">

                        <div class="col-md-4" style="color:#700000 ;padding:5px;">&nbsp;&nbsp;&nbsp;&nbsp;
                            <a href="Add_student_subject.php"> <input type="submit" class="btn btn-success" name="submit" value="Add <?php echo $dynamic_student; ?> <?php echo $dynamic_subject; ?>" style="width:170;font-weight:bold;font-size:14px;" />
                            </a>
                        </div>
                        <div class="col-md-4" align="center">
                            <h2><?php echo $dynamic_student . " " . $dynamic_subject; ?> List </h2>
                        </div>
                        <div class="col-md-4" style="color:#700000; padding-top:5px;">
                            <a href="generate_student_subject.php"> <input type="submit" class="btn btn-success pull-right" name="submit" value="Generate <?php echo $dynamic_student; ?> <?php echo $dynamic_subject; ?>" style="font-size:14px;" />
                            </a>
                        </div>
                    </div>

                    <div class="row" style="padding:10px;">
                        <form action="" method="post" style="margin-top:9px; padding:10px;">
                            <table id="example" align="center" style="margin-top: 1cm;" cellspacing="5px">


                                <div class="col-md-2"></div>

                                <div id="abc">
                                    <tr>
                                        <td>
                                            <div class="row ">
                                                <div class="col-md-7 col-md-offset-2" align="left" style="color:#003399;font-size:16px;margin-top: -20px;margin-left: 50px;">
                                                    <b> <?php echo $dynamic_student; ?> ID </b>
                                                </div>
                                                <div class="col-md-5 form-group">
                                                    <input type="text" class="form-control" id="student_id" name="student_id" placeholder="Enter Student ID" value="<?php if (isset($_POST['student_id'])) {
                                                                                                                                                                        echo $_POST['student_id'];
                                                                                                                                                                    } ?>" style="width: 200px; padding:5px; text-align: center;" />
                                                </div>

                                            </div>
                                        </td>
                                        <td>
                                            <div class="row ">
                                                <div class="col-md-7 col-md-offset-2" align="left" style="color:#003399;font-size:16px;margin-top: -20px;margin-left: 50px;">
                                                    <b><?php echo $dynamic_student; ?> Name </b>
                                                </div>
                                                <div class="col-md-5 form-group">
                                                    <input type="text" class="form-control" id="std_complete_name" name="std_complete_name" placeholder="Enter Student Name" value="<?php if (isset($_POST['std_complete_name'])) {
                                                                                                                                                                                        echo $_POST['std_complete_name'];
                                                                                                                                                                                    } ?>" style="width:200px;padding:5px; text-align: center;" />
                                                </div>

                                            </div>
                                        </td>

                                        <td>
                                            <div class="row ">
                                                <div class="col-md-7 col-md-offset-2" align="left" style="color:#003399;font-size:16px;margin-top: -20px;margin-left: 50px;">
                                                    <b>Course Level</b>
                                                </div>
                                                <div class="col-md-5 form-group">
                                                    <input type="text" class="form-control" id="CourseLevel" name="CourseLevel" placeholder=" Enter Course Level" value="<?php if (isset($_POST['CourseLevel'])) {
                                                                                                                                                                                echo $_POST['CourseLevel'];
                                                                                                                                                                            } ?>" style="width:200px; padding:5px; text-align: center;" />
                                                </div>

                                            </div>
                                        </td>
                                        <td>
                                            <div class="row ">
                                                <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px;margin-top: -20px;margin-left: 50px;">
                                                    <b>Department</b>
                                                </div>
                                                <div class="col-md-5 form-group">
                                                    <input type="text" class="form-control" id="Department_id" name="Department_id" placeholder="Enter Department Name" value="<?php if (isset($_POST['Department_id'])) {
                                                                                                                                                                                    echo $_POST['Department_id'];
                                                                                                                                                                                } ?>" style="width:200px; padding: 5px; text-align: center;" />
                                                </div>

                                            </div>
                                        </td>
                                    </tr>
                                    <tr style="height: 10px;">

                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="row ">
                                                <div class="col-md-7 col-md-offset-2" align="left" style="color:#003399;font-size:16px;margin-top: -20px;margin-left: 50px;">
                                                    <b> <?php echo $dynamic_subject; ?> Code</b>
                                                </div>
                                                <div class="col-md-5 form-group">
                                                    <input type="text" class="form-control" id="subjcet_code" name="subjcet_code" placeholder="Enter Subject Code" value="<?php if (isset($_POST['subjcet_code'])) {
                                                                                                                                                                                echo $_POST['subjcet_code'];
                                                                                                                                                                            } ?>" style="width:200px; padding:5px; text-align: center;" />

                                                </div>

                                            </div>
                                        </td>

                                        <td>
                                            <div class="row ">
                                                <div class="col-md-7 col-md-offset-2" align="left" style="color:#003399;font-size:16px;margin-top: -28px;margin-left: 50px;">
                                                    <b> <?php echo ($_SESSION['usertype'] == 'Manager') ? 'Evaluation' : 'Academic'; ?> Year</b>
                                                </div>
                                                <div class="col-md-11 form-group" style="margin-top: -10px;">
                                                    <select name="AcademicYear" class=" form-control" style="text-indent:30%">

                                                        <?php
                                                        $sql = " SELECT ExtYearID,Academic_Year, Enable FROM tbl_academic_Year where school_id='$school_id' and ExtYearID != '' group by Academic_Year";
                                                        $res = mysql_query($sql);
                                                        $result = mysql_fetch_array($res);
                                                        while ($value = mysql_fetch_array($res)) { ?>
                                                            <option value="<?php echo $value['Academic_Year']; ?>" <?php if (isset($_POST['AcademicYear'])) {
                                                                                                                        if ($value['Academic_Year'] == $_POST['AcademicYear']) {
                                                                                                                            echo "selected";
                                                                                                                        }
                                                                                                                    } else {
                                                                                                                        if ($value['Enable'] == 1) echo "selected";
                                                                                                                    } ?> style="text-indent:30%"><?php echo $value['Academic_Year']; ?></option>
                                                        <?php }
                                                        ?>

                                                    </select>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="row ">
                                                <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px;margin-top: -20px;margin-left: 50px;">
                                                    <b>Division</b>
                                                </div>
                                                <div class="col-md-5 form-group">
                                                    <input type="text" class="form-control" id="Division_id" name="Division_id" placeholder="Enter Division Name" value="<?php if (isset($_POST['Division_id'])) {
                                                                                                                                                                                echo $_POST['Division_id'];
                                                                                                                                                                            } ?>" style="width:200px;padding:5px; text-align: center;" />

                                                </div>

                                            </div>
                                        </td>
                                        <td>

                                            <div class="row ">
                                                <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px;margin-top: -20px;margin-left: 50px;">
                                                    <b>Class</b>
                                                </div>
                                                <div class="col-md-5 form-group">
                                                    <input type="text" class="form-control" id="std_class" name="std_class" placeholder="Enter Class Name" value="<?php if (isset($_POST['std_class'])) {
                                                                                                                                                                        echo $_POST['std_class'];
                                                                                                                                                                    } ?>" style="width:200px; padding:5px; text-align: center;" />

                                                </div>

                                            </div>

                                        </td>
                                        <td>


                                            <div class="row ">
                                                <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px;margin-top: -20px;margin-left: 50px;">
                                                    <b>Semester</b>
                                                </div>
                                                <div class="col-md-5 form-group">
                                                    <input type="text" class="form-control" id="Semester_id" name="Semester_id" placeholder="Enter Semester Name" value="<?php if (isset($_POST['Semester_id'])) {
                                                                                                                                                                                echo $_POST['Semester_id'];
                                                                                                                                                                            } ?>" style="width:200px; padding:5px; text-align: center;" />
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </div>
                            </table>

                            <div class="row">
                                <div class="col-md-3 col-md-offset-2" style="padding:10px;">
                                    <input type="submit" name="submit1" id="submit1" class='btn btn-success' style="width:50%; margin-left:200px;color:#FFFFFF;" value="Submit" />
                                </div>
                                <div class="col-md-3 col-md-offset-1" style="padding:10px;">
                                    <a href="list_student_subject.php"><input type="button" class='btn btn-danger' name="Back" value="Back" style="width:50%;margin-left:0px;color:#FFFFFF;" /></a>
                                </div>
                            </div>
                        </form>
                    </div>
    <?php
        //This part will execute only of Submit button is pressed,i.e, Filters are inserted. 
        if (isset($_POST['submit1']) || count($_SESSION['list_student_subject']) > 0) {
            if(count($_POST)>0) {
                $_SESSION['list_student_subject'] = $_POST;
            } else {
                $_POST = $_SESSION['list_submit_subject'];
            }

            $student_id             = trim($_POST['student_id']);
            $std_complete_name      = trim($_POST['std_complete_name']);
            $t_complete_name        = trim($_POST['t_complete_name']);
            $CourseLevel            = trim($_POST['CourseLevel']);
            $std_class              = trim($_POST['std_class']);
            $subject_code           = trim($_POST['subjcet_code']);
            $Semester_id            = trim($_POST['Semester_id']);
            $Division_id            = trim($_POST['Division_id']);
            $Department_id          = trim($_POST['Department_id']);
            $AcademicYear           = trim($_POST['AcademicYear']);

            $query = "select DISTINCT sm.student_id,sm.id as subject_master_id,sm.teacher_ID,sm.subjcet_code,sm.subjectName,sm.Semester_id,sm.CourseLevel,sm.id,sm.Division_id,sm.Department_id,sm.Branches_id, sm.AcademicYear,s.std_complete_name,s.std_name, s.std_Father_name,s.std_lastname, s.std_class FROM tbl_student_subject_master sm
            LEFT JOIN tbl_student s on s.school_id=sm.school_id AND sm.student_id=s.std_PRN where sm.school_id='$school_id' and s.school_id='$school_id'";

            $query1 = "";

            if ($_POST['student_id'] == ''  &&  $_POST['std_complete_name'] == '' && $_POST['t_complete_name'] == '' && $_POST['CourseLevel'] == '' && $_POST['std_class'] == '' && $_POST['subjcet_code'] == '' && $_POST['Semester_id'] == '' && $_POST['Division_id'] == '' && $_POST['Department_id'] == '' && $_POST['AcademicYear'] == '') {
                echo "<script>window.alert('please enter a field')</script>";
                echo "<script>window.location.assign('list_student_subject.php')</script>";
            } else {
                if ($student_id != '') {
                    $query1 .= " and sm.student_id like '%$student_id%'";
                }
                if ($std_complete_name != '') {
                    $query1 .= " and s.std_complete_name like '%$std_complete_name%'";
                }

                if ($CourseLevel != '') {
                    $query1 .= " and sm.CourseLevel like '%$CourseLevel%'";
                }
                if ($std_class != '') {
                    $query1 .= " and s.std_class like '%$std_class%'";
                }
                if ($subject_code != '') {
                    $query1 .= " and sm.subjcet_code like '%$subject_code%'";
                }
                if ($Semester_id != '') {
                    $query1 .= " and sm.Semester_id like '$Semester_id'";
                }
                if ($Division_id != '') {
                    $query1 .= " and sm.Division_id like '%$Division_id%'";
                }
                if ($Department_id != '') {
                    $query1 .= " and sm.Department_id like '%$Department_id%'";
                }
                if ($AcademicYear != '' && $AcademicYear != 'All') {
                    $query1 .= " and sm.AcademicYear = '$AcademicYear'";
                }

                $query1 .= " LIMIT $start,10";
                $arr = $query . $query1;
                // echo $arr;

            }
        } else if ($x != '') {
            if ($x == 'All') {
                $arr = "SELECT sm.id as subject_master_id,sm.student_id,sm.teacher_ID,sm.subjcet_code,sm.subjectName,sm.Semester_id,sm.CourseLevel,sm.id,sm.Division_id,sm.Department_id,sm.Branches_id,s.std_complete_name,s.std_name, s.std_Father_name,s.std_lastname, s.std_class, sm.AcademicYear as AcademicYear
                FROM tbl_student_subject_master sm
                LEFT JOIN tbl_student s on s.school_id=sm.school_id AND sm.student_id=s.std_PRN where sm.school_id='$school_id' and s.school_id='$school_id' LIMIT $start,10";
            } else {
                $arr = "SELECT sm.id as subject_master_id,sm.student_id,sm.teacher_ID,sm.subjcet_code,sm.subjectName,sm.Semester_id,sm.CourseLevel,sm.id,sm.Division_id,sm.Department_id,sm.Branches_id,s.std_complete_name,s.std_name, s.std_Father_name,s.std_lastname, s.std_class, sm.AcademicYear as AcademicYear
                FROM tbl_student_subject_master sm
                LEFT JOIN tbl_student s on s.school_id=sm.school_id AND sm.student_id=s.std_PRN where sm.school_id='$school_id' and s.school_id='$school_id' And sm.AcademicYear='$x' LIMIT $start,10";
            }
        } else {
                $arr = "SELECT sm.id as subject_master_id,sm.student_id,sm.teacher_ID,sm.subjcet_code,sm.subjectName,sm.Semester_id,sm.CourseLevel,sm.id,sm.Division_id,sm.Department_id,sm.Branches_id,s.std_complete_name,s.std_name, s.std_Father_name,s.std_lastname, s.std_class, sm.AcademicYear as AcademicYear
                FROM tbl_student_subject_master sm
                LEFT JOIN tbl_student s on s.school_id=sm.school_id AND sm.student_id=s.std_PRN where sm.school_id='$school_id' and s.school_id='$school_id' LIMIT $start, 10";
        }

        $sql = mysql_query($arr);
        if (mysql_num_rows($sql) > 0) {
            $test = 1;
        } else {
            echo "<script>window.alert('No records found')</script>";
            // echo "<script>window.location.assign('list_student_subject.php')</script>";
        }

        // exit();
    ?>
                    <div class="row" id="main" style="padding:10px;">
                        <div class="col-md-12 table-responsive" id="no-more-tables">

                            <?php $i = 0; ?>


                            <table id="example" class="display" width="100%" cellspacing="0" border="1" cellpadding="5">
                                <table class="table-bordered" id="example">
                                    <thead>
                                        <tr style="background-color:#0073BD; color:#ffffff;font-family:Times New Roman, Times, serif;font-size:17px">
                                            <!-- Camel casing done for Sr. No. by Pranali -->
                                            <th style="width:30px;"><b>

                                                    <center>Sr. No.</center>
                                                </b>
                                            </th>

                                            <th style="width:350px;">
                                                <center><?php echo $dynamic_student; ?> Name / </center>

                                                <center><?php //echo $dynamic_student;
                                                        ?> ID</center>
                                            </th>

                                            <th style="width:350px;">
                                                <center><?php echo $dynamic_subject; ?> Title / </center>

                                                <center><?php //echo $dynamic_subject;
                                                        ?> Code</center>
                                            </th>


                                            <?php if (($school_type == 'school' or $school_type == 'organization') && $user == 'School Admin' || $user == 'School Admin Staff') { ?>
                                                <th style="width:350px;">
                                                    <center>Branch / </center>

                                                    <center>Department</center>
                                                </th>
                                                <th style="width:50px;">
                                                    <center>Semester Name / </center>
                                                    <center>Academic Year</center>
                                                </th>
                                                <th style="width:50px;">
                                                    <center>Division / </center>

                                                    <center>Class</center>
                                                </th>
                                                <th style="width:50px;">


                                                    <center>Course Level</center>
                                                </th>


                                            <?php } ?>
                                            <th style="width:50px;">
                                                <center>Edit</center>
                                            </th>
                                            <th style="width:100px;">
                                                <center>Delete</center>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        $arr = mysql_query("select DISTINCT sm.student_id,sm.teacher_ID,sm.subjcet_code,sm.subjectName,sm.Semester_id,sm.CourseLevel,sm.id,sm.Division_id,sm.Department_id,sm.Branches_id, sm.AcademicYear,s.std_complete_name,s.std_name, s.std_Father_name,s.std_lastname, s.std_class FROM tbl_student_subject_master sm
LEFT JOIN tbl_student s on s.school_id=sm.school_id AND sm.student_id=s.std_PRN and sm.AcademicYear=s.AcademicYear where sm.school_id='$school_id' and s.school_id='$school_id' order by `id` LIMIT $start_page, 10");
                                        ?>
                                        <?php echo $arr; ?>
                                        <?php
                                        if ($test == 1) {
                                            $c = $start + 1;
                                            while ($rows = mysql_fetch_array($sql)) { ?>
                                                <?php


                                                $id = $rows['student_id'];

                                                $std_comp_name = $rows['std_complete_name'];
                                                $tch_comp_name = $rows['t_complete_name'];
                                                $crs_lvl = $rows['CourseLevel'];
                                                $stud_class = $rows['std_class'];
                                                $subj_Name = $rows['subjectName'];
                                                $subj_code = $rows['subjcet_code'];
                                                $sem_id = $rows['Semester_id'];
                                                $div_id = $rows['Division_id'];
                                                $branch_id = $rows['Branches_id'];
                                                $dept_id = $rows['Department_id'];
                                                $aca_year = $rows['AcademicYear'];                                            ?>


                                                <tr style="font-family:Times New Roman, Times, serif;font-size:17px; color:#333;">
                                                    <td style="width:20px;"><b>
                                                            <center><?php echo $c; ?></center>
                                                        </b></td>

                                                    <td style="width:100px;">
                                                        <center><?php echo $rows['std_complete_name'] . ' / ' . $rows['student_id']; ?> </center>
                                                    </td>

                                                    <td style="width:400px;">
                                                        <center><?php echo $rows['subjectName'] . ' / ' . $rows['subjcet_code']; ?> </center>
                                                    </td>


                                                    <?php if (($school_type == 'school' or $school_type == 'organization') && $user == 'School Admin' || $user == 'School Admin Staff') { ?>
                                                        <td style="width:400px;">
                                                            <center><?php echo $rows['Branches_id'] . ' / ' . $rows['Department_id']; ?></center>
                                                        </td>
                                                        <td style="width:50px;">
                                                            <center><?php echo $rows['Semester_id'] . ' / ' . $rows['AcademicYear']; ?> </center>
                                                        </td>
                                                        <td style="width:50px;">
                                                            <center><?php echo $rows['Division_id'] . ' / ' . $rows['std_class']; ?></center>
                                                        </td>

                                                        <td style="width:50px;">


                                                            <center><?php echo $rows['CourseLevel']; ?></center>
                                                        </td>


                                                    <?php } ?>
                                                    <td style="width:100px;">

                                                        <center>
                                                            <a href="Add_student_subject.php?subject=<?= $rows['subjcet_code']; ?>&student_id=<?php echo $rows['student_id']; ?>&school_id=<?php echo $school_id; ?>" style="width:100px;"><span class="glyphicon glyphicon-pencil"></span> </a>

                                                        </center>
                                                    </td>
                                                    <td style="width:100px;">
                                                        <center><a onClick="confirmation('<?php echo $rows['subject_master_id'] ?>' )"><span class="glyphicon glyphicon-trash"></span></a>
                                                        </center>
                                                    </td>
                                                </tr>

                                                <?php $c++; ?>
                                            <?php  } ?>
                                        <?php   } else {
                                        ?>


                                            <?php

                                            $arr = mysql_query("select sm.student_id,sm.subjcet_code,sm.subjectName,sm.Branches_id,sm.Semester_id,sm.CourseLevel,sm.id,sm.Division_id,sm.Department_id,sm.AcademicYear,
 s.std_complete_name,s.std_name,s.std_class, s.std_Father_name, s.std_lastname from tbl_student_subject_master sm inner join tbl_academic_Year Y on sm.AcademicYear=Y.Academic_Year LEFT JOIN tbl_student s on s.school_id=sm.school_id AND sm.student_id=s.std_PRN sm.AcademicYear=Y.AcademicYear where sm.school_id='$school_id' and Y.school_id='$school_id' and Y.Enable=1 desc LIMIT $start, 10");


                                            echo $arr;
                                            ?>

                                            <?php
                                            $c = $start + 1;
                                            while ($row = mysql_fetch_array($arr)) {
                                                $PRN = $row['student_id'];
                                                $std_id = $row['id'];
                                                $teacher_ID = $row['teacher_ID'];

                                            ?>
                                                <tr style="font-family:Times New Roman, Times, serif;font-size:17px; color:#333;">
                                                    <td style="width:20px;"><b>
                                                            <center><?php echo $c; ?></center>
                                                        </b></td>
                                                    <?php

                                                    $getteachername = mysql_query("select std_complete_name,std_name,std_Father_name,std_lastname,std_class
                                        from tbl_student where std_PRN='$PRN' and school_id='$school_id'");


                                                    while ($getRows = mysql_fetch_array($getteachername)) {
                                                        $name = $getRows['std_name'];
                                                        $Mname = $getRows['std_Father_name'];
                                                        $Lname = $getRows['std_lastname'];
                                                        $std_class = $getRows['std_class'];
                                                        $studentName = $getRows['std_complete_name'];
                                                        if ($studentName == '') {

                                                            $studentName = $name . " " . $Mname . " " . $Lname;
                                                        } else {
                                                            $studentName;
                                                        }
                                                    }

                                                    ?>

                                                    <td style="width:100px;">
                                                        <center><?php echo $studentName . ' / ' . $row['student_id']; ?> </center>

                                                    </td>

                                                    <td style="width:400px;">
                                                        <center><?php echo $row['subjectName'] . ' / ' . $row['subjcet_code']; ?> </center>
                                                    </td>


                                                    <?php if (($school_type == 'school' or $school_type == 'organization') && $user == 'School Admin' || $user == 'School Admin Staff') { ?>
                                                        <td style="width:400px;">
                                                            <center><?php echo $row['Branches_id'] . ' / ' . $row['Department_id']; ?></center>
                                                        </td>
                                                        <td style="width:50px;">
                                                            <center><?php echo $row['Semester_id'] . ' / ' . $row['AcademicYear']; ?> </center>
                                                        </td>
                                                        <td style="width:50px;">
                                                            <center><?php echo $row['Division_id'] . ' / ' . $row['std_class']; ?></center>
                                                        </td>
                                                        <td style="width:50px;">


                                                            <center><?php echo $row['CourseLevel']; ?></center>
                                                        </td>
                                                    <?php } ?>
                                                    <td style="width:100px;">

                                                        <center><?php $subjcet_code = $row['subjcet_code']; ?>
                                                            <a href="Add_student_subject.php?subject=<?= $subjcet_code; ?>&student_id=<?php echo $row['student_id']; ?>&school_id=<?php echo $school_id; ?>" style="width:100px;"><span class="glyphicon glyphicon-pencil"></span> </a>

                                                        </center>
                                                    </td>
                                                    <td style="width:100px;">
                                                        <?php // echo $row['student_id'];
                                                        ?>
                                                        <center><a onClick="confirmation('<?php echo $std_id; ?>' )"><span class="glyphicon glyphicon-trash"></span></a>
                                                        </center>
                                                    </td>
                                                </tr>
                                                <?php $c++; ?>
                                            <?php } ?>
                                        <?php } ?>


                                    </tbody>
                                </table>
                        </div>
                    </div>
                    <div align='center'>

                        <?php
                        if ($end > $total) {
                            $end = $total;
                        }
                        if ($total == 0) {
                            $start = $start - 1;
                        }
                        echo "<div style='margin-top:5px;'><font color='#0073BD'><style='margin-left:600px;'>Now showing " . ($start + 1) . " to " . ($end) . " records out of " . ($total) . " records.</font></style></div>";
                        ?>
                        <div class="container">
                            <nav aria-label="Page navigation">
                                <ul class="pagination" id="pagination"></ul>
                            </nav>
                        </div>
                    </div>

                </div>
            </div>

            <div class="row" style="padding:5px;">

                <div class="col-md-4">

                </div>

                <div class="col-md-3 " align="center">



                </div>

            </div>

            <div class="row">

                <div class="col-md-4">

                </div>

                <div class="col-md-3" style="color:#FF0000;" align="center">

                    <?php echo $report; ?>

                </div>
            </div>
        </div>
    </div>
    </div>
    </div>

    <script type="text/javascript">
        $(function() {
            var total_page = <?php echo $total_page; ?>;
            var start_page = <?php echo $page; ?>;
            window.pagObj = $('#pagination').twbsPagination({
                totalPages: total_page,
                visiblePages: 10,
                startPage: start_page,
                onPageClick: function(event, page) {

                    console.info(page + ' (from options)');
                }

            }).on('page', function(event, page) {
                console.info(page + '(from event listening)');
                console.log(page);
                // window.location.assign('list_student_subject.php?page='+page+'&school_id=<?php echo $school_id; ?>' );


                window.location.assign('list_student_subject.php?&page=' + page + '&school_id=<?php echo $school_id . "&AcademicYear=" . $AcademicYear . "&std_complete_name=" . $std_complete_name . "&t_complete_name=" . $t_complete_name . "&CourseLevel=" . $CourseLevel . "&std_class=" . $std_class . "&subject_code=" . $subject_code . "&Semester_id=" . $Semester_id . "&Division_id=" . $Division_id . "&Department_id=" . $Department_id; ?>');
            });
        });
    </script>
    </div>

    </td>

</body>

</html>