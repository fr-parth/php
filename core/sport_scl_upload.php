<?php
include("cookieadminheader.php");

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

		<h2>School Upload Panel</h2></div>
		<form method="post" action="" enctype="multipart/form-data">
		<table align='left'>
		<tr><br><td><b>Select group name </td><td><select name="group_member_id" id= 'group_member_id'/><option value=''>Select name</option>
		<?php $query = mysql_query("select id,group_name from tbl_cookieadmin where group_type !='admin' and group_name != '' ");
		while($row2 = mysql_fetch_array($query)){
		?>
		<option value='<?php echo $row2['id'];?>'><?php echo $row2['group_name'];?></option>
		<?php } ?>
		</td></tr>
		<tr><br><td><b>Select upload data type: </td><td><select name="file_type" id= 'file_type'/><option value=''>Select data type</option>
		<option value='basic_data'>School's basic data</option>
		<option value='all_data'>School's all data</option></td></tr>
		<tr><br><td><b>Select file: </td><td><input type="file" name="file"/></td></tr>   
		<tr><td><br><input class="btn btn-primary" type="submit" name="submit_file" value="Submit"/></td></tr>
		</table>
		 </form>




		  <form method='post' enctype='multipart/form-data'>
				<table align='right'>
						<div class='row'>
							<select name='data_format' id='data_format'>
								<option value=''>Select format</option>
								<option value='basic_data_format'>School's basic data format</option>
								<option value='all_data_format'>School's all data format</option>
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

