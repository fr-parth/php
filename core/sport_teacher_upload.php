<?php
include("cookieadminheader.php");
//include('conn.php');

$uploaded_by = $_SESSION['id'];
$entity=$_SESSION['entity'];
if($entity !=6 AND $entity !=8){

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
				<tr><br><td><b>Select group name </td><td><select name="group_member_id" id= 'group_member_id'/><option value=''>Select name</option>
				<?php $query = mysql_query("select id,group_name from tbl_cookieadmin where group_type !='admin' and group_name != '' ");
				while($row2 = mysql_fetch_array($query)){
				?>
				<option value='<?php echo $row2['id'];?>'><?php echo $row2['group_name'];?></option>
				<?php } ?>
				</td></tr>
				<tr><br><td><b>Select  to upload data : </td><td><select name="file_type" id= 'file_type'/><option value=''>Select data</option>
				<option value='basic_data'>Teacher's data</option>
				<!-- <option value='all_data'>Student's all data</option> --></td></tr>
				<tr><br><td><b>Select file: </td><td><input type="file" name="file"/></td></tr>
						   
				<tr><td><br><input class="btn btn-primary" type="submit" name="submit_file" value="Submit"/></td></tr>
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
	 $filetype = $_POST["file_type"];
	 $group_member_id = $_POST['group_member_id'];
	 //print_r($_REQUEST); exit;
     $filename = basename($_FILES['file']['name']); //exit; 
     $file = $_FILES['file']['tmp_name'];
     $handle = fopen($file, "r");

	//tables
		$main_table  = "tbl_teacher";
		$raw_table	 = "tbl_raw_teacher";
		$school_table = "tbl_school_admin";
	
	if($filetype == '')
	 {
		echo "Please select data type to upload ";
		exit;
	 }
	 if($group_member_id == '')
	 {
		echo "Please select a group name ";
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
		
		
      while(($filesop = fgetcsv($handle, 1000, ",")) !== false)
        {
		 if($row == 0){$row++;continue;}
		  $ok = 1;
		 
			$teacher_name = $filesop[0];
			$teacher_mobile	= $filesop[1];
			$teacher_email = $filesop[2];
			$school_name = $filesop[3];
			$school_id = $filesop[4];
			$teacher_id = (!empty($filesop[5])?$filesop[5] : $filesop[1]);
			//$password = random_password(8);
			$pass = explode(' ',$teacher_name);
		 	$password = $pass[0].'123';
			
			if($teacher_name == "" || $school_id == "" || $teacher_mobile =="")
			{
				$ok = 0;

				$msg = "Either school id, teacher name or mobile number is missing";
				$password = "";
			}
			
			$myquery = "select school_id from $school_table where school_id='$school_id'";
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

			$myquery1 = "select t_phone,school_id from $main_table where t_id='$teacher_id' AND school_id='$school_id' and group_member_id='$group_member_id'";
			$myres1 = mysql_query($myquery1);
			$count1 = mysql_num_rows($myres1);
		
			if($count1 > 0)
			{
				$ok = 2;
				$mysqlquery = "update $main_table set t_complete_name =\"$teacher_name\",t_phone='$teacher_mobile',t_email='$teacher_email',t_current_school_name=\"$school_name\",school_id='$school_id',t_date=NOW(),t_password='$password',created_by='$uploaded_by',created_on=NOW()where t_id='$teacher_id' AND school_id='$school_id' AND group_member_id='$group_member_id';"; 

				$mysqlres = mysql_query($mysqlquery);
				if($mysqlres)
				{
					$a++;
				}

			}

			if($ok == 1)
			{
				$sql = "INSERT INTO $main_table(t_complete_name,t_phone,t_email,t_current_school_name,school_id,t_id,t_date,t_password,created_by,created_on,group_member_id) values (\"$teacher_name\",'$teacher_mobile','$teacher_email',\"$school_name\",'$school_id','$teacher_id',NOW(),'$password','$uploaded_by',NOW(),'$group_member_id');"; //exit;

				$res = mysql_query($sql);
				
				if($res)
				{
					//$mysql = "delete from $raw_table where school_id = '$school_id' and t_phone = '$teacher_mobile' ";
					//$myres = mysql_query($mysql);
					$i++;
				}
																
			}
			else if($ok == 0)
			{
				$sql = "INSERT INTO $raw_table(t_complete_name,t_phone,t_email,t_school_name,t_school_id,t_id,t_date,t_password,error_msg,created_by,created_on,group_member_id) values (\"$teacher_name\",'$teacher_mobile','$teacher_email',\"$school_name\",'$school_id','$teacher_id',NOW(),'$password','$msg',$uploaded_by,NOW(),'$group_member_id');"; 

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
		<th>Teacher Name</th>
		<th>Teacher Mobile</th>
		<th>School Name</th>
		<th>School Id</th>
		<th>Registration Date</th>
		</tr>
		<?php 
		$myquery1 = "select error_msg,t_complete_name,t_phone,t_school_name,t_school_id,t_date from $raw_table where group_member_id = '$group_member_id' order by t_date  DESC";
		$myres1 = mysql_query($myquery1);
		$k = 1;
		while($row = mysql_fetch_array($myres1))
		{
		?>
		<tr>
		<td align='center'><?php echo $k++ ?></td>
		<td><?php echo $row['error_msg'] ;?></td>
		<td><?php echo $row['t_complete_name']; ?></td>
		<td><?php echo $row['t_phone'] ?></td>
		<td><?php echo $row['t_school_name']; ?></td>
		<td><?php echo $row['t_school_id']; ?></td>
		<td><?php echo date('Y-M-d H:i:s', strtotime($row['t_date'])) ;?></td>
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
?>