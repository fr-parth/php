<?php
/**
 * Created by PhpStorm.
 * User: Bpsi-Rohit
 * Date: 9/28/2017
 * Time: 2:51 PM
 */
include("groupadminheader.php"); 
$GroupMemId   = $_SESSION['id']; 


?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Smartcookie :: Club list</title>
    <script src="/maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"></script>
    <script src="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css"></script>
    <script src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="bower_components/sweetalert2/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
    <script>
        $(document).ready(function() { 
            
            $('#example').DataTable();
            $(".edit").click(function() {
                var userID = $(this).attr('user-data');
               
                var $row = $(this).closest("tr");    // Find the row
                $('#user-id').val(userID);
                $('#admin_name').val($row.find(".admin_name").text());
                $('#Club_Name').val($row.find(".club_name").text());
                $('#Club_address').val($row.find(".club_address").text());
                $('#club_email').val($row.find(".club_email").text());
               // $('#Club_name').val($row.find(".admin_name").text());
            });
            
//            $("#editSchool").submit(function(e){ 
//                e.preventDefault();
//                
//                          $.ajax({
//                                 url:'updateSchoolGroupAdmin.php',
//                                 type:"POST",
//                                 data:new FormData(this), //this is formData
//                                 processData:false,
//                                 contentType:false,
//                                 cache:false,
//                                 async:false,
//                                  success: function(data){
//                                      alert(data);
//                                      //$('editSchool').unbind("submit").submit();  
//                                      $('#editSchool')[0].reset();
//                                      $("#myModal").modal('hide');
//                                       
//                               }
//                         });
//            });
            
        });
        
      
    </script>
     
   
</head>
<body>
<div class="container">
            <!-- Central Modal Medium Success -->
            <div  class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-notify modal-success" role="document">
                    <!--Content-->
                    <form method="post" action="updateSchoolGroupAdmin.php" id="editSchool">
                    <div class="modal-content">
                        <!--Header-->
                        <div class="modal-header" style="background-color: #e0ebeb">
                            <div class="float-right" style="text-align:right;">
                            <button  type="button" class="Close btn btn-danger btn-sm" data-dismiss="modal" style="color: black;"><span class="glyphicon glyphicon-remove"></span></button>
                            </div>
                                <b><h2 style="text-align: center;"><font face="verdana" color="#3d004d"><b>School Edit</b></font></h2></b>
                        </div>
                        <!--Body-->
                        <div class="modal-body"> 
                            <div class="text-center">
                                <div class="input-group">
                                    <span class="input-group-addon">Admin Name</span>
                                    <input id="admin_name" type="text" class="form-control" name="admin_name">
                                </div>
                            </div>

                            <div class="text-center" style="margin-top: 10px;">
                                <div class="input-group">
                                    <span class="input-group-addon" style="padding-left: 22px;">School Name</span>
                                    <input id="Club_Name" type="text" class="form-control" name="Club_Name"  >
                                </div>
                            </div>

                            <div class="text-center" style="margin-top: 10px;">
                                <div class="input-group text-center">
                                    <span class="input-group-addon " style="padding-left: 57px;text-align: left">Email</span>
                                    <input id="club_email" type="text" class="form-control" name="club_email">
                                </div>
                            </div>

                            <div class="text-center" style="margin-top: 10px;">
                                <div class="input-group">
                                    <span class="input-group-addon" style="padding-left: 42px;">Address</span>
                                    <input id="Club_address" type="text" class="form-control" name="Club_address">
                                </div>
                            </div>
                        </div>
                        <!--Footer-->
                        <div class=" modal-footer justify-content-center" style="text-align:center;">
                            <input type="hidden" id="user-id" name="user-id">
                            <input type="submit" id="submit" name="submit" class="btn btn-success" value="Update">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                    <!--/.Content-->
                    </form>        
                </div>
            </div> 
            <div class="page-header">
<!--
                <a href="addclub.php"  class="btn btn-info btn-lg">
                    <span class="glyphicon glyphicon-plus"></span>
                </a>
-->
    <b><h2 style="text-align: center;"><font face="verdana" color="#3d004d">School list</font></h2></b>
</div>
    <table id="example" class="table table-striped table-bordered" width="100%" cellspacing="0">
        <thead>
        <tr>
            <th>Sr.No</th>
            <th>School Name</th>
            <th>Admin Name</th>
            <th>Address</th>
            <th>Email</th>
            <th>Edit</th>
            
        </tr>
        </thead>
        <tbody>
        <?php
        $i=1;
        //$row=mysql_query("SELECT * FROM tbl_school_admin WHERE group_status='$GroupMemId'");    
        $row=mysql_query("SELECT * FROM tbl_school_admin WHERE group_member_id='$GroupMemId'");
        while($result=mysql_fetch_array($row)) {
            ?>
            <tr>
                <td ><?php echo $i;?></td>
                <td class="club_name"><?php echo $result['school_name']?></td>
                <td class="admin_name"><?php echo $result['name']?></td>
                <td class="club_address"><?php echo $result['address']?></td>
                <td class="club_email"><?php echo $result['email']?></td>
                <td><a class="edit btn btn-info btn-lg" user-data="<?php echo $result['id']?>" data-toggle="modal" data-target="#myModal">
                        <span class="glyphicon glyphicon-pencil"></span>
                    </a>
                </td>
<!--
                 <td> <a href="#"  class="btn btn-danger btn-lg" $('#delete').click(function() { >
                         <span class="glyphicon glyphicon-trash"></span>
                     </a>
                </td>
-->
            </tr>
            <?php
            $i++;
             }
           ?>
        </tbody>
    </table>
</div> 
</body>
</html>
