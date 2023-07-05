<?php
    include('scadmin_header.php');
    $report = "";
    $id = $_SESSION['id'];
    $group_member_id = $_SESSION['group_member_id'];
    $sc_id = $_SESSION['school_id'];
     ?>
    <!DOCTYPE>
    <html>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
    <script src="js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        } );
    </script>
    <script>
        function confirmation(xxx) {
            var answer = confirm("Are you sure you want to delete?")
            if (answer) {
                window.location = "delete_activity.php?id=" + xxx;
            }
            else {
            }
        }
    </script>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Activity List</title>
    </head>
    <body bgcolor="#CCCCCC">
    <div style="bgcolor:#CCCCCC">
        <div>
        </div>
        <div class="container" style="padding:25px;">
                <div class="page-header" style="background-color: #ebebe0">
                    <center><h1 style="padding: 20px;padding-bottom: 10px;">Activity List</h1></center>
                </div>
            <div style="padding:2px 2px 2px 2px;border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">
                <div class="btn-group" style="padding:20px;">
                    <a href="activity.php"><input type="submit" class="btn btn-primary" name="submit" value="Add Activity" style="width:150;font-weight:bold;font-size:14px;"/></a>
                    <?php if($group_member_id=='0')
                    { ?>
                    <a href="copy_activity.php?id=<?php echo $sc_id; ?>"><input type="submit" class="btn btn-primary" name="copy" value="Copy Activity Type from Cookieadmin" style="font-weight:bold;font-size:14px;"/></a>
                    
                     <a href="copyActivityList.php"><input type="submit" class="btn btn-primary" name="copy" value="Copy Activity from Cookieadmin" style="font-weight:bold;font-size:14px;"/></a>
                    <?php }
                    else
                    { ?>
                        <a href="copyGroupActivityType.php"><input type="submit" class="btn btn-primary" name="copy" value="Copy Activity Type from Groupadmin" style="font-weight:bold;font-size:14px;"/></a>
                        <a href="copyGroupActivityList.php"><input type="submit" class="btn btn-primary" name="copy" value="Copy Activity from Groupadmin" style="font-weight:bold;font-size:14px;"/></a>
                        
                <?php   } ?>
                </div>
                <div class="col-sm-4" style="color: green;"><?php echo $_GET['deletemessage'];?></div>
                <div style="height:20px;"></div>
                <div style="background-color:#F8F8F8 ;">
                    <div class="row" style="padding-top:20px;">
                        <div class="col-md-0"></div>
                        <div class="col-md-12">
                            <div align="right">
                                <table id="example" class="display" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>Sr. No.</th>
                                        <th>Activity Name</th>
                                        <th>Activity Type</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                    </thead>
                                    <tbody>


                                    <?php 
                                    //on condition added by Pranali for SMC-3854 on 26-9-19
                                    $arr = mysql_query("SELECT * FROM tbl_studentpointslist sp JOIN tbl_activity_type a 
                                        ON sp.sc_type=a.id    
                                        WHERE sp.school_id= '$sc_id'
                                         ORDER BY sp.sc_id");

                                    while ($row = mysql_fetch_array($arr)) {
                                        $i++;
                                        ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $row['sc_list']; ?></td>
                                            <td><?php echo $row['activity_type']; ?></td>
                                            <td>
                                                <a href="editcompanyactivity.php?activity=<?php echo $row['sc_id']; ?>"><span class="glyphicon glyphicon-pencil"></a>
                                            </td>
                                            <td><a onclick="confirmation(<?php echo $row['sc_id']; ?> )"><span class="glyphicon glyphicon-trash"></a></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                            <div style="height:50px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
    </html>