<?php  
//$json=$_GET ['json'];
$json = file_get_contents('php://input');
$obj = json_decode($json);

 $format = 'json'; //xml is the default
$std_PRN = $obj->{'std_prn'};
$sc_id = $obj->{'school_id'};
if($sc_id!='' && $std_PRN!='')
{

	   include 'conn.php';

  
			$arr1=mysql_query("SELECT * FROM tbl_student WHERE `std_PRN`='$std_PRN' and school_id='$sc_id'");
  
  	
  			$posts = array();
  			if(mysql_num_rows($arr1)>=1) {
				
				$arr2=mysql_query("SELECT sc_total_point FROM tbl_student_reward WHERE `sc_stud_id`='$std_PRN'");
				$result=mysql_fetch_array($arr2);
			
					while($post = mysql_fetch_assoc($arr1)) {
						if(isset($post['sc_total_point']))
					{
						$post['sc_total_point'];
					}
					else
					{
						$post['sc_total_point']=0;
					}
      				$posts[] = array('sc_total_point'=>$post['sc_total_point']);
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
