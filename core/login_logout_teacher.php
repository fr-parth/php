<?php
include("cookieadminheader.php");
 $fr_date = date("d-m-Y H:i",mktime(00,00));//hour, minute, second
 $to_date = date("d-m-Y H:i",mktime(23,59));//hour, minute, second
  $group_member_id = $_SESSION['group_admin_id'];
  // print_r($_POST); exit;
      $type=$_POST['type'];
       $from_date=$_POST['from_date'];
        $to_date=$_POST['to_date'];
      if($type=="web"){ $type_nm = "Web";}else if($type=="Android"){ $type_nm = $type;}else{$type_nm="IOS";}
       $where =  "sa.group_member_id='$group_member_id' AND ls.LatestMethod='$type'";
     if(isset($_POST['type'])){
      $dataLine ="Data of ";
      if($_POST['school_id']==""){$_POST['school_id']='0';}
        $school_id = $_POST['school_id'];
        if($school_id!="0"){
          $where .= " AND ls.school_id='$school_id'";
          $dataLine .= " $school_id";
        }
      
      // print_r($_POST); exit;
      $f_dt = $_POST['fd'];
      $t_dt = $_POST['td'];
      if($f_dt!="" && $t_dt!=""){
        $from_dt = date('Y-m-d H:i',strtotime($f_dt));
        $to_dt = date('Y-m-d H:i',strtotime($t_dt));
        $where .= " AND ls.LatestLoginTime between '$from_dt' AND '$to_dt'";
        $dataLine .= " Date ".date('d-m-Y H:i',strtotime($f_dt))." - ".date('d-m-Y H:i',strtotime($t_dt));
      }else{
      $current_dt = date("Y-m-d");
      $where .= " AND date_format(ls.LatestLoginTime,'%Y-%m-%d')='$current_dt'";
      }
    }else{
      $current_dt = date("Y-m-d");
      $where .= " AND date_format(ls.LatestLoginTime,'%Y-%m-%d')='$current_dt'";
      }
    
    $teacher_sql = "SELECT count(DISTINCT(ls.EntityID)) as cnt, ls.school_id, sa.school_name FROM tbl_LoginStatus as ls JOIN tbl_teacher as t ON ls.EntityID=t.id and ls.school_id=t.school_id JOIN tbl_school_admin as sa ON ls.school_id=sa.school_id where ls.school_id='$school_id' AND (ls.Entity_type='103' OR ls.Entity_type='203') AND LatestMethod='$type_nm' AND ls.LatestLoginTime between '$from_dt' AND '$to_dt' group by ls.school_id order by sa.school_name";
 $arr=mysql_query($teacher_sql);
 //  echo $teacher_sql; //exit;
    
    // $arr=mysql_fetch_array($teacher_query);

     $total_teachers = ($teacher_web_count+$teacher_ios_count+$teacher_android_count);
    
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Smart Cookie </title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" />

<style>
.shadow{
   box-shadow: 1px 1px 1px 2px  #694489;
}

