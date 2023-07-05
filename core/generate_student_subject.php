<!-- add file for SMC-4137 By Kunal -->
<?php

include('scadmin_header.php');
$report = "";
$id = $_SESSION['id'];
$fields = array("id" => $id);
$table = "tbl_school_admin";
$smartcookie = new smartcookie();

$results = $smartcookie->retrive_individual($table, $fields);
$result = mysql_fetch_array($results);

$sc_id = $result['school_id'];


if (isset($_POST['submit']))
    {
    // $studprn = $_POST['textbox1'];
    // $stud = mysql_query("select student_id,subjcet_code,subjectName,Branches_id,Semester_id,CourseLevel,`id` from     tbl_student_subject_master join tbl_student s on s.std_PRN='$studprn' where `school_id`='$sc_id' and student_id='$studprn' order by `id`");

    	$cls = trim($_POST['class']);
    	$student = trim($_POST['student']);
    	if($student!="all"){
    		$query = "Select std_PRN,std_complete_name,std_div from tbl_student  where school_id='$sc_id' AND std_class='$cls' AND std_PRN='$student' AND std_complete_name!=''";
    	}else{
    		$query = "Select std_PRN,std_complete_name,std_div from tbl_student  where school_id='$sc_id' AND std_class='$cls' AND std_PRN!='' AND std_complete_name!=''";
    	}
    	//echo $query; exit;
    	$sql1=mysql_query($query);
    	$i=0;
    	$k=0;
    	$tbl = "<table class='table table-bordered'>
						<tr><th>Student Name</th><th>Division</th><th>Status</th></tr>";
			while($row=mysql_fetch_array($sql1)){
			$query2 = "Select id,subject_code,subject_name,branch,branch_id,semester,semester_id,course_level,dept_id,department,academic_year from tbl_class_subject_master  where school_id='$sc_id' AND class='$cls'";
			// echo $query2; exit;
			$sql2=mysql_query($query2);
			while($row2=mysql_fetch_array($sql2)){
				$std_PRN = $row['std_PRN'];
        $std_div = $row['std_div'];
				$subject_code = $row2['subject_code'];
				$subject_name = $row2['subject_name'];
				$semester = $row2['semester'];
				$branch = $row2['branch'];
				$department = $row2['department'];
				$course = $row2['course_level'];
				$academic_year = $row2['academic_year'];
				$uploadedBy = 'School_admin';
				$semesterid = $row2['semester_id'];
				$branchids = $row2['branch_id'];

				$upload_date=date('Y-m-d h:i:s');

				$query3 = "Select count(id) from tbl_student_subject_master  where school_id='$sc_id' AND student_id='$std_PRN' AND subjcet_code='$subject_code'";
			// echo $query3; exit;

				$sql3 = mysql_query($query3);
				$res3 = mysql_fetch_row($sql3);
				$cnt = $res3[0];
				//print_r($res3); exit;
				if($cnt>0){
					$tbl .= "<tr><th>".$row['std_complete_name']."</th>"."<th>".$std_div."</th><th>Duplicate Record</th></tr>";
					$k++;
				}else{

					$ins_query = "insert into tbl_student_subject_master (student_id,school_id,subjcet_code,subjectName,Semester_id,Branches_id,Department_id,CourseLevel,AcademicYear,upload_date,uploaded_by,ExtSemesterId,ExtBranchId,Division_id) values('$std_PRN','$sc_id','$subject_code','$subject_name','$semester','$branch','$department','$course','$academic_year','$upload_date','$uploadedBy','$semesterid','$branchids','$std_div')";
					// echo $ins_query; exit;
					mysql_query($ins_query);
					if(mysql_affected_rows()>0){
						$i++;
						$tbl .= "<tr><th>".$row['std_complete_name']."</th>"."<th>".$std_div."</th><th>Record Inserted.</th></tr>";
					}
				}
			}
 		}
 		$tbl .="</table>";
 		// echo "i".$i."-k".$k; exit;
 		if($i>0){
	 		if($k>0){
	 			$msg='<span class="text-danger"> '.$k.' duplicate record. </span><br> <span class="text-success">'.$i.' records Inserted Successfully.</span>';
	 		}else{
	 			$msg='<span class="text-success">'.$i.' records Inserted Successfully. </span>';
	 		}
	 	}else{
 			if($k>0){
	 			$msg='<span class="text-danger"> '.$k.' duplicate records. </span>';
	 		}else{
 				$msg='<span class="text-danger">No subject found for the class</span>';
 			}
 		}
    }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
