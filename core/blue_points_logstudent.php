<?Php

if(isset($_GET['name']))
{

include_once("school_staff_header.php");

$id=$_SESSION['staff_id'];

$rec_limit = 10;

/* Get total number of records */

$sql = "SELECT count(id) FROM tbl_student";

$retval = mysql_query( $sql);

if(! $retval )

{

  die('Could not get data: ' . mysql_error());

}


$row = mysql_fetch_array($retval, MYSQL_NUM );

$rec_count = $row[0];



if( isset($_GET{'page'} ) )

{

   $page = $_GET{'page'} + 1;

   $offset = $rec_limit * $page ;

}

else

{

   $page = 0;

   $offset = 0;

}

 $left_rec = $rec_count - ($page * $rec_limit);

?>

<!DOCTYPE html>

<html>

<head>

 <meta name="viewport" content="width=device-width" />



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

<div class="container">

    <div  style="width:100%;">

        <div style="height:10px;"></div>

    	<div style="height:50px; background-color:#FFFFFF; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;" align="left">

        	<h2 style="padding-left:20px; margin-top:2px;color:#666">Student Log</h2>

        </div>

<div id="no-more-tables" style="padding-top:20px;">

            <table class="col-md-12 table-bordered table-striped table-condensed cf" align="center" style="width:100%">

        		<thead class="cf">



        				<tr  style="background-color:#428BCA; color:#FFFFFF; height:30px;">

                	<th>Sr. No.</th>

                    <th>Student Name</th>

                    <th>Green Points</th>

                    <th>Used Points</th>



                </tr>



        		</thead>



                <?php



			$i=$rec_limit*$page;

				$arr = mysql_query("select school_id from tbl_school_adminstaff  where id=$id");

				while($school = mysql_fetch_array($arr))

				{

				$school_id=$school['school_id'];

				}

               $arrs = mysql_query("select s.id ,s.std_name,re.sc_total_point from tbl_student_reward re join tbl_student s on re.sc_stud_id = s.id  where s.school_id=$school_id ORDER BY s.id LIMIT $offset, $rec_limit");



				while($student = mysql_fetch_array($arrs))

				{

				$i++;

				?>

                <tbody>

                 <tr>

                	<td data-title="Sr.No"><?php echo $i;?></td>

                    <td data-title="Student Name"><?php echo $student['std_name'];?></td>





                     <td data-title="Balance Point"  ><?php echo $student['sc_total_point'];?></td>

                      <?php  $std_id=$student['id'];

				  $result=mysql_query("select points from tbl_accept_coupon where stud_id=$std_id");

				  $point=0;

				       while($student = mysql_fetch_array($result))

							{

							      $point=$point+$student['points'];

							}



							?>



                    <td data-title="Used Points"><?php echo $point;?></td>

                </tr>



                </tbody>

                <?php

				}

				?>

            </table>
<div align="center">

			<?php

if( $page > 0 )

{

   $last = $page - 2;

   echo  "<a href=\"student_log.php?page=$last\">Last 10 Records</a> |";

   echo "<a href=\"student_log.php?page=$page\">Next 10 Records</a>";

}

else if( $page == 0 )

{

   echo "<a href=\"student_log.php?page=$page\">Next 10 Records</a>";

}

else if( $left_rec < $rec_limit )

{

   $last = $page - 2;

   echo "<a href=\"student_log.php?page=$last\">Last 10 Records</a>";

}



?></div>

</div>

</div>

</body>

<footer>

<?php

 include_once('footer.php');?>

 </footer>

</html>

<?php

			}

			else

			{

				include("scadmin_header.php");



$id=$_SESSION['id'];

$entity=$_SESSION['entity'];
$user=$_SESSION['usertype'];

//$school_id=$_SESSION['school_id'];
$rec_limit = 10;
//Added user & below if conditions to solve the issue of 'No data available' even though there are records. -Rutuja for SMC-4360 on 19/03/2020
if($user=='School Admin' || $user=='HR Admin')
{
	$rows=mysql_query("select * from tbl_school_admin where id='$id'");
}

if($user=='HR Admin Staff' || $user=='School Admin Staff')
{

	$rows=mysql_query("select * from tbl_school_adminstaff where id='$id'");
}

$value=mysql_fetch_array($rows);
$school_id=$value['school_id'];
?>

<!DOCTYPE html>



<head>

 <meta name="viewport" content="width=device-width" />



<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">

 <link rel="stylesheet" href="css/bootstrap.min.css">

<script src="js/jquery-1.11.1.min.js"></script>

<script src="js/jquery.dataTables.min.js"></script>



    <script>

$(document).ready(function() {



    $('#example').DataTable();

} );

</script>



	</head>





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

<body>

<div class="container">

    <div  style="width:100%;">

        <div style="height:10px;"></div>

    	<div style="height:50px; background-color:#FFFFFF; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;" align="left">

        	<h2 style="padding-left:20px; margin-top:2px;color:#666">Blue Points Given to <?php echo $dynamic_student;?> for Distribution</h2>



       </div>

<div id="no-more-tables" style="padding-top:20px;">







 <table  id="example" class="table-bordered  table-condensed cf" width="100%"  >
 <thead>

                    <tr style="background-color:#555;color:#FFFFFF;height:30px;"><th>Sr. No.</th>
                    <th><?php echo $dynamic_student;?> Name</th>
                    <th>Blue Points</th>
                    <th>Reason</th>
                    <th>Assigned Date</th>
                     <th>Used Points</th>
                   </tr>
                   </thead>

                           <?php
                            $j=0;
							//echo "SELECT s.id, s.std_PRN, s.std_name, s.std_complete_name, s.std_lastname, s.std_Father_name, s.used_blue_points, re.sc_point, re.point_date, re.reason FROM tbl_student_point re JOIN tbl_student s ON re.sc_stud_id = s.std_PRN and re.school_id=s.school_id WHERE (re.school_id='$school_id' or re.school_id='$id') AND re.sc_entites_id=102 order by point_date asc";
							
							 //Below code done by Rutuja Jori & Sayali Balkawade for the Bug SMC-3751 on 14/05/2019
							 
                            $sql=mysql_query("SELECT s.id, s.std_PRN, s.std_name, s.std_complete_name, s.std_lastname, s.std_Father_name, s.used_blue_points, re.sc_point, re.point_date, re.reason,re.id FROM tbl_student_point re left JOIN tbl_student s ON re.sc_stud_id = s.std_PRN and re.school_id=s.school_id WHERE re.school_id='$school_id' AND re.sc_entites_id=102 AND type_points='blue_point' order by re.id desc");

						   while($value1 = mysql_fetch_array($sql))

						   {
						     $j++;
                            ?>

                                <tr><td align="center"><?php echo $j;?></td>


								<td data-title="Student Name"><?php



					if($value1['std_complete_name']=="")

					{

					echo ucwords(strtolower($value1['std_name']." ".$value1['std_Father_name']." ".$value1['std_lastname']));



					}

					else

					{

					echo ucwords(strtolower($value1['std_complete_name']));

                     }?>

                 </td>
                    <?php  $std_id=$value1['id'];
				  $result=mysql_query("select points from tbl_accept_coupon where stud_id='$std_id'");
				  $point=0;
				       while($student = mysql_fetch_array($result))
							{
							      $point=$point+$student['points'];
							}

							?>

				    <td data-title="Blue Point" align="center" ><?php if($value1['sc_point']=="")
					{
						echo 0;
					}
					else{
						echo $value1['sc_point'];
					}

					?></td>
                    <td data-title="Reason"><?php echo $value1['reason'];?></td>
                    <td data-title="Assigned Date" align="center"><?php echo $value1['point_date'];?></td>
                    <td data-title="Used Points" align="center"><?php echo $value1['used_blue_points'];?></td>

								</tr>

                            <?php

                            	}



							?>

                            </table>

                            </div>
</div>

</div>

</body>

<footer>

<?php

 include_once('footer.php');?>

 </footer>

</html>

<?php

	 }

	 ?>











