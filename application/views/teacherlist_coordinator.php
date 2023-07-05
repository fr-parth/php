<?php 
//print_r($schoolinfo);

$this->load->view('stud_header',$studentinfo);

?>

<!DOCTYPE html>
<html lang="en">
<head>
<script>
	
        $(document).ready(function() {
            $('#example').dataTable( {
		
				
         });
			
  
        } );
		
		
        </script>
</head>

<title>Teacher List</title>
    

<body>

    <!--END THEME SETTING-->

   
        <!--END SIDEBAR MENU--><!--BEGIN CHAT FORM-->
   
     <div id="area-chart-spline" style="width: 100%; height:300px; display:none;"></div>
            <!--END TITLE & BREADCRUMB PAGE--><!--BEGIN CONTENT-->
          			<?php //echo ($this->session->userdata('usertype')=='employee')?'Project':'Subject'; ?>
          
           
             <div id="page-wrapper"><!--BEGIN TITLE & BREADCRUMB PAGE-->
            <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
                <div class="page-header pull-left">
                    <div class="page-title">My <?php echo ($this->session->userdata('usertype')=='employee')?'Project':'Subject'; ?> and <?php echo ($this->session->userdata('usertype')=='employee')?'Manager':'Teacher'; ?></div>
                </div>
                <ol class="breadcrumb page-breadcrumb pull-right">
                    <li><i class="fa fa-home"></i>&nbsp;<a href="members">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                    <li><a href="#">Points</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                    <li class="active">My <?php echo ($this->session->userdata('usertype')=='employee')?'Projects':'Subjects'; ?> and <?php echo ($this->session->userdata('usertype')=='employee')?'Manager':'Teacher'; ?></li>
                </ol>
                <div class="clearfix"></div>
            </div>
            <!--END TITLE & BREADCRUMB PAGE--><!--BEGIN CONTENT-->
            <div class="page-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div id="generalTabContent" class="tab-content responsive" style="margin-top:4%;">
                            <div id="teacher" class="tab-pane fade in active">
                        
                                <div class="row">
                                    <?php 
                                    if(isset($report)){
                                     ?>
                                    <div class="alert alert-success alert-dismissible">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                       
                                    <?php echo $report; ?>  
                                                    
                                                        
                                    </div>
                                    <?php }?>
                                
                                  <div id="no-more-tables">
                                    <table class="table table-bordered table-hover " id="example" style="margin-left: 0px !important;">
                                        <thead class="cf">
                                        <tr>
                                          <th>Sr.No.</th>
                <th>Image</th>
				 <th><?php echo ($this->session->userdata('usertype')=='employee')?'Manager':'Teacher'; ?> ID</th>
                <th><?php echo ($this->session->userdata('usertype')=='employee')?'Manager':'Teacher'; ?> Name</th>
                <th><?php echo ($this->session->userdata('usertype')=='employee')?'Project':'Subject'; ?> Name </th>
                <th>Send Request</th>                                   
                                         
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $i=1;

                                            foreach($teacherlist as $t) {

                                            if($school_type=='organization')
                                            {                
                                                $img = $t['teacher_image'];  
                                                $teacher_name = $t['teacher_name'];
                                                $teacher_id = $t['teacher_id'];
                                                $id = $t['teacher_id'];

                                            }
                                            else
                                            {
                                                    
                                                $img = base_url().'teacher_images/'.$t->t_pc;  
                                                    if($t->t_complete_name=='')
                                                    {
                                                        $teacher_name = $t->t_name.' '.$t->t_middlename.' '.$t->t_lastname;
                                                    }else
                                                    {
                                                        $teacher_name = $t->t_complete_name;
                                                    }
                                                    $teacher_id = $t->teacher_id;
                                                   $id = $t->teacher_id;
                                            }

                                                ?>
                                        <tr><?php 
echo form_open("main/teacherlist_coordinator/","class=form-horizontal");?>
                                            <td data-title="Sr.No."><?php echo $i;?></td>
                                      
									       <td data-title=""><img src="<?php echo $img;?>" alt="" class="img-circle" style="height:50px;width:50px;"/></td>
                                           <td data-title="<?php echo ($this->session->userdata('usertype')=='employee')?'Manager':'Teacher'; ?> Id"><?php echo $teacher_id?>
                                           <input id="teacher_id" name="teacher_id" type="text" value="<?php echo $id; ?>" style="display:none;" /></td>
                                            <td data-title="Amount" ><?php echo ucwords(strtolower( $teacher_name));?></td>
                                            <td data-title="Generation Date" > <?php echo $subjectName;?></td>
											
                                            <td> 

											<?php 
											$flag=True;
											foreach($coordinator_request_info as $r)
											{
												if($r->stud_id2==$id)
												{
													$flag=False;
													if($r->flag=='P')
													{		
														echo"<label>Request Declined</label><br>";		
														echo form_submit('request', 'Send Request Again','class="btn 	btn-green"');
													}
													else if($r->flag=='Y')
													{
														echo form_submit('request', 'Request Accepted','class="btn btn-green" disabled');
													}
													else
													{
														echo"<label>Request Pending</label><br>";	
														echo form_submit('request', 'Send Request','class="btn btn-green"');
													}	
													break;
													
												}
												
													}
													if($flag)
													{
													echo form_submit('request', 'Send Request','class="btn btn-green"');
	
													}
													
													?>    </td>
                                         <?php

echo form_close();
	?>
                                           
                                        </tr>
                                      <?php $i++;}?>
                                        </tbody>
                                    </table>
									
                                </div>
                                
                                
                                </div>
                                </div>
                                    
                                </div>
                            </div>                                       
                                    </div>
                                </div>             
                
            <!--END CONTENT--><!--BEGIN FOOTER-->
            
           
        <!--END PAGE WRAPPER-->
                   
                  <?php 


$this->load->view('footer');

?>          
            <!--END CONTENT--><!--BEGIN FOOTER-->
         
            </div>         
</body>
</html>