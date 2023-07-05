<?php
include('scadmin_header.php');

//     $id=$_SESSION['staff_id'];
$fields = array("id" => $id);
/*   $table="tbl_school_admin";
*/
$smartcookie = new smartcookie();
$results = $smartcookie->retrive_individual($table, $fields);
$result = mysql_fetch_array($results);
$sc_id = $result['school_id'];
$t_id = $_GET['t_id'];
$temp=0;
$temp1=0;
$temp3=0;
$temp4=0;
$feedback_score = 0;
$group_id=$_SESSION['group_member_id'];

$t_sql = mysql_query("SELECT * FROM tbl_teacher where t_id = '$t_id' ");
$t_res = mysql_fetch_array($t_sql);
$teacher_name = $t_res['t_complete_name'];

$sq = mysql_query("SELECT * FROM tbl_academic_Year where school_id ='$sc_id' and Enable ='1' ");
$y = mysql_fetch_array($sq);
$curr_yr = $y['Academic_Year'];


// include('securityfunctions.php');
$url = $GLOBALS['URLNAME']."/core/Version6/360_feedback_report_api.php";
//echo $url;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<!-- //Modified query for academic year -->
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Semester</title>
    <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <!-- <script src="360_print.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- <link href="ymz_box.css" type="text/css" rel="stylesheet"> -->
    <!-- <script src="ymz_box.min.js" type="text/javascript"></script> -->



    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>

</head>

<body bgcolor="#CCCCCC">

<div style="bgcolor:#CCCCCC">
    <div class="" style="margin-top: 8px;">
        <div class="row">
            <div class="container" style="padding-top: 12px;">
                <div class="col-md-2" id="" style="" align="left">
                    <a href="TeacherListFeed360.php"><button class="btn btn-danger" style="">Back</button></a>
                </div>
                <div class="col-md-8">
                   <div class="row" align="center" style="margin-left: 15%;">
                            <div class="col-md-3" style="color:#808080; font-size:18px; margin:0px;">
                                Select Year
                            </div>
                            <div class="col-md-3">
                                <form method="post">
                                        <select name="year" id="year" class="form-control" required>
                                            <option value="">Select</option>

                                            <?php  if(isset($_POST['year'])){ ?>
                                                <option value="<?php echo $_POST['year']; ?>" selected = "selected"><?php echo $_POST['year']; ?></option>
                                                <?php  }else{ ?>
                                                    <option value="<?php echo $curr_yr; ?>" selected = "selected"><?php echo $curr_yr; ?></option>
                                                 <?php  }  ?> 
                                            <?php  
                                            $sql="SELECT * FROM tbl_academic_Year where school_id='$school_id' and ExtYearID != '' group by Academic_Year";
                                            $res=mysql_query($sql);
                                            // $result=mysql_fetch_array($res);
                                            while($value=mysql_fetch_array($res)){ ?>
                                            <option value="<?php echo $value['Academic_Year']; ?>" <?php $value['Academic_Year']==$_POST['year'] ? 'selected="selected"' : 'selected="selected"' ?> ><?php echo $value['Academic_Year']; ?></option>
                                            <?php }?>
                                        </select>
                                
                           </div>
                           <div class="col-md-2">
                                <input type="submit" name="submit" value="Submit" class="btn btn-success">
                           </div>
                           </form>
                    </div> 
                </div>
                <?php //Below code added by Rutuja for SMC-4815 on 09-09-2020
                if(isset($_POST['submit']))
                {
                    $years= $_POST['year'];
                    $year_flag=1;

                    
                }
                else{
                    $sql2 = "SELECT Academic_Year FROM tbl_academic_Year WHERE school_id='$sc_id' and Enable = '1' ";//changed the query to show current academic year as default
                        $query2 = mysql_query($sql2);
                        $res2=mysql_fetch_row($query2);
                        $years=$res2[0];
                    $year_cond='';
                    $year_flag=1;
                }
                    ?>
                            <?php 
                                //php for school logo
                                $school_details = mysql_query("SELECT * from tbl_school_admin where school_id = '$sc_id' ");
                                $sc_arr = mysql_fetch_array($school_details);
                                $sc_logo = $sc_arr['img_path'];
                                $sc_name = $sc_arr['school_name'];
                                $principal_name = $sc_arr['name'];
                                $aicte = "scadmin_image/aicte_logo.jpg";
                            ?>
                <div class="col-md-2" id="" style="" align="right" >
                    <form action="feedback_report.php" method="post">
                        <input type="hidden" name="360_feedback" value="<?php echo $years.','.$t_id.','.$sc_id.','.$sc_logo.','.$aicte; ?>">
                        <button class="btn btn-primary" type="submit" id="submit" name="submit">Print this page</button>
                    </form>
                </div>
            </div>  
        </div>
    </div>
   
