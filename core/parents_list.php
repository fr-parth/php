<?php
error_reporting(0);
include('scadmin_header.php');

$report="";
//Queries modified and pagination done by Pranali for bug SMC-3349
$sc_id=$_SESSION['school_id'];
//$webpagelimit = 100;
if (!($_GET['Search'])){

	if (isset($_GET["page"])){ $page  = mysql_real_escape_string($_GET["page"]); } else { $page=1; };  
	$start_from = ($page-1) * $webpagelimit;
		
	$sql=mysql_query("Select p.Id,p.Name,p.std_PRN,p.Phone,p.Occupation,p.FamilyIncome,s.std_name,s.std_Father_name,s.std_lastname,s.std_complete_name 
	from tbl_parent p left join tbl_student s 
	on p.std_PRN = s.std_PRN and p.school_id = s.school_id
	where p.school_id='$sc_id' ORDER BY p.Id desc LIMIT $start_from, $webpagelimit") or die("Could not Search!");	

	$sql1 =mysql_query("Select p.Id,p.Name,p.std_PRN,p.Phone,p.Occupation,p.FamilyIncome,s.std_name,s.std_Father_name,s.std_lastname,s.std_complete_name 
	from tbl_parent p left join tbl_student s 
	on p.std_PRN = s.std_PRN and p.school_id = s.school_id
	where p.school_id='$sc_id' ORDER BY p.Id desc");
	  
						
						$total_records = mysql_num_rows($sql1);
						$total_pages = ceil($total_records / $webpagelimit);
						
						if($total_pages == $_GET['page']){
							$webpagelimit = $total_records;
						}
						else{
							$webpagelimit = $start_from + $webpagelimit;
						}
}
else
{
		if (isset($_GET["spage"])){ 
			$spage  = mysql_real_escape_string($_GET["spage"]);
		} 
		else{
			$spage=1; 
		};  
	$start_from = ($spage-1) * $webpagelimit;

	$searchq=mysql_real_escape_string($_GET['Search']);
	$colname=mysql_real_escape_string($_GET['colname']);
		if ($colname != '' and $colname != 'Select')
		{			
			$sql=mysql_query("Select p.Id,p.Name,p.std_PRN,p.Phone,p.Occupation,p.FamilyIncome,s.std_name,s.std_Father_name,s.std_lastname,s.std_complete_name 
			from tbl_parent p left join tbl_student s 
			on p.std_PRN = s.std_PRN and p.school_id = s.school_id
			where p.school_id='$sc_id' AND $colname LIKE '%$searchq%' ORDER BY p.Id desc LIMIT $start_from, $webpagelimit") or die("Could not Search!");
					
			$sql1 =mysql_query("Select p.Id,p.Name,p.std_PRN,p.Phone,p.Occupation,p.FamilyIncome,s.std_name,s.std_Father_name,s.std_lastname,s.std_complete_name 
			from tbl_parent p left join tbl_student s 
			on p.std_PRN = s.std_PRN and p.school_id = s.school_id
			where p.school_id='$sc_id' AND $colname LIKE '%$searchq%' ORDER BY p.Id desc"); 
				
							$total_records = mysql_num_rows($sql1); 
							$total_pages = ceil($total_records / $webpagelimit);

		}else{
			
			$sql = mysql_query("Select p.Id,p.Name,p.std_PRN,p.Phone,p.Occupation,p.FamilyIncome,s.std_name,s.std_Father_name,s.std_lastname,s.std_complete_name 
			from tbl_parent p join tbl_student s 
			on p.std_PRN = s.std_PRN and p.school_id = s.school_id
			where p.school_id='$sc_id' AND (p.Id LIKE '%$searchq%' or
			p.Name LIKE '%$searchq%' or p.std_PRN LIKE '%$searchq%' or p.Phone LIKE '%$searchq%' or p.Occupation LIKE '%$searchq%' or p.FamilyIncome LIKE '%$searchq%' or s.std_name LIKE '%$searchq%' or s.std_Father_name LIKE '%$searchq%' or s.std_lastname LIKE '%$searchq%' or s.std_complete_name LIKE '%$searchq%') ORDER BY p.Id desc LIMIT $start_from, $webpagelimit") or die("Could not Search!");
							
			$sql1 = mysql_query("Select p.Id,p.Name,p.std_PRN,p.Phone,p.Occupation,p.FamilyIncome,s.std_name,s.std_Father_name,s.std_lastname,s.std_complete_name 
			from tbl_parent p join tbl_student s 
			on p.std_PRN = s.std_PRN and p.school_id = s.school_id
			where p.school_id='$sc_id' AND (p.Id LIKE '%$searchq%' or
			p.Name LIKE '%$searchq%' or p.std_PRN LIKE '%$searchq%' or p.Phone LIKE '%$searchq%' or p.Occupation LIKE '%$searchq%' or p.FamilyIncome LIKE '%$searchq%' or s.std_name LIKE '%$searchq%' or s.std_Father_name LIKE '%$searchq%' or s.std_lastname LIKE '%$searchq%' or s.std_complete_name LIKE '%$searchq%') ORDER BY p.Id desc"); 
							 
		  
							$total_records = mysql_num_rows($sql1);  
							$total_pages = ceil($total_records / $webpagelimit);
		}
				
			//below query use for search count
			 
						if($total_pages == $_GET['spage']){
							$webpagelimit = $total_records;
						}
						else{
							$webpagelimit = $start_from + $webpagelimit;
						}
					 
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta charset="utf-8">
<title>Smart Cookies</title>
<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
    <script src="code.jquery.com/jquery-1.10.2.js"></script>
    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>

    <script src="code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
	<script src="js/jquery.twbsPagination.js" type="text/javascript"></script>
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
			window.location.assign('parents_list.php?page='+page);
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
			window.location.assign('parents_list.php?colname=<?php echo $colname;?>&Search=<?php echo $searchq; ?>&spage='+page);
        });
    });
</script>
<?php }?>
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
		
		padding-right: 10px; 
		white-space: nowrap;
		
		
	}
 
	/*
	Label the data
	*/
	#no-more-tables td:before { content: attr(data-title); }
}
</style>
</head>

