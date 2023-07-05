<?php

include('scadmin_header.php');

    //     $id=$_SESSION['staff_id'];

           $fields=array("id"=>$id);

        /*   $table="tbl_school_admin";
*/


           $smartcookie=new smartcookie();



$results=$smartcookie->retrive_individual($table,$fields);

$result=mysql_fetch_array($results);

$sc_id=$result['school_id'];

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Branch Subject Division Year</title>

<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">

 <link rel="stylesheet" href="css/bootstrap.min.css">

<script>

$(document).ready(function() {

    $('#example').dataTable( {



    } );

} );

</script>



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



</head>

<body bgcolor="#CCCCCC">

<div style="bgcolor:#CCCCCC">



<div class="container" style="padding:30px;" >

        	<div style="border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">





                    <div style="background-color:#F8F8F8 ;">

                    <div class="row">

                    <div class="col-md-3 "  style="color:#700000 ;padding:5px;" >&nbsp;&nbsp;&nbsp;&nbsp;

                       <!--<a href="#"> <input type="submit" class="btn btn-primary" name="submit" value="Add Branch Subject Division Year" style="font-weight:bold;font-size:14px;margin-left: 20px;"/></a>-->

               			 </div>

              			 <div class="col-md-6 " align="center"  >

                         	<h2>Branch Subject Division Year List </h2>

               			 </div>



                     </div>

               <div class="row" style="padding:10px;" >

             <div class="col-md-12  " id="no-more-tables" >





    <table id="example" align="center" class="display" style="text-align: center;" width="100%" cellspacing="0">

        <thead style="text-align: center;">

            <tr >
								<th  style="text-align: center;">Sr. No</th>
								<th style="text-align: center;">Branch Name</th>
								<th style="text-align: center;">Subject Name</th>
								<th style="text-align: center;">Division Name</th>
								<th style="text-align: center;">Semester Name</th>
								<th style="text-align: center;">Course Level</th>
								<th style="text-align: center;">Year</th> 
            </tr>

        </thead>
        <tbody>
            <?php
            $i=1;
			$sql = "SELECT DISTINCT * FROM  `Branch_Subject_Division_Year`  WHERE `school_id`='$sc_id'";
                  $query = mysql_query($sql);
                  while($rows=mysql_fetch_assoc($query))
                  { ?>
                  <tr>
                      <td>
                           <?php echo $i;?>
                      </td>
					  <td>
                          <?php echo $rows['BranchName']; ?>
                      </td>
                      <td>
                          <?php echo $rows['SubjectTitle']; ?>
                      </td>
                      <td>
                          <?php echo $rows['DivisionName']; ?>
                      </td>
					  <td>
                          <?php echo $rows['SemesterName']; ?>
                      </td>
					  <td>
                          <?php echo $rows['CourseLevel']; ?>
                      </td>
					  <td>
                          <?php echo $rows['Year']; ?>
                      </td>

					  
                      
                  </tr>

                 <?php 
				   $i++;
				   } ?>


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