//	function random_password( $length = 8 ) {
//		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
//		$password = substr( str_shuffle( $chars ), 0, $length );
//		return $password;
//	}

		if(isset($_POST["submit_file"]))
		 { 
			 $filetype = $_POST["file_type"];
			 $group_type = '';
			 $group_member_id = $_POST['group_member_id'];
			 $group_name = '';
			 //print_r($_REQUEST); exit;
			 $filename = basename($_FILES['file']['name']); //exit; 
			$file = $_FILES['file']['tmp_name'];
			$handle = fopen($file, "r");

			
			if($group_member_id == '')
			 {
				echo "Please select a group name";
				exit;
			 }
			 if($filetype == '')
			 {
				echo "Please select data type to upload ";
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
				$main_table  = "tbl_school_admin";
				$raw_table	 = "tbl_school_admin_raw";
				$main_staff_table  = "tbl_school_adminstaff";
				
			  while(($filesop = fgetcsv($handle, 1000, ",")) !== false)
				{
				  if($row == 0){$row++;continue;}
				  $ok = 1;
				 //if($ok) { $ok = false; continue; }
					$school_type = $filesop[0];
					if($school_type=='')
					{
						$school_type='school';
					}
					$school_id	= $filesop[1];
					$school_name = $filesop[2];
					$DTECode = $filesop[3];
					$school_email = $filesop[4];
					$address =	$filesop[5];
					$scadmin_city = $filesop[6];
					$scadmin_country = $filesop[7];
					$scadminStates = $filesop[11];
					$scadmin_pattern = $filesop[12];
					
					$CountryCode = (!empty($filesop[8])?$filesop[8] : 91);
					$mobile	= $filesop[9];
					$sc_admin_name = (!empty($filesop[10])?$filesop[10] : $filesop[4]);
					$scadmin_state =$filesop[11];
					$aicte_pid =$filesop[12];
					$aicte_aid =$filesop[13];

					   $name = explode(" ", $sc_admin_name);
          
                        $password = $school_id; 


                  //$password = random_password(8);
					
					if($school_id == "" || $school_name == "")
					{
						$ok = 0;

						$msg = "Either school id or school name is missing";
						$password = "";
					}
					
					$myquery = "select school_id from $main_table where school_id='$school_id' and group_member_id='$group_member_id'";
					$myres = mysql_query($myquery);
					$count = mysql_num_rows($myres);
				
					if($count > 0)
					{
						$ok = 2;
						

						$mysqlquery = "update $main_table set school_type='$school_type',school_name=\"$school_name\",DTECode='$DTECode',email='$school_email',address='$address',scadmin_city='$scadmin_city',scadmin_country='$scadmin_country',CountryCode='$CountryCode',mobile='$mobile',name='$sc_admin_name',reg_date=NOW(),password='$password',uploaded_by = '$uploaded_by',group_type='$group_type',group_name='$group_name',scadmin_state='$scadmin_state', aicte_permanent_id='$aicte_pid',aicte_application_id='$aicte_aid' where school_id = '$school_id' and group_member_id='$group_member_id'"; 


						$mysqlres = mysql_query($mysqlquery);
						
						if($mysqlres)
						{
							$a++;
						}

					}

					if($ok == 1)
					{

						$sql = "INSERT INTO $main_table(school_type,school_id,school_name,DTECode,email,address,scadmin_city,scadmin_country,CountryCode,mobile,name,reg_date,password,uploaded_by,group_type,group_name,group_member_id,scadmin_state,aicte_permanent_id,aicte_application_id) values ('$school_type','$school_id',\"$school_name\",'$DTECode','$school_email','$address','$scadmin_city','$scadmin_country','$CountryCode','$mobile','$sc_admin_name',NOW(),'$password','$uploaded_by','$group_type','$group_name','$group_member_id','$scadmin_state', '$aicte_pid','$aicte_aid')"; 


						$res = mysql_query($sql);
						
//insert query for school admin staff and access permission to staff  added by Pranali for SMC-4645 on 6-4-20				
						$delete_flag='0';
						$pass = $name[0]."123";
						$sql1 = "INSERT INTO $main_staff_table(school_id,school_name,email,addd,city,country,CountryCode,phone,stf_name,currentDate,pass,group_member_id,delete_flag) VALUES ('$school_id',\"$school_name\",'$school_email','$address','$scadmin_city','$scadmin_country','$CountryCode','$mobile','$sc_admin_name',NOW(),'$pass','$group_member_id','$delete_flag')";
						$res1 = mysql_query($sql1);

						$staff_info = mysql_query("select id,stf_name from tbl_school_adminstaff ORDER BY id DESC limit 1");
			            $row = mysql_fetch_array($staff_info);
			            $staff_id = $row['id'];
			            $stf_name = $row['stf_name'];

						//access permission to staff
						$entity_id='102';
		                $sql_access = mysql_query("SELECT menu_key FROM tbl_menu WHERE entity_type='$entity_id'");
		                if(mysql_num_rows($sql_access) > 0) 
		                {
		                    $key = array();
		                        while($access = mysql_fetch_assoc($sql_access))
		                        {
		                            $key[] = $access['menu_key'];
		                        }
		                        
		                    $permission = implode(',' ,$key);

		                    $insert_access = mysql_query("INSERT INTO tbl_permission (`school_id`, `s_a_st_id`, `school_staff_name`, `permission`, `current_date`) VALUES ('$school_id','$staff_id','$stf_name','$permission',NOW())");

		                }

						if($res && $res1)
						{
							//$mysql = "delete from $raw_table where school_id = '$school_id' and school_name = \"$school_name\" LIMIT 1";
							//$myres = mysql_query($mysql);
							$i++;
						}
										
					}
					else if($ok == 0)
					{
						$sql = "INSERT INTO $raw_table	(school_type,school_id,school_name,DTECode,email,address,scadmin_city,scadmin_country,CountryCode,mobile,name,reg_date,password,error_msg,uploaded_by,group_member_id) values ('$school_type','$school_id','$school_name','$DTECode','$school_email','$address','$scadmin_city','$scadmin_country','$CountryCode','$mobile','$sc_admin_name',NOW(),'$password','$msg','$uploaded_by','$group_member_id');"; 

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
				<th>School Id</th>
				<th>School Name</th>
				<th>School Email</th>
				<th>Registration Date</th>
				</tr>
				<?php 
				$myquery1 = "select error_msg,school_id,school_name,email,reg_date from $raw_table where group_member_id = '$group_member_id' and reg_date > timestamp(DATE_SUB(NOW(), INTERVAL 10 MINUTE)) order by reg_date DESC";
				$myres1 = mysql_query($myquery1);
				$k = 1;
				while($row = mysql_fetch_array($myres1))
				{
				?>
				<tr>
				<td align='center'><?php echo $k++ ?></td>
				<td><?php echo $row['error_msg'] ;?></td>
				<td><?php echo $row['school_id'] ?></td>
				<td><?php echo $row['school_name'] ?></td>
				<td><?php echo $row['email'] ?></td>
				<td><?php echo date('Y-M-d H:i:s',strtotime($row['reg_date'])); ?></td>
				</tr>

				<?php }?>
				</table>
			<?php } ?>

				<?php
			}
			else if($filetype == 'all_data')
			{
				$table = 'sport_school_all_details';
				$m =0;
				$row = 0;
				while(($filesop = fgetcsv($handle, 1000, ",")) !== false)
				{
					if($row == 0){$row++;continue;}
					$school_id = $filesop[10];
					$school_name = $filesop[11];
					if($school_id != "" && $school_name != "")
					{
						$fields = array();
						for($i=0;$i<count($filesop); $i++) {
							$fields[] = '\''.addslashes($filesop[$i]).'\'';
						}
					   $sql = "REPLACE into $table values(''," . implode(', ', $fields) . ",'$uploaded_by',NOW(),'$group_member_id')"; //exit;
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
				$filename="school_basic_data_format.csv";
				$filepath = $path.$filename;

				echo "<script>window.open('$filepath');</script>";

			}
			if($data_format =='all_data_format')
			{
				$filename="school_all_data_format.csv";
				$filepath = $path.$filename;

				echo "<script>window.open('$filepath');</script>";

			}	

		}

?>