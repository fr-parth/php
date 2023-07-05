<?php
include("conn.php");
if(isset($_GET["id"]))
	{
		$id= $_GET["id"];
		
		 $sql="DELETE FROM tbl_thanqyoupointslist WHERE id='$id'";
		mysql_query($sql);
		//header("location:thanqyoulist.php");
	}
?>
<script> 
	 window.history.go(-1);
	  </script>