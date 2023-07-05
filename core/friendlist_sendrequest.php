<?php
 include_once('stud_header.php');
 
  if(!isset($_SESSION['id']))
	 {
	 	header('Location:login.php');
	 }
	 
	  $query = mysql_query("select * from tbl_student where id = ".$_SESSION['id']);
	 $value = mysql_fetch_array($query);
	 $school_id=$value['school_id'];
	 $id=$value['id'];
	 $std_PRN=$value['std_PRN'];
	 

	  	 $sql2=mysql_query("select s.BranchName,s.DeptName,s.SemesterName,s.DivisionName, s.CourseLevel,s.AcdemicYear from StudentSemesterRecord s join tbl_academic_Year Y on Y.Year= s.AcdemicYear and Y.Enable='1' where s.IsCurrentSemester='1' and s.student_id='$std_PRN' and s.school_id='$school_id'");
	 $value2=mysql_fetch_array($sql2);
	 
	 $branch=$value2['BranchName'];
	 $dept=$value2['DeptName'];
	 $SemesterName=$value2['SemesterName'];
	 $DivisionName=$value2['DivisionName'];
	 $CourseLevel=$value2['CourseLevel'];
 
	 ?>


       <html>
       <head>
     
       <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
        <meta name="viewport" content="width=device-width, initial-scale=1">
 
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  
  
		<script src="js/jquery-1.11.1.min.js"></script>
        <script src="js/jquery.dataTables.min.js"></script>
    
        <script>
	
        $(document).ready(function() {
            $('#example').dataTable( {
		
				
         });
			$('#example1').dataTable( {
		
				
         });
		 $('#example2').dataTable( {
		
				
         });
			
  
        } );
		
		
        </script>
        
        <script>
 function openwindow(stud_id)
 {

if(stud_id!="")
{

window.location = "sendrequest_tostudent.php?stud_id="+stud_id;
}
 
 }
 </script>
         <style>
		 .preview
{
border-radius:50% 50% 50% 50%;  

box-shadow: 0 3px 2px rgba(0, 0, 0, 0.3);
-webkit-border-radius: 99em;
  -moz-border-radius: 99em;
  border-radius: 99em;
  border: 5px solid #eee;
  width:100px;
}
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
   <body style= "background: none repeat scroll 0% 0% transparent;border: 0px none; margin: 0px; outline: 0px none; padding: 0px;">


<div class="container" style="padding-top:5px;">

            <div class="row" style="color:#3c763d;font-weight:bold;">
            <h4 align="center">Request Points</h4>
            </div>        
                  
  <div class="row">
	
   

