<?php
//Created by Rutuja Jori on 28/08/2019 for Adding functionality to Update GroupMember ID

error_reporting(0);

include_once("cookieadminheader.php");
$report="";
$subject_id=$_GET['id'];

$results=$smartcookie->retrive_individual($table,$fields);
$result=mysql_fetch_array($results);


 
 if(isset($_POST['submit']))
	 {   

		 $school_name=$_POST['school_name']; 
		 
		  $r=explode(" ",$school_name);
		  $school_id=$r[0];
		  $sch_name=$r[1];
		   
		 
		 $group_member_id=$_POST['group_member_id'];
		 
          $selected_radio_value=$_POST['selected_radio_value'];
		 
	      
		 
		$update=mysql_query("update tbl_school_admin set group_member_id='$group_member_id' where school_id='$school_id'"); 
		$fetch=mysql_fetch_array($select);
	    
		
		if($selected_radio_value[0]=='teacher' || $selected_radio_value[1]=='teacher' || $selected_radio_value[2]=='teacher' || $selected_radio_value[3]=='teacher' || $selected_radio_value[4]=='teacher')
		{
		$update=mysql_query("update tbl_teacher set group_member_id='$group_member_id' where  school_id='$school_id'");
		}

		if($selected_radio_value[0]=='student' || $selected_radio_value[1]=='student' || $selected_radio_value[2]=='student' || $selected_radio_value[3]=='student' || $selected_radio_value[4]=='student')
		{
		$update=mysql_query("update tbl_student set group_member_id='$group_member_id' where  school_id='$school_id'"); 	
		}
		
	 if($selected_radio_value[0]=='student_subject' || $selected_radio_value[1]=='student_subject' || $selected_radio_value[2]=='student_subject' || $selected_radio_value[3]=='student_subject' || $selected_radio_value[4]=='student_subject')
		{
		$update=mysql_query("update tbl_student_subject_master set group_member_id='$group_member_id' where  school_id='$school_id'"); 
		}
		
		if($selected_radio_value[0]=='thanq_reason' || $selected_radio_value[1]=='thanq_reason' || $selected_radio_value[2]=='thanq_reason' || $selected_radio_value[3]=='thanq_reason' || $selected_radio_value[4]=='thanq_reason')
		{
		$update=mysql_query("update tbl_thanqyoupointslist set group_member_id='$group_member_id' where  school_id='$school_id'");	
		}


		if($update)	
	    {
		$successreport="Updated Successfully...!!!";
		}
		else
		{
		$successreport1="Failed to Update...";
		}

	   } 
	
?>

<script>

$(document).ready(function() {
    $('.searchselect').select2();

    <?php if(isset($_POST['submit'])){?>
            var base_url = "<?php echo $GLOBALS['URLNAME'];?>";
            var value =   "<?= $_POST['school_name'];?>";
			 var value =   "<?= $_POST['group_name'];?>";
			
         <?php  }?>
});
</script>




<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<link rel="stylesheet" href="../css/bootstrap.min.css">
<script src="../js/jquery-1.11.1.min.js"></script>
<script src="../js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css" href="../css/jquery.dataTables.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>
<script src='../js/bootstrap.min.js' type='text/javascript'></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.cs">
<!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>-->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css" rel="stylesheet" />

	 
 <form action="" method="POST" >
<div class="row">
    <div class="col-md-2 "></div>
  <div class="col-md-8 center centered">
<div class="panel panel-danger " style="margin-top:60px;">
  <div class="panel-heading text-center">
  
    <h3 class="panel-title"><font color="#580000"><b>Update Group Member ID For School </b></font></h3>
  </div>
  <div class="panel-body" style="margin-top:10px;">
 
 <div class="row">

 <div class="col-md-5" ><select name="school_name" class="form-control searchselect" id="school_name"  /required>
 
   <?php $sql1=mysql_query("Select id,school_name,school_id from tbl_school_admin  where school_name!='' group by school_name order by id desc");?>
    <option value="<?php echo $school_id; ?>" disabled selected>School/College Name</option>
	
	<?php while($row=mysql_fetch_array($sql1)){ ?>
	
	<option value="<?php echo $row['school_id'];?> <?php echo $row['school_name'];?>"><?php echo $row['school_name']." - " .$row['school_id'];?></option>
	
	
    <?php }?>
  </select>
</div>






 <div class="col-md-5" ><select name="group_member_id" class="form-control searchselect" id="group_member_id" style="margin-left:100px;" onChange="onSchoolChange()" /required>
   <?php $sql1=mysql_query("SELECT distinct(group_name),id FROM tbl_cookieadmin where group_name!='' and group_type!='admin';");?>
   
   
   <option value="<?php echo $school_id; ?>" disabled selected>Group Name</option>
	<?php while($row=mysql_fetch_array($sql1)){ ?>
	
	<option value="<?php echo $row['id'];?>"><?php echo $row['group_name']." - " .$row['id'];?></option>
	
	
    <?php }?>
  </select>
</div>


 


</div>
<?php echo "</br>";?>
<h3 class="panel-title"><font color="#580000"><b>Update Group Member ID Of following entities for Above Selected School: </b></font></h3>
<div id="selected_radio_value">
<?php echo "</br>";?>
<div>
<div>
<input type="checkbox" name="selected_radio_value[]" id="selected_radio_value" value="teacher">Teacher
</div>
<?php echo "</br>";?>
<div>
<input type="checkbox" name="selected_radio_value[]" id="selected_radio_value" value="student">Student
</div>
<?php echo "</br>";?>
<div>
<input type="checkbox" name="selected_radio_value[]" id="selected_radio_value" value="student_subject">Student-Subject
</div>
<?php echo "</br>";?>
<div>
<input type="checkbox" name="selected_radio_value[]" id="selected_radio_value" value="school_subject">School-Subject
</div>
<?php echo "</br>";?>
<div>
<input type="checkbox" name="selected_radio_value[]" id="selected_radio_value" value="thanq_reason">ThanQ Reason
</div>
</div>
</div>

<div>


<div class="row">
<div class="row" align="center">
					  <div class="col-md-4" ></div>
					  <div  class="col-md-4" >
						 <input type="submit" name="submit" value="Submit" class="btn btn-success"/>
					  </div>
					   <div class="col-md-3" ></div>
					   
				</div>
					</div>
				<div class="row" style="padding:30px;padding-left:300px;">
                                    <div class="col-md-7" style="color:#F00;" align="center" id="error">
                                        <b><?php echo $successreport1; ?></b>
                                    </div>
                                </div>
					<div class="row" style="padding:30px;padding-left:280px;">
                                    <div class="col-md-7" style="color:#008000;" align="center" id="error">
                                        <b><?php echo $successreport; ?></b>
                                    </div>
                                </div>	

							
				</form>
</div>
</div>
</div>
</div>
</div>
</html>


