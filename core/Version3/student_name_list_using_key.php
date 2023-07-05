<?php  
//$json=$_GET ['json'];
$json = file_get_contents('php://input');
$obj = json_decode($json);

 $format = 'json'; //xml is the default
$key = $obj->{'name_key'};
$sc_id = $obj->{'school_id'};
if($sc_id!='')
{

	   include 'conn.php';

   
		
	$arr1=mysql_query("SELECT id,std_PRN,std_name,std_Father_name,std_lastname,std_complete_name FROM tbl_student WHERE `std_name` LIKE  '$key%' and school_id='$sc_id' ");
  
  	
  			$posts = array();
  			if(mysql_num_rows($arr1)>=1) {
					while($post = mysql_fetch_assoc($arr1)) {
						$std_complete_name=$post['std_complete_name'];
						if($std_complete_name=="")
						{
							$std_complete_name=$post['std_name']." ".$post['std_Father_name']." ".$post['std_lastname'];
						}
      				$posts[] = array('std_PRN'=>$post['std_PRN'],'std_complete_name'=>$std_complete_name);
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
  
 }else
{
  $postvalue['responseStatus']=1000;
				$postvalue['responseMessage']="Invalid Input";
				$postvalue['posts']=null;
			  
			  header('Content-type: application/json');
   			  echo  json_encode($postvalue);   
}	
	@mysql_close($link);	
		
  ?>
