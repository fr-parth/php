<?php
//Below code updated by Rutuja Jori for merging Add & Edit pages into one on 25/11/2019 for SMC-4196
include('scadmin_header.php');
$report = "";
$smartcookie = new smartcookie();
$results = $smartcookie->retrive_individual($table, $fields);
$result = mysql_fetch_array($results);
$sc_id = $result['school_id'];

if(isset($_GET['CourseLevelId'])=='')
{
if (isset($_POST['submit'])) {
    $course = $_POST['course'];
    $ExtCourseLevelID = $_POST['ExtCourseLevelID'];
    $results = mysql_query("SELECT * FROM `tbl_CourseLevel` WHERE `school_id`='$sc_id' and CourseLevel='$course' ");
    if (mysql_num_rows($results) == 0) {
        $query = "insert into `tbl_CourseLevel` (CourseLevel,school_id,ExtCourseLevelID) values('$course','$sc_id','$ExtCourseLevelID') ";
        $rs = mysql_query($query);
        //$successreport = "Record inserted Successfully";
        echo "<script LANGUAGE='JavaScript'>
                    window.alert('Record inserted Successfully');
                    window.location.href='list_school_course_level.php';
                    </script>";
    } else {
        $errorreport = 'Error while inserting Record';
    }
}
?>
<script  src="http://code.jquery.com/jquery-3.2.1.min.js"  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
            <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.js"></script>
            <script type="text/javascript">

function valid() {
    //alert('hi');
var course = document.getElementById("course").value;
        var pattern = /^[A-z\.\-\/]+$/;
        if(course.trim()=="" || course.trim()==null)
        {
            alert("Please enter <?php echo $dynamic_level;?> !");
        return false;
        }
        if (pattern.test(course)) {
            //alert("Your your Academic Year is : " + course);
           // return true;
        }
        else{
        alert("It is not valid <?php echo $dynamic_level;?> !");
        return false;
        }
        var ExtCourseLevelID = document.getElementById("ExtCourseLevelID").value;
        var pattern = /^[0-9]+$/;
        if(ExtCourseLevelID.trim()=="" || ExtCourseLevelID.trim()==null)
        {
            alert("Please enter Ext <?php echo $dynamic_level;?> ID !");
           return false;
        }
        if (pattern.test(ExtCourseLevelID)) {
            //alert("Your your Academic Year is : " + ExtCourseLevelID);
           // return true;
        }
        else{
        alert("It is not valid  Ext <?php echo $dynamic_level;?> ID!");
        return false;
        }
}
</script>
<html>
<head>

</head>
<body>
<div class="container" style="padding:25px;"
" >

<div style="padding:2px 2px 2px 2px;border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;background-color:#F8F8F8;">

    <form method="post">

        <div class="row">

            <div class="col-md-3 col-md-offset-1" style="color:#700000 ;padding:5px;"></div>

            <div class="col-md-3 " align="center" style="color:#663399;">
                <h2>Add <?php echo $dynamic_level;?></h2>

                <!-- <h5 align="center"><a href="Add_SubjectSheet_updated_20160109PT.php" >Add Excel Sheet</a></h5>  -->
                <br><br>
            </div>


        </div>

       <div class="row" style="padding-top:30px;">
                                    <div class="col-md-4"></div>
                                   <div class="col-md-2" style="color:#808080;font-size:18px;margin-left:50px"> <?php echo $dynamic_level;?>:<span style="color:red;font-size: 25px;">*</span></div>

                                    <div class="col-md-3">

                <input type="text" name="course" class="form-control " id="course" placeholder="<?php echo $dynamic_level;?>" style="margin-left:-35px">

            </div>
         </div>
            

				<div class="row" style="padding-top:30px;">

                <div class="col-md-4"></div>
                <div class="col-md-2" style="color:#808080;font-size:18px;margin-left:4px">Ext <?php echo $dynamic_level;?> ID:<span style="color:red;font-size: 25px;">*</span></div>
                 <div class="col-md-3">

                
                <input type="text" name="ExtCourseLevelID" class="form-control " id="ExtCourseLevelID" placeholder="Ext <?php echo $dynamic_level;?> ID">

            </div>

            <br/><br/>

            <!--<div class="col-md-3 col-md-offset-4">

                <input type="text" name="Batch ID" class="form-control " id="0" placeholder="Batch ID">

            </div>-->

        </div>


        <div id="error" style="color:#F00;text-align: center;" align="center"></div>


        <div class="row" style="padding-top:15px;">


            <div class="col-md-2 col-md-offset-4 ">

                <input type="submit" class="btn btn-primary" name="submit" value="Add "
                       style="width:80px;font-weight:bold;font-size:14px;" id = "btnValid" onClick ="return valid()"/>

            </div>


            <div class="col-md-3 " align="left">

                <a href="list_school_course_level.php" style="text-decoration:none;"> <input type="button"
                                                                                             class="btn btn-primary"
                                                                                             name="Back" value="Back"
                                                                                             style="width:80px;font-weight:bold;font-size:14px;"/></a>

            </div>


        </div>


        <div class="row" style="padding-top:15px;">

            <div class="col-md-4">

                <input type="hidden" name="count" id="count" value="1">

            </div>

            <div class="col-md-11" style="color:#FF0000;" align="center" id="error">


                <?php echo $errorreport; ?>
            </div>

            <div class="col-md-11" style="color:#063;" align="center" id="error">

                <?php echo $successreport; ?>

            </div>

        </div>

    </form>

</div>


</body>
</html>

<?php } else{

if (isset($_GET["deleteCourseLevelId"])) {
    $deleteCourseLevelId=$_GET['deleteCourseLevelId'];
    $id = $_SESSION['id'];
    $fields = array("id" => $id);
    $table = "tbl_school_admin";
    $smartcookie = new smartcookie();
    $results = $smartcookie->retrive_individual($table, $fields);
    $result = mysql_fetch_array($results);
    $sc_id = $result['school_id'];
    $sql1 = "delete from tbl_CourseLevel where id='$deleteCourseLevelId' and school_id='$sc_id' ";
    $row = mysql_query($sql1);
    header('Location: ' ."/core/list_school_course_level.php" );
}
if (isset($_GET["CourseLevelId"])) {
    $id = $_SESSION['id'];
    $fields = array("id" => $id);
    $table = "tbl_school_admin";
    $smartcookie = new smartcookie();
    $results = $smartcookie->retrive_individual($table, $fields);
    $result = mysql_fetch_array($results);
    $sc_id = $result['school_id'];
    //fetch courseLevel data from database
    $CourseLevelId = $_GET["CourseLevelId"];
    $sql1 = "select * from tbl_CourseLevel where id='$CourseLevelId' and school_id='$sc_id' ";
    $row = mysql_query($sql1);
    $arr = mysql_fetch_array($row);
    $CourseLevel = $arr['CourseLevel'];
    $ExtCourseLevelID = $arr['ExtCourseLevelID'];
    
    
    
    
    // GET FORM DATA
  if (isset($_POST['submit'])) {

       
         $Course_Level = $_POST['CourseLevel']; 
         $ExtCourseLevelID = $_POST['ExtCourseLevelID'];
        

if($CourseLevel == $Course_Level)
{
    

    $r = "update tbl_CourseLevel set CourseLevel='$Course_Level', ExtCourseLevelID = '$ExtCourseLevelID' where id='$CourseLevelId'";
    
}
else
{
    
    
    
$sql1 = mysql_query("SELECT school_id,CourseLevel FROM `tbl_CourseLevel` WHERE `school_id`='$sc_id' and `CourseLevel`='$Course_Level'");

$count=mysql_num_rows($sql1);


if ($count > 0) 
{
    
    
    echo "<script>alert('Record already present') </script>";
}

else
{
    $r = "update tbl_CourseLevel set CourseLevel='$Course_Level', ExtCourseLevelID = '$ExtCourseLevelID' where id='$CourseLevelId'"; 

}
}  
    if($r!='')
    {
        $a = mysql_query($r);
        if (mysql_affected_rows() > 0) {
            
            echo ("<script LANGUAGE='JavaScript'>
                        alert('Record Updated Successfully..!!');
                        window.location.href='list_school_course_level.php';
                        </script>");
        } else {
            echo "<script>alert('There is no change while updating record') </script>";
        }
    }
    
}
    
$r = mysql_query("SELECT school_id,CourseLevel FROM `tbl_CourseLevel` WHERE `school_id`='$sc_id' and `CourseLevel`='$Course_Level'");

if (mysql_num_rows($r) > 0) {
    $res= mysql_fetch_assoc($r);
    
} ?>


    <script  src="http://code.jquery.com/jquery-3.2.1.min.js"  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
            <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.js"></script>
            <script type="text/javascript">

function valid() {
    //alert('hi');
var CourseLevel = document.getElementById("CourseLevel").value;
        var pattern = /^[a-zA-Z\.\-\/]+$/;
        if(CourseLevel.trim()=="" || CourseLevel.trim()==null)
        {
            alert("Please Enter <?php echo $dynamic_level;?> !");
        return false;
        }
        if (pattern.test(CourseLevel)) {
            //alert("Your your Academic Year is : " + CourseLevel);
           // return true;
        }
        else{
        alert("It is not valid <?php echo $dynamic_level;?> !");
        return false;
        }
        
        var ExtCourseLevelID = document.getElementById("ExtCourseLevelID").value;
        var pattern = /^[0-9]+$/;
        if(ExtCourseLevelID.trim()=="" || ExtCourseLevelID.trim()==null)
        {
            alert("Please Enter Ext <?php echo $dynamic_level;?> ID !");
        return false;
        }
        if (pattern.test(ExtCourseLevelID)) {
            //alert("Your your Academic Year is : " + ExtCourseLevelID);
           // return true;
        }
        else{
        alert("It is not valid  Ext <?php echo $dynamic_level;?> ID!");
        return false;
        }
}
</script>
    <html>
    <head>
        <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
    </head>
    <body align="center">
    <div class="container" style="padding:10px;" align="center">
        <div class="row">
            <div class="col-md-3">
            </div>
            <div style="padding:2px -20px 122px -42px;border:0px solid #CCCCCC; border:0px solid #CCCCCC;box-shadow: 0px 1px 1px 1px #C3C3C4;">
                <div class="container">
                    <div style="padding:2px 2px 2px 2px;border:1px solid #CCCCCC; border:0px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;background-color:#F8F8F8 ;">
                        <form method="post">
                            <div style="background-color:#F8F8F8 ;">
                                <div class="row">
                                    <div class="col-md-12 " align="center" style="color:#663399;">
                                        <h2>Update <?php echo $dynamic_level;?></h2>
                                    </div>
                                </div>

                                <div class="row" style="padding-top:30px;">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-2" style="color:#808080;font-size:18px;margin-left:14px"> <?php echo $dynamic_level;?>:<span style="color:red;font-size: 25px;">*</span></div>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control" name="CourseLevel" id="CourseLevel" value="<?php echo $CourseLevel;?>" style="margin-left:-30px;">
                                    </div>
                                </div>

                                <div class="col-md-4 col-md-offset-5"  style="color:#F00; text-align: center;">
                                    <span class="error"><?php echo $ErrorCourseLevel; ?></span>
                                </div>

                                <div class="row" style="padding-top:30px;">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-2" style="color:#808080; font-size:18px;"> Ext <?php echo $dynamic_level;?> ID:<span
                                            style="color:red;font-size: 25px;">*</span></div>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control" name="ExtCourseLevelID" id="ExtCourseLevelID" value="<?php echo $ExtCourseLevelID; ?>">
                                    </div>
                                </div>

                                <div class="col-md-4 col-md-offset-5"  style="color:#F00; text-align: center;">
                                    <span class="error"><?php echo $ErrExtcourseLevelID; ?></span>
                                </div>

                                <div class="row" style="padding-top:60px;">
                                    <div class="col-md-5"></div>
                                    <div class="col-md-1"><input type="submit" name="submit" value="Update" class="btn btn-success"  onClick ="return valid()"></div>
                                    <div class="col-md-1"><a href="list_school_course_level.php"><input type="button" value="Back" class="btn btn-danger"></a></div>
                                </div>

                                <div class="row" style="padding:30px;padding-left:450px;">
                                    <div class="col-md-4" style="color:#F00;" align="center" id="error">
                                        <b><?php echo $errorreport; ?></b>
                                    </div>
                                </div>

                                <div class="row" style="padding:30px;padding-left:450px;">
                                    <div class="col-md-4" style="color:#008000;" align="center" id="error">
                                        <b><?php echo $report; ?></b>
                                    </div>
                                </div>

                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </body>
    </html>
<?php }?>
<?php } ?>