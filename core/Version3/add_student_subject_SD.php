<?php
//add the student subject records
include("scadmin_header.php");
include_once("conn.php");
	
$report="";

//get school mnemonic
$id=$_SESSION['id'];
$query="select * from `tbl_school_admin` where id='$id'";       // uploaded by
$row=mysql_query($query);
$value=mysql_fetch_array($row);
$uploaded_by=$value['name'];
$school_id=$value['school_id'];


if(isset($_POST['submit'])){
	if (!empty($_FILES["file"]["name"])){
			//get last batch id
			$sql2=mysql_query("select batch_id from tbl_Batch_Master where school_id='$school_id' and entity='School_Admin' and uploaded_by like '$uploaded_by' order by id desc");
			
			$resultsql=mysql_fetch_array($sql2);
			$count=mysql_num_rows($sql2);	 
			$date=date('Y-m-d h:i:s',strtotime('+330 minute'));
			
					if($count==""){
						$batch_id=$school_id."-"."B-1";
								 
					}else{	
						$batch_id=$resultsql['batch_id'];
						$b_id=explode("-",$batch_id);
						$batch=$b_id[2];
						$batch=$batch+1;
						$batch_id=$school_id."-"."B-".$batch;
					}
			
			$storagename= $_FILES["file"]["name"];
			$file_typ=explode(".", $storagename);	
			$file_type=$file_typ[1];
			
			//insert new batch id
			$sql3=mysql_query("insert into tbl_Batch_Master (batch_id,input_file_name,uploaded_date_time,uploaded_by,entity,school_id)values('$batch_id','$storagename','$date','$uploaded_by','School_Admin','$school_id') ");
			
			$storagename = "Importdata/" . $_FILES["file"]["name"];
			
			move_uploaded_file($_FILES["file"]["tmp_name"],  $storagename);
			
			if($file_type=='csv'){	
					$j=mysql_query("LOCK TABLES `tbl_student_subject` WRITE;")or die(mysql_error());
					$q="LOAD DATA LOCAL INFILE '$storagename' REPLACE INTO TABLE tbl_student_subject
                                FIELDS TERMINATED BY \",\"
                                ENCLOSED BY '\"'
                                LINES TERMINATED BY \"\r\n\"                               
                                IGNORE 1 LINES
                                ( student_id, school_id, subjcet_code, subjectName, Division_id, Semester_id, Branches_id, Department_id, CourseLevel, AcademicYear, teacher_ID ) 
								SET school_staff_id='', status='', upload_date='$date', uploaded_by='$uploaded_by', batch_id='$batch_id'";	
					$k=  mysql_query($q) or die(mysql_error());
					$l=mysql_query("UNLOCK TABLES;")or die(mysql_error());
					
					if($k){
						$datatoraw=true;
						header("Location: process_batch_sch_sub.php");
					}										
			}else{
				$report='Please upload File In MS-DOS .CSV Format';
			}
			
		
	}else{
		$report='Please Select A File';
	}	
}



?>
<div class='container'>
<div class='panel panel-default'>
	<div class='panel-heading'>
		Add Student Subject Excel Sheet
	</div>
	<div class='panel-body'>
		<form method='post' enctype='multipart/form-data'>
		<div class='row'>
			<div class='col-md-4 col-md-offset-4'>
				<input type='file' name='file'  accept='.csv,.xls,.xlsx' />   
				<br/>
				<input type="radio" name="scan" id="scan" value="0" checked="checked"  />Scan Only 
				&nbsp;&nbsp;&nbsp;
				<input type="radio" name="scan" id="scan" value="1"  />	Scan and Upload
				<br/><br/><?=$report;?><br/>
				<button type='submit' name='submit' class='btn btn-success' >Upload</button>&nbsp;&nbsp;&nbsp;
				<button type='reset' name='reset' class='btn btn-alert' >Cancel</button>
			</div>
		</div>	
		</form>
		<div class='row'>
		<div class='col-md-4 col-md-offset-4'>
			<!--add excel sheet format here-->
		</div>
		</div>
	</div>

</div>
</div>
