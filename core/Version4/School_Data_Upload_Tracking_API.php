<?php  
/*Author : Pranali Dalvi
Date : 14-11-2019
This API was created for tracking all data uploaded by school and create reports in Cookie Admin and Group Admin.
*/
$json = file_get_contents('php://input');
$obj = json_decode($json);

 $format = 'json';

include '../conn.php';

$SchoolID = xss_clean(mysql_real_escape_string($obj->{'SchoolID'}));
$GroupID = xss_clean(mysql_real_escape_string($obj->{'GroupID'}));
$Academic_Year = xss_clean(mysql_real_escape_string($obj->{'Academic_Year'}));

	if($SchoolID!='' && $GroupID!='' && $Academic_Year!=''){
				
		$sql = mysql_query("SELECT bm.batch_id,bm.input_file_name,bm.school_id,bm.display_table_name,bm.db_table_name,bm.uploaded_date_time,bm.group_member_id,ay.Academic_Year,dw.Weightage 
			FROM tbl_Batch_Master bm
			LEFT JOIN tbl_academic_Year ay 
			ON bm.school_id=ay.school_id AND bm.group_member_id=ay.group_member_id
			LEFT JOIN tbl_datafile_weightage dw
			ON bm.display_table_name=dw.table_name 
			WHERE bm.school_id='".$SchoolID."' AND bm.group_member_id='".$GroupID."' AND ay.Academic_Year='".$Academic_Year."' 
			GROUP BY bm.display_table_name");
				
		$post = array();
		$count = mysql_num_rows($sql);
		if($count==0){

			$acad_year=mysql_query("SELECT Academic_Year FROM tbl_academic_Year where group_member_id='".$GroupID."' AND Enable='1' AND school_id='".$SchoolID."' order by id desc");
			
			$acad_year1=mysql_fetch_assoc($acad_year);
			$Year=$acad_year1['Academic_Year'];
			
			$sql = mysql_query("SELECT bm.batch_id,bm.input_file_name,bm.school_id,bm.display_table_name,bm.db_table_name,bm.uploaded_date_time,bm.group_member_id,ay.Academic_Year,dw.Weightage 
					FROM tbl_Batch_Master bm
					LEFT JOIN tbl_academic_Year ay 
					ON bm.school_id=ay.school_id AND bm.group_member_id=ay.group_member_id
					LEFT JOIN tbl_datafile_weightage dw
					ON bm.display_table_name=dw.table_name 
					WHERE bm.school_id='".$SchoolID."' AND bm.group_member_id='".$GroupID."' AND ay.Academic_Year='".$Year."' 
					GROUP BY bm.display_table_name");
			$count = mysql_num_rows($sql);

		}
			$sum=0;
			while($row=mysql_fetch_assoc($sql)){

				$post[] = $row;
				$sum+=$row['Weightage'];
			}		
				$postvalue['responseStatus']=200;
				$postvalue['responseMessage']="OK";
				$postvalue['count']=$count;
				$postvalue['percentage']=$sum."%";
				$postvalue['posts']=$post;
				
	}
	else
  	{			$postvalue['responseStatus']=1000;
				$postvalue['responseMessage']="Invalid Input";
	}
  	header('Content-type: application/json');
   	echo  json_encode($postvalue); 
?>