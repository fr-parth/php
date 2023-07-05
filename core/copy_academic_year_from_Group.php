				
<?php
//Created by Rutuja to copy Academic Years from Groupadmin if School belongs to a Group for SMC-4663 on 14/04/2020
include('scadmin_header.php');
$report="";

$id=$_SESSION['id'];
$sc_id=$_SESSION['school_id'];
           $fields=array("id"=>$id);
		   $table="tbl_school_admin";
		   
		   $smartcookie=new smartcookie();
		   
$results=$smartcookie->retrive_individual($table,$fields);
$result=mysql_fetch_array($results);
//$sc_id=$result['school_id'];
$group_member_id=$result['group_member_id'];

if($sc_id !='')
	{
		//$school_id= $_GET["id"];
		$a_lists=array();
		
		$i=0;
		
		 $sql=mysql_query("select * from tbl_academic_Year where school_id='0' and group_member_id='$group_member_id'");
		while($result=mysql_fetch_array($sql))
		{
		 $a_lists[$i]=$result['Academic_Year'];
		 $Enable=$result['Enable'];
		 $Year=$result['Year'];
		
		
		
		  $results=mysql_query("select * from tbl_academic_Year where school_id='$sc_id' and group_member_id='$group_member_id'  and Academic_Year like '$a_lists[$i]' ");
		  $count=mysql_num_rows($results);
		  
		  if($count==0)
		  { 
		
		$query=mysql_query("insert into tbl_academic_Year(Academic_Year,school_id,group_member_id,Enable,Year) values('$a_lists[$i]','$sc_id','$group_member_id','$Enable','$Year')");
		$i++;
		}
		
		else
		{

		}
		
		}
		if($i==0)
		{
		echo "<script>alert('Not found any different Academic Years to add...'); window.location='list_school_academic_year.php';</script>";
		}
		else if($i==1)
		{
		echo "<script>alert('$i Academic Year is added successfully'); window.location='list_school_academic_year.php';</script>";
		}
		else
		{
		echo "<script>alert('$i Academic Years are added successfully'); window.location='list_school_academic_year.php';</script>";
		}
}
?>
