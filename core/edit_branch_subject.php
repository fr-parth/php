<?php
$report = "";
include("scadmin_header.php");
if (!isset($_SESSION['id'])) {
    header('location:login.php');
}
$id = $_SESSION['id'];
$fields = array("id" => $id);
$table = "tbl_school_admin";
$smartcookie = new smartcookie();
$results = $smartcookie->retrive_individual($table, $fields);
$result = mysql_fetch_array($results);
$sc_id = $result['school_id'];
if (isset($_GET["subject"])) {
    $subject_id = $_GET['subject'];
    //echo "select * from tbl_school_subject where id='$subject_id' and school_id='$sc_id'";
    $sql1 = "select * from Branch_Subject_Division_Year where id='$subject_id' and school_id='$sc_id'";
    $row = mysql_query($sql1);
    $arr = mysql_fetch_array($row);
    $id = $arr['id'];
    ?>
    <?php
    if (isset($_POST['submit'])) {
		if (($school_type == 'school' or $school_type == 'organization') && $user=='School Admin'){
        $Introduce_YearID= $_POST['Intruduce_YeqarID'];
        $SubjectTitle= $_POST['SubjectTitle'];
        $Subject_Code= $_POST['Subject_Code'];
        $SubjectType= $_POST['SubjectType'];
        $SubjectShortName= $_POST['SubjectShortName'];
        $IsEnabled= $_POST['IsEnabled'];
        $CourseLevelPID= $_POST['CourseLevelID'];
        $DeptID= $_POST['DeptID'];
        $DeptName= $_POST['DeptName'];
        $BranchID= $_POST['BranchID'];
        $semesterId= $_POST['semesterId'];
        $SemesterName= $_POST['SemesterName'];
        $DivisionId= $_POST['DivisionId'];
        $DivisionName= $_POST['DivisionName'];
        $Branch= $_POST['BranchName'];
        $courselevel= $_POST['courselevel'];
        $Year= $_POST['Year'];
		}else{
			 $Introduce_YearID= $_POST['Intruduce_YeqarID'];
        $SubjectTitle= $_POST['SubjectTitle'];
        $Subject_Code= $_POST['Subject_Code'];
        $SubjectType= $_POST['SubjectType'];
        $SubjectShortName= $_POST['SubjectShortName'];
        $IsEnabled= $_POST['IsEnabled'];
        $CourseLevelPID= "";
        $DeptID= $_POST['DeptID'];
        $DeptName= $_POST['DeptName'];
        $BranchID= $_POST['BranchID'];
        $semesterId= "";
        $SemesterName= "";
        $DivisionId= $_POST['DivisionId'];
        $DivisionName= $_POST['DivisionName'];
        $Branch= $_POST['BranchName'];
        $courselevel= "";
        $Year= $_POST['Year'];
		}
        $sql3= "update Branch_Subject_Division_Year set Intruduce_YeqarID='$Introduce_YearID', SubjectTitle='$SubjectTitle', SubjectCode='$Subject_Code', SubjectType='$SubjectType',SubjectShortName='$SubjectShortName', 	IsEnable='$IsEnabled',CourseLevelPID='$CourseLevelPID',DeptID='$DeptID',DeptName='$DeptName',BranchID='$BranchID', SemesterID='$semesterId', SemesterName='$SemesterName', DevisionId='$DivisionId',DivisionName='$DivisionName',BranchName='$Branch',CourseLevel='$courselevel',Year='$Year' where id='$id' and school_id='$sc_id'";
        if(mysql_query( $sql3)){
            header("Refresh:0");
            echo "Records were updated successfully.";
        } else {
            echo "ERROR: Could not able to execute " ;
        }
    } ?>
    <html>
    <head>
        <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
        <script>
            function valid() {
                var subject = document.getElementById("subject").value;
                if (subject == "") {
                    document.getElementById('error').innerHTML = 'Please Enter <?php echo $dynamic_subject; ?> ';
                    return false;
                }
                regx = /^[0-9]*$/;
                //validation of subject
                if (regx.test(subject)) {
                    document.getElementById('error').innerHTML = 'Please Enter valid <?php echo $dynamic_subject; ?> ';
                    return false;
                }
            }
        </script>
    </head>
    <body align="center">
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
                                <h2>Edit <?php echo $dynamic_branch;?> Subject</h2>
                            </div>
                            <div class="row ">
                                <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">
                                    <b> Introduce YearID</b>
                                </div>
                                <div class="col-md-5 form-group">
                                    <input type="text" name="Intruduce_YeqarID" id="Intruduce_YeqarID" class="form-control" style="width:100%; padding:5px;" placeholder="Introduce YearID" value="<?php echo $arr['Intruduce_YeqarID'];?>"/>
                                </div>

                                <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">
                                    <b> <?php echo $dynamic_subject; ?> Title</b>
                                </div>
                                <div class="col-md-5 form-group">
                                    <input type="text" name="SubjectTitle" id="SubjectTitle" class="form-control" style="width:100%; padding:5px;" placeholder="SubjectTitle" value="<?php echo $arr['SubjectTitle'];?>"/>
                                </div>

                                <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">
                                    <b> <?php echo $dynamic_subject; ?> code</b>
                                </div>
                                <div class="col-md-5 form-group">
                                    <input type="text" name="Subject_Code" id="Subject_Code" class="form-control" style="width:100%; padding:5px;" placeholder="Enter Subject" value="<?php echo $arr['SubjectCode'];?>"/>
                                </div>

                                <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">
                                    <b> <?php echo $dynamic_subject; ?> Type</b>
                                </div>
                                <div class="col-md-5 form-group">
                                    <input type="text" name="SubjectType" id="SubjectType" class="form-control" style="width:100%; padding:5px;" placeholder="Subject Type" value="<?php echo $arr['SubjectType'];?>"/>
                                </div>

                                <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">
                                    <b><?php echo $dynamic_subject; ?> Short Name</b>
                                </div>
                                <div class="col-md-5 form-group">
                                    <input type="text" name="SubjectShortName" id="SubjectShortName" class="form-control" style="width:100%; padding:5px;" placeholder="Subject Short Name" value="<?php echo $arr['SubjectShortName'];?>"/>
                                </div>


                                <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">
                                    <b> IsEnabled</b>
                                </div>
                                <div class="col-md-5 form-group">
                                    <input type="text" name="IsEnabled" id="IsEnabled" class="form-control" style="width:100%; padding:5px;" placeholder="IsEnabled" value="<?php echo $arr['IsEnable'];?>"/>
                                </div>

<?php if (($school_type == 'school' or $school_type == 'organization') && $user=='School Admin'){?>
                                <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">
                                    <b>Course Level ID</b>
                                </div>
                                <div class="col-md-5 form-group">
                                    <input type="text" name="CourseLevelID" id="CourseLevelID" class="form-control" style="width:100%; padding:5px;" placeholder="Course Level ID" value="<?php echo $arr['CourseLevelPID'];?>"/>
                                </div>

                                <div class="row ">
                                    <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">
                                        <b>course level</b>
                                    </div>
                                    <div class="col-md-5 form-group">
                                        <input type="text" name="courselevel" id="courselevel" class="form-control" style="width:100%; padding:5px;" placeholder="course_level" value="<?php echo $arr['CourseLevel'];?>"/>
                                    </div>
                                </div>
<?php } ?>

                                <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">
                                    <b>  Department ID</b>
                                </div>
                                <div class="col-md-5 form-group">
                                    <input type="text" name="DeptID" id="DeptID" class="form-control" style="width:100%; padding:5px;" placeholder="DeptID" value="<?php echo $arr['DeptID'];?>"/>
                                </div>

                                <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">
                                    <b> Department Name</b>
                                </div>
                                <div class="col-md-5 form-group">
                                    <input type="text" name="DeptName" id="DeptName" class="form-control" style="width:100%; padding:5px;" placeholder="DeptName" value="<?php echo $arr['DeptName'];?>"/>
                                </div>

                                <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">
                                    <b> <?php echo $dynamic_branch;?> ID</b>
                                </div>
                                <div class="col-md-5 form-group">
                                    <input type="text" name="BranchID" id="BranchID" class="form-control" style="width:100%; padding:5px;" placeholder="BranchID" value="<?php echo $arr['BranchID'];?>"/>
                                </div>

                                <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">
                                    <b> <?php echo $dynamic_branch;?> Name</b>
                                </div>
                                <div class="col-md-5 form-group">
                                    <input type="text" name="BranchName" id="BranchName" class="form-control" style="width:100%; padding:5px;" placeholder="BranchName" value="<?php echo  $arr['BranchName'];?>"/>
                                </div>

<?php if (($school_type == 'school' or $school_type == 'organization') && $user=='School Admin'){?>
                                <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">
                                    <b> semester Id   </b>
                                </div>
                                <div class="col-md-5 form-group">
                                    <input type="text" name="semesterId" id="semesterId" class="form-control" style="width:100%; padding:5px;" placeholder="semester  ID" value="<?php echo $arr['SemesterID'];?>"/>
                                </div>

                                <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">
                                    <b> Semester Name</b>
                                </div>
                                <div class="col-md-5 form-group">
                                    <input type="text" name="SemesterName" id="SemesterName" class="form-control" style="width:100%; padding:5px;" placeholder="Semester Name" value="<?php echo $arr['SemesterName'];?>"/>
                                </div>
<?php } ?>

                                <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">
                                    <b> <?php echo $designation; ?> ID</b>
                                </div>
                                <div class="col-md-5 form-group">
                                    <input type="text" name="DivisionId" id="DivisionId" class="form-control" style="width:100%; padding:5px;" placeholder="DivisionId" value="<?php echo $arr['DevisionId'];?>"/>
                                </div>

                                <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">
                                    <b> <?php echo $designation; ?>Name </b>
                                </div>
                                <div class="col-md-5 form-group">
                                    <input type="text" name="DivisionName" id="DivisionName" class="form-control" style="width:100%; padding:5px;" placeholder="DivisionName" value="<?php echo $arr['DivisionName'];?>"/>
                                </div>

                            </div>


                            <div class="row ">
                                <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">
                                    <b>Year</b>
                                </div>
                                <div class="col-md-5 form-group">
                                     <select class="form-control" name='Year'>
                                    <?php
                                    $list=mysql_query("select DISTINCT  Year from tbl_academic_Year WHERE school_id='$sc_id' order by Year asc");
                                    while($row_list=mysql_fetch_assoc($list)){
                                        ?>
                                        <option value="<?php echo $row_list['Year']; ?>" <?php if($arr['Year']==$select){ echo "selected"; } ?>>
                                            <?php echo $row_list['Year']; ?>
                                        </option>
                                        <?php
                                    }
                                    ?>
                                     </select>
                                </div>
                            </div>

                           <!-- <div class="row ">
                                <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">
                                    <b>Semester</b>
                                </div>
                                <div class="col-md-5 form-group">
                                    <select name="Semester" class="form-control" style="width:100%; padding:5px;">
                                        <option value="" >Choose</option>
                                        <option value="Semester I" >Semester I</option>
                                        <option value="Semester II" >Semester II</option>
                                        <option value="Semester III">Semester III</option>
                                        <option value="Semester IV" >Semester IV</option>
                                        <option value="Semester V"  >Semester V</option>
                                        <option value="Semester VI" >Semester VI</option>
                                        <option value="Semester VII">Semester VII</option>
                                        <option value="Semester VIII">Semester VIII</option>
                                    </select>
                                </div>
                            </div>-->

                            <div class="row ">
                                <div class="col-md-8 form-group col-md-offset-3" id="error"
                                     style="color:red;"><?php echo $report; ?></div>
                            </div>
                            <div class="row">

                                <div class="col-md-3 col-md-offset-2 " >
                                    <input type="submit" name="submit" class="form-control" style="width:50%;background-color:#0080C0; color:#FFFFFF;" value="Update" onClick="return valid()"/>
                                </div>

                               <!-- <div class="col-md-3 col-md-offset-2" style="padding:10px;">

                                    <input type="submit" name="submit" class="form-control" style="width:100%;background-color:#0080C0; color:#FFFFFF;" value="submit" onClick="return valid()"/>
                                </div>-->
                               <!-- <div class="col-md-3 col-md-offset-1" style="padding:10px;">
                                    <a href="list_school_subject.php" style="text-decoration:none;">
                                        <input type="Reset" class="form-control" name="cancel" value="cancel" style="width:100%;background-color:#0080C0; color:#FFFFFF;">
                                    </a>
                                </div>-->
                                <div class="col-md-3" >

                                    <a href="branch_subject_master.php" style="text-decoration:none;"> <input type="button" class="btn btn-danger" name="Back" value="Back" style="width:80px;font-weight:bold;font-size:14px;"/></a>

                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </body>
    </html>
<?php } ?>