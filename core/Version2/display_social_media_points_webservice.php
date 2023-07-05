<?php  
//$json=$_GET ['json'];
$json = file_get_contents('php://input');
$obj = json_decode($json);

 $format = 'json'; //xml is the default


include 'conn.php';
// Start SMC-3450 modify by Pravin 2018-09-21 2:33 PM
$server_name = $GLOBALS['URLNAME'];

//input from user
    $std_PRN=$obj->{'std_PRN'};
    $school_id=$obj->{'school_id'}; //SMC-3450 add parameter school_id for find unique student

    if($std_PRN!='' && $school_id!='')////SMC-3450
	{
	
	
		
		    //retrive info from tbl_master  for each activity
			
					$arr1=mysql_query("SELECT * FROM tbl_social_points order by id");
  
  				/* create one master array of the records */
  			$posts = array();
			
  			if(mysql_num_rows($arr1)>=1) {
    			while($test = mysql_fetch_assoc($arr1)) {
						$media_id=$test['id'];
						$media_name=$test['media_name'];
					$image=$test['media_logo'];
					
					if($image=='')
					{	//SMC-3450
						$imgpath="$server_name/Assets/images/avatar/avatar_2x.png";
					}
					else{
						//SMC-3450
						$imgpath="$server_name/core/".$image;
					}
				
					////SMC-3450
					$sql2=mysql_query("select online_flag from tbl_student_reward where sc_stud_id='$std_PRN' and school_id ='$school_id'");
					
					
$result2=mysql_fetch_assoc($sql2);


$flag1= $result2['online_flag'];
$med_name=substr($media_name, 0,2);



$pos2 = strpos($flag1,$med_name);
 if($pos2 !== false)
 {
	$status="True";
}
else{
	$status="False";

}
					$points=$test['points'];
					$media_name;
					$key=strtolower($media_name);
      				$posts[] = array('Media Id'=>$media_id,'Media Name'=>$media_name,'Image'=>$imgpath,'Points'=>$points,'Key Id'=>$key,'Status'=>$status);
				
			
						
					
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
