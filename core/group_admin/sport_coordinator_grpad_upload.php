
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

	echo "You are not authorize to view this page..";
	exit;
}
?>
<div class='container'>



<div class='panel panel-default'>

	<div class='panel-heading' align ='center'>

<h2>Co-ordinator Upload Panel</h2></div>
<form method="post" action="" enctype="multipart/form-data">
<table align='left'>
<input type='text' name='uploaded_by' id='uploaded_by'  placeholder='Uploaded By'/>
<tr><br><td><b>Select  to upload data : </td><td><select name="file_type" id= "file_type"/><option value="">Select data</option>
<option value='basic_data'>Co-ordinator's data</option>
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
				<option value='basic_data_format'>Co-ordinator's data format</option>
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
		$sql2=mysql_query("select batch_id from tbl_Batch_Master where batch_id like 'GRP-%' order by id desc limit 1");			

			$resultsql=mysql_fetch_array($sql2);

			$batchcount=mysql_num_rows($sql2);

			

			if($batchcount==""){
					
				$batch_id="GRP-".$group_member_id."-1";


						 

			}else{	

				$batch_id=@$resultsql['batch_id'];

				$b_id=explode("-",$batch_id);

				$batch=@$b_id[2];

				$batch=$batch+1;

				$batch_id="GRP-".$group_member_id."-".$batch;

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

			$school_id = trim($data[0]);
			$teacher_id = trim($data[1]);
			$teacher_name = mysql_real_escape_string(trim($data[2]));
			$teacher_mobile	= trim($data[3]);
			$teacher_email = trim($data[4]);
			$teacher_state = trim($data[5]);
			$teacher_designation = trim($data[6]);
			$school_name = mysql_real_escape_string(trim($data[7]));

			$queryreject = "select * from tbl_school_admin where school_id='".$school_id."'";
			$queryresp = mysql_query($queryreject);
			
			if($queryresp>=0)
			{
			$rowquery = mysql_fetch_array($queryresp);
			$mainschool = $rowquery['school_id'];
		
			}else{
					die("school id not present");
				 }		

if ($mainschool != $school_id){

		
			$msg = "School id not found";
			
			$sql7 = "INSERT INTO tbl_raw_teacher(t_complete_name,t_phone,t_email,t_school_name,t_school_id,t_id,t_date,error_msg,created_by,created_on,group_member_id,batch_id,upload_date,uploaded_by,status,t_qualification, t_state) values ('$teacher_name','$teacher_mobile','$teacher_email','$school_name','$school_id','$teacher_id',NOW(),'$msg',$uploaded_by1,NOW(),'$group_member_id','$batch_id',NOW(),'$uploaded_by','error','$teacher_designation','$teacher_state')"; 
            $res7 = mysql_query($sql7);
			
		}else{
	
	
			$maxquery = mysql_query("select * from tbl_teacher where  school_id='$school_id' AND t_id='$teacher_id ' ");
		$result = mysql_fetch_array($maxquery);

$teacher_id1 = $result['t_id'];


	if($teacher_id1 == $teacher_id && $school_id == $mainschool)
{

	
	if($teacher_name == ''){
		$teacher_name = $result['t_complete_name'];//table mdhl name
	}
	if($teacher_mobile == ''){
		$teacher_mobile = $result['t_phone'];
	}
	if($teacher_email == ''){
		$teacher_email = $result['t_email'];
	}
	if($teacher_state == ''){
		$teacher_state = $result['state'];
	}

		if($teacher_designation == ''){
		$teacher_designation = $result['t_designation'];
	}
	if($school_name == ''){
		$school_name = $result['t_school_name'];
	}
	$mysqlquery = "update tbl_teacher set t_complete_name ='$teacher_name',t_phone='$teacher_mobile',t_email='$teacher_email',t_current_school_name='$school_name',t_designation='$teacher_designation',state='$teacher_state',error_records='Update',batch_id='$batch_id' where school_id='$school_id' AND t_id='$teacher_id' "; 
                $mysqlres = mysql_query($mysqlquery);   

     $sqlquery ="Update tbl_school_admin set coordinator_id='$teacher_id' where school_id='$school_id'";
     $mysqlres1 = mysql_query($sqlquery);

     $sql8 = "INSERT INTO tbl_raw_teacher(t_complete_name,t_phone,t_email,t_school_name,t_school_id,t_id,t_date,error_msg,created_by,created_on,group_member_id,batch_id,upload_date,uploaded_by,status,t_qualification, t_state) values ('$teacher_name','$teacher_mobile','$teacher_email','$school_name','$school_id','$teacher_id',NOW(),'Update',$uploaded_by1,NOW(),'$group_member_id','$batch_id',NOW(),'$uploaded_by','updated','$teacher_designation','$teacher_state')"; 
            $res8 = mysql_query($sql8);
			     
}else if($teacher_id1 != $teacher_id && $school_id == $mainschool){

	// $sql6 = "INSERT INTO tbl_teacher(t_complete_name,t_phone,t_email,t_current_school_name,school_id,t_id,state,t_designation, group_member_id,error_records,batch_id) values ('$teacher_name','$teacher_mobile','$teacher_email','$school_name','$school_id','$teacher_id','$teacher_state','$teacher_designation','$group_member_id','Insert','$batch_id')"; 


 //    $mysqlres = mysql_query($sql6);
 
 //    $sqlquery ="Update tbl_school_admin set coordinator_id='$teacher_id' where school_id='$school_id'";
 //    $mysqlres1 = mysql_query($sqlquery);

    $sql8 = "INSERT INTO tbl_raw_teacher(t_complete_name,t_phone,t_email,t_school_name,t_school_id,t_id,t_date,error_msg,created_by,created_on,group_member_id,batch_id,upload_date,uploaded_by,status,t_qualification, t_state) values ('$teacher_name','$teacher_mobile','$teacher_email','$school_name','$school_id','$teacher_id',NOW(),'coordinator not found',$uploaded_by1,NOW(),'$group_member_id','$batch_id',NOW(),'$uploaded_by','error','$teacher_designation','$teacher_state')"; 


            $res8 = mysql_query($sql8);

}else{

}
			
			
			
		}

	
		}
		
		
	}

    	
		$b = mysql_query("select * from tbl_raw_teacher WHERE batch_id='$batch_id' AND error_msg='Update'");
		$ab = mysql_num_rows($b);
		$c = mysql_query("select * from tbl_raw_teacher WHERE batch_id='$batch_id' AND status='error'");
		$j = mysql_num_rows($c);
		
		echo "<div align='center'><font color='green'><b>Total Uploaded records: ".$xyz."</b></font></div>";
		// echo "<div align='center'><font color='green'><b>Total inserted records: ".$i."</b></font></div>";
		echo "<div align='center'><font color='green'><b>Total updated records: ".$ab."</b></font></div>";

		echo "<div align='center'><br><br><font color='red'><b>Total rejected records: ".$j."</b></font></div>";
		// $teachernotnameq = mysql_query("select * from tbl_raw_teacher WHERE batch_id='$batch_id' and t_complete_name=''");
		// $teachernotname = mysql_num_rows($teachernotnameq);
		// $teacherid = mysql_query("select * from tbl_raw_teacher WHERE batch_id='$batch_id' and t_id=''");
		// $teachernotid = mysql_num_rows($teacherid);
		// count school id 
		$schooler1 = mysql_query("select * from tbl_raw_teacher WHERE batch_id='$batch_id' and t_school_id=''");
		$schoolnotid1 = mysql_num_rows($schooler1);
		
		$schooler2 = mysql_query("select * from tbl_raw_teacher WHERE batch_id='$batch_id' and error_msg='School id not found' and t_school_id !=''");
		$schoolnotid2 = mysql_num_rows($schooler2);
		$schoolnotid = $schoolnotid1 + $schoolnotid2;
	
		$a =mysql_query("select * from tbl_raw_teacher WHERE batch_id='$batch_id' AND error_msg='coordinator not found'");

		$i = mysql_num_rows($a);
		

		echo "<div align='center'><br><br><font color='red'><b>Total rejected School Id: ".$schoolnotid."</b></font></div>";
		echo "<div align='center'><br><br><font color='red'><b>Total rejected Co-ordinator Id: ".$i."</b></font></div>";
		// echo "<div align='center'><br><br><font color='red'><b>Total rejected Blank Co-ordinator Id: ".$teachernotid."</b></font></div>";
		// echo "<div align='center'><br><br><font color='red'><b>Total rejected Blank Co-ordinator Name: ".$teachernotname."</b></font></div>";
		//batch_id, input_file_name, uploaded_date_time, uploaded_by, entity, school_id, display_table_name, db_table_name,academic_year,semester_type
		
		$school_id19="GRP".$group_member_id;
		$BATCHQUERY = "INSERT INTO tbl_Batch_Master (batch_id,input_file_name,file_type,uploaded_by,entity,school_id,num_records_uploaded,num_errors_records,num_errors_scid,num_errors_name,num_newrecords_inserted,num_records_updated,uploaded_date_time,group_member_id,display_table_name, db_table_name) VALUES ('$batch_id','$name','$type','$uploaded_by','Group_Admin','$school_id19','$xyz','$j','$schoolnotid','$teachernotname','$i','$ab',NOW(),'$group_member_id','Teacher','tbl_teacher')";
		$BATCHRESULT = mysql_query($BATCHQUERY);
		?>
