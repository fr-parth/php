<?php
include_once('scadmin_header.php');

$report = "";
//echo $stud_prn;
$stud_prn =$_POST['prn'];
$school_id = $_POST['school_id'];
$std_name=$_POST['Name'];
$CourseLevel=$_POST['courselevel'];

// copied position in studlist.php
if ($_POST['Search']==""){ 
    //$arr = "SELECT st.student_id,st.subjectName,st.subjcet_code,st.Semester_id,
    //st.Department_id,st.AcademicYear,st.CourseLevel,st.Division_id,st.Branches_id,dm.Dept_code FROM tbl_student_subject_master st
    // JOIN tbl_academic_Year Y 
    //ON Y.Academic_Year=st.AcademicYear AND Y.Enable='1' JOIN tbl_department_master dm ON dm.Dept_Name=st.Department_id
    //WHERE dm.School_ID='$school_id' AND st.student_id='$stud_prn' AND st.school_id='$school_id' 
    //AND Y.school_id='$school_id' ORDER BY st.subjectName";
    //$sql1 = mysql_query($arr);


  $url = $GLOBALS['URLNAME']."/core/Version4/student_subjectlistTeacher.php";

    $data = array("school_id"=>$school_id,"std_PRN"=>$stud_prn);
  // $data = array("school_id"=>'119',"std_PRN"=>'15','student_dashboard'=>'');
       // print_r($data);//exit;
        //$ch = curl_init($url);             
        $data_string = json_encode($data);    

        //curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
        //curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);  
        //curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);      
        //curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data_string)));
        //$result = json_decode(curl_exec($ch),true);
        ////print_r($data_string);
        

//echo $url="https://dev.smartcookie.in/core/Version4/student_subjectlistTeacher.php";

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => $url,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => $data_string,
  CURLOPT_HTTPHEADER => array(
    "cache-control: no-cache",
    "content-type: application/json"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);


  //echo $response;
  $result = Json_decode($response,json);
  //print_r($result);exit;
  //print_r($result);

}
else{
    $searchq=trim($_POST['Search']);
    $colname=$_POST['colname'];
    $stud_prn=$_POST['prn'];
    $school_id=$_POST['school_id'];
    $std_name=$_POST['name'];
    $CourseLevel=$_POST['courselevel'];

    
    if ($colname != ""){

       // if($filter=="Current_Academic_Year" ||$filter==''){
        //$current_year=date('Y');
        //}
       $arr3 = "SELECT sm.student_id, sm.subjcet_code, sm.subjectName, sm.Semester_id, sm.Department_id, sm.Branches_id, sm.Division_id,
         sm.AcademicYear,tm.teacher_id,
         tss.Subject_Code, tss.subject, tss.id, tss.image,
         t.t_name, t.t_middlename, t.t_lastname, t.t_complete_name,c.class,
        a.Year, a.Academic_Year FROM tbl_student_subject_master sm  
        LEFT OUTER JOIN tbl_teacher_subject_master tm ON sm.school_id='$school_id' AND sm.subjcet_code=tm.subjcet_code 
        AND sm.Semester_id=tm.Semester_id AND sm.Department_id=tm.Department_id AND sm.Division_id=tm.Division_id AND
        sm.Branches_id=tm.Branches_id left OUTER JOIN tbl_teacher t ON tm.teacher_id=t.t_id AND t.school_id='$school_id' 
        LEFT OUTER JOIN tbl_school_subject tss ON tss.school_id='$school_id' AND tss.Subject_Code=sm.subjcet_code 
        left OUTER JOIN tbl_class_subject_master c ON c.school_id='$school_id' AND c.subject_code=sm.subjcet_code 
        AND c.course_level=sm.CourseLevel AND c.semester=sm.Semester_id 
        JOIN tbl_academic_Year a ON a.school_id='$school_id' AND a.Academic_Year = sm.AcademicYear AND a.Enable='1'
        WHERE sm.student_id = '$stud_prn' AND sm.school_id='$school_id' AND sm.subjcet_code!='' ";
        if($colname =="AcademicYear"){
            $arr3.= " and sm.AcademicYear='$searchq'";
        }
        if($colname =="Division_id"){
            $arr3.= " and sm.Division_id='$searchq'";
        }
        if($colname =="Semester_id"){
            $arr3.= " and sm.Semester_id='$searchq'";
        }
        if($colname =="Department_id"){
            $arr3.= " and sm.Department_id='$searchq'";
        }
        if($colname =="Class"){
            $arr3.= " and c.class='$searchq'";
        }
        
        // AND( sm.AcademicYear='$searchq' OR
        //sm.Division_id='$searchq' OR sm.Semester_id='$searchq' OR sm.Department_id='$searchq' OR c.class='$searchq')";

        $sql = mysql_query($arr3);
    }
}
?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
    <!--
    <script src='js/bootstrap.min.js' type='text/javascript'></script>
    -->
    <title><?php echo $dynamic_student; ?> Semester Records</title>
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
<script>
    $(document).ready(function () {
        $('#example').dataTable({
            "pagingType": "full_numbers"
        });
    });

