<?php
include("groupadminheader.php");
error_reporting(0);
$group_member_id = $_SESSION['group_admin_id'];
// $query = "select * from `tbl_school_admin` where id='$id'";       // uploaded by
// $row1 = mysql_query($query);
// $value1 = mysql_fetch_array($row1);
// $uploaded_by = $value1['name'];
// $smartcookie = new smartcookie();
// $id = $_SESSION['id'];
// $fields = array("id" => $id);
// $table = "tbl_school_admin";
// $smartcookie = new smartcookie();
// $results = $smartcookie->retrive_individual($table, $fields);
// $result = mysql_fetch_array($results);
// $sc_id = $result['school_id'];
$res = mysql_query("select id,type,email_body from tbl_email_sms_templates");
$res1 = mysql_query("select e_id,email_id from tbl_email_parameters");
    // $sqln1 = "SELECT t.id,t.t_id,t.t_complete_name,t.t_phone,t.t_email,t.t_internal_email,t.batch_id,t.send_unsend_status,t.email_status,t.school_id,t.t_country,t.sms_time_log,t.email_time_log, t.t_dept, sa.school_name FROM tbl_teacher t LEFT JOIN tbl_school_admin sa ON t.school_id=sa.school_id WHERE sa.group_member_id='$group_member_id' AND t.t_emp_type_pid IN ('133','134') AND t.error_records LIKE 'Correct'";
