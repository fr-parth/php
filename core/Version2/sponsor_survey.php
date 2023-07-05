<?php
include('conn.php');
$json = file_get_contents('php://input');
$obj = json_decode($json);
header('Content-type: application/json');

$salesperson_id = addslashes($obj->{'salesperson_id'});
$sponsor_id = addslashes($obj->{'sponsor_id'});

	if($salesperson_id != '' && $sponsor_id != '')
	{
		$survey_res = mysql_query("select current_market_val,discount_val,digital_market_val from tbl_sponsorer where id= '$sponsor_id' AND sales_person_id= '$salesperson_id'");
		if($survey_res)
		{
			while($row =mysql_fetch_assoc($survey_res))
			{
				$posts[] = array('current_market_val'=>"[{".ltrim(rtrim($row['current_market_val'],']'),'[')."}]",'discount_val'=>"[{".ltrim(rtrim($row['discount_val'],']'),'[')."}]",'digital_market_val'=>"[{".ltrim(rtrim($row['digital_market_val'],']'),'[')."}]"); 
			}
			$postvalue['responseStatus']  = 200;
			$postvalue['responseMessage'] = "OK";
			$postvalue['posts']           = $posts;
		}
		else
		{
			$postvalue['responseStatus']  = 204;
			$postvalue['responseMessage'] = "Record Not Found";
			$postvalue['posts']           = $posts;
		}
	}
	else 
	{
		$postvalue['responseStatus']=1000;
		$postvalue['responseMessage']="Invalid Input";
		$postvalue['posts']=null;
	}
	echo  json_encode($postvalue);
?>