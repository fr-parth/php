<?php
include("groupadminheader.php");
error_reporting(0);
$group_member_id = $_SESSION['group_admin_id'];

$res = mysql_query("select id,type,email_body from tbl_email_sms_templates");
$res1 = mysql_query("select e_id,email_id from tbl_email_parameters");
    

    if(isset($_POST['submit'])){

     $a=$_POST['Search'];
     $b=$_POST['Search1'];
   if($a!='')
   {
    $searchq=$a;
   }
   if($b!='')
   {
    $searchq=$b;
   }
$colname=$_POST['colname'];
$country1=$_POST['country'];
$state1=$_POST['state'];
$city=$_POST['city'];
$a=$_POST['Search'];
$send_to_email=$_POST['sendtoschoolorco'];

$sql= mysql_query("SELECT * FROM tbl_country where country_id='$country1'");
$query =mysql_fetch_array($sql);
  $country=$query['country'];

$sql1= mysql_query("SELECT * FROM tbl_state where state_id='$state1'");
$query1 =mysql_fetch_array($sql1);
 $state=$query1['state'];
$check=$_POST['email_st'];
        
        if($_POST['startlmt']!="" && $_POST['endlmt']!=""){
            $start=((int)$_POST['startlmt']-1);
            $end=((int)$_POST['endlmt']);
            $Limit= "LIMIT ".$start.",".$end;
        }
        else if($_POST['startlmt']!="" && $_POST['endlmt']==""){
            $Limit= "LIMIT ".$_POST['startlmt'];
        }
        else{$Limit= "";}
if($check=='No')
{
    $cond1="and (email_time_log='' or email_time_log is null)";
}else 
{
    $cond1='';
}
if($send_to_email=='Coordinator')
{
    $cond2="and coordinator_id IS NOT NULL";
}
else
{
  $cond2='';
}


if($country !='' && $state !='' && $city!='')
{
    if($colname=='is_dept_admin')
    {
     $cond=" and state='$state' and t_country='$country' and t_city='$city' ";
    }
    else
    {
    $cond=" and scadmin_state='$state' and scadmin_country='$country' and scadmin_city='$city' ";
    }
}
else if ($country !='' && $state !='' && $city =='')
{
    if($colname=='is_dept_admin')
    {
     $cond=" and state='$state' and t_country='$country' ";
    }
    else
    {
     $cond=" and scadmin_state='$state' and scadmin_country='$country' ";
    }
}
else if($country !='' && $state =='' && $city !='')
{
    if($colname=='is_dept_admin')
    {
     $cond=" and t_country='$country' and t_city='$city' ";
    }
    else
    {
    $cond=" and scadmin_country='$country' and scadmin_city='$city'";
    }
}
else if($country !='' && $state =='' && $city =='')
{
    if($colname=='is_dept_admin')
    {
     $cond=" and t_country='$country' ";
    }
   else
    {
    $cond=" and scadmin_country='$country'";
    }
}
else if($country =='' && $state =='' && $city !='')
{
    if($colname=='is_dept_admin')
    {
     $cond=" and t_city='$city' ";
    }
   else
   {
    $cond=" and scadmin_city='$city' ";
   }
}
else {
    $cond="";
}

      if ($colname != ''and $colname != 'Select')
    {


        if($colname=='coordinator_id')
        {
             $sqln1="SELECT
        * from tbl_school_admin where group_member_id = '$group_member_id' AND `$colname`!='' $cond $cond1 $cond2 order by id $Limit"; 
      //echo $sqln1;
        }
        else
        {
          $sqln1="SELECT
        * from tbl_school_admin where group_member_id = '$group_member_id' AND `$colname` LIKE '%$searchq%' $cond $cond1 $cond2 order by id $Limit"; 
       //echo $sqln1;
       } 
    }else{
               $sqln1="select * from tbl_school_admin where group_member_id = '$group_member_id' AND (name LIKE '%$searchq%' or school_name LIKE '%$searchq%' or email LIKE '$searchq%' or mobile LIKE '$searchq%' or email_status LIKE '$searchq%' or send_sms_status LIKE '$searchq%' or sms_time_log LIKE '$searchq%' or email_time_log LIKE '$searchq%') $cond $cond1 order by id $Limit";
               
            }
        
    }
    // echo $sqln1;

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
     $(document).ready(function() {
        $('#example').dataTable({});    
 });
    function confirmEmail(Status,school_id,email,name) {
        //alert(email);return false;
        var msgid = $('#preview').val();
        var senderid = $('#emailtype').val();
         if(email == "")
        {
            alert("Receiver Email id is Empty !!");
            $("#preview").focus();
            return false;
        }
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

        if (Status == 'Send_Email') {
            var answer = confirm("Are you sure,do you want to resend Email");
            if (answer) {
                window.location = "SendEmail_group_admin_new.php?email="+email+"&school_id="+school_id+"&msgid="+msgid+"&senderid="+senderid;
            }
            else {
            }
        } else {
            window.location = "SendEmail_group_admin_new.php?email="+email+"&school_id="+school_id+"&msgid="+msgid+"&senderid="+senderid;
            // window.location = "SendEmail_group_admin_new.php?email="+email+"&school_id="+school_id+"&name="+name;
        }
    }
    // function confirmSMS(phone,school_id,Status,country) {
    //     if(Status=='Send_SMS'){
    //         var answer = confirm("Are you sure,do you want to resend SMS");
    //         if (answer) {
    //             window.location = "Send_SMS_group_admin.php?phone="+phone+"&school_id="+school_id+"&Status="+Status+"&country="+country;
    //         }
    //         else {
    //         }
    //     }else{
    //         window.location = "Send_SMS_group_admin.php?phone="+phone+"&school_id="+school_id+"&Status="+Status+"&country="+country;
    //     }
    // }

    function confirmSMS(phone,school_id,Status,country,i) {
            var base_url = "<?php echo $GLOBALS['URLNAME'];?>";
        var msgid = $('#preview').val();
        if(msgid == "" || msgid == "0")
        {
            alert("Please select message to send!!");
            $("#preview").focus();
            return false;
        }
        if(Status=='Send_SMS')
            {
                var answer = confirm("Are you sure,do you want to resend SMS");
                if (answer)
                    {
                        $.ajax({
                        type: "POST",
                        url: base_url + "/core/group_admin/Send_SMS_group_admin.php",
                        dataType: 'text',
                        data:{school_id:school_id,phone:phone,status:Status,i:i,country:country,msgid:msgid},
                        success: function(table){
                            alert('SMS Sent Successfully');
                             // $('#data'+student_prn).html(table); 
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
                            url: base_url + "/core/group_admin/Send_SMS_group_admin.php",
                            dataType: 'text',
                            data:{school_id:school_id,phone:phone,status:Status,i:i,country:country,msgid:msgid},
                            success: function(table){
                                alert('SMS Sent Successfully');
                                 // $('#data'+student_prn).html(table); 
                               }
                             });
                             return false;
                        }
                    else{ 
                        }
            }
        }
        function callajaxSMS(check){
    var msgid = $('#preview').val();
    
        if(msgid == "" || msgid == "0")
        {
            alert("Please select message to send!!");
            $("#preview").focus();
            return false;
        }
    var base_url = "<?php echo $GLOBALS['URLNAME'];?>";
    var key = $('#colname').val();
    var keyw = $('#keywor').val();
    // var start = $('#startlmt').val();
    // var end = $('#endlmt').val();
    $.ajax({
    url: base_url + "/core/group_admin/Send_SMStoAll_group_admin.php",
    type:'POST',
    data:({ key:key,
            keyw:keyw,
            msgid:msgid
            // email:mail,
            // startlmt:start,
            // endlmt:end
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
                      
                         </div>
                      
                        <div class="col-md-6 " align="center">
                            <h2>Send SMS/EMAIL to <?php echo $dynamic_school;?>Admin</h2>
                        </div>
                         </div>
                         
                     </div>
               
                <div class="clearfix"></div>
                <br>
                
                <form method="post" id="myform">
                    <div class="row">
                       <div class="col-md-4">
                            <div class="form-group">
                                <label for="type" class ="control-label col-sm-4">Country:</label>
                                <div class="col-sm-8" id="typeedit">
                            
        <?php $sql2 = mysql_query("select * from tbl_country where is_enabled='1'");
        
    ?>
                                  <select class="form-control" name="country" id="country" >
                                        <option value=''>Select</option>
                                    <?php
                                    while($result2 = mysql_fetch_array($sql2)){ ?>
                                    
                                    <option value="<?php echo $result2['country_id']; ?>"  <?php if($result2['country']==$country){?> selected="selected" <?php }?>><?php echo $result2['country']; ?></option>
                                    
                                 <?php  }?>
                                  </select> 
                                </div>
                            </div> 
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="type" class ="control-label col-sm-4">State:</label>
                                <div class="col-sm-8" id="typeedit">
                                  <select name='state' id='state' class='form-control'>
                                 <?php if($state !=''){?>
                                   <option value='<?php echo $state1;?>'><?php echo $state; ?></option>
                                 <?php } else {?>
                                 <option value=''>Select</option>


                                 <?php }?>                                                                  </select>

                                </div>
                            </div> 
                        </div>
                        
                            
                            <div class="col-md-4">
                            <div class="form-group">
                                <label for="type" class ="control-label col-sm-4">City:</label>
                                <div class="col-sm-8" id="typeedit">
                                  <select class="form-control" name="city" id="city" >
                                   
                                    <?php if($city !=''){?>
                                   <option value='<?php echo $city;?>'><?php echo $city; ?></option>
                                 <?php } else {?>
                                  <option value="">All</option>
                                 <?php }?>      
                                   
                                  </select>
                                </div>
                            </div> 
                        </div>
                    </div>  
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="type" class ="control-label col-sm-6"> Select School :</label>
                                <div class="col-sm-6" id="typeedit">
                                <select class="form-control" name="email_st" id="email_st">
                                    <option <?php if(isset($_POST['email_st'])){ if($_POST['email_st']=="No"){ echo "selected"; } }?> value="No">Unsent Schools</option>
                                    <option <?php if(isset($_POST['email_st'])){ if($_POST['email_st']=="Yes"){ echo "selected"; } }?> value="Yes">All Schools</option>
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
                            <label for="type" class ="control-label col-sm-6">Record Limit:</label>
                            <div class="col-sm-6" id="typeedit">
                                <input type="number" class="form-control" name="endlmt" id="endlmt" <?php if(isset($_POST['endlmt'])){ echo "value=".$_POST['endlmt']; }?> min="1">    
                            </div>
                        </div>
                        <br> 
                        <br> 


            <div class="col-md-4">
                            <div class="form-group">
                                <label for="type" class ="control-label col-sm-6">Send to Person <span style="color:red;">*</span>:</label>
                                <div class="col-sm-6" id="typeedit">
                                  <select class="form-control" name="sendtoschoolorco" id="" required>
                                  <option value="schooladmin" <?php if (($_POST['sendtoschoolorco']) == "schooladmin") {
                            echo $_POST['colname']; ?> selected="selected" <?php } ?>>School Admin</option>
                                     <option value="Coordinator" <?php if (($_POST['sendtoschoolorco']) == "Coordinator") {
                            echo $_POST['colname']; ?> selected="selected" <?php } ?>>Coordinator</option>
                                   
                                  </select>
                                </div>
                            </div> 
              </div>

            <div class="col-md-2" style="font-weight:bold; margin-right:-36px;">Search By
            </div>
            <div class="col-md-2" style="width:17%;">
               <select name="colname" id="colname" class="form-control" size=1>
                    <option selected="selected">Select</option>
                    <option value="name"
                    <?php if (($_POST['colname']) == "name") {
                            echo $_POST['colname']; ?> selected="selected" <?php } ?>>Admin Name</option>
                     <option value="school_name"
                    <?php if (($_POST['colname']) == "school_name") {
                            echo $_POST['colname']; ?> selected="selected" <?php } ?>><?php echo $dynamic_school; ?>  Name</option>
                             <option value="school_id"
                    <?php if (($_POST['colname']) == "school_id") {
                            echo $_POST['colname']; ?> selected="selected" <?php } ?>>School Id</option>
                    <option value="email"
                    <?php if (($_POST['colname']) == "email") {
                            echo $_POST['colname']; ?> selected="selected" <?php } ?>>Email ID</option>
                    <option value="mobile"
                    <?php if (($_POST['colname']) == "mobile") {
                            echo $_POST['colname']; ?> selected="selected" <?php } ?>>Mobile</option>    
                             <option value="is_accept_terms"
                    <?php if (($_POST['colname']) == "is_accept_terms") {
                             echo $_POST['colname'];
                           ?> selected="selected" <?php } ?>>Is activated</option>    

                            <!--  <option value="coordinator_id"
                    <?php if (($_POST['colname']) == "coordinator_id") { 
                            echo $_POST['colname']; ?> selected="selected" <?php } ?>>Primary coordinator</option>    

                             <option value="is_dept_admin"
                    <?php if (($_POST['colname']) == "is_dept_admin") {
                            echo $_POST['colname']; ?> selected="selected" <?php } ?>>Department coordinator</option>     -->
                </select>
            </div>
            <div class="col-md-2" id="activated2" style="width:17%">

              <?php //print_r($_POST);
              if ($_POST['colname'] == "is_accept_terms") 
                          {
                            if($_POST['Search1']=='1'){$searchq="Yes";}
                            elseif($_POST['Search1']=='0'){$searchq="No";}
                            elseif($_POST['Search1']==''){$searchq="All";}
                            else{$searchq="";}
                            ?>
                            <input type="text" class="form-control" name="Search" value="<?php echo $searchq; ?>" id="keywor" placeholder="Search.." > 
                          <?php
                          }
                          else
                          { ?>
                            <input type="text" class="form-control" name="Search" value="<?php echo $searchq; ?>" id="keywor" placeholder="Search.." > 
                 
                         <?php } ?>
              </div>
           
              <div class="col-md-2"  id="activated1" style="width:17%;">
                
                 <select name="Search1" id="colname" class="form-control">

                    <option selected="selected">Select</option>
                    <option value="1" <?php if (($_POST['Search1']) == "1") {
                            echo $_POST['Search1']; ?> selected="selected" <?php } ?>selected="selected">Yes</option>
                    <option value="0" <?php if (($_POST['Search1']) == "0") {
                            echo $_POST['Search1']; ?> selected="selected" <?php } ?> selected="selected">No</option>
                    <option value="" <?php if (($_POST['Search1']) == "") {
                            echo $_POST['Search1']; ?> selected="selected" <?php } ?> selected="selected">All</option>
                  </select>
             </div>

            <div class="col-md-1" >
            <button type="submit" value="Search" name="submit" class="btn btn-primary">Search</button>
            </div>
            <div class="col-md-1" >
            <input type="button" class="btn btn-info" value="Reset" onclick="window.open('Send_Mail_Group_admin.php','_self')" />
            
            </div>
                </form>
                <br>
                <br>
                    <div class="row">
                        <div class="col-md-7">
                            <div class="form-group">
                                <label for="type" class ="control-label col-sm-4">Select Message to Send<span style="color:red;">*</span>:</label>
                                <div class="col-sm-8" id="typeedit">
                                  <select class="form-control select1" name="type" id="preview" required>
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
                                  <select class="form-control select1" name="emailtype" id="emailtype" required>
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
                                <th> Sr. No.</th>

                    <th> Admin Name<br>Coordinator Name</th>
                    <th> School Id<br>School Name </th>
                    <th> Admin Email<br>Coordinator Email<br>Coordinator Id </th>
                    <th> Admin Mb.<br>Coordinator Mb.</th>
                    <th> EMAIL Status </th>
                    <th> SMS Status </th>
                    <th> TimeStramp(SMS/Email) </th>
                    <th> Send Email </th> 
                                </tr>
                                </thead>
                                <tbody id="ajaxRecords">
                                <?php
                                    $i=1;
                                    $arr = mysql_query($sqln1);
                                   // print_r(mysql_fetch_array($arr));
                                    while ($row = mysql_fetch_array($arr)) {


                                      $teacher_id = $row['id'];
                                   $a=$row['coordinator_id'];
                               $school_id=$row['school_id'];
                               if($a!='')
                               {
                                $sql= mysql_query("SELECT t_email,t_complete_name,t_phone,t_id FROM tbl_teacher where t_id='$a' and school_id='$school_id'");
                                $query =mysql_fetch_array($sql);
                                $email=$query['t_email'];
                                $t_complete_name=$query['t_complete_name'];
                                $t_phone=$query['t_phone'];
                              //  $t_id=$query['t_id'];
                               } 
                              else
                              {
                                $email='';
                                $t_complete_name='';
                                $t_phone='';
                              //  $t_id='';
                               }

                                    ?>
    <!--id for tr added by Pranali -->
                                    <tr>
                        <td data-title="Sr.No" ><b><?php echo $i; ?></b></td>

                               
                                <td data-title="Teacher ID" ><b><?php echo $row['name']; ?></b><br><b><?php echo $t_complete_name; ?></b></td>
                                <td data-title="Name" ><?php echo $row['school_id'];?><br><?php echo $row['school_name'];?></td>
                                <td data-title="Phone" ><?php echo 'A:-'.$row['email']; 
                                ?><br><?php echo 'C:-'.$email; ?><br><?php echo 'Co. Id:-'.$row['coordinator_id'];  ?>
                                </td>
                                <td data-title="Phone" ><?php echo $row['mobile']; ?><br><?php echo $t_phone; ?> </td>

                                <td data-title="Phone" ><?php
                                    if ($row['email_status'] == 'Send_Email') {
                                    echo 'Email sent';
                                    } elseif ($row['email_status'] == 'Unsend') {
                                    echo 'Unsent';
                                    }
                                    elseif ($row['email_status'] == '') {
                                    $row['email_status'] = 'Unsend';
                                    echo 'Unsent';
                                    }
                                    ?> </td>
                                <td data-title="Send/Unsen Status" ><?php
                                    if ($row['send_sms_status'] == 'Send_SMS') {
                                    echo 'SMS sent';
                                    } elseif ($row['send_sms_status'] == 'Unsend') {
                                    echo 'Unsent';
                                    }elseif ($row['send_sms_status'] == '') {
                                    echo 'Unsent';
                                    }
                                    ?> </td>
                                <td><?php echo "SMS :".$row['sms_time_log']."<br>Email :".$row['email_time_log'];?></td>
                                <td data-title="Phone" >
                                    <a onclick="confirmSMS( '<?php echo $row['mobile']; ?>','<?php echo $row['school_id']; ?>','<?php echo $row['send_sms_status'];?>','<?php echo $row['scadmin_country']; ?>','<?= $i;?>');"><img src="/core/Images/S.png"></a>
                                    <?php if($send_to_email=='schooladmin'){?>
                                    <img src="/core/Images/E.png" onclick="confirmEmail('<?php echo $row['email_status'];?>','<?php echo $row['school_id']; ?>','<?php echo $row['email']; ?>','<?php echo $row['name']; ?>');" >
                                  <?php } ?>
                                   <?php if($send_to_email=='Coordinator'){?>
                                    <img src="/core/Images/E.png" onclick="confirmEmail('<?php echo $row['email_status'];?>','<?php echo $row['school_id']; ?>','<?php echo $email; ?>','<?php echo $row['name']; ?>');" >
                                  <?php } ?>
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
    $(document).ready(function(){
      $('.select1').select2();
    });

</script>

<script type="text/javascript">
    $("#country").change(function(){
        
        var c_id = $(this).val();
        $.ajax({
            url : "country_state_city.php",
            data : { c_id : c_id },
            type : "POST",
            success : function(data){
                $("#state").html(data);
            }

        });
    });
    
</script>
<script type="text/javascript">
    $("#state").change(function(){
        
        var s_id = $(this).val();
        // work_categoy=work_category.split('#');
        // var cat_id = work_category[0];
        
        $.ajax({
            url : "country_state_city.php",
            data : { s_id : s_id },
            type : "POST",
            success : function(data){
                $("#city").html(data);
            }

        });
    });
    
</script>
    
<script>
    $(document).ready(function(){
        $('#openMSGmodal').click(function(){
            $('#MyMSGModal').modal('show');
        });
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
    });

</script>

 <script type="text/javascript">
            $(document).ready(function(){


          $("#activated1").hide();
        $("#activated2").show();
        $('#colname').on('change', function() {


      if ( this.value == 'is_accept_terms')
      {
        $('#keywor').removeAttr('value');
        $("#activated1").show();
        $("#activated2").hide();
      }
      if ( this.value != 'is_accept_terms')
       {
          $("#activated1").hide();
        $("#activated2").show();
      
      }

    });
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