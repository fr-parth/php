<?php
include('scadmin_header.php');
$results=$smartcookie->retrive_individual($table,$fields);
$result=mysql_fetch_array($results);
$school_id=$result['school_id'];
 $fr_date = date("d-m-Y H:i",mktime(00,00));//hour, minute, second
 $to_date = date("d-m-Y H:i",mktime(23,59));//hour, minute, second$timeStamp = mktime(0, 0, 0, $month, 1, $year);
   // $group_member_id = $_SESSION['group_admin_id'];     
   //    $where =  "sa.group_member_id='$group_member_id'";
     if(isset($_POST)){
      $dataLine ="Data of ";
      // print_r($_POST); exit;
      // if($_POST['school_id']==""){$_POST['school_id']='0';}
      // $school_id = $_POST['school_id'];
      $f_dt = $_POST['fromdt'];//table column
      $t_dt = $_POST['todt'];//table column
      // if($school_id!="0"){
      //   $where .= " AND ls.school_id='$school_id'";
      //   $dataLine .= " $school_id";
      // }      
      if($f_dt!="" && $t_dt!=""){
         $from_dt = date('Y-m-d H:i',strtotime($f_dt));
         $to_dt = date('Y-m-d H:i',strtotime($t_dt));
        $where .= " AND ls.LatestLoginTime between '$from_dt' AND '$to_dt'";
        $dataLine .= " Date ".date('d-m-Y H:i',strtotime($f_dt))." - ".date('d-m-Y H:i',strtotime($t_dt));
        // $newurl = "&fd=".trim($from_dt).'&td='.trim($to_dt); 
      }
      else{
      $current_dt = date("Y-m-d");
      $where .= " AND date_format(ls.LatestLoginTime,'%Y-%m-%d')='$current_dt'";
      $dataLine .= " Date ".date('d-m-Y H:i',strtotime($fr_date))." - ".date('d-m-Y H:i',strtotime($to_date));

      }
    }else{
      $current_dt = date("Y-m-d");
      $where .= " AND date_format(ls.LatestLoginTime,'%Y-%m-%d')='$current_dt'";
      $dataLine .= " Date ".date('d-m-Y H:i',strtotime($fr_date))." - ".date('d-m-Y H:i',strtotime($to_date));
    }
    // $query1=mysql_query("SELECT school_type FROM tbl_school_admin where school_id='$school_id'");
    // $row=mysql_fetch_array($query1);
    $query12=mysql_query("SELECT Entity_type, FROM tbl_LoginStatus where school_id='$school_id'");
    $row1=mysql_fetch_array($query12);
     $Entity_type=$row1['Entity_type'];
    $url_teacher = "login_logout_teacher1.php";
    $url_student = "login_logout_student1.php";
    // if($from_dt!='' && $to_dt!='')
    // {
   if(($Entity_type='103') || ($Entity_type='203'))
    {

     $web_teacher_sql = "SELECT DISTINCT(ls.entityID) FROM tbl_LoginStatus as ls JOIN tbl_teacher as t ON ls.EntityID=t.id and ls.school_id=t.school_id JOIN tbl_school_admin as sa ON ls.school_id=sa.school_id where ls.school_id='$school_id' $where AND (Entity_type='103' OR Entity_type='203') AND ls.LatestMethod='web' ";
    // echo $web_teacher_sql; exit;
    $web_teacher=mysql_query($web_teacher_sql);
    $teacher_web_count=mysql_num_rows($web_teacher);
    
    $ios_teacher=mysql_query("SELECT DISTINCT(ls.entityID) FROM tbl_LoginStatus as ls JOIN tbl_teacher as t ON ls.EntityID=t.id and ls.school_id=t.school_id JOIN tbl_school_admin as sa ON ls.school_id=sa.school_id where ls.school_id='$school_id' $where AND (ls.Entity_type='103' OR ls.Entity_type='203') AND ls.LatestMethod='iOS'");
    $teacher_ios_count=mysql_num_rows($ios_teacher);
    
    $android_teacher=mysql_query("SELECT DISTINCT(ls.entityID) FROM tbl_LoginStatus as ls JOIN tbl_teacher as t ON ls.EntityID=t.id and ls.school_id=t.school_id JOIN tbl_school_admin as sa ON ls.school_id=sa.school_id where ls.school_id='$school_id' $where AND (ls.Entity_type='103' OR ls.Entity_type='203') AND ls.LatestMethod='Android'");
    $teacher_android_count=mysql_num_rows($android_teacher);
   }
 if(($Entity_type='105') || ($Entity_type='205'))
    {
     
    $web_student=mysql_query("SELECT DISTINCT(ls.entityID) FROM tbl_LoginStatus as ls JOIN tbl_student as s ON ls.EntityID=s.id and ls.school_id=s.school_id JOIN tbl_school_admin as sa ON ls.school_id=sa.school_id where ls.school_id='$school_id' AND ls.LatestLoginTime between '$from_dt' AND '$to_dt' AND (ls.Entity_type='105' OR ls.Entity_type='205') AND ls.LatestMethod='web'");
    $student_web_count=mysql_num_rows($web_student);
    
    $ios_student=mysql_query("SELECT DISTINCT(ls.entityID) FROM tbl_LoginStatus as ls JOIN tbl_student as s ON ls.EntityID=s.id and ls.school_id=s.school_id JOIN tbl_school_admin as sa ON ls.school_id=sa.school_id where ls.school_id='$school_id' AND ls.LatestLoginTime between '$from_dt' AND '$to_dt' AND (ls.Entity_type='105' OR ls.Entity_type='205') AND ls.LatestMethod='iOS'");
    $student_ios_count=mysql_num_rows($ios_student);
    
    $android_student=mysql_query("SELECT DISTINCT(ls.entityID) FROM tbl_LoginStatus as ls JOIN tbl_student as s ON ls.EntityID=s.id and ls.school_id=s.school_id JOIN tbl_school_admin as sa ON ls.school_id=sa.school_id where ls.school_id='$school_id' AND ls.LatestLoginTime between '$from_dt' AND '$to_dt'  AND (ls.Entity_type='105' OR ls.Entity_type='205') AND ls.LatestMethod='Android'");
    $student_android_count=mysql_num_rows($android_student);
  }
