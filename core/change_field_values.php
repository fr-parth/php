<?php
error_reporting(0);
//include('conn.php');
include_once("cookieadminheader.php");
$report="";
$subject_id=$_GET['id'];

/*$id=$_SESSION['id'];
$query="select * from `tbl_school_admin` where id='$id'";       // getting the the school id of login user by checking the session
$row1=mysql_query($query);
$value1=mysql_fetch_array($row1);
 $school_id=$value1['school_id'];*/
$results=$smartcookie->retrive_individual($table,$fields);
$result=mysql_fetch_array($results);
include("table_name_array.php");
 if(isset($_POST['submit']))
	 {   
		$id=$_POST['dropcoll']; 
		$academic_year_ID=$_POST['academic_year_ID'];
		
			$tbl_name = $_POST['tbl_name']; 
			$field_name = $_POST['field_name'];
			$entity_name = $_POST['entity_name'];//exit;
		if($entity_name!=''){
			if($tbl_name=="tbl_student"){
			$where = " AND std_PRN='$entity_name'";
			}
			else if($tbl_name=="tbl_teacher"){
				$where = " AND t_id='$entity_name' ";
			}else if($tbl_name=="tbl_360_activities_data"){
				$where = " AND tID='$entity_name'";
			}else if($tbl_name=="tbl_360feedback_template"){
				 $where = " AND feed360_teacher_id='$entity_name'";
			}else if($tbl_name=="tbl_student_feedback"){
				$where = " AND stu_feed_teacher_id='$entity_name'";
			}else{
				$where ="";
			}
		}	
		else{
			$where ="";
		} 
		$oldpassword = mysql_real_escape_string($_POST['oldpwd']);
		$newpassword = mysql_real_escape_string($_POST['newpwd']);
		$confirmpassword= mysql_real_escape_string($_POST['confirmpwd']);
		//$oldpassword='';
		
      				if($newpassword==$confirmpassword && $oldpassword!=$newpassword)
						{	
					
							$insert=mysql_query("update ".$tbl_name." set ".$field_name." ='$newpassword' where school_id='$id' AND (t_academic_year='$oldpassword' OR t_academic_year='' OR t_academic_year IS NULL) $where");
								
							
							$insert1=mysql_query("update ".$tbl_name." set ".$field_name." ='$newpassword' where schoolID='$id' AND (Academic_Year IS NULL OR Academic_Year='' OR Academic_Year='$oldpassword' OR activity_name='$oldpassword' OR semester_name='$oldpassword' OR group_member_id='$oldpassword') $where"); 
							
							   $insert2=mysql_query("update ".$tbl_name." set ".$field_name." ='$newpassword' where feed360_school_id='$id' AND (feed360_academic_year_ID='$oldpassword' OR feed360_academic_year_ID IS NULL OR feed360_academic_year_ID='' OR feed360_subject_name='$oldpassword' OR feed360_semester_ID='$oldpassword' OR feed360_subject_code='$oldpassword') $where");
							
							$insert3=mysql_query("update ".$tbl_name." set ".$field_name." ='$newpassword' where stu_feed_school_id='$id' AND (stu_feed_academic_year='$oldpassword' OR stu_feed_academic_year='' OR stu_feed_academic_year IS NULL OR  stu_feed_semester_ID='$oldpassword' OR stu_feed_dept_ID='$oldpassword' OR stu_feed_que='$oldpassword') $where"); 
							
							if($insert)	
							{
				$successreport="Value Updated Successfully ";
			echo "<script>window.alert('$successreport')</script>";
							}else if($insert1)	
							{
				$successreport="Value Updated Successfully ";
				 echo "<script>window.alert('$successreport')</script>";
							}else if($insert2)	
							{
				$successreport="Value Updated Successfully ";
			 echo "<script>window.alert('$successreport')</script>";
							}else if($insert3)	
							{
				$successreport="Value Updated Successfully ";
				echo "<script>window.alert('$successreport')</script>";
							}
							else
							{
				$successreport1="Value Not Updated";
				 echo "<script>window.alert('$successreport1')</script>";
							}
														
						}
						else
						{
							
		$successreport1="New value & Confirm value Not Match Please Try Again";
		echo "<script>window.alert('$successreport1')</script>";
						}
	 }  
	
