
<?php  
         if(isset($_GET['name']))
	       {
		  	//$id=$_SESSION['staff_id'];
	    include_once("school_staff_header.php");
		$report="";
		$results=mysql_query("select * from tbl_school_adminstaff where id=".$id."");
        $result=mysql_fetch_array($results);
	    $Get_staff=$result['id'];
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
        
        window.location = "delete_teacher.php?id="+xxx;
    }
    else{
       
    }
}

</script>
<body bgcolor="#CCCCCC"> 
<div style="bgcolor:#CCCCCC">

<div class="container" >
        	
            
            	
                   
                   
                    <div style="background-color:;">
                    <div class="row">
                    <div class="col-md-3 "  style="color:#700000 ;padding:5px;" >&nbsp;&nbsp;&nbsp;&nbsp;
                     <!--  <a href="teacher_setup.php?id=<?=$Get_staff?>">   <input type="submit" class="btn btn-primary" name="submit" value="Add Teacher" style="width:150;font-weight:bold;font-size:14px;"/></a>-->
               			 </div>
							<div class="col-md-3 " style="margin-top: 20px;margin-left: -60px;">
<a href="sd_upload_report.php" style="text-decoration:none;">
<input type="button" class="btn btn-danger" name="Back" value="Back" style="width:80px;font-weight:bold;font-size:14px;"/></a>
    </div> 
              			 <div class="col-md-6 " align="center"  >
                         	<h2>Batch Master</h2>
               			 </div>
                         
                     </div>
               <div class="row" >
             <div class="#" id="no-more-tables" style="margin-left:-100px;">
               <?php $i=0;?>
                  <table class="table-bordered" id="example" width="50;">
                     <tr style="background-color:#428BCA" >
					 <th style="width:10%;" ><b>Sr.No</b></th>
					 <th style="width:10%;"><b>Uploaded_Batch_ID</b></th>
					 <th style="width:10%;" >Input File name</th>
					 <th style="width:8%;"><b>Uploaded Date and Time</b></th>
					 <th style="width:8%;">Uploaded Records </th>
					<th style="width:8%;">Errors Records</th>
					<th style="width:8%;">Duplicate Records</th>
					<th style="width:8%;">Inactive Records</th>
					<th style="width:8%;">Deleted Records</th>
					<th style="width:8%;">Correct Records</th>
					<th style="width:8%;">Updated Records</th>
					<th style="width:8%;">Inserted Records </th>
					<th style="width:8%;">Existing Records </th>
					<th style="width:8%;">Uploaded By</th>
					<!--<th style="width:20%;">Table Name</th>
					<th style="width:10%;">DB Table Name</th>-->
					
					
					</tr>
					</thead><tbody>
                 <?php
				
				        // $order=mysql_query("select * from tbl_Batch_Master order by uploaded_date_time DESC");
				   $i=1;
				   
				  $arr=mysql_query("select * from tbl_Batch_Master order by uploaded_date_time DESC ");?>
				  <?php while($row=mysql_fetch_array($arr)){?>
                  
                 <tr>
                    <td style="width:10%;"><?php echo $i;?></td>
					<td style="width:10%;"><?php echo $row['batch_id'];?></td>
                    <td style="width:10%;"><?php echo $row['input_file_name'];?></td> 
                    <td style="width:8%;"><?php echo $row['uploaded_date_time'];?></td> 
					<td style="width:8%;"><?php echo $row['num_records_uploaded'];?></td> 
                    <td style="width:8%;"><?php echo $row['num_errors_records'];?></td> 
					<td style="width:8%;"><?php echo $row['num_duplicates_record'];?></td> 					 
                    <td style="width:8%;"><?php echo $row['num_records_inactivated'];?></td> 
					<td style="width:8%;"><?php echo $row['num_records_deleted'];?></td> 
					<td style="width:8%;"><?php echo $row['num_correct_records'];?></td> 
					<td style="width:8%;"><?php echo $row['num_records_updated'];?></td> 
					<td style="width:8%;"><?php echo $row['num_newrecords_inserted'];?> </td>
					<td style="width:8%;"><?php echo $row['existing_records'];?> </td>
					<td style="width:8%;"><?php echo $row['uploaded_by'];?></td>
					
					<!--<td style="width:13%;"><?php //echo $row['display_table_name'];?> </td> 
				    <td style="width:10%;"><?php //echo $row['db_table_name'];?> </td>-->
					
                 
                 </tr>
                <?php 
				$i++;
				?>
                 <?php }?>
                  
                  </tbody>
                  </table>
                
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
<!----------------------------------------------------End---School Staff------------------------------------------------------------->
</html>

