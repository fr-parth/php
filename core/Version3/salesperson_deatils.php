<?php  

$json = file_get_contents('php://input');
$obj = json_decode($json);

 $format = 'json'; //xml is the default

include 'conn.php';

//Start SMC-3488 Pagination
	$offset = xss_clean(mysql_real_escape_string($obj->{'offset'}));//for pagination
 
 //offset function call from core/securityfunctions.php
	$offset=offset($offset);//default offset = "0"
 
$query = mysql_query("select person_id,p_name,p_email,p_phone from tbl_salesperson LIMIT $limit OFFSET $offset");
//$limit call from core/securityfunctions.php
$count = mysql_num_rows($query);
					if($count==0 && $arr) 
					{
						if($offset==0)
						{
							
							$postvalue['responseStatus']=204;
							$postvalue['responseMessage']="No Record found";
							$postvalue['posts']=null;
						}else
							{
						$postvalue['responseStatus']=224;
						$postvalue['responseMessage']="End of Records";
						$postvalue['posts']=null;
							}
						
					}
					
					else if($count > 0) 
					{
							//End SMC-3488
								while($row = mysql_fetch_assoc($query))
								{
									$posts[]=$row;
								}

								$postvalue['responseStatus']=200;
								$postvalue['responseMessage']="ok";
								$postvalue['posts']=$posts;
								
			
			
					}
					else
					{
								$postvalue['responseStatus']=204;
								$postvalue['responseMessage']="No Record found";
								$postvalue['posts']=null;
								
					}	
			
header('Content-type: application/json');
echo  json_encode($postvalue); 
  /* disconnect from the db */
  @mysql_close($link);	
	
		
  ?>