?>


<script>
	 $(document).ready(function() {
    	$('.searchselect').select2();
	});
function pvalid() {
//	alert("hiii");
	
	/*		//validation for Previous Password
			var prepass = document.getElementById("prepass").value;
            if (prepass.trim() == "" || prepass.trim() == null) {
                document.getElementById("prepass").innerHTML = "Enter Your Previous Password";
                return false;
            }else{
                document.getElementById("prepass").innerHTML = ""; 
            }
		*/	
			
			//validation for Country code
			var newpwd = document.getElementById("newpwd").value;
            if (newpwd.trim() == "" || newpwd.trim() == null) {
				
                document.getElementById("pass").innerHTML = "Please Enter Your New Value";

                return false;
            }else{
				
                document.getElementById("pass").innerHTML = ""; 
            }
			//validation for Country code
			var confirmpwd = document.getElementById("confirmpwd").value;
            if (confirmpwd.trim() == "" || confirmpwd.trim() == null) {
                document.getElementById("cpass").innerHTML = "Please Enter Your Confirm Value";
                return false;
            }else{
                document.getElementById("cpass").innerHTML = ""; 
            }
            var oldpwd = document.getElementById("oldpwd").value;
            if (oldpwd.trim() == "" || oldpwd.trim() == null) {
				
                document.getElementById("opass").innerHTML = "Please Enter Your Old Value";

                return false;
            }else{
				
                document.getElementById("opass").innerHTML = ""; 
            }
            if ((newpwd.trim())!=(confirmpwd.trim())) {
                document.getElementById("cpass").innerHTML = "New value and Confirm Value not matched";
                return false;
            }else{
                document.getElementById("cpass").innerHTML = ""; 
            }
		}
    </script>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title></title>
    <link rel="stylesheet" type="css" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
	<script type="text/javascript" src="js/jquery.form.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css" rel="stylesheet" />
<style type="text/css">
	.row{
		padding-bottom: 10px;
	}
