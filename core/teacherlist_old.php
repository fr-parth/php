<?php

include_once('scadmin_header.php');

$report = "";

$results = $smartcookie->retrive_individual($table, $fields);

$result = mysql_fetch_array($results);

//changes done for bug SMC-3449 by Pranali on 17-10-2018
$sc_id = $_SESSION['school_id'];

//Pagination & search functionality done by Pranali for bug SMC-3259 on 14-11-2018
$where="";
/*if (isset($_GET['t_id']))
{*/
    
    //As per discussion with Santosh Sir Updated below query for adding 135 & 137 - Rutuja Jori on 04/09/2019

    $where.=" and (`t_emp_type_pid`='133' or `t_emp_type_pid`='134' or `t_emp_type_pid`='135' or `t_emp_type_pid`='137')";


/*else
{

    $where.=" and (`t_emp_type_pid`='139' or `t_emp_type_pid`='141' or `t_emp_type_pid`='143')";
}*/


if (!($_GET['Search'])){

    // if (isset($_GET["page"])){ $page  = mysql_real_escape_string($_GET["page"]); } else { $page=1; };  
    // $start_from = ($page-1) * $webpagelimit;
        
    // $sql=mysql_query("select t_emp_type_pid,id,t_designation, t_id, t_complete_name, t_name, t_middlename, t_lastname, t_email,t_phone, t_dept,t_pc,school_id from tbl_teacher where school_id='$sc_id' $where  order by t_complete_name ASC LIMIT $start_from, $webpagelimit") or die("Could not Search!"); 
    $sql=mysql_query("select t_emp_type_pid,id,t_designation, t_id, t_complete_name, t_name, t_middlename, t_lastname, t_email,t_phone, t_dept,t_pc,school_id from tbl_teacher where school_id='$sc_id' $where  order by t_complete_name ASC") or die("Could not Search!"); 

    // $sql1 =mysql_query("select t_emp_type_pid,id, t_id,t_designation, t_complete_name, t_name, t_middlename, t_lastname, t_email,t_phone, t_dept,t_pc,school_id from tbl_teacher where school_id='$sc_id' $where order by t_complete_name ASC");
      
                        
    //                  $total_records = mysql_num_rows($sql1);
    //                  $total_pages = ceil($total_records / $webpagelimit);
                        
    //                  if($total_pages == $_GET['page']){
    //                      $webpagelimit = $total_records;
    //                  }
    //                  else{
    //                      $webpagelimit = $start_from + $webpagelimit;
    //                  }
}
else
{
    //  if (isset($_GET["spage"])){ 
    //      $spage  = mysql_real_escape_string($_GET["spage"]);
    //  } 
    //  else{
    //      $spage=1; 
    //  };  
    // $start_from = ($spage-1) * $webpagelimit;

    $searchq=mysql_real_escape_string(trim($_GET['Search']));
    $colname=mysql_real_escape_string($_GET['colname']);
        if ($colname != '' and $colname != 'Select')
        {           
            // $sql=mysql_query("select t_emp_type_pid,id,t_id,t_designation, t_complete_name, t_name, t_middlename, t_lastname, t_email,t_phone, t_dept,t_pc,school_id from tbl_teacher where  school_id='$sc_id' $where AND $colname LIKE '%$searchq%' order by t_complete_name ASC LIMIT $start_from, $webpagelimit") or die("Could not Search!");
            $sql=mysql_query("select t_emp_type_pid,id,t_id,t_designation, t_complete_name, t_name, t_middlename, t_lastname, t_email,t_phone, t_dept,t_pc,school_id from tbl_teacher where  school_id='$sc_id' $where AND $colname LIKE '%$searchq%' order by t_complete_name ASC") or die("Could not Search!");
                    
            $sql1 =mysql_query("select t_emp_type_pid,id,t_id,t_designation, t_complete_name, t_name, t_middlename, t_lastname, t_email,t_phone, t_dept,t_pc,school_id from tbl_teacher where  school_id='$sc_id' $where AND $colname LIKE '%$searchq%' order by t_complete_name ASC"); 
                
                            $total_records = mysql_num_rows($sql1); 
                            $total_pages = ceil($total_records / $webpagelimit);

        }else{
            
            // $sql = mysql_query("select t_emp_type_pid,id,t_id,t_designation, t_complete_name, t_name, t_middlename, t_lastname, t_email,t_phone, t_dept,t_pc,school_id from tbl_teacher where school_id='$sc_id' $where AND (t_id LIKE '%$searchq%' or t_designation LIKE '%$searchq%' or t_complete_name LIKE '%$searchq%' or t_name LIKE '%$searchq%' or t_middlename LIKE '%$searchq%' or t_lastname LIKE '%$searchq%' or t_email LIKE '%$searchq%' or t_phone LIKE '%$searchq%' or t_dept LIKE '%$searchq%' ) order by t_complete_name ASC LIMIT $start_from, $webpagelimit") or die("Could not Search!");
                            
            $sql = mysql_query("select t_emp_type_pid,id,t_id,t_designation, t_complete_name, t_name, t_middlename, t_lastname, t_email,t_phone, t_dept,t_pc,school_id from tbl_teacher where school_id='$sc_id' $where AND (t_id LIKE '%$searchq%' or t_designation LIKE '%$searchq%' or t_complete_name LIKE '%$searchq%' or t_name LIKE '%$searchq%' or t_middlename LIKE '%$searchq%' or t_lastname LIKE '%$searchq%' or t_email LIKE '%$searchq%' or t_phone LIKE '%$searchq%' or t_dept LIKE '%$searchq%' ) order by t_complete_name ASC") or die("Could not Search!");
        
            // $sql1 = mysql_query("select t_emp_type_pid,id,t_id,t_designation, t_complete_name, t_name, t_middlename, t_lastname, t_email,t_phone, t_dept,t_pc,school_id from tbl_teacher where school_id='$sc_id' $where AND (t_id LIKE '%$searchq%' or t_designation LIKE '%$searchq%' or
            // t_complete_name LIKE '%$searchq%' or t_name LIKE '%$searchq%' or t_middlename LIKE '%$searchq%' or t_lastname LIKE '%$searchq%' or t_email LIKE '%$searchq%' or t_phone LIKE '%$searchq%' or t_dept LIKE '%$searchq%' ) order by t_complete_name ASC"); 
                             
          
            //              $total_records = mysql_num_rows($sql1);  
            //              $total_pages = ceil($total_records / $webpagelimit);
        }
                
            //below query use for search count
             
                        // if($total_pages == $_GET['spage']){
                        //  $webpagelimit = $total_records;
                        // }
                        // else{
                        //  $webpagelimit = $start_from + $webpagelimit;
                        // }
                     
}



