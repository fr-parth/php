<?Php
ob_start();
/* Modified file by  Pranali Dalvi
Date : 27-02-21
This file was modified for displaying school's blue point and used blue point, assign points in bulk to all teachers, assign points to teachers department wise (SMC-4979)
*/

    include("scadmin_header.php");
  
if($_SESSION['usertype']=='HR Admin Staff'  OR $_SESSION['usertype']=='School Admin Staff')
  {
    $sc_id=$_SESSION['school_id']; 
    $query2 = mysql_query("select id from tbl_school_admin where school_id ='$sc_id'");

    $value2 = mysql_fetch_array($query2);

    $id = $value2['id'];
    
    
  }
  else
  {
    $id = $_SESSION['id'];
  }
    $query = mysql_query("select * from tbl_school_admin where id ='$id'");

    $value = mysql_fetch_array($query);

    $school_id = $value['school_id'];

   // $id = $_SESSION['id'];


    ?>

    <!DOCTYPE html>


    <head>


        <link href='css/jquery.dataTables.css' rel='stylesheet' type='text/css'>


        <script src='js/jquery-1.11.1.min.js' type='text/javascript'></script>

        <script src='js/jquery.dataTables.min.js' type='text/javascript'></script>


        <script src="js/dataTables.responsive.min.js"></script>


        <script src="js/dataTables.bootstrap.js"></script>


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

                    alert("Please Select Dropdownlist For Assign Bluk Point To <?php echo $dynamic_teacher;?>"); // prompt user

                    document.getElementById("teacher").focus(); //set focus back to control

                    return false;

                }
                //Below condition added by Pranali
                 else if (document.getElementById("teacher").value == "Dept") {
                 
                    if(document.getElementById("Department").value == "select"){
                        
                        alert("Please Select Department");
                        document.getElementById("teacher").focus(); //set focus back to control

                    return false;
                    }
                 }
                var pt = document.getElementById("point").value;
                    if (pt.trim() == "" || pt.trim() == null) {

                        alert("Please Enter Point"); // prompt user

                        document.getElementById("point").focus(); //set focus back to control

                        return false;

                }
                else if(pt==0 || pt < 0){
                  alert("Please enter points greater than 0");
                  return false;
                }


            }


        </script>

        <!------------------------END------------------------->


        <?php

        $result1 = "";

        $report = "";

