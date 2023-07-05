<?php 
/*
Author Yogesh Sonawane
New web service for green point to teacher log
Updated by Rutuja Jori for adding 'assigner_id' field for fetching water point log  and also fetched designation for both Employee & Manager on 05/12/2019
*/

 
$json = file_get_contents('php://input');
$obj = json_decode($json);
header('Content-type: application/json; charset=utf-8');
$format = 'json'; //xml is the default
include '../conn.php';


function msort($array, $key, $sort_flags = SORT_REGULAR) {
    if (is_array($array) && count($array) > 0) {
        if (!empty($key)) {
            $mapping = array();
            foreach ($array as $k => $v) {
                $sort_key = '';
                if (!is_array($key)) {
                    $sort_key = $v[$key];
                } else {
                    // @TODO This should be fixed, now it will be sorted as string
                    foreach ($key as $key_key) {
                        $sort_key .= $v[$key_key];
                    }
                    $sort_flags = SORT_STRING;
                }
                $mapping[$k] = $sort_key;
            }
            arsort($mapping, $sort_flags);
            $sorted = array();
            foreach ($mapping as $k => $v) {
                $sorted[] = $array[$k];
            }
            return $sorted;
        }
    }
    return $array;
}


   $t_id = xss_clean(mysql_real_escape_string($obj->{'t_id'}));
   $school_id = xss_clean(mysql_real_escape_string($obj->{'school_id'}));
    $offset = xss_clean(mysql_real_escape_string($obj->{'offset'}));
  //offset function call from core/securityfunctions.php
 $offset=offset($offset);//default offset = "0"
	if($t_id!="" && $school_id!="" )
	{

		//sc_teacher_id added by Rutuja Jori on 14/12/2019 for SMC-4229 for fetching both Manager & Employee records
			$arr=mysql_query("Select sp.sc_point,sp.reason,sp.point_date,ts.t_name as std_name,ts.t_lastname as std_lastname,ts.t_complete_name as std_complete_name from tbl_teacher_point sp LEFT JOIN tbl_teacher ts ON sp.sc_teacher_id=ts.t_id AND sp.school_id=ts.school_id
				where (sp.point_type='Waterpoint' or sp.point_type='Water Points') and sp.assigner_id ='$t_id' and sp.school_id='$school_id' and sp.sc_entities_id='103' ORDER BY sp.id DESC LIMIT $limit OFFSET $offset");




				$arr1=mysql_query("Select sp.sc_point,sp.reason,sp.point_date,ts.std_name,ts.std_lastname,ts.std_complete_name from tbl_student_point sp LEFT JOIN tbl_student ts ON sp.sc_stud_id= ts.std_PRN AND sp.school_id=ts.school_id
				where (sp.type_points='Waterpoint' or sp.type_points='Water Points') and sp.sc_teacher_id ='$t_id' and sp.school_id='$school_id' and sp.sc_entites_id='103' ORDER BY sp.id DESC LIMIT $limit OFFSET $offset");


		
  				/* create one master array of the records */
				
				$numrecord=	mysql_num_rows($arr);
				$numrecord1=	mysql_num_rows($arr1);
				if($numrecord==0 && $numrecord1==0) 
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
						$t_name = $post['std_complete_name'];
						$designation = $post['designation'];
						if($t_name==""){
							$t_name = $post['std_name'].' '.$post['std_lastname'];
						}	
						if($designation==""){
							$designation = "Manager";
						}						
						$posts[] =array('sc_point'=>$sc_point,'reason'=>$reason,'point_date'=>$point_date,'name'=>$t_name,'designation'=>$designation);
					}
					
					if($numrecord1>0)
				{	
					while($post1 = mysql_fetch_assoc($arr1))
					{
						$sc_point=$post1['sc_point'];
						$reason=$post1['reason'];
						$point_date=$post1['point_date'];
						$std_name = $post1['std_complete_name'];
						$designation = $post['designation'];
							
						if($designation==""){
							$designation = "Employee";
						}	
						if($std_name==""){
							$std_name = $post1['std_name'].' '.$post1['std_lastname'];
						}						
						$posts[] =array('sc_point'=>$sc_point,'reason'=>$reason,'point_date'=>$point_date,'name'=>$std_name,'designation'=>$designation);
					}
				
				}
				$arrsort=msort($posts,array('point_date'));
					$postvalue['responseStatus']=200;
					$postvalue['responseMessage']="OK";
					$postvalue['posts']=$arrsort;
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