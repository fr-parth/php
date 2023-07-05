<?php  
 $json = file_get_contents('php://input');
$obj = json_decode($json);

 $format = 'json';

include 'conn.php';

 $t_id = xss_clean(mysql_real_escape_string($obj->{'t_id'}));
 $school_id = xss_clean(mysql_real_escape_string($obj->{'school_id'}));
 //pagination code sachin
$offset=xss_clean(mysql_real_escape_string($obj->{'offset'}));
$offset = offset($offset);
//end pagination code sachin
 
if($school_id != "" && $t_id != "" )
{

	$sql=mysql_query("select ucwords(t.std_name) as std_name,ucwords(t.std_lastname) as std_lastname ,ucwords(t.std_complete_name) as std_complete_name,sp.sc_thanqupointlist_id, sp.sc_point,sp.point_date,IF( sc_thanqupointlist_id != '', (select t_list from tbl_thanqyoupointslist where id=sc_thanqupointlist_id and school_id='$school_id' ),null) AS reason from tbl_teacher_point sp join tbl_student t where sp.assigner_id=t.std_PRN and sp.`sc_entities_id`='105' and sp.sc_teacher_id='$t_id'  and t.school_id='$school_id' order by sp.id desc limit $limit OFFSET $offset");


	$posts = array();
	$post['input_id']=0;

			//pagination code sachin
			$numrecord=	mysql_num_rows($sql);
			if($numrecord==0 && ($sql)) 
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
				// end pagination code sachin
			{
    			while($post = mysql_fetch_array($sql)) {
					
				$std_name=$post['std_name'];
				$std_lastname=$post['std_lastname'];
				$std_complete_name=$post['std_complete_name'];
				$points=$post['sc_point'];
				$point_date=$post['point_date'];
				$reason=$post['reason'];
	
				$posts[] = array('std_name'=>$std_name,'std_lastname'=>$std_lastname,'std_complete_name'=>$std_complete_name,'reason'=>ucwords(strtolower($reason)),'points'=>$points,'point_date'=>$point_date);

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
			?>
 
