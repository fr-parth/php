<?php
include("cookieadminheader.php");

//Change in query done by Pranali
//$sql="SELECT Id,Name,Address,email_id,Phone FROM tbl_parent  order by Id desc";
//$row=mysql_query($sql);

//Change in perfomance issue done by sachin 
//$webpagelimit = 10;  
/*if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };  
$start_from = ($page-1) * $webpagelimit;
$s="SELECT tp.Id,tp.Name,tp.Address,tp.email_id,tp.Phone,(SELECT GROUP_CONCAT(std_name) FROM tbl_student st where st.parent_id=tp.Id )as child_name,(SELECT sum(sc_point) FROM tbl_student_point sp where sp.sc_teacher_id=tp.Id and sp.sc_entites_id='106')as total_assigned from tbl_parent as tp order by tp.Id desc LIMIT $start_from, $webpagelimit";

$sql=mysql_query("SELECT tp.Id,tp.Name,tp.Address,tp.email_id,tp.Phone,(SELECT GROUP_CONCAT(std_name) FROM tbl_student st where st.parent_id=tp.Id )as child_name,(SELECT sum(sc_point) FROM tbl_student_point sp where sp.sc_teacher_id=tp.Id and sp.sc_entites_id='106')as total_assigned from tbl_parent as tp order by tp.Id desc LIMIT $start_from, $webpagelimit");
*/
if (!($_GET['Search'])){

if (isset($_GET["page"])){ $page  = mysql_real_escape_string($_GET["page"]); } else { $page=1; };  
$start_from = ($page-1) * $webpagelimit;
	
$sql=mysql_query("SELECT tp.Id,tp.Name,tp.Address,tp.email_id,tp.Phone,(SELECT GROUP_CONCAT(std_name) FROM tbl_student st where st.parent_id=tp.Id )as child_name,(SELECT sum(sc_point) FROM tbl_student_point sp where sp.sc_teacher_id=tp.Id and sp.sc_entites_id='106')as total_assigned from tbl_parent as tp order by tp.Id desc LIMIT $start_from, $webpagelimit");	

$sql1 ="select COUNT(id),tp.Id,tp.Name,tp.Address,tp.email_id,tp.Phone,(SELECT GROUP_CONCAT(std_name) FROM tbl_student st where st.parent_id=tp.Id )as child_name,(SELECT sum(sc_point) FROM tbl_student_point sp where sp.sc_teacher_id=tp.Id and sp.sc_entites_id='106')as total_assigned from tbl_parent as tp order by tp.Id desc";  
					$rs_result = mysql_query($sql1);  
					$row1 = mysql_fetch_row($rs_result);  
					$total_records = $row1[0];  
					$total_pages = ceil($total_records / $webpagelimit);
					if($total_pages == $_GET['page']){
					$webpagelimit = $total_records;
					}else{
					$webpagelimit = $start_from + $webpagelimit;
					}
}else
{
	if (isset($_GET["spage"])){ $spage  = mysql_real_escape_string($_GET["spage"]); } else { $spage=1; };  
$start_from = ($spage-1) * $webpagelimit;

$searchq=mysql_real_escape_string($_GET['Search']);
$colname=mysql_real_escape_string($_GET['colname']);
	if ($colname != ''and $colname != 'Select')
	{
		if ($colname =='total_assigned')
		{	
			$query1=mysql_query("SELECT tp.Id,tp.Name,tp.Address,tp.email_id,tp.Phone,tp.balance_blue_points,tp.assigned_blue_points,tp.balance_points,(SELECT GROUP_CONCAT(std_name) FROM tbl_student st where st.parent_id=tp.Id )as child_name,(SELECT sum(sc_point) FROM tbl_student_point sp where sp.sc_teacher_id=tp.Id and sp.sc_entites_id='106')as total_assigned from tbl_parent as tp having $colname LIKE '%$searchq%' order by tp.Id desc LIMIT $start_from, $webpagelimit") or die("could not Search!");
					
			$sql1 ="SELECT tp.Id,tp.Name,tp.Address,tp.email_id,tp.Phone,tp.balance_blue_points,tp.assigned_blue_points,tp.balance_points,(SELECT GROUP_CONCAT(std_name) FROM tbl_student st where st.parent_id=tp.Id )as child_name,(SELECT sum(sc_point) FROM tbl_student_point sp where sp.sc_teacher_id=tp.Id and sp.sc_entites_id='106')as total_assigned from tbl_parent as tp having $colname LIKE '%$searchq%' order by tp.Id desc"; 
					$rs_result = mysql_query($sql1);  
					$row1 = mysql_num_rows($rs_result);  
					$total_records = $row1;  
					$total_pages = ceil($total_records / $webpagelimit);
		
		}else if ($colname =='child_name')
		{	
			$query1=mysql_query("SELECT tp.Id,tp.Name,tp.Address,tp.email_id,tp.Phone,tp.balance_blue_points,tp.assigned_blue_points,tp.balance_points,(SELECT GROUP_CONCAT(std_name) FROM tbl_student st where st.parent_id=tp.Id )as child_name,(SELECT sum(sc_point) FROM tbl_student_point sp where sp.sc_teacher_id=tp.Id and sp.sc_entites_id='106')as total_assigned from tbl_parent as tp having $colname LIKE '%$searchq%' order by tp.Id desc LIMIT $start_from, $webpagelimit") or die("could not Search!");
					
			$sql1 ="SELECT tp.Id,tp.Name,tp.Address,tp.email_id,tp.Phone,tp.balance_blue_points,tp.assigned_blue_points,tp.balance_points,(SELECT GROUP_CONCAT(std_name) FROM tbl_student st where st.parent_id=tp.Id )as child_name,(SELECT sum(sc_point) FROM tbl_student_point sp where sp.sc_teacher_id=tp.Id and sp.sc_entites_id='106')as total_assigned from tbl_parent as tp having $colname LIKE '%$searchq%' order by tp.Id desc"; 
					$rs_result = mysql_query($sql1);  
					$row1 = mysql_num_rows($rs_result);  
					$total_records = $row1;  
					$total_pages = ceil($total_records / $webpagelimit);
		
		}else
		{
			$query1=mysql_query("SELECT tp.Id,tp.Name,tp.Address,tp.email_id,tp.Phone,tp.balance_blue_points,tp.assigned_blue_points,tp.balance_points,(SELECT GROUP_CONCAT(std_name) FROM tbl_student st where st.parent_id=tp.Id )as child_name,(SELECT sum(sc_point) FROM tbl_student_point sp where sp.sc_teacher_id=tp.Id and sp.sc_entites_id='106')as total_assigned from tbl_parent as tp where $colname LIKE '%$searchq%' order by tp.Id desc LIMIT $start_from, $webpagelimit") or die("could not Search!");
					
			$sql1 ="SELECT tp.Id,tp.Name,tp.Address,tp.email_id,tp.Phone,tp.balance_blue_points,tp.assigned_blue_points,tp.balance_points,(SELECT GROUP_CONCAT(std_name) FROM tbl_student st where st.parent_id=tp.Id )as child_name,(SELECT sum(sc_point) FROM tbl_student_point sp where sp.sc_teacher_id=tp.Id and sp.sc_entites_id='106')as total_assigned from tbl_parent as tp where $colname LIKE '%$searchq%' order by tp.Id desc"; 
					$rs_result = mysql_query($sql1);  
					$row1 = mysql_num_rows($rs_result);  
					$total_records = $row1;  
					$total_pages = ceil($total_records / $webpagelimit);
			}

	}else{
			$query1=mysql_query("SELECT tp.Id,tp.Name,tp.Address,tp.email_id,tp.Phone,tp.balance_blue_points,tp.assigned_blue_points,tp.balance_points,st.std_name,st.parent_id from  tbl_parent tp left join tbl_student st on st.parent_id = tp.Id where (Name LIKE '%$searchq%' or Address LIKE '%$searchq%' or email_id LIKE '%$searchq%' or Phone LIKE '%$searchq%' or std_name LIKE '%$searchq%' or parent_id LIKE '%$searchq%') order by tp.Id desc LIMIT $start_from, $webpagelimit") or die("could not Search!");
			
			$sql1 ="select tp.Id,tp.Name,tp.Address,tp.email_id,tp.Phone,tp.balance_blue_points,tp.assigned_blue_points,tp.balance_points,st.std_name,st.parent_id from  tbl_parent tp left join tbl_student st on st.parent_id = tp.Id where (Name LIKE '%$searchq%' or Address LIKE '%$searchq%' or email_id LIKE '%$searchq%' or Phone LIKE '%$searchq%' or std_name LIKE '%$searchq%' or parent_id LIKE '%$searchq%') order by tp.Id desc "; 
			
		
					$rs_result = mysql_query($sql1);  
					$row1 = mysql_num_rows($rs_result);  
					$total_records = $row1;  
					$total_pages = ceil($total_records / $webpagelimit);
		}
			
		//below query use for search count		

					if($total_pages == $_GET['spage']){
					$webpagelimit = $total_records;
					}else{
					$webpagelimit = $start_from + $webpagelimit;
					}
					 
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>School Information</title>
<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css"> 
<link rel="stylesheet" href="css/bootstrap.min.css">
 <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css"> 
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<!-- <script src="js/jquery-1.11.1.min.js"></script> --> 
 <script src="js/jquery.dataTables.min.js"></script>
  <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script> 
   <script src="js/jquery.twbsPagination.js" type="text/javascript"></script>
  <!-- <script>
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
  </script> -->
 
    <script>
    $(document).ready(function() {
    $('#example').dataTable( {
	"paging":   false,
	"info":false,
	"searching": false,
     "scrollCollapse": true
    } );
} );
    </script>
<?php if (!($_GET['Search'])){?>
<script type="text/javascript">
    $(function () {
		var total_pages = <?php echo $total_pages; ?> ;
		var start_page = <?php echo $page; ?> ;
        window.pagObj = $('#pagination').twbsPagination({
            totalPages: total_pages,
            visiblePages: 10,
			startPage: start_page,
            onPageClick: function (event, page) {
                console.info(page + ' (from options)'); 
            }
        }).on('page', function (event, page) {
            console.info(page + '(from event listening)');
			window.location.assign('parent_list.php?page='+page);
        });
    });
</script>
<?php }else{
	?>
<script type="text/javascript">
    $(function () {
		var total_pages = <?php echo $total_pages; ?> ;
		var start_page = <?php echo $spage; ?> ;
        window.pagObj = $('#pagination').twbsPagination({
            totalPages: total_pages,
            visiblePages: 10,
			startPage: start_page,
            onPageClick: function (event, page) {
                console.info(page + ' (from options)'); 
            }
        }).on('page', function (event, page) {
            console.info(page + '(from event listening)');
			window.location.assign('parent_list.php?colname=<?php echo $colname;?>&Search=<?php echo $searchq; ?>&spage='+page);
        });
    });
</script>
<?php }?>
<!---Changes for delete Parent By Dhanashri_Tak--->
    <script>
   function delete_cookie_parent(id){
	if(window.confirm("Do you want to delete Record")){
		$.ajax({
		url: "delete_cookie_parent.php",
		type:'post',
		data:({id:id}),
		success: function(result){
			if(result == true){
				alert('Record Deleted Successfully');
				 //window.location.reload();
				$("#example").load(window.location + " #example");
			   // callajax();
			}
			else {
				alert('Error In Deletion');
			}
		}
		})
  }
}
</script>
 <!--End-->
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
<div align="center" class="col-md-12">
<div style="padding-top:50px;">
        	<h2 style="padding-left:20px; margin-top:2px;color:white;background-color:#694489;padding-top:10px;padding-bottom:10px">Parent Information</h2>
</div>
	<!-- <form style="margin-top:5px;">
					<div style="margin-left: 800px;">
						<input type="text" name="Search" placeholder="Search..">
						<input type="submit" value="Search">		
					</div>
	</form> -->
	<div class='row'>
		<form style="margin-top:5px;">
			 <div class="col-md-4" style="width:17%;">
			 </div>
			<div class="col-md-2" style="font-weight:bold; margin-right:-36px;">Search By
			</div>
            <div class="col-md-2" style="width:17%;">
              <select name="colname" class="form-control">
                    <option selected="selected">Select</option>
                    <option value="tp.Id"
					<?php if (($_GET['colname']) == "tp.Id") {
                            echo $_GET['colname']; ?> selected="selected" <?php } ?>>Parent ID</option>
                     <option value="tp.Name"
					<?php if (($_GET['colname']) == "tp.Name") {
                            echo $_GET['colname']; ?> selected="selected" <?php } ?>>Parent Name</option>
					<option value="tp.Address"
					<?php if (($_GET['colname']) == "tp.Address") {
                            echo $_GET['colname']; ?> selected="selected" <?php } ?>>Address</option>
					<option value="tp.email_id"
					<?php if (($_GET['colname']) == "tp.email_id") {
                            echo $_GET['colname']; ?> selected="selected" <?php } ?>>Email ID</option>
					<option value="tp.Phone"
					<?php if (($_GET['colname']) == "tp.Phone") {
                            echo $_GET['colname']; ?> selected="selected" <?php } ?>>Phone</option>
					<option value="child_name"
					<?php if (($_GET['colname']) == "child_name") {
                            echo $_GET['colname']; ?> selected="selected" <?php } ?>>Children Name</option>
					<option value="tp.assigned_blue_points"
					<?php if (($_GET['colname']) == "tp.assigned_blue_points") {
                            echo $_GET['colname']; ?> selected="selected" <?php } ?>>Assigned Blue Points</option>
					<option value="tp.balance_blue_points"
					<?php if (($_GET['colname']) == "tp.balance_blue_points") {
                            echo $_GET['colname']; ?> selected="selected" <?php } ?>>Balance  Blue Points</option>
					<option value="tp.balance_points"
					<?php if (($_GET['colname']) == "tp.balance_points") {
                            echo $_GET['colname']; ?> selected="selected" <?php } ?>>Assigned Green Points</option>
					<option value="total_assigned"
					<?php if (($_GET['colname']) == "total_assigned") {
                            echo $_GET['colname']; ?> selected="selected" <?php } ?>>Balance  Green Points</option>
                </select>
			</div>
			<div class="col-md-2" style="width:17%;">
				<input type="text" class="form-control" name="Search" value="<?php echo $searchq; ?>" placeholder="Search.." required> 
			</div>
			<div class="col-md-1" >
			<button type="submit" value="Search" class="btn btn-primary">Search</button>
			</div>
			<div class="col-md-1" >
			<input type="button" class="btn btn-info" value="Reset" onclick="window.open('parent_list.php','_self')" />
			</div>
					<!-- <div style="margin-left: 800px;">
						<input type="text" name="Search" value="<?php echo $searchq; ?>" placeholder="Search..">
						<input type="submit" value="Search">
						<input type="button" value="Reset" onclick="window.open('beneficiary_list.php','_self')" />
					</div> -->
		</form>
		 </div> 
		 <!-- <div id="show" >
		 		<?php if (!($_GET['Search']))
		 			{
		 				if ($webpagelimit >$total_records){ $webpagelimit=$total_records;}
		 				echo "<div style='margin-top:5px;'><font color='blue'><b style='margin-left:600px;'>Now showing ".($start_from +1)." to ".($webpagelimit)." records out of ".$total_records. " records.</b></font></div>";
		    }else
		 			{
		 				if ($webpagelimit >$total_records){ $webpagelimit=$total_records;}
		 				echo "<div style='margin-top:5px;'><font color='blue'><b style='margin-left:600px;'>Now showing ".($start_from +1)." to ".($webpagelimit)." records out of ".($total_records). " records.</b></font></div>";
		 			}
		 			?>
		 </div> -->
	<?php  
			/*		$sql1 ="select COUNT(Id),Name,Address,email_id,Phone FROM tbl_parent order by Id desc";  
					$rs_result = mysql_query($sql1);  
					$row1 = mysql_fetch_row($rs_result);  
					$total_records = $row1[0];  
					$total_pages = ceil($total_records / $webpagelimit);  
					if($total_pages == $_GET['page']){
					$webpagelimit = $total_records;
					}else{
					$webpagelimit = $start_from + $webpagelimit;
					}
					$pagLink =""; 
					for ($i=1; $i<=$total_pages; $i++) { 
						$mypage = !empty($_GET['page'])?$_GET['page']:1;
						if($i == $mypage){
							$class = 'active';
							$selected = "selected";
							$pagLink .= "<option value='parent_list.php?page=".$i."'".$selected." >  ".$i.''." </option> ";
						}else{
							$class = '';
							   // $pagLink .= " <option value='index.php?page=".$i."'".$selected." ><a class='$class' href='index.php?page=".$i."'>".$i.''." </a></option> "; 
							   //$pagLink .="
							   $pagLink .= "<option value='parent_list.php?page=".$i."'>  ".$i.''." </option> "; 
						}		   
					};
					echo "<div class='pagination'  style='margin-top:5px;'>";
					
					echo "<form><select onchange='location = this.value;' style='margin-left:100px;' >";
					echo $pagLink ."</select>";
					echo "<font color='blue'><b style='margin-left:10px;'>Go to page number</b>"; 
					echo "<b style='margin-left:400px;'>Now showing ".($start_from +1)." to ".($webpagelimit)." records out of ".$total_records. " records.</b></font></form></div>";
					*/?>
		<?php
		if (isset($_GET['Search']))
		{
			/* 
			$searchq=$_GET['Search'];
			//$q1="SELECT tp.Id,tp.Name,tp.Address,tp.email_id,tp.Phone,st.std_name,st.parent_id from  tbl_parent tp left join tbl_student st on st.parent_id = tp.Id where (Name LIKE '$searchq%' or Address LIKE '$searchq%' or email_id LIKE '$searchq%' or Phone LIKE '$searchq%' or std_name LIKE '$searchq%' or parent_id LIKE '%$searchq%') order by tp.Id desc";

			$query1=mysql_query("SELECT tp.Id,tp.Name,tp.Address,tp.email_id,tp.Phone,tp.balance_blue_points,tp.assigned_blue_points,tp.balance_points,st.std_name,st.parent_id from  tbl_parent tp left join tbl_student st on st.parent_id = tp.Id where (Name LIKE '%$searchq%' or Address LIKE '%$searchq%' or email_id LIKE '$searchq%' or Phone LIKE '$searchq%' or std_name LIKE '$searchq%' or parent_id LIKE '%$searchq%') order by tp.Id desc") or die("could not Search!"); 
			*/

			$count=mysql_num_rows($query1);
			if($count == 0){
				echo "<script>$('#show').css('display','none');</script><div style='margin-top:20px;'><font color='Red'><b>There Was No Search Result</b></font></div>";	
			}
			else
			{
			?>
			<div id="no-more-tables" style="padding-top:20px;">
				<table id="example" class="col-md-12 table-bordered "  align="center" >
							<thead>
							<tr  style="background-color:#694489; color:#FFFFFF; height:30px;">
								<th>Sr. No.</th>
								<th>Parent ID</th>
								<th><center>Parent Name</center></th>
								<th><center>Address</center></th>
								<th>Email ID</th>
								<th> Phone</th>
								<th>Children Name</th>
								<th>Assigned Blue Points</th>
								<th>Balance  Blue Points</th>
								<th>Assigned Green Points</th>
								<th>Balance  Green Points</th>
								<th>Edit</th>
								<th>Delete</th>
							</tr>
							
							</thead>
							<?php $i=1;
							$i = ($start_from +1);
							 while($result=mysql_fetch_array($query1)){
							 $id=$result['Id'];?>
						<tr>
							<td data-title="Sr.No."><?php echo $i;   ?></td>
							<td data-title="Parent ID"><?php echo $result['Id']; ?></td>
							<td data-title="Parent Name"><?php echo ucwords($result['Name']); ?></td>
							<td data-title="Address"><?php echo ucwords($result['Address']);?></td>
							<td data-title="Email ID"><?php echo $result['email_id'];?></td>
							<td data-title="Phone No."><?php echo $result['Phone'];?></td>
							 <td data-title="Child Name"><?php echo $result['child_name'];?></td>
							<!-- <?php
							 $sql2="SELECT std_name FROM tbl_student  where parent_id='$id'";
									$row_student=mysql_query($sql2);
									$count=mysql_num_rows($row_student);
									$j=1;
									?>
									<?php
									while($results_student=mysql_fetch_array($row_student)){
									if($count==1 || $j==$count)
									{?><?php echo $results_student['std_name'];?></td><?php }
									else{
								?>
								<?php echo $results_student['std_name'].",";?>
									<?php } $j++;}?></td> -->
							<td data-title="Assigned blue Points"><?php echo $result['assigned_blue_points'];?></td>
							<td data-title="Balance blue Points"><?php echo $result['balance_blue_points'];?></td>
							
							<td data-title="Assigned green Points"><?php echo $result['balance_points'];?></td>
							<td data-title="Balance green points"><?php echo $result['total_assigned'];?></td>
							<!--<td data-title="Edit" width="10%"  ><button type="button" class="btn btn-default" style=''  data-toggle="modal" data-target="#exampleModal" data-whatever="<?php echo  $result[''];?>"><span class="glyphicon glyphicon-pencil"></span></button><a style="text-decoration:none"></td>
							<td data-title="Delete" width="10%" ><button type="button" class="btn btn-default" style=''  onclick="delete_social_media(<?php echo $result[''];?>)"><span class="glyphicon glyphicon-trash"></span></button></td>-->
							
							<!-- by sachin
							
							<?php
							 $sql2="SELECT sum(sc_point) as total_assigned FROM tbl_student_point  where sc_teacher_id='$id' and sc_entites_id='106'";
									$row_parent=mysql_query($sql2);
									$results_parent=mysql_fetch_array($row_parent);
									if($results_parent['total_assigned']==0){
									$results_parent['total_assigned']=0;?>
									<?php echo $results_parent['total_assigned'];?></td>
								<?php
								}
								else
								{
								?>
								 <?php echo $results_parent['total_assigned'];?></td>
							<?php 	}?> -->

							<!--added edit and delete option by Dhanashri-->
							 <!--<a href="edit_cookie_parent.php?parent=<?= $id; ?>"-->
							 <td><a href="edit_cookie_parent.php?parent=<?php echo base64_encode($id); ?>"
																	   style="text-decoration:none">
																	<span class="glyphicon glyphicon-pencil"></span>
								  </a></td>
							<!--<td><a onClick="confirmation(<php echo $id; ?>)"
																	   style="text-decoration:none">
																		<span class="glyphicon glyphicon-trash"></span>
																	</a></td>-->
								<td data-title="Delete" width="10%" ><button type="button" class="btn btn-default" style=""  onclick="delete_cookie_parent(<?php echo $id;?>)"><span class="glyphicon glyphicon-trash"></span></button></td>
							<!--End-->
						</tr>
							<?php  $i++;} ?>
				</table>
			</div>
				<div class="container" align ="center">
					<nav aria-label="Page navigation">
					  <ul class="pagination" id="pagination"></ul>
					</nav>
				</div>
			<?php
			}
		}
		else
		{			
		?>
	<div id="no-more-tables" style="padding-top:20px;">
		<table id="example" class="col-md-12 table-bordered " align="center" >
					<!-- <tr><?php echo $s; ?></tr> -->
					<thead>
					<tr>
						<th>Sr.No.</th>
						<th>Parent ID</th>
						<th><center>Parent Name</center></th>
						<th><center>Address</center></th>
						<th>Email ID</th>
						<th> Phone</th>
						<th>Children Name</th>
						<th>Assigned Blue Points</th>
						<th>Balance  Blue Points</th>
						<th>Assigned Green Points</th>
						<th>Balance  Green Points</th>
						<th>Edit</th>
						<th>Delete</th>
					</tr>
					</thead>
					<?php $i=1;
		
					$i = ($start_from +1);
					 while($result=mysql_fetch_array($sql)){
					 $id=$result['Id'];?>
				<tr>
					<td data-title="Sr.No."><?php echo $i;   ?></td>
					<td data-title="Parent ID"><?php echo $result['Id']; ?></td>
					<td data-title="Parent Name"><?php echo ucwords($result['Name']); ?></td>
					<td data-title="Address"><?php echo ucwords($result['Address']);?></td>
					<td data-title="Email ID"><?php echo $result['email_id'];?></td>
					<td data-title="Phone No."><?php echo $result['Phone'];?></td>
					<td data-title="Child Name"><?php echo $result['child_name'];?></td>
					<!-- <td data-title="Child Name">
					<?php
					$sql2="SELECT std_name FROM tbl_student  where parent_id='$id'";
							$row_student=mysql_query($sql2);
							$count=mysql_num_rows($row_student);
							$j=1;
							?>
							<?php
							while($results_student=mysql_fetch_array($row_student)){
							if($count==1 || $j==$count)
							{?><?php echo $results_student['std_name'];?></td><?php }
							else{
						?>
						<?php echo $results_student['std_name'].",";?>
							<?php } $j++;}?></td> -->
					<td data-title="Assigned blue Points"><?php echo $result['assigned_blue_points'];?></td>
					<td data-title="Balance blue Points"><?php echo $result['balance_blue_points'];?></td>
					
					<td data-title="Assigned green Points"><?php echo $result['balance_points'];?></td>
					<td data-title="Balance green points">
					<!--<td data-title="Edit" width="10%"  ><button type="button" class="btn btn-default" style=''  data-toggle="modal" data-target="#exampleModal" data-whatever="<?php echo  $result[''];?>"><span class="glyphicon glyphicon-pencil"></span></button><a style="text-decoration:none"></td>
					<td data-title="Delete" width="10%" ><button type="button" class="btn btn-default" style=''  onclick="delete_social_media(<?php echo $result[''];?>)"><span class="glyphicon glyphicon-trash"></span></button></td>-->
					<!-- <?php
					 $sql2="SELECT sum(sc_point) as total_assigned FROM tbl_student_point  where sc_teacher_id='$id' and sc_entites_id='106'";
							$row_parent=mysql_query($sql2);
							$results_parent=mysql_fetch_array($row_parent);
							if($results_parent['total_assigned']==0){
							$results_parent['total_assigned']=0;?>
							<?php echo $results_parent['total_assigned'];?></td>
						<?php
						}
						else
						{
						?> -->
						 <?php echo $result['total_assigned'];?></td>
					   <!-- <?php }?> -->
					<!--added edit and delete option by Dhanashri-->
					 <!--<a href="edit_cookie_parent.php?parent=<?= $id; ?>"-->
					 <td><a href="edit_cookie_parent.php?parent=<?php echo base64_encode($id); ?>"
															   style="text-decoration:none">
															<span class="glyphicon glyphicon-pencil"></span>
						  </a></td>
					<!--<td><a onClick="confirmation(<php echo $id; ?>)"
															   style="text-decoration:none">
																<span class="glyphicon glyphicon-trash"></span>
															</a></td>-->
						<td data-title="Delete" width="10%" ><button type="button" class="btn btn-default" style=""  onclick="delete_cookie_parent(<?php echo $id;?>)"><span class="glyphicon glyphicon-trash"></span></button></td>
					<!--End-->
				</tr>
					<?php  $i++;} ?>
		</table>
	</div>
				<div class="container" align ="center">
					<nav aria-label="Page navigation">
					  <ul class="pagination" id="pagination"></ul>
					</nav>
				</div>
<?php } ?>

</div>
<!-- </div>
</div> -->
</body>
</html>