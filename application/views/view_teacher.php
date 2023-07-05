<?php 
//print_r($schoolinfo);

$this->load->view('scadmin_header',$schoolinfo);

?>

<!DOCTYPE html>
<html lang="en">
<head><title>Dashboard | Dashboard</title>
    
    <script>
	$(document).ready(function() {

    $('#example').DataTable();
} );
</script>
        
</head>
<body>

    <!--END THEME SETTING-->
    <div id="page-wrapper"><!--BEGIN SIDEBAR MENU-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
                <div class="page-header pull-left">
                    <div class="page-title">Teacher List</div>
                </div>
                <ol class="breadcrumb page-breadcrumb pull-right">
                    <li><i class="fa fa-home"></i>&nbsp;<a href="members">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                    <li class="active"><a href="#">Masters</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                    <li class="active">Teacher</li>
                </ol>
                <div class="clearfix"></div>
            </div>
        <!--END SIDEBAR MENU--><!--BEGIN CHAT FORM-->
   <div id="area-chart-spline" style="width: 100%; height:300px;display:none;"></div>
   
   <div style="padding-left:87%;" > <a href="addteacher" style="text-decoration:none;"><button type="submit" class="btn btn-green">Add Teacher</button></a></div>
   
                                        
                   
              <div class="panel panel-yellow">
                          
                            <div class="panel-body">
                                <div id="no-more-tables">
                                    <table class="table table-bordered table-striped table-condensed cf" id="example">
                                        <thead class="cf">
                                        <tr>
                                            <th>Sr.No.</th>
                                            <th>Profile Picture</th>
                                            <th>Teacher ID</th>
                                            <th >Teacher Name</th>
                                            <th >Email ID</th>
                                            <th>Phone No.</th>
                                           
                                           
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $i=1;
                                            foreach($teacherinfo as $t) {?>
                                        <tr>
                                            <td data-title="Sr.No"><?php echo $i;?></td>
                                            <td data-title="Company"><?php if($t->t_pc=="")
                                            {?>
                    <img src="http://127.0.0.1/Reshma-smartcookie/images/avtar.png" alt="" class="img-circle" style="height:50px;">
                                            <?php }else
											{?>
												<img src= "<?php echo base_url()?><?php echo $t->t_pc?>" alt="" class="img-circle" style="height:50px; width:50px;">
											<?php }

                                            ;?></td>
                                            <td data-title="Price" class="numeric"><?php echo $t->t_id;?></td>
                                            <td data-title="Change" class="numeric"><?php echo $t->t_complete_name ;?></td>
                                            <td data-title="Change %" class="numeric"><?php echo $t->t_email;?></td>
                                            <td data-title="Open" class="numeric"><?php echo $t->t_phone;?></td>
                                           
                                        </tr>
                                      <?php $i++;}?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                   
                   
                   
                   
                   
                   
                   
                   
                   
                
            <!--END CONTENT--><!--BEGIN FOOTER-->
         <?php 


$this->load->view('footer');

?>
            </div>
            
           
</body>
</html>