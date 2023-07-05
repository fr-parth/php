<?php  
//$json=$_GET ['json'];
$json = file_get_contents('php://input');
$obj = json_decode($json);
include '../conn.php';
 $format = 'json'; //xml is the default
$std_PRN = xss_clean(mysql_real_escape_string($obj->{'std_prn'}));
$sc_id = xss_clean(mysql_real_escape_string($obj->{'school_id'}));
if($sc_id!='' && $std_PRN!='')
{

	   

  
			$arr1=mysql_query("SELECT * FROM tbl_student s
			LEFT JOIN tbl_student_reward r on r.`sc_stud_id`=s.std_PRN and r.school_id=s.school_id WHERE s.`std_PRN`='$std_PRN' and s.school_id='$sc_id'");  
  	
  			
  			if(mysql_num_rows($arr1)>=1) {		
				$posts = array();
				while($post = mysql_fetch_assoc($arr1)) {
					$std_img_path=$post['std_img_path'];
					if($std_img_path=="")
					{	
					  $post['std_img_path']=$GLOBALS['URLNAME']."/Assets/images/avatar/avatar_2x.png";
					}
					else{
						$post['std_img_path']=$GLOBALS['URLNAME']."/core/".$std_img_path;
					}
					$posts[] = $post;
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
			
 
  /* disconnect from the db */
  @mysql_close($link);	
 }else
{
 $postvalue['responseStatus']=1000;
				$postvalue['responseMessage']="Invalid Input";
				$postvalue['posts']=null;
			  
			  header('Content-type: application/json');
   			  echo  json_encode($postvalue);     
}	
	
		
  ?>
