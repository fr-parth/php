<?php
//copy activity_type from cookie to group by yogesh
include('groupadminheader.php');
$report="";

 $group_member_id=$_SESSION['id'];

	//$school_id= $_GET["id"];
		$id=array();
		$activity_type=array();
		$i=0;	
		 $sql=mysql_query("select * from tbl_activity_type where school_id='0' and group_member_id='0' ");
		while($result=mysql_fetch_array($sql))
		{
		//$id[$i]=$result['id'];	
		$activity_type[$i]=$result['activity_type'];		

		 $results=mysql_query("select * from tbl_activity_type where school_id='0' and  group_member_id='$group_member_id'  and activity_type='$activity_type[$i]'  ");
		  $count=mysql_num_rows($results);


		  if($count==0)
		  { 
		$query=mysql_query("insert into tbl_activity_type(activity_type,school_id,group_member_id) values('$activity_type[$i]','0','$group_member_id')");

		$i++;
		
		}
		else
		{
			
		}
		}
		echo ("<script LANGUAGE='JavaScript'>window.alert('$i Activities Added Succesfully');
                     window.location.href='System_level_activity_type.php';
                  </script>");
	
	/*END*/
?>
 