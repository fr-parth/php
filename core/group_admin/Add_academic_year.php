<?php
include('groupadminheader.php');
$report = "";
//$smartcookie = new smartcookie();
//$results = $smartcookie->retrive_individual($table, $fields);
//$result = mysql_fetch_array($results);
$group_member_id=$_SESSION['id']; 
$sc_id =0;
if($_GET['id']==''){
if (isset($_POST['submit'])) {
    
    $ac_year = trim($_POST['ac_year']);
    $is_active = $_POST['is_active'];
    $year = trim($_POST['year']);
    $semester_type = trim($_POST['semester_type']);
    $ext_year = trim($_POST['ext_year']);
    if($is_active=='1'){
        $qury4 = "UPDATE tbl_cookieadmin SET current_ay='$ac_year', current_sem_type='$semester_type' WHERE id='$group_member_id'";
        // echo $qury4; exit;
       mysql_query($qury4);
    }
    $qury1 = "select * from tbl_school_admin where group_member_id='$group_member_id'";
    // echo $qury1; exit;
    $extExistCheckQry=mysql_query("SELECT id from tbl_academic_Year WHERE ExtYearID='$ext_year' AND group_member_id='$group_member_id'");
    if(mysql_num_rows($extExistCheckQry)>=1 ){
        echo "<script LANGUAGE='JavaScript'>
                    window.alert('External Year already exist!');
                    window.location.href='Add_academic_year.php';
                    </script>";
        exit();
    }
    $sql = mysql_query($qury1);
    while($rows = mysql_fetch_array($sql)){
        $sc_id = $rows['school_id'];
        $qury2 = "select * from tbl_academic_Year where group_member_id='$group_member_id' AND school_id='$sc_id' AND Academic_Year='$ac_year'";
    // echo $qury2; exit;
$query = mysql_num_rows(mysql_query($qury2));
// print_r($query); exit;
if($query == 0){
    $qury3="INSERT INTO tbl_academic_Year (Academic_Year,Year,ExtYearID,school_id,Enable,group_member_id) VALUES ('$ac_year','$year','$ext_year','$sc_id','$is_active','$group_member_id')";
   // echo $qury3; exit;
    $sqlqury = mysql_query($qury3);
}
    }

    if($sqlqury){
        echo "<script LANGUAGE='JavaScript'>
                    window.alert('Record inserted Successfully');
                    window.location.href='academic_year_list.php';
                    </script>";
}else if($sqlquryupdate){
    echo "<script LANGUAGE='JavaScript'>
                    window.alert('Record Updated Successfully');
                    window.location.href='academic_year_list.php';
                    </script>";
}else{
    echo "<script LANGUAGE='JavaScript'>
                    window.alert('Record not inserted Please Try Again!');
                    window.location.href='Add_academic_year.php';
                    </script>";
}
  

}
?>
<!DOCTYPE html>   
<html>
<head>
<script type="text/javascript">
    $(document).ready(function(){
    //     $("#ac_year").datepicker();
        $("#is_active").change(function(){

            var isAct = $(this).val();
            if(isAct=="1"){

                $("#semtypeDiv").css("display","block");
                $("#semType").html("<select name='semester_type' id='semester_type' class='form-control' required><option value='odd'>Odd Semesters</option><option value='even'>Even Semesters</option></select>");
            }else{
                $("#semtypeDiv").css("display","none");
                $("#semType").html("");
            }
        });
        
    });
    function valid() {
    
    var a_year = document.getElementById("ac_year").value;
    var year_ = document.getElementById("year").value;
    const d = new Date();
    let cur_year=d.getFullYear();
    let years=a_year.split("-");
    let years2=parseInt(years[0])+1;

    console.log(d);
    console.log(cur_year);
    console.log(years2);
    console.log(years);
    if((years[0]==cur_year && (years[1]==parseInt(cur_year)+1)) || ((years[0]==parseInt(cur_year)-1) && (years[1]==years2))){  
        if(!(year_==years[0])){
            alert("It is not valid Year!");
            return false;
        }
        console.log("true");
    }else{
        alert("It is not valid Academic Year!");
        return false;
    }
    var pattern1 =/^[0-9-0-9]{9}$/;
    if (pattern1.test(a_year)) {
    //   return true;
    // alert('hello');
    }
    else{
    alert("It is not valid Academic Year!");
    return false;
    }
    
    var year = document.getElementById("year").value;
   
    var pattern2 = /^[0-9]{4}$/;
    if (pattern2.test(year)) {
      return true;
    }
    else{
    alert("It is not valid  Year!");
    return false;
    }
    //added for external year
    var ext_yr= document.querySelector("#ext_year").value;
    var pattern = /^[0-9]+$/;
    if(pattern.test(ext_yr)){
        return true;
        // console.log(ext_yr.value);
    }else{
        return false;
    }

}
</script>
</head>
<body>


<div class="container" style="padding:25px;">

<div style="padding:2px 2px 2px 2px;border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;background-color:#F8F8F8;">

    <form method="post">

        <div class="row">

            <div class="col-md-3 col-md-offset-1" style="color:#700000 ;padding:5px;"></div>

            <div class="col-md-6 " align="center" style="color:#663399;">

                <h2>Add Academic Year</h2>
                <!-- <h5 align="center"><a href="Add_SubjectSheet_updated_20160109PT.php" >Add Excel Sheet</a></h5>  -->
                <br><br>
            </div>


        </div>

       <div class="row" style="padding-top:30px;">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-2" style="color:#808080;font-size:18px; margin-left:12px">Academic Year:<span style="color:red;font-size: 25px;">*</span></div>
                                    <div class="col-md-3">

                <input type="text" name="ac_year" class="form-control datepicker" id="ac_year" placeholder="Academic Year" required>

            </div>
            
         </div>
        
           
    
    
    
             <div class="row" style="padding-top:30px;">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-2" style="color:#808080;font-size:18px;margin-left:14px"> Year:<span style="color:red;font-size: 25px;">*</span></div>
                                    <div class="col-md-3">
                
                <input type="text" name="year" class="form-control" id="year" placeholder="Year" required>

            </div>

            <br/><br/>
            <div class="row" style="padding-top:30px;">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-2" style="color:#808080;font-size:18px;margin-left:14px">External Year Id:<span style="color:red;font-size: 25px;">*</span></div>
                                    <div class="col-md-3">
                
                <input type="text" name="ext_year" class="form-control" id="ext_year" placeholder="External Year" required>

            </div>
        </div>
    
        <div id="error" style="color:#F00;text-align: center;" align="center"></div>

            <div class="row" style="padding-top:30px;">
                <div class="col-md-4"></div>
                <div class="col-md-2" style="color:#808080; font-size:18px; margin-left: 13px;" > Is Active<span
                            style="color:red;font-size: 25px;"></span></div>
                <div class="col-md-3">
                    <select name="is_active" id="is_active" class="form-control" required>
                        <option value="" disabled selected> Select </option>
                        <option value="1" >Yes</option>
                        <option value="0" >No</option>
                    </select>
                </div>
            </div>

            <div class="col-md-4 col-md-offset-5"  style="color:#F00; text-align: center;">
                <span class="error"><?php echo $Errcourselevel; ?></span>
            </div>

            <div class="row" id="semtypeDiv" style="padding-top:30px; display: none;">
                <div class="col-md-4"></div>
                <div class="col-md-2" style="color:#808080; font-size:18px; margin-left: 13px;" >Active Semester Type<span
                            style="color:red;font-size: 25px;"></span></div>
                <div class="col-md-3" id="semType">
                   
                </div>
            </div>

        <div class="row" style="padding-top:15px;">

            <div class="col-md-2 col-md-offset-4 ">

                <input type="submit" class="btn btn-primary" name="submit" value="Add "style="width:80px;font-weight:bold;font-size:14px;" id = "btnValid" onClick ="return valid()" />

            </div>


            <div class="col-md-3 " align="left">

                <a href="academic_year_list.php" style="text-decoration:none;"> <input type="button"  class="btn btn-primary" name="Back" value="Back" style="width:80px;font-weight:bold;font-size:14px;"/></a>

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
<?php } else {
    if($_POST['submit']=='Update'){
    $ac_year = trim($_POST['ac_year']);
    $is_active = $_POST['is_active'];
    $year ="G-". trim($_POST['year']);
    $ext_year = trim($_POST['ext_year']);
    $semester_type = trim($_POST['semester_type']);
    if($is_active=='1'){
        $qury4 = "UPDATE tbl_cookieadmin SET current_ay='$ac_year', current_sem_type='$semester_type' WHERE id='$group_member_id'";
        // echo $qury4; exit;
       mysql_query($qury4);
       $sql_enable_no="update tbl_academic_Year set Enable='0' where Academic_Year !='".$_POST['ac_year']."' and group_member_id='$group_member_id' ";
        // echo $sql_enable_no;
        $sql_enable_query=mysql_query($sql_enable_no);
    }
    $qury1 = "select * from tbl_school_admin where group_member_id='$group_member_id'";
    // echo $qury1; exit;
    $sql = mysql_query($qury1);
    while($rows = mysql_fetch_array($sql)){
        $sc_id = $rows['school_id'];
        $qury2 = "select * from tbl_academic_Year where group_member_id='$group_member_id' AND school_id='$sc_id' AND Academic_Year='$ac_year'";
    // echo $qury2; exit;
        $query = mysql_num_rows(mysql_query($qury2));
        // print_r($query); exit;
        if($query > 0){
        $sqlquryupdate = mysql_query("UPDATE tbl_academic_Year SET Year='$year',ExtYearID='$ext_year',Enable='$is_active' WHERE school_id='$sc_id' AND group_member_id='$group_member_id' AND Academic_Year='$ac_year'");
        }

    }
        echo "<script type='text/javascript'>alert('Record Updated Successfully');window.location.href='academic_year_list.php'</script>";

    }
    else{
        $sql2 = "select * from tbl_academic_Year  where id=".$_GET['id'];
        $query_result=mysql_query($sql2);
    }

    ?>




<!DOCTYPE html>
<html>
    <head>
    <script type="text/javascript">
    $(document).ready(function(){
        // $("#ac_year").prop("readonly",true);
        $("#is_active").change(function(){

            var isAct = $(this).val();
            if(isAct=="1"){

                $("#semtypeDiv").css("display","block");
                $("#semType").html("<select name='semester_type' id='semester_type' class='form-control' required><option value='odd'>Odd Semesters</option><option value='even'>Even Semesters</option></select>");
            }else{
                $("#semtypeDiv").css("display","none");
                $("#semType").html("");
            }
        });
        
    });
    function valid() {
    
    var a_year = document.getElementById("ac_year").value;
    var pattern =/^[0-9-0-9]{9}$/;
    if (pattern.test(a_year)) {
    //   return true;
    // alert('hello');
    }
    else{
    alert("It is not valid Academic Year!");
    return false;
    }
    
    var year = document.getElementById("year").value;
   
    var pattern = /^[0-9]{4}$/;
    if (pattern.test(year)) {
      return true;
    }
    else{
    alert("It is not valid  Year!");
    return false;
    }
    //added for external year
    var ext_yr= document.querySelector("#ext_year").value;
        var pattern = /^[0-9]+$/;
        if(pattern.test(ext_yr)){
            return true;
            // console.log(ext_yr.value);
        }else{
            return false;
        }
}
</script>
    </head>
    <body>
    
    <div class="container" style="padding:25px;">

    <div style="padding:2px 2px 2px 2px;border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;background-color:#F8F8F8;">

    <form method="post">
        <div class="row">

            <div class="col-md-3 col-md-offset-1" style="color:#700000 ;padding:5px;"></div>

            <div class="col-md-6 " align="center" style="color:#663399;">

                <h2>Edit Academic Year</h2>
                <!-- <h5 align="center"><a href="Add_SubjectSheet_updated_20160109PT.php" >Add Excel Sheet</a></h5>  -->
                <br><br>
            </div>


        </div>
        <?php while($row1=mysql_fetch_array($query_result)){ 
            $get_year=$row1['Year'];
            // print_r($get_year);
            // echo "<br>". $get_year;
            $get_year_explode=explode("-",$get_year);
            $exact_year=$get_year_explode[1];
            ?>
        <input type="hidden" name="id" id="" value="<?php echo $_GET['id']; ?>">

       <div class="row" style="padding-top:30px;">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-2" style="color:#808080;font-size:18px; margin-left:12px">Academic Year:<span style="color:red;font-size: 25px;"></span></div>
                                    <div class="col-md-3">

                <input type="text" name="ac_year" class="form-control datepicker" id="ac_year" placeholder="Academic Year" value="<?php echo $row1['Academic_Year'] ?>" required>

            </div>
            
         </div>
        
           
    
    
    
             <div class="row" style="padding-top:30px;">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-2" style="color:#808080;font-size:18px;margin-left:14px"> Year:<span style="color:red;font-size: 25px;"></span></div>
                                    <div class="col-md-3">
                
                <input type="text" name="year" class="form-control" id="year" placeholder="Year" value="<?php echo $exact_year; ?>" required>

            </div>

            <br/><br/>
            <div class="row" style="padding-top:30px;">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-2" style="color:#808080;font-size:18px;margin-left:14px">External Year Id:<span style="color:red;font-size: 25px;">*</span></div>
                                    <div class="col-md-3">
                
                <input type="text" name="ext_year" class="form-control" id="ext_year" placeholder="External Year" value="<?php echo $row1['ExtYearID'] ?>" readonly required>

            </div>
            <br><br>
            <!-- <div class="row" style="padding-top:30px;">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-2" style="color:#808080;font-size:18px;margin-left:14px">Id :<span style="color:red;font-size: 25px;">*</span></div>
                                    <div class="col-md-3">
                
                <input type="text" name="get_id" class="form-control" id="get_id" placeholder="" value="<?php echo $_GET['id']; ?>" readonly>

            </div> -->
        </div>
    
        <div id="error" style="color:#F00;text-align: center;" align="center"></div>

            <div class="row" style="padding-top:30px;">
                <div class="col-md-4"></div>
                <div class="col-md-2" style="color:#808080; font-size:18px; margin-left: 13px;" > Is Active<span
                            style="color:red;font-size: 25px;"></span></div>
                <div class="col-md-3">
                    <select name="is_active" id="is_active" class="form-control" required>
                        <option value="1" <?php if($row1['Enable']=='1'){echo "selected"; } ?>>Yes</option>
                        <option value="0" <?php if($row1['Enable']=='0'){echo "selected"; } ?> >No</option>
                    </select>
                </div>
            </div>

            <div class="col-md-4 col-md-offset-5"  style="color:#F00; text-align: center;">
                <span class="error"><?php echo $Errcourselevel; ?></span>
            </div>
            <?php if($row1['Enable']=='1'){ ?>
            <div class="row" id="semtypeDiv" style="padding-top:30px;">
                <div class="col-md-4"></div>
                <div class="col-md-2" style="color:#808080; font-size:18px; margin-left: 13px;" >Active Semester Type<span
                            style="color:red;font-size: 25px;"></span></div>
                <div class="col-md-3" id="semType">
                <select name='semester_type' id='semester_type' class='form-control' required>
                    <option value='odd'>Odd Semesters</option>
                    <option value='even'>Even Semesters</option>
                </select>
                </div>
            </div>
                <?php } ?>
        <div class="row" style="padding-top:15px;">

            <div class="col-md-2 col-md-offset-4 ">

                <input type="submit" class="btn btn-primary" name="submit" value="Update"
                       style="width:80px;font-weight:bold;font-size:14px;" id = "btnValid" onClick ="return valid()"/>

            </div>


            <div class="col-md-3 " align="left">

                <a href="academic_year_list.php" style="text-decoration:none;"> <input type="button"  class="btn btn-primary" name="Back" value="Back" style="width:80px;font-weight:bold;font-size:14px;"/></a>

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
            <?php } ?>
    </form>

</div>

    <?php } ?>
    
</body>
</html>


