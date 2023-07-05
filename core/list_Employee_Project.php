<?php
				include('scadmin_header.php');
             $report="";
             $id=$_SESSION['id'];
           $fields=array("id"=>$id);
		   $table="tbl_school_admin";
		   $smartcookie=new smartcookie();

$results=$smartcookie->retrive_individual($table,$fields);
$result=mysql_fetch_array($results);

$sc_id=$result['school_id'];
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
 <link rel="stylesheet" href="css/bootstrap.min.css">


<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.dataTables.min.js"></script>

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
        



<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
<script>
$(document).ready(function() {
    $('#example').dataTable( {
      
    } );
} );


function confirmation(xxx) {

    var answer = confirm("Are you sure you want to delete?")
    if (answer){
        
        window.location = "delete_teacher_subject_master.php?id="+xxx;
    }
    else{
       
    }
}

</script>
<body bgcolor="#CCCCCC">
<div style="bgcolor:#CCCCCC">

<div class="container"  style="padding:30px;" >
        	
            
            	<div style="border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">
                   
                   
                    <div style="background-color:#F8F8F8 ;">
                    <div class="row">
                    <div class="col-md-3 "  style="color:#700000 ;padding:5px;" >&nbsp;&nbsp;&nbsp;&nbsp;
                       <a href="Add_employee_project.php"> <input type="submit" class="btn btn-primary" name="submit" value="Add Project" style="width:150;font-weight:bold;font-size:14px;"/></a>
               			 </div>
              			 <div class="col-md-6 " align="center"  >
                         	<h2>Employee Project List </h2>
               			 </div>
                         
                     </div>
               <div class="row" style="padding:10px;" >
             <div class="col-md-12  " id="no-more-tables" >

               <?php $i=0;?>
                  <table class="table-bordered" id="example" >
                     <thead>
                    	<tr style="background-color:#555;color:#FFFFFF;height:30px;"><th style="width:50px;" ><b><center>Sr.No</center></b><th style="width:350px;" ><center>Employee ID</center></th><th style="width:350px;" ><center>Employee Name</center></th></th><th style="width:150px;" ><center>Project ID</center></th><th style="width:350px;" ><center>Project Title</center></th><th style="width:350px;" ><center>Department</center></th><th style="width:100px;" ><center>Designation</center></th><th style="width:100px;" ><center>Project Domain</center></th><th style="width:50px;" ><center>Edit</center></th><th style="width:100px;" ><center>Delete </center></th></tr></thead><tbody>
                 <?php
				 
				   $i=1;
				  $arr=mysql_query("select student_id,subjcet_code,subjectName,Branches_id,Semester_id,Department_id,`id` from tbl_student_subject_master where `school_id`='$sc_id' order by `id`");?>
                  <?php while($row=mysql_fetch_array($arr))
				  {
				        $PRN=$row['student_id'];
				  ?>
                 <tr style="height:30px;color:#808080;">
                    <th style="width:50px;"><b><center><?php echo $i;?></center></b></th>
                     <?php 
					             
					 $getteachername=mysql_query("select std_name,std_Father_name,std_lastname from tbl_student where std_PRN=".$PRN." and school_id='$sc_id'");
					           while($getRows=mysql_fetch_array($getteachername))
							   {
									   $name=$getRows['std_name'];
										$Mname=$getRows['std_Father_name'];
										$Lname=$getRows['std_lastname'];
									$studentName=$name." ".$Mname." ".$Lname;
								}	
					 ?>
					  <th style="width:100px;" ><center><?php echo $row['student_id'];?> </center></th>
                    <th style="width:100px;" ><center><?=$studentName?> </center></th>
                   
					<th style="width:100px;" ><center><?php echo $row['subjcet_code'];?> </center></th>
					<th style="width:300px;"><center><?php echo $row['subjectName'];?></center> </th>
					<th style="width:300px;"><center><?php echo $row['Branches_id'];?></center> </th>
					<th style="width:50px;"><center><?php echo $row['Semester_id'];?></center> </th>
					<th style="width:100px;"><center><?php echo $row['Department_id'];?></center> </th>
					
					
					
                    <th style="width:100px;"><center><?php  $sub_id= $row['id'];?>
                     <a href="edit_school_subject.php?subject=<?=$sub_id; ?>" style="width:100px;"><span class="glyphicon glyphicon-pencil"> </a>
                                 </center>
                    </th>
                    <th style="width:100px;" ><center> <a onClick="confirmation(<?php echo $sub_id; ?> )"><span class="glyphicon glyphicon-trash"></a></center></th>
                 </tr>
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


					  
			