</div>


<div id="printdiv">


<div style="bgcolor:#CCCCCC">


    <div class="container" style="padding:30px; padding-top: 15px;">
        

        <div style="border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">

            <div style="background-color:#F8F8F8 ;">

            <div class="container" style="padding: 5px;">
                
                            
                <!-- inside container -->
                <table style="width: 100%;">
                    <tr>

                    <td>
                        <?php if ($sc_logo != "") { ?>

                            <img src='/core/<?php echo $sc_logo ?>' height="70" ; width="70" class="preview"/>

                            <?php } else { ?>

                            <img src="/Assets/images/avatar/avatar_2x.png" width="70" height="70" class="preview"/>

                        <?php } ?>
                    <!-- <td align="left">
                        <h2 style="display:block;color:#666666;font-weight:bold;font-family: Times New Roman, Times, serif; ">
                            <?php //echo $sc_name ?>
                        </h2>
                    </td> -->
                    <td align="center">
                        <h2>360 Degree Feedback Report (<?php echo $years ?>)</h2> 
                        <h2 style="display:block;color:#666666;font-weight:bold;font-family: Times New Roman, Times, serif; ">
                        <?php echo $sc_name ?>
                        </h2>
                    
                    </td>
                    </td>
                       <td align="right" >
                       <img src="/core/scadmin_image/aicte_logo.jpg" width="70" height="70" class="preview"/>
                       </td>
                    </tr>
                </table>
            </div>
                

                <div class="row" style="padding:10px;">

                    <div class="col-md-12  " id="no-more-tables">


                        <table id="example" class="display" style="text-align: center;" width="100%" cellspacing="0" border="1">

            </div>
                </form>
                
                
                            <thead>

                            <tr>
                                <th style=" text-align: center;">Teacher Name</th>
                                <th style=" text-align: center;">360 Feedback Score</th>
                                <th style="text-align: center;">Present Position</th>
                                <th style="text-align: center;">Academic year</th>


                            </tr>

                            </thead>
                            <tbody>

                            <?php /*$sql ="SELECT a.Year,t.t_complete_name,t.t_emp_type_pid as teacher_type
                            FROM tbl_teacher t
                            JOIN tbl_academic_Year a
                            on t.school_id=a.school_id
                            WHERE a.Enable='1' and t.school_id='$sc_id' AND t.t_id='$t_id'";*/
                            // if ($year_flag==0) {
                            $sql ="SELECT a.Academic_Year,a.Year,t.t_complete_name,(CASE WHEN t.t_emp_type_pid='133' THEN 'Teacher'
                            WHEN (t.t_emp_type_pid='134' or t.t_emp_type_pid='133')  THEN 'Teacher'
                            WHEN t.t_emp_type_pid='135' THEN 'HOD'
                            WHEN t.t_emp_type_pid='137' THEN 'Principal'
                            ELSE 'Non-Teacher' END) as teacher_type
                            FROM tbl_teacher t
                            JOIN tbl_academic_Year a
                            on t.school_id=a.school_id
                            WHERE a.Enable='1' and t.school_id='$sc_id' AND t.t_id='$t_id' group by t.t_id";//Changes **Amol Patil solve problem repeated name show
                        //   } else {
                            // $sql ="SELECT a.Academic_Year,a.Year,t.t_complete_name,(CASE WHEN t.t_emp_type_pid='133' THEN 'teacher'
                            // WHEN (t.t_emp_type_pid='134' or t.t_emp_type_pid='133')  THEN 'Teacher'
                            // WHEN t.t_emp_type_pid='135' THEN 'HOD'
                            // WHEN t.t_emp_type_pid='137' THEN 'Principal'
                            // ELSE 'Non-Teacher' END) as teacher_type
                            // FROM tbl_teacher t
                            // JOIN tbl_academic_Year a
                            // on t.school_id=a.school_id and a.Academic_Year=t.t_academic_year
                            // WHERE t.school_id='$sc_id' AND t.t_id='$t_id' group by t.t_id";
                        //   }
                        //   echo $sql;
                        //Count Starts here 
                        // <!-- Teaching Process -->

    // api calls starts here
                        
        $data = array("school_id"=>$sc_id,
                    "teacher_id"=>$t_id,
                    "academic_year"=>$years,
                    "entity_key"=>"teaching_process",
                    "limit"=>"" );
        $data_string = json_encode($data); 
        $arr = post_function($url,$data_string);
        $teaching_process_det = json_decode($arr,TRUE);
        
    //student feedback
    
        $data = array("school_id"=>$sc_id,
                    "teacher_id"=>$t_id,
                    "academic_year"=>$years,
                    "entity_key"=>"student_feedback",
                    "limit"=>""  );
        $data_string = json_encode($data); 
        $arr = post_function($url,$data_string);
        $student_feed_det = json_decode($arr,TRUE); 

    //dept activity

        $data = array("school_id"=>$sc_id,
                    "teacher_id"=>$t_id,
                    "academic_year"=>$years,
                    "entity_key"=>"departmental_activity",
                    "limit"=>""  );
        $data_string = json_encode($data); 
        $arr = post_function($url,$data_string);
        $dept_activity_det = json_decode($arr,TRUE); 
    //institute

        $data = array("school_id"=>$sc_id,
                    "teacher_id"=>$t_id,
                    "academic_year"=>$years,
                    "entity_key"=>"institute_activity",
                    "limit"=>""  );
        $data_string = json_encode($data); 
        $arr = post_function($url,$data_string);
        $institute_activity_det = json_decode($arr,TRUE); 

    //acr
        $data = array("school_id"=>$sc_id,
                    "teacher_id"=>$t_id,
                    "academic_year"=>$years,
                    "entity_key"=>"ACR",
                    "limit"=>""  );
        $data_string = json_encode($data); 
        $arr = post_function($url,$data_string);
        $acr_det = json_decode($arr,TRUE); 
    //society

        $data = array("school_id"=>$sc_id,
                    "teacher_id"=>$t_id,
                    "academic_year"=>$years,
                    "entity_key"=>"society_contribution",
                    "limit"=>""  );
        $data_string = json_encode($data); 
        $arr = post_function($url,$data_string);
        $society_contri_det = json_decode($arr,TRUE); 

        // api calls ends here
                        //teaching process
                        $count=count($teaching_process_det['posts']);
                        foreach($teaching_process_det['posts'] as $rows){
                         $studen_feed=round((($rows['feed360_actual_classes'] /$rows['feed360_classes_scheduled'])*25),2);
         
                                 $temp=$temp+$studen_feed;
                                 $tc_feedback = round(($temp/$count),2);
                                
                        }
                        if($tc_feedback >25)
                        {
                          
                           $teac_max_sql = mysql_query("select total_points from tbl_360activity_level where actL360_activity_level = 'Teaching Process' ");
                           $teac_res = mysql_fetch_array($teac_max_sql);
                           $tc_feedback = $teac_res['total_points'];
                            
                        }
                                   
                        
                        //student feedback
                        $count1=count($student_feed_det['posts']);
                                   foreach($student_feed_det['posts'] as $rows){
                                     $avg_stud_feed=round((($rows['stu_feed_points'])*(25/(5*$rows['count']))),2);
                                                 $temp1=$temp1+$avg_stud_feed;
                                                  $st_feed = round(($temp1/$count1),2);
                                       
                                      }
                                      if($st_feed >25)
                                            {
                                            
                                            $stud_max_sql = mysql_query("select total_points from tbl_360activity_level where actL360_activity_level = 'Students Feedback' ");
                                            $stud_res = mysql_fetch_array($teac_max_sql);
                                            $st_feed = $stud_res['total_points'];
                                            }
                                    
                                      //dept feedback
                                      $dept_total=0;
                                     foreach($dept_activity_det['posts'] as $rows) { 
                                       $dept_total+= $rows['credit_point'];
                                       $dept_feed = round(($dept_total),2);
                                       
                                     }
                                     if($dept_feed >20)
                                       {
                                         
                                          $dept_max_sql = mysql_query("select total_points from tbl_360activity_level where actL360_activity_level = 'Departmental Activities' ");
                                          $dept_res = mysql_fetch_array($dept_max_sql);
                                          $dept_feed = $dept_res['total_points'];
                                           
                                       }
                                     //institute feedback
                                     $institute_total = 0;
                                    foreach($institute_activity_det['posts'] as $rows) { 
         
                                         $institute_total+=$rows['credit_point'];
                                       $inst_feed = round(($institute_total),2); 
 
                             }
                             if($inst_feed >10)
                             {
                                
                                $inst_max_sql = mysql_query("select total_points from tbl_360activity_level where actL360_activity_level = 'Institute Activities' ");
                                $inst_res = mysql_fetch_array($inst_max_sql);
                                $inst_feed = $inst_res['total_points'];
                                 
                             }

                             //acr
                              $ACR_count=count($acr_det['posts']);
                                     $ACR_total = 0;
                                     foreach($acr_det['posts'] as $rows) { 
                                       $ACR_total+= $rows['credit_point'];
                                                 $acr_feed = round(($ACR_total/$ACR_count),2);
                                     }
                                     if($acr_feed >10)
                                     {
                                        
                                        $acr_max_sql = mysql_query("select total_points from tbl_360activity_level where actL360_activity_level = 'ACR' ");
                                        $acr_res = mysql_fetch_array($acr_max_sql);
                                        $acr_feed = $acr_res['total_points'];
                                        
                                     }

                                     //society contribution
                                     $contribution_total = 0;
                                     foreach($society_contri_det['posts'] as $rows) { 
                                       $contribution_total+= $rows['credit_point'];
                                       
                                     }
                                     if($contribution_total > 10)
                                       {
                                        $soc_sql = mysql_query("select total_points from tbl_360activity_level where actL360_activity_level = 'Contribution to Society' ");
                                        $soc_res = mysql_fetch_array($soc_sql);
                                        $contribution_total = $soc_res['total_points'];
                                        }
         
         
                                  $feedback_score= $tc_feedback + $st_feed + $dept_feed + $inst_feed + $acr_feed + $contribution_total ;
                        //count ends here
                        

                            $query = mysql_query($sql);
                            while ($rows = mysql_fetch_assoc($query)) { 
                                ?>
                                <tr>

                                    <td>
                                        <?php echo $rows['t_complete_name']; ?>
                                    </td>
                                    <td>
                                        <?php echo $feedback_score; ?>
                                    </td>
                                    <td>
                                        <?php echo $rows['teacher_type']; ?>
                                    </td>
                                     <td>
                                        <?php  echo $years ; ?>
                                    </td>




                                </tr>

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
    </div>
</div>


<body bgcolor="#CCCCCC">

<div style="bgcolor:#CCCCCC">


    <div class="container" style="padding:30px;">

        <div style="border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">

            <div style="background-color:#F8F8F8 ;">

                <div class="row">


                    <div class="col-md-6 ">

                        <h2> <span class="tech-pro">A) Teaching Process (Max Point 25) </span></h2>

                    </div>


                </div>

                <div class="row" style="padding:10px;">

                    <div class="col-md-12  " id="no-more-tables">


                        <table id="example" class="display" style="text-align: center;" width="100%" cellspacing="0" border="1">

                            <thead>

                            <tr>
                                <th style="width:15%; text-align: center;">Semester</th>
                                <th style="width:15%; text-align: center;">Subject Code </th>
                                <th style="width:20%; text-align: center;">No. Of Scheduled Classes</th>
                                <th style="width:20%; text-align: center;">No. Of Actually Held Classes </th>
                                <th style="width:15%; text-align: center;">Point Earned</th>
                                <th style="width:15%; text-align: center;">Enclosure No. </th>
                            </tr>

                            </thead>
                            <tbody>
                            <?php
                            // $feedback_data added and total count for all activities taken from below query result by Pranali for SMC-4454 on 2-4-2020
                            $feedback_data = mysql_query("SELECT * FROM aicte_ind_feedback_summary_report WHERE teacher_id='$t_id' and school_id='$sc_id' and group_member_id='$group_id'");
                            $data = mysql_fetch_assoc($feedback_data);

                            if ($year_flag==0) {
                              $sql ="SELECT feed360_semester_ID, feed360_subject_code,feed360_classes_scheduled, feed360_actual_classes
                              FROM tbl_360feedback_template
                              WHERE feed360_school_id='$sc_id' and feed360_teacher_id='$t_id'";
                            } else {
                            $sql ="SELECT feed360_semester_ID, feed360_subject_code,feed360_classes_scheduled, feed360_actual_classes
                            FROM tbl_360feedback_template
                            WHERE feed360_school_id='$sc_id' and feed360_teacher_id='$t_id' and feed360_academic_year_ID='$years'";
                          }

                           
                                foreach($teaching_process_det['posts'] as $rows){  ?>
                                <tr>

                                    <td style="text-align: left; padding: 0px 0px 0px 10px;">
                                        <?php echo $rows['feed360_semester_ID']; ?>
                                    </td>
                                    <td style="text-align: left; padding: 0px 0px 0px 10px;">
                                        <?php echo $rows['feed360_subject_code']; ?>
                                    </td>
                                     <td>
                                        <?php echo $rows['feed360_classes_scheduled']; ?>
                                    </td>
                                    <td>

                                       <?php echo $rows['feed360_actual_classes']; ?>
                                    </td>
                                     <td>
                                        <?php echo $student_feed=round((($rows['feed360_actual_classes'] /$rows['feed360_classes_scheduled'])*25),2);

                                        $temp2=$temp2+$student_feed;
                                         ?>
                                    </td>
                                    <td>


                                    </td>


                                </tr>

                            <?php } ?>