// }

// $sqln2="Select school_id,school_name,scadmin_country from tbl_school_admin";
//                                 // echo $sqln2; exit;
//     $sql1 = mysql_query($sqln2);

    $total_teachers = ($teacher_web_count+$teacher_ios_count+$teacher_android_count);
    $total_students = ($student_web_count+$student_ios_count+$student_android_count);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Smart Cookie </title>
<link rel="stylesheet" href="css/bootstrap.min.css">
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css"> -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" />

<style>
.shadow{
   box-shadow: 1px 1px 1px 2px  #428BCA;
}

.shadow:hover{

 box-shadow: 1px 1px 1px 3px  #428BCA;
}
.radius{
    border-radius: 5px;
}
.hColor{
    padding:3px;
    border-radius:5px 5px 0px 0px;
    color:#fff;
    background-color: rgba(105,68,137, 0.8);
}

.detail_color{
   color:#7647a2;
}

.detail_color:hover{
   color:#188e8e;
   font-size: 28px;
}
</style>

</head>
<body>
<div class="container">
  <div class="row">

        <div class="radius" style="height:50px; background-color:#428BCA;" align="center">
          <h2 style="padding-left:20px;padding-top:10px;color:white"> Login-Logout Statistics</h2>
        </div>
  </div>
  
  <div class="row" style="padding-top:10px;">
    <div class="col-md-12" style="padding:20px 0 10px;">
      <form method="post" action="">
      <!--   <div class="col-md-4">
          <label for="type" class ="control-label col-sm-4"> School Name:</label>
          <div class="col-sm-8" id="typeedit">
            <select class="form-control searchselect" name="school_id" id="school_nm" required="required">-->
               <!-- <option value="All" style="text-indent:30%">All</option> -->
             <!--  <option value="0">Select School</option>
              <?php //while ($row = mysql_fetch_array($sql1)){ ?>
                <option <?php //if(isset($_POST['school_id'])){ if($_POST['school_id']==$row['school_id']){ echo "selected"; } }?> value="<?php //echo $row['school_id']; ?>"><?php echo $row['school_name']; ?> (<?php echo $row['school_id']; ?>)</option>
              <?php //} ?>
            </select> 
          </div> 
        </div>-->
        <div class="col-md-3">
          <label for="type" class ="control-label col-sm-3">From Date:</label>
          <div class="col-sm-9" id="typeedit">
          <input type="text" class="form-control datetimepic" name="fromdt" autocomplete="off" id="fromdt" value="<?php if(isset($_POST)){if($f_dt!=""){echo date('d-m-Y H:i',strtotime($f_dt)); }else{ echo $fr_date; }}  else{ echo $fr_date; }  ?>">    
          </div>
        </div>
        <div class="col-md-3">
          <label for="type" class ="control-label col-sm-3">To Date:</label>
          <div class="col-sm-9" id="typeedit">
            <input type="text" class="form-control datetimepic" name="todt" autocomplete="off" id="todt" value="<?php if(isset($_POST)){if($t_dt!=""){echo date('d-m-Y H:i',strtotime($t_dt)); }else{ echo $to_date;}}  else{ echo $to_date;} ?>">    
          </div>
        </div>
        <div class="col-md-2">
          <button class="btn btn-success" type="submit" name="submit"><i class="glyphicon glyphicon-search"></i> Search</button>
        </div>
      </form>
    </div>
    <br>
    <br>
    <div class="col-md-12"><h3 class="text-center"><?= $dataLine; ?></h3></div>
    <div class="clearfix"></div>
    <div class="col-md-12" style="padding-top:20px;">
      <div class="col-sm-1" style="padding-top:20px;" ></div>
      
      <div class="col-md-4 shadow radius" style="background-color:#FFFFFF; border:1px solid #428BCA;">         
                   <!--Teacher Login Logout Details title modified by Pranali -->
          <h4 style="font-size:30px;color:#428BCA;" align="center"><?php echo $dynamic_teacher; ?> Stats</h4>
                        <div class="col-md-12" style="font-size:24px;padding-left:5px; font-weight: 600;">
                            <!-- <a href="<?= $url_teacher_web;?>" class="detail_color" style="text-decoration: none;"> -->
                              <form method="post" class="detail_color" style="cursor: pointer;" action="<?= $url_teacher;?>">
                                <input type="hidden" name="school_id" value="<?= $school_id;?>">
                                <input type="hidden" name="type" value="web">
                                <input type="hidden" name="fd" value="<?php if(isset($_POST)){if($f_dt!=""){echo date('d-m-Y H:i',strtotime($f_dt)); }else{ echo $fr_date; }}  else{ echo $fr_date; } ?>">
                                <input type="hidden" name="td" value="<?php if(isset($_POST)){if($t_dt!=""){echo date('d-m-Y H:i',strtotime($t_dt)); }else{ echo $to_date;}}  else{ echo $to_date;} ?>">
                                <button type="submit" id="teacher_web" style="display: none;"></button>
                              <div class="col-md-12" id="t_web" style="color:#428BCA;">
                                <div class="col-md-6">Web</div>
                                <div class="col-md-6 text-right"><?= $teacher_web_count; ?></div>
                              </div>
                            </form>
                            <!-- </a> -->
                            <!-- <a href="login_logout_teacher.php?type=Android<?php //if($_POST['fromdt']!=''){ echo '&fd='.$_POST['fromdt'].'&td='.$_POST['todt'];}?>" class="detail_color" style="text-decoration: none;"> -->
                            <form method="post" class="detail_color" style="cursor: pointer;" action="<?= $url_teacher;?>">
                             <input type="hidden" name="school_id" value="<?= $school_id;?>">
                              <input type="hidden" name="type" value="Android">
                              <input type="hidden" name="fd" value="<?php if(isset($_POST)){if($f_dt!=""){echo date('d-m-Y H:i',strtotime($f_dt)); }else{ echo $fr_date; }}  else{ echo $fr_date; } ?>">
                              <input type="hidden" name="td" value="<?php if(isset($_POST)){if($t_dt!=""){echo date('d-m-Y H:i',strtotime($t_dt)); }else{ echo $to_date;}}  else{ echo $to_date;} ?>">
                              <button type="submit" id="teacher_Android" style="display: none;"></button>
                              <div class="col-md-12" id="t_Android" style="color:#428BCA;">
                                <div class="col-md-6">Android</div>
                                <div class="col-md-6 text-right"><?= $teacher_android_count; ?></div>
                              </div>
                            </form>
                            </a>
                            <!-- <a href="login_logout_teacher.php?type=iOS<?php if($_POST['fromdt']!=''){ echo '&fd='.$_POST['fromdt'].'&td='.$_POST['todt'];}?>" class="detail_color" style="text-decoration: none;"> -->
                            <form method="post" class="detail_color" style="cursor: pointer;" action="<?= $url_teacher;?>">
                               <input type="hidden" name="school_id" value="<?= $school_id;?>">
                              <input type="hidden" name="type" value="iOS">
                              <input type="hidden" name="fd" value="<?php if(isset($_POST)){if($f_dt!=""){echo date('d-m-Y H:i',strtotime($f_dt)); }else{ echo $fr_date; }}  else{ echo $fr_date; } ?>">
                              <input type="hidden" name="td" value="<?php if(isset($_POST)){if($t_dt!=""){echo date('d-m-Y H:i',strtotime($t_dt)); }else{ echo $to_date;}}  else{ echo $to_date;} ?>">
                              <button type="submit" id="teacher_iOS" style="display: none;"></button>
                              <div class="col-md-12" id="t_iOS" style="color:#428BCA;">
                                <div class="col-md-6">IOS</div>
                                <div class="col-md-6 text-right"><?= $teacher_ios_count; ?></div>
                              </div>
                            </form>
                            <!-- </a> -->

                            <div class="clearfix"></div>
                            <div class="row" style="border: 1px solid #428BCA;"></div>

                            <div class="col-md-12" style="color:#428BCA;">
                              <div class="col-md-6">Total</div>
                              <div class="col-md-6 text-right"><?= $total_teachers; ?></div>
                            </div>
                          </div>

                </div>
 <div class="col-sm-1" style="padding-top:20px;" ></div>
    <div class="col-sm-1" style="padding-top:20px;" ></div>
      <div class="col-md-4 shadow radius" style="background-color:#FFFFFF; border:1px solid #428BCA;">
          <!-- Student Login Logout Details title modified by Pranali -->
                  <h4 style="font-size:30px;color:#428BCA;" align="center"><?php echo $dynamic_student; ?> Stats</h4>
                          <div class="col-md-12" style="font-size:24px;padding-left:5px; font-weight: 600;">
                            <!-- <a href="login_logout_student.php?type=web<?php if($_POST['fromdt']!=''){ echo '&fd='.$_POST['fromdt'].'&td='.$_POST['todt'];}?>" class="detail_color" style="text-decoration: none;"> -->
                             <form method="post" class="detail_color" style="cursor: pointer;" action="<?= $url_student;?>">
                                 <input type="hidden" name="school_id" value="<?= $school_id;?>">
                                <input type="hidden" name="type" value="web">
                                <input type="hidden" name="fd" value="<?php if(isset($_POST)){if($f_dt!=""){echo date('d-m-Y H:i',strtotime($f_dt)); }else{ echo $fr_date; }}  else{ echo $fr_date; } ?>">
                                <input type="hidden" name="td" value="<?php if(isset($_POST)){if($t_dt!=""){echo date('d-m-Y H:i',strtotime($t_dt)); }else{ echo $to_date;}}  else{ echo $to_date;} ?>">
                                <button type="submit" id="student_web" style="display: none;"></button>
                              <div class="col-md-12" id="s_web" style="color:#428BCA;">
                                <div class="col-md-6">Web</div>
                                <div class="col-md-6 text-right"><?= $student_web_count; ?></div>
                              </div>
                            </form>
                            <!-- </a> -->
                            <!-- <a href="login_logout_student.php?type=Android<?php if($_POST['fromdt']!=''){ echo '&fd='.$_POST['fromdt'].'&td='.$_POST['todt'];}?>" class="detail_color" style="text-decoration: none;">   -->
                             <form method="post" class="detail_color" style="cursor: pointer;" action="<?= $url_student;?>">
                                <!-- <input type="hidden" name="school_id" value="<?= $school_id;?>"> -->
                                <input type="hidden" name="type" value="Android">
                                <input type="hidden" name="fd" value="<?php if(isset($_POST)){if($f_dt!=""){echo date('d-m-Y H:i',strtotime($f_dt)); }else{ echo $fr_date; }}  else{ echo $fr_date; } ?>">
                                <input type="hidden" name="td" value="<?php if(isset($_POST)){if($t_dt!=""){echo date('d-m-Y H:i',strtotime($t_dt)); }else{ echo $to_date;}}  else{ echo $to_date;} ?>">
                                <button type="submit" id="student_Android" style="display: none;"></button>
                              <div class="col-md-12" id="s_Android" style="color:#428BCA;">
                                <div class="col-md-6">Android</div>
                                <div class="col-md-6 text-right"><?= $student_android_count; ?></div>
                              </div>
                            </form>
                            <!-- </a> -->
                            <!-- <a href="login_logout_student.php?type=iOS<?php if($_POST['fromdt']!=''){ echo '&fd='.$_POST['fromdt'].'&td='.$_POST['todt'];}?>" class="detail_color" style="text-decoration: none;"> -->
                            <form method="post" class="detail_color" style="cursor: pointer;" action="<?= $url_student;?>">
                                <!-- <input type="hidden" name="school_id" value="<?= $school_id;?>"> -->
                                <input type="hidden" name="type" value="iOS">
                                <input type="hidden" name="fd" value="<?php if(isset($_POST)){if($f_dt!=""){echo date('d-m-Y H:i',strtotime($f_dt)); }else{ echo $fr_date; }}  else{ echo $fr_date; } ?>">
                                <input type="hidden" name="td" value="<?php if(isset($_POST)){if($t_dt!=""){echo date('d-m-Y H:i',strtotime($t_dt)); }else{ echo $to_date;}}  else{ echo $to_date;} ?>">
                                <button type="submit" id="student_iOS" style="display: none;"></button>
                              <div class="col-md-12" id="s_iOS" style="color:#428BCA;">
                                <div class="col-md-6">IOS</div>
                                <div class="col-md-6 text-right"><?= $student_ios_count; ?></div>
                              </div>
                            </form>
                            <!-- </a> -->

                            <div class="clearfix"></div>
                            <div class="row" style="border: 1px solid #428BCA;"></div>
                            
                            <div class="col-md-12" style="color:#428BCA;">
                              <div class="col-md-6">Total</div>
                              <div class="col-md-6 text-right"><?= $total_students; ?></div>
                            </div>
                          </div>

                </div>
    <div class="col-sm-1" style="padding-top:20px;" ></div>
  </div>

