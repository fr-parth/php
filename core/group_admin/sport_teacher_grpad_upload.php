<?php
include("groupadminheader.php");
//include('../conn.php');


$uploaded_by1 = $_SESSION['group_admin_id'];
$group_type = $_SESSION['data'][0]['status'];
$group_member_id = $_SESSION['group_admin_id'];


/*function url(){
  return sprintf(
    "%s://%s",
    isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
    $_SERVER['SERVER_NAME']
  );
}*/


if($_SESSION['entity'] !=12){

	echo "You are not authorize to view this page.";
	exit;
}
?>
<div class='container'>



<div class='panel panel-default'>

	<div class='panel-heading' align ='center'>

<h2>Teacher Upload Panel</h2></div>
<form method="post" action="" enctype="multipart/form-data">
<table align='left'>
<input type='text' name='uploaded_by' id='uploaded_by'  placeholder='Uploaded By'/>
<tr><br><td><b>Select  to upload data : </td><td><select name="file_type" id= "file_type"/><option value="">Select data</option>
<option value='basic_data'>Teacher's data</option>
<!-- <option value='all_data'>Student's all data</option> --></td></tr>
<tr><br><td><b>Select file: </td><td><input type="file" name="csv" id="csv" /></td></tr>
		   
		<tr><td><br><input class="btn btn-success" type="submit" name="submit_file" value="Submit"/></td></tr>
		</table>
 </form>

 <form method='post' enctype='multipart/form-data'>
<table align='right'>
		<div class='row'>
			<select name='data_format' id='data_format'>

				<option value=''>Select format</option>
				<option value='basic_data_format'>Teacher's data format</option>
				<!-- <option value='all_data_format'>Student's all data format</option> -->
			</select>

			<button type='submit' name='dformat' class='btn btn-success btn-xs' >Download Format</button>
			<button type='submit' name='previewformat' class='btn btn-success btn-xs' >Preview</button>
		</div>	
</table>
		</form>
	<div class='panel-body'>

	<div class='row'>

	<div class='col-md-8'>

	</div>
	</div>
	</div>
	</div>
	</div>

	<?php

//header('Content-Type: text/plain; charset=utf-8');

function random_password( $length = 8 ) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $password = substr( str_shuffle( $chars ), 0, $length );
    return $password;
}

