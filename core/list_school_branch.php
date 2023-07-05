<?php
$report = "";
include('scadmin_header.php');
$fields = array("id" => $id);
$smartcookie = new smartcookie();
$results = $smartcookie->retrive_individual($table, $fields);
$result = mysql_fetch_array($results);
$sc_id = $result['school_id'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title><?php echo $dynamic_school;?> Admin</title>
    <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
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
    <script>
    function confirmation(xxx)
  {
     
    var s = "Are you sure you want to delete?";
    var answer = confirm(s);
    if (answer){

        window.location = "delete_school_branch.php?id="+xxx;
    }
    else{

    }
  }
</script>
    <script>
        $(document).ready(function () {

            $('#example').dataTable({});

        });
    </script>
</head>
<html>
<body bgcolor="#CCCCCC">
<div style="bgcolor:#CCCCCC">
    <div>
    </div>
    <div class="container" style="padding:25px;">
        <div style="padding:2px 2px 2px 2px;border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">
            <div style="background-color:#F8F8F8 ;">
                <div class="row">
                    <div class="col-md-3 " style="color:#700000 ;padding:5px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="add_school_branch.php"> <input type="submit" class="btn btn-primary" name="submit" value="Add <?php echo $dynamic_branch;?>" style="width:150px;font-weight:bold;font-size:14px;"/></a>
                    </div>
                    <div class="col-md-5 " align="center" style="color:black;padding:5px;">
                        <h2><?php echo $dynamic_branches;?></h2>
                    </div>
                </div>
                <div class="row" style="padding-top:2px;">
                    <div class="col-md-0">
                    </div>
                    <div class="col-md-12 ">
                        <?php $i = 0; ?>
                        <table id="example" class="display" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th><!-- Camel casing done for Sr. No. by Pranali -->
                                    <center>Sr. No.</center>
                                </th>

                                <th>
                                 <b>
                                    <center><?php echo $dynamic_branch;?> Name</center>
                                       </b>
                                </th>

                                <th>
                                    <b>
                                        <center><?php echo $dynamic_branch;?> code</center>
                                    </b>
                                </th>

                                <th>
                                    <b>
                                        <center>Department Name</center>
                                    </b>
                                </th>

                                <th>
                                    <b>
                                        <center><?php echo $dynamic_level;?> </center>
                                    </b>
                                </th>

                                <th>
                                    <b>
                                        <center><?php echo $dynamic_branch;?> ID</center>
                                    </b>
                                </th>

                                <th>
                                    <b>
                                        <center>Edit</center>
                                    </b>
                                </th>

                                <th>
                                    <b>
                                        <center>Delete</center>
                                    </b>
                                </th>

                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $i = 1;
                            $arr = mysql_query("select id,ExtBranchId,branch_Name,Branch_code,Dept_Id,Course_Name,DepartmentName,degree_code from tbl_branch_master where school_id='$sc_id' ORDER BY id desc"); ?>
                            <?php while ($row = mysql_fetch_array($arr)) {?>
                            
                                <tr style="height:40px;">
                                    <td style="width:100px;">
                                            <center><?php echo $i;?></center>
                                    </td>

                                    <td style="width:150px;">
                                        <center> <?php echo $row['branch_Name']; ?></center>
                                    </td>

                                    <td style="width:100px;">
                                            <center><?php echo $row['Branch_code']; ?></center>
                                      
                                    </td>
                                     <td style="width:100px;">
                                            <center><?php echo $row['DepartmentName']; ?></center>
                                   </td>

                               <!--     <th style="width:100px;"><b>
                                            <center><?php/* $dept_id = $row['Dept_Id'];
                                                $sql = mysql_query("select Dept_Name from  tbl_department_master where Dept_code='$dept_id' and school_id='$sc_id'");
                                                $result = mysql_fetch_array($sql);
                                                $dept_name = $result['Dept_Name'];
                                                echo $dept_name;
                                         */       ?></center>
                                        </b>
                                    </th>
-->
                                   <td style="width:100px;">
                                            <center><?php echo $row['Course_Name']; ?></center>
                                    </td>

                                    <td style="width:100px;">
                                            <center><?php echo $row['ExtBranchId']; ?></center>
                                    </td>

                                    <td align="center">
                                    <form   method="post" action="add_school_branch.php">
                                    <input type="hidden" name="id" value="<?= $row['id'];?>">
                                        <button type="submit" name="submit_edit" > 
                                            <span class="glyphicon glyphicon-pencil"></span></button>
                                            </form>
                                    </td>


                                   
                                    <!-- <a href="delete_school_branch" class=""  value="<?php //echo $rows['id']?>">
                                            <span class="glyphicon glyphicon-trash" ></span>
                                        </a>-->
                                    
                       <!--add align for edit and delete by Dhanashri_Tak-->                    
                                        <td align="center">
                        <a onClick="confirmation(<?php echo $row['id']; ?>)"><span class="glyphicon glyphicon-trash"></span> </a>
                                       </td>
                                

                                </tr>
                                <?php $i++; ?>
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
                    <div class="col-md-4" style="color:#FF0000;" align="center">
                        <?php if (isset($_GET['report'])) {
                            echo $_GET['report'];
                        } ?>
                    </div>
                </div>
            </div>
        </div>
</body>
</html>