$teacher_grp ="'133','134','135','137','139','141','143'";

    if(isset($_POST['submit'])){
        if($_POST['dept_id']==""){$_POST['dept_id']="0";}
        if($_POST['school_id']==""){$_POST['school_id']="0";}
        $School_id = $_POST['school_id'];
        $check=$_POST['email_st'];
        $group_name1 = $_POST['group_name'];
       $group_nm=explode(',' , $group_name1);
       $group_name = $group_nm[1]; 
       $group_member_id=$group_nm[0];

        if($_POST['startlmt']!="" && $_POST['endlmt']!=""){
            $start=((int)$_POST['startlmt']-1);
            $end=((int)$_POST['endlmt']-((int)$start));
            $Limit= "LIMIT ".$start.",".$end;
        }
        else if($_POST['startlmt']!="" && $_POST['endlmt']==""){
            $Limit= "LIMIT ".$_POST['startlmt'];
        }
        else{$Limit= "";}

        if($check != "No"){
            if($_POST['dept_id']!="0"){
                $dept = $_POST['dept_id'];
                
                $sqln1 = "SELECT t.id,t.t_id,t.t_complete_name,t.t_phone,t.t_email,t.t_internal_email,t.batch_id,t.send_unsend_status,t.email_status,t.school_id,t.t_country,t.sms_time_log,t.email_time_log, t.t_dept, sa.school_name FROM tbl_teacher t LEFT JOIN tbl_school_admin sa ON t.school_id=sa.school_id 
                join tbl_group_school gs on gs.school_id=sa.school_id
                WHERE  sa.school_id='$School_id' AND gs.group_member_id='$group_member_id' AND t.t_dept='$dept' AND t.t_emp_type_pid IN ($teacher_grp) AND t.error_records LIKE 'Correct' ORDER BY t.id $Limit";
            }else if($School_id!="0"){
                $sqln1 = "SELECT t.id,t.t_id,t.t_complete_name,t.t_phone,t.t_email,t.t_internal_email,t.batch_id,t.send_unsend_status,t.email_status,t.school_id,t.t_country,t.sms_time_log,t.email_time_log, t.t_dept, sa.school_name FROM tbl_teacher t LEFT JOIN tbl_school_admin sa ON t.school_id=sa.school_id 
                join tbl_group_school gs on gs.school_id=sa.school_id
                WHERE  sa.school_id='$School_id' AND gs.group_member_id='$group_member_id' AND t.t_emp_type_pid IN ($teacher_grp) AND t.error_records LIKE 'Correct' ORDER BY t.id $Limit";
            }else{
                $sqln1 = "SELECT t.id,t.t_id,t.t_complete_name,t.t_phone,t.t_email,t.t_internal_email,t.batch_id,t.send_unsend_status,t.email_status,t.school_id,t.t_country,t.sms_time_log,t.email_time_log, t.t_dept, sa.school_name FROM tbl_teacher t LEFT JOIN tbl_school_admin sa ON t.school_id=sa.school_id 
                join tbl_group_school gs on gs.school_id=sa.school_id
                WHERE gs.group_member_id='$group_member_id' AND t.t_emp_type_pid IN ($teacher_grp) AND t.error_records LIKE 'Correct' ORDER BY t.id $Limit";
            }
        }else{
            if($_POST['dept_id']!="0"){
                $dept = $_POST['dept_id'];
                $sqln1 = "SELECT t.id,t.t_id,t.t_complete_name,t.t_phone,t.t_email,t.t_internal_email,t.batch_id,t.send_unsend_status,t.email_status,t.school_id,t.t_country,t.sms_time_log,t.email_time_log, t.t_dept, sa.school_name FROM tbl_teacher t LEFT JOIN tbl_school_admin sa ON t.school_id=sa.school_id 
                join tbl_group_school gs on gs.school_id=sa.school_id
                WHERE  sa.school_id='$School_id' AND gs.group_member_id='$group_member_id' AND t.t_dept='$dept' AND t.t_emp_type_pid IN ($teacher_grp) AND t.email_status = 'Unsend' AND t.error_records LIKE 'Correct' ORDER BY t.id $Limit";
            }else if($School_id!="0"){
              $sqln1 = "SELECT t.id,t.t_id,t.t_complete_name,t.t_phone,t.t_email,t.t_internal_email,t.batch_id,t.send_unsend_status,t.email_status,t.school_id,t.t_country,t.sms_time_log,t.email_time_log, t.t_dept, sa.school_name FROM tbl_teacher t LEFT JOIN tbl_school_admin sa ON t.school_id=sa.school_id
              join tbl_group_school gs on gs.school_id=sa.school_id
               WHERE sa.school_id='$School_id' AND gs.group_member_id='$group_member_id' AND t.t_emp_type_pid IN ($teacher_grp) AND t.email_status = 'Unsend' AND t.error_records LIKE 'Correct' ORDER BY t.id $Limit";
            }else{
                $sqln1 = "SELECT t.id,t.t_id,t.t_complete_name,t.t_phone,t.t_email,t.t_internal_email,t.batch_id,t.send_unsend_status,t.email_status,t.school_id,t.t_country,t.sms_time_log,t.email_time_log, t.t_dept, sa.school_name FROM tbl_teacher t LEFT JOIN tbl_school_admin sa ON t.school_id=sa.school_id join tbl_group_school gs on gs.school_id=sa.school_id
                                WHERE gs.group_member_id='$group_member_id' AND t.t_emp_type_pid IN ($teacher_grp) AND t.email_status = 'Unsend' AND t.error_records LIKE 'Correct' ORDER BY t.id $Limit";
            }
        }
    }
  //  echo $sqln1;

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<link rel="stylesheet" href="../css/bootstrap.min.css">
<script src="../js/jquery-1.11.1.min.js"></script>
<script src="../js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css" href="../css/jquery.dataTables.css">
<script src="../js/select2.min.js"></script>
<script src='../js/bootstrap.min.js' type='text/javascript'></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.cs">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<link href="../css/select2.min.css" rel="stylesheet" />
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

    /*for loader*/
    .loader {
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid #3498db;
  width: 120px;
  height: 120px;
  -webkit-animation: spin 2s linear infinite; /* Safari */
  animation: spin 2s linear infinite;
}

/* Safari */
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
    
</style>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Smart Cookie:Send SMS/EMAIL</title>
    
    <style type="text/css">
  .popup {
    width:200px;
    height:100px;
    position:absolute;
    top:50%;
    left:50%;
    margin:-50px 0 0 -100px; /* [-(height/2)px 0 0 -(width/2)px] */
    display:none;
  }
