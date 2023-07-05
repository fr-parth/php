<?php
include("groupadminheader.php");
$fr_date = date("d-m-Y H:i",mktime(00,00));//hour, minute, second
 $to_date = date("d-m-Y H:i",mktime(23,59));//hour, minute, second

  $group_member_id = $_SESSION['group_admin_id'];
  // print_r($_POST); exit;
      $type=$_POST['type'];
      if($type=="web"){ $type_nm = "Web";}else if($type=="Android"){ $type_nm = $type;}else{$type_nm="IOS";}
      $sc_id=$_POST['school_id'];
      $school=$_POST['school'];
       $where =  "sa.group_member_id='$group_member_id' AND ls.school_id='$sc_id' AND ls.LatestMethod='$type'";
     if(isset($_POST['type'])){
      $dataLine ="Data of $sc_id";
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
    $student_sql = "SELECT ls.EntityID, s.std_complete_name, ls.FirstLoginTime, ls.LatestLoginTime, ls.LogoutTime, ls.school_id, sa.school_name FROM tbl_LoginStatus as ls JOIN tbl_student as s ON ls.EntityID=s.id and ls.school_id=s.school_id JOIN tbl_school_admin as sa ON ls.school_id=sa.school_id where
 $where AND Entity_type='105' group by ls.EntityID order by ls.LatestLoginTime DESC";
      // echo $student_sql; exit;
    $arr=mysql_query($student_sql);
    $res_count = mysql_num_rows($arr);

    // $arr=mysql_fetch_array($teacher_query);

    // $total_teachers = ($teacher_web_count+$teacher_ios_count+$teacher_android_count);
    
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Smart Cookie </title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="../css/jquery.dataTables.css">
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
}

</style>
</head>
<body>


<div class="container">
  <div class="row">

        <div class="radius" style="height:50px; background-color:#694489;" align="center">
          <h2 style="padding-left:20px;padding-top:10px;color:white"><?= $type_nm; ?> Login-Logout School-wise Student Statistics</h2>
        </div>
  </div>
  
  <div class="row" style="padding-top:10px;">
    <div class="col-md-12" style="padding:20px 0 10px;">
     <!--  <form method="post" action="">
        <input type="hidden" name='type' value="<?= $_POST['type'];?>">
        <input type="hidden" name='school_id' value="<?= $_POST['school_id'];?>">
        <div class="col-md-5">
          <label for="type" class ="control-label col-sm-3">From Date:</label>
          <div class="col-sm-9" id="typeedit">
            <input type="text" class="form-control datetimepic" name="fd" autocomplete="off" id="fromdt">    
          </div>
        </div>
        <div class="col-md-5">
          <label for="type" class ="control-label col-sm-3">To Date:</label>
          <div class="col-sm-9" id="typeedit">
            <input type="text" class="form-control datetimepic" name="td" autocomplete="off" id="todt">    
          </div>
        </div>
        <div class="col-md-2">
          <button class="btn btn-success" type="submit" name="submit">Search</button>
        </div>
      </form> -->
    </div>
    <br>
    <form method="post" class="detail_color" style="cursor: pointer;" action="login_logout_student.php">
      <input type="hidden" name="type" value="<?= $type; ?>" />
      <input type="hidden" name="fd" value="<?=$from_dt;?>" />
      <input type="hidden" name="td" value="<?=$to_dt;?>" />
      <input type="hidden" name="school_id" value="<?= $school;?>">
      <button class="btn btn-info" type="submit"><i class="glyphicon glyphicon-chevron-left"></i>Back to Login-Logout Statistics</button>
    </form>
    <div class="col-md-12"><h3 class="text-center"><?= $dataLine; ?></h3></div>
    <br>
    <div class="clearfix"></div>
    <div class="col-md-12">
      <table class="table-bordered  table-condensed cf" id="example" width="100%;">
                                <thead>
                                <tr style="background-color:#428BCA">
                                <!-- Camel casing done for Sr. No. by Pranali -->
                                    <th style="width:3%;"><b>Sr. No.</b></th>
                                    <th style="width:21%;">Student Name</th>
                                    <th style="width:10%;">School ID</th>
                                    <th style="width:21%;">School Name</th>
                                    <th style="width:15%;">First Login </th>
                                    <th style="width:15%;">Last Login </th>
                                    <th style="width:15%;">Last Logout</th>
                                </tr>
                                </thead>
                                <tbody id="ajaxRecords">
                                <?php
                                    $i= 1;// for serial number
                                    if($res_count>0){
                                    while ($row = mysql_fetch_array($arr)) {
                                      $firstLogin = date("d-m-Y h:i a",strtotime($row['FirstLoginTime']));
                                      if(date("d-m-Y",strtotime($firstLogin))=="01-01-1970"){$firstLogin="";}
                                      $lastLogin = date("d-m-Y h:i a",strtotime($row['LatestLoginTime']));
                                      if(date("d-m-Y",strtotime($lastLogin))=="01-01-1970"){$lastLogin="";}
                                      $logout = date("d-m-Y h:i a",strtotime($row['LogoutTime']));
                                      if(date("d-m-Y",strtotime($logout))=="01-01-1970"){$logout="";}
                                    ?>
                                      <tr style="color:#808080;" class="active s_web detail_color">
                                        <td data-title="Sr.No"><b><?php echo $i; ?></b></td>
                                        <td data-title="student_name"><b><?php echo $row['std_complete_name']; ?></b></td>
                                        <td data-title="school_id"><b><?php echo $row['school_id']; ?></b></td>
                                        <td data-title="school_name"><b><?php echo $row['school_name']; ?></b></td>
                                        <td data-title="First"><?php echo $firstLogin; ?></td>
                                        <td data-title="Last"><?php echo $lastLogin; ?></td>
                                        <td data-title="logout"><?php echo $logout; ?></td>
                                      </tr>
                                    <?php $i++; } }else{
                                      echo '<tr><td class="text-center" colspan="7">No Data Found</td></tr>';
                                    } ?>
                                </tbody>
                            </table>
    </div>
</div>
<script src="../js/jquery-1.11.1.min.js"></script>
<script src="../js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>
<script src='../js/bootstrap.min.js' type='text/javascript'></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script src="../js/moment.js"></script>
<script src="../js/bootstrap-datetimepicker.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $('.searchselect').select2();
     $('#example').dataTable({}); 
  });
</script>
<script type="text/javascript">
    $(function () {
        $('#fromdt').datetimepicker({
          format:'DD-MM-YYYY HH:mm',
          stepping: 15,
          maxDate: moment().add(+0, 'days')
        });
        $('#todt').datetimepicker({
          format:'DD-MM-YYYY HH:mm',
          stepping: 15,
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
</script>
<script type="text/javascript">
  $(document).ready(function() {

    $('.s_web').click(function () {
        $(".student_web").trigger( "click" );
    });

  });
</script>
</body>
</html>