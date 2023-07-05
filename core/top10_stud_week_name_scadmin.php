<?php
error_reporting(0);
include('conn.php');


//$report="";	
$id1=$_GET['check_id'];
$result_explode = explode(',',$id1);
 $id=$result_explode[0];
 $school_id=$result_explode[1];
 
 //echo $id1;
/* $id=$_SESSION['id'];
$query="select * from `tbl_school_admin` where id='$id'";       // getting the the school id of login user by checking the session
$row1=mysql_query($query);
$value1=mysql_fetch_array($row1); 
 $school_id=$value1['school_id'];*/
	


				
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
					$name="";
					/* echo $id.",".$school_id; */
					if($school_id=="all")

					{
						if($id==1)
						{	
										$sql=mysql_query("SELECT ss.std_complete_name, sp.sc_stud_id, std_school_name, ss.std_img_path, sp.point_date, st.sc_total_point FROM tbl_student_point sp
										JOIN tbl_student_reward st ON sp.sc_stud_id = st.sc_stud_id
										JOIN tbl_student ss ON ss.std_PRN = sp.sc_stud_id
										WHERE point_date
										BETWEEN DATE_FORMAT((CURDATE( ) - INTERVAL 7 DAY ) , '%d/%m/%Y') AND  DATE_FORMAT(CURDATE( ), '%d/%m/%Y') GROUP BY sc_stud_id ORDER BY st.sc_total_point DESC LIMIT 10");
										
										$name="Week";
						}
					
						if($id==2)
						{	
						       
										$sql=mysql_query("SELECT ss.std_complete_name, sp.sc_stud_id, std_school_name, ss.std_img_path, sp.point_date, st.sc_total_point FROM tbl_student_point sp
										JOIN tbl_student_reward st ON sp.sc_stud_id = st.sc_stud_id
										JOIN tbl_student ss ON ss.std_PRN = sp.sc_stud_id
										WHERE point_date
										BETWEEN DATE_FORMAT((CURDATE( ) - INTERVAL 31 DAY ) , '%d/%m/%Y') AND CURDATE( )  GROUP BY sc_stud_id ORDER BY st.sc_total_point DESC LIMIT 10" );
					
							$name="Month";
					
			         }
					  if($id==3)
					 
						
						{	
										$sql=mysql_query("SELECT ss.std_complete_name, sp.sc_stud_id, std_school_name, ss.std_img_path, sp.point_date, st.sc_total_point FROM tbl_student_point sp
										JOIN tbl_student_reward st ON sp.sc_stud_id = st.sc_stud_id
										JOIN tbl_student ss ON ss.std_PRN = sp.sc_stud_id
										WHERE point_date
										BETWEEN DATE_FORMAT((CURDATE( ) - INTERVAL 365 DAY ) , '%d/%m/%Y') AND CURDATE( )  GROUP BY sc_stud_id ORDER BY st.sc_total_point DESC LIMIT 10");
					
					 	
							$name="Year";
					
					
					  }
					  if($id=='allDuration')
						{
										$sql=mysql_query("SELECT ss.std_complete_name, sp.sc_stud_id, std_school_name, ss.std_img_path, sp.point_date, st.sc_total_point FROM tbl_student_point sp
										JOIN tbl_student_reward st ON sp.sc_stud_id = st.sc_stud_id
										JOIN tbl_student ss ON ss.std_PRN = sp.sc_stud_id
										GROUP BY sc_stud_id ORDER BY st.sc_total_point DESC LIMIT 10");
										
										$name="All";
						}
					}
					
					else
					{
						if($id==1)
				    {	
										$sql=mysql_query("SELECT ss.std_complete_name, sp.sc_stud_id, std_school_name, ss.std_img_path, sp.point_date, st.sc_total_point FROM tbl_student_point sp
										JOIN tbl_student_reward st ON sp.sc_stud_id = st.sc_stud_id
										JOIN tbl_student ss ON ss.std_PRN = sp.sc_stud_id
										WHERE point_date
										BETWEEN DATE_FORMAT((CURDATE( ) - INTERVAL 7 DAY ) , '%d/%m/%Y') AND  DATE_FORMAT(CURDATE( ), '%d/%m/%Y') and ss.school_id='$school_id' GROUP BY sc_stud_id ORDER BY st.sc_total_point DESC LIMIT 10");
						$name="Week";
					}
					
					if($id==2)
					 {	
						       
										$sql=mysql_query("SELECT ss.std_complete_name, sp.sc_stud_id, std_school_name, ss.std_img_path, sp.point_date, st.sc_total_point FROM tbl_student_point sp
										JOIN tbl_student_reward st ON sp.sc_stud_id = st.sc_stud_id
										JOIN tbl_student ss ON ss.std_PRN = sp.sc_stud_id
										WHERE point_date
										BETWEEN DATE_FORMAT((CURDATE( ) - INTERVAL 31 DAY ) , '%d/%m/%Y') AND CURDATE( ) and ss.school_id='$school_id' GROUP BY sc_stud_id ORDER BY st.sc_total_point DESC LIMIT 10" );
					
							$name="Month";
					
			         }
					  if($id==3)
					 
						
						{	
										$sql=mysql_query("SELECT ss.std_complete_name, sp.sc_stud_id, std_school_name, ss.std_img_path, sp.point_date, st.sc_total_point FROM tbl_student_point sp
										JOIN tbl_student_reward st ON sp.sc_stud_id = st.sc_stud_id
										JOIN tbl_student ss ON ss.std_PRN = sp.sc_stud_id
										WHERE point_date
										BETWEEN DATE_FORMAT((CURDATE( ) - INTERVAL 365 DAY ) , '%d/%m/%Y') AND CURDATE( ) and ss.school_id='$school_id' GROUP BY sc_stud_id ORDER BY st.sc_total_point DESC LIMIT 10");
					
					 	
							$name="Year";
					
					
					  }
					  if($id=='allDuration')
						{
										$sql=mysql_query("SELECT ss.std_complete_name, sp.sc_stud_id, std_school_name, ss.std_img_path, sp.point_date, st.sc_total_point FROM tbl_student_point sp
										JOIN tbl_student_reward st ON sp.sc_stud_id = st.sc_stud_id
										JOIN tbl_student ss ON ss.std_PRN = sp.sc_stud_id WHERE  ss.school_id='$school_id'
										GROUP BY sc_stud_id ORDER BY st.sc_total_point DESC LIMIT 10");
										
										$name="All";
						}
						
					}
					
					
					
					
				/* 	if($id==1 && $school_id!='all')
				    {	
										$sql=mysql_query("SELECT ss.std_complete_name, sp.sc_stud_id, std_school_name, ss.std_img_path, sp.point_date, st.sc_total_point FROM tbl_student_point sp
										JOIN tbl_student_reward st ON sp.sc_stud_id = st.sc_stud_id
										JOIN tbl_student ss ON ss.std_PRN = sp.sc_stud_id
										WHERE point_date
										BETWEEN DATE_FORMAT((CURDATE( ) - INTERVAL 7 DAY ) , '%d/%m/%Y') AND  DATE_FORMAT(CURDATE( ), '%d/%m/%Y') and ss.school_id='$school_id' GROUP BY sc_stud_id ORDER BY st.sc_total_point DESC LIMIT 10");
						$name="Week";
					
					}else{
						
						
										$sql=mysql_query("SELECT ss.std_complete_name, sp.sc_stud_id, std_school_name, ss.std_img_path, sp.point_date, st.sc_total_point FROM tbl_student_point sp
										JOIN tbl_student_reward st ON sp.sc_stud_id = st.sc_stud_id
										JOIN tbl_student ss ON ss.std_PRN = sp.sc_stud_id
										WHERE point_date
										BETWEEN DATE_FORMAT((CURDATE( ) - INTERVAL 7 DAY ) , '%d/%m/%Y') AND  DATE_FORMAT(CURDATE( ), '%d/%m/%Y') GROUP BY sc_stud_id ORDER BY st.sc_total_point DESC LIMIT 10");
						$name="Week";
						
					}
					 
				
					if($id==2 && $school_id!='all')
					 {	
						       
										$sql=mysql_query("SELECT ss.std_complete_name, sp.sc_stud_id, std_school_name, ss.std_img_path, sp.point_date, st.sc_total_point FROM tbl_student_point sp
										JOIN tbl_student_reward st ON sp.sc_stud_id = st.sc_stud_id
										JOIN tbl_student ss ON ss.std_PRN = sp.sc_stud_id
										WHERE point_date
										BETWEEN DATE_FORMAT((CURDATE( ) - INTERVAL 31 DAY ) , '%d/%m/%Y') AND CURDATE( ) and ss.school_id='$school_id' GROUP BY sc_stud_id ORDER BY st.sc_total_point DESC LIMIT 10" );
					
							$name="Month";
					
			         }else
					 {
						 
						 
										$sql=mysql_query("SELECT ss.std_complete_name, sp.sc_stud_id, std_school_name, ss.std_img_path, sp.point_date, st.sc_total_point FROM tbl_student_point sp
										JOIN tbl_student_reward st ON sp.sc_stud_id = st.sc_stud_id
										JOIN tbl_student ss ON ss.std_PRN = sp.sc_stud_id
										WHERE point_date
										BETWEEN DATE_FORMAT((CURDATE( ) - INTERVAL 31 DAY ) , '%d/%m/%Y') AND CURDATE( ) GROUP BY sc_stud_id ORDER BY st.sc_total_point DESC LIMIT 10" );
						 $name="Month";
						 
					 }
					 if($id==3 && $school_id!='all')
					 
						
						{	
										$sql=mysql_query("SELECT ss.std_complete_name, sp.sc_stud_id, std_school_name, ss.std_img_path, sp.point_date, st.sc_total_point FROM tbl_student_point sp
										JOIN tbl_student_reward st ON sp.sc_stud_id = st.sc_stud_id
										JOIN tbl_student ss ON ss.std_PRN = sp.sc_stud_id
										WHERE point_date
										BETWEEN DATE_FORMAT((CURDATE( ) - INTERVAL 365 DAY ) , '%d/%m/%Y') AND CURDATE( ) and ss.school_id='$school_id' GROUP BY sc_stud_id ORDER BY st.sc_total_point DESC LIMIT 10");
					
					 	
							$name="Yea";
					
					
					  }else
					  
					  {
						  
										$sql=mysql_query("SELECT ss.std_complete_name, sp.sc_stud_id, std_school_name, ss.std_img_path, sp.point_date, st.sc_total_point FROM tbl_student_point sp
										JOIN tbl_student_reward st ON sp.sc_stud_id = st.sc_stud_id
										JOIN tbl_student ss ON ss.std_PRN = sp.sc_stud_id
										WHERE point_date
										BETWEEN DATE_FORMAT((CURDATE( ) - INTERVAL 365 DAY ) , '%d/%m/%Y') AND CURDATE( ) GROUP BY sc_stud_id ORDER BY st.sc_total_point DESC LIMIT 10");
						  $name="Yea1";
					  }
						 */
					
					
						//echo $school_id.",".$id;
					
						
										
						
						
							?>
					
					
					
									</table>
									</div>
								 </div>
								</div>
								</div>
										
										<div class='container-fluid'>
									<div class='row-fluid'>
									  <div class='span1'>
										
									  </div>
									  <div class='span11'>
									<div class="" align="center"> 
									<table class="table table-condensed table-responsive table-hover" style="">
									<thead align="center">
										<tr class="danger" >
											<th>Sr.No</th>
											<th align="center">Student Image</th>
											<th>Student Name</th>
											<th>Student School/College Name</th>
											<th><?php echo $name;?></th>
											<th>Points</th>
											
										</tr>
									</thead>
									<?php $i=0; 
									 while($row=mysql_fetch_array($sql)){
									$i++;?>
									
									<tbody>
										<tr class="warning">
										<td ><?php echo $i;?></td>
										<td align="center"> <?php if($row['std_img_path'] != ''){?>
											<img src="<?php echo $row['std_img_path'];?>"  style=" width:70px;height:70px;border-radius:50% 50% 50% 50%; -webkit-box-shadow: 2px 2px 5px 0px rgba(0, 0, 0, 1);" alt="Responsive image" /> <?php }else {?> <img src="image/no_photo.png"  style="border:1px solid #CCCCCC; width:70px;height:70px;border-radius:50% 50% 50% 50%; -webkit-box-shadow: 2px 2px 5px 0px rgba(0, 0, 0, 1);"  alt="Responsive image"/> <?php }?></td>
											<td><?php echo $row['std_complete_name'];?></td>
											<td><?php echo $row['std_school_name'];?></td>
											<td><?php echo $row['point_date'];?></td>
											<td><?php echo $row['sc_total_point'];?></td>
											
										</tr>
									</tbody>
					
									 <?php } ?>
</body>
</html>
					
					
               		
			
					
                   
					
                   
					
               
 
			   



  
 
 





</body>
</html>