<tr>
<td><?php //echo $temp2.$count; ?></td>
<?php //$a = $temp/$count; 

// $tc_feedback = round(($temp2/$count),2);
// $feedback_score += $tc_feedback; 
// $feedback_score = $feedback_score + $tc_feedback;

?>
<td><?php //echo $feedback_score; ?></td>
<td></td>
<td><b>Total</b></td>
<?php 
     
?>
<td><b> <?php echo $tc_feedback; ?></b></td>
<td></td>
</tr>

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
    </div>
</div>

<!--student feedback -->
<?php


?>
<div style="bgcolor:#CCCCCC">


    <div class="container" style="padding:30px;">

        <div style="border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">

            <div style="background-color:#F8F8F8 ;">

                <div class="row">


                    <div class="col-md-6 " align="left">

                        <h2> <span class="tech-pro1"> B) Student Feedback (Max Point 25) </span> </h2>

                    </div>


                </div>

                <div class="row" style="padding:10px;">

                    <div class="col-md-12  " id="no-more-tables">


                        <table id="example" class="display" style="text-align: center; table-layout: fixed;" width="100%" cellspacing="0" border="1";>

                            <thead>

                            <tr>
                                <th style="text-align: center;">Semester</th>
                                <th style="text-align: center;">Subject Code </th>
                                <th style=" text-align: center;">Average Student Feedback</th>
                                <th style=" text-align: center;">Details</th>
                                <th style=" text-align: center;">Enclosure NO. </th>

                            </tr>

                            </thead>
                            <tbody>
                            <?php


                                foreach($student_feed_det['posts'] as $rows){ ?>
                                <tr>

                                    <td style="width: 150px; text-align: left; padding: 0px 0px 0px 10px;">
                                        <?php echo $rows['stu_feed_semester_ID']; ?>
                                    </td>
                                    <td style="width:150px; text-align: left; padding: 0px 0px 0px 10px;">
                                        <?php echo $rows['stud_subjcet_code']; ?>
                                    </td>
                                     <td style="width:150px;">
                                        <?php echo $avg_stud_feed=round((($rows['stu_feed_points'])*(25/(5 * $rows['count']))),2);
                                        $temp3=$temp3+$avg_stud_feed;
                                        ?>
                                    </td>
                                    <td style="width:150px; padding: 0px 0px 0px 10px;">
                                        <form action="student_feedback_summary.php" method="POST">
                                            <input type="hidden" name="feedback_summary" value="<?php echo $rows['stu_feed_semester_ID'].','.$rows['stud_subjcet_code'].','.$rows['stu_feed_academic_year'].','.$t_id.','.$sc_id ;?>">    
                                            
                                            <a><button type="submit" name="submit_feedback" class="btn btn-light" style="margin-bottom: -14px; margin-top: 2px;">Details</button></a>
                                        </form>
                                    </td>
                                    <td style="width:150px; padding: 0px 0px 0px 10px;">
                                        <?php //echo $rows['']; ?>
                                    </td>



                                </tr>

                            <?php } ?>