<link rel="stylesheet" href="css/bootstrap.min.css">

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css" rel="stylesheet" />

<script src="js/jquery-1.11.1.min.js"></script>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Untitled Document</title>
</head>
<style type="text/css">
	form div{
		padding-top: 10px;
	}
</style>
<body bgcolor="#CCCCCC">
<div style="bgcolor:#CCCCCC">

    <div class="container" style="padding:30px;">


        <div style="border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">


            <div style="background-color:#F8F8F8 ;">
                <div class="row">

                    <div class="col-md-12 " align="center">
                        <h2 style="padding-top:30px;"><center>Generate <?php echo $dynamic_student;?>  <?php echo $dynamic_subject;?> </center></h2>
                    </div>

                </div>

                <form method="post">
                <div class="row" style="padding:10px;">
                    <div class="col-md-12">
                        <div class="col-md-4" style="color:#808080; font-size:18px;" ><?php echo $dynamic_class;?><b style="color:red";>*</b></div>
			            <div class="col-md-4">
						   <select name="class" id="class" class="form-control searchselect" required >
							   <option value="">Select <?php echo $dynamic_class;?></option>
				             	<?php
							 	$sql_dept=mysql_query("select class,ExtClassID from  Class where school_id='$sc_id' order by id");
								while($result_dept=mysql_fetch_array($sql_dept)){?>
								 <option value="<?php echo $result_dept['class'];?>"><?php echo $result_dept['class'];?></option>
								<?php } ?>
			            	</select>
			            </div>
						<div class='col-md-4 indent-small' id="errordepartment" style="color:#FF0000"></div>
		            </div>
		            <div class="clearfix"></div><div class="col-md-12" id="loader" style="text-align:center;"></div>

		            <div class="col-md-12">
                        <div class="col-md-4" style="color:#808080; font-size:18px;" ><?php echo $dynamic_student;?><b style="color:red";>*</b></div>
			            <div class="col-md-4">
						   <select name="student" id="student" class="form-control searchselect" required>
						   		<option value="">Select <?php echo $dynamic_class;?> First</option>
			             	</select>
			            </div>
						<div class='col-md-4 indent-small' id="errordepartment" style="color:#FF0000"></div>
		            </div>
                </div>


                <div class="row" style="padding:5px;">
                    <div class="col-md-4">
                    </div>
                    <div class="col-md-3 " align="center">
                    	<button class="btn btn-success" name="submit" type="submit">Generate</button> &emsp;
                    	<button class="btn btn-danger" name="btnback" type="button" onclick="window.history.back();"> Back</button>
                    </div>
                </div>


                        </form>
            </div>
        </div>
        <div class="row">
        	<div style="padding: 10px;">
        		<?php if(isset($msg)){echo $tbl.'<br>'.$msg;} ?>
        	</div>
        </div>
    </div>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>
<script type="text/javascript">
	$('document').ready(function(){
		$('.searchselect').select2();

		$('#class').change(function(){
			var cls = $(this).val();
			var scid = '<?= $sc_id; ?>';
			if(cls!=""){
				$.ajax({
	                type: "POST",
	                url: "ajax_students_classlist.php",
	                dataType: 'text',
	                data:{id:scid,cl:cls},
	                beforeSend: function() {
		                $('#loader').html('Please Wait for Minute !!!');
			        },
	                success: function(table){
		                // alert('SMS Sent Successfully');
		                $('#loader').html('');
		                $('#student').html(table);
	                }
	        	});
			}else{
				$('#student').html('<option value="">Select <?php echo $dynamic_class;?> First</option>')
			}
		});
	});
</script>
</html>
