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

<title><?php echo ($this->session->userdata('usertype')=='employee')?'Manager':'Teacher'; ?> List</title>
    

<body>

    <!--END THEME SETTING-->

   
        <!--END SIDEBAR MENU--><!--BEGIN CHAT FORM-->
   
     <div id="area-chart-spline" style="width: 100%; height:300px; display:none;"></div>
            <!--END TITLE & BREADCRUMB PAGE--><!--BEGIN CONTENT-->
          
          
           
             <div id="page-wrapper"><!--BEGIN TITLE & BREADCRUMB PAGE-->
            <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
                <div class="page-header pull-left">
                    <div class="page-title">Points Request to <?php echo ($this->session->userdata('usertype')=='employee')?'Manager':'Teacher'; ?></div>
                </div>
                <ol class="breadcrumb page-breadcrumb pull-right">
                    <li><i class="fa fa-home"></i>&nbsp;<a href="<?php echo base_url();?>/main/members">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                    <li><a href="#">Points</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                    <li class="active">Points Request to <?php echo ($this->session->userdata('usertype')=='employee')?'Manager':'Teacher'; ?> </li>
                </ol>
                <div class="clearfix"></div>
                
            </div>
            <!--END TITLE & BREADCRUMB PAGE--><!--BEGIN CONTENT-->
            <div class="page-content">
            <?php 

echo form_open("main/teacherlist_request","class=form-horizontal");?>
						
<?php
echo form_close();

	?>
                <div class="row">
                    <div class="col-lg-12">
                        <div id="generalTabContent" class="tab-content responsive" style="margin-top:4%;">
                            <div id="teacher" class="tab-pane fade in active">
                        
                                <div class="row">
<!--Department added by Pranali for SMC-4333 on 10-3-20 -->
                                  <div id="no-more-tables">
                                    <table class="table table-bordered table-hover " id="example" style="margin-left: 0px !important;">
                                        <thead class="cf">
                                        <tr>
                                          <th>Sr.No.</th>
                <th>Image</th>
                <th><?php echo ($this->session->userdata('usertype')=='employee')?'Manager':'Teacher'; ?> Name</th>
                <th>Department</th>
               <?php 
			   if($selectopt==2){
			   
			   ?> <th><?php echo ($this->session->userdata('usertype')=='employee')?'Project':'Subject'; ?> Name </th>
               
               <?php } ?>
                <th>Request</th>       
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
                                                $dept = $t['dept'];

                                            }
                                            else
                                            {
                                                    
                                                $img = base_url().'teacher_images/'.$t->t_pc;  
                                                    if($t->t_complete_name==''){
                                                        $teacher_name = $t->t_name.' '.$t->t_middlename.' '.$t->t_lastname;
                                                    }else
                                                    {
                                                        $teacher_name = $t->t_complete_name;
                                                    }
                                                    $teacher_id = $t->teacher_id;
                                                    $dept = $t->dept;
                                            }

                                                ?>
                                        <tr>
                                            <td data-title="Sr.No."><?php echo $i;?></td>
                                            <td data-title="Image"><img src="<?php echo $img; ?>" alt="" class="img-circle" style="height:50px;width:50px;"/></td> 
                                            <td data-title="Name" ><?php echo ucwords(strtolower( $teacher_name));?></td>
                                            <td data-title="Department"><?php echo $dept;?></td>
                                       
                                        <?php 
			   if($selectopt==2){
			   
			   ?> 
                                            <td data-title="Subject" > <?php echo $subjectName;?></td>
                                            
                                            <?php }?>
                                            
                                            <?php if($selectopt==2){?>
                                            <td><a href="send_requestteacher/<?php echo $teacher_id?>"><button type="button" class="btn btn-success">Send Request</button></a></td>
                                         
                                        <?php
											}
											else
											{?>
                                            
                                            
                                            	<?php 

											$flag=True;


											foreach($studentteacherrequset_info as $r)

											{

												if($r->stud_id2==$t->t_id)

												{

													$flag=False;?>
                                                     <td><button type="button" class="btn btn-success" disabled> Request Sent</button></td>

<?php
													break;

												}
													}

													if($flag)

													{?>
                                                    
                                                     <td><a href="teacherlist_request/<?php echo $t->t_id?>"><button type="button" class="btn btn-success">Send Request</button></a></td>

	
<?php
													}

													?>
												
										<?php	}
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