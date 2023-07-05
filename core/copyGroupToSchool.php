<?php
include('scadmin_header.php');
$report="";
if($_SESSION['usertype']=='HR Admin Staff' OR $_SESSION['usertype']=='School Admin Staff')
	{
		$sc_id1=$_SESSION['school_id']; 
		$query2 = mysql_query("select id from tbl_school_admin where school_id ='$sc_id1'");

    $value2 = mysql_fetch_array($query2);

    $id = $value2['id'];
		
		
	}
	else
	{
		$id = $_SESSION['id'];
	};
//$sc_id=$_SESSION['school_id'];
           $fields=array("id"=>$id);
		   $table="tbl_school_admin";
		   
		   $smartcookie=new smartcookie();
		   
$results=$smartcookie->retrive_individual($table,$fields);
$result=mysql_fetch_array($results);
$sc_id=$result['school_id'];
$group_member_id=$result['group_member_id'];

if($sc_id !='')
	{
		//$school_id= $_GET["id"];
		$t_lists=array();
		
		$i=0;
		
		 $sql=mysql_query("select * from tbl_thanqyoupointslist where school_id='0' and group_member_id='$group_member_id'");
		while($result=mysql_fetch_array($sql))
		{
		$t_lists[$i]=$result['t_list'];
		
		
		
		
		  $results=mysql_query("select * from tbl_thanqyoupointslist where school_id='$sc_id' and group_member_id='$group_member_id'  and t_list like '$t_lists[$i]' ");
		  $count=mysql_num_rows($results);
		  
		  if($count==0)
		  { 
		
		$query=mysql_query("insert into tbl_thanqyoupointslist(t_list,school_id,group_member_id) values('$t_lists[$i]','$sc_id','$group_member_id')");
		$i++;
		}
		
		else
		{

			//window.location and alert added by Pranali
			//echo "<script>alert('Thanq you name are already added...');window.location='thanqyoulist.php';</script>";
		
		}
		
		}
		
		echo "<script>alert('$i Thanq you name are added successfully'); window.location='thanqyoulist.php';</script>";
	}
?>
