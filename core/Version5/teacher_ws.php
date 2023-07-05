<?php 
include '../conn.php'; 
$json = file_get_contents('php://input');
$obj = json_decode($json);
$format = 'json';
$arr="";
$msg="";

$school_id=xss_clean(mysql_real_escape_string($obj->{'school_id'}));
$teacher_id=xss_clean(mysql_real_escape_string($obj->{'t_id'}));
$f=xss_clean(mysql_real_escape_string($_GET['f']));
// pagination code sachin
$offset=xss_clean(mysql_real_escape_string($obj->{'offset'}));
$offset = offset($offset);
$limit=xss_clean(mysql_real_escape_string($obj->{'limit'}));
//pass $limit & $offset values in functions
//end pagination code sachin
//echo $limit;
//echo $offset;
//exit;
 $image_path = "vvvvvvvv";//$GLOBALS['URLNAME']."/core/summaryicon/";

if(function_exists(xss_clean(mysql_real_escape_string($_GET['f'])))){
	switch(xss_clean(mysql_real_escape_string($_GET['f']))) {
	case 'teacherMyBranch':
		$arr=$f(xss_clean(mysql_real_escape_string($obj->{'school_id'})),xss_clean(mysql_real_escape_string($obj->{'t_id'})),$limit,$offset);
		break;
	case 'teacherMySemester':
		$arr=$f['f'](xss_clean(mysql_real_escape_string($obj->{'school_id'})),xss_clean(mysql_real_escape_string($obj->{'t_id'})),$limit,$offset);
		break;
	case 'teacherMySubjects':
		$arr=$f(xss_clean(mysql_real_escape_string($obj->{'school_id'})),xss_clean(mysql_real_escape_string($obj->{'t_id'})),xss_clean(mysql_real_escape_string($obj->{'Division_id'})),xss_clean(mysql_real_escape_string($obj->{'Semester_id'})),xss_clean(mysql_real_escape_string($obj->{'Branches_id'})),xss_clean(mysql_real_escape_string($obj->{'Department_id'})),xss_clean(mysql_real_escape_string($obj->{'CourseLevel'})),xss_clean(mysql_real_escape_string($obj->{'acadmic_year'})),$limit,$offset);
		break;
		
	case 'teacherallsubjects':
		$arr=$f(xss_clean(mysql_real_escape_string($obj->{'school_id'})),xss_clean(mysql_real_escape_string($obj->{'t_id'})),xss_clean(mysql_real_escape_string($obj->{'Division_id'})),xss_clean(mysql_real_escape_string($obj->{'Semester_id'})),xss_clean(mysql_real_escape_string($obj->{'Branches_id'})),xss_clean(mysql_real_escape_string($obj->{'Department_id'})),xss_clean(mysql_real_escape_string($obj->{'CourseLevel'})),$limit,$offset);
		break;
		
	case 'teacherMystudentsforsubject':
		$arr=$f(xss_clean(mysql_real_escape_string($obj->{'school_id'})),xss_clean(mysql_real_escape_string($obj->{'t_id'})),xss_clean(mysql_real_escape_string($obj->{'Division_id'})),xss_clean(mysql_real_escape_string($obj->{'Semester_id'})),xss_clean(mysql_real_escape_string($obj->{'Branches_id'})),xss_clean(mysql_real_escape_string($obj->{'Department_id'})),
		xss_clean(mysql_real_escape_string($obj->{'CourseLevel'})),xss_clean(mysql_real_escape_string($obj->{'subject_code'})),xss_clean(mysql_real_escape_string($obj->{'AcademicYear'})),$limit,$offset);
		break;
		
	case 'rewardlog':
		$arr=$f(xss_clean(mysql_real_escape_string($obj->{'school_id'})),xss_clean(mysql_real_escape_string($obj->{'t_id'})),$limit,$offset);
		break;
		
	case 'teacher_particular_subjectsforstudent':
		$arr=$f(xss_clean(mysql_real_escape_string($obj->{'school_id'})),xss_clean(mysql_real_escape_string($obj->{'t_id'})),xss_clean(mysql_real_escape_string($obj->{'std_PRN'})),$limit,$offset);
		break;
		//teaching_process case added by Pranali for SMC-3808 to display teacher subject's scheduled classes and actual classes on 26-4-19
	case 'teaching_process':
		$arr=$f(xss_clean(mysql_real_escape_string($obj->{'school_id'})),xss_clean(mysql_real_escape_string($obj->{'t_id'})));
		break;
	}
}

