<?php

include '../conn.php';

$json = file_get_contents('php://input');
$obj = json_decode($json);
//error_reporting(0);



  $school_id = xss_clean(mysql_real_escape_string($obj->{'school_id'}));
  $t_id = xss_clean(mysql_real_escape_string($obj->{'t_id'}));

   if($school_id == "")
   {
    $postvalue['responseStatus']=204;
    $postvalue['responseMessage']="Please Enter School ID";
	echo json_encode($postvalue);
	die;
   }
   
   if($t_id == "")
   {
	$postvalue['responseStatus']=206;
    $postvalue['responseMessage']="Please Enter Teacher ID";
	echo json_encode($postvalue);
	die;
   }
   
   $teacherquery = mysql_query("select * from tbl_teacher where t_id='$t_id'");
   $rowteacher = mysql_fetch_array($teacherquery);
   $Department_Id = $rowteacher['t_DeptCode'];
   
   $sql = mysql_query("select email,name from tbl_school_admin where school_id='$school_id'");
   $count_admin = mysql_num_rows($sql);
   
   if($count_admin == 0)
   {
	 $postvalue['responseStatus']=220;
     $postvalue['responseMessage']="No Record Found In School Admin";
	 echo json_encode($postvalue);  
	 die;
   }
   $rows = mysql_fetch_array($sql);
   $admin_email = $rows['email'];
   $admin_name = $rows['name'];
   
   $query = mysql_query("select * from tbl_teacher where ((t_emp_type_pid = '135' and t_DeptCode='$Department_Id') or t_emp_type_pid = '137') and school_id='$school_id'");
   $count_hodp = mysql_num_rows($query);
   if($count_hodp == 0)
   {
	 $postvalue['responseStatus']=222;
     $postvalue['responseMessage']="No Record Found In Teacher Table";
	 echo json_encode($postvalue);  
	 die;
   }
   while($row = mysql_fetch_array($query))
   {
   $t_email = $row['t_email'];
   $t_DeptID = $row['t_DeptCode'];
   $t_emp_type_pid = $row['t_emp_type_pid'];
   $t_complete_name = $row['t_complete_name'];
	if($t_emp_type_pid == 135 )
	{
	  $post_name = "HOD";
	}
	if($t_emp_type_pid == 137)
	{
	 $post_name = "Principal";
	}
	$info[] = array("Employee_Type"=>$post_name,"Employee_Name"=>$t_complete_name,"Employee_Entity_Id"=>$t_emp_type_pid,"Department_Id"=>$t_DeptID,"Email_id"=>$t_email);
   }
    $info[] = array("Employee_Type"=>"School Admin","Employee_Name"=>$admin_name,"Employee_Entity_Id"=>100,"Department_Id"=>$Department_Id,"Email_id"=>$admin_email);
	
	 $postvalue['responseStatus']=200;
     $postvalue['responseMessage']="Ok";
	 $postvalue['Result']=$info;
	 echo json_encode($postvalue);
  
  ?>