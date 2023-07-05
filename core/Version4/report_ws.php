<?php  
//Below web service done by Rutuja Jori on 08/08/2019 for bug SMC-3991

$json = file_get_contents('php://input');
$obj = json_decode($json);

 $format = 'json'; //xml is the default

include '../conn.php';
$site=$GLOBALS['URLNAME'];
  $std_dept = xss_clean(mysql_real_escape_string($obj->{'std_dept'}));  
  $t_emp_id = xss_clean(mysql_real_escape_string($obj->{'t_emp_id'}));
$school_id =  xss_clean(mysql_real_escape_string($obj->{'school_id'}));
$std_class =  xss_clean(mysql_real_escape_string($obj->{'std_class'}));
$offset=xss_clean(mysql_real_escape_string($obj->{'offset'}));
$emp_type=xss_clean(mysql_real_escape_string($obj->{'emp_type'}));
$from_date=xss_clean(mysql_real_escape_string($obj->{'from_date'}));
$to_date=xss_clean(mysql_real_escape_string($obj->{'to_date'}));
$activity_id=xss_clean(mysql_real_escape_string($obj->{'activity_id'}));
$selected_manager_emp_pid=xss_clean(mysql_real_escape_string($obj->{'selected_manager_emp_pid'}));
 $to=$to_date." ".'23:59:59'; 
 $from=$from_date." ".'00:00:00';

 $whereforstudent="";
 $sqlforstudent = "select s.std_complete_name as Employee_name,s.std_PRN as Employee_ID,sp.sc_stud_id,SUM(sp.sc_point) as Assigned_points from tbl_student s join tbl_student_point sp on s.std_PRN=sp.sc_stud_id and s.school_id=sp.school_id join tbl_studentpointslist spl on spl.sc_id=sp.sc_studentpointlist_id where sp.school_id='$school_id'";
 $sqlgroupbyforstudent = " group by sp.sc_stud_id order by Assigned_points desc LIMIT $limit offset $offset ";

 $whereforteacher="";
 $sqlforteacher= "select t.t_emp_type_pid as t_emp_type_pid,t.t_designation as designation,t.t_complete_name as Employee_name,t.t_id as Employee_ID,tp.sc_teacher_id,SUM(tp.sc_point) as Assigned_points from tbl_teacher t join tbl_teacher_point tp on t.t_id=tp.sc_teacher_id and t.school_id=tp.school_id join tbl_studentpointslist spl on spl.sc_id=tp.sc_thanqupointlist_id where tp.school_id='$school_id' ";
 $sqlgroupbyforteacher = " group by tp.sc_teacher_id order by Assigned_points desc LIMIT $limit offset $offset ";

 $whereforstudent .= " and (sp.point_date BETWEEN '$from' AND '$to') ";
 $whereforteacher .= " and (tp.point_date BETWEEN '$from' AND '$to') and reward_type='reward' ";
   
 if($activity_id=='0')
 {
	 // All Activity
 } else {
	  //Specific Activity
	  $whereforstudent .= " and sp.sc_studentpointlist_id='".$activity_id."' ";
	  $whereforteacher .= " and tp.sc_thanqupointlist_id='".$activity_id."' ";
 }
 
 if ( $emp_type == "Employee" ) {
	 
	  $entityid='105';
	   $designation='Employee';
	   $t_emp_type_pid='0';	
	   
	if ( $std_dept == "All" ) {
		// All Departments
	} else {
		// Specific Department
		$whereforstudent .= " and s.std_dept='".$std_dept."' ";
	}
	
	if ( $std_class == "" ) {
		//All Classes
	} else {
		// Specific Class
		$whereforstudent .= " and s.std_class='".$std_class."' ";
	}
 }
 
 if( $emp_type=='Manager' ) {
	  $entityid='103';
	if ( $std_dept == "All" ) {
		// All Departments
	} else {
		// Specific Department
		$whereforteacher .= " and t.t_dept='".$std_dept."' ";
	}
	
	if ( $selected_manager_emp_pid == "0" ) {
		// All Managers
		$whereforteacher .= " and t.t_emp_type_pid <'".$t_emp_id."' ";
	} else {
		// For Selected Manager
		$whereforteacher .= " and t.t_emp_type_pid <'".$selected_manager_emp_pid."' ";
	}

 }
 
 if($school_id!='' && $t_emp_id!='')
 {
	if ( $emp_type=='Employee' ) {
		$arr = mysql_query( $sqlforstudent . $whereforstudent . $sqlgroupbyforstudent );		
	}

	if ( $emp_type=='Manager' ) {
		
		$arr = mysql_query( $sqlforteacher . $whereforteacher . $sqlgroupbyforteacher );
	}
	
	$posts = array();
			
  	$numrecord=	mysql_num_rows($arr);
		
	if($numrecord==0 && ($arr)) {
		if($offset==0) {
			$postvalue['responseStatus']=204;
			$postvalue['responseMessage']="No Record Found";
			$postvalue['posts']=null;
		} else {
			$postvalue['responseStatus']=224;
			$postvalue['responseMessage']="End Of Records";
			$postvalue['posts']=null;
		}
	}
	else if($numrecord > 0) {
 		while($post = mysql_fetch_assoc($arr)) {
			$Employee_name=$post['Employee_name'];
			$Employee_ID=$post['Employee_ID'];
			$Assigned_points=$post['Assigned_points'];
			$entityid=$entityid;
			$designation=$designation;
			$t_emp_type_pid=$t_emp_type_pid;
					
				if( $emp_type=='Employee')
				{
					$designation=$designation;
					$t_emp_type_pid=$t_emp_type_pid;
				}
				else if ($emp_type=='Manager')
				{
					$designation=$post['designation'];
					$t_emp_type_pid=$post['t_emp_type_pid'];
				}
				
			$posts[] = array(
						'Employee_name'=>$Employee_name,
						'Employee_ID'=>$Employee_ID,
						'Assigned_points'=>$Assigned_points,
						'entityid'=>$entityid,
						'designation'=>$designation,
						't_emp_type_pid'=>$t_emp_type_pid
					);
		}
		
		$postvalue['responseStatus']=200;
		$postvalue['responseMessage']="OK";
		$postvalue['posts']=$posts;
  	} else {
		$postvalue['responseStatus']=204;
		$postvalue['responseMessage']="No Response";
		$postvalue['posts']=null;
	}
 } else {
	$postvalue['responseStatus']=1000;
	$postvalue['responseMessage']="Invalid Input";
	$postvalue['posts']=null;
			  
	header('Content-type: application/json');
   	echo  json_encode($postvalue);  
	@mysql_close($link);
	exit;
 }

		
/* output in necessary format */
if($format == 'json') {
	header('Content-type: application/json');
   	echo json_encode($postvalue);
} else {
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
@mysql_close($link);	
	
?>
