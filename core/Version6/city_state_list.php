<?php  
/*Author: Sayali Balkawade
Date:14/01/2021
This is for state city country  
SMC-5105 */
include '../connsqli.php';
$json = file_get_contents('php://input');
$obj = json_decode($json);

 $keyState = $obj->{'keyState'};
 $limit= 100;
 $offset=$obj->{'offset'};
 //$offset = 10;
 
    if($keyState == '1234')
		
	{
		
		$query="SELECT cc.state_id as city_state_id,cc.sub_district as city_sub_district ,st.state as state_name, st.state_id as state_id,c.country as country ,c.country_id as country_id,c.calling_code as calling_id 
FROM tbl_country c
 INNER JOIN tbl_state st
on c.country_id=st.country_id
INNER JOIN tbl_city cc
on cc.state_id=st.state_id where c.is_enabled='1' 
 group by st.state ,cc.sub_district,c.country ORDER BY c.country limit $limit OFFSET $offset";
// echo $query;exit;

	}
	else
		{		
				$postvalue['responseStatus']=1000;
				$postvalue['responseMessage']="Invalid Input";
				$postvalue['posts']=null;
			  
			  header('Content-type: application/json');
                     echo json_encode($postvalue);
					 
			}	
		
		
			
			$arr=mysqli_query($conn,$query);
		//$qr=mysql_fetch_array($arr);
	
  			$posts = array();
  			if(mysqli_num_rows($arr)>0) {
    			while($post = mysqli_fetch_array($arr)) {
					$city_state_id = $post['city_state_id'];
					$city_sub_district = $post['city_sub_district'];
					$state_name = $post['state_name'];
					$state_id = $post['state_id'];
					$country = $post['country'];
					$country_id = $post['country_id'];
					$calling_id = $post['calling_id'];
      				$posts[] = array('city_state_id'=>$city_state_id,'city_sub_district'=>$city_sub_district,'state_name'=>$state_name,'state_id'=>$state_id,'country'=>$country,'country_id'=>$country_id,'calling_id'=>$calling_id);
    			}
    			//print_r($posts);
				$postvalue['responseStatus']=200;
				$postvalue['responseMessage']="OK";
				$postvalue['posts']=$posts;

				
  			}
  			else
			{
				
				$postvalue['responseStatus']=204;
				$postvalue['responseMessage']="No records found";
				$postvalue['posts']=null;
				 
			}
			
			header('Content-type: application/json');
			echo json_encode($postvalue); 
	  @mysql_close($con);		
	
?>