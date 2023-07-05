<?php
include('scadmin_header.php');
$report="";
$id=$_SESSION['id'];
           $fields=array("id"=>$id);
		   $table="tbl_school_admin";		   
		   $smartcookie=new smartcookie();		   
$results=$smartcookie->retrive_individual($table,$fields);
$result=mysql_fetch_array($results);
$school_id=$result['school_id'];
if(isset($_GET["id"]))
	{
		$school_id= $_GET["id"];
		$id=array();
		$activity_type=array();
		$i=0;	
		 $sql=mysql_query("select * from tbl_activity_type where school_id='0' and group_member_id='0' ");
		while($result=mysql_fetch_array($sql))
		{
		//$id[$i]=$result['id'];	
		$activity_type[$i]=$result['activity_type'];		

		 $results=mysql_query("select * from tbl_activity_type where school_id='$school_id'   and activity_type='$activity_type[$i]'  ");
		  $count=mysql_num_rows($results);

/*Added echo in if else and at the end  By Dhanashri_Tak*/
		  if($count==0)
		  { 
		$query=mysql_query("insert into tbl_activity_type(activity_type,school_id) values('$activity_type[$i]','$school_id')");

		$i++;
		
		}
		
		}
		echo ("<script LANGUAGE='JavaScript'>window.alert('$i Activity Type Added Succesfully');
                     window.location.href='activitylist.php';
                  </script>");
	}
	/*END*/
?>
 