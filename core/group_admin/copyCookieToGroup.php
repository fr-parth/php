<?php
include('groupadminheader.php');
$group_member_id=$_SESSION['id'];
$report="";
/*
$id=$_SESSION['id'];
           $fields=array("id"=>$id);
		   $table="tbl_school_admin";
		   
		   $smartcookie=new smartcookie();
		   
$results=$smartcookie->retrive_individual($table,$fields);
$result=mysql_fetch_array($results);
$sc_id=$result['school_id'];
*/

		$t_lists=array();
		
		$i=0;
		
		 $sql=mysql_query("select * from tbl_thanqyoupointslist where school_id='0' and group_member_id='0'");
		while($result=mysql_fetch_array($sql))
		{
		$t_lists[$i]=$result['t_list'];
		
		
		
		
		  $results=mysql_query("select * from tbl_thanqyoupointslist where school_id='0' and group_member_id='$group_member_id'  and t_list like '$t_lists[$i]' ");
		  $count=mysql_num_rows($results);
		  
		  if($count==0)
		  { 
		
		$query=mysql_query("insert into tbl_thanqyoupointslist(t_list,school_id,group_member_id) values('$t_lists[$i]','0','$group_member_id')");
		$i++;
		}
		
		else
		{

			//window.location and alert added by Pranali
			//echo "<script>alert('$i Thanq you name are added successfully'); window.location='thanqyoulist.php';</script>";
		
		}
		
		}
		
		//echo "<script>window.location='thanqyoulist.php';</script>";
		echo "<script>alert('$i Thanq you name are added successfully'); window.location='thanqyou.php';</script>";
	
?>
