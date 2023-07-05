<?php
/*Created by Rutuja Jori on 14/08/2019*/
include '../conn.php';
error_reporting(0);
$json = file_get_contents('php://input');
header('Content-type: application/json');
$obj = json_decode($json);

  $std_PRN = xss_clean(mysql_real_escape_string($obj->{'std_PRN'}));
  $school_id=xss_clean(mysql_real_escape_string($obj->{'school_id'}));

 $site=$GLOBALS['URLNAME'].'/core/';
  $server_name = $GLOBALS['URLNAME'];
if($std_PRN != "" and $school_id !="" )
{
  $sql = "SELECT  * from tbl_student where std_PRN='$std_PRN' and school_id='$school_id'";
$arr=mysql_query($sql);
 $count=mysql_num_rows($sql);
  
  			if(mysql_num_rows($arr)>=1) {
    			while($post = mysql_fetch_assoc($arr)) {
					
						
			$id=$post['id'];
			$Stud_Member_Id=$post['id'];
			$Roll_no=$post['Roll_no'];
			$std_PRN=$post['std_PRN'];
			$std_complete_name=$post['std_complete_name'];
			$std_name=$post['std_name'];
			$std_lastname=$post['std_lastname'];
			$std_Father_name=$post['std_Father_name'];
			$std_complete_father_name=$post['std_complete_father_name'];
			$std_dob=$post['std_dob'];
			$old_std_dob=$post['old_std_dob'];
			$std_age=$post['std_age'];
			$std_school_name=$post['std_school_name'];
			$school_id=$post['school_id'];	
			$sc_staff_id=$post['sc_staff_id'];
			$std_branch=$post['std_branch'];
			$std_dept=$post['std_dept'];
			$std_year=$post['std_year'];
			$std_semester=$post['std_semester'];
			$std_class=$post['std_class'];
			$Specialization=$post['Specialization'];
			$std_address=$post['std_address'];
			$std_city=$post['std_city'];
			$std_country=$post['std_country'];
			$country_code=$post['country_code'];
			$std_gender=$post['std_gender'];
			$std_div=$post['std_div'];
			$std_hobbies=$post['std_hobbies'];
			$std_classteacher_name=$post['std_classteacher_name'];
			
			
			$std_img_path=$post['std_img_path'];
  
						if($std_img_path!="")
						 {
							 $imagepath=$site.$std_img_path;
						 }
						else
						{
							$imagepath=$server_name."/Assets/images/avatar/avatar_2x.png";
						}
			
			$std_email=$post['std_email'];
			$std_username=$post['std_username'];
			$std_password=$post['std_password'];
			$std_date=$post['std_date'];
			$old_std_date=$post['old_std_date'];
			$parent_id=$post['parent_id'];
			$latitude=$post['latitude'];
			$longitude=$post['longitude'];
			$std_phone=$post['std_phone'];
			$std_state=$post['std_state'];
			$used_blue_points=$post['used_blue_points'];
			$balance_bluestud_points=$post['balance_bluestud_points'];
			$balance_water_points=$post['balance_water_points'];
			$batch_id=$post['batch_id'];
			$error_records=$post['error_records'];
			$send_unsend_status=$post['send_unsend_status'];
			$email_status=$post['email_status'];
			$Temp_address=$post['Temp_address'];
			$permanent_address=$post['permanent_address'];
			$Permanent_village=$post['Permanent_village'];
			$Permanent_taluka=$post['Permanent_taluka'];
			$Permanent_district=$post['Permanent_district'];
			$Permanent_pincode=$post['Permanent_pincode'];
			$Email_Internal=$post['Email_Internal'];
			$Admission_year_id=$post['Admission_year_id'];
			$Academic_Year=$post['Academic_Year'];
			$Course_level=$post['Course_level'];
			$Iscoordinator=$post['Iscoordinator'];
			$Gcm_id=$post['Gcm_id'];
			$college_mnemonic=$post['college_mnemonic'];
			$ExtBranchId=$post['ExtBranchId'];
			$ExtDeptId=$post['ExtDeptId'];
			$ExtSemesterId=$post['ExtSemesterId'];
			$validity=$post['validity'];
			$status=$post['status'];
			$uploaded_by=$post['uploaded_by'];
			$upload_date=$post['upload_date'];
			$fb_id=$post['fb_id'];
			$gplus_id=$post['gplus_id'];
			$linkedin_id=$post['linkedin_id'];
			$RegistrationSource=$post['RegistrationSource'];
			$email_time_log=$post['email_time_log'];
			$sms_time_log=$post['sms_time_log'];
			$group_status=$post['group_status'];
			$sms_response=$post['sms_response'];
			$group_member_id=$post['group_member_id'];
		
	
			$posts[] = array(
			
			
						    'id'=>$id,
						'Stud_Member_Id'=>$Stud_Member_Id,
						'Roll_no'=>$Roll_no,
						'std_PRN'=>$std_PRN,
						'std_complete_name'=>$std_complete_name,
						'std_name'=>$std_name,
						'std_lastname'=>$std_lastname,
						'std_Father_name'=>$std_Father_name,
						'std_complete_father_name'=>$std_complete_father_name,
						'std_dob'=>$std_dob,
						'old_std_dob'=>$old_std_dob,
						'std_age'=>$std_age,
						'std_school_name'=>$std_school_name,
						'school_id'=>$school_id,
						'sc_staff_id'=>$sc_staff_id,
						'std_branch'=>$std_branch,
						'std_dept'=>$std_dept,
						'std_year'=>$std_year,
						'std_semester'=>$std_semester,
						'std_class'=>$std_class,
						'Specialization'=>$Specialization,
						'std_address'=>$std_address,
						'std_city'=>$std_city,
						'std_country'=>$std_country,
						'country_code'=>$country_code,
						'std_gender'=>$std_gender,
						'std_div'=>$std_div,
						'std_hobbies'=>$std_hobbies,
						'std_classteacher_name'=>$std_classteacher_name,
						'std_img_path'=>$imagepath,
						'std_email'=>$std_email,
						'std_username'=>$std_username,
						'std_password'=>$std_password,
						'std_date'=>$std_date,
						'old_std_date'=>$old_std_date,
						'parent_id'=>$parent_id,
						'latitude'=>$latitude,
						'longitude'=>$longitude,
						'std_phone'=>$std_phone,
						'std_state'=>$std_state,
						'used_blue_points'=>$used_blue_points,
						'balance_bluestud_points'=>$balance_bluestud_points,
						'balance_water_points'=>$balance_water_points,
						'batch_id'=>$batch_id,
						'error_records'=>$error_records,
						'send_unsend_status'=>$send_unsend_status,
						'email_status'=>$email_status,
						'Temp_address'=>$Temp_address,
						'permanent_address'=>$permanent_address,
						'Permanent_village'=>$Permanent_village,
						'Permanent_taluka'=>$Permanent_taluka,
						'Permanent_district'=>$Permanent_district,
						'Permanent_pincode'=>$Permanent_pincode,
						'Email_Internal'=>$Email_Internal,
						'Admission_year_id'=>$Admission_year_id,
						'Academic_Year'=>$Academic_Year,
						'Course_level'=>$Course_level,
						'Iscoordinator'=>$Iscoordinator,
						'Gcm_id'=>$Gcm_id,
						'college_mnemonic'=>$college_mnemonic,
						'ExtBranchId'=>$ExtBranchId,
						'ExtDeptId'=>$ExtDeptId,
						'ExtSemesterId'=>$ExtSemesterId,
						'validity'=>$validity,
						'status'=>$status,
						'uploaded_by'=>$uploaded_by,
						'upload_date'=>$upload_date,
						'fb_id'=>$fb_id,
						'gplus_id'=>$gplus_id,
						'linkedin_id'=>$linkedin_id,
						'RegistrationSource'=>$RegistrationSource,
						'email_time_log'=>$email_time_log,
						'sms_time_log'=>$sms_time_log,
						'group_status'=>$group_status,
						'sms_response'=>$sms_response,
						'group_member_id'=>$group_member_id
				
					);


    			}
			
				
				$postvalue['responseStatus']=200;
				$postvalue['responseMessage']="OK";
				$postvalue['posts']=$posts;
  			}
  			else
  				{$postvalue['responseStatus']=204;
				$postvalue['responseMessage']="No Response";
				$postvalue['posts']=null;	
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
			
  					
			  header('Content-type: application/json');
   			  echo  json_encode($postvalue); 
  @mysql_close($link);	
		
  ?>