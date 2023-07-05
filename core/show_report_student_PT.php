<?php
       if(isset($_GET['name']))
	   {
		 // $id=$_GET['name'];
		include_once("school_staff_header.php");	
        $report="";
$results=mysql_query("select * from tbl_school_adminstaff where id=".$id."");
$result=mysql_fetch_array($results);
$sc_id=$result['school_id'];
$stafff=$result['id'];
$B_id=$_GET['batch_id'];
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
        
		
        window.location = "delete_student.php?id="+xxx;
    }
    else
	   {
       }
	   }


</script>
<body bgcolor="#CCCCCC">
<div style="bgcolor:#CCCCCC">
<div>

</div>
<div class="container" style="padding:25px;" >
        	
            
            	<div style="padding:2px 2px 2px 2px;border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">
                   
                    
                    <div style="background-color:#F8F8F8 ;">
                    <div class="row">
                    <div class="col-md-4 "  style="color:#700000 ;padding:5px;" >&nbsp;&nbsp;&nbsp;&nbsp;
                       <a href="student_setup.php?id=<?=$stafff?>">
                          <input type="submit" class="btn btn-primary" name="submit" value="Add Student" style="width:150;font-weight:bold;font-size:14px;"/></a>
               			 </div>
              			 <div class="col-md-6 " >
                         	
                   				<h2>List of Students </h2>
               			 </div>
                         
                     </div>
                  
                  
                   
                  
               <div class="row">
             
               <div class="col-md-1">
               </div>
               <div class="col-md-10 ">
               <?php $i=0;?>
                 <table class="table-bordered" id="example" >
                     <thead>
                    	<tr style="background-color:#428BCA" ><th style="width:2%;" ><b>Sr.No</b></th><th style="width:20%;" >Student PRN</th><th style="width:20%;" >First Name</th><th style="width:20%;" >Last Name</th><th style="width:5%;">Branch</th><th style="width:3%;" >Year</th></th><th style="width:10%;" >Phone</th><th style="width:10%;" >Star</th></tr></thead><tbody>
                 <?php
				 
				   $i=1;
				  
				  $arr=mysql_query("select std_name,std_Father_name,std_lastname,std_PRN,std_branch,std_year,std_class,sc_total_point,std_div,std_email,std_phone from tbl_student s left outer join tbl_student_reward sr on s.id=sr.sc_stud_id where school_id='$sc_id' and batch_id='$B_id' and error_records like 'correct' order by s.std_PRN DESC");?>
                  <?php while($row=mysql_fetch_array($arr)){?>
                   <?php
							$star_count=0;
							$sc_total_point=$row['sc_total_point'];
							 $rows=mysql_query("select * from star_table");
								while($values=mysql_fetch_array($rows))
								{
								   $from=$values['from'];
								   $to=$values['to'];
								   if($to!=0)
								   {
									 if($from<=$sc_total_point && $to>=$sc_total_point)
									 {
											$star_count=$values['star_count'];
									 }
								   }
								   else
								   {
									 if($from<=$sc_total_point)
									   {
											 $star_count=$values['star_count'];
									   }
								   
								   }
								}
								
						?>
                 <tr style="height:30px;color:#808080;">
                    <th style="width:2%;" ><b><?php echo $i;?></b></th>
					<th style="width:10%;" align="left"><?php echo $row['std_PRN'];?> </th>
                    <th style="width:20%;" align="left"><?php echo $row['std_name'];?> </th>
					
					<th style="width:20%;" align="left"><?php echo $row['std_lastname'];?> </th>
					<th style="width:20%;" align="left"><?php echo $row['std_branch'];?> </th>
                     <th style="width:5%;" align="left"><?php echo $row['std_year'];?> </th>
                 <!--   <th style="width:3%;">
                                  <?php echo $row['std_div']; ?> -->
                                 
                  
                    </th>
                    
                    <!--  <th style="width:10%">
                                  <?php echo $row['std_email']; ?>  -->
                              
                  
                    </th>
                     <th style="width:15%"><center>
                                  <?php echo $row['std_phone']; ?> 
                                 </center>
                  
                    </th>
                     <th style="width:10%">
                                 <?php 
							  $j=1;
                                    while($j<=$star_count)
									{
									$j++;
									 ?>
                                     <img src='image/stud_star.jpg' style="height:20px;width:15px;" />
                                     <?php
									
									}
									
									?>
                                
                  
                    </th>
                  
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

           
           <?php
		   }
		   else
		   {
			   ?>
               <?php include('scadmin_header.php');
           $report="";
           $id=$_SESSION['id'];
           $fields=array("id"=>$id);
	       $table="tbl_school_admin";
		   
		   $smartcookie=new smartcookie();
		   
$results=$smartcookie->retrive_individual($table,$fields);
$result=mysql_fetch_array($results);
$sc_id=$result['school_id'];
$duplicate=$_GET['error'];
$B_id=$_GET['batch_id'];
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
        
		
        window.location = "delete_student.php?id="+xxx;
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
                   
                    
                    <div style="background-color:#F8F8F8 ;">
                    <div class="row">
                    <div class="col-md-4"  style="color:#700000 ;padding:5px;" >&nbsp;&nbsp;&nbsp;&nbsp;
                       <a href="student_report_PT.php">
                          <input type="submit" class="btn btn-primary" name="submit" value="Back" style="width:150;font-weight:bold;font-size:14px;"/></a>
               			 </div>
              			 <div class="col-md-6 " >
                         	
                   				<h2>List of Duplicates Students </h2>
               			 </div>
                         
                     </div>
                  
                  
                   
                  
               <div class="row">
             
               <div class="col-md-1">
               </div>
               <div class="col-md-10 ">
               <?php $i=0;?>
                  <table class="table-bordered" id="example" >
                     <thead>
                    	<tr style="background-color:#428BCA" ><th style="width:2%;" ><b>Sr.No</b></th><th style="width:20%;" >Student PRN</th><th style="width:20%;" >First Name</th><th style="width:20%;" >Middle Name</th><th style="width:20%;" >Last Name</th><th style="width:5%;">Branch</th><th style="width:3%;" >Year</th></th><th style="width:10%;" >Error Status</th></tr></thead><tbody>
                 <?php
				 
				   $i=1;
				 
				  $arr=mysql_query("select * from  tbl_raw_student where `error_records`='$duplicate' and `s_school_id`='$sc_id' and batch_id='$B_id'");?>
                  <?php while($row=mysql_fetch_array($arr)){?>
                   <?php
							$star_count=0;
							$sc_total_point=$row['sc_total_point'];
							 $rows=mysql_query("select * from star_table");
								while($values=mysql_fetch_array($rows))
								{
								   $from=$values['from'];
								   $to=$values['to'];
								   if($to!=0)
								   {
									 if($from<=$sc_total_point && $to>=$sc_total_point)
									 {
											$star_count=$values['star_count'];
									 }
								   }
								   else
								   {
									 if($from<=$sc_total_point)
									   {
											 $star_count=$values['star_count'];
									   }
								   
								   }
								}
								
						?>
                 <tr style="height:30px;color:#808080;">
                    <th style="width:2%;" ><b><?php echo $i;?></b></th>
					<th style="width:10%;" align="left"><?php echo $row['s_PRN'];?> </th>
                    <th style="width:20%;" align="left"><?php echo $row['s_firstname'];?> </th>
					<th style="width:20%;" align="left"><?php echo $row['s_middlename'];?> </th>
					<th style="width:20%;" align="left"><?php echo $row['s_lastname'];?> </th>
					<th style="width:20%;" align="left"><?php echo $row['s_branch'];?> </th>
                     <th style="width:5%;" align="left"><?php echo $row['s_year'];?> </th>
					 <th style="width:5%;" align="left"><?php echo $row['error_records'];?> </th>
                
                    <!-- <th style="width:10%">
                                 <?php 
							  $j=1;
                                    while($j<=$star_count)
									{
									$j++;
									 ?>
                                     <img src='image/stud_star.jpg' style="height:20px;width:15px;" />
                                     <?php
									
									}
									
									?>
                                
                  
                    </th>-->
                  
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

               
               <?php
			   }
		   ?>