<tr>
<?php 
    // $st_feed = round(($temp3/$count1),2);
    // $feedback_score = $feedback_score + $st_feed;
?>
<td style="width:25%;"><?php //echo $temp1."<br>".$count1."<br>".$year_flag ; ?></td>
<td style="width:25%;"><b>Total</b></td>

<td style="width:25%;"><b> <?php echo $st_feed; ?></b></td>
<?php //exit;?>

<td style="width:25%;"></td>
</tr>
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
    </div>
</div>





<!--Departmental Activity .-->

<div style="bgcolor:#CCCCCC">


    <div class="container" style="padding:30px;">

        <div style="border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">

            <div style="background-color:#F8F8F8 ;">

                <div class="row">


                    <div class="col-md-6 " align="left">

                        <h2> <span class="tech-pro1">C) Departmental Activity (Max Credit 20) </span> </h2>

                    </div>


                </div>

                <div class="row" style="padding:10px;">

                    <div class="col-md-12  " id="no-more-tables">


                        <table id="example" class="display" style="text-align: center;" width="100%" cellspacing="0" border="1">

                            <thead>

                            <tr>
                                <th style="width:20%; text-align: center;">Semester</th>
                                <th style="width:20%; text-align: center;">Activity Code/Name </th>
                                <th style="width:20%; text-align: center;">Credit Point</th>
                                <th style="width:20%; text-align: center;">Criteria</th>
                                <th style="width:20%; text-align: center;">Enclosure NO. </th>

                            </tr>

                            </thead>
                            <tbody>
                            <?php

                            if($year_flag==0){
                              $sql ="SELECT semester_name, activity_name,credit_point,criteria
                              FROM tbl_360_activities_data
                              WHERE schoolID='$sc_id' and Receiver_tID='$t_id' and activity_level_id='1'";
                            }
                            else {
                              $sql ="SELECT semester_name, activity_name,credit_point,criteria
                              FROM tbl_360_activities_data
                              WHERE schoolID='$sc_id' and Receiver_tID='$t_id' and activity_level_id='1' and Academic_Year='$years'";
                            }

                            $query = mysql_query($sql);
                            $dept_total=0;
                            foreach($dept_activity_det['posts'] as $rows) { ?>
                                <tr>

                                    <td style="width:20%; text-align: left; padding: 0px 0px 0px 10px;">
                                        <?php echo $rows['semester_name']; ?>
                                    </td>
                                    <td style="width:20%; text-align: left; padding: 0px 0px 0px 10px;">
                                        <?php echo $rows['activity_name']; ?>
                                    </td>
                                     <td style="width:20%;">
                                        <?php echo ($rows['credit_point']>20) ? $rows['credit_point']=20 : $rows['credit_point']; ?>
                                    </td>
                                    <td style="width:20%;">
                                        <?php echo $rows['criteria']; ?>
                                    </td>
                                    <td style="width:20%;">
                                        <?php //echo $rows['']; ?>
                                    </td>


                                </tr>

                            <?php $dept_total+= $rows['credit_point']; } ?>
                            <tr>
                                <?php 
                                    // $dept_feed = round(($dept_total),2);
                                    // $feedback_score += $dept_feed;
                                ?>
                                <td style="width:20%;"><?php //echo $feedback_score; ?></td>

                                <td style="width:20%;"><b>Total</b></td>
                                <td style="width:20%;"><b> <?php 
                                  echo $dept_feed;

                            ?></b></td>
                                        <td style="width:20%;"></td>
                                        <td style="width:20%;"></td>
                                    </tr>

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
    </div>
