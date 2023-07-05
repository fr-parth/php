<?php  
//$json=$_GET ['json'];
$json = file_get_contents('php://input');
$obj = json_decode($json);

 $format = 'json'; //xml is the default



include 'conn.php';




// wheen you test the webservice on local//

 



//at a time only one path select

//input from user
	
	//$t_id=$obj->{'t_id'};
	$school_id=$obj->{'school_id'};
	
	
	
	


 
	if($school_id!="" )
		{
	
	$arr=mysql_query("select distinct st.Subject_Code,st.subject,st.Semester_id,st.Course_Level_PID,Y.Year  
				 from `tbl_school_subject`st
 						inner join tbl_academic_Year Y 
						    on st.school_id=Y.school_id  
							   where st.school_id='$school_id' and Y.Enable='1' ORDER BY st.subject ASC");  
  				/* create one master array of the records */
  		
  			if(mysql_num_rows($arr)>=1) {
    			while($post = mysql_fetch_assoc($arr)) {
					
					
						$subject=$post['subject'];
						$Subject_Code=$post['Subject_Code'];
						$Semester_id=$post['Semester_id'];
						
						$Course_Level_PID=$post['Course_Level_PID'];
						$Year=$post['Year'];
						
						
						
						
      				   $posts[] =array('subject'=>$subject,'Subject_Code'=>$Subject_Code,'Semester_id'=>$Semester_id,'Course_Level_PID'=>$Course_Level_PID,'Year'=>$Year);
    			}
				
				$postvalue['responseStatus']=200;
				$postvalue['responseMessage']="OK";
				$postvalue['posts']=$posts;
  			}
  			else
  				{$postvalue['responseStatus']=204;
				$postvalue['responseMessage']="No Response";
				$postvalue['posts']=null;	
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

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
 
	