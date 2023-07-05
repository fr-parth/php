<?php
   include_once('scadmin_header.php');

     $report="";
	 $t_id=$_GET['t_id'];
	 $subjectName=$_GET['subjectName'];
	 $school_id=$_GET['school_id'];
	
	//change in query done by Pranali for bug SMC-3287
	
	$arr="SELECT DISTINCT t.t_complete_name,st.subjectName,st.teacher_ID,st.CourseLevel,st.AcademicYear FROM tbl_student_subject st inner join tbl_teacher t on st.teacher_ID=t.t_id where st.subjectName='$subjectName' and st.teacher_ID='$t_id' and st.school_id='$school_id' and t.school_id='$school_id'";
	
	//changes end
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="css/bootstrap.min.css">
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
<!--<script src='js/bootstrap.min.js' type='text/javascript'></script>-->
<title>Student Semester Records</title>
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
$(document).ready(function() {
    $('#example').dataTable( {
        "pagingType": "full_numbers"
    } );
} );

</script>
<!--
<script>
function confirmation(xxx) {
    var answer = confirm("Are you sure you want to delete")
    if (answer){
        
        window.location = "delete_school_subject.php?id="+xxx;
    }
    else{
       
     }
}

</script>
-->
<body bgcolor="#CCCCCC">
<div style="bgcolor:#CCCCCC">
<div>

</div>
<div class="container" style="padding:25px;" >
        	
            
            	<div style="padding:2px 2px 2px 2px;border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">
                   
                    
                    <div style="background-color:#F8F8F8 ;">
                    <div class="row">
                    <div class="col-md-3 "  style="color:#700000 ;padding:5px;" >&nbsp;&nbsp;&nbsp;&nbsp;
                 <!--      <a href="add_school_subject.php">   <input type="submit" class="btn btn-primary" name="submit" value="Add Subject" style="width:110px;font-weight:bold;font-size:14px;"/></a>-->
               			 </div>
              			 <div class="col-md-6 " align="center"  >
                         	
                   				<h2><?php echo ($_SESSION['usertype']=='Manager')? 'Employee':'Teacher';?> List</h2>
               			 </div>
                         
                     </div>
                  
                  <div class="row" align="center" style="margin-top:3%;">
				  <form method="post">
				    <div class="col-md-3"></div>
				  
				  
				  <div class="col-md-3">
				 
				  </div>
				  <div class="col-md-2">
				 
				  </div>
				  
				  
				  </form>
				  </div>
                   
                  
               <div class="row" style="margin-top:3%;">

               <div class="col-md-2">
               </div>
              <div class="col-md-12" id="no-more-tables" >
               <?php $i=0;?>
                   <table class="table-bordered  table-condensed cf" id="example" width="100%;" >
                     <thead>
					    <tr style="background-color:#555;color:#FFFFFF;height:30px;">
						<th style="width:50px;" ><center>Sr. No.</center></th>
                        <th style="width:50px;" ><center>Teacher ID</center></th>
                         <th style="width:50px;" ><center>Teacher  Name</center></th>
                           <th style="width:50px;" ><center>Subject Name</center></th>
                        
                        <th style="width:50px;" ><center>CourseLevel</center></th>
                        <th style="width:50px;" ><center>AcademicYear</center></th>
                       
                       
	
     
						
						
					</tr>
					</thead>
				<tbody>
                 <?php
				 
				   $i=1;
//$arr="SELECT std.std_PRN, std.std_name, std.std_Father_name, std.std_lastname, std.std_complete_name, semester.student_id, semester.SemesterName, semester.BranchName, semester.Specialization, semester.DeptName, semester.CourseLevel, semester.DivisionName, semester.AcdemicYear FROM StudentSemesterRecord AS semester JOIN tbl_student AS std ON std.std_PRN = semester.student_id JOIN tbl_academic_Year a ON semester.AcdemicYear=a.Year where semester.school_id='$sc_id' and semester.`IsCurrentSemester`='1' and a.Enable='1' and a.school_id='$sc_id' ORDER BY std.std_name,std.std_complete_name"?>
                  <?php
$arr1=mysql_query($arr);
				  while($row=mysql_fetch_array($arr1))
				  {
				      // $fullName=ucwords(strtolower($row['std_name']." ".$row['std_Father_name']." ".$row['std_lastname']));
				  ?>
				  
				  <tr 				  style="height:30px;color:#808080;">
				
               
                    <td data-title="Sr. No." style="width:50px;"><b><center><?php echo $i;?></center></b></td>
                    <td data-title="Student Name" style="width:50px;" ><center><a href="studentdetails.php?prn=<?php echo $row['teacher_ID'];?>"><?php echo $row['teacher_ID'];?><a></center></td>
                     <td data-title="Student Name" style="width:50px;" ><center><?php echo $row['t_complete_name'];?></center></td>
                    <td data-title="Student PRN" style="width:50px;" ><center><?php echo $row['subjectName'];?> </center></td>
                    
					<td data-title="Student PRN" style="width:50px;" ><center><?php echo $row['CourseLevel'];?> </center></td>
                    
                    
					<td data-title="Branch Name" style="width:420px;"><center><?php echo $row['AcademicYear'];?></center> </td>
					
					
     
     
					
                    
                <?php $i++;?>
                 <?php }?>
                  
                  </tbody>
                  </table>
                  </div>
                  </div>
                  
                  
                   <div class="row" style="padding:5px;">
                   <div class="col-md-4">
               </div>
                  <div class="col-md-3 "  align="center">
                   
                   </form>
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