</style>
</head>
<script>
function callajax(check){
    var msgid = $('#preview').val();
        if(msgid == "" || msgid == "0")
        {
            alert("Please select message to send!!");
            $("#preview").focus();
            return false;
        }
        var mail = $("#emailtype").val();
        if(mail == "" || mail == "0")
        {
            alert("Please select Sender Id to send e-mail!!");
            $("#emailtype").focus();
            return false;
        }
    var base_url = "<?php echo $GLOBALS['URLNAME'];?>";
    // var check = check;
    var check = $('#email_st').val();
    var school_id = "<?php echo $School_id; ?>";
    var dept = $('#dept_nm').val();
    var start = "<?php echo $start; ?>";
    var end = "<?php echo $end; ?>";
    var grp_id = "<?php echo $group_member_id; ?>";
    $.ajax({
    url: base_url + "/core/SendEmail_toAll_dept_teacher.php",
    type:'POST',
    data:({ check:check,
            school_id:school_id,
            t_dept:dept,
            msgid:msgid,
            email:mail,
            startlmt:start,
            endlmt:end,
            gp_id:grp_id
            }),
    beforeSend: function(){
     $('#ResultModal').modal({show: true, backdrop: 'static', keyboard: false});
   },
    success: function(result){
    $('#ResultModal').modal('hide');
      if(result){  
        alert(result);
      }
      else {
        alert('Error In Sending Mail');
      }
    }
    })
};

function callajaxSMS(check){
    var msgid = $('#preview').val();
        // if(msgid == "" || msgid == "0")
        // {
        //     alert("Please select message to send!!");
        //     $("#preview").focus();
        //     return false;
        // }
    var base_url = "<?php echo $GLOBALS['URLNAME'];?>";
    // var check = check;
    var grp_id = "<?php echo $group_member_id; ?>";
    var check = $('#email_st').val();
    var school_id = "<?php echo $School_id; ?>";
    var dept = $('#dept_nm').val();
    var start = $('#startlmt').val();
    var end = "<?php echo $end; ?>";
    console.log(msgid)
    console.log(school_id)
    console.log(start)
    console.log(end)
    $.ajax({
    url: base_url + "/core/SendSMS_toAll_dept_teacher.php",
    type:'POST',
    data:({ check:check,
            school_id:school_id,
            t_dept:dept,
            msgid:msgid,
            // email:mail,
            gp_id:grp_id,
            startlmt:start,
            endlmt:end
            }),
    beforeSend: function(){
     $('#ResultModal').modal({show: true, backdrop: 'static', keyboard: false});
   },
    success: function(result){
    $('#ResultModal').modal('hide');
      if(result){  
        alert(result);
      }
      else {
        alert('Error In Sending SMS');
      }
    }
    })
}
function send_to_all() {
    var check = "Yes";
    callajax(check);
}

function send_to_unsend() {
    var check = "No";
    // callajax(check);
}

function send_SMS_to_all() {
    var check = "Yes";
    callajaxSMS(check);
}

function send_SMS_to_unsend() {
    var check = "No";
    // callajax(check);
}
</script>
<body bgcolor="#CCCCCC">

