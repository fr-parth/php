<?php
include("cookieadminheader.php");
if (!isset($_SESSION['id'])) {
    header('location:login.php');
}
?>
<!DOCTYPE >
<html>
<head>
    <!--    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />-->
    <title>List salesperson</title>
    <script>
        $(document).ready(function () {
            $('#example').DataTable();
        });
			
			function confirmation(xxx) {
    var answer = confirm("Are you sure you want to delete?")
    if (answer){
       // alert("Activity has been deleted successfully..");
        window.location = "delete_salesperson.php?id="+xxx;
    }
    else{
       
    }
}
    </script>
<!--    <script src='js/bootstrap.min.js' type='text/javascript'>-->
    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
</head>
<body>
<div class="container" style="padding-top:50px;">
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10"
             style="border:1px solid #CCCCCC;border: solid 1px gainsboro; transition: box-shadow 0.3s, border 0.3s; box-shadow: 0 0 5px 1px #969696;">
            <h2 align="center">List Of Salesperson</h2>
            <div class="row">
                <div class="col-md-13" align="center"><a href="salesperson_register.php"> <input type="button" value="Add salesperson"
                                                                                 class="btn btn-primary"></a></div>
            </div>
            <div>
                <div class="row" style="padding-top:20px;">
                    <div class="col-md-1"></div>
                    <div class="col-md-10">
                        <div id="no-more-tables" style="padding-top:20px;">
                            <table id="example" class="table-bordered table-striped " style="border-collapse:collapse">
                                <thead>
                                <tr style="background-color:#999999;color:#FFFFFF;">
                                    <th>Sr. No.</th>
                                    <th>Name</th>
                                    <th>Email ID</th>
                                    <th>Phone No</th>
									<th>Map</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                    
                                </tr>
                                </thead>
                                <?php $i = 1;
                                $sql = mysql_query("SELECT * FROM `tbl_salesperson` order by person_id desc");
                                while ($result = mysql_fetch_array($sql)) {
                                    ?>
                                    <tr>
                                        <td data-title="Sr.No."><?php echo $i; ?></td>
                                        <td data-title="Name"><?php echo ucwords($result['p_name']); ?></td>
                                        <td data-title="Email ID"><?php echo $result['p_email']; ?></td>
                                        <td data-title="Phone No"><?php echo $result['p_phone']; ?></td>
                                       <td data-title="Map">
                                            <a href="salesperson_map_tracker.php?salesperson_id=<?php echo $result['person_id']; ?>"
                                               value="<?php echo $rows['id'] ?>">
                                                <span class="glyphicon glyphicon-map-marker"></span> Map
                                            </a>
                                            </a>
                                            </a>
                                        </td>
									   <td data-title="Edit">
                                            <a href="edit_salesperson.php?Edit_id=<?php echo $result['person_id']; ?>"
                                               class="confirm" value="<?php echo $rows['id'] ?>">
                                                <span class="glyphicon glyphicon-pencil"></span></a>
                                            </a>
                                        </td>
                                        <td data-title="Delete" width="10%" align="center"><a style="text-decoration:none" onClick="confirmation(<?php echo $result['person_id']; ?> )"<span class="glyphicon glyphicon-trash"></span></a></td>
                                            
                                               
                                            </a>
                                            </a>
                                        </td>
                                        

                                    </tr>
                                    <?php $i++;
                                } ?>

                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
