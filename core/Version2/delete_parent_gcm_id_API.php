<?php  

$json = file_get_contents('php://input');
$obj = json_decode($json);

 $GCMID = $obj->{'gcm_id'};
 $PID = $obj->{'parent_id'};



  $number_of_posts = isset($_GET['num']) ? intval($_GET['num']) : 10; //10 is the default
  $format = 'json'; 
  
include 'conn.php';


   
    if(!empty($GCMID) && !empty($PID))
	{
		$query="DELETE from parent_gcmid where parent_id='$PID' and gcm_id='$GCMID'";
		$result = mysql_query($query) or die('Errant query:  '.$query);
				$postvalue['responseStatus']=204;
				$postvalue['responseMessage']="GCM ID has been deleted successfully.";
				$postvalue['posts']=null;
			    header('Content-type: application/json');
   			    echo  json_encode($postvalue); 

	
  }
	else
			{
			
			   $postvalue['responseStatus']=1000;
				$postvalue['responseMessage']="Invalid Input";
				$postvalue['posts']=null;
			  
			  header('Content-type: application/json');
   			  echo  json_encode($postvalue); 
			  
			
			}
  
  
 

?>