<?php 
	require '../conn.php';
	require '../sd_upload_function.php';		
	//$group_member_id = $_SESSION['group_admin_id'];
	if($_GET['pro']=="dwnld"){		
		
		// $table=trim($_GET['proc']);
		 $group=trim($_GET['group_id']);
		 $batchid = $_GET['batch_id'];
			// $data=upload_info($table);
			$data['display_table_name']='Coordinator';

				$data['filename']='Coordinator';

				$data['raw_table']='tbl_raw_teacher';

				$data['fields']='t_school_id, t_id,t_complete_name, t_phone, t_email,t_qualification, t_school_name';

				$data['display_fields']='SchoolCode,Coordinator Id,Coordinator Name,Mobile,Email,Designation,School Name ';

				//$sql="SELECT ".$data['fields'].",upload_date, uploaded_by, batch_id, error_msg from ".$data['raw_table']." where status not in ('Insert', 'Update') AND group_member_id =".$group." AND batch_id=$batchid";
                $sql = "SELECT * FROM tbl_raw_teacher WHERE batch_id='$batchid'";
				// echo $sql; exit;
			
			$qd=@mysql_query($sql)or die(mysql_error());
			header("Content-type: application/vnd.ms-excel; charset=utf-8");
			header("Content-disposition: attachment; filename=".$data['filename'].'-'.date("Ymd").".xls");
		
			echo "<table border='1'>";
			echo "<tr><th>";
			echo str_replace(",","</th><th>",$data['display_fields']);
			echo "</th><th>upload_date</th><th>uploaded_by</th><th>batch_id</th><th>status</th></tr>";

			while($er=@mysql_fetch_array($qd)){	
					$t_school_id1 = trim($er['t_school_id']);
					$t_id1 = trim($er['t_id']);
                    $t_complete_name1 = trim($er['t_complete_name']);
					$t_phone1 = trim($er['t_phone']);
					$t_email1 = trim($er['t_email']);
					$t_qualification1 = trim($er['t_qualification']);
					$t_school_name1 = trim($er['t_school_name']);
					$upload_date = trim($er['upload_date']);
					$uploaded_by = trim($er['uploaded_by']);
					$batch_id = trim($er['batch_id']);
					$error_msg = trim($er['error_msg']);
					
		$queryreject55 = "select * from tbl_school_admin where school_id='$t_school_id1'";
			$queryresp55 = mysql_query($queryreject55);
			$rowquery55 = mysql_fetch_array($queryresp55);
			$mainschool55 = $rowquery55['school_id'];
					
					$errmsg ="";
					if($t_complete_name1 == ''){
						$t_complete_name2 = $t_complete_name1;
						$t_complete_name = 'Teacher Name Not Correct';
						$errmsg .= $t_complete_name." , ";
					}else{
						$t_complete_name2 = $t_complete_name1;
					}
					// if($t_phone1 == ''){
					// 	$t_phone2 = $t_phone1;
					// 	$t_phone = 'Mobile_No_Not_Found';
					// 	$errmsg .= $t_phone." , ";
					// }else if(!preg_match("/^[6-9][0-9]{9}$/", $t_phone1)){
					// 	$t_phone2 = $t_phone1;
					// 	$t_phone = 'Mobile_No_Not_Correct';
					// 	$errmsg .= $t_phone." , ";
					// }
					// else{
					// 	$t_phone2 = $t_phone1;
					// }
					// if($t_email1 == ''){
					// 	$t_email2 = $t_email1;
					// 	$t_email = 'Email_Not_Found';
					// 	$errmsg .= $t_email." , ";
					// }else if(!filter_var($t_email1, FILTER_VALIDATE_EMAIL)){
					// 	$t_email2 = $t_email1;
					// 	$t_email = 'Email_Not_Correct';
					// 	$errmsg .= $t_email." , ";
					// }
					// else{
					// 	$t_email2 = $t_email1;
					// }
					if($t_school_name1 == ''){
						$t_school_name2 = $t_school_name1;
						$t_school_name = 'School Name not Correct';
						$errmsg .= $t_school_name." , ";
					}else{
						$t_school_name2 = $t_school_name1;
					}
					if($t_school_id1 == ''){
						$t_school_id2 = $t_school_id1;
						$t_school_id = 'School id Not Correct';
						$errmsg .= $t_school_id." , ";
					}else if ($t_school_id1 != $mainschool55){
						$t_school_id2 = $t_school_id1;
						$t_school_id = 'School id Not Correct , ';
						$errmsg .= $t_school_id;
					}
					else{
						$t_school_id2 = $t_school_id1;
					}

					if($t_id1 == ''){
						$t_id2 = $t_id1;
						$t_id = 'Teacher Id Not Correct';
						$errmsg .= $t_id." , ";
					}else{
						$t_id2 = $t_id1;
					}
					
					// if($t_qualification1 == ''){
					// 	$t_qualification2 = $t_qualification1;
					// 	$t_qualification = 'Designation Not Found';
					// 	$errmsg .= $t_qualification." , ";
					// }else{
					// 	$t_qualification2 = $t_qualification1;
					// }
					
					$err = substr_replace($errmsg , "", -2);
					if($err == '')
				{
					$err= $er['error_msg'];
				}
				
					echo "<tr>";

					echo "<td>$t_school_id2</td>";
					echo "<td>$t_id2</td>";
					echo "<td>$t_complete_name2</td>";
					echo "<td>$t_phone1</td>";
					echo "<td>$t_email1</td>";
					echo "<td>$t_qualification1</td>";
					echo "<td>$t_school_name1</td>";
					echo "<td>$upload_date</td>";
					echo "<td>$uploaded_by</td>";
					echo "<td>$batch_id</td>";
					echo "<td>$err</td>";
					echo "</tr>";
								
			}			
			echo "</table>";				
	}		

?>