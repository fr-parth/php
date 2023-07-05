<?php
include('cookieadminheader.php');
//     $id=$_SESSION['staff_id'];
$fields = array("id" => $id);
/*   $table="tbl_school_admin";
*/
$smartcookie = new smartcookie();
$results = $smartcookie->retrive_individual($table, $fields);
$result = mysql_fetch_array($results);
$sc_id = $result['school_id'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Semester</title>
    <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <link href="ymz_box.css" type="text/css" rel="stylesheet">
    <script src="ymz_box.min.js" type="text/javascript"></script>
    <script>

$(document).ready(function() {

    $('#example').dataTable( {



    } );

} );

   function confirmation(xxx) 
{
    var answer = confirm("Are you sure you want to delete?")
    if (answer){
        
        window.location = "delete_school_course_level.php?id="+xxx;
		
		
    }
    else
	{
       
    }
}



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

            #no-more-tables tr {
                border: 1px solid #ccc;
            }

            #no-more-tables td {

                /* Behave  like a "row" */

                border: none;

                border-bottom: 1px solid #eee;

                position: relative;

                padding-left: 50%;

                white-space: normal;

                text-align: left;

                font: Arial, Helvetica, sans-serif;

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
            #no-more-tables td:before {
                content: attr(data-title);
            }

        }

    </style>


</head>

<body bgcolor="#CCCCCC">

<div style="bgcolor:#CCCCCC">


    <div class="container" style="padding:30px;">

        <div style="border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">

            <div style="background-color:#F8F8F8 ;">

                <div class="row">

                    <div class="col-md-3 " style="color:#700000 ;padding:5px;">&nbsp;&nbsp;&nbsp;&nbsp;

                        <a href="Add_360_process_list.php"> <input type="submit" class="btn btn-primary" name="submit"
                                                               value="Add Feedback Process"
                                                               style="font-weight:bold;font-size:14px;"/></a>

                    </div>

                    <div class="col-md-6 " align="center">

                        <h2>Feedback Process List </h2>

                    </div>


                </div>

                <div class="row" style="padding:10px;">

                    <div class="col-md-12  " id="no-more-tables">


                        <table id="example" class="display" style="text-align: center;" width="100%" cellspacing="0">

                            <thead>

                            <tr>
                                <th style="width:100px; text-align: center;">ID</th>
                                <th style="text-align: center;">Activity</th>
								<th style="text-align: center;">Sequence Order</th>
								<th style="text-align: center;">Credit Points</th>
                                <th style="text-align: center;">Edit</th>
                         <!--       <th style="text-align: center;">Delete</th> -->
                               


                            </tr>

                            </thead>
                            <tbody>
                            <?php $sql = "SELECT pro360_ID,pro360_process_description, pro360_seq_order,pro360_max_points FROM tbl_360process";
                            $query = mysql_query($sql);
                            while ($rows = mysql_fetch_assoc($query)) { ?>
                                <tr>
                                    <td>
                                        <?php echo $rows['pro360_ID']; ?>
                                    </td>
                                    <td>
                                        <?php echo $rows['pro360_process_description']; ?>
                                    </td>
                                    <td>
                                        <?php echo $rows['pro360_seq_order']; ?>
                                    </td>
									<td>
                                        <?php echo $rows['pro360_max_points']; ?>
                                    </td>
                                    <td>
                                        <a class="btn btn-default"
                                           href="#?CourseLevelId=<?php echo $rows['pro360_ID']; ?>">
                                            <span class="glyphicon glyphicon-pencil"></span></a>
                                    </td>

<!--
                                    <td>
                                   
										<a onClick="confirmation(<?php //echo $rows['pro360_ID']; ?>)"><span class="glyphicon glyphicon-trash"></span></a>	
                                    </td>
-->

                                </tr>

                            <?php } ?>


                            </tbody>


                        </table>

                    </div>

                </div>


                <div class="row" style="padding:5px;">

                    <div class="col-md-4">

                    </div>

                    <div class="col-md-3 " align="center">


                        </form>

                    </div>

                </div>

                <div class="row">

                    <div class="col-md-4">

                    </div>

                    <div class="col-md-3" style="color:#FF0000;" align="center">

                        <?php echo $report; ?>

                    </div>
                </div>
            </div>
        </div>
</body>

</html>



