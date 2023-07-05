<?php include_once('header.php');

 if(!isset($_SESSION['id']))
	{
		header('location:login.php');
	}
	$id=$_SESSION['id'];
	$query = mysql_query("select * from tbl_teacher where id = ".$_SESSION['id']);
$value = mysql_fetch_array($query);
$sc_id=$value['school_id'];
$t_id=$value['t_id'];


?>
<!DOCTYPE html>
<script>
$(document).ready(function() {

    $('#example').DataTable();
} );
</script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="//cdn.datatables.net/1.10.4/js/jquery.dataTables.min.js"></script>
    <link href="//cdn.datatables.net/1.10.4/css/jquery.dataTables.css" rel="stylesheet" type="text/css"></link>


<head>

<link rel="stylesheet" type="text/css" href="css/student_dashboard_test.css">
    
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
		
		position: relative;
		padding-left: 50%; 
		white-space: normal;
		text-align:left;
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
<body>
<div class="container">
    <div  style="width:100%;">
     
    	<div style="height:50px; background-color:#FFFFFF; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;" align="left">
        	<h2 style="padding-left:20px; margin-top:4px;color:white;text-align:center;background-color:#2F329F;">My School Subject</h2>
      
       </div>
<div id="no-more-tables" style="padding-top:40px;" style="padding-top:10px;">
            <table id="example" class="" align="center" style="width:100%;pa">
        	<thead>
            	<tr style="background-color:#2F329F; color:white
                ; height:30px;">
                	<th>Sr. No.</th>
                    
                    <th>Subject Code</th>
                     <th> Subject Name</th>
                    <th>Semester</th>
                     <th>Course_Level</th>
                       <?php /*?> <th>Department_Name</th>
                           <th>Branch_name</th><?php */?>
                            <th>Academic_Year</th>
                     <th>Add Subject</th>
                   
                   
                </tr>
               </thead>
 <?php
			
			$i=0;
				//$arr = mysql_query("select * from `tbl_school_subject` where school_id='$sc_id' ORDER BY subject");
				/*$arr=mysql_query("select distinct st.Subject_Code,st.subject,st.Semester_id,st.Course_Level_PID,s.Department_Name,s.Branch_name,Y.	Academic_Year  from `tbl_school_subject`st inner join tbl_semester_master s on st.Course_Level_PID=s.CourseLevel inner join tbl_academic_Year Y on st.school_id=Y.school_id  where s.school_id='$sc_id'and Y.Enable='1'");*/
				 //and s.Is_enable='1'
				 $arr=mysql_query("select distinct st.Subject_Code,st.subject,st.Semester_id,st.Course_Level_PID,Y.Year  
				 from `tbl_school_subject`st
 						inner join tbl_academic_Year Y 
						    on st.school_id=Y.school_id  
							   where st.school_id='$sc_id' and Y.Enable='1'");
				
				
				
				
				
				while($row = mysql_fetch_array($arr))
				{
				$i++;
				?>
                <tr>
                	<td data-title="Sr.No"><b><?php echo $i;?></b></td>
                   
                   
                   
                 
                    <td data-title="Points"><b><?php echo $row['Subject_Code'];?></b></td>
                    <td data-title="Reason"><b><?php echo $row['subject'];?></b></td>
                    <td data-title="Reason"><b><?php echo $row['Semester_id'];?></b></td>
                      <td data-title="Reason"><b><?php echo $row['Course_Level_PID'];?></b></td>
                       <?php /*?><td data-title="Reason"><b><?php echo $row['Department_Name'];?></b></td>
                        <td data-title="Reason"><b><?php echo $row['Branch_name'];?></b></td><?php */?>
                          <td data-title="Reason"><b><?php echo $row['Year'];?></b></td>
                    <!-- <td  data-title="Date"><a href="insert_sub.php"><center>  Add</center></a></b></td>--> <td align="center">  
                    
                    <?php /*?><a href="insert_tech.php?Subject_Code=<?php echo $row['Subject_Code'];?>&subject=<?php echo $row['subject'];?>&Semester_id=<?php echo $row['Semester_id'];?>&Course_Level_PID=<?php echo $row['Course_Level_PID'];?>&t_id=<?php echo $t_id=$value['t_id'];?>&depart=<?php echo  $row['Department_Name'];?>& branch=<?php echo  $row['Branch_name'];?>&year=<?php echo  $row['Academic_Year'];?>"><?php */?>
                      <a href="insert_tech.php?Subject_Code=<?php echo $row['Subject_Code'];?>&subject=<?php echo $row['subject'];?>&Semester_id=<?php echo $row['Semester_id'];?>&Course_Level_PID=<?php echo $row['Course_Level_PID'];?>&t_id=<?php echo $t_id=$value['t_id'];?>&year=<?php echo  $row['Year'];?>">
                    
                    
                    <input type="submit" value="Add" name="Add" class="btn btn-primary"style="color:white;background-color:#2F329F;"></a></td>
                    
                </tr>
                <?php
				}
				?>
            </table>
            
 
<div align="center" style="padding-top:20px; "><a href="dashboard.php" style="text-decoration:none"><input type="button"  value="Back" class="btn btn-danger" style="width:10%;"/></a></div>
</div>
                




</div>
</div>
</body>
<footer>
<?php
 include_once('footer.php');?>
 </footer>
</html>