<?php
include('groupadminheader.php');
    $sc_id = 0;
//Added entities for differentiating between Group Admin & Group Admin Staff to display list of Academic Year for SMC-4556 on 21/03/2020 by Rutuja Jori
    $entity=$_SESSION['entity'];
    if($entity==12)
    {
        $group_member_id=$_SESSION['id'];
    }
    if($entity==13)
    {
        $group_member_id=$_SESSION['group_member_id'];
    }

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Academic Year List</title>
    <link rel="stylesheet" type="text/css" href="../css/jquery.dataTables.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link href="../ymz_box.css" type="text/css" rel="stylesheet">
    <script src="../ymz_box.min.js" type="text/javascript"></script>
    <script>

$(document).ready(function() {
    $('#example').dataTable();
});

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

                    <div class="col-md-3" style="color:#700000 ;padding:5px;">&nbsp;&nbsp;&nbsp;&nbsp;

                        <a href="Add_academic_year.php"> <input type="submit" class="btn btn-primary" name="submit"
                                                               value="Add Academic Year"
                                                               style="font-weight:bold;font-size:14px;"/></a>

 


                    </div>
                    

                    <div class="col-md-6 " align="center">

                        <h2>Academic Year List </h2>

                    </div>
                    <!--Copy from CookieAdmin option added by Rutuja for SMC-4663 on 11/04/2020-->
                     <div align = "right" class="col-md-3"  style="color:#700000 ;padding:5px;margin-left: -2%;" >&nbsp;&nbsp;&nbsp;&nbsp;

                      
                <a href="copy_academic_year_from_cookie.php"> <input type="submit" class="btn btn-primary" name="submit"
                                                               value="Copy from CookieAdmin"
                                                               style="font-weight:bold;font-size:14px;"/></a>
                </div>
                </div>

                <div class="row" style="padding:10px;">

                    <div class="col-md-12  " id="no-more-tables">


                        <table id="example" class="display" style="text-align: center;" width="100%" cellspacing="0">

                            <thead>

                            <tr>
                                <th style="width:100px; text-align: center;">Sr.No.</th>
                                <th style="text-align: center;">Academic Year</th>
                                <th style="text-align: center;">Year</th>
                                <th style="text-align: center;">Is Active</th>
                                <th style="text-align: center;">Edit</th>
                                <!-- <th style="text-align: center;">Delete</th> -->
                                
                                 <!-- <th style="text-align: center;">Edit</th> -->
                            <!--   <th style="text-align: center;">Delete</th> -->
                               


                            </tr>

                            </thead>
                            <tbody>
                       <?php $sql = "SELECT id,Academic_year,Year,Enable from tbl_academic_Year where group_member_id='$group_member_id' GROUP BY group_member_id,Academic_year order by Year desc";
                       // echo $sql; exit;
                            $query = mysql_query($sql);
                            $i=1;
                            while ($rows = mysql_fetch_assoc($query)) { ?>
                                <tr>
                                    <td>
                                        <?php echo $i; ?>
                                    </td>
                                    
                                    <td>
                                        <?php echo $rows['Academic_year']; ?>
                                    </td>
                                    <td>
                                        <?php 
                                        $y=explode("-",$rows['Year']);
                                        echo  $y[0]=='G'? $y[1]: $rows['Year'];
                                        ?>
                                    </td>
                                    <td>
                                        <?php if($rows['Enable']=="1"){ echo "Yes";}else{echo "No";} ?>
                                    </td>
                                    
                                   <td>
                                     <a class="btn btn-default"
                                     href="Add_academic_year.php?id=<?php echo $rows['id'];?>"><span class="glyphicon glyphicon-pencil"></span></a>
                                    </td>
                                    


               <!--                     <td>
                                   
                                        <a onClick="confirmation(<?php// echo $rows['id']; ?>)"><span class="glyphicon glyphicon-trash"></span></a> 
                                    </td>
-->

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



