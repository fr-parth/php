<?php

include('conn.php');
$json = file_get_contents('php://input');
$obj = json_decode($json);
$posts  = array();

//Start SMC-3488 Pagination
$address=xss_clean(mysql_real_escape_string($obj->{'address'}));
$offset = xss_clean(mysql_real_escape_string($obj->{'offset'}));//for pagination
 
 //offset function call from core/securityfunctions.php
 $offset=offset($offset);//default offset = "0"
 
 
		if($address!='')
		{
			$query = mysql_query("select * from tbl_sponsorer where sp_address like '%$address%' LIMIT $limit OFFSET $offset");
			//$limit call from core/securityfunctions.php
			
					$count = mysql_num_rows($query);
					if($count==0 && $query) 
					{
						if($offset==0)
						{
							
							$postvalue['responseStatus']=204;
							$postvalue['responseMessage']="No Record found";
							$postvalue['posts']=null;
						}
						else
							{
								$postvalue['responseStatus']=224;
								$postvalue['responseMessage']="End of Records";
								$postvalue['posts']=null;
							}
						
					}
					//End SMC-3487
					else if($count > 0) 
					{
						while($row = mysql_fetch_assoc($query))
						{
							foreach($row as $k=>$v)
							{
								$row[$k]=htmlentities(preg_replace( "/\r|\n|\'/", "", $v ));
							}
						   
						 $posts[] = $row;
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
		}
		else{

		  $postvalue['responseStatus']=1000;
		  $postvalue['responseMessage']="Invalid Inputs";
		  $postvalue['posts']=null;
			
		}
header('Content-type: application/json');
echo json_encode($postvalue);

@mysql_close($con);

?>