</div>


<!-- Institude Activity -->
<?php 


?>


<div style="bgcolor:#CCCCCC">


    <div class="container" style="padding:30px;">

        <div style="border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">

            <div style="background-color:#F8F8F8 ;">

                <div class="row">

                   

                    <div class="col-md-6 " align="left">

                        <h2> <span class="tech-pro1">D) Institute Activity (Max Credit 10) <span></h2>

                    </div>


                </div>

                <div class="row" style="padding:10px;">

                    <div class="col-md-12  " id="no-more-tables">


                        <table id="example" class="display" style="text-align: center;" width="100%" cellspacing="0" border="1">

                            <thead>

                            <tr>
                                <th style="width:20%; text-align: center;">Semester</th>
                                <th style="width:20%; text-align: center;">Activity </th>
                                <th style="width:20%; text-align: center;">Credit Point</th>
                                <th style="width:20%; text-align: center;">Criteria</th>
                                <th style="width:20%; text-align: center;">Enclosure NO. </th>

                            </tr>

                            </thead>
                            <tbody>
                            <?php

                           
                            $institute_total = 0;
                            $institute_cnt = 0;

                            foreach($institute_activity_det['posts'] as $rows) { $institute_cnt++; ?>
                                <tr>

                                    <td style="width:20%; text-align: left; padding: 0px 0px 0px 10px;">
                                        <?php echo $rows['semester_name']; ?>
                                    </td>
                                    <td style="width:20%; text-align: left; padding: 0px 0px 0px 10px;">
                                        <?php echo $rows['activity_name']; ?>
                                    </td>
                                     <td style="width:20%;">
                                        <?php echo ($rows['credit_point']>10) ? $rows['credit_point']=10 : $rows['credit_point']; ?>
                                    </td>
                                    <td style="width:20%;">
                                        <?php echo $rows['criteria']; ?>
                                    </td>
                                    <td style="width:20%;">
                                        <?php  ?>
                                    </td>


                                </tr>

                            <?php $institute_total+=$rows['credit_point']; } ?>
                                <tr>

                                        <td style="width:20%;"><?php //echo $feedback_score; ?></td>

                                        <td style="width:20%;"><b>Total</b></td>
                                        <td style="width:20%;"><b> 
                                            <?php echo $inst_feed; ?>
                                            </b></td>
                                        <td style="width:20%;"></td>
                                        <td style="width:20%;"></td>
                                    </tr>

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
    </div>
