<?php  
/*Author: Sayali Balkawade
Date:14/01/2021
This is for display school id and school name for 
SMC-5105 */
$json = file_get_contents('php://input');
$obj = json_decode($json);
 include '../conn.php';

$format = 'json'; //xml is the default
$state = xss_clean(mysql_real_escape_string($obj->{'state'}));
$city = xss_clean(mysql_real_escape_string($obj->{'city'})); 
$country = xss_clean(mysql_real_escape_string($obj->{'country'})); 

	if( $state !='' && $city!='' && $country!='')
		{
			$query="SELECT trim(scadmin_state) as scadmin_state,trim(scadmin_city) as scadmin_city,trim(scadmin_country) as scadmin_country,trim(school_id) as school_id, school_name, aicte_application_id, aicte_permanent_id from tbl_school_admin where scadmin_state='".$state."' and scadmin_city='".$city."' and scadmin_country='".$country."'";
		}
	else if ($state !='' && $city=='' && $country=='')
	{
		$query="SELECT trim(scadmin_state) as scadmin_state,trim(scadmin_city) as scadmin_city,trim(scadmin_country) as scadmin_country,trim(school_id) as school_id, school_name, aicte_application_id, aicte_permanent_id from tbl_school_admin where trim(scadmin_state)='".$state."'";
	}
	else if ($state=='' && $city !='' && $country=='')
	{
		$query="SELECT trim(scadmin_state) as scadmin_state,trim(scadmin_city) as scadmin_city,trim(scadmin_country) as scadmin_country,trim(school_id) as school_id, school_name, aicte_application_id, aicte_permanent_id from tbl_school_admin where trim(scadmin_city)='".$city."'";
	}
	else if ($state=='' && $city=='' && $country!='')
	{
		$query="SELECT trim(scadmin_state) as scadmin_state,trim(scadmin_city) as scadmin_city,trim(scadmin_country) as scadmin_country,trim(school_id) as school_id, school_name, aicte_application_id, aicte_permanent_id from tbl_school_admin where trim(scadmin_country)='".$country."'";
	}
	else if( $state !='' && $city!='' && $country=='')
		{
			$query="SELECT trim(scadmin_state) as scadmin_state,trim(scadmin_city) as scadmin_city,trim(scadmin_country) as scadmin_country,trim(school_id) as school_id, school_name, aicte_application_id, aicte_permanent_id from tbl_school_admin where scadmin_state='".$state."' and scadmin_city='".$city."'";
		}
		else if( $state =='' && $city!='' && $country!='')
		{
			$query="SELECT trim(scadmin_state) as scadmin_state,trim(scadmin_city) as scadmin_city,trim(scadmin_country) as scadmin_country,trim(school_id) as school_id, school_name, aicte_application_id, aicte_permanent_id from tbl_school_admin where  scadmin_city='".$city."' and scadmin_country='".$country."'";
		}
		else if( $state !='' && $city=='' && $country!='')
		{
			$query="SELECT trim(scadmin_state) as scadmin_state,trim(scadmin_city) as scadmin_city,trim(scadmin_country) as scadmin_country,trim(school_id) as school_id, school_name, aicte_application_id, aicte_permanent_id from tbl_school_admin where scadmin_state='".$state."' and scadmin_country='".$country."'";
		}
	else
		{		
				$postvalue['responseStatus']=1000;
				$postvalue['responseMessage']="Invalid Input";
				$postvalue['posts']=null;
			  
			  header('Content-type: application/json');
                     echo json_encode($postvalue);
					 exit;
			}	
		
		
			
			$arr=mysql_query($query);
		//$qr=mysql_fetch_array($arr);
	
  			$posts = array();
  			if(mysql_num_rows($arr)>=1) {
    			while($post = mysql_fetch_assoc($arr)) {

      				$posts[] = $post;
    			}
    			//print_r($posts);
				$postvalue['responseStatus']=200;
				$postvalue['responseMessage']="OK";
				$postvalue['posts']=$posts;
				//print_r($postvalue);die;
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