<?php
	  }
	  
	else
	  {
	   ?>
         <?php
		 
      include('scadmin_header.php');
     $report="";

$smartcookie=new smartcookie();
           $id=$_SESSION['id'];
           $fields=array("id"=>$id);
		   $table="tbl_school_admin";
		   $smartcookie=new smartcookie();
		   
		   
		 // echo $user;exit; HR Admin School Admin
		   
$results=$smartcookie->retrive_individual($table,$fields);
$result=mysql_fetch_array($results);
$sc_id=$result['school_id'];
$table_name=$_GET['tbl_name'];
$school_id=$_SESSION['school_id'];

//$tbl_name1 is added by Sayali Balkawade for SMC-4366 on 16/02/2020
if(isset($_GET['tbl_name1'])){
$table_name=$_GET['tbl_name1'];
}

	switch($table_name){		

		case 'tbl_teacher':
		
		$tbl_name='Teacher';
		$tbl_name1='Manager';

		break;

		case 'tbl_department_master':
		$tbl_name='Department';
		$tbl_name1='Department Master';
		break;

		case 'tbl_academic_Year':	
		$tbl_name='Academic Year';
		$tbl_name1='Financial  Year';
		break;

		case 'tbl_semester_master':	
		$tbl_name='Semester Master';
		$tbl_name1='Default Duration Master';
		break;

		case 'tbl_student_subject_master':	
		$tbl_name='Student Subject';
		break;

		case 'tbl_teacher_subject_master':	
		$tbl_name='Teacher Subject';
		break;

		case 'tbl_degree_master':	
		$tbl_name='Degree Master';
		$tbl_name1='Corporate  Master';
		break;

		case 'tbl_branch_master':	
		$tbl_name='Branch Master';
		$tbl_name1='Section  Master';
		break;

		case 'Division':	
		$tbl_name='Division Master';
		$tbl_name1='Location  Master';
		break;

		case 'Class':	
		$tbl_name='Class Master';
		$tbl_name1='Team  Master';
		break;

		case 'tbl_school_subject':	
		$tbl_name='Subject Master';
		$tbl_name1='Project';
		break;

		case 'tbl_CourseLevel':	
		$tbl_name='Course Level';
		$tbl_name1='Employee Level';
		break;

		case 'StudentSemesterRecord':	
		$tbl_name='Student Semester';
		break;

		case 'tbl_student':	
		$tbl_name='Student';
		$tbl_name1='Employee';
		break;

		case 'tbl_parent':	
		$tbl_name='Parent';
		break;

		case 'Branch_Subject_Division_Year':	
		$tbl_name='Branch_Subject_Division_Year';
		break;

		case 'tbl_class_subject_master':	
		$tbl_name='Class Subject';
		break;
	}
//}


?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

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
table.dataTable {
  width: 100%;
  margin-left: -50px!important;
  clear: both;
  border-collapse: separate;
  border-spacing: 0;
	
}
</style>
        



<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
 <link rel="stylesheet" href="css/bootstrap.min.css">
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.dataTables.min.js"></script>

<script>
$(document).ready(function() {
    $('#example').dataTable( {
	
      
    } );
} );

</script>


<script>


function confirmation(xxx) {

    var answer = confirm("Are you sure you want to delete?")
    if (answer){
        
        window.location = "delete_teacher.php?id="+xxx;
    }
    else{
       
    }
}

</script>
<body bgcolor="#CCCCCC"> 
<div style="bgcolor:#CCCCCC">

<div class="container"  >
        	
            
            	
                   
                   
<div style="background-color: ;">
<div class="row">
<div class="col-md-1 " style="margin-top: 20px;margin-left: -60px;">
<a href="sd_upload_report.php" style="text-decoration:none;">
<input type="button" class="btn btn-danger" name="Back" value="Back" style="width:80px;font-weight:bold;font-size:14px;"/></a>
    </div>
	 <div class="col-md-11" align="center"  >
 		<h2>Batch Master</h2>
	 </div>
 
</div>
<div class="row">
  <div class="col-md-4">
<div class="dropdown" id="drop" style="padding-left:500px">
  <button class="btn btn-default dropdown-toggle"  type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
 <?php if(isset($tbl_name) && $user=='HR Admin')
 		{echo $tbl_name1;} 
 		elseif(isset($tbl_name) && $user=='School Admin')
 			{echo $tbl_name;}
 		else echo 'Table Name';?>
    <span class="caret"></span>
  </button>

  <ul class="dropdown-menu"  role="menu" aria-labelledby="dropdownMenu1" style="margin-left:500px;">
  
   <!-- Below condtiotn is added by Sayali Balkawade for SMC-4366 on 16/02/2020-->
  <?php if($user=='HR Admin')
  {
	  $sql1=mysql_query("Select table_name,tbl_name from tbl_datafile_weightage where school_type='organization' order by seq_no");

   while($row=mysql_fetch_array($sql1)){ ?>
	<?php $a=$row['table_name'];
		$b= $row['tbl_name'];?>
	 
   <li role="presentation"><a role="menuitem" tabindex="-1" href="Batch_Master_PT.php?tbl_name=<?php echo $a;?>&tbl_name=<?php echo $b;?>"><?php echo $row['table_name'];?>
   <?php }?></a></li> 
  

	  <?php } else {
	  	//echo "Select table_name,tbl_name from tbl_datafile_weightage where school_type='school' order by seq_no";exit;
  $sql1=mysql_query("Select table_name,tbl_name from tbl_datafile_weightage where school_type='school' order by seq_no");
   while($row=mysql_fetch_array($sql1)){ 
   	$a=$row['table_name'];
		$b= $row['tbl_name'];?>
   <li role="presentation"><a role="menuitem" tabindex="-1" href="Batch_Master_PT.php?tbl_name=<?php echo $a;?>&tbl_name=<?php echo $b;?>"><?php echo $row['table_name'];?>
   <?php }?></a></li>
   
	  <?php }?>
  </ul>
</div>
</div>  
</div> 
               <div class="row" >
             <div class="#" id="no-more-tables" style="margin-center:50px;" >
               <?php $i=0;?>
                  <table class="table-bordered" id="example"  >
                     <tr style="background-color:#428BCA" >
					 <th style="width:10%;" ><b>Sr.No</b></th>
					 <th style="width:10%;"><b>Uploaded_Batch_ID</b></th>
					 <th style="width:10%;" >Input File name</th>
					 <th style="width:8%;"><b>Batch_Date</b></th>
					 <th style="width:8%;"><b>Batch_Time</b></th>
					 <th style="width:8%;">Uploaded Records </th>
					<th style="width:8%;">Errors Records</th>
					<th style="width:8%;">Duplicate Records</th>
					<th style="width:8%;">Inactive Records</th>
					<th style="width:8%;">Deleted Records</th>
					<th style="width:8%;">Correct Records</th>
					<th style="width:8%;">Updated Records</th>
					<th style="width:8%;">Inserted Records </th>
					<th style="width:8%;">Existing Records </th>
					<th style="width:8%;">Uploaded By</th>
					<!--<th style="width:20%;">Table Name</th>
					<th style="width:10%;">DB Table Name</th>-->
					
					</tr>
					</thead>
					<tbody>
                 <?php
				 $sc_id=$_SESSION['school_id'];
				   $i=1;
				    //Below condition is added by Sayali Balkawade for SMC-4366 on 16/02/2020
				   if($user='School Admin')

				   {  //echo $tbl_name;echo "select * from tbl_Batch_Master where display_table_name='$tbl_name' and `school_id`='$sc_id' group by `batch_id` order by `uploaded_date_time` DESC ";exit;
				  $arr=mysql_query("select * from tbl_Batch_Master where display_table_name='$tbl_name' and `school_id`='$sc_id' AND (isnull(status) OR status!='N') group by `batch_id` order by `uploaded_date_time` DESC ");
				   }
				   else 
				   {
				  $arr=mysql_query("select * from tbl_Batch_Master where db_table_name='$tbl_name1' and `school_id`='$sc_id' AND (isnull(status) OR status!='N') group by `batch_id` order by `uploaded_date_time` DESC ");
				   }
				  
				  ?>
			

				 <?php while($row=mysql_fetch_array($arr)){
					   
						
						$date_time=$row['uploaded_date_time'];
						$first_name=explode(" ",$date_time); 
						$date=$first_name[0];
						$time=$first_name[1];

					   ?>
                 <tr>
                    <td style="width:10%;"><?php echo $i;?></td>
					<td style="width:10%;"><a href="All_Batch_MasterPT.php?batch_id=<?php echo $row['batch_id'];?>&tbl_name=<?php echo $tbl_name;?>&records_size=<?php echo $row['num_records_uploaded'];?>&duplicate=<?php echo $row['num_duplicates_record'];?>&error=<?php echo $row['num_errors_records'];?>"><?php echo $row['batch_id'];?></td>
                    <td style="width:10%;"><?php echo $row['input_file_name'];?></td> 
                    <td style="width:8%;"><?php echo $date;?></td> 
					<td style="width:8%;"><?php echo $time;?></td> 
					<td style="width:8%;"><?php echo $row['num_records_uploaded'];?></td> 
                    <td style="width:8%;"><?php echo $row['num_errors_records'];?></td> 
					<td style="width:8%;"><?php echo $row['num_duplicates_record'];?></td>  					 
                    <td style="width:8%;"><?php echo $row['num_records_inactivated'];?></td> 
					<td style="width:8%;"><?php echo $row['num_records_deleted'];?></td>
					<td style="width:8%;"><?php echo $row['num_correct_records'];?></td> 
					<td style="width:8%;"><?php echo $row['num_records_updated'];?></td>
					<td style="width:8%;"><?php echo $row['num_newrecords_inserted'];?> </td>
					<td style="width:8%;"><?php echo $row['existing_records'];?> </td>
					<td style="width:8%;"><?php echo $row['uploaded_by'];?></td>
					<!--<td style="width:13%;"><?php //echo $row['display_table_name'];?> </td> 
				    <td style="width:10%;"><?php// echo $row['db_table_name'];?> </td>-->
					
                 
                 </tr>
                <?php 
				$i++;
				?>
                 <?php }?>
                  
                  </tbody>
                  </table>
                
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
<?php
 }
?>