</div>

<div style="bgcolor:#CCCCCC">


    <div class="container" style="padding:30px;">

        <div style="border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">

            <div style="background-color:#F8F8F8 ;">

                <div class="row">

                   

                    <div class="col-md-6 " align="left">

                        <h2><span class="tech-pro1">E) ACR (Max Credit 10)</span> </h2>

                    </div>


                </div>

                <div class="row" style="padding:10px;">

                    <div class="col-md-12  " id="no-more-tables">


                        <table id="example" class="display" style="text-align: center;" width="100%" cellspacing="0" border="1">

                            <thead>

                            <tr>
                                <th style="width:20%; text-align: center;">Year</th>
                                <th style="width:20%; text-align: center;">Activity </th>
                                <th style="width:20%; text-align: center;">Credit Point</th>
                                <th style="width:20%; text-align: center;">Criteria</th>
                                <th style="width:20%; text-align: center;">Enclosure NO. </th>

                            </tr>

                            </thead>
                            <tbody>
                            <?php

                            if ($year_flag==0){
                              $sql ="SELECT a.Academic_Year, a.activity_name,a.credit_point,a.criteria
                              FROM tbl_360_activities_data a join tbl_academic_Year y on a.schoolID=y.school_id and a.Academic_Year=y.Academic_Year
                              WHERE a.schoolID='$sc_id' and a.Receiver_tID='$t_id' and a.activity_level_id='4'";
                            }
                            else{
                              $sql ="SELECT a.Academic_Year, a.activity_name,a.credit_point,a.criteria
                              FROM tbl_360_activities_data a join tbl_academic_Year y on a.schoolID=y.school_id and a.Academic_Year=y.Academic_Year
                              WHERE a.schoolID='$sc_id' and a.Receiver_tID='$t_id' and a.activity_level_id='4' and a.Academic_Year='$years' ";
                             
                              
                            }
                            // echo $sql;
                            // exit;