</style>
</head>
<body>
<form action="" method="POST" onsubmit="return pvalid();">
	<div class="row">
    <!-- <div class="col-md-1 "></div> -->
	  	<div class=" col-md-offset-1 col-md-10 col-md-offset-1">
			<div class="panel panel-danger " style="margin-top:22px;">
				<div class="panel-heading text-center">
				    <h3 class="panel-title"><font color="#580000"><b>Bulk Update Database Value </b></font></h3>
				</div>
				<div class="panel-body" style="margin-top:10px;">
				 	<div class="center-block">
						<div class="row">
						 	<label for="type" class ="control-label col-md-3"> Select School Name:</label>
						 	<div class="col-md-6" >
							 	<select name="dropcoll" class="form-control searchselect" id="dropcoll" required>
								   <?php $sql1=mysql_query("Select id,school_name,school_id,password from tbl_school_admin  where `school_name`!='' group by school_name order by `id` desc");?>
									    <option value="<?php echo $school_id; ?>" disabled selected>School/College Name</option>
										
										<?php while($row=mysql_fetch_array($sql1)){ ?>
										
										<option value="<?php echo $row['school_id']; ?>" <?php if($row['school_id']==$id){ echo "selected";}else{}?>><?php echo $row['school_name']." (".$row['school_id'].")";?></option>	
								    <?php }?>
							  	</select>
							</div>
						</div>
						<div class="row">
							<label for="type" class ="control-label col-md-3"> Select Table Name:</label>
							<div class="col-md-6" >
							 	<select name="tbl_name" class="form-control searchselect" id="tbl_name" required>
									    <option value="" disabled selected>Select Table Name</option>
								   		<?php foreach($table as $code => $name){ ?>
										    <option value="<?= $code;?>"><?= $name;?></option>
										<?php } ?>
										
							  	</select>
							</div>
						</div>
						<div class="row" id="loader" class="text-center"></div>
						<div class="row" id="entity_div">
							<label for="type" class ="control-label col-md-3" id="entity_lbl"> Select Student / Teacher / Activity Data :</label>
							<div class="col-md-6" >
							 	<select name="entity_name" class="form-control searchselect" id="entity_name">
								    <option value="" disabled selected>First Select Table Name</option>		
							  	</select>
							</div>
							<div class="col-md-3 text-danger" id="entity_err"></div>
						</div>
						<div class="row">
							<label for="type" class ="control-label col-md-3"> Select Field Name:</label>
							<div class="col-md-6" >
							 	<select name="field_name" class="form-control searchselect" id="field_name" required>
								    <option value="" disabled selected>First Select Table Name</option>		
							  	</select>
							</div>
						</div>
						
						<div class="row">
							<label for="type" class ="control-label col-md-3">Old Field Value:</label>
							<div class="col-md-3" id="oldvalue">
								<input type="text" name="oldpwd"  id="oldpwd" placeholder="Old Value" class="form-control" >
							</div>
							<div class="col-md-6 text-danger" id="opass"></div>
						</div>

						<div class="row">
							<label for="type" class ="control-label col-md-3">New Field Value:</label>
							<div class="col-md-3" id="newvalue">
								<input type="text" name="newpwd"  id="newpwd" placeholder="New Value" class="form-control" >
							</div>
							<div class="col-md-6 text-danger" id="pass"></div>
						</div>
						<div class="row">
							<label for="type" class ="control-label col-md-3">Confirm Field Value:</label>
							<div class="col-md-3" id="confirmvalue">
								<input type="text" name="confirmpwd"  id="confirmpwd" placeholder="Confirm Value" class="form-control">
							</div>
							<div class="col-md-6 text-danger" id="cpass"></div>
						</div>
					</div>
				</div>
			</div>

			<div class="row" align="center">
						  <div class="col-md-4" ></div>
						  <div  class="col-md-4" >
							 <input type="submit" name="submit" value="Submit" class="btn btn-success" />
						  </div>
						   <div class="col-md-3" ></div>
						   
			</div>
			<!-- <div class="row" style="padding:30px;padding-left:330px;">
	                                    <div class="col-md-10" style="color:#F00;"  id="error">
	                                        <b><?php echo $successreport1; ?></b>
	                                    </div>
	        </div>
			<div class="row" style="padding:30px;padding-left:350px;">
	            <div class="col-md-7" style="color:#008000;" align="center" id="error">
	                <b><?php echo $successreport; ?></b>
	            </div>
	        </div>	 -->
		</div>			
	</div>		