</script>
<body bgcolor="#CCCCCC">
<div style="bgcolor:#CCCCCC">
    <div>
    </div>
    <div class="container" style="padding:25px;">
        <div style="padding:2px 2px 2px 2px;border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">
            <div style="background-color:#F8F8F8 ;">
                <div class="row">
                    <div class="col-md-3 " style="color:#700000 ;padding:5px;">&nbsp;&nbsp;&nbsp;&nbsp;
                        <!--      <a href="add_school_subject.php">   <input type="submit" class="btn btn-primary" name="submit" value="Add Subject" style="width:110px;font-weight:bold;font-size:14px;"/></a>-->
                    </div>
                    <div class="col-md-6 " align="center">
                        <h2><?php echo $dynamic_subject;?> list for <?php echo ucwords(strtolower($std_name));?><br/>(ID:<?php echo $stud_prn;?>)</h2>
                    </div>

                </div>
                

                
                <div class="col-md-11"  style="color:#700000 ;padding:6px;">
                </div>
                <div>
                    <form method="POST">

                    <center>
                    <div class="col-md-3"></div>
            <div class="col-md-2" style="width:17%;">
                <select id="search" name="colname" class="form-control">
                    <option selected="selected">Search By</option>

                    <option value='AcademicYear'
                    <?php if (($_POST['colname']) == "AcademicYear") {
                            echo $_POST['colname']; ?> selected="selected" <?php } ?>>Academic Year </option>
                    <option value="Semester_id"
                    <?php if (($_POST['colname']) == "Semester_id") {
                            echo $_POST['colname']; ?> selected="selected" <?php } ?>> Semester </option> 
                    <option value="Division_id"
                    <?php if (($_POST['colname']) == "Division_id") {
                            echo $_POST['colname']; ?> selected="selected" <?php } ?>> Division </option> 
                    <option value='Class'
                    <?php if (($_POST['colname']) == "Class") {
                            echo $_POST['colname']; ?> selected="selected" <?php } ?>>Class</option>
                    <option value='Department_id'
                    <?php if (($_POST['colname']) == "Department_id") {
                            echo $_POST['colname']; ?> selected="selected" <?php } ?>>Department</option>
                            
                </select>
            </div>
            </center>
            <div class="col-md-2" style="width:17%;">
                <input type='hidden' name='prn' value='<?php echo $stud_prn; ?>'>
                <input type='hidden' name='name' value='<?php echo $std_name; ?>'>
                <input type='hidden' name='school_id' value='<?php echo $school_id; ?>'>
                <input type='hidden' name='courselevel' value='<?php echo $CourseLevel; ?>'>
                <input type="text" class="form-control" name="Search" value="<?php echo $searchq;?>" placeholder="Search.." required> 
                

            </div>
            <div class="col-md-1">
            <button type="submit" value="Search" class="btn btn-primary">Search</button>
            </div>
            <?php $site=$_SERVER['SERVER_NAME'];?>
            <div class="col-md-3"> 
                        <a href="<?php echo "http://$site/core/studlist.php"; ?>" style="text-decoration:none;"> 
                        <input type="button" class="btn btn-danger" name="Back" value="Back" /></a>
            </div>
            
            <br/><br/>

                    </form>
                </div>
    

                
                <div class="row" style="margin-top:3%;">

                    <div class="col-md-2">
                    </div>
                    <div class="col-md-12" id="no-more-tables">
                        <?php $i = 0; ?>
                        <table class="table-bordered  table-condensed cf" id="example" width="100%;">
                            <thead>
                            <tr style="background-color:#428BCA;color:#FFFFFF;height:30px;">
                                <th style="width:50px;">
                                    <center>Sr.No</center>
                                </th>


                                <th style="width:150px;">
                                    <center><?php echo $dynamic_subject;?>
                                        Name<br/>(Subject code)
                                    </center>
                                </th>



                                <?php
                                if ($_SESSION['usertype'] == 'Manager') {
                                    ?>

                                    <th style="width:350px;">
                                        <center>Department Name<br/>(Department code)</center>
                                    </th>

                                    <?php
                                } else {
                                    ?>
                                    <th style="width:350px;">
                                        <center>Department Name<br/>(Department code)</center>
                                    </th>
                                    <?php
                                }
                                ?>

                                <th style="width:50px;">
                                    <center>Class<br/>(Division)</center>
                                </th>

                                

                                <th style="width:150px;">
                                    <center><?php echo ($_SESSION['usertype'] == 'Manager') ? 'Evaluation' : 'Academic'; ?>
                                        Year<br/>(Semester)
                                    </center>
                                </th>

                                <th style="width:150px;">
                                    <center>Teacher Name<br/>(Teacher ID)
                                    </center>
                                </th>

                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            if ($_POST['Search']!="")
                            {
                            ?>
                            <?php

                            $i = 1;
                            //$arr="SELECT std.std_PRN, std.std_name, std.std_Father_name, std.std_lastname, std.std_complete_name, semester.student_id, semester.SemesterName, semester.BranchName, semester.Specialization, semester.DeptName, semester.CourseLevel, semester.DivisionName, semester.AcdemicYear FROM StudentSemesterRecord AS semester JOIN tbl_student AS std ON std.std_PRN = semester.student_id JOIN tbl_academic_Year a ON semester.AcdemicYear=a.Year where semester.school_id='$sc_id' and semester.`IsCurrentSemester`='1' and a.Enable='1' and a.school_id='$sc_id' ORDER BY std.std_name,std.std_complete_name"?>
                            <?php
                            
                            while ($row = mysql_fetch_array($sql)) {
                                // $fullName=ucwords(strtolower($row['std_name']." ".$row['std_Father_name']." ".$row['std_lastname']));
                                $Department_id=$row['Department_id'];
                                $subjectName=$row['subjectName'];
                                $Semester_id=$row['Semester_id'];
                                //$CourseLevel=$row['CourseLevel'];
                                $subjcet_code=$row['subjcet_code'];
                                //$Branches_id=$row['Branches_id'];
                                $Division_id=$row['Division_id'];
                                $teacher_ID=$row['teacher_id'];
                                $t_name=$row['t_name'];
                                $t_middlename=$row['t_middlename'];
                                $t_lastname=$row['t_lastname'];
                                $t_class = $row['class'];

                                //$tquery=mysql_query("SELECT teacher_id FROM tbl_teacher_subject_master where subjcet_code='$subjcet_code' AND
                                //subjectName='$subjectName' AND Semester_id='$Semester_id' AND Branches_id='$Branches_id' AND
                                //Department_id='$Department_id' AND school_id='$school_id'");
                                //$trow=mysql_fetch_array($tquery);
                                //$teacher_ID=$trow['teacher_id'];

                                $query2=mysql_query("SELECT Dept_code FROM tbl_department_master WHERE Dept_Name='".$Department_id."' AND School_ID='".$school_id."' ");
                                $rows2=mysql_fetch_array($query2);
                                $dept_code=$rows2['Dept_code'];

                                //$query=mysql_query("SELECT DISTINCT t.t_DeptID,t.t_complete_name,t.t_name,t.t_middlename,t.t_lastname,t.t_id FROM tbl_teacher t WHERE t.t_id='".$teacher_ID."' AND t.school_id='".$school_id."'");
                                //$row1=mysql_fetch_array($query);
                                //$t_name=$row1['t_name'];
                                //$t_middlename=$row1['t_middlename'];
                                //$t_lastname=$row1['t_lastname'];
                                
                                
                                   // $query3=mysql_query("SELECT DISTINCT class FROM tbl_class_subject_master WHERE subject_name= '".$subjectName."'AND school_id='".$school_id."' AND subject_code='".$subjcet_code."' AND course_level='".$CourseLevel."' AND semester='".$Semester_id."'  ");  
                                    //$rows3=mysql_fetch_array($query3);
                                   //     $t_class = $rows3['class'];
                                
                                
                                ?>


                                <tr style="height:30px;color:#808080;">


                                    <td data-title="Sr.No" style="width:50px;"><b>
                                            <center><?php echo $i; ?></center>
                                        </b></td>

                                    <td data-title="Subject Name" style="width:50px;">
                                        <center>
                                            <!-- <a href="display_teach_subjectwise.php?subjectName=<?php echo $subjectName; ?>& t_id=<?php echo $row['teacher_ID']; ?>& school_id=<?php echo $_POST['school_id']; ?>"><?php echo $row['subjectName']; echo"<br/>(";echo $subjcet_code; echo")"; ?> -->
                                            <?php echo $row['subjectName']; 
                                            if($subjcet_code !=''){
                                            echo"<br/>(";echo $subjcet_code; echo")"; 
                                            }?>
                                    </center>
                                    </td>


                                    <td data-title="Department Name" style="width:420px;">
                                        <center><?php echo $Department_id;
                                        if($dept_code!=''){
                                        echo"<br/>(";echo $dept_code;echo")"; 
                                        }?></center>
                                    </td>

                                    <td data-title="Class" style="width:50px;">
                                            <center><?php echo $t_class;
                                            if($row['Division_id'] !=''){
                                            echo"<br/>("; echo $row['Division_id'];  echo")";
                                            }?> </center>
                                            
                                    </td>

                                    <td data-title="Year" style="width:100px;">
                                        <center><?php echo $row['AcademicYear']; 
                                        if($Semester_id !=''){
                                        echo"<br/>("; echo $Semester_id; echo")";
                                        }?></center>
                                    </td>

                                    <td><center><?php
                                    $teacher_name = ucwords(strtolower($row['t_complete_name']));
                                        if ($teacher_name == '') {
                                        echo ucwords(strtolower($t_name)) . " " . ucwords(strtolower($t_middlename)) . " " . ucwords(strtolower($t_lastname));
                                        if($teacher_ID !=''){
                                        echo"<br/>(";echo $teacher_ID; echo")";
                                        }
                                    } else {
                                        echo $teacher_name;
                                        if($teacher_ID !=''){
                                        echo"<br/>(";echo $teacher_ID; echo")";
                                        }
                                    }
                                    ?></center></td>

                                </tr>
                                <?php $i++; ?>
                            <?php } ?>

                            </tbody>
                        </table>
                    </div>
                </div>


                <div class="row" style="padding:5px;">
                    <div class="col-md-4">
                    </div>
                    <div class="col-md-3 " align="center">

                        </form>
                       
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
        <?php } 
        else
        {
            ?>
                            <?php

                            $i = 1;
                            //$arr="SELECT std.std_PRN, std.std_name, std.std_Father_name, std.std_lastname, std.std_complete_name, semester.student_id, semester.SemesterName, semester.BranchName, semester.Specialization, semester.DeptName, semester.CourseLevel, semester.DivisionName, semester.AcdemicYear FROM StudentSemesterRecord AS semester JOIN tbl_student AS std ON std.std_PRN = semester.student_id JOIN tbl_academic_Year a ON semester.AcdemicYear=a.Year where semester.school_id='$sc_id' and semester.`IsCurrentSemester`='1' and a.Enable='1' and a.school_id='$sc_id' ORDER BY std.std_name,std.std_complete_name"?>
                            <?php
                           // print_r($result);exit;
                            foreach($result['posts'] as $row) {
                                //print_r($row);exit;
                                // $fullName=ucwords(strtolower($row['std_name']." ".$row['std_Father_name']." ".$row['std_lastname']));
                                $Department_id=$row['departmentId'];
                                $Division_id=$row['divisionId'];
                                $subjectName=$row['subjectName'];
                                $Semester_id=$row['semesterName'];
                                //$CourseLevel=$row['CourseLevel'];
                                $subjcet_code=$row['SubjectCode'];
                                //$Branches_id=$row['Branches_id'];
                                //$dept_code=$row['Dept_code'];
                                $teacher_ID=$row['teacher_id'];
                                $teacher_name=$row['teacher_name'];
                                //$t_class=$row['t_class'];

                                //$tquery=mysql_query("SELECT teacher_id FROM tbl_teacher_subject_master where subjcet_code='$subjcet_code' AND
                                //Semester_id='$Semester_id' AND Branches_id='$Branches_id' AND
                                //Department_id='$Department_id' AND school_id='$school_id'");
                                //$trow=mysql_fetch_array($tquery);
                                //$teacher_ID=$trow['teacher_id'];

                                $query2=mysql_query("SELECT Dept_code FROM tbl_department_master WHERE School_ID='".$school_id."' AND  Dept_Name='".$Department_id."' ");
                                $rows2=mysql_fetch_array($query2);
                                $dept_code=$rows2['Dept_code'];

                               //if($teacher_ID !=''){
                               //$query=mysql_query("SELECT DISTINCT t.t_class,t.t_DeptID,t.t_complete_name,t.t_name,t.t_middlename,t.t_lastname,t.t_id FROM tbl_teacher t WHERE t.t_id='".$teacher_ID."' AND t.school_id='$school_id'  ");
                               //$row1=mysql_fetch_array($query);
                               //$t_name=$row1['t_name'];
                               //$t_middlename=$row1['t_middlename'];
                               //$t_lastname=$row1['t_lastname'];
                               //$t_class=$row1['t_class'];
                               //}
                                
                                    
                                
                                $query3=mysql_query("SELECT DISTINCT class FROM tbl_class_subject_master WHERE subject_name= '".$subjectName."'AND school_id='".$school_id."' AND subject_code='".$subjcet_code."' AND course_level='".$CourseLevel."' AND semester='".$Semester_id."'  ");
                                $rows3=mysql_fetch_array($query3);
                                    $t_class = $rows3['class'];
                                
                                ?>


                                <tr style="height:30px;color:#808080;">


                                    <td data-title="Sr.No" style="width:50px;"><b>
                                            <center><?php echo $i; ?></center>
                                        </b></td>

                                    <td data-title="Subject Name" style="width:50px;">
                                        <center>
                                            <!-- <a href="display_teach_subjectwise.php?subjectName=<?php //echo $subjectName; ?>& t_id=<?php //echo $row['teacher_ID']; ?>& school_id=<?php //echo $_POST['school_id']; ?>"><?php //echo $row['subjectName']; echo"<br/>(";echo $subjcet_code; echo")"; ?> -->
                                            <?php echo $subjectName; 
                                            if($subjcet_code !=''){
                                            echo"<br/>(";echo $subjcet_code; echo")"; 
                                            }?>
            
                                    </center>
                                    </td>


                                    <td data-title="Department Name" style="width:420px;">
                                        <center><?php echo $Department_id;
                                        if($dept_code !=''){
                                        echo"<br/>("; echo $dept_code;  echo")"; 
                                        }?></center>
                                    </td>

                                    <td data-title="Class" style="width:50px;">
                                             <center><?php echo $t_class; 
                                             if($Division_id !=''){
                                             echo"<br/>("; echo $Division_id;  echo")";
                                            }
                                             ?> </center>
                                            
                                    </td>

                                    <td data-title="Year" style="width:100px;">
                                        <center><?php echo $row['Year'];
                                        if($Semester_id !=''){ 
                                            echo"<br/>("; echo $Semester_id; echo")";
                                        }?></center>
                                    </td>

                                    <td><center><?php
                                    //$t_complete_name = ucwords(strtolower($row1['t_complete_name']));
                                    //    if ($t_complete_name == '') {
                                    //    echo ucwords(strtolower($t_name)) . " " . ucwords(strtolower($t_middlename)) . " " . ucwords(strtolower($t_lastname));echo"<br/>(";echo $teacher_ID; echo")";
                                    //} else {
                                        echo $teacher_name;
                                        if($teacher_ID !=''){
                                        echo"<br/>(";echo $teacher_ID; echo")";
                                        }
                                    //}
                                    ?></center></td>

                                </tr>
                                <?php $i++; ?>
                            <?php } ?>

                            </tbody>
                        </table>
                    </div>
                </div>


                <div class="row" style="padding:5px;">
                    <div class="col-md-4">
                    </div>
                    <div class="col-md-3 " align="center">

                        </form>
                       
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
        <?php } ?>
</body>
</html>