<script>
function confirmation(xxx) {
    var answer = confirm("Are you sure you want to delete")
    if (answer){
        
        window.location = "delete_parents_record.php?Id="+xxx;
    }
    else{
       
     }
}
</script>
<body bgcolor="#CCCCCC">
<div style="bgcolor:#CCCCCC">
<div>

</div>
<div class="container" style="padding:25px;" >
        	
            
            	<div style="padding:2px 2px 2px 2px;border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">
                   <div class="col-md-3 "  style="color:#700000 ;padding:5px;" >&nbsp;&nbsp;&nbsp;&nbsp;

					<a href="add_parents_detail.php">

                        <input type="submit" class="btn btn-primary" name="submit" value="Add Parent" style="width:150;font-weight:bold;font-size:14px;"/></a>
       			 </div>
                    
                    <div style="background-color:#F8F8F8 ;">
					
                    <div class="row">
                    <div class="col-md-3 "  style="color:#700000 ;padding:5px;" >&nbsp;&nbsp;&nbsp;&nbsp;
                   
               			 </div>
              			 <div class="col-md-6 " align="center"  >
                         	
                   				<h2>List of Parents</h2>
							<!--	<h5 align="center"><a href="Add_ParentSheet.php" >Add Excel Sheet</a></h5> -->
               			 </div>
                         
                     </div>
                  
                  <div class="row" style="padding:10px;" >

		<form style="margin-top:5px;">
			 <div class="col-md-4" style="width:17%;">
			 </div>
			<div class="col-md-2" style="font-weight:bold; margin-right:-36px;">Search By
			</div>
            <div class="col-md-2" style="width:17%;">
                <select name="colname" class="form-control">
                    <option selected="selected">Select</option>
					
                    <option value="p.Name"
					<?php if (($_GET['colname']) == "p.Name") {
                            echo "Parent Name"; ?> selected="selected" <?php } ?>>Parent Name</option>
                     							
					<option value="p.std_PRN"
					<?php if (($_GET['colname']) == "p.std_PRN") {
                            echo "Student PRN"; ?> selected="selected" <?php } ?>><?php echo $dynamic_student_prn; ?></option>
							
					<option value="s.std_complete_name"
					<?php if (($_GET['colname']) == "s.std_complete_name") {
                            echo "Student Name"; ?> selected="selected" <?php } ?>><?php echo $dynamic_student; ?> Name</option>
							
					<option value="p.Phone"
					<?php if (($_GET['colname']) == "p.Phone") {
                            echo "Phone"; ?> selected="selected" <?php } ?>>Phone</option>
							
					<option value="p.Occupation"
					<?php if (($_GET['colname']) == "p.Occupation") {
                            echo "Occupation"; ?> selected="selected" <?php } ?>>Occupation</option>
												
					<option value="p.FamilyIncome"
					<?php if (($_GET['colname']) == "p.FamilyIncome") {
                            echo "FamilyIncome"; ?> selected="selected" <?php } ?>>FamilyIncome</option>
											
					</select>
			</div>
			<div class="col-md-2" style="width:17%;">
				<input type="text" class="form-control" name="Search" value="<?php echo $searchq; ?>" placeholder="Search.." required> 
			</div>
			<div class="col-md-1" >
			<button type="submit" value="Search" class="btn btn-primary">Search</button>
			</div>
			<div class="col-md-1" >
			<input type="button" class="btn btn-info" value="Reset" onclick="window.open('parents_list.php','_self')" />
			</div>
					<!-- <div style="margin-left: 800px;">
						<input type="text" name="Search" value="<?php echo $searchq; ?>" placeholder="Search..">
						<input type="submit" value="Search">
						<input type="button" value="Reset" onclick="window.open('beneficiary_list.php','_self')" />
					</div> -->
		</form>
		 </div> 
       <!-- <div id="show" >
			?php if (!($_GET['Search']))
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

		 
                  
               <div class="row">

               <div class="col-md-2">
               </div>
			   
			   <?php
		if (isset($_GET['Search']))
		{
			
			$count=mysql_num_rows($sql);
			if($count == 0)
			{
				
				echo "<script>$('#show').css('display','none');</script><div style='margin-top:20px;' align='center'><font color='Red'><b>There Was No Search Result</b></font></div>";	
			}
			else
			{
			?>
			   
              <div class="col-md-12" id="no-more-tables" >
              
                    <table id="example" class="display" width="100%" cellspacing="0">
                     <thead>
                    	<tr ><!-- Camel casing done for Sr. No. by Pranali -->
						<th style="width:50px;" ><center>Sr. No.</center></th>						
						<th style="width:40px;" ><center>Parent Name</center></th>	
                        <th style="width:150px;" ><center>Student PRN</center></th>					
						<th style="width:350px;" ><center>Student Name</center></th>
						
						
						<th style="width:50px;" ><center>Phone</center></th>
						<th style="width:100px;" ><center>Occupation</center></th>
						<th style="width:100px;" ><center>FamilyIncome</center></th>

						<!--Added Edit And Delete By Dhanashri_Tak -->

						<th style="width:100px;" ><center>Edit</center></th>
                        <th  style="width:100px;" ><center> Delete </center></th>
						<!-- End-->
					</tr>
					</thead>
				<tbody>
                <?php
									
					$i = 1;
					$i = ($start_from +1);?>
                  <?php 
				  while($row=mysql_fetch_array($sql)){
				  ?>
                 <tr onmouseover="this.style.cursor='pointer';this.style.textDecoration='underline';this.style.color='dodgerblue'"

				  onmouseout="this.style.textDecoration='none';this.style.color='black';" 

				  onclick="window.location='#'" 

				  style="cursor: pointer; text-decoration: underline; color: dodgerblue; background-color: rgb(239, 243, 251);height:30px;color:#808080;">
				  
                    <td data-title="Sr.No" style="width:50px;"><center><?php echo $i;?></center></td>
					<td data-title="Fathers Name" style="width:250px;"><center><?php echo ucwords(strtolower($row['Name']));?></center> </td>
                    <td data-title="Student PRN" style="width:50px;" ><center><?php echo $row['std_PRN'];?> </center></td>

					<?php 
									
					if($row['std_complete_name']=="")
					{
						$std_name=ucwords(strtolower($row['std_name']))." ".ucwords(strtolower($row['std_Father_name']))." ".ucwords(strtolower($row['std_lastname']));
					}
					
					else
					{
						$std_name=ucwords(strtolower($row['std_complete_name']));
					}
					
					
                    ?>
					<td data-title="Student Name" style="width:420px;"><center><?php echo $std_name;?></center> </td>	
					
					<td data-title="Phone" style="width:50px;"><center><?php echo $row['Phone'];?></center> </td>
					
					<td data-title="Occupation" style="width:100px;"><center><?php echo $row['Occupation'];?></center> </td>
					
                    <td data-title="Family Income" style="width:100px;"><center><?php echo $row['FamilyIncome'];?></center> </td>

					<!--Added Edit And Delete By Dhanashri_Tak Intern -->

                    <td style="width:100px;">
					<center><?php $id = $row['Id']; ?>
                    <a href="edit_parents_record.php?id=<?php echo base64_encode($row['Id']); ?>" style="width:100px;"> <span class="glyphicon glyphicon-pencil"></span></a>
                 	</center></td> 
										
                    <td style="width:100px;">
                    <center> <a onClick="confirmation(<?php echo $row['Id']; ?>)"><span class="glyphicon glyphicon-trash"></span></a></b></center></td>
					<!--End-->
                 </tr>
                <?php $i++;?>
                 <?php }?>
                  
                  </tbody>
                  </table>
				   </div>
				   
		<div class="container" align="center">
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
		<div class="col-md-12" id="no-more-tables" >
              
        <table id="example" class="display" width="100%" cellspacing="0">
                     <thead>
                    	<tr ><!-- Camel casing done for Sr. No. by Pranali -->
						<th style="width:50px;" ><center>Sr. No.</center></th>						
						<th style="width:40px;" ><center>Parent Name</center></th>	
                        <th style="width:150px;" ><center>Student PRN</center></th>					
						<th style="width:350px;" ><center>Student Name</center></th>
						
						
						<th style="width:50px;" ><center>Phone</center></th>
						<th style="width:100px;" ><center>Occupation</center></th>
						<th style="width:100px;" ><center>FamilyIncome</center></th>

						<!--Added Edit And Delete By Dhanashri_Tak -->

						<th style="width:100px;" ><center>Edit</center></th>
                        <th  style="width:100px;" ><center> Delete </center></th>
						<!-- End-->
					</tr>
					</thead>
				<tbody>
                <?php
									
					$i = 1;
					$i = ($start_from +1);?>
                  <?php 
				  while($row=mysql_fetch_array($sql)){
				  ?>
                 <tr onmouseover="this.style.cursor='pointer';this.style.textDecoration='underline';this.style.color='dodgerblue'"

				  onmouseout="this.style.textDecoration='none';this.style.color='black';" 

				  onclick="window.location='#'" 

				  style="cursor: pointer; text-decoration: underline; color: dodgerblue; background-color: rgb(239, 243, 251);height:30px;color:#808080;">
				  
                    <td data-title="Sr.No" style="width:50px;"><center><?php echo $i;?></center></td>
					<td data-title="Fathers Name" style="width:250px;"><center><?php echo ucwords(strtolower($row['Name']));?></center> </td>
                    <td data-title="Student PRN" style="width:50px;" ><center><?php echo $row['std_PRN'];?> </center></td>

					<?php 
									
					if($row['std_complete_name']=="")
					{
						$std_name=ucwords(strtolower($row['std_name']))." ".ucwords(strtolower($row['std_Father_name']))." ".ucwords(strtolower($row['std_lastname']));
					}
					
					else
					{
						$std_name=ucwords(strtolower($row['std_complete_name']));
					}
					
					
                    ?>
					<td data-title="Student Name" style="width:420px;"><center><?php echo $std_name;?></center> </td>	
					
					<td data-title="Phone" style="width:50px;"><center><?php echo $row['Phone'];?></center> </td>
					
					<td data-title="Occupation" style="width:100px;"><center><?php echo $row['Occupation'];?></center> </td>
					
                    <td data-title="Family Income" style="width:100px;"><center><?php echo $row['FamilyIncome'];?></center> </td>

					<!--Added Edit And Delete By Dhanashri_Tak Intern -->

                    <td style="width:100px;">
					<center><?php $id = $row['Id']; ?>
                    <a href="add_parents_detail.php?id=<?php echo base64_encode($row['Id']); ?>" style="width:100px;"> <span class="glyphicon glyphicon-pencil"></span></a>
                 	</center></td> 
										
                    <td style="width:100px;">
                    <center> <a onClick="confirmation(<?php echo $row['Id']; ?>)"><span class="glyphicon glyphicon-trash"></span></a></b></center></td>
					<!--End-->
                 </tr>
                <?php $i++;?>
                 <?php }?>
                  
                  </tbody>
                  </table>
				   </div>
				   
		<div class="container" align="center">
		<nav aria-label="Page navigation">
			<ul class="pagination" id="pagination"></ul>
		</nav>
		</div>
		<?php } ?>

                 
                  </div>
                <!--changes end -->  
                  
                   <div class="row" style="padding:5px;">
                   <div class="col-md-4">
               </div>
                  <div class="col-md-3 "  align="center">
                   
                   
                   </div>
                    </div>
                     <div class="row" >
                     <div class="col-md-4">
                     </div>
                      <div class="col-md-3" style="color:#FF0000;" align="center">
                      
                      <?php echo $report;?>
               			</div>
                 
                    </div>
               </div>
               </div>
	</body>
</html>