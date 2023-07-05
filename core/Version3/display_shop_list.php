<?php  
//$json=$_GET ['json'];
$json = file_get_contents('php://input');
$obj = json_decode($json);

 $format = 'json'; //xml is the default

include 'conn.php';

 ///          added CountryCode by Dhanashri Tak Intern//

//input from user
$User_Name=xss_clean(mysql_real_escape_string($obj->{'User_Name'}));
$country_code = xss_clean(mysql_real_escape_string($obj->{'sp_countrycode'}));
$site = $GLOBALS['URLNAME'];

 $country_code1=trim($country_code,"+");
 //echo $country_code;exit();	
 
   if($User_Name!="" )
	{
			//retrive info from tbl_school_subject
	$arr = mysql_query("select * from tbl_sponsorer  where sp_email like '$User_Name' or (sp_phone like '$User_Name' and CountryCode ='$country_code1')");
  
 
   
  				/* create one master array of the records */
  			$posts = array();
  			if(mysql_num_rows($arr)>=1) {
    			while($post = mysql_fetch_assoc($arr)) {
      				$post['id']=(int)$post['id'];
					$post['pin']=$post['pin'];
					$post['sales_person_id']=(int)$post['sales_person_id'];
					$post['sp_phone']=$post['sp_phone'];
					$post['sp_img_path']=$post['sp_img_path'];
					if($post['sp_img_path']=='')
 					{
						
						$post['sp_img_path']="$site/Assets/images/avatar/avatar_2x.png";
 					}
 					else
 					{
					   $post['sp_img_path'] = "$site/Assets/images/sp/profile/".$post['sp_img_path'];
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
