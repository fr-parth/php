<?php  
/*Author: Sayali Balkawade
Date:14/01/2021
This is for state city country  
SMC-5105 */
include '../connsqli.php';
$json = file_get_contents('php://input');
$obj = json_decode($json);

 $keyState = $obj->{'keyState'};
 $country1 = $obj->{'country'};
  $state1 = $obj->{'state'};

$qr=mysqli_query($conn,"select country ,country_id from tbl_country where country='$country1' and is_enabled='1' ");
$qr1=mysqli_fetch_array($qr);
 $country=$qr1['country_id'];
 
 
 $qr2=mysqli_query($conn,"select state ,state_id from tbl_state where state='$state1'");
$qr3=mysqli_fetch_array($qr2);
 $state=$qr3['state_id'];

    if($keyState == '1234' && $country !='' && $state!='')
		
	{
		
		$query="SELECT cc.state_id as city_state_id,cc.sub_district as city_sub_district ,st.state as state_name, st.state_id as state_id,c.country as country ,c.country_id as country_id,c.calling_code as calling_id 
FROM tbl_country c
 INNER JOIN tbl_state st
on c.country_id=st.country_id
INNER JOIN tbl_city cc
on cc.state_id=st.state_id where c.is_enabled='1' and st.country_id='$country' and cc.state_id='$state'
 group by cc.sub_district ORDER BY cc.sub_district ";
		

	}
	else if($keyState == '1234' && $country =='' && $state =='')
		
	{
		
		$query="SELECT c.country as country ,c.country_id as country_id,c.calling_code as calling_id 
FROM tbl_country c where c.is_enabled='1' group by c.country ORDER BY c.country";
		

	}
	else if($country !='' && $state!='')
		
	{
		$query="SELECT cc.state_id as city_state_id,cc.sub_district as city_sub_district ,st.state as state_name, st.state_id as state_id,c.country as country ,c.country_id as country_id,c.calling_code as calling_id 
FROM tbl_country c
 INNER JOIN tbl_state st
on c.country_id=st.country_id
INNER JOIN tbl_city cc
on cc.state_id=st.state_id where c.is_enabled='1' and st.country_id='$country' and cc.state_id='$state'
 group by cc.sub_district ORDER BY cc.sub_district ";
		

	}
	else if($country =='' && $state!='')
		
	{
		$query="SELECT cc.state_id as city_state_id,cc.sub_district as city_sub_district 
FROM tbl_city cc where cc.state_id='$state'
 group by cc.sub_district ORDER BY cc.sub_district ";
		

	}
	else if( $country !='' && $state=='')
		
	{
	$query="SELECT st.state as state_name, st.state_id as state_id
FROM tbl_state st where st.country_id='$country'
 group by st.state ORDER BY st.state ";
 
		
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
    			while($post = mysqli_fetch_assoc($arr)) {
					
      				$posts[] = $post;
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