?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta charset="utf-8">
<title>Smart Cookies</title>
<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
    <script src="code.jquery.com/jquery-1.10.2.js"></script>
    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>

    <script src="code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
    <script src="js/jquery.twbsPagination.js" type="text/javascript"></script>
    <script>
    $(document).ready(function() {
    $('#example').dataTable( {
    // "paging":   false,
    // "info":false,
    // "searching": true,
 //     "scrollCollapse": true
        
    } );
} );
    </script>
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
            window.location.assign('teacherlist.php?t_id=<?php echo $dynamic_teacher;?>');
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
            window.location.assign('teacherlist.php?colname=<?php echo $colname;?>&Search=<?php echo $searchq; ?>');
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
 
    #no-more-tables tr { border: 1px solid #ccc; }
 
    #no-more-tables td { 
        /* Behave  like a "row" */
        border: none;
        border-bottom: 1px solid #eee; 
        position: relative;
        padding-left: 50%; 
        white-space: normal;
        text-align:left;
        font:Arial, Helvetica, sans-serif;
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
    #no-more-tables td:before { content: attr(data-title); }
}
</style>
</head>

<script>

function confirmation(xxx) {


var answer = confirm("Are you sure you want to delete?")

if (answer)
    {
    //alert('DELETE FROM tbl_teacher where id='+xxx);
    alert('record deleted successfully');
    window.location.assign("delete_teacher.php?id=" + xxx);
    // window.location.assign = ;
    }

else {


    }

}


</script>


<style>

.preview 
{

    border-radius: 50% 50% 50% 50%;

    box-shadow: 0 3px 2px rgba(0, 0, 0, 0.3);

    -webkit-border-radius: 99em;

    -moz-border-radius: 99em;

    border-radius: 99em;

    border: 5px solid #eee;

    width: 100px;

}

</style>


