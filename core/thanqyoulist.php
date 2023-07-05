<?php

//include('hr_header.php');
include('scadmin_header.php');

?>

<?php
$report="";

if($_SESSION['usertype']=='HR Admin Staff' OR $_SESSION['usertype']=='School Admin Staff')
	{
		$sc_id1=$_SESSION['school_id']; 
		$query2 = mysql_query("select id from tbl_school_admin where school_id ='$sc_id1'");

    $value2 = mysql_fetch_array($query2);

    $id = $value2['id'];
		
		
	}
	else
	{
		$id = $_SESSION['id'];
	}
           $fields=array("id"=>$id);
		   $table="tbl_school_admin";
		   
		   $smartcookie=new smartcookie();
		   
$results=$smartcookie->retrive_individual($table,$fields);
$result=mysql_fetch_array($results);
$sc_id=$result['school_id'];
$group_member_id=$result['group_member_id'];
$report="";
//Changes done by Pranali on 02-07-2018 for bug SMC-3214
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
<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
 <link rel="stylesheet" href="css/bootstrap.min.css">
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.dataTables.min.js"></script>
	
<script>

function confirmation(xxx) {

    var answer = confirm("Are you sure you want to delete?")
    if (answer){
        alert('record deleted successfully');
        window.location = "delete_thanqyouschool.php?id="+xxx;
    }
    else{
       
    }
	}
	
</script>
<script>

$(document).ready(function() {
    $('#thanq').dataTable( {
      
    } );
} );
</script>
<body bgcolor="#CCCCCC">
<div style="bgcolor:#CCCCCC">
<div>

</div>
<div class="container" style="padding:25px;" >
        	
            
            	<div style="padding:2px 2px 2px 2px;border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">
                   
                    
                    <div style="background-color:#F8F8F8 ;">
                    <div class="row" style="padding-left:30px;">
                    <div class="col-md-4"  style="color:#700000 ;padding:5px;" >
                       <a href="addthanqyouschool.php">
                          <input type="button" class="btn btn-primary" name="submit" value="Add ThanQ-Reason" style="width:150;font-weight:bold;font-size:14px;"/></a>
               			</div>
                        <div class="col-md-1"></div>
              		<div class="col-md-4" style="padding-right:60px;margin-right:60px;">
                         	
                   			<h3>ThanQ Reason List </h3>
               			 </div>
                 <div class="btn-group" style="padding:20px;">
                   
                    <?php if($group_member_id=='0' || $group_member_id=='')
                    { ?>
                    
                    
                     <a href="copy_thanqyou.php"><input type="submit" class="btn btn-primary" name="copy" value="Copy from Cookieadmin" style="font-weight:bold;font-size:14px;margin-left: 800px;margin-top: -70px;"/></a>
                    <?php }
                    else
                    { ?>
                       
                        <a href="copyGroupToSchool.php"><input type="submit" class="btn btn-primary" name="copy" value="Copy from Groupadmin" style="font-weight:bold;font-size:14px;margin-left: 800px;margin-top: -70px;"/></a>
                        
                <?php   } ?>
                </div>
				 
					<!-- finish-->
	                        
                        </div> 
                    
                <div class="row" style="padding-top:20px;">
                <div class="col-md-3"></div>
        
                    <div class="col-md-6">
      
        	
            	<div style="background-color:#FFFFFF; border:1px solid #CCCCCC;" align="right" id="no-more-tables">
                
                <!--Pagination done by Pranali -->
                <table id="thanq" class="table-bordered table-condensed cf" cellpadding="2" cellspacing="2" >
                                  <thead>    
                    	<tr align="left" style="width:100%; background-color:#999999; color:#FFFFFF; height:30px;"><th>
                        Sr. No.</th><th>Reason</th><th>Edit</th><th>Delete</th></tr>
						</thead><tbody>
                        <?php
							$i=1;
							$sp_id1=$_SESSION['id'];
						
							
							$arr = mysql_query("SELECT * FROM tbl_thanqyoupointslist  WHERE school_id='$sc_id' ORDER BY id");
							while($row = mysql_fetch_array($arr))
							{
							
						?>
                        <tr align="left"><td><?php echo $i;?></td><td><?php echo $row['t_list'];?></td>
                         <td><a href="addthanqyouschool.php?id=<?php echo $row['id'];  ?>" ><span class="glyphicon glyphicon-pencil"></span></a></td>
                     <td> <a onclick="confirmation(<?php echo $row['id']; ?> )"><span class="glyphicon glyphicon-trash"></span></a></td>
                    </tr>
                        <?php
							$i++;
							}
						?>
						</tbody>
                    </table>
                	
                <?php echo $report;?>
                </div>
                
                
              
            </div>
            
            
            </div>
            </div>
                <!--changes end  --> 
               </div>
               </div>
</body>
</html>






