if(isset($_POST["submit_file"]))
 { 
$uploadby = $_POST['uploaded_by'];
if($uploadby == ''){
	$query = mysql_query("select admin_name from tbl_cookieadmin where id='$group_member_id'");
	$row = mysql_fetch_array($query);
	$uploaded_by = $row['admin_name'];
}else{
	$uploaded_by = $uploadby;
}
 if($_FILES['csv']['error'] == 0){
	  
	$target_path = "Importdata/";
	$target_location = $target_path . basename($_FILES['csv']['name']);
    $name = $_FILES['csv']['name'];
    $ext = strtolower(end(explode('.', $_FILES['csv']['name'])));
    $type = $_FILES['csv']['type'];
    $tmpName = $_FILES['csv']['tmp_name'];
	 
    // check the file is a csv
    if($ext === 'csv'){
	
        if(($handle = fopen($tmpName, 'r')) !== FALSE) {
            // necessary if a large csv file
            set_time_limit(0);

            $row = 0;

            while(($data = fgetcsv($handle, 100000, ',')) !== FALSE) {
                // number of fields in the csv
                
$the_big_array[] = $data;
                //$col_count get the values from the csv
              $csv[$row]['col1'] = $data[0];
                $csv[$row]['col2'] = $data[1];

                // inc the row
                $row++;
            }

            fclose($handle);
        }
		move_uploaded_file($tmpName, $target_location);
    }
	
unset($the_big_array[0]);
$xyz = count($the_big_array);
	//print_r($the_big_array);
	 $x = 1;
	 
$filetype = $_POST["file_type"];
// code for batch id
		$sql2=mysql_query("select batch_id from tbl_Batch_Master where batch_id like 'G-%' order by id desc limit 1");			

			$resultsql=mysql_fetch_array($sql2);

			$batchcount=mysql_num_rows($sql2);

			

			if($batchcount==""){
					
				$batch_id="G-".$group_member_id."-1";

						 

			}else{	

				$batch_id=@$resultsql['batch_id'];

				$b_id=explode("-",$batch_id);

				$batch=@$b_id[2];

				$batch=$batch+1;

				$batch_id="G-".$group_member_id."-".$batch;

			}
// End batch id code

	if($filetype == "")
	 {
		echo "Please select data File to upload ";
		exit;
	 }

    if ($tmpName == NULL) {
     echo "Please select a file to import";
      
    }
	else if($filetype == 'basic_data'){
		
		
		foreach ($the_big_array as $data){
			$teacher_name = trim($data[0]);
			$teacher_mobile	= trim($data[1]);
			$teacher_email = trim($data[2]);
			$school_id = trim($data[4]);
			$teacher_id = trim($data[5]);
			

			$queryreject = "select * from tbl_school_admin where school_id='$school_id' and group_member_id='$group_member_id'";
			$queryresp = mysql_query($queryreject);
			$rowquery = mysql_fetch_array($queryresp);
			$mainschool = $rowquery['school_id'];
			

if (($teacher_name == '' || $school_id == '' ) || ($teacher_id== '' && $teacher_email == '' && $teacher_mobile == '') ||  $mainschool != $school_id || !preg_match("/^[6-9][0-9]{9}$/", $teacher_mobile) || !filter_var($teacher_email, FILTER_VALIDATE_EMAIL) ){

	
	        $teacher_name = 0;
			$teacher_mobile	= 0;
			$teacher_email = 0;
			$school_name = 0;
			$school_id = 0;
			$teacher_id = 0;
			$empType_id = 0;
			$password = "";
			
			$queryreject8 = "select * from tbl_school_admin where school_id='$school_id' and group_member_id='$group_member_id'";
			$queryresp8 = mysql_query($queryreject8);
			$rowquery8 = mysql_fetch_array($queryresp8);
			$mainschool8 = $rowquery8['school_id'];
			
		$teacher_name112 = trim($data[0]);
		if($teacher_name112 == ''){
			$teacher_name11 = '';
		}else{
			$teacher_name11 = trim($teacher_name112);
		}
		
		$teacher_mobile112 = trim($data[1]);
		if($teacher_mobile112 == ''){
			$teacher_mobile11 = '';
		}else if(!preg_match("/^[6-9][0-9]{9}$/", $teacher_mobile112)){
			$teacher_mobile11 = trim($teacher_mobile112);
		}
		else{
			$teacher_mobile11 = trim($teacher_mobile112);
		}
		

		$teacher_email112 = trim($data[2]);

		if($teacher_email112 == ''){
			$teacher_email11 = '';
		}else if(!filter_var($teacher_email112, FILTER_VALIDATE_EMAIL)){
			$teacher_email11 = trim($teacher_email112);
		}
		else{
			$teacher_email11 = trim($teacher_email112);
		}
		
		$school_id112 = trim($data[4]);
		if($school_id112 == ''){
			$school_id11 = '';
		}else if($school_id112 != $mainschool8){
			$school_id11 = trim($school_id112);
		}else{
			$school_id11 = trim($school_id112);
		}
		
		$teacher_id112 = trim($data[5]);
		if($teacher_id112 == ''){
			$teacher_id11 = '';
		}else{
			$teacher_id11 = trim($teacher_id112);
		}
		
			$school_name11 = trim($data[3]);
			$empType_id11 = trim($data[6]);
			$msg = "Error";
			
			$sql7 = "INSERT INTO tbl_raw_teacher(t_complete_name,t_phone,t_email,t_school_name,t_school_id,t_id,t_date,t_password,error_msg,created_by,created_on,group_member_id,t_emp_type_pid,batch_id,upload_date,uploaded_by,status) values ('$teacher_name11','$teacher_mobile11','$teacher_email11','$school_name11','$school_id11','$teacher_id11',NOW(),'$password','$msg',$uploaded_by1,NOW(),'$group_member_id','$empType_id11','$batch_id',NOW(),'$uploaded_by','error')"; 
            $res7 = mysql_query($sql7);
			
		}else{
			if($teacher_id== '' && $teacher_mobile!= ''){
		$teacher_id = $teacher_mobile;
	}
	else if($teacher_id== '' && $teacher_mobile== '' && $teacher_email != ''){
		$teacher_id = $teacher_email;
	}else{
		$teacher_id = trim($data[5]);
	}
	
	        $teacher_name = trim($data[0]);
			$teacher_mobile	= trim($data[1]);
			$teacher_email = trim($data[2]);
			$school_name = trim($data[3]);
			$school_id = trim($data[4]);
			
			$empType_id = trim($data[6]);
			$pass = explode(' ',$teacher_name);
		 	$password = $pass[0].'123';
			
			$maxquery = mysql_query("select * from tbl_teacher where t_id='$teacher_id ' AND school_id='$school_id'");
$std_PRN1 = mysql_fetch_array($maxquery);
$std_PRN = $std_PRN1['t_id'];
if($std_PRN == $teacher_id){
	if($teacher_name == ''){
		$teacher_name = $std_PRN1['t_complete_name'];
	}
	if($teacher_mobile == ''){
		$teacher_mobile = $std_PRN1['t_phone'];
	}
	if($teacher_email == ''){
		$teacher_email = $std_PRN1['t_email'];
	}
	if($school_name == ''){
		$school_name = $std_PRN1['t_school_name'];
	}
	if($empType_id == ''){
		$empType_id = $std_PRN1['t_emp_type_pid'];
	}
	$mysqlquery = "update tbl_teacher set t_complete_name ='$teacher_name',t_phone='$teacher_mobile',t_email='$teacher_email',t_current_school_name='$school_name',t_emp_type_pid='$empType_id',t_date=NOW(),t_password='$password',created_by='$uploaded_by1',created_on=NOW(),error_records='Update',batch_id='$batch_id' where t_id='$teacher_id' AND school_id='$school_id' and group_member_id='$group_member_id'"; 
                $mysqlres = mysql_query($mysqlquery);
}else{

	$sql6 = "INSERT INTO tbl_teacher (t_complete_name,t_phone,t_email,t_current_school_name,school_id,t_id,t_date,t_password,created_by,created_on,group_member_id,t_emp_type_pid,batch_id,error_records) values ('$teacher_name','$teacher_mobile','$teacher_email','$school_name','$school_id','$teacher_id',NOW(),'$password','$uploaded_by1',NOW(),'$group_member_id','$empType_id','$batch_id','Insert')"; 

    $mysqlres = mysql_query($sql6);

}
			
			
			
		}

	
		}
		
		
	}
        $a = mysql_query("select * from tbl_teacher WHERE batch_id='$batch_id' AND error_records='Insert'");
		$i = mysql_num_rows($a);
		$b = mysql_query("select * from tbl_teacher WHERE batch_id='$batch_id' AND error_records='Update'");
		$ab = mysql_num_rows($b);
		$c = mysql_query("select * from tbl_raw_teacher WHERE batch_id='$batch_id' AND status='error'");
		$j = mysql_num_rows($c);
		//$xyz = $i+$ab+$j;
		echo "<div align='center'><font color='green'><b>Total Uploaded records: ".$xyz."</b></font></div>";
		echo "<div align='center'><font color='green'><b>Total inserted records: ".$i."</b></font></div>";
		echo "<div align='center'><font color='green'><b>Total updated records: ".$ab."</b></font></div>";
		echo "<div align='center'><br><br><font color='red'><b>Total rejected records: ".$j."</b></font></div>";
		$teachernotnameq = mysql_query("select * from tbl_raw_teacher WHERE batch_id='$batch_id' and t_complete_name=''");
		$teachernotname = mysql_num_rows($teachernotnameq);
		
		$schooler1 = mysql_query("select * from tbl_raw_teacher WHERE batch_id='$batch_id' and t_school_id=''");
		$schoolnotid1 = mysql_num_rows($schooler1);
		
		$schooler2 = mysql_query("select * from tbl_raw_teacher WHERE batch_id='$batch_id' and t_school_id !='$mainschool' and t_school_id !=''");
		$schoolnotid2 = mysql_num_rows($schooler2);
		
	
		
		$schoolnotid = $schoolnotid1 + $schoolnotid2;
		$teacherid = mysql_query("select * from tbl_raw_teacher WHERE batch_id='$batch_id' and t_id=''");
		$teachernotid = mysql_num_rows($teacherid);
		echo "<div align='center'><br><br><font color='red'><b>Total rejected School Id: ".$schoolnotid."</b></font></div>";
		echo "<div align='center'><br><br><font color='red'><b>Total rejected Blank Teacher Id: ".$teachernotid."</b></font></div>";
		echo "<div align='center'><br><br><font color='red'><b>Total rejected Blank Teacher Name: ".$teachernotname."</b></font></div>";
		
		$BATCHQUERY = "INSERT INTO tbl_Batch_Master (batch_id,input_file_name,file_type,uploaded_by,entity,school_id,num_records_uploaded,num_errors_records,num_errors_scid,num_errors_name,num_newrecords_inserted,num_records_updated,uploaded_date_time,group_member_id) VALUES ('$batch_id','$name','$type','$uploaded_by','Group_Admin','$mainschool','$xyz','$j','$schoolnotid','$teachernotname','$i','$ab',NOW(),'$group_member_id')";
		$BATCHRESULT = mysql_query($BATCHQUERY);
		?>
<?php if($j > 0){?>

		<div class="row">
			<div class="col-sm-8 col-sm-offset-4"><a href="<?php echo 'sd_error_records.php?pro=dwnld&group_id='.$group_member_id.'&batch_id='.$batch_id; ?>" target='_blank' class='btn btn-default btn-sm pull-right'>Download Error Records</a></div></div>

		<table border='1px' align='center'>

		<tr>
		<th>Sr No.</th>
		<th>Error Message</th>
		<th>Teacher Id</th>
		<th>Teacher Name</th>
		<th>Teacher Mobile</th>
		<th>Teacher Email</th>
		<th>School Name</th>
		<th>School Id</th>
		<th>Registration Date</th>
		<th>Batch Id</th>
		</tr>
		<?php 
		$myquery1 = "select * from tbl_raw_teacher where group_member_id = '$group_member_id' and batch_id='$batch_id' order by t_date  DESC";
		$myres1 = mysql_query($myquery1);
		$k = 1;
		while($row = mysql_fetch_array($myres1))
		{
			
			
			$errmsg ="";
			
			$errortid1 = trim($row['t_id']);
			if($errortid1 == ''){
				$errortid2 = $errortid1;
				$errortid = 'Teacher_Id_Not_Found';
			    $errmsg .= $errortid." , ";	
			}else{
				$errortid2 = trim($row['t_id']);
			}
			
			$errortname1 = trim($row['t_complete_name']);
			if($errortname1 == ''){
				 $errortname2 = $errortname1;
				$errortname = 'Teacher_Name_Not_Found';
				$errmsg .= $errortname." , ";
			}else{
				$errortname2 = trim($row['t_complete_name']);
			}
			
			$errornumber1 = trim($row['t_phone']);
			if($errornumber1 == ''){
				$errornumber2 = $errornumber1;
				$errornumber = 'Mobile_No_Not_Found';
				$errmsg .= $errornumber." , ";
			}else if(!preg_match("/^[6-9][0-9]{9}$/", $errornumber1)){
				$errornumber2 = $errornumber1;
				$errornumber = 'Mobile_No_Not_Correct';
				$errmsg .= $errornumber." , ";
			}
			else{
				$errornumber2 = trim($row['t_phone']);
			}
			$erroretemail1 = trim($row['t_email']);
			if($erroretemail1 == ''){
				$erroretemail2 = $erroretemail1;
				$erroretemail = 'Email_Not_Found';
				$errmsg .= $erroretemail." , ";
			}else if (!filter_var($erroretemail1, FILTER_VALIDATE_EMAIL)){
				$erroretemail2 = $erroretemail1;
				$erroretemail = 'Email_Not_Correct';
				$errmsg .= $erroretemail." , ";
			}
			else{
				$erroretemail2 = trim($row['t_email']);
			}
			$errorscname1 = trim($row['t_school_name']);
			if($errorscname1 == ''){
				$errorscname2 = $errorscname1;
				$errorscname = 'School_Name_Not_Found';
				$errmsg .= $errorscname." , ";
			}else{
				$errorscname2 = trim($row['t_school_name']);
			}
			
			$errorscid1 = trim($row['t_school_id']);
			
			$queryreject55 = "select * from tbl_school_admin where school_id='$errorscid1' and group_member_id='$group_member_id'";
			$queryresp55 = mysql_query($queryreject55);
			$rowquery55 = mysql_fetch_array($queryresp55);
			$mainschool55 = $rowquery55['school_id'];
			
			if($errorscid1 == ''){
				$errorscid2 = $errorscid1;
				$errorscid = 'School_id_Not_Found';
				$errmsg .= $errorscid." , ";
			}else if($errorscid1 != $mainschool55) {
				$errorscid2 = $errorscid1;
				$errmsg .= 'School_id_Not_Correct , ';
			}
			else{
				$errorscid2 = trim($row['t_school_id']);
			}
			
			$err = substr_replace($errmsg , "", -2);
		?>
		<tr>
		<td align='center'><?php echo $k++ ?></td>
		<td><?php echo $err ;//$row['error_msg'];?></td>
		<td><?php echo $errortid2; ?></td>
		<td><?php echo $errortname2; ?></td>
		<td><?php echo $errornumber2; ?></td>
		<td><?php echo $erroretemail2; ?></td>
		<td><?php echo $errorscname2; ?></td>
		<td><?php echo $errorscid2; ?></td>
		<td><?php echo date('Y-M-d H:i:s', strtotime($row['t_date'])) ;?></td>
		<td><?php echo $row['batch_id']; ?></td>
		</tr>
		<?php }?>
		</table>
<?php } ?>
		<?php
 }
	/*else if($filetype == 'all_data')
	{
		$table = 'sport_student_all_details';
		$m =0;
		while(($filesop = fgetcsv($handle, 1000, ",")) !== false)
        {
			$school_id = $filesop[10];
			$school_name = $filesop[11];
			if($school_id != "" && $school_name != "")
			{
				$fields = array();
				for($i=0;$i<count($filesop); $i++) {
					$fields[] = '\''.addslashes($filesop[$i]).'\'';
				}
			   $sql = "Insert into $table values(''," . implode(', ', $fields) . ",'$uploaded_by',NOW())"; 
			   $res = mysql_query($sql);
			   if($res)
				{
				   $m++;
				}
			}
			
		}
		echo "<div align='center'><font color='green'><b>Total uploaded records: ".$m."</b></font></div>";
	}*/
    
 }

