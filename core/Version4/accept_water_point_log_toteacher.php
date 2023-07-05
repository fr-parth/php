<?php 
/*
Author Yogesh Sonawane
New web service for green point to teacher log
*/

 
$json = file_get_contents('php://input');
$obj = json_decode($json);
header('Content-type: application/json');
$format = 'json'; //xml is the default
include '../conn.php';

  
   $t_id = xss_clean(mysql_real_escape_string($obj->{'t_id'}));
   $school_id = xss_clean(mysql_real_escape_string($obj->{'school_id'}));
    $offset = xss_clean(mysql_real_escape_string($obj->{'offset'}));
  //offset function call from core/securityfunctions.php
 $offset=offset($offset);//default offset = "0"
	if($t_id!="" && $school_id!="" )
	{
			$arr=mysql_query("Select sc_point,reason,point_date from tbl_teacher_point
				where (point_type='Waterpoint' or point_type='Water Points') and assigner_id ='$t_id' and school_id='$school_id' and sc_entities_id='103' ORDER BY id DESC LIMIT $limit OFFSET $offset");	
		
  				/* create one master array of the records */
				
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
					while($post = mysql_fetch_assoc($arr))
					{
						$sc_point=$post['sc_point'];
						$reason=$post['reason'];
						$point_date=$post['point_date'];
						$posts[] =array('sc_point'=>$sc_point,'reason'=>$reason,'point_date'=>$point_date);
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
		  
		  
  					/* output in necessary format */
  					
				header('Content-type: application/json');
				echo json_encode($postvalue);
  					
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