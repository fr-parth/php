<?php 
/*
Author : Pranali Dalvi
Date : 12-11-19
This API was created for Upload data status segregation (Percentage and Marks calculation) based on Information Provided by School Admin.
*/
 
$json = file_get_contents('php://input');
$obj = json_decode($json);
header('Content-type: application/json');
$format = 'json'; //xml is the default
include '../conn.php';

 $GroupID = xss_clean(mysql_real_escape_string($obj->{'GroupID'}));
 $SchoolID = xss_clean(mysql_real_escape_string($obj->{'SchoolID'}));
 $School_MemberID = xss_clean(mysql_real_escape_string($obj->{'School_MemberID'}));
 $School_Type = xss_clean(mysql_real_escape_string($obj->{'School_Type'}));
 
if($SchoolID!='') //School
{
 	// $sql = mysql_query("SELECT Academic_Year,Year FROM tbl_academic_Year WHERE school_id='".$SchoolID."' AND Enable='1'");
 	// $res = mysql_fetch_assoc($sql);
 	// $Academic_Year = $res['Academic_Year'];

	$query = "SELECT sd.*,dw.weightage FROM tbl_school_datacount sd
  			join tbl_datafile_weightage dw 
  			on sd.tbl_name=dw.tbl_name
  			where sd.school_id='".$SchoolID."' group by sd.school_id, sd.tbl_name,sd.semister_type ORDER BY sd.id DESC ";
 	
} else if($GroupID!=""){ //Group
	
 	$query = "SELECT DISTINCT(sd.id),sd.academic_year,
 				   sd.expected_records,sd.inserted_date,
				   sd.semister_type,sd.tbl_display_name,sd.uploaded_records,sd.tbl_name,sd.school_id,dw.weightage 
 				   FROM tbl_school_datacount sd
  				   JOIN tbl_datafile_weightage dw 
  				   ON sd.tbl_name=dw.tbl_name 
  				   LEFT JOIN tbl_school_admin sa ON sd.school_id=sa.school_id
  				   WHERE sa.group_member_id='".$GroupID."' AND sd.school_id='".$SchoolID."' ORDER BY sd.id DESC";  
}
else { //Cookie
	$query = "SELECT sd.*,dw.weightage FROM tbl_school_datacount sd
  			join tbl_datafile_weightage dw 
  			on sd.tbl_name=dw.tbl_name group by sd.school_id, sd.tbl_name,sd.semister_type ORDER BY sd.id DESC";
}
	$data = mysql_query($query);
 	$count = mysql_num_rows($data);
 	if($count>0)
 	{
 		$posts = array();
 		while ($result = mysql_fetch_assoc($data)) {
 		
		//Shifted code of calculating $actual_records above and shifted $percent calculation code down for solving bug SMC-5143 by Pranali				    

				//Below if else conditions added by Rutuja for dynamicaly reflecting the count of Actual records for SMC-4921 on 23-10-2020	
			if($SchoolID!=''){
	            $tbl_name = $result['tbl_name'];
            
            
            	if($tbl_name=='tbl_department_master'){
               	$school_id_var = 'School_ID';
            	}else{
               	$school_id_var = 'school_id';
            	}
            
            $master = mysql_query("SELECT * FROM $tbl_name WHERE $school_id_var='$SchoolID'");
            $actual_records = mysql_num_rows($master);
        	}
            else{
            	// $actual_records=$result['uploaded_records'];
            }

            		if($result['expected_records'] > $result['uploaded_records'] ){
	                   $percent = 100; 
	                }
	                else{
	               		$percent = round(($result['expected_records'] / $result['uploaded_records']) * 100, 2);
	                }
	                
	                
	                $marks = round(($percent * $result['weightage']) / 100, 2);

	                $percent_sum +=	$percent; 

					$posts[] = array('id'=>$result['id'],'school_id'=>$result['school_id'],'academic_year'=>$result['academic_year'],'semister_type'=>$result['semister_type'],'tbl_name'=>$result['tbl_name'],'tbl_display_name'=>$result['tbl_display_name'],'actual_records'=>$actual_records,'expected_records'=>$result['expected_records'],'date'=>$result['inserted_date'],'weightage'=>$result['weightage'],'percentage'=>$percent,'marks'=>$marks); 
	                
 	}
 	    $total_percent = round(($percent_sum*100)/($count*100),2);
 		$postvalue['responseStatus']=200;
		$postvalue['responseMessage']="OK";
		$postvalue['count']=$count;
		$postvalue['total_percent']=$total_percent;
		$postvalue['posts']=$posts;
	}
	else{
		$postvalue['responseStatus']=204;
		$postvalue['responseMessage']="No record found";
	}
 /* disconnect from the db */
  echo json_encode($postvalue);

  @mysql_close($conn);	
?>