<div style="bgcolor:#CCCCCC">
    <div class="container-fluid" style="padding:30px;width:1152px">
        <div class="modal fade" id="ResultModal" tabindex="0" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
           <div class="modal-dialog modal-lg">
              <div class="modal-content">
               <div class="modal-header">
                <h4 class="modal-title">Wait for Response</h4>
               </div>
               <div class="modal-body" style="overflow-x: scroll;">
                  <!-- <p>If you want to send email to All then click "Yes". <br> -->
                  <!-- If you want to send mail only to unsent users then click "NO"  ?</p> -->
                  <div class="loader"></div>
               </div>
            </div>
           </div>
         </div>

          <div class="modal fade" id="MyModal" tabindex="0" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
           <div class="modal-dialog modal-lg">
              <div class="modal-content">
               <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                 <h4 class="modal-title">Send Email To All</h4>
               </div>
               <div class="modal-body" style="overflow-x: scroll;">
                  <!-- <p>If you want to send email to All then click "Yes". <br> -->
                  <!-- If you want to send mail only to unsent users then click "NO"  ?</p> -->
                  <p>Do You really want to send E-mail</p>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-info" data-dismiss="modal" id="Yes" onclick = "send_to_all()">Yes</button>
                  <button type="button" class="btn btn-default" data-dismiss="modal" id="No" onclick = "send_to_unsend()">No</button>
                </div>
            </div>
           </div>
         </div>
         <div class="modal fade" id="MyMSGModal" tabindex="1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
           <div class="modal-dialog modal-lg">
              <div class="modal-content">
               <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                 <h4 class="modal-title">Send SMS To All</h4>
               </div>
               <div class="modal-body" style="overflow-x: scroll;">
                  <!-- <p>If you want to send SMS to All then click "Yes". <br> -->
                  <!-- If you want to send SMS only to unsent users then click "NO"  ?</p> -->
                  <p>Do You really want to send SMS</p>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-info" data-dismiss="modal" id="Yes" onclick = "send_SMS_to_all()">Yes</button>
                  <button type="button" class="btn btn-default" data-dismiss="modal" id="No" onclick = "send_SMS_to_unsend()">No</button>
                  <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">Cancel</button> -->
                </div>
            </div>
           </div>
         </div>
        <div style="border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">
            <div style="background-color:#F8F8F8 ;">
                <div class="row">
                    <div style="color:#700000 ;padding:5px;" >
                        <div class="col-md-4">
                        
                        <!-- <a href="SendSMS_toAll_dept_teacher.php?school_id=<?php echo $School_id;?>&country=<?php echo $country;?>"> <img src="../Images/Sms.png"></a> -->
                        <a class="btn btn-lg" data-toggle="modal" data-target="#myMSGModal" id="openMSGmodal"> <img src="../Images/Sms.png"></a>
                        <a class="btn btn-lg" data-toggle="modal" data-target="#myModal" id="openmodal" > <img src="../Images/Email.png"></a>
                         </div>
                      
                        <div class="col-md-6 " align="center">
                            <h2>Send SMS/EMAIL to <?php echo $dynamic_teacher;?></h2>
                        </div>
                         </div>
                         
                     </div>
               
                <div class="clearfix"></div>
                <br>
                
                <form method="post" id="myform">
                    <div class="row">
                      <div class="col-md-4">
                              <div class="form-group">
                                  <label for="type" class ="control-label col-sm-4">Select Group:</label>
              
                                <div class="col-sm-8">
                                  <select name="group_name" id="group_name" class="searchselect form-control">
                                  <option value="" disabled selected> Select Group</option>
                                  <?php 
                                    if(isset($_POST['group_name']))
                                    {?>
                                      <option value="<?php echo $group_member_id.','.$group_name; ?>"selected><?php if($group_name!=''){ echo $group_name ;} else{ echo "All" ;} ?></option>
                                   <?php  } ?>
                                  <?php
                                  $gp = mysql_query("SELECT distinct(group_member_id),group_mnemonic_name FROM tbl_group_school where group_mnemonic_name!=''");
                                  while($rr = mysql_fetch_array($gp)){?>
                                  <option value="<?php echo $rr['group_member_id'].','.$rr['group_mnemonic_name'] ?>"><?php echo $rr['group_mnemonic_name'] ?></option>
                                    <?php } ?>
                                  </select>
                              </div>

                            </div> 
                          </div>
                        <div class="col-md-4">
                               <label for="type" class ="control-label col-sm-4"> Select School:</label>
                                <div class="col-sm-8" id="typeedit">

                                <?php $sqln2="Select DISTINCT(tsa.school_id) as school_id,tsa.school_id,tsa.school_name,tsa.scadmin_country from tbl_school_admin tsa 
                                inner join tbl_group_school tgs on tsa.school_id=tgs.school_id where tgs.group_member_id='$group_member_id' group by tsa.school_id";
                                // echo $sqln2; exit;

                                 $sql1 = mysql_query($sqln2); ?>
                                
                                <!-- style="margin-left:500px;" added in below <ul> by Pranali  -->
                                    <select class="form-control searchselect" name="school_id" id="school_nm" required="required">
                                        <option value="0">Select School</option>
                                        <!-- <?php while ($row = mysql_fetch_array($sql1)){ ?>
                                        <option <?php if(isset($_POST['school_id'])){ if($_POST['school_id']==$row['school_id']){ echo "selected"; } }?> value="<?php echo $row['school_id']; ?>"><?php echo $row['school_name']." (".$row['school_id'].")"; ?></option>
                                        <?php } ?> -->
                                    </select>
                                </div>
                        </div>
                      

                        <div class="col-md-4">
                                <label for="type" class ="control-label col-sm-4"> Select Department:</label>
                                <div class="col-sm-8" id="typeedit">
                                <select class="form-control" name="dept_id" id="dept_nm">
                                    <?php if(isset($_POST['school_id'])){
                                        $sqld1 = mysql_query("Select DISTINCT(t.batch_id) as batch_id,t.batch_id,t.t_dept,t.school_id,t.send_unsend_status,t.t_country from tbl_teacher t inner join tbl_group_school tgs on t.school_id=tgs.school_id where tgs.school_id='".$_POST["school_id"]."' and t_dept!='' group by t.t_dept"); ?>
                                        <option value="0">Select Department</option>

                                    <?php while ($rowd = mysql_fetch_array($sqld1)){ ?>
                                        <option <?php if($_POST['dept_id']!="0"){ if($_POST['dept_id']==$rowd['t_dept']){ echo "selected"; } }?> value="<?php echo $rowd['t_dept']; ?>"><?php echo $rowd['t_dept']; ?></option>
                                        <?php } } else{ ?>
                                        <option value="">Please select School first</option>
                                    <?php } ?>
                                    </select>
                                </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="type" class ="control-label col-sm-4"> Send To:</label>
                                <div class="col-sm-8" id="typeedit">
                                <select class="form-control" name="email_st" id="email_st">
                                    <option <?php if(isset($_POST['email_st'])){ if($_POST['email_st']=="Yes"){ echo "selected"; } }?> value="Yes">All Teachers</option>
                                    <option <?php if(isset($_POST['email_st'])){ if($_POST['email_st']=="No"){ echo "selected"; } }?> value="No">Unsent Teachers</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="type" class ="control-label col-sm-6">Start From:</label>
                            <div class="col-sm-6" id="typeedit">
                                <input type="number" class="form-control" name="startlmt" id="startlmt" <?php if(isset($_POST['startlmt'])){ echo "value=".$_POST['startlmt']; }?> min="1">    
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="type" class ="control-label col-sm-6">End At:</label>
                            <div class="col-sm-6" id="typeedit">
                                <input type="number" class="form-control" name="endlmt" id="endlmt" <?php if(isset($_POST['endlmt'])){ echo "value=".$_POST['endlmt']; }?> min="1">    
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-success" type="submit" name="submit">Search</button>
                        </div>
                    </div>
                </form>
                <br>
                    <div class="row">
                        <div class="col-md-7">
                            <div class="form-group">
                                <label for="type" class ="control-label col-sm-4">Select Message to Send<span style="color:red;">*</span>:</label>
                                <div class="col-sm-8" id="typeedit">
                                  <select class="form-control" name="type" id="preview" required>
                                    <option value="">Select Id</option>
                                    <?php while($row= mysql_fetch_array($res)){ ?>
                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['type']; ?></option>
                                    <?php } ?>
                                  </select>
                                </div>
                            </div> 
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="type" class ="control-label col-sm-4">Select Email-ID<span style="color:red;">*</span>:</label>
                                <div class="col-sm-8" id="typeedit">
                                  <select class="form-control" name="emailtype" id="emailtype" required>
                                    <option value="">Select Id</option>
                                    <?php while($row= mysql_fetch_array($res1)){ ?>
                                    <option value="<?php echo $row['e_id']; ?>"><?php echo $row['email_id']; ?></option>
                                    <?php } ?>
                                  </select>
                                </div>
                            </div> 
                        </div>
                    </div>  
                    <div class="row" style="padding:10px;">
                        <div class="col-md-12  " id="no-more-tables">
                            <table class="table-bordered  table-condensed cf" id="example" width="100%;">
                                <thead>
                                <tr style="background-color:#428BCA">
                                <!-- Camel casing done for Sr. No. by Pranali -->
                                    <th style="width:3%;"><b>Sr. No.</b></th>
                                    <th style="width:10%;"><b><?php echo $dynamic_teacher;?> ID</b></th>
                                    <th style="width:15%;">Name/Phone No.</th>
                                    <th style="width:15%;">Email ID</th>
                                    <th style="width:15%;">School Name</th>
                                    <th style="width:8%;">Department</th>
                                    <th style="width:8%;">SMS Status</th>
                                    <th style="width:9%;">EMAIL Status</th>
                                    <th style="width:9%;">TimeStamp (SMS/Email)</th> 
                                    <th style="width:8%;">Send SMS/Email</th>
                                </tr>
                                </thead>
                                <tbody id="ajaxRecords">
                                <?php
                                    // define('MAX_REC_PER_PAGE', 100); 
                                    //getting count of total number of rows
                                                      // echo $sqln1; exit;
                                    $i= 1;// for serial number
                                    $arr = mysql_query($sqln1);
                                    while ($row = mysql_fetch_array($arr)) {

                                                    $teacher_id = $row['t_id'];
                                    ?>
    <!--id for tr added by Pranali -->
                                    <tr id ='data<?php echo $teacher_id ?>' style="color:#808080;" class="active">
                                        <td data-title="Sr.No" style="width:4%;"><b><?php echo $i; ?></b></td>
                                        <td data-title="<?php echo $dynamic_teacher;?> ID" style="width:6%;"><b><?php echo $teacher_id; ?></b></td>
                                        <td data-title="First Name" style="width:12%;"><?php echo $row['t_complete_name']."(".$row['t_phone'].")" ?></td>
                                        <td data-title="Email" style="width:10%;word-wrap: break-word;">
                                        <?php  if($row['t_email']=="")
                                        {
                                            echo $row['t_internal_email'];
                                        }
                                        else
                                        {
                                            echo $row['t_email'];
                                            
                                        }?> </td>
                                        
                                        
                                        <td data-title="Batch Id" style="width:6%;"><?php echo $row['school_name']; ?> </td>
                                        
                                        <td data-title="Batch Id" style="width:6%;"><?php echo $row['t_dept']; ?> </td>
                                    
                                        <td data-title="Send/Unsen Status" style="width:5%;"><?php
                                            if ($row['send_unsend_status'] == 'Send_SMS') {
                                                echo 'SMS sent';
                                            } elseif ($row['send_unsend_status'] == 'Unsend') {
                                                echo 'Unsent';
                                            }
                                            ?> </td>
                                        <td data-title="Send/Unsen Status" style="width:5%;"><?php
                                            if ($row['email_status'] == 'Send_Email') {
                                                echo 'Email sent';
                                            }   
                                            elseif ($row['email_status'] == 'Email sent') {
                                                echo 'Email sent';  
                                            } elseif ($row['email_status'] == 'Unsend') {
                                                echo 'Unsent';
                                            }
                                            ?> </td>
                                        <td ><?php echo "SMS :".$row['sms_time_log']."<br>Email :".$row['email_time_log'];?>
                                            
                                        </td>
                                        
                                        <td  data-title="Phone" style="width:10%;"></td>


                                        <img src="../Images/S.png" onclick="confirmSMS('<?php echo $row['school_id']; ?>','<?php if($row['t_email']=="")
                                            {
                                            echo $row['t_internal_email'];
                                            }
                                            else
                                            {
                                            echo $row['t_email'];
                                            } ?>','<?php echo $row['t_phone']; ?>','<?php echo $row['send_unsend_status'];?>','<?php echo $row['t_country']; ?>','<?php echo $teacher_id; ?>','<?php echo $i;?>');" ></td>

                                            <td>
                                        <img src="../Images/E.png" onclick="confirmEmail('<?php echo $row['school_id']; ?>','<?php if($row['t_email']=="")
                                            {
                                            echo $row['t_internal_email'];
                                            }
                                            else
                                            {
                                            echo $row['t_email'];
                                            } ?>','<?php echo $row['t_phone']; ?>','<?php echo $row['email_status'];?>','<?php echo $teacher_id; ?>','<?php echo $i;?>');" >
                                        </td>

                                    </tr>
                                    <?php 
                                    $i++; 
                                     } 
                                     ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <div class="row" style="padding:5px;">
                    <div class="col-md-4">
                    </div>
                    <div class="col-md-3 " align="center">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                    </div>
                </div>
            </div>
        </div>
