<?php include('Parent_header.php');
$id=$_SESSION['id'];?>

<!doctype html>
<html lang="en-US">
<head>
  <meta charset="utf-8">
  <meta http-equiv="Content-Type" content="text/html">
  <title>Simple Table Sorting with jQuery - Treehouse Demo</title>
  <meta name="author" content="Jake Rocheleau">
  <link rel="shortcut icon" href="http://d15dxvojnvxp1x.cloudfront.net/assets/favicon.ico">
  <link rel="icon" href="http://d15dxvojnvxp1x.cloudfront.net/assets/favicon.ico">
  <link rel="stylesheet" type="text/css" media="all" href="css/sorted_table.css">
  <script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
  <script type="text/javascript" src="js/jquery.tablesorter.min.js"></script>
  <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
 <link rel="stylesheet" href="css/bootstrap.min.css">

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
<style>

div.pagination {
	padding: 3px;
	margin: 3px;
}

div.pagination a {
	padding: 2px 5px 2px 5px;
	margin: 2px;
	border: 1px solid #AAAADD;
	
	text-decoration: none; /* no underline */
	color: #000099;
}
div.pagination a:hover, div.pagination a:active {
	border: 1px solid #000099;

	color: #000;
}
div.pagination span.current {
	padding: 2px 5px 2px 5px;
	margin: 2px;
		border: 1px solid #000099;
		
		font-weight: bold;
		background-color: #000099;
		color: #FFF;
	}
	div.pagination span.disabled {
		padding: 2px 5px 2px 5px;
		margin: 2px;
		border: 1px solid #EEE;
	text-align:left;
		color: #DDD;
	}
	
</style>
<script type="text/javascript">
$(function(){
  $('#keywords').tablesorter(); 
});
</script>

</head>

<body >
<div class="container" style="padding-top:10px;padding-left:30px;">

<div class="panel panel-default" style="background-color:#F2F2F2;padding-left:5px;">

<h3>Purple Points Log</h3>

</div>
<div class="col-md-11 ">
 
 <?php


// How many adjacent pages should be shown on each side?
	$adjacents = 10;
	$start=0;
	
	
	/* 
	   First get total number of rows in data table. 
	   If you have a WHERE clause in your query, make sure you mirror it here.
	*/
	$query = "SELECT COUNT(id) as num FROM tbl_student_point where sc_teacher_id='$id' and sc_entites_id='106'";
	$total_pages = mysql_fetch_array(mysql_query($query));
	$total_pages = $total_pages['num'];
	
	/* Setup vars for query. */
	$targetpage = "parent_greenpoint_log.php"; 	//your file name  (the name of this file)
	$limit = 10; 
	if(isset($_GET['page']))
	{								//how many items to show per page
	$page = $_GET['page'];

	if($page) 
		$start = ($page - 1) * $limit; 			//first item to display on this page
	else
		$start = 0;								//if no page var is given, set start to 0
	}
	else
	{
			
			$page=0;
	}
	
	
	
