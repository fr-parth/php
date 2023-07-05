<?php 
//print_r($schoolinfo);

$this->load->view('scadmin_header',$schoolinfo);

?>

<!DOCTYPE html>
<html lang="en">
<head><title>Distribute Green Points</title>
    
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
                    <li><i class="fa fa-home"></i>&nbsp;<a href="members">Points</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                    <li class="active"><a href="#">Distribution Points</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                    <li class="active">Green Points</li>
                </ol>
                <div class="clearfix"></div>
            </div>
        <!--END SIDEBAR MENU--><!--BEGIN CHAT FORM-->
   <div id="area-chart-spline" style="width: 100%; height:300px;display:none;"></div>
   
 
   
                                        
                   
              <div class="panel panel-yellow">
                          
                            <div class="panel-body">
                                <div id="no-more-tables">
                                  <form method="post" action="green_points">
                                    <table class="table table-bordered table-striped table-condensed cf" id="example">
                                        <thead class="cf">
                                        <tr>
                                            <th>Sr.No.</th>
                                           
                                            <th >Teacher Name</th>
                                           
                                             <th >Balance Points</th>
                                             <th></th>
                                           
                                           
                                        </tr>
                                        </thead>
                                        <tbody>
                                      
                                            <?php 
											//echo form_open('main/green_points');
                                            $i=1;
                                            foreach($teacherinfo as $t) {?>
                                        <tr>
                                       
                                         <td data-title="Check"><input type="checkbox" name="check" value="<?php echo $t->t_id;?>"></td>
                                            <td data-title="Sr.No"><?php echo $i;?></td>
                                            
                                            <td data-title="Name" ><?php
											 if($t->t_complete_name=="")
											{
												 $name=$t->t_name." ".$t->t_lastname; 
												 echo $name;
												 
												 } 
												 else
												 {
													 
												 echo $t->t_complete_name;
												 
												 }
												 
												 
												 
												 ?></td>
                                            <td data-title="Name" ><?php echo $t-> tc_balance_point ;?></td>
                                         
                                           
                                        </tr>
                                      <?php $i++;}
									  
									 
									  
									  ?>
                                      
                                        </tbody>
                                    </table>
                                   <div ><input type="submit" name="submit" class="btn btn-success">
                              </div>
                              
                              
                              </form>
                              
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