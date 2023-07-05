<?php
session_start();
include("conn.php");

if($_SESSION['usertype']=='HR Admin Staff' OR $_SESSION['usertype']=='School Admin Staff')
	{
		$sc_id=$_SESSION['school_id']; 
		$query2 = mysql_query("select id from tbl_school_admin where school_id ='$sc_id'");

    $value2 = mysql_fetch_array($query2);

    $id = $value2['id'];
		
		
	}
	else
	{
		$id = $_SESSION['id'];
	}
$query = mysql_query("select school_id,school_type from tbl_school_admin where id ='$id'");
$value = mysql_fetch_array($query);
$school_id=$value['school_id'];
$scType = $value['school_type'];
if($scType=="organization"){ $dynamic_student = "Employee";}else{$dynamic_student = "Student";}

?>
  <script>
   $('#example1').DataTable();
  </script>
<?php
$std_branch=$_GET['branch'];

//echo "select Degee_name,Degree_code from tbl_degree_master where school_id='$sc_id' and course_level='$value'";die;

 // $row=mysql_query("select DISTINCT t_dept from tbl_teacher where school_id='$school_id'"); 
  ?>
  

        <div class="container-fluid" style="padding-top:70px;" >  
         <?php $std_branch=$_GET['branch'];
         ?> <!--Added ucwords for dept name by Pranali for SMC-4980 -->
           <h2 style="padding-left:20px; margin-top:2px;color:#666;" align="center"> Assign Points To <?php echo ucwords($std_branch)." Department ".$dynamic_student; ?> </h2>
      
                     
                  <div class='col-md-12' id='no-more-tables' style='margin-top:30px;' >
               <?php  $i=0;  ?>
               <table id="example1" class="col-md-12 table-bordered">

        <thead>

            <tr style="background-color:#0073BD; color:#FFFFFF; height:30px;">

            <th style="width:5%">Sr.No</th>

                <th><?php echo $dynamic_student;?> ID</th>

                <th><?php echo $dynamic_student;?> Name</th>

                <th style="width:20%">Email ID</th>
        
        <th style="width:20%">Department </th>

               <!--<th style="width:10%">Class</th>-->

                <th style="width:15%">Used Blue Points</th>

                <th style="width:20%">Balance Blue Points</th>

             </tr>

        </thead>

 <tbody>

        <?php $sql=mysql_query("Select * from tbl_student where school_id='$school_id' AND std_dept = '$std_branch' order by std_complete_name,std_name ASC");

    $i=1;

             while($result=mysql_fetch_array($sql))

             { 

                    $firstname=$result['std_name'];

                    $fathrname=$result['std_Father_name'];

                    $lastname=$result['std_lastname'];

                    $studentName=$firstname." ".$fathrname." ".$lastname;

             ?>

<tr onClick="document.location = 'studassignbluepoints.php?id=<?php echo $result['id'];?>'">

                             <td><?php echo $i;?></td>

                             <td ><?php echo $result['std_PRN'];?></td>

                             <td><?php $coplitename=$result['std_complete_name'];

                   if($coplitename=="")

                   {echo ucwords(strtolower($studentName)); } else { echo ucwords(strtolower($coplitename));}

                    ?></td>

                             <td><?php echo $result['std_email'];?></td>

               <td><?php echo $result['std_dept'];?></td>
               
                             <td><?php echo $result['used_blue_points'];?> </td>

                             <td><?php echo $result['balance_bluestud_points'];?> </td>

                       </tr>

                  <?php $i++; }?>

        </tbody>

</table>

                </div>

