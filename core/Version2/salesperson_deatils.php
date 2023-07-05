<?php  

$json = file_get_contents('php://input');
$obj = json_decode($json);

 $format = 'json'; //xml is the default

include 'conn.php';


$query = mysql_query("select person_id,p_name,p_email,p_phone from tbl_salesperson");

if(mysql_num_rows($query)>0)
{
while($row = mysql_fetch_assoc($query))
{
	$posts[]=$row;
}

			$postvalue['responseStatus']=200;
			$postvalue['responseMessage']="ok";
			$postvalue['posts']=$posts;
			header('Content-type: application/json');
			echo  json_encode($postvalue); 
			
			
}
else
{
			$postvalue['responseStatus']=204;
			$postvalue['responseMessage']="no records";
			$postvalue['posts']=null;
			header('Content-type: application/json');
			echo  json_encode($postvalue); 
}	
			
 
  /* disconnect from the db */
  @mysql_close($link);	
	
		
  ?>
