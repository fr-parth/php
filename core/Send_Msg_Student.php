<?php
error_reporting(0);
include("scadmin_header.php");
$id = $_SESSION['id'];
$query = "select * from `tbl_school_admin` where id='$id'";       // uploaded by
$row1 = mysql_query($query);
$value1 = mysql_fetch_array($row1);
$uploaded_by = $value1['name'];
$smartcookie = new smartcookie();
/*$id=$_SESSION['id']; */
$fields = array("id" => $id);
$table="tbl_school_admin";
$smartcookie = new smartcookie();
$results = $smartcookie->retrive_individual($table, $fields);
$result = mysql_fetch_array($results);
$sc_id = $result['school_id'];
$res = mysql_query("select id,type,email_body from tbl_email_sms_templates");
$res1 = mysql_query("select e_id,email_id from tbl_email_parameters");
$coordinator = mysql_query("select coordinator_id from tbl_school_admin where school_id='$sc_id'");
$coordinator1=mysql_fetch_array($coordinator);
$coordinator2=$coordinator1['coordinator_id'];


$sqln2="SELECT std_class from tbl_student where school_id='$sc_id' and std_class!='' group by std_class";
                                // echo $sqln2; exit;
    $sql1 = mysql_query($sqln2); 
    
    $sqld1 = mysql_query("Select std_dept from tbl_student where school_id='$sc_id' and std_dept!='' group by std_dept");

    $arrsql = "SELECT id,std_PRN,std_complete_name,std_phone,std_branch,std_email,batch_id,send_unsend_status,email_status,school_id,std_country,sms_time_log,email_time_log,std_dept,std_branch, std_class FROM tbl_student WHERE school_id='$sc_id' GROUP BY std_PRN ORDER BY id";
    
    if(isset($_POST['submit'])){
        $check=$_POST['email_st'];
        $dept = $_POST['dept_id'];
        $clas =  $_POST['class_id'];
        $where = "school_id='$sc_id'";
        if($dept!="0"){
            $where .= " AND std_dept='$dept'";
        }
        if($clas!="0"){
            $where .= " AND std_class='$clas'";
        }
        if($_POST['startlmt']!="" && $_POST['endlmt']!=""){
            $start=((int)$_POST['startlmt']-1);
            $Limit= "LIMIT ".$start.",".$_POST['endlmt'];
        }
        else if($_POST['startlmt']!="" && $_POST['endlmt']==""){
            $Limit= "LIMIT ".$_POST['startlmt'];
        }
        else{$Limit= "";}

        if($check != "No"){
                 $arrsql="SELECT id,std_PRN,std_complete_name,std_phone,std_branch,std_email,batch_id,send_unsend_status,email_status,school_id,std_country,sms_time_log,email_time_log,std_dept,std_branch, std_class FROM tbl_student WHERE $where GROUP BY std_PRN ORDER BY id $Limit";
        }
        else{
                $arrsql = "SELECT id,std_PRN,std_complete_name,std_phone,std_branch,std_email,batch_id,send_unsend_status,email_status,school_id,std_country,sms_time_log,email_time_log,std_dept,std_branch, std_class FROM tbl_student WHERE $where AND email_status = 'Unsend' GROUP BY std_PRN ORDER BY id $Limit";
        }
    }
    $i=1;
    $arr = mysql_query($arrsql); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
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
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Smart Cookie:Send SMS/EMAIL</title>
    <style>
        .dropdown1 {
            padding-left: 460px;
            margin-top: 15px;
        }
        .dropdown2 {
            padding-left: 500px;
            margin-top: 15px; 
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
    var std_cls = $('#std_class').val();
    var dept = $('#dept_nm').val();
    var start = $('#startlmt').val();
    var end = $('#endlmt').val();
    $.ajax({
    url: base_url + "/core/SendEmail_toAll_dept_student.php",
    type:'POST',
    data:({ check:check,
            school_id:school_id,
            t_dept:dept,
            std:std_cls,
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

function send_to_all() {
    var check = "Yes";
    callajax(check);
}

function send_to_unsend() {
    var check = "No";
    // callajax(check);
}
</script>
<body bgcolor="#CCCCCC">
<div style="bgcolor:#CCCCCC">
    <div class="container-fluid" style="padding:30px;width:1252px">
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
                 <h4 class="modal-title">Send Email</h4>
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
        <div style="border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">
            <div style="background-color:#F8F8F8 ;">
                <div class="row">
                
                <a onclick="confirmSMSToAll('<?php echo $sc_id ?>');" class="btn btn-info" style="margin-left: 500px;">
                <span class="glyphicon glyphicon-envelope"></span> Send to All
                </a>
                
                <!--<a href="SendSMS_toAll_student.php?phone=<?php echo $row['std_phone'];?>&school_id=<?php echo $row['school_id'];?>&Status=<?php echo $row['send_unsend_status'];?>&country=<?php echo $row['std_country'];?>"> <img src="Images/Sms.png"></a>-->
                <!--<a onclick="confirmSMSToAll('<?php echo $sc_id ?>');"><img src="Images/Sms.png"></a>-->
                
                <a onclick="confirmSMSTounsendAll('<?php echo $sc_id ?>');" class="btn btn-info">
                <span class="glyphicon glyphicon-envelope"></span> Exclude sent one's 
                </a>
                
                <!--<a onclick="confirmSMSTounsendAll('<?php echo $sc_id ?>');"><img src="Images/Sms.png"></a>-->
                    <div class="col-md-3 " style="color:#700000 ;padding:5px;">&nbsp;&nbsp;&nbsp;&nbsp;
                        <!--<a href="teacher_setup.php">   <input type="submit" class="btn btn-primary" name="submit" value="Add Teacher" style="width:150;font-weight:bold;font-size:14px;"/></a>-->
                        <a class="btn btn-lg" data-toggle="modal" data-target="#myModal" id="openmodal" > <img src="Images/Email.png"></a>
                    </div>
                    <div class="col-md-12 " >
                       <h2 style="text-align:center" margin-left: 170px;>Send SMS/EMAIL to <?php echo $dynamic_student;?></h2> 
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="dropdown1">
                            <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">Send SMS/ Email to <?php echo $dynamic_student;?><span class="caret"></span></button>
                            <ul style='margin-left:500px' class="dropdown-menu " role="menu" aria-labelledby="dropdownMenu1" >
                                <li role="presentation"><a role="menuitem" tabindex="-1" href="Send_Msg_Teacher.php"><?php echo $dynamic_teacher;?></a></li>
                                <li role="presentation"><a role="menuitem" tabindex="-1" href="Send_Msg_Student.php"><?php echo $dynamic_student;?> </a>
                                </li>
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
                                        <option <?php if($_POST['dept_id']!="0"){ if($_POST['dept_id']==$rowd['std_dept']){ echo "selected"; } }?> value="<?php echo $rowd['std_dept']; ?>"><?php echo $rowd['std_dept']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                        </div>
                        <div class="col-md-6">
                               <label for="type" class ="control-label col-sm-4"> Select Class:</label>
                                <div class="col-sm-8" id="typeedit">
                                
                                    <select class="form-control searchselect" name="class_id" id="std_class" required="required">
                                        <option value="0">Select Class</option>
                                        <?php while ($row = mysql_fetch_array($sql1)){ ?>
                                        <option <?php if(isset($_POST['class_id'])){ if($_POST['class_id']==$row['std_class']){ echo "selected"; } }?> value="<?php echo $row['std_class']; ?>"><?php echo $row['std_class']; ?></option>
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
                                    <option <?php if(isset($_POST['email_st'])){ if($_POST['email_st']=="Yes"){ echo "selected"; } }?> value="Yes">All <?php echo $dynamic_student;?></option>
                                    <option <?php if(isset($_POST['email_st'])){ if($_POST['email_st']=="No"){ echo "selected"; } }?> value="No">Unsent <?php echo $dynamic_student;?></option>
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
                
                <div class="row" style="padding:10px;">
                    <div class="col-md-12  " id="no-more-tables">
                        <table class="table-bordered  table-condensed cf" style="border: 1px solid #ccc;" id="example" width="100%;">
                            <thead>
                            <tr style="background-color:#428BCA">
                            <!-- Camel casing done for Sr. No. by Pranali -->
                            <!--Chnaged label of TimeStramp to TimeStamp by Pranali for SMC-4977-->
                                <th style="width:3%;"><b>Sr. No.</b></th>
                                <th style="width:10%;"><b><?php echo $dynamic_student." ";?><?php echo $dynamic_student_prn;?></b></th>
                                <th style="width:20%;">Name/Phone No.</th>
                                <th style="width:15%;">Email ID</th>
                                <th style="width:10%;">Department</th>
                                <th style="width:8%;">Class</th>
                                <th style="width:6%;">SMS Status</th> 
                                <th style="width:6%;">EMAIL Status</th> 
                                <th style="width:15%;">TimeStamp(SMS/Email)</th>
                                <th style="width:7%;">Send SMS/Email</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php while ($row = mysql_fetch_array($arr)) {
                                $prn_id = $row['std_PRN'];
                                ?>
        <!--id for tr added by Sachin -->
                                <tr id ='data<?php echo $prn_id ?>' style="color:#808080;" class="active">
                                    <td data-title="Sr.No" style="width:4%;"><b><?php echo $i; ?></b></td>
                                    <td data-title="Teacher ID" style="width:6%;"><b><?php echo $row['std_PRN']; ?></b></td>
                                    <td data-title="Name" style="width:12%;"><?php echo $row['std_complete_name']."<br>Phone ".$row['std_phone'];?></td>
                                    <td data-title="Phone" style="width:8%;"><?php echo $row['std_email']; ?> </td>
                                    <td data-title="Dept" style="width:8%;"><?php echo $row['std_dept']; ?> </td>
                                    <td data-title="Class" style="width:6%;"><?php echo $row['std_class']; ?> </td>
                                    
                                    <td data-title="SmsStatus" style="width:5%;"><?php
                                        if ($row['send_unsend_status'] == 'Unsend') {
                                            echo 'Unsent';
                                        } elseif ($row['send_unsend_status'] == 'Send_SMS') {
                                            echo 'SMS Sent';
                                        }
                                        ?> </td>
                                    <td data-title="MailStatus" style="width:5%;"><?php
                                        if ($row['email_status'] == 'Send_Email') {
                                            echo 'Email sent';
                                        } elseif ($row['email_status'] == 'Unsend') {
                                            echo 'Unsent';
                                        }
                                        ?> </td>
                                    <td><?php echo "SMS :".$row['sms_time_log']."<br>Email :".$row['email_time_log'];?></td>

                                    <td data-title="ButtonTD" style="width:10%;">
                                        <img src="Images/S.png" onclick="confirmSMS( '<?php echo $row['std_phone']; ?>','<?php echo $row['school_id']; ?>','<?php echo $row['std_email']; ?>','<?php echo $row['send_unsend_status'];?>','<?php echo $row['std_country']; ?>','<?php echo $prn_id; ?>','<?php echo $i; ?>');">
                                        <img src="Images/E.png" onclick="confirmEmail('<?php echo $row['email_status'];?>','<?php echo $row['school_id']; ?>','<?php echo $row['std_email']; ?>','<?php echo $row['std_phone']; ?>','<?php echo $row['std_complete_name']; ?>','<?php echo $prn_id; ?>','<?php echo $i; ?>','<?php echo $row['id']; ?>','<?php echo $coordinator2; ?>');" >
                                        
                                    
                                    </td>
                                </tr>
                                <?php $i++;?>
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
//ajax functionality in confirmEmail() & confirmSMS() done by Pranali
    function confirmEmail(Status,school_id,email,phone,name,prn_id,i,id,coordinator2) {
      //  alert(coordinator2);
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
            { //Added member_id in both ajax calls for email for SMC-4977 by Pranali
                var answer = confirm("Are you sure,do you want to resend Email");
                if (answer) 
                    {
                        $.ajax({
                        type: "POST",
                        url: "SendEmail_Student.php",
                        dataType: 'text',
                        data:{Status:Status,school_id:school_id,email:email,phone:phone,name:name,prn_id:prn_id,i:i,msgid:msgid,senderid:senderid, member_id : id,coordinator2:coordinator2},
                        beforeSend: function(){
                             $('#ResultModal').modal({show: true, backdrop: 'static', keyboard: false});
                           },
                        success: function(table){
                            $('#ResultModal').modal('hide');
                            alert('Email Sent Successfully');
                             $('#data'+prn_id).html(table);
                           }
                         });
                         return false;
                    }
                else{
                    }
            }
        else{
            
                var answer = confirm("Do you want to send Email");
                if (answer) 
                    {
                        alert(coordinator2);
                        $.ajax({
                        type: "POST",
                        url: "SendEmail_Student.php",
                        dataType: 'text',
                        data:{Status:Status,school_id:school_id,email:email,phone:phone,name:name,prn_id:prn_id,i:i,msgid:msgid,senderid:senderid, member_id : id,coordinator2:coordinator2},
                        beforeSend: function(){
                            $('#ResultModal').modal({show: true, backdrop: 'static', keyboard: false});
                           },
                        success: function(table){
                                    $('#ResultModal').modal('hide');
                                    alert('Email Sent Successfully');
                             $('#data'+prn_id).html(table);
                          }
                         });
                         return false;
                    }
                else{
                    }
            }
    }

    function confirmSMS(phone,school_id,email,Status,country,prn_id,i) {
        
        if(Status=='Send_SMS')
            {
                var answer = confirm("Are you sure,do you want to resend SMS");
                if (answer) 
                    {
                        $.ajax({
                        type: "POST",
                        url: "SendSMS_Student.php",
                        dataType: 'text',
                        data:{phone:phone,school_id:school_id,email:email,Status:Status,country:country,prn_id:prn_id,i:i},
                        success: function(table){
                            
                             alert('SMS Sent Successfully');
                           $('#data'+prn_id).html(table);
                            //$('#data'+prn_id).load(window.location + ' #data'+prn_id);
                             
                           }
                         });
                         return false;    
                    }
                else{
                    }
            }
        else{
                var answer = confirm("Do you want to send SMS");
                if (answer) {
                            $.ajax({
                                    type: "POST",
                                    url: "SendSMS_Student.php",
                                    dataType: 'text',
                                    data:{phone:phone,school_id:school_id,email:email,Status:Status,country:country,prn_id:prn_id,i:i},
                                    success: function(table){
                                        
                                         alert('SMS Sent Successfully');
                                        $('#data'+prn_id).html(table);
                                         //$('#data'+prn_id).load(window.location + ' #data'+prn_id);
                                         
                                       }
                                     });
                                     return false;
                           }
                      else {
                           }
            }
    }
    
    
    function confirmSMSToAll(school_id) {
        //alert(school_id);
        //if(Status=='Send_SMS'){
    var base_url = "<?php echo $GLOBALS['URLNAME'];?>";
    var check = $('#email_st').val();
    var school_id = "<?= $sc_id;?>";
    var std_cls = $('#std_class').val();
    var dept = $('#dept_nm').val();
    var start = $('#startlmt').val();
    var end = $('#endlmt').val();
    
       //Added varaibles check,std_cls, dept, start, end by Pranali for SMC-4756
            var answer = confirm("Are you sure,do you want to send SMS?");
            if (answer) {
                window.location = "SendSMS_toAll_student.php?school_id="+school_id+"&check="+check+"&std_cls="+std_cls+"&dept="+dept+"&start="+start+"&end="+end;
            }
            // else {
            // }
        //}else{
       // window.location = "SendSMS_toAll_student.php?school_id="+school_id+"&Status="+Status+"&country="+country;
    //}
    }
    
    function confirmSMSTounsendAll(school_id) {
        //alert(school_id);
        //if(Status=='Send_SMS'){
            var answer = confirm("Are you sure,do you want to send SMS?");
            if (answer) {
                window.location = "SendSMS_toAll_unsend_student.php?school_id="+school_id;
            }
            else {
            }
        //}else{
       // window.location = "SendSMS_toAll_student.php?school_id="+school_id+"&Status="+Status+"&country="+country;
    //}
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
    })

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















