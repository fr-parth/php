<?php
error_reporting(0);
include("scadmin_header.php");
$id = $_SESSION['id'];
$query = "select * from `tbl_school_admin` where id='$id'";       // uploaded by
$row1 = mysql_query($query);
$value1 = mysql_fetch_array($row1);
$uploaded_by = $value1['name'];
$smartcookie = new smartcookie();
$id = $_SESSION['id'];
$fields = array("id" => $id);
$table = "tbl_school_admin";
$smartcookie = new smartcookie();
$results = $smartcookie->retrive_individual($table, $fields);
$result = mysql_fetch_array($results);
$sc_id = $result['school_id'];
$res = mysql_query("select id,type,email_body from tbl_email_sms_templates");
$res1 = mysql_query("select e_id,email_id from tbl_email_parameters");

$teacher_grp ="'133','134','135','137','139','141','143'";

    $sqln2="Select DISTINCT(batch_id) as batch_id,school_id,send_unsend_status,t_country from tbl_teacher where school_id='$sc_id' AND batch_id!=''  group by batch_id";
                                // echo $sqln2; exit;
    $sql1 = mysql_query($sqln2); 
    
    $sqld1 = mysql_query("Select t_dept,school_id,send_unsend_status,t_country from tbl_teacher where school_id='$sc_id' and t_dept!='' group by t_dept");

    $arrsql="SELECT id,t_id,t_complete_name,t_phone,t_email,t_internal_email,batch_id,send_unsend_status,email_status,school_id,t_country,sms_time_log,email_time_log,t_dept FROM tbl_teacher WHERE school_id='$sc_id' AND t_emp_type_pid IN (teacher_grp) AND error_records LIKE 'Correct' ORDER BY id ";
    
    if(isset($_POST['submit'])){
        $check=$_POST['email_st'];
        if($_POST['startlmt']!="" && $_POST['endlmt']!=""){
            $start=((int)$_POST['startlmt']-1);
            $Limit= "LIMIT ".$start.",".$_POST['endlmt'];
        }
        else if($_POST['startlmt']!="" && $_POST['endlmt']==""){
            $Limit= "LIMIT ".$_POST['startlmt'];
        }
        else{$Limit= "";}

        if($check != "No"){
            if($_POST['dept_id']!="0"){
                $dept = $_POST['dept_id'];
            $arrsql = "SELECT id,t_id,t_complete_name,t_phone,t_email,t_internal_email,batch_id,send_unsend_status,email_status,school_id,t_country,sms_time_log,email_time_log,t_dept FROM tbl_teacher WHERE school_id='$sc_id' AND t_dept='$dept' AND t_emp_type_pid IN ($teacher_grp) AND error_records LIKE 'Correct' ORDER BY id $Limit";
            }else{
                 $arrsql="SELECT id,t_id,t_complete_name,t_phone,t_email,t_internal_email,batch_id,send_unsend_status,email_status,school_id,t_country,sms_time_log,email_time_log,t_dept FROM tbl_teacher WHERE school_id='$sc_id' AND t_emp_type_pid IN ($teacher_grp) AND error_records LIKE 'Correct' ORDER BY id $Limit";
            }
        }
        else{
            if($_POST['dept_id']!="0"){
                $dept = $_POST['dept_id'];
            $arrsql = "SELECT id,t_id,t_complete_name,t_phone,t_email,t_internal_email,batch_id,send_unsend_status,email_status,school_id,t_country,sms_time_log,email_time_log,t_dept FROM tbl_teacher WHERE school_id='$sc_id' AND t_dept='$dept' AND email_status = 'Unsend' AND t_emp_type_pid IN ($teacher_grp) AND error_records LIKE 'Correct' ORDER BY id $Limit";
            }else{
                 $arrsql="SELECT id,t_id,t_complete_name,t_phone,t_email,t_internal_email,batch_id,send_unsend_status,email_status,school_id,t_country,sms_time_log,email_time_log,t_dept FROM tbl_teacher WHERE school_id='$sc_id' AND email_status = 'Unsend' AND t_emp_type_pid IN ($teacher_grp) AND error_records LIKE 'Correct' ORDER BY id $Limit";
            }
        }
    }
    $i=1;
    $arr = mysql_query($arrsql); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<link rel="stylesheet" href="css/bootstrap.min.css">
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
<script src='js/bootstrap.min.js' type='text/javascript'></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.cs">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
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
    .dropdown-menu {
        margin-left: 0px;
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
    var school_id = "<?= $sc_id;?>";
    var dept = $('#dept_nm').val();
    var start = $('#startlmt').val();
    var end = $('#endlmt').val();
    $.ajax({
    url: base_url + "/core/SendEmail_toAll_dept_teacher.php",
    type:'POST',
    data:({ check:check,
            school_id:school_id,
            t_dept:dept,
            msgid:msgid,
            email:mail,
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
        alert('Error In Sending Mail');
      }
    }
    })
};