</body>
<script>
    $(document).ready(function() {
        $('#example').dataTable({});    
 });

 $(document).ready(function(){
     $("#group_name").on('change',function(){
        var base_url = "<?php echo $GLOBALS['URLNAME'];?>";
        var gp_id=$("#group_name").val();
        var grp=gp_id.split(",");
        var grp_id = grp[0];
         $.ajax({
            type: "POST",
                        url: base_url + "/core/group_School_list.php",
                        datatype:'html',
                        data:{group_id:grp_id},
                        success:function(response){
                            //alert(response);
                            $("#school_nm").empty().append(response);
                            // $("#kkkkk").append(response); 
                        
                        },
                        // error:function(a){ alert(a) },
                    // beforeSend: function(b){alert(b)},
                    // complete: function(c){alert(c)}

         })
     })
 })
     
    function confirmation(xxx) {
        var answer = confirm("Are you sure you want to delete?")
        if (answer) {
            window.location = "delete_teacher.php?id=" + xxx;
        }
        else {
        }
    }
    //ajax functionality in confirmEmail() & confirmSMS() done by Pranali
    function confirmEmail(school_id,email,t_phone,Status,teacher_id,i) {
        console.log(teacher_id)
        var base_url = "<?php echo $GLOBALS['URLNAME'];?>";
        var msgid = $('#preview').val();
        var senderid = $('#emailtype').val();
        if(msgid == "" || msgid == "0")
        {
            alert("Please select message to send!!");
            $("#preview").focus();
            return false;
        }
        if(senderid == "" || senderid == "0")
        {
            alert("Please select Sender Id to send e-mail!!");
            $("#emailtype").focus();
            return false;
        }
        if (Status == 'Send_Email') 
            {
                var answer = confirm("Are you sure,do you want to resend Email");
                if (answer) 
                    {
                        $.ajax({
                        type: "POST",
                        url: base_url + "/core/SendEmail_Teacher.php",
                        dataType: 'text',
                        data:{school_id:school_id,email:email,t_phone:t_phone,Status:Status,teacher_id:teacher_id,i:i,msgid:msgid,senderid:senderid},
                        beforeSend: function(){
                             $('#ResultModal').modal({show: true, backdrop: 'static', keyboard: false});
                           },
                        success: function(table){
                            $('#ResultModal').modal('hide');
                             alert('Email Sent Successfully');
                             $('#data'+teacher_id).html(table); 
                               }
                             });
                             return false;
                    }
                    else{
                        }
            }else{
                    var answer = confirm("Do you want to send Email");
                    if (answer) 
                        {
                              $.ajax({
                                type: "POST",
                                url: base_url + "/core/SendEmail_Teacher.php",
                                dataType: 'text',
                                data:{school_id:school_id,email:email,t_phone:t_phone,Status:Status,teacher_id:teacher_id,i:i,msgid:msgid,senderid:senderid},
                                beforeSend: function(){
                                     $('#ResultModal').modal({show: true, backdrop: 'static', keyboard: false});
                                   },
                                success: function(table){
                                    $('#ResultModal').modal('hide');
                                     alert('Email Sent Successfully');
                                     $('#data'+teacher_id).html(table);
                                   }
                                 });
                                 return false;
                        }
                        else{
                            }
            }
    }
    function confirmSMS(school_id,email,t_phone,Status,country,teacher_id,i) {
      var msgid = $('#preview').val();
            var base_url = "<?php echo $GLOBALS['URLNAME'];?>";
        if(Status=='Send_SMS')
            {
                var answer = confirm("Are you sure,do you want to resend SMS");
                if (answer)
                    {
                        $.ajax({
                        type: "POST",
                        url: base_url + "/core/SendSMS_Teacher.php",
                        dataType: 'text',
                        data:{school_id:school_id,email:email,t_phone:t_phone,Status:Status,teacher_id:teacher_id,i:i,country:country,msgid:msgid},
                        success: function(table){
                            alert('SMS Sent Successfully');
                             $('#data'+teacher_id).html(table); 
                           }
                         });
                         return false;
                    }
                    else{     
                        }
            }
            else{
                    var answer = confirm("Do you want to send SMS");
                    if (answer)
                        {
                            $.ajax({
                            type: "POST",
                            url: base_url + "/core/SendSMS_Teacher.php",
                            dataType: 'text',
                            data:{school_id:school_id,email:email,t_phone:t_phone,Status:Status,teacher_id:teacher_id,i:i,country:country,msgid:msgid},
                            success: function(table){
                                alert('SMS Sent Successfully');
                                 $('#data'+teacher_id).html(table); 
                               }
                             });
                             return false;
                        }
                    else{ 
                        }
            }
        }
    
        $('#preview').change(function() {
            var base_url = "<?php echo $GLOBALS['URLNAME'];?>";
            var value = $(this).val();
            //var value = '8';

            $.ajax({
                    type: "POST",
                    url: base_url + '/core/EmailSmsTemplate_ajax.php',
                    data: { id : value,},
                    dataType: "json",
                    cache:false,
                    success: function(data) {
                        $("#getCode").html(data["email_body"]);
                        $("#getCodeModal").modal('show');
                        $("#myModalLabel").html("Subject : " + data["subject"]);
                        
                        }       
                });
        });

        $('#school_nm').change(function() {
            var base_url = "<?php echo $GLOBALS['URLNAME'];?>";
            var value = $(this).val();
            // alert(value);
            //var value = '8';
            $.ajax({
                    type: "POST",
                    url: 'AjaxDepartment.php',
                    data: { school : value},
                    success: function(data) {
                        $("#dept_nm").html(data);
                        
                        }       
                });
        });
        
        $('#openmodal').click(function(){
   $('#MyModal').modal('show');
})
        $('#openMSGmodal').click(function(){
            $('#MyMSGModal').modal('show');
        });

   $(document).ready(function() {
    $('.searchselect').select2();

    <?php if(isset($_POST['submit'])){?>
            var base_url = "<?php echo $GLOBALS['URLNAME'];?>";
            var value =   "<?= $_POST['school_id'];?>";
            //var value = '8';
            
            <?php if($_POST['dept_id']!="0" && $_POST['school_id']!="0"){?>
            var value2 =  "<?= $_POST['dept_id'];?>";
            $.ajax({
                    type: "POST",
                    url: 'AjaxDepartment.php',
                    data: { school : value,dept : value2},
                    success: function(data) {
                        $("#dept_nm").html(data);
                        
                        }       
            });
        <?php }else if($_POST['school_id']!="0"){ ?>
            $.ajax({
                    type: "POST",
                    url: 'AjaxDepartment.php',
                    data: { school : value},
                    success: function(data) {
                        $("#dept_nm").html(data);
                        
                        }       
            });
         <?php } }?>
});
</script>

</html>
<div class="modal fade" id="getCodeModal" tabindex="0" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
       <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
         <h2 class="modal-title" align='center'>Email Message Preview</h2>
         <h4 class="modal-title" id="myModalLabel"> </h4>
       </div>
       <div class="modal-body" id="getCode" style="overflow-x: scroll;">
          //ajax success content here.
       </div>
    </div>
   </div>
 </div>
<style>
.modal fade {
  text-align: center;
}

@media screen and (min-width: 768px) { 
  .modal fade:before {
    display: inline-block;
    vertical-align: middle;
    content: " ";
    height: 100%;
  }
}

.modal-dialog {
  display: inline-block;
  text-align: left;
  vertical-align: middle;
  margin-left: -35%;
  width: 70%;
}
</style>