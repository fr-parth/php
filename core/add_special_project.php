<?php
include('cookieadminheader.php');
$report = "";
$smartcookie = new smartcookie();
$results = $smartcookie->retrive_individual($table, $fields);
$result = mysql_fetch_array($results);
$sc_id = $result['school_id'];
if (isset($_POST['submit'])) {
    $project_name = $_POST['project_name'];
    $project_code = $_POST['project_code'];
    $isenable = $_POST['isenable'];
    $results = mysql_query("SELECT id,project_name,project_code FROM tbl_special_project WHERE project_name='$project_name' or project_code='$project_code'");
    if (mysql_num_rows($results) == 0) {
        $query = "insert into tbl_special_project(project_name,project_code,project_enabled) values('$project_name','$project_code','$isenable') ";
        $rs = mysql_query($query);
        //$successreport = "Record inserted Successfully";
		echo "<script LANGUAGE='JavaScript'>
					window.alert('Project inserted Successfully');
					window.location.href='special_project.php';
					</script>";
    } else {
        $errorreport = 'Project already present';
    }
}
?>
<script  src="http://code.jquery.com/jquery-3.2.1.min.js"  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
			<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.js"></script>
			<script type="text/javascript">

function valid() {
	//alert('hi');
var course = document.getElementById("project_name").value;
        var pattern = /^[a-zA-Z ]+$/;
		if(course.trim()=="" || course.trim()==null)
		{
			alert("Please enter Project Name !");
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

                <h2>Add Special Project</h2>
                <!-- <h5 align="center"><a href="Add_SubjectSheet_updated_20160109PT.php" >Add Excel Sheet</a></h5>  -->
                <br><br>
            </div>


        </div>

       <div class="row" style="padding-top:30px;">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-4" style="color:#808080;font-size:18px;margin-left:50px"> Special Project name Level:<span style="color:red;font-size: 25px;">*</span></div>
                                    <div class="col-md-3">

                <input type="text" name="project_name" class="form-control " id="project_name" placeholder="Project Name" required style="margin-left:-35px">

            </div>
         </div>
         <br>
         <div class="row" style="padding-top:30px;">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-4" style="color:#808080;font-size:18px;margin-left:50px"> Special Project Code:</div>
                                    <div class="col-md-3">

                <input type="text" name="project_code" class="form-control " id="project_code" placeholder="Project Code" style="margin-left:-35px">

            </div>
         </div>
             <br/><br/>
		 
		 <div class="col-md-4"></div>
                <div class="row" style="padding-top:10px; margin-left:60px; ">
                    <div class="col-md-2"></div>
                    <div class="col-md-4" style="color:#808080; font-size:18px;">Is Enabled</div>
                    <div class="col-md-3">Yes&nbsp;&nbsp; <input type="radio" name="isenable" id="isenable1" class="isenable" value="1"> &nbsp;&nbsp;No&nbsp;
                        &nbsp;&nbsp;<input type="radio" name="isenable" id="isenable2" class="isenable" value="0">
                    </div>
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

                <a href="list_360_feedback_activitylevel.php" style="text-decoration:none;"> <input type="button"
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


