<?php
//Created by Rutuja Jori on 30/12/2019 for SMC-4278
$report="";
include('scadmin_header.php');


	    $fields=array("id"=>$id);
		  /* $table="tbl_school_admin";*/

		   $smartcookie=new smartcookie();

$results=$smartcookie->retrive_individual($table,$fields);
$result=mysql_fetch_array($results);
$sc_id=$_SESSION['school_id'];
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
    function confirmation($d_id)
  {
    var s = "Are you sure you want to delete?";
    var answer = confirm(s);
    if (answer){

        window.location = "delete_school_department.php?id="+$d_id;
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
                      <!--below href updated by Rutuja Jori for merging Add & Edit pages into one on 28/11/2019 for SMC-4196-->
                       <a href="add_school_department_admin.php">   <input type="submit" class="btn btn-primary" name="submit" value="Add Department Admin" style="width:177px;font-weight:bold;font-size:14px;"/></a>
               			 </div>
              			 <div class="col-md-5 " align="center" style="color:black;padding:5px;" >
                         	
                   				<h2>Department Admin List</h2>
               			 </div>
                         
                     </div>

                  
                   
                  
               <div class="row" style="padding-top:0px;">
             
               <div class="col-md-0">
               </div>
               <div class="col-md-12 ">
               <?php $i=0;?>

                  <table id="example" class="display" width="100%" cellspacing="0">
                     <thead>
                    	<tr >
						<th style="width:50;" ><align='left'>Department ID
						</th>
						<th style="width:50;" ><align='left'>Department Name
						</th><th style="width:;" ><b><align='left'>Admin Name
						</th>
             <th style="width:20%;" ><b><align='left'>Edit</b></th>         
						</tr></thead><tbody>
                 
				  
				<?php
				 
				   $i=1;
				  $arr=mysql_query("select * from tbl_teacher where school_id='$sc_id' and is_dept_admin='1' ORDER BY id");?>
                  <?php while($row=mysql_fetch_array($arr)){?>
                 <tr style="height:40px;"><td style="width:100px;" ><align='left'><?php echo $i;?></td><td style="width:100px;" ><align='left'><?php echo $row['t_dept'];?></td><td style="width:100px;" ><align='left'><?php echo $row['t_complete_name'];?></td>
				         <td><align='left'><a href="edit_school_department_admin.php?t_id=<?php echo $row['t_id'];?>"><span class="glyphicon glyphicon-pencil"></a>
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
