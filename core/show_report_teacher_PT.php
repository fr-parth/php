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

<div class="container"  style="padding:30px;" >
        	
            
            	<div style="border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">
                   
                   
                    <div style="background-color:#F8F8F8 ;">
                    <div class="row">
                    <div class="col-md-3 "  style="color:#700000 ;padding:5px;" >&nbsp;&nbsp;&nbsp;&nbsp;
                     <!--  <a href="teacher_setup.php?id=<?=$Get_staff?>">   <input type="submit" class="btn btn-primary" name="submit" value="Add Teacher" style="width:150;font-weight:bold;font-size:14px;"/></a>-->
               			 </div>
              			 <div class="col-md-6 " align="center"  >
                         	<h2>List of Duplicate Teachers </h2>
               			 </div>
                         
                     </div>
               <div class="row" style="padding:10px;" >
             <div class="col-md-12  " id="no-more-tables" >
               <?php $i=0;?>
                  <table class="table-bordered  table-condensed cf" id="example" width="100%;" >
                     <tr style="background-color:#428BCA" ><th style="width:10%;" ><b>Sr.No</b></th><th style="width:20%;"><b>Teacher ID</b></th><th style="width:30%;" >First Name</th><th style="width:30%;" >Middle Name</th><th style="width:30%;" >Last Name</th><th style="width:20%;">Phone No.</th><th style="width:20%;">Email ID</th><th style="width:20%;">Department</th><th style="width:20%;">Gender</th><th style="width:10%;" >Green Balance Points</th><th style="width:10%;" >Green Assigned Points </th><th style="width:10%;" >Blue Balance Points</th><th style="width:10%;" >Blue Shared Points </th>
                        <th style="width:10%;">Delete</th>
                        <th style="width:10%;">Edit</th></thead><tbody>
                 <?php
				 
				   $i=1;
				  $arr=mysql_query("select * from  tbl_raw_teacher where `error_records`='$duplicate' and t_school_id='$sc_id' and batch_id='$B_id'order by id");?>
                  <?php while($row=mysql_fetch_array($arr)){
				  $teacher_id=$row['id'];
				  ?>
                <tr style="color:#808080;" class="active">
                    <td data-title="Sr.No" style="width:10%;" ><b><?php echo $i;?></b></td>
					<td data-title="Teacher ID" style="width:10%;" ><b><?php echo $row['t_id'];?></b></td>
                    <td data-title="Name" style="width:20%;"><?php echo $row['t_name']?></td> 
                    <td data-title="Name" style="width:20%;"><?php echo $row['t_middlename']?></td> 
					<td data-title="Name" style="width:20%;"><?php echo $row['t_lastname']?></td> 
                         <td data-title="Phone" style="width:10%;"><?php echo $row['t_phone'];?> </td>
						  <td data-title="Phone" style="width:0%;"><?php echo $row['t_email'];?> </td>
						 <td data-title="Department" style="width:10%;"><?php echo $row['t_dept'];?> </td>
						 <td data-title="Gender" style="width:10%;"><?php echo $row['t_gender'];?> </td>
                   <td data-title="Green Balance  Points" style="width:10%;">
                                  <?php echo $row['tc_balance_point']; ?> 
                               
                  
                    </td>
                    
                      <td  data-title=" Green Assigned  Points" style="width:10%;">
                                  <?php
								  
								  $sql=mysql_query("select  s.id, sum(s.sc_point) total,s.sc_point,s.sc_teacher_id, s.sc_stud_id, s.point_date, s.sc_studentpointlist_id,t.school_id, t.t_pc,t.t_name,t.tc_balance_point from tbl_student_point s, tbl_teacher t where s.sc_teacher_id = t.id and s.sc_entites_id='103'and t.id='$teacher_id'");
								  $result=mysql_fetch_array($sql);
								  $total = $result['total'];
								  if($total==""|| $total==0)
								  {
								  echo "0";
								 }
								  else
								  {
								   echo $total; 
								   }
								   ?> 
                               
                  
                    </td>
                    <td  data-title="Blue Balance Points" style="width:10%;">
                                  <?php echo $row['balance_blue_points']; ?> 
                               
                  
                    </td>
                    <td  data-title="Blue Assigned Points" style="width:10%;">
                                  <?php 
								  $query=mysql_query("select sum(sc_point) as sc_point  from tbl_teacher_point sp join tbl_teacher s where sp.sc_teacher_id=s.id and sp.sc_entities_id='103' and sp.assigner_id='$teacher_id' ");
								  
								  $test=mysql_fetch_array($query);
								  $sc_point=$test['sc_point'];
								  if($sc_point==""|| $sc_point==0)
								  {
								  echo "0";
								  
								  }
								  else
								  {
								  echo $sc_point;
								  }
								  
								   ?>  
                               
                  
                    </td>
                    
   <td><a onClick="confirmation(<?php echo $teacher_id; ?>)"style="text-decoration:none"><center><img src="images/trash.png" alt="" title="" border="0" /></center>
    </a></td>
    
 <td><a href="teacher_setup.php?edit_id=<?=$teacher_id?>"><center><img src="images/edit.jpg" width="30" height="29" alt="" title="" border="0" /></center>
    </a></td>
                  
                 </tr>
                <?php 
				$i++;
				?>
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

<div class="container"  style="padding:30px;" >
        	
            
            	<div style="border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">
                   
                    
                    <div style="background-color:#F8F8F8 ;">
                    <div class="row">
                    <div class="col-md-3 "  style="color:#700000 ;padding:5px;" >&nbsp;&nbsp;&nbsp;&nbsp;
                   <a href="teacher_report_PT.php">   <input type="submit" class="btn btn-primary" name="submit" value="Back" style="width:150;font-weight:bold;font-size:14px;"/></a>
               			 </div>
              			 <div class="col-md-6 " align="center"  >
                         	
                   				<h2>List of Duplicate Teachers </h2>
               			 </div>
                         
                     </div>
                  
                  
                   
                  
               <div class="row" style="padding:10px;" >
             
         
               <div class="col-md-12  " id="no-more-tables" >
               <?php $i=0;?>
                  <table class="table-bordered  table-condensed cf" id="example" width="100%;" >
                     <thead>
                    	 <tr style="background-color:#428BCA" ><th style="width:10%;" ><b>Sr.No</b></th><th style="width:20%;"><b>Teacher ID</b></th><th style="width:30%;" >First Name</th><th style="width:30%;" >Middle Name</th><th style="width:30%;" >Last Name</th><th style="width:20%;">Phone No.</th><th style="width:20%;">Email ID</th><th style="width:20%;">Department</th><th style="width:20%;">Gender</th></tr>
                        
                       <!-- <th style="width:10%;">Edit</th>-->
                        </thead><tbody>
                 <?php
				 
				   $i=1;
				  $arr=mysql_query("select * from  tbl_raw_teacher where `error_records`='$duplicate' and t_school_id='$sc_id' and batch_id='$B_id'order by id");?>
                  <?php while($row=mysql_fetch_array($arr)){
				  $teacher_id=$row['id'];
				  ?>
                  <tr>  <!--onmouseover="this.style.cursor='pointer';this.style.textDecoration='underline';this.style.color='dodgerblue'" onmouseout="this.style.textDecoration='none';this.style.color='black';"  onclick="window.location='teachers_subjects.php?t_id=<?php echo $row['t_id'];?>'"class="d0" style="padding-top:2px;color:#808080">-->
                
                    <td data-title="Sr.No" style="width:10%;" ><b><?php echo $i;?></b></td>
					<td data-title="Teacher ID" style="width:10%;" ><b><?php echo $row['t_id'];?></b></td>
                    <td data-title="Name" style="width:20%;"><?php echo $row['t_name']?></td> 
                    <td data-title="Name" style="width:20%;"><?php echo $row['t_middlename']?></td> 
					<td data-title="Name" style="width:20%;"><?php echo $row['t_lastname']?></td> 
                         <td data-title="Phone" style="width:10%;"><?php echo $row['t_phone'];?> </td>
						  <td data-title="Phone" style="width:0%;"><?php echo $row['t_email'];?> </td>
						 <td data-title="Department" style="width:10%;"><?php echo $row['t_dept'];?> </td>
						 <td data-title="Gender" style="width:10%;"><?php echo $row['t_gender'];?> </td>
                   
                  
                 </tr>
                <?php 
				$i++;
				?>
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