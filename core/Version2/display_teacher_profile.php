<?php
include 'conn.php';
error_reporting(0);
$json = file_get_contents('php://input');
header('Content-type: application/json');
$obj = json_decode($json);

  $t_id = xss_clean(mysql_real_escape_string($obj->{'t_id'}));
  $school_id=xss_clean(mysql_real_escape_string($obj->{'school_id'}));

$site=$GLOBALS['URLNAME'];
if($t_id != "" and $school_id !="" )
{
  $sql = "SELECT  id , t_id , t_complete_name,t_middlename,t_lastname,t_name, t_current_school_name, school_id, t_dept, t_subject, t_class, t_qualification, t_address, t_permanent_village, t_permanent_taluka, t_permanent_district, t_permanent_pincode, t_city, t_dob, t_gender, t_country, t_email, t_academic_year, t_password, t_pc, CountryCode, t_phone, tc_balance_point, tc_used_point, state, balance_blue_points, water_point, used_blue_points, brown_point, school_type, group_status FROM tbl_teacher where t_id='$t_id' and school_id='$school_id'";

  $query = mysql_query($sql);
	if(!$query)
	{
		$postvalue['responseStatus']=1000;
		$postvalue['responseMessage']="Query not Executed";
		$postvalue['posts']=null;
		echo  json_encode($postvalue);
	}
$count = mysql_num_rows($query);
  /* create one master array of the records */
  $posts = array();
  if($count > 0)
   {
                $post = mysql_fetch_array($query);
                      
                        $College_Code= $post["school_id"];
                         $t_row_id=$post["id"];
                         $t_complete_name=$post["t_complete_name"];
                         //$tname= (IS NULL($post["t_name"]))?' ':$post["t_name"];
						 $tname=  isset($post['t_name']) ? $post['t_name'] : '';
                         $tmname=isset($post["t_middlename"])?$post["t_middlename"]:'';
                         $tlname=isset($post["t_lastname"])?$post["t_lastname"]:'';
						 
						 if($t_complete_name=="")
						 {
							 $t_complete_name=$tname." ".$tmname." ".$tlname;
						 }
						 else
						 {
							 $t_complete_name;
						 }
						 
						 if($post['t_pc'] !=''){
							 $imagepath="$site/core/".$post['t_pc'];
						 }
						 else{
							 $imagepath="$site/Assets/images/avatar/avatar_2x.png";
						 }
						 $data=array(
						 'id' =>$post['id'],
						 't_id' =>$post['t_id'],
						 't_complete_name'=>ucwords(strtolower($t_complete_name)),
						 't_current_school_name'=>$post['school_id'],
						 'school_id'=>$post['school_id'],
						't_name'=>ucwords(strtolower($tname)),
						't_middlename'=>ucwords(strtolower($tmname)),
						't_lastname'=>ucwords(strtolower($tlname)),
						 't_dept'=>$post['t_dept'],
						 't_subject'=>isset($post['t_subject'])?$post['t_subject']:'',
						 't_class'=>isset($post['t_class'])?$post['t_class']:'',
						't_password'=>$post['t_password'],
						 't_qualification'=>$post['t_qualification'],
						 't_address'=>$post['t_address'],
						't_permanent_village'=>isset($post['t_permanent_village'])?$post['t_permanent_village']:'',
						't_permanent_taluka'=>isset($post['t_permanent_taluka'])?$post['t_permanent_taluka']:'', 
						't_permanent_district'=>isset($post['t_permanent_district'])?$post['t_permanent_district']:'',
						't_permanent_pincode'=>$post['t_permanent_pincode'],
						't_city'=>$post['t_city'], 
						't_dob'=>$post['t_dob'],
						't_gender'=>$post['t_gender'],
						't_country'=>$post['t_country'],
						't_email'=>$post['t_email'], 
						't_academic_year'=>isset($post['t_academic_year'])?$post['t_academic_year']:'',
						't_pc'=>$imagepath, 
						'CountryCode'=>$post['CountryCode'],
						't_phone'=>$post['t_phone'],
						'tc_balance_point'=>$post['tc_balance_point'],
						'tc_used_point'=>$post['tc_used_point'],
						'state'=>$post['state'],
						'balance_blue_points'=>$post['balance_blue_points'], 
						'water_point'=>$post['water_point'],
						'used_blue_points'=>$post['used_blue_points'],
						'brown_point'=>$post['brown_point'],
						'school_type'=>isset($post['school_type'])?$post['school_type']:'',
						'group_status'=>isset($post['group_status'])?$post['group_status']:''
						 );
                     
				$posts[] = $data;
	            $postvalue['responseStatus']=200;
				$postvalue['responseMessage']="OK";
				$postvalue['posts']=$posts;
   				echo  json_encode($postvalue);
                
		}
	  else if($count > 1)
	  {

					$postvalue['responseStatus']=409;
					$postvalue['responseMessage']="conflict";
					$postvalue['posts']=null;
					
   					echo  json_encode($postvalue);

	  }
  /* disconnect from the db */

  	}
	else
			{
				$postvalue['responseStatus']=1000;
				$postvalue['responseMessage']="Invalid Input";
				$postvalue['posts']=null;
   				echo  json_encode($postvalue);
			}


  @mysql_close($con);

?>