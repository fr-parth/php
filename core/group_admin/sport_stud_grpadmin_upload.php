<?php
include("groupadminheader.php");
//include('../conn.php');


$uploaded_by = $_SESSION['group_admin_id'];
$group_type = $_SESSION['data'][0]['group_type'];
$group_name = $_SESSION['data'][0]['group_name'];
$group_member_id = $_SESSION['group_admin_id'];

$res1 = mysql_query("select id,project_id,project_name from tbl_project_event");

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

		<h2>Student Upload Panel</h2></div>
<form method="post" action="" enctype="multipart/form-data">
<table align='left'>

<tr><br><td><b>Select upload data type: </td><td><select name="file_type" id= 'file_type'><option value=''>Select data type</option>
<option value='basic_data'>Student's basic data</option>
<option value='basic_data_osot'>Student's basic data for OSOT</option>
</select>
</td></tr>
<tr id= 'project'><br><td><b>Select upload data type: </td><td>
<select name="project">
	<option value=''>Select Project</option>
	<?php while($row= mysql_fetch_array($res1)){ ?>
        <option value="<?php echo $row['id']; ?>"><?php echo $row['project_name']."(".$row['project_id'].")"; ?></option>
    <?php } ?>
</select>
<!-- <option value='all_data'>Student's all data</option> --></td></tr>
<tr id= 'project1'><br><td><b>Source: </td><td>
<input type="text" name="source" class="form-input" />
<!-- <option value='all_data'>Student's all data</option> --></td></tr>
<tr><br><td><b>Select file: </td><td><input type="file" name="file"/></td></tr>
		   
		<tr><td><br><input class="btn btn-success" type="submit" name="submit_file" value="Submit"/></td></tr>
		</table>
 </form>

 <form method='post' enctype='multipart/form-data'>
<table align='right'>
		<div class='row'>
			<select name='data_format' id='data_format'>

				<option value=''>Select format</option>
				<option value='basic_data_format'>Student's basic data format</option>
				<option value='basic_data_format_osot'>Student's basic data for OSOT</option>
				<!-- <option value='all_data_format'>Student's all data format</option> -->
				

			</select>

			<button type='submit' name='dformat' class='btn btn-success btn-xs' >Download Format</button>
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
	<div class='col-md-4'>

			<!--format-->

		
		</div>
<script>
	$(document).ready(function(){
		$('#project').css('display','none');
		$('#project1').css('display','none');
		$('#file_type').change(function(){
			var file_nm = $(this).val();
			if(file_nm=="basic_data_osot"){
				$('#project').css('display','table-row');
				$('#project1').css('display','table-row');
			}else{
				$('#project').css('display','none');
				$('#project1').css('display','none');
			}
		});
	});
</script>
<?php
function random_password( $length = 8 ) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $password = substr( str_shuffle( $chars ), 0, $length );
    return $password;
}

