<?php
include '../conn.php';
error_reporting(0);
$json = file_get_contents('php://input');
header('Content-type: application/json');
$obj = json_decode($json);
//$mobile=xss_clean(mysql_real_escape_string($obj->{'mobile'}));
$MemberID=xss_clean(mysql_real_escape_string($obj->{'MemberID'}));
//MemberID added as i/p parameter by Pranali for SMC-3734 on 24-1-19
if($MemberID != "")
{
 
  $query = mysql_query("select * from tbl_vol_spect_master where id ='$MemberID'");

$count = mysql_num_rows($query);

  $posts = array();
  if($count > 0)
   {   		
	   $pquery = mysql_query("select SUM(no_of_points) AS points FROM game_master WHERE sc_member_id='$MemberID'");
				$pqrow = mysql_fetch_assoc($pquery); 
                $sum = $pqrow['points'];
				if($sum > 0){
					$sum = $sum;
				}else{
					$sum = 0;
				}
                $post = mysql_fetch_array($query);
                $mobile=$post['mobile'];
                $school_id = $post['school_id'];
                //below queries for getting brown point of student added y Pranali for SMC-4695 on 7-5-20
				$sql_student_exits = mysql_query("SELECT std_PRN,school_id FROM tbl_student WHERE std_phone='$mobile' AND school_id='$school_id'");
				if(mysql_num_rows($sql_student_exits)==1)
				{
					$stud=mysql_fetch_array($sql_student_exits);
					$std_PRN=$stud['std_PRN'];
					$school_id=$stud['school_id'];
					
					$sql_student = mysql_query("SELECT brown_point,sc_total_point FROM tbl_student_reward WHERE school_id='".$school_id."' AND sc_stud_id='".$std_PRN."' ORDER BY id DESC LIMIT 1");

					if(mysql_num_rows($sql_student)==1){
						$stud1=mysql_fetch_array($sql_student);
						$brown_point=$stud1['brown_point'];

					}else{
						$brown_point=0;
					}
				}
				else{
						$brown_point=0;
					}
					$sum = $sum + $brown_point;
						 $data=array(
						 'total_points' =>$sum,
						 'reward_points' =>$post['reward_points'],
						 
						 );
                     
				$posts[] = $data;
	            $postvalue['responseStatus']=200;
				$postvalue['responseMessage']="OK";
				$postvalue['posts']=$posts;
   				header('Content-type: application/json');
                 echo json_encode($postvalue);
		}
	  else
	  {

					$postvalue['responseStatus']=409;
					$postvalue['responseMessage']="Invalid Phone Number ";
					$postvalue['posts']=null;
					header('Content-type: application/json');
                     echo json_encode($postvalue);
	  }
 
  	}
	else
			{
				$postvalue['responseStatus']=1000;
				$postvalue['responseMessage']="Invalid Input";
				$postvalue['posts']=null;
   				header('Content-type: application/json');
                echo json_encode($postvalue);
			}


  @mysql_close($con);

?>