<?php if($j > 0){?>

		<div class="row">
			<div class="col-sm-8 col-sm-offset-4"><a href="<?php echo 'cd_error_records.php?pro=dwnld&group_id='.$group_member_id.'&batch_id='.$batch_id; ?>" target='_blank' class='btn btn-default btn-sm pull-right'>Download Error Records</a></div></div>
		<table border='1px' align='center'>

		<tr>
		<th>Sr No.</th>
		<th>Error Message</th>
		<th>School Id</th>
		<th>Co-ordinator Id</th>
		<th>Co-ordinator Name</th>
		<th>Co-ordinator Mobile</th
		<th>Co-ordinator Email</th>
		<th>State </th>
		<th>Designation</th>				
		<th>School Name</th>
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
				$errortid = 'Teacher Id Not Found';
			    $errmsg .= $errortid." , ";	
			}else{
				$errortid2 = trim($row['t_id']);
			}
			
			$errortname1 = trim($row['t_complete_name']);
			if($errortname1 == ''){
				 $errortname2 = $errortname1;
				$errortname = 'Teacher Name Not Found';
				$errmsg .= $errortname." , ";
			}else{
				$errortname2 = trim($row['t_complete_name']);
			}
			
			// $errornumber1 = trim($row['t_phone']);
			// if($errornumber1 == ''){
			// 	$errornumber2 = $errornumber1;
				
			// }else if($errornumber1){
			// 	$errornumber2 = $errornumber1;
				
			// }
			// else{
				$errornumber2 = trim($row['t_phone']);
			// }


			// $erroretemail1 = trim($row['t_email']);
			// if($erroretemail1 == ''){
			// 	$erroretemail2 = $erroretemail1;
				
			// }else if (($erroretemail1)){
			// 	$erroretemail2 = $erroretemail1;
				
			// }
			// else{
				$erroretemail2 = trim($row['t_email']);
			// }

			

			// $errorsstate1 = trim($row['t_state']);
			// if($errorsstate1 == ''){
			// 	$errorsstate2 = $errorsstate1;
				
			// }else{
				$errorsstate2 = trim($row['t_state']);
			// }

			// $errorsdesi1 = trim($row['t_qualification']);
			// if($errorsdesi1 == ''){
			// 	$errorsdesi2 = $errorsdesi1;
			
			// }else{
				$errorsdesi2 = trim($row['t_qualification']);
			// }

			$errorscname1 = trim($row['t_school_name']);
			if($errorscname1 == ''){
				$errorscname2 = $errorscname1;
				$errorscname = 'School Name Not Found';
				$errmsg .= $errorscname." , ";
			}else{
				$errorscname2 = trim($row['t_school_name']);
			}
			
			$errorscid1 = trim($row['t_school_id']);
			
			$queryreject55 = "select * from tbl_school_admin where school_id='$errorscid1' ";
			$queryresp55 = mysql_query($queryreject55);
			$rowquery55 = mysql_fetch_array($queryresp55);
			$mainschool55 = $rowquery55['school_id'];
			
			if($errorscid1 == ''){
				$errorscid2 = $errorscid1;
				$errorscid = 'School id Not Found';
				$errmsg .= $errorscid." , ";
			}else if($errorscid1 != $mainschool55) {
				$errorscid2 = $errorscid1;
				$errmsg .= 'School id Not Correct , ';
			}
			else{
				$errorscid2 = trim($row['t_school_id']);
			}
			
			$err = substr_replace($errmsg , "", -2);
			if($err == '')
			{
				$err = $row['error_msg'];
			}
		?>
		<tr>
		<td align='center'><?php echo $k++ ?></td>
		<td><?php echo $err ;//$row['error_msg'];?></td>
		<td><?php echo $errorscid2; ?></td>
		<td><?php echo $errortid2; ?></td>
		<td><?php echo $errortname2; ?></td>
		<td><?php echo $errornumber2; ?></td>
		<td><?php echo $erroretemail2; ?></td>
		<td><?php echo $errorsstate2; ?></td>
		<td><?php echo $errorsdesi2; ?></td>
		<td><?php echo $errorscname2; ?></td>
		
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