</form>
<script type="text/javascript">
	$(document).ready(function(){
		    $('#entity_div').css('display','none'); 
		$('#tbl_name').change(function(){
			var tbl = $(this).val();
		    var scid = $('#dropcoll').val();
			if(tbl=='tbl_student'){
				$.ajax({
	                type: "POST",
	                url: "ajax_students_list.php",
	                dataType: 'text',
	                data:{id:scid},
	                beforeSend: function() { 
		                $('#loader').html('Please Wait for Minute !!!');    
			        }, 
	                success: function(table){
		                // alert('SMS Sent Successfully');
		                $('#loader').html('');
		                $('#entity_lbl').html('Select Student'); 
		                $('#entity_div').css('display','block'); 
		                $('#entity_name').html(table); 
	                }
	            });
			}
			else if(tbl=='tbl_teacher'){
				$.ajax({
	                type: "POST",
	                url: "ajax_teachers_list.php",
	                dataType: 'text',
	                data:{id:scid},
	                beforeSend: function() {
		                $('#loader').html('Please Wait for Minute !!!');
			        }, 
	                success: function(table){
		                // alert('SMS Sent Successfully');
		                $('#loader').html('');
		                $('#entity_lbl').html('Select Teacher'); 
		                $('#entity_div').css('display','block'); 
		                $('#entity_name').html(table); 
	                }
	            });
			}else if(tbl=='tbl_360_activities_data'){
				$.ajax({
	                type: "POST",
	                url: "ajax_360_activities_data.php",
	                dataType: 'text',
	                data:{id:scid},
	                beforeSend: function() {
		                $('#loader').html('Please Wait for Minute !!!');
			        }, 
	                success: function(table){
		                // alert('SMS Sent Successfully');
		                $('#loader').html('');
		               $('#entity_lbl').html('Select Activity'); 
		                $('#entity_div').css('display','block'); 
		                $('#entity_name').html(table); 
	                }
	            });
			}else if(tbl=='tbl_360feedback_template'){
				$.ajax({
	                type: "POST",
	                url: "ajax_teaching_process.php",
	                dataType: 'text',
	                data:{id:scid},
	                beforeSend: function() {
		                $('#loader').html('Please Wait for Minute !!!');
			        }, 
	                success: function(table){
		                // alert('SMS Sent Successfully');
		                $('#loader').html('');
		               $('#entity_lbl').html('Select Activity'); 
		                $('#entity_div').css('display','block'); 
		                $('#entity_name').html(table);
		                $('#entity_name').html(table); 
	                }
	            });
			}else if(tbl=='tbl_student_feedback'){
				$.ajax({
	                type: "POST",
	                url: "ajax_student_feedback.php",
	                dataType: 'text',
	                data:{id:scid},
	                beforeSend: function() {
		                $('#loader').html('Please Wait for Minute !!!');
			        }, 
	                success: function(table){
		                // alert('SMS Sent Successfully');
		                $('#loader').html('');
		               $('#entity_lbl').html('Select Activity'); 
		                $('#entity_div').css('display','block'); 
		                $('#entity_name').html(table); 
	                }
	            });
			}else {
		    	$('#entity_div').css('display','none');
			}
			$.ajax({
                type: "POST",
                url: "table_field_array.php",
                dataType: 'text',
                data:{t:tbl},
                success: function(table){
	                // alert('SMS Sent Successfully');
	                $('#field_name').html(table); 
                }
            });

			// $('#field_name').html()
		});

		$('#field_name').change(function(){
			var field = $(this).val();
		    var scid = $('#dropcoll').val();
			if(field=='school_type'){
				
		    	$('#newvalue').html('<select name="newpwd" id="newpwd" class="form-control"><option value="school">School</option><option value="organization">Organization</option></select>');
		    	$('#confirmvalue').html('<select name="confirmpwd" id="confirmpwd" class="form-control"><option value="school">School</option><option value="organization">Organization</option></select>');
			}
		});

		$('#field_name').change(function(){
			var field = $(this).val();
		    var scid = $('#dropcoll').val();
		    var tbl = $('#tbl_name').val();
			if(field=='entity_type_id' && tbl=='tbl_student'){
				
		    	$('#newvalue').html('<select name="newpwd" id="newpwd" class="form-control"><option value="105">105</option><option value="205">205</option></select>');
		    	$('#confirmvalue').html('<select name="confirmpwd" id="confirmpwd" class="form-control"><option value="105">105</option><option value="205">205</option></select>');
			}
			else if(field=='entity_type_id' && tbl=='tbl_teacher'){
				
		    	$('#newvalue').html('<select name="newpwd" id="newpwd" class="form-control"><option value="103">103</option><option value="203">203</option></select>');
		    	$('#confirmvalue').html('<select name="confirmpwd" id="confirmpwd" class="form-control"><option value="103">103</option><option value="203">203</option></select>');
			}

		});
	});
</script>
</body>
</html>


