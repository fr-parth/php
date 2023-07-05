<?php include('Parent_header.php');
if(!isset($_SESSION['id']))
	{
		header('location:index.php');
	}
	$id=$_SESSION['id'];
	$i=0;
    $row=mysql_query("select distinct school_id from tbl_parent where Id='$id'");
	$values=mysql_fetch_array($row);
	/* while($values=mysql_fetch_array($row))
	{
	 $school_id[$i]=$values['school_id'];
	 $i++;
	
	} */
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
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
        

  
      <script>
       $(document).ready(function() {
	  
	    $('#example').DataTable();
} );
        </script>
  
</head>

<body>
    <div class="row">
       <!-- <div class="col-md-4" style="padding:10px;">
        <div style="padding:2px 2px 2px 2px;border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">
        <div style="background-color:#FFFFFF ;">
        <?php $query=mysql_query("select balance_points from tbl_parent where Id='$id' ");
        $results=mysql_fetch_array($query);
        
        ?>
        <div class="row" align="center"><h3>Balance Blue Points</h3></div>
        <div class="row" align="center"><h4 style="color: #719BA7;font-size: 50px;font-weight: bold;">
        
        
         <?php echo $results['balance_points'];?></h4></div>
        <div class="row" align="center" style="padding-top:10px;"> <h4>Points </h4>
        
        
        </div>
       
        
        </div>
        </div>
        </div>-->
        
        
        
   

 

<div class="container" style="padding-top:20px;width:100%;">

<div style="width:100%; height:50px; background-color:#f9f9f9; border:1px solid #CCCCCC;" align="center" >
        	<h1 style="padding-left:20px; margin-top:4px;color:#800080;">Assign Purple Points</h1>
        </div>
        
         <div style="height:20px;"></div>
         
         
        
        
              <div id="no-more-tables" style="padding-top:20px;">
             
             
  <table id="example" class="col-md-12 table-bordered table-striped " >
           
        	
        			
        				<thead>
        			<tr style="background-color:#708090;color:#FFFFFF;">
                	<th>Sr. No.</th>
                    <th>Student Name</th>
                     <th>School Name</th>
                     <th>Balance Points</th>
              
                  <th>Assign</th>
                    
                    
                </tr>
                </thead>
        			
        
            
             <?php $i=1;
			 //for($j=0;$j<count($school_id);$j++)
			 //{
			 	//$sql=mysql_query("SELECT ts.std_complete_name,ts.std_name,ts.std_Father_name,ts.std_lastname,tsr.sc_total_point,tsr.yellow_points,tsr.purple_points,ts.std_PRN,ts.std_complete_name,ts.std_school_name FROM tbl_student ts join tbl_student_reward tsr on ts.std_PRN=tsr.sc_stud_id where ts.school_id='$school_id[$j]' order by ts.school_id");
				$sql=mysql_query("SELECT ts.`school_id`,ts.std_complete_name,ts.std_name,ts.std_Father_name,ts.std_lastname,tsr.sc_total_point,tsr.yellow_points,tsr.purple_points,ts.std_PRN,ts.std_complete_name,ts.std_school_name FROM tbl_student ts LEFT join tbl_student_reward tsr on ts.std_PRN=tsr.sc_stud_id and ts.`school_id`=tsr.`school_id`
				where `parent_id`='$id' order by std_complete_name ");
					 while($result=mysql_fetch_array($sql)){ 
					?>
					<tr>
					<td data-title="Sr.No."><?php echo $i;   ?></td>
					<td data-title="Teacher Name"><?php echo $result['std_complete_name'];?></td>
					<td data-title="School Name"><?php echo $result['std_school_name'];?></td>


					<td data-title="Balance Blue Points"><div class="row" style="padding-bottom:5px;padding-left:8px;">
											<div class="col-md-1 " style="background-color:#92C81A;" >
                        &nbsp;&nbsp;
                        </div>
                        <div  class="col-md-3">
                           <?php echo $result['sc_total_point']." "."Points";?>
                        </div>
                    
     
                        <div style="background-color:#FFFF00;" class="col-md-1">
                        &nbsp;&nbsp;
                        </div>
                        <div  class="col-md-3">
                         
                          <?php echo $result['yellow_points']." "."Points";?>
                     
                        </div>
						 <div style="background-color:#800080;" class="col-md-1">
                        &nbsp;&nbsp;
                        </div>
                        <div  class="col-md-3">
                         
                          <?php echo $result['purple_points']." "."Points";?>
                     
                        </div></td> <?php //echo $result['balance_bluestud_points'];?>

<!--<td data-title="Used Blue Points"><?php //echo $result['used_blue_points'];?></td>-->

<td > <a href="parent_assignpurplepoint_student.php?id=<?php echo $result['std_PRN'];?>&sch_id=<?php echo $result['school_id'];?>"> <input type="button" value="Assign" name="assign" class="btn "/></a></td>





</tr>
<?php  $i++;} //}?>
      
        	</table>
        </div>
             
             
             
             
             
             
             
             
             
             
             
             
             
             
             
             
             
            
            
         
            
            
            
            
            
            
            
            
            </div>
    
		       </div>
       
       </div>


</body>
</html>      
 