<?php 
           if(isset($_GET['name']))
			 {
         include('school_staff_header.php');
           $report="";
		   $results=mysql_query("select * from tbl_school_adminstaff where id=".$id."");
           $result=mysql_fetch_array($results);
		   
          $sc_id=$result['school_id'];
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
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
        
        window.location = "delete_teacher_subject_master.php?id="+xxx;
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
                       <a href="add_school_subject.php?id=<?=$staff_id;?>"><input type="submit" class="btn btn-primary" name="submit" value="Add Subject" style="width:100px;font-weight:bold;font-size:14px;"/></a>
               			 </div>
              			 <div class="col-md-6 " align="center"  >
                         	<h2>Subjects</h2>
               			 </div>
                         
                     </div>
                   <div class="row">
             
               <div class="col-md-2">
               </div>
               <div class="col-md-8 ">
               <?php $i=0;?>
                  <table class="table-bordered" id="example" >
                     <thead>
                    	<tr style="background-color:#555;color:#FFFFFF;height:30px;"><th style="width:50px;" ><b><center>Sr.No</center></b></th><th style="width:150px;" ><center>Subject Code</center></th><th style="width:350px;" ><center>Subject Title</center></th><th style="width:350px;" ><center>Branch</center></th><th style="width:50px;" ><center>Semester</center></th><th style="width:100px;" ><center>Degree Name</center></th><th style="width:50px;" ><center>Edit</center></th><th style="width:100px;" ><center>Delete </center></th></tr></thead><tbody>
                 <?php
				 
				   $i=1;
				  $arr=mysql_query("select tss.Subject_Code,tss.Subject_Title,tss.Branch_ID,tss.Degree_name,tsd.Semester_ID from `tbl_school_subject` as tss JOIN `tbl_subjectdetails` as tsd ON tss.Subject_Code=tsd.Subject_Code where tss.school_id='$sc_id' group by Subject_Code ORDER BY tss.Subject_Title");?>
                  <?php while($row=mysql_fetch_array($arr)){?>
                 <tr style="height:30px;color:#808080;">
                    <th style="width:50px;"><b><center><?php echo $i;?></center></b></th>
					<th style="width:100px;" ><center><?php echo $row['Subject_Code'];?> </center></th>
					<th style="width:400px;"><center><?php echo $row['Subject_Title'];?></center> </th>
					<th style="width:400px;"><center><?php echo $row['Branch_ID'];?></center> </th>
					<th style="width:50px;"><center><?php echo $row['Semester_ID'];?></center> </th>
					<th style="width:100px;"><center><?php echo $row['Degree_name'];?></center> </th>
                    <th style="width:100px;"><center><?php  $sub_id= $row['id'];?>
                                  <a href="edit_school_subject.php?subject=<?php echo $sub_id; ?>" style="width:100px;">Edit </a>
                                 </center>
                    </th>
                    <th style="width:100px;" ><center> <a onClick="confirmation(<?php echo $sub_id; ?> )"   >   Delete</a></center></th>
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
				include('scadmin_header.php');
      $report="";
       $id=$_SESSION['id'];
	   $std_PRN=$_GET['id'];
	   
	   
           $fields=array("id"=>$id);
		   $table="tbl_school_admin";
		   $smartcookie=new smartcookie();
		   
$results=$smartcookie->retrive_individual($table,$fields);
$result=mysql_fetch_array($results);

$sc_id=$result['school_id'];

$arr=mysql_query("select std_complete_name,std_phone,std_name,std_Father_name,std_lastname,std_img_path,Email_Internal from tbl_student where std_PRN='$std_PRN' and school_id='$sc_id' ");
$result_arr=mysql_fetch_array($arr);

			  
				  


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
<style>
.preview
{
border-radius:50% 50% 50% 50%;  

box-shadow: 0 3px 2px rgba(0, 0, 0, 0.3);
-webkit-border-radius: 99em;
  -moz-border-radius: 99em;
  border-radius: 99em;
  border: 5px solid #eee;
  width:100px;
}
</style>
<body bgcolor="#CCCCCC">
<div style="bgcolor:#CCCCCC">

<div class="container"  style="padding:30px;" >
        	
            
            	<div style="border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;margin-left:18%; width:65%;margin-top:8%;">
                   
				  
				 
                   
                    <div style="background-color:#F8F8F8 ;">
                    <div class="row" align="center" style="margin-top:20px;">
                    
<?php if($result_arr['std_img_path']!=""){ ?><img src="<?php echo $result_arr['std_img_path'];?>"  class="preview" style=" width:70px;height:70px;" alt="Responsive image" /><?php }else{ ?> <img src="image/avatar_2x.png" style="border:1px solid #CCCCCC; width:70px;height:70px;" class="preview" alt="Responsive image"/><?php } ?>
                     </div>
					 
					 
					  <div class="row" style="font-size:large;margin-top:3%;" >
					 <div class="col-md-4"></div>
					 <div class="col-md-2">PRN No:</div>
					 <div class="col-md-6">
					<?php
					echo $std_PRN;
					?>
					 
					 
					 </div>
					 
					 </div>
					 <div class="row" style="font-size:large;margin-top:3%;" >
					 <div class="col-md-4"></div>
					 <div class="col-md-2">Name:</div>
					 <div class="col-md-6">
					 <?php
					  $std_name=$result_arr['std_complete_name'];
									   if($std_name=="")
									   {
										    $studentname=ucwords(strtolower($result_arr['std_name']))." ".ucwords(strtolower($result_arr['std_Father_name']))." ".ucwords(strtolower($result_arr['std_lastname']));
									   }
									   else
									   {
										  $studentname=ucwords(strtolower($result_arr['std_complete_name']));
									   }
					 echo $studentname;
					 ?>
					 
					 
					 </div>
					 
					 </div>
					 
					 <div class="row" style="font-size:large;margin-top:3%;" >
					 <div class="col-md-4"></div>
					 <div class="col-md-2">Email ID:</div>
					 <div class="col-md-6">
					<?php
					echo $result_arr['Email_Internal'];
					?>
					 
					 
					 </div>
					 
					 </div>
					 
					  <div class="row" style="font-size:large;margin-top:3%;" >
					 <div class="col-md-4"></div>
					 <div class="col-md-2">Phone No:</div>
					 <div class="col-md-6">
					<?php
					echo $result_arr['std_phone'];
					?>
					 
					 
					 </div>
					 
					 </div>
                     
                     
                   
                     
                    
                     
                     
            
                  
                  
                   
                 
                 
               </div>
			
               </div>
			   </div>
</div>
</div>
			   </body>
</html>

<?php
}
?>
					  
			
