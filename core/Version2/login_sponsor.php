<?php  

$json = file_get_contents('php://input');
$obj = json_decode($json);
//print_r($json);
 $User_Name = $obj->{'User_Name'};
 $User_Pass = $obj->{'User_Pass'};
  $User_Id = $obj->{'User_Id'};
   /* $LatestMethod=$obj->{'method'};
	$LatestDevicetype=$obj->{'device_type'}; 
	$LatestDeviceDetails=$obj->{'device_details'};
	$LatestPlatformOS=$obj->{'platform_OS'};
	$LatestIPAddress=$obj->{'ip_address'};
	$LatestLatitude=$obj->{'lat'};
	$LatestLongitude=$obj->{'long'};
	$LatestBrowser=$obj->{'platform_OS'};
	//$LatestBrowser=$obj->{'browser'};*/

  //$number_of_posts = isset($_GET['num']) ? intval($_GET['num']) : 10; //10 is the default
 $format = 'json'; //xml is the default

include 'conn.php';

if($User_Name != "" and $User_Pass !="" and $User_Id !="")
		{

  $User_Name_id1 = str_replace("M","",$User_Name);
 // $User_Name_id = str_replace("0","",$User_Name_id1);
  $User_Name_id = ltrim($User_Name_id1, '0');


  $query = "SELECT * FROM `tbl_sponsorer` where (sp_email = '$User_Name' or  sp_phone = '$User_Name' ) and sp_password = '$User_Pass' and id = '$User_Id'";
  $result = mysql_query($query);
   
  $getdata = "SELECT * FROM `tbl_sponsorer` where (sp_email = '$User_Name' or  sp_phone = '$User_Name' ) and sp_password = '$User_Pass' and id = '$User_Id'";
   
   $result1 = mysql_query($getdata);
   
   $getDataResults=mysql_fetch_array($result1);
  /* create one master array of the records */
 $posts = array();
  if(mysql_num_rows($result)>=1) {
	  
	  $Entity_type="108";
	//$EntityID=$getDataResults['id'];
	$EntityID=$User_Id;
	$CountryCode=$getDataResults['CountryCode'];
	$LatestLoginTime=date('Y-m-d H:i:s');
	
			$arr = mysql_query("select EntityID from `tbl_LoginStatus` where EntityID='$EntityID' and Entity_type='108'");
			if (mysql_num_rows($arr) == 0)
				{
									$LoginStatus=mysql_query("INSERT INTO `tbl_LoginStatus`(`EntityID`,`Entity_type`,`FirstLoginTime`)
							     VALUES ('$EntityID','$Entity_type','$LatestLoginTime')");
									
				}
				else
				{
					
					$LoginStatus = mysql_query("update `tbl_LoginStatus` set `LatestLoginTime` = '$LatestLoginTime' where EntityID='$EntityID' and Entity_type='108'");		
	  
										
										
	  
				}
	  
	  
	  
	  
    while($post = mysql_fetch_assoc($result)) {
	
	$post['id']=(int)$post['id'];
					$post['pin']=(int)$post['pin'];
					$post['sales_person_id']=(int)$post['sales_person_id'];
					$post['sp_phone']=(int)$post['sp_phone'];
	
  $posts[] = $post;
	  
	
    }
		$postvalue['responseStatus']=200;
				$postvalue['responseMessage']="OK";

   
				$postvalue['posts']=$posts;
	
  }
  
    

  else
  {
  				$postvalue['responseStatus']=204;
				$postvalue['responseMessage']="No Response";
				$postvalue['posts']=null;
  }
  /* output in necessary format */
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