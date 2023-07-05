<?php
include('scadmin_header.php');
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

   function confirmation(id) 
{
    var answer = confirm("Are you sure you want to delete?")
    if (answer){
        
        window.location = "delete_360activity.php?id="+id;
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
        <div>
        </div>
        <div class="container" style="padding:25px;">
                <div class="page-header" style="background-color: #ebebe0">
                    <center><h1 style="padding: 20px;padding-bottom: 10px;">360 Activity List</h1></center>
                </div>
            <div style="padding:2px 2px 2px 2px;border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">
			<div align='center'>
                <div  class="btn-group" style="padding:20px;">
                    <a href="Add_360_activitys.php"><input type="submit" class="btn btn-primary" name="submit" value="Add Activity" style="width:150;font-weight:bold;font-size:14px;"/></a>
					
                    <a href="copy_360activity.php?id=<?php echo $sc_id; ?>"><input type="submit" class="btn btn-primary" name="copy" value="Copy from Groupadmin" style="font-weight:bold;font-size:14px;"/></a>
                </div>
					</div>
					
                    <div class="row" style="padding-top:20px;">
                        <div class="col-md-0"></div>
                        <div class="col-md-12">
                            <div style="background-color:#FFFFFF;" align="right">
                                <table id="example" class="display" width="100%" cellspacing="0">

                            <thead style="background-color:#FFFFFF; border:1px solid #CCCCCC;">

                             <tr align="left" style="background-color:#428bca;">
                                <th style="width:100px; text-align: center;">ID</th>
                                <th style="text-align: center;">Activity</th>
								<th style="text-align: center;">Activity Level</th>
								<th style="text-align: center;">Credit Points</th>
                                <th style="text-align: center;">Edit</th>
                                <th style="text-align: center;">Delete</th>
                               


                            </tr>

                            </thead>
                            <tbody>
                       <?php $sql = "SELECT a.act360_ID,a.act360_activity, a.act360_credit_points, a.act360_school_ID, al.actL360_activity_level FROM tbl_360activities a join tbl_360activity_level al on a.act360_activity_level_ID = al.actL360_ID where a.act360_school_ID='$sc_id' order by a.act360_ID desc";
                            $query = mysql_query($sql);
							$i=1;
                            while ($rows = mysql_fetch_assoc($query)) { ?>
                                <tr>
                                    <td>
                                        <?php echo $i; ?>
                                    </td>
									
                                    <td>
                                        <?php echo $rows['act360_activity']; ?>
                                    </td>
                                    <td>
                                        <?php echo $rows['actL360_activity_level']; ?>
                                    </td>
									<td>
                                        <?php echo $rows['act360_credit_points']; ?>
                                    </td>
									
                                   <td>
                                     <a class="btn btn-default"
                                     href="edit_360_feedback_activitys.php?act360_ID=<?php echo $rows['act360_ID'];?>&act=<?php echo $rows['act360_activity'];?>"><span class="glyphicon glyphicon-pencil"  style="color:#428bca;"></span></a>
                                    </td>

                                   <td>
                                   <a class="btn btn-default"
                                     href="edit_360_feedback_activitys.php?act360_ID=<?php echo $rows['act360_ID']; ?>&del=1"><span class="glyphicon glyphicon-trash"  style="color:#428bca;"></span></a>
                                    
										<!-- <a onClick="confirmation(<?php //echo $rows['id']; ?>)"><span class="glyphicon glyphicon-trash"></span></a>	 -->
                                    </td>


                                </tr>
										
                            <?php $i++; } ?>


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



