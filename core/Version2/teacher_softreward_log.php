<?php
 $json = file_get_contents('php://input');
$obj = json_decode($json);
    error_reporting(0);
	
    $id = $obj->{'id'};
    $userType = $obj->{'userType'};
    $school_id = $obj->{'school_id'};
	
   $site=$_SERVER['HTTP_HOST'];
include 'conn.php';

    if($id!='' && $userType!='' && $school_id!='')
	{

        $sql="select r.imagepath,r.rewardType,s.point,s.date from  softreward r,purcheseSoftreward s where s.userType='$userType' and s.user_id='$id' and r.`softrewardId`=s.reward_id and s.school_id='$school_id'  order by  id DESC"; 
			
		$result=mysql_query($sql);
                                      
					$count=mysql_num_rows($result);	
					
					if($count>0)
					{
						while($data=mysql_fetch_assoc($result))
						{
							$imagepath=$data['imagepath']; 
							$rewardType=$data['rewardType']; 
							$point=$data['point']; 
							$date=$data['date']; 
							
							
							
							if($imagepath=="")
							{
							$img="https://$site/Assets/images/avatar/avatar_2x.png";
							}
							else
							{
								 $img="https://$site/core/".$imagepath;
							}
							
       
							
							$data=array(
							'imagepath'=>$img,
							'rewardType'=>$rewardType,
							'point'=>$point,
							'date'=>$date
							);	
                    
						
											
					$post[]=$data;
					$postvalue['responseStatus']=200;
			    	$postvalue['responseMessage']="OK";
				    $postvalue['posts']=$post;
					
					
					
						}
					
					
					}
	
					else
					{
					$postvalue['responseStatus']=204;
			    	$postvalue['responseMessage']="No Record Found";
				    $postvalue['posts']=null;
					
					}   
					
	}
	else
			{

			        $postvalue['responseStatus']=1000;
			    	$postvalue['responseMessage']="Invalid Input";
				    $postvalue['posts']=null;



			}

header('Content-type: application/json');
 echo  json_encode($postvalue);
 
 
  @mysql_close($con);

?>