<body bgcolor="#CCCCCC">

    <div style="bgcolor:#CCCCCC">
        <div class="container" style="padding:1px;">
            <div style="border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">
                <div style="background-color:#F8F8F8 ;">
                    <div class="row">
                        <div class="col-md-3" style="color:#700000 ;padding:5px;">&nbsp;&nbsp;&nbsp;&nbsp;

                            <a href="teacher_setup.php"><input type="submit" class="btn btn-primary" name="submit"
                                           value="Add <?php echo $dynamic_teacher; ?>"
                                           style="width:150;font-weight:bold;font-size:14px;"/></a>
                        </div>
                            <div class="col-md-6 " align="center">
                                <h2>List of <?php echo $dynamic_teacher; ?> </h2>
                            </div>
                            <div class="row" align="center" style="margin-top:3%;">
                            <form method="post">
                                    <div class="col-md-4" style="margin-left:79px;"><label>Search by Year:</label></div>
                                        <div class="col-md-2">
                                        
                                            <select name="info" class="form-control" style="margin-left:-160px;"> 
                                            
                                            <?php $select_option_value= $_POST['info'] ?>
                                            
                                            <option value="Current" <?php if($select_option_value == "Current") echo 'selected="selected"'; ?>>Current year</option>
                                            
                                            <option value="All" <?php if($select_option_value == "All") echo 'selected="selected"'; ?>>All years</option>
                                            
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="submit" name="submit" value="Submit" class="btn btn-success" style="margin-left:68px;">
                                        </div>
                            </form>
                            </div>
                            <div class="row" style="padding:10px;" >

        <form style="margin-top:5px;">
             <div class="col-md-4" style="width:17%;">
             </div>
            
            
    
            
                    <!-- <div style="margin-left: 800px;">
                        <input type="text" name="Search" value="<?php echo $searchq; ?>" placeholder="Search..">
                        <input type="submit" value="Search">
                        <input type="button" value="Reset" onclick="window.open('beneficiary_list.php','_self')" />
                    </div> -->
        </form>
         </div> 


                   </div>
                    <div class="row" style="padding:0px;">
                    <div class="col-md-2">
                    </div>
               
                       <?php
                if (isset($_GET['Search']))
                {
                    
                    $count=mysql_num_rows($sql);
                    if($count == 0)
                    {
                        
                        echo "<script>$('#show').css('display','none');</script><div style='margin-top:20px;' align='center'><font color='Red'><b>There Was No Search Result</b></font></div>"; 
                    }
                    else
                    {
                    ?>
                            <div class="col-md-12" id="no-more-tables">

                                <?php $i = 0; ?>


                                    <table class="table-bordered  table-condensed cf" id="example" width="100%;">
                                    <thead>

                                    <tr style="background-color:#555;color:#FFFFFF;height:30px;"><!-- Camel casing done for Sr. No. by Pranali -->
                                    <th>Sr. No.</th>
                                    <th>Profile Picture</th>
                                    <th><?php echo $dynamic_teacher; ?> ID</th>
                                    <th><?php echo $dynamic_teacher; ?> Name</th>
                                    <th>Email ID/Phone No.</th>

                                    <th>Department</th>
                                    <th>Designation</th>
                                    <th>No. of <?php echo $dynamic_subject; ?></th>
                                    <th>No. of <?php echo $dynamic_student; ?></th>
                                    <th>Management Level</th>
                                    
                                    <th>Edit</th>
                                    <th>Delete</th>
                                    </tr>

                                    </thead>
                                    <tbody>
                                    <?php
                                    
                    $i = 1;
                    $i = ($start_from +1);?>

<?php

//$arr = mysql_query("select * from tbl_teacher where (`t_emp_type_pid`='133' or `t_emp_type_pid`='134') and school_id='$sc_id' order by t_complete_name ASC");

//$count = mysql_num_rows($arr);

//$i=1;
while ($row = mysql_fetch_array($sql)) {

        $teacher_id = $row['id'];

        $t_id = $row['t_id'];

        $fullname = ucwords(strtolower($row['t_complete_name']));

?>

<tr
onmouseover="this.style.cursor='pointer';this.style.textDecoration='underline';this.style.color='dodgerblue'"
onmouseout="this.style.textDecoration='none';this.style.color='black';"
style="cursor: pointer; text-decoration: underline; color: dodgerblue; background-color: rgb(239, 243, 251);height:30px;color:#808080;"
>


<td><?php echo $i; ?></td>
<td>
<object data="<?php echo $row['t_pc']; ?>" style="width:70px;height:70px;">
<img src="http://smartcookie.in/core/Images/avatar_2x.png" style="width:70px;height:70px;"/>
</object>

</td>
<td>
<!--  <a href="display_teach_subject.php?t_i

d=<?php //echo $row['t_id']; ?>&school_id=<?php// echo $row['school_id']; ?>">   -->
<?php echo $row['t_id']; ?>
</td>


<td>
<!--                                        <a href="scadmin_teacher_edit.php?t_id=-->
<?php //echo $row['t_id']; ?><!--">--><?php //$teacher_name = ucwords(strtolower($row['t_name'] . " " . $row['t_middlename'] . " " . $row['t_lastname'])); ?>
<a href="teacher_setup.php?t_id=<?php echo $row['t_id']; ?>">
<?php $teacher_name = ucwords(strtolower($row['t_name'] . " " . $row['t_middlename'] . " " . $row['t_lastname'])); ?>

<?php if ($fullname == "") {

    echo $teacher_name;

} else {

    echo $fullname;

}


?></a></td>



<td><?php echo $row['t_email'];echo "</br>";echo $row['t_phone']; ?> </td>





<td><?php echo $row['t_dept']; ?> </td>
<td><?php echo $row['t_designation']; ?> </td>


<?php

$sql_subject = mysql_query("SELECT DISTINCT  st.Branches_id,st.`subjectName`,st.ExtSemesterId,st.subjcet_code,st.Division_id,st.Semester_id,st.Department_id,st.CourseLevel,st.AcademicYear FROM `tbl_teacher_subject_master` st inner join tbl_academic_Year Y on st.AcademicYear=Y.Year    WHERE st.`teacher_id` ='$t_id' and st.school_id='$sc_id' and Y.Enable='1' and Y.school_id='$sc_id'");


if(isset($_POST['submit']))
{
    
    echo "SELECT DISTINCT  st.Branches_id,st.`subjectName`,st.ExtSemesterId,st.subjcet_code,st.Division_id,st.Semester_id,st.Department_id,st.CourseLevel,st.AcademicYear FROM `tbl_teacher_subject_master` st inner join tbl_academic_Year Y on st.AcademicYear=Y.Year    WHERE st.`teacher_id` ='$t_id' and st.school_id='$sc_id' and Y.Enable='1' and Y.school_id='$sc_id'";exit;
    
    if ($_POST['info'] == 'Current') {
        
        
    $sql_subject = mysql_query("SELECT DISTINCT  st.Branches_id,st.`subjectName`,st.ExtSemesterId,st.subjcet_code,st.Division_id,st.Semester_id,st.Department_id,st.CourseLevel,st.AcademicYear FROM `tbl_teacher_subject_master` st inner join tbl_academic_Year Y on st.AcademicYear=Y.Year    WHERE st.`teacher_id` ='$t_id' and st.school_id='$sc_id' and Y.Enable='1' and Y.school_id='$sc_id'");
    }
     elseif ($_POST['info'] == 'All') {
    $sql_subject = mysql_query("SELECT DISTINCT  st.Branches_id,st.`subjectName`,st.ExtSemesterId,st.subjcet_code,st.Division_id,st.Semester_id,st.Department_id,st.CourseLevel,st.AcademicYear FROM `tbl_teacher_subject_master` st inner join tbl_academic_Year Y on st.AcademicYear=Y.Year    WHERE st.`teacher_id` ='$t_id' and st.school_id='$sc_id'  and Y.school_id='$sc_id'");
    } else{
     $sql_subject = mysql_query("SELECT DISTINCT  st.Branches_id,st.`subjectName`,st.ExtSemesterId,st.subjcet_code,st.Division_id,st.Semester_id,st.Department_id,st.CourseLevel,st.AcademicYear FROM `tbl_teacher_subject_master` st inner join tbl_academic_Year Y on st.AcademicYear=Y.Year    WHERE st.`teacher_id` ='$t_id' and st.school_id='$sc_id' and Y.Enable='1' and Y.school_id='$sc_id'");
    }
}

$result = mysql_num_rows($sql_subject);
if(isset($_POST['info']))
{
 $selection_value=  $_POST['info'];
}
else {
 $selection_value= "Current";
}
?>

<td>
<?php 

$fullname = ucwords(strtolower($row['t_complete_name']));
if ($fullname == "") 
{

    $t_name =  ucwords(strtolower($row['t_name'] . " " . $row['t_middlename'] . " " . $row['t_lastname']));

}
else 
{

    $t_name = $fullname;

}


?>
<a href="display_teach_subject.php?t_id=<?php echo $row['t_id']; ?>&school_id=<?php echo $row['school_id']; ?>&selection=<?php echo $selection_value; ?>&t_name=<?php echo $t_name; ?>"> <?php echo $result; ?></a>
</td>




<?php
$sql_student = mysql_query("SELECT  st.subjectName,st.student_id,st.CourseLevel,st.AcademicYear 
FROM tbl_student_subject_master st
join tbl_student s on s.std_PRN=st.student_id AND s.school_id = st.school_id
join tbl_academic_Year as y on st.AcademicYear=y.Academic_Year and y.school_id='$sc_id' 
where st.teacher_ID='$t_id'and st.school_id='$sc_id' and y.Enable=1 ");


if(isset($_POST['submit'])) {
if ($_POST['info'] == 'Current')
    {
$sql_student = mysql_query("SELECT  st.subjectName,st.student_id,st.CourseLevel,st.AcademicYear 
FROM tbl_student_subject_master st
join tbl_student s on s.std_PRN=st.student_id AND s.school_id = st.school_id
join tbl_academic_Year as y on st.AcademicYear=y.Academic_Year and y.school_id='$sc_id' 
where st.teacher_ID='$t_id'and st.school_id='$sc_id' and y.Enable=1");
}
 elseif ($_POST['info'] == 'All') {
$sql_student = mysql_query("SELECT  st.subjectName,st.student_id,st.CourseLevel,st.AcademicYear 
FROM tbl_student_subject_master st
join tbl_student s on s.std_PRN=st.student_id AND s.school_id = st.school_id
join tbl_academic_Year as y on st.AcademicYear=y.Academic_Year and y.school_id='$sc_id' 
where st.teacher_ID='$t_id'and st.school_id='$sc_id'");
} 
else {
 $sql_student = mysql_query("SELECT  st.subjectName,st.student_id,st.CourseLevel,st.AcademicYear 
FROM tbl_student_subject_master st
join tbl_student s on s.std_PRN=st.student_id AND s.school_id = st.school_id
join tbl_academic_Year as y on st.AcademicYear=y.Academic_Year and y.school_id='$sc_id' 
where st.teacher_ID='$t_id'and st.school_id='$sc_id' and y.Enable=1");
}
}

$result_student = mysql_num_rows($sql_student);

?>

<td><?php echo $result_student;?></td>

<td><?php 

$t_emp_type_pid=$row['t_emp_type_pid'];
if($t_emp_type_pid=='133' || $t_emp_type_pid=='134')
{
    echo $dynamic_teacher;
}
if($t_emp_type_pid=='135')
{
    echo $dynamic_hod;
}
if($t_emp_type_pid=='137')
{
    echo $dynamic_principal;
}

 ?> </td>
<td><a href="teacher_setup.php?t_id=<?php echo $row['t_id']; ?>">
<center><img src="Images/edit.png" height="20px" width="20px">
</a></center></td>

<td>
<center><img src="Images/cancel.png" style=" width:25px;height:25px;"
         alt="Cancel" id="<?php echo $row['id']; ?>"
         onclick="return confirmation(this.id)"></center>
</td>
<!-- changes end for bug SMC-3449-->

</tr>

<?php

$i++;

 } ?>


                                    </tbody>

                                    </table>


                                </div>
                                <div class="container" align="center">
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
                <div class="col-md-12" id="no-more-tables">

                                <?php $i = 0; ?>


                                    <table class="table-bordered  table-condensed cf" id="example" width="100%;">
                                    <thead>

                                    <tr style="background-color:#555;color:#FFFFFF;height:30px;"><!-- Camel casing done for Sr. No. by Pranali -->
                                    <th>Sr. No.</th>
                                    <th>Profile Picture</th>
                                    <th><?php echo $dynamic_teacher; ?> ID</th>
                                    <th><?php echo $dynamic_teacher; ?> Name</th>
                                    <th>Email ID/Phone No.</th>

                                    <th>Department</th>
                                    <th>Designation</th>
                                    <th>No. of <?php echo $dynamic_subject; ?></th>
                                    <th>No. of <?php echo $dynamic_student; ?></th>
                                    
                                    <th>Management Level</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                    </tr>

                                    </thead>
                                    <tbody>
                                    <?php
                                    
                    $i = 1;
                    $i = ($start_from +1);?>

<?php

//$arr = mysql_query("select * from tbl_teacher where (`t_emp_type_pid`='133' or `t_emp_type_pid`='134') and school_id='$sc_id' order by t_complete_name ASC");

//$count = mysql_num_rows($arr);

//$i=1;
while ($row = mysql_fetch_array($sql)) {

        $teacher_id = $row['id'];

        $t_id = $row['t_id'];

        $fullname = ucwords(strtolower($row['t_complete_name']));

?>

<tr
onmouseover="this.style.cursor='pointer';this.style.textDecoration='underline';this.style.color='dodgerblue'"
onmouseout="this.style.textDecoration='none';this.style.color='black';"
style="cursor: pointer; text-decoration: underline; color: dodgerblue; background-color: rgb(239, 243, 251);height:30px;color:#808080;"
>


<td><?php echo $i; ?></td>
<td>
<object data="<?php echo $row['t_pc']; ?>" style="width:70px;height:70px;">
<img src="http://smartcookie.in/core/Images/avatar_2x.png" style="width:70px;height:70px;"/>
</object>

</td>
<td>
<!--  <a href="display_teach_subject.php?t_i

d=<?php //echo $row['t_id']; ?>&school_id=<?php// echo $row['school_id']; ?>">   -->
<?php echo $row['t_id']; ?>
</td>


<td>
<!--                                        <a href="scadmin_teacher_edit.php?t_id=-->
<?php //echo $row['t_id']; ?><!--">--><?php //$teacher_name = ucwords(strtolower($row['t_name'] . " " . $row['t_middlename'] . " " . $row['t_lastname'])); ?>
<a href="teacher_setup.php?t_id=<?php echo $row['t_id']; ?>">
<?php $teacher_name = ucwords(strtolower($row['t_name'] . " " . $row['t_middlename'] . " " . $row['t_lastname'])); ?>

<?php if ($fullname == "") {

    echo $teacher_name;

} else {

    echo $fullname;

}


?></a></td>



<td><?php echo $row['t_email'];echo "</br>";echo $row['t_phone']; ?> </td>





<td><?php echo $row['t_dept']; ?> </td>
<td><?php echo $row['t_designation']; ?> </td>


<?php

$sql_subject = mysql_query("SELECT DISTINCT  st.Branches_id,st.`subjectName`,st.ExtSemesterId,st.subjcet_code,st.Division_id,st.Semester_id,st.Department_id,st.CourseLevel,st.AcademicYear FROM `tbl_teacher_subject_master` st inner join tbl_academic_Year Y on st.AcademicYear=Y.Year    WHERE st.`teacher_id` ='$t_id' and st.school_id='$sc_id' and Y.Enable='1' and Y.school_id='$sc_id'");


if(isset($_POST['submit']))
{
    if ($_POST['info'] == 'Current') {
    $sql_subject = mysql_query("SELECT DISTINCT  st.Branches_id,st.`subjectName`,st.ExtSemesterId,st.subjcet_code,st.Division_id,st.Semester_id,st.Department_id,st.CourseLevel,st.AcademicYear FROM `tbl_teacher_subject_master` st inner join tbl_academic_Year Y on st.AcademicYear=Y.Year    WHERE st.`teacher_id` ='$t_id' and st.school_id='$sc_id' and Y.Enable='1' and Y.school_id='$sc_id'");
    }
     elseif ($_POST['info'] == 'All') {
    $sql_subject = mysql_query("SELECT DISTINCT  st.Branches_id,st.`subjectName`,st.ExtSemesterId,st.subjcet_code,st.Division_id,st.Semester_id,st.Department_id,st.CourseLevel,st.AcademicYear FROM `tbl_teacher_subject_master` st inner join tbl_academic_Year Y on st.AcademicYear=Y.Year    WHERE st.`teacher_id` ='$t_id' and st.school_id='$sc_id'  and Y.school_id='$sc_id'");
    } else{
     $sql_subject = mysql_query("SELECT DISTINCT  st.Branches_id,st.`subjectName`,st.ExtSemesterId,st.subjcet_code,st.Division_id,st.Semester_id,st.Department_id,st.CourseLevel,st.AcademicYear FROM `tbl_teacher_subject_master` st inner join tbl_academic_Year Y on st.AcademicYear=Y.Year    WHERE st.`teacher_id` ='$t_id' and st.school_id='$sc_id' and Y.Enable='1' and Y.school_id='$sc_id'");
    }
}

$result = mysql_num_rows($sql_subject);
if(isset($_POST['info']))
{
 $selection_value=  $_POST['info'];
}
else {
 $selection_value= "Current";
}
?>

<td>
<?php 

$fullname = ucwords(strtolower($row['t_complete_name']));
if ($fullname == "") 
{

    $t_name =  ucwords(strtolower($row['t_name'] . " " . $row['t_middlename'] . " " . $row['t_lastname']));

}
else 
{

    $t_name = $fullname;

}


?>
<a href="display_teach_subject.php?t_id=<?php echo $row['t_id']; ?>&school_id=<?php echo $row['school_id']; ?>&selection=<?php echo $selection_value; ?>&t_name=<?php echo $t_name; ?>"> <?php echo $result; ?></a>
</td>




<?php
$sql_student = mysql_query("SELECT  st.subjectName,st.student_id,st.CourseLevel,st.AcademicYear 
FROM tbl_student_subject_master st
join tbl_student s on s.std_PRN=st.student_id AND s.school_id = st.school_id
join tbl_academic_Year as y on st.AcademicYear=y.Academic_Year and y.school_id='$sc_id' 
where st.teacher_ID='$t_id'and st.school_id='$sc_id' and y.Enable=1 ");


if(isset($_POST['submit'])) {
if ($_POST['info'] == 'Current')
    {
$sql_student = mysql_query("SELECT  st.subjectName,st.student_id,st.CourseLevel,st.AcademicYear 
FROM tbl_student_subject_master st
join tbl_student s on s.std_PRN=st.student_id AND s.school_id = st.school_id
join tbl_academic_Year as y on st.AcademicYear=y.Academic_Year and y.school_id='$sc_id' 
where st.teacher_ID='$t_id'and st.school_id='$sc_id' and y.Enable=1");
}
 elseif ($_POST['info'] == 'All') {
$sql_student = mysql_query("SELECT  st.subjectName,st.student_id,st.CourseLevel,st.AcademicYear 
FROM tbl_student_subject_master st
join tbl_student s on s.std_PRN=st.student_id AND s.school_id = st.school_id
join tbl_academic_Year as y on st.AcademicYear=y.Academic_Year and y.school_id='$sc_id' 
where st.teacher_ID='$t_id'and st.school_id='$sc_id'");
} 
else {
 $sql_student = mysql_query("SELECT  st.subjectName,st.student_id,st.CourseLevel,st.AcademicYear 
FROM tbl_student_subject_master st
join tbl_student s on s.std_PRN=st.student_id AND s.school_id = st.school_id
join tbl_academic_Year as y on st.AcademicYear=y.Academic_Year and y.school_id='$sc_id' 
where st.teacher_ID='$t_id'and st.school_id='$sc_id' and y.Enable=1");
}
}

$result_student = mysql_num_rows($sql_student);

?>

<td><?php echo $result_student;?></td>

<td><?php 

$t_emp_type_pid=$row['t_emp_type_pid'];
if($t_emp_type_pid=='133' || $t_emp_type_pid=='134')
{
    echo $dynamic_teacher;
}
if($t_emp_type_pid=='135')
{
    echo $dynamic_hod;
}
if($t_emp_type_pid=='137')
{
    echo $dynamic_principal;
}

 ?> </td>

</td>
<td><a href="teacher_setup.php?t_id=<?php echo $row['t_id']; ?>">
<center><img src="Images/edit.png" height="20px" width="20px">
</a></center></td>

<td>
<center><img src="Images/cancel.png" style=" width:25px;height:25px;"
         alt="Cancel" id="<?php echo $row['id']; ?>"
         onclick="return confirmation(this.id)"></center>
</td>
<!-- changes end for bug SMC-3449-->

</tr>

<?php

$i++;

 } ?>


                                    </tbody>

                                    </table>


                                </div>
                                <div class="container" align="center">
        <nav aria-label="Page navigation">
            <ul class="pagination" id="pagination"></ul>
        </nav>
        </div>
        <?php } ?>
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
        </div>

        </div>
        <!--Changes end for SMC-3259 by Pranali-->
    </body>

</html>

    
    