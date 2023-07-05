<?php  
//Below web service done by Rutuja Jori on 29/05/2019 for bug SMC-3880

$json = file_get_contents('php://input');
$obj = json_decode($json);

 $format = 'json'; //xml is the default

include '../conn.php';
$site=$GLOBALS['URLNAME'];
   $school_id =  xss_clean(mysql_real_escape_string($obj->{'school_id'}));
   $std_dept =  xss_clean(mysql_real_escape_string($obj->{'std_dept'}));
   $t_emp_pid =  xss_clean(mysql_real_escape_string($obj->{'t_emp_pid'}));
   //$offset=xss_clean(mysql_real_escape_string($obj->{'offset'}));

   $where="";
 
  if(($std_dept == "All" || $std_dept == ''))
 {	
	$where="";
 }
 
 if($std_dept!= "All" && $std_dept != '')
 {	
 $where.=" and t_dept='".$std_dept."' ";
 }

	if($school_id!='' && $t_emp_pid!='')
	{	
	if ($t_emp_pid=='135')
	{
	$sql="select id,t_id,t_complete_name,t_emp_type_pid,t_designation,t_dept,t_class from tbl_teacher  where school_id='$school_id' and (t_emp_type_pid='133' or t_emp_type_pid='134') $where order by id desc";
	
	
	
	
$arr = mysql_query($sql);
		$posts = array();
			
  		$numrecord=	mysql_num_rows($arr);
		
			if($numrecord==0 && ($arr)) 
					{
						
							$postvalue['responseStatus']=204;
							$postvalue['responseMessage']="No Record Found";
							$postvalue['posts']=null;
						
					}
			
			else if($numrecord>0)
			{
 			 while($post = mysql_fetch_assoc($arr)) {
					
					$id=$post['id'];
					$t_id=$post['t_id'];
					$t_complete_name=$post['t_complete_name'];
					$t_emp_pid=$post['t_emp_type_pid'];
					$t_designation=$post['t_designation'];
					$t_dept=$post['t_dept'];
					$t_class=$post['t_class'];
	
						
					$posts[] = array(
					
					'id'=>$id,
					't_id'=>$t_id,
					't_complete_name'=>$t_complete_name,
					't_emp_type_pid'=>$t_emp_pid,
					't_designation'=>$t_designation,
					't_dept'=>$t_dept,
					't_class'=>$t_class
					
					);
					
				
      				
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
 
	
		}
		
		
	else if ($t_emp_pid=='137')
	{
	$sql="select id,t_id,t_complete_name,t_emp_type_pid,t_designation,t_dept,t_class from tbl_teacher  where school_id='$school_id' and (t_emp_type_pid='133' or t_emp_type_pid='134' or t_emp_type_pid='135') $where order by id desc";
	
$arr = mysql_query($sql);
		$posts = array();
			
  		$numrecord=	mysql_num_rows($arr);
		
			if($numrecord==0 && ($arr)) 
					{
						
							$postvalue['responseStatus']=204;
							$postvalue['responseMessage']="No Record Found";
							$postvalue['posts']=null;
						
					}
			
			else if($numrecord>0)
			{
 			 while($post = mysql_fetch_assoc($arr)) {
					
					$id=$post['id'];
					$t_id=$post['t_id'];
					$t_complete_name=$post['t_complete_name'];
					$t_emp_pid=$post['t_emp_type_pid'];
					$t_designation=$post['t_designation'];
					$t_dept=$post['t_dept'];
					$t_class=$post['t_class'];
	
						
					$posts[] = array(
					
					'id'=>$id,
					't_id'=>$t_id,
					't_complete_name'=>$t_complete_name,
					't_emp_type_pid'=>$t_emp_pid,
					't_designation'=>$t_designation,
					't_dept'=>$t_dept,
					't_class'=>$t_class
					
					);
					//SMC-3669 End
				
      				
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
 
	
		}
		else if ($t_emp_pid=='139')
	{
	$sql="select id,t_id,t_complete_name,t_emp_type_pid,t_designation,t_dept,t_class from tbl_teacher  where school_id='$school_id' and (t_emp_type_pid='133' or t_emp_type_pid='134' or t_emp_type_pid='135' or t_emp_type_pid='137') $where order by id desc";
	
	
$arr = mysql_query($sql);
		$posts = array();
			
  		$numrecord=	mysql_num_rows($arr);
		
			if($numrecord==0 && ($arr)) 
					{
						
							$postvalue['responseStatus']=204;
							$postvalue['responseMessage']="No Record Found";
							$postvalue['posts']=null;
						
					}
			
			else if($numrecord>0)
			{
 			 while($post = mysql_fetch_assoc($arr)) {
					
					$id=$post['id'];
					$t_id=$post['t_id'];
					$t_complete_name=$post['t_complete_name'];
					$t_emp_pid=$post['t_emp_type_pid'];
					$t_designation=$post['t_designation'];
					$t_dept=$post['t_dept'];
					$t_class=$post['t_class'];
	
						
					$posts[] = array(
					
					'id'=>$id,
					't_id'=>$t_id,
					't_complete_name'=>$t_complete_name,
					't_emp_type_pid'=>$t_emp_pid,
					't_designation'=>$t_designation,
					't_dept'=>$t_dept,
					't_class'=>$t_class
					
					);
					//SMC-3669 End
				
      				
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
 
	
		}
		
		
		else if ($t_emp_pid=='141')
	{
	$sql="select id,t_id,t_complete_name,t_emp_type_pid,t_designation,t_dept,t_class from tbl_teacher  where school_id='$school_id' and (t_emp_type_pid='133' or t_emp_type_pid='134' or t_emp_type_pid='135' or t_emp_type_pid='137' or  t_emp_type_pid='139') $where order by id desc";
	
	
$arr = mysql_query($sql);
		$posts = array();
			
  		$numrecord=	mysql_num_rows($arr);
		
			if($numrecord==0 && ($arr)) 
					{
						
							$postvalue['responseStatus']=204;
							$postvalue['responseMessage']="No Record Found";
							$postvalue['posts']=null;
						
					}
			
			else if($numrecord>0)
			{
 			 while($post = mysql_fetch_assoc($arr)) {
					
					$id=$post['id'];
					$t_id=$post['t_id'];
					$t_complete_name=$post['t_complete_name'];
					$t_emp_pid=$post['t_emp_type_pid'];
					$t_designation=$post['t_designation'];
					$t_dept=$post['t_dept'];
					$t_class=$post['t_class'];
	
						
					$posts[] = array(
					
					'id'=>$id,
					't_id'=>$t_id,
					't_complete_name'=>$t_complete_name,
					't_emp_type_pid'=>$t_emp_pid,
					't_designation'=>$t_designation,
					't_dept'=>$t_dept,
					't_class'=>$t_class
					
					);
					
				
      				
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
 
	
		}
		
		
		else if ($t_emp_pid=='143')
	{
	$sql="select id,t_id,t_complete_name,t_emp_type_pid,t_designation,t_dept,t_class from tbl_teacher  where school_id='$school_id' and (t_emp_type_pid='133' or t_emp_type_pid='134' or t_emp_type_pid='135' or t_emp_type_pid='137' or t_emp_type_pid='139' or t_emp_type_pid='141') $where order by id desc";
	
	
	
$arr = mysql_query($sql);
		$posts = array();
			
  		$numrecord=	mysql_num_rows($arr);
		
			if($numrecord==0 && ($arr)) 
					{
						
							$postvalue['responseStatus']=204;
							$postvalue['responseMessage']="No Record Found";
							$postvalue['posts']=null;
						
					}
			
			else if($numrecord>0)
			{
 			 while($post = mysql_fetch_assoc($arr)) {
					
					$id=$post['id'];
					$t_id=$post['t_id'];
					$t_complete_name=$post['t_complete_name'];
					$t_emp_pid=$post['t_emp_type_pid'];
					$t_designation=$post['t_designation'];
					$t_dept=$post['t_dept'];
					$t_class=$post['t_class'];
	
						
					$posts[] = array(
					
					'id'=>$id,
					't_id'=>$t_id,
					't_complete_name'=>$t_complete_name,
					't_emp_type_pid'=>$t_emp_pid,
					't_designation'=>$t_designation,
					't_dept'=>$t_dept,
					't_class'=>$t_class
					
				);
      				
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
 
	
		}
		

		else
		{
			$postvalue['responseStatus']=1000;
				$postvalue['responseMessage']="Invalid Input";
				$postvalue['posts']=null;
			  
			  header('Content-type: application/json');
   			  echo  json_encode($postvalue);  
			  @mysql_close($link);
			  exit;
		}

}		
	else
	{
		$postvalue['responseStatus']=1000;
		$postvalue['responseMessage']="Invalid Input";
		$postvalue['posts']=null;
	  
	  header('Content-type: application/json');
   			  echo  json_encode($postvalue);  
			  @mysql_close($link);
			  exit;
	}	
						/* output in necessary format */
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
		
  /* disconnect from the db */
  @mysql_close($link);	
	
		
  ?>
