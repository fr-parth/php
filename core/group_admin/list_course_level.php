<?php
include('groupadminheader.php');
//     $id=$_SESSION['staff_id'];
// $fields = array("id" => $id);
/*   $table="tbl_school_admin";
*/
// $smartcookie = new smartcookie();
// $results = $smartcookie->retrive_individual($table, $fields);
// $result = mysql_fetch_array($results);
$group_member_id = $_SESSION['id'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Course Level</title>
    <link rel="stylesheet" type="text/css" href="../css/jquery.dataTables.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
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
        
        window.location = "delete_course_level.php?id="+xxx;
        
        
    }
    else
    {
       
    }
}



</script>


    <script src="../js/jquery-1.11.1.min.js"></script>
    <script src="../js/jquery.dataTables.min.js"></script>


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

                        <a href="Add_course_level.php"> <input type="submit" class="btn btn-primary" name="submit"
                                                               value="Add Course Level"
                                                               style="font-weight:bold;font-size:14px;"/></a>

                    </div>

                    <div class="col-md-6 " align="center">

                        <h2>Course Level List </h2>

                    </div>


                </div>

                <div class="row" style="padding:10px;">

                    <div class="col-md-12  " id="no-more-tables">


                        <table id="example" class="display" style="text-align: center;" width="100%" cellspacing="0">

                            <thead>
<!--Done changes in th for label by Dhanashri_Tak-->
                            <tr>
                                <th style="width:100px; text-align: center;">ID</th>
                                <th style="text-align: center;">Ext Course Level ID</th>
                                <th style="text-align: center;">Course Level</th>
                                <th style="text-align: center;">Edit</th>
                                <th style="text-align: center;">Delete</th>
                                <!--<th>Batch ID</th>-->
<!--End-->

                            </tr>

                            </thead>
                            <tbody>

                            <?php $sql = "SELECT * FROM `tbl_CourseLevel` WHERE `group_member_id`='$group_member_id'";

                            $query = mysql_query($sql);
                            while ($rows = mysql_fetch_assoc($query)) { ?>
                                <tr>
                                    <td>
                                        <?php echo $rows['id']; ?>
                                    </td>
                                    <td>
                                        <?php echo $rows['ExtCourseLevelID']; ?>
                                    </td>
                                    <td>
                                        <?php echo $rows['CourseLevel']; ?>
                                    </td>
                                    

                                    <td><!--Below href updated by Rutuja Jori for merging Add & Edit pages into one page on 25/11/2019 for SMC-4196-->
                                        <a class="btn btn-default"
                                           href="Add_course_level.php?CourseLevelId=<?php echo $rows['id']; ?>">
                                            <span class="glyphicon glyphicon-pencil"></span></a>
                                    </td>

                                    <td>
                                    <!--    <a href="list_school_course_level.php?Id=<?php// echo $rows['id']; ?>" class=""  value="<?php echo $rows['id']?>">
                                            <span class="glyphicon glyphicon-trash" ></span>
                                        </a>  -->
            <!--Remove <th> Dhanashri_Tak-->
                                        <a onClick="confirmation(<?php echo $rows['id']; ?>)"><span class="glyphicon glyphicon-trash"></span></a>   
                                    </td>


                                    <!--<td>
                          <?php echo $rows['department']; ?>
                      </td>
                      <td>
                          <?php echo $rows['batch_id']; ?>
                      </td>-->
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


 
