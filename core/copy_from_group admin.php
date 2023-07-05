<?php
include("conn.php");
include('scadmin_header.php');?>

<?php
$report="";

/*$id=$_SESSION['id'];*/
           $fields=array("id"=>$id);
		 /*  $table="tbl_school_admin"; */
		   $smartcookie=new smartcookie();
		   
$results=$smartcookie->retrive_individual($table,$fields);
$result=mysql_fetch_array($results);

$sc_id=$result['school_id'];
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="css/bootstrap.min.css">
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">

<title>Untitled Document</title>
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
function confirmation(xxx) {
    var answer = confirm("Are you sure you want to delete")
    if (answer){
        
        window.location = "delete_school_subject.php?id="+xxx;
		
		
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
                    <div class="col-md-3 "  style="color:#700000 ;padding:5px;" >&nbsp;&nbsp;&nbsp;&nbsp;
                       <a href="add_school_subject.php">   <input type="submit" class="btn btn-primary" name="submit" value="Add <?php echo $dynamic_subject;?>" style="width:110px;font-weight:bold;font-size:14px;"/></a>
               			 </div>
						 <div class="col-md-6 "  style="color:#700000 ;padding:5px;" >&nbsp;&nbsp;&nbsp;&nbsp;
                       <a href=""><input type="submit" class="btn btn-primary" name="submit" value="Add group admin" style="width:110px;font-weight:bold;font-size:14px;"/></a>
               			 </div>
              			 <div class="col-md-6 " align="center"  >
                         	
                   				<h2> <?php echo $dynamic_subject;?></h2>
               			 </div>
                         
                     </div>
                  
                  
                   
                  
               <div class="row">
             
               <div class="col-md-2">
               </div>
              <div class="col-md-12" id="no-more-tables" >
               <?php $i=0;?>
                  <table id="example" class="display" width="100%" cellspacing="0">
                     <thead>
                    	<tr ><th style="width:50px;" ><b><center>Sr.No</center></b></th><th style="width:150px;" ><center><?php echo $dynamic_subject;?> Code</center></th><th style="width:350px;" ><center><?php echo $dynamic_subject;?> Name</center><!--<th style="width:40px;" ><center>Credit</center></th></th><!--<th style="width:350px;" ><center>Branch Name</center></th>--><th style="width:50px;" ><center>Edit</center></th><th style="width:100px;" ><center>Delete </center></th></tr></thead><tbody>
                 <?php
				 
				   $i=1;
				  $arr=mysql_query("select * from `tbl_games` where school_id='$sc_id' ORDER BY subject");  ?>
				   
                  <?php while($row=mysql_fetch_array($arr)){?>
                 <tr class="active" style="height:30px;color:#808080;">
                    <td data-title="Sr.No" style="width:50px;"><b><center><?php echo $i;?></center></b></td>
					<td data-title="Subject Code" style="width:50px;" ><center><?php echo $row['Subject_Code'];?> </center></td>
					<td data-title="Subject" style="width:420px;"><center><?php echo $row['subject'];?></center> </td>
					<!--<td data-title="Subject" style="width:50px;"><center><?//php echo $row['subject_credit'];?></center> </td>-->
					<!--<td data-title="Branch Id" style="width:420px;"><center><?//php echo $row['Dept_id'];?></center> </td>-->
					
					
                    <td style="width:100px;"><center><?php  $sub_id= $row['id'];?>
                                  <a href="edit_school_subject.php?subject=<?php echo $sub_id; ?>" style="width:100px;"><span class="glyphicon glyphicon-pencil"></span> </a>
                                 </center>
                    </td>
                    <td style="width:100px;" ><center> <a onClick="confirmation(<?php echo $sub_id; ?> )"><span class="glyphicon glyphicon-trash"></span></a></center></td>
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
                      <div class="col-md-3"  align="center" id="error">
                      <div style="color:#FF0000;">
                      <?php echo $report;?>
                      </div>
                      <div style="color:#009900;"><?php if($_GET['successreport']){echo $_GET['successreport'];}?></div>
               			</div>
                 
                    </div>
                      
                
                  
                 
                    
                    
                  
               </div>
               </div>
</body>
</html>
