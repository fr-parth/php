<?php
/*Created by Rutuja Jori for SMC-5122 on 23-01-2021*/
include '../conn.php';

$json = file_get_contents('php://input');
$obj = json_decode($json);
error_reporting(0);
$site=$GLOBALS['URLNAME'];

//print_r($json);

  $school_id = xss_clean(mysql_real_escape_string($obj->{'school_id'}));
  $duration = xss_clean(mysql_real_escape_string($obj->{'duration'}));
  $point_type = xss_clean(mysql_real_escape_string($obj->{'point_type'}));
  $department = xss_clean(mysql_real_escape_string($obj->{'department'}));
  $group_member_id = xss_clean(mysql_real_escape_string($obj->{'group_member_id'}));

  $where="";$time_duration="";$point1="";  
 
  $date = CURRENT_TIMESTAMP; 
  
  $cond = "";
  /* soak in the passed variable or set our own */
  $number_of_posts = isset($_GET['num']) ? intval($_GET['num']) : 10; //10 is the default
 $format = 'json'; //xml is the default

 if($school_id != "" )
    {
               if($school_id!='all')
          {
            $where .="  t.school_id='$school_id'";
          }
          else
          {
            $where .= "  t.group_member_id='$group_member_id'";
          }
          
            
          if($duration=="week")
          {
            $time_duration .= " and tp.point_date > date_sub(now(), INTERVAL 1 WEEK)";
          }
          else if($duration=="month")
          {
            $time_duration .= " and tp.point_date > date_sub(now(), INTERVAL 1 MONTH)";
          }
          else
          {
            $time_duration .= " and tp.point_date > date_sub(now(), INTERVAL 1 YEAR)";
          }
          
          if($point_type=='school')
          {
            $point1 .= " and tp.sc_entities_id='102'";
            $type_point .= " and (point_type='bluepoint' or point_type='blue_point') ";
            
          }           
          else if($point_type=='stud')
          {
            $point1 .= " and tp.sc_entities_id='105'";
            $type_point .= " and (point_type='bluepoint' or point_type='blue_point') ";
          }
          
          /*else if($point_type=='teacher')
          {
            $point1 .= " and tp.sc_entities_id='103'";
            $type_point .= " and (point_type='Waterpoint' or point_type='Water Points') ";
          }*/
          
          else
          {
            $point1 .= " and (tp.sc_entities_id='102' or  tp.sc_entities_id='105' or tp.sc_entities_id='103') ";
            $type_point .= " and (point_type='bluepoint' or point_type='blue_point') ";
          }
          if($department!='')
          {
           
            $where .=" and t.t_dept='$department'";
          }
          
          
          $sqlforall="Select t.t_dept,t.school_id,t.t_id,t.t_pc,ucwords(t.t_complete_name) as name,t.t_current_school_name,SUM(tp.sc_point) as Assigned_Points from 
          tbl_teacher t join tbl_teacher_point tp on t.t_id=tp.sc_teacher_id and t.school_id=tp.school_id where $where $type_point ";
          
      
          
          $groupby= " group by tp.sc_teacher_id order by Assigned_Points desc limit 10";
      
          //echo $sqlforall . $time_duration . $point1 . $groupby;exit;
          $sql=mysql_query( $sqlforall . $time_duration . $point1 . $groupby);
      
          
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
          $teacher_name=$post['name'];
          $teacher_school=$post['t_current_school_name'];
          $teacher_reward_points=$post['Assigned_Points'];
          $teacher_dept=$post['t_dept'];
          $teacher_image = $post['t_pc']; 

          $default_image="$site/Assets/images/avatar/avatar_2x.png";

            if($teacher_image!=""){

              $image="$site/teacher_images/".$teacher_image;
            }
            else{
        
                $image=$default_image;
            }
                     
          $posts[] = array(
          
          'image'=>$image,
          'teacher_name'=>$teacher_name,
          'teacher_school'=>$teacher_school,
          'teacher_dept'=>$teacher_dept,
          'teacher_reward_points'=>$teacher_reward_points
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