//echo $sql;exit;
                            $query = mysql_query($sql);
                            $ACR_count=mysql_num_rows($query);
                            $ACR_total = 0;
                            foreach($acr_det['posts'] as $rows) { ?>
                                <tr>

                                    <td style="width:20%; text-align: left; padding: 0px 0px 0px 10px;">
                                        <?php echo $rows['Academic_Year']; ?>
                                    </td>
                                    <td style="width:20%; text-align: left; padding: 0px 0px 0px 10px;">
                                        <?php echo $rows['activity_name']; ?>
                                    </td style="width:20%; text-align: left; padding: 0px 0px 0px 10px;">
                                     <td>
                                        <?php echo ($rows['credit_point']>10) ? $rows['credit_point']=10 : $rows['credit_point']; ?>
                                    </td>
                                    <td style="width:20%; text-align: left; padding: 0px 0px 0px 10px;">
                                        <?php
                                            if($rows['credit_point'] == 10)
                                                echo "Extraordinary" ;
                                            else if($rows['credit_point'] == 9)
                                                echo "Excellent" ;
                                            else if($rows['credit_point'] == 8)
                                                echo "Very Good " ;
                                            else if($rows['credit_point'] == 7)
                                                echo "Good " ;
                                            else
                                                echo "Satisfactory" ;
                                            ?>
                                    </td>
                                    <td style="width:20%">
                                        <?php //echo $rows['']; ?>
                                    </td>




                                </tr>

                            <?php  } ?>
                                <tr>
                                    <?php 
                                        // $acr_feed = round(($ACR_total/$ACR_count),2);
                                        // $feedback_score += $acr_feed;
                                    ?>
                                        <td style="width:20%"><?php //echo $feedback_score; ?></td>

                                        <td style="width:20%"><b>Total</b></td>
                                        <td style="width:20%"><b> <?php 
                              echo $acr_feed;

                              ?></b></td>
                                        <td style="width:20%"></td>
                                        <td style="width:20%"></td>
                                    </tr>

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
    </div>
