<?php
include("groupadminheader.php");
$group_member_id = $_SESSION['group_admin_id'];
$sql = "SELECT group_type FROM tbl_cookieadmin WHERE id='$group_member_id'";
$query = mysql_query($sql);
$rows = mysql_fetch_assoc($query);
$group_type= $rows['group_type']; 
//$sql="SELECT * FROM  tbl_school_subject where group_member_id = '$group_member_id' order by id ";
if($group_type=="Sports")
 {
	$sql="SELECT id,subject_code as Subject_Code,name as subject  FROM  tbl_games where group_member_id = '$group_member_id' order by id ";						
 }
else 
 {
	$sql="SELECT ss.id,Subject_Code,subject,image FROM  tbl_school_subject ss inner join tbl_group_school gs on ss.school_id=gs.school_id where gs.group_member_id = '$group_member_id' order by ss.id ";						
 }
//echo $sql;
	$row=mysql_query($sql);	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title><?php echo $dynamic_subject."Information";?></title>


<link rel="stylesheet" type="text/css" href="../css/jquery.dataTables.css">
 <link rel="stylesheet" href="../bootstrap.min.css">
 <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="../js/jquery-1.11.1.min.js"></script>
<script src="../js/jquery.dataTables.min.js"></script>

  <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>

  <script>
  $(function() {
    $( "#from_date" ).datepicker({
      changeMonth: true,
      changeYear: true
    });
  });

  $(function() {
    $( "#to_date" ).datepicker({
      changeMonth: true,
      changeYear: true,

    });
  });
  </script>

  <script>
      $(document).ready(function(){
     $('#example').dataTable()
		  ({
    		});
		});



function confirmation(xxx) {
    var answer = confirm("Are you sure you want to delete ?")
    if (answer){  
        window.location = "delete_games_list.php?id="+xxx;
    }
    else{
       
    }
}
   </script>
      <style>
@media only screen and (max-width: 800px) {

    /* Force table to not be like tables anymore */
	#no-more-tables table,
	#no-more-tables thead,
	#no-more-tables tbody,
	#no-more-tables th,
	#no-more-tables td,
	#no-more-tables tr {
		display: block;
	}

	/* Hide table headers (but not display: none;, for accessibility) */
	#no-more-tables thead tr {
		position: absolute;
		top: -9999px;
		left: -9999px;
	}

	#no-more-tables tr { border: 1px solid #ccc; }

	#no-more-tables td {
		/* Behave  like a "row" */
		border: none;
		border-bottom: 1px solid #eee;
		position: relative;
		padding-left: 50%;
		white-space: normal;
		text-align:left;
		font:Arial, Helvetica, sans-serif;
	}

	#no-more-tables td:before {
		/* Now like a table header */
		position: absolute;
		/* Top/left values mimic padding */
		top: 6px;
		left: 6px;
		width: 45%;
		padding-right: 10px;
		white-space: nowrap;
		text-align:left;

	}

	/*
	Label the data
	*/
	#no-more-tables td:before { content: attr(data-title); }
}
</style>
 </head>

<body bgcolor="#CCCCCC">
<div align="center">
<div class="container" style="width:100%;">
<div style="padding-top:30px">

        	<h2 style="padding-left:20px;padding-top:10px;padding-bottom:10px;background-color:#694489; margin-top:2px;color:#666;color:white"><?php echo $dynamic_subject." Information";?></h2>
</div>

<div id="no-more-tables">
  <table id="example" class="col-md-12 table-bordered table-striped table-condensed cf"  >

        	<thead>

        	<tr  style="background-color:#694489; color:#FFFFFF; height:30px;">
			
             <th width=15%>Sr. No.</th>
			 <th width=15%><?php echo $dynamic_subject." Code";?></th>
			 <th width=15%><?php echo $dynamic_subject." Name";?></th> 
			 <th width=15%>Image</th>
			 <th width=15%>Edit</th>
			 <th width=15%>Delete</th>
             </tr>

        	</thead>

             <?php $i=1;

 while($result=mysql_fetch_array($row)){
	 //print_r($result); exit;
?>
<tr>
<td data-title="Sr.No."><?php echo $i;  ?></td>

<td  data-title="Subject Code"><?php echo $result['Subject_Code'];?></td>
<td  data-title="Subject"><?php echo $result['subject'];?></td>
<?php if($result['image']!=''){ ?>
<td data-title="Game Image"><img style='width:10%' src="<?php echo $GLOBALS['URLNAME']."/core/subjectSportsImages/".$result['image']; ?>"/></td>

					<?php  }else {?>
						<td data-title="Games Image"><img style='width:10%' src="<?php $GLOBALS['URLNAME']."/Assets/images/avatar/avatar_2x.png" ?>"/></td>
					<?php } ?>



<td data-title="Edit" width="10%" align="center"><a href="edit_games_list.php?id=<?php echo $result['id'];  ?>" style="text-decoration:none" ><span class="glyphicon glyphicon-pencil"></span></a></td>



<td data-title="Delete" width="10%" align="center"><a style="text-decoration:none" onClick="confirmation(<?php echo $result['id']; ?> )" ><span class="glyphicon glyphicon-trash"></span></a></td>



</tr>
<?php  $i++;} ?>

        	</table>

</div>




</div>

</div>


</div>
</div>
</body>
</html>
