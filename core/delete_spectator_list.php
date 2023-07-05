<?php
include("conn.php");
if(isset($_GET["id"]))
	{
		$id= $_GET["id"];
		
		 $sql="DELETE FROM  tbl_vol_spect_master WHERE id='$id'";
		mysql_query($sql);
		
		 echo ("<script LANGUAGE='JavaScript'>
				alert('Record Deleted Successfully');
				window.location.href='spectator_list.php';
				</script>");
		
	}
?>