function callajaxSMS(check){
    var msgid = $('#preview').val();
        if(msgid == "" || msgid == "0")
        {
            alert("Please select message to send!!");
            $("#preview").focus();
            return false;
        }
        // var mail = $("#emailtype").val();
        // if(mail == "" || mail == "0")
        // {
        //     alert("Please select Sender Id to send e-mail!!");
        //     $("#emailtype").focus();
        //     return false;
        // }
    var base_url = "<?php echo $GLOBALS['URLNAME'];?>";
    // var check = check;
    var check = $('#email_st').val();
    var school_id = "<?= $sc_id;?>";
    var dept = $('#dept_nm').val();
    var start = $('#startlmt').val();
    var end = $('#endlmt').val();
    $.ajax({
    url: base_url + "/core/SendSMS_toAll_dept_teacher.php",
    type:'POST',
    data:({ check:check,
            school_id:school_id,
            t_dept:dept,
            msgid:msgid,
            // email:mail,
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
                    <div class="col-md-3 " style="color:#700000 ;padding:5px;">&nbsp;&nbsp;&nbsp;&nbsp;
                        <!--<a href="teacher_setup.php">   <input type="submit" class="btn btn-primary" name="submit" value="Add Teacher" style="width:150;font-weight:bold;font-size:14px;"/></a>-->
                        <a class="btn btn-lg" data-toggle="modal" data-target="#myMSGModal" id="openMSGmodal"> <img src="Images/Sms.png"></a>
                        <!-- <a href="SendSMS_toAll_dept_teacher.php?school_id=<?php echo $sc_id;?>&country=<?php echo $country;?>"> <img src="Images/Sms.png"></a> -->
                        <a class="btn btn-lg" data-toggle="modal" data-target="#myModal" id="openmodal" > <img src="Images/Email.png"></a>
                    </div>
                    <div class="col-md-6 " align="center">
                        <h2>Send SMS/EMAIL to <?php echo $dynamic_teacher;?></h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-offset-4 col-md-4 col-md-offset-4">
                        <div class="dropdown1">
                            <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">Send SMS/ Email to <?php echo $dynamic_teacher;?><span class="caret"></span></button>
                            <ul class="dropdown-menu " role="menu" aria-labelledby="dropdownMenu1" style="margin-left:50px;">
                                <li role="presentation"><a role="menuitem" tabindex="-1" href="Send_Msg_Teacher.php"><?php echo $dynamic_teacher;?></a></li>
                                <li role="presentation"><a role="menuitem" tabindex="-1" href="Send_Msg_Student.php"><?php echo $dynamic_student;?> </a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <br>

                <form method="post" id="myform">
                    <div class="row">
                        <div class="col-md-6">
                                <label for="type" class ="control-label col-sm-4"> Select Department:</label>
                                <div class="col-sm-8" id="typeedit">
                                <select class="form-control" name="dept_id" id="dept_nm">
                                        <option value="0">Select Department</option>

                                    <?php while ($rowd = mysql_fetch_array($sqld1)){ ?>
                                        <option <?php if($_POST['dept_id']!="0"){ if($_POST['dept_id']==$rowd['t_dept']){ echo "selected"; } }?> value="<?php echo $rowd['t_dept']; ?>"><?php echo $rowd['t_dept']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                        </div>
                        <div class="col-md-6">
                            <!--    <label for="type" class ="control-label col-sm-4"> Select Batch ID:</label>
                                <div class="col-sm-8" id="typeedit">
                                
                                    <select class="form-control searchselect" name="batch_id" id="batch_nm" required="required">
                                        <option value="0">Select Batch Id</option>
                                        <?php while ($row = mysql_fetch_array($sql1)){ ?>
                                        <option <?php if(isset($_POST['batch_id'])){ if($_POST['batch_id']==$row['batch_id']){ echo "selected"; } }?> value="<?php echo $row['batch_id']; ?>"><?php echo $row['batch_id']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div> -->
                        </div>

                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="type" class ="control-label col-sm-4"> Send To:</label>
                                <div class="col-sm-8" id="typeedit">
                                <select class="form-control" name="email_st" id="email_st">
                                    <option <?php if(isset($_POST['email_st'])){ if($_POST['email_st']=="Yes"){ echo "selected"; } }?> value="Yes">All <?php  echo $dynamic_teacher; ?></option>
                                    <option <?php if(isset($_POST['email_st'])){ if($_POST['email_st']=="No"){ echo "selected"; } }?> value="No">Unsent <?php  echo $dynamic_teacher; ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="type" class ="control-label col-sm-6">Start From:</label>
                            <div class="col-sm-6" id="typeedit">
                                <input type="number" class="form-control" name="startlmt" id="startlmt" <?php if(isset($_POST['startlmt'])){ echo "value=".$_POST['startlmt']; }?> min="1">    
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="type" class ="control-label col-sm-6">Record Limit:</label>
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
                            <label for="type" class ="control-label col-sm-5">Select Message to Send:</label>
                            <div class="col-sm-7" id="typeedit">
                              <select class="form-control" name="type" id="preview">
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
                <form action="#" method="post" id="myform">
                    <div class="row" style="padding:10px;">
                        <div class="col-md-12  " id="no-more-tables">
                            <table class="table-bordered  table-condensed cf" id="example" width="100%;">
                                <thead>
                                <tr style="background-color:#428BCA">
                                <!-- Camel casing done for Sr. No. by Pranali -->
                                    <th style="width:10%;"><b>Sr. No.</b></th>
                                    <th style="width:20%;"><b><?php echo $dynamic_teacher;?> ID</b></th>
                                    <th style="width:20%;">Name/Phone No.</th></th>
                                    <th style="width:20%;">Email ID</th></th>
                                    <th style="width:10%;">Department</th></th>
                                    <th style="width:10%;">SMS Status</th>
                                    <th style="width:10%;">EMAIL Status</th></th>
                                    <th style="width:10%;">TimeStamp(SMS/Email)</th></th> 
                                    <th style="width:20%;">Send SMS/Email</th></th>
                                </tr>
                                </thead>
                                <tbody>
                                
                                    
                                    <?php while ($row = mysql_fetch_array($arr)) {

                                                    $teacher_id = $row['t_id'];
                                    ?>
    <!--id for tr added by Pranali -->
                                    <tr id ='data<?php echo $teacher_id ?>' style="color:#808080;" class="active">
                                        <td data-title="Sr.No" style="width:4%;"><b><?php echo $i; ?></b></td>
                                        <td data-title="<?php echo $dynamic_teacher;?> ID" style="width:6%;"><b><?php echo $teacher_id; ?></b></td>
                                        <td data-title="First Name" style="width:12%;"><?php echo $row['t_complete_name']."(".$row['t_phone'].")" ?></td>
                                        <td data-title="Email" style="width:10%;">
                                        <?php  if($row['t_email']=="")
                                        {
                                            echo $row['t_internal_email'];
                                        }
                                        else
                                        {
                                            echo $row['t_email'];
                                            
                                        }?> </td>
                                        
                                        
                                        <td data-title="Dept Id" style="width:6%;"><?php echo $row['t_dept']; ?> </td>
                                    
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
                                        
                                        <td  data-title="Phone" style="width:10%;">


                                        <img src="Images/S.png" onclick="confirmSMS('<?php echo $row['school_id']; ?>','<?php if($row['t_email']=="")
                                            {
                                            echo $row['t_internal_email'];
                                            }
                                            else
                                            {
                                            echo $row['t_email'];
                                            } ?>','<?php echo $row['t_phone']; ?>','<?php echo $row['send_unsend_status'];?>','<?php echo $row['t_country']; ?>','<?php echo $teacher_id; ?>','<?php echo $i;?>');" >

                                        <img src="Images/E.png" onclick="confirmEmail('<?php echo $row['school_id']; ?>','<?php if($row['t_email']=="")
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

                                <div>
                                  
                        </div>  
                        </div>
                    </div>
                </form>
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
<script>
    $(document).ready(function() {
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
    //ajax functionality in confirmEmail() & confirmSMS() done by Pranali
    function confirmEmail(school_id,email,t_phone,Status,teacher_id,i) {
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
                        url: "SendEmail_Teacher.php",
                        dataType: 'text',
                        data:{school_id:school_id,email:email,t_phone:t_phone,Status:Status,teacher_id:teacher_id,i:i,msgid:msgid,senderid:senderid},
                        beforeSend: function(){
                             $('#ResultModal').modal({show: true, backdrop: 'static', keyboard: false});
                           },
                        success: function(table){
                            $('#ResultModal').modal('hide');
                             alert('Email Sent Successfully');
                             $('#data'+teacher_id).html(table); 
                             location.reload();
                           // $("#myform").load(data);
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
                                url: "SendEmail_Teacher.php",
                                dataType: 'text',
                                data:{school_id:school_id,email:email,t_phone:t_phone,Status:Status,teacher_id:teacher_id,i:i,msgid:msgid,senderid:senderid},
                                beforeSend: function(){
                                     $('#ResultModal').modal({show: true, backdrop: 'static', keyboard: false});
                                   },
                                success: function(table){
                                    $('#ResultModal').modal('hide');
                                    alert('Email Sent Successfully');
                                     $('#data'+teacher_id).html(table);
                                     location.reload();
                                   }
                                 });
                                 return false;
                        }
                        else{
                            }
            }
    }

    function confirmSMS(school_id,email,t_phone,Status,country,teacher_id,i) {
        if(Status=='Send_SMS')
            {
                var answer = confirm("Are you sure,do you want to resend SMS");
                if (answer)
                    {
                        $.ajax({
                        type: "POST",
                        url: "SendSMS_Teacher.php",
                        dataType: 'text',
                        data:{school_id:school_id,email:email,t_phone:t_phone,Status:Status,teacher_id:teacher_id,i:i,country:country},
                        success: function(table){
                            alert('SMS Sent Successfully');
                             $('#data'+teacher_id).html(table); 
                             location.reload();
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
                            url: "SendSMS_Teacher.php",
                            dataType: 'text',
                            data:{school_id:school_id,email:email,t_phone:t_phone,Status:Status,teacher_id:teacher_id,i:i,country:country},
                            success: function(table){
                                alert('SMS Sent Successfully');
                                 $('#data'+teacher_id).html(table);
                                 location.reload(); 
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

         $('#openmodal').click(function(){
            $('#MyModal').modal('show');
        });

         $('#openMSGmodal').click(function(){
            $('#MyMSGModal').modal('show');
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