?>


    <div id="no-more-tables">

  <table id="keywords" class="dataTable no-footer table table-striped" >
    <thead>
      <tr bgcolor="#800080">
        <th style="color:white;">Sr. No.</th>
        <th style="color:white;">Student  Name</th>
        <th style="color:white;">Reason</th>
        <th style="color:white;" >Points</th>
        <th  style="color:white;">Assigned Date</th>
      </tr>
    </thead>
    <tbody>
    
    <?php  	$i=$start+1;
    $a=0;
			$sql=mysql_query("SELECT `std_PRN`,`id` FROM `tbl_student` WHERE `parent_id`='$id'");
                while($result=mysql_fetch_array($sql))
				{
					$students[$a]=$result['std_PRN'];
					$a++;
				}
				$id1s = join("','",$students);
	$row=mysql_query("select sc_point,std_img_path,std_name,std_lastname,point_date,sc_studentpointlist_id,sp.reason,sp.activity_type from tbl_student_point sp LEFT join tbl_student s on sp.sc_stud_id=s.std_PRN and sp.`school_id`=s.school_id where sc_teacher_id='$id' and sc_entites_id='106' and sc_studentpointlist_id!='' and `sc_stud_id` IN('$id1s') ORDER BY sp.id desc limit  $start, $limit ");
	       while($value=mysql_fetch_array($row))
		   {
	?>
      <tr >
        <td data-title="Sr.No." ><?php echo $i;?></td>
        <td data-title="Student Name"  ><?php echo $value['std_name']." ".$value['std_lastname'];?></td>
        <?php $reason_id=$value['activity_type'];
		
		         if($reason_id=="subject")
				 {
					 //$subject_id=substr($reason_id,8);
					
					 $rows=mysql_query("select subjectName from tbl_student_subject_master where id='".$value['sc_studentpointlist_id']."'");
					 $values=mysql_fetch_array($rows);
				 ?>
              <td  data-title="Subject" ><?php echo ucwords($values['subjectName'])?></td>
                 <?php
				 
				 }
				 
				 else if(!is_numeric($value['sc_studentpointlist_id']) && $reason_id!="subject")
				 {
					 //$subject_id=substr($reason_id,8);
					
					 //$rows=mysql_query("");
					 //$values=$value['sc_studentpointlist_id'];
				 ?>
              <td  data-title="Subject" ><?php echo ucwords($value['sc_studentpointlist_id'])?></td>
                 <?php
				 
				 }
				 else
				 {
				
				 $rows=mysql_query("select * from tbl_studentpointslist where sc_id='".$value['sc_studentpointlist_id']."' and sc_id!=''");
			     $values=mysql_fetch_array($rows);
			 ?>
               <td data-title="Activity" ><?php echo ucwords($values['sc_list'])?></td>
             <?php
				 }
		?>
       
        <td data-title="Points" ><?php echo $value['sc_point']?></td>
        <?php
        $sum;
		$sum = $sum + $value['sc_point']; 
		
		?>
        <td  data-title="Point Date" ><?php echo $value['point_date']?></td>
      </tr>
      <?php $i++;}?>
      <!-- <div style="border: 1px solid black;
    border-radius: 25px;
    padding: 10px;
    margin-right: 300px;
    margin-left: 400px;
    margin-bottom: 20px;
    color: white;
    padding-left: 120px;
    background-color: purple;
    font-size: 20px;"><?php //echo $sum;?></div>
     -->
    </tbody>
  </table>
  </div>

  <div class="row">
  <div class="col-md-6 col-md-offset-8">
 <?php 
  
	
	/* Setup page vars for display. */
	if ($page == 0) ;					//if no page var is given, default to 1.
	$prev = $page - 1;							//previous page is page - 1
	$next = $page + 1;							//next page is page + 1
	$lastpage = ceil($total_pages/$limit);		//lastpage is = total pages / items per page, rounded up.
	$lpm1 = $lastpage - 1;						//last page minus 1
	
	/* 
		Now we apply our rules and draw the pagination object. 
		We're actually saving the code to a variable in case we want to draw it more than once.
	*/
	$pagination = "";
	if($lastpage > 1)
	{	
		$pagination .= "<div class=\"pagination\">";
		//previous button
		if ($page > 1) 
			$pagination.= "<a href=\"$targetpage?page=$prev\"> << </a>";
		else
		$pagination.= "<span class=\"disabled\"> << </span>";	
		
		//pages	
		if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
		{	
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				if ($counter == $page)
					$pagination.= "<span class=\"current\">$counter</span>";
				else
					$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";					
			}
		}
		elseif($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some
		{
			//close to beginning; only hide later pages
			if($page < 1 + ($adjacents * 2))		
			{
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";					
				}
				$pagination.= "...";
				$pagination.= "<a href=\"$targetpage?page=$lpm1\">$lpm1</a>";
				$pagination.= "<a href=\"$targetpage?page=$lastpage\">$lastpage</a>";		
			}
			//in middle; hide some front and some back
			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			{
				$pagination.= "<a href=\"$targetpage?page=1\">1</a>";
				$pagination.= "<a href=\"$targetpage?page=2\">2</a>";
				$pagination.= "...";
				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";					
				}
				$pagination.= "...";
				$pagination.= "<a href=\"$targetpage?page=$lpm1\">$lpm1</a>";
				$pagination.= "<a href=\"$targetpage?page=$lastpage\">$lastpage</a>";		
			}
			//close to end; only hide early pages
			else
			{
				$pagination.= "<a href=\"$targetpage?page=1\">1</a>";
				$pagination.= "<a href=\"$targetpage?page=2\">2</a>";
				$pagination.= "...";
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";					
				}
			}
		}
		
		//next button
		if ($page < $counter - 1) 
			$pagination.= "<a href=\"$targetpage?page=$next\">>></a>";
		else
			$pagination.= "<span class=\"disabled\">>> </span>";
		$pagination.= "</div>\n";		
	}?>
    
   <?php echo $pagination;?>
   </div>
 </div> 
 </div>
</div>
</body>
</html>