<?php 

include '../conn.php';

 $json = file_get_contents('php://input');
 $obj = json_decode($json);

 $format = 'json';

 

  $t_id = xss_clean(mysql_real_escape_string($obj->{'t_id'}));
  $school_id = xss_clean(mysql_real_escape_string($obj->{'school_id'}));
  $input_id = xss_clean(mysql_real_escape_string($obj->{'input_id'}));
 //SMC-3507 modify Pravin 2018-10-09 1:28 PM 
  $offset = xss_clean(mysql_real_escape_string($obj->{'offset'}));
//offset function call from core/securityfunctions.php
 $offset=offset($offset);//default offset = "0"
 //Added new input parameter by Pranali for SMC-5092 on 7/1/21
 $Limit = xss_clean(mysql_real_escape_string($obj->{'limit'}));
 $t_dept = xss_clean(mysql_real_escape_string($obj->{'ExtDeptId'}));

if($school_id != "" && $t_id != "" )
{

if($input_id==0 && $input_id=="")
{
	$input_id=0;
}
else
{
	$input_id=$input_id+1;
}
if($t_dept!='')
{
   $cond="and s.ExtDeptId='$t_dept'";
}
else
{
   $cond="";
}

 $query="SELECT DISTINCT ss.student_id, ss.school_id, ss.subjectName, ss.Branches_id, ss.AcademicYear, ss.Division_id, s.std_complete_name,s.std_address,s.std_age, s.std_name,s.std_city, s.std_lastname, s.std_Father_name,s.std_class,s.std_country, s.std_phone,s.std_img_path,s.std_PRN,s.std_school_name,s.std_email,s.std_gender,s.std_dob,s.std_date,s.std_hobbies,s.std_semester,ss.Semester_id ,s.id
FROM tbl_student_subject_master ss JOIN tbl_academic_Year Y ON ss.AcademicYear = Y.Year and Y.Enable='1' JOIN tbl_student s ON s.std_PRN = ss.student_id and s.school_id =  '$school_id'
    $cond WHERE ss.`teacher_id` ='$t_id' AND ss.school_id =  '$school_id' group by ss.student_id ORDER BY s.std_class, std_name,s.std_PRN";

 $count_query=mysql_num_rows(mysql_query($query));
if ($count_query > 0 )
{
	if($Limit==''){
		$Limit=$limit;
   }
   else if($Limit=='All' && ($offset=='0' || $offset!='0')){
   		
   		$Limit=$count_query;
   }

	 $query .=" LIMIT $Limit OFFSET $offset ";
	
	$sql=mysql_query($query);
//$limit call from core/securityfunctions.php
}
	
	if($count_query < 1 )
	{
		// Comment by Pravin due to limit 4450 is already declared 
			/*$sql = mysql_query("SELECT  ss.student_id, ss.school_id, s.std_city, ss.subjectName, ss.Branches_id, ss.AcademicYear, ss.Division_id, s.std_complete_name, s.std_name, s.std_lastname,s.std_age, s.std_hobbies, s.std_Father_name, s.std_country, s.std_phone, s.std_address, s.std_img_path, s.std_PRN, s.std_school_name , s.std_email, s.std_gender, s.std_dob, s.std_date, s.std_class, s.std_semester,  ss.Semester_id 
			FROM tbl_student_subject_master ss join tbl_student s on s.std_PRN = ss.student_id AND s.school_id='$school_id'
			WHERE ss.school_id='$school_id'
			group by ss.student_id 
			ORDER BY s.std_name limit 4450
			");	*/
//As approved by Avi Sir , changed below queries by Pranali to display all students of that particular school for SMC-3787 on 25-2-19
			$sql1 = mysql_query("SELECT s.std_city, s.std_complete_name, s.std_name, s.std_lastname,s.std_age, s.std_hobbies, s.std_Father_name, s.std_country, s.std_phone, s.std_address, s.std_img_path, s.std_PRN, s.std_school_name , s.std_email, s.std_gender, s.std_dob, s.std_date, s.std_class, s.std_semester ,s.id
			FROM tbl_student s 
			WHERE s.school_id='$school_id'
			ORDER BY s.std_name");		
			$count_query=mysql_num_rows($sql1);	
			
			if($Limit==''){
				$Limit=$limit;
		   }
		   else if($Limit=='All' && ($offset=='0' || $offset!='0')){
		   		
		   		$Limit=$count_query;
		   }

$sql = mysql_query("SELECT  s.std_city, s.std_complete_name, s.std_name, s.std_lastname,s.std_age, s.std_hobbies, s.std_Father_name, s.std_country, s.std_phone, s.std_address, s.std_img_path, s.std_PRN, s.std_school_name , s.std_email, s.std_gender, s.std_dob, s.std_date, s.std_class, s.std_semester,s.id 
			FROM tbl_student s 
			WHERE s.school_id='$school_id' $cond
			ORDER BY s.std_name LIMIT $Limit OFFSET $offset
			");	
//$limit call from core/securityfunctions.php
			
	}

	$post['input_id']=0;
	 $count=mysql_num_rows($sql);
	if($count==0 && $sql) 
					{
						if($offset==0)
						{
							
							$postvalue['responseStatus']=204;
							$postvalue['responseMessage']="No Record found";
							$postvalue['posts']=null;
						}else
							{
						$postvalue['responseStatus']=224;
						$postvalue['responseMessage']="End of Records";
						$postvalue['posts']=null;
							}
						
					}
					//End SMC-3507
  			else if($count > 0) 
			{
    		while($post = mysql_fetch_assoc($sql)) {
				
			$std_complete_name=clean_string(isset($post['std_complete_name'])?$post['std_complete_name']:'');		 
			$std_school_name=isset($post['std_school_name'])?$post['std_school_name']:'';
			if($std_complete_name=='')
			{
				 $std_complete_name=$post['std_name']." ".$post['std_Father_name']." ".$post['std_lastname'];
			}
			$std_date=isset($post['std_date'])? $post['std_date']:'';
			$std_img_path1=$post['std_img_path'];
			if($std_img_path1=="")
			{	
				$std_img_path=$GLOBALS['URLNAME']."/Assets/images/avatar/avatar_2x.png";
			}
			else{
				//Image path added by Rutuja Jori on 14/08/2019
				$std_img_path=$GLOBALS['URLNAME']."/core/".$std_img_path1;
			}

			$student_id=(int)$post['student_id'];
			$std_city=ucwords(strtolower($post['std_city']));
			$std_PRN=isset($post['std_PRN'])?$post['std_PRN']:'';
			$std_Father_name=ucwords(strtolower(isset($post['std_Father_name'])?$post['std_Father_name']:''));
			$std_gender=isset($post['std_gender'])?$post['std_gender']:'';
			$std_dob=isset($post['std_dob'])?$post['std_dob']:'';
			$std_email=isset($post['std_email'])?$post['std_email']:'';
			$std_country=ucwords(strtolower($post['std_country']));
			$std_date=isset($post['std_date'])?$post['std_date']:'';
			$subjectName = ucwords(strtolower(isset($post['subjectName'])?$post['subjectName']:''));
			$std_phone = isset($post['std_phone'])?$post['std_phone']:'';
			$std_class=isset($post['std_class'])?$post['std_class']:'';			
			$std_address=isset($post['std_address'])?$post['std_address']:'';		
			$std_age=(int)$post['std_age'];
			$std_div=isset($post['Division_id'])?$post['Division_id']:'';			
			$std_hobbies=isset($post['std_hobbies'])?$post['std_hobbies']:'';		
			$post['input_id']=$input_id;
			$stud_mem_id=(int)$post['id'];
	$count=mysql_num_rows($sql);
	
	$query=mysql_query("select status from tbl_coordinator where stud_id = '$student_id' and school_id='$school_id' ");
	$result1=mysql_fetch_array($query);
	$thanqu_flag=$result1['status'];

		 if($thanqu_flag =="Y")
		 {
			 $is_coordinator='Y';
		 }
		 
		 else
		 {
			 $is_coordinator='N'; 
			 
		 }
	
			/** Author : Vaibhav G
			/*  Below code belongs to calculate age
			/* code start
			*/
			if(!empty($std_dob)){
				//date format changed by sachin
				//$std_dob = date("d/m/Y", strtotime( $std_dob));
				$std_dob = date("Y/m/d", strtotime( $std_dob));
				//end changes
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
			
			$posts[] = array(
			'subjec_name'=>clean_string($subjectName),
			'student_id'=>clean_string($student_id),
			'std_name'=>clean_string(ucwords(strtolower($std_complete_name))),'std_father_name'=>clean_string($std_Father_name),
			'std_school_name'=>clean_string($std_school_name),
			'std_class'=>clean_string($std_class),
			'std_address'=>clean_string($std_address),
			'std_gender'=>clean_string($std_gender),
			'std_dob'=>clean_string($std_dob),
			'std_age'=>clean_string($std_age),
			'std_city'=>clean_string($std_city),
			'std_phone'=>clean_string($std_phone),
			'std_email'=>clean_string($std_email),
			'std_PRN'=>clean_string($std_PRN),
			'school_id'=>clean_string($school_id),
			'std_date'=>clean_string($std_date),
			'std_div'=>clean_string($std_div),
			'std_hobbies'=>clean_string($std_hobbies),
			'std_country'=>clean_string($std_country),
			'std_img_path'=>clean_string($std_img_path),
			'input_id'=>clean_string($input_id),
			'total_count'=>clean_string($count_query),
			'is_coordinator'=>clean_string($is_coordinator),
			'stud_mem_id'=>clean_string($stud_mem_id)
			);	

	  $input_id++;
    }
	
		$postvalue['responseStatus']=200;
		$postvalue['responseMessage']="OK";
		$postvalue['posts']=$posts;

  }
  else
  {
				$postvalue['responseStatus']=204;
				$postvalue['responseMessage']="No Response";
				$postvalue['posts']=null;	
  }
	
	
	
	if($format == 'json') {
    					header('Content-type: application/json');
   					 echo json_encode($postvalue);
  					}
 				 else {
   				 		header('Content-type: text/xml');
    					echo '';
   					 	foreach($posts as $index => $post) {
     						 if(is_array($post)) {
       							 foreach($post as $key => $value) {
        							  echo '<',$key,'>';
          								if(is_array($value)) {
            								foreach($value as $tag => $val) {
              								echo '<',$tag,'>',htmlentities($val),'</',$tag,'>';
            											}
         									}
         							  echo '</',$key,'>';
        						}
      						}
    				}
   			 echo '';
 				 }
	
		}
	else
	{
		$postvalue['responseStatus']=1000;
		$postvalue['responseMessage']="Invalid Input";
		$postvalue['posts']=null;
	  
		header('Content-type: application/json');
		echo  json_encode($postvalue); 
	}