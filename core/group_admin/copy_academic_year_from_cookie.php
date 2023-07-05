<?php
//Created by Rutuja to copy Academic Years from CookieAdmin for SMC-4663 on 13/04/2020
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

		$a_lists=array();
		
		$i=0;
		
		 $sql=mysql_query("SELECT DISTINCT * FROM  tbl_academic_Year  WHERE school_id = '0' and group_member_id = '0' order by id desc");
		while($result=mysql_fetch_array($sql))
		{
		 $a_lists[$i]=$result['Academic_Year'];
		 $Enable=$result['Enable'];
		 $Year=$result['Year'];
		
		
		  $results=mysql_query("select * from tbl_academic_Year where school_id='0' and group_member_id='$group_member_id'  and Academic_Year like '$a_lists[$i]' ");
		  $count=mysql_num_rows($results);
		  
		  if($count==0)
		  { 
		
		$query=mysql_query("insert into tbl_academic_Year(Academic_Year,school_id,group_member_id,Enable,Year) values('$a_lists[$i]','0','$group_member_id','$Enable','$Year')");
		$i++;
		}
		
		else
		{

		}
		
		}
		
		if($i==0)
		{
		echo "<script>alert('Not found any different Academic Years to add...'); window.location='academic_year_list.php';</script>";
		}
		else if($i==1)
		{
		echo "<script>alert('$i Academic Year is added successfully'); window.location='academic_year_list.php';</script>";
		}
		else
		{
		echo "<script>alert('$i Academic Years are added successfully'); window.location='academic_year_list.php';</script>";
		}
?>
