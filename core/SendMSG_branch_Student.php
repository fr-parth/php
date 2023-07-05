<?php
error_reporting(0);
include("scadmin_header.php");

$std_branch=$_GET['std_branch'];
//$p_lenght=strlen(trim(($phone)));
$School_id=$_GET['school_id'];
$Sms_status=$_GET['status'];
$country=$_GET['country'];




$smartcookie=new smartcookie();
$id=$_SESSION['id'];
 $fields=array("id"=>$id);
 $table="tbl_school_admin";
$smartcookie=new smartcookie();		   
$results=$smartcookie->retrive_individual($table,$fields);
$result=mysql_fetch_array($results);
$sc_id=$result['school_id'];

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
<link rel="stylesheet" href="css/bootstrap.min.css">
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.dataTables.min.js"></script>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.cs">

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
.dropdown2{padding-left:500px;margin-top:15px;}

</style>
</head>
<script>
$(document).ready(function() {
    $('#example').dataTable( {
      
    } );
} );


function confirmation(xxx) {

    var answer = confirm("Are you sure you want to delete?")
    if (answer){
        
        window.location = "delete_teacher.php?id="+xxx;
    }
    else{
       
    }
}

</script>
<body bgcolor="#CCCCCC">
<div style="bgcolor:#CCCCCC">

<div class="container"  style="padding:30px;width:1500px" >
        	
            
            	<div style="border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">
                   
                    
                    <div style="background-color:#F8F8F8 ;">
                    	<div class="row">
                    <div class="col-md-4 "  style="color:#700000 ;padding:5px;" >&nbsp;&nbsp;&nbsp;&nbsp;
				
					 <a href="SendSMS_toAll_batch_student.php?batch_id=<?php echo $batch_id;?>&school_id=<?php echo $School_id;?>&status=<?php echo $Sms_status;?>&country=<?php echo $country;?>"> <img src="images/Sms.png"></a>
					 <a href="SendEmail_toAll_batch_student.php?batch_id=<?php echo $batch_id;?>&school_id=<?php echo $School_id;?>&status=<?php echo $Sms_status;?>"> <img src="images/Email.png"></a> 					 <!--  <input type="submit" class="btn btn-primary" name="submit" value="Add Teacher" style="width:150;font-weight:bold;font-size:14px;"/></a>-->
                        </div>
              			 <div class="col-md-4 " align="center" >
                         	
                   				<h2>Send SMS/EMAIL</h2>
               			 </div>
                         
                     </div>
					 
                  <div class="row">
				  <div class="col-md-4">
				<div class="dropdown1">
				  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
				Send SMS/ Email to Students 
					<span class="caret"></span>
				  </button>
				  
				  <ul class="dropdown-menu " role="menu" aria-labelledby="dropdownMenu1">
				 
					
					<li role="presentation"><a role="menuitem" tabindex="-1" href="Send_Msg_Teacher.php">TEACHERS</a></li>
					<li role="presentation"><a role="menuitem" tabindex="-1" href="Send_Msg_Student.php">STUDENTS </a></li>
					
				  </ul>
				</div>
				</div>
				</div>
				
				<div class="col-md-4">
				<div class="dropdown2">
				  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-expanded="true">
				Batch ID's
					<span class="caret"></span>
				  </button>
				   <?php $sql1=mysql_query("Select DISTINCT(batch_id) as batch_id,school_id,send_unsend_status from tbl_student where school_id='$sc_id' group by batch_id" );?>
				  <ul class="dropdown-menu " role="menu" aria-labelledby="dropdownMenu2">
				 <?php while($row=mysql_fetch_array($sql1)){ ?>
					
					
					<li role="presentation"><a role="menuitem" tabindex="-1" href="SendMSG_allbatch_Student.php?batch_id=<?php echo $row['batch_id'];?>&school_id=<?php echo $row['school_id'];?>&status=<?php echo $row['send_unsend_status'];?>&country=<?php echo $row['std_country'];?>"><?php echo $row['batch_id'];?><?php }?> </a></li>
					
				  </ul>
				</div>
				</div>
				
			 <div class="row" style="padding:10px;" >
             
             <div class="col-md-9">
				<div class="dropdown2">
			<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-expanded="true">
				Department
					<span class="caret"></span>
				  </button>