if(isset($_POST["submit_file"]))
 { 
	 $filetype = $_POST["file_type"];
	 $project = $_POST["project"];
	 $source = $_POST["source"];
	 //print_r($_REQUEST); exit;
     $filename = basename($_FILES['file']['name']); //exit; 
    $file = $_FILES['file']['tmp_name'];
    $handle = fopen($file, "r");

	if($filetype == '')
	 {
		echo "Please select data type to upload";
		exit;
	 }

    if ($file == NULL) {
     echo "Please select a file to import";
      
    }
	else if($filetype == 'basic_data'){
		$i = 0;
		$j = 0;
		$row = 0;
		$a = 0;
		$main_table  = "tbl_student";
		$raw_table	 = "tbl_raw_student";
		$school_table = "tbl_school_admin";
		
      while(($filesop = fgetcsv($handle, 1000, ",")) !== false)
        {
		  if($row == 0){$row++;continue;}
		  $ok = 1;
		 //if($ok) { $ok = false; continue; }
			$player_name = ucwords(strtolower($filesop[0]));
			$player_id	= $filesop[1];
			$player_dob = $filesop[2];
			$player_age = $filesop[3];
			$player_gender = $filesop[4];
			$player_school_name =	$filesop[5];
			$player_school_id = $filesop[6];
			$student_class = $filesop[7];
			/*$CountryCode = (!empty($filesop[8])?$filesop[8] : 91);
			$mobile	= $filesop[9];
			$sc_admin_name = (!empty($filesop[10])?$filesop[10] : $filesop[4]);*/

			//$password = random_password(8);
			$pass = explode(' ',$player_name);
		 	$password = $pass[0].'123';
			
			if($player_name == "" || $player_id == "" || $player_school_id == "")
			{
				$ok = 0;

				$msg = "Either school id, player id or school name is missing";
				$password = "";
			}
			
			$myquery = "select school_id from $school_table where school_id='$player_school_id' and group_member_id='$group_member_id'";
			$myres = mysql_query($myquery);
			$count = mysql_num_rows($myres);
		
			if($count > 0)
			{
				$ok = 1;

			}
			else
			{
				$ok = 0;
				$msg = "School id does not exist";
			}

			$myquery1 = "select std_PRN,school_id from $main_table where std_PRN='$player_id' AND school_id='$player_school_id' and group_member_id='$group_member_id';";
			$myres1 = mysql_query($myquery1);
			$count1 = mysql_num_rows($myres1);
		
			if($count1 > 0)
			{
				$ok = 2;
				$mysqlquery = "update $main_table set std_complete_name=\"$player_name\",std_PRN='$player_id',std_dob='$player_dob',std_age='$player_age',std_gender='$player_gender',std_school_name=\"$player_school_name\",school_id='$player_school_id',std_class='$student_class',std_password='$password' where std_PRN='$player_id' AND school_id='$player_school_id' and group_member_id='$group_member_id';"; 

				$mysqlres = mysql_query($mysqlquery);
				if($mysqlres)
				{
					$a++;
				}
				else
				{
					$ok = 0;
					$msg = "DB Error - ".mysql_error();
				}

			}
			if($ok == 1)
			{
				 $sql = " INSERT INTO $main_table(std_complete_name,std_PRN,std_dob,std_age,std_gender,std_school_name,school_id,std_date,std_password,group_member_id,std_class) values (\"$player_name\",'$player_id','$player_dob','$player_age','$player_gender',\"$player_school_name\",'$player_school_id',NOW(),'$password','$group_member_id','$student_class');"; 

				$res = mysql_query($sql);
				
				if($res)
				{
					//$mysql = "delete from $raw_table where school_id = '$player_school_id' and std_PRN = '$player_id' ";
					//$myres = mysql_query($mysql);
					$i++;
				}
				else
				{
					$ok = 0;
					$msg = "DB Error - ".mysql_error();
				}
								
			}
			else if($ok == 0)
			{
				 $sql = "INSERT INTO $raw_table (s_complete_name,s_PRN,s_dob,s_age,s_gender,s_school_name,s_school_id,s_date,s_password,error_msg,group_member_id,s_class) values (\"$player_name\",'$player_id','$player_dob','$player_age','$player_gender',\"$player_school_name\",'$player_school_id',NOW(),'$password','$msg','$group_member_id','$student_class');";  

				$res = mysql_query($sql);

				$j++;
				
			}
			
		}
		
		echo "<div align='center'><font color='green'><b>Total inserted records: ".$i."</b></font></div>";
		echo "<div align='center'><font color='green'><b>Total updated records: ".$a."</b></font></div>";
		echo "<div align='center'><br><br><font color='red'><b>Total rejected records: ".$j."</b></font></div>";
		?>
<?php if($j > 0){?>
		<table border='1px' align='center'>

		<tr>
		<th>Sr No.</th>
		<th>Error Message</th>
		<th>Student Id</th>
		<th>Student Name</th>
		<th>School Name</th>
		<th>School Id</th>
		<th>Registration Date</th>
		</tr>
		<?php 
		$myquery1 = "select error_msg,s_complete_name,s_PRN,s_school_name,s_school_id,s_date from $raw_table where group_member_id = '$group_member_id' order by s_date DESC";
		$myres1 = mysql_query($myquery1);
		$k = 1;
		while($row = mysql_fetch_array($myres1))
		{
		?>
		<tr>
		<td align='center'><?php echo $k++ ?></td>
		<td><?php echo $row['error_msg'] ;?></td>
		<td><?php echo $row['s_PRN'] ?></td>
		<td><?php echo $row['s_complete_name'] ?></td>
		<td><?php echo $row['s_school_name'] ?></td>
		<td><?php echo $row['s_school_id'] ?></td>
		<td><?php echo date('Y-M-d H:i:s',strtotime($row['s_date'])); ?></td>
		</tr>

		<?php }?>
		</table>
<?php } 
	}
	else if($filetype == 'basic_data_osot'){
		// echo "OSOT"; exit;
		$i = 0;
		$k = 0;
		$j = 0;
		$s = 0;
		$row = 0;
		$a = 0;
		$main_table  = "tbl_student";
		$raw_table	 = "tbl_raw_student";
		$school_table = "tbl_school_admin";
		$transaction_table = "tbl_student_project_transaction";
		$intersect_table = "tbl_student_project_intersect";
		
      while(($filesop = fgetcsv($handle, 1000, ",")) !== false)
        {
        	// print_r($filesop); exit;
		  if($row == 0){$row++;continue;}
		  $ok = 1;
		  $oks = 1;
		  $okss = 1;
		 //if($ok) { $ok = false; continue; }
			$player_name = $filesop[0];
			$player_id = (!empty($filesop[1])?$filesop[1] : $filesop[5]);
			$player_id = (!empty($player_id)?$player_id : $filesop[6]);
			$player_gender = $filesop[2];
			$player_school_name = $filesop[3];
			$player_school_id = $filesop[4];
			$player_mobile = $filesop[5];
			$player_email = $filesop[6];
			$player_tree = $filesop[7];
			$player_image = $filesop[8];
			/*$CountryCode = (!empty($filesop[8])?$filesop[8] : 91);
			$mobile	= $filesop[9];
			$sc_admin_name = (!empty($filesop[10])?$filesop[10] : $filesop[4]);*/

			//$password = random_password(8);
			// $pass = explode(' ',$player_name);
		 	$password = 'temp123';

		 	// $data = 'data:image/png;base64,AAAFBfj42Pj4';
			
			if($player_name == "" || $player_id == "" || $player_school_id == "")
			{
				$ok = 0;
				$oks = 0;
				$okss = 0;

				$msg = "Either school id, player id or school name is missing";
				$password = "";
			}
			
			$myquery = "select school_id from $school_table where school_id='$player_school_id'";
			$myres = mysql_query($myquery);
			$count = mysql_num_rows($myres);
		
			if($count > 0)
			{
				$ok = 1;
				$oks = 1;
				$okss = 1;

			}
			else
			{
				$ok = 0;
				$oks = 0;
				$okss = 0;
				$msg = "School id does not exist";
			}

			$myquery1 = "select std_PRN,school_id from $main_table where std_PRN='$player_id' AND school_id='$player_school_id'";
			$myres1 = mysql_query($myquery1);
			$count1 = mysql_num_rows($myres1);
			
			if($count1 > 0)
			{
				$ok = 2;
				$mysqlquery = "update $main_table set std_complete_name=\"$player_name\",std_PRN='$player_id',std_gender='$player_gender',std_school_name=\"$player_school_name\",school_id='$player_school_id',std_phone='$player_mobile',std_email='$player_email',std_password='$password' where std_PRN='$player_id' AND school_id='$player_school_id' and group_member_id='$group_member_id'"; 

				$mysqlres = mysql_query($mysqlquery);
				if($mysqlres)
				{
					$a++;
				}

			}
			$myquery1_osot = "select std_PRN,school_id from $transaction_table where std_PRN='$player_id' AND school_id='$player_school_id' AND project_id='$project' AND object_photo=\"$player_image\"";
			$myres1_osot = mysql_query($myquery1_osot);
			$count1_osot = mysql_num_rows($myres1_osot);
		
			if($count1_osot > 0)
			{
				$oks = 2;
				$mysqlquery_osot = "update $transaction_table set std_PRN='$player_id',school_id='$player_school_id',project_id='$project', source='$source', date_time=NOW(), object_photo=\"$player_image\" where std_PRN='$player_id' AND school_id='$player_school_id' and group_member_id='$group_member_id'"; 

				$mysqlres_osot = mysql_query($mysqlquery_osot);
				if($mysqlres_osot)
				{
					// $a++;
				}

			}
			// $myquery1_osot_inter = "select std_PRN,school_id from $transaction_table where std_PRN='$player_id' AND school_id='$player_school_id' AND project_id='$project'";
			// $myres1_osot_inter = mysql_query($myquery1_osot_inter);
			// $count1_osot_inter = mysql_num_rows($myres1_osot_inter);
		
			// if($count1_osot_inter > 0)
			// {
			// 	$okss = 2;
			// 	$mysqlquery_osot_inter = "update $intersect_table set std_PRN='$player_id',school_id='$player_school_id',project_id='$project', source='$source', date_time=NOW(), object_photo=\"$player_image\" where std_PRN='$player_id' AND school_id='$player_school_id' and group_member_id='$group_member_id'"; 

			// 	$mysqlres_osot_inter = mysql_query($mysqlquery_osot_inter);
			// 	if($mysqlres_osot_inter)
			// 	{
			// 		// $a++;
			// 	}

			// }
			if($ok == 1)
			{
			// echo $mysqlquery_osot; exit;
				 $sql = " INSERT INTO $main_table(std_complete_name,std_PRN,std_gender,std_school_name,school_id,std_date,std_password,group_member_id,std_phone,std_email) values (\"$player_name\",'$player_id','$player_gender',\"$player_school_name\",'$player_school_id',NOW(),'$password','$group_member_id','$player_mobile','$player_email')";
				$res = mysql_query($sql);
				 if($res)
				{
					$i++;
				}
			}
			else if($ok == 0)
			{
				 $sql = "INSERT INTO $raw_table (std_complete_name,std_PRN,std_gender,std_school_name,school_id,std_date,std_password,group_member_id,std_phone,std_email,error_msg) values (\"$player_name\",'$player_id','$player_gender',\"$player_school_name\",'$player_school_id',NOW(),'$password','$group_member_id','$player_mobile','$player_email','$msg')";  

				$res = mysql_query($sql);

				$j++;
				
			}
			if($oks == 1)
			{
				 $sql_osot_tran = " INSERT INTO $transaction_table(std_PRN, school_id, project_id, source, date_time,object_photo) values ('$player_id','$player_school_id','$project','$source',NOW(),\"$player_image\")";
				 
				$res_osot_tran = mysql_query($sql_osot_tran);
				 if($res_osot_tran)
				{
					$k++;
				}			
			}
			// if($okss == 1)
			// {
			// 	 $sql_osot_inter = " INSERT INTO $intersect_table(std_PRN, school_id, project_id, source, date_time) values ('$player_id','$player_school_id','$project','$source',NOW())";

			// 	$res_osot_inter = mysql_query($sql_osot_inter);
			// 	 if($res_osot_inter)
			// 	{
			// 		$s++;
			// 	}			
			// }
				
		}
		
		echo "<div align='center'><font color='green'><b>Total inserted records in Student: ".$i."</b></font></div>";
		echo "<div align='center'><font color='green'><b>Total inserted records in Transaction: ".$k."</b></font></div>";
		// echo "<div align='center'><font color='green'><b>Total inserted records in Intersect: ".$s."</b></font></div>";
		echo "<div align='center'><font color='green'><b>Total updated records in Student: ".$a."</b></font></div>";
		echo "<div align='center'><br><br><font color='red'><b>Total rejected records for Student: ".$j."</b></font></div>";
		?>
<?php  
	}
	else if($filetype == 'all_data')
	{
		exit;
		$table = 'sport_student_all_details';
		$m =0;
		while(($filesop = fgetcsv($handle, 1000, ",")) !== false)
        {
			$school_id = $filesop[9];
			$school_name = $filesop[8];
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
	}
    
}

if(isset($_POST['dformat']))
{

	$data_format=$_POST['data_format'];	
	$path = url()."/core/Importdata/";

	if($data_format =='basic_data_format')
	{
		$filename="student_basic_data_format.csv";
		$filepath = $path.$filename;

		echo "<script>window.open('$filepath');</script>";

	}
	if($data_format =='all_data_format')
	{
		$filename="student_all_data_format.csv";
		$filepath = $path.$filename;

		echo "<script>window.open('$filepath');</script>";

	}
	if($data_format =='basic_data_format_osot')
	{
		$filename="student_basic_data_format_osot.csv";
		$filepath = $path.$filename;

		echo "<script>window.open('$filepath');</script>";

	}	

}

?>