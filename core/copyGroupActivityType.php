<?php
//copy activity_type from group to school by yogesh
include('scadmin_header.php');
$report="";

 $school_id=$_SESSION['school_id'];
 $group_member_id=$_SESSION['group_member_id'];

		$id=array();
		$activity_type=array();
		$i=0;	
		 $sql=mysql_query("select * from tbl_activity_type where school_id='0' and group_member_id='$group_member_id' ");
		while($result=mysql_fetch_array($sql))
		{
		//$id[$i]=$result['id'];	
		$activity_type[$i]=$result['activity_type'];		

		 $results=mysql_query("select * from tbl_activity_type where school_id='$school_id'   and activity_type='$activity_type[$i]'  ");
		  $count=mysql_num_rows($results);


		  if($count==0)
		  { 
		$query=mysql_query("insert into tbl_activity_type(activity_type,school_id,group_member_id) values('$activity_type[$i]','$school_id','$group_member_id')");

		$i++;
		
		}
		
		}
		echo ("<script LANGUAGE='JavaScript'>window.alert('$i Activities Added Succesfully');
                     window.location.href='activitylist.php';
                  </script>");
		//header("location:activitylist.php");
	
	/*END*/
?>
 