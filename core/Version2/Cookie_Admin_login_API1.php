<?php

$json = file_get_contents('php://input');
$obj = json_decode($json);

	$User_Name = $obj->{'Admin_Name'};
	$User_Pass = $obj->{'Admin_Pass'};



  $format = 'json';
  
include 'conn.php';


   
 
 
    if($User_Name!="" && $User_Pass!="" )
	{
		$query="SELECT * FROM `tbl_cookieadmin` where admin_email='$User_Name' and admin_password = '$User_Pass'";
         	$result = mysql_query($query,$con) or die('Errant query:  '.$query);
             $school=mysql_query("SELECT *  FROM tbl_school_admin where school_id!=''");
             $Teacher=mysql_query("SELECT * FROM tbl_teacher where school_id!=''");
             $Sponsors=mysql_query("select * from tbl_sponsorer");
             $Parents=mysql_query("select * from tbl_parent");
             $Students=mysql_query("SELECT *  FROM tbl_student where school_id!=''");
             $Staffs=mysql_query("select * from tbl_cookie_adminstaff");


		/* create one master array of the records */
		$posts = array();
		$posts1 = array();
		if(mysql_num_rows($result)>=1)
		{
			while($post = mysql_fetch_assoc($result))
			{
			  $cookie_id= $post["id"];
              $email=$post["admin_email"];
              $pswd=$post["admin_password"];
			 	$posts[]= array(
            					   //	'post'=>array(
                                    'id'=>$cookie_id,
                                    'admin_email'=>$email,
                                    'admin_password'=>$pswd
                                    

            					);
			
			}
                           $posts1[]= array( 'Schools'=>mysql_num_rows($school),
            						'Teachers'=>mysql_num_rows($Teacher),
            						'Sponsors'=>mysql_num_rows($Sponsors),
            						'Parents'=>mysql_num_rows($Parents),
            						'Students'=>mysql_num_rows($Students),
            					   	'Staffs'=>mysql_num_rows($Staffs));



                                	$postvalue['responseStatus']=200;
                        			$postvalue['responseMessage']="OK";
                        			$postvalue['posts']=$posts;
                                    $postvalue['post1']=$posts1;

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
  
  		}
	else
			{
			
			   $postvalue['responseStatus']=1000;
				$postvalue['responseMessage']="Invalid Input";
				$postvalue['posts']=null;
			  
			  header('Content-type: application/json');
   			  echo  json_encode($postvalue); 
			  
			
			}
  
  
  @mysql_close($con);

?>