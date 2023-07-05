
<?php 
/*
(SMC-4229) Modifications done by Rutuja Jori on 04/12/2019 for:
-Merging Manager & Employee arrays to fetch ThanQ points log(given by both Teacher/Manager & Student/Employee) for a specific manager who is logged in.
-Reason for points assigned was displayed blank on Production environment.So, updated query for fetching the reason.
-The Teacher/Mananger who is logged in, his name was getting displayed in ThanQ points log on Dev & test environment. This issue is also resolved.
-Added designation for differentiating between Employee & Manager.
-If designation is NULL added 'Employee' & 'Manager' respectively.
*/

 
$json = file_get_contents('php://input');
$obj = json_decode($json);
header('Content-type: application/json');
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
 $entity = xss_clean(mysql_real_escape_string($obj->{'entity'}));
 $offset=xss_clean(mysql_real_escape_string($obj->{'offset'}));
 $offset = offset($offset);

				if($school_id != "" && $t_id != "" )

				{
				$arr=mysql_query("select t_designation as designation,ucwords(t.t_name) as std_name,ucwords(t.t_lastname) as std_lastname ,ucwords(t.t_complete_name) as std_complete_name,sp.sc_thanqupointlist_id, sp.sc_point,sp.point_date,IF( sc_thanqupointlist_id != '', (select t_list from tbl_thanqyoupointslist tl where tl.id=sp.sc_thanqupointlist_id and sp.school_id='$school_id' ),null) AS reason from tbl_teacher_point sp join tbl_teacher t where sp.assigner_id=t.t_id and sp.`sc_entities_id`='103' and sp.sc_teacher_id='$t_id'  and t.school_id='$school_id' order by sp.id desc limit $limit OFFSET $offset");

				$arr1=mysql_query("select emp_designation as designation,ucwords(t.std_name) as std_name,ucwords(t.std_lastname) as std_lastname ,ucwords(t.std_complete_name) as std_complete_name,sp.sc_thanqupointlist_id, sp.sc_point,sp.point_date,IF( sc_thanqupointlist_id != '', (select t_list from tbl_thanqyoupointslist where id=sc_thanqupointlist_id and school_id='$school_id' ),null) AS reason from tbl_teacher_point sp join tbl_student t where sp.assigner_id=t.std_PRN and sp.`sc_entities_id`='105' and sp.sc_teacher_id='$t_id'  and t.school_id='$school_id' order by sp.id desc limit $limit OFFSET $offset");
		
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
					while($post = mysql_fetch_assoc($arr)) {
					
				$std_name=$post['std_name'];
				$std_lastname=$post['std_lastname'];
				$std_complete_name=$post['std_complete_name'];
				$points=$post['sc_point'];
				$point_date=$post['point_date'];
				$reason=$post['reason'];
				$designation=$post['designation'];
				if($designation==""){
							$designation = "Manager";
						}	
	
				$posts[] = array('std_name'=>$std_name,'std_lastname'=>$std_lastname,'std_complete_name'=>$std_complete_name,'reason'=>ucwords(strtolower($reason)),'points'=>$points,'point_date'=>$point_date,'designation'=>$designation);

			  }
					
					if($numrecord1>0)
				{	
					while($post = mysql_fetch_assoc($arr1)) {
					
				$std_name=$post['std_name'];
				$std_lastname=$post['std_lastname'];
				$std_complete_name=$post['std_complete_name'];
				$points=$post['sc_point'];
				$point_date=$post['point_date'];
				$reason=$post['reason'];
				$designation=$post['designation'];
				if($designation==""){
							$designation = "Employee";
						}	
	
				$posts[] = array('std_name'=>$std_name,'std_lastname'=>$std_lastname,'std_complete_name'=>$std_complete_name,'reason'=>ucwords(strtolower($reason)),'points'=>$points,'point_date'=>$point_date,'designation'=>$designation);

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