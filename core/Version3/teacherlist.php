

         <?php



     include_once('scadmin_header.php');

     $report="";



/*$smartcookie=new smartcookie();

           $id=$_SESSION['id'];

           $fields=array("id"=>$id);

		   $table="tbl_school_admin";

		   $smartcookie=new smartcookie();*/

		   

$results=$smartcookie->retrive_individual($table,$fields);

$result=mysql_fetch_array($results);

$sc_id=$result['school_id'];
//echo  $sc_id ;

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



<div class="" style="padding:30px;">

        	

            

            	<div style="border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">

                   

                    

                    <div style="background-color:#F8F8F8 ;">

                    <div class="row">

                    <div class="col-md-3"  style="color:#700000 ;padding:5px;">&nbsp;&nbsp;&nbsp;&nbsp;

             <a href="teacher_setup.php"><input type="submit" class="btn btn-primary" name="submit" value="Add Teacher" style="width:150;font-weight:bold;font-size:14px;"/></a>

               			 </div>

              			 <div class="col-md-6 " align="center"  >

                         	

                   				<h2>List of Teachers </h2>

               			 </div>

                         

                     </div>

                  <div class="row" style="padding:10px;" >

                  <div class="col-md-12" id="no-more-tables" >

               <?php $i=0;?>

             

                    

                    	<table id="example" class="display" width="100%" cellspacing="0">   <thead>

<tr  ><th >Sr.No</th><th>Profile Picture</th><th >Teacher ID</th><th>Teacher Name</th><th >Phone/Email ID</th>

					 <th >Login Time</th><th>Logout Time</th><th >Department</th><th >No of Subjects</th><th>Edit</th><th>Delete</th></tr>

                      </thead><tbody>

                 <?php

				 

				$i=1;
                  $val="";
				  $arr=mysql_query("select * from tbl_teacher where (`t_emp_type_pid`='133' or `t_emp_type_pid`='134') and school_id='$sc_id' order by t_complete_name ASC");?>

                  <?php while($row=mysql_fetch_assoc($arr)){

				  $teacher_id=$row['id'];

				  $t_id=$row['t_id'];

				  $fullname=ucwords(strtolower($row['t_complete_name']));

                  $sql = "SELECT `LatestLoginTime`,`LogoutTime` FROM `tbl_LoginStatus` WHERE Entity_type='103' and EntityID='".$row['id']."' " ;
                  $query = mysql_query($sql);
                  $val = mysql_fetch_array($query);

				  ?>

                  <tr

				  onmouseover="this.style.cursor='pointer';this.style.textDecoration='underline';this.style.color='dodgerblue'"

				  onmouseout="this.style.textDecoration='none';this.style.color='black';" 

				  onclick="window.location='teacherswise_subjects.php?t_id=<?php echo $row['t_id'];?>'" 

				  style="cursor: pointer; text-decoration: underline; color: dodgerblue; background-color: rgb(239, 243, 251);height:30px;color:#808080;"

				>

                

                    <td ><?php echo $i;?></td>

					<td><?php if($row['t_pc'] != ''){?>

                <img src="<?php echo $row['t_pc'];?>" class="preview" style=" width:70px;height:70px;" alt="Responsive image" />

                <?php }else {?> <img src="image/avatar_2x.png"  style="border:1px solid #CCCCCC; width:70px;height:70px;" class="preview" alt="Responsive image"/> <?php }?></td>

                <td ><?php echo $row['t_id'];?></td>

                

                    <td ><?php $teacher_name=ucwords(strtolower( $row['t_name']." ".$row['t_middlename']." ".$row['t_lastname']));?><?php if($fullname=="")

					

					{

					echo $teacher_name;

					}

					else

					{

					echo $fullname;

					}

					

					;?></td> 

                    

					

                    

                    <td><?php echo $row['t_phone']."<br>".$row['t_email'];?> </td>

					

					<td ><?php echo $val['LatestLoginTime']; ?> </td>

                    <td ><?php  if($val['LogoutTime']!=""){ echo $val['LogoutTime'];}else{if($val['LatestLoginTime']!=""){echo "<div style='color:#428BCA'>Running</div>";} } ?> </td>

				    <td ><?php echo $row['t_dept'];?> </td>

						

					<td >  <?php 
                            /*echo  $t_id." ".$sc_id; */
		$sql=mysql_query("select s.tch_sub_id from tbl_teacher_subject_master s join  tbl_academic_Year y on s.AcademicYear=y.Year and s.`ExtYearID`=y.ExtYearID and y.Enable='1' where s.teacher_id='$t_id' and y.school_id='$sc_id'");

								  

								  $count=mysql_num_rows($sql);

								  echo $count;

								   ?>  </td>

								   

				  <td ><a href="edit_teacher_details.php?t_id=<?php echo $row['t_id'];?>"><center><img src="images/edit.png" height="20px" width="20px"></a></center></td>

				  <td><center><img src="images/cancel.png" style=" width:25px;height:25px;" alt="Cancel" id="<?php echo $row['id']; ?>" onclick="return confirmation(this.id)"></center></td>

						  

                   

                  

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

