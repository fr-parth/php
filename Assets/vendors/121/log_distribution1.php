<?Php

if(isset($_GET['name']))
{
include_once("school_staff_header.php");

$query = mysql_query("select * from tbl_school_adminstaff where id = ".$_SESSION['staff_id']);
$value = mysql_fetch_array($query);
$school_id=$value['school_id'];
$id=$_SESSION['staff_id'];

?>
<!DOCTYPE html>
<html>
<head>


 <link href='webservice/test_webservice/css/jquery.dataTables.css' rel='stylesheet' type='text/css'>

 <script src='webservice/test_webservice/js/jquery-1.11.1.min.js' type='text/javascript'></script>
 <script src='webservice/test_webservice/js/jquery.dataTables.min.js' type='text/javascript'></script>

 <script src="webservice/test_webservice/js/dataTables.responsive.min.js"></script>
 <script src="webservice/test_webservice/js/ dataTables.bootstrap.js"></script>

        <script>
       $(document).ready(function()
       {
	    $('#example').DataTable();
} );
        </script>
<style>
@media only screen and (max-width: 800px)
{

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
	#no-more-tables thead tr
     {
		position: absolute;
		top: -9999px;
		left: -9999px;
	}

	#no-more-tables tr
    {
      border: 1px solid #ccc;
    }

	#no-more-tables td
    {
		/* Behave  like a "row" */
		border: none;
		border-bottom: 1px solid #eee;
		position: relative;
		padding-left: 50%;
		white-space: normal;
		text-align:left;
	}

	#no-more-tables td:before
     {
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
	#no-more-tables td:before
     {
        content: attr(data-title);
     }
}
</style>

</head>

<body>
<div class="container">
<div class="row">
<div style="height:10px;"></div>

        <div style="height:20px;"></div>
        <div style="height:10px;"></div>
    	<div style="height:50px; background-color:#FFFFFF; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;" align="left">
        <h2 style="padding-left:20px; margin-top:2px;color:#666">Manager Log</h2>
        </div>
        <div   class="container" style="padding-top:20px;">
       <?php



	        $i=0;
			$old_id=0;
			$sum=0;
			$teacher_id=0;
			$teachers_id=array();



               $arrs = mysql_query("SELECT t.id, t_name, tc_balance_point, sc_point, sc_entites_id
                                    FROM tbl_teacher t
                                    LEFT JOIN tbl_student_point st ON t.id = st.sc_teacher_id
                                    WHERE school_id =  '$school_id' and t.tc_balance_point!=0
                                    ORDER BY t.id ");


                $teachers_id=array();
				$teachers_name=array();
				$teachers_assign_point=array();
				$teachers_balance_point=array();

				while($teacher = mysql_fetch_array($arrs))
				{
				      $teacher_id=$teacher['id'];

					   if($old_id==0)
					   {
					        $old_id =$teacher_id;

					   }
			           if($teacher_id==$old_id)
				       {
				            $sum=$sum+$teacher['sc_point'];
				       }
				       if($teacher_id!=$old_id)
				       {
                            $sum=0;$i++;
				       }
				      $teachers_id[$i]= $teacher_id;
					  $teachers_name[$i] = $teacher['t_name'];
					  $teachers_assign_point[$i]= $sum;
					  $teachers_balance_point[$i]= $teacher['tc_balance_point'];
					  $old_id=$teacher_id;
                }

?>

                <table id="example" class=" table-bordered table-striped table-condensed cf" align="center" style="width:100%">

        		<thead>

        		<tr  style="background-color:#428BCA; color:#FFFFFF; height:30px;">
                	<th>Sr. No.</th>
                    <th>Manager ID</th>
                    <th>Manager Name</th>
                    <th>Assigned Points</th>
                    <th>Balance Points</th>
                </tr>

        		</thead>
                <tbody>
                <?php


				for($j=0;$j<count($teachers_id);$j++)
				{
				?>
				<td><?php echo $j+1;?></td>
                    <td><?php echo $teachers_id[$j];?></td>
                    <td><?php echo $teachers_name[$j] ;?></td>
                    <td><?php echo $teachers_assign_point[$j];?></td>
                    <td><?php echo  $teachers_balance_point[$j];?></td>
                    <tr>

			<?php
				}
				?>
               </tbody>
        	   </table>

</div>
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
		include("hr_header.php");

	$query = mysql_query("select * from tbl_school_admin where id = ".$_SESSION['id']);
	$value = mysql_fetch_array($query);
	$school_id=$value['school_id'];
	$id=$_SESSION['id'];

?>
<!DOCTYPE html>

<head>


   <link href='css/jquery.dataTables.css' rel='stylesheet' type='text/css'>

    <script src='js/jquery-1.11.1.min.js' type='text/javascript'></script>

	<script src='js/jquery.dataTables.min.js' type='text/javascript'></script>
    <script src="js/dataTables.responsive.min.js"></script>
    <script src="js/dataTables.bootstrap.js"></script>

        <script>
$(document).ready(function()
{
$('#example').DataTable();
} );
        </script>
<style>
@media only screen and (max-width: 800px)
{

    /* Force table to not be like tables anymore */
	#no-more-tables table,
	#no-more-tables thead,
	#no-more-tables tbody,
	#no-more-tables th,
	#no-more-tables td,
	#no-more-tables tr
    {
		display: block;
	}

	/* Hide table headers (but not display: none;, for accessibility) */
	#no-more-tables thead tr
     {
		position: absolute;
		top: -9999px;
		left: -9999px;
	}

	#no-more-tables tr
    {
       border: 1px solid #ccc;
    }

	#no-more-tables td
    {
		/* Behave  like a "row" */
		border: none;
		border-bottom: 1px solid #eee;
		position: relative;
		padding-left: 50%;
		white-space: normal;
		text-align:left;
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



</head>

<body>
<div class="container" >
<div class="row">

<div style="height:10px;"></div>



        <div style="height:20px;"></div>

		<div style="height:10px;" ></div>
    	
		<div style="height:50px; background-color:#FFFFFF; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;" align="left">
        <h2 style="padding-left:20px; margin-top:2px;color:#666">Manager Log</h2>
        </div>
      
		<div   class="container" style="padding-top:20px;">
        
		<?php



	        $i=0;
			$old_id=0;
			$sum=0;
			$teacher_id=0;
			$teachers_id=array();



               $arrs = mysql_query("SELECT t.id,t.t_id, t_complete_name, tc_balance_point, sc_point, sc_entites_id FROM tbl_teacher t
						LEFT JOIN tbl_student_point st ON t.id = st.sc_teacher_id
						WHERE (`t_emp_type_pid`='133' or `t_emp_type_pid`='132') AND t.school_id = '$school_id' and t.tc_balance_point!=0 ORDER BY t.t_complete_name ASC ");


                $teachers_id=array();
				$teachers_name=array();
				$teachers_assign_point=array();
				$teachers_balance_point=array();
				while($teacher = mysql_fetch_array($arrs))
				{

					   $teacher_id=$teacher['t_id'];

					   if($old_id==0)
					   {
					   $old_id =$teacher_id;

					   }
			      if($teacher_id==$old_id)
				  {
				     $sum=$sum+$teacher['sc_point'];
				  }

				 if($teacher_id!=$old_id)
				  {
				   $sum=0;
				   $i++;
				  }
					 $teachers_id[$i]= $teacher_id;
					 $teachers_name[$i] = $teacher['t_complete_name'];
					 $teachers_assign_point[$i]= $sum;
					 $teachers_balance_point[$i]= $teacher['tc_balance_point'];
					 $old_id=$teacher_id;
				}



			  ?>

                <table id="example" class="table-bordered table-striped table-condensed cf" align="center" style="width:100%">

        		<thead>

        				<tr  style="background-color:#428BCA; color:#FFFFFF; height:30px;">
                	<th>Sr. No.</th>
                    <th>Manager ID</th>
                    <th>Manager Name</th>
                    <th>Assigned Points</th>
                    <th>Balance Points</th>


                </tr>

        		</thead>
                <tbody>
                <?php


				for($j=0;$j<count($teachers_id);$j++)
				{
				?> <tr>
				    <td><?php echo $j+1;?></td>
                    <td><?php echo $teachers_id[$j];?></td>
                    <td><?php echo $teachers_name[$j];?></td>
                    <td><?php echo $teachers_assign_point[$j];?></td>
                    <td><?php echo $teachers_balance_point[$j];?></td>
                   </tr>

			<?php
				}
			?>
               </tbody>
        	   </table>
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