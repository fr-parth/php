<?php  

$json = file_get_contents('php://input');
$obj = json_decode($json);

 $format = 'json'; //xml is the default

include 'conn.php';

$salesperson_id = $obj->{'salesperson_id'};
$date = $obj->{'date'};

if($salesperson_id!='')
{
	if($date=='')
	{
		$date = date("Y-m-d");
	}
	
	$query = mysql_query("select id,sp_name,sp_address,sp_email,sp_phone,sp_date,sp_company,v_category,payment_method,amount,sales_p_lon,sales_p_lat from tbl_sponsorer where sales_person_id='$salesperson_id' and sp_date like '$date%'");
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
			
}
else
{
				$postvalue['responseStatus']=1000;
				$postvalue['responseMessage']="Invalid inputs";
				$postvalue['posts']=null;
				header('Content-type: application/json');
				echo  json_encode($postvalue);
	
}
  /* disconnect from the db */
  @mysql_close($link);	
	
		
  ?>
