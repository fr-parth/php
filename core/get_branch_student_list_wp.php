<?php
//  SMC-4209 create new page by Kunal
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
if($scType=="organization"){ $dynamic_students = "Employees"; $dynamic_branch = "Section";}else{$dynamic_students = "Students"; $dynamic_branch = "Branch";}

?>
  <script>
   $('#example1').DataTable();
  </script>
<?php
$std_branch=$_GET['std_branch'];

//echo "select Degee_name,Degree_code from tbl_degree_master where school_id='$sc_id' and course_level='$value'";die;

 // $row=mysql_query("select DISTINCT t_dept from tbl_teacher where school_id='$school_id'"); 
  ?>
  

        <div class="container" style="padding-top:70px;" >	
				 <?php $std_branch=$_GET['std_branch'];
				 ?>
         <!-- added $std_branch in below line for displaying dept name of students by Pranali for SMC-5172 on 20-2-21 -->
           <div class='panel-heading h4'><h2 style="padding-left:20px; margin-top:2px;color:#666">Assign Points To <?php echo ucwords($std_branch).' Department '.$dynamic_students; ?> List</h2></div>
    	
                     
                  <div class='col-md-12' id='no-more-tables' style='padding-top:30px;' >
               <?php  $i=0;  ?>
               <table id="example1" class="display table-bordered" cellspacing="0" width="100%">

        <thead>

            <tr style="background-color:#0073BD; color:#FFFFFF; height:30px;">

            <th style="width:5%">Sr.No</th>

                <th><?php echo $dynamic_student;?> ID</th>

                <th><?php echo $dynamic_student;?> Name</th>

                <th style="width:20%">Email ID</th>
				
				        <th style="width:20%"><?php echo $dynamic_branch;?></th>

                <th style="width:20%">Balance Water Points</th>

                 <th style="width:15%">Used Water Points</th>

             </tr>

        </thead>

 <tbody>

        <?php $query = "Select * from tbl_student where school_id='$school_id' AND std_dept = '$std_branch' order by std_complete_name,std_name ASC";
        // echo $query; exit;
        $sql=mysql_query($query);

		$i=1;

						 while($result=mysql_fetch_array($sql))

						 { 

									  $firstname=$result['std_name'];

									  $fathrname=$result['std_Father_name'];

									  $lastname=$result['std_lastname'];

									  $studentName=$firstname." ".$fathrname." ".$lastname;

						 ?>

<tr onClick="document.location = 'studassignwaterpoints.php?id=<?php echo $result['id'];?>'">

                             <td><?php echo $i;?></td>

                             </td><td ><?php echo $result['std_PRN'];?></td>

                             <td><?php $coplitename=$result['std_complete_name'];

									 if($coplitename=="")

									 {echo ucwords(strtolower($studentName)); } else { echo ucwords(strtolower($coplitename));}

									  ?></td>

                             <td><?php echo $result['std_email'];?></td>

							 <td><?php echo $result['std_dept'];?></td>
							 
                             <td><?php echo $result['balance_water_points'];?> </td>

                             <td><?php echo $result['used_water_points'];?> </td>

                       </tr></a>

                  <?php $i++; }?>

        </tbody>

</table>

                </div>