function teacherMyBranch($school_id,$teacher_id,$limit,$offset){
	$arr=mysql_query("select distinct st.Branches_id from `tbl_teacher_subject_master` st JOIN `tbl_academic_Year` Y ON st.AcademicYear = Y.Year where st.school_id='$school_id' and st.teacher_id='$teacher_id' and Y.Enable = '1' limit $limit OFFSET $offset");
	return $arr; 
}
function teacherMySemester($school_id,$teacher_id,$limit,$offset){
	$arr=mysql_query("select distinct st.Semester_id from `tbl_teacher_subject_master` st JOIN `tbl_academic_Year` Y ON st.AcademicYear = Y.Year where st.school_id='$school_id' and st.teacher_id='$teacher_id' and Y.Enable = '1' limit $limit OFFSET $offset");
	return $arr; 	
}
function teacherMySubjects($school_id,$teacher_id,$Division_id,$Semester_id,$Branches_id,$Department_id,$CourseLevel,$acadmic_year,$limit,$offset){
		$query="SELECT distinct st.Branches_id,st.school_id, st.subjcet_code, st.subjectName,st.AcademicYear, st.Division_id, st.Semester_id, st.Department_id, st.CourseLevel,ss.Subject_type,ss.subject
		FROM `tbl_teacher_subject_master` st
	 INNER JOIN tbl_academic_Year Y ON st.AcademicYear = Y.Academic_Year AND Y.school_id=st.school_id
	 INNER JOIN tbl_school_subject ss ON ss.school_id = st.school_id AND ss.Subject_Code=st.subjcet_code AND ss.subject=st.subjectName
	 
		WHERE st.school_id = '$school_id'
		AND  st.teacher_id = '$teacher_id'
		AND Y.school_id = '$school_id'
		AND ss.school_id = '$school_id'";
		
		if($Division_id!=""){
			$query .="AND st.Division_id='$Division_id'";
		}
		if($Semester_id!=""){
			$query .="AND st.Semester_id='$Semester_id'";
		}
		if($Branches_id!=""){
			$query .="AND st.Branches_id='$Branches_id'";
		}
		if($Department_id!=""){
			$query .="AND st.Department_id='$Department_id'";
		}
		if($CourseLevel!=""){
			$query .="AND st.CourseLevel='$CourseLevel'";
		}
		if($acadmic_year!=""){
			$query .="AND st.AcademicYear='$acadmic_year'";
		}
		if($limit!='All'){
			$query .="limit $limit OFFSET $offset";}

		$query .="order by st.subjectName";
		  // echo $query;exit;
		$arr=mysql_query($query);
		return $arr; 
}


function teacherallsubjects($school_id,$teacher_id,$Division_id,$Semester_id,$Branches_id,$Department_id,$CourseLevel,$limit,$offset){
		$query="SELECT distinct st.Branches_id,st.school_id, st.subjcet_code, st.subjectName,st.AcademicYear, st.Division_id, st.Semester_id, st.Department_id, st.CourseLevel
		FROM `tbl_teacher_subject_master` st
		WHERE st.school_id = '$school_id'
		AND  st.teacher_id = '$teacher_id'";
		if($Division_id!=""){
			$query .="AND st.Division_id='$Division_id'";
		}
		if($Semester_id!=""){
			$query .="AND st.Semester_id='$Semester_id'";
		}
		if($Branches_id!=""){
			$query .="AND st.Branches_id='$Branches_id'";
		}
		if($Department_id!=""){
			$query .="AND st.Department_id='$Department_id'";
		}
		if($CourseLevel!=""){
			$query .="AND st.CourseLevel='$CourseLevel'";
		}
		$query .="order by st.subjectName limit $limit OFFSET $offset";
		$arr=mysql_query($query);
		return $arr; 
}

function teacherMystudentsforsubject($school_id,$teacher_id,$Division_id,$Semester_id,$Branches_id,$Department_id,$CourseLevel,$subject_code,$AcademicYear,$limit,$offset)
{
    /*
        * commented semester table join because of response time
        * no index for join columns
        * commented by Shivkumar on 20180825
    */
    //$AcademicYear='2020-2021';
    
      $sql="SELECT distinct ss.student_id, ucwords(std.std_complete_name) as std_complete_name, ucwords(std.std_name) as std_name ,ucwords(std.std_Father_name) as std_Father_name, ucwords(std.std_lastname) as std_lastname, std.std_img_path, std.school_id, std.std_dept, std.std_branch, std.std_class, std.std_dob, round(DATEDIFF(CURRENT_DATE, STR_TO_DATE(std_dob, '%Y/%m/%d'))/365) as std_age, std.std_school_name, std.std_address,std.std_city, std.std_country, std.std_gender, std.std_div, std.std_hobbies,std.std_email, std.std_phone, std.std_state, std.Iscoordinator, Y.Academic_Year
FROM tbl_student_subject_master ss
-- join tbl_teacher_subject_master st on st.subjcet_code=ss.subjcet_code and st.school_id=ss.school_id
join tbl_student std on std.std_PRN=ss.student_id  AND std.school_id=ss.school_id
join tbl_academic_Year Y on ss.AcademicYear=Y.Academic_Year AND Y.school_id=ss.school_id
WHERE ss.school_id='$school_id'";
// if($teacher_id){
// $sql.= " and ss.`teacher_id` ='$teacher_id'";
// }
if($Semester_id){
$sql.= " and ss.Semester_id='$Semester_id'";
}
if($Branches_id){
$sql.= " and ss.Branches_id='$Branches_id'";
}
if($subject_code){
$sql.= " and ss.subjcet_code='$subject_code'";
}
if($Division_id){
$sql.= " and ss.Division_id='$Division_id'";
}
if($AcademicYear){
$sql.= "  and ss.AcademicYear='$AcademicYear'";
}
else
{
	$sql.= "";
}
if($limit!='')
{
	if($limit=='All')
	{
		$sql.= " order by std_complete_name ";
	}
	else
	{
       $sql.= " order by std_complete_name limit $limit OFFSET $offset";
	}

}
else
{
 $sql.= " order by std_complete_name";

}

 //echo $sql;exit;
    $arr=mysql_query($sql);
    //$arr1=mysql_fetch_array($arr);
    //print_r($arr1);exit;

    return $arr;
}



