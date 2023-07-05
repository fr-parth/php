<?php
//subactivity_list.php
$report="";
include('scadmin_header.php');
/*$id=$_SESSION['id'];

if(!isset($_SESSION['id']))
	{
		header('location:login.php');
	}*/

	    $fields=array("id"=>$id);
		  /* $table="tbl_school_admin";*/

		   $smartcookie=new smartcookie();

$results=$smartcookie->retrive_individual($table,$fields);
$result=mysql_fetch_array($results);
$sc_id=$result['school_id'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
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
    $('#example').dataTable( {
      //  "pagingType": "full_numbers"
    } );
} );
</script>
<script>
    function confirmation($a_id)
  {
    var s = "Are you sure you want to delete?";
    var answer = confirm(s);
    if (answer){

        window.location = "delete_subactivity.php?id="+$a_id;
    }
    else{

    }
  }
</script>
 

</head>
<html>
<body bgcolor="#CCCCCC">
<div style="bgcolor:#CCCCCC">
<div>

</div>
<div class="container" style="padding:25px;" >
        	
            
            	<div style="padding:2px 2px 2px 2px;border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">
                   
                    
                    <div style="background-color:#F8F8F8 ;">
                    <div class="row">
                    <div class="col-md-3 "  style="color:#700000 ;padding:5px;" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                       <a href="subactivity.php"><input type="submit" class="btn btn-primary" name="submit" value="Add Sub Activity" style="width:150px;font-weight:bold;font-size:14px;"/></a>
               			 </div>
              			 <div class="col-md-5 " align="center" style="color:black;padding:5px;" >
                         	
                   				<h2>Sub Activity List</h2>
               			 </div>
                         
                     </div>

                  
               <!-- Add edit operation for SMC-4197 by chaitali on 23-01-2021 -->      
                
               <div class="row" style="padding-top:0px;">
             
               <div class="col-md-0">
               </div>
               <div class="col-md-12 ">
               <?php $i=0;?>

                  <table id="example" class="display" width="100%" cellspacing="0">
                     <thead>
                    	<tr ><th style="width:;" ><b><align='left'> ID</b></th><th style="width:;" ><align='left'>Subactivity Name
						</th><th style="width:;" ><b><align='left'>Activity Type ID
						</th><th style="width:;" ><b><align='left'>Activity ID
						
						</center></b></th><th style="width:;" ><b><align='left'>Point</b></th>
						
						<!--<th style="width:;" ><b><align='left'> Subject ID
						</th>
						<th style="width:;" ><b><align='left'> Subject Name
						</th>-->
						
                        <th><align='left'>Edit</th>
                        <th><align='left'>Delete</th>
						</tr></thead><tbody>
                 
				 
				<?php
				 
				   $i=1;
				  $arr=mysql_query("select * from tbl_onlinesubject_activity_achivement where school_id='$sc_id' ORDER BY a_id desc");?>
                  <?php while($row=mysql_fetch_array($arr)){?>
				  
                 <tr style="height:40px;">
				 <td style="width:100px;" ><align='left'><?php echo $row['a_id'] ;?></td>
				 <td style="width:100px;" ><align='left'><?php echo $row['a_desc'] ;?></td>
				 <td style="width:100px;" ><align='left'><?php echo $row['a_activity_id'];?></td>
				 <td style="width:100px;" ><align='left'><?php echo $row['a_sub_activity_id'];?></td>
				 <td style="width:100px;" ><align='left'><?php echo $row['a_alloc_points'];?></td>
				 <!--<td style="width:200px;" ><align='left'><?php echo $row['subject_id'];?></td>
				 <td style="width:200px;" ><align='left'><?php echo $row['subject_name'];?></td>-->
				 
				 <td><align='left'>
				 	<a href="edit_subActivity.php?id=<?php echo $row['a_id']?>">
                        <span class="glyphicon glyphicon-pencil"></span>
					</a>
                </td>
                 <td><align='left'><a onClick="confirmation(<?php echo $row['a_id']; ?>)"><span class="glyphicon glyphicon-trash"></a>
				 </td>
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
                      <div class="col-md-4" style="color:#FF0000;" align="center">
                      
                      <?php if(isset($_GET['report'])){echo $_GET['report'];}?>
               			</div>
                 
                    </div>
                      
                
                  
                 
                    
                    
                  
               </div>
               </div>
</body>
</html>