<?php  
error_reporting(0);
$json = file_get_contents('php://input');
$obj = json_decode($json);

 $Card_no = $obj->{'card_no'};
 $parent_id = $obj->{'parent_id'};
 


   $number_of_posts = isset($_GET['num']) ? intval($_GET['num']) : 10; //10 is the default
   $format = 'json'; 
  
   

    if($Card_no!="" && $parent_id!="")
	{
		include 'conn.php';
		$query="SELECT * FROM `tbl_giftcards` where card_no='$Card_no'";
		$result = mysql_query($query) or die('Errant query:  '.$query);
        $count = mysql_num_rows($result);
		$value2=mysql_fetch_array($result);
		$amount=$value2['amount'];
		$issue_date=$value2['issue_date'];
		$valid_to=$value2['valid_to'];
		$status=$value2['status'];
		$date1=date('d/m/Y');
        $today_time = strtotime($date1);
         $expire_time = strtotime($valid_to);
		/* create one master array of the records */
		$posts = array();
		if($count == 0)
		{
			    $postvalue['responseStatus']=204;
				$postvalue['responseMessage']="No Response";
				$postvalue['posts']=null;
		}
		else{
			  if($status=='Unused')
			  {
					

                if ($today_time <= $expire_time)
                {
				  $query1="SELECT balance_points FROM `tbl_parent` where Id='$parent_id'";
				  $result1 = mysql_query($query1) or die('Errant query:  '.$query);
				  $value22=mysql_fetch_array($result1);
		          $parent_bal_points=$value22['balance_points'];
				  $total_bal_points=$parent_bal_points+$amount;
				  $sql_update1="update `tbl_parent` set balance_points='$total_bal_points' where Id='$parent_id'";
				  $retval11 = mysql_query($sql_update1) or die('Could not update data: ' . mysql_error());
				  $sql_update2="update `tbl_giftcards` set status='Used' where card_no='$Card_no'";
				  $retval12 = mysql_query($sql_update2) or die('Could not update data: ' . mysql_error());
				  mysql_query("insert into tbl_giftof_waterpoint(coupon_id,points,issue_date,entities_id,user_id)
				  values('$Card_no','$amount','$date1','106','$parent_id')");
				  $postvalue['responseStatus']=200;
				  $postvalue['responseMessage']="OK";
				  $postvalue['balance']=$amount." "."points added successfully";
				}else
				{
						$postvalue['responseStatus']=204;
						$postvalue['responseMessage']="Coupon Expired";
						$postvalue['posts']=null;
					
				}
			  }else{
					  $postvalue['responseStatus']=204;
						$postvalue['responseMessage']="Coupon already purchased";
						$postvalue['posts']=null;
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
			
			    $postvalue['responseStatus']=1000;
				$postvalue['responseMessage']="Invalid Input";
				$postvalue['posts']=null;
			  
			  header('Content-type: application/json');
   			  echo  json_encode($postvalue); 
			  
			
			}
  
  
  @mysql_close($con);

?>