function teacher_particular_subjectsforstudent($school_id,$t_id,$std_PRN,$limit,$offset)
{
	//SMC-3669 start sports/subject image path added by Pravin 2018-11-24 4:43 PM 
	$image_path = $GLOBALS['URLNAME']."/core/subjectSportsImages/";
	$default_image_path = $GLOBALS['URLNAME']."/Assets/images/avatar/avatar_2x.png";
	
$arr=mysql_query("SELECT ss.id as subjcet_code,sm.subjectName,sm.Semester_id,sm.Branches_id,teacher_ID,IF(ss.image = '','$default_image_path',concat('$image_path',ss.image)) as image FROM tbl_student_subject_master sm JOIN tbl_school_subject ss ON sm.subjcet_code=ss.Subject_Code JOIN tbl_academic_Year a ON sm.AcademicYear = a.Year WHERE sm.student_id ='$std_PRN' AND sm.school_id='$school_id' AND Enable='1' AND sm.teacher_ID='$t_id' group by sm.subjectName limit $limit OFFSET $offset");
//SMC-3669 End
if(mysql_num_rows($arr) < 1)
{
$arr = mysql_query("SELECT ss.id as subjcet_code,subjectName,Semester_id,Branches_id,teacher_ID  FROM tbl_student_subject_master sm  LEFT JOIN tbl_academic_Year a ON sm.AcademicYear = a.Year 
WHERE sm.student_id = '$std_PRN' AND sm.school_id='$school_id' limit $limit OFFSET $offset");
}

	return $arr; 	
}

function rewardlog($school_id,$t_id,$limit,$offset)
{
$arr=mysql_query("select st.sc_point,s.std_complete_name,st.point_date,
						
IF(st.activity_type ='subject', (SELECT subjectName from tbl_teacher_subject_master where subjcet_code=sc_studentpointlist_id and school_id='$school_id' and teacher_id='$t_id'), (SELECT sc_list FROM tbl_studentpointslist WHERE sc_id = sc_studentpointlist_id ) ) AS reason from tbl_student_point st  join tbl_student s on  s.std_PRN=st.sc_stud_id
 where st.sc_teacher_id='$t_id' and st.sc_entites_id='103' and s.school_id='$school_id' ORDER BY st.id DESC limit $limit OFFSET $offset");
 
 return $arr;
}
	//teaching_process case added by Pranali for SMC-3808 to display teacher subject's scheduled classes and actual classes on 26-4-19
function teaching_process($school_id,$t_id)	{

	/*$arr=mysql_query("SELECT fbt.*,tsm.subjcet_code,tsm.subjectName
					FROM tbl_teacher_subject_master tsm
					JOIN tbl_360feedback_template fbt on tsm.teacher_id=fbt.feed360_teacher_id and tsm.school_id=fbt.feed360_school_id
					WHERE fbt.feed360_teacher_id='".$t_id."' AND fbt.feed360_school_id='".$school_id."'");
	
	//if(mysql_num_rows($arr)==0){*/

		$arr=mysql_query("SELECT tch_sub_id as feed360_ID, AcademicYear as feed360_academic_year_ID  ,Semester_id as feed360_semester_ID  ,Branches_id as feed360_branch_ID, Department_id as feed360_dept_ID, CourseLevel as feed360_course_ID, teacher_id as feed360_teacher_id,school_id as feed360_school_id,subjcet_code as feed360_subject_code, subjectName as feed360_subjcet_id
			FROM tbl_teacher_subject_master 
			WHERE teacher_id='".$t_id."' and school_id='".$school_id."'");
	//}
	return $arr;
}			
  			$posts = array();
//pagination code sachin
			$numrecord=	mysql_num_rows($arr);
			if($numrecord==0 && ($arr)) 
					{
						if($offset==0)
						{
							$postvalue['responseStatus']=204;
							$postvalue['responseMessage']="No Record Found";
							$postvalue['posts']=null;
						}else
							{
								$postvalue['responseStatus']=224;
								$postvalue['responseMessage']="End Of Records";
								$postvalue['posts']=null;
							}	
					}		
				else if($numrecord>0)
				{
//pagination code sachin

//Start SMC-3563 Modify by Pravin 2018-10-10 09:08 PM
					while($post = mysql_fetch_assoc($arr))
					{				
						 
						foreach($post as $key=>$value)
						{
			   
							      $abc[$key] = isset($value) ? $value : "";
								 
						}
						$posts[] = $abc;
					}
					
//End SMC-3563					
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
  					/* output in necessary format */
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
		
  /* disconnect from the db */
  @mysql_close($con);	
	
		
  ?>