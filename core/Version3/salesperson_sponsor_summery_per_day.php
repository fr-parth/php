<?php  

$json = file_get_contents('php://input');
$obj = json_decode($json);

 $format = 'json'; //xml is the default

include 'conn.php';
//Start SMC-3488
$salesperson_id = xss_clean(mysql_real_escape_string($obj->{'salesperson_id'}));
//End SMC-3488
$date = $obj->{'date'};



	if($date=='')
	{
		$date = date("Y-m-d");
		 
	}
	
	if($salesperson_id!='')
	{
		$query = mysql_query("SELECT count(id) as total_sponsors,  SUM(case when payment_method = 'Free Register'  then 1 else 0 end) as free,sum(if(payment_method ='cheque', 1, 0)) AS paid_by_cheque,sum(if(payment_method = 'cash', 1, 0)) AS paid_by_cash, sum(if(calback_date_time != '', 1, 0)) AS calback_date_time,sum(amount) as total_amount,sum(if(v_responce_status='Not Interested',1,0)) AS Not_Interested, sum(if(v_responce_status='Suggested',1,0)) AS Suggested from tbl_sponsorer where sales_person_id='$salesperson_id' and sp_date like '$date%'");
	}
	else
	{
		
		$query = mysql_query("SELECT count(id) as total_sponsors,  SUM(case when payment_method = 'Free Register'  then 1 else 0 end) as free,sum(if(payment_method ='cheque', 1, 0)) AS paid_by_cheque,sum(if(payment_method = 'cash', 1, 0)) AS paid_by_cash, sum(if(calback_date_time != '', 1, 0)) AS calback_date_time,sum(amount) as total_amount, sum(if(v_responce_status='Not Interested',1,0)) AS Not_Interested, sum(if(v_responce_status='Suggested',1,0)) AS Suggested from tbl_sponsorer where sp_date like '$date%'");
	}
	
	//$query = mysql_query("select sp_name,sp_address,sp_email,sp_phone,sp_date,sp_company,v_category,payment_method,amount,sales_p_lon,sales_p_lat from tbl_sponsorer where sales_person_id='$salesperson_id' and sp_date like '$date%'");
	if(mysql_num_rows($query)>0)
	{
		$row = mysql_fetch_assoc($query);
		$posts = new stdClass();
		
		$posts->total_sponsors = $row['total_sponsors'];
		$posts->free = $row['free'];
		$posts->paid_by_cheque = $row['paid_by_cheque'];
		$posts->paid_by_cash = $row['paid_by_cash'];
		$posts->calback_date_time = $row['calback_date_time'];
		$posts->total_amount = $row['total_amount'];
		$posts->not_interested = $row['Not_Interested'];
		$posts->Suggested = $row['Suggested'];
	

				$postvalue['responseStatus']=200;
				$postvalue['responseMessage']="ok";
				$postvalue['posts']=(object)$posts;
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
