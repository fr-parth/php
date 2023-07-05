<?php
include('scadmin_header.php');
$report="";
//$id=$_SESSION['id'];
 $sc_id=$_SESSION['school_id'];
 $group_member_id=$_SESSION['group_member_id']; 
           $fields=array("id"=>$id);
		 //  $table="tbl_school_admin";		   
		 //  $smartcookie=new smartcookie();		   
//$results=$smartcookie->retrive_individual($table,$fields);
//$result=mysql_fetch_array($results);
//$school_id=0;
//$act360_school_ID = $result['school_id'];
if(isset($_GET["id"]))
	{
		$school_id= $_GET["id"];
		$id=array();
		$school_id=array();
		$i=0;
		if($group_member_id !='0')
		{
		 $sql=mysql_query("select * from tbl_360activities where group_member_id='$group_member_id' AND act360_school_ID='0'");
		while($result=mysql_fetch_array($sql))
		{
		//$id[$i]=$result['id'];	
		$act360_activity=$result['act360_activity'];		
		$act360_activity_level_ID=$result['act360_activity_level_ID'];	
		$act360_credit_points=$result['act360_credit_points'];	
		$act360_school_ID=$result['act360_school_ID'];	
		
		 $results=mysql_query("select * from tbl_360activities where (act360_school_ID='$sc_id')   and (act360_activity='$act360_activity') and (group_member_id='$group_member_id') ");
		  $count=mysql_num_rows($results);


		  if($count==0)
		  { 
		$query=mysql_query("insert into tbl_360activities(act360_activity,act360_activity_level_ID,act360_credit_points,act360_school_ID,group_member_id) values('$act360_activity','$act360_activity_level_ID','$act360_credit_points','$sc_id','$group_member_id')");

		$i++;
		echo ("<script LANGUAGE='JavaScript'>window.alert('Activities Added Succesfully');
                     window.location.href='list_360_feedback_activitys.php';
                  </script>");
		}
		else
		{
			echo ("<script LANGUAGE='JavaScript'>window.alert('Activities are already added...');
                     window.location.href='list_360_feedback_activitys.php';
                  </script>");
		 //$report="Activities are already added...";
		}
		}
		}
		echo ("<script LANGUAGE='JavaScript'>
                     window.location.href='list_360_feedback_activitys.php';
                  </script>");
		//header("location:activitylist.php");
	}
	/*END*/
?>
 