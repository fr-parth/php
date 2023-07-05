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

<div class="container"  style="padding:30px;" >
        	
            
            	<div style="border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">
                   
                   
                    <div style="background-color:#F8F8F8 ;">
                    <div class="row">
                    <div class="col-md-3 "  style="color:#700000 ;padding:5px;" >&nbsp;&nbsp;&nbsp;&nbsp;
                     <!--  <a href="teacher_setup.php?id=<?=$Get_staff?>">   <input type="submit" class="btn btn-primary" name="submit" value="Add Teacher" style="width:150;font-weight:bold;font-size:14px;"/></a>-->
               			 </div>
              			 <div class="col-md-6 " align="center"  >
                         	<h2>Batch Master</h2>
               			 </div>
                         
                     </div>
               <div class="row" style="padding:10px;" >
             <div class="col-md-12  " id="no-more-tables" >
               <?php $i=0;?>
                  <table class="table-bordered  table-condensed cf" id="example" width="100%;" >
					<tr style="background-color:#428BCA" >
					<th style="width:10%;"><b>Sr.No</b></th>
					<th style="width:10%;"><b>Batch ID</b></th>
					<th style="width:30%;">Input File name</th>
					<th style="width:20%;"><b>Uploaded Date and Time</b></th>
					<th style="width:20%;">No. Records Uploaded</th>
					<th style="width:20%;">No. of Errors Records</th>
					<th style="width:20%;">No. of Duplicate Records</th>
					<th style="width:20%;">No. Correct Records</th>
					<th style="width:20%;">No. Updated Records</th>
					<th style="width:20%;">Table Name</th>
					<th style="width:10%;">DB Table Name</th>
					<th style="width:10%;">Uploaded By</th>
					</tr>
					</thead>
					<tbody>
                 <?php
				 
				   $i=1;
				  $arr=mysql_query("select * from tbl_Batch_Master ");?>
				  <?php while($row=mysql_fetch_array($arr)){?>
                  
                 <tr>
                    <td style="width:10%;"><?php echo $i;?></td>
					<td style="width:9%;"><?php echo $row['batch_id'];?></td>
                    <td style="width:15%;"><?php echo $row['input_file_name'];?></td> 
                    <td style="width:15%;"><?php echo $row['uploaded_date_time'];?></td> 
					<td style="width:15%;"><?php echo $row['num_records_uploaded'];?></td> 
                    <td style="width:15%;"><?php echo $row['num_errors_records'];?></td> 
					<td style="width:15%;"><?php echo $row['num_duplicates_record'];?></td> 
					<td style="width:15%;"><?php echo $row['num_correct_records'];?></td> 
					<td style="width:15%;"><?php echo $row['num_records_updated'];?></td> 
					<td style="width:13%;"><?php echo $row['display_table_name'];?> </td> 
				    <td style="width:10%;"><?php echo $row['db_table_name'];?> </td>
					<td style="width:8%;"><?php echo $row['uploaded_by'];?></td>
                 
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
		 
      include('hr_header.php');
     $report="";

	$smartcookie=new smartcookie();
           $id=$_SESSION['id'];
           $fields=array("id"=>$id);
		   $table="tbl_school_admin";
		   $smartcookie=new smartcookie();
		   
$results=$smartcookie->retrive_individual($table,$fields);
$result=mysql_fetch_array($results);
$sc_id=$result['school_id'];
$tbl_name=$_GET['table_name'];
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

<div class="container"  style="padding:30px;" >
        	
            
            	<div style="border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">
                   
                   
                    <div style="background-color:#F8F8F8 ;">
                    <div class="row">
                    <div class="col-md-3 "  style="color:#700000 ;padding:5px;">&nbsp;&nbsp;&nbsp;&nbsp;
                     <!--  <a href="teacher_setup.php?id=<?=$Get_staff?>">   <input type="submit" class="btn btn-primary" name="submit" value="Add Teacher" style="width:150;font-weight:bold;font-size:14px;"/></a>-->
               			 </div>
              			 <div class="col-md-6 " align="center"  >
                         	<h2>Batch Master</h2>
               			 </div>
                         
                     </div>
					  <div class="row">
  <div class="col-md-4">
<div class="dropdown" id="drop" style="padding-left:500px">
  <button class="btn btn-default dropdown-toggle"  type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
	Table Name
    <span class="caret"></span>
  </button>

  <ul class="dropdown-menu"  role="menu" aria-labelledby="dropdownMenu1" style="margin-left:502px;">
  
   <?php $sql1=mysql_query("Select display_table_name from tbl_Batch_Master group by display_table_name" );?>

	  <?php while($row=mysql_fetch_array($sql1)){ ?>
	 
   <li role="presentation"><a role="menuitem" tabindex="-1" href="Batch_Master_PT.php?table_name=<?php echo $row['display_table_name'];?>"><?php echo $row['display_table_name'];?><?php }?></a></li>
    
  </ul>
</div>
</div>  
</div> 
            <div class="row" style="padding:10px;" >
				<div class="col-md-12  " id="no-more-tables" >
					<?php $i=0;?>
                  <table class="table-bordered  table-condensed cf" id="example" width="100%;" >
                    <tr style="background-color:#428BCA" >
					 
						<th style="width:10%;" ><b>Sr.No</b></th>
						<th style="width:10%;"><b>Batch ID</b></th>
						<th style="width:30%;" >Input File name</th>
						<th style="width:20%;"><b>Date</b></th>
						<th style="width:20%;"><b>Time</b></th>
						<th style="width:20%;">No. Records Uploaded</th>
						<th style="width:20%;">No. of Errors Records</th>
						<th style="width:20%;">No. of Duplicate Records</th>
						<th style="width:20%;">No. Correct Records</th>
						<th style="width:20%;">No. Updated Records</th>
						<th style="width:20%;">Table Name</th>
						<th style="width:10%;">DB Table Name</th>
						<th style="width:10%;">Uploaded By</th>
					</tr>
					
					</thead>
				<tbody>
                 <?php
				 
				   $i=1;
				  $arr=mysql_query("select * from tbl_Batch_Master where display_table_name='$tbl_name' and `school_id`='$sc_id' group by `batch_id` order by `batch_id` ASC ");?>
				  <?php while($row=mysql_fetch_array($arr)){
					   
						
						$date_time=$row['uploaded_date_time'];
						$first_name=explode(" ",$date_time); 
						$date=$first_name[0];
						$time=$first_name[1];

					   ?>
                 <tr>
                    <td style="width:10%;"><?php echo $i;?></td>
					<td style="width:9%;"><a href="All_Batch_MasterPT.php?batch_id=<?php echo $row['batch_id'];?>&table_name=<?php echo $tbl_name;?>&records_size=<?php echo $row['num_records_uploaded'];?>"><?php echo $row['batch_id'];?></td>
                    <td style="width:15%;"><?php echo $row['input_file_name'];?></td> 
                    <td style="width:15%;"><?php echo $date;?></td> 
					<td style="width:15%;"><?php echo $time;?></td> 
					<td style="width:15%;"><?php echo $row['num_records_uploaded'];?></td> 
                    <td style="width:15%;"><?php echo $row['num_errors_records'];?></td> 
					<td style="width:15%;"><?php echo $row['num_duplicates_record'];?></td> 
					<td style="width:15%;"><?php echo $row['num_correct_records'];?></td> 
					<td style="width:15%;"><?php echo $row['num_records_updated'];?></td> 
					<td style="width:13%;"><?php echo $row['display_table_name'];?> </td> 
				    <td style="width:10%;"><?php echo $row['db_table_name'];?> </td>
					<td style="width:8%;"><?php echo $row['uploaded_by'];?></td>
                 
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