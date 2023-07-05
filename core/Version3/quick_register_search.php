<?php
include '../conn.php';
error_reporting(0);
$json = file_get_contents('php://input');
header('Content-type: application/json');
$obj = json_decode($json);

  
  $school_id=xss_clean(mysql_real_escape_string($obj->{'school_id'}));

 
if($school_id !="")
{
  $sql = "SELECT  school_id,school_name from tbl_school_admin where school_id='$school_id'";
$arr=mysql_query($sql);
 $count=mysql_num_rows($sql);
  
  			if(mysql_num_rows($arr)>=1) {
    			while($post = mysql_fetch_assoc($arr)) {
							
			$school_id=$post['school_id'];
			$school_name=$post['school_name'];
			$posts[] = array(
					 'school_id'=>$school_id,
					 'school_name'=>$school_name
					);
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
}
else
			{
			 $postvalue['responseStatus']=1000;
				$postvalue['responseMessage']="Invalid Input";
				$postvalue['posts']=null;
			  
			  header('Content-type: application/json');
   			  echo  json_encode($postvalue); 
			}	
					
			  header('Content-type: application/json');
   			  echo  json_encode($postvalue); 
  @mysql_close($link);	
	

?>