.shadow:hover{

 box-shadow: 1px 1px 1px 3px  #694489;
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

.detail_color td{
   color:#7647a2;
   cursor: pointer;
}

.detail_color td:hover{
   color:#188e8e;
   font-size: 20px;
}
</style>
</head>
<body>


<div class="container">
  <div class="row">

        <div class="radius" style="height:50px; background-color:#694489;" align="center">
          <h2 style="padding-left:20px;padding-top:10px;color:white"><?= $type_nm; ?> Login-Logout School-wise Teachers Statistics</h2>
        </div>
  </div>
  
  <div class="row" style="padding-top:10px;">
    <div class="col-md-12" style="padding:20px 0 10px;">
      <form method="post" action="">
        <input type="hidden" name='type' value="<?= $_POST['type'];?>">
        <input type="hidden" name="school_id" value="<?= $school_id;?>">
        <div class="col-md-5">
          <label for="type" class ="control-label col-sm-3">From Date:</label>
          <div class="col-sm-9" id="typeedit">
            <input type="text" class="form-control datetimepic" autocomplete="off" name="fd" id="fromdt" value="<?php if(isset($_POST)){if($f_dt!=""){echo date('d-m-Y H:i',strtotime($f_dt)); }else{ echo $fr_date; }}  else{ echo $fr_date; } ?>">    
          </div>
        </div>
        <div class="col-md-5">
          <label for="type" class ="control-label col-sm-3">To Date:</label>
          <div class="col-sm-9" id="typeedit">
            <input type="text" class="form-control datetimepic" name="td" autocomplete="off" id="todt" value="<?php if(isset($_POST)){if($t_dt!=""){echo date('d-m-Y H:i',strtotime($t_dt)); }else{ echo $to_date;}}  else{ echo $to_date;}  ?>">    
          </div>
        </div>
        <div class="col-md-2">
          <button class="btn btn-success" type="submit" name="submit">Search</button>
        </div>
      </form>
    </div>
    <br>
    <form method="post" class="detail_color" style="cursor: pointer;" action="loginlogoutStatusCookie.php">
      <input type="hidden" name="fromdt" value="<?=$from_dt;?>" />
      <input type="hidden" name="todt" value="<?=$to_dt;?>" />
      <input type="hidden" name="school_id" value="<?= $school_id;?>">
      <button class="btn btn-info" type="submit" style="background-color:#694489;"><i class="glyphicon glyphicon-chevron-left"></i>Back to Login-Logout Statistics</button>
    </form>
    <div class="col-md-12"><h3 class="text-center"><?= $dataLine; ?></h3></div>
    <br>
    <div class="clearfix"></div>
    <div class="col-md-12">
      <table class="table-bordered  table-condensed cf" id="example" width="100%;">
                                <thead>
                                <tr style="background-color:#694489;color:white;">
                                <!-- Camel casing done for Sr. No. by Pranali -->
                                    <th style="width:3%;"><b>Sr. No.</b></th>
                                    <th style="width:15%;">School Name</th>
                                    <th style="width:15%;">School ID</th>
                                    <th style="width:8%;">Total count</th>
                                </tr>
                                </thead>
                                <tbody id="ajaxRecords">
                                <?php
                                    $i= 1;// for serial number
                                    while ($row = mysql_fetch_array($arr)) {
                                    ?>
                                    <form method="post" class="detail_color" style="cursor: pointer;" action="Login_logout_school_teacher.php">
                                      <input type="hidden" name="school_id" value="<?= $row['school_id']; ?>" />
                                      <input type="hidden" name="type" value="<?= $type; ?>">
                                      <input type="hidden" name="fd" value="<?=$from_dt;?>">
                                      <input type="hidden" name="td" value="<?=$to_dt;?>">
                                      <input type="hidden" name="school" value="<?= $_POST['school_id']; ?>" >
                                      <button type="submit" id="teacher_web<?= $i;?>" style="display: none;"></button>
                                      <tr style="color:#808080;" class="active detail_color" onclick="teacher_web(<?= $i;?>);">
                                          <td data-title="Sr.No"><b><?php echo $i; ?></b></td>
                                          <td data-title="school_name"><b><?php echo $row['school_name']; ?></b></td>
                                          <td data-title="school_id"><b><?php echo $row['school_id']; ?></b></td>
                                          <td data-title="cnt"><?php echo $row['cnt']; ?></td>
                                      </tr>
                                    </form>
                                    <?php $i++; } ?>
                                </tbody>
                            </table>
    </div>
</div>
<script src="../js/jquery-1.11.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>
<script src='../js/bootstrap.min.js' type='text/javascript'></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script src="js/moment.js"></script>
<script src="js/bootstrap-datetimepicker.js"></script>
<script src='js/bootstrap-datepicker.min.js' type='text/javascript'></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $('.searchselect').select2();
  });
</script>
<script type="text/javascript">
    $(function () {
        $('#fromdt').datetimepicker({
          format:'DD-MM-YYYY HH:mm',
          //stepping: 15,
          maxDate: moment().add(+0, 'days'),
          useCurrent: false
        }).datetimepicker('setdate','0');;
        $('#todt').datetimepicker({
          format:'DD-MM-YYYY HH:mm',
          //stepping: 15,
          maxDate: moment().add(30, 'days'),
          useCurrent: false //Important! See issue #1075
        });
        $("#fromdt").on("dp.change", function (e) {
            $('#todt').data("DateTimePicker").minDate(e.date);
            $('#todt').data("DateTimePicker").maxDate(moment(e.date).add(30, 'days'));
           
            // $(this).datetimepicker('hide');
        });
        $("#todt").on("dp.change", function (e) {
            $('#fromdt').data("DateTimePicker").maxDate(e.date);
            // $(this).datetimepicker('hide');

        });
    });
    function teacher_web(i) {
        $("#teacher_web"+i).trigger( "click" );
    }
</script>
</body>
</html>