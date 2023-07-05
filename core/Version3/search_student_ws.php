<?php
$json = file_get_contents('php://input');
$obj = json_decode($json);
include "conn.php";

$student_key = xss_clean(mysql_real_escape_string($obj->{'student_key'}));
$school_id = xss_clean(mysql_real_escape_string($obj->{'school_id'}));
$offset = xss_clean(mysql_real_escape_string($obj->{'offset'}));

$format = 'json';

$site=$GLOBALS['URLNAME'];
if(!empty($student_key)){
	if(!empty($school_id))
	{
		if(!empty($offset)){
	$query="SELECT  DISTINCT  school_id,id as member_id,std_PRN ,std_name,std_lastname,std_Father_name,std_complete_name,std_dept,std_class,std_branch,std_dob,std_age,	std_school_name,std_address,std_city,std_country,std_gender,std_div,std_hobbies,	std_img_path,std_email,std_phone,	std_state,Iscoordinator,Academic_Year FROM tbl_student 
	WHERE
	(std_PRN LIKE '%$student_key%'OR std_complete_name LIKE '%$student_key%' 
	OR std_lastname LIKE '%$student_key%' OR std_dept LIKE '$student_key%'	
	OR std_Father_name LIKE '%$student_key%' OR school_id LIKE '%$student_key%'
	OR std_name LIKE '%$student_key%' OR std_class LIKE '$student_key%' OR std_branch LIKE '%$student_key%') AND school_id = '$school_id' LIMIT 100 OFFSET $offset";
	
		}
		else{
			$query="SELECT  DISTINCT  school_id,id as member_id,std_PRN,std_name,std_lastname,std_Father_name,std_complete_name,std_dept,std_class,std_branch,std_dob,std_age,	std_school_name,std_address,std_city,std_country,std_gender,std_div,std_hobbies,	std_img_path,std_email,std_phone,	std_state,Iscoordinator,Academic_Year FROM tbl_student 
	WHERE
	(std_PRN LIKE '%$student_key%'OR std_complete_name LIKE '%$student_key%' 
	OR std_lastname LIKE '%$student_key%' OR std_dept LIKE '$student_key%'	
	OR std_Father_name LIKE '%$student_key%' OR school_id LIKE '%$student_key%'
	OR std_name LIKE '%$student_key%' OR std_class LIKE '$student_key%' OR std_branch LIKE '%$student_key%') AND school_id = '$school_id' LIMIT 100 ";
		}
	}
	else{
		if(!empty($offset)){
	$query="SELECT  DISTINCT  school_id,id as member_id,std_PRN,std_name,std_lastname,std_Father_name,std_complete_name,std_dept,std_class,std_branch,std_dob,std_age,	std_school_name,std_address,std_city,std_country,std_gender,std_div,std_hobbies,	std_img_path,std_email,std_phone,	std_state,Iscoordinator,Academic_Year FROM tbl_student 
	WHERE
	(std_PRN LIKE '%$student_key%'OR std_complete_name LIKE '%$student_key%' 
	OR std_lastname LIKE '%$student_key%' OR std_dept LIKE '$student_key%'	
	OR std_Father_name LIKE '%$student_key%' OR school_id LIKE '%$student_key%'
	OR std_name LIKE '%$student_key%' OR std_class LIKE '$student_key%' OR std_branch LIKE '%$student_key%') LIMIT 100 OFFSET $offset";
		}
		else{
			$query="SELECT  DISTINCT  school_id,id as member_id,std_PRN,std_name,std_lastname,std_Father_name,std_complete_name,std_dept,std_class,std_branch,std_dob,std_age,	std_school_name,std_address,std_city,std_country,std_gender,std_div,std_hobbies,	std_img_path,std_email,std_phone,	std_state,Iscoordinator,Academic_Year FROM tbl_student 
	WHERE
	(std_PRN LIKE '%$student_key%'OR std_complete_name LIKE '%$student_key%' 
	OR std_lastname LIKE '%$student_key%' OR std_dept LIKE '$student_key%'	
	OR std_Father_name LIKE '%$student_key%' OR school_id LIKE '%$student_key%'
	OR std_name LIKE '%$student_key%' OR std_class LIKE '$student_key%' OR std_branch LIKE '%$student_key%') LIMIT 100";
		}
	}
	
	$result = mysql_query($query,$con) or die('Errant query:  '.$query);
	$posts = array();
	
	if(mysql_num_rows($result) >= 1){
		while($post = mysql_fetch_assoc($result)){
			$res_school_id = htmlentities($post['school_id']);
			$res_member_id = htmlentities($post['member_id']);
			$res_std_PRN = htmlentities($post['std_PRN']);
			$std_name =htmlentities($post['std_name']);
			$std_Father_name = htmlentities($post['std_Father_name']);
			$std_lastname = htmlentities($post['std_lastname']);
			$res_std_complete_name = htmlentities($post['std_complete_name']);
			$res_std_dept = htmlentities($post['std_dept']);
			$res_std_class = htmlentities($post['std_class']);
			$res_std_branch = htmlentities($post['std_branch']);
			$std_dob = htmlentities($post['std_dob']);
			$std_age = htmlentities($post['std_age']);
			$std_school_name = htmlentities($post['std_school_name']);
			$std_address = htmlentities($post['std_address']);
			$std_city = htmlentities($post['std_city']);
			$std_country = htmlentities($post['std_country']);
			$std_gender = htmlentities($post['std_gender']);
			$std_div = htmlentities($post['std_div']);
			$std_hobbies = htmlentities($post['std_hobbies']);
			$std_img_path = htmlentities($post['std_img_path']);
			$std_email = htmlentities($post['std_email']);
			$std_phone = htmlentities($post['std_phone']);
			$std_state = htmlentities($post['std_state']);
			$Iscoordinator = htmlentities($post['Iscoordinator']);
			$Academic_Year = htmlentities($post['Academic_Year']);
			if($std_img_path != ''){
				
				$std_img_path="$site/core/".$std_img_path;
			}
			else{
				$std_img_path="$site/Assets/images/avatar/avatar_2x.png";
			}
			if($res_std_complete_name =='')
			{
				$res_std_complete_name=$std_name." ".$std_Father_name." ".$std_lastname;
			}
			else{
				$res_std_complete_name;
			}
			/** Author : Vaibhav G
			/*  Below code belongs to calculate age
			/* code start
			*/
			if(!empty($std_dob)){
				//date format changed by sachin
             //$std_dob = date("d/m/Y", strtotime( $std_dob));
			 $std_dob = date("Y/m/d", strtotime( $std_dob));
			 //end sachin
				
				$arr=explode('/',$std_dob);
				//$dateTs=date_default_timezone_set($std_dob); 
				$dateTs=strtotime($std_dob);
				 
				$now=strtotime('today');
				 
				//if(sizeof($arr)!=3) die('ERROR:please entera valid date');
				 
				//if(!checkdate($arr[0],$arr[1],$arr[2])) die('PLEASE: enter a valid dob');
				 
				//if($dateTs>=$now) die('ENTER a dob earlier than today');
				 
				$ageDays=floor(($now-$dateTs)/86400);
				 
				$ageYears=floor($ageDays/365);
				 
				$ageMonths=floor(($ageDays-($ageYears*365))/30);
				 
				$std_age= $ageYears;
			}
			/* code end
			*/
			
			$posts[] =array(
			"school_id"=>$res_school_id,
			"member_id"=>$res_member_id,
			"std_PRN"=>$res_std_PRN,
			"std_complete_name"=>ucwords(strtolower(trim($res_std_complete_name))),
			"std_img_path"=>$std_img_path,
			"std_dept"=>$res_std_dept,
			"std_class"=>$res_std_class,
			"std_dob"=>$std_dob,
			"std_age"=>$std_age,
			"std_school_name"=>$std_school_name,
			"std_address"=>$std_address,
			"std_city"=>$std_city,
			"std_country"=>$std_country,
			"std_gender"=>$std_gender,
			"std_div"=>$std_div,
			"std_hobbies"=>$std_hobbies,
			"std_email"=>$std_email,
			"std_phone"=>$std_phone,
			"std_state"=>$std_state,
			"Iscoordinator"=>$Iscoordinator,
			"Academic_Year"=>$Academic_Year,
			"std_branch"=>$res_std_branch
			
			);
		}
		$postvalue['responseStatus'] = 200;
		$postvalue['responseMessage'] = "OK";
		$postvalue['posts'] = $posts;

	}
	else{
		$postvalue['responseStatus'] = 204;
		$postvalue['responseMessage'] = 'No Response';
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