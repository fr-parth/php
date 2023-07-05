<?php
include 'sd_upload_function.php';
include "hr_header.php";





$report="";



$sca=get_school_id($_SESSION['id']);

$uploaded_by=$sca['name'];

$school_id=$sca['school_id'];

$redirect_to=''; 





if(isset($_POST['submit'])){

	if (!empty($_FILES["file"]["name"]) and !empty($_POST['table'])){

		

			$table=$_POST['table'];	

			$uploaded_by1=$_POST['uploaded_by'];

			if($uploaded_by1!=''){

				$uploaded_by=$uploaded_by1;

			}

			

			$upinfo=upload_info($table);

			$display_table_name=$upinfo['display_table_name'];

			$raw_table=$upinfo['raw_table'];

			$fields=$upinfo['fields'];

			$redirect_to=$upinfo['redirect_to']; 

			$filename=$upinfo['filename']; 

			$display_fields=$upinfo['display_fields'];

		

			$date=date('Y-m-d h:i:s',strtotime('+330 minute'));			



			$batch_id=get_last_batchid($school_id,$uploaded_by);

			

			$storagename= $_FILES["file"]["name"];

			$file_typ=explode(".", $storagename);	

			$file_type=$file_typ[1];

			

				

			

			$storagename = "Importdata/" . $_FILES["file"]["name"];

			if(file_exists($storagename)){

				unlink($storagename);

			}

			move_uploaded_file($_FILES["file"]["tmp_name"],  $storagename);

			

			

			//headers comparison

			$handle= fopen ( $storagename , "r" );			

			$first_row=	fgetcsv($handle);

			$firstRowTrimmed = array_map('trim', $first_row);

			

			$displayFields=explode(",",$display_fields);

			$displayFieldsTrimmed = array_map('trim', $displayFields);			

				

			$equal=strcmp(implode(",",$firstRowTrimmed),implode(",",$displayFieldsTrimmed));



			

			

			if($equal==0){

			//insert new batch id	

			$sql3=mysql_query("insert into tbl_Batch_Master (batch_id, input_file_name, uploaded_date_time, uploaded_by, entity, school_id, display_table_name, db_table_name)values('$batch_id', '$storagename', '$date', '$uploaded_by', 'School_Admin', '$school_id', '$display_table_name', '$table')");

			

			if($file_type=='csv'){	

					$j=mysql_query("LOCK TABLES $raw_table WRITE;")or die(mysql_error());

					$k=mysql_query("LOAD DATA LOCAL INFILE '$storagename' REPLACE INTO TABLE $raw_table

                                FIELDS TERMINATED BY \",\"

                                ENCLOSED BY '\"'

                                LINES TERMINATED BY \"\r\n\"                               

                                IGNORE 1 LINES

                                ( $fields ) 

							SET status='', upload_date='$date', uploaded_by='$uploaded_by', batch_id='$batch_id', validity=''") or die(mysql_error());

					

					$l=mysql_query("UNLOCK TABLES;")or die(mysql_error());

					

					if($k){

						

						$totrec1=mysql_query("select count(1) as totrec from ".$raw_table." where batch_id='$batch_id'");

						$totrecords=mysql_fetch_array($totrec1);

						$totrec=$totrecords['totrec'];						

						$upbm=mysql_query("update tbl_Batch_Master set num_records_uploaded='$totrec' where batch_id='$batch_id'")or die(mysql_error());

						

						echo "<script>

						alert('Uploaded To Temporary Table, Please go to Batch Upload Status');

						//window.location='$urlredirect';

						</script>";

					}										

			}else{

				$report="<span style='color:red;'>".'Please upload File In MS-DOS .CSV Format'."</span>";

			} 

			}else{

				$report="<span style='color:red;'>".'Please Check Uploaded File, Headers Do Not Match. '."</span>";

			}

		

	}else{

		$report="<span style='color:red;'>".'Please Select A File Or Table Name'."</span>";

	}	

}



if(isset($_POST['dformat'])){

			$table=$_POST['table'];		

	if($table!=''){

		$upinfo=upload_info($table);

		$display_table_name=$upinfo['display_table_name'];

		$raw_table=$upinfo['raw_table'];

		$filename=$upinfo['filename'];

		$display_fields=$upinfo['display_fields'];

		$redirect_to=$upinfo['redirect_to']; 

		

		$filename1=$school_id."_".$filename.".csv";

		$file = fopen($filename1,"w");

		fputcsv($file,explode(',',$display_fields));

		fclose($file);

		echo "<script>window.open('$filename1');</script>";			

	}



	



			

}

?><div class='container'>



<div class='panel panel-default'>

	<div class='panel-heading'>

		Upload Panel</div>

	<div class='panel-body'>

	<div class='row'>

	<div class='col-md-8'>



		<form method='post' enctype='multipart/form-data'>

		

		<input type='text' name='uploaded_by' id='uploaded_by' value='<?php if(isset($_POST['uploaded_by'])){ echo $_POST['uploaded_by'];}?>' placeholder='Uploaded By'/><br/>	<br/>	

			

				<select name='table' id='table'>

					<option value=''></option>

                    

					<option value='tbl_department_master'>Departments</option>

					<option value='tbl_academic_Year'>Academic Year</option>

					

					<option value='tbl_teacher'>Manager</option>

					<option value='tbl_student'>Employee</option>

					

					<option value='tbl_student_subject_master'>Employee Project</option>

                    <option value='tbl_teacher_subject_master'>Manager Project</option>                    

					
					<option value='Division'>Designation</option>

						

					<option value='tbl_school_subject'>Project</option>		

					<option value='tbl_CourseLevel'>Project Domain</option>	

					

					<option value='Branch_Subject_Division_Year'> Project  Year</option>

					

				</select><br/><br/>

				<input type='file' name='file'  accept='.csv,.xls,.xlsx' />   

				<br/><?php echo $report;?><br/>

				<button type='submit' name='submit' class='btn btn-success' >Upload</button>&nbsp;&nbsp;&nbsp;

				<button type='reset' name='reset' class='btn btn-alert' >Cancel</button>

			

			<!--<a href='<?php echo $redirect_to;?>'>Process Previous Batch Uploaded</a>-->

		



		</form>



	</div>

	<div class='col-md-4'>

			<!--format-->

		<form method='post' enctype='multipart/form-data'>

		<div class='row'>

			

			

				<select name='table' id='table'>

					<option value=''></option>

                    

					<option value='tbl_department_master'>Departments</option>

					<option value='tbl_academic_Year'>Academic Year</option>

				

					 <option value='tbl_teacher'>Manager</option>

					 <option value='tbl_student'>Employee</option>

					

					<option value='tbl_student_subject_master'>Employee Project</option>

                    <option value='tbl_teacher_subject_master'>Manager Project</option>                    

					<option value='tbl_degree_master'>Employee</option>
				

					<option value='tbl_school_subject'>Project</option>		

					<option value='tbl_CourseLevel'>Project Domain</option>	


					<option value='Branch_Subject_Division_Year'> Project  Year</option>

					

				</select>

				<button type='submit' name='dformat' class='btn btn-success btn-xs' >Download Format</button>

				

		</div>	

		</form>

		<!--end format-->

	</div>

		<div class='row'>

			<a href='sd_process_report.php'>Batch Scanning Status</a><br/>

			<a href='sd_upload_report.php'>Batch Upload Status</a><br/>

			<a href='Batch_Master_PT.php'>Overall Batch Report</a><br/>

		</div>

</div>

</div>

</div>