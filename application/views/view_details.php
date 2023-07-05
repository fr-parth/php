  <?php
     $this->load->view('scadmin_header',$school_admin); 
  ?>

   <!DOCTYPE html>
<html lang="en">

<head>


</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
      

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">List of Teachers</h1>
                </div>
               
            </div>
         
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                      
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                           <th>Sr.No.</th>
                                            <th>Teacher ID</th>
                                            <th>Teacher Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                         
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i=1; foreach($teacherinfo as $post) {?>
                                        <tr class="odd gradeX">
                                            <td><?php echo $i;?></td>
                                            <td><?php echo $post->t_id;?></td>
                                            <td><?php echo ucwords(strtolower( $post->t_complete_name));?></td>
                                             
                                             <td><?php echo $post->t_email;?></td>
                                              <td><?php echo $post->t_phone;?></td>
                                            
                                           
                                        </tr>

                                           
                                        <?php $i++;} ?>
                                        
                                        
                                    </tbody>
                                </table>
                            </div>
                            
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
       
          
              
                        
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-6 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
   
    <script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
                responsive: true
        });
    });
    </script>

</body>

</html>
