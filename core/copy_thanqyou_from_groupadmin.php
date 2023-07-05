<?php
include('scadmin_header.php');
$report="";

$id=$_SESSION['id'];
           $fields=array("id"=>$id);
		   $table="tbl_school_admin";
		   
		   $smartcookie=new smartcookie();
		   
$results=$smartcookie->retrive_individual($table,$fields);
$result=mysql_fetch_array($results);
$sc_id=$result['school_id'];
$group_status=$result['group_status'];
$Group_id= $_GET["Group_id"];


if(isset($_GET["Group_id"]))
	{
		$Group_id= $_GET["Group_id"];
		$school_id= $_GET["id"];
		$t_lists=array();
		
		$i=0;
		//echo"1";
		 $sql=mysql_query("select * from tbl_thanqyoupointslist where school_id='2'");
		while($result=mysql_fetch_array($sql))
		{
		$t_lists[$i]=$result['t_list'];
		//echo"2";
		//echo "select * from tbl_thanqyoupointslist where school_id='$Group_id'  and t_list like '$t_lists[$i]' ";
		  $results=mysql_query("select * from tbl_thanqyoupointslist where school_id='$school_id'  and t_list like '$t_lists[$i]' ");
		  $count=mysql_num_rows($results);
		 // echo"3";
		  //echo $count;
		  if($count==0)
		  { 
		
		$query=mysql_query("insert into tbl_thanqyoupointslist(t_list,school_id) values('$t_lists[$i]','$school_id')");
		//echo"4";
		$i++;
		//echo"5";
		}
		
		/*else
		{
			$query=mysql_query("insert into tbl_thanqyoupointslist(t_list,school_id) values('$t_lists[$i]','$Group_id')");
		
		 $report="Thanq you name are already added...";
		
		}*/
		
		}
		//window.location and alert added by Pranali
		echo "<script>window.location='thanqyoulist.php';</script>";
	}
?>