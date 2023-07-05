<?php  
/*Created by Rutuja Jori on 14/08/2019*/

$json = file_get_contents('php://input');
$obj = json_decode($json);

$format = 'json'; //xml is the default

include '../conn.php';

//input from user
	
	$User_Meid = xss_clean(mysql_real_escape_string($obj->{'User_Meid'}));
	
	$school_id = xss_clean(mysql_real_escape_string($obj->{'school_id'}));
	$User_FName = xss_clean(mysql_real_escape_string($obj->{'User_FName'}));
	$User_fathername = xss_clean(mysql_real_escape_string($obj->{'User_fathername'}));
	$User_LName = xss_clean(mysql_real_escape_string($obj->{'User_LName'}));
	$User_email = xss_clean(mysql_real_escape_string($obj->{'User_email'}));
	$User_Phone = xss_clean(mysql_real_escape_string($obj->{'User_Phone'}));
	$std_year = xss_clean(mysql_real_escape_string($obj->{'std_year'}));
	$new_school_id = xss_clean(mysql_real_escape_string($obj->{'new_school_id'}));
	$User_age = xss_clean(mysql_real_escape_string($obj->{'User_age'}));
	$User_gender = xss_clean(mysql_real_escape_string($obj->{'User_gender'}));
	$User_id = xss_clean(mysql_real_escape_string($obj->{'User_id'}));
	$User_username = xss_clean(mysql_real_escape_string($obj->{'User_username'}));
	$User_password = xss_clean(mysql_real_escape_string($obj->{'User_password'}));
	$User_schoolname = xss_clean(mysql_real_escape_string($obj->{'User_schoolname'}));
	$User_class = xss_clean(mysql_real_escape_string($obj->{'User_class'}));
	$User_div = xss_clean(mysql_real_escape_string($obj->{'User_div'}));
	$User_classteachername = xss_clean(mysql_real_escape_string($obj->{'User_classteachername'}));
	$User_date = xss_clean(mysql_real_escape_string($obj->{'User_date'}));
	$User_hobbies = xss_clean(mysql_real_escape_string($obj->{'User_hobbies'}));
	$User_address = xss_clean(mysql_real_escape_string($obj->{'User_address'}));
	$User_city = xss_clean(mysql_real_escape_string($obj->{'User_city'}));
	$state = xss_clean(mysql_real_escape_string($obj->{'state'}));
	$User_country = xss_clean(mysql_real_escape_string($obj->{'User_country'}));
	$country_code = xss_clean(mysql_real_escape_string($obj->{'country_code'}));
	$User_department = xss_clean(mysql_real_escape_string($obj->{'User_department'}));
	$User_branch = xss_clean(mysql_real_escape_string($obj->{'User_branch'}));
	$User_semester = xss_clean(mysql_real_escape_string($obj->{'User_semester'}));
	$User_dob = xss_clean(mysql_real_escape_string($obj->{'User_dob'}));
	$newUser_id = xss_clean(mysql_real_escape_string($obj->{'newUser_id'}));
	$User_Image = xss_clean(mysql_real_escape_string($obj->{'User_Image'}));
	$imageDataEncoded = xss_clean(mysql_real_escape_string($obj->{'User_imagebase64'}));
	$student_name = $User_FName." ".$User_fathername." ".$User_LName;
	$std_complete_father_name= $User_fathername." ".$User_LName;
	 $date=date("Y-m-d");

	 $row=mysql_query("select Dept_code,ExtDeptId from tbl_department_master where Dept_Name='$User_department' and School_ID='$school_id'");
        $arr = mysql_fetch_array($row);
         $DeptCode= $arr['Dept_code'];
         $ExtDeptId= $arr['ExtDeptId'];
       $row1=mysql_query("select ExtSemesterId from tbl_semester_master where Semester_Name='$User_semester'");

        $arr1 = mysql_fetch_array($row1);
         $ExtSemesterId= $arr1['ExtSemesterId'];
         
         
	if($school_id == 'OPEN' || $school_id == 'open')
	{
		$validateSchool=mysql_query("SELECT school_id FROM tbl_school_admin where school_id='$new_school_id'");
		$validateSchool1=mysql_fetch_assoc($validateSchool);
		$SchoolID=$validateSchool1['school_id'];
		
		if($new_school_id==$SchoolID)
		{
			$test=mysql_query("UPDATE tbl_student SET school_id='$new_school_id'  where id='$User_Meid'");
		}
		
		else{
		
			$postvalue['responseStatus']=204;
			$postvalue['responseMessage']="Please enter valid School ID";
			echo json_encode($postvalue);
			exit;
		}
	
	}
	
	 
  if($imageDataEncoded !='')	{
  
	
			   $data=$obj->{'User_imagebase64'};
			 $img = $User_Image->{'User_Image'};
			 $ex_img = explode(".",$img);
			 $img_name = "mid_".$User_Meid."_".date('mdYHi').".jpg";
			 $filenm=$_SERVER['DOCUMENT_ROOT'].'/core/student_image/'.$img_name;

			 $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $data));
			 file_put_contents($filenm, $data);

			 $test = mysql_query("update tbl_student set std_img_path = 'student_image/$img_name' where id = '$User_Meid'");
  }
	
	
	
  if($User_age=='')
	  {
		  $User_age='0';
	  }
	  else
	  {
		  $User_age;
	  }
	
	if($User_date=='')
	  {
		  $User_date=$date;
	  }
	  else
	  {
		  $User_date;
	  }
	if( $User_Meid != "")
		{
			//echo "hiiii";exit;	

	$sql=mysql_query("update tbl_student set std_complete_name = '$student_name', std_name ='$User_FName',std_lastname ='$User_LName' ,std_Father_name = '$User_fathername',std_complete_father_name='$User_fathername', std_dob = '$User_dob', std_age = '$User_age', std_school_name ='$User_schoolname',country_code='$country_code',std_dept='$User_department',Dept_code='$DeptCode',ExtDeptId='$ExtDeptId',std_branch='$User_branch',std_semester='$User_semester',ExtSemesterId='$ExtSemesterId', std_class = '$User_class', std_address = '$User_address', std_city = '$User_city', std_country ='$User_country',std_state = '$state', std_gender = '$User_gender', std_div = '$User_div', std_hobbies = '$User_hobbies', std_classteacher_name = '$User_classteachername',std_email = '$User_email',std_phone = '$User_Phone',std_username ='$User_username', std_password = '$User_password', std_date = '$User_date',std_PRN = '$newUser_id',std_year='$std_year' where id ='$User_Meid'");


$result=mysql_fetch_array($sql);

$res=mysql_num_rows($result);

				
				$postvalue['responseStatus']=200;
				$postvalue['responseMessage']="Updated successfully";
				$postvalue['posts']=$posts;
  			}
		
		else
			{
			 $postvalue['responseStatus']=1000;
				$postvalue['responseMessage']="Invalid Input";
				$postvalue['posts']=null;
			  
			  header('Content-type: application/json');
   			  echo  json_encode($postvalue); 
			}	
  					
			  header('Content-type: application/json');
   			  echo  json_encode($postvalue); 
  @mysql_close($link);	
		
  ?>