<?php $sql1=mysql_query("Select DISTINCT(std_dept) as std_dept,school_id,send_unsend_status,std_country from tbl_student where school_id='$sc_id' group by std_dept" );?>
				  <ul class="dropdown-menu " role="menu" aria-labelledby="dropdownMenu2">
				 <?php while($row=mysql_fetch_array($sql1))
				 { 
				 ?>
<li role="presentation"><a role="menuitem" tabindex="-1" href="SendMSG_department_Student.php?dpt_id=<?php echo $row['std_dept'];?>&school_id=<?php echo $row['school_id'];?>&status=<?php echo $row['send_unsend_status'];?>&country=<?php echo $row['std_country'];?>"><?php echo $row['std_dept'];?><?php }?> </a></li>
					
				  </ul>
				</div>
				</div>
                
           <div class="col-md-7">
			<div class="dropdown2">
			<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-expanded="true">
				Branch
					<span class="caret"></span>
				  </button>
<?php $sql1=mysql_query("Select DISTINCT(std_branch) as std_branch,school_id,send_unsend_status,std_country from tbl_student where school_id='$sc_id' group by std_branch" );?>
				  <ul class="dropdown-menu " role="menu" aria-labelledby="dropdownMenu2">
				 <?php while($row=mysql_fetch_array($sql1))
				 { 
				 ?>
<li role="presentation"><a role="menuitem" tabindex="-1" href="SendMSG_branch_Student.php?std_branch=<?php echo $row['std_branch'];?>&school_id=<?php echo $row['school_id'];?>&status=<?php echo $row['send_unsend_status'];?>&country=<?php echo $row['std_country'];?>"><?php echo $row['std_branch'];?><?php }?> </a></li>
					
				  </ul>
				</div>
		   </div>
             
         
               <div class="col-md-12  " id="no-more-tables" >
               <?php $i=0;?>
                  <table class="table-bordered  table-condensed cf" id="example" width="100%;" >
                     <thead>
                    	<tr style="background-color:#428BCA" ><th style="width:10%;" ><b>Sr.No</b></th><th style="width:20%;"><b>Student PRN</b></th><th style="width:20%;" >First Name</th><th style="width:30%;" >Last Name</th><th style="width:20%;">Phone No.</th><th style="width:20%;">Email ID</th> </th><th style="width:10%;">Branch</th> </th><th style="width:10%;">Message Status</th>  
                        <th style="width:15%;">Send SMS/Email</th>
                        </tr></thead><tbody>
                 <?php
				 
				   $i=1;
				  $arr=mysql_query("select * from tbl_student where school_id='$School_id' and error_records like 'Correct' and std_branch like '$std_branch' order by id");?>
                  <?php while($row=mysql_fetch_array($arr)){
				  //$teacher_id=$row['id'];
				  ?>
                    <tr style="color:#808080;" class="active">
                    <td data-title="Sr.No" style="width:4%;" ><b><?php echo $i;?></b></td>
					<td data-title="Teacher ID" style="width:6%;" ><b><?php echo $row['std_PRN'];?></b></td>
                    <td data-title="Name" style="width:12%;"><?php echo $row['std_name']?></td> 
                 
					<td data-title="Name" style="width:12%;"><?php echo $row['std_lastname']?></td> 
                     <td data-title="Phone" style="width:10%;"><?php echo $row['std_phone'];?> </td>
				     <td data-title="Phone" style="width:8%;"><?php echo $row['std_email'];?> </td>
				      <td data-title="Phone" style="width:6%;"><?php echo $row['std_branch'];?> </td>
					   <td data-title="Phone" style="width:5%;"><?php echo $row['send_unsend_status'];?> </td>
					    <td data-title="Phone" style="width:10%;"><a href="SendSMS_Student.php?phone=<?php echo $row['std_phone'];?>&school_id=<?php echo $row['school_id'];?>&status=<?php echo $row['send_unsend_status'];?>&country=<?php echo $row['std_country'];?>"><img src="images/S.png"></a>
						<a href="SendEmail_Student.php?email=<?php echo $row['std_email'];?>&school_id=<?php echo $row['school_id'];?>&status=<?php echo $row['send_unsend_status'];?>"><img src="images/E.png"></a>
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

</body>
</html>
