</div>


<!-- Contribution to Society -->
<?php 

?>


<div style="bgcolor:#CCCCCC">


    <div class="container" style="padding:30px;">

        <div style="border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">

            <div style="background-color:#F8F8F8 ;">

                <div class="row">

                    
                    <div class="col-md-12 " align="left">

                  <h2><span class="tech-pro1">F) Contribution To Society (Max Credit 10) <span> </h2>

                    </div>


                </div>

                <div class="row" style="padding:10px;">

                    <div class="col-md-12  " id="no-more-tables">


                        <table id="example" class="display" style="text-align: center;" width="100%" cellspacing="0" border="1">

                            <thead>

                            <tr>
                                <th style="width:20%; text-align: center;">Semester</th>
                                <th style="width:20%; text-align: center;">Activity </th>
                                <th style="width:20%; text-align: center;">Credit Point</th>
                                <th style="width:20%; text-align: center;">Criteria</th>
                                <th style="width:20%; text-align: center;">Enclosure NO. </th>

                            </tr>

                            </thead>
                            <tbody>
                            <?php

                            if($year_flag==0){
                              $sql ="SELECT semester_name, activity_name,credit_point,criteria
                              FROM tbl_360_activities_data
                              WHERE schoolID='$sc_id' and Receiver_tID='$t_id' and activity_level_id='3'";
                            }
                            else{
                              $sql ="SELECT semester_name, activity_name,credit_point,criteria
                              FROM tbl_360_activities_data
                              WHERE schoolID='$sc_id' and Receiver_tID='$t_id' and activity_level_id='3' and Academic_Year='$years'";
                            }

                            
                            $query = mysql_query($sql);
                            // $contribution_total = 0;
                            // $contribution_cnt = 0;
                            foreach($society_contri_det['posts'] as $rows) {  ?>
                                <tr>

                                    <td style="width:20%; text-align: left; padding: 0px 0px 0px 10px;">
                                        <?php echo $rows['semester_name']; ?>
                                    </td>
                                    <td style="width:20%; text-align: left; padding: 0px 0px 0px 10px;">
                                        <?php echo $rows['activity_name']; ?>
                                    </td>
                                     <td style="width:20%;">
                                        <?php echo $rows['credit_point']; ?>
                                    </td>
                                    <td style="width:20%;">
                                        <?php echo $rows['criteria']; ?>
                                    </td>
                                    <td style="width:20%;">
                                        <?php //echo $rows['']; ?>
                                    </td>



                                </tr>


                            <?php  } ?>

                                <tr>
                                   
                                        <td style="width:20%;"><?php //echo $feedback_score ?></td>

                                        <td style="width:20%;"><b>Total</b></td>

                                        <td style="width:20%;"><b> <?php /*$sql ="SELECT SUM(credit_point) as credit_point
                            FROM tbl_360_activities_data
                            WHERE schoolID='$sc_id' and Receiver_tID='$t_id' and activity_level_id='3'";
                            $query = mysql_query($sql);
                            $rows = mysql_fetch_assoc($query);
                            $total=$rows['credit_point'];
                              if($total >= 10)
                                  echo "10";
                              else
                                echo  $total;*/
                                echo $contribution_total;

                                 ?></b></td>
                                        <td style="width:20%;"></td>
                                        <td style="width:20%;"></td>
                                    </tr>

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
        
    </div>
   
</div>
                            </div>
        </head>
</body>


</html>