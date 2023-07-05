<?php 
/*
Author Sayali Balkawade -24/10/2019  
New web service for Activity log of Student And Teacher
*/

 
$json = file_get_contents('php://input');
$obj = json_decode($json);
header('Content-type: application/json');
$format = 'json'; //xml is the default
include '../conn.php';

	
   $user_id = xss_clean(mysql_real_escape_string($obj->{'Member_ID'}));
   $school_id = xss_clean(mysql_real_escape_string($obj->{'school_id'}));
   $key = xss_clean(mysql_real_escape_string($obj->{'key'}));
   
   //$entity_type = xss_clean(mysql_real_escape_string($obj->{'Entity_Type_2'}));
   
    //$offset = xss_clean(mysql_real_escape_string($obj->{'offset'}));
  //offset function call from core/securityfunctions.php
 $offset=offset($offset);//default offset = "0"
 if($user_id!="" && $key!="") 
	{
		//SMC-4835 by Pranali : modified below queries for displaying student name and teacher name
 if($key=='STUDENT')
 {

	
			$arr=mysql_query("SELECT distinct(a.Timestamp),a.ActivityLogID,a.Entity_Type_2,a.EntityID,a.Timestamp,a.Activity,a.Entity_type,a.quantity,t.t_id,t.t_complete_name,sp.sp_company,
l.EntityID,l.Entity_type,l.FirstDeviceDetails, std.std_PRN, std.std_complete_name,t.t_id,t.t_complete_name
 FROM tbl_ActivityLog a left join tbl_LoginStatus l 
 on  a.EntityID=l.EntityID and a.school_id=l.school_id
 left join tbl_student std
  on (a.EntityID_2=std.id or a.EntityID_2=std.std_PRN) and a.school_id=std.school_id
 left join tbl_teacher t
 on (a.EntityID_2=t.t_id or a.EntityID_2=t.id) and a.school_id=t.school_id
  left join tbl_sponsorer sp on  a.EntityID_2=sp.id
  where a.EntityID='$user_id' and a.school_id='$school_id' and a.Entity_type='105'
			GROUP BY a.ActivityLogID ORDER BY a.ActivityLogID DESC");	
			
			
				$numrecord=	mysql_num_rows($arr);
				
				
							
				 if($numrecord>0)
				{	 
					while($post = mysql_fetch_assoc($arr))
					{
						$Activity=$post['Activity'];
						
						$quantity=$post['quantity'];
						$FirstDeviceDetails=$post['FirstDeviceDetails'];
						$Timestamp=$post['Timestamp'];
						$t_complete_name=$post['t_complete_name'];
						$sp_company=$post['sp_company'];
						$Entity_Type_2=$post['Entity_Type_2'];
						$std_complete_name=$post['std_complete_name'];
						
						$posts[] =array('Activity'=>$Activity ,'quantity'=>$quantity ,'Timestamp'=>$Timestamp ,'FirstDeviceDetails'=>$FirstDeviceDetails ,'t_complete_name'=>$t_complete_name,'sp_company'=>$sp_company,'Entity_Type_2'=>$Entity_Type_2,'std_complete_name'=>$std_complete_name);
					}
					$postvalue['count']=$numrecord;
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
  					
				header('Content-type: application/json');
				echo json_encode($postvalue);
  					
			}
		
			else 
			{
				
				$t_id=xss_clean(mysql_real_escape_string($obj->{'t_id'}));
				
			$arr=mysql_query("SELECT distinct(a.ActivityLogID),a.Entity_Type_2,a.EntityID,a.Timestamp,a.Activity,a.Entity_type,a.quantity,sp.sp_company,
l.EntityID,l.Entity_type,l.FirstDeviceDetails, std.id, std.std_complete_name, t.t_complete_name
 FROM tbl_ActivityLog a left join tbl_LoginStatus l 
 on  a.EntityID=l.EntityID and a.school_id=l.school_id
 left join tbl_student std
 on a.EntityID_2=std.id and a.school_id=std.school_id
 left join tbl_teacher t
  on (a.EntityID_2=t.id or a.EntityID_2=t.t_id) and a.school_id=t.school_id
 
 left join tbl_sponsorer sp on  a.EntityID_2=sp.id
  where (a.EntityID='$user_id' or a.EntityID=$t_id) and a.school_id='$school_id' and a.Entity_type='103'
			GROUP BY a.ActivityLogID DESC");	
			
			
				$numrecord=	mysql_num_rows($arr);
				
				
							
				 if($numrecord>0)
				{	 
					while($post = mysql_fetch_assoc($arr))
					{
						$Activity=$post['Activity'];
						
						$quantity=$post['quantity'];
						$FirstDeviceDetails=$post['FirstDeviceDetails'];
						$Timestamp=$post['Timestamp'];
						$std_complete_name=$post['std_complete_name'];
						$sp_company=$post['sp_company'];
						$Entity_Type_2=$post['Entity_Type_2'];
						$t_complete_name=$post['t_complete_name'];
						
						$posts[] =array('Activity'=>$Activity ,'quantity'=>$quantity ,'Timestamp'=>$Timestamp ,'FirstDeviceDetails'=>$FirstDeviceDetails ,'std_complete_name'=>$std_complete_name,'sp_company'=>$sp_company,'Entity_Type_2'=>$Entity_Type_2,'t_complete_name'=>$t_complete_name);
					}
					$postvalue['count']=$numrecord;
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
  					
				header('Content-type: application/json');
				echo json_encode($postvalue);
  					
			}	
			 }	
			
			
			
 
 else
	{
				$postvalue['responseStatus']=1000;
				$postvalue['responseMessage']="Invalid Input";
				$postvalue['posts']=null;
				echo  json_encode($postvalue); 
	}
 
			
 
  /* disconnect from the db */
  @mysql_close($conn);	
	
		
  ?>