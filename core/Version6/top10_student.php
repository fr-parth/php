<?php
/*Created by Rutuja Jori for SMC-5122 on 23-01-2021*/
include '../conn.php';

$json = file_get_contents('php://input');
$obj = json_decode($json);
error_reporting(0);

//print_r($json);

  $school_id = xss_clean(mysql_real_escape_string($obj->{'school_id'}));
  $duration = xss_clean(mysql_real_escape_string($obj->{'duration'}));
  $activity_id = xss_clean(mysql_real_escape_string($obj->{'activity_id'}));
  $subject_id = xss_clean(mysql_real_escape_string($obj->{'subject_id'}));
  $department = xss_clean(mysql_real_escape_string($obj->{'department'}));
  $group_member_id = xss_clean(mysql_real_escape_string($obj->{'group_member_id'}));

  $where="";$time_duration="";$subject_activity="";$join_for_sub_act="";$point_type="";  
 
  $date = CURRENT_TIMESTAMP; 
  
  $cond = "";
  /* soak in the passed variable or set our own */
  $number_of_posts = isset($_GET['num']) ? intval($_GET['num']) : 10; //10 is the default
 $format = 'json'; //xml is the default

 if($school_id != "" )
    {
                if($school_id!='all')
          {
            $where .=" and s.school_id='$school_id'";
          }
          else
          {
            $where .= " and s.group_member_id='$group_member_id'";
          }
          
          if($duration=="week")
          {
            $time_duration .= " and sp.point_date > date_sub(now(), INTERVAL 1 WEEK)";
          }
          else if($duration=="month")
          {
            $time_duration .= " and sp.point_date > date_sub(now(), INTERVAL 1 MONTH)";
          }
          else
          {
            $time_duration .= " and sp.point_date > date_sub(now(), INTERVAL 1 YEAR)";
          }
          
          
          if($activity_id!='')
          {
          $subject_activity .= " spl.sc_list, ";
          $join_for_sub_act .= " join tbl_studentpointslist spl on spl.sc_id = sp.sc_studentpointlist_id where activity_type='activity'";
          if($activity_id=="allActivity")
          {
          $where .="";
          }
          else{
            $where .=" and sp.sc_studentpointlist_id='$activity_id'";
          }
          
          }
          
          if($subject_id!='')
          { 
          $subject_activity .= " ss.subject,"; 
        
          $join_for_sub_act .= " join tbl_school_subject ss on ss.id = sp.sc_studentpointlist_id where activity_type='subject'";
          
          if($subject_id=="allSubject")
          {
          $where .= ""; 
          }
          else
          {
          $where .= " and sp.sc_studentpointlist_id='$subject_id'"; 
          } 
          
            }
            if($department!='')
          {
            $where .=" and s.std_dept='$department'";
          }
                      
                    
          
          $sqlforall="Select $subject_activity
          ucwords(s.std_complete_name) as name,s.std_img_path,s.std_school_name,s.school_id,IFNULL(s.std_dept,'') as department ,IFNULL(s.emp_designation,'') as designation,
          sum(sc_point) as total from tbl_student s join tbl_student_point sp on s.std_PRN=sp.sc_stud_id and s.school_id=sp.school_id $join_for_sub_act and (sp.type_points='Greenpoint' or sp.type_points='green_Point')";
          
          $groupby= " GROUP BY sp.sc_stud_id order by total desc limit 10";
          //echo $sqlforall . $time_duration . $where . $groupby;exit;

          $sql=mysql_query( $sqlforall . $time_duration . $where . $groupby);
      
          $count=mysql_num_rows($sql);

if(!$sql){
            $postvalue['responseStatus']=204;
            $postvalue['responseMessage']="No Response";
            $postvalue['posts']=null;
            header('Content-type: application/json');
             echo json_encode($postvalue); 
          exit;
}

  /* create one master array of the records */
  $posts = array();
  if($count >= 1)
   {
         while($post = mysql_fetch_assoc($sql)){
          $student_name=$post['name'];
          $student_school=$post['std_school_name'];
          $student_reward_points=$post['total'];
          $student_dept=$post['department'];
          $std_img_path = $post['std_img_path']; 
          if($std_img_path=="")
      { 
        $std_img_path=$GLOBALS['URLNAME']."/Assets/images/avatar/avatar_2x.png";
      }
      else{
        $std_img_path=$GLOBALS['URLNAME']."/core/".$std_img_path;
      }
                     
          $posts[] = array(
          
          'std_img_path'=>$std_img_path,
          'student_name'=>$student_name,
          'student_school'=>$student_school,
          'student_dept'=>$student_dept,
          'student_reward_points'=>$student_reward_points
          );
       }           
      $postvalue['responseStatus']=200;
        $postvalue['responseMessage']="OK";
        $postvalue['posts']=$posts;
      }
      else{
      $postvalue['responseStatus']=204;
        $postvalue['responseMessage']="Record not found";
        $postvalue['posts']=null;
      }
        }
        else
      {

        $postvalue['responseStatus']=1000;
        $postvalue['responseMessage']="Invalid Input";
        $postvalue['posts']=null;

      }
      
  /* output in necessary format */
  if($format == 'json') {
             header('Content-type: application/json');
             echo json_encode($postvalue);
  }
  else {
    //header('Content-type: text/xml');
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

  @mysql_close($con);

?>