</div>
<script src="js/jquery-1.11.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>
<script src='js/bootstrap.min.js' type='text/javascript'></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script src="js/moment.js"></script>
<!-- <script src='js/bootstrap-datepicker.min.js' type='text/javascript'></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $('.searchselect').select2();

    $('#t_web').click(function () {
        $("#teacher_web").trigger( "click" );
    });
    $('#t_Android').click(function () {
        $("#teacher_Android").trigger( "click" );
    });
    $('#t_iOS').click(function () {
        $("#teacher_iOS").trigger( "click" );
    });

    $('#s_web').click(function () {
        $("#student_web").trigger( "click" );
    });
    $('#s_Android').click(function () {
        $("#student_Android").trigger( "click" );
    });
    $('#s_iOS').click(function () {
        $("#student_iOS").trigger( "click" );
    });
  });
</script>
<script src="js/bootstrap-datetimepicker.js"></script>
<script src='js/bootstrap-datepicker.min.js' type='text/javascript'></script>
<script type="text/javascript">
   $(function () {   
            $("#fromdt").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    dateFormat: 'yy-mm-dd HH:mm',
                    endDate: new Date()
                });

                $("#todt").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    dateFormat: 'yy-mm-dd HH:mm',
                    endDate: new Date()
                });

            });
</script>
</body>
</html>