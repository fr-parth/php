<?php  
//require_once('loader.php');
//require_once('../function.php');
//require_once('../config.php');
error_reporting(0);
//$json=$_GET ['json'];
$json = file_get_contents('php://input');
$obj = json_decode($json);
$format = 'json'; 

include '../conn.php';
	// Sender PRN						
   $t_id1=xss_clean(mysql_real_escape_string($obj->{'t_id'})); 
	// Receiver PRN   
   $t_id2=xss_clean(mysql_real_escape_string($obj->{'t_id2'}));  
   $points=xss_clean(mysql_real_escape_string($obj->{'points'}));
  
  //if points given for blog then blog id is inserted in reason column
   $reason=xss_clean(mysql_real_escape_string($obj->{'reason'}));
   $school_id=xss_clean(mysql_real_escape_string($obj->{'school_id'}));
   $select_opt=xss_clean(mysql_real_escape_string($obj->{'point_type'}));

   //Receiver_SchoolID added extra parameter by Pranali for ticket SMC3791 on 1232019
   $Receiver_SchoolID=xss_clean(mysql_real_escape_string($obj->{'Receiver_SchoolID'}));
     
   $posts = array();
   
if($t_id1!="" && $t_id2!="" && $points!="" && $reason!="" && $school_id!="") 
{	
	if($t_id1 == $t_id2 && $school_id == $Receiver_SchoolID)
	{
		$postvalue['responseStatus']=409;
		$postvalue['responseMessage']="You cannot assign points to your own blog";
		$postvalue['posts']=null;
	}
	else
	{
		if($select_opt=='Bluepoint')	
		{
		$query = mysql_query("select id,balance_blue_points from tbl_teacher where t_id ='$t_id1' and school_id='$school_id' ");
		$result=mysql_fetch_array($query);
		$balance_blue_points=$result['balance_blue_points'];
		$teacher_id1=$result['id'];
			if($points<=$balance_blue_points)
			{
						// Start SMC3451 Modify By sachin 20180920 19:16:38 PM 
						  //$date=Date('Y/m/d');
						  $date = CURRENT_TIMESTAMP; 
						  // define in core/securityfunctions.php
						  //Start SMC3451

						
					$sql=mysql_query("select id,balance_blue_points from tbl_teacher where t_id ='$t_id2' and school_id='$school_id' ");
					$result=mysql_fetch_array($sql);
					$teacher_id2=$result['id'];
					$sc_final_point=$result['balance_blue_points']+$points;
						
					//add blue points to receiver
					$sql1=mysql_query("update tbl_teacher set balance_blue_points='$sc_final_point' where t_id='$t_id2' and school_id='$school_id' ");
						
					//deduct blue points from sender
					$sc_share_point=$balance_blue_points-$points;
					$query=mysql_query("update tbl_teacher set balance_blue_points='$sc_share_point' where t_id='$t_id1' and school_id='$school_id' ");
						
					//insert into tbl_teacher_point for points log
					$test=mysql_query("insert into tbl_teacher_point(Teacher_Member_Id,sc_entities_id,sc_point,sc_teacher_id,assigner_id,reason,point_date,school_id,point_type,Receiver_SchoolID) values('$teacher_id2','103','$points','$t_id2','$t_id1','$reason','$date','$school_id','$select_opt','$Receiver_SchoolID')");
						
					$report="Blue Points are shared succesfully";
					$posts[]=array('report'=>$report);
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
	}	
	elseif($select_opt=='Waterpoint')	
	{					
	
		$query = mysql_query("select water_point,id from tbl_teacher where t_id ='$t_id1' and school_id='$school_id' ");			
		$result=mysql_fetch_array($query);			
		$water_point=$result['water_point'];				
		$teacher_id1=$result['id'];				
		if($points<=$water_point)				
		{	
			// Start SMC3451 Modify By sachin 20180920 19:16:38 PM 
			//$date=Date('Y/m/d');
			$date = CURRENT_TIMESTAMP; 
			// define in core/securityfunctions.php
			//Start SMC3451
						
			$sql=mysql_query("select id,balance_blue_points from tbl_teacher where t_id ='$t_id2' and school_id='$school_id' ");	
			$result=mysql_fetch_array($sql);				
			$teacher_id2=$result['id'];					
			$sc_final_point=$result['balance_blue_points']+$points;	
			
			//add blue_points of receiver
			
			$sql1=mysql_query("update tbl_teacher set balance_blue_points='$sc_final_point' where t_id='$t_id2' and school_id='$school_id' ");	
			
			$sc_share_point=$water_point-$points;
			//deduct water_point from sender			
			$query=mysql_query("update tbl_teacher set water_point='$sc_share_point' where t_id='$t_id1' and school_id='$school_id' ");			
			$test=mysql_query("insert into tbl_teacher_point(Teacher_Member_Id,sc_entities_id,sc_point,sc_teacher_id,assigner_id,reason,point_date,school_id,point_type,Receiver_SchoolID) values('$teacher_id2','103','$points','$t_id2','$t_id1','$reason','$date','$school_id','$select_opt','$Receiver_SchoolID')");
			
			$report="Water Points are shared succesfully";					
			
			$posts[]=array('report'=>$report);							$postvalue['responseStatus']=200;							$postvalue['responseMessage']="OK";							$postvalue['posts']=$posts;					
		}					
		else
		{	
			$postvalue['responseStatus']=204;							$postvalue['responseMessage']="No Response";				$postvalue['posts']=null;		
		}						
	}
	//As per approved by Rakesh Sir,brown points sharing (for blog only) condition added by Pranali for SMC3791 on 13319
	elseif($select_opt=='BrownPoint' && !empty($Receiver_SchoolID))
	{					
		$query = mysql_query("select brown_point,id from tbl_teacher where t_id ='$t_id1' and school_id='$school_id' ");			
		$result=mysql_fetch_array($query);			
		$brown_point=$result['brown_point'];				
		$teacher_id1=$result['id'];				
		if($points<=$brown_point)				
		{	
			//CURRENT_TIMESTAMP defined in core/securityfunctions.php
			$date = CURRENT_TIMESTAMP; 
									
			$sql=mysql_query("select id,balance_blue_points from tbl_teacher where t_id ='$t_id2' and school_id='$school_id' ");	
			$result=mysql_fetch_array($sql);				
			$teacher_id2=$result['id'];					
			$sc_final_point=$result['balance_blue_points']+$points;	
			
			//add blue_points of receiver
			
			$sql1=mysql_query("update tbl_teacher set balance_blue_points='$sc_final_point' where t_id='$t_id2' and school_id='$school_id' ");	
			
			$sc_share_point=$brown_point-$points;
			//deduct water_point from sender			
			$query=mysql_query("update tbl_teacher set brown_point='$sc_share_point' where t_id='$t_id1' and school_id='$school_id' ");			
			$test=mysql_query("insert into tbl_teacher_point(Teacher_Member_Id,sc_entities_id,sc_point,sc_teacher_id,assigner_id,reason,point_date,school_id,point_type,Receiver_SchoolID) values('$teacher_id2','103','$points','$t_id2','$t_id1','$reason','$date','$school_id','$select_opt','$Receiver_SchoolID')");
			
			$report="Brown Points are shared succesfully";				
			
			$posts[]=array('report'=>$report);							$postvalue['responseStatus']=200;							$postvalue['responseMessage']="OK";							$postvalue['posts']=$posts;					
		}					
		else
		{	
			$postvalue['responseStatus']=204;							$postvalue['responseMessage']="No Response";				$postvalue['posts']=null;		
		}						
	}
		

	}
	if($format == 'json') {							
			header('Contenttype: application/json');  					echo json_encode($postvalue);		
		}
}
else{	   
				$postvalue['responseStatus']=1000;
				$postvalue['responseMessage']="Invalid Input";
				$postvalue['posts']=null;
			  
				header('Contenttype: application/json');
				echo  json_encode($postvalue); 
	   
	 }
		
?>