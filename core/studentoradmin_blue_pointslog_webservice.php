<?php  
//$json=$_GET ['json'];
$json = file_get_contents('php://input');
$obj = json_decode($json);
 $format = 'json'; //xml is the default
//echo $json;

//Save
if($obj->{'entities_id'} != '' && $obj->{'std_PRN'}!='' )
{
include 'conn.php';
	
	 $std_PRN = $obj->{'std_PRN'};
	 $entities_id = $obj->{'entities_id'};

	if($entities_id=='105')
		{

	 $arr = mysql_query ("select s.t_name,s.t_lastname,t_complete_name,sp.sc_point,sp.sc_thanqupointlist_id,sp.point_date,s.school_id from tbl_teacher_point sp join tbl_teacher s where sp.sc_teacher_id=s.t_id and sc_entities_id='105' and assigner_id='$std_PRN' order by sp.id desc");
	 }
	
	if($entities_id=='102')
	{
	$arr=mysql_query("select t.name,sp.sc_thanqupointlist_id,t.school_id, sp.sc_point,sp.point_date,t.school_id from tbl_teacher_point sp join tbl_school_admin t where sp.assigner_id=t.id and sp.`sc_entities_id`='102' and sp.sc_teacher_id='$std_PRN' order by sp.id desc");
	
	}
	
	   $posts = array();
	   if(mysql_num_rows($arr)>=1)
	{
    while($post = mysql_fetch_assoc($arr))
		{
	
	
					$sc_thanqupointlist_id=$post['sc_thanqupointlist_id'];
					$school_id=$post['school_id'];
					$points=$post['sc_point'];
					$point_date=$post['point_date'];
					$sql=mysql_query("select t_list from tbl_thanqyoupointslist where id='$sc_thanqupointlist_id' and school_id='$school_id'");
					$result=mysql_fetch_array($sql);
					$thanq_reason= $result['t_list'];
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
