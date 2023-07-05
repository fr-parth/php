<?php 
 
include 'conn.php';
$json = file_get_contents('php://input');
$obj = json_decode($json);
$format = 'json'; //xml is the default

$std_PRN = xss_clean(mysql_real_escape_string($obj->{'std_PRN'}));
$entities_id = xss_clean(mysql_real_escape_string($obj->{'entities_id'}));

//Start SMC-3450 Pagination
$offset = xss_clean(mysql_real_escape_string($obj->{'offset'}));
//offset function call from core/securityfunctions.php
 $offset=offset($offset);//default offset = "0"	 
 
//  added extra parameter as school_id for ticket number SAND-899.
				
$school_id=xss_clean(mysql_real_escape_string($obj->{'school_id'}));

if($entities_id != '' && $std_PRN!='' && $school_id!='')
{

	if($entities_id=='105')
		{

	 $arr = mysql_query ("select s.t_name,s.t_lastname,t_complete_name,sp.sc_point,sp.sc_thanqupointlist_id,sp.point_date,s.school_id from tbl_teacher_point sp join tbl_teacher s ON s.school_id=sp.school_id where sp.sc_teacher_id=s.t_id and sc_entities_id='105' and assigner_id='$std_PRN' and sp.school_id='$school_id' order by sp.id desc  LIMIT $limit OFFSET $offset");
	 //$limit call from core/securityfunctions.php
	 }
	
	if($entities_id=='102')
	{
		
		
	/* Author VaibhavG
		* here we put code  for getting only blue poins log assigned from School Admin to the student as per the discussed with Android Developer Pooja Paramshetti for ticket number SAND-889.
		*/
		
	//commented old query by VaibhavG
		//$arr=mysql_query("select t.name,sp.sc_thanqupointlist_id,t.school_id, sp.sc_point,sp.point_date,t.school_id from tbl_teacher_point sp join tbl_school_admin t where sp.assigner_id=t.id and sp.`sc_entities_id`='102' and sp.sc_teacher_id='$std_PRN' order by sp.id desc");
	
	//insert new query by vaibhavG
		$arr=mysql_query("SELECT s.name,sp.reason, sp.`sc_point` , sp.`point_date` , s.school_id FROM  `tbl_student_point` sp JOIN  tbl_school_admin s ON s.school_id = sp.school_id WHERE sp.`sc_stud_id` ='$std_PRN' AND sp.`sc_entites_id` ='102' AND sp.`type_points`='blue_point' and sp.school_id='$school_id' order by sp.id desc LIMIT $limit OFFSET $offset");
		//$limit call from core/securityfunctions.php
	}
	
	   $posts = array();
	    $count = mysql_num_rows($arr);
					if($count==0 && $arr) 
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
				
					else if($count > 0 )
					{
						while($post = mysql_fetch_assoc($arr))
						{
	
								$sc_studentpointlist_id=$post['sc_studentpointlist_id'];
								$sc_thanqupointlist_id=$post['sc_thanqupointlist_id'];
								$school_id=$post['school_id'];
								$points=$post['sc_point'];
								$point_date=$post['point_date'];
								if($entities_id=='102')
								{
									//insert new query by vaibhavG for ticket number SAND-899.
									$sql=mysql_query("SELECT s.name,sp.reason, sp.`sc_point` , sp.`point_date` , s.school_id FROM  `tbl_student_point` sp JOIN  tbl_school_admin s ON s.school_id = sp.school_id WHERE sp.`sc_stud_id` ='$std_PRN' AND sp.`sc_entites_id` ='102' AND sp.`type_points`='blue_point' and sp.school_id='$school_id' order by sp.id desc LIMIT $limit OFFSET $offset");
									//$limit call from core/securityfunctions.php
									//End SMC-3450
								}
								else{
								$sql=mysql_query("select t_list from tbl_thanqyoupointslist where id='$sc_thanqupointlist_id' and school_id='$school_id'");
								}
								$result=mysql_fetch_array($sql);
								if($entities_id=='102')
								{
									//getting new parameter by vaibhavG instead of old one for ticket number SAND-899.
									$thanq_reason= $result['reason'];
								}else{
								$thanq_reason= $result['t_list'];
								}
								
								if($entities_id=='105')
								{
									if($post['t_complete_name']=="")
									{
								$std_name=$post['t_name']." ".$post['t_lastname'];
									}
									else
									{
										$std_name=$post['t_complete_name'];
									}
								}
								
								if($entities_id=='102')
								{
									
								$std_name=$post['name'];
				
								}
								$posts[] = array('Name'=>$std_name,'ThanQ Reason'=>$thanq_reason,'Points'=>$points, 'Point Date'=>$point_date);
	  
							$postvalue['responseStatus']=200;
							$postvalue['responseMessage']="OK";
							$postvalue['posts']=$posts;
	  
						}
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
			
			
			
 
  /* disconnect from the db */
  @mysql_close($link);	
	
		
  ?>