//Given alert for each message by Pranali for SMC-4979
        if (isset($_POST['Assign'])) {

        
        
            if ($_POST['point'] > 0) {

            
                if (isset($_POST['point']) && isset($_POST['Department'])) {

                     
                    $dept = trim($_POST['Department']);


                    $sql = mysql_query("select balance_blue_points from tbl_school_admin where school_id='$school_id'");

                    $arr = mysql_fetch_array($sql);

                    $school_balance_point = $arr['balance_blue_points'];


                    $abc = mysql_query("select count(id) from tbl_teacher where school_id='$school_id' AND t_dept='$dept'");

                    $ab = mysql_fetch_array($abc);


                    $nowrows = mysql_num_rows($abc);

                    $points = $_POST['point'] * $ab['count(id)'];

                    $point = $_POST['point'];

                    //Change in if condition done by Pranali for bug SMC-3274
                    if ($points >= $school_balance_point) {

                        $report = "You have Insufficient Balance Points!!!";
                        echo "<script> alert('".$report."'); window.location.href='teacher_thanQ_points.php'; </script>";

                    } else {

                        $updatepoint = mysql_query("UPDATE tbl_teacher SET balance_blue_points = CASE WHEN balance_blue_points = 0 then '$point' ELSE balance_blue_points+$point END where school_id='$school_id' AND t_dept='$dept'");
                        
                        //Below Select and Insert queries added by Pranali for bug SMC-3276
                        
                         $sql = mysql_query("SELECT * FROM tbl_teacher where school_id='$school_id' and t_dept='$dept'");
                        
                        while($row = mysql_fetch_array($sql))
                        {
                            $tID=$row['t_id'];
                            $sID=$_SESSION['id'];
                                
                            // Start SMC-3495 Modify By yogesh 2018-10-04 07:04 PM 
                            //$pointDate=date('d/m/Y');;
                            $pointDate = CURRENT_TIMESTAMP; // define in core/securityfunctions.php
                            //end SMC-3495
                   
           
           
           
                         $insert=mysql_query("INSERT into tbl_teacher_point(sc_teacher_id,sc_entities_id,assigner_id,sc_point,point_date,reason,school_id,point_type) values ('$tID','102','$sID','$point','$pointDate',
                            'assigned by $dynamic_school_admin','$school_id','Blue Points')");
                        }
            
                        //changes end
                        $successreport = "Successfully Assigned Point To All $dynamic_teacher by Department $dept";
                        
                        
                        
                        $result = mysql_query("select balance_blue_points,assign_blue_points from tbl_school_admin where school_id='$school_id'");

                        
                        
                        $sql = mysql_fetch_array($result);


                        $school_balance_point = $sql['balance_blue_points'];

                        $school_balance_point = $sql['balance_blue_points'] - $points;

                        $school_assigned_point = $sql['assign_blue_points'] + $points;


                        mysql_query("update tbl_school_admin set balance_blue_points='$school_balance_point' where school_id='$school_id'");

                        mysql_query("update tbl_school_admin set assign_blue_points='$school_assigned_point' where school_id='$school_id'");
                        
                        echo "<script> alert('".$successreport."'); window.location.href='teacher_thanQ_points.php'; </script>";
                        
                    }

                } elseif (isset($_POST['point']) && !isset($_POST['Department'])) {
                    

                    $sql = mysql_query("select balance_blue_points from tbl_school_admin where school_id='$school_id'");

                    $arr = mysql_fetch_array($sql);

                    $school_balance_point = $arr['balance_blue_points'];

                    $abc = mysql_query("select count(id) from tbl_teacher where school_id='$school_id' and (t_emp_type_pid=133 or `t_emp_type_pid`=134 or `t_emp_type_pid`=135 or `t_emp_type_pid`=137)");

                    $ab = mysql_fetch_array($abc);
                    
                     $points = $_POST['point'] * $ab['count(id)'];

                    $point = $_POST['point'];

                    //Change in if condition done by Pranali for bug SMC-3274
                    if ($points >= $school_balance_point) {

                        $report = "You have Insufficient Balance Points!!!";
                        echo "<script> alert('".$report."'); window.location.href='teacher_thanQ_points.php'; </script>";

                    } else {
                        
                        $updatepoint = mysql_query("UPDATE tbl_teacher SET balance_blue_points = CASE WHEN balance_blue_points = 0 then '$point' WHEN balance_blue_points Is Null THEN '$point' ELSE balance_blue_points+$point END where school_id='$school_id' and (t_emp_type_pid=133 or `t_emp_type_pid`=134 or `t_emp_type_pid`=135 or `t_emp_type_pid`=137)");
                         
                         
                         //Below Select and Insert queries added by Pranali for bug SMC-3276
                         $sql = mysql_query("SELECT * FROM tbl_teacher where school_id='$school_id' and (t_emp_type_pid=133 or `t_emp_type_pid`=134)");
                         
                        while($row = mysql_fetch_array($sql))
                        {
                            $tID=$row['t_id'];
                            $sID=$_SESSION['id'];
                            
                            // Start SMC-3495 Modify By yogesh 2018-10-04 07:04 PM 
                            //$pointDate=date('d/m/Y');
                            $pointDate = CURRENT_TIMESTAMP; // define in core/securityfunctions.php
                            //end SMC-3495
                        
                         $insert=mysql_query("INSERT into tbl_teacher_point(sc_teacher_id,sc_entities_id,assigner_id,sc_point,point_date,reason,school_id,point_type) values ('$tID','102','$sID','$point','$pointDate',
                            'assigned by $dynamic_school_admin','$school_id','Blue Points')");
                        }
                            //changes end
                        $successreport .= "Successfully Assigned Point To All $dynamic_teacher";

                        $result = mysql_query("select balance_blue_points,assign_blue_points from tbl_school_admin where school_id='$school_id'");

                        $sql = mysql_fetch_array($result);


                        $school_balance_point = $sql['balance_blue_points'];

                        $school_balance_point = $sql['balance_blue_points'] - $points;

                        $school_assigned_point = $sql['assign_blue_points'] + $points;


                        mysql_query("update tbl_school_admin set balance_blue_points='$school_balance_point' where school_id='$school_id'");

                        mysql_query("update tbl_school_admin set assign_blue_points='$school_assigned_point' where school_id='$school_id'");

                        echo "<script> alert('".$successreport."'); window.location.href='teacher_thanQ_points.php'; </script>";
                    }

                }


                //header("location:teacherassign.php");

            } else {
                $report = "Enter valid points";
                echo "<script> alert('".$report."'); window.location.href='teacher_thanQ_points.php'; </script>";


            }

        }

        ?>

    </head>

    <script>

        function MyAlert(course) {

           // alert(course);
        
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

                    if(course=="Dept"){
                      document.getElementById('Department1').innerHTML = points;
                    }
                    else{
                      window.location.href="teacher_thanQ_points.php";
                    }

                }

            }

            xmlhttp.open("GET", "get_branch_for_asign_point.php?course=" + course, true);

            xmlhttp.send();

            
        }


        function showbranchwise(br) {

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


            xmlhttp.open("GET", "get_dept_wise_teacher.php?branch=" + br, true);

            xmlhttp.send();

        }


    </script>

    <script>

        $(function () {


            $("#teacher").change(function () {

                var bulk = document.getElementById('teacher').value;
                        
                // document.category.submit();

                // document.forms["category"].submit();
                    
                MyAlert(bulk);
                    

            })


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


       $sql = mysql_query("select balance_blue_points,assign_blue_points from tbl_school_admin where school_id='$school_id'");

       $arr = mysql_fetch_array($sql);

       $school_balance_point = $arr['balance_blue_points'];

       echo $school_balance_point;


       ?>

        </span></a>


                    <a href="#" class="list-group-item">Assigned Blue Points

                        <span class="badge">

        <?php

        // $sql1 = mysql_query("select school_assigned_point from  tbl_school_admin where school_id='$school_id'");

        // $arr1 = mysql_fetch_array($sql1);

        // $school_assigned_point = $arr1['school_assigned_point'];

        echo $arr['assign_blue_points'];


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
                                        style="width:152px;padding-left:10px;">
                                    
                                    <option value="teacher">All <?php echo $dynamic_teacher?></option>

                                    <option value="Dept"><?php echo "Department";?> Wise</option>

                                </select>
                            </div>
            </form>


            <div class="clearfix"></div>
            <div id="Department1">

            </div>

        </div>

        <div class="row form-inline" style="padding-top:20px;">

            <div style="float:left;width:150px;padding-left:10px;">Enter Points</div>&nbsp;&nbsp;

            <div style="float:left;"><input type="text" name="point" id="point" style="width:152px;"
                                            class="form-control"></div>
        </div>
        <div align="center" style="padding-top:10px; margin-left: 12px;"><input type="submit" class="btn btn-success btn-sm" name="Assign"
                                                             id="Assign" value="Assign"></div>

        <div style="color:#FF0000;" class="row1">

            <?php

            // echo $report;

            // echo $result1;

            ?>

        </div>
        <div style="color:#090;" class="row1">

            <?php
        //below if else conditions added by Pranali

            // if($_POST['Department'] == "select")
            // {
            //     $successreport="";
            // }
            // else
            // {
            //     $successreport;
            // }
            // echo $successreport;


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
                    <center>Assign Points to <?php echo $dpt ?> <?php echo $dynamic_branch; ?>  <?php echo $dynamic_teacher;?></center>
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

                            <th>Department</th>

                            <th>Assign</th>

                        </tr>
                        </thead>
                        <tbody>

                        <?php

                        $i = 1;

                        $arr = mysql_query("SELECT id,t_id, t_name,t_complete_name,t_middlename,t_lastname,t_dept, balance_blue_points,used_blue_points
                         FROM `tbl_teacher` 
                         WHERE school_id ='$school_id' AND t_dept='$dpt'  and (t_emp_type_pid=133 or `t_emp_type_pid`=134 or `t_emp_type_pid`=135 or `t_emp_type_pid`=137) 
                         order by t_complete_name,t_name desc "); ?>

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

                                        echo ucwords(strtolower($t_complete_name));

                                    }

                                    ?>

                                </td>

                                <td data-title="Blue Balance Points">

                                    <?php echo $row['balance_blue_points']; ?>

                                </td>


                                <td data-title="USed Blue Points">


                                    <?php echo $row['used_blue_points'];    ?>


                                </td>

                                <td data-title="Branch"> <?php echo $row['t_dept']; ?>  </td>

                                <td data-title="Assign">
                                    <center>
                                    
                                        <a href="admin_assign_thanQpoint.php?id=<?php echo $id; ?>">
                                            <input type="button" value="Assign" name="assign"/></a></center>
                                </td>


                            </tr>


                            <?php


                            $i++;

                        }

                        }
                        else{?>
                        
                        
<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>

    <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
    <script src="js/jquery.twbsPagination.js" type="text/javascript"></script>
    <script>
    $(document).ready(function() {
    $('#example').dataTable( {
    "paging":   false,
    "info":false,
    "searching": false,
     "scrollCollapse": true,
     "scrollX": true
    } );
} );
    </script>
    <?php

if (!($_GET['Search'])){

if (isset($_GET["page"])){ $page  = mysql_real_escape_string($_GET["page"]); } else { $page=1; };  
$start_from = ($page-1) * $webpagelimit;
    
$sql=mysql_query("SELECT id,t_id, t_name,t_complete_name,t_middlename,t_lastname, balance_blue_points,used_blue_points FROM  `tbl_teacher` WHERE school_id ='$school_id'  and (t_emp_type_pid=133 or `t_emp_type_pid`=134 or `t_emp_type_pid`=135 or `t_emp_type_pid`=137) order by id desc LIMIT $start_from, $webpagelimit"); 

$sql1 ="SELECT count(id) FROM  `tbl_teacher` WHERE school_id ='$school_id'  and (t_emp_type_pid=133 or `t_emp_type_pid`=134 or `t_emp_type_pid`=135 or `t_emp_type_pid`=137) order by id desc"; 
 
                    $rs_result = mysql_query($sql1);  
                    $row1 = mysql_fetch_row($rs_result);  
                    $total_records = $row1[0];  
                    $total_pages = ceil($total_records / $webpagelimit);
                    if($total_pages == $_GET['page']){
                    $webpagelimit = $total_records;
                    }else{
                    $webpagelimit = $start_from + $webpagelimit;
                    }
}else
{
    if (isset($_GET["spage"])){ $spage  = mysql_real_escape_string($_GET["spage"]); } else { $spage=1; };  
$start_from = ($spage-1) * $webpagelimit;

$searchq=mysql_real_escape_string($_GET['Search']);
//$colname=mysql_real_escape_string($_GET['colname']);
    if ($searchq != '')
    { 
        $query1=mysql_query("SELECT id,t_id, t_name,t_complete_name,t_middlename,t_lastname, balance_blue_points,used_blue_points FROM  `tbl_teacher` WHERE school_id ='$school_id'  and (t_emp_type_pid=133 or `t_emp_type_pid`=134 or `t_emp_type_pid`=135 or `t_emp_type_pid`=137)  and
 
 (t_complete_name LIKE '%$searchq%' or balance_blue_points LIKE '%$searchq%') 

  LIMIT $start_from, $webpagelimit") or die("could not Search!");
            
            $sql1 ="SELECT count(id) FROM  `tbl_teacher` WHERE school_id ='$school_id'  and (t_emp_type_pid=133 or `t_emp_type_pid`=134) and
 
 (t_complete_name LIKE '%$searchq%' or balance_blue_points LIKE '%$searchq%') order by id desc
"; 

            $rs_result = mysql_query($sql1);  
                    $row1 = mysql_fetch_row($rs_result);  
                    $total_records = $row1[0];  
                    $total_pages = ceil($total_records / $webpagelimit);

    }else{
    
   
$query1=mysql_query("SELECT id,t_id, t_name,t_complete_name,t_middlename,t_lastname, balance_blue_points, used_blue_points FROM  `tbl_teacher` WHERE school_id ='$school_id'  and (t_emp_type_pid=133 or `t_emp_type_pid`=134 or `t_emp_type_pid`=135 or `t_emp_type_pid`=137) 
 and  $colname LIKE '%$searchq%' order by id desc

LIMIT $start_from, $webpagelimit")
 
        or die("could not Search!");
                    //echo $query1;
        $sql1 ="SELECT count(id) FROM  `tbl_teacher` WHERE school_id ='$school_id'  and (t_emp_type_pid=133 or `t_emp_type_pid`=134 or `t_emp_type_pid`=135 or `t_emp_type_pid`=137) 
 and  $colname LIKE '%$searchq%' order by id desc"; 
                    $rs_result = mysql_query($sql1);  
                    $row1 = mysql_fetch_row($rs_result);  
                    $total_records = $row1[0];  
                    $total_pages = ceil($total_records / $webpagelimit);
            
            
            
        }
            
        //below query use for search count
         
                    

                    if($total_pages == $_GET['spage']){
                    $webpagelimit = $total_records;
                    }else{
                    $webpagelimit = $start_from + $webpagelimit;
                    }
                     
}
?>



<?php if (!($_GET['Search'])){?>
<script type="text/javascript">
    $(function () {
        var total_pages = <?php echo $total_pages; ?> ;
        var start_page = <?php echo $page; ?> ;
        window.pagObj = $('#pagination').twbsPagination({
            totalPages: total_pages,
            visiblePages: 10,
            startPage: start_page,
            onPageClick: function (event, page) {
                console.info(page + ' (from options)'); 
            }
        }).on('page', function (event, page) {
            console.info(page + '(from event listening)');
            window.location.assign('teacher_thanQ_points.php?page='+page);
        });
    });
</script>
<?php }else{
    ?>
<script type="text/javascript">
    $(function () {
        var total_pages = <?php echo $total_pages; ?> ;
        var start_page = <?php echo $spage; ?> ;
        window.pagObj = $('#pagination').twbsPagination({
            totalPages: total_pages,
            visiblePages: 10,
            startPage: start_page,
            onPageClick: function (event, page) {
                console.info(page + ' (from options)'); 
            }
        }).on('page', function (event, page) {
            console.info(page + '(from event listening)');
            window.location.assign('teacher_thanQ_points.php?Search=<?php echo $searchq; ?>&spage='+page);
        });
    });
</script>
<?php }?>
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

<body bgcolor="#CCCCCC">
<div align="center">
    <div class="container" style="width:100%;">
        <div style="padding-top:30px;">

            <h2 style="padding-left:20px; margin-top:2px;color:#666"> Assign Blue Points To <?php echo $dynamic_teacher;?></h2>

        </div>
        
        <div class='row'>
        <form style="margin-top:5px;">
             <div class="col-md-4" style="width:35%;">
             </div>
          
            <div class="col-md-2" style="width:17%;">
                <input type="text" class="form-control" name="Search" value="<?php echo $searchq; ?>" placeholder="Search.." required> 
            </div>
            <div class="col-md-1" >
            <button type="submit" value="Search" class="btn btn-primary">Search</button>
            </div>
            <div class="col-md-3" >
            <input type="button" class="btn btn-info" value="Reset" onclick="window.open('teacher_thanQ_points.php','_self')" />
            </div>
                    
        
                    <!-- <div style="margin-left: 800px;">
                        <input type="text" name="Search" value="" placeholder="Search..">
                        <input type="submit" value="Search">
                        <input type="button" value="Reset" onclick="window.open('beneficiary_list.php','_self')" />
                    </div> -->
                    
                    
                    
                    
        </form>
         </div> 
         <!-- <div id="show" >
                <?php if (!($_GET['Search']))
                    {
                        if ($webpagelimit >$total_records){ $webpagelimit=$total_records;}
                        echo "<div style='margin-top:5px;'><font color='blue'><b style='margin-left:600px;'>Now showing ".($start_from +1)." to ".($webpagelimit)." records out of ".$total_records. " records.</b></font></div>";
            }else
                    {
                        if ($webpagelimit >$total_records){ $webpagelimit=$total_records;}
                        echo "<div style='margin-top:5px;'><font color='blue'><b style='margin-left:600px;'>Now showing ".($start_from +1)." to ".($webpagelimit)." records out of ".($total_records). " records.</b></font></div>";
                    }
                    ?>
         </div> -->
        <?php
        if (isset($_GET['Search']))
        {
            
            $count=mysql_num_rows($query1);
            if($count == 0){
                
                echo "<script>$('#show').css('display','none');</script><div style='margin-top:20px;'><font color='Red'><b>There Was No Search Result</b></font></div>";    
            }
            else
            {
            ?>
            <div id="no-more-tables" style="padding-top:20px;">

            <table id="example" class="col-md-12 table-bordered " align="center">
                <thead>
                <!-- <tr><?php echo $sql1; ?></tr> -->
                <tr style="background-color:#0073BD; color:#FFFFFF; height:30px;">
                    
                  <th>Sr.No.</th>
                 
                    <th><?php echo $dynamic_teacher;?> Name</th>
                     <th> Balance Blue Points</th>
                    
                      <th> Used Blue Points </th>
                       
                        <th> Assign </th>
                     
                  
                    
                    
                </tr>
                </thead>

                <?php $i = 1;
                    $i = ($start_from +1);
                while($result = mysql_fetch_array($query1)) {
                    $teacher_id = $result['t_id'];
                    $id = $result['id'];
                    ?>
                    <tr>
                        <td data-title="Sr.No."><?php echo $i; ?></td>
                        
                       
                       
                        <td data-title="<?php echo $dynamic_teacher;?> Name"><?php echo $result['t_complete_name']; ?></td>
                        <td data-title="Balance Blue Points"><?php echo $result['balance_blue_points']; ?></td>
                        <td data-title="Used Blue Points"> <?php  echo $result['used_blue_points'];   ?> </td>
                       
                        <td data-title="Assign">
                                            <center>             
                                                <a href="admin_assign_thanQpoint.php?id=<?php echo $id; ?>">
                                                    <input type="button" value="Assign" name="assign"/></a></center>
                                        </td>
                       </tr></a>    
                    <?php $i++;
                } ?>
            </table>
        </div>
        <div align=left>
                <?php if (!($_GET['Search']))
                    {
                        if ($webpagelimit >$total_records){ $webpagelimit=$total_records;}
                        echo "<div style='margin-top:5px;'><font color='#0073BD'><style='margin-left:600px;'>Now showing ".($start_from +1)." to ".($webpagelimit)." records out of ".$total_records. " records.</font></style></div>";
            }else
                    {
                        if ($webpagelimit >$total_records){ $webpagelimit=$total_records;}
                        echo "<div style='margin-top:5px;'><font color='#0073BD'><style='margin-left:600px;'>Now showing ".($start_from +1)." to ".($webpagelimit)." records out of ".($total_records). " records.</font></style></div>";
                    }
                    ?>
         </div>
            <div class="container">
            <nav aria-label="Page navigation">
              <ul class="pagination" id="pagination"></ul>
            </nav>
        </div>
            <?php
            }

        }
        else
            {
            ?>
            <div id="no-more-tables" style="padding-top:20px;">

            <table id="example" class="col-md-12 table-bordered " align="center">
                <thead>
               
                <tr style="background-color:#0073BD; color:#FFFFFF; height:30px;">
                     <th>Sr.No.</th>
                 
                    <th><?php echo $dynamic_teacher;?> Name</th>
                     <th> Balance Blue Points</th>
                    
                      <th> Used Blue Points </th>
                       
                        <th> Assign </th>
                     
                    
                   
                </tr>
                </thead>

                <?php $i = 1;
                    $i = ($start_from +1);
                while($result = mysql_fetch_array($sql)) {
                    $teacher_id = $result['t_id'];
                    $id = $result['id'];
                    ?>
                    <tr>
                        <td data-title="Sr.No."><?php echo $i; ?></td>
                        
                       
                       
                        <td data-title="<?php echo $dynamic_teacher;?> Name"><?php echo $result['t_complete_name']; ?></td>
                        <td data-title="Balance Green Points"><?php echo $result['balance_blue_points']; ?></td>
                        
                        <td data-title="Used Green Points"> <?php echo $result['used_blue_points'];  ?> </td>
                       
                        <td data-title="Assign">
                                            <center>                                    
                                            
                                                <a href="admin_assign_thanQpoint.php?id=<?php echo $id; ?>">
                                                    <input type="button" value="Assign" name="assign"/></a></center>
                                        </td>
                       </tr></a>    
                    <?php $i++;
                } ?>
            </table>
        </div>
<div align=left>
                <?php if (!($_GET['Search']))
                    {
                        if ($webpagelimit >$total_records){ $webpagelimit=$total_records;}
                        echo "<div style='margin-top:5px;'><font color='#0073BD'><style='margin-left:600px;'>Now showing ".($start_from +1)." to ".($webpagelimit)." records out of ".$total_records. " records.</font></style></div>";
            }else
                    {
                        if ($webpagelimit >$total_records){ $webpagelimit=$total_records;}
                        echo "<div style='margin-top:5px;'><font color='#0073BD'><style='margin-left:600px;'>Now showing ".($start_from +1)." to ".($webpagelimit)." records out of ".($total_records). " records.</font></style></div>";
                    }
                    ?>
         </div>
        <div class="container">
            <nav aria-label="Page navigation">
              <ul class="pagination" id="pagination"></ul>
            </nav>
        </div>



<?php 
} } 
?>

</body>

</html>




                        