<ul class="nav nav-tabs" style="padding-top:10px;">
    <li class="active"><a data-toggle="tab" href="#home">Send Request</a></li>
    <li><a data-toggle="tab" href="#menu1">Accepted request points Log</a></li>
      <li><a data-toggle="tab" href="#menu2">Send request Log</a></li>
  
  </ul>
  
  <div class="tab-content">
    <div id="home" class="tab-pane fade in active">
     
       <div id="no-more-tables" style="padding-top:40px;">
          
                           
                           <form method="post">
                           <div class="row" >
                           <div class="col-md-4">
                         Find friends for sending request</div><div class="col-md-3"><input type="text" name="student_name" id="student_name" class="form-control" value="<?php if(isset($_POST['student_name'])){echo $_POST['student_name'];}?>" placeholder="Enter Student Name/PRN"></div><div class="col-md-1"><input type="submit" name="submit" value="Search" class="btn btn-primary"></div></div>
                           </form>
                           <div style="padding-top:40px;">
                    <table id="example" class="display"  width="100%" cellspacing="0" >
                <thead>
                    <tr>
                        <th>Sr. No.</th>
                        <th></th>
                        <th>Student PRN No</th>
                       <th>Student Name</th>
                         <th></th>
                       
                    </tr>
                </thead>
         
               
         
                <tbody>
                
               
                    <?php 
					if(isset($_POST['submit']))
					{
					
					$student_name=$_POST['student_name'];
					if($student_name!='')
					{
						  $sql1= "Select s.std_img_path,s.id,s.std_PRN,s.std_name,s.std_Father_name,s.std_lastname,s.std_complete_name from tbl_student s inner join StudentSemesterRecord ss on ss.student_id=s.std_PRN where (s.std_name='$student_name' or s.std_complete_name='$student_name' or std_PRN='$student_name') and s.std_PRN!='$std_PRN' and ss.BranchName='$branch' and ss.DeptName='$dept' and ss.IsCurrentSemester='1'and ss.SemesterName='$SemesterName' and ss.DivisionName='$DivisionName' and ss.CourseLevel='$CourseLevel' and  s.school_id='$school_id' ORDER BY s.std_name";
						  
					}
					else
					{
					$sql1= "Select s.std_img_path,s.id,s.std_PRN,s.std_name,s.std_Father_name,s.std_lastname,s.std_complete_name from tbl_student s inner join StudentSemesterRecord ss on ss.student_id=s.std_PRN where s.std_PRN!='$std_PRN' and ss.BranchName='$branch' and ss.DeptName='$dept' and ss.IsCurrentSemester='1'and ss.SemesterName='$SemesterName' and ss.DivisionName='$DivisionName' and ss.CourseLevel='$CourseLevel' and  s.school_id='$school_id' ORDER BY s.std_name";
					
					
					}
					
					}
					else
					{
						
					
					  $sql1= "Select s.std_img_path,s.id,s.std_PRN,s.std_name,s.std_Father_name,s.std_lastname,s.std_complete_name from tbl_student s inner join StudentSemesterRecord ss on ss.student_id=s.std_PRN where s.std_PRN!='$std_PRN' and ss.BranchName='$branch' and ss.DeptName='$dept' and ss.IsCurrentSemester='1'and ss.SemesterName='$SemesterName' and ss.DivisionName='$DivisionName' and ss.CourseLevel='$CourseLevel' and  s.school_id='$school_id' ORDER BY s.std_name";
					  
					  }
                    $i=0;
                        $arr1 = mysql_query($sql1);
                        while($row1 = mysql_fetch_array($arr1))
                        {
						$stud_id=$row1['std_PRN'];
                        $i++;
                        ?>
                        <tr>
                            <td data-title="Sr.No"><?php echo $i;?></td>
                            <td><img src="<?php if($row1['std_img_path'] !=''){echo $row1['std_img_path'];}else{ echo "image/avatar_2x.png";}?>"  style="border:1px solid #CCCCCC; width:60px;height:60px;" class="preview" alt="Responsive image"></td>
                            <td data-title="std_PRN"><?php echo $row1['std_PRN'];?></td>
                            <td data-title="Name"><?php echo ucwords(strtolower($row1['std_complete_name']));?></td>
                            
                             <td> 
                            
							
                            <a class="txt-button" onClick="openwindow(<?php echo $stud_id;?>);"><input type="button" value="Send Request" class="btn btn-primary"></a>
                            
                            
                         </td>
                            
                        </tr>
                        <?php
                        }
                        ?>
        
                 
                    
                </tbody>
            </table></div> 
            </div>
    </div>
    <div id="menu1" class="tab-pane fade">
      
      <div id="no-more-tables" style="padding-top:20px;">
          
                           
                    <table id="example1" class="display"  width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Sr. No.</th>
                        
                        <th>Student Name</th>
                        <th>Points</th>
                        <th>Reason</th>
                         <th>Date</th>
                       
                    </tr>
                </thead>
         
               
         
                <tbody>
                    <?php  $sql1="select s.std_PRN,s.std_name,s.std_complete_name,sp.sc_point,sp.reason,sp.point_date from tbl_student_point sp join tbl_student s where sp.sc_stud_id=s.std_PRN and sp.sc_entites_id='105' and sp.sc_teacher_id='$std_PRN' order by sp.id desc";
                    $i=0;
                        $arr1 = mysql_query($sql1);
                        while($row1 = mysql_fetch_array($arr1))
                        {
                        $i++;
						
                        ?>
                        <tr>
                            <td data-title="Sr.No"><?php echo $i;?></td>
                           
                            <td data-title="Student Name"><?php echo ucwords(strtolower($row1['std_complete_name']));?></td>
                            <td data-title="Points"><?php echo $row1['sc_point'];?></td>
                            <td data-title="Reason"><?php echo $row1['reason'];?></td>
                            <td data-title="Date"><?php echo $row1['point_date'];?></td>
                            
                        </tr>
                        <?php
                        }
                        ?>
        
                 
                    
                </tbody>
            </table> 
            </div>
    </div>
    
     <div id="menu2" class="tab-pane fade">
      
      <div id="no-more-tables" style="padding-top:20px;">
          
                           
                    <table id="example2" class="display"  width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Sr. No.</th>
                        <th>Student Name</th>
                        <th>Points</th>
                        <th>Reason</th>
                         <th>Request Date</th>
                         <th>Status</th>
                       
                       
                    </tr>
                </thead>
         
               
         
                <tbody>
                    <?php  $sql1="select s.std_PRN,s.std_name,s.std_complete_name,s.std_lastname,r.points,r.reason,r.flag,r.requestdate from tbl_student s join tbl_request r on r.stud_id2=s.std_PRN   and r.entitity_id='105' and r.stud_id1='$std_PRN' order by r.id desc";
                    $i=0;
                        $arr1 = mysql_query($sql1);
                        while($row1 = mysql_fetch_array($arr1))
                        {
                        $i++;
						
                        ?>
                        <tr>
                            <td data-title="Sr.No"><?php echo $i;?></td>
                           
                            <td data-title="Student Name"><?php echo ucwords(strtolower($row1['std_complete_name']));?></td>
                            <td data-title="Points"><?php echo $row1['points'];?></td>
                            <td data-title="Reason"><?php echo $row1['reason'];?></td>
                            <td data-title="Date"><?php echo $row1['requestdate'];?></td>
                            
                            <td data-title="Date"><?php $flag=$row1['flag'];
							
							if($flag=='Y')
							{
							$status='Accepted';	
								
							}
							else
							{
								$status='Pending';
							}
							
							echo $status;
							?></td>
                        </tr>
                        <?php
                        }
                        ?>
        
                 
                    
                </tbody>
            </table> 
            </div>
    </div>
    
    
    
  </div>
</div>
                 
               
       
                 


          
          
          
          
          
          </div>
          
          
          
          
          


</div>









</div>


</body>




</html>










