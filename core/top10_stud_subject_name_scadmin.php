<?php
error_reporting(0);

include('conn.php');

$report="";	
$data=xss_clean(mysql_real_escape_string($_GET['subject_id']));

            $result_explode = explode(',',$data);
            $subject_id=$result_explode[0];
            $school_id=$result_explode[1];

				
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
.panel-heading{margin-top:5px;}
.dropdown1{padding-left:105px;margin-top:15px;}


  </style>


</style>
<!--<link rel="stylesheet" href="css/bootstrap.min.css">-->
<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src='js/bootstrap.min.js' type='text/javascript'></script>
<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">-->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.cs">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
<title>LEADER BOARD::SMART COOKIES</title>

</head>
<body bgcolor=#FFDD88>

   
   
					<?php 
					
					if($subject_id!='')
					{
							if($subject_id=="allSubjects")
							{
										$sql=mysql_query("Select ss.subject,s.std_complete_name,s.std_img_path,s.std_school_name,sum(sc_point) as total 
										from tbl_student s join tbl_student_point sp on s.std_PRN=sp.sc_stud_id join tbl_school_subject ss on ss.id = sp.sc_studentpointlist_id
										where activity_type='subject' 
										GROUP BY sc_stud_id order by total desc limit 10" );
							}
							else{
									$sql=mysql_query("Select ss.subject,s.std_complete_name,s.std_img_path,s.std_school_name,sum(sc_point) as total 
										from tbl_student s join tbl_student_point sp on s.std_PRN=sp.sc_stud_id join tbl_school_subject ss on ss.id = sp.sc_studentpointlist_id
										where s.school_id='$school_id' and sp.sc_studentpointlist_id='$subject_id' and activity_type='subject' 
										GROUP BY sc_stud_id order by total desc limit 10" );
							}
										
										 ?>	
										
									  <div class='container-fluid'>
										<div class='row-fluid'>
										  <div class='span1'>
											
										  </div>
										  <div class='span11'>
										<div class="" align="center"> 
										<table class="table table-condensed table-responsive table-hover" style="">
										<thead align="center">
											<tr class="warning" >
                                            <th align="center">Sr.No</th>
                                            <th align="center"><?php echo xecho($dynamic_student);?>Image</th>
                                            <th align="center"><?php echo xecho($dynamic_student);?> Name</th>
                                            <th align="center"><?php echo xecho($dynamic_student." ".$dynamic_school."");?>College Name</th>
                                            <th align="center">Points</th>
											</tr>
										</thead>
										<?php $i=0;
										 while($row=mysql_fetch_array($sql)){
										$i++;?>
										
										<tbody>
											<tr class="success">
											<td ><?php echo $i;?></td>
											<td> <?php if($row['std_img_path'] != ''){?>
												<img src="<?php echo xecho($row['std_img_path']);?>"  style=" width:70px;height:70px;border-radius:50% 50% 50% 50%; -webkit-box-shadow: 2px 2px 5px 0px rgba(0, 0, 0, 1);" alt="Responsive image" /> <?php }else {?> <img src="Images/avatar_2x.png"  style="border:1px solid #CCCCCC; width:70px;height:70px;border-radius:50% 50% 50% 50%; -webkit-box-shadow: 2px 2px 5px 0px rgba(0, 0, 0, 1);"  alt="Responsive image"/> <?php }?></td>
												<td><?php echo xecho($row['std_complete_name']);?></td>
												<td><?php echo xecho($row['std_school_name']);?></td>
												<td><?php echo xecho($row['subject']);?></td>
												<td><?php echo xecho($row['total']);?></td>
												
											</tr>
										</tbody>
										
										
					
					<?php } }
					else{
						
						
								$sql=mysql_query("Select ss.subject,s.std_complete_name,s.std_img_path,s.std_school_name,sum(sc_point) as total 
										from tbl_student s join tbl_student_point sp on s.std_PRN=sp.sc_stud_id join tbl_school_subject ss on ss.id = sp.sc_studentpointlist_id
										where activity_type='subject' and s.school_id='$school_id'
										GROUP BY sc_stud_id order by total desc limit 10" );
										
										 ?>	
										
									  <div class='container-fluid'>
										<div class='row-fluid'>
										  <div class='span1'>
											
										  </div>
										  <div class='span11'>
										<div class="" align="center"> 
										<table class="table table-condensed table-responsive table-hover" style="">
										<thead align="center">
											<tr class="warning" >
												<th align="center">Sr.No</th>
												<th align="center"><?php echo xecho(($_SESSION['usertype']=='Manager')? 'Employee Image':'Student Image');?></th>
												<th align="center"><?php echo xecho(($_SESSION['usertype']=='Manager')? 'Employee Name':'Student Name');?></th>
												<th align="center"><?php echo xecho(($_SESSION['usertype']=='Manager')? 'Organization Name':'Student School/College Name');?></th>
												<th align="center"><?php echo xecho(($_SESSION['usertype']=='Manager')? 'Project Name':'Subject Name');?></th>
												<th align="center">Points</th>
												
											</tr>
										</thead>
										<?php $i=0;
										 while($row=mysql_fetch_array($sql)){
										$i++;?>
										
										<tbody>
											<tr class="success">
											<td ><?php echo xecho($i);?></td>
											<td> <?php if($row['std_img_path'] != ''){?>
												<img src="<?php echo xecho($row['std_img_path']);?>"  style=" width:70px;height:70px;border-radius:50% 50% 50% 50%; -webkit-box-shadow: 2px 2px 5px 0px rgba(0, 0, 0, 1);" alt="Responsive image" /> <?php }else {?> <img src="Images/avatar_2x.png"  style="border:1px solid #CCCCCC; width:70px;height:70px;border-radius:50% 50% 50% 50%; -webkit-box-shadow: 2px 2px 5px 0px rgba(0, 0, 0, 1);"  alt="Responsive image"/> <?php }?></td>
												<td><?php echo xecho($row['std_complete_name']);?></td>
												<td><?php echo xecho($row['std_school_name']);?></td>
												<td><?php echo xecho($row['subject']);?></td>
												<td><?php echo xecho($row['total']);?></td>
												
											</tr>
										</tbody>
										
						
					<?php												}
					
					}
					
					?>
					
               		</table>
					</div>
				 </div>
				</div>
				</div>
</body>
</html>
