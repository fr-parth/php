<?php
$json = file_get_contents('php://input');
$obj = json_decode($json);


$teacher_key = trim($obj->{'teacher_key'});
$school_id = $obj->{'school_id'};

$format = 'json';
include "conn.php";

$site=$GLOBALS['URLNAME'];
if(!empty($teacher_key)){
	 
	if(!empty($school_id))
	{

	  $query="SELECT DISTINCT t.id,t.t_pc, t.t_id, t.t_complete_name, t.t_name, t.t_middlename, t.t_lastname, t.t_dept, t.school_id, t.t_class,ts.subjectName,ts.subjcet_code FROM tbl_teacher as t left join tbl_teacher_subject_master as ts on t.t_id=ts.teacher_id and t.school_id=ts.school_id left join tbl_academic_Year as ay on ay.Year=ts.AcademicYear and ay.Enable='1' and ay.school_id=t.school_id WHERE (t.t_complete_name LIKE '%$teacher_key%' OR t.t_name LIKE '%$teacher_key%' OR t.t_lastname LIKE '%$teacher_key%') AND t.school_id ='$school_id'";

	
	//echo $query;exit;
	}
	else
	{
		 $query="SELECT DISTINCT t.id,t.t_pc, t.t_id, t.t_complete_name, t.t_name, t.t_middlename, t.t_lastname, t.t_dept, t.school_id, t.t_class,ts.subjectName,ts.subjcet_code FROM tbl_teacher as t left join tbl_teacher_subject_master as ts on t.t_id=ts.teacher_id and t.school_id=ts.school_id left join tbl_academic_Year as ay on ay.Year=ts.AcademicYear and ay.Enable='1' and ay.school_id=t.school_id WHERE (t.t_complete_name LIKE '%$teacher_key%' OR t.t_name LIKE '%$teacher_key%' OR t.t_lastname LIKE '%$teacher_key%')";
		 
	}
	$result = mysql_query($query) or die('Errant query:  '.$query);
	
	$count=mysql_num_rows($result);
	$posts = array();
	
	
		
	if( $count > 0){
		
		while($post = mysql_fetch_array($result)){
			
			$id=$post['id'];
			$t_id=$post['t_id'];
			$t_pc=$post['t_pc'];
			$t_complete_name=$post['t_complete_name'];
			$t_name=$post['t_name'];
			$t_middlename=$post['t_middlename'];
			$t_lastname=$post['t_lastname'];
			$t_dept=$post['t_dept'];
			$t_class=$post['t_class'];
			$school_id=$post['school_id'];
			$subjectName=htmlspecialchars($post['subjectName']);
			$subjcet_code= htmlspecialchars($post['subjcet_code']);
			
			if($t_complete_name!=""){
				$t_complete_name;
			}
			else{
				
				$t_complete_name=$t_name." ".$t_middlename." ".$t_lastname;
			}
			if($t_pc!=""){
				$image=$site."/teacher_images/".$t_pc;
			}
			else{
				
			$image=$site."/Assets/images/avatar/avatar_2x.png";
			}
			
		if($subjectName == NULL) 
			{
				$subjectName='';
				
			}
		if($subjcet_code == NULL)
		{
			$subjcet_code='';
		}
		if($t_class == NULL)
		{
			$t_class='';
		}
		if($t_dept == NULL)
		{
			$t_dept='';
		}
			
			$data[]=array(
			"id"=> $id,
			"teacher_image"=> $image,
            "teacher_id"=> $t_id,
            "teacher_name"=>$t_complete_name,
            "t_dept"=>$t_dept,
            "school_id"=> $school_id,
            "t_class"=>$t_class,
            "subjectName"=>$subjectName,
            "SubjectCode"=>$subjcet_code
			);
			
			
			
			
		}	
		
	
		$posts = $data;
		$postvalue['responseStatus'] = 200;
		$postvalue['responseMessage'] = "OK";
		$postvalue['posts'] = $posts;

	}
	else{
		$postvalue['responseStatus'] = 204;
		$postvalue['responsMessage'] = 'No Response';
		$postvalue['posts'] = NULL;
	}
	
	if($format = 'json'){
		header('Content-type: application/json');
		echo json_encode($postvalue);
	}
	
}

else{

	$postvalue['responseStatus']=1000;
	$postvalue['responseMessage']="Invalid Input";
	$postvalue['posts']=null;
	
	header('Content-type: application/json');
   	echo  json_encode($postvalue);
}

  @mysql_close($con);

?>