<?php
error_reporting(0);
include("groupadminheader.php");

// $batch_id=$_GET['batch_id'];
$School_id=$_GET['school_id'];
// $Sms_status=$_GET['status'];
$country=$_GET['country'];
$dept=$_GET['t_dept'];



$group_member_id = $_SESSION['group_admin_id'];

// $smartcookie=new smartcookie();
// $id=$_SESSION['id'];
//  $fields=array("id"=>$id);
//  $table="tbl_school_admin";
// $smartcookie=new smartcookie();		   
// $results=$smartcookie->retrive_individual($table,$fields);
// $result=mysql_fetch_array($results);
// $sc_id=$result['school_id'];

$sc_id=$School_id;

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
        


<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Smart Cookie:Send SMS/EMAIL</title>

<style>

.dropdown1{padding-left:460px;margin-top:15px;}
.dropdown3{padding-left:500px;margin-top:15px;}
.ul {}

</style>
</head>
<script>
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

  <!-- Trigger the modal with a button -->
 

  <!-- Modal -->


<div class="container"  style="padding:30px;width:1500px" >
        
        <div class="modal fade" id="MyModal" tabindex="0" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
       <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
         <h4 class="modal-title">Send Email To All</h4>
       </div>
       <div class="modal-body" style="overflow-x: scroll;">
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
					<!-- <a href="SendEmail_toAll_dept_teacher.php?t_dept=<?php echo $dept;?>&school_id=<?php echo $School_id;?>&status=<?php echo $Sms_status;?>"> <img src="Images/Email.png"></a> -->					 <!--  <input type="submit" class="btn btn-primary" name="submit" value="Add Teacher" style="width:150;font-weight:bold;font-size:14px;"/></a>-->
					 <a class="btn btn-lg" data-toggle="modal" data-target="#myModal" id="openmodal" > <img src="../Images/Email.png"></a>
					 </div>
					  
              			<div class="col-md-4 " align="center"  >
                   			<h2>Send SMS/EMAIL</h2>
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
					</div>

					<div class="col-md-4">
                    <div class="dropdown3">
                        <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu3" data-toggle="dropdown" aria-expanded="true">Select Department<span class="caret"></span></button>
                        <?php $sql1 = mysql_query("Select DISTINCT(batch_id) as batch_id,t_dept,school_id,send_unsend_status,t_country from tbl_teacher where school_id='$sc_id' group by t_dept"); ?>
                        <ul class="dropdown-menu " role="menu" aria-labelledby="dropdownMenu2" style="margin-left:509px"; >
                            <?php while ($row = mysql_fetch_array($sql1)){ ?>
                            <li role="presentation"><a role="menuitem" tabindex="-1" href="SendMSG_alldept_Teacher.php?t_dept=<?php echo $row['t_dept']; ?>&school_id=<?php echo $row['school_id']; ?>&status=<?php echo $row['send_unsend_status']; ?>&country=<?php echo $row['t_country']; ?>"><?php echo $row['t_dept']; ?><?php } ?> </a></li>
                        </ul>
                    </div>
                </div>
				</div> 	
			
               <div class="row" style="padding:10px;" >
             
         
               <div class="col-md-12  " id="no-more-tables" >
               <?php $i=0;?>
                  <table class="table-bordered  table-condensed cf" id="example" width="100%;" >
                     <thead>
                    	<tr style="background-color:#428BCA" ><th style="width:10%;" ><b>Sr.No</b></th><th style="width:20%;"><b>Teacher ID</b></th><th style="width:20%;" >Name</th><th style="width:20%;">Phone No.</th><th style="width:20%;">Email ID</th> </th><th style="width:10%;">Department</th> </th><th style="width:10%;">SMS Status</th><th style="width:10%;">Email Status</th> </th><th style="width:20%;">Send SMS/Email</th> </th>
                      
                        </tr></thead><tbody>
                 <?php
				 
				   $i=1;
				   if(isset($_GET['t_dept'])){
				   	$sqln1 = "select id,t_id,t_complete_name,t_dept,t_phone,t_email,t_internal_email,batch_id,send_unsend_status,email_status,t_country,school_id from tbl_teacher where school_id='$School_id' and t_dept='$dept' and error_records like 'Correct' order by id";
				   }else{
				   	$sqln1 = "select id,t_id,t_complete_name,t_dept,t_phone,t_email,t_internal_email,batch_id,send_unsend_status,email_status,t_country,school_id from tbl_teacher where school_id='$School_id' and error_records like 'Correct' order by id";
				   }
				  $arr=mysql_query($sqln1);
				  ?>
                  <?php while($row=mysql_fetch_array($arr)){
				  $teacher_id=$row['id'];
				  ?>
                    <tr style="color:#808080;" class="active">
                    <td data-title="Sr.No" style="width:4%;" ><b><?php echo $i;?></b></td>
					<td data-title="Teacher ID" style="width:6%;" ><b><?php echo $row['t_id'];?></b></td>
                    <td data-title="First Name" style="width:12%;"><?php echo $row['t_complete_name']?></td> 
                 
	                <td data-title="Phone" style="width:10%;"><?php echo $row['t_phone'];?> </td>
				     <td data-title="Email" style="width:10%;"><?php if($row['t_email']=="")
										{
											echo $row['t_internal_email'];
										}
										else
										{
											echo $row['t_email'];
											
										}?> </td>
				     <!-- <td data-title="Batch Id" style="width:6%;"><?php echo $row['batch_id'];?> </td> -->
					  <td data-title="Batch Id" style="width:6%;"><?php echo $row['t_dept'];?> </td>
					   <td data-title="Send/Unsen Status" style="width:5%;"><?php echo $row['send_unsend_status'];?> </td>
					    <td data-title="Send/Unsen Status" style="width:5%;"><?php echo $row['email_status'];?> </td>
					    <td data-title="Phone" style="width:10%;"><a href="SendSMS_Teacher.php?phone=<?php echo $row['t_phone'];?>&school_id=<?php echo $row['school_id'];?>&status=<?php echo $row['send_unsend_status'];?>&country=<?php echo $row['t_country'];?>"><img src="../Images/S.png"></a>
						 <a href="SendEmail_Teacher.php?email=<?php if($row['t_email']=="")
										{
											echo $row['t_internal_email'];
										}
										else
										{
											echo $row['t_email'];
											
										}?>&school_id=<?php echo $row['school_id'];?>&status=<?php echo $row['email_status'];?>"><img src="../Images/E.png"></a>
						 </td>
				 
    
                   
                  
                   
                    
                    
                  
                 </tr>
                <?php $i++;?>
                 <?php }?>
                  
                  </tbody>
                  </table>
                
                  </div>
                  </div>
                  
                  
                   <div class="row" style="padding:5px;">
                   <div class="col-md-4">
               </div>
                  <div class="col-md-3 "  align="center">
                   
                   </form>
                   </div>
                    </div>
                     <div class="row" >
                     <div class="col-md-4">
                     </div>
                      <div class="col-md-3" style="color:#FF0000;" align="center">
                      
                      <?php echo $report;?>
               			</div>
                 
                    </div>
                      
                
                  
                 
                    
                    
                  
               </div>
               </div>

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