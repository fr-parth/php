<?Php
ob_start();

if (isset($_GET['name'])) {

    include_once("school_staff_header.php");

    $report = "";


    $results = mysql_query("select * from tbl_school_adminstaff where id=" . $staff_id . "");

    $value = mysql_fetch_array($results);

    $school_id = $value['school_id'];

    $id = $_SESSION['staff_id'];


    ?>

    <!DOCTYPE html>


    <head>


        <link href='css/jquery.dataTables.css' rel='stylesheet' type='text/css'>

        <script src='js/jquery-1.11.1.min.js' type='text/javascript'></script>

        <script src='js/jquery.dataTables.min.js' type='text/javascript'></script>

        <script src="js/dataTables.responsive.min.js"></script>

        <script src="js/dataTables.bootstrap.js"></script>

        <!-- <script>

        $(document).ready(function() {

         $('#example').DataTable();

 } );

         </script>-->


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

                }

                #no-more-tables td:before {

                    /* Now like a table header */

                    position: absolute;

                    /* Top/left values mimic padding */

                    top: 6px;

                    left: 6px;

                    width: 45%;

                    padding-right: 10px;

                    white-space: nowrap;

                    text-align: left;

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


    <body>

    <div class="container">

        <div class="row">

            <div class="col-md-4">

                <div style="height:10px;"></div>

                <div style="background-color:#FFFFFF; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;"
                     align="left">


                    <h2 style="padding-left:20px; margin-top:6px;color:#3333FF">
                        <center><?php echo $dynamic_school ?> Points</center>
                    </h2>

                    <div style="height:20px;"></div>


                    <div class="row">

                        <div class="col-sm-6">

                            <h4 style="padding-left:2px;">Balance Blue Points</h4>

                            <div style="height:10px;"></div>

                            <h2 style="color:#993300">
                                <center><?php


                                    $sql = mysql_query("select balance_blue_points from tbl_school_admin where school_id='$school_id'");

                                    $arr = mysql_fetch_array($sql);

                                    $balance_blue_points = $arr['balance_blue_points'];

                                    echo $balance_blue_points;


                                    ?></center>
                            </h2>


                        </div>

                        <div class="col-md-6">

                            <h4> Assigned Blue Points</h4>

                            <div style="height:10px;"></div>


                            <h2 style="color:#993300">
                                <center>

                                    <?php

                                    $sql1 = mysql_query("select school_assigned_point from  tbl_school_admin where school_id='$school_id'");

                                    $arr1 = mysql_fetch_array($sql1);

                                    $school_assigned_point = $arr1['school_assigned_point'];

                                    echo $school_assigned_point;


                                    ?>  </center>
                            </h2>


                        </div>

                    </div>

                </div>

            </div>

            <div class="col-md-8">


                <div style="width:100%;">


                    <div style="height:10px;"></div>

                    <div style="height:50px; background-color:#FFFFFF; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;"
                         align="left">

                        <h2 style="padding-left:20px; margin-top:2px;color:#666">Assign Blue Points
                            to <?php echo $dynamic_student ?></h2>

                    </div>

                    <div class="container" style="padding-top:20px;">

                        <?php

                        $i = 0;

                        $old_id = 0;

                        $sum = 0;

                        $teacher_id = 0;

                        $teachers_id = array();


                        $arrs = mysql_query("SELECT t.id, t_name, balance_blue_points, sc_point, sc_entites_id FROM tbl_teacher t LEFT JOIN tbl_student_point st ON t.id = st.sc_teacher_id WHERE school_id =  '$school_id'

 ORDER BY t_name ");


                        $teachers_id = array();

                        $teachers_name = array();

                        $teachers_assign_point = array();


                        $teachers_balance_point = array();

                        while ($teacher = mysql_fetch_array($arrs)) {


                            $teacher_id = $teacher['id'];


                            if ($old_id == 0) {

                                $old_id = $teacher_id;


                            }

                            if ($teacher_id == $old_id) {


                                $sum = $sum + $teacher['sc_point'];

                            }


                            if ($teacher_id != $old_id) {


                                $sum = 0;
                                $i++;

                            }

                            $teachers_id[$i] = $teacher_id;

                            $teachers_name[$i] = $teacher['t_name'];


                            $teachers_assign_point[$i] = $sum;

                            $teachers_balance_point[$i] = $teacher['balance_blue_points'];

                            $old_id = $teacher_id;

                        }


                        ?>


                        <table id="example" class=" table-bordered table-striped table-condensed cf" align="center"
                               style="width:100%">


                            <thead>


                            <tr style="background-color:#428BCA; color:#FFFFFF; height:30px;">

                                <th>Sr. No.</th>

                                <th><?php echo $dynamic_student ?>v ID</th>

                                <th><?php echo $dynamic_student ?> Name</th>

                                <th>Assigned Points</th>

                                <th>Balance Points</th>

                                <th></th>


                            </tr>


                            </thead>

                            <tbody>

                            <?php

                            for ($j = 0;
                            $j < count($teachers_id);
                            $j++)

                            {

                            ?>

                            <td><?php echo $j + 1; ?></td>

                            <td><?php echo $teachers_id[$j]; ?></td>

                            <td><?php echo $teachers_name[$j]; ?></td>

                            <td><?php echo $teachers_assign_point[$j]; ?></td>

                            <td><?php echo $teachers_balance_point[$j]; ?></td>

                            <td>
                                <center><a href="teacher_assignpoint.php?teacherID=<?php echo $teachers_id[$j]; ?>">
                                        <input type="button" value="Assign" name="assign"/></a></center>
                            </td>
                            <tr>

                                <?php

                                }

                                ?>

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>


    </body>

    </html>

    <?php

} else {


    include("scadmin_header.php");

    $query = mysql_query("select * from tbl_school_admin where id = " . $_SESSION['id']);

    $value = mysql_fetch_array($query);

    $school_id = $value['school_id'];

    $id = $_SESSION['id'];
	


    ?>

    <!DOCTYPE html>


    <head>


        <link href='css/jquery.dataTables.css' rel='stylesheet' type='text/css'>


        <script src='js/jquery-1.11.1.min.js' type='text/javascript'></script>

        <script src='js/jquery.dataTables.min.js' type='text/javascript'></script>


        <script src="js/dataTables.responsive.min.js"></script>


        <script src="js/ dataTables.bootstrap.js"></script>


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

                }

                #no-more-tables td:before {

                    /* Now like a table header */

                    position: absolute;

                    /* Top/left values mimic padding */

                    top: 6px;

                    left: 6px;

                    width: 45%;

                    padding-right: 10px;

                    white-space: nowrap;

                    text-align: left;

                }

                /*

                Label the data

                */
                #no-more-tables td:before {
                    content: attr(data-title);
                }

            }

        </style>

        <style>

            .row1 {

                padding-top: 10px;

                padding-left: 5px;

            }

        </style>

        <!----Validation for Bluk Assign Point To Student ---->


        <script>

            function validateForm() {


                if (document.getElementById("teacher").value == "") {

                    alert("Please Select Dropdownlist For Assign Bluk Point To Teachers"); // prompt user

                    document.getElementById("teacher").focus(); //set focus back to control

                    return false;

                }


                if (document.getElementById("point").value == "") {

                    alert("Please Enter Point"); // prompt user

                    document.getElementById("point").focus(); //set focus back to control

                    return false;

                }


            }


        </script>

        <!------------------------END------------------------->


        <?php

        $result1 = "";

        $report = "";


        if (isset($_POST['Assign'])) {

		
		
            if ($_POST['point'] > 0) {

			//echo "Hi in point";
                if (isset($_POST['point']) && isset($_POST['Department'])) {

					//echo "Hi in if"; 
                    $dept = trim($_POST['Department']);


                    $sql = mysql_query("select balance_blue_points from tbl_school_admin where school_id='$school_id'");

                    $arr = mysql_fetch_array($sql);

                    $balance_blue_points = $arr['balance_blue_points'];


                    //echo "</br>select count(id) from tbl_teacher where school_id='$school_id' AND t_dept='$dept'";

                    $abc = mysql_query("select count(id) from tbl_teacher where school_id='$school_id' AND t_dept='$dept'");

                    $ab = mysql_fetch_array($abc);


                    $ab['count(id)'];

                    $nowrows = mysql_num_rows($abc);

                    $points = $_POST['point'] * $ab['count(id)'];

                    $point = $_POST['point'];

                    if ($points > $balance_blue_points) {

                        $report = "You have Insufficient Balance Points!!!";

                    } else {

						//echo "hsdsi";die;
					 
                        //echo "</br>update tbl_teacher set balance_blue_points=balance_blue_points+'$point' where school_id='$school_id' AND t_dept='$dept'";

						//echo "UPDATE tbl_teacher SET balance_blue_points = CASE WHEN balance_blue_points = 0 then '$point' ELSE balance_blue_points+$point END where school_id='$school_id' AND t_dept='$dept'";
						
                        $updatepoint = mysql_query("UPDATE tbl_teacher SET balance_blue_points = CASE WHEN balance_blue_points = 0 then '$point' ELSE balance_blue_points+$point END where school_id='$school_id' AND t_dept='$dept'");
						
						
						
						//UPDATE tbl_teacher SET balance_blue_points = CASE WHEN balance_blue_points IS NULL THEN set balance_blue_points = '$point' ELSE set balance_blue_points=balance_blue_points+'$point' END
						//echo "update tbl_teacher set balance_blue_points=balance_blue_points+'$point' where school_id='$school_id' AND t_dept='$dept'";
                        $successreport = "sucessfully Assigned Point To All Teachers by branch $dept";
						
						
						
                        $result = mysql_query("select balance_blue_points,school_assigned_point from tbl_school_admin where school_id='$school_id'");

						
						
                        $sql = mysql_fetch_array($result);


                        $balance_blue_points = $sql['balance_blue_points'];

                        $balance_blue_points = $sql['balance_blue_points'] - $points;

                        $school_assigned_point = $sql['school_assigned_point'] + $points;


                        mysql_query("update tbl_school_admin set balance_blue_points='$balance_blue_points' where school_id='$school_id'");

                        mysql_query("update tbl_school_admin set school_assigned_point='$school_assigned_point' where school_id='$school_id'");
						
						
						//header("location:teacherassign.php");
						
				


                    }

                } elseif (isset($_POST['point']) && !isset($_POST['Department'])) {
					

                    $sql = mysql_query("select balance_blue_points from tbl_school_admin where school_id='$school_id'");

                    $arr = mysql_fetch_array($sql);

                    $balance_blue_points = $arr['balance_blue_points'];


                    //echo "</br>select t_id from tbl_teacher where school_id='$school_id'" ;

                    $abc = mysql_query("select count(id) from tbl_teacher where school_id='$school_id'");

                    $ab = mysql_fetch_array($abc);

                    $points = $_POST['point'] * $ab['count(id)'];

                    $point = $_POST['point'];

                    if ($points > $balance_blue_points) {

                        $report = "You have Insufficient Balance Points!!!";

                    } else {
						
						//echo "UPDATE tbl_teacher SET balance_blue_points = CASE WHEN balance_blue_points = 0 then '$point' WHEN balance_blue_points = '' THEN '$point' ELSE balance_blue_points+$point END where school_id='$school_id'";

                        $updatepoint = mysql_query("UPDATE tbl_teacher SET balance_blue_points = CASE WHEN balance_blue_points = 0 then '$point' WHEN balance_blue_points Is Null THEN '$point' ELSE balance_blue_points+$point END where school_id='$school_id'");
						 
						
						 

                        $successreport .= "Successfully Assigned Point To All Teachers";

                        $result = mysql_query("select balance_blue_points,school_assigned_point from tbl_school_admin where school_id='$school_id'");

                        $sql = mysql_fetch_array($result);


                        $balance_blue_points = $sql['balance_blue_points'];

                        $balance_blue_points = $sql['balance_blue_points'] - $points;

                        $school_assigned_point = $sql['school_assigned_point'] + $points;


                        mysql_query("update tbl_school_admin set balance_blue_points='$balance_blue_points' where school_id='$school_id'");

                        mysql_query("update tbl_school_admin set school_assigned_point='$school_assigned_point' where school_id='$school_id'");


                    }

                }


                //header("location:teacherassign.php");

            } else {
                $report = "Enter valid points";

            }

        }

        ?>

    </head>

    <script>

        function MyAlert(course) {

            //alert(course);

            if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari

                xmlhttp = new XMLHttpRequest();

            }

            else {// code for IE6, IE5

                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");

            }

            xmlhttp.onreadystatechange = function () {

                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {

                    var points = xmlhttp.responseText;

                    //alert(points);


                    document.getElementById('Department1').innerHTML = points;

                }

            }

            xmlhttp.open("GET", "get_branch_for_asign_blue_point.php?course=" + course, true);

            xmlhttp.send();

        }


        function showbranchwiselist(br) {

            //alert(br);
	
            if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari

                xmlhttp = new XMLHttpRequest();

            }

            else {// code for IE6, IE5

                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");

            }

            xmlhttp.onreadystatechange = function () {

                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {

                    var points = xmlhttp.responseText;

                    //alert(points);


                    document.getElementById('dpt').innerHTML = points;

                }

            }


            xmlhttp.open("GET", "get_branch_list_blue_point.php?branch=" + br, true);

            xmlhttp.send();

        }


    </script>

    <script>

        $(function () {


            $("#teacher").change(function () {

                var bulk = document.getElementById('teacher').value;

				//alert("Hi");	
                // document.category.submit();

                // document.forms["category"].submit();

                MyAlert(bulk);


            })


        });

    </script>

    <script>

        $(document).ready(function () {

            $('#example').DataTable();

        });

    </script>

    <body>

    <div class="container">

        <div class="row" style="padding-top:10px;"></div>


        <div class="col-md-4">


            <div class="panel panel-default">

                <div class="panel-heading h4">
                    <center><?php echo $dynamic_school?> Points</center>
                </div>


                <div class="panel-body">

                    <a href="#" class="list-group-item">Balance Blue Points

                        <span class="badge">

		

       <?php


       $sql = mysql_query("select balance_blue_points from tbl_school_admin where school_id='$school_id'");

       $arr = mysql_fetch_array($sql);

       $balance_blue_points = $arr['balance_blue_points'];

       echo $balance_blue_points;


       ?>

        </span></a>


                    <a href="#" class="list-group-item">Assigned Blue Points

                        <span class="badge">

		<?php

        $sql1 = mysql_query("select school_assigned_point from  tbl_school_admin where school_id='$school_id'");

        $arr1 = mysql_fetch_array($sql1);

        $school_assigned_point = $arr1['school_assigned_point'];

        echo $school_assigned_point;


        ?>

         </span></a>


                </div>

            </div>

            <form action="" name="bulk" id="bulk" method="post" onSubmit="return validateForm()">

                <div class="panel panel-default">

                    <div class="panel-heading h4">
                        <center>Bulk Assign Point</center>
                    </div>

                    <div class="panel-body">

                        <div class="row form-inline" style="padding-top:20px;">


                            <div style="float:left;width:150px;padding-left:10px;">Select <?php echo $dynamic_teacher?></div>
                            <div style="float:left;">
                                <select name="teacher" id="teacher" class="form-control"
                                        style="width:140px;padding-left:10px;">

                                    <option value="">Select</option>

                                    <option value="teacher">All <?php echo $dynamic_teacher?></option>

                                    <option value="Dept">Branch Wise</option>

                                </select>
                            </div>
            </form>

        </div>


        <div id="Department1">

        </div>


        <div class="row form-inline" style="padding-top:20px;">

            <div style="float:left;width:150px;padding-left:10px;">Enter Points</div>&nbsp;&nbsp;

            <div style="float:left;"><input type="text" name="point" id="point" style="width:120px;"
                                            class="form-control"></div>
        </div>
        <div align="center" style="padding-top:10px;"><input type="submit" class="btn btn-default btn-sm" name="Assign"
                                                             id="Assign" value="Assign"></div>

        <div style="color:#FF0000;" class="row1">

            <?php

            echo $report;

            echo $result1;

            ?>

        </div>
        <div style="color:#090;" class="row1">

            <?php

            echo $successreport;


            ?>

        </div>


    </div>

    </div></div>


    <div class="col-md-8">

        </form>

        <div id="dpt">

            <div class="panel panel-default">

                <?php

                if (isset($_POST['Department']))

                {

                $dpt = $_POST['Department']

                ?>

                <div class="panel-heading h4">&nbsp;&nbsp;
                    <center>Assign Points to <?php echo $dpt ?> Branch  <?php echo $dynamic_teacher?></center>
                </div>


                <div class="col-md-12" id="no-more-tables" style="padding-top:30px;">

                    <?php $i = 0; ?>

                    <table class="table-bordered  table-condensed cf" id="example" width="100%;">

                        <thead>

                        <tr style="background-color:#428BCA">
                            <th>Sr. No.</th>

                            <th><?php echo $dynamic_teacher?> Name</th>

                            <th>Balance Blue Points</th>

                            <th>Used Blue Points</th>

                            <th>Branch</th>

                            <th>Assign</th>

                        </tr>
                        </thead>
                        <tbody>

                        <?php

                        $i = 1;

                        $arr = mysql_query("SELECT id,t_id, t_name,t_complete_name,t_middlename,t_lastname,t_dept, balance_blue_points FROM `tbl_teacher` WHERE school_id ='$school_id' AND t_dept='$dpt'  and (t_emp_type_pid=133 or `t_emp_type_pid`=134) order by t_complete_name,t_name ASC "); ?>

                        <?php while ($row = mysql_fetch_array($arr)) {

                            $teacher_id = $row['t_id'];


                            ?>

                            <tr style="color:#808080;" class="active">

                                <td data-title="Sr.No"><?php echo $i; ?></td>

                                <td data-title="Teacher Name">

                                    <?php $t_complete_name = $row['t_complete_name'];

                                    if ($t_complete_name == "") {

                                        echo ucwords(strtolower($row['t_name'] . " " . $row['t_middlename'] . " " . $row['t_lastname']));

                                    } else {

                                        echo ucwords(strtolower($t_complete_name));

                                    }

                                    ?>

                                </td>

                                <td data-title="Green Balance Points">

                                    <?php echo $row['balance_blue_points']; ?>

                                </td>


                                <td data-title="USed green Points">


                                    <?php 
									//$query = mysql_query("select sum(sc_point) as sc_point  from tbl_student_point where sc_entites_id ='103' and sc_teacher_id='$teacher_id' and school_id='$school_id'");

                                    //$test = mysql_fetch_array($query);


                                    $sc_point = $row['used_blue_points'];

                                    if ($sc_point == "" || $sc_point == 0) {

                                        echo "0";

                                    } else {

                                        echo $sc_point;

                                    }

                                    ?>


                                </td>

                                <td data-title="Branch"> <?php echo $row['t_dept']; ?>  </td>

                                <td data-title="Assign">
                                    <center>
									<a href="admin_assign_thanQpoint.php?id=<?php echo $teacher_id;?> " style='text-decoration:none'> <input type="button"  class="btn btn-primary" value="Assign" name="assign"/></a>
                                        <!-- <a href="teacher_assignpoint.php?id=<?php //echo $teacher_id; ?>,<?php //$school_id ?>">
                                            <input type="button" value="Assign" name="assign"/></a>
											-->
											</center>
                                </td>


                            </tr>


                            <?php


                            $i++;

                        }

                        }

                        else

                        {

                        ?>

                        <div class="panel-heading h2">
                            <center>Assign Blue Points to <?php echo $dynamic_teacher?></center>
                        </div>


                        <div class="col-md-12  " id="no-more-tables" style="padding-top:30px;">

                            <?php $i = 0; ?>

                            <table class="table-bordered  table-condensed cf" id="example" width="100%;">

                                <thead>

                                <tr style="background-color:#428BCA">
                                    <th>Sr.No.</th>

                                    <th><?php echo $dynamic_teacher?> Name</th>

                                    <th>Balance Blue Points</th>

                                    <th>Used Blue Points</th>

                                    <th>Assign</th>

                                </tr>
                                </thead>
                                <tbody>

                                <?php

                                $i = 1;

                                $arr = mysql_query("SELECT * FROM tbl_teacher where school_id='$school_id' and (t_emp_type_pid=133 or `t_emp_type_pid`=134) order by t_complete_name ASC "); ?>

                                <?php while ($row = mysql_fetch_array($arr)) {

                                    $teacher_id = $row['t_id'];
									$id = $row['id'];
									
									
                                    ?>

                                    <tr style="color:#808080;" class="active">

                                        <td data-title="Sr.No"><?php echo $i; ?></td>

                                        <td data-title="Teacher Name">

                                            <?php $t_complete_name = $row['t_complete_name'];

                                            if ($t_complete_name == "") {

                                                echo ucwords(strtolower($row['t_name'] . " " . $row['t_middlename'] . " " . $row['t_lastname']));

                                            } else {

                                                echo ucwords(strtolower($row['t_complete_name']));

                                            }

                                            ?>

                                        </td>

                                        <td data-title="Green Balance Points">

                                            <?php echo $row['balance_blue_points']; ?>

                                        </td>


                                        <td data-title="USed green Points">

                                            <?php
											//$query = mysql_query("select sum(sc_point) as sc_point  from tbl_student_point where sc_entites_id ='103' and sc_teacher_id='$teacher_id' and school_id='$school_id'");

                                           // $test = mysql_fetch_array($query);


                                            $sc_point = $row['used_blue_points'];

                                            if ($sc_point == "" || $sc_point == 0) {

                                                echo "0";


                                            } else {

                                                echo $sc_point;

                                            }

                                            ?>


                                        </td>


                                        <td data-title="Assign">
                                            <center>
											<a href="admin_assign_thanQpoint.php?id=<?php echo $id;?> " style='text-decoration:none'> <input type="button"  class="btn btn-primary" value="Assign" name="assign"/></a>
											
                                              <!--  <a href="teacher_assignpoint.php?id=<?php //echo $teacher_id; ?>,<?php //echo $school_id; ?>"> 
												
                                                    <input type="button" value="Assign" name="assign"/></a> -->
													
													</center>
                                        </td>


                                    </tr>


                                    <?php


                                    $i++;

                                }

                                }

                                ?>


                                </tbody>

                            </table>


                        </div>

                </div>

            </div>

        </div>

    </div>

    </div>

    </body>


    <?php

}

?>

