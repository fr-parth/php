<?php
error_reporting(0);
include('scadmin_header.php');?>

<?php
$report = "";
  $std_PRN = $_GET['id'];
 // $sc_id = $_GET['school_id'];
$key = $_GET['key'];
$sc_id=$_SESSION['school_id']; 
$fields = array("id" => $id);
/* $table="tbl_school_admin";  */
$smartcookie = new smartcookie();
$results = $smartcookie->retrive_individual($table, $fields);
$result = mysql_fetch_array($results);
//$sc_id = $result['school_id'];
$school_name = $result['school_name'];

$sql = mysql_query("select * from tbl_student where school_id='$sc_id' and std_PRN='$std_PRN'");
$result1 = mysql_fetch_array($sql);
//$arr=mysql_query( "SELECT  semester.student_id, semester.SemesterName, semester.BranchName, semester.Specialization, semester.DeptName, semester.CourseLevel, semester.DivisionName, semester.AcdemicYear FROM StudentSemesterRecord AS semester JOIN tbl_student AS std ON std.std_PRN = semester.student_id JOIN //tbl_academic_Year a ON semester.AcdemicYear=a.Year where semester.school_id='$sc_id' and std.std_PRN='$std_PRN' and std.school_id='$sc_id' and semester.////`IsCurrentSemester`='1' and a.Enable='1' and a.school_id='$sc_id'");
//$result_arr=mysql_fetch_array($arr);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title><?php echo $dynamic_student;?> Information</title>
    <style>
        .preview {
            border-radius: 50% 50% 50% 50%;
            height: 100px;
            box-shadow: 0 3px 2px rgba(0, 0, 0, 0.3);
            -webkit-border-radius: 99em;
            -moz-border-radius: 99em;
            border-radius: 99em;
            border: 5px solid #eee;
            width: 100px;
        }

        .button {

            color: #fff;
            background-color: #428bca;
            border-color: 357 ebd;
        }
    </style>
</head>

