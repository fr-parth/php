<?php
//include("conn.php");

if (isset($_GET['name'])) {   

    //$id=$_SESSION['staff_id'];

    include_once("school_staff_header.php");

    $report = "";

    $results = mysql_query("select * from tbl_school_adminstaff where id=" . $id . "");

    $result = mysql_fetch_array($results);

    $Get_staff = $result['id'];

    $sc_id = $result['school_id'];

    ?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
            "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

    <html xmlns="http://www.w3.org/1999/xhtml"> 
    <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css"> 
    <link rel="stylesheet" href="css/bootstrap.min.css"> 
    <script src="js/jquery-1.11.1.min.js"></script> 
    <script src="js/jquery.dataTables.min.js"></script> 

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


    <head>

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

        <title>Untitled Document</title>

    </head>

    <script>

        $(document).ready(function () {

            $('#example').dataTable({});

        });


        function confirmation(xxx) {


            var answer = confirm("Are you sure you want to delete?")

            if (answer) {


                window.location = "delete_teacher.php?id=" + xxx;

            }

            else {


            }

        }


    </script>

    <body bgcolor="#CCCCCC">

    <div style="bgcolor:#CCCCCC">


        <div class="container" style="padding:30px;">


            <div style="border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">


                <div style="background-color:#F8F8F8 ;">

                    <div class="row">

                        <div class="col-md-3 " style="color:#700000 ;padding:5px;">&nbsp;&nbsp;&nbsp;&nbsp;

                            <a href="teacher_setup.php?id=<?= $Get_staff ?>"> <input type="submit"
                                                                                     class="btn btn-primary"
                                                                                     name="submit" value="Add Teacher"
                                                                                     style="width:150;font-weight:bold;font-size:14px;"/></a>

                        </div>

                        <div class="col-md-6 " align="center">

                            <h2>List of Teachers </h2>

                        </div>


                    </div>

                    <div class="row" style="padding:10px;">

                        <div class="col-md-12  " id="no-more-tables">

                            <?php $i = 0; ?>


                            <table class="table-bordered  table-condensed cf" id="example" width="100%;">

                                <thead>

                                <tr style="background-color:#555;color:#FFFFFF;height:30px;">
                                <!-- Camel casing done for Sr. No. by Pranali -->
                                    <th>Sr. No.</th>
                                    <th><b>Teacher ID</b></th>
                                    <th>Name</th>
                                    <th>Phone No.</th>

                                    <th style="width:20%;">Landline No.</th>
                                    <th style="width:20%;">Email ID</th>
                                    <th style="width:20%;">Internal Email ID</th>
                                    <th>Department</th>
                                    <th>Date Of Appointment</th>
                                    <th style="width:20%;">Gender</th>
                                    <th style="width:20%;">DOB</th>
                                    <th style="width:10%;">Emp. Type PID</th>
                                    <th>Address</th>
                                    <th>Green Balance Points</th>
                                    <th style="width:10%;">Green Assigned Points</th>
                                    <th style="width:10%;">Blue Balance Points</th>
                                    <th>Blue Shared Points</th>

                                    <th style="width:10%;">Delete</th>

                                    <th style="width:10%;">Edit</th>
                                </thead>
                                <tbody>

                                <?php


                                $i = 1;

                                $arr = mysql_query("select * from tbl_teacher where school_id=$sc_id order by id"); ?>

                                <?php while ($row = mysql_fetch_array($arr)) {
                                    //print_r($row);exit;
                                    $teacher_id = $row['id'];

                                    ?>

                                    <tr style="color:#808080;" class="active">

                                        <td data-title="Sr.No" style="width:10%;"><b><?php echo $i; ?></b></td>

                                        <td data-title="Teacher ID" style="width:10%;">
                                            <b><?php echo $row['t_id']; ?></b></td>

                                        <td data-title="Name"
                                            style="width:20%;"><?php echo $row['t_complete_name'] ?></td>


                                        <td data-title="Phone" style="width:10%;"><?php echo $row['t_phone']; ?> </td>

                                        <td data-title="landline"
                                            style="width:10%;"><?php echo $row['t_landline']; ?> </td>

                                        <td data-title="email" style="width:0%;"><?php echo $row['t_email']; ?> </td>

                                        <td data-title="internal_email"
                                            style="width:0%;"><?php echo $row['t_internal_email']; ?> </td>

                                        <td data-title="Department"
                                            style="width:10%;"><?php

                                                //query added by Sayali for SMC-5030 on 11/12/2020
                                            //$query=mysql_query("select distinct(dm.ExtDeptId),dm.Dept_Name,t.t_dept, t.t_DeptID  from   tbl_department_master dm left JOIN tbl_teacher t 
                                             //on (dm.ExtDeptId= t.t_DeptID or dm.ExtDeptId=t.t_dept) 
                                             //and dm.School_ID=t.school_id
                                             //where dm.School_ID='$school_id' and t.t_id='".$row['t_id']."' and dm.ExtDeptId!='' ");
                                                            
                                            
                                            echo $row['t_dept']; ?> </td>

                                        <td data-title="date"
                                            style="width:10%;"><?php echo $row['t_date_of_appointment']; ?> </td>

                                        <td data-title="Gender" style="width:10%;"><?php echo $row['t_gender']; ?> </td>

                                        <td data-title="dob" style="width:10%;"><?php echo $row['t_dob']; ?> </td>

                                        <td data-title="employee_id"
                                            style="width:10%;"><?php echo $row['t_emp_type_pid']; ?> </td>

                                        <td data-title="address"
                                            style="width:10%;"><?php echo $row['t_address']; ?> </td>

                                        <td data-title="Green Balance  Points" style="width:10%;">

                                            <?php echo $row['tc_balance_point']; ?>


                                        </td>


                                        <td data-title=" Green Assigned  Points" style="width:10%;">

                                            <?php

                                            //echo "select  s.id, sum(s.sc_point) total,s.sc_point,s.sc_teacher_id, s.sc_stud_id, s.point_date, s.sc_studentpointlist_id,t.school_id, t.t_pc,t.t_name,t.tc_balance_point from tbl_student_point s, tbl_teacher t where s.sc_teacher_id = t.id and s.sc_entites_id='103'and t.id='$teacher_id'";
                                            $sql = mysql_query("select  s.id, sum(s.sc_point) total,s.sc_point,s.sc_teacher_id, s.sc_stud_id, s.point_date, s.sc_studentpointlist_id,t.school_id, t.t_pc,t.t_name,t.tc_balance_point from tbl_student_point s, tbl_teacher t where s.sc_teacher_id = t.id and s.sc_entites_id='103'and t.id='$teacher_id'");

                                            $result = mysql_fetch_array($sql);

                                            $total = $result['total'];

                                            if ($total == "" || $total == 0) {

                                                echo "0";

                                            } else {

                                                echo $total;

                                            }

                                            ?>


                                        </td>

                                        <td data-title="Blue Balance Points" style="width:10%;">

                                            <?php echo $row['balance_blue_points']; ?>


                                        </td>

                                        <td data-title="Blue Assigned Points" style="width:10%;">

                                            <?php

                                            $query = mysql_query("select sum(sc_point) as sc_point  from tbl_teacher_point sp join tbl_teacher s where sp.sc_teacher_id=s.id and sp.sc_entities_id='103' and sp.assigner_id='$teacher_id' ");


                                            $test = mysql_fetch_array($query);

                                            $sc_point = $test['sc_point'];

                                            if ($sc_point == "" || $sc_point == 0) {

                                                echo "0";


                                            } else {

                                                echo $sc_point;

                                            }


                                            ?>


                                        </td>


                                        <td><a onClick="confirmation(<?php echo $teacher_id; ?>)"
                                               style="text-decoration:none">
                                                <center><img src="Images/trash.png" alt="" title="" border="0"/>
                                                </center>

                                            </a></td>


                                        <td><a href="teacher_setup.php?edit_id=<?= $teacher_id ?>">
                                                <center><img src="Images/edit.jpg" width="30" height="29" alt=""
                                                             title="" border="0"/></center>

                                            </a></td>


                                    </tr>

                                    <?php

                                    $i++;

                                    ?>

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

    </body>    

    <!----------------------------------------------------End---School Staff------------------------------------------------------------->
    </html>

    <?php

} else {

    ?>

    <?php


    include('scadmin_header.php');

    $report = "";
    
$results=$smartcookie->retrive_individual($table,$fields);
$result=mysql_fetch_array($results);
$school_id1=$result['school_id'];

    $smartcookie = new smartcookie();

    $id = $_SESSION['id'];

    $fields = array("id" => $id);

    $table = "tbl_school_admin";

    $smartcookie = new smartcookie(); 

    $results = $smartcookie->retrive_individual($table, $fields);

    $result = mysql_fetch_array($results);
    $sc_id = $result['school_id'];
 
    ?>


    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

    <html xmlns="http://www.w3.org/1999/xhtml">

    <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">

    <link rel="stylesheet" href="css/bootstrap.min.css">


    <script src="js/jquery-1.11.1.min.js"></script>

    <script src="js/jquery.dataTables.min.js"></script>


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


    <head>

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

        <title>Untitled Document</title>

    </head>

    <script>

        $(document).ready(function () {

            $('#example').dataTable({});

        });


        function confirmation(xxx) {


            var answer = confirm("Are you sure you want to delete?")

            if (answer) {

                    alert('record deleted successfully');
                window.location = "delete_nonteacher.php?id=" + xxx;

            }

            else {


            }

        }


    </script>

    <body bgcolor="#CCCCCC">

    <div style="bgcolor:#CCCCCC">


        <div class="container" style="padding:30px;">


            <div style="border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">


                <div style="background-color:#F8F8F8 ;">

                    <div class="row">

                        <div class="col-md-3 " style="color:#700000 ;padding:5px;">&nbsp;&nbsp;&nbsp;&nbsp;

                            <a href="add_Nonteacherlist.php"> <input type="submit" class="btn btn-primary" name="submit"
                                                                    value="Add <?php echo $nonTeacherStaff;?>"
                                                                    style="width:190;font-weight:bold;font-size:14px;"/></a>

                        </div>

                        <div class="col-md-6 " align="center">


                            <h2>List of <?php echo $nonTeacherStaff; ?></h2>

                        </div>


                    </div>


                    <div class="row" style="padding:10px;">


                        <div class="col-md-12  " id="no-more-tables">

                            <?php $i = 0; ?>

                            <table class="table-bordered  table-condensed cf" id="example" width="100%;">

                                <thead>


                                <tr style="background-color:#555;color:#FFFFFF;height:30px;">
                                <!-- Camel casing done for Sr. No. and NonTeachingStaff ID by Pranali -->
                                    <th>Sr. No.</th>
                                    <th>Profile Image</th>
                                    <th><?php echo $nonTeacherStaff;?> ID</th>
                                    <th style="width:385px;">Name</th>
                                    <th>Phone No.</th>
                                    <th>Email ID</th>
                                    <th>Department</th>

                                    <th>Department Code</th>
                                     <?php if ($school_type == 'organization' && $user=='HR Admin'){ ?>
                                    <th>Management Level</th>
                                    <?php } ?>
                                    <th>Edit</th>
                                    <th>Delete</th>

                                </tr>
                                </thead>

                                <tbody>

                                <?php
                                //changes by done Sayali Balkawade on 4th september,2019 - remove 135 and 137 from  non-teaching staff 
                                define('MAX_REC_PER_PAGE', 1000000);
                                $rs = mysql_query("select * from tbl_teacher where `t_emp_type_pid`!=133 and `t_emp_type_pid`!=134 and `t_emp_type_pid`!=135 and `t_emp_type_pid`!=137 and school_id='$school_id1' order by id"); 
                                $total = mysql_num_rows($rs);
                                $total_pages = ceil($total / MAX_REC_PER_PAGE);
                                $page = intval(@$_GET["page"]);
                                if(0 == $page){
                                    $page = 1;
                                    }
                                $start = MAX_REC_PER_PAGE * ($page - 1);
                                $max = MAX_REC_PER_PAGE;
                                $i=$start + 1;
                                //echo "select * from tbl_teacher where (`t_emp_type_pid`!='133' and `t_emp_type_pid`!='134') and school_id='$sc_id' order by id";
                                $arr = mysql_query(" select * from tbl_teacher where `t_emp_type_pid`!=133 and `t_emp_type_pid`!=134 and `t_emp_type_pid`!=135 and `t_emp_type_pid`!=137 and school_id='$school_id1' order by id LIMIT $start, $max") ?>

                                <?php while ($row = mysql_fetch_array($arr)) {

                                    $teacher_id = $row['id'];

                                    ?>

                                    <tr>


                                        <td><?php echo $i; ?></td>

                                        <td data-title="Profile Picture"
                                            style="width:10%;"><?php if ($row['t_pc'] != "") { ?><img
                                                src="<?php echo $row['t_pc']; ?>"  class="preview"
                                                style=" width:70px;height:70px;"
                                                alt="Responsive image" /><?php } else { ?> <img
                                                    src="Images/avatar_2x.png"
                                                    style="border:1px solid #CCCCCC; width:70px;height:70px;"
                                                    class="preview" alt="Responsive image"/><?php } ?></td>

                                        <td><?php echo $row['t_id']; ?></td>


                                        <td><?php


                                            if ($row['t_complete_name'] == "") {

                                                echo ucwords(strtolower($row['t_name'] . " " . $row['t_middlename'] . " " . $row['t_lastname']));

                                            } else {


                                                echo ucwords(strtolower($row['t_complete_name']));


                                            }

                                            ?></td>

                                        <td><?php echo $row['t_phone']; ?> </td>


                                        <td><?php echo $row['t_email']; ?> </td>

                                        <td><?php 

                                        //query added by Sayali for SMC-5030 on 11/12/2020
                                            $query=mysql_query("select dm.ExtDeptId,t.t_dept, t.t_DeptID  from   tbl_department_master dm left JOIN tbl_teacher t 
                                            on dm.ExtDeptId= t.t_DeptID where dm.school_id='$school_id' and t.school_id='$school_id' and t.t_id='".$row['t_id']."' and dm.ExtDeptId!='' ");
                                            $rows=mysql_fetch_array($query);
                                        
                                        if($row['t_dept']==NULL){ echo "Non Teaching Staff"; }else { echo $row['t_dept']; } ?> </td>
                                        <td><?php if($row['t_DeptID']==NULL){ echo "All"; }else{ echo $row['t_DeptID']; } ?></td>
                                        
                                         <?php if ($school_type == 'organization' && $user=='HR Admin'){ ?>
                                    
                                    
                                        <td><?php 

$t_emp_type_pid=$row['t_emp_type_pid'];
if($t_emp_type_pid=='143' )
{
    echo Chairman;
}
if($t_emp_type_pid=='141')
{
    echo Vice; echo " "; echo Chairman;
}
if($t_emp_type_pid=='139')
{
    echo Member ; echo " "; echo Secretary;
}

 ?> </td>
 <?php } ?>

                                        <td><a href="add_Nonteacherlist.php?t_id=<?php echo $row['t_id']; ?>">
                                                <center><img src="Images/edit.png" height="20px" width="20px">
                                            </a></center></td>

                                        <td>
                                            <center><img src="Images/cancel.png" style=" width:25px;height:25px;"
                                                         alt="Cancel" id="<?php echo $row['id']; ?>"
                                                         onclick="return confirmation(this.id)"></center>
                                        </td>

                                    </tr>

                                    <?php

                                    $i++;

                                    ?>

                                <?php } ?>


                                </tbody>

                            </table>


                            <div>
                                <center>
                                <?php
                                // for previous
                                if($page > 1)
                                    {
                                    $previous = $page - 1;
                                ?>
                                <a href="?page=<?php echo $previous; ?>&max=<?php echo $max; ?>"> << PREV 100 </a>
                                <?php
                                // for next
                                    }
                                if($page < $total_pages)
                                    {
                                    $next = $page + 1;
                                ?>
                                &nbsp &nbsp <a href="?page=<?php echo $next; ?>&max=<?php echo $max; ?>"> NEXT 100>> </a>
                                <?php
                                    }
                                ?>  
                                </center>
                            </div>      
                        </div>

                    </div>


                    <div class="row" style="padding:5px;">

                        <div class="col-md-4">

                        </div>

                        <div class="col-md-3 " align="center">


                            </form>

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

    </body>

    </html>

    <?php

}

?>