if(isset($_POST['dformat']))
{

	$data_format=$_POST['data_format'];	
	$path = url()."/core/Importdata/";

	if($data_format =='basic_data_format')
	{
		$filename="teacher_data_format.csv";
		$filepath = $path.$filename;

		echo "<script>window.open('$filepath');</script>";

	}		

}

if(isset($_POST['previewformat']))
{
	$data_format=$_POST['data_format'];	
	$path = url()."/core/Importdata/";
	if($data_format =='basic_data_format')
	{
		$filename="teacher_data_format.csv";
		$filepath = $path.$filename;
		$handle= fopen ( $filepath , "r" );			

			$first_row=	fgetcsv($handle);

			$firstRowTrimmed = array_map('trim', $first_row);
			$y = count($firstRowTrimmed);
			echo "<h3 align='center'>Teacher Data Format</h3>";
		echo "<table class='table table-bordered'>";
		echo "<tr>";
		for($i=0 ; $i<$y;$i++){
			echo "<th class='text-center'>$firstRowTrimmed[$i]</th>";
			//echo $x[$i];
		}
		echo "</tr>";
		
		echo "<tr>";
		echo "<td>Ender Teacher Name</td>";
		echo "<td>Phone Number of the Teacher</td>";
		echo "<td>Email ID of the Teacher which will be used for login into the system</td>";
		echo "<td>Teacher's School Name</td>";
		echo "<td>If you have deployed an internal computerized system at your school / college you can provide this Internal ID if any</td>";
		echo "<td>Teacher Code by which they would be unique to the system</td>";
		echo "<td>Teaching Staff is identified as 133 or 134 and non-teaching staff is identified by any other ID.
135 identified by HOD and 137 identified by Principal
</td>";
	//	for($j=0 ; $j<$y;$j++){
		//	echo "<td class='text-center'>$z[$j]</td>";
			//echo $x[$i];
	//	}
		echo "</tr>";
		
	echo "</table>";
		
	}
}
 
?>