<body bgcolor="#CCCCCC">
<div style="bgcolor:#CCCCCC">
    <div>

    </div>
    <div class="container" style="padding:25px;">


        <div style="padding:2px 2px 2px 2px;border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">
            <div style="background-color:#F8F8F8 ;">
                <?php switch ($key) {
                    case 1: ?><a href="studentlist.php">
                        <input type="button" name="Submit" id="n8" value="Back" class="button">
                    </a><?php break;
                    case 2: ?><!--<a href="subjectwise_student.php?prn=<?php //echo $row['student_id'];?>">-->
                        <input type="button" id="n8" value="Back" onClick="history.go(-1);" class="button">
                        </a>

                        <?php break;
                    default: ?>  <a href="studentlist.php">
                        <input type="button" name="Submit" id="n8" value="Back" class="button">
                    </a> <?php } ?>


                <div class="row">
                    <div class="col-md-3 " style="color:#700000 ;padding:5px;">&nbsp;&nbsp;&nbsp;&nbsp;
                        <!--      <a href="add_school_subject.php">   <input type="submit" class="btn btn-primary" name="submit" value="Add Subject" style="width:110px;font-weight:bold;font-size:14px;"/></a>-->
                    </div>
                    <div class="col-md-6 " align="center">

                        <h2><?php echo $dynamic_student;?> Information</h2>
                    </div>

                </div>


                <div class="row" style="margin-top:3%;">

                    <div class="col-md-5"></div>
                    <div class="col-md-2" align="center">
                        <div id="preview">
                            <?php
                            if ($result1['std_img_path'] == "") {
                                ?>

                                <img src="image/avatar_2x.png" class='preview'/><?php } else {
                                ?>
                                <img src="<?php echo $result1['std_img_path']; ?>" class='preview'
                                     style="height:100px;width:100px;"/>
                            <?php } ?>
                        </div>


                    </div>


                </div>
                <div class="row" style="margin-top:3%;">

                    <div class="col-md-4"></div>
                    <div class="col-md-2">
                        <b>Name</b></div>
                    <div class="col-md-4"><b>
                            <?php if ($result1['std_complete_name'] == "") {
                                echo ucwords(strtolower($result1['std_name'] . " " . $result1['std_Father_name'] . " " . $result1['std_lastname']));
                            } else {
                                echo ucwords(strtolower($result1['std_complete_name']));
                            }
                            ?></b>
                    </div>
                </div>
                <div class="row" style="margin-top:2%;">

                    <div class="col-md-4"></div>
                    <div class="col-md-2">
                        <b><?php echo $dynamic_student;?> PRN</b></div>
                    <div class="col-md-4"><b>
                            <?php echo $std_PRN;
                            ?></b>
                    </div>
                </div>
                <div class="row" style="margin-top:2%;">

                    <div class="col-md-4"></div>
                    <div class="col-md-2">
                        <b><?php echo $dynamic_student;?> MemberID</b></div>
                    <div class="col-md-4"><b>
                            <?php echo $result1['id'];
                            ?></b>
                    </div>
                </div>
                <div class="row" style="margin-top:2%;">

                    <div class="col-md-4"></div>
                    <div class="col-md-2">
                        <b><?php echo $organization;?> Name</b></div>
                    <div class="col-md-4"><b>
                            <?php echo $result['school_name'];
                            ?></b>
                    </div>
                </div>
                <div class="row" style="margin-top:2%;">

                    <div class="col-md-4"></div>
                    <div class="col-md-2">
                        <b>Internal Email ID</b></div>
                    <div class="col-md-4"><b>
                            <?php echo $result1['Email_Internal'];
                            ?></b>
                    </div>
                </div>

                <div class="row" style="margin-top:2%;">

                    <div class="col-md-4"></div>
                    <div class="col-md-2">
                        <b>External Email ID</b></div>
                    <div class="col-md-4"><b>
                            <?php echo $result1['std_email'];
                            ?></b>
                    </div>
                </div>

                <div class="row" style="margin-top:2%;">

                    <div class="col-md-4"></div>
                    <div class="col-md-2">
                        <b>Phone No</b></div>
                    <div class="col-md-4"><b>
                            <?php echo $result1['std_phone'];
                            ?></b>
                    </div>
                </div>
                <div class="row" style="margin-top:2%;">

                    <div class="col-md-4"></div>
                    <div class="col-md-2">
                        <b>Address</b></div>
                    <div class="col-md-6"><b>
                            <?php echo $result1['permanent_address'];
                            ?></b>
                    </div>
                </div>
			
				<div class="row" style="margin-top:2%;">

                    <div class="col-md-4"></div>
                    <div class="col-md-2">
                        <b>Country</b></div>
                    <div class="col-md-6"><b>
                            <?php echo $result1['std_country'];
                            ?></b>
                    </div>
                </div>
				
				<div class="row" style="margin-top:2%;">

                    <div class="col-md-4"></div>
                    <div class="col-md-2">
                        <b>State</b></div>
                    <div class="col-md-6"><b>
                            <?php echo $result1['std_state'];
                            ?></b>
                    </div>
                </div>
				
				<div class="row" style="margin-top:2%;">

                    <div class="col-md-4"></div>
                    <div class="col-md-2">
                        <b>City</b></div>
                    <div class="col-md-6"><b>
                            <?php echo $result1['std_city'];
                            ?></b>
                    </div>
                </div>
				
                <div class="row" style="margin-top:2%;">

                    <div class="col-md-4"></div>
                    <div class="col-md-2">
                        <b>Department</b></div>
                    <div class="col-md-6"><b>
                            <?php echo $result1['std_dept'];
                            ?></b>
                    </div>
                </div>

                <div class="row" style="margin-top:2%;">

                    <div class="col-md-4"></div>
                    <div class="col-md-2">
                        <b><?php echo $dynamic_branch;?></b></div>
                    <div class="col-md-6"><b>
                            <?php echo $result1['std_branch'];
                            ?></b>
                    </div>
                </div>

                <div class="row" style="margin-top:2%;">

                    <div class="col-md-4"></div>
                    <div class="col-md-2">
                        <b>Specialization</b></div>
                    <div class="col-md-6"><b>
                            <?php echo $result1['Specialization'];
                            ?></b>
                    </div>
                </div>


                <div class="row" style="margin-top:2%;">

                    <div class="col-md-4"></div>
                    <div class="col-md-2">
                        <b><?php echo $dynamic_level;?></b></div>
                    <div class="col-md-6"><b>
                            <?php echo $result1['Course_level'];
                            ?></b>
                    </div>
                </div>


                <div class="row" style="margin-top:2%;">

                    <div class="col-md-4"></div>
                    <div class="col-md-2">
                        <b><?php echo $dynamic_semester;?></b></div>
                    <div class="col-md-6"><b>
                            <?php echo $result1['std_semester'];
                            ?></b>
                    </div>
                </div>

                <div class="row" style="margin-top:2%;">

                    <div class="col-md-4"></div>
                    <div class="col-md-2">
                        <b><?php echo $designation;?></b></div>
                    <div class="col-md-6"><b>
                            <?php echo $result1['std_div'];
                            ?></b>
                    </div>
                </div>


                <div class="row" style="margin-top:2%;">

                    <div class="col-md-4"></div>
                    <div class="col-md-2">
                        <b><?php echo $dynamic_year;?></b></div>
                    <div class="col-md-6"><b>
                            <?php echo $result1['Academic_Year'];
                            ?></b>
                    </div>
                </div>

                <div class="row" style="margin-top:2%;">

                    <div class="col-md-4"></div>
                    <div class="col-md-2" style="color:blue;">
                        <b>Blue Points</b></div>
                    <div class="col-md-6"><b>
                            <?php echo $result1['balance_bluestud_points'];
                            ?></b>
                    </div>
                </div>

                <div class="row" style="margin-top:2%;">

                    <div class="col-md-4"></div>
                    <div class="col-md-2" style="color:#0588BC;">
                        <b>Water Points</b></div>
                    <div class="col-md-6"><b>
                            <?php echo $result1['balance_water_points'];
                            ?></b>
                    </div>
                </div>

                <?php $sql1 = mysql_query("select * from tbl_student_reward where school_id='$sc_id' and sc_stud_id='$std_PRN'");
                $result11 = mysql_fetch_array($sql1); ?>

                <div class="row" style="margin-top:2%;">

                    <div class="col-md-4"></div>
                    <div class="col-md-2" style="color:#298F00;">
                        <b>Green Points</b></div>
                    <div class="col-md-6"><b>
                            <?php if ($result11['sc_total_point'] == "") {
                                echo "0";
                            } else {
                                echo $result11['sc_total_point'];
                            }
                            ?></b>
                    </div>
                </div>

                <div class="row" style="margin-top:2%;">

                    <div class="col-md-4"></div>
                    <div class="col-md-2" style="color:#FFDE00;">
                        <b>Yellow Points</b></div>
                    <div class="col-md-6"><b>
                            <?php if ($result11['yellow_points'] == "") {
                                echo "0";
                            } else {
                                echo $result11['yellow_points'];
                            }
                            ?></b>
                    </div>
                </div>

                <div class="row" style="margin-top:2%;">

                    <div class="col-md-4"></div>
                    <div class="col-md-2" style="color:#6600CC;">
                        <b>Purple Points</b></div>
                    <div class="col-md-6"><b>
                            <?php if ($result11['purple_points'] == "") {
                                echo "0";
                            } else {
                                echo $result11['purple_points'];
                            }
                            ?></b>
                    </div>
                </div>

                <?php
                $std_run_id = $result1['id'];
                $sql1 = mysql_query("select FirstLoginTime, LatestLoginTime, LatestMethod, LogoutTime  from tbl_LoginStatus where EntityID='$std_run_id' order by RowID desc LIMIT 1 ");
                $result111 = mysql_fetch_array($sql1); ?>
                <div class="row" style="margin-top:2%;">

                    <div class="col-md-4"></div>
                    <div class="col-md-2" style="color:#6E6E6E;">
                        <b>First Login</b></div>
                    <div class="col-md-6"><b>
                            <?php echo $result111['FirstLoginTime']; ?></b>

                    </div>
                </div>

                <div class="row" style="margin-top:2%;">

                    <div class="col-md-4"></div>
                    <div class="col-md-2" style="color:#6E6E6E;">
                        <b>Last Login</b></div>
                    <div class="col-md-6"><b>
                            <?php echo $result111['LatestLoginTime']; ?></b>
                    </div>
                </div>

                <div class="row" style="margin-top:2%;">

                    <div class="col-md-4"></div>
                    <div class="col-md-2" style="color:#6E6E6E;">
                        <b>Method</b></div>
                    <div class="col-md-6"><b>
                            <?php echo $result111['LatestMethod'];
                            ?></b>
                    </div>
                </div>

                <div class="row" style="margin-top:2%;">

                    <div class="col-md-4"></div>
                    <div class="col-md-2" style="color:#6E6E6E;">
                        <b>Logout Time</b></div>
                    <div class="col-md-6"><b>
                            <?php echo $result111['LogoutTime'];
                            ?></b>
                    </div>
                </div>

                <div style="height:60px;"></div>


            </div>
        </div>
</body>
</html>
