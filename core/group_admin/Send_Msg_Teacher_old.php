<?php
include("groupadminheader.php");
error_reporting(E_ALL);
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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<link rel="stylesheet" href="../css/bootstrap.min.css">
<script src="../js/jquery-1.11.1.min.js"></script>
<script src="../js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css" href="../css/jquery.dataTables.css">
<script src='../js/bootstrap.min.js' type='text/javascript'></script>
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
</style>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Smart Cookie:Send SMS/EMAIL</title>
    <style>
        .dropdown3 {
            padding-left: 488px;
            
        }
        .dropdown2 {
            padding-left: 500px;
            margin-top: 15px;
        }
        .dropdown1 {
            padding-left: 450px;
            margin-top: 15px;
        }
    </style>
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
$(document).ready(function() {
    $('#example').dataTable( {
      
    } );
} );

function callajax(check){
    var base_url = "<?php echo $GLOBALS['URLNAME'];?>";
    var check = check;
    var school_id = '<?php echo $sc_id; ?>';
    var dept = '<?php echo $_GET["t_dept"]; ?>';
    $.ajax({
    url: base_url + "/core/SendEmail_toAll_dept_teacher.php",
    type:'POST',
    data:({ check:check,
            school_id:school_id,
            t_dept:dept
            }),
    success: function(result){
      if(result){  
      alert(result);
      }
      else {
        alert('Error In Deletion');
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
    callajax(check);
}


</script>
<body bgcolor="#CCCCCC">

<div style="bgcolor:#CCCCCC">
    <div class="container-fluid" style="padding:30px;width:1152px">
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog" style="margin-left: -258px;">
            
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Send Email To All</h4>
                </div>
                <div class="modal-body">
                  <p>Do you want to send the mails ?</p>
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
                    <div style="color:#700000 ;padding:5px;" >
                    <div class="col-md-4">&nbsp;&nbsp;&nbsp;&nbsp;
                    
                     <a href="SendSMS_toAll_dept_teacher.php?school_id=<?php echo $School_id;?>&country=<?php echo $country;?>"> <img src="../Images/Sms.png"></a>
                    <a class="btn btn-lg" data-toggle="modal" data-target="#myModal" > <img src="../Images/Email.png"></a>
                     </div>
                      
                        <div class="col-md-6 " align="center">
                            <h2>Send SMS/EMAIL to <?php echo $dynamic_teacher;?></h2>
                        </div>
                         </div>
                         
                     </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="dropdown1">
                            <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">Send SMS/ Email to <?php echo $dynamic_teacher;?><span class="caret"></span></button>
                            <ul class="dropdown-menu " role="menu" aria-labelledby="dropdownMenu1" style="margin-left:500px;">
                                <li role="presentation"><a role="menuitem" tabindex="-1" href="Send_Msg_Teacher.php"><?php echo $dynamic_teacher;?></a></li>
                                <li role="presentation"><a role="menuitem" tabindex="-1" href="Send_Msg_Student.php"><?php echo $dynamic_student;?> </a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- <div class="col-sm-offset-2 col-sm-8">
                        <button id="preview" class="btn btn-default" style="background-color: #428BCA;margin-left: -21%; margin-top: -10%;color: white;"><b>Preview Message</b></button> 
                     </div> -->
                  <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="type" class ="control-label col-sm-4">Select Message to Send:</label>
                        <div class="col-sm-8" id="typeedit">
                          <select class="form-control" name="type" id="preview">
                            <option value="">Select Id</option>
                            <?php while($row= mysql_fetch_array($res)){ ?>
                            <option value="<?php echo $row['id']; ?>"><?php echo $row['type']; ?></option>
                            <?php } ?>
                          </select>
                        </div>
                    </div> 
                    <!-- <div class="dropdown2">
                        <button class="btn btn-default dropdown-toggle"  type="button" id="dropdownMenu2" data-toggle="dropdown" aria-expanded="true">Batch ID's<span class="caret"></span></button>
                        <?php $sql1 = mysql_query("Select DISTINCT(batch_id) as batch_id,school_id,send_unsend_status,t_country from tbl_teacher where school_id='$sc_id'  group by batch_id"); ?>
                        <ul class="dropdown-menu " role="menu" aria-labelledby="dropdownMenu2" style="margin-left:500px;">
                            <?php while ($row = mysql_fetch_array($sql1)){ ?>
                            <li role="presentation"><a role="menuitem" tabindex="-1" href="SendMSG_allbatch_Teacher.php?batch_id=<?php echo $row['batch_id']; ?>&school_id=<?php echo $row['school_id']; ?>&status=<?php echo $row['send_unsend_status']; ?>&country=<?php echo $row['t_country']; ?>"><?php echo $row['batch_id']; ?><?php } ?> </a></li>
                        </ul>
                    </div> -->
                </div>
                
                <div class="col-md-4">
                    <div class="dropdown3">
                        <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu3" data-toggle="dropdown" aria-expanded="true">Select School<span class="caret"></span></button>
                        <?php $sqln2="Select DISTINCT(school_id) as school_id,school_name,scadmin_country from tbl_school_admin where group_member_id='$group_member_id' group by school_id";
                        // echo $sqln2; exit;
                         $sql1 = mysql_query($sqln2); ?>
                        
                        <!-- style="margin-left:500px;" added in below <ul> by Pranali  -->
                        <ul class="dropdown-menu " role="menu" aria-labelledby="dropdownMenu2" style="margin-left:500px;">
                            <?php while ($row = mysql_fetch_array($sql1)){ ?>
                            <li role="presentation"><a role="menuitem" tabindex="-1" href="SendMSG_alldept_Teacher.php?school_id=<?php echo $row['school_id']; ?>&country=<?php echo $row['scadmin_country']; ?>"><?php echo $row['school_name']; ?><?php } ?> </a></li>
                        </ul>
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
                                    <th style="width:3%;"><b>Sr. No.</b></th>
                                    <th style="width:10%;"><b><?php echo $dynamic_teacher;?> ID</b></th>
                                    <th style="width:15%;">Name/Phone No.</th></th>
                                    <th style="width:15%;">Email ID</th></th>
                                    <th style="width:8%;">Batch ID</th></th>
                                    <th style="width:15%;">School Name</th></th>
                                    <th style="width:8%;">SMS Status</th>
                                    <th style="width:9%;">EMAIL Status</th></th>
                                    <th style="width:9%;">TimeStamp(SMS/Email)</th></th> 
                                    <th style="width:8%;">Send SMS/Email</th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                    define('MAX_REC_PER_PAGE', 100); 
                                    //getting count of total number of rows
                                    $sqln1 = "SELECT t.id,t.t_id,t.t_complete_name,t.t_phone,t.t_email,t.t_internal_email,t.batch_id,t.send_unsend_status,t.email_status,t.school_id,t.t_country,t.sms_time_log,t.email_time_log, sa.school_name
                                                        FROM tbl_teacher t LEFT JOIN tbl_school_admin sa ON t.school_id=sa.school_id WHERE sa.group_member_id='$group_member_id' AND t.t_emp_type_pid IN ('133','134') AND t.error_records 
                                                        LIKE 'Correct'";
                                                        // echo $sqln1; exit;
                                    $rs = mysql_query($sqln1);
               //mysql_num_rows added by Pranali for bug SMC-3096
                                    $total = mysql_num_rows($rs);
                                    // echo $total;
                                    $total_pages = ceil($total / MAX_REC_PER_PAGE);//diving total rows by 100
                                    $page = intval(@$_GET["page"]);
            
                                     if(0 == $page){
                                         $page = 1;
                                        }  
                                    $start = MAX_REC_PER_PAGE * ($page - 1);
                                    $max = MAX_REC_PER_PAGE;
                             
                                    $i=$start + 1;// for serial number
                                    $arr = mysql_query("SELECT t.id,t.t_id,t.t_complete_name,t.t_phone,t.t_email,t.t_internal_email,t.batch_id,t.send_unsend_status,t.email_status,t.school_id,t.t_country,t.sms_time_log,t.email_time_log, sa.school_name
                                                        FROM tbl_teacher t LEFT JOIN tbl_school_admin sa ON t.school_id=sa.school_id WHERE sa.group_member_id='$group_member_id' AND t.t_emp_type_pid IN ('133','134') AND t.error_records 
                                                        LIKE 'Correct' ORDER BY t.id LIMIT $start, $max"); ?>
                                    
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
                                        
                                        
                                        <td data-title="Batch Id" style="width:6%;"><?php echo $row['batch_id']; ?> </td>
                                        
                                        <td data-title="Batch Id" style="width:6%;"><?php echo $row['school_name']; ?> </td>
                                    
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


                                        <img src="../Images/S.png" onclick="confirmSMS('<?php echo $row['school_id']; ?>','<?php if($row['t_email']=="")
                                            {
                                            echo $row['t_internal_email'];
                                            }
                                            else
                                            {
                                            echo $row['t_email'];
                                            } ?>','<?php echo $row['t_phone']; ?>','<?php echo $row['send_unsend_status'];?>','<?php echo $row['t_country']; ?>','<?php echo $teacher_id; ?>','<?php echo $i;?>');" >

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
                                    &nbsp; &nbsp; <a href="?page=<?php echo $next; ?>&max=<?php echo $max; ?>">NEXT 100 >> </a>
                            <?php
                                    }
                            ?>  
                            </center>
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
        var base_url = "<?php echo $GLOBALS['URLNAME'];?>";
        var msgid = $('#preview').val();
        if(msgid == "" || msgid == "0")
        {
            alert("Please select message to send!!");
            $("#preview").focus();
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
                        data:{school_id:school_id,email:email,t_phone:t_phone,Status:Status,teacher_id:teacher_id,i:i,msgid:msgid},
                        success: function(table){
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
                                data:{school_id:school_id,email:email,t_phone:t_phone,Status:Status,teacher_id:teacher_id,i:i,msgid:msgid},
                                success: function(table){
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
                        data:{school_id:school_id,email:email,t_phone:t_phone,Status:Status,teacher_id:teacher_id,i:i,country:country},
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
                            data:{school_id:school_id,email:email,t_phone:t_phone,Status:Status,teacher_id:teacher_id,i:i,country:country},
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