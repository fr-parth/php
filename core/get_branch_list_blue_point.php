<?php
include("conn.php");

$id=$_SESSION['id'];
$query = mysql_query("select school_id from tbl_school_admin where id ='$id'");
$value = mysql_fetch_array($query);
$school_id=$value['school_id'];

?>
   <link href='css/jquery.dataTables.css' rel='stylesheet' type='text/css'>

 <script src='js/jquery-1.11.1.min.js' type='text/javascript'></script>
    <script src='js/jquery.dataTables.min.js' type='text/javascript'></script>
 
        <script src="js/dataTables.responsive.min.js"></script>
       
   <script src="js/ dataTables.bootstrap.js"></script>
 <script>
       $(document).ready(function() 
	   {
	    $('#example').DataTable();
} );
</script>

<?php
$branch=$_GET['branch'];

//echo "select Degee_name,Degree_code from tbl_degree_master where school_id='$sc_id' and course_level='$value'";die;

 // $row=mysql_query("select DISTINCT t_dept from tbl_teacher where school_id='$school_id'"); 
  ?>

        <div class='panel panel-default'>
         
				
				 <?php $branch=$_GET['branch'];
				 ?>
           <div class='panel-heading h4'><center>Assign Points to <?php echo $branch; ?> Branch Teachers List</center></div>
    	
                     
                  <div class='col-md-12' id='no-more-tables' style='padding-top:30px;' >
               <?php  $i=0;  ?>
               <table class='table-bordered  table-condensed cf' id='example' width='100%;' >
                   <thead>
                    <tr style='background-color:#428BCA'><th>Sr. No.</th>
                    <th>Teacher Name</th>
                    <th>Balance Blue Points</th>
                    <th>Used Blue Points</th>
                    <th>Branch</th>
                    <th>Assign</th>
                    </tr></thead><tbody>
                
				 <?php   $i=1;
$arr=mysql_query("SELECT id, t_name,t_complete_name,t_middlename,t_lastname,t_dept,balance_blue_points,used_blue_points FROM `tbl_teacher` WHERE school_id ='$school_id' AND t_dept='$branch' order by t_complete_name,t_name ASC");
                   while($row=mysql_fetch_array($arr))
				   {
				   
				     $teacher_id=$row['id'];
					 ?>
				  <tr style='color:#808080;' class='active'>
                    <td data-title='Sr.No'>  <?php echo $i; ?></td>
                    <td data-title='Teacher Name'>
                    <?php
                         $t_complete_name= $row['t_complete_name']; 
								 if($t_complete_name=="")
								  {
								  echo $row['t_name'].' '.$row['t_middlename'].' '.$row['t_lastname'];
								  }
								  else
								  {
								    echo $row['t_complete_name'];
								  }
								?> 
                   </td>
                    <td  data-title='Green Balance Points'>
                         <?php echo $row['balance_blue_points'];?>
                     </td>
                    
                    
                    <td  data-title='USed green Points'>
                    <?php $query=mysql_query("select sum(sc_point) as sc_point  from tbl_student_point where sc_entites_id ='103' and sc_teacher_id='$teacher_id'");
					 $test=mysql_fetch_array($query);
					 
								  //$sc_point=$test['sc_point'];
								  $sc_point=$row['used_blue_points'];
								  if($sc_point=="" || $sc_point==0)
								  {
								  echo "0";
								  }
								  else
								  {
								  echo $sc_point;
								  }?>
							</td>
                            <td  data-title='Branch'>  <?php echo $row['t_dept']; ?></td>
       <td data-title='Assign' ><center>
	   <a href="admin_assign_thanQpoint.php?id=<?php echo $teacher_id;?> " style='text-decoration:none'> <input type="button"  class="btn btn-primary" value="Assign" name="assign"/></a>
	   <!--
	   <a href='teacher_assignpoint.php?id=<?php //echo $teacher_id; ?>'> <input type='button' value='Assign' name='assign'/></a>
	   -->
	   </center></td>
                  
                 </tr>
                  <?php $i++;
				} ?>
				 </tbody>
                  </table>
                </div>