// if(isset($_POST['dformat']))
// {

// 	$data_format=$_POST['data_format'];	
// 	$path = url()."/core/Importdata/";

// 	if($data_format =='basic_data_format')
// 	{
// 		$filename="coordinator_data_format.csv";
// 		$filepath = $path.$filename;

// 		echo "<script>window.open('$filepath');</script>";

// 	}		

// }

if(isset($_POST['dformat']))
{

	$data_format=$_POST['data_format'];	
	$path = url()."/core/Importdata/";

	if($data_format =='basic_data_format')
	{
		$filename="coordinator_data_format.csv";
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
		$filename="coordinator_data_format.csv";
		$filepath = $path.$filename;
		$handle= fopen ( $filepath , "r" );			

			$first_row=	fgetcsv($handle);

			$firstRowTrimmed = array_map('trim', $first_row);
			$y = count($firstRowTrimmed);
			echo "<h3 align='center'>Co-ordinator Data Format</h3>";
		echo "<table class='table table-bordered'>";
		// echo "<tr>";
		// for($i=0 ; $i<$y;$i++){
		// 	echo "<th class='text-center'>$firstRowTrimmed[$i]</th>";
		// 	//echo $x[$i];
		// }
		// echo "</tr>";

			 

		echo "<tr>";
		echo "<td>School Id</td>";
		echo "<td>Co-ordinator Id</td>";
		echo "<td>	Co-ordinator Name</td>";

		echo "<td>Phone  </td>";
		echo "<td>Email </td>";
		echo "<td> State</td>";
		echo "<td> Designation</td>";						
		echo "<td>School Name</td>";


		
	//	for($j=0 ; $j<$y;$j++){
		//	echo "<td class='text-center'>$z[$j]</td>";
			//echo $x[$i];
	//	}
		echo "</tr>";
		
		echo "<tr>";
		echo "<td>Enter School Id</td>";
		echo "<td>Enter Teacher Id</td>";
		echo "<td>Enter Co-ordinator Name</td>";

		echo "<td>Phone Number of the Co-ordinator</td>";
		echo "<td>Email ID of the Co-ordinator which will be used for login into the system</td>";
		echo "<td>Enter State</td>";
		echo "<td>Enter Designation</td>";						
		echo "<td>Co-ordinator's School Name</td>";


		
	//	for($j=0 ; $j<$y;$j++){
		//	echo "<td class='text-center'>$z[$j]</td>";
			//echo $x[$i];
	//	}
		echo "</tr>";
		
	echo "</table>";
		
	}
}


 
?>