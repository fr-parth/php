<?php   
$json = file_get_contents('php://input');
$obj = json_decode($json);

  include '../conn.php';
	$User_Type = xss_clean(mysql_real_escape_string($obj->{'User_Type'}));
	$User_Name = xss_clean(mysql_real_escape_string($obj->{'Admin_Name'}));
	$User_Pass = xss_clean(mysql_real_escape_string($obj->{'Admin_Pass'}));
	$school_id = xss_clean(mysql_real_escape_string($obj->{'school_id'}));
	$condition = "";
	if(preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/",trim($User_Name)))
	{
		 $condition = "email='".$User_Name."'";
			
	}

	else //(preg_match('/^[789]\d{9}$/',$User_Name))
	{
		$condition = "mobile='".$User_Name."'";
		
	}
  $number_of_posts = isset($_GET['num']) ? intval($_GET['num']) : 10; //10 is the default
 
  $format = 'json';  

    if($User_Name!="" && $User_Pass!="" && $school_id!="" && (strtolower($User_Type)=="email" || strtolower($User_Type)=="mobile"))
	{
		
		 $query="SELECT * FROM `tbl_school_admin` where $condition and school_id='$school_id' and password = '$User_Pass'";
 		$result = mysql_query($query,$con) or die('Errant query:  '.$query);
 		/* create one master array of the records */
		$posts = array();	
		if(mysql_num_rows($result)>=1) 
		{
			while($post = mysql_fetch_assoc($result))
			{
			$post['tnc_link'] = $GLOBALS['URLNAME']."/core/tnc.php";
			$posts[] = $post;			
			}
			
			$condition1=strpos($condition, '@');
				if(strtolower($User_Type)=="email" && $User_Name!="mobile" && $condition1!="")
				{
					$postvalue['responseStatus']=200;
					$postvalue['responseMessage']="OK";
					$postvalue['posts']=$posts;
				}
				else if(strtolower($User_Type)=="mobile" && $User_Name!="email" && $condition1=="")
				{
					$postvalue['responseStatus']=200;
					$postvalue['responseMessage']="OK1";
					$postvalue['posts']=$posts;
				}

				else
				{
					$postvalue['responseStatus']=209;
					$postvalue['responseMessage']="Wrong User Type";
					//$postvalue['posts']=$posts;
				}
			
			//}
		}
	 if(($school_id=='' or $school_id!='') and $User_Name!='' and $User_Pass !='' )
                            {		
                            	if ($school_id =='') {
                            		$postvalue['responseStatus']=204;
									$postvalue['responseMessage']="Wrong School ID";
                            	}else{
		                            	$querycheck=mysql_query("select school_id from tbl_school_admin where school_id='$school_id' AND password='$User_Pass'");
		                                $qrCount=mysql_num_rows($querycheck);
		                                if($qrCount <= 0)
		                                {
		                                $postvalue['responseStatus']=204;
										$postvalue['responseMessage']="School Id Not match";
										//$postvalue['posts']=null;
		                                }
                            		}
                               
                            }
    if(($User_Name =='' or $User_Name !='') and $school_id!='' and $User_Pass !='' )
                        {		
                            	if ($User_Name =='')
                            	 {
                            		$postvalue['responseStatus']=204;
									$postvalue['responseMessage']="Wrong email ID";
                            	}
                            	else
                            	{
                            	
                            		$querycheck=mysql_query("select email from tbl_school_admin where $condition and  password='$User_Pass'");
		                                $qrCount=mysql_num_rows($querycheck);
		                                
		                               if($qrCount <= 0)
		                                {
		                                	if(strtolower($User_Type)=='email')
		                                	{
		                                $postvalue['responseStatus']=206;
										$postvalue['responseMessage']="Email Id Not match";
										//$postvalue['posts']=null;
									      }
									      else  
									      {
                            		
		                            	$postvalue['responseStatus']=206;
										$postvalue['responseMessage']="Mobile No. Not match";
										//$postvalue['posts']=null;
		                                
		                           			 }
		                                }
		                                
                            	}
		                       
		                              
                            }

                            
     if(($User_Pass =='' or $User_Pass !='')  and $User_Name!='' and $school_id !='' )
                            {		
                            	if ($User_Pass =='') {
                            		$postvalue['responseStatus']=208;
									$postvalue['responseMessage']="Wrong Password";
                            	}else{
		                            	$querycheck=mysql_query("select password from tbl_school_admin where password='$User_Pass'");
		                                $qrCount=mysql_num_rows($querycheck);
		                                if($qrCount <= 0)
		                                {
		                                $postvalue['responseStatus']=208;
										$postvalue['responseMessage']="Password Not match";
										//$postvalue['posts']=null;
		                               }
		                              } 
                               
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
  
  		}
	else
			{
                            	
			
			   $postvalue['responseStatus']=207;
				$postvalue['responseMessage']="Wrong Credentials";
				$postvalue['posts']="";
			  
			  header('Content-type: application/json');
   			  echo  json_encode($postvalue); 
			  
			
			}
  
  
  @mysql_close($con);

?>