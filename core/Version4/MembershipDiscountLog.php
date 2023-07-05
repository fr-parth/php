<?php
/*Author: Pranali Dalvi
Date : 12-2-19
This web service was created to display Membership Discount Logs on Sponsor app
*/
include '../conn.php';
header('Content-type: application/json');
$json = file_get_contents('php://input');
$obj = json_decode($json);

$MemberID = xss_clean(mysql_real_escape_string($obj->{'MemberID'}));
$EnityType = xss_clean(mysql_real_escape_string($obj->{'EnityType'}));
$offset = xss_clean(mysql_real_escape_string($obj->{'offset'}));

//offset function call from core/securityfunctions.php
 $offset=offset($offset);//default offset = "0"
 
//if entity is Sponsor and its member id is not null 
if($MemberID!='' && $EnityType=='Sponsor')
{
	//$limit and $offset from core/securityfunctions.php
	$sql = mysql_query("SELECT md.SponsorID,md.MemberID,md.Entity_type,md.Entity_name,md.product,md.discount,md.date,md.school_name,sp.sp_name,sp.sp_company 
	                    FROM tbl_membership_discount md 
						JOIN tbl_sponsorer sp ON md.SponsorID=sp.id
						WHERE md.SponsorID='$MemberID' order by md.id desc limit $limit offset $offset");
		
		/* create one master array of the records */
  			$posts = array();
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
					
  		else if($count > 0) 
		{
			while($data=mysql_fetch_assoc($sql))
			{
				
				if($data['Entity_type']=='105') //student image
				{
					$MemberID=$data['MemberID'];
					
					$studImage = mysql_query("SELECT std_PRN,std_complete_name,std_school_name,school_id,std_img_path FROM tbl_student WHERE id='$MemberID'");
					
					$studImage1=mysql_fetch_assoc($studImage);
					
					$simage=$studImage1['std_img_path'];
					$data['name']=$studImage1['std_complete_name'];
					$data['school_name']=$studImage1['std_school_name'];
					if($simage=='')
					{
						$data['user_image']=$GLOBALS['URLNAME']."/Assets/images/avatar/avatar_2x.png";
					}else{					
						$data['user_image']=$GLOBALS['URLNAME']."/core/".$simage;
					}
					$data['school_id']=$studImage1['school_id'];
					$data['prn_tid']=$studImage1['std_PRN'];
					
	//update query to update details in tbl_membership_discount
					mysql_query("UPDATE tbl_membership_discount set prn_tid='".$studImage1['std_PRN']."', name='".$studImage1['std_complete_name']."', school_name='".$studImage1['std_school_name']."', school_id='".$studImage1['school_id']."' WHERE MemberID='$MemberID'");
							
				}
				else if($data['Entity_type']=='103') //teacher image
				{
					$MemberID=$data['MemberID'];
					
					$teacherImage = mysql_query("SELECT t_complete_name,t_current_school_name,school_id,t_pc,t_id FROM tbl_teacher WHERE id='$MemberID'");
					
					$teacherImage1=mysql_fetch_assoc($teacherImage);
					
					$timage=$teacherImage1['t_pc'];
					
					if($timage=='')
					{
						$data['user_image']=$GLOBALS['URLNAME']."/Assets/images/avatar/avatar_2x.png";
					}else{					
						$data['user_image']=$GLOBALS['URLNAME']."/teacher_images/".$timage;
					}
										
					$data['name']=$teacherImage1['t_complete_name'];
					$data['school_name']=$teacherImage1['t_current_school_name'];
					$data['school_id']=$teacherImage1['school_id'];
					$data['prn_tid']=$teacherImage1['t_id'];
					
		//update query to update details in tbl_membership_discount	
					mysql_query("UPDATE tbl_membership_discount set prn_tid='".$teacherImage1['t_id']."', name='".$teacherImage1['t_complete_name']."', school_name='".$teacherImage1['t_current_school_name']."', school_id='".$teacherImage1['school_id']."' WHERE MemberID='$MemberID'");
				}
				else if($data['Entity_type']=='106') //parent image
				{
					$MemberID=$data['MemberID'];
									
					$parentImage = mysql_query("SELECT p_img_path,std_PRN,Name,school_id FROM tbl_parent WHERE Id='$MemberID'");
					
					$parentImage1=mysql_fetch_assoc($parentImage);
					
					$pimage=$parentImage1['p_img_path'];
					if($pimage=='')
					{
						$data['user_image']=$GLOBALS['URLNAME']."/Assets/images/avatar/avatar_2x.png";
					}else{					
						$data['user_image']=$GLOBALS['URLNAME']."/core/".$pimage;
					}
					
					$data['name']=$parentImage1['Name'];
					$data['school_id']=$parentImage1['school_id'];
					$data['prn_tid']=$parentImage1['std_PRN'];
					//update query to update details in tbl_membership_discount	
					mysql_query("UPDATE tbl_membership_discount set prn_tid='".$parentImage1['std_PRN']."', name='".$parentImage1['Name']."', school_name='".$data['school_name']."', school_id='".$parentImage1['school_id']."' WHERE MemberID='$MemberID'");
					
				}
				$posts[] = array_map(clean_string,$data);
				$postvalue['responseStatus']=200;
				$postvalue['responseMessage']="OK";
				$postvalue['posts']=$posts;
			}
					
		}
		
}
else
{
		$postvalue['responseStatus']=1000;
		$postvalue['responseMessage']="Invalid Input";
		$postvalue['posts']=null;
}
header('Content-type: application/json');
echo json_encode($postvalue);

  
?>