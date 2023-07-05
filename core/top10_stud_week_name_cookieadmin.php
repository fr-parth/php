<?php
error_reporting(0);
include('conn.php');
include("cookieadminheader.php");

//$report="";	
//$subject_id=$_GET['id'];
$subject_id=$_GET['id'];
$school_id=$_GET['school_id'];	


				
?> 
<html>
<head>
<style>
.dropdown {
    
    display: -webkit-flex; /* Safari */
    -webkit-align-items: center; /* Safari 7.0+ */
    display: flex;
    align-items: center;
}
.list-inline
{
display: inline-block; }
.dropdown{padding-left:55px;margin-top:15px;margin-bottom:30px;}
.dropdown1{padding-left:105px;margin-top:15px;}
.panel-heading{margin-top:5px;}



  </style>


</style>
<link rel="stylesheet" href="css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src='js/bootstrap.min.js' type='text/javascript'></script>
<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">-->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.cs">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
<title>LEADER BOARD::SMART COOKIES</title>
</head>
<body bgcolor=#FFDD88>
<div class="row">
  <div class="col-md-offset-2 col-md-8">
    <div class="panel panel-default">
      <div class="panel-heading text-center">
     <img src="image/newlogo1.png"> <!--<h1><font color="red" size=10>Smart</font> <font color="black" size=10>Cookie</font></h1></font>-->
      </div>
      <div class="panel-body" style="background-color:#FFDD88;color:#4D4B4A;text-align:center;padding:3px;">
      <small><b><font size=4>LEADER BOARD (TOP 10 STUDENTS OF THE WEEK)</font></b></small>
      </div>
     </div>
  </div>
</div>

<!-- School name drop down list -->

<div class="row">
  <div class="col-md-offset-2 col-md-8 centered">
<div class="panel panel-info">

  <div class="panel-heading text-center">
    <h3 class="panel-title"><font color="black"><b>List of Top 10 Students</b></font></h3>
  </div>
  <div class="panel-body>
 <div class="center-block"> 
 <div class="row">
  <div class="col-md-4">
<div class="dropdown">
  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
  School/College Name 
    <span class="caret"></span>
  </button>

  <ul class="dropdown-menu "  role="menu" aria-labelledby="dropdownMenu1">
  
   <?php $sql1=mysql_query("Select school_name from tbl_school order by `school_name` ASC" );?>
 

   
    <li role="presentation" class="dropdown-header">All School</a></li>
	 <li role="presentation"><a role="menuitem" tabindex="-1" href="top10_stud_cookieadmin.php">All School</a></li>
	  <li role="presentation" class="divider"></li>
	  <li role="presentation" class="dropdown-header">Specific School</a></li>
	  <?php while($row=mysql_fetch_array($sql1)){ ?>
	  
	 
	
	
    <li role="presentation"><a role="menuitem" tabindex="-1" href="top10_stud_school_name_cookieadmin.php?id=<?php echo $row['id'];?>"><?php echo $row['school_name'];?><?php }?></a></li>
    
  </ul>
</div>
</div>

<!-- Duration drop down list -->

 <div class="row">
  <div class="col-md-4">
<div class="dropdown1">

  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
Duration
	
    <span class="caret"></span>
  </button>
  
    <ul class="dropdown-menu " role="menu" aria-labelledby="dropdownMenu1">

   
    <li role="presentation"><a role="menuitem" tabindex="-1" href="top10_stud_week_name_cookieadmin.php">Week </a></li>
    <li role="presentation"><a role="menuitem" tabindex="-1" href="top10_stud_month_name_cookieadmin.php">Month</a></li>
    <li role="presentation"><a role="menuitem" tabindex="-1" href="top10_stud_year_name_cookieadmin.php">Year</a></li>
   
  </ul>
</div>
</div>
   
   <!-- Subject/Activity drop down list -->
    <div class="row"> 
  <div class="col-md-4">
   <div class="dropdown">
  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
Subject/Activity
    <span class="caret"></span>
  </button>
  <ul class="dropdown-menu " role="menu" aria-labelledby="dropdownMenu1">
   <?php $sql2=mysql_query("Select * from tbl_school_subject where school_id='$school_id'" );?>
   <li role="presentation" class="dropdown-header">Subjects Name</a></li>
   <li role="presentation" class="divider"></li>
	<?php while($row=mysql_fetch_array($sql2)){?>
	<li role="presentation"><a role="menuitem" tabindex="-1" href="top10_stud_subject_name_cookieadmin.php?id=<?php echo $row['id'];?>&school_id=<?php echo $row['school_id'];?>"><?php echo $row['subject'];?><?php }?></a></li>
	  
	  <?php $sql3=mysql_query("Select * from tbl_studentpointslist where school_id='$school_id'" );?>
	  <li role="presentation" class="divider"></li>
    <li role="presentation" class="dropdown-header">Activity Types</a></li>
	<li role="presentation" class="divider"></li>
	<?php while($row=mysql_fetch_array($sql3)){?>
	<li role="presentation"><a role="menuitem" tabindex="-1" href="top10_stud_activity_name_cookieadmin.php?id=<?php echo $row['school_id'];?>&sc_id=<?php echo $row['sc_id'];?>"><?php echo $row['sc_list'];?><?php }?></a></li>
    
   
  </ul>
</div>
</div>


  </div>
</div> 
 
 </div>
</div>  
  </form> 
   
   
					<?php 
					$sql=mysql_query("SELECT ss.std_complete_name, sp.sc_stud_id, std_school_name, ss.std_img_path, sp.point_date, st.sc_total_point FROM tbl_student_point sp
										JOIN tbl_student_reward st ON sp.sc_stud_id = st.sc_stud_id
										JOIN tbl_student ss ON ss.id = sp.sc_stud_id
										WHERE point_date
										BETWEEN DATE_FORMAT((CURDATE( ) - INTERVAL 7 DAY ) , '%m/%d/%Y') AND CURDATE( ) GROUP BY sc_stud_id ORDER BY st.sc_total_point DESC LIMIT 10");
					
					 ?>	
					
				  <div class='container-fluid'>
					<div class='row-fluid'>
					  <div class='span1'>
						
					  </div>
					  <div class='span11'>
					<div class="table-responsive" align="center"> 
                    <table class="table table-bordered table-condensed table-hover" style="white-space: nowrap">
					<thead align="center">
						<tr class="warning" >
                        	<th>Sr.No</th>
							<th>Student Name</th>
							<th>Student School/College Name</th>
							<th>Week</th>
							<th>Points</th>
							
						</tr>
					</thead>
                    <?php $i=0;
					 while($row=mysql_fetch_array($sql)){
					$i++;?>
					
					<tbody>
						<tr class="success">
                        <td class="active"><?php echo $i;?></td>
                        
							<td><?php echo $row['std_complete_name'];?></td>
							<td ><?php echo $row['std_school_name'];?></td>
							<td ><?php echo $row['point_date'];?></td>
							<td><?php echo $row['sc_total_point'];?></td>
							
						</tr>
				    </tbody>
					
					
					
					 <?php } ?>
					
               		</table>
					</div>
				 </div>
				</div>
				</div>
			
					
                   
					
                   
					
               
 
			   



  
 
 





</body>
</html>
