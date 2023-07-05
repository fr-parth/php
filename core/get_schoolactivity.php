<?php
 include("conn.php");
$id=$_SESSION['id'];
$marks = xss_clean(mysql_real_escape_string($_GET['val']));


$query = mysql_query("select * from tbl_teacher where id = '$id' ");
$value = mysql_fetch_array($query);

$school_id=$value['school_id'];
$method_type = xss_clean(mysql_real_escape_string($_GET['method_type']));
$activity = xss_clean(mysql_real_escape_string($_GET['activity']));

 $tag=substr($activity,0,7);
if($tag=="subject")
{
$activity=substr($activity,8);

}

 $sql="SELECT  m.id,from_range,to_range FROM tbl_master m JOIN tbl_method t on t.id=m.method_id WHERE t.id ='$method_type' AND activity_id='$activity' AND school_id='$school_id'";

$id="";

$result=mysql_query($sql);
if(mysql_num_rows($result)>0)
{
	while( $row = mysql_fetch_array($result))
	{
	
	 $from_range=$row['from_range'];
	 $to_range=$row['to_range'];
	if($method_type=="3")
	{
	
		if(strcmp($from_range,$marks)<=0 && strcmp($to_range,$marks)>=0)
		{
		 $id=$row['id'];
		}
	
	}
	else
	{
		if($marks>=$from_range && $marks<=$to_range)
		{
		 $id=$row['id'];
		
		
		}
	}
}
}
else
{

	$results=mysql_query("SELECT  m.id,from_range,to_range FROM tbl_master m JOIN tbl_method t on t.id=m.method_id WHERE t.id ='$method_type' AND school_id='0'");

	while( $rows = mysql_fetch_array($results))
	{
	
	 $from_range=$rows['from_range'];
	 $to_range=$rows['to_range'];
	if($method_type=="Grade")
	{
	
		if(strcmp($from_range,$marks)<=0 && strcmp($to_range,$marks)>=0)
		{
		 $id=$rows['id'];
		}
	
	}
	else
	{
		if($marks>=$from_range && $marks<=$to_range)
		{
		 $id=$rows['id'];
		
		
		}
	}


}
}

$results=mysql_query("SELECT  m.id,points FROM tbl_master m JOIN tbl_method t WHERE m.id='$id'");
$values=mysql_fetch_array($results);
echo